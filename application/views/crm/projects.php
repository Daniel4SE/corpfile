<!-- CRM Projects Listing -->
<div class="page-title">
    <div class="title_left">
        <h3>Projects</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('crm_projects/add') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Project</a>
            <a href="<?= base_url('crm_dashboard') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to CRM</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-projects" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Project Name</th>
                            <th>Client</th>
                            <th>Status</th>
                            <th>Progress</th>
                            <th>Start Date</th>
                            <th>Due Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($projects)): ?>
                            <?php $sno = 1; foreach ($projects as $p): ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><?= htmlspecialchars($p->name ?? '') ?></td>
                                <td><?= htmlspecialchars($p->client ?? '') ?></td>
                                <td>
                                    <?php
                                    $status = $p->status ?? 'Not Started';
                                    $badge = 'label-default';
                                    if ($status === 'In Progress') $badge = 'label-info';
                                    elseif ($status === 'Completed') $badge = 'label-success';
                                    elseif ($status === 'On Hold') $badge = 'label-warning';
                                    elseif ($status === 'Cancelled') $badge = 'label-danger';
                                    ?>
                                    <span class="label <?= $badge ?>"><?= htmlspecialchars($status) ?></span>
                                </td>
                                <td>
                                    <div class="progress" style="margin-bottom:0;">
                                        <div class="progress-bar progress-bar-success" role="progressbar" style="width: <?= $p->progress ?? 0 ?>%">
                                            <?= $p->progress ?? 0 ?>%
                                        </div>
                                    </div>
                                </td>
                                <td><?= isset($p->start_date) ? date('d/m/Y', strtotime($p->start_date)) : '' ?></td>
                                <td><?= isset($p->due_date) ? date('d/m/Y', strtotime($p->due_date)) : '' ?></td>
                                <td>
                                    <a href="<?= base_url('crm_projects/view/' . ($p->id ?? '')) ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
                                    <a href="<?= base_url('crm_projects/edit/' . ($p->id ?? '')) ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-xs delete-item" data-id="<?= $p->id ?? '' ?>"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted">No projects found.</td>
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
        $('#datatable-projects').DataTable({
            pageLength: 10,
            lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
            order: [[5, 'desc']],
        });
    }
    if ($.fn.select2) { $('.select2').select2(); }
});
</script>
