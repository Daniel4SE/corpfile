<!-- Add Admin User Form -->
<div class="page-title">
    <div class="title_left">
        <h3>Add Admin User</h3>
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
                <h2 style="color:#fff;"><i class="fa fa-user-plus"></i> Admin Information</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="POST" action="<?= base_url('add_admin') ?>" enctype="multipart/form-data" class="form-horizontal form-label-left">
                    <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Password <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="password" name="password" class="form-control" placeholder="Password" required minlength="6">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Password <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required minlength="6">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Role <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="role" class="form-control" required>
                                <option value="">Select Role</option>
                                <option value="Super Admin">Super Admin</option>
                                <option value="Admin">Admin</option>
                                <option value="User">User</option>
                                <option value="Viewer">Viewer</option>
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
                                    <option value="<?= $ug->id ?? '' ?>"><?= htmlspecialchars($ug->group_name ?? '') ?></option>
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
                                    <option value="<?= $b->id ?? '' ?>"><?= htmlspecialchars($b->branch_name ?? '') ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="status" class="form-control">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="phone" class="form-control" placeholder="Phone Number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Profile Image</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="file" name="profile_image" class="form-control" accept="image/*">
                            <small class="text-muted">Accepted formats: JPG, PNG, GIF. Max 2MB.</small>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <a href="<?= base_url('alladmin') ?>" class="btn btn-default">Cancel</a>
                            <button type="reset" class="btn btn-warning">Reset</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Admin</button>
                        </div>
                    </div>
                </form>
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
