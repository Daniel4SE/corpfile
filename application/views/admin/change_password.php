<!-- Change Password Form -->
<div class="page-title">
    <div class="title_left">
        <h3>Change Password</h3>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-lock"></i> Update Your Password</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $flash = $this->getFlash(); ?>
                <?php if ($flash): ?>
                    <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?>">
                        <?= htmlspecialchars($flash['message']) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= base_url('change_psd') ?>" class="form-horizontal form-label-left" id="changePasswordForm">
                    <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Current Password <span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="password" name="current_password" class="form-control" placeholder="Enter current password" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">New Password <span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Enter new password" required minlength="6">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Confirm Password <span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm new password" required minlength="6">
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4">
                            <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> Change Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#changePasswordForm').on('submit', function(e) {
        var newPwd = $('#new_password').val();
        var confirmPwd = $('#confirm_password').val();
        if (newPwd !== confirmPwd) {
            e.preventDefault();
            if (typeof swal !== 'undefined') {
                swal("Error", "New password and confirm password do not match.", "error");
            } else {
                alert('New password and confirm password do not match.');
            }
            return false;
        }
    });
});
</script>
