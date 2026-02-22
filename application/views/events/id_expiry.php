<!-- ID Document Expiry Listing Page -->
<div class="page-title">
    <div class="title_left">
        <h3>ID Document Expiry Listing</h3>
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
                            <label>Expiry Date Range</label>
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
                                <option value="expired">Expired</option>
                                <option value="expiring">Expiring Soon</option>
                                <option value="valid">Valid</option>
                            </select>
                        </div>
                        <div class="col-md-3" style="padding-top:25px;">
                            <button class="btn btn-success btn-sm" onclick="applyFilter()"><i class="fa fa-search"></i> Apply</button>
                            <button class="btn btn-default btn-sm" onclick="resetFilter()"><i class="fa fa-refresh"></i> Reset</button>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <table id="datatable-idexpiry" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No.</th>
                            <th>Name</th>
                            <th>ID Type</th>
                            <th>ID Number</th>
                            <th>Expiry Date</th>
                            <th>Days Until Expiry</th>
                            <th>Nationality</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; foreach ($members as $m): ?>
                        <?php
                            $today = date('Y-m-d');
                            $expiry_date = $m->id_expiry_date ?? null;
                            $days_to_expiry = $expiry_date ? (int)((strtotime($expiry_date) - strtotime($today)) / 86400) : null;
                            
                            if ($days_to_expiry !== null && $days_to_expiry < 0) {
                                $status = 'expired'; $status_label = 'danger'; $status_text = 'Expired';
                            } elseif ($days_to_expiry !== null && $days_to_expiry <= 90) {
                                $status = 'expiring'; $status_label = 'warning'; $status_text = 'Expiring Soon';
                            } else {
                                $status = 'valid'; $status_label = 'success'; $status_text = 'Valid';
                            }
                        ?>
                        <tr>
                            <td><?= $sno++ ?></td>
                            <td><?= htmlspecialchars($m->name ?? '') ?></td>
                            <td><?= htmlspecialchars($m->id_type ?? '') ?></td>
                            <td><?= htmlspecialchars($m->id_number ?? '') ?></td>
                            <td><?= $expiry_date ? date('d/m/Y', strtotime($expiry_date)) : '-' ?></td>
                            <td>
                                <?php if ($days_to_expiry !== null): ?>
                                    <span class="text-<?= $days_to_expiry < 0 ? 'danger' : ($days_to_expiry <= 90 ? 'warning' : 'success') ?>">
                                        <?php if ($days_to_expiry < 0): ?>
                                            <?= abs($days_to_expiry) ?> days ago
                                        <?php else: ?>
                                            <?= $days_to_expiry ?> days
                                        <?php endif; ?>
                                    </span>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($m->nationality ?? '') ?></td>
                            <td data-status="<?= $status ?>">
                                <span class="label label-<?= $status_label ?>"><?= $status_text ?></span>
                            </td>
                            <td>
                                <a href="<?= base_url("view_member/{$m->id}") ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
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
        $('#datatable-idexpiry').DataTable({
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
    var table = $('#datatable-idexpiry').DataTable();
    var status = $('#filter_status').val();
    if (status) { table.columns(7).search(status).draw(); }
    else { table.columns(7).search('').draw(); }
}

function resetFilter() {
    var table = $('#datatable-idexpiry').DataTable();
    table.search('').columns().search('').draw();
    $('#filter_company').val(null).trigger('change');
    $('#filter_status').val('');
    $('.datepicker').val('');
}
</script>
