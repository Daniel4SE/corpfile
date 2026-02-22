<!-- Page Title -->
<div class="page-title">
    <div class="title_left">
        <h3><?php echo $page_title; ?></h3>
    </div>
    <div class="title_right">
        <a href="<?php echo site_url('members'); ?>" class="btn btn-default pull-right"><i class="fa fa-arrow-left"></i> Back to List</a>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">

                <form id="form_add_member" action="<?php echo site_url('members/add_member'); ?>" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left" novalidate>
                    <input type="hidden" name="ci_csrf_token" value="<?php echo $csrf_token ?? ''; ?>" />

                    <!-- ============================================================ -->
                    <!-- SECTION 1: Personal Information -->
                    <!-- ============================================================ -->
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="form-section-title" style="background:#206570;color:#fff;padding:10px 15px;margin:0 0 20px 0;border-radius:3px;">
                                <i class="fa fa-user"></i> Personal Information
                            </h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Name Initials <span class="text-danger">*</span></label>
                                <select name="name_initials" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Mr">Mr</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Mdm">Mdm</option>
                                    <option value="Dr">Dr</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Full Name" required />
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Former Name</label>
                                <input type="text" name="former_name" class="form-control" placeholder="Former Name (if any)" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Alias Name</label>
                                <input type="text" name="alias_name" class="form-control" placeholder="Alias Name" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Gender <span class="text-danger">*</span></label>
                                <select name="gender" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Date of Birth <span class="text-danger">*</span></label>
                                <input type="text" name="date_of_birth" class="form-control datepicker" placeholder="DD/MM/YYYY" required autocomplete="off" />
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
                                        <option value="<?php echo htmlspecialchars($country); ?>"><?php echo htmlspecialchars($country); ?></option>
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
                                        <option value="<?php echo htmlspecialchars($country); ?>"><?php echo htmlspecialchars($country); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Active">Active</option>
                                    <option value="Ceased">Ceased</option>
                                    <option value="Discharged">Discharged</option>
                                    <option value="Deceased">Deceased</option>
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
                                    <option value="Chinese">Chinese</option>
                                    <option value="Malay">Malay</option>
                                    <option value="Indian">Indian</option>
                                    <option value="Eurasian">Eurasian</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Risk Assessment Rating</label>
                                <select name="risk_assessment_rating" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Deceased Date</label>
                                <input type="text" name="deceased_date" class="form-control datepicker" placeholder="DD/MM/YYYY" autocomplete="off" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Additional Notes</label>
                                <textarea name="additional_notes" class="form-control" rows="3" placeholder="Additional notes..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Resigning</label>
                                <select name="resigning" class="form-control">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Father Name</label>
                                <input type="text" name="father_name" class="form-control" placeholder="Father's Name" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Mother Name</label>
                                <input type="text" name="mother_name" class="form-control" placeholder="Mother's Name" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Spouse Name</label>
                                <input type="text" name="spouse_name" class="form-control" placeholder="Spouse's Name" />
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
                    </div>

                    <div class="ln_solid"></div>

                    <!-- ============================================================ -->
                    <!-- SECTION 3: Address -->
                    <!-- ============================================================ -->
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="form-section-title" style="background:#206570;color:#fff;padding:10px 15px;margin:0 0 20px 0;border-radius:3px;">
                                <i class="fa fa-map-marker"></i> Registered Address
                            </h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Block</label>
                                <input type="text" name="reg_block" class="form-control" placeholder="Block" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Street / Address <span class="text-danger">*</span></label>
                                <textarea name="reg_street" class="form-control" rows="2" placeholder="Street / Address" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Building</label>
                                <input type="text" name="reg_building" class="form-control" placeholder="Building Name" />
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Level</label>
                                <input type="text" name="reg_level" class="form-control" placeholder="Level" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Unit</label>
                                <input type="text" name="reg_unit" class="form-control" placeholder="Unit" />
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
                                        <option value="<?php echo htmlspecialchars($country); ?>"><?php echo htmlspecialchars($country); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>State</label>
                                <input type="text" name="reg_state" class="form-control" placeholder="State" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="reg_city" class="form-control" placeholder="City" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Postal Code <span class="text-danger">*</span></label>
                                <input type="text" name="reg_postal_code" class="form-control" placeholder="Postal Code" required />
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
                        <!-- Clonable address rows will be appended here -->
                    </div>

                    <div class="ln_solid"></div>

                    <!-- ============================================================ -->
                    <!-- SECTION 4: Contact Information -->
                    <!-- ============================================================ -->
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="form-section-title" style="background:#206570;color:#fff;padding:10px 15px;margin:0 0 20px 0;border-radius:3px;">
                                <i class="fa fa-phone"></i> Contact Information
                            </h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Preferred Contact Mode</label>
                                <select name="preferred_contact_mode" class="form-control select2" style="width:100%;">
                                    <option value="">Select</option>
                                    <option value="Email">Email</option>
                                    <option value="Phone">Phone</option>
                                    <option value="Post">Post</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Email Address" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Alternate Email</label>
                                <input type="email" name="alternate_email" class="form-control" placeholder="Alternate Email Address" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>WhatsApp</label>
                                <input type="text" name="skype_id" class="form-control" placeholder="WhatsApp Number" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Services to Contact</label>
                                <select name="services_to_contact[]" class="form-control select2" style="width:100%;" multiple>
                                    <option value="Corporate Secretarial">Corporate Secretarial</option>
                                    <option value="Accounting">Accounting</option>
                                    <option value="Tax">Tax</option>
                                    <option value="Payroll">Payroll</option>
                                    <option value="Immigration">Immigration</option>
                                    <option value="Advisory">Advisory</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Mobile Number</label>
                                <div class="input-group">
                                    <select name="mobile_code" class="form-control select2_phone_code" style="width:100px;">
                                        <option value="+65" selected>+65</option>
                                        <option value="+60">+60</option>
                                        <option value="+62">+62</option>
                                        <option value="+63">+63</option>
                                        <option value="+66">+66</option>
                                        <option value="+84">+84</option>
                                        <option value="+91">+91</option>
                                        <option value="+86">+86</option>
                                        <option value="+852">+852</option>
                                        <option value="+81">+81</option>
                                        <option value="+82">+82</option>
                                        <option value="+44">+44</option>
                                        <option value="+1">+1</option>
                                        <option value="+61">+61</option>
                                    </select>
                                    <input type="text" name="mobile_number" class="form-control" placeholder="Mobile Number" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Telephone Number</label>
                                <div class="input-group">
                                    <select name="telephone_code" class="form-control select2_phone_code" style="width:100px;">
                                        <option value="+65" selected>+65</option>
                                        <option value="+60">+60</option>
                                        <option value="+62">+62</option>
                                        <option value="+63">+63</option>
                                        <option value="+66">+66</option>
                                        <option value="+84">+84</option>
                                        <option value="+91">+91</option>
                                        <option value="+86">+86</option>
                                        <option value="+852">+852</option>
                                        <option value="+81">+81</option>
                                        <option value="+82">+82</option>
                                        <option value="+44">+44</option>
                                        <option value="+1">+1</option>
                                        <option value="+61">+61</option>
                                    </select>
                                    <input type="text" name="telephone_number" class="form-control" placeholder="Telephone Number" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <!-- Submit -->
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="<?php echo site_url('members'); ?>" class="btn btn-default btn-lg"><i class="fa fa-times"></i> Cancel</a>
                            <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> Save Individual</button>
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
        todayHighlight: true,
        endDate: '+0d'
    });

    // =============================================
    // Identification Row - Clone / Remove
    // =============================================
    var idIndex = 1;

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

        // Clear values
        template.find('input[type="text"], input[type="file"]').val('');
        template.find('select').val('').trigger('change');

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
    var addressIndex = 0;

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
    $('#form_add_member').on('submit', function(e) {
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
