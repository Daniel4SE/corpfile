<!-- eSign Document Detail View -->
<?php
    $envelope = $envelope ?? null;
    $signers = $signers ?? [];
    $auditLog = $audit_log ?? [];
    if (!$envelope) return;

    $status = $envelope->status ?? 'Draft';
    $badgeMap = [
        'Draft'     => 'esign-badge-draft',
        'Sent'      => 'esign-badge-sent',
        'Completed' => 'esign-badge-completed',
        'Declined'  => 'esign-badge-declined',
        'Voided'    => 'esign-badge-voided',
    ];
    $badgeCls = $badgeMap[$status] ?? 'esign-badge-draft';

    $totalSigners = count($signers);
    $completedSigners = 0;
    foreach ($signers as $s) { if (($s->status ?? '') === 'Completed') $completedSigners++; }
?>

<div class="page-title">
    <div class="title_left">
        <h3>
            <?= htmlspecialchars($envelope->title ?? 'Untitled') ?>
            <span class="esign-badge <?= $badgeCls ?>" style="font-size:13px; vertical-align:middle; margin-left:8px;"><?= $status ?></span>
        </h3>
        <p style="color:var(--cf-text-secondary); font-size:13px; margin-top:4px;">
            Created by <?= htmlspecialchars($envelope->creator_name ?? 'Unknown') ?>
            on <?= date('d M Y, H:i', strtotime($envelope->created_at)) ?>
            <?php if ($envelope->company_name): ?>
                &middot; <?= htmlspecialchars($envelope->company_name) ?>
            <?php endif; ?>
        </p>
    </div>
    <div class="title_right">
        <div class="pull-right" style="display:flex; gap:8px;">
            <a href="<?= base_url('esign/manage') ?>" class="btn btn-default" style="border-radius:var(--cf-radius-sm);">
                <i class="fa fa-arrow-left"></i> Back to List
            </a>
            <?php if ($status === 'Draft'): ?>
                <button class="btn btn-success" onclick="esignSend(<?= $envelope->id ?>)" style="border-radius:var(--cf-radius-sm);">
                    <i class="fa fa-paper-plane"></i> Send for Signing
                </button>
            <?php endif; ?>
            <?php if ($status === 'Completed'): ?>
                <a href="<?= base_url('esign/download/' . $envelope->id) ?>" class="btn btn-success" style="border-radius:var(--cf-radius-sm);">
                    <i class="fa fa-download"></i> Download Signed
                </a>
            <?php endif; ?>
            <?php if ($status === 'Sent'): ?>
                <button class="btn btn-warning" onclick="esignRemindDetail(<?= $envelope->id ?>)" style="border-radius:var(--cf-radius-sm);">
                    <i class="fa fa-bell"></i> Remind
                </button>
                <button class="btn btn-danger" onclick="esignVoidDetail(<?= $envelope->id ?>)" style="border-radius:var(--cf-radius-sm);">
                    <i class="fa fa-ban"></i> Void
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <!-- Left Column: Info + Signers -->
    <div class="col-md-8">
        <!-- Document Info Card -->
        <div class="x_panel">
            <div class="x_title"><h2><i class="fa fa-file-text-o"></i> Document Information</h2><div class="clearfix"></div></div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="esign-detail-item">
                            <span class="esign-detail-label">Title</span>
                            <span class="esign-detail-value"><?= htmlspecialchars($envelope->title ?? '') ?></span>
                        </div>
                        <div class="esign-detail-item">
                            <span class="esign-detail-label">Email Subject</span>
                            <span class="esign-detail-value"><?= htmlspecialchars($envelope->subject ?? '—') ?></span>
                        </div>
                        <div class="esign-detail-item">
                            <span class="esign-detail-label">Source Document</span>
                            <span class="esign-detail-value">
                                <?php if ($envelope->source_doc_name): ?>
                                    <i class="fa fa-file-pdf-o" style="color:#ef4444;"></i> <?= htmlspecialchars($envelope->source_doc_name) ?>
                                <?php else: ?>
                                    <span class="text-muted">No document attached</span>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="esign-detail-item">
                            <span class="esign-detail-label">Company</span>
                            <span class="esign-detail-value"><?= htmlspecialchars($envelope->company_name ?? '—') ?></span>
                        </div>
                        <div class="esign-detail-item">
                            <span class="esign-detail-label">Signing Order</span>
                            <span class="esign-detail-value"><?= $envelope->signing_order ? 'Sequential' : 'Parallel (all at once)' ?></span>
                        </div>
                        <div class="esign-detail-item">
                            <span class="esign-detail-label">Expires</span>
                            <span class="esign-detail-value">
                                <?php if ($envelope->expires_at): ?>
                                    <?= date('d M Y', strtotime($envelope->expires_at)) ?>
                                    <?php if (strtotime($envelope->expires_at) < time()): ?>
                                        <span class="label label-danger" style="margin-left:4px;">Expired</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    No expiry
                                <?php endif; ?>
                            </span>
                        </div>
                        <?php if ($envelope->message): ?>
                        <div class="esign-detail-item">
                            <span class="esign-detail-label">Message</span>
                            <span class="esign-detail-value"><?= nl2br(htmlspecialchars($envelope->message)) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($status === 'Voided' && $envelope->void_reason): ?>
                <div class="alert alert-danger" style="margin-top:12px; margin-bottom:0;">
                    <i class="fa fa-ban"></i> <strong>Voided:</strong> <?= htmlspecialchars($envelope->void_reason) ?>
                    <?php if ($envelope->voided_at): ?>
                        <span class="text-muted"> — <?= date('d M Y, H:i', strtotime($envelope->voided_at)) ?></span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Signers Card -->
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    <i class="fa fa-users"></i> Signing Recipients
                    <span class="text-muted" style="font-size:13px; font-weight:normal;">(<?= $completedSigners ?>/<?= $totalSigners ?> signed)</span>
                </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- Progress bar -->
                <?php if ($totalSigners > 0): ?>
                <div class="esign-progress-wrap" style="margin-bottom:16px;">
                    <div class="esign-signer-bar" style="height:8px; border-radius:4px;">
                        <div class="esign-signer-fill" style="width:<?= round(($completedSigners/$totalSigners)*100) ?>%; border-radius:4px;"></div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($signers)): ?>
                    <?php foreach ($signers as $signer): ?>
                    <?php
                        $sStatus = $signer->status ?? 'Pending';
                        $sIconMap = [
                            'Pending'   => ['fa-clock-o', '#94a3b8'],
                            'Sent'      => ['fa-envelope-o', '#3b82f6'],
                            'Completed' => ['fa-check-circle', '#22c55e'],
                            'Declined'  => ['fa-times-circle', '#ef4444'],
                        ];
                        $sIcon = $sIconMap[$sStatus] ?? ['fa-question-circle', '#94a3b8'];
                    ?>
                    <div class="esign-signer-card">
                        <div class="esign-signer-card-left">
                            <?php if ($envelope->signing_order): ?>
                                <span class="esign-signer-card-order"><?= $signer->routing_order ?></span>
                            <?php endif; ?>
                            <i class="fa <?= $sIcon[0] ?>" style="font-size:20px; color:<?= $sIcon[1] ?>; margin-right:10px;"></i>
                            <div>
                                <div class="esign-signer-card-name">
                                    <?= htmlspecialchars($signer->name) ?>
                                    <?php if ($signer->person_type && $signer->person_type !== 'Other'): ?>
                                        <span class="esign-person-badge esign-person-<?= strtolower($signer->person_type) ?>"><?= $signer->person_type ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="esign-signer-card-email"><?= htmlspecialchars($signer->email) ?></div>
                                <?php if ($signer->signed_at): ?>
                                    <div class="esign-signer-card-time">Signed <?= date('d M Y, H:i', strtotime($signer->signed_at)) ?></div>
                                <?php endif; ?>
                                <?php if ($signer->declined_at): ?>
                                    <div class="esign-signer-card-time" style="color:#ef4444;">
                                        Declined <?= date('d M Y, H:i', strtotime($signer->declined_at)) ?>
                                        <?= $signer->decline_reason ? ' — ' . htmlspecialchars($signer->decline_reason) : '' ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="esign-signer-card-right">
                            <span class="esign-badge <?= $sStatus === 'Completed' ? 'esign-badge-completed' : ($sStatus === 'Declined' ? 'esign-badge-declined' : ($sStatus === 'Sent' ? 'esign-badge-sent' : 'esign-badge-draft')) ?>"><?= $sStatus ?></span>
                            <span class="text-muted" style="font-size:11px;"><?= $signer->role ?></span>
                            <?php if ($status === 'Sent' && in_array($sStatus, ['Sent', 'Pending'])): ?>
                                <button class="btn btn-xs btn-default" onclick="simulateSign(<?= $signer->id ?>)" title="Simulate signature (demo)">
                                    <i class="fa fa-pencil"></i> Sign
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center text-muted" style="padding:24px;">No recipients added to this envelope.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Right Column: Timeline -->
    <div class="col-md-4">
        <!-- Status Summary -->
        <div class="x_panel">
            <div class="x_title"><h2><i class="fa fa-info-circle"></i> Status</h2><div class="clearfix"></div></div>
            <div class="x_content" style="text-align:center; padding:20px;">
                <div class="esign-status-icon esign-status-<?= strtolower($status) ?>">
                    <?php
                        $statusIconMap = [
                            'Draft'     => 'fa-pencil-square-o',
                            'Sent'      => 'fa-paper-plane',
                            'Completed' => 'fa-check-circle',
                            'Declined'  => 'fa-times-circle',
                            'Voided'    => 'fa-ban',
                        ];
                    ?>
                    <i class="fa <?= $statusIconMap[$status] ?? 'fa-question' ?>" style="font-size:36px;"></i>
                </div>
                <h4 style="margin:12px 0 4px;"><?= $status ?></h4>
                <?php if ($status === 'Sent'): ?>
                    <p class="text-muted" style="font-size:13px;">Waiting for <?= ($totalSigners - $completedSigners) ?> signer(s)</p>
                <?php elseif ($status === 'Completed'): ?>
                    <p class="text-muted" style="font-size:13px;">All parties have signed</p>
                <?php elseif ($status === 'Draft'): ?>
                    <p class="text-muted" style="font-size:13px;">Ready to send</p>
                <?php endif; ?>

                <?php if ($envelope->sent_at): ?>
                <div class="esign-detail-item" style="text-align:left; margin-top:16px;">
                    <span class="esign-detail-label">Sent</span>
                    <span class="esign-detail-value"><?= date('d M Y, H:i', strtotime($envelope->sent_at)) ?></span>
                </div>
                <?php endif; ?>
                <?php if ($envelope->completed_at): ?>
                <div class="esign-detail-item" style="text-align:left;">
                    <span class="esign-detail-label">Completed</span>
                    <span class="esign-detail-value"><?= date('d M Y, H:i', strtotime($envelope->completed_at)) ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Audit Timeline -->
        <div class="x_panel">
            <div class="x_title"><h2><i class="fa fa-history"></i> Activity Timeline</h2><div class="clearfix"></div></div>
            <div class="x_content">
                <?php if (!empty($auditLog)): ?>
                <div class="esign-timeline">
                    <?php foreach ($auditLog as $log): ?>
                    <?php
                        $eventIconMap = [
                            'Created'   => ['fa-plus-circle', '#3b82f6'],
                            'Sent'      => ['fa-paper-plane', '#8b5cf6'],
                            'Viewed'    => ['fa-eye', '#f59e0b'],
                            'Signed'    => ['fa-check', '#22c55e'],
                            'Completed' => ['fa-check-circle', '#16a34a'],
                            'Declined'  => ['fa-times', '#ef4444'],
                            'Voided'    => ['fa-ban', '#6b7280'],
                            'Reminder'  => ['fa-bell', '#f59e0b'],
                        ];
                        $eIcon = $eventIconMap[$log->event] ?? ['fa-circle-o', '#94a3b8'];
                    ?>
                    <div class="esign-timeline-item">
                        <div class="esign-timeline-dot" style="background:<?= $eIcon[1] ?>;">
                            <i class="fa <?= $eIcon[0] ?>" style="color:#fff; font-size:10px;"></i>
                        </div>
                        <div class="esign-timeline-content">
                            <div class="esign-timeline-event"><?= htmlspecialchars($log->event) ?></div>
                            <?php if ($log->details): ?>
                                <div class="esign-timeline-detail"><?= htmlspecialchars($log->details) ?></div>
                            <?php endif; ?>
                            <div class="esign-timeline-time">
                                <?= date('d M Y, H:i', strtotime($log->created_at)) ?>
                                <?php if ($log->actor): ?>
                                    &middot; <?= htmlspecialchars($log->actor) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                    <div class="text-center text-muted" style="padding:16px;">No activity recorded yet.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function esignSend(id) {
    swal({
        title: 'Send for Signing?',
        text: 'This will send the document to all recipients for their signature.',
        type: 'info',
        showCancelButton: true,
        confirmButtonText: 'Send Now',
        confirmButtonColor: '#22c55e',
    }, function() {
        $.post(BASE_URL + 'esign/send/' + id, function(resp) {
            if (resp.success) {
                new PNotify({ title: 'Sent', text: resp.message, type: 'success' });
                setTimeout(function() { location.reload(); }, 1000);
            } else {
                new PNotify({ title: 'Error', text: resp.message, type: 'error' });
            }
        }).fail(function() {
            new PNotify({ title: 'Error', text: 'Failed to send envelope', type: 'error' });
        });
    });
}

function esignRemindDetail(id) {
    swal({
        title: 'Send Reminder?',
        text: 'This will send a reminder email to all pending signers.',
        type: 'info',
        showCancelButton: true,
        confirmButtonText: 'Send Reminder',
    }, function() {
        $.post(BASE_URL + 'esign/remind/' + id, function(resp) {
            if (resp.success) {
                new PNotify({ title: 'Reminder Sent', text: resp.message, type: 'success' });
            } else {
                new PNotify({ title: 'Error', text: resp.message, type: 'error' });
            }
        });
    });
}

function esignVoidDetail(id) {
    swal({
        title: 'Void Envelope?',
        text: 'This will cancel the signing request. This action cannot be undone.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, Void It',
    }, function() {
        $.post(BASE_URL + 'esign/void/' + id, { reason: 'Voided by user' }, function(resp) {
            if (resp.success) {
                new PNotify({ title: 'Voided', text: resp.message, type: 'success' });
                setTimeout(function() { location.reload(); }, 1000);
            } else {
                new PNotify({ title: 'Error', text: resp.message, type: 'error' });
            }
        });
    });
}

function simulateSign(signerId) {
    swal({
        title: 'Simulate Signature?',
        text: 'This will mark this signer as having completed their signature (demo mode).',
        type: 'info',
        showCancelButton: true,
        confirmButtonText: 'Simulate Sign',
    }, function() {
        $.post(BASE_URL + 'esign/simulate_sign/' + signerId, function(resp) {
            if (resp.success) {
                new PNotify({ title: 'Signed', text: resp.message, type: 'success' });
                setTimeout(function() { location.reload(); }, 1000);
            } else {
                new PNotify({ title: 'Error', text: resp.message, type: 'error' });
            }
        }).fail(function() {
            new PNotify({ title: 'Error', text: 'Failed to simulate signing', type: 'error' });
        });
    });
}

/* Auto-refresh status every 30s for active envelopes */
<?php if ($status === 'Sent'): ?>
setInterval(function() {
    $.getJSON(BASE_URL + 'esign/status_check/<?= $envelope->id ?>', function(resp) {
        if (resp && resp.status && resp.status !== '<?= $status ?>') {
            location.reload();
        }
    });
}, 30000);
<?php endif; ?>
</script>
