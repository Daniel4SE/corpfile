<?php
/**
 * Misc Controller - Miscellaneous Pages
 * Handles: /my_profile, /sealings_list, /add_seal, /company_bank,
 *          /add_company_bank, /reminder_list, /set_reminder, /edit_reminder,
 *          /esign_settings, /esign_log, /member_pdf, /member_documents
 */
class Misc extends BaseController {
    
    public function index() {
        $this->requireAuth();
        $this->redirect('my_profile');
    }
}

// My Profile (maps to /my_profile)
class My_profile extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'My Profile',
            'profile'    => null,
        ];

        $userId = $_SESSION['user_id'] ?? null;
        if ($this->db && $userId) {
            $data['profile'] = $this->db->fetchOne("SELECT * FROM users WHERE id = ?", [$userId]);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->validateCsrf() && $this->db && $userId) {
                $updateData = [
                    'name'    => $this->input('name', ''),
                    'email'   => $this->input('email', ''),
                    'phone'   => $this->input('phone', ''),
                    'address' => $this->input('address', ''),
                ];

                if (!empty($_FILES['profile_image']['name'])) {
                    $uploadDir = FCPATH . 'public/uploads/profiles/';
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                    $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
                    $filename = 'profile_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
                    move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadDir . $filename);
                    $updateData['profile_image'] = $filename;
                }

                $this->db->update('users', $updateData, 'id = ?', [$userId]);
                $_SESSION['user_name'] = $updateData['name'];
                $_SESSION['user_email'] = $updateData['email'];
                $this->setFlash('success', 'Profile updated successfully.');
                $this->redirect('my_profile');
                return;
            }
        }

        $this->loadLayout('misc/profile', $data);
    }
}

// Sealings List (maps to /sealings_list)
class Sealings_list extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Sealings List',
            'sealings'   => [],
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['sealings'] = $this->db->fetchAll(
                    "SELECT s.*, c.company_name FROM sealings s 
                     LEFT JOIN companies c ON c.id = s.company_id 
                     WHERE s.client_id = ? ORDER BY s.created_at DESC",
                    [$client->id]
                );
            }
        }

        $this->loadLayout('misc/sealings_list', $data);
    }
}

// Add Seal (maps to /add_seal)
class Add_seal extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Add Seal',
            'companies'  => [],
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['companies'] = $this->db->fetchAll(
                    "SELECT id, company_name FROM companies WHERE client_id = ? ORDER BY company_name ASC",
                    [$client->id]
                );
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->validateCsrf() && $this->db) {
                $clientId = $_SESSION['client_id'] ?? '';
                $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
                if ($client) {
                    $this->db->insert('sealings', [
                        'client_id'   => $client->id,
                        'company_id'  => $this->input('company_id'),
                        'seal_type'   => $this->input('seal_type', ''),
                        'seal_number' => $this->input('seal_number', ''),
                        'date_sealed' => $this->input('date_sealed') ?: null,
                        'description' => $this->input('description', ''),
                        'status'      => $this->input('status', 'Active'),
                        'created_by'  => $_SESSION['user_id'] ?? null,
                    ]);
                    $this->setFlash('success', 'Seal added successfully.');
                    $this->redirect('sealings_list');
                    return;
                }
            }
        }

        $this->loadLayout('misc/add_seal', $data);
    }
}

// Company Bank Accounts (maps to /company_bank)
class Company_bank extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title'    => 'Company Bank Accounts',
            'bank_accounts' => [],
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['bank_accounts'] = $this->db->fetchAll(
                    "SELECT cb.*, c.company_name, b.bank_name FROM company_bank_accounts cb 
                     LEFT JOIN companies c ON c.id = cb.company_id 
                     LEFT JOIN banks b ON b.id = cb.bank_id
                     WHERE c.client_id = ? ORDER BY c.company_name ASC",
                    [$client->id]
                );
            }
        }

        $this->loadLayout('misc/company_bank', $data);
    }
}

// Add Company Bank Account (maps to /add_company_bank)
class Add_company_bank extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Add Company Bank Account',
            'companies'  => [],
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['companies'] = $this->db->fetchAll(
                    "SELECT id, company_name FROM companies WHERE client_id = ? ORDER BY company_name ASC",
                    [$client->id]
                );
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->validateCsrf() && $this->db) {
                $clientId = $_SESSION['client_id'] ?? '';
                $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
                if ($client) {
                    $this->db->insert('company_bank_accounts', [
                        'client_id'      => $client->id,
                        'company_id'     => $this->input('company_id'),
                        'bank_name'      => $this->input('bank_name', ''),
                        'account_name'   => $this->input('account_name', ''),
                        'account_number' => $this->input('account_number', ''),
                        'branch'         => $this->input('branch', ''),
                        'swift_code'     => $this->input('swift_code', ''),
                        'currency'       => $this->input('currency', 'SGD'),
                        'status'         => $this->input('status', 'Active'),
                        'created_by'     => $_SESSION['user_id'] ?? null,
                    ]);
                    $this->setFlash('success', 'Bank account added successfully.');
                    $this->redirect('company_bank');
                    return;
                }
            }
        }

        $this->loadLayout('misc/add_company_bank', $data);
    }
}

// Reminder List (maps to /reminder_list)
class Reminder_list extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Reminders',
            'reminders'  => [],
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['reminders'] = $this->db->fetchAll(
                    "SELECT r.*, rs.subject_name FROM reminders r 
                     LEFT JOIN reminder_subjects rs ON rs.id = r.subject_id
                     WHERE r.client_id = ? ORDER BY r.reminder_name ASC",
                    [$client->id]
                );
            }
        }

        $this->loadLayout('misc/reminder_list', $data);
    }
}

// Set Reminder (maps to /set_reminder)
class Set_reminder extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = ['page_title' => 'Set Reminder'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->validateCsrf() && $this->db) {
                $this->db->insert('reminders', [
                    'user_id'       => $_SESSION['user_id'] ?? null,
                    'title'         => $this->input('title', ''),
                    'description'   => $this->input('description', ''),
                    'reminder_date' => $this->input('reminder_date') ?: null,
                    'reminder_time' => $this->input('reminder_time', ''),
                    'priority'      => $this->input('priority', 'Medium'),
                    'status'        => 'Active',
                    'created_by'    => $_SESSION['user_id'] ?? null,
                ]);
                $this->setFlash('success', 'Reminder created successfully.');
                $this->redirect('reminder_list');
                return;
            }
        }

        $this->loadLayout('misc/reminder_form', $data);
    }
}

// Edit Reminder (maps to /edit_reminder/{id})
class Edit_reminder extends BaseController {
    public function index($id = null) {
        $this->requireAuth();
        if (!$id) { $this->redirect('reminder_list'); return; }

        $data = [
            'page_title' => 'Edit Reminder',
            'reminder'   => null,
        ];

        if ($this->db) {
            $data['reminder'] = $this->db->fetchOne("SELECT * FROM reminders WHERE id = ?", [$id]);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->validateCsrf() && $this->db) {
                $this->db->update('reminders', [
                    'title'         => $this->input('title', ''),
                    'description'   => $this->input('description', ''),
                    'reminder_date' => $this->input('reminder_date') ?: null,
                    'reminder_time' => $this->input('reminder_time', ''),
                    'priority'      => $this->input('priority', 'Medium'),
                    'status'        => $this->input('status', 'Active'),
                ], 'id = ?', [$id]);
                $this->setFlash('success', 'Reminder updated successfully.');
                $this->redirect('reminder_list');
                return;
            }
        }

        $this->loadLayout('misc/reminder_form', $data);
    }
}

// eSign Settings (maps to /esign_settings)
class Esign_settings extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'eSign Settings',
            'settings'   => [],
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                try {
                    $data['settings'] = $this->db->fetchOne(
                        "SELECT * FROM settings_general WHERE client_id = ? AND setting_key LIKE 'esign_%'",
                        [$client->id]
                    );
                } catch (Exception $e) {
                    $data['settings'] = null;
                }
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->validateCsrf() && $this->db) {
                $clientId = $_SESSION['client_id'] ?? '';
                $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
                if ($client) {
                    // Save eSign settings as key-value pairs
                    $esignKeys = ['api_key', 'api_secret', 'provider', 'callback_url', 'esign_status'];
                    foreach ($esignKeys as $key) {
                        $fullKey = 'esign_' . $key;
                        $val = $this->input($key, '');
                        $existing = $this->db->fetchOne(
                            "SELECT id FROM settings_general WHERE client_id = ? AND setting_key = ?",
                            [$client->id, $fullKey]
                        );
                        if ($existing) {
                            $this->db->update('settings_general', ['setting_value' => $val], 'id = ?', [$existing->id]);
                        } else {
                            $this->db->insert('settings_general', ['client_id' => $client->id, 'setting_key' => $fullKey, 'setting_value' => $val]);
                        }
                    }
                    $this->setFlash('success', 'eSign settings saved successfully.');
                    $this->redirect('esign_settings');
                    return;
                }
            }
        }

        $this->loadLayout('misc/esign_settings', $data);
    }
}

// eSign Log (maps to /esign_log)
class Esign_log extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'eSign Audit Log',
            'logs'       => [],
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                try {
                    $data['logs'] = $this->db->fetchAll(
                        "SELECT ul.*, u.name as user_name FROM user_logs ul 
                         LEFT JOIN users u ON u.id = ul.user_id 
                         WHERE ul.client_id = ? AND ul.module = 'esign' ORDER BY ul.created_at DESC",
                        [$client->id]
                    );
                } catch (Exception $e) {
                    $data['logs'] = [];
                }
            }
        }

        $this->loadLayout('misc/esign_log', $data);
    }
}

// Member PDF Preview (maps to /member_pdf/{id})
class Member_pdf extends BaseController {
    public function index($id = null) {
        $this->requireAuth();
        if (!$id) { $this->redirect('member'); return; }

        $data = [
            'page_title' => 'Member PDF Preview',
            'member'     => null,
            'member_id'  => $id,
        ];

        if ($this->db) {
            $data['member'] = $this->db->fetchOne("SELECT * FROM members WHERE id = ?", [$id]);
        }

        $this->loadLayout('misc/member_pdf', $data);
    }
}

// Member Documents (maps to /member_documents/{id})
class Member_documents extends BaseController {
    public function index($id = null) {
        $this->requireAuth();
        if (!$id) { $this->redirect('member'); return; }

        $data = [
            'page_title' => 'Member Documents',
            'member' => null,
            'documents' => [],
        ];

        if ($this->db) {
            $data['member'] = $this->db->fetchOne("SELECT * FROM members WHERE id = ?", [$id]);
            $data['documents'] = $this->db->fetchAll(
                "SELECT * FROM documents WHERE entity_type = 'member' AND entity_id = ? ORDER BY created_at DESC",
                [$id]
            );
        }

        $this->loadLayout('misc/member_documents', $data);
    }
}

// Corporate Shareholder Company List (maps to /corp_share_comp_list)
class Corp_share_comp_list extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = ['page_title' => 'Corporate Shareholder - Company List', 'shareholders' => []];
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['shareholders'] = $this->db->fetchAll(
                    "SELECT s.*, c.company_name, c.registration_number, COALESCE(SUM(cs.number_of_shares),0) as total_shares FROM shareholders s JOIN companies c ON c.id = s.company_id LEFT JOIN company_shares cs ON cs.shareholder_id = s.id AND cs.type = 'Allotment' WHERE s.shareholder_type = 'Corporate' AND c.client_id = ? GROUP BY s.id ORDER BY c.company_name", [$client->id]
                );
            }
        }
        $this->loadLayout('shares/corporate_shareholder', $data);
    }
}

// Registered Address List (maps to /reg_address_list)
class Reg_address_list extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = ['page_title' => 'Registered Office Address List', 'addresses' => []];
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['addresses'] = $this->db->fetchAll(
                    "SELECT c.id, c.company_name, c.registration_number, COALESCE(a.address_text,'') as registered_address, COALESCE(a.postal_code,'') as postal_code, c.incorporation_date as date_of_incorporation, c.entity_status FROM companies c LEFT JOIN addresses a ON a.entity_type = 'company' AND a.entity_id = c.id AND a.address_type = 'Registered Office' WHERE c.client_id = ? ORDER BY c.company_name", [$client->id]
                );
            }
        }
        $this->loadLayout('misc/reg_address_list', $data);
    }
}

// FYE Date Not Entered PDF View (maps to /fye_pdf_view)
class Fye_pdf_view extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = ['page_title' => 'FYE Date Not Entered', 'companies' => []];
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['companies'] = $this->db->fetchAll(
                    "SELECT c.*, ct.type_name FROM companies c LEFT JOIN company_types ct ON ct.id = c.company_type_id WHERE c.client_id = ? AND (c.fye_date IS NULL) ORDER BY c.company_name", [$client->id]
                );
            }
        }
        $this->loadLayout('misc/fye_pdf_view', $data);
    }
}

// Event Receiving Parties (maps to /event_receiving_parties/{company_id})
class Event_receiving_parties extends BaseController {
    public function index($company_id = null) {
        $this->requireAuth();
        $data = ['page_title' => 'Event Receiving Parties', 'company' => null, 'parties' => []];
        if ($this->db && $company_id) {
            $data['company'] = $this->db->fetchOne("SELECT * FROM companies WHERE id = ?", [$company_id]);
        }
        $this->loadLayout('settings/event_receiving_parties', $data);
    }
}

// Agent Commission Setup (maps to /agent_commission_setup)
class Agent_commission_setup extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = ['page_title' => 'Product Agent Commission Setup', 'commissions' => [], 'users' => []];
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['users'] = $this->db->fetchAll("SELECT id, name FROM users WHERE client_id = ? ORDER BY name", [$client->id]);
            }
        }
        $this->loadLayout('settings/agent_commission', $data);
    }
}

// Recurring Event Names (maps to /recurring_event_name)
class Recurring_event_name extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = ['page_title' => 'Recurring Event Names', 'events' => []];
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['events'] = $this->db->fetchAll("SELECT * FROM event_types WHERE client_id = ? ORDER BY event_name", [$client->id]);
            }
        }
        $this->loadLayout('settings/recurring_event', $data);
    }
}

// Account Type List (maps to /mainadmin_account_type, /account_type)
class Account_type_list extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = ['page_title' => 'Account Types', 'account_types' => []];
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['account_types'] = $this->db->fetchAll(
                    "SELECT * FROM account_types WHERE client_id = ? ORDER BY type_name", [$client->id]
                );
            }
        }
        $this->loadLayout('misc/account_type_list', $data);
    }
}

// Add Account Type (maps to /mainadmin_add_account, /add_account_type)
class Add_account_type extends BaseController {
    public function index($id = null) {
        $this->requireAuth();
        $data = ['page_title' => ($id ? 'Edit' : 'Add') . ' Account Type', 'account_type' => null];
        if ($this->db && $id) {
            $data['account_type'] = $this->db->fetchOne("SELECT * FROM account_types WHERE id = ?", [$id]);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->validateCsrf() && $this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                if ($id) {
                    $this->db->execute("UPDATE account_types SET type_name=?, status=? WHERE id=?", [
                        $this->input('type_name',''), $this->input('status',1), $id
                    ]);
                    $this->setFlash('success', 'Account type updated.');
                } else {
                    $this->db->execute("INSERT INTO account_types (client_id, type_name, status) VALUES (?,?,?)", [
                        $client->id, $this->input('type_name',''), $this->input('status',1)
                    ]);
                    $this->setFlash('success', 'Account type added.');
                }
                $this->redirect('mainadmin_account_type'); return;
            }
        }
        $this->loadLayout('misc/add_account_type', $data);
    }
}
