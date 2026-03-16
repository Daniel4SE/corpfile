<?php

class BrowserTools {
    private $serviceUrl;
    private $serviceKey;
    private $sessionId;
    private $timeout;

    public function __construct($options = []) {
        $this->serviceUrl = rtrim($options['service_url'] ?? getenv('BROWSER_SERVICE_URL') ?: 'http://localhost:3100', '/');
        $this->serviceKey = $options['service_key'] ?? getenv('BROWSER_SERVICE_KEY') ?: '';
        $this->sessionId  = $options['session_id'] ?? null;
        $this->timeout    = (int)($options['timeout'] ?? 35);
    }

    public function isAvailable() {
        $result = $this->callService('GET', '/health');
        return !empty($result['ok']);
    }

    public static function getToolDefinitions() {
        return [
            [
                'name' => 'browse_url',
                'description' => 'Navigate to a URL and retrieve the page text content. Use this to look up information from websites like ACRA BizFile+, IRAS, company registries, or any public webpage.',
                'input_schema' => [
                    'type' => 'object',
                    'properties' => [
                        'url' => ['type' => 'string', 'description' => 'Full URL including https://'],
                        'wait_for_selector' => ['type' => 'string', 'description' => 'CSS selector to wait for before extracting content'],
                    ],
                    'required' => ['url'],
                ],
            ],
            [
                'name' => 'screenshot',
                'description' => 'Take a screenshot of the current browser page. Returns a base64-encoded PNG image. Use after navigating to capture visual state.',
                'input_schema' => [
                    'type' => 'object',
                    'properties' => [
                        'full_page' => ['type' => 'boolean', 'description' => 'Capture full scrollable page (default: false, viewport only)'],
                        'selector' => ['type' => 'string', 'description' => 'CSS selector to screenshot a specific element'],
                    ],
                ],
            ],
            [
                'name' => 'get_content',
                'description' => 'Extract text or HTML from specific elements on the current page using CSS selectors.',
                'input_schema' => [
                    'type' => 'object',
                    'properties' => [
                        'selector' => ['type' => 'string', 'description' => 'CSS selector to target elements'],
                        'attribute' => ['type' => 'string', 'description' => 'What to extract: text (default), html, href, src, value'],
                        'multiple' => ['type' => 'boolean', 'description' => 'Return all matching elements as array'],
                    ],
                ],
            ],
            [
                'name' => 'click',
                'description' => 'Click on an element on the current page. Use CSS selector or match by visible text.',
                'input_schema' => [
                    'type' => 'object',
                    'properties' => [
                        'selector' => ['type' => 'string', 'description' => 'CSS selector of element to click'],
                        'text' => ['type' => 'string', 'description' => 'Visible text of button/link to click (alternative to selector)'],
                    ],
                ],
            ],
            [
                'name' => 'fill_form',
                'description' => 'Type text into a form input field on the current page.',
                'input_schema' => [
                    'type' => 'object',
                    'properties' => [
                        'selector' => ['type' => 'string', 'description' => 'CSS selector of the input field'],
                        'value' => ['type' => 'string', 'description' => 'Text to type into the field'],
                    ],
                    'required' => ['selector', 'value'],
                ],
            ],
            [
                'name' => 'get_links',
                'description' => 'Get all links on the current page, optionally filtered by text or URL pattern.',
                'input_schema' => [
                    'type' => 'object',
                    'properties' => [
                        'filter' => ['type' => 'string', 'description' => 'Filter links containing this text in label or URL'],
                    ],
                ],
            ],
            [
                'name' => 'get_page_info',
                'description' => 'Get current page metadata: title, URL, meta tags, form count, link count.',
                'input_schema' => [
                    'type' => 'object',
                    'properties' => new \stdClass(),
                ],
            ],
            [
                'name' => 'web_search',
                'description' => 'Search Google for a query. Navigates to Google, enters the search query, and returns the search results with titles, URLs, and snippets.',
                'input_schema' => [
                    'type' => 'object',
                    'properties' => [
                        'query' => ['type' => 'string', 'description' => 'Search query string'],
                    ],
                    'required' => ['query'],
                ],
            ],
            [
                'name' => 'scroll',
                'description' => 'Scroll the current page in a direction.',
                'input_schema' => [
                    'type' => 'object',
                    'properties' => [
                        'direction' => ['type' => 'string', 'description' => 'Scroll direction: down (default), up, left, right'],
                        'amount' => ['type' => 'number', 'description' => 'Pixels to scroll (default: 500)'],
                    ],
                ],
            ],
        ];
    }

    public function executeTool($toolName, $input) {
        switch ($toolName) {
            case 'browse_url':
                return $this->callTool('navigate', $input);

            case 'screenshot':
                $result = $this->callTool('screenshot', $input);
                if (!empty($result['result']['data'])) {
                    return [
                        'type' => 'image',
                        'data' => $result['result']['data'],
                        'mime' => $result['result']['mime'] ?? 'image/png',
                    ];
                }
                return $result;

            case 'get_content':
                return $this->callTool('get_content', $input);

            case 'click':
                return $this->callTool('click', $input);

            case 'fill_form':
                return $this->callTool('fill', $input);

            case 'get_links':
                return $this->callTool('get_links', $input);

            case 'get_page_info':
                return $this->callTool('get_page_info', $input);

            case 'scroll':
                return $this->callTool('scroll', $input);

            case 'web_search':
                return $this->webSearch($input['query'] ?? '');

            default:
                throw new \Exception("Unknown browser tool: {$toolName}");
        }
    }

    private function webSearch($query) {
        if (empty($query)) throw new \Exception('Search query is required');

        $this->callTool('navigate', [
            'url' => 'https://www.google.com/search?q=' . urlencode($query),
        ]);

        $result = $this->callTool('evaluate', [
            'script' => "(() => {
                const results = [];
                document.querySelectorAll('#search .g, #rso .g').forEach((el, i) => {
                    if (i >= 10) return;
                    const a = el.querySelector('a[href]');
                    const title = el.querySelector('h3');
                    const snippet = el.querySelector('.VwiC3b, [data-sncf], .s3v9rd');
                    if (a && title) {
                        results.push({
                            title: title.innerText,
                            url: a.href,
                            snippet: snippet ? snippet.innerText : ''
                        });
                    }
                });
                return JSON.stringify(results);
            })()"
        ]);

        $parsed = json_decode($result['result']['result'] ?? '[]', true);
        return ['query' => $query, 'results' => $parsed ?: [], 'count' => count($parsed ?: [])];
    }

    private function callTool($action, $params) {
        $body = [
            'action' => $action,
            'params' => $params ?: new \stdClass(),
        ];
        if ($this->sessionId) {
            $body['session_id'] = $this->sessionId;
        }

        $result = $this->callService('POST', '/api/tool', $body);

        if (empty($result['ok'])) {
            throw new \Exception('Browser tool failed: ' . ($result['error'] ?? 'Unknown error'));
        }

        return $result;
    }

    private function callService($method, $path, $body = null) {
        $ch = curl_init();

        $url = $this->serviceUrl . $path;
        $headers = ['Content-Type: application/json'];
        if ($this->serviceKey) {
            $headers[] = 'x-api-key: ' . $this->serviceKey;
        }

        $opts = [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_HTTPHEADER     => $headers,
        ];

        if ($method === 'POST' && $body !== null) {
            $opts[CURLOPT_POST] = true;
            $opts[CURLOPT_POSTFIELDS] = json_encode($body);
        } elseif ($method === 'DELETE') {
            $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
        }

        curl_setopt_array($ch, $opts);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        @curl_close($ch);

        if ($curlError) {
            return ['ok' => false, 'error' => 'Browser service unreachable: ' . $curlError];
        }

        $decoded = json_decode($response, true);
        if ($httpCode !== 200 || !is_array($decoded)) {
            return ['ok' => false, 'error' => 'Browser service error (HTTP ' . $httpCode . '): ' . substr($response, 0, 500)];
        }

        return $decoded;
    }

    public function destroySession() {
        if ($this->sessionId) {
            $this->callService('DELETE', '/api/session/' . urlencode($this->sessionId));
        }
    }
}
