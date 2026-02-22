<!-- Financial Year End Listing Page -->
<div class="page-title">
    <div class="title_left">
        <h3>Financial Year End Listing</h3>
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
                            <label>FYE Date Range</label>
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
                            <label>FYE Month</label>
                            <select class="form-control" id="filter_fye_month">
                                <option value="">All</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="col-md-3" style="padding-top:25px;">
                            <button class="btn btn-success btn-sm" onclick="applyFilter()"><i class="fa fa-search"></i> Apply</button>
                            <button class="btn btn-default btn-sm" onclick="resetFilter()"><i class="fa fa-refresh"></i> Reset</button>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <table id="datatable-fye" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No.</th>
                            <th>Company Name</th>
                            <th>Registration No.</th>
                            <th>FYE Date</th>
                            <th>FYE Month</th>
                            <th>AGM Due</th>
                            <th>AR Due</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; foreach ($events as $e): ?>
                        <?php
                            $fye_date = $e->fye_date ?? null;
                            $fye_month = $fye_date ? date('F', strtotime($fye_date)) : '-';
                            $today = date('Y-m-d');
                            
                            $agm_due = $e->agm_due_date ?? null;
                            $ar_due = $e->ar_due_date ?? null;
                            
                            if (($agm_due && $agm_due < $today) || ($ar_due && $ar_due < $today)) {
                                $status_label = 'danger'; $status_text = 'Action Required';
                            } elseif ($fye_date && $fye_date <= date('Y-m-d', strtotime('+60 days'))) {
                                $status_label = 'warning'; $status_text = 'Approaching';
                            } else {
                                $status_label = 'success'; $status_text = 'On Track';
                            }
                        ?>
                        <tr>
                            <td><?= $sno++ ?></td>
                            <td><?= htmlspecialchars($e->company_name) ?></td>
                            <td><?= htmlspecialchars($e->registration_number ?? '') ?></td>
                            <td><?= $fye_date ? date('d/m/Y', strtotime($fye_date)) : '-' ?></td>
                            <td><?= $fye_month ?></td>
                            <td><?= $agm_due ? date('d/m/Y', strtotime($agm_due)) : '-' ?></td>
                            <td><?= $ar_due ? date('d/m/Y', strtotime($ar_due)) : '-' ?></td>
                            <td>
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
        $('#datatable-fye').DataTable({
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
    var table = $('#datatable-fye').DataTable();
    var month = $('#filter_fye_month').val();
    if (month) {
        var monthNames = ['','January','February','March','April','May','June','July','August','September','October','November','December'];
        table.columns(4).search(monthNames[parseInt(month)]).draw();
    } else {
        table.columns(4).search('').draw();
    }
}

function resetFilter() {
    var table = $('#datatable-fye').DataTable();
    table.search('').columns().search('').draw();
    $('#filter_company').val(null).trigger('change');
    $('#filter_fye_month').val('');
    $('.datepicker').val('');
}
</script>
