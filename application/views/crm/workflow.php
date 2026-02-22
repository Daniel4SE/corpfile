<div class="page-title"><div class="title_left"><h3>AGM Automation Workflow</h3></div><div class="title_right"><div class="pull-right">
<a href="<?= base_url('event_tracker') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
<button class="btn btn-primary" data-toggle="modal" data-target="#addWorkflowModal"><i class="fa fa-plus"></i> Add Workflow</button>
</div></div></div><div class="clearfix"></div>

<div class="row">
<div class="col-md-12">
<div class="x_panel">
<div class="x_title"><h2>Workflow Rules</h2>
<ul class="nav navbar-right panel_toolbox"><li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li></ul>
<div class="clearfix"></div></div>
<div class="x_content">
<!-- Tab Navigation -->
<ul class="nav nav-tabs bar_tabs">
<li class="active"><a href="#tab_unallocated" data-toggle="tab">Unallocated</a></li>
<li><a href="#tab_allocated" data-toggle="tab">Allocated</a></li>
<li><a href="#tab_completed" data-toggle="tab">Completed</a></li>
</ul>
<div class="tab-content">
<div class="tab-pane active" id="tab_unallocated">
<table class="table table-striped table-bordered dataTable" style="margin-top:15px;">
<thead><tr style="background:#206570;color:#fff;">
<th><input type="checkbox" class="check-all"></th><th>S/No</th><th>Company Name</th><th>UEN</th><th>Event Type</th><th>Due Date</th><th>Days Remaining</th><th>Action</th>
</tr></thead>
<tbody>
<?php $i=1; foreach ($unallocated as $w): ?>
<tr>
<td><input type="checkbox" name="selected[]" value="<?= $w->id ?? '' ?>"></td>
<td><?= $i++ ?></td>
<td><?= htmlspecialchars($w->company_name ?? '') ?></td>
<td><?= htmlspecialchars($w->registration_number ?? '') ?></td>
<td><?= htmlspecialchars($w->event_type ?? 'AGM') ?></td>
<td><?= htmlspecialchars($w->due_date ?? '-') ?></td>
<td><?php $days = !empty($w->due_date) ? (int)((strtotime($w->due_date) - time()) / 86400) : 0; ?>
<span class="label label-<?= $days < 0 ? 'danger' : ($days < 30 ? 'warning' : 'success') ?>"><?= $days ?> days</span></td>
<td><a href="<?= base_url('view_company/' . ($w->company_id ?? $w->id ?? '')) ?>" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
<button class="btn btn-xs btn-primary btn-allocate" data-id="<?= $w->id ?? '' ?>"><i class="fa fa-user-plus"></i> Allocate</button></td>
</tr>
<?php endforeach; ?>
</tbody></table>
<button class="btn btn-primary btn-sm" id="bulkAllocate"><i class="fa fa-users"></i> Bulk Allocate Selected</button>
</div>
<div class="tab-pane" id="tab_allocated">
<table class="table table-striped table-bordered dataTable" style="margin-top:15px;">
<thead><tr style="background:#206570;color:#fff;"><th>S/No</th><th>Company</th><th>Event</th><th>Assigned To</th><th>Due Date</th><th>Status</th><th>Action</th></tr></thead>
<tbody>
<?php $i=1; foreach ($allocated as $w): ?>
<tr><td><?= $i++ ?></td><td><?= htmlspecialchars($w->company_name ?? '') ?></td><td><?= htmlspecialchars($w->event_type ?? 'AGM') ?></td><td><?= htmlspecialchars($w->assigned_to_name ?? '-') ?></td><td><?= htmlspecialchars($w->due_date ?? '-') ?></td><td><span class="label label-info">In Progress</span></td><td><button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Complete</button></td></tr>
<?php endforeach; ?>
</tbody></table>
</div>
<div class="tab-pane" id="tab_completed">
<table class="table table-striped table-bordered dataTable" style="margin-top:15px;">
<thead><tr style="background:#206570;color:#fff;"><th>S/No</th><th>Company</th><th>Event</th><th>Completed By</th><th>Completed Date</th></tr></thead>
<tbody>
<?php $i=1; foreach ($completed as $w): ?>
<tr><td><?= $i++ ?></td><td><?= htmlspecialchars($w->company_name ?? '') ?></td><td><?= htmlspecialchars($w->event_type ?? 'AGM') ?></td><td><?= htmlspecialchars($w->assigned_to_name ?? '-') ?></td><td><?= htmlspecialchars($w->completed_date ?? '-') ?></td></tr>
<?php endforeach; ?>
</tbody></table>
</div>
</div></div></div></div></div>
<script>$(function(){$('.dataTable').DataTable();$('.check-all').change(function(){$('input[name="selected[]"]').prop('checked',this.checked);});});</script>
