<?php
/**
 * Templates Controller - Template Management & eSign
 * Handles: /templates, /esign
 */
class Templates extends BaseController {
    
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Template Management',
            'templates' => [],
        ];
        $this->loadLayout('templates/index', $data);
    }
}

/**
 * eSign Documents Controller
 * 
 * Routes (via /esign/* prefix in router):
 *   GET  /esign/manage           — list all eSign envelopes
 *   GET  /esign/create           — show create wizard
 *   POST /esign/store            — save new eSign request
 *   GET  /esign/view/{id}        — view envelope detail
 *   POST /esign/send/{id}        — send envelope for signing
 *   POST /esign/remind/{id}      — send reminder to pending signers
 *   POST /esign/void/{id}        — void/cancel envelope
 *   POST /esign/delete/{id}      — delete draft envelope
 *   GET  /esign/download/{id}    — download signed document
 *   GET  /esign/signers/{companyId} — get directors/shareholders as JSON for recipient picker
 */
class Esign extends BaseController {

    /**
     * Magic method to handle /esign/view/{id} since "view" conflicts with BaseController::view()
     */
    public function __call($method, $args) {
        if ($method === 'view' && !empty($args)) {
            return $this->detail($args[0]);
        }
        if ($method === 'view') {
            return $this->detail(null);
        }
        $this->redirect('esign/manage');
    }

    /**
     * List all eSign envelopes
     * GET /esign/manage (or /esign)
     */
    public function index() {
        $this->manage();
    }

    public function manage() {
        $this->requireAuth();
        $documents = [];
        $statusCounts = ['all' => 0, 'Draft' => 0, 'Sent' => 0, 'Completed' => 0, 'Declined' => 0, 'Voided' => 0];

        if ($this->db) {
            $clientId = $this->getClientDbId();

            $documents = $this->db->fetchAll(
                "SELECT e.*, 
                        c.company_name,
                        u.name as creator_name,
                        d.document_name as source_doc_name,
                        (SELECT COUNT(*) FROM esign_signers WHERE esign_id = e.id) as signer_count,
                        (SELECT COUNT(*) FROM esign_signers WHERE esign_id = e.id AND status = 'Completed') as signed_count
                 FROM esign_documents e
                 LEFT JOIN companies c ON c.id = e.company_id
                 LEFT JOIN users u ON u.id = e.created_by
                 LEFT JOIN documents d ON d.id = e.document_id
                 WHERE e.client_id = ?
                 ORDER BY e.created_at DESC",
                [$clientId]
            );

            $statusCounts['all'] = count($documents);
            foreach ($documents as $doc) {
                $s = $doc->status ?? 'Draft';
                if (isset($statusCounts[$s])) $statusCounts[$s]++;
            }
        }

        $data = [
            'page_title'    => 'eSign Documents',
            'documents'     => $documents,
            'status_counts' => $statusCounts,
        ];
        $this->loadLayout('templates/esign', $data);
    }

    /**
     * Show create wizard
     * GET /esign/create
     */
    public function create() {
        $this->requireAuth();
        $companies = [];
        $documents = [];

        if ($this->db) {
            $clientId = $this->getClientDbId();

            $companies = $this->db->fetchAll(
                "SELECT id, company_name, registration_number FROM companies WHERE client_id = ? ORDER BY company_name",
                [$clientId]
            );

            // Get recent documents that can be signed (PDF, DOC, DOCX)
            $documents = $this->db->fetchAll(
                "SELECT d.id, d.document_name, d.entity_type, d.entity_id, d.file_type, d.file_path,
                        c.company_name
                 FROM documents d
                 LEFT JOIN companies c ON c.id = d.entity_id AND d.entity_type = 'company'
                 WHERE d.client_id = ?
                 ORDER BY d.created_at DESC
                 LIMIT 200",
                [$clientId]
            );
        }

        $data = [
            'page_title' => 'New eSign Request',
            'companies'  => $companies,
            'documents'  => $documents,
        ];
        $this->loadLayout('templates/esign_create', $data);
    }

    /**
     * Save new eSign request
     * POST /esign/store
     */
    public function store() {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('esign/manage');
            return;
        }

        $clientId = $this->getClientDbId();
        $title = trim($this->input('title', ''));
        $subject = trim($this->input('subject', ''));
        $message = trim($this->input('message', ''));
        $companyId = $this->input('company_id') ?: null;
        $documentId = $this->input('document_id') ?: null;
        $signingOrder = $this->input('signing_order') ? 1 : 0;
        $expiresAt = $this->input('expires_at') ?: null;
        $signers = $this->input('signers'); // array of signer objects

        if (!$title) {
            $this->setFlash('error', 'Document title is required.');
            $this->redirect('esign/create');
            return;
        }

        // Get document name from document_id if not provided
        $docName = $title;
        if ($documentId && $this->db) {
            $doc = $this->db->fetchOne("SELECT document_name FROM documents WHERE id = ?", [$documentId]);
            if ($doc) $docName = $doc->document_name;
        }

        if ($this->db) {
            $uniqueKey = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 12));

            $esignId = $this->db->insert('esign_documents', [
                'client_id'     => $clientId,
                'company_id'    => $companyId,
                'document_id'   => $documentId,
                'title'         => $title,
                'subject'       => $subject ?: 'Signature required: ' . $title,
                'message'       => $message,
                'status'        => 'Draft',
                'signing_order' => $signingOrder,
                'unique_key'    => $uniqueKey,
                'expires_at'    => $expiresAt,
                'created_by'    => $_SESSION['user_id'] ?? 1,
            ]);

            // Insert signers
            if (is_array($signers)) {
                $order = 1;
                foreach ($signers as $signer) {
                    $name = trim($signer['name'] ?? '');
                    $email = trim($signer['email'] ?? '');
                    if (!$name || !$email) continue;

                    $this->db->insert('esign_signers', [
                        'esign_id'      => $esignId,
                        'name'          => $name,
                        'email'         => $email,
                        'role'          => $signer['role'] ?? 'Signer',
                        'person_type'   => $signer['person_type'] ?? 'Other',
                        'person_id'     => $signer['person_id'] ?: null,
                        'routing_order' => $signingOrder ? $order++ : 1,
                        'status'        => 'Pending',
                    ]);
                }
            }

            // Audit log
            $this->logAudit($esignId, 'Created', 'Envelope created as Draft');

            $this->setFlash('success', 'eSign request created successfully.');
            $this->redirect('esign/view/' . $esignId);
            return;
        }

        $this->setFlash('error', 'Database not available.');
        $this->redirect('esign/manage');
    }

    /**
     * View envelope detail
     * GET /esign/detail/{id}  (also accessible via /esign/view/{id} through __call)
     */
    public function detail($id = null) {
        $this->requireAuth();
        if (!$id) { $this->redirect('esign/manage'); return; }

        $envelope = null;
        $signers = [];
        $auditLog = [];

        if ($this->db) {
            $clientId = $this->getClientDbId();

            $envelope = $this->db->fetchOne(
                "SELECT e.*, 
                        c.company_name,
                        u.name as creator_name,
                        d.document_name as source_doc_name,
                        d.file_path as source_file_path
                 FROM esign_documents e
                 LEFT JOIN companies c ON c.id = e.company_id
                 LEFT JOIN users u ON u.id = e.created_by
                 LEFT JOIN documents d ON d.id = e.document_id
                 WHERE e.id = ? AND e.client_id = ?",
                [$id, $clientId]
            );

            if (!$envelope) {
                $this->setFlash('error', 'eSign document not found.');
                $this->redirect('esign/manage');
                return;
            }

            $signers = $this->db->fetchAll(
                "SELECT * FROM esign_signers WHERE esign_id = ? ORDER BY routing_order ASC, id ASC",
                [$id]
            );

            $auditLog = $this->db->fetchAll(
                "SELECT * FROM esign_audit_log WHERE esign_id = ? ORDER BY created_at DESC",
                [$id]
            );
        }

        $data = [
            'page_title' => 'eSign: ' . ($envelope->title ?? ''),
            'envelope'   => $envelope,
            'signers'    => $signers,
            'audit_log'  => $auditLog,
        ];
        $this->loadLayout('templates/esign_view', $data);
    }

    /**
     * Send envelope for signing
     * POST /esign/send/{id}
     */
    public function send($id = null) {
        $this->requireAuth();
        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('esign/manage');
            return;
        }

        if ($this->db) {
            $clientId = $this->getClientDbId();
            $envelope = $this->db->fetchOne(
                "SELECT * FROM esign_documents WHERE id = ? AND client_id = ?",
                [$id, $clientId]
            );

            if (!$envelope) {
                $this->json(['success' => false, 'message' => 'Envelope not found'], 404);
                return;
            }

            if ($envelope->status !== 'Draft') {
                $this->json(['success' => false, 'message' => 'Only draft envelopes can be sent'], 400);
                return;
            }

            // Check signers exist
            $signerCount = $this->db->count('esign_signers', 'esign_id = ?', [$id]);
            if ($signerCount === 0) {
                $this->json(['success' => false, 'message' => 'At least one signer is required'], 400);
                return;
            }

            // Update status to Sent
            $this->db->update('esign_documents', [
                'status'  => 'Sent',
                'sent_at' => date('Y-m-d H:i:s'),
            ], 'id = ?', [$id]);

            // Update all signers to Sent
            $this->db->update('esign_signers', [
                'status' => 'Sent',
            ], 'esign_id = ?', [$id]);

            $this->logAudit($id, 'Sent', 'Envelope sent for signing');

            $this->json(['success' => true, 'message' => 'Envelope sent for signing successfully']);
        }
    }

    /**
     * Send reminder to pending signers
     * POST /esign/remind/{id}
     */
    public function remind($id = null) {
        $this->requireAuth();
        if (!$id) {
            $this->json(['success' => false, 'message' => 'ID required'], 400);
            return;
        }

        if ($this->db) {
            $clientId = $this->getClientDbId();
            $envelope = $this->db->fetchOne(
                "SELECT * FROM esign_documents WHERE id = ? AND client_id = ?",
                [$id, $clientId]
            );

            if (!$envelope || $envelope->status !== 'Sent') {
                $this->json(['success' => false, 'message' => 'Envelope not found or not in sent state'], 400);
                return;
            }

            // Get pending signers
            $pendingSigners = $this->db->fetchAll(
                "SELECT * FROM esign_signers WHERE esign_id = ? AND status IN ('Sent','Pending')",
                [$id]
            );

            $this->logAudit($id, 'Reminder', 'Reminder sent to ' . count($pendingSigners) . ' pending signer(s)');

            $this->json([
                'success' => true, 
                'message' => 'Reminder sent to ' . count($pendingSigners) . ' pending signer(s)'
            ]);
        }
    }

    /**
     * Void/cancel an envelope
     * POST /esign/void/{id}
     */
    public function void($id = null) {
        $this->requireAuth();
        if (!$id) {
            $this->json(['success' => false, 'message' => 'ID required'], 400);
            return;
        }

        if ($this->db) {
            $clientId = $this->getClientDbId();
            $envelope = $this->db->fetchOne(
                "SELECT * FROM esign_documents WHERE id = ? AND client_id = ?",
                [$id, $clientId]
            );

            if (!$envelope) {
                $this->json(['success' => false, 'message' => 'Envelope not found'], 404);
                return;
            }

            if (in_array($envelope->status, ['Completed', 'Voided'])) {
                $this->json(['success' => false, 'message' => 'Cannot void a ' . strtolower($envelope->status) . ' envelope'], 400);
                return;
            }

            $reason = trim($this->input('reason', 'Voided by user'));

            $this->db->update('esign_documents', [
                'status'      => 'Voided',
                'voided_at'   => date('Y-m-d H:i:s'),
                'void_reason' => $reason,
            ], 'id = ?', [$id]);

            $this->logAudit($id, 'Voided', $reason);

            $this->json(['success' => true, 'message' => 'Envelope voided successfully']);
        }
    }

    /**
     * Delete a draft envelope
     * POST /esign/delete/{id}
     */
    public function delete($id = null) {
        $this->requireAuth();
        if (!$id) {
            $this->json(['success' => false, 'message' => 'ID required'], 400);
            return;
        }

        if ($this->db) {
            $clientId = $this->getClientDbId();
            $envelope = $this->db->fetchOne(
                "SELECT * FROM esign_documents WHERE id = ? AND client_id = ?",
                [$id, $clientId]
            );

            if (!$envelope) {
                $this->json(['success' => false, 'message' => 'Envelope not found'], 404);
                return;
            }

            if ($envelope->status !== 'Draft') {
                $this->json(['success' => false, 'message' => 'Only draft envelopes can be deleted'], 400);
                return;
            }

            // Cascade delete handled by FK, but explicit for safety
            $this->db->delete('esign_audit_log', 'esign_id = ?', [$id]);
            $this->db->delete('esign_signers', 'esign_id = ?', [$id]);
            $this->db->delete('esign_documents', 'id = ?', [$id]);

            $this->json(['success' => true, 'message' => 'Draft deleted successfully']);
        }
    }

    /**
     * Download signed/original document
     * GET /esign/download/{id}
     */
    public function download($id = null) {
        $this->requireAuth();
        if (!$id) { $this->redirect('esign/manage'); return; }

        if ($this->db) {
            $clientId = $this->getClientDbId();
            $envelope = $this->db->fetchOne(
                "SELECT e.*, d.file_path, d.document_name, d.file_type
                 FROM esign_documents e
                 LEFT JOIN documents d ON d.id = e.document_id
                 WHERE e.id = ? AND e.client_id = ?",
                [$id, $clientId]
            );

            if (!$envelope) {
                $this->setFlash('error', 'Document not found.');
                $this->redirect('esign/manage');
                return;
            }

            // Prefer completed document, fallback to original
            $filePath = $envelope->completed_doc_path ?: $envelope->file_path;
            if ($filePath) {
                $fullPath = BASEPATH . $filePath;
                if (file_exists($fullPath)) {
                    $fileName = $envelope->completed_doc_path 
                        ? 'signed_' . ($envelope->document_name ?? 'document') 
                        : ($envelope->document_name ?? 'document');

                    header('Content-Type: ' . ($envelope->file_type ?: 'application/octet-stream'));
                    header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
                    header('Content-Length: ' . filesize($fullPath));
                    readfile($fullPath);
                    exit;
                }
            }

            $this->setFlash('error', 'File not found on disk.');
            $this->redirect('esign/view/' . $id);
        }
    }

    /**
     * Get directors + shareholders for a company as JSON (for recipient picker)
     * GET /esign/signers/{companyId}
     */
    public function signers($companyId = null) {
        $this->requireAuth();
        if (!$companyId) {
            $this->json(['success' => true, 'data' => []]);
            return;
        }

        $result = [];
        if ($this->db) {
            // Directors
            $directors = $this->db->fetchAll(
                "SELECT id, name, email, 'Director' as person_type, status FROM directors WHERE company_id = ? AND status = 'Active' ORDER BY name",
                [$companyId]
            );
            foreach ($directors as $d) {
                $result[] = [
                    'person_id'   => $d->id,
                    'name'        => $d->name,
                    'email'       => $d->email ?: '',
                    'person_type' => 'Director',
                    'role'        => 'Signer',
                ];
            }

            // Shareholders
            $shareholders = $this->db->fetchAll(
                "SELECT id, name, email, 'Shareholder' as person_type, status FROM shareholders WHERE company_id = ? AND status = 'Active' ORDER BY name",
                [$companyId]
            );
            foreach ($shareholders as $sh) {
                // Avoid duplicates (same person might be both director and shareholder)
                $exists = false;
                foreach ($result as $r) {
                    if (strtolower(trim($r['email'])) === strtolower(trim($sh->email ?: '')) && $sh->email) {
                        $exists = true;
                        break;
                    }
                }
                if (!$exists) {
                    $result[] = [
                        'person_id'   => $sh->id,
                        'name'        => $sh->name,
                        'email'       => $sh->email ?: '',
                        'person_type' => 'Shareholder',
                        'role'        => 'Signer',
                    ];
                }
            }

            // Secretaries
            $secretaries = $this->db->fetchAll(
                "SELECT id, name, email, 'Secretary' as person_type, status FROM secretaries WHERE company_id = ? AND status = 'Active' ORDER BY name",
                [$companyId]
            );
            foreach ($secretaries as $sec) {
                $exists = false;
                foreach ($result as $r) {
                    if (strtolower(trim($r['email'])) === strtolower(trim($sec->email ?: '')) && $sec->email) {
                        $exists = true;
                        break;
                    }
                }
                if (!$exists) {
                    $result[] = [
                        'person_id'   => $sec->id,
                        'name'        => $sec->name,
                        'email'       => $sec->email ?: '',
                        'person_type' => 'Secretary',
                        'role'        => 'CC',
                    ];
                }
            }
        }

        $this->json(['success' => true, 'data' => $result]);
    }

    /**
     * Simulate a signer completing their signature (for demo/testing)
     * POST /esign/simulate_sign/{signerId}
     */
    public function simulate_sign($signerId = null) {
        $this->requireAuth();
        if (!$signerId) {
            $this->json(['success' => false, 'message' => 'Signer ID required'], 400);
            return;
        }

        if ($this->db) {
            $signer = $this->db->fetchOne("SELECT * FROM esign_signers WHERE id = ?", [$signerId]);
            if (!$signer) {
                $this->json(['success' => false, 'message' => 'Signer not found'], 404);
                return;
            }

            // Mark signer as completed
            $this->db->update('esign_signers', [
                'status'    => 'Completed',
                'signed_at' => date('Y-m-d H:i:s'),
            ], 'id = ?', [$signerId]);

            $this->logAudit($signer->esign_id, 'Signed', $signer->name . ' (' . $signer->email . ') signed the document');

            // Check if all signers completed
            $pendingCount = $this->db->count('esign_signers', 'esign_id = ? AND status != ?', [$signer->esign_id, 'Completed']);
            if ($pendingCount === 0) {
                $this->db->update('esign_documents', [
                    'status'       => 'Completed',
                    'completed_at' => date('Y-m-d H:i:s'),
                ], 'id = ?', [$signer->esign_id]);

                $this->logAudit($signer->esign_id, 'Completed', 'All signers have completed. Envelope is now complete.');
            }

            $this->json(['success' => true, 'message' => $signer->name . ' has signed successfully']);
        }
    }

    /**
     * Quick status check for auto-refresh polling
     * GET /esign/status_check/{id}
     */
    public function status_check($id = null) {
        $this->requireAuth();
        if (!$id) {
            $this->json(['status' => '']);
            return;
        }
        if ($this->db) {
            $clientId = $this->getClientDbId();
            $envelope = $this->db->fetchOne(
                "SELECT status FROM esign_documents WHERE id = ? AND client_id = ?",
                [$id, $clientId]
            );
            $this->json(['status' => $envelope ? $envelope->status : '']);
        } else {
            $this->json(['status' => '']);
        }
    }

    // ─── Private Helpers ────────────────────────────────────────────

    private function getClientDbId() {
        if (!$this->db) return 1;
        $clientId = $_SESSION['client_id'] ?? '';
        $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
        return $client ? $client->id : 1;
    }

    private function logAudit($esignId, $event, $details = null) {
        if (!$this->db) return;
        $this->db->insert('esign_audit_log', [
            'esign_id'    => $esignId,
            'event'       => $event,
            'actor'       => $_SESSION['user_name'] ?? 'System',
            'actor_email' => $_SESSION['user_email'] ?? '',
            'details'     => $details,
            'ip_address'  => $_SERVER['REMOTE_ADDR'] ?? '',
        ]);
    }
}
