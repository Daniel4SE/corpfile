<?php
/**
 * AiBridge
 *
 * Thin wrapper around the AI CLI so the PHP app can query runtime
 * status and execute grounded agent turns.
 */
class AiBridge {
    private $binary;
    private $stateDir;
    private $shellHome;
    private $path;

    public function __construct($options = []) {
        $this->binary = $options['binary'] ?? getenv('AI_BIN') ?: $this->detectBinary();
        $stateDir = $options['state_dir'] ?? getenv('AI_STATE_DIR') ?: $this->defaultStateDir();
        $this->stateDir = rtrim((string) $stateDir, '/');
        $this->shellHome = rtrim((string) (getenv('AI_HOME') ?: getenv('HOME') ?: dirname($this->stateDir)), '/');
        $this->path = getenv('PATH') ?: '/usr/local/bin:/usr/bin:/bin:/opt/homebrew/bin';
    }

    public function status() {
        if (!$this->binary) {
            return [
                'ready' => false,
                'cli_found' => false,
                'cli_version' => null,
                'mode' => 'unavailable',
                'gateway' => ['ok' => false],
                'local_fallback_ready' => !empty(getenv('OPENAI_API_KEY')),
                'error' => 'AI CLI not found in PATH.',
            ];
        }

        $versionResult = $this->runCommand([$this->binary, '--version']);
        $gateway = $this->probeGateway();
        $mode = $this->resolveExecMode($gateway);
        $localFallbackReady = !empty(getenv('OPENAI_API_KEY'));

        return [
            'ready' => $gateway['ok'] || $localFallbackReady,
            'cli_found' => true,
            'cli_version' => $versionResult['exit_code'] === 0 ? trim($versionResult['output']) : null,
            'mode' => $mode,
            'agent_id' => getenv('AI_AGENT_ID') ?: 'main',
            'gateway' => $gateway,
            'local_fallback_ready' => $localFallbackReady,
            'state_dir' => $this->stateDir,
            'error' => $gateway['ok'] || $localFallbackReady ? null : ($gateway['error'] ?: 'AI runtime is not available.'),
        ];
    }

    public function runTurn($message, $options = []) {
        $message = trim((string) $message);
        if ($message === '') {
            return [
                'ok' => false,
                'error' => 'Prompt is required.',
            ];
        }

        if (!$this->binary) {
            return [
                'ok' => false,
                'error' => 'AI CLI not found in PATH.',
            ];
        }

        $gateway = $this->probeGateway();
        $mode = $options['mode'] ?? $this->resolveExecMode($gateway);
        $agentId = (string) ($options['agent_id'] ?? getenv('AI_AGENT_ID') ?: 'main');
        $thinking = (string) ($options['thinking'] ?? 'minimal');
        $timeout = (int) ($options['timeout'] ?? getenv('AI_TIMEOUT') ?: 90);
        $timeout = max(15, min($timeout, 600));

        $command = [$this->binary, 'agent'];
        if ($mode === 'local') {
            $command[] = '--local';
        } else {
            $command[] = '--agent';
            $command[] = $agentId;
        }

        $command[] = '--message';
        $command[] = $message;
        $command[] = '--thinking';
        $command[] = $thinking;
        $command[] = '--timeout';
        $command[] = (string) $timeout;
        $command[] = '--json';

        $result = $this->runCommand($command);
        $decoded = json_decode($result['output'], true);

        if ($result['exit_code'] !== 0 || !is_array($decoded)) {
            if ($mode === 'gateway' && $this->canUseLocalFallback()) {
                $fallbackOptions = $options;
                $fallbackOptions['mode'] = 'local';
                $fallbackResult = $this->runTurn($message, $fallbackOptions);
                if (!empty($fallbackResult['ok'])) {
                    return $fallbackResult;
                }
            }

            return [
                'ok' => false,
                'mode' => $mode,
                'agent_id' => $mode === 'local' ? 'embedded' : $agentId,
                'raw_output' => $result['output'],
                'error' => $this->extractErrorMessage($result['output'], $result['exit_code']),
            ];
        }

        $payloads = $decoded['result']['payloads'] ?? [];
        $meta = $decoded['result']['meta'] ?? [];

        return [
            'ok' => true,
            'mode' => $mode,
            'agent_id' => $mode === 'local' ? 'embedded' : $agentId,
            'response_text' => $this->extractPayloadText($payloads),
            'session_id' => $meta['agentMeta']['sessionId'] ?? null,
            'model' => $meta['agentMeta']['model'] ?? null,
            'provider' => $meta['agentMeta']['provider'] ?? null,
            'duration_ms' => $meta['durationMs'] ?? null,
            'usage' => $meta['agentMeta']['usage'] ?? null,
            'raw' => $decoded,
        ];
    }

    private function resolveExecMode($gateway) {
        $configured = strtolower((string) (getenv('AI_EXEC_MODE') ?: 'auto'));
        if ($configured === 'gateway' || $configured === 'local') {
            return $configured;
        }

        if (!empty($gateway['ok'])) {
            return 'gateway';
        }

        return 'local';
    }

    private function probeGateway() {
        $result = $this->runCommand([$this->binary, 'gateway', 'status', '--json']);
        $decoded = json_decode($result['output'], true);

        if ($result['exit_code'] !== 0 || !is_array($decoded)) {
            return [
                'ok' => false,
                'error' => $this->extractErrorMessage($result['output'], $result['exit_code']),
            ];
        }

        return [
            'ok' => !empty($decoded['rpc']['ok']),
            'port' => $decoded['gateway']['port'] ?? null,
            'bind_host' => $decoded['gateway']['bindHost'] ?? null,
            'probe_url' => $decoded['gateway']['probeUrl'] ?? null,
            'service_loaded' => $decoded['service']['loaded'] ?? null,
            'runtime_status' => $decoded['service']['runtime']['status'] ?? null,
            'issues' => $decoded['service']['configAudit']['issues'] ?? [],
            'raw' => $decoded,
            'error' => !empty($decoded['rpc']['ok']) ? null : 'Gateway RPC probe failed.',
        ];
    }

    private function extractPayloadText($payloads) {
        if (!is_array($payloads) || empty($payloads)) {
            return '';
        }

        $texts = [];
        foreach ($payloads as $payload) {
            $text = trim((string) ($payload['text'] ?? ''));
            if ($text !== '') {
                $texts[] = $text;
            }
        }

        return trim(implode("\n\n", $texts));
    }

    private function extractErrorMessage($output, $exitCode) {
        $output = trim((string) $output);
        if ($output !== '') {
            return $output;
        }

        return 'AI command failed with exit code ' . (int) $exitCode . '.';
    }

    private function detectBinary() {
        // Try to find any AI CLI in PATH
        foreach (['corpfile-ai', 'ai-agent'] as $name) {
            $binary = trim((string) @shell_exec('command -v ' . $name . ' 2>/dev/null'));
            if ($binary !== '') {
                return $binary;
            }
        }

        return null;
    }

    private function defaultStateDir() {
        $home = getenv('HOME');
        if ($home) {
            return $home . '/.corpfile-ai';
        }

        return sys_get_temp_dir() . '/.corpfile-ai';
    }

    private function canUseLocalFallback() {
        return !empty(getenv('OPENAI_API_KEY'));
    }

    private function runCommand($commandParts) {
        $escaped = [];
        foreach ($commandParts as $part) {
            $escaped[] = escapeshellarg((string) $part);
        }

        $envPrefix = sprintf(
            'HOME=%s AI_STATE_DIR=%s PATH=%s',
            escapeshellarg($this->shellHome),
            escapeshellarg($this->stateDir),
            escapeshellarg($this->path)
        );
        $command = $envPrefix . ' ' . implode(' ', $escaped) . ' 2>&1';

        $outputLines = [];
        $exitCode = 0;
        @exec($command, $outputLines, $exitCode);

        return [
            'exit_code' => (int) $exitCode,
            'output' => trim(implode("\n", $outputLines)),
            'command' => $command,
        ];
    }
}
