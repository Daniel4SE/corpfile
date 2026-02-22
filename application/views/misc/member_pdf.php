<!-- Member PDF Preview -->
<div class="page-title">
    <div class="title_left">
        <h3>Member PDF - <?= htmlspecialchars($member->name ?? '') ?></h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('member') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Members</a>
            <button class="btn btn-primary" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <?php if ($member): ?>
                    <?php $pdfUrl = base_url('api/member_pdf/' . ($member_id ?? '')); ?>
                    <div style="text-align:center;margin-bottom:15px;">
                        <a href="<?= $pdfUrl ?>" class="btn btn-success" target="_blank"><i class="fa fa-download"></i> Download PDF</a>
                        <a href="<?= $pdfUrl ?>" class="btn btn-info" target="_blank"><i class="fa fa-external-link"></i> Open in New Tab</a>
                    </div>

                    <div style="border:1px solid #ddd;background:#f5f5f5;min-height:600px;">
                        <iframe src="<?= $pdfUrl ?>" style="width:100%;height:800px;border:none;">
                            <p>Your browser does not support iframes. <a href="<?= $pdfUrl ?>">Download the PDF</a> instead.</p>
                        </iframe>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-triangle"></i> Member not found. Unable to generate PDF.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
