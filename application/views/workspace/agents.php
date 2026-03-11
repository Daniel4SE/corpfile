<!-- Agents - AI Agent Cards + IR8A Console -->
<div class="page-title">
    <div class="title_left">
        <h3>AI Agents</h3>
        <p style="color:var(--cf-text-secondary); font-size:14px; margin-top:4px;">
            Intelligent assistants for corporate secretarial workflows
        </p>
    </div>
</div>
<div class="clearfix"></div>

<!-- ── Agent Cards Grid ─────────────────────────────────── -->
<div class="cf-agents-grid">

    <!-- Compliance Agent -->
    <div class="cf-agent-card">
        <div class="cf-agent-card-header">
            <div class="cf-agent-icon" style="background: rgba(30,58,95,0.08); color: var(--cf-primary);">
                <i class="fa fa-shield"></i>
            </div>
            <div class="cf-agent-status">
                <span class="cf-agent-status-dot online"></span> Active
            </div>
        </div>
        <h4 class="cf-agent-name">Compliance Monitor</h4>
        <p class="cf-agent-desc">Tracks AGM, AR, FYE deadlines, and regulatory filing requirements. Sends alerts before due dates.</p>
        <div class="cf-agent-skills">
            <span class="cf-agent-skill">AGM Tracking</span>
            <span class="cf-agent-skill">AR Filing</span>
            <span class="cf-agent-skill">Due Dates</span>
        </div>
        <button class="btn btn-primary btn-sm cf-agent-action" onclick="openAgentChat('compliance')">
            <i class="fa fa-play" style="margin-right:4px;"></i> Run
        </button>
    </div>

    <!-- Document Agent -->
    <div class="cf-agent-card">
        <div class="cf-agent-card-header">
            <div class="cf-agent-icon" style="background: rgba(79,134,198,0.08); color: var(--cf-accent);">
                <i class="fa fa-file-text"></i>
            </div>
            <div class="cf-agent-status">
                <span class="cf-agent-status-dot online"></span> Active
            </div>
        </div>
        <h4 class="cf-agent-name">Document Generator</h4>
        <p class="cf-agent-desc">Auto-generates resolutions, forms, certificates, and corporate documents from templates.</p>
        <div class="cf-agent-skills">
            <span class="cf-agent-skill">Templates</span>
            <span class="cf-agent-skill">Resolutions</span>
            <span class="cf-agent-skill">Certificates</span>
        </div>
        <button class="btn btn-primary btn-sm cf-agent-action" onclick="openAgentChat('docgen')">
            <i class="fa fa-play" style="margin-right:4px;"></i> Run
        </button>
    </div>

    <!-- KYC Agent -->
    <div class="cf-agent-card">
        <div class="cf-agent-card-header">
            <div class="cf-agent-icon" style="background: rgba(16,185,129,0.08); color: var(--cf-success);">
                <i class="fa fa-search"></i>
            </div>
            <div class="cf-agent-status">
                <span class="cf-agent-status-dot online"></span> Active
            </div>
        </div>
        <h4 class="cf-agent-name">KYC Screening</h4>
        <p class="cf-agent-desc">Performs customer due diligence, PEP/sanctions screening, and AML risk assessment.</p>
        <div class="cf-agent-skills">
            <span class="cf-agent-skill">CDD</span>
            <span class="cf-agent-skill">PEP Check</span>
            <span class="cf-agent-skill">Sanctions</span>
        </div>
        <button class="btn btn-primary btn-sm cf-agent-action" onclick="openAgentChat('kyc')">
            <i class="fa fa-play" style="margin-right:4px;"></i> Run
        </button>
    </div>

    <!-- IR8A / Tax Agent -->
    <div class="cf-agent-card">
        <div class="cf-agent-card-header">
            <div class="cf-agent-icon" style="background: rgba(245,158,11,0.08); color: var(--cf-warning);">
                <i class="fa fa-calculator"></i>
            </div>
            <div class="cf-agent-status">
                <span class="cf-agent-status-dot online"></span> Active
            </div>
        </div>
        <h4 class="cf-agent-name">IR8A / Tax Filing</h4>
        <p class="cf-agent-desc">Prepares IR8A forms, validates tax computations, handles IRAS e-filing workflows.</p>
        <div class="cf-agent-skills">
            <span class="cf-agent-skill">IR8A</span>
            <span class="cf-agent-skill">Tax Calc</span>
            <span class="cf-agent-skill">IRAS Filing</span>
        </div>
        <button class="btn btn-primary btn-sm cf-agent-action" onclick="openAgentChat('ir8a')">
            <i class="fa fa-play" style="margin-right:4px;"></i> Run
        </button>
    </div>

    <!-- Invoice Agent -->
    <div class="cf-agent-card">
        <div class="cf-agent-card-header">
            <div class="cf-agent-icon" style="background: rgba(236,72,153,0.08); color: #EC4899;">
                <i class="fa fa-money"></i>
            </div>
            <div class="cf-agent-status">
                <span class="cf-agent-status-dot warning"></span> Setup Required
            </div>
        </div>
        <h4 class="cf-agent-name">Invoice Manager</h4>
        <p class="cf-agent-desc">Generates annual fee invoices, tracks payments, sends billing reminders to clients.</p>
        <div class="cf-agent-skills">
            <span class="cf-agent-skill">Invoicing</span>
            <span class="cf-agent-skill">Billing</span>
            <span class="cf-agent-skill">Reminders</span>
        </div>
        <button class="btn btn-default btn-sm cf-agent-action" onclick="openAgentChat('invoice')">
            <i class="fa fa-cog" style="margin-right:4px;"></i> Configure
        </button>
    </div>

    <!-- Payroll Agent -->
    <div class="cf-agent-card">
        <div class="cf-agent-card-header">
            <div class="cf-agent-icon" style="background: rgba(139,92,246,0.08); color: #8B5CF6;">
                <i class="fa fa-users"></i>
            </div>
            <div class="cf-agent-status">
                <span class="cf-agent-status-dot online"></span> Active
            </div>
        </div>
        <h4 class="cf-agent-name">SG Payroll</h4>
        <p class="cf-agent-desc">Singapore payroll processing, CPF calculations, SDL/FWL computation, payslip generation.</p>
        <div class="cf-agent-skills">
            <span class="cf-agent-skill">CPF</span>
            <span class="cf-agent-skill">SDL/FWL</span>
            <span class="cf-agent-skill">Payslips</span>
        </div>
        <button class="btn btn-primary btn-sm cf-agent-action" onclick="openAgentChat('payroll')">
            <i class="fa fa-play" style="margin-right:4px;"></i> Run
        </button>
    </div>

</div>

<!-- ── Agent Metrics (from database) ────────────────────── -->
<div style="margin-top: 24px;">
    <div class="section-title"><span class="dot"></span> Agent Data Sources</div>
    <div class="kpi-grid" style="grid-template-columns: repeat(4, 1fr);">
        <div class="kpi-card kpi-navy animate-in">
            <div class="kpi-header">
                <span class="kpi-label">IR8A / Tax Files</span>
                <div class="kpi-icon navy"><i class="fa fa-file-text-o"></i></div>
            </div>
            <div class="kpi-value"><?= number_format((int) ($metrics['ir8a_files'] ?? 0)) ?></div>
            <div class="kpi-trend neutral"><i class="fa fa-database"></i> Stored documents</div>
        </div>
        <div class="kpi-card kpi-amber animate-in animate-in-delay-1">
            <div class="kpi-header">
                <span class="kpi-label">Tax Deadlines</span>
                <div class="kpi-icon amber"><i class="fa fa-calendar"></i></div>
            </div>
            <div class="kpi-value"><?= number_format((int) ($metrics['tax_deadlines'] ?? 0)) ?></div>
            <div class="kpi-trend neutral"><i class="fa fa-clock-o"></i> ECI, Tax Return, AR</div>
        </div>
        <div class="kpi-card kpi-blue animate-in animate-in-delay-2">
            <div class="kpi-header">
                <span class="kpi-label">Payroll Clients</span>
                <div class="kpi-icon blue"><i class="fa fa-users"></i></div>
            </div>
            <div class="kpi-value"><?= number_format((int) ($metrics['payroll_clients'] ?? 0)) ?></div>
            <div class="kpi-trend neutral"><i class="fa fa-briefcase"></i> Tagged for payroll</div>
        </div>
        <div class="kpi-card kpi-green animate-in animate-in-delay-3">
            <div class="kpi-header">
                <span class="kpi-label">Templates</span>
                <div class="kpi-icon green"><i class="fa fa-copy"></i></div>
            </div>
            <div class="kpi-value"><?= number_format((int) ($metrics['templates'] ?? 0)) ?></div>
            <div class="kpi-trend neutral"><i class="fa fa-check"></i> Ready for workflows</div>
        </div>
    </div>
</div>

<!-- ── Tax Deadline Queue + Recent Files ────────────────── -->
<?php if (!empty($tax_deadlines) || !empty($tax_documents)): ?>
<div class="row" style="margin-top: 24px;">
    <?php if (!empty($tax_deadlines)): ?>
    <div class="col-md-7">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-calendar" style="margin-right:8px; color:var(--cf-accent);"></i> Tax Deadline Queue</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Company</th>
                            <th>Event</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th style="text-align:right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tax_deadlines as $deadline): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($deadline->company_name ?? '') ?></strong></td>
                            <td><?= htmlspecialchars($deadline->event_name ?? '') ?></td>
                            <td><?= !empty($deadline->due_date) ? date('d M Y', strtotime($deadline->due_date)) : '-' ?></td>
                            <td>
                                <span class="label label-<?= ($deadline->tone ?? 'neutral') === 'danger' ? 'danger' : (($deadline->tone ?? '') === 'warning' ? 'warning' : 'default') ?>">
                                    <?= htmlspecialchars($deadline->status ?? 'Pending') ?>
                                </span>
                            </td>
                            <td style="text-align:right;">
                                <a href="<?= htmlspecialchars($deadline->href ?? base_url('agents')) ?>" class="btn btn-xs btn-primary">Open</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($tax_documents)): ?>
    <div class="col-md-5">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-file-text-o" style="margin-right:8px; color:var(--cf-accent);"></i> Recent IR8A / Tax Files</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <ul class="list-unstyled msg_list">
                    <?php foreach ($tax_documents as $document): ?>
                    <li>
                        <a href="javascript:;">
                            <span style="font-weight:600; color:var(--cf-text);"><?= htmlspecialchars($document->document_name ?? '') ?></span>
                            <span class="message"><?= !empty($document->created_at) ? date('d M Y', strtotime($document->created_at)) : 'No date' ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<style>
/* Agent Cards Grid */
.cf-agents-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 18px;
    margin-top: 8px;
}
.cf-agent-card {
    background: var(--cf-white);
    border: 1px solid var(--cf-border);
    border-radius: var(--cf-radius);
    padding: 22px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    transition: var(--cf-transition);
}
.cf-agent-card:hover {
    box-shadow: var(--cf-shadow-md);
    transform: translateY(-2px);
}
.cf-agent-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.cf-agent-icon {
    width: 44px; height: 44px;
    border-radius: var(--cf-radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.cf-agent-name {
    font-size: 15px;
    font-weight: 600;
    color: var(--cf-text);
    margin: 0;
}
.cf-agent-desc {
    font-size: 13px;
    color: var(--cf-text-secondary);
    line-height: 1.5;
    margin: 0;
}
.cf-agent-skills {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}
.cf-agent-skill {
    padding: 3px 10px;
    border-radius: 20px;
    background: var(--cf-card-bg);
    color: var(--cf-text-secondary);
    font-size: 11px;
    font-weight: 500;
}
.cf-agent-status {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    font-weight: 500;
    color: var(--cf-text-secondary);
}
.cf-agent-status-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}
.cf-agent-status-dot.online { background: var(--cf-success); box-shadow: 0 0 6px rgba(16,185,129,0.4); }
.cf-agent-status-dot.warning { background: var(--cf-warning); box-shadow: 0 0 6px rgba(245,158,11,0.4); }
.cf-agent-status-dot.offline { background: var(--cf-danger); box-shadow: 0 0 6px rgba(239,68,68,0.4); }
.cf-agent-action {
    align-self: flex-start;
    margin-top: auto;
}

@media (max-width: 768px) {
    .cf-agents-grid { grid-template-columns: 1fr; }
}
</style>

<script>
function openAgentChat(type) {
    var messages = {
        'compliance': 'Show me upcoming compliance deadlines and overdue items',
        'docgen': 'Help me generate a corporate document or resolution',
        'kyc': 'Run a KYC screening check for a new client',
        'ir8a': 'Help me with IR8A form preparation',
        'invoice': 'Generate annual invoices for current clients',
        'payroll': 'Calculate Singapore payroll including CPF contributions'
    };

    /* Navigate to the full Chats page with a pre-filled message */
    var msg = messages[type] || '';
    window.location.href = BASE_URL + 'chats' + (msg ? '?prompt=' + encodeURIComponent(msg) : '');
}
</script>
