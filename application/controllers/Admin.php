<?php
/**
 * Admin Controller - User Management
 * Handles: /alladmin, /add_admin, /edit_admin, /page_access_rights,
 *          /user_groups, /add_user_group, /edit_user_group,
 *          /user_groups_permissions, /change_psd
 */
class Admin extends BaseController {
    
    public function index() {
        $this->requireAuth();
        $this->redirect('alladmin');
    }

    /**
     * Delete an admin user
     * GET /admin/delete/{id}
     */
    public function delete($id = null) {
        $this->requireAuth();
        if ($id && $this->db) {
            $this->db->delete('users', 'id = ?', [$id]);
        }
        $this->redirect('alladmin');
    }

    /**
     * Delete a user group
     * GET /admin/delete_group/{id}
     */
    public function delete_group($id = null) {
        $this->requireAuth();
        if ($id && $this->db) {
            $this->db->delete('user_groups', 'id = ?', [$id]);
        }
        $this->redirect('user_groups');
    }
}

// Admin user listing (maps to /alladmin)
class Alladmin extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'All Admin Users',
            'admins' => [],
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['admins'] = $this->db->fetchAll(
                    "SELECT u.*, ug.group_name 
                     FROM users u 
                     LEFT JOIN user_groups ug ON ug.id = u.user_group_id
                     WHERE u.client_id = ? 
                     ORDER BY u.name ASC",
                    [$client->id]
                );
            }
        }

        $this->loadLayout('admin/list', $data);
    }
}

// Add Admin form (maps to /add_admin)
class Add_admin extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Add Admin User',
            'user_groups' => [],
            'branches' => [],
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['user_groups'] = $this->db->fetchAll(
                    "SELECT * FROM user_groups WHERE client_id = ? AND status = 1 ORDER BY group_name ASC",
                    [$client->id]
                );
                $data['branches'] = $this->db->fetchAll(
                    "SELECT * FROM branches WHERE client_id = ? AND status = 1 ORDER BY branch_name ASC",
                    [$client->id]
                );
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->store();
            return;
        }

        $this->loadLayout('admin/add', $data);
    }

    private function store() {
        if (!$this->validateCsrf()) {
            $this->setFlash('error', 'Invalid security token.');
            $this->redirect('add_admin');
            return;
        }
        if (!$this->db) {
            $this->setFlash('error', 'Database not connected');
            $this->redirect('add_admin');
            return;
        }

        $password = $this->input('password', '');
        $confirmPassword = $this->input('confirm_password', '');
        if ($password !== $confirmPassword) {
            $this->setFlash('error', 'Passwords do not match.');
            $this->redirect('add_admin');
            return;
        }

        $clientId = $_SESSION['client_id'] ?? '';
        $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
        if (!$client) {
            $this->setFlash('error', 'Invalid client');
            $this->redirect('add_admin');
            return;
        }

        $userData = [
            'client_id'     => $client->id,
            'name'          => $this->input('name', ''),
            'email'         => $this->input('email', ''),
            'password'      => password_hash($password, PASSWORD_DEFAULT),
            'role'          => $this->input('role', 'User'),
            'user_group_id' => $this->input('user_group') ?: null,
            'branch_id'     => $this->input('branch') ?: null,
            'status'        => $this->input('status', 'Active'),
            'phone'         => $this->input('phone', ''),
            'created_by'    => $_SESSION['user_id'] ?? null,
        ];

        // Handle profile image upload
        if (!empty($_FILES['profile_image']['name'])) {
            $uploadDir = FCPATH . 'public/uploads/profiles/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
            $filename = 'profile_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
            move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadDir . $filename);
            $userData['profile_image'] = $filename;
        }

        $this->db->insert('users', $userData);
        $this->setFlash('success', 'Admin user created successfully.');
        $this->redirect('alladmin');
    }
}

// Edit Admin form (maps to /edit_admin/{id})
class Edit_admin extends BaseController {
    public function index($id = null) {
        $this->requireAuth();
        if (!$id) { $this->redirect('alladmin'); return; }

        $data = [
            'page_title'   => 'Edit Admin User',
            'admin'        => null,
            'user_groups'  => [],
            'branches'     => [],
        ];

        if ($this->db) {
            $data['admin'] = $this->db->fetchOne("SELECT * FROM users WHERE id = ?", [$id]);
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['user_groups'] = $this->db->fetchAll(
                    "SELECT * FROM user_groups WHERE client_id = ? AND status = 1 ORDER BY group_name ASC",
                    [$client->id]
                );
                $data['branches'] = $this->db->fetchAll(
                    "SELECT * FROM branches WHERE client_id = ? AND status = 1 ORDER BY branch_name ASC",
                    [$client->id]
                );
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->update($id);
            return;
        }

        $this->loadLayout('admin/edit', $data);
    }

    private function update($id) {
        if (!$this->validateCsrf()) {
            $this->setFlash('error', 'Invalid security token.');
            $this->redirect("edit_admin/{$id}");
            return;
        }
        if (!$this->db) {
            $this->setFlash('error', 'Database not connected');
            $this->redirect("edit_admin/{$id}");
            return;
        }

        $updateData = [
            'name'          => $this->input('name', ''),
            'email'         => $this->input('email', ''),
            'role'          => $this->input('role', 'User'),
            'user_group_id' => $this->input('user_group') ?: null,
            'branch_id'     => $this->input('branch') ?: null,
            'status'        => $this->input('status', 'Active'),
            'phone'         => $this->input('phone', ''),
        ];

        if (!empty($_FILES['profile_image']['name'])) {
            $uploadDir = FCPATH . 'public/uploads/profiles/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
            $filename = 'profile_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
            move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadDir . $filename);
            $updateData['profile_image'] = $filename;
        }

        $this->db->update('users', $updateData, 'id = ?', [$id]);
        $this->setFlash('success', 'Admin user updated successfully.');
        $this->redirect('alladmin');
    }
}

// Page Access Rights (maps to /page_access_rights/{user_id})
class Page_access_rights extends BaseController {
    public function index($userId = null) {
        $this->requireAuth();
        if (!$userId) { $this->redirect('alladmin'); return; }

        $data = [
            'page_title'  => 'Page Access Rights',
            'user'        => null,
            'modules'     => [],
            'permissions' => [],
        ];

        if ($this->db) {
            $data['user'] = $this->db->fetchOne("SELECT * FROM users WHERE id = ?", [$userId]);
            $data['modules'] = $this->db->fetchAll("SELECT * FROM modules ORDER BY module_name ASC");
            $data['permissions'] = $this->db->fetchAll(
                "SELECT * FROM user_permissions WHERE user_id = ?",
                [$userId]
            );
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->validateCsrf() && $this->db) {
                $this->db->query("DELETE FROM user_permissions WHERE user_id = ?", [$userId]);
                $modules = $_POST['modules'] ?? [];
                foreach ($modules as $moduleId => $perms) {
                    $this->db->insert('user_permissions', [
                        'user_id'    => $userId,
                        'module_id'  => $moduleId,
                        'can_view'   => isset($perms['view']) ? 1 : 0,
                        'can_add'    => isset($perms['add']) ? 1 : 0,
                        'can_edit'   => isset($perms['edit']) ? 1 : 0,
                        'can_delete' => isset($perms['delete']) ? 1 : 0,
                    ]);
                }
                $this->setFlash('success', 'Permissions updated successfully.');
                $this->redirect("page_access_rights/{$userId}");
                return;
            }
        }

        $this->loadLayout('admin/access_rights', $data);
    }
}

// User Groups listing (maps to /user_groups)
class User_groups extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'User Groups',
            'groups'     => [],
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['groups'] = $this->db->fetchAll(
                    "SELECT * FROM user_groups WHERE client_id = ? ORDER BY group_name ASC",
                    [$client->id]
                );
            }
        }

        $this->loadLayout('admin/user_groups', $data);
    }
}

// Add User Group (maps to /add_user_group)
class Add_user_group extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = ['page_title' => 'Add User Group'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->validateCsrf() && $this->db) {
                $clientId = $_SESSION['client_id'] ?? '';
                $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
                if ($client) {
                    $this->db->insert('user_groups', [
                        'client_id'   => $client->id,
                        'group_name'  => $this->input('group_name', ''),
                        'description' => $this->input('description', ''),
                        'status'      => $this->input('status', 1),
                        'created_by'  => $_SESSION['user_id'] ?? null,
                    ]);
                    $this->setFlash('success', 'User group created successfully.');
                    $this->redirect('user_groups');
                    return;
                }
            }
        }

        $this->loadLayout('admin/user_group_form', $data);
    }
}

// Edit User Group (maps to /edit_user_group/{id})
class Edit_user_group extends BaseController {
    public function index($id = null) {
        $this->requireAuth();
        if (!$id) { $this->redirect('user_groups'); return; }

        $data = [
            'page_title' => 'Edit User Group',
            'group'      => null,
        ];

        if ($this->db) {
            $data['group'] = $this->db->fetchOne("SELECT * FROM user_groups WHERE id = ?", [$id]);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->validateCsrf() && $this->db) {
                $this->db->update('user_groups', [
                    'group_name'  => $this->input('group_name', ''),
                    'description' => $this->input('description', ''),
                    'status'      => $this->input('status', 1),
                ], 'id = ?', [$id]);
                $this->setFlash('success', 'User group updated successfully.');
                $this->redirect('user_groups');
                return;
            }
        }

        $this->loadLayout('admin/user_group_form', $data);
    }
}

// User Groups Permissions (maps to /user_groups_permissions)
class User_groups_permissions extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'User Group Permissions',
            'groups'     => [],
            'modules'    => [],
            'permissions'=> [],
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['groups'] = $this->db->fetchAll(
                    "SELECT * FROM user_groups WHERE client_id = ? AND status = 1 ORDER BY group_name ASC",
                    [$client->id]
                );
            }
            $data['modules'] = $this->db->fetchAll("SELECT * FROM modules ORDER BY module_name ASC");
            $data['permissions'] = $this->db->fetchAll("SELECT * FROM group_permissions");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->validateCsrf() && $this->db) {
                $groupId = $this->input('group_id');
                if ($groupId) {
                    $this->db->query("DELETE FROM group_permissions WHERE group_id = ?", [$groupId]);
                    $modules = $_POST['modules'] ?? [];
                    foreach ($modules as $moduleId => $perms) {
                        $this->db->insert('group_permissions', [
                            'group_id'   => $groupId,
                            'module_id'  => $moduleId,
                            'can_view'   => isset($perms['view']) ? 1 : 0,
                            'can_add'    => isset($perms['add']) ? 1 : 0,
                            'can_edit'   => isset($perms['edit']) ? 1 : 0,
                            'can_delete' => isset($perms['delete']) ? 1 : 0,
                        ]);
                    }
                    $this->setFlash('success', 'Group permissions updated successfully.');
                    $this->redirect('user_groups_permissions');
                    return;
                }
            }
        }

        $this->loadLayout('admin/user_groups', $data);
    }
}

// Change Password (maps to /change_psd)
class Change_psd extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = ['page_title' => 'Change Password'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->validateCsrf() && $this->db) {
                $currentPassword = $this->input('current_password', '');
                $newPassword = $this->input('new_password', '');
                $confirmPassword = $this->input('confirm_password', '');

                if ($newPassword !== $confirmPassword) {
                    $this->setFlash('error', 'New passwords do not match.');
                    $this->redirect('change_psd');
                    return;
                }

                $userId = $_SESSION['user_id'] ?? null;
                $user = $this->db->fetchOne("SELECT * FROM users WHERE id = ?", [$userId]);
                if ($user && password_verify($currentPassword, $user->password)) {
                    $this->db->update('users', [
                        'password' => password_hash($newPassword, PASSWORD_DEFAULT),
                    ], 'id = ?', [$userId]);
                    $this->setFlash('success', 'Password changed successfully.');
                } else {
                    $this->setFlash('error', 'Current password is incorrect.');
                }
                $this->redirect('change_psd');
                return;
            }
        }

        $this->loadLayout('admin/change_password', $data);
    }
}
