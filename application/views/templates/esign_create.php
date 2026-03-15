<!-- eSign Create - Multi-Step Wizard -->
<div class="page-title">
    <div class="title_left">
        <h3>New eSign Request</h3>
        <p style="color:var(--cf-text-secondary); font-size:13px; margin-top:4px;">
            Configure and send a document for electronic signature
        </p>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('esign/manage') ?>" class="btn btn-default" style="border-radius:var(--cf-radius-sm);">
                <i class="fa fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!-- Step Indicator -->
<div class="esign-wizard-steps">
    <div class="esign-step active" data-step="1">
        <span class="esign-step-num">1</span>
        <span class="esign-step-label">Document</span>
    </div>
    <div class="esign-step-line"></div>
    <div class="esign-step" data-step="2">
        <span class="esign-step-num">2</span>
        <span class="esign-step-label">Recipients</span>
    </div>
    <div class="esign-step-line"></div>
    <div class="esign-step" data-step="3">
        <span class="esign-step-num">3</span>
        <span class="esign-step-label">Review & Send</span>
    </div>
</div>

<form id="esignForm" method="POST" action="<?= base_url('esign/store') ?>">
    <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">

    <!-- ═══════ STEP 1: Document ═══════ -->
    <div class="esign-wizard-panel" id="step1" style="display:block;">
        <div class="x_panel">
            <div class="x_title"><h2><i class="fa fa-file-text-o"></i> Document Details</h2><div class="clearfix"></div></div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Company <span class="text-muted">(optional)</span></label>
                            <select name="company_id" id="esignCompany" class="form-control select2" style="width:100%">
                                <option value="">— Select Company —</option>
                                <?php foreach ($companies as $c): ?>
                                <option value="<?= $c->id ?>"><?= htmlspecialchars($c->company_name) ?> (<?= $c->registration_number ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select Existing Document <span class="text-muted">(optional)</span></label>
                            <select name="document_id" id="esignDocumentId" class="form-control select2" style="width:100%">
                                <option value="">— Select Document —</option>
                                <?php foreach ($documents as $doc): ?>
                                <option value="<?= $doc->id ?>" data-company="<?= $doc->entity_id ?>"><?= htmlspecialchars($doc->document_name) ?><?= $doc->company_name ? ' (' . $doc->company_name . ')' : '' ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Document Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="esignTitle" class="form-control" required placeholder="e.g. Board Resolution for AGM 2025">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Expiry Date <span class="text-muted">(optional)</span></label>
                            <input type="date" name="expires_at" id="esignExpiry" class="form-control" min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email Subject</label>
                            <input type="text" name="subject" id="esignSubject" class="form-control" placeholder="Signature required: [Document Title]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Message to Signers <span class="text-muted">(optional)</span></label>
                            <textarea name="message" id="esignMessage" class="form-control" rows="2" placeholder="Please review and sign this document at your earliest convenience."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="esign-wizard-nav">
            <span></span>
            <button type="button" class="btn btn-primary" onclick="goToStep(2)">
                Next: Recipients <i class="fa fa-arrow-right"></i>
            </button>
        </div>
    </div>

    <!-- ═══════ STEP 2: Recipients ═══════ -->
    <div class="esign-wizard-panel" id="step2" style="display:none;">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-users"></i> Signing Recipients</h2>
                <div class="pull-right" style="margin-top:2px;">
                    <label class="esign-toggle-label">
                        <input type="checkbox" name="signing_order" id="signingOrderToggle" value="1">
                        <span>Enable signing order</span>
                    </label>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- Auto-load from company -->
                <div id="companySignersSection" style="display:none; margin-bottom:16px;">
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                        <h5 style="margin:0; font-weight:600; color:var(--cf-text);">
                            <i class="fa fa-building-o"></i> Company Officers
                        </h5>
                        <button type="button" class="btn btn-xs btn-info" id="loadSignersBtn" onclick="loadCompanySigners()">
                            <i class="fa fa-refresh"></i> Load from Company
                        </button>
                    </div>
                    <div id="companySignersList" class="esign-company-signers"></div>
                </div>

                <!-- Signers list -->
                <div id="signersContainer">
                    <div class="esign-signers-header">
                        <div style="flex:1; font-weight:600; font-size:13px;">Added Recipients</div>
                    </div>
                    <div id="signersList" class="esign-signers-list">
                        <!-- Dynamic signer rows inserted here -->
                    </div>
                </div>

                <!-- Add signer button -->
                <div style="margin-top:12px;">
                    <button type="button" class="btn btn-default" onclick="addSignerRow()">
                        <i class="fa fa-plus"></i> Add Recipient Manually
                    </button>
                </div>

                <div id="noSignersAlert" class="alert alert-info" style="margin-top:16px;">
                    <i class="fa fa-info-circle"></i> Select a company above to auto-load directors and shareholders, or add recipients manually.
                </div>
            </div>
        </div>
        <div class="esign-wizard-nav">
            <button type="button" class="btn btn-default" onclick="goToStep(1)">
                <i class="fa fa-arrow-left"></i> Back
            </button>
            <button type="button" class="btn btn-primary" onclick="goToStep(3)">
                Next: Review <i class="fa fa-arrow-right"></i>
            </button>
        </div>
    </div>

    <!-- ═══════ STEP 3: Review & Send ═══════ -->
    <div class="esign-wizard-panel" id="step3" style="display:none;">
        <div class="x_panel">
            <div class="x_title"><h2><i class="fa fa-check-circle"></i> Review & Send</h2><div class="clearfix"></div></div>
            <div class="x_content">
                <!-- Summary Card -->
                <div class="esign-review-card">
                    <div class="esign-review-section">
                        <h5><i class="fa fa-file-text-o"></i> Document</h5>
                        <div class="esign-review-row">
                            <span class="esign-review-label">Title:</span>
                            <span id="reviewTitle" class="esign-review-value">—</span>
                        </div>
                        <div class="esign-review-row">
                            <span class="esign-review-label">Company:</span>
                            <span id="reviewCompany" class="esign-review-value">—</span>
                        </div>
                        <div class="esign-review-row">
                            <span class="esign-review-label">Subject:</span>
                            <span id="reviewSubject" class="esign-review-value">—</span>
                        </div>
                        <div class="esign-review-row">
                            <span class="esign-review-label">Expires:</span>
                            <span id="reviewExpiry" class="esign-review-value">No expiry</span>
                        </div>
                    </div>
                    <div class="esign-review-section">
                        <h5><i class="fa fa-users"></i> Recipients (<span id="reviewSignerCount">0</span>)</h5>
                        <div id="reviewSignersList"></div>
                    </div>
                    <div class="esign-review-section">
                        <h5><i class="fa fa-cog"></i> Settings</h5>
                        <div class="esign-review-row">
                            <span class="esign-review-label">Signing Order:</span>
                            <span id="reviewSigningOrder" class="esign-review-value">Disabled</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="esign-wizard-nav">
            <button type="button" class="btn btn-default" onclick="goToStep(2)">
                <i class="fa fa-arrow-left"></i> Back
            </button>
            <div style="display:flex; gap:8px;">
                <button type="submit" name="action" value="draft" class="btn btn-default">
                    <i class="fa fa-save"></i> Save as Draft
                </button>
                <button type="submit" name="action" value="send" class="btn btn-success btn-lg">
                    <i class="fa fa-paper-plane"></i> Save & Create
                </button>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    if ($.fn.select2) {
        $('#esignCompany').select2({ placeholder: '— Select Company —', allowClear: true });
        $('#esignDocumentId').select2({ placeholder: '— Select Document —', allowClear: true });
    }

    // When company is selected, show signers section
    $('#esignCompany').on('change', function() {
        var companyId = $(this).val();
        if (companyId) {
            $('#companySignersSection').show();
            $('#noSignersAlert').hide();
            loadCompanySigners();
        } else {
            $('#companySignersSection').hide();
            $('#companySignersList').empty();
        }
    });

    // When document is selected, auto-fill title
    $('#esignDocumentId').on('change', function() {
        var text = $(this).find('option:selected').text();
        if (text && !$('#esignTitle').val()) {
            // Extract just the document name (before the parenthetical company name)
            var docName = text.replace(/\s*\(.*\)\s*$/, '').trim();
            $('#esignTitle').val(docName);
        }
    });
});

var signerIndex = 0;

/* Step navigation */
function goToStep(step) {
    // Validate before moving forward
    if (step === 2) {
        var title = $('#esignTitle').val().trim();
        if (!title) {
            new PNotify({ title: 'Required', text: 'Please enter a document title', type: 'warning' });
            $('#esignTitle').focus();
            return;
        }
    }
    if (step === 3) {
        var signerRows = document.querySelectorAll('.esign-signer-row');
        if (signerRows.length === 0) {
            new PNotify({ title: 'Required', text: 'Please add at least one recipient', type: 'warning' });
            return;
        }
        // Validate emails
        var valid = true;
        signerRows.forEach(function(row) {
            var emailInput = row.querySelector('input[name*="[email]"]');
            var nameInput = row.querySelector('input[name*="[name]"]');
            if (!nameInput.value.trim() || !emailInput.value.trim()) {
                valid = false;
            }
        });
        if (!valid) {
            new PNotify({ title: 'Incomplete', text: 'All recipients must have a name and email', type: 'warning' });
            return;
        }
        updateReview();
    }

    // Hide all panels, show target
    document.querySelectorAll('.esign-wizard-panel').forEach(function(p) { p.style.display = 'none'; });
    document.getElementById('step' + step).style.display = 'block';

    // Update step indicator
    document.querySelectorAll('.esign-step').forEach(function(s) {
        var sStep = parseInt(s.getAttribute('data-step'));
        s.classList.remove('active', 'completed');
        if (sStep === step) s.classList.add('active');
        if (sStep < step) s.classList.add('completed');
    });

    window.scrollTo({ top: 0, behavior: 'smooth' });
}

/* Load company directors/shareholders */
function loadCompanySigners() {
    var companyId = $('#esignCompany').val();
    if (!companyId) return;

    $('#loadSignersBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');

    $.getJSON(BASE_URL + 'esign/signers/' + companyId, function(resp) {
        $('#loadSignersBtn').prop('disabled', false).html('<i class="fa fa-refresh"></i> Load from Company');
        if (resp.success && resp.data.length > 0) {
            var html = '';
            resp.data.forEach(function(person) {
                var typeClass = person.person_type === 'Director' ? 'esign-person-director' : 
                               (person.person_type === 'Shareholder' ? 'esign-person-shareholder' : 'esign-person-secretary');
                html += '<div class="esign-company-signer-item">';
                html += '  <label class="esign-person-check">';
                html += '    <input type="checkbox" class="companySignerCheck" ' +
                        '      data-name="' + escHtml(person.name) + '" ' +
                        '      data-email="' + escHtml(person.email) + '" ' +
                        '      data-type="' + person.person_type + '" ' +
                        '      data-id="' + (person.person_id || '') + '" ' +
                        '      data-role="' + (person.role || 'Signer') + '">';
                html += '    <span class="esign-person-name">' + escHtml(person.name) + '</span>';
                html += '    <span class="esign-person-badge ' + typeClass + '">' + person.person_type + '</span>';
                html += '  </label>';
                html += '  <span class="esign-person-email">' + escHtml(person.email || 'No email') + '</span>';
                html += '</div>';
            });
            html += '<div style="margin-top:10px;">';
            html += '  <button type="button" class="btn btn-sm btn-primary" onclick="addSelectedSigners()"><i class="fa fa-plus"></i> Add Selected</button>';
            html += '  <button type="button" class="btn btn-sm btn-default" onclick="selectAllSigners()" style="margin-left:4px;">Select All</button>';
            html += '</div>';
            $('#companySignersList').html(html);
        } else {
            $('#companySignersList').html('<div class="text-muted" style="padding:10px;">No active directors or shareholders found for this company.</div>');
        }
    }).fail(function() {
        $('#loadSignersBtn').prop('disabled', false).html('<i class="fa fa-refresh"></i> Load from Company');
        new PNotify({ title: 'Error', text: 'Failed to load company signers', type: 'error' });
    });
}

function selectAllSigners() {
    $('.companySignerCheck').prop('checked', true);
}

function addSelectedSigners() {
    var checked = document.querySelectorAll('.companySignerCheck:checked');
    if (checked.length === 0) {
        new PNotify({ title: 'Select', text: 'Please select at least one person', type: 'info' });
        return;
    }
    checked.forEach(function(cb) {
        addSignerRow(cb.dataset.name, cb.dataset.email, cb.dataset.role, cb.dataset.type, cb.dataset.id);
        cb.checked = false;
    });
    $('#noSignersAlert').hide();
    new PNotify({ title: 'Added', text: checked.length + ' recipient(s) added', type: 'success', delay: 2000 });
}

/* Add a signer row */
function addSignerRow(name, email, role, personType, personId) {
    name = name || '';
    email = email || '';
    role = role || 'Signer';
    personType = personType || 'Other';
    personId = personId || '';

    var idx = signerIndex++;
    var roles = ['Signer', 'Approver', 'CC', 'Viewer'];
    var roleOptions = '';
    roles.forEach(function(r) {
        roleOptions += '<option value="' + r + '"' + (r === role ? ' selected' : '') + '>' + r + '</option>';
    });

    var typeLabel = '';
    if (personType === 'Director') typeLabel = '<span class="esign-person-badge esign-person-director">Director</span>';
    else if (personType === 'Shareholder') typeLabel = '<span class="esign-person-badge esign-person-shareholder">Shareholder</span>';
    else if (personType === 'Secretary') typeLabel = '<span class="esign-person-badge esign-person-secretary">Secretary</span>';

    var html = '<div class="esign-signer-row" data-index="' + idx + '">';
    html += '  <span class="esign-signer-order">' + (document.querySelectorAll('.esign-signer-row').length + 1) + '</span>';
    html += '  <div class="esign-signer-fields">';
    html += '    <input type="text" name="signers[' + idx + '][name]" class="form-control input-sm" value="' + escHtml(name) + '" placeholder="Full Name" required>';
    html += '    <input type="email" name="signers[' + idx + '][email]" class="form-control input-sm" value="' + escHtml(email) + '" placeholder="Email Address" required>';
    html += '    <select name="signers[' + idx + '][role]" class="form-control input-sm">' + roleOptions + '</select>';
    html += '    <input type="hidden" name="signers[' + idx + '][person_type]" value="' + escHtml(personType) + '">';
    html += '    <input type="hidden" name="signers[' + idx + '][person_id]" value="' + escHtml(personId) + '">';
    html += '    ' + typeLabel;
    html += '  </div>';
    html += '  <button type="button" class="btn btn-xs btn-danger" onclick="removeSignerRow(this)" title="Remove"><i class="fa fa-times"></i></button>';
    html += '</div>';

    $('#signersList').append(html);
    $('#noSignersAlert').hide();
    updateSignerNumbers();
}

function removeSignerRow(btn) {
    $(btn).closest('.esign-signer-row').remove();
    updateSignerNumbers();
    if (document.querySelectorAll('.esign-signer-row').length === 0) {
        $('#noSignersAlert').show();
    }
}

function updateSignerNumbers() {
    document.querySelectorAll('.esign-signer-row').forEach(function(row, i) {
        row.querySelector('.esign-signer-order').textContent = i + 1;
    });
}

/* Update review panel */
function updateReview() {
    $('#reviewTitle').text($('#esignTitle').val() || '—');
    $('#reviewCompany').text($('#esignCompany option:selected').text() || '—');
    $('#reviewSubject').text($('#esignSubject').val() || 'Signature required: ' + ($('#esignTitle').val() || ''));
    var expiry = $('#esignExpiry').val();
    $('#reviewExpiry').text(expiry ? new Date(expiry).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }) : 'No expiry');
    $('#reviewSigningOrder').text($('#signingOrderToggle').is(':checked') ? 'Enabled (sequential)' : 'Disabled (parallel)');

    var signerRows = document.querySelectorAll('.esign-signer-row');
    $('#reviewSignerCount').text(signerRows.length);

    var signersHtml = '';
    signerRows.forEach(function(row, i) {
        var name = row.querySelector('input[name*="[name]"]').value;
        var email = row.querySelector('input[name*="[email]"]').value;
        var role = row.querySelector('select[name*="[role]"]').value;
        signersHtml += '<div class="esign-review-signer">';
        signersHtml += '  <span class="esign-review-signer-num">' + (i + 1) + '</span>';
        signersHtml += '  <span class="esign-review-signer-info">';
        signersHtml += '    <strong>' + escHtml(name) + '</strong> &lt;' + escHtml(email) + '&gt;';
        signersHtml += '    <span class="esign-review-signer-role">' + role + '</span>';
        signersHtml += '  </span>';
        signersHtml += '</div>';
    });
    $('#reviewSignersList').html(signersHtml || '<div class="text-muted">No recipients added</div>');
}

function escHtml(str) {
    if (!str) return '';
    var div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}
</script>
