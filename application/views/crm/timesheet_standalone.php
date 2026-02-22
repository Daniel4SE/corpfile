<div class="page-title"><div class="title_left"><h3>Weekly Timesheet</h3></div><div class="title_right"><div class="pull-right">
<a href="<?= base_url('crm_timesheets') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to List</a>
</div></div></div><div class="clearfix"></div>

<div class="row">
<div class="col-md-12">
<div class="x_panel">
<div class="x_title"><h2>Timesheet Entry</h2><div class="clearfix"></div></div>
<div class="x_content">
<form method="get" class="form-inline" style="margin-bottom:20px;">
<div class="form-group"><label>Week: </label> <input type="week" name="week" class="form-control" value="<?= htmlspecialchars($current_week ?? date('Y-\WW')) ?>"></div>
<div class="form-group" style="margin-left:15px;"><label>User: </label>
<select name="user_id" class="form-control select2_single">
<?php foreach ($users as $u): ?><option value="<?= $u->id ?>" <?= ($filter_user ?? '') == $u->id ? 'selected' : '' ?>><?= htmlspecialchars($u->name) ?></option><?php endforeach; ?>
</select></div>
<button type="submit" class="btn btn-primary" style="margin-left:10px;">Load</button>
</form>

<table class="table table-bordered">
<thead><tr style="background:#206570;color:#fff;">
<th>Project / Task</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th><th>Sun</th><th>Total</th>
</tr></thead>
<tbody>
<?php if (!empty($timesheet_rows)):
foreach ($timesheet_rows as $row): ?>
<tr>
<td><?= htmlspecialchars($row->project_name ?? '') ?> / <?= htmlspecialchars($row->task_name ?? '') ?></td>
<?php for ($d=0; $d<7; $d++): $key="day{$d}"; ?>
<td><input type="number" class="form-control input-sm ts-hour" style="width:60px;" value="<?= $row->$key ?? 0 ?>" step="0.5" min="0" max="24"></td>
<?php endfor; ?>
<td><strong class="row-total"><?= $row->total_hours ?? 0 ?></strong></td>
</tr>
<?php endforeach; else: ?>
<tr><td colspan="9" class="text-center text-muted">No timesheet entries for this week. Click "Add Row" to start.</td></tr>
<?php endif; ?>
</tbody>
<tfoot><tr><th>Total</th><th colspan="7"></th><th id="grand-total"><strong>0</strong></th></tr></tfoot>
</table>
<button class="btn btn-sm btn-info" id="addRow"><i class="fa fa-plus"></i> Add Row</button>
<button class="btn btn-primary pull-right" id="saveTimesheet"><i class="fa fa-save"></i> Save Timesheet</button>
</div></div></div></div>

<script>
$(function(){
    function calcTotals(){
        var grand=0;
        $('tbody tr').each(function(){
            var t=0; $(this).find('.ts-hour').each(function(){t+=parseFloat($(this).val())||0;});
            $(this).find('.row-total').text(t.toFixed(1)); grand+=t;
        });
        $('#grand-total strong').text(grand.toFixed(1));
    }
    $(document).on('change','.ts-hour',calcTotals);
    calcTotals();
});
</script>
