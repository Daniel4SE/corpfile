<!-- Reusable Add Officer Form -->
<?php
    $type = $officer_type ?? 'director';
    $type_label = ucwords(str_replace('_', ' ', $type));
    
    // Determine form action URL
    $form_actions = [
        'director' => "add_director/{$company_id}",
        'shareholder' => "add_shareholder/{$company_id}",
        'secretary' => "add_secretary/{$company_id}",
        'auditor' => "add_auditor/{$company_id}",
        'representative' => "add_representative/{$company_id}",
        'manager' => "add_manager/{$company_id}",
        'ceo' => "add_ceo/{$company_id}",
    ];
    $form_action = base_url($form_actions[$type] ?? "add_representative/{$company_id}");
    
    // Which field groups to show
    $show_id_fields = !in_array($type, ['auditor']);
    $show_address_fields = !in_array($type, ['auditor']);
    $show_contact_fields = !in_array($type, ['auditor']);
    $show_dob_field = !in_array($type, ['auditor']);
    $show_director_fields = ($type === 'director');
    $show_shareholder_fields = ($type === 'shareholder');
    $show_auditor_fields = ($type === 'auditor');
    $show_company_contact = ($type === 'director');
?>

<div class="page-title">
    <div class="title_left">
        <h3>Add <?= $type_label ?> - <?= htmlspecialchars($company->company_name ?? '') ?></h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url("officials_list/{$company_id}") ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Officials</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Add <?= $type_label ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="POST" action="<?= $form_action ?>" class="form-horizontal form-label-left" id="addOfficerForm">
                    <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">
                    <input type="hidden" name="officer_type" value="<?= $type ?>">

                    <?php if ($show_shareholder_fields): ?>
                    <!-- ===== Shareholder Type ===== -->
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Shareholder Type <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="shareholder_type" id="shareholder_type" class="form-control" onchange="toggleShareholderType(this.value)">
                                <option value="Individual">Individual</option>
                                <option value="Corporate">Corporate</option>
                            </select>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <?php endif; ?>

                    <?php if ($show_auditor_fields): ?>
                    <!-- ===== Auditor-Specific Fields ===== -->
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Firm Name <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="firm_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Auditor Name <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Date of Appointment</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="date_of_appointment" class="form-control datepicker">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Date of Cessation</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="date_of_cessation" class="form-control datepicker">
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- ===== Individual / Common Fields ===== -->
                    <div id="individual_fields" <?php if ($show_auditor_fields): ?>style="display:none;"<?php endif; ?>>

                        <?php if ($show_id_fields): ?>
                        <!-- ID Section -->
                        <h4 style="color:#206570;"><i class="fa fa-id-card"></i> Identification</h4>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">ID Type</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="id_type" class="form-control">
                                    <option value="">Select ID Type</option>
                                    <option value="NRIC">NRIC</option>
                                    <option value="FIN">FIN</option>
                                    <option value="Passport">Passport</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">ID Expiry Date</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="id_expiry_date" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">NRIC / Passport No.</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="id_number" class="form-control">
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Name -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>

                        <!-- Nationality -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nationality</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="nationality" class="form-control select2">
                                    <option value="">Select Nationality</option>
                                    <?php foreach ($countries ?? [] as $c): ?>
                                    <option value="<?= $c ?>" <?= $c === 'SINGAPORE' ? 'selected' : '' ?>><?= $c ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <?php if ($show_address_fields): ?>
                        <div class="ln_solid"></div>
                        <!-- Address Section -->
                        <h4 style="color:#206570;"><i class="fa fa-map-marker"></i> Address</h4>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Local Address</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="local_address" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Foreign Address</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="foreign_address" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <?php if ($show_director_fields): ?>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Alt Local Address</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="alt_local_address" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Alt Foreign Address</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="alt_foreign_address" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($show_contact_fields): ?>
                        <div class="ln_solid"></div>
                        <!-- Contact Section -->
                        <h4 style="color:#206570;"><i class="fa fa-envelope"></i> Contact</h4>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="email" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Contact Number</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="contact_number" class="form-control">
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($show_dob_field): ?>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Date of Birth</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="date_of_birth" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($show_director_fields): ?>
                        <div class="ln_solid"></div>
                        <!-- Director-Specific Fields -->
                        <h4 style="color:#206570;"><i class="fa fa-briefcase"></i> Director Details</h4>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Business Occupation</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="business_occupation" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Other Directorship</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="other_directorship" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nominee Director</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label class="radio-inline"><input type="radio" name="nominee_director" value="Yes"> Yes</label>
                                <label class="radio-inline"><input type="radio" name="nominee_director" value="No" checked> No</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Registrable Controller</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label class="radio-inline"><input type="radio" name="registrable_controller" value="Yes"> Yes</label>
                                <label class="radio-inline"><input type="radio" name="registrable_controller" value="No" checked> No</label>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="ln_solid"></div>
                        <!-- Appointment Section -->
                        <h4 style="color:#206570;"><i class="fa fa-calendar"></i> Appointment</h4>
                        
                        <?php if ($show_director_fields): ?>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Appointment Type</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label class="radio-inline"><input type="radio" name="appointment_type" value="Proposed"> Proposed</label>
                                <label class="radio-inline"><input type="radio" name="appointment_type" value="Effective" checked> Effective</label>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Date of Appointment</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="date_of_appointment" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Date of Cessation</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="date_of_cessation" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <?php if ($show_company_contact): ?>
                        <div class="ln_solid"></div>
                        <!-- Company Contact (Director only) -->
                        <h4 style="color:#206570;"><i class="fa fa-phone"></i> Company Contact</h4>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Company Email</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="email" name="company_email" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Company Contact</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="text" name="company_contact_code" class="form-control" placeholder="Code" value="65">
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="company_contact_number" class="form-control" placeholder="Number">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Company Telephone</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="text" name="company_telephone_code" class="form-control" placeholder="Code" value="65">
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="company_telephone_number" class="form-control" placeholder="Number">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div>
                    <!-- End individual_fields -->

                    <?php if ($show_shareholder_fields): ?>
                    <!-- ===== Corporate Shareholder Fields ===== -->
                    <div id="corporate_fields" style="display:none;">
                        <h4 style="color:#206570;"><i class="fa fa-building"></i> Corporate Shareholder Details</h4>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Registration No.</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="corp_registration_no" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Company Name</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="corp_company_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Company Type</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="corp_company_type" class="form-control">
                                    <option value="">Select Type</option>
                                    <option value="Private Limited">Private Limited</option>
                                    <option value="Public Limited">Public Limited</option>
                                    <option value="LLP">LLP</option>
                                    <option value="Partnership">Partnership</option>
                                    <option value="Sole Proprietor">Sole Proprietor</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Reg Office Address</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="corp_reg_office_address" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Incorporation Date</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="corp_incorp_date" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Country</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="corp_country" class="form-control select2">
                                    <option value="">Select Country</option>
                                    <?php foreach ($countries ?? [] as $c): ?>
                                    <option value="<?= $c ?>" <?= $c === 'SINGAPORE' ? 'selected' : '' ?>><?= $c ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="corp_status" class="form-control">
                                    <option value="Active">Active</option>
                                    <option value="Struck Off">Struck Off</option>
                                    <option value="Dissolved">Dissolved</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                        </div>

                        <!-- Corporate shareholder also needs Name and appointment -->
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Name (for record) <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="name" class="form-control" id="corp_name_field">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Date of Appointment</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="date_of_appointment" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Date of Cessation</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="date_of_cessation" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End corporate_fields -->
                    <?php endif; ?>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <a href="<?= base_url("officials_list/{$company_id}") ?>" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save <?= $type_label ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize datepickers
    if ($.fn.daterangepicker) {
        $('.datepicker').daterangepicker({
            singleDatePicker: true,
            autoApply: true,
            locale: { format: 'DD/MM/YYYY' }
        });
        $('.datepicker').val('');
    }
    // Initialize select2
    if ($.fn.select2) {
        $('.select2').select2();
    }
});

<?php if ($show_shareholder_fields): ?>
function toggleShareholderType(type) {
    if (type === 'Corporate') {
        document.getElementById('individual_fields').style.display = 'none';
        document.getElementById('corporate_fields').style.display = 'block';
        // Auto-fill name from company name
        var corpName = document.querySelector('input[name="corp_company_name"]');
        if (corpName) {
            corpName.addEventListener('blur', function() {
                var nameField = document.getElementById('corp_name_field');
                if (nameField && !nameField.value) nameField.value = this.value;
            });
        }
    } else {
        document.getElementById('individual_fields').style.display = 'block';
        document.getElementById('corporate_fields').style.display = 'none';
    }
}
<?php endif; ?>
</script>
