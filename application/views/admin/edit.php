<!-- Edit Admin User Form -->
<div class="page-title">
    <div class="title_left">
        <h3>Edit Admin User</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('alladmin') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to List</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-user"></i> Edit Admin - <?= htmlspecialchars($admin->name ?? '') ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php if (!$admin): ?>
                    <div class="alert alert-danger">Admin user not found.</div>
                <?php else: ?>
                <form method="POST" action="<?= base_url('edit_admin/' . ($admin->id ?? '')) ?>" enctype="multipart/form-data" class="form-horizontal form-label-left">
                    <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($admin->name ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($admin->email ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Role <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="role" class="form-control" required>
                                <option value="Super Admin" <?= ($admin->role ?? '') === 'Super Admin' ? 'selected' : '' ?>>Super Admin</option>
                                <option value="Admin" <?= ($admin->role ?? '') === 'Admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="User" <?= ($admin->role ?? '') === 'User' ? 'selected' : '' ?>>User</option>
                                <option value="Viewer" <?= ($admin->role ?? '') === 'Viewer' ? 'selected' : '' ?>>Viewer</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">User Group</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="user_group" class="form-control select2_single" style="width:100%;">
                                <option value="">Select User Group</option>
                                <?php if (!empty($user_groups)): ?>
                                    <?php foreach ($user_groups as $ug): ?>
                                    <option value="<?= $ug->id ?? '' ?>" <?= ($admin->user_group_id ?? '') == ($ug->id ?? '') ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($ug->group_name ?? '') ?>
                                    </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Branch</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="branch" class="form-control select2_single" style="width:100%;">
                                <option value="">Select Branch</option>
                                <?php if (!empty($branches)): ?>
                                    <?php foreach ($branches as $b): ?>
                                    <option value="<?= $b->id ?? '' ?>" <?= ($admin->branch_id ?? '') == ($b->id ?? '') ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($b->branch_name ?? '') ?>
                                    </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="status" class="form-control">
                                <option value="Active" <?= ($admin->status ?? '') === 'Active' ? 'selected' : '' ?>>Active</option>
                                <option value="Inactive" <?= ($admin->status ?? '') === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($admin->phone ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Profile Image</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php if (!empty($admin->profile_image)): ?>
                                <div style="margin-bottom:10px;">
                                    <img src="<?= base_url('public/uploads/profiles/' . $admin->profile_image) ?>" alt="" class="img-circle" style="width:80px;height:80px;">
                                </div>
                            <?php endif; ?>
                            <input type="file" name="profile_image" class="form-control" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image.</small>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <a href="<?= base_url('alladmin') ?>" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update Admin</button>
                        </div>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.select2) {
        $('.select2_single').select2({ allowClear: true });
    }
});
</script>
