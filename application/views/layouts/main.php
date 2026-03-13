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
    <!-- Modern Theme (Rillet AI ERP + Glassmorphism) -->
    <link href="<?= base_url('public/css/modern-theme.css') ?>?v=<?= time() ?>" rel="stylesheet">
</head>

<?php
    $uri_path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
    $uri_segments = $uri_path ? explode('/', $uri_path) : [];
    $current_url = $uri_segments[0] ?? '';
    $current_url2 = $uri_segments[1] ?? '';

    // Include SVG icon helpers
    include_once APPPATH . 'views/partials/sidebar_icons.php';

    // User info
    $user_name = isset($current_user->name) ? $current_user->name : 'Admin';
    $user_role = isset($current_user->role) ? $current_user->role : 'Administrator';
    $user_initials = strtoupper(substr($user_name, 0, 1) . (strpos($user_name, ' ') !== false ? substr($user_name, strpos($user_name, ' ') + 1, 1) : ''));
?>

<body class="nav-md modern-theme">
<div class="container body">
    <div class="main_container">

        <!-- LEFT SIDEBAR - Light Theme with SVG Icons -->
        <style>
            #modernSidebar .cf-nav-icon {
                display: inline-flex !important;
                width: 22px !important;
                height: 20px !important;
                align-items: center !important;
                justify-content: center !important;
                margin-right: 10px !important;
                flex-shrink: 0 !important;
                vertical-align: middle !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            #modernSidebar .cf-nav-icon svg {
                display: inline-block !important;
                width: 20px !important;
                height: 20px !important;
                stroke: #6B7280 !important;
                fill: none !important;
                visibility: visible !important;
                opacity: 1 !important;
                overflow: visible !important;
            }
            #modernSidebar .nav.side-menu > li.active > a .cf-nav-icon svg {
                stroke: #fff !important;
                filter: brightness(0) invert(1) !important;
            }
            #modernSidebar .nav.side-menu > li.active > a .cf-nav-icon svg *,
            #modernSidebar .nav.side-menu > li.active > a .cf-nav-icon svg path,
            #modernSidebar .nav.side-menu > li.active > a .cf-nav-icon svg rect,
            #modernSidebar .nav.side-menu > li.active > a .cf-nav-icon svg circle,
            #modernSidebar .nav.side-menu > li.active > a .cf-nav-icon svg line,
            #modernSidebar .nav.side-menu > li.active > a .cf-nav-icon svg polyline {
                stroke: #fff !important;
            }
            #modernSidebar .nav.side-menu > li > a {
                display: flex !important;
                align-items: center !important;
                color: #111827 !important;
                font-weight: 500 !important;
            }
            #modernSidebar .nav.side-menu > li.active > a {
                color: #fff !important;
            }
        </style>
        <div class="col-md-3 left_col" id="modernSidebar">
            <div class="left_col scroll-view">
                <!-- CF Logo Badge -->
                <div class="navbar nav_title" style="border: 0;">
                    <a href="<?= base_url('dashboard') ?>" class="site_title cf-logo-link">
                        <span class="cf-logo-badge">CF</span>
                        <span class="cf-logo-text">CorpFile</span>
                    </a>
                </div>

                <div class="clearfix"></div>

                <!-- Sidebar Menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <ul class="nav side-menu">

                            <!-- 1. Assistant -->
                            <li class="<?= ($current_url == 'chats') ? 'active' : '' ?>">
                                <a href="<?= base_url('chats') ?>">
                                    <span class="cf-nav-icon"><?= cf_icon('chat') ?></span>
                                    <span>Assistant</span>
                                </a>
                            </li>

                            <!-- 2. Dashboard -->
                            <li class="<?= ($current_url == 'dashboard') ? 'active' : '' ?>">
                                <a href="<?= base_url('dashboard') ?>">
                                    <span class="cf-nav-icon"><?= cf_icon('dashboard') ?></span>
                                    <span>Dashboard</span>
                                </a>
                            </li>

                            <!-- 3. Company Records (expandable) -->
                            <li class="<?= in_array($current_url, ['member','company_list','pre_company','post_company','Company_officials','corporate_shareholder','settings','Sealings','mainadmin']) ? 'active' : '' ?>">
                                <a>
                                    <span class="cf-nav-icon"><?= cf_icon('company') ?></span>
                                    <span>Company Records</span>
                                    <span class="cf-chevron"><?= cf_icon('chevron_down', 14) ?></span>
                                </a>
                                <ul class="nav child_menu">
                                    <li class="<?= ($current_url == 'member') ? 'active' : '' ?>">
                                        <a href="<?= base_url('member') ?>">Individuals</a>
                                    </li>
                                    <li class="<?= ($current_url == 'company_list') ? 'active' : '' ?>">
                                        <a href="<?= base_url('company_list') ?>">Companies</a>
                                    </li>
                                    <li class="<?= ($current_url == 'Company_officials' && $current_url2 == 'company_officials_list') ? 'active' : '' ?>">
                                        <a href="<?= base_url('Company_officials/company_officials_list') ?>">Director Records</a>
                                    </li>
                                    <li class="<?= ($current_url == 'corporate_shareholder') ? 'active' : '' ?>">
                                        <a href="<?= base_url('corporate_shareholder/corp_share_comp_list') ?>">Shareholder Records</a>
                                    </li>
                                    <li class="<?= ($current_url == 'pre_company') ? 'active' : '' ?>">
                                        <a href="<?= base_url('pre_company') ?>">Pre-Incorporation</a>
                                    </li>
                                    <li class="<?= ($current_url == 'post_company') ? 'active' : '' ?>">
                                        <a href="<?= base_url('post_company') ?>">Post-Incorporation</a>
                                    </li>
                                    <li class="<?= ($current_url == 'registers' && $current_url2 == 'register_of_charges') ? 'active' : '' ?>">
                                        <a href="<?= base_url('registers/register_of_charges') ?>">Charges</a>
                                    </li>
                                    <li class="<?= ($current_url == 'Sealings') ? 'active' : '' ?>">
                                        <a href="<?= base_url('Sealings/sealings_list') ?>">Sealings</a>
                                    </li>
                                    <li class="<?= ($current_url == 'mainadmin' && $current_url2 == 'company_bank') ? 'active' : '' ?>">
                                        <a href="<?= base_url('mainadmin/company_bank') ?>">Company Bank</a>
                                    </li>
                                </ul>
                            </li>

                            <!-- 4. Documents -->
                            <li class="<?= in_array($current_url, ['alldocuments','company_file','esign']) ? 'active' : '' ?>">
                                <a>
                                    <span class="cf-nav-icon"><?= cf_icon('documents') ?></span>
                                    <span>Documents</span>
                                    <span class="cf-chevron"><?= cf_icon('chevron_down', 14) ?></span>
                                </a>
                                <ul class="nav child_menu">
                                    <li class="<?= ($current_url == 'alldocuments') ? 'active' : '' ?>">
                                        <a href="<?= base_url('alldocuments') ?>">All Documents</a>
                                    </li>
                                    <li class="<?= ($current_url == 'company_file') ? 'active' : '' ?>">
                                        <a href="<?= base_url('company_file') ?>">Generate Templates</a>
                                    </li>
                                    <li class="<?= ($current_url == 'esign') ? 'active' : '' ?>">
                                        <a href="<?= base_url('esign/manage') ?>">eSign Documents</a>
                                    </li>
                                </ul>
                            </li>

                            <!-- 5. Registration -->
                            <li class="<?= ($current_url == 'add_company') ? 'active' : '' ?>">
                                <a href="<?= base_url('add_company') ?>">
                                    <span class="cf-nav-icon"><?= cf_icon('registration') ?></span>
                                    <span>Registration</span>
                                </a>
                            </li>

                            <!-- 7. Events & Alerts -->
                            <li class="<?= in_array($current_url, ['company_agm','duedatetracker']) ? 'active' : '' ?>">
                                <a>
                                    <span class="cf-nav-icon"><?= cf_icon('events') ?></span>
                                    <span>Events & Alerts</span>
                                    <span class="cf-badge-count">5</span>
                                    <span class="cf-chevron"><?= cf_icon('chevron_down', 14) ?></span>
                                </a>
                                <ul class="nav child_menu">
                                    <li class="<?= ($current_url == 'company_agm') ? 'active' : '' ?>">
                                        <a href="<?= base_url('company_agm/company_agm_list') ?>">Events</a>
                                    </li>
                                    <li class="<?= ($current_url == 'duedatetracker') ? 'active' : '' ?>">
                                        <a href="<?= base_url('duedatetracker') ?>">Due Date Tracker</a>
                                    </li>
                                </ul>
                            </li>

                            <!-- 8. Projects (expandable, includes Workflow) -->
                            <li class="<?= in_array($current_url, ['projects','tasks','timesheet','workflow']) ? 'active' : '' ?>">
                                <a>
                                    <span class="cf-nav-icon"><?= cf_icon('projects') ?></span>
                                    <span>Projects</span>
                                    <span class="cf-chevron"><?= cf_icon('chevron_down', 14) ?></span>
                                </a>
                                <ul class="nav child_menu">
                                    <li class="<?= ($current_url == 'workflow') ? 'active' : '' ?>">
                                        <a href="<?= base_url('workflow') ?>">Workflow (SOP)</a>
                                    </li>
                                    <li class="<?= ($current_url == 'tasks') ? 'active' : '' ?>">
                                        <a href="<?= base_url('tasks') ?>">Tasks</a>
                                    </li>
                                    <li class="<?= ($current_url == 'timesheet') ? 'active' : '' ?>">
                                        <a href="<?= base_url('timesheet') ?>">Timesheet</a>
                                    </li>
                                </ul>
                            </li>

                            <!-- Divider -->
                            <li class="cf-nav-divider"></li>

                            <!-- 10. Agents -->
                            <li class="<?= ($current_url == 'agents') ? 'active' : '' ?>">
                                <a href="<?= base_url('agents') ?>">
                                    <span class="cf-nav-icon"><?= cf_icon('agents') ?></span>
                                    <span>Agents</span>
                                </a>
                            </li>

                            <!-- 11. Reports -->
                            <li class="<?= ($current_url == 'report_module') ? 'active' : '' ?>">
                                <a href="<?= base_url('report_module/default_report') ?>">
                                    <span class="cf-nav-icon"><?= cf_icon('reports') ?></span>
                                    <span>Reports</span>
                                </a>
                            </li>

                            <!-- 12. Registers -->
                            <li class="<?= ($current_url == 'registers') ? 'active' : '' ?>">
                                <a>
                                    <span class="cf-nav-icon"><?= cf_icon('registers') ?></span>
                                    <span>Registers</span>
                                    <span class="cf-chevron"><?= cf_icon('chevron_down', 14) ?></span>
                                </a>
                                <ul class="nav child_menu">
                                    <li><a href="<?= base_url('registers/register_of_members') ?>">Members</a></li>
                                    <li><a href="<?= base_url('registers/register_of_directors') ?>">Directors</a></li>
                                    <li><a href="<?= base_url('registers/register_of_secretaries') ?>">Secretaries</a></li>
                                    <li><a href="<?= base_url('registers/register_of_charges') ?>">Charges</a></li>
                                    <li><a href="<?= base_url('registers/register_of_controllers') ?>">Controllers</a></li>
                                    <li><a href="<?= base_url('registers/register_of_beneficial_owners') ?>">Beneficial Owners</a></li>
                                    <li><a href="<?= base_url('registers/share_certificate') ?>">Share Certificate</a></li>
                                    <li><a href="<?= base_url('registers/annual_return') ?>">Annual Return</a></li>
                                </ul>
                            </li>

                            <!-- 13. Sales -->
                            <li class="<?= in_array($current_url, ['leads','quotations','followups','sales_orders','sales_company']) ? 'active' : '' ?>">
                                <a>
                                    <span class="cf-nav-icon"><?= cf_icon('sales') ?></span>
                                    <span>Sales</span>
                                    <span class="cf-chevron"><?= cf_icon('chevron_down', 14) ?></span>
                                </a>
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
                                </ul>
                            </li>

                            <!-- 14. Admin -->
                            <li class="<?= in_array($current_url, ['general_settings','user_settings','css_settings','presales_settings','order_settings','pm_settings','support_settings']) ? 'active' : '' ?>">
                                <a>
                                    <span class="cf-nav-icon"><?= cf_icon('admin') ?></span>
                                    <span>Admin</span>
                                    <span class="cf-badge-count">2</span>
                                    <span class="cf-chevron"><?= cf_icon('chevron_down', 14) ?></span>
                                </a>
                                <ul class="nav child_menu">
                                    <li><a href="<?= base_url('general_settings/company_type') ?>">General Settings</a></li>
                                    <li><a href="<?= base_url('user_settings/manage_users') ?>">Users</a></li>
                                    <li><a href="<?= base_url('css_settings/theme_color') ?>">Appearance</a></li>
                                    <li><a href="<?= base_url('presales_settings/lead_source') ?>">Pre-Sales</a></li>
                                    <li><a href="<?= base_url('order_settings/order_status') ?>">Orders</a></li>
                                    <li><a href="<?= base_url('pm_settings/project_status') ?>">Project Mgmt</a></li>
                                    <li><a href="<?= base_url('support_settings/ticket_status') ?>">Support</a></li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>
                <!-- /sidebar menu -->

                <!-- Sidebar User Profile Footer -->
                <div class="sidebar-footer hidden-small">
                    <div class="cf-sidebar-user">
                        <div class="cf-user-avatar"><?= $user_initials ?></div>
                        <div class="cf-user-info">
                            <div class="cf-user-name"><?= htmlspecialchars($user_name) ?></div>
                            <div class="cf-user-role"><?= htmlspecialchars($user_role) ?></div>
                        </div>
                        <a href="<?= base_url('general_settings/company_type') ?>" class="cf-user-settings" title="Settings">
                            <?= cf_icon('settings', 16) ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /LEFT SIDEBAR -->

        <!-- TOP NAVIGATION - Minimal -->
        <div class="top_nav">
            <div class="nav_menu">
                <div class="nav toggle">
                    <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>

                <!-- Spacer pushes items to the right -->
                <div style="flex:1;"></div>

                <!-- Minimal Topbar: Search + Bell + Avatar -->
                <div class="cf-topbar-actions">
                    <!-- Search -->
                    <div class="cf-topbar-search">
                        <span class="cf-topbar-search-icon"><?= cf_icon('search', 16) ?></span>
                        <input type="text" id="globalSearch" placeholder="Search..." class="cf-topbar-search-input">
                    </div>

                    <!-- Notification Bell -->
                    <div class="dropdown cf-topbar-bell">
                        <a href="javascript:;" class="dropdown-toggle cf-topbar-icon-btn" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                            <?= cf_icon('bell', 18) ?>
                            <span class="cf-notif-dot" id="notification_count"><?= isset($notification_count) ? $notification_count : '0' ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1" id="notification_list">
                            <li class="nav-item">
                                <div class="text-center">
                                    <a href="<?= base_url('notifications') ?>">
                                        <strong>See All Notifications</strong>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- User Avatar -->
                    <div class="dropdown cf-topbar-user">
                        <a href="javascript:;" class="dropdown-toggle cf-topbar-avatar-btn" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                            <span class="cf-topbar-avatar"><?= $user_initials ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-usermenu" aria-labelledby="navbarDropdown">
                            <li><a href="<?= base_url('my_profile') ?>"><i class="fa fa-user pull-right"></i> My Profile</a></li>
                            <li><a href="<?= base_url('general_settings/company_type') ?>"><i class="fa fa-building pull-right"></i> Company Profile</a></li>
                            <li><a href="<?= base_url('change_psd') ?>"><i class="fa fa-key pull-right"></i> Change Password</a></li>
                            <li><a href="<?= base_url('welcome/logout') ?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                        </ul>
                    </div>
                </div>
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
                Powered by <a href="javascript:;" style="color:var(--cf-accent); font-weight:500;">CorpFile</a> &copy; <?= date('Y') ?>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /FOOTER -->

    </div>
</div>

<!-- AI FAB + Drawer removed — use Assistant page or Agents page instead -->

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

<script>
/* ── Modern Theme JS ──────────────────────────────────────── */
const BASE_URL = "<?= base_url() ?>";

$(document).ready(function () {
    /* Fullscreen toggle */
    $('#fullscreen_toggle').on('click', function () {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen?.() ||
            document.documentElement.webkitRequestFullscreen?.() ||
            document.documentElement.mozRequestFullScreen?.();
        } else {
            document.exitFullscreen?.() ||
            document.webkitExitFullscreen?.() ||
            document.mozCancelFullScreen?.();
        }
    });

    /* Mobile sidebar toggle */
    $('#menu_toggle').on('click', function() {
        var sidebar = document.getElementById('modernSidebar');
        sidebar.classList.toggle('show-sidebar');
    });

    /* Smooth page-load animation */
    document.querySelectorAll('.kpi-card, .alert-item, .x_panel').forEach(function(el, i) {
        el.classList.add('animate-in');
        el.style.animationDelay = (i * 0.04) + 's';
    });
});

/* ── AI Response Action Buttons ── */
function cfMakeActionBar(rawText, redoCallback) {
    var bar = document.createElement('div');
    bar.className = 'cf-ai-actions';

    /* Copy */
    var copyBtn = document.createElement('button');
    copyBtn.className = 'cf-ai-action-btn';
    copyBtn.title = 'Copy';
    copyBtn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>';
    copyBtn.addEventListener('click', function() {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(rawText).then(function() {
                copyBtn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
                setTimeout(function() {
                    copyBtn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>';
                }, 1500);
            });
        }
    });

    /* Upvote */
    var upBtn = document.createElement('button');
    upBtn.className = 'cf-ai-action-btn';
    upBtn.title = 'Good response';
    upBtn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/></svg>';
    upBtn.addEventListener('click', function() {
        upBtn.style.color = '#22c55e';
        downBtn.style.color = '';
    });

    /* Downvote */
    var downBtn = document.createElement('button');
    downBtn.className = 'cf-ai-action-btn';
    downBtn.title = 'Bad response';
    downBtn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"/></svg>';
    downBtn.addEventListener('click', function() {
        downBtn.style.color = '#ef4444';
        upBtn.style.color = '';
    });

    /* Redo */
    var redoBtn = document.createElement('button');
    redoBtn.className = 'cf-ai-action-btn';
    redoBtn.title = 'Regenerate';
    redoBtn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>';
    if (typeof redoCallback === 'function') {
        redoBtn.addEventListener('click', redoCallback);
    }

    bar.appendChild(copyBtn);
    bar.appendChild(upBtn);
    bar.appendChild(downBtn);
    bar.appendChild(redoBtn);
    return bar;
}

/* ── Markdown renderer (shared, supports tables/hr/blockquotes) ── */
function cfRenderMarkdown(text) {
    /* 1. Extract code blocks first to protect them */
    var codeBlocks = [];
    text = text.replace(/```([\s\S]*?)```/g, function(m, code) {
        codeBlocks.push(code);
        return '%%CODEBLOCK' + (codeBlocks.length - 1) + '%%';
    });

    /* 2. Escape HTML */
    text = text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');

    /* 3. Tables: detect lines with pipes */
    text = text.replace(/((?:^[ \t]*\|.+\|[ \t]*$\n?)+)/gm, function(tableBlock) {
        var rows = tableBlock.trim().split('\n');
        if (rows.length < 2) return tableBlock;

        var html = '<table style="border-collapse:collapse;width:100%;margin:8px 0;font-size:13px">';
        var isHeader = true;
        for (var i = 0; i < rows.length; i++) {
            var row = rows[i].trim();
            if (!row) continue;
            /* Skip separator row (|---|---| or |:---:|) */
            if (/^\|[\s\-:]+\|$/.test(row) || /^\|(\s*:?-+:?\s*\|)+$/.test(row)) {
                isHeader = false;
                continue;
            }
            var cells = row.split('|').filter(function(c, idx, arr) { return idx > 0 && idx < arr.length - 1; });
            var tag = (i === 0) ? 'th' : 'td';
            var bgStyle = (i === 0) ? 'background:#f1f5f9;font-weight:600;' : '';
            html += '<tr>';
            for (var j = 0; j < cells.length; j++) {
                html += '<' + tag + ' style="' + bgStyle + 'border:1px solid #e2e8f0;padding:6px 10px;text-align:left">' + cells[j].trim() + '</' + tag + '>';
            }
            html += '</tr>';
        }
        html += '</table>';
        return html;
    });

    /* 4. Horizontal rules */
    text = text.replace(/^-{3,}$/gm, '<hr style="border:none;border-top:1px solid #e2e8f0;margin:12px 0">');

    /* 5. Inline formatting */
    text = text.replace(/`([^`]+)`/g, '<code style="background:#f4f5f7;padding:1px 5px;border-radius:3px;font-size:12px">$1</code>');
    text = text.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
    text = text.replace(/\*(.+?)\*/g, '<em>$1</em>');

    /* 6. Headings */
    text = text.replace(/^### (.+)$/gm, '<h5 style="margin:8px 0 4px;font-size:13px;font-weight:700">$1</h5>');
    text = text.replace(/^## (.+)$/gm, '<h4 style="margin:10px 0 4px;font-size:14px;font-weight:700">$1</h4>');
    text = text.replace(/^# (.+)$/gm, '<h3 style="margin:10px 0 6px;font-size:15px;font-weight:700">$1</h3>');

    /* 7. Blockquotes */
    text = text.replace(/^&gt;\s?(.+)$/gm, '<div style="border-left:3px solid #cbd5e1;padding:4px 12px;margin:6px 0;color:#475569;background:#f8fafc">$1</div>');

    /* 8. Lists */
    text = text.replace(/^\d+\.\s+(.+)$/gm, '<li style="margin-left:16px;list-style:decimal">$1</li>');
    text = text.replace(/^[-•]\s+(.+)$/gm, '<li style="margin-left:16px;list-style:disc">$1</li>');

    /* 9. Newlines → <br>, but clean up around block elements */
    text = text.replace(/\n/g, '<br>');
    text = text.replace(/<br>\s*(<h[345])/g, '$1').replace(/(<\/h[345]>)\s*<br>/g, '$1');
    text = text.replace(/<br>\s*(<table)/g, '$1').replace(/(<\/table>)\s*<br>/g, '$1');
    text = text.replace(/<br>\s*(<hr)/g, '$1').replace(/(margin:12px 0">)\s*<br>/g, '$1');
    text = text.replace(/<br>\s*(<div style="border-left)/g, '$1').replace(/(<\/div>)\s*<br>/g, '$1');
    text = text.replace(/<br>\s*(%%CODEBLOCK)/g, '$1').replace(/(%%CODEBLOCK\d+%%)\s*<br>/g, '$1');

    /* 10. Restore code blocks */
    text = text.replace(/%%CODEBLOCK(\d+)%%/g, function(m, idx) {
        return '<pre style="background:#f4f5f7;padding:10px;border-radius:6px;font-size:12px;overflow-x:auto;margin:6px 0;white-space:pre-wrap"><code>' + codeBlocks[parseInt(idx)] + '</code></pre>';
    });

    return text;
}
/* Aliases for backward compat */
var renderMd = cfRenderMarkdown;

/* AI Agent Drawer removed — use Assistant page or Agents page instead */

function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text);
    }
}

/* Fix sidebar icon colors for active items (white on navy) */
(function(){
    var activeItems = document.querySelectorAll('.nav.side-menu > li.active > a .cf-nav-icon svg');
    for (var i = 0; i < activeItems.length; i++) {
        activeItems[i].style.stroke = '#fff';
    }
})();
</script>

</body>
</html>
