<style>
/* ── Registration Page Layout ── */
.cf-reg-page { display: flex; gap: 0; height: calc(100vh - var(--cf-topbar-h) - 40px); }
.cf-reg-left { flex: 1; min-width: 0; display: flex; flex-direction: column; border-right: 1px solid var(--cf-border); }
.cf-reg-right { width: 420px; flex-shrink: 0; display: flex; flex-direction: column; background: var(--cf-white); }

/* ── Top Tabs ── */
.cf-reg-tabs { display: flex; border-bottom: 2px solid var(--cf-border); flex-shrink: 0; background: var(--cf-white); }
.cf-reg-tab-group { display: flex; gap: 0; }
.cf-reg-tab-group + .cf-reg-tab-group { margin-left: auto; }
.cf-reg-tab {
    padding: 14px 20px;
    font-size: 13px;
    font-weight: 500;
    color: var(--cf-text-secondary);
    cursor: pointer;
    border-bottom: 2px solid transparent;
    margin-bottom: -2px;
    transition: color 0.15s, border-color 0.15s;
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 6px;
    background: none;
    border-top: none;
    border-left: none;
    border-right: none;
}
.cf-reg-tab:hover { color: var(--cf-text); }
.cf-reg-tab.active { color: var(--cf-primary); border-bottom-color: var(--cf-primary); font-weight: 600; }
.cf-reg-tab.active-blue { color: #2563eb; border-bottom-color: #2563eb; font-weight: 600; }
.cf-reg-tab i { font-size: 13px; }

/* ── Tab Content ── */
.cf-reg-content { flex: 1; overflow-y: auto; padding: 28px; }
.cf-reg-tab-pane { display: none; }
.cf-reg-tab-pane.active { display: block; }

/* ── Upload Area ── */
.cf-reg-upload-area {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 300px;
    background: rgba(16,185,129,0.04);
    border: 2px dashed var(--cf-border);
    border-radius: 12px;
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
    padding: 40px;
}
.cf-reg-upload-area:hover { border-color: var(--cf-primary); background: rgba(32,101,112,0.04); }
.cf-reg-upload-icon {
    width: 48px; height: 48px;
    display: flex; align-items: center; justify-content: center;
    color: var(--cf-primary);
    font-size: 24px;
    margin-bottom: 12px;
}
.cf-reg-upload-text { font-size: 15px; font-weight: 600; color: var(--cf-text); margin-bottom: 6px; }
.cf-reg-upload-sub { font-size: 12px; color: var(--cf-text-muted); }

/* ── Right Panel: CorpSec Tasks ── */
.cf-reg-right-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--cf-border);
    display: flex;
    align-items: center;
    gap: 10px;
}
.cf-reg-right-header h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: var(--cf-text);
}
.cf-reg-right-header i { color: var(--cf-primary); font-size: 18px; }

.cf-reg-tasks {
    flex: 1;
    overflow-y: auto;
    padding: 20px 24px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.cf-reg-task-row {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}
.cf-reg-task-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    border: 1.5px solid var(--cf-border);
    border-radius: 24px;
    background: var(--cf-white);
    color: var(--cf-primary);
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
}
.cf-reg-task-btn:hover {
    border-color: var(--cf-primary);
    background: rgba(32,101,112,0.04);
    box-shadow: 0 1px 4px rgba(32,101,112,0.10);
}
.cf-reg-task-btn i { font-size: 14px; }

/* ── Right Panel: Copilot Note ── */
.cf-reg-copilot-note {
    padding: 16px 24px;
    border-bottom: 1px solid var(--cf-border);
    font-size: 13px;
    color: var(--cf-text);
    background: var(--cf-bg);
    display: flex;
    align-items: center;
    gap: 6px;
}
.cf-reg-copilot-note strong { font-weight: 600; }

/* ── Responsive ── */
@media (max-width: 1024px) {
    .cf-reg-page { flex-direction: column; height: auto; }
    .cf-reg-right { width: 100%; border-top: 1px solid var(--cf-border); }
    .cf-reg-left { border-right: none; }
}
</style>

<div class="cf-reg-page">
    <!-- Left: Company Profile with Tabs -->
    <div class="cf-reg-left">
        <div class="cf-reg-tabs">
            <!-- Left tab group -->
            <div class="cf-reg-tab-group">
                <button class="cf-reg-tab active" data-tab="basic-profile" onclick="switchRegTab(this)">
                    <i class="fa fa-th-list"></i> Basic Profile
                </button>
                <button class="cf-reg-tab" data-tab="capital-structure" onclick="switchRegTab(this)">
                    <i class="fa fa-pie-chart"></i> Capital Structure
                </button>
                <button class="cf-reg-tab" data-tab="stakeholders" onclick="switchRegTab(this)">
                    <i class="fa fa-users"></i> Stakeholders
                </button>
                <button class="cf-reg-tab" data-tab="share-certificates" onclick="switchRegTab(this)">
                    <i class="fa fa-certificate"></i> Share Certificates
                </button>
            </div>
            <!-- Right tab group -->
            <div class="cf-reg-tab-group">
                <button class="cf-reg-tab active-blue" data-tab="initiate-change" onclick="switchRegTab(this)">
                    Initiate Change
                </button>
                <button class="cf-reg-tab" data-tab="annual-compliance" onclick="switchRegTab(this)">
                    Annual Compliance
                </button>
                <button class="cf-reg-tab" data-tab="change-history" onclick="switchRegTab(this)">
                    Change History
                </button>
            </div>
        </div>

        <div class="cf-reg-content">
            <!-- Basic Profile -->
            <div class="cf-reg-tab-pane active" id="pane-basic-profile">
                <h3 style="margin-bottom:20px; font-size:15px; font-weight:600; color:var(--cf-text);">Get started by uploading the Business Profile</h3>
                <div class="cf-reg-upload-area" onclick="document.getElementById('bizProfileUpload').click()">
                    <div class="cf-reg-upload-icon"><i class="fa fa-cloud-upload"></i></div>
                    <div class="cf-reg-upload-text">Click to upload or drag & drop</div>
                    <div class="cf-reg-upload-sub">PDF, JPG, PNG up to 10 MB</div>
                </div>
                <input type="file" id="bizProfileUpload" accept=".pdf,.jpg,.jpeg,.png" style="display:none">
            </div>

            <!-- Capital Structure -->
            <div class="cf-reg-tab-pane" id="pane-capital-structure">
                <h3 style="margin-bottom:16px; font-size:15px; font-weight:600; color:var(--cf-text);">Capital Structure</h3>
                <p style="color:var(--cf-text-secondary); font-size:13px;">Share capital details, classes of shares, and allotment records will appear here once the company profile is loaded.</p>
            </div>

            <!-- Stakeholders -->
            <div class="cf-reg-tab-pane" id="pane-stakeholders">
                <h3 style="margin-bottom:16px; font-size:15px; font-weight:600; color:var(--cf-text);">Stakeholders</h3>
                <p style="color:var(--cf-text-secondary); font-size:13px;">Directors, shareholders, secretaries, and auditors for the selected company will be listed here.</p>
            </div>

            <!-- Share Certificates -->
            <div class="cf-reg-tab-pane" id="pane-share-certificates">
                <h3 style="margin-bottom:16px; font-size:15px; font-weight:600; color:var(--cf-text);">Share Certificates</h3>
                <p style="color:var(--cf-text-secondary); font-size:13px;">Share certificate records and issuance history will appear here.</p>
            </div>

            <!-- Initiate Change -->
            <div class="cf-reg-tab-pane" id="pane-initiate-change">
                <div class="cf-reg-copilot-note" style="margin:-28px -28px 24px -28px; padding:16px 28px;">
                    <strong>Note:</strong> Please use CorpFile AI <i class="fa fa-bolt" style="color:#f59e0b;"></i> to add your request
                </div>
                <h3 style="margin-bottom:16px; font-size:15px; font-weight:600; color:var(--cf-text);">Select a change to initiate</h3>
                <p style="color:var(--cf-text-secondary); font-size:13px;">Choose from common corporate secretarial changes below, or use the AI assistant to describe your request.</p>
            </div>

            <!-- Annual Compliance -->
            <div class="cf-reg-tab-pane" id="pane-annual-compliance">
                <h3 style="margin-bottom:16px; font-size:15px; font-weight:600; color:var(--cf-text);">Annual Compliance</h3>
                <p style="color:var(--cf-text-secondary); font-size:13px;">AGM due dates, annual return filing status, and financial year-end tracking for the selected company.</p>
            </div>

            <!-- Change History -->
            <div class="cf-reg-tab-pane" id="pane-change-history">
                <h3 style="margin-bottom:16px; font-size:15px; font-weight:600; color:var(--cf-text);">Change History</h3>
                <p style="color:var(--cf-text-secondary); font-size:13px;">A chronological log of all corporate changes filed for this company.</p>
            </div>
        </div>
    </div>

    <!-- Right: Common CorpSec Tasks -->
    <div class="cf-reg-right">
        <div class="cf-reg-right-header">
            <i class="fa fa-tasks"></i>
            <h3>Common CorpSec Tasks</h3>
        </div>
        <div class="cf-reg-tasks">
            <div class="cf-reg-task-row">
                <button class="cf-reg-task-btn" onclick="startCorpSecTask('Change Registered Address')">
                    <i class="fa fa-map-marker"></i> Change Registered Address
                </button>
            </div>
            <div class="cf-reg-task-row">
                <button class="cf-reg-task-btn" onclick="startCorpSecTask('Change Primary Activity')">
                    <i class="fa fa-briefcase"></i> Change Primary Activity
                </button>
            </div>
            <div class="cf-reg-task-row">
                <button class="cf-reg-task-btn" onclick="startCorpSecTask('Change Secondary Activity')">
                    <i class="fa fa-list"></i> Change Secondary Activity
                </button>
            </div>
            <div class="cf-reg-task-row">
                <button class="cf-reg-task-btn" onclick="startCorpSecTask('Change Company Name')">
                    <i class="fa fa-building"></i> Change Company Name
                </button>
                <button class="cf-reg-task-btn" onclick="startCorpSecTask('Appoint a Director')">
                    <i class="fa fa-user-plus"></i> Appoint a Director
                </button>
            </div>
            <div class="cf-reg-task-row">
                <button class="cf-reg-task-btn" onclick="startCorpSecTask('Resign a Director')">
                    <i class="fa fa-user-times"></i> Resign a Director
                </button>
                <button class="cf-reg-task-btn" onclick="startCorpSecTask('Appoint Auditor')">
                    <i class="fa fa-user-plus"></i> Appoint Auditor
                </button>
            </div>
            <div class="cf-reg-task-row">
                <button class="cf-reg-task-btn" onclick="startCorpSecTask('Resign Auditor')">
                    <i class="fa fa-user-times"></i> Resign Auditor
                </button>
                <button class="cf-reg-task-btn" onclick="startCorpSecTask('Add Shareholder')">
                    <i class="fa fa-users"></i> Add Shareholder
                </button>
            </div>
            <div class="cf-reg-task-row">
                <button class="cf-reg-task-btn" onclick="startCorpSecTask('Increase Capital')">
                    <i class="fa fa-line-chart"></i> Increase Capital
                </button>
                <button class="cf-reg-task-btn" onclick="startCorpSecTask('RORC')">
                    <i class="fa fa-list-alt"></i> RORC
                </button>
            </div>
            <div class="cf-reg-task-row">
                <button class="cf-reg-task-btn" onclick="startCorpSecTask('Strike Off Company')">
                    <i class="fa fa-times-circle"></i> Strike Off Company
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function switchRegTab(btn) {
    // Deactivate all tabs
    document.querySelectorAll('.cf-reg-tab').forEach(function(t) {
        t.classList.remove('active', 'active-blue');
    });
    // Activate clicked tab
    var group = btn.closest('.cf-reg-tab-group');
    var isRight = group === group.parentElement.lastElementChild;
    btn.classList.add(isRight ? 'active-blue' : 'active');

    // Show corresponding pane
    var tabId = btn.getAttribute('data-tab');
    document.querySelectorAll('.cf-reg-tab-pane').forEach(function(p) {
        p.classList.remove('active');
    });
    var pane = document.getElementById('pane-' + tabId);
    if (pane) pane.classList.add('active');
}

function startCorpSecTask(taskName) {
    // Open the AI drawer with the task pre-filled
    var drawer = document.getElementById('aiDrawer');
    if (drawer) {
        drawer.classList.add('open');
        var input = document.getElementById('aiInput');
        if (input) {
            input.value = 'I need to ' + taskName.toLowerCase() + ' for my company. Please guide me through the process.';
            input.focus();
        }
    }
}
</script>
