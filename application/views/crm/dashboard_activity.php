<!-- Activity Dashboard -->
<div class="page-title">
    <div class="title_left">
        <h3>Activity Dashboard</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('crm_dashboard') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to CRM</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!-- Stat Tiles -->
<div class="row top_tiles">
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#206570;">
            <div class="icon"><i class="fa fa-clock-o" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;"><?= $stats['total'] ?? 0 ?></div>
            <h3 style="color:#fff !important;">Total Activities</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#26B99A;">
            <div class="icon"><i class="fa fa-calendar-check-o" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;"><?= $stats['today'] ?? 0 ?></div>
            <h3 style="color:#fff !important;">Today</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#f0ad4e;">
            <div class="icon"><i class="fa fa-calendar" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;"><?= $stats['this_week'] ?? 0 ?></div>
            <h3 style="color:#fff !important;">This Week</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#9B59B6;">
            <div class="icon"><i class="fa fa-bar-chart" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;"><?= $stats['this_month'] ?? 0 ?></div>
            <h3 style="color:#fff !important;">This Month</h3>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Activities -->
    <div class="col-md-8">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-clock-o"></i> Recent Activities</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="dt-activities" class="table table-striped table-bordered">
                    <thead><tr style="background:#f5f5f5;"><th>Date</th><th>Activity</th><th>Type</th><th>User</th><th>Status</th></tr></thead>
                    <tbody>
                        <?php if (!empty($activities)): foreach ($activities as $a): ?>
                        <tr>
                            <td><?= !empty($a->created_at) ? date('d/m/Y H:i', strtotime($a->created_at)) : '' ?></td>
                            <td><?= htmlspecialchars($a->description ?? '') ?></td>
                            <td><?= htmlspecialchars($a->type ?? '') ?></td>
                            <td><?= htmlspecialchars($a->user_name ?? '') ?></td>
                            <td><span class="label label-info"><?= htmlspecialchars($a->status ?? '') ?></span></td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="5" class="text-center text-muted">No recent activities.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Activity Chart -->
    <div class="col-md-4">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-pie-chart"></i> Activity Distribution</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="activity_chart" style="height:300px;display:flex;align-items:center;justify-content:center;">
                    <div class="text-center text-muted">
                        <i class="fa fa-pie-chart fa-3x"></i>
                        <p style="margin-top:15px;">Chart will display when data is available.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) { $('#dt-activities').DataTable({ pageLength: 10, order: [[0, 'desc']] }); }
});
</script>
