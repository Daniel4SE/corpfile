<?php
/**
 * Base Controller
 */
class BaseController {
    protected $db;
    protected $data = [];
    
    public function __construct() {
        try {
            $this->db = Database::getInstance();
        } catch (Exception $e) {
            // Database may not be set up yet
            $this->db = null;
        }
        
        // Set common view data
        $this->data['base_url'] = config_item('base_url');
        $this->data['site_title'] = config_item('site_title');
        $this->data['csrf_token'] = $this->generateCsrfToken();
        $this->data['current_user'] = $this->getCurrentUser();
    }
    
    protected function view($viewPath, $data = []) {
        $data = array_merge($this->data, $data);
        extract($data);
        
        $file = APPPATH . 'views/' . $viewPath . '.php';
        if (file_exists($file)) {
            ob_start();
            include $file;
            echo ob_get_clean();
        } else {
            echo "View not found: {$viewPath}";
        }
    }
    
    protected function loadLayout($viewPath, $data = []) {
        $data = array_merge($this->data, $data);
        $data['content_view'] = $viewPath;
        extract($data);
        
        $layoutFile = APPPATH . 'views/layouts/main.php';
        if (file_exists($layoutFile)) {
            include $layoutFile;
        }
    }
    
    protected function redirect($url) {
        header('Location: ' . base_url($url));
        exit;
    }
    
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    protected function requireAuth() {
        if (!Auth::check()) {
            $this->redirect('welcome');
        }
    }
    
    protected function getCurrentUser() {
        Auth::check(); // restore from cookie if session missing

        $clientId = $_SESSION['client_id'] ?? 'SG123';

        // Always refresh client_id from DB based on user_id to avoid stale session values
        $userId = $_SESSION['user_id'] ?? null;
        if ($userId && $this->db) {
            $fresh = $this->db->fetchOne(
                "SELECT c.client_id as company_code
                 FROM users u JOIN clients c ON c.id = u.client_id
                 WHERE u.id = ? LIMIT 1",
                [$userId]
            );
            if ($fresh && !empty($fresh->company_code)) {
                $clientId = $fresh->company_code;
                $_SESSION['client_id'] = $clientId; // keep session in sync
            }
        }

        return (object)[
            'id'        => $_SESSION['user_id']    ?? 1,
            'username'  => $_SESSION['username']   ?? 'accountingtang',
            'name'      => $_SESSION['user_name']  ?? 'Accountingtang',
            'email'     => $_SESSION['user_email'] ?? 'admin@corpfile.sg',
            'role'      => $_SESSION['user_role']  ?? 'superadmin',
            'client_id' => $clientId,
        ];
    }
    
    protected function generateCsrfToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    protected function validateCsrf() {
        $token = $_POST['ci_csrf_token'] ?? '';
        return hash_equals($_SESSION['csrf_token'] ?? '', $token);
    }
    
    protected function input($key, $default = null) {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }
    
    protected function setFlash($type, $message) {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }
    
    protected function getFlash() {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }
}
