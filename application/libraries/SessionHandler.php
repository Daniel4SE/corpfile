<?php
/**
 * Database Session Handler
 * Stores PHP sessions in MySQL so they persist across Cloud Run instances.
 */
class DbSessionHandler implements SessionHandlerInterface {
    private $pdo;
    private $lifetime;

    public function __construct(PDO $pdo, int $lifetime = 7200) {
        $this->pdo      = $pdo;
        $this->lifetime = $lifetime;
    }

    public function open(string $path, string $name): bool { return true; }
    public function close(): bool { return true; }

    public function read(string $id): string {
        $stmt = $this->pdo->prepare(
            "SELECT session_data FROM php_sessions WHERE session_id = ? AND session_expiry > ?"
        );
        $stmt->execute([$id, time()]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['session_data'] : '';
    }

    public function write(string $id, string $data): bool {
        $expiry = time() + $this->lifetime;
        $stmt = $this->pdo->prepare(
            "INSERT INTO php_sessions (session_id, session_data, session_expiry)
             VALUES (?, ?, ?)
             ON DUPLICATE KEY UPDATE session_data = VALUES(session_data), session_expiry = VALUES(session_expiry)"
        );
        return $stmt->execute([$id, $data, $expiry]);
    }

    public function destroy(string $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM php_sessions WHERE session_id = ?");
        return $stmt->execute([$id]);
    }

    public function gc(int $max_lifetime): int|false {
        $stmt = $this->pdo->prepare("DELETE FROM php_sessions WHERE session_expiry < ?");
        $stmt->execute([time()]);
        return $stmt->rowCount();
    }
}
