<?php
/**
 * Shares Controller - Share Management
 * Handles: /shares, /discrepancy_company
 */
class Shares extends BaseController {
    
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Share Management',
            'shares' => [],
        ];
        $this->loadLayout('shares/index', $data);
    }
}

// Share Discrepancy Company (maps to /discrepancy_company)
class Discrepancy_company extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Share Discrepancies',
            'companies' => [],
        ];
        
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['companies'] = $this->db->fetchAll(
                    "SELECT c.id, c.company_name, c.registration_number,
                            c.ord_issued_share_capital, c.no_ord_shares, c.ord_currency,
                            c.paid_up_capital, c.entity_status,
                            COALESCE(SUM(cs.number_of_shares), 0) as total_shareholder_shares
                     FROM companies c
                     LEFT JOIN company_shares cs ON cs.company_id = c.id AND cs.type = 'Allotment'
                     WHERE c.client_id = ?
                     GROUP BY c.id
                     HAVING c.no_ord_shares != total_shareholder_shares OR total_shareholder_shares = 0
                     ORDER BY c.company_name ASC",
                    [$client->id]
                );
            }
        }
        
        $this->loadLayout('shares/discrepancy', $data);
    }
}

// =========================================================================
// Company Share Level Detail (maps to /company_share_level/{company_id})
// =========================================================================
class Company_share_level extends BaseController {
    public function index($company_id = null) {
        $this->requireAuth();
        
        if (!$company_id) {
            $this->redirect('company_list');
            return;
        }
        
        $data = [
            'page_title' => 'Company Shares',
            'company' => null,
            'company_id' => $company_id,
            'shareholders' => [],
            'allotments' => [],
            'transfers' => [],
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
                $data['page_title'] = 'Shares - ' . $data['company']->company_name;
                $data['shareholders'] = $this->db->fetchAll(
                    "SELECT * FROM shareholders WHERE company_id = ? ORDER BY status DESC, name ASC",
                    [$company_id]
                );
                $data['allotments'] = $this->db->fetchAll(
                    "SELECT cs.*, s.name as shareholder_name 
                     FROM company_shares cs 
                     LEFT JOIN shareholders s ON s.id = cs.shareholder_id
                     WHERE cs.company_id = ? AND cs.type = 'Allotment' 
                     ORDER BY cs.transaction_date DESC",
                    [$company_id]
                ) ?: [];
                $data['transfers'] = $this->db->fetchAll(
                    "SELECT cs.*, s.name as shareholder_name 
                     FROM company_shares cs 
                     LEFT JOIN shareholders s ON s.id = cs.shareholder_id
                     WHERE cs.company_id = ? AND cs.type = 'Transfer' 
                     ORDER BY cs.transaction_date DESC",
                    [$company_id]
                ) ?: [];
            }
        }
        
        $this->loadLayout('shares/company_shares', $data);
    }
}

// =========================================================================
// Partial/Full Paid Discrepancy (maps to /partial_full_paid_discrepancy_company)
// =========================================================================
class Partial_full_paid_discrepancy_company extends BaseController {
    public function index() {
        $this->requireAuth();
        
        $data = [
            'page_title' => 'Partial/Full Paid Share Discrepancies',
            'companies' => [],
        ];
        
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['companies'] = $this->db->fetchAll(
                    "SELECT c.id, c.company_name, c.registration_number,
                            c.ord_issued_share_capital, c.no_ord_shares, c.ord_currency,
                            c.paid_up_capital, c.entity_status
                     FROM companies c
                     WHERE c.client_id = ? 
                       AND c.paid_up_capital IS NOT NULL 
                       AND c.ord_issued_share_capital IS NOT NULL
                       AND c.paid_up_capital != c.ord_issued_share_capital
                     ORDER BY c.company_name ASC",
                    [$client->id]
                );
            }
        }
        
        $this->loadLayout('shares/partial_discrepancy', $data);
    }
}
