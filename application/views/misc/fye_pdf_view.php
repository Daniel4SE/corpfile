<div class="page-title"><div class="title_left"><h3>FYE Date Not Entered - PDF View</h3></div><div class="title_right"><div class="pull-right">
<a href="<?= base_url('fye_listing') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
<button class="btn btn-primary" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
</div></div></div><div class="clearfix"></div>

<div class="row">
<div class="col-md-12">
<div class="x_panel">
<div class="x_title"><h2>Companies Without FYE Date</h2><div class="clearfix"></div></div>
<div class="x_content">
<p class="text-muted">The following companies do not have a Financial Year End date entered in the system.</p>
<table id="datatable-fye" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
<thead><tr style="background:#206570;color:#fff;">
<th>S/No</th><th>Company Name</th><th>UEN</th><th>Company Type</th><th>Incorporation Date</th><th>Entity Status</th><th>Action</th>
</tr></thead>
<tbody>
<?php $i=1; foreach ($companies as $c): ?>
<tr>
<td><?= $i++ ?></td>
<td><a href="<?= base_url('view_company/' . ($c->id ?? '')) ?>"><?= htmlspecialchars($c->company_name ?? '') ?></a></td>
<td><?= htmlspecialchars($c->registration_number ?? '') ?></td>
<td><?= htmlspecialchars($c->type_name ?? '-') ?></td>
<td><?= htmlspecialchars($c->date_of_incorporation ?? '-') ?></td>
<td><span class="label label-<?= ($c->entity_status ?? '') == 'Live' ? 'success' : 'default' ?>"><?= htmlspecialchars($c->entity_status ?? '') ?></span></td>
<td><a href="<?= base_url('edit_company/' . ($c->id ?? '')) ?>" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Set FYE</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div></div></div></div>
<script>$(function(){$('#datatable-fye').DataTable({dom:'Bfrtip',buttons:['copy','csv','excel','pdf','print']});});</script>
