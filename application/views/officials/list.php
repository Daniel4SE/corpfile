<!-- Company Officials Global Listing -->
<div class="page-title">
    <div class="title_left">
        <h3>Company Officials</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('company_list') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Companies</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <!-- Data Table -->
                <table id="datatable-officials" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No.</th>
                            <th>Company Name</th>
                            <th>Registration No.</th>
                            <th>Status</th>
                            <th>Total Directors</th>
                            <th>Total Shareholders</th>
                            <th>Total Secretaries</th>
                            <th>Total Auditors</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; foreach ($companies as $c): ?>
                        <tr>
                            <td><?= $sno++ ?></td>
                            <td><?= htmlspecialchars($c->company_name) ?></td>
                            <td><?= htmlspecialchars($c->registration_number ?? '') ?></td>
                            <td>
                                <span class="label label-<?= ($c->entity_status ?? 'Active') === 'Active' ? 'success' : 'default' ?>">
                                    <?= htmlspecialchars($c->entity_status ?? 'Active') ?>
                                </span>
                            </td>
                            <td><span class="badge bg-blue"><?= $c->total_directors ?? 0 ?></span></td>
                            <td><span class="badge bg-green"><?= $c->total_shareholders ?? 0 ?></span></td>
                            <td><span class="badge bg-purple"><?= $c->total_secretaries ?? 0 ?></span></td>
                            <td><span class="badge bg-orange"><?= $c->total_auditors ?? 0 ?></span></td>
                            <td>
                                <a href="<?= base_url("officials_list/{$c->id}") ?>" class="btn btn-primary btn-xs">
                                    <i class="fa fa-eye"></i> View Officials
                                </a>
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
        $('#datatable-officials').DataTable({
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            order: [[1, 'asc']],
        });
    }
});
</script>
