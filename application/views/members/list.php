<!-- Individuals / Members List - Modern Rillet Style -->
<div class="page-title">
    <div class="title_left">
        <h3><?php echo $page_title; ?></h3>
        <p style="color:var(--cf-text-secondary); font-size:14px; margin-top:4px;">
            Manage individual profiles, directors, and shareholders
        </p>
    </div>
    <div class="title_right">
        <div class="pull-right" style="display:flex; gap:8px; align-items:center;">
            <span style="font-size:13px; color:var(--cf-text-secondary);">
                <i class="fa fa-users" style="margin-right:4px;"></i> Total: <?php echo $total; ?>
            </span>
            <a href="<?php echo site_url('members/add_member'); ?>" class="btn btn-primary">
                <i class="fa fa-plus" style="margin-right:4px;"></i> Add Individual
            </a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">

                <!-- Modern Filter Bar -->
                <div style="display:flex; gap:12px; align-items:center; margin-bottom:16px; flex-wrap:wrap;">
                    <button class="btn btn-default" id="toggleFilter" style="border-radius:var(--cf-radius-sm);">
                        <i class="fa fa-filter" style="margin-right:6px; color:var(--cf-accent);"></i> Filters
                    </button>
                    <div style="flex:1;"></div>
                    <span style="font-size:13px; color:var(--cf-text-secondary);">
                        <i class="fa fa-database" style="margin-right:4px;"></i>
                        <?php echo $total; ?> records
                    </span>
                </div>

                <!-- Collapsible Filter Panel -->
                <div id="filterPanel" style="display:none; background:var(--cf-card-bg); padding:20px; border-radius:var(--cf-radius); margin-bottom:16px; border:1px solid var(--cf-border);">
                    <div class="row">
                        <div class="col-md-3">
                            <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Status</label>
                            <select id="filter_status" class="form-control select2_filter" style="width:100%;">
                                <option value="">All Statuses</option>
                                <option value="Active">Active</option>
                                <option value="Ceased">Ceased</option>
                                <option value="Discharged">Discharged</option>
                                <option value="Deceased">Deceased</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Nationality</label>
                            <select id="filter_nationality" class="form-control select2_filter" style="width:100%;">
                                <option value="">All Nationalities</option>
                                <?php
                                $nationalities = array();
                                foreach ($members as $m) {
                                    if (!empty($m->nationality) && !in_array($m->nationality, $nationalities)) {
                                        $nationalities[] = $m->nationality;
                                    }
                                }
                                sort($nationalities);
                                foreach ($nationalities as $nat): ?>
                                    <option value="<?php echo htmlspecialchars($nat); ?>"><?php echo htmlspecialchars($nat); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3" style="display:flex; align-items:flex-end;">
                            <button id="btn_reset_filter" class="btn btn-default btn-sm">
                                <i class="fa fa-refresh" style="margin-right:4px;"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <table id="datatable" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">S/No.</th>
                            <th>Individual Name</th>
                            <th>Alias Name</th>
                            <th>ID Type / ID No.</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Contact No.</th>
                            <th width="12%" style="min-width:140px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($members)):
                            $sno = 1;
                            foreach ($members as $row): ?>
                            <tr>
                                <td style="color:var(--cf-text-muted); font-size:12px;"><?php echo $sno++; ?></td>
                                <td>
                                    <span style="font-weight:600; color:var(--cf-text);"><?php echo htmlspecialchars($row->name); ?></span>
                                </td>
                                <td style="color:var(--cf-text-secondary); font-size:12px;"><?php echo htmlspecialchars($row->alias_name); ?></td>
                                <td style="font-family:monospace; font-size:12px;">
                                    <?php
                                    if (!empty($row->id_type) && !empty($row->id_number)) {
                                        echo htmlspecialchars($row->id_type) . ' / ' . htmlspecialchars($row->id_number);
                                    } else {
                                        echo '<span style="color:var(--cf-text-muted);">--</span>';
                                    }
                                    ?>
                                </td>
                                <td style="font-size:12px; max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                    <?php
                                    if (!empty($row->address)) {
                                        echo htmlspecialchars($row->address);
                                    } else {
                                        echo '<span style="color:var(--cf-text-muted);">--</span>';
                                    }
                                    ?>
                                </td>
                                <td style="font-size:12px;"><?php echo htmlspecialchars($row->email); ?></td>
                                <td style="font-size:12px;"><?php echo htmlspecialchars($row->phone ?? $row->contact_number ?? ''); ?></td>
                                <td>
                                    <div style="display:flex; gap:4px; flex-wrap:wrap;">
                                        <a href="<?php echo site_url('members/edit_member/' . $row->id); ?>" class="btn btn-default btn-xs" title="Edit" style="border-radius:6px;">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="<?php echo site_url('members/view_member/' . $row->id); ?>" class="btn btn-default btn-xs" title="View" style="border-radius:6px;">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <button class="btn btn-default btn-xs delete_doc" data-id="<?php echo $row->id; ?>" title="Delete" style="border-radius:6px; color:var(--cf-danger);">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach;
                        endif; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    // DataTable init
    var table = $('#datatable').DataTable({
        "order": [[0, "asc"]],
        "pageLength": 25,
        "responsive": true,
        "language": {
            "emptyTable": "No individuals found",
            "search": "",
            "searchPlaceholder": "Search individuals...",
            "info": "Showing _START_ to _END_ of _TOTAL_ individuals",
            "paginate": { "previous": '<i class="fa fa-chevron-left"></i>', "next": '<i class="fa fa-chevron-right"></i>' }
        },
        "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>rtip'
    });

    // Filter toggle
    $('#toggleFilter').click(function() {
        $('#filterPanel').slideToggle(200);
        $(this).toggleClass('active');
    });

    // Select2 init for filter dropdowns
    if ($.fn.select2) {
        $('.select2_filter').select2({
            allowClear: true,
            placeholder: function() {
                return $(this).find('option:first').text();
            }
        });
    }

    // Filter by Status
    $('#filter_status').on('change', function() {
        var val = $(this).val();
        table.draw();
    });

    // Filter by Nationality
    $('#filter_nationality').on('change', function() {
        var val = $(this).val();
        table.draw();
    });

    // Reset Filters
    $('#btn_reset_filter').on('click', function() {
        $('#filter_status').val('').trigger('change');
        $('#filter_nationality').val('').trigger('change');
        table.search('').columns().search('').draw();
    });

    // SweetAlert Delete Confirmation
    $(document).on('click', '.delete_doc', function() {
        var id = $(this).data('id');
        var row = $(this).closest('tr');

        swal({
            title: "Are you sure?",
            text: "You are about to delete this individual record. This action cannot be undone!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#EF4444",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }, function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: base_url + 'members/delete_member',
                    type: 'POST',
                    data: {
                        id: id,
                        'ci_csrf_token': '<?php echo $csrf_token ?? ''; ?>'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            swal("Deleted!", response.message, "success");
                            table.row(row).remove().draw();
                        } else {
                            swal("Error!", response.message, "error");
                        }
                    },
                    error: function() {
                        swal("Error!", "An error occurred while deleting the record.", "error");
                    }
                });
            }
        });
    });

});
</script>
