<?php
require_once APPPATH . 'libraries/AiBridge.php';

/**
 * AI Controller
 *
 * JSON endpoints for the CorpFile AI agent (drawer + full-page chat).
 */
class Ai extends BaseController {
    private function getClient() {
        if (!$this->db) {
            return null;
        }

        $clientCode = $_SESSION['client_id'] ?? '';
        if (!$clientCode) {
            return null;
        }

        return $this->db->fetchOne("SELECT * FROM clients WHERE client_id = ?", [$clientCode]);
    }

    private function getJsonInput() {
        $raw = file_get_contents('php://input');
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }

    /**
     * GET /ai/status — Check if AI backend is configured and reachable.
     */
    public function status() {
        $this->requireAuth();

        $bridge = new AiBridge();
        $status = $bridge->status();

        $this->json([
            'success' => true,
            'status'  => $status,
        ]);
    }

    /**
     * POST /ai/chat — Chat endpoint for both the AI drawer and the full-page chat.
     * Accepts { message, conversation_id?, source?, agent? }
     * Returns { ok, response_text, conversation_id, error }.
     */
    public function chat() {
        $this->requireAuth();

        if (strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->json(['ok' => false, 'error' => 'Method not allowed'], 405);
            return;
        }

        $payload = $this->getJsonInput();
        $message = trim((string) ($payload['message'] ?? ''));
        if ($message === '') {
            $this->json(['ok' => false, 'error' => 'Message is required']);
            return;
        }
        if (strlen($message) > 4000) {
            $message = substr($message, 0, 4000);
        }

        $conversationId = (int) ($payload['conversation_id'] ?? 0);
        $source = $payload['source'] ?? 'chat';
        $agent  = $payload['agent']  ?? null;
        $userId = (int) ($_SESSION['user_id'] ?? 1);

        // Resolve client DB id
        $clientDbId = 0;
        $client = $this->getClient();
        if ($client) {
            $clientDbId = (int) $client->id;
        }

        // Auto-create conversation if none provided
        if ($conversationId <= 0 && $this->db) {
            try {
                $title = mb_substr($message, 0, 80);
                $conversationId = (int) $this->db->insert('chat_conversations', [
                    'user_id'   => $userId,
                    'client_id' => $clientDbId,
                    'title'     => $title,
                    'agent'     => $agent,
                    'source'    => in_array($source, ['chat','drawer','agent']) ? $source : 'chat',
                ]);
            } catch (\Exception $e) {
                // Non-fatal — chat still works without persistence
                $conversationId = 0;
            }
        }

        // Save user message
        if ($conversationId > 0 && $this->db) {
            try {
                $this->db->insert('chat_messages', [
                    'conversation_id' => $conversationId,
                    'role'    => 'user',
                    'content' => $message,
                ]);
            } catch (\Exception $e) { /* non-fatal */ }
        }

        // Build conversation history for multi-turn context
        $history = [];
        if ($conversationId > 0 && $this->db) {
            try {
                $rows = $this->db->fetchAll(
                    "SELECT role, content FROM chat_messages
                     WHERE conversation_id = ?
                     ORDER BY id ASC
                     LIMIT 20",
                    [$conversationId]
                );
                foreach ($rows as $r) {
                    $history[] = ['role' => $r->role, 'content' => $r->content];
                }
            } catch (\Exception $e) { /* non-fatal */ }
        }

        // Build context: enrich the user message with workspace data when relevant
        $contextInfo = $this->buildContextSnippet($message);
        $enrichedMessage = $message;
        if ($contextInfo) {
            $enrichedMessage = $message . "\n\n---\n[Workspace context for this query]\n" . $contextInfo;
        }

        @set_time_limit(300);

        $bridge = new AiBridge();

        // If we have multi-turn history, pass it to the bridge
        $opts = [
            'max_tokens'  => 4096,
            'temperature' => 0.3,
            'timeout'     => 180,
        ];
        if (count($history) > 1) {
            // Replace the last user message with enriched version (with context)
            $history[count($history) - 1]['content'] = $enrichedMessage;
            $opts['messages'] = $history;
            $result = $bridge->runTurn(null, $opts);
        } else {
            $result = $bridge->runTurn($enrichedMessage, $opts);
        }

        if (empty($result['ok'])) {
            $this->json([
                'ok'              => false,
                'error'           => $result['error'] ?? 'AI agent is currently unavailable.',
                'response_text'   => null,
                'conversation_id' => $conversationId ?: null,
            ]);
            return;
        }

        // Save assistant response
        if ($conversationId > 0 && $this->db) {
            try {
                $usage = $result['usage'] ?? [];
                $this->db->insert('chat_messages', [
                    'conversation_id' => $conversationId,
                    'role'       => 'assistant',
                    'content'    => $result['response_text'],
                    'model'      => $result['model'] ?? null,
                    'tokens_in'  => $usage['input_tokens'] ?? null,
                    'tokens_out' => $usage['output_tokens'] ?? null,
                ]);
                // Update conversation timestamp
                $this->db->update('chat_conversations', [
                    'updated_at' => date('Y-m-d H:i:s'),
                ], 'id = ?', [$conversationId]);
            } catch (\Exception $e) { /* non-fatal */ }
        }

        $this->json([
            'ok'              => true,
            'response_text'   => $result['response_text'],
            'conversation_id' => $conversationId ?: null,
            'model'           => $result['model'] ?? null,
            'provider'        => $result['provider'] ?? null,
            'usage'           => $result['usage'] ?? null,
        ]);
    }

    /* ================================================================
     * Chat History API
     * ================================================================ */

    /**
     * GET /ai/conversations — List conversations for the current user.
     */
    public function conversations() {
        $this->requireAuth();

        if (!$this->db) {
            $this->json(['ok' => true, 'conversations' => []]);
            return;
        }

        $userId = (int) ($_SESSION['user_id'] ?? 1);
        $source = $_GET['source'] ?? null;

        try {
            $sql = "SELECT c.id, c.title, c.agent, c.source, c.created_at, c.updated_at,
                           (SELECT COUNT(*) FROM chat_messages WHERE conversation_id = c.id) as msg_count
                    FROM chat_conversations c
                    WHERE c.user_id = ?";
            $params = [$userId];

            if ($source) {
                $sql .= " AND c.source = ?";
                $params[] = $source;
            }

            $sql .= " ORDER BY c.updated_at DESC LIMIT 50";

            $rows = $this->db->fetchAll($sql, $params);
            $conversations = [];
            foreach ($rows as $r) {
                $conversations[] = [
                    'id'         => (int) $r->id,
                    'title'      => $r->title,
                    'agent'      => $r->agent,
                    'source'     => $r->source,
                    'msg_count'  => (int) $r->msg_count,
                    'created_at' => $r->created_at,
                    'updated_at' => $r->updated_at,
                ];
            }

            $this->json(['ok' => true, 'conversations' => $conversations]);
        } catch (\Exception $e) {
            $this->json(['ok' => true, 'conversations' => []]);
        }
    }

    /**
     * GET /ai/conversation?id=123 — Load messages for a conversation.
     */
    public function conversation() {
        $this->requireAuth();

        $id = (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            $this->json(['ok' => false, 'error' => 'Invalid conversation ID']);
            return;
        }

        if (!$this->db) {
            $this->json(['ok' => false, 'error' => 'Database unavailable']);
            return;
        }

        $userId = (int) ($_SESSION['user_id'] ?? 1);

        try {
            // Verify ownership
            $conv = $this->db->fetchOne(
                "SELECT * FROM chat_conversations WHERE id = ? AND user_id = ?",
                [$id, $userId]
            );
            if (!$conv) {
                $this->json(['ok' => false, 'error' => 'Conversation not found']);
                return;
            }

            $messages = $this->db->fetchAll(
                "SELECT id, role, content, model, created_at
                 FROM chat_messages
                 WHERE conversation_id = ?
                 ORDER BY id ASC",
                [$id]
            );

            $msgs = [];
            foreach ($messages as $m) {
                $msgs[] = [
                    'id'         => (int) $m->id,
                    'role'       => $m->role,
                    'content'    => $m->content,
                    'model'      => $m->model,
                    'created_at' => $m->created_at,
                ];
            }

            $this->json([
                'ok'       => true,
                'conversation' => [
                    'id'    => (int) $conv->id,
                    'title' => $conv->title,
                    'agent' => $conv->agent,
                    'source' => $conv->source,
                ],
                'messages' => $msgs,
            ]);
        } catch (\Exception $e) {
            $this->json(['ok' => false, 'error' => 'Failed to load conversation']);
        }
    }

    /**
     * POST /ai/deleteConversation — Delete a conversation.
     * Accepts { id: int }
     */
    public function deleteConversation() {
        $this->requireAuth();

        if (strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->json(['ok' => false, 'error' => 'Method not allowed'], 405);
            return;
        }

        $payload = $this->getJsonInput();
        $id = (int) ($payload['id'] ?? 0);
        if ($id <= 0) {
            $this->json(['ok' => false, 'error' => 'Invalid conversation ID']);
            return;
        }

        if (!$this->db) {
            $this->json(['ok' => false, 'error' => 'Database unavailable']);
            return;
        }

        $userId = (int) ($_SESSION['user_id'] ?? 1);

        try {
            // Verify ownership before delete
            $conv = $this->db->fetchOne(
                "SELECT id FROM chat_conversations WHERE id = ? AND user_id = ?",
                [$id, $userId]
            );
            if (!$conv) {
                $this->json(['ok' => false, 'error' => 'Conversation not found']);
                return;
            }

            $this->db->delete('chat_conversations', 'id = ?', [$id]);
            $this->json(['ok' => true]);
        } catch (\Exception $e) {
            $this->json(['ok' => false, 'error' => 'Failed to delete conversation']);
        }
    }

    /**
     * POST /ai/run — Legacy endpoint for the IR8A agent workflow.
     * Kept for backward compatibility.
     */
    public function run() {
        $this->requireAuth();

        if (strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->json(['success' => false, 'message' => 'Method not allowed'], 405);
            return;
        }

        $payload = $this->getJsonInput();

        $message = trim((string) ($payload['message'] ?? $_POST['message'] ?? ''));
        if ($message === '') {
            $this->json(['success' => false, 'message' => 'Prompt is required'], 422);
            return;
        }
        if (strlen($message) > 4000) {
            $message = substr($message, 0, 4000);
        }

        $contextInfo = $this->buildContextSnippet($message);
        $enrichedMessage = $message;
        if ($contextInfo) {
            $enrichedMessage = $message . "\n\n---\n[Workspace context]\n" . $contextInfo;
        }

        @set_time_limit(180);

        $bridge = new AiBridge();
        $result = $bridge->runTurn($enrichedMessage, [
            'max_tokens'  => 3000,
            'temperature' => 0.3,
            'timeout'     => 120,
        ]);

        if (empty($result['ok'])) {
            $this->json([
                'success' => false,
                'message' => $result['error'] ?? 'AI agent run failed.',
                'meta'    => ['provider' => $result['provider'] ?? null],
            ], 502);
            return;
        }

        $this->json([
            'success' => true,
            'reply'   => $result['response_text'],
            'meta'    => [
                'model'    => $result['model'] ?? null,
                'provider' => $result['provider'] ?? null,
                'usage'    => $result['usage'] ?? null,
            ],
        ]);
    }

    /**
     * Build comprehensive context from the database for the AI agent.
     * Wrapped in try-catch so DB errors never crash the AI endpoint.
     */
    private function buildContextSnippet($message) {
        try {
            return $this->doBuildContext($message);
        } catch (\Exception $e) {
            return "Context lookup error: " . $e->getMessage();
        }
    }

    /**
     * Smart SQL RAG: analyze the user's question, only query relevant data.
     * Keeps context to ~2-5K tokens instead of 41K, so Claude responds in 5-15s not 60s.
     */
    private function doBuildContext($message) {
        $client = $this->getClient();
        if (!$client) {
            return null;
        }

        $lines = [];
        $msg = strtolower($message);
        $today = date('Y-m-d');

        // ════════════════════════════════════════
        // ALWAYS: lightweight summary (~200 tokens)
        // ════════════════════════════════════════
        $companyCount = (int) $this->db->count('companies', 'client_id = ?', [$client->id]);
        $lines[] = "=== CORPFILE DATABASE (live data) ===";
        $lines[] = "Client: {$client->company_name} (Code: {$client->client_id}) | Today: {$today}";
        $lines[] = "Total companies: {$companyCount}";

        try {
            $statusSummary = $this->db->fetchAll(
                "SELECT COALESCE(entity_status, 'Unknown') AS status, COUNT(*) AS cnt
                 FROM companies WHERE client_id = ? GROUP BY entity_status ORDER BY cnt DESC",
                [$client->id]
            );
            if ($statusSummary) {
                $parts = [];
                foreach ($statusSummary as $s) $parts[] = "{$s->status}: {$s->cnt}";
                $lines[] = "Status breakdown: " . implode(' | ', $parts);
            }
        } catch (\Exception $e) {}

        // ════════════════════════════════════════
        // SMART ROUTING: detect intent → query only what's needed
        // ════════════════════════════════════════

        $needCompanyList   = (bool) preg_match('/compan|list|all|portfolio|清单|公司|列表|search|find|how many|总共|几家/i', $msg);
        $needDirectors     = (bool) preg_match('/director|board|appoint|resign|cessation|officer|董事|任命/i', $msg);
        $needShareholders  = (bool) preg_match('/sharehold|equity|shares|stock|investor|股东|股份/i', $msg);
        $needSecretaries   = (bool) preg_match('/secretar|company sec|秘书/i', $msg);
        $needDeadlines     = (bool) preg_match('/deadline|due|compliance|agm|annual|overdue|fye|filing|ar |合规|到期|逾期|截止/i', $msg);
        $needDocuments     = (bool) preg_match('/document|file|upload|ir8a|tax|payroll|doc|文件|文档/i', $msg);
        $needInvoices      = (bool) preg_match('/invoice|bill|fee|payment|billing|发票|账单|费用/i', $msg);
        $needMembers       = (bool) preg_match('/member|individual|person|people|kyc|成员|个人/i', $msg);
        $needRecent        = (bool) preg_match('/recent|new|register|incorporat|past|latest|最近|新注册|成立/i', $msg);

        // Detect specific company name mention
        $specificCompany = $this->findMentionedCompany($msg, $client->id);

        // If nothing specific matched, give a compact company overview
        if (!$needCompanyList && !$needDirectors && !$needShareholders && !$needSecretaries
            && !$needDeadlines && !$needDocuments && !$needInvoices && !$needMembers
            && !$needRecent && !$specificCompany) {
            $needCompanyList = true; // default: show company summary
        }

        // ── Company list (compact) ──
        if ($needCompanyList && !$specificCompany) {
            try {
                $limit = 50;
                $companies = $this->db->fetchAll(
                    "SELECT c.company_name, c.registration_number, c.incorporation_date,
                            c.entity_status, c.internal_css_status, c.fye_date
                     FROM companies c
                     WHERE c.client_id = ?
                     ORDER BY c.company_name ASC
                     LIMIT {$limit}",
                    [$client->id]
                );
                if ($companies) {
                    $lines[] = "\n--- Companies (first {$limit} of {$companyCount}) ---";
                    foreach ($companies as $co) {
                        $lines[] = "- {$co->company_name} | " . ($co->registration_number ?: '-')
                            . " | Incorp: " . ($co->incorporation_date ?: '-')
                            . " | {$co->entity_status}";
                    }
                }
            } catch (\Exception $e) {}
        }

        // ── Recent incorporations ──
        if ($needRecent) {
            try {
                $months = 3;
                if (preg_match('/(\d+)\s*(?:month|个月)/i', $msg, $m)) $months = min((int)$m[1], 24);
                $sinceDate = date('Y-m-d', strtotime("-{$months} months"));

                $recent = $this->db->fetchAll(
                    "SELECT company_name, registration_number, incorporation_date, entity_status, internal_css_status
                     FROM companies WHERE client_id = ? AND incorporation_date >= ?
                     ORDER BY incorporation_date DESC LIMIT 30",
                    [$client->id, $sinceDate]
                );
                $lines[] = "\n--- Companies incorporated since {$sinceDate} (" . count($recent) . " found) ---";
                foreach ($recent as $co) {
                    $lines[] = "- {$co->company_name} | " . ($co->registration_number ?: '-')
                        . " | Incorp: {$co->incorporation_date} | {$co->entity_status}";
                }
            } catch (\Exception $e) {}
        }

        // ── Directors ──
        if ($needDirectors) {
            try {
                // Check if asking about specific director count
                $havingClause = '';
                $params = [$client->id];
                if (preg_match('/(\d+)\s*(?:director|董事)/i', $msg, $dm)) {
                    $havingClause = " HAVING dir_count = ?";
                    $params[] = (int)$dm[1];
                }

                $dirQuery = "SELECT c.company_name, c.registration_number, COUNT(d.id) AS dir_count,
                                    GROUP_CONCAT(CONCAT(d.name, ' (', COALESCE(d.nationality,''), ')') ORDER BY d.name SEPARATOR '; ') AS directors
                             FROM companies c
                             LEFT JOIN directors d ON d.company_id = c.id
                             WHERE c.client_id = ?
                             GROUP BY c.id, c.company_name, c.registration_number{$havingClause}
                             ORDER BY dir_count DESC
                             LIMIT 50";
                $dirData = $this->db->fetchAll($dirQuery, $params);
                if ($dirData) {
                    $lines[] = "\n--- Companies & Directors (" . count($dirData) . " companies) ---";
                    foreach ($dirData as $co) {
                        $lines[] = "- {$co->company_name} | " . ($co->registration_number ?: '-')
                            . " | Directors({$co->dir_count}): " . ($co->directors ?: 'none');
                    }
                }
            } catch (\Exception $e) {}
        }

        // ── Shareholders ──
        if ($needShareholders) {
            try {
                $shData = $this->db->fetchAll(
                    "SELECT c.company_name, s.name, s.shareholder_type, s.nationality, s.date_of_appointment, s.status
                     FROM shareholders s
                     JOIN companies c ON c.id = s.company_id
                     WHERE c.client_id = ?
                     ORDER BY c.company_name, s.name LIMIT 100",
                    [$client->id]
                );
                if ($shData) {
                    $lines[] = "\n--- Shareholders (" . count($shData) . ") ---";
                    foreach ($shData as $s) {
                        $lines[] = "- {$s->company_name} | {$s->name} | {$s->shareholder_type} | " . ($s->nationality ?: '-');
                    }
                }
            } catch (\Exception $e) {}
        }

        // ── Secretaries ──
        if ($needSecretaries) {
            try {
                $secData = $this->db->fetchAll(
                    "SELECT c.company_name, s.name, s.date_of_appointment, s.date_of_cessation, s.status
                     FROM secretaries s
                     JOIN companies c ON c.id = s.company_id
                     WHERE c.client_id = ?
                     ORDER BY c.company_name, s.name LIMIT 100",
                    [$client->id]
                );
                if ($secData) {
                    $lines[] = "\n--- Secretaries (" . count($secData) . ") ---";
                    foreach ($secData as $s) {
                        $lines[] = "- {$s->company_name} | {$s->name} | Appointed: " . ($s->date_of_appointment ?: '-')
                            . " | " . ($s->date_of_cessation ? "Ceased: {$s->date_of_cessation}" : 'Current');
                    }
                }
            } catch (\Exception $e) {}
        }

        // ── Deadlines ──
        if ($needDeadlines) {
            try {
                $deadlines = $this->db->fetchAll(
                    "SELECT COALESCE(c.company_name, d.company_name, 'N/A') AS company_name,
                            d.event_name, d.due_date, d.status, d.pic
                     FROM due_dates d
                     LEFT JOIN companies c ON c.id = d.company_id
                     WHERE d.client_id = ?
                     ORDER BY COALESCE(d.due_date, '9999-12-31') ASC LIMIT 30",
                    [$client->id]
                );
                if ($deadlines) {
                    $lines[] = "\n--- Deadlines (" . count($deadlines) . ") ---";
                    foreach ($deadlines as $d) {
                        $daysLeft = '';
                        if ($d->due_date) {
                            $diff = (int) (new \DateTimeImmutable('today'))->diff(new \DateTimeImmutable($d->due_date))->format('%r%a');
                            $daysLeft = $diff < 0 ? " [OVERDUE " . abs($diff) . "d]" : " [{$diff}d left]";
                        }
                        $lines[] = "- {$d->company_name} | {$d->event_name} | " . ($d->due_date ?: '-') . $daysLeft
                            . " | " . ($d->status ?: 'Pending');
                    }
                }
            } catch (\Exception $e) {}
        }

        // ── Documents ──
        if ($needDocuments) {
            try {
                $docs = $this->db->fetchAll(
                    "SELECT d.document_name, d.created_at,
                            COALESCE(c.company_name, 'General') AS company_name
                     FROM documents d
                     LEFT JOIN companies c ON c.id = d.entity_id AND d.entity_type = 'company'
                     WHERE d.client_id = ? ORDER BY d.created_at DESC LIMIT 20",
                    [$client->id]
                );
                if ($docs) {
                    $lines[] = "\n--- Recent Documents (" . count($docs) . ") ---";
                    foreach ($docs as $doc) {
                        $lines[] = "- {$doc->document_name} | {$doc->company_name} | " . ($doc->created_at ?: '-');
                    }
                }
            } catch (\Exception $e) {}
        }

        // ── Invoices ──
        if ($needInvoices) {
            try {
                $invoiceCount = (int) $this->db->count('invoices', 'client_id = ?', [$client->id]);
                $lines[] = "\nTotal invoices: {$invoiceCount}";
            } catch (\Exception $e) {}
        }

        // ── Members / individuals ──
        if ($needMembers) {
            try {
                $members = $this->db->fetchAll(
                    "SELECT m.name, m.nationality, m.status, m.email
                     FROM members m WHERE m.client_id = ?
                     ORDER BY m.name ASC LIMIT 100",
                    [$client->id]
                );
                if ($members) {
                    $lines[] = "\n--- Individuals/Members (" . count($members) . ") ---";
                    foreach ($members as $m) {
                        $lines[] = "- {$m->name} | " . ($m->nationality ?: '-') . " | " . ($m->status ?: '-');
                    }
                }
            } catch (\Exception $e) {}
        }

        // ════════════════════════════════════════
        // SPECIFIC COMPANY DEEP DIVE
        // ════════════════════════════════════════
        if ($specificCompany) {
            $cid = $specificCompany->id;
            $lines[] = "\n--- DETAILED: {$specificCompany->company_name} ---";

            // Company fields
            $detail = $this->db->fetchOne("SELECT * FROM companies WHERE id = ?", [$cid]);
            if ($detail) {
                $fields = [
                    'registration_number', 'acra_registration_number', 'incorporation_date',
                    'entity_status', 'internal_css_status', 'fye_date', 'email', 'website',
                    'phone1_number', 'activity_1', 'activity_1_desc_default', 'country',
                    'paid_up_capital', 'ord_currency', 'contact_person'
                ];
                foreach ($fields as $f) {
                    if (!empty($detail->$f)) {
                        $label = ucwords(str_replace('_', ' ', $f));
                        $lines[] = "  {$label}: {$detail->$f}";
                    }
                }
            }

            // Directors
            try {
                $dirs = $this->db->fetchAll(
                    "SELECT name, id_number, nationality, role, appointment_date, cessation_date
                     FROM directors WHERE company_id = ? ORDER BY name", [$cid]);
                if ($dirs) {
                    $lines[] = "  Directors (" . count($dirs) . "):";
                    foreach ($dirs as $d) {
                        $lines[] = "    - {$d->name} | {$d->nationality} | {$d->role} | Since: " . ($d->appointment_date ?: '-')
                            . ($d->cessation_date ? " | Ceased: {$d->cessation_date}" : '');
                    }
                }
            } catch (\Exception $e) {}

            // Shareholders
            try {
                $shares = $this->db->fetchAll(
                    "SELECT name, shareholder_type, nationality, date_of_appointment, status
                     FROM shareholders WHERE company_id = ? ORDER BY name", [$cid]);
                if ($shares) {
                    $lines[] = "  Shareholders (" . count($shares) . "):";
                    foreach ($shares as $s) {
                        $lines[] = "    - {$s->name} | {$s->shareholder_type} | " . ($s->nationality ?: '-');
                    }
                }
            } catch (\Exception $e) {}

            // Secretaries
            try {
                $secs = $this->db->fetchAll(
                    "SELECT name, date_of_appointment, date_of_cessation
                     FROM secretaries WHERE company_id = ? ORDER BY name", [$cid]);
                if ($secs) {
                    $lines[] = "  Secretaries (" . count($secs) . "):";
                    foreach ($secs as $s) {
                        $lines[] = "    - {$s->name} | Since: " . ($s->date_of_appointment ?: '-');
                    }
                }
            } catch (\Exception $e) {}

            // Addresses
            try {
                $addrs = $this->db->fetchAll(
                    "SELECT address_type, CONCAT_WS(', ', block, address_text, building, postal_code) AS full_address
                     FROM addresses WHERE entity_type = 'company' AND entity_id = ? LIMIT 5", [$cid]);
                if ($addrs) {
                    $lines[] = "  Addresses:";
                    foreach ($addrs as $a) {
                        $lines[] = "    - " . ($a->address_type ?: 'Address') . ": {$a->full_address}";
                    }
                }
            } catch (\Exception $e) {}

            // Due dates
            try {
                $dues = $this->db->fetchAll(
                    "SELECT event_name, due_date, status FROM due_dates
                     WHERE company_id = ? ORDER BY due_date ASC LIMIT 10", [$cid]);
                if ($dues) {
                    $lines[] = "  Due Dates:";
                    foreach ($dues as $d) {
                        $lines[] = "    - {$d->event_name} | Due: " . ($d->due_date ?: '-') . " | " . ($d->status ?: 'Pending');
                    }
                }
            } catch (\Exception $e) {}
        }

        $lines[] = "\n=== END ===";
        $lines[] = "IMPORTANT: This is REAL live data. Present it directly. Do NOT say you cannot access the database.";

        return implode("\n", $lines);
    }

    /**
     * Try to match a company name mentioned in the user's message.
     */
    private function findMentionedCompany($msg, $clientId) {
        try {
            $companies = $this->db->fetchAll(
                "SELECT id, company_name FROM companies WHERE client_id = ? ORDER BY LENGTH(company_name) DESC",
                [$clientId]
            );
            foreach ($companies as $co) {
                // Exact match (case-insensitive)
                if (stripos($msg, strtolower($co->company_name)) !== false) {
                    return $co;
                }
                // Partial match: first two significant words (skip PTE/LTD etc)
                $words = preg_split('/\s+/', $co->company_name);
                $significant = array_filter($words, function($w) {
                    return !in_array(strtoupper($w), ['PTE', 'PTE.', 'LTD', 'LTD.', 'PRIVATE', 'LIMITED', 'INC', 'CORP', 'CO.', 'CO']);
                });
                $significant = array_values($significant);
                if (count($significant) >= 2) {
                    $partial = strtolower($significant[0] . ' ' . $significant[1]);
                    if (strlen($partial) > 5 && stripos($msg, $partial) !== false) {
                        return $co;
                    }
                } elseif (count($significant) === 1 && strlen($significant[0]) > 4) {
                    if (stripos($msg, strtolower($significant[0])) !== false) {
                        return $co;
                    }
                }
            }
        } catch (\Exception $e) {}
        return null;
    }
}
