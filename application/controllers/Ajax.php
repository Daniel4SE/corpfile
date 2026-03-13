<?php
/**
 * Ajax Controller - Handles all AJAX API endpoints
 * 
 * Routes (via fallback router):
 *   POST /Ajax/mark_all_notifications_read
 *   POST /Ajax/delete_member
 *   POST /Ajax/upload_member_file/{member_id}
 *   POST /Ajax/delete_member_file
 *   POST /Ajax/kyc_search
 *   GET  /Ajax/get_company_files/{company_id}
 *   GET  /Ajax/get_company_activity_log/{company_id}
 *   POST /Ajax/upload_company_file/{company_id}
 *   POST /Ajax/delete_company_file/{file_id}
 *   POST /Ajax/delete_company_record/{type}/{id}
 *   GET  /Ajax/officer_form/{type}/{company_id}[/{id}]
 *   POST /Ajax/save_officer/{type}/{company_id}
 *   POST /Ajax/save_company
 *   POST /Ajax/save_member
 *   GET  /Ajax/global_search?q={keyword}
 */
class Ajax extends BaseController {

    public function index() {
        $this->json(['error' => 'Method required'], 400);
    }

    // ─── Notifications ───────────────────────────────────────────────

    /**
     * Mark all notifications as read for current user
     * POST /Ajax/mark_all_notifications_read
     */
    public function mark_all_notifications_read() {
        $this->requireAuth();
        
        if ($this->db) {
            $userId = $_SESSION['user_id'] ?? 0;
            $this->db->update('notifications', ['is_read' => 1], 'user_id = ?', [$userId]);
        }
        
        $this->json(['success' => true, 'message' => 'All notifications marked as read']);
    }

    // ─── Members ─────────────────────────────────────────────────────

    /**
     * Delete a member
     * POST /Ajax/delete_member
     */
    public function delete_member() {
        $this->requireAuth();
        
        $memberId = $this->input('member_id');
        if (!$memberId) {
            $this->json(['success' => false, 'message' => 'Member ID required'], 400);
        }
        
        if ($this->db) {
            // Check for dependencies
            $directorCount = $this->db->count('directors', 'member_id = ?', [$memberId]);
            $shareholderCount = $this->db->count('shareholders', 'member_id = ?', [$memberId]);
            
            if ($directorCount > 0 || $shareholderCount > 0) {
                $this->json([
                    'success' => false,
                    'message' => 'Cannot delete member. They are currently appointed as director or shareholder in one or more companies.'
                ], 400);
            }
            
            $this->db->delete('member_identifications', 'member_id = ?', [$memberId]);
            $this->db->delete('addresses', "entity_type = 'member' AND entity_id = ?", [$memberId]);
            $this->db->delete('members', 'id = ?', [$memberId]);
        }
        
        $this->json(['success' => true, 'message' => 'Member deleted successfully']);
    }

    /**
     * Upload file for a member
     * POST /Ajax/upload_member_file/{member_id}
     */
    public function upload_member_file($memberId = null) {
        $this->requireAuth();
        
        if (!$memberId) {
            $this->json(['success' => false, 'message' => 'Member ID required'], 400);
        }
        
        if (empty($_FILES['file'])) {
            $this->json(['success' => false, 'message' => 'No file uploaded'], 400);
        }
        
        $file = $_FILES['file'];
        $uploadDir = BASEPATH . 'uploads/members/' . $memberId . '/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file['name']);
        $filepath = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            if ($this->db) {
                $clientId = $this->getClientDbId();
                $this->db->insert('documents', [
                    'client_id' => $clientId,
                    'entity_type' => 'member',
                    'entity_id' => $memberId,
                    'document_name' => $file['name'],
                    'file_path' => 'uploads/members/' . $memberId . '/' . $filename,
                    'file_type' => $file['type'],
                    'file_size' => $file['size'],
                    'uploaded_by' => $_SESSION['user_id'] ?? 1,
                ]);
            }
            $this->json(['success' => true, 'message' => 'File uploaded successfully']);
        } else {
            $this->json(['success' => false, 'message' => 'Upload failed'], 500);
        }
    }

    /**
     * Delete a member file
     * POST /Ajax/delete_member_file
     */
    public function delete_member_file() {
        $this->requireAuth();
        
        $fileId = $this->input('file_id');
        if (!$fileId) {
            $this->json(['success' => false, 'message' => 'File ID required'], 400);
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
        
        $this->json(['success' => true, 'message' => 'File deleted successfully']);
    }

    /**
     * KYC screening search
     * POST /Ajax/kyc_search
     */
    public function kyc_search() {
        $this->requireAuth();
        
        $name = $this->input('name', '');
        
        // In a real implementation this would call external KYC APIs
        // For demo purposes, return sample results
        $results = [
            'status' => 'completed',
            'name_searched' => $name,
            'screening_date' => date('Y-m-d H:i:s'),
            'matches_found' => 0,
            'results' => [],
            'message' => 'No adverse records found for "' . htmlspecialchars($name) . '".'
        ];
        
        $this->json(['success' => true, 'data' => $results]);
    }

    // ─── Companies ───────────────────────────────────────────────────

    /**
     * Get company files list
     * GET /Ajax/get_company_files/{company_id}
     */
    public function get_company_files($companyId = null) {
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
        
        $this->json(['success' => true, 'data' => $files]);
    }

    /**
     * Get company activity log
     * GET /Ajax/get_company_activity_log/{company_id}
     */
    public function get_company_activity_log($companyId = null) {
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
        
        $this->json(['success' => true, 'data' => $logs]);
    }

    /**
     * Upload file for a company
     * POST /Ajax/upload_company_file/{company_id}
     */
    public function upload_company_file($companyId = null) {
        $this->requireAuth();
        
        if (!$companyId) {
            $this->json(['success' => false, 'message' => 'Company ID required'], 400);
        }
        
        if (empty($_FILES['file'])) {
            $this->json(['success' => false, 'message' => 'No file uploaded'], 400);
        }
        
        $file = $_FILES['file'];
        $categoryId = $this->input('category_id');
        $uploadDir = BASEPATH . 'uploads/companies/' . $companyId . '/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file['name']);
        $filepath = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            if ($this->db) {
                $clientId = $this->getClientDbId();
                $docId = $this->db->insert('documents', [
                    'client_id' => $clientId,
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
            $this->json(['success' => true, 'message' => 'File uploaded successfully', 'id' => $docId ?? 0]);
        } else {
            $this->json(['success' => false, 'message' => 'Upload failed'], 500);
        }
    }

    /**
     * Delete a company file
     * POST /Ajax/delete_company_file/{file_id}
     */
    public function delete_company_file($fileId = null) {
        $this->requireAuth();
        
        if (!$fileId) {
            $fileId = $this->input('file_id');
        }
        
        if (!$fileId) {
            $this->json(['success' => false, 'message' => 'File ID required'], 400);
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
        
        $this->json(['success' => true, 'message' => 'File deleted successfully']);
    }

    /**
     * Delete a company record (director, shareholder, secretary, auditor, etc.)
     * POST /Ajax/delete_company_record/{type}/{id}
     */
    public function delete_company_record($type = null, $id = null) {
        $this->requireAuth();
        
        if (!$type || !$id) {
            $this->json(['success' => false, 'message' => 'Type and ID required'], 400);
        }
        
        $tableMap = [
            'director'    => 'directors',
            'shareholder' => 'shareholders',
            'secretary'   => 'secretaries',
            'auditor'     => 'auditors',
            'controller'  => 'controllers',
            'official'    => 'company_officials',
        ];
        
        $table = $tableMap[$type] ?? null;
        if (!$table) {
            $this->json(['success' => false, 'message' => 'Invalid record type'], 400);
        }
        
        if ($this->db) {
            $this->db->delete($table, 'id = ?', [$id]);
        }
        
        $this->json(['success' => true, 'message' => ucfirst($type) . ' deleted successfully']);
    }

    /**
     * Get officer form HTML for modal (add/edit)
     * GET /Ajax/officer_form/{type}/{company_id}[/{id}]
     */
    public function officer_form($type = null, $companyId = null, $id = null) {
        $this->requireAuth();
        
        $typeLabels = [
            'director'       => 'Director',
            'shareholder'    => 'Shareholder',
            'secretary'      => 'Secretary',
            'auditor'        => 'Auditor',
            'controller'     => 'Registrable Controller',
            'contact_person' => 'Contact Person',
            'chairperson'    => 'Chairperson',
            'dpo'            => 'Data Protection Officer',
            'representative' => 'Authorized Representative',
            'ceo'            => 'CEO',
            'nominee'        => 'Nominee',
            'ubo'            => 'Ultimate Beneficial Owner',
            'other'          => 'Other Official',
        ];
        
        $label = $typeLabels[$type] ?? ucfirst($type);
        $record = null;
        $members = [];
        
        if ($this->db) {
            $clientId = $this->getClientDbId();
            $members = $this->db->fetchAll(
                "SELECT id, name, email FROM members WHERE client_id = ? ORDER BY name",
                [$clientId]
            );
            
            if ($id) {
                $tableMap = [
                    'director'    => 'directors',
                    'shareholder' => 'shareholders',
                    'secretary'   => 'secretaries',
                    'auditor'     => 'auditors',
                    'controller'  => 'controllers',
                ];
                $table = $tableMap[$type] ?? 'company_officials';
                $record = $this->db->fetchOne("SELECT * FROM {$table} WHERE id = ?", [$id]);
            }
        }
        
        // Return a simple HTML form
        $isEdit = $record !== null;
        $formAction = base_url("Ajax/save_officer/{$type}/{$companyId}" . ($id ? "/{$id}" : ''));
        
        $html = '<form id="officerForm" action="' . $formAction . '" method="POST">';
        $html .= '<input type="hidden" name="ci_csrf_token" value="' . $this->generateCsrfToken() . '">';
        
        $html .= '<div class="form-group">';
        $html .= '<label>Select Existing Individual</label>';
        $html .= '<select name="member_id" class="form-control select2">';
        $html .= '<option value="">-- Select --</option>';
        foreach ($members as $m) {
            $sel = ($record && isset($record->member_id) && $record->member_id == $m->id) ? ' selected' : '';
            $html .= '<option value="' . $m->id . '"' . $sel . '>' . htmlspecialchars($m->name) . '</option>';
        }
        $html .= '</select></div>';
        
        $html .= '<div class="form-group"><label>Name *</label>';
        $html .= '<input type="text" name="name" class="form-control" required value="' . htmlspecialchars($record->name ?? '') . '"></div>';
        
        $html .= '<div class="row"><div class="col-md-6"><div class="form-group"><label>ID Type</label>';
        $html .= '<select name="id_type" class="form-control"><option value="">Select</option>';
        foreach (['NRIC', 'Passport', 'FIN'] as $idt) {
            $sel = ($record && isset($record->id_type) && $record->id_type === $idt) ? ' selected' : '';
            $html .= '<option value="' . $idt . '"' . $sel . '>' . $idt . '</option>';
        }
        $html .= '</select></div></div>';
        $html .= '<div class="col-md-6"><div class="form-group"><label>ID Number</label>';
        $html .= '<input type="text" name="id_number" class="form-control" value="' . htmlspecialchars($record->id_number ?? '') . '"></div></div></div>';
        
        $html .= '<div class="row"><div class="col-md-6"><div class="form-group"><label>Email</label>';
        $html .= '<input type="email" name="email" class="form-control" value="' . htmlspecialchars($record->email ?? '') . '"></div></div>';
        $html .= '<div class="col-md-6"><div class="form-group"><label>Date of Appointment</label>';
        $html .= '<input type="date" name="date_of_appointment" class="form-control" value="' . ($record->date_of_appointment ?? '') . '"></div></div></div>';
        
        $html .= '<div class="form-group"><label>Nationality</label>';
        $html .= '<input type="text" name="nationality" class="form-control" value="' . htmlspecialchars($record->nationality ?? '') . '"></div>';
        
        $html .= '<div class="form-group text-right">';
        $html .= '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> ';
        $html .= '<button type="submit" class="btn btn-primary">' . ($isEdit ? 'Update' : 'Add') . ' ' . $label . '</button>';
        $html .= '</div></form>';
        
        echo $html;
        exit;
    }

    /**
     * Save officer record (add/update)
     * POST /Ajax/save_officer/{type}/{company_id}[/{id}]
     */
    public function save_officer($type = null, $companyId = null, $id = null) {
        $this->requireAuth();
        
        if (!$type || !$companyId) {
            $this->json(['success' => false, 'message' => 'Type and company ID required'], 400);
        }
        
        $tableMap = [
            'director'    => 'directors',
            'shareholder' => 'shareholders',
            'secretary'   => 'secretaries',
            'auditor'     => 'auditors',
            'controller'  => 'controllers',
        ];
        
        $table = $tableMap[$type] ?? 'company_officials';
        
        $data = [
            'company_id'          => $companyId,
            'name'                => $this->input('name', ''),
            'id_type'             => $this->input('id_type'),
            'id_number'           => $this->input('id_number'),
            'email'               => $this->input('email'),
            'date_of_appointment' => $this->input('date_of_appointment') ?: null,
            'status'              => 'Active',
        ];
        
        $memberId = $this->input('member_id');
        if ($memberId) {
            $data['member_id'] = $memberId;
        }
        
        $nationality = $this->input('nationality');
        // Only add nationality if the table supports it
        if (in_array($type, ['director', 'shareholder', 'secretary'])) {
            $data['nationality'] = $nationality;
        }
        
        // For generic officials, add the type
        if ($table === 'company_officials') {
            $data['official_type'] = $type;
        }
        
        if ($this->db) {
            if ($id) {
                $this->db->update($table, $data, 'id = ?', [$id]);
                $this->json(['success' => true, 'message' => ucfirst($type) . ' updated successfully']);
            } else {
                $newId = $this->db->insert($table, $data);
                $this->json(['success' => true, 'message' => ucfirst($type) . ' added successfully', 'id' => $newId]);
            }
        } else {
            $this->json(['success' => true, 'message' => ucfirst($type) . ' saved (demo mode)']);
        }
    }

    /**
     * Save company (add/edit)
     * POST /Ajax/save_company
     */
    public function save_company() {
        $this->requireAuth();
        
        $companyId = $this->input('company_id');
        $clientId = $this->getClientDbId();
        
        $data = [
            'client_id'                => $clientId,
            'company_name'             => $this->input('company_name', ''),
            'former_name'              => $this->input('former_name'),
            'trading_name'             => $this->input('trading_name'),
            'company_type_id'          => $this->input('company_type_id') ?: null,
            'registration_number'      => $this->input('registration_number'),
            'acra_registration_number' => $this->input('acra_registration_number'),
            'country'                  => $this->input('country', 'SINGAPORE'),
            'incorporation_date'       => $this->input('incorporation_date') ?: null,
            'entity_status'            => $this->input('entity_status', 'Live'),
            'internal_css_status'      => $this->input('internal_css_status', 'Active'),
            'fye_date'                 => $this->input('fye_date') ?: null,
            'email'                    => $this->input('email'),
            'phone1_number'            => $this->input('phone1_number'),
            'contact_person'           => $this->input('contact_person'),
            'remarks'                  => $this->input('remarks'),
            'is_css_client'            => $this->input('is_css_client', 1),
            'is_client'                => 1,
        ];
        
        if ($this->db) {
            if ($companyId) {
                $this->db->update('companies', $data, 'id = ?', [$companyId]);
                $this->setFlash('success', 'Company updated successfully');
                $this->redirect('view_company/' . $companyId);
            } else {
                $data['created_by'] = $_SESSION['user_id'] ?? 1;
                $newId = $this->db->insert('companies', $data);
                $this->setFlash('success', 'Company created successfully');
                $this->redirect('view_company/' . $newId);
            }
        } else {
            $this->setFlash('success', 'Company saved (demo mode)');
            $this->redirect('company_list');
        }
    }

    /**
     * Save member (add/edit)
     * POST /Ajax/save_member
     */
    public function save_member() {
        $this->requireAuth();
        
        $memberId = $this->input('member_id');
        $clientId = $this->getClientDbId();
        
        $data = [
            'client_id'     => $clientId,
            'name_initials' => $this->input('name_initials'),
            'name'          => $this->input('name', ''),
            'former_name'   => $this->input('former_name'),
            'gender'        => $this->input('gender'),
            'date_of_birth' => $this->input('date_of_birth') ?: null,
            'nationality'   => $this->input('nationality'),
            'email'         => $this->input('email'),
            'mobile_code'   => $this->input('mobile_code', '65'),
            'mobile_number' => $this->input('mobile_number'),
            'status'        => $this->input('status', 'Active'),
        ];
        
        if ($this->db) {
            if ($memberId) {
                $this->db->update('members', $data, 'id = ?', [$memberId]);
                $this->setFlash('success', 'Individual updated successfully');
                $this->redirect('view_member/' . $memberId);
            } else {
                $data['created_by'] = $_SESSION['user_id'] ?? 1;
                $newId = $this->db->insert('members', $data);
                $this->setFlash('success', 'Individual created successfully');
                $this->redirect('view_member/' . $newId);
            }
        } else {
            $this->setFlash('success', 'Individual saved (demo mode)');
            $this->redirect('member');
        }
    }

    // ─── Global Search ──────────────────────────────────────────────

    /**
     * Global site search across companies, members, documents, events, etc.
     * GET /Ajax/global_search?q=keyword
     */
    public function global_search() {
        $this->requireAuth();
        
        $keyword = trim($this->input('q', ''));
        if (strlen($keyword) < 2) {
            $this->json(['success' => true, 'data' => [], 'total' => 0]);
        }
        
        $results = [];
        $clientId = $this->getClientDbId();
        $like = '%' . $keyword . '%';
        
        if ($this->db) {
            // 1. Search Companies
            $companies = $this->db->fetchAll(
                "SELECT id, company_name, registration_number, entity_status, country
                 FROM companies 
                 WHERE client_id = ? AND (
                     company_name LIKE ? OR 
                     registration_number LIKE ? OR 
                     acra_registration_number LIKE ? OR
                     former_name LIKE ? OR
                     trading_name LIKE ? OR
                     email LIKE ? OR
                     contact_person LIKE ?
                 )
                 ORDER BY company_name ASC
                 LIMIT 8",
                [$clientId, $like, $like, $like, $like, $like, $like, $like]
            );
            foreach ($companies as $c) {
                $results[] = [
                    'type'     => 'company',
                    'icon'     => 'building',
                    'title'    => $c->company_name,
                    'subtitle' => trim(($c->registration_number ?: '') . ($c->country ? ' · ' . $c->country : '')),
                    'badge'    => $c->entity_status ?: '',
                    'url'      => base_url('view_company/' . $c->id),
                ];
            }
            
            // 2. Search Members/Individuals
            $members = $this->db->fetchAll(
                "SELECT m.id, m.name, m.email, m.nationality, m.mobile_number
                 FROM members m
                 WHERE m.client_id = ? AND (
                     m.name LIKE ? OR 
                     m.email LIKE ? OR
                     m.former_name LIKE ? OR
                     m.mobile_number LIKE ?
                 )
                 ORDER BY m.name ASC
                 LIMIT 8",
                [$clientId, $like, $like, $like, $like]
            );
            foreach ($members as $m) {
                $subtitle = [];
                if ($m->email) $subtitle[] = $m->email;
                if ($m->nationality) $subtitle[] = $m->nationality;
                $results[] = [
                    'type'     => 'member',
                    'icon'     => 'user',
                    'title'    => $m->name,
                    'subtitle' => implode(' · ', $subtitle),
                    'badge'    => '',
                    'url'      => base_url('view_member/' . $m->id),
                ];
            }
            
            // 3. Search Directors
            $directors = $this->db->fetchAll(
                "SELECT d.id, d.name, d.id_number, d.company_id, c.company_name
                 FROM directors d
                 LEFT JOIN companies c ON c.id = d.company_id
                 WHERE c.client_id = ? AND (
                     d.name LIKE ? OR 
                     d.id_number LIKE ?
                 )
                 ORDER BY d.name ASC
                 LIMIT 5",
                [$clientId, $like, $like]
            );
            foreach ($directors as $d) {
                $results[] = [
                    'type'     => 'director',
                    'icon'     => 'briefcase',
                    'title'    => $d->name,
                    'subtitle' => 'Director' . ($d->company_name ? ' · ' . $d->company_name : ''),
                    'badge'    => '',
                    'url'      => base_url('view_company/' . $d->company_id),
                ];
            }
            
            // 4. Search Documents
            $documents = $this->db->fetchAll(
                "SELECT d.id, d.document_name, d.entity_type, d.entity_id, d.file_type, d.created_at
                 FROM documents d
                 WHERE d.client_id = ? AND d.document_name LIKE ?
                 ORDER BY d.created_at DESC
                 LIMIT 5",
                [$clientId, $like]
            );
            foreach ($documents as $doc) {
                $docUrl = $doc->entity_type === 'company' 
                    ? base_url('view_company/' . $doc->entity_id) 
                    : base_url('view_member/' . $doc->entity_id);
                $results[] = [
                    'type'     => 'document',
                    'icon'     => 'file',
                    'title'    => $doc->document_name,
                    'subtitle' => ucfirst($doc->entity_type) . ' document' . ($doc->created_at ? ' · ' . date('d M Y', strtotime($doc->created_at)) : ''),
                    'badge'    => '',
                    'url'      => $docUrl,
                ];
            }
            
            // 5. Search Events (AGM/AR etc.)
            $events = $this->db->fetchAll(
                "SELECT e.id, e.company_id, e.event_type, e.status, e.due_date, c.company_name
                 FROM company_events e
                 LEFT JOIN companies c ON c.id = e.company_id
                 WHERE c.client_id = ? AND (
                     e.event_type LIKE ? OR 
                     c.company_name LIKE ?
                 )
                 ORDER BY e.due_date DESC
                 LIMIT 5",
                [$clientId, $like, $like]
            );
            foreach ($events as $ev) {
                $results[] = [
                    'type'     => 'event',
                    'icon'     => 'calendar',
                    'title'    => ($ev->event_type ?: 'Event') . ' — ' . ($ev->company_name ?: ''),
                    'subtitle' => ($ev->status ?: '') . ($ev->due_date ? ' · Due ' . date('d M Y', strtotime($ev->due_date)) : ''),
                    'badge'    => $ev->status ?: '',
                    'url'      => base_url('view_company/' . $ev->company_id),
                ];
            }
        }
        
        // Sort: companies first, then members, then the rest
        $typeOrder = ['company' => 0, 'member' => 1, 'director' => 2, 'document' => 3, 'event' => 4];
        usort($results, function($a, $b) use ($typeOrder) {
            return ($typeOrder[$a['type']] ?? 9) - ($typeOrder[$b['type']] ?? 9);
        });
        
        // Limit total results
        $total = count($results);
        $results = array_slice($results, 0, 20);
        
        $this->json(['success' => true, 'data' => $results, 'total' => $total]);
    }

    // ─── Helpers ─────────────────────────────────────────────────────

    /**
     * Get the database ID for the current client
     */
    private function getClientDbId() {
        if (!$this->db) return 1;
        $clientId = $_SESSION['client_id'] ?? '';
        $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
        return $client ? $client->id : 1;
    }
}
