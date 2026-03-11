<?php
require_once APPPATH . 'libraries/AiBridge.php';

/**
 * AI Controller
 *
 * JSON endpoints for the CorpFile AI agent console.
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

    private function daysUntil($dateValue) {
        if (empty($dateValue)) {
            return null;
        }

        try {
            $today = new DateTimeImmutable('today');
            $target = new DateTimeImmutable($dateValue);
            return (int) $today->diff($target)->format('%r%a');
        } catch (Exception $e) {
            return null;
        }
    }

    private function buildIr8aSnapshot() {
        $snapshot = [
            'client_code' => $_SESSION['client_id'] ?? '',
            'documents' => [],
            'deadlines' => [],
            'payroll_clients' => [],
            'templates_count' => 0,
        ];

        $client = $this->getClient();
        if (!$client) {
            return $snapshot;
        }

        $snapshot['documents'] = $this->db->fetchAll(
            "SELECT document_name, file_path, created_at
             FROM documents
             WHERE client_id = ?
               AND (
                    document_name LIKE '%IR8A%'
                    OR document_name LIKE '%Tax%'
                    OR document_name LIKE '%payroll%'
               )
             ORDER BY created_at DESC
             LIMIT 8",
            [$client->id]
        );

        $snapshot['deadlines'] = $this->db->fetchAll(
            "SELECT COALESCE(c.company_name, d.company_name, 'Corporate record') AS company_name,
                    d.event_name, d.due_date, d.status
             FROM due_dates d
             LEFT JOIN companies c ON c.id = d.company_id
             WHERE d.client_id = ?
               AND d.event_name IN ('Tax Return', 'ECI', 'Annual Filing')
             ORDER BY COALESCE(d.due_date, '9999-12-31') ASC
             LIMIT 8",
            [$client->id]
        );

        $snapshot['payroll_clients'] = $this->db->fetchAll(
            "SELECT company_name, country
             FROM companies
             WHERE client_id = ? AND is_payroll_client = 1
             ORDER BY company_name ASC
             LIMIT 8",
            [$client->id]
        );

        $snapshot['templates_count'] = (int) $this->db->count('form_templates', 'client_id = ?', [$client->id]);

        foreach ($snapshot['deadlines'] as $deadline) {
            $deadline->days_remaining = $this->daysUntil($deadline->due_date);
        }

        return $snapshot;
    }

    private function composeAgentPrompt($userMessage, $task, $snapshot) {
        $lines = [
            'Use the corpfile-ir8a skill and the sg-payroll skill for this request.',
            'You are the CorpFile IR8A agent embedded inside an AI-native corporate management workspace.',
            'Use sg-payroll for Singapore payroll, SDL, FWL, self-help levy, payslip timing, and IR8A-related payroll checks.',
            'Ground any specific references to documents, deadlines, payroll clients, or filing readiness only in the workspace data below.',
            'If the workspace data is insufficient, say so clearly instead of inventing details.',
            'Respond with short operational sections titled: Summary, Next Actions, Source Records.',
            '',
            'Requested workflow: ' . ($task ?: 'general_ir8a'),
            'User request: ' . $userMessage,
            '',
            'Workspace snapshot:',
            '- Client code: ' . ($snapshot['client_code'] ?: 'Unknown'),
            '- Template count: ' . (int) ($snapshot['templates_count'] ?? 0),
            '- Tax documents loaded: ' . count($snapshot['documents']),
            '- Tax deadlines loaded: ' . count($snapshot['deadlines']),
            '- Payroll clients loaded: ' . count($snapshot['payroll_clients']),
            '',
            'Recent tax documents:',
        ];

        foreach ($snapshot['documents'] as $document) {
            $lines[] = sprintf(
                '- %s | %s | %s',
                $document->document_name ?? 'Unnamed document',
                !empty($document->created_at) ? date('Y-m-d', strtotime($document->created_at)) : 'No date',
                $document->file_path ?? 'No path'
            );
        }

        $lines[] = '';
        $lines[] = 'Upcoming tax deadlines:';
        foreach ($snapshot['deadlines'] as $deadline) {
            $lines[] = sprintf(
                '- %s | %s | due %s | %s days | %s',
                $deadline->company_name ?? 'Corporate record',
                $deadline->event_name ?? 'Tax event',
                $deadline->due_date ?? 'No due date',
                $deadline->days_remaining === null ? 'n/a' : (string) $deadline->days_remaining,
                $deadline->status ?? 'Pending'
            );
        }

        $lines[] = '';
        $lines[] = 'Payroll clients:';
        foreach ($snapshot['payroll_clients'] as $client) {
            $lines[] = sprintf(
                '- %s | %s',
                $client->company_name ?? 'Unnamed company',
                $client->country ?? 'Unknown jurisdiction'
            );
        }

        return implode("\n", $lines);
    }

    private function skillInstallInfo() {
        $stateDir = getenv('AI_STATE_DIR') ?: ((getenv('HOME') ?: '') . '/.corpfile-ai');
        $workspaceRoot = rtrim($stateDir, '/') . '/workspace/skills';

        return [
            'ir8a_skill_installed' => is_file($workspaceRoot . '/corpfile-ir8a/SKILL.md'),
            'payroll_skill_installed' => is_file($workspaceRoot . '/sg-payroll/SKILL.md'),
        ];
    }

    public function status() {
        $this->requireAuth();

        $bridge = new AiBridge();
        $status = $bridge->status();
        $skillInfo = $this->skillInstallInfo();

        $this->json([
            'success' => true,
            'status' => array_merge($status, $skillInfo),
        ]);
    }

    /**
     * Chat endpoint for the AI Agent drawer.
     * Accepts POST { message: string } and returns { ok, response_text, error }.
     * Does NOT require CSRF for easier AJAX usage from the drawer.
     */
    public function chat() {
        $this->requireAuth();

        if (strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->json(['ok' => false, 'error' => 'Method not allowed'], 405);
        }

        $payload = $this->getJsonInput();
        $message = trim((string) ($payload['message'] ?? ''));
        if ($message === '') {
            $this->json(['ok' => false, 'error' => 'Message is required']);
        }
        if (strlen($message) > 4000) {
            $message = substr($message, 0, 4000);
        }

        // Detect which skill(s) to invoke based on keywords
        $skills = $this->detectSkills($message);

        // Build context-aware prompt
        $prompt = implode("\n", [
            'Use these skills: ' . implode(', ', $skills) . '.',
            'You are CorpFile AI, an intelligent assistant embedded in a corporate secretarial management platform.',
            'Help users with company management, compliance tracking, document generation, KYC screening, invoicing, and Singapore regulatory workflows.',
            'Be concise, operational, and action-oriented.',
            'If asked about specific companies or records, use workspace data when available.',
            '',
            'User request: ' . $message,
        ]);

        @set_time_limit(120);

        $bridge = new AiBridge();
        $result = $bridge->runTurn($prompt, [
            'thinking' => 'minimal',
            'timeout' => 90,
        ]);

        if (empty($result['ok'])) {
            $this->json([
                'ok' => false,
                'error' => $result['error'] ?? 'AI agent is currently unavailable.',
                'response_text' => null,
            ]);
        }

        $this->json([
            'ok' => true,
            'response_text' => $result['response_text'] ?: 'Request processed successfully.',
            'mode' => $result['mode'] ?? null,
            'skills_used' => $skills,
        ]);
    }

    /**
     * Detect which AI skills to invoke based on message content.
     */
    private function detectSkills($message) {
        $message = strtolower($message);
        $skills = [];

        if (preg_match('/ir8a|payroll|tax|iras|income\s*tax/i', $message)) {
            $skills[] = 'corpfile-ir8a';
            $skills[] = 'sg-payroll';
        }
        if (preg_match('/kyc|cdd|due\s*diligence|screening|aml|pep|sanctions/i', $message)) {
            $skills[] = 'corpfile-kyc';
        }
        if (preg_match('/document|template|resolution|form|generate|draft|letter/i', $message)) {
            $skills[] = 'corpfile-docgen';
        }
        if (preg_match('/invoice|billing|fee|annual\s*fee|payment/i', $message)) {
            $skills[] = 'corpfile-invoice';
        }
        if (preg_match('/compliance|agm|annual\s*return|fye|due\s*date|expiry|deadline|alert/i', $message)) {
            $skills[] = 'corpfile-compliance';
        }

        if (empty($skills)) {
            $skills = ['corpfile-compliance', 'corpfile-docgen'];
        }

        return array_unique($skills);
    }

    public function run() {
        $this->requireAuth();

        if (strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->json(['success' => false, 'message' => 'Method not allowed'], 405);
        }

        $payload = $this->getJsonInput();
        $token = $payload['ci_csrf_token'] ?? $_POST['ci_csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'] ?? '', (string) $token)) {
            $this->json(['success' => false, 'message' => 'Invalid CSRF token'], 419);
        }

        $message = trim((string) ($payload['message'] ?? $_POST['message'] ?? ''));
        if ($message === '') {
            $this->json(['success' => false, 'message' => 'Prompt is required'], 422);
        }

        if (strlen($message) > 4000) {
            $message = substr($message, 0, 4000);
        }

        $task = trim((string) ($payload['task'] ?? $_POST['task'] ?? 'general_ir8a'));
        $thinking = trim((string) ($payload['thinking'] ?? $_POST['thinking'] ?? 'minimal'));
        if (!in_array($thinking, ['off', 'minimal', 'low', 'medium', 'high'], true)) {
            $thinking = 'minimal';
        }

        $snapshot = $this->buildIr8aSnapshot();
        $prompt = $this->composeAgentPrompt($message, $task, $snapshot);

        @set_time_limit(180);
        @ini_set('max_execution_time', '180');

        $bridge = new AiBridge();
        $result = $bridge->runTurn($prompt, [
            'thinking' => $thinking,
            'agent_id' => getenv('AI_AGENT_ID') ?: 'main',
            'timeout' => getenv('AI_TIMEOUT') ?: 120,
        ]);

        if (empty($result['ok'])) {
            $this->json([
                'success' => false,
                'message' => $result['error'] ?? 'AI agent run failed.',
                'meta' => [
                    'mode' => $result['mode'] ?? null,
                    'agent_id' => $result['agent_id'] ?? null,
                ],
            ], 502);
        }

        $this->json([
            'success' => true,
            'reply' => $result['response_text'] ?: 'AI agent completed, but did not return text.',
            'meta' => [
                'mode' => $result['mode'] ?? null,
                'agent_id' => $result['agent_id'] ?? null,
                'session_id' => $result['session_id'] ?? null,
                'provider' => $result['provider'] ?? null,
                'model' => $result['model'] ?? null,
                'duration_ms' => $result['duration_ms'] ?? null,
                'usage' => $result['usage'] ?? null,
                'documents_loaded' => count($snapshot['documents']),
                'deadlines_loaded' => count($snapshot['deadlines']),
                'payroll_clients_loaded' => count($snapshot['payroll_clients']),
            ],
        ]);
    }
}
