<!-- Annual Return Listing Page -->
<div class="page-title">
    <div class="title_left">
        <h3>Annual Return Listing</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('event_tracker') ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back to Event Tracker</a>
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
                            <label>AR Due Date Range</label>
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
                            <label>Status</label>
                            <select class="form-control" id="filter_status">
                                <option value="">All</option>
                                <option value="overdue">Overdue</option>
                                <option value="upcoming">Upcoming</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div class="col-md-3" style="padding-top:25px;">
                            <button class="btn btn-success btn-sm" onclick="applyFilter()"><i class="fa fa-search"></i> Apply</button>
                            <button class="btn btn-default btn-sm" onclick="resetFilter()"><i class="fa fa-refresh"></i> Reset</button>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <table id="datatable-ar" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No.</th>
                            <th>Company Name</th>
                            <th>FYE Date</th>
                            <th>AR Due Date</th>
                            <th>AR Filing Date</th>
                            <th>Days Remaining</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; foreach ($events as $e): ?>
                        <?php
                            $today = date('Y-m-d');
                            $ar_due = $e->ar_due_date ?? null;
                            $ar_filed = $e->ar_filing_date ?? null;
                            $days_remaining = $ar_due ? (int)((strtotime($ar_due) - strtotime($today)) / 86400) : null;
                            
                            if ($ar_filed) {
                                $status = 'completed'; $status_label = 'success'; $status_text = 'Filed';
                            } elseif ($ar_due && $ar_due < $today) {
                                $status = 'overdue'; $status_label = 'danger'; $status_text = 'Overdue';
                            } elseif ($ar_due && $days_remaining !== null && $days_remaining <= 30) {
                                $status = 'upcoming'; $status_label = 'warning'; $status_text = 'Upcoming';
                            } else {
                                $status = 'pending'; $status_label = 'info'; $status_text = 'Pending';
                            }
                        ?>
                        <tr>
                            <td><?= $sno++ ?></td>
                            <td><?= htmlspecialchars($e->company_name) ?></td>
                            <td><?= !empty($e->fye_date) ? date('d/m/Y', strtotime($e->fye_date)) : '-' ?></td>
                            <td><?= $ar_due ? date('d/m/Y', strtotime($ar_due)) : '-' ?></td>
                            <td><?= $ar_filed ? date('d/m/Y', strtotime($ar_filed)) : '-' ?></td>
                            <td>
                                <?php if ($ar_filed): ?>
                                    <span class="text-success">Filed</span>
                                <?php elseif ($days_remaining !== null): ?>
                                    <span class="text-<?= $days_remaining < 0 ? 'danger' : ($days_remaining <= 30 ? 'warning' : 'info') ?>">
                                        <?= $days_remaining ?> days
                                    </span>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td data-status="<?= $status ?>">
                                <span class="label label-<?= $status_label ?>"><?= $status_text ?></span>
                            </td>
                            <td>
                                <a href="<?= base_url("view_company/{$e->company_id}") ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
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
        $('#datatable-ar').DataTable({
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
            singleDatePicker: true, autoApply: true,
            locale: { format: 'DD/MM/YYYY' }
        });
        $('.datepicker').val('');
    }
    $('#toggleFilter').click(function() { $('#filterPanel').slideToggle(); });
});

function applyFilter() {
    var table = $('#datatable-ar').DataTable();
    var status = $('#filter_status').val();
    if (status) { table.columns(6).search(status).draw(); }
    else { table.columns(6).search('').draw(); }
}

function resetFilter() {
    var table = $('#datatable-ar').DataTable();
    table.search('').columns().search('').draw();
    $('#filter_company').val(null).trigger('change');
    $('#filter_status').val('');
    $('.datepicker').val('');
}
</script>
