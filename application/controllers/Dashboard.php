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
                $data['total_companies'] = $this->db->count('companies', 'client_id = ?' . $clientTypeFilter, [$cid]);
                $data['pre_incorp_count'] = $this->db->count('companies', "client_id = ? AND internal_css_status = 'Pre-Incorporation'" . $clientTypeFilter, [$cid]);
                $data['post_incorp_count'] = $this->db->count('companies', "client_id = ? AND internal_css_status != 'Pre-Incorporation' AND (is_non_client = 0 OR is_non_client IS NULL)" . $clientTypeFilter, [$cid]);
                $data['non_client_count'] = $this->db->count('companies', "client_id = ? AND is_non_client = 1" . $clientTypeFilter, [$cid]);
                
                // AGM alerts - companies where AGM due date is approaching
                $data['agm_alerts'] = $this->db->fetchAll(
                    "SELECT c.id, c.company_name, ce.agm_due_date, ce.agm_held_date, ce.fye_date, ce.ar_filing_date 
                     FROM companies c 
                     LEFT JOIN company_events ce ON ce.company_id = c.id AND ce.event_type = 'AGM'
                     WHERE c.client_id = ? AND ce.agm_due_date IS NOT NULL
                     ORDER BY ce.agm_due_date ASC LIMIT 50",
                    [$cid]
                );
                
                // Calendar events
                $data['calendar_events'] = $this->db->fetchAll(
                    "SELECT ce.*, c.company_name 
                     FROM company_events ce
                     JOIN companies c ON c.id = ce.company_id
                     WHERE c.client_id = ?
                     ORDER BY ce.event_date DESC LIMIT 100",
                    [$cid]
                );
            }
        } else {
            // Demo mode - fake data
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
