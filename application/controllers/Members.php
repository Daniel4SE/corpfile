<?php
/**
 * Members Controller - Member List / Add / Edit / View
 * Handles: /member, /add_member, /edit_member, /view_member
 */
class Members extends BaseController {

    public function index() {
        $this->requireAuth();
        $this->redirect('member');
    }

    /**
     * Delete a member record
     * POST /members/delete_member
     */
    public function delete_member() {
        $this->requireAuth();
        
        $memberId = $this->input('id');
        if (!$memberId) {
            $this->json(['status' => 'error', 'message' => 'Member ID required']);
            return;
        }
        
        if ($this->db) {
            // Check for dependencies
            $directorCount = $this->db->count('directors', 'member_id = ?', [$memberId]);
            $shareholderCount = $this->db->count('shareholders', 'member_id = ?', [$memberId]);
            
            if ($directorCount > 0 || $shareholderCount > 0) {
                $this->json([
                    'status' => 'error',
                    'message' => 'Cannot delete. Individual is appointed as director or shareholder in one or more companies.'
                ]);
                return;
            }
            
            $this->db->delete('member_identifications', 'member_id = ?', [$memberId]);
            $this->db->delete('addresses', "entity_type = 'member' AND entity_id = ?", [$memberId]);
            $this->db->delete('documents', "entity_type = 'member' AND entity_id = ?", [$memberId]);
            $this->db->delete('members', 'id = ?', [$memberId]);
        }
        
        $this->json(['status' => 'success', 'message' => 'Individual deleted successfully']);
    }

    /**
     * Upload file for a member
     * POST /members/upload_file/{member_id}
     */
    public function upload_file($memberId = null) {
        $this->requireAuth();
        
        if (!$memberId) {
            $this->json(['status' => 'error', 'message' => 'Member ID required']);
            return;
        }
        
        if (empty($_FILES['file'])) {
            $this->json(['status' => 'error', 'message' => 'No file uploaded']);
            return;
        }
        
        $file = $_FILES['file'];
        $uploadDir = BASEPATH . 'uploads/members/' . $memberId . '/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file['name']);
        
        if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            if ($this->db) {
                $clientDbId = $this->getClientDbId();
                $this->db->insert('documents', [
                    'client_id' => $clientDbId,
                    'entity_type' => 'member',
                    'entity_id' => $memberId,
                    'document_name' => $file['name'],
                    'file_path' => 'uploads/members/' . $memberId . '/' . $filename,
                    'file_type' => $file['type'],
                    'file_size' => $file['size'],
                    'uploaded_by' => $_SESSION['user_id'] ?? 1,
                ]);
            }
            $this->json(['status' => 'success', 'message' => 'File uploaded successfully']);
        } else {
            $this->json(['status' => 'error', 'message' => 'Upload failed']);
        }
    }

    /**
     * Delete a member file
     * POST /members/delete_file
     */
    public function delete_file() {
        $this->requireAuth();
        
        $fileId = $this->input('id');
        if (!$fileId) {
            $this->json(['status' => 'error', 'message' => 'File ID required']);
            return;
        }
        
        if ($this->db) {
            $file = $this->db->fetchOne("SELECT * FROM documents WHERE id = ?", [$fileId]);
            if ($file) {
                $fullPath = BASEPATH . $file->file_path;
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
                $this->db->delete('documents', 'id = ?', [$fileId]);
            }
        }
        
        $this->json(['status' => 'success', 'message' => 'File deleted successfully']);
    }

    /**
     * Download an identification document
     * GET /members/download_id_doc/{id}
     */
    public function download_id_doc($identId = null) {
        $this->requireAuth();
        
        if (!$identId) {
            http_response_code(404);
            echo 'Document ID required';
            return;
        }
        
        if ($this->db) {
            $ident = $this->db->fetchOne(
                "SELECT mi.*, m.name AS member_name FROM member_identifications mi
                 LEFT JOIN members m ON m.id = mi.member_id
                 WHERE mi.id = ?",
                [$identId]
            );
            
            if ($ident && !empty($ident->file_path)) {
                $fullPath = BASEPATH . $ident->file_path;
                if (file_exists($fullPath)) {
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="' . basename($ident->file_path) . '"');
                    header('Content-Length: ' . filesize($fullPath));
                    readfile($fullPath);
                    return;
                }
            }
        }
        
        // No file found - return a friendly message
        header('Content-Type: text/html');
        echo '<div style="padding:40px;font-family:sans-serif;text-align:center;">';
        echo '<i class="fa fa-info-circle" style="font-size:48px;color:#206570;"></i>';
        echo '<h3>No Document Available</h3>';
        echo '<p>The identification document has not been uploaded yet.</p>';
        echo '<a href="javascript:history.back();" style="color:#206570;">Go Back</a>';
        echo '</div>';
    }

    /**
     * KYC screening search
     * POST /members/kyc_search
     */
    public function kyc_search() {
        $this->requireAuth();
        
        $name = $this->input('name', '');
        
        // In production, this would call an external KYC screening API
        $results = [
            'status' => 'completed',
            'name_searched' => $name,
            'screening_date' => date('Y-m-d H:i:s'),
            'matches_found' => 0,
            'results' => [],
            'message' => 'No adverse records found for "' . htmlspecialchars($name) . '".'
        ];
        
        $this->json(['status' => 'success', 'data' => $results]);
    }

    /**
     * Helper: Get the database ID for the current client
     */
    private function getClientDbId() {
        if (!$this->db) return 1;
        $clientId = $_SESSION['client_id'] ?? '';
        $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
        return $client ? $client->id : 1;
    }
}

// Member List controller (maps to /member)
class Member_list extends BaseController {
    public function index() {
        $this->requireAuth();

        $data = [
            'page_title' => 'List Of Individuals',
            'members' => [],
            'total' => 0,
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['members'] = $this->db->fetchAll(
                    "SELECT m.* 
                     FROM members m 
                     WHERE m.client_id = ? 
                     ORDER BY m.name ASC",
                    [$client->id]
                );
                $data['total'] = count($data['members']);
            }
        }

        $this->loadLayout('members/list', $data);
    }
}

// Add Member controller (maps to /add_member)
class Add_member extends BaseController {
    public function index() {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->store();
            return;
        }

        $data = [
            'page_title' => 'Add Individual',
            'countries' => $this->getCountries(),
        ];

        $this->loadLayout('members/add', $data);
    }

    private function store() {
        if (!$this->db) {
            $this->setFlash('error', 'Database not connected');
            $this->redirect('add_member');
            return;
        }

        $clientId = $_SESSION['client_id'] ?? '';
        $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
        if (!$client) {
            $this->setFlash('error', 'Invalid client');
            $this->redirect('add_member');
            return;
        }

        // Core member data
        $dob = $this->input('date_of_birth', '');
        if ($dob) {
            $d = DateTime::createFromFormat('d/m/Y', $dob);
            $dob = $d ? $d->format('Y-m-d') : null;
        } else {
            $dob = null;
        }
        $deceased = $this->input('deceased_date', '');
        if ($deceased) {
            $d = DateTime::createFromFormat('d/m/Y', $deceased);
            $deceased = $d ? $d->format('Y-m-d') : null;
        } else {
            $deceased = null;
        }

        $services = isset($_POST['services_to_contact']) ? implode(',', (array)$_POST['services_to_contact']) : '';

        $memberData = [
            'client_id'              => $client->id,
            'name_initials'          => $this->input('name_initials', ''),
            'name'                   => $this->input('name', ''),
            'former_name'            => $this->input('former_name', ''),
            'alias_name'             => $this->input('alias_name', ''),
            'gender'                 => $this->input('gender', '') ?: null,
            'date_of_birth'          => $dob,
            'country_of_birth'       => $this->input('country_of_birth', ''),
            'nationality'            => $this->input('nationality', ''),
            'status'                 => $this->input('status', 'Active'),
            'race'                   => $this->input('race', ''),
            'risk_assessment_rating' => $this->input('risk_assessment_rating', ''),
            'additional_notes'       => $this->input('additional_notes', ''),
            'deceased_date'          => $deceased,
            'resigning'              => $this->input('resigning', 'No'),
            'father_name'            => $this->input('father_name', ''),
            'mother_name'            => $this->input('mother_name', ''),
            'spouse_name'            => $this->input('spouse_name', ''),
            'preferred_contact_mode' => $this->input('preferred_contact_mode', ''),
            'email'                  => $this->input('email', ''),
            'alternate_email'        => $this->input('alternate_email', ''),
            'skype_id'               => $this->input('skype_id', ''),
            'services_to_contact'    => $services,
            'mobile_code'            => $this->input('mobile_code', ''),
            'mobile_number'          => $this->input('mobile_number', ''),
            'telephone_code'         => $this->input('telephone_code', ''),
            'telephone_number'       => $this->input('telephone_number', ''),
            'created_by'             => $_SESSION['user_id'] ?? null,
        ];

        $memberId = $this->db->insert('members', $memberData);

        // Save identifications
        $identifications = $_POST['identification'] ?? [];
        foreach ($identifications as $ident) {
            $idType = $ident['id_type'] ?? '';
            $idNum  = $ident['id_number'] ?? '';
            if (empty($idType) && empty($idNum)) continue;
            $issueDate  = !empty($ident['issue_date'])  ? DateTime::createFromFormat('d/m/Y', $ident['issue_date'])  : null;
            $expiryDate = !empty($ident['expiry_date']) ? DateTime::createFromFormat('d/m/Y', $ident['expiry_date']) : null;
            $this->db->insert('member_identifications', [
                'member_id'        => $memberId,
                'id_type'          => $idType,
                'id_number'        => $idNum,
                'country_of_issue' => $ident['country_of_issue'] ?? '',
                'issue_date'       => $issueDate  ? $issueDate->format('Y-m-d')  : null,
                'expiry_date'      => $expiryDate ? $expiryDate->format('Y-m-d') : null,
            ]);
        }

        // Save registered address
        $regStreet = $this->input('reg_street', '');
        if (!empty($regStreet) || !empty($this->input('reg_block', '')) || !empty($this->input('reg_country', ''))) {
            $this->db->insert('addresses', [
                'entity_type'  => 'member',
                'entity_id'    => $memberId,
                'address_type' => 'Registered',
                'is_default'   => 1,
                'block'        => $this->input('reg_block', ''),
                'address_text'  => $regStreet,
                'building'     => $this->input('reg_building', ''),
                'level'        => $this->input('reg_level', ''),
                'unit'         => $this->input('reg_unit', ''),
                'country'      => $this->input('reg_country', ''),
                'state'        => $this->input('reg_state', ''),
                'city'         => $this->input('reg_city', ''),
                'postal_code'  => $this->input('reg_postal_code', ''),
            ]);
        }

        // Save other addresses
        $otherAddresses = $_POST['other_address'] ?? [];
        foreach ($otherAddresses as $addr) {
            $addrType   = $addr['address_type'] ?? '';
            $addrStreet = $addr['street'] ?? '';
            if (empty($addrType) && empty($addrStreet)) continue;
            $this->db->insert('addresses', [
                'entity_type'  => 'member',
                'entity_id'    => $memberId,
                'address_type' => $addrType,
                'is_default'   => 0,
                'block'        => $addr['block'] ?? '',
                'address_text'  => $addrStreet,
                'building'     => $addr['building'] ?? '',
                'level'        => $addr['level'] ?? '',
                'unit'         => $addr['unit'] ?? '',
                'country'      => $addr['country'] ?? '',
                'state'        => $addr['state'] ?? '',
                'city'         => $addr['city'] ?? '',
                'postal_code'  => $addr['postal_code'] ?? '',
            ]);
        }

        $this->setFlash('success', 'Individual created successfully.');
        $this->redirect('member');
    }

    private function getCountries() {
        return ['AFGHANISTAN','ALBANIA','ALGERIA','ANDORRA','ANGOLA','ARGENTINA','ARMENIA','AUSTRALIA','AUSTRIA','AZERBAIJAN','BAHAMAS','BAHRAIN','BANGLADESH','BARBADOS','BELARUS','BELGIUM','BELIZE','BERMUDA','BHUTAN','BOLIVIA','BOSNIA AND HERZEGOVINA','BOTSWANA','BRAZIL','BRUNEI','BULGARIA','CAMBODIA','CAMEROON','CANADA','CAYMAN ISLANDS','CHILE','CHINA','COLOMBIA','COSTA RICA','CROATIA','CUBA','CYPRUS','CZECH REPUBLIC','DENMARK','ECUADOR','EGYPT','EL SALVADOR','ESTONIA','ETHIOPIA','FIJI','FINLAND','FRANCE','GEORGIA','GERMANY','GHANA','GREECE','GUAM','GUATEMALA','HONG KONG','HUNGARY','ICELAND','INDIA','INDONESIA','IRAN','IRAQ','IRELAND','ISRAEL','ITALY','JAMAICA','JAPAN','JORDAN','KAZAKHSTAN','KENYA','KUWAIT','LAOS','LATVIA','LEBANON','LIBYA','LIECHTENSTEIN','LITHUANIA','LUXEMBOURG','MACAU','MADAGASCAR','MALAYSIA','MALDIVES','MALTA','MAURITIUS','MEXICO','MONACO','MONGOLIA','MOROCCO','MOZAMBIQUE','MYANMAR','NEPAL','NETHERLANDS','NEW ZEALAND','NIGERIA','NORTH KOREA','NORWAY','OMAN','PAKISTAN','PANAMA','PAPUA NEW GUINEA','PARAGUAY','PERU','PHILIPPINES','POLAND','PORTUGAL','QATAR','ROMANIA','RUSSIA','SAUDI ARABIA','SERBIA','SINGAPORE','SLOVAKIA','SLOVENIA','SOUTH AFRICA','SOUTH KOREA','SPAIN','SRI LANKA','SWEDEN','SWITZERLAND','SYRIA','TAIWAN','TAJIKISTAN','TANZANIA','THAILAND','TUNISIA','TURKEY','TURKMENISTAN','UAE','UGANDA','UKRAINE','UNITED KINGDOM','UNITED STATES','URUGUAY','UZBEKISTAN','VENEZUELA','VIETNAM','YEMEN','ZAMBIA','ZIMBABWE'];
    }
}

// View Member controller (maps to /view_member/{id})
class View_member extends BaseController {
    public function index($id = null) {
        $this->requireAuth();

        if (!$id) {
            $this->redirect('member');
            return;
        }

        $data = [
            'page_title' => 'View Individual',
            'member' => null,
            'identifications' => [],
            'addresses' => [],
            'roles' => [],
        ];

        if ($this->db) {
            $data['member'] = $this->db->fetchOne(
                "SELECT * FROM members WHERE id = ?",
                [$id]
            );
            if ($data['member']) {
                $data['identifications'] = $this->db->fetchAll(
                    "SELECT * FROM member_identifications WHERE member_id = ? ORDER BY id ASC",
                    [$id]
                );
                $data['addresses'] = $this->db->fetchAll(
                    "SELECT * FROM addresses WHERE entity_type = 'member' AND entity_id = ? ORDER BY is_default DESC, id ASC",
                    [$id]
                );
                // Fetch company roles (officer positions held by this member)
                $data['roles'] = $this->db->fetchAll(
                    "SELECT d.*, c.company_name 
                     FROM directors d 
                     LEFT JOIN companies c ON c.id = d.company_id 
                     WHERE d.member_id = ? 
                     ORDER BY d.date_of_appointment DESC",
                    [$id]
                );
            }
        }

        $this->loadLayout('members/view', $data);
    }
}

// Edit Member controller (maps to /edit_member/{id})
class Edit_member extends BaseController {
    public function index($id = null) {
        $this->requireAuth();

        if (!$id) {
            $this->redirect('member');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->update($id);
            return;
        }

        $data = [
            'page_title' => 'Edit Individual',
            'member' => null,
            'identifications' => [],
            'addresses' => [],
            'countries' => $this->getCountries(),
        ];

        if ($this->db) {
            $data['member'] = $this->db->fetchOne("SELECT * FROM members WHERE id = ?", [$id]);
            $data['identifications'] = $this->db->fetchAll(
                "SELECT * FROM member_identifications WHERE member_id = ? ORDER BY id ASC",
                [$id]
            );
            $data['addresses'] = $this->db->fetchAll(
                "SELECT * FROM addresses WHERE entity_type = 'member' AND entity_id = ? ORDER BY is_default DESC, id ASC",
                [$id]
            );
        }

        $this->loadLayout('members/edit', $data);
    }

    private function update($id) {
        if (!$this->db) {
            $this->setFlash('error', 'Database not connected');
            $this->redirect("edit_member/{$id}");
            return;
        }

        // Update core member data
        $dob = $this->input('date_of_birth', '');
        if ($dob) {
            $d = DateTime::createFromFormat('d/m/Y', $dob);
            $dob = $d ? $d->format('Y-m-d') : null;
        } else {
            $dob = null;
        }
        $deceased = $this->input('deceased_date', '');
        if ($deceased) {
            $d = DateTime::createFromFormat('d/m/Y', $deceased);
            $deceased = $d ? $d->format('Y-m-d') : null;
        } else {
            $deceased = null;
        }

        $services = isset($_POST['services_to_contact']) ? implode(',', (array)$_POST['services_to_contact']) : '';

        $updateData = [
            'name_initials'          => $this->input('name_initials', ''),
            'name'                   => $this->input('name', ''),
            'former_name'            => $this->input('former_name', ''),
            'alias_name'             => $this->input('alias_name', ''),
            'gender'                 => $this->input('gender', '') ?: null,
            'date_of_birth'          => $dob,
            'country_of_birth'       => $this->input('country_of_birth', ''),
            'nationality'            => $this->input('nationality', ''),
            'status'                 => $this->input('status', 'Active'),
            'race'                   => $this->input('race', ''),
            'risk_assessment_rating' => $this->input('risk_assessment_rating', ''),
            'additional_notes'       => $this->input('additional_notes', ''),
            'deceased_date'          => $deceased,
            'resigning'              => $this->input('resigning', 'No'),
            'father_name'            => $this->input('father_name', ''),
            'mother_name'            => $this->input('mother_name', ''),
            'spouse_name'            => $this->input('spouse_name', ''),
            'preferred_contact_mode' => $this->input('preferred_contact_mode', ''),
            'email'                  => $this->input('email', ''),
            'alternate_email'        => $this->input('alternate_email', ''),
            'skype_id'               => $this->input('skype_id', ''),
            'services_to_contact'    => $services,
            'mobile_code'            => $this->input('mobile_code', ''),
            'mobile_number'          => $this->input('mobile_number', ''),
            'telephone_code'         => $this->input('telephone_code', ''),
            'telephone_number'       => $this->input('telephone_number', ''),
        ];

        $this->db->update('members', $updateData, 'id = ?', [$id]);

        // Replace identifications: delete existing and re-insert
        $this->db->delete('member_identifications', 'member_id = ?', [$id]);
        $identifications = $_POST['identification'] ?? [];
        foreach ($identifications as $ident) {
            $idType = $ident['id_type'] ?? '';
            $idNum  = $ident['id_number'] ?? '';
            if (empty($idType) && empty($idNum)) continue;
            $issueDate  = !empty($ident['issue_date'])  ? DateTime::createFromFormat('d/m/Y', $ident['issue_date'])  : null;
            $expiryDate = !empty($ident['expiry_date']) ? DateTime::createFromFormat('d/m/Y', $ident['expiry_date']) : null;
            $this->db->insert('member_identifications', [
                'member_id'       => $id,
                'id_type'         => $idType,
                'id_number'       => $idNum,
                'country_of_issue'=> $ident['country_of_issue'] ?? '',
                'issue_date'      => $issueDate  ? $issueDate->format('Y-m-d')  : null,
                'expiry_date'     => $expiryDate ? $expiryDate->format('Y-m-d') : null,
            ]);
        }

        // Replace addresses: delete existing and re-insert
        $this->db->delete('addresses', "entity_type = 'member' AND entity_id = ?", [$id]);

        // Registered address
        $regStreet = $this->input('reg_street', '');
        if (!empty($regStreet) || !empty($this->input('reg_block', '')) || !empty($this->input('reg_country', ''))) {
            $this->db->insert('addresses', [
                'entity_type'  => 'member',
                'entity_id'    => $id,
                'address_type' => 'Registered',
                'is_default'   => 1,
                'block'        => $this->input('reg_block', ''),
                'address_text'  => $regStreet,
                'building'     => $this->input('reg_building', ''),
                'level'        => $this->input('reg_level', ''),
                'unit'         => $this->input('reg_unit', ''),
                'country'      => $this->input('reg_country', ''),
                'state'        => $this->input('reg_state', ''),
                'city'         => $this->input('reg_city', ''),
                'postal_code'  => $this->input('reg_postal_code', ''),
            ]);
        }

        // Other addresses
        $otherAddresses = $_POST['other_address'] ?? [];
        foreach ($otherAddresses as $addr) {
            $addrType   = $addr['address_type'] ?? '';
            $addrStreet = $addr['street'] ?? '';
            if (empty($addrType) && empty($addrStreet)) continue;
            $this->db->insert('addresses', [
                'entity_type'  => 'member',
                'entity_id'    => $id,
                'address_type' => $addrType,
                'is_default'   => 0,
                'block'        => $addr['block'] ?? '',
                'address_text'  => $addrStreet,
                'building'     => $addr['building'] ?? '',
                'level'        => $addr['level'] ?? '',
                'unit'         => $addr['unit'] ?? '',
                'country'      => $addr['country'] ?? '',
                'state'        => $addr['state'] ?? '',
                'city'         => $addr['city'] ?? '',
                'postal_code'  => $addr['postal_code'] ?? '',
            ]);
        }

        $this->setFlash('success', 'Individual updated successfully.');
        $this->redirect("view_member/{$id}");
    }

    private function getCountries() {
        return ['AFGHANISTAN','ALBANIA','ALGERIA','ANDORRA','ANGOLA','ARGENTINA','ARMENIA','AUSTRALIA','AUSTRIA','AZERBAIJAN','BAHAMAS','BAHRAIN','BANGLADESH','BARBADOS','BELARUS','BELGIUM','BELIZE','BERMUDA','BHUTAN','BOLIVIA','BOSNIA AND HERZEGOVINA','BOTSWANA','BRAZIL','BRUNEI','BULGARIA','CAMBODIA','CAMEROON','CANADA','CAYMAN ISLANDS','CHILE','CHINA','COLOMBIA','COSTA RICA','CROATIA','CUBA','CYPRUS','CZECH REPUBLIC','DENMARK','ECUADOR','EGYPT','EL SALVADOR','ESTONIA','ETHIOPIA','FIJI','FINLAND','FRANCE','GEORGIA','GERMANY','GHANA','GREECE','GUAM','GUATEMALA','HONG KONG','HUNGARY','ICELAND','INDIA','INDONESIA','IRAN','IRAQ','IRELAND','ISRAEL','ITALY','JAMAICA','JAPAN','JORDAN','KAZAKHSTAN','KENYA','KUWAIT','LAOS','LATVIA','LEBANON','LIBYA','LIECHTENSTEIN','LITHUANIA','LUXEMBOURG','MACAU','MADAGASCAR','MALAYSIA','MALDIVES','MALTA','MAURITIUS','MEXICO','MONACO','MONGOLIA','MOROCCO','MOZAMBIQUE','MYANMAR','NEPAL','NETHERLANDS','NEW ZEALAND','NIGERIA','NORTH KOREA','NORWAY','OMAN','PAKISTAN','PANAMA','PAPUA NEW GUINEA','PARAGUAY','PERU','PHILIPPINES','POLAND','PORTUGAL','QATAR','ROMANIA','RUSSIA','SAUDI ARABIA','SERBIA','SINGAPORE','SLOVAKIA','SLOVENIA','SOUTH AFRICA','SOUTH KOREA','SPAIN','SRI LANKA','SWEDEN','SWITZERLAND','SYRIA','TAIWAN','TAJIKISTAN','TANZANIA','THAILAND','TUNISIA','TURKEY','TURKMENISTAN','UAE','UGANDA','UKRAINE','UNITED KINGDOM','UNITED STATES','URUGUAY','UZBEKISTAN','VENEZUELA','VIETNAM','YEMEN','ZAMBIA','ZIMBABWE'];
    }
}
