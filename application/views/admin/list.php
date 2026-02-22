<!-- Admin User Listing Page -->
<div class="page-title">
    <div class="title_left">
        <h3>All Admin Users</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('add_admin') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Admin</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-admins" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>User Group</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($admins)): ?>
                            <?php $sno = 1; foreach ($admins as $admin): ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td>
                                    <?php if (!empty($admin->profile_image)): ?>
                                        <img src="<?= base_url('public/uploads/profiles/' . $admin->profile_image) ?>" alt="" class="img-circle" style="width:30px;height:30px;margin-right:5px;">
                                    <?php else: ?>
                                        <img src="<?= base_url('public/images/user.png') ?>" alt="" class="img-circle" style="width:30px;height:30px;margin-right:5px;">
                                    <?php endif; ?>
                                    <?= htmlspecialchars($admin->name ?? '') ?>
                                </td>
                                <td><?= htmlspecialchars($admin->email ?? '') ?></td>
                                <td>
                                    <?php
                                    $role = $admin->role ?? 'User';
                                    $role_badge = 'label-default';
                                    if ($role === 'Super Admin') $role_badge = 'label-danger';
                                    elseif ($role === 'Admin') $role_badge = 'label-primary';
                                    elseif ($role === 'User') $role_badge = 'label-info';
                                    elseif ($role === 'Viewer') $role_badge = 'label-warning';
                                    ?>
                                    <span class="label <?= $role_badge ?>"><?= htmlspecialchars($role) ?></span>
                                </td>
                                <td><?= htmlspecialchars($admin->group_name ?? '') ?></td>
                                <td>
                                    <?php $status = $admin->status ?? 'Active'; ?>
                                    <span class="label label-<?= $status === 'Active' ? 'success' : 'danger' ?>"><?= htmlspecialchars($status) ?></span>
                                </td>
                                <td><?= !empty($admin->last_login) ? date('d/m/Y H:i', strtotime($admin->last_login)) : 'Never' ?></td>
                                <td>
                                    <a href="<?= base_url('edit_admin/' . ($admin->id ?? '')) ?>" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                                    <a href="<?= base_url('page_access_rights/' . ($admin->id ?? '')) ?>" class="btn btn-warning btn-xs" title="Permissions"><i class="fa fa-key"></i></a>
                                    <button class="btn btn-danger btn-xs delete-admin" data-id="<?= $admin->id ?? '' ?>" title="Delete"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted">No admin users found.</td>
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
        $('#datatable-admins').DataTable({
            pageLength: 10,
            lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
            order: [[1, 'asc']],
        });
    }

    $('.delete-admin').click(function() {
        var id = $(this).data('id');
        if (typeof swal !== 'undefined') {
            swal({
                title: "Are you sure?",
                text: "This admin user will be permanently deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }, function(isConfirm) {
                if (isConfirm) {
                    window.location.href = '<?= base_url("admin/delete/") ?>' + id;
                }
            });
        } else if (confirm('Are you sure you want to delete this admin?')) {
            window.location.href = '<?= base_url("admin/delete/") ?>' + id;
        }
    });
});
</script>
