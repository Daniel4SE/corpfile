<!-- Sealings List -->
<div class="page-title">
    <div class="title_left">
        <h3>Sealings List</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('add_seal') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Seal</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-sealings" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Company</th>
                            <th>Seal Type</th>
                            <th>Seal Number</th>
                            <th>Date Sealed</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($sealings)): ?>
                            <?php $sno = 1; foreach ($sealings as $s): ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><?= htmlspecialchars($s->company_name ?? '') ?></td>
                                <td><?= htmlspecialchars($s->seal_type ?? '') ?></td>
                                <td><?= htmlspecialchars($s->seal_number ?? '') ?></td>
                                <td><?= !empty($s->date_sealed) ? date('d/m/Y', strtotime($s->date_sealed)) : '' ?></td>
                                <td><?= htmlspecialchars($s->description ?? '') ?></td>
                                <td><span class="label label-<?= ($s->status ?? '') === 'Active' ? 'success' : 'default' ?>"><?= htmlspecialchars($s->status ?? '') ?></span></td>
                                <td>
                                    <button class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="8" class="text-center text-muted">No sealings found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) { $('#datatable-sealings').DataTable({ pageLength: 10, order: [[4, 'desc']] }); }
});
</script>
