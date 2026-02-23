<!-- All Documents -->
<div class="page-title">
    <div class="title_left">
        <h3>All Documents</h3>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-documents" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No.</th>
                            <th>Entity Name/Registration No.</th>
                            <th>Document</th>
                            <th>Category</th>
                            <th>Resolution Date</th>
                            <th>Created Date</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; foreach ($documents as $doc): ?>
                        <tr>
                            <td><?= $sno++ ?></td>
                            <td><?= htmlspecialchars($doc->company_name ?? '') ?></td>
                            <td>
                                <?php if (!empty($doc->file_path)): ?>
                                <a href="<?= htmlspecialchars($doc->file_path) ?>" target="_blank">
                                    <?= htmlspecialchars($doc->document_name ?? '') ?>
                                </a>
                                <?php else: ?>
                                <?= htmlspecialchars($doc->document_name ?? '') ?>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($doc->category_name ?? '') ?></td>
                            <td></td>
                            <td><?= !empty($doc->created_at) ? date('d/m/Y', strtotime($doc->created_at)) : '' ?></td>
                            <td></td>
                            <td>
                                <?php if (!empty($doc->file_path)): ?>
                                <a href="<?= base_url('file_preview/' . $doc->id) ?>" class="btn btn-xs btn-info" title="Preview"><i class="fa fa-eye"></i> preview</a>
                                <a href="<?= htmlspecialchars($doc->file_path) ?>" class="btn btn-xs btn-primary" title="Download" download><i class="fa fa-download"></i> Download</a>
                                <?php endif; ?>
                                <a href="<?= base_url('edit_document/' . $doc->id) ?>" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-pencil"></i> Edit</a>
                                <button class="btn btn-xs btn-danger delete-item" data-id="<?= $doc->id ?>" title="Delete"><i class="fa fa-trash"></i> Delete</button>
                                <a href="<?= base_url('document_history/' . $doc->id) ?>" class="btn btn-xs btn-default" title="History"><i class="fa fa-history"></i> Document History</a>
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
        $('#datatable-documents').DataTable({
            pageLength: 50,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            order: [[0, 'asc']],
        });
    }
});
</script>
