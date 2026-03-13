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

<!-- ═══════ Generation Panel (slides in) ═══════ -->
<div class="dg-gen-overlay" id="dgGenOverlay" style="display:none;" onclick="closeGenPanel()"></div>
<div class="dg-gen-panel" id="dgGenPanel">
    <div class="dg-gen-header">
        <button class="btn btn-default btn-sm" onclick="closeGenPanel()" style="border:none; padding:4px 8px;"><i class="fa fa-arrow-left"></i></button>
        <h4 id="dgGenTitle" style="margin:0; font-size:15px; font-weight:600; flex:1;">Generate Document</h4>
        <button class="btn btn-default btn-sm" onclick="closeGenPanel()" style="border:none; padding:4px 8px;"><i class="fa fa-times"></i></button>
    </div>
    <div class="dg-gen-body">
        <div class="form-group">
            <label style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase; letter-spacing:0.5px;">Select Company</label>
            <select class="form-control" id="dgCompanySelect">
                <option value="">-- Select a company --</option>
                <?php foreach ($companies as $c): ?>
                <option value="<?= $c->id ?>"><?= htmlspecialchars($c->company_name) ?> (<?= htmlspecialchars($c->registration_number ?? '') ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <button class="btn btn-primary btn-block" id="dgGenerateBtn" onclick="generateDocument()" style="border-radius:var(--cf-radius-sm); padding:10px; font-weight:600;">
            <i class="fa fa-magic" style="margin-right:6px;"></i> Generate Document
        </button>

        <!-- Output -->
        <div id="dgOutput" style="display:none; margin-top:16px;">
            <div class="dg-output-toolbar">
                <span style="font-size:12px; font-weight:600; color:var(--cf-text-secondary); text-transform:uppercase;">Generated Document</span>
                <div style="display:flex; gap:6px;">
                    <button class="btn btn-default btn-xs" onclick="copyOutput()" title="Copy to clipboard"><i class="fa fa-copy"></i> Copy</button>
                    <button class="btn btn-default btn-xs" onclick="printOutput()" title="Print"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
            <div id="dgOutputContent" class="dg-output-content"></div>
        </div>

        <!-- Loading state -->
        <div id="dgLoading" style="display:none; text-align:center; padding:40px 0;">
            <div class="dg-spinner"></div>
            <p style="margin-top:12px; color:var(--cf-text-secondary); font-size:13px;">Generating document with AI...</p>
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

/* Generation Panel */
.dg-gen-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.25);
    z-index: 1040;
}
.dg-gen-panel {
    position: fixed;
    top: 0;
    right: -500px;
    width: 500px;
    max-width: 90vw;
    height: 100vh;
    background: var(--cf-white);
    box-shadow: -4px 0 24px rgba(0,0,0,0.12);
    z-index: 1050;
    display: flex;
    flex-direction: column;
    transition: right 0.3s ease;
}
.dg-gen-panel.open { right: 0; }
.dg-gen-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 16px;
    border-bottom: 1px solid var(--cf-border);
    flex-shrink: 0;
}
.dg-gen-body {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
}

/* Output */
.dg-output-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}
.dg-output-content {
    background: var(--cf-bg);
    border: 1px solid var(--cf-border);
    border-radius: var(--cf-radius-sm);
    padding: 16px;
    font-size: 13px;
    line-height: 1.7;
    white-space: pre-wrap;
    max-height: calc(100vh - 320px);
    overflow-y: auto;
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

function selectTemplate(id, el) {
    selectedTemplateId = id;
    /* Highlight card */
    $('.dg-card').removeClass('selected');
    $(el).addClass('selected');
    /* Set title */
    var name = $(el).find('.dg-card-name').text();
    $('#dgGenTitle').text('Generate: ' + name);
    /* Reset output */
    $('#dgOutput').hide();
    $('#dgLoading').hide();
    /* Open panel */
    openGenPanel();
}

function openReport(id) {
    var url = reportUrls[id];
    if (url) {
        window.location.href = url;
    }
}

function openGenPanel() {
    $('#dgGenOverlay').show();
    setTimeout(function() {
        $('#dgGenPanel').addClass('open');
    }, 10);
}

function closeGenPanel() {
    $('#dgGenPanel').removeClass('open');
    setTimeout(function() {
        $('#dgGenOverlay').hide();
    }, 300);
}

function generateDocument() {
    if (!selectedTemplateId) return;
    var companyId = $('#dgCompanySelect').val();
    
    var btn = $('#dgGenerateBtn');
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Generating...');
    $('#dgOutput').hide();
    $('#dgLoading').show();
    
    $.ajax({
        url: '<?= base_url('document_generator/generate') ?>',
        method: 'POST',
        data: {
            template_id: selectedTemplateId,
            company_id: companyId
        },
        dataType: 'json',
        success: function(res) {
            $('#dgLoading').hide();
            if (res.success) {
                $('#dgOutputContent').text(res.content);
                $('#dgOutput').show();
            } else {
                $('#dgOutputContent').text('Error: ' + (res.message || 'Generation failed'));
                $('#dgOutput').show();
            }
        },
        error: function() {
            $('#dgLoading').hide();
            $('#dgOutputContent').text('Error: Could not reach the server. Please try again.');
            $('#dgOutput').show();
        },
        complete: function() {
            btn.prop('disabled', false).html('<i class="fa fa-magic" style="margin-right:6px;"></i> Generate Document');
        }
    });
}

function copyOutput() {
    var text = $('#dgOutputContent').text();
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(function() {
            showToast('Copied to clipboard');
        });
    } else {
        /* Fallback */
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
    var title = $('#dgGenTitle').text();
    var w = window.open('', '_blank');
    w.document.write('<html><head><title>' + title + '</title><style>body{font-family:Arial,sans-serif;padding:40px;line-height:1.8;white-space:pre-wrap;font-size:13px;}h1{font-size:18px;margin-bottom:20px;}</style></head><body>');
    w.document.write('<h1>' + title + '</h1>');
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
    /* Close panel on Escape */
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') closeGenPanel();
    });
});
</script>
