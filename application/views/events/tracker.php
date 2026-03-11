<!-- Event Tracker - Modern Rillet Style -->
<div class="page-title">
    <div class="title_left">
        <h3>Event Tracker</h3>
        <p style="color:var(--cf-text-secondary); font-size:14px; margin-top:4px;">
            Track AGM, AR filings, FYE dates, and compliance deadlines
        </p>
    </div>
    <div class="title_right">
        <div class="pull-right" style="display:flex; gap:6px; flex-wrap:wrap;">
            <a href="<?= base_url('agm_listing') ?>" class="btn btn-default btn-sm" style="border-radius:var(--cf-radius-sm);"><i class="fa fa-gavel" style="margin-right:4px; color:var(--cf-primary);"></i> AGM</a>
            <a href="<?= base_url('ar_listing') ?>" class="btn btn-default btn-sm" style="border-radius:var(--cf-radius-sm);"><i class="fa fa-file-text" style="margin-right:4px; color:var(--cf-accent);"></i> AR</a>
            <a href="<?= base_url('fye_listing') ?>" class="btn btn-default btn-sm" style="border-radius:var(--cf-radius-sm);"><i class="fa fa-calendar-check-o" style="margin-right:4px; color:var(--cf-success);"></i> FYE</a>
            <a href="<?= base_url('anniversary_listing') ?>" class="btn btn-default btn-sm" style="border-radius:var(--cf-radius-sm);"><i class="fa fa-birthday-cake" style="margin-right:4px; color:var(--cf-accent);"></i> Anniversary</a>
            <a href="<?= base_url('due_listing') ?>" class="btn btn-default btn-sm" style="border-radius:var(--cf-radius-sm);"><i class="fa fa-clock-o" style="margin-right:4px; color:var(--cf-warning);"></i> Due Dates</a>
            <a href="<?= base_url('id_expiry_listing') ?>" class="btn btn-default btn-sm" style="border-radius:var(--cf-radius-sm);"><i class="fa fa-id-card" style="margin-right:4px; color:var(--cf-danger);"></i> ID Expiry</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <!-- Modern Filter Bar -->
                <div style="display:flex; gap:12px; align-items:center; margin-bottom:16px; flex-wrap:wrap;">
                    <button class="btn btn-default" id="toggleFilter" style="border-radius:var(--cf-radius-sm);">
                        <i class="fa fa-filter" style="margin-right:6px; color:var(--cf-accent);"></i> Filters
                    </button>
                    <div style="flex:1;"></div>
                    <span style="font-size:13px; color:var(--cf-text-secondary);">
                        <i class="fa fa-calendar" style="margin-right:4px;"></i>
                        <?= count($events ?? []) ?> events
                    </span>
                </div>

                <!-- Collapsible Filter Panel -->
                <div id="filterPanel" style="display:none; background:var(--cf-card-bg); padding:20px; border-radius:var(--cf-radius); margin-bottom:16px; border:1px solid var(--cf-border);">
                    <div class="row">
                        <div class="col-md-3">
                            <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Date Range</label>
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" id="filter_date_from" placeholder="From">
                                <span class="input-group-addon" style="background:var(--cf-card-bg); border-color:var(--cf-border); color:var(--cf-text-muted);">to</span>
                                <input type="text" class="form-control datepicker" id="filter_date_to" placeholder="To">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Company</label>
                            <select class="form-control select2" id="filter_company" multiple>
                                <?php foreach ($companies as $c): ?>
                                <option value="<?= $c->id ?>"><?= htmlspecialchars($c->company_name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Event Type</label>
                            <select class="form-control" id="filter_event_type">
                                <option value="">All</option>
                                <?php foreach ($event_types as $type): ?>
                                <option value="<?= $type ?>"><?= $type ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Status</label>
                            <select class="form-control" id="filter_status">
                                <option value="">All</option>
                                <option value="overdue">Overdue</option>
                                <option value="upcoming">Upcoming</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                    <div style="margin-top:14px; display:flex; gap:8px;">
                        <button class="btn btn-primary btn-sm" onclick="applyFilter()">
                            <i class="fa fa-search" style="margin-right:4px;"></i> Apply
                        </button>
                        <button class="btn btn-default btn-sm" onclick="resetFilter()">
                            <i class="fa fa-refresh" style="margin-right:4px;"></i> Reset
                        </button>
                    </div>
                </div>

                <!-- Data Table -->
                <table id="datatable-events" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>S/No.</th>
                            <th>Company Name</th>
                            <th>FYE Date</th>
                            <th>AGM Due</th>
                            <th>AR Due</th>
                            <th>Last AGM</th>
                            <th>Last AR Filed</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; foreach ($events as $e): ?>
                        <?php
                            $today = date('Y-m-d');
                            $agm_due = $e->agm_due_date ?? null;
                            $ar_due = $e->ar_due_date ?? null;
                            $status = 'completed';
                            $badge_class = 'active';
                            $status_text = 'Completed';
                            
                            if ($agm_due && $agm_due < $today && empty($e->agm_held_date)) {
                                $status = 'overdue';
                                $badge_class = 'expired';
                                $status_text = 'Overdue';
                            } elseif ($agm_due && $agm_due >= $today && $agm_due <= date('Y-m-d', strtotime('+30 days')) && empty($e->agm_held_date)) {
                                $status = 'upcoming';
                                $badge_class = 'pending';
                                $status_text = 'Upcoming';
                            } elseif ($ar_due && $ar_due < $today && empty($e->ar_filing_date)) {
                                $status = 'overdue';
                                $badge_class = 'expired';
                                $status_text = 'Overdue';
                            } elseif ($ar_due && $ar_due >= $today && $ar_due <= date('Y-m-d', strtotime('+30 days')) && empty($e->ar_filing_date)) {
                                $status = 'upcoming';
                                $badge_class = 'pending';
                                $status_text = 'Upcoming';
                            }
                        ?>
                        <tr>
                            <td style="color:var(--cf-text-muted); font-size:12px;"><?= $sno++ ?></td>
                            <td><span style="font-weight:600;"><?= htmlspecialchars($e->company_name) ?></span></td>
                            <td style="font-size:12px;"><?= $e->fye_date ? date('d/m/Y', strtotime($e->fye_date)) : '<span style="color:var(--cf-text-muted);">--</span>' ?></td>
                            <td style="font-size:12px; <?= ($status === 'overdue' && $agm_due) ? 'color:var(--cf-danger); font-weight:600;' : '' ?>"><?= $agm_due ? date('d/m/Y', strtotime($agm_due)) : '<span style="color:var(--cf-text-muted);">--</span>' ?></td>
                            <td style="font-size:12px;"><?= $ar_due ? date('d/m/Y', strtotime($ar_due)) : '<span style="color:var(--cf-text-muted);">--</span>' ?></td>
                            <td style="font-size:12px;"><?= !empty($e->agm_held_date) ? date('d/m/Y', strtotime($e->agm_held_date)) : '<span style="color:var(--cf-text-muted);">--</span>' ?></td>
                            <td style="font-size:12px;"><?= !empty($e->ar_filing_date) ? date('d/m/Y', strtotime($e->ar_filing_date)) : '<span style="color:var(--cf-text-muted);">--</span>' ?></td>
                            <td data-status="<?= $status ?>">
                                <span class="status-badge <?= $badge_class ?>"><?= $status_text ?></span>
                            </td>
                            <td>
                                <a href="<?= base_url("view_company/{$e->company_id}") ?>" class="btn btn-default btn-xs" style="border-radius:6px;">
                                    <i class="fa fa-eye" style="margin-right:4px;"></i> View
                                </a>
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
    var table;
    if ($.fn.DataTable) {
        table = $('#datatable-events').DataTable({
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            order: [[3, 'asc']],
            language: {
                search: '',
                searchPlaceholder: 'Search events...',
                info: 'Showing _START_ to _END_ of _TOTAL_ events',
                paginate: { previous: '<i class="fa fa-chevron-left"></i>', next: '<i class="fa fa-chevron-right"></i>' }
            }
        });
    }
    if ($.fn.select2) {
        $('.select2').select2({ placeholder: 'Select companies...' });
    }
    if ($.fn.daterangepicker) {
        $('.datepicker').daterangepicker({
            singleDatePicker: true,
            autoApply: true,
            locale: { format: 'DD/MM/YYYY' }
        });
        $('.datepicker').val('');
    }

    $('#toggleFilter').click(function() {
        $('#filterPanel').slideToggle(200);
        $(this).toggleClass('active');
    });
});

function applyFilter() {
    var table = $('#datatable-events').DataTable();
    var company = $('#filter_company').val();
    var eventType = $('#filter_event_type').val();
    var status = $('#filter_status').val();

    if (eventType) {
        table.columns(2).search(eventType).draw();
    } else {
        table.columns(2).search('').draw();
    }
    if (status) {
        table.columns(7).search(status).draw();
    } else {
        table.columns(7).search('').draw();
    }
}

function resetFilter() {
    var table = $('#datatable-events').DataTable();
    table.search('').columns().search('').draw();
    $('#filter_company').val(null).trigger('change');
    $('#filter_event_type').val('');
    $('#filter_status').val('');
    $('.datepicker').val('');
}
</script>
