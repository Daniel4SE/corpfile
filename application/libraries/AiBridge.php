<?php
/**
 * AiBridge
 *
 * Calls the Anthropic Claude Messages API directly via HTTP.
 * Supports Tool Use (function calling) for browser automation.
 * No CLI dependency — works anywhere PHP + curl are available.
 */
class AiBridge {
    private $apiKey;
    private $apiUrl;
    private $model;
    private $systemPrompt;
    private $maxToolIterations = 8;

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
     * Original simple text-only method (backward compatible).
     */
    public function runTurn($message, $options = []) {
        if (empty($this->apiKey)) {
            return ['ok' => false, 'error' => 'AI_API_KEY not configured. Please set the AI_API_KEY environment variable.'];
        }

        $maxTokens   = (int) ($options['max_tokens']   ?? 2048);
        $temperature = (float) ($options['temperature'] ?? 0.4);
        $timeout     = (int) ($options['timeout']       ?? 90);
        $timeout     = max(15, min($timeout, 300));

        $messages = $this->buildMessages($message, $options);

        if (empty($messages)) {
            return ['ok' => false, 'error' => 'Prompt is required.'];
        }

        $systemPrompt = $options['system_prompt'] ?? $this->systemPrompt;
        $model = $options['model'] ?? $this->model;

        $body = [
            'model'      => $model,
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
        $responseText = $this->extractText($data);

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
     * Send a message with Tool Use support.
     * Handles the full tool_use → execute → tool_result → repeat loop.
     *
     * @param string|array $message     User message
     * @param array $tools              Tool definitions (Claude API format)
     * @param callable $toolExecutor    function(string $toolName, array $input): array
     * @param array $options            Same as runTurn + 'tool_choice'
     * @return array                    ['ok', 'response_text', 'tool_calls' => [...], ...]
     */
    public function runTurnWithTools($message, $tools, callable $toolExecutor, $options = []) {
        if (empty($this->apiKey)) {
            return ['ok' => false, 'error' => 'AI_API_KEY not configured.'];
        }

        $maxTokens   = (int) ($options['max_tokens']   ?? 4096);
        $temperature = (float) ($options['temperature'] ?? 0.3);
        $timeout     = (int) ($options['timeout']       ?? 120);
        $timeout     = max(15, min($timeout, 300));

        $messages = $this->buildMessages($message, $options);
        if (empty($messages)) {
            return ['ok' => false, 'error' => 'Prompt is required.'];
        }

        $systemPrompt = $options['system_prompt'] ?? $this->systemPrompt;
        $model = $options['model'] ?? $this->model;

        $allToolCalls = [];
        $totalUsage = ['input_tokens' => 0, 'output_tokens' => 0];

        for ($iteration = 0; $iteration < $this->maxToolIterations; $iteration++) {
            $body = [
                'model'      => $model,
                'max_tokens' => $maxTokens,
                'temperature'=> $temperature,
                'system'     => $systemPrompt,
                'messages'   => $messages,
                'tools'      => $tools,
            ];

            if (!empty($options['tool_choice'])) {
                $body['tool_choice'] = $options['tool_choice'];
            }

            $result = $this->callApi($body, $timeout);

            if (!$result['ok']) {
                return [
                    'ok' => false,
                    'error' => $result['error'],
                    'response_text' => null,
                    'tool_calls' => $allToolCalls,
                    'iterations' => $iteration,
                ];
            }

            $data = $result['data'];
            $stopReason = $data['stop_reason'] ?? null;

            if (!empty($data['usage'])) {
                $totalUsage['input_tokens']  += $data['usage']['input_tokens'] ?? 0;
                $totalUsage['output_tokens'] += $data['usage']['output_tokens'] ?? 0;
            }

            if ($stopReason === 'tool_use') {
                // Fix empty input objects: PHP json_decode turns {} into [] (array),
                // but Claude API requires {} (object). Convert empty arrays to stdClass.
                $fixedContent = array_map(function ($block) {
                    if (($block['type'] ?? '') === 'tool_use' && isset($block['input']) && is_array($block['input']) && empty($block['input'])) {
                        $block['input'] = new \stdClass();
                    }
                    return $block;
                }, $data['content']);

                $messages[] = [
                    'role'    => 'assistant',
                    'content' => $fixedContent,
                ];

                $toolResults = [];
                foreach ($data['content'] as $block) {
                    if (($block['type'] ?? '') !== 'tool_use') continue;

                    $toolName  = $block['name'];
                    $toolInput = $block['input'] ?? [];
                    $toolId    = $block['id'];

                    $allToolCalls[] = [
                        'iteration' => $iteration,
                        'tool'      => $toolName,
                        'input'     => $toolInput,
                        'id'        => $toolId,
                    ];

                    try {
                        $execResult = $toolExecutor($toolName, $toolInput);
                        $toolResults[] = [
                            'type'        => 'tool_result',
                            'tool_use_id' => $toolId,
                            'content'     => is_array($execResult) ? json_encode($execResult) : (string)$execResult,
                        ];

                        $lastIdx = count($allToolCalls) - 1;
                        $allToolCalls[$lastIdx]['result'] = $execResult;
                        $allToolCalls[$lastIdx]['ok'] = true;
                    } catch (\Throwable $e) {
                        $toolResults[] = [
                            'type'        => 'tool_result',
                            'tool_use_id' => $toolId,
                            'content'     => json_encode(['error' => $e->getMessage()]),
                            'is_error'    => true,
                        ];

                        $lastIdx = count($allToolCalls) - 1;
                        $allToolCalls[$lastIdx]['error'] = $e->getMessage();
                        $allToolCalls[$lastIdx]['ok'] = false;
                    }
                }

                $messages[] = [
                    'role'    => 'user',
                    'content' => $toolResults,
                ];

                continue;
            }

            $responseText = $this->extractText($data);

            return [
                'ok'            => true,
                'response_text' => trim($responseText) ?: 'Request processed.',
                'mode'          => 'anthropic_api_tools',
                'model'         => $data['model'] ?? $this->model,
                'provider'      => 'anthropic',
                'usage'         => $totalUsage,
                'stop_reason'   => $stopReason,
                'message_id'    => $data['id'] ?? null,
                'tool_calls'    => $allToolCalls,
                'iterations'    => $iteration + 1,
            ];
        }

        return [
            'ok'            => false,
            'error'         => 'Max tool iterations reached (' . $this->maxToolIterations . ')',
            'response_text' => null,
            'tool_calls'    => $allToolCalls,
            'iterations'    => $this->maxToolIterations,
        ];
    }

    private function buildMessages($message, $options) {
        $messages = [];
        if (!empty($options['messages']) && is_array($options['messages'])) {
            foreach ($options['messages'] as $msg) {
                $messages[] = [
                    'role'    => $msg['role'] ?? 'user',
                    'content' => $msg['content'] ?? '',
                ];
            }
        } elseif (!empty($options['context']) && is_array($options['context'])) {
            foreach ($options['context'] as $msg) {
                $messages[] = [
                    'role'    => $msg['role'] ?? 'user',
                    'content' => $msg['content'] ?? '',
                ];
            }
        }

        if (is_array($message)) {
            $messages[] = ['role' => 'user', 'content' => $message];
        } else {
            $message = trim((string) ($message ?? ''));
            if ($message !== '') {
                $messages[] = ['role' => 'user', 'content' => $message];
            }
        }

        return $messages;
    }

    private function extractText($data) {
        $text = '';
        if (!empty($data['content']) && is_array($data['content'])) {
            foreach ($data['content'] as $block) {
                if (($block['type'] ?? '') === 'text') {
                    $text .= $block['text'];
                }
            }
        }
        return $text;
    }

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

You also have access to browser automation tools. When users ask you to look up information from websites (like ACRA BizFile+, IRAS, MOM), search the web, or interact with online services, you can use the available tools to navigate, scrape, screenshot, and interact with web pages. Use these tools proactively when web information would help answer the user's question.

Guidelines:
- Be concise, professional, and action-oriented
- When discussing Singapore regulations, cite the Companies Act (Cap. 50) or relevant ACRA/IRAS guidelines
- Use structured formatting: headers, bullet points, numbered steps
- If you don't have enough information, ask clarifying questions
- Never fabricate company data, filing numbers, or regulatory references
- When asked to generate documents, provide the full text content ready to use
- For compliance checks, clearly state what is compliant and what needs attention
- When using browser tools, summarize the findings clearly — don't dump raw HTML
PROMPT;
    }
}
