<div class="page-title"><div class="title_left"><h3>File Preview</h3></div><div class="title_right"><div class="pull-right">
<a href="javascript:history.back()" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
<?php if (!empty($document)): ?>
<a href="<?= base_url('documents/download/' . ($document->id ?? '')) ?>" class="btn btn-success"><i class="fa fa-download"></i> Download</a>
<?php endif; ?>
</div></div></div><div class="clearfix"></div>

<div class="row">
<div class="col-md-12">
<div class="x_panel">
<div class="x_title"><h2><?= htmlspecialchars($document->document_name ?? 'File Preview') ?></h2><div class="clearfix"></div></div>
<div class="x_content">
<?php if (!empty($document)):
    $ext = strtolower(pathinfo($document->file_path ?? '', PATHINFO_EXTENSION));
    $file_url = base_url($document->file_path ?? '');
    $r2 = new R2Storage();
    if ($r2->isConfigured()) {
        $r2Key = 'documents/' . basename($document->file_path ?? '');
        $r2Url = $r2->getUrl($r2Key);
        if ($r2Url) {
            $file_url = $r2Url;
        }
    }
?>
    <?php if (in_array($ext, ['jpg','jpeg','png','gif','bmp','svg'])): ?>
        <div class="text-center"><img src="<?= $file_url ?>" class="img-responsive" style="max-height:80vh;margin:auto;"></div>
    <?php elseif ($ext === 'pdf'): ?>
        <iframe src="<?= $file_url ?>" width="100%" height="800" style="border:none;"></iframe>
    <?php elseif (in_array($ext, ['doc','docx','xls','xlsx','ppt','pptx'])): ?>
        <div class="text-center" style="padding:60px;">
            <i class="fa fa-file-word-o fa-5x" style="color:#2b579a;"></i>
            <h4 style="margin-top:20px;"><?= htmlspecialchars($document->document_name ?? '') ?></h4>
            <p class="text-muted">Office documents cannot be previewed inline. Please download to view.</p>
            <a href="<?= $file_url ?>" class="btn btn-primary btn-lg"><i class="fa fa-download"></i> Download File</a>
        </div>
    <?php else: ?>
        <div class="text-center" style="padding:60px;">
            <i class="fa fa-file-o fa-5x" style="color:#999;"></i>
            <h4 style="margin-top:20px;"><?= htmlspecialchars($document->document_name ?? '') ?></h4>
            <p class="text-muted">File type: .<?= $ext ?> | Size: <?= htmlspecialchars($document->file_size ?? '-') ?></p>
            <a href="<?= $file_url ?>" class="btn btn-primary btn-lg"><i class="fa fa-download"></i> Download File</a>
        </div>
    <?php endif; ?>

    <div class="ln_solid"></div>
    <table class="table table-condensed" style="max-width:500px;">
    <tr><th>File Name:</th><td><?= htmlspecialchars($document->document_name ?? '') ?></td></tr>
    <tr><th>Category:</th><td><?= htmlspecialchars($document->category_name ?? '-') ?></td></tr>
    <tr><th>Company:</th><td><?= htmlspecialchars($document->company_name ?? '-') ?></td></tr>
    <tr><th>Uploaded By:</th><td><?= htmlspecialchars($document->uploaded_by_name ?? '-') ?></td></tr>
    <tr><th>Upload Date:</th><td><?= htmlspecialchars($document->created_at ?? '-') ?></td></tr>
    </table>
<?php else: ?>
    <div class="alert alert-warning">File not found or no longer available.</div>
<?php endif; ?>
</div></div></div></div>
