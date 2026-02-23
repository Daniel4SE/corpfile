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
                            <th>ID</th>
                            <th>Company</th>
                            <th>Sealing Date</th>
                            <th>Description of Documents Sealed</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($sealings)): ?>
                            <?php foreach ($sealings as $s): ?>
                            <tr>
                                <td><?= $s->id ?? '' ?></td>
                                <td><?= htmlspecialchars($s->company_name ?? '') ?></td>
                                <td><?= !empty($s->seal_date) ? date('d/m/Y', strtotime($s->seal_date)) : '' ?></td>
                                <td><?= htmlspecialchars($s->document_description ?? '') ?></td>
                                <td>
                                    <button class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit</button>
                                    <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center text-muted">No sealings found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) { $('#datatable-sealings').DataTable({ pageLength: 25, order: [[2, 'desc']] }); }
});
</script>
