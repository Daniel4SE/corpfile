<div class="page-title"><div class="title_left"><h3>Team Management</h3></div><div class="title_right"><div class="pull-right">
<button class="btn btn-primary" data-toggle="modal" data-target="#addTeamModal"><i class="fa fa-plus"></i> Create Team</button>
</div></div></div><div class="clearfix"></div>

<div class="row">
<div class="col-md-12">
<div class="x_panel">
<div class="x_title"><h2>Teams</h2><div class="clearfix"></div></div>
<div class="x_content">
<table id="datatable-teams" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
<thead><tr style="background:#206570;color:#fff;">
<th>S/No</th><th>Team Name</th><th>Leader</th><th>Members</th><th>Created Date</th><th>Status</th><th>Action</th>
</tr></thead>
<tbody>
<?php $i=1; foreach ($teams as $t): ?>
<tr>
<td><?= $i++ ?></td>
<td><?= htmlspecialchars($t->team_name ?? '') ?></td>
<td><?= htmlspecialchars($t->leader_name ?? '-') ?></td>
<td><span class="badge"><?= $t->member_count ?? 0 ?></span></td>
<td><?= htmlspecialchars($t->created_at ?? '-') ?></td>
<td><span class="label label-<?= ($t->status ?? '') == 'Active' ? 'success' : 'default' ?>"><?= htmlspecialchars($t->status ?? 'Active') ?></span></td>
<td>
<button class="btn btn-xs btn-info btn-view-team" data-id="<?= $t->id ?? '' ?>"><i class="fa fa-eye"></i></button>
<button class="btn btn-xs btn-warning btn-edit-team" data-id="<?= $t->id ?? '' ?>"><i class="fa fa-pencil"></i></button>
<button class="btn btn-xs btn-danger btn-delete-team" data-id="<?= $t->id ?? '' ?>"><i class="fa fa-trash"></i></button>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div></div></div></div>

<!-- Add Team Modal -->
<div class="modal fade" id="addTeamModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
<div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Create Team</h4></div>
<form method="post"><input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
<div class="modal-body">
<div class="form-group"><label>Team Name <span class="required">*</span></label><input type="text" name="team_name" class="form-control" required></div>
<div class="form-group"><label>Team Leader</label><select name="leader_id" class="form-control select2_single">
<option value="">-- Select --</option>
<?php foreach ($users as $u): ?><option value="<?= $u->id ?>"><?= htmlspecialchars($u->name) ?></option><?php endforeach; ?>
</select></div>
<div class="form-group"><label>Members</label><select name="members[]" class="form-control select2_multiple" multiple>
<?php foreach ($users as $u): ?><option value="<?= $u->id ?>"><?= htmlspecialchars($u->name) ?></option><?php endforeach; ?>
</select></div>
</div>
<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Create</button></div>
</form></div></div></div>

<script>$(function(){$('#datatable-teams').DataTable();$('.select2_multiple').select2();});</script>
