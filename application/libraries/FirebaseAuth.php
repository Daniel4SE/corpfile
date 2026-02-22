<?php
/**
 * Firebase ID Token Verifier
 * Verifies Firebase Authentication ID tokens without third-party dependencies.
 * Uses Google's public keys to verify JWT RS256 signatures.
 */
class FirebaseAuth {

    private static $certsUrl = 'https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com';
    private static $certs = null;
    private static $certsExpiry = 0;

    /**
     * Verify a Firebase ID token and return the decoded payload.
     * Returns null if verification fails.
     */
    public static function verifyIdToken(string $idToken, string $projectId): ?object {
        // 1. Decode JWT parts
        $parts = explode('.', $idToken);
        if (count($parts) !== 3) return null;

        [$headerB64, $payloadB64, $signatureB64] = $parts;

        $header = json_decode(self::base64UrlDecode($headerB64));
        $payload = json_decode(self::base64UrlDecode($payloadB64));
        $signature = self::base64UrlDecode($signatureB64);

        if (!$header || !$payload || !$signature) return null;

        // 2. Check header algorithm
        if (($header->alg ?? '') !== 'RS256') return null;

        $kid = $header->kid ?? '';
        if (!$kid) return null;

        // 3. Check payload claims
        $now = time();

        // Issuer must match
        if (($payload->iss ?? '') !== "https://securetoken.google.com/{$projectId}") return null;

        // Audience must match
        if (($payload->aud ?? '') !== $projectId) return null;

        // Token must not be expired (with 5 min grace)
        if (($payload->exp ?? 0) < $now - 300) return null;

        // Token must have been issued in the past (with 5 min grace)
        if (($payload->iat ?? 0) > $now + 300) return null;

        // Subject (user ID) must be non-empty
        if (empty($payload->sub)) return null;

        // 4. Verify signature using Google's public certs
        $certs = self::fetchCerts();
        if (!$certs || !isset($certs[$kid])) return null;

        $publicKey = openssl_pkey_get_public($certs[$kid]);
        if (!$publicKey) return null;

        $dataToVerify = $headerB64 . '.' . $payloadB64;
        $verified = openssl_verify($dataToVerify, $signature, $publicKey, OPENSSL_ALGO_SHA256);

        if ($verified !== 1) return null;

        return $payload;
    }

    /**
     * Fetch Google's public certs (cached in memory and respects Cache-Control).
     */
    private static function fetchCerts(): ?array {
        if (self::$certs && time() < self::$certsExpiry) {
            return self::$certs;
        }

        $context = stream_context_create([
            'http' => ['timeout' => 10],
            'ssl'  => ['verify_peer' => true],
        ]);

        $response = @file_get_contents(self::$certsUrl, false, $context);
        if (!$response) return self::$certs; // Return stale cache if fetch fails

        $certs = json_decode($response, true);
        if (!$certs) return self::$certs;

        // Parse max-age from response headers
        $maxAge = 3600; // default 1 hour
        foreach ($http_response_header ?? [] as $h) {
            if (preg_match('/max-age=(\d+)/', $h, $m)) {
                $maxAge = (int)$m[1];
                break;
            }
        }

        self::$certs = $certs;
        self::$certsExpiry = time() + $maxAge;

        return self::$certs;
    }

    /**
     * Base64URL decode (JWT uses URL-safe base64 without padding).
     */
    private static function base64UrlDecode(string $input): string {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $input .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }
}
