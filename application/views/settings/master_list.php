<!-- Settings Master List - Reusable CRUD listing for all 42 master types -->
<div class="page-title">
    <div class="title_left">
        <h3><?= htmlspecialchars($config['title']) ?></h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('settings_master_add/' . htmlspecialchars($master_type)) ?>" class="btn btn-success btn-sm">
                <i class="fa fa-plus"></i> Add New
            </a>
            <a href="<?= base_url('settings') ?>" class="btn btn-default btn-sm">
                <i class="fa fa-arrow-left"></i> Back to Settings
            </a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<?php if (!empty($flash)): ?>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : htmlspecialchars($flash['type']) ?> alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?= $flash['message'] ?>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-list"></i> <?= htmlspecialchars($config['title']) ?>
                    <small class="text-muted">(<?= count($records) ?> record<?= count($records) !== 1 ? 's' : '' ?>)</small>
                </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table id="masterTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead style="background:#206570;color:#fff;">
                            <tr>
                                <?php foreach ($config['columns'] as $col): ?>
                                <th><?= htmlspecialchars($col) ?></th>
                                <?php endforeach; ?>
                                <th style="width:100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($records)): ?>
                                <?php $sno = 1; foreach ($records as $record): ?>
                                <tr>
                                    <?php
                                    // Map columns to record fields dynamically
                                    $colIndex = 0;
                                    foreach ($config['columns'] as $col) {
                                        $colIndex++;
                                        if ($colIndex === 1) {
                                            // First column: always show record ID or S/No
                                            echo '<td>' . htmlspecialchars($record->id ?? $sno) . '</td>';
                                        } else {
                                            // Map column header to field name: lowercase, replace spaces/special chars with underscore
                                            $fieldName = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '_', trim($col)));
                                            $fieldName = rtrim($fieldName, '_');
                                            $value = '';

                                            // Try exact match first, then common variations
                                            if (isset($record->$fieldName)) {
                                                $value = $record->$fieldName;
                                            } else {
                                                // Try matching against field definitions
                                                foreach ($config['fields'] as $field) {
                                                    $fieldLabel = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '_', trim($field['label'])));
                                                    $fieldLabel = rtrim($fieldLabel, '_');
                                                    if ($fieldLabel === $fieldName && isset($record->{$field['name']})) {
                                                        $value = $record->{$field['name']};
                                                        break;
                                                    }
                                                }
                                            }

                                            // Render status column with badge
                                            if (strtolower($col) === 'status') {
                                                $statusClass = (strtolower($value) === 'active') ? 'success' : 'danger';
                                                echo '<td><span class="label label-' . $statusClass . '">' . htmlspecialchars($value ?: 'Active') . '</span></td>';
                                            } else {
                                                echo '<td>' . htmlspecialchars($value ?? '') . '</td>';
                                            }
                                        }
                                    }
                                    ?>
                                    <td>
                                        <a href="<?= base_url("settings_master_edit/" . htmlspecialchars($master_type) . "/" . $record->id) ?>"
                                           class="btn btn-info btn-xs" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger btn-xs btn-delete" data-id="<?= $record->id ?>"
                                                data-name="<?= htmlspecialchars($record->{$config['fields'][0]['name']} ?? 'this record') ?>"
                                                title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php $sno++; endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="<?= count($config['columns']) + 1 ?>" class="text-center" style="padding:30px;">
                                    <i class="fa fa-inbox fa-2x text-muted" style="display:block;margin-bottom:10px;"></i>
                                    No records found.
                                    <a href="<?= base_url('settings_master_add/' . htmlspecialchars($master_type)) ?>">Add the first one</a>.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // ── Initialize DataTable ──────────────────────────────────────────────
    <?php if (!empty($records)): ?>
    if ($.fn.DataTable) {
        $('#masterTable').DataTable({
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            order: [[0, 'desc']],
            columnDefs: [
                { orderable: false, targets: -1 } // Disable sorting on Actions column
            ],
            dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>rtip',
            language: {
                search: 'Search:',
                lengthMenu: 'Show _MENU_ entries',
                info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                emptyTable: 'No records found',
                zeroRecords: 'No matching records found'
            },
            responsive: true
        });
    }
    <?php endif; ?>

    // ── Delete with SweetAlert confirmation ───────────────────────────────
    $(document).on('click', '.btn-delete', function() {
        var id   = $(this).data('id');
        var name = $(this).data('name');
        var deleteUrl = '<?= base_url("settings_master/delete/" . htmlspecialchars($master_type) . "/") ?>' + id;

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Are you sure?',
                html: 'Delete <strong>' + name + '</strong>? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then(function(result) {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        } else if (confirm('Are you sure you want to delete "' + name + '"? This action cannot be undone.')) {
            window.location.href = deleteUrl;
        }
    });
});
</script>
