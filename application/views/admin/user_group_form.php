<!-- Add/Edit User Group Form -->
<div class="page-title">
    <div class="title_left">
        <h3><?= isset($group) ? 'Edit' : 'Add' ?> User Group</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('user_groups') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Groups</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-users"></i> User Group Details</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="POST" action="<?= base_url(isset($group) ? 'edit_user_group/' . ($group->id ?? '') : 'add_user_group') ?>" class="form-horizontal form-label-left">
                    <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Group Name <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="group_name" class="form-control" value="<?= htmlspecialchars($group->group_name ?? '') ?>" placeholder="Group Name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea name="description" class="form-control" rows="3" placeholder="Group description..."><?= htmlspecialchars($group->description ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="status" class="form-control">
                                <option value="1" <?= (isset($group) && ($group->status ?? 1) == 1) ? 'selected' : '' ?>>Active</option>
                                <option value="0" <?= (isset($group) && ($group->status ?? 1) == 0) ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <a href="<?= base_url('user_groups') ?>" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> <?= isset($group) ? 'Update' : 'Save' ?> Group</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
