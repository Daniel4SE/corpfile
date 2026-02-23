<?php
/**
 * Officials Controller - Company Officials Management
 * Handles: /company_officials, /officials_list, /add_director, /add_shareholder,
 *          /add_secretary, /add_auditor, /add_representative, /add_manager, /add_ceo
 */
class Officials extends BaseController {
    
    public function index() {
        $this->requireAuth();
        $this->redirect('company_officials');
    }
}

// =========================================================================
// Global Company Officials Listing (maps to /company_officials)
// =========================================================================
class Company_officials extends BaseController {
    public function index() {
        $this->requireAuth();
        
        $data = [
            'page_title' => 'Company Officials',
            'companies' => [],
        ];
        
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['companies'] = $this->db->fetchAll(
                    "SELECT c.id, c.company_name, c.registration_number,
                        (SELECT COUNT(*) FROM company_officials co WHERE co.company_id = c.id AND co.official_type = 'director') as total_directors,
                        (SELECT COUNT(*) FROM company_officials co WHERE co.company_id = c.id AND co.official_type = 'shareholder') as total_shareholders,
                        (SELECT COUNT(*) FROM company_officials co WHERE co.company_id = c.id AND co.official_type = 'secretary') as total_secretaries,
                        (SELECT COUNT(*) FROM company_officials co WHERE co.company_id = c.id AND co.official_type = 'auditor') as total_auditors,
                        (SELECT COUNT(*) FROM company_officials co WHERE co.company_id = c.id AND co.official_type = 'manager') as total_managers
                     FROM companies c
                     WHERE c.client_id = ? AND c.internal_css_status IS NOT NULL
                     ORDER BY c.company_name ASC",
                    [$client->id]
                );
            }
        }
        
        $this->loadLayout('officials/list', $data);
    }
}

// =========================================================================
// Per-Company Officials List (maps to /officials_list/{company_id})
// =========================================================================
class Officials_list extends BaseController {
    public function index($company_id = null) {
        $this->requireAuth();
        
        if (!$company_id) {
            $this->redirect('company_officials');
            return;
        }
        
        $data = [
            'page_title' => 'Company Officials',
            'company' => null,
            'company_id' => $company_id,
            'directors' => [],
            'shareholders' => [],
            'secretaries' => [],
            'auditors' => [],
            'controllers' => [],
            'contact_persons' => [],
            'chair_persons' => [],
            'data_protection_officers' => [],
            'partners' => [],
            'nominee_trustees' => [],
            'agents' => [],
            'fund_managers' => [],
            'owners' => [],
            'chief_representatives' => [],
            'deputy_representatives' => [],
            'ep_holders' => [],
            'dp_holders' => [],
            'corporate_representatives' => [],
            'ceos' => [],
            'managers' => [],
            'representatives' => [],
        ];
        
        if ($this->db) {
            $data['company'] = $this->db->fetchOne(
                "SELECT c.*, ct.type_name as company_type_name 
                 FROM companies c 
                 LEFT JOIN company_types ct ON ct.id = c.company_type_id 
                 WHERE c.id = ?",
                [$company_id]
            );
            
            if ($data['company']) {
                $data['page_title'] = 'Officials - ' . $data['company']->company_name;
                $data['directors'] = $this->db->fetchAll("SELECT * FROM directors WHERE company_id = ? ORDER BY status DESC, date_of_appointment DESC", [$company_id]);
                $data['shareholders'] = $this->db->fetchAll("SELECT * FROM shareholders WHERE company_id = ? ORDER BY status DESC", [$company_id]);
                $data['secretaries'] = $this->db->fetchAll("SELECT * FROM secretaries WHERE company_id = ? ORDER BY status DESC", [$company_id]);
                $data['auditors'] = $this->db->fetchAll("SELECT * FROM auditors WHERE company_id = ? ORDER BY status DESC", [$company_id]);
                // Generic company_officials table queries for additional types
                $officerTypes = [
                    'controller', 'contact_person', 'chair_person', 'data_protection',
                    'partner', 'nominee_trustee', 'agent', 'fund_manager', 'owner',
                    'chief_representative', 'deputy_representative', 'ep_holder',
                    'dp_holder', 'corporate_representative', 'ceo', 'manager', 'representative'
                ];
                foreach ($officerTypes as $type) {
                    $key = $type . 's';
                    if ($type === 'data_protection') $key = 'data_protection_officers';
                    $data[$key] = $this->db->fetchAll(
                        "SELECT * FROM company_officials WHERE company_id = ? AND official_type = ? ORDER BY status DESC, date_of_appointment DESC",
                        [$company_id, $type]
                    ) ?: [];
                }
            }
        }
        
        $this->loadLayout('officials/company_officials', $data);
    }
}

// =========================================================================
// Add Director (maps to /add_director/{company_id})
// =========================================================================
class Add_director extends BaseController {
    public function index($company_id = null) {
        $this->requireAuth();
        if (!$company_id) { $this->redirect('company_officials'); return; }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->store($company_id);
            return;
        }
        
        $data = [
            'page_title' => 'Add Director',
            'company_id' => $company_id,
            'company' => null,
            'officer_type' => 'director',
            'countries' => $this->getCountries(),
        ];
        
        if ($this->db) {
            $data['company'] = $this->db->fetchOne("SELECT id, company_name FROM companies WHERE id = ?", [$company_id]);
        }
        
        $this->loadLayout('officials/add_officer', $data);
    }
    
    private function store($company_id) {
        if (!$this->validateCsrf()) {
            $this->setFlash('error', 'Invalid security token.');
            $this->redirect("add_director/{$company_id}");
            return;
        }
        if (!$this->db) {
            $this->setFlash('error', 'Database not connected');
            $this->redirect("add_director/{$company_id}");
            return;
        }
        
        $this->db->insert('directors', [
            'company_id' => $company_id,
            'role' => 'director',
            'name' => $this->input('name', ''),
            'id_type' => $this->input('id_type', ''),
            'id_expiry_date' => $this->input('id_expiry_date') ?: null,
            'id_number' => $this->input('id_number', ''),
            'nationality' => $this->input('nationality', ''),
            'local_address' => $this->input('local_address', ''),
            'foreign_address' => $this->input('foreign_address', ''),
            'alt_local_address' => $this->input('alt_local_address', ''),
            'alt_foreign_address' => $this->input('alt_foreign_address', ''),
            'email' => $this->input('email', ''),
            'contact_number' => $this->input('contact_number', ''),
            'date_of_birth' => $this->input('date_of_birth') ?: null,
            'business_occupation' => $this->input('business_occupation', ''),
            'other_directorship' => $this->input('other_directorship', ''),
            'nominee_director' => $this->input('nominee_director', 'No'),
            'registrable_controller' => $this->input('registrable_controller', 'No'),
            'date_of_appointment' => $this->input('date_of_appointment') ?: null,
            'appointment_type' => $this->input('appointment_type', 'Effective'),
            'date_of_cessation' => $this->input('date_of_cessation') ?: null,
            'company_email' => $this->input('company_email', ''),
            'company_contact_code' => $this->input('company_contact_code', '65'),
            'company_contact_number' => $this->input('company_contact_number', ''),
            'company_telephone_code' => $this->input('company_telephone_code', '65'),
            'company_telephone_number' => $this->input('company_telephone_number', ''),
            'status' => 'Active',
            'created_by' => $_SESSION['user_id'] ?? null,
        ]);
        
        $this->setFlash('success', 'Director added successfully.');
        $this->redirect("officials_list/{$company_id}");
    }
    
    private function getCountries() {
        return ['AFGHANISTAN','ALBANIA','ALGERIA','ANDORRA','ANGOLA','ARGENTINA','ARMENIA','AUSTRALIA','AUSTRIA','AZERBAIJAN','BAHAMAS','BAHRAIN','BANGLADESH','BARBADOS','BELARUS','BELGIUM','BELIZE','BERMUDA','BHUTAN','BOLIVIA','BOSNIA AND HERZEGOVINA','BOTSWANA','BRAZIL','BRUNEI','BULGARIA','CAMBODIA','CAMEROON','CANADA','CAYMAN ISLANDS','CHILE','CHINA','COLOMBIA','COSTA RICA','CROATIA','CUBA','CYPRUS','CZECH REPUBLIC','DENMARK','ECUADOR','EGYPT','EL SALVADOR','ESTONIA','ETHIOPIA','FIJI','FINLAND','FRANCE','GEORGIA','GERMANY','GHANA','GREECE','GUAM','GUATEMALA','HONG KONG','HUNGARY','ICELAND','INDIA','INDONESIA','IRAN','IRAQ','IRELAND','ISRAEL','ITALY','JAMAICA','JAPAN','JORDAN','KAZAKHSTAN','KENYA','KUWAIT','LAOS','LATVIA','LEBANON','LIBYA','LIECHTENSTEIN','LITHUANIA','LUXEMBOURG','MACAU','MADAGASCAR','MALAYSIA','MALDIVES','MALTA','MAURITIUS','MEXICO','MONACO','MONGOLIA','MOROCCO','MOZAMBIQUE','MYANMAR','NEPAL','NETHERLANDS','NEW ZEALAND','NIGERIA','NORTH KOREA','NORWAY','OMAN','PAKISTAN','PANAMA','PAPUA NEW GUINEA','PARAGUAY','PERU','PHILIPPINES','POLAND','PORTUGAL','QATAR','ROMANIA','RUSSIA','SAUDI ARABIA','SERBIA','SINGAPORE','SLOVAKIA','SLOVENIA','SOUTH AFRICA','SOUTH KOREA','SPAIN','SRI LANKA','SWEDEN','SWITZERLAND','SYRIA','TAIWAN','TAJIKISTAN','TANZANIA','THAILAND','TUNISIA','TURKEY','TURKMENISTAN','UAE','UGANDA','UKRAINE','UNITED KINGDOM','UNITED STATES','URUGUAY','UZBEKISTAN','VENEZUELA','VIETNAM','YEMEN','ZAMBIA','ZIMBABWE'];
    }
}

// =========================================================================
// Add Shareholder (maps to /add_shareholder/{company_id})
// =========================================================================
class Add_shareholder extends BaseController {
    public function index($company_id = null) {
        $this->requireAuth();
        if (!$company_id) { $this->redirect('company_officials'); return; }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->store($company_id);
            return;
        }
        
        $data = [
            'page_title' => 'Add Shareholder',
            'company_id' => $company_id,
            'company' => null,
            'officer_type' => 'shareholder',
            'countries' => $this->getCountries(),
        ];
        
        if ($this->db) {
            $data['company'] = $this->db->fetchOne("SELECT id, company_name FROM companies WHERE id = ?", [$company_id]);
        }
        
        $this->loadLayout('officials/add_officer', $data);
    }
    
    private function store($company_id) {
        if (!$this->validateCsrf()) {
            $this->setFlash('error', 'Invalid security token.');
            $this->redirect("add_shareholder/{$company_id}");
            return;
        }
        if (!$this->db) {
            $this->setFlash('error', 'Database not connected');
            $this->redirect("add_shareholder/{$company_id}");
            return;
        }
        
        $shareholderType = $this->input('shareholder_type', 'Individual');
        
        $insertData = [
            'company_id' => $company_id,
            'shareholder_type' => $shareholderType,
            'name' => $this->input('name', ''),
            'date_of_appointment' => $this->input('date_of_appointment') ?: null,
            'date_of_cessation' => $this->input('date_of_cessation') ?: null,
            'status' => 'Active',
            'created_by' => $_SESSION['user_id'] ?? null,
        ];
        
        if ($shareholderType === 'Individual') {
            $insertData += [
                'id_type' => $this->input('id_type', ''),
                'id_number' => $this->input('id_number', ''),
                'nationality' => $this->input('nationality', ''),
                'local_address' => $this->input('local_address', ''),
                'foreign_address' => $this->input('foreign_address', ''),
                'email' => $this->input('email', ''),
                'date_of_birth' => $this->input('date_of_birth') ?: null,
            ];
        } else {
            $insertData += [
                'corp_registration_no' => $this->input('corp_registration_no', ''),
                'corp_company_name' => $this->input('corp_company_name', ''),
                'corp_company_type' => $this->input('corp_company_type', ''),
                'corp_reg_office_address' => $this->input('corp_reg_office_address', ''),
                'corp_incorp_date' => $this->input('corp_incorp_date') ?: null,
                'corp_country' => $this->input('corp_country', ''),
                'corp_status' => $this->input('corp_status', ''),
            ];
        }
        
        $this->db->insert('shareholders', $insertData);
        
        $this->setFlash('success', 'Shareholder added successfully.');
        $this->redirect("officials_list/{$company_id}");
    }
    
    private function getCountries() {
        return ['AFGHANISTAN','ALBANIA','ALGERIA','ANDORRA','ANGOLA','ARGENTINA','ARMENIA','AUSTRALIA','AUSTRIA','AZERBAIJAN','BAHAMAS','BAHRAIN','BANGLADESH','BARBADOS','BELARUS','BELGIUM','BELIZE','BERMUDA','BHUTAN','BOLIVIA','BOSNIA AND HERZEGOVINA','BOTSWANA','BRAZIL','BRUNEI','BULGARIA','CAMBODIA','CAMEROON','CANADA','CAYMAN ISLANDS','CHILE','CHINA','COLOMBIA','COSTA RICA','CROATIA','CUBA','CYPRUS','CZECH REPUBLIC','DENMARK','ECUADOR','EGYPT','EL SALVADOR','ESTONIA','ETHIOPIA','FIJI','FINLAND','FRANCE','GEORGIA','GERMANY','GHANA','GREECE','GUAM','GUATEMALA','HONG KONG','HUNGARY','ICELAND','INDIA','INDONESIA','IRAN','IRAQ','IRELAND','ISRAEL','ITALY','JAMAICA','JAPAN','JORDAN','KAZAKHSTAN','KENYA','KUWAIT','LAOS','LATVIA','LEBANON','LIBYA','LIECHTENSTEIN','LITHUANIA','LUXEMBOURG','MACAU','MADAGASCAR','MALAYSIA','MALDIVES','MALTA','MAURITIUS','MEXICO','MONACO','MONGOLIA','MOROCCO','MOZAMBIQUE','MYANMAR','NEPAL','NETHERLANDS','NEW ZEALAND','NIGERIA','NORTH KOREA','NORWAY','OMAN','PAKISTAN','PANAMA','PAPUA NEW GUINEA','PARAGUAY','PERU','PHILIPPINES','POLAND','PORTUGAL','QATAR','ROMANIA','RUSSIA','SAUDI ARABIA','SERBIA','SINGAPORE','SLOVAKIA','SLOVENIA','SOUTH AFRICA','SOUTH KOREA','SPAIN','SRI LANKA','SWEDEN','SWITZERLAND','SYRIA','TAIWAN','TAJIKISTAN','TANZANIA','THAILAND','TUNISIA','TURKEY','TURKMENISTAN','UAE','UGANDA','UKRAINE','UNITED KINGDOM','UNITED STATES','URUGUAY','UZBEKISTAN','VENEZUELA','VIETNAM','YEMEN','ZAMBIA','ZIMBABWE'];
    }
}

// =========================================================================
// Add Secretary (maps to /add_secretary/{company_id})
// =========================================================================
class Add_secretary extends BaseController {
    public function index($company_id = null) {
        $this->requireAuth();
        if (!$company_id) { $this->redirect('company_officials'); return; }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->store($company_id);
            return;
        }
        
        $data = [
            'page_title' => 'Add Secretary',
            'company_id' => $company_id,
            'company' => null,
            'officer_type' => 'secretary',
            'countries' => $this->getCountries(),
        ];
        
        if ($this->db) {
            $data['company'] = $this->db->fetchOne("SELECT id, company_name FROM companies WHERE id = ?", [$company_id]);
        }
        
        $this->loadLayout('officials/add_officer', $data);
    }
    
    private function store($company_id) {
        if (!$this->validateCsrf()) {
            $this->setFlash('error', 'Invalid security token.');
            $this->redirect("add_secretary/{$company_id}");
            return;
        }
        if (!$this->db) {
            $this->setFlash('error', 'Database not connected');
            $this->redirect("add_secretary/{$company_id}");
            return;
        }
        
        $this->db->insert('secretaries', [
            'company_id' => $company_id,
            'name' => $this->input('name', ''),
            'id_type' => $this->input('id_type', ''),
            'id_expiry_date' => $this->input('id_expiry_date') ?: null,
            'id_number' => $this->input('id_number', ''),
            'nationality' => $this->input('nationality', ''),
            'local_address' => $this->input('local_address', ''),
            'foreign_address' => $this->input('foreign_address', ''),
            'email' => $this->input('email', ''),
            'contact_number' => $this->input('contact_number', ''),
            'date_of_birth' => $this->input('date_of_birth') ?: null,
            'date_of_appointment' => $this->input('date_of_appointment') ?: null,
            'date_of_cessation' => $this->input('date_of_cessation') ?: null,
            'status' => 'Active',
            'created_by' => $_SESSION['user_id'] ?? null,
        ]);
        
        $this->setFlash('success', 'Secretary added successfully.');
        $this->redirect("officials_list/{$company_id}");
    }
    
    private function getCountries() {
        return ['AFGHANISTAN','ALBANIA','ALGERIA','ANDORRA','ANGOLA','ARGENTINA','ARMENIA','AUSTRALIA','AUSTRIA','AZERBAIJAN','BAHAMAS','BAHRAIN','BANGLADESH','BARBADOS','BELARUS','BELGIUM','BELIZE','BERMUDA','BHUTAN','BOLIVIA','BOSNIA AND HERZEGOVINA','BOTSWANA','BRAZIL','BRUNEI','BULGARIA','CAMBODIA','CAMEROON','CANADA','CAYMAN ISLANDS','CHILE','CHINA','COLOMBIA','COSTA RICA','CROATIA','CUBA','CYPRUS','CZECH REPUBLIC','DENMARK','ECUADOR','EGYPT','EL SALVADOR','ESTONIA','ETHIOPIA','FIJI','FINLAND','FRANCE','GEORGIA','GERMANY','GHANA','GREECE','GUAM','GUATEMALA','HONG KONG','HUNGARY','ICELAND','INDIA','INDONESIA','IRAN','IRAQ','IRELAND','ISRAEL','ITALY','JAMAICA','JAPAN','JORDAN','KAZAKHSTAN','KENYA','KUWAIT','LAOS','LATVIA','LEBANON','LIBYA','LIECHTENSTEIN','LITHUANIA','LUXEMBOURG','MACAU','MADAGASCAR','MALAYSIA','MALDIVES','MALTA','MAURITIUS','MEXICO','MONACO','MONGOLIA','MOROCCO','MOZAMBIQUE','MYANMAR','NEPAL','NETHERLANDS','NEW ZEALAND','NIGERIA','NORTH KOREA','NORWAY','OMAN','PAKISTAN','PANAMA','PAPUA NEW GUINEA','PARAGUAY','PERU','PHILIPPINES','POLAND','PORTUGAL','QATAR','ROMANIA','RUSSIA','SAUDI ARABIA','SERBIA','SINGAPORE','SLOVAKIA','SLOVENIA','SOUTH AFRICA','SOUTH KOREA','SPAIN','SRI LANKA','SWEDEN','SWITZERLAND','SYRIA','TAIWAN','TAJIKISTAN','TANZANIA','THAILAND','TUNISIA','TURKEY','TURKMENISTAN','UAE','UGANDA','UKRAINE','UNITED KINGDOM','UNITED STATES','URUGUAY','UZBEKISTAN','VENEZUELA','VIETNAM','YEMEN','ZAMBIA','ZIMBABWE'];
    }
}

// =========================================================================
// Add Auditor (maps to /add_auditor/{company_id})
// =========================================================================
class Add_auditor extends BaseController {
    public function index($company_id = null) {
        $this->requireAuth();
        if (!$company_id) { $this->redirect('company_officials'); return; }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->store($company_id);
            return;
        }
        
        $data = [
            'page_title' => 'Add Auditor',
            'company_id' => $company_id,
            'company' => null,
            'officer_type' => 'auditor',
            'countries' => $this->getCountries(),
        ];
        
        if ($this->db) {
            $data['company'] = $this->db->fetchOne("SELECT id, company_name FROM companies WHERE id = ?", [$company_id]);
        }
        
        $this->loadLayout('officials/add_officer', $data);
    }
    
    private function store($company_id) {
        if (!$this->validateCsrf()) {
            $this->setFlash('error', 'Invalid security token.');
            $this->redirect("add_auditor/{$company_id}");
            return;
        }
        if (!$this->db) {
            $this->setFlash('error', 'Database not connected');
            $this->redirect("add_auditor/{$company_id}");
            return;
        }
        
        $this->db->insert('auditors', [
            'company_id' => $company_id,
            'firm_name' => $this->input('firm_name', ''),
            'name' => $this->input('name', ''),
            'date_of_appointment' => $this->input('date_of_appointment') ?: null,
            'date_of_cessation' => $this->input('date_of_cessation') ?: null,
            'status' => 'Active',
            'created_by' => $_SESSION['user_id'] ?? null,
        ]);
        
        $this->setFlash('success', 'Auditor added successfully.');
        $this->redirect("officials_list/{$company_id}");
    }
    
    private function getCountries() {
        return ['SINGAPORE','MALAYSIA','HONG KONG','CHINA','INDIA','UNITED STATES','UNITED KINGDOM','AUSTRALIA'];
    }
}

// =========================================================================
// Add Representative (maps to /add_representative/{company_id})
// =========================================================================
class Add_representative extends BaseController {
    public function index($company_id = null) {
        $this->requireAuth();
        if (!$company_id) { $this->redirect('company_officials'); return; }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->storeOfficer($company_id, 'representative');
            return;
        }
        
        $data = [
            'page_title' => 'Add Representative',
            'company_id' => $company_id,
            'company' => null,
            'officer_type' => 'representative',
            'countries' => $this->getCountries(),
        ];
        
        if ($this->db) {
            $data['company'] = $this->db->fetchOne("SELECT id, company_name FROM companies WHERE id = ?", [$company_id]);
        }
        
        $this->loadLayout('officials/add_officer', $data);
    }
    
    private function storeOfficer($company_id, $type) {
        if (!$this->validateCsrf()) {
            $this->setFlash('error', 'Invalid security token.');
            $this->redirect("add_{$type}/{$company_id}");
            return;
        }
        if (!$this->db) {
            $this->setFlash('error', 'Database not connected');
            $this->redirect("add_{$type}/{$company_id}");
            return;
        }
        
        $this->db->insert('officers', [
            'company_id' => $company_id,
            'officer_type' => $type,
            'name' => $this->input('name', ''),
            'id_type' => $this->input('id_type', ''),
            'id_number' => $this->input('id_number', ''),
            'id_expiry_date' => $this->input('id_expiry_date') ?: null,
            'nationality' => $this->input('nationality', ''),
            'local_address' => $this->input('local_address', ''),
            'foreign_address' => $this->input('foreign_address', ''),
            'email' => $this->input('email', ''),
            'contact_number' => $this->input('contact_number', ''),
            'date_of_birth' => $this->input('date_of_birth') ?: null,
            'date_of_appointment' => $this->input('date_of_appointment') ?: null,
            'date_of_cessation' => $this->input('date_of_cessation') ?: null,
            'status' => 'Active',
            'created_by' => $_SESSION['user_id'] ?? null,
        ]);
        
        $typeLabel = ucfirst(str_replace('_', ' ', $type));
        $this->setFlash('success', "{$typeLabel} added successfully.");
        $this->redirect("officials_list/{$company_id}");
    }
    
    private function getCountries() {
        return ['AFGHANISTAN','ALBANIA','ALGERIA','ANDORRA','ANGOLA','ARGENTINA','ARMENIA','AUSTRALIA','AUSTRIA','AZERBAIJAN','BAHAMAS','BAHRAIN','BANGLADESH','BARBADOS','BELARUS','BELGIUM','BELIZE','BERMUDA','BHUTAN','BOLIVIA','BOSNIA AND HERZEGOVINA','BOTSWANA','BRAZIL','BRUNEI','BULGARIA','CAMBODIA','CAMEROON','CANADA','CAYMAN ISLANDS','CHILE','CHINA','COLOMBIA','COSTA RICA','CROATIA','CUBA','CYPRUS','CZECH REPUBLIC','DENMARK','ECUADOR','EGYPT','EL SALVADOR','ESTONIA','ETHIOPIA','FIJI','FINLAND','FRANCE','GEORGIA','GERMANY','GHANA','GREECE','GUAM','GUATEMALA','HONG KONG','HUNGARY','ICELAND','INDIA','INDONESIA','IRAN','IRAQ','IRELAND','ISRAEL','ITALY','JAMAICA','JAPAN','JORDAN','KAZAKHSTAN','KENYA','KUWAIT','LAOS','LATVIA','LEBANON','LIBYA','LIECHTENSTEIN','LITHUANIA','LUXEMBOURG','MACAU','MADAGASCAR','MALAYSIA','MALDIVES','MALTA','MAURITIUS','MEXICO','MONACO','MONGOLIA','MOROCCO','MOZAMBIQUE','MYANMAR','NEPAL','NETHERLANDS','NEW ZEALAND','NIGERIA','NORTH KOREA','NORWAY','OMAN','PAKISTAN','PANAMA','PAPUA NEW GUINEA','PARAGUAY','PERU','PHILIPPINES','POLAND','PORTUGAL','QATAR','ROMANIA','RUSSIA','SAUDI ARABIA','SERBIA','SINGAPORE','SLOVAKIA','SLOVENIA','SOUTH AFRICA','SOUTH KOREA','SPAIN','SRI LANKA','SWEDEN','SWITZERLAND','SYRIA','TAIWAN','TAJIKISTAN','TANZANIA','THAILAND','TUNISIA','TURKEY','TURKMENISTAN','UAE','UGANDA','UKRAINE','UNITED KINGDOM','UNITED STATES','URUGUAY','UZBEKISTAN','VENEZUELA','VIETNAM','YEMEN','ZAMBIA','ZIMBABWE'];
    }
}

// =========================================================================
// Add Manager (maps to /add_manager/{company_id})
// =========================================================================
class Add_manager extends BaseController {
    public function index($company_id = null) {
        $this->requireAuth();
        if (!$company_id) { $this->redirect('company_officials'); return; }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->storeOfficer($company_id, 'manager');
            return;
        }
        
        $data = [
            'page_title' => 'Add Manager',
            'company_id' => $company_id,
            'company' => null,
            'officer_type' => 'manager',
            'countries' => $this->getCountries(),
        ];
        
        if ($this->db) {
            $data['company'] = $this->db->fetchOne("SELECT id, company_name FROM companies WHERE id = ?", [$company_id]);
        }
        
        $this->loadLayout('officials/add_officer', $data);
    }
    
    private function storeOfficer($company_id, $type) {
        if (!$this->validateCsrf()) {
            $this->setFlash('error', 'Invalid security token.');
            $this->redirect("add_{$type}/{$company_id}");
            return;
        }
        if (!$this->db) {
            $this->setFlash('error', 'Database not connected');
            $this->redirect("add_{$type}/{$company_id}");
            return;
        }
        
        $this->db->insert('officers', [
            'company_id' => $company_id,
            'officer_type' => $type,
            'name' => $this->input('name', ''),
            'id_type' => $this->input('id_type', ''),
            'id_number' => $this->input('id_number', ''),
            'id_expiry_date' => $this->input('id_expiry_date') ?: null,
            'nationality' => $this->input('nationality', ''),
            'local_address' => $this->input('local_address', ''),
            'foreign_address' => $this->input('foreign_address', ''),
            'email' => $this->input('email', ''),
            'contact_number' => $this->input('contact_number', ''),
            'date_of_birth' => $this->input('date_of_birth') ?: null,
            'date_of_appointment' => $this->input('date_of_appointment') ?: null,
            'date_of_cessation' => $this->input('date_of_cessation') ?: null,
            'status' => 'Active',
            'created_by' => $_SESSION['user_id'] ?? null,
        ]);
        
        $typeLabel = ucfirst(str_replace('_', ' ', $type));
        $this->setFlash('success', "{$typeLabel} added successfully.");
        $this->redirect("officials_list/{$company_id}");
    }
    
    private function getCountries() {
        return ['AFGHANISTAN','ALBANIA','ALGERIA','ANDORRA','ANGOLA','ARGENTINA','ARMENIA','AUSTRALIA','AUSTRIA','AZERBAIJAN','BAHAMAS','BAHRAIN','BANGLADESH','BARBADOS','BELARUS','BELGIUM','BELIZE','BERMUDA','BHUTAN','BOLIVIA','BOSNIA AND HERZEGOVINA','BOTSWANA','BRAZIL','BRUNEI','BULGARIA','CAMBODIA','CAMEROON','CANADA','CAYMAN ISLANDS','CHILE','CHINA','COLOMBIA','COSTA RICA','CROATIA','CUBA','CYPRUS','CZECH REPUBLIC','DENMARK','ECUADOR','EGYPT','EL SALVADOR','ESTONIA','ETHIOPIA','FIJI','FINLAND','FRANCE','GEORGIA','GERMANY','GHANA','GREECE','GUAM','GUATEMALA','HONG KONG','HUNGARY','ICELAND','INDIA','INDONESIA','IRAN','IRAQ','IRELAND','ISRAEL','ITALY','JAMAICA','JAPAN','JORDAN','KAZAKHSTAN','KENYA','KUWAIT','LAOS','LATVIA','LEBANON','LIBYA','LIECHTENSTEIN','LITHUANIA','LUXEMBOURG','MACAU','MADAGASCAR','MALAYSIA','MALDIVES','MALTA','MAURITIUS','MEXICO','MONACO','MONGOLIA','MOROCCO','MOZAMBIQUE','MYANMAR','NEPAL','NETHERLANDS','NEW ZEALAND','NIGERIA','NORTH KOREA','NORWAY','OMAN','PAKISTAN','PANAMA','PAPUA NEW GUINEA','PARAGUAY','PERU','PHILIPPINES','POLAND','PORTUGAL','QATAR','ROMANIA','RUSSIA','SAUDI ARABIA','SERBIA','SINGAPORE','SLOVAKIA','SLOVENIA','SOUTH AFRICA','SOUTH KOREA','SPAIN','SRI LANKA','SWEDEN','SWITZERLAND','SYRIA','TAIWAN','TAJIKISTAN','TANZANIA','THAILAND','TUNISIA','TURKEY','TURKMENISTAN','UAE','UGANDA','UKRAINE','UNITED KINGDOM','UNITED STATES','URUGUAY','UZBEKISTAN','VENEZUELA','VIETNAM','YEMEN','ZAMBIA','ZIMBABWE'];
    }
}

// =========================================================================
// Add CEO (maps to /add_ceo/{company_id})
// =========================================================================
class Add_ceo extends BaseController {
    public function index($company_id = null) {
        $this->requireAuth();
        if (!$company_id) { $this->redirect('company_officials'); return; }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->storeOfficer($company_id, 'ceo');
            return;
        }
        
        $data = [
            'page_title' => 'Add CEO',
            'company_id' => $company_id,
            'company' => null,
            'officer_type' => 'ceo',
            'countries' => $this->getCountries(),
        ];
        
        if ($this->db) {
            $data['company'] = $this->db->fetchOne("SELECT id, company_name FROM companies WHERE id = ?", [$company_id]);
        }
        
        $this->loadLayout('officials/add_officer', $data);
    }
    
    private function storeOfficer($company_id, $type) {
        if (!$this->validateCsrf()) {
            $this->setFlash('error', 'Invalid security token.');
            $this->redirect("add_{$type}/{$company_id}");
            return;
        }
        if (!$this->db) {
            $this->setFlash('error', 'Database not connected');
            $this->redirect("add_{$type}/{$company_id}");
            return;
        }
        
        $this->db->insert('officers', [
            'company_id' => $company_id,
            'officer_type' => $type,
            'name' => $this->input('name', ''),
            'id_type' => $this->input('id_type', ''),
            'id_number' => $this->input('id_number', ''),
            'id_expiry_date' => $this->input('id_expiry_date') ?: null,
            'nationality' => $this->input('nationality', ''),
            'local_address' => $this->input('local_address', ''),
            'foreign_address' => $this->input('foreign_address', ''),
            'email' => $this->input('email', ''),
            'contact_number' => $this->input('contact_number', ''),
            'date_of_birth' => $this->input('date_of_birth') ?: null,
            'date_of_appointment' => $this->input('date_of_appointment') ?: null,
            'date_of_cessation' => $this->input('date_of_cessation') ?: null,
            'status' => 'Active',
            'created_by' => $_SESSION['user_id'] ?? null,
        ]);
        
        $this->setFlash('success', 'CEO added successfully.');
        $this->redirect("officials_list/{$company_id}");
    }
    
    private function getCountries() {
        return ['AFGHANISTAN','ALBANIA','ALGERIA','ANDORRA','ANGOLA','ARGENTINA','ARMENIA','AUSTRALIA','AUSTRIA','AZERBAIJAN','BAHAMAS','BAHRAIN','BANGLADESH','BARBADOS','BELARUS','BELGIUM','BELIZE','BERMUDA','BHUTAN','BOLIVIA','BOSNIA AND HERZEGOVINA','BOTSWANA','BRAZIL','BRUNEI','BULGARIA','CAMBODIA','CAMEROON','CANADA','CAYMAN ISLANDS','CHILE','CHINA','COLOMBIA','COSTA RICA','CROATIA','CUBA','CYPRUS','CZECH REPUBLIC','DENMARK','ECUADOR','EGYPT','EL SALVADOR','ESTONIA','ETHIOPIA','FIJI','FINLAND','FRANCE','GEORGIA','GERMANY','GHANA','GREECE','GUAM','GUATEMALA','HONG KONG','HUNGARY','ICELAND','INDIA','INDONESIA','IRAN','IRAQ','IRELAND','ISRAEL','ITALY','JAMAICA','JAPAN','JORDAN','KAZAKHSTAN','KENYA','KUWAIT','LAOS','LATVIA','LEBANON','LIBYA','LIECHTENSTEIN','LITHUANIA','LUXEMBOURG','MACAU','MADAGASCAR','MALAYSIA','MALDIVES','MALTA','MAURITIUS','MEXICO','MONACO','MONGOLIA','MOROCCO','MOZAMBIQUE','MYANMAR','NEPAL','NETHERLANDS','NEW ZEALAND','NIGERIA','NORTH KOREA','NORWAY','OMAN','PAKISTAN','PANAMA','PAPUA NEW GUINEA','PARAGUAY','PERU','PHILIPPINES','POLAND','PORTUGAL','QATAR','ROMANIA','RUSSIA','SAUDI ARABIA','SERBIA','SINGAPORE','SLOVAKIA','SLOVENIA','SOUTH AFRICA','SOUTH KOREA','SPAIN','SRI LANKA','SWEDEN','SWITZERLAND','SYRIA','TAIWAN','TAJIKISTAN','TANZANIA','THAILAND','TUNISIA','TURKEY','TURKMENISTAN','UAE','UGANDA','UKRAINE','UNITED KINGDOM','UNITED STATES','URUGUAY','UZBEKISTAN','VENEZUELA','VIETNAM','YEMEN','ZAMBIA','ZIMBABWE'];
    }
}
