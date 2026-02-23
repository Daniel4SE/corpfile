<?php
/**
 * Dashboard Controller
 */
class Dashboard extends BaseController {
    
    public function index() {
        $this->requireAuth();
        
        $data = [
            'page_title' => 'Dashboard',
            'total_companies' => 0,
            'pre_incorp_count' => 0,
            'post_incorp_count' => 0,
            'non_client_count' => 0,
            'agm_alerts' => [],
            'ar_alerts' => [],
            'due_alerts' => [],
            'fye_alerts' => [],
            'incorp_alerts' => [],
            'anniversary_alerts' => [],
            'expiry_alerts' => [],
            'calendar_events' => [],
        ];
        
        // Client type filter mapping
        $clientTypeMap = [
            '1'  => 'is_css_client',
            '2'  => 'is_taxation_client',
            '6'  => 'is_accounting_client',
            '10' => 'is_audit_client',
            '12' => 'is_client',
        ];
        $clientTypeFilter = '';
        $filterTypes = isset($_GET['client_type']) ? explode(',', $_GET['client_type']) : [];
        if (!empty($filterTypes)) {
            $conditions = [];
            foreach ($filterTypes as $t) {
                $t = trim($t);
                if (isset($clientTypeMap[$t])) {
                    $conditions[] = $clientTypeMap[$t] . " = 1";
                }
            }
            if (!empty($conditions)) {
                $clientTypeFilter = ' AND (' . implode(' OR ', $conditions) . ')';
            }
        }

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);

            if ($client) {
                $cid = $client->id;

                // === Stat Tiles ===
                $data['total_companies'] = $this->db->count('companies', 'client_id = ?' . $clientTypeFilter, [$cid]);
                $data['pre_incorp_count'] = $this->db->count('companies', "client_id = ? AND internal_css_status = 'Pre-Incorporation'" . $clientTypeFilter, [$cid]);
                $data['post_incorp_count'] = $this->db->count('companies', "client_id = ? AND internal_css_status != 'Pre-Incorporation' AND (is_non_client = 0 OR is_non_client IS NULL)" . $clientTypeFilter, [$cid]);
                $data['non_client_count'] = $this->db->count('companies', "client_id = ? AND is_non_client = 1" . $clientTypeFilter, [$cid]);
                
                // === AGM Due Alerts — all pending (not held yet) ===
                $data['agm_alerts'] = $this->db->fetchAll(
                    "SELECT c.id, c.company_name, ce.agm_due_date, ce.agm_held_date, ce.fye_date
                     FROM companies c 
                     JOIN company_events ce ON ce.company_id = c.id AND ce.event_type = 'AGM'
                     WHERE c.client_id = ? AND ce.agm_due_date IS NOT NULL AND ce.agm_held_date IS NULL
                     ORDER BY ce.agm_due_date ASC LIMIT 100",
                    [$cid]
                );

                // === AR Due Alerts — all pending (not filed yet) ===
                $data['ar_alerts'] = $this->db->fetchAll(
                    "SELECT c.id, c.company_name, ce.ar_due_date, ce.ar_filing_date
                     FROM companies c 
                     JOIN company_events ce ON ce.company_id = c.id AND ce.event_type = 'AGM'
                     WHERE c.client_id = ? AND ce.ar_due_date IS NOT NULL AND ce.ar_filing_date IS NULL
                     ORDER BY ce.ar_due_date ASC LIMIT 100",
                    [$cid]
                );

                // === Due Date Alerts — pending due events (non-AGM/AR) ===
                $data['due_alerts'] = $this->db->fetchAll(
                    "SELECT d.id, d.company_name, d.company_id, d.event_name, d.due_date, d.status
                     FROM due_dates d
                     WHERE d.client_id = ? AND d.status != 'Completed'
                       AND d.event_name NOT IN ('AGM', 'AR')
                     ORDER BY d.due_date ASC LIMIT 100",
                    [$cid]
                );

                // === FYE Date Not Entered (only post-incorp, non-client excluded) ===
                $data['fye_alerts'] = $this->db->fetchAll(
                    "SELECT c.id, c.company_name
                     FROM companies c
                     WHERE c.client_id = ? AND c.fye_date IS NULL 
                       AND c.internal_css_status = 'Post-Incorporation' AND (c.is_non_client = 0 OR c.is_non_client IS NULL)
                     ORDER BY c.company_name ASC",
                    [$cid]
                );

                // === Incorporation Date Not Entered (only post-incorp with registration, non-client excluded) ===
                $data['incorp_alerts'] = $this->db->fetchAll(
                    "SELECT c.id, c.company_name
                     FROM companies c
                     WHERE c.client_id = ? AND c.incorporation_date IS NULL 
                       AND c.internal_css_status = 'Pre-Incorporation'
                     ORDER BY c.company_name ASC",
                    [$cid]
                );

                // === Anniversary Due Alerts (companies with incorporation_date) ===
                $data['anniversary_alerts'] = $this->db->fetchAll(
                    "SELECT c.id, c.company_name, c.incorporation_date,
                            CONCAT(YEAR(CURDATE()) - YEAR(c.incorporation_date), ' years') as years_since
                     FROM companies c
                     WHERE c.client_id = ? AND c.incorporation_date IS NOT NULL
                       AND MONTH(c.incorporation_date) = MONTH(CURDATE())
                     ORDER BY c.company_name ASC LIMIT 50",
                    [$cid]
                );

                // === ID Expiry Alerts ===
                $data['expiry_alerts'] = $this->db->fetchAll(
                    "SELECT m.id, m.name, mi.id_type, mi.expired_date
                     FROM members m
                     INNER JOIN member_identifications mi ON mi.member_id = m.id
                     WHERE m.client_id = ? AND mi.expired_date IS NOT NULL
                       AND mi.expired_date <= DATE_ADD(CURDATE(), INTERVAL 3 MONTH)
                     ORDER BY mi.expired_date ASC LIMIT 50",
                    [$cid]
                );

                // Calendar events
                $data['calendar_events'] = $this->db->fetchAll(
                    "SELECT ce.*, c.company_name 
                     FROM company_events ce
                     JOIN companies c ON c.id = ce.company_id
                     WHERE c.client_id = ?
                     ORDER BY ce.agm_due_date DESC LIMIT 100",
                    [$cid]
                );
            }
        } else {
            // Demo mode
            $data['total_companies'] = 299;
            $data['pre_incorp_count'] = 10;
            $data['post_incorp_count'] = 187;
            $data['non_client_count'] = 102;
        }
        
        $this->loadLayout('dashboard/index', $data);
    }
    
    // AJAX endpoints for dashboard alert panels
    public function agm_listbox() {
        $this->requireAuth();
        $this->json(['status' => 'ok', 'data' => []]);
    }
    
    public function ar_listbox() {
        $this->requireAuth();
        $this->json(['status' => 'ok', 'data' => []]);
    }
    
    public function due_listbox() {
        $this->requireAuth();
        $this->json(['status' => 'ok', 'data' => []]);
    }
}
