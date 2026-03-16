<?php
$slot1 = $identification_slots[1] ?? null;
$slot2 = $identification_slots[2] ?? null;
?>

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
                <form id="form_edit_member" action="<?php echo site_url('members/edit_member/' . $member->id); ?>" method="POST" class="form-horizontal form-label-left" novalidate>
                    <input type="hidden" name="ci_csrf_token" value="<?php echo $csrf_token ?? ''; ?>" />
                    <input type="hidden" name="member_id" value="<?php echo $member->id; ?>" />

                    <div class="form-section-title" style="background:#206570;color:#fff;padding:10px 15px;margin:0 0 20px 0;border-radius:3px;"><i class="fa fa-user"></i> Personal Info</div>
                    <div class="row">
                        <div class="col-md-2"><div class="form-group"><label>Name Initials</label><select name="name_initials" class="form-control"><?php foreach (['','Mr','Mrs','Ms','Mdm','Dr'] as $opt): ?><option value="<?php echo $opt; ?>" <?php echo (!empty($member->name_initials) && $member->name_initials === $opt) ? 'selected' : ''; ?>><?php echo $opt === '' ? 'Select' : $opt; ?></option><?php endforeach; ?></select></div></div>
                        <div class="col-md-4"><div class="form-group"><label>Individual Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($member->name); ?>" required /></div></div>
                        <div class="col-md-3"><div class="form-group"><label>Gender</label><select name="gender" class="form-control"><option value="">Select</option><option value="Male" <?php echo (!empty($member->gender) && $member->gender === 'Male') ? 'selected' : ''; ?>>Male</option><option value="Female" <?php echo (!empty($member->gender) && $member->gender === 'Female') ? 'selected' : ''; ?>>Female</option></select></div></div>
                        <div class="col-md-3"><div class="form-group"><label>Date of Birth</label><input type="text" name="date_of_birth" class="form-control datepicker" value="<?php echo !empty($member->date_of_birth) ? date('d/m/Y', strtotime($member->date_of_birth)) : ''; ?>" placeholder="DD/MM/YYYY" autocomplete="off" /></div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><div class="form-group"><label>Alias</label><input type="text" name="alias_name" class="form-control" value="<?php echo htmlspecialchars($member->alias_name ?? ''); ?>" /></div></div>
                        <div class="col-md-4"><div class="form-group"><label>Country of Birth</label><select name="country_of_birth" class="form-control select2"><option value="">Select Country</option><?php foreach ($countries as $country): ?><option value="<?php echo htmlspecialchars($country); ?>" <?php echo (!empty($member->country_of_birth) && $member->country_of_birth === $country) ? 'selected' : ''; ?>><?php echo htmlspecialchars($country); ?></option><?php endforeach; ?></select></div></div>
                        <div class="col-md-4"><div class="form-group"><label>Nationality</label><select name="nationality" class="form-control select2"><option value="">Select Nationality</option><?php foreach ($countries as $country): ?><option value="<?php echo htmlspecialchars($country); ?>" <?php echo (!empty($member->nationality) && $member->nationality === $country) ? 'selected' : ''; ?>><?php echo htmlspecialchars($country); ?></option><?php endforeach; ?></select></div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><div class="form-group"><label>Risk Assessment Rating</label><select name="risk_assessment_rating" class="form-control"><option value="">Select</option><?php foreach (['Low','Medium','High'] as $opt): ?><option value="<?php echo $opt; ?>" <?php echo (!empty($member->risk_assessment_rating) && $member->risk_assessment_rating === $opt) ? 'selected' : ''; ?>><?php echo $opt; ?></option><?php endforeach; ?></select></div></div>
                        <div class="col-md-4"><div class="form-group"><label>Status</label><select name="status" class="form-control"><?php foreach (['Active','Ceased','Discharged','Deceased'] as $opt): ?><option value="<?php echo $opt; ?>" <?php echo (!empty($member->status) && $member->status === $opt) ? 'selected' : ''; ?>><?php echo $opt; ?></option><?php endforeach; ?></select></div></div>
                        <div class="col-md-4"><div class="form-group"><label>Phone</label><input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($member->phone ?? ''); ?>" /></div></div>
                    </div>
                    <div class="row"><div class="col-md-12"><div class="form-group"><label>Additional Notes</label><textarea name="additional_notes" class="form-control" rows="3"><?php echo htmlspecialchars($member->additional_notes ?? ''); ?></textarea></div></div></div>

                    <div class="ln_solid"></div>
                    <div class="form-section-title" style="background:#206570;color:#fff;padding:10px 15px;margin:0 0 20px 0;border-radius:3px;"><i class="fa fa-map-marker"></i> Addresses</div>
                    <div class="row">
                        <div class="col-md-4"><div class="form-group"><label>Default Address</label><select name="default_address_type" class="form-control"><?php foreach (['Contact Address','Residential Address','Foreign Address'] as $opt): ?><option value="<?php echo $opt; ?>" <?php echo ((!empty($member->default_address_type) ? $member->default_address_type : 'Contact Address') === $opt) ? 'selected' : ''; ?>><?php echo $opt; ?></option><?php endforeach; ?></select></div></div>
                        <div class="col-md-8"><div class="form-group"><label>Contact Address</label><textarea name="contact_address" class="form-control" rows="2"><?php echo htmlspecialchars($member->contact_address ?? ''); ?></textarea></div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><div class="form-group"><label>Residential Address</label><textarea name="residential_address" class="form-control" rows="2"><?php echo htmlspecialchars($member->residential_address ?? ''); ?></textarea></div></div>
                        <div class="col-md-6"><div class="form-group"><label>Foreign Address</label><textarea name="foreign_address" class="form-control" rows="2"><?php echo htmlspecialchars($member->foreign_address ?? ''); ?></textarea></div></div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-section-title" style="background:#206570;color:#fff;padding:10px 15px;margin:0 0 20px 0;border-radius:3px;"><i class="fa fa-id-card"></i> Identification 1</div>
                    <div class="row">
                        <div class="col-md-3"><div class="form-group"><label>ID Type</label><select name="identification[1][id_type]" class="form-control"><option value="">Select Type</option><?php foreach (['NRIC','Passport','FIN','Birth Certificate','Others'] as $opt): ?><option value="<?php echo $opt; ?>" <?php echo (!empty($slot1->id_type) && $slot1->id_type === $opt) ? 'selected' : ''; ?>><?php echo $opt; ?></option><?php endforeach; ?></select></div></div>
                        <div class="col-md-3"><div class="form-group"><label>ID No.</label><input type="text" name="identification[1][id_number]" class="form-control" value="<?php echo htmlspecialchars($slot1->id_number ?? ''); ?>" /></div></div>
                        <div class="col-md-3"><div class="form-group"><label>ID Expiry Date</label><input type="text" name="identification[1][id_expiry_date]" class="form-control datepicker" value="<?php echo !empty($slot1->id_expiry_date) ? date('d/m/Y', strtotime($slot1->id_expiry_date)) : ''; ?>" placeholder="DD/MM/YYYY" autocomplete="off" /></div></div>
                        <div class="col-md-3"><div class="form-group"><label>ID Issued Date</label><input type="text" name="identification[1][id_issued_date]" class="form-control datepicker" value="<?php echo !empty($slot1->id_issued_date) ? date('d/m/Y', strtotime($slot1->id_issued_date)) : ''; ?>" placeholder="DD/MM/YYYY" autocomplete="off" /></div></div>
                    </div>
                    <div class="row"><div class="col-md-4"><div class="form-group"><label>ID Issued Country</label><select name="identification[1][id_issued_country]" class="form-control select2"><option value="">Select Country</option><?php foreach ($countries as $country): ?><option value="<?php echo htmlspecialchars($country); ?>" <?php echo (!empty($slot1->id_issued_country) && $slot1->id_issued_country === $country) ? 'selected' : ''; ?>><?php echo htmlspecialchars($country); ?></option><?php endforeach; ?></select></div></div></div>

                    <div class="ln_solid"></div>
                    <div class="form-section-title" style="background:#206570;color:#fff;padding:10px 15px;margin:0 0 20px 0;border-radius:3px;"><i class="fa fa-id-card"></i> Identification 2</div>
                    <div class="row">
                        <div class="col-md-3"><div class="form-group"><label>ID Type</label><select name="identification[2][id_type]" class="form-control"><option value="">Select Type</option><?php foreach (['NRIC','Passport','FIN','Birth Certificate','Others'] as $opt): ?><option value="<?php echo $opt; ?>" <?php echo (!empty($slot2->id_type) && $slot2->id_type === $opt) ? 'selected' : ''; ?>><?php echo $opt; ?></option><?php endforeach; ?></select></div></div>
                        <div class="col-md-3"><div class="form-group"><label>ID No.</label><input type="text" name="identification[2][id_number]" class="form-control" value="<?php echo htmlspecialchars($slot2->id_number ?? ''); ?>" /></div></div>
                        <div class="col-md-3"><div class="form-group"><label>ID Expiry Date</label><input type="text" name="identification[2][id_expiry_date]" class="form-control datepicker" value="<?php echo !empty($slot2->id_expiry_date) ? date('d/m/Y', strtotime($slot2->id_expiry_date)) : ''; ?>" placeholder="DD/MM/YYYY" autocomplete="off" /></div></div>
                        <div class="col-md-3"><div class="form-group"><label>ID Issued Date</label><input type="text" name="identification[2][id_issued_date]" class="form-control datepicker" value="<?php echo !empty($slot2->id_issued_date) ? date('d/m/Y', strtotime($slot2->id_issued_date)) : ''; ?>" placeholder="DD/MM/YYYY" autocomplete="off" /></div></div>
                    </div>
                    <div class="row"><div class="col-md-4"><div class="form-group"><label>ID Issued Country</label><select name="identification[2][id_issued_country]" class="form-control select2"><option value="">Select Country</option><?php foreach ($countries as $country): ?><option value="<?php echo htmlspecialchars($country); ?>" <?php echo (!empty($slot2->id_issued_country) && $slot2->id_issued_country === $country) ? 'selected' : ''; ?>><?php echo htmlspecialchars($country); ?></option><?php endforeach; ?></select></div></div></div>

                    <div class="ln_solid"></div>
                    <div class="form-section-title" style="background:#206570;color:#fff;padding:10px 15px;margin:0 0 20px 0;border-radius:3px;"><i class="fa fa-users"></i> Family Info</div>
                    <div class="row">
                        <div class="col-md-4"><div class="form-group"><label>Father's Name</label><input type="text" name="father_name" class="form-control" value="<?php echo htmlspecialchars($member->father_name ?? ''); ?>" /></div></div>
                        <div class="col-md-4"><div class="form-group"><label>Mother's Name</label><input type="text" name="mother_name" class="form-control" value="<?php echo htmlspecialchars($member->mother_name ?? ''); ?>" /></div></div>
                        <div class="col-md-4"><div class="form-group"><label>Spouse Name</label><input type="text" name="spouse_name" class="form-control" value="<?php echo htmlspecialchars($member->spouse_name ?? ''); ?>" /></div></div>
                    </div>

                    <div class="ln_solid"></div>
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

<script>
$(document).ready(function() {
    $('.select2').select2({ allowClear: true, placeholder: function() { return $(this).find('option:first').text(); } });
    $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true });
});
</script>
