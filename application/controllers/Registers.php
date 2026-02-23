<?php
/**
 * Registers Controller - Statutory Registers
 * Handles: /registers, /register_directors, /register_shareholders, /register_secretaries
 */
class Registers extends BaseController {

    // Config: all register subtypes
    private $registerConfig = [
        'register_of_members' => [
            'title'   => 'Register of Members',
            'color'   => '#206570',
            'icon'    => 'fa-users',
            'columns' => ['Name', 'ID Type', 'ID Number', 'Nationality', 'Address', 'Status'],
        ],
        'register_of_directors' => [
            'title'   => 'Register of Directors',
            'color'   => '#337ab7',
            'icon'    => 'fa-user-secret',
            'columns' => ['Name', 'ID Number', 'Company', 'Date Appointed', 'Date Ceased', 'Status'],
        ],
        'register_of_secretaries' => [
            'title'   => 'Register of Secretaries',
            'color'   => '#26B99A',
            'icon'    => 'fa-user',
            'columns' => ['Name', 'ID Number', 'Company', 'Date Appointed', 'Date Ceased', 'Status'],
        ],
        'register_of_charges' => [
            'title'   => 'Register of Charges',
            'color'   => '#5cb85c',
            'icon'    => 'fa-link',
            'columns' => ['Company', 'Charge ID', 'Date Created', 'Amount', 'Chargee', 'Status'],
        ],
        'register_of_debenture_holders' => [
            'title'   => 'Register of Debenture Holders',
            'color'   => '#f27b53',
            'icon'    => 'fa-file-text',
            'columns' => ['Name', 'ID Number', 'Company', 'Debenture Type', 'Amount', 'Date'],
        ],
        'register_of_auditors' => [
            'title'   => 'Register of Auditors',
            'color'   => '#E74C3C',
            'icon'    => 'fa-shield',
            'columns' => ['Name', 'ID Number', 'Company', 'Date Appointed', 'Date Ceased', 'Status'],
        ],
        'register_of_nominee_directors' => [
            'title'   => 'Register of Nominee Directors',
            'color'   => '#f0ad4e',
            'icon'    => 'fa-user-plus',
            'columns' => ['Name', 'ID Number', 'Company', 'Nominator', 'Date Appointed', 'Status'],
        ],
        'register_of_substantial_shareholders' => [
            'title'   => 'Register of Substantial Shareholders',
            'color'   => '#9B59B6',
            'icon'    => 'fa-star',
            'columns' => ['Name', 'ID Number', 'Company', 'No. of Shares', '% Held', 'Date Notified'],
        ],
        'register_of_directors_shareholdings' => [
            'title'   => 'Register of Directors\' Shareholdings',
            'color'   => '#3498DB',
            'icon'    => 'fa-pie-chart',
            'columns' => ['Director Name', 'Company', 'No. of Shares', 'Share Class', '% Held', 'Date'],
        ],
        'register_of_transfers' => [
            'title'   => 'Register of Transfers',
            'color'   => '#1ABC9C',
            'icon'    => 'fa-exchange',
            'columns' => ['Company', 'Transferor', 'Transferee', 'No. of Shares', 'Date of Transfer', 'Consideration'],
        ],
        'register_of_allotments' => [
            'title'   => 'Register of Allotments',
            'color'   => '#2C3E50',
            'icon'    => 'fa-plus-circle',
            'columns' => ['Company', 'Allottee', 'No. of Shares', 'Share Class', 'Date Allotted', 'Amount Paid'],
        ],
        'register_of_seals' => [
            'title'   => 'Register of Seals',
            'color'   => '#8E44AD',
            'icon'    => 'fa-stamp',
            'columns' => ['Company', 'Document', 'Date', 'Authorised By', 'Witness', 'Remarks'],
        ],
        'register_of_applicants' => [
            'title'   => 'Register of Applicants',
            'color'   => '#D35400',
            'icon'    => 'fa-pencil-square-o',
            'columns' => ['Name', 'ID Number', 'Application Date', 'Company', 'Status', 'Remarks'],
        ],
        'register_of_controllers' => [
            'title'   => 'Register of Controllers',
            'color'   => '#27AE60',
            'icon'    => 'fa-cogs',
            'columns' => ['Name', 'ID Number', 'Company', 'Nature of Control', 'Date Notified', 'Status'],
        ],
        'register_of_beneficial_owners' => [
            'title'   => 'Register of Beneficial Owners',
            'color'   => '#C0392B',
            'icon'    => 'fa-eye',
            'columns' => ['Name', 'ID Number', 'Company', 'No. of Shares', 'Nature of Interest', 'Date'],
        ],
        'register_of_nominee_shareholders' => [
            'title'   => 'Register of Nominee Shareholders',
            'color'   => '#7F8C8D',
            'icon'    => 'fa-user-circle',
            'columns' => ['Nominee Name', 'Beneficial Owner', 'Company', 'No. of Shares', 'Date', 'Status'],
        ],
        'minute_book_directors' => [
            'title'   => 'Minute Book — Directors',
            'color'   => '#2980B9',
            'icon'    => 'fa-book',
            'columns' => ['Company', 'Meeting Date', 'Resolution', 'Attendees', 'Type', 'Remarks'],
        ],
        'minute_book_members' => [
            'title'   => 'Minute Book — Members',
            'color'   => '#16A085',
            'icon'    => 'fa-book',
            'columns' => ['Company', 'Meeting Date', 'Resolution', 'Attendees', 'Type', 'Remarks'],
        ],
        'share_certificate' => [
            'title'   => 'Share Certificate',
            'color'   => '#F39C12',
            'icon'    => 'fa-certificate',
            'columns' => ['Certificate No.', 'Company', 'Shareholder', 'Share Class', 'No. of Shares', 'Date Issued'],
        ],
        'annual_return' => [
            'title'   => 'Annual Return',
            'color'   => '#E67E22',
            'icon'    => 'fa-file',
            'columns' => ['Company', 'FYE Date', 'AR Due Date', 'AR Filed Date', 'Status', 'Remarks'],
        ],
        'register_of_depository_agents' => [
            'title'   => 'Register of Depository Agents',
            'color'   => '#E74C3C',
            'icon'    => 'fa-bank',
            'columns' => ['Name', 'ID Number', 'Company', 'Date Appointed', 'Date Ceased', 'Status'],
        ],
        'register_of_managers' => [
            'title'   => 'Register of Managers',
            'color'   => '#3498DB',
            'icon'    => 'fa-briefcase',
            'columns' => ['Name', 'ID Number', 'Company', 'Date Appointed', 'Date Ceased', 'Status'],
        ],
        'register_of_partners' => [
            'title'   => 'Register of Partners',
            'color'   => '#E91E63',
            'icon'    => 'fa-handshake-o',
            'columns' => ['Name', 'ID Number', 'Company', 'Partnership Share', 'Date Joined', 'Status'],
        ],
    ];

    public function index($type = null) {
        $this->requireAuth();

        // Sub-register page
        if ($type && isset($this->registerConfig[$type])) {
            $config = $this->registerConfig[$type];
            $records = $this->fetchRegisterData($type);

            $data = [
                'page_title' => $config['title'],
                'register_type' => $type,
                'config'     => $config,
                'records'    => $records,
            ];
            $this->loadLayout('registers/register', $data);
            return;
        }

        // Index page
        $data = ['page_title' => 'Registers'];
        $this->loadLayout('registers/index', $data);
    }

    private function fetchRegisterData($type) {
        if (!$this->db) return [];

        $clientId = $_SESSION['client_id'] ?? '';
        $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
        if (!$client) return [];
        $cid = $client->id;

        switch ($type) {
            case 'register_of_members':
                return $this->db->fetchAll(
                    "SELECT m.name,
                            MAX(mi.id_type) AS id_type,
                            MAX(mi.id_number) AS id_number,
                            m.nationality,
                            MAX(CONCAT_WS(' ', a.block, a.address_text, a.building)) AS address,
                            m.status
                     FROM members m
                     LEFT JOIN member_identifications mi ON mi.member_id = m.id
                     LEFT JOIN addresses a ON a.entity_type = 'member' AND a.entity_id = m.id AND a.is_default = 1
                     WHERE m.client_id = ?
                     GROUP BY m.id, m.name, m.nationality, m.status
                     ORDER BY m.name",
                    [$cid]
                );

            case 'register_of_directors':
            case 'register_of_secretaries':
            case 'register_of_auditors':
            case 'register_of_nominee_directors':
            case 'register_of_depository_agents':
            case 'register_of_managers':
                $typeMap = [
                    'register_of_directors'         => 'director',
                    'register_of_secretaries'       => 'secretary',
                    'register_of_auditors'          => 'auditor',
                    'register_of_nominee_directors' => 'nominee_director',
                    'register_of_depository_agents' => 'depository_agent',
                    'register_of_managers'          => 'manager',
                ];
                $officialType = $typeMap[$type];
                return $this->db->fetchAll(
                    "SELECT co.name, co.id_number, c.company_name,
                            co.date_of_appointment, co.date_of_cessation, co.status
                     FROM company_officials co
                     JOIN companies c ON c.id = co.company_id
                     WHERE c.client_id = ? AND co.official_type = ?
                     ORDER BY co.name",
                    [$cid, $officialType]
                );

            case 'register_of_seals':
                return $this->db->fetchAll(
                    "SELECT COALESCE(c.company_name, '') AS company_name,
                            s.document_description, s.seal_date,
                            s.sealed_by, '' AS witness, '' AS remarks
                     FROM sealings s
                     LEFT JOIN companies c ON c.id = s.company_id
                     WHERE s.client_id = ? ORDER BY s.seal_date DESC",
                    [$cid]
                );

            case 'annual_return':
                return $this->db->fetchAll(
                    "SELECT c.company_name, ce.fye_date, ce.agm_due_date,
                            ce.ar_filing_date, ce.agm_held_date, '' AS remarks
                     FROM companies c
                     LEFT JOIN company_events ce ON ce.company_id = c.id AND ce.event_type = 'AGM'
                     WHERE c.client_id = ?
                     ORDER BY c.company_name",
                    [$cid]
                );

            default:
                return [];
        }
    }
}

// Register of Directors (maps to /register_directors)
class Register_directors extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Register of Directors',
            'directors' => [],
        ];
        $this->loadLayout('registers/index', $data);
    }
}

// Register of Shareholders (maps to /register_shareholders)
class Register_shareholders extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Register of Shareholders',
            'shareholders' => [],
        ];
        $this->loadLayout('registers/index', $data);
    }
}

// Register of Secretaries (maps to /register_secretaries)
class Register_secretaries extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Register of Secretaries',
            'secretaries' => [],
        ];
        $this->loadLayout('registers/index', $data);
    }
}
