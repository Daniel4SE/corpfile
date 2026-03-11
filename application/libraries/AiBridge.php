<?php
/**
 * AiBridge
 *
 * Calls the Anthropic Claude Messages API directly via HTTP.
 * No CLI dependency — works anywhere PHP + curl are available.
 */
class AiBridge {
    private $apiKey;
    private $apiUrl;
    private $model;
    private $systemPrompt;

    public function __construct($options = []) {
        $this->apiKey = $options['api_key'] ?? getenv('AI_API_KEY') ?: '';
        $this->apiUrl = $options['api_url'] ?? getenv('AI_API_URL') ?: 'https://api.anthropic.com/v1/messages';
        $this->model  = $options['model']   ?? getenv('AI_MODEL')   ?: 'claude-opus-4-6';

        $this->systemPrompt = $options['system_prompt'] ?? $this->defaultSystemPrompt();
    }

    /**
     * Check if the AI backend is configured and reachable.
     */
    public function status() {
        if (empty($this->apiKey)) {
            return [
                'ready' => false,
                'error' => 'AI_API_KEY not configured.',
                'provider' => 'anthropic',
                'model' => $this->model,
            ];
        }

        return [
            'ready' => true,
            'provider' => 'anthropic',
            'model' => $this->model,
            'api_url' => $this->apiUrl,
            'error' => null,
        ];
    }

    /**
     * Send a message to Claude and return the response.
     *
     * @param string $message     User's message
     * @param array  $options     Optional: system_prompt, max_tokens, temperature, context (array of prior messages)
     * @return array              ['ok' => bool, 'response_text' => string, 'error' => string|null, ...]
     */
    public function runTurn($message, $options = []) {
        $message = trim((string) $message);
        if ($message === '') {
            return ['ok' => false, 'error' => 'Prompt is required.'];
        }

        if (empty($this->apiKey)) {
            return ['ok' => false, 'error' => 'AI_API_KEY not configured. Please set the AI_API_KEY environment variable.'];
        }

        $maxTokens   = (int) ($options['max_tokens']   ?? 2048);
        $temperature = (float) ($options['temperature'] ?? 0.4);
        $timeout     = (int) ($options['timeout']       ?? 90);
        $timeout     = max(15, min($timeout, 300));

        // Build messages array (support conversation context)
        $messages = [];
        if (!empty($options['context']) && is_array($options['context'])) {
            foreach ($options['context'] as $msg) {
                $messages[] = [
                    'role'    => $msg['role'] ?? 'user',
                    'content' => $msg['content'] ?? '',
                ];
            }
        }
        $messages[] = ['role' => 'user', 'content' => $message];

        // System prompt
        $systemPrompt = $options['system_prompt'] ?? $this->systemPrompt;

        // Build API request body
        $body = [
            'model'      => $this->model,
            'max_tokens' => $maxTokens,
            'temperature'=> $temperature,
            'system'     => $systemPrompt,
            'messages'   => $messages,
        ];

        $result = $this->callApi($body, $timeout);

        if (!$result['ok']) {
            return [
                'ok'    => false,
                'error' => $result['error'],
                'response_text' => null,
            ];
        }

        $data = $result['data'];

        // Extract text from response content blocks
        $responseText = '';
        if (!empty($data['content']) && is_array($data['content'])) {
            foreach ($data['content'] as $block) {
                if (($block['type'] ?? '') === 'text') {
                    $responseText .= $block['text'];
                }
            }
        }

        return [
            'ok'            => true,
            'response_text' => trim($responseText) ?: 'Request processed.',
            'mode'          => 'anthropic_api',
            'model'         => $data['model'] ?? $this->model,
            'provider'      => 'anthropic',
            'usage'         => $data['usage'] ?? null,
            'stop_reason'   => $data['stop_reason'] ?? null,
            'message_id'    => $data['id'] ?? null,
        ];
    }

    /**
     * Make the actual HTTP call to the Anthropic API.
     */
    private function callApi($body, $timeout) {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL            => $this->apiUrl,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($body),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => $timeout,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'x-api-key: ' . $this->apiKey,
                'anthropic-version: 2023-06-01',
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        @curl_close($ch);

        if ($curlError) {
            return ['ok' => false, 'error' => 'Network error: ' . $curlError, 'data' => null];
        }

        $decoded = json_decode($response, true);

        if ($httpCode !== 200 || !is_array($decoded)) {
            $errorMsg = 'API error (HTTP ' . $httpCode . ')';
            if (is_array($decoded) && !empty($decoded['error']['message'])) {
                $errorMsg = $decoded['error']['message'];
            } elseif (is_array($decoded) && !empty($decoded['error']['type'])) {
                $errorMsg = $decoded['error']['type'] . ': ' . ($decoded['error']['message'] ?? 'Unknown error');
            }
            return ['ok' => false, 'error' => $errorMsg, 'data' => $decoded];
        }

        return ['ok' => true, 'error' => null, 'data' => $decoded];
    }

    /**
     * Default system prompt for the CorpFile AI assistant.
     */
    private function defaultSystemPrompt() {
        return <<<'PROMPT'
You are CorpFile AI, an intelligent assistant embedded in CorpFile, a corporate secretarial management platform used by company secretaries and compliance professionals.

Your expertise includes:
- Company incorporation, registration, and corporate governance
- Annual returns, AGM filings, and compliance deadlines (especially Singapore ACRA)
- Director and shareholder management, share transfers, and allotments
- KYC/AML screening, Customer Due Diligence (CDD), and PEP checks
- Corporate document generation: resolutions, minutes, statutory forms
- IR8A tax filing, Singapore payroll (CPF, SDL, FWL), and IRAS deadlines
- Invoice generation and fee management for secretarial services
- Company event tracking (FYE changes, striking off, dormancy)

Guidelines:
- Be concise, professional, and action-oriented
- When discussing Singapore regulations, cite the Companies Act (Cap. 50) or relevant ACRA/IRAS guidelines
- Use structured formatting: headers, bullet points, numbered steps
- If you don't have enough information, ask clarifying questions
- Never fabricate company data, filing numbers, or regulatory references
- When asked to generate documents, provide the full text content ready to use
- For compliance checks, clearly state what is compliant and what needs attention
PROMPT;
    }
}
