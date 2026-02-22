<!-- Support Tickets -->
<div class="page-title">
    <div class="title_left">
        <h3>Support Tickets</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('support/create') ?>" class="btn btn-success"><i class="fa fa-plus"></i> New Ticket</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <!-- Quick Stats -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#206570;padding:15px;border-radius:5px;margin-bottom:15px;">
            <div class="count" style="color:#fff;font-size:24px;">0</div>
            <h3 style="color:#fff !important;font-size:13px;">Open Tickets</h3>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#f0ad4e;padding:15px;border-radius:5px;margin-bottom:15px;">
            <div class="count" style="color:#fff;font-size:24px;">0</div>
            <h3 style="color:#fff !important;font-size:13px;">Pending</h3>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#5cb85c;padding:15px;border-radius:5px;margin-bottom:15px;">
            <div class="count" style="color:#fff;font-size:24px;">0</div>
            <h3 style="color:#fff !important;font-size:13px;">Resolved</h3>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats" style="background:#E74C3C;padding:15px;border-radius:5px;margin-bottom:15px;">
            <div class="count" style="color:#fff;font-size:24px;">0</div>
            <h3 style="color:#fff !important;font-size:13px;">Overdue</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-tickets" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Ticket ID</th>
                            <th>Subject</th>
                            <th>Category</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tickets)): ?>
                            <?php $sno = 1; foreach ($tickets as $ticket): ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><?= htmlspecialchars($ticket->ticket_id ?? '') ?></td>
                                <td><?= htmlspecialchars($ticket->subject ?? '') ?></td>
                                <td><?= htmlspecialchars($ticket->category ?? '') ?></td>
                                <td>
                                    <?php
                                    $priority = $ticket->priority ?? 'Medium';
                                    $badge = 'label-warning';
                                    if ($priority === 'High') $badge = 'label-danger';
                                    elseif ($priority === 'Low') $badge = 'label-info';
                                    elseif ($priority === 'Urgent') $badge = 'label-danger';
                                    ?>
                                    <span class="label <?= $badge ?>"><?= htmlspecialchars($priority) ?></span>
                                </td>
                                <td>
                                    <?php
                                    $status = $ticket->status ?? 'Open';
                                    $sbadge = 'label-primary';
                                    if ($status === 'Resolved') $sbadge = 'label-success';
                                    elseif ($status === 'Closed') $sbadge = 'label-default';
                                    elseif ($status === 'Pending') $sbadge = 'label-warning';
                                    elseif ($status === 'In Progress') $sbadge = 'label-info';
                                    ?>
                                    <span class="label <?= $sbadge ?>"><?= htmlspecialchars($status) ?></span>
                                </td>
                                <td><?= htmlspecialchars($ticket->assigned_to ?? '') ?></td>
                                <td><?= isset($ticket->created_at) ? date('d/m/Y', strtotime($ticket->created_at)) : '' ?></td>
                                <td>
                                    <a href="<?= base_url('support/view/' . ($ticket->id ?? '')) ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
                                    <a href="<?= base_url('support/edit/' . ($ticket->id ?? '')) ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-xs delete-item" data-id="<?= $ticket->id ?? '' ?>"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted">No support tickets found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#datatable-tickets').DataTable({
            pageLength: 10,
            lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
            order: [[7, 'desc']],
        });
    }
    if ($.fn.select2) { $('.select2').select2(); }
});
</script>
