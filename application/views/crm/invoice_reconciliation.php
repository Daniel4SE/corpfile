<!-- CRM Invoice Reconciliation -->
<div class="page-title">
    <div class="title_left">
        <h3>Invoice Reconciliation</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('crm_invoices') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Invoices</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-recon" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Invoice No</th>
                            <th>Company</th>
                            <th>Invoice Date</th>
                            <th>Invoice Amount</th>
                            <th>Paid Amount</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($reconciliations)): ?>
                            <?php $sno = 1; foreach ($reconciliations as $r): ?>
                            <?php
                                $invAmount = $r->amount ?? 0;
                                $paidAmount = $r->paid_amount ?? 0;
                                $balance = $invAmount - $paidAmount;
                                $reconStatus = 'Unpaid';
                                $reconBadge = 'label-danger';
                                if ($balance <= 0) { $reconStatus = 'Fully Paid'; $reconBadge = 'label-success'; }
                                elseif ($paidAmount > 0) { $reconStatus = 'Partial'; $reconBadge = 'label-warning'; }
                            ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><?= htmlspecialchars($r->invoice_no ?? '') ?></td>
                                <td><?= htmlspecialchars($r->company_name ?? '') ?></td>
                                <td><?= !empty($r->invoice_date) ? date('d/m/Y', strtotime($r->invoice_date)) : '' ?></td>
                                <td class="text-right">$<?= number_format($invAmount, 2) ?></td>
                                <td class="text-right">$<?= number_format($paidAmount, 2) ?></td>
                                <td class="text-right"><strong>$<?= number_format(max(0, $balance), 2) ?></strong></td>
                                <td><span class="label <?= $reconBadge ?>"><?= $reconStatus ?></span></td>
                                <td>
                                    <button class="btn btn-primary btn-xs" title="View"><i class="fa fa-eye"></i></button>
                                    <button class="btn btn-success btn-xs" title="Record Payment"><i class="fa fa-dollar"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="9" class="text-center text-muted">No invoices to reconcile.</td></tr>
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
        $('#datatable-recon').DataTable({
            pageLength: 10,
            lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
            order: [[3, 'desc']],
        });
    }
});
</script>
