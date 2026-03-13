<style>
/* ── Registration Page Layout ── */
.cf-reg-page { display: flex; gap: 0; height: calc(100vh - var(--cf-topbar-h) - 40px); }
.cf-reg-left { flex: 1; min-width: 0; display: flex; flex-direction: column; border-right: 1px solid var(--cf-border); }
.cf-reg-right { width: 400px; flex-shrink: 0; display: flex; flex-direction: column; background: var(--cf-white); }

/* ── Company Selector ── */
.cf-reg-selector {
    padding: 14px 20px;
    border-bottom: 1px solid var(--cf-border);
    display: flex; align-items: center; gap: 12px;
    background: var(--cf-white); flex-shrink: 0;
}
.cf-reg-selector label { font-size: 13px; font-weight: 600; color: var(--cf-text); white-space: nowrap; }
.cf-reg-selector select {
    flex: 1; padding: 8px 12px; border: 1px solid var(--cf-border); border-radius: 8px;
    font-size: 13px; color: var(--cf-text); background: var(--cf-white); outline: none;
    font-family: var(--cf-font);
}
.cf-reg-selector select:focus { border-color: var(--cf-accent); box-shadow: 0 0 0 3px rgba(79,134,198,0.1); }

/* ── Tabs ── */
.cf-reg-tabs { display: flex; border-bottom: 2px solid var(--cf-border); flex-shrink: 0; background: var(--cf-white); overflow-x: auto; }
.cf-reg-tab-group { display: flex; gap: 0; }
.cf-reg-tab-group + .cf-reg-tab-group { margin-left: auto; }
.cf-reg-tab {
    padding: 12px 18px; font-size: 12.5px; font-weight: 500; color: var(--cf-text-secondary);
    cursor: pointer; border-bottom: 2px solid transparent; margin-bottom: -2px;
    transition: color 0.15s, border-color 0.15s; white-space: nowrap;
    display: flex; align-items: center; gap: 5px; background: none;
    border-top: none; border-left: none; border-right: none;
}
.cf-reg-tab:hover { color: var(--cf-text); }
.cf-reg-tab.active { color: var(--cf-primary); border-bottom-color: var(--cf-primary); font-weight: 600; }
.cf-reg-tab.active-blue { color: #2563eb; border-bottom-color: #2563eb; font-weight: 600; }
.cf-reg-tab i { font-size: 12px; }

/* ── Tab Content ── */
.cf-reg-content { flex: 1; overflow-y: auto; padding: 24px; }
.cf-reg-tab-pane { display: none; }
.cf-reg-tab-pane.active { display: block; }

/* ── Upload Area ── */
.cf-reg-upload-area {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    min-height: 260px; background: rgba(16,185,129,0.04); border: 2px dashed var(--cf-border);
    border-radius: 12px; cursor: pointer; transition: border-color 0.2s, background 0.2s; padding: 40px;
}
.cf-reg-upload-area:hover { border-color: var(--cf-primary); background: rgba(32,101,112,0.04); }
.cf-reg-upload-icon { color: var(--cf-primary); font-size: 28px; margin-bottom: 12px; }

/* ── Info Grid ── */
.cf-reg-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 16px; }
.cf-reg-info-item { padding: 10px 14px; background: var(--cf-bg); border-radius: 8px; }
.cf-reg-info-label { font-size: 11px; font-weight: 600; color: var(--cf-text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
.cf-reg-info-value { font-size: 13px; color: var(--cf-text); font-weight: 500; word-break: break-word; }
.cf-reg-info-item.full { grid-column: 1 / -1; }

/* ── Mini Table ── */
.cf-reg-table { width: 100%; border-collapse: collapse; font-size: 12.5px; margin-top: 12px; }
.cf-reg-table th { text-align: left; font-weight: 600; color: var(--cf-text-secondary); padding: 8px 10px; border-bottom: 2px solid var(--cf-border); font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
.cf-reg-table td { padding: 8px 10px; border-bottom: 1px solid var(--cf-border); color: var(--cf-text); vertical-align: top; }
.cf-reg-table tr:last-child td { border-bottom: none; }
.cf-reg-table .status-active { color: #10b981; font-weight: 600; }
.cf-reg-table .status-ceased { color: #ef4444; font-weight: 600; }

/* ── Section Title ── */
.cf-reg-section-title { font-size: 15px; font-weight: 700; color: var(--cf-text); margin-bottom: 14px; display: flex; align-items: center; gap: 8px; }
.cf-reg-section-title i { color: var(--cf-primary); }
.cf-reg-subtitle { font-size: 12.5px; color: var(--cf-text-secondary); margin-bottom: 16px; }

/* ── Right Panel: CorpSec Tasks ── */
.cf-reg-right-header { padding: 18px 22px; border-bottom: 1px solid var(--cf-border); display: flex; align-items: center; gap: 10px; }
.cf-reg-right-header h3 { margin: 0; font-size: 15px; font-weight: 700; color: var(--cf-text); }
.cf-reg-right-header i { color: var(--cf-primary); font-size: 16px; }
.cf-reg-tasks { flex: 1; overflow-y: auto; padding: 18px 22px; display: flex; flex-direction: column; gap: 10px; }
.cf-reg-task-row { display: flex; flex-wrap: wrap; gap: 10px; }
.cf-reg-task-btn {
    display: inline-flex; align-items: center; gap: 7px; padding: 9px 16px;
    border: 1.5px solid var(--cf-border); border-radius: 22px; background: var(--cf-white);
    color: var(--cf-primary); font-size: 12.5px; font-weight: 500; cursor: pointer;
    transition: all 0.15s; white-space: nowrap;
}
.cf-reg-task-btn:hover { border-color: var(--cf-primary); background: rgba(32,101,112,0.04); }
.cf-reg-task-btn i { font-size: 13px; }

/* ── Timeline ── */
.cf-reg-timeline { margin-top: 12px; }
.cf-reg-timeline-item { display: flex; gap: 14px; padding: 12px 0; border-bottom: 1px solid var(--cf-border); }
.cf-reg-timeline-item:last-child { border-bottom: none; }
.cf-reg-timeline-dot { width: 10px; height: 10px; border-radius: 50%; background: var(--cf-primary); margin-top: 4px; flex-shrink: 0; }
.cf-reg-timeline-dot.completed { background: #10b981; }
.cf-reg-timeline-dot.pending { background: #f59e0b; }
.cf-reg-timeline-dot.rejected { background: #ef4444; }
.cf-reg-timeline-content { flex: 1; min-width: 0; }
.cf-reg-timeline-title { font-size: 13px; font-weight: 600; color: var(--cf-text); }
.cf-reg-timeline-meta { font-size: 11px; color: var(--cf-text-muted); margin-top: 2px; }
.cf-reg-timeline-desc { font-size: 12px; color: var(--cf-text-secondary); margin-top: 4px; }

/* ── Compliance Card ── */
.cf-reg-compliance-card { padding: 14px; border: 1px solid var(--cf-border); border-radius: 10px; margin-bottom: 10px; display: flex; align-items: center; gap: 14px; }
.cf-reg-compliance-icon { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; }
.cf-reg-compliance-icon.green { background: rgba(16,185,129,0.1); color: #10b981; }
.cf-reg-compliance-icon.red { background: rgba(239,68,68,0.1); color: #ef4444; }
.cf-reg-compliance-icon.yellow { background: rgba(245,158,11,0.1); color: #f59e0b; }
.cf-reg-compliance-icon.blue { background: rgba(59,130,246,0.1); color: #3b82f6; }
.cf-reg-compliance-info { flex: 1; }
.cf-reg-compliance-label { font-size: 12px; font-weight: 600; color: var(--cf-text); }
.cf-reg-compliance-date { font-size: 11px; color: var(--cf-text-muted); margin-top: 2px; }

/* ── Empty State ── */
.cf-reg-empty { text-align: center; padding: 40px 20px; color: var(--cf-text-muted); }
.cf-reg-empty i { font-size: 32px; margin-bottom: 10px; display: block; opacity: 0.3; }
.cf-reg-empty p { font-size: 13px; }

/* ── Task Modal ── */
.cf-reg-modal-overlay {
    display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 9999;
    align-items: center; justify-content: center;
}
.cf-reg-modal-overlay.open { display: flex; }
.cf-reg-modal {
    background: var(--cf-white); border-radius: 14px; width: 520px; max-width: 95vw;
    max-height: 85vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.2);
}
.cf-reg-modal-header { padding: 20px 24px; border-bottom: 1px solid var(--cf-border); display: flex; align-items: center; justify-content: space-between; }
.cf-reg-modal-header h3 { margin: 0; font-size: 16px; font-weight: 700; color: var(--cf-text); }
.cf-reg-modal-close { background: none; border: none; font-size: 20px; color: var(--cf-text-muted); cursor: pointer; padding: 4px; }
.cf-reg-modal-body { padding: 20px 24px; }
.cf-reg-modal-body label { display: block; font-size: 12px; font-weight: 600; color: var(--cf-text-secondary); margin-bottom: 5px; margin-top: 14px; }
.cf-reg-modal-body label:first-child { margin-top: 0; }
.cf-reg-modal-body input, .cf-reg-modal-body textarea, .cf-reg-modal-body select {
    width: 100%; padding: 9px 12px; border: 1px solid var(--cf-border); border-radius: 8px;
    font-size: 13px; font-family: var(--cf-font); color: var(--cf-text); outline: none;
}
.cf-reg-modal-body input:focus, .cf-reg-modal-body textarea:focus, .cf-reg-modal-body select:focus { border-color: var(--cf-accent); box-shadow: 0 0 0 3px rgba(79,134,198,0.1); }
.cf-reg-modal-body textarea { min-height: 80px; resize: vertical; }
.cf-reg-modal-footer { padding: 16px 24px; border-top: 1px solid var(--cf-border); display: flex; justify-content: flex-end; gap: 10px; }
.cf-reg-modal-footer .btn-submit {
    padding: 9px 22px; border-radius: 8px; border: none; background: var(--cf-primary);
    color: #fff; font-size: 13px; font-weight: 600; cursor: pointer;
}
.cf-reg-modal-footer .btn-cancel {
    padding: 9px 22px; border-radius: 8px; border: 1px solid var(--cf-border); background: var(--cf-white);
    color: var(--cf-text); font-size: 13px; font-weight: 500; cursor: pointer;
}

/* ── Copilot Note ── */
.cf-reg-copilot-note { padding: 12px 22px; border-bottom: 1px solid var(--cf-border); font-size: 12.5px; color: var(--cf-text); background: var(--cf-bg); }

@media (max-width: 1024px) {
    .cf-reg-page { flex-direction: column; height: auto; }
    .cf-reg-right { width: 100%; }
    .cf-reg-left { border-right: none; }
    .cf-reg-info-grid { grid-template-columns: 1fr; }
}
</style>

<div class="cf-reg-page">
    <!-- Left Panel -->
    <div class="cf-reg-left">
        <!-- Company Selector -->
        <div class="cf-reg-selector">
            <label>Company Profile</label>
            <select id="regCompanySelect" onchange="loadCompanyData()">
                <option value="">-- Select a Company --</option>
                <?php foreach (($companies ?? []) as $c): ?>
                <option value="<?= (int)$c->id ?>"><?= htmlspecialchars($c->company_name) ?> (<?= htmlspecialchars($c->acra_registration_number ?? $c->registration_number ?? '') ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Tabs -->
        <div class="cf-reg-tabs">
            <div class="cf-reg-tab-group">
                <button class="cf-reg-tab active" data-tab="basic-profile" onclick="switchRegTab(this)"><i class="fa fa-th-list"></i> Basic Profile</button>
                <button class="cf-reg-tab" data-tab="capital-structure" onclick="switchRegTab(this)"><i class="fa fa-pie-chart"></i> Capital Structure</button>
                <button class="cf-reg-tab" data-tab="stakeholders" onclick="switchRegTab(this)"><i class="fa fa-users"></i> Stakeholders</button>
                <button class="cf-reg-tab" data-tab="share-certificates" onclick="switchRegTab(this)"><i class="fa fa-certificate"></i> Share Certificates</button>
            </div>
            <div class="cf-reg-tab-group">
                <button class="cf-reg-tab" data-tab="initiate-change" onclick="switchRegTab(this)">Initiate Change</button>
                <button class="cf-reg-tab" data-tab="annual-compliance" onclick="switchRegTab(this)">Annual Compliance</button>
                <button class="cf-reg-tab" data-tab="change-history" onclick="switchRegTab(this)">Change History</button>
            </div>
        </div>

        <!-- Content -->
        <div class="cf-reg-content">
            <div class="cf-reg-tab-pane active" id="pane-basic-profile"><div id="basicProfileContent"><div class="cf-reg-empty"><i class="fa fa-building"></i><p>Select a company above to view its profile,<br>or upload a Business Profile PDF to get started.</p></div><div class="cf-reg-upload-area" onclick="document.getElementById('bizProfileUpload').click()" style="margin-top:20px"><div class="cf-reg-upload-icon"><i class="fa fa-cloud-upload"></i></div><div style="font-size:14px;font-weight:600;color:var(--cf-text)">Upload Business Profile</div><div style="font-size:12px;color:var(--cf-text-muted);margin-top:4px">PDF, JPG, PNG up to 10 MB</div></div><input type="file" id="bizProfileUpload" accept=".pdf,.jpg,.jpeg,.png" style="display:none"></div></div>
            <div class="cf-reg-tab-pane" id="pane-capital-structure"><div id="capitalContent"><div class="cf-reg-empty"><i class="fa fa-pie-chart"></i><p>Select a company to view capital structure.</p></div></div></div>
            <div class="cf-reg-tab-pane" id="pane-stakeholders"><div id="stakeholdersContent"><div class="cf-reg-empty"><i class="fa fa-users"></i><p>Select a company to view stakeholders.</p></div></div></div>
            <div class="cf-reg-tab-pane" id="pane-share-certificates"><div id="shareCertsContent"><div class="cf-reg-empty"><i class="fa fa-certificate"></i><p>Select a company to view share certificates.</p></div></div></div>
            <div class="cf-reg-tab-pane" id="pane-initiate-change"><div id="initiateChangeContent">
                <div class="cf-reg-copilot-note" style="margin:-24px -24px 20px;padding:14px 24px"><strong>Note:</strong> Please use CorpFile AI <i class="fa fa-bolt" style="color:#f59e0b"></i> to add your request, or select a task from the right panel.</div>
                <div class="cf-reg-empty"><i class="fa fa-pencil-square-o"></i><p>Select a company, then choose a task from the right panel to initiate a change.</p></div>
            </div></div>
            <div class="cf-reg-tab-pane" id="pane-annual-compliance"><div id="complianceContent"><div class="cf-reg-empty"><i class="fa fa-calendar-check-o"></i><p>Select a company to view compliance status.</p></div></div></div>
            <div class="cf-reg-tab-pane" id="pane-change-history"><div id="historyContent"><div class="cf-reg-empty"><i class="fa fa-history"></i><p>Select a company to view change history.</p></div></div></div>
        </div>
    </div>

    <!-- Right Panel: CorpSec Tasks -->
    <div class="cf-reg-right">
        <div class="cf-reg-right-header"><i class="fa fa-tasks"></i><h3>Common CorpSec Tasks</h3></div>
        <div class="cf-reg-copilot-note"><strong>Note:</strong> Select a company first, then click a task to initiate.</div>
        <div class="cf-reg-tasks">
            <div class="cf-reg-task-row"><button class="cf-reg-task-btn" onclick="openTaskModal('change_address')"><i class="fa fa-map-marker"></i> Change Registered Address</button></div>
            <div class="cf-reg-task-row"><button class="cf-reg-task-btn" onclick="openTaskModal('change_primary_activity')"><i class="fa fa-briefcase"></i> Change Primary Activity</button></div>
            <div class="cf-reg-task-row"><button class="cf-reg-task-btn" onclick="openTaskModal('change_secondary_activity')"><i class="fa fa-list"></i> Change Secondary Activity</button></div>
            <div class="cf-reg-task-row">
                <button class="cf-reg-task-btn" onclick="openTaskModal('change_name')"><i class="fa fa-building"></i> Change Company Name</button>
                <button class="cf-reg-task-btn" onclick="openTaskModal('appoint_director')"><i class="fa fa-user-plus"></i> Appoint a Director</button>
            </div>
            <div class="cf-reg-task-row">
                <button class="cf-reg-task-btn" onclick="openTaskModal('resign_director')"><i class="fa fa-user-times"></i> Resign a Director</button>
                <button class="cf-reg-task-btn" onclick="openTaskModal('appoint_auditor')"><i class="fa fa-user-plus"></i> Appoint Auditor</button>
            </div>
            <div class="cf-reg-task-row">
                <button class="cf-reg-task-btn" onclick="openTaskModal('resign_auditor')"><i class="fa fa-user-times"></i> Resign Auditor</button>
                <button class="cf-reg-task-btn" onclick="openTaskModal('add_shareholder')"><i class="fa fa-users"></i> Add Shareholder</button>
            </div>
            <div class="cf-reg-task-row">
                <button class="cf-reg-task-btn" onclick="openTaskModal('increase_capital')"><i class="fa fa-line-chart"></i> Increase Capital</button>
                <button class="cf-reg-task-btn" onclick="openTaskModal('rorc')"><i class="fa fa-list-alt"></i> RORC</button>
            </div>
            <div class="cf-reg-task-row"><button class="cf-reg-task-btn" onclick="openTaskModal('strike_off')"><i class="fa fa-times-circle"></i> Strike Off Company</button></div>
        </div>
    </div>
</div>

<!-- Task Modal -->
<div class="cf-reg-modal-overlay" id="taskModalOverlay" onclick="if(event.target===this)closeTaskModal()">
    <div class="cf-reg-modal">
        <div class="cf-reg-modal-header">
            <h3 id="taskModalTitle">Task</h3>
            <button class="cf-reg-modal-close" onclick="closeTaskModal()">&times;</button>
        </div>
        <div class="cf-reg-modal-body" id="taskModalBody"></div>
        <div class="cf-reg-modal-footer">
            <button class="btn-cancel" onclick="closeTaskModal()">Cancel</button>
            <button class="btn-submit" id="taskSubmitBtn" onclick="submitTask()">Submit Request</button>
        </div>
    </div>
</div>

<script>
var BASE = "<?= base_url() ?>";
var regData = null; // loaded company data
var currentTaskType = '';

/* ── Tab Switching ── */
function switchRegTab(btn) {
    document.querySelectorAll('.cf-reg-tab').forEach(function(t) { t.classList.remove('active','active-blue'); });
    var group = btn.closest('.cf-reg-tab-group');
    var isRight = group === group.parentElement.lastElementChild;
    btn.classList.add(isRight ? 'active-blue' : 'active');
    document.querySelectorAll('.cf-reg-tab-pane').forEach(function(p) { p.classList.remove('active'); });
    var pane = document.getElementById('pane-' + btn.getAttribute('data-tab'));
    if (pane) pane.classList.add('active');
}

/* ── Load Company Data ── */
function loadCompanyData() {
    var id = document.getElementById('regCompanySelect').value;
    if (!id) { regData = null; renderAllTabs(); return; }

    fetch(BASE + 'registration/companyData?id=' + id)
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.ok) { regData = data; renderAllTabs(); }
        else { alert(data.error || 'Failed to load company data'); }
    })
    .catch(function() { alert('Network error loading company data'); });
}

/* ── Render All Tabs ── */
function renderAllTabs() {
    renderBasicProfile();
    renderCapitalStructure();
    renderStakeholders();
    renderShareCertificates();
    renderInitiateChange();
    renderCompliance();
    renderHistory();
}

/* ── Helper functions ── */
function esc(s) { var d = document.createElement('div'); d.textContent = s || ''; return d.innerHTML; }
function fmtDate(d) { if (!d) return '-'; try { return new Date(d).toLocaleDateString('en-SG', { day: 'numeric', month: 'short', year: 'numeric' }); } catch(e) { return d; } }
function fmtMoney(n, cur) { cur = cur || 'SGD'; return cur + ' ' + Number(n || 0).toLocaleString('en-SG', { minimumFractionDigits: 2 }); }
function statusCls(s) { return (s||'').toLowerCase() === 'active' ? 'status-active' : 'status-ceased'; }

/* ── Basic Profile ── */
function renderBasicProfile() {
    var el = document.getElementById('basicProfileContent');
    if (!regData) { el.innerHTML = '<div class="cf-reg-empty"><i class="fa fa-building"></i><p>Select a company above to view its profile.</p></div><div class="cf-reg-upload-area" onclick="document.getElementById(\'bizProfileUpload\').click()" style="margin-top:20px"><div class="cf-reg-upload-icon"><i class="fa fa-cloud-upload"></i></div><div style="font-size:14px;font-weight:600">Upload Business Profile</div><div style="font-size:12px;color:var(--cf-text-muted);margin-top:4px">PDF, JPG, PNG up to 10 MB</div></div><input type="file" id="bizProfileUpload" accept=".pdf,.jpg,.jpeg,.png" style="display:none">'; return; }
    var c = regData.company;
    var addr = (regData.addresses || []).find(function(a) { return a.address_type === 'Registered Office' || a.is_default == 1; });
    var addrText = addr ? [addr.block, addr.address_text, addr.building, addr.level ? '#'+addr.level : '', addr.unit ? '-'+addr.unit : '', addr.postal_code, addr.country].filter(Boolean).join(', ') : (c.address || '-');

    el.innerHTML = '<div class="cf-reg-section-title"><i class="fa fa-building"></i> ' + esc(c.company_name) + '</div>' +
        '<div class="cf-reg-info-grid">' +
        '<div class="cf-reg-info-item"><div class="cf-reg-info-label">UEN / Registration No.</div><div class="cf-reg-info-value">' + esc(c.acra_registration_number || c.registration_number || '-') + '</div></div>' +
        '<div class="cf-reg-info-item"><div class="cf-reg-info-label">Incorporation Date</div><div class="cf-reg-info-value">' + fmtDate(c.incorporation_date) + '</div></div>' +
        '<div class="cf-reg-info-item"><div class="cf-reg-info-label">Entity Status</div><div class="cf-reg-info-value">' + esc(c.entity_status || '-') + '</div></div>' +
        '<div class="cf-reg-info-item"><div class="cf-reg-info-label">Country</div><div class="cf-reg-info-value">' + esc(c.country || 'SINGAPORE') + '</div></div>' +
        '<div class="cf-reg-info-item full"><div class="cf-reg-info-label">Registered Address</div><div class="cf-reg-info-value">' + esc(addrText) + '</div></div>' +
        '<div class="cf-reg-info-item"><div class="cf-reg-info-label">Primary Activity (SSIC)</div><div class="cf-reg-info-value">' + esc(c.activity_1 || '-') + (c.activity_1_desc_default ? ' — ' + esc(c.activity_1_desc_default) : '') + '</div></div>' +
        '<div class="cf-reg-info-item"><div class="cf-reg-info-label">Secondary Activity</div><div class="cf-reg-info-value">' + esc(c.activity_2 || '-') + (c.activity_2_desc_default ? ' — ' + esc(c.activity_2_desc_default) : '') + '</div></div>' +
        '<div class="cf-reg-info-item"><div class="cf-reg-info-label">FYE Date</div><div class="cf-reg-info-value">' + fmtDate(c.fye_date) + '</div></div>' +
        '<div class="cf-reg-info-item"><div class="cf-reg-info-label">Former Name</div><div class="cf-reg-info-value">' + esc(c.former_name || '-') + '</div></div>' +
        '<div class="cf-reg-info-item"><div class="cf-reg-info-label">Phone</div><div class="cf-reg-info-value">' + esc(c.phone1_number ? ('+' + (c.phone1_code||'65') + ' ' + c.phone1_number) : '-') + '</div></div>' +
        '<div class="cf-reg-info-item"><div class="cf-reg-info-label">Email</div><div class="cf-reg-info-value">' + esc(c.email || '-') + '</div></div>' +
        '</div>';
}

/* ── Capital Structure ── */
function renderCapitalStructure() {
    var el = document.getElementById('capitalContent');
    if (!regData) { el.innerHTML = '<div class="cf-reg-empty"><i class="fa fa-pie-chart"></i><p>Select a company to view capital structure.</p></div>'; return; }
    var c = regData.company;
    var html = '<div class="cf-reg-section-title"><i class="fa fa-pie-chart"></i> Share Capital Summary</div>' +
        '<div class="cf-reg-info-grid">' +
        '<div class="cf-reg-info-item"><div class="cf-reg-info-label">Ordinary Shares</div><div class="cf-reg-info-value">' + Number(c.no_ord_shares || 0).toLocaleString() + '</div></div>' +
        '<div class="cf-reg-info-item"><div class="cf-reg-info-label">Issued Capital (Ordinary)</div><div class="cf-reg-info-value">' + fmtMoney(c.ord_issued_share_capital, c.ord_currency) + '</div></div>' +
        '<div class="cf-reg-info-item"><div class="cf-reg-info-label">Paid-Up Capital</div><div class="cf-reg-info-value">' + fmtMoney(c.paid_up_capital, c.paid_up_capital_currency) + '</div></div>' +
        '<div class="cf-reg-info-item"><div class="cf-reg-info-label">Special Shares</div><div class="cf-reg-info-value">' + Number(c.no_spec_shares || 0).toLocaleString() + '</div></div>' +
        '</div>';

    var shares = regData.shares || [];
    if (shares.length > 0) {
        html += '<div class="cf-reg-section-title" style="margin-top:24px"><i class="fa fa-exchange"></i> Share Transactions</div>' +
            '<table class="cf-reg-table"><thead><tr><th>Date</th><th>Type</th><th>Shareholder</th><th>Shares</th><th>Amount</th></tr></thead><tbody>';
        shares.forEach(function(s) {
            html += '<tr><td>' + fmtDate(s.transaction_date) + '</td><td>' + esc(s.type || '-') + '</td><td>' + esc(s.shareholder_name || '-') + '</td><td>' + Number(s.number_of_shares || 0).toLocaleString() + '</td><td>' + fmtMoney(s.issued_share_capital, s.currency) + '</td></tr>';
        });
        html += '</tbody></table>';
    }
    el.innerHTML = html;
}

/* ── Stakeholders ── */
function renderStakeholders() {
    var el = document.getElementById('stakeholdersContent');
    if (!regData) { el.innerHTML = '<div class="cf-reg-empty"><i class="fa fa-users"></i><p>Select a company to view stakeholders.</p></div>'; return; }

    function officerTable(title, icon, list, dateField) {
        dateField = dateField || 'date_of_appointment';
        if (!list || list.length === 0) return '<div class="cf-reg-section-title"><i class="fa fa-' + icon + '"></i> ' + title + '</div><p style="color:var(--cf-text-muted);font-size:12.5px;margin-bottom:20px">No ' + title.toLowerCase() + ' on record.</p>';
        var h = '<div class="cf-reg-section-title"><i class="fa fa-' + icon + '"></i> ' + title + ' <span style="font-size:12px;color:var(--cf-text-muted);font-weight:400">(' + list.length + ')</span></div>' +
            '<table class="cf-reg-table"><thead><tr><th>Name</th><th>ID No.</th><th>Nationality</th><th>Appointed</th><th>Status</th></tr></thead><tbody>';
        list.forEach(function(p) {
            h += '<tr><td><strong>' + esc(p.name) + '</strong>' + (p.email ? '<br><span style="font-size:11px;color:var(--cf-text-muted)">' + esc(p.email) + '</span>' : '') + '</td>' +
                '<td style="font-family:monospace;font-size:11.5px">' + esc(p.id_number || '-') + '</td>' +
                '<td>' + esc(p.nationality || '-') + '</td>' +
                '<td>' + fmtDate(p[dateField] || p.date_of_appointment || p.appointment_date) + '</td>' +
                '<td><span class="' + statusCls(p.status) + '">' + esc(p.status || 'Active') + '</span></td></tr>';
        });
        h += '</tbody></table><div style="margin-bottom:24px"></div>';
        return h;
    }

    el.innerHTML =
        officerTable('Directors', 'user-secret', regData.directors, 'date_of_appointment') +
        officerTable('Shareholders', 'users', regData.shareholders, 'date_of_appointment') +
        officerTable('Secretaries', 'user', regData.secretaries, 'date_of_appointment') +
        officerTable('Auditors', 'search', regData.auditors, 'date_of_appointment');
}

/* ── Share Certificates ── */
function renderShareCertificates() {
    var el = document.getElementById('shareCertsContent');
    if (!regData) { el.innerHTML = '<div class="cf-reg-empty"><i class="fa fa-certificate"></i><p>Select a company to view share certificates.</p></div>'; return; }
    var shares = regData.shares || [];
    if (shares.length === 0) { el.innerHTML = '<div class="cf-reg-empty"><i class="fa fa-certificate"></i><p>No share certificate records for this company.</p></div>'; return; }
    var html = '<div class="cf-reg-section-title"><i class="fa fa-certificate"></i> Share Certificate Register</div>' +
        '<table class="cf-reg-table"><thead><tr><th>Cert #</th><th>Shareholder</th><th>Share Type</th><th>No. of Shares</th><th>Date</th></tr></thead><tbody>';
    shares.forEach(function(s, i) {
        html += '<tr><td>SC-' + String(i + 1).padStart(3, '0') + '</td><td>' + esc(s.shareholder_name || '-') + '</td><td>' + esc(s.share_type || 'Ordinary') + '</td><td>' + Number(s.number_of_shares || 0).toLocaleString() + '</td><td>' + fmtDate(s.transaction_date) + '</td></tr>';
    });
    html += '</tbody></table>';
    el.innerHTML = html;
}

/* ── Initiate Change ── */
function renderInitiateChange() {
    var el = document.getElementById('initiateChangeContent');
    if (!regData) {
        el.innerHTML = '<div class="cf-reg-copilot-note" style="margin:-24px -24px 20px;padding:14px 24px"><strong>Note:</strong> Please use CorpFile AI <i class="fa fa-bolt" style="color:#f59e0b"></i> to add your request.</div><div class="cf-reg-empty"><i class="fa fa-pencil-square-o"></i><p>Select a company, then choose a task from the right panel.</p></div>';
        return;
    }
    var cr = regData.change_requests || [];
    var pending = cr.filter(function(r) { return r.status === 'pending' || r.status === 'in_progress' || r.status === 'draft'; });
    var html = '<div class="cf-reg-copilot-note" style="margin:-24px -24px 20px;padding:14px 24px"><strong>Note:</strong> Select a task from the right panel, or use CorpFile AI <i class="fa fa-bolt" style="color:#f59e0b"></i> to describe your request.</div>';

    if (pending.length > 0) {
        html += '<div class="cf-reg-section-title"><i class="fa fa-clock-o"></i> Pending Requests (' + pending.length + ')</div>';
        pending.forEach(function(r) {
            html += '<div class="cf-reg-compliance-card"><div class="cf-reg-compliance-icon yellow"><i class="fa fa-clock-o"></i></div><div class="cf-reg-compliance-info"><div class="cf-reg-compliance-label">' + esc(r.title) + '</div><div class="cf-reg-compliance-date">Status: ' + esc(r.status) + ' &middot; ' + fmtDate(r.created_at) + '</div></div></div>';
        });
    } else {
        html += '<div class="cf-reg-empty" style="padding:30px"><i class="fa fa-check-circle" style="color:#10b981"></i><p>No pending change requests.<br>Click a task on the right to start one.</p></div>';
    }
    el.innerHTML = html;
}

/* ── Annual Compliance ── */
function renderCompliance() {
    var el = document.getElementById('complianceContent');
    if (!regData) { el.innerHTML = '<div class="cf-reg-empty"><i class="fa fa-calendar-check-o"></i><p>Select a company to view compliance status.</p></div>'; return; }
    var c = regData.company;
    var html = '<div class="cf-reg-section-title"><i class="fa fa-calendar-check-o"></i> Compliance Overview</div>';

    // Key dates from company record
    var items = [
        { label: 'Financial Year End (FYE)', date: c.fye_date, icon: 'calendar' },
        { label: 'Next AGM Due', date: c.next_agm_due, icon: 'gavel' },
        { label: 'Last AGM Held', date: c.date_of_agm, icon: 'check' },
        { label: 'Annual Return Filed', date: c.last_ar_filing || c.date_of_ar, icon: 'file-text' },
    ];
    items.forEach(function(item) {
        var tone = 'blue';
        if (item.date) {
            var diff = (new Date(item.date) - new Date()) / 86400000;
            if (diff < 0) tone = 'red';
            else if (diff < 30) tone = 'yellow';
            else tone = 'green';
        }
        html += '<div class="cf-reg-compliance-card"><div class="cf-reg-compliance-icon ' + tone + '"><i class="fa fa-' + item.icon + '"></i></div><div class="cf-reg-compliance-info"><div class="cf-reg-compliance-label">' + item.label + '</div><div class="cf-reg-compliance-date">' + fmtDate(item.date) + '</div></div></div>';
    });

    // Due dates table
    var dd = regData.due_dates || [];
    if (dd.length > 0) {
        html += '<div class="cf-reg-section-title" style="margin-top:20px"><i class="fa fa-clock-o"></i> Upcoming Due Dates</div>' +
            '<table class="cf-reg-table"><thead><tr><th>Event</th><th>Due Date</th><th>Status</th><th>PIC</th></tr></thead><tbody>';
        dd.forEach(function(d) {
            html += '<tr><td>' + esc(d.event_name) + '</td><td>' + fmtDate(d.due_date) + '</td><td><span class="' + (d.status === 'Completed' ? 'status-active' : '') + '">' + esc(d.status) + '</span></td><td>' + esc(d.pic || '-') + '</td></tr>';
        });
        html += '</tbody></table>';
    }

    // Events
    var ev = regData.events || [];
    if (ev.length > 0) {
        html += '<div class="cf-reg-section-title" style="margin-top:20px"><i class="fa fa-list"></i> Event Records</div>' +
            '<table class="cf-reg-table"><thead><tr><th>FYE Year</th><th>AGM Due</th><th>AGM Held</th><th>AR Due</th><th>AR Filed</th><th>Status</th></tr></thead><tbody>';
        ev.forEach(function(e) {
            html += '<tr><td>' + esc(e.fye_year || '-') + '</td><td>' + fmtDate(e.agm_due_date) + '</td><td>' + fmtDate(e.agm_held_date) + '</td><td>' + fmtDate(e.ar_due_date) + '</td><td>' + fmtDate(e.ar_filing_date) + '</td><td>' + esc(e.status) + '</td></tr>';
        });
        html += '</tbody></table>';
    }
    el.innerHTML = html;
}

/* ── Change History ── */
function renderHistory() {
    var el = document.getElementById('historyContent');
    if (!regData) { el.innerHTML = '<div class="cf-reg-empty"><i class="fa fa-history"></i><p>Select a company to view change history.</p></div>'; return; }
    var cr = regData.change_requests || [];
    var logs = regData.logs || [];

    if (cr.length === 0 && logs.length === 0) {
        el.innerHTML = '<div class="cf-reg-empty"><i class="fa fa-history"></i><p>No change history recorded for this company.</p></div>';
        return;
    }

    var html = '<div class="cf-reg-section-title"><i class="fa fa-history"></i> Change History</div><div class="cf-reg-timeline">';

    // Change requests
    cr.forEach(function(r) {
        var dotCls = r.status === 'completed' ? 'completed' : (r.status === 'rejected' || r.status === 'cancelled' ? 'rejected' : 'pending');
        html += '<div class="cf-reg-timeline-item"><div class="cf-reg-timeline-dot ' + dotCls + '"></div><div class="cf-reg-timeline-content"><div class="cf-reg-timeline-title">' + esc(r.title) + '</div><div class="cf-reg-timeline-meta">' + fmtDate(r.created_at) + ' &middot; ' + esc(r.status) + (r.requested_by_name ? ' &middot; by ' + esc(r.requested_by_name) : '') + '</div>' + (r.description ? '<div class="cf-reg-timeline-desc">' + esc(r.description) + '</div>' : '') + '</div></div>';
    });

    // User logs
    logs.forEach(function(l) {
        html += '<div class="cf-reg-timeline-item"><div class="cf-reg-timeline-dot"></div><div class="cf-reg-timeline-content"><div class="cf-reg-timeline-title">' + esc(l.action || 'Update') + ' — ' + esc(l.module || '') + '</div><div class="cf-reg-timeline-meta">' + fmtDate(l.created_at) + (l.user_name ? ' &middot; by ' + esc(l.user_name) : '') + '</div>' + (l.remarks ? '<div class="cf-reg-timeline-desc">' + esc(l.remarks) + '</div>' : '') + '</div></div>';
    });

    html += '</div>';
    el.innerHTML = html;
}

/* ── Task Modal ── */
var TASK_FORMS = {
    change_address: { title: 'Change Registered Address', fields: [
        { name: 'new_address', label: 'New Registered Address', type: 'textarea', placeholder: 'Enter the full new registered address' },
        { name: 'effective_date', label: 'Effective Date', type: 'date' },
        { name: 'remarks', label: 'Remarks', type: 'textarea', placeholder: 'Any additional notes' }
    ]},
    change_primary_activity: { title: 'Change Primary Activity', fields: [
        { name: 'new_ssic_code', label: 'New SSIC Code', type: 'text', placeholder: 'e.g. 62011' },
        { name: 'new_description', label: 'Activity Description', type: 'text', placeholder: 'e.g. Software Development' },
        { name: 'effective_date', label: 'Effective Date', type: 'date' },
        { name: 'remarks', label: 'Remarks', type: 'textarea' }
    ]},
    change_secondary_activity: { title: 'Change Secondary Activity', fields: [
        { name: 'new_ssic_code', label: 'New SSIC Code', type: 'text', placeholder: 'e.g. 62021' },
        { name: 'new_description', label: 'Activity Description', type: 'text' },
        { name: 'effective_date', label: 'Effective Date', type: 'date' },
        { name: 'remarks', label: 'Remarks', type: 'textarea' }
    ]},
    change_name: { title: 'Change Company Name', fields: [
        { name: 'new_name', label: 'Proposed New Company Name', type: 'text', placeholder: 'Enter proposed new name' },
        { name: 'alt_name', label: 'Alternative Name (if rejected)', type: 'text' },
        { name: 'effective_date', label: 'Effective Date', type: 'date' },
        { name: 'remarks', label: 'Reason for Name Change', type: 'textarea' }
    ]},
    appoint_director: { title: 'Appoint a Director', fields: [
        { name: 'director_name', label: 'Full Name', type: 'text', placeholder: 'As per NRIC/Passport' },
        { name: 'id_type', label: 'ID Type', type: 'select', options: ['NRIC','FIN','Passport'] },
        { name: 'id_number', label: 'ID Number', type: 'text' },
        { name: 'nationality', label: 'Nationality', type: 'text', placeholder: 'e.g. SINGAPOREAN' },
        { name: 'address', label: 'Residential Address', type: 'textarea' },
        { name: 'appointment_date', label: 'Date of Appointment', type: 'date' },
        { name: 'remarks', label: 'Remarks', type: 'textarea' }
    ]},
    resign_director: { title: 'Resign a Director', fields: [
        { name: 'director_name', label: 'Director Name', type: 'text', placeholder: 'Name of the resigning director' },
        { name: 'cessation_date', label: 'Date of Cessation', type: 'date' },
        { name: 'reason', label: 'Reason for Resignation', type: 'textarea' }
    ]},
    appoint_auditor: { title: 'Appoint Auditor', fields: [
        { name: 'auditor_name', label: 'Auditor / Firm Name', type: 'text' },
        { name: 'registration_number', label: 'Registration Number', type: 'text' },
        { name: 'address', label: 'Auditor Address', type: 'textarea' },
        { name: 'appointment_date', label: 'Date of Appointment', type: 'date' }
    ]},
    resign_auditor: { title: 'Resign Auditor', fields: [
        { name: 'auditor_name', label: 'Auditor / Firm Name', type: 'text' },
        { name: 'cessation_date', label: 'Date of Cessation', type: 'date' },
        { name: 'reason', label: 'Reason', type: 'textarea' }
    ]},
    add_shareholder: { title: 'Add Shareholder', fields: [
        { name: 'shareholder_name', label: 'Full Name', type: 'text' },
        { name: 'shareholder_type', label: 'Type', type: 'select', options: ['Individual','Corporate'] },
        { name: 'id_number', label: 'ID / Registration Number', type: 'text' },
        { name: 'nationality', label: 'Nationality / Country', type: 'text' },
        { name: 'num_shares', label: 'Number of Shares', type: 'text', placeholder: 'e.g. 1000' },
        { name: 'share_type', label: 'Share Type', type: 'select', options: ['Ordinary','Preference'] },
        { name: 'appointment_date', label: 'Date of Appointment', type: 'date' }
    ]},
    increase_capital: { title: 'Increase Share Capital', fields: [
        { name: 'new_shares', label: 'Number of New Shares', type: 'text', placeholder: 'e.g. 10000' },
        { name: 'share_type', label: 'Share Type', type: 'select', options: ['Ordinary','Preference'] },
        { name: 'price_per_share', label: 'Price Per Share', type: 'text', placeholder: 'e.g. 1.00' },
        { name: 'currency', label: 'Currency', type: 'select', options: ['SGD','USD','EUR','GBP','MYR','HKD'] },
        { name: 'effective_date', label: 'Effective Date', type: 'date' },
        { name: 'remarks', label: 'Remarks', type: 'textarea' }
    ]},
    rorc: { title: 'Register of Registrable Controllers (RORC)', fields: [
        { name: 'controller_name', label: 'Controller Name', type: 'text' },
        { name: 'id_number', label: 'ID / Registration Number', type: 'text' },
        { name: 'nationality', label: 'Nationality / Country', type: 'text' },
        { name: 'address', label: 'Address', type: 'textarea' },
        { name: 'date_registered', label: 'Date Registered as Controller', type: 'date' },
        { name: 'remarks', label: 'Remarks', type: 'textarea' }
    ]},
    strike_off: { title: 'Strike Off Company', fields: [
        { name: 'reason', label: 'Reason for Strike Off', type: 'textarea', placeholder: 'e.g. Company ceased operations' },
        { name: 'proposed_date', label: 'Proposed Strike Off Date', type: 'date' },
        { name: 'confirmation', label: 'Confirm all debts are settled?', type: 'select', options: ['Yes','No'] },
        { name: 'remarks', label: 'Additional Remarks', type: 'textarea' }
    ]}
};

function openTaskModal(taskType) {
    var companyId = document.getElementById('regCompanySelect').value;
    if (!companyId) { alert('Please select a company first.'); return; }

    currentTaskType = taskType;
    var form = TASK_FORMS[taskType];
    if (!form) { alert('Unknown task type'); return; }

    document.getElementById('taskModalTitle').textContent = form.title;
    var body = '';
    form.fields.forEach(function(f) {
        body += '<label>' + f.label + '</label>';
        if (f.type === 'textarea') {
            body += '<textarea name="' + f.name + '" placeholder="' + (f.placeholder || '') + '"></textarea>';
        } else if (f.type === 'select') {
            body += '<select name="' + f.name + '">' + (f.options || []).map(function(o) { return '<option value="' + o + '">' + o + '</option>'; }).join('') + '</select>';
        } else {
            body += '<input type="' + f.type + '" name="' + f.name + '" placeholder="' + (f.placeholder || '') + '">';
        }
    });
    document.getElementById('taskModalBody').innerHTML = body;
    document.getElementById('taskModalOverlay').classList.add('open');
}

function closeTaskModal() {
    document.getElementById('taskModalOverlay').classList.remove('open');
    currentTaskType = '';
}

function submitTask() {
    var companyId = document.getElementById('regCompanySelect').value;
    if (!companyId || !currentTaskType) return;

    var form = TASK_FORMS[currentTaskType];
    var formData = {};
    form.fields.forEach(function(f) {
        var el = document.querySelector('#taskModalBody [name="' + f.name + '"]');
        if (el) formData[f.name] = el.value;
    });

    document.getElementById('taskSubmitBtn').textContent = 'Submitting...';
    document.getElementById('taskSubmitBtn').disabled = true;

    fetch(BASE + 'registration/submitChange', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            company_id: parseInt(companyId),
            change_type: currentTaskType,
            title: form.title,
            description: formData.remarks || formData.reason || '',
            form_data: formData,
            priority: 'normal'
        })
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        document.getElementById('taskSubmitBtn').textContent = 'Submit Request';
        document.getElementById('taskSubmitBtn').disabled = false;
        if (data.ok) {
            closeTaskModal();
            alert('Change request submitted successfully! ID: #' + data.id);
            loadCompanyData(); // Refresh to show the new request
        } else {
            alert(data.error || 'Failed to submit request');
        }
    })
    .catch(function() {
        document.getElementById('taskSubmitBtn').textContent = 'Submit Request';
        document.getElementById('taskSubmitBtn').disabled = false;
        alert('Network error. Please try again.');
    });
}
</script>
