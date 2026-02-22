<!-- Edit User Page -->
<div class="page-title">
    <div class="title_left">
        <h3>Edit User</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('user_settings') ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back to Users</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<?php if (!empty($flash['error'])): ?>
<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?= htmlspecialchars($flash['error']) ?></div>
<?php endif; ?>
<?php if (!empty($flash['success'])): ?>
<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?= htmlspecialchars($flash['success']) ?></div>
<?php endif; ?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:3px 3px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-user"></i> Edit User — <?= htmlspecialchars($user->name ?? '') ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="padding:20px;">
                <form method="POST" action="<?= base_url("user_settings/edit_user/{$user->id}") ?>">
                    <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name"
                                       value="<?= htmlspecialchars($user->name ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="username"
                                       value="<?= htmlspecialchars($user->username ?? '') ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email"
                                       value="<?= htmlspecialchars($user->email ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>New Password <small class="text-muted">(leave blank to keep current)</small></label>
                                <input type="password" class="form-control" name="password" placeholder="Enter new password to change">
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
                                        <option value="<?= htmlspecialchars($r->role_name ?? '') ?>"
                                            <?= ($user->role ?? '') == ($r->role_name ?? '') ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($r->role_name ?? '') ?>
                                        </option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="superadmin" <?= ($user->role ?? '') == 'superadmin' ? 'selected' : '' ?>>Superadmin</option>
                                        <option value="admin"      <?= ($user->role ?? '') == 'admin'      ? 'selected' : '' ?>>Admin</option>
                                        <option value="user"       <?= ($user->role ?? '') == 'user'       ? 'selected' : '' ?>>User</option>
                                        <option value="viewer"     <?= ($user->role ?? '') == 'viewer'     ? 'selected' : '' ?>>Viewer</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Department</label>
                                <input type="text" class="form-control" name="department"
                                       value="<?= htmlspecialchars($user->department ?? '') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" name="phone"
                                       value="<?= htmlspecialchars($user->phone ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option value="1" <?= ($user->status ?? 1) == 1 ? 'selected' : '' ?>>Active</option>
                                    <option value="0" <?= ($user->status ?? 1) == 0 ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="text-center">
                        <a href="<?= base_url('user_settings') ?>" class="btn btn-default btn-lg">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fa fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
