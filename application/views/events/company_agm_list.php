<!-- Per-Company AGM Event List - Modern Rillet Style -->
<div class="page-title">
    <div class="title_left">
        <h3>AGM Events</h3>
        <p style="color:var(--cf-text-secondary); font-size:14px; margin-top:4px;">
            <?= htmlspecialchars($company->company_name ?? '') ?>
        </p>
    </div>
    <div class="title_right">
        <div class="pull-right" style="display:flex; gap:8px; flex-wrap:wrap;">
            <a href="<?= base_url('agm_listing') ?>" class="btn btn-default btn-sm">
                <i class="fa fa-arrow-left" style="margin-right:4px;"></i> Back to AGM Listing
            </a>
            <a href="<?= base_url("view_company/{$company_id}") ?>" class="btn btn-default btn-sm">
                <i class="fa fa-building" style="margin-right:4px;"></i> View Company
            </a>
            <a href="<?= base_url("add_agm/{$company_id}") ?>" class="btn btn-primary btn-sm">
                <i class="fa fa-plus" style="margin-right:4px;"></i> Add AGM Event
            </a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!-- Summary KPI Cards -->
<?php
    $total_events = count($events ?? []);
    $completed = count(array_filter($events ?? [], function($e) { return !empty($e->agm_held_date); }));
    $overdue_count = count(array_filter($events ?? [], function($e) { return empty($e->agm_held_date) && !empty($e->agm_due_date) && $e->agm_due_date < date('Y-m-d'); }));
    $upcoming_count = count(array_filter($events ?? [], function($e) { return empty($e->agm_held_date) && !empty($e->agm_due_date) && $e->agm_due_date >= date('Y-m-d'); }));
?>
<div class="kpi-grid" style="grid-template-columns: repeat(4, 1fr); margin-bottom:20px;">
    <div class="kpi-card kpi-navy">
        <div class="kpi-header">
            <span class="kpi-label">Total Events</span>
            <span class="kpi-icon navy"><i class="fa fa-calendar"></i></span>
        </div>
        <div class="kpi-value"><?= $total_events ?></div>
    </div>
    <div class="kpi-card kpi-green">
        <div class="kpi-header">
            <span class="kpi-label">Completed</span>
            <span class="kpi-icon green"><i class="fa fa-check-circle"></i></span>
        </div>
        <div class="kpi-value"><?= $completed ?></div>
    </div>
    <div class="kpi-card kpi-red">
        <div class="kpi-header">
            <span class="kpi-label">Overdue</span>
            <span class="kpi-icon red"><i class="fa fa-exclamation-circle"></i></span>
        </div>
        <div class="kpi-value"><?= $overdue_count ?></div>
    </div>
    <div class="kpi-card kpi-amber">
        <div class="kpi-header">
            <span class="kpi-label">Upcoming</span>
            <span class="kpi-icon amber"><i class="fa fa-clock-o"></i></span>
        </div>
        <div class="kpi-value"><?= $upcoming_count ?></div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-agm-company" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
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
                                $badge_class = 'active'; $status_text = 'Completed';
                            } elseif ($agm_due && $agm_due < $today) {
                                $badge_class = 'expired'; $status_text = 'Overdue';
                            } else {
                                $badge_class = 'pending'; $status_text = 'Pending';
                            }
                        ?>
                        <tr>
                            <td style="color:var(--cf-text-muted); font-size:12px;"><?= $sno++ ?></td>
                            <td style="font-size:12px;"><?= !empty($e->fye_date) ? date('d/m/Y', strtotime($e->fye_date)) : '<span style="color:var(--cf-text-muted);">--</span>' ?></td>
                            <td style="font-size:12px; <?= ($badge_class === 'expired') ? 'color:var(--cf-danger); font-weight:600;' : '' ?>"><?= $agm_due ? date('d/m/Y', strtotime($agm_due)) : '<span style="color:var(--cf-text-muted);">--</span>' ?></td>
                            <td style="font-size:12px;"><?= $agm_held ? date('d/m/Y', strtotime($agm_held)) : '<span style="color:var(--cf-text-muted);">--</span>' ?></td>
                            <td style="font-size:12px;"><?= !empty($e->ar_date) ? date('d/m/Y', strtotime($e->ar_date)) : '<span style="color:var(--cf-text-muted);">--</span>' ?></td>
                            <td style="font-size:12px;"><?= !empty($e->ar_filing_date) ? date('d/m/Y', strtotime($e->ar_filing_date)) : '<span style="color:var(--cf-text-muted);">--</span>' ?></td>
                            <td style="font-size:12px;"><?= !empty($e->next_due_date) ? date('d/m/Y', strtotime($e->next_due_date)) : '<span style="color:var(--cf-text-muted);">--</span>' ?></td>
                            <td><span class="status-badge <?= $badge_class ?>"><?= $status_text ?></span></td>
                            <td style="font-size:12px; max-width:150px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="<?= htmlspecialchars($e->notes ?? '') ?>"><?= htmlspecialchars($e->notes ?? '') ?></td>
                            <td>
                                <div style="display:flex; gap:4px;">
                                    <a href="<?= base_url("edit_agm/{$e->id}") ?>" class="btn btn-default btn-xs" title="Edit" style="border-radius:6px;">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <button class="btn btn-default btn-xs delete-agm" data-id="<?= $e->id ?>" title="Delete" style="border-radius:6px; color:var(--cf-danger);">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
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
            language: {
                search: '',
                searchPlaceholder: 'Search events...',
                paginate: { previous: '<i class="fa fa-chevron-left"></i>', next: '<i class="fa fa-chevron-right"></i>' }
            }
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
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, delete it!'
            }).then(function(result) {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url("delete_agm/") ?>' + id;
                }
            });
        } else if (typeof swal !== 'undefined') {
            swal({
                title: 'Delete AGM Event?',
                text: 'This action cannot be undone.',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                confirmButtonText: 'Yes, delete it!'
            }, function(confirmed) {
                if (confirmed) {
                    window.location.href = '<?= base_url("delete_agm/") ?>' + id;
                }
            });
        } else if (confirm('Delete this AGM event?')) {
            window.location.href = '<?= base_url("delete_agm/") ?>' + id;
        }
    });
});
</script>
