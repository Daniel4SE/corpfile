<!-- CRM Quotations Listing -->
<div class="page-title">
    <div class="title_left">
        <h3>Quotations</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('crm_quotations/add') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Quotation</a>
            <a href="<?= base_url('dashboard') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-quotations" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Quote No</th>
                            <th>Company</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($quotations)): ?>
                            <?php $sno = 1; foreach ($quotations as $q): ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><?= htmlspecialchars($q->quote_no ?? '') ?></td>
                                <td><?= htmlspecialchars($q->company ?? '') ?></td>
                                <td>$<?= number_format($q->amount ?? 0, 2) ?></td>
                                <td>
                                    <?php
                                    $status = $q->status ?? 'Draft';
                                    $badge = 'label-default';
                                    if ($status === 'Approved') $badge = 'label-success';
                                    elseif ($status === 'Pending') $badge = 'label-warning';
                                    elseif ($status === 'Rejected') $badge = 'label-danger';
                                    elseif ($status === 'Sent') $badge = 'label-info';
                                    ?>
                                    <span class="label <?= $badge ?>"><?= htmlspecialchars($status) ?></span>
                                </td>
                                <td><?= isset($q->created_at) ? date('d/m/Y', strtotime($q->created_at)) : '' ?></td>
                                <td>
                                    <a href="<?= base_url('crm_quotations/view/' . ($q->id ?? '')) ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
                                    <a href="<?= base_url('crm_quotations/edit/' . ($q->id ?? '')) ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-xs delete-item" data-id="<?= $q->id ?? '' ?>"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">No quotations found.</td>
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
        $('#datatable-quotations').DataTable({
            pageLength: 10,
            lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
            order: [[5, 'desc']],
        });
    }
    if ($.fn.select2) { $('.select2').select2(); }
});
</script>
