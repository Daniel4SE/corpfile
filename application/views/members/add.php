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
                <form id="form_add_member" action="<?php echo site_url('members/add_member'); ?>" method="POST" class="form-horizontal form-label-left" novalidate>
                    <input type="hidden" name="ci_csrf_token" value="<?php echo $csrf_token ?? ''; ?>" />

                    <div class="form-section-title" style="background:#206570;color:#fff;padding:10px 15px;margin:0 0 20px 0;border-radius:3px;"><i class="fa fa-user"></i> Personal Info</div>
                    <div class="row">
                        <div class="col-md-2"><div class="form-group"><label>Name Initials</label><select name="name_initials" class="form-control"><option value="">Select</option><option value="Mr">Mr</option><option value="Mrs">Mrs</option><option value="Ms">Ms</option><option value="Mdm">Mdm</option><option value="Dr">Dr</option></select></div></div>
                        <div class="col-md-4"><div class="form-group"><label>Individual Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" required /></div></div>
                        <div class="col-md-3"><div class="form-group"><label>Gender</label><select name="gender" class="form-control"><option value="">Select</option><option value="Male">Male</option><option value="Female">Female</option></select></div></div>
                        <div class="col-md-3"><div class="form-group"><label>Date of Birth</label><input type="text" name="date_of_birth" class="form-control datepicker" placeholder="DD/MM/YYYY" autocomplete="off" /></div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><div class="form-group"><label>Alias</label><input type="text" name="alias_name" class="form-control" /></div></div>
                        <div class="col-md-4"><div class="form-group"><label>Country of Birth</label><select name="country_of_birth" class="form-control select2"><option value="">Select Country</option><?php foreach ($countries as $country): ?><option value="<?php echo htmlspecialchars($country); ?>"><?php echo htmlspecialchars($country); ?></option><?php endforeach; ?></select></div></div>
                        <div class="col-md-4"><div class="form-group"><label>Nationality</label><select name="nationality" class="form-control select2"><option value="">Select Nationality</option><?php foreach ($countries as $country): ?><option value="<?php echo htmlspecialchars($country); ?>"><?php echo htmlspecialchars($country); ?></option><?php endforeach; ?></select></div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><div class="form-group"><label>Risk Assessment Rating</label><select name="risk_assessment_rating" class="form-control"><option value="">Select</option><option value="Low">Low</option><option value="Medium">Medium</option><option value="High">High</option></select></div></div>
                        <div class="col-md-4"><div class="form-group"><label>Status</label><select name="status" class="form-control"><option value="Active">Active</option><option value="Ceased">Ceased</option><option value="Discharged">Discharged</option><option value="Deceased">Deceased</option></select></div></div>
                        <div class="col-md-4"><div class="form-group"><label>Phone</label><input type="text" name="phone" class="form-control" /></div></div>
                    </div>
                    <div class="row"><div class="col-md-12"><div class="form-group"><label>Additional Notes</label><textarea name="additional_notes" class="form-control" rows="3"></textarea></div></div></div>

                    <div class="ln_solid"></div>
                    <div class="form-section-title" style="background:#206570;color:#fff;padding:10px 15px;margin:0 0 20px 0;border-radius:3px;"><i class="fa fa-map-marker"></i> Addresses</div>
                    <div class="row">
                        <div class="col-md-4"><div class="form-group"><label>Default Address</label><select name="default_address_type" class="form-control"><option value="Contact Address" selected>Contact Address</option><option value="Residential Address">Residential Address</option><option value="Foreign Address">Foreign Address</option></select></div></div>
                        <div class="col-md-8"><div class="form-group"><label>Contact Address</label><textarea name="contact_address" class="form-control" rows="2"></textarea></div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><div class="form-group"><label>Residential Address</label><textarea name="residential_address" class="form-control" rows="2"></textarea></div></div>
                        <div class="col-md-6"><div class="form-group"><label>Foreign Address</label><textarea name="foreign_address" class="form-control" rows="2"></textarea></div></div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-section-title" style="background:#206570;color:#fff;padding:10px 15px;margin:0 0 20px 0;border-radius:3px;"><i class="fa fa-id-card"></i> Identification 1</div>
                    <div class="row">
                        <div class="col-md-3"><div class="form-group"><label>ID Type</label><select name="identification[1][id_type]" class="form-control"><option value="">Select Type</option><option value="NRIC">NRIC</option><option value="Passport">Passport</option><option value="FIN">FIN</option><option value="Birth Certificate">Birth Certificate</option><option value="Others">Others</option></select></div></div>
                        <div class="col-md-3"><div class="form-group"><label>ID No.</label><input type="text" name="identification[1][id_number]" class="form-control" /></div></div>
                        <div class="col-md-3"><div class="form-group"><label>ID Expiry Date</label><input type="text" name="identification[1][id_expiry_date]" class="form-control datepicker" placeholder="DD/MM/YYYY" autocomplete="off" /></div></div>
                        <div class="col-md-3"><div class="form-group"><label>ID Issued Date</label><input type="text" name="identification[1][id_issued_date]" class="form-control datepicker" placeholder="DD/MM/YYYY" autocomplete="off" /></div></div>
                    </div>
                    <div class="row"><div class="col-md-4"><div class="form-group"><label>ID Issued Country</label><select name="identification[1][id_issued_country]" class="form-control select2"><option value="">Select Country</option><?php foreach ($countries as $country): ?><option value="<?php echo htmlspecialchars($country); ?>"><?php echo htmlspecialchars($country); ?></option><?php endforeach; ?></select></div></div></div>

                    <div class="ln_solid"></div>
                    <div class="form-section-title" style="background:#206570;color:#fff;padding:10px 15px;margin:0 0 20px 0;border-radius:3px;"><i class="fa fa-id-card"></i> Identification 2</div>
                    <div class="row">
                        <div class="col-md-3"><div class="form-group"><label>ID Type</label><select name="identification[2][id_type]" class="form-control"><option value="">Select Type</option><option value="NRIC">NRIC</option><option value="Passport">Passport</option><option value="FIN">FIN</option><option value="Birth Certificate">Birth Certificate</option><option value="Others">Others</option></select></div></div>
                        <div class="col-md-3"><div class="form-group"><label>ID No.</label><input type="text" name="identification[2][id_number]" class="form-control" /></div></div>
                        <div class="col-md-3"><div class="form-group"><label>ID Expiry Date</label><input type="text" name="identification[2][id_expiry_date]" class="form-control datepicker" placeholder="DD/MM/YYYY" autocomplete="off" /></div></div>
                        <div class="col-md-3"><div class="form-group"><label>ID Issued Date</label><input type="text" name="identification[2][id_issued_date]" class="form-control datepicker" placeholder="DD/MM/YYYY" autocomplete="off" /></div></div>
                    </div>
                    <div class="row"><div class="col-md-4"><div class="form-group"><label>ID Issued Country</label><select name="identification[2][id_issued_country]" class="form-control select2"><option value="">Select Country</option><?php foreach ($countries as $country): ?><option value="<?php echo htmlspecialchars($country); ?>"><?php echo htmlspecialchars($country); ?></option><?php endforeach; ?></select></div></div></div>

                    <div class="ln_solid"></div>
                    <div class="form-section-title" style="background:#206570;color:#fff;padding:10px 15px;margin:0 0 20px 0;border-radius:3px;"><i class="fa fa-users"></i> Family Info</div>
                    <div class="row">
                        <div class="col-md-4"><div class="form-group"><label>Father's Name</label><input type="text" name="father_name" class="form-control" /></div></div>
                        <div class="col-md-4"><div class="form-group"><label>Mother's Name</label><input type="text" name="mother_name" class="form-control" /></div></div>
                        <div class="col-md-4"><div class="form-group"><label>Spouse Name</label><input type="text" name="spouse_name" class="form-control" /></div></div>
                    </div>

                    <div class="ln_solid"></div>
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

<script>
$(document).ready(function() {
    $('.select2').select2({ allowClear: true, placeholder: function() { return $(this).find('option:first').text(); } });
    $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true });
});
</script>
