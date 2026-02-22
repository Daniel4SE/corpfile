<?php if (!empty($flash['error'])): ?>
<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?= htmlspecialchars($flash['error']) ?></div>
<?php endif; ?>
<?php if (!empty($flash['success'])): ?>
<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?= htmlspecialchars($flash['success']) ?></div>
<?php endif; ?>

<!-- User Management Page -->
<div class="page-title">
    <div class="title_left">
        <h3>User Management</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('settings') ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back to Settings</a>
            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addUserModal"><i class="fa fa-plus"></i> Add User</button>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <!-- Filter Panel Toggle -->
                <button class="btn btn-primary btn-sm" id="toggleFilter" style="margin-bottom:10px;">
                    <i class="fa fa-filter"></i> Filter
                </button>

                <!-- Filter Panel -->
                <div id="filterPanel" style="display:none;background:#f9f9f9;padding:15px;border-radius:5px;margin-bottom:15px;">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Role</label>
                            <select class="form-control" id="filter_role">
                                <option value="">All</option>
                                <?php foreach ($roles as $r): ?>
                                <option value="<?= htmlspecialchars($r->role_name ?? '') ?>"><?= htmlspecialchars($r->role_name ?? '') ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Status</label>
                            <select class="form-control" id="filter_status">
                                <option value="">All</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-3" style="padding-top:25px;">
                            <button class="btn btn-success btn-sm" onclick="applyFilter()"><i class="fa fa-search"></i> Apply</button>
                            <button class="btn btn-default btn-sm" onclick="resetFilter()"><i class="fa fa-refresh"></i> Reset</button>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <table id="datatable-users" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No.</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; foreach ($users as $u): ?>
                        <tr>
                            <td><?= $sno++ ?></td>
                            <td><?= htmlspecialchars($u->name ?? '') ?></td>
                            <td><?= htmlspecialchars($u->username ?? '') ?></td>
                            <td><?= htmlspecialchars($u->email ?? '') ?></td>
                            <td><?= htmlspecialchars($u->role ?? 'User') ?></td>
                            <td><?= htmlspecialchars($u->department ?? '') ?></td>
                            <td>
                                <span class="label label-<?= ($u->status ?? 1) == 1 ? 'success' : 'danger' ?>">
                                    <?= ($u->status ?? 1) == 1 ? 'Active' : 'Inactive' ?>
                                </span>
                            </td>
                            <td><?= !empty($u->last_login) ? date('d/m/Y H:i', strtotime($u->last_login)) : 'Never' ?></td>
                            <td>
                                <a href="<?= base_url("user_settings/edit_user/{$u->id}") ?>" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-edit"></i></a>
                                <a href="<?= base_url("user_settings/view_user/{$u->id}") ?>" class="btn btn-primary btn-xs" title="View"><i class="fa fa-eye"></i></a>
                                <button class="btn btn-danger btn-xs delete-user" data-id="<?= $u->id ?>" title="Delete"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="<?= base_url('user_settings/add_user') ?>">
                <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-user-plus"></i> Add New User</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Role</label>
                                <select class="form-control" name="role">
                                    <?php if (!empty($roles)): ?>
                                        <?php foreach ($roles as $r): ?>
                                        <option value="<?= htmlspecialchars($r->role_name ?? '') ?>"><?= htmlspecialchars($r->role_name ?? '') ?></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="superadmin">Superadmin</option>
                                        <option value="admin">Admin</option>
                                        <option value="user" selected>User</option>
                                        <option value="viewer">Viewer</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Department</label>
                                <input type="text" class="form-control" name="department">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" name="phone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#datatable-users').DataTable({
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            order: [[1, 'asc']],
        });
    }

    $('#toggleFilter').click(function() { $('#filterPanel').slideToggle(); });

    // Delete user
    $('.delete-user').click(function() {
        var id = $(this).data('id');
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Are you sure?',
                text: "This user will be deactivated!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url("user_settings/delete_user/") ?>' + id;
                }
            });
        } else if (confirm('Are you sure you want to delete this user?')) {
            window.location.href = '<?= base_url("user_settings/delete_user/") ?>' + id;
        }
    });
});

function applyFilter() {
    var table = $('#datatable-users').DataTable();
    var role = $('#filter_role').val();
    var status = $('#filter_status').val();
    if (role) { table.columns(4).search(role).draw(); }
    else { table.columns(4).search('').draw(); }
    if (status) { table.columns(6).search(status).draw(); }
    else { table.columns(6).search('').draw(); }
}

function resetFilter() {
    var table = $('#datatable-users').DataTable();
    table.search('').columns().search('').draw();
    $('#filter_role').val('');
    $('#filter_status').val('');
}
</script>
