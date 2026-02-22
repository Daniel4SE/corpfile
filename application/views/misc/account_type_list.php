<!-- Account Types List -->
<div class="page-title">
    <div class="title_left">
        <h3>Account Types</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('mainadmin_add_account') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Account Type</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-account-types" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Type Name</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($account_types)): ?>
                            <?php $sno = 1; foreach ($account_types as $at): ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><?= htmlspecialchars($at->type_name ?? '') ?></td>
                                <td><span class="label label-<?= ($at->status ?? 1) == 1 ? 'success' : 'default' ?>"><?= ($at->status ?? 1) == 1 ? 'Active' : 'Inactive' ?></span></td>
                                <td><?= !empty($at->created_at) ? date('d/m/Y', strtotime($at->created_at)) : '' ?></td>
                                <td>
                                    <a href="<?= base_url('mainadmin_add_account/' . $at->id) ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                                    <button class="btn btn-danger btn-xs btn-delete" data-id="<?= $at->id ?>"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center text-muted">No account types found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) { $('#datatable-account-types').DataTable({ pageLength: 25, order: [[1, 'asc']] }); }
});
</script>
