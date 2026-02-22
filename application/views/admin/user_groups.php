<!-- User Groups Listing -->
<div class="page-title">
    <div class="title_left">
        <h3>User Groups</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('add_user_group') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Group</a>
            <a href="<?= base_url('user_groups_permissions') ?>" class="btn btn-warning"><i class="fa fa-key"></i> Group Permissions</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-groups" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Group Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($groups)): ?>
                            <?php $sno = 1; foreach ($groups as $g): ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><?= htmlspecialchars($g->group_name ?? '') ?></td>
                                <td><?= htmlspecialchars($g->description ?? '') ?></td>
                                <td>
                                    <span class="label label-<?= ($g->status ?? 0) == 1 ? 'success' : 'danger' ?>">
                                        <?= ($g->status ?? 0) == 1 ? 'Active' : 'Inactive' ?>
                                    </span>
                                </td>
                                <td><?= !empty($g->created_at) ? date('d/m/Y', strtotime($g->created_at)) : '' ?></td>
                                <td>
                                    <a href="<?= base_url('edit_user_group/' . ($g->id ?? '')) ?>" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-xs delete-group" data-id="<?= $g->id ?? '' ?>" title="Delete"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No user groups found.</td>
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
        $('#datatable-groups').DataTable({
            pageLength: 10,
            order: [[1, 'asc']],
        });
    }

    $('.delete-group').click(function() {
        var id = $(this).data('id');
        if (typeof swal !== 'undefined') {
            swal({
                title: "Are you sure?",
                text: "This user group will be permanently deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }, function(isConfirm) {
                if (isConfirm) {
                    window.location.href = '<?= base_url("admin/delete_group/") ?>' + id;
                }
            });
        } else if (confirm('Delete this user group?')) {
            window.location.href = '<?= base_url("admin/delete_group/") ?>' + id;
        }
    });
});
</script>
