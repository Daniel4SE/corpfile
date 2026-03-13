<!-- New Company Registration - SOP Wizard -->
<div class="page-title">
    <div class="title_left">
        <h3>New Company Registration</h3>
        <p style="color:var(--cf-text-secondary); font-size:14px; margin-top:4px;">
            Step-by-step company incorporation workflow
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
                <div class="reg-step-desc">Basic details & officers</div>
            </div>
            <div class="reg-step-line"></div>
            <div class="reg-step" data-step="2">
                <div class="reg-step-circle">2</div>
                <div class="reg-step-label">Pre-Incorp Docs</div>
                <div class="reg-step-desc">AI-generated documents</div>
            </div>
            <div class="reg-step-line"></div>
            <div class="reg-step" data-step="3">
                <div class="reg-step-circle">3</div>
                <div class="reg-step-label">ACRA Filing</div>
                <div class="reg-step-desc">Registration with ACRA</div>
            </div>
            <div class="reg-step-line"></div>
            <div class="reg-step" data-step="4">
                <div class="reg-step-circle">4</div>
                <div class="reg-step-label">Post-Incorp Docs</div>
                <div class="reg-step-desc">First resolutions & setup</div>
            </div>
        </div>
    </div>
</div>

<!-- ==================== STEP 1: Company Info Questionnaire ==================== -->
<div class="reg-panel" id="step1Panel">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel" style="border-radius:var(--cf-radius);border:1px solid var(--cf-border);box-shadow:var(--cf-shadow);">
                <div class="x_title" style="border-bottom:1px solid var(--cf-border);padding:16px 20px;">
                    <h2 style="margin:0;font-size:16px;font-weight:600;color:var(--cf-text);">
                        <i class="fa fa-building-o" style="color:var(--cf-accent);margin-right:8px;"></i> Company Information
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" style="padding:24px;">

                    <!-- Proposed Company Name(s) -->
                    <div class="form-group">
                        <label class="reg-label">Proposed Company Name(s) <span class="required">*</span></label>
                        <input type="text" id="regCompanyName1" class="form-control" placeholder="First choice company name">
                        <input type="text" id="regCompanyName2" class="form-control" placeholder="Second choice (optional)" style="margin-top:6px;">
                        <input type="text" id="regCompanyName3" class="form-control" placeholder="Third choice (optional)" style="margin-top:6px;">
                        <small class="text-muted">ACRA may reject names that are identical or similar to existing entities.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="reg-label">Company Type</label>
                                <select id="regCompanyType" class="form-control">
                                    <option value="Private Limited (Pte. Ltd.)">Private Company Limited by Shares (Pte. Ltd.)</option>
                                    <option value="Exempt Private">Exempt Private Company</option>
                                    <option value="Public Limited">Public Company Limited by Shares</option>
                                    <option value="Company Limited by Guarantee">Company Limited by Guarantee</option>
                                    <option value="Unlimited Company">Unlimited Company</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="reg-label">Country of Incorporation</label>
                                <select id="regCountry" class="form-control">
                                    <option value="SINGAPORE" selected>Singapore</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- SSIC / Business Activity -->
                    <div class="form-group">
                        <label class="reg-label">Primary Business Activity (SSIC)</label>
                        <input type="text" id="regSSIC1" class="form-control" placeholder="e.g. 62011 - Software Development">
                        <small class="text-muted">Enter SSIC code or describe the business activity</small>
                    </div>
                    <div class="form-group">
                        <label class="reg-label">Secondary Business Activity (optional)</label>
                        <input type="text" id="regSSIC2" class="form-control" placeholder="e.g. 62090 - Other IT services">
                    </div>

                    <!-- Registered Address -->
                    <div class="form-group">
                        <label class="reg-label">Registered Address <span class="required">*</span></label>
                        <textarea id="regAddress" class="form-control" rows="2" placeholder="e.g. 1 Raffles Place, #20-01, One Raffles Place, Singapore 048616"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="reg-label">Financial Year End (FYE)</label>
                                <select id="regFYE" class="form-control">
                                    <option value="31 January">31 January</option>
                                    <option value="28/29 February">28/29 February</option>
                                    <option value="31 March">31 March</option>
                                    <option value="30 April">30 April</option>
                                    <option value="31 May">31 May</option>
                                    <option value="30 June">30 June</option>
                                    <option value="31 July">31 July</option>
                                    <option value="31 August">31 August</option>
                                    <option value="30 September">30 September</option>
                                    <option value="31 October">31 October</option>
                                    <option value="30 November">30 November</option>
                                    <option value="31 December" selected>31 December</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="reg-label">Share Capital (SGD)</label>
                                <input type="number" id="regShareCapital" class="form-control" value="1" min="1" placeholder="e.g. 100">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="reg-label">Number of Shares</label>
                                <input type="number" id="regNumShares" class="form-control" value="1" min="1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="reg-label">Constitution</label>
                                <select id="regConstitution" class="form-control">
                                    <option value="Model Constitution">Model Constitution (Companies Act)</option>
                                    <option value="Customised Constitution">Customised Constitution</option>
                                    <option value="M&AA (old)">Memorandum & Articles of Association (old)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr style="border-color:var(--cf-border);margin:20px 0;">

                    <!-- Directors -->
                    <h4 style="font-size:15px;font-weight:600;color:var(--cf-text);margin-bottom:12px;">
                        <i class="fa fa-users" style="color:var(--cf-accent);margin-right:6px;"></i> Directors
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
                                <div class="col-md-2"><input type="text" class="form-control dir-address" placeholder="Residential Address"></div>
                                <div class="col-md-2"><input type="email" class="form-control dir-email" placeholder="Email"></div>
                                <div class="col-md-1"><button class="btn btn-danger btn-xs remove-officer" style="margin-top:6px;border-radius:6px;" title="Remove"><i class="fa fa-trash"></i></button></div>
                            </div>
                        </div>
                    </div>

                    <hr style="border-color:var(--cf-border);margin:20px 0;">

                    <!-- Shareholders -->
                    <h4 style="font-size:15px;font-weight:600;color:var(--cf-text);margin-bottom:12px;">
                        <i class="fa fa-pie-chart" style="color:var(--cf-accent);margin-right:6px;"></i> Shareholders
                        <button class="btn btn-success btn-xs pull-right" id="addShareholderRow" style="border-radius:6px;">
                            <i class="fa fa-plus"></i> Add Shareholder
                        </button>
                    </h4>
                    <div id="shareholdersContainer">
                        <div class="officer-row" data-type="shareholder">
                            <div class="row">
                                <div class="col-md-3"><input type="text" class="form-control sh-name" placeholder="Full Name *"></div>
                                <div class="col-md-2"><input type="text" class="form-control sh-id" placeholder="NRIC / Passport"></div>
                                <div class="col-md-2">
                                    <select class="form-control sh-type">
                                        <option value="Individual">Individual</option>
                                        <option value="Corporate">Corporate</option>
                                    </select>
                                </div>
                                <div class="col-md-2"><input type="number" class="form-control sh-shares" placeholder="No. of Shares" value="1" min="1"></div>
                                <div class="col-md-2"><input type="text" class="form-control sh-nationality" placeholder="Nationality"></div>
                                <div class="col-md-1"><button class="btn btn-danger btn-xs remove-officer" style="margin-top:6px;border-radius:6px;" title="Remove"><i class="fa fa-trash"></i></button></div>
                            </div>
                        </div>
                    </div>

                    <hr style="border-color:var(--cf-border);margin:20px 0;">

                    <!-- Company Secretary -->
                    <h4 style="font-size:15px;font-weight:600;color:var(--cf-text);margin-bottom:12px;">
                        <i class="fa fa-id-badge" style="color:var(--cf-accent);margin-right:6px;"></i> Company Secretary
                    </h4>
                    <div class="row">
                        <div class="col-md-4"><input type="text" id="regSecName" class="form-control" placeholder="Secretary Name" value="Teamwork Corporate Secretarial Pte Ltd"></div>
                        <div class="col-md-4"><input type="text" id="regSecId" class="form-control" placeholder="NRIC / Registration No."></div>
                        <div class="col-md-4"><input type="email" id="regSecEmail" class="form-control" placeholder="Email"></div>
                    </div>

                    <hr style="border-color:var(--cf-border);margin:20px 0;">

                    <!-- Additional Notes -->
                    <div class="form-group">
                        <label class="reg-label">Additional Notes / Special Instructions</label>
                        <textarea id="regNotes" class="form-control" rows="3" placeholder="e.g. Nominee director required, DPO appointment needed, specific banking requirements..."></textarea>
                    </div>

                    <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:20px;">
                        <a href="<?= base_url('company_list') ?>" class="btn btn-default" style="border-radius:var(--cf-radius-sm);">Cancel</a>
                        <button class="btn btn-primary" id="goToStep2" style="border-radius:var(--cf-radius-sm);padding:8px 24px;font-weight:600;">
                            Next: Generate Pre-Incorp Docs <i class="fa fa-arrow-right" style="margin-left:6px;"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==================== STEP 2: Pre-Incorporation Documents ==================== -->
<div class="reg-panel" id="step2Panel" style="display:none;">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel" style="border-radius:var(--cf-radius);border:1px solid var(--cf-border);box-shadow:var(--cf-shadow);">
                <div class="x_title" style="border-bottom:1px solid var(--cf-border);padding:16px 20px;">
                    <h2 style="margin:0;font-size:16px;font-weight:600;color:var(--cf-text);">
                        <i class="fa fa-file-text" style="color:var(--cf-accent);margin-right:8px;"></i> Pre-Incorporation Documents
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" style="padding:24px;">

                    <p style="font-size:13px;color:var(--cf-text-secondary);margin-bottom:16px;">
                        AI will generate the following documents based on the company information provided. Review and download each document before proceeding to ACRA filing.
                    </p>

                    <!-- Document Checklist -->
                    <div id="preIncorpDocs" class="doc-checklist">
                        <div class="doc-item" data-doc="subscriber_consent">
                            <div class="doc-item-header">
                                <span class="doc-status"><i class="fa fa-circle-o"></i></span>
                                <strong>Subscriber's Consent to Act as Member</strong>
                            </div>
                            <div class="doc-item-body" style="display:none;"></div>
                        </div>
                        <div class="doc-item" data-doc="form45">
                            <div class="doc-item-header">
                                <span class="doc-status"><i class="fa fa-circle-o"></i></span>
                                <strong>Consent to Act as Director (Form 45)</strong>
                            </div>
                            <div class="doc-item-body" style="display:none;"></div>
                        </div>
                        <div class="doc-item" data-doc="notice_registered_office">
                            <div class="doc-item-header">
                                <span class="doc-status"><i class="fa fa-circle-o"></i></span>
                                <strong>Notice of Registered Office Address</strong>
                            </div>
                            <div class="doc-item-body" style="display:none;"></div>
                        </div>
                        <div class="doc-item" data-doc="form45b">
                            <div class="doc-item-header">
                                <span class="doc-status"><i class="fa fa-circle-o"></i></span>
                                <strong>Declaration of Non-Disqualification (Form 45B)</strong>
                            </div>
                            <div class="doc-item-body" style="display:none;"></div>
                        </div>
                        <div class="doc-item" data-doc="register_registrable_controllers">
                            <div class="doc-item-header">
                                <span class="doc-status"><i class="fa fa-circle-o"></i></span>
                                <strong>Register of Registrable Controllers</strong>
                            </div>
                            <div class="doc-item-body" style="display:none;"></div>
                        </div>
                        <div class="doc-item" data-doc="register_nominee_shares">
                            <div class="doc-item-header">
                                <span class="doc-status"><i class="fa fa-circle-o"></i></span>
                                <strong>Register of Nominee Shareholders</strong>
                            </div>
                            <div class="doc-item-body" style="display:none;"></div>
                        </div>
                        <div class="doc-item" data-doc="dcr">
                            <div class="doc-item-header">
                                <span class="doc-status"><i class="fa fa-circle-o"></i></span>
                                <strong>Declaration of Compliance with Requirements (DCR)</strong>
                            </div>
                            <div class="doc-item-body" style="display:none;"></div>
                        </div>
                        <div class="doc-item" data-doc="kyc">
                            <div class="doc-item-header">
                                <span class="doc-status"><i class="fa fa-circle-o"></i></span>
                                <strong>KYC / Customer Due Diligence Checklist</strong>
                            </div>
                            <div class="doc-item-body" style="display:none;"></div>
                        </div>
                    </div>

                    <div style="margin-top:20px;text-align:center;">
                        <button class="btn btn-primary btn-lg" id="generatePreIncorpBtn" style="border-radius:var(--cf-radius-sm);padding:12px 40px;font-weight:600;">
                            <i class="fa fa-magic" style="margin-right:8px;"></i> Generate All Pre-Incorp Documents with AI
                        </button>
                    </div>

                    <div id="preIncorpResult" style="margin-top:20px;display:none;"></div>

                    <div style="display:flex;justify-content:space-between;gap:8px;margin-top:24px;">
                        <button class="btn btn-default" id="backToStep1" style="border-radius:var(--cf-radius-sm);">
                            <i class="fa fa-arrow-left" style="margin-right:6px;"></i> Back
                        </button>
                        <button class="btn btn-primary" id="goToStep3" style="border-radius:var(--cf-radius-sm);padding:8px 24px;font-weight:600;">
                            Next: ACRA Filing <i class="fa fa-arrow-right" style="margin-left:6px;"></i>
                        </button>
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
                    <h2 style="margin:0;font-size:16px;font-weight:600;color:var(--cf-text);">
                        <i class="fa fa-university" style="color:var(--cf-accent);margin-right:8px;"></i> ACRA Registration
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" style="padding:24px;">

                    <div class="alert" style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:var(--cf-radius-sm);color:#1e40af;padding:16px;">
                        <i class="fa fa-info-circle" style="margin-right:8px;"></i>
                        <strong>File with ACRA BizFile+</strong> &mdash; Once all pre-incorporation documents are signed, proceed to file the incorporation with ACRA via <a href="https://www.bizfile.gov.sg" target="_blank" style="color:#1e40af;text-decoration:underline;">BizFile+ portal</a>.
                    </div>

                    <div class="row" style="margin-top:20px;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="reg-label">ACRA Application Reference No.</label>
                                <input type="text" id="acraRefNo" class="form-control" placeholder="e.g. APP-2026XXXX-XXXX">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="reg-label">Filing Date</label>
                                <input type="date" id="acraFilingDate" class="form-control" value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="reg-label">Filing Status</label>
                                <select id="acraStatus" class="form-control">
                                    <option value="pending">Pending Submission</option>
                                    <option value="submitted">Submitted to ACRA</option>
                                    <option value="approved">Approved - UEN Issued</option>
                                    <option value="rejected">Rejected - Resubmission Required</option>
                                    <option value="name_reserved">Name Reserved</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="reg-label">UEN (once issued)</label>
                                <input type="text" id="acraUEN" class="form-control" placeholder="e.g. 202600001A">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="reg-label">Incorporation Date (once approved)</label>
                                <input type="date" id="acraIncorpDate" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="reg-label">Filing Fee (SGD)</label>
                                <input type="number" id="acraFee" class="form-control" value="315" step="0.01">
                                <small class="text-muted">Standard incorporation fee: SGD 315 (SGD 15 name application + SGD 300 registration)</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="reg-label">ACRA Notes / Rejection Reason</label>
                        <textarea id="acraNotes" class="form-control" rows="2" placeholder="Any notes about the ACRA filing..."></textarea>
                    </div>

                    <!-- ACRA Filing Checklist -->
                    <h5 style="font-weight:600;margin-top:20px;margin-bottom:12px;">Filing Checklist</h5>
                    <div class="acra-checklist">
                        <label class="change-check-item"><input type="checkbox" id="chkNameApproved"> <i class="fa fa-check-square-o"></i> Name application approved</label>
                        <label class="change-check-item"><input type="checkbox" id="chkPreDocsReady"> <i class="fa fa-file-text"></i> All pre-incorp docs signed</label>
                        <label class="change-check-item"><input type="checkbox" id="chkIDVerified"> <i class="fa fa-id-card"></i> All directors/shareholders ID verified</label>
                        <label class="change-check-item"><input type="checkbox" id="chkAddressVerified"> <i class="fa fa-map-marker"></i> Registered address verified</label>
                        <label class="change-check-item"><input type="checkbox" id="chkFeesPaid"> <i class="fa fa-money"></i> Filing fees paid</label>
                        <label class="change-check-item"><input type="checkbox" id="chkSubmitted"> <i class="fa fa-paper-plane"></i> Submitted to ACRA</label>
                        <label class="change-check-item"><input type="checkbox" id="chkCertReceived"> <i class="fa fa-certificate"></i> Certificate of Incorporation received</label>
                        <label class="change-check-item"><input type="checkbox" id="chkBizProfile"> <i class="fa fa-file-pdf-o"></i> Business Profile downloaded</label>
                    </div>

                    <div style="display:flex;justify-content:space-between;gap:8px;margin-top:24px;">
                        <button class="btn btn-default" id="backToStep2" style="border-radius:var(--cf-radius-sm);">
                            <i class="fa fa-arrow-left" style="margin-right:6px;"></i> Back
                        </button>
                        <button class="btn btn-primary" id="goToStep4" style="border-radius:var(--cf-radius-sm);padding:8px 24px;font-weight:600;">
                            Next: Post-Incorp Docs <i class="fa fa-arrow-right" style="margin-left:6px;"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==================== STEP 4: Post-Incorporation Documents ==================== -->
<div class="reg-panel" id="step4Panel" style="display:none;">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel" style="border-radius:var(--cf-radius);border:1px solid var(--cf-border);box-shadow:var(--cf-shadow);">
                <div class="x_title" style="border-bottom:1px solid var(--cf-border);padding:16px 20px;">
                    <h2 style="margin:0;font-size:16px;font-weight:600;color:var(--cf-text);">
                        <i class="fa fa-check-circle" style="color:#10b981;margin-right:8px;"></i> Post-Incorporation Documents
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" style="padding:24px;">

                    <p style="font-size:13px;color:var(--cf-text-secondary);margin-bottom:16px;">
                        After ACRA incorporation is approved, generate the post-incorporation documents to complete company setup.
                    </p>

                    <!-- Post-Incorp Document Checklist -->
                    <div id="postIncorpDocs" class="doc-checklist">
                        <div class="doc-item" data-doc="first_directors_resolution">
                            <div class="doc-item-header">
                                <span class="doc-status"><i class="fa fa-circle-o"></i></span>
                                <strong>First Directors' Resolution in Writing</strong>
                            </div>
                            <div class="doc-item-desc">Covers: registered office, bank account opening, FYE, secretary appointment, share allotment, common seal, DPO</div>
                            <div class="doc-item-body" style="display:none;"></div>
                        </div>
                        <div class="doc-item" data-doc="dpo_notification">
                            <div class="doc-item-header">
                                <span class="doc-status"><i class="fa fa-circle-o"></i></span>
                                <strong>Data Protection Officer (DPO) Notification</strong>
                            </div>
                            <div class="doc-item-desc">Required under PDPA for all companies collecting personal data</div>
                            <div class="doc-item-body" style="display:none;"></div>
                        </div>
                        <div class="doc-item" data-doc="nominee_director_agreement">
                            <div class="doc-item-header">
                                <span class="doc-status"><i class="fa fa-circle-o"></i></span>
                                <strong>Nominee Director Agreement</strong>
                            </div>
                            <div class="doc-item-desc">If a nominee/local resident director is appointed</div>
                            <div class="doc-item-body" style="display:none;"></div>
                        </div>
                        <div class="doc-item" data-doc="letter_of_authorization">
                            <div class="doc-item-header">
                                <span class="doc-status"><i class="fa fa-circle-o"></i></span>
                                <strong>Letter of Authorization</strong>
                            </div>
                            <div class="doc-item-desc">Authorizing the corporate secretary to act on behalf of the company</div>
                            <div class="doc-item-body" style="display:none;"></div>
                        </div>
                    </div>

                    <div style="margin-top:20px;text-align:center;">
                        <button class="btn btn-primary btn-lg" id="generatePostIncorpBtn" style="border-radius:var(--cf-radius-sm);padding:12px 40px;font-weight:600;">
                            <i class="fa fa-magic" style="margin-right:8px;"></i> Generate All Post-Incorp Documents with AI
                        </button>
                    </div>

                    <div id="postIncorpResult" style="margin-top:20px;display:none;"></div>

                    <hr style="border-color:var(--cf-border);margin:24px 0;">

                    <!-- Final Actions -->
                    <h5 style="font-weight:600;margin-bottom:12px;">Complete Registration</h5>
                    <p style="font-size:13px;color:var(--cf-text-secondary);">
                        Save this registration to create the company record in CorpFile with all collected information.
                    </p>

                    <div style="display:flex;justify-content:space-between;gap:8px;margin-top:20px;">
                        <button class="btn btn-default" id="backToStep3" style="border-radius:var(--cf-radius-sm);">
                            <i class="fa fa-arrow-left" style="margin-right:6px;"></i> Back
                        </button>
                        <div style="display:flex;gap:8px;">
                            <button class="btn btn-default" id="saveDraftBtn" style="border-radius:var(--cf-radius-sm);">
                                <i class="fa fa-save" style="margin-right:6px;"></i> Save as Draft
                            </button>
                            <button class="btn btn-success" id="completeRegBtn" style="border-radius:var(--cf-radius-sm);padding:8px 24px;font-weight:600;">
                                <i class="fa fa-check" style="margin-right:6px;"></i> Complete & Create Company
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==================== STYLES ==================== -->
<style>
/* Stepper */
.reg-stepper {
    display: flex;
    align-items: flex-start;
    justify-content: center;
    gap: 0;
    padding: 20px;
    background: var(--cf-card-bg);
    border-radius: var(--cf-radius);
    border: 1px solid var(--cf-border);
    box-shadow: var(--cf-shadow);
}
.reg-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    min-width: 120px;
}
.reg-step-circle {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: #e5e7eb;
    color: #6b7280;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 14px;
    transition: all 0.2s;
}
.reg-step.active .reg-step-circle,
.reg-step.completed .reg-step-circle {
    background: var(--cf-accent);
    color: #fff;
}
.reg-step.completed .reg-step-circle {
    background: #10b981;
}
.reg-step-label {
    font-size: 13px; font-weight: 600; color: var(--cf-text);
    text-align: center;
}
.reg-step-desc {
    font-size: 11px; color: var(--cf-text-muted);
    text-align: center;
}
.reg-step-line {
    flex: 1;
    height: 2px;
    background: #e5e7eb;
    margin-top: 18px;
    min-width: 40px;
    max-width: 100px;
}
.reg-step.active ~ .reg-step-line,
.reg-step.active ~ .reg-step { opacity: 0.5; }
.reg-step.completed ~ .reg-step-line { background: #10b981; }

/* Labels */
.reg-label {
    font-size: 13px;
    font-weight: 600;
    color: var(--cf-text);
    margin-bottom: 4px;
    display: block;
}

/* Officer rows */
.officer-row {
    background: #f9fafb;
    padding: 10px 12px;
    border-radius: var(--cf-radius-sm);
    margin-bottom: 8px;
    border: 1px solid var(--cf-border);
}
.officer-row .form-control {
    font-size: 13px;
    padding: 6px 10px;
    height: 34px;
}

/* Document checklist */
.doc-checklist {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.doc-item {
    border: 1px solid var(--cf-border);
    border-radius: var(--cf-radius-sm);
    overflow: hidden;
    transition: all 0.2s;
}
.doc-item.generated {
    border-color: #10b981;
}
.doc-item-header {
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    font-size: 13px;
}
.doc-item-header:hover {
    background: #f9fafb;
}
.doc-item .doc-status {
    color: #d1d5db;
    font-size: 16px;
}
.doc-item.generated .doc-status {
    color: #10b981;
}
.doc-item.generated .doc-status i:before {
    content: "\f058"; /* fa-check-circle */
}
.doc-item-desc {
    padding: 0 16px 8px 42px;
    font-size: 12px;
    color: var(--cf-text-muted);
}
.doc-item-body {
    padding: 0 16px 16px 16px;
    border-top: 1px solid var(--cf-border);
    background: #f8fafc;
}
.doc-item-body .cf-ai-content {
    font-size: 13px;
    line-height: 1.7;
}

/* ACRA Checklist */
.acra-checklist {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
}

@media (max-width: 768px) {
    .reg-stepper { flex-wrap: wrap; gap: 8px; }
    .reg-step-line { display: none; }
    .acra-checklist { grid-template-columns: 1fr; }
}
</style>

<!-- ==================== JAVASCRIPT ==================== -->
<script>
$(document).ready(function() {
    var currentStep = 1;
    var regData = {}; // Collected registration data

    // ── Step Navigation ──
    function goToStep(step) {
        currentStep = step;
        $('.reg-panel').hide();
        $('#step' + step + 'Panel').show();

        // Update stepper
        $('.reg-step').each(function() {
            var s = parseInt($(this).data('step'));
            $(this).removeClass('active completed');
            if (s < step) $(this).addClass('completed');
            if (s === step) $(this).addClass('active');
        });

        // Scroll to top
        $('html, body').animate({ scrollTop: $('.reg-stepper').offset().top - 20 }, 300);
    }

    $('#goToStep2').click(function() {
        // Validate Step 1
        var name = $('#regCompanyName1').val().trim();
        if (!name) {
            alert('Please enter at least one proposed company name.');
            $('#regCompanyName1').focus();
            return;
        }
        collectRegData();
        goToStep(2);
    });

    $('#goToStep3').click(function() { goToStep(3); });
    $('#goToStep4').click(function() { goToStep(4); });
    $('#backToStep1').click(function() { goToStep(1); });
    $('#backToStep2').click(function() { goToStep(2); });
    $('#backToStep3').click(function() { goToStep(3); });

    // Stepper click navigation
    $('.reg-step').click(function() {
        var s = parseInt($(this).data('step'));
        if (s <= currentStep || $(this).hasClass('completed')) {
            goToStep(s);
        }
    });

    // ── Collect form data into regData ──
    function collectRegData() {
        regData.companyName = $('#regCompanyName1').val().trim();
        regData.companyName2 = $('#regCompanyName2').val().trim();
        regData.companyName3 = $('#regCompanyName3').val().trim();
        regData.companyType = $('#regCompanyType').val();
        regData.country = $('#regCountry').val();
        regData.ssic1 = $('#regSSIC1').val().trim();
        regData.ssic2 = $('#regSSIC2').val().trim();
        regData.address = $('#regAddress').val().trim();
        regData.fye = $('#regFYE').val();
        regData.shareCapital = $('#regShareCapital').val();
        regData.numShares = $('#regNumShares').val();
        regData.constitution = $('#regConstitution').val();
        regData.notes = $('#regNotes').val().trim();

        // Directors
        regData.directors = [];
        $('#directorsContainer .officer-row').each(function() {
            var name = $(this).find('.dir-name').val().trim();
            if (name) {
                regData.directors.push({
                    name: name,
                    id: $(this).find('.dir-id').val().trim(),
                    nationality: $(this).find('.dir-nationality').val().trim(),
                    address: $(this).find('.dir-address').val().trim(),
                    email: $(this).find('.dir-email').val().trim()
                });
            }
        });

        // Shareholders
        regData.shareholders = [];
        $('#shareholdersContainer .officer-row').each(function() {
            var name = $(this).find('.sh-name').val().trim();
            if (name) {
                regData.shareholders.push({
                    name: name,
                    id: $(this).find('.sh-id').val().trim(),
                    type: $(this).find('.sh-type').val(),
                    shares: $(this).find('.sh-shares').val(),
                    nationality: $(this).find('.sh-nationality').val().trim()
                });
            }
        });

        // Secretary
        regData.secretary = {
            name: $('#regSecName').val().trim(),
            id: $('#regSecId').val().trim(),
            email: $('#regSecEmail').val().trim()
        };
    }

    // ── Add/Remove Officer Rows ──
    $('#addDirectorRow').click(function() {
        var html = '<div class="officer-row" data-type="director">' +
            '<div class="row">' +
            '<div class="col-md-3"><input type="text" class="form-control dir-name" placeholder="Full Name *"></div>' +
            '<div class="col-md-2"><input type="text" class="form-control dir-id" placeholder="NRIC / Passport"></div>' +
            '<div class="col-md-2"><input type="text" class="form-control dir-nationality" placeholder="Nationality"></div>' +
            '<div class="col-md-2"><input type="text" class="form-control dir-address" placeholder="Residential Address"></div>' +
            '<div class="col-md-2"><input type="email" class="form-control dir-email" placeholder="Email"></div>' +
            '<div class="col-md-1"><button class="btn btn-danger btn-xs remove-officer" style="margin-top:6px;border-radius:6px;" title="Remove"><i class="fa fa-trash"></i></button></div>' +
            '</div></div>';
        $('#directorsContainer').append(html);
    });

    $('#addShareholderRow').click(function() {
        var html = '<div class="officer-row" data-type="shareholder">' +
            '<div class="row">' +
            '<div class="col-md-3"><input type="text" class="form-control sh-name" placeholder="Full Name *"></div>' +
            '<div class="col-md-2"><input type="text" class="form-control sh-id" placeholder="NRIC / Passport"></div>' +
            '<div class="col-md-2"><select class="form-control sh-type"><option value="Individual">Individual</option><option value="Corporate">Corporate</option></select></div>' +
            '<div class="col-md-2"><input type="number" class="form-control sh-shares" placeholder="No. of Shares" value="1" min="1"></div>' +
            '<div class="col-md-2"><input type="text" class="form-control sh-nationality" placeholder="Nationality"></div>' +
            '<div class="col-md-1"><button class="btn btn-danger btn-xs remove-officer" style="margin-top:6px;border-radius:6px;" title="Remove"><i class="fa fa-trash"></i></button></div>' +
            '</div></div>';
        $('#shareholdersContainer').append(html);
    });

    $(document).on('click', '.remove-officer', function() {
        var container = $(this).closest('.officer-row').parent();
        if (container.find('.officer-row').length > 1) {
            $(this).closest('.officer-row').remove();
        } else {
            alert('At least one entry is required.');
        }
    });

    // ── Toggle doc item body ──
    $(document).on('click', '.doc-item-header', function() {
        var body = $(this).closest('.doc-item').find('.doc-item-body');
        if (body.html().trim()) {
            body.slideToggle(200);
        }
    });

    // ── Generate Pre-Incorp Documents ──
    $('#generatePreIncorpBtn').click(function() {
        collectRegData();
        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Generating documents...');
        $('#preIncorpResult').show().html('<div style="padding:30px;text-align:center;color:var(--cf-text-muted);"><i class="fa fa-spinner fa-spin fa-2x"></i><br><br>AI is generating 8 pre-incorporation documents...<br><small>This may take 30-60 seconds</small></div>');

        var prompt = buildPreIncorpPrompt();

        fetch('<?= base_url("ai/chat") ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message: prompt, source: 'agent', agent: 'docgen' })
        })
        .then(function(r) { return r.text(); })
        .then(function(text) {
            var jsonMatch = text.match(/\{[\s\S]*\}$/);
            if (jsonMatch) {
                var data = JSON.parse(jsonMatch[0]);
                btn.prop('disabled', false).html('<i class="fa fa-magic" style="margin-right:8px;"></i> Regenerate Pre-Incorp Documents');
                if (data.ok && data.response_text) {
                    renderDocuments('preIncorpDocs', data.response_text, 'preIncorpResult');
                } else {
                    $('#preIncorpResult').html('<div class="alert alert-danger">' + (data.error || 'Failed to generate.') + '</div>');
                }
            }
        })
        .catch(function(err) {
            btn.prop('disabled', false).html('<i class="fa fa-magic" style="margin-right:8px;"></i> Generate All Pre-Incorp Documents with AI');
            $('#preIncorpResult').html('<div class="alert alert-danger">Connection error. Please try again.</div>');
        });
    });

    // ── Generate Post-Incorp Documents ──
    $('#generatePostIncorpBtn').click(function() {
        collectRegData();
        // Also collect ACRA info
        regData.uen = $('#acraUEN').val().trim();
        regData.incorpDate = $('#acraIncorpDate').val();

        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Generating documents...');
        $('#postIncorpResult').show().html('<div style="padding:30px;text-align:center;color:var(--cf-text-muted);"><i class="fa fa-spinner fa-spin fa-2x"></i><br><br>AI is generating post-incorporation documents...<br><small>This may take 30-60 seconds</small></div>');

        var prompt = buildPostIncorpPrompt();

        fetch('<?= base_url("ai/chat") ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message: prompt, source: 'agent', agent: 'docgen' })
        })
        .then(function(r) { return r.text(); })
        .then(function(text) {
            var jsonMatch = text.match(/\{[\s\S]*\}$/);
            if (jsonMatch) {
                var data = JSON.parse(jsonMatch[0]);
                btn.prop('disabled', false).html('<i class="fa fa-magic" style="margin-right:8px;"></i> Regenerate Post-Incorp Documents');
                if (data.ok && data.response_text) {
                    renderDocuments('postIncorpDocs', data.response_text, 'postIncorpResult');
                } else {
                    $('#postIncorpResult').html('<div class="alert alert-danger">' + (data.error || 'Failed to generate.') + '</div>');
                }
            }
        })
        .catch(function() {
            btn.prop('disabled', false).html('<i class="fa fa-magic" style="margin-right:8px;"></i> Generate All Post-Incorp Documents with AI');
            $('#postIncorpResult').html('<div class="alert alert-danger">Connection error. Please try again.</div>');
        });
    });

    // ── Build AI Prompts ──
    function buildPreIncorpPrompt() {
        var p = 'Generate pre-incorporation documents for a new Singapore company registration.\n\n';
        p += '=== COMPANY INFORMATION ===\n';
        p += 'Proposed Company Name: ' + regData.companyName + '\n';
        if (regData.companyName2) p += 'Alternative Name 2: ' + regData.companyName2 + '\n';
        if (regData.companyName3) p += 'Alternative Name 3: ' + regData.companyName3 + '\n';
        p += 'Company Type: ' + regData.companyType + '\n';
        p += 'Country: ' + regData.country + '\n';
        p += 'Registered Address: ' + regData.address + '\n';
        p += 'SSIC 1: ' + (regData.ssic1 || 'Not specified') + '\n';
        if (regData.ssic2) p += 'SSIC 2: ' + regData.ssic2 + '\n';
        p += 'FYE: ' + regData.fye + '\n';
        p += 'Share Capital: SGD ' + regData.shareCapital + '\n';
        p += 'Number of Shares: ' + regData.numShares + '\n';
        p += 'Constitution: ' + regData.constitution + '\n';

        p += '\n=== DIRECTORS ===\n';
        regData.directors.forEach(function(d, i) {
            p += 'Director ' + (i+1) + ': ' + d.name;
            if (d.id) p += ', ID: ' + d.id;
            if (d.nationality) p += ', Nationality: ' + d.nationality;
            if (d.address) p += ', Address: ' + d.address;
            if (d.email) p += ', Email: ' + d.email;
            p += '\n';
        });

        p += '\n=== SHAREHOLDERS ===\n';
        regData.shareholders.forEach(function(s, i) {
            p += 'Shareholder ' + (i+1) + ': ' + s.name + ' (' + s.type + ')';
            if (s.id) p += ', ID: ' + s.id;
            p += ', Shares: ' + s.shares;
            if (s.nationality) p += ', Nationality: ' + s.nationality;
            p += '\n';
        });

        p += '\n=== COMPANY SECRETARY ===\n';
        p += regData.secretary.name + (regData.secretary.id ? ', ID: ' + regData.secretary.id : '') + '\n';

        if (regData.notes) p += '\n=== ADDITIONAL NOTES ===\n' + regData.notes + '\n';

        p += '\n=== DOCUMENTS TO GENERATE ===\n';
        p += 'Please generate ALL of the following pre-incorporation documents with complete, ready-to-sign content:\n\n';
        p += '1. **Subscriber\'s Consent to Act as Member** - For each subscriber/shareholder\n';
        p += '2. **Consent to Act as Director (Form 45)** - For each director\n';
        p += '3. **Notice of Registered Office Address** - Company registered office notification\n';
        p += '4. **Declaration of Non-Disqualification (Form 45B)** - For each director\n';
        p += '5. **Register of Registrable Controllers** - Initial register entry\n';
        p += '6. **Register of Nominee Shareholders** - Declaration (even if none)\n';
        p += '7. **Declaration of Compliance with Requirements (DCR)** - By the company secretary\n';
        p += '8. **KYC / Customer Due Diligence Checklist** - Items to collect from each person\n';
        p += '\nFormat each document with clear headers separating them. Use proper Singapore legal language.\n';
        p += 'Include signature lines with "Name:", "NRIC/Passport:", "Signature:", "Date:" fields.\n';
        p += 'For each document, clearly label it like: "## DOCUMENT 1: Subscriber\'s Consent to Act as Member"';

        return p;
    }

    function buildPostIncorpPrompt() {
        var p = 'Generate post-incorporation documents for a newly incorporated Singapore company.\n\n';
        p += '=== COMPANY INFORMATION ===\n';
        p += 'Company Name: ' + regData.companyName + '\n';
        p += 'UEN: ' + (regData.uen || 'Pending') + '\n';
        p += 'Incorporation Date: ' + (regData.incorpDate || 'Pending') + '\n';
        p += 'Company Type: ' + regData.companyType + '\n';
        p += 'Registered Address: ' + regData.address + '\n';
        p += 'FYE: ' + regData.fye + '\n';
        p += 'Share Capital: SGD ' + regData.shareCapital + ', Shares: ' + regData.numShares + '\n';
        p += 'Constitution: ' + regData.constitution + '\n';

        p += '\n=== DIRECTORS ===\n';
        regData.directors.forEach(function(d, i) {
            p += 'Director ' + (i+1) + ': ' + d.name;
            if (d.id) p += ', ID: ' + d.id;
            if (d.nationality) p += ', Nationality: ' + d.nationality;
            p += '\n';
        });

        p += '\n=== SHAREHOLDERS ===\n';
        regData.shareholders.forEach(function(s, i) {
            p += 'Shareholder ' + (i+1) + ': ' + s.name + ' (' + s.type + '), Shares: ' + s.shares + '\n';
        });

        p += '\n=== SECRETARY ===\n';
        p += regData.secretary.name + '\n';

        if (regData.notes) p += '\n=== ADDITIONAL NOTES ===\n' + regData.notes + '\n';

        p += '\n=== DOCUMENTS TO GENERATE ===\n';
        p += 'Please generate ALL of the following post-incorporation documents:\n\n';
        p += '1. **First Directors\' Resolution in Writing** - Comprehensive resolution covering:\n';
        p += '   - Confirmation of registered office address\n';
        p += '   - Opening of bank account (recommend DBS/OCBC/UOB)\n';
        p += '   - Adoption of company seal (if applicable)\n';
        p += '   - Appointment of company secretary\n';
        p += '   - Confirmation of financial year end\n';
        p += '   - Allotment and issuance of shares to subscribers\n';
        p += '   - Appointment of Data Protection Officer\n';
        p += '   - Authorization for corporate secretary to handle ACRA filings\n';
        p += '2. **Data Protection Officer (DPO) Notification** - PDPA compliance notification\n';
        p += '3. **Nominee Director Agreement** - Standard agreement (if nominee director is used)\n';
        p += '4. **Letter of Authorization** - Authorizing corporate secretary for ACRA e-services\n';
        p += '\nFormat each document with clear headers. Use proper Singapore legal language.\n';
        p += 'Include signature lines and date fields. Label: "## DOCUMENT 1: First Directors\' Resolution"';

        return p;
    }

    // ── Render AI-generated documents into checklist ──
    function renderDocuments(containerId, responseText, resultId) {
        var md = (typeof cfRenderMarkdown === 'function') ? cfRenderMarkdown(responseText) : responseText;

        // Show full result with copy button
        $('#' + resultId).html(
            '<div style="border:1px solid var(--cf-border);border-radius:var(--cf-radius);padding:16px;background:#f8fafc;max-height:500px;overflow-y:auto;">' +
            '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">' +
            '<strong style="color:var(--cf-primary);"><i class="fa fa-file-text-o"></i> Generated Documents</strong>' +
            '<button class="btn btn-default btn-xs" onclick="copyRegResult(\'' + resultId + '\')" title="Copy All"><i class="fa fa-copy"></i> Copy All</button>' +
            '</div>' +
            '<div id="' + resultId + 'Content" class="cf-ai-content" style="font-size:13px;line-height:1.7;">' + md + '</div>' +
            '</div>'
        );

        // Mark all doc items as generated
        $('#' + containerId + ' .doc-item').addClass('generated');
    }

    // ── Save Draft / Complete Registration ──
    $('#saveDraftBtn').click(function() {
        collectRegData();
        saveRegistration('Pre-Incorporation');
    });

    $('#completeRegBtn').click(function() {
        collectRegData();
        regData.uen = $('#acraUEN').val().trim();
        regData.incorpDate = $('#acraIncorpDate').val();

        if (!regData.uen) {
            if (!confirm('No UEN has been entered. Save as Pre-Incorporation company?')) return;
        }

        saveRegistration(regData.uen ? 'Active' : 'Pre-Incorporation');
    });

    function saveRegistration(status) {
        var formData = {
            'company-name': regData.companyName,
            'company-type': '',
            'reg-num': regData.uen || '',
            'acra_reg_id': regData.uen || '',
            'country': regData.country,
            'incorp-date': regData.incorpDate || '',
            'company-status': status,
            'company_status': status === 'Active' ? 'Active' : 'Pre-Incorporation',
            'date-fye': regData.fye,
            'ord_issued_share_capital': regData.shareCapital,
            'no_ord_shares': regData.numShares,
            'reg-address': regData.address,
            'remarks': regData.notes || '',
            'client': '1',
            'corporate_shareholder_client': '1',
            'ci_csrf_token': '<?= $csrf_token ?? "" ?>'
        };

        // POST to add_company
        var form = $('<form method="POST" action="<?= base_url("add_company") ?>"></form>');
        for (var key in formData) {
            form.append($('<input type="hidden">').attr('name', key).val(formData[key]));
        }

        // Add directors
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

        // Add shareholders
        regData.shareholders.forEach(function(s) {
            form.append($('<input type="hidden" name="shareh-name[]">').val(s.name));
            form.append($('<input type="hidden" name="shareholder_type[]">').val(s.type));
            form.append($('<input type="hidden" name="shareh_id_type[]">').val('NRIC'));
            form.append($('<input type="hidden" name="shareh-passport[]">').val(s.id));
            form.append($('<input type="hidden" name="shareh-nationality[]">').val(s.nationality));
            form.append($('<input type="hidden" name="shareh-doapp[]">').val(''));
        });

        // Add secretary
        if (regData.secretary.name) {
            form.append($('<input type="hidden" name="secreatary-name[]">').val(regData.secretary.name));
            form.append($('<input type="hidden" name="secretary_id_type[]">').val(''));
            form.append($('<input type="hidden" name="secreatary-passport[]">').val(regData.secretary.id));
            form.append($('<input type="hidden" name="secreatary-nationality[]">').val('SINGAPORE'));
            form.append($('<input type="hidden" name="secreatary-doapp[]">').val(''));
        }

        $('body').append(form);
        form.submit();
    }
});

function copyRegResult(resultId) {
    var el = document.getElementById(resultId + 'Content');
    if (el) {
        var range = document.createRange();
        range.selectNodeContents(el);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
        document.execCommand('copy');
        sel.removeAllRanges();
        alert('Copied to clipboard!');
    }
}
</script>
