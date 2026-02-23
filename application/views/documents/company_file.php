<div class="page-title"><div class="title_left"><h3>Generate Templates</h3></div></div>
<div class="clearfix"></div>

<div class="row">
<div class="col-md-12">
<div class="x_panel">
<div class="x_title"><h2>Templates</h2><div class="clearfix"></div></div>
<div class="x_content">
<table id="datatable-templates" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
<thead><tr style="background:#206570;color:#fff;">
<th>S/No.</th><th>TemplateId</th><th>Template Name</th><th>Category</th><th>Source</th><th>Action</th>
</tr></thead>
<tbody>
<?php $i=1; foreach ($templates as $t): ?>
<tr>
<td><?= $i++ ?></td>
<td><?= htmlspecialchars($t->file_path ?? '') ?></td>
<td><?= htmlspecialchars($t->template_name ?? '') ?></td>
<td><?= htmlspecialchars($t->category_name ?? '') ?></td>
<td>CorpFile</td>
<td>
<a href="<?= base_url('mainadmin/edit_form/' . ($t->id ?? '')) ?>" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-pencil"></i> Edit</a>
<a href="<?= base_url('mainadmin/generate_form/' . ($t->id ?? '')) ?>" class="btn btn-xs btn-success" title="Generate"><i class="fa fa-file-text"></i> Generate</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div></div></div></div>

<script>
$(function(){
    if ($.fn.DataTable) {
        $('#datatable-templates').DataTable({
            pageLength: 50,
            lengthMenu: [[10,25,50,100,-1],[10,25,50,100,"All"]],
            order: [[2, 'asc']]
        });
    }
});
</script>
