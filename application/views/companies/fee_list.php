<!-- Company Fee List -->
<div class="page-title">
    <div class="title_left">
        <h3>Fee List - <?= htmlspecialchars($company->company_name ?? '') ?></h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <button class="btn btn-success" data-toggle="modal" data-target="#addFeeModal"><i class="fa fa-plus"></i> Add Fee</button>
            <a href="<?= base_url('company_list') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Companies</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-fees" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Fee Type</th>
                            <th>Amount ($)</th>
                            <th>Period</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($fees)): ?>
                            <?php $sno = 1; foreach ($fees as $fee): ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><?= htmlspecialchars($fee->fee_type ?? '') ?></td>
                                <td class="text-right">$<?= number_format($fee->amount ?? 0, 2) ?></td>
                                <td><?= htmlspecialchars($fee->period ?? '') ?></td>
                                <td><?= !empty($fee->due_date) ? date('d/m/Y', strtotime($fee->due_date)) : '' ?></td>
                                <td>
                                    <?php
                                    $fstatus = $fee->status ?? 'Pending';
                                    $fbadge = 'label-warning';
                                    if ($fstatus === 'Paid') $fbadge = 'label-success';
                                    elseif ($fstatus === 'Overdue') $fbadge = 'label-danger';
                                    ?>
                                    <span class="label <?= $fbadge ?>"><?= htmlspecialchars($fstatus) ?></span>
                                </td>
                                <td>
                                    <button class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-center text-muted">No fees recorded for this company.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Fee Modal -->
<div class="modal fade" id="addFeeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#206570;color:#fff;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;"><span>&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Add Fee</h4>
            </div>
            <form method="POST" action="<?= base_url('company_fee_list/' . ($company_id ?? '')) ?>">
                <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Fee Type <span class="required">*</span></label>
                        <select name="fee_type" class="form-control" required>
                            <option value="">Select Fee Type</option>
                            <option value="Annual Return Filing">Annual Return Filing</option>
                            <option value="Company Secretarial">Company Secretarial</option>
                            <option value="Registered Office">Registered Office</option>
                            <option value="Nominee Director">Nominee Director</option>
                            <option value="Accounting">Accounting</option>
                            <option value="Tax Filing">Tax Filing</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount ($) <span class="required">*</span></label>
                        <input type="number" name="amount" class="form-control" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Period</label>
                        <select name="period" class="form-control">
                            <option value="Annual">Annual</option>
                            <option value="Monthly">Monthly</option>
                            <option value="Quarterly">Quarterly</option>
                            <option value="One-time">One-time</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Due Date</label>
                        <input type="date" name="due_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="Pending">Pending</option>
                            <option value="Paid">Paid</option>
                            <option value="Overdue">Overdue</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Fee</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#datatable-fees').DataTable({ pageLength: 10, order: [[4, 'desc']] });
    }
});
</script>
