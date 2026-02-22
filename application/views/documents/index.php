<!-- Document Management -->
<div class="page-title">
    <div class="title_left">
        <h3>Document Management</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <button class="btn btn-success" data-toggle="modal" data-target="#uploadModal"><i class="fa fa-upload"></i> Upload Document</button>
            <button class="btn btn-primary" data-toggle="modal" data-target="#folderModal"><i class="fa fa-folder-open"></i> New Folder</button>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-folder-open-o"></i> File Manager</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li><a href="<?= base_url('documents') ?>"><i class="fa fa-home"></i> Root</a></li>
                </ol>

                <table id="datatable-documents" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th width="5%"><input type="checkbox" id="select_all"></th>
                            <th>File Name</th>
                            <th>Company</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Uploaded By</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($documents)): ?>
                            <?php foreach ($documents as $doc): ?>
                            <tr>
                                <td><input type="checkbox" class="doc-check" value="<?= $doc->id ?? '' ?>"></td>
                                <td>
                                    <i class="fa fa-file-<?= $doc->icon ?? 'o' ?>" style="margin-right:5px;color:#206570;"></i>
                                    <?= htmlspecialchars($doc->name ?? '') ?>
                                </td>
                                <td><?= htmlspecialchars($doc->company ?? '') ?></td>
                                <td><?= htmlspecialchars($doc->type ?? '') ?></td>
                                <td><?= htmlspecialchars($doc->size ?? '') ?></td>
                                <td><?= htmlspecialchars($doc->uploaded_by ?? '') ?></td>
                                <td><?= isset($doc->created_at) ? date('d/m/Y', strtotime($doc->created_at)) : '' ?></td>
                                <td>
                                    <a href="<?= base_url('documents/download/' . ($doc->id ?? '')) ?>" class="btn btn-primary btn-xs"><i class="fa fa-download"></i></a>
                                    <a href="<?= base_url('documents/view/' . ($doc->id ?? '')) ?>" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a>
                                    <button class="btn btn-danger btn-xs delete-item" data-id="<?= $doc->id ?? '' ?>"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    <div style="padding:30px;">
                                        <i class="fa fa-folder-open-o fa-3x" style="color:#ccc;"></i>
                                        <p style="margin-top:15px;">No documents uploaded yet. Click "Upload Document" to get started.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#206570;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;"><span>&times;</span></button>
                <h4 class="modal-title" style="color:#fff;"><i class="fa fa-upload"></i> Upload Document</h4>
            </div>
            <form method="POST" action="<?= base_url('documents/upload') ?>" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Select File(s)</label>
                        <input type="file" name="documents[]" class="form-control" multiple required>
                    </div>
                    <div class="form-group">
                        <label>Company (Optional)</label>
                        <select name="company_id" class="form-control select2_single">
                            <option value="">Select Company</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Document Type</label>
                        <select name="document_type" class="form-control">
                            <option value="General">General</option>
                            <option value="Resolution">Resolution</option>
                            <option value="Certificate">Certificate</option>
                            <option value="Agreement">Agreement</option>
                            <option value="Form">Form</option>
                            <option value="Report">Report</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
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

<!-- New Folder Modal -->
<div class="modal fade" id="folderModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#206570;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;"><span>&times;</span></button>
                <h4 class="modal-title" style="color:#fff;"><i class="fa fa-folder-open"></i> New Folder</h4>
            </div>
            <form method="POST" action="<?= base_url('documents/create_folder') ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Folder Name</label>
                        <input type="text" name="folder_name" class="form-control" placeholder="Enter folder name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-folder-open"></i> Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#datatable-documents').DataTable({
            pageLength: 20,
            lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
            order: [[6, 'desc']],
        });
    }
    if ($.fn.select2) { $('.select2_single').select2(); }

    $('#select_all').change(function() {
        $('.doc-check').prop('checked', $(this).is(':checked'));
    });
});
</script>
