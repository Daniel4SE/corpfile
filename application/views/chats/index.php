<!-- Chats - Full Page AI Chat Interface with Conversation History -->
<style>
.cf-chat-container {
    display: flex;
    height: calc(100vh - var(--cf-topbar-h) - 40px);
    background: var(--cf-white);
    border: 1px solid var(--cf-border);
    border-radius: var(--cf-radius);
    overflow: hidden;
}

/* Left: Chat History Sidebar */
.cf-chat-sidebar {
    width: 280px;
    border-right: 1px solid var(--cf-border);
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
    background: var(--cf-bg);
    transition: width 0.25s cubic-bezier(.4,0,.2,1);
    overflow: hidden;
}
.cf-chat-sidebar.collapsed {
    width: 44px;
}
.cf-chat-sidebar.collapsed .cf-chat-sidebar-header h4,
.cf-chat-sidebar.collapsed .cf-chat-new-btn,
.cf-chat-sidebar.collapsed .cf-chat-list {
    display: none;
}
.cf-chat-sidebar.collapsed .cf-sidebar-toggle {
    transform: none;
}
.cf-chat-sidebar-header {
    padding: 16px;
    border-bottom: 1px solid var(--cf-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
}
.cf-chat-sidebar.collapsed .cf-chat-sidebar-header {
    padding: 10px;
    justify-content: center;
    border-bottom: none;
}
.cf-chat-sidebar-header h4 {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
    color: var(--cf-text);
    white-space: nowrap;
}
.cf-sidebar-toggle {
    width: 24px; height: 24px;
    border: none;
    background: transparent;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--cf-text-muted);
    border-radius: 4px;
    flex-shrink: 0;
    transition: transform 0.25s, background 0.15s;
}
.cf-sidebar-toggle:hover {
    background: var(--cf-border);
    color: var(--cf-text);
}
.cf-chat-new-btn {
    height: 28px;
    padding: 0 12px;
    border-radius: 6px;
    border: 1px solid var(--cf-border);
    background: var(--cf-white);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--cf-text-secondary);
    font-size: 12px;
    font-weight: 600;
    font-family: var(--cf-font) !important;
    transition: var(--cf-transition-fast);
    white-space: nowrap;
}
.cf-chat-new-btn:hover {
    background: var(--cf-primary);
    color: #fff;
    border-color: var(--cf-primary);
}
.cf-chat-list {
    flex: 1;
    overflow-y: auto;
    padding: 8px;
}
.cf-chat-item {
    padding: 10px 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: var(--cf-transition-fast);
    margin-bottom: 2px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 6px;
}
.cf-chat-item:hover { background: var(--cf-white); }
.cf-chat-item.active { background: var(--cf-white); box-shadow: var(--cf-shadow-sm); }
.cf-chat-item-info { flex: 1; min-width: 0; }
.cf-chat-item-title {
    font-size: 13px;
    font-weight: 500;
    color: var(--cf-text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.cf-chat-item-time {
    font-size: 11px;
    color: var(--cf-text-muted);
    margin-top: 2px;
}
.cf-chat-item-del {
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
    transition: var(--cf-transition-fast);
    flex-shrink: 0;
}
.cf-chat-item:hover .cf-chat-item-del { opacity: 1; }
.cf-chat-item-del:hover { background: #fee2e2; color: #ef4444; }
.cf-chat-empty {
    padding: 20px;
    text-align: center;
    color: var(--cf-text-muted);
    font-size: 12px;
}

/* Right: Chat Main Area */
.cf-chat-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-width: 0;
}
.cf-chat-main-header {
    padding: 14px 20px;
    border-bottom: 1px solid var(--cf-border);
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}
.cf-chat-main-header .cf-chat-ai-badge {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    font-size: 14px;
    color: var(--cf-primary);
}
.cf-chat-main-header .cf-chat-ai-icon {
    width: 28px; height: 28px;
    border-radius: 7px;
    background: linear-gradient(135deg, var(--cf-accent), var(--cf-primary));
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 13px;
}

/* Quick suggestion chips */
.cf-chat-chips {
    padding: 12px 20px;
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    border-bottom: 1px solid var(--cf-border);
    flex-shrink: 0;
}
.cf-chat-chip {
    padding: 6px 14px;
    border-radius: 20px;
    background: var(--cf-card-bg);
    border: 1px solid var(--cf-border);
    font-size: 12px;
    font-weight: 500;
    color: var(--cf-text);
    cursor: pointer;
    transition: var(--cf-transition-fast);
}
.cf-chat-chip:hover {
    background: var(--cf-primary);
    color: #fff;
    border-color: var(--cf-primary);
}

/* Messages area */
.cf-chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.cf-chat-msg {
    max-width: 75%;
    padding: 12px 16px;
    border-radius: var(--cf-radius);
    font-size: 13px;
    line-height: 1.6;
}
.cf-chat-msg.user {
    background: var(--cf-primary);
    color: #fff;
    align-self: flex-end;
    border-bottom-right-radius: 4px;
}
.cf-chat-msg.assistant {
    background: var(--cf-card-bg);
    color: var(--cf-text);
    align-self: flex-start;
    border-bottom-left-radius: 4px;
}
.cf-chat-msg .cf-msg-avatar {
    width: 22px; height: 22px;
    border-radius: 5px;
    background: linear-gradient(135deg, var(--cf-accent), var(--cf-primary));
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 10px;
    margin-right: 6px;
    vertical-align: middle;
}

/* Perplexity-style Input Area */
.cf-chat-input-area {
    padding: 12px 20px 16px;
    flex-shrink: 0;
}
.cf-chat-input-box {
    border: 1.5px solid var(--cf-border, #e5e7eb);
    border-radius: 16px;
    background: #fff;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    overflow: visible;
    transition: border-color 0.15s;
    position: relative;
}
.cf-chat-input-box:focus-within {
    border-color: var(--cf-accent, #4f86c6);
    box-shadow: 0 4px 24px rgba(79,134,198,0.12);
}
.cf-chat-input-box textarea {
    width: 100%;
    border: none;
    outline: none;
    resize: none;
    padding: 14px 18px 6px;
    font-size: 15px;
    font-family: var(--cf-font, inherit) !important;
    color: var(--cf-text, #1e293b);
    background: transparent;
    line-height: 1.5;
    min-height: 24px;
    max-height: 160px;
    border-radius: 16px 16px 0 0;
    box-sizing: border-box;
}
.cf-chat-input-box textarea::placeholder { color: #94a3b8; }
.cf-chat-input-box textarea:focus { outline: none !important; outline-style: none !important; box-shadow: none !important; }
.cf-chat-input-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 4px 8px 8px 10px;
}
.cf-chat-toolbar-left {
    display: flex;
    align-items: center;
    gap: 8px;
}
.cf-chat-toolbar-right {
    display: flex;
    align-items: center;
    gap: 8px;
}
/* Circle + button */
.cf-chat-plus-circle {
    width: 36px; height: 36px;
    border-radius: 50%;
    border: 1.5px solid #e0e0e0;
    background: #fff;
    color: #9ca3af;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
    flex-shrink: 0;
}
.cf-chat-plus-circle:hover {
    border-color: #bbb;
    color: var(--cf-text, #1e293b);
    background: #f9fafb;
}
/* Agent / Model pill */
.cf-chat-agent-pill {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border: 1.5px solid #e0e0e0;
    border-radius: 20px;
    background: #fff;
    color: var(--cf-text, #1e293b);
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.15s;
    font-family: var(--cf-font, inherit) !important;
}
.cf-chat-agent-pill:hover {
    border-color: #bbb;
    background: #f9fafb;
}
.cf-chat-agent-pill svg {
    color: #6b7280;
    flex-shrink: 0;
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
.cf-plus-dropdown-item:hover {
    background: #f5f7fa;
}
.cf-plus-dropdown-item svg {
    color: #64748b;
    flex-shrink: 0;
}
.cf-plus-dropdown-item:hover svg {
    color: var(--cf-text, #1e293b);
}
/* Agents submenu */
.cf-plus-agents-trigger { position: relative; }
.cf-agents-submenu {
    display: none;
    position: absolute;
    left: 100%;
    top: -6px;
    min-width: 220px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    padding: 6px;
    z-index: 10000;
    margin-left: 4px;
}
.cf-agents-submenu button {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 9px 14px;
    border-radius: 8px;
    cursor: pointer;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    font-size: 13px;
    font-weight: 500;
    color: var(--cf-text, #1e293b);
    font-family: var(--cf-font, inherit) !important;
    transition: background 0.12s;
}
.cf-agents-submenu button:hover { background: #f5f7fa; }
.cf-agent-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}
/* Agent badge above input */
.cf-chat-agent-badge {
    display: none;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    font-size: 12px;
    font-weight: 600;
    color: var(--cf-text-secondary);
    border-bottom: 1px solid #f1f5f9;
}
.cf-agent-badge-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}
.cf-plus-item-badge {
    margin-left: auto;
    font-size: 11px;
    font-weight: 600;
    color: var(--cf-accent, #4f86c6);
    background: #eef2ff;
    padding: 2px 8px;
    border-radius: 10px;
}
/* Model Selector */
.cf-model-selector-wrap {
    position: relative;
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
.cf-model-dropdown-item .cf-model-item-info {
    flex: 1;
}
.cf-model-dropdown-item .cf-model-item-name {
    font-weight: 600;
    font-size: 13px;
}
.cf-model-dropdown-item .cf-model-item-desc {
    font-size: 11px;
    color: #94a3b8;
    margin-top: 1px;
}
.cf-model-dropdown-item .cf-model-check {
    color: var(--cf-accent, #4f86c6);
    opacity: 0;
    flex-shrink: 0;
}
.cf-model-dropdown-item.active .cf-model-check { opacity: 1; }
/* Send button */
.cf-chat-send-btn {
    width: 36px; height: 36px;
    border-radius: 50%;
    border: none;
    background: var(--cf-primary, #1e3a5f);
    color: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.15s;
}
.cf-chat-send-btn:hover { background: var(--cf-primary-light, #2a4f7a); }
.cf-chat-send-btn:disabled { opacity: 0.3; cursor: not-allowed; }

/* Typing indicator */
.cf-typing { display: flex; gap: 4px; padding: 10px 14px; align-self: flex-start; }
.cf-typing span {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: var(--cf-text-muted);
    animation: cfTypePulse 1.4s infinite ease-in-out;
}
.cf-typing span:nth-child(2) { animation-delay: 0.2s; }
.cf-typing span:nth-child(3) { animation-delay: 0.4s; }
@keyframes cfTypePulse {
    0%,80%,100% { transform: scale(0.6); opacity: 0.4; }
    40% { transform: scale(1); opacity: 1; }
}

.cf-sse-status-bar {
    width: 100%;
    max-width: 85%;
    border: 1px solid #dbeafe;
    background: #eff6ff;
    color: #1e3a8a;
    border-radius: 10px;
    padding: 8px 10px;
    font-size: 12px;
    line-height: 1.4;
}
.cf-sse-status-label {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-weight: 600;
}
.cf-sse-status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #2563eb;
    animation: cfSsePulse 1.2s infinite ease-in-out;
}
@keyframes cfSsePulse {
    0%, 100% { transform: scale(0.9); opacity: 0.6; }
    50% { transform: scale(1.1); opacity: 1; }
}

.cf-step-stream {
    width: 100%;
    max-width: 85%;
    display: flex;
    flex-direction: column;
    gap: 8px;
    border-left: 2px solid #dbeafe;
    padding-left: 12px;
}
.cf-step-item {
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    border-radius: 10px;
    padding: 8px 10px;
}
.cf-step-head {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: #334155;
    line-height: 1.4;
}
.cf-step-index {
    font-weight: 700;
    color: #1e3a8a;
    min-width: 42px;
}
.cf-step-ok { color: #15803d; }
.cf-step-fail { color: #b91c1c; }
.cf-step-meta {
    margin-top: 4px;
    font-size: 11px;
    color: #475569;
    word-break: break-word;
}
.cf-step-thumb {
    margin-top: 6px;
    display: inline-block;
}
.cf-step-thumb img {
    max-width: 100%;
    max-height: 200px;
    border-radius: 8px;
    border: 1px solid #d1d5db;
    display: block;
}

/* AI content formatting */
.cf-ai-content { display: inline; }
.cf-ai-content pre {
    background: #f4f5f7;
    padding: 10px 12px;
    border-radius: 6px;
    font-size: 12px;
    overflow-x: auto;
    margin: 6px 0;
    white-space: pre-wrap;
    word-break: break-word;
}
.cf-ai-content code {
    background: #f4f5f7;
    padding: 1px 5px;
    border-radius: 3px;
    font-size: 12px;
}
.cf-ai-content strong { font-weight: 600; }

/* Offline / setup notice */
.cf-chat-offline {
    background: #fef9ee !important;
    border: 1px solid #f5e0b0;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    max-width: 85% !important;
}
.cf-chat-offline strong {
    color: var(--cf-text);
    font-size: 13px;
}

@media (max-width: 768px) {
    .cf-chat-sidebar { width: 44px; }
    .cf-chat-sidebar:not(.collapsed) .cf-chat-sidebar-header h4,
    .cf-chat-sidebar:not(.collapsed) .cf-chat-new-btn,
    .cf-chat-sidebar:not(.collapsed) .cf-chat-list { display: none; }
    .cf-chat-sidebar.collapsed .cf-sidebar-toggle { transform: rotate(180deg); }
}
</style>

<div class="cf-chat-container">
    <!-- Left: Conversation History Sidebar -->
    <div class="cf-chat-sidebar" id="chatSidebar">
        <div class="cf-chat-sidebar-header">
            <button class="cf-sidebar-toggle" id="sidebarToggle" onclick="toggleChatSidebar()" title="Toggle conversations">
                <i class="fa fa-minus" id="sidebarToggleIcon"></i>
            </button>
            <h4>Conversations</h4>
            <button class="cf-chat-new-btn" onclick="newChat()" title="New Chat">
                New
            </button>
        </div>
        <div class="cf-chat-list" id="chatList">
            <div class="cf-chat-empty">Loading...</div>
        </div>
    </div>

    <!-- Right: Chat Main -->
    <div class="cf-chat-main">
        <div class="cf-chat-main-header">
            <div class="cf-chat-ai-badge">
                <span class="cf-chat-ai-icon"><i class="fa fa-bolt"></i></span>
                CorpFile AI
            </div>
        </div>

        <div class="cf-chat-chips" id="chatChips">
            <button class="cf-chat-chip" onclick="sendChatChip('Fill IR8A form for selected employee')">Fill IR8A</button>
            <button class="cf-chat-chip" onclick="sendChatChip('Search ACRA for company registration status')"><i class="fa fa-globe"></i> ACRA Lookup</button>
            <button class="cf-chat-chip" onclick="sendChatChip('Search Google for latest Singapore Companies Act amendments')"><i class="fa fa-search"></i> Web Search</button>
            <button class="cf-chat-chip" onclick="sendChatChip('Go to IRAS website and check the latest IR8A filing deadlines')"><i class="fa fa-external-link"></i> Browse IRAS</button>
        </div>

        <div class="cf-chat-messages" id="chatMessages">
            <div class="cf-chat-msg assistant">
                <span class="cf-msg-avatar"><i class="fa fa-bolt"></i></span>
                Hello! I'm CorpFile AI. I can help you generate documents, run compliance checks, query data, and automate routine tasks. How can I assist you today?
            </div>
        </div>

        <div class="cf-chat-input-area">
            <div class="cf-chat-input-box">
                <textarea id="chatInput" rows="1" placeholder="Ask CorpFile AI anything..." autocomplete="off"></textarea>
                <div class="cf-chat-input-toolbar">
                    <div class="cf-chat-toolbar-left">
                        <div class="cf-plus-menu-wrap" id="chatPlusWrap">
                            <button class="cf-chat-plus-circle" id="chatPlusBtn" title="More options" type="button">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            </button>
                            <div class="cf-plus-dropdown" id="chatPlusDropdown">
                                <!-- Add Documents or Images -->
                                <button class="cf-plus-dropdown-item" type="button" onclick="document.getElementById('chatFileInput').click(); closeChatPlusMenu();">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                                    <span>Add Documents or Images</span>
                                </button>
                                <!-- Add Agents -->
                                <div class="cf-plus-dropdown-item cf-plus-agents-trigger" onmouseenter="showAgentsSub()" onmouseleave="hideAgentsSub()">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                                    <span>Add Agents</span>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left:auto;opacity:0.4;"><polyline points="9 18 15 12 9 6"/></svg>
                                    <div class="cf-agents-submenu" id="chatAgentsSub">
                                        <button type="button" onclick="selectChatAgent('compliance','Company Registration','Show me upcoming compliance deadlines and overdue items'); closeChatPlusMenu();"><span class="cf-agent-dot" style="background:#8b5cf6;"></span> Company Registration</button>
                                        <button type="button" onclick="selectChatAgent('docgen','Document Generator','Help me generate a corporate document or resolution'); closeChatPlusMenu();"><span class="cf-agent-dot" style="background:#3b82f6;"></span> Document Generator</button>
                                        <button type="button" onclick="selectChatAgent('kyc','KYC Screening','Run a KYC screening check for a new client'); closeChatPlusMenu();"><span class="cf-agent-dot" style="background:#10b981;"></span> KYC Screening</button>
                                        <button type="button" onclick="selectChatAgent('ir8a','IR8A / Tax Filing','Help me with IR8A form preparation'); closeChatPlusMenu();"><span class="cf-agent-dot" style="background:#f59e0b;"></span> IR8A / Tax Filing</button>
                                        <button type="button" onclick="selectChatAgent('invoice','Invoice Manager','Generate annual invoices for current clients'); closeChatPlusMenu();"><span class="cf-agent-dot" style="background:#ec4899;"></span> Invoice Manager</button>
                                        <button type="button" onclick="selectChatAgent('payroll','SG Payroll','Calculate Singapore payroll including CPF contributions'); closeChatPlusMenu();"><span class="cf-agent-dot" style="background:#7c3aed;"></span> SG Payroll</button>
                                    </div>
                                </div>
                                <!-- Add Connectors -->
                                <div class="cf-plus-dropdown-item cf-plus-agents-trigger" onmouseenter="document.getElementById('chatConnSub').style.display='block'" onmouseleave="setTimeout(function(){document.getElementById('chatConnSub').style.display='none'},200)">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="8" height="8" rx="1"/><rect x="14" y="2" width="8" height="8" rx="1"/><rect x="2" y="14" width="8" height="8" rx="1"/><rect x="14" y="14" width="8" height="8" rx="1"/></svg>
                                    <span>Add Connectors</span>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left:auto;opacity:0.4;"><polyline points="9 18 15 12 9 6"/></svg>
                                    <div class="cf-agents-submenu" id="chatConnSub" style="display:none;">
                                        <button type="button" onclick="window.open('https://www.bizfile.gov.sg','_blank'); closeChatPlusMenu();"><span class="cf-agent-dot" style="background:#206570;"></span> ACRA BizFile+</button>
                                        <button type="button" onclick="window.open('https://www.iras.gov.sg','_blank'); closeChatPlusMenu();"><span class="cf-agent-dot" style="background:#e74c3c;"></span> IRAS e-Filing</button>
                                        <button type="button" onclick="window.open('https://www.cpf.gov.sg','_blank'); closeChatPlusMenu();"><span class="cf-agent-dot" style="background:#f59e0b;"></span> CPF Board</button>
                                        <button type="button" onclick="window.open('https://www.corppass.gov.sg','_blank'); closeChatPlusMenu();"><span class="cf-agent-dot" style="background:#3b82f6;"></span> CorpPass</button>
                                        <button type="button" onclick="window.open('https://www.mom.gov.sg','_blank'); closeChatPlusMenu();"><span class="cf-agent-dot" style="background:#8b5cf6;"></span> MOM WorkPass</button>
                                    </div>
                                </div>
                                <!-- Web Search -->
                                <button class="cf-plus-dropdown-item" type="button" onclick="toggleWebSearch(); closeChatPlusMenu();">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                    <span>Web Search</span>
                                    <span class="cf-plus-item-badge" id="chatWebSearchBadge">Auto</span>
                                </button>
                            </div>
                        </div>
                        <input type="file" id="chatFileInput" style="display:none" multiple accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.csv,.txt">
                        <div class="cf-model-selector-wrap" id="chatModelWrap">
                            <button class="cf-chat-agent-pill" id="chatModelBtn" type="button" title="Select model">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                <span id="chatModelLabel">Sonnet 4.6</span>
                            </button>
                            <div class="cf-model-dropdown" id="chatModelDropdown"></div>
                        </div>
                    </div>
                    <div class="cf-chat-toolbar-right">
                        <button class="cf-chat-send-btn" id="chatSendBtn" onclick="sendChatMessage()" title="Send" type="button">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var BASE = "<?= base_url() ?>";
var currentConversationId = 0;
var isSending = false;

/* ── Model Selector ── */
var cfModels = [
    { id: 'claude-sonnet-4-6', label: 'Sonnet 4.6', desc: 'Fast & intelligent', color: '#10b981' },
    { id: 'claude-opus-4-6', label: 'Opus 4.6', desc: 'Most intelligent', color: '#8b5cf6' },
    { id: 'claude-haiku-4-5-20251001', label: 'Haiku 4.5', desc: 'Fastest responses', color: '#f59e0b' }
];
var selectedModelIndex = 0;

function buildChatModelDropdown() {
    var dd = document.getElementById('chatModelDropdown');
    dd.innerHTML = '';
    cfModels.forEach(function(m, i) {
        var item = document.createElement('button');
        item.type = 'button';
        item.className = 'cf-model-dropdown-item' + (i === selectedModelIndex ? ' active' : '');
        item.innerHTML =
            '<span class="cf-model-item-dot" style="background:' + m.color + '"></span>' +
            '<span class="cf-model-item-info">' +
                '<span class="cf-model-item-name">' + m.label + '</span>' +
                '<span class="cf-model-item-desc">' + m.desc + '</span>' +
            '</span>' +
            '<svg class="cf-model-check" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
        item.addEventListener('click', function(e) {
            e.stopPropagation();
            selectedModelIndex = i;
            document.getElementById('chatModelLabel').textContent = m.label;
            document.getElementById('chatModelDot').style.background = m.color;
            closeChatModelDropdown();
        });
        dd.appendChild(item);
    });
}
function openChatModelDropdown() {
    buildChatModelDropdown();
    var dd = document.getElementById('chatModelDropdown');
    var btn = document.getElementById('chatModelBtn');
    var rect = btn.getBoundingClientRect();
    dd.style.bottom = (window.innerHeight - rect.top + 8) + 'px';
    dd.style.left = rect.left + 'px';
    dd.classList.add('open');
}
function closeChatModelDropdown() {
    document.getElementById('chatModelDropdown').classList.remove('open');
}
document.getElementById('chatModelBtn').addEventListener('click', function(e) {
    e.stopPropagation();
    var dd = document.getElementById('chatModelDropdown');
    if (dd.classList.contains('open')) { closeChatModelDropdown(); } else { openChatModelDropdown(); }
});
document.addEventListener('click', function() { closeChatModelDropdown(); closeChatPlusMenu(); });

/* ── Plus Menu ── */
function openChatPlusMenu() {
    var dd = document.getElementById('chatPlusDropdown');
    var btn = document.getElementById('chatPlusBtn');
    var rect = btn.getBoundingClientRect();
    dd.style.bottom = (window.innerHeight - rect.top + 8) + 'px';
    dd.style.left = rect.left + 'px';
    dd.classList.add('open');
}
function closeChatPlusMenu() {
    document.getElementById('chatPlusDropdown').classList.remove('open');
}
document.getElementById('chatPlusBtn').addEventListener('click', function(e) {
    e.stopPropagation();
    var dd = document.getElementById('chatPlusDropdown');
    if (dd.classList.contains('open')) { closeChatPlusMenu(); } else { openChatPlusMenu(); }
});

/* ── File attachment state ── */
var chatPendingFiles = []; // { name, type, data (base64 dataURL) }

function showChatFileBadges() {
    var existing = document.getElementById('chatFileBadges');
    if (existing) existing.remove();
    if (!chatPendingFiles.length) return;
    var wrap = document.createElement('div');
    wrap.id = 'chatFileBadges';
    wrap.style.cssText = 'display:flex;flex-wrap:wrap;gap:6px;padding:6px 18px 2px;';
    chatPendingFiles.forEach(function(f, idx) {
        var badge = document.createElement('span');
        badge.style.cssText = 'display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:8px;background:#f1f5f9;font-size:12px;color:#475569;font-weight:500;';
        var isImg = /^image\//.test(f.type);
        var isPdf = /pdf/i.test(f.type) || /\.pdf$/i.test(f.name);
        var icon = isPdf ? '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>' :
                   isImg ? '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>' :
                   '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/></svg>';
        badge.innerHTML = icon + '<span>' + f.name.substring(0, 25) + (f.name.length > 25 ? '...' : '') + '</span>' +
            '<button onclick="removeChatFile(' + idx + ')" style="background:none;border:none;cursor:pointer;color:#94a3b8;padding:0 0 0 2px;font-size:14px;line-height:1;">&times;</button>';
        wrap.appendChild(badge);
    });
    /* Insert before toolbar in the input box */
    var toolbar = document.querySelector('.cf-chat-input-toolbar');
    if (toolbar) toolbar.parentNode.insertBefore(wrap, toolbar);
}

function removeChatFile(idx) {
    chatPendingFiles.splice(idx, 1);
    showChatFileBadges();
}

/* File upload handler — reads file content as base64 */
document.getElementById('chatFileInput').addEventListener('change', function(e) {
    var files = e.target.files;
    if (!files || !files.length) return;
    var remaining = files.length;
    for (var i = 0; i < files.length; i++) {
        (function(file) {
            var reader = new FileReader();
            reader.onload = function(ev) {
                chatPendingFiles.push({
                    name: file.name,
                    type: file.type || 'application/octet-stream',
                    data: ev.target.result
                });
                remaining--;
                if (remaining <= 0) {
                    showChatFileBadges();
                    document.getElementById('chatInput').focus();
                }
            };
            reader.readAsDataURL(file);
        })(files[i]);
    }
    e.target.value = '';
});

/* Agent selector from + menu */
var chatSelectedAgent = null;
function selectChatAgent(agentKey, agentName, defaultPrompt) {
    chatSelectedAgent = agentKey;
    currentConvAgent = agentKey; /* Wire into chat API payload */
    /* Show agent badge above input */
    var badge = document.getElementById('chatAgentBadge');
    if (!badge) {
        badge = document.createElement('div');
        badge.id = 'chatAgentBadge';
        badge.className = 'cf-chat-agent-badge';
        document.querySelector('.cf-chat-input-box').insertBefore(badge, document.getElementById('chatInput'));
    }
    badge.innerHTML = '<span class="cf-agent-badge-dot" style="background:' + getAgentColor(agentKey) + ';"></span>' +
        '<span>' + agentName + '</span>' +
        '<button onclick="clearChatAgent()" title="Remove agent" style="background:none;border:none;cursor:pointer;color:var(--cf-text-muted);font-size:14px;padding:0 2px;margin-left:4px;">&times;</button>';
    badge.style.display = 'flex';
    /* Set prompt */
    var ta = document.getElementById('chatInput');
    ta.value = defaultPrompt;
    ta.style.height = 'auto';
    ta.style.height = Math.min(ta.scrollHeight, 160) + 'px';
    ta.focus();
}
function clearChatAgent() {
    chatSelectedAgent = null;
    var badge = document.getElementById('chatAgentBadge');
    if (badge) badge.style.display = 'none';
}
function getAgentColor(key) {
    var colors = {compliance:'#8b5cf6',docgen:'#3b82f6',kyc:'#10b981',ir8a:'#f59e0b',invoice:'#ec4899',payroll:'#7c3aed'};
    return colors[key] || '#6b7280';
}
function showAgentsSub() { document.getElementById('chatAgentsSub').style.display = 'block'; }
function hideAgentsSub() { setTimeout(function(){ document.getElementById('chatAgentsSub').style.display = 'none'; }, 200); }

/* Web Search toggle */
var chatWebSearchEnabled = true;
function toggleWebSearch() {
    chatWebSearchEnabled = !chatWebSearchEnabled;
    var badge = document.getElementById('chatWebSearchBadge');
    badge.textContent = chatWebSearchEnabled ? 'Auto' : 'Off';
    badge.style.background = chatWebSearchEnabled ? '#eef2ff' : '#f1f5f9';
    badge.style.color = chatWebSearchEnabled ? 'var(--cf-accent, #4f86c6)' : '#94a3b8';
}

/* ── Textarea auto-grow ── */
(function() {
    var ta = document.getElementById('chatInput');
    ta.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 160) + 'px';
    });
    ta.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendChatMessage();
        }
    });
})();

/* Use shared markdown renderer from main layout (cfRenderMarkdown) */
function renderMarkdown(text) {
    return (typeof cfRenderMarkdown === 'function') ? cfRenderMarkdown(text) : text;
}

/* ── Source/Agent label helpers ── */
var agentLabels = {
    compliance: 'Compliance', docgen: 'Doc Gen', kyc: 'KYC',
    tax: 'IR8A/Tax', invoice: 'Invoice', payroll: 'Payroll'
};
function sourceLabel(conv) {
    if (conv.source === 'agent' && conv.agent) {
        return agentLabels[conv.agent] || conv.agent;
    }
    if (conv.source === 'drawer') return 'Quick';
    return '';
}
function sourceBadgeColor(conv) {
    if (conv.source === 'agent') return '#8B5CF6';
    if (conv.source === 'drawer') return '#F59E0B';
    return '';
}

/* ── Sidebar: Load conversation list (ALL sources) ── */
function loadConversations() {
    fetch(BASE + 'ai/conversations')
    .then(function(r) { return r.json(); })
    .then(function(data) {
        var list = document.getElementById('chatList');
        if (!data.ok || !data.conversations || data.conversations.length === 0) {
            list.innerHTML = '<div class="cf-chat-empty">No conversations yet.<br>Start a new chat!</div>';
            return;
        }
        list.innerHTML = '';
        data.conversations.forEach(function(conv) {
            var item = document.createElement('div');
            item.className = 'cf-chat-item' + (conv.id === currentConversationId ? ' active' : '');
            item.setAttribute('data-id', conv.id);

            var info = document.createElement('div');
            info.className = 'cf-chat-item-info';
            info.onclick = function() { loadConversation(conv.id); };

            var titleRow = document.createElement('div');
            titleRow.style.cssText = 'display:flex;align-items:center;gap:5px;';

            var badge = sourceLabel(conv);
            if (badge) {
                var badgeEl = document.createElement('span');
                badgeEl.style.cssText = 'font-size:9px;padding:1px 5px;border-radius:3px;font-weight:600;color:#fff;background:' + sourceBadgeColor(conv) + ';flex-shrink:0;';
                badgeEl.textContent = badge;
                titleRow.appendChild(badgeEl);
            }

            var title = document.createElement('span');
            title.className = 'cf-chat-item-title';
            title.textContent = conv.title || 'New Chat';
            titleRow.appendChild(title);
            info.appendChild(titleRow);

            var time = document.createElement('div');
            time.className = 'cf-chat-item-time';
            time.textContent = formatTime(conv.updated_at) + ' \u00B7 ' + conv.msg_count + ' msgs';
            info.appendChild(time);

            item.appendChild(info);

            var del = document.createElement('button');
            del.className = 'cf-chat-item-del';
            del.title = 'Delete';
            del.innerHTML = '<i class="fa fa-trash"></i>';
            del.onclick = function(e) {
                e.stopPropagation();
                deleteConversation(conv.id);
            };
            item.appendChild(del);

            list.appendChild(item);
        });
    })
    .catch(function() {
        document.getElementById('chatList').innerHTML = '<div class="cf-chat-empty">Could not load history.</div>';
    });
}

/* ── Track which agent/source the current conversation belongs to ── */
var currentConvAgent = null;
var currentConvSource = 'chat';

/* ── Load a specific conversation ── */
function loadConversation(id) {
    currentConversationId = id;

    // Highlight active item
    var items = document.querySelectorAll('.cf-chat-item');
    items.forEach(function(el) {
        el.classList.toggle('active', parseInt(el.getAttribute('data-id')) === id);
    });

    var chatBody = document.getElementById('chatMessages');
    chatBody.innerHTML = '<div class="cf-typing"><span></span><span></span><span></span></div>';

    // Hide chips when loading a conversation
    var chips = document.getElementById('chatChips');
    if (chips) chips.style.display = 'none';

    fetch(BASE + 'ai/conversation?id=' + id)
    .then(function(r) { return r.json(); })
    .then(function(data) {
        chatBody.innerHTML = '';
        if (!data.ok || !data.messages || data.messages.length === 0) {
            chatBody.innerHTML = '<div class="cf-chat-msg assistant"><span class="cf-msg-avatar"><i class="fa fa-bolt"></i></span> Conversation is empty. Send a message to begin.</div>';
            return;
        }
        // Remember agent/source for continued conversation
        if (data.conversation) {
            currentConvAgent = data.conversation.agent || null;
            currentConvSource = data.conversation.source || 'chat';
        }
        data.messages.forEach(function(msg) {
            appendMessage(msg.role, msg.content);
        });
        chatBody.scrollTop = chatBody.scrollHeight;
    })
    .catch(function() {
        chatBody.innerHTML = '<div class="cf-chat-msg assistant cf-chat-offline"><span class="cf-msg-avatar" style="background:linear-gradient(135deg,#f0ad4e,#ec971f)"><i class="fa fa-info"></i></span><div>Failed to load conversation.</div></div>';
    });
}

/* ── Append a message to the chat body ── */
function appendMessage(role, content) {
    var chatBody = document.getElementById('chatMessages');
    var div = document.createElement('div');
    div.className = 'cf-chat-msg ' + role;

    if (role === 'assistant') {
        div.innerHTML = '<span class="cf-msg-avatar"><i class="fa fa-bolt"></i></span> ' +
            '<div class="cf-ai-content">' + renderMarkdown(content) + '</div>';
        if (typeof cfMakeActionBar === 'function') {
            div.appendChild(cfMakeActionBar(content, function() {
                var lastUser = chatBody.querySelectorAll('.cf-chat-msg.user');
                if (lastUser.length) {
                    document.getElementById('chatInput').value = lastUser[lastUser.length - 1].textContent;
                    div.remove();
                    sendChatMessage();
                }
            }));
        }
    } else {
        div.textContent = content;
    }

    chatBody.appendChild(div);
    return div;
}

/* ── Delete conversation ── */
function deleteConversation(id) {
    if (!confirm('Delete this conversation?')) return;

    fetch(BASE + 'ai/deleteConversation', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id })
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.ok) {
            if (currentConversationId === id) {
                newChat();
            }
            loadConversations();
        }
    });
}

/* ── New Chat ── */
function newChat() {
    currentConversationId = 0;
    currentConvAgent = null;
    currentConvSource = 'chat';
    var chatBody = document.getElementById('chatMessages');
    chatBody.innerHTML = '<div class="cf-chat-msg assistant"><span class="cf-msg-avatar"><i class="fa fa-bolt"></i></span> New conversation started. How can I help you?</div>';

    // Show chips again
    var chips = document.getElementById('chatChips');
    if (chips) chips.style.display = '';

    // Deselect sidebar items
    var items = document.querySelectorAll('.cf-chat-item');
    items.forEach(function(el) { el.classList.remove('active'); });
}

/* ── Send chip shortcut ── */
function sendChatChip(text) {
    var ta = document.getElementById('chatInput');
    ta.value = text;
    ta.style.height = 'auto';
    sendChatMessage();
}

/* ── Send message ── */
function sendChatMessage() {
    if (isSending) return;
    var input = document.getElementById('chatInput');
    var message = input.value.trim();
    if (!message && !chatPendingFiles.length) return;
    if (!message) message = 'Please analyze the attached file(s).';
    input.value = '';
    input.style.height = 'auto';
    isSending = true;

    // Hide chips after first message
    var chips = document.getElementById('chatChips');
    if (chips) chips.style.display = 'none';

    var chatBody = document.getElementById('chatMessages');

    // User message (show filenames if attached)
    var displayMsg = message;
    if (chatPendingFiles.length) {
        var fileNames = chatPendingFiles.map(function(f) { return f.name; });
        displayMsg = '[Attached: ' + fileNames.join(', ') + ']\n' + message;
    }
    appendMessage('user', displayMsg);

    // Collect file attachments
    var attachments = chatPendingFiles.map(function(f) {
        return { name: f.name, type: f.type, data: f.data };
    });
    chatPendingFiles = [];
    showChatFileBadges(); /* Clear badges */

    // Typing indicator
    var typingDiv = document.createElement('div');
    typingDiv.className = 'cf-typing';
    typingDiv.id = 'chatTyping';
    typingDiv.innerHTML = '<span></span><span></span><span></span>';
    chatBody.appendChild(typingDiv);
    chatBody.scrollTop = chatBody.scrollHeight;

    // Call AI API with conversation_id + model + attachments
    var controller = new AbortController();
    var timeoutId = setTimeout(function() { controller.abort(); }, 180000);

    var chatPayload = {
        message: message,
        conversation_id: currentConversationId || 0,
        source: currentConvSource || 'chat',
        model: cfModels[selectedModelIndex].id
    };
    if (currentConvAgent) chatPayload.agent = currentConvAgent;
    if (attachments.length) chatPayload.attachments = attachments;

    var isBrowserTask = /go to|browse|navigate|visit|open.*\.com|open.*\.sg|open.*\.gov|acra|iras|bizfile|search google|web search|fill.*form|screenshot/i.test(message);

    if (isBrowserTask && !attachments.length) {
        sendChatSSE(chatPayload, chatBody);
    } else {
        sendChatFetch(chatPayload, chatBody, controller, timeoutId, attachments);
    }
}

function sendChatSSE(payload, chatBody) {
    fetch(BASE + 'ai/chat_stream', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    }).then(function(response) {
        var reader = response.body.getReader();
        var decoder = new TextDecoder();
        var buffer = '';

        function processChunk() {
            reader.read().then(function(result) {
                if (result.done) { finishSSE(); return; }
                buffer += decoder.decode(result.value, { stream: true });
                var lines = buffer.split('\n');
                buffer = lines.pop();

                var currentEvent = '';
                for (var i = 0; i < lines.length; i++) {
                    var line = lines[i];
                    if (line.startsWith('event: ')) { currentEvent = line.substring(7); }
                    else if (line.startsWith('data: ')) {
                        try { handleSSEEvent(currentEvent, JSON.parse(line.substring(6)), chatBody); }
                        catch(e) {}
                    }
                }
                processChunk();
            });
        }
        processChunk();
    }).catch(function() { finishSSE(); showChatError(chatBody, 'Connection lost during browser operation.'); });
}

function ensureSSEStatus(chatBody) {
    var bar = document.getElementById('chatSSEStatus');
    if (bar) return bar;
    bar = document.createElement('div');
    bar.id = 'chatSSEStatus';
    bar.className = 'cf-chat-msg assistant cf-sse-status-bar';
    var typing = document.getElementById('chatTyping');
    chatBody.insertBefore(bar, typing || null);
    return bar;
}

function ensureStepStream(chatBody) {
    var stream = document.getElementById('chatStepStream');
    if (stream) return stream;
    stream = document.createElement('div');
    stream.id = 'chatStepStream';
    stream.className = 'cf-chat-msg assistant cf-step-stream';
    var typing = document.getElementById('chatTyping');
    chatBody.insertBefore(stream, typing || null);
    return stream;
}

function handleSSEEvent(event, data, chatBody) {
    if (event === 'status') {
        var typing = document.getElementById('chatTyping');
        var statusMsg = data.message || '';
        if (typing) typing.innerHTML = '<span></span><span></span><span></span> <small style="color:#94a3b8;margin-left:8px">' + statusMsg + '</small>';

        var statusBar = ensureSSEStatus(chatBody);
        statusBar.innerHTML = '<span class="cf-sse-status-label"><span class="cf-sse-status-dot"></span>Status</span> ' + statusMsg;
        chatBody.scrollTop = chatBody.scrollHeight;
    }
    else if (event === 'tool_step') {
        var typing = document.getElementById('chatTyping');
        var context = data.url || data.query || '';
        var contextText = context ? ' -> ' + context.substring(0, 80) : '';
        if (typing) typing.innerHTML = '<span></span><span></span><span></span> <small style="color:#94a3b8;margin-left:8px">Step ' + data.step + ': ' + data.tool + contextText + '</small>';

        var stream = ensureStepStream(chatBody);
        var card = document.createElement('div');
        card.className = 'cf-step-item';
        var stateClass = data.ok === false ? 'cf-step-fail' : 'cf-step-ok';
        var stateText = data.ok === false ? 'Failed' : 'Done';
        var detail = data.url || data.query || '';
        var thumb = data.screenshot ? '<a class="cf-step-thumb" href="data:image/png;base64,' + data.screenshot + '" target="_blank" rel="noopener noreferrer"><img src="data:image/png;base64,' + data.screenshot + '" alt="Step ' + data.step + ' screenshot"></a>' : '';
        card.innerHTML = '<div class="cf-step-head"><span class="cf-step-index">Step ' + data.step + '</span><strong>' + (data.tool || 'tool') + '</strong><span class="' + stateClass + '">' + stateText + '</span></div>' +
            (detail ? '<div class="cf-step-meta">' + detail + '</div>' : '') + thumb;
        stream.appendChild(card);
        chatBody.scrollTop = chatBody.scrollHeight;
    }
    else if (event === 'result') {
        var typing = document.getElementById('chatTyping');
        if (typing) typing.remove();
        isSending = false;
        if (data.conversation_id) { currentConversationId = data.conversation_id; loadConversations(); }
        if (data.ok && data.response_text) { appendMessage('assistant', data.response_text); }
        else { showChatError(chatBody, data.error || 'AI error'); }
        chatBody.scrollTop = chatBody.scrollHeight;
    }
    else if (event === 'done') { finishSSE(); }
}

function finishSSE() {
    var typing = document.getElementById('chatTyping');
    if (typing) typing.remove();
    isSending = false;
}

function showChatError(chatBody, msg) {
    var errDiv = document.createElement('div');
    errDiv.className = 'cf-chat-msg assistant cf-chat-offline';
    errDiv.innerHTML = '<span class="cf-msg-avatar" style="background:linear-gradient(135deg,#f0ad4e,#ec971f)"><i class="fa fa-info"></i></span>' +
        '<div><strong>AI Agent error</strong><br><span style="font-size:12px;color:var(--cf-text-secondary)">' + msg + '</span></div>';
    chatBody.appendChild(errDiv);
}

function sendChatFetch(chatPayload, chatBody, controller, timeoutId, attachments) {
    if (attachments.length) chatPayload.attachments = attachments;

    fetch(BASE + 'ai/chat', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(chatPayload),
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
        var typing = document.getElementById('chatTyping');
        if (typing) typing.remove();
        isSending = false;
        if (data.conversation_id) { currentConversationId = data.conversation_id; loadConversations(); }
        if (data.ok && data.response_text) { appendMessage('assistant', data.response_text); }
        else { showChatError(chatBody, data.error || 'Something went wrong.'); }
        chatBody.scrollTop = chatBody.scrollHeight;
    })
    .catch(function(err) {
        var typing = document.getElementById('chatTyping');
        if (typing) typing.remove();
        isSending = false;
        showChatError(chatBody, 'Unable to reach the AI service. Please try again later.');
        chatBody.scrollTop = chatBody.scrollHeight;
    });
}

/* ── Time formatting helper ── */
function formatTime(dateStr) {
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

/* ── Toggle sidebar collapse ── */
function toggleChatSidebar() {
    var sidebar = document.getElementById('chatSidebar');
    sidebar.classList.toggle('collapsed');
    var icon = document.getElementById('sidebarToggleIcon');
    if (sidebar.classList.contains('collapsed')) {
        icon.className = 'fa fa-plus';
    } else {
        icon.className = 'fa fa-minus';
    }
    // Remember state
    try { localStorage.setItem('cf_chat_sidebar', sidebar.classList.contains('collapsed') ? '1' : '0'); } catch(e){}
}
// Restore sidebar state on load
(function() {
    try {
        if (localStorage.getItem('cf_chat_sidebar') === '1') {
            document.getElementById('chatSidebar').classList.add('collapsed');
            document.getElementById('sidebarToggleIcon').className = 'fa fa-plus';
        }
    } catch(e){}
})();

/* ── Init: load conversation list on page load ── */
loadConversations();
</script>
