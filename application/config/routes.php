<?php
/**
 * Route Configuration
 */

$routes = [
    ''                    => 'Welcome/index',
    'welcome'             => 'Welcome/index',
    'welcome/index'       => 'Welcome/index',
    'welcome/login'       => 'Welcome/login',
    'welcome/logout'      => 'Welcome/logout',
    'welcome/firebase_login' => 'Welcome/firebase_login',
    'welcome/forgot_password' => 'Welcome/forgot_password',
    'dashboard'           => 'Dashboard/index',
    'companies'           => 'Companies/index',
    'companies/add'       => 'Companies/add',
    'companies/edit'      => 'Companies/edit',
    'companies/view'      => 'Companies/view',
    'company_list'        => 'Company_list/index',
    'add_company'         => 'Add_company/index',
    'view_company/(:any)'  => 'View_company/index/$1',
    'edit_company/(:any)'  => 'Edit_company/index/$1',
    'directors'           => 'Directors/index',
    'shareholders'        => 'Shareholders/index',
    'secretary'           => 'Secretary/index',
    'contacts'            => 'Contacts/index',
    'notifications'       => 'Notifications/index',
    'users'               => 'Users/index',
    'settings'            => 'Settings/index',

    // Admin/User Management
    'alladmin'                     => 'Alladmin/index',
    'add_admin'                    => 'Add_admin/index',
    'edit_admin/(:any)'            => 'Edit_admin/index/$1',
    'page_access_rights/(:any)'    => 'Page_access_rights/index/$1',
    'user_groups'                  => 'User_groups/index',
    'add_user_group'               => 'Add_user_group/index',
    'edit_user_group/(:any)'       => 'Edit_user_group/index/$1',
    'user_groups_permissions'      => 'User_groups_permissions/index',
    'change_psd'                   => 'Change_psd/index',

    // CRM Detail Pages
    'crm_project_view/(:any)'      => 'Crm_project_view/index/$1',
    'crm_project_edit/(:any)'      => 'Crm_project_edit/index/$1',
    'crm_project_create'           => 'Crm_project_create/index',
    'crm_project_gantt'            => 'Crm_project_gantt/index',
    'crm_create_quotation'         => 'Crm_create_quotation/index',
    'crm_create_order'             => 'Crm_create_order/index',
    'crm_followup_list'            => 'Crm_followup_list/index',
    'crm_invoice_reconciliation'   => 'Crm_invoice_reconciliation/index',
    'crm_ticket_view/(:any)'       => 'Crm_ticket_view/index/$1',
    'dashboard_activity'           => 'Dashboard_activity/index',
    'dashboard_invoice'            => 'Dashboard_invoice/index',
    'dashboard_project'            => 'Dashboard_project/index',
    'dashboard_leads'              => 'Dashboard_leads/index',
    'dashboard_support'            => 'Dashboard_support/index',

    // Company Sub-pages
    'pre_company'                  => 'Pre_company/index',
    'post_company'                 => 'Post_company/index',
    'company_non_client'           => 'Company_non_client/index',
    'company_fee_list/(:any)'      => 'Company_fee_list/index/$1',
    'company_pdf/(:any)'           => 'Company_pdf/index/$1',

    // Reports
    'reports'                      => 'Reports/index',
    'css_reports'                  => 'Css_reports/index',
    'crm_reports'                  => 'Crm_reports/index',
    'report_view/(:any)'           => 'Report_view/index/$1',

    // Miscellaneous Pages
    'my_profile'                   => 'My_profile/index',
    'sealings_list'                => 'Sealings_list/index',
    'add_seal'                     => 'Add_seal/index',
    'company_bank'                 => 'Company_bank/index',
    'add_company_bank'             => 'Add_company_bank/index',
    'reminder_list'                => 'Reminder_list/index',
    'set_reminder'                 => 'Set_reminder/index',
    'edit_reminder/(:any)'         => 'Edit_reminder/index/$1',
    'esign_settings'               => 'Esign_settings/index',
    'esign_log'                    => 'Esign_log/index',
    'member_pdf/(:any)'            => 'Member_pdf/index/$1',
    'member_documents/(:any)'      => 'Member_documents/index/$1',
];
