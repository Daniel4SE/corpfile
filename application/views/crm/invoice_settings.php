<div class="page-title"><div class="title_left"><h3>Invoice Settings</h3></div><div class="title_right"><div class="pull-right"><a href="<?= base_url('crm_invoices') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a></div></div></div><div class="clearfix"></div>

<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="x_panel">
<div class="x_title"><h2>Invoice Configuration</h2><div class="clearfix"></div></div>
<div class="x_content">
<form method="post" class="form-horizontal form-label-left">
<input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">

<h4 class="form-section">Invoice Numbering</h4>
<div class="form-group"><label class="control-label col-md-3">Invoice Prefix</label>
<div class="col-md-9"><input type="text" name="prefix" class="form-control" value="<?= htmlspecialchars($settings->prefix ?? 'INV-') ?>" placeholder="e.g. INV-"></div></div>
<div class="form-group"><label class="control-label col-md-3">Next Invoice Number</label>
<div class="col-md-9"><input type="number" name="next_number" class="form-control" value="<?= htmlspecialchars($settings->next_number ?? '1001') ?>"></div></div>

<h4 class="form-section">Tax Settings</h4>
<div class="form-group"><label class="control-label col-md-3">Default Tax Rate (%)</label>
<div class="col-md-9"><input type="number" name="tax_rate" class="form-control" step="0.01" value="<?= htmlspecialchars($settings->tax_rate ?? '9.00') ?>"></div></div>
<div class="form-group"><label class="control-label col-md-3">Tax Label</label>
<div class="col-md-9"><input type="text" name="tax_label" class="form-control" value="<?= htmlspecialchars($settings->tax_label ?? 'GST') ?>"></div></div>

<h4 class="form-section">Payment</h4>
<div class="form-group"><label class="control-label col-md-3">Payment Terms (days)</label>
<div class="col-md-9"><input type="number" name="payment_terms" class="form-control" value="<?= htmlspecialchars($settings->payment_terms ?? '30') ?>"></div></div>
<div class="form-group"><label class="control-label col-md-3">Bank Details</label>
<div class="col-md-9"><textarea name="bank_details" class="form-control" rows="4"><?= htmlspecialchars($settings->bank_details ?? '') ?></textarea></div></div>

<h4 class="form-section">Footer / Notes</h4>
<div class="form-group"><label class="control-label col-md-3">Default Notes</label>
<div class="col-md-9"><textarea name="notes" class="form-control" rows="3"><?= htmlspecialchars($settings->notes ?? '') ?></textarea></div></div>
<div class="form-group"><label class="control-label col-md-3">Footer Text</label>
<div class="col-md-9"><textarea name="footer" class="form-control" rows="2"><?= htmlspecialchars($settings->footer ?? '') ?></textarea></div></div>

<h4 class="form-section">Email Template</h4>
<div class="form-group"><label class="control-label col-md-3">Email Subject</label>
<div class="col-md-9"><input type="text" name="email_subject" class="form-control" value="<?= htmlspecialchars($settings->email_subject ?? 'Invoice #{invoice_number}') ?>"></div></div>
<div class="form-group"><label class="control-label col-md-3">Email Body</label>
<div class="col-md-9"><textarea name="email_body" class="form-control" rows="5"><?= htmlspecialchars($settings->email_body ?? '') ?></textarea></div></div>

<div class="ln_solid"></div>
<div class="form-group"><div class="col-md-9 col-md-offset-3">
<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Settings</button>
<button type="reset" class="btn btn-default">Reset</button>
</div></div>
</form>
</div></div></div></div>
