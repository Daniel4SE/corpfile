<!-- CRM Follow-up Listing -->
<div class="page-title">
    <div class="title_left">
        <h3>Follow-up List</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('crm_dashboard') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to CRM</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-followups" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Date</th>
                            <th>Lead / Company</th>
                            <th>Mode</th>
                            <th>Agenda</th>
                            <th>Status</th>
                            <th>Next Follow-up</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($followups)): ?>
                            <?php $sno = 1; foreach ($followups as $f): ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><?= !empty($f->followup_date) ? date('d/m/Y', strtotime($f->followup_date)) : '' ?></td>
                                <td>
                                    <?= htmlspecialchars($f->lead_name ?? '') ?>
                                    <?php if (!empty($f->company_name)): ?>
                                        <br><small class="text-muted"><?= htmlspecialchars($f->company_name) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                    $mode = $f->mode ?? '';
                                    $micon = 'fa-phone';
                                    if ($mode === 'Email') $micon = 'fa-envelope';
                                    elseif ($mode === 'Meeting') $micon = 'fa-calendar';
                                    elseif ($mode === 'Visit') $micon = 'fa-map-marker';
                                    ?>
                                    <i class="fa <?= $micon ?>"></i> <?= htmlspecialchars($mode) ?>
                                </td>
                                <td><?= htmlspecialchars($f->agenda ?? '') ?></td>
                                <td>
                                    <?php
                                    $fstatus = $f->status ?? 'Pending';
                                    $fbadge = 'label-warning';
                                    if ($fstatus === 'Completed') $fbadge = 'label-success';
                                    elseif ($fstatus === 'Cancelled') $fbadge = 'label-danger';
                                    ?>
                                    <span class="label <?= $fbadge ?>"><?= htmlspecialchars($fstatus) ?></span>
                                </td>
                                <td><?= !empty($f->next_followup_date) ? date('d/m/Y', strtotime($f->next_followup_date)) : '-' ?></td>
                                <td>
                                    <button class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="8" class="text-center text-muted">No follow-ups found.</td></tr>
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
        $('#datatable-followups').DataTable({
            pageLength: 10,
            lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
            order: [[1, 'desc']],
        });
    }
});
</script>
