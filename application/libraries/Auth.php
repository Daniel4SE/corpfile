<?php
/**
 * Authentication Library
 */
class Auth {

    private static $cookieName = 'cf_auth';
    private static $secret     = 'CorpFile_secret_key_2024_xK9mPqRs';
    private static $ttl        = 7200;

    // ── Cookie helpers ──────────────────────────────────────────────

    private static function makeCookieValue(array $data): string {
        $payload = base64_encode(json_encode($data));
        $sig     = hash_hmac('sha256', $payload, self::$secret);
        return $payload . '.' . $sig;
    }

    private static function parseCookie(): ?array {
        $raw = $_COOKIE[self::$cookieName] ?? '';
        if (!$raw) return null;
        $parts = explode('.', $raw, 2);
        if (count($parts) !== 2) return null;
        [$payload, $sig] = $parts;
        if (!hash_equals(hash_hmac('sha256', $payload, self::$secret), $sig)) return null;
        $data = json_decode(base64_decode($payload), true);
        if (!$data || ($data['exp'] ?? 0) < time()) return null;
        return $data;
    }

    private static function setCookie(array $data): void {
        $data['exp'] = time() + self::$ttl;
        setcookie(self::$cookieName, self::makeCookieValue($data), [
            'expires'  => time() + self::$ttl,
            'path'     => '/',
            'secure'   => true,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        // Also populate $_COOKIE for the current request
        $_COOKIE[self::$cookieName] = self::makeCookieValue($data);
    }

    // ── Public API ──────────────────────────────────────────────────

    public static function login($userId, $username, $name, $email, $role, $clientId) {
        $data = [
            'user_id'   => $userId,
            'username'  => $username,
            'user_name' => $name,
            'user_email'=> $email,
            'user_role' => $role,
            'client_id' => $clientId,
        ];
        // Session (best-effort)
        $_SESSION['user_id']    = $userId;
        $_SESSION['username']   = $username;
        $_SESSION['user_name']  = $name;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_role']  = $role;
        $_SESSION['client_id']  = $clientId;
        $_SESSION['login_time'] = time();
        // Signed cookie (works across Cloud Run instances)
        self::setCookie($data);
    }

    public static function logout() {
        session_unset();
        session_destroy();
        setcookie(self::$cookieName, '', ['expires' => time() - 3600, 'path' => '/', 'secure' => true, 'httponly' => true, 'samesite' => 'Lax']);
        unset($_COOKIE[self::$cookieName]);
    }

    public static function check(): bool {
        if (isset($_SESSION['user_id'])) return true;
        // Restore session from cookie
        $data = self::parseCookie();
        if (!$data) return false;
        $_SESSION['user_id']    = $data['user_id'];
        $_SESSION['username']   = $data['username'];
        $_SESSION['user_name']  = $data['user_name'];
        $_SESSION['user_email'] = $data['user_email'];
        $_SESSION['user_role']  = $data['user_role'];
        $_SESSION['client_id']  = $data['client_id'];
        return true;
    }

    public static function user() {
        if (!self::check()) return null;
        return (object)[
            'id'        => $_SESSION['user_id'],
            'username'  => $_SESSION['username'],
            'name'      => $_SESSION['user_name'],
            'email'     => $_SESSION['user_email'],
            'role'      => $_SESSION['user_role'],
            'client_id' => $_SESSION['client_id'],
        ];
    }
    
    public static function isAdmin() {
        return ($_SESSION['user_role'] ?? '') === 'admin';
    }
    
    public static function hasRole($role) {
        return ($_SESSION['user_role'] ?? '') === $role;
    }
    
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
    
    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
}
