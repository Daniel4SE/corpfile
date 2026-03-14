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
        $model  = $payload['model']  ?? null;
        $attachments = $payload['attachments'] ?? []; // Array of { name, type, data }
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

        // ── Process file attachments ──
        $imageBlocks = [];  // For Claude vision (image content blocks)
        $textAttachments = ''; // Text content from files (prepended to message)

        if (!empty($attachments) && is_array($attachments)) {
            foreach ($attachments as $att) {
                $name = $att['name'] ?? 'file';
                $type = $att['type'] ?? '';
                $data = $att['data'] ?? '';
                if (empty($data)) continue;

                // Image files: send as Claude vision image blocks
                if (preg_match('/^image\/(jpeg|png|gif|webp)$/i', $type)) {
                    // data is base64 (may have data:image/...;base64, prefix)
                    $base64 = $data;
                    if (strpos($data, 'base64,') !== false) {
                        $base64 = substr($data, strpos($data, 'base64,') + 7);
                    }
                    // Limit image size (~5MB base64)
                    if (strlen($base64) < 7000000) {
                        $mediaType = strtolower($type);
                        $imageBlocks[] = [
                            'type' => 'image',
                            'source' => [
                                'type' => 'base64',
                                'media_type' => $mediaType,
                                'data' => $base64,
                            ],
                        ];
                    }
                }
                // PDF files: extract text from base64 PDF using Claude's built-in PDF support
                elseif ($type === 'application/pdf' || strtolower(pathinfo($name, PATHINFO_EXTENSION)) === 'pdf') {
                    $base64 = $data;
                    if (strpos($data, 'base64,') !== false) {
                        $base64 = substr($data, strpos($data, 'base64,') + 7);
                    }
                    // Claude supports PDF as document type (up to ~30MB)
                    if (strlen($base64) < 40000000) {
                        $imageBlocks[] = [
                            'type' => 'document',
                            'source' => [
                                'type' => 'base64',
                                'media_type' => 'application/pdf',
                                'data' => $base64,
                            ],
                        ];
                    }
                }
                // Text-like files: include content directly in message
                else {
                    $content = $data;
                    // If it looks like base64 data URL, decode it
                    if (strpos($data, 'base64,') !== false) {
                        $content = base64_decode(substr($data, strpos($data, 'base64,') + 7));
                    }
                    // Limit text content to 50KB
                    if (strlen($content) > 50000) {
                        $content = substr($content, 0, 50000) . "\n... [truncated]";
                    }
                    $textAttachments .= "\n\n---\n[File: {$name}]\n{$content}\n";
                }
            }
        }

        // Append text file content to message
        if ($textAttachments) {
            $message .= $textAttachments;
        }

        // Build context: enrich the user message with workspace data when relevant
        $contextInfo = $this->buildContextSnippet($message);
        $enrichedMessage = $message;
        if ($contextInfo) {
            $enrichedMessage = $message . "\n\n---\n[Workspace context for this query]\n" . $contextInfo;
        }

        @set_time_limit(300);

        // Agent-specific system prompts
        $agentPrompts = $this->getAgentSystemPrompts();
        $bridgeOpts = [];
        if ($agent && isset($agentPrompts[$agent])) {
            $bridgeOpts['system_prompt'] = $agentPrompts[$agent];
        }

        $bridge = new AiBridge($bridgeOpts);

        // If we have multi-turn history, pass it to the bridge
        $opts = [
            'max_tokens'  => 4096,
            'temperature' => 0.3,
            'timeout'     => 180,
        ];
        // Pass per-request model override if provided
        if ($model) {
            $opts['model'] = $model;
        }

        // Build the final user content (may include image/document blocks for Claude vision)
        $userContent = $enrichedMessage;
        if (!empty($imageBlocks)) {
            // Multi-modal: content is an array of blocks
            $contentBlocks = [];
            foreach ($imageBlocks as $block) {
                $contentBlocks[] = $block;
            }
            $contentBlocks[] = ['type' => 'text', 'text' => $enrichedMessage];
            $userContent = $contentBlocks;
        }

        if (count($history) > 1) {
            // Replace the last user message with enriched version (with context + files)
            $history[count($history) - 1]['content'] = $userContent;
            $opts['messages'] = $history;
            $result = $bridge->runTurn(null, $opts);
        } else {
            $result = $bridge->runTurn($userContent, $opts);
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

    /**
     * Agent-specific system prompts for specialized behavior.
     */
    private function getAgentSystemPrompts() {
        $base = <<<'BASE'
You are CorpFile AI, an intelligent assistant embedded in CorpFile, a corporate secretarial management platform used in Singapore.

Guidelines:
- Be concise, professional, and action-oriented
- Use structured formatting: headers, bullet points, numbered steps
- When discussing Singapore regulations, cite the Companies Act (Cap. 50) or relevant ACRA/IRAS guidelines
- Never fabricate company data, filing numbers, or regulatory references
- If you don't have enough information, ask clarifying questions
BASE;

        return [
            'compliance' => $base . "\n\n" . <<<'AGENT'
You are the **Company Registration** agent — a specialist in Singapore company incorporation and corporate compliance.

Your focus areas:
- AGM (Annual General Meeting) deadlines and extensions under Section 175 of the Companies Act
- Annual Return (AR) filing with ACRA via BizFile+
- Financial Year End (FYE) changes and implications
- Company striking off, dormancy, and restoration procedures
- Director and secretary appointment/cessation compliance (Section 145, 171)
- Exempt Private Company (EPC) exemptions
- XBRL financial statement filing requirements
- Common Seal and Constitution compliance

When reviewing compliance:
1. Check if AGM is due (within 6 months of FYE for private companies, 4 months for listed)
2. Check if AR is filed (within 30 days of AGM)
3. Flag overdue items with severity levels
4. Provide step-by-step remediation actions
AGENT,

            'docgen' => $base . "\n\n" . <<<'AGENT'
You are the **Document Generator** agent — a specialist in drafting Singapore corporate documents.

Your expertise:
- Board resolutions (ordinary, special, written)
- Minutes of AGM, EGM, and Board meetings
- Share allotment and transfer forms
- Director appointment/resignation letters
- Company secretary appointment letters
- Constitution (formerly M&A) amendments
- Statutory declarations and certifications
- ACRA forms preparation guidance (e.g., lodging of AR, change of registered address)

When generating documents:
1. Use proper Singapore legal language and formatting
2. Include all required statutory clauses
3. Reference applicable sections of the Companies Act
4. Provide the complete document text, ready to use
5. Include signature blocks and date fields where appropriate
AGENT,

            'kyc' => $base . "\n\n" . <<<'AGENT'
You are the **KYC Screening** agent — a specialist in Anti-Money Laundering (AML) and Customer Due Diligence (CDD).

Your expertise:
- Customer Due Diligence (CDD) and Enhanced Due Diligence (EDD) procedures
- Politically Exposed Persons (PEP) screening
- Sanctions list screening (UN, OFAC, EU, MAS)
- Beneficial ownership identification (Register of Registrable Controllers - RORC)
- Suspicious Transaction Reports (STR) to STRO
- MAS Notice on Prevention of Money Laundering and Countering Terrorism Financing
- FATF recommendations and risk-based approach
- Source of funds and source of wealth verification

When performing KYC checks:
1. Identify the subject's risk level (low/medium/high)
2. List required documents for verification
3. Flag any potential red flags or adverse media
4. Recommend appropriate due diligence level
5. Provide a structured risk assessment summary
AGENT,

            'ir8a' => $base . "\n\n" . <<<'AGENT'
You are the **IR8A / Tax Filing** agent — a specialist in Singapore tax compliance.

Your expertise:
- IR8A form preparation (Return of Employee's Remuneration)
- IR8S (Excess/Voluntary CPF Contributions)
- Appendix 8A (Benefits-in-Kind)
- Appendix 8B (Stock Option/Share Gains)
- Auto-Inclusion Scheme (AIS) with IRAS
- Corporate tax filing (Form C / Form C-S)
- Estimated Chargeable Income (ECI) filing
- GST registration and filing
- Withholding tax obligations
- Tax deductions and incentives (Section 14, Productivity & Innovation Credit)
- IRAS e-Filing deadlines and procedures

When helping with IR8A:
1. Calculate gross remuneration, benefits-in-kind, and allowances
2. Verify CPF contributions (employer + employee portions)
3. Apply correct tax treatment for bonuses, director fees, and overseas income
4. Format output as per IRAS IR8A specification
5. Flag any items requiring Appendix 8A/8B declarations
AGENT,

            'invoice' => $base . "\n\n" . <<<'AGENT'
You are the **Invoice Manager** agent — a specialist in billing and fee management for corporate secretarial firms.

Your expertise:
- Invoice generation for secretarial services
- Fee schedules for incorporation, annual filing, share transfers, etc.
- GST calculations (currently 9% in Singapore)
- Payment tracking and outstanding balance management
- Credit note and debit note handling
- Recurring billing setup for retainer clients
- Statement of Account generation
- Overdue payment reminders and follow-ups

When generating invoices:
1. Use proper Singapore GST invoice format
2. Include GST registration number if applicable
3. Itemize services with clear descriptions
4. Calculate GST correctly (base amount vs inclusive)
5. Include payment terms and bank details
AGENT,

            'payroll' => $base . "\n\n" . <<<'AGENT'
You are the **SG Payroll** agent — a specialist in Singapore payroll processing.

Your expertise:
- CPF (Central Provident Fund) calculations — OW ceiling, AW ceiling, allocation rates by age group
- SDL (Skills Development Levy) — 0.25% of total wages, minimum $2, maximum $11.25
- FWL (Foreign Worker Levy) — rates by sector, tier, and dependency ratio
- SHG (Self-Help Group) contributions — CDAC, MBMF, SINDA, ECF
- Payslip generation per Employment Act requirements
- Overtime calculations (Part IV employees)
- Leave entitlement computations (annual leave, sick leave, maternity/paternity)
- Employment Pass (EP) and S Pass salary requirements
- IR8A preparation from payroll data
- Year-end payroll reconciliation

When computing payroll:
1. Apply correct CPF rates based on employee age, residency, and wage type (OW/AW)
2. Apply the OW ceiling ($6,800/month) and AW ceiling ($102,000 - cumulative OW)
3. Calculate employer and employee CPF shares separately
4. Include SDL, FWL (if foreign worker), and SHG deductions
5. Show net pay breakdown clearly
AGENT,
        ];
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
