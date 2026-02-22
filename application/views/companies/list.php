<!-- Company Listing Page -->
<div class="page-title">
    <div class="title_left">
        <h3>List Of Companies</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <div class="btn-group">
                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                    Share Discrepancies <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?= base_url('shares/discrepancy_company') ?>">Share Discrepancies</a></li>
                    <li><a href="<?= base_url('shares/partial_full_paid_discrepancy_company') ?>">Partial/Full Paid Discrepancies</a></li>
                </ul>
            </div>
            <a href="<?= base_url('add_company') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Company</a>
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
                            <label>Entity Name</label>
                            <select class="form-control select2" name="company_id[]" multiple>
                                <?php foreach ($companies as $c): ?>
                                <option value="<?= $c->id ?>"><?= htmlspecialchars($c->company_name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Registration No.</label>
                            <input type="text" class="form-control" name="filter_reg_no">
                        </div>
                        <div class="col-md-3">
                            <label>Internal CSS Status</label>
                            <select class="form-control" name="filter_status">
                                <option value="">All</option>
                                <?php foreach ($statuses as $s): ?>
                                <option value="<?= $s ?>"><?= $s ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Entity Status</label>
                            <select class="form-control" name="filter_entity_status">
                                <option value="">All</option>
                                <option value="prospect">Prospect</option>
                                <option value="client">Client</option>
                                <option value="non_client">Non-Client</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <button class="btn btn-success btn-sm" onclick="applyFilter()"><i class="fa fa-search"></i> Apply</button>
                    <button class="btn btn-default btn-sm" onclick="resetFilter()"><i class="fa fa-refresh"></i> Reset</button>
                </div>

                <!-- Data Table -->
                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No.</th>
                            <th>Company Name</th>
                            <th>Client</th>
                            <th>Company ID</th>
                            <th>Registration No.</th>
                            <th>Company Type</th>
                            <th>FYE</th>
                            <th>Registered Address</th>
                            <th>Status</th>
                            <th>Country</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; foreach ($companies as $c): ?>
                        <tr>
                            <td><?= $sno++ ?></td>
                            <td><?= htmlspecialchars($c->company_name) ?></td>
                            <td>
                                <?php if ($c->is_client): ?><span class="label label-success">Client</span><?php endif; ?>
                                <?php if ($c->is_prospect): ?><span class="label label-warning">Prospect</span><?php endif; ?>
                                <?php if ($c->is_non_client): ?><span class="label label-danger">Non-Client</span><?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($c->company_id_code ?? '') ?></td>
                            <td><?= htmlspecialchars($c->registration_number ?? '') ?></td>
                            <td><?= htmlspecialchars($c->company_type_name ?? '') ?></td>
                            <td><?= $c->fye_date ? date('M', strtotime($c->fye_date)) : '' ?></td>
                            <td></td>
                            <td>
                                <span class="label label-<?= $c->entity_status === 'Active' ? 'success' : 'default' ?>">
                                    <?= htmlspecialchars($c->entity_status ?? 'Active') ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($c->country ?? '') ?></td>
                            <td>
                                <a href="<?= base_url("crm/detail_company_lead?id={$c->id}") ?>" class="btn btn-xs" style="background:#206570;color:#fff;">360</a>
                                <a href="<?= base_url("edit_company/{$c->id}/?comp") ?>" class="btn btn-info btn-xs">Edit</a>
                                <a href="<?= base_url("view_company/{$c->id}/?comp") ?>" class="btn btn-primary btn-xs">View</a>
                                <a href="<?= base_url("settings/company_fee_list/{$c->id}") ?>" class="btn btn-primary btn-xs">Fee</a>
                                <a href="<?= base_url("settings/view_company_pdf/{$c->id}") ?>" target="_blank" class="btn btn-primary btn-xs">Pdf</a>
                                <a href="<?= base_url("shares/company_share_level/{$c->id}") ?>" class="btn btn-success btn-xs">Shares</a>
                                <button class="btn btn-danger btn-xs delete_doc" data-id="<?= $c->id ?>"><i class="fa fa-trash"></i></button>
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
            pageLength: 10,
            lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
            order: [[1, 'asc']],
        });
    }
    if ($.fn.select2) {
        $('.select2').select2();
    }
    
    $('#toggleFilter').click(function() {
        $('#filterPanel').slideToggle();
    });
    
    // Delete company
    $('.delete_doc').click(function() {
        var id = $(this).data('id');
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url("companies/delete/") ?>' + id;
                }
            });
        } else if (confirm('Are you sure you want to delete this company?')) {
            window.location.href = '<?= base_url("companies/delete/") ?>' + id;
        }
    });
});

function applyFilter() {
    // Apply filter logic
    console.log('Applying filters...');
}

function resetFilter() {
    $('select[name]').val('').trigger('change');
    $('input[name]').val('');
}
</script>
