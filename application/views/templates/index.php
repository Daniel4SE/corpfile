<!-- Template Management -->
<div class="page-title">
    <div class="title_left">
        <h3>Template Management</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('templates/add') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Template</a>
            <a href="<?= base_url('templates/upload') ?>" class="btn btn-primary"><i class="fa fa-upload"></i> Upload Template</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-templates" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Template Name</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Last Modified</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($templates)): ?>
                            <?php $sno = 1; foreach ($templates as $t): ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><?= htmlspecialchars($t->name ?? '') ?></td>
                                <td><?= htmlspecialchars($t->category ?? '') ?></td>
                                <td><?= htmlspecialchars($t->type ?? '') ?></td>
                                <td><?= isset($t->updated_at) ? date('d/m/Y', strtotime($t->updated_at)) : '' ?></td>
                                <td>
                                    <span class="label label-<?= ($t->status ?? 'Active') === 'Active' ? 'success' : 'default' ?>">
                                        <?= htmlspecialchars($t->status ?? 'Active') ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= base_url('templates/preview/' . ($t->id ?? '')) ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
                                    <a href="<?= base_url('templates/edit/' . ($t->id ?? '')) ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                                    <a href="<?= base_url('templates/download/' . ($t->id ?? '')) ?>" class="btn btn-default btn-xs"><i class="fa fa-download"></i></a>
                                    <button class="btn btn-danger btn-xs delete-item" data-id="<?= $t->id ?? '' ?>"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">No templates found. <a href="<?= base_url('templates/add') ?>">Create your first template</a>.</td>
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
        $('#datatable-templates').DataTable({
            pageLength: 10,
            lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
            order: [[4, 'desc']],
        });
    }
    if ($.fn.select2) { $('.select2').select2(); }
});
</script>
