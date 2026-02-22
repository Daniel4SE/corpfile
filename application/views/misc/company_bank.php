<!-- Company Bank Accounts -->
<div class="page-title">
    <div class="title_left">
        <h3>Company Bank Accounts</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('add_company_bank') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Bank Account</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-banks" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Company</th>
                            <th>Bank Name</th>
                            <th>Account Name</th>
                            <th>Account Number</th>
                            <th>Branch</th>
                            <th>Currency</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($bank_accounts)): ?>
                            <?php $sno = 1; foreach ($bank_accounts as $ba): ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><?= htmlspecialchars($ba->company_name ?? '') ?></td>
                                <td><?= htmlspecialchars($ba->bank_name ?? '') ?></td>
                                <td><?= htmlspecialchars($ba->account_name ?? '') ?></td>
                                <td><?= htmlspecialchars($ba->account_number ?? '') ?></td>
                                <td><?= htmlspecialchars($ba->branch ?? '') ?></td>
                                <td><?= htmlspecialchars($ba->currency ?? 'SGD') ?></td>
                                <td><span class="label label-<?= ($ba->status ?? '') === 'Active' ? 'success' : 'danger' ?>"><?= htmlspecialchars($ba->status ?? '') ?></span></td>
                                <td>
                                    <button class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="9" class="text-center text-muted">No bank accounts found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) { $('#datatable-banks').DataTable({ pageLength: 10, order: [[1, 'asc']] }); }
});
</script>
