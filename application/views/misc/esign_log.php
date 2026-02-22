<!-- eSign Audit Log -->
<div class="page-title">
    <div class="title_left">
        <h3>eSign Audit Log</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('esign_settings') ?>" class="btn btn-info"><i class="fa fa-cog"></i> Settings</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-esign-log" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Date/Time</th>
                            <th>User</th>
                            <th>Document</th>
                            <th>Action</th>
                            <th>Signer Email</th>
                            <th>Status</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($logs)): ?>
                            <?php $sno = 1; foreach ($logs as $log): ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><?= !empty($log->created_at) ? date('d/m/Y H:i:s', strtotime($log->created_at)) : '' ?></td>
                                <td><?= htmlspecialchars($log->user_name ?? '') ?></td>
                                <td><?= htmlspecialchars($log->document_name ?? '') ?></td>
                                <td>
                                    <?php
                                    $action = $log->action ?? '';
                                    $abadge = 'label-info';
                                    if ($action === 'Signed') $abadge = 'label-success';
                                    elseif ($action === 'Rejected') $abadge = 'label-danger';
                                    elseif ($action === 'Sent') $abadge = 'label-primary';
                                    elseif ($action === 'Viewed') $abadge = 'label-warning';
                                    ?>
                                    <span class="label <?= $abadge ?>"><?= htmlspecialchars($action) ?></span>
                                </td>
                                <td><?= htmlspecialchars($log->signer_email ?? '') ?></td>
                                <td><span class="label label-<?= ($log->status ?? '') === 'Completed' ? 'success' : 'info' ?>"><?= htmlspecialchars($log->status ?? '') ?></span></td>
                                <td><?= htmlspecialchars($log->ip_address ?? '') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="8" class="text-center text-muted">No eSign log entries found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) { $('#datatable-esign-log').DataTable({ pageLength: 20, order: [[1, 'desc']] }); }
});
</script>
