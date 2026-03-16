<?php
$pick = function ($row, $keys, $default = '-') {
    if (empty($row)) {
        return $default;
    }
    foreach ($keys as $key) {
        if (isset($row->$key) && $row->$key !== '') {
            return $row->$key;
        }
    }
    return $default;
};

$fmt = function ($date) {
    if (empty($date)) {
        return '-';
    }
    $ts = strtotime($date);
    if (!$ts) {
        return '-';
    }
    return date('d/m/Y', $ts);
};

$slot1 = $identification_slots[1] ?? null;
$slot2 = $identification_slots[2] ?? null;

$risk = !empty($member->risk_assessment_rating) ? $member->risk_assessment_rating : '-';
$riskClass = 'default';
if ($risk === 'Low') {
    $riskClass = 'success';
} elseif ($risk === 'Medium') {
    $riskClass = 'warning';
} elseif ($risk === 'High') {
    $riskClass = 'danger';
}

$statusClass = 'default';
if ($member->status === 'Active') {
    $statusClass = 'success';
} elseif ($member->status === 'Ceased') {
    $statusClass = 'warning';
} elseif ($member->status === 'Discharged') {
    $statusClass = 'info';
} elseif ($member->status === 'Deceased') {
    $statusClass = 'danger';
}
?>

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

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <div class="col-md-6">
                        <h4 style="color:#206570;margin-top:0;"><i class="fa fa-user"></i> Individual Profile</h4>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr><th width="36%">Individual Name</th><td><?php echo htmlspecialchars($member->name); ?></td></tr>
                                <tr><th>Gender</th><td><?php echo htmlspecialchars(!empty($member->gender) ? $member->gender : '-'); ?></td></tr>
                                <tr><th>Alias</th><td><?php echo htmlspecialchars(!empty($member->alias_name) ? $member->alias_name : '-'); ?></td></tr>
                                <tr>
                                    <th>Risk Assessment Rating</th>
                                    <td><span class="label label-<?php echo $riskClass; ?>"><?php echo htmlspecialchars($risk); ?></span></td>
                                </tr>
                                <tr><th>Country of Birth</th><td><?php echo htmlspecialchars(!empty($member->country_of_birth) ? $member->country_of_birth : '-'); ?></td></tr>
                                <tr><th>Date of Birth</th><td><?php echo $fmt($member->date_of_birth ?? null); ?></td></tr>
                                <tr><th>Nationality</th><td><?php echo htmlspecialchars(!empty($member->nationality) ? $member->nationality : '-'); ?></td></tr>
                                <tr><th>Additional Notes</th><td><?php echo !empty($member->additional_notes) ? nl2br(htmlspecialchars($member->additional_notes)) : '-'; ?></td></tr>
                                <tr><th>Default Address</th><td><?php echo htmlspecialchars(!empty($member->default_address_type) ? $member->default_address_type : 'Contact Address'); ?></td></tr>
                                <tr><th>Residential Address</th><td><?php echo !empty($member->residential_address) ? nl2br(htmlspecialchars($member->residential_address)) : '-'; ?></td></tr>
                                <tr><th>Foreign Address</th><td><?php echo !empty($member->foreign_address) ? nl2br(htmlspecialchars($member->foreign_address)) : '-'; ?></td></tr>
                                <tr><th>Contact Address</th><td><?php echo !empty($member->contact_address) ? nl2br(htmlspecialchars($member->contact_address)) : '-'; ?></td></tr>
                                <tr><th>Father's Name</th><td><?php echo htmlspecialchars(!empty($member->father_name) ? $member->father_name : '-'); ?></td></tr>
                                <tr><th>Mother's Name</th><td><?php echo htmlspecialchars(!empty($member->mother_name) ? $member->mother_name : '-'); ?></td></tr>
                                <tr><th>Spouse Name</th><td><?php echo htmlspecialchars(!empty($member->spouse_name) ? $member->spouse_name : '-'); ?></td></tr>
                                <tr>
                                    <th>Status</th>
                                    <td><span class="label label-<?php echo $statusClass; ?>"><?php echo htmlspecialchars(!empty($member->status) ? $member->status : '-'); ?></span></td>
                                </tr>
                            </tbody>
                        </table>

                        <h4 style="color:#206570;"><i class="fa fa-id-card"></i> ID 1</h4>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr><th width="36%">ID Type</th><td><?php echo htmlspecialchars($pick($slot1, ['id_type'])); ?></td></tr>
                                <tr><th>ID No.</th><td><?php echo htmlspecialchars($pick($slot1, ['id_number'])); ?></td></tr>
                                <tr><th>ID Expiry Date</th><td><?php echo $fmt($pick($slot1, ['id_expiry_date', 'expiry_date'], '')); ?></td></tr>
                                <tr><th>ID Issued Country</th><td><?php echo htmlspecialchars($pick($slot1, ['id_issued_country', 'country_of_issue', 'country'])); ?></td></tr>
                                <tr><th>ID Issued Date</th><td><?php echo $fmt($pick($slot1, ['id_issued_date', 'issue_date'], '')); ?></td></tr>
                            </tbody>
                        </table>

                        <h4 style="color:#206570;"><i class="fa fa-id-card"></i> ID 2</h4>
                        <table class="table table-bordered table-striped" style="margin-bottom:0;">
                            <tbody>
                                <tr><th width="36%">ID Type</th><td><?php echo htmlspecialchars($pick($slot2, ['id_type'])); ?></td></tr>
                                <tr><th>ID No.</th><td><?php echo htmlspecialchars($pick($slot2, ['id_number'])); ?></td></tr>
                                <tr><th>ID Expiry Date</th><td><?php echo $fmt($pick($slot2, ['id_expiry_date', 'expiry_date'], '')); ?></td></tr>
                                <tr><th>ID Issued Country</th><td><?php echo htmlspecialchars($pick($slot2, ['id_issued_country', 'country_of_issue', 'country'])); ?></td></tr>
                                <tr><th>ID Issued Date</th><td><?php echo $fmt($pick($slot2, ['id_issued_date', 'issue_date'], '')); ?></td></tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h4 style="color:#206570;margin-top:0;"><i class="fa fa-history"></i> Appointment History</h4>

                        <h5>Director History</h5>
                        <table class="table table-bordered table-striped">
                            <thead><tr><th>Company</th><th>Appointment</th><th>Cessation</th><th>Status</th></tr></thead>
                            <tbody>
                                <?php if (!empty($director_history)): foreach ($director_history as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars(!empty($row->company_name) ? $row->company_name : '-'); ?></td>
                                    <td><?php echo $fmt($row->date_of_appointment ?? null); ?></td>
                                    <td><?php echo $fmt($row->date_of_cessation ?? null); ?></td>
                                    <td><?php echo htmlspecialchars(!empty($row->status) ? $row->status : '-'); ?></td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr><td colspan="4" class="text-center">No records found</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <h5>Shareholder History</h5>
                        <table class="table table-bordered table-striped">
                            <thead><tr><th>Company</th><th>Appointment</th><th>Cessation</th><th>Status</th></tr></thead>
                            <tbody>
                                <?php if (!empty($shareholder_history)): foreach ($shareholder_history as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars(!empty($row->company_name) ? $row->company_name : '-'); ?></td>
                                    <td><?php echo $fmt($row->date_of_appointment ?? null); ?></td>
                                    <td><?php echo $fmt($row->date_of_cessation ?? null); ?></td>
                                    <td><?php echo htmlspecialchars(!empty($row->status) ? $row->status : '-'); ?></td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr><td colspan="4" class="text-center">No records found</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <h5>Secretary History</h5>
                        <table class="table table-bordered table-striped">
                            <thead><tr><th>Company</th><th>Appointment</th><th>Cessation</th><th>Status</th></tr></thead>
                            <tbody>
                                <?php if (!empty($secretary_history)): foreach ($secretary_history as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars(!empty($row->company_name) ? $row->company_name : '-'); ?></td>
                                    <td><?php echo $fmt($row->date_of_appointment ?? null); ?></td>
                                    <td><?php echo $fmt($row->date_of_cessation ?? null); ?></td>
                                    <td><?php echo htmlspecialchars(!empty($row->status) ? $row->status : '-'); ?></td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr><td colspan="4" class="text-center">No records found</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <h5>Contact Person History</h5>
                        <table class="table table-bordered table-striped">
                            <thead><tr><th>Company</th><th>Appointment</th><th>Cessation</th><th>Status</th></tr></thead>
                            <tbody>
                                <?php if (!empty($contact_person_history)): foreach ($contact_person_history as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars(!empty($row->company_name) ? $row->company_name : '-'); ?></td>
                                    <td><?php echo $fmt($row->date_of_appointment ?? null); ?></td>
                                    <td><?php echo $fmt($row->date_of_cessation ?? null); ?></td>
                                    <td><?php echo htmlspecialchars(!empty($row->status) ? $row->status : '-'); ?></td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr><td colspan="4" class="text-center">No records found</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <h5>Controller History</h5>
                        <table class="table table-bordered table-striped" style="margin-bottom:0;">
                            <thead><tr><th>Company</th><th>Appointment</th><th>Cessation</th><th>Status</th></tr></thead>
                            <tbody>
                                <?php if (!empty($controller_history)): foreach ($controller_history as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars(!empty($row->company_name) ? $row->company_name : '-'); ?></td>
                                    <td><?php echo $fmt($row->date_of_appointment ?? null); ?></td>
                                    <td><?php echo $fmt($row->date_of_cessation ?? null); ?></td>
                                    <td><?php echo htmlspecialchars(!empty($row->status) ? $row->status : '-'); ?></td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr><td colspan="4" class="text-center">No records found</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
