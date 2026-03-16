<!-- Company Records - Modern Rillet Style -->
<div class="page-title">
    <div class="title_left">
        <h3>Company Records</h3>
        <p style="color:var(--cf-text-secondary); font-size:14px; margin-top:4px;">
            Manage all company registrations and entity records
        </p>
    </div>
    <div class="title_right">
        <div class="pull-right" style="display:flex; gap:8px; align-items:center;">
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="border-radius:var(--cf-radius-sm);">
                    <i class="fa fa-exclamation-triangle" style="margin-right:4px;"></i> Discrepancies <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?= base_url('shares/discrepancy_company') ?>">Share Discrepancies</a></li>
                    <li><a href="<?= base_url('shares/partial_full_paid_discrepancy_company') ?>">Partial/Full Paid Discrepancies</a></li>
                </ul>
            </div>

            <!-- Split Add Button -->
            <div class="btn-group">
                <a href="<?= base_url('add_company') ?>" class="btn btn-primary" style="border-radius:var(--cf-radius-sm) 0 0 var(--cf-radius-sm);">
                    <i class="fa fa-plus"></i> Add Company
                </a>
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" style="border-radius:0 var(--cf-radius-sm) var(--cf-radius-sm) 0; border-left:1px solid rgba(255,255,255,0.2);">
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="<?= base_url('new_registration') ?>"><i class="fa fa-plus-circle" style="margin-right:8px; color:var(--cf-accent);"></i> New Registration</a></li>
                    <li><a href="<?= base_url('transfer_in') ?>"><i class="fa fa-exchange" style="margin-right:8px; color:var(--cf-warning);"></i> Transfer In</a></li>
                    <li class="divider"></li>
                    <li><a href="<?= base_url('add_company') ?>"><i class="fa fa-pencil-square-o" style="margin-right:8px; color:var(--cf-text-muted);"></i> Manual Add (Legacy)</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<?php
$filters = $filters ?? [];
$selectedCompanyIds = array_map('intval', $filters['company_ids'] ?? []);
$selectedAlerts = $filters['alerts'] ?? [];
$selectedCountry = $filters['country'] ?? 'all';
$selectedClientType = $filters['client_type'] ?? '';
?>

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
                        <i class="fa fa-database" style="margin-right:4px;"></i>
                        <?= count($companies ?? []) ?> records
                    </span>
                </div>

                <div class="cf-stats-bar" style="display:flex;gap:16px;margin-bottom:16px;flex-wrap:wrap;">
                    <div class="cf-stat-card" style="flex:1;min-width:120px;padding:12px 16px;background:#fff;border-radius:8px;border:1px solid var(--cf-border);text-align:center;">
                        <div style="font-size:24px;font-weight:700;color:var(--cf-primary)" id="statTotal">-</div>
                        <div style="font-size:11px;color:var(--cf-text-secondary);text-transform:uppercase;">Total</div>
                    </div>
                    <div class="cf-stat-card" style="flex:1;min-width:120px;padding:12px 16px;background:#fff;border-radius:8px;border:1px solid var(--cf-border);text-align:center;">
                        <div style="font-size:24px;font-weight:700;color:#ef4444" id="statAgmOverdue">-</div>
                        <div style="font-size:11px;color:var(--cf-text-secondary);text-transform:uppercase;">AGM Overdue</div>
                    </div>
                    <div class="cf-stat-card" style="flex:1;min-width:120px;padding:12px 16px;background:#fff;border-radius:8px;border:1px solid var(--cf-border);text-align:center;">
                        <div style="font-size:24px;font-weight:700;color:#ef4444" id="statArOverdue">-</div>
                        <div style="font-size:11px;color:var(--cf-text-secondary);text-transform:uppercase;">AR Overdue</div>
                    </div>
                    <div class="cf-stat-card" style="flex:1;min-width:120px;padding:12px 16px;background:#fff;border-radius:8px;border:1px solid var(--cf-border);text-align:center;">
                        <div style="font-size:24px;font-weight:700;color:#f59e0b" id="statEpDue">-</div>
                        <div style="font-size:11px;color:var(--cf-text-secondary);text-transform:uppercase;">EP Due</div>
                    </div>
                    <div class="cf-stat-card" style="flex:1;min-width:120px;padding:12px 16px;background:#fff;border-radius:8px;border:1px solid var(--cf-border);text-align:center;">
                        <div style="font-size:24px;font-weight:700;color:#6b7280" id="statMissing">-</div>
                        <div style="font-size:11px;color:var(--cf-text-secondary);text-transform:uppercase;">Missing Info</div>
                    </div>
                </div>

                <div class="cf-country-chips">
                    <button type="button" class="btn btn-default btn-sm country-chip <?= ($selectedCountry === 'all' || $selectedCountry === '') ? 'active' : '' ?>" data-country="all">
                        All <span class="badge" id="countryCountAll">0</span>
                    </button>
                    <button type="button" class="btn btn-default btn-sm country-chip <?= ($selectedCountry === 'sg' || $selectedCountry === 'singapore') ? 'active' : '' ?>" data-country="sg">
                        Singapore <span class="badge" id="countryCountSg">0</span>
                    </button>
                    <button type="button" class="btn btn-default btn-sm country-chip <?= ($selectedCountry === 'my' || $selectedCountry === 'malaysia') ? 'active' : '' ?>" data-country="my">
                        Malaysia <span class="badge" id="countryCountMy">0</span>
                    </button>
                    <button type="button" class="btn btn-default btn-sm country-chip <?= ($selectedCountry === 'bvi_cayman' || $selectedCountry === 'bvi' || $selectedCountry === 'cayman') ? 'active' : '' ?>" data-country="bvi_cayman">
                        BVI/Cayman <span class="badge" id="countryCountBvi">0</span>
                    </button>
                    <button type="button" class="btn btn-default btn-sm country-chip <?= $selectedCountry === 'other' ? 'active' : '' ?>" data-country="other">
                        Other <span class="badge" id="countryCountOther">0</span>
                    </button>
                </div>

                <!-- Filter Panel -->
                <div id="filterPanel" style="display:none; background:var(--cf-card-bg); padding:20px; border-radius:var(--cf-radius); margin-bottom:16px; border:1px solid var(--cf-border);">
                    <input type="hidden" name="country" value="<?= htmlspecialchars($selectedCountry) ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Entity Name</label>
                            <select class="form-control select2" name="company_id[]" multiple>
                                <?php foreach ($companies as $c): ?>
                                <option value="<?= $c->id ?>" <?= in_array((int)$c->id, $selectedCompanyIds, true) ? 'selected' : '' ?>><?= htmlspecialchars($c->company_name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Registration No.</label>
                            <input type="text" class="form-control" name="filter_reg_no" placeholder="Enter UEN / Reg No." value="<?= htmlspecialchars($filters['reg_no'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">CSS Status</label>
                            <select class="form-control" name="filter_status">
                                <option value="">All Statuses</option>
                                <?php foreach ($statuses as $s): ?>
                                <option value="<?= $s ?>" <?= ($filters['status'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Entity Type</label>
                            <select class="form-control" name="filter_entity_status">
                                <option value="">All Types</option>
                                <option value="prospect" <?= ($filters['entity_status'] ?? '') === 'prospect' ? 'selected' : '' ?>>Prospect</option>
                                <option value="client" <?= ($filters['entity_status'] ?? '') === 'client' ? 'selected' : '' ?>>Client</option>
                                <option value="non_client" <?= ($filters['entity_status'] ?? '') === 'non_client' ? 'selected' : '' ?>>Non-Client</option>
                            </select>
                        </div>
                    </div>

                    <div class="row" style="margin-top:14px;">
                        <div class="col-md-4">
                            <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Client Type</label>
                            <select class="form-control" name="client_type">
                                <option value="">All Client Types</option>
                                <option value="css_client" <?= $selectedClientType === 'css_client' ? 'selected' : '' ?>>CSS Client</option>
                                <option value="accounting_only" <?= $selectedClientType === 'accounting_only' ? 'selected' : '' ?>>Accounting Only</option>
                                <option value="audit_client" <?= $selectedClientType === 'audit_client' ? 'selected' : '' ?>>Audit Client</option>
                                <option value="listed_related" <?= $selectedClientType === 'listed_related' ? 'selected' : '' ?>>Listed Company Related</option>
                                <option value="ep_client" <?= $selectedClientType === 'ep_client' ? 'selected' : '' ?>>EP Client (有EP)</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Alert Filters</label>
                            <div class="cf-alert-grid">
                                <label class="cf-alert-toggle"><input type="checkbox" name="alert[]" value="fye" <?= in_array('fye', $selectedAlerts, true) ? 'checked' : '' ?>> FYE Alert <span class="badge" id="alertCountFye">0</span></label>
                                <label class="cf-alert-toggle"><input type="checkbox" name="alert[]" value="agm_due" <?= in_array('agm_due', $selectedAlerts, true) ? 'checked' : '' ?>> AGM Due <span class="badge" id="alertCountAgm">0</span></label>
                                <label class="cf-alert-toggle"><input type="checkbox" name="alert[]" value="ar_due" <?= in_array('ar_due', $selectedAlerts, true) ? 'checked' : '' ?>> AR Due <span class="badge" id="alertCountAr">0</span></label>
                                <label class="cf-alert-toggle"><input type="checkbox" name="alert[]" value="ep_due" <?= in_array('ep_due', $selectedAlerts, true) ? 'checked' : '' ?>> EP Due <span class="badge" id="alertCountEp">0</span></label>
                                <label class="cf-alert-toggle"><input type="checkbox" name="alert[]" value="id_passport_due" <?= in_array('id_passport_due', $selectedAlerts, true) ? 'checked' : '' ?>> ID/Passport Due <span class="badge" id="alertCountId">0</span></label>
                                <label class="cf-alert-toggle"><input type="checkbox" name="alert[]" value="missing_info" <?= in_array('missing_info', $selectedAlerts, true) ? 'checked' : '' ?>> Missing Info <span class="badge" id="alertCountMissing">0</span></label>
                                <label class="cf-alert-toggle"><input type="checkbox" name="alert[]" value="iit_due" <?= in_array('iit_due', $selectedAlerts, true) ? 'checked' : '' ?>> IIT Due <span class="badge" id="alertCountIit">0</span></label>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top:14px; display:flex; gap:8px;">
                        <button class="btn btn-primary btn-sm" onclick="applyFilter()">
                            <i class="fa fa-search" style="margin-right:4px;"></i> Apply Filters
                        </button>
                        <button class="btn btn-default btn-sm" onclick="resetFilter()">
                            <i class="fa fa-refresh" style="margin-right:4px;"></i> Reset
                        </button>
                    </div>
                </div>

                <!-- Modern Data Table -->
                <table id="datatable" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Company Name</th>
                            <th>Client</th>
                            <th>ID</th>
                            <th>UEN / Reg No.</th>
                            <th>Type</th>
                            <th>FYE</th>
                            <th style="width:60px;">AGM</th>
                            <th style="width:60px;">AR</th>
                            <th>Status</th>
                            <th>Country</th>
                            <th style="min-width:180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; foreach ($companies as $c): ?>
                        <tr>
                            <td style="color:var(--cf-text-muted); font-size:12px;"><?= $sno++ ?></td>
                            <td>
                                <a href="<?= base_url("view_company/{$c->id}") ?>" style="color:var(--cf-text); font-weight:600;">
                                    <?= htmlspecialchars($c->company_name) ?>
                                </a>
                            </td>
                            <td>
                                <?php if ($c->is_client): ?>
                                    <span class="status-badge active"><i class="fa fa-check"></i> Client</span>
                                <?php elseif ($c->is_prospect): ?>
                                    <span class="status-badge pending"><i class="fa fa-clock-o"></i> Prospect</span>
                                <?php elseif ($c->is_non_client): ?>
                                    <span class="status-badge draft"><i class="fa fa-minus"></i> Non-Client</span>
                                <?php endif; ?>
                            </td>
                            <td style="font-size:12px; color:var(--cf-text-secondary);"><?= htmlspecialchars($c->company_id_code ?? '') ?></td>
                            <td style="font-family:monospace; font-size:12px;"><?= htmlspecialchars($c->registration_number ?? '') ?></td>
                            <td style="font-size:12px;"><?= htmlspecialchars($c->company_type_name ?? '') ?></td>
                            <td style="font-size:12px;">
                                <?php if (!empty($c->fye_date)): ?>
                                    <?= date('d M', strtotime($c->fye_date)) ?>
                                    <span class="label label-default" style="font-size:9px;margin-left:4px;"><?= htmlspecialchars($c->fye_quarter ?? '') ?></span>
                                <?php else: ?>
                                    <span style="color:var(--cf-text-muted);">--</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align:center;">
                                <span style="display:inline-block;width:12px;height:12px;border-radius:50%;background:<?= htmlspecialchars($c->agm_color ?? '#9ca3af') ?>;" title="<?= htmlspecialchars($c->agm_title ?? 'AGM: N/A') ?>"></span>
                            </td>
                            <td style="text-align:center;">
                                <span style="display:inline-block;width:12px;height:12px;border-radius:50%;background:<?= htmlspecialchars($c->ar_color ?? '#9ca3af') ?>;" title="<?= htmlspecialchars($c->ar_title ?? 'AR Due: N/A') ?>"></span>
                            </td>
                            <td>
                                <span class="status-badge <?= $c->entity_status === 'Active' ? 'active' : 'draft' ?>">
                                    <?= htmlspecialchars($c->entity_status ?? 'Active') ?>
                                </span>
                            </td>
                            <td style="font-size:12px;"><?= htmlspecialchars($c->country ?? '') ?></td>
                            <td>
                                <div style="display:flex; gap:4px; flex-wrap:wrap;">
                                    <a href="<?= base_url("view_company/{$c->id}") ?>" class="btn btn-default btn-xs" title="View" style="border-radius:6px;">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url("edit_company/{$c->id}/?comp") ?>" class="btn btn-default btn-xs" title="Edit" style="border-radius:6px;">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <button class="btn btn-warning btn-xs change-btn" data-id="<?= $c->id ?>" data-name="<?= htmlspecialchars($c->company_name) ?>" data-uen="<?= htmlspecialchars($c->registration_number ?? '') ?>" title="File a Change" style="border-radius:6px; color:#fff;">
                                        <i class="fa fa-exchange"></i> Change
                                    </button>
                                    <a href="<?= base_url("alldocuments?company_id={$c->id}") ?>" class="btn btn-default btn-xs" title="Documents" style="border-radius:6px;">
                                        <i class="fa fa-folder"></i>
                                    </a>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" style="border-radius:6px;">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a href="<?= base_url("shares/company_share_level/{$c->id}") ?>"><i class="fa fa-pie-chart" style="margin-right:8px;"></i> Shares</a></li>
                                            <li><a href="<?= base_url("settings/company_fee_list/{$c->id}") ?>"><i class="fa fa-money" style="margin-right:8px;"></i> Fees</a></li>
                                            <li><a href="<?= base_url("crm/detail_company_lead?id={$c->id}") ?>"><i class="fa fa-th-large" style="margin-right:8px;"></i> 360 View</a></li>
                                            <li><a href="<?= base_url("settings/view_company_pdf/{$c->id}") ?>" target="_blank"><i class="fa fa-file-pdf-o" style="margin-right:8px;"></i> Export PDF</a></li>
                                            <li class="divider"></li>
                                            <li><a href="javascript:;" class="delete_doc" data-id="<?= $c->id ?>" style="color:var(--cf-danger);"><i class="fa fa-trash" style="margin-right:8px;"></i> Delete</a></li>
                                        </ul>
                                    </div>
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
var currentFilters = <?= json_encode($filters ?? []) ?>;

$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#datatable').DataTable({
            pageLength: 20,
            lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
            order: [[1, 'asc']],
            language: {
                search: '',
                searchPlaceholder: 'Search companies...',
                info: 'Showing _START_ to _END_ of _TOTAL_ companies',
                paginate: { previous: '<i class="fa fa-chevron-left"></i>', next: '<i class="fa fa-chevron-right"></i>' }
            }
        });
    }

    if ($.fn.select2) {
        $('.select2').select2({ placeholder: 'Select companies...' });
    }

    if ((currentFilters.alerts && currentFilters.alerts.length) || (currentFilters.client_type) || (currentFilters.reg_no) || (currentFilters.status) || (currentFilters.entity_status) || (currentFilters.company_ids && currentFilters.company_ids.length)) {
        $('#filterPanel').show();
        $('#toggleFilter').addClass('active');
    }

    $(document).on('click', '.country-chip', function() {
        $('.country-chip').removeClass('active');
        $(this).addClass('active');
        $('input[name="country"]').val($(this).data('country'));
    });

    loadFilterCounts();

    $('#toggleFilter').click(function() {
        $('#filterPanel').slideToggle(200);
        $(this).toggleClass('active');
    });

    $(document).on('click', '.delete_doc', function() {
        var id = $(this).data('id');
        if (typeof swal !== 'undefined') {
            swal({
                title: 'Delete Company?',
                text: 'This action cannot be undone.',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, delete'
            }, function(confirmed) {
                if (confirmed) {
                    window.location.href = '<?= base_url("companies/delete/") ?>' + id;
                }
            });
        } else if (confirm('Are you sure you want to delete this company?')) {
            window.location.href = '<?= base_url("companies/delete/") ?>' + id;
        }
    });
});

function loadFilterCounts() {
    $.getJSON('<?= base_url('company_list/filter_counts') ?>', function(resp) {
        if (!resp || !resp.ok || !resp.counts) return;

        $('#countryCountAll').text(resp.counts.country.all || 0);
        $('#countryCountSg').text(resp.counts.country.sg || 0);
        $('#countryCountMy').text(resp.counts.country.my || 0);
        $('#countryCountBvi').text(resp.counts.country.bvi_cayman || 0);
        $('#countryCountOther').text(resp.counts.country.other || 0);

        $('#alertCountFye').text(resp.counts.alerts.fye || 0);
        $('#alertCountAgm').text(resp.counts.alerts.agm_due || 0);
        $('#alertCountAr').text(resp.counts.alerts.ar_due || 0);
        $('#alertCountEp').text(resp.counts.alerts.ep_due || 0);
        $('#alertCountId').text(resp.counts.alerts.id_passport_due || 0);
        $('#alertCountMissing').text(resp.counts.alerts.missing_info || 0);
        $('#alertCountIit').text(resp.counts.alerts.iit_due || 0);

        $('#statTotal').text(resp.counts.country.all || 0);
        $('#statAgmOverdue').text(resp.counts.alerts.agm_overdue || 0);
        $('#statArOverdue').text(resp.counts.alerts.ar_overdue || 0);
        $('#statEpDue').text(resp.counts.alerts.ep_due || 0);
        $('#statMissing').text(resp.counts.alerts.missing_info || 0);
    });
}

function applyFilter() {
    var params = new URLSearchParams();
    var country = $('input[name="country"]').val() || 'all';

    if (country && country !== 'all') {
        params.set('country', country);
    }

    var companyIds = $('select[name="company_id[]"]').val() || [];
    companyIds.forEach(function(id) {
        if (id) params.append('company_id[]', id);
    });

    var regNo = $('input[name="filter_reg_no"]').val().trim();
    if (regNo) params.set('filter_reg_no', regNo);

    var status = $('select[name="filter_status"]').val();
    if (status) params.set('filter_status', status);

    var entityStatus = $('select[name="filter_entity_status"]').val();
    if (entityStatus) params.set('filter_entity_status', entityStatus);

    var clientType = $('select[name="client_type"]').val();
    if (clientType) params.set('client_type', clientType);

    $('input[name="alert[]"]:checked').each(function() {
        params.append('alert[]', $(this).val());
    });

    var url = '<?= base_url('company_list') ?>';
    var query = params.toString();
    window.location.href = query ? (url + '?' + query) : url;
}

function resetFilter() {
    window.location.href = '<?= base_url('company_list') ?>';
}

/* ── Change Button: open modal ── */
$(document).ready(function() {

$(document).on('click', '.change-btn', function() {
    var companyId = $(this).data('id');
    var companyName = $(this).data('name');
    var companyUen = $(this).data('uen');
    $('#changeCompanyName').text(companyName);
    $('#changeCompanyUen').text(companyUen ? ' (' + companyUen + ')' : '');
    $('#changeCompanyId').val(companyId);
    $('#changeModal').modal('show');
    // Reset state
    $('#changeItems').find('input[type=checkbox]').prop('checked', false);
    $('#changeDetails').val('');
    $('#changeResult').hide().html('');
    $('#changeGenerateBtn').prop('disabled', false).text('Generate Documents with AI');
});

/* ── Generate Change Documents ── */
$('#changeGenerateBtn').on('click', function() {
    var companyId = $('#changeCompanyId').val();
    var companyName = $('#changeCompanyName').text();
    var selected = [];
    $('#changeItems input[type=checkbox]:checked').each(function() {
        selected.push($(this).val());
    });
    var details = $('#changeDetails').val().trim();

    if (selected.length === 0 && !details) {
        alert('Please select at least one change type or provide details.');
        return;
    }

    var btn = $(this);
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Generating...');
    $('#changeResult').show().html('<div style="padding:20px;text-align:center;color:var(--cf-text-muted);"><i class="fa fa-spinner fa-spin fa-2x"></i><br>AI is generating change documents...</div>');

    var prompt = 'Generate corporate change documents for company "' + companyName + '" (ID: ' + companyId + ').\n\n';
    prompt += 'Change types selected: ' + (selected.length ? selected.join(', ') : 'See details below') + '.\n';
    if (details) prompt += 'Additional details: ' + details + '\n';
    prompt += '\nPlease generate:\n';
    prompt += '1. Board Resolution (Directors Resolution in Writing) covering all selected changes\n';
    prompt += '2. List of ACRA forms needed for each change\n';
    prompt += '3. Summary of documents that need to be signed\n';
    prompt += '4. Timeline and next steps\n';
    prompt += '\nIf multiple changes are of the same resolution type (e.g. all are board resolutions), combine them into ONE resolution document.\n';
    prompt += 'Format the resolution in proper legal language for a Singapore company.';

    fetch('<?= base_url("ai/chat") ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ message: prompt, source: 'agent', agent: 'docgen' })
    })
    .then(function(r) { return r.text(); })
    .then(function(text) {
        var jsonMatch = text.match(/\{[\s\S]*\}$/);
        if (jsonMatch) {
            var data = JSON.parse(jsonMatch[0]);
            btn.prop('disabled', false).text('Generate Documents with AI');
            if (data.ok && data.response_text) {
                var md = (typeof cfRenderMarkdown === 'function') ? cfRenderMarkdown(data.response_text) : data.response_text;
                $('#changeResult').html(
                    '<div style="border:1px solid var(--cf-border);border-radius:var(--cf-radius);padding:16px;background:#f8fafc;max-height:400px;overflow-y:auto;">' +
                    '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">' +
                    '<strong style="color:var(--cf-primary);"><i class="fa fa-file-text-o"></i> Generated Documents</strong>' +
                    '<button class="btn btn-default btn-xs" onclick="copyChangeResult()" title="Copy"><i class="fa fa-copy"></i> Copy</button>' +
                    '</div>' +
                    '<div id="changeResultContent" class="cf-ai-content" style="font-size:13px;line-height:1.7;">' + md + '</div>' +
                    '</div>'
                );
            } else {
                $('#changeResult').html('<div class="alert alert-danger">' + (data.error || 'Failed to generate.') + '</div>');
            }
        }
    })
    .catch(function() {
        btn.prop('disabled', false).text('Generate Documents with AI');
        $('#changeResult').html('<div class="alert alert-danger">Connection error. Please try again.</div>');
    });
});
});

function copyChangeResult() {
    var el = document.getElementById('changeResultContent');
    if (el) {
        var range = document.createRange();
        range.selectNodeContents(el);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
        document.execCommand('copy');
        sel.removeAllRanges();
        alert('Copied to clipboard!');
    }
}
</script>

<!-- Change Modal -->
<div class="modal fade" id="changeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius:var(--cf-radius);border:none;box-shadow:var(--cf-shadow-lg);">
            <div class="modal-header" style="background:linear-gradient(135deg,var(--cf-primary),var(--cf-primary-light));color:#fff;border-radius:var(--cf-radius) var(--cf-radius) 0 0;padding:18px 24px;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:0.8;font-size:24px;">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-exchange" style="margin-right:8px;"></i> File Company Change
                </h4>
                <div style="font-size:13px;opacity:0.85;margin-top:4px;">
                    <span id="changeCompanyName"></span><span id="changeCompanyUen" style="font-family:monospace;"></span>
                </div>
            </div>
            <div class="modal-body" style="padding:24px;">
                <input type="hidden" id="changeCompanyId">

                <p style="font-size:13px;color:var(--cf-text-secondary);margin-bottom:16px;">
                    Select the changes you need to file. AI will generate the required resolution documents, ACRA forms list, and signing instructions.
                </p>

                <div id="changeItems" style="display:grid; grid-template-columns:1fr 1fr; gap:8px; margin-bottom:16px;">
                    <label class="change-check-item"><input type="checkbox" value="Change of Company Name"> <i class="fa fa-pencil-square-o"></i> Company Name</label>
                    <label class="change-check-item"><input type="checkbox" value="Change of Registered Address"> <i class="fa fa-map-marker"></i> Registered Address</label>
                    <label class="change-check-item"><input type="checkbox" value="Appointment of New Director"> <i class="fa fa-user-plus"></i> Appoint Director</label>
                    <label class="change-check-item"><input type="checkbox" value="Resignation/Removal of Director"> <i class="fa fa-user-minus"></i> Remove Director</label>
                    <label class="change-check-item"><input type="checkbox" value="Change of Company Secretary"> <i class="fa fa-id-badge"></i> Company Secretary</label>
                    <label class="change-check-item"><input type="checkbox" value="Transfer of Shares"> <i class="fa fa-exchange"></i> Transfer of Shares</label>
                    <label class="change-check-item"><input type="checkbox" value="Allotment of New Shares"> <i class="fa fa-plus-circle"></i> Allot New Shares</label>
                    <label class="change-check-item"><input type="checkbox" value="Change of Financial Year End"> <i class="fa fa-calendar"></i> Financial Year End</label>
                    <label class="change-check-item"><input type="checkbox" value="Change of SSIC / Business Activity"> <i class="fa fa-industry"></i> SSIC / Activity</label>
                    <label class="change-check-item"><input type="checkbox" value="Change of Auditor"> <i class="fa fa-gavel"></i> Auditor</label>
                    <label class="change-check-item"><input type="checkbox" value="Amendment of Constitution / M&AA"> <i class="fa fa-book"></i> Constitution / M&AA</label>
                    <label class="change-check-item"><input type="checkbox" value="Striking Off / Closure"> <i class="fa fa-ban"></i> Striking Off</label>
                </div>

                <div class="form-group">
                    <label style="font-weight:600;font-size:13px;">Additional Details (optional)</label>
                    <textarea id="changeDetails" class="form-control" rows="3" placeholder="E.g. New director name: John Tan, NRIC: S1234567A, appointed from 15 Mar 2026..."></textarea>
                </div>

                <button id="changeGenerateBtn" class="btn btn-primary btn-block" style="border-radius:var(--cf-radius-sm);padding:10px;font-weight:600;">
                    <i class="fa fa-magic" style="margin-right:6px;"></i> Generate Documents with AI
                </button>

                <div id="changeResult" style="margin-top:16px; display:none;"></div>
            </div>
        </div>
    </div>
</div>

<style>
.change-check-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border: 1px solid var(--cf-border);
    border-radius: var(--cf-radius-sm);
    cursor: pointer;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.15s;
    margin: 0;
}
.change-check-item:hover { background: var(--cf-card-bg); border-color: var(--cf-accent); }
.change-check-item input[type=checkbox]:checked + i { color: var(--cf-primary); }
.change-check-item:has(input:checked) { background: #eff6ff; border-color: var(--cf-accent); }

.cf-country-chips {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 14px;
}
.cf-country-chips .country-chip {
    border-radius: 999px;
    border-color: var(--cf-border);
    color: var(--cf-primary);
}
.cf-country-chips .country-chip.active {
    background: var(--cf-primary);
    border-color: var(--cf-primary);
    color: #fff;
}
.cf-country-chips .country-chip .badge {
    margin-left: 6px;
    background: rgba(32, 101, 112, 0.12);
    color: var(--cf-primary);
}
.cf-country-chips .country-chip.active .badge {
    background: rgba(255, 255, 255, 0.22);
    color: #fff;
}

.cf-alert-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(120px, 1fr));
    gap: 8px;
}
.cf-alert-toggle {
    margin: 0;
    padding: 8px 10px;
    border: 1px solid var(--cf-border);
    border-radius: var(--cf-radius-sm);
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    background: #fff;
}
.cf-alert-toggle input { margin: 0 6px 0 0; }
.cf-alert-toggle .badge {
    background: #f59e0b;
    color: #fff;
}

@media (max-width: 992px) {
    .cf-alert-grid { grid-template-columns: repeat(2, minmax(120px, 1fr)); }
}

@media (max-width: 640px) {
    .cf-alert-grid { grid-template-columns: 1fr; }
}
</style>
