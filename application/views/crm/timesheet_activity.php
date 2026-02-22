<div class="page-title"><div class="title_left"><h3>Timesheet Activity Report</h3></div><div class="title_right"><div class="pull-right">
<a href="<?= base_url('crm_timesheets') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
</div></div></div><div class="clearfix"></div>

<div class="row">
<div class="col-md-12">
<div class="x_panel">
<div class="x_title"><h2>Activity Log</h2><div class="clearfix"></div></div>
<div class="x_content">
<form method="get" class="form-inline" style="margin-bottom:20px;">
<div class="form-group"><label>Date Range: </label> <input type="text" name="daterange" class="form-control" id="daterange" value="<?= htmlspecialchars($filter_daterange ?? '') ?>" placeholder="Select date range"></div>
<div class="form-group" style="margin-left:15px;"><label>User: </label>
<select name="user_id[]" class="form-control select2_multiple" multiple style="width:250px;">
<?php foreach ($users as $u): ?><option value="<?= $u->id ?>"><?= htmlspecialchars($u->name) ?></option><?php endforeach; ?>
</select></div>
<div class="form-group" style="margin-left:15px;"><label>Project: </label>
<select name="project_id[]" class="form-control select2_multiple" multiple style="width:250px;">
<?php foreach ($projects as $p): ?><option value="<?= $p->id ?>"><?= htmlspecialchars($p->project_name ?? '') ?></option><?php endforeach; ?>
</select></div>
<button type="submit" class="btn btn-primary" style="margin-left:10px;"><i class="fa fa-filter"></i> Filter</button>
</form>

<table id="datatable-ts-activity" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
<thead><tr style="background:#206570;color:#fff;">
<th>S/No</th><th>Date</th><th>User</th><th>Project</th><th>Task</th><th>Hours</th><th>Description</th><th>Billable</th>
</tr></thead>
<tbody>
<?php $i=1; foreach ($activities as $a): ?>
<tr>
<td><?= $i++ ?></td>
<td><?= htmlspecialchars($a->date ?? '-') ?></td>
<td><?= htmlspecialchars($a->user_name ?? '-') ?></td>
<td><?= htmlspecialchars($a->project_name ?? '-') ?></td>
<td><?= htmlspecialchars($a->task_name ?? '-') ?></td>
<td><?= htmlspecialchars($a->hours ?? 0) ?></td>
<td><?= htmlspecialchars($a->description ?? '-') ?></td>
<td><?= ($a->billable ?? 0) ? '<span class="label label-success">Yes</span>' : '<span class="label label-default">No</span>' ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div></div></div></div>
<script>$(function(){$('#datatable-ts-activity').DataTable({dom:'Bfrtip',buttons:['copy','csv','excel','pdf','print']});$('.select2_multiple').select2();$('#daterange').daterangepicker({autoUpdateInput:false});});</script>
