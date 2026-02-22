<!-- CRM Ticket Detail View -->
<div class="page-title">
    <div class="title_left">
        <h3>Ticket #<?= htmlspecialchars($ticket->id ?? '') ?> - <?= htmlspecialchars($ticket->subject ?? 'Not Found') ?></h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('tickets') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Tickets</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<?php if (!$ticket): ?>
    <div class="alert alert-danger">Ticket not found.</div>
<?php else: ?>
<div class="row">
    <!-- Ticket Info Sidebar -->
    <div class="col-md-4">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-ticket"></i> Ticket Info</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-condensed" style="font-size:13px;">
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            <?php
                            $tstatus = $ticket->status ?? 'Open';
                            $tbadge = 'label-info';
                            if ($tstatus === 'Closed') $tbadge = 'label-success';
                            elseif ($tstatus === 'In Progress') $tbadge = 'label-warning';
                            elseif ($tstatus === 'Resolved') $tbadge = 'label-primary';
                            ?>
                            <span class="label <?= $tbadge ?>"><?= htmlspecialchars($tstatus) ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Priority:</strong></td>
                        <td>
                            <?php
                            $tpriority = $ticket->priority ?? 'Medium';
                            $tpbadge = 'label-info';
                            if ($tpriority === 'High') $tpbadge = 'label-danger';
                            elseif ($tpriority === 'Low') $tpbadge = 'label-default';
                            elseif ($tpriority === 'Urgent') $tpbadge = 'label-danger';
                            ?>
                            <span class="label <?= $tpbadge ?>"><?= htmlspecialchars($tpriority) ?></span>
                        </td>
                    </tr>
                    <tr><td><strong>Category:</strong></td><td><?= htmlspecialchars($ticket->category ?? '-') ?></td></tr>
                    <tr><td><strong>Created By:</strong></td><td><?= htmlspecialchars($ticket->created_by_name ?? '') ?></td></tr>
                    <tr><td><strong>Assigned To:</strong></td><td><?= htmlspecialchars($ticket->assigned_to_name ?? 'Unassigned') ?></td></tr>
                    <tr><td><strong>Created:</strong></td><td><?= !empty($ticket->created_at) ? date('d M Y H:i', strtotime($ticket->created_at)) : '' ?></td></tr>
                    <tr><td><strong>Updated:</strong></td><td><?= !empty($ticket->updated_at) ? date('d M Y H:i', strtotime($ticket->updated_at)) : '' ?></td></tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Conversation Thread -->
    <div class="col-md-8">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-comments"></i> Conversation</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- Original Ticket Description -->
                <div class="well" style="background:#f0f7ff;border-left:4px solid #206570;">
                    <strong><?= htmlspecialchars($ticket->created_by_name ?? 'User') ?></strong>
                    <span class="text-muted pull-right" style="font-size:11px;">
                        <?= !empty($ticket->created_at) ? date('d M Y H:i', strtotime($ticket->created_at)) : '' ?>
                    </span>
                    <hr style="margin:8px 0;">
                    <p style="white-space:pre-wrap;"><?= htmlspecialchars($ticket->description ?? '') ?></p>
                </div>

                <!-- Conversation Replies -->
                <?php if (!empty($conversations)): foreach ($conversations as $conv): ?>
                <div class="well" style="margin-bottom:10px;border-left:4px solid <?= ($conv->user_id ?? '') == ($_SESSION['user_id'] ?? '') ? '#26B99A' : '#ccc' ?>;">
                    <strong><?= htmlspecialchars($conv->user_name ?? 'User') ?></strong>
                    <span class="text-muted pull-right" style="font-size:11px;">
                        <?= !empty($conv->created_at) ? date('d M Y H:i', strtotime($conv->created_at)) : '' ?>
                    </span>
                    <hr style="margin:8px 0;">
                    <p style="white-space:pre-wrap;"><?= htmlspecialchars($conv->message ?? '') ?></p>
                </div>
                <?php endforeach; endif; ?>

                <!-- Reply Form -->
                <div style="margin-top:20px;border-top:2px solid #206570;padding-top:15px;">
                    <h4><i class="fa fa-reply"></i> Post a Reply</h4>
                    <form method="POST" action="<?= base_url('crm_ticket_view/' . ($ticket->id ?? '')) ?>">
                        <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">
                        <div class="form-group">
                            <textarea name="message" class="form-control" rows="4" placeholder="Type your reply here..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i> Send Reply</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
