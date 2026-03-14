<?php
/**
 * Documents Controller - Document Management
 * Handles: /documents
 */
class Documents extends BaseController {
    
    public function index() {
        $this->requireAuth();
        $documents = [];
        $companyFolders = [];
        $totalDocs = 0;
        $recentDocs = [];
        $categories = [];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                // Get company folders with document counts
                $companyFolders = $this->db->fetchAll(
                    "SELECT c.id, c.company_name, c.registration_number, c.entity_status,
                            COUNT(d.id) as doc_count,
                            MAX(d.created_at) as latest_doc
                     FROM companies c
                     LEFT JOIN documents d ON d.entity_id = c.id AND d.entity_type = 'company'
                     WHERE c.client_id = ?
                     GROUP BY c.id
                     ORDER BY c.company_name ASC",
                    [$client->id]
                );

                // Count unlinked/general docs
                $generalCount = $this->db->fetchOne(
                    "SELECT COUNT(*) as cnt FROM documents WHERE client_id = ? AND (entity_id IS NULL OR entity_type != 'company')",
                    [$client->id]
                );

                // Get all documents (flat)
                $documents = $this->db->fetchAll(
                    "SELECT d.*, c.company_name as company, u.name as uploaded_by 
                     FROM documents d 
                     LEFT JOIN companies c ON c.id = d.entity_id AND d.entity_type='company'
                     LEFT JOIN users u ON u.id = d.uploaded_by
                     WHERE d.client_id = ?
                     ORDER BY d.created_at DESC
                     LIMIT 500",
                    [$client->id]
                );

                $totalDocs = count($documents);

                // Add computed fields
                foreach ($documents as &$doc) {
                    $doc->name = $doc->document_name ?? $doc->file_name ?? 'Untitled';
                    $doc->type = $doc->document_type ?? $doc->category_name ?? 'General';
                    $ext = strtolower(pathinfo($doc->document_name ?? $doc->file_name ?? '', PATHINFO_EXTENSION));
                    $iconMap = ['pdf'=>'pdf-o','doc'=>'word-o','docx'=>'word-o','xls'=>'excel-o','xlsx'=>'excel-o','jpg'=>'image-o','jpeg'=>'image-o','png'=>'image-o','gif'=>'image-o','txt'=>'text-o','csv'=>'excel-o','zip'=>'archive-o','rar'=>'archive-o'];
                    $doc->icon = $iconMap[$ext] ?? 'o';
                    $doc->size = !empty($doc->file_size) ? $this->formatBytes($doc->file_size) : '';
                }

                // Recent docs (last 10)
                $recentDocs = array_slice($documents, 0, 10);

                // Categories
                $categories = $this->db->fetchAll(
                    "SELECT * FROM document_categories WHERE client_id = ? ORDER BY category_name",
                    [$client->id]
                );
            }
        }
        $data = [
            'page_title' => 'Document Management',
            'documents' => $documents,
            'company_folders' => $companyFolders,
            'total_docs' => $totalDocs,
            'general_count' => (int) ($generalCount->cnt ?? 0),
            'recent_docs' => $recentDocs,
            'categories' => $categories,
        ];
        $this->loadLayout('documents/index', $data);
    }

    public function upload() {
        $this->requireAuth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$this->validateCsrf()) {
            $this->redirect('documents');
            return;
        }
        if (empty($_FILES['documents']) || empty($_FILES['documents']['name'][0])) {
            $this->setFlash('error', 'No file selected.');
            $this->redirect('documents');
            return;
        }
        $clientId = $_SESSION['client_id'] ?? '';
        $client = $this->db ? $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]) : null;
        if (!$client) { $this->redirect('documents'); return; }

        $uploadDir = BASEPATH . 'uploads/documents/';
        if (!is_dir($uploadDir)) { mkdir($uploadDir, 0755, true); }

        $userCompanyId = $this->input('company_id', '') ?: null;
        $docType   = $this->input('document_type', 'General');
        $desc      = $this->input('description', '');
        $userId    = $_SESSION['user_id'] ?? null;

        // Pre-load all company names for auto-matching
        $allCompanies = $this->db->fetchAll(
            "SELECT id, company_name FROM companies WHERE client_id = ? ORDER BY CHAR_LENGTH(company_name) DESC",
            [$client->id]
        );

        $count = 0;
        $matched = 0;
        $unmatched = 0;

        foreach ($_FILES['documents']['name'] as $i => $name) {
            if ($_FILES['documents']['error'][$i] !== UPLOAD_ERR_OK) continue;
            $tmpName = $_FILES['documents']['tmp_name'][$i];
            $size    = $_FILES['documents']['size'][$i];
            $safeName = time() . '_' . $i . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $name);
            $dest     = $uploadDir . $safeName;

            // Determine company_id: user-selected > auto-match from filename > null (unidentified)
            $companyId = $userCompanyId;
            if (!$companyId) {
                $companyId = $this->matchCompanyFromFilename($name, $allCompanies);
            }

            $entityType = $companyId ? 'company' : 'general';

            if (move_uploaded_file($tmpName, $dest)) {
                $this->db->insert('documents', [
                    'client_id'     => $client->id,
                    'entity_type'   => $entityType,
                    'entity_id'     => $companyId,
                    'document_name' => $name,
                    'file_path'     => 'uploads/documents/' . $safeName,
                    'file_size'     => $size,
                    'file_type'     => strtolower(pathinfo($name, PATHINFO_EXTENSION)),
                    'uploaded_by'   => $userId,
                ]);
                $count++;
                if ($companyId) { $matched++; } else { $unmatched++; }
            }
        }

        $msg = "{$count} document(s) uploaded.";
        if ($matched > 0) $msg .= " {$matched} auto-matched to companies.";
        if ($unmatched > 0) $msg .= " {$unmatched} placed in Unidentified folder.";
        $this->setFlash('success', $msg);
        $this->redirect('documents');
    }

    /**
     * Try to match a filename to a company by checking if the company name appears in the filename.
     * Uses longest-match-first to avoid false positives (e.g. "ARK" matching before "ARK SOLAR ENERGY").
     */
    private function matchCompanyFromFilename($filename, $allCompanies) {
        // Remove extension, replace separators with spaces, normalize
        $clean = pathinfo($filename, PATHINFO_FILENAME);
        $clean = str_replace(['_', '-', '.'], ' ', $clean);
        $cleanLower = strtolower($clean);

        foreach ($allCompanies as $co) {
            $coName = strtolower(trim($co->company_name));
            if ($coName === '') continue;

            // Try full company name match
            if (strpos($cleanLower, $coName) !== false) {
                return (int) $co->id;
            }

            // Try without common suffixes (PTE. LTD., LTD., LLP, etc.)
            $short = preg_replace('/\s*(pte\.?\s*ltd\.?|ltd\.?|llp|inc\.?|corp\.?|sdn\.?\s*bhd\.?|pac)\s*$/i', '', $coName);
            $short = trim($short);
            if ($short !== '' && strlen($short) >= 4 && strpos($cleanLower, $short) !== false) {
                return (int) $co->id;
            }
        }

        return null;
    }

    public function download($id = null) {
        $this->requireAuth();
        if (!$id || !$this->db) { $this->redirect('documents'); return; }
        $doc = $this->db->fetchOne("SELECT * FROM documents WHERE id = ?", [$id]);
        if (!$doc || empty($doc->file_path)) { $this->redirect('documents'); return; }
        $filePath = BASEPATH . $doc->file_path;
        if (!file_exists($filePath)) { $this->setFlash('error', 'File not found.'); $this->redirect('documents'); return; }
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . ($doc->document_name ?? $doc->file_name ?? 'download') . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }

    private function formatBytes($bytes, $precision = 1) {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

// Company File Manager (maps to /company_file)
class Company_file extends BaseController {
    public function index($company_id = null) {
        $this->requireAuth();
        $data = ['page_title' => 'Company Files', 'company' => null, 'files' => [], 'categories' => [], 'companies' => []];
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['companies'] = $this->db->fetchAll("SELECT id, company_name, registration_number FROM companies WHERE client_id = ? ORDER BY company_name", [$client->id]);
                $data['categories'] = $this->db->fetchAll("SELECT * FROM document_categories WHERE client_id = ? ORDER BY category_name", [$client->id]);
                if ($company_id || !empty($_GET['company_id'])) {
                    $cid = $company_id ?: $_GET['company_id'];
                    $data['company'] = $this->db->fetchOne("SELECT * FROM companies WHERE id = ?", [$cid]);
                    $data['files'] = $this->db->fetchAll(
                        "SELECT d.*, dc.category_name, u.name as uploaded_by_name FROM documents d LEFT JOIN document_categories dc ON dc.id = d.category_id LEFT JOIN users u ON u.id = d.uploaded_by WHERE d.entity_type = 'company' AND d.entity_id = ? ORDER BY d.created_at DESC", [$cid]
                    );
                }
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
            $this->db->query("UPDATE documents SET document_name=?, category_id=?, entity_type=?, entity_id=? WHERE id=?", [
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
                $this->db->query("UPDATE form_templates SET template_name=?, category_id=?, description=?, status=? WHERE id=?", [
                    $this->input('template_name',''), $this->input('category_id',''), $this->input('description',''), $this->input('status','Active'), $id
                ]);
            } else {
                $clientId = $_SESSION['client_id'] ?? '';
                $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
                if ($client) {
                    $this->db->query("INSERT INTO form_templates (client_id,template_name,category_id,description,status) VALUES (?,?,?,?,?)", [
                        $client->id, $this->input('template_name',''), $this->input('category_id',''), $this->input('description',''), $this->input('status','Active')
                    ]);
                }
            }
            $this->setFlash('success', 'Form saved.'); $this->redirect('company_forms'); return;
        }
        $this->loadLayout('documents/edit_form', $data);
    }
}
