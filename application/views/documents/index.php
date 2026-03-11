<!-- Document Management - Modern Rillet Style -->
<div class="page-title">
    <div class="title_left">
        <h3>Document Management</h3>
        <p style="color:var(--cf-text-secondary); font-size:14px; margin-top:4px;">
            Upload, organize, and manage company documents
        </p>
    </div>
    <div class="title_right">
        <div class="pull-right" style="display:flex; gap:8px;">
            <button class="btn btn-default" data-toggle="modal" data-target="#folderModal">
                <i class="fa fa-folder-open" style="margin-right:4px; color:var(--cf-accent);"></i> New Folder
            </button>
            <button class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">
                <i class="fa fa-upload" style="margin-right:4px;"></i> Upload Document
            </button>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <!-- Breadcrumb -->
                <nav style="margin-bottom:16px;">
                    <ol style="display:flex; gap:8px; list-style:none; padding:0; margin:0; font-size:13px; align-items:center;">
                        <li>
                            <a href="<?= base_url('documents') ?>" style="color:var(--cf-accent); text-decoration:none; font-weight:500;">
                                <i class="fa fa-home" style="margin-right:4px;"></i> Root
                            </a>
                        </li>
                    </ol>
                </nav>

                <table id="datatable-documents" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th width="5%"><input type="checkbox" id="select_all"></th>
                            <th>File Name</th>
                            <th>Company</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Uploaded By</th>
                            <th>Date</th>
                            <th style="min-width:120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($documents)): ?>
                            <?php foreach ($documents as $doc): ?>
                            <tr>
                                <td><input type="checkbox" class="doc-check" value="<?= $doc->id ?? '' ?>"></td>
                                <td>
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <span style="width:28px; height:28px; border-radius:6px; background:var(--cf-card-bg); display:flex; align-items:center; justify-content:center; color:var(--cf-accent); font-size:13px; flex-shrink:0;">
                                            <i class="fa fa-file-<?= $doc->icon ?? 'o' ?>"></i>
                                        </span>
                                        <span style="font-weight:500;"><?= htmlspecialchars($doc->name ?? '') ?></span>
                                    </div>
                                </td>
                                <td style="font-size:12px;"><?= htmlspecialchars($doc->company ?? '') ?></td>
                                <td>
                                    <span class="status-badge draft"><?= htmlspecialchars($doc->type ?? '') ?></span>
                                </td>
                                <td style="font-size:12px; color:var(--cf-text-secondary);"><?= htmlspecialchars($doc->size ?? '') ?></td>
                                <td style="font-size:12px;"><?= htmlspecialchars($doc->uploaded_by ?? '') ?></td>
                                <td style="font-size:12px;"><?= isset($doc->created_at) ? date('d/m/Y', strtotime($doc->created_at)) : '' ?></td>
                                <td>
                                    <div style="display:flex; gap:4px;">
                                        <a href="<?= base_url('documents/download/' . ($doc->id ?? '')) ?>" class="btn btn-default btn-xs" title="Download" style="border-radius:6px;">
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <a href="<?= base_url('documents/view/' . ($doc->id ?? '')) ?>" class="btn btn-default btn-xs" title="View" style="border-radius:6px;">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <button class="btn btn-default btn-xs delete-item" data-id="<?= $doc->id ?? '' ?>" title="Delete" style="border-radius:6px; color:var(--cf-danger);">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center" style="padding:50px 20px !important;">
                                    <div>
                                        <div style="width:56px; height:56px; border-radius:14px; background:var(--cf-card-bg); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; color:var(--cf-text-muted); font-size:24px;">
                                            <i class="fa fa-folder-open-o"></i>
                                        </div>
                                        <p style="color:var(--cf-text-secondary); font-size:14px; margin:0;">No documents uploaded yet.</p>
                                        <p style="color:var(--cf-text-muted); font-size:12px; margin-top:4px;">Click "Upload Document" to get started.</p>
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
        <div class="modal-content" style="border-radius:var(--cf-radius); border:1px solid var(--cf-border); overflow:hidden;">
            <div class="modal-header" style="background:var(--cf-primary); border-bottom:none; padding:16px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff; opacity:0.7;"><span>&times;</span></button>
                <h4 class="modal-title" style="color:#fff; font-size:16px; font-weight:600;"><i class="fa fa-upload" style="margin-right:8px;"></i> Upload Document</h4>
            </div>
            <form method="POST" action="<?= base_url('documents/upload') ?>" enctype="multipart/form-data">
                <div class="modal-body" style="padding:20px;">
                    <div class="form-group">
                        <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Select File(s)</label>
                        <input type="file" name="documents[]" class="form-control" multiple required>
                    </div>
                    <div class="form-group">
                        <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Company (Optional)</label>
                        <select name="company_id" class="form-control select2_single">
                            <option value="">Select Company</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Document Type</label>
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
                        <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Description</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Optional file description"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid var(--cf-border); padding:14px 20px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-upload" style="margin-right:4px;"></i> Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- New Folder Modal -->
<div class="modal fade" id="folderModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="border-radius:var(--cf-radius); border:1px solid var(--cf-border); overflow:hidden;">
            <div class="modal-header" style="background:var(--cf-primary); border-bottom:none; padding:16px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff; opacity:0.7;"><span>&times;</span></button>
                <h4 class="modal-title" style="color:#fff; font-size:16px; font-weight:600;"><i class="fa fa-folder-open" style="margin-right:8px;"></i> New Folder</h4>
            </div>
            <form method="POST" action="<?= base_url('documents/create_folder') ?>">
                <div class="modal-body" style="padding:20px;">
                    <div class="form-group">
                        <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Folder Name</label>
                        <input type="text" name="folder_name" class="form-control" placeholder="Enter folder name" required>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid var(--cf-border); padding:14px 20px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-folder-open" style="margin-right:4px;"></i> Create</button>
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
            language: {
                search: '',
                searchPlaceholder: 'Search documents...',
                info: 'Showing _START_ to _END_ of _TOTAL_ documents',
                paginate: { previous: '<i class="fa fa-chevron-left"></i>', next: '<i class="fa fa-chevron-right"></i>' }
            }
        });
    }
    if ($.fn.select2) { $('.select2_single').select2(); }

    $('#select_all').change(function() {
        $('.doc-check').prop('checked', $(this).is(':checked'));
    });
});
</script>
