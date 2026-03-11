<!-- Leads Dashboard -->
<div class="page-title">
    <div class="title_left">
        <h3>Leads Dashboard</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('crm_leads') ?>" class="btn btn-primary"><i class="fa fa-list"></i> All Leads</a>
            <a href="<?= base_url('add_lead') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Lead</a>
            <a href="<?= base_url('dashboard') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!-- Stat Tiles -->
<div class="row top_tiles">
    <div class="animated flipInY col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#206570;">
            <div class="icon"><i class="fa fa-users" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;"><?= $stats['total'] ?? 0 ?></div>
            <h3 style="color:#fff !important;">Total Leads</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#3498db;">
            <div class="icon"><i class="fa fa-star" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;"><?= $stats['new'] ?? 0 ?></div>
            <h3 style="color:#fff !important;">New</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#f0ad4e;">
            <div class="icon"><i class="fa fa-filter" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;"><?= $stats['qualified'] ?? 0 ?></div>
            <h3 style="color:#fff !important;">Qualified</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#26B99A;">
            <div class="icon"><i class="fa fa-trophy" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;"><?= $stats['converted'] ?? 0 ?></div>
            <h3 style="color:#fff !important;">Converted</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#E74C3C;">
            <div class="icon"><i class="fa fa-times-circle" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;"><?= $stats['lost'] ?? 0 ?></div>
            <h3 style="color:#fff !important;">Lost</h3>
        </div>
    </div>
</div>

<div class="row">
    <!-- Lead Pipeline -->
    <div class="col-md-8">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-bar-chart"></i> Lead Pipeline</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="pipeline_chart" style="height:350px;display:flex;align-items:center;justify-content:center;">
                    <div class="text-center text-muted">
                        <i class="fa fa-bar-chart fa-3x"></i>
                        <p style="margin-top:15px;">Pipeline chart will display when data is available.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Conversion Stats -->
    <div class="col-md-4">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-percent"></i> Conversion</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                $total = max(1, $stats['total'] ?? 1);
                $convRate = ($stats['converted'] ?? 0) / $total * 100;
                ?>
                <div class="text-center" style="padding:30px;">
                    <h1 style="font-size:48px;color:#26B99A;"><?= number_format($convRate, 1) ?>%</h1>
                    <p class="text-muted">Conversion Rate</p>
                </div>
                <div class="progress" style="height:25px;">
                    <div class="progress-bar progress-bar-success" style="width:<?= $convRate ?>%;line-height:25px;">
                        <?= number_format($convRate, 1) ?>%
                    </div>
                </div>
                <hr>
                <table class="table table-condensed" style="font-size:13px;">
                    <tr><td>New to Qualified:</td><td class="text-right"><strong>-</strong></td></tr>
                    <tr><td>Qualified to Converted:</td><td class="text-right"><strong>-</strong></td></tr>
                    <tr><td>Avg. Conversion Time:</td><td class="text-right"><strong>-</strong></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
