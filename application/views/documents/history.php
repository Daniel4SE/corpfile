<div class="page-title"><div class="title_left"><h3>Document History <?php if (!empty($document)): ?> - <?= htmlspecialchars($document->document_name ?? '') ?><?php endif; ?></h3></div><div class="title_right"><div class="pull-right"><a href="javascript:history.back()" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a></div></div></div><div class="clearfix"></div>

<div class="row">
<div class="col-md-12">
<div class="x_panel">
<div class="x_title"><h2>Version History</h2><div class="clearfix"></div></div>
<div class="x_content">
<?php if (!empty($document)): ?>
<div class="row" style="margin-bottom:20px;">
<div class="col-md-6">
<table class="table table-condensed">
<tr><th width="150">Document:</th><td><?= htmlspecialchars($document->document_name ?? '') ?></td></tr>
<tr><th>Company:</th><td><?= htmlspecialchars($document->company_name ?? '-') ?></td></tr>
<tr><th>Category:</th><td><?= htmlspecialchars($document->category_name ?? '-') ?></td></tr>
<tr><th>Current File:</th><td><?= htmlspecialchars($document->file_path ?? '-') ?></td></tr>
</table>
</div>
</div>
<table id="datatable-history" class="table table-striped table-bordered" cellspacing="0" width="100%">
<thead><tr style="background:#206570;color:#fff;">
<th>S/No</th><th>Version</th><th>Action</th><th>Changed By</th><th>Date</th><th>Details</th>
</tr></thead>
<tbody>
<?php $i=1; foreach ($history as $h): ?>
<tr>
<td><?= $i++ ?></td>
<td><?= htmlspecialchars($h->version ?? $i) ?></td>
<td><span class="label label-<?= ($h->action ?? '') == 'Upload' ? 'success' : (($h->action ?? '') == 'Delete' ? 'danger' : 'info') ?>"><?= htmlspecialchars($h->action ?? 'Update') ?></span></td>
<td><?= htmlspecialchars($h->user_name ?? '-') ?></td>
<td><?= htmlspecialchars($h->created_at ?? '-') ?></td>
<td><?= htmlspecialchars($h->details ?? '-') ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
<div class="alert alert-warning">Document not found.</div>
<?php endif; ?>
</div></div></div></div>
<script>$(function(){$('#datatable-history').DataTable();});</script>
