<!-- AI Agents - Choose Agent + Inline Chat -->
<div class="cf-agents-page" id="agentsPage">

    <!-- Header -->
    <div class="cf-agents-header">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;">
            <div>
                <h2 class="cf-agents-title">Choose AI Agent</h2>
                <p class="cf-agents-subtitle">Start with the right context. Each agent is designed for a specific corporate secretarial workflow, so answers stay accurate and consistent with your records.</p>
            </div>
            <button class="cf-agents-history-btn" id="agentHistoryBtn" onclick="toggleAgentHistory()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                History
            </button>
        </div>
    </div>

    <!-- History Panel (hidden by default) -->
    <div class="cf-agents-history" id="agentHistoryPanel" style="display:none;">
        <div class="cf-agents-history-header">
            <h4><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:6px;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Agent Conversations</h4>
            <button class="cf-agents-history-close" onclick="toggleAgentHistory()" title="Close">
                <i class="fa fa-times"></i>
            </button>
        </div>
        <div class="cf-agents-history-list" id="agentHistoryList">
            <div style="padding:20px;text-align:center;color:var(--cf-text-muted);font-size:12px;">Loading...</div>
        </div>
    </div>

    <!-- Agent Cards -->
    <div class="cf-agents-scroll" id="agentsScroll">
        <div class="cf-agents-grid-v2" id="agentsGrid">

            <!-- Company Registration -->
            <div class="cf-agent-card-v2" data-agent="compliance"
                 data-prompt="Show me upcoming compliance deadlines and overdue items"
                 data-color="purple" data-label="Company Registration">
                <div class="cf-agent-icon-circle purple">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h4 class="cf-agent-card-name">Company Registration</h4>
                <p class="cf-agent-card-desc">Handles company incorporation, ACRA registration, compliance checks, and post-incorporation setup.</p>
                <button class="cf-agent-edit-btn" onclick="event.stopPropagation();openAgentEditor('compliance')" title="View / Edit Agent"><i class="fa fa-cog"></i></button>
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
                <button class="cf-agent-edit-btn" onclick="event.stopPropagation();openAgentEditor('docgen')" title="View / Edit Agent"><i class="fa fa-cog"></i></button>
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
                <button class="cf-agent-edit-btn" onclick="event.stopPropagation();openAgentEditor('kyc')" title="View / Edit Agent"><i class="fa fa-cog"></i></button>
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
                <button class="cf-agent-edit-btn" onclick="event.stopPropagation();openAgentEditor('ir8a')" title="View / Edit Agent"><i class="fa fa-cog"></i></button>
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
                <button class="cf-agent-edit-btn" onclick="event.stopPropagation();openAgentEditor('invoice')" title="View / Edit Agent"><i class="fa fa-cog"></i></button>
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
                <button class="cf-agent-edit-btn" onclick="event.stopPropagation();openAgentEditor('payroll')" title="View / Edit Agent"><i class="fa fa-cog"></i></button>
            </div>

        </div>
    </div>

    <!-- Chat Messages Area (hidden until first message) -->
    <div class="cf-agents-chat" id="agentsChat">
        <div class="cf-agents-chat-header" id="agentsChatHeader">
            <div class="cf-agents-chat-agent">
                <span class="cf-agents-chat-agent-icon" id="chatAgentIcon"></span>
                <span class="cf-agents-chat-agent-name" id="chatAgentName">Company Registration</span>
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                <button onclick="toggleAgentHistory()" style="font-size:12px;color:var(--cf-accent);background:none;border:none;cursor:pointer;white-space:nowrap;padding:0;" title="View agent history">
                    <i class="fa fa-history"></i> History
                </button>
                <button class="cf-agents-chat-back" id="chatBackBtn" title="Back to agents">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                    Back
                </button>
            </div>
        </div>
        <div class="cf-agents-messages" id="agentsMessages"></div>
    </div>

    <!-- Bottom Chat Bar (Perplexity-style) -->
    <div class="cf-agents-chatbar" id="agentsChatbar">
        <div class="cf-agents-chatbar-inner">
            <textarea class="cf-agents-chatinput" id="agentChatInput" rows="1" placeholder="Ask me anything..." autocomplete="off"></textarea>
            <div class="cf-agents-chatbar-toolbar">
                <div class="cf-agents-toolbar-left">
                    <div class="cf-plus-menu-wrap" id="agentPlusWrap">
                        <button class="cf-chat-attach-btn" id="agentPlusBtn" title="More options" type="button">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        </button>
                        <div class="cf-plus-dropdown" id="agentPlusDropdown">
                            <!-- Add Documents or Images -->
                            <button class="cf-plus-dropdown-item" type="button" onclick="document.getElementById('agentFileInput').click(); closeAgentPlusMenu();">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                                <span>Add Documents or Images</span>
                            </button>
                            <!-- Add Agents -->
                            <div class="cf-plus-dropdown-item cf-plus-agents-trigger" onmouseenter="document.getElementById('agentAgentsSub').style.display='block'" onmouseleave="setTimeout(function(){document.getElementById('agentAgentsSub').style.display='none'},200)">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                                <span>Add Agents</span>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left:auto;opacity:0.4;"><polyline points="9 18 15 12 9 6"/></svg>
                                <div class="cf-agents-submenu" id="agentAgentsSub" style="display:none;">
                                    <button type="button" onclick="switchToAgent('compliance'); closeAgentPlusMenu();"><span class="cf-agent-dot" style="background:#8b5cf6;"></span> Company Registration</button>
                                    <button type="button" onclick="switchToAgent('docgen'); closeAgentPlusMenu();"><span class="cf-agent-dot" style="background:#3b82f6;"></span> Document Generator</button>
                                    <button type="button" onclick="switchToAgent('kyc'); closeAgentPlusMenu();"><span class="cf-agent-dot" style="background:#10b981;"></span> KYC Screening</button>
                                    <button type="button" onclick="switchToAgent('ir8a'); closeAgentPlusMenu();"><span class="cf-agent-dot" style="background:#f59e0b;"></span> IR8A / Tax Filing</button>
                                    <button type="button" onclick="switchToAgent('invoice'); closeAgentPlusMenu();"><span class="cf-agent-dot" style="background:#ec4899;"></span> Invoice Manager</button>
                                    <button type="button" onclick="switchToAgent('payroll'); closeAgentPlusMenu();"><span class="cf-agent-dot" style="background:#7c3aed;"></span> SG Payroll</button>
                                </div>
                            </div>
                            <!-- Add Connectors -->
                            <button class="cf-plus-dropdown-item" type="button" onclick="openConnectorsModal(); closeAgentPlusMenu();">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="8" height="8" rx="1"/><rect x="14" y="2" width="8" height="8" rx="1"/><rect x="2" y="14" width="8" height="8" rx="1"/><rect x="14" y="14" width="8" height="8" rx="1"/></svg>
                                <span>Add Connectors</span>
                            </button>
                            <!-- Web Search -->
                            <button class="cf-plus-dropdown-item" type="button" onclick="toggleAgentWebSearch(); closeAgentPlusMenu();">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                <span>Web Search</span>
                                <span class="cf-plus-item-badge" id="agentWebSearchBadge">Auto</span>
                            </button>
                        </div>
                    </div>
                    <input type="file" id="agentFileInput" style="display:none" multiple accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.csv,.txt">
                </div>
                <div class="cf-agents-toolbar-right">
                    <div class="cf-agent-selector-wrap" id="agentSelectorWrap">
                        <button class="cf-agent-selector-btn" id="agentSelectorBtn" title="Switch agent" type="button">
                            <span class="cf-agent-selector-icon" id="agentSelectorIcon"></span>
                            <span id="agentSelectorLabel">Company Registration</span>
                            <svg class="cf-selector-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <div class="cf-agent-dropdown" id="agentDropdown"></div>
                    </div>
                    <div class="cf-model-selector-wrap" id="agentModelWrap">
                        <button class="cf-model-selector-btn" id="agentModelBtn" type="button" title="Select model">
                            <span class="cf-model-dot" id="agentModelDot" style="background:#10b981;"></span>
                            <span id="agentModelLabel">Sonnet 4.6</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <div class="cf-model-dropdown" id="agentModelDropdown"></div>
                    </div>
                    <div class="cf-agent-quick-wrap" id="agentQuickWrap">
                        <button class="cf-model-selector-btn" id="agentQuickBtn" type="button" title="Switch Agent">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            <span id="agentQuickLabel">Agents</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <div class="cf-agent-quick-dropdown" id="agentQuickDropdown"></div>
                    </div>
                    <button class="cf-agents-sendbtn" id="agentSendBtn" title="Send" type="button">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </button>
                </div>
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

/* History button */
.cf-agents-history-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 14px;
    border-radius: 8px;
    border: 1px solid var(--cf-border);
    background: var(--cf-white);
    color: var(--cf-text-secondary);
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
    flex-shrink: 0;
    margin-top: 4px;
}
.cf-agents-history-btn:hover {
    background: var(--cf-primary);
    color: #fff;
    border-color: var(--cf-primary);
}
.cf-agents-page.chatting .cf-agents-history-btn {
    padding: 5px 10px;
    font-size: 12px;
}

/* History Panel */
.cf-agents-history {
    background: var(--cf-bg);
    border: 1px solid var(--cf-border);
    border-radius: var(--cf-radius);
    margin-bottom: 12px;
    flex-shrink: 0;
    max-height: 320px;
    display: flex;
    flex-direction: column;
    animation: fadeSlideDown 0.2s ease-out;
}
@keyframes fadeSlideDown {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}
.cf-agents-history-header {
    padding: 12px 16px;
    border-bottom: 1px solid var(--cf-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
}
.cf-agents-history-header h4 {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
    color: var(--cf-text);
}
.cf-agents-history-close {
    width: 26px; height: 26px;
    border: none;
    background: transparent;
    cursor: pointer;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--cf-text-muted);
    font-size: 13px;
}
.cf-agents-history-close:hover { background: var(--cf-border); color: var(--cf-text); }

.cf-agents-history-list {
    flex: 1;
    overflow-y: auto;
    padding: 6px;
}
.cf-hist-item {
    padding: 10px 12px;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: background 0.15s;
    margin-bottom: 2px;
}
.cf-hist-item:hover { background: var(--cf-white); }
.cf-hist-item-icon {
    width: 30px; height: 30px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.cf-hist-item-info { flex: 1; min-width: 0; }
.cf-hist-item-title {
    font-size: 13px;
    font-weight: 500;
    color: var(--cf-text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.cf-hist-item-meta {
    font-size: 11px;
    color: var(--cf-text-muted);
    margin-top: 1px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.cf-hist-item-badge {
    font-size: 9px;
    padding: 1px 5px;
    border-radius: 3px;
    font-weight: 600;
    color: #fff;
    flex-shrink: 0;
}
.cf-hist-item-del {
    width: 22px; height: 22px;
    border: none;
    background: transparent;
    color: var(--cf-text-muted);
    cursor: pointer;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    opacity: 0;
    flex-shrink: 0;
    transition: opacity 0.15s;
}
.cf-hist-item:hover .cf-hist-item-del { opacity: 1; }
.cf-hist-item-del:hover { background: #fee2e2; color: #ef4444; }
.cf-hist-empty {
    padding: 24px 20px;
    text-align: center;
    color: var(--cf-text-muted);
    font-size: 12px;
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
    position: relative;
}
/* Edit button on card */
.cf-agent-edit-btn {
    position: absolute; top: 12px; right: 12px;
    width: 28px; height: 28px; border-radius: 7px;
    border: none; background: transparent; color: #9ca3af;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    font-size: 13px; opacity: 0; transition: opacity 0.15s, background 0.15s, color 0.15s;
}
.cf-agent-card-v2:hover .cf-agent-edit-btn { opacity: 1; }
.cf-agent-edit-btn:hover { background: #f3f4f6; color: #374151; }
.cf-agents-page.chatting .cf-agent-edit-btn { display: none; }

/* Agent Editor Modal */
.cf-agent-editor-overlay {
    display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:9999;
    align-items:center; justify-content:center;
}
.cf-agent-editor-overlay.open { display:flex; }
.cf-agent-editor {
    background:#fff; border-radius:14px; width:580px; max-width:95vw;
    max-height:85vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,0.2);
}
.cf-agent-editor-header {
    padding:20px 24px; border-bottom:1px solid #e5e7eb;
    display:flex; align-items:center; justify-content:space-between;
}
.cf-agent-editor-header h3 { margin:0; font-size:16px; font-weight:700; }
.cf-agent-editor-close { background:none; border:none; font-size:20px; color:#9ca3af; cursor:pointer; }
.cf-agent-editor-body { padding:20px 24px; }
.cf-agent-editor-body label {
    display:block; font-size:12px; font-weight:600; color:#6b7280;
    margin-bottom:5px; margin-top:16px; text-transform:uppercase; letter-spacing:0.4px;
}
.cf-agent-editor-body label:first-child { margin-top:0; }
.cf-agent-editor-body input,
.cf-agent-editor-body textarea {
    width:100%; padding:9px 12px; border:1px solid #e5e7eb; border-radius:8px;
    font-size:13px; font-family:inherit; color:#1f2937; outline:none;
}
.cf-agent-editor-body input:focus,
.cf-agent-editor-body textarea:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.1); }
.cf-agent-editor-body textarea { min-height:120px; resize:vertical; font-family:monospace; font-size:12px; line-height:1.5; }
.cf-agent-editor-footer {
    padding:16px 24px; border-top:1px solid #e5e7eb;
    display:flex; justify-content:flex-end; gap:10px;
}
.cf-agent-editor-footer .btn-save {
    padding:9px 22px; border-radius:8px; border:none; background:#6366f1;
    color:#fff; font-size:13px; font-weight:600; cursor:pointer;
}
.cf-agent-editor-footer .btn-save:hover { background:#4f46e5; }
.cf-agent-editor-footer .btn-cancel {
    padding:9px 22px; border-radius:8px; border:1px solid #e5e7eb; background:#fff;
    color:#374151; font-size:13px; font-weight:500; cursor:pointer;
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

/* ── Bottom Chat Bar (Perplexity-style) ─────────────────────────────────── */
.cf-agents-chatbar {
    flex-shrink: 0;
    padding: 12px 0 16px;
    background: linear-gradient(to top, #f4f6f9 60%, transparent);
    z-index: 20;
}
.cf-agents-chatbar-inner {
    display: flex;
    flex-direction: column;
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    overflow: visible;
    transition: border-color 0.15s;
    position: relative;
}
.cf-agents-chatbar-inner:focus-within {
    border-color: var(--cf-accent, #4f86c6);
    box-shadow: 0 4px 24px rgba(79,134,198,0.12);
}
.cf-agents-chatinput {
    width: 100%;
    border: none;
    outline: none;
    resize: none;
    font-size: 15px;
    color: var(--cf-text, #1e293b);
    background: transparent;
    padding: 14px 18px 6px;
    min-width: 0;
    min-height: 24px;
    max-height: 160px;
    line-height: 1.5;
    font-family: var(--cf-font, inherit) !important;
    box-sizing: border-box;
    border-radius: 16px 16px 0 0;
}
.cf-agents-chatinput::placeholder { color: #94a3b8; }
.cf-agents-chatinput:focus { outline: none !important; outline-style: none !important; box-shadow: none !important; }

.cf-agents-chatbar-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 4px 8px 8px 10px;
}
.cf-agents-toolbar-left {
    display: flex;
    align-items: center;
    gap: 4px;
}
.cf-agents-toolbar-right {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}
/* Attach button (shared style) */
.cf-chat-attach-btn {
    width: 32px; height: 32px;
    border-radius: 8px;
    border: none;
    background: transparent;
    color: #94a3b8;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
}
.cf-chat-attach-btn:hover {
    background: #f1f5f9;
    color: var(--cf-text, #1e293b);
}
/* Plus Menu */
.cf-plus-menu-wrap {
    position: relative;
}
.cf-plus-dropdown {
    display: none;
    position: fixed;
    min-width: 200px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    padding: 6px;
    z-index: 9999;
    animation: cfPlusDropIn 0.15s ease;
}
.cf-plus-dropdown.open { display: block; }
@keyframes cfPlusDropIn {
    from { opacity: 0; transform: translateY(4px); }
    to { opacity: 1; transform: translateY(0); }
}
.cf-plus-dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    border-radius: 10px;
    cursor: pointer;
    transition: background 0.12s;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    font-size: 14px;
    font-weight: 500;
    color: var(--cf-text, #1e293b);
    font-family: var(--cf-font, inherit) !important;
}
.cf-plus-dropdown-item:hover { background: #f5f7fa; }
.cf-plus-dropdown-item svg { color: #64748b; flex-shrink: 0; }
.cf-plus-dropdown-item:hover svg { color: var(--cf-text, #1e293b); }
/* Agents submenu */
.cf-plus-agents-trigger { position: relative; }
.cf-agents-submenu {
    position: absolute; left: 100%; top: -6px; min-width: 220px;
    background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12); padding: 6px; z-index: 10000; margin-left: 4px;
}
.cf-agents-submenu button {
    display: flex; align-items: center; gap: 8px; padding: 9px 14px; border-radius: 8px;
    cursor: pointer; border: none; background: none; width: 100%; text-align: left;
    font-size: 13px; font-weight: 500; color: var(--cf-text, #1e293b);
    font-family: var(--cf-font, inherit) !important; transition: background 0.12s;
}
.cf-agents-submenu button:hover { background: #f5f7fa; }
.cf-agent-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
.cf-plus-item-badge {
    margin-left: auto;
    font-size: 11px;
    font-weight: 600;
    color: var(--cf-accent, #4f86c6);
    background: #eef2ff;
    padding: 2px 8px;
    border-radius: 10px;
}
/* Model Selector (shared between pages) */
.cf-model-selector-wrap {
    position: relative;
}
.cf-model-selector-btn {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border: 1.5px solid #e5e7eb;
    border-radius: 20px;
    background: #f8fafc;
    color: var(--cf-text-secondary, #64748b);
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.15s;
    font-family: var(--cf-font, inherit) !important;
}
.cf-model-selector-btn:hover {
    border-color: #c7d2fe;
    background: #f5f3ff;
    color: var(--cf-text, #1e293b);
}
.cf-model-selector-btn .cf-model-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}
.cf-model-dropdown {
    display: none;
    position: fixed;
    min-width: 220px;
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 14px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    padding: 6px;
    z-index: 9999;
    animation: cfModelDropIn 0.15s ease;
}
.cf-model-dropdown.open { display: block; }
@keyframes cfModelDropIn {
    from { opacity: 0; transform: translateY(6px); }
    to { opacity: 1; transform: translateY(0); }
}
.cf-model-dropdown-item {
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
    font-size: 13px;
    color: var(--cf-text, #1e293b);
}
.cf-model-dropdown-item:hover { background: #f5f3ff; }
.cf-model-dropdown-item.active { background: #eef2ff; }
.cf-model-dropdown-item .cf-model-item-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    flex-shrink: 0;
}
.cf-model-dropdown-item .cf-model-item-info { flex: 1; }
.cf-model-dropdown-item .cf-model-item-name { font-weight: 600; font-size: 13px; }
.cf-model-dropdown-item .cf-model-item-desc { font-size: 11px; color: #94a3b8; margin-top: 1px; }
.cf-model-dropdown-item .cf-model-check {
    color: var(--cf-accent, #4f86c6);
    opacity: 0;
    flex-shrink: 0;
}
.cf-model-dropdown-item.active .cf-model-check { opacity: 1; }

/* Agent Quick Selector */
.cf-agent-quick-wrap { position: relative; }
.cf-agent-quick-dropdown {
    display: none;
    position: fixed;
    min-width: 240px;
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 14px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    padding: 6px;
    z-index: 9999;
    animation: cfModelDropIn 0.15s ease;
}
.cf-agent-quick-dropdown.open { display: block; }
.cf-agent-quick-item {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px; border-radius: 10px; cursor: pointer;
    border: none; background: none; width: 100%; text-align: left;
    font-size: 13px; color: #1e293b; transition: background 0.12s;
}
.cf-agent-quick-item:hover { background: #f5f3ff; }
.cf-agent-quick-item.active { background: #eef2ff; }
.cf-agent-quick-item .cf-aq-dot {
    width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0;
}
.cf-agent-quick-item .cf-aq-name { font-weight: 600; font-size: 13px; }
.cf-agent-quick-item .cf-aq-check {
    color: #4f86c6; opacity: 0; flex-shrink: 0; margin-left: auto;
}
.cf-agent-quick-item.active .cf-aq-check { opacity: 1; }

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
    position: fixed;
    min-width: 260px;
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 14px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    padding: 6px;
    z-index: 9999;
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
    width: 34px;
    height: 34px;
    border-radius: 10px;
    border: none;
    background: var(--cf-primary, #1e3a5f);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.15s;
    flex-shrink: 0;
}
.cf-agents-sendbtn:hover {
    background: var(--cf-primary-light, #2a4f7a);
}
.cf-agents-sendbtn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
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
    var agentConversationId = 0; /* Track conversation for multi-turn */

    /* ── Model selector state ── */
    var cfAgentModels = [
        { id: 'claude-sonnet-4-6', label: 'Sonnet 4.6', desc: 'Fast & intelligent', color: '#10b981' },
        { id: 'claude-opus-4-6', label: 'Opus 4.6', desc: 'Most intelligent', color: '#8b5cf6' },
        { id: 'claude-haiku-4-5-20251001', label: 'Haiku 4.5', desc: 'Fastest responses', color: '#f59e0b' }
    ];
    var agentSelectedModelIndex = 0;

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

    /* ── Textarea auto-grow ── */
    chatInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 160) + 'px';
    });

    /* ── Model Selector ── */
    function buildAgentModelDropdown() {
        var dd = document.getElementById('agentModelDropdown');
        dd.innerHTML = '';
        cfAgentModels.forEach(function(m, i) {
            var item = document.createElement('button');
            item.type = 'button';
            item.className = 'cf-model-dropdown-item' + (i === agentSelectedModelIndex ? ' active' : '');
            item.innerHTML =
                '<span class="cf-model-item-dot" style="background:' + m.color + '"></span>' +
                '<span class="cf-model-item-info">' +
                    '<span class="cf-model-item-name">' + m.label + '</span>' +
                    '<span class="cf-model-item-desc">' + m.desc + '</span>' +
                '</span>' +
                '<svg class="cf-model-check" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
            item.addEventListener('click', function(e) {
                e.stopPropagation();
                agentSelectedModelIndex = i;
                document.getElementById('agentModelLabel').textContent = m.label;
                document.getElementById('agentModelDot').style.background = m.color;
                closeAgentModelDropdown();
            });
            dd.appendChild(item);
        });
    }
    function openAgentModelDropdown() {
        buildAgentModelDropdown();
        var dd = document.getElementById('agentModelDropdown');
        var btn = document.getElementById('agentModelBtn');
        var rect = btn.getBoundingClientRect();
        dd.style.bottom = (window.innerHeight - rect.top + 8) + 'px';
        dd.style.right = (window.innerWidth - rect.right) + 'px';
        dd.classList.add('open');
    }
    function closeAgentModelDropdown() {
        document.getElementById('agentModelDropdown').classList.remove('open');
    }
    document.getElementById('agentModelBtn').addEventListener('click', function(e) {
        e.stopPropagation();
        var dd = document.getElementById('agentModelDropdown');
        if (dd.classList.contains('open')) { closeAgentModelDropdown(); } else { openAgentModelDropdown(); }
    });

    /* ── Agents Quick Selector ── */
    function buildAgentQuickDropdown() {
        var dd = document.getElementById('agentQuickDropdown');
        dd.innerHTML = '';
        cards.forEach(function(card) {
            var key = card.getAttribute('data-agent');
            var label = card.getAttribute('data-label');
            var color = card.getAttribute('data-color') || 'purple';
            var dotColors = { purple:'#7c3aed', blue:'#3b82f6', green:'#059669', amber:'#d97706', pink:'#db2777', violet:'#8b5cf6' };
            var item = document.createElement('button');
            item.type = 'button';
            item.className = 'cf-agent-quick-item' + (selectedAgent === key ? ' active' : '');
            item.innerHTML =
                '<span class="cf-aq-dot" style="background:' + (dotColors[color] || '#6b7280') + '"></span>' +
                '<span class="cf-aq-name">' + label + '</span>' +
                '<svg class="cf-aq-check" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
            item.addEventListener('click', function(e) {
                e.stopPropagation();
                selectCard(card);
                document.getElementById('agentQuickLabel').textContent = label;
                closeAgentQuickDropdown();
            });
            dd.appendChild(item);
        });
    }
    function openAgentQuickDropdown() {
        buildAgentQuickDropdown();
        var dd = document.getElementById('agentQuickDropdown');
        var btn = document.getElementById('agentQuickBtn');
        var rect = btn.getBoundingClientRect();
        dd.style.bottom = (window.innerHeight - rect.top + 8) + 'px';
        dd.style.right = (window.innerWidth - rect.right) + 'px';
        dd.classList.add('open');
    }
    function closeAgentQuickDropdown() {
        document.getElementById('agentQuickDropdown').classList.remove('open');
    }
    document.getElementById('agentQuickBtn').addEventListener('click', function(e) {
        e.stopPropagation();
        var dd = document.getElementById('agentQuickDropdown');
        closeAgentModelDropdown();
        if (dd.classList.contains('open')) { closeAgentQuickDropdown(); } else { openAgentQuickDropdown(); }
    });
    /* Close on outside click */
    document.addEventListener('click', function() { closeAgentQuickDropdown(); });

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
        compliance: 'You are the Company Registration agent. Focus on AGM, AR, FYE deadlines, regulatory filings, and compliance alerts.',
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
        agentConversationId = 0; /* Reset for new conversation */
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
                agentConversationId = 0; /* New agent = new conversation */
                if (isChatting) {
                    addMessage('assistant', 'Switched to **' + label + '**. How can I help?');
                }
            });
            dropdown.appendChild(item);
        });
    }

    function openDropdown() {
        buildDropdown();
        var btn = document.getElementById('agentSelectorBtn');
        var rect = btn.getBoundingClientRect();
        dropdown.style.bottom = (window.innerHeight - rect.top + 8) + 'px';
        dropdown.style.right = (window.innerWidth - rect.right) + 'px';
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

    /* ── Plus Menu ── */
    function openAgentPlusMenu() {
        var dd = document.getElementById('agentPlusDropdown');
        var btn = document.getElementById('agentPlusBtn');
        var rect = btn.getBoundingClientRect();
        dd.style.bottom = (window.innerHeight - rect.top + 8) + 'px';
        dd.style.left = rect.left + 'px';
        dd.classList.add('open');
    }
    function closeAgentPlusMenu() {
        document.getElementById('agentPlusDropdown').classList.remove('open');
    }
    document.getElementById('agentPlusBtn').addEventListener('click', function(e) {
        e.stopPropagation();
        var dd = document.getElementById('agentPlusDropdown');
        if (dd.classList.contains('open')) { closeAgentPlusMenu(); } else { openAgentPlusMenu(); }
    });

    /* ── File attachment state ── */
    var agentPendingFiles = []; // { name, type, data (base64 dataURL) }

    function showAgentFileBadges() {
        var existing = document.getElementById('agentFileBadges');
        if (existing) existing.remove();
        if (!agentPendingFiles.length) return;
        var wrap = document.createElement('div');
        wrap.id = 'agentFileBadges';
        wrap.style.cssText = 'display:flex;flex-wrap:wrap;gap:6px;padding:6px 18px 2px;';
        agentPendingFiles.forEach(function(f, idx) {
            var badge = document.createElement('span');
            badge.style.cssText = 'display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:8px;background:#f1f5f9;font-size:12px;color:#475569;font-weight:500;';
            var isImg = /^image\//.test(f.type);
            var isPdf = /pdf/i.test(f.type) || /\.pdf$/i.test(f.name);
            var icon = isPdf ? '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>' :
                       isImg ? '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>' :
                       '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/></svg>';
            badge.innerHTML = icon + '<span>' + f.name.substring(0, 25) + (f.name.length > 25 ? '...' : '') + '</span>' +
                '<button onclick="removeAgentFile(' + idx + ')" style="background:none;border:none;cursor:pointer;color:#94a3b8;padding:0 0 0 2px;font-size:14px;line-height:1;">&times;</button>';
            wrap.appendChild(badge);
        });
        // Insert before toolbar
        var toolbar = document.querySelector('.cf-agents-chatbar-toolbar');
        toolbar.parentNode.insertBefore(wrap, toolbar);
    }

    window.removeAgentFile = function(idx) {
        agentPendingFiles.splice(idx, 1);
        showAgentFileBadges();
    };

    /* File upload handler — reads file content as base64 */
    document.getElementById('agentFileInput').addEventListener('change', function(e) {
        var files = e.target.files;
        if (!files || !files.length) return;
        var remaining = files.length;
        for (var i = 0; i < files.length; i++) {
            (function(file) {
                var reader = new FileReader();
                reader.onload = function(ev) {
                    agentPendingFiles.push({
                        name: file.name,
                        type: file.type || 'application/octet-stream',
                        data: ev.target.result // base64 data URL
                    });
                    remaining--;
                    if (remaining <= 0) {
                        showAgentFileBadges();
                        chatInput.focus();
                    }
                };
                reader.readAsDataURL(file);
            })(files[i]);
        }
        e.target.value = '';
    });

    /* Switch to agent from + menu submenu */
    window.switchToAgent = function(agentKey) {
        var card = document.querySelector('.cf-agent-card-v2[data-agent="' + agentKey + '"]');
        if (card) {
            card.click();
        }
    };

    /* Web Search toggle */
    var agentWebSearchEnabled = true;
    window.toggleAgentWebSearch = function() {
        agentWebSearchEnabled = !agentWebSearchEnabled;
        var badge = document.getElementById('agentWebSearchBadge');
        badge.textContent = agentWebSearchEnabled ? 'Auto' : 'Off';
        badge.style.background = agentWebSearchEnabled ? '#eef2ff' : '#f1f5f9';
        badge.style.color = agentWebSearchEnabled ? 'var(--cf-accent, #4f86c6)' : '#94a3b8';
    };

    /* Close dropdowns on outside click */
    document.addEventListener('click', function() {
        closeDropdown();
        closeAgentModelDropdown();
        closeAgentPlusMenu();
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

    /* Use shared markdown renderer from main layout */
    function renderMarkdown(text) {
        return (typeof cfRenderMarkdown === 'function') ? cfRenderMarkdown(text) : text;
    }

    /* ── Send message ── */
    function sendMessage() {
        if (isSending) return;
        var message = chatInput.value.trim();
        if (!message && !agentPendingFiles.length) return;
        if (!message) message = 'Please analyze the attached file(s).';
        chatInput.value = '';
        chatInput.style.height = 'auto';

        if (!isChatting) enterChatMode();

        /* Show user message with file badges */
        var displayMsg = message;
        if (agentPendingFiles.length) {
            var fileNames = agentPendingFiles.map(function(f) { return f.name; });
            displayMsg = '[Attached: ' + fileNames.join(', ') + ']\n' + message;
        }
        addMessage('user', displayMsg);
        addTyping();

        isSending = true;
        sendBtn.disabled = true;

        /* Build enriched message with agent context */
        var hint = agentSystemHints[selectedAgent] || '';
        var enrichedMsg = hint ? '[Agent: ' + (selectedAgent || 'general') + '] ' + message : message;

        /* Collect file attachments */
        var attachments = agentPendingFiles.map(function(f) {
            return { name: f.name, type: f.type, data: f.data };
        });
        agentPendingFiles = [];
        showAgentFileBadges(); /* Clear badges */

        var controller = new AbortController();
        var timeoutId = setTimeout(function() { controller.abort(); }, 180000);

        var payload = {
            message: enrichedMsg,
            source: 'agent',
            agent: selectedAgent || 'general',
            conversation_id: agentConversationId || 0,
            model: cfAgentModels[agentSelectedModelIndex].id
        };
        if (attachments.length) payload.attachments = attachments;

        fetch(BASE_URL + 'ai/chat', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
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

            /* Track conversation_id for multi-turn */
            if (data.conversation_id) {
                agentConversationId = data.conversation_id;
            }

            if (data.ok && data.response_text) {
                var row = addMessage('assistant', data.response_text);
                if (typeof cfMakeActionBar === 'function') {
                    var bubble = row.querySelector('.cf-agent-msg-bubble');
                    if (bubble) bubble.appendChild(cfMakeActionBar(data.response_text, function() {
                        /* Redo: resend the last user message */
                        var msgs = msgArea.querySelectorAll('.cf-agent-msg.user');
                        if (msgs.length) {
                            chatInput.value = msgs[msgs.length - 1].querySelector('.cf-agent-msg-bubble').textContent;
                            row.remove();
                            sendMessage();
                        }
                    }));
                }
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

    /* ── Agent History Panel ── */
    var historyPanel = document.getElementById('agentHistoryPanel');
    var historyList = document.getElementById('agentHistoryList');
    var historyOpen = false;

    var agentColorMap = {
        compliance: { bg: '#ede9fe', fg: '#7c3aed', label: 'Compliance' },
        docgen:     { bg: '#dbeafe', fg: '#3b82f6', label: 'Doc Gen' },
        kyc:        { bg: '#d1fae5', fg: '#059669', label: 'KYC' },
        ir8a:       { bg: '#fef3c7', fg: '#d97706', label: 'IR8A/Tax' },
        tax:        { bg: '#fef3c7', fg: '#d97706', label: 'IR8A/Tax' },
        invoice:    { bg: '#fce7f3', fg: '#db2777', label: 'Invoice' },
        payroll:    { bg: '#ede9fe', fg: '#8b5cf6', label: 'Payroll' }
    };

    window.toggleAgentHistory = function() {
        historyOpen = !historyOpen;
        historyPanel.style.display = historyOpen ? '' : 'none';
        if (historyOpen) loadAgentHistory();
    };

    function loadAgentHistory() {
        historyList.innerHTML = '<div style="padding:20px;text-align:center;color:var(--cf-text-muted);font-size:12px;"><i class="fa fa-spinner fa-spin"></i> Loading...</div>';

        fetch(BASE_URL + 'ai/conversations')
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (!data.ok || !data.conversations || data.conversations.length === 0) {
                historyList.innerHTML = '<div class="cf-hist-empty">No agent conversations yet.<br>Start chatting with an agent!</div>';
                return;
            }
            historyList.innerHTML = '';
            /* Filter to agent-source conversations only */
            var agentConvs = data.conversations.filter(function(c) { return c.source === 'agent'; });
            if (agentConvs.length === 0) {
                historyList.innerHTML = '<div class="cf-hist-empty">No agent conversations yet.</div>';
                return;
            }
            agentConvs.forEach(function(conv) {
                var ac = agentColorMap[conv.agent] || { bg: '#e5e7eb', fg: '#6b7280', label: conv.agent || 'Agent' };

                var item = document.createElement('div');
                item.className = 'cf-hist-item';

                /* Icon */
                var icon = document.createElement('div');
                icon.className = 'cf-hist-item-icon';
                icon.style.background = ac.bg;
                icon.style.color = ac.fg;
                /* Find matching card icon */
                var matchCard = document.querySelector('.cf-agent-card-v2[data-agent="' + conv.agent + '"]');
                if (matchCard) {
                    icon.innerHTML = matchCard.querySelector('.cf-agent-icon-circle').innerHTML
                        .replace(/width="22"/g, 'width="16"').replace(/height="22"/g, 'height="16"');
                } else {
                    icon.innerHTML = '<i class="fa fa-bolt" style="font-size:14px;"></i>';
                }

                /* Info */
                var info = document.createElement('div');
                info.className = 'cf-hist-item-info';

                var titleRow = document.createElement('div');
                titleRow.className = 'cf-hist-item-title';
                titleRow.textContent = conv.title || 'New Chat';

                var meta = document.createElement('div');
                meta.className = 'cf-hist-item-meta';

                var badge = document.createElement('span');
                badge.className = 'cf-hist-item-badge';
                badge.style.background = ac.fg;
                badge.textContent = ac.label;

                var time = document.createElement('span');
                time.textContent = formatAgentTime(conv.updated_at) + ' \u00B7 ' + conv.msg_count + ' msgs';

                meta.appendChild(badge);
                meta.appendChild(time);
                info.appendChild(titleRow);
                info.appendChild(meta);

                /* Delete button */
                var del = document.createElement('button');
                del.className = 'cf-hist-item-del';
                del.title = 'Delete';
                del.innerHTML = '<i class="fa fa-trash"></i>';
                del.onclick = function(e) {
                    e.stopPropagation();
                    if (!confirm('Delete this conversation?')) return;
                    fetch(BASE_URL + 'ai/deleteConversation', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: conv.id })
                    }).then(function() { loadAgentHistory(); });
                };

                item.appendChild(icon);
                item.appendChild(info);
                item.appendChild(del);

                /* Click to load conversation */
                item.onclick = function() {
                    resumeAgentConversation(conv);
                };

                historyList.appendChild(item);
            });
        })
        .catch(function() {
            historyList.innerHTML = '<div class="cf-hist-empty">Could not load history.</div>';
        });
    }

    function resumeAgentConversation(conv) {
        /* Select the matching agent card */
        var matchCard = document.querySelector('.cf-agent-card-v2[data-agent="' + conv.agent + '"]');
        if (matchCard) selectCard(matchCard);

        /* Set conversation id for multi-turn */
        agentConversationId = conv.id;

        /* Enter chat mode */
        if (!isChatting) {
            isChatting = true;
            page.classList.add('chatting');
        }
        msgArea.innerHTML = '';

        /* Close history panel */
        historyOpen = false;
        historyPanel.style.display = 'none';

        /* Load messages */
        var loadingEl = document.createElement('div');
        loadingEl.className = 'cf-agent-typing';
        loadingEl.innerHTML = '<div class="cf-agent-typing-dots"><span></span><span></span><span></span></div>';
        msgArea.appendChild(loadingEl);

        fetch(BASE_URL + 'ai/conversation?id=' + conv.id)
        .then(function(r) { return r.json(); })
        .then(function(data) {
            msgArea.innerHTML = '';
            if (data.ok && data.messages && data.messages.length > 0) {
                data.messages.forEach(function(msg) {
                    addMessage(msg.role, msg.content);
                });
            } else {
                addMessage('assistant', 'Conversation loaded. Send a message to continue.');
            }
            msgArea.scrollTop = msgArea.scrollHeight;
        })
        .catch(function() {
            msgArea.innerHTML = '';
            addMessage('assistant', '**Error:** Could not load conversation messages.');
        });
    }

    function formatAgentTime(dateStr) {
        if (!dateStr) return '';
        var d = new Date(dateStr);
        var now = new Date();
        var diff = (now - d) / 1000;
        if (diff < 60) return 'Just now';
        if (diff < 3600) return Math.floor(diff / 60) + 'm ago';
        if (diff < 86400) return Math.floor(diff / 3600) + 'h ago';
        if (diff < 604800) return Math.floor(diff / 86400) + 'd ago';
        return d.toLocaleDateString('en-SG', { day: 'numeric', month: 'short' });
    }

    /* ── Auto-fill from URL param ── */
    var urlParams = new URLSearchParams(window.location.search);
    var promptParam = urlParams.get('prompt');
    if (promptParam) {
        chatInput.value = promptParam;
        /* Small delay so the page renders first */
        setTimeout(function() { sendMessage(); }, 300);
    }

    /* ── Agent Editor ── */
    var editingAgent = null;

    window.openAgentEditor = function(agentKey) {
        editingAgent = agentKey;
        var card = document.querySelector('.cf-agent-card-v2[data-agent="' + agentKey + '"]');
        if (!card) return;

        var name = card.getAttribute('data-label') || '';
        var desc = card.querySelector('.cf-agent-card-desc').textContent || '';
        var prompt = card.getAttribute('data-prompt') || '';
        var systemHint = agentSystemHints[agentKey] || '';

        document.getElementById('agentEditorTitle').textContent = 'Edit Agent: ' + name;
        document.getElementById('agentEditName').value = name;
        document.getElementById('agentEditDesc').value = desc;
        document.getElementById('agentEditPrompt').value = prompt;
        document.getElementById('agentEditSystem').value = systemHint;
        document.getElementById('agentEditorOverlay').classList.add('open');
    };

    window.closeAgentEditor = function() {
        document.getElementById('agentEditorOverlay').classList.remove('open');
        editingAgent = null;
    };

    window.saveAgentEditor = function() {
        if (!editingAgent) return;
        var card = document.querySelector('.cf-agent-card-v2[data-agent="' + editingAgent + '"]');
        if (!card) return;

        var newName = document.getElementById('agentEditName').value.trim();
        var newDesc = document.getElementById('agentEditDesc').value.trim();
        var newPrompt = document.getElementById('agentEditPrompt').value.trim();
        var newSystem = document.getElementById('agentEditSystem').value.trim();

        /* Update card */
        if (newName) {
            card.setAttribute('data-label', newName);
            card.querySelector('.cf-agent-card-name').textContent = newName;
        }
        if (newDesc) {
            card.querySelector('.cf-agent-card-desc').textContent = newDesc;
        }
        if (newPrompt) {
            card.setAttribute('data-prompt', newPrompt);
        }
        if (newSystem) {
            agentSystemHints[editingAgent] = newSystem;
        }

        /* Update chat header if this agent is currently selected */
        if (selectedAgent === editingAgent && newName) {
            document.getElementById('chatAgentName').textContent = newName;
            document.getElementById('agentSelectorLabel').textContent = newName;
        }

        closeAgentEditor();
    };
})();
</script>

<!-- Agent Editor Modal -->
<div class="cf-agent-editor-overlay" id="agentEditorOverlay" onclick="if(event.target===this)closeAgentEditor()">
    <div class="cf-agent-editor">
        <div class="cf-agent-editor-header">
            <h3 id="agentEditorTitle">Edit Agent</h3>
            <button class="cf-agent-editor-close" onclick="closeAgentEditor()">&times;</button>
        </div>
        <div class="cf-agent-editor-body">
            <label>Agent Name</label>
            <input type="text" id="agentEditName" placeholder="e.g. Company Registration">

            <label>Description</label>
            <input type="text" id="agentEditDesc" placeholder="Short description of what this agent does">

            <label>Default Prompt</label>
            <input type="text" id="agentEditPrompt" placeholder="Default message when this agent is selected">

            <label>System Prompt (Instructions to AI)</label>
            <textarea id="agentEditSystem" placeholder="Define the agent's behavior, expertise, and response style..."></textarea>
        </div>
        <div class="cf-agent-editor-footer">
            <button class="btn-cancel" onclick="closeAgentEditor()">Cancel</button>
            <button class="btn-save" onclick="saveAgentEditor()">Save Changes</button>
        </div>
    </div>
</div>

<!-- Connectors Modal (shared) -->
<script>
function openConnectorsModal() { document.getElementById('connectorsModalAgent').style.display = 'flex'; document.getElementById('connSearchAgent').value = ''; filterConnAgent(); }
function closeConnectorsModal() { document.getElementById('connectorsModalAgent').style.display = 'none'; }
function filterConnAgent() { var q=(document.getElementById('connSearchAgent').value||'').toLowerCase(); document.querySelectorAll('#connectorsModalAgent .conn-card').forEach(function(c){c.style.display=(!q||(c.dataset.name+' '+c.dataset.desc).toLowerCase().indexOf(q)!==-1)?'':'none';}); }
function toggleConnector(el) { el.classList.toggle('connected'); var b=el.querySelector('.conn-add-btn'); b.innerHTML=el.classList.contains('connected')?'<i class="fa fa-check"></i>':'<i class="fa fa-plus"></i>'; }
</script>
<div class="conn-modal-overlay" id="connectorsModalAgent" style="display:none;" onclick="if(event.target===this)closeConnectorsModal()">
<div class="conn-modal">
    <div class="conn-modal-header"><div><h2 style="margin:0;font-size:22px;font-weight:700;">Connectors</h2><p style="margin:4px 0 0;font-size:13px;color:var(--cf-text-secondary);">Connect CorpFile AI to your apps, government portals, and services.</p></div><button class="conn-close" onclick="closeConnectorsModal()">&times;</button></div>
    <div class="conn-toolbar"><input type="text" class="conn-search" id="connSearchAgent" placeholder="Search connectors..." oninput="filterConnAgent()"></div>
    <div class="conn-grid">
        <div class="conn-card" data-name="ACRA BizFile+" data-desc="File annual returns company changes" onclick="toggleConnector(this)"><div class="conn-icon" style="background:#206570;color:#fff;font-weight:700;font-size:14px;">A</div><div class="conn-body"><div class="conn-name">ACRA BizFile+ <span class="conn-tag popular">Government</span></div><div class="conn-desc">File annual returns, company changes, and search business profiles</div></div><button class="conn-add-btn"><i class="fa fa-plus"></i></button></div>
        <div class="conn-card" data-name="IRAS" data-desc="Tax filing stamp duty GST" onclick="toggleConnector(this)"><div class="conn-icon" style="background:#e74c3c;color:#fff;font-weight:700;font-size:14px;">I</div><div class="conn-body"><div class="conn-name">IRAS <span class="conn-tag popular">Government</span></div><div class="conn-desc">Tax filing, stamp duty, GST returns, and IR8A submissions</div></div><button class="conn-add-btn"><i class="fa fa-plus"></i></button></div>
        <div class="conn-card" data-name="CPF Board" data-desc="CPF contributions employer" onclick="toggleConnector(this)"><div class="conn-icon" style="background:#f59e0b;color:#fff;font-weight:700;font-size:14px;">C</div><div class="conn-body"><div class="conn-name">CPF Board <span class="conn-tag popular">Government</span></div><div class="conn-desc">CPF contributions, submission, and employer obligations</div></div><button class="conn-add-btn"><i class="fa fa-plus"></i></button></div>
        <div class="conn-card" data-name="CorpPass" data-desc="Corporate digital identity" onclick="toggleConnector(this)"><div class="conn-icon" style="background:#3b82f6;color:#fff;font-weight:700;font-size:14px;">CP</div><div class="conn-body"><div class="conn-name">CorpPass <span class="conn-tag">Government</span></div><div class="conn-desc">Corporate digital identity for government e-services</div></div><button class="conn-add-btn"><i class="fa fa-plus"></i></button></div>
        <div class="conn-card" data-name="MOM" data-desc="Work passes employment" onclick="toggleConnector(this)"><div class="conn-icon" style="background:#8b5cf6;color:#fff;font-weight:700;font-size:14px;">M</div><div class="conn-body"><div class="conn-name">MOM WorkPass <span class="conn-tag">Government</span></div><div class="conn-desc">Work passes, employment act compliance, foreign worker management</div></div><button class="conn-add-btn"><i class="fa fa-plus"></i></button></div>
        <div class="conn-card" data-name="MyInfo Business" data-desc="KYC verification" onclick="toggleConnector(this)"><div class="conn-icon" style="background:#10b981;color:#fff;font-weight:700;font-size:12px;">Mi</div><div class="conn-body"><div class="conn-name">MyInfo Business <span class="conn-tag">Government</span></div><div class="conn-desc">KYC verification and corporate entity data from government</div></div><button class="conn-add-btn"><i class="fa fa-plus"></i></button></div>
        <div class="conn-card" data-name="Xero" data-desc="Accounting invoices" onclick="toggleConnector(this)"><div class="conn-icon" style="background:#13B5EA;color:#fff;font-weight:700;font-size:14px;">X</div><div class="conn-body"><div class="conn-name">Xero <span class="conn-tag">Accounting</span></div><div class="conn-desc">Sync accounting data, invoices, bank feeds, and financial reports</div></div><button class="conn-add-btn"><i class="fa fa-plus"></i></button></div>
        <div class="conn-card" data-name="QuickBooks" data-desc="Accounting payroll" onclick="toggleConnector(this)"><div class="conn-icon" style="background:#2CA01C;color:#fff;font-weight:700;font-size:12px;">QB</div><div class="conn-body"><div class="conn-name">QuickBooks <span class="conn-tag">Accounting</span></div><div class="conn-desc">Accounting, invoicing, expense tracking, and payroll</div></div><button class="conn-add-btn"><i class="fa fa-plus"></i></button></div>
        <div class="conn-card" data-name="Google Workspace" data-desc="Gmail Calendar Drive" onclick="toggleConnector(this)"><div class="conn-icon" style="background:#fff;border:1px solid #e5e7eb;"><span style="font-size:18px;">G</span></div><div class="conn-body"><div class="conn-name">Google Workspace <span class="conn-tag">Productivity</span></div><div class="conn-desc">Gmail, Calendar, Drive — email, scheduling, file storage</div></div><button class="conn-add-btn"><i class="fa fa-plus"></i></button></div>
        <div class="conn-card" data-name="Microsoft 365" data-desc="Outlook Teams OneDrive" onclick="toggleConnector(this)"><div class="conn-icon" style="background:#0078D4;color:#fff;font-weight:700;font-size:12px;">MS</div><div class="conn-body"><div class="conn-name">Microsoft 365 <span class="conn-tag">Productivity</span></div><div class="conn-desc">Outlook, Teams, OneDrive — enterprise collaboration</div></div><button class="conn-add-btn"><i class="fa fa-plus"></i></button></div>
        <div class="conn-card" data-name="Slack" data-desc="Messages notifications" onclick="toggleConnector(this)"><div class="conn-icon" style="background:#4A154B;color:#fff;font-weight:700;font-size:14px;">S</div><div class="conn-body"><div class="conn-name">Slack <span class="conn-tag">Communication</span></div><div class="conn-desc">Send notifications, search messages, automate workflows</div></div><button class="conn-add-btn"><i class="fa fa-plus"></i></button></div>
        <div class="conn-card" data-name="DocuSign" data-desc="e-signature signing" onclick="toggleConnector(this)"><div class="conn-icon" style="background:#FFD23F;color:#000;font-weight:700;font-size:12px;">DS</div><div class="conn-body"><div class="conn-name">DocuSign <span class="conn-tag">eSign</span></div><div class="conn-desc">Send for e-signature, track signing, manage envelopes</div></div><button class="conn-add-btn"><i class="fa fa-plus"></i></button></div>
        <div class="conn-card" data-name="Stripe" data-desc="Payments subscriptions" onclick="toggleConnector(this)"><div class="conn-icon" style="background:#635BFF;color:#fff;font-weight:700;font-size:14px;">S</div><div class="conn-body"><div class="conn-name">Stripe <span class="conn-tag">Payments</span></div><div class="conn-desc">Accept payments, manage subscriptions, track revenue</div></div><button class="conn-add-btn"><i class="fa fa-plus"></i></button></div>
        <div class="conn-card" data-name="Dropbox" data-desc="Cloud storage files" onclick="toggleConnector(this)"><div class="conn-icon" style="background:#0061FF;color:#fff;font-weight:700;font-size:12px;">DB</div><div class="conn-body"><div class="conn-name">Dropbox <span class="conn-tag">Storage</span></div><div class="conn-desc">Cloud document storage, sharing, version control</div></div><button class="conn-add-btn"><i class="fa fa-plus"></i></button></div>
        <div class="conn-card" data-name="Notion" data-desc="Workspace wiki" onclick="toggleConnector(this)"><div class="conn-icon" style="background:#000;color:#fff;font-weight:700;font-size:14px;">N</div><div class="conn-body"><div class="conn-name">Notion <span class="conn-tag">Productivity</span></div><div class="conn-desc">Connect workspace to search, update, and power workflows</div></div><button class="conn-add-btn"><i class="fa fa-plus"></i></button></div>
        <div class="conn-card" data-name="Telegram" data-desc="Notifications channels" onclick="toggleConnector(this)"><div class="conn-icon" style="background:#0088CC;color:#fff;font-weight:700;font-size:14px;">T</div><div class="conn-body"><div class="conn-name">Telegram <span class="conn-tag">Communication</span></div><div class="conn-desc">Send notifications to Telegram channels and groups</div></div><button class="conn-add-btn"><i class="fa fa-plus"></i></button></div>
    </div>
</div>
</div>
<style>
.conn-modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:10000;display:flex;align-items:center;justify-content:center;animation:connFadeIn .15s ease}
@keyframes connFadeIn{from{opacity:0}to{opacity:1}}
.conn-modal{background:var(--cf-white,#fff);border-radius:16px;width:780px;max-width:95vw;max-height:85vh;overflow:hidden;display:flex;flex-direction:column;box-shadow:0 24px 64px rgba(0,0,0,0.2)}
.conn-modal-header{display:flex;justify-content:space-between;align-items:flex-start;padding:24px 28px 16px;flex-shrink:0}
.conn-close{background:none;border:none;font-size:28px;color:var(--cf-text-muted);cursor:pointer;padding:0 4px;line-height:1}
.conn-close:hover{color:var(--cf-text)}
.conn-toolbar{padding:0 28px 16px;flex-shrink:0}
.conn-search{width:100%;border:1px solid var(--cf-border,#e5e7eb);border-radius:10px;padding:10px 14px;font-size:14px;outline:none;font-family:var(--cf-font,inherit)!important}
.conn-search:focus{border-color:var(--cf-accent,#4f86c6);box-shadow:0 0 0 2px rgba(79,134,198,0.1)}
.conn-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;padding:0 28px 28px;overflow-y:auto;flex:1}
.conn-card{display:flex;align-items:center;gap:14px;padding:14px 16px;border:1px solid var(--cf-border,#e5e7eb);border-radius:12px;cursor:pointer;transition:border-color .15s,box-shadow .15s;background:var(--cf-white,#fff)}
.conn-card:hover{border-color:var(--cf-accent,#4f86c6);box-shadow:0 2px 8px rgba(0,0,0,0.06)}
.conn-card.connected{border-color:#10b981;background:rgba(16,185,129,0.03)}
.conn-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:16px}
.conn-body{flex:1;min-width:0}
.conn-name{font-size:14px;font-weight:600;color:var(--cf-text,#1e293b);margin-bottom:2px;display:flex;align-items:center;gap:6px}
.conn-desc{font-size:11px;color:var(--cf-text-muted,#94a3b8);line-height:1.4}
.conn-tag{font-size:10px;font-weight:500;padding:1px 6px;border-radius:4px;background:rgba(107,114,128,0.08);color:var(--cf-text-secondary,#64748b)}
.conn-tag.popular{background:rgba(79,134,198,0.1);color:var(--cf-accent,#4f86c6)}
.conn-add-btn{width:32px;height:32px;border-radius:50%;border:1px solid var(--cf-border,#e5e7eb);background:var(--cf-white,#fff);display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--cf-text-muted);font-size:14px;flex-shrink:0;transition:all .15s}
.conn-add-btn:hover{border-color:var(--cf-accent);color:var(--cf-accent)}
.conn-card.connected .conn-add-btn{background:#10b981;border-color:#10b981;color:#fff}
@media(max-width:768px){.conn-grid{grid-template-columns:1fr}.conn-modal{width:95vw}}
</style>
