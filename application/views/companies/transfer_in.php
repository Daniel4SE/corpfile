<!-- Transfer In Company - SOP Wizard -->
<div class="page-title">
    <div class="title_left">
        <h3>Transfer In Company</h3>
        <p style="color:var(--cf-text-secondary); font-size:14px; margin-top:4px;">
            Transfer an existing company to CorpFile management
        </p>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('company_list') ?>" class="btn btn-default" style="border-radius:var(--cf-radius-sm);">
                <i class="fa fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!-- Progress Stepper -->
<div class="row" style="margin-bottom:24px;">
    <div class="col-md-12">
        <div class="reg-stepper" id="regStepper">
            <div class="reg-step active" data-step="1">
                <div class="reg-step-circle">1</div>
                <div class="reg-step-label">Company Info</div>
                <div class="reg-step-desc">Existing company details</div>
            </div>
            <div class="reg-step-line"></div>
            <div class="reg-step" data-step="2">
                <div class="reg-step-circle">2</div>
                <div class="reg-step-label">Transfer Docs</div>
                <div class="reg-step-desc">AI-generated documents</div>
            </div>
            <div class="reg-step-line"></div>
            <div class="reg-step" data-step="3">
                <div class="reg-step-circle">3</div>
                <div class="reg-step-label">ACRA Filing</div>
                <div class="reg-step-desc">Secretary change filing</div>
            </div>
            <div class="reg-step-line"></div>
            <div class="reg-step" data-step="4">
                <div class="reg-step-circle">4</div>
                <div class="reg-step-label">Onboarding</div>
                <div class="reg-step-desc">Setup & handover</div>
            </div>
        </div>
    </div>
</div>

<!-- ==================== STEP 1: Existing Company Info ==================== -->
<div class="reg-panel" id="step1Panel">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel" style="border-radius:var(--cf-radius);border:1px solid var(--cf-border);box-shadow:var(--cf-shadow);">
                <div class="x_title" style="border-bottom:1px solid var(--cf-border);padding:16px 20px;">
                    <h2 style="margin:0;font-size:16px;font-weight:600;color:var(--cf-text);">
                        <i class="fa fa-exchange" style="color:var(--cf-warning);margin-right:8px;"></i> Existing Company Information
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" style="padding:24px;">

                    <div class="alert" style="background:#fef9ee;border:1px solid #f5e0b0;border-radius:var(--cf-radius-sm);color:#92400e;padding:14px;margin-bottom:20px;">
                        <i class="fa fa-info-circle" style="margin-right:6px;"></i>
                        Enter the details of the <strong>existing</strong> company being transferred in. The UEN and incorporation date should already exist.
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="reg-label">Company Name <span class="required">*</span></label>
                                <input type="text" id="regCompanyName1" class="form-control" placeholder="Exact registered company name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="reg-label">UEN / Registration No. <span class="required">*</span></label>
                                <input type="text" id="regUEN" class="form-control" placeholder="e.g. 202012345A" style="font-family:monospace;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="reg-label">Incorporation Date</label>
                                <input type="date" id="regIncorpDate" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="reg-label">Company Type</label>
                                <select id="regCompanyType" class="form-control">
                                    <option value="Private Limited (Pte. Ltd.)">Private Company Limited by Shares (Pte. Ltd.)</option>
                                    <option value="Exempt Private">Exempt Private Company</option>
                                    <option value="Public Limited">Public Company Limited by Shares</option>
                                    <option value="Company Limited by Guarantee">Company Limited by Guarantee</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="reg-label">Entity Status</label>
                                <select id="regStatus" class="form-control">
                                    <option value="Active" selected>Active</option>
                                    <option value="Dormant">Dormant</option>
                                    <option value="Striking Off">Striking Off</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="reg-label">Registered Address</label>
                        <textarea id="regAddress" class="form-control" rows="2" placeholder="Current registered office address"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="reg-label">Financial Year End (FYE)</label>
                                <select id="regFYE" class="form-control">
                                    <option value="31 January">31 January</option><option value="28/29 February">28/29 February</option>
                                    <option value="31 March">31 March</option><option value="30 April">30 April</option>
                                    <option value="31 May">31 May</option><option value="30 June">30 June</option>
                                    <option value="31 July">31 July</option><option value="31 August">31 August</option>
                                    <option value="30 September">30 September</option><option value="31 October">31 October</option>
                                    <option value="30 November">30 November</option><option value="31 December" selected>31 December</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="reg-label">Share Capital (SGD)</label>
                                <input type="number" id="regShareCapital" class="form-control" value="1" min="1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="reg-label">Number of Shares</label>
                                <input type="number" id="regNumShares" class="form-control" value="1" min="1">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="reg-label">SSIC / Business Activity</label>
                        <input type="text" id="regSSIC1" class="form-control" placeholder="e.g. 62011 - Software Development">
                    </div>

                    <hr style="border-color:var(--cf-border);margin:20px 0;">

                    <!-- Previous Secretary -->
                    <h4 style="font-size:15px;font-weight:600;color:var(--cf-text);margin-bottom:12px;">
                        <i class="fa fa-sign-out" style="color:var(--cf-danger);margin-right:6px;"></i> Previous Company Secretary (Outgoing)
                    </h4>
                    <div class="row">
                        <div class="col-md-4"><input type="text" id="prevSecName" class="form-control" placeholder="Previous secretary name"></div>
                        <div class="col-md-4"><input type="text" id="prevSecId" class="form-control" placeholder="Registration No."></div>
                        <div class="col-md-4"><input type="date" id="prevSecCessation" class="form-control" title="Date of cessation"></div>
                    </div>

                    <hr style="border-color:var(--cf-border);margin:20px 0;">

                    <!-- New Secretary -->
                    <h4 style="font-size:15px;font-weight:600;color:var(--cf-text);margin-bottom:12px;">
                        <i class="fa fa-sign-in" style="color:#10b981;margin-right:6px;"></i> New Company Secretary (Incoming)
                    </h4>
                    <div class="row">
                        <div class="col-md-4"><input type="text" id="regSecName" class="form-control" placeholder="Secretary Name" value="Teamwork Corporate Secretarial Pte Ltd"></div>
                        <div class="col-md-4"><input type="text" id="regSecId" class="form-control" placeholder="Registration No."></div>
                        <div class="col-md-4"><input type="date" id="regSecAppoint" class="form-control" title="Date of appointment" value="<?= date('Y-m-d') ?>"></div>
                    </div>

                    <hr style="border-color:var(--cf-border);margin:20px 0;">

                    <!-- Directors -->
                    <h4 style="font-size:15px;font-weight:600;color:var(--cf-text);margin-bottom:12px;">
                        <i class="fa fa-users" style="color:var(--cf-accent);margin-right:6px;"></i> Current Directors
                        <button class="btn btn-success btn-xs pull-right" id="addDirectorRow" style="border-radius:6px;">
                            <i class="fa fa-plus"></i> Add Director
                        </button>
                    </h4>
                    <div id="directorsContainer">
                        <div class="officer-row" data-type="director">
                            <div class="row">
                                <div class="col-md-3"><input type="text" class="form-control dir-name" placeholder="Full Name *"></div>
                                <div class="col-md-2"><input type="text" class="form-control dir-id" placeholder="NRIC / Passport"></div>
                                <div class="col-md-2"><input type="text" class="form-control dir-nationality" placeholder="Nationality"></div>
                                <div class="col-md-2"><input type="text" class="form-control dir-address" placeholder="Address"></div>
                                <div class="col-md-2"><input type="email" class="form-control dir-email" placeholder="Email"></div>
                                <div class="col-md-1"><button class="btn btn-danger btn-xs remove-officer" style="margin-top:6px;border-radius:6px;" title="Remove"><i class="fa fa-trash"></i></button></div>
                            </div>
                        </div>
                    </div>

                    <hr style="border-color:var(--cf-border);margin:20px 0;">

                    <!-- Shareholders -->
                    <h4 style="font-size:15px;font-weight:600;color:var(--cf-text);margin-bottom:12px;">
                        <i class="fa fa-pie-chart" style="color:var(--cf-accent);margin-right:6px;"></i> Current Shareholders
                        <button class="btn btn-success btn-xs pull-right" id="addShareholderRow" style="border-radius:6px;">
                            <i class="fa fa-plus"></i> Add Shareholder
                        </button>
                    </h4>
                    <div id="shareholdersContainer">
                        <div class="officer-row" data-type="shareholder">
                            <div class="row">
                                <div class="col-md-3"><input type="text" class="form-control sh-name" placeholder="Full Name *"></div>
                                <div class="col-md-2"><input type="text" class="form-control sh-id" placeholder="NRIC / Passport"></div>
                                <div class="col-md-2"><select class="form-control sh-type"><option value="Individual">Individual</option><option value="Corporate">Corporate</option></select></div>
                                <div class="col-md-2"><input type="number" class="form-control sh-shares" placeholder="Shares" value="1" min="1"></div>
                                <div class="col-md-2"><input type="text" class="form-control sh-nationality" placeholder="Nationality"></div>
                                <div class="col-md-1"><button class="btn btn-danger btn-xs remove-officer" style="margin-top:6px;border-radius:6px;" title="Remove"><i class="fa fa-trash"></i></button></div>
                            </div>
                        </div>
                    </div>

                    <hr style="border-color:var(--cf-border);margin:20px 0;">

                    <div class="form-group">
                        <label class="reg-label">Additional Notes / Reason for Transfer</label>
                        <textarea id="regNotes" class="form-control" rows="3" placeholder="e.g. Previous secretary resigned, client referred by XYZ..."></textarea>
                    </div>

                    <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:20px;">
                        <a href="<?= base_url('company_list') ?>" class="btn btn-default" style="border-radius:var(--cf-radius-sm);">Cancel</a>
                        <button class="btn btn-primary" id="goToStep2" style="border-radius:var(--cf-radius-sm);padding:8px 24px;font-weight:600;">
                            Next: Generate Transfer Docs <i class="fa fa-arrow-right" style="margin-left:6px;"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==================== STEP 2: Transfer Documents ==================== -->
<div class="reg-panel" id="step2Panel" style="display:none;">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel" style="border-radius:var(--cf-radius);border:1px solid var(--cf-border);box-shadow:var(--cf-shadow);">
                <div class="x_title" style="border-bottom:1px solid var(--cf-border);padding:16px 20px;">
                    <h2 style="margin:0;font-size:16px;font-weight:600;color:var(--cf-text);">
                        <i class="fa fa-file-text" style="color:var(--cf-accent);margin-right:8px;"></i> Transfer Documents
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" style="padding:24px;">
                    <p style="font-size:13px;color:var(--cf-text-secondary);margin-bottom:16px;">
                        AI will generate the required documents for the secretary transfer. Review and download each document.
                    </p>

                    <div id="transferDocs" class="doc-checklist">
                        <div class="doc-item" data-doc="resignation_letter"><div class="doc-item-header"><span class="doc-status"><i class="fa fa-circle-o"></i></span><strong>Resignation Letter of Outgoing Secretary</strong></div><div class="doc-item-body" style="display:none;"></div></div>
                        <div class="doc-item" data-doc="consent_secretary"><div class="doc-item-header"><span class="doc-status"><i class="fa fa-circle-o"></i></span><strong>Consent to Act as Secretary (Incoming)</strong></div><div class="doc-item-body" style="display:none;"></div></div>
                        <div class="doc-item" data-doc="board_resolution"><div class="doc-item-header"><span class="doc-status"><i class="fa fa-circle-o"></i></span><strong>Board Resolution - Appointment of New Secretary</strong></div><div class="doc-item-body" style="display:none;"></div></div>
                        <div class="doc-item" data-doc="letter_authorization"><div class="doc-item-header"><span class="doc-status"><i class="fa fa-circle-o"></i></span><strong>Letter of Authorization for ACRA e-Services</strong></div><div class="doc-item-body" style="display:none;"></div></div>
                        <div class="doc-item" data-doc="handover_checklist"><div class="doc-item-header"><span class="doc-status"><i class="fa fa-circle-o"></i></span><strong>Handover Checklist</strong></div><div class="doc-item-body" style="display:none;"></div></div>
                        <div class="doc-item" data-doc="kyc_cdd"><div class="doc-item-header"><span class="doc-status"><i class="fa fa-circle-o"></i></span><strong>KYC / Customer Due Diligence</strong></div><div class="doc-item-body" style="display:none;"></div></div>
                    </div>

                    <div style="margin-top:20px;text-align:center;">
                        <button class="btn btn-primary btn-lg" id="generateTransferBtn" style="border-radius:var(--cf-radius-sm);padding:12px 40px;font-weight:600;">
                            <i class="fa fa-magic" style="margin-right:8px;"></i> Generate All Transfer Documents with AI
                        </button>
                    </div>
                    <div id="transferResult" style="margin-top:20px;display:none;"></div>

                    <div style="display:flex;justify-content:space-between;gap:8px;margin-top:24px;">
                        <button class="btn btn-default" id="backToStep1" style="border-radius:var(--cf-radius-sm);"><i class="fa fa-arrow-left" style="margin-right:6px;"></i> Back</button>
                        <button class="btn btn-primary" id="goToStep3" style="border-radius:var(--cf-radius-sm);padding:8px 24px;font-weight:600;">Next: ACRA Filing <i class="fa fa-arrow-right" style="margin-left:6px;"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==================== STEP 3: ACRA Filing ==================== -->
<div class="reg-panel" id="step3Panel" style="display:none;">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel" style="border-radius:var(--cf-radius);border:1px solid var(--cf-border);box-shadow:var(--cf-shadow);">
                <div class="x_title" style="border-bottom:1px solid var(--cf-border);padding:16px 20px;">
                    <h2 style="margin:0;font-size:16px;font-weight:600;color:var(--cf-text);"><i class="fa fa-university" style="color:var(--cf-accent);margin-right:8px;"></i> ACRA Filing - Secretary Change</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" style="padding:24px;">
                    <div class="alert" style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:var(--cf-radius-sm);color:#1e40af;padding:16px;">
                        <i class="fa fa-info-circle" style="margin-right:8px;"></i>
                        File the <strong>Change of Company Secretary</strong> with ACRA via <a href="https://www.bizfile.gov.sg" target="_blank" style="color:#1e40af;text-decoration:underline;">BizFile+</a>. This must be done within 14 days of the change.
                    </div>

                    <div class="row" style="margin-top:20px;">
                        <div class="col-md-6">
                            <div class="form-group"><label class="reg-label">Filing Date</label><input type="date" id="acraFilingDate" class="form-control" value="<?= date('Y-m-d') ?>"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="reg-label">Filing Status</label>
                                <select id="acraStatus" class="form-control">
                                    <option value="pending">Pending Submission</option>
                                    <option value="submitted">Submitted to ACRA</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <h5 style="font-weight:600;margin-top:20px;margin-bottom:12px;">Transfer Checklist</h5>
                    <div class="acra-checklist">
                        <label class="change-check-item"><input type="checkbox"> <i class="fa fa-file-text"></i> Resignation letter signed by outgoing secretary</label>
                        <label class="change-check-item"><input type="checkbox"> <i class="fa fa-check-square-o"></i> Consent signed by incoming secretary</label>
                        <label class="change-check-item"><input type="checkbox"> <i class="fa fa-gavel"></i> Board resolution signed by directors</label>
                        <label class="change-check-item"><input type="checkbox"> <i class="fa fa-id-card"></i> KYC/CDD completed for all officers</label>
                        <label class="change-check-item"><input type="checkbox"> <i class="fa fa-paper-plane"></i> ACRA filing submitted</label>
                        <label class="change-check-item"><input type="checkbox"> <i class="fa fa-key"></i> BizFile+ access obtained</label>
                        <label class="change-check-item"><input type="checkbox"> <i class="fa fa-folder"></i> Company documents handed over</label>
                        <label class="change-check-item"><input type="checkbox"> <i class="fa fa-book"></i> Statutory registers received</label>
                    </div>

                    <div style="display:flex;justify-content:space-between;gap:8px;margin-top:24px;">
                        <button class="btn btn-default" id="backToStep2" style="border-radius:var(--cf-radius-sm);"><i class="fa fa-arrow-left" style="margin-right:6px;"></i> Back</button>
                        <button class="btn btn-primary" id="goToStep4" style="border-radius:var(--cf-radius-sm);padding:8px 24px;font-weight:600;">Next: Onboarding <i class="fa fa-arrow-right" style="margin-left:6px;"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==================== STEP 4: Onboarding & Complete ==================== -->
<div class="reg-panel" id="step4Panel" style="display:none;">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel" style="border-radius:var(--cf-radius);border:1px solid var(--cf-border);box-shadow:var(--cf-shadow);">
                <div class="x_title" style="border-bottom:1px solid var(--cf-border);padding:16px 20px;">
                    <h2 style="margin:0;font-size:16px;font-weight:600;color:var(--cf-text);"><i class="fa fa-check-circle" style="color:#10b981;margin-right:8px;"></i> Onboarding Complete</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" style="padding:24px;">
                    <p style="font-size:13px;color:var(--cf-text-secondary);margin-bottom:16px;">
                        Complete the transfer by saving the company record into CorpFile. All officers and company info will be imported.
                    </p>

                    <h5 style="font-weight:600;margin-bottom:12px;">Onboarding Items</h5>
                    <div class="acra-checklist">
                        <label class="change-check-item"><input type="checkbox"> <i class="fa fa-calendar"></i> Set up compliance calendar (AGM/AR/FYE)</label>
                        <label class="change-check-item"><input type="checkbox"> <i class="fa fa-folder-open"></i> Upload received company documents</label>
                        <label class="change-check-item"><input type="checkbox"> <i class="fa fa-users"></i> Verify all directors/shareholders are current</label>
                        <label class="change-check-item"><input type="checkbox"> <i class="fa fa-money"></i> Set up annual fee schedule</label>
                        <label class="change-check-item"><input type="checkbox"> <i class="fa fa-envelope"></i> Send welcome letter to client</label>
                        <label class="change-check-item"><input type="checkbox"> <i class="fa fa-shield"></i> Complete AML/CFT assessment</label>
                    </div>

                    <div style="display:flex;justify-content:space-between;gap:8px;margin-top:24px;">
                        <button class="btn btn-default" id="backToStep3" style="border-radius:var(--cf-radius-sm);"><i class="fa fa-arrow-left" style="margin-right:6px;"></i> Back</button>
                        <div style="display:flex;gap:8px;">
                            <button class="btn btn-default" id="saveDraftBtn" style="border-radius:var(--cf-radius-sm);"><i class="fa fa-save" style="margin-right:6px;"></i> Save as Draft</button>
                            <button class="btn btn-success" id="completeRegBtn" style="border-radius:var(--cf-radius-sm);padding:8px 24px;font-weight:600;"><i class="fa fa-check" style="margin-right:6px;"></i> Complete Transfer & Create Company</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==================== STYLES ==================== -->
<style>
.reg-stepper { display:flex;align-items:flex-start;justify-content:center;gap:0;padding:20px;background:var(--cf-card-bg);border-radius:var(--cf-radius);border:1px solid var(--cf-border);box-shadow:var(--cf-shadow); }
.reg-step { display:flex;flex-direction:column;align-items:center;gap:6px;cursor:pointer;min-width:120px; }
.reg-step-circle { width:36px;height:36px;border-radius:50%;background:#e5e7eb;color:#6b7280;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;transition:all 0.2s; }
.reg-step.active .reg-step-circle,.reg-step.completed .reg-step-circle { background:var(--cf-accent);color:#fff; }
.reg-step.completed .reg-step-circle { background:#10b981; }
.reg-step-label { font-size:13px;font-weight:600;color:var(--cf-text);text-align:center; }
.reg-step-desc { font-size:11px;color:var(--cf-text-muted);text-align:center; }
.reg-step-line { flex:1;height:2px;background:#e5e7eb;margin-top:18px;min-width:40px;max-width:100px; }
.reg-label { font-size:13px;font-weight:600;color:var(--cf-text);margin-bottom:4px;display:block; }
.officer-row { background:#f9fafb;padding:10px 12px;border-radius:var(--cf-radius-sm);margin-bottom:8px;border:1px solid var(--cf-border); }
.officer-row .form-control { font-size:13px;padding:6px 10px;height:34px; }
.doc-checklist { display:flex;flex-direction:column;gap:8px; }
.doc-item { border:1px solid var(--cf-border);border-radius:var(--cf-radius-sm);overflow:hidden;transition:all 0.2s; }
.doc-item.generated { border-color:#10b981; }
.doc-item-header { padding:12px 16px;display:flex;align-items:center;gap:10px;cursor:pointer;font-size:13px; }
.doc-item-header:hover { background:#f9fafb; }
.doc-item .doc-status { color:#d1d5db;font-size:16px; }
.doc-item.generated .doc-status { color:#10b981; }
.doc-item.generated .doc-status i:before { content:"\f058"; }
.doc-item-body { padding:0 16px 16px;border-top:1px solid var(--cf-border);background:#f8fafc; }
.acra-checklist { display:grid;grid-template-columns:1fr 1fr;gap:8px; }
.change-check-item { display:flex;align-items:center;gap:8px;padding:8px 12px;border:1px solid var(--cf-border);border-radius:var(--cf-radius-sm);cursor:pointer;font-size:13px;font-weight:500;transition:all 0.15s;margin:0; }
.change-check-item:hover { background:var(--cf-card-bg);border-color:var(--cf-accent); }
.change-check-item:has(input:checked) { background:#eff6ff;border-color:var(--cf-accent); }
@media (max-width:768px) { .reg-stepper{flex-wrap:wrap;gap:8px;} .reg-step-line{display:none;} .acra-checklist{grid-template-columns:1fr;} }
</style>

<!-- ==================== JAVASCRIPT ==================== -->
<script>
$(document).ready(function() {
    var currentStep = 1;
    var regData = {};

    function goToStep(step) {
        currentStep = step;
        $('.reg-panel').hide();
        $('#step' + step + 'Panel').show();
        $('.reg-step').each(function() {
            var s = parseInt($(this).data('step'));
            $(this).removeClass('active completed');
            if (s < step) $(this).addClass('completed');
            if (s === step) $(this).addClass('active');
        });
        $('html, body').animate({ scrollTop: $('.reg-stepper').offset().top - 20 }, 300);
    }

    $('#goToStep2').click(function() {
        if (!$('#regCompanyName1').val().trim()) { alert('Please enter the company name.'); $('#regCompanyName1').focus(); return; }
        collectRegData();
        goToStep(2);
    });
    $('#goToStep3').click(function() { goToStep(3); });
    $('#goToStep4').click(function() { goToStep(4); });
    $('#backToStep1').click(function() { goToStep(1); });
    $('#backToStep2').click(function() { goToStep(2); });
    $('#backToStep3').click(function() { goToStep(3); });
    $('.reg-step').click(function() { var s = parseInt($(this).data('step')); if (s <= currentStep || $(this).hasClass('completed')) goToStep(s); });

    function collectRegData() {
        regData.companyName = $('#regCompanyName1').val().trim();
        regData.uen = $('#regUEN').val().trim();
        regData.incorpDate = $('#regIncorpDate').val();
        regData.companyType = $('#regCompanyType').val();
        regData.status = $('#regStatus').val();
        regData.address = $('#regAddress').val().trim();
        regData.fye = $('#regFYE').val();
        regData.shareCapital = $('#regShareCapital').val();
        regData.numShares = $('#regNumShares').val();
        regData.ssic1 = $('#regSSIC1').val().trim();
        regData.notes = $('#regNotes').val().trim();
        regData.prevSec = { name: $('#prevSecName').val().trim(), id: $('#prevSecId').val().trim(), cessation: $('#prevSecCessation').val() };
        regData.newSec = { name: $('#regSecName').val().trim(), id: $('#regSecId').val().trim(), appoint: $('#regSecAppoint').val() };

        regData.directors = [];
        $('#directorsContainer .officer-row').each(function() {
            var name = $(this).find('.dir-name').val().trim();
            if (name) regData.directors.push({ name: name, id: $(this).find('.dir-id').val().trim(), nationality: $(this).find('.dir-nationality').val().trim(), address: $(this).find('.dir-address').val().trim(), email: $(this).find('.dir-email').val().trim() });
        });
        regData.shareholders = [];
        $('#shareholdersContainer .officer-row').each(function() {
            var name = $(this).find('.sh-name').val().trim();
            if (name) regData.shareholders.push({ name: name, id: $(this).find('.sh-id').val().trim(), type: $(this).find('.sh-type').val(), shares: $(this).find('.sh-shares').val(), nationality: $(this).find('.sh-nationality').val().trim() });
        });
    }

    // Add/Remove officers
    $('#addDirectorRow').click(function() {
        $('#directorsContainer').append('<div class="officer-row" data-type="director"><div class="row"><div class="col-md-3"><input type="text" class="form-control dir-name" placeholder="Full Name *"></div><div class="col-md-2"><input type="text" class="form-control dir-id" placeholder="NRIC / Passport"></div><div class="col-md-2"><input type="text" class="form-control dir-nationality" placeholder="Nationality"></div><div class="col-md-2"><input type="text" class="form-control dir-address" placeholder="Address"></div><div class="col-md-2"><input type="email" class="form-control dir-email" placeholder="Email"></div><div class="col-md-1"><button class="btn btn-danger btn-xs remove-officer" style="margin-top:6px;border-radius:6px;" title="Remove"><i class="fa fa-trash"></i></button></div></div></div>');
    });
    $('#addShareholderRow').click(function() {
        $('#shareholdersContainer').append('<div class="officer-row" data-type="shareholder"><div class="row"><div class="col-md-3"><input type="text" class="form-control sh-name" placeholder="Full Name *"></div><div class="col-md-2"><input type="text" class="form-control sh-id" placeholder="NRIC / Passport"></div><div class="col-md-2"><select class="form-control sh-type"><option value="Individual">Individual</option><option value="Corporate">Corporate</option></select></div><div class="col-md-2"><input type="number" class="form-control sh-shares" placeholder="Shares" value="1" min="1"></div><div class="col-md-2"><input type="text" class="form-control sh-nationality" placeholder="Nationality"></div><div class="col-md-1"><button class="btn btn-danger btn-xs remove-officer" style="margin-top:6px;border-radius:6px;" title="Remove"><i class="fa fa-trash"></i></button></div></div></div>');
    });
    $(document).on('click', '.remove-officer', function() {
        var c = $(this).closest('.officer-row').parent();
        if (c.find('.officer-row').length > 1) $(this).closest('.officer-row').remove();
        else alert('At least one entry is required.');
    });

    // Toggle doc bodies
    $(document).on('click', '.doc-item-header', function() {
        var body = $(this).closest('.doc-item').find('.doc-item-body');
        if (body.html().trim()) body.slideToggle(200);
    });

    // Generate transfer documents
    $('#generateTransferBtn').click(function() {
        collectRegData();
        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Generating...');
        $('#transferResult').show().html('<div style="padding:30px;text-align:center;color:var(--cf-text-muted);"><i class="fa fa-spinner fa-spin fa-2x"></i><br><br>AI is generating transfer documents...<br><small>This may take 30-60 seconds</small></div>');

        var p = 'Generate corporate secretary transfer-in documents for an existing Singapore company.\n\n';
        p += '=== COMPANY ===\nName: ' + regData.companyName + '\nUEN: ' + (regData.uen || 'N/A') + '\nIncorporation Date: ' + (regData.incorpDate || 'N/A') + '\nType: ' + regData.companyType + '\nAddress: ' + (regData.address || 'N/A') + '\nFYE: ' + regData.fye + '\n';
        p += '\n=== OUTGOING SECRETARY ===\n' + (regData.prevSec.name || 'N/A') + (regData.prevSec.id ? ', Reg: ' + regData.prevSec.id : '') + (regData.prevSec.cessation ? ', Cessation: ' + regData.prevSec.cessation : '') + '\n';
        p += '\n=== INCOMING SECRETARY ===\n' + regData.newSec.name + (regData.newSec.id ? ', Reg: ' + regData.newSec.id : '') + (regData.newSec.appoint ? ', Appointment: ' + regData.newSec.appoint : '') + '\n';
        p += '\n=== DIRECTORS ===\n';
        regData.directors.forEach(function(d, i) { p += (i+1) + '. ' + d.name + (d.id ? ' (ID: ' + d.id + ')' : '') + '\n'; });
        if (regData.notes) p += '\n=== NOTES ===\n' + regData.notes + '\n';
        p += '\n=== GENERATE THESE DOCUMENTS ===\n';
        p += '1. **Resignation Letter of Outgoing Secretary** - Formal resignation\n';
        p += '2. **Consent to Act as Secretary** - For the incoming secretary\n';
        p += '3. **Board Resolution** - Directors\' resolution appointing new secretary and accepting resignation\n';
        p += '4. **Letter of Authorization** - Authorizing new secretary for ACRA e-services\n';
        p += '5. **Handover Checklist** - Items to be handed over from old to new secretary\n';
        p += '6. **KYC / CDD Checklist** - Due diligence items for the transfer-in client\n';
        p += '\nUse proper Singapore legal language. Include signature lines.';

        fetch('<?= base_url("ai/chat") ?>', {
            method: 'POST', headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message: p, source: 'agent', agent: 'docgen' })
        })
        .then(function(r) { return r.text(); })
        .then(function(text) {
            var m = text.match(/\{[\s\S]*\}$/);
            if (m) {
                var data = JSON.parse(m[0]);
                btn.prop('disabled', false).html('<i class="fa fa-magic" style="margin-right:8px;"></i> Regenerate Transfer Documents');
                if (data.ok && data.response_text) {
                    var md = (typeof cfRenderMarkdown === 'function') ? cfRenderMarkdown(data.response_text) : data.response_text;
                    $('#transferResult').html(
                        '<div style="border:1px solid var(--cf-border);border-radius:var(--cf-radius);padding:16px;background:#f8fafc;max-height:500px;overflow-y:auto;">' +
                        '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">' +
                        '<strong style="color:var(--cf-primary);"><i class="fa fa-file-text-o"></i> Generated Documents</strong>' +
                        '<button class="btn btn-default btn-xs" onclick="copyTransferResult()" title="Copy All"><i class="fa fa-copy"></i> Copy All</button></div>' +
                        '<div id="transferResultContent" class="cf-ai-content" style="font-size:13px;line-height:1.7;">' + md + '</div></div>'
                    );
                    $('#transferDocs .doc-item').addClass('generated');
                } else {
                    $('#transferResult').html('<div class="alert alert-danger">' + (data.error || 'Failed.') + '</div>');
                }
            }
        })
        .catch(function() {
            btn.prop('disabled', false).html('<i class="fa fa-magic" style="margin-right:8px;"></i> Generate All Transfer Documents with AI');
            $('#transferResult').html('<div class="alert alert-danger">Connection error.</div>');
        });
    });

    // Save / Complete
    $('#saveDraftBtn, #completeRegBtn').click(function() {
        collectRegData();
        var status = $(this).attr('id') === 'completeRegBtn' ? 'Active' : 'Pre-Incorporation';
        var form = $('<form method="POST" action="<?= base_url("add_company") ?>"></form>');
        var fields = {
            'company-name': regData.companyName, 'reg-num': regData.uen, 'acra_reg_id': regData.uen,
            'country': 'SINGAPORE', 'incorp-date': regData.incorpDate || '', 'company-status': status,
            'company_status': status, 'date-fye': regData.fye, 'ord_issued_share_capital': regData.shareCapital,
            'no_ord_shares': regData.numShares, 'reg-address': regData.address, 'remarks': regData.notes || '',
            'client': '1', 'corporate_shareholder_client': '1', 'ci_csrf_token': '<?= $csrf_token ?? "" ?>'
        };
        for (var k in fields) form.append($('<input type="hidden">').attr('name', k).val(fields[k]));
        regData.directors.forEach(function(d) {
            form.append($('<input type="hidden" name="director-name[]">').val(d.name));
            form.append($('<input type="hidden" name="director_id_type[]">').val('NRIC'));
            form.append($('<input type="hidden" name="director-passport[]">').val(d.id));
            form.append($('<input type="hidden" name="director-nationality[]">').val(d.nationality));
            form.append($('<input type="hidden" name="direcetor-local-address[]">').val(d.address));
            form.append($('<input type="hidden" name="director-email-address[]">').val(d.email));
            form.append($('<input type="hidden" name="director-contact-number[]">').val(''));
            form.append($('<input type="hidden" name="director-dob[]">').val(''));
            form.append($('<input type="hidden" name="director-doapp[]">').val(''));
            form.append($('<input type="hidden" name="direcetor-foreign-address[]">').val(''));
        });
        regData.shareholders.forEach(function(s) {
            form.append($('<input type="hidden" name="shareh-name[]">').val(s.name));
            form.append($('<input type="hidden" name="shareholder_type[]">').val(s.type));
            form.append($('<input type="hidden" name="shareh_id_type[]">').val('NRIC'));
            form.append($('<input type="hidden" name="shareh-passport[]">').val(s.id));
            form.append($('<input type="hidden" name="shareh-nationality[]">').val(s.nationality));
            form.append($('<input type="hidden" name="shareh-doapp[]">').val(''));
        });
        if (regData.newSec.name) {
            form.append($('<input type="hidden" name="secreatary-name[]">').val(regData.newSec.name));
            form.append($('<input type="hidden" name="secretary_id_type[]">').val(''));
            form.append($('<input type="hidden" name="secreatary-passport[]">').val(regData.newSec.id));
            form.append($('<input type="hidden" name="secreatary-nationality[]">').val('SINGAPORE'));
            form.append($('<input type="hidden" name="secreatary-doapp[]">').val(regData.newSec.appoint || ''));
        }
        $('body').append(form);
        form.submit();
    });
});

function copyTransferResult() {
    var el = document.getElementById('transferResultContent');
    if (el) { var r = document.createRange(); r.selectNodeContents(el); var s = window.getSelection(); s.removeAllRanges(); s.addRange(r); document.execCommand('copy'); s.removeAllRanges(); alert('Copied!'); }
}
</script>
