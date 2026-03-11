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

        @set_time_limit(120);

        $bridge = new AiBridge();
        $result = $bridge->runTurn($enrichedMessage, [
            'max_tokens'  => 2048,
            'temperature' => 0.4,
            'timeout'     => 90,
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
    private function buildContextSnippet($message) {
        $client = $this->getClient();
        if (!$client) {
            return null;
        }

        $lines = [];
        $lowerMsg = strtolower($message);

        // Always provide basic stats
        $companyCount = $this->db->count('companies', 'client_id = ?', [$client->id]);
        $lines[] = "Client: {$client->client_name} (Code: {$client->client_id})";
        $lines[] = "Total companies under management: {$companyCount}";

        // Compliance / deadlines
        if (preg_match('/deadline|due|compliance|agm|annual|overdue|alert|fye/i', $lowerMsg)) {
            $deadlines = $this->db->fetchAll(
                "SELECT COALESCE(c.company_name, 'N/A') AS company_name,
                        d.event_name, d.due_date, d.status
                 FROM due_dates d
                 LEFT JOIN companies c ON c.id = d.company_id
                 WHERE d.client_id = ?
                 ORDER BY COALESCE(d.due_date, '9999-12-31') ASC
                 LIMIT 10",
                [$client->id]
            );
            if ($deadlines) {
                $lines[] = "\nUpcoming deadlines:";
                foreach ($deadlines as $d) {
                    $lines[] = "- {$d->company_name} | {$d->event_name} | Due: " . ($d->due_date ?: 'N/A') . " | Status: " . ($d->status ?: 'Pending');
                }
            }
        }

        // IR8A / payroll / tax
        if (preg_match('/ir8a|payroll|tax|cpf|iras|sdl|fwl/i', $lowerMsg)) {
            $docs = $this->db->fetchAll(
                "SELECT document_name, created_at
                 FROM documents
                 WHERE client_id = ?
                   AND (document_name LIKE '%IR8A%' OR document_name LIKE '%Tax%' OR document_name LIKE '%payroll%')
                 ORDER BY created_at DESC
                 LIMIT 5",
                [$client->id]
            );
            if ($docs) {
                $lines[] = "\nTax/payroll documents:";
                foreach ($docs as $doc) {
                    $lines[] = "- {$doc->document_name} (" . ($doc->created_at ?: 'no date') . ")";
                }
            }
        }

        // Company list
        if (preg_match('/compan|director|share|incorporat/i', $lowerMsg)) {
            $companies = $this->db->fetchAll(
                "SELECT company_name, registration_no, company_status
                 FROM companies
                 WHERE client_id = ?
                 ORDER BY company_name ASC
                 LIMIT 10",
                [$client->id]
            );
            if ($companies) {
                $lines[] = "\nCompanies (first 10):";
                foreach ($companies as $co) {
                    $lines[] = "- {$co->company_name} | Reg: " . ($co->registration_no ?: 'N/A') . " | Status: " . ($co->company_status ?: 'Active');
                }
            }
        }

        // Invoice / billing
        if (preg_match('/invoice|bill|fee|payment/i', $lowerMsg)) {
            $invoiceCount = $this->db->count('invoices', 'client_id = ?', [$client->id]);
            $lines[] = "\nTotal invoices: {$invoiceCount}";
        }

        return count($lines) > 2 ? implode("\n", $lines) : implode("\n", $lines);
    }
}
