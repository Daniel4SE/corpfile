<div class="page-title"><div class="title_left"><h3>Registered Office Address List</h3></div><div class="title_right"><div class="pull-right"><a href="<?= base_url('company_list') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a></div></div></div><div class="clearfix"></div>

<div class="row">
<div class="col-md-12">
<div class="x_panel">
<div class="x_title"><h2>Registered Addresses</h2><div class="clearfix"></div></div>
<div class="x_content">
<table id="datatable-regaddr" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
<thead><tr style="background:#206570;color:#fff;">
<th>S/No</th><th>Company Name</th><th>UEN</th><th>Registered Address</th><th>Postal Code</th><th>Effective Date</th><th>Status</th><th>Action</th>
</tr></thead>
<tbody>
<?php $i=1; foreach ($addresses as $a): ?>
<tr>
<td><?= $i++ ?></td>
<td><a href="<?= base_url('view_company/' . ($a->id ?? '')) ?>"><?= htmlspecialchars($a->company_name ?? '') ?></a></td>
<td><?= htmlspecialchars($a->registration_number ?? '') ?></td>
<td><?= htmlspecialchars($a->registered_address ?? '-') ?></td>
<td><?= htmlspecialchars($a->postal_code ?? '-') ?></td>
<td><?= htmlspecialchars($a->date_of_incorporation ?? '-') ?></td>
<td><span class="label label-<?= ($a->entity_status ?? '') == 'Live' ? 'success' : 'default' ?>"><?= htmlspecialchars($a->entity_status ?? '') ?></span></td>
<td><a href="<?= base_url('view_company/' . ($a->id ?? '')) ?>" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div></div></div></div>
<script>$(function(){$('#datatable-regaddr').DataTable({dom:'Bfrtip',buttons:['copy','csv','excel','pdf','print']});});</script>
