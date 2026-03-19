<style>
.nr-page {
    --cf-primary: #1e3a5f;
    --cf-accent: #4f86c6;
    --cf-border: #e5e7eb;
    --cf-bg: #f8fafc;
    --cf-white: #fff;
    --cf-text: #1e293b;
    --cf-text-secondary: #64748b;
    --cf-text-muted: #94a3b8;
    --cf-radius: 12px;
    --cf-font: Inter, system-ui, sans-serif;

    color: var(--cf-text);
    font-family: var(--cf-font);
}

.nr-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.nr-back-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--cf-primary);
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
}

.nr-back-link:hover,
.nr-back-link:focus {
    color: var(--cf-accent);
    text-decoration: none;
}

.nr-title {
    margin: 0;
    font-size: 28px;
    font-weight: 700;
    letter-spacing: -0.02em;
}

.nr-card {
    background: var(--cf-white);
    border: 1px solid var(--cf-border);
    border-radius: var(--cf-radius);
    box-shadow: 0 10px 35px rgba(15, 23, 42, 0.05);
    overflow: hidden;
}

.nr-card-head {
    padding: 16px 20px;
    border-bottom: 1px solid var(--cf-border);
    background: linear-gradient(120deg, rgba(79, 134, 198, 0.08), rgba(30, 58, 95, 0.03));
}

.nr-card-title {
    margin: 0;
    font-size: 17px;
    font-weight: 700;
}

.nr-card-subtitle {
    margin: 4px 0 0;
    font-size: 13px;
    color: var(--cf-text-secondary);
}

.nr-stepper {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 20px;
    margin-bottom: 22px;
}

.nr-step {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 600;
    color: var(--cf-text-muted);
    white-space: nowrap;
    cursor: pointer;
    transition: color 0.2s;
}

.nr-step.active,
.nr-step.done {
    color: var(--cf-primary);
}

.nr-step-num {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    border: 1px solid var(--cf-border);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    background: var(--cf-white);
}

.nr-step.active .nr-step-num,
.nr-step.done .nr-step-num {
    background: var(--cf-primary);
    border-color: var(--cf-primary);
    color: #fff;
}

.nr-step-line {
    flex: 1;
    height: 3px;
    border-radius: 999px;
    background: linear-gradient(to right, rgba(30, 58, 95, 0.28), rgba(79, 134, 198, 0.2));
}

.nr-step-pane {
    display: none;
    padding: 20px;
}

.nr-step-pane.active {
    display: block;
}

.nr-accordion {
    border: 1px solid var(--cf-border);
    border-radius: var(--cf-radius);
    overflow: hidden;
    background: var(--cf-white);
}

.nr-section + .nr-section {
    border-top: 1px solid var(--cf-border);
}

.nr-section-head {
    width: 100%;
    border: none;
    background: #fcfdff;
    color: var(--cf-text);
    text-align: left;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    font-size: 14px;
    font-weight: 700;
}

.nr-section-head:hover {
    background: rgba(79, 134, 198, 0.08);
}

.nr-chevron {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 1px solid var(--cf-border);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: var(--cf-text-muted);
    transition: transform 0.2s;
}

.nr-section.open .nr-chevron {
    transform: rotate(180deg);
}

.nr-section-body {
    display: none;
    padding: 16px;
    background: var(--cf-white);
}

.nr-section.open .nr-section-body {
    display: block;
}

.nr-repeat-wrap {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.nr-repeat-card {
    border: 1px solid var(--cf-border);
    border-radius: 10px;
    background: var(--cf-bg);
    padding: 14px;
}

.nr-repeat-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
    gap: 10px;
}

.nr-repeat-title {
    margin: 0;
    font-size: 13px;
    font-weight: 700;
    color: var(--cf-text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.nr-inline-help {
    margin: 0;
    font-size: 12px;
    color: var(--cf-text-muted);
}

.nr-actions {
    margin-top: 18px;
    display: flex;
    justify-content: space-between;
    gap: 10px;
}

.nr-doc-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 12px;
}

.nr-doc-card {
    border: 1px solid var(--cf-border);
    border-radius: 12px;
    background: #fcfdff;
    padding: 12px;
    display: flex;
    gap: 10px;
    align-items: flex-start;
}

.nr-doc-icon {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: rgba(79, 134, 198, 0.16);
    color: var(--cf-primary);
    flex-shrink: 0;
}

.nr-doc-main {
    flex: 1;
    min-width: 0;
}

.nr-doc-name {
    margin: 0;
    font-size: 13px;
    font-weight: 700;
}

.nr-doc-detail {
    margin-top: 3px;
    font-size: 12px;
    color: var(--cf-text-secondary);
}

.nr-badge {
    display: inline-flex;
    align-items: center;
    border-radius: 999px;
    padding: 2px 8px;
    font-size: 11px;
    font-weight: 700;
}

.nr-badge.required {
    background: rgba(16, 185, 129, 0.14);
    color: #059669;
}

.nr-badge.conditional {
    background: rgba(245, 158, 11, 0.18);
    color: #d97706;
}

.nr-generation {
    margin-top: 16px;
    border: 1px solid var(--cf-border);
    border-radius: 12px;
    background: var(--cf-white);
    overflow: hidden;
}

.nr-progress-wrap {
    padding: 12px;
    border-bottom: 1px solid var(--cf-border);
}

.nr-progress-label {
    font-size: 12px;
    color: var(--cf-text-secondary);
    margin-bottom: 6px;
}

.nr-output {
    max-height: 420px;
    overflow-y: auto;
    padding: 12px;
    background: #fdfefe;
}

.nr-output-empty {
    color: var(--cf-text-muted);
    font-size: 13px;
}

.nr-doc-output {
    border: 1px solid var(--cf-border);
    border-radius: 10px;
    margin-bottom: 12px;
    background: var(--cf-white);
}

.nr-doc-output-head {
    border-bottom: 1px solid var(--cf-border);
    padding: 10px 12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

.nr-doc-output-title {
    margin: 0;
    font-size: 13px;
    font-weight: 700;
}

.nr-doc-output-body {
    padding: 12px;
    white-space: pre-wrap;
    font-size: 12px;
    line-height: 1.55;
    color: var(--cf-text);
    max-height: 300px;
    overflow-y: auto;
}

.nr-checklist {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 8px;
}

.nr-check-item {
    border: 1px solid var(--cf-border);
    border-radius: 10px;
    padding: 10px 12px;
    background: #fcfdff;
}

.nr-check-item label {
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 600;
}

.nr-acra-grid {
    margin-top: 16px;
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 12px;
}

.form-group label {
    color: var(--cf-text-secondary);
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.02em;
}

.form-control {
    border-color: var(--cf-border);
    box-shadow: none;
    font-size: 13px;
}

.form-control:focus {
    border-color: var(--cf-accent);
    box-shadow: 0 0 0 3px rgba(79, 134, 198, 0.15);
}

.help-block {
    font-size: 12px;
    color: var(--cf-text-muted);
}

.checkbox label {
    font-size: 13px;
    color: var(--cf-text);
    text-transform: none;
    letter-spacing: 0;
}

.nr-inline-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.nr-hidden {
    display: none !important;
}

@media (max-width: 992px) {
    .nr-doc-grid,
    .nr-acra-grid {
        grid-template-columns: 1fr;
    }

    .nr-stepper {
        overflow-x: auto;
        padding-bottom: 6px;
    }

    .nr-step-line {
        min-width: 24px;
    }

    .nr-actions {
        flex-direction: column-reverse;
    }
}
</style>

<div class="nr-page">
    <div class="nr-topbar">
        <a class="nr-back-link" href="<?= base_url('workspace/registration') ?>"><i class="fa fa-arrow-left"></i> Back to Registration</a>
    </div>

    <h1 class="nr-title">New Company Registration</h1>

    <div class="nr-stepper">
        <div class="nr-step active" data-step="1"><span class="nr-step-num">1</span> Questionnaire</div>
        <div class="nr-step-line"></div>
        <div class="nr-step" data-step="2"><span class="nr-step-num">2</span> Pre-Incorp Docs</div>
        <div class="nr-step-line"></div>
        <div class="nr-step" data-step="3"><span class="nr-step-num">3</span> ACRA Filing</div>
        <div class="nr-step-line"></div>
        <div class="nr-step" data-step="4"><span class="nr-step-num">4</span> Post-Incorp</div>
    </div>

    <div class="nr-card">
        <div class="nr-card-head">
            <h3 class="nr-card-title" id="nrStepTitle">Step 1: Company Questionnaire</h3>
            <p class="nr-card-subtitle" id="nrStepSubtitle">Complete all sections, then generate pre-incorporation documents.</p>
        </div>

        <div class="nr-step-pane active" data-pane="1">
            <div class="nr-accordion" id="nrAccordion">
                <div class="nr-section open" data-section="1">
                    <button type="button" class="nr-section-head" onclick="toggleNrSection(this)">
                        <span>1. Company Info</span>
                        <span class="nr-chevron"><i class="fa fa-chevron-down"></i></span>
                    </button>
                    <div class="nr-section-body" style="display:block;">
                        <div class="row">
                            <div class="col-sm-4 form-group"><label>Company Name Choice 1</label><input class="form-control" name="company_name_1" type="text"></div>
                            <div class="col-sm-4 form-group"><label>Company Name Choice 2</label><input class="form-control" name="company_name_2" type="text"></div>
                            <div class="col-sm-4 form-group"><label>Company Name Choice 3</label><input class="form-control" name="company_name_3" type="text"></div>
                        </div>
                        <div class="form-group">
                            <label>Principal Activities</label>
                            <textarea class="form-control" name="principal_activities" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 form-group"><label>SSIC Code</label><input class="form-control" name="ssic_code" type="text"></div>
                        </div>
                    </div>
                </div>

                <div class="nr-section" data-section="2">
                    <button type="button" class="nr-section-head" onclick="toggleNrSection(this)">
                        <span>2. Company Assets</span>
                        <span class="nr-chevron"><i class="fa fa-chevron-down"></i></span>
                    </button>
                    <div class="nr-section-body">
                        <div class="form-group">
                            <label>Assets</label>
                            <textarea class="form-control" name="assets" rows="3">N.A.</textarea>
                        </div>
                    </div>
                </div>

                <div class="nr-section" data-section="3">
                    <button type="button" class="nr-section-head" onclick="toggleNrSection(this)">
                        <span>3. Source of Funds</span>
                        <span class="nr-chevron"><i class="fa fa-chevron-down"></i></span>
                    </button>
                    <div class="nr-section-body">
                        <div class="form-group">
                            <label>Source of Funds</label>
                            <textarea class="form-control" name="source_of_funds" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="nr-section" data-section="4">
                    <button type="button" class="nr-section-head" onclick="toggleNrSection(this)">
                        <span>4. Group Companies</span>
                        <span class="nr-chevron"><i class="fa fa-chevron-down"></i></span>
                    </button>
                    <div class="nr-section-body" style="display:block;">
                        <div class="row">
                            <div class="col-sm-6 form-group"><label>Group Name</label><input class="form-control" name="group_name" type="text"></div>
                            <div class="col-sm-6 form-group"><label>Group Website</label><input class="form-control" name="group_website" type="text" placeholder="https://"></div>
                        </div>
                    </div>
                </div>

                <div class="nr-section" data-section="5">
                    <button type="button" class="nr-section-head" onclick="toggleNrSection(this)">
                        <span>5. UBO / Registrable Controller</span>
                        <span class="nr-chevron"><i class="fa fa-chevron-down"></i></span>
                    </button>
                    <div class="nr-section-body">
                        <p class="nr-inline-help">Add one or more UBO/controller records.</p>
                        <div id="uboList" class="nr-repeat-wrap"></div>
                        <button type="button" class="btn btn-default btn-sm" id="addUboBtn"><i class="fa fa-plus"></i> Add UBO / Controller</button>
                    </div>
                </div>

                <div class="nr-section" data-section="6">
                    <button type="button" class="nr-section-head" onclick="toggleNrSection(this)">
                        <span>6. Shareholders</span>
                        <span class="nr-chevron"><i class="fa fa-chevron-down"></i></span>
                    </button>
                    <div class="nr-section-body">
                        <p class="nr-inline-help">Add each shareholder and share allocation details.</p>
                        <div id="shareholderList" class="nr-repeat-wrap"></div>
                        <button type="button" class="btn btn-default btn-sm" id="addShareholderBtn"><i class="fa fa-plus"></i> Add Shareholder</button>
                    </div>
                </div>

                <div class="nr-section" data-section="7">
                    <button type="button" class="nr-section-head" onclick="toggleNrSection(this)">
                        <span>7. Capital Structure</span>
                        <span class="nr-chevron"><i class="fa fa-chevron-down"></i></span>
                    </button>
                    <div class="nr-section-body">
                        <div class="row">
                            <div class="col-sm-4 form-group"><label>Share Class</label><input class="form-control" name="share_class" type="text" value="Ordinary"></div>
                            <div class="col-sm-4 form-group"><label>Total Shares</label><input class="form-control" name="total_shares" type="number" min="0"></div>
                            <div class="col-sm-4 form-group"><label>Price per Share</label><input class="form-control" name="price_per_share" type="number" min="0" step="0.01" value="1"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 form-group"><label>Paid-up Amount</label><input class="form-control" name="paid_up_amount" type="number" min="0" step="0.01"></div>
                            <div class="col-sm-4 form-group">
                                <label>Currency</label>
                                <select class="form-control" name="currency">
                                    <option>SGD</option>
                                    <option>USD</option>
                                    <option>RMB</option>
                                    <option>EUR</option>
                                    <option>GBP</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="nr-section" data-section="8">
                    <button type="button" class="nr-section-head" onclick="toggleNrSection(this)">
                        <span>8. Registered Office</span>
                        <span class="nr-chevron"><i class="fa fa-chevron-down"></i></span>
                    </button>
                    <div class="nr-section-body">
                        <div class="radio">
                            <label>
                                <input type="radio" name="registered_office_mode" value="agent" checked>
                                Use agent address (51 Goldhill Plaza #20-07 Singapore 308900)
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="registered_office_mode" value="custom">
                                Use custom registered office address
                            </label>
                        </div>
                        <div class="form-group" id="customAddressWrap">
                            <label>Custom Address</label>
                            <input class="form-control" name="custom_address" type="text" disabled>
                        </div>
                    </div>
                </div>

                <div class="nr-section" data-section="9">
                    <button type="button" class="nr-section-head" onclick="toggleNrSection(this)">
                        <span>9. Directors</span>
                        <span class="nr-chevron"><i class="fa fa-chevron-down"></i></span>
                    </button>
                    <div class="nr-section-body">
                        <p class="nr-inline-help">At least one director must be marked as Singapore resident.</p>
                        <div id="directorList" class="nr-repeat-wrap"></div>
                        <button type="button" class="btn btn-default btn-sm" id="addDirectorBtn"><i class="fa fa-plus"></i> Add Director</button>
                    </div>
                </div>

                <div class="nr-section" data-section="10">
                    <button type="button" class="nr-section-head" onclick="toggleNrSection(this)">
                        <span>10. Accounting</span>
                        <span class="nr-chevron"><i class="fa fa-chevron-down"></i></span>
                    </button>
                    <div class="nr-section-body">
                        <div class="row">
                            <div class="col-sm-3 form-group"><label>Base Currency</label><input class="form-control" name="base_currency" type="text" value="SGD"></div>
                            <div class="col-sm-3 form-group"><label>FYE</label><input class="form-control" name="fye" type="text" value="31 December"></div>
                            <div class="col-sm-3 form-group"><label>Auditors</label><input class="form-control" name="auditors" type="text"></div>
                            <div class="col-sm-3 form-group"><label>Tax Agent</label><input class="form-control" name="tax_agent" type="text"></div>
                        </div>
                    </div>
                </div>

                <div class="nr-section" data-section="11">
                    <button type="button" class="nr-section-head" onclick="toggleNrSection(this)">
                        <span>11. Bank Account</span>
                        <span class="nr-chevron"><i class="fa fa-chevron-down"></i></span>
                    </button>
                    <div class="nr-section-body">
                        <div class="row">
                            <div class="col-sm-6 form-group"><label>Bank Name</label><input class="form-control" name="bank_name" type="text"></div>
                            <div class="col-sm-6 form-group"><label>Bank Currency</label><input class="form-control" name="bank_currency" type="text"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group"><label>Signatories</label><input class="form-control" name="signatories" type="text"></div>
                            <div class="col-sm-6 form-group">
                                <label>Operation Mode</label>
                                <select class="form-control" name="operation_mode"><option>Singly</option><option>Jointly</option></select>
                            </div>
                        </div>
                        <div class="form-group"><label>Mailing Address</label><input class="form-control" name="mailing_address" type="text"></div>
                    </div>
                </div>

                <div class="nr-section" data-section="12">
                    <button type="button" class="nr-section-head" onclick="toggleNrSection(this)">
                        <span>12. Key Contact</span>
                        <span class="nr-chevron"><i class="fa fa-chevron-down"></i></span>
                    </button>
                    <div class="nr-section-body">
                        <div class="row">
                            <div class="col-sm-4 form-group"><label>Contact Name *</label><input class="form-control" name="contact_name" type="text" required></div>
                            <div class="col-sm-4 form-group"><label>Contact Email *</label><input class="form-control" name="contact_email" type="email" required></div>
                            <div class="col-sm-4 form-group"><label>Contact Phone *</label><input class="form-control" name="contact_phone" type="text" required></div>
                        </div>
                    </div>
                </div>

                <div class="nr-section" data-section="13">
                    <button type="button" class="nr-section-head" onclick="toggleNrSection(this)">
                        <span>13. Declaration</span>
                        <span class="nr-chevron"><i class="fa fa-chevron-down"></i></span>
                    </button>
                    <div class="nr-section-body">
                        <div class="alert alert-info" style="margin-bottom: 12px;">
                            I/We declare that all information provided in this questionnaire is true, complete, and accurate to the best of our knowledge and that we authorize CorpFile to proceed with incorporation and document preparation.
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group"><label>Signatory Name</label><input class="form-control" name="signatory_name" type="text"></div>
                            <div class="col-sm-6 form-group"><label>Declaration Date</label><input class="form-control" name="declaration_date" type="date"></div>
                        </div>
                    </div>
                </div>

                <div class="nr-section" data-section="14">
                    <button type="button" class="nr-section-head" onclick="toggleNrSection(this)">
                        <span>14. KYC Risk</span>
                        <span class="nr-chevron"><i class="fa fa-chevron-down"></i></span>
                    </button>
                    <div class="nr-section-body">
                        <div class="checkbox">
                            <label><input type="checkbox" name="is_high_risk"> Mark as high-risk client profile (triggers Document #9)</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="nr-actions">
                <span class="help-block">All questionnaire data is saved in-memory to <code>regData</code>.</span>
                <button type="button" class="btn btn-primary" id="toStep2Btn">Next: Generate Documents <i class="fa fa-arrow-right"></i></button>
            </div>
        </div>

        <div class="nr-step-pane" data-pane="2">
            <div id="preDocChecklist" class="nr-doc-grid"></div>

            <div class="nr-generation">
                <div class="nr-progress-wrap">
                    <div class="nr-progress-label" id="preProgressLabel">Generation progress: ready</div>
                    <div class="progress" style="margin-bottom: 0; height: 14px;">
                        <div id="preProgressBar" class="progress-bar progress-bar-striped active" role="progressbar" style="width:0%">0%</div>
                    </div>
                </div>
                <div class="nr-output" id="preDocOutput">
                    <div class="nr-output-empty">No generated documents yet.</div>
                </div>
            </div>

            <div class="nr-actions">
                <button type="button" class="btn btn-default" data-goto="1"><i class="fa fa-arrow-left"></i> Back to Questionnaire</button>
                <div class="nr-inline-actions">
                    <button type="button" class="btn btn-info" id="generatePreDocsBtn"><i class="fa fa-magic"></i> Generate All Documents</button>
                    <button type="button" class="btn btn-primary" data-goto="3">Continue to ACRA Filing <i class="fa fa-arrow-right"></i></button>
                </div>
            </div>
        </div>

        <div class="nr-step-pane" data-pane="3">
            <div class="nr-checklist">
                <div class="nr-check-item"><label><input type="checkbox" name="acra_submit"> Submit incorporation application via BizFile+</label></div>
                <div class="nr-check-item"><label><input type="checkbox" name="acra_fee"> Pay ACRA registration fee (SGD 315)</label></div>
                <div class="nr-check-item"><label><input type="checkbox" name="acra_cert"> Receive Certificate of Incorporation</label></div>
            </div>

            <div class="nr-acra-grid">
                <div class="form-group">
                    <label>UEN</label>
                    <input type="text" class="form-control" name="uen" placeholder="e.g. 202612345A">
                </div>
                <div class="form-group">
                    <label>Incorporation Date</label>
                    <input type="date" class="form-control" name="incorporation_date">
                </div>
            </div>

            <div class="nr-actions">
                <button type="button" class="btn btn-default" data-goto="2"><i class="fa fa-arrow-left"></i> Back to Pre-Incorp Docs</button>
                <button type="button" class="btn btn-primary" id="saveAcraBtn">Save &amp; Continue <i class="fa fa-arrow-right"></i></button>
            </div>
        </div>

        <div class="nr-step-pane" data-pane="4">
            <div id="postDocChecklist" class="nr-doc-grid"></div>

            <div class="nr-generation">
                <div class="nr-progress-wrap">
                    <div class="nr-progress-label" id="postProgressLabel">Generation progress: ready</div>
                    <div class="progress" style="margin-bottom: 0; height: 14px;">
                        <div id="postProgressBar" class="progress-bar progress-bar-striped active" role="progressbar" style="width:0%">0%</div>
                    </div>
                </div>
                <div class="nr-output" id="postDocOutput">
                    <div class="nr-output-empty">No generated documents yet.</div>
                </div>
            </div>

            <div class="nr-actions">
                <button type="button" class="btn btn-default" data-goto="3"><i class="fa fa-arrow-left"></i> Back to ACRA Filing</button>
                <div class="nr-inline-actions">
                    <button type="button" class="btn btn-info" id="generatePostDocsBtn"><i class="fa fa-magic"></i> Generate Post-Incorp Documents</button>
                    <button type="button" class="btn btn-success" id="completeRegistrationBtn"><i class="fa fa-check"></i> Complete Registration</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var regData = {
    questionnaire: {},
    ubo: [],
    shareholders: [],
    directors: [],
    selectedPreDocs: [],
    generatedPreDocs: [],
    acra: {},
    selectedPostDocs: [],
    generatedPostDocs: []
};

var directorIndex = 0;
var shareholderIndex = 0;
var uboIndex = 0;

var STEP_META = {
    1: { title: 'Step 1: Company Questionnaire', subtitle: 'Complete all sections, then generate pre-incorporation documents.' },
    2: { title: 'Step 2: Pre-Incorporation Document Generation', subtitle: 'Select required documents and generate using AI.' },
    3: { title: 'Step 3: ACRA Filing', subtitle: 'Capture filing completion status, UEN, and incorporation date.' },
    4: { title: 'Step 4: Post-Incorporation Documents', subtitle: 'Generate post-incorporation set and complete registration.' }
};

function toggleNrSection(btn) {
    var section = btn && btn.closest ? btn.closest('.nr-section') : null;
    if (!section) return false;
    var body = section.querySelector('.nr-section-body');
    if (!body) return false;
    var willOpen = !section.classList.contains('open');
    section.classList.toggle('open', willOpen);
    body.style.display = willOpen ? 'block' : 'none';
    return false;
}

function addUbo(initial) {
    uboIndex += 1;
    var data = initial || {};
    var html = '' +
        '<div class="nr-repeat-card" data-ubo-item data-index="' + uboIndex + '">' +
            '<div class="nr-repeat-head">' +
                '<h5 class="nr-repeat-title">UBO / Controller #' + uboIndex + '</h5>' +
                '<button type="button" class="btn btn-link btn-xs text-danger" data-remove-ubo><i class="fa fa-trash"></i> Remove</button>' +
            '</div>' +
            '<div class="row">' +
                '<div class="col-sm-6 form-group"><label>Name</label><input class="form-control" data-field="ubo_name" type="text" value="' + escAttr(data.ubo_name || '') + '"></div>' +
                '<div class="col-sm-6 form-group"><label>Email</label><input class="form-control" data-field="ubo_email" type="email" value="' + escAttr(data.ubo_email || '') + '"></div>' +
            '</div>' +
            '<div class="form-group"><label>Address</label><input class="form-control" data-field="ubo_address" type="text" value="' + escAttr(data.ubo_address || '') + '"></div>' +
            '<div class="row">' +
                '<div class="col-sm-4 form-group"><label>ID Type</label><select class="form-control" data-field="ubo_id_type"><option>NRIC</option><option>Passport</option><option>Company Reg</option></select></div>' +
                '<div class="col-sm-4 form-group"><label>ID Number</label><input class="form-control" data-field="ubo_id_number" type="text" value="' + escAttr(data.ubo_id_number || '') + '"></div>' +
                '<div class="col-sm-4 form-group"><label>Mobile</label><input class="form-control" data-field="ubo_mobile" type="text" value="' + escAttr(data.ubo_mobile || '') + '"></div>' +
            '</div>' +
            '<div class="row">' +
                '<div class="col-sm-4 form-group"><label>Verified Method</label><select class="form-control" data-field="ubo_verified_method"><option>Video</option><option>Face-to-face</option></select></div>' +
                '<div class="col-sm-4 form-group checkbox"><label><input data-field="ubo_is_pep" type="checkbox"> Is PEP</label></div>' +
                '<div class="col-sm-4 form-group checkbox"><label><input data-field="ubo_is_natural_person" type="checkbox" checked> Is Natural Person</label></div>' +
            '</div>' +
            '<div class="form-group ubo-pep-wrap nr-hidden"><label>PEP Period</label><input class="form-control" data-field="ubo_pep_period" type="text" value="' + escAttr(data.ubo_pep_period || '') + '"></div>' +
        '</div>';
    var $node = $(html);
    $node.find('[data-field="ubo_id_type"]').val(data.ubo_id_type || 'NRIC');
    $node.find('[data-field="ubo_verified_method"]').val(data.ubo_verified_method || 'Video');
    $node.find('[data-field="ubo_is_pep"]').prop('checked', !!data.ubo_is_pep);
    $node.find('[data-field="ubo_is_natural_person"]').prop('checked', data.ubo_is_natural_person !== false);
    if (data.ubo_is_pep) {
        $node.find('.ubo-pep-wrap').removeClass('nr-hidden');
    }
    $('#uboList').append($node);
}

function addShareholder(initial) {
    shareholderIndex += 1;
    var data = initial || {};
    var html = '' +
        '<div class="nr-repeat-card" data-shareholder-item data-index="' + shareholderIndex + '">' +
            '<div class="nr-repeat-head">' +
                '<h5 class="nr-repeat-title">Shareholder #' + shareholderIndex + '</h5>' +
                '<button type="button" class="btn btn-link btn-xs text-danger" data-remove-shareholder><i class="fa fa-trash"></i> Remove</button>' +
            '</div>' +
            '<div class="row">' +
                '<div class="col-sm-6 form-group"><label>Name</label><input class="form-control" data-field="sh_name" type="text" value="' + escAttr(data.sh_name || '') + '"></div>' +
                '<div class="col-sm-3 form-group"><label>Shares</label><input class="form-control" data-field="sh_shares" type="number" min="0" value="' + escAttr(data.sh_shares || '') + '"></div>' +
                '<div class="col-sm-3 form-group"><label>Price / Share</label><input class="form-control" data-field="sh_price_per_share" type="text" value="' + escAttr(data.sh_price_per_share || 'SGD 1.00') + '"></div>' +
            '</div>' +
            '<div class="form-group"><label>Address</label><input class="form-control" data-field="sh_address" type="text" value="' + escAttr(data.sh_address || '') + '"></div>' +
            '<div class="row">' +
                '<div class="col-sm-4 form-group"><label>ID Number</label><input class="form-control" data-field="sh_id_number" type="text" value="' + escAttr(data.sh_id_number || '') + '"></div>' +
                '<div class="col-sm-4 form-group"><label>Nationality</label><input class="form-control" data-field="sh_nationality" type="text" value="' + escAttr(data.sh_nationality || '') + '"></div>' +
                '<div class="col-sm-4 form-group"><label>Verified Method</label><select class="form-control" data-field="sh_verified_method"><option>Video</option><option>Face-to-face</option></select></div>' +
            '</div>' +
            '<div class="row">' +
                '<div class="col-sm-6 form-group"><label>Email</label><input class="form-control" data-field="sh_email" type="email" value="' + escAttr(data.sh_email || '') + '"></div>' +
                '<div class="col-sm-6 form-group"><label>Mobile</label><input class="form-control" data-field="sh_mobile" type="text" value="' + escAttr(data.sh_mobile || '') + '"></div>' +
            '</div>' +
            '<div class="row">' +
                '<div class="col-sm-3 checkbox"><label><input data-field="sh_is_controller" type="checkbox"> Is Controller</label></div>' +
                '<div class="col-sm-3 checkbox"><label><input data-field="sh_is_pep" type="checkbox"> Is PEP</label></div>' +
                '<div class="col-sm-3 checkbox"><label><input data-field="sh_is_company" type="checkbox"> Is Company</label></div>' +
            '</div>' +
        '</div>';
    var $node = $(html);
    $node.find('[data-field="sh_verified_method"]').val(data.sh_verified_method || 'Video');
    $node.find('[data-field="sh_is_controller"]').prop('checked', !!data.sh_is_controller);
    $node.find('[data-field="sh_is_pep"]').prop('checked', !!data.sh_is_pep);
    $node.find('[data-field="sh_is_company"]').prop('checked', !!data.sh_is_company);
    $('#shareholderList').append($node);
}

function addDirector(initial) {
    directorIndex += 1;
    var data = initial || {};
    var html = '' +
        '<div class="nr-repeat-card" data-director-item data-index="' + directorIndex + '">' +
            '<div class="nr-repeat-head">' +
                '<h5 class="nr-repeat-title">Director #' + directorIndex + '</h5>' +
                '<button type="button" class="btn btn-link btn-xs text-danger" data-remove-director><i class="fa fa-trash"></i> Remove</button>' +
            '</div>' +
            '<div class="row">' +
                '<div class="col-sm-6 form-group"><label>Name</label><input class="form-control" data-field="dir_name" type="text" value="' + escAttr(data.dir_name || '') + '"></div>' +
                '<div class="col-sm-6 form-group"><label>ID Number</label><input class="form-control" data-field="dir_id_number" type="text" value="' + escAttr(data.dir_id_number || '') + '"></div>' +
            '</div>' +
            '<div class="form-group"><label>Address</label><input class="form-control" data-field="dir_address" type="text" value="' + escAttr(data.dir_address || '') + '"></div>' +
            '<div class="row">' +
                '<div class="col-sm-4 form-group"><label>Phone</label><input class="form-control" data-field="dir_phone" type="text" value="' + escAttr(data.dir_phone || '') + '"></div>' +
                '<div class="col-sm-4 form-group"><label>Email</label><input class="form-control" data-field="dir_email" type="email" value="' + escAttr(data.dir_email || '') + '"></div>' +
                '<div class="col-sm-4 form-group"><label>Date of Birth</label><input class="form-control" data-field="dir_dob" type="date" value="' + escAttr(data.dir_dob || '') + '"></div>' +
            '</div>' +
            '<div class="row">' +
                '<div class="col-sm-4 form-group"><label>Nationality</label><input class="form-control" data-field="dir_nationality" type="text" value="' + escAttr(data.dir_nationality || '') + '"></div>' +
                '<div class="col-sm-4 form-group"><label>Tax Residence</label><input class="form-control" data-field="dir_tax_residence" type="text" value="' + escAttr(data.dir_tax_residence || '') + '"></div>' +
                '<div class="col-sm-4 form-group"><label>Domicile</label><input class="form-control" data-field="dir_domicile" type="text" value="' + escAttr(data.dir_domicile || '') + '"></div>' +
            '</div>' +
            '<div class="row">' +
                '<div class="col-sm-4 form-group"><label>Verified Method</label><select class="form-control" data-field="dir_verified_method"><option>Video</option><option>Face-to-face</option></select></div>' +
                '<div class="col-sm-4 form-group"><label>Nominee Type</label><select class="form-control" data-field="dir_nominee_type"><option value="individual">Individual</option><option value="corporate">Corporate</option></select></div>' +
            '</div>' +
            '<div class="row">' +
                '<div class="col-sm-4 checkbox"><label><input data-field="dir_is_nominee" type="checkbox"> Is Nominee</label></div>' +
                '<div class="col-sm-4 checkbox"><label><input data-field="dir_is_sg_resident" type="checkbox"> Is SG Resident</label></div>' +
                '<div class="col-sm-4 checkbox"><label><input data-field="dir_is_pep" type="checkbox"> Is PEP</label></div>' +
            '</div>' +
        '</div>';
    var $node = $(html);
    $node.find('[data-field="dir_verified_method"]').val(data.dir_verified_method || 'Video');
    $node.find('[data-field="dir_nominee_type"]').val(data.dir_nominee_type || 'individual');
    $node.find('[data-field="dir_is_nominee"]').prop('checked', !!data.dir_is_nominee);
    $node.find('[data-field="dir_is_sg_resident"]').prop('checked', !!data.dir_is_sg_resident);
    $node.find('[data-field="dir_is_pep"]').prop('checked', !!data.dir_is_pep);
    $('#directorList').append($node);
}

function escAttr(value) {
    return String(value || '')
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

function collectFormData() {
    var questionnaire = {
        company_name_1: $('[name="company_name_1"]').val(),
        company_name_2: $('[name="company_name_2"]').val(),
        company_name_3: $('[name="company_name_3"]').val(),
        principal_activities: $('[name="principal_activities"]').val(),
        ssic_code: $('[name="ssic_code"]').val(),
        assets: $('[name="assets"]').val(),
        source_of_funds: $('[name="source_of_funds"]').val(),
        group_name: $('[name="group_name"]').val(),
        group_website: $('[name="group_website"]').val(),
        share_class: $('[name="share_class"]').val(),
        total_shares: $('[name="total_shares"]').val(),
        price_per_share: $('[name="price_per_share"]').val(),
        paid_up_amount: $('[name="paid_up_amount"]').val(),
        currency: $('[name="currency"]').val(),
        registered_office_mode: $('[name="registered_office_mode"]:checked').val(),
        custom_address: $('[name="custom_address"]').val(),
        base_currency: $('[name="base_currency"]').val(),
        fye: $('[name="fye"]').val(),
        auditors: $('[name="auditors"]').val(),
        tax_agent: $('[name="tax_agent"]').val(),
        bank_name: $('[name="bank_name"]').val(),
        bank_currency: $('[name="bank_currency"]').val(),
        signatories: $('[name="signatories"]').val(),
        operation_mode: $('[name="operation_mode"]').val(),
        mailing_address: $('[name="mailing_address"]').val(),
        contact_name: $('[name="contact_name"]').val(),
        contact_email: $('[name="contact_email"]').val(),
        contact_phone: $('[name="contact_phone"]').val(),
        signatory_name: $('[name="signatory_name"]').val(),
        declaration_date: $('[name="declaration_date"]').val(),
        is_high_risk: $('[name="is_high_risk"]').is(':checked')
    };

    var ubo = [];
    $('[data-ubo-item]').each(function() {
        var $item = $(this);
        ubo.push({
            ubo_name: $item.find('[data-field="ubo_name"]').val(),
            ubo_address: $item.find('[data-field="ubo_address"]').val(),
            ubo_id_type: $item.find('[data-field="ubo_id_type"]').val(),
            ubo_id_number: $item.find('[data-field="ubo_id_number"]').val(),
            ubo_email: $item.find('[data-field="ubo_email"]').val(),
            ubo_mobile: $item.find('[data-field="ubo_mobile"]').val(),
            ubo_is_pep: $item.find('[data-field="ubo_is_pep"]').is(':checked'),
            ubo_pep_period: $item.find('[data-field="ubo_pep_period"]').val(),
            ubo_verified_method: $item.find('[data-field="ubo_verified_method"]').val(),
            ubo_is_natural_person: $item.find('[data-field="ubo_is_natural_person"]').is(':checked')
        });
    });

    var shareholders = [];
    $('[data-shareholder-item]').each(function() {
        var $item = $(this);
        shareholders.push({
            sh_name: $item.find('[data-field="sh_name"]').val(),
            sh_shares: $item.find('[data-field="sh_shares"]').val(),
            sh_price_per_share: $item.find('[data-field="sh_price_per_share"]').val(),
            sh_address: $item.find('[data-field="sh_address"]').val(),
            sh_id_number: $item.find('[data-field="sh_id_number"]').val(),
            sh_nationality: $item.find('[data-field="sh_nationality"]').val(),
            sh_email: $item.find('[data-field="sh_email"]').val(),
            sh_mobile: $item.find('[data-field="sh_mobile"]').val(),
            sh_is_controller: $item.find('[data-field="sh_is_controller"]').is(':checked'),
            sh_is_pep: $item.find('[data-field="sh_is_pep"]').is(':checked'),
            sh_is_company: $item.find('[data-field="sh_is_company"]').is(':checked'),
            sh_verified_method: $item.find('[data-field="sh_verified_method"]').val()
        });
    });

    var directors = [];
    $('[data-director-item]').each(function() {
        var $item = $(this);
        directors.push({
            dir_name: $item.find('[data-field="dir_name"]').val(),
            dir_id_number: $item.find('[data-field="dir_id_number"]').val(),
            dir_address: $item.find('[data-field="dir_address"]').val(),
            dir_phone: $item.find('[data-field="dir_phone"]').val(),
            dir_email: $item.find('[data-field="dir_email"]').val(),
            dir_dob: $item.find('[data-field="dir_dob"]').val(),
            dir_nationality: $item.find('[data-field="dir_nationality"]').val(),
            dir_tax_residence: $item.find('[data-field="dir_tax_residence"]').val(),
            dir_domicile: $item.find('[data-field="dir_domicile"]').val(),
            dir_is_nominee: $item.find('[data-field="dir_is_nominee"]').is(':checked'),
            dir_nominee_type: $item.find('[data-field="dir_nominee_type"]').val(),
            dir_is_sg_resident: $item.find('[data-field="dir_is_sg_resident"]').is(':checked'),
            dir_is_pep: $item.find('[data-field="dir_is_pep"]').is(':checked'),
            dir_verified_method: $item.find('[data-field="dir_verified_method"]').val()
        });
    });

    regData.questionnaire = questionnaire;
    regData.ubo = ubo;
    regData.shareholders = shareholders;
    regData.directors = directors;

    regData.acra = $.extend({}, regData.acra, {
        acra_submit: $('[name="acra_submit"]').is(':checked'),
        acra_fee: $('[name="acra_fee"]').is(':checked'),
        acra_cert: $('[name="acra_cert"]').is(':checked'),
        uen: $('[name="uen"]').val(),
        incorporation_date: $('[name="incorporation_date"]').val()
    });

    return regData;
}

function buildPreDocList() {
    collectFormData();

    var directorNames = regData.directors.map(function(d) { return d.dir_name || 'Unnamed Director'; });
    var hasCompanyShareholder = regData.shareholders.some(function(s) { return !!s.sh_is_company; });
    var highRisk = !!regData.questionnaire.is_high_risk;
    var hasNomineeIndividual = regData.directors.some(function(d) { return d.dir_is_nominee && d.dir_nominee_type !== 'corporate'; });
    var hasNomineeCorporate = regData.directors.some(function(d) { return d.dir_is_nominee && d.dir_nominee_type === 'corporate'; });
    var naturalCount = regData.ubo.filter(function(u) { return u.ubo_is_natural_person; }).length;
    var companyCount = regData.ubo.length - naturalCount;
    var partLabel = companyCount > 0 && naturalCount > 0 ? 'Part 1 + Part 2 (Mixed Controllers)' : (companyCount > 0 ? 'Part 2 - Company' : 'Part 1 - Natural Person');

    var docs = [
        { id: 'doc1', label: "#1 Subscriber's Consent", required: true, detail: 'Always required for incorporation.' },
        { id: 'doc2', label: '#2 Form 45 x ' + (directorNames.length || 1), required: true, detail: directorNames.length ? ('Directors: ' + directorNames.join(', ')) : 'One form per director.' },
        { id: 'doc3', label: '#3 Secretary Consent (YANG YUJIE)', required: true, detail: 'Default appointed secretary.' },
        { id: 'doc4', label: '#4 Notice of Registered Office', required: true, detail: 'Uses agent/custom office data.' },
        { id: 'doc5', label: '#5 Registrable Controller Notice', required: true, detail: partLabel },
        { id: 'doc6', label: '#6 Register of Nominee Shareholders', required: true, detail: 'Generated as statutory register.' },
        { id: 'doc7', label: '#7 Register of Nominee Directors', required: true, detail: 'Generated as statutory register.' },
        { id: 'doc10', label: '#10 DPO Form', required: true, detail: 'Always required.' }
    ];

    if (hasNomineeIndividual) {
        docs.push({ id: 'doc7_1', label: '#7.1 Nominee Director Agreement - Individual', required: false, detail: 'Triggered by nominee individual director(s).' });
    }
    if (hasNomineeCorporate) {
        docs.push({ id: 'doc7_2', label: '#7.2 Nominee Director Agreement - Corporate', required: false, detail: 'Triggered by nominee corporate director(s).' });
    }
    if (hasCompanyShareholder) {
        docs.push({ id: 'doc8', label: '#8 Corporate Shareholder Board Resolution', required: false, detail: 'Triggered by corporate shareholder.' });
    }
    if (highRisk) {
        docs.push({ id: 'doc9', label: '#9 Self-Declaration Letter', required: false, detail: 'Triggered by high-risk KYC profile.' });
    }

    regData.selectedPreDocs = docs.filter(function(d) { return d.required; }).map(function(d) { return d.id; });
    return docs;
}

function buildPostDocList() {
    collectFormData();
    var uenValue = regData.acra && regData.acra.uen ? regData.acra.uen : 'Pending UEN';
    var docs = [
        { id: 'doc11', label: "#11 Director's Resolutions in Writing", required: true, detail: 'Includes UEN: ' + uenValue },
        { id: 'doc12', label: '#12 Filled Questionnaire (archive)', required: true, detail: 'Archive snapshot of Step 1 data.' },
        { id: 'doc13', label: '#13 New Client Acceptance Form', required: true, detail: 'Onboarding acceptance package.' }
    ];
    regData.selectedPostDocs = docs.map(function(d) { return d.id; });
    return docs;
}

function renderDocChecklist(target, docs, stage) {
    var html = docs.map(function(doc) {
        var checked = doc.required ? 'checked' : '';
        var badge = doc.required ? 'required' : 'conditional';
        var badgeLabel = doc.required ? 'Required' : 'Conditional';
        return '' +
            '<div class="nr-doc-card">' +
                '<label style="margin:0;padding-top:6px;"><input type="checkbox" class="nr-doc-check" data-stage="' + stage + '" data-doc-id="' + doc.id + '" ' + checked + '></label>' +
                '<span class="nr-doc-icon"><i class="fa fa-file-text-o"></i></span>' +
                '<div class="nr-doc-main">' +
                    '<p class="nr-doc-name">' + doc.label + '</p>' +
                    '<div class="nr-doc-detail">' + doc.detail + '</div>' +
                '</div>' +
                '<span class="nr-badge ' + badge + '">' + badgeLabel + '</span>' +
            '</div>';
    }).join('');
    $(target).html(html);
}

function updateSelectedDocs(stage) {
    var ids = [];
    $('.nr-doc-check[data-stage="' + stage + '"]:checked').each(function() {
        ids.push($(this).data('doc-id'));
    });
    if (stage === 'pre') {
        regData.selectedPreDocs = ids;
    } else {
        regData.selectedPostDocs = ids;
    }
}

function renderOutput(stage, docs, rawText) {
    var target = stage === 'pre' ? '#preDocOutput' : '#postDocOutput';
    if (!docs.length) {
        $(target).html('<div class="nr-output-empty">No documents selected.</div>');
        return;
    }

    var chunks = String(rawText || '').split(/\n\s*---\s*\n/g);
    var sections = docs.map(function(id, idx) {
        var content = chunks[idx] || rawText || 'No content returned for this section.';
        return '' +
            '<div class="nr-doc-output">' +
                '<div class="nr-doc-output-head">' +
                    '<p class="nr-doc-output-title">' + id + '</p>' +
                    '<div class="nr-inline-actions">' +
                        '<button type="button" class="btn btn-default btn-xs" data-copy-doc="#docBody' + stage + idx + '"><i class="fa fa-copy"></i> Copy</button>' +
                        '<button type="button" class="btn btn-default btn-xs" data-print-doc="#docBody' + stage + idx + '"><i class="fa fa-print"></i> Print</button>' +
                    '</div>' +
                '</div>' +
                '<div class="nr-doc-output-body" id="docBody' + stage + idx + '">' +
                    escapeHtml(content) +
                '</div>' +
            '</div>';
    }).join('');

    $(target).html(sections);
}

function escapeHtml(str) {
    return String(str || '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

function setProgress(stage, percent, label) {
    var p = Math.max(0, Math.min(100, percent));
    var bar = stage === 'pre' ? '#preProgressBar' : '#postProgressBar';
    var text = stage === 'pre' ? '#preProgressLabel' : '#postProgressLabel';
    $(bar).css('width', p + '%').text(Math.round(p) + '%');
    $(text).text(label || ('Generation progress: ' + Math.round(p) + '%'));
}

function generateDocs(stage) {
    collectFormData();

    var docIds = stage === 'pre' ? regData.selectedPreDocs : regData.selectedPostDocs;
    if (!docIds || !docIds.length) {
        alert('Please select at least one document first.');
        return;
    }

    if (stage === 'post' && !(regData.acra && regData.acra.uen)) {
        alert('UEN is required before generating post-incorporation documents.');
        goToStep(3);
        return;
    }

    setProgress(stage, 8, 'Building AI prompt...');
    var stageLabel = stage === 'pre' ? 'Pre-Incorporation Documents' : 'Post-Incorporation Documents';

    var prompt = [
        'You are a Singapore corporate secretarial drafting assistant.',
        'Generate the following ' + stageLabel + ' based on the questionnaire and filing data.',
        'For each document, use clear heading with the document number and name.',
        'Return all requested documents in plain text, separated by "---" lines.',
        'Use Singapore legal/corporate formatting where relevant.',
        '',
        'Requested document IDs:',
        JSON.stringify(docIds),
        '',
        'Registration Data JSON:',
        JSON.stringify(regData, null, 2)
    ].join('\n');

    setProgress(stage, 25, 'Calling AI generation endpoint...');
    $.ajax({
        url: BASE_URL + 'ai/chat',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            message: prompt,
            source: 'assistant'
        })
    }).done(function(resp) {
        setProgress(stage, 82, 'Parsing AI response...');
        var text;
        if (typeof resp === 'string') {
            text = resp;
        } else if (resp && typeof resp.reply === 'string') {
            text = resp.reply;
        } else if (resp && typeof resp.response === 'string') {
            text = resp.response;
        } else if (resp && typeof resp.message === 'string') {
            text = resp.message;
        } else {
            text = JSON.stringify(resp, null, 2);
        }

        if (stage === 'pre') {
            regData.generatedPreDocs = docIds.slice();
        } else {
            regData.generatedPostDocs = docIds.slice();
        }

        renderOutput(stage, docIds, text || 'No content returned.');
        setProgress(stage, 100, 'Generation completed.');
    }).fail(function(xhr) {
        var errorMessage = 'AI generation failed.';
        if (xhr && xhr.responseText) {
            errorMessage += ' ' + xhr.responseText;
        }
        setProgress(stage, 0, 'Generation failed.');
        alert(errorMessage);
    });
}

function validateStep1() {
    collectFormData();
    if (!regData.questionnaire.contact_name || !regData.questionnaire.contact_email || !regData.questionnaire.contact_phone) {
        alert('Please complete all required key contact fields in Section 12.');
        return false;
    }

    if (!regData.directors.length) {
        alert('Please add at least one director in Section 9.');
        return false;
    }

    var hasResidentDirector = regData.directors.some(function(d) { return !!d.dir_is_sg_resident; });
    if (!hasResidentDirector) {
        alert('At least one director must be marked as Singapore resident.');
        return false;
    }
    return true;
}

function goToStep(stepNum) {
    var n = Number(stepNum);
    if (n < 1 || n > 4) {
        return;
    }

    if (n >= 2) {
        collectFormData();
    }

    if (n === 2) {
        var preDocs = buildPreDocList();
        renderDocChecklist('#preDocChecklist', preDocs, 'pre');
    }

    if (n === 4) {
        var postDocs = buildPostDocList();
        renderDocChecklist('#postDocChecklist', postDocs, 'post');
    }

    $('.nr-step-pane').removeClass('active');
    $('.nr-step-pane[data-pane="' + n + '"]').addClass('active');

    $('.nr-step').each(function() {
        var stepValue = Number($(this).data('step'));
        $(this).toggleClass('active', stepValue === n);
        $(this).toggleClass('done', stepValue < n);
    });

    $('#nrStepTitle').text(STEP_META[n].title);
    $('#nrStepSubtitle').text(STEP_META[n].subtitle);
}

document.addEventListener('DOMContentLoaded', function() {
    addUbo();
    addShareholder();
    addDirector();

    $('#addUboBtn').on('click', function() { addUbo(); });
    $('#addShareholderBtn').on('click', function() { addShareholder(); });
    $('#addDirectorBtn').on('click', function() { addDirector(); });

    $('#uboList').on('click', '[data-remove-ubo]', function() {
        $(this).closest('[data-ubo-item]').remove();
    });
    $('#shareholderList').on('click', '[data-remove-shareholder]', function() {
        $(this).closest('[data-shareholder-item]').remove();
    });
    $('#directorList').on('click', '[data-remove-director]', function() {
        $(this).closest('[data-director-item]').remove();
    });

    $('#uboList').on('change', '[data-field="ubo_is_pep"]', function() {
        var checked = $(this).is(':checked');
        var $card = $(this).closest('[data-ubo-item]');
        $card.find('.ubo-pep-wrap').toggleClass('nr-hidden', !checked);
    });

    $('[name="registered_office_mode"]').on('change', function() {
        var isCustom = $('[name="registered_office_mode"]:checked').val() === 'custom';
        $('[name="custom_address"]').prop('disabled', !isCustom);
    });

    $('#toStep2Btn').on('click', function() {
        if (!validateStep1()) {
            return;
        }
        goToStep(2);
    });

    $(document).on('click', '[data-goto]', function() {
        goToStep(Number($(this).data('goto')));
    });

    $(document).on('change', '.nr-doc-check', function() {
        updateSelectedDocs($(this).data('stage'));
    });

    $('#generatePreDocsBtn').on('click', function() {
        updateSelectedDocs('pre');
        generateDocs('pre');
    });

    $('#saveAcraBtn').on('click', function() {
        collectFormData();
        if (!regData.acra.uen || !regData.acra.incorporation_date) {
            alert('Please provide both UEN and incorporation date.');
            return;
        }
        goToStep(4);
    });

    $('#generatePostDocsBtn').on('click', function() {
        updateSelectedDocs('post');
        generateDocs('post');
    });

    $('#completeRegistrationBtn').on('click', function() {
        collectFormData();
        if (!regData.generatedPostDocs.length) {
            alert('Please generate post-incorporation documents before completion.');
            return;
        }
        alert('Registration workflow completed. You can now archive this record.');
    });

    $(document).on('click', '[data-copy-doc]', function() {
        var selector = $(this).data('copy-doc');
        var txt = $(selector).text();
        if (!txt) {
            return;
        }
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(txt);
        } else {
            var $tmp = $('<textarea>').val(txt).appendTo('body').select();
            document.execCommand('copy');
            $tmp.remove();
        }
    });

    $(document).on('click', '[data-print-doc]', function() {
        var selector = $(this).data('print-doc');
        var txt = $(selector).text();
        var printWin = window.open('', '_blank');
        if (!printWin) {
            return;
        }
        printWin.document.write('<pre style="font-family: Arial, sans-serif; white-space: pre-wrap;">' + escapeHtml(txt) + '</pre>');
        printWin.document.close();
        printWin.focus();
        printWin.print();
    });

    $('.nr-step').on('click', function() {
        var step = Number($(this).data('step'));
        if (step === 2 && !validateStep1()) {
            return;
        }
        if (step === 4) {
            collectFormData();
            if (!(regData.acra && regData.acra.uen)) {
                alert('Please complete Step 3 first.');
                return;
            }
        }
        goToStep(step);
    });
});
</script>
