<!-- Invoice Dashboard -->
<div class="page-title">
    <div class="title_left">
        <h3>Invoice Dashboard</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('crm_invoices') ?>" class="btn btn-primary"><i class="fa fa-list"></i> All Invoices</a>
            <a href="<?= base_url('crm_dashboard') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to CRM</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!-- Stat Tiles -->
<div class="row top_tiles">
    <div class="animated flipInY col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#206570;">
            <div class="icon"><i class="fa fa-file-text-o" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;"><?= $stats['total'] ?? 0 ?></div>
            <h3 style="color:#fff !important;">Total Invoices</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#26B99A;">
            <div class="icon"><i class="fa fa-check-circle" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;"><?= $stats['paid'] ?? 0 ?></div>
            <h3 style="color:#fff !important;">Paid</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#f0ad4e;">
            <div class="icon"><i class="fa fa-clock-o" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;"><?= $stats['unpaid'] ?? 0 ?></div>
            <h3 style="color:#fff !important;">Unpaid</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#E74C3C;">
            <div class="icon"><i class="fa fa-exclamation-triangle" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;"><?= $stats['overdue'] ?? 0 ?></div>
            <h3 style="color:#fff !important;">Overdue</h3>
        </div>
    </div>
    <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#5cb85c;">
            <div class="icon"><i class="fa fa-dollar" style="color:#fff;"></i></div>
            <div class="count" style="color:#fff;">$<?= number_format($stats['revenue'] ?? 0, 0) ?></div>
            <h3 style="color:#fff !important;">Total Revenue</h3>
        </div>
    </div>
</div>

<div class="row">
    <!-- Revenue Chart -->
    <div class="col-md-8">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-line-chart"></i> Revenue Chart</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="revenue_chart" style="height:350px;display:flex;align-items:center;justify-content:center;">
                    <div class="text-center text-muted">
                        <i class="fa fa-line-chart fa-3x"></i>
                        <p style="margin-top:15px;">Revenue chart will display when data is available.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overdue List -->
    <div class="col-md-4">
        <div class="x_panel">
            <div class="x_title" style="background:#E74C3C;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-exclamation-circle"></i> Overdue Invoices</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php if (!empty($overdue_list)): foreach ($overdue_list as $ov): ?>
                <div style="padding:8px;border-bottom:1px solid #eee;">
                    <strong><?= htmlspecialchars($ov->invoice_no ?? '') ?></strong>
                    <span class="pull-right text-danger">$<?= number_format($ov->amount ?? 0, 2) ?></span>
                    <br><small class="text-muted"><?= htmlspecialchars($ov->company_name ?? '') ?> - Due: <?= !empty($ov->due_date) ? date('d/m/Y', strtotime($ov->due_date)) : '' ?></small>
                </div>
                <?php endforeach; else: ?>
                <p class="text-muted text-center" style="padding:30px;">No overdue invoices.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
