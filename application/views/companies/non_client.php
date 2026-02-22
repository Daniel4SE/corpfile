<!-- Non-Client Company Listing -->
<div class="page-title">
    <div class="title_left">
        <h3>Non-Client Companies <small>(Total: <?= $total ?? 0 ?>)</small></h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('add_company') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Company</a>
            <a href="<?= base_url('company_list') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> All Companies</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="alert alert-warning">
                    <i class="fa fa-info-circle"></i> Showing <strong>Non-Client</strong> companies only.
                </div>

                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No.</th>
                            <th>Company Name</th>
                            <th>Company ID</th>
                            <th>Registration No.</th>
                            <th>Company Type</th>
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
                            <td><?= htmlspecialchars($c->company_id_code ?? '') ?></td>
                            <td><?= htmlspecialchars($c->registration_number ?? '') ?></td>
                            <td><?= htmlspecialchars($c->company_type_name ?? '') ?></td>
                            <td><span class="label label-<?= ($c->entity_status ?? '') === 'Active' ? 'success' : 'default' ?>"><?= htmlspecialchars($c->entity_status ?? '') ?></span></td>
                            <td><?= htmlspecialchars($c->country ?? '') ?></td>
                            <td>
                                <a href="<?= base_url("edit_company/{$c->id}/?comp") ?>" class="btn btn-info btn-xs">Edit</a>
                                <a href="<?= base_url("view_company/{$c->id}/?comp") ?>" class="btn btn-primary btn-xs">View</a>
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
        $('#datatable').DataTable({ pageLength: 10, lengthMenu: [[10,20,50,100,-1],[10,20,50,100,"All"]], order: [[1,'asc']] });
    }
});
</script>
