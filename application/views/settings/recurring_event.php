<div class="page-title"><div class="title_left"><h3>Recurring Event Names</h3></div><div class="title_right"><div class="pull-right">
<a href="<?= base_url('settings') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
<button class="btn btn-primary" data-toggle="modal" data-target="#addEventModal"><i class="fa fa-plus"></i> Add Event</button>
</div></div></div><div class="clearfix"></div>

<div class="row">
<div class="col-md-12">
<div class="x_panel">
<div class="x_title"><h2>Recurring Events</h2><div class="clearfix"></div></div>
<div class="x_content">
<table id="datatable-events" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
<thead><tr style="background:#206570;color:#fff;">
<th>S/No</th><th>Event Name</th><th>Category</th><th>Frequency</th><th>Interval (Days)</th><th>Status</th><th>Action</th>
</tr></thead>
<tbody>
<?php $i=1; foreach ($events as $e): ?>
<tr>
<td><?= $i++ ?></td>
<td><?= htmlspecialchars($e->event_name ?? '') ?></td>
<td><?= htmlspecialchars($e->category ?? '-') ?></td>
<td><?= htmlspecialchars($e->frequency ?? 'Annually') ?></td>
<td><?= htmlspecialchars($e->recurring_interval ?? '-') ?></td>
<td><span class="label label-<?= ($e->status ?? '') == 'Active' ? 'success' : 'default' ?>"><?= htmlspecialchars($e->status ?? 'Active') ?></span></td>
<td><button class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></button> <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div></div></div></div>

<div class="modal fade" id="addEventModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
<div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Add Recurring Event</h4></div>
<form method="post"><input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
<div class="modal-body">
<div class="form-group"><label>Event Name</label><input type="text" name="event_name" class="form-control" required></div>
<div class="form-group"><label>Category</label><input type="text" name="category" class="form-control"></div>
<div class="form-group"><label>Frequency</label><select name="frequency" class="form-control"><option>Annually</option><option>Semi-Annually</option><option>Quarterly</option><option>Monthly</option><option>Custom</option></select></div>
<div class="form-group"><label>Interval (Days)</label><input type="number" name="recurring_interval" class="form-control" value="365"></div>
<div class="form-group"><label>Status</label><select name="status" class="form-control"><option value="Active">Active</option><option value="Inactive">Inactive</option></select></div>
</div>
<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Save</button></div>
</form></div></div></div>
<script>$(function(){$('#datatable-events').DataTable();});</script>
