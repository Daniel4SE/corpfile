<!-- Page Access Rights - Permission Matrix -->
<div class="page-title">
    <div class="title_left">
        <h3>Page Access Rights <?= isset($user->name) ? '- ' . htmlspecialchars($user->name) : '' ?></h3>
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
                <h2 style="color:#fff;"><i class="fa fa-key"></i> Permission Matrix</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php if (!$user): ?>
                    <div class="alert alert-danger">User not found.</div>
                <?php else: ?>
                    <?php
                    // Build permission lookup
                    $permLookup = [];
                    if (!empty($permissions)) {
                        foreach ($permissions as $p) {
                            $permLookup[$p->module_id] = $p;
                        }
                    }
                    ?>
                    <form method="POST" action="<?= base_url('page_access_rights/' . ($user->id ?? '')) ?>">
                        <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">

                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> Set permissions for <strong><?= htmlspecialchars($user->name ?? '') ?></strong> (<?= htmlspecialchars($user->email ?? '') ?>). Check the boxes to grant access.
                        </div>

                        <div style="margin-bottom:10px;">
                            <button type="button" class="btn btn-xs btn-default" id="checkAll"><i class="fa fa-check-square-o"></i> Check All</button>
                            <button type="button" class="btn btn-xs btn-default" id="uncheckAll"><i class="fa fa-square-o"></i> Uncheck All</button>
                        </div>

                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr style="background:#206570;color:#fff;">
                                    <th width="5%">S/No</th>
                                    <th width="35%">Module</th>
                                    <th width="15%" class="text-center">View</th>
                                    <th width="15%" class="text-center">Add</th>
                                    <th width="15%" class="text-center">Edit</th>
                                    <th width="15%" class="text-center">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($modules)): ?>
                                    <?php $sno = 1; foreach ($modules as $mod): ?>
                                        <?php $perm = $permLookup[$mod->id] ?? null; ?>
                                        <tr>
                                            <td><?= $sno++ ?></td>
                                            <td><?= htmlspecialchars($mod->module_name ?? '') ?></td>
                                            <td class="text-center">
                                                <input type="checkbox" name="modules[<?= $mod->id ?>][view]" value="1" <?= ($perm && $perm->can_view) ? 'checked' : '' ?> class="perm-checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="modules[<?= $mod->id ?>][add]" value="1" <?= ($perm && $perm->can_add) ? 'checked' : '' ?> class="perm-checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="modules[<?= $mod->id ?>][edit]" value="1" <?= ($perm && $perm->can_edit) ? 'checked' : '' ?> class="perm-checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="modules[<?= $mod->id ?>][delete]" value="1" <?= ($perm && $perm->can_delete) ? 'checked' : '' ?> class="perm-checkbox">
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No modules configured. Please add modules in Settings.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <div class="ln_solid"></div>
                        <div class="text-center">
                            <a href="<?= base_url('alladmin') ?>" class="btn btn-default btn-lg">Cancel</a>
                            <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> Save Permissions</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#checkAll').click(function() {
        $('.perm-checkbox').prop('checked', true);
    });
    $('#uncheckAll').click(function() {
        $('.perm-checkbox').prop('checked', false);
    });
});
</script>
