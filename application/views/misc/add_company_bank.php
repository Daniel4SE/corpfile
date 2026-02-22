<!-- Add Company Bank Account Form -->
<div class="page-title">
    <div class="title_left">
        <h3>Add Company Bank Account</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('company_bank') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to List</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-university"></i> Bank Account Details</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="POST" action="<?= base_url('add_company_bank') ?>" class="form-horizontal form-label-left">
                    <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">

                    <div class="form-group">
                        <label class="control-label col-md-3">Company <span class="required">*</span></label>
                        <div class="col-md-6">
                            <select name="company_id" class="form-control select2_single" style="width:100%;" required>
                                <option value="">Select Company</option>
                                <?php if (!empty($companies)): foreach ($companies as $c): ?>
                                <option value="<?= $c->id ?>"><?= htmlspecialchars($c->company_name) ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Bank Name <span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="text" name="bank_name" class="form-control" placeholder="Bank Name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Account Name <span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="text" name="account_name" class="form-control" placeholder="Account Name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Account Number <span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="text" name="account_number" class="form-control" placeholder="Account Number" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Branch</label>
                        <div class="col-md-6">
                            <input type="text" name="branch" class="form-control" placeholder="Branch">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">SWIFT Code</label>
                        <div class="col-md-6">
                            <input type="text" name="swift_code" class="form-control" placeholder="SWIFT Code">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Currency</label>
                        <div class="col-md-6">
                            <select name="currency" class="form-control">
                                <option value="SGD">SGD</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                                <option value="GBP">GBP</option>
                                <option value="MYR">MYR</option>
                                <option value="HKD">HKD</option>
                                <option value="CNY">CNY</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Status</label>
                        <div class="col-md-6">
                            <select name="status" class="form-control">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <a href="<?= base_url('company_bank') ?>" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Account</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() { if ($.fn.select2) { $('.select2_single').select2({ allowClear: true }); } });
</script>
