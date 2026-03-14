<!-- CRM Reports -->
<div class="page-title">
    <div class="title_left">
        <h3>CRM Reports</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('reports') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Reports</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <?php
    $crm_report_types = [
        ['icon' => 'fa-users',          'title' => 'Lead Report',              'desc' => 'Lead generation and conversion analytics',     'color' => '#206570', 'type' => 'crm_lead'],
        ['icon' => 'fa-line-chart',     'title' => 'Sales Report',             'desc' => 'Sales performance and revenue tracking',       'color' => '#26B99A', 'type' => 'crm_sales_order'],
        ['icon' => 'fa-money',          'title' => 'Invoice Report',           'desc' => 'Invoice status, aging, and payment reports',   'color' => '#f0ad4e', 'type' => 'crm_invoice'],
        ['icon' => 'fa-tasks',          'title' => 'Project Report',           'desc' => 'Project progress, milestones, and timelines',  'color' => '#337ab7', 'type' => 'crm_projects'],
        ['icon' => 'fa-check-square-o', 'title' => 'Task Report',             'desc' => 'Task completion rates and team workload',       'color' => '#5cb85c', 'type' => 'crm_task'],
        ['icon' => 'fa-clock-o',        'title' => 'Activity Report',          'desc' => 'Team activity logs and engagement metrics',    'color' => '#9B59B6', 'type' => 'crm_activities'],
        ['icon' => 'fa-calendar',       'title' => 'Timesheet Report',         'desc' => 'Hours logged by user, project, and period',    'color' => '#E74C3C', 'type' => 'working_hrs'],
        ['icon' => 'fa-file-text-o',    'title' => 'Quotation Report',         'desc' => 'Quotation conversion and pipeline analytics',  'color' => '#3498DB', 'type' => 'quotations'],
        ['icon' => 'fa-shopping-cart',   'title' => 'Sales Order Report',      'desc' => 'Order fulfillment and delivery tracking',      'color' => '#E67E22', 'type' => 'soreport'],
        ['icon' => 'fa-bar-chart',       'title' => 'Pipeline Report',         'desc' => 'Sales pipeline stages and deal tracking',      'color' => '#2C3E50', 'type' => 'lead_report'],
        ['icon' => 'fa-pie-chart',       'title' => 'Revenue Report',          'desc' => 'Revenue breakdown by service and period',      'color' => '#16A085', 'type' => 'revenue_by_product_service'],
        ['icon' => 'fa-user',            'title' => 'Statement of Accounts',   'desc' => 'Client statement of accounts history',         'color' => '#8E44AD', 'type' => 'statement_of_accounts'],
    ];
    foreach ($crm_report_types as $report):
    ?>
    <div class="col-md-3 col-sm-4 col-xs-6" style="margin-bottom:15px;">
        <a href="<?= base_url('report_view/' . $report['type']) ?>" style="text-decoration:none;">
            <div class="x_panel" style="cursor:pointer;min-height:180px;transition:all 0.3s;">
                <div class="x_content" style="text-align:center;padding:20px 10px;">
                    <div style="width:50px;height:50px;border-radius:50%;background:<?= $report['color'] ?>;display:inline-flex;align-items:center;justify-content:center;margin-bottom:10px;">
                        <i class="fa <?= $report['icon'] ?>" style="color:#fff;font-size:20px;"></i>
                    </div>
                    <h4 style="color:<?= $report['color'] ?>;font-size:13px;font-weight:bold;"><?= $report['title'] ?></h4>
                    <p style="font-size:11px;color:#999;margin:0;"><?= $report['desc'] ?></p>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<script>
$(document).ready(function() {
    $('.x_panel').hover(
        function() { $(this).css({'box-shadow': '0 4px 15px rgba(0,0,0,0.15)', 'transform': 'translateY(-2px)'}); },
        function() { $(this).css({'box-shadow': '', 'transform': ''}); }
    );
});
</script>
