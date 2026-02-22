<!-- CRM Dashboard -->
<div class="page-title">
    <div class="title_left">
        <h3>CRM Dashboard</h3>
    </div>
</div>
<div class="clearfix"></div>

<!-- Stat Tiles -->
<div class="row top_tiles">
    <div class="animated flipInY col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#206570;">
            <div class="icon"><i class="fa fa-users" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;">0</div>
            <h3 style="color:#fff !important;">Total Leads</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#26B99A;">
            <div class="icon"><i class="fa fa-folder-open" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;">0</div>
            <h3 style="color:#fff !important;">Open Leads</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#5cb85c;">
            <div class="icon"><i class="fa fa-trophy" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;">0</div>
            <h3 style="color:#fff !important;">Won</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#E74C3C;">
            <div class="icon"><i class="fa fa-times-circle" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;">0</div>
            <h3 style="color:#fff !important;">Lost</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#f0ad4e;">
            <div class="icon"><i class="fa fa-dollar" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;">$0</div>
            <h3 style="color:#fff !important;">Revenue</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#9B59B6;">
            <div class="icon"><i class="fa fa-percent" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;">0%</div>
            <h3 style="color:#fff !important;">Conversion Rate</h3>
        </div>
    </div>
</div>

<!-- Recent Activities & Pipeline Chart -->
<div class="row">
    <!-- Recent Activities -->
    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-clock-o"></i> Recent Activities</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Activity</th>
                            <th>User</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center text-muted">No recent activities</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pipeline Chart -->
    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-bar-chart"></i> Sales Pipeline</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="pipeline_chart" style="height:300px;display:flex;align-items:center;justify-content:center;">
                    <div class="text-center text-muted">
                        <i class="fa fa-bar-chart fa-3x"></i>
                        <p style="margin-top:15px;">Pipeline chart will be displayed here when data is available.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Quick Links</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <a href="<?= base_url('crm_leads') ?>" class="btn btn-primary"><i class="fa fa-users"></i> Leads</a>
                <a href="<?= base_url('add_lead') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Lead</a>
                <a href="<?= base_url('crm_quotations') ?>" class="btn btn-info"><i class="fa fa-file-text-o"></i> Quotations</a>
                <a href="<?= base_url('crm_sales_order') ?>" class="btn btn-warning"><i class="fa fa-shopping-cart"></i> Sales Orders</a>
                <a href="<?= base_url('crm_invoices') ?>" class="btn btn-default"><i class="fa fa-money"></i> Invoices</a>
                <a href="<?= base_url('crm_projects') ?>" class="btn btn-primary"><i class="fa fa-tasks"></i> Projects</a>
                <a href="<?= base_url('crm_tasks') ?>" class="btn btn-info"><i class="fa fa-check-square-o"></i> Tasks</a>
                <a href="<?= base_url('crm_activities') ?>" class="btn btn-default"><i class="fa fa-clock-o"></i> Activities</a>
                <a href="<?= base_url('crm_timesheets') ?>" class="btn btn-success"><i class="fa fa-calendar"></i> Timesheets</a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.select2) {
        $('.select2').select2();
    }
});
</script>
