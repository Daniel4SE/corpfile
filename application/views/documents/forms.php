<div class="page-title"><div class="title_left"><h3>Company Forms <?php if (!empty($company)): ?> - <?= htmlspecialchars($company->company_name) ?><?php endif; ?></h3></div><div class="title_right"><div class="pull-right">
<a href="<?= base_url('company_list') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
<a href="<?= base_url('add_form_category') ?>" class="btn btn-info"><i class="fa fa-folder-plus"></i> Manage Categories</a>
</div></div></div><div class="clearfix"></div>

<div class="row">
<div class="col-md-12">
<div class="x_panel">
<div class="x_title"><h2>Form Templates</h2><div class="clearfix"></div></div>
<div class="x_content">
<div class="row" style="margin-bottom:15px;">
<div class="col-md-4"><select id="filter_cat" class="form-control select2_single"><option value="">All Categories</option>
<?php foreach ($form_categories as $fc): ?><option value="<?= htmlspecialchars($fc->category_name ?? '') ?>"><?= htmlspecialchars($fc->category_name ?? '') ?></option><?php endforeach; ?>
</select></div>
<div class="col-md-4"><input type="text" class="form-control" id="search_form" placeholder="Search forms..."></div>
</div>
<table id="datatable-forms" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
<thead><tr style="background:#206570;color:#fff;">
<th>S/No</th><th>Form Name</th><th>Category</th><th>Description</th><th>Last Updated</th><th>Status</th><th>Action</th>
</tr></thead>
<tbody>
<?php $i=1; foreach ($forms as $f): ?>
<tr>
<td><?= $i++ ?></td>
<td><i class="fa fa-file-text-o"></i> <?= htmlspecialchars($f->template_name ?? $f->form_name ?? '') ?></td>
<td><?= htmlspecialchars($f->category_name ?? '-') ?></td>
<td><?= htmlspecialchars($f->description ?? '-') ?></td>
<td><?= htmlspecialchars($f->updated_at ?? $f->created_at ?? '-') ?></td>
<td><span class="label label-<?= ($f->status ?? '') == 'Active' ? 'success' : 'default' ?>"><?= htmlspecialchars($f->status ?? 'Active') ?></span></td>
<td>
<a href="<?= base_url('edit_form/' . ($f->id ?? '')) ?>" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-pencil"></i></a>
<a href="<?= base_url('file_preview/' . ($f->id ?? '')) ?>" class="btn btn-xs btn-info" title="Preview"><i class="fa fa-eye"></i></a>
<button class="btn btn-xs btn-danger btn-delete" data-id="<?= $f->id ?? '' ?>"><i class="fa fa-trash"></i></button>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div></div></div></div>
<script>$(function(){$('#datatable-forms').DataTable({dom:'Bfrtip',buttons:['copy','csv','excel','pdf','print']});});</script>
