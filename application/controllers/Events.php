<?php
/**
 * Events Controller - Event Tracker / AGM / AR / FYE / Anniversary / Due / ID Expiry
 * Handles: /event_tracker, /agm_listing, /ar_listing, /fye_listing, /anniversary_listing, /due_listing, /id_expiry_listing
 */
class Events extends BaseController {
    
    public function index() {
        $this->requireAuth();
        $this->redirect('event_tracker');
    }
}

// Event Tracker controller (maps to /event_tracker)
class Event_tracker extends BaseController {
    public function index() {
        $this->requireAuth();
        
        $data = [
            'page_title' => 'Event Tracker',
            'events' => [],
            'companies' => [],
            'event_types' => ['AGM', 'AR', 'FYE', 'Anniversary', 'ID Expiry'],
        ];
        
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['companies'] = $this->db->fetchAll(
                    "SELECT id, company_name FROM companies WHERE client_id = ? ORDER BY company_name ASC",
                    [$client->id]
                );
                $data['events'] = $this->db->fetchAll(
                    "SELECT ce.*, c.company_name 
                     FROM company_events ce
                     JOIN companies c ON c.id = ce.company_id
                     WHERE c.client_id = ?
                     ORDER BY ce.fye_date DESC",
                    [$client->id]
                );
            }
        }
        
        $this->loadLayout('events/tracker', $data);
    }
}

// AGM Listing controller (maps to /agm_listing)
class Agm_listing extends BaseController {
    public function index() {
        $this->requireAuth();
        
        $data = [
            'page_title' => 'AGM Listing',
            'events' => [],
            'companies' => [],
        ];
        
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['companies'] = $this->db->fetchAll(
                    "SELECT id, company_name FROM companies WHERE client_id = ? ORDER BY company_name ASC",
                    [$client->id]
                );
                $data['events'] = $this->db->fetchAll(
                    "SELECT ce.*, c.company_name 
                     FROM company_events ce
                     JOIN companies c ON c.id = ce.company_id
                     WHERE c.client_id = ? AND ce.event_type = 'AGM'
                     ORDER BY ce.agm_due_date ASC",
                    [$client->id]
                );
            }
        }
        
        $this->loadLayout('events/agm', $data);
    }
}

// Annual Return Listing controller (maps to /ar_listing)
class Ar_listing extends BaseController {
    public function index() {
        $this->requireAuth();
        
        $data = [
            'page_title' => 'Annual Return Listing',
            'events' => [],
            'companies' => [],
        ];
        
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['companies'] = $this->db->fetchAll(
                    "SELECT id, company_name FROM companies WHERE client_id = ? ORDER BY company_name ASC",
                    [$client->id]
                );
                $data['events'] = $this->db->fetchAll(
                    "SELECT ce.*, c.company_name 
                     FROM company_events ce
                     JOIN companies c ON c.id = ce.company_id
                     WHERE c.client_id = ? AND ce.event_type = 'AR'
                     ORDER BY ce.ar_due_date ASC",
                    [$client->id]
                );
            }
        }
        
        $this->loadLayout('events/ar', $data);
    }
}

// Financial Year End Listing controller (maps to /fye_listing)
class Fye_listing extends BaseController {
    public function index() {
        $this->requireAuth();
        
        $data = [
            'page_title' => 'Financial Year End Listing',
            'events' => [],
            'companies' => [],
        ];
        
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['companies'] = $this->db->fetchAll(
                    "SELECT id, company_name FROM companies WHERE client_id = ? ORDER BY company_name ASC",
                    [$client->id]
                );
                $data['events'] = $this->db->fetchAll(
                    "SELECT ce.*, c.company_name 
                     FROM company_events ce
                     JOIN companies c ON c.id = ce.company_id
                     WHERE c.client_id = ?
                     ORDER BY ce.fye_date ASC",
                    [$client->id]
                );
            }
        }
        
        $this->loadLayout('events/fye', $data);
    }
}

// Anniversary Listing controller (maps to /anniversary_listing)
class Anniversary_listing extends BaseController {
    public function index() {
        $this->requireAuth();
        
        $data = [
            'page_title' => 'Company Anniversary Listing',
            'companies' => [],
            'anniversaries' => [],
        ];
        
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['companies'] = $this->db->fetchAll(
                    "SELECT id, company_name FROM companies WHERE client_id = ? ORDER BY company_name ASC",
                    [$client->id]
                );
                $data['anniversaries'] = $this->db->fetchAll(
                    "SELECT c.id, c.company_name, c.registration_number, c.incorporation_date, c.entity_status
                     FROM companies c
                     WHERE c.client_id = ? AND c.incorporation_date IS NOT NULL
                     ORDER BY c.incorporation_date ASC",
                    [$client->id]
                );
            }
        }
        
        $this->loadLayout('events/anniversary', $data);
    }
}

// Due Date Listing controller (maps to /due_listing)
class Due_listing extends BaseController {
    public function index() {
        $this->requireAuth();
        
        $data = [
            'page_title' => 'Upcoming Due Dates',
            'events' => [],
            'companies' => [],
        ];
        
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['companies'] = $this->db->fetchAll(
                    "SELECT id, company_name FROM companies WHERE client_id = ? ORDER BY company_name ASC",
                    [$client->id]
                );
                $data['events'] = $this->db->fetchAll(
                    "SELECT ce.*, c.company_name 
                     FROM company_events ce
                     JOIN companies c ON c.id = ce.company_id
                     WHERE c.client_id = ? 
                       AND (ce.agm_due_date >= CURDATE() OR ce.ar_due_date >= CURDATE())
                     ORDER BY LEAST(COALESCE(ce.agm_due_date, '9999-12-31'), COALESCE(ce.ar_due_date, '9999-12-31')) ASC",
                    [$client->id]
                );
            }
        }
        
        $this->loadLayout('events/due', $data);
    }
}

// ID Expiry Listing controller (maps to /id_expiry_listing)
class Id_expiry_listing extends BaseController {
    public function index() {
        $this->requireAuth();
        
        $data = [
            'page_title' => 'ID Document Expiry Listing',
            'members' => [],
            'companies' => [],
        ];
        
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['companies'] = $this->db->fetchAll(
                    "SELECT id, company_name FROM companies WHERE client_id = ? ORDER BY company_name ASC",
                    [$client->id]
                );
                $data['members'] = $this->db->fetchAll(
                    "SELECT m.*, mi.id_type, mi.id_number, mi.expired_date as id_expiry_date, 'Individual' as entity_type
                     FROM members m
                     INNER JOIN member_identifications mi ON mi.member_id = m.id
                     WHERE m.client_id = ? AND mi.expired_date IS NOT NULL
                     ORDER BY mi.expired_date ASC",
                    [$client->id]
                );
            }
        }
        
        $this->loadLayout('events/id_expiry', $data);
    }
}

// =========================================================================
// Per-Company AGM List (maps to /company_agm_list/{company_id})
// =========================================================================
class Company_agm_list extends BaseController {
    public function index($company_id = null) {
        $this->requireAuth();
        
        if (!$company_id) {
            $this->redirect('agm_listing');
            return;
        }
        
        $data = [
            'page_title' => 'Company AGM Events',
            'company' => null,
            'company_id' => $company_id,
            'events' => [],
        ];
        
        if ($this->db) {
            $data['company'] = $this->db->fetchOne("SELECT id, company_name, registration_number FROM companies WHERE id = ?", [$company_id]);
            if ($data['company']) {
                $data['page_title'] = 'AGM Events - ' . $data['company']->company_name;
                $data['events'] = $this->db->fetchAll(
                    "SELECT * FROM company_events WHERE company_id = ? ORDER BY fye_date DESC",
                    [$company_id]
                );
            }
        }
        
        $this->loadLayout('events/company_agm_list', $data);
    }
}

// =========================================================================
// Add AGM Event (maps to /add_agm/{company_id})
// =========================================================================
class Add_agm extends BaseController {
    public function index($company_id = null) {
        $this->requireAuth();
        
        if (!$company_id) {
            $this->redirect('agm_listing');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->store($company_id);
            return;
        }
        
        $data = [
            'page_title' => 'Add AGM Event',
            'company' => null,
            'company_id' => $company_id,
        ];
        
        if ($this->db) {
            $data['company'] = $this->db->fetchOne("SELECT id, company_name FROM companies WHERE id = ?", [$company_id]);
        }
        
        $this->loadLayout('events/add_agm', $data);
    }
    
    private function store($company_id) {
        if (!$this->validateCsrf()) {
            $this->setFlash('error', 'Invalid security token.');
            $this->redirect("add_agm/{$company_id}");
            return;
        }
        if (!$this->db) {
            $this->setFlash('error', 'Database not connected');
            $this->redirect("add_agm/{$company_id}");
            return;
        }
        
        $this->db->insert('company_events', [
            'company_id' => $company_id,
            'event_type' => 'AGM',
            'fye_date' => $this->parseDate($this->input('fye_date')),
            'agm_due_date' => $this->parseDate($this->input('agm_due_date')),
            'agm_held_date' => $this->parseDate($this->input('agm_held_date')),
            'agm_date' => $this->parseDate($this->input('agm_due_date')),
            'ar_date' => $this->parseDate($this->input('ar_date')),
            'ar_due_date' => $this->parseDate($this->input('ar_date')),
            'ar_filing_date' => $this->parseDate($this->input('ar_filing_date')),
            'next_due_date' => $this->parseDate($this->input('next_due_date')),
            'event_status' => $this->input('event_status', 'Pending'),
            'notes' => $this->input('notes', ''),
            'created_by' => $_SESSION['user_id'] ?? null,
        ]);
        
        $this->setFlash('success', 'AGM event added successfully.');
        $this->redirect("company_agm_list/{$company_id}");
    }
    
    private function parseDate($dateStr) {
        if (empty($dateStr)) return null;
        // Handle DD/MM/YYYY format
        $parts = explode('/', $dateStr);
        if (count($parts) === 3) {
            return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        return $dateStr ?: null;
    }
}

// =========================================================================
// Edit AGM Event (maps to /edit_agm/{event_id})
// =========================================================================
class Edit_agm extends BaseController {
    public function index($event_id = null) {
        $this->requireAuth();
        
        if (!$event_id) {
            $this->redirect('agm_listing');
            return;
        }
        
        $data = [
            'page_title' => 'Edit AGM Event',
            'event' => null,
            'company' => null,
        ];
        
        if ($this->db) {
            $data['event'] = $this->db->fetchOne("SELECT * FROM company_events WHERE id = ?", [$event_id]);
            if ($data['event']) {
                $data['company'] = $this->db->fetchOne("SELECT id, company_name FROM companies WHERE id = ?", [$data['event']->company_id]);
            }
        }
        
        if (!$data['event']) {
            $this->setFlash('error', 'AGM event not found.');
            $this->redirect('agm_listing');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->update($event_id, $data['event']->company_id);
            return;
        }
        
        $this->loadLayout('events/edit_agm', $data);
    }
    
    private function update($event_id, $company_id) {
        if (!$this->validateCsrf()) {
            $this->setFlash('error', 'Invalid security token.');
            $this->redirect("edit_agm/{$event_id}");
            return;
        }
        if (!$this->db) {
            $this->setFlash('error', 'Database not connected');
            $this->redirect("edit_agm/{$event_id}");
            return;
        }
        
        $this->db->update('company_events', [
            'fye_date' => $this->parseDate($this->input('fye_date')),
            'agm_due_date' => $this->parseDate($this->input('agm_due_date')),
            'agm_held_date' => $this->parseDate($this->input('agm_held_date')),
            'agm_date' => $this->parseDate($this->input('agm_due_date')),
            'ar_date' => $this->parseDate($this->input('ar_date')),
            'ar_due_date' => $this->parseDate($this->input('ar_date')),
            'ar_filing_date' => $this->parseDate($this->input('ar_filing_date')),
            'next_due_date' => $this->parseDate($this->input('next_due_date')),
            'event_status' => $this->input('event_status', 'Pending'),
            'notes' => $this->input('notes', ''),
        ], 'id = ?', [$event_id]);
        
        $this->setFlash('success', 'AGM event updated successfully.');
        $this->redirect("company_agm_list/{$company_id}");
    }
    
    private function parseDate($dateStr) {
        if (empty($dateStr)) return null;
        $parts = explode('/', $dateStr);
        if (count($parts) === 3) {
            return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        return $dateStr ?: null;
    }
}

// =========================================================================
// Multiple/Bulk Add AGM Events (maps to /multiple_add_agm)
// =========================================================================
class Multiple_add_agm extends BaseController {
    public function index() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->store();
            return;
        }
        
        $data = [
            'page_title' => 'Bulk Add AGM Events',
            'companies' => [],
        ];
        
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['companies'] = $this->db->fetchAll(
                    "SELECT id, company_name, registration_number FROM companies WHERE client_id = ? ORDER BY company_name ASC",
                    [$client->id]
                );
            }
        }
        
        $this->loadLayout('events/multiple_add_agm', $data);
    }
    
    private function store() {
        if (!$this->validateCsrf()) {
            $this->setFlash('error', 'Invalid security token.');
            $this->redirect('multiple_add_agm');
            return;
        }
        if (!$this->db) {
            $this->setFlash('error', 'Database not connected');
            $this->redirect('multiple_add_agm');
            return;
        }
        
        $companyIds = $_POST['company_ids'] ?? [];
        if (empty($companyIds)) {
            $this->setFlash('error', 'Please select at least one company.');
            $this->redirect('multiple_add_agm');
            return;
        }
        
        $count = 0;
        foreach ($companyIds as $companyId) {
            $this->db->insert('company_events', [
                'company_id' => $companyId,
                'event_type' => 'AGM',
                'fye_date' => $this->parseDate($this->input('fye_date')),
                'agm_due_date' => $this->parseDate($this->input('agm_due_date')),
                'agm_held_date' => $this->parseDate($this->input('agm_held_date')),
                'agm_date' => $this->parseDate($this->input('agm_due_date')),
                'ar_date' => $this->parseDate($this->input('ar_date')),
                'ar_due_date' => $this->parseDate($this->input('ar_date')),
                'ar_filing_date' => $this->parseDate($this->input('ar_filing_date')),
                'next_due_date' => $this->parseDate($this->input('next_due_date')),
                'event_status' => $this->input('event_status', 'Pending'),
                'notes' => $this->input('notes', ''),
                'created_by' => $_SESSION['user_id'] ?? null,
            ]);
            $count++;
        }
        
        $this->setFlash('success', "AGM events created for {$count} companies successfully.");
        $this->redirect('agm_listing');
    }
    
    private function parseDate($dateStr) {
        if (empty($dateStr)) return null;
        $parts = explode('/', $dateStr);
        if (count($parts) === 3) {
            return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        return $dateStr ?: null;
    }
}
