<!-- CRM Timesheets Listing -->
<div class="page-title">
    <div class="title_left">
        <h3>Timesheets</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('crm_timesheets/add') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Entry</a>
            <a href="<?= base_url('crm_dashboard') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to CRM</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-timesheets" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>Date</th>
                            <th>User</th>
                            <th>Project</th>
                            <th>Task</th>
                            <th>Hours</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($timesheets)): ?>
                            <?php foreach ($timesheets as $ts): ?>
                            <tr>
                                <td><?= isset($ts->date) ? date('d/m/Y', strtotime($ts->date)) : '' ?></td>
                                <td><?= htmlspecialchars($ts->user ?? '') ?></td>
                                <td><?= htmlspecialchars($ts->project ?? '') ?></td>
                                <td><?= htmlspecialchars($ts->task ?? '') ?></td>
                                <td><?= number_format($ts->hours ?? 0, 1) ?></td>
                                <td><?= htmlspecialchars($ts->description ?? '') ?></td>
                                <td>
                                    <a href="<?= base_url('crm_timesheets/edit/' . ($ts->id ?? '')) ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-xs delete-item" data-id="<?= $ts->id ?? '' ?>"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">No timesheet entries found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#datatable-timesheets').DataTable({
            pageLength: 10,
            lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
            order: [[0, 'desc']],
        });
    }
    if ($.fn.select2) { $('.select2').select2(); }
});
</script>
