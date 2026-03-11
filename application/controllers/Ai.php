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

        // Always provide basic stats
        $companyCount = $this->db->count('companies', 'client_id = ?', [$client->id]);
        $lines[] = "Client: {$client->company_name} (Code: {$client->client_id})";
        $lines[] = "Total companies under management: {$companyCount}";
        $lines[] = "Today's date: {$today}";

        // ── Recent registrations / incorporations (past N months) ──
        if (preg_match('/recent|new|register|incorporat|past.*month|最近|新注册|注册|成立/i', $lowerMsg)) {
            // Detect time range from message (default 3 months)
            $months = 3;
            if (preg_match('/(\d+)\s*(?:month|个月)/i', $lowerMsg, $m)) {
                $months = min((int)$m[1], 24);
            }
            $sinceDate = date('Y-m-d', strtotime("-{$months} months"));

            $recentCompanies = $this->db->fetchAll(
                "SELECT company_name, registration_number, incorporation_date, entity_status, internal_css_status
                 FROM companies
                 WHERE client_id = ?
                   AND incorporation_date >= ?
                 ORDER BY incorporation_date DESC
                 LIMIT 50",
                [$client->id, $sinceDate]
            );
            $lines[] = "\nCompanies incorporated in the past {$months} months (since {$sinceDate}):";
            if ($recentCompanies) {
                $lines[] = "Found " . count($recentCompanies) . " companies:";
                foreach ($recentCompanies as $co) {
                    $lines[] = "- {$co->company_name} | Reg: " . ($co->registration_number ?: 'N/A')
                        . " | Incorporated: " . ($co->incorporation_date ?: 'N/A')
                        . " | Status: " . ($co->entity_status ?: 'N/A')
                        . " | CSS Status: " . ($co->internal_css_status ?: 'N/A');
                }
            } else {
                $lines[] = "No companies found with incorporation_date in this period.";

                // Fallback: show companies created recently in system
                $recentCreated = $this->db->fetchAll(
                    "SELECT company_name, registration_number, incorporation_date, entity_status, created_at
                     FROM companies
                     WHERE client_id = ?
                     ORDER BY COALESCE(incorporation_date, created_at) DESC
                     LIMIT 20",
                    [$client->id]
                );
                if ($recentCreated) {
                    $lines[] = "\nMost recently added companies (by system record):";
                    foreach ($recentCreated as $co) {
                        $lines[] = "- {$co->company_name} | Reg: " . ($co->registration_number ?: 'N/A')
                            . " | Incorporated: " . ($co->incorporation_date ?: 'N/A')
                            . " | Added: " . ($co->created_at ?: 'N/A');
                    }
                }
            }
        }

        // ── Compliance / deadlines ──
        if (preg_match('/deadline|due|compliance|agm|annual|overdue|alert|fye/i', $lowerMsg)) {
            $deadlines = $this->db->fetchAll(
                "SELECT COALESCE(c.company_name, 'N/A') AS company_name,
                        d.event_name, d.due_date, d.status
                 FROM due_dates d
                 LEFT JOIN companies c ON c.id = d.company_id
                 WHERE d.client_id = ?
                 ORDER BY COALESCE(d.due_date, '9999-12-31') ASC
                 LIMIT 20",
                [$client->id]
            );
            if ($deadlines) {
                $lines[] = "\nUpcoming deadlines:";
                foreach ($deadlines as $d) {
                    $lines[] = "- {$d->company_name} | {$d->event_name} | Due: " . ($d->due_date ?: 'N/A') . " | Status: " . ($d->status ?: 'Pending');
                }
            }
        }

        // ── IR8A / payroll / tax ──
        if (preg_match('/ir8a|payroll|tax|cpf|iras|sdl|fwl/i', $lowerMsg)) {
            $docs = $this->db->fetchAll(
                "SELECT document_name, created_at
                 FROM documents
                 WHERE client_id = ?
                   AND (document_name LIKE '%IR8A%' OR document_name LIKE '%Tax%' OR document_name LIKE '%payroll%')
                 ORDER BY created_at DESC
                 LIMIT 10",
                [$client->id]
            );
            if ($docs) {
                $lines[] = "\nTax/payroll documents:";
                foreach ($docs as $doc) {
                    $lines[] = "- {$doc->document_name} (" . ($doc->created_at ?: 'no date') . ")";
                }
            }
        }

        // ── Company list / search ──
        if (preg_match('/compan|director|share|list|清单|公司|列表/i', $lowerMsg)) {
            // Check if user is searching for specific company
            $searchTerm = null;
            if (preg_match('/(?:named?|called|search|find|查找|搜索)\s+["\']?([^"\']+)["\']?/i', $lowerMsg, $sm)) {
                $searchTerm = trim($sm[1]);
            }

            if ($searchTerm) {
                $companies = $this->db->fetchAll(
                    "SELECT company_name, registration_number, incorporation_date, entity_status, internal_css_status
                     FROM companies
                     WHERE client_id = ? AND (company_name LIKE ? OR registration_number LIKE ?)
                     ORDER BY company_name ASC
                     LIMIT 20",
                    [$client->id, "%{$searchTerm}%", "%{$searchTerm}%"]
                );
            } else {
                $companies = $this->db->fetchAll(
                    "SELECT company_name, registration_number, incorporation_date, entity_status, internal_css_status
                     FROM companies
                     WHERE client_id = ?
                     ORDER BY company_name ASC
                     LIMIT 30",
                    [$client->id]
                );
            }
            if ($companies) {
                $lines[] = $searchTerm
                    ? "\nCompanies matching '{$searchTerm}' (" . count($companies) . " found):"
                    : "\nCompanies (first " . count($companies) . "):";
                foreach ($companies as $co) {
                    $lines[] = "- {$co->company_name} | Reg: " . ($co->registration_number ?: 'N/A')
                        . " | Incorporated: " . ($co->incorporation_date ?: 'N/A')
                        . " | Status: " . ($co->entity_status ?: 'Active');
                }
                if (count($companies) >= 30) {
                    $lines[] = "(Showing first 30 of {$companyCount} total)";
                }
            }
        }

        // ── Company status summary ──
        if (preg_match('/status|active|dormant|struck|terminated|状态|活跃/i', $lowerMsg)) {
            $statusSummary = $this->db->fetchAll(
                "SELECT COALESCE(entity_status, 'Unknown') AS status, COUNT(*) AS cnt
                 FROM companies
                 WHERE client_id = ?
                 GROUP BY entity_status
                 ORDER BY cnt DESC",
                [$client->id]
            );
            if ($statusSummary) {
                $lines[] = "\nCompany status breakdown:";
                foreach ($statusSummary as $s) {
                    $lines[] = "- {$s->status}: {$s->cnt} companies";
                }
            }
        }

        // ── Invoice / billing ──
        if (preg_match('/invoice|bill|fee|payment|发票|账单/i', $lowerMsg)) {
            $invoiceCount = $this->db->count('invoices', 'client_id = ?', [$client->id]);
            $lines[] = "\nTotal invoices: {$invoiceCount}";
        }

        // ── Officers / directors ──
        if (preg_match('/officer|director|secretary|shareholder|member|董事|股东|秘书/i', $lowerMsg)) {
            try {
                // Find companies with specific director counts if asked
                if (preg_match('/(\d+)\s*(?:director|董事)/i', $lowerMsg, $dm)) {
                    $targetCount = (int)$dm[1];
                    $companiesWithNDirs = $this->db->fetchAll(
                        "SELECT c.company_name, c.registration_number, COUNT(d.id) AS dir_count
                         FROM companies c
                         JOIN directors d ON d.company_id = c.id
                         WHERE c.client_id = ? AND d.role = 'director'
                         GROUP BY c.id, c.company_name, c.registration_number
                         HAVING dir_count = ?
                         ORDER BY c.company_name ASC
                         LIMIT 30",
                        [$client->id, $targetCount]
                    );
                    if ($companiesWithNDirs) {
                        $lines[] = "\nCompanies with exactly {$targetCount} directors (" . count($companiesWithNDirs) . " found):";
                        foreach ($companiesWithNDirs as $co) {
                            $lines[] = "- {$co->company_name} | Reg: " . ($co->registration_number ?: 'N/A') . " | Directors: {$co->dir_count}";
                        }
                    } else {
                        $lines[] = "\nNo companies found with exactly {$targetCount} directors.";
                    }
                } else {
                    // General director stats
                    $dirStats = $this->db->fetchAll(
                        "SELECT c.company_name, COUNT(d.id) AS dir_count
                         FROM companies c
                         LEFT JOIN directors d ON d.company_id = c.id AND d.role = 'director'
                         WHERE c.client_id = ?
                         GROUP BY c.id, c.company_name
                         ORDER BY dir_count DESC
                         LIMIT 20",
                        [$client->id]
                    );
                    if ($dirStats) {
                        $totalDirs = array_sum(array_map(function($r) { return $r->dir_count; }, $dirStats));
                        $lines[] = "\nDirector overview (top 20 companies by director count, total directors: {$totalDirs}):";
                        foreach ($dirStats as $co) {
                            $lines[] = "- {$co->company_name}: {$co->dir_count} directors";
                        }
                    }
                }
            } catch (\Exception $e) {
                // Table may not exist in some environments
                $lines[] = "\n(Director data not available)";
            }
        }

        return implode("\n", $lines);
    }
}
