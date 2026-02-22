<!-- CRM Sales Orders -->
<div class="page-title">
    <div class="title_left">
        <h3>Sales Orders</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('crm_sales_order/add') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Sales Order</a>
            <a href="<?= base_url('crm_dashboard') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to CRM</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-sales-orders" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Order No</th>
                            <th>Company</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($sales_orders)): ?>
                            <?php $sno = 1; foreach ($sales_orders as $so): ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><?= htmlspecialchars($so->order_no ?? '') ?></td>
                                <td><?= htmlspecialchars($so->company ?? '') ?></td>
                                <td>$<?= number_format($so->amount ?? 0, 2) ?></td>
                                <td>
                                    <?php
                                    $status = $so->status ?? 'Pending';
                                    $badge = 'label-warning';
                                    if ($status === 'Completed') $badge = 'label-success';
                                    elseif ($status === 'Cancelled') $badge = 'label-danger';
                                    elseif ($status === 'Processing') $badge = 'label-info';
                                    ?>
                                    <span class="label <?= $badge ?>"><?= htmlspecialchars($status) ?></span>
                                </td>
                                <td><?= isset($so->created_at) ? date('d/m/Y', strtotime($so->created_at)) : '' ?></td>
                                <td>
                                    <a href="<?= base_url('crm_sales_order/view/' . ($so->id ?? '')) ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
                                    <a href="<?= base_url('crm_sales_order/edit/' . ($so->id ?? '')) ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-xs delete-item" data-id="<?= $so->id ?? '' ?>"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">No sales orders found.</td>
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
        $('#datatable-sales-orders').DataTable({
            pageLength: 10,
            lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
            order: [[5, 'desc']],
        });
    }
    if ($.fn.select2) { $('.select2').select2(); }
});
</script>
