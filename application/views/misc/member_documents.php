<!-- Member Documents List -->
<div class="page-title">
    <div class="title_left">
        <h3>Documents - <?= htmlspecialchars($member->name ?? '') ?></h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <button class="btn btn-success" data-toggle="modal" data-target="#uploadDocModal"><i class="fa fa-upload"></i> Upload Document</button>
            <a href="<?= base_url('member') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Members</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-member-docs" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Document Name</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Uploaded Date</th>
                            <th>Uploaded By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($documents)): ?>
                            <?php $sno = 1; foreach ($documents as $doc): ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><i class="fa fa-file-o"></i> <?= htmlspecialchars($doc->document_name ?? $doc->file_name ?? '') ?></td>
                                <td><?= htmlspecialchars($doc->document_type ?? $doc->file_type ?? '') ?></td>
                                <td><?= htmlspecialchars($doc->file_size ?? '') ?></td>
                                <td><?= !empty($doc->created_at) ? date('d/m/Y H:i', strtotime($doc->created_at)) : '' ?></td>
                                <td><?= htmlspecialchars($doc->uploaded_by_name ?? '') ?></td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-xs" title="Download"><i class="fa fa-download"></i></a>
                                    <a href="#" class="btn btn-info btn-xs" title="View" target="_blank"><i class="fa fa-eye"></i></a>
                                    <button class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-center text-muted">No documents found for this member.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Upload Document Modal -->
<div class="modal fade" id="uploadDocModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#206570;color:#fff;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;"><span>&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-upload"></i> Upload Document</h4>
            </div>
            <form method="POST" action="<?= base_url('member_documents/' . ($member_id ?? '')) ?>" enctype="multipart/form-data">
                <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Document Name <span class="required">*</span></label>
                        <input type="text" name="document_name" class="form-control" placeholder="Document Name" required>
                    </div>
                    <div class="form-group">
                        <label>Document Type</label>
                        <select name="document_type" class="form-control">
                            <option value="NRIC">NRIC</option>
                            <option value="Passport">Passport</option>
                            <option value="FIN">FIN</option>
                            <option value="Proof of Address">Proof of Address</option>
                            <option value="Authorization Letter">Authorization Letter</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>File <span class="required">*</span></label>
                        <input type="file" name="document_file" class="form-control" required>
                        <small class="text-muted">Max file size: 10MB. Supported: PDF, JPG, PNG, DOC, DOCX</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) { $('#datatable-member-docs').DataTable({ pageLength: 10, order: [[4, 'desc']] }); }
});
</script>
