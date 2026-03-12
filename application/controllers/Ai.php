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
     * Accepts { message: string } and returns { ok, response_text, error }.
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

        // Build context: enrich the user message with workspace data when relevant
        $contextInfo = $this->buildContextSnippet($message);
        $enrichedMessage = $message;
        if ($contextInfo) {
            $enrichedMessage = $message . "\n\n---\n[Workspace context for this query]\n" . $contextInfo;
        }

        @set_time_limit(300);

        $bridge = new AiBridge();
        $result = $bridge->runTurn($enrichedMessage, [
            'max_tokens'  => 4096,
            'temperature' => 0.3,
            'timeout'     => 180,
        ]);

        if (empty($result['ok'])) {
            $this->json([
                'ok'            => false,
                'error'         => $result['error'] ?? 'AI agent is currently unavailable.',
                'response_text' => null,
            ]);
            return;
        }

        $this->json([
            'ok'            => true,
            'response_text' => $result['response_text'],
            'model'         => $result['model'] ?? null,
            'provider'      => $result['provider'] ?? null,
            'usage'         => $result['usage'] ?? null,
        ]);
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
     * Build a short context snippet from the database based on the user's query.
     * This gives Claude relevant workspace data to ground its answers.
     */
    /**
     * Build comprehensive context from the database for the AI agent.
     * Always loads a full snapshot so the AI can answer ANY question.
     */
    private function buildContextSnippet($message) {
        try {
            return $this->doBuildContext($message);
        } catch (\Exception $e) {
            return "Context lookup error: " . $e->getMessage();
        }
    }

    private function doBuildContext($message) {
        $client = $this->getClient();
        if (!$client) {
            return null;
        }

        $lines = [];
        $lowerMsg = strtolower($message);
        $today = date('Y-m-d');

        // ════════════════════════════════════════════
        // 1. ALWAYS: Basic stats
        // ════════════════════════════════════════════
        $companyCount = (int) $this->db->count('companies', 'client_id = ?', [$client->id]);
        $memberCount  = (int) $this->db->count('members', 'client_id = ?', [$client->id]);
        $docCount     = (int) $this->db->count('documents', 'client_id = ?', [$client->id]);

        $lines[] = "=== CORPFILE DATABASE CONTEXT ===";
        $lines[] = "Client: {$client->company_name} (Code: {$client->client_id})";
        $lines[] = "Today: {$today}";
        $lines[] = "Total companies: {$companyCount} | Total individuals/members: {$memberCount} | Total documents: {$docCount}";

        // ════════════════════════════════════════════
        // 2. ALWAYS: Company status breakdown
        // ════════════════════════════════════════════
        $statusSummary = $this->db->fetchAll(
            "SELECT COALESCE(entity_status, 'Unknown') AS status, COUNT(*) AS cnt
             FROM companies WHERE client_id = ?
             GROUP BY entity_status ORDER BY cnt DESC",
            [$client->id]
        );
        if ($statusSummary) {
            $lines[] = "\n--- Company Status Breakdown ---";
            foreach ($statusSummary as $s) {
                $lines[] = "  {$s->status}: {$s->cnt}";
            }
        }

        // ════════════════════════════════════════════
        // 3. ALWAYS: All companies with director/shareholder/secretary counts
        // ════════════════════════════════════════════
        $companies = $this->db->fetchAll(
            "SELECT c.id, c.company_name, c.registration_number, c.incorporation_date,
                    c.entity_status, c.company_type, c.fye_date, c.email,
                    (SELECT COUNT(*) FROM directors d WHERE d.company_id = c.id) AS director_count,
                    (SELECT COUNT(*) FROM shareholders s WHERE s.company_id = c.id) AS shareholder_count,
                    (SELECT COUNT(*) FROM secretaries sec WHERE sec.company_id = c.id) AS secretary_count,
                    (SELECT COUNT(*) FROM documents doc WHERE doc.entity_type = 'company' AND doc.entity_id = c.id) AS doc_count
             FROM companies c
             WHERE c.client_id = ?
             ORDER BY c.company_name ASC
             LIMIT 300",
            [$client->id]
        );
        if ($companies) {
            $lines[] = "\n--- All Companies ({$companyCount}) ---";
            $lines[] = "Format: Name | UEN/Reg | Incorp Date | Status | Type | FYE | Directors | Shareholders | Secretaries | Docs";
            foreach ($companies as $co) {
                $lines[] = "- {$co->company_name} | "
                    . ($co->registration_number ?: '-') . " | "
                    . ($co->incorporation_date ?: '-') . " | "
                    . ($co->entity_status ?: '-') . " | "
                    . ($co->company_type ?: '-') . " | "
                    . ($co->fye_date ?: '-') . " | "
                    . "D:{$co->director_count} S:{$co->shareholder_count} Sec:{$co->secretary_count} | "
                    . "Docs:{$co->doc_count}";
            }
        }

        // ════════════════════════════════════════════
        // 4. ALWAYS: Directors with company names
        // ════════════════════════════════════════════
        try {
            $directors = $this->db->fetchAll(
                "SELECT d.name, d.id_number, d.nationality, d.role, d.appointment_date, d.cessation_date,
                        c.company_name, c.registration_number
                 FROM directors d
                 JOIN companies c ON c.id = d.company_id
                 WHERE c.client_id = ?
                 ORDER BY c.company_name, d.name
                 LIMIT 500",
                [$client->id]
            );
            if ($directors) {
                $lines[] = "\n--- All Directors (" . count($directors) . ") ---";
                $lines[] = "Format: Name | ID | Nationality | Role | Appointed | Ceased | Company";
                foreach ($directors as $d) {
                    $lines[] = "- {$d->name} | "
                        . ($d->id_number ?: '-') . " | "
                        . ($d->nationality ?: '-') . " | "
                        . ($d->role ?: 'director') . " | "
                        . ($d->appointment_date ?: '-') . " | "
                        . ($d->cessation_date ?: 'current') . " | "
                        . $d->company_name;
                }
            }
        } catch (\Exception $e) {}

        // ════════════════════════════════════════════
        // 5. ALWAYS: Shareholders with company names
        // ════════════════════════════════════════════
        try {
            $shareholders = $this->db->fetchAll(
                "SELECT s.name, s.share_type, s.num_shares, s.nationality,
                        c.company_name, c.registration_number
                 FROM shareholders s
                 JOIN companies c ON c.id = s.company_id
                 WHERE c.client_id = ?
                 ORDER BY c.company_name, s.name
                 LIMIT 500",
                [$client->id]
            );
            if ($shareholders) {
                $lines[] = "\n--- All Shareholders (" . count($shareholders) . ") ---";
                $lines[] = "Format: Name | Share Type | Shares | Nationality | Company";
                foreach ($shareholders as $s) {
                    $lines[] = "- {$s->name} | "
                        . ($s->share_type ?: 'Ordinary') . " | "
                        . ($s->num_shares ?: '-') . " | "
                        . ($s->nationality ?: '-') . " | "
                        . $s->company_name;
                }
            }
        } catch (\Exception $e) {}

        // ════════════════════════════════════════════
        // 6. ALWAYS: Secretaries
        // ════════════════════════════════════════════
        try {
            $secretaries = $this->db->fetchAll(
                "SELECT s.name, s.appointment_date, s.cessation_date,
                        c.company_name
                 FROM secretaries s
                 JOIN companies c ON c.id = s.company_id
                 WHERE c.client_id = ?
                 ORDER BY c.company_name, s.name
                 LIMIT 300",
                [$client->id]
            );
            if ($secretaries) {
                $lines[] = "\n--- All Secretaries (" . count($secretaries) . ") ---";
                foreach ($secretaries as $s) {
                    $lines[] = "- {$s->name} | Appointed: " . ($s->appointment_date ?: '-')
                        . " | Ceased: " . ($s->cessation_date ?: 'current')
                        . " | {$s->company_name}";
                }
            }
        } catch (\Exception $e) {}

        // ════════════════════════════════════════════
        // 7. ALWAYS: Due dates / deadlines (next 30)
        // ════════════════════════════════════════════
        $deadlines = $this->db->fetchAll(
            "SELECT COALESCE(c.company_name, d.company_name, 'N/A') AS company_name,
                    d.event_name, d.due_date, d.status, d.pic
             FROM due_dates d
             LEFT JOIN companies c ON c.id = d.company_id
             WHERE d.client_id = ?
             ORDER BY COALESCE(d.due_date, '9999-12-31') ASC
             LIMIT 50",
            [$client->id]
        );
        if ($deadlines) {
            $lines[] = "\n--- Upcoming Deadlines (" . count($deadlines) . ") ---";
            $lines[] = "Format: Company | Event | Due Date | Status | PIC";
            foreach ($deadlines as $d) {
                $daysLeft = '';
                if ($d->due_date) {
                    $diff = (int) (new \DateTimeImmutable('today'))->diff(new \DateTimeImmutable($d->due_date))->format('%r%a');
                    $daysLeft = $diff < 0 ? " (OVERDUE by " . abs($diff) . " days)" : " ({$diff} days left)";
                }
                $lines[] = "- {$d->company_name} | {$d->event_name} | " . ($d->due_date ?: '-') . $daysLeft
                    . " | " . ($d->status ?: 'Pending')
                    . " | PIC: " . ($d->pic ?: '-');
            }
        }

        // ════════════════════════════════════════════
        // 8. ALWAYS: Recent documents
        // ════════════════════════════════════════════
        $docs = $this->db->fetchAll(
            "SELECT d.document_name, d.created_at,
                    COALESCE(c.company_name, 'General') AS company_name
             FROM documents d
             LEFT JOIN companies c ON c.id = d.entity_id AND d.entity_type = 'company'
             WHERE d.client_id = ?
             ORDER BY d.created_at DESC
             LIMIT 30",
            [$client->id]
        );
        if ($docs) {
            $lines[] = "\n--- Recent Documents (last 30) ---";
            foreach ($docs as $doc) {
                $lines[] = "- {$doc->document_name} | {$doc->company_name} | " . ($doc->created_at ?: '-');
            }
        }

        // ════════════════════════════════════════════
        // 9. ALWAYS: Members / individuals
        // ════════════════════════════════════════════
        $members = $this->db->fetchAll(
            "SELECT m.name, m.nationality, m.status, m.email, m.phone,
                    (SELECT COUNT(*) FROM company_officials co WHERE co.member_id = m.id) AS role_count
             FROM members m
             WHERE m.client_id = ?
             ORDER BY m.name ASC
             LIMIT 400",
            [$client->id]
        );
        if ($members) {
            $lines[] = "\n--- All Individuals/Members (" . count($members) . ") ---";
            $lines[] = "Format: Name | Nationality | Status | Email | Roles";
            foreach ($members as $m) {
                $lines[] = "- {$m->name} | "
                    . ($m->nationality ?: '-') . " | "
                    . ($m->status ?: '-') . " | "
                    . ($m->email ?: '-') . " | "
                    . "Roles: {$m->role_count}";
            }
        }

        // ════════════════════════════════════════════
        // 10. ALWAYS: Company events
        // ════════════════════════════════════════════
        try {
            $events = $this->db->fetchAll(
                "SELECT ce.event_type, ce.event_date, ce.description,
                        COALESCE(c.company_name, 'N/A') AS company_name
                 FROM company_events ce
                 LEFT JOIN companies c ON c.id = ce.company_id
                 WHERE ce.client_id = ?
                 ORDER BY ce.event_date DESC
                 LIMIT 30",
                [$client->id]
            );
            if ($events) {
                $lines[] = "\n--- Recent Company Events (last 30) ---";
                foreach ($events as $ev) {
                    $lines[] = "- {$ev->company_name} | {$ev->event_type} | " . ($ev->event_date ?: '-') . " | " . ($ev->description ?: '-');
                }
            }
        } catch (\Exception $e) {}

        // ════════════════════════════════════════════
        // 11. SMART: Specific company lookup if user mentions a company
        // ════════════════════════════════════════════
        $this->addSpecificCompanyContext($lines, $lowerMsg, $client);

        // ════════════════════════════════════════════
        // 12. Invoices count
        // ════════════════════════════════════════════
        try {
            $invoiceCount = (int) $this->db->count('invoices', 'client_id = ?', [$client->id]);
            if ($invoiceCount > 0) {
                $lines[] = "\n--- Invoices ---";
                $lines[] = "Total invoices: {$invoiceCount}";
            }
        } catch (\Exception $e) {}

        $lines[] = "\n=== END OF DATABASE CONTEXT ===";

        return implode("\n", $lines);
    }

    /**
     * If the user mentions a specific company name, load detailed info about it.
     */
    private function addSpecificCompanyContext(&$lines, $lowerMsg, $client) {
        // Try to match a company name from the message
        $allCompanyNames = $this->db->fetchAll(
            "SELECT id, company_name FROM companies WHERE client_id = ? ORDER BY LENGTH(company_name) DESC",
            [$client->id]
        );

        $matchedCompany = null;
        foreach ($allCompanyNames as $co) {
            if (stripos($lowerMsg, strtolower($co->company_name)) !== false) {
                $matchedCompany = $co;
                break;
            }
            // Also try partial match (first 2 words)
            $words = explode(' ', $co->company_name);
            if (count($words) >= 2) {
                $partial = strtolower($words[0] . ' ' . $words[1]);
                if (strlen($partial) > 5 && stripos($lowerMsg, $partial) !== false) {
                    $matchedCompany = $co;
                    break;
                }
            }
        }

        if (!$matchedCompany) return;

        $cid = $matchedCompany->id;
        $lines[] = "\n--- DETAILED LOOKUP: {$matchedCompany->company_name} ---";

        // Full company record
        $detail = $this->db->fetchOne("SELECT * FROM companies WHERE id = ?", [$cid]);
        if ($detail) {
            $fields = ['registration_number', 'acra_registration_number', 'incorporation_date',
                       'company_type', 'entity_status', 'fye_date', 'email', 'website', 'phone',
                       'ssic_code', 'ssic_description', 'registered_address', 'country',
                       'paid_up_capital', 'currency', 'contact_person', 'internal_css_status'];
            foreach ($fields as $f) {
                if (!empty($detail->$f)) {
                    $lines[] = "  " . str_replace('_', ' ', ucfirst($f)) . ": {$detail->$f}";
                }
            }
        }

        // Directors for this company
        try {
            $dirs = $this->db->fetchAll(
                "SELECT name, id_number, nationality, role, appointment_date, cessation_date
                 FROM directors WHERE company_id = ? ORDER BY name", [$cid]);
            if ($dirs) {
                $lines[] = "  Directors (" . count($dirs) . "):";
                foreach ($dirs as $d) {
                    $lines[] = "    - {$d->name} | {$d->nationality} | Since: " . ($d->appointment_date ?: '-')
                        . ($d->cessation_date ? " | Ceased: {$d->cessation_date}" : '');
                }
            }
        } catch (\Exception $e) {}

        // Shareholders for this company
        try {
            $shares = $this->db->fetchAll(
                "SELECT name, share_type, num_shares, nationality
                 FROM shareholders WHERE company_id = ? ORDER BY name", [$cid]);
            if ($shares) {
                $lines[] = "  Shareholders (" . count($shares) . "):";
                foreach ($shares as $s) {
                    $lines[] = "    - {$s->name} | " . ($s->share_type ?: 'Ordinary') . " | Shares: " . ($s->num_shares ?: '-');
                }
            }
        } catch (\Exception $e) {}

        // Secretaries for this company
        try {
            $secs = $this->db->fetchAll(
                "SELECT name, appointment_date, cessation_date
                 FROM secretaries WHERE company_id = ? ORDER BY name", [$cid]);
            if ($secs) {
                $lines[] = "  Secretaries (" . count($secs) . "):";
                foreach ($secs as $s) {
                    $lines[] = "    - {$s->name} | Since: " . ($s->appointment_date ?: '-');
                }
            }
        } catch (\Exception $e) {}

        // Addresses
        try {
            $addrs = $this->db->fetchAll(
                "SELECT address_type, CONCAT_WS(', ', block, address_text, building, postal_code) AS full_address
                 FROM addresses WHERE entity_type = 'company' AND entity_id = ?
                 LIMIT 5", [$cid]);
            if ($addrs) {
                $lines[] = "  Addresses:";
                foreach ($addrs as $a) {
                    $lines[] = "    - " . ($a->address_type ?: 'Address') . ": {$a->full_address}";
                }
            }
        } catch (\Exception $e) {}

        // Due dates for this company
        try {
            $dues = $this->db->fetchAll(
                "SELECT event_name, due_date, status FROM due_dates WHERE company_id = ? ORDER BY due_date ASC LIMIT 10", [$cid]);
            if ($dues) {
                $lines[] = "  Due Dates:";
                foreach ($dues as $d) {
                    $lines[] = "    - {$d->event_name} | Due: " . ($d->due_date ?: '-') . " | " . ($d->status ?: 'Pending');
                }
            }
        } catch (\Exception $e) {}
    }
}
