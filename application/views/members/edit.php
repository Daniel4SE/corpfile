<!-- Page Title -->
<div class="page-title">
    <div class="title_left">
        <h3><?php echo $page_title; ?></h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?php echo site_url('members/view_member/' . $member->id); ?>" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
            <a href="<?php echo site_url('members'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to List</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">

                <form id="form_edit_member" action="<?php echo site_url('members/edit_member/' . $member->id); ?>" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left" novalidate>
                    <input type="hidden" name="ci_csrf_token" value="<?php echo $csrf_token ?? ''; ?>" />
                    <input type="hidden" name="member_id" value="<?php echo $member->id; ?>" />

                    <!-- ============================================================ -->
                    <!-- SECTION 1: Personal Information -->
                    <!-- ============================================================ -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-section-title" style="background:#206570;color:#fff;padding:10px 15px;margin:0 0 20px 0;border-radius:3px;">
                                <span style="font-size:16px;font-weight:bold;"><i class="fa fa-user"></i> Personal Information</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Name Initials <span class="text-danger">*</span></label>
                                <select name="name_initials" class="form-control" required>
                                    <option value="">Select</option>
                                    <?php
                                    $initials_options = array('Mr', 'Mrs', 'Ms', 'Mdm', 'Dr');
                                    foreach ($initials_options as $opt): ?>
                                        <option value="<?php echo $opt; ?>" <?php echo (!empty($member->name_initials) && $member->name_initials == $opt) ? 'selected' : ''; ?>><?php echo $opt; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Full Name" value="<?php echo htmlspecialchars($member->name); ?>" required />
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Former Name</label>
                                <input type="text" name="former_name" class="form-control" placeholder="Former Name (if any)" value="<?php echo htmlspecialchars(!empty($member->former_name) ? $member->former_name : ''); ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Alias Name</label>
                                <input type="text" name="alias_name" class="form-control" placeholder="Alias Name" value="<?php echo htmlspecialchars(!empty($member->alias_name) ? $member->alias_name : ''); ?>" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Gender <span class="text-danger">*</span></label>
                                <select name="gender" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Male" <?php echo (!empty($member->gender) && $member->gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo (!empty($member->gender) && $member->gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Date of Birth <span class="text-danger">*</span></label>
                                <input type="text" name="date_of_birth" class="form-control datepicker" placeholder="DD/MM/YYYY" value="<?php echo !empty($member->date_of_birth) ? date('d/m/Y', strtotime($member->date_of_birth)) : ''; ?>" required autocomplete="off" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Country of Birth</label>
                                <select name="country_of_birth" class="form-control select2" style="width:100%;">
                                    <option value="">Select Country</option>
                                    <?php foreach ($countries as $country): ?>
                                        <option value="<?php echo htmlspecialchars($country); ?>" <?php echo (!empty($member->country_of_birth) && $member->country_of_birth == $country) ? 'selected' : ''; ?>><?php echo htmlspecialchars($country); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nationality <span class="text-danger">*</span></label>
                                <select name="nationality" class="form-control select2" style="width:100%;" required>
                                    <option value="">Select Nationality</option>
                                    <?php foreach ($countries as $country): ?>
                                        <option value="<?php echo htmlspecialchars($country); ?>" <?php echo (!empty($member->nationality) && $member->nationality == $country) ? 'selected' : ''; ?>><?php echo htmlspecialchars($country); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="">Select</option>
                                    <?php
                                    $status_options = array('Active', 'Ceased', 'Discharged', 'Deceased');
                                    foreach ($status_options as $opt): ?>
                                        <option value="<?php echo $opt; ?>" <?php echo (!empty($member->status) && $member->status == $opt) ? 'selected' : ''; ?>><?php echo $opt; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Race</label>
                                <select name="race" class="form-control select2" style="width:100%;">
                                    <option value="">Select Race</option>
                                    <?php
                                    $race_options = array('Chinese', 'Malay', 'Indian', 'Eurasian', 'Others');
                                    foreach ($race_options as $opt): ?>
                                        <option value="<?php echo $opt; ?>" <?php echo (!empty($member->race) && $member->race == $opt) ? 'selected' : ''; ?>><?php echo $opt; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Risk Assessment Rating</label>
                                <select name="risk_assessment_rating" class="form-control">
                                    <option value="">Select</option>
                                    <?php
                                    $risk_options = array('Low', 'Medium', 'High');
                                    foreach ($risk_options as $opt): ?>
                                        <option value="<?php echo $opt; ?>" <?php echo (!empty($member->risk_assessment_rating) && $member->risk_assessment_rating == $opt) ? 'selected' : ''; ?>><?php echo $opt; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Deceased Date</label>
                                <input type="text" name="deceased_date" class="form-control datepicker" placeholder="DD/MM/YYYY" value="<?php echo !empty($member->deceased_date) ? date('d/m/Y', strtotime($member->deceased_date)) : ''; ?>" autocomplete="off" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Additional Notes</label>
                                <textarea name="additional_notes" class="form-control" rows="3" placeholder="Additional notes..."><?php echo htmlspecialchars(!empty($member->additional_notes) ? $member->additional_notes : ''); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Resigning</label>
                                <select name="resigning" class="form-control">
                                    <option value="No" <?php echo (!empty($member->resigning) && $member->resigning == 'No') ? 'selected' : ''; ?>>No</option>
                                    <option value="Yes" <?php echo (!empty($member->resigning) && $member->resigning == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Father Name</label>
                                <input type="text" name="father_name" class="form-control" placeholder="Father's Name" value="<?php echo htmlspecialchars(!empty($member->father_name) ? $member->father_name : ''); ?>" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Mother Name</label>
                                <input type="text" name="mother_name" class="form-control" placeholder="Mother's Name" value="<?php echo htmlspecialchars(!empty($member->mother_name) ? $member->mother_name : ''); ?>" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Spouse Name</label>
                                <input type="text" name="spouse_name" class="form-control" placeholder="Spouse's Name" value="<?php echo htmlspecialchars(!empty($member->spouse_name) ? $member->spouse_name : ''); ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <!-- ============================================================ -->
                    <!-- SECTION 2: Identification -->
                    <!-- ============================================================ -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-section-title" style="background:#206570;color:#fff;padding:10px 15px;margin:0 0 20px 0;border-radius:3px;display:flex;align-items:center;justify-content:space-between;">
                                <span style="font-size:16px;font-weight:bold;"><i class="fa fa-id-card"></i> Identification</span>
                                <button type="button" class="btn btn-success btn-sm" id="btn_add_id"><i class="fa fa-plus"></i> Add Identification</button>
                            </div>
                        </div>
                    </div>

                    <div id="identification_container">
                        <?php if (!empty($identifications)):
                            foreach ($identifications as $idx => $ident): ?>
                            <div class="identification-row" data-index="<?php echo $idx; ?>">
                                <input type="hidden" name="identification[<?php echo $idx; ?>][existing_id]" value="<?php echo $ident->id; ?>" />
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>ID Type <span class="text-danger">*</span></label>
                                            <select name="identification[<?php echo $idx; ?>][id_type]" class="form-control select2_id_type" style="width:100%;" required>
                                                <option value="">Select Type</option>
                                                <?php
                                                $id_type_options = array('NRIC', 'Passport', 'FIN', 'Birth Certificate', 'Others');
                                                foreach ($id_type_options as $opt): ?>
                                                    <option value="<?php echo $opt; ?>" <?php echo ($ident->id_type == $opt) ? 'selected' : ''; ?>><?php echo $opt; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>ID Number <span class="text-danger">*</span></label>
                                            <input type="text" name="identification[<?php echo $idx; ?>][id_number]" class="form-control" placeholder="ID Number" value="<?php echo htmlspecialchars($ident->id_number); ?>" required />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Country of Issue</label>
                                            <select name="identification[<?php echo $idx; ?>][country_of_issue]" class="form-control select2_country" style="width:100%;">
                                                <option value="">Select Country</option>
                                                <?php foreach ($countries as $country): ?>
                                                    <option value="<?php echo htmlspecialchars($country); ?>" <?php echo (!empty($ident->country_of_issue) && $ident->country_of_issue == $country) ? 'selected' : ''; ?>><?php echo htmlspecialchars($country); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Issue Date</label>
                                            <input type="text" name="identification[<?php echo $idx; ?>][issue_date]" class="form-control datepicker" placeholder="DD/MM/YYYY" value="<?php echo !empty($ident->issue_date) ? date('d/m/Y', strtotime($ident->issue_date)) : ''; ?>" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Expiry Date</label>
                                            <input type="text" name="identification[<?php echo $idx; ?>][expiry_date]" class="form-control datepicker" placeholder="DD/MM/YYYY" value="<?php echo !empty($ident->expiry_date) ? date('d/m/Y', strtotime($ident->expiry_date)) : ''; ?>" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>File</label>
                                            <input type="file" name="identification[<?php echo $idx; ?>][file]" class="form-control" style="padding:3px;" />
                                            <?php if (!empty($ident->file_path)): ?>
                                                <small><a href="<?php echo base_url($ident->file_path); ?>" target="_blank"><i class="fa fa-file"></i> Current</a></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-sm btn-block btn_remove_id" style="margin-top:0;"><i class="fa fa-minus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="ln_solid" style="margin:5px 0 15px 0;"></div>
                            </div>
                        <?php endforeach;
                        else: ?>
                            <!-- Empty identification row if none exist -->
                            <div class="identification-row" data-index="0">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>ID Type <span class="text-danger">*</span></label>
                                            <select name="identification[0][id_type]" class="form-control select2_id_type" style="width:100%;" required>
                                                <option value="">Select Type</option>
                                                <option value="NRIC">NRIC</option>
                                                <option value="Passport">Passport</option>
                                                <option value="FIN">FIN</option>
                                                <option value="Birth Certificate">Birth Certificate</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>ID Number <span class="text-danger">*</span></label>
                                            <input type="text" name="identification[0][id_number]" class="form-control" placeholder="ID Number" required />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Country of Issue</label>
                                            <select name="identification[0][country_of_issue]" class="form-control select2_country" style="width:100%;">
                                                <option value="">Select Country</option>
                                                <?php foreach ($countries as $country): ?>
                                                    <option value="<?php echo htmlspecialchars($country); ?>"><?php echo htmlspecialchars($country); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Issue Date</label>
                                            <input type="text" name="identification[0][issue_date]" class="form-control datepicker" placeholder="DD/MM/YYYY" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Expiry Date</label>
                                            <input type="text" name="identification[0][expiry_date]" class="form-control datepicker" placeholder="DD/MM/YYYY" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>File</label>
                                            <input type="file" name="identification[0][file]" class="form-control" style="padding:3px;" />
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-sm btn-block btn_remove_id" style="margin-top:0;"><i class="fa fa-minus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="ln_solid" style="margin:5px 0 15px 0;"></div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="ln_solid"></div>

                    <!-- ============================================================ -->
                    <!-- SECTION 3: Registered Address -->
                    <!-- ============================================================ -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-section-title" style="background:#206570;color:#fff;padding:10px 15px;margin:0 0 20px 0;border-radius:3px;">
                                <span style="font-size:16px;font-weight:bold;"><i class="fa fa-map-marker"></i> Registered Address</span>
                            </div>
                        </div>
                    </div>

                    <?php
                    // Find the registered address from addresses array
                    $reg_address = null;
                    $other_addresses = array();
                    if (!empty($addresses)) {
                        foreach ($addresses as $addr) {
                            if (!empty($addr->address_type) && $addr->address_type == 'Registered') {
                                $reg_address = $addr;
                            } else {
                                $other_addresses[] = $addr;
                            }
                        }
                        // If no address is explicitly 'Registered', use the first one
                        if ($reg_address === null && !empty($addresses)) {
                            $reg_address = $addresses[0];
                            $other_addresses = array_slice($addresses, 1);
                        }
                    }
                    ?>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Block</label>
                                <input type="text" name="reg_block" class="form-control" placeholder="Block" value="<?php echo htmlspecialchars(!empty($reg_address->block) ? $reg_address->block : ''); ?>" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Street / Address <span class="text-danger">*</span></label>
                                <textarea name="reg_street" class="form-control" rows="2" placeholder="Street / Address" required><?php echo htmlspecialchars(!empty($reg_address->address_text) ? $reg_address->address_text : (!empty($reg_address->street) ? $reg_address->street : '')); ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Building</label>
                                <input type="text" name="reg_building" class="form-control" placeholder="Building Name" value="<?php echo htmlspecialchars(!empty($reg_address->building) ? $reg_address->building : ''); ?>" />
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Level</label>
                                <input type="text" name="reg_level" class="form-control" placeholder="Level" value="<?php echo htmlspecialchars(!empty($reg_address->level) ? $reg_address->level : ''); ?>" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Unit</label>
                                <input type="text" name="reg_unit" class="form-control" placeholder="Unit" value="<?php echo htmlspecialchars(!empty($reg_address->unit) ? $reg_address->unit : ''); ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Country <span class="text-danger">*</span></label>
                                <select name="reg_country" class="form-control select2" style="width:100%;" required>
                                    <option value="">Select Country</option>
                                    <?php foreach ($countries as $country): ?>
                                        <option value="<?php echo htmlspecialchars($country); ?>" <?php echo (!empty($reg_address->country) && $reg_address->country == $country) ? 'selected' : ''; ?>><?php echo htmlspecialchars($country); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>State</label>
                                <input type="text" name="reg_state" class="form-control" placeholder="State" value="<?php echo htmlspecialchars(!empty($reg_address->state) ? $reg_address->state : ''); ?>" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="reg_city" class="form-control" placeholder="City" value="<?php echo htmlspecialchars(!empty($reg_address->city) ? $reg_address->city : ''); ?>" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Postal Code <span class="text-danger">*</span></label>
                                <input type="text" name="reg_postal_code" class="form-control" placeholder="Postal Code" value="<?php echo htmlspecialchars(!empty($reg_address->postal_code) ? $reg_address->postal_code : ''); ?>" required />
                            </div>
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <!-- Other Addresses -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-section-title" style="background:#206570;color:#fff;padding:10px 15px;margin:0 0 20px 0;border-radius:3px;display:flex;align-items:center;justify-content:space-between;">
                                <span style="font-size:16px;font-weight:bold;"><i class="fa fa-map"></i> Other Addresses</span>
                                <button type="button" class="btn btn-success btn-sm" id="btn_add_address"><i class="fa fa-plus"></i> Add Address</button>
                            </div>
                        </div>
                    </div>

                    <div id="address_container">
                        <?php if (!empty($other_addresses)):
                            foreach ($other_addresses as $addr_idx => $addr): ?>
                            <div class="address-row" data-index="<?php echo $addr_idx; ?>">
                                <input type="hidden" name="other_address[<?php echo $addr_idx; ?>][existing_id]" value="<?php echo $addr->id; ?>" />
                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Address Type</label>
                                                    <select name="other_address[<?php echo $addr_idx; ?>][address_type]" class="form-control">
                                                        <?php
                                                        $addr_type_options = array('Local', 'Foreign', 'Alternative Local', 'Alternative Foreign');
                                                        foreach ($addr_type_options as $opt): ?>
                                                            <option value="<?php echo $opt; ?>" <?php echo (!empty($addr->address_type) && $addr->address_type == $opt) ? 'selected' : ''; ?>><?php echo $opt; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Block</label>
                                                    <input type="text" name="other_address[<?php echo $addr_idx; ?>][block]" class="form-control" placeholder="Block" value="<?php echo htmlspecialchars(!empty($addr->block) ? $addr->block : ''); ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Street / Address</label>
                                                    <textarea name="other_address[<?php echo $addr_idx; ?>][street]" class="form-control" rows="2" placeholder="Street / Address"><?php echo htmlspecialchars(!empty($addr->address_text) ? $addr->address_text : (!empty($addr->street) ? $addr->street : '')); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Building</label>
                                                    <input type="text" name="other_address[<?php echo $addr_idx; ?>][building]" class="form-control" placeholder="Building Name" value="<?php echo htmlspecialchars(!empty($addr->building) ? $addr->building : ''); ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label>Level</label>
                                                    <input type="text" name="other_address[<?php echo $addr_idx; ?>][level]" class="form-control" placeholder="Level" value="<?php echo htmlspecialchars(!empty($addr->level) ? $addr->level : ''); ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Unit</label>
                                                    <input type="text" name="other_address[<?php echo $addr_idx; ?>][unit]" class="form-control" placeholder="Unit" value="<?php echo htmlspecialchars(!empty($addr->unit) ? $addr->unit : ''); ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <select name="other_address[<?php echo $addr_idx; ?>][country]" class="form-control select2_clone" style="width:100%;">
                                                        <option value="">Select Country</option>
                                                        <?php foreach ($countries as $country): ?>
                                                            <option value="<?php echo htmlspecialchars($country); ?>" <?php echo (!empty($addr->country) && $addr->country == $country) ? 'selected' : ''; ?>><?php echo htmlspecialchars($country); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>State</label>
                                                    <input type="text" name="other_address[<?php echo $addr_idx; ?>][state]" class="form-control" placeholder="State" value="<?php echo htmlspecialchars(!empty($addr->state) ? $addr->state : ''); ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <input type="text" name="other_address[<?php echo $addr_idx; ?>][city]" class="form-control" placeholder="City" value="<?php echo htmlspecialchars(!empty($addr->city) ? $addr->city : ''); ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Postal Code</label>
                                                    <input type="text" name="other_address[<?php echo $addr_idx; ?>][postal_code]" class="form-control" placeholder="Postal Code" value="<?php echo htmlspecialchars(!empty($addr->postal_code) ? $addr->postal_code : ''); ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-sm btn-block btn_remove_address"><i class="fa fa-minus"></i> Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="ln_solid" style="margin:5px 0 15px 0;"></div>
                            </div>
                        <?php endforeach;
                        endif; ?>
                    </div>

                    <div class="ln_solid"></div>

                    <!-- ============================================================ -->
                    <!-- SECTION 4: Contact Information -->
                    <!-- ============================================================ -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-section-title" style="background:#206570;color:#fff;padding:10px 15px;margin:0 0 20px 0;border-radius:3px;">
                                <span style="font-size:16px;font-weight:bold;"><i class="fa fa-phone"></i> Contact Information</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Preferred Contact Mode</label>
                                <select name="preferred_contact_mode" class="form-control select2" style="width:100%;">
                                    <option value="">Select</option>
                                    <?php
                                    $contact_modes = array('Email', 'Phone', 'Post');
                                    foreach ($contact_modes as $opt): ?>
                                        <option value="<?php echo $opt; ?>" <?php echo (!empty($member->preferred_contact_mode) && $member->preferred_contact_mode == $opt) ? 'selected' : ''; ?>><?php echo $opt; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Email Address" value="<?php echo htmlspecialchars(!empty($member->email) ? $member->email : ''); ?>" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Alternate Email</label>
                                <input type="email" name="alternate_email" class="form-control" placeholder="Alternate Email Address" value="<?php echo htmlspecialchars(!empty($member->alternate_email) ? $member->alternate_email : ''); ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>WhatsApp</label>
                                <input type="text" name="skype_id" class="form-control" placeholder="WhatsApp Number" value="<?php echo htmlspecialchars(!empty($member->skype_id) ? $member->skype_id : ''); ?>" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Services to Contact</label>
                                <?php
                                $selected_services = !empty($member->services_to_contact) ? explode(',', $member->services_to_contact) : array();
                                $selected_services = array_map('trim', $selected_services);
                                ?>
                                <select name="services_to_contact[]" class="form-control select2" style="width:100%;" multiple>
                                    <?php
                                    $service_options = array('Corporate Secretarial', 'Accounting', 'Tax', 'Payroll', 'Immigration', 'Advisory');
                                    foreach ($service_options as $opt): ?>
                                        <option value="<?php echo $opt; ?>" <?php echo in_array($opt, $selected_services) ? 'selected' : ''; ?>><?php echo $opt; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <?php
                    $phone_codes = array('+65', '+60', '+62', '+63', '+66', '+84', '+91', '+86', '+852', '+81', '+82', '+44', '+1', '+61');
                    ?>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Mobile Number</label>
                                <div class="input-group">
                                    <select name="mobile_code" class="form-control select2_phone_code" style="width:100px;">
                                        <?php foreach ($phone_codes as $code): ?>
                                            <option value="<?php echo $code; ?>" <?php echo (!empty($member->mobile_code) && $member->mobile_code == $code) ? 'selected' : ($code == '+65' && empty($member->mobile_code) ? 'selected' : ''); ?>><?php echo $code; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="text" name="mobile_number" class="form-control" placeholder="Mobile Number" value="<?php echo htmlspecialchars(!empty($member->mobile_number) ? $member->mobile_number : ''); ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Telephone Number</label>
                                <div class="input-group">
                                    <select name="telephone_code" class="form-control select2_phone_code" style="width:100px;">
                                        <?php foreach ($phone_codes as $code): ?>
                                            <option value="<?php echo $code; ?>" <?php echo (!empty($member->telephone_code) && $member->telephone_code == $code) ? 'selected' : ($code == '+65' && empty($member->telephone_code) ? 'selected' : ''); ?>><?php echo $code; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="text" name="telephone_number" class="form-control" placeholder="Telephone Number" value="<?php echo htmlspecialchars(!empty($member->telephone_number) ? $member->telephone_number : ''); ?>" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <!-- Submit -->
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="<?php echo site_url('members/view_member/' . $member->id); ?>" class="btn btn-default btn-lg"><i class="fa fa-times"></i> Cancel</a>
                            <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> Update Individual</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<!-- Address Row Template (hidden) -->
<script type="text/html" id="address_row_template">
    <div class="address-row" data-index="{index}">
        <div class="row">
            <div class="col-md-11">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Address Type</label>
                            <select name="other_address[{index}][address_type]" class="form-control">
                                <option value="Local">Local</option>
                                <option value="Foreign">Foreign</option>
                                <option value="Alternative Local">Alternative Local</option>
                                <option value="Alternative Foreign">Alternative Foreign</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Block</label>
                            <input type="text" name="other_address[{index}][block]" class="form-control" placeholder="Block" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Street / Address</label>
                            <textarea name="other_address[{index}][street]" class="form-control" rows="2" placeholder="Street / Address"></textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Building</label>
                            <input type="text" name="other_address[{index}][building]" class="form-control" placeholder="Building Name" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>Level</label>
                            <input type="text" name="other_address[{index}][level]" class="form-control" placeholder="Level" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Unit</label>
                            <input type="text" name="other_address[{index}][unit]" class="form-control" placeholder="Unit" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Country</label>
                            <select name="other_address[{index}][country]" class="form-control select2_clone" style="width:100%;">
                                <option value="">Select Country</option>
                                <?php foreach ($countries as $country): ?>
                                    <option value="<?php echo htmlspecialchars($country); ?>"><?php echo htmlspecialchars($country); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" name="other_address[{index}][state]" class="form-control" placeholder="State" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="other_address[{index}][city]" class="form-control" placeholder="City" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Postal Code</label>
                            <input type="text" name="other_address[{index}][postal_code]" class="form-control" placeholder="Postal Code" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-sm btn-block btn_remove_address"><i class="fa fa-minus"></i> Remove</button>
                </div>
            </div>
        </div>
        <div class="ln_solid" style="margin:5px 0 15px 0;"></div>
    </div>
</script>

<script>
$(document).ready(function() {

    // =============================================
    // Select2 Initialization
    // =============================================
    $('.select2').select2({
        allowClear: true,
        placeholder: function() {
            return $(this).find('option:first').text();
        }
    });

    $('.select2_id_type').select2({
        allowClear: true,
        placeholder: 'Select Type'
    });

    $('.select2_country').select2({
        allowClear: true,
        placeholder: 'Select Country'
    });

    $('.select2_clone').select2({
        allowClear: true,
        placeholder: 'Select Country'
    });

    $('.select2_phone_code').select2({
        minimumResultsForSearch: Infinity,
        width: '100px'
    });

    // =============================================
    // Datepicker Initialization
    // =============================================
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true
    });

    // =============================================
    // Identification Row - Clone / Remove
    // =============================================
    var idIndex = <?php echo !empty($identifications) ? count($identifications) : 1; ?>;

    $('#btn_add_id').on('click', function() {
        var template = $('#identification_container .identification-row:first').clone();

        // Update field names with new index
        template.attr('data-index', idIndex);
        template.find('input, select').each(function() {
            var name = $(this).attr('name');
            if (name) {
                $(this).attr('name', name.replace(/\[\d+\]/, '[' + idIndex + ']'));
            }
        });

        // Clear values and remove existing_id hidden field
        template.find('input[type="text"], input[type="file"]').val('');
        template.find('input[type="hidden"]').remove();
        template.find('select').val('').trigger('change');
        template.find('small').remove(); // Remove "Current file" links

        // Destroy and reinit select2
        template.find('.select2_id_type').select2('destroy');
        template.find('.select2_country').select2('destroy');

        $('#identification_container').append(template);

        // Reinitialize Select2 on cloned elements
        template.find('.select2_id_type').select2({
            allowClear: true,
            placeholder: 'Select Type'
        });
        template.find('.select2_country').select2({
            allowClear: true,
            placeholder: 'Select Country'
        });

        // Reinitialize datepicker on cloned elements
        template.find('.datepicker').datepicker('destroy');
        template.find('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            todayHighlight: true
        });

        idIndex++;
    });

    $(document).on('click', '.btn_remove_id', function() {
        if ($('#identification_container .identification-row').length > 1) {
            $(this).closest('.identification-row').remove();
        } else {
            swal("Warning", "At least one identification record is required.", "warning");
        }
    });

    // =============================================
    // Address Row - Clone / Remove
    // =============================================
    var addressIndex = <?php echo !empty($other_addresses) ? count($other_addresses) : 0; ?>;

    $('#btn_add_address').on('click', function() {
        var html = $('#address_row_template').html().replace(/\{index\}/g, addressIndex);
        $('#address_container').append(html);

        // Initialize Select2 on newly added selects
        var newRow = $('#address_container .address-row:last');
        newRow.find('.select2_clone').select2({
            allowClear: true,
            placeholder: 'Select Country'
        });

        addressIndex++;
    });

    $(document).on('click', '.btn_remove_address', function() {
        $(this).closest('.address-row').remove();
    });

    // =============================================
    // Form Validation
    // =============================================
    $('#form_edit_member').on('submit', function(e) {
        var isValid = true;
        var firstError = null;

        // Check required fields
        $(this).find('[required]').each(function() {
            var $field = $(this);
            var value = $field.val();

            // Remove previous error styling
            $field.closest('.form-group').removeClass('has-error');

            if (!value || value === '') {
                isValid = false;
                $field.closest('.form-group').addClass('has-error');
                if (!firstError) {
                    firstError = $field;
                }
            }
        });

        // Validate email format
        var email = $('input[name="email"]').val();
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            isValid = false;
            $('input[name="email"]').closest('.form-group').addClass('has-error');
            if (!firstError) {
                firstError = $('input[name="email"]');
            }
        }

        if (!isValid) {
            e.preventDefault();
            if (firstError) {
                $('html, body').animate({
                    scrollTop: firstError.offset().top - 100
                }, 500);
            }
            swal("Validation Error", "Please fill in all required fields highlighted in red.", "error");
            return false;
        }
    });

    // Remove error styling on field change
    $(document).on('change keyup', '.has-error input, .has-error select, .has-error textarea', function() {
        if ($(this).val()) {
            $(this).closest('.form-group').removeClass('has-error');
        }
    });

});
</script>
