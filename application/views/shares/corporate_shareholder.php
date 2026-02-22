<div class="page-title"><div class="title_left"><h3>Corporate Shareholder - Company List</h3></div><div class="title_right"><div class="pull-right"><a href="<?= base_url('company_list') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a></div></div></div><div class="clearfix"></div>

<div class="row">
<div class="col-md-12">
<div class="x_panel">
<div class="x_title"><h2>Companies with Corporate Shareholders</h2><div class="clearfix"></div></div>
<div class="x_content">
<table id="datatable-corp-sh" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
<thead><tr style="background:#206570;color:#fff;">
<th>S/No</th><th>Company Name</th><th>UEN</th><th>Corporate Shareholder</th><th>Country</th><th>Share Type</th><th>No. of Shares</th><th>Status</th><th>Action</th>
</tr></thead>
<tbody>
<?php $i=1; foreach ($shareholders as $s): ?>
<tr>
<td><?= $i++ ?></td>
<td><a href="<?= base_url('view_company/' . ($s->company_id ?? '')) ?>"><?= htmlspecialchars($s->company_name ?? '') ?></a></td>
<td><?= htmlspecialchars($s->registration_number ?? '') ?></td>
<td><?= htmlspecialchars($s->name ?? '') ?></td>
<td><?= htmlspecialchars($s->corp_country ?? $s->nationality ?? '-') ?></td>
<td>Ordinary</td>
<td><?= htmlspecialchars($s->total_shares ?? '0') ?></td>
<td><span class="label label-<?= ($s->status ?? '') == 'Active' ? 'success' : 'default' ?>"><?= htmlspecialchars($s->status ?? '') ?></span></td>
<td><a href="<?= base_url('company_officials/' . ($s->company_id ?? '')) ?>" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div></div></div></div>
<script>$(function(){$('#datatable-corp-sh').DataTable({dom:'Bfrtip',buttons:['copy','csv','excel','pdf','print']});});</script>
