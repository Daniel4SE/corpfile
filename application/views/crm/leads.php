<!-- CRM Leads Listing -->
<div class="page-title">
    <div class="title_left">
        <h3>Leads</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('add_lead') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Lead</a>
            <a href="<?= base_url('dashboard') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-leads" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Lead Name</th>
                            <th>Company</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Source</th>
                            <th>Assigned To</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($leads)): ?>
                            <?php $sno = 1; foreach ($leads as $lead): ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><?= htmlspecialchars($lead->name ?? '') ?></td>
                                <td><?= htmlspecialchars($lead->company ?? '') ?></td>
                                <td>
                                    <?= htmlspecialchars($lead->email ?? '') ?><br>
                                    <small><?= htmlspecialchars($lead->phone ?? '') ?></small>
                                </td>
                                <td>
                                    <?php
                                    $status = $lead->status ?? 'Warm';
                                    $badge_class = 'label-warning';
                                    if ($status === 'Hot') $badge_class = 'label-danger';
                                    elseif ($status === 'Cold') $badge_class = 'label-info';
                                    ?>
                                    <span class="label <?= $badge_class ?>"><?= htmlspecialchars($status) ?></span>
                                </td>
                                <td><?= htmlspecialchars($lead->source ?? '') ?></td>
                                <td><?= htmlspecialchars($lead->assigned_to ?? '') ?></td>
                                <td><?= isset($lead->created_at) ? date('d/m/Y', strtotime($lead->created_at)) : '' ?></td>
                                <td>
                                    <a href="<?= base_url('crm_leads/view/' . ($lead->id ?? '')) ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
                                    <a href="<?= base_url('crm_leads/edit/' . ($lead->id ?? '')) ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-xs delete-lead" data-id="<?= $lead->id ?? '' ?>"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted">No leads found. <a href="<?= base_url('add_lead') ?>">Add your first lead</a>.</td>
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
        $('#datatable-leads').DataTable({
            pageLength: 10,
            lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
            order: [[7, 'desc']],
        });
    }
    if ($.fn.select2) {
        $('.select2').select2();
    }

    $('.delete-lead').click(function() {
        var id = $(this).data('id');
        if (typeof swal !== 'undefined') {
            swal({
                title: "Are you sure?",
                text: "This lead will be permanently deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }, function(isConfirm) {
                if (isConfirm) {
                    window.location.href = '<?= base_url("crm_leads/delete/") ?>' + id;
                }
            });
        } else if (confirm('Are you sure you want to delete this lead?')) {
            window.location.href = '<?= base_url("crm_leads/delete/") ?>' + id;
        }
    });
});
</script>
