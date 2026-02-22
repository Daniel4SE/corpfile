<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($page_title) ? $page_title . ' | ' : '' ?>CorpFile</title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url('public/images/favicon.png') ?>"/>

    <!-- Bootstrap -->
    <link href="<?= base_url('public/vendors/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= base_url('public/vendors/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?= base_url('public/vendors/nprogress/nprogress.css') ?>" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?= base_url('public/vendors/iCheck/skins/flat/green.css') ?>" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="<?= base_url('public/vendors/bootstrap-daterangepicker/daterangepicker.css') ?>" rel="stylesheet">
    <!-- Select2 -->
    <link href="<?= base_url('public/vendors/select2/dist/css/select2.min.css') ?>" rel="stylesheet">
    <!-- FullCalendar -->
    <link href="<?= base_url('public/vendors/fullcalendar/dist/fullcalendar.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/vendors/fullcalendar/dist/fullcalendar.print.min.css') ?>" rel="stylesheet" media="print">
    <!-- bootstrap-wysiwyg -->
    <link href="<?= base_url('public/vendors/google-code-prettify/bin/prettify.min.css') ?>" rel="stylesheet">
    <!-- Switchery -->
    <link href="<?= base_url('public/vendors/switchery/dist/switchery.min.css') ?>" rel="stylesheet">
    <!-- SweetAlert -->
    <link href="<?= base_url('public/vendors/sweetalert/dist/sweetalert.css') ?>" rel="stylesheet">
    <!-- Datatables -->
    <link href="<?= base_url('public/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>" rel="stylesheet">
    <!-- PNotify -->
    <link href="<?= base_url('public/vendors/pnotify/dist/pnotify.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/vendors/pnotify/dist/pnotify.buttons.css') ?>" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?= base_url('public/css/custom.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/css/custom.css') ?>" rel="stylesheet">
</head>

<?php
    $uri_path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
    $uri_segments = $uri_path ? explode('/', $uri_path) : [];
    $current_url = $uri_segments[0] ?? '';
    $current_url2 = $uri_segments[1] ?? '';
?>

<body class="nav-md">
<div class="container body">
    <div class="main_container">

        <!-- LEFT SIDEBAR -->
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="<?= base_url('dashboard') ?>" class="site_title">
                        <img src="<?= base_url('public/images/corpfile-logo.png') ?>" alt="CorpFile" style="max-height:55px;max-width:180px;margin-top:2px;">
                    </a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile_pic">
                        <img src="<?= base_url('public/images/user.png') ?>" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
                        <h2><?= isset($current_user->name) ? $current_user->name : 'Admin' ?></h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <h3>General</h3>
                        <ul class="nav side-menu">

                            <!-- 1. Dashboard -->
                            <li class="<?= ($current_url == 'dashboard') ? 'active' : '' ?>">
                                <a href="<?= base_url('dashboard') ?>">
                                    <i class="fa fa-tachometer"></i> Dashboard
                                </a>
                            </li>

                            <!-- 2. Company Registration -->
                            <li class="<?= ($current_url == 'add_company') ? 'active' : '' ?>">
                                <a href="<?= base_url('add_company') ?>">
                                    <i class="fa fa-building"></i> Company Registration
                                </a>
                            </li>

                            <!-- 3. Records -->
                            <li class="<?= in_array($current_url, ['member','company_list','pre_company','post_company','Company_officials','corporate_shareholder','settings','Sealings','mainadmin']) ? 'active' : '' ?>">
                                <a><i class="fa fa-list"></i> Records <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="<?= ($current_url == 'member') ? 'active' : '' ?>">
                                        <a href="<?= base_url('member') ?>">Individuals</a>
                                    </li>
                                    <li class="<?= ($current_url == 'company_list') ? 'active' : '' ?>">
                                        <a href="<?= base_url('company_list') ?>">Companies</a>
                                    </li>
                                    <li class="<?= ($current_url == 'pre_company') ? 'active' : '' ?>">
                                        <a href="<?= base_url('pre_company') ?>">Pre-Incorporation</a>
                                    </li>
                                    <li class="<?= ($current_url == 'post_company') ? 'active' : '' ?>">
                                        <a href="<?= base_url('post_company') ?>">Post-Incorporation</a>
                                    </li>
                                    <li class="<?= ($current_url == 'Company_officials' && $current_url2 == 'company_officials_list') ? 'active' : '' ?>">
                                        <a href="<?= base_url('Company_officials/company_officials_list') ?>">Officials</a>
                                    </li>
                                    <li class="<?= ($current_url == 'corporate_shareholder') ? 'active' : '' ?>">
                                        <a href="<?= base_url('corporate_shareholder/corp_share_comp_list') ?>">Corporate Shareholders</a>
                                    </li>
                                    <li class="<?= ($current_url == 'settings' && $current_url2 == 'register_charge_list') ? 'active' : '' ?>">
                                        <a href="<?= base_url('settings/register_charge_list') ?>">Charges</a>
                                    </li>
                                    <li class="<?= ($current_url == 'Sealings') ? 'active' : '' ?>">
                                        <a href="<?= base_url('Sealings/sealings_list') ?>">Sealings</a>
                                    </li>
                                    <li class="<?= ($current_url == 'mainadmin' && $current_url2 == 'company_bank') ? 'active' : '' ?>">
                                        <a href="<?= base_url('mainadmin/company_bank') ?>">Company Bank</a>
                                    </li>
                                </ul>
                            </li>

                            <!-- 4. Event Tracker -->
                            <li class="<?= in_array($current_url, ['company_agm','duedatetracker']) ? 'active' : '' ?>">
                                <a><i class="fa fa-calendar"></i> Event Tracker <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="<?= ($current_url == 'company_agm') ? 'active' : '' ?>">
                                        <a href="<?= base_url('company_agm/company_agm_list') ?>">Event</a>
                                    </li>
                                    <li class="<?= ($current_url == 'duedatetracker') ? 'active' : '' ?>">
                                        <a href="<?= base_url('duedatetracker') ?>">Due Date Tracker</a>
                                    </li>
                                </ul>
                            </li>

                            <!-- 5. Templates -->
                            <li class="<?= in_array($current_url, ['company_file','esign']) ? 'active' : '' ?>">
                                <a><i class="fa fa-file"></i> Templates <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="<?= ($current_url == 'company_file') ? 'active' : '' ?>">
                                        <a href="<?= base_url('company_file') ?>">Generate Templates</a>
                                    </li>
                                    <li class="<?= ($current_url == 'esign') ? 'active' : '' ?>">
                                        <a href="<?= base_url('esign/manage') ?>">eSign Documents</a>
                                    </li>
                                </ul>
                            </li>

                            <!-- 6. Report -->
                            <li class="<?= ($current_url == 'report_module') ? 'active' : '' ?>">
                                <a><i class="fa fa-file-word-o"></i> Report <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="<?= ($current_url == 'report_module' && $current_url2 == 'default_report') ? 'active' : '' ?>">
                                        <a href="<?= base_url('report_module/default_report') ?>">Default Report</a>
                                    </li>
                                </ul>
                            </li>

                            <!-- 7. Document Management -->
                            <li class="<?= ($current_url == 'alldocuments') ? 'active' : '' ?>">
                                <a href="<?= base_url('alldocuments') ?>">
                                    <i class="fa fa-file"></i> Document Management
                                </a>
                            </li>

                            <!-- 8. Registers (23 sub-items) -->
                            <li class="<?= ($current_url == 'registers') ? 'active' : '' ?>">
                                <a><i class="fa fa-th"></i> Registers <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?= base_url('registers/register_of_members') ?>">Register of Members</a></li>
                                    <li><a href="<?= base_url('registers/register_of_directors') ?>">Register of Directors</a></li>
                                    <li><a href="<?= base_url('registers/register_of_secretaries') ?>">Register of Secretaries</a></li>
                                    <li><a href="<?= base_url('registers/register_of_charges') ?>">Register of Charges</a></li>
                                    <li><a href="<?= base_url('registers/register_of_debenture_holders') ?>">Register of Debenture Holders</a></li>
                                    <li><a href="<?= base_url('registers/register_of_auditors') ?>">Register of Auditors</a></li>
                                    <li><a href="<?= base_url('registers/register_of_nominee_directors') ?>">Register of Nominee Directors</a></li>
                                    <li><a href="<?= base_url('registers/register_of_substantial_shareholders') ?>">Register of Substantial Shareholders</a></li>
                                    <li><a href="<?= base_url('registers/register_of_directors_shareholdings') ?>">Register of Directors Shareholdings</a></li>
                                    <li><a href="<?= base_url('registers/register_of_transfers') ?>">Register of Transfers</a></li>
                                    <li><a href="<?= base_url('registers/register_of_allotments') ?>">Register of Allotments</a></li>
                                    <li><a href="<?= base_url('registers/register_of_seals') ?>">Register of Seals</a></li>
                                    <li><a href="<?= base_url('registers/register_of_applicants') ?>">Register of Applicants</a></li>
                                    <li><a href="<?= base_url('registers/register_of_controllers') ?>">Register of Controllers</a></li>
                                    <li><a href="<?= base_url('registers/register_of_beneficial_owners') ?>">Register of Beneficial Owners</a></li>
                                    <li><a href="<?= base_url('registers/register_of_nominee_shareholders') ?>">Register of Nominee Shareholders</a></li>
                                    <li><a href="<?= base_url('registers/minute_book_directors') ?>">Minute Book - Directors</a></li>
                                    <li><a href="<?= base_url('registers/minute_book_members') ?>">Minute Book - Members</a></li>
                                    <li><a href="<?= base_url('registers/share_certificate') ?>">Share Certificate</a></li>
                                    <li><a href="<?= base_url('registers/annual_return') ?>">Annual Return</a></li>
                                    <li><a href="<?= base_url('registers/register_of_depository_agents') ?>">Register of Depository Agents</a></li>
                                    <li><a href="<?= base_url('registers/register_of_managers') ?>">Register of Managers</a></li>
                                    <li><a href="<?= base_url('registers/register_of_partners') ?>">Register of Partners</a></li>
                                </ul>
                            </li>

                            <!-- 9. General Settings (19 sub-items) -->
                            <li class="<?= ($current_url == 'general_settings') ? 'active' : '' ?>">
                                <a><i class="fa fa-cog"></i> General Settings <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?= base_url('general_settings/company_type') ?>">Company Type</a></li>
                                    <li><a href="<?= base_url('general_settings/company_status') ?>">Company Status</a></li>
                                    <li><a href="<?= base_url('general_settings/company_category') ?>">Company Category</a></li>
                                    <li><a href="<?= base_url('general_settings/designation') ?>">Designation</a></li>
                                    <li><a href="<?= base_url('general_settings/share_type') ?>">Share Type</a></li>
                                    <li><a href="<?= base_url('general_settings/currency') ?>">Currency</a></li>
                                    <li><a href="<?= base_url('general_settings/country') ?>">Country</a></li>
                                    <li><a href="<?= base_url('general_settings/state') ?>">State</a></li>
                                    <li><a href="<?= base_url('general_settings/city') ?>">City</a></li>
                                    <li><a href="<?= base_url('general_settings/race') ?>">Race</a></li>
                                    <li><a href="<?= base_url('general_settings/religion') ?>">Religion</a></li>
                                    <li><a href="<?= base_url('general_settings/id_type') ?>">ID Type</a></li>
                                    <li><a href="<?= base_url('general_settings/salutation') ?>">Salutation</a></li>
                                    <li><a href="<?= base_url('general_settings/relationship') ?>">Relationship</a></li>
                                    <li><a href="<?= base_url('general_settings/nature_of_business') ?>">Nature of Business</a></li>
                                    <li><a href="<?= base_url('general_settings/document_type') ?>">Document Type</a></li>
                                    <li><a href="<?= base_url('general_settings/tax_settings') ?>">Tax Settings</a></li>
                                    <li><a href="<?= base_url('general_settings/email_template') ?>">Email Template</a></li>
                                    <li><a href="<?= base_url('general_settings/notification_settings') ?>">Notification Settings</a></li>
                                </ul>
                            </li>

                            <!-- 10. User Settings (8 sub-items) -->
                            <li class="<?= ($current_url == 'user_settings') ? 'active' : '' ?>">
                                <a><i class="fa fa-cog"></i> User Settings <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?= base_url('user_settings/manage_users') ?>">Manage Users</a></li>
                                    <li><a href="<?= base_url('user_settings/manage_roles') ?>">Manage Roles</a></li>
                                    <li><a href="<?= base_url('user_settings/manage_permissions') ?>">Manage Permissions</a></li>
                                    <li><a href="<?= base_url('user_settings/user_group') ?>">User Group</a></li>
                                    <li><a href="<?= base_url('user_settings/user_branch') ?>">User Branch</a></li>
                                    <li><a href="<?= base_url('user_settings/user_department') ?>">User Department</a></li>
                                    <li><a href="<?= base_url('user_settings/login_history') ?>">Login History</a></li>
                                    <li><a href="<?= base_url('user_settings/activity_log') ?>">Activity Log</a></li>
                                </ul>
                            </li>

                            <!-- 11. CSS Settings (5 sub-items) -->
                            <li class="<?= ($current_url == 'css_settings') ? 'active' : '' ?>">
                                <a><i class="fa fa-cog"></i> CSS Settings <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?= base_url('css_settings/theme_color') ?>">Theme Color</a></li>
                                    <li><a href="<?= base_url('css_settings/logo_settings') ?>">Logo Settings</a></li>
                                    <li><a href="<?= base_url('css_settings/favicon_settings') ?>">Favicon Settings</a></li>
                                    <li><a href="<?= base_url('css_settings/login_page') ?>">Login Page</a></li>
                                    <li><a href="<?= base_url('css_settings/custom_css') ?>">Custom CSS</a></li>
                                </ul>
                            </li>

                            <!-- 12. Pre Sales Settings (7 sub-items) -->
                            <li class="<?= ($current_url == 'presales_settings') ? 'active' : '' ?>">
                                <a><i class="fa fa-cog"></i> Pre Sales Settings <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?= base_url('presales_settings/lead_source') ?>">Lead Source</a></li>
                                    <li><a href="<?= base_url('presales_settings/lead_status') ?>">Lead Status</a></li>
                                    <li><a href="<?= base_url('presales_settings/lead_category') ?>">Lead Category</a></li>
                                    <li><a href="<?= base_url('presales_settings/industry_type') ?>">Industry Type</a></li>
                                    <li><a href="<?= base_url('presales_settings/follow_up_type') ?>">Follow Up Type</a></li>
                                    <li><a href="<?= base_url('presales_settings/quotation_terms') ?>">Quotation Terms</a></li>
                                    <li><a href="<?= base_url('presales_settings/service_list') ?>">Service List</a></li>
                                </ul>
                            </li>

                            <!-- 13. Order Processing Settings (2 sub-items) -->
                            <li class="<?= ($current_url == 'order_settings') ? 'active' : '' ?>">
                                <a><i class="fa fa-cog"></i> Order Processing Settings <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?= base_url('order_settings/order_status') ?>">Order Status</a></li>
                                    <li><a href="<?= base_url('order_settings/payment_terms') ?>">Payment Terms</a></li>
                                </ul>
                            </li>

                            <!-- 14. PM Settings (9 sub-items) -->
                            <li class="<?= ($current_url == 'pm_settings') ? 'active' : '' ?>">
                                <a><i class="fa fa-cog"></i> PM Settings <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?= base_url('pm_settings/project_status') ?>">Project Status</a></li>
                                    <li><a href="<?= base_url('pm_settings/project_category') ?>">Project Category</a></li>
                                    <li><a href="<?= base_url('pm_settings/task_status') ?>">Task Status</a></li>
                                    <li><a href="<?= base_url('pm_settings/task_priority') ?>">Task Priority</a></li>
                                    <li><a href="<?= base_url('pm_settings/task_category') ?>">Task Category</a></li>
                                    <li><a href="<?= base_url('pm_settings/activity_type') ?>">Activity Type</a></li>
                                    <li><a href="<?= base_url('pm_settings/activity_status') ?>">Activity Status</a></li>
                                    <li><a href="<?= base_url('pm_settings/milestone') ?>">Milestone</a></li>
                                    <li><a href="<?= base_url('pm_settings/timesheet_category') ?>">Timesheet Category</a></li>
                                </ul>
                            </li>

                            <!-- 15. Support Settings (4 sub-items) -->
                            <li class="<?= ($current_url == 'support_settings') ? 'active' : '' ?>">
                                <a><i class="fa fa-cog"></i> Support Settings <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?= base_url('support_settings/ticket_status') ?>">Ticket Status</a></li>
                                    <li><a href="<?= base_url('support_settings/ticket_priority') ?>">Ticket Priority</a></li>
                                    <li><a href="<?= base_url('support_settings/ticket_category') ?>">Ticket Category</a></li>
                                    <li><a href="<?= base_url('support_settings/ticket_department') ?>">Ticket Department</a></li>
                                </ul>
                            </li>

                            <!-- 16. TWXRM Report (7 sub-items) -->
                            <li class="<?= ($current_url == 'twxrm_report') ? 'active' : '' ?>">
                                <a><i class="fa fa-file-excel-o"></i> TWXRM Report <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?= base_url('twxrm_report/sales_report') ?>">Sales Report</a></li>
                                    <li><a href="<?= base_url('twxrm_report/lead_report') ?>">Lead Report</a></li>
                                    <li><a href="<?= base_url('twxrm_report/quotation_report') ?>">Quotation Report</a></li>
                                    <li><a href="<?= base_url('twxrm_report/order_report') ?>">Order Report</a></li>
                                    <li><a href="<?= base_url('twxrm_report/project_report') ?>">Project Report</a></li>
                                    <li><a href="<?= base_url('twxrm_report/task_report') ?>">Task Report</a></li>
                                    <li><a href="<?= base_url('twxrm_report/support_report') ?>">Support Report</a></li>
                                </ul>
                            </li>

                            <!-- 17. TWXRM Dashboard (6 sub-items) -->
                            <li class="<?= ($current_url == 'twxrm_dashboard') ? 'active' : '' ?>">
                                <a><i class="fa fa-tachometer"></i> TWXRM Dashboard <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?= base_url('twxrm_dashboard/sales_dashboard') ?>">Sales Dashboard</a></li>
                                    <li><a href="<?= base_url('twxrm_dashboard/lead_dashboard') ?>">Lead Dashboard</a></li>
                                    <li><a href="<?= base_url('twxrm_dashboard/project_dashboard') ?>">Project Dashboard</a></li>
                                    <li><a href="<?= base_url('twxrm_dashboard/task_dashboard') ?>">Task Dashboard</a></li>
                                    <li><a href="<?= base_url('twxrm_dashboard/support_dashboard') ?>">Support Dashboard</a></li>
                                    <li><a href="<?= base_url('twxrm_dashboard/overall_dashboard') ?>">Overall Dashboard</a></li>
                                </ul>
                            </li>

                            <!-- 18. Sales (5 sub-items) -->
                            <li class="<?= in_array($current_url, ['leads','quotations','followups','sales_orders','sales_company']) ? 'active' : '' ?>">
                                <a><i class="fa fa-line-chart"></i> Sales <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="<?= ($current_url == 'leads') ? 'active' : '' ?>">
                                        <a href="<?= base_url('leads') ?>">Leads</a>
                                    </li>
                                    <li class="<?= ($current_url == 'quotations') ? 'active' : '' ?>">
                                        <a href="<?= base_url('quotations') ?>">Quotations</a>
                                    </li>
                                    <li class="<?= ($current_url == 'followups') ? 'active' : '' ?>">
                                        <a href="<?= base_url('followups') ?>">Follow-ups</a>
                                    </li>
                                    <li class="<?= ($current_url == 'sales_orders') ? 'active' : '' ?>">
                                        <a href="<?= base_url('sales_orders') ?>">Sales Orders</a>
                                    </li>
                                    <li class="<?= ($current_url == 'sales_company') ? 'active' : '' ?>">
                                        <a href="<?= base_url('sales_company') ?>">Company</a>
                                    </li>
                                </ul>
                            </li>

                            <!-- 19. Projects (4 sub-items) -->
                            <li class="<?= in_array($current_url, ['projects','tasks','activities','timesheet']) ? 'active' : '' ?>">
                                <a><i class="fa fa-tasks"></i> Projects <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="<?= ($current_url == 'projects') ? 'active' : '' ?>">
                                        <a href="<?= base_url('projects') ?>">Projects</a>
                                    </li>
                                    <li class="<?= ($current_url == 'tasks') ? 'active' : '' ?>">
                                        <a href="<?= base_url('tasks') ?>">Tasks</a>
                                    </li>
                                    <li class="<?= ($current_url == 'activities') ? 'active' : '' ?>">
                                        <a href="<?= base_url('activities') ?>">Activities</a>
                                    </li>
                                    <li class="<?= ($current_url == 'timesheet') ? 'active' : '' ?>">
                                        <a href="<?= base_url('timesheet') ?>">Weekly Timesheet</a>
                                    </li>
                                </ul>
                            </li>

                            <!-- 20. Support (1 sub-item) -->
                            <li class="<?= ($current_url == 'tickets') ? 'active' : '' ?>">
                                <a><i class="fa fa-ticket"></i> Support <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="<?= ($current_url == 'tickets') ? 'active' : '' ?>">
                                        <a href="<?= base_url('tickets') ?>">Ticket Management</a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Settings" href="<?= base_url('general_settings/company_type') ?>">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen" id="fullscreen_toggle">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock" class="lock_btn" href="<?= base_url('auth/lock_screen') ?>">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?= base_url('welcome/logout') ?>">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>
        <!-- /LEFT SIDEBAR -->

        <!-- TOP NAVIGATION -->
        <div class="top_nav">
            <div class="nav_menu">
                <div class="nav toggle">
                    <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>

                <nav class="nav navbar-nav">
                    <ul class=" navbar-right">
                        <!-- User Profile Dropdown -->
                        <li class="nav-item dropdown" style="padding-left: 15px;">
                            <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                <img src="<?= base_url('public/images/user.png') ?>" alt="">
                                <?= isset($current_user->name) ? $current_user->name : 'Admin' ?>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                                <li><a href="<?= base_url('my_profile') ?>"><i class="fa fa-user pull-right"></i> My Profile</a></li>
                                <li><a href="<?= base_url('general_settings/company_type') ?>"><i class="fa fa-building pull-right"></i> Company Profile</a></li>
                                <li><a href="<?= base_url('change_psd') ?>"><i class="fa fa-key pull-right"></i> Change Password</a></li>
                                <li><a href="<?= base_url('welcome/logout') ?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                            </ul>
                        </li>

                        <!-- Notification Bell -->
                        <li role="presentation" class="nav-item dropdown">
                            <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell-o"></i>
                                <span class="badge bg-green" id="notification_count"><?= isset($notification_count) ? $notification_count : '0' ?></span>
                            </a>
                            <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1" id="notification_list">
                                <li class="nav-item">
                                    <div class="text-center">
                                        <a href="<?= base_url('notifications') ?>">
                                            <strong>See All Notifications</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>

                        <!-- Company / Client Label -->
                        <li class="nav-item" style="padding-right: 15px; display: flex; align-items: center;">
                            <?php if (isset($current_user->client_id)): ?>
                                <span class="label label-primary" style="font-size: 12px;">
                                    <i class="fa fa-building-o"></i> Client ID: <?= $current_user->client_id ?>
                                </span>
                            <?php endif; ?>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /TOP NAVIGATION -->

        <!-- PAGE CONTENT -->
        <div class="right_col" role="main">
            <?php if (isset($content_view)): ?>
                <?php include APPPATH . 'views/' . $content_view . '.php'; ?>
            <?php endif; ?>
        </div>
        <!-- /PAGE CONTENT -->

        <!-- FOOTER -->
        <footer>
            <div class="pull-right">
                Powered by <a href="javascript:;">CorpFile</a> &copy; <?= date('Y') ?>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /FOOTER -->

    </div>
</div>

<!-- jQuery -->
<script src="<?= base_url('public/vendors/jquery/dist/jquery.min.js') ?>"></script>
<!-- Bootstrap -->
<script src="<?= base_url('public/vendors/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<!-- FastClick -->
<script src="<?= base_url('public/vendors/fastclick/lib/fastclick.js') ?>"></script>
<!-- NProgress -->
<script src="<?= base_url('public/vendors/nprogress/nprogress.js') ?>"></script>
<!-- iCheck -->
<script src="<?= base_url('public/vendors/iCheck/icheck.min.js') ?>"></script>
<!-- Moment.js -->
<script src="<?= base_url('public/vendors/moment/min/moment.min.js') ?>"></script>
<!-- bootstrap-daterangepicker -->
<script src="<?= base_url('public/vendors/bootstrap-daterangepicker/daterangepicker.js') ?>"></script>
<!-- bootstrap-wysiwyg -->
<script src="<?= base_url('public/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js') ?>"></script>
<script src="<?= base_url('public/vendors/jquery.hotkeys/jquery.hotkeys.js') ?>"></script>
<script src="<?= base_url('public/vendors/google-code-prettify/src/prettify.js') ?>"></script>
<!-- Select2 -->
<script src="<?= base_url('public/vendors/select2/dist/js/select2.full.min.js') ?>"></script>
<!-- FullCalendar -->
<script src="<?= base_url('public/vendors/fullcalendar/dist/fullcalendar.min.js') ?>"></script>
<!-- SweetAlert -->
<script src="<?= base_url('public/vendors/sweetalert/dist/sweetalert.min.js') ?>"></script>
<!-- Datatables -->
<script src="<?= base_url('public/vendors/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('public/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>
<!-- PNotify -->
<script src="<?= base_url('public/vendors/pnotify/dist/pnotify.js') ?>"></script>
<script src="<?= base_url('public/vendors/pnotify/dist/pnotify.buttons.js') ?>"></script>
<!-- Custom Theme Scripts -->
<script src="<?= base_url('public/js/custom.min.js') ?>"></script>
<script src="<?= base_url('public/js/custom.js') ?>"></script>

<!-- Fullscreen Toggle -->
<script>
    $(document).ready(function () {
        $('#fullscreen_toggle').on('click', function () {
            if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.msRequestFullscreen) {
                    document.documentElement.msRequestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                }
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                }
            }
        });
    });
</script>

</body>
</html>
