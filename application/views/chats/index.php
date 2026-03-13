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
    transform: rotate(180deg);
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
    width: 30px; height: 30px;
    border-radius: 6px;
    border: 1px solid var(--cf-border);
    background: var(--cf-white);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--cf-text-secondary);
    font-size: 14px;
    transition: var(--cf-transition-fast);
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

/* Input area */
.cf-chat-input-area {
    padding: 16px 20px;
    border-top: 1px solid var(--cf-border);
    display: flex;
    gap: 10px;
    flex-shrink: 0;
}
.cf-chat-input-area input {
    flex: 1;
    border: 1px solid var(--cf-border);
    border-radius: var(--cf-radius-sm);
    padding: 10px 14px;
    font-size: 13px;
    outline: none;
    font-family: var(--cf-font) !important;
    color: var(--cf-text);
}
.cf-chat-input-area input:focus {
    border-color: var(--cf-accent);
    box-shadow: 0 0 0 3px rgba(79,134,198,0.1);
}
.cf-chat-input-area input::placeholder { color: var(--cf-text-muted); }
.cf-chat-send-btn {
    width: 40px; height: 40px;
    border-radius: var(--cf-radius-sm);
    border: none;
    background: var(--cf-primary);
    color: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
    transition: var(--cf-transition-fast);
}
.cf-chat-send-btn:hover { background: var(--cf-primary-light); }

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
            <button class="cf-sidebar-toggle" id="sidebarToggle" onclick="toggleChatSidebar()" title="Collapse sidebar">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <h4>Conversations</h4>
            <button class="cf-chat-new-btn" onclick="newChat()" title="New Chat">
                <i class="fa fa-plus"></i>
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
            <button class="cf-chat-chip" onclick="sendChatChip('Generate annual invoice for current clients')">Generate Invoice</button>
            <button class="cf-chat-chip" onclick="sendChatChip('Fill IR8A form for selected employee')">Fill IR8A</button>
            <button class="cf-chat-chip" onclick="sendChatChip('Run KYC screening check')">Run KYC</button>
            <button class="cf-chat-chip" onclick="sendChatChip('Export company report summary')">Export Report</button>
            <button class="cf-chat-chip" onclick="sendChatChip('Show upcoming compliance deadlines')">Check Compliance</button>
            <button class="cf-chat-chip" onclick="sendChatChip('Calculate Singapore payroll with CPF')">SG Payroll</button>
        </div>

        <div class="cf-chat-messages" id="chatMessages">
            <div class="cf-chat-msg assistant">
                <span class="cf-msg-avatar"><i class="fa fa-bolt"></i></span>
                Hello! I'm CorpFile AI. I can help you generate documents, run compliance checks, query data, and automate routine tasks. How can I assist you today?
            </div>
        </div>

        <div class="cf-chat-input-area">
            <input type="text" id="chatInput" placeholder="Ask CorpFile AI anything..."
                   onkeydown="if(event.key==='Enter')sendChatMessage()">
            <button class="cf-chat-send-btn" onclick="sendChatMessage()">
                <i class="fa fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<script>
var BASE = "<?= base_url() ?>";
var currentConversationId = 0;
var isSending = false;

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
    document.getElementById('chatInput').value = text;
    sendChatMessage();
}

/* ── Send message ── */
function sendChatMessage() {
    if (isSending) return;
    var input = document.getElementById('chatInput');
    var message = input.value.trim();
    if (!message) return;
    input.value = '';
    isSending = true;

    // Hide chips after first message
    var chips = document.getElementById('chatChips');
    if (chips) chips.style.display = 'none';

    var chatBody = document.getElementById('chatMessages');

    // User message
    appendMessage('user', message);

    // Typing indicator
    var typingDiv = document.createElement('div');
    typingDiv.className = 'cf-typing';
    typingDiv.id = 'chatTyping';
    typingDiv.innerHTML = '<span></span><span></span><span></span>';
    chatBody.appendChild(typingDiv);
    chatBody.scrollTop = chatBody.scrollHeight;

    // Call AI API with conversation_id
    var controller = new AbortController();
    var timeoutId = setTimeout(function() { controller.abort(); }, 180000);

    var chatPayload = {
        message: message,
        conversation_id: currentConversationId || 0,
        source: currentConvSource || 'chat'
    };
    if (currentConvAgent) chatPayload.agent = currentConvAgent;

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

        // Track conversation_id returned by server
        if (data.conversation_id) {
            currentConversationId = data.conversation_id;
            // Refresh sidebar to show new/updated conversation
            loadConversations();
        }

        if (data.ok && data.response_text) {
            appendMessage('assistant', data.response_text);
        } else {
            var errDiv = document.createElement('div');
            errDiv.className = 'cf-chat-msg assistant cf-chat-offline';
            errDiv.innerHTML = '<span class="cf-msg-avatar" style="background:linear-gradient(135deg,#f0ad4e,#ec971f)"><i class="fa fa-info"></i></span>' +
                '<div><strong>AI Agent error</strong><br>' +
                '<span style="font-size:12px;color:var(--cf-text-secondary)">' + (data.error || 'Something went wrong. Please try again.') + '</span></div>';
            chatBody.appendChild(errDiv);
        }
        chatBody.scrollTop = chatBody.scrollHeight;
    })
    .catch(function(err) {
        var typing = document.getElementById('chatTyping');
        if (typing) typing.remove();
        isSending = false;

        var errDiv = document.createElement('div');
        errDiv.className = 'cf-chat-msg assistant cf-chat-offline';
        errDiv.innerHTML = '<span class="cf-msg-avatar" style="background:linear-gradient(135deg,#f0ad4e,#ec971f)"><i class="fa fa-info"></i></span>' +
            '<div><strong>Connection unavailable</strong><br>' +
            '<span style="font-size:12px;color:var(--cf-text-secondary)">Unable to reach the AI service. Please check your connection and try again later.</span></div>';
        chatBody.appendChild(errDiv);
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
    // Remember state
    try { localStorage.setItem('cf_chat_sidebar', sidebar.classList.contains('collapsed') ? '1' : '0'); } catch(e){}
}
// Restore sidebar state on load
(function() {
    try {
        if (localStorage.getItem('cf_chat_sidebar') === '1') {
            document.getElementById('chatSidebar').classList.add('collapsed');
        }
    } catch(e){}
})();

/* ── Init: load conversation list on page load ── */
loadConversations();
</script>
