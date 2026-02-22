<!-- Project Dashboard -->
<div class="page-title">
    <div class="title_left">
        <h3>Project Dashboard</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('crm_projects') ?>" class="btn btn-primary"><i class="fa fa-list"></i> All Projects</a>
            <a href="<?= base_url('crm_dashboard') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to CRM</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!-- Stat Tiles -->
<div class="row top_tiles">
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#206570;">
            <div class="icon"><i class="fa fa-tasks" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;"><?= $stats['total'] ?? 0 ?></div>
            <h3 style="color:#fff !important;">Total Projects</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#3498db;">
            <div class="icon"><i class="fa fa-spinner" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;"><?= $stats['active'] ?? 0 ?></div>
            <h3 style="color:#fff !important;">Active</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#26B99A;">
            <div class="icon"><i class="fa fa-check-circle" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;"><?= $stats['completed'] ?? 0 ?></div>
            <h3 style="color:#fff !important;">Completed</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#f0ad4e;">
            <div class="icon"><i class="fa fa-pause-circle" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;"><?= $stats['on_hold'] ?? 0 ?></div>
            <h3 style="color:#fff !important;">On Hold</h3>
        </div>
    </div>
</div>

<div class="row">
    <!-- Active Projects -->
    <div class="col-md-8">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-tasks"></i> Active Projects</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php if (!empty($active_projects)): foreach ($active_projects as $ap): ?>
                <div style="padding:12px;border-bottom:1px solid #eee;">
                    <div class="row">
                        <div class="col-md-6">
                            <strong><?= htmlspecialchars($ap->name ?? '') ?></strong>
                            <br><small class="text-muted"><?= htmlspecialchars($ap->client_name ?? '') ?></small>
                        </div>
                        <div class="col-md-3">
                            <small>Due: <?= !empty($ap->due_date) ? date('d/m/Y', strtotime($ap->due_date)) : '-' ?></small>
                        </div>
                        <div class="col-md-3">
                            <div class="progress" style="margin-bottom:0;">
                                <div class="progress-bar progress-bar-success" style="width:<?= $ap->progress ?? 0 ?>%;"><?= $ap->progress ?? 0 ?>%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; else: ?>
                <p class="text-muted text-center" style="padding:30px;">No active projects.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Completion Chart -->
    <div class="col-md-4">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-pie-chart"></i> Completion Rate</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="completion_chart" style="height:300px;display:flex;align-items:center;justify-content:center;">
                    <div class="text-center text-muted">
                        <i class="fa fa-pie-chart fa-3x"></i>
                        <p style="margin-top:15px;">Chart will display when data is available.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
