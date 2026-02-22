<!-- Per-Company AGM Event List -->
<div class="page-title">
    <div class="title_left">
        <h3>AGM Events - <?= htmlspecialchars($company->company_name ?? '') ?></h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url("add_agm/{$company_id}") ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add AGM Event</a>
            <a href="<?= base_url("view_company/{$company_id}") ?>" class="btn btn-info btn-sm"><i class="fa fa-building"></i> View Company</a>
            <a href="<?= base_url('agm_listing') ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back to AGM Listing</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!-- Summary Cards -->
<div class="row tile_count">
    <div class="col-md-3 col-sm-6 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-calendar"></i> Total Events</span>
        <div class="count"><?= count($events ?? []) ?></div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-check-circle text-success"></i> Completed</span>
        <div class="count green"><?= count(array_filter($events ?? [], function($e) { return !empty($e->agm_held_date); })) ?></div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-exclamation-circle text-danger"></i> Overdue</span>
        <div class="count red"><?= count(array_filter($events ?? [], function($e) { return empty($e->agm_held_date) && !empty($e->agm_due_date) && $e->agm_due_date < date('Y-m-d'); })) ?></div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-clock-o text-warning"></i> Upcoming</span>
        <div class="count"><?= count(array_filter($events ?? [], function($e) { return empty($e->agm_held_date) && !empty($e->agm_due_date) && $e->agm_due_date >= date('Y-m-d'); })) ?></div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-agm-company" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No.</th>
                            <th>FYE Date</th>
                            <th>AGM Due Date</th>
                            <th>AGM Held Date</th>
                            <th>AR Date</th>
                            <th>AR Filing Date</th>
                            <th>Next Due Date</th>
                            <th>Status</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; foreach ($events ?? [] as $e): ?>
                        <?php
                            $today = date('Y-m-d');
                            $agm_due = $e->agm_due_date ?? null;
                            $agm_held = $e->agm_held_date ?? null;
                            if ($agm_held) {
                                $status_label = 'success'; $status_text = 'Completed';
                            } elseif ($agm_due && $agm_due < $today) {
                                $status_label = 'danger'; $status_text = 'Overdue';
                            } else {
                                $status_label = 'warning'; $status_text = 'Pending';
                            }
                        ?>
                        <tr>
                            <td><?= $sno++ ?></td>
                            <td><?= !empty($e->fye_date) ? date('d/m/Y', strtotime($e->fye_date)) : '-' ?></td>
                            <td><?= $agm_due ? date('d/m/Y', strtotime($agm_due)) : '-' ?></td>
                            <td><?= $agm_held ? date('d/m/Y', strtotime($agm_held)) : '-' ?></td>
                            <td><?= !empty($e->ar_date) ? date('d/m/Y', strtotime($e->ar_date)) : '-' ?></td>
                            <td><?= !empty($e->ar_filing_date) ? date('d/m/Y', strtotime($e->ar_filing_date)) : '-' ?></td>
                            <td><?= !empty($e->next_due_date) ? date('d/m/Y', strtotime($e->next_due_date)) : '-' ?></td>
                            <td><span class="label label-<?= $status_label ?>"><?= $status_text ?></span></td>
                            <td><?= htmlspecialchars($e->notes ?? '') ?></td>
                            <td>
                                <a href="<?= base_url("edit_agm/{$e->id}") ?>" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                                <button class="btn btn-danger btn-xs delete-agm" data-id="<?= $e->id ?>" title="Delete"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#datatable-agm-company').DataTable({
            pageLength: 25,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            order: [[1, 'desc']],
        });
    }
    
    $('.delete-agm').click(function() {
        var id = $(this).data('id');
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Delete AGM Event?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then(function(result) {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url("delete_agm/") ?>' + id;
                }
            });
        } else if (confirm('Delete this AGM event?')) {
            window.location.href = '<?= base_url("delete_agm/") ?>' + id;
        }
    });
});
</script>
