<!-- AI Agents - Choose Agent + Chat -->
<div class="cf-agents-page">

    <!-- Header -->
    <div class="cf-agents-header">
        <h2 class="cf-agents-title">Choose AI Agent</h2>
        <p class="cf-agents-subtitle">Start with the right context. Each agent is designed for a specific corporate secretarial workflow, so answers stay accurate and consistent with your records.</p>
    </div>

    <!-- Scrollable Agent Cards -->
    <div class="cf-agents-scroll">
        <div class="cf-agents-grid-v2">

            <!-- Compliance Monitor -->
            <div class="cf-agent-card-v2" data-agent="compliance" data-prompt="Show me upcoming compliance deadlines and overdue items">
                <div class="cf-agent-icon-circle purple">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h4 class="cf-agent-card-name">Compliance Monitor</h4>
                <p class="cf-agent-card-desc">Tracks AGM, AR, FYE deadlines, and regulatory filing requirements. Sends alerts before due dates.</p>
            </div>

            <!-- Document Generator -->
            <div class="cf-agent-card-v2" data-agent="docgen" data-prompt="Help me generate a corporate document or resolution">
                <div class="cf-agent-icon-circle blue">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                </div>
                <h4 class="cf-agent-card-name">Document Generator</h4>
                <p class="cf-agent-card-desc">Auto-generates resolutions, forms, certificates, and corporate documents from templates.</p>
            </div>

            <!-- KYC Screening -->
            <div class="cf-agent-card-v2" data-agent="kyc" data-prompt="Run a KYC screening check for a new client">
                <div class="cf-agent-icon-circle green">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
                <h4 class="cf-agent-card-name">KYC Screening</h4>
                <p class="cf-agent-card-desc">Performs customer due diligence, PEP/sanctions screening, and AML risk assessment for new clients.</p>
            </div>

            <!-- IR8A / Tax Filing -->
            <div class="cf-agent-card-v2" data-agent="ir8a" data-prompt="Help me with IR8A form preparation">
                <div class="cf-agent-icon-circle amber">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="8" y1="10" x2="16" y2="10"/><line x1="8" y1="14" x2="12" y2="14"/></svg>
                </div>
                <h4 class="cf-agent-card-name">IR8A / Tax Filing</h4>
                <p class="cf-agent-card-desc">Prepares IR8A forms, validates tax computations, and handles IRAS e-filing workflows.</p>
            </div>

            <!-- Invoice Manager -->
            <div class="cf-agent-card-v2" data-agent="invoice" data-prompt="Generate annual invoices for current clients">
                <div class="cf-agent-icon-circle pink">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h4 class="cf-agent-card-name">Invoice Manager</h4>
                <p class="cf-agent-card-desc">Generates annual fee invoices, tracks payments, and sends billing reminders to clients.</p>
            </div>

            <!-- SG Payroll -->
            <div class="cf-agent-card-v2" data-agent="payroll" data-prompt="Calculate Singapore payroll including CPF contributions">
                <div class="cf-agent-icon-circle violet">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h4 class="cf-agent-card-name">SG Payroll</h4>
                <p class="cf-agent-card-desc">Singapore payroll processing, CPF calculations, SDL/FWL computation, and payslip generation.</p>
            </div>

        </div>
    </div>

    <!-- Bottom Chat Bar -->
    <div class="cf-agents-chatbar">
        <div class="cf-agents-chatbar-inner">
            <input type="text" class="cf-agents-chatinput" id="agentChatInput" placeholder="Ask me anything..." autocomplete="off">
            <div class="cf-agents-chatbar-right">
                <button class="cf-agent-selector-btn" id="agentSelectorBtn">
                    <span class="cf-agent-selector-icon" id="agentSelectorIcon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </span>
                    <span id="agentSelectorLabel">Compliance Monitor</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <button class="cf-agents-sendbtn" id="agentSendBtn" title="Send">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                </button>
            </div>
        </div>
    </div>

</div>

<style>
/* ── Agents Page V2 ─────────────────────────────────── */
.cf-agents-page {
    display: flex;
    flex-direction: column;
    min-height: calc(100vh - 80px);
    padding: 0;
    position: relative;
}

.cf-agents-header {
    padding: 32px 0 8px 0;
}
.cf-agents-title {
    font-size: 26px;
    font-weight: 700;
    color: var(--cf-text, #1e3a5f);
    margin: 0 0 8px 0;
    letter-spacing: -0.3px;
}
.cf-agents-subtitle {
    font-size: 15px;
    color: var(--cf-text-secondary, #64748b);
    line-height: 1.6;
    margin: 0;
    max-width: 680px;
}

/* Scrollable card area */
.cf-agents-scroll {
    flex: 1 1 auto;
    overflow-y: auto;
    padding: 24px 0 120px 0;
    -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 3%, black 85%, transparent 100%);
    mask-image: linear-gradient(to bottom, transparent 0%, black 3%, black 85%, transparent 100%);
}

.cf-agents-grid-v2 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}

/* Agent Card V2 */
.cf-agent-card-v2 {
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 16px;
    padding: 24px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.cf-agent-card-v2:hover {
    border-color: #c7d2fe;
    box-shadow: 0 2px 12px rgba(99, 102, 241, 0.08);
}
.cf-agent-card-v2.selected {
    border-color: #6366f1;
    background: linear-gradient(135deg, #f5f3ff 0%, #eef2ff 100%);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12), 0 4px 16px rgba(99, 102, 241, 0.1);
}

/* Icon circles */
.cf-agent-icon-circle {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.cf-agent-icon-circle.purple { background: #ede9fe; color: #7c3aed; }
.cf-agent-icon-circle.blue   { background: #dbeafe; color: #3b82f6; }
.cf-agent-icon-circle.green  { background: #d1fae5; color: #059669; }
.cf-agent-icon-circle.amber  { background: #fef3c7; color: #d97706; }
.cf-agent-icon-circle.pink   { background: #fce7f3; color: #db2777; }
.cf-agent-icon-circle.violet { background: #ede9fe; color: #8b5cf6; }

.cf-agent-card-name {
    font-size: 16px;
    font-weight: 700;
    color: var(--cf-text, #1e293b);
    margin: 0;
    letter-spacing: -0.2px;
}
.cf-agent-card-desc {
    font-size: 13.5px;
    color: var(--cf-text-secondary, #64748b);
    line-height: 1.6;
    margin: 0;
}

/* ── Bottom Chat Bar ─────────────────────────────────── */
.cf-agents-chatbar {
    position: sticky;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 16px 0 20px;
    background: linear-gradient(to top, #f4f6f9 60%, transparent);
    z-index: 20;
}
.cf-agents-chatbar-inner {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 16px;
    padding: 8px 10px 8px 20px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    max-width: 100%;
}
.cf-agents-chatinput {
    flex: 1 1 auto;
    border: none;
    outline: none;
    font-size: 15px;
    color: var(--cf-text, #1e293b);
    background: transparent;
    padding: 8px 0;
    min-width: 0;
}
.cf-agents-chatinput::placeholder {
    color: #94a3b8;
}

.cf-agents-chatbar-right {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}

/* Agent Selector Pill */
.cf-agent-selector-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border: 1.5px solid #e5e7eb;
    border-radius: 24px;
    background: #f8fafc;
    color: var(--cf-text, #1e293b);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.15s;
}
.cf-agent-selector-btn:hover {
    border-color: #c7d2fe;
    background: #f5f3ff;
}
.cf-agent-selector-icon {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ede9fe;
    color: #7c3aed;
    flex-shrink: 0;
}

/* Send Button */
.cf-agents-sendbtn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    flex-shrink: 0;
}
.cf-agents-sendbtn:hover {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    transform: scale(1.05);
}

/* ── Responsive ─────────────────────────────────── */
@media (max-width: 1024px) {
    .cf-agents-grid-v2 {
        grid-template-columns: repeat(2, 1fr);
    }
}
@media (max-width: 640px) {
    .cf-agents-grid-v2 {
        grid-template-columns: 1fr;
    }
    .cf-agents-header {
        padding: 20px 0 4px 0;
    }
    .cf-agents-title {
        font-size: 22px;
    }
    .cf-agent-selector-btn span#agentSelectorLabel {
        display: none;
    }
}
</style>

<script>
(function() {
    var selectedAgent = null;
    var cards = document.querySelectorAll('.cf-agent-card-v2');
    var chatInput = document.getElementById('agentChatInput');
    var sendBtn = document.getElementById('agentSendBtn');
    var selectorLabel = document.getElementById('agentSelectorLabel');
    var selectorIcon = document.getElementById('agentSelectorIcon');

    var agentColors = {
        compliance: { bg: '#ede9fe', color: '#7c3aed' },
        docgen:     { bg: '#dbeafe', color: '#3b82f6' },
        kyc:        { bg: '#d1fae5', color: '#059669' },
        ir8a:       { bg: '#fef3c7', color: '#d97706' },
        invoice:    { bg: '#fce7f3', color: '#db2777' },
        payroll:    { bg: '#ede9fe', color: '#8b5cf6' }
    };

    // Select first card by default
    function selectCard(card) {
        cards.forEach(function(c) { c.classList.remove('selected'); });
        card.classList.add('selected');
        selectedAgent = card.getAttribute('data-agent');

        var name = card.querySelector('.cf-agent-card-name').textContent;
        selectorLabel.textContent = name;

        var colors = agentColors[selectedAgent] || agentColors.compliance;
        selectorIcon.style.background = colors.bg;
        selectorIcon.style.color = colors.color;

        chatInput.setAttribute('placeholder', 'Ask ' + name + ' anything...');
    }

    cards.forEach(function(card) {
        card.addEventListener('click', function() {
            selectCard(card);
        });
    });

    // Select first card
    if (cards.length > 0) {
        selectCard(cards[0]);
    }

    function sendMessage() {
        var message = chatInput.value.trim();
        if (!message && selectedAgent) {
            // Use default prompt from selected card
            var sel = document.querySelector('.cf-agent-card-v2.selected');
            if (sel) message = sel.getAttribute('data-prompt') || '';
        }
        if (!message) return;

        window.location.href = BASE_URL + 'chats?prompt=' + encodeURIComponent(message);
    }

    sendBtn.addEventListener('click', sendMessage);
    chatInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendMessage();
        }
    });

    // Agent selector button cycles through agents
    document.getElementById('agentSelectorBtn').addEventListener('click', function(e) {
        e.stopPropagation();
        var arr = Array.prototype.slice.call(cards);
        var idx = -1;
        arr.forEach(function(c, i) {
            if (c.classList.contains('selected')) idx = i;
        });
        var next = (idx + 1) % arr.length;
        selectCard(arr[next]);
    });
})();
</script>
