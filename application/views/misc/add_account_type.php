<!-- Add/Edit Account Type -->
<div class="page-title">
    <div class="title_left">
        <h3><?= !empty($account_type) ? 'Edit' : 'Add' ?> Account Type</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('mainadmin_account_type') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to List</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="x_panel">
            <div class="x_title">
                <h2><?= !empty($account_type) ? 'Edit' : 'New' ?> Account Type</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="POST" class="form-horizontal form-label-left">
                    <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Type Name <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="type_name" class="form-control" value="<?= htmlspecialchars($account_type->type_name ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="status" class="form-control">
                                <option value="1" <?= (($account_type->status ?? 1) == 1) ? 'selected' : '' ?>>Active</option>
                                <option value="0" <?= (($account_type->status ?? 1) == 0) ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <a href="<?= base_url('mainadmin_account_type') ?>" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> <?= !empty($account_type) ? 'Update' : 'Save' ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
