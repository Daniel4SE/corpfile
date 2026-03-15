<!-- eSign Documents Dashboard -->
<div class="page-title">
    <div class="title_left">
        <h3>eSign Documents</h3>
        <p style="color:var(--cf-text-secondary); font-size:13px; margin-top:4px;">
            Manage document signing requests and track status
        </p>
    </div>
    <div class="title_right">
        <div class="pull-right" style="display:flex; gap:8px;">
            <a href="<?= base_url('esign_settings') ?>" class="btn btn-default" style="border-radius:var(--cf-radius-sm);">
                <i class="fa fa-cog"></i> Settings
            </a>
            <a href="<?= base_url('esign/create') ?>" class="btn btn-success" style="border-radius:var(--cf-radius-sm);">
                <i class="fa fa-plus"></i> New eSign Request
            </a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!-- Status Filter Tabs -->
<?php
    $statusCounts = $status_counts ?? ['all' => 0, 'Draft' => 0, 'Sent' => 0, 'Completed' => 0, 'Declined' => 0, 'Voided' => 0];
?>
<div class="esign-status-tabs" style="margin-bottom:16px; display:flex; gap:6px; flex-wrap:wrap;">
    <button class="esign-tab active" data-filter="all" onclick="filterEsign('all', this)">
        All <span class="esign-tab-count"><?= $statusCounts['all'] ?></span>
    </button>
    <button class="esign-tab" data-filter="Draft" onclick="filterEsign('Draft', this)">
        <span class="esign-dot" style="background:#94a3b8;"></span> Draft <span class="esign-tab-count"><?= $statusCounts['Draft'] ?></span>
    </button>
    <button class="esign-tab" data-filter="Sent" onclick="filterEsign('Sent', this)">
        <span class="esign-dot" style="background:#3b82f6;"></span> Sent <span class="esign-tab-count"><?= $statusCounts['Sent'] ?></span>
    </button>
    <button class="esign-tab" data-filter="Completed" onclick="filterEsign('Completed', this)">
        <span class="esign-dot" style="background:#22c55e;"></span> Completed <span class="esign-tab-count"><?= $statusCounts['Completed'] ?></span>
    </button>
    <button class="esign-tab" data-filter="Declined" onclick="filterEsign('Declined', this)">
        <span class="esign-dot" style="background:#ef4444;"></span> Declined <span class="esign-tab-count"><?= $statusCounts['Declined'] ?></span>
    </button>
    <button class="esign-tab" data-filter="Voided" onclick="filterEsign('Voided', this)">
        <span class="esign-dot" style="background:#9ca3af;"></span> Voided <span class="esign-tab-count"><?= $statusCounts['Voided'] ?></span>
    </button>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <?php if (!empty($documents)): ?>
                <table id="datatable-esign" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:30px;">S/No</th>
                            <th>Document</th>
                            <th>Company</th>
                            <th>Signers</th>
                            <th>Status</th>
                            <th>Sent Date</th>
                            <th>Completed</th>
                            <th style="width:130px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; foreach ($documents as $doc): ?>
                        <?php
                            $status = $doc->status ?? 'Draft';
                            $badgeMap = [
                                'Draft'     => 'esign-badge-draft',
                                'Sent'      => 'esign-badge-sent',
                                'Completed' => 'esign-badge-completed',
                                'Declined'  => 'esign-badge-declined',
                                'Voided'    => 'esign-badge-voided',
                            ];
                            $badgeCls = $badgeMap[$status] ?? 'esign-badge-draft';
                            $signerCount = (int)($doc->signer_count ?? 0);
                            $signedCount = (int)($doc->signed_count ?? 0);
                        ?>
                        <tr data-status="<?= $status ?>">
                            <td><?= $sno++ ?></td>
                            <td>
                                <a href="<?= base_url('esign/view/' . $doc->id) ?>" class="esign-doc-link">
                                    <i class="fa fa-file-text-o" style="margin-right:4px; color:var(--cf-accent);"></i>
                                    <?= htmlspecialchars($doc->title ?? $doc->source_doc_name ?? 'Untitled') ?>
                                </a>
                                <?php if ($doc->subject): ?>
                                    <div class="esign-doc-subject"><?= htmlspecialchars($doc->subject) ?></div>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($doc->company_name ?? '—') ?></td>
                            <td>
                                <?php if ($signerCount > 0): ?>
                                    <span class="esign-signer-progress">
                                        <span class="esign-signer-bar">
                                            <span class="esign-signer-fill" style="width:<?= $signerCount > 0 ? round(($signedCount/$signerCount)*100) : 0 ?>%"></span>
                                        </span>
                                        <?= $signedCount ?>/<?= $signerCount ?> signed
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">No signers</span>
                                <?php endif; ?>
                            </td>
                            <td><span class="esign-badge <?= $badgeCls ?>"><?= htmlspecialchars($status) ?></span></td>
                            <td><?= !empty($doc->sent_at) ? date('d M Y', strtotime($doc->sent_at)) : '—' ?></td>
                            <td><?= !empty($doc->completed_at) ? date('d M Y', strtotime($doc->completed_at)) : '—' ?></td>
                            <td>
                                <div class="esign-actions">
                                    <a href="<?= base_url('esign/view/' . $doc->id) ?>" class="btn btn-xs btn-primary" title="View Details">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <?php if ($status === 'Completed'): ?>
                                        <a href="<?= base_url('esign/download/' . $doc->id) ?>" class="btn btn-xs btn-success" title="Download">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($status === 'Sent'): ?>
                                        <button class="btn btn-xs btn-warning" title="Send Reminder" onclick="esignRemind(<?= $doc->id ?>)">
                                            <i class="fa fa-bell"></i>
                                        </button>
                                        <button class="btn btn-xs btn-danger" title="Void" onclick="esignVoid(<?= $doc->id ?>)">
                                            <i class="fa fa-ban"></i>
                                        </button>
                                    <?php endif; ?>
                                    <?php if ($status === 'Draft'): ?>
                                        <button class="btn btn-xs btn-danger" title="Delete" onclick="esignDelete(<?= $doc->id ?>)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <!-- Empty State -->
                <div class="esign-empty-state">
                    <div class="esign-empty-icon">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <path d="M12 18v-6"/>
                            <path d="M9 15l3 3 3-3"/>
                        </svg>
                    </div>
                    <h4>No eSign Documents Yet</h4>
                    <p>Send your first document for electronic signature.<br>Directors, shareholders, and other parties can sign from anywhere.</p>
                    <a href="<?= base_url('esign/create') ?>" class="btn btn-success" style="margin-top:12px;">
                        <i class="fa fa-plus"></i> Create eSign Request
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable && $('#datatable-esign tbody tr').length > 0 && !$('#datatable-esign tbody tr td[colspan]').length) {
        window.esignTable = $('#datatable-esign').DataTable({
            pageLength: 20,
            lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
            order: [[5, 'desc']],
            language: {
                search: '',
                searchPlaceholder: 'Search documents...',
            },
        });
    }
});

/* Status filter tabs */
function filterEsign(status, btn) {
    document.querySelectorAll('.esign-tab').forEach(function(t) { t.classList.remove('active'); });
    btn.classList.add('active');

    if (window.esignTable) {
        if (status === 'all') {
            window.esignTable.column(4).search('').draw();
        } else {
            window.esignTable.column(4).search('^' + status + '$', true, false).draw();
        }
    }
}

/* Action handlers */
function esignRemind(id) {
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
        }).fail(function() {
            new PNotify({ title: 'Error', text: 'Failed to send reminder', type: 'error' });
        });
    });
}

function esignVoid(id) {
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
        }).fail(function() {
            new PNotify({ title: 'Error', text: 'Failed to void envelope', type: 'error' });
        });
    });
}

function esignDelete(id) {
    swal({
        title: 'Delete Draft?',
        text: 'This draft will be permanently deleted.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Delete',
    }, function() {
        $.post(BASE_URL + 'esign/delete/' + id, function(resp) {
            if (resp.success) {
                new PNotify({ title: 'Deleted', text: resp.message, type: 'success' });
                setTimeout(function() { location.reload(); }, 800);
            } else {
                new PNotify({ title: 'Error', text: resp.message, type: 'error' });
            }
        }).fail(function() {
            new PNotify({ title: 'Error', text: 'Failed to delete', type: 'error' });
        });
    });
}
</script>
