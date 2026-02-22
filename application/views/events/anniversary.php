<!-- Company Anniversary Listing Page -->
<div class="page-title">
    <div class="title_left">
        <h3>Company Anniversary Listing</h3>
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
                            <label>Incorporation Date Range</label>
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
                            <label>Anniversary Month</label>
                            <select class="form-control" id="filter_month">
                                <option value="">All</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>
                        <div class="col-md-3" style="padding-top:25px;">
                            <button class="btn btn-success btn-sm" onclick="applyFilter()"><i class="fa fa-search"></i> Apply</button>
                            <button class="btn btn-default btn-sm" onclick="resetFilter()"><i class="fa fa-refresh"></i> Reset</button>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <table id="datatable-anniversary" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No.</th>
                            <th>Company Name</th>
                            <th>Registration No.</th>
                            <th>Incorporation Date</th>
                            <th>Anniversary Month</th>
                            <th>Years Since Incorporation</th>
                            <th>Next Anniversary</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; foreach ($anniversaries as $a): ?>
                        <?php
                            $incorp_date = $a->incorporation_date ?? null;
                            $years = 0;
                            $next_anniversary = '-';
                            $anniversary_month = '-';
                            $days_to_next = null;
                            
                            if ($incorp_date) {
                                $incorp_ts = strtotime($incorp_date);
                                $anniversary_month = date('F', $incorp_ts);
                                $years = (int)date_diff(date_create($incorp_date), date_create('today'))->format('%y');
                                
                                $this_year_anniv = date('Y') . date('-m-d', $incorp_ts);
                                if (strtotime($this_year_anniv) < strtotime('today')) {
                                    $next_anniversary = (date('Y') + 1) . date('-m-d', $incorp_ts);
                                } else {
                                    $next_anniversary = $this_year_anniv;
                                }
                                $days_to_next = (int)((strtotime($next_anniversary) - strtotime('today')) / 86400);
                            }
                            
                            if ($days_to_next !== null && $days_to_next <= 30) {
                                $status_label = 'warning'; $status_text = 'Upcoming';
                            } elseif ($days_to_next !== null && $days_to_next <= 90) {
                                $status_label = 'info'; $status_text = 'Approaching';
                            } else {
                                $status_label = 'success'; $status_text = 'Active';
                            }
                        ?>
                        <tr>
                            <td><?= $sno++ ?></td>
                            <td><?= htmlspecialchars($a->company_name) ?></td>
                            <td><?= htmlspecialchars($a->registration_number ?? '') ?></td>
                            <td><?= $incorp_date ? date('d/m/Y', strtotime($incorp_date)) : '-' ?></td>
                            <td><?= $anniversary_month ?></td>
                            <td><?= $years ?> year<?= $years !== 1 ? 's' : '' ?></td>
                            <td>
                                <?php if ($next_anniversary !== '-'): ?>
                                    <?= date('d/m/Y', strtotime($next_anniversary)) ?>
                                    <small class="text-muted">(<?= $days_to_next ?> days)</small>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="label label-<?= $status_label ?>"><?= $status_text ?></span>
                            </td>
                            <td>
                                <a href="<?= base_url("view_company/{$a->id}") ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
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
        $('#datatable-anniversary').DataTable({
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            order: [[6, 'asc']],
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
    var table = $('#datatable-anniversary').DataTable();
    var month = $('#filter_month').val();
    if (month) { table.columns(4).search(month).draw(); }
    else { table.columns(4).search('').draw(); }
}

function resetFilter() {
    var table = $('#datatable-anniversary').DataTable();
    table.search('').columns().search('').draw();
    $('#filter_company').val(null).trigger('change');
    $('#filter_month').val('');
    $('.datepicker').val('');
}
</script>
