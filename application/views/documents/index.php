<!-- Document Management - Folder View by Company -->
<div class="page-title">
    <div class="title_left">
        <h3>Document Management</h3>
        <p style="color:var(--cf-text-secondary); font-size:14px; margin-top:4px;">
            <?= $total_docs ?> documents across <?= count($company_folders) ?> companies
        </p>
    </div>
    <div class="title_right">
        <div class="pull-right" style="display:flex; gap:8px;">
            <button class="btn btn-default" id="viewToggleBtn" onclick="toggleDocView()" title="Toggle view">
                <i class="fa fa-th-list" id="viewToggleIcon"></i>
            </button>
            <button class="btn btn-primary" data-toggle="modal" data-target="#uploadModal" style="border-radius:var(--cf-radius-sm);">
                <i class="fa fa-upload" style="margin-right:4px;"></i> Upload
            </button>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!-- ══════ Two-Panel: Folders + Documents ══════ -->
<div class="doc-layout" id="docLayout">

    <!-- Left: Company Folder Tree -->
    <div class="doc-folders" id="docFolders">
        <div class="doc-folders-header">
            <input type="text" class="doc-folder-search" id="folderSearch" placeholder="Search companies..." oninput="filterFolders()">
        </div>
        <div class="doc-folder-list" id="folderList">
            <!-- All Documents -->
            <div class="doc-folder-item active" data-filter="all" onclick="filterByFolder('all', this)">
                <span class="doc-folder-icon"><i class="fa fa-files-o"></i></span>
                <span class="doc-folder-name">All Documents</span>
                <span class="doc-folder-count"><?= $total_docs ?></span>
            </div>

            <!-- Recent -->
            <div class="doc-folder-item" data-filter="recent" onclick="filterByFolder('recent', this)">
                <span class="doc-folder-icon" style="color:#f59e0b;"><i class="fa fa-clock-o"></i></span>
                <span class="doc-folder-name">Recent</span>
                <span class="doc-folder-count"><?= count($recent_docs) ?></span>
            </div>

            <?php if ($general_count > 0): ?>
            <div class="doc-folder-item" data-filter="general" onclick="filterByFolder('general', this)">
                <span class="doc-folder-icon" style="color:#6b7280;"><i class="fa fa-folder-o"></i></span>
                <span class="doc-folder-name">Unlinked / General</span>
                <span class="doc-folder-count"><?= $general_count ?></span>
            </div>
            <?php endif; ?>

            <div class="doc-folder-divider"></div>

            <!-- Company Folders -->
            <?php foreach ($company_folders as $folder): ?>
            <?php if ((int)($folder->doc_count ?? 0) > 0): ?>
            <div class="doc-folder-item company-folder" data-filter="company-<?= $folder->id ?>" data-name="<?= htmlspecialchars(strtolower($folder->company_name)) ?>" onclick="filterByFolder('company-<?= $folder->id ?>', this)">
                <span class="doc-folder-icon"><i class="fa fa-folder"></i></span>
                <span class="doc-folder-name"><?= htmlspecialchars($folder->company_name) ?></span>
                <span class="doc-folder-count"><?= $folder->doc_count ?></span>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>

            <div class="doc-folder-divider"></div>
            <div class="doc-folder-label">Empty folders</div>

            <?php foreach ($company_folders as $folder): ?>
            <?php if ((int)($folder->doc_count ?? 0) === 0): ?>
            <div class="doc-folder-item company-folder empty-folder" data-filter="company-<?= $folder->id ?>" data-name="<?= htmlspecialchars(strtolower($folder->company_name)) ?>" onclick="filterByFolder('company-<?= $folder->id ?>', this)" style="opacity:0.5;">
                <span class="doc-folder-icon"><i class="fa fa-folder-o"></i></span>
                <span class="doc-folder-name"><?= htmlspecialchars($folder->company_name) ?></span>
                <span class="doc-folder-count">0</span>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Right: Documents Table -->
    <div class="doc-main" id="docMain">
        <!-- Breadcrumb -->
        <div class="doc-breadcrumb" id="docBreadcrumb">
            <span class="doc-breadcrumb-icon"><i class="fa fa-files-o"></i></span>
            <span id="breadcrumbText">All Documents</span>
            <span id="breadcrumbCount" class="doc-breadcrumb-count"><?= $total_docs ?> files</span>
        </div>

        <div class="doc-table-wrap">
            <table id="datatable-documents" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th width="4%"><input type="checkbox" id="select_all"></th>
                        <th>File Name</th>
                        <th>Company</th>
                        <th>Type</th>
                        <th>Size</th>
                        <th>Uploaded By</th>
                        <th>Date</th>
                        <th style="min-width:100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($documents)): ?>
                        <?php foreach ($documents as $doc): ?>
                        <tr data-company-id="<?= $doc->entity_id ?? '' ?>" data-entity-type="<?= $doc->entity_type ?? '' ?>">
                            <td><input type="checkbox" class="doc-check" value="<?= $doc->id ?? '' ?>"></td>
                            <td>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="width:28px; height:28px; border-radius:6px; background:var(--cf-card-bg); display:flex; align-items:center; justify-content:center; color:var(--cf-accent); font-size:13px; flex-shrink:0;">
                                        <i class="fa fa-file-<?= $doc->icon ?? 'o' ?>"></i>
                                    </span>
                                    <div>
                                        <span style="font-weight:500; font-size:13px;"><?= htmlspecialchars($doc->name ?? '') ?></span>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:12px;"><?= htmlspecialchars($doc->company ?? '<em style="color:var(--cf-text-muted)">General</em>') ?></td>
                            <td><span class="status-badge draft" style="font-size:10px;"><?= htmlspecialchars($doc->type ?? '') ?></span></td>
                            <td style="font-size:12px; color:var(--cf-text-secondary);"><?= htmlspecialchars($doc->size ?? '') ?></td>
                            <td style="font-size:12px;"><?= htmlspecialchars($doc->uploaded_by ?? '') ?></td>
                            <td style="font-size:12px;"><?= isset($doc->created_at) ? date('d/m/Y', strtotime($doc->created_at)) : '' ?></td>
                            <td>
                                <div style="display:flex; gap:4px;">
                                    <a href="<?= base_url('documents/download/' . ($doc->id ?? '')) ?>" class="btn btn-default btn-xs" title="Download" style="border-radius:6px;"><i class="fa fa-download"></i></a>
                                    <a href="<?= base_url('file_preview/' . ($doc->id ?? '')) ?>" class="btn btn-default btn-xs" title="Preview" style="border-radius:6px;"><i class="fa fa-eye"></i></a>
                                    <a href="<?= base_url('edit_document/' . ($doc->id ?? '')) ?>" class="btn btn-default btn-xs" title="Edit" style="border-radius:6px;"><i class="fa fa-pencil"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center" style="padding:50px 20px !important;">
                                <div>
                                    <div style="width:56px; height:56px; border-radius:14px; background:var(--cf-card-bg); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; color:var(--cf-text-muted); font-size:24px;"><i class="fa fa-folder-open-o"></i></div>
                                    <p style="color:var(--cf-text-secondary); font-size:14px; margin:0;">No documents found.</p>
                                    <p style="color:var(--cf-text-muted); font-size:12px; margin-top:4px;">Click "Upload" to add documents.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
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
                        <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Company</label>
                        <select name="company_id" class="form-control select2_single" id="uploadCompanySelect">
                            <option value="">-- General (no company) --</option>
                            <?php foreach ($company_folders as $f): ?>
                            <option value="<?= $f->id ?>"><?= htmlspecialchars($f->company_name) ?></option>
                            <?php endforeach; ?>
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
                            <option value="ACRA">ACRA</option>
                            <option value="Tax">Tax</option>
                            <option value="Report">Report</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Description</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Optional description"></textarea>
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

<!-- ══════ STYLES ══════ -->
<style>
.doc-layout {
    display: flex;
    gap: 0;
    height: calc(100vh - var(--cf-topbar-h) - 130px);
    background: var(--cf-white);
    border: 1px solid var(--cf-border);
    border-radius: var(--cf-radius);
    overflow: hidden;
}

/* Left: Folder panel */
.doc-folders {
    width: 280px;
    border-right: 1px solid var(--cf-border);
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
    background: var(--cf-bg);
    transition: width 0.25s;
}
.doc-folders.collapsed {
    width: 0;
    overflow: hidden;
    border-right: none;
}
.doc-folders-header {
    padding: 12px;
    border-bottom: 1px solid var(--cf-border);
    flex-shrink: 0;
}
.doc-folder-search {
    width: 100%;
    border: 1px solid var(--cf-border);
    border-radius: 6px;
    padding: 7px 10px;
    font-size: 12px;
    outline: none;
    font-family: var(--cf-font) !important;
}
.doc-folder-search:focus {
    border-color: var(--cf-accent);
    box-shadow: 0 0 0 2px rgba(79,134,198,0.1);
}
.doc-folder-list {
    flex: 1;
    overflow-y: auto;
    padding: 6px;
}
.doc-folder-item {
    padding: 8px 10px;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--cf-text);
    transition: background 0.12s;
    margin-bottom: 1px;
}
.doc-folder-item:hover { background: var(--cf-white); }
.doc-folder-item.active {
    background: var(--cf-white);
    box-shadow: var(--cf-shadow-sm);
    font-weight: 600;
}
.doc-folder-icon {
    width: 20px;
    text-align: center;
    color: var(--cf-accent);
    font-size: 13px;
    flex-shrink: 0;
}
.doc-folder-name {
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    min-width: 0;
}
.doc-folder-count {
    font-size: 11px;
    color: var(--cf-text-muted);
    flex-shrink: 0;
    background: var(--cf-card-bg);
    padding: 1px 6px;
    border-radius: 10px;
    min-width: 20px;
    text-align: center;
}
.doc-folder-divider {
    height: 1px;
    background: var(--cf-border);
    margin: 6px 8px;
}
.doc-folder-label {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--cf-text-muted);
    padding: 4px 10px;
    font-weight: 600;
}

/* Right: Main panel */
.doc-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-width: 0;
    overflow: hidden;
}
.doc-breadcrumb {
    padding: 10px 16px;
    border-bottom: 1px solid var(--cf-border);
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
    font-size: 14px;
    font-weight: 600;
    color: var(--cf-text);
}
.doc-breadcrumb-icon {
    color: var(--cf-accent);
}
.doc-breadcrumb-count {
    font-size: 11px;
    font-weight: 400;
    color: var(--cf-text-muted);
    margin-left: auto;
}
.doc-table-wrap {
    flex: 1;
    overflow-y: auto;
    padding: 0;
}
.doc-table-wrap .table {
    margin-bottom: 0;
}
.doc-table-wrap .table thead th {
    position: sticky;
    top: 0;
    background: var(--cf-bg);
    z-index: 2;
    border-bottom: 2px solid var(--cf-border);
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    color: var(--cf-text-secondary);
    padding: 10px 12px;
}
.doc-table-wrap .table tbody td {
    padding: 8px 12px;
    vertical-align: middle;
}
.doc-table-wrap .table tbody tr.doc-hidden { display: none; }

@media (max-width: 992px) {
    .doc-folders { width: 220px; }
}
@media (max-width: 768px) {
    .doc-layout { flex-direction: column; height: auto; }
    .doc-folders { width: 100% !important; max-height: 200px; border-right: none; border-bottom: 1px solid var(--cf-border); }
    .doc-table-wrap { overflow-x: auto; }
}
</style>

<!-- ══════ JAVASCRIPT ══════ -->
<script>
$(document).ready(function() {
    /* DataTable init (if available) - no default search, we handle filtering */
    var dt = null;
    if ($.fn.DataTable) {
        dt = $('#datatable-documents').DataTable({
            pageLength: 50,
            lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "All"]],
            order: [[6, 'desc']],
            dom: 'lrtip', /* hide default search - we use folder filter */
            language: {
                info: '_START_-_END_ of _TOTAL_',
                paginate: { previous: '<i class="fa fa-chevron-left"></i>', next: '<i class="fa fa-chevron-right"></i>' }
            }
        });
    }
    if ($.fn.select2) { $('.select2_single').select2(); }

    $('#select_all').change(function() {
        $('.doc-check').prop('checked', $(this).is(':checked'));
    });

    /* ── Folder filtering ── */
    window.filterByFolder = function(filter, el) {
        /* Highlight active folder */
        $('.doc-folder-item').removeClass('active');
        $(el).addClass('active');

        /* Update breadcrumb */
        var name = $(el).find('.doc-folder-name').text().trim();
        var count = $(el).find('.doc-folder-count').text().trim();
        $('#breadcrumbText').text(name);
        $('#breadcrumbCount').text(count + ' files');
        var iconClass = $(el).find('.doc-folder-icon i').attr('class');
        $('.doc-breadcrumb-icon i').attr('class', iconClass);

        /* Filter table rows */
        if (dt) {
            dt.rows().every(function() {
                var row = this.node();
                var companyId = $(row).data('company-id');
                var entityType = $(row).data('entity-type');
                var show = false;

                if (filter === 'all') {
                    show = true;
                } else if (filter === 'recent') {
                    /* Show last 10 rows by date */
                    show = true; /* Will limit via index */
                } else if (filter === 'general') {
                    show = !companyId || entityType !== 'company';
                } else if (filter.startsWith('company-')) {
                    var fid = filter.replace('company-', '');
                    show = (String(companyId) === String(fid));
                }

                if (show) {
                    $(row).removeClass('doc-hidden');
                } else {
                    $(row).addClass('doc-hidden');
                }
            });
            /* For "recent", only show first 10 visible */
            if (filter === 'recent') {
                var visCount = 0;
                dt.rows().every(function() {
                    visCount++;
                    if (visCount > 10) $(this.node()).addClass('doc-hidden');
                });
            }
            dt.draw();
        }

        /* Pre-select company in upload modal */
        if (filter.startsWith('company-')) {
            var cid = filter.replace('company-', '');
            $('#uploadCompanySelect').val(cid).trigger('change');
        }
    };

    /* ── Search folders ── */
    window.filterFolders = function() {
        var q = $('#folderSearch').val().toLowerCase().trim();
        $('.company-folder').each(function() {
            var name = $(this).data('name') || '';
            $(this).toggle(q === '' || name.indexOf(q) !== -1);
        });
    };

    /* ── Toggle folder panel (view toggle) ── */
    window.toggleDocView = function() {
        var folders = $('#docFolders');
        folders.toggleClass('collapsed');
        var icon = $('#viewToggleIcon');
        if (folders.hasClass('collapsed')) {
            icon.attr('class', 'fa fa-columns');
        } else {
            icon.attr('class', 'fa fa-th-list');
        }
    };

    /* DataTable custom filtering to respect .doc-hidden */
    if (dt) {
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var row = dt.row(dataIndex).node();
            return !$(row).hasClass('doc-hidden');
        });
    }
});
</script>
