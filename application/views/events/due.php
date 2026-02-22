<!-- Upcoming Due Dates Page -->
<div class="page-title">
    <div class="title_left">
        <h3>Upcoming Due Dates</h3>
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
                            <label>Due Date Range</label>
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
                            <label>Due Type</label>
                            <select class="form-control" id="filter_due_type">
                                <option value="">All</option>
                                <option value="AGM">AGM</option>
                                <option value="AR">Annual Return</option>
                            </select>
                        </div>
                        <div class="col-md-3" style="padding-top:25px;">
                            <button class="btn btn-success btn-sm" onclick="applyFilter()"><i class="fa fa-search"></i> Apply</button>
                            <button class="btn btn-default btn-sm" onclick="resetFilter()"><i class="fa fa-refresh"></i> Reset</button>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <table id="datatable-due" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No.</th>
                            <th>Company Name</th>
                            <th>Due Type</th>
                            <th>Due Date</th>
                            <th>Days Remaining</th>
                            <th>FYE Date</th>
                            <th>Urgency</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sno = 1;
                            $today = date('Y-m-d');
                            foreach ($events as $e):
                                $due_items = [];
                                if (!empty($e->agm_due_date) && empty($e->agm_held_date)) {
                                    $due_items[] = ['type' => 'AGM', 'date' => $e->agm_due_date];
                                }
                                if (!empty($e->ar_due_date) && empty($e->ar_filing_date)) {
                                    $due_items[] = ['type' => 'AR', 'date' => $e->ar_due_date];
                                }
                                foreach ($due_items as $item):
                                    $days_remaining = (int)((strtotime($item['date']) - strtotime($today)) / 86400);
                                    
                                    if ($days_remaining < 0) {
                                        $urgency_label = 'danger'; $urgency_text = 'Overdue';
                                    } elseif ($days_remaining <= 7) {
                                        $urgency_label = 'danger'; $urgency_text = 'Critical';
                                    } elseif ($days_remaining <= 30) {
                                        $urgency_label = 'warning'; $urgency_text = 'Urgent';
                                    } elseif ($days_remaining <= 60) {
                                        $urgency_label = 'info'; $urgency_text = 'Upcoming';
                                    } else {
                                        $urgency_label = 'success'; $urgency_text = 'On Track';
                                    }
                        ?>
                        <tr>
                            <td><?= $sno++ ?></td>
                            <td><?= htmlspecialchars($e->company_name) ?></td>
                            <td><?= $item['type'] ?></td>
                            <td><?= date('d/m/Y', strtotime($item['date'])) ?></td>
                            <td>
                                <span class="text-<?= $days_remaining < 0 ? 'danger' : ($days_remaining <= 30 ? 'warning' : 'success') ?>">
                                    <?php if ($days_remaining < 0): ?>
                                        <?= abs($days_remaining) ?> days overdue
                                    <?php else: ?>
                                        <?= $days_remaining ?> days
                                    <?php endif; ?>
                                </span>
                            </td>
                            <td><?= !empty($e->fye_date) ? date('d/m/Y', strtotime($e->fye_date)) : '-' ?></td>
                            <td>
                                <span class="label label-<?= $urgency_label ?>"><?= $urgency_text ?></span>
                            </td>
                            <td>
                                <a href="<?= base_url("view_company/{$e->company_id}") ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#datatable-due').DataTable({
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            order: [[4, 'asc']],
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
    var table = $('#datatable-due').DataTable();
    var dueType = $('#filter_due_type').val();
    if (dueType) { table.columns(2).search(dueType).draw(); }
    else { table.columns(2).search('').draw(); }
}

function resetFilter() {
    var table = $('#datatable-due').DataTable();
    table.search('').columns().search('').draw();
    $('#filter_company').val(null).trigger('change');
    $('#filter_due_type').val('');
    $('.datepicker').val('');
}
</script>
