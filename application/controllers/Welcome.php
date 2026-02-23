<?php
/**
 * Welcome Controller - Login / Logout / Forgot Password
 */
class Welcome extends BaseController {

    private function getDefaultClientId(): string {
        if ($this->db) {
            $client = $this->db->fetchOne(
                "SELECT client_id FROM clients WHERE status = 1 ORDER BY id ASC LIMIT 1"
            );
            if ($client && !empty($client->client_id)) {
                return (string)$client->client_id;
            }
        }
        return 'SG123';
    }

    private function resolveLoginClient(string $rawClientId): ?object {
        if (!$this->db) {
            return null;
        }

        $normalizedClientId = strtoupper(str_replace(' ', '', trim($rawClientId)));
        if ($normalizedClientId !== '') {
            $matched = $this->db->fetchOne(
                "SELECT id, client_id
                 FROM clients
                 WHERE status = 1
                   AND REPLACE(UPPER(client_id), ' ', '') = ?
                 LIMIT 1",
                [$normalizedClientId]
            );
            if ($matched) {
                return $matched;
            }
        }

        // Demo-safe fallback: if only one active client exists, use it.
        $activeClients = $this->db->fetchAll(
            "SELECT id, client_id FROM clients WHERE status = 1 ORDER BY id ASC LIMIT 2"
        );
        if (count($activeClients) === 1) {
            return $activeClients[0];
        }

        return null;
    }
    
    public function index() {
        if (Auth::check()) {
            $this->redirect('dashboard');
        }
        $this->data['default_client_id'] = $this->getDefaultClientId();
        $this->view('auth/login', $this->data);
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('welcome');
            return;
        }

        $formClientId = trim($_POST['client_id'] ?? '');
        $formUsername  = trim($_POST['uname'] ?? '');
        $formPassword  = $_POST['upsd'] ?? '';
        $lookupUser = strtolower($formUsername);

        // Validation
        if (!$formClientId || !$formUsername || !$formPassword) {
            $this->data['error_message'] = 'Please fill in all fields.';
            $this->data['default_client_id'] = $this->getDefaultClientId();
            $this->view('auth/login', $this->data);
            return;
        }

        $user = null;
        $resolvedClient = null;

        if ($this->db) {
            $resolvedClient = $this->resolveLoginClient($formClientId);
            if ($resolvedClient && $lookupUser !== '') {
                $user = $this->db->fetchOne(
                    "SELECT u.*, c.client_id as company_code
                     FROM users u JOIN clients c ON c.id = u.client_id
                     WHERE u.client_id = ?
                       AND u.status = 1
                       AND (
                            LOWER(TRIM(u.username)) = ?
                            OR LOWER(TRIM(COALESCE(u.email, ''))) = ?
                       )
                     LIMIT 1",
                    [$resolvedClient->id, $lookupUser, $lookupUser]
                );
            }
        }

        // Verify password
        if ($user && Auth::verifyPassword($formPassword, $user->password)) {
            Auth::login($user->id, $user->username, $user->name, $user->email, $user->role, $user->company_code);
            $this->db->update('users', ['last_login' => date('Y-m-d H:i:s')], 'id = ?', [$user->id]);
            $this->redirect('dashboard');
            return;
        }

        // Login failed — keep extra details in development only.
        $dbStatus = $this->db ? 'connected' : 'NULL';
        $resolvedClientCode = $resolvedClient->client_id ?? 'no-match';
        $userFound = $user ? 'yes(id=' . $user->id . ')' : 'no';
        $pwdOk = ($user && Auth::verifyPassword($formPassword, $user->password)) ? 'yes' : 'no';
        $this->data['default_client_id'] = $this->getDefaultClientId();
        $this->data['error_message'] = "Invalid Company ID, username, or password.";
        if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
            $debug = "DB:{$dbStatus} | InputClient:'{$formClientId}' | ResolvedClient:'{$resolvedClientCode}' | User:'{$formUsername}' | Found:{$userFound} | PwdOk:{$pwdOk}";
            $this->data['error_message'] .= " [{$debug}]";
        }
        $this->view('auth/login', $this->data);
    }
    
    /**
     * Firebase Authentication endpoint.
     * Receives a Firebase ID token from the frontend JS SDK,
     * verifies it server-side, and creates a local session.
     */
    public function firebase_login() {
        // Always return JSON — catch any PHP error before headers are sent
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        header('Content-Type: application/json');

        try {

        $input = json_decode(file_get_contents('php://input'), true);
        $idToken = $input['id_token'] ?? '';

        if (!$idToken) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing id_token']);
            return;
        }

        // Verify the Firebase ID token
        $projectId = config_item('firebase')['projectId'] ?? '';
        $payload = FirebaseAuth::verifyIdToken($idToken, $projectId);

        if (!$payload) {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid or expired token']);
            return;
        }

        $firebaseUid = $payload->sub;
        $email = $payload->email ?? '';
        $name = $payload->name ?? ($email ? explode('@', $email)[0] : 'User');
        $picture = $payload->picture ?? '';

        // Try to find an existing user linked to this Firebase UID
        $user = null;
        if ($this->db) {
            // 1. Check oauth_users table for existing link
            $oauth = $this->db->fetchOne(
                "SELECT u.*, c.client_id as company_code
                 FROM oauth_users ou
                 JOIN users u ON u.id = ou.user_id
                 JOIN clients c ON c.id = u.client_id
                 WHERE ou.provider = 'google' AND ou.provider_uid = ? AND u.status = 1
                 LIMIT 1",
                [$firebaseUid]
            );

            if ($oauth) {
                $user = $oauth;
            } else {
                // 2. Try matching by email in existing users
                if ($email) {
                    $user = $this->db->fetchOne(
                        "SELECT u.*, c.client_id as company_code
                         FROM users u JOIN clients c ON c.id = u.client_id
                         WHERE u.email = ? AND u.status = 1
                         LIMIT 1",
                        [$email]
                    );
                }

                // 3. If no match, auto-create user under default client
                if (!$user) {
                    // Get default client (first active client)
                    $defaultClient = $this->db->fetchOne(
                        "SELECT id, client_id FROM clients WHERE status = 1 ORDER BY id LIMIT 1"
                    );
                    $clientDbId = $defaultClient ? $defaultClient->id : 1;

                    // Create user
                    $username = $email ? explode('@', $email)[0] : 'google_' . substr($firebaseUid, 0, 8);
                    // Ensure unique username
                    $existing = $this->db->fetchOne(
                        "SELECT id FROM users WHERE client_id = ? AND username = ?",
                        [$clientDbId, $username]
                    );
                    if ($existing) {
                        $username .= '_' . substr(md5($firebaseUid), 0, 4);
                    }

                    $this->db->insert('users', [
                        'client_id'     => $clientDbId,
                        'username'      => $username,
                        'password'      => password_hash(bin2hex(random_bytes(16)), PASSWORD_BCRYPT),
                        'name'          => $name,
                        'email'         => $email,
                        'role'          => 'user',
                        'profile_image' => $picture,
                        'status'        => 1,
                    ]);
                    $newUserId = $this->db->lastInsertId();

                    $user = $this->db->fetchOne(
                        "SELECT u.*, c.client_id as company_code
                         FROM users u JOIN clients c ON c.id = u.client_id
                         WHERE u.id = ?",
                        [$newUserId]
                    );
                }

                // Link Firebase UID to local user for future logins
                if ($user) {
                    try {
                        $this->db->insert('oauth_users', [
                            'user_id'      => $user->id,
                            'provider'     => 'google',
                            'provider_uid' => $firebaseUid,
                            'email'        => $email,
                            'name'         => $name,
                            'avatar'       => $picture,
                        ]);
                    } catch (Exception $e) {
                        // Link may already exist, ignore
                    }
                }
            }

            if ($user) {
                Auth::login($user->id, $user->username, $user->name, $user->email ?? $email, $user->role, $user->company_code);
                $this->db->update('users', ['last_login' => date('Y-m-d H:i:s')], 'id = ?', [$user->id]);
                echo json_encode(['success' => true, 'redirect' => base_url('dashboard')]);
                return;
            }
        }

        // Fallback: no DB, create session from Firebase data directly
        Auth::login(0, $email ?: 'google_user', $name, $email, 'user', 'DEMO');
        echo json_encode(['success' => true, 'redirect' => base_url('dashboard')]);

        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
        }
    }

    public function logout() {
        Auth::logout();
        $this->redirect('welcome');
    }
    
    public function forgot_password() {
        $this->view('auth/forgot_password', $this->data);
    }
}
