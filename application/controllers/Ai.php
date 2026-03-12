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

    private function doBuildContext($message) {
        $client = $this->getClient();
        if (!$client) {
            return null;
        }

        $lines = [];
        $today = date('Y-m-d');

        // ── 1. Basic stats ──
        $companyCount = (int) $this->db->count('companies', 'client_id = ?', [$client->id]);
        $memberCount  = (int) $this->db->count('members', 'client_id = ?', [$client->id]);

        $lines[] = "=== CORPFILE DATABASE CONTEXT ===";
        $lines[] = "Client: {$client->company_name} (Code: {$client->client_id})";
        $lines[] = "Today: {$today}";
        $lines[] = "Total companies: {$companyCount} | Total individuals/members: {$memberCount}";

        // ── 2. Company status breakdown ──
        try {
            $statusSummary = $this->db->fetchAll(
                "SELECT COALESCE(entity_status, 'Unknown') AS status, COUNT(*) AS cnt
                 FROM companies WHERE client_id = ? GROUP BY entity_status ORDER BY cnt DESC",
                [$client->id]
            );
            if ($statusSummary) {
                $lines[] = "\n--- Company Status Breakdown ---";
                foreach ($statusSummary as $s) {
                    $lines[] = "  {$s->status}: {$s->cnt}";
                }
            }
        } catch (\Exception $e) {}

        // ── 3. All companies with officer counts ──
        // Note: companies table uses company_type_id (FK), not company_type
        try {
            $companies = $this->db->fetchAll(
                "SELECT c.id, c.company_name, c.registration_number, c.incorporation_date,
                        c.entity_status, c.internal_css_status, c.fye_date, c.email, c.contact_person,
                        (SELECT COUNT(*) FROM directors d WHERE d.company_id = c.id) AS director_count,
                        (SELECT COUNT(*) FROM shareholders s WHERE s.company_id = c.id) AS shareholder_count,
                        (SELECT COUNT(*) FROM secretaries sec WHERE sec.company_id = c.id) AS secretary_count
                 FROM companies c
                 WHERE c.client_id = ?
                 ORDER BY c.company_name ASC
                 LIMIT 300",
                [$client->id]
            );
            if ($companies) {
                $lines[] = "\n--- All Companies ({$companyCount}) ---";
                $lines[] = "Format: Name | UEN/Reg | Incorp Date | Status | CSS Status | FYE | Directors | Shareholders | Secretaries";
                foreach ($companies as $co) {
                    $lines[] = "- {$co->company_name} | "
                        . ($co->registration_number ?: '-') . " | "
                        . ($co->incorporation_date ?: '-') . " | "
                        . ($co->entity_status ?: '-') . " | "
                        . ($co->internal_css_status ?: '-') . " | "
                        . ($co->fye_date ?: '-') . " | "
                        . "D:{$co->director_count} S:{$co->shareholder_count} Sec:{$co->secretary_count}";
                }
            }
        } catch (\Exception $e) {
            $lines[] = "\n(Company list query error: {$e->getMessage()})";
        }

        // ── 4. Directors ──
        // Note: directors table uses appointment_date, cessation_date
        try {
            $directors = $this->db->fetchAll(
                "SELECT d.name, d.id_number, d.nationality, d.role, d.appointment_date, d.cessation_date,
                        c.company_name
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

        // ── 5. Shareholders ──
        // Note: shareholders table uses shareholder_type, date_of_appointment; no share_type/num_shares columns
        try {
            $shareholders = $this->db->fetchAll(
                "SELECT s.name, s.shareholder_type, s.nationality, s.date_of_appointment, s.status,
                        c.company_name
                 FROM shareholders s
                 JOIN companies c ON c.id = s.company_id
                 WHERE c.client_id = ?
                 ORDER BY c.company_name, s.name
                 LIMIT 500",
                [$client->id]
            );
            if ($shareholders) {
                $lines[] = "\n--- All Shareholders (" . count($shareholders) . ") ---";
                $lines[] = "Format: Name | Type | Nationality | Appointed | Status | Company";
                foreach ($shareholders as $s) {
                    $lines[] = "- {$s->name} | "
                        . ($s->shareholder_type ?: 'Individual') . " | "
                        . ($s->nationality ?: '-') . " | "
                        . ($s->date_of_appointment ?: '-') . " | "
                        . ($s->status ?: '-') . " | "
                        . $s->company_name;
                }
            }
        } catch (\Exception $e) {}

        // ── 6. Secretaries ──
        // Note: secretaries table uses date_of_appointment, date_of_cessation
        try {
            $secretaries = $this->db->fetchAll(
                "SELECT s.name, s.date_of_appointment, s.date_of_cessation, s.status,
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
                    $lines[] = "- {$s->name} | Appointed: " . ($s->date_of_appointment ?: '-')
                        . " | Ceased: " . ($s->date_of_cessation ?: 'current')
                        . " | Status: " . ($s->status ?: '-')
                        . " | {$s->company_name}";
                }
            }
        } catch (\Exception $e) {}

        // ── 7. Due dates / deadlines ──
        try {
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
                $lines[] = "\n--- Deadlines (" . count($deadlines) . ") ---";
                foreach ($deadlines as $d) {
                    $daysLeft = '';
                    if ($d->due_date) {
                        $diff = (int) (new \DateTimeImmutable('today'))->diff(new \DateTimeImmutable($d->due_date))->format('%r%a');
                        $daysLeft = $diff < 0 ? " (OVERDUE " . abs($diff) . "d)" : " ({$diff}d left)";
                    }
                    $lines[] = "- {$d->company_name} | {$d->event_name} | " . ($d->due_date ?: '-') . $daysLeft
                        . " | " . ($d->status ?: 'Pending') . " | PIC: " . ($d->pic ?: '-');
                }
            }
        } catch (\Exception $e) {}

        // ── 8. Members / individuals ──
        // Note: members table uses mobile_number, not phone
        try {
            $members = $this->db->fetchAll(
                "SELECT m.name, m.nationality, m.status, m.email, m.mobile_number
                 FROM members m
                 WHERE m.client_id = ?
                 ORDER BY m.name ASC
                 LIMIT 300",
                [$client->id]
            );
            if ($members) {
                $lines[] = "\n--- All Individuals/Members (" . count($members) . ") ---";
                foreach ($members as $m) {
                    $lines[] = "- {$m->name} | " . ($m->nationality ?: '-') . " | " . ($m->status ?: '-')
                        . " | " . ($m->email ?: '-');
                }
            }
        } catch (\Exception $e) {}

        // ── 9. Recent documents ──
        try {
            $docs = $this->db->fetchAll(
                "SELECT d.document_name, d.created_at,
                        COALESCE(c.company_name, 'General') AS company_name
                 FROM documents d
                 LEFT JOIN companies c ON c.id = d.entity_id AND d.entity_type = 'company'
                 WHERE d.client_id = ?
                 ORDER BY d.created_at DESC
                 LIMIT 20",
                [$client->id]
            );
            if ($docs) {
                $lines[] = "\n--- Recent Documents (" . count($docs) . ") ---";
                foreach ($docs as $doc) {
                    $lines[] = "- {$doc->document_name} | {$doc->company_name} | " . ($doc->created_at ?: '-');
                }
            }
        } catch (\Exception $e) {}

        // ── 10. Invoices ──
        try {
            $invoiceCount = (int) $this->db->count('invoices', 'client_id = ?', [$client->id]);
            if ($invoiceCount > 0) {
                $lines[] = "\nTotal invoices: {$invoiceCount}";
            }
        } catch (\Exception $e) {}

        $lines[] = "\n=== END OF DATABASE CONTEXT ===";
        $lines[] = "IMPORTANT: The above is REAL data from the database. Present it directly when the user asks. Do NOT say you cannot access the database.";

        return implode("\n", $lines);
    }
}
