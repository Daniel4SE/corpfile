<!-- Page Title -->
<div class="page-title">
    <div class="title_left">
        <h3><?php echo $page_title; ?></h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?php echo site_url('members/edit_member/' . $member->id); ?>" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
            <a href="<?php echo site_url('members'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to List</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!-- Member Header Card -->
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <div class="col-md-8">
                        <h2 style="margin-top:5px;">
                            <?php echo htmlspecialchars($member->name); ?>
                            <?php if (!empty($member->alias_name)): ?>
                                <small style="color:#888;">(<?php echo htmlspecialchars($member->alias_name); ?>)</small>
                            <?php endif; ?>
                        </h2>
                    </div>
                    <div class="col-md-4 text-right">
                        <?php
                        $status_class = 'default';
                        if ($member->status == 'Active') $status_class = 'success';
                        elseif ($member->status == 'Ceased') $status_class = 'warning';
                        elseif ($member->status == 'Discharged') $status_class = 'info';
                        elseif ($member->status == 'Deceased') $status_class = 'danger';
                        ?>
                        <span class="label label-<?php echo $status_class; ?>" style="font-size:14px;padding:6px 15px;">
                            <?php echo htmlspecialchars($member->status); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabbed Content -->
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">

                <!-- Tab Navigation -->
                <ul class="nav nav-tabs bar_tabs" id="member_tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#tab_personal" role="tab" data-toggle="tab"><i class="fa fa-user"></i> Personal Info</a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_identifications" role="tab" data-toggle="tab"><i class="fa fa-id-card"></i> Identifications</a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_addresses" role="tab" data-toggle="tab"><i class="fa fa-map-marker"></i> Addresses</a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_roles" role="tab" data-toggle="tab"><i class="fa fa-briefcase"></i> Company Roles</a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_files" role="tab" data-toggle="tab"><i class="fa fa-folder-open"></i> Files</a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_log" role="tab" data-toggle="tab"><i class="fa fa-history"></i> Log</a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_kyc" role="tab" data-toggle="tab"><i class="fa fa-search"></i> KYC Search</a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" style="padding:20px 0;">

                    <!-- ======================================== -->
                    <!-- TAB 1: Personal Info -->
                    <!-- ======================================== -->
                    <div role="tabpanel" class="tab-pane fade in active" id="tab_personal">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th width="35%" style="background:#f5f5f5;">Name Initials</th>
                                            <td><?php echo htmlspecialchars(!empty($member->name_initials) ? $member->name_initials : '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <th style="background:#f5f5f5;">Full Name</th>
                                            <td><?php echo htmlspecialchars($member->name); ?></td>
                                        </tr>
                                        <tr>
                                            <th style="background:#f5f5f5;">Former Name</th>
                                            <td><?php echo htmlspecialchars(!empty($member->former_name) ? $member->former_name : '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <th style="background:#f5f5f5;">Alias Name</th>
                                            <td><?php echo htmlspecialchars(!empty($member->alias_name) ? $member->alias_name : '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <th style="background:#f5f5f5;">Gender</th>
                                            <td><?php echo htmlspecialchars(!empty($member->gender) ? $member->gender : '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <th style="background:#f5f5f5;">Date of Birth</th>
                                            <td><?php echo !empty($member->date_of_birth) ? date('d/m/Y', strtotime($member->date_of_birth)) : '-'; ?></td>
                                        </tr>
                                        <tr>
                                            <th style="background:#f5f5f5;">Country of Birth</th>
                                            <td><?php echo htmlspecialchars(!empty($member->country_of_birth) ? $member->country_of_birth : '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <th style="background:#f5f5f5;">Nationality</th>
                                            <td><?php echo htmlspecialchars(!empty($member->nationality) ? $member->nationality : '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <th style="background:#f5f5f5;">Race</th>
                                            <td><?php echo htmlspecialchars(!empty($member->race) ? $member->race : '-'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th width="35%" style="background:#f5f5f5;">Status</th>
                                            <td>
                                                <span class="label label-<?php echo $status_class; ?>"><?php echo htmlspecialchars($member->status); ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background:#f5f5f5;">Risk Assessment</th>
                                            <td>
                                                <?php
                                                $risk = !empty($member->risk_assessment_rating) ? $member->risk_assessment_rating : '-';
                                                $risk_class = 'default';
                                                if ($risk == 'Low') $risk_class = 'success';
                                                elseif ($risk == 'Medium') $risk_class = 'warning';
                                                elseif ($risk == 'High') $risk_class = 'danger';
                                                ?>
                                                <span class="label label-<?php echo $risk_class; ?>"><?php echo htmlspecialchars($risk); ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background:#f5f5f5;">Email</th>
                                            <td><?php echo htmlspecialchars(!empty($member->email) ? $member->email : '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <th style="background:#f5f5f5;">Alternate Email</th>
                                            <td><?php echo htmlspecialchars(!empty($member->alternate_email) ? $member->alternate_email : '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <th style="background:#f5f5f5;">Mobile</th>
                                            <td><?php echo htmlspecialchars(!empty($member->mobile_code) ? $member->mobile_code . ' ' : '') . htmlspecialchars(!empty($member->mobile_number) ? $member->mobile_number : '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <th style="background:#f5f5f5;">Telephone</th>
                                            <td><?php echo htmlspecialchars(!empty($member->telephone_code) ? $member->telephone_code . ' ' : '') . htmlspecialchars(!empty($member->telephone_number) ? $member->telephone_number : '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <th style="background:#f5f5f5;">Father Name</th>
                                            <td><?php echo htmlspecialchars(!empty($member->father_name) ? $member->father_name : '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <th style="background:#f5f5f5;">Mother Name</th>
                                            <td><?php echo htmlspecialchars(!empty($member->mother_name) ? $member->mother_name : '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <th style="background:#f5f5f5;">Spouse Name</th>
                                            <td><?php echo htmlspecialchars(!empty($member->spouse_name) ? $member->spouse_name : '-'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <?php if (!empty($member->additional_notes)): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="well" style="margin-top:10px;">
                                    <strong><i class="fa fa-sticky-note"></i> Additional Notes:</strong><br/>
                                    <?php echo nl2br(htmlspecialchars($member->additional_notes)); ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- ======================================== -->
                    <!-- TAB 2: Identifications -->
                    <!-- ======================================== -->
                    <div role="tabpanel" class="tab-pane fade" id="tab_identifications">
                        <table id="dt_identifications" class="table table-striped table-bordered" width="100%">
                            <thead style="background:#206570;color:#fff;">
                                <tr>
                                    <th width="5%">S/No.</th>
                                    <th>ID Type</th>
                                    <th>ID Number</th>
                                    <th>Country of Issue</th>
                                    <th>Issue Date</th>
                                    <th>Expiry Date</th>
                                    <th>Status</th>
                                    <th width="10%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($identifications)):
                                    $sno = 1;
                                    foreach ($identifications as $ident): ?>
                                    <tr>
                                        <td><?php echo $sno++; ?></td>
                                        <td><?php echo htmlspecialchars($ident->id_type); ?></td>
                                        <td><?php echo htmlspecialchars($ident->id_number); ?></td>
                                        <td><?php echo htmlspecialchars(!empty($ident->country_of_issue) ? $ident->country_of_issue : '-'); ?></td>
                                        <td><?php echo !empty($ident->issue_date) ? date('d/m/Y', strtotime($ident->issue_date)) : '-'; ?></td>
                                        <td><?php echo !empty($ident->expiry_date) ? date('d/m/Y', strtotime($ident->expiry_date)) : '-'; ?></td>
                                        <td>
                                            <?php
                                            $id_status = !empty($ident->status) ? $ident->status : 'Active';
                                            $id_status_class = $id_status == 'Active' ? 'success' : 'danger';
                                            ?>
                                            <span class="label label-<?php echo $id_status_class; ?>"><?php echo htmlspecialchars($id_status); ?></span>
                                        </td>
                                        <td>
                                            <?php if (!empty($ident->file_path)): ?>
                                                <a href="<?php echo base_url($ident->file_path); ?>" class="btn btn-xs btn-default" target="_blank" title="View File"><i class="fa fa-file"></i></a>
                                            <?php endif; ?>
                                            <a href="<?php echo site_url('members/download_id_doc/' . $ident->id); ?>" class="btn btn-xs btn-primary" title="Download"><i class="fa fa-download"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach;
                                endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- ======================================== -->
                    <!-- TAB 3: Addresses -->
                    <!-- ======================================== -->
                    <div role="tabpanel" class="tab-pane fade" id="tab_addresses">
                        <?php if (!empty($addresses)):
                            foreach ($addresses as $addr): ?>
                            <div class="panel panel-default" style="margin-bottom:15px;">
                                <div class="panel-heading">
                                    <h4 class="panel-title" style="margin:0;">
                                        <?php
                                        $addr_type = !empty($addr->address_type) ? $addr->address_type : 'Registered';
                                        $badge_class = 'primary';
                                        if ($addr_type == 'Registered') $badge_class = 'success';
                                        elseif ($addr_type == 'Foreign') $badge_class = 'info';
                                        elseif (strpos($addr_type, 'Alternative') !== false) $badge_class = 'warning';
                                        ?>
                                        <span class="label label-<?php echo $badge_class; ?>"><?php echo htmlspecialchars($addr_type); ?></span>
                                        Address
                                    </h4>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-condensed">
                                                <tr>
                                                    <th width="30%">Block</th>
                                                    <td><?php echo htmlspecialchars(!empty($addr->block) ? $addr->block : '-'); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Street / Address</th>
                                                    <td><?php echo htmlspecialchars(!empty($addr->street) ? $addr->street : '-'); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Building</th>
                                                    <td><?php echo htmlspecialchars(!empty($addr->building) ? $addr->building : '-'); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Level / Unit</th>
                                                    <td>
                                                        <?php
                                                        $level_unit = '';
                                                        if (!empty($addr->level)) $level_unit .= $addr->level;
                                                        if (!empty($addr->unit)) $level_unit .= (!empty($level_unit) ? ' / ' : '') . $addr->unit;
                                                        echo htmlspecialchars(!empty($level_unit) ? $level_unit : '-');
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-condensed">
                                                <tr>
                                                    <th width="30%">Country</th>
                                                    <td><?php echo htmlspecialchars(!empty($addr->country) ? $addr->country : '-'); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>State</th>
                                                    <td><?php echo htmlspecialchars(!empty($addr->state) ? $addr->state : '-'); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>City</th>
                                                    <td><?php echo htmlspecialchars(!empty($addr->city) ? $addr->city : '-'); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Postal Code</th>
                                                    <td><?php echo htmlspecialchars(!empty($addr->postal_code) ? $addr->postal_code : '-'); ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;
                        else: ?>
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> No addresses found for this individual.
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- ======================================== -->
                    <!-- TAB 4: Company Roles -->
                    <!-- ======================================== -->
                    <div role="tabpanel" class="tab-pane fade" id="tab_roles">
                        <table id="dt_roles" class="table table-striped table-bordered" width="100%">
                            <thead style="background:#206570;color:#fff;">
                                <tr>
                                    <th width="5%">S/No.</th>
                                    <th>Company Name</th>
                                    <th>UEN</th>
                                    <th>Role</th>
                                    <th>Date of Appointment</th>
                                    <th>Date of Cessation</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($roles)):
                                    $sno = 1;
                                    foreach ($roles as $role): ?>
                                    <tr>
                                        <td><?php echo $sno++; ?></td>
                                        <td>
                                            <a href="<?php echo site_url('companies/view_company/' . $role->company_id); ?>">
                                                <?php echo htmlspecialchars($role->company_name); ?>
                                            </a>
                                        </td>
                                        <td><?php echo htmlspecialchars(!empty($role->uen) ? $role->uen : '-'); ?></td>
                                        <td>
                                            <?php
                                            $role_badge = 'default';
                                            if ($role->role == 'Director') $role_badge = 'primary';
                                            elseif ($role->role == 'Shareholder') $role_badge = 'info';
                                            elseif ($role->role == 'Secretary') $role_badge = 'success';
                                            elseif ($role->role == 'Auditor') $role_badge = 'warning';
                                            ?>
                                            <span class="label label-<?php echo $role_badge; ?>"><?php echo htmlspecialchars($role->role); ?></span>
                                        </td>
                                        <td><?php echo !empty($role->date_of_appointment) ? date('d/m/Y', strtotime($role->date_of_appointment)) : '-'; ?></td>
                                        <td><?php echo !empty($role->date_of_cessation) ? date('d/m/Y', strtotime($role->date_of_cessation)) : '-'; ?></td>
                                        <td>
                                            <?php
                                            $role_status = !empty($role->status) ? $role->status : 'Active';
                                            $role_status_class = $role_status == 'Active' ? 'success' : 'danger';
                                            ?>
                                            <span class="label label-<?php echo $role_status_class; ?>"><?php echo htmlspecialchars($role_status); ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach;
                                endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- ======================================== -->
                    <!-- TAB 5: Files -->
                    <!-- ======================================== -->
                    <div role="tabpanel" class="tab-pane fade" id="tab_files">
                        <!-- File Upload Area -->
                        <div class="row" style="margin-bottom:20px;">
                            <div class="col-md-12">
                                <form id="form_upload_file" action="<?php echo site_url('members/upload_file/' . $member->id); ?>" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="ci_csrf_token" value="<?php echo $csrf_token ?? ''; ?>" />
                                    <div class="well" style="border:2px dashed #ccc;text-align:center;padding:30px;">
                                        <i class="fa fa-cloud-upload" style="font-size:40px;color:#999;"></i>
                                        <h4 style="color:#999;">Drag & drop files here or click to browse</h4>
                                        <input type="file" name="member_file" id="member_file_input" style="margin:10px auto;display:inline-block;" />
                                        <div class="form-group" style="margin-top:10px;">
                                            <input type="text" name="file_description" class="form-control" placeholder="File description (optional)" style="width:50%;margin:0 auto;" />
                                        </div>
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-upload"></i> Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Files DataTable -->
                        <table id="dt_files" class="table table-striped table-bordered" width="100%">
                            <thead style="background:#206570;color:#fff;">
                                <tr>
                                    <th width="5%">S/No.</th>
                                    <th>File Name</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Size</th>
                                    <th>Uploaded By</th>
                                    <th>Upload Date</th>
                                    <th width="10%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($member->files)):
                                    $sno = 1;
                                    foreach ($member->files as $file): ?>
                                    <tr>
                                        <td><?php echo $sno++; ?></td>
                                        <td><?php echo htmlspecialchars($file->file_name); ?></td>
                                        <td><?php echo htmlspecialchars(!empty($file->description) ? $file->description : '-'); ?></td>
                                        <td><?php echo htmlspecialchars($file->file_type); ?></td>
                                        <td><?php echo htmlspecialchars($file->file_size); ?></td>
                                        <td><?php echo htmlspecialchars($file->uploaded_by); ?></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($file->created_at)); ?></td>
                                        <td>
                                            <a href="<?php echo site_url('members/download_file/' . $file->id); ?>" class="btn btn-xs btn-primary" title="Download"><i class="fa fa-download"></i></a>
                                            <button class="btn btn-xs btn-danger delete_file" data-id="<?php echo $file->id; ?>" title="Delete"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach;
                                endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- ======================================== -->
                    <!-- TAB 6: Activity Log -->
                    <!-- ======================================== -->
                    <div role="tabpanel" class="tab-pane fade" id="tab_log">
                        <table id="dt_log" class="table table-striped table-bordered" width="100%">
                            <thead style="background:#206570;color:#fff;">
                                <tr>
                                    <th width="5%">S/No.</th>
                                    <th>Date & Time</th>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Description</th>
                                    <th>IP Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($member->logs)):
                                    $sno = 1;
                                    foreach ($member->logs as $log): ?>
                                    <tr>
                                        <td><?php echo $sno++; ?></td>
                                        <td><?php echo date('d/m/Y H:i:s', strtotime($log->created_at)); ?></td>
                                        <td><?php echo htmlspecialchars($log->user_name); ?></td>
                                        <td>
                                            <?php
                                            $log_badge = 'default';
                                            if ($log->action == 'Created') $log_badge = 'success';
                                            elseif ($log->action == 'Updated') $log_badge = 'info';
                                            elseif ($log->action == 'Deleted') $log_badge = 'danger';
                                            ?>
                                            <span class="label label-<?php echo $log_badge; ?>"><?php echo htmlspecialchars($log->action); ?></span>
                                        </td>
                                        <td><?php echo htmlspecialchars($log->description); ?></td>
                                        <td><?php echo htmlspecialchars($log->ip_address); ?></td>
                                    </tr>
                                <?php endforeach;
                                endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- ======================================== -->
                    <!-- TAB 7: KYC Search -->
                    <!-- ======================================== -->
                    <div role="tabpanel" class="tab-pane fade" id="tab_kyc">
                        <!-- KYC Search Form -->
                        <div class="row" style="margin-bottom:20px;">
                            <div class="col-md-12">
                                <div class="well">
                                    <form id="form_kyc_search" class="form-inline">
                                        <div class="form-group" style="margin-right:10px;">
                                            <label>Name: </label>
                                            <input type="text" name="kyc_name" class="form-control" value="<?php echo htmlspecialchars($member->name); ?>" style="width:250px;" />
                                        </div>
                                        <div class="form-group" style="margin-right:10px;">
                                            <label>Date of Birth: </label>
                                            <input type="text" name="kyc_dob" class="form-control datepicker" value="<?php echo !empty($member->date_of_birth) ? date('d/m/Y', strtotime($member->date_of_birth)) : ''; ?>" placeholder="DD/MM/YYYY" autocomplete="off" />
                                        </div>
                                        <div class="form-group" style="margin-right:10px;">
                                            <label>Country: </label>
                                            <input type="text" name="kyc_country" class="form-control" value="<?php echo htmlspecialchars(!empty($member->nationality) ? $member->nationality : ''); ?>" />
                                        </div>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- KYC Results Table -->
                        <table id="dt_kyc" class="table table-striped table-bordered" width="100%">
                            <thead style="background:#206570;color:#fff;">
                                <tr>
                                    <th width="5%">S/No.</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Country</th>
                                    <th>Date of Birth</th>
                                    <th>Matches</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- KYC search results will be populated via AJAX -->
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- End Tab Content -->

            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    // =============================================
    // DataTable Initializations
    // =============================================
    $('#dt_identifications').DataTable({
        "order": [[0, "asc"]],
        "pageLength": 10,
        "language": { "emptyTable": "No identification records found" }
    });

    $('#dt_roles').DataTable({
        "order": [[0, "asc"]],
        "pageLength": 10,
        "language": { "emptyTable": "No company roles found" }
    });

    $('#dt_files').DataTable({
        "order": [[6, "desc"]],
        "pageLength": 10,
        "language": { "emptyTable": "No files uploaded" }
    });

    $('#dt_log').DataTable({
        "order": [[1, "desc"]],
        "pageLength": 25,
        "language": { "emptyTable": "No activity log entries" }
    });

    $('#dt_kyc').DataTable({
        "order": [[0, "asc"]],
        "pageLength": 10,
        "language": { "emptyTable": "No KYC search results. Click Search to begin." }
    });

    // =============================================
    // Datepicker for KYC
    // =============================================
    $('#tab_kyc .datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true
    });

    // =============================================
    // Reinitialize DataTables on tab shown (for proper column width)
    // =============================================
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
    });

    // =============================================
    // File Upload via AJAX
    // =============================================
    $('#form_upload_file').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function() {
                $('#form_upload_file button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Uploading...');
            },
            success: function(response) {
                if (response.status === 'success') {
                    swal("Success!", response.message, "success");
                    setTimeout(function() { location.reload(); }, 1500);
                } else {
                    swal("Error!", response.message, "error");
                }
            },
            error: function() {
                swal("Error!", "An error occurred during file upload.", "error");
            },
            complete: function() {
                $('#form_upload_file button[type="submit"]').prop('disabled', false).html('<i class="fa fa-upload"></i> Upload');
            }
        });
    });

    // =============================================
    // Delete File
    // =============================================
    $(document).on('click', '.delete_file', function() {
        var fileId = $(this).data('id');
        var row = $(this).closest('tr');

        swal({
            title: "Are you sure?",
            text: "This file will be permanently deleted.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }, function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: base_url + 'members/delete_file',
                    type: 'POST',
                    data: {
                        id: fileId,
                        'ci_csrf_token': '<?php echo $csrf_token ?? ''; ?>'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            swal("Deleted!", response.message, "success");
                            $('#dt_files').DataTable().row(row).remove().draw();
                        } else {
                            swal("Error!", response.message, "error");
                        }
                    },
                    error: function() {
                        swal("Error!", "An error occurred while deleting the file.", "error");
                    }
                });
            }
        });
    });

    // =============================================
    // KYC Search
    // =============================================
    $('#form_kyc_search').on('submit', function(e) {
        e.preventDefault();

        var name = $('input[name="kyc_name"]').val();
        var dob = $('input[name="kyc_dob"]').val();
        var country = $('input[name="kyc_country"]').val();

        if (!name) {
            swal("Warning", "Please enter a name to search.", "warning");
            return;
        }

        var kycTable = $('#dt_kyc').DataTable();
        kycTable.clear().draw();

        $.ajax({
            url: base_url + 'members/kyc_search',
            type: 'POST',
            data: {
                name: name,
                dob: dob,
                country: country,
                'ci_csrf_token': '<?php echo $csrf_token ?? ''; ?>'
            },
            dataType: 'json',
            beforeSend: function() {
                $('#form_kyc_search button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Searching...');
            },
            success: function(response) {
                if (response.status === 'success' && response.results) {
                    var sno = 1;
                    $.each(response.results, function(i, item) {
                        kycTable.row.add([
                            sno++,
                            item.name || '-',
                            item.date || '-',
                            item.country || '-',
                            item.dob || '-',
                            '<span class="label label-' + (item.match_level == 'High' ? 'danger' : (item.match_level == 'Medium' ? 'warning' : 'success')) + '">' + (item.matches || '0') + ' (' + (item.match_level || 'Low') + ')</span>',
                            '<a href="' + base_url + 'members/kyc_detail/' + item.id + '" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a>'
                        ]).draw(false);
                    });
                } else {
                    swal("Info", "No matches found.", "info");
                }
            },
            error: function() {
                swal("Error!", "An error occurred during KYC search.", "error");
            },
            complete: function() {
                $('#form_kyc_search button[type="submit"]').prop('disabled', false).html('<i class="fa fa-search"></i> Search');
            }
        });
    });

});
</script>
