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
    <link href="<?= base_url('public/css/modern-theme.css') ?>" rel="stylesheet">
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

                            <!-- 1. Chats -->
                            <li class="<?= ($current_url == 'chats') ? 'active' : '' ?>">
                                <a href="<?= base_url('chats') ?>">
                                    <span class="cf-nav-icon"><?= cf_icon('chat') ?></span>
                                    <span>Chats</span>
                                    <span class="cf-badge-count">3</span>
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

                            <!-- 6. EP/DP Management -->
                            <li class="<?= ($current_url == 'duedatetracker' && isset($_GET['type']) && $_GET['type'] == 'ep') ? 'active' : '' ?>">
                                <a href="<?= base_url('duedatetracker') ?>">
                                    <span class="cf-nav-icon"><?= cf_icon('ep_dp') ?></span>
                                    <span>EP/DP Management</span>
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

                            <!-- 8. Workflow (SOP) -->
                            <li class="<?= ($current_url == 'workflow') ? 'active' : '' ?>">
                                <a href="<?= base_url('workflow') ?>">
                                    <span class="cf-nav-icon"><?= cf_icon('workflow') ?></span>
                                    <span>Workflow (SOP)</span>
                                </a>
                            </li>

                            <!-- 9. Projects (expandable) -->
                            <li class="<?= in_array($current_url, ['projects','tasks','activities','timesheet']) ? 'active' : '' ?>">
                                <a>
                                    <span class="cf-nav-icon"><?= cf_icon('projects') ?></span>
                                    <span>Projects</span>
                                    <span class="cf-chevron"><?= cf_icon('chevron_down', 14) ?></span>
                                </a>
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
                                        <a href="<?= base_url('timesheet') ?>">Timesheet</a>
                                    </li>
                                </ul>
                            </li>

                            <!-- 10. Agents -->
                            <li class="<?= ($current_url == 'agents') ? 'active' : '' ?>">
                                <a href="<?= base_url('agents') ?>">
                                    <span class="cf-nav-icon"><?= cf_icon('agents') ?></span>
                                    <span>Agents</span>
                                </a>
                            </li>

                            <!-- Divider -->
                            <li class="cf-nav-divider"></li>

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

<!-- AI AGENT FLOATING BUTTON -->
<button class="ai-fab" id="aiFabBtn" onclick="toggleAIDrawer()" title="CorpFile AI Agent">
    <i class="fa fa-bolt"></i>
    <span class="pulse-ring"></span>
</button>

<!-- AI AGENT DRAWER OVERLAY -->
<div class="ai-drawer-overlay" id="aiOverlay" onclick="toggleAIDrawer()"></div>

<!-- AI AGENT DRAWER -->
<div class="ai-drawer" id="aiDrawer">
    <div class="ai-drawer-header">
        <div class="ai-badge">
            <span class="sparkle"><i class="fa fa-bolt"></i></span>
            CorpFile AI
        </div>
        <button class="ai-drawer-close" onclick="toggleAIDrawer()">
            <i class="fa fa-times"></i>
        </button>
    </div>

    <div class="ai-suggestion-chips">
        <button class="ai-chip" onclick="sendAIChip('Generate annual invoice for current clients')">Generate Invoice</button>
        <button class="ai-chip" onclick="sendAIChip('Fill IR8A form for selected employee')">Fill IR8A</button>
        <button class="ai-chip" onclick="sendAIChip('Run KYC screening check')">Run KYC</button>
        <button class="ai-chip" onclick="sendAIChip('Export company report summary')">Export Report</button>
        <button class="ai-chip" onclick="sendAIChip('Query company registration status')">Query Data</button>
    </div>

    <div class="ai-chat-body" id="aiChatBody">
        <div class="ai-message assistant">
            <span class="ai-avatar"><i class="fa fa-bolt"></i></span>
            Hello! I'm CorpFile AI. I can help you generate documents, run compliance checks, query data, and automate routine tasks. How can I assist you today?
        </div>
    </div>

    <div class="ai-chat-input">
        <input type="text" id="aiInput" placeholder="Ask CorpFile AI anything..." onkeydown="if(event.key==='Enter')sendAIMessage()">
        <button class="send-btn" onclick="sendAIMessage()">
            <i class="fa fa-paper-plane"></i>
        </button>
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

/* ── Simple Markdown renderer ──────────────────────────────── */
function renderMd(text) {
    var h = text
        .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
        .replace(/```([\s\S]*?)```/g, '<pre style="background:#f4f5f7;padding:8px;border-radius:4px;font-size:12px;overflow-x:auto"><code>$1</code></pre>')
        .replace(/`([^`]+)`/g, '<code style="background:#f4f5f7;padding:1px 4px;border-radius:3px;font-size:12px">$1</code>')
        .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
        .replace(/\*(.+?)\*/g, '<em>$1</em>')
        .replace(/^### (.+)$/gm, '<div style="font-weight:700;font-size:12px;margin:6px 0 2px">$1</div>')
        .replace(/^## (.+)$/gm, '<div style="font-weight:700;font-size:13px;margin:8px 0 3px">$1</div>')
        .replace(/^# (.+)$/gm, '<div style="font-weight:700;font-size:14px;margin:8px 0 4px">$1</div>')
        .replace(/^\d+\.\s+(.+)$/gm, '<div style="margin-left:12px">&#8226; $1</div>')
        .replace(/^[-•]\s+(.+)$/gm, '<div style="margin-left:12px">&#8226; $1</div>')
        .replace(/\n/g, '<br>');
    return h;
}

/* ── AI Agent Drawer ──────────────────────────────────────── */
function toggleAIDrawer() {
    var drawer = document.getElementById('aiDrawer');
    var overlay = document.getElementById('aiOverlay');
    var isActive = drawer.classList.contains('active');
    drawer.classList.toggle('active');
    overlay.classList.toggle('active');
    if (!isActive) {
        document.getElementById('aiInput').focus();
    }
}

function sendAIChip(text) {
    document.getElementById('aiInput').value = text;
    sendAIMessage();
}

function sendAIMessage() {
    var input = document.getElementById('aiInput');
    var message = input.value.trim();
    if (!message) return;
    input.value = '';

    var chatBody = document.getElementById('aiChatBody');

    /* User message */
    var userDiv = document.createElement('div');
    userDiv.className = 'ai-message user';
    userDiv.textContent = message;
    chatBody.appendChild(userDiv);

    /* Typing indicator */
    var typingDiv = document.createElement('div');
    typingDiv.className = 'ai-typing';
    typingDiv.id = 'aiTyping';
    typingDiv.innerHTML = '<span></span><span></span><span></span>';
    chatBody.appendChild(typingDiv);
    chatBody.scrollTop = chatBody.scrollHeight;

    /* Call AI API */
    fetch(BASE_URL + 'ai/chat', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ message: message })
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        var typing = document.getElementById('aiTyping');
        if (typing) typing.remove();

        var aiDiv = document.createElement('div');
        aiDiv.className = 'ai-message assistant';

        if (data.ok && data.response_text) {
            aiDiv.innerHTML = '<span class="ai-avatar"><i class="fa fa-bolt"></i></span> ' +
                '<div style="display:inline">' + renderMd(data.response_text) + '</div>';
            aiDiv.innerHTML += '<div class="action-btns">' +
                '<button onclick="copyToClipboard(this.closest(\'.ai-message\').innerText)"><i class="fa fa-copy"></i> Copy</button>' +
                '</div>';
        } else {
            aiDiv.innerHTML = '<span class="ai-avatar"><i class="fa fa-bolt"></i></span> ' +
                '<em style="color:var(--cf-text-secondary)">' + (data.error || 'AI agent encountered an error. Please try again.') + '</em>';
        }

        chatBody.appendChild(aiDiv);
        chatBody.scrollTop = chatBody.scrollHeight;
    })
    .catch(function(err) {
        var typing = document.getElementById('aiTyping');
        if (typing) typing.remove();

        var errDiv = document.createElement('div');
        errDiv.className = 'ai-message assistant';
        errDiv.innerHTML = '<span class="ai-avatar"><i class="fa fa-bolt"></i></span> <em style="color:var(--cf-text-secondary)">Unable to reach the AI service. Please try again later.</em>';
        chatBody.appendChild(errDiv);
        chatBody.scrollTop = chatBody.scrollHeight;
    });
}

function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text);
    }
}
</script>

</body>
</html>
