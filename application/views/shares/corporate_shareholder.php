<div class="page-title"><div class="title_left"><h3>Corporate Shareholder - Company List</h3></div><div class="title_right"><div class="pull-right"><a href="<?= base_url('company_list') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a></div></div></div><div class="clearfix"></div>

<div class="row">
<div class="col-md-12">
<div class="x_panel">
<div class="x_title"><h2>Corporate Shareholders <small>(<?= count($companies) ?> records)</small></h2><div class="clearfix"></div></div>
<div class="x_content">
<table id="datatable_register_charge" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
<thead><tr style="background:#206570;color:#fff;">
<th>S/No.</th><th>Company Name</th><th>Client ID</th><th>Registration No.</th><th>Registered Office Address</th><th>Foreign Address</th><th>Country</th><th>Action</th>
</tr></thead>
<tbody>
<?php $i=1; foreach ($companies as $c): ?>
<tr>
<td><?= $i++ ?></td>
<td><a href="<?= base_url('view_company/' . ($c->id ?? '')) ?>"><?= htmlspecialchars($c->company_name ?? '') ?></a></td>
<td></td>
<td><?= htmlspecialchars($c->registration_number ?? '') ?></td>
<td><?= htmlspecialchars($c->registered_address ?? 'Not Specified') ?></td>
<td><?= htmlspecialchars($c->foreign_address ?? 'Not Specified') ?></td>
<td><?= htmlspecialchars($c->country ?? '') ?></td>
<td>
<a href="<?= base_url('edit_company/' . ($c->id ?? '')) ?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit</a>
<a href="<?= base_url('view_company/' . ($c->id ?? '')) ?>" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a>
<a href="#" class="btn btn-xs btn-warning"><i class="fa fa-file-pdf-o"></i> Pdf</a>
<a href="#" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> Delete</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div></div></div></div>
<script>$(function(){$('#datatable_register_charge').DataTable({dom:'Bfrtip',buttons:['copy','csv','excel','pdf','print']});});</script>
