<?php
/**
 * Documents Controller - Document Management
 * Handles: /documents
 */
class Documents extends BaseController {
    
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'All Documents',
            'documents' => [],
        ];
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['documents'] = $this->db->fetchAll(
                    "SELECT d.id, d.document_name, d.file_path, d.file_type, d.file_size,
                            d.entity_type, d.entity_id, d.category_id, d.created_at,
                            c.company_name, c.registration_number,
                            dc.category_name
                     FROM documents d
                     LEFT JOIN companies c ON c.id = d.entity_id AND d.entity_type = 'company'
                     LEFT JOIN document_categories dc ON dc.id = d.category_id
                     WHERE d.client_id = ?
                     ORDER BY d.created_at DESC",
                    [$client->id]
                );
            }
        }
        $this->loadLayout('documents/index', $data);
    }
}

// Company File / Templates Manager (maps to /company_file)
// Displays form_templates list — the "Generate Templates" page
class Company_file extends BaseController {
    public function index($company_id = null) {
        $this->requireAuth();
        $data = [
            'page_title'      => 'Generate Templates',
            'templates'       => [],
            'form_categories' => [],
        ];
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['form_categories'] = $this->db->fetchAll(
                    "SELECT * FROM form_categories WHERE client_id = ? ORDER BY category_name",
                    [$client->id]
                );
                $data['templates'] = $this->db->fetchAll(
                    "SELECT ft.*, fc.category_name
                     FROM form_templates ft
                     LEFT JOIN form_categories fc ON fc.id = ft.category_id
                     WHERE ft.client_id = ?
                     ORDER BY ft.template_name",
                    [$client->id]
                );
            }
        }
        $this->loadLayout('documents/company_file', $data);
    }
}

// Company Document Upload (maps to /company_document)
class Company_document extends BaseController {
    public function index($company_id = null) {
        $this->requireAuth();
        // Redirect to company_file with company context
        if ($company_id) { $this->redirect("company_file/{$company_id}"); } else { $this->redirect('company_file'); }
    }
}

// Edit Document (maps to /edit_document/{id})
class Edit_document extends BaseController {
    public function index($id = null) {
        $this->requireAuth();
        if (!$id) { $this->redirect('documents'); return; }
        $data = ['page_title' => 'Edit Document', 'document' => null, 'categories' => [], 'companies' => []];
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['document'] = $this->db->fetchOne("SELECT * FROM documents WHERE id = ?", [$id]);
                $data['categories'] = $this->db->fetchAll("SELECT * FROM document_categories WHERE client_id = ? ORDER BY category_name", [$client->id]);
                $data['companies'] = $this->db->fetchAll("SELECT id, company_name FROM companies WHERE client_id = ? ORDER BY company_name", [$client->id]);
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->validateCsrf() && $this->db && $data['document']) {
            $this->db->execute("UPDATE documents SET document_name=?, category_id=?, entity_type=?, entity_id=? WHERE id=?", [
                $this->input('document_name',''), $this->input('category_id',''),
                $this->input('entity_type','company'), $this->input('entity_id',''), $id
            ]);
            $this->setFlash('success', 'Document updated.'); $this->redirect("edit_document/{$id}"); return;
        }
        $this->loadLayout('documents/edit_document', $data);
    }
}

// Document History (maps to /document_history/{id})
class Document_history extends BaseController {
    public function index($id = null) {
        $this->requireAuth();
        if (!$id) { $this->redirect('documents'); return; }
        $data = ['page_title' => 'Document History', 'document' => null, 'history' => []];
        if ($this->db) {
            $data['document'] = $this->db->fetchOne(
                "SELECT d.*, c.company_name, dc.category_name FROM documents d LEFT JOIN companies c ON c.id = d.entity_id AND d.entity_type = 'company' LEFT JOIN document_categories dc ON dc.id = d.category_id WHERE d.id = ?", [$id]
            );
            $data['history'] = $this->db->fetchAll(
                "SELECT ul.*, u.name as user_name FROM user_logs ul LEFT JOIN users u ON u.id = ul.user_id WHERE ul.module = 'document' AND ul.record_id = ? ORDER BY ul.created_at DESC", [$id]
            );
        }
        $this->loadLayout('documents/history', $data);
    }
}

// File Preview (maps to /file_preview/{id})
class File_preview extends BaseController {
    public function index($id = null) {
        $this->requireAuth();
        if (!$id) { $this->redirect('documents'); return; }
        $data = ['page_title' => 'File Preview', 'document' => null];
        if ($this->db) {
            $data['document'] = $this->db->fetchOne(
                "SELECT d.*, c.company_name, dc.category_name, u.name as uploaded_by_name FROM documents d LEFT JOIN companies c ON c.id = d.entity_id AND d.entity_type = 'company' LEFT JOIN document_categories dc ON dc.id = d.category_id LEFT JOIN users u ON u.id = d.uploaded_by WHERE d.id = ?", [$id]
            );
        }
        $this->loadLayout('documents/preview', $data);
    }
}

// Company Forms listing (maps to /company_forms)
class Company_forms extends BaseController {
    public function index($company_id = null) {
        $this->requireAuth();
        $data = ['page_title' => 'Company Forms', 'company' => null, 'forms' => [], 'form_categories' => []];
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['form_categories'] = $this->db->fetchAll("SELECT * FROM form_categories WHERE client_id = ? ORDER BY category_name", [$client->id]);
                if ($company_id) {
                    $data['company'] = $this->db->fetchOne("SELECT * FROM companies WHERE id = ?", [$company_id]);
                }
                $data['forms'] = $this->db->fetchAll("SELECT ft.*, fc.category_name FROM form_templates ft LEFT JOIN form_categories fc ON fc.id = ft.category_id WHERE ft.client_id = ? ORDER BY ft.template_name", [$client->id]);
            }
        }
        $this->loadLayout('documents/forms', $data);
    }
}

// Edit Form Template (maps to /edit_form/{id})
class Edit_form extends BaseController {
    public function index($id = null) {
        $this->requireAuth();
        $data = ['page_title' => 'Edit Form', 'form' => null, 'form_categories' => []];
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                if ($id) { $data['form'] = $this->db->fetchOne("SELECT * FROM form_templates WHERE id = ?", [$id]); }
                $data['form_categories'] = $this->db->fetchAll("SELECT * FROM form_categories WHERE client_id = ? ORDER BY category_name", [$client->id]);
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->validateCsrf() && $this->db) {
            if ($id) {
                $this->db->execute("UPDATE form_templates SET template_name=?, category_id=?, description=?, status=? WHERE id=?", [
                    $this->input('template_name',''), $this->input('category_id',''), $this->input('description',''), $this->input('status','Active'), $id
                ]);
            } else {
                $clientId = $_SESSION['client_id'] ?? '';
                $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
                if ($client) {
                    $this->db->execute("INSERT INTO form_templates (client_id,template_name,category_id,description,status) VALUES (?,?,?,?,?)", [
                        $client->id, $this->input('template_name',''), $this->input('category_id',''), $this->input('description',''), $this->input('status','Active')
                    ]);
                }
            }
            $this->setFlash('success', 'Form saved.'); $this->redirect('company_forms'); return;
        }
        $this->loadLayout('documents/edit_form', $data);
    }
}
