<?php
/**
 * CorpFile - Corporate Secretarial System
 * 
 * Entry point - routes all requests through the MVC framework
 */

// ── Static file handler for PHP built-in server ──────────────────
// When using `php -S`, all requests go through this file.
// Serve static assets (CSS, JS, images, fonts, videos) directly.
if (php_sapi_name() === 'cli-server') {
    $uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    $file = __DIR__ . $uri;
    if ($uri !== '/' && is_file($file)) {
        // Set proper Content-Type for common static files
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $mimeTypes = [
            'css'  => 'text/css',
            'js'   => 'application/javascript',
            'json' => 'application/json',
            'png'  => 'image/png',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif'  => 'image/gif',
            'svg'  => 'image/svg+xml',
            'ico'  => 'image/x-icon',
            'woff' => 'font/woff',
            'woff2'=> 'font/woff2',
            'ttf'  => 'font/ttf',
            'eot'  => 'application/vnd.ms-fontobject',
            'otf'  => 'font/otf',
            'mp4'  => 'video/mp4',
            'webm' => 'video/webm',
            'pdf'  => 'application/pdf',
            'map'  => 'application/json',
        ];
        if (isset($mimeTypes[$ext])) {
            header('Content-Type: ' . $mimeTypes[$ext]);
        }
        readfile($file);
        return;
    }
}

define('BASEPATH', __DIR__ . '/');
define('APPPATH', BASEPATH . 'application/');
define('FCPATH', BASEPATH . 'public/');
define('ENVIRONMENT', 'development');

// PHP 8.1+ compatibility: suppress Deprecated warnings for htmlspecialchars(null)
// These are harmless and come from the original codebase patterns
error_reporting(E_ALL & ~E_DEPRECATED);

// Safe htmlspecialchars wrapper for PHP 8.1+ (null-safe)
if (!function_exists('esc')) {
    function esc($str) {
        return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
    }
}

// Load configuration first (needed for DB session handler)
require_once APPPATH . 'config/config.php';
require_once APPPATH . 'config/database.php';
require_once APPPATH . 'config/routes.php';

// Start session (use DB handler if database is available)
require_once APPPATH . 'libraries/SessionHandler.php';
try {
    $dbCfg = $GLOBALS['db_config'];
    $socket = getenv('DB_SOCKET');
    $dsn = $socket
        ? "mysql:unix_socket={$socket};dbname={$dbCfg['database']};charset={$dbCfg['charset']}"
        : "mysql:host={$dbCfg['host']};port={$dbCfg['port']};dbname={$dbCfg['database']};charset={$dbCfg['charset']}";
    $sessionPdo = new PDO($dsn, $dbCfg['username'], $dbCfg['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    // Only use DB session handler if the table exists
    $tableCheck = $sessionPdo->query("SHOW TABLES LIKE 'php_sessions'")->fetchColumn();
    if (!$tableCheck) {
        // Create the table on-the-fly
        $sessionPdo->exec("CREATE TABLE IF NOT EXISTS php_sessions (
            session_id VARCHAR(128) NOT NULL PRIMARY KEY,
            session_data MEDIUMTEXT NOT NULL,
            session_expiry INT(11) UNSIGNED NOT NULL,
            INDEX idx_expiry (session_expiry)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }
    $handler = new DbSessionHandler($sessionPdo);
    session_set_save_handler($handler, true);
} catch (Exception $e) {
    // Fall back to file-based sessions if DB not available
}
session_start();

// Load core libraries
require_once APPPATH . 'libraries/Database.php';
require_once APPPATH . 'libraries/Controller.php';
require_once APPPATH . 'libraries/Model.php';
require_once APPPATH . 'libraries/Auth.php';
require_once APPPATH . 'libraries/FirebaseAuth.php';

// Autoload all model files
$modelDir = APPPATH . 'models/';
if (is_dir($modelDir)) {
    foreach (glob($modelDir . '*.php') as $modelFile) {
        require_once $modelFile;
    }
}

// Flat URL mapping: maps first URI segment to controller file and class name
$controllerMap = [
    // ─── Companies ───────────────────────────────────────────────
    'company_list'       => ['file' => 'Companies.php', 'class' => 'Company_list'],
    'add_company'        => ['file' => 'Companies.php', 'class' => 'Add_company'],
    'view_company'       => ['file' => 'Companies.php', 'class' => 'View_company'],
    'edit_company'       => ['file' => 'Companies.php', 'class' => 'Edit_company'],
    'pre_company'        => ['file' => 'Companies.php', 'class' => 'Pre_company'],
    'post_company'       => ['file' => 'Companies.php', 'class' => 'Post_company'],
    'company_non_client' => ['file' => 'Companies.php', 'class' => 'Company_non_client'],
    'company_fee_list'   => ['file' => 'Companies.php', 'class' => 'Company_fee_list'],
    'settings_company_fee_list' => ['file' => 'Companies.php', 'class' => 'Company_fee_list'],
    'new_registration'   => ['file' => 'Companies.php', 'class' => 'New_registration'],
    'transfer_in'        => ['file' => 'Companies.php', 'class' => 'Transfer_in'],
    'company_pdf'        => ['file' => 'Companies.php', 'class' => 'Company_pdf'],
    'settings_view_company_pdf' => ['file' => 'Companies.php', 'class' => 'Company_pdf'],
    'company_type'       => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'add_company_types'  => ['file' => 'Settings.php', 'class' => 'Settings_master_add'],
    'edit_company_types' => ['file' => 'Settings.php', 'class' => 'Settings_master_edit'],

    // ─── Members ─────────────────────────────────────────────────
    'member'       => ['file' => 'Members.php', 'class' => 'Member_list'],
    'add_member'   => ['file' => 'Members.php', 'class' => 'Add_member'],
    'view_member'  => ['file' => 'Members.php', 'class' => 'View_member'],
    'edit_member'  => ['file' => 'Members.php', 'class' => 'Edit_member'],

    // ─── Chats ──────────────────────────────────────────────────
    'chats' => ['file' => 'Chats.php', 'class' => 'Chats'],

    // ─── Dashboard ───────────────────────────────────────────────
    'dashboard' => ['file' => 'Dashboard.php', 'class' => 'Dashboard'],
    'registration' => ['file' => 'Workspace.php', 'class' => 'Registration'],
    'events_alerts' => ['file' => 'Workspace.php', 'class' => 'Events_alerts'],
    'workflow' => ['file' => 'Workspace.php', 'class' => 'Workflow'],
    'agents' => ['file' => 'Workspace.php', 'class' => 'Agents'],

    // ─── Auth ────────────────────────────────────────────────────
    'welcome' => ['file' => 'Welcome.php', 'class' => 'Welcome'],

    // ─── Events ──────────────────────────────────────────────────
    'event_tracker'       => ['file' => 'Events.php', 'class' => 'Event_tracker'],
    'agm_listing'         => ['file' => 'Events.php', 'class' => 'Agm_listing'],
    'ar_listing'          => ['file' => 'Events.php', 'class' => 'Ar_listing'],
    'fye_listing'         => ['file' => 'Events.php', 'class' => 'Fye_listing'],
    'anniversary_listing' => ['file' => 'Events.php', 'class' => 'Anniversary_listing'],
    'due_listing'         => ['file' => 'Events.php', 'class' => 'Due_listing'],
    'id_expiry_listing'   => ['file' => 'Events.php', 'class' => 'Id_expiry_listing'],
    'company_agm_list'    => ['file' => 'Events.php', 'class' => 'Company_agm_list'],
    'add_agm'             => ['file' => 'Events.php', 'class' => 'Add_agm'],
    'edit_agm'            => ['file' => 'Events.php', 'class' => 'Edit_agm'],
    'multiple_add_agm'    => ['file' => 'Events.php', 'class' => 'Multiple_add_agm'],
    'duedatetracker'      => ['file' => 'Events.php', 'class' => 'Event_tracker'],

    // ─── Settings ────────────────────────────────────────────────
    'settings'                => ['file' => 'Settings.php', 'class' => 'Settings'],
    'general_settings'        => ['file' => 'Settings.php', 'class' => 'General_settings'],
    'user_settings'           => ['file' => 'Settings.php', 'class' => 'User_settings'],
    'css_settings'            => ['file' => 'Settings.php', 'class' => 'Css_settings'],
    'settings_master'         => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_master_add'     => ['file' => 'Settings.php', 'class' => 'Settings_master_add'],
    'settings_master_edit'    => ['file' => 'Settings.php', 'class' => 'Settings_master_edit'],
    'settings_company_profile'          => ['file' => 'Settings.php', 'class' => 'General_settings'],
    'settings_branch_master'            => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_member_id_type_list'      => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_event_name_list'          => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_fee_type_list'            => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_document_category'        => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_email_template_list'      => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_payment_mode'             => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_industry_master'          => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_market_segment_master'    => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_region_master'            => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_custom_field'             => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_list_product_cat_master'  => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_list_tag_master'          => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_status_master'            => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_list_status'              => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_list_lead_source'         => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_list_lead_rating'         => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_list_order_reason'        => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_list_follow_up_mode'      => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_list_follow_up_agenda'    => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_terms'                    => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_shares_class_type_list'   => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_register_footer_list'     => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_list_crm_master_task'     => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_list_crm_master_cycle'    => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_list_ticket_type_master'  => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_list_project_status'      => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_list_importance_master'   => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_list_task_group'          => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_task_priority_list'       => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_crm_taskchecklist_master' => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_ticket_priority_list'     => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_bank_transaction_approver_groups' => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_list_designer_master'     => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_group_master'             => ['file' => 'Settings.php', 'class' => 'Settings_master'],

    // ─── Officials ───────────────────────────────────────────────
    'company_officials'    => ['file' => 'Officials.php', 'class' => 'Company_officials'],
    'officials_list'       => ['file' => 'Officials.php', 'class' => 'Officials_list'],
    'directors'            => ['file' => 'Officials.php', 'class' => 'Directors_list'],
    'shareholders'         => ['file' => 'Officials.php', 'class' => 'Shareholders_list'],
    'add_director'         => ['file' => 'Officials.php', 'class' => 'Add_director'],
    'add_shareholder'      => ['file' => 'Officials.php', 'class' => 'Add_shareholder'],
    'add_secretary'        => ['file' => 'Officials.php', 'class' => 'Add_secretary'],
    'add_auditor'          => ['file' => 'Officials.php', 'class' => 'Add_auditor'],
    'add_representative'   => ['file' => 'Officials.php', 'class' => 'Add_representative'],
    'add_manager'          => ['file' => 'Officials.php', 'class' => 'Add_manager'],
    'add_ceo'              => ['file' => 'Officials.php', 'class' => 'Add_ceo'],
    'add_external_corp_sec' => ['file' => 'Officials.php', 'class' => 'Add_secretary'],
    'mainadmin_auditors_list' => ['file' => 'Officials.php', 'class' => 'Company_officials'],
    'mainadmin_add_auditors'  => ['file' => 'Officials.php', 'class' => 'Add_auditor'],
    'corporate_shareholder' => ['file' => 'Officials.php', 'class' => 'Company_officials'],

    // ─── Shares ──────────────────────────────────────────────────
    'shares'              => ['file' => 'Shares.php', 'class' => 'Shares'],
    'company_share_level' => ['file' => 'Shares.php', 'class' => 'Company_share_level'],
    'discrepancy_company' => ['file' => 'Shares.php', 'class' => 'Discrepancy_company'],
    'partial_full_paid_discrepancy_company' => ['file' => 'Shares.php', 'class' => 'Partial_full_paid_discrepancy_company'],

    // ─── Document Generator ─────────────────────────────────────
    'document_generator' => ['file' => 'DocumentGenerator.php', 'class' => 'DocumentGenerator'],

    // ─── Reports ─────────────────────────────────────────────────
    'reports'       => ['file' => 'Reports.php', 'class' => 'Reports'],
    'css_reports'   => ['file' => 'Reports.php', 'class' => 'Css_reports'],
    'crm_reports'   => ['file' => 'Reports.php', 'class' => 'Crm_reports'],
    'report_view'   => ['file' => 'Reports.php', 'class' => 'Report_view'],
    'report_module' => ['file' => 'Reports.php', 'class' => 'Report_view'],

    // ─── CRM ─────────────────────────────────────────────────────
    'crm'                        => ['file' => 'Crm.php', 'class' => 'Crm'],
    'crm_dashboard'              => ['file' => 'Crm.php', 'class' => 'Crm_dashboard'],
    'crm_leads'                  => ['file' => 'Crm.php', 'class' => 'Crm_leads'],
    'leads'                      => ['file' => 'Crm.php', 'class' => 'Crm_leads'],
    'leads_listing'              => ['file' => 'Crm.php', 'class' => 'Crm_leads'],
    'add_lead'                   => ['file' => 'Crm.php', 'class' => 'Add_lead'],
    'crm_quotations'             => ['file' => 'Crm.php', 'class' => 'Crm_quotations'],
    'leads_quotations'           => ['file' => 'Crm.php', 'class' => 'Crm_quotations'],
    'crm_sales_order'            => ['file' => 'Crm.php', 'class' => 'Crm_sales_order'],
    'orders'                     => ['file' => 'Crm.php', 'class' => 'Crm_sales_order'],
    'orders_listing'             => ['file' => 'Crm.php', 'class' => 'Crm_sales_order'],
    'crm_invoices'               => ['file' => 'Crm.php', 'class' => 'Crm_invoices'],
    'crm_projects'               => ['file' => 'Crm.php', 'class' => 'Crm_projects'],
    'twcrm_projects'             => ['file' => 'Crm.php', 'class' => 'Crm_projects'],
    'crm_tasks'                  => ['file' => 'Crm.php', 'class' => 'Crm_tasks'],
    'tasks'                      => ['file' => 'Crm.php', 'class' => 'Crm_tasks'],
    'crm_activities'             => ['file' => 'Crm.php', 'class' => 'Crm_activities'],
    'activities'                 => ['file' => 'Crm.php', 'class' => 'Crm_activities'],
    'crm_timesheets'             => ['file' => 'Crm.php', 'class' => 'Crm_timesheets'],
    'timesheet'                  => ['file' => 'Crm.php', 'class' => 'Crm_timesheets'],
    'crm_project_view'           => ['file' => 'Crm.php', 'class' => 'Crm_project_view'],
    'crm_project_edit'           => ['file' => 'Crm.php', 'class' => 'Crm_project_edit'],
    'crm_project_create'         => ['file' => 'Crm.php', 'class' => 'Crm_project_create'],
    'crm_project_gantt'          => ['file' => 'Crm.php', 'class' => 'Crm_project_gantt'],
    'crm_create_quotation'       => ['file' => 'Crm.php', 'class' => 'Crm_create_quotation'],
    'crm_create_order'           => ['file' => 'Crm.php', 'class' => 'Crm_create_order'],
    'crm_followup_list'          => ['file' => 'Crm.php', 'class' => 'Crm_followup_list'],
    'leads_followup_list'        => ['file' => 'Crm.php', 'class' => 'Crm_followup_list'],
    'crm_invoice_reconciliation' => ['file' => 'Crm.php', 'class' => 'Crm_invoice_reconciliation'],
    'crm_ticket_view'            => ['file' => 'Crm.php', 'class' => 'Crm_ticket_view'],
    'dashboard_activity'         => ['file' => 'Crm.php', 'class' => 'Dashboard_activity'],
    'dashboard_invoice'          => ['file' => 'Crm.php', 'class' => 'Dashboard_invoice'],
    'dashboard_project'          => ['file' => 'Crm.php', 'class' => 'Dashboard_project'],
    'dashboard_leads'            => ['file' => 'Crm.php', 'class' => 'Dashboard_leads'],
    'dashboard_support'          => ['file' => 'Crm.php', 'class' => 'Dashboard_support'],
    'Lead_dashboard'             => ['file' => 'Crm.php', 'class' => 'Dashboard_leads'],
    'crm_detail_company_lead'    => ['file' => 'Crm.php', 'class' => 'Crm_lead_detail'],
    'crm_lead_detail'            => ['file' => 'Crm.php', 'class' => 'Crm_lead_detail'],
    'timesheet_weekly'           => ['file' => 'Crm.php', 'class' => 'Timesheet_weekly'],
    'timesheet_timsheet_activity' => ['file' => 'Crm.php', 'class' => 'Timesheet_activity'],
    'timesheet_activity'         => ['file' => 'Crm.php', 'class' => 'Timesheet_activity'],
    'workflow_agmAutomation'     => ['file' => 'Crm.php', 'class' => 'Workflow_agm'],
    'workflow_agm'               => ['file' => 'Crm.php', 'class' => 'Workflow_agm'],
    'invoice_settings'           => ['file' => 'Crm.php', 'class' => 'Invoice_settings'],
    'invoice_invoice_settings'   => ['file' => 'Crm.php', 'class' => 'Invoice_settings'],

    // ─── Admin / Users ───────────────────────────────────────────
    'alladmin'                   => ['file' => 'Admin.php', 'class' => 'Alladmin'],
    'add_admin'                  => ['file' => 'Admin.php', 'class' => 'Add_admin'],
    'edit_admin'                 => ['file' => 'Admin.php', 'class' => 'Edit_admin'],
    'page_access_rights'         => ['file' => 'Admin.php', 'class' => 'Page_access_rights'],
    'settings_page_access_rights'        => ['file' => 'Admin.php', 'class' => 'Page_access_rights'],
    'settings_lead_access_rights'        => ['file' => 'Admin.php', 'class' => 'Page_access_rights'],
    'settings_task_ticket_access_rights' => ['file' => 'Admin.php', 'class' => 'Page_access_rights'],
    'user_groups'                => ['file' => 'Admin.php', 'class' => 'User_groups'],
    'settings_user_groups'       => ['file' => 'Admin.php', 'class' => 'User_groups'],
    'add_user_group'             => ['file' => 'Admin.php', 'class' => 'Add_user_group'],
    'settings_add_user_group'    => ['file' => 'Admin.php', 'class' => 'Add_user_group'],
    'edit_user_group'            => ['file' => 'Admin.php', 'class' => 'Edit_user_group'],
    'settings_edit_user_group'   => ['file' => 'Admin.php', 'class' => 'Edit_user_group'],
    'user_groups_permissions'    => ['file' => 'Admin.php', 'class' => 'User_groups_permissions'],
    'settings_user_groups_permissions'   => ['file' => 'Admin.php', 'class' => 'User_groups_permissions'],
    'settings_admin_access_list' => ['file' => 'Admin.php', 'class' => 'Alladmin'],
    'change_psd'                 => ['file' => 'Admin.php', 'class' => 'Change_psd'],
    'crm_team_creation'          => ['file' => 'Crm.php', 'class' => 'Crm_team_creation'],

    // ─── Documents ───────────────────────────────────────────────
    'documents'            => ['file' => 'Documents.php', 'class' => 'Documents'],
    'alldocuments'         => ['file' => 'Documents.php', 'class' => 'Documents'],
    'company_document'     => ['file' => 'Documents.php', 'class' => 'Company_document'],
    'company_file'         => ['file' => 'Documents.php', 'class' => 'Company_file'],
    'edit_document'        => ['file' => 'Documents.php', 'class' => 'Edit_document'],
    'document_history'     => ['file' => 'Documents.php', 'class' => 'Document_history'],
    'file_preview'         => ['file' => 'Documents.php', 'class' => 'File_preview'],
    'company_forms'        => ['file' => 'Documents.php', 'class' => 'Company_forms'],
    'companyform_form'     => ['file' => 'Documents.php', 'class' => 'Company_forms'],
    'edit_form'            => ['file' => 'Documents.php', 'class' => 'Edit_form'],
    'mainadmin_edit_form'  => ['file' => 'Documents.php', 'class' => 'Edit_form'],
    'mainadmin_file_preview' => ['file' => 'Documents.php', 'class' => 'File_preview'],
    'settings_document_history' => ['file' => 'Documents.php', 'class' => 'Document_history'],
    'form_category'        => ['file' => 'Settings.php', 'class' => 'Settings_master'],

    // ─── Templates / eSign ───────────────────────────────────────
    'templates'    => ['file' => 'Templates.php', 'class' => 'Templates'],
    'esign'        => ['file' => 'Templates.php', 'class' => 'Esign'],
    'esign_manage' => ['file' => 'Templates.php', 'class' => 'Esign'],

    // ─── Registers ───────────────────────────────────────────────
    'registers'             => ['file' => 'Registers.php', 'class' => 'Registers'],
    'register_directors'    => ['file' => 'Registers.php', 'class' => 'Register_directors'],
    'register_shareholders' => ['file' => 'Registers.php', 'class' => 'Register_shareholders'],
    'register_secretaries'  => ['file' => 'Registers.php', 'class' => 'Register_secretaries'],

    // ─── Support ─────────────────────────────────────────────────
    'support'              => ['file' => 'Support.php', 'class' => 'Support'],
    'clientsupport_ticket' => ['file' => 'Support.php', 'class' => 'Support'],

    // ─── Notifications ───────────────────────────────────────────
    'notifications' => ['file' => 'Notifications.php', 'class' => 'Notifications'],

    // ─── Misc ────────────────────────────────────────────────────
    'my_profile'            => ['file' => 'Misc.php', 'class' => 'My_profile'],
    'sealings_list'         => ['file' => 'Misc.php', 'class' => 'Sealings_list'],
    'add_seal'              => ['file' => 'Misc.php', 'class' => 'Add_seal'],
    'company_bank'          => ['file' => 'Misc.php', 'class' => 'Company_bank'],
    'mainadmin_company_bank'     => ['file' => 'Misc.php', 'class' => 'Company_bank'],
    'add_company_bank'           => ['file' => 'Misc.php', 'class' => 'Add_company_bank'],
    'mainadmin_add_company_bank' => ['file' => 'Misc.php', 'class' => 'Add_company_bank'],
    'reminder_list'         => ['file' => 'Misc.php', 'class' => 'Reminder_list'],
    'set_reminder'          => ['file' => 'Misc.php', 'class' => 'Set_reminder'],
    'edit_reminder'         => ['file' => 'Misc.php', 'class' => 'Edit_reminder'],
    'esign_settings'        => ['file' => 'Misc.php', 'class' => 'Esign_settings'],
    'esign_log'             => ['file' => 'Misc.php', 'class' => 'Esign_log'],
    'member_pdf'            => ['file' => 'Misc.php', 'class' => 'Member_pdf'],
    'settings_view_member_pdf' => ['file' => 'Misc.php', 'class' => 'Member_pdf'],
    'member_documents'      => ['file' => 'Misc.php', 'class' => 'Member_documents'],
    'mainadmin_view_member_document' => ['file' => 'Misc.php', 'class' => 'Member_documents'],
    'bank'                  => ['file' => 'Misc.php', 'class' => 'Company_bank'],
    'add_bank'              => ['file' => 'Misc.php', 'class' => 'Add_company_bank'],
    'Sealings_sealings_list'     => ['file' => 'Misc.php', 'class' => 'Sealings_list'],
    'Sealings_add_seal'          => ['file' => 'Misc.php', 'class' => 'Add_seal'],
    'Sealings_reg_address_list'  => ['file' => 'Misc.php', 'class' => 'Reg_address_list'],
    'reg_address_list'           => ['file' => 'Misc.php', 'class' => 'Reg_address_list'],
    'Remainder_remainder_list'   => ['file' => 'Misc.php', 'class' => 'Reminder_list'],
    'Remainder_set_remainder'    => ['file' => 'Misc.php', 'class' => 'Set_reminder'],
    'Remainder_edit_remainder'   => ['file' => 'Misc.php', 'class' => 'Edit_reminder'],
    'settings_register_charge_list' => ['file' => 'Misc.php', 'class' => 'Register_charge_list'],

    // ─── Misc Extended ──────────────────────────────────────────
    'corporate_shareholder_corp_share_comp_list' => ['file' => 'Misc.php', 'class' => 'Corp_share_comp_list'],
    'corp_share_comp_list'       => ['file' => 'Misc.php', 'class' => 'Corp_share_comp_list'],
    'fye_pdf_view'               => ['file' => 'Misc.php', 'class' => 'Fye_pdf_view'],
    'Remainder_fye_date_not_entered_pdf_view' => ['file' => 'Misc.php', 'class' => 'Fye_pdf_view'],
    'event_receiving_parties'    => ['file' => 'Misc.php', 'class' => 'Event_receiving_parties'],
    'settings_event_receiving_parties' => ['file' => 'Misc.php', 'class' => 'Event_receiving_parties'],
    'agent_commission_setup'     => ['file' => 'Misc.php', 'class' => 'Agent_commission_setup'],
    'settings_product_agent_commission_setup' => ['file' => 'Misc.php', 'class' => 'Agent_commission_setup'],
    'recurring_event_name'       => ['file' => 'Misc.php', 'class' => 'Recurring_event_name'],
    'settings_recurring_event_name' => ['file' => 'Misc.php', 'class' => 'Recurring_event_name'],

    // ─── Account Types ──────────────────────────────────────────
    'mainadmin_account_type'     => ['file' => 'Misc.php', 'class' => 'Account_type_list'],
    'mainadmin_add_account'      => ['file' => 'Misc.php', 'class' => 'Add_account_type'],
    'account_type'               => ['file' => 'Misc.php', 'class' => 'Account_type_list'],
    'add_account_type'           => ['file' => 'Misc.php', 'class' => 'Add_account_type'],

    // ─── Form Category CRUD ─────────────────────────────────────
    'add_form_category'          => ['file' => 'Settings.php', 'class' => 'Settings_master_add'],
    'edit_form_category'         => ['file' => 'Settings.php', 'class' => 'Settings_master_edit'],

    // ─── Invoice/Billing Reports (flat routes) ──────────────────
    'invoice_credit_note_report' => ['file' => 'Reports.php', 'class' => 'Report_view'],
    'Invoice_Reconciliation'     => ['file' => 'Crm.php', 'class' => 'Crm_invoice_reconciliation'],
    'invoice_invoice_agent_report'     => ['file' => 'Reports.php', 'class' => 'Report_view'],
    'invoice_invoice_payment_report'   => ['file' => 'Reports.php', 'class' => 'Report_view'],
    'invoice_invoice_report_new'       => ['file' => 'Reports.php', 'class' => 'Report_view'],
    'invoice_invoice_service_report'   => ['file' => 'Reports.php', 'class' => 'Report_view'],
    'Invoice_statement_of_accounts'    => ['file' => 'Reports.php', 'class' => 'Report_view'],
    'Invoice_custom_statement_of_accounts' => ['file' => 'Reports.php', 'class' => 'Report_view'],

    // ─── twcrm_controller settings lists ────────────────────────
    'settings_list_uom_master'           => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_list_expense_head'         => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'settings_list_ticket_source_master' => ['file' => 'Settings.php', 'class' => 'Settings_master'],

    // ─── Help ───────────────────────────────────────────────────
    'help' => ['file' => 'Help.php', 'class' => 'Help'],
];

// ---------------------------------------------------------------------------
// Helper: dispatch a resolved controller map entry
// ---------------------------------------------------------------------------
function dispatchController($map, $params = []) {
    $controllerFile = APPPATH . 'controllers/' . $map['file'];
    $className = $map['class'];

    if (!file_exists($controllerFile)) {
        http_response_code(404);
        echo '404 - Controller file not found';
        return;
    }

    require_once $controllerFile;

    if (!class_exists($className)) {
        http_response_code(404);
        echo '404 - Class not found: ' . htmlspecialchars($className);
        return;
    }

    $controller = new $className();

    // If first param looks like a method name, try calling it
    if (!empty($params[0]) && method_exists($controller, $params[0])) {
        $method = array_shift($params);
        call_user_func_array([$controller, $method], $params);
    } elseif (!empty($params[0]) && method_exists($controller, '__call')) {
        // Support __call for method name aliasing (e.g. Esign::view -> detail)
        $method = array_shift($params);
        call_user_func_array([$controller, $method], $params);
    } elseif (method_exists($controller, 'index')) {
        call_user_func_array([$controller, 'index'], $params);
    } else {
        http_response_code(404);
        echo '404 - Method not found';
    }
}

// ---------------------------------------------------------------------------
// Simple Router
// ---------------------------------------------------------------------------
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');
$segments = $uri ? explode('/', $uri) : [];

$firstSegment = !empty($segments[0]) ? $segments[0] : '';
$firstSegmentLower = strtolower($firstSegment);

// ── 1. Handle "settings/" prefix URLs ────────────────────────────────────
//    e.g. /settings/company_fee_list/156 → lookup "settings_company_fee_list"
//    If "settings" is the first segment and there are more segments, try to
//    build a prefixed key "settings_<second_segment>" and look it up in the map.
if ($firstSegmentLower === 'settings' && count($segments) >= 2) {
    $settingsSubKey = 'settings_' . strtolower($segments[1]);
    if (isset($controllerMap[$settingsSubKey])) {
        $map = $controllerMap[$settingsSubKey];
        $params = array_slice($segments, 2);
        // For Settings_master class, pass the sub-key as the type parameter
        // e.g. /settings/document_category → Settings_master::index('document_category')
        if ($map['class'] === 'Settings_master' && empty($params)) {
            $params = [strtolower($segments[1])];
            // Strip trailing '_list' if present (e.g. member_id_type_list → member_id_type)
            $typeKey = preg_replace('/_list$/', '', $params[0]);
            $params = [$typeKey];
        }
        dispatchController($map, $params);
        return;
    }
    // Also check the second segment directly (e.g. /settings/general_settings)
    $directKey = strtolower($segments[1]);
    if (isset($controllerMap[$directKey])) {
        $params = array_slice($segments, 2);
        dispatchController($controllerMap[$directKey], $params);
        return;
    }
    // Fall through to try "settings" as a standalone route below
}

// ── 2. Handle "report_module/" prefix URLs ───────────────────────────────
//    e.g. /report_module/register_of_director_list → Report_view class
//    All remaining segments (including the sub-report name) passed as params.
if ($firstSegmentLower === 'report_module' && count($segments) >= 2) {
    $params = array_slice($segments, 1); // sub-report name + any further params
    dispatchController($controllerMap['report_module'], $params);
    return;
}

// ── 2b. Handle "crm_report_module/" prefix URLs ─────────────────────────
//    e.g. /crm_report_module/activity_report → Report_view class
if ($firstSegmentLower === 'crm_report_module' && count($segments) >= 2) {
    $params = array_slice($segments, 1);
    dispatchController($controllerMap['report_module'], $params);
    return;
}

// ── 2c. Handle "Invoice/" prefix URLs ────────────────────────────────────
//    e.g. /Invoice/credit_note_report → Invoice_report class
//    /Invoice/Reconciliation → Crm_invoice_reconciliation
//    /Invoice/statement_of_accounts → Invoice_report class
if ($firstSegmentLower === 'invoice' && count($segments) >= 2) {
    $subKey = strtolower($segments[1]);
    // Map invoice sub-URLs to report config keys
    $invoiceReportMap = [
        'credit_note_report'           => 'credit_note',
        'invoice_agent_report'         => 'invoice_agent',
        'invoice_payment_report'       => 'invoice_payment',
        'invoice_report_new'           => 'invoice_new',
        'invoice_service_report'       => 'invoice_service',
        'statement_of_accounts'        => 'statement_of_accounts',
        'custom_statement_of_accounts' => 'custom_statement_of_accounts',
    ];
    if ($subKey === 'reconciliation') {
        dispatchController($controllerMap['crm_invoice_reconciliation'], array_slice($segments, 2));
        return;
    }
    if (isset($invoiceReportMap[$subKey])) {
        dispatchController(['file' => 'Reports.php', 'class' => 'Report_view'], [$invoiceReportMap[$subKey]]);
        return;
    }
    // Also try prefixed key invoice_<sub>
    $invoicePrefixed = 'invoice_' . $subKey;
    if (isset($controllerMap[$invoicePrefixed])) {
        dispatchController($controllerMap[$invoicePrefixed], array_slice($segments, 2));
        return;
    }
}

// ── 2d. Handle "company_agm/" prefix URLs ────────────────────────────────
//    e.g. /company_agm/company_agm_list → Event_tracker
//    /company_agm/add_agm/30/event → Add_agm
//    /company_agm/edit_agm/754 → Edit_agm
//    /company_agm/multiple_add_agm/... → Multiple_add_agm
if ($firstSegmentLower === 'company_agm' && count($segments) >= 2) {
    $subKey = strtolower($segments[1]);
    if (isset($controllerMap[$subKey])) {
        $params = array_slice($segments, 2);
        dispatchController($controllerMap[$subKey], $params);
        return;
    }
    // Default to company_agm_list
    dispatchController($controllerMap['company_agm_list'], array_slice($segments, 1));
    return;
}

// ── 2e. Handle "company_shares/" prefix URLs ─────────────────────────────
//    e.g. /company_shares/shareholders_listing/30/view/view_officials
//    /company_shares/add_shareholders/93/view/view_company
if ($firstSegmentLower === 'company_shares' && count($segments) >= 2) {
    $subKey = strtolower($segments[1]);
    // Map sub-URLs to existing controllers
    $sharesSubMap = [
        'shareholders_listing' => 'company_officials',
        'add_shareholders'     => 'add_shareholder',
        'shares'               => 'shares',
        'company_share_level'  => 'company_share_level',
    ];
    if (isset($sharesSubMap[$subKey])) {
        $params = array_slice($segments, 2);
        dispatchController($controllerMap[$sharesSubMap[$subKey]], $params);
        return;
    }
    if (isset($controllerMap[$subKey])) {
        $params = array_slice($segments, 2);
        dispatchController($controllerMap[$subKey], $params);
        return;
    }
    // Default to company_officials with shareholder context
    dispatchController($controllerMap['company_officials'], array_slice($segments, 1));
    return;
}

// ── 2f. Handle "mainadmin/" prefix URLs ──────────────────────────────────
//    e.g. /mainadmin/auditors_list/30/view/view_officials
//    /mainadmin/account_type → Account_type_list
//    /mainadmin/add_account → Add_account_type
if ($firstSegmentLower === 'mainadmin' && count($segments) >= 2) {
    $subKey = strtolower($segments[1]);
    // Try prefixed key mainadmin_<sub>
    $mainadminPrefixed = 'mainadmin_' . $subKey;
    if (isset($controllerMap[$mainadminPrefixed])) {
        $params = array_slice($segments, 2);
        dispatchController($controllerMap[$mainadminPrefixed], $params);
        return;
    }
    // Try direct key
    if (isset($controllerMap[$subKey])) {
        $params = array_slice($segments, 2);
        dispatchController($controllerMap[$subKey], $params);
        return;
    }
    // Map known sub-routes
    $mainadminSubMap = [
        'auditors_list'  => 'company_officials',
        'add_auditors'   => 'add_auditor',
    ];
    if (isset($mainadminSubMap[$subKey])) {
        $params = array_slice($segments, 2);
        dispatchController($controllerMap[$mainadminSubMap[$subKey]], $params);
        return;
    }
}

// ── 2g. Handle "twcrm_controller/" prefix URLs ──────────────────────────
//    e.g. /twcrm_controller/list_uom_master → Settings_master
//    /twcrm_controller/list_expense_head → Settings_master
//    /twcrm_controller/list_ticket_source_master → Settings_master
if ($firstSegmentLower === 'twcrm_controller' && count($segments) >= 2) {
    $subKey = strtolower($segments[1]);
    // Try settings_ prefixed key
    $settingsKey = 'settings_' . $subKey;
    if (isset($controllerMap[$settingsKey])) {
        $params = array_slice($segments, 2);
        dispatchController($controllerMap[$settingsKey], $params);
        return;
    }
    // All twcrm_controller/list_* pages are settings master lists
    dispatchController($controllerMap['settings_master'], array_slice($segments, 1));
    return;
}

// ── 2h. Handle "help/" prefix URLs ──────────────────────────────────────
//    e.g. /help, /help/article/1, /help/category/2
if ($firstSegmentLower === 'help') {
    dispatchController(['file' => 'Help.php', 'class' => 'Help'], array_slice($segments, 1));
    return;
}

// ── 2i. Handle "add_external_corp_sec/" prefix URLs ─────────────────────
if ($firstSegmentLower === 'add_external_corp_sec' || $firstSegmentLower === 'add_external_corpsec') {
    dispatchController($controllerMap['add_secretary'], array_slice($segments, 1));
    return;
}

// ── 2j. Handle "members/" prefix URLs ───────────────────────────────────
//    e.g. /members/edit_member/8 → Edit_member with param 8
//    /members/view_member/5 → View_member with param 5
//    /members/add_member → Add_member
//    /members/delete_member → Members::delete_member (AJAX)
if ($firstSegmentLower === 'members' && count($segments) >= 2) {
    $subKey = strtolower($segments[1]);
    if (isset($controllerMap[$subKey])) {
        $params = array_slice($segments, 2);
        dispatchController($controllerMap[$subKey], $params);
        return;
    }
    // Fall through to fallback (Members class has methods like delete_member, upload_file)
}

// ── 2k. Handle "Company_officials/" prefix URLs ─────────────────────────
//    e.g. /Company_officials/company_officials_list → Company_officials
//    /Company_officials/director_list/30/... → Company_officials with params
if ($firstSegmentLower === 'company_officials' && count($segments) >= 2) {
    $subKey = strtolower($segments[1]);
    if (isset($controllerMap[$subKey])) {
        $params = array_slice($segments, 2);
        dispatchController($controllerMap[$subKey], $params);
        return;
    }
    // Try the compound key
    $compoundKey = 'company_officials_' . $subKey;
    if (isset($controllerMap[$compoundKey])) {
        $params = array_slice($segments, 2);
        dispatchController($controllerMap[$compoundKey], $params);
        return;
    }
    // Default to company_officials with sub-segments as params
    dispatchController($controllerMap['company_officials'], array_slice($segments, 1));
    return;
}

// ── 2k2. Handle "corporate_shareholder/" prefix URLs ────────────────────
//    e.g. /corporate_shareholder/corp_share_comp_list → Corp_share_comp_list
if ($firstSegmentLower === 'corporate_shareholder' && count($segments) >= 2) {
    $subKey = strtolower($segments[1]);
    $compoundKey = 'corporate_shareholder_' . $subKey;
    if (isset($controllerMap[$compoundKey])) {
        $params = array_slice($segments, 2);
        dispatchController($controllerMap[$compoundKey], $params);
        return;
    }
    if (isset($controllerMap[$subKey])) {
        $params = array_slice($segments, 2);
        dispatchController($controllerMap[$subKey], $params);
        return;
    }
    // Default to Company_officials
    dispatchController($controllerMap['corporate_shareholder'], array_slice($segments, 1));
    return;
}

// ── 2l. Handle "Sealings/" prefix URLs ──────────────────────────────────
//    e.g. /Sealings/sealings_list → Sealings_list
//    /Sealings/add_seal → Add_seal
//    /Sealings/reg_address_list → Reg_address_list
if ($firstSegmentLower === 'sealings' && count($segments) >= 2) {
    $subKey = strtolower($segments[1]);
    // Try Sealings_ prefixed key
    $sealingsPrefixed = 'Sealings_' . $subKey;
    if (isset($controllerMap[$sealingsPrefixed])) {
        $params = array_slice($segments, 2);
        dispatchController($controllerMap[$sealingsPrefixed], $params);
        return;
    }
    // Try direct key
    if (isset($controllerMap[$subKey])) {
        $params = array_slice($segments, 2);
        dispatchController($controllerMap[$subKey], $params);
        return;
    }
}

// ── 2m. Handle "Remainder/" prefix URLs ─────────────────────────────────
//    e.g. /Remainder/remainder_list → Reminder_list
//    /Remainder/set_remainder → Set_reminder
if ($firstSegmentLower === 'remainder' && count($segments) >= 2) {
    $subKey = strtolower($segments[1]);
    $remainderPrefixed = 'Remainder_' . $subKey;
    if (isset($controllerMap[$remainderPrefixed])) {
        $params = array_slice($segments, 2);
        dispatchController($controllerMap[$remainderPrefixed], $params);
        return;
    }
    if (isset($controllerMap[$subKey])) {
        $params = array_slice($segments, 2);
        dispatchController($controllerMap[$subKey], $params);
        return;
    }
}

// ── 2n. Handle "auth/" prefix URLs ──────────────────────────────────────
//    e.g. /auth/logout → Welcome::logout
//    /auth/change_password → Change_psd
//    /auth/lock_screen → (just redirect to welcome)
if ($firstSegmentLower === 'auth' && count($segments) >= 2) {
    $subKey = strtolower($segments[1]);
    if ($subKey === 'logout') {
        dispatchController($controllerMap['welcome'], ['logout']);
        return;
    }
    if ($subKey === 'change_password') {
        dispatchController($controllerMap['change_psd'] ?? ['file' => 'Admin.php', 'class' => 'Change_psd'], array_slice($segments, 2));
        return;
    }
    if ($subKey === 'lock_screen') {
        dispatchController($controllerMap['welcome'], ['logout']);
        return;
    }
}

// ── 2o. Handle "profile" and "company_profile" redirects ────────────────
if ($firstSegmentLower === 'profile') {
    dispatchController($controllerMap['my_profile'], array_slice($segments, 1));
    return;
}
if ($firstSegmentLower === 'company_profile') {
    dispatchController($controllerMap['general_settings'], ['company_type']);
    return;
}

// ── 2p. Generic prefix handler ──────────────────────────────────────────
//    For any URL like /X/Y/... where X is NOT in controllerMap but Y IS,
//    dispatch to Y. This catches patterns like:
//    /quotations/add_quotation/5, /followups/add_followup, etc.
if (count($segments) >= 2 && !isset($controllerMap[$firstSegmentLower])) {
    $subKey = strtolower($segments[1]);
    if (isset($controllerMap[$subKey])) {
        $params = array_slice($segments, 2);
        dispatchController($controllerMap[$subKey], $params);
        return;
    }
}

// ── 2q. Handle CRM shortcut prefix URLs ─────────────────────────────────
//    e.g. /quotations → crm_quotations, /followups → crm_followup_list,
//    /sales_orders → crm_sales_order, /projects → crm_projects,
//    /tickets → support
$crmShortcuts = [
    'quotations'   => 'crm_quotations',
    'followups'    => 'crm_followup_list',
    'sales_orders' => 'crm_sales_order',
    'sales_company'=> 'crm_leads',
    'projects'     => 'crm_projects',
    'tickets'      => 'support',
];
if (isset($crmShortcuts[$firstSegmentLower])) {
    $targetKey = $crmShortcuts[$firstSegmentLower];
    if (isset($controllerMap[$targetKey])) {
        $params = array_slice($segments, 1);
        dispatchController($controllerMap[$targetKey], $params);
        return;
    }
}

// ── 2r. Handle settings shortcut prefix URLs ────────────────────────────
//    e.g. /general_settings/company_type → General_settings with 'company_type'
//    /user_settings/manage_users → User_settings with 'manage_users'
//    /presales_settings/lead_source → Settings_master with 'lead_source'
//    /twxrm_report/sales_report → Report_view with 'sales_report'
//    /twxrm_dashboard/sales_dashboard → Dashboard_activity with 'sales_dashboard'
$settingsShortcutPrefixes = [
    'general_settings'   => ['file' => 'Settings.php', 'class' => 'General_settings'],
    'user_settings'      => ['file' => 'Settings.php', 'class' => 'User_settings'],
    'css_settings'       => ['file' => 'Settings.php', 'class' => 'Css_settings'],
    'presales_settings'  => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'order_settings'     => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'pm_settings'        => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'support_settings'   => ['file' => 'Settings.php', 'class' => 'Settings_master'],
    'twxrm_report'       => ['file' => 'Reports.php', 'class' => 'Report_view'],
    'twxrm_dashboard'    => ['file' => 'Crm.php', 'class' => 'Dashboard_activity'],
];
if (isset($settingsShortcutPrefixes[$firstSegmentLower]) && count($segments) >= 2) {
    $params = array_slice($segments, 1);
    dispatchController($settingsShortcutPrefixes[$firstSegmentLower], $params);
    return;
}

// ── 2s. Handle "esign/" prefix URLs ─────────────────────────────────────
if ($firstSegmentLower === 'esign' && count($segments) >= 2) {
    dispatchController($controllerMap['esign'], array_slice($segments, 1));
    return;
}

// ── 3. Exact match on first segment (case-sensitive first, then lowercase) ─
//    Handles nested patterns like:
//    company_officials/director_list/30/director_view/view_officials
//    → maps "company_officials" and passes remaining segments as params.
if ($firstSegment !== '') {
    // Try exact case first (for keys like "Lead_dashboard", "Sealings_*", etc.)
    if (isset($controllerMap[$firstSegment])) {
        $params = array_slice($segments, 1);
        dispatchController($controllerMap[$firstSegment], $params);
        return;
    }
    // Try lowercase
    if (isset($controllerMap[$firstSegmentLower])) {
        $params = array_slice($segments, 1);
        dispatchController($controllerMap[$firstSegmentLower], $params);
        return;
    }
}

// ── 4. Fallback: original /Controller/method/params routing ──────────────
$controllerName = !empty($segments[0]) ? ucfirst($segments[0]) : 'Welcome';
$method = !empty($segments[1]) ? $segments[1] : 'index';
$params = array_slice($segments, 2);

$controllerFile = APPPATH . 'controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName();

    if (method_exists($controller, $method) || method_exists($controller, '__call')) {
        call_user_func_array([$controller, $method], $params);
    } else {
        http_response_code(404);
        echo '404 - Method not found';
    }
} else {
    // Try lowercase filename
    $controllerFile = APPPATH . 'controllers/' . strtolower($controllerName) . '.php';
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $className = ucfirst(strtolower($controllerName));
        $controller = new $className();
        if (method_exists($controller, $method) || method_exists($controller, '__call')) {
            call_user_func_array([$controller, $method], $params);
        } else {
            http_response_code(404);
            echo '404 - Method not found';
        }
    } else {
        http_response_code(404);
        echo '404 - Controller not found';
    }
}
