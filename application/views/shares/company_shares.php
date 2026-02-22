<!-- Company Share Structure Detail -->
<style>
    .share-summary-card {
        border: 1px solid #e5e5e5;
        border-radius: 4px;
        padding: 15px;
        margin-bottom: 15px;
        background: #fafafa;
    }
    .share-summary-card h4 {
        color: #206570;
        font-weight: 600;
        margin-top: 0;
        border-bottom: 2px solid #206570;
        padding-bottom: 8px;
    }
    .share-summary-card .share-info { font-size: 13px; margin-bottom: 5px; }
    .share-summary-card .share-info strong { display: inline-block; width: 180px; color: #555; }
    .share-summary-card .share-value { color: #333; font-weight: 600; }
</style>

<div class="page-title">
    <div class="title_left">
        <h3>Share Structure - <?= htmlspecialchars($company->company_name ?? '') ?></h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url("view_company/{$company_id}") ?>" class="btn btn-info btn-sm"><i class="fa fa-building"></i> View Company</a>
            <a href="<?= base_url('company_list') ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back to Companies</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!-- Share Capital Summary -->
<div class="row">
    <div class="col-md-6">
        <div class="share-summary-card">
            <h4><i class="fa fa-money"></i> Ordinary Shares</h4>
            <div class="share-info">
                <strong>Issued Share Capital:</strong>
                <span class="share-value"><?= htmlspecialchars($company->ord_currency ?? 'SGD') ?> <?= !empty($company->ord_issued_share_capital) ? number_format($company->ord_issued_share_capital, 2) : '0.00' ?></span>
            </div>
            <div class="share-info">
                <strong>Number of Shares:</strong>
                <span class="share-value"><?= !empty($company->no_ord_shares) ? number_format($company->no_ord_shares) : '0' ?></span>
            </div>
            <div class="share-info">
                <strong>Paid-up Capital:</strong>
                <span class="share-value"><?= htmlspecialchars($company->ord_currency ?? 'SGD') ?> <?= !empty($company->paid_up_capital) ? number_format($company->paid_up_capital, 2) : '0.00' ?></span>
            </div>
            <?php
                $total_shareholder_shares = 0;
                foreach ($shareholders ?? [] as $sh) {
                    $total_shareholder_shares += ($sh->no_shares ?? 0);
                }
                $discrepancy = ($company->no_ord_shares ?? 0) - $total_shareholder_shares;
            ?>
            <div class="share-info">
                <strong>Total Shareholder Shares:</strong>
                <span class="share-value"><?= number_format($total_shareholder_shares) ?></span>
                <?php if ($discrepancy != 0): ?>
                    <span class="label label-danger" style="margin-left:10px;">Discrepancy: <?= number_format($discrepancy) ?></span>
                <?php else: ?>
                    <span class="label label-success" style="margin-left:10px;">Balanced</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="share-summary-card">
            <h4><i class="fa fa-star"></i> Special/Preference Shares</h4>
            <div class="share-info">
                <strong>Issued Share Capital:</strong>
                <span class="share-value"><?= htmlspecialchars($company->spec_currency ?? 'SGD') ?> <?= !empty($company->spec_issued_share_capital) ? number_format($company->spec_issued_share_capital, 2) : '0.00' ?></span>
            </div>
            <div class="share-info">
                <strong>Number of Shares:</strong>
                <span class="share-value"><?= !empty($company->no_spec_shares) ? number_format($company->no_spec_shares) : '0' ?></span>
            </div>
        </div>
    </div>
</div>

<!-- Shareholders Table -->
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-pie-chart"></i> Shareholders</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="dt-shareholders" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Type</th>
                            <th>Name</th>
                            <th>ID Number</th>
                            <th>Nationality</th>
                            <th>No. of Shares</th>
                            <th>Share Type</th>
                            <th>Currency</th>
                            <th>Amount</th>
                            <th>Percentage</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; $total_shares = max($company->no_ord_shares ?? 1, 1); foreach ($shareholders ?? [] as $sh): ?>
                        <tr>
                            <td><?= $sno++ ?></td>
                            <td><?= htmlspecialchars($sh->shareholder_type ?? 'Individual') ?></td>
                            <td><?= htmlspecialchars($sh->name ?? '') ?></td>
                            <td><?= htmlspecialchars($sh->id_number ?? '') ?></td>
                            <td><?= htmlspecialchars($sh->nationality ?? '') ?></td>
                            <td><?= number_format($sh->no_shares ?? 0) ?></td>
                            <td><?= htmlspecialchars($sh->share_type ?? 'Ordinary') ?></td>
                            <td><?= htmlspecialchars($sh->currency ?? ($company->ord_currency ?? 'SGD')) ?></td>
                            <td><?= number_format($sh->amount ?? 0, 2) ?></td>
                            <td>
                                <?php
                                    $pct = ($sh->no_shares ?? 0) > 0 ? (($sh->no_shares / $total_shares) * 100) : 0;
                                    echo number_format($pct, 2) . '%';
                                ?>
                            </td>
                            <td>
                                <span class="label label-<?= strtolower($sh->status ?? 'Active') === 'active' ? 'success' : 'danger' ?>">
                                    <?= htmlspecialchars($sh->status ?? 'Active') ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Allotment History -->
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-plus-circle"></i> Allotment History</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="dt-allotments" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Allotment Date</th>
                            <th>Shareholder</th>
                            <th>Share Type</th>
                            <th>No. of Shares</th>
                            <th>Price Per Share</th>
                            <th>Total Amount</th>
                            <th>Currency</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; foreach ($allotments ?? [] as $al): ?>
                        <tr>
                            <td><?= $sno++ ?></td>
                            <td><?= !empty($al->allotment_date) ? date('d/m/Y', strtotime($al->allotment_date)) : '-' ?></td>
                            <td><?= htmlspecialchars($al->shareholder_name ?? '') ?></td>
                            <td><?= htmlspecialchars($al->share_type ?? 'Ordinary') ?></td>
                            <td><?= number_format($al->no_shares ?? 0) ?></td>
                            <td><?= number_format($al->price_per_share ?? 0, 4) ?></td>
                            <td><?= number_format($al->total_amount ?? 0, 2) ?></td>
                            <td><?= htmlspecialchars($al->currency ?? 'SGD') ?></td>
                            <td><?= htmlspecialchars($al->remarks ?? '') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Transfer History -->
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-exchange"></i> Transfer History</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="dt-transfers" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Transfer Date</th>
                            <th>Transferor</th>
                            <th>Transferee</th>
                            <th>Share Type</th>
                            <th>No. of Shares</th>
                            <th>Price Per Share</th>
                            <th>Consideration</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; foreach ($transfers ?? [] as $tr): ?>
                        <tr>
                            <td><?= $sno++ ?></td>
                            <td><?= !empty($tr->transfer_date) ? date('d/m/Y', strtotime($tr->transfer_date)) : '-' ?></td>
                            <td><?= htmlspecialchars($tr->transferor_name ?? '') ?></td>
                            <td><?= htmlspecialchars($tr->transferee_name ?? '') ?></td>
                            <td><?= htmlspecialchars($tr->share_type ?? 'Ordinary') ?></td>
                            <td><?= number_format($tr->no_shares ?? 0) ?></td>
                            <td><?= number_format($tr->price_per_share ?? 0, 4) ?></td>
                            <td><?= number_format($tr->consideration ?? 0, 2) ?></td>
                            <td><?= htmlspecialchars($tr->remarks ?? '') ?></td>
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
        var dtOpts = {
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            order: [[0, 'asc']],
            language: { emptyTable: "No records found" }
        };
        $('#dt-shareholders').DataTable(dtOpts);
        $('#dt-allotments').DataTable($.extend({}, dtOpts, { order: [[1, 'desc']] }));
        $('#dt-transfers').DataTable($.extend({}, dtOpts, { order: [[1, 'desc']] }));
    }
});
</script>
