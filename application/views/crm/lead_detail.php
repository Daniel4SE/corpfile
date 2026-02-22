<div class="page-title"><div class="title_left"><h3>Lead Details <?php if (!empty($lead)): ?> - <?= htmlspecialchars($lead->lead_title ?? '') ?><?php endif; ?></h3></div><div class="title_right"><div class="pull-right">
<a href="<?= base_url('crm_leads') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
<?php if (!empty($lead)): ?>
<a href="<?= base_url('crm_create_quotation?lead_id=' . $lead->id) ?>" class="btn btn-success"><i class="fa fa-file-text-o"></i> Create Quotation</a>
<?php endif; ?>
</div></div></div><div class="clearfix"></div>

<?php if (!empty($lead)): ?>
<div class="row">
<div class="col-md-4">
<div class="x_panel">
<div class="x_title"><h2>Lead Information</h2><div class="clearfix"></div></div>
<div class="x_content">
<table class="table table-condensed">
<tr><th width="130">Lead Title:</th><td><?= htmlspecialchars($lead->lead_title ?? '') ?></td></tr>
<tr><th>Company:</th><td><?= htmlspecialchars($lead->company_name ?? '-') ?></td></tr>
<tr><th>Contact:</th><td><?= htmlspecialchars($lead->contact_person ?? '-') ?></td></tr>
<tr><th>Email:</th><td><a href="mailto:<?= htmlspecialchars($lead->email ?? '') ?>"><?= htmlspecialchars($lead->email ?? '-') ?></a></td></tr>
<tr><th>Phone:</th><td><?= htmlspecialchars($lead->phone ?? '-') ?></td></tr>
<tr><th>Source:</th><td><?= htmlspecialchars($lead->source_name ?? '-') ?></td></tr>
<tr><th>Rating:</th><td><?= htmlspecialchars($lead->rating_name ?? '-') ?></td></tr>
<tr><th>Status:</th><td><span class="label label-info"><?= htmlspecialchars($lead->status_name ?? '-') ?></span></td></tr>
<tr><th>Assigned To:</th><td><?= htmlspecialchars($lead->assigned_to_name ?? '-') ?></td></tr>
<tr><th>Expected Value:</th><td><?= !empty($lead->expected_value) ? '$' . number_format($lead->expected_value, 2) : '-' ?></td></tr>
<tr><th>Created:</th><td><?= htmlspecialchars($lead->created_at ?? '-') ?></td></tr>
</table>
<?php if (!empty($lead->notes)): ?><div class="well well-sm"><strong>Notes:</strong><br><?= nl2br(htmlspecialchars($lead->notes)) ?></div><?php endif; ?>
</div></div></div>

<div class="col-md-8">
<!-- Tabs -->
<div class="x_panel">
<div class="x_title"><h2>Details</h2><div class="clearfix"></div></div>
<div class="x_content">
<ul class="nav nav-tabs bar_tabs" role="tablist">
<li role="presentation" class="active"><a href="#followups" role="tab" data-toggle="tab">Follow-ups</a></li>
<li role="presentation"><a href="#quotations" role="tab" data-toggle="tab">Quotations</a></li>
<li role="presentation"><a href="#activities" role="tab" data-toggle="tab">Activities</a></li>
</ul>
<div class="tab-content">
<!-- Follow-ups Tab -->
<div role="tabpanel" class="tab-pane fade in active" id="followups">
<div style="margin:15px 0;"><button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addFollowupModal"><i class="fa fa-plus"></i> Add Follow-up</button></div>
<table class="table table-striped table-bordered dataTable">
<thead><tr style="background:#206570;color:#fff;"><th>Date</th><th>Mode</th><th>Agenda</th><th>Notes</th><th>Next Follow-up</th></tr></thead>
<tbody>
<?php foreach ($followups as $fu): ?>
<tr><td><?= htmlspecialchars($fu->followup_date ?? '-') ?></td><td><?= htmlspecialchars($fu->mode_name ?? '-') ?></td><td><?= htmlspecialchars($fu->agenda_name ?? '-') ?></td><td><?= htmlspecialchars($fu->notes ?? '-') ?></td><td><?= htmlspecialchars($fu->next_followup_date ?? '-') ?></td></tr>
<?php endforeach; ?>
</tbody></table>
</div>
<!-- Quotations Tab -->
<div role="tabpanel" class="tab-pane fade" id="quotations">
<table class="table table-striped table-bordered dataTable">
<thead><tr style="background:#206570;color:#fff;"><th>Quotation No</th><th>Date</th><th>Valid Until</th><th>Amount</th><th>Status</th></tr></thead>
<tbody>
<?php foreach ($quotations as $q): ?>
<tr><td><?= htmlspecialchars($q->quotation_number ?? '') ?></td><td><?= htmlspecialchars($q->date ?? '-') ?></td><td><?= htmlspecialchars($q->valid_until ?? '-') ?></td><td>$<?= number_format($q->total ?? 0, 2) ?></td><td><span class="label label-info"><?= htmlspecialchars($q->status ?? '') ?></span></td></tr>
<?php endforeach; ?>
</tbody></table>
</div>
<!-- Activities Tab -->
<div role="tabpanel" class="tab-pane fade" id="activities">
<table class="table table-striped table-bordered dataTable">
<thead><tr style="background:#206570;color:#fff;"><th>Date</th><th>Type</th><th>Description</th><th>By</th></tr></thead>
<tbody>
<?php foreach ($activities as $act): ?>
<tr><td><?= htmlspecialchars($act->created_at ?? '-') ?></td><td><?= htmlspecialchars($act->type ?? '-') ?></td><td><?= htmlspecialchars($act->description ?? '-') ?></td><td><?= htmlspecialchars($act->user_name ?? '-') ?></td></tr>
<?php endforeach; ?>
</tbody></table>
</div>
</div></div></div></div>
</div>
<?php else: ?>
<div class="alert alert-warning">Lead not found.</div>
<?php endif; ?>
<script>$(function(){$('.dataTable').DataTable();});</script>
