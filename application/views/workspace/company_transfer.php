<!-- Company Transfer-In -->
<div class="page-title">
    <div class="title_left">
        <h3>Company Transfer-In</h3>
        <p style="color:var(--cf-text-secondary); font-size:14px; margin-top:4px;">
            Generate the complete document package for transferring a company's corporate secretary services to Yu Young Consulting
        </p>
    </div>
</div>
<div class="clearfix"></div>

<!-- Wizard Container -->
<div class="ct-wizard" id="ctWizard">

    <!-- Steps Indicator -->
    <div class="ct-steps" id="ctSteps">
        <div class="ct-step active" data-step="1"><span class="ct-step-num">1</span> Select Company</div>
        <div class="ct-step-line"></div>
        <div class="ct-step" data-step="2"><span class="ct-step-num">2</span> Change Types & Details</div>
        <div class="ct-step-line"></div>
        <div class="ct-step" data-step="3"><span class="ct-step-num">3</span> Generate Documents</div>
    </div>

    <!-- Step 1: Select Company -->
    <div class="ct-wiz-step" id="ctStep1">
        <div class="ct-card">
            <label class="ct-card-label">Select Company</label>
            <p class="ct-card-hint">Choose the company being transferred to Yu Young Consulting.</p>
            <select class="form-control" id="ctCompanySelect" style="font-size:14px;">
                <option value="">-- Select a company --</option>
                <?php foreach ($companies as $c): ?>
                <option value="<?= $c->id ?>"><?= htmlspecialchars($c->company_name) ?> (<?= htmlspecialchars($c->registration_number ?? '') ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="ct-actions">
            <span></span>
            <button class="btn btn-primary" onclick="ctNext(2)">Next <i class="fa fa-arrow-right" style="margin-left:6px;"></i></button>
        </div>
    </div>

    <!-- Step 2: Change Types & Details -->
    <div class="ct-wiz-step" id="ctStep2" style="display:none;">
        <!-- Change Type Selection -->
        <div class="ct-card">
            <label class="ct-card-label">Select Change Types (变更项目)</label>
            <p class="ct-card-hint">Check all changes needed for this transfer-in. Pre-checked items are standard for most transfers.</p>

            <div class="ct-group-label"><i class="fa fa-star" style="color:#f0ad4e; margin-right:6px;"></i>Standard Transfer Package</div>
            <label class="ct-check-row">
                <input type="checkbox" class="ct-cb" value="change_registered_office" checked>
                <span class="ct-check-label">Change Registered Office <span class="ct-cn">(变更注册地址)</span></span>
            </label>
            <label class="ct-check-row">
                <input type="checkbox" class="ct-cb" value="change_secretary" checked>
                <span class="ct-check-label">Change Secretary <span class="ct-cn">(变更公司秘书)</span></span>
            </label>
            <label class="ct-check-row">
                <input type="checkbox" class="ct-cb" value="change_director">
                <span class="ct-check-label">Change Director <span class="ct-cn">(变更董事)</span></span>
            </label>

            <div class="ct-group-label" style="margin-top:14px;"><i class="fa fa-plus-circle" style="color:#3498DB; margin-right:6px;"></i>Additional Changes</div>
            <label class="ct-check-row">
                <input type="checkbox" class="ct-cb" value="change_company_name">
                <span class="ct-check-label">Change Company Name <span class="ct-cn">(变更公司名称)</span> <span class="ct-badge ct-badge-special">Special Resolution</span></span>
            </label>
            <label class="ct-check-row">
                <input type="checkbox" class="ct-cb" value="change_principal_activities">
                <span class="ct-check-label">Change Principal Activities <span class="ct-cn">(变更主营业务)</span></span>
            </label>
            <label class="ct-check-row">
                <input type="checkbox" class="ct-cb" value="change_registered_controller">
                <span class="ct-check-label">Change Registered Controller <span class="ct-cn">(变更实控人)</span></span>
            </label>
            <label class="ct-check-row">
                <input type="checkbox" class="ct-cb" value="change_accounting_period">
                <span class="ct-check-label">Change Accounting Period <span class="ct-cn">(变更会计期间)</span></span>
            </label>
            <label class="ct-check-row">
                <input type="checkbox" class="ct-cb" value="change_currency">
                <span class="ct-check-label">Change Currency <span class="ct-cn">(变更货币)</span></span>
            </label>
            <label class="ct-check-row">
                <input type="checkbox" class="ct-cb" value="update_constitution">
                <span class="ct-check-label">Update Constitution <span class="ct-cn">(更新章程)</span> <span class="ct-badge ct-badge-special">Special Resolution</span></span>
            </label>
            <label class="ct-check-row">
                <input type="checkbox" class="ct-cb" value="particulars_update">
                <span class="ct-check-label">Particulars Update <span class="ct-cn">(个人信息更新)</span> <span class="ct-badge ct-badge-admin">No Resolution</span></span>
            </label>

            <div class="ct-group-label" style="margin-top:14px;"><i class="fa fa-money" style="color:#27AE60; margin-right:6px;"></i>Capital & Share Changes</div>
            <label class="ct-check-row">
                <input type="checkbox" class="ct-cb" value="increase_share_capital">
                <span class="ct-check-label">Increase Share Capital <span class="ct-cn">(增加股本)</span></span>
            </label>
            <label class="ct-check-row">
                <input type="checkbox" class="ct-cb" value="reduce_share_capital">
                <span class="ct-check-label">Reduce Share Capital <span class="ct-cn">(减少股本)</span> <span class="ct-badge ct-badge-special">Special Resolution</span></span>
            </label>
            <label class="ct-check-row">
                <input type="checkbox" class="ct-cb" value="transfer_share">
                <span class="ct-check-label">Transfer Share <span class="ct-cn">(股份转让)</span></span>
            </label>
            <label class="ct-check-row">
                <input type="checkbox" class="ct-cb" value="interim_dividend">
                <span class="ct-check-label">Interim Dividend <span class="ct-cn">(中期分红)</span></span>
            </label>
            <label class="ct-check-row">
                <input type="checkbox" class="ct-cb" value="update_paid_up_capital">
                <span class="ct-check-label">Update Paid-up Capital <span class="ct-cn">(更新实缴资本)</span></span>
            </label>
        </div>

        <!-- Transfer Details -->
        <div class="ct-card" style="margin-top:16px;">
            <label class="ct-card-label">Transfer Details</label>
            <div class="ct-field"><label for="ct_effective_date">Effective Date (生效日期)</label>
            <input type="date" id="ct_effective_date"></div>
            <div class="ct-field"><label for="ct_new_address">New Registered Office (if different from Yu Young default)</label>
            <input type="text" id="ct_new_address" placeholder="Default: 51 Goldhill Plaza #20-07 Singapore 308900"></div>
            <div class="ct-field"><label for="ct_new_secretary">New Secretary Name (if different from default)</label>
            <input type="text" id="ct_new_secretary" placeholder="Default: YANG YUJIE"></div>
        </div>

        <!-- Director Change Details (conditional) -->
        <div class="ct-card ct-conditional" id="ctDirectorFields" style="margin-top:16px; display:none;">
            <label class="ct-card-label">New Director Details (变更董事详情)</label>
            <div class="ct-field"><label for="ct_dir_name">Director Full Name</label>
            <input type="text" id="ct_dir_name" placeholder="Full legal name"></div>
            <div class="ct-field"><label for="ct_dir_id">ID/Passport No.</label>
            <input type="text" id="ct_dir_id" placeholder="e.g. S1234567A"></div>
            <div class="ct-field"><label for="ct_dir_nationality">Nationality</label>
            <input type="text" id="ct_dir_nationality" placeholder="e.g. Singaporean"></div>
            <div class="ct-field"><label for="ct_dir_address">Residential Address</label>
            <input type="text" id="ct_dir_address" placeholder="Full residential address"></div>
            <div class="ct-field"><label for="ct_dir_is_nominee">Is Nominee Director?</label>
            <select id="ct_dir_is_nominee"><option value="no">No — Independent director</option><option value="yes">Yes — Yu Young nominee director</option></select></div>
            <div class="ct-field"><label for="ct_dir_removing">Director Being Removed (if any)</label>
            <input type="text" id="ct_dir_removing" placeholder="Name of outgoing director (leave blank if none)"></div>
        </div>

        <!-- Additional Instructions -->
        <div class="ct-card" style="margin-top:16px;">
            <label class="ct-card-label">Additional Instructions (补充说明)</label>
            <div class="ct-field"><label for="ct_extra">Any additional details or special instructions</label>
            <textarea id="ct_extra" rows="3" placeholder="e.g. New SSIC code for principal activity change, share transfer details, etc."></textarea></div>
        </div>

        <div class="ct-actions">
            <button class="btn btn-default" onclick="ctBack(1)"><i class="fa fa-arrow-left" style="margin-right:6px;"></i> Back</button>
            <button class="btn btn-primary" onclick="ctNext(3)"><i class="fa fa-magic" style="margin-right:6px;"></i> Generate Documents</button>
        </div>
    </div>

    <!-- Step 3: Output -->
    <div class="ct-wiz-step" id="ctStep3" style="display:none;">
        <!-- Loading -->
        <div id="ctLoading" style="text-align:center; padding:50px 0;">
            <div class="ct-spinner"></div>
            <p style="margin-top:14px; color:var(--cf-text-secondary); font-size:14px;">Generating transfer-in document package...</p>
            <p style="color:var(--cf-text-muted); font-size:12px;">This may take 30-60 seconds for a complete package</p>
        </div>
        <!-- Result -->
        <div id="ctResult" style="display:none;">
            <div class="ct-card" style="padding:0; overflow:hidden;">
                <div class="ct-result-toolbar">
                    <span class="ct-result-title"><i class="fa fa-check-circle" style="color:#10b981; margin-right:6px;"></i> Document Package Generated</span>
                    <div style="display:flex; gap:6px;">
                        <button class="btn btn-default btn-sm" onclick="ctCopy()"><i class="fa fa-copy"></i> Copy</button>
                        <button class="btn btn-default btn-sm" onclick="ctPrint()"><i class="fa fa-print"></i> Print</button>
                    </div>
                </div>
                <div class="ct-result-content" id="ctOutputContent"></div>
            </div>
            <div class="ct-actions">
                <button class="btn btn-default" onclick="ctBack(2)"><i class="fa fa-arrow-left" style="margin-right:6px;"></i> Edit & Re-generate</button>
                <button class="btn btn-primary" onclick="window.location.reload()"><i class="fa fa-check" style="margin-right:6px;"></i> Done</button>
            </div>
        </div>
    </div>
</div>

<!-- ═══════ STYLES ═══════ -->
<style>
.ct-wizard { max-width: 780px; margin: 0 auto; }

/* Steps */
.ct-steps {
    display: flex; align-items: center; gap: 0;
    margin-bottom: 24px; background: var(--cf-bg);
    border-radius: var(--cf-radius); padding: 12px 20px;
}
.ct-step {
    display: flex; align-items: center; gap: 8px;
    font-size: 13px; color: var(--cf-text-muted);
    font-weight: 500; white-space: nowrap;
}
.ct-step.active { color: var(--cf-accent); font-weight: 600; }
.ct-step.done { color: #10b981; }
.ct-step-num {
    width: 26px; height: 26px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700;
    background: var(--cf-border); color: var(--cf-text-muted); flex-shrink: 0;
}
.ct-step.active .ct-step-num { background: var(--cf-accent); color: #fff; }
.ct-step.done .ct-step-num { background: #10b981; color: #fff; }
.ct-step-line { flex: 1; height: 2px; background: var(--cf-border); margin: 0 12px; min-width: 20px; }

/* Cards */
.ct-card {
    background: var(--cf-white); border: 1px solid var(--cf-border);
    border-radius: var(--cf-radius); padding: 24px; margin-bottom: 16px;
}
.ct-card-label { font-size: 14px; font-weight: 700; color: var(--cf-text); margin-bottom: 4px; display: block; }
.ct-card-hint { font-size: 12px; color: var(--cf-text-muted); margin-bottom: 16px; }

/* Actions */
.ct-actions {
    display: flex; justify-content: space-between; gap: 12px; padding-top: 8px;
}
.ct-actions .btn { border-radius: var(--cf-radius-sm); padding: 9px 20px; font-weight: 600; font-size: 13px; }

/* Fields */
.ct-field { margin-bottom: 14px; }
.ct-field label {
    font-size: 12px; font-weight: 600; color: var(--cf-text-secondary);
    text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 4px; display: block;
}
.ct-field input, .ct-field select, .ct-field textarea {
    width: 100%; border: 1px solid var(--cf-border); border-radius: 6px;
    padding: 8px 12px; font-size: 13px; font-family: var(--cf-font) !important; outline: none;
    transition: border-color 0.15s;
}
.ct-field input:focus, .ct-field select:focus, .ct-field textarea:focus {
    border-color: var(--cf-accent); box-shadow: 0 0 0 2px rgba(79,134,198,0.1);
}

/* Checkbox Group */
.ct-group-label {
    font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;
    color: var(--cf-text-secondary); font-weight: 600; margin-bottom: 8px; padding-top: 4px;
}
.ct-check-row {
    display: flex; align-items: center; gap: 10px;
    padding: 7px 10px; margin: 0 -10px; border-radius: 6px;
    cursor: pointer; transition: background 0.12s; font-weight: 400;
}
.ct-check-row:hover { background: rgba(79,134,198,0.04); }
.ct-cb { width: 16px; height: 16px; accent-color: var(--cf-accent); flex-shrink: 0; cursor: pointer; }
.ct-check-label { font-size: 13px; color: var(--cf-text); line-height: 1.4; }
.ct-cn { color: var(--cf-text-muted); font-size: 12px; }
.ct-badge {
    display: inline-block; font-size: 10px; font-weight: 600;
    padding: 1px 6px; border-radius: 4px; margin-left: 6px; vertical-align: middle;
}
.ct-badge-special { background: #fef3c7; color: #92400e; }
.ct-badge-admin { background: #e0e7ff; color: #3730a3; }

/* Result */
.ct-result-toolbar {
    display: flex; justify-content: space-between; align-items: center;
    padding: 14px 20px; border-bottom: 1px solid var(--cf-border); background: var(--cf-bg);
}
.ct-result-title { font-size: 14px; font-weight: 600; color: var(--cf-text); }
.ct-result-content {
    padding: 20px; font-size: 13px; line-height: 1.8;
    white-space: pre-wrap; max-height: 600px; overflow-y: auto; color: var(--cf-text);
}

/* Spinner */
.ct-spinner {
    width: 36px; height: 36px; border: 3px solid var(--cf-border);
    border-top-color: var(--cf-accent); border-radius: 50%;
    animation: ctSpin 0.8s linear infinite; margin: 0 auto;
}
@keyframes ctSpin { to { transform: rotate(360deg); } }

@media (max-width: 768px) { .ct-wizard { padding: 0 8px; } }
</style>

<!-- ═══════ JAVASCRIPT ═══════ -->
<script>
function ctShowStep(step) {
    $('.ct-wiz-step').hide();
    $('#ctStep' + step).show();
    $('.ct-step').each(function() {
        var s = parseInt($(this).data('step'));
        $(this).removeClass('active done');
        if (s < step) $(this).addClass('done');
        else if (s === step) $(this).addClass('active');
    });
}

function ctNext(step) {
    if (step === 2) {
        ctShowStep(2);
    } else if (step === 3) {
        ctShowStep(3);
        ctGenerate();
    }
}
function ctBack(step) { ctShowStep(step); }

/* Checkbox → conditional director fields */
$(document).on('change', '.ct-cb', function() {
    if ($(this).val() === 'change_director') {
        $('#ctDirectorFields').toggle($(this).is(':checked'));
    }
});

/* Collect all form data */
function ctCollectData() {
    var data = {};
    var selected = [];
    $('.ct-cb:checked').each(function() { selected.push($(this).val()); });
    data['selected_changes'] = selected.join(', ');
    data['effective_date'] = $('#ct_effective_date').val() || '';
    data['new_registered_office'] = $('#ct_new_address').val() || '51 Goldhill Plaza #20-07 Singapore 308900';
    data['new_secretary_name'] = $('#ct_new_secretary').val() || 'YANG YUJIE';

    if (selected.indexOf('change_director') !== -1) {
        data['new_director_name'] = $('#ct_dir_name').val() || '';
        data['new_director_id'] = $('#ct_dir_id').val() || '';
        data['new_director_nationality'] = $('#ct_dir_nationality').val() || '';
        data['new_director_address'] = $('#ct_dir_address').val() || '';
        data['is_nominee_director'] = $('#ct_dir_is_nominee').val() || 'no';
        data['removing_director'] = $('#ct_dir_removing').val() || '';
    }
    data['additional_instructions'] = $('#ct_extra').val() || '';
    return data;
}

/* Generate via API */
function ctGenerate() {
    var companyId = $('#ctCompanySelect').val();
    var fields = ctCollectData();

    $('#ctLoading').show();
    $('#ctResult').hide();

    var extra = '';
    for (var key in fields) {
        if (fields[key]) extra += key.replace(/_/g, ' ') + ': ' + fields[key] + '\n';
    }

    $.ajax({
        url: '<?= base_url("document_generator/generate") ?>',
        method: 'POST',
        data: { template_id: 'transfer_in_package', company_id: companyId, extra_context: extra },
        dataType: 'json',
        timeout: 180000,
        success: function(res) {
            $('#ctLoading').hide();
            $('#ctOutputContent').text(res.success ? res.content : 'Error: ' + (res.message || 'Generation failed'));
            $('#ctResult').show();
        },
        error: function(xhr, status) {
            $('#ctLoading').hide();
            $('#ctOutputContent').text(status === 'timeout'
                ? 'Request timed out. The AI is processing a complex document package — please try again.'
                : 'Error: Could not reach the server (HTTP ' + (xhr.status || '?') + '). Please try again.');
            $('#ctResult').show();
        }
    });
}

function ctCopy() {
    var text = $('#ctOutputContent').text();
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(function() { ctToast('Copied to clipboard'); });
    } else {
        var ta = document.createElement('textarea');
        ta.value = text; document.body.appendChild(ta); ta.select();
        document.execCommand('copy'); document.body.removeChild(ta);
        ctToast('Copied to clipboard');
    }
}

function ctPrint() {
    var content = $('#ctOutputContent').text();
    var w = window.open('', '_blank');
    w.document.write('<html><head><title>Company Transfer-In Document Package</title><style>body{font-family:Arial,sans-serif;padding:40px;line-height:1.8;white-space:pre-wrap;font-size:13px;}h1{font-size:18px;margin-bottom:20px;}</style></head><body>');
    w.document.write('<h1>Company Transfer-In Document Package</h1>');
    w.document.write(content.replace(/</g, '&lt;').replace(/>/g, '&gt;'));
    w.document.write('</body></html>');
    w.document.close();
    w.print();
}

function ctToast(msg) {
    var toast = $('<div>').text(msg).css({
        position:'fixed', bottom:'20px', left:'50%', transform:'translateX(-50%)',
        background:'var(--cf-primary)', color:'#fff', padding:'8px 20px',
        borderRadius:'6px', fontSize:'13px', zIndex:9999, boxShadow:'0 4px 12px rgba(0,0,0,0.15)'
    });
    $('body').append(toast);
    setTimeout(function() { toast.fadeOut(300, function() { toast.remove(); }); }, 2000);
}

$(document).ready(function() {
    ctShowStep(1);
    $(document).on('keydown', function(e) { if (e.key === 'Escape') window.history.back(); });
});
</script>
