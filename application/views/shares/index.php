<!-- Share Management -->
<div class="page-title">
    <div class="title_left">
        <h3><?= $page_title ?? 'Share Management' ?></h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('company_list') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Companies</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <!-- Filter -->
                <div class="row" style="margin-bottom:15px;">
                    <div class="col-md-4">
                        <select class="form-control select2_single" id="company_filter">
                            <option value="">Select Company</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary" onclick="filterShares()"><i class="fa fa-search"></i> Filter</button>
                    </div>
                </div>

                <table id="datatable-shares" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Company</th>
                            <th>Shareholder</th>
                            <th>Share Type</th>
                            <th>No. of Shares</th>
                            <th>Currency</th>
                            <th>Amount</th>
                            <th>Percentage</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($shares)): ?>
                            <?php $sno = 1; foreach ($shares as $s): ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><?= htmlspecialchars($s->company ?? '') ?></td>
                                <td><?= htmlspecialchars($s->shareholder ?? '') ?></td>
                                <td><?= htmlspecialchars($s->share_type ?? 'Ordinary') ?></td>
                                <td><?= number_format($s->no_shares ?? 0) ?></td>
                                <td><?= htmlspecialchars($s->currency ?? 'SGD') ?></td>
                                <td>$<?= number_format($s->amount ?? 0, 2) ?></td>
                                <td><?= number_format($s->percentage ?? 0, 2) ?>%</td>
                                <td>
                                    <span class="label label-<?= ($s->status ?? 'Active') === 'Active' ? 'success' : 'default' ?>">
                                        <?= htmlspecialchars($s->status ?? 'Active') ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= base_url('shares/view/' . ($s->id ?? '')) ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
                                    <a href="<?= base_url('shares/edit/' . ($s->id ?? '')) ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center text-muted">No share records found. Select a company to view share details.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#datatable-shares').DataTable({
            pageLength: 10,
            lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
            order: [[1, 'asc']],
        });
    }
    if ($.fn.select2) { $('.select2_single').select2(); }
});

function filterShares() {
    var companyId = $('#company_filter').val();
    if (companyId) {
        window.location.href = '<?= base_url("shares") ?>?company_id=' + companyId;
    }
}
</script>
