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
                    <li><a href="<?= base_url('add_company') ?>"><i class="fa fa-plus-circle" style="margin-right:8px; color:var(--cf-accent);"></i> New Registration</a></li>
                    <li><a href="<?= base_url('add_company?type=transfer') ?>"><i class="fa fa-exchange" style="margin-right:8px; color:var(--cf-warning);"></i> Transfer In</a></li>
                </ul>
            </div>
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
                        <i class="fa fa-database" style="margin-right:4px;"></i>
                        <?= count($companies ?? []) ?> records
                    </span>
                </div>

                <!-- Filter Panel -->
                <div id="filterPanel" style="display:none; background:var(--cf-card-bg); padding:20px; border-radius:var(--cf-radius); margin-bottom:16px; border:1px solid var(--cf-border);">
                    <div class="row">
                        <div class="col-md-3">
                            <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Entity Name</label>
                            <select class="form-control select2" name="company_id[]" multiple>
                                <?php foreach ($companies as $c): ?>
                                <option value="<?= $c->id ?>"><?= htmlspecialchars($c->company_name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Registration No.</label>
                            <input type="text" class="form-control" name="filter_reg_no" placeholder="Enter UEN / Reg No.">
                        </div>
                        <div class="col-md-3">
                            <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">CSS Status</label>
                            <select class="form-control" name="filter_status">
                                <option value="">All Statuses</option>
                                <?php foreach ($statuses as $s): ?>
                                <option value="<?= $s ?>"><?= $s ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Entity Type</label>
                            <select class="form-control" name="filter_entity_status">
                                <option value="">All Types</option>
                                <option value="prospect">Prospect</option>
                                <option value="client">Client</option>
                                <option value="non_client">Non-Client</option>
                            </select>
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
                            <td style="font-size:12px;"><?= $c->fye_date ? date('M', strtotime($c->fye_date)) : '<span style="color:var(--cf-text-muted);">--</span>' ?></td>
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
                                    <a href="<?= base_url("alldocuments?company_id={$c->id}") ?>" class="btn btn-default btn-xs" title="Documents" style="border-radius:6px;">
                                        <i class="fa fa-folder"></i>
                                    </a>
                                    <a href="<?= base_url("shares/company_share_level/{$c->id}") ?>" class="btn btn-default btn-xs" title="Shares" style="border-radius:6px;">
                                        <i class="fa fa-pie-chart"></i>
                                    </a>
                                    <a href="<?= base_url("settings/company_fee_list/{$c->id}") ?>" class="btn btn-default btn-xs" title="Fees" style="border-radius:6px;">
                                        <i class="fa fa-money"></i>
                                    </a>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" style="border-radius:6px;">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
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

function applyFilter() { console.log('Applying filters...'); }
function resetFilter() {
    $('select[name]').val('').trigger('change');
    $('input[name]').val('');
}
</script>
