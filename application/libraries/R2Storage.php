<?php

class R2Storage {
    private $endpoint;
    private $bucket;
    private $accessKey;
    private $secretKey;
    private $publicUrl;
    private $region = 'auto';
    private $service = 's3';

    public function __construct() {
        $this->endpoint = rtrim((string) getenv('R2_ENDPOINT'), '/');
        $this->bucket = trim((string) getenv('R2_BUCKET'));
        $this->accessKey = trim((string) getenv('R2_ACCESS_KEY_ID'));
        $this->secretKey = trim((string) getenv('R2_SECRET_ACCESS_KEY'));
        $this->publicUrl = rtrim(trim((string) getenv('R2_PUBLIC_URL')), '/');
    }

    public function isConfigured() {
        return $this->endpoint !== ''
            && $this->bucket !== ''
            && $this->accessKey !== ''
            && $this->secretKey !== '';
    }

    public function upload($key, $filePath, $contentType = 'application/octet-stream') {
        if (!$this->isConfigured() || !is_file($filePath)) {
            return false;
        }

        $body = file_get_contents($filePath);
        if ($body === false) {
            return false;
        }

        $response = $this->request('PUT', $key, $body, [
            'content-type' => $contentType ?: 'application/octet-stream',
        ]);

        return $response['ok'];
    }

    public function download($key) {
        if (!$this->isConfigured()) {
            return false;
        }

        $response = $this->request('GET', $key);
        if (!$response['ok']) {
            return false;
        }

        return $response['body'];
    }

    public function getUrl($key) {
        if (!$this->isConfigured() || $this->publicUrl === '') {
            return null;
        }

        return $this->publicUrl . '/' . $this->encodeObjectKey($key);
    }

    public function delete($key) {
        if (!$this->isConfigured()) {
            return false;
        }

        $response = $this->request('DELETE', $key);
        return $response['status'] === 204 || $response['status'] === 200;
    }

    public function exists($key) {
        if (!$this->isConfigured()) {
            return false;
        }

        $response = $this->request('HEAD', $key);
        return $response['status'] === 200;
    }

    private function request($method, $key, $body = '', $extraHeaders = []) {
        $parsed = parse_url($this->endpoint);
        if (!$parsed || empty($parsed['host']) || empty($parsed['scheme'])) {
            return ['ok' => false, 'status' => 0, 'body' => null];
        }

        $host = $parsed['host'];
        $amzDate = gmdate('Ymd\\THis\\Z');
        $dateStamp = gmdate('Ymd');
        $canonicalUri = '/' . $this->bucket . '/' . $this->encodeObjectKey($key);
        $queryString = '';

        $payload = is_string($body) ? $body : '';
        $payloadHash = hash('sha256', $payload);

        $headers = [
            'host' => $host,
            'x-amz-content-sha256' => $payloadHash,
            'x-amz-date' => $amzDate,
        ];

        foreach ($extraHeaders as $name => $value) {
            if ($value === null || $value === '') {
                continue;
            }
            $headers[strtolower($name)] = trim((string) $value);
        }

        ksort($headers);
        $canonicalHeaders = '';
        foreach ($headers as $name => $value) {
            $canonicalHeaders .= $name . ':' . preg_replace('/\\s+/', ' ', trim($value)) . "\n";
        }
        $signedHeaders = implode(';', array_keys($headers));

        $canonicalRequest = implode("\n", [
            $method,
            $canonicalUri,
            $queryString,
            $canonicalHeaders,
            $signedHeaders,
            $payloadHash,
        ]);

        $algorithm = 'AWS4-HMAC-SHA256';
        $credentialScope = $dateStamp . '/' . $this->region . '/' . $this->service . '/aws4_request';
        $stringToSign = implode("\n", [
            $algorithm,
            $amzDate,
            $credentialScope,
            hash('sha256', $canonicalRequest),
        ]);

        $signingKey = $this->getSignatureKey($this->secretKey, $dateStamp, $this->region, $this->service);
        $signature = hash_hmac('sha256', $stringToSign, $signingKey);

        $authorization = $algorithm
            . ' Credential=' . $this->accessKey . '/' . $credentialScope
            . ', SignedHeaders=' . $signedHeaders
            . ', Signature=' . $signature;

        $url = $parsed['scheme'] . '://' . $host . $canonicalUri;
        $curlHeaders = [];
        foreach ($headers as $name => $value) {
            $curlHeaders[] = $this->formatHeaderName($name) . ': ' . $value;
        }
        $curlHeaders[] = 'Authorization: ' . $authorization;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $curlHeaders);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        if ($method === 'PUT') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        }

        $responseBody = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $ok = $status >= 200 && $status < 300;

        return [
            'ok' => $ok,
            'status' => $status,
            'body' => $responseBody,
        ];
    }

    private function encodeObjectKey($key) {
        $segments = explode('/', ltrim((string) $key, '/'));
        $encoded = array_map('rawurlencode', $segments);
        return implode('/', $encoded);
    }

    private function getSignatureKey($secretKey, $dateStamp, $regionName, $serviceName) {
        $kDate = hash_hmac('sha256', $dateStamp, 'AWS4' . $secretKey, true);
        $kRegion = hash_hmac('sha256', $regionName, $kDate, true);
        $kService = hash_hmac('sha256', $serviceName, $kRegion, true);
        return hash_hmac('sha256', 'aws4_request', $kService, true);
    }

    private function formatHeaderName($name) {
        $parts = explode('-', strtolower($name));
        $parts = array_map(function ($part) {
            return ucfirst($part);
        }, $parts);
        return implode('-', $parts);
    }
}
