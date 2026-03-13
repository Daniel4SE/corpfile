<!-- Document Management - Folder View by Company -->
<div class="page-title">
    <div class="title_left">
        <h3>Document Management</h3>
        <p style="color:var(--cf-text-secondary); font-size:14px; margin-top:4px;">
            <?= $total_docs ?> documents across <?= count($company_folders) ?> companies
        </p>
    </div>
    <div class="title_right">
        <div class="pull-right" style="display:flex; gap:8px; align-items:center;">
            <!-- View toggle: list / grid -->
            <div class="btn-group" id="viewToggleGroup">
                <button class="btn btn-default active" id="btnListView" onclick="setDocView('list')" title="List view" style="border-radius:var(--cf-radius-sm) 0 0 var(--cf-radius-sm);">
                    <i class="fa fa-th-list"></i>
                </button>
                <button class="btn btn-default" id="btnGridView" onclick="setDocView('grid')" title="Grid view" style="border-radius:0 var(--cf-radius-sm) var(--cf-radius-sm) 0;">
                    <i class="fa fa-th-large"></i>
                </button>
            </div>
            <button class="btn btn-primary" data-toggle="modal" data-target="#uploadModal" style="border-radius:var(--cf-radius-sm);">
                <i class="fa fa-upload" style="margin-right:4px;"></i> Upload
            </button>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!-- ══════ Bulk Action Bar (hidden by default) ══════ -->
<div class="doc-bulk-bar" id="bulkBar" style="display:none;">
    <div class="doc-bulk-inner">
        <span class="doc-bulk-count"><span id="bulkCount">0</span> selected</span>
        <button class="btn btn-sm btn-default" onclick="bulkDownload()" title="Download selected">
            <i class="fa fa-download"></i> Download
        </button>
        <button class="btn btn-sm btn-danger" onclick="bulkDelete()" title="Delete selected">
            <i class="fa fa-trash-o"></i> Delete
        </button>
        <button class="btn btn-sm btn-default" onclick="clearSelection()" title="Clear selection">
            <i class="fa fa-times"></i> Clear
        </button>
    </div>
</div>

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

    <!-- Right: Documents Panel -->
    <div class="doc-main" id="docMain">
        <!-- Breadcrumb -->
        <div class="doc-breadcrumb" id="docBreadcrumb">
            <span class="doc-breadcrumb-icon"><i class="fa fa-files-o"></i></span>
            <span id="breadcrumbText">All Documents</span>
            <span id="breadcrumbCount" class="doc-breadcrumb-count"><?= $total_docs ?> files</span>
        </div>

        <!-- ── LIST VIEW ── -->
        <div class="doc-table-wrap" id="docListView">
            <table id="datatable-documents" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th width="4%"><input type="checkbox" id="select_all" title="Select all"></th>
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
                        <tr data-company-id="<?= $doc->entity_id ?? '' ?>" data-entity-type="<?= $doc->entity_type ?? '' ?>" data-doc-id="<?= $doc->id ?? '' ?>">
                            <td><input type="checkbox" class="doc-check" value="<?= $doc->id ?? '' ?>"></td>
                            <td>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span class="doc-file-icon doc-ext-<?= strtolower(pathinfo($doc->name ?? '', PATHINFO_EXTENSION)) ?>">
                                        <i class="fa fa-file-<?= $doc->icon ?? 'o' ?>"></i>
                                    </span>
                                    <div>
                                        <span style="font-weight:500; font-size:13px;"><?= htmlspecialchars($doc->name ?? '') ?></span>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:12px;"><?= htmlspecialchars($doc->company ?? '') ?: '<em style="color:var(--cf-text-muted)">General</em>' ?></td>
                            <td><span class="status-badge draft" style="font-size:10px;"><?= htmlspecialchars($doc->type ?? '') ?></span></td>
                            <td style="font-size:12px; color:var(--cf-text-secondary);"><?= htmlspecialchars($doc->size ?? '') ?></td>
                            <td style="font-size:12px;"><?= htmlspecialchars($doc->uploaded_by ?? '') ?></td>
                            <td style="font-size:12px;"><?= isset($doc->created_at) ? date('d/m/Y', strtotime($doc->created_at)) : '' ?></td>
                            <td>
                                <div style="display:flex; gap:4px;">
                                    <a href="<?= base_url('documents/download/' . ($doc->id ?? '')) ?>" class="btn btn-default btn-xs" title="Download" style="border-radius:6px;"><i class="fa fa-download"></i></a>
                                    <a href="<?= base_url('file_preview/' . ($doc->id ?? '')) ?>" class="btn btn-default btn-xs" title="Preview" style="border-radius:6px;"><i class="fa fa-eye"></i></a>
                                    <a href="<?= base_url('edit_document/' . ($doc->id ?? '')) ?>" class="btn btn-default btn-xs" title="Edit" style="border-radius:6px;"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-default btn-xs btn-doc-delete" data-id="<?= $doc->id ?? '' ?>" title="Delete" style="border-radius:6px; color:var(--cf-danger);"><i class="fa fa-trash-o"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="doc-empty-row">
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

        <!-- ── GRID VIEW ── -->
        <div class="doc-grid-wrap" id="docGridView" style="display:none;">
            <div class="doc-grid" id="docGrid">
                <?php if (!empty($documents)): ?>
                    <?php foreach ($documents as $doc):
                        $ext = strtolower(pathinfo($doc->name ?? '', PATHINFO_EXTENSION));
                        $colorMap = ['pdf'=>'#e74c3c','doc'=>'#2b579a','docx'=>'#2b579a','xls'=>'#217346','xlsx'=>'#217346','jpg'=>'#f59e0b','jpeg'=>'#f59e0b','png'=>'#f59e0b','gif'=>'#f59e0b','txt'=>'#6b7280','csv'=>'#217346','zip'=>'#8b5cf6','rar'=>'#8b5cf6'];
                        $extColor = $colorMap[$ext] ?? 'var(--cf-accent)';
                    ?>
                    <div class="doc-grid-card" data-company-id="<?= $doc->entity_id ?? '' ?>" data-entity-type="<?= $doc->entity_type ?? '' ?>" data-doc-id="<?= $doc->id ?? '' ?>">
                        <div class="doc-grid-card-check">
                            <input type="checkbox" class="doc-grid-check" value="<?= $doc->id ?? '' ?>">
                        </div>
                        <div class="doc-grid-card-icon" style="color:<?= $extColor ?>;">
                            <i class="fa fa-file-<?= $doc->icon ?? 'o' ?> fa-2x"></i>
                        </div>
                        <div class="doc-grid-card-name" title="<?= htmlspecialchars($doc->name ?? '') ?>"><?= htmlspecialchars($doc->name ?? '') ?></div>
                        <div class="doc-grid-card-meta">
                            <?= htmlspecialchars($doc->size ?? '') ?> &middot; <?= strtoupper($ext ?: '?') ?>
                        </div>
                        <div class="doc-grid-card-company"><?= htmlspecialchars($doc->company ?? 'General') ?></div>
                        <div class="doc-grid-card-actions">
                            <a href="<?= base_url('documents/download/' . ($doc->id ?? '')) ?>" class="btn btn-default btn-xs" title="Download"><i class="fa fa-download"></i></a>
                            <a href="<?= base_url('file_preview/' . ($doc->id ?? '')) ?>" class="btn btn-default btn-xs" title="Preview"><i class="fa fa-eye"></i></a>
                            <button class="btn btn-default btn-xs btn-doc-delete" data-id="<?= $doc->id ?? '' ?>" title="Delete" style="color:var(--cf-danger);"><i class="fa fa-trash-o"></i></button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
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
            <form method="POST" action="<?= base_url('documents/upload') ?>" enctype="multipart/form-data" id="uploadForm">
                <div class="modal-body" style="padding:20px;">
                    <!-- Drag & Drop Zone -->
                    <div class="doc-upload-zone" id="uploadZone">
                        <i class="fa fa-cloud-upload" style="font-size:32px; color:var(--cf-accent); margin-bottom:8px;"></i>
                        <p style="margin:0; font-size:14px; font-weight:500;">Drag files here or click to browse</p>
                        <p style="margin:4px 0 0; font-size:12px; color:var(--cf-text-muted);">PDF, DOC, XLS, Images, ZIP — max 50MB each</p>
                        <input type="file" name="documents[]" id="fileInput" multiple required style="display:none;">
                    </div>
                    <!-- Selected files list -->
                    <div id="selectedFilesList" style="display:none; margin-top:12px;">
                        <label style="font-size:11px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Selected Files</label>
                        <div id="fileListItems"></div>
                    </div>

                    <div class="form-group" style="margin-top:16px;">
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
                    <button type="submit" class="btn btn-primary" id="uploadSubmitBtn"><i class="fa fa-upload" style="margin-right:4px;"></i> Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirm Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="border-radius:var(--cf-radius); overflow:hidden;">
            <div class="modal-header" style="background:#dc3545; border-bottom:none; padding:14px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff; opacity:0.7;"><span>&times;</span></button>
                <h4 class="modal-title" style="color:#fff; font-size:15px; font-weight:600;"><i class="fa fa-exclamation-triangle" style="margin-right:6px;"></i> Delete Document</h4>
            </div>
            <div class="modal-body" style="padding:20px;">
                <p style="margin:0; font-size:14px;" id="deleteConfirmText">Are you sure you want to delete this document? This action cannot be undone.</p>
            </div>
            <div class="modal-footer" style="border-top:1px solid var(--cf-border); padding:12px 20px;">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteBtn"><i class="fa fa-trash-o"></i> Delete</button>
            </div>
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

/* Bulk action bar */
.doc-bulk-bar {
    background: var(--cf-primary);
    color: #fff;
    border-radius: var(--cf-radius-sm);
    margin-bottom: 10px;
    padding: 8px 16px;
    animation: slideDown 0.2s ease;
}
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-8px); }
    to { opacity: 1; transform: translateY(0); }
}
.doc-bulk-inner {
    display: flex;
    align-items: center;
    gap: 10px;
}
.doc-bulk-count {
    font-size: 13px;
    font-weight: 600;
    margin-right: auto;
}
.doc-bulk-bar .btn { border-color: rgba(255,255,255,0.3); color: #fff; }
.doc-bulk-bar .btn:hover { background: rgba(255,255,255,0.15); }
.doc-bulk-bar .btn-danger { background: #dc3545; border-color: #dc3545; }
.doc-bulk-bar .btn-danger:hover { background: #c82333; }

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

/* File icon colors */
.doc-file-icon {
    width: 28px; height: 28px; border-radius: 6px;
    background: var(--cf-card-bg); display: flex; align-items: center; justify-content: center;
    color: var(--cf-accent); font-size: 13px; flex-shrink: 0;
}
.doc-ext-pdf .fa { color: #e74c3c; }
.doc-ext-doc .fa, .doc-ext-docx .fa { color: #2b579a; }
.doc-ext-xls .fa, .doc-ext-xlsx .fa, .doc-ext-csv .fa { color: #217346; }
.doc-ext-jpg .fa, .doc-ext-jpeg .fa, .doc-ext-png .fa, .doc-ext-gif .fa { color: #f59e0b; }
.doc-ext-zip .fa, .doc-ext-rar .fa { color: #8b5cf6; }

/* Row hover highlight for checkbox */
.doc-table-wrap .table tbody tr:hover { background: rgba(79,134,198,0.04); }
.doc-table-wrap .table tbody tr.selected { background: rgba(79,134,198,0.08); }

/* Delete button styling */
.btn-doc-delete { border: none; background: none; padding: 3px 6px; }
.btn-doc-delete:hover { background: rgba(220,53,69,0.1); border-radius: 6px; }

/* ══════ GRID VIEW ══════ */
.doc-grid-wrap {
    flex: 1;
    overflow-y: auto;
    padding: 16px;
}
.doc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 12px;
}
.doc-grid-card {
    border: 1px solid var(--cf-border);
    border-radius: var(--cf-radius);
    padding: 16px 12px 10px;
    text-align: center;
    position: relative;
    transition: box-shadow 0.15s, border-color 0.15s;
    background: var(--cf-white);
    cursor: default;
}
.doc-grid-card:hover {
    box-shadow: var(--cf-shadow);
    border-color: var(--cf-accent);
}
.doc-grid-card.selected {
    border-color: var(--cf-accent);
    background: rgba(79,134,198,0.04);
}
.doc-grid-card-check {
    position: absolute;
    top: 8px;
    left: 8px;
    opacity: 0;
    transition: opacity 0.15s;
}
.doc-grid-card:hover .doc-grid-card-check,
.doc-grid-card.selected .doc-grid-card-check { opacity: 1; }
.doc-grid-card-icon {
    margin-bottom: 10px;
}
.doc-grid-card-name {
    font-size: 12px;
    font-weight: 600;
    color: var(--cf-text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 4px;
}
.doc-grid-card-meta {
    font-size: 10px;
    color: var(--cf-text-muted);
    margin-bottom: 2px;
}
.doc-grid-card-company {
    font-size: 10px;
    color: var(--cf-text-secondary);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 8px;
}
.doc-grid-card-actions {
    display: flex;
    justify-content: center;
    gap: 4px;
    opacity: 0;
    transition: opacity 0.15s;
}
.doc-grid-card:hover .doc-grid-card-actions { opacity: 1; }
.doc-grid-card-actions .btn { border-radius: 4px; font-size: 11px; }

/* Upload drop zone */
.doc-upload-zone {
    border: 2px dashed var(--cf-border);
    border-radius: var(--cf-radius);
    padding: 30px 20px;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
}
.doc-upload-zone:hover, .doc-upload-zone.dragover {
    border-color: var(--cf-accent);
    background: rgba(79,134,198,0.04);
}
.doc-file-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    background: var(--cf-card-bg);
    border-radius: 4px;
    font-size: 12px;
    margin: 3px 2px;
}
.doc-file-tag .fa-times {
    cursor: pointer;
    color: var(--cf-text-muted);
}
.doc-file-tag .fa-times:hover { color: var(--cf-danger); }

/* View toggle active */
#viewToggleGroup .btn.active {
    background: var(--cf-primary);
    color: #fff;
    border-color: var(--cf-primary);
}

@media (max-width: 992px) {
    .doc-folders { width: 220px; }
}
@media (max-width: 768px) {
    .doc-layout { flex-direction: column; height: auto; }
    .doc-folders { width: 100% !important; max-height: 200px; border-right: none; border-bottom: 1px solid var(--cf-border); }
    .doc-table-wrap { overflow-x: auto; }
    .doc-grid { grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); }
}
</style>

<!-- ══════ JAVASCRIPT ══════ -->
<script>
$(document).ready(function() {
    /* ── State ── */
    var currentFilter = 'all';
    var currentView = localStorage.getItem('docView') || 'list';
    var deleteTargetIds = [];

    /* ── DataTable init ── */
    var dt = null;
    if ($.fn.DataTable) {
        /* Register custom filter BEFORE creating the DataTable */
        $.fn.dataTable.ext.search.push(function(settings, searchData, dataIndex) {
            if (settings.nTable.id !== 'datatable-documents') return true;
            var row = dt ? dt.row(dataIndex).node() : null;
            if (!row) return true;
            var companyId = String($(row).data('company-id') || '');
            var entityType = String($(row).data('entity-type') || '');

            if (currentFilter === 'all') return true;
            if (currentFilter === 'general') return !companyId || companyId === '' || entityType !== 'company';
            if (currentFilter === 'recent') return true; /* show all — recent is pre-sorted */
            if (currentFilter.indexOf('company-') === 0) {
                var fid = currentFilter.replace('company-', '');
                return companyId === fid;
            }
            return true;
        });

        dt = $('#datatable-documents').DataTable({
            pageLength: -1,
            lengthChange: false,
            order: [[6, 'desc']],
            dom: 'rtip',
            language: {
                info: '_TOTAL_ files',
                infoFiltered: '(filtered from _MAX_)',
                infoEmpty: '0 files',
                emptyTable: 'No documents in this folder',
                paginate: { previous: '<i class="fa fa-chevron-left"></i>', next: '<i class="fa fa-chevron-right"></i>' }
            }
        });
    }
    if ($.fn.select2) { $('.select2_single').select2(); }

    /* ══════════════════════════════════════════════
       SELECT ALL + BULK ACTIONS
       ══════════════════════════════════════════════ */

    /* Select All in list view header */
    $('#select_all').on('change', function() {
        var checked = $(this).is(':checked');
        /* Only check visible rows */
        if (dt) {
            dt.rows({ search: 'applied' }).nodes().each(function() {
                $(this).find('.doc-check').prop('checked', checked);
                $(this).toggleClass('selected', checked);
            });
        } else {
            $('.doc-check').prop('checked', checked);
            $('.doc-check').closest('tr').toggleClass('selected', checked);
        }
        /* Sync grid checkboxes too */
        syncGridCheckboxes();
        updateBulkBar();
    });

    /* Individual checkbox in list */
    $(document).on('change', '.doc-check', function() {
        var tr = $(this).closest('tr');
        tr.toggleClass('selected', $(this).is(':checked'));
        syncGridCheckboxFromList($(this));
        updateSelectAll();
        updateBulkBar();
    });

    /* Individual checkbox in grid */
    $(document).on('change', '.doc-grid-check', function() {
        var card = $(this).closest('.doc-grid-card');
        card.toggleClass('selected', $(this).is(':checked'));
        syncListCheckboxFromGrid($(this));
        updateSelectAll();
        updateBulkBar();
    });

    function syncGridCheckboxes() {
        /* Sync all grid checkboxes to match list checkboxes */
        $('.doc-grid-check').each(function() {
            var id = $(this).val();
            var listCb = $('.doc-check[value="' + id + '"]');
            $(this).prop('checked', listCb.is(':checked'));
            $(this).closest('.doc-grid-card').toggleClass('selected', listCb.is(':checked'));
        });
    }

    function syncGridCheckboxFromList(listCb) {
        var id = listCb.val();
        var gridCb = $('.doc-grid-check[value="' + id + '"]');
        gridCb.prop('checked', listCb.is(':checked'));
        gridCb.closest('.doc-grid-card').toggleClass('selected', listCb.is(':checked'));
    }

    function syncListCheckboxFromGrid(gridCb) {
        var id = gridCb.val();
        var listCb = $('.doc-check[value="' + id + '"]');
        listCb.prop('checked', gridCb.is(':checked'));
        listCb.closest('tr').toggleClass('selected', gridCb.is(':checked'));
    }

    function updateSelectAll() {
        var total = dt ? dt.rows({ search: 'applied' }).nodes().length : $('.doc-check').length;
        var checked = getSelectedIds().length;
        $('#select_all').prop('checked', total > 0 && checked === total);
        $('#select_all').prop('indeterminate', checked > 0 && checked < total);
    }

    function getSelectedIds() {
        var ids = [];
        $('.doc-check:checked').each(function() {
            var id = $(this).val();
            if (id && ids.indexOf(id) === -1) ids.push(id);
        });
        return ids;
    }

    function updateBulkBar() {
        var ids = getSelectedIds();
        if (ids.length > 0) {
            $('#bulkBar').slideDown(150);
            $('#bulkCount').text(ids.length);
        } else {
            $('#bulkBar').slideUp(150);
        }
    }

    window.clearSelection = function() {
        $('.doc-check, .doc-grid-check').prop('checked', false);
        $('tr.selected, .doc-grid-card.selected').removeClass('selected');
        $('#select_all').prop('checked', false).prop('indeterminate', false);
        updateBulkBar();
    };

    /* ══════════════════════════════════════════════
       BULK DOWNLOAD
       ══════════════════════════════════════════════ */
    window.bulkDownload = function() {
        var ids = getSelectedIds();
        if (ids.length === 0) return;
        /* Download each file sequentially using hidden iframes */
        ids.forEach(function(id, i) {
            setTimeout(function() {
                var iframe = $('<iframe>').attr('src', '<?= base_url('documents/download/') ?>' + id).hide();
                $('body').append(iframe);
                setTimeout(function() { iframe.remove(); }, 10000);
            }, i * 300);
        });
    };

    /* ══════════════════════════════════════════════
       DELETE (single + bulk)
       ══════════════════════════════════════════════ */

    /* Single delete button */
    $(document).on('click', '.btn-doc-delete', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        if (!id) return;
        deleteTargetIds = [String(id)];
        $('#deleteConfirmText').text('Are you sure you want to delete this document? This action cannot be undone.');
        $('#deleteConfirmModal').modal('show');
    });

    /* Bulk delete */
    window.bulkDelete = function() {
        var ids = getSelectedIds();
        if (ids.length === 0) return;
        deleteTargetIds = ids;
        $('#deleteConfirmText').text('Are you sure you want to delete ' + ids.length + ' document(s)? This action cannot be undone.');
        $('#deleteConfirmModal').modal('show');
    };

    /* Confirm delete */
    $('#confirmDeleteBtn').on('click', function() {
        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Deleting...');

        if (deleteTargetIds.length === 1) {
            /* Single delete */
            $.ajax({
                url: '<?= base_url('Ajax/delete_document') ?>',
                method: 'POST',
                data: { id: deleteTargetIds[0] },
                dataType: 'json',
                success: function(res) {
                    removeDocFromUI(deleteTargetIds[0]);
                    $('#deleteConfirmModal').modal('hide');
                    updateBulkBar();
                },
                error: function() {
                    alert('Failed to delete document. Please try again.');
                },
                complete: function() {
                    btn.prop('disabled', false).html('<i class="fa fa-trash-o"></i> Delete');
                }
            });
        } else {
            /* Bulk delete */
            $.ajax({
                url: '<?= base_url('Ajax/bulk_delete_documents') ?>',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ ids: deleteTargetIds }),
                dataType: 'json',
                success: function(res) {
                    deleteTargetIds.forEach(function(id) { removeDocFromUI(id); });
                    clearSelection();
                    $('#deleteConfirmModal').modal('hide');
                },
                error: function() {
                    alert('Failed to delete documents. Please try again.');
                },
                complete: function() {
                    btn.prop('disabled', false).html('<i class="fa fa-trash-o"></i> Delete');
                }
            });
        }
    });

    function removeDocFromUI(id) {
        /* Remove from DataTable */
        if (dt) {
            var row = $('tr[data-doc-id="' + id + '"]');
            if (row.length) {
                dt.row(row).remove().draw(false);
            }
        }
        /* Remove from grid */
        $('.doc-grid-card[data-doc-id="' + id + '"]').fadeOut(200, function() { $(this).remove(); });
        /* Update breadcrumb count */
        if (dt) {
            var info = dt.page.info();
            $('#breadcrumbCount').text(info.recordsDisplay + ' files');
        }
    }

    /* ══════════════════════════════════════════════
       FOLDER FILTERING
       ══════════════════════════════════════════════ */
    window.filterByFolder = function(filter, el) {
        currentFilter = filter;

        /* Highlight active folder */
        $('.doc-folder-item').removeClass('active');
        $(el).addClass('active');

        /* Update breadcrumb */
        var name = $(el).find('.doc-folder-name').text().trim();
        $('#breadcrumbText').text(name);
        var iconClass = $(el).find('.doc-folder-icon i').attr('class');
        $('.doc-breadcrumb-icon i').attr('class', iconClass);

        /* Redraw DataTable — the custom filter function uses currentFilter */
        if (dt) {
            dt.draw();
            var info = dt.page.info();
            $('#breadcrumbCount').text(info.recordsDisplay + ' files');
        }

        /* Filter grid cards too */
        filterGridCards();

        /* Pre-select company in upload modal */
        if (filter.indexOf('company-') === 0) {
            var cid = filter.replace('company-', '');
            $('#uploadCompanySelect').val(cid).trigger('change');
        }

        /* Clear selection when changing folder */
        clearSelection();
    };

    function filterGridCards() {
        $('.doc-grid-card').each(function() {
            var companyId = String($(this).data('company-id') || '');
            var entityType = String($(this).data('entity-type') || '');
            var show = true;

            if (currentFilter === 'all') show = true;
            else if (currentFilter === 'general') show = !companyId || companyId === '' || entityType !== 'company';
            else if (currentFilter === 'recent') show = true;
            else if (currentFilter.indexOf('company-') === 0) {
                var fid = currentFilter.replace('company-', '');
                show = companyId === fid;
            }

            $(this).toggle(show);
        });
    }

    /* ── Folder search (fuzzy / multi-word) ── */
    window.filterFolders = function() {
        var q = $('#folderSearch').val().toLowerCase().trim();
        if (!q) {
            $('.company-folder').show();
            $('.doc-folder-divider, .doc-folder-label').show();
            return;
        }
        var words = q.split(/[\s\-_\.]+/).filter(function(w) { return w.length > 0; });

        $('.company-folder').each(function() {
            var name = ($(this).data('name') || '').toLowerCase();
            var match = words.every(function(w) { return name.indexOf(w) !== -1; });
            $(this).toggle(match);
        });
        $('.doc-folder-divider, .doc-folder-label').toggle(q === '');
    };

    /* ══════════════════════════════════════════════
       VIEW TOGGLE (List / Grid)
       ══════════════════════════════════════════════ */
    window.setDocView = function(view) {
        currentView = view;
        localStorage.setItem('docView', view);

        if (view === 'grid') {
            $('#docListView').hide();
            $('#docGridView').show();
            $('#btnGridView').addClass('active');
            $('#btnListView').removeClass('active');
            /* Apply current filter to grid */
            filterGridCards();
        } else {
            $('#docGridView').hide();
            $('#docListView').show();
            $('#btnListView').addClass('active');
            $('#btnGridView').removeClass('active');
        }
        /* Sync checkboxes between views */
        if (view === 'grid') syncGridCheckboxes();
    };

    /* Restore saved view */
    if (currentView === 'grid') {
        setDocView('grid');
    }

    /* ══════════════════════════════════════════════
       UPLOAD: Drag & Drop + File Preview
       ══════════════════════════════════════════════ */
    var uploadZone = document.getElementById('uploadZone');
    var fileInput = document.getElementById('fileInput');
    var selectedFiles = new DataTransfer();

    if (uploadZone && fileInput) {
        uploadZone.addEventListener('click', function() { fileInput.click(); });

        uploadZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadZone.classList.add('dragover');
        });
        uploadZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadZone.classList.remove('dragover');
        });
        uploadZone.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadZone.classList.remove('dragover');
            if (e.dataTransfer.files.length > 0) {
                addFilesToSelection(e.dataTransfer.files);
            }
        });

        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                addFilesToSelection(fileInput.files);
            }
        });
    }

    function addFilesToSelection(files) {
        for (var i = 0; i < files.length; i++) {
            selectedFiles.items.add(files[i]);
        }
        fileInput.files = selectedFiles.files;
        renderFileList();
    }

    function removeFileFromSelection(index) {
        selectedFiles.items.remove(index);
        fileInput.files = selectedFiles.files;
        renderFileList();
    }

    function renderFileList() {
        var list = $('#fileListItems');
        list.empty();
        if (selectedFiles.files.length === 0) {
            $('#selectedFilesList').hide();
            return;
        }
        $('#selectedFilesList').show();
        for (var i = 0; i < selectedFiles.files.length; i++) {
            var f = selectedFiles.files[i];
            var size = f.size < 1024 ? f.size + ' B' : (f.size < 1048576 ? (f.size/1024).toFixed(1) + ' KB' : (f.size/1048576).toFixed(1) + ' MB');
            list.append(
                '<div class="doc-file-tag" data-index="' + i + '">' +
                '<i class="fa fa-file-o" style="color:var(--cf-accent);"></i>' +
                '<span>' + $('<span>').text(f.name).html() + '</span>' +
                '<span style="color:var(--cf-text-muted); font-size:10px;">(' + size + ')</span>' +
                '<i class="fa fa-times" onclick="removeUploadFile(' + i + ')"></i>' +
                '</div>'
            );
        }
    }

    window.removeUploadFile = function(index) {
        removeFileFromSelection(index);
    };

    /* Reset on modal close */
    $('#uploadModal').on('hidden.bs.modal', function() {
        selectedFiles = new DataTransfer();
        fileInput.value = '';
        fileInput.files = selectedFiles.files;
        renderFileList();
    });
});
</script>
