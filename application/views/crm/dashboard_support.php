<!-- Support Dashboard -->
<div class="page-title">
    <div class="title_left">
        <h3>Support Dashboard</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('tickets') ?>" class="btn btn-primary"><i class="fa fa-list"></i> All Tickets</a>
            <a href="<?= base_url('dashboard') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!-- Stat Tiles -->
<div class="row top_tiles">
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#206570;">
            <div class="icon"><i class="fa fa-ticket" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;"><?= $stats['total'] ?? 0 ?></div>
            <h3 style="color:#fff !important;">Total Tickets</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#E74C3C;">
            <div class="icon"><i class="fa fa-exclamation-circle" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;"><?= $stats['open'] ?? 0 ?></div>
            <h3 style="color:#fff !important;">Open</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#26B99A;">
            <div class="icon"><i class="fa fa-check-circle" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;"><?= $stats['closed'] ?? 0 ?></div>
            <h3 style="color:#fff !important;">Closed</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#9B59B6;">
            <div class="icon"><i class="fa fa-clock-o" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;"><?= $stats['avg_response'] ?? '0h' ?></div>
            <h3 style="color:#fff !important;">Avg Response</h3>
        </div>
    </div>
</div>

<div class="row">
    <!-- Open/Closed Chart -->
    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-pie-chart"></i> Ticket Status Distribution</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="ticket_status_chart" style="height:300px;display:flex;align-items:center;justify-content:center;">
                    <div class="text-center text-muted">
                        <i class="fa fa-pie-chart fa-3x"></i>
                        <p style="margin-top:15px;">Chart will display when data is available.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SLA Performance -->
    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-tachometer"></i> SLA Performance</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div style="padding:20px;">
                    <div class="row" style="margin-bottom:20px;">
                        <div class="col-md-6">
                            <h5>Response SLA</h5>
                            <div class="progress" style="height:25px;">
                                <div class="progress-bar progress-bar-success" style="width:0%;line-height:25px;">0%</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Resolution SLA</h5>
                            <div class="progress" style="height:25px;">
                                <div class="progress-bar progress-bar-info" style="width:0%;line-height:25px;">0%</div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-condensed" style="font-size:13px;">
                        <tr><td>Avg. First Response Time:</td><td class="text-right"><strong>-</strong></td></tr>
                        <tr><td>Avg. Resolution Time:</td><td class="text-right"><strong>-</strong></td></tr>
                        <tr><td>SLA Breach Rate:</td><td class="text-right"><strong>-</strong></td></tr>
                        <tr><td>Customer Satisfaction:</td><td class="text-right"><strong>-</strong></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
