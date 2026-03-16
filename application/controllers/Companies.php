<?php
/**
 * Companies Controller - Company List / Add / Edit / View
 * Handles: /company_list, /add_company, /edit_company, /view_company
 */
class Companies extends BaseController {
    
    public function index() {
        $this->requireAuth();
        $this->redirect('company_list');
    }

    /**
     * Delete a company record
     * GET /companies/delete/{id}
     */
    public function delete($id = null) {
        $this->requireAuth();
        if ($id && $this->db) {
            // Delete related records first
            $this->db->delete('directors', 'company_id = ?', [$id]);
            $this->db->delete('shareholders', 'company_id = ?', [$id]);
            $this->db->delete('secretaries', 'company_id = ?', [$id]);
            $this->db->delete('auditors', 'company_id = ?', [$id]);
            $this->db->delete('company_officials', 'company_id = ?', [$id]);
            $this->db->delete('addresses', "entity_type = 'company' AND entity_id = ?", [$id]);
            $this->db->delete('documents', "entity_type = 'company' AND entity_id = ?", [$id]);
            $this->db->delete('companies', 'id = ?', [$id]);
        }
        $this->redirect('company_list');
    }

    /**
     * Get company files list (JSON)
     * GET /companies/get_files/{company_id}
     */
    public function get_files($companyId = null) {
        $this->requireAuth();
        
        $files = [];
        if ($this->db && $companyId) {
            $files = $this->db->fetchAll(
                "SELECT d.*, u.name as uploaded_by_name 
                 FROM documents d 
                 LEFT JOIN users u ON u.id = d.uploaded_by
                 WHERE d.entity_type = 'company' AND d.entity_id = ? 
                 ORDER BY d.created_at DESC",
                [$companyId]
            );
        }
        
        $this->json(['status' => 'success', 'data' => $files]);
    }

    /**
     * Get company activity log (JSON)
     * GET /companies/get_activity_log/{company_id}
     */
    public function get_activity_log($companyId = null) {
        $this->requireAuth();
        
        $logs = [];
        if ($this->db && $companyId) {
            $logs = $this->db->fetchAll(
                "SELECT ul.*, u.name as user_name 
                 FROM user_logs ul 
                 LEFT JOIN users u ON u.id = ul.user_id
                 WHERE ul.module = 'companies' AND ul.record_id = ? 
                 ORDER BY ul.created_at DESC
                 LIMIT 100",
                [$companyId]
            );
        }
        
        $this->json(['status' => 'success', 'data' => $logs]);
    }

    /**
     * Upload file for a company
     * POST /companies/upload_file/{company_id}
     */
    public function upload_file($companyId = null) {
        $this->requireAuth();
        
        if (!$companyId) {
            $this->json(['status' => 'error', 'message' => 'Company ID required']);
            return;
        }
        
        if (empty($_FILES['file'])) {
            $this->json(['status' => 'error', 'message' => 'No file uploaded']);
            return;
        }
        
        $file = $_FILES['file'];
        $categoryId = $this->input('category_id');
        $uploadDir = BASEPATH . 'uploads/companies/' . $companyId . '/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file['name']);
        
        if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            $docId = 0;
            if ($this->db) {
                $clientDbId = $this->getClientDbId();
                $docId = $this->db->insert('documents', [
                    'client_id' => $clientDbId,
                    'entity_type' => 'company',
                    'entity_id' => $companyId,
                    'category_id' => $categoryId,
                    'document_name' => $file['name'],
                    'file_path' => 'uploads/companies/' . $companyId . '/' . $filename,
                    'file_type' => $file['type'],
                    'file_size' => $file['size'],
                    'uploaded_by' => $_SESSION['user_id'] ?? 1,
                ]);
            }
            $this->json(['status' => 'success', 'message' => 'File uploaded successfully', 'id' => $docId]);
        } else {
            $this->json(['status' => 'error', 'message' => 'Upload failed']);
        }
    }

    /**
     * Delete a company file
     * POST /companies/delete_file/{file_id}
     */
    public function delete_file($fileId = null) {
        $this->requireAuth();
        
        if (!$fileId) {
            $fileId = $this->input('id');
        }
        
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
     * Delete a company record (director, shareholder, secretary, auditor, etc.)
     * POST /companies/delete_director/{id}, /companies/delete_shareholder/{id}, etc.
     * The method name starts with "delete_" followed by the type
     */
    public function __call($name, $arguments) {
        if (strpos($name, 'delete_') === 0) {
            $this->requireAuth();
            $type = substr($name, 7); // remove "delete_" prefix
            $id = $arguments[0] ?? $this->input('id');
            
            if (!$id) {
                $this->json(['status' => 'error', 'message' => 'Record ID required']);
                return;
            }
            
            $tableMap = [
                'director'       => 'directors',
                'shareholder'    => 'shareholders',
                'secretary'      => 'secretaries',
                'auditor'        => 'auditors',
                'controller'     => 'controllers',
                'contact_person' => 'company_officials',
                'chairperson'    => 'company_officials',
                'dpo'            => 'company_officials',
                'representative' => 'company_officials',
                'ceo'            => 'company_officials',
                'nominee'        => 'company_officials',
                'ubo'            => 'company_officials',
                'official'       => 'company_officials',
                'other'          => 'company_officials',
            ];
            
            $table = $tableMap[$type] ?? null;
            if (!$table) {
                $this->json(['status' => 'error', 'message' => 'Invalid record type: ' . $type]);
                return;
            }
            
            if ($this->db) {
                $this->db->delete($table, 'id = ?', [$id]);
            }
            
            $this->json(['status' => 'success', 'message' => ucfirst(str_replace('_', ' ', $type)) . ' deleted successfully']);
            return;
        }
        
        // Handle officer form loading: director_form, shareholder_form, etc.
        if (strpos($name, '_form') !== false) {
            $this->requireAuth();
            $type = str_replace('_form', '', $name);
            $companyId = $arguments[0] ?? null;
            $recordId = $arguments[1] ?? null;
            $this->loadOfficerForm($type, $companyId, $recordId);
            return;
        }
        
        http_response_code(404);
        echo '404 - Method not found: ' . htmlspecialchars($name);
    }

    /**
     * Render officer form HTML for modal
     */
    private function loadOfficerForm($type, $companyId, $recordId = null) {
        $typeLabels = [
            'director' => 'Director', 'shareholder' => 'Shareholder',
            'secretary' => 'Secretary', 'auditor' => 'Auditor',
            'controller' => 'Registrable Controller', 'contact_person' => 'Contact Person',
            'chairperson' => 'Chairperson', 'dpo' => 'Data Protection Officer',
            'representative' => 'Authorized Representative', 'ceo' => 'CEO',
            'nominee' => 'Nominee', 'ubo' => 'Ultimate Beneficial Owner', 'other' => 'Other',
        ];
        
        $label = $typeLabels[$type] ?? ucfirst($type);
        $record = null;
        $members = [];
        
        if ($this->db) {
            $clientDbId = $this->getClientDbId();
            $members = $this->db->fetchAll(
                "SELECT id, name, email FROM members WHERE client_id = ? ORDER BY name",
                [$clientDbId]
            );
            
            if ($recordId) {
                $tableMap = [
                    'director' => 'directors', 'shareholder' => 'shareholders',
                    'secretary' => 'secretaries', 'auditor' => 'auditors',
                    'controller' => 'controllers',
                ];
                $table = $tableMap[$type] ?? 'company_officials';
                $record = $this->db->fetchOne("SELECT * FROM {$table} WHERE id = ?", [$recordId]);
            }
        }
        
        $isEdit = $record !== null;
        
        // Render inline form HTML
        echo '<form id="officerForm" method="POST">';
        echo '<input type="hidden" name="ci_csrf_token" value="' . $this->generateCsrfToken() . '">';
        echo '<input type="hidden" name="officer_type" value="' . htmlspecialchars($type) . '">';
        echo '<input type="hidden" name="company_id" value="' . htmlspecialchars($companyId) . '">';
        if ($recordId) echo '<input type="hidden" name="record_id" value="' . htmlspecialchars($recordId) . '">';
        
        echo '<div class="form-group"><label>Select Existing Individual</label>';
        echo '<select name="member_id" class="form-control select2"><option value="">-- Select --</option>';
        foreach ($members as $m) {
            $sel = ($record && isset($record->member_id) && $record->member_id == $m->id) ? ' selected' : '';
            echo '<option value="' . $m->id . '"' . $sel . '>' . htmlspecialchars($m->name) . '</option>';
        }
        echo '</select></div>';
        
        echo '<div class="form-group"><label>Name <span class="required">*</span></label>';
        echo '<input type="text" name="name" class="form-control" required value="' . htmlspecialchars($record->name ?? '') . '"></div>';
        
        echo '<div class="row"><div class="col-md-6"><div class="form-group"><label>ID Type</label>';
        echo '<select name="id_type" class="form-control"><option value="">Select</option>';
        foreach (['NRIC', 'Passport', 'FIN'] as $idt) {
            $sel = ($record && isset($record->id_type) && $record->id_type === $idt) ? ' selected' : '';
            echo '<option value="' . $idt . '"' . $sel . '>' . $idt . '</option>';
        }
        echo '</select></div></div>';
        echo '<div class="col-md-6"><div class="form-group"><label>ID Number</label>';
        echo '<input type="text" name="id_number" class="form-control" value="' . htmlspecialchars($record->id_number ?? '') . '"></div></div></div>';
        
        echo '<div class="row"><div class="col-md-6"><div class="form-group"><label>Nationality</label>';
        echo '<input type="text" name="nationality" class="form-control" value="' . htmlspecialchars($record->nationality ?? '') . '"></div></div>';
        echo '<div class="col-md-6"><div class="form-group"><label>Email</label>';
        echo '<input type="email" name="email" class="form-control" value="' . htmlspecialchars($record->email ?? '') . '"></div></div></div>';
        
        echo '<div class="row"><div class="col-md-6"><div class="form-group"><label>Date of Appointment</label>';
        echo '<input type="date" name="date_of_appointment" class="form-control" value="' . ($record->date_of_appointment ?? '') . '"></div></div>';
        echo '<div class="col-md-6"><div class="form-group"><label>Date of Cessation</label>';
        echo '<input type="date" name="date_of_cessation" class="form-control" value="' . ($record->date_of_cessation ?? '') . '"></div></div></div>';
        
        echo '<div class="form-group text-right" style="margin-top:15px;">';
        echo '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> ';
        echo '<button type="submit" class="btn btn-primary">' . ($isEdit ? 'Update' : 'Add') . ' ' . $label . '</button>';
        echo '</div></form>';
        exit;
    }

    /**
     * View a company file (opens file in browser)
     * GET /companies/view_file/{file_id}
     */
    public function view_file($fileId = null) {
        $this->requireAuth();
        
        if ($this->db && $fileId) {
            $file = $this->db->fetchOne("SELECT * FROM documents WHERE id = ?", [$fileId]);
            if ($file) {
                $fullPath = BASEPATH . $file->file_path;
                if (file_exists($fullPath)) {
                    header('Content-Type: ' . ($file->file_type ?: 'application/octet-stream'));
                    header('Content-Disposition: inline; filename="' . basename($file->document_name) . '"');
                    readfile($fullPath);
                    exit;
                }
            }
        }
        
        http_response_code(404);
        echo 'File not found';
    }

    /**
     * Download a company file
     * GET /companies/download_file/{file_id}
     */
    public function download_file($fileId = null) {
        $this->requireAuth();
        
        if ($this->db && $fileId) {
            $file = $this->db->fetchOne("SELECT * FROM documents WHERE id = ?", [$fileId]);
            if ($file) {
                $fullPath = BASEPATH . $file->file_path;
                if (file_exists($fullPath)) {
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="' . basename($file->document_name) . '"');
                    header('Content-Length: ' . filesize($fullPath));
                    readfile($fullPath);
                    exit;
                }
            }
        }
        
        http_response_code(404);
        echo 'File not found';
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

// Company List controller (maps to /company_list)
class Company_list extends BaseController {
    private $tableCache = [];
    private $columnCache = [];

    private function hasTable($table) {
        if (isset($this->tableCache[$table])) {
            return $this->tableCache[$table];
        }
        if (!$this->db) {
            $this->tableCache[$table] = false;
            return false;
        }
        $row = $this->db->fetchOne("SHOW TABLES LIKE ?", [$table]);
        $this->tableCache[$table] = (bool)$row;
        return $this->tableCache[$table];
    }

    private function hasColumn($table, $column) {
        $key = $table . '.' . $column;
        if (isset($this->columnCache[$key])) {
            return $this->columnCache[$key];
        }
        if (!$this->db) {
            $this->columnCache[$key] = false;
            return false;
        }
        $row = $this->db->fetchOne(
            "SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ? LIMIT 1",
            [$table, $column]
        );
        $this->columnCache[$key] = (bool)$row;
        return $this->columnCache[$key];
    }

    private function getClientRecord() {
        if (!$this->db) return null;
        $clientId = $_SESSION['client_id'] ?? '';
        if (!$clientId) return null;
        return $this->db->fetchOne("SELECT id, company_name FROM clients WHERE client_id = ?", [$clientId]);
    }

    private function readFilters() {
        $alerts = $_GET['alert'] ?? [];
        if (is_string($alerts) && $alerts !== '') {
            $alerts = explode(',', $alerts);
        }
        if (!is_array($alerts)) {
            $alerts = [];
        }

        $companyIds = $_GET['company_id'] ?? [];
        if (!is_array($companyIds)) {
            $companyIds = [$companyIds];
        }

        $entityStatus = trim((string)($_GET['filter_entity_status'] ?? ''));
        $clientType = trim((string)($_GET['client_type'] ?? ($_GET['type'] ?? '')));

        return [
            'country' => strtolower(trim((string)($_GET['country'] ?? 'all'))),
            'company_ids' => array_values(array_filter(array_map('intval', $companyIds))),
            'reg_no' => trim((string)($_GET['filter_reg_no'] ?? '')),
            'status' => trim((string)($_GET['filter_status'] ?? '')),
            'entity_status' => in_array($entityStatus, ['prospect', 'client', 'non_client'], true) ? $entityStatus : '',
            'client_type' => in_array($clientType, ['css_client', 'accounting_only', 'audit_client', 'listed_related'], true) ? $clientType : '',
            'alerts' => array_values(array_intersect(['fye', 'agm_due', 'ar_due', 'ep_due', 'id_passport_due', 'missing_info'], array_map('strtolower', array_map('trim', $alerts)))),
        ];
    }

    private function countryCondition($country) {
        if ($country === 'sg' || $country === 'singapore') {
            return ["UPPER(COALESCE(c.country, '')) = 'SINGAPORE'", []];
        }
        if ($country === 'my' || $country === 'malaysia') {
            return ["UPPER(COALESCE(c.country, '')) = 'MALAYSIA'", []];
        }
        if ($country === 'bvi_cayman' || $country === 'bvi' || $country === 'cayman') {
            return ["UPPER(COALESCE(c.country, '')) IN ('BVI', 'CAYMAN ISLANDS', 'BRITISH VIRGIN ISLANDS')", []];
        }
        return ['', []];
    }

    private function clientTypeCondition($clientType, $clientCompanyName) {
        if ($clientType === 'css_client') {
            if (!$this->hasTable('secretaries') && !$this->hasColumn('companies', 'is_css_client')) {
                return ['0 = 1', []];
            }
            $flag = $this->hasColumn('companies', 'is_css_client') ? 'c.is_css_client = 1 OR ' : '';
            $secretaryCheck = $this->hasTable('secretaries') ? "EXISTS (
                    SELECT 1 FROM secretaries s
                    WHERE s.company_id = c.id
                      AND UPPER(TRIM(COALESCE(s.name, ''))) = UPPER(TRIM(?))
                )" : '0 = 1';
            return [
                '(' . $flag . $secretaryCheck . ')',
                [$clientCompanyName]
            ];
        }

        if ($clientType === 'accounting_only') {
            if (!$this->hasColumn('companies', 'is_accounting_client')) {
                return ['0 = 1', []];
            }
            $auditField = $this->hasColumn('companies', 'is_audit_client') ? 'COALESCE(c.is_audit_client, 0)' : '0';
            return ["c.is_accounting_client = 1 AND {$auditField} = 0", []];
        }

        if ($clientType === 'audit_client') {
            if (!$this->hasTable('auditors') && !$this->hasColumn('companies', 'is_audit_client')) {
                return ['0 = 1', []];
            }
            $flag = $this->hasColumn('companies', 'is_audit_client') ? 'c.is_audit_client = 1 OR ' : '';
            $auditorCheck = $this->hasTable('auditors') ? "EXISTS (
                    SELECT 1 FROM auditors a
                    WHERE a.company_id = c.id
                      AND (
                        UPPER(TRIM(COALESCE(a.name, ''))) = UPPER(TRIM(?))
                        OR UPPER(TRIM(COALESCE(a.firm_name, ''))) = UPPER(TRIM(?))
                      )
                )" : '0 = 1';
            return [
                '(' . $flag . $auditorCheck . ')',
                [$clientCompanyName, $clientCompanyName]
            ];
        }

        if ($clientType === 'listed_related') {
            if (!$this->hasColumn('companies', 'is_listed_related')) {
                return ['0 = 1', []];
            }
            return ["COALESCE(c.is_listed_related, 0) = 1", []];
        }

        return ['', []];
    }

    private function alertCondition($alert) {
        if ($alert === 'fye') {
            return "c.fye_date IS NOT NULL AND c.fye_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 3 MONTH) AND CURDATE()";
        }

        if ($alert === 'agm_due') {
            return "c.next_agm_due IS NOT NULL AND c.next_agm_due <= DATE_ADD(CURDATE(), INTERVAL 6 MONTH)";
        }

        if ($alert === 'ar_due') {
            return "(
                (c.date_of_ar IS NOT NULL AND c.date_of_ar <= DATE_ADD(CURDATE(), INTERVAL 6 MONTH))
                OR
                (c.last_ar_filing IS NOT NULL AND DATE_ADD(c.last_ar_filing, INTERVAL 12 MONTH) <= DATE_ADD(CURDATE(), INTERVAL 6 MONTH))
            )";
        }

        if ($alert === 'ep_due') {
            if (!$this->hasTable('due_dates')) {
                return '0 = 1';
            }
            return "EXISTS (
                SELECT 1 FROM due_dates d
                WHERE d.company_id = c.id
                  AND d.due_date IS NOT NULL
                  AND d.due_date <= DATE_ADD(CURDATE(), INTERVAL 3 MONTH)
                  AND (
                    UPPER(COALESCE(d.event_name, '')) LIKE '%EMPLOYMENT PASS%'
                    OR UPPER(COALESCE(d.event_name, '')) LIKE '%EP EXPIRY%'
                    OR UPPER(COALESCE(d.event_name, '')) LIKE 'EP%'
                  )
            )";
        }

        if ($alert === 'id_passport_due') {
            if (!$this->hasTable('member_identifications')) {
                return '0 = 1';
            }

            $entityChecks = [];
            if ($this->hasTable('directors')) $entityChecks[] = 'EXISTS (SELECT 1 FROM directors dr WHERE dr.company_id = c.id AND dr.member_id = mi.member_id)';
            if ($this->hasTable('shareholders')) $entityChecks[] = 'EXISTS (SELECT 1 FROM shareholders sh WHERE sh.company_id = c.id AND sh.member_id = mi.member_id)';
            if ($this->hasTable('secretaries')) $entityChecks[] = 'EXISTS (SELECT 1 FROM secretaries se WHERE se.company_id = c.id AND se.member_id = mi.member_id)';
            if ($this->hasTable('controllers')) $entityChecks[] = 'EXISTS (SELECT 1 FROM controllers co WHERE co.company_id = c.id AND co.member_id = mi.member_id)';
            if ($this->hasTable('company_officials')) $entityChecks[] = 'EXISTS (SELECT 1 FROM company_officials cf WHERE cf.company_id = c.id AND cf.member_id = mi.member_id)';

            if (empty($entityChecks)) {
                return '0 = 1';
            }

            return "EXISTS (
                SELECT 1
                FROM member_identifications mi
                WHERE mi.expired_date IS NOT NULL
                  AND mi.expired_date <= DATE_ADD(CURDATE(), INTERVAL 3 MONTH)
                  AND (" . implode(' OR ', $entityChecks) . ")
            )";
        }

        if ($alert === 'missing_info') {
            if (!$this->hasTable('directors')) {
                return "(
                    COALESCE(TRIM(c.registration_number), '') = ''
                    OR c.fye_date IS NULL
                    OR c.incorporation_date IS NULL
                )";
            }
            return "(
                COALESCE(TRIM(c.registration_number), '') = ''
                OR c.fye_date IS NULL
                OR c.incorporation_date IS NULL
                OR NOT EXISTS (SELECT 1 FROM directors dr WHERE dr.company_id = c.id)
            )";
        }

        return '';
    }

    private function buildFilterQueryParts($filters, $clientCompanyName) {
        $where = [];
        $params = [];

        $countryFilter = $this->countryCondition($filters['country']);
        if ($countryFilter[0] !== '') {
            $where[] = $countryFilter[0];
            $params = array_merge($params, $countryFilter[1]);
        }

        if (!empty($filters['company_ids'])) {
            $where[] = 'c.id IN (' . implode(',', array_fill(0, count($filters['company_ids']), '?')) . ')';
            $params = array_merge($params, $filters['company_ids']);
        }

        if ($filters['reg_no'] !== '') {
            $where[] = '(c.registration_number LIKE ? OR c.acra_registration_number LIKE ?)';
            $needle = '%' . $filters['reg_no'] . '%';
            $params[] = $needle;
            $params[] = $needle;
        }

        if ($filters['status'] !== '') {
            $where[] = 'c.internal_css_status = ?';
            $params[] = $filters['status'];
        }

        if ($filters['entity_status'] === 'prospect') {
            $where[] = 'c.is_prospect = 1';
        }
        if ($filters['entity_status'] === 'client') {
            $where[] = 'c.is_client = 1';
        }
        if ($filters['entity_status'] === 'non_client') {
            $where[] = 'c.is_non_client = 1';
        }

        $clientTypeFilter = $this->clientTypeCondition($filters['client_type'], $clientCompanyName);
        if ($clientTypeFilter[0] !== '') {
            $where[] = $clientTypeFilter[0];
            $params = array_merge($params, $clientTypeFilter[1]);
        }

        if (!empty($filters['alerts'])) {
            foreach ($filters['alerts'] as $alert) {
                $alertCondition = $this->alertCondition($alert);
                if ($alertCondition !== '') {
                    $where[] = '(' . $alertCondition . ')';
                }
            }
        }

        return [$where, $params];
    }

    public function index() {
        $this->requireAuth();
        $filters = $this->readFilters();
        
        $data = [
            'page_title' => 'List Of Companies',
            'companies' => [],
            'total' => 0,
            'filters' => $filters,
            'company_types' => [],
            'statuses' => [
                'Pre-Incorporation', 'Active', 'Terminated', 'Dormant',
                'Liquidation in Progress', 'Dissolved', 'Striking Off',
                'Struck-Off', 'De-Registered', 'Inactive', 'Liquidated',
                'Cancelled', 'Amalgamated'
            ],
        ];
        
        if ($this->db) {
            $client = $this->getClientRecord();
            if ($client) {
                $parts = $this->buildFilterQueryParts($filters, (string)($client->company_name ?? ''));
                $whereSql = '';
                if (!empty($parts[0])) {
                    $whereSql = ' AND ' . implode(' AND ', $parts[0]);
                }
                $params = array_merge([$client->id], $parts[1]);

                $data['companies'] = $this->db->fetchAll(
                    "SELECT c.*, ct.type_name as company_type_name 
                     FROM companies c 
                      LEFT JOIN company_types ct ON ct.id = c.company_type_id
                     WHERE c.client_id = ? {$whereSql}
                     ORDER BY c.company_name ASC",
                    $params
                );
                $data['total'] = count($data['companies']);
                $data['company_types'] = $this->db->fetchAll(
                    "SELECT * FROM company_types WHERE client_id = ? AND status = 1",
                    [$client->id]
                );
            }
        }
        
        $this->loadLayout('companies/list', $data);
    }

    public function filter_counts() {
        $this->requireAuth();

        $counts = [
            'country' => [
                'all' => 0,
                'sg' => 0,
                'my' => 0,
                'bvi_cayman' => 0,
            ],
            'client_type' => [
                'css_client' => 0,
                'accounting_only' => 0,
                'audit_client' => 0,
                'listed_related' => 0,
            ],
            'alerts' => [
                'fye' => 0,
                'agm_due' => 0,
                'ar_due' => 0,
                'ep_due' => 0,
                'id_passport_due' => 0,
                'missing_info' => 0,
            ],
        ];

        if (!$this->db) {
            $this->json(['ok' => true, 'counts' => $counts]);
            return;
        }

        $client = $this->getClientRecord();
        if (!$client) {
            $this->json(['ok' => true, 'counts' => $counts]);
            return;
        }

        $sql = "SELECT
                    COUNT(*) AS total_count,
                    SUM(CASE WHEN UPPER(COALESCE(c.country, '')) = 'SINGAPORE' THEN 1 ELSE 0 END) AS sg_count,
                    SUM(CASE WHEN UPPER(COALESCE(c.country, '')) = 'MALAYSIA' THEN 1 ELSE 0 END) AS my_count,
                    SUM(CASE WHEN UPPER(COALESCE(c.country, '')) IN ('BVI', 'CAYMAN ISLANDS', 'BRITISH VIRGIN ISLANDS') THEN 1 ELSE 0 END) AS bvi_cayman_count,

                    SUM(CASE WHEN ((" . ($this->hasColumn('companies', 'is_css_client') ? 'c.is_css_client = 1' : '0 = 1') . ") OR " . ($this->hasTable('secretaries') ? "EXISTS (
                        SELECT 1 FROM secretaries s
                        WHERE s.company_id = c.id
                          AND UPPER(TRIM(COALESCE(s.name, ''))) = UPPER(TRIM(?))
                    )" : '0 = 1') . ")) THEN 1 ELSE 0 END) AS css_client_count,
                    SUM(CASE WHEN " . ($this->hasColumn('companies', 'is_accounting_client') ? "c.is_accounting_client = 1 AND " . ($this->hasColumn('companies', 'is_audit_client') ? 'COALESCE(c.is_audit_client, 0)' : '0') . " = 0" : '0 = 1') . " THEN 1 ELSE 0 END) AS accounting_only_count,
                    SUM(CASE WHEN ((" . ($this->hasColumn('companies', 'is_audit_client') ? 'c.is_audit_client = 1' : '0 = 1') . ") OR " . ($this->hasTable('auditors') ? "EXISTS (
                        SELECT 1 FROM auditors a
                        WHERE a.company_id = c.id
                          AND (
                            UPPER(TRIM(COALESCE(a.name, ''))) = UPPER(TRIM(?))
                            OR UPPER(TRIM(COALESCE(a.firm_name, ''))) = UPPER(TRIM(?))
                          )
                    )" : '0 = 1') . ")) THEN 1 ELSE 0 END) AS audit_client_count,
                    SUM(CASE WHEN " . ($this->hasColumn('companies', 'is_listed_related') ? 'COALESCE(c.is_listed_related, 0) = 1' : '0 = 1') . " THEN 1 ELSE 0 END) AS listed_related_count,

                    SUM(CASE WHEN c.fye_date IS NOT NULL AND c.fye_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 3 MONTH) AND CURDATE() THEN 1 ELSE 0 END) AS fye_count,
                    SUM(CASE WHEN c.next_agm_due IS NOT NULL AND c.next_agm_due <= DATE_ADD(CURDATE(), INTERVAL 6 MONTH) THEN 1 ELSE 0 END) AS agm_due_count,
                    SUM(CASE WHEN (
                        (c.date_of_ar IS NOT NULL AND c.date_of_ar <= DATE_ADD(CURDATE(), INTERVAL 6 MONTH))
                        OR
                        (c.last_ar_filing IS NOT NULL AND DATE_ADD(c.last_ar_filing, INTERVAL 12 MONTH) <= DATE_ADD(CURDATE(), INTERVAL 6 MONTH))
                    ) THEN 1 ELSE 0 END) AS ar_due_count,
                    SUM(CASE WHEN " . ($this->hasTable('due_dates') ? "EXISTS (
                        SELECT 1 FROM due_dates d
                        WHERE d.company_id = c.id
                          AND d.due_date IS NOT NULL
                          AND d.due_date <= DATE_ADD(CURDATE(), INTERVAL 3 MONTH)
                          AND (
                            UPPER(COALESCE(d.event_name, '')) LIKE '%EMPLOYMENT PASS%'
                            OR UPPER(COALESCE(d.event_name, '')) LIKE '%EP EXPIRY%'
                            OR UPPER(COALESCE(d.event_name, '')) LIKE 'EP%'
                          )
                    )" : '0 = 1') . " THEN 1 ELSE 0 END) AS ep_due_count,
                    SUM(CASE WHEN " . $this->alertCondition('id_passport_due') . " THEN 1 ELSE 0 END) AS id_passport_due_count,
                    SUM(CASE WHEN (
                        COALESCE(TRIM(c.registration_number), '') = ''
                        OR c.fye_date IS NULL
                        OR c.incorporation_date IS NULL" . ($this->hasTable('directors') ? "
                        OR NOT EXISTS (SELECT 1 FROM directors dr WHERE dr.company_id = c.id)" : '') . "
                    ) THEN 1 ELSE 0 END) AS missing_info_count
                FROM companies c
                WHERE c.client_id = ?";

        $params = [
            (string)($client->company_name ?? ''),
            (string)($client->company_name ?? ''),
            (string)($client->company_name ?? ''),
            $client->id,
        ];

        if (!$this->hasTable('secretaries')) {
            array_shift($params);
        }
        if (!$this->hasTable('auditors')) {
            array_splice($params, $this->hasTable('secretaries') ? 1 : 0, 2);
        }

        $row = $this->db->fetchOne($sql, $params);

        if ($row) {
            $counts['country']['all'] = (int)$row->total_count;
            $counts['country']['sg'] = (int)$row->sg_count;
            $counts['country']['my'] = (int)$row->my_count;
            $counts['country']['bvi_cayman'] = (int)$row->bvi_cayman_count;

            $counts['client_type']['css_client'] = (int)$row->css_client_count;
            $counts['client_type']['accounting_only'] = (int)$row->accounting_only_count;
            $counts['client_type']['audit_client'] = (int)$row->audit_client_count;
            $counts['client_type']['listed_related'] = (int)$row->listed_related_count;

            $counts['alerts']['fye'] = (int)$row->fye_count;
            $counts['alerts']['agm_due'] = (int)$row->agm_due_count;
            $counts['alerts']['ar_due'] = (int)$row->ar_due_count;
            $counts['alerts']['ep_due'] = (int)$row->ep_due_count;
            $counts['alerts']['id_passport_due'] = (int)$row->id_passport_due_count;
            $counts['alerts']['missing_info'] = (int)$row->missing_info_count;
        }

        $this->json(['ok' => true, 'counts' => $counts]);
    }
}

// Add Company controller (maps to /add_company)
class Add_company extends BaseController {
    public function index() {
        $this->requireAuth();
        
        $data = [
            'page_title' => 'Add Company',
            'company_types' => [],
            'countries' => $this->getCountries(),
        ];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->store();
            return;
        }
        
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['company_types'] = $this->db->fetchAll(
                    "SELECT * FROM company_types WHERE client_id = ? AND status = 1",
                    [$client->id]
                );
            }
        }
        
        $this->loadLayout('companies/add', $data);
    }
    
    private function store() {
        if (!$this->validateCsrf()) {
            $this->setFlash('error', 'Invalid security token. Please try again.');
            $this->redirect('add_company');
            return;
        }

        if (!$this->db) {
            $this->setFlash('error', 'Database not connected');
            $this->redirect('add_company');
            return;
        }
        
        $clientId = $_SESSION['client_id'] ?? '';
        $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
        if (!$client) {
            $this->setFlash('error', 'Invalid client');
            $this->redirect('add_company');
            return;
        }
        
        $companyData = [
            'client_id' => $client->id,
            'company_name' => $this->input('company-name', ''),
            'former_name' => $this->input('former-name', ''),
            'company_id_code' => $this->input('clientid', ''),
            'company_type_id' => $this->input('company-type') ?: null,
            'registration_number' => $this->input('reg-num', ''),
            'acra_registration_number' => $this->input('acra_reg_id', ''),
            'country' => $this->input('country', 'SINGAPORE'),
            'incorporation_date' => $this->input('incorp-date') ?: null,
            'entity_status' => $this->input('company-status', 'Active'),
            'internal_css_status' => $this->input('company_status', ''),
            'risk_assessment_rating' => $this->input('risk_assessment_rating', ''),
            'common_seal' => $this->input('common_seal', ''),
            'company_stamp' => $this->input('company_stamp', ''),
            'ord_issued_share_capital' => $this->input('ord_issued_share_capital', 0),
            'ord_currency' => $this->input('ord_currency', 'SGD'),
            'no_ord_shares' => $this->input('no_ord_shares', 0),
            'paid_up_capital' => $this->input('paid_up_capital', 0),
            'spec_issued_share_capital' => $this->input('spec_issued_share_capital', 0),
            'spec_currency' => $this->input('spec_currency', 'SGD'),
            'no_spec_shares' => $this->input('no_spec_shares', 0),
            'fye_date' => $this->input('date-fye') ?: null,
            'next_agm_due' => $this->input('next-agm-due') ?: null,
            'contact_person' => $this->input('contact_person', ''),
            'email' => $this->input('company_email', ''),
            'website' => $this->input('company_website', ''),
            'phone1_code' => $this->input('company_contact_code', '65'),
            'phone1_number' => $this->input('company-contact-number', ''),
            'remarks' => $this->input('remarks', ''),
            'additional_remarks' => $this->input('additional_remarks', ''),
            'is_css_client' => $this->input('corporate_shareholder_client') ? 1 : 0,
            'is_taxation_client' => $this->input('taxation_client') ? 1 : 0,
            'is_prospect' => $this->input('prospect') ? 1 : 0,
            'is_client' => $this->input('client') ? 1 : 0,
            'is_non_client' => $this->input('non_client') ? 1 : 0,
            'created_by' => $_SESSION['user_id'] ?? null,
        ];
        
        $companyId = $this->db->insert('companies', $companyData);
        
        // Save registered address
        $addressData = [
            'entity_type' => 'company',
            'entity_id' => $companyId,
            'address_type' => 'Registered Office',
            'is_default' => 1,
            'block' => $this->input('reg_add_block', ''),
            'address_text' => $this->input('reg-address', ''),
            'building' => $this->input('reg_add_building', ''),
            'level' => $this->input('reg_add_level', ''),
            'unit' => $this->input('reg_add_unit', ''),
            'country' => $this->input('reg_country', ''),
            'state' => $this->input('reg_add_state', ''),
            'city' => $this->input('reg_add_city', ''),
            'postal_code' => $this->input('reg_add_pcode', ''),
        ];
        $this->db->insert('addresses', $addressData);
        
        // Save contact persons (Step 2)
        $cpNames = $_POST['contactp-name'] ?? [];
        foreach ($cpNames as $i => $name) {
            if (empty($name)) continue;
            $this->db->insert('contact_persons', [
                'company_id' => $companyId,
                'name' => $name,
                'id_type' => $_POST['contactp_id_type'][$i] ?? '',
                'id_number' => $_POST['contactp-passport'][$i] ?? '',
                'nationality' => $_POST['contactp-nationality'][$i] ?? '',
                'email' => $_POST['contactp-email-address'][$i] ?? '',
                'contact_number' => $_POST['contactp-contact-number'][$i] ?? '',
                'date_of_birth' => $_POST['contactp-dob'][$i] ?? null,
                'local_address' => $_POST['contactp-local-address'][$i] ?? '',
                'foreign_address' => $_POST['contactp-foreign-address'][$i] ?? '',
                'date_of_appointment' => $_POST['contactp-doapp'][$i] ?? null,
                'date_of_cessation' => $_POST['cp-doc'][$i] ?? null,
            ]);
        }

        // Save directors (Step 3)
        $dirNames = $_POST['director-name'] ?? [];
        foreach ($dirNames as $i => $name) {
            if (empty($name)) continue;
            $this->db->insert('directors', [
                'company_id' => $companyId,
                'role' => 'director',
                'name' => $name,
                'id_type' => $_POST['director_id_type'][$i] ?? '',
                'id_number' => $_POST['director-passport'][$i] ?? '',
                'nationality' => $_POST['director-nationality'][$i] ?? '',
                'local_address' => $_POST['direcetor-local-address'][$i] ?? '',
                'foreign_address' => $_POST['direcetor-foreign-address'][$i] ?? '',
                'email' => $_POST['director-email-address'][$i] ?? '',
                'contact_number' => $_POST['director-contact-number'][$i] ?? '',
                'date_of_birth' => $_POST['director-dob'][$i] ?? null,
                'date_of_appointment' => $_POST['director-doapp'][$i] ?? null,
            ]);
        }
        
        // Save shareholders (Step 4)
        $shNames = $_POST['shareh-name'] ?? [];
        foreach ($shNames as $i => $name) {
            if (empty($name)) continue;
            $this->db->insert('shareholders', [
                'company_id' => $companyId,
                'shareholder_type' => $_POST['shareholder_type'][$i] ?? 'Individual',
                'name' => $name,
                'id_type' => $_POST['shareh_id_type'][$i] ?? '',
                'id_number' => $_POST['shareh-passport'][$i] ?? '',
                'nationality' => $_POST['shareh-nationality'][$i] ?? '',
                'date_of_appointment' => $_POST['shareh-doapp'][$i] ?? null,
            ]);
        }
        
        // Save secretary (Step 5)
        $secNames = $_POST['secreatary-name'] ?? [];
        foreach ($secNames as $i => $name) {
            if (empty($name)) continue;
            $this->db->insert('secretaries', [
                'company_id' => $companyId,
                'name' => $name,
                'id_type' => $_POST['secretary_id_type'][$i] ?? '',
                'id_number' => $_POST['secreatary-passport'][$i] ?? '',
                'nationality' => $_POST['secreatary-nationality'][$i] ?? '',
                'date_of_appointment' => $_POST['secreatary-doapp'][$i] ?? null,
            ]);
        }
        
        $this->setFlash('success', 'Company created successfully.');
        $this->redirect('company_list');
    }
    
    private function getCountries() {
        return ['AFGHANISTAN','ALBANIA','ALGERIA','ANDORRA','ANGOLA','ARGENTINA','ARMENIA','AUSTRALIA','AUSTRIA','AZERBAIJAN','BAHAMAS','BAHRAIN','BANGLADESH','BARBADOS','BELARUS','BELGIUM','BELIZE','BERMUDA','BHUTAN','BOLIVIA','BOSNIA AND HERZEGOVINA','BOTSWANA','BRAZIL','BRUNEI','BULGARIA','CAMBODIA','CAMEROON','CANADA','CAYMAN ISLANDS','CHILE','CHINA','COLOMBIA','COSTA RICA','CROATIA','CUBA','CYPRUS','CZECH REPUBLIC','DENMARK','ECUADOR','EGYPT','EL SALVADOR','ESTONIA','ETHIOPIA','FIJI','FINLAND','FRANCE','GEORGIA','GERMANY','GHANA','GREECE','GUAM','GUATEMALA','HONG KONG','HUNGARY','ICELAND','INDIA','INDONESIA','IRAN','IRAQ','IRELAND','ISRAEL','ITALY','JAMAICA','JAPAN','JORDAN','KAZAKHSTAN','KENYA','KUWAIT','LAOS','LATVIA','LEBANON','LIBYA','LIECHTENSTEIN','LITHUANIA','LUXEMBOURG','MACAU','MADAGASCAR','MALAYSIA','MALDIVES','MALTA','MAURITIUS','MEXICO','MONACO','MONGOLIA','MOROCCO','MOZAMBIQUE','MYANMAR','NEPAL','NETHERLANDS','NEW ZEALAND','NIGERIA','NORTH KOREA','NORWAY','OMAN','PAKISTAN','PANAMA','PAPUA NEW GUINEA','PARAGUAY','PERU','PHILIPPINES','POLAND','PORTUGAL','QATAR','ROMANIA','RUSSIA','SAUDI ARABIA','SERBIA','SINGAPORE','SLOVAKIA','SLOVENIA','SOUTH AFRICA','SOUTH KOREA','SPAIN','SRI LANKA','SWEDEN','SWITZERLAND','SYRIA','TAIWAN','TAJIKISTAN','TANZANIA','THAILAND','TUNISIA','TURKEY','TURKMENISTAN','UAE','UGANDA','UKRAINE','UNITED KINGDOM','UNITED STATES','URUGUAY','UZBEKISTAN','VENEZUELA','VIETNAM','YEMEN','ZAMBIA','ZIMBABWE'];
    }
}

// View Company controller (maps to /view_company/{id})
class View_company extends BaseController {
    public function index($id = null) {
        $this->requireAuth();
        
        if (!$id) {
            $this->redirect('company_list');
            return;
        }
        
        $data = [
            'page_title' => 'View Company',
            'company' => null,
            'directors' => [],
            'shareholders' => [],
            'secretaries' => [],
            'auditors' => [],
            'addresses' => [],
            'events' => [],
        ];
        
        if ($this->db) {
            $data['company'] = $this->db->fetchOne(
                "SELECT c.*, ct.type_name as company_type_name FROM companies c LEFT JOIN company_types ct ON ct.id = c.company_type_id WHERE c.id = ?",
                [$id]
            );
            if ($data['company']) {
                $data['directors'] = $this->db->fetchAll("SELECT * FROM directors WHERE company_id = ? ORDER BY status DESC, date_of_appointment DESC", [$id]);
                $data['shareholders'] = $this->db->fetchAll("SELECT * FROM shareholders WHERE company_id = ? ORDER BY status DESC", [$id]);
                $data['secretaries'] = $this->db->fetchAll("SELECT * FROM secretaries WHERE company_id = ? ORDER BY status DESC", [$id]);
                $data['auditors'] = $this->db->fetchAll("SELECT * FROM auditors WHERE company_id = ? ORDER BY status DESC", [$id]);
                $data['addresses'] = $this->db->fetchAll("SELECT * FROM addresses WHERE entity_type = 'company' AND entity_id = ?", [$id]);
                $data['events'] = $this->db->fetchAll("SELECT * FROM company_events WHERE company_id = ? ORDER BY fye_date DESC", [$id]);
            }
        }
        
        $this->loadLayout('companies/view', $data);
    }
}

// Pre-Incorporation Company listing (maps to /pre_company)
class Pre_company extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title'  => 'Pre-Incorporation Companies',
            'companies'   => [],
            'total'       => 0,
            'filter_status'=> 'Pre-Incorporation',
            'statuses' => [
                'Pre-Incorporation', 'Active', 'Terminated', 'Dormant',
                'Liquidation in Progress', 'Dissolved', 'Striking Off',
                'Struck-Off', 'De-Registered', 'Inactive', 'Liquidated',
                'Cancelled', 'Amalgamated'
            ],
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['companies'] = $this->db->fetchAll(
                    "SELECT c.*, ct.type_name as company_type_name 
                     FROM companies c 
                     LEFT JOIN company_types ct ON ct.id = c.company_type_id
                     WHERE c.client_id = ? AND c.entity_status = 'Pre-Incorporation'
                     ORDER BY c.company_name ASC",
                    [$client->id]
                );
                $data['total'] = count($data['companies']);
            }
        }

        $this->loadLayout('companies/pre_company', $data);
    }
}

// Post-Incorporation Company listing (maps to /post_company)
class Post_company extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title'  => 'Post-Incorporation Companies',
            'companies'   => [],
            'total'       => 0,
            'filter_status'=> 'Active',
            'statuses' => [
                'Pre-Incorporation', 'Active', 'Terminated', 'Dormant',
                'Liquidation in Progress', 'Dissolved', 'Striking Off',
                'Struck-Off', 'De-Registered', 'Inactive', 'Liquidated',
                'Cancelled', 'Amalgamated'
            ],
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['companies'] = $this->db->fetchAll(
                    "SELECT c.*, ct.type_name as company_type_name 
                     FROM companies c 
                     LEFT JOIN company_types ct ON ct.id = c.company_type_id
                     WHERE c.client_id = ? AND c.entity_status = 'Active'
                     ORDER BY c.company_name ASC",
                    [$client->id]
                );
                $data['total'] = count($data['companies']);
            }
        }

        $this->loadLayout('companies/post_company', $data);
    }
}

// Non-Client Companies (maps to /company_non_client)
class Company_non_client extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title'  => 'Non-Client Companies',
            'companies'   => [],
            'total'       => 0,
            'statuses' => [
                'Pre-Incorporation', 'Active', 'Terminated', 'Dormant',
                'Liquidation in Progress', 'Dissolved', 'Striking Off',
                'Struck-Off', 'De-Registered', 'Inactive', 'Liquidated',
                'Cancelled', 'Amalgamated'
            ],
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['companies'] = $this->db->fetchAll(
                    "SELECT c.*, ct.type_name as company_type_name 
                     FROM companies c 
                     LEFT JOIN company_types ct ON ct.id = c.company_type_id
                     WHERE c.client_id = ? AND c.is_non_client = 1
                     ORDER BY c.company_name ASC",
                    [$client->id]
                );
                $data['total'] = count($data['companies']);
            }
        }

        $this->loadLayout('companies/non_client', $data);
    }
}

// Company Fee List (maps to /company_fee_list/{id})
class Company_fee_list extends BaseController {
    public function index($id = null) {
        $this->requireAuth();
        if (!$id) { $this->redirect('company_list'); return; }

        $data = [
            'page_title' => 'Company Fee List',
            'company'    => null,
            'fees'       => [],
            'company_id' => $id,
        ];

        if ($this->db) {
            $data['company'] = $this->db->fetchOne("SELECT * FROM companies WHERE id = ?", [$id]);
            $data['fees'] = $this->db->fetchAll(
                "SELECT * FROM company_fees WHERE company_id = ? ORDER BY created_at DESC",
                [$id]
            );
        }

        $this->loadLayout('companies/fee_list', $data);
    }
}

// Company PDF Preview (maps to /company_pdf/{id})
class Company_pdf extends BaseController {
    public function index($id = null) {
        $this->requireAuth();
        if (!$id) { $this->redirect('company_list'); return; }

        $data = [
            'page_title' => 'Company PDF Preview',
            'company'    => null,
            'company_id' => $id,
        ];

        if ($this->db) {
            $data['company'] = $this->db->fetchOne("SELECT * FROM companies WHERE id = ?", [$id]);
        }

        $this->loadLayout('companies/pdf_view', $data);
    }
}

// Edit Company controller
class Edit_company extends BaseController {
    private function getCountries() {
        return ['AFGHANISTAN','ALBANIA','ALGERIA','ANDORRA','ANGOLA','ARGENTINA','ARMENIA','AUSTRALIA','AUSTRIA','AZERBAIJAN','BAHAMAS','BAHRAIN','BANGLADESH','BARBADOS','BELARUS','BELGIUM','BELIZE','BERMUDA','BHUTAN','BOLIVIA','BOSNIA AND HERZEGOVINA','BOTSWANA','BRAZIL','BRUNEI','BULGARIA','CAMBODIA','CAMEROON','CANADA','CAYMAN ISLANDS','CHILE','CHINA','COLOMBIA','COSTA RICA','CROATIA','CUBA','CYPRUS','CZECH REPUBLIC','DENMARK','ECUADOR','EGYPT','EL SALVADOR','ESTONIA','ETHIOPIA','FIJI','FINLAND','FRANCE','GEORGIA','GERMANY','GHANA','GREECE','GUAM','GUATEMALA','HONG KONG','HUNGARY','ICELAND','INDIA','INDONESIA','IRAN','IRAQ','IRELAND','ISRAEL','ITALY','JAMAICA','JAPAN','JORDAN','KAZAKHSTAN','KENYA','KUWAIT','LAOS','LATVIA','LEBANON','LIBYA','LIECHTENSTEIN','LITHUANIA','LUXEMBOURG','MACAU','MADAGASCAR','MALAYSIA','MALDIVES','MALTA','MAURITIUS','MEXICO','MONACO','MONGOLIA','MOROCCO','MOZAMBIQUE','MYANMAR','NEPAL','NETHERLANDS','NEW ZEALAND','NIGERIA','NORTH KOREA','NORWAY','OMAN','PAKISTAN','PANAMA','PAPUA NEW GUINEA','PARAGUAY','PERU','PHILIPPINES','POLAND','PORTUGAL','QATAR','ROMANIA','RUSSIA','SAUDI ARABIA','SERBIA','SINGAPORE','SLOVAKIA','SLOVENIA','SOUTH AFRICA','SOUTH KOREA','SPAIN','SRI LANKA','SWEDEN','SWITZERLAND','SYRIA','TAIWAN','TAJIKISTAN','TANZANIA','THAILAND','TUNISIA','TURKEY','TURKMENISTAN','UAE','UGANDA','UKRAINE','UNITED KINGDOM','UNITED STATES','URUGUAY','UZBEKISTAN','VENEZUELA','VIETNAM','YEMEN','ZAMBIA','ZIMBABWE'];
    }

    public function index($id = null) {
        $this->requireAuth();
        if (!$id) { $this->redirect('company_list'); return; }
        
        $data = [
            'page_title' => 'Edit Company',
            'company' => null,
            'company_types' => [],
            'addresses' => [],
            'countries' => $this->getCountries(),
        ];
        
        if ($this->db) {
            $data['company'] = $this->db->fetchOne("SELECT * FROM companies WHERE id = ?", [$id]);
            $data['addresses'] = $this->db->fetchAll("SELECT * FROM addresses WHERE entity_type = 'company' AND entity_id = ?", [$id]);
            
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['company_types'] = $this->db->fetchAll("SELECT * FROM company_types WHERE client_id = ? AND status = 1", [$client->id]);
            }
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->update($id);
            return;
        }
        
        $this->loadLayout('companies/edit', $data);
    }
    
    private function update($id) {
        if (!$this->validateCsrf()) {
            $this->setFlash('error', 'Invalid security token. Please try again.');
            $this->redirect("edit_company/{$id}");
            return;
        }

        if (!$this->db) {
            $this->setFlash('error', 'Database not connected');
            $this->redirect("edit_company/{$id}");
            return;
        }
        
        $updateData = [
            'company_name' => $this->input('company-name', ''),
            'former_name' => $this->input('former-name', ''),
            'company_id_code' => $this->input('clientid', ''),
            'company_type_id' => $this->input('company-type') ?: null,
            'registration_number' => $this->input('reg-num', ''),
            'acra_registration_number' => $this->input('acra_reg_id', ''),
            'country' => $this->input('country', 'SINGAPORE'),
            'incorporation_date' => $this->input('incorp-date') ?: null,
            'entity_status' => $this->input('company-status', 'Active'),
            'internal_css_status' => $this->input('company_status', ''),
            'email' => $this->input('company_email', ''),
            'website' => $this->input('company_website', ''),
            'remarks' => $this->input('remarks', ''),
        ];
        
        $this->db->update('companies', $updateData, 'id = ?', [$id]);
        $this->setFlash('success', 'Company updated successfully.');
        $this->redirect("view_company/{$id}");
    }
}

// New Registration SOP wizard (maps to /new_registration)
class New_registration extends BaseController {
    public function index() {
        $this->requireAuth();

        $data = [
            'page_title' => 'New Company Registration',
            'company_types' => [],
            'countries' => $this->getCountries(),
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['company_types'] = $this->db->fetchAll(
                    "SELECT * FROM company_types WHERE client_id = ? AND status = 1",
                    [$client->id]
                );
            }
        }

        $this->loadLayout('companies/new_registration', $data);
    }

    private function getCountries() {
        return ['AFGHANISTAN','ALBANIA','ALGERIA','ANDORRA','ANGOLA','ARGENTINA','ARMENIA','AUSTRALIA','AUSTRIA','AZERBAIJAN','BAHAMAS','BAHRAIN','BANGLADESH','BARBADOS','BELARUS','BELGIUM','BELIZE','BERMUDA','BHUTAN','BOLIVIA','BOSNIA AND HERZEGOVINA','BOTSWANA','BRAZIL','BRUNEI','BULGARIA','CAMBODIA','CAMEROON','CANADA','CAYMAN ISLANDS','CHILE','CHINA','COLOMBIA','COSTA RICA','CROATIA','CUBA','CYPRUS','CZECH REPUBLIC','DENMARK','ECUADOR','EGYPT','EL SALVADOR','ESTONIA','ETHIOPIA','FIJI','FINLAND','FRANCE','GEORGIA','GERMANY','GHANA','GREECE','GUAM','GUATEMALA','HONG KONG','HUNGARY','ICELAND','INDIA','INDONESIA','IRAN','IRAQ','IRELAND','ISRAEL','ITALY','JAMAICA','JAPAN','JORDAN','KAZAKHSTAN','KENYA','KUWAIT','LAOS','LATVIA','LEBANON','LIBYA','LIECHTENSTEIN','LITHUANIA','LUXEMBOURG','MACAU','MADAGASCAR','MALAYSIA','MALDIVES','MALTA','MAURITIUS','MEXICO','MONACO','MONGOLIA','MOROCCO','MOZAMBIQUE','MYANMAR','NEPAL','NETHERLANDS','NEW ZEALAND','NIGERIA','NORTH KOREA','NORWAY','OMAN','PAKISTAN','PANAMA','PAPUA NEW GUINEA','PARAGUAY','PERU','PHILIPPINES','POLAND','PORTUGAL','QATAR','ROMANIA','RUSSIA','SAUDI ARABIA','SERBIA','SINGAPORE','SLOVAKIA','SLOVENIA','SOUTH AFRICA','SOUTH KOREA','SPAIN','SRI LANKA','SWEDEN','SWITZERLAND','SYRIA','TAIWAN','TAJIKISTAN','TANZANIA','THAILAND','TUNISIA','TURKEY','TURKMENISTAN','UAE','UGANDA','UKRAINE','UNITED KINGDOM','UNITED STATES','URUGUAY','UZBEKISTAN','VENEZUELA','VIETNAM','YEMEN','ZAMBIA','ZIMBABWE'];
    }
}

// Transfer-in SOP wizard (maps to /transfer_in)
class Transfer_in extends BaseController {
    public function index() {
        $this->requireAuth();

        $data = [
            'page_title' => 'Transfer In Company',
            'company_types' => [],
            'countries' => $this->getCountries(),
            'is_transfer' => true,
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['company_types'] = $this->db->fetchAll(
                    "SELECT * FROM company_types WHERE client_id = ? AND status = 1",
                    [$client->id]
                );
            }
        }

        $this->loadLayout('companies/transfer_in', $data);
    }

    private function getCountries() {
        return ['AFGHANISTAN','ALBANIA','ALGERIA','ANDORRA','ANGOLA','ARGENTINA','ARMENIA','AUSTRALIA','AUSTRIA','AZERBAIJAN','BAHAMAS','BAHRAIN','BANGLADESH','BARBADOS','BELARUS','BELGIUM','BELIZE','BERMUDA','BHUTAN','BOLIVIA','BOSNIA AND HERZEGOVINA','BOTSWANA','BRAZIL','BRUNEI','BULGARIA','CAMBODIA','CAMEROON','CANADA','CAYMAN ISLANDS','CHILE','CHINA','COLOMBIA','COSTA RICA','CROATIA','CUBA','CYPRUS','CZECH REPUBLIC','DENMARK','ECUADOR','EGYPT','EL SALVADOR','ESTONIA','ETHIOPIA','FIJI','FINLAND','FRANCE','GEORGIA','GERMANY','GHANA','GREECE','GUAM','GUATEMALA','HONG KONG','HUNGARY','ICELAND','INDIA','INDONESIA','IRAN','IRAQ','IRELAND','ISRAEL','ITALY','JAMAICA','JAPAN','JORDAN','KAZAKHSTAN','KENYA','KUWAIT','LAOS','LATVIA','LEBANON','LIBYA','LIECHTENSTEIN','LITHUANIA','LUXEMBOURG','MACAU','MADAGASCAR','MALAYSIA','MALDIVES','MALTA','MAURITIUS','MEXICO','MONACO','MONGOLIA','MOROCCO','MOZAMBIQUE','MYANMAR','NEPAL','NETHERLANDS','NEW ZEALAND','NIGERIA','NORTH KOREA','NORWAY','OMAN','PAKISTAN','PANAMA','PAPUA NEW GUINEA','PARAGUAY','PERU','PHILIPPINES','POLAND','PORTUGAL','QATAR','ROMANIA','RUSSIA','SAUDI ARABIA','SERBIA','SINGAPORE','SLOVAKIA','SLOVENIA','SOUTH AFRICA','SOUTH KOREA','SPAIN','SRI LANKA','SWEDEN','SWITZERLAND','SYRIA','TAIWAN','TAJIKISTAN','TANZANIA','THAILAND','TUNISIA','TURKEY','TURKMENISTAN','UAE','UGANDA','UKRAINE','UNITED KINGDOM','UNITED STATES','URUGUAY','UZBEKISTAN','VENEZUELA','VIETNAM','YEMEN','ZAMBIA','ZIMBABWE'];
    }
}
