<!-- Company Files - Modern Rillet Style -->
<div class="page-title">
    <div class="title_left">
        <h3>Company Files</h3>
        <?php if (!empty($company)): ?>
        <p style="color:var(--cf-text-secondary); font-size:14px; margin-top:4px;">
            <?= htmlspecialchars($company->company_name) ?>
        </p>
        <?php endif; ?>
    </div>
    <div class="title_right">
        <div class="pull-right" style="display:flex; gap:8px;">
            <a href="<?= base_url('company_list') ?>" class="btn btn-default">
                <i class="fa fa-arrow-left" style="margin-right:4px;"></i> Back
            </a>
            <?php if (!empty($company)): ?>
            <button class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">
                <i class="fa fa-upload" style="margin-right:4px;"></i> Upload File
            </button>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <?php if (!empty($company)): ?>
                <!-- Filter Bar -->
                <div style="display:flex; gap:12px; align-items:center; margin-bottom:16px; flex-wrap:wrap;">
                    <div style="width:250px;">
                        <select id="filter_category" class="form-control select2_single">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat->category_name ?? '') ?>"><?= htmlspecialchars($cat->category_name ?? '') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div style="width:200px;">
                        <input type="text" id="filter_date" class="form-control" placeholder="Filter by date">
                    </div>
                    <div style="flex:1;"></div>
                    <span style="font-size:13px; color:var(--cf-text-secondary);">
                        <i class="fa fa-file-o" style="margin-right:4px;"></i>
                        <?= count($files ?? []) ?> files
                    </span>
                </div>

                <table id="datatable-files" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>S/No</th>
                            <th>File Name</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Uploaded By</th>
                            <th>Upload Date</th>
                            <th>Size</th>
                            <th style="min-width:160px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($files as $f): ?>
                        <tr>
                            <td style="color:var(--cf-text-muted); font-size:12px;"><?= $i++ ?></td>
                            <td>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="width:26px; height:26px; border-radius:6px; background:var(--cf-card-bg); display:flex; align-items:center; justify-content:center; color:var(--cf-accent); font-size:12px; flex-shrink:0;">
                                        <i class="fa fa-file-o"></i>
                                    </span>
                                    <span style="font-weight:500;"><?= htmlspecialchars($f->document_name ?? $f->file_name ?? '') ?></span>
                                </div>
                            </td>
                            <td><span class="status-badge draft"><?= htmlspecialchars($f->category_name ?? '-') ?></span></td>
                            <td style="font-size:12px; max-width:150px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="<?= htmlspecialchars($f->description ?? '') ?>"><?= htmlspecialchars($f->description ?? '-') ?></td>
                            <td style="font-size:12px;"><?= htmlspecialchars($f->uploaded_by_name ?? '-') ?></td>
                            <td style="font-size:12px;"><?= htmlspecialchars($f->created_at ?? '-') ?></td>
                            <td style="font-size:12px; color:var(--cf-text-secondary);"><?= htmlspecialchars($f->file_size ?? '-') ?></td>
                            <td>
                                <div style="display:flex; gap:4px; flex-wrap:wrap;">
                                    <a href="<?= base_url('file_preview/' . ($f->id ?? '')) ?>" class="btn btn-default btn-xs" title="Preview" style="border-radius:6px;">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('companies/download_file/' . ($f->id ?? '')) ?>" class="btn btn-default btn-xs" title="Download" style="border-radius:6px;">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    <a href="<?= base_url('edit_document/' . ($f->id ?? '')) ?>" class="btn btn-default btn-xs" title="Edit" style="border-radius:6px;">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="<?= base_url('document_history/' . ($f->id ?? '')) ?>" class="btn btn-default btn-xs" title="History" style="border-radius:6px;">
                                        <i class="fa fa-history"></i>
                                    </a>
                                    <button class="btn btn-default btn-xs btn-delete-file" data-id="<?= $f->id ?? '' ?>" title="Delete" style="border-radius:6px; color:var(--cf-danger);">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div style="text-align:center; padding:40px 20px;">
                    <div style="width:56px; height:56px; border-radius:14px; background:var(--cf-card-bg); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; color:var(--cf-accent); font-size:24px;">
                        <i class="fa fa-building"></i>
                    </div>
                    <p style="color:var(--cf-text); font-size:15px; font-weight:600; margin-bottom:8px;">Select a Company</p>
                    <p style="color:var(--cf-text-secondary); font-size:13px; margin-bottom:20px;">Choose a company to view and manage its files.</p>
                    <form method="get" style="max-width:400px; margin:0 auto;">
                        <select name="company_id" class="form-control select2_single" onchange="this.form.submit()">
                            <option value="">-- Select Company --</option>
                            <?php foreach ($companies ?? [] as $c): ?>
                            <option value="<?= $c->id ?>"><?= htmlspecialchars($c->company_name) ?> (<?= htmlspecialchars($c->registration_number ?? '') ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:var(--cf-radius); border:1px solid var(--cf-border); overflow:hidden;">
            <div class="modal-header" style="background:var(--cf-primary); border-bottom:none; padding:16px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff; opacity:0.7;">&times;</button>
                <h4 class="modal-title" style="color:#fff; font-size:16px; font-weight:600;">
                    <i class="fa fa-upload" style="margin-right:8px;"></i> Upload File
                </h4>
            </div>
            <form method="post" enctype="multipart/form-data" action="<?= base_url('companies/upload_file/' . ($company->id ?? '')) ?>">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
                <div class="modal-body" style="padding:20px;">
                    <div class="form-group">
                        <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Category</label>
                        <select name="category" class="form-control">
                            <option value="">-- Select --</option>
                            <?php foreach ($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat->id ?? '') ?>"><?= htmlspecialchars($cat->category_name ?? '') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Description</label>
                        <input type="text" name="description" class="form-control" placeholder="File description">
                    </div>
                    <div class="form-group">
                        <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">File</label>
                        <input type="file" name="file" class="form-control" required>
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

<script>
$(function(){
    if ($.fn.DataTable) {
        $('#datatable-files').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy','csv','excel','pdf','print'],
            language: {
                search: '',
                searchPlaceholder: 'Search files...',
                paginate: { previous: '<i class="fa fa-chevron-left"></i>', next: '<i class="fa fa-chevron-right"></i>' }
            }
        });
    }
    if ($.fn.select2) { $('.select2_single').select2(); }

    $('.btn-delete-file').click(function(){
        var id = $(this).data('id');
        if (typeof swal !== 'undefined') {
            swal({
                title: 'Delete this file?',
                text: 'This action cannot be undone.',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                confirmButtonText: 'Yes, delete'
            }, function(confirmed) {
                if (confirmed) {
                    $.post('<?= base_url("companies/delete_file/") ?>'+id, {csrf_token:'<?= $csrf_token ?? '' ?>'}, function(){ location.reload(); });
                }
            });
        } else if(confirm('Delete this file?')){
            $.post('<?= base_url("companies/delete_file/") ?>'+id, {csrf_token:'<?= $csrf_token ?? '' ?>'}, function(){ location.reload(); });
        }
    });
});
</script>
