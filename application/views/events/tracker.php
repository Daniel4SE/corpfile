<!-- Event Tracker Page -->
<div class="page-title">
    <div class="title_left">
        <h3>Event Tracker</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('agm_listing') ?>" class="btn btn-info btn-sm"><i class="fa fa-gavel"></i> AGM</a>
            <a href="<?= base_url('ar_listing') ?>" class="btn btn-info btn-sm"><i class="fa fa-file-text"></i> AR</a>
            <a href="<?= base_url('fye_listing') ?>" class="btn btn-info btn-sm"><i class="fa fa-calendar-check-o"></i> FYE</a>
            <a href="<?= base_url('anniversary_listing') ?>" class="btn btn-info btn-sm"><i class="fa fa-birthday-cake"></i> Anniversary</a>
            <a href="<?= base_url('due_listing') ?>" class="btn btn-warning btn-sm"><i class="fa fa-clock-o"></i> Due Dates</a>
            <a href="<?= base_url('id_expiry_listing') ?>" class="btn btn-danger btn-sm"><i class="fa fa-id-card"></i> ID Expiry</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <!-- Filter Panel Toggle -->
                <button class="btn btn-primary btn-sm" id="toggleFilter" style="margin-bottom:10px;">
                    <i class="fa fa-filter"></i> Filter
                </button>

                <!-- Filter Panel -->
                <div id="filterPanel" style="display:none;background:#f9f9f9;padding:15px;border-radius:5px;margin-bottom:15px;">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Date Range</label>
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" id="filter_date_from" placeholder="From">
                                <span class="input-group-addon">to</span>
                                <input type="text" class="form-control datepicker" id="filter_date_to" placeholder="To">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Company</label>
                            <select class="form-control select2" id="filter_company" multiple>
                                <?php foreach ($companies as $c): ?>
                                <option value="<?= $c->id ?>"><?= htmlspecialchars($c->company_name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Event Type</label>
                            <select class="form-control" id="filter_event_type">
                                <option value="">All</option>
                                <?php foreach ($event_types as $type): ?>
                                <option value="<?= $type ?>"><?= $type ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Status</label>
                            <select class="form-control" id="filter_status">
                                <option value="">All</option>
                                <option value="overdue">Overdue</option>
                                <option value="upcoming">Upcoming</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <button class="btn btn-success btn-sm" onclick="applyFilter()"><i class="fa fa-search"></i> Apply</button>
                    <button class="btn btn-default btn-sm" onclick="resetFilter()"><i class="fa fa-refresh"></i> Reset</button>
                </div>

                <!-- Data Table -->
                <table id="datatable-events" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
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
                            $status_label = 'success';
                            $status_text = 'Completed';
                            
                            if ($agm_due && $agm_due < $today && empty($e->agm_held_date)) {
                                $status = 'overdue';
                                $status_label = 'danger';
                                $status_text = 'Overdue';
                            } elseif ($agm_due && $agm_due >= $today && $agm_due <= date('Y-m-d', strtotime('+30 days')) && empty($e->agm_held_date)) {
                                $status = 'upcoming';
                                $status_label = 'warning';
                                $status_text = 'Upcoming';
                            } elseif ($ar_due && $ar_due < $today && empty($e->ar_filing_date)) {
                                $status = 'overdue';
                                $status_label = 'danger';
                                $status_text = 'Overdue';
                            } elseif ($ar_due && $ar_due >= $today && $ar_due <= date('Y-m-d', strtotime('+30 days')) && empty($e->ar_filing_date)) {
                                $status = 'upcoming';
                                $status_label = 'warning';
                                $status_text = 'Upcoming';
                            }
                        ?>
                        <tr>
                            <td><?= $sno++ ?></td>
                            <td><?= htmlspecialchars($e->company_name) ?></td>
                            <td><?= $e->fye_date ? date('d/m/Y', strtotime($e->fye_date)) : '-' ?></td>
                            <td><?= $agm_due ? date('d/m/Y', strtotime($agm_due)) : '-' ?></td>
                            <td><?= $ar_due ? date('d/m/Y', strtotime($ar_due)) : '-' ?></td>
                            <td><?= !empty($e->agm_held_date) ? date('d/m/Y', strtotime($e->agm_held_date)) : '-' ?></td>
                            <td><?= !empty($e->ar_filing_date) ? date('d/m/Y', strtotime($e->ar_filing_date)) : '-' ?></td>
                            <td data-status="<?= $status ?>">
                                <span class="label label-<?= $status_label ?>"><?= $status_text ?></span>
                            </td>
                            <td>
                                <a href="<?= base_url("view_company/{$e->company_id}") ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> View</a>
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
        $('#filterPanel').slideToggle();
    });
});

function applyFilter() {
    var table = $('#datatable-events').DataTable();
    var company = $('#filter_company').val();
    var eventType = $('#filter_event_type').val();
    var status = $('#filter_status').val();

    // Column-based search
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
