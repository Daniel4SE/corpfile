<!-- AI Agents - Choose Agent + Inline Chat -->
<div class="cf-agents-page" id="agentsPage">

    <!-- Header -->
    <div class="cf-agents-header">
        <h2 class="cf-agents-title">Choose AI Agent</h2>
        <p class="cf-agents-subtitle">Start with the right context. Each agent is designed for a specific corporate secretarial workflow, so answers stay accurate and consistent with your records.</p>
    </div>

    <!-- Agent Cards -->
    <div class="cf-agents-scroll" id="agentsScroll">
        <div class="cf-agents-grid-v2" id="agentsGrid">

            <!-- Compliance Monitor -->
            <div class="cf-agent-card-v2" data-agent="compliance"
                 data-prompt="Show me upcoming compliance deadlines and overdue items"
                 data-color="purple" data-label="Compliance Monitor">
                <div class="cf-agent-icon-circle purple">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h4 class="cf-agent-card-name">Compliance Monitor</h4>
                <p class="cf-agent-card-desc">Tracks AGM, AR, FYE deadlines, and regulatory filing requirements. Sends alerts before due dates.</p>
            </div>

            <!-- Document Generator -->
            <div class="cf-agent-card-v2" data-agent="docgen"
                 data-prompt="Help me generate a corporate document or resolution"
                 data-color="blue" data-label="Document Generator">
                <div class="cf-agent-icon-circle blue">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                </div>
                <h4 class="cf-agent-card-name">Document Generator</h4>
                <p class="cf-agent-card-desc">Auto-generates resolutions, forms, certificates, and corporate documents from templates.</p>
            </div>

            <!-- KYC Screening -->
            <div class="cf-agent-card-v2" data-agent="kyc"
                 data-prompt="Run a KYC screening check for a new client"
                 data-color="green" data-label="KYC Screening">
                <div class="cf-agent-icon-circle green">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
                <h4 class="cf-agent-card-name">KYC Screening</h4>
                <p class="cf-agent-card-desc">Performs customer due diligence, PEP/sanctions screening, and AML risk assessment for new clients.</p>
            </div>

            <!-- IR8A / Tax Filing -->
            <div class="cf-agent-card-v2" data-agent="ir8a"
                 data-prompt="Help me with IR8A form preparation"
                 data-color="amber" data-label="IR8A / Tax Filing">
                <div class="cf-agent-icon-circle amber">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="8" y1="10" x2="16" y2="10"/><line x1="8" y1="14" x2="12" y2="14"/></svg>
                </div>
                <h4 class="cf-agent-card-name">IR8A / Tax Filing</h4>
                <p class="cf-agent-card-desc">Prepares IR8A forms, validates tax computations, and handles IRAS e-filing workflows.</p>
            </div>

            <!-- Invoice Manager -->
            <div class="cf-agent-card-v2" data-agent="invoice"
                 data-prompt="Generate annual invoices for current clients"
                 data-color="pink" data-label="Invoice Manager">
                <div class="cf-agent-icon-circle pink">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h4 class="cf-agent-card-name">Invoice Manager</h4>
                <p class="cf-agent-card-desc">Generates annual fee invoices, tracks payments, and sends billing reminders to clients.</p>
            </div>

            <!-- SG Payroll -->
            <div class="cf-agent-card-v2" data-agent="payroll"
                 data-prompt="Calculate Singapore payroll including CPF contributions"
                 data-color="violet" data-label="SG Payroll">
                <div class="cf-agent-icon-circle violet">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h4 class="cf-agent-card-name">SG Payroll</h4>
                <p class="cf-agent-card-desc">Singapore payroll processing, CPF calculations, SDL/FWL computation, and payslip generation.</p>
            </div>

        </div>
    </div>

    <!-- Chat Messages Area (hidden until first message) -->
    <div class="cf-agents-chat" id="agentsChat">
        <div class="cf-agents-chat-header" id="agentsChatHeader">
            <div class="cf-agents-chat-agent">
                <span class="cf-agents-chat-agent-icon" id="chatAgentIcon"></span>
                <span class="cf-agents-chat-agent-name" id="chatAgentName">Compliance Monitor</span>
            </div>
            <button class="cf-agents-chat-back" id="chatBackBtn" title="Back to agents">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Back
            </button>
        </div>
        <div class="cf-agents-messages" id="agentsMessages"></div>
    </div>

    <!-- Bottom Chat Bar (always visible) -->
    <div class="cf-agents-chatbar" id="agentsChatbar">
        <div class="cf-agents-chatbar-inner">
            <input type="text" class="cf-agents-chatinput" id="agentChatInput" placeholder="Ask me anything..." autocomplete="off">
            <div class="cf-agents-chatbar-right">
                <div class="cf-agent-selector-wrap" id="agentSelectorWrap">
                    <button class="cf-agent-selector-btn" id="agentSelectorBtn" title="Switch agent">
                        <span class="cf-agent-selector-icon" id="agentSelectorIcon"></span>
                        <span id="agentSelectorLabel">Compliance Monitor</span>
                        <svg class="cf-selector-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div class="cf-agent-dropdown" id="agentDropdown"></div>
                </div>
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
    height: calc(100vh - 80px);
    padding: 0;
    position: relative;
    overflow: hidden;
}

/* Header */
.cf-agents-header {
    padding: 28px 0 4px 0;
    flex-shrink: 0;
    transition: all 0.35s cubic-bezier(.4,0,.2,1);
}
.cf-agents-page.chatting .cf-agents-header {
    padding: 12px 0 0 0;
}
.cf-agents-page.chatting .cf-agents-title {
    font-size: 18px;
    margin-bottom: 0;
}
.cf-agents-page.chatting .cf-agents-subtitle {
    display: none;
}

.cf-agents-title {
    font-size: 26px;
    font-weight: 700;
    color: var(--cf-text, #1e3a5f);
    margin: 0 0 8px 0;
    letter-spacing: -0.3px;
    transition: font-size 0.3s;
}
.cf-agents-subtitle {
    font-size: 15px;
    color: var(--cf-text-secondary, #64748b);
    line-height: 1.6;
    margin: 0;
    max-width: 680px;
}

/* ── Card Scroll Area ─────────────────────────────────── */
.cf-agents-scroll {
    flex-shrink: 0;
    overflow-x: hidden;
    overflow-y: auto;
    padding: 20px 0 16px 0;
    transition: all 0.35s cubic-bezier(.4,0,.2,1);
}
.cf-agents-page.chatting .cf-agents-scroll {
    padding: 8px 0 8px 0;
    max-height: 90px;
    overflow-x: auto;
    overflow-y: hidden;
}
.cf-agents-grid-v2 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    transition: all 0.35s cubic-bezier(.4,0,.2,1);
}
.cf-agents-page.chatting .cf-agents-grid-v2 {
    display: flex;
    gap: 10px;
    flex-wrap: nowrap;
}

/* ── Agent Card ─────────────────────────────────── */
.cf-agent-card-v2 {
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 16px;
    padding: 24px;
    cursor: pointer;
    transition: all 0.25s ease;
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.cf-agent-card-v2:hover {
    border-color: #c7d2fe;
    box-shadow: 0 2px 12px rgba(99,102,241,0.08);
}
.cf-agent-card-v2.selected {
    border-color: #6366f1;
    background: linear-gradient(135deg, #f5f3ff 0%, #eef2ff 100%);
    box-shadow: 0 0 0 3px rgba(99,102,241,0.12), 0 4px 16px rgba(99,102,241,0.1);
}

/* Compact card in chat mode */
.cf-agents-page.chatting .cf-agent-card-v2 {
    flex-direction: row;
    align-items: center;
    gap: 10px;
    padding: 10px 16px;
    border-radius: 12px;
    min-width: max-content;
    flex-shrink: 0;
}
.cf-agents-page.chatting .cf-agent-card-v2 .cf-agent-card-desc {
    display: none;
}
.cf-agents-page.chatting .cf-agent-card-v2 .cf-agent-icon-circle {
    width: 32px;
    height: 32px;
}
.cf-agents-page.chatting .cf-agent-card-v2 .cf-agent-icon-circle svg {
    width: 16px;
    height: 16px;
}
.cf-agents-page.chatting .cf-agent-card-v2 .cf-agent-card-name {
    font-size: 13px;
    white-space: nowrap;
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
    transition: all 0.25s;
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

/* ── Chat Area ─────────────────────────────────── */
.cf-agents-chat {
    flex: 1 1 auto;
    display: none;
    flex-direction: column;
    min-height: 0;
    overflow: hidden;
}
.cf-agents-page.chatting .cf-agents-chat {
    display: flex;
}

.cf-agents-chat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #e5e7eb;
    flex-shrink: 0;
}
.cf-agents-chat-agent {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    font-size: 14px;
    color: var(--cf-text, #1e293b);
}
.cf-agents-chat-agent-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.cf-agents-chat-back {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 6px 12px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    background: #fff;
    color: var(--cf-text-secondary, #64748b);
    font-size: 13px;
    cursor: pointer;
    transition: all 0.15s;
}
.cf-agents-chat-back:hover {
    background: #f8fafc;
    border-color: #c7d2fe;
    color: var(--cf-text, #1e293b);
}

/* Messages */
.cf-agents-messages {
    flex: 1 1 auto;
    overflow-y: auto;
    padding: 16px 0;
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.cf-agent-msg {
    display: flex;
    gap: 10px;
    max-width: 85%;
    animation: cfMsgIn 0.25s ease;
}
@keyframes cfMsgIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}
.cf-agent-msg.user {
    align-self: flex-end;
    flex-direction: row-reverse;
}
.cf-agent-msg-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 2px;
}
.cf-agent-msg.user .cf-agent-msg-avatar {
    background: var(--cf-primary, #1e3a5f);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
}
.cf-agent-msg-bubble {
    padding: 12px 16px;
    border-radius: 14px;
    font-size: 14px;
    line-height: 1.65;
}
.cf-agent-msg.user .cf-agent-msg-bubble {
    background: var(--cf-primary, #1e3a5f);
    color: #fff;
    border-bottom-right-radius: 4px;
}
.cf-agent-msg.assistant .cf-agent-msg-bubble {
    background: #f4f6f8;
    color: var(--cf-text, #1e293b);
    border-bottom-left-radius: 4px;
}

/* AI content formatting */
.cf-agent-msg-bubble pre {
    background: #e8eaed;
    padding: 10px 12px;
    border-radius: 8px;
    font-size: 12px;
    overflow-x: auto;
    margin: 8px 0;
    white-space: pre-wrap;
    word-break: break-word;
}
.cf-agent-msg-bubble code {
    background: #e8eaed;
    padding: 1px 5px;
    border-radius: 4px;
    font-size: 12px;
}
.cf-agent-msg-bubble strong { font-weight: 600; }
.cf-agent-msg-bubble ul, .cf-agent-msg-bubble ol {
    margin: 6px 0;
    padding-left: 20px;
}
.cf-agent-msg-bubble li { margin: 2px 0; }

/* Typing indicator */
.cf-agent-typing {
    display: flex;
    gap: 10px;
    max-width: 85%;
    animation: cfMsgIn 0.25s ease;
}
.cf-agent-typing-dots {
    display: flex;
    gap: 5px;
    padding: 14px 18px;
    background: #f4f6f8;
    border-radius: 14px;
    border-bottom-left-radius: 4px;
}
.cf-agent-typing-dots span {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #94a3b8;
    animation: cfAgentDot 1.4s infinite ease-in-out;
}
.cf-agent-typing-dots span:nth-child(2) { animation-delay: 0.2s; }
.cf-agent-typing-dots span:nth-child(3) { animation-delay: 0.4s; }
@keyframes cfAgentDot {
    0%,80%,100% { transform: scale(0.6); opacity: 0.3; }
    40% { transform: scale(1); opacity: 1; }
}

/* Error message */
.cf-agent-msg-error .cf-agent-msg-bubble {
    background: #fef9ee;
    border: 1px solid #f5e0b0;
    color: var(--cf-text, #1e293b);
}

/* ── Bottom Chat Bar ─────────────────────────────────── */
.cf-agents-chatbar {
    flex-shrink: 0;
    padding: 12px 0 16px;
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
    font-family: var(--cf-font, inherit) !important;
}
.cf-agents-chatinput::placeholder { color: #94a3b8; }

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
    width: 26px;
    height: 26px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.cf-agent-selector-icon svg {
    width: 14px;
    height: 14px;
}

/* Agent Selector Wrapper */
.cf-agent-selector-wrap {
    position: relative;
}

/* Agent Dropdown */
.cf-agent-dropdown {
    display: none;
    position: absolute;
    bottom: calc(100% + 8px);
    right: 0;
    min-width: 260px;
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 14px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    padding: 6px;
    z-index: 100;
    animation: cfDropIn 0.15s ease;
}
.cf-agent-dropdown.open {
    display: block;
}
@keyframes cfDropIn {
    from { opacity: 0; transform: translateY(6px); }
    to { opacity: 1; transform: translateY(0); }
}
.cf-agent-dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 10px;
    cursor: pointer;
    transition: background 0.12s;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    font-size: 13.5px;
    font-weight: 600;
    color: var(--cf-text, #1e293b);
}
.cf-agent-dropdown-item:hover {
    background: #f5f3ff;
}
.cf-agent-dropdown-item.active {
    background: #eef2ff;
}
.cf-agent-dropdown-item .cf-dd-icon {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.cf-agent-dropdown-item .cf-dd-icon svg {
    width: 15px;
    height: 15px;
}
.cf-agent-dropdown-item .cf-dd-text {
    display: flex;
    flex-direction: column;
    gap: 1px;
    min-width: 0;
}
.cf-agent-dropdown-item .cf-dd-name {
    font-size: 13.5px;
    font-weight: 600;
    color: var(--cf-text, #1e293b);
}
.cf-agent-dropdown-item .cf-dd-desc {
    font-size: 11.5px;
    font-weight: 400;
    color: var(--cf-text-secondary, #64748b);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.cf-selector-chevron {
    transition: transform 0.2s;
}
.cf-agent-selector-wrap.dropdown-open .cf-selector-chevron {
    transform: rotate(180deg);
}

/* Send Button */
.cf-agents-sendbtn {
    width: 42px;
    height: 42px;
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
.cf-agents-sendbtn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

/* ── Responsive ─────────────────────────────────── */
@media (max-width: 1024px) {
    .cf-agents-grid-v2 { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .cf-agents-grid-v2 { grid-template-columns: 1fr; }
    .cf-agents-header { padding: 16px 0 4px 0; }
    .cf-agents-title { font-size: 22px; }
    .cf-agent-selector-btn #agentSelectorLabel { display: none; }
    .cf-agent-msg { max-width: 95%; }
}
</style>

<script>
(function() {
    /* ── State ── */
    var selectedAgent = null;
    var isChatting = false;
    var isSending = false;

    /* ── DOM refs ── */
    var page = document.getElementById('agentsPage');
    var cards = document.querySelectorAll('.cf-agent-card-v2');
    var chatInput = document.getElementById('agentChatInput');
    var sendBtn = document.getElementById('agentSendBtn');
    var selectorLabel = document.getElementById('agentSelectorLabel');
    var selectorIcon = document.getElementById('agentSelectorIcon');
    var chatArea = document.getElementById('agentsChat');
    var msgArea = document.getElementById('agentsMessages');
    var chatAgentIcon = document.getElementById('chatAgentIcon');
    var chatAgentName = document.getElementById('chatAgentName');
    var backBtn = document.getElementById('chatBackBtn');

    /* ── Color map ── */
    var colorMap = {
        purple: { bg: '#ede9fe', fg: '#7c3aed' },
        blue:   { bg: '#dbeafe', fg: '#3b82f6' },
        green:  { bg: '#d1fae5', fg: '#059669' },
        amber:  { bg: '#fef3c7', fg: '#d97706' },
        pink:   { bg: '#fce7f3', fg: '#db2777' },
        violet: { bg: '#ede9fe', fg: '#8b5cf6' }
    };

    /* ── Agent system prompts for context ── */
    var agentSystemHints = {
        compliance: 'You are the Compliance Monitor agent. Focus on AGM, AR, FYE deadlines, regulatory filings, and compliance alerts.',
        docgen: 'You are the Document Generator agent. Help generate corporate resolutions, forms, certificates, and legal documents.',
        kyc: 'You are the KYC Screening agent. Focus on customer due diligence, PEP checks, sanctions screening, and AML risk.',
        ir8a: 'You are the IR8A / Tax Filing agent. Help with IR8A form preparation, tax computations, and IRAS e-filing.',
        invoice: 'You are the Invoice Manager agent. Help generate invoices, track payments, and manage billing.',
        payroll: 'You are the SG Payroll agent. Help with Singapore payroll, CPF calculations, SDL/FWL, and payslip generation.'
    };

    /* ── Select card ── */
    function selectCard(card) {
        cards.forEach(function(c) { c.classList.remove('selected'); });
        card.classList.add('selected');
        selectedAgent = card.getAttribute('data-agent');
        var label = card.getAttribute('data-label');
        var color = card.getAttribute('data-color') || 'purple';
        var iconHTML = card.querySelector('.cf-agent-icon-circle').innerHTML;

        /* Update selector pill */
        selectorLabel.textContent = label;
        var c = colorMap[color] || colorMap.purple;
        selectorIcon.style.background = c.bg;
        selectorIcon.style.color = c.fg;
        selectorIcon.innerHTML = iconHTML.replace(/width="22"/g, 'width="14"').replace(/height="22"/g, 'height="14"');

        /* Update chat header */
        chatAgentIcon.style.background = c.bg;
        chatAgentIcon.style.color = c.fg;
        chatAgentIcon.innerHTML = iconHTML.replace(/width="22"/g, 'width="16"').replace(/height="22"/g, 'height="16"');
        chatAgentName.textContent = label;

        chatInput.setAttribute('placeholder', 'Ask ' + label + ' anything...');
    }

    cards.forEach(function(card) {
        card.addEventListener('click', function() { selectCard(card); });
    });

    /* Default: first card */
    if (cards.length > 0) selectCard(cards[0]);

    /* ── Enter chat mode ── */
    function enterChatMode() {
        if (isChatting) return;
        isChatting = true;
        page.classList.add('chatting');

        /* Welcome message from agent */
        var label = document.querySelector('.cf-agent-card-v2.selected').getAttribute('data-label');
        addMessage('assistant', 'Hello! I\'m the **' + label + '** agent. How can I assist you today?');
    }

    function exitChatMode() {
        isChatting = false;
        page.classList.remove('chatting');
        msgArea.innerHTML = '';
    }

    backBtn.addEventListener('click', exitChatMode);

    /* ── Agent Dropdown ── */
    var selectorWrap = document.getElementById('agentSelectorWrap');
    var dropdown = document.getElementById('agentDropdown');

    function buildDropdown() {
        dropdown.innerHTML = '';
        cards.forEach(function(card) {
            var agent = card.getAttribute('data-agent');
            var label = card.getAttribute('data-label');
            var color = card.getAttribute('data-color') || 'purple';
            var iconHTML = card.querySelector('.cf-agent-icon-circle').innerHTML;
            var desc = card.querySelector('.cf-agent-card-desc').textContent;
            var c = colorMap[color] || colorMap.purple;

            var item = document.createElement('button');
            item.className = 'cf-agent-dropdown-item' + (agent === selectedAgent ? ' active' : '');
            item.innerHTML =
                '<span class="cf-dd-icon" style="background:' + c.bg + ';color:' + c.fg + '">' +
                    iconHTML.replace(/width="22"/g, 'width="15"').replace(/height="22"/g, 'height="15"') +
                '</span>' +
                '<span class="cf-dd-text">' +
                    '<span class="cf-dd-name">' + label + '</span>' +
                    '<span class="cf-dd-desc">' + desc.substring(0, 60) + (desc.length > 60 ? '...' : '') + '</span>' +
                '</span>';

            item.addEventListener('click', function(e) {
                e.stopPropagation();
                selectCard(card);
                closeDropdown();
                if (isChatting) {
                    addMessage('assistant', 'Switched to **' + label + '**. How can I help?');
                }
            });
            dropdown.appendChild(item);
        });
    }

    function openDropdown() {
        buildDropdown();
        dropdown.classList.add('open');
        selectorWrap.classList.add('dropdown-open');
    }

    function closeDropdown() {
        dropdown.classList.remove('open');
        selectorWrap.classList.remove('dropdown-open');
    }

    function toggleDropdown() {
        if (dropdown.classList.contains('open')) {
            closeDropdown();
        } else {
            openDropdown();
        }
    }

    document.getElementById('agentSelectorBtn').addEventListener('click', function(e) {
        e.stopPropagation();
        toggleDropdown();
    });

    /* Close dropdown on outside click */
    document.addEventListener('click', function() {
        closeDropdown();
    });

    /* ── Add message to chat ── */
    function addMessage(role, text) {
        var row = document.createElement('div');
        row.className = 'cf-agent-msg ' + role;

        var avatar = document.createElement('div');
        avatar.className = 'cf-agent-msg-avatar';

        if (role === 'user') {
            avatar.textContent = 'U';
        } else {
            var card = document.querySelector('.cf-agent-card-v2.selected');
            var color = card ? card.getAttribute('data-color') : 'purple';
            var c = colorMap[color] || colorMap.purple;
            avatar.style.background = c.bg;
            avatar.style.color = c.fg;
            var iconSrc = card ? card.querySelector('.cf-agent-icon-circle').innerHTML : '';
            avatar.innerHTML = iconSrc.replace(/width="22"/g, 'width="16"').replace(/height="22"/g, 'height="16"');
        }

        var bubble = document.createElement('div');
        bubble.className = 'cf-agent-msg-bubble';
        bubble.innerHTML = renderMarkdown(text);

        row.appendChild(avatar);
        row.appendChild(bubble);
        msgArea.appendChild(row);
        msgArea.scrollTop = msgArea.scrollHeight;
        return row;
    }

    function addTyping() {
        var el = document.createElement('div');
        el.className = 'cf-agent-typing';
        el.id = 'agentTyping';

        var card = document.querySelector('.cf-agent-card-v2.selected');
        var color = card ? card.getAttribute('data-color') : 'purple';
        var c = colorMap[color] || colorMap.purple;

        var av = document.createElement('div');
        av.className = 'cf-agent-msg-avatar';
        av.style.background = c.bg;
        av.style.color = c.fg;
        var iconSrc = card ? card.querySelector('.cf-agent-icon-circle').innerHTML : '';
        av.innerHTML = iconSrc.replace(/width="22"/g, 'width="16"').replace(/height="22"/g, 'height="16"');

        var dots = document.createElement('div');
        dots.className = 'cf-agent-typing-dots';
        dots.innerHTML = '<span></span><span></span><span></span>';

        el.appendChild(av);
        el.appendChild(dots);
        msgArea.appendChild(el);
        msgArea.scrollTop = msgArea.scrollHeight;
    }

    function removeTyping() {
        var t = document.getElementById('agentTyping');
        if (t) t.remove();
    }

    /* ── Markdown renderer ── */
    function renderMarkdown(text) {
        var html = text
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
            .replace(/```([\s\S]*?)```/g, '<pre><code>$1</code></pre>')
            .replace(/`([^`]+)`/g, '<code>$1</code>')
            .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.+?)\*/g, '<em>$1</em>')
            .replace(/^### (.+)$/gm, '<h5 style="margin:8px 0 4px;font-size:13px;font-weight:700">$1</h5>')
            .replace(/^## (.+)$/gm, '<h4 style="margin:10px 0 4px;font-size:14px;font-weight:700">$1</h4>')
            .replace(/^# (.+)$/gm, '<h3 style="margin:10px 0 6px;font-size:15px;font-weight:700">$1</h3>')
            .replace(/^\d+\.\s+(.+)$/gm, '<li style="margin-left:16px;list-style:decimal">$1</li>')
            .replace(/^[-\u2022]\s+(.+)$/gm, '<li style="margin-left:16px;list-style:disc">$1</li>')
            .replace(/\n/g, '<br>');
        html = html.replace(/<br>\s*(<h[345])/g, '$1').replace(/(<\/h[345]>)\s*<br>/g, '$1');
        html = html.replace(/<br>\s*(<pre>)/g, '$1').replace(/(<\/pre>)\s*<br>/g, '$1');
        return html;
    }

    /* ── Send message ── */
    function sendMessage() {
        if (isSending) return;
        var message = chatInput.value.trim();
        if (!message) return;
        chatInput.value = '';

        if (!isChatting) enterChatMode();

        addMessage('user', message);
        addTyping();

        isSending = true;
        sendBtn.disabled = true;

        /* Build enriched message with agent context */
        var hint = agentSystemHints[selectedAgent] || '';
        var enrichedMsg = hint ? '[Agent: ' + (selectedAgent || 'general') + '] ' + message : message;

        var controller = new AbortController();
        var timeoutId = setTimeout(function() { controller.abort(); }, 180000);

        fetch(BASE_URL + 'ai/chat', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message: enrichedMsg }),
            signal: controller.signal
        })
        .then(function(r) {
            clearTimeout(timeoutId);
            return r.text().then(function(text) {
                var jsonMatch = text.match(/\{[\s\S]*\}$/);
                if (jsonMatch) return JSON.parse(jsonMatch[0]);
                throw new Error('Invalid response');
            });
        })
        .then(function(data) {
            removeTyping();
            isSending = false;
            sendBtn.disabled = false;

            if (data.ok && data.response_text) {
                addMessage('assistant', data.response_text);
            } else {
                var errRow = addMessage('assistant', '**Error:** ' + (data.error || 'Something went wrong. Please try again.'));
                errRow.classList.add('cf-agent-msg-error');
            }
        })
        .catch(function(err) {
            removeTyping();
            isSending = false;
            sendBtn.disabled = false;
            var errRow = addMessage('assistant', '**Connection unavailable.** Unable to reach the AI service. Please check your connection and try again.');
            errRow.classList.add('cf-agent-msg-error');
        });
    }

    sendBtn.addEventListener('click', sendMessage);
    chatInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    /* ── Auto-fill from URL param ── */
    var urlParams = new URLSearchParams(window.location.search);
    var promptParam = urlParams.get('prompt');
    if (promptParam) {
        chatInput.value = promptParam;
        /* Small delay so the page renders first */
        setTimeout(function() { sendMessage(); }, 300);
    }
})();
</script>
