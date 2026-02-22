<div class="page-title"><div class="title_left"><h3>Event Receiving Parties <?php if (!empty($company)): ?> - <?= htmlspecialchars($company->company_name) ?><?php endif; ?></h3></div><div class="title_right"><div class="pull-right">
<a href="javascript:history.back()" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
<button class="btn btn-primary" data-toggle="modal" data-target="#addPartyModal"><i class="fa fa-plus"></i> Add Party</button>
</div></div></div><div class="clearfix"></div>

<div class="row">
<div class="col-md-12">
<div class="x_panel">
<div class="x_title"><h2>Receiving Parties</h2><div class="clearfix"></div></div>
<div class="x_content">
<table id="datatable-parties" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
<thead><tr style="background:#206570;color:#fff;">
<th>S/No</th><th>Name</th><th>Email</th><th>Event Type</th><th>Status</th><th>Action</th>
</tr></thead>
<tbody>
<?php $i=1; foreach ($parties as $p): ?>
<tr>
<td><?= $i++ ?></td>
<td><?= htmlspecialchars($p->name ?? '') ?></td>
<td><?= htmlspecialchars($p->email ?? '-') ?></td>
<td><?= htmlspecialchars($p->event_type ?? 'All') ?></td>
<td><span class="label label-<?= ($p->status ?? '') == 'Active' ? 'success' : 'default' ?>"><?= htmlspecialchars($p->status ?? 'Active') ?></span></td>
<td><button class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></button> <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div></div></div></div>

<div class="modal fade" id="addPartyModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
<div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Add Receiving Party</h4></div>
<form method="post"><input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
<div class="modal-body">
<div class="form-group"><label>Name</label><input type="text" name="name" class="form-control" required></div>
<div class="form-group"><label>Email</label><input type="email" name="email" class="form-control"></div>
<div class="form-group"><label>Event Type</label><select name="event_type" class="form-control"><option value="All">All Events</option><option value="AGM">AGM</option><option value="AR">Annual Return</option><option value="FYE">FYE</option></select></div>
</div>
<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Add</button></div>
</form></div></div></div>
<script>$(function(){$('#datatable-parties').DataTable();});</script>
