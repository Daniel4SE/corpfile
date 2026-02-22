<!-- My Profile Page -->
<div class="page-title">
    <div class="title_left">
        <h3>My Profile</h3>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-3">
        <div class="x_panel">
            <div class="x_content text-center">
                <?php if (!empty($profile->profile_image)): ?>
                    <img src="<?= base_url('public/uploads/profiles/' . $profile->profile_image) ?>" class="img-circle" style="width:150px;height:150px;">
                <?php else: ?>
                    <img src="<?= base_url('public/images/user.png') ?>" class="img-circle" style="width:150px;height:150px;">
                <?php endif; ?>
                <h4 style="margin-top:15px;"><?= htmlspecialchars($profile->name ?? '') ?></h4>
                <p class="text-muted"><?= htmlspecialchars($profile->role ?? 'User') ?></p>
                <p><i class="fa fa-envelope"></i> <?= htmlspecialchars($profile->email ?? '') ?></p>
                <?php if (!empty($profile->phone)): ?>
                <p><i class="fa fa-phone"></i> <?= htmlspecialchars($profile->phone) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-user"></i> Profile Settings</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="POST" action="<?= base_url('my_profile') ?>" enctype="multipart/form-data" class="form-horizontal form-label-left">
                    <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">

                    <div class="form-group">
                        <label class="control-label col-md-3">Name <span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($profile->name ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Email <span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($profile->email ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Phone</label>
                        <div class="col-md-6">
                            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($profile->phone ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Address</label>
                        <div class="col-md-6">
                            <textarea name="address" class="form-control" rows="3"><?= htmlspecialchars($profile->address ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Profile Image</label>
                        <div class="col-md-6">
                            <input type="file" name="profile_image" class="form-control" accept="image/*">
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update Profile</button>
                            <a href="<?= base_url('change_psd') ?>" class="btn btn-warning"><i class="fa fa-key"></i> Change Password</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
