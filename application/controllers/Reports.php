<?php
/**
 * Reports Controller - Report Module
 * Handles: /reports, /css_reports, /crm_reports, /report_view
 */
class Reports extends BaseController {
    
    public function index() {
        $this->requireAuth();
        $data = ['page_title' => 'Reports'];
        $this->loadLayout('reports/index', $data);
    }
}

// CSS Reports (maps to /css_reports)
class Css_reports extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = ['page_title' => 'CSS Reports'];
        $this->loadLayout('reports/css_reports', $data);
    }
}

// CRM Reports (maps to /crm_reports)
class Crm_reports extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = ['page_title' => 'CRM Reports'];
        $this->loadLayout('reports/crm_reports', $data);
    }
}

/**
 * Report_view - Generic Report Viewer
 * A single controller that serves ALL 87+ report types by accepting a report_type parameter
 * and loading the appropriate column configuration.
 *
 * Routes: /report_view/{report_type}
 * Example: /report_view/register_of_owner
 */
class Report_view extends BaseController {

    /**
     * Complete report configurations for all 87 report types.
     * Each entry defines the title and column headers for the DataTable.
     */
    private $reportConfigs = [

        // ─── CSS Register Reports (24) ────────────────────────────────────

        'register_of_owner' => [
            'title'   => 'Register of Owners',
            'columns' => ['S/No', 'Company Name', 'Owner Name', 'ID Type', 'ID No', 'Nationality', 'Address', 'Date of Appointment', 'Status'],
        ],
        'register_of_member' => [
            'title'   => 'Register of Members',
            'columns' => ['S/No', 'Company Name', 'Member Name', 'Share Type', 'No. of Shares', 'Date'],
        ],
        'register_of_directors_shareholding' => [
            'title'   => 'Register of Directors Shareholding',
            'columns' => ['S/No', 'Company Name', 'Director Name', 'Share Type', 'No. of Shares', 'Date of Change', 'Consideration', 'Remarks'],
        ],
        'register_of_director' => [
            'title'   => 'Register of Directors',
            'columns' => ['S/No', 'Company Name', 'Director Name', 'ID Type', 'ID No', 'Nationality', 'Local Address', 'Date of Appointment', 'Date of Cessation', 'Status'],
        ],
        'register_of_controllers' => [
            'title'   => 'Register of Controllers',
            'columns' => ['S/No', 'Company Name', 'Controller Name', 'ID Type', 'ID No', 'Nationality', 'Address', 'Date of Entry', 'Status'],
        ],
        'register_of_ceo_shareholding' => [
            'title'   => 'Register of CEO Shareholding',
            'columns' => ['S/No', 'Company Name', 'CEO Name', 'Share Type', 'No. of Shares', 'Date of Change', 'Consideration', 'Remarks'],
        ],
        'register_of_ceo' => [
            'title'   => 'Register of CEO',
            'columns' => ['S/No', 'Company Name', 'CEO Name', 'ID Type', 'ID No', 'Nationality', 'Address', 'Date of Appointment', 'Date of Cessation', 'Status'],
        ],
        'register_of_nominee' => [
            'title'   => 'Register of Nominees',
            'columns' => ['S/No', 'Company Name', 'Nominee Name', 'ID Type', 'ID No', 'Nationality', 'Address', 'Date of Appointment', 'Status'],
        ],
        'register_of_secretaries' => [
            'title'   => 'Register of Secretaries',
            'columns' => ['S/No', 'Company Name', 'Secretary Name', 'ID Type', 'ID No', 'Address', 'Date of Appointment', 'Date of Cessation', 'Status'],
        ],
        'register_of_auditors' => [
            'title'   => 'Register of Auditors',
            'columns' => ['S/No', 'Company Name', 'Auditor Name', 'Firm Name', 'Address', 'Date of Appointment', 'Date of Cessation', 'Status'],
        ],
        'register_of_managers' => [
            'title'   => 'Register of Managers',
            'columns' => ['S/No', 'Company Name', 'Manager Name', 'ID Type', 'ID No', 'Nationality', 'Address', 'Date of Appointment', 'Date of Cessation', 'Status'],
        ],
        'register_of_shares_allotment' => [
            'title'   => 'Register of Shares Allotment',
            'columns' => ['S/No', 'Company Name', 'Allottee Name', 'Share Type', 'No. of Shares', 'Amount Paid', 'Date of Allotment', 'Remarks'],
        ],
        'register_of_fund_manager' => [
            'title'   => 'Register of Fund Managers',
            'columns' => ['S/No', 'Company Name', 'Fund Manager Name', 'License No', 'Address', 'Date of Appointment', 'Date of Cessation', 'Status'],
        ],
        'register_of_data_protection' => [
            'title'   => 'Register of Data Protection Officers',
            'columns' => ['S/No', 'Company Name', 'DPO Name', 'Email', 'Contact No', 'Date of Appointment', 'Date of Cessation', 'Status'],
        ],
        'register_of_nominee_member' => [
            'title'   => 'Register of Nominee Members',
            'columns' => ['S/No', 'Company Name', 'Nominee Name', 'Beneficial Owner', 'Share Type', 'No. of Shares', 'Date', 'Status'],
        ],
        'register_of_shares_transfers' => [
            'title'   => 'Register of Shares Transfers',
            'columns' => ['S/No', 'Company Name', 'Transferor', 'Transferee', 'Share Type', 'No. of Shares', 'Consideration', 'Date of Transfer'],
        ],
        'register_of_shares_allotment_transaction_date' => [
            'title'   => 'Register of Shares Allotment by Transaction Date',
            'columns' => ['S/No', 'Company Name', 'Transaction Date', 'Allottee Name', 'Share Type', 'No. of Shares', 'Amount Paid', 'Remarks'],
        ],
        'register_of_charges' => [
            'title'   => 'Register of Charges',
            'columns' => ['S/No', 'Company Name', 'Charge Description', 'Chargee', 'Amount Secured', 'Date of Creation', 'Date of Satisfaction', 'Status'],
        ],
        'register_of_sealings' => [
            'title'   => 'Register of Sealings',
            'columns' => ['S/No', 'Company Name', 'Document Description', 'Seal Type', 'Authorized By', 'Date of Sealing', 'Remarks'],
        ],
        'register_of_representative' => [
            'title'   => 'Register of Representatives',
            'columns' => ['S/No', 'Company Name', 'Representative Name', 'ID Type', 'ID No', 'Nationality', 'Address', 'Date of Appointment', 'Status'],
        ],
        'register_of_nominee_trustee' => [
            'title'   => 'Register of Nominee Trustees',
            'columns' => ['S/No', 'Company Name', 'Trustee Name', 'ID Type', 'ID No', 'Address', 'Date of Appointment', 'Date of Cessation', 'Status'],
        ],
        'register_of_agent' => [
            'title'   => 'Register of Agents',
            'columns' => ['S/No', 'Company Name', 'Agent Name', 'License No', 'Address', 'Date of Appointment', 'Date of Cessation', 'Status'],
        ],
        'register_of_shareholder_nominee' => [
            'title'   => 'Register of Shareholder Nominees',
            'columns' => ['S/No', 'Company Name', 'Nominee Name', 'Beneficial Owner', 'Share Type', 'No. of Shares', 'Date of Appointment', 'Status'],
        ],
        'register_of_controllers_report' => [
            'title'   => 'Controllers Report',
            'columns' => ['S/No', 'Company Name', 'Controller Name', 'Controller Type', 'ID No', 'Nationality', 'Date of Entry', 'Date of Cessation', 'Status'],
        ],

        // ─── CSS General Reports (33) ──────────────────────────────────────

        'all_document' => [
            'title'   => 'All Documents Report',
            'columns' => ['S/No', 'Company Name', 'Document Name', 'Category', 'Uploaded By', 'Upload Date', 'File Size'],
        ],
        'company_hierarchy' => [
            'title'   => 'Company Hierarchy Report',
            'columns' => ['S/No', 'Parent Company', 'Subsidiary', 'Ownership %', 'Level', 'Country', 'Status'],
        ],
        'comp_director_report' => [
            'title'   => 'Company Director Report',
            'columns' => ['S/No', 'Company Name', 'UEN', 'Director Name', 'ID No', 'Nationality', 'Date of Appointment', 'Date of Cessation', 'Status'],
        ],
        'individual_report' => [
            'title'   => 'Individual Report',
            'columns' => ['S/No', 'Individual Name', 'ID Type', 'ID No', 'Nationality', 'Address', 'Companies Associated', 'Roles'],
        ],
        'official_contact_address' => [
            'title'   => 'Official Contact Address Report',
            'columns' => ['S/No', 'Company Name', 'UEN', 'Contact Person', 'Address', 'Phone', 'Email', 'Status'],
        ],
        'user_management' => [
            'title'   => 'User Management Report',
            'columns' => ['S/No', 'User Name', 'Email', 'Role', 'Last Login', 'Companies Assigned', 'Status'],
        ],
        'change_of_company_name' => [
            'title'   => 'Change of Company Name Report',
            'columns' => ['S/No', 'Company Name', 'UEN', 'Previous Name', 'New Name', 'Effective Date', 'Filed By'],
        ],
        'user_log_report' => [
            'title'   => 'User Log Report',
            'columns' => ['S/No', 'User Name', 'Action', 'Module', 'Details', 'IP Address', 'Date/Time'],
        ],
        'registered_office_default' => [
            'title'   => 'Registered Office Default Report',
            'columns' => ['S/No', 'Company Name', 'UEN', 'Registered Address', 'Effective Date', 'Status'],
        ],
        'event_specific' => [
            'title'   => 'Event Specific Report',
            'columns' => ['S/No', 'Company Name', 'Event Type', 'Event Name', 'Due Date', 'Completed Date', 'Status'],
        ],
        'agm_overdue' => [
            'title'   => 'AGM Overdue Report',
            'columns' => ['S/No', 'Company Name', 'UEN', 'Last AGM Date', 'AGM Due Date', 'Days Overdue', 'Status'],
        ],
        'comp_secretary_default' => [
            'title'   => 'Company Secretary Default Report',
            'columns' => ['S/No', 'Company Name', 'UEN', 'Secretary Name', 'Date of Appointment', 'Status'],
        ],
        'key_dates' => [
            'title'   => 'Key Dates Report',
            'columns' => ['S/No', 'Company Name', 'Incorporation Date', 'FYE', 'Last AGM', 'Next AGM Due', 'Last AR Filed', 'Next AR Due'],
        ],
        'id_expiry_date' => [
            'title'   => 'ID Expiry Date Report',
            'columns' => ['S/No', 'Individual Name', 'ID Type', 'ID No', 'Expiry Date', 'Days to Expiry', 'Companies Associated', 'Status'],
        ],
        'remindersendout' => [
            'title'   => 'Reminder Send Out Report',
            'columns' => ['S/No', 'Company Name', 'Reminder Type', 'Recipient', 'Email', 'Sent Date', 'Status'],
        ],
        'company_fees' => [
            'title'   => 'Company Fees Report',
            'columns' => ['S/No', 'Company Name', 'UEN', 'Fee Type', 'Amount', 'Due Date', 'Payment Date', 'Status'],
        ],
        'comp_contact_default' => [
            'title'   => 'Company Contact Default Report',
            'columns' => ['S/No', 'Company Name', 'Contact Person', 'Designation', 'Phone', 'Email', 'Status'],
        ],
        'comp_auditor_default' => [
            'title'   => 'Company Auditor Default Report',
            'columns' => ['S/No', 'Company Name', 'UEN', 'Auditor Name', 'Firm', 'Date of Appointment', 'Status'],
        ],
        'email_template' => [
            'title'   => 'Email Template Report',
            'columns' => ['S/No', 'Template Name', 'Subject', 'Category', 'Created By', 'Created Date', 'Status'],
        ],
        'comp_client_default' => [
            'title'   => 'Company Client Default Report',
            'columns' => ['S/No', 'Company Name', 'UEN', 'Client Group', 'Primary Contact', 'Email', 'Status'],
        ],
        'comp_manager_default' => [
            'title'   => 'Company Manager Default Report',
            'columns' => ['S/No', 'Company Name', 'UEN', 'Manager Name', 'Date of Appointment', 'Status'],
        ],
        'all_register_download' => [
            'title'   => 'All Register Download Report',
            'columns' => ['S/No', 'Company Name', 'Register Type', 'Total Records', 'Last Updated', 'Download'],
        ],
        'company_event' => [
            'title'   => 'Company Event Report',
            'columns' => ['S/No', 'Company Name', 'Event Type', 'Event Name', 'Event Date', 'Assignee', 'Status'],
        ],
        'default_ceo' => [
            'title'   => 'Default CEO Report',
            'columns' => ['S/No', 'Company Name', 'UEN', 'CEO Name', 'ID No', 'Date of Appointment', 'Status'],
        ],
        'default_chair_person' => [
            'title'   => 'Default Chair Person Report',
            'columns' => ['S/No', 'Company Name', 'UEN', 'Chair Person Name', 'ID No', 'Date of Appointment', 'Status'],
        ],
        'default_data_protection' => [
            'title'   => 'Default Data Protection Officer Report',
            'columns' => ['S/No', 'Company Name', 'UEN', 'DPO Name', 'Email', 'Date of Appointment', 'Status'],
        ],
        'default_nominee_trustee' => [
            'title'   => 'Default Nominee Trustee Report',
            'columns' => ['S/No', 'Company Name', 'UEN', 'Trustee Name', 'ID No', 'Date of Appointment', 'Status'],
        ],
        'remainder_upcoming_event' => [
            'title'   => 'Reminder Upcoming Event Report',
            'columns' => ['S/No', 'Company Name', 'Event Type', 'Event Name', 'Due Date', 'Days Remaining', 'Assignee', 'Status'],
        ],
        'default_fund_manager' => [
            'title'   => 'Default Fund Manager Report',
            'columns' => ['S/No', 'Company Name', 'UEN', 'Fund Manager Name', 'License No', 'Date of Appointment', 'Status'],
        ],
        'default_shareholder' => [
            'title'   => 'Default Shareholder Report',
            'columns' => ['S/No', 'Company Name', 'UEN', 'Shareholder Name', 'Share Type', 'No. of Shares', 'Percentage', 'Status'],
        ],
        'default_company_controllers' => [
            'title'   => 'Default Company Controllers Report',
            'columns' => ['S/No', 'Company Name', 'UEN', 'Controller Name', 'Controller Type', 'ID No', 'Date of Entry', 'Status'],
        ],
        'official_local_alternate_address' => [
            'title'   => 'Official Local Alternate Address Report',
            'columns' => ['S/No', 'Company Name', 'UEN', 'Primary Address', 'Alternate Address', 'Effective Date', 'Status'],
        ],
        'acra_companies_search' => [
            'title'   => 'ACRA Companies Search Report',
            'columns' => ['S/No', 'Company Name', 'UEN', 'Status', 'Incorporation Date', 'Company Type', 'Principal Activity'],
        ],

        // ─── CRM Reports (30) ─────────────────────────────────────────────

        'crm_default' => [
            'title'   => 'CRM Default Report',
            'columns' => ['S/No', 'Client Name', 'Contact Person', 'Email', 'Phone', 'Industry', 'Status'],
        ],
        'crm_task' => [
            'title'   => 'CRM Task Report',
            'columns' => ['S/No', 'Task Name', 'Project', 'Assigned To', 'Priority', 'Due Date', 'Status'],
        ],
        'crm_invoice' => [
            'title'   => 'CRM Invoice Report',
            'columns' => ['S/No', 'Invoice No', 'Client Name', 'Invoice Date', 'Due Date', 'Amount', 'Paid', 'Balance', 'Status'],
        ],
        'crm_projects' => [
            'title'   => 'CRM Projects Report',
            'columns' => ['S/No', 'Project Name', 'Client', 'Start Date', 'End Date', 'Budget', 'Progress %', 'Status'],
        ],
        'crm_activities' => [
            'title'   => 'CRM Activities Report',
            'columns' => ['S/No', 'Activity Type', 'Subject', 'Related To', 'Assigned To', 'Date', 'Duration', 'Status'],
        ],
        'crm_sales_order' => [
            'title'   => 'CRM Sales Order Report',
            'columns' => ['S/No', 'SO No', 'Client Name', 'Order Date', 'Delivery Date', 'Amount', 'Status'],
        ],
        'crm_lead' => [
            'title'   => 'CRM Lead Report',
            'columns' => ['S/No', 'Lead Name', 'Company', 'Email', 'Phone', 'Source', 'Rating', 'Assigned To', 'Status'],
        ],
        'company_fee' => [
            'title'   => 'Company Fee Report',
            'columns' => ['S/No', 'Company Name', 'Fee Type', 'Description', 'Amount', 'Due Date', 'Payment Date', 'Status'],
        ],
        'quotations' => [
            'title'   => 'Quotations Report',
            'columns' => ['S/No', 'Quotation No', 'Client Name', 'Date', 'Valid Until', 'Amount', 'Status'],
        ],
        'activity' => [
            'title'   => 'Activity Report',
            'columns' => ['S/No', 'Activity Type', 'Subject', 'Related To', 'Assigned To', 'Date', 'Status'],
        ],
        'task_summary' => [
            'title'   => 'Task Summary Report',
            'columns' => ['S/No', 'Project', 'Total Tasks', 'Completed', 'In Progress', 'Overdue', 'Completion %'],
        ],
        'tasks' => [
            'title'   => 'Tasks Report',
            'columns' => ['S/No', 'Task Name', 'Project', 'Assigned To', 'Start Date', 'Due Date', 'Priority', 'Status'],
        ],
        'task_wo_activity' => [
            'title'   => 'Tasks Without Activity Report',
            'columns' => ['S/No', 'Task Name', 'Project', 'Assigned To', 'Created Date', 'Due Date', 'Days Inactive', 'Status'],
        ],
        'ad_hoc_fee' => [
            'title'   => 'Ad Hoc Fee Report',
            'columns' => ['S/No', 'Company Name', 'Fee Description', 'Amount', 'Created Date', 'Due Date', 'Status'],
        ],
        'credit_note' => [
            'title'   => 'Credit Note Report',
            'columns' => ['S/No', 'Credit Note No', 'Client Name', 'Invoice Ref', 'Date', 'Amount', 'Reason', 'Status'],
        ],
        'invoice_agent' => [
            'title'   => 'Invoice Agent Report',
            'columns' => ['S/No', 'Agent Name', 'Invoice No', 'Client Name', 'Amount', 'Commission', 'Date', 'Status'],
        ],
        'invoice_payment' => [
            'title'   => 'Invoice Payment Report',
            'columns' => ['S/No', 'Invoice No', 'Client Name', 'Payment Date', 'Payment Mode', 'Amount', 'Reference', 'Status'],
        ],
        'invoice_new' => [
            'title'   => 'New Invoice Report',
            'columns' => ['S/No', 'Invoice No', 'Client Name', 'Invoice Date', 'Due Date', 'Amount', 'Status'],
        ],
        'invoice_service' => [
            'title'   => 'Invoice Service Report',
            'columns' => ['S/No', 'Invoice No', 'Client Name', 'Service', 'Quantity', 'Unit Price', 'Amount', 'Date'],
        ],
        'revenue_by_product_service' => [
            'title'   => 'Revenue by Product/Service Report',
            'columns' => ['S/No', 'Product/Service', 'Category', 'Total Invoiced', 'Total Collected', 'Outstanding', 'Count'],
        ],
        'statement_of_accounts' => [
            'title'   => 'Statement of Accounts',
            'columns' => ['S/No', 'Date', 'Reference', 'Description', 'Debit', 'Credit', 'Balance'],
        ],
        'custom_statement_of_accounts' => [
            'title'   => 'Custom Statement of Accounts',
            'columns' => ['S/No', 'Client Name', 'Date', 'Reference', 'Description', 'Debit', 'Credit', 'Balance'],
        ],
        'project_no_task' => [
            'title'   => 'Projects Without Tasks Report',
            'columns' => ['S/No', 'Project Name', 'Client', 'Start Date', 'End Date', 'Manager', 'Status'],
        ],
        'project_payment' => [
            'title'   => 'Project Payment Report',
            'columns' => ['S/No', 'Project Name', 'Client', 'Total Budget', 'Invoiced', 'Paid', 'Outstanding', 'Status'],
        ],
        'project_revenue' => [
            'title'   => 'Project Revenue Report',
            'columns' => ['S/No', 'Project Name', 'Client', 'Budget', 'Revenue', 'Cost', 'Profit', 'Margin %'],
        ],
        'project_summary' => [
            'title'   => 'Project Summary Report',
            'columns' => ['S/No', 'Project Name', 'Client', 'Start Date', 'End Date', 'Tasks', 'Progress %', 'Status'],
        ],
        'project_working_hours' => [
            'title'   => 'Project Working Hours Report',
            'columns' => ['S/No', 'Project Name', 'Team Member', 'Estimated Hours', 'Actual Hours', 'Variance', 'Period'],
        ],
        'working_hrs' => [
            'title'   => 'Working Hours Report',
            'columns' => ['S/No', 'Employee Name', 'Project', 'Task', 'Date', 'Hours', 'Billable', 'Status'],
        ],
        'soreport' => [
            'title'   => 'Sales Order Summary Report',
            'columns' => ['S/No', 'SO No', 'Client Name', 'Order Date', 'Items', 'Total Amount', 'Delivered', 'Status'],
        ],
        'lead_report' => [
            'title'   => 'Lead Analysis Report',
            'columns' => ['S/No', 'Lead Name', 'Company', 'Source', 'Rating', 'Assigned To', 'Created Date', 'Converted Date', 'Status'],
        ],
    ];

    /**
     * Main entry point: /report_view/{report_type}
     */
    public function index($report_type = null) {
        $this->requireAuth();

        // Validate report type
        if (!$report_type || !isset($this->reportConfigs[$report_type])) {
            $this->setFlash('error', 'Invalid report type specified.');
            $this->redirect('reports');
            return;
        }

        $config = $this->reportConfigs[$report_type];

        // Fetch report data if filters are applied
        $report_data = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || !empty($_GET['generate'])) {
            $report_data = $this->fetchReportData($report_type);
        }

        $data = [
            'page_title'    => $config['title'],
            'report_type'   => $report_type,
            'report_config' => $config,
            'report_data'   => $report_data,
            'filters'       => [
                'company'   => $this->input('filter_company', ''),
                'date_from' => $this->input('date_from', ''),
                'date_to'   => $this->input('date_to', ''),
                'status'    => $this->input('filter_status', ''),
            ],
            'companies'     => $this->getCompanyList(),
        ];

        $this->loadLayout('reports/report_template', $data);
    }

    /**
     * AJAX endpoint for DataTable server-side data (optional)
     */
    public function ajax_data($report_type = null) {
        $this->requireAuth();

        if (!$report_type || !isset($this->reportConfigs[$report_type])) {
            $this->json(['error' => 'Invalid report type'], 400);
            return;
        }

        $data = $this->fetchReportData($report_type);
        $this->json(['data' => $data]);
    }

    /**
     * Fetch report data from database based on report type and filters.
     * Returns an array of row arrays matching the column order in reportConfigs.
     */
    private function fetchReportData($report_type) {
        if (!$this->db) return [];

        $clientId = $_SESSION['client_id'] ?? '';
        $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
        if (!$client) return [];

        $cid = $client->id;
        $company  = $this->input('filter_company', '');
        $status   = $this->input('filter_status', '');
        $companyWhere = $company ? " AND c.id = " . intval($company) : "";
        $n = 0;

        try {
            switch ($report_type) {

                // ─── CSS-01: Company List / Official Contact ───
                case 'official_contact_address':
                case 'acra_companies_search':
                    $rows = $this->db->fetchAll("SELECT c.id, c.company_name, c.acra_registration_number, c.registration_number, c.contact_person, c.phone1_number, c.email, c.entity_status,
                        (SELECT CONCAT(a.address_text,' ',COALESCE(a.postal_code,'')) FROM addresses a WHERE a.entity_type='company' AND a.entity_id=c.id LIMIT 1) as addr
                        FROM companies c WHERE c.client_id = ? {$companyWhere} ORDER BY c.company_name LIMIT 500", [$cid]);
                    return array_map(function($r) use (&$n) { $n++;
                        return [$n, $r->company_name, $r->acra_registration_number ?? $r->registration_number ?? '', $r->contact_person ?? '', $r->addr ?? '', $r->phone1_number ?? '', $r->email ?? '', $r->entity_status ?? 'Active'];
                    }, $rows);

                // ─── CSS-02: Director Report ───
                case 'comp_director_report':
                case 'register_of_director':
                    $statusW = $status ? " AND d.status = '" . addslashes($status) . "'" : "";
                    $rows = $this->db->fetchAll("SELECT d.*, c.company_name, c.acra_registration_number FROM directors d JOIN companies c ON c.id = d.company_id WHERE c.client_id = ? {$companyWhere} {$statusW} ORDER BY c.company_name, d.name LIMIT 1000", [$cid]);
                    return array_map(function($r) use (&$n) { $n++;
                        return [$n, $r->company_name, $r->acra_registration_number ?? '', $r->name, $r->id_type ?? '', $r->id_number ?? '', $r->nationality ?? '', $r->local_address ?? '', $r->date_of_appointment ?? $r->appointment_date ?? '', $r->date_of_cessation ?? $r->cessation_date ?? '', $r->status ?? 'Active'];
                    }, $rows);

                // ─── CSS-03: Shareholder Report ───
                case 'default_shareholder':
                case 'register_of_member':
                    $rows = $this->db->fetchAll("SELECT s.*, c.company_name, c.acra_registration_number FROM shareholders s JOIN companies c ON c.id = s.company_id WHERE c.client_id = ? {$companyWhere} ORDER BY c.company_name, s.name LIMIT 1000", [$cid]);
                    return array_map(function($r) use (&$n) { $n++;
                        return [$n, $r->company_name, $r->acra_registration_number ?? '', $r->name, $r->shareholder_type ?? 'Individual', '', '', $r->status ?? 'Active'];
                    }, $rows);

                // ─── CSS-04: Secretary Report ───
                case 'comp_secretary_default':
                case 'register_of_secretaries':
                    $rows = $this->db->fetchAll("SELECT s.*, c.company_name, c.acra_registration_number FROM secretaries s JOIN companies c ON c.id = s.company_id WHERE c.client_id = ? {$companyWhere} ORDER BY c.company_name LIMIT 500", [$cid]);
                    return array_map(function($r) use (&$n) { $n++;
                        return [$n, $r->company_name, $r->acra_registration_number ?? '', $r->name, $r->date_of_appointment ?? '', $r->status ?? 'Active'];
                    }, $rows);

                // ─── CSS-05: AGM Report ───
                case 'agm_overdue':
                    $rows = $this->db->fetchAll("SELECT c.company_name, c.acra_registration_number, c.date_of_agm, c.next_agm_due, c.fye_date FROM companies c WHERE c.client_id = ? {$companyWhere} AND c.entity_status = 'Active' ORDER BY c.next_agm_due ASC, c.company_name LIMIT 500", [$cid]);
                    return array_map(function($r) use (&$n) { $n++;
                        $daysOverdue = null; $st = 'N/A';
                        if ($r->next_agm_due) {
                            $diff = (strtotime($r->next_agm_due) - time()) / 86400;
                            if ($diff < 0) { $daysOverdue = abs(round($diff)); $st = 'OVERDUE'; }
                            elseif ($diff <= 30) { $daysOverdue = 0; $st = 'DUE SOON'; }
                            else { $st = 'On Track'; }
                        }
                        return [$n, $r->company_name, $r->acra_registration_number ?? '', $r->date_of_agm ?? '-', $r->next_agm_due ?? '-', $daysOverdue !== null ? $daysOverdue . ' days' : '-', $st];
                    }, $rows);

                // ─── CSS-06: Annual Return / Key Dates Report ───
                case 'key_dates':
                    $rows = $this->db->fetchAll("SELECT c.company_name, c.incorporation_date, c.fye_date, c.date_of_agm, c.next_agm_due, c.last_ar_filing, c.date_of_ar FROM companies c WHERE c.client_id = ? {$companyWhere} AND c.entity_status = 'Active' ORDER BY c.company_name LIMIT 500", [$cid]);
                    return array_map(function($r) use (&$n) { $n++;
                        // Compute next AR due: 7 months after FYE for private
                        $arDue = '-';
                        if ($r->fye_date) {
                            $arDue = date('Y-m-d', strtotime($r->fye_date . ' +7 months'));
                        }
                        return [$n, $r->company_name, $r->incorporation_date ?? '-', $r->fye_date ?? '-', $r->date_of_agm ?? '-', $r->next_agm_due ?? '-', $r->last_ar_filing ?? $r->date_of_ar ?? '-', $arDue];
                    }, $rows);

                // ─── CSS-07: FYE / Upcoming Events Report ───
                case 'remainder_upcoming_event':
                    $rows = $this->db->fetchAll("SELECT d.*, c.company_name FROM due_dates d LEFT JOIN companies c ON c.id = d.company_id WHERE d.client_id = ? AND d.due_date >= CURDATE() ORDER BY d.due_date ASC LIMIT 200", [$cid]);
                    return array_map(function($r) use (&$n) { $n++;
                        $days = round((strtotime($r->due_date) - time()) / 86400);
                        return [$n, $r->company_name ?? $r->company_name ?? '', $r->event_name ?? '', $r->event_name ?? '', $r->due_date, $days . ' days', $r->pic ?? '', $r->status ?? 'Pending'];
                    }, $rows);

                // ─── CSS-08: Share Capital / Allotments ───
                case 'register_of_shares_allotment':
                    $rows = $this->db->fetchAll("SELECT cs.*, c.company_name, s.name as shareholder_name FROM company_shares cs JOIN companies c ON c.id = cs.company_id LEFT JOIN shareholders s ON s.id = cs.shareholder_id WHERE c.client_id = ? {$companyWhere} ORDER BY cs.transaction_date DESC LIMIT 500", [$cid]);
                    return array_map(function($r) use (&$n) { $n++;
                        return [$n, $r->company_name, $r->shareholder_name ?? '', $r->share_type ?? 'Ordinary', $r->number_of_shares ?? 0, number_format($r->issued_share_capital ?? 0, 2), $r->transaction_date ?? '', ''];
                    }, $rows);

                // ─── CSS-09: Registered Address ───
                case 'registered_office_default':
                    $rows = $this->db->fetchAll("SELECT c.company_name, c.acra_registration_number, c.entity_status,
                        (SELECT CONCAT(COALESCE(a.address_text,''),' ',COALESCE(a.postal_code,'')) FROM addresses a WHERE a.entity_type='company' AND a.entity_id=c.id AND (a.is_default=1 OR a.address_type='Registered Office') LIMIT 1) as addr
                        FROM companies c WHERE c.client_id = ? {$companyWhere} ORDER BY c.company_name LIMIT 500", [$cid]);
                    return array_map(function($r) use (&$n) { $n++;
                        return [$n, $r->company_name, $r->acra_registration_number ?? '', $r->addr ?? '-', '', $r->entity_status ?? 'Active'];
                    }, $rows);

                // ─── CSS-10: Auditor Report ───
                case 'register_of_auditors':
                case 'comp_auditor_default':
                    $rows = $this->db->fetchAll("SELECT au.*, c.company_name, c.acra_registration_number FROM auditors au JOIN companies c ON c.id = au.company_id WHERE c.client_id = ? {$companyWhere} ORDER BY c.company_name LIMIT 500", [$cid]);
                    return array_map(function($r) use (&$n) { $n++;
                        return [$n, $r->company_name, $r->acra_registration_number ?? '', $r->name ?? '', $r->firm_name ?? '', $r->date_of_appointment ?? '', $r->status ?? 'Active'];
                    }, $rows);

                // ─── CSS: Controllers ───
                case 'register_of_controllers':
                case 'default_company_controllers':
                case 'register_of_controllers_report':
                    try {
                        $rows = $this->db->fetchAll("SELECT ct.*, c.company_name, c.acra_registration_number FROM controllers ct JOIN companies c ON c.id = ct.company_id WHERE c.client_id = ? {$companyWhere} ORDER BY c.company_name LIMIT 500", [$cid]);
                    } catch (\Exception $e) { $rows = []; }
                    return array_map(function($r) use (&$n) { $n++;
                        return [$n, $r->company_name ?? '', $r->name ?? '', $r->controller_type ?? '', $r->id_number ?? '', $r->nationality ?? '', $r->date_registered ?? '', $r->date_ceased ?? '', $r->status ?? 'Active'];
                    }, $rows);

                // ─── CSS: Sealings ───
                case 'register_of_sealings':
                    try {
                        $rows = $this->db->fetchAll("SELECT sl.*, c.company_name FROM sealings sl JOIN companies c ON c.id = sl.company_id WHERE c.client_id = ? {$companyWhere} ORDER BY sl.sealing_date DESC LIMIT 500", [$cid]);
                    } catch (\Exception $e) { $rows = []; }
                    return array_map(function($r) use (&$n) { $n++;
                        return [$n, $r->company_name ?? '', $r->document_description ?? '', $r->seal_type ?? 'Common Seal', $r->authorised_by ?? '', $r->sealing_date ?? '', $r->remarks ?? ''];
                    }, $rows);

                // ─── CRM: Invoices ───
                case 'crm_invoice':
                case 'invoice_new':
                    $rows = $this->db->fetchAll("SELECT i.*, c.company_name as client_name FROM invoices i LEFT JOIN companies c ON c.id = i.company_id WHERE i.client_id = ? ORDER BY i.created_at DESC LIMIT 500", [$cid]);
                    return array_map(function($r) use (&$n) { $n++;
                        $amt = number_format($r->total_amount ?? $r->amount ?? 0, 2);
                        $paid = number_format($r->paid_amount ?? 0, 2);
                        $bal = number_format(($r->total_amount ?? 0) - ($r->paid_amount ?? 0), 2);
                        return [$n, $r->invoice_number ?? 'INV-'.$r->id, $r->client_name ?? '', $r->invoice_date ?? $r->created_at ?? '', $r->due_date ?? '', $amt, $paid, $bal, $r->status ?? 'Draft'];
                    }, $rows);

                // ─── CRM: Tasks ───
                case 'crm_task':
                case 'tasks':
                    $rows = $this->db->fetchAll("SELECT t.*, p.project_name, u.name as assignee FROM tasks t LEFT JOIN projects p ON p.id = t.project_id LEFT JOIN users u ON u.id = t.assigned_to WHERE t.client_id = ? ORDER BY t.due_date ASC LIMIT 500", [$cid]);
                    return array_map(function($r) use (&$n) { $n++;
                        return [$n, $r->task_name ?? '', $r->project_name ?? '', $r->assignee ?? '', $r->start_date ?? '', $r->due_date ?? '', '', $r->status ?? ''];
                    }, $rows);

                // ─── CRM: Projects ───
                case 'crm_projects':
                case 'project_summary':
                    $rows = $this->db->fetchAll("SELECT p.*, c.company_name, u.name as manager,
                        (SELECT COUNT(*) FROM tasks t WHERE t.project_id = p.id) as task_count
                        FROM projects p LEFT JOIN companies c ON c.id = p.company_id LEFT JOIN users u ON u.id = p.created_by WHERE p.client_id = ? ORDER BY p.created_at DESC LIMIT 200", [$cid]);
                    return array_map(function($r) use (&$n) { $n++;
                        return [$n, $r->project_name ?? '', $r->company_name ?? '', $r->start_date ?? '', $r->end_date ?? '', '', $r->task_count ?? 0, $r->status ?? ''];
                    }, $rows);

                // ─── CRM: Leads ───
                case 'crm_lead':
                case 'lead_report':
                    $rows = $this->db->fetchAll("SELECT l.*, u.name as assignee FROM leads l LEFT JOIN users u ON u.id = l.assigned_to WHERE l.client_id = ? ORDER BY l.created_at DESC LIMIT 500", [$cid]);
                    return array_map(function($r) use (&$n) { $n++;
                        return [$n, $r->name ?? $r->lead_name ?? '', $r->company_name ?? '', $r->email ?? '', $r->phone ?? '', $r->source ?? '', $r->rating ?? '', $r->assignee ?? '', $r->status ?? ''];
                    }, $rows);

                // ─── CRM: Quotations ───
                case 'quotations':
                    $rows = $this->db->fetchAll("SELECT q.*, c.company_name FROM quotations q LEFT JOIN companies c ON c.id = q.company_id WHERE q.client_id = ? ORDER BY q.created_at DESC LIMIT 500", [$cid]);
                    return array_map(function($r) use (&$n) { $n++;
                        return [$n, $r->quotation_number ?? 'Q-'.$r->id, $r->company_name ?? '', $r->quotation_date ?? $r->created_at ?? '', $r->valid_until ?? '', number_format($r->total_amount ?? 0, 2), $r->status ?? ''];
                    }, $rows);

                // ─── Company Events ───
                case 'company_event':
                case 'event_specific':
                    $rows = $this->db->fetchAll("SELECT e.*, c.company_name FROM company_events e JOIN companies c ON c.id = e.company_id WHERE c.client_id = ? ORDER BY e.event_date DESC, e.id DESC LIMIT 500", [$cid]);
                    return array_map(function($r) use (&$n) { $n++;
                        return [$n, $r->company_name ?? '', $r->event_type ?? '', $r->event_description ?? '', $r->event_date ?? '', '', $r->status ?? ''];
                    }, $rows);

                // ─── Documents ───
                case 'all_document':
                    $rows = $this->db->fetchAll("SELECT d.*, c.company_name, u.name as uploader FROM documents d LEFT JOIN companies c ON c.id = d.entity_id AND d.entity_type='company' LEFT JOIN users u ON u.id = d.uploaded_by WHERE d.client_id = ? ORDER BY d.created_at DESC LIMIT 500", [$cid]);
                    return array_map(function($r) use (&$n) { $n++;
                        $size = $r->file_size ? round($r->file_size / 1024, 1) . ' KB' : '';
                        return [$n, $r->company_name ?? 'General', $r->document_name ?? '', $r->file_type ?? '', $r->uploader ?? '', $r->created_at ? date('d/m/Y', strtotime($r->created_at)) : '', $size];
                    }, $rows);

                // ─── User Logs ───
                case 'user_log_report':
                    $rows = $this->db->fetchAll("SELECT ul.*, u.name as user_name FROM user_logs ul LEFT JOIN users u ON u.id = ul.user_id WHERE ul.client_id = ? ORDER BY ul.created_at DESC LIMIT 500", [$cid]);
                    return array_map(function($r) use (&$n) { $n++;
                        return [$n, $r->user_name ?? '', $r->action ?? '', $r->module ?? '', $r->remarks ?? '', $r->ip_address ?? '', $r->created_at ?? ''];
                    }, $rows);

                default:
                    return [];
            }
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get list of companies for filter dropdown
     */
    private function getCompanyList() {
        if (!$this->db) {
            return [];
        }
        $clientId = $_SESSION['client_id'] ?? '';
        $client   = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
        if (!$client) {
            return [];
        }
        return $this->db->fetchAll(
            "SELECT id, company_name FROM companies WHERE client_id = ? ORDER BY company_name ASC",
            [$client->id]
        );
    }

    /**
     * Return all available report types (for menus / API)
     */
    public function list_types() {
        $this->requireAuth();
        $types = [];
        foreach ($this->reportConfigs as $key => $cfg) {
            $types[] = ['key' => $key, 'title' => $cfg['title'], 'column_count' => count($cfg['columns'])];
        }
        $this->json($types);
    }
}
