<!-- CRM Invoices Listing -->
<div class="page-title">
    <div class="title_left">
        <h3>Invoices</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('crm_invoices/add') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Create Invoice</a>
            <a href="<?= base_url('dashboard') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-invoices" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Invoice No</th>
                            <th>Company</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($invoices)): ?>
                            <?php $sno = 1; foreach ($invoices as $inv): ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><?= htmlspecialchars($inv->invoice_no ?? '') ?></td>
                                <td><?= htmlspecialchars($inv->company ?? '') ?></td>
                                <td>$<?= number_format($inv->amount ?? 0, 2) ?></td>
                                <td>
                                    <?php
                                    $status = $inv->status ?? 'Unpaid';
                                    $badge = 'label-warning';
                                    if ($status === 'Paid') $badge = 'label-success';
                                    elseif ($status === 'Overdue') $badge = 'label-danger';
                                    elseif ($status === 'Partial') $badge = 'label-info';
                                    ?>
                                    <span class="label <?= $badge ?>"><?= htmlspecialchars($status) ?></span>
                                </td>
                                <td><?= isset($inv->due_date) ? date('d/m/Y', strtotime($inv->due_date)) : '' ?></td>
                                <td>
                                    <a href="<?= base_url('crm_invoices/view/' . ($inv->id ?? '')) ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
                                    <a href="<?= base_url('crm_invoices/edit/' . ($inv->id ?? '')) ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                                    <a href="<?= base_url('crm_invoices/pdf/' . ($inv->id ?? '')) ?>" class="btn btn-default btn-xs" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
                                    <button class="btn btn-danger btn-xs delete-item" data-id="<?= $inv->id ?? '' ?>"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">No invoices found.</td>
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
        $('#datatable-invoices').DataTable({
            pageLength: 10,
            lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
            order: [[5, 'desc']],
        });
    }
    if ($.fn.select2) { $('.select2').select2(); }
});
</script>
