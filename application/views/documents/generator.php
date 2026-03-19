<!-- Document Generator -->
<div class="page-title">
    <div class="title_left">
        <h3>Document Generator</h3>
        <p style="color:var(--cf-text-secondary); font-size:14px; margin-top:4px;">
            Generate corporate secretarial documents from templates using AI
        </p>
    </div>
</div>
<div class="clearfix"></div>

<!-- Category Tabs -->
<div class="dg-tabs" id="dgTabs">
    <button class="dg-tab active" data-cat="acra" onclick="switchCategory('acra', this)">
        <i class="fa fa-university"></i> ACRA Registers
    </button>
    <button class="dg-tab" data-cat="resolutions" onclick="switchCategory('resolutions', this)">
        <i class="fa fa-gavel"></i> Company Resolutions
    </button>
    <button class="dg-tab" data-cat="annual" onclick="switchCategory('annual', this)">
        <i class="fa fa-calendar-check-o"></i> Annual Filings
    </button>
    <button class="dg-tab" data-cat="forms" onclick="switchCategory('forms', this)">
        <i class="fa fa-file-text-o"></i> Forms
    </button>
    <button class="dg-tab" data-cat="transfer" onclick="switchCategory('transfer', this)">
        <i class="fa fa-exchange"></i> Company Transfer
    </button>
    <button class="dg-tab" data-cat="reports" onclick="switchCategory('reports', this)">
        <i class="fa fa-bar-chart"></i> Reports
    </button>
</div>

<!-- Search -->
<div class="dg-search-row">
    <div class="dg-search-box">
        <i class="fa fa-search"></i>
        <input type="text" id="dgSearch" placeholder="Search templates..." oninput="filterTemplates()">
    </div>
    <div class="dg-count" id="dgCount"></div>
</div>

<!-- ═══════ ACRA Registers ═══════ -->
<div class="dg-category" id="cat-acra">
    <div class="dg-grid">
        <?php
        $acra_templates = [
            ['id'=>'acra_register_directors',       'icon'=>'fa-user-secret',    'color'=>'#337ab7', 'name'=>'Register of Directors',                  'desc'=>'Section 173 — All directors with appointments & cessations'],
            ['id'=>'acra_register_secretaries',      'icon'=>'fa-user-circle',    'color'=>'#5cb85c', 'name'=>'Register of Secretaries',                'desc'=>'Section 171 — Company secretary listing'],
            ['id'=>'acra_register_shareholders',     'icon'=>'fa-users',          'color'=>'#26B99A', 'name'=>'Register of Members',                    'desc'=>'Section 190 — Shareholders & share holdings'],
            ['id'=>'acra_register_charges',          'icon'=>'fa-chain',          'color'=>'#E74C3C', 'name'=>'Register of Charges',                    'desc'=>'Section 138 — Charges, debentures & security interests'],
            ['id'=>'acra_register_transfers',        'icon'=>'fa-exchange',       'color'=>'#3498DB', 'name'=>'Register of Share Transfers',             'desc'=>'History of all share transfers & changes'],
            ['id'=>'acra_register_allotments',       'icon'=>'fa-plus-circle',    'color'=>'#1ABC9C', 'name'=>'Register of Share Allotments',            'desc'=>'New share allotments & issuances'],
            ['id'=>'acra_register_beneficial_owners','icon'=>'fa-eye',            'color'=>'#9B59B6', 'name'=>'Register of Registrable Controllers',    'desc'=>'Section 386AF — Beneficial owners & controllers'],
            ['id'=>'acra_register_nominee_directors','icon'=>'fa-id-badge',       'color'=>'#E67E22', 'name'=>'Register of Nominee Directors',           'desc'=>'Section 386AI — Nominee director disclosures'],
            ['id'=>'acra_register_auditors',         'icon'=>'fa-shield',         'color'=>'#8E44AD', 'name'=>'Register of Auditors',                   'desc'=>'Auditor appointments & details'],
            ['id'=>'acra_register_seals',            'icon'=>'fa-stamp',          'color'=>'#7F8C8D', 'name'=>'Register of Seals',                      'desc'=>'Seal usage records & authorizations'],
        ];
        foreach ($acra_templates as $t): ?>
        <div class="dg-card" data-id="<?= $t['id'] ?>" data-name="<?= htmlspecialchars(strtolower($t['name'])) ?>" onclick="selectTemplate('<?= $t['id'] ?>', this)">
            <div class="dg-card-icon" style="background:<?= $t['color'] ?>;">
                <i class="fa <?= $t['icon'] ?>"></i>
            </div>
            <div class="dg-card-body">
                <div class="dg-card-name"><?= $t['name'] ?></div>
                <div class="dg-card-desc"><?= $t['desc'] ?></div>
            </div>
            <div class="dg-card-arrow"><i class="fa fa-chevron-right"></i></div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ═══════ Company Resolutions ═══════ -->
<div class="dg-category" id="cat-resolutions" style="display:none;">
    <div class="dg-grid">
        <?php
        $res_templates = [
            ['id'=>'res_director_appointment',   'icon'=>'fa-user-plus',      'color'=>'#337ab7', 'name'=>'Appointment of Director',              'desc'=>'Board resolution for director appointment under S.149'],
            ['id'=>'res_director_cessation',      'icon'=>'fa-user-times',     'color'=>'#E74C3C', 'name'=>'Cessation of Director',                'desc'=>'Resolution for director resignation/cessation'],
            ['id'=>'res_secretary_appointment',   'icon'=>'fa-user-plus',      'color'=>'#5cb85c', 'name'=>'Appointment of Secretary',             'desc'=>'Resolution for company secretary appointment under S.171'],
            ['id'=>'res_secretary_cessation',      'icon'=>'fa-user-times',     'color'=>'#c0392b', 'name'=>'Cessation of Secretary',               'desc'=>'Resolution for secretary cessation'],
            ['id'=>'res_change_address',          'icon'=>'fa-map-marker',     'color'=>'#2C3E50', 'name'=>'Change of Registered Address',         'desc'=>'Resolution to change registered office under S.142'],
            ['id'=>'res_change_name',             'icon'=>'fa-pencil-square-o','color'=>'#E67E22', 'name'=>'Change of Company Name',               'desc'=>'Special resolution for name change under S.28'],
            ['id'=>'res_change_fye',              'icon'=>'fa-calendar',       'color'=>'#f0ad4e', 'name'=>'Change of Financial Year End',         'desc'=>'Resolution to change FYE date'],
            ['id'=>'res_share_allotment',         'icon'=>'fa-plus-circle',    'color'=>'#1ABC9C', 'name'=>'Allotment of Shares',                  'desc'=>'Resolution for new share issuance & allotment'],
            ['id'=>'res_share_transfer',          'icon'=>'fa-exchange',       'color'=>'#3498DB', 'name'=>'Approval of Share Transfer',            'desc'=>'Board approval for share transfer between parties'],
            ['id'=>'res_dividend_declaration',     'icon'=>'fa-money',          'color'=>'#27AE60', 'name'=>'Declaration of Dividend',               'desc'=>'Resolution to declare interim or final dividend'],
            ['id'=>'res_open_bank_account',       'icon'=>'fa-university',     'color'=>'#206570', 'name'=>'Opening of Bank Account',               'desc'=>'Resolution with authorized signatories & signing mandate'],
            ['id'=>'res_close_bank_account',      'icon'=>'fa-times-circle',   'color'=>'#7F8C8D', 'name'=>'Closing of Bank Account',               'desc'=>'Resolution to close corporate bank account'],
            ['id'=>'res_authorize_signatory',      'icon'=>'fa-key',            'color'=>'#9B59B6', 'name'=>'Change of Authorized Signatories',      'desc'=>'Resolution to update bank signing authority'],
            ['id'=>'res_auditor_appointment',      'icon'=>'fa-shield',         'color'=>'#8E44AD', 'name'=>'Appointment of Auditor',                'desc'=>'Resolution for auditor appointment under S.205'],
            ['id'=>'res_annual_general_meeting',   'icon'=>'fa-calendar-check-o','color'=>'#f27b53','name'=>'AGM / Dispensation of AGM',             'desc'=>'Resolution to convene AGM or dispense under S.175A'],
            ['id'=>'res_striking_off',             'icon'=>'fa-ban',            'color'=>'#E74C3C', 'name'=>'Application for Striking Off',          'desc'=>'Special resolution for strike-off under S.344'],
        ];
        foreach ($res_templates as $t): ?>
        <div class="dg-card" data-id="<?= $t['id'] ?>" data-name="<?= htmlspecialchars(strtolower($t['name'])) ?>" onclick="selectTemplate('<?= $t['id'] ?>', this)">
            <div class="dg-card-icon" style="background:<?= $t['color'] ?>;">
                <i class="fa <?= $t['icon'] ?>"></i>
            </div>
            <div class="dg-card-body">
                <div class="dg-card-name"><?= $t['name'] ?></div>
                <div class="dg-card-desc"><?= $t['desc'] ?></div>
            </div>
            <div class="dg-card-arrow"><i class="fa fa-chevron-right"></i></div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ═══════ Annual Filings ═══════ -->
<div class="dg-category" id="cat-annual" style="display:none;">
    <div class="dg-grid">
        <?php
        $af_templates = [
            ['id'=>'af_annual_return',           'icon'=>'fa-file-text',      'color'=>'#206570', 'name'=>'Annual Return Preparation',             'desc'=>'Data summary for ACRA annual return filing'],
            ['id'=>'af_agm_notice',              'icon'=>'fa-bullhorn',       'color'=>'#337ab7', 'name'=>'Notice of AGM',                         'desc'=>'Formal notice to convene Annual General Meeting'],
            ['id'=>'af_agm_minutes',             'icon'=>'fa-pencil',         'color'=>'#26B99A', 'name'=>'Minutes of AGM',                        'desc'=>'Full AGM minutes with attendees, quorum & resolutions'],
            ['id'=>'af_directors_report',        'icon'=>'fa-briefcase',      'color'=>'#5cb85c', 'name'=>'Directors\' Report',                     'desc'=>'Report accompanying financial statements'],
            ['id'=>'af_directors_statement',     'icon'=>'fa-check-circle',   'color'=>'#f27b53', 'name'=>'Directors\' Statement',                  'desc'=>'Section 201 statement on true & fair view'],
            ['id'=>'af_exempt_private_company',  'icon'=>'fa-certificate',    'color'=>'#9B59B6', 'name'=>'EPC Declaration',                       'desc'=>'Declaration of Exempt Private Company status'],
            ['id'=>'af_dormant_company_resolution','icon'=>'fa-bed',          'color'=>'#7F8C8D', 'name'=>'Dormant Company Exemption',              'desc'=>'Resolution declaring company dormant under S.205C'],
            ['id'=>'af_solvency_statement',      'icon'=>'fa-balance-scale',  'color'=>'#E74C3C', 'name'=>'Declaration of Solvency',                'desc'=>'Section 293 solvency declaration for winding up'],
        ];
        foreach ($af_templates as $t): ?>
        <div class="dg-card" data-id="<?= $t['id'] ?>" data-name="<?= htmlspecialchars(strtolower($t['name'])) ?>" onclick="selectTemplate('<?= $t['id'] ?>', this)">
            <div class="dg-card-icon" style="background:<?= $t['color'] ?>;">
                <i class="fa <?= $t['icon'] ?>"></i>
            </div>
            <div class="dg-card-body">
                <div class="dg-card-name"><?= $t['name'] ?></div>
                <div class="dg-card-desc"><?= $t['desc'] ?></div>
            </div>
            <div class="dg-card-arrow"><i class="fa fa-chevron-right"></i></div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ═══════ Forms ═══════ -->
<div class="dg-category" id="cat-forms" style="display:none;">
    <div class="dg-grid">
        <?php
        $form_templates = [
            ['id'=>'form_consent_director',       'icon'=>'fa-check-square-o', 'color'=>'#337ab7', 'name'=>'Consent to Act as Director',            'desc'=>'Section 145 consent form for incoming director'],
            ['id'=>'form_consent_secretary',       'icon'=>'fa-check-square-o', 'color'=>'#5cb85c', 'name'=>'Consent to Act as Secretary',           'desc'=>'Consent form for incoming company secretary'],
            ['id'=>'form_resignation_director',    'icon'=>'fa-sign-out',       'color'=>'#E74C3C', 'name'=>'Director Resignation Letter',           'desc'=>'Formal resignation letter from director'],
            ['id'=>'form_resignation_secretary',   'icon'=>'fa-sign-out',       'color'=>'#c0392b', 'name'=>'Secretary Resignation Letter',          'desc'=>'Formal resignation letter from secretary'],
            ['id'=>'form_share_transfer',          'icon'=>'fa-exchange',       'color'=>'#3498DB', 'name'=>'Share Transfer Instrument',              'desc'=>'Instrument of transfer for share sale/purchase'],
            ['id'=>'form_proxy',                   'icon'=>'fa-hand-paper-o',   'color'=>'#E67E22', 'name'=>'Proxy Form',                            'desc'=>'Proxy appointment for general meeting voting'],
            ['id'=>'form_statutory_declaration',    'icon'=>'fa-gavel',          'color'=>'#206570', 'name'=>'Statutory Declaration (S.13)',           'desc'=>'Compliance declaration for incorporation'],
            ['id'=>'form_nominee_declaration',      'icon'=>'fa-id-badge',       'color'=>'#9B59B6', 'name'=>'Nominee Director Declaration',          'desc'=>'Section 386AH nominee disclosure form'],
            ['id'=>'form_register_controller_notice','icon'=>'fa-bell',         'color'=>'#f27b53', 'name'=>'Notice to Registrable Controller',      'desc'=>'Section 386AC information request to beneficial owner'],
            ['id'=>'form_change_particulars',       'icon'=>'fa-pencil',        'color'=>'#26B99A', 'name'=>'Notice of Change of Particulars',       'desc'=>'Update director/secretary personal details'],
            ['id'=>'form_waiver_preemptive',        'icon'=>'fa-thumbs-up',     'color'=>'#1ABC9C', 'name'=>'Waiver of Pre-emptive Rights',          'desc'=>'Shareholder consent to waive first refusal on new shares'],
            ['id'=>'form_indemnity_lost_cert',      'icon'=>'fa-file-o',        'color'=>'#7F8C8D', 'name'=>'Indemnity — Lost Share Certificate',    'desc'=>'Indemnity letter for replacement share certificate'],
        ];
        foreach ($form_templates as $t): ?>
        <div class="dg-card" data-id="<?= $t['id'] ?>" data-name="<?= htmlspecialchars(strtolower($t['name'])) ?>" onclick="selectTemplate('<?= $t['id'] ?>', this)">
            <div class="dg-card-icon" style="background:<?= $t['color'] ?>;">
                <i class="fa <?= $t['icon'] ?>"></i>
            </div>
            <div class="dg-card-body">
                <div class="dg-card-name"><?= $t['name'] ?></div>
                <div class="dg-card-desc"><?= $t['desc'] ?></div>
            </div>
            <div class="dg-card-arrow"><i class="fa fa-chevron-right"></i></div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ═══════ Company Transfer-In ═══════ -->
<div class="dg-category" id="cat-transfer" style="display:none;">
    <div class="dg-section-label">Company Transfer-In — 转入公司文件生成</div>
    <p style="color:var(--cf-text-secondary); font-size:13px; margin-bottom:16px; line-height:1.6;">
        Generate the complete document package for transferring a company's corporate secretary services to Yu Young Consulting.
        Select the applicable change types and the system will auto-merge Board Resolutions and generate all supplementary documents.
    </p>
    <div class="dg-grid">
        <div class="dg-card" data-id="transfer_in_package" data-name="company transfer-in complete document package" onclick="selectTemplate('transfer_in_package', this)">
            <div class="dg-card-icon" style="background:linear-gradient(135deg, #206570, #26B99A);">
                <i class="fa fa-files-o"></i>
            </div>
            <div class="dg-card-body">
                <div class="dg-card-name">Transfer-In Document Package</div>
                <div class="dg-card-desc">Complete package — Board Resolution (auto-merged), Acceptance Form, Forms & Resignation Letters</div>
            </div>
            <div class="dg-card-arrow"><i class="fa fa-chevron-right"></i></div>
        </div>
    </div>
</div>

<!-- ═══════ Reports ═══════ -->
<div class="dg-category" id="cat-reports" style="display:none;">
    <!-- Reports Hub Cards -->
    <div class="dg-reports-hub">
        <a href="<?= base_url('css_reports') ?>" class="dg-report-hub-card">
            <div class="dg-rhub-icon" style="background:#206570;"><i class="fa fa-building"></i></div>
            <div class="dg-rhub-body">
                <div class="dg-rhub-name">CSS Reports</div>
                <div class="dg-rhub-desc">Corporate Secretarial System — 24 report types including company, director, shareholder, AGM, AR, FYE reports</div>
            </div>
            <span class="label label-primary" style="flex-shrink:0;">24 Types</span>
            <i class="fa fa-external-link" style="color:var(--cf-text-muted); margin-left:8px;"></i>
        </a>
        <a href="<?= base_url('crm_reports') ?>" class="dg-report-hub-card">
            <div class="dg-rhub-icon" style="background:#26B99A;"><i class="fa fa-line-chart"></i></div>
            <div class="dg-rhub-body">
                <div class="dg-rhub-name">CRM Reports</div>
                <div class="dg-rhub-desc">CRM module — leads, sales, invoices, projects, activities, timesheets, pipeline reports</div>
            </div>
            <span class="label label-success" style="flex-shrink:0;">12 Types</span>
            <i class="fa fa-external-link" style="color:var(--cf-text-muted); margin-left:8px;"></i>
        </a>
    </div>

    <div class="dg-section-label">Quick Access — Individual Reports</div>
    <div class="dg-grid">
        <?php
        $report_templates = [
            ['id'=>'report_company_list',     'icon'=>'fa-building',        'color'=>'#206570', 'name'=>'Company List Report',               'desc'=>'Complete listing of all companies with key details'],
            ['id'=>'report_director',         'icon'=>'fa-user-secret',     'color'=>'#337ab7', 'name'=>'Director Report',                   'desc'=>'All directors with appointments & cessations'],
            ['id'=>'report_shareholder',      'icon'=>'fa-users',           'color'=>'#26B99A', 'name'=>'Shareholder Report',                'desc'=>'Shareholder details & share allocation'],
            ['id'=>'report_secretary',        'icon'=>'fa-user',            'color'=>'#5cb85c', 'name'=>'Secretary Report',                  'desc'=>'Company secretary listing & appointment details'],
            ['id'=>'report_agm',              'icon'=>'fa-calendar-check-o','color'=>'#f27b53', 'name'=>'AGM Report',                        'desc'=>'AGM dates, due dates & compliance'],
            ['id'=>'report_ar',               'icon'=>'fa-file-text',       'color'=>'#E74C3C', 'name'=>'Annual Return Report',              'desc'=>'AR filing status & dates'],
            ['id'=>'report_fye',              'icon'=>'fa-calendar',        'color'=>'#f0ad4e', 'name'=>'FYE Report',                        'desc'=>'Financial year end dates & upcoming deadlines'],
            ['id'=>'report_share_capital',    'icon'=>'fa-money',           'color'=>'#9B59B6', 'name'=>'Share Capital Report',              'desc'=>'Issued & paid-up share capital across companies'],
            ['id'=>'report_registered_address','icon'=>'fa-map-marker',     'color'=>'#2C3E50', 'name'=>'Registered Address Report',         'desc'=>'All company registered addresses & changes'],
            ['id'=>'report_auditor',          'icon'=>'fa-shield',          'color'=>'#8E44AD', 'name'=>'Auditor Report',                    'desc'=>'Company auditor appointments & details'],
        ];
        foreach ($report_templates as $t): ?>
        <div class="dg-card dg-card-link" data-id="<?= $t['id'] ?>" data-name="<?= htmlspecialchars(strtolower($t['name'])) ?>" onclick="openReport('<?= $t['id'] ?>')">
            <div class="dg-card-icon" style="background:<?= $t['color'] ?>;">
                <i class="fa <?= $t['icon'] ?>"></i>
            </div>
            <div class="dg-card-body">
                <div class="dg-card-name"><?= $t['name'] ?></div>
                <div class="dg-card-desc"><?= $t['desc'] ?></div>
            </div>
            <div class="dg-card-arrow"><i class="fa fa-external-link"></i></div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ═══════ Inline Wizard (replaces template grid when active) ═══════ -->
<div class="dg-wizard" id="dgWizard" style="display:none;">
    <!-- Wizard Header -->
    <div class="dg-wiz-header">
        <button class="dg-wiz-back" onclick="closeWizard()"><i class="fa fa-arrow-left"></i> Back to Templates</button>
        <div class="dg-wiz-title" id="dgWizTitle">Register of Directors</div>
    </div>

    <!-- Steps Indicator -->
    <div class="dg-steps" id="dgSteps">
        <div class="dg-step active" data-step="1"><span class="dg-step-num">1</span> Select Company</div>
        <div class="dg-step-line"></div>
        <div class="dg-step" data-step="2"><span class="dg-step-num">2</span> Details</div>
        <div class="dg-step-line"></div>
        <div class="dg-step" data-step="3"><span class="dg-step-num">3</span> Generate</div>
    </div>

    <!-- Step 1: Select Company -->
    <div class="dg-wiz-step" id="wizStep1">
        <div class="dg-wiz-card">
            <label class="dg-wiz-label">Select Company</label>
            <p class="dg-wiz-hint">Choose the company for which to generate this document.</p>
            <select class="form-control" id="dgCompanySelect" style="font-size:14px;">
                <option value="">-- Select a company --</option>
                <?php foreach ($companies as $c): ?>
                <option value="<?= $c->id ?>"><?= htmlspecialchars($c->company_name) ?> (<?= htmlspecialchars($c->registration_number ?? '') ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="dg-wiz-actions">
            <button class="btn btn-default" onclick="closeWizard()">Cancel</button>
            <button class="btn btn-primary" onclick="wizNext(2)">Next <i class="fa fa-arrow-right" style="margin-left:6px;"></i></button>
        </div>
    </div>

    <!-- Step 2: Template-specific Details -->
    <div class="dg-wiz-step" id="wizStep2" style="display:none;">
        <div class="dg-wiz-card">
            <label class="dg-wiz-label" id="wizStep2Label">Additional Details</label>
            <p class="dg-wiz-hint" id="wizStep2Hint">Provide any additional information for this document.</p>
            <div id="wizFields"></div>
        </div>
        <div class="dg-wiz-actions">
            <button class="btn btn-default" onclick="wizBack(1)"><i class="fa fa-arrow-left" style="margin-right:6px;"></i> Back</button>
            <button class="btn btn-primary" onclick="wizNext(3)">Generate <i class="fa fa-magic" style="margin-left:6px;"></i></button>
        </div>
    </div>

    <!-- Step 3: Output -->
    <div class="dg-wiz-step" id="wizStep3" style="display:none;">
        <!-- Loading -->
        <div id="wizLoading" style="text-align:center; padding:50px 0;">
            <div class="dg-spinner"></div>
            <p style="margin-top:14px; color:var(--cf-text-secondary); font-size:14px;">Generating document with AI...</p>
            <p style="color:var(--cf-text-muted); font-size:12px;">This may take 10-30 seconds</p>
        </div>
        <!-- Result -->
        <div id="wizResult" style="display:none;">
            <div class="dg-wiz-card" style="padding:0; overflow:hidden;">
                <div class="dg-result-toolbar">
                    <span class="dg-result-title"><i class="fa fa-check-circle" style="color:#10b981; margin-right:6px;"></i> Document Generated</span>
                    <div style="display:flex; gap:6px;">
                        <button class="btn btn-default btn-sm" onclick="copyOutput()"><i class="fa fa-copy"></i> Copy</button>
                        <button class="btn btn-default btn-sm" onclick="printOutput()"><i class="fa fa-print"></i> Print</button>
                    </div>
                </div>
                <div class="dg-result-content" id="dgOutputContent"></div>
            </div>
            <div class="dg-wiz-actions">
                <button class="btn btn-default" onclick="wizBack(2)"><i class="fa fa-arrow-left" style="margin-right:6px;"></i> Edit & Re-generate</button>
                <button class="btn btn-primary" onclick="closeWizard()"><i class="fa fa-check" style="margin-right:6px;"></i> Done</button>
            </div>
        </div>
    </div>
</div>

<!-- ═══════ STYLES ═══════ -->
<style>
/* Tabs */
.dg-tabs {
    display: flex;
    gap: 4px;
    border-bottom: 2px solid var(--cf-border);
    margin-bottom: 16px;
    overflow-x: auto;
    flex-wrap: nowrap;
}
.dg-tab {
    padding: 10px 18px;
    border: none;
    background: none;
    font-size: 13px;
    font-weight: 500;
    color: var(--cf-text-secondary);
    cursor: pointer;
    border-bottom: 2px solid transparent;
    margin-bottom: -2px;
    transition: color 0.15s, border-color 0.15s;
    white-space: nowrap;
    font-family: var(--cf-font) !important;
}
.dg-tab:hover { color: var(--cf-text); }
.dg-tab.active {
    color: var(--cf-accent);
    border-bottom-color: var(--cf-accent);
    font-weight: 600;
}
.dg-tab i { margin-right: 6px; }

/* Search */
.dg-search-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
}
.dg-search-box {
    flex: 1;
    max-width: 400px;
    position: relative;
}
.dg-search-box i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--cf-text-muted);
    font-size: 13px;
}
.dg-search-box input {
    width: 100%;
    border: 1px solid var(--cf-border);
    border-radius: 8px;
    padding: 8px 12px 8px 34px;
    font-size: 13px;
    font-family: var(--cf-font) !important;
    outline: none;
}
.dg-search-box input:focus {
    border-color: var(--cf-accent);
    box-shadow: 0 0 0 2px rgba(79,134,198,0.12);
}
.dg-count {
    font-size: 12px;
    color: var(--cf-text-muted);
}

/* Template Grid */
.dg-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 10px;
}

/* Template Card */
.dg-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    background: var(--cf-white);
    border: 1px solid var(--cf-border);
    border-radius: var(--cf-radius);
    cursor: pointer;
    transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
}
.dg-card:hover {
    border-color: var(--cf-accent);
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}
.dg-card.selected {
    border-color: var(--cf-accent);
    background: rgba(79,134,198,0.04);
    box-shadow: 0 0 0 2px rgba(79,134,198,0.15);
}
.dg-card-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #fff;
    font-size: 16px;
}
.dg-card-body {
    flex: 1;
    min-width: 0;
}
.dg-card-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--cf-text);
    margin-bottom: 2px;
}
.dg-card-desc {
    font-size: 11px;
    color: var(--cf-text-muted);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.dg-card-arrow {
    color: var(--cf-text-muted);
    font-size: 12px;
    flex-shrink: 0;
    opacity: 0;
    transition: opacity 0.15s;
}
.dg-card:hover .dg-card-arrow { opacity: 1; }

/* Reports Hub */
.dg-reports-hub {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px;
}
.dg-report-hub-card {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px 20px;
    background: var(--cf-white);
    border: 1px solid var(--cf-border);
    border-radius: var(--cf-radius);
    text-decoration: none !important;
    color: var(--cf-text);
    transition: border-color 0.15s, box-shadow 0.15s;
}
.dg-report-hub-card:hover {
    border-color: var(--cf-accent);
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    color: var(--cf-text);
}
.dg-rhub-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 20px;
    flex-shrink: 0;
}
.dg-rhub-body { flex: 1; min-width: 0; }
.dg-rhub-name { font-size: 15px; font-weight: 600; margin-bottom: 2px; }
.dg-rhub-desc { font-size: 12px; color: var(--cf-text-secondary); }

.dg-section-label {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--cf-text-muted);
    font-weight: 600;
    margin-bottom: 10px;
}

/* ═══ Inline Wizard ═══ */
.dg-wizard {
    max-width: 720px;
    margin: 0 auto;
}
.dg-wiz-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 20px;
}
.dg-wiz-back {
    border: none;
    background: none;
    color: var(--cf-text-secondary);
    font-size: 13px;
    cursor: pointer;
    padding: 6px 0;
    font-family: var(--cf-font) !important;
    transition: color 0.15s;
}
.dg-wiz-back:hover { color: var(--cf-accent); }
.dg-wiz-back i { margin-right: 6px; }
.dg-wiz-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--cf-text);
}

/* Steps indicator */
.dg-steps {
    display: flex;
    align-items: center;
    gap: 0;
    margin-bottom: 24px;
    background: var(--cf-bg);
    border-radius: var(--cf-radius);
    padding: 12px 20px;
}
.dg-step {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--cf-text-muted);
    font-weight: 500;
    white-space: nowrap;
}
.dg-step.active {
    color: var(--cf-accent);
    font-weight: 600;
}
.dg-step.done {
    color: #10b981;
}
.dg-step-num {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    background: var(--cf-border);
    color: var(--cf-text-muted);
    flex-shrink: 0;
}
.dg-step.active .dg-step-num {
    background: var(--cf-accent);
    color: #fff;
}
.dg-step.done .dg-step-num {
    background: #10b981;
    color: #fff;
}
.dg-step-line {
    flex: 1;
    height: 2px;
    background: var(--cf-border);
    margin: 0 12px;
    min-width: 20px;
}

/* Wizard cards */
.dg-wiz-card {
    background: var(--cf-white);
    border: 1px solid var(--cf-border);
    border-radius: var(--cf-radius);
    padding: 24px;
    margin-bottom: 16px;
}
.dg-wiz-label {
    font-size: 14px;
    font-weight: 600;
    color: var(--cf-text);
    margin-bottom: 4px;
    display: block;
}
.dg-wiz-hint {
    font-size: 12px;
    color: var(--cf-text-muted);
    margin-bottom: 16px;
}
.dg-wiz-actions {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    padding-top: 8px;
}
.dg-wiz-actions .btn {
    border-radius: var(--cf-radius-sm);
    padding: 9px 20px;
    font-weight: 600;
    font-size: 13px;
}

/* Wizard form fields */
.dg-wiz-field {
    margin-bottom: 14px;
}
.dg-wiz-field label {
    font-size: 12px;
    font-weight: 600;
    color: var(--cf-text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.4px;
    margin-bottom: 4px;
    display: block;
}
.dg-wiz-field input,
.dg-wiz-field select,
.dg-wiz-field textarea {
    width: 100%;
    border: 1px solid var(--cf-border);
    border-radius: 6px;
    padding: 8px 12px;
    font-size: 13px;
    font-family: var(--cf-font) !important;
    outline: none;
    transition: border-color 0.15s;
}
.dg-wiz-field input:focus,
.dg-wiz-field select:focus,
.dg-wiz-field textarea:focus {
    border-color: var(--cf-accent);
    box-shadow: 0 0 0 2px rgba(79,134,198,0.1);
    outline: none !important;
}

/* Result area */
.dg-result-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 20px;
    border-bottom: 1px solid var(--cf-border);
    background: var(--cf-bg);
}
.dg-result-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--cf-text);
}
.dg-result-content {
    padding: 20px;
    font-size: 13px;
    line-height: 1.8;
    white-space: pre-wrap;
    max-height: 500px;
    overflow-y: auto;
    color: var(--cf-text);
}

/* Spinner */
.dg-spinner {
    width: 36px;
    height: 36px;
    border: 3px solid var(--cf-border);
    border-top-color: var(--cf-accent);
    border-radius: 50%;
    animation: dgSpin 0.8s linear infinite;
    margin: 0 auto;
}
@keyframes dgSpin { to { transform: rotate(360deg); } }

/* Hidden template */
.dg-card.dg-hidden { display: none; }

/* ═══ Transfer-In Specific ═══ */
.dg-ti-section {
    background: var(--cf-white);
    border: 1px solid var(--cf-border);
    border-radius: var(--cf-radius);
    padding: 20px 24px;
}
.dg-ti-section-title {
    font-size: 14px;
    font-weight: 700;
    color: var(--cf-text);
    margin-bottom: 4px;
}
.dg-ti-section-desc {
    font-size: 12px;
    color: var(--cf-text-muted);
    margin-bottom: 14px;
}
.dg-ti-group-label {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--cf-text-secondary);
    font-weight: 600;
    margin-bottom: 8px;
    padding-top: 4px;
}
.dg-ti-check-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 7px 10px;
    margin: 0 -10px;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.12s;
    font-weight: 400;
}
.dg-ti-check-row:hover {
    background: rgba(79,134,198,0.04);
}
.dg-ti-cb {
    width: 16px;
    height: 16px;
    accent-color: var(--cf-accent);
    flex-shrink: 0;
    cursor: pointer;
}
.dg-ti-check-label {
    font-size: 13px;
    color: var(--cf-text);
    line-height: 1.4;
}
.dg-ti-cn {
    color: var(--cf-text-muted);
    font-size: 12px;
}
.dg-ti-badge {
    display: inline-block;
    font-size: 10px;
    font-weight: 600;
    padding: 1px 6px;
    border-radius: 4px;
    margin-left: 6px;
    vertical-align: middle;
}
.dg-ti-badge-special {
    background: #fef3c7;
    color: #92400e;
}
.dg-ti-badge-admin {
    background: #e0e7ff;
    color: #3730a3;
}

@media (max-width: 768px) {
    .dg-grid { grid-template-columns: 1fr; }
    .dg-gen-panel { width: 100vw; max-width: 100vw; }
}
</style>

<!-- ═══════ JAVASCRIPT ═══════ -->
<script>
var selectedTemplateId = null;
var currentCategory = 'acra';

/* Report URL map */
var reportUrls = {
    'report_company_list':      '<?= base_url('report_view/official_contact_address') ?>',
    'report_director':          '<?= base_url('report_view/comp_director_report') ?>',
    'report_shareholder':       '<?= base_url('report_view/default_shareholder') ?>',
    'report_secretary':         '<?= base_url('report_view/comp_secretary_default') ?>',
    'report_agm':               '<?= base_url('report_view/agm_overdue') ?>',
    'report_ar':                '<?= base_url('report_view/key_dates') ?>',
    'report_fye':               '<?= base_url('report_view/remainder_upcoming_event') ?>',
    'report_share_capital':     '<?= base_url('report_view/register_of_shares_allotment') ?>',
    'report_registered_address':'<?= base_url('report_view/registered_office_default') ?>',
    'report_auditor':           '<?= base_url('report_view/register_of_auditors') ?>'
};

function switchCategory(cat, el) {
    currentCategory = cat;
    /* Update tab */
    $('.dg-tab').removeClass('active');
    $(el).addClass('active');
    /* Show/hide panels */
    $('.dg-category').hide();
    $('#cat-' + cat).show();
    /* Clear search */
    $('#dgSearch').val('');
    filterTemplates();
}

function filterTemplates() {
    var q = $('#dgSearch').val().toLowerCase().trim();
    var words = q ? q.split(/\s+/).filter(function(w) { return w.length > 0; }) : [];
    var visible = 0;
    var total = 0;
    
    $('#cat-' + currentCategory + ' .dg-card').each(function() {
        total++;
        if (!q) {
            $(this).removeClass('dg-hidden');
            visible++;
            return;
        }
        var name = ($(this).data('name') || '').toLowerCase();
        var desc = $(this).find('.dg-card-desc').text().toLowerCase();
        var text = name + ' ' + desc;
        var match = words.every(function(w) { return text.indexOf(w) !== -1; });
        $(this).toggleClass('dg-hidden', !match);
        if (match) visible++;
    });
    
    $('#dgCount').text(visible + ' of ' + total + ' templates');
}

/* ═══════ Template-specific fields ═══════ */
var templateFields = {
    /* ACRA Registers — mostly auto-generated from company data */
    'acra_register_directors':       { label: 'Register of Directors', hint: 'Will auto-populate from company data. Add notes if needed.', fields: [{ id:'notes', label:'Additional Notes', type:'textarea', placeholder:'e.g. Include resigned directors from last 2 years' }] },
    'acra_register_secretaries':     { label: 'Register of Secretaries', hint: 'Auto-populated from company records.', fields: [{ id:'notes', label:'Additional Notes', type:'textarea', placeholder:'Any specific instructions' }] },
    'acra_register_shareholders':    { label: 'Register of Members', hint: 'Auto-populated from shareholder records.', fields: [{ id:'notes', label:'Additional Notes', type:'textarea', placeholder:'e.g. Include share class details' }] },
    'acra_register_charges':         { label: 'Register of Charges', hint: 'Enter charge details below.', fields: [{ id:'charge_desc', label:'Charge Description', type:'text', placeholder:'e.g. First fixed charge over property' }, { id:'amount', label:'Amount Secured', type:'text', placeholder:'e.g. SGD 500,000' }, { id:'chargee', label:'Chargee Name', type:'text', placeholder:'e.g. DBS Bank Ltd' }] },
    'acra_register_transfers':       { label: 'Share Transfers', hint: 'Auto-populated. Add notes if needed.', fields: [{ id:'notes', label:'Additional Notes', type:'textarea', placeholder:'Any specific transfer details to include' }] },
    'acra_register_allotments':      { label: 'Share Allotments', hint: 'Auto-populated. Add notes if needed.', fields: [{ id:'notes', label:'Additional Notes', type:'textarea', placeholder:'Any specific allotment details' }] },
    'acra_register_beneficial_owners': { label: 'Registrable Controllers', hint: 'Enter controller details.', fields: [{ id:'controller_name', label:'Controller Name', type:'text', placeholder:'Full legal name' }, { id:'nature_of_control', label:'Nature of Control', type:'text', placeholder:'e.g. Holds >25% shares directly' }] },
    'acra_register_nominee_directors': { label: 'Nominee Directors', hint: 'Enter nominator details.', fields: [{ id:'nominator_name', label:'Nominator Name', type:'text', placeholder:'Full name of nominator' }, { id:'nominator_address', label:'Nominator Address', type:'text', placeholder:'Residential address' }] },
    'acra_register_auditors':        { label: 'Register of Auditors', hint: 'Auto-populated from company records.', fields: [{ id:'notes', label:'Additional Notes', type:'textarea', placeholder:'Any specific instructions' }] },
    'acra_register_seals':           { label: 'Register of Seals', hint: 'Enter sealing record details.', fields: [{ id:'document_sealed', label:'Document Sealed', type:'text', placeholder:'e.g. Share Certificate No. 001' }, { id:'purpose', label:'Purpose', type:'text', placeholder:'e.g. Issuance of shares' }] },

    /* Company Resolutions */
    'res_director_appointment':   { label: 'Director Appointment', hint: 'Enter the new director details.', fields: [{ id:'dir_name', label:'Director Full Name', type:'text', placeholder:'Full legal name' }, { id:'dir_id', label:'ID/Passport No.', type:'text', placeholder:'e.g. S1234567A' }, { id:'dir_nationality', label:'Nationality', type:'text', placeholder:'e.g. Singaporean' }, { id:'dir_address', label:'Residential Address', type:'text', placeholder:'Full address' }, { id:'effective_date', label:'Effective Date', type:'date' }] },
    'res_director_cessation':     { label: 'Director Cessation', hint: 'Enter the outgoing director details.', fields: [{ id:'dir_name', label:'Director Full Name', type:'text', placeholder:'Name of resigning director' }, { id:'effective_date', label:'Effective Date', type:'date' }, { id:'reason', label:'Reason', type:'select', options:['Resignation','Removal','Disqualification','Death'] }] },
    'res_secretary_appointment':  { label: 'Secretary Appointment', hint: 'Enter the new secretary details.', fields: [{ id:'sec_name', label:'Secretary Full Name', type:'text', placeholder:'Full legal name' }, { id:'sec_id', label:'ID No.', type:'text', placeholder:'e.g. S1234567A' }, { id:'effective_date', label:'Effective Date', type:'date' }] },
    'res_secretary_cessation':    { label: 'Secretary Cessation', hint: 'Enter cessation details.', fields: [{ id:'sec_name', label:'Secretary Name', type:'text', placeholder:'Name of outgoing secretary' }, { id:'effective_date', label:'Effective Date', type:'date' }] },
    'res_change_address':         { label: 'Change of Address', hint: 'Enter the address change details.', fields: [{ id:'old_address', label:'Current Registered Address', type:'text', placeholder:'Current address' }, { id:'new_address', label:'New Registered Address', type:'text', placeholder:'New address' }, { id:'effective_date', label:'Effective Date', type:'date' }] },
    'res_change_name':            { label: 'Change of Company Name', hint: 'Enter the name change details.', fields: [{ id:'new_name', label:'Proposed New Company Name', type:'text', placeholder:'New company name' }, { id:'reason', label:'Reason for Change', type:'textarea', placeholder:'Brief reason for the name change' }] },
    'res_change_fye':             { label: 'Change of FYE', hint: 'Enter financial year end change details.', fields: [{ id:'current_fye', label:'Current FYE Date', type:'text', placeholder:'e.g. 31 December' }, { id:'new_fye', label:'New FYE Date', type:'text', placeholder:'e.g. 31 March' }, { id:'reason', label:'Reason', type:'textarea', placeholder:'Reason for FYE change' }] },
    'res_share_allotment':        { label: 'Share Allotment', hint: 'Enter allotment details.', fields: [{ id:'allottee', label:'Allottee Name', type:'text', placeholder:'Full name' }, { id:'num_shares', label:'Number of Shares', type:'text', placeholder:'e.g. 10,000' }, { id:'share_class', label:'Class of Shares', type:'text', placeholder:'e.g. Ordinary' }, { id:'consideration', label:'Consideration per Share', type:'text', placeholder:'e.g. SGD 1.00' }] },
    'res_share_transfer':         { label: 'Share Transfer Approval', hint: 'Enter transfer details.', fields: [{ id:'transferor', label:'Transferor Name', type:'text', placeholder:'Selling party' }, { id:'transferee', label:'Transferee Name', type:'text', placeholder:'Buying party' }, { id:'num_shares', label:'Number of Shares', type:'text', placeholder:'e.g. 5,000' }, { id:'consideration', label:'Total Consideration', type:'text', placeholder:'e.g. SGD 50,000' }] },
    'res_dividend_declaration':   { label: 'Dividend Declaration', hint: 'Enter dividend details.', fields: [{ id:'div_type', label:'Dividend Type', type:'select', options:['Interim Dividend','Final Dividend','Special Dividend'] }, { id:'amount_per_share', label:'Amount per Share', type:'text', placeholder:'e.g. SGD 0.05' }, { id:'record_date', label:'Record Date', type:'date' }, { id:'payment_date', label:'Payment Date', type:'date' }] },
    'res_open_bank_account':      { label: 'Open Bank Account', hint: 'Enter bank account details.', fields: [{ id:'bank_name', label:'Bank Name', type:'text', placeholder:'e.g. DBS Bank' }, { id:'account_type', label:'Account Type', type:'text', placeholder:'e.g. Corporate Current Account' }, { id:'signatories', label:'Authorized Signatories', type:'textarea', placeholder:'List the authorized signatories' }] },
    'res_close_bank_account':     { label: 'Close Bank Account', hint: 'Enter account closure details.', fields: [{ id:'bank_name', label:'Bank Name', type:'text', placeholder:'e.g. OCBC Bank' }, { id:'account_no', label:'Account Number', type:'text', placeholder:'Account number to close' }, { id:'reason', label:'Reason', type:'text', placeholder:'Reason for closure' }] },
    'res_authorize_signatory':    { label: 'Change Signatories', hint: 'Enter signatory change details.', fields: [{ id:'outgoing', label:'Outgoing Signatory', type:'text', placeholder:'Name of outgoing signatory' }, { id:'incoming', label:'Incoming Signatory', type:'text', placeholder:'Name of new signatory' }, { id:'bank_name', label:'Bank Name', type:'text', placeholder:'Bank name' }] },
    'res_auditor_appointment':    { label: 'Auditor Appointment', hint: 'Enter auditor details.', fields: [{ id:'auditor_firm', label:'Audit Firm Name', type:'text', placeholder:'e.g. KPMG LLP' }, { id:'partner', label:'Partner-in-Charge', type:'text', placeholder:'Name of partner' }, { id:'fy', label:'Financial Year', type:'text', placeholder:'e.g. FY2025' }] },
    'res_annual_general_meeting': { label: 'AGM Resolution', hint: 'Enter AGM details.', fields: [{ id:'agm_type', label:'Type', type:'select', options:['Convene AGM','Dispense with AGM (S.175A)'] }, { id:'agm_date', label:'AGM Date', type:'date' }, { id:'venue', label:'Venue', type:'text', placeholder:'e.g. 1 Raffles Place #10-01' }] },
    'res_striking_off':           { label: 'Striking Off', hint: 'Confirm company is eligible.', fields: [{ id:'confirm_no_assets', label:'Confirm No Assets/Liabilities', type:'select', options:['Yes — Company has no assets or liabilities','No'] }, { id:'confirm_no_charges', label:'Confirm No Outstanding Charges', type:'select', options:['Yes — No outstanding charges','No'] }] },

    /* Annual Filings */
    'af_annual_return':           { label: 'Annual Return', hint: 'All data auto-populated from company records.', fields: [{ id:'ar_year', label:'AR Year', type:'text', placeholder:'e.g. 2025' }] },
    'af_agm_notice':              { label: 'AGM Notice', hint: 'Enter meeting details.', fields: [{ id:'meeting_date', label:'Meeting Date & Time', type:'text', placeholder:'e.g. 15 June 2025 at 10:00 AM' }, { id:'venue', label:'Venue', type:'text', placeholder:'Meeting venue address' }, { id:'special_business', label:'Special Business (if any)', type:'textarea', placeholder:'Any special resolutions to be tabled' }] },
    'af_agm_minutes':             { label: 'AGM Minutes', hint: 'Enter AGM details.', fields: [{ id:'meeting_date', label:'Date of AGM', type:'date' }, { id:'chairman', label:'Chairman', type:'text', placeholder:'Name of chairman' }, { id:'attendees', label:'Attendees', type:'textarea', placeholder:'List of attendees (one per line)' }] },
    'af_directors_report':        { label: 'Directors Report', hint: 'Enter financial year details.', fields: [{ id:'fy_period', label:'Financial Year Period', type:'text', placeholder:'e.g. 1 Jan 2024 to 31 Dec 2024' }, { id:'principal_activities', label:'Principal Activities', type:'text', placeholder:'e.g. Investment holding' }] },
    'af_directors_statement':     { label: 'Directors Statement', hint: 'Enter financial year details.', fields: [{ id:'fy_period', label:'Financial Year Period', type:'text', placeholder:'e.g. 1 Jan 2024 to 31 Dec 2024' }] },
    'af_exempt_private_company':  { label: 'EPC Declaration', hint: 'Auto-generated based on company data.', fields: [{ id:'notes', label:'Additional Notes', type:'textarea', placeholder:'Any clarifications' }] },
    'af_dormant_company_resolution': { label: 'Dormant Company', hint: 'Confirm dormancy.', fields: [{ id:'dormant_since', label:'Dormant Since', type:'date' }, { id:'reason', label:'Reason for Dormancy', type:'text', placeholder:'e.g. No business operations' }] },
    'af_solvency_statement':      { label: 'Solvency Declaration', hint: 'Enter declaration details.', fields: [{ id:'period', label:'Review Period', type:'text', placeholder:'e.g. Next 12 months from date of declaration' }] },

    /* Forms */
    'form_consent_director':       { label: 'Director Consent', hint: 'Enter incoming director details.', fields: [{ id:'dir_name', label:'Full Name', type:'text', placeholder:'Full legal name' }, { id:'dir_id', label:'ID/Passport No.', type:'text', placeholder:'e.g. S1234567A' }, { id:'dir_nationality', label:'Nationality', type:'text', placeholder:'e.g. Singaporean' }, { id:'dir_address', label:'Residential Address', type:'text', placeholder:'Full address' }] },
    'form_consent_secretary':      { label: 'Secretary Consent', hint: 'Enter incoming secretary details.', fields: [{ id:'sec_name', label:'Full Name', type:'text', placeholder:'Full legal name' }, { id:'sec_id', label:'ID No.', type:'text', placeholder:'e.g. S1234567A' }] },
    'form_resignation_director':   { label: 'Director Resignation', hint: 'Enter resignation details.', fields: [{ id:'dir_name', label:'Director Name', type:'text', placeholder:'Name of resigning director' }, { id:'effective_date', label:'Effective Date', type:'date' }] },
    'form_resignation_secretary':  { label: 'Secretary Resignation', hint: 'Enter resignation details.', fields: [{ id:'sec_name', label:'Secretary Name', type:'text', placeholder:'Name of resigning secretary' }, { id:'effective_date', label:'Effective Date', type:'date' }] },
    'form_share_transfer':         { label: 'Transfer Instrument', hint: 'Enter transfer details.', fields: [{ id:'transferor', label:'Transferor', type:'text', placeholder:'Selling party name' }, { id:'transferee', label:'Transferee', type:'text', placeholder:'Buying party name' }, { id:'num_shares', label:'No. of Shares', type:'text', placeholder:'e.g. 1,000' }, { id:'consideration', label:'Consideration', type:'text', placeholder:'e.g. SGD 10,000' }] },
    'form_proxy':                  { label: 'Proxy Form', hint: 'Enter meeting details.', fields: [{ id:'meeting_date', label:'Meeting Date', type:'date' }, { id:'member_name', label:'Member Name', type:'text', placeholder:'Name of appointing member' }, { id:'proxy_name', label:'Proxy Name', type:'text', placeholder:'Name of proxy' }] },
    'form_statutory_declaration':  { label: 'Statutory Declaration', hint: 'Auto-generated for incorporation.', fields: [{ id:'notes', label:'Additional Notes', type:'textarea', placeholder:'Any clarifications' }] },
    'form_nominee_declaration':    { label: 'Nominee Declaration', hint: 'Enter nominee & nominator details.', fields: [{ id:'nominee_name', label:'Nominee Director Name', type:'text', placeholder:'Full name' }, { id:'nominator_name', label:'Nominator Name', type:'text', placeholder:'Full name of nominator' }] },
    'form_register_controller_notice': { label: 'Controller Notice', hint: 'Enter controller details.', fields: [{ id:'controller_name', label:'Controller Name', type:'text', placeholder:'Full name' }, { id:'controller_address', label:'Controller Address', type:'text', placeholder:'Address' }] },
    'form_change_particulars':     { label: 'Change of Particulars', hint: 'Enter old and new details.', fields: [{ id:'person_name', label:'Person Name', type:'text', placeholder:'Director/Secretary name' }, { id:'field_changed', label:'Field Changed', type:'select', options:['Residential Address','Name','ID Number','Nationality'] }, { id:'old_value', label:'Old Value', type:'text', placeholder:'Previous value' }, { id:'new_value', label:'New Value', type:'text', placeholder:'New value' }] },
    'form_waiver_preemptive':      { label: 'Waiver of Pre-emptive Rights', hint: 'Enter allotment details.', fields: [{ id:'num_shares', label:'Shares to be Allotted', type:'text', placeholder:'e.g. 10,000' }, { id:'allottee', label:'Allottee Name', type:'text', placeholder:'Name of allottee' }] },
    'form_indemnity_lost_cert':    { label: 'Lost Certificate Indemnity', hint: 'Enter certificate details.', fields: [{ id:'cert_no', label:'Certificate Number', type:'text', placeholder:'e.g. CERT-001' }, { id:'holder_name', label:'Certificate Holder', type:'text', placeholder:'Name of holder' }, { id:'num_shares', label:'No. of Shares', type:'text', placeholder:'Shares on lost certificate' }] },

    /* Company Transfer-In */
    'transfer_in_package': {
        label: 'Company Transfer-In — Document Package',
        hint: 'Select the changes needed for this transfer-in. The standard 3 items (address, secretary, director) are pre-checked. Board Resolutions will be auto-merged into one document.',
        custom: true
    },
};

var selectedTemplateName = '';

function selectTemplate(id, el) {
    selectedTemplateId = id;
    selectedTemplateName = $(el).find('.dg-card-name').text();
    
    /* Hide template grid, show wizard */
    $('#dgTabs, .dg-search-row, .dg-category').hide();
    $('#dgWizard').show();
    $('#dgWizTitle').text(selectedTemplateName);
    
    /* Build step 2 fields */
    buildWizFields(id);
    
    /* Start at step 1 */
    showWizStep(1);
    
    /* Scroll to top */
    window.scrollTo(0, 0);
}

function openReport(id) {
    var url = reportUrls[id];
    if (url) window.location.href = url;
}

function closeWizard() {
    $('#dgWizard').hide();
    $('#dgTabs, .dg-search-row').show();
    $('#cat-' + currentCategory).show();
    $('.dg-card').removeClass('selected');
    selectedTemplateId = null;
}

function showWizStep(step) {
    $('.dg-wiz-step').hide();
    $('#wizStep' + step).show();
    /* Update step indicators */
    $('.dg-step').each(function() {
        var s = parseInt($(this).data('step'));
        $(this).removeClass('active done');
        if (s < step) $(this).addClass('done');
        else if (s === step) $(this).addClass('active');
    });
}

function wizNext(step) {
    if (step === 2) {
        /* Validate step 1 */
        showWizStep(2);
    } else if (step === 3) {
        showWizStep(3);
        doGenerate();
    }
}

function wizBack(step) {
    showWizStep(step);
}

function buildWizFields(templateId) {
    var config = templateFields[templateId];
    var container = $('#wizFields');
    container.empty();
    
    if (!config) {
        $('#wizStep2Label').text('Additional Details');
        $('#wizStep2Hint').text('No additional input needed for this template.');
        container.html('<p style="color:var(--cf-text-muted); font-size:13px;">This document will be generated using your company data. Click Generate to proceed.</p>');
        return;
    }
    
    $('#wizStep2Label').text(config.label);
    $('#wizStep2Hint').text(config.hint);

    /* Custom transfer-in builder */
    if (config.custom && templateId === 'transfer_in_package') {
        buildTransferInFields(container);
        return;
    }
    
    config.fields.forEach(function(f) {
        var html = '<div class="dg-wiz-field"><label for="wiz_' + f.id + '">' + f.label + '</label>';
        if (f.type === 'textarea') {
            html += '<textarea id="wiz_' + f.id + '" rows="3" placeholder="' + (f.placeholder || '') + '"></textarea>';
        } else if (f.type === 'select') {
            html += '<select id="wiz_' + f.id + '">';
            (f.options || []).forEach(function(opt) {
                html += '<option value="' + opt + '">' + opt + '</option>';
            });
            html += '</select>';
        } else if (f.type === 'date') {
            html += '<input type="date" id="wiz_' + f.id + '">';
        } else {
            html += '<input type="text" id="wiz_' + f.id + '" placeholder="' + (f.placeholder || '') + '">';
        }
        html += '</div>';
        container.append(html);
    });
}

/* ═══════ Transfer-In Custom Builder ═══════ */
function buildTransferInFields(container) {
    var changeTypes = [
        { id: 'change_registered_office',   label: 'Change Registered Office',       cn: '变更注册地址',   checked: true,  group: 'standard' },
        { id: 'change_secretary',            label: 'Change Secretary',               cn: '变更公司秘书',   checked: true,  group: 'standard' },
        { id: 'change_director',             label: 'Change Director',                cn: '变更董事',       checked: false, group: 'standard' },
        { id: 'change_company_name',         label: 'Change Company Name',            cn: '变更公司名称',   checked: false, group: 'additional', special: true },
        { id: 'change_principal_activities', label: 'Change Principal Activities',    cn: '变更主营业务',   checked: false, group: 'additional' },
        { id: 'change_registered_controller',label: 'Change Registered Controller',  cn: '变更实控人',     checked: false, group: 'additional' },
        { id: 'change_accounting_period',    label: 'Change Accounting Period',       cn: '变更会计期间',   checked: false, group: 'additional' },
        { id: 'change_currency',             label: 'Change Currency',                cn: '变更货币',       checked: false, group: 'additional' },
        { id: 'increase_share_capital',      label: 'Increase Share Capital',         cn: '增加股本',       checked: false, group: 'capital' },
        { id: 'reduce_share_capital',        label: 'Reduce Share Capital',           cn: '减少股本',       checked: false, group: 'capital', special: true },
        { id: 'transfer_share',              label: 'Transfer Share',                 cn: '股份转让',       checked: false, group: 'capital' },
        { id: 'interim_dividend',            label: 'Interim Dividend',               cn: '中期分红',       checked: false, group: 'capital' },
        { id: 'update_constitution',         label: 'Update Constitution',            cn: '更新章程',       checked: false, group: 'additional', special: true },
        { id: 'update_paid_up_capital',      label: 'Update Paid-up Capital',         cn: '更新实缴资本',   checked: false, group: 'capital' },
        { id: 'particulars_update',          label: 'Particulars Update',             cn: '个人信息更新',   checked: false, group: 'additional', noResolution: true }
    ];

    /* Section: Change Type Selection */
    var html = '';
    html += '<div class="dg-ti-section">';
    html += '<div class="dg-ti-section-title">Select Change Types (变更项目)</div>';
    html += '<div class="dg-ti-section-desc">Check all changes needed for this transfer-in. Pre-checked items are standard for most transfers.</div>';

    /* Standard Transfer Package */
    html += '<div class="dg-ti-group-label"><i class="fa fa-star" style="color:#f0ad4e; margin-right:6px;"></i>Standard Transfer Package</div>';
    changeTypes.filter(function(ct) { return ct.group === 'standard'; }).forEach(function(ct) {
        html += buildChangeTypeCheckbox(ct);
    });

    /* Additional Changes */
    html += '<div class="dg-ti-group-label" style="margin-top:14px;"><i class="fa fa-plus-circle" style="color:#3498DB; margin-right:6px;"></i>Additional Changes</div>';
    changeTypes.filter(function(ct) { return ct.group === 'additional'; }).forEach(function(ct) {
        html += buildChangeTypeCheckbox(ct);
    });

    /* Capital & Share Changes */
    html += '<div class="dg-ti-group-label" style="margin-top:14px;"><i class="fa fa-money" style="color:#27AE60; margin-right:6px;"></i>Capital & Share Changes</div>';
    changeTypes.filter(function(ct) { return ct.group === 'capital'; }).forEach(function(ct) {
        html += buildChangeTypeCheckbox(ct);
    });

    html += '</div>';

    /* Section: Common Fields */
    html += '<div class="dg-ti-section" style="margin-top:20px;">';
    html += '<div class="dg-ti-section-title">Transfer Details</div>';
    html += '<div class="dg-wiz-field"><label for="wiz_ti_effective_date">Effective Date (生效日期)</label>';
    html += '<input type="date" id="wiz_ti_effective_date"></div>';

    html += '<div class="dg-wiz-field"><label for="wiz_ti_new_address">New Registered Office (if different from Yu Young default)</label>';
    html += '<input type="text" id="wiz_ti_new_address" placeholder="Default: 51 Goldhill Plaza #20-07 Singapore 308900"></div>';

    html += '<div class="dg-wiz-field"><label for="wiz_ti_new_secretary">New Secretary Name (if different from default)</label>';
    html += '<input type="text" id="wiz_ti_new_secretary" placeholder="Default: YANG YUJIE"></div>';
    html += '</div>';

    /* Section: Director Change Details (conditional) */
    html += '<div class="dg-ti-section dg-ti-conditional" id="tiDirectorFields" style="margin-top:20px; display:none;">';
    html += '<div class="dg-ti-section-title">New Director Details (变更董事详情)</div>';
    html += '<div class="dg-wiz-field"><label for="wiz_ti_dir_name">Director Full Name</label>';
    html += '<input type="text" id="wiz_ti_dir_name" placeholder="Full legal name"></div>';
    html += '<div class="dg-wiz-field"><label for="wiz_ti_dir_id">ID/Passport No.</label>';
    html += '<input type="text" id="wiz_ti_dir_id" placeholder="e.g. S1234567A"></div>';
    html += '<div class="dg-wiz-field"><label for="wiz_ti_dir_nationality">Nationality</label>';
    html += '<input type="text" id="wiz_ti_dir_nationality" placeholder="e.g. Singaporean"></div>';
    html += '<div class="dg-wiz-field"><label for="wiz_ti_dir_address">Residential Address</label>';
    html += '<input type="text" id="wiz_ti_dir_address" placeholder="Full residential address"></div>';
    html += '<div class="dg-wiz-field"><label for="wiz_ti_dir_is_nominee">Is Nominee Director?</label>';
    html += '<select id="wiz_ti_dir_is_nominee"><option value="no">No — Independent director</option><option value="yes">Yes — Yu Young nominee director</option></select></div>';
    html += '<div class="dg-wiz-field"><label for="wiz_ti_dir_removing">Director Being Removed (if any)</label>';
    html += '<input type="text" id="wiz_ti_dir_removing" placeholder="Name of outgoing director (leave blank if none)"></div>';
    html += '</div>';

    /* Section: Additional Context */
    html += '<div class="dg-ti-section" style="margin-top:20px;">';
    html += '<div class="dg-ti-section-title">Additional Instructions (补充说明)</div>';
    html += '<div class="dg-wiz-field"><label for="wiz_ti_extra">Any additional details or special instructions</label>';
    html += '<textarea id="wiz_ti_extra" rows="3" placeholder="e.g. New SSIC code for principal activity change, share transfer details, etc."></textarea></div>';
    html += '</div>';

    container.html(html);

    /* Bind checkbox change events */
    container.find('.dg-ti-cb').on('change', function() {
        var id = $(this).val();
        /* Show/hide director fields */
        if (id === 'change_director') {
            $('#tiDirectorFields').toggle($(this).is(':checked'));
        }
    });
}

function buildChangeTypeCheckbox(ct) {
    var badges = '';
    if (ct.special) badges += ' <span class="dg-ti-badge dg-ti-badge-special">Special Resolution</span>';
    if (ct.noResolution) badges += ' <span class="dg-ti-badge dg-ti-badge-admin">No Resolution</span>';
    return '<label class="dg-ti-check-row">' +
        '<input type="checkbox" class="dg-ti-cb" value="' + ct.id + '"' + (ct.checked ? ' checked' : '') + '>' +
        '<span class="dg-ti-check-label">' + ct.label + ' <span class="dg-ti-cn">(' + ct.cn + ')</span>' + badges + '</span>' +
        '</label>';
}

function collectWizFields() {
    var data = {};
    var config = templateFields[selectedTemplateId];
    if (!config) return data;

    /* Custom transfer-in collection */
    if (config.custom && selectedTemplateId === 'transfer_in_package') {
        return collectTransferInFields();
    }

    config.fields.forEach(function(f) {
        data[f.id] = $('#wiz_' + f.id).val() || '';
    });
    return data;
}

function collectTransferInFields() {
    var data = {};
    /* Collect selected change types */
    var selected = [];
    $('.dg-ti-cb:checked').each(function() {
        selected.push($(this).val());
    });
    data['selected_changes'] = selected.join(', ');

    /* Common fields */
    data['effective_date'] = $('#wiz_ti_effective_date').val() || '';
    data['new_registered_office'] = $('#wiz_ti_new_address').val() || '51 Goldhill Plaza #20-07 Singapore 308900';
    data['new_secretary_name'] = $('#wiz_ti_new_secretary').val() || 'YANG YUJIE';

    /* Director fields (if change_director selected) */
    if (selected.indexOf('change_director') !== -1) {
        data['new_director_name'] = $('#wiz_ti_dir_name').val() || '';
        data['new_director_id'] = $('#wiz_ti_dir_id').val() || '';
        data['new_director_nationality'] = $('#wiz_ti_dir_nationality').val() || '';
        data['new_director_address'] = $('#wiz_ti_dir_address').val() || '';
        data['is_nominee_director'] = $('#wiz_ti_dir_is_nominee').val() || 'no';
        data['removing_director'] = $('#wiz_ti_dir_removing').val() || '';
    }

    /* Extra context */
    data['additional_instructions'] = $('#wiz_ti_extra').val() || '';

    return data;
}

function doGenerate() {
    var companyId = $('#dgCompanySelect').val();
    var extraFields = collectWizFields();
    
    $('#wizLoading').show();
    $('#wizResult').hide();
    
    /* Build extra context string */
    var extra = '';
    for (var key in extraFields) {
        if (extraFields[key]) {
            extra += key.replace(/_/g, ' ') + ': ' + extraFields[key] + '\n';
        }
    }
    
    $.ajax({
        url: '<?= base_url('document_generator/generate') ?>',
        method: 'POST',
        data: {
            template_id: selectedTemplateId,
            company_id: companyId,
            extra_context: extra
        },
        dataType: 'json',
        timeout: 120000,
        success: function(res) {
            $('#wizLoading').hide();
            if (res.success) {
                $('#dgOutputContent').text(res.content);
            } else {
                $('#dgOutputContent').text('Error: ' + (res.message || 'Generation failed'));
            }
            $('#wizResult').show();
        },
        error: function(xhr, status, err) {
            $('#wizLoading').hide();
            if (status === 'timeout') {
                $('#dgOutputContent').text('Request timed out. The AI is processing a complex document — please try again. If the issue persists, try a simpler template first.');
            } else {
                $('#dgOutputContent').text('Error: Could not reach the server (HTTP ' + (xhr.status || '?') + '). Please try again.');
            }
            $('#wizResult').show();
        }
    });
}

function copyOutput() {
    var text = $('#dgOutputContent').text();
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(function() { showToast('Copied to clipboard'); });
    } else {
        var ta = document.createElement('textarea');
        ta.value = text;
        document.body.appendChild(ta);
        ta.select();
        document.execCommand('copy');
        document.body.removeChild(ta);
        showToast('Copied to clipboard');
    }
}

function printOutput() {
    var content = $('#dgOutputContent').text();
    var w = window.open('', '_blank');
    w.document.write('<html><head><title>' + selectedTemplateName + '</title><style>body{font-family:Arial,sans-serif;padding:40px;line-height:1.8;white-space:pre-wrap;font-size:13px;}h1{font-size:18px;margin-bottom:20px;}</style></head><body>');
    w.document.write('<h1>' + selectedTemplateName + '</h1>');
    w.document.write(content.replace(/</g, '&lt;').replace(/>/g, '&gt;'));
    w.document.write('</body></html>');
    w.document.close();
    w.print();
}

function showToast(msg) {
    var toast = $('<div>').text(msg).css({
        position: 'fixed', bottom: '20px', left: '50%', transform: 'translateX(-50%)',
        background: 'var(--cf-primary)', color: '#fff', padding: '8px 20px',
        borderRadius: '6px', fontSize: '13px', zIndex: 9999, boxShadow: '0 4px 12px rgba(0,0,0,0.15)'
    });
    $('body').append(toast);
    setTimeout(function() { toast.fadeOut(300, function() { toast.remove(); }); }, 2000);
}

/* Init */
$(document).ready(function() {
    filterTemplates();
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $('#dgWizard').is(':visible')) closeWizard();
    });
});
</script>
