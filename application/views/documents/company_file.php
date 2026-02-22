<div class="page-title"><div class="title_left"><h3>Company Files <?php if (!empty($company)): ?> - <?= htmlspecialchars($company->company_name) ?><?php endif; ?></h3></div><div class="title_right"><div class="pull-right">
<a href="<?= base_url('company_list') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
<?php if (!empty($company)): ?>
<button class="btn btn-primary" data-toggle="modal" data-target="#uploadModal"><i class="fa fa-upload"></i> Upload File</button>
<?php endif; ?>
</div></div></div><div class="clearfix"></div>

<div class="row">
<div class="col-md-12">
<div class="x_panel">
<div class="x_title"><h2>Files</h2><div class="clearfix"></div></div>
<div class="x_content">
<?php if (!empty($company)): ?>
<div class="row" style="margin-bottom:15px;">
<div class="col-md-4">
<select id="filter_category" class="form-control select2_single">
<option value="">All Categories</option>
<?php foreach ($categories as $cat): ?>
<option value="<?= htmlspecialchars($cat->category_name ?? '') ?>"><?= htmlspecialchars($cat->category_name ?? '') ?></option>
<?php endforeach; ?>
</select>
</div>
<div class="col-md-4">
<input type="text" id="filter_date" class="form-control" placeholder="Filter by date range">
</div>
</div>
<table id="datatable-files" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
<thead><tr style="background:#206570;color:#fff;">
<th>S/No</th><th>File Name</th><th>Category</th><th>Description</th><th>Uploaded By</th><th>Upload Date</th><th>Size</th><th>Action</th>
</tr></thead>
<tbody>
<?php $i=1; foreach ($files as $f): ?>
<tr>
<td><?= $i++ ?></td>
<td><i class="fa fa-file-o"></i> <?= htmlspecialchars($f->document_name ?? $f->file_name ?? '') ?></td>
<td><?= htmlspecialchars($f->category_name ?? '-') ?></td>
<td><?= htmlspecialchars($f->description ?? '-') ?></td>
<td><?= htmlspecialchars($f->uploaded_by_name ?? '-') ?></td>
<td><?= htmlspecialchars($f->created_at ?? '-') ?></td>
<td><?= htmlspecialchars($f->file_size ?? '-') ?></td>
<td>
<a href="<?= base_url('file_preview/' . ($f->id ?? '')) ?>" class="btn btn-xs btn-info" title="Preview"><i class="fa fa-eye"></i></a>
<a href="<?= base_url('companies/download_file/' . ($f->id ?? '')) ?>" class="btn btn-xs btn-success" title="Download"><i class="fa fa-download"></i></a>
<a href="<?= base_url('edit_document/' . ($f->id ?? '')) ?>" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-pencil"></i></a>
<a href="<?= base_url('document_history/' . ($f->id ?? '')) ?>" class="btn btn-xs btn-default" title="History"><i class="fa fa-history"></i></a>
<button class="btn btn-xs btn-danger btn-delete-file" data-id="<?= $f->id ?? '' ?>" title="Delete"><i class="fa fa-trash"></i></button>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
<div class="alert alert-info">Select a company to view files.</div>
<form method="get">
<div class="form-group">
<label>Select Company</label>
<select name="company_id" class="form-control select2_single" onchange="this.form.submit()">
<option value="">-- Select Company --</option>
<?php foreach ($companies ?? [] as $c): ?>
<option value="<?= $c->id ?>"><?= htmlspecialchars($c->company_name) ?> (<?= htmlspecialchars($c->registration_number ?? '') ?>)</option>
<?php endforeach; ?>
</select>
</div>
</form>
<?php endif; ?>
</div></div></div></div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog">
<div class="modal-dialog"><div class="modal-content">
<div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Upload File</h4></div>
<form method="post" enctype="multipart/form-data" action="<?= base_url('companies/upload_file/' . ($company->id ?? '')) ?>">
<input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
<div class="modal-body">
<div class="form-group"><label>Category</label>
<select name="category" class="form-control">
<option value="">-- Select --</option>
<?php foreach ($categories as $cat): ?>
<option value="<?= htmlspecialchars($cat->id ?? '') ?>"><?= htmlspecialchars($cat->category_name ?? '') ?></option>
<?php endforeach; ?>
</select></div>
<div class="form-group"><label>Description</label><input type="text" name="description" class="form-control" placeholder="File description"></div>
<div class="form-group"><label>File</label><input type="file" name="file" class="form-control" required></div>
</div>
<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Upload</button></div>
</form>
</div></div></div>

<script>
$(function(){
    $('#datatable-files').DataTable({dom:'Bfrtip',buttons:['copy','csv','excel','pdf','print']});
    $('.btn-delete-file').click(function(){
        if(confirm('Delete this file?')){
            var id=$(this).data('id');
            $.post('<?= base_url("companies/delete_file/") ?>'+id,{csrf_token:'<?= $csrf_token ?? '' ?>'},function(){location.reload();});
        }
    });
});
</script>
