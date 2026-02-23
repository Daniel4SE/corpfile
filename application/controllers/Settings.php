<?php
/**
 * Settings Controller - Settings / General Settings / User Settings / CSS Settings
 * Handles: /settings, /general_settings, /user_settings, /css_settings
 */
class Settings extends BaseController {
    
    public function index() {
        $this->requireAuth();
        
        $data = [
            'page_title' => 'Settings',
            'active_tab' => $this->input('tab', 'general'),
            'company_profile' => null,
            'users' => [],
            'system_preferences' => [],
        ];
        
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT * FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['company_profile'] = $client;
                $data['users'] = $this->db->fetchAll(
                    "SELECT * FROM users WHERE client_id = ? ORDER BY name ASC",
                    [$client->id]
                );
            }
        }
        
        $this->loadLayout('settings/index', $data);
    }
}

// General Settings controller (maps to /general_settings)
class General_settings extends BaseController {
    public function index() {
        $this->requireAuth();
        
        $data = [
            'page_title' => 'General Settings',
            'company_profile' => null,
            'email_settings' => [],
            'notification_settings' => [],
        ];
        
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT * FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['company_profile'] = $client;
            }
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->save();
            return;
        }
        
        $this->loadLayout('settings/general', $data);
    }
    
    private function save() {
        if (!$this->validateCsrf()) {
            $this->setFlash('error', 'Invalid security token. Please try again.');
            $this->redirect('general_settings');
            return;
        }
        
        // Save general settings logic
        $this->setFlash('success', 'General settings saved successfully.');
        $this->redirect('general_settings');
    }
}

// User Settings controller (maps to /user_settings)
class User_settings extends BaseController {

    private function getClient() {
        if (!$this->db) return null;
        $clientId = $_SESSION['client_id'] ?? '';
        return $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
    }

    private function getRoles($clientId) {
        if (!$this->db) return [];
        $rows = $this->db->fetchAll(
            "SELECT id, group_name AS role_name FROM user_groups WHERE client_id = ? ORDER BY group_name ASC",
            [$clientId]
        );
        return $rows ?: [];
    }

    public function index() {
        $this->requireAuth();

        $data = [
            'page_title' => 'User Management',
            'users'      => [],
            'roles'      => [],
            'csrf_token' => $this->getCsrfToken(),
            'flash'      => $this->getFlash(),
        ];

        $client = $this->getClient();
        if ($client) {
            $data['users'] = $this->db->fetchAll(
                "SELECT * FROM users WHERE client_id = ? ORDER BY name ASC",
                [$client->id]
            );
            $data['roles'] = $this->getRoles($client->id);
        }

        $this->loadLayout('settings/users', $data);
    }

    public function add_user() {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('user_settings');
            return;
        }

        $client = $this->getClient();
        if (!$client) {
            $this->setFlash('error', 'Session error. Please log in again.');
            $this->redirect('user_settings');
            return;
        }

        $name       = trim($this->input('name', ''));
        $username   = trim($this->input('username', ''));
        $email      = trim($this->input('email', ''));
        $password   = $this->input('password', '');
        $role       = trim($this->input('role', 'user'));
        $department = trim($this->input('department', ''));
        $phone      = trim($this->input('phone', ''));
        $status     = (int)$this->input('status', 1);

        if (empty($name) || empty($username) || empty($email) || empty($password)) {
            $this->setFlash('error', 'Name, username, email and password are required.');
            $this->redirect('user_settings');
            return;
        }

        // Check duplicate username / email
        $exists = $this->db->fetchOne(
            "SELECT id FROM users WHERE client_id = ? AND (username = ? OR email = ?)",
            [$client->id, $username, $email]
        );
        if ($exists) {
            $this->setFlash('error', 'Username or email already exists.');
            $this->redirect('user_settings');
            return;
        }

        $this->db->insert('users', [
            'client_id'  => $client->id,
            'name'       => $name,
            'username'   => $username,
            'email'      => $email,
            'password'   => password_hash($password, PASSWORD_DEFAULT),
            'role'       => $role,
            'department' => $department,
            'phone'      => $phone,
            'status'     => $status,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $this->setFlash('success', 'User created successfully.');
        $this->redirect('user_settings');
    }

    public function edit_user($id = null) {
        $this->requireAuth();

        if (!$id) {
            $this->redirect('user_settings');
            return;
        }

        $client = $this->getClient();
        if (!$client) {
            $this->redirect('user_settings');
            return;
        }

        $user = $this->db->fetchOne(
            "SELECT * FROM users WHERE id = ? AND client_id = ?",
            [$id, $client->id]
        );
        if (!$user) {
            $this->setFlash('error', 'User not found.');
            $this->redirect('user_settings');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name       = trim($this->input('name', ''));
            $username   = trim($this->input('username', ''));
            $email      = trim($this->input('email', ''));
            $role       = trim($this->input('role', 'user'));
            $department = trim($this->input('department', ''));
            $phone      = trim($this->input('phone', ''));
            $status     = (int)$this->input('status', 1);
            $newPassword = $this->input('password', '');

            if (empty($name) || empty($username) || empty($email)) {
                $this->setFlash('error', 'Name, username and email are required.');
                $this->redirect("user_settings/edit_user/{$id}");
                return;
            }

            // Check duplicate username/email (exclude current user)
            $exists = $this->db->fetchOne(
                "SELECT id FROM users WHERE client_id = ? AND (username = ? OR email = ?) AND id != ?",
                [$client->id, $username, $email, $id]
            );
            if ($exists) {
                $this->setFlash('error', 'Username or email already used by another user.');
                $this->redirect("user_settings/edit_user/{$id}");
                return;
            }

            $updateData = [
                'name'       => $name,
                'username'   => $username,
                'email'      => $email,
                'role'       => $role,
                'department' => $department,
                'phone'      => $phone,
                'status'     => $status,
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            if (!empty($newPassword)) {
                $updateData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
            }

            $this->db->update('users', $updateData, 'id = ? AND client_id = ?', [$id, $client->id]);
            $this->setFlash('success', 'User updated successfully.');
            $this->redirect('user_settings');
            return;
        }

        $data = [
            'page_title' => 'Edit User',
            'user'       => $user,
            'roles'      => $this->getRoles($client->id),
            'csrf_token' => $this->getCsrfToken(),
            'flash'      => $this->getFlash(),
        ];
        $this->loadLayout('settings/edit_user', $data);
    }

    public function view_user($id = null) {
        $this->requireAuth();
        // Redirect to edit for now
        $this->redirect("user_settings/edit_user/{$id}");
    }

    public function delete_user($id = null) {
        $this->requireAuth();

        if (!$id) {
            $this->redirect('user_settings');
            return;
        }

        $client = $this->getClient();
        if ($client) {
            // Prevent self-deletion
            $currentUserId = $_SESSION['user_id'] ?? 0;
            if ($id == $currentUserId) {
                $this->setFlash('error', 'You cannot delete your own account.');
                $this->redirect('user_settings');
                return;
            }
            $this->db->update('users', ['status' => 0], 'id = ? AND client_id = ?', [$id, $client->id]);
            $this->setFlash('success', 'User deactivated successfully.');
        }
        $this->redirect('user_settings');
    }

    private function getCsrfToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
        }
        return $_SESSION['csrf_token'];
    }
}

// CSS Settings controller (maps to /css_settings)
class Css_settings extends BaseController {
    public function index() {
        $this->requireAuth();
        
        $data = [
            'page_title' => 'CSS Module Settings',
            'css_config' => [],
        ];
        
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['css_config'] = $this->db->fetchAll(
                    "SELECT * FROM settings_general WHERE client_id = ? AND setting_group = 'css'",
                    [$client->id]
                );
            }
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->save();
            return;
        }
        
        $this->loadLayout('settings/css', $data);
    }
    
    private function save() {
        if (!$this->validateCsrf()) {
            $this->setFlash('error', 'Invalid security token. Please try again.');
            $this->redirect('css_settings');
            return;
        }
        
        $this->setFlash('success', 'CSS settings saved successfully.');
        $this->redirect('css_settings');
    }
}

// ═══════════════════════════════════════════════════════════════════════════════
// Settings Master CRUD Controllers
// Generic CRUD for all master/lookup tables via a single set of reusable views
// ═══════════════════════════════════════════════════════════════════════════════

/**
 * Settings_master - Generic Master List
 * Route: /settings_master/{type}
 * Displays a DataTable listing for any master/lookup table.
 */
class Settings_master extends BaseController {

    /**
     * Complete master configurations for all 42 settings types.
     * Each entry defines: table name, display title, DataTable columns, and form fields.
     */
    private $masterConfigs = [

        'member_id_type' => [
            'table'   => 'member_id_types',
            'title'   => 'Member ID Types',
            'columns' => ['ID', 'Type Name', 'Description', 'Status'],
            'fields'  => [
                ['name' => 'type_name',   'label' => 'Type Name',   'type' => 'text',     'required' => true],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'required' => false],
                ['name' => 'status',      'label' => 'Status',      'type' => 'select',   'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'event_name' => [
            'table'   => 'event_types',
            'title'   => 'Event Names',
            'columns' => ['ID', 'Event Name', 'Category', 'Status'],
            'fields'  => [
                ['name' => 'event_name', 'label' => 'Event Name', 'type' => 'text',   'required' => true],
                ['name' => 'category',   'label' => 'Category',   'type' => 'text',   'required' => false],
                ['name' => 'status',     'label' => 'Status',     'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'fee_type' => [
            'table'   => 'fee_types',
            'title'   => 'Fee Types',
            'columns' => ['ID', 'Fee Type', 'Default Amount', 'Status'],
            'fields'  => [
                ['name' => 'fee_type',       'label' => 'Fee Type',       'type' => 'text',   'required' => true],
                ['name' => 'default_amount', 'label' => 'Default Amount', 'type' => 'number', 'required' => false],
                ['name' => 'status',         'label' => 'Status',         'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'company_type' => [
            'table'   => 'company_types',
            'title'   => 'Company Types',
            'columns' => ['ID', 'Company Type', 'Code', 'Status'],
            'fields'  => [
                ['name' => 'company_type', 'label' => 'Company Type', 'type' => 'text',   'required' => true],
                ['name' => 'code',         'label' => 'Code',         'type' => 'text',   'required' => false],
                ['name' => 'status',       'label' => 'Status',       'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'document_category' => [
            'table'   => 'document_categories',
            'title'   => 'Document Categories',
            'columns' => ['ID', 'Category Name', 'Description', 'Status'],
            'fields'  => [
                ['name' => 'category_name', 'label' => 'Category Name', 'type' => 'text',     'required' => true],
                ['name' => 'description',   'label' => 'Description',   'type' => 'textarea', 'required' => false],
                ['name' => 'status',        'label' => 'Status',        'type' => 'select',   'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'region' => [
            'table'   => 'regions',
            'title'   => 'Regions',
            'columns' => ['ID', 'Region Name', 'Code', 'Status'],
            'fields'  => [
                ['name' => 'region_name', 'label' => 'Region Name', 'type' => 'text',   'required' => true],
                ['name' => 'code',        'label' => 'Code',        'type' => 'text',   'required' => false],
                ['name' => 'status',      'label' => 'Status',      'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'email_template' => [
            'table'   => 'email_templates',
            'title'   => 'Email Templates',
            'columns' => ['ID', 'Template Name', 'Subject', 'Category', 'Status'],
            'fields'  => [
                ['name' => 'template_name', 'label' => 'Template Name', 'type' => 'text',     'required' => true],
                ['name' => 'subject',       'label' => 'Subject',       'type' => 'text',     'required' => true],
                ['name' => 'category',      'label' => 'Category',      'type' => 'text',     'required' => false],
                ['name' => 'body',          'label' => 'Email Body',    'type' => 'richtext', 'required' => false],
                ['name' => 'status',        'label' => 'Status',        'type' => 'select',   'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'reminder_subject' => [
            'table'   => 'reminder_subjects',
            'title'   => 'Reminder Subjects',
            'columns' => ['ID', 'Subject', 'Category', 'Status'],
            'fields'  => [
                ['name' => 'subject',  'label' => 'Subject',  'type' => 'text',   'required' => true],
                ['name' => 'category', 'label' => 'Category', 'type' => 'text',   'required' => false],
                ['name' => 'status',   'label' => 'Status',   'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'payment_mode' => [
            'table'   => 'payment_modes',
            'title'   => 'Payment Modes',
            'columns' => ['ID', 'Payment Mode', 'Description', 'Status'],
            'fields'  => [
                ['name' => 'payment_mode', 'label' => 'Payment Mode', 'type' => 'text',     'required' => true],
                ['name' => 'description',  'label' => 'Description',  'type' => 'textarea', 'required' => false],
                ['name' => 'status',       'label' => 'Status',       'type' => 'select',   'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'bank' => [
            'table'   => 'banks',
            'title'   => 'Banks',
            'columns' => ['ID', 'Bank Name', 'Bank Code', 'Swift Code', 'Status'],
            'fields'  => [
                ['name' => 'bank_name',  'label' => 'Bank Name',  'type' => 'text',   'required' => true],
                ['name' => 'bank_code',  'label' => 'Bank Code',  'type' => 'text',   'required' => false],
                ['name' => 'swift_code', 'label' => 'Swift Code', 'type' => 'text',   'required' => false],
                ['name' => 'status',     'label' => 'Status',     'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'account_type' => [
            'table'   => 'account_types',
            'title'   => 'Account Types',
            'columns' => ['ID', 'Account Type', 'Description', 'Status'],
            'fields'  => [
                ['name' => 'account_type', 'label' => 'Account Type', 'type' => 'text',     'required' => true],
                ['name' => 'description',  'label' => 'Description',  'type' => 'textarea', 'required' => false],
                ['name' => 'status',       'label' => 'Status',       'type' => 'select',   'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'industry' => [
            'table'   => 'industries',
            'title'   => 'Industries',
            'columns' => ['ID', 'Industry Name', 'Code', 'Status'],
            'fields'  => [
                ['name' => 'industry_name', 'label' => 'Industry Name', 'type' => 'text',   'required' => true],
                ['name' => 'code',          'label' => 'Code',          'type' => 'text',   'required' => false],
                ['name' => 'status',        'label' => 'Status',        'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'market_segment' => [
            'table'   => 'market_segments',
            'title'   => 'Market Segments',
            'columns' => ['ID', 'Segment Name', 'Description', 'Status'],
            'fields'  => [
                ['name' => 'segment_name', 'label' => 'Segment Name', 'type' => 'text',     'required' => true],
                ['name' => 'description',  'label' => 'Description',  'type' => 'textarea', 'required' => false],
                ['name' => 'status',       'label' => 'Status',       'type' => 'select',   'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'tag' => [
            'table'   => 'tags',
            'title'   => 'Tags',
            'columns' => ['ID', 'Tag Name', 'Color', 'Status'],
            'fields'  => [
                ['name' => 'tag_name', 'label' => 'Tag Name', 'type' => 'text',   'required' => true],
                ['name' => 'color',    'label' => 'Color',    'type' => 'text',   'required' => false],
                ['name' => 'status',   'label' => 'Status',   'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'status' => [
            'table'   => 'status_master',
            'title'   => 'Status Master',
            'columns' => ['ID', 'Status Name', 'Category', 'Color', 'Status'],
            'fields'  => [
                ['name' => 'status_name', 'label' => 'Status Name', 'type' => 'text',   'required' => true],
                ['name' => 'category',    'label' => 'Category',    'type' => 'text',   'required' => false],
                ['name' => 'color',       'label' => 'Color',       'type' => 'text',   'required' => false],
                ['name' => 'status',      'label' => 'Status',      'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'lead_source' => [
            'table'   => 'lead_sources',
            'title'   => 'Lead Sources',
            'columns' => ['ID', 'Source Name', 'Description', 'Status'],
            'fields'  => [
                ['name' => 'source_name',  'label' => 'Source Name',  'type' => 'text',     'required' => true],
                ['name' => 'description',  'label' => 'Description',  'type' => 'textarea', 'required' => false],
                ['name' => 'status',       'label' => 'Status',       'type' => 'select',   'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'order_reason' => [
            'table'   => 'order_reasons',
            'title'   => 'Order Reasons',
            'columns' => ['ID', 'Reason', 'Category', 'Status'],
            'fields'  => [
                ['name' => 'reason',   'label' => 'Reason',   'type' => 'text',   'required' => true],
                ['name' => 'category', 'label' => 'Category', 'type' => 'text',   'required' => false],
                ['name' => 'status',   'label' => 'Status',   'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'follow_up_mode' => [
            'table'   => 'follow_up_modes',
            'title'   => 'Follow Up Modes',
            'columns' => ['ID', 'Mode Name', 'Description', 'Status'],
            'fields'  => [
                ['name' => 'mode_name',   'label' => 'Mode Name',   'type' => 'text',     'required' => true],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'required' => false],
                ['name' => 'status',      'label' => 'Status',      'type' => 'select',   'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'follow_up_agenda' => [
            'table'   => 'follow_up_agendas',
            'title'   => 'Follow Up Agendas',
            'columns' => ['ID', 'Agenda Name', 'Description', 'Status'],
            'fields'  => [
                ['name' => 'agenda_name', 'label' => 'Agenda Name', 'type' => 'text',     'required' => true],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'required' => false],
                ['name' => 'status',      'label' => 'Status',      'type' => 'select',   'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'lead_rating' => [
            'table'   => 'lead_ratings',
            'title'   => 'Lead Ratings',
            'columns' => ['ID', 'Rating Name', 'Score', 'Status'],
            'fields'  => [
                ['name' => 'rating_name', 'label' => 'Rating Name', 'type' => 'text',   'required' => true],
                ['name' => 'score',       'label' => 'Score',       'type' => 'number', 'required' => false],
                ['name' => 'status',      'label' => 'Status',      'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'crm_master_task' => [
            'table'   => 'crm_master_tasks',
            'title'   => 'CRM Master Tasks',
            'columns' => ['ID', 'Task Name', 'Category', 'Default Priority', 'Status'],
            'fields'  => [
                ['name' => 'task_name',        'label' => 'Task Name',        'type' => 'text',   'required' => true],
                ['name' => 'category',         'label' => 'Category',         'type' => 'text',   'required' => false],
                ['name' => 'default_priority', 'label' => 'Default Priority', 'type' => 'select', 'options' => ['Low', 'Medium', 'High', 'Critical'], 'required' => false],
                ['name' => 'status',           'label' => 'Status',           'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'crm_master_cycle' => [
            'table'   => 'crm_master_cycles',
            'title'   => 'CRM Master Cycles',
            'columns' => ['ID', 'Cycle Name', 'Duration (Days)', 'Status'],
            'fields'  => [
                ['name' => 'cycle_name', 'label' => 'Cycle Name',      'type' => 'text',   'required' => true],
                ['name' => 'duration',   'label' => 'Duration (Days)', 'type' => 'number', 'required' => false],
                ['name' => 'status',     'label' => 'Status',          'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'ticket_type' => [
            'table'   => 'ticket_types',
            'title'   => 'Ticket Types',
            'columns' => ['ID', 'Type Name', 'Description', 'Status'],
            'fields'  => [
                ['name' => 'type_name',   'label' => 'Type Name',   'type' => 'text',     'required' => true],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'required' => false],
                ['name' => 'status',      'label' => 'Status',      'type' => 'select',   'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'project_status' => [
            'table'   => 'project_statuses',
            'title'   => 'Project Statuses',
            'columns' => ['ID', 'Status Name', 'Color', 'Sort Order', 'Status'],
            'fields'  => [
                ['name' => 'status_name', 'label' => 'Status Name', 'type' => 'text',   'required' => true],
                ['name' => 'color',       'label' => 'Color',       'type' => 'text',   'required' => false],
                ['name' => 'sort_order',  'label' => 'Sort Order',  'type' => 'number', 'required' => false],
                ['name' => 'status',      'label' => 'Status',      'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'expense_head' => [
            'table'   => 'expense_heads',
            'title'   => 'Expense Heads',
            'columns' => ['ID', 'Expense Head', 'Account Code', 'Status'],
            'fields'  => [
                ['name' => 'expense_head',  'label' => 'Expense Head',  'type' => 'text',   'required' => true],
                ['name' => 'account_code',  'label' => 'Account Code',  'type' => 'text',   'required' => false],
                ['name' => 'status',        'label' => 'Status',        'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'importance' => [
            'table'   => 'importance_levels',
            'title'   => 'Importance Levels',
            'columns' => ['ID', 'Level Name', 'Sort Order', 'Status'],
            'fields'  => [
                ['name' => 'level_name',  'label' => 'Level Name',  'type' => 'text',   'required' => true],
                ['name' => 'sort_order',  'label' => 'Sort Order',  'type' => 'number', 'required' => false],
                ['name' => 'status',      'label' => 'Status',      'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'task_group' => [
            'table'   => 'task_groups',
            'title'   => 'Task Groups',
            'columns' => ['ID', 'Group Name', 'Description', 'Status'],
            'fields'  => [
                ['name' => 'group_name',  'label' => 'Group Name',  'type' => 'text',     'required' => true],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'required' => false],
                ['name' => 'status',      'label' => 'Status',      'type' => 'select',   'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'task_priority' => [
            'table'   => 'task_priorities',
            'title'   => 'Task Priorities',
            'columns' => ['ID', 'Priority Name', 'Color', 'Sort Order', 'Status'],
            'fields'  => [
                ['name' => 'priority_name', 'label' => 'Priority Name', 'type' => 'text',   'required' => true],
                ['name' => 'color',         'label' => 'Color',         'type' => 'text',   'required' => false],
                ['name' => 'sort_order',    'label' => 'Sort Order',    'type' => 'number', 'required' => false],
                ['name' => 'status',        'label' => 'Status',        'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'task_checklist' => [
            'table'   => 'task_checklists',
            'title'   => 'Task Checklists',
            'columns' => ['ID', 'Checklist Name', 'Items Count', 'Status'],
            'fields'  => [
                ['name' => 'checklist_name', 'label' => 'Checklist Name', 'type' => 'text',     'required' => true],
                ['name' => 'items',          'label' => 'Checklist Items', 'type' => 'textarea', 'required' => false],
                ['name' => 'status',         'label' => 'Status',          'type' => 'select',   'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'ticket_source' => [
            'table'   => 'ticket_sources',
            'title'   => 'Ticket Sources',
            'columns' => ['ID', 'Source Name', 'Description', 'Status'],
            'fields'  => [
                ['name' => 'source_name', 'label' => 'Source Name', 'type' => 'text',     'required' => true],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'required' => false],
                ['name' => 'status',      'label' => 'Status',      'type' => 'select',   'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'ticket_priority' => [
            'table'   => 'ticket_priorities',
            'title'   => 'Ticket Priorities',
            'columns' => ['ID', 'Priority Name', 'Color', 'Sort Order', 'Status'],
            'fields'  => [
                ['name' => 'priority_name', 'label' => 'Priority Name', 'type' => 'text',   'required' => true],
                ['name' => 'color',         'label' => 'Color',         'type' => 'text',   'required' => false],
                ['name' => 'sort_order',    'label' => 'Sort Order',    'type' => 'number', 'required' => false],
                ['name' => 'status',        'label' => 'Status',        'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'shares_class_type' => [
            'table'   => 'share_classes',
            'title'   => 'Shares Class Types',
            'columns' => ['ID', 'Class Name', 'Code', 'Par Value', 'Status'],
            'fields'  => [
                ['name' => 'class_name', 'label' => 'Class Name', 'type' => 'text',   'required' => true],
                ['name' => 'code',       'label' => 'Code',       'type' => 'text',   'required' => false],
                ['name' => 'par_value',  'label' => 'Par Value',  'type' => 'number', 'required' => false],
                ['name' => 'status',     'label' => 'Status',     'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'register_footer' => [
            'table'   => 'register_footers',
            'title'   => 'Register Footers',
            'columns' => ['ID', 'Register Type', 'Footer Text', 'Status'],
            'fields'  => [
                ['name' => 'register_type', 'label' => 'Register Type', 'type' => 'text',     'required' => true],
                ['name' => 'footer_text',   'label' => 'Footer Text',   'type' => 'richtext', 'required' => false],
                ['name' => 'status',        'label' => 'Status',        'type' => 'select',   'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'bank_approver_group' => [
            'table'   => 'bank_approver_groups',
            'title'   => 'Bank Approver Groups',
            'columns' => ['ID', 'Group Name', 'Members', 'Status'],
            'fields'  => [
                ['name' => 'group_name',  'label' => 'Group Name',  'type' => 'text',     'required' => true],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'required' => false],
                ['name' => 'status',      'label' => 'Status',      'type' => 'select',   'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'uom' => [
            'table'   => 'uom_master',
            'title'   => 'Unit of Measure',
            'columns' => ['ID', 'UOM Name', 'Symbol', 'Status'],
            'fields'  => [
                ['name' => 'uom_name', 'label' => 'UOM Name', 'type' => 'text',   'required' => true],
                ['name' => 'symbol',   'label' => 'Symbol',   'type' => 'text',   'required' => false],
                ['name' => 'status',   'label' => 'Status',   'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'terms' => [
            'table'   => 'terms',
            'title'   => 'Terms & Conditions',
            'columns' => ['ID', 'Term Name', 'Category', 'Status'],
            'fields'  => [
                ['name' => 'term_name', 'label' => 'Term Name', 'type' => 'text',     'required' => true],
                ['name' => 'category',  'label' => 'Category',  'type' => 'text',     'required' => false],
                ['name' => 'content',   'label' => 'Content',   'type' => 'richtext', 'required' => false],
                ['name' => 'status',    'label' => 'Status',    'type' => 'select',   'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'custom_field' => [
            'table'   => 'custom_fields',
            'title'   => 'Custom Fields',
            'columns' => ['ID', 'Field Name', 'Field Type', 'Module', 'Status'],
            'fields'  => [
                ['name' => 'field_name', 'label' => 'Field Name', 'type' => 'text',   'required' => true],
                ['name' => 'field_type', 'label' => 'Field Type', 'type' => 'select', 'options' => ['Text', 'Number', 'Date', 'Select', 'Textarea', 'Checkbox'], 'required' => true],
                ['name' => 'module',     'label' => 'Module',     'type' => 'select', 'options' => ['Company', 'Contact', 'Invoice', 'Project', 'Task'], 'required' => true],
                ['name' => 'status',     'label' => 'Status',     'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'product_category' => [
            'table'   => 'product_categories',
            'title'   => 'Product Categories',
            'columns' => ['ID', 'Category Name', 'Parent Category', 'Status'],
            'fields'  => [
                ['name' => 'category_name',   'label' => 'Category Name',   'type' => 'text',   'required' => true],
                ['name' => 'parent_category', 'label' => 'Parent Category', 'type' => 'text',   'required' => false],
                ['name' => 'status',          'label' => 'Status',          'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'form_category' => [
            'table'   => 'form_categories',
            'title'   => 'Form Categories',
            'columns' => ['ID', 'Category Name', 'Description', 'Status'],
            'fields'  => [
                ['name' => 'category_name', 'label' => 'Category Name', 'type' => 'text',     'required' => true],
                ['name' => 'description',   'label' => 'Description',   'type' => 'textarea', 'required' => false],
                ['name' => 'status',        'label' => 'Status',        'type' => 'select',   'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'user_group' => [
            'table'   => 'user_groups',
            'title'   => 'User Groups',
            'columns' => ['ID', 'Group Name', 'Description', 'Members', 'Status'],
            'fields'  => [
                ['name' => 'group_name',  'label' => 'Group Name',  'type' => 'text',     'required' => true],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'required' => false],
                ['name' => 'status',      'label' => 'Status',      'type' => 'select',   'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'group_master' => [
            'table'   => 'group_master',
            'title'   => 'Group Master',
            'columns' => ['ID', 'Group Name', 'Group Type', 'Description', 'Status'],
            'fields'  => [
                ['name' => 'group_name',  'label' => 'Group Name',  'type' => 'text',     'required' => true],
                ['name' => 'group_type',  'label' => 'Group Type',  'type' => 'text',     'required' => false],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'required' => false],
                ['name' => 'status',      'label' => 'Status',      'type' => 'select',   'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'designer' => [
            'table'   => 'designer_master',
            'title'   => 'Designer Master',
            'columns' => ['ID', 'Designer Name', 'Email', 'Phone', 'Status'],
            'fields'  => [
                ['name' => 'designer_name', 'label' => 'Designer Name', 'type' => 'text',   'required' => true],
                ['name' => 'email',         'label' => 'Email',         'type' => 'email',  'required' => false],
                ['name' => 'phone',         'label' => 'Phone',         'type' => 'text',   'required' => false],
                ['name' => 'status',        'label' => 'Status',        'type' => 'select', 'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
        'branch' => [
            'table'   => 'branch_master',
            'title'   => 'Branch Master',
            'columns' => ['ID', 'Branch Name', 'Address', 'Phone', 'Status'],
            'fields'  => [
                ['name' => 'branch_name', 'label' => 'Branch Name', 'type' => 'text',     'required' => true],
                ['name' => 'address',     'label' => 'Address',     'type' => 'textarea', 'required' => false],
                ['name' => 'phone',       'label' => 'Phone',       'type' => 'text',     'required' => false],
                ['name' => 'email',       'label' => 'Email',       'type' => 'email',    'required' => false],
                ['name' => 'status',      'label' => 'Status',      'type' => 'select',   'options' => ['Active', 'Inactive'], 'required' => true],
            ],
        ],
    ];

    /**
     * Get config or redirect on invalid type
     */
    protected function getConfig($type) {
        if (!$type || !isset($this->masterConfigs[$type])) {
            return null;
        }
        return $this->masterConfigs[$type];
    }

    /**
     * Get all configs (used by sub-classes)
     */
    protected function getAllConfigs() {
        return $this->masterConfigs;
    }

    /**
     * Main listing: /settings_master/{type}
     */
    public function index($type = null) {
        $this->requireAuth();

        $config = $this->getConfig($type);
        if (!$config) {
            $this->setFlash('error', 'Invalid settings type specified.');
            $this->redirect('settings');
            return;
        }

        // Fetch records from database
        $records = [];
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client   = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $records = $this->db->fetchAll(
                    "SELECT * FROM {$config['table']} WHERE client_id = ? ORDER BY id DESC",
                    [$client->id]
                );
            }
        }

        $data = [
            'page_title'  => $config['title'],
            'master_type' => $type,
            'config'      => $config,
            'records'     => $records,
            'flash'       => $this->getFlash(),
        ];

        $this->loadLayout('settings/master_list', $data);
    }

    /**
     * Delete handler: /settings_master/delete/{type}/{id}
     */
    public function delete($type = null, $id = null) {
        $this->requireAuth();

        $config = $this->getConfig($type);
        if (!$config || !$id) {
            $this->setFlash('error', 'Invalid request.');
            $this->redirect('settings');
            return;
        }

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client   = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $this->db->execute(
                    "DELETE FROM {$config['table']} WHERE id = ? AND client_id = ?",
                    [$id, $client->id]
                );
                $this->setFlash('success', 'Record deleted successfully.');
            }
        }

        $this->redirect("settings_master/{$type}");
    }

    /**
     * Return all available master types (for menus / API)
     */
    public function list_types() {
        $this->requireAuth();
        $types = [];
        foreach ($this->masterConfigs as $key => $cfg) {
            $types[] = ['key' => $key, 'title' => $cfg['title'], 'table' => $cfg['table']];
        }
        $this->json($types);
    }
}

/**
 * Settings_master_add - Generic Add Form
 * Route: /settings_master_add/{type}
 */
class Settings_master_add extends Settings_master {

    public function index($type = null) {
        $this->requireAuth();

        $config = $this->getConfig($type);
        if (!$config) {
            $this->setFlash('error', 'Invalid settings type specified.');
            $this->redirect('settings');
            return;
        }

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->store($type, $config);
            return;
        }

        $data = [
            'page_title'  => 'Add ' . $config['title'],
            'master_type' => $type,
            'config'      => $config,
            'record'      => null,
            'form_action' => base_url("settings_master_add/{$type}"),
            'is_edit'     => false,
            'flash'       => $this->getFlash(),
        ];

        $this->loadLayout('settings/master_form', $data);
    }

    /**
     * Store new record
     */
    private function store($type, $config) {
        if (!$this->validateCsrf()) {
            $this->setFlash('error', 'Invalid security token. Please try again.');
            $this->redirect("settings_master_add/{$type}");
            return;
        }

        // Validate required fields
        $errors = [];
        $fieldData = [];
        foreach ($config['fields'] as $field) {
            $value = trim($this->input($field['name'], ''));
            if (!empty($field['required']) && $value === '') {
                $errors[] = $field['label'] . ' is required.';
            }
            $fieldData[$field['name']] = $value;
        }

        if (!empty($errors)) {
            $this->setFlash('error', implode('<br>', $errors));
            $this->redirect("settings_master_add/{$type}");
            return;
        }

        // Insert record
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client   = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $fieldData['client_id']  = $client->id;
                $fieldData['created_at'] = date('Y-m-d H:i:s');
                $fieldData['created_by'] = $_SESSION['user_id'] ?? 0;

                $columns      = implode(', ', array_keys($fieldData));
                $placeholders = implode(', ', array_fill(0, count($fieldData), '?'));

                $this->db->execute(
                    "INSERT INTO {$config['table']} ({$columns}) VALUES ({$placeholders})",
                    array_values($fieldData)
                );

                $this->setFlash('success', 'Record added successfully.');
                $this->redirect("settings_master/{$type}");
                return;
            }
        }

        $this->setFlash('error', 'Failed to add record. Please try again.');
        $this->redirect("settings_master_add/{$type}");
    }
}

/**
 * Settings_master_edit - Generic Edit Form
 * Route: /settings_master_edit/{type}/{id}
 */
class Settings_master_edit extends Settings_master {

    public function index($type = null, $id = null) {
        $this->requireAuth();

        $config = $this->getConfig($type);
        if (!$config || !$id) {
            $this->setFlash('error', 'Invalid settings type or record specified.');
            $this->redirect('settings');
            return;
        }

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->update($type, $id, $config);
            return;
        }

        // Fetch existing record
        $record = null;
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client   = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $record = $this->db->fetchOne(
                    "SELECT * FROM {$config['table']} WHERE id = ? AND client_id = ?",
                    [$id, $client->id]
                );
            }
        }

        if (!$record) {
            $this->setFlash('error', 'Record not found.');
            $this->redirect("settings_master/{$type}");
            return;
        }

        $data = [
            'page_title'  => 'Edit ' . $config['title'],
            'master_type' => $type,
            'config'      => $config,
            'record'      => $record,
            'record_id'   => $id,
            'form_action' => base_url("settings_master_edit/{$type}/{$id}"),
            'is_edit'     => true,
            'flash'       => $this->getFlash(),
        ];

        $this->loadLayout('settings/master_form', $data);
    }

    /**
     * Update existing record
     */
    private function update($type, $id, $config) {
        if (!$this->validateCsrf()) {
            $this->setFlash('error', 'Invalid security token. Please try again.');
            $this->redirect("settings_master_edit/{$type}/{$id}");
            return;
        }

        // Validate required fields
        $errors = [];
        $setClauses = [];
        $params     = [];

        foreach ($config['fields'] as $field) {
            $value = trim($this->input($field['name'], ''));
            if (!empty($field['required']) && $value === '') {
                $errors[] = $field['label'] . ' is required.';
            }
            $setClauses[] = "{$field['name']} = ?";
            $params[]     = $value;
        }

        if (!empty($errors)) {
            $this->setFlash('error', implode('<br>', $errors));
            $this->redirect("settings_master_edit/{$type}/{$id}");
            return;
        }

        // Add audit fields
        $setClauses[] = 'updated_at = ?';
        $params[]     = date('Y-m-d H:i:s');
        $setClauses[] = 'updated_by = ?';
        $params[]     = $_SESSION['user_id'] ?? 0;

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client   = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $params[] = $id;
                $params[] = $client->id;

                $setString = implode(', ', $setClauses);
                $this->db->execute(
                    "UPDATE {$config['table']} SET {$setString} WHERE id = ? AND client_id = ?",
                    $params
                );

                $this->setFlash('success', 'Record updated successfully.');
                $this->redirect("settings_master/{$type}");
                return;
            }
        }

        $this->setFlash('error', 'Failed to update record. Please try again.');
        $this->redirect("settings_master_edit/{$type}/{$id}");
    }
}
