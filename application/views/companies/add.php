<!-- Add Company - 5 Step Wizard -->
<div class="page-title">
    <div class="title_left">
        <h3>Add Company</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('company_list') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to List</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Add Company <small>Step-by-step wizard</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <!-- Wizard Steps Navigation -->
                <ul class="wizard_steps anchor" id="wizardSteps">
                    <li class="active">
                        <a href="#step-1" class="selected">
                            <span class="step_no">1</span>
                            <span class="step_descr">Company Details</span>
                        </a>
                    </li>
                    <li>
                        <a href="#step-2" class="disabled">
                            <span class="step_no">2</span>
                            <span class="step_descr">Contact Person</span>
                        </a>
                    </li>
                    <li>
                        <a href="#step-3" class="disabled">
                            <span class="step_no">3</span>
                            <span class="step_descr">Directors</span>
                        </a>
                    </li>
                    <li>
                        <a href="#step-4" class="disabled">
                            <span class="step_no">4</span>
                            <span class="step_descr">Shareholders</span>
                        </a>
                    </li>
                    <li>
                        <a href="#step-5" class="disabled">
                            <span class="step_no">5</span>
                            <span class="step_descr">Secretary</span>
                        </a>
                    </li>
                </ul>

                <form method="POST" action="<?= base_url('add_company') ?>" id="company-details-form" class="form-horizontal form-label-left">
                    <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?>">

                    <!-- ==================== STEP 1: Company Details ==================== -->
                    <div id="step-1" class="step-content" style="display:block;">
                        <h2 class="StepTitle">Company Details</h2>

                        <!-- Client Type Checkboxes -->
                        <div class="form-group" style="background:#f5f5f5;padding:15px;border-radius:5px;margin-bottom:20px;">
                            <label class="control-label col-md-12" style="margin-bottom:10px;"><strong>Client Type</strong></label>
                            <div class="col-md-12">
                                <div class="row">
                                    <?php
                                    $checkboxes = [
                                        'corporate_shareholder_client' => 'CSS Client',
                                        'taxation_client' => 'Taxation Client',
                                        'accounting_client' => 'Accounting Client',
                                        'audit_client' => 'Audit Client',
                                        'outsrc_accounting_client' => 'Outsrc Accounting Client',
                                        'outsrc_tax_client' => 'Outsrc Tax Client',
                                        'payroll_client' => 'Payroll Client',
                                        'compilation_client' => 'Compilation Client',
                                        'ask_client' => 'ASK Client',
                                        'm_and_a_client' => 'M&A Client',
                                        'hr_client' => 'HR Client',
                                        'scrutinisation_client' => 'Scrutinisation Client',
                                        'gst_client' => 'GST Client',
                                        'wp_ep_client' => 'WP/EP Client',
                                        'commercial_accounting_client' => 'Commercial Accounting',
                                        'personal_tax' => 'Personal Tax',
                                        'auditor_checkbox' => 'Auditor',
                                        'corporate_shareholder_checkbox' => 'Corporate Shareholder',
                                        'fund_management' => 'Fund Management',
                                        'corporate_director' => 'Corporate Director',
                                        'corporate_owner' => 'Corporate Owner',
                                        'external_corp_sec' => 'External Corp Sec',
                                        'sub_fund' => 'Sub Fund',
                                        'agent' => 'Agent',
                                        'corporate_controller' => 'Corporate Controller',
                                        'corporate_partner' => 'Corporate Partner',
                                        'represent_office' => 'Representative Office',
                                        'odi' => 'ODI',
                                        'resident_represent' => 'Resident Representative',
                                        'liquidator' => 'Liquidator',
                                        'hrs_client' => 'HRS Client',
                                        'trust_fund' => 'Trust Fund',
                                        'prospect' => 'Prospect',
                                        'client' => 'Client',
                                        'non_client' => 'Non-Client',
                                    ];
                                    $i = 0;
                                    foreach ($checkboxes as $name => $label):
                                    ?>
                                    <div class="col-md-3 col-sm-4 col-xs-6" style="margin-bottom:5px;">
                                        <label>
                                            <input type="checkbox" name="<?= $name ?>" id="<?= $name ?>" value="1"> <?= $label ?>
                                        </label>
                                    </div>
                                    <?php $i++; endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <div class="ln_solid"></div>

                        <!-- Company Name -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Company Name <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="company-name" id="company-name" class="form-control col-md-7 col-xs-12 textarea_format input-box-style-1" required>
                            </div>
                        </div>

                        <!-- Former Name -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Former Name</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="former-name" id="former-name" class="form-control col-md-7 col-xs-12 textarea_format input-box-style-1">
                            </div>
                        </div>

                        <!-- Client ID -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Client ID</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="clientid" id="clientid" class="form-control col-md-7 col-xs-12 textarea_format input-textbox-style-nopad">
                            </div>
                        </div>

                        <!-- Company Type -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Company Type</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="company-type" id="company-type" class="select2_single form-control">
                                    <option value="">Select Company Type</option>
                                    <?php foreach ($company_types as $ct): ?>
                                    <option value="<?= $ct->id ?>"><?= htmlspecialchars($ct->type_name) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Registration Number -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Registration Number</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="reg-num" id="registration-number" class="form-control col-md-7 col-xs-12 textarea_format">
                            </div>
                        </div>

                        <!-- ACRA Registration Number -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">ACRA Registration Number</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="acra_reg_id" id="acra_reg_id" class="form-control col-md-7 col-xs-12 textarea_format">
                            </div>
                        </div>

                        <!-- Country -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Country</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="country" id="country" class="select2_single form-control">
                                    <?php foreach ($countries as $c): ?>
                                    <option value="<?= $c ?>" <?= $c === 'SINGAPORE' ? 'selected' : '' ?>><?= $c ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Region -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Region</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="region" id="region" class="select2_single form-control">
                                    <option value="">Select Region</option>
                                    <option value="Asia Pacific">Asia Pacific</option>
                                    <option value="Europe">Europe</option>
                                    <option value="North America">North America</option>
                                    <option value="South America">South America</option>
                                    <option value="Middle East">Middle East</option>
                                    <option value="Africa">Africa</option>
                                </select>
                            </div>
                        </div>

                        <!-- Internal CSS Status -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Internal CSS Status</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="company_status" id="company_status" class="select2_single form-control">
                                    <option value="">Select Status</option>
                                    <?php foreach (['Pre-Incorporation','Active','Terminated','Dormant','Liquidation in Progress','Dissolved','Striking Off','Struck-Off','De-Registered','Inactive','Liquidated','Cancelled','Amalgamated'] as $s): ?>
                                    <option value="<?= $s ?>"><?= $s ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Risk Assessment Rating -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Risk Assessment Rating</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="risk_assessment_rating" class="form-control col-md-7 col-xs-12">
                                    <option value="">Select Rating</option>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>
                        </div>

                        <!-- Incorporation Date -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Incorporation Date</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="incorp-date" id="single_cal4" class="form-control has-feedback-left datepicker">
                                </div>
                            </div>
                        </div>

                        <!-- Entity Status -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Entity Status</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="company-status" id="company-status" class="select2_single form-control">
                                    <option value="">Select Entity Status</option>
                                    <?php foreach (['Pre-Incorporation','Active','Terminated','Dormant','Liquidation in Progress','Dissolved','Striking Off','Struck-Off','De-Registered','Inactive','Liquidated','Cancelled','Amalgamated'] as $s): ?>
                                    <option value="<?= $s ?>"><?= $s ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Status Dates (conditionally visible) -->
                        <div class="form-group status-date-field" id="strike_off_date_group" style="display:none;">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Strike Off Date</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="strike_off_date" id="strike_off_date" class="form-control has-feedback-left datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group status-date-field" id="liquid_strike_off_date_group" style="display:none;">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Liquid/Strike Off Date</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="liquid_strike_off_date" id="liquid_strike_off_date" class="form-control has-feedback-left datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group status-date-field" id="terminate_date_group" style="display:none;">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Terminate Date</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="terminate_date" id="terminate_date" class="form-control has-feedback-left datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group status-date-field" id="dormant_date_group" style="display:none;">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Dormant Date</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="dormant_date" id="dormant_date" class="form-control has-feedback-left datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group status-date-field" id="liquidated_date_group" style="display:none;">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Liquidated Date</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="liquidated_date" id="liquidated_date" class="form-control has-feedback-left datepicker">
                                </div>
                            </div>
                        </div>

                        <!-- Common Seal -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Common Seal</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="common_seal" class="select2_single form-control">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>

                        <!-- Company Stamp -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Company Stamp</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="company_stamp" class="select2_single form-control">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>

                        <!-- Related Industry -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Related Industry</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="related_industry" id="related_industry" class="form-control select2_single">
                                    <option value="">Select Industry</option>
                                </select>
                            </div>
                        </div>

                        <!-- Market Segment -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Market Segment</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="market_segment" id="market_segment" class="form-control select2_single">
                                    <option value="">Select Segment</option>
                                </select>
                            </div>
                        </div>

                        <!-- Public Interest Company -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Public Interest Company</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="public_interest_company" id="public_interest_company" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>

                        <!-- Legislative Entity Name -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Legislative Entity Name</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="legis_entity_name" id="legis_entity_name" class="form-control col-md-7 col-xs-12 textarea_format">
                            </div>
                        </div>

                        <!-- Financial Institution Date -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Financial Institution Date</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="findate" id="findate" class="form-control has-feedback-left datepicker">
                                </div>
                            </div>
                        </div>

                        <!-- Jurisdiction fields -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jurisdiction of Incorporation</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="jurisdiction_incorp_name" id="jurisdiction_incorp_name" class="form-control col-md-7 col-xs-12 textarea_format">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jurisdiction Corporate Name</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="jurisdiction_corp_name" id="jurisdiction_corp_name" class="form-control col-md-7 col-xs-12 textarea_format">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jurisdiction Corporate ID</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="jurisdiction_corp_id" id="jurisdiction_corp_id" class="form-control col-md-7 col-xs-12 textarea_format">
                            </div>
                        </div>

                        <!-- Person In Charge -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Person In Charge</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="person_in_charge[]" class="form-control select2_multiple" multiple="multiple">
                                </select>
                            </div>
                        </div>

                        <!-- Group Name -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Group Name</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="group_name[]" class="form-control select2_multiple" multiple="multiple">
                                </select>
                            </div>
                        </div>

                        <!-- Holding Company Name -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Holding Company Name</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="holding_company_name[]" class="form-control select2_multiple" multiple="multiple">
                                </select>
                            </div>
                        </div>

                        <!-- Referral Partner -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Referral Partner</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="referral_partner" id="referral_partner" class="form-control select2_single">
                                    <option value="">Select Referral Partner</option>
                                </select>
                            </div>
                        </div>

                        <!-- Individual Referral Partner -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Individual Referral Partner</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="ind_referral_partner[]" id="ind_referral_partner" class="form-control select2_multiple" multiple="multiple">
                                </select>
                            </div>
                        </div>

                        <!-- Company Referral Partner -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Company Referral Partner</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="cmp_referral_partner[]" id="cmp_referral_partner" class="form-control select2_multiple" multiple="multiple">
                                </select>
                            </div>
                        </div>

                        <div class="ln_solid"></div>

                        <!-- ===== Registered Address ===== -->
                        <h4 style="color:#206570;"><i class="fa fa-map-marker"></i> Registered Address</h4>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Address Type</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="reg-address" id="address_type_dropdown" class="form-control">
                                    <option value="Registered Office">Registered Office</option>
                                    <option value="Business Address">Business Address</option>
                                    <option value="Mailing Address">Mailing Address</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Block</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="reg_add_block" class="form-control textarea_class">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Street / Address</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="reg-address" id="reg-address" class="form-control textarea_class" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Building</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="reg_add_building" class="form-control textarea_class">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-6 col-sm-6 col-xs-12">Level</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="reg_add_level" class="form-control textarea_class">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Unit</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="reg_add_unit" class="form-control textarea_class">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Country</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="reg_country" class="select2_single form-control">
                                    <?php foreach ($countries as $c): ?>
                                    <option value="<?= $c ?>" <?= $c === 'SINGAPORE' ? 'selected' : '' ?>><?= $c ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">State</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="reg_add_state" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">City</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="reg_add_city" class="form-control textarea_class">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Postal Code</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="reg_add_pcode" class="form-control textarea_class">
                            </div>
                        </div>

                        <!-- Other Addresses (clonable) -->
                        <div class="ln_solid"></div>
                        <h4 style="color:#206570;"><i class="fa fa-map-marker"></i> Other Address
                            <button type="button" class="btn btn-success btn-xs pull-right" id="addOtherAddress"><i class="fa fa-plus"></i> Add Address</button>
                        </h4>
                        <div id="otherAddressContainer">
                            <div class="other-address-row" style="background:#f9f9f9;padding:15px;border-radius:5px;margin-bottom:10px;">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Default</label>
                                    <div class="col-md-6"><input type="radio" name="default_address" value="0" class="com_default_address"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Address Type</label>
                                    <div class="col-md-6">
                                        <select name="address_type[]" class="form-control address_type">
                                            <option value="Business Address">Business Address</option>
                                            <option value="Mailing Address">Mailing Address</option>
                                            <option value="Registered Office">Registered Office</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Care Of</label>
                                    <div class="col-md-6"><input type="text" name="other_add_care_of[]" class="form-control textarea_class"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Block</label>
                                    <div class="col-md-6"><input type="text" name="other_add_block[]" class="form-control textarea_class"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Street / Address</label>
                                    <div class="col-md-6"><textarea name="other_add_address_text[]" class="form-control textarea_class" rows="2"></textarea></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Building</label>
                                    <div class="col-md-6"><textarea name="other_add_building[]" class="form-control textarea_class" rows="1"></textarea></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-6">Level</label>
                                            <div class="col-md-6"><input type="text" name="other_add_level[]" class="form-control textarea_class"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Unit</label>
                                            <div class="col-md-6"><input type="text" name="other_add_unit[]" class="form-control textarea_class"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Country</label>
                                    <div class="col-md-6">
                                        <select name="other_add_country[]" class="form-control select2_single">
                                            <?php foreach ($countries as $c): ?>
                                            <option value="<?= $c ?>" <?= $c === 'SINGAPORE' ? 'selected' : '' ?>><?= $c ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">State</label>
                                    <div class="col-md-6"><input type="text" name="other_add_state[]" class="form-control"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">City</label>
                                    <div class="col-md-6"><input type="text" name="other_add_city[]" class="form-control textarea_class"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Postal Code</label>
                                    <div class="col-md-6"><input type="text" name="other_add_pcode[]" class="form-control textarea_class"></div>
                                </div>
                                <button type="button" class="btn btn-danger btn-xs removeOtherAddress"><i class="fa fa-trash"></i> Remove</button>
                            </div>
                        </div>

                        <div class="ln_solid"></div>

                        <!-- ===== SSIC Activities ===== -->
                        <h4 style="color:#206570;"><i class="fa fa-industry"></i> SSIC Activities</h4>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Primary Activity (SSIC 1)</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="act-one" id="activities_1" class="select2_single form-control">
                                    <option value="">Select Activity</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="actone-desc" class="form-control act_one_desc" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Secondary Activity (SSIC 2)</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="act-two" id="activities_2" class="select2_single form-control">
                                    <option value="">Select Activity</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="acttwo-desc" class="form-control act_two_desc" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="ln_solid"></div>

                        <!-- ===== Share Capital ===== -->
                        <h4 style="color:#206570;"><i class="fa fa-money"></i> Share Capital</h4>

                        <h5><strong>Ordinary Share Capital</strong></h5>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Issued Share Capital <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" name="ord_issued_share_capital" id="number" class="form-control col-md-7 col-xs-12" placeholder="(Amount)" required value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Currency</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="ord_currency" id="currency" class="select2_single form-control">
                                    <option value="SGD" selected>SGD</option>
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>
                                    <option value="GBP">GBP</option>
                                    <option value="JPY">JPY</option>
                                    <option value="AUD">AUD</option>
                                    <option value="CAD">CAD</option>
                                    <option value="CHF">CHF</option>
                                    <option value="CNY">CNY</option>
                                    <option value="HKD">HKD</option>
                                    <option value="MYR">MYR</option>
                                    <option value="INR">INR</option>
                                    <option value="IDR">IDR</option>
                                    <option value="THB">THB</option>
                                    <option value="PHP">PHP</option>
                                    <option value="KRW">KRW</option>
                                    <option value="TWD">TWD</option>
                                    <option value="NZD">NZD</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Number of Shares</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="no_ord_shares" id="No-shares" class="form-control col-md-7 col-xs-12" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Paid Up Capital</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="paid_up_capital" class="form-control col-md-7 col-xs-12" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Paid Up Capital Currency</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="paid_up_capital_currency" class="select2_single form-control">
                                    <option value="SGD" selected>SGD</option>
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>
                                    <option value="GBP">GBP</option>
                                </select>
                            </div>
                        </div>

                        <h5><strong>Special/Preference Share Capital</strong></h5>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Issued Share Capital <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" name="spec_issued_share_capital" class="form-control col-md-7 col-xs-12" placeholder="(Amount)" required value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Currency</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="spec_currency" id="currency-spl" class="select2_single form-control">
                                    <option value="SGD" selected>SGD</option>
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>
                                    <option value="GBP">GBP</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Number of Shares</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="no_spec_shares" id="No-shares-spl" class="form-control col-md-7 col-xs-12" value="0">
                            </div>
                        </div>
                        <input type="hidden" name="share-type" id="share-type">

                        <div class="ln_solid"></div>

                        <!-- ===== AGM / AR / FYE ===== -->
                        <h4 style="color:#206570;"><i class="fa fa-calendar-check-o"></i> AGM / AR / FYE</h4>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Next AGM Due</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="next-agm-due" id="single_cal6" class="form-control has-feedback-left datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Date of Last AGM</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="date-agm" id="single_cal1" class="form-control has-feedback-left datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Date of Last AR</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="date-ar" id="single_cal2" class="form-control has-feedback-left datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Last AR Filing Date</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="last-ar-fili" id="single_cal10" class="form-control has-feedback-left datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">FYE Date</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="date-fye" id="single_cal8" class="form-control has-feedback-left datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="ln_solid"></div>

                        <!-- ===== Contact & Other Info ===== -->
                        <h4 style="color:#206570;"><i class="fa fa-info-circle"></i> Contact & Other Info</h4>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Contact Person</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="contact_person" id="contact_person" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Auditor Name</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="auditor_name" id="auditor_name" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>

                        <!-- Bank Details -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Bank Name</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="bank_name" id="bank_name" class="select2_single form-control">
                                    <option value="">Select Bank</option>
                                    <option value="DBS">DBS</option>
                                    <option value="OCBC">OCBC</option>
                                    <option value="UOB">UOB</option>
                                    <option value="Standard Chartered">Standard Chartered</option>
                                    <option value="HSBC">HSBC</option>
                                    <option value="Citibank">Citibank</option>
                                    <option value="Maybank">Maybank</option>
                                    <option value="CIMB">CIMB</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Account Number</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="acc_no" id="bank_currency" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>

                        <!-- Signatory Authority -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Signatory Authority 1</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="sig_auth_p1" id="sig_auth_p1" class="select2_single form-control">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Signatory Authority 2</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="sig_auth_p2" id="sig_auth_p2" class="select2_single form-control">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Signatory Authority 3</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="sig_auth_p3" id="sig_auth_p3" class="select2_single form-control">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>

                        <!-- Company Service -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Company Service Name</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="company_service_name" id="company_service_name" class="select2_single form-control">
                                    <option value="">Select Service</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Service Appointment Date</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="service_appoint_date" id="service_appoint_date" class="form-control has-feedback-left datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Service Termination Date</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="service_termination_date" id="service_termination_date" class="form-control has-feedback-left datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Service Status</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="service_status" id="service_status" class="select2_single form-control">
                                    <option value="">Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Terminated">Terminated</option>
                                </select>
                            </div>
                        </div>

                        <div class="ln_solid"></div>

                        <!-- ===== Phone / Contact ===== -->
                        <h4 style="color:#206570;"><i class="fa fa-phone"></i> Contact Information</h4>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
                            <div class="col-md-2 col-sm-2 col-xs-4">
                                <select name="company_contact_code" id="director-contact-code-com" class="form-control select2_single">
                                    <option value="65" selected>+65</option>
                                    <option value="60">+60</option>
                                    <option value="62">+62</option>
                                    <option value="63">+63</option>
                                    <option value="66">+66</option>
                                    <option value="84">+84</option>
                                    <option value="91">+91</option>
                                    <option value="86">+86</option>
                                    <option value="81">+81</option>
                                    <option value="82">+82</option>
                                    <option value="44">+44</option>
                                    <option value="1">+1</option>
                                    <option value="61">+61</option>
                                    <option value="852">+852</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-8">
                                <input type="text" name="company-contact-number" id="member-contact-number" class="form-control col-md-7 col-xs-12 phone_no_class">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Telephone</label>
                            <div class="col-md-2 col-sm-2 col-xs-4">
                                <select name="company_telephone_code" id="director-telephone-code" class="form-control select2_single">
                                    <option value="65" selected>+65</option>
                                    <option value="60">+60</option>
                                    <option value="1">+1</option>
                                    <option value="44">+44</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-8">
                                <input type="text" name="company-telephone-number" id="member-telephone-number" class="form-control col-md-7 col-xs-12 phone_no_class">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Fax</label>
                            <div class="col-md-2 col-sm-2 col-xs-4">
                                <select name="company_fax_code" id="company-fax-code" class="form-control select2_single">
                                    <option value="65" selected>+65</option>
                                    <option value="60">+60</option>
                                    <option value="1">+1</option>
                                    <option value="44">+44</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-8">
                                <input type="text" name="company_fax" id="company_fax" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Website</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="company_website" id="company_website" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="email" name="company_email" id="member-email-address" class="form-control col-md-7 col-xs-12 email_class">
                            </div>
                        </div>

                        <div class="ln_solid"></div>

                        <!-- Remarks -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Remarks</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="remarks" id="remarks" class="textarea_format form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Additional Remarks</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="additional_remarks" id="additional_remarks" class="textarea_format form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- END Step 1 -->

                    <!-- ==================== STEP 2: Contact Person ==================== -->
                    <div id="step-2" class="step-content" style="display:none;">
                        <h2 class="StepTitle">Contact Person</h2>
                        <div id="cp-container">
                            <div class="cp-row officer-row" style="background:#f9f9f9;padding:15px;border-radius:5px;margin-bottom:15px;border-left:4px solid #206570;">
                                <h5><strong>Contact Person #1</strong></h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">ID Type</label>
                                            <div class="col-md-8">
                                                <select name="contactp_id_type[]" class="form-control contactp_id_type">
                                                    <option value="">Select</option>
                                                    <option value="NRIC">NRIC</option>
                                                    <option value="Passport">Passport</option>
                                                    <option value="FIN">FIN</option>
                                                    <option value="Birth Certificate">Birth Certificate</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">ID Expiry Date</label>
                                            <div class="col-md-8">
                                                <input type="text" name="contactp-id-expired-date[]" class="form-control datepicker contactp_id_expired_date">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">NRIC/Passport No</label>
                                            <div class="col-md-8">
                                                <input type="text" name="contactp-passport[]" class="form-control cp-nric-pass">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Name</label>
                                            <div class="col-md-8">
                                                <input type="text" name="contactp-name[]" class="form-control cp_name">
                                                <input type="hidden" name="contactp_id[]" class="contactp_id">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Nationality</label>
                                            <div class="col-md-8">
                                                <input type="text" name="contactp-nationality[]" class="form-control cp-nat">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Email</label>
                                            <div class="col-md-8">
                                                <input type="email" name="contactp-email-address[]" class="form-control cp-emil-add">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Contact Number</label>
                                            <div class="col-md-8">
                                                <input type="text" name="contactp-contact-number[]" class="form-control cp-cnt-num">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Date of Birth</label>
                                            <div class="col-md-8">
                                                <input type="text" name="contactp-dob[]" class="form-control datepicker cp-dob">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Local Address</label>
                                            <div class="col-md-8">
                                                <textarea name="contactp-local-address[]" class="form-control cp-loc-add" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Foreign Address</label>
                                            <div class="col-md-8">
                                                <textarea name="contactp-foreign-address[]" class="form-control cp-foreign-add" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Alt Local Address</label>
                                            <div class="col-md-8">
                                                <textarea name="contactp-alt-local-address[]" class="form-control cp-alt-loc-add" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Alt Foreign Address</label>
                                            <div class="col-md-8">
                                                <textarea name="contactp-alt-foreign-address[]" class="form-control cp-alt-foreign-add" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Date of Appointment</label>
                                            <div class="col-md-8">
                                                <label><input type="radio" name="cp_appt_proposed_or_effective1" class="cp_appt_proposed_or_effective" value="Proposed"> Proposed</label>
                                                <label><input type="radio" name="cp_appt_proposed_or_effective1" class="cp_appt_proposed_or_effective" value="Effective"> Effective</label>
                                                <input type="text" name="contactp-doapp[]" class="form-control datepicker cp-dt-appoint" style="margin-top:5px;">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Date of Cessation</label>
                                            <div class="col-md-8">
                                                <label><input type="radio" name="cp_cess_proposed_or_effective1" class="cp_cess_proposed_or_effective" value="Proposed"> Proposed</label>
                                                <label><input type="radio" name="cp_cess_proposed_or_effective1" class="cp_cess_proposed_or_effective" value="Effective"> Effective</label>
                                                <input type="text" name="cp-doc[]" class="form-control datepicker cp-doc" style="margin-top:5px;">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Company Email</label>
                                            <div class="col-md-8">
                                                <input type="email" name="cp-company-email-address[]" class="form-control cp_company_email_address">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Company Contact</label>
                                            <div class="col-md-4">
                                                <select name="cp-company-contact-code" class="form-control cp_company_contact_code">
                                                    <option value="65">+65</option>
                                                    <option value="60">+60</option>
                                                    <option value="1">+1</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="cp-company-contact-number[]" class="form-control cp_company_contact_number">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="button" id="btnAdd4" class="btn btn-success" value="Add Contact Person">
                            <input type="button" id="btnDel4" class="btn btn-danger" value="Remove Last">
                        </div>
                    </div>
                    <!-- END Step 2 -->

                    <!-- ==================== STEP 3: Directors ==================== -->
                    <div id="step-3" class="step-content" style="display:none;">
                        <h2 class="StepTitle">Directors</h2>
                        <div id="director-container">
                            <div class="director-row officer-row" style="background:#f9f9f9;padding:15px;border-radius:5px;margin-bottom:15px;border-left:4px solid #26B99A;">
                                <h5><strong>Director #1</strong></h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">ID Type</label>
                                            <div class="col-md-8">
                                                <select name="director_id_type[]" class="form-control director_id_type">
                                                    <option value="">Select</option>
                                                    <option value="NRIC">NRIC</option>
                                                    <option value="Passport">Passport</option>
                                                    <option value="FIN">FIN</option>
                                                    <option value="Birth Certificate">Birth Certificate</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">ID Expiry Date</label>
                                            <div class="col-md-8">
                                                <input type="text" name="director-id-expired-date[]" class="form-control datepicker director_id_expired_date">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">NRIC/Passport No</label>
                                            <div class="col-md-8">
                                                <input type="text" name="director-passport[]" class="form-control nric-pass">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Name</label>
                                            <div class="col-md-8">
                                                <input type="text" name="director-name[]" class="form-control dir_name">
                                                <input type="hidden" name="director_id[]" class="director_id">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Nationality</label>
                                            <div class="col-md-8">
                                                <input type="text" name="director-nationality[]" class="form-control dir-nat">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Email</label>
                                            <div class="col-md-8">
                                                <input type="email" name="director-email-address[]" class="form-control emil-add">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Contact Number</label>
                                            <div class="col-md-8">
                                                <input type="text" name="director-contact-number[]" class="form-control dir-cnt-num">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Date of Birth</label>
                                            <div class="col-md-8">
                                                <input type="text" name="director-dob[]" class="form-control datepicker dir-dob">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Business Occupation</label>
                                            <div class="col-md-8">
                                                <textarea name="dir_business_occupation[]" class="form-control dir_business_occupation textarea_format2" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Other Directorship</label>
                                            <div class="col-md-8">
                                                <textarea name="dir_other_directorship[]" class="form-control dir_other_directorship textarea_format2" rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Local Address</label>
                                            <div class="col-md-8">
                                                <textarea name="direcetor-local-address[]" class="form-control loc-add" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Foreign Address</label>
                                            <div class="col-md-8">
                                                <textarea name="direcetor-foreign-address[]" class="form-control for-add" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Alt Local Address</label>
                                            <div class="col-md-8">
                                                <textarea name="direcetor-alt-local-address[]" class="form-control alt-loc-add" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Alt Foreign Address</label>
                                            <div class="col-md-8">
                                                <textarea name="direcetor-alt-foreign-address[]" class="form-control alt-for-add" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Nominee Director</label>
                                            <div class="col-md-8">
                                                <label><input type="radio" name="nominee_dir" class="nominee_dir" value="Yes"> Yes</label>
                                                <label><input type="radio" name="nominee_dir" class="nominee_dir" value="No" checked> No</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Registrable Controller</label>
                                            <div class="col-md-8">
                                                <label><input type="radio" name="reg_controller" class="reg_controller" value="Yes"> Yes</label>
                                                <label><input type="radio" name="reg_controller" class="reg_controller" value="No" checked> No</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Date of Appointment</label>
                                            <div class="col-md-8">
                                                <label><input type="radio" name="dir_appt_proposed_or_effective1" class="dir_appt_proposed_or_effective" value="Proposed"> Proposed</label>
                                                <label><input type="radio" name="dir_appt_proposed_or_effective1" class="dir_appt_proposed_or_effective" value="Effective"> Effective</label>
                                                <input type="text" name="director-doapp[]" class="form-control datepicker dt-appoint director_doapp" style="margin-top:5px;">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Date of Cessation</label>
                                            <div class="col-md-8">
                                                <label><input type="radio" name="dir_cess_proposed_or_effective1" class="dir_cess_proposed_or_effective" value="Proposed"> Proposed</label>
                                                <label><input type="radio" name="dir_cess_proposed_or_effective1" class="dir_cess_proposed_or_effective" value="Effective"> Effective</label>
                                                <input type="text" name="director-doc[]" class="form-control datepicker director-doc" style="margin-top:5px;">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Company Email</label>
                                            <div class="col-md-8">
                                                <input type="email" name="dir-company-email-address[]" class="form-control dir_company_email_address textarea_format2">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Company Contact</label>
                                            <div class="col-md-4">
                                                <select name="dir-company-contact-code" class="form-control dir_company_contact_code">
                                                    <option value="65">+65</option>
                                                    <option value="60">+60</option>
                                                    <option value="1">+1</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="dir-company-contact-number[]" class="form-control dir_company_contact_number textarea_format2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="button" id="btnAdd" class="btn btn-success" value="Add Director">
                            <input type="button" id="btnDel" class="btn btn-danger" value="Remove Last">
                        </div>
                    </div>
                    <!-- END Step 3 -->

                    <!-- ==================== STEP 4: Shareholders ==================== -->
                    <div id="step-4" class="step-content" style="display:none;">
                        <h2 class="StepTitle">Shareholders</h2>
                        <div id="sh-container">
                            <div class="sh-row officer-row" style="background:#f9f9f9;padding:15px;border-radius:5px;margin-bottom:15px;border-left:4px solid #F0AD4E;">
                                <h5><strong>Shareholder #1</strong></h5>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Shareholder Type <span class="required">*</span></label>
                                    <div class="col-md-6">
                                        <select name="shareholder_type[]" class="form-control shareholder_type" required>
                                            <option value="">Select Type</option>
                                            <option value="Individual">Individual</option>
                                            <option value="Corporate">Corporate</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Individual Shareholder Fields -->
                                <div class="sh-individual-fields">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">ID Type</label>
                                                <div class="col-md-8">
                                                    <select name="shareh_id_type[]" class="form-control shareh_id_type">
                                                        <option value="">Select</option>
                                                        <option value="NRIC">NRIC</option>
                                                        <option value="Passport">Passport</option>
                                                        <option value="FIN">FIN</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">ID Expiry Date</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="shareh-id-expired-date[]" class="form-control datepicker shareh_id_expired_date">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">NRIC/Passport No</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="shareh-passport[]" class="form-control sh-nric-pass">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Name</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="shareh-name[]" class="form-control sh_name">
                                                    <input type="hidden" name="shareh_id[]" class="shareh_id">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Nationality</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="shareh-nationality[]" class="form-control sh-nat">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Email</label>
                                                <div class="col-md-8">
                                                    <input type="email" name="shareh-email-address[]" class="form-control sh-emil-add">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Contact Number</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="shareh-contact-number[]" class="form-control sh-cnt-num">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Date of Birth</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="shareh-dob[]" class="form-control datepicker sh-dob">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Local Address</label>
                                                <div class="col-md-8">
                                                    <textarea name="shareh-local-address[]" class="form-control sh-loc-add" rows="2"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Foreign Address</label>
                                                <div class="col-md-8">
                                                    <textarea name="shareh-foreign-address[]" class="form-control sh-foreign-add" rows="2"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Alt Local Address</label>
                                                <div class="col-md-8">
                                                    <textarea name="shareh-alt-local-address[]" class="form-control sh-alt-loc-add" rows="2"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Alt Foreign Address</label>
                                                <div class="col-md-8">
                                                    <textarea name="shareh-alt-foreign-address[]" class="form-control sh-alt-foreign-add" rows="2"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Date of Appointment</label>
                                                <div class="col-md-8">
                                                    <label><input type="radio" name="sh_appt_proposed_or_effective1" value="Proposed"> Proposed</label>
                                                    <label><input type="radio" name="sh_appt_proposed_or_effective1" value="Effective"> Effective</label>
                                                    <input type="text" name="shareh-doapp[]" class="form-control datepicker sh-dt-appoint" style="margin-top:5px;">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Date of Cessation</label>
                                                <div class="col-md-8">
                                                    <label><input type="radio" name="sh_cess_proposed_or_effective1" value="Proposed"> Proposed</label>
                                                    <label><input type="radio" name="sh_cess_proposed_or_effective1" value="Effective"> Effective</label>
                                                    <input type="text" name="sh-doc[]" class="form-control datepicker sh-doc" style="margin-top:5px;">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Company Email</label>
                                                <div class="col-md-8">
                                                    <input type="email" name="sh-company-email-address[]" class="form-control sh_company_email_address">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Corporate Shareholder Fields (hidden by default) -->
                                <div class="sh-corporate-fields" style="display:none;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Registration No.</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="shareh-passport[]" class="form-control company_registration_number" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Company Name</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="shareh-name[]" class="form-control company_name readonly_class" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Company Type</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="company_type[]" class="form-control company_type" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Reg. Office Address</label>
                                                <div class="col-md-8">
                                                    <textarea name="company_reg_office_address[]" class="form-control company_reg_office_address" rows="2" disabled></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Incorp. Date</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="company_incorporation_date[]" class="form-control datepicker company_incorporation_date" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Country</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="company_country[]" class="form-control company_country" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Status</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="company_status1[]" class="form-control company_status" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="button" id="btnAdd5" class="btn btn-success" value="Add Shareholder">
                            <input type="button" id="btnDel5" class="btn btn-danger" value="Remove Last">
                        </div>
                    </div>
                    <!-- END Step 4 -->

                    <!-- ==================== STEP 5: Secretary ==================== -->
                    <div id="step-5" class="step-content" style="display:none;">
                        <h2 class="StepTitle">Secretary</h2>
                        <div id="sec-container">
                            <div class="sec-row officer-row" style="background:#f9f9f9;padding:15px;border-radius:5px;margin-bottom:15px;border-left:4px solid #D9534F;">
                                <h5><strong>Secretary #1</strong></h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">ID Type</label>
                                            <div class="col-md-8">
                                                <select name="secretary_id_type[]" class="form-control secretary_id_type">
                                                    <option value="">Select</option>
                                                    <option value="NRIC">NRIC</option>
                                                    <option value="Passport">Passport</option>
                                                    <option value="FIN">FIN</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">ID Expiry Date</label>
                                            <div class="col-md-8">
                                                <input type="text" name="secreatary-id-expired-date[]" class="form-control datepicker secretary_id_expired_date">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">NRIC/Passport No</label>
                                            <div class="col-md-8">
                                                <input type="text" name="secreatary-passport[]" class="form-control sec-nric-pass">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Name</label>
                                            <div class="col-md-8">
                                                <input type="text" name="secreatary-name[]" class="form-control sec_name">
                                                <input type="hidden" name="secretary_id[]" class="secretary_id">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Nationality</label>
                                            <div class="col-md-8">
                                                <input type="text" name="secreatary-nationality[]" class="form-control sec-nat">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Email</label>
                                            <div class="col-md-8">
                                                <input type="email" name="secreatary-email-address[]" class="form-control sec-emil-add">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Contact Number</label>
                                            <div class="col-md-8">
                                                <input type="text" name="secreatary-contact-number[]" class="form-control sec-cnt-num">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Date of Birth</label>
                                            <div class="col-md-8">
                                                <input type="text" name="secreatary-dob[]" class="form-control datepicker sec-dob">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Local Address</label>
                                            <div class="col-md-8">
                                                <textarea name="secreatary-local-address[]" class="form-control sec-loc-add" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Foreign Address</label>
                                            <div class="col-md-8">
                                                <textarea name="secreatary-foreign-address[]" class="form-control sec-foreign-add" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Alt Local Address</label>
                                            <div class="col-md-8">
                                                <textarea name="secreatary-alt-local-address[]" class="form-control sec-alt-loc-add" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Alt Foreign Address</label>
                                            <div class="col-md-8">
                                                <textarea name="secreatary-alt-foreign-address[]" class="form-control sec-alt-foreign-add" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Date of Appointment</label>
                                            <div class="col-md-8">
                                                <label><input type="radio" name="sec_appt_proposed_or_effective1" value="Proposed"> Proposed</label>
                                                <label><input type="radio" name="sec_appt_proposed_or_effective1" value="Effective"> Effective</label>
                                                <input type="text" name="secreatary-doapp[]" class="form-control datepicker sec-dt-appoint" style="margin-top:5px;">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Date of Cessation</label>
                                            <div class="col-md-8">
                                                <label><input type="radio" name="sec_cess_proposed_or_effective1" value="Proposed"> Proposed</label>
                                                <label><input type="radio" name="sec_cess_proposed_or_effective1" value="Effective"> Effective</label>
                                                <input type="text" name="sec-doc[]" class="form-control datepicker sec-doc" style="margin-top:5px;">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Company Email</label>
                                            <div class="col-md-8">
                                                <input type="email" name="sec-company-email-address[]" class="form-control sec_company_email_address">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Company Contact</label>
                                            <div class="col-md-4">
                                                <select name="sec-company-contact-code" class="form-control sec_company_contact_code">
                                                    <option value="65">+65</option>
                                                    <option value="60">+60</option>
                                                    <option value="1">+1</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="sec-company-contact-number[]" class="form-control sec_company_contact_number">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="button" id="btnAdd2" class="btn btn-success" value="Add Secretary">
                            <input type="button" id="btnDel2" class="btn btn-danger" value="Remove Last">
                        </div>
                    </div>
                    <!-- END Step 5 -->

                    <!-- ===== Navigation Buttons ===== -->
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 text-center">
                            <button type="button" class="btn btn-default btn-lg" id="prevBtn" style="display:none;">
                                <i class="fa fa-arrow-left"></i> Previous
                            </button>
                            <button type="button" class="btn btn-success btn-lg" id="nextBtn">
                                Next <i class="fa fa-arrow-right"></i>
                            </button>
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" style="display:none;">
                                <i class="fa fa-check"></i> Submit Company
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<!-- Wizard Custom Styles -->
<style>
.wizard_steps { list-style: none; padding: 0; display: flex; margin-bottom: 30px; border-bottom: 2px solid #e5e5e5; }
.wizard_steps li { flex: 1; text-align: center; padding: 15px 10px; position: relative; cursor: pointer; }
.wizard_steps li.active a { color: #206570; }
.wizard_steps li.active { border-bottom: 3px solid #206570; }
.wizard_steps li.done { border-bottom: 3px solid #26B99A; }
.wizard_steps li.done a { color: #26B99A; }
.wizard_steps li a { text-decoration: none; color: #999; }
.wizard_steps .step_no { display: block; font-size: 24px; font-weight: bold; margin-bottom: 5px; }
.wizard_steps .step_descr { display: block; font-size: 12px; }
.step-content { min-height: 400px; }
.StepTitle { color: #206570; border-bottom: 2px solid #e5e5e5; padding-bottom: 10px; margin-bottom: 20px; }
.officer-row { transition: all 0.3s ease; }
.officer-row:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.ln_solid { border-top: 1px solid #e5e5e5; margin: 20px 0; }
.required { color: red; }
</style>

<script>
$(document).ready(function() {
    var currentStep = 1;
    var totalSteps = 5;

    // Initialize Select2
    if ($.fn.select2) {
        $('.select2_single').select2({ allowClear: true, width: '100%' });
        $('.select2_multiple').select2({ width: '100%' });
    }

    // Initialize datepickers
    $('.datepicker').each(function() {
        if ($.fn.daterangepicker) {
            $(this).daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoUpdateInput: false,
                locale: { format: 'DD/MM/YYYY' }
            }).on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY'));
            });
        }
    });

    // Step navigation
    function showStep(step) {
        $('.step-content').hide();
        $('#step-' + step).show();

        // Update wizard tabs
        $('#wizardSteps li').each(function(idx) {
            var li = $(this);
            var stepNum = idx + 1;
            li.removeClass('active done');
            if (stepNum < step) li.addClass('done');
            if (stepNum === step) li.addClass('active');
        });

        // Update buttons
        $('#prevBtn').toggle(step > 1);
        $('#nextBtn').toggle(step < totalSteps);
        $('#submitBtn').toggle(step === totalSteps);

        currentStep = step;
        $('html, body').animate({ scrollTop: 0 }, 300);
    }

    // Tab click navigation
    $('#wizardSteps li').click(function() {
        var idx = $(this).index() + 1;
        showStep(idx);
    });

    $('#nextBtn').click(function() {
        if (currentStep === 1) {
            var companyName = $('input[name="company-name"]').val();
            if (!companyName) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire('Validation Error', 'Company Name is required.', 'warning');
                } else {
                    alert('Company Name is required.');
                }
                return;
            }
        }
        if (currentStep < totalSteps) showStep(currentStep + 1);
    });

    $('#prevBtn').click(function() {
        if (currentStep > 1) showStep(currentStep - 1);
    });

    // Entity status change - show/hide date fields
    $('#company-status').change(function() {
        var status = $(this).val();
        $('.status-date-field').hide();
        if (status === 'Striking Off' || status === 'Struck-Off') {
            $('#strike_off_date_group, #liquid_strike_off_date_group').show();
        } else if (status === 'Terminated') {
            $('#terminate_date_group').show();
        } else if (status === 'Dormant') {
            $('#dormant_date_group').show();
        } else if (status === 'Liquidated' || status === 'Liquidation in Progress') {
            $('#liquidated_date_group').show();
        }
    });

    // === Clone row functions ===
    var cpCount = 1;
    $('#btnAdd4').click(function() {
        cpCount++;
        var clone = $('#cp-container .cp-row:first').clone();
        clone.find('input, textarea, select').val('');
        clone.find('h5 strong').text('Contact Person #' + cpCount);
        // Update radio names to be unique per row
        clone.find('[name^="cp_appt_proposed_or_effective"]').attr('name', 'cp_appt_proposed_or_effective' + cpCount);
        clone.find('[name^="cp_cess_proposed_or_effective"]').attr('name', 'cp_cess_proposed_or_effective' + cpCount);
        $('#cp-container').append(clone);
        initNewRowPlugins(clone);
    });
    $('#btnDel4').click(function() {
        if ($('#cp-container .cp-row').length > 1) {
            $('#cp-container .cp-row:last').remove();
            cpCount--;
        }
    });

    var dirCount = 1;
    $('#btnAdd').click(function() {
        dirCount++;
        var clone = $('#director-container .director-row:first').clone();
        clone.find('input, textarea, select').val('');
        clone.find('h5 strong').text('Director #' + dirCount);
        clone.find('[name^="dir_appt_proposed_or_effective"]').attr('name', 'dir_appt_proposed_or_effective' + dirCount);
        clone.find('[name^="dir_cess_proposed_or_effective"]').attr('name', 'dir_cess_proposed_or_effective' + dirCount);
        clone.find('[name^="nominee_dir"]').attr('name', 'nominee_dir' + dirCount);
        clone.find('[name^="reg_controller"]').attr('name', 'reg_controller' + dirCount);
        $('#director-container').append(clone);
        initNewRowPlugins(clone);
    });
    $('#btnDel').click(function() {
        if ($('#director-container .director-row').length > 1) {
            $('#director-container .director-row:last').remove();
            dirCount--;
        }
    });

    var shCount = 1;
    $('#btnAdd5').click(function() {
        shCount++;
        var clone = $('#sh-container .sh-row:first').clone();
        clone.find('input, textarea, select').val('');
        clone.find('.sh-corporate-fields').hide();
        clone.find('.sh-individual-fields').show();
        clone.find('.sh-corporate-fields input, .sh-corporate-fields textarea').prop('disabled', true);
        clone.find('.sh-individual-fields input, .sh-individual-fields textarea, .sh-individual-fields select').prop('disabled', false);
        clone.find('h5 strong').text('Shareholder #' + shCount);
        clone.find('[name^="sh_appt_proposed_or_effective"]').attr('name', 'sh_appt_proposed_or_effective' + shCount);
        clone.find('[name^="sh_cess_proposed_or_effective"]').attr('name', 'sh_cess_proposed_or_effective' + shCount);
        $('#sh-container').append(clone);
        initNewRowPlugins(clone);
        bindShareholderTypeChange(clone);
    });
    $('#btnDel5').click(function() {
        if ($('#sh-container .sh-row').length > 1) {
            $('#sh-container .sh-row:last').remove();
            shCount--;
        }
    });

    var secCount = 1;
    $('#btnAdd2').click(function() {
        secCount++;
        var clone = $('#sec-container .sec-row:first').clone();
        clone.find('input, textarea, select').val('');
        clone.find('h5 strong').text('Secretary #' + secCount);
        clone.find('[name^="sec_appt_proposed_or_effective"]').attr('name', 'sec_appt_proposed_or_effective' + secCount);
        clone.find('[name^="sec_cess_proposed_or_effective"]').attr('name', 'sec_cess_proposed_or_effective' + secCount);
        $('#sec-container').append(clone);
        initNewRowPlugins(clone);
    });
    $('#btnDel2').click(function() {
        if ($('#sec-container .sec-row').length > 1) {
            $('#sec-container .sec-row:last').remove();
            secCount--;
        }
    });

    // Shareholder type toggle (Individual vs Corporate)
    function bindShareholderTypeChange(row) {
        row.find('.shareholder_type').change(function() {
            var type = $(this).val();
            var parentRow = $(this).closest('.sh-row');
            if (type === 'Corporate') {
                parentRow.find('.sh-individual-fields').hide();
                parentRow.find('.sh-individual-fields input, .sh-individual-fields textarea, .sh-individual-fields select').prop('disabled', true);
                parentRow.find('.sh-corporate-fields').show();
                parentRow.find('.sh-corporate-fields input, .sh-corporate-fields textarea').prop('disabled', false);
            } else {
                parentRow.find('.sh-corporate-fields').hide();
                parentRow.find('.sh-corporate-fields input, .sh-corporate-fields textarea').prop('disabled', true);
                parentRow.find('.sh-individual-fields').show();
                parentRow.find('.sh-individual-fields input, .sh-individual-fields textarea, .sh-individual-fields select').prop('disabled', false);
            }
        });
    }
    bindShareholderTypeChange($('#sh-container .sh-row:first'));

    // Other address clone
    var otherAddressCount = 1;
    $('#addOtherAddress').click(function() {
        otherAddressCount++;
        var clone = $('#otherAddressContainer .other-address-row:first').clone();
        clone.find('input, textarea, select').val('');
        clone.find('[name="default_address"]').val(otherAddressCount - 1);
        $('#otherAddressContainer').append(clone);
        initNewRowPlugins(clone);
    });
    $(document).on('click', '.removeOtherAddress', function() {
        if ($('#otherAddressContainer .other-address-row').length > 1) {
            $(this).closest('.other-address-row').remove();
        }
    });

    // Re-initialize plugins on cloned rows
    function initNewRowPlugins(row) {
        if ($.fn.select2) {
            row.find('.select2_single').select2({ allowClear: true, width: '100%' });
        }
        if ($.fn.daterangepicker) {
            row.find('.datepicker').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoUpdateInput: false,
                locale: { format: 'DD/MM/YYYY' }
            }).on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY'));
            });
        }
    }

    // Form submission
    $('#company-details-form').on('submit', function(e) {
        var companyName = $('input[name="company-name"]').val();
        if (!companyName) {
            e.preventDefault();
            if (typeof Swal !== 'undefined') {
                Swal.fire('Error', 'Company Name is required.', 'error');
            } else {
                alert('Company Name is required.');
            }
            showStep(1);
            return false;
        }
        // Enable all disabled fields before submit so they get posted
        $(this).find(':disabled').prop('disabled', false);
    });
});
</script>
