<!-- Dashboard - Modern CorpFile Reference Design -->
<div class="page-title">
    <div class="title_left">
        <h3>Dashboard</h3>
        <p style="color:var(--cf-text-secondary); font-size:14px; margin-top:4px;">
            Welcome back<?= isset($current_user->name) ? ', ' . htmlspecialchars($current_user->name) : '' ?>. Here's your overview.
        </p>
    </div>
</div>
<div class="clearfix"></div>

<!-- ── TOP SECTION: KPIs (left 8 col) + Quick Reports (right 4 col) ── -->
<div class="row">
    <div class="col-md-8">
        <!-- KPI Row 1: Company Stats -->
        <div class="kpi-grid" style="grid-template-columns: repeat(4, 1fr); margin-bottom: 14px;">
            <a href="<?= base_url('company_list') ?>" class="kpi-card kpi-navy animate-in">
                <div class="kpi-header">
                    <span class="kpi-label">Total Companies</span>
                    <div class="kpi-icon navy"><i class="fa fa-building-o"></i></div>
                </div>
                <div class="kpi-value"><?= $total_companies ?? 0 ?></div>
                <div class="kpi-trend neutral"><i class="fa fa-bar-chart"></i> All jurisdictions</div>
            </a>

            <a href="<?= base_url('pre_company') ?>" class="kpi-card kpi-blue animate-in animate-in-delay-1">
                <div class="kpi-header">
                    <span class="kpi-label">Pre-Incorporation</span>
                    <div class="kpi-icon blue"><i class="fa fa-clock-o"></i></div>
                </div>
                <div class="kpi-value"><?= $pre_incorp_count ?? 0 ?></div>
                <div class="kpi-trend neutral"><i class="fa fa-hourglass-half"></i> Pending</div>
            </a>

            <a href="<?= base_url('post_company') ?>" class="kpi-card kpi-green animate-in animate-in-delay-2">
                <div class="kpi-header">
                    <span class="kpi-label">Post-Incorporation</span>
                    <div class="kpi-icon green"><i class="fa fa-check-circle"></i></div>
                </div>
                <div class="kpi-value"><?= $post_incorp_count ?? 0 ?></div>
                <div class="kpi-trend up"><i class="fa fa-check"></i> Active</div>
            </a>

            <a href="<?= base_url('company_non_client') ?>" class="kpi-card animate-in animate-in-delay-3">
                <div class="kpi-header">
                    <span class="kpi-label">Non-Client</span>
                    <div class="kpi-icon" style="background:rgba(107,114,128,0.1); color:var(--cf-text-secondary);"><i class="fa fa-building"></i></div>
                </div>
                <div class="kpi-value"><?= $non_client_count ?? 0 ?></div>
                <div class="kpi-trend neutral"><i class="fa fa-external-link"></i> External</div>
            </a>
        </div>

        <!-- KPI Row 2: Client Segmentation -->
        <div class="kpi-grid" style="grid-template-columns: repeat(4, 1fr); margin-bottom: 0;">
            <div class="kpi-card animate-in">
                <div class="kpi-header">
                    <span class="kpi-label">CSS Clients</span>
                    <div class="kpi-icon" style="background:rgba(99,102,241,0.1); color:#6366F1;"><i class="fa fa-briefcase"></i></div>
                </div>
                <div class="kpi-value" id="css_client_count">--</div>
                <div class="kpi-trend neutral"><i class="fa fa-users"></i> Corp Sec</div>
            </div>

            <div class="kpi-card animate-in animate-in-delay-1">
                <div class="kpi-header">
                    <span class="kpi-label">Accounting</span>
                    <div class="kpi-icon" style="background:rgba(236,72,153,0.1); color:#EC4899;"><i class="fa fa-calculator"></i></div>
                </div>
                <div class="kpi-value" id="acct_client_count">--</div>
                <div class="kpi-trend neutral"><i class="fa fa-file-text-o"></i> Clients</div>
            </div>

            <div class="kpi-card animate-in animate-in-delay-2">
                <div class="kpi-header">
                    <span class="kpi-label">Audit Clients</span>
                    <div class="kpi-icon" style="background:rgba(249,115,22,0.1); color:#F97316;"><i class="fa fa-search"></i></div>
                </div>
                <div class="kpi-value" id="audit_client_count">--</div>
                <div class="kpi-trend neutral"><i class="fa fa-shield"></i> Audit</div>
            </div>

            <div class="kpi-card animate-in animate-in-delay-3">
                <div class="kpi-header">
                    <span class="kpi-label">Listed-Related</span>
                    <div class="kpi-icon" style="background:rgba(139,92,246,0.1); color:#8B5CF6;"><i class="fa fa-star"></i></div>
                </div>
                <div class="kpi-value" id="listed_client_count">--</div>
                <div class="kpi-trend neutral"><i class="fa fa-certificate"></i> Listed</div>
            </div>
        </div>
    </div>

    <!-- Right: Quick Reports Panel -->
    <div class="col-md-4">
        <div class="quick-reports" style="height: 100%;">
            <h4><i class="fa fa-bolt" style="color:var(--cf-accent); margin-right:8px;"></i> Quick Reports</h4>
            <a href="<?= base_url('report_module/default_report') ?>" class="report-link">
                <i class="fa fa-file-text-o"></i> Income Statement
            </a>
            <a href="<?= base_url('registers/annual_return') ?>" class="report-link">
                <i class="fa fa-refresh"></i> AR Aging Report
            </a>
            <a href="<?= base_url('company_agm/company_agm_list') ?>" class="report-link">
                <i class="fa fa-id-card-o"></i> EP Status Report
            </a>
            <a href="<?= base_url('registers/annual_return') ?>" class="report-link">
                <i class="fa fa-calendar-check-o"></i> Annual Return
            </a>
            <a href="<?= base_url('alldocuments') ?>" class="report-link">
                <i class="fa fa-folder-open"></i> Document Audit
            </a>
            <a href="<?= base_url('report_module/default_report') ?>" class="report-link">
                <i class="fa fa-pie-chart"></i> Client Summary
            </a>
        </div>
    </div>
</div>

<!-- ── ALERT COCKPIT (6 cards: FYE, AGM, AR, EP, ID, IIT) ── -->
<div style="margin-top: 24px;">
    <div class="section-title"><span class="dot"></span> Alert Cockpit</div>
    <div class="alert-cockpit">
        <!-- FYE Overdue -->
        <div class="alert-item animate-in">
            <div class="alert-icon" style="background:rgba(79,134,198,0.1); color:var(--cf-accent);">
                <i class="fa fa-calendar"></i>
            </div>
            <div class="alert-info">
                <div class="alert-title">FYE Overdue</div>
                <div class="alert-count" id="fye_count_val">0</div>
            </div>
            <span class="alert-badge warning" id="fye_badge">Check</span>
        </div>

        <!-- AGM Overdue -->
        <div class="alert-item animate-in animate-in-delay-1" onclick="window.location='<?= base_url('company_agm/company_agm_list') ?>'">
            <div class="alert-icon" style="background:rgba(239,68,68,0.1); color:var(--cf-danger);">
                <i class="fa fa-gavel"></i>
            </div>
            <div class="alert-info">
                <div class="alert-title">AGM Overdue</div>
                <div class="alert-count"><?= count($agm_alerts ?? []) ?></div>
            </div>
            <span class="alert-badge <?= count($agm_alerts ?? []) > 0 ? 'urgent' : 'clear' ?>">
                <?= count($agm_alerts ?? []) > 0 ? 'Action' : 'Clear' ?>
            </span>
        </div>

        <!-- AR Due -->
        <div class="alert-item animate-in animate-in-delay-2" onclick="window.location='<?= base_url('registers/annual_return') ?>'">
            <div class="alert-icon" style="background:rgba(245,158,11,0.1); color:var(--cf-warning);">
                <i class="fa fa-refresh"></i>
            </div>
            <div class="alert-info">
                <div class="alert-title">AR Due</div>
                <div class="alert-count" id="ar_count_val">0</div>
            </div>
            <span class="alert-badge clear" id="ar_badge">Clear</span>
        </div>

        <!-- EP Expiry -->
        <div class="alert-item animate-in">
            <div class="alert-icon" style="background:rgba(236,72,153,0.1); color:#EC4899;">
                <i class="fa fa-briefcase"></i>
            </div>
            <div class="alert-info">
                <div class="alert-title">EP Expiry</div>
                <div class="alert-count" id="ep_count_val">0</div>
            </div>
            <span class="alert-badge clear" id="ep_badge">Clear</span>
        </div>

        <!-- ID Expiry -->
        <div class="alert-item animate-in animate-in-delay-1">
            <div class="alert-icon" style="background:rgba(16,185,129,0.1); color:var(--cf-success);">
                <i class="fa fa-id-card-o"></i>
            </div>
            <div class="alert-info">
                <div class="alert-title">ID Expiry</div>
                <div class="alert-count" id="expiry_count_val">0</div>
            </div>
            <span class="alert-badge clear" id="expiry_badge">Clear</span>
        </div>

        <!-- IIT Filing -->
        <div class="alert-item animate-in animate-in-delay-2">
            <div class="alert-icon" style="background:rgba(139,92,246,0.1); color:#8B5CF6;">
                <i class="fa fa-file-text"></i>
            </div>
            <div class="alert-info">
                <div class="alert-title">IIT Filing</div>
                <div class="alert-count" id="iit_count_val">0</div>
            </div>
            <span class="alert-badge clear" id="iit_badge">Clear</span>
        </div>
    </div>
</div>

<!-- ── DETAIL PANELS + INTEGRATION/ACTIONS ───────────────── -->
<div class="row" style="margin-top: 24px;">
    <!-- Left: Alert Detail Panels -->
    <div class="col-md-8">
        <!-- AGM Due Alert -->
        <div class="x_panel">
            <div class="x_title alertcolor">
                <h2><i class="fa fa-gavel" style="margin-right:8px; color:var(--cf-accent);"></i> AGM Due Alert (<?= count($agm_alerts ?? []) ?>)</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="max-height:220px; overflow-y:auto;">
                <ul class="list-unstyled msg_list" id="postList">
                    <?php if (!empty($agm_alerts)): ?>
                        <?php foreach ($agm_alerts as $alert): ?>
                        <li style="cursor:pointer;">
                            <a href="<?= base_url('view_company/' . $alert->id) ?>">
                                <span style="font-weight:600; color:var(--cf-text);"><?= htmlspecialchars($alert->company_name) ?></span>
                                <span class="message">
                                    <span style="color:var(--cf-danger); font-weight:500;">AGM Due:</span> <?= $alert->agm_due_date ?>
                                </span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li><a><span class="message" style="color:var(--cf-success);"><i class="fa fa-check-circle"></i> No AGM alerts - all clear</span></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- AR Due Alert -->
        <div class="x_panel">
            <div class="x_title alertcolor">
                <h2><i class="fa fa-refresh" style="margin-right:8px; color:var(--cf-accent);"></i> AR Due Alert (<span id="ar_count">0</span>)</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="max-height:220px; overflow-y:auto;">
                <ul class="list-unstyled msg_list" id="postList1">
                    <li><a><span class="message"><i class="fa fa-check-circle" style="color:var(--cf-success);"></i> No AR alerts</span></a></li>
                </ul>
            </div>
        </div>

        <!-- Due Date + FYE Alerts -->
        <div class="row">
            <div class="col-md-6">
                <div class="x_panel">
                    <div class="x_title alertcolor">
                        <h2><i class="fa fa-bell" style="margin-right:8px; color:var(--cf-accent);"></i> Due Alerts (<span id="due_count">0</span>)</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="max-height:180px; overflow-y:auto;">
                        <ul class="list-unstyled msg_list" id="postList2">
                            <li><a><span class="message">No due alerts</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="x_panel">
                    <div class="x_title alertcolor">
                        <h2><i class="fa fa-calendar-times-o" style="margin-right:8px; color:var(--cf-warning);"></i> FYE Missing (<span id="fye_count">0</span>)</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="max-height:180px; overflow-y:auto;">
                        <ul class="list-unstyled msg_list" id="postList3">
                            <li><a><span class="message">No alerts</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Integration + Quick Actions -->
    <div class="col-md-4">
        <!-- Integration Status -->
        <div style="background:var(--cf-white); border:1px solid var(--cf-border); border-radius:var(--cf-radius); padding:20px; margin-bottom:18px;">
            <h4 style="font-size:14px; font-weight:600; margin:0 0 14px; padding-bottom:10px; border-bottom:1px solid var(--cf-border); color:var(--cf-text);">
                Integration Status
            </h4>
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div class="integration-item">
                    <span class="integration-dot online"></span>
                    ACRA BizFile API
                </div>
                <div class="integration-item">
                    <span class="integration-dot online"></span>
                    Singpass MyInfo
                </div>
                <div class="integration-item">
                    <span class="integration-dot warning"></span>
                    MOM Work Pass
                </div>
                <div class="integration-item">
                    <span class="integration-dot online"></span>
                    IRAS e-Filing
                </div>
                <div class="integration-item">
                    <span class="integration-dot online"></span>
                    CorpFile AI Agent
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div style="background:var(--cf-white); border:1px solid var(--cf-border); border-radius:var(--cf-radius); padding:20px;">
            <h4 style="font-size:14px; font-weight:600; margin:0 0 14px; padding-bottom:10px; border-bottom:1px solid var(--cf-border); color:var(--cf-text);">
                Quick Actions
            </h4>
            <div style="display:flex; flex-direction:column; gap:8px;">
                <a href="<?= base_url('add_company') ?>" class="btn btn-primary btn-block" style="text-align:left; padding:10px 16px;">
                    <i class="fa fa-plus" style="margin-right:8px;"></i> New Company Registration
                </a>
                <a href="<?= base_url('member') ?>" class="btn btn-default btn-block" style="text-align:left; padding:10px 16px;">
                    <i class="fa fa-user-plus" style="margin-right:8px;"></i> Add Individual
                </a>
                <a href="<?= base_url('company_file') ?>" class="btn btn-default btn-block" style="text-align:left; padding:10px 16px;">
                    <i class="fa fa-file-text" style="margin-right:8px;"></i> Generate Template
                </a>
                <a href="<?= base_url('duedatetracker') ?>" class="btn btn-default btn-block" style="text-align:left; padding:10px 16px;">
                    <i class="fa fa-clock-o" style="margin-right:8px;"></i> Due Date Tracker
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ── Calendar Section ────────────────────────────────── -->
<div class="row" style="margin-top:20px;">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-calendar" style="margin-right:8px; color:var(--cf-accent);"></i> Event Calendar</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div style="display:flex; gap:20px; margin-bottom:16px; flex-wrap:wrap; align-items:center;">
                    <span style="display:flex; align-items:center; gap:6px; font-size:13px; color:var(--cf-text-secondary);">
                        <span style="width:12px; height:12px; border-radius:3px; background:#4F86C6; display:inline-block;"></span> AGM
                    </span>
                    <span style="display:flex; align-items:center; gap:6px; font-size:13px; color:var(--cf-text-secondary);">
                        <span style="width:12px; height:12px; border-radius:3px; background:#F97316; display:inline-block;"></span> AR
                    </span>
                    <span style="display:flex; align-items:center; gap:6px; font-size:13px; color:var(--cf-text-secondary);">
                        <span style="width:12px; height:12px; border-radius:3px; background:#F59E0B; display:inline-block;"></span> Resolution
                    </span>
                    <span style="display:flex; align-items:center; gap:6px; font-size:13px; color:var(--cf-text-secondary);">
                        <span style="width:12px; height:12px; border-radius:3px; background:#10B981; display:inline-block;"></span> Events
                    </span>
                    <div style="margin-left:auto; display:flex; gap:8px;">
                        <select class="form-control" id="yearFilter" style="width:auto; padding:6px 12px; font-size:13px;">
                            <?php for($y = 2020; $y <= 2031; $y++): ?>
                            <option value="<?= $y ?>" <?= $y == date('Y') ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                        <select class="form-control" id="monthFilter" style="width:auto; padding:6px 12px; font-size:13px;">
                            <?php
                            $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
                            foreach($months as $i => $m): ?>
                            <option value="<?= $i+1 ?>" <?= ($i+1) == date('n') ? 'selected' : '' ?>><?= $m ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    /* Initialize Select2 */
    if ($.fn.select2) {
        $('.select2_multiple').select2({
            placeholder: 'Select client types...',
            allowClear: true
        });
    }

    /* Initialize FullCalendar */
    if ($.fn.fullCalendar) {
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek'
            },
            defaultDate: '<?= date("Y-m") ?>',
            navLinks: true,
            editable: false,
            eventLimit: true,
            events: <?= json_encode(array_map(function($e) {
                $colors = ['AGM' => '#4F86C6', 'AR' => '#F97316', 'Resolution' => '#F59E0B', 'Event' => '#10B981'];
                return [
                    'title' => $e->company_name ?? 'Event',
                    'start' => $e->event_date ?? $e->agm_due_date ?? '',
                    'backgroundColor' => $colors[$e->event_type ?? 'Event'] ?? '#4F86C6',
                    'borderColor' => 'transparent',
                ];
            }, $calendar_events ?? [])) ?>,
            eventClick: function(event) {
                swal({
                    title: event.title,
                    text: 'Date: ' + moment(event.start).format('DD MMM YYYY'),
                    type: 'info'
                });
            }
        });
    }
});

function filterByClientType() {
    var selected = $('#select_client').val();
    if (!selected || selected.length === 0) {
        window.location.href = '<?= base_url('dashboard') ?>';
        return;
    }
    window.location.href = '<?= base_url('dashboard') ?>?client_type=' + selected.join(',');
}
</script>
