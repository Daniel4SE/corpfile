<!-- CRM Tasks Listing -->
<div class="page-title">
    <div class="title_left">
        <h3>Tasks</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('crm_tasks/add') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Task</a>
            <a href="<?= base_url('crm_dashboard') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to CRM</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-tasks" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Task</th>
                            <th>Project</th>
                            <th>Assigned To</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tasks)): ?>
                            <?php $sno = 1; foreach ($tasks as $t): ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><?= htmlspecialchars($t->name ?? '') ?></td>
                                <td><?= htmlspecialchars($t->project ?? '') ?></td>
                                <td><?= htmlspecialchars($t->assigned_to ?? '') ?></td>
                                <td>
                                    <?php
                                    $priority = $t->priority ?? 'Medium';
                                    $badge = 'label-warning';
                                    if ($priority === 'High') $badge = 'label-danger';
                                    elseif ($priority === 'Low') $badge = 'label-info';
                                    elseif ($priority === 'Urgent') $badge = 'label-danger';
                                    ?>
                                    <span class="label <?= $badge ?>"><?= htmlspecialchars($priority) ?></span>
                                </td>
                                <td>
                                    <?php
                                    $status = $t->status ?? 'Pending';
                                    $sbadge = 'label-default';
                                    if ($status === 'In Progress') $sbadge = 'label-info';
                                    elseif ($status === 'Completed') $sbadge = 'label-success';
                                    elseif ($status === 'Overdue') $sbadge = 'label-danger';
                                    ?>
                                    <span class="label <?= $sbadge ?>"><?= htmlspecialchars($status) ?></span>
                                </td>
                                <td><?= isset($t->due_date) ? date('d/m/Y', strtotime($t->due_date)) : '' ?></td>
                                <td>
                                    <a href="<?= base_url('crm_tasks/view/' . ($t->id ?? '')) ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
                                    <a href="<?= base_url('crm_tasks/edit/' . ($t->id ?? '')) ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-xs delete-item" data-id="<?= $t->id ?? '' ?>"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted">No tasks found.</td>
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
        $('#datatable-tasks').DataTable({
            pageLength: 10,
            lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
            order: [[6, 'asc']],
        });
    }
    if ($.fn.select2) { $('.select2').select2(); }
});
</script>
