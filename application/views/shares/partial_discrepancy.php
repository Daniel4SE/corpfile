<!-- Partial/Full Paid Share Discrepancy Report -->
<div class="page-title">
    <div class="title_left">
        <h3>Partial/Full Paid Share Discrepancies</h3>
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
            <div class="x_title">
                <h2><i class="fa fa-exclamation-circle text-danger"></i> Partial/Full Paid Discrepancies</h2>
                <small>Companies where paid-up capital does not match issued share capital</small>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="datatable-partial" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Company Name</th>
                            <th>Registration No.</th>
                            <th>Currency</th>
                            <th>Issued Share Capital</th>
                            <th>Paid-up Capital</th>
                            <th>Difference</th>
                            <th>Payment Status</th>
                            <th>No. of Shares</th>
                            <th>Entity Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; foreach ($companies ?? [] as $c): ?>
                        <?php
                            $issued = $c->ord_issued_share_capital ?? 0;
                            $paid = $c->paid_up_capital ?? 0;
                            $diff = $issued - $paid;
                            $payment_status = ($diff == 0) ? 'Fully Paid' : (($paid > 0) ? 'Partially Paid' : 'Unpaid');
                            $payment_label = ($diff == 0) ? 'success' : (($paid > 0) ? 'warning' : 'danger');
                        ?>
                        <tr>
                            <td><?= $sno++ ?></td>
                            <td><?= htmlspecialchars($c->company_name) ?></td>
                            <td><?= htmlspecialchars($c->registration_number ?? '') ?></td>
                            <td><?= htmlspecialchars($c->ord_currency ?? 'SGD') ?></td>
                            <td><?= number_format($issued, 2) ?></td>
                            <td><?= number_format($paid, 2) ?></td>
                            <td>
                                <span class="text-<?= $diff != 0 ? 'danger' : 'success' ?>" style="font-weight:600;">
                                    <?= number_format($diff, 2) ?>
                                </span>
                            </td>
                            <td><span class="label label-<?= $payment_label ?>"><?= $payment_status ?></span></td>
                            <td><?= number_format($c->no_ord_shares ?? 0) ?></td>
                            <td>
                                <span class="label label-<?= ($c->entity_status ?? 'Active') === 'Active' ? 'success' : 'default' ?>">
                                    <?= htmlspecialchars($c->entity_status ?? 'Active') ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url("company_share_level/{$c->id}") ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> View Shares</a>
                                <a href="<?= base_url("view_company/{$c->id}") ?>" class="btn btn-info btn-xs"><i class="fa fa-building"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#datatable-partial').DataTable({
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            order: [[1, 'asc']],
        });
    }
});
</script>
