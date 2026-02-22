<!-- Report Template - Reusable view for all 87+ report types -->
<div class="page-title">
    <div class="title_left">
        <h3><?= htmlspecialchars($report_config['title']) ?></h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <button class="btn btn-success btn-sm" id="exportExcel"><i class="fa fa-file-excel-o"></i> Export Excel</button>
            <button class="btn btn-danger btn-sm" id="exportPdf"><i class="fa fa-file-pdf-o"></i> Export PDF</button>
            <button class="btn btn-info btn-sm" id="printReport"><i class="fa fa-print"></i> Print</button>
            <a href="javascript:history.back()" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-filter"></i> Filters</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="filterPanel" style="background:#f9f9f9;padding:15px;border-radius:5px;margin-bottom:15px;">
                    <form id="reportFilterForm" method="post" action="<?= base_url('report_view/' . htmlspecialchars($report_type)) ?>">
                        <input type="hidden" name="ci_csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Company</label>
                                    <select class="form-control select2" name="filter_company" id="filter_company">
                                        <option value="">-- All Companies --</option>
                                        <?php if (!empty($companies)): foreach ($companies as $comp): ?>
                                        <option value="<?= htmlspecialchars($comp->id) ?>" <?= ($filters['company'] == $comp->id) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($comp->company_name) ?>
                                        </option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Date From</label>
                                    <input type="text" class="form-control datepicker" name="date_from" id="date_from"
                                           placeholder="dd/mm/yyyy" value="<?= htmlspecialchars($filters['date_from'] ?? '') ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Date To</label>
                                    <input type="text" class="form-control datepicker" name="date_to" id="date_to"
                                           placeholder="dd/mm/yyyy" value="<?= htmlspecialchars($filters['date_to'] ?? '') ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="filter_status" id="filter_status">
                                        <option value="">-- All --</option>
                                        <option value="Active" <?= ($filters['status'] ?? '') === 'Active' ? 'selected' : '' ?>>Active</option>
                                        <option value="Ceased" <?= ($filters['status'] ?? '') === 'Ceased' ? 'selected' : '' ?>>Ceased</option>
                                        <option value="Inactive" <?= ($filters['status'] ?? '') === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                                        <option value="Pending" <?= ($filters['status'] ?? '') === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3" style="padding-top:25px;">
                                <button type="submit" class="btn btn-success btn-sm" id="btnGenerate">
                                    <i class="fa fa-search"></i> Generate
                                </button>
                                <button type="button" class="btn btn-default btn-sm" id="btnReset">
                                    <i class="fa fa-refresh"></i> Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-table"></i> <?= htmlspecialchars($report_config['title']) ?>
                    <?php if (!empty($report_data)): ?>
                    <small class="text-muted">(<?= count($report_data) ?> record<?= count($report_data) !== 1 ? 's' : '' ?>)</small>
                    <?php endif; ?>
                </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table id="reportTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead style="background:#206570;color:#fff;">
                            <tr>
                                <?php foreach ($report_config['columns'] as $col): ?>
                                <th><?= htmlspecialchars($col) ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($report_data)): ?>
                                <?php foreach ($report_data as $row): ?>
                                <tr>
                                    <?php foreach ($row as $cell): ?>
                                    <td><?= htmlspecialchars($cell ?? '') ?></td>
                                    <?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="<?= count($report_config['columns']) ?>" class="text-center" style="padding:30px;">
                                    <i class="fa fa-info-circle fa-2x text-muted" style="display:block;margin-bottom:10px;"></i>
                                    No data found. Please adjust filters and click <strong>Generate</strong> to load the report.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // ── Initialize DataTable ──────────────────────────────────────────────
    var reportTable = null;
    <?php if (!empty($report_data)): ?>
    if ($.fn.DataTable) {
        reportTable = $('#reportTable').DataTable({
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            order: [[0, 'asc']],
            dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>rtip',
            language: {
                search: 'Search:',
                lengthMenu: 'Show _MENU_ entries',
                info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                emptyTable: 'No data available',
                zeroRecords: 'No matching records found'
            },
            responsive: true
        });
    }
    <?php endif; ?>

    // ── Select2 for Company filter ────────────────────────────────────────
    if ($.fn.select2) {
        $('#filter_company').select2({
            placeholder: '-- All Companies --',
            allowClear: true,
            width: '100%'
        });
    }

    // ── Datepicker ────────────────────────────────────────────────────────
    if ($.fn.datepicker) {
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });
    } else if ($.fn.daterangepicker) {
        $('.datepicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: { format: 'DD/MM/YYYY' },
            autoUpdateInput: false
        }).on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        }).on('cancel.daterangepicker', function() {
            $(this).val('');
        });
    }

    // ── Reset Filters ─────────────────────────────────────────────────────
    $('#btnReset').on('click', function() {
        $('#filter_company').val('').trigger('change');
        $('#date_from').val('');
        $('#date_to').val('');
        $('#filter_status').val('');
    });

    // ── Export to Excel ───────────────────────────────────────────────────
    $('#exportExcel').on('click', function() {
        var title = <?= json_encode($report_config['title']) ?>;
        var csv = [];
        var headers = [];

        // Get headers
        $('#reportTable thead th').each(function() {
            headers.push('"' + $(this).text().replace(/"/g, '""') + '"');
        });
        csv.push(headers.join(','));

        // Get rows
        $('#reportTable tbody tr').each(function() {
            var row = [];
            $(this).find('td').each(function() {
                row.push('"' + $(this).text().trim().replace(/"/g, '""') + '"');
            });
            if (row.length > 1) { // skip "no data" row
                csv.push(row.join(','));
            }
        });

        // Download
        var csvContent = '\uFEFF' + csv.join('\n'); // BOM for Excel UTF-8
        var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        var link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = title.replace(/[^a-zA-Z0-9]/g, '_') + '_' + new Date().toISOString().slice(0, 10) + '.csv';
        link.click();
        URL.revokeObjectURL(link.href);
    });

    // ── Export to PDF ─────────────────────────────────────────────────────
    $('#exportPdf').on('click', function() {
        var title = <?= json_encode($report_config['title']) ?>;

        // Use browser print with styling as PDF fallback
        var printWindow = window.open('', '_blank');
        var tableHtml = $('#reportTable').clone();

        // Remove DataTable wrappers if present
        printWindow.document.write(
            '<!DOCTYPE html><html><head><title>' + title + '</title>' +
            '<style>' +
            'body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }' +
            'h2 { color: #206570; margin-bottom: 5px; }' +
            'p { color: #666; font-size: 11px; margin-bottom: 15px; }' +
            'table { width: 100%; border-collapse: collapse; }' +
            'th { background: #206570; color: #fff; padding: 8px; border: 1px solid #ddd; font-size: 11px; }' +
            'td { padding: 6px 8px; border: 1px solid #ddd; font-size: 11px; }' +
            'tr:nth-child(even) { background: #f9f9f9; }' +
            '@media print { body { margin: 0; } }' +
            '</style></head><body>' +
            '<h2>' + title + '</h2>' +
            '<p>Generated on: ' + new Date().toLocaleDateString('en-GB') + '</p>' +
            tableHtml[0].outerHTML +
            '<script>window.onload=function(){window.print();window.close();}<\/script>' +
            '</body></html>'
        );
        printWindow.document.close();
    });

    // ── Print Report ──────────────────────────────────────────────────────
    $('#printReport').on('click', function() {
        var title = <?= json_encode($report_config['title']) ?>;
        var printWindow = window.open('', '_blank');
        var tableHtml = $('#reportTable').clone();

        printWindow.document.write(
            '<!DOCTYPE html><html><head><title>' + title + '</title>' +
            '<style>' +
            'body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }' +
            'h2 { color: #206570; margin-bottom: 5px; }' +
            'p { color: #666; font-size: 11px; margin-bottom: 15px; }' +
            'table { width: 100%; border-collapse: collapse; }' +
            'th { background: #206570; color: #fff; padding: 8px; border: 1px solid #ddd; font-size: 11px; }' +
            'td { padding: 6px 8px; border: 1px solid #ddd; font-size: 11px; }' +
            'tr:nth-child(even) { background: #f9f9f9; }' +
            '@media print { body { margin: 0; } }' +
            '</style></head><body>' +
            '<h2>' + title + '</h2>' +
            '<p>Printed on: ' + new Date().toLocaleDateString('en-GB') + '</p>' +
            tableHtml[0].outerHTML +
            '<script>window.onload=function(){window.print();}<\/script>' +
            '</body></html>'
        );
        printWindow.document.close();
    });
});
</script>
