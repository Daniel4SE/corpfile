<div class="page-title"><div class="title_left"><h3>Product Agent Commission Setup</h3></div><div class="title_right"><div class="pull-right">
<a href="<?= base_url('settings') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
<button class="btn btn-primary" data-toggle="modal" data-target="#addCommModal"><i class="fa fa-plus"></i> Add Commission Rule</button>
</div></div></div><div class="clearfix"></div>

<div class="row">
<div class="col-md-12">
<div class="x_panel">
<div class="x_title"><h2>Commission Rules</h2><div class="clearfix"></div></div>
<div class="x_content">
<table id="datatable-comm" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
<thead><tr style="background:#206570;color:#fff;">
<th>S/No</th><th>Product/Service</th><th>Agent</th><th>Commission Type</th><th>Rate / Amount</th><th>Status</th><th>Action</th>
</tr></thead>
<tbody>
<?php $i=1; foreach ($commissions as $c): ?>
<tr>
<td><?= $i++ ?></td>
<td><?= htmlspecialchars($c->product_name ?? '') ?></td>
<td><?= htmlspecialchars($c->agent_name ?? '-') ?></td>
<td><?= htmlspecialchars($c->commission_type ?? 'Percentage') ?></td>
<td><?= ($c->commission_type ?? '') == 'Fixed' ? '$' . number_format($c->rate ?? 0, 2) : ($c->rate ?? 0) . '%' ?></td>
<td><span class="label label-<?= ($c->status ?? '') == 'Active' ? 'success' : 'default' ?>"><?= htmlspecialchars($c->status ?? 'Active') ?></span></td>
<td><button class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></button> <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div></div></div></div>

<div class="modal fade" id="addCommModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
<div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Add Commission Rule</h4></div>
<form method="post"><input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
<div class="modal-body">
<div class="form-group"><label>Product/Service</label><input type="text" name="product_name" class="form-control" required></div>
<div class="form-group"><label>Agent</label><select name="agent_id" class="form-control select2_single">
<option value="">-- Select --</option>
<?php foreach ($users ?? [] as $u): ?><option value="<?= $u->id ?>"><?= htmlspecialchars($u->name) ?></option><?php endforeach; ?>
</select></div>
<div class="form-group"><label>Commission Type</label><select name="commission_type" class="form-control"><option value="Percentage">Percentage</option><option value="Fixed">Fixed Amount</option></select></div>
<div class="form-group"><label>Rate / Amount</label><input type="number" name="rate" class="form-control" step="0.01"></div>
</div>
<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Save</button></div>
</form></div></div></div>
<script>$(function(){$('#datatable-comm').DataTable();});</script>
