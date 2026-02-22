<!-- Page Title -->
<div class="page-title">
    <div class="title_left">
        <h3><?php echo $page_title; ?> <small>(Total: <?php echo $total; ?>)</small></h3>
    </div>
    <div class="title_right">
        <a href="<?php echo site_url('members/add_member'); ?>" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add Individual</a>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">

                <!-- Filter Row -->
                <div class="row" style="margin-bottom:15px;">
                    <div class="col-md-3">
                        <select id="filter_status" class="form-control select2_filter" style="width:100%;">
                            <option value="">-- Filter by Status --</option>
                            <option value="Active">Active</option>
                            <option value="Ceased">Ceased</option>
                            <option value="Discharged">Discharged</option>
                            <option value="Deceased">Deceased</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filter_nationality" class="form-control select2_filter" style="width:100%;">
                            <option value="">-- Filter by Nationality --</option>
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
                    <div class="col-md-2">
                        <button id="btn_reset_filter" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</button>
                    </div>
                </div>

                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead style="background:#206570;color:#fff;">
                        <tr>
                            <th width="5%">S/No.</th>
                            <th>Individual Name</th>
                            <th>Alias Name</th>
                            <th>ID Type / ID No.</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Contact No.</th>
                            <th width="12%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($members)):
                            $sno = 1;
                            foreach ($members as $row): ?>
                            <tr>
                                <td><?php echo $sno++; ?></td>
                                <td><?php echo htmlspecialchars($row->name); ?></td>
                                <td><?php echo htmlspecialchars($row->alias_name); ?></td>
                                <td>
                                    <?php
                                    if (!empty($row->id_type) && !empty($row->id_number)) {
                                        echo htmlspecialchars($row->id_type) . ' / ' . htmlspecialchars($row->id_number);
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (!empty($row->address)) {
                                        echo htmlspecialchars($row->address);
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($row->email); ?></td>
                                <td><?php echo htmlspecialchars($row->contact_number); ?></td>
                                <td>
                                    <a href="<?php echo site_url('members/edit_member/' . $row->id); ?>" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i> Edit</a>
                                    <a href="<?php echo site_url('members/view_member/' . $row->id); ?>" class="btn btn-primary btn-xs" title="View"><i class="fa fa-eye"></i> View</a>
                                    <button class="btn btn-danger btn-xs delete_doc" data-id="<?php echo $row->id; ?>" title="Delete"><i class="fa fa-trash"></i></button>
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
            "search": "Search:"
        },
        "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>rtip'
    });

    // Select2 init for filter dropdowns
    $('.select2_filter').select2({
        allowClear: true,
        placeholder: function() {
            return $(this).find('option:first').text();
        }
    });

    // Filter by Status
    $('#filter_status').on('change', function() {
        var val = $(this).val();
        // Status is not directly in the table, but could be used for server-side filtering
        // For client-side, we do a simple column search if status were visible
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
            confirmButtonColor: "#DD6B55",
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
