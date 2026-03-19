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

.nr-spinner {
    width: 36px;
    height: 36px;
    border: 3px solid var(--cf-border);
    border-top-color: var(--cf-accent);
    border-radius: 50%;
    animation: nrSpin 0.8s linear infinite;
}

.nr-spinner-wrap {
    padding: 28px 18px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.nr-change-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px;
}

.nr-update-table {
    width: 100%;
    border-collapse: collapse;
}

.nr-update-table th,
.nr-update-table td {
    border: 1px solid var(--cf-border);
    padding: 8px;
    vertical-align: top;
}

.nr-update-table th {
    background: #fcfdff;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.02em;
    color: var(--cf-text-secondary);
}

.nr-file-list {
    margin: 0;
    padding-left: 18px;
}

.nr-file-list li {
    margin-bottom: 6px;
    font-size: 13px;
}

.nr-mt-10 {
    margin-top: 10px;
}

.nr-mt-12 {
    margin-top: 12px;
}

.nr-mt-16 {
    margin-top: 16px;
}

.nr-progress-bar-init {
    width: 0%;
}

.nr-declaration {
    border: 1px solid var(--cf-border);
    border-radius: 10px;
    padding: 12px;
    background: #fcfdff;
    font-size: 13px;
    line-height: 1.6;
}

@keyframes nrSpin {
    to { transform: rotate(360deg); }
}

@media (max-width: 992px) {
    .nr-doc-grid,
    .nr-acra-grid,
    .nr-change-grid {
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
        <a class="nr-back-link" href="<?= base_url('workspace') ?>"><i class="fa fa-arrow-left"></i> Back to Workspace</a>
    </div>

    <h1 class="nr-title">Company Transfer-In</h1>

    <div class="nr-stepper">
        <div class="nr-step active" data-step="1"><span class="nr-step-num">1</span> New Client Acceptance Form</div>
        <div class="nr-step-line"></div>
        <div class="nr-step" data-step="2"><span class="nr-step-num">2</span> Select Change Types</div>
        <div class="nr-step-line"></div>
        <div class="nr-step" data-step="3"><span class="nr-step-num">3</span> Generate Documents</div>
        <div class="nr-step-line"></div>
        <div class="nr-step" data-step="4"><span class="nr-step-num">4</span> Output</div>
    </div>

    <div class="nr-card">
        <div class="nr-card-head">
            <h3 class="nr-card-title" id="ctStepTitle">Step 1: New Client Acceptance Form</h3>
            <p class="nr-card-subtitle" id="ctStepSubtitle">Complete all questionnaire sections before selecting transfer-in change types.</p>
        </div>

        <div class="nr-step-pane active" data-pane="1">
            <div class="nr-accordion" id="ctAccordion">
                <div class="nr-section open" data-section="1">
                    <button type="button" class="nr-section-head" onclick="ctToggleSection(this)">
                        <span>1. Company Info &amp; Bizfile Check</span>
                        <span class="nr-chevron"><i class="fa fa-chevron-down"></i></span>
                    </button>
                    <div class="nr-section-body">
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>Company Name</label>
                                <input class="form-control" name="company_name" type="text">
                            </div>
                            <div class="col-sm-3 form-group">
                                <label>UEN</label>
                                <input class="form-control" name="company_uen" type="text">
                            </div>
                            <div class="col-sm-3 form-group">
                                <label>Bizfile Date</label>
                                <input class="form-control" name="bizfile_date" type="date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Select Existing Company Record</label>
                            <select class="form-control" id="ctCompanySelect" name="company_id">
                                <option value="">-- Select a company --</option>
                                <?php foreach ($companies as $c): ?>
                                <option value="<?= $c->id ?>" data-uen="<?= htmlspecialchars($c->registration_number ?? '') ?>"><?= htmlspecialchars($c->company_name) ?> (<?= htmlspecialchars($c->registration_number ?? '') ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Bizfile information is accurate? / 商业档案信息正确</label>
                            <div class="radio"><label><input type="radio" name="bizfile_is_accurate" value="yes" checked> YES</label></div>
                            <div class="radio"><label><input type="radio" name="bizfile_is_accurate" value="no"> NO</label></div>
                        </div>
                        <div id="ctBizfileUpdateWrap" class="nr-hidden">
                            <p class="nr-inline-help">Add each item that should be updated in Bizfile.</p>
                            <table class="nr-update-table">
                                <thead>
                                    <tr>
                                        <th>Information in business profile need to be updated</th>
                                        <th>Updated information</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="ctBizfileUpdates"></tbody>
                            </table>
                            <div class="nr-inline-actions nr-mt-10">
                                <button type="button" class="btn btn-default btn-sm" id="ctAddBizfileUpdateBtn"><i class="fa fa-plus"></i> Add Update Item</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="nr-section" data-section="2">
                    <button type="button" class="nr-section-head" onclick="ctToggleSection(this)">
                        <span>2. Document Checklist</span>
                        <span class="nr-chevron"><i class="fa fa-chevron-down"></i></span>
                    </button>
                    <div class="nr-section-body">
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>Shareholder's ID or Passport provided?</label>
                                <div class="radio"><label><input type="radio" name="docs_shareholder_id" value="yes"> YES</label></div>
                                <div class="radio"><label><input type="radio" name="docs_shareholder_id" value="no" checked> NO</label></div>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Shareholder address proof (&lt; 3 months) provided?</label>
                                <div class="radio"><label><input type="radio" name="docs_shareholder_address_proof" value="yes"> YES</label></div>
                                <div class="radio"><label><input type="radio" name="docs_shareholder_address_proof" value="no" checked> NO</label></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>Director's ID or Passport provided?</label>
                                <div class="radio"><label><input type="radio" name="docs_director_id" value="yes"> YES</label></div>
                                <div class="radio"><label><input type="radio" name="docs_director_id" value="no" checked> NO</label></div>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Director address proof (&lt; 3 months) provided?</label>
                                <div class="radio"><label><input type="radio" name="docs_director_address_proof" value="yes"> YES</label></div>
                                <div class="radio"><label><input type="radio" name="docs_director_address_proof" value="no" checked> NO</label></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>Has company registered DPO?</label>
                                <div class="radio"><label><input type="radio" name="docs_dpo_registered" value="yes"> YES</label></div>
                                <div class="radio"><label><input type="radio" name="docs_dpo_registered" value="no" checked> NO</label></div>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Financial Year End</label>
                                <input class="form-control" name="docs_fye" type="text" placeholder="e.g. 31 December">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="nr-section" data-section="3">
                    <button type="button" class="nr-section-head" onclick="ctToggleSection(this)">
                        <span>3. Primary Contact (第一联系人)</span>
                        <span class="nr-chevron"><i class="fa fa-chevron-down"></i></span>
                    </button>
                    <div class="nr-section-body">
                        <div class="row">
                            <div class="col-sm-6 form-group"><label>Full Name</label><input class="form-control" name="primary_name" type="text"></div>
                            <div class="col-sm-6 form-group"><label>Phone</label><input class="form-control" name="primary_phone" type="text"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group"><label>Email</label><input class="form-control" name="primary_email" type="email"></div>
                            <div class="col-sm-6 form-group"><label>Date of Birth</label><input class="form-control" name="primary_dob" type="date"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group"><label>Nationality</label><input class="form-control" name="primary_nationality" type="text"></div>
                            <div class="col-sm-3 form-group"><label>ID Type</label><input class="form-control" name="primary_id_type" type="text" placeholder="Passport or IC"></div>
                            <div class="col-sm-3 form-group"><label>ID Number</label><input class="form-control" name="primary_id_number" type="text"></div>
                        </div>
                        <div class="form-group"><label>Residential and Contact Address</label><textarea class="form-control" name="primary_address" rows="2"></textarea></div>
                    </div>
                </div>

                <div class="nr-section" data-section="4">
                    <button type="button" class="nr-section-head" onclick="ctToggleSection(this)">
                        <span>4. Emergency Contact (紧急联系人)</span>
                        <span class="nr-chevron"><i class="fa fa-chevron-down"></i></span>
                    </button>
                    <div class="nr-section-body">
                        <div class="row">
                            <div class="col-sm-6 form-group"><label>Full Name</label><input class="form-control" name="emergency_name" type="text"></div>
                            <div class="col-sm-6 form-group"><label>Phone</label><input class="form-control" name="emergency_phone" type="text"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group"><label>Email</label><input class="form-control" name="emergency_email" type="email"></div>
                            <div class="col-sm-6 form-group"><label>Date of Birth</label><input class="form-control" name="emergency_dob" type="date"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group"><label>Nationality</label><input class="form-control" name="emergency_nationality" type="text"></div>
                            <div class="col-sm-6 form-group"><label>ID Number</label><input class="form-control" name="emergency_id_number" type="text"></div>
                        </div>
                        <div class="form-group"><label>Residential and Contact Address</label><textarea class="form-control" name="emergency_address" rows="2"></textarea></div>
                    </div>
                </div>

                <div class="nr-section" data-section="5">
                    <button type="button" class="nr-section-head" onclick="ctToggleSection(this)">
                        <span>5. UBO / Registrable Controller (最终受益人/实控人)</span>
                        <span class="nr-chevron"><i class="fa fa-chevron-down"></i></span>
                    </button>
                    <div class="nr-section-body">
                        <p class="nr-inline-help">Add one or more UBO/controller records.</p>
                        <div id="ctUboList" class="nr-repeat-wrap"></div>
                        <button type="button" class="btn btn-default btn-sm" id="ctAddUboBtn"><i class="fa fa-plus"></i> Add UBO / Controller</button>
                    </div>
                </div>

                <div class="nr-section" data-section="6">
                    <button type="button" class="nr-section-head" onclick="ctToggleSection(this)">
                        <span>6. Declaration</span>
                        <span class="nr-chevron"><i class="fa fa-chevron-down"></i></span>
                    </button>
                    <div class="nr-section-body">
                        <div class="nr-declaration">
                            I/We declare that all information provided is true, accurate, and complete, and that I/we are persons of integrity and will settle all monies payable to Yu Young Consulting. I/We further declare that the source of property is legitimate, there is no money laundering, drug trafficking, or terrorism concern, the company remains solvent after any contribution, and all contributed assets are free from lien or encumbrance and given voluntarily.<br>
                            本人/我们声明所提供的信息真实、准确、完整，且本人/我们为诚信人士并将按时结清应付给杨语洋咨询的款项。本人/我们进一步声明财产来源合法，不涉及洗钱、毒品交易或恐怖主义，出资后公司仍具备偿付能力，且所投入资产不存在任何抵押、质押或权利负担，均为自愿投入。
                        </div>
                        <div class="row nr-mt-12">
                            <div class="col-sm-4 form-group"><label>Signature Name</label><input class="form-control" name="declaration_name" type="text"></div>
                            <div class="col-sm-4 form-group"><label>Designation (职位)</label><input class="form-control" name="declaration_designation" type="text"></div>
                            <div class="col-sm-4 form-group"><label>Date</label><input class="form-control" name="declaration_date" type="date"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="nr-actions">
                <span class="help-block">Complete all sections in Step 1 before moving forward.</span>
                <button type="button" class="btn btn-primary" id="ctToStep2Btn">Next: Select Change Types <i class="fa fa-arrow-right"></i></button>
            </div>
        </div>

        <div class="nr-step-pane" data-pane="2">
            <div class="nr-accordion">
                <div class="nr-section open" data-section="change-types">
                    <button type="button" class="nr-section-head" onclick="ctToggleSection(this)">
                        <span>Change Types (变更项目)</span>
                        <span class="nr-chevron"><i class="fa fa-chevron-down"></i></span>
                    </button>
                    <div class="nr-section-body">
                        <p class="nr-inline-help">Standard package is pre-selected for registered office and secretary changes.</p>
                        <div class="nr-change-grid">
                            <div>
                                <h5 class="nr-repeat-title">Standard Package</h5>
                                <div class="nr-checklist">
                                    <div class="nr-check-item"><label><input type="checkbox" class="nr-change-check" value="change_registered_office" checked> Change Registered Office <span class="nr-badge required">Board Resolution</span></label></div>
                                    <div class="nr-check-item"><label><input type="checkbox" class="nr-change-check" value="change_secretary" checked> Change Secretary <span class="nr-badge required">Board Resolution</span></label></div>
                                    <div class="nr-check-item"><label><input type="checkbox" class="nr-change-check" value="change_director"> Change Director <span class="nr-badge required">Board Resolution</span></label></div>
                                </div>
                            </div>
                            <div>
                                <h5 class="nr-repeat-title">Additional Changes</h5>
                                <div class="nr-checklist">
                                    <div class="nr-check-item"><label><input type="checkbox" class="nr-change-check" value="change_company_name"> Change Company Name <span class="nr-badge conditional">Special Resolution</span></label></div>
                                    <div class="nr-check-item"><label><input type="checkbox" class="nr-change-check" value="change_principal_activities"> Change Principal Activities <span class="nr-badge required">Board Resolution</span></label></div>
                                    <div class="nr-check-item"><label><input type="checkbox" class="nr-change-check" value="change_registered_controller"> Change Registered Controller <span class="nr-badge required">Board Resolution</span></label></div>
                                    <div class="nr-check-item"><label><input type="checkbox" class="nr-change-check" value="change_accounting_period"> Change Accounting Period <span class="nr-badge required">Board Resolution</span></label></div>
                                    <div class="nr-check-item"><label><input type="checkbox" class="nr-change-check" value="change_currency"> Change Currency <span class="nr-badge required">Board Resolution</span></label></div>
                                    <div class="nr-check-item"><label><input type="checkbox" class="nr-change-check" value="update_constitution"> Update Constitution <span class="nr-badge conditional">Special Resolution</span></label></div>
                                    <div class="nr-check-item"><label><input type="checkbox" class="nr-change-check" value="particulars_update"> Particulars Update <span class="nr-badge conditional">No Resolution</span></label></div>
                                </div>
                            </div>
                            <div>
                                <h5 class="nr-repeat-title">Capital &amp; Share Changes</h5>
                                <div class="nr-checklist">
                                    <div class="nr-check-item"><label><input type="checkbox" class="nr-change-check" value="increase_share_capital"> Increase Share Capital <span class="nr-badge required">Board Resolution</span></label></div>
                                    <div class="nr-check-item"><label><input type="checkbox" class="nr-change-check" value="reduce_share_capital"> Reduce Share Capital <span class="nr-badge conditional">Special Resolution</span></label></div>
                                    <div class="nr-check-item"><label><input type="checkbox" class="nr-change-check" value="transfer_share"> Transfer Share <span class="nr-badge required">Board Resolution</span></label></div>
                                    <div class="nr-check-item"><label><input type="checkbox" class="nr-change-check" value="interim_dividend"> Interim Dividend <span class="nr-badge required">Board Resolution</span></label></div>
                                    <div class="nr-check-item"><label><input type="checkbox" class="nr-change-check" value="update_paid_up_capital"> Update Paid-up Capital <span class="nr-badge required">Board Resolution</span></label></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row nr-mt-16">
                <div class="col-sm-4 form-group"><label>Effective Date</label><input class="form-control" name="change_effective_date" type="date"></div>
                <div class="col-sm-4 form-group"><label>New Registered Office</label><input class="form-control" name="change_new_address" type="text" value="51 Goldhill Plaza #20-07 Singapore 308900"></div>
                <div class="col-sm-4 form-group"><label>New Secretary Name</label><input class="form-control" name="change_new_secretary" type="text" value="YANG YUJIE"></div>
            </div>

            <div id="ctDirectorFields" class="nr-repeat-card nr-hidden">
                <div class="nr-repeat-head"><h5 class="nr-repeat-title">Director Change Details</h5></div>
                <div class="row">
                    <div class="col-sm-6 form-group"><label>New Director Name</label><input class="form-control" name="director_new_name" type="text"></div>
                    <div class="col-sm-6 form-group"><label>New Director ID / Passport</label><input class="form-control" name="director_new_id" type="text"></div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group"><label>New Director Nationality</label><input class="form-control" name="director_new_nationality" type="text"></div>
                    <div class="col-sm-6 form-group"><label>New Director DOB</label><input class="form-control" name="director_new_dob" type="date"></div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group"><label>New Director Address</label><input class="form-control" name="director_new_address" type="text"></div>
                    <div class="col-sm-6 form-group"><label>New Director Email</label><input class="form-control" name="director_new_email" type="email"></div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group"><label>New Director Phone</label><input class="form-control" name="director_new_phone" type="text"></div>
                    <div class="col-sm-6 form-group"><label>Outgoing Director Name (if any)</label><input class="form-control" name="director_old_name" type="text"></div>
                </div>
                <div class="checkbox"><label><input type="checkbox" name="director_is_nominee"> Is nominee director</label></div>
            </div>

            <div class="form-group nr-mt-16">
                <label>Additional Instructions</label>
                <textarea class="form-control" name="change_additional_instructions" rows="3" placeholder="Any additional details, drafting notes, or filing instructions."></textarea>
            </div>

            <div class="nr-actions">
                <button type="button" class="btn btn-default" data-goto="1"><i class="fa fa-arrow-left"></i> Back to Acceptance Form</button>
                <button type="button" class="btn btn-primary" id="ctToStep3Btn">Next: Generate Documents <i class="fa fa-arrow-right"></i></button>
            </div>
        </div>

        <div class="nr-step-pane" data-pane="3">
            <div class="nr-generation">
                <div class="nr-progress-wrap">
                    <div class="nr-progress-label" id="ctProgressLabel">Generation progress: ready</div>
                    <div class="progress">
                        <div id="ctProgressBar" class="progress-bar progress-bar-striped active nr-progress-bar-init" role="progressbar">0%</div>
                    </div>
                </div>
                <div class="nr-spinner-wrap" id="ctSpinnerWrap">
                    <div class="nr-spinner"></div>
                    <div class="nr-progress-label" id="ctSpinnerText">Preparing transfer-in generation request...</div>
                </div>
            </div>
            <div class="nr-actions">
                <button type="button" class="btn btn-default" data-goto="2"><i class="fa fa-arrow-left"></i> Back to Change Types</button>
                <span class="help-block">Generation starts automatically once you enter this step.</span>
            </div>
        </div>

        <div class="nr-step-pane" data-pane="4">
            <div class="nr-generation">
                <div class="nr-progress-wrap">
                    <div class="nr-progress-label">Generated document package</div>
                </div>
                <div class="nr-output" id="ctOutputPane">
                    <div class="nr-doc-output">
                        <div class="nr-doc-output-head">
                            <p class="nr-doc-output-title">Document List</p>
                            <div class="nr-inline-actions">
                                <button type="button" class="btn btn-default btn-xs" id="ctCopyBtn"><i class="fa fa-copy"></i> Copy</button>
                                <button type="button" class="btn btn-default btn-xs" id="ctPrintBtn"><i class="fa fa-print"></i> Print</button>
                            </div>
                        </div>
                        <div class="nr-doc-output-body" id="ctDocListBody">
                            <div class="nr-output-empty">No generated package yet.</div>
                        </div>
                    </div>
                    <div class="nr-doc-output">
                        <div class="nr-doc-output-head">
                            <p class="nr-doc-output-title">AI Output</p>
                        </div>
                        <div class="nr-doc-output-body" id="ctAiOutputBody">No generated content yet.</div>
                    </div>
                </div>
            </div>
            <div class="nr-actions">
                <button type="button" class="btn btn-default" data-goto="2"><i class="fa fa-arrow-left"></i> Edit Inputs</button>
                <button type="button" class="btn btn-primary" id="ctRegenerateBtn"><i class="fa fa-refresh"></i> Re-generate</button>
            </div>
        </div>
    </div>
</div>

<script>
var ctData = {
    acceptance: {},
    bizfile_updates: [],
    ubo: [],
    changes: {},
    selected_changes: [],
    extra_context: '',
    generated_content: ''
};

var ctStepMeta = {
    1: { title: 'Step 1: New Client Acceptance Form', subtitle: 'Complete all questionnaire sections before selecting transfer-in change types.' },
    2: { title: 'Step 2: Select Change Types', subtitle: 'Choose transfer-in changes and provide required change details.' },
    3: { title: 'Step 3: Generate Documents', subtitle: 'Generating transfer-in package using selected changes and acceptance form data.' },
    4: { title: 'Step 4: Output', subtitle: 'Review generated package, copy/print, and finalize filing set.' }
};

var ctUboIndex = 0;

function ctToggleSection(el) {
    var $section = $(el).closest('.nr-section');
    $section.toggleClass('open');
}

function ctGoStep(stepNum) {
    var n = Number(stepNum);
    if (n < 1 || n > 4) {
        return;
    }

    if (n >= 2) {
        ctCollectData();
    }

    $('.nr-step-pane').removeClass('active');
    $('.nr-step-pane[data-pane="' + n + '"]').addClass('active');

    $('.nr-step').each(function() {
        var value = Number($(this).data('step'));
        $(this).toggleClass('active', value === n);
        $(this).toggleClass('done', value < n);
    });

    $('#ctStepTitle').text(ctStepMeta[n].title);
    $('#ctStepSubtitle').text(ctStepMeta[n].subtitle);

    if (n === 3) {
        ctSetProgress(0, 'Preparing transfer-in generation request...');
        $('#ctSpinnerWrap').show();
        ctGenerateDocuments();
    }
}

function ctEscAttr(value) {
    return String(value || '')
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

function ctEscapeHtml(value) {
    return String(value || '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

function ctAddBizfileUpdate(initial) {
    var data = initial || {};
    var row = '' +
        '<tr data-bizfile-update-item>' +
            '<td><input class="form-control" data-field="field" type="text" value="' + ctEscAttr(data.field || '') + '"></td>' +
            '<td><input class="form-control" data-field="new_value" type="text" value="' + ctEscAttr(data.new_value || '') + '"></td>' +
            '<td><button type="button" class="btn btn-link btn-xs text-danger" data-remove-bizfile-update><i class="fa fa-trash"></i> Remove</button></td>' +
        '</tr>';
    $('#ctBizfileUpdates').append($(row));
}

function ctAddUbo(initial) {
    ctUboIndex += 1;
    var data = initial || {};
    var html = '' +
        '<div class="nr-repeat-card" data-ubo-item data-index="' + ctUboIndex + '">' +
            '<div class="nr-repeat-head">' +
                '<h5 class="nr-repeat-title">UBO / Controller #' + ctUboIndex + '</h5>' +
                '<button type="button" class="btn btn-link btn-xs text-danger" data-remove-ubo><i class="fa fa-trash"></i> Remove</button>' +
            '</div>' +
            '<div class="row">' +
                '<div class="col-sm-6 form-group"><label>Name</label><input class="form-control" data-field="name" type="text" value="' + ctEscAttr(data.name || '') + '"></div>' +
                '<div class="col-sm-6 form-group"><label>Email</label><input class="form-control" data-field="email" type="email" value="' + ctEscAttr(data.email || '') + '"></div>' +
            '</div>' +
            '<div class="form-group"><label>Residential Address</label><input class="form-control" data-field="address" type="text" value="' + ctEscAttr(data.address || '') + '"></div>' +
            '<div class="row">' +
                '<div class="col-sm-4 form-group"><label>ID Number</label><input class="form-control" data-field="id_number" type="text" value="' + ctEscAttr(data.id_number || '') + '"></div>' +
                '<div class="col-sm-4 form-group"><label>Mobile</label><input class="form-control" data-field="mobile" type="text" value="' + ctEscAttr(data.mobile || '') + '"></div>' +
                '<div class="col-sm-4 form-group"><label>Verification Method</label><select class="form-control" data-field="verified_method"><option value="Video">Video</option><option value="In-person">In-person</option></select></div>' +
            '</div>' +
            '<div class="row">' +
                '<div class="col-sm-4 checkbox"><label><input type="checkbox" data-field="is_pep"> Is PEP</label></div>' +
                '<div class="col-sm-8 form-group nr-pep-period nr-hidden"><label>PEP Period</label><input class="form-control" data-field="pep_period" type="text" value="' + ctEscAttr(data.pep_period || '') + '"></div>' +
            '</div>' +
        '</div>';

    var $node = $(html);
    $node.find('[data-field="verified_method"]').val(data.verified_method || 'Video');
    $node.find('[data-field="is_pep"]').prop('checked', !!data.is_pep);
    if (data.is_pep) {
        $node.find('.nr-pep-period').removeClass('nr-hidden');
    }
    $('#ctUboList').append($node);
}

function ctCollectBizfileUpdates() {
    var updates = [];
    $('[data-bizfile-update-item]').each(function() {
        var $row = $(this);
        var item = {
            field: $row.find('[data-field="field"]').val(),
            new_value: $row.find('[data-field="new_value"]').val()
        };
        if (item.field || item.new_value) {
            updates.push(item);
        }
    });
    return updates;
}

function ctCollectUbo() {
    var ubo = [];
    $('[data-ubo-item]').each(function() {
        var $item = $(this);
        ubo.push({
            name: $item.find('[data-field="name"]').val(),
            address: $item.find('[data-field="address"]').val(),
            id_number: $item.find('[data-field="id_number"]').val(),
            email: $item.find('[data-field="email"]').val(),
            mobile: $item.find('[data-field="mobile"]').val(),
            verified_method: $item.find('[data-field="verified_method"]').val(),
            is_pep: $item.find('[data-field="is_pep"]').is(':checked'),
            pep_period: $item.find('[data-field="pep_period"]').val()
        });
    });
    return ubo;
}

function ctCollectSelectedChanges() {
    var selected = [];
    $('.nr-change-check:checked').each(function() {
        selected.push($(this).val());
    });
    return selected;
}

function ctCollectData() {
    var acceptance = {
        company_name: $('[name="company_name"]').val(),
        company_uen: $('[name="company_uen"]').val(),
        bizfile_date: $('[name="bizfile_date"]').val(),
        company_id: $('#ctCompanySelect').val(),
        bizfile_is_accurate: $('[name="bizfile_is_accurate"]:checked').val(),
        docs_shareholder_id: $('[name="docs_shareholder_id"]:checked').val(),
        docs_shareholder_address_proof: $('[name="docs_shareholder_address_proof"]:checked').val(),
        docs_director_id: $('[name="docs_director_id"]:checked').val(),
        docs_director_address_proof: $('[name="docs_director_address_proof"]:checked').val(),
        docs_dpo_registered: $('[name="docs_dpo_registered"]:checked').val(),
        docs_fye: $('[name="docs_fye"]').val(),
        primary_name: $('[name="primary_name"]').val(),
        primary_address: $('[name="primary_address"]').val(),
        primary_phone: $('[name="primary_phone"]').val(),
        primary_email: $('[name="primary_email"]').val(),
        primary_dob: $('[name="primary_dob"]').val(),
        primary_nationality: $('[name="primary_nationality"]').val(),
        primary_id_type: $('[name="primary_id_type"]').val(),
        primary_id_number: $('[name="primary_id_number"]').val(),
        emergency_name: $('[name="emergency_name"]').val(),
        emergency_address: $('[name="emergency_address"]').val(),
        emergency_phone: $('[name="emergency_phone"]').val(),
        emergency_email: $('[name="emergency_email"]').val(),
        emergency_dob: $('[name="emergency_dob"]').val(),
        emergency_nationality: $('[name="emergency_nationality"]').val(),
        emergency_id_number: $('[name="emergency_id_number"]').val(),
        declaration_name: $('[name="declaration_name"]').val(),
        declaration_designation: $('[name="declaration_designation"]').val(),
        declaration_date: $('[name="declaration_date"]').val()
    };

    var changes = {
        effective_date: $('[name="change_effective_date"]').val(),
        new_address: $('[name="change_new_address"]').val(),
        new_secretary: $('[name="change_new_secretary"]').val(),
        director_new_name: $('[name="director_new_name"]').val(),
        director_new_id: $('[name="director_new_id"]').val(),
        director_new_nationality: $('[name="director_new_nationality"]').val(),
        director_new_dob: $('[name="director_new_dob"]').val(),
        director_new_address: $('[name="director_new_address"]').val(),
        director_new_email: $('[name="director_new_email"]').val(),
        director_new_phone: $('[name="director_new_phone"]').val(),
        director_old_name: $('[name="director_old_name"]').val(),
        director_is_nominee: $('[name="director_is_nominee"]').is(':checked') ? 'yes' : 'no',
        additional_instructions: $('[name="change_additional_instructions"]').val()
    };

    ctData.acceptance = acceptance;
    ctData.bizfile_updates = ctCollectBizfileUpdates();
    ctData.ubo = ctCollectUbo();
    ctData.selected_changes = ctCollectSelectedChanges();
    ctData.changes = changes;

    return ctData;
}

function ctValidateStep1() {
    ctCollectData();
    if (!ctData.acceptance.company_id) {
        alert('Please select a company record in Section 1.');
        return false;
    }
    if (!ctData.acceptance.company_name || !ctData.acceptance.company_uen) {
        alert('Please provide Company Name and UEN in Section 1.');
        return false;
    }
    if (!ctData.acceptance.primary_name || !ctData.acceptance.primary_email || !ctData.acceptance.primary_phone) {
        alert('Please complete Primary Contact name, email, and phone in Section 3.');
        return false;
    }
    if (!ctData.ubo.length) {
        alert('Please add at least one UBO / Registrable Controller entry in Section 5.');
        return false;
    }
    return true;
}

function ctBuildExtraContext() {
    ctCollectData();

    var lines = [];
    lines.push('=== NEW CLIENT ACCEPTANCE FORM ===');
    lines.push('Company Name: ' + (ctData.acceptance.company_name || ''));
    lines.push('UEN: ' + (ctData.acceptance.company_uen || ''));
    lines.push('Bizfile Date: ' + (ctData.acceptance.bizfile_date || ''));
    lines.push('Company ID: ' + (ctData.acceptance.company_id || ''));
    lines.push('Bizfile accurate: ' + (ctData.acceptance.bizfile_is_accurate || ''));

    if (ctData.bizfile_updates.length) {
        lines.push('Bizfile updates:');
        ctData.bizfile_updates.forEach(function(item, idx) {
            lines.push('  ' + (idx + 1) + '. Field: ' + (item.field || '') + ' | New value: ' + (item.new_value || ''));
        });
    } else {
        lines.push('Bizfile updates: none');
    }

    lines.push('');
    lines.push('Document checklist:');
    lines.push('  Shareholder ID provided: ' + (ctData.acceptance.docs_shareholder_id || ''));
    lines.push('  Shareholder address proof provided: ' + (ctData.acceptance.docs_shareholder_address_proof || ''));
    lines.push('  Director ID provided: ' + (ctData.acceptance.docs_director_id || ''));
    lines.push('  Director address proof provided: ' + (ctData.acceptance.docs_director_address_proof || ''));
    lines.push('  DPO registered: ' + (ctData.acceptance.docs_dpo_registered || ''));
    lines.push('  Financial year end: ' + (ctData.acceptance.docs_fye || ''));

    lines.push('');
    lines.push('Primary Contact:');
    lines.push('  Name: ' + (ctData.acceptance.primary_name || ''));
    lines.push('  Address: ' + (ctData.acceptance.primary_address || ''));
    lines.push('  Phone: ' + (ctData.acceptance.primary_phone || ''));
    lines.push('  Email: ' + (ctData.acceptance.primary_email || ''));
    lines.push('  DOB: ' + (ctData.acceptance.primary_dob || ''));
    lines.push('  Nationality: ' + (ctData.acceptance.primary_nationality || ''));
    lines.push('  ID Type: ' + (ctData.acceptance.primary_id_type || ''));
    lines.push('  ID Number: ' + (ctData.acceptance.primary_id_number || ''));

    lines.push('');
    lines.push('Emergency Contact:');
    lines.push('  Name: ' + (ctData.acceptance.emergency_name || ''));
    lines.push('  Address: ' + (ctData.acceptance.emergency_address || ''));
    lines.push('  Phone: ' + (ctData.acceptance.emergency_phone || ''));
    lines.push('  Email: ' + (ctData.acceptance.emergency_email || ''));
    lines.push('  DOB: ' + (ctData.acceptance.emergency_dob || ''));
    lines.push('  Nationality: ' + (ctData.acceptance.emergency_nationality || ''));
    lines.push('  ID Number: ' + (ctData.acceptance.emergency_id_number || ''));

    lines.push('');
    lines.push('UBO / Registrable Controller Entries:');
    if (ctData.ubo.length) {
        ctData.ubo.forEach(function(item, idx) {
            lines.push('  Entry ' + (idx + 1) + ':');
            lines.push('    Name: ' + (item.name || ''));
            lines.push('    Address: ' + (item.address || ''));
            lines.push('    ID Number: ' + (item.id_number || ''));
            lines.push('    Email: ' + (item.email || ''));
            lines.push('    Mobile: ' + (item.mobile || ''));
            lines.push('    Verification method: ' + (item.verified_method || ''));
            lines.push('    Is PEP: ' + (item.is_pep ? 'yes' : 'no'));
            lines.push('    PEP period: ' + (item.pep_period || ''));
        });
    } else {
        lines.push('  none');
    }

    lines.push('');
    lines.push('Declaration Signature:');
    lines.push('  Name: ' + (ctData.acceptance.declaration_name || ''));
    lines.push('  Designation: ' + (ctData.acceptance.declaration_designation || ''));
    lines.push('  Date: ' + (ctData.acceptance.declaration_date || ''));

    lines.push('');
    lines.push('=== SELECTED CHANGES ===');
    lines.push('Selected changes: ' + (ctData.selected_changes.join(', ') || 'none'));
    lines.push('Effective date: ' + (ctData.changes.effective_date || ''));
    lines.push('New address: ' + (ctData.changes.new_address || ''));
    lines.push('New secretary name: ' + (ctData.changes.new_secretary || ''));
    lines.push('Director change - new name: ' + (ctData.changes.director_new_name || ''));
    lines.push('Director change - new id: ' + (ctData.changes.director_new_id || ''));
    lines.push('Director change - new nationality: ' + (ctData.changes.director_new_nationality || ''));
    lines.push('Director change - new DOB: ' + (ctData.changes.director_new_dob || ''));
    lines.push('Director change - new address: ' + (ctData.changes.director_new_address || ''));
    lines.push('Director change - new email: ' + (ctData.changes.director_new_email || ''));
    lines.push('Director change - new phone: ' + (ctData.changes.director_new_phone || ''));
    lines.push('Director change - outgoing director: ' + (ctData.changes.director_old_name || ''));
    lines.push('Director change - is nominee: ' + (ctData.changes.director_is_nominee || 'no'));
    lines.push('Additional instructions: ' + (ctData.changes.additional_instructions || ''));

    ctData.extra_context = lines.join('\n');
    return ctData.extra_context;
}

function ctSetProgress(percent, text) {
    var p = Math.max(0, Math.min(100, Number(percent) || 0));
    $('#ctProgressBar').css('width', p + '%').text(Math.round(p) + '%');
    $('#ctProgressLabel').text('Generation progress: ' + Math.round(p) + '%');
    $('#ctSpinnerText').text(text || 'Generating transfer-in document package...');
}

function ctBuildDocumentList() {
    var selected = ctData.selected_changes || [];
    var docs = [];

    var specialResolutionChanges = ['change_company_name', 'reduce_share_capital', 'update_constitution'];
    var noResolutionChanges = ['particulars_update'];

    var hasBoardItems = selected.some(function(id) {
        return specialResolutionChanges.indexOf(id) === -1 && noResolutionChanges.indexOf(id) === -1;
    });

    var hasSpecialItems = selected.some(function(id) {
        return specialResolutionChanges.indexOf(id) !== -1;
    });

    docs.push('00_New_Client_Acceptance_Form.docx');
    if (hasBoardItems) {
        docs.push('01_Board_Resolution_Combined.docx');
    }
    if (hasSpecialItems) {
        docs.push('01b_Special_Resolution_Combined.docx');
    }
    if (selected.indexOf('change_director') !== -1) {
        var directorName = ctData.changes.director_new_name || 'DIRECTOR_NAME';
        docs.push('02_Form45_' + directorName.replace(/\s+/g, '_') + '.docx');
        if (ctData.changes.director_is_nominee === 'yes') {
            docs.push('06_Nominee_Director_Agreement.docx');
        }
        if (ctData.changes.director_old_name) {
            docs.push('09_Letter_of_Resignation_Director.docx');
        }
    }
    if (selected.indexOf('change_secretary') !== -1) {
        docs.push('03_Consent_Secretary.docx');
        docs.push('08_Letter_of_Resignation_Secretary.docx');
    }
    if (selected.indexOf('change_registered_office') !== -1) {
        docs.push('04_Notice_Registered_Office.docx');
    }
    if (selected.indexOf('change_registered_controller') !== -1) {
        docs.push('05_Registrable_Controller_Notice.docx');
    }
    if (ctData.acceptance.docs_dpo_registered === 'no') {
        docs.push('07_DPO_Form.docx');
    }

    return docs;
}

function ctRenderOutput() {
    var docs = ctBuildDocumentList();
    if (!docs.length) {
        $('#ctDocListBody').html('<div class="nr-output-empty">No generated documents.</div>');
    } else {
        var listHtml = '<ol class="nr-file-list">' + docs.map(function(name) {
            return '<li>' + ctEscapeHtml(name) + '</li>';
        }).join('') + '</ol>';
        $('#ctDocListBody').html(listHtml);
    }
    $('#ctAiOutputBody').text(ctData.generated_content || 'No generated content returned.');
}

function ctGenerateDocuments() {
    ctCollectData();
    var companyId = ctData.acceptance.company_id;
    if (!companyId) {
        alert('Please select company in Step 1 before generating documents.');
        ctGoStep(1);
        return;
    }

    ctSetProgress(10, 'Collecting form data...');
    var extraContext = ctBuildExtraContext();

    ctSetProgress(30, 'Calling document generator...');
    $.ajax({
        url: '<?= base_url("document_generator/generate") ?>',
        method: 'POST',
        dataType: 'json',
        timeout: 180000,
        data: {
            template_id: 'transfer_in_package',
            company_id: companyId,
            extra_context: extraContext
        }
    }).done(function(res) {
        ctSetProgress(85, 'Processing generated package...');
        $('#ctSpinnerWrap').hide();
        if (res && res.success) {
            ctData.generated_content = res.content || '';
        } else {
            ctData.generated_content = 'Error: ' + ((res && res.message) ? res.message : 'Generation failed');
        }
        ctSetProgress(100, 'Generation completed.');
        ctRenderOutput();
        ctGoStep(4);
    }).fail(function(xhr, status) {
        $('#ctSpinnerWrap').hide();
        ctSetProgress(0, 'Generation failed.');
        if (status === 'timeout') {
            ctData.generated_content = 'Error: generation request timed out. Please try again.';
        } else {
            ctData.generated_content = 'Error: unable to reach generation endpoint (HTTP ' + (xhr.status || '?') + ').';
        }
        ctRenderOutput();
        ctGoStep(4);
    });
}

function ctCopyOutput() {
    var text = $('#ctAiOutputBody').text() || '';
    if (!text) {
        return;
    }
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text);
    } else {
        var $tmp = $('<textarea>').val(text).appendTo('body').select();
        document.execCommand('copy');
        $tmp.remove();
    }
}

function ctPrintOutput() {
    var docsHtml = $('#ctDocListBody').html() || '';
    var aiText = $('#ctAiOutputBody').text() || '';
    var win = window.open('', '_blank');
    if (!win) {
        return;
    }
    win.document.write('<html><head><title>Transfer-In Output</title><style>body{font-family:Arial,sans-serif;padding:24px;}h2{font-size:16px;margin-top:0}pre{white-space:pre-wrap;line-height:1.6;font-size:12px;}</style></head><body>');
    win.document.write('<h2>Generated Document List</h2>');
    win.document.write(docsHtml);
    win.document.write('<h2>AI Output</h2><pre>' + ctEscapeHtml(aiText) + '</pre>');
    win.document.write('</body></html>');
    win.document.close();
    win.focus();
    win.print();
}

$(document).ready(function() {
    ctAddUbo();

    $('[name="bizfile_is_accurate"]').on('change', function() {
        var isNo = $('[name="bizfile_is_accurate"]:checked').val() === 'no';
        $('#ctBizfileUpdateWrap').toggleClass('nr-hidden', !isNo);
        if (isNo && !$('[data-bizfile-update-item]').length) {
            ctAddBizfileUpdate();
        }
    });

    $('#ctAddBizfileUpdateBtn').on('click', function() {
        ctAddBizfileUpdate();
    });

    $('#ctBizfileUpdates').on('click', '[data-remove-bizfile-update]', function() {
        $(this).closest('[data-bizfile-update-item]').remove();
    });

    $('#ctAddUboBtn').on('click', function() {
        ctAddUbo();
    });

    $('#ctUboList').on('click', '[data-remove-ubo]', function() {
        $(this).closest('[data-ubo-item]').remove();
    });

    $('#ctUboList').on('change', '[data-field="is_pep"]', function() {
        var checked = $(this).is(':checked');
        var $card = $(this).closest('[data-ubo-item]');
        $card.find('.nr-pep-period').toggleClass('nr-hidden', !checked);
    });

    $(document).on('change', '.nr-change-check', function() {
        var showDirectorFields = $('.nr-change-check[value="change_director"]').is(':checked');
        $('#ctDirectorFields').toggleClass('nr-hidden', !showDirectorFields);
    });

    $('#ctCompanySelect').on('change', function() {
        var $selected = $('#ctCompanySelect option:selected');
        var selectedText = $selected.text();
        var uen = $selected.data('uen') || '';
        if (selectedText && selectedText !== '-- Select a company --') {
            if (!$('[name="company_name"]').val()) {
                $('[name="company_name"]').val(selectedText.replace(/\s*\([^\)]*\)\s*$/, ''));
            }
            if (!$('[name="company_uen"]').val() && uen) {
                $('[name="company_uen"]').val(uen);
            }
        }
    });

    $('#ctToStep2Btn').on('click', function() {
        if (!ctValidateStep1()) {
            return;
        }
        ctGoStep(2);
    });

    $('#ctToStep3Btn').on('click', function() {
        ctCollectData();
        if (!ctData.selected_changes.length) {
            alert('Please select at least one change type in Step 2.');
            return;
        }
        ctGoStep(3);
    });

    $(document).on('click', '[data-goto]', function() {
        ctGoStep(Number($(this).data('goto')));
    });

    $('.nr-step').on('click', function() {
        var step = Number($(this).data('step'));
        if (step >= 2 && !ctValidateStep1()) {
            return;
        }
        if (step >= 3) {
            ctCollectData();
            if (!ctData.selected_changes.length) {
                alert('Please select at least one change type in Step 2.');
                return;
            }
        }
        ctGoStep(step);
    });

    $('#ctCopyBtn').on('click', ctCopyOutput);
    $('#ctPrintBtn').on('click', ctPrintOutput);
    $('#ctRegenerateBtn').on('click', function() {
        ctGoStep(3);
    });
});
</script>
