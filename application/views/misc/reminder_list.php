<!-- Reminders List -->
<div class="page-title">
    <div class="title_left">
        <h3>Reminders</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('set_reminder') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Set Reminder</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-reminders" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($reminders)): ?>
                            <?php $sno = 1; foreach ($reminders as $r): ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><?= htmlspecialchars($r->title ?? '') ?></td>
                                <td><?= htmlspecialchars(substr($r->description ?? '', 0, 80)) ?><?= strlen($r->description ?? '') > 80 ? '...' : '' ?></td>
                                <td><?= !empty($r->reminder_date) ? date('d/m/Y', strtotime($r->reminder_date)) : '' ?></td>
                                <td><?= htmlspecialchars($r->reminder_time ?? '') ?></td>
                                <td>
                                    <?php
                                    $rpri = $r->priority ?? 'Medium';
                                    $rpbadge = 'label-info';
                                    if ($rpri === 'High') $rpbadge = 'label-danger';
                                    elseif ($rpri === 'Low') $rpbadge = 'label-default';
                                    ?>
                                    <span class="label <?= $rpbadge ?>"><?= htmlspecialchars($rpri) ?></span>
                                </td>
                                <td>
                                    <?php $rstatus = $r->status ?? 'Active'; ?>
                                    <span class="label label-<?= $rstatus === 'Active' ? 'success' : ($rstatus === 'Completed' ? 'primary' : 'default') ?>"><?= htmlspecialchars($rstatus) ?></span>
                                </td>
                                <td>
                                    <a href="<?= base_url('edit_reminder/' . ($r->id ?? '')) ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="8" class="text-center text-muted">No reminders set.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) { $('#datatable-reminders').DataTable({ pageLength: 10, order: [[3, 'asc']] }); }
});
</script>
