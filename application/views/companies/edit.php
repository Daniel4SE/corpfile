<!-- Company Edit Page -->
<?php
// Countries fallback list
$country_list = (!empty($countries)) ? $countries : [
    'AFGHANISTAN','ALBANIA','ALGERIA','ANDORRA','ANGOLA','ARGENTINA','ARMENIA','AUSTRALIA','AUSTRIA','AZERBAIJAN',
    'BAHAMAS','BAHRAIN','BANGLADESH','BARBADOS','BELARUS','BELGIUM','BELIZE','BERMUDA','BHUTAN','BOLIVIA',
    'BOSNIA AND HERZEGOVINA','BOTSWANA','BRAZIL','BRUNEI','BULGARIA','CAMBODIA','CAMEROON','CANADA','CAYMAN ISLANDS',
    'CHILE','CHINA','COLOMBIA','COSTA RICA','CROATIA','CUBA','CYPRUS','CZECH REPUBLIC','DENMARK','ECUADOR','EGYPT',
    'EL SALVADOR','ESTONIA','ETHIOPIA','FIJI','FINLAND','FRANCE','GEORGIA','GERMANY','GHANA','GREECE','GUAM',
    'GUATEMALA','HONG KONG','HUNGARY','ICELAND','INDIA','INDONESIA','IRAN','IRAQ','IRELAND','ISRAEL','ITALY',
    'JAMAICA','JAPAN','JORDAN','KAZAKHSTAN','KENYA','KUWAIT','LAOS','LATVIA','LEBANON','LIBYA','LIECHTENSTEIN',
    'LITHUANIA','LUXEMBOURG','MACAU','MADAGASCAR','MALAYSIA','MALDIVES','MALTA','MAURITIUS','MEXICO','MONACO',
    'MONGOLIA','MOROCCO','MOZAMBIQUE','MYANMAR','NEPAL','NETHERLANDS','NEW ZEALAND','NIGERIA','NORTH KOREA',
    'NORWAY','OMAN','PAKISTAN','PANAMA','PAPUA NEW GUINEA','PARAGUAY','PERU','PHILIPPINES','POLAND','PORTUGAL',
    'QATAR','ROMANIA','RUSSIA','SAUDI ARABIA','SERBIA','SINGAPORE','SLOVAKIA','SLOVENIA','SOUTH AFRICA',
    'SOUTH KOREA','SPAIN','SRI LANKA','SWEDEN','SWITZERLAND','SYRIA','TAIWAN','TAJIKISTAN','TANZANIA','THAILAND',
    'TUNISIA','TURKEY','TURKMENISTAN','UAE','UGANDA','UKRAINE','UNITED KINGDOM','UNITED STATES','URUGUAY',
    'UZBEKISTAN','VENEZUELA','VIETNAM','YEMEN','ZAMBIA','ZIMBABWE'
];

// Get first address if available
$addr = isset($addresses[0]) ? $addresses[0] : null;
?>

<div class="page-title">
    <div class="title_left">
        <h3>Edit Company - <?= htmlspecialchars($company->company_name ?? '') ?></h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('view_company/' . $company->id) ?>" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
            <a href="<?= base_url('company_list') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to List</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Edit Company Details</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="POST" action="<?= base_url('edit_company/' . $company->id) ?>" class="form-horizontal form-label-left" id="company-edit-form" novalidate>
                    <input type="hidden" name="ci_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                    <input type="hidden" name="company_id" value="<?= htmlspecialchars($company->id ?? '') ?>">

                    <!-- ============================================================ -->
                    <!-- CLIENT TYPE CHECKBOXES -->
                    <!-- ============================================================ -->
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Client Type</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_css_client" value="1" <?= !empty($company->is_css_client) ? 'checked' : '' ?>> CSS Client
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_taxation_client" value="1" <?= !empty($company->is_taxation_client) ? 'checked' : '' ?>> Taxation Client
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_prospect" value="1" <?= !empty($company->is_prospect) ? 'checked' : '' ?>> Prospect
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_client" value="1" <?= !empty($company->is_client) ? 'checked' : '' ?>> Client
                                    </label>
                                </div>
                            </div>
                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_non_client" value="1" <?= !empty($company->is_non_client) ? 'checked' : '' ?>> Non-Client
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_accounting_client" value="1" <?= !empty($company->is_accounting_client) ? 'checked' : '' ?>> Accounting Client
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_payroll_client" value="1" <?= !empty($company->is_payroll_client) ? 'checked' : '' ?>> Payroll Client
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_audit_client" value="1" <?= !empty($company->is_audit_client) ? 'checked' : '' ?>> Audit Client
                                    </label>
                                </div>
                            </div>
                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_gst_client" value="1" <?= !empty($company->is_gst_client) ? 'checked' : '' ?>> GST Client
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_valuation_client" value="1" <?= !empty($company->is_valuation_client) ? 'checked' : '' ?>> Valuation Client
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_management_client" value="1" <?= !empty($company->is_management_client) ? 'checked' : '' ?>> Management Client
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_advisory_client" value="1" <?= !empty($company->is_advisory_client) ? 'checked' : '' ?>> Advisory Client
                                    </label>
                                </div>
                            </div>
                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_dormant" value="1" <?= !empty($company->is_dormant) ? 'checked' : '' ?>> Dormant
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_struck_off" value="1" <?= !empty($company->is_struck_off) ? 'checked' : '' ?>> Struck Off
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_liquidated" value="1" <?= !empty($company->is_liquidated) ? 'checked' : '' ?>> Liquidated
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_terminated" value="1" <?= !empty($company->is_terminated) ? 'checked' : '' ?>> Terminated
                                    </label>
                                </div>
                            </div>
                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_holding_company" value="1" <?= !empty($company->is_holding_company) ? 'checked' : '' ?>> Holding Company
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_subsidiary" value="1" <?= !empty($company->is_subsidiary) ? 'checked' : '' ?>> Subsidiary
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_associate" value="1" <?= !empty($company->is_associate) ? 'checked' : '' ?>> Associate
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_branch" value="1" <?= !empty($company->is_branch) ? 'checked' : '' ?>> Branch
                                    </label>
                                </div>
                            </div>
                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_llp" value="1" <?= !empty($company->is_llp) ? 'checked' : '' ?>> LLP
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_lp" value="1" <?= !empty($company->is_lp) ? 'checked' : '' ?>> LP
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_sole_proprietor" value="1" <?= !empty($company->is_sole_proprietor) ? 'checked' : '' ?>> Sole Proprietor
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_partnership" value="1" <?= !empty($company->is_partnership) ? 'checked' : '' ?>> Partnership
                                    </label>
                                </div>
                            </div>
                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_trust" value="1" <?= !empty($company->is_trust) ? 'checked' : '' ?>> Trust
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_club" value="1" <?= !empty($company->is_club) ? 'checked' : '' ?>> Club/Association
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_charity" value="1" <?= !empty($company->is_charity) ? 'checked' : '' ?>> Charity
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_foreign_company" value="1" <?= !empty($company->is_foreign_company) ? 'checked' : '' ?>> Foreign Company
                                    </label>
                                </div>
                            </div>
                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_nominee_director" value="1" <?= !empty($company->is_nominee_director) ? 'checked' : '' ?>> Nominee Director
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_nominee_shareholder" value="1" <?= !empty($company->is_nominee_shareholder) ? 'checked' : '' ?>> Nominee Shareholder
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_registered_office" value="1" <?= !empty($company->is_registered_office) ? 'checked' : '' ?>> Registered Office
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_virtual_office" value="1" <?= !empty($company->is_virtual_office) ? 'checked' : '' ?>> Virtual Office
                                    </label>
                                </div>
                            </div>
                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_mail_forwarding" value="1" <?= !empty($company->is_mail_forwarding) ? 'checked' : '' ?>> Mail Forwarding
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_bookkeeping" value="1" <?= !empty($company->is_bookkeeping) ? 'checked' : '' ?>> Bookkeeping
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <!-- ============================================================ -->
                    <!-- COMPANY DETAILS SECTION -->
                    <!-- ============================================================ -->
                    <h4 class="form-section-heading" style="color:#206570;border-bottom:1px solid #e5e5e5;padding-bottom:8px;margin-bottom:20px;">
                        <i class="fa fa-building"></i> Company Details
                    </h4>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Company Name <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="company_name" value="<?= htmlspecialchars($company->company_name ?? '') ?>" class="form-control col-md-7 col-xs-12" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Former Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="former_name" value="<?= htmlspecialchars($company->former_name ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Client ID</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="company_id_code" value="<?= htmlspecialchars($company->company_id_code ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Company Type</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="company_type_id" class="form-control select2_single col-md-7 col-xs-12">
                                <option value="">-- Select Company Type --</option>
                                <?php if (!empty($company_types)): ?>
                                    <?php foreach ($company_types as $type): ?>
                                        <option value="<?= $type->id ?>" <?= (isset($company->company_type_id) && $company->company_type_id == $type->id) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($type->type_name) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Registration Number</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="registration_number" value="<?= htmlspecialchars($company->registration_number ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">ACRA Registration Number</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="acra_registration_number" value="<?= htmlspecialchars($company->acra_registration_number ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Country</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="country" class="form-control select2_single col-md-7 col-xs-12">
                                <option value="">-- Select Country --</option>
                                <?php foreach ($country_list as $c_name): ?>
                                    <option value="<?= htmlspecialchars($c_name) ?>" <?= (isset($company->country) && strtoupper($company->country) == strtoupper($c_name)) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($c_name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Region</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="region" value="<?= htmlspecialchars($company->region ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Internal CSS Status</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="internal_css_status" class="form-control col-md-7 col-xs-12">
                                <option value="">-- Select Status --</option>
                                <option value="Active" <?= (isset($company->internal_css_status) && $company->internal_css_status == 'Active') ? 'selected' : '' ?>>Active</option>
                                <option value="Inactive" <?= (isset($company->internal_css_status) && $company->internal_css_status == 'Inactive') ? 'selected' : '' ?>>Inactive</option>
                                <option value="Pending" <?= (isset($company->internal_css_status) && $company->internal_css_status == 'Pending') ? 'selected' : '' ?>>Pending</option>
                                <option value="Suspended" <?= (isset($company->internal_css_status) && $company->internal_css_status == 'Suspended') ? 'selected' : '' ?>>Suspended</option>
                                <option value="Closed" <?= (isset($company->internal_css_status) && $company->internal_css_status == 'Closed') ? 'selected' : '' ?>>Closed</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Risk Assessment Rating</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="risk_assessment_rating" class="form-control col-md-7 col-xs-12">
                                <option value="">-- Select Rating --</option>
                                <option value="Low" <?= (isset($company->risk_assessment_rating) && $company->risk_assessment_rating == 'Low') ? 'selected' : '' ?>>Low</option>
                                <option value="Medium" <?= (isset($company->risk_assessment_rating) && $company->risk_assessment_rating == 'Medium') ? 'selected' : '' ?>>Medium</option>
                                <option value="High" <?= (isset($company->risk_assessment_rating) && $company->risk_assessment_rating == 'High') ? 'selected' : '' ?>>High</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Incorporation Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="incorporation_date" value="<?= htmlspecialchars($company->incorporation_date ?? '') ?>" class="form-control col-md-7 col-xs-12 datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Entity Status</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="entity_status" class="form-control col-md-7 col-xs-12">
                                <option value="">-- Select Entity Status --</option>
                                <option value="Active" <?= (isset($company->entity_status) && $company->entity_status == 'Active') ? 'selected' : '' ?>>Active</option>
                                <option value="Inactive" <?= (isset($company->entity_status) && $company->entity_status == 'Inactive') ? 'selected' : '' ?>>Inactive</option>
                                <option value="Struck Off" <?= (isset($company->entity_status) && $company->entity_status == 'Struck Off') ? 'selected' : '' ?>>Struck Off</option>
                                <option value="Dissolved" <?= (isset($company->entity_status) && $company->entity_status == 'Dissolved') ? 'selected' : '' ?>>Dissolved</option>
                                <option value="Liquidated" <?= (isset($company->entity_status) && $company->entity_status == 'Liquidated') ? 'selected' : '' ?>>Liquidated</option>
                                <option value="Dormant" <?= (isset($company->entity_status) && $company->entity_status == 'Dormant') ? 'selected' : '' ?>>Dormant</option>
                                <option value="Under Judicial Management" <?= (isset($company->entity_status) && $company->entity_status == 'Under Judicial Management') ? 'selected' : '' ?>>Under Judicial Management</option>
                                <option value="In Receivership" <?= (isset($company->entity_status) && $company->entity_status == 'In Receivership') ? 'selected' : '' ?>>In Receivership</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Strike Off Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="strike_off_date" value="<?= htmlspecialchars($company->strike_off_date ?? '') ?>" class="form-control col-md-7 col-xs-12 datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Terminate Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="terminate_date" value="<?= htmlspecialchars($company->terminate_date ?? '') ?>" class="form-control col-md-7 col-xs-12 datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Dormant Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="dormant_date" value="<?= htmlspecialchars($company->dormant_date ?? '') ?>" class="form-control col-md-7 col-xs-12 datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Liquidated Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="liquidated_date" value="<?= htmlspecialchars($company->liquidated_date ?? '') ?>" class="form-control col-md-7 col-xs-12 datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Common Seal</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="common_seal" class="form-control col-md-7 col-xs-12">
                                <option value="">-- Select --</option>
                                <option value="Yes" <?= (isset($company->common_seal) && $company->common_seal == 'Yes') ? 'selected' : '' ?>>Yes</option>
                                <option value="No" <?= (isset($company->common_seal) && $company->common_seal == 'No') ? 'selected' : '' ?>>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Company Stamp</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="company_stamp" class="form-control col-md-7 col-xs-12">
                                <option value="">-- Select --</option>
                                <option value="Yes" <?= (isset($company->company_stamp) && $company->company_stamp == 'Yes') ? 'selected' : '' ?>>Yes</option>
                                <option value="No" <?= (isset($company->company_stamp) && $company->company_stamp == 'No') ? 'selected' : '' ?>>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Related Industry</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="related_industry" value="<?= htmlspecialchars($company->related_industry ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Market Segment</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="market_segment" value="<?= htmlspecialchars($company->market_segment ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <!-- ============================================================ -->
                    <!-- REGISTERED ADDRESS SECTION -->
                    <!-- ============================================================ -->
                    <h4 class="form-section-heading" style="color:#206570;border-bottom:1px solid #e5e5e5;padding-bottom:8px;margin-bottom:20px;">
                        <i class="fa fa-map-marker"></i> Registered Address
                    </h4>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Address Type</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="address_type" class="form-control col-md-7 col-xs-12">
                                <option value="">-- Select Address Type --</option>
                                <option value="Registered" <?= ($addr && isset($addr->address_type) && $addr->address_type == 'Registered') ? 'selected' : '' ?>>Registered</option>
                                <option value="Business" <?= ($addr && isset($addr->address_type) && $addr->address_type == 'Business') ? 'selected' : '' ?>>Business</option>
                                <option value="Mailing" <?= ($addr && isset($addr->address_type) && $addr->address_type == 'Mailing') ? 'selected' : '' ?>>Mailing</option>
                                <option value="Residential" <?= ($addr && isset($addr->address_type) && $addr->address_type == 'Residential') ? 'selected' : '' ?>>Residential</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Block/House No.</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="block" value="<?= htmlspecialchars($addr->block ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Street/Address</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="address_text" value="<?= htmlspecialchars($addr->address_text ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Building Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="building" value="<?= htmlspecialchars($addr->building ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Level</label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <input type="text" name="level" value="<?= htmlspecialchars($addr->level ?? '') ?>" class="form-control col-md-7 col-xs-12" placeholder="Level">
                        </div>
                        <label class="control-label col-md-1 col-sm-1 col-xs-12">Unit</label>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <input type="text" name="unit" value="<?= htmlspecialchars($addr->unit ?? '') ?>" class="form-control col-md-7 col-xs-12" placeholder="Unit">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Country</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="address_country" class="form-control select2_single col-md-7 col-xs-12">
                                <option value="">-- Select Country --</option>
                                <?php foreach ($country_list as $c_name): ?>
                                    <option value="<?= htmlspecialchars($c_name) ?>" <?= ($addr && isset($addr->country) && strtoupper($addr->country) == strtoupper($c_name)) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($c_name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">State/Province</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="state" value="<?= htmlspecialchars($addr->state ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">City</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="city" value="<?= htmlspecialchars($addr->city ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Postal Code</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="postal_code" value="<?= htmlspecialchars($addr->postal_code ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <!-- ============================================================ -->
                    <!-- SSIC ACTIVITIES SECTION -->
                    <!-- ============================================================ -->
                    <h4 class="form-section-heading" style="color:#206570;border-bottom:1px solid #e5e5e5;padding-bottom:8px;margin-bottom:20px;">
                        <i class="fa fa-industry"></i> SSIC Activities
                    </h4>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Primary SSIC Code</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="primary_ssic_code" value="<?= htmlspecialchars($company->primary_ssic_code ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Primary SSIC Description</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="primary_ssic_description" value="<?= htmlspecialchars($company->primary_ssic_description ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Secondary SSIC Code</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="secondary_ssic_code" value="<?= htmlspecialchars($company->secondary_ssic_code ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Secondary SSIC Description</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="secondary_ssic_description" value="<?= htmlspecialchars($company->secondary_ssic_description ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <!-- ============================================================ -->
                    <!-- SHARE CAPITAL SECTION -->
                    <!-- ============================================================ -->
                    <h4 class="form-section-heading" style="color:#206570;border-bottom:1px solid #e5e5e5;padding-bottom:8px;margin-bottom:20px;">
                        <i class="fa fa-money"></i> Share Capital
                    </h4>

                    <h5 style="margin-left:25%;color:#555;"><strong>Ordinary Shares</strong></h5>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Issued Share Capital</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="ord_issued_share_capital" value="<?= htmlspecialchars($company->ord_issued_share_capital ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Currency</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="ord_currency" class="form-control select2_single col-md-7 col-xs-12">
                                <option value="">-- Select Currency --</option>
                                <option value="SGD" <?= (isset($company->ord_currency) && $company->ord_currency == 'SGD') ? 'selected' : '' ?>>SGD - Singapore Dollar</option>
                                <option value="USD" <?= (isset($company->ord_currency) && $company->ord_currency == 'USD') ? 'selected' : '' ?>>USD - US Dollar</option>
                                <option value="EUR" <?= (isset($company->ord_currency) && $company->ord_currency == 'EUR') ? 'selected' : '' ?>>EUR - Euro</option>
                                <option value="GBP" <?= (isset($company->ord_currency) && $company->ord_currency == 'GBP') ? 'selected' : '' ?>>GBP - British Pound</option>
                                <option value="AUD" <?= (isset($company->ord_currency) && $company->ord_currency == 'AUD') ? 'selected' : '' ?>>AUD - Australian Dollar</option>
                                <option value="HKD" <?= (isset($company->ord_currency) && $company->ord_currency == 'HKD') ? 'selected' : '' ?>>HKD - Hong Kong Dollar</option>
                                <option value="MYR" <?= (isset($company->ord_currency) && $company->ord_currency == 'MYR') ? 'selected' : '' ?>>MYR - Malaysian Ringgit</option>
                                <option value="CNY" <?= (isset($company->ord_currency) && $company->ord_currency == 'CNY') ? 'selected' : '' ?>>CNY - Chinese Yuan</option>
                                <option value="JPY" <?= (isset($company->ord_currency) && $company->ord_currency == 'JPY') ? 'selected' : '' ?>>JPY - Japanese Yen</option>
                                <option value="INR" <?= (isset($company->ord_currency) && $company->ord_currency == 'INR') ? 'selected' : '' ?>>INR - Indian Rupee</option>
                                <option value="IDR" <?= (isset($company->ord_currency) && $company->ord_currency == 'IDR') ? 'selected' : '' ?>>IDR - Indonesian Rupiah</option>
                                <option value="THB" <?= (isset($company->ord_currency) && $company->ord_currency == 'THB') ? 'selected' : '' ?>>THB - Thai Baht</option>
                                <option value="PHP" <?= (isset($company->ord_currency) && $company->ord_currency == 'PHP') ? 'selected' : '' ?>>PHP - Philippine Peso</option>
                                <option value="VND" <?= (isset($company->ord_currency) && $company->ord_currency == 'VND') ? 'selected' : '' ?>>VND - Vietnamese Dong</option>
                                <option value="KRW" <?= (isset($company->ord_currency) && $company->ord_currency == 'KRW') ? 'selected' : '' ?>>KRW - Korean Won</option>
                                <option value="TWD" <?= (isset($company->ord_currency) && $company->ord_currency == 'TWD') ? 'selected' : '' ?>>TWD - Taiwan Dollar</option>
                                <option value="CHF" <?= (isset($company->ord_currency) && $company->ord_currency == 'CHF') ? 'selected' : '' ?>>CHF - Swiss Franc</option>
                                <option value="CAD" <?= (isset($company->ord_currency) && $company->ord_currency == 'CAD') ? 'selected' : '' ?>>CAD - Canadian Dollar</option>
                                <option value="NZD" <?= (isset($company->ord_currency) && $company->ord_currency == 'NZD') ? 'selected' : '' ?>>NZD - New Zealand Dollar</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">No. of Ordinary Shares</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="no_ord_shares" value="<?= htmlspecialchars($company->no_ord_shares ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Paid Up Capital</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="paid_up_capital" value="<?= htmlspecialchars($company->paid_up_capital ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <h5 style="margin-left:25%;color:#555;margin-top:20px;"><strong>Special/Preference Shares</strong></h5>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Issued Share Capital</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="spec_issued_share_capital" value="<?= htmlspecialchars($company->spec_issued_share_capital ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Currency</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="spec_currency" class="form-control select2_single col-md-7 col-xs-12">
                                <option value="">-- Select Currency --</option>
                                <option value="SGD" <?= (isset($company->spec_currency) && $company->spec_currency == 'SGD') ? 'selected' : '' ?>>SGD - Singapore Dollar</option>
                                <option value="USD" <?= (isset($company->spec_currency) && $company->spec_currency == 'USD') ? 'selected' : '' ?>>USD - US Dollar</option>
                                <option value="EUR" <?= (isset($company->spec_currency) && $company->spec_currency == 'EUR') ? 'selected' : '' ?>>EUR - Euro</option>
                                <option value="GBP" <?= (isset($company->spec_currency) && $company->spec_currency == 'GBP') ? 'selected' : '' ?>>GBP - British Pound</option>
                                <option value="AUD" <?= (isset($company->spec_currency) && $company->spec_currency == 'AUD') ? 'selected' : '' ?>>AUD - Australian Dollar</option>
                                <option value="HKD" <?= (isset($company->spec_currency) && $company->spec_currency == 'HKD') ? 'selected' : '' ?>>HKD - Hong Kong Dollar</option>
                                <option value="MYR" <?= (isset($company->spec_currency) && $company->spec_currency == 'MYR') ? 'selected' : '' ?>>MYR - Malaysian Ringgit</option>
                                <option value="CNY" <?= (isset($company->spec_currency) && $company->spec_currency == 'CNY') ? 'selected' : '' ?>>CNY - Chinese Yuan</option>
                                <option value="JPY" <?= (isset($company->spec_currency) && $company->spec_currency == 'JPY') ? 'selected' : '' ?>>JPY - Japanese Yen</option>
                                <option value="INR" <?= (isset($company->spec_currency) && $company->spec_currency == 'INR') ? 'selected' : '' ?>>INR - Indian Rupee</option>
                                <option value="IDR" <?= (isset($company->spec_currency) && $company->spec_currency == 'IDR') ? 'selected' : '' ?>>IDR - Indonesian Rupiah</option>
                                <option value="THB" <?= (isset($company->spec_currency) && $company->spec_currency == 'THB') ? 'selected' : '' ?>>THB - Thai Baht</option>
                                <option value="PHP" <?= (isset($company->spec_currency) && $company->spec_currency == 'PHP') ? 'selected' : '' ?>>PHP - Philippine Peso</option>
                                <option value="VND" <?= (isset($company->spec_currency) && $company->spec_currency == 'VND') ? 'selected' : '' ?>>VND - Vietnamese Dong</option>
                                <option value="KRW" <?= (isset($company->spec_currency) && $company->spec_currency == 'KRW') ? 'selected' : '' ?>>KRW - Korean Won</option>
                                <option value="TWD" <?= (isset($company->spec_currency) && $company->spec_currency == 'TWD') ? 'selected' : '' ?>>TWD - Taiwan Dollar</option>
                                <option value="CHF" <?= (isset($company->spec_currency) && $company->spec_currency == 'CHF') ? 'selected' : '' ?>>CHF - Swiss Franc</option>
                                <option value="CAD" <?= (isset($company->spec_currency) && $company->spec_currency == 'CAD') ? 'selected' : '' ?>>CAD - Canadian Dollar</option>
                                <option value="NZD" <?= (isset($company->spec_currency) && $company->spec_currency == 'NZD') ? 'selected' : '' ?>>NZD - New Zealand Dollar</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">No. of Special/Preference Shares</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="no_spec_shares" value="<?= htmlspecialchars($company->no_spec_shares ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <!-- ============================================================ -->
                    <!-- AGM / AR / FYE SECTION -->
                    <!-- ============================================================ -->
                    <h4 class="form-section-heading" style="color:#206570;border-bottom:1px solid #e5e5e5;padding-bottom:8px;margin-bottom:20px;">
                        <i class="fa fa-calendar"></i> AGM / AR / FYE
                    </h4>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Financial Year End (FYE) Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="fye_date" value="<?= htmlspecialchars($company->fye_date ?? '') ?>" class="form-control col-md-7 col-xs-12 datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Next AGM Due</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="next_agm_due" value="<?= htmlspecialchars($company->next_agm_due ?? '') ?>" class="form-control col-md-7 col-xs-12 datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Last AGM Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="last_agm_date" value="<?= htmlspecialchars($company->last_agm_date ?? '') ?>" class="form-control col-md-7 col-xs-12 datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Last AR Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="last_ar_date" value="<?= htmlspecialchars($company->last_ar_date ?? '') ?>" class="form-control col-md-7 col-xs-12 datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Next AR Due Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="next_ar_due_date" value="<?= htmlspecialchars($company->next_ar_due_date ?? '') ?>" class="form-control col-md-7 col-xs-12 datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">AGM Exemption</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="agm_exemption" class="form-control col-md-7 col-xs-12">
                                <option value="">-- Select --</option>
                                <option value="Yes" <?= (isset($company->agm_exemption) && $company->agm_exemption == 'Yes') ? 'selected' : '' ?>>Yes</option>
                                <option value="No" <?= (isset($company->agm_exemption) && $company->agm_exemption == 'No') ? 'selected' : '' ?>>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <!-- ============================================================ -->
                    <!-- CONTACT INFORMATION SECTION -->
                    <!-- ============================================================ -->
                    <h4 class="form-section-heading" style="color:#206570;border-bottom:1px solid #e5e5e5;padding-bottom:8px;margin-bottom:20px;">
                        <i class="fa fa-user"></i> Contact Information
                    </h4>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Contact Person</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="contact_person" value="<?= htmlspecialchars($company->contact_person ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="email" name="email" value="<?= htmlspecialchars($company->email ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone 1</label>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <input type="text" name="phone1_code" value="<?= htmlspecialchars($company->phone1_code ?? '') ?>" class="form-control" placeholder="Country Code">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" name="phone1_number" value="<?= htmlspecialchars($company->phone1_number ?? '') ?>" class="form-control" placeholder="Phone Number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone 2</label>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <input type="text" name="phone2_code" value="<?= htmlspecialchars($company->phone2_code ?? '') ?>" class="form-control" placeholder="Country Code">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" name="phone2_number" value="<?= htmlspecialchars($company->phone2_number ?? '') ?>" class="form-control" placeholder="Phone Number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Telephone</label>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <input type="text" name="telephone_code" value="<?= htmlspecialchars($company->telephone_code ?? '') ?>" class="form-control" placeholder="Country Code">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" name="telephone_number" value="<?= htmlspecialchars($company->telephone_number ?? '') ?>" class="form-control" placeholder="Telephone Number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Fax</label>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <input type="text" name="fax_code" value="<?= htmlspecialchars($company->fax_code ?? '') ?>" class="form-control" placeholder="Country Code">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" name="fax_number" value="<?= htmlspecialchars($company->fax_number ?? '') ?>" class="form-control" placeholder="Fax Number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Website</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="url" name="website" value="<?= htmlspecialchars($company->website ?? '') ?>" class="form-control col-md-7 col-xs-12" placeholder="https://">
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <!-- ============================================================ -->
                    <!-- AUDITOR & BANK SECTION -->
                    <!-- ============================================================ -->
                    <h4 class="form-section-heading" style="color:#206570;border-bottom:1px solid #e5e5e5;padding-bottom:8px;margin-bottom:20px;">
                        <i class="fa fa-bank"></i> Auditor &amp; Bank Information
                    </h4>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Auditor Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="auditor_name" value="<?= htmlspecialchars($company->auditor_name ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Auditor Appointment Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="auditor_appointment_date" value="<?= htmlspecialchars($company->auditor_appointment_date ?? '') ?>" class="form-control col-md-7 col-xs-12 datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Auditor Cessation Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="auditor_cessation_date" value="<?= htmlspecialchars($company->auditor_cessation_date ?? '') ?>" class="form-control col-md-7 col-xs-12 datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Bank Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="bank_name" value="<?= htmlspecialchars($company->bank_name ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Bank Account Number</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="bank_account_number" value="<?= htmlspecialchars($company->bank_account_number ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Bank Branch</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="bank_branch" value="<?= htmlspecialchars($company->bank_branch ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <!-- ============================================================ -->
                    <!-- COMPANY SERVICE SECTION -->
                    <!-- ============================================================ -->
                    <h4 class="form-section-heading" style="color:#206570;border-bottom:1px solid #e5e5e5;padding-bottom:8px;margin-bottom:20px;">
                        <i class="fa fa-cogs"></i> Company Service
                    </h4>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Service Start Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="service_start_date" value="<?= htmlspecialchars($company->service_start_date ?? '') ?>" class="form-control col-md-7 col-xs-12 datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Service End Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="service_end_date" value="<?= htmlspecialchars($company->service_end_date ?? '') ?>" class="form-control col-md-7 col-xs-12 datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Service Fee</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="service_fee" value="<?= htmlspecialchars($company->service_fee ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Service Description</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea name="service_description" class="form-control col-md-7 col-xs-12" rows="3"><?= htmlspecialchars($company->service_description ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Person In Charge</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="person_in_charge" value="<?= htmlspecialchars($company->person_in_charge ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Reviewer</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="reviewer" value="<?= htmlspecialchars($company->reviewer ?? '') ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <!-- ============================================================ -->
                    <!-- REMARKS SECTION -->
                    <!-- ============================================================ -->
                    <h4 class="form-section-heading" style="color:#206570;border-bottom:1px solid #e5e5e5;padding-bottom:8px;margin-bottom:20px;">
                        <i class="fa fa-commenting"></i> Remarks
                    </h4>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Remarks</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea name="remarks" class="form-control col-md-7 col-xs-12" rows="4"><?= htmlspecialchars($company->remarks ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Additional Remarks</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea name="additional_remarks" class="form-control col-md-7 col-xs-12" rows="4"><?= htmlspecialchars($company->additional_remarks ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <!-- ============================================================ -->
                    <!-- FORM ACTIONS -->
                    <!-- ============================================================ -->
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
                            <a href="<?= base_url('view_company/' . $company->id) ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- JAVASCRIPT -->
<!-- ============================================================ -->
<script>
$(document).ready(function() {

    // -------------------------------------------------------
    // Initialize Select2
    // -------------------------------------------------------
    if ($.fn.select2) {
        $('.select2_single').select2({
            placeholder: 'Select an option',
            allowClear: true
        });
        $('.select2_multiple').select2({
            placeholder: 'Select options',
            allowClear: true
        });
    }

    // -------------------------------------------------------
    // Initialize Datepicker
    // -------------------------------------------------------
    if ($.fn.datepicker) {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });
    } else if ($.fn.daterangepicker) {
        // Fallback to daterangepicker in single mode
        $('.datepicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: false,
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Clear'
            }
        });
        $('.datepicker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
        });
        $('.datepicker').on('cancel.daterangepicker', function() {
            $(this).val('');
        });
    }

    // -------------------------------------------------------
    // Form Validation
    // -------------------------------------------------------
    function validateForm() {
        var isValid = true;
        var errors = [];

        // Company Name is required
        var companyName = $('input[name="company_name"]').val().trim();
        if (!companyName) {
            errors.push('Company Name is required.');
            $('input[name="company_name"]').closest('.form-group').addClass('has-error');
            isValid = false;
        } else {
            $('input[name="company_name"]').closest('.form-group').removeClass('has-error');
        }

        // Email validation (if provided)
        var email = $('input[name="email"]').val().trim();
        if (email) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                errors.push('Please enter a valid email address.');
                $('input[name="email"]').closest('.form-group').addClass('has-error');
                isValid = false;
            } else {
                $('input[name="email"]').closest('.form-group').removeClass('has-error');
            }
        }

        // Website validation (if provided)
        var website = $('input[name="website"]').val().trim();
        if (website) {
            try {
                new URL(website);
                $('input[name="website"]').closest('.form-group').removeClass('has-error');
            } catch (e) {
                errors.push('Please enter a valid website URL.');
                $('input[name="website"]').closest('.form-group').addClass('has-error');
                isValid = false;
            }
        }

        if (!isValid) {
            var errorHtml = '<ul style="text-align:left;margin:0;padding-left:20px;">';
            $.each(errors, function(i, msg) {
                errorHtml += '<li>' + msg + '</li>';
            });
            errorHtml += '</ul>';

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errorHtml
                });
            } else {
                alert('Validation Error:\n' + errors.join('\n'));
            }
        }

        return isValid;
    }

    // -------------------------------------------------------
    // Form Submit with SweetAlert Confirmation
    // -------------------------------------------------------
    $('#company-edit-form').on('submit', function(e) {
        e.preventDefault();
        var form = this;

        if (!validateForm()) {
            return false;
        }

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Update Company?',
                text: 'Are you sure you want to save the changes to this company?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#26B99A',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'Cancel'
            }).then(function(result) {
                if (result.isConfirmed || result.value) {
                    form.submit();
                }
            });
        } else if (confirm('Are you sure you want to save the changes to this company?')) {
            form.submit();
        }

        return false;
    });

    // -------------------------------------------------------
    // Remove error highlight on input change
    // -------------------------------------------------------
    $('input, select, textarea').on('change keyup', function() {
        $(this).closest('.form-group').removeClass('has-error');
    });

});
</script>
