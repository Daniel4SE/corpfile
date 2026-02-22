<!-- Reports Index -->
<div class="page-title">
    <div class="title_left">
        <h3>Reports</h3>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <!-- CSS Reports -->
    <div class="col-md-4 col-sm-6 col-xs-12">
        <a href="<?= base_url('css_reports') ?>" style="text-decoration:none;">
            <div class="x_panel" style="cursor:pointer;transition:box-shadow 0.3s;">
                <div class="x_content" style="text-align:center;padding:30px;">
                    <div style="width:80px;height:80px;border-radius:50%;background:#206570;display:inline-flex;align-items:center;justify-content:center;margin-bottom:15px;">
                        <i class="fa fa-building fa-2x" style="color:#fff;"></i>
                    </div>
                    <h3 style="color:#206570;">CSS Reports</h3>
                    <p class="text-muted">Corporate Secretarial System reports including company, director, shareholder, AGM, AR, and FYE reports.</p>
                    <span class="label label-primary">20+ Report Types</span>
                </div>
            </div>
        </a>
    </div>

    <!-- CRM Reports -->
    <div class="col-md-4 col-sm-6 col-xs-12">
        <a href="<?= base_url('crm_reports') ?>" style="text-decoration:none;">
            <div class="x_panel" style="cursor:pointer;transition:box-shadow 0.3s;">
                <div class="x_content" style="text-align:center;padding:30px;">
                    <div style="width:80px;height:80px;border-radius:50%;background:#26B99A;display:inline-flex;align-items:center;justify-content:center;margin-bottom:15px;">
                        <i class="fa fa-line-chart fa-2x" style="color:#fff;"></i>
                    </div>
                    <h3 style="color:#26B99A;">CRM Reports</h3>
                    <p class="text-muted">CRM module reports including leads, sales, invoices, projects, and activity reports.</p>
                    <span class="label label-success">10+ Report Types</span>
                </div>
            </div>
        </a>
    </div>

    <!-- Custom Reports -->
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="x_panel" style="opacity:0.6;">
            <div class="x_content" style="text-align:center;padding:30px;">
                <div style="width:80px;height:80px;border-radius:50%;background:#999;display:inline-flex;align-items:center;justify-content:center;margin-bottom:15px;">
                    <i class="fa fa-cogs fa-2x" style="color:#fff;"></i>
                </div>
                <h3 style="color:#999;">Custom Reports</h3>
                <p class="text-muted">Build custom reports with advanced filtering and export options.</p>
                <span class="label label-default">Coming Soon</span>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Hover effect for report tiles
    $('.x_panel').hover(
        function() { $(this).css('box-shadow', '0 4px 15px rgba(0,0,0,0.15)'); },
        function() { $(this).css('box-shadow', ''); }
    );
});
</script>
