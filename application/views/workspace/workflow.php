<section>
    <div class="cf-page-header" style="margin-bottom:14px;">
        <div>
            <h2>Task Board</h2>
            <p>Tasks from projects, due dates, and compliance items.</p>
        </div>
    </div>

    <div class="cf-task-board">
        <?php foreach (($lanes ?? []) as $laneKey => $lane): ?>
            <section class="cf-task-column" id="lane-<?= htmlspecialchars($laneKey) ?>">
                <header>
                    <div><h3><?= esc($lane['label'] ?? '') ?></h3></div>
                    <span class="cf-badge neutral"><?= count($lane['items'] ?? []) ?></span>
                </header>

                <?php if (!empty($lane['items'])): ?>
                    <?php foreach ($lane['items'] as $idx => $item):
                        $cardId = $laneKey . '_' . $idx;
                    ?>
                        <article class="cf-task-card" style="cursor:pointer;" onclick="openTaskDetail('<?= $cardId ?>')">
                            <span class="cf-card-kicker"><?= esc($item['subject_name'] ?? '') ?></span>
                            <strong><?= esc($item['task_name'] ?? '') ?></strong>
                            <p><?= esc($item['description'] ?? '') ?></p>
                            <div class="cf-task-meta">
                                <span><?= !empty($item['due_date']) ? date('d M Y', strtotime($item['due_date'])) : 'No due date' ?></span>
                                <span class="cf-badge <?= esc($item['tone'] ?? 'neutral') ?>"><?= esc($item['assignee_name'] ?? 'Unassigned') ?></span>
                            </div>
                            <div class="cf-inline-actions" style="margin-top:12px;">
                                <a href="<?= esc($item['href'] ?? base_url('workflow')) ?>" class="btn btn-xs btn-primary" onclick="event.stopPropagation();">Open</a>
                            </div>
                        </article>

                        <!-- Hidden data for modal -->
                        <script>
                        if(!window._taskData) window._taskData = {};
                        window._taskData['<?= $cardId ?>'] = {
                            subject: <?= json_encode($item['subject_name'] ?? '') ?>,
                            task: <?= json_encode($item['task_name'] ?? '') ?>,
                            description: <?= json_encode($item['description'] ?? '') ?>,
                            owner: <?= json_encode($item['assignee_name'] ?? 'Unassigned') ?>,
                            dueDate: <?= json_encode($item['due_date'] ?? null) ?>,
                            startDate: <?= json_encode($item['start_date'] ?? null) ?>,
                            completedDate: <?= json_encode($item['completed_date'] ?? null) ?>,
                            lane: <?= json_encode($lane['label'] ?? '') ?>,
                            tone: <?= json_encode($item['tone'] ?? 'neutral') ?>,
                            href: <?= json_encode($item['href'] ?? '') ?>
                        };
                        </script>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="cf-empty">No items in this lane.</div>
                <?php endif; ?>
            </section>
        <?php endforeach; ?>
    </div>
</section>

<section style="margin-top:22px;">
    <div class="cf-kpi-grid">
        <article class="cf-card cf-metric-card neutral" style="cursor:pointer;" onclick="scrollToLane('intake')">
            <span class="cf-card-kicker">Open tasks</span>
            <div class="cf-metric-value"><?= number_format((int) ($metrics['open'] ?? 0)) ?></div>
            <div class="cf-metric-meta"><span class="cf-metric-trend quiet">All active tasks</span></div>
        </article>
        <article class="cf-card cf-metric-card warning" style="cursor:pointer;" onclick="scrollToLane('due_this_week')">
            <span class="cf-card-kicker">Due this week</span>
            <div class="cf-metric-value"><?= number_format((int) ($metrics['due_this_week'] ?? 0)) ?></div>
            <div class="cf-metric-meta"><span class="cf-metric-trend quiet">Needs immediate follow-up</span></div>
        </article>
        <article class="cf-card cf-metric-card blue" style="cursor:pointer;" onclick="scrollToLane('pending_review')">
            <span class="cf-card-kicker">Pending review</span>
            <div class="cf-metric-value"><?= number_format((int) ($metrics['pending_review'] ?? 0)) ?></div>
            <div class="cf-metric-meta"><span class="cf-metric-trend quiet">Waiting for approval or sign-off</span></div>
        </article>
        <article class="cf-card cf-metric-card green" style="cursor:pointer;" onclick="scrollToLane('done')">
            <span class="cf-card-kicker">Done</span>
            <div class="cf-metric-value"><?= number_format((int) ($metrics['done'] ?? 0)) ?></div>
            <div class="cf-metric-meta"><span class="cf-metric-trend quiet">Completed tasks</span></div>
        </article>
    </div>
</section>

<!-- Task Detail Modal -->
<style>
/* Clickable KPI cards */
.cf-kpi-grid .cf-metric-card[onclick] {
    transition: transform 0.15s, box-shadow 0.15s;
}
.cf-kpi-grid .cf-metric-card[onclick]:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
}
.cf-kpi-grid .cf-metric-card[onclick]:active {
    transform: translateY(0);
}
.cf-task-modal-overlay {
    display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:9999;
    align-items:center; justify-content:center;
}
.cf-task-modal-overlay.open { display:flex; }
.cf-task-modal {
    background:var(--cf-white); border-radius:14px; width:520px; max-width:95vw;
    max-height:85vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,0.2);
}
.cf-task-modal-header {
    padding:20px 24px; border-bottom:1px solid var(--cf-border);
    display:flex; align-items:center; justify-content:space-between;
}
.cf-task-modal-header h3 { margin:0; font-size:16px; font-weight:700; color:var(--cf-text); }
.cf-task-modal-close { background:none; border:none; font-size:20px; color:var(--cf-text-muted); cursor:pointer; }
.cf-task-modal-body { padding:20px 24px; }
.cf-task-detail-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
.cf-task-detail-item { padding:10px 14px; background:var(--cf-bg); border-radius:8px; }
.cf-task-detail-item.full { grid-column: 1 / -1; }
.cf-task-detail-label { font-size:11px; font-weight:600; color:var(--cf-text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px; }
.cf-task-detail-value { font-size:13px; color:var(--cf-text); font-weight:500; }
.cf-task-status-badge {
    display:inline-block; padding:3px 12px; border-radius:12px; font-size:11px; font-weight:600;
}
.cf-task-status-badge.green { background:rgba(16,185,129,0.1); color:#10b981; }
.cf-task-status-badge.warning { background:rgba(245,158,11,0.1); color:#f59e0b; }
.cf-task-status-badge.danger { background:rgba(239,68,68,0.1); color:#ef4444; }
.cf-task-status-badge.neutral { background:rgba(107,114,128,0.1); color:#6b7280; }
.cf-task-status-badge.blue { background:rgba(59,130,246,0.1); color:#3b82f6; }
.cf-task-modal-footer { padding:16px 24px; border-top:1px solid var(--cf-border); display:flex; justify-content:flex-end; gap:10px; }
.cf-task-modal-footer .btn { padding:8px 20px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; }
</style>

<div class="cf-task-modal-overlay" id="taskDetailOverlay" onclick="if(event.target===this)closeTaskDetail()">
    <div class="cf-task-modal">
        <div class="cf-task-modal-header">
            <h3 id="taskDetailTitle">Task Details</h3>
            <button class="cf-task-modal-close" onclick="closeTaskDetail()">&times;</button>
        </div>
        <div class="cf-task-modal-body">
            <div id="taskDetailSubject" style="font-size:13px;color:var(--cf-text-muted);margin-bottom:4px;"></div>
            <div id="taskDetailName" style="font-size:18px;font-weight:700;color:var(--cf-text);margin-bottom:12px;"></div>
            <div id="taskDetailDesc" style="font-size:13px;color:var(--cf-text-secondary);margin-bottom:20px;line-height:1.6;"></div>

            <div class="cf-task-detail-grid">
                <div class="cf-task-detail-item">
                    <div class="cf-task-detail-label">Owner / Assignee</div>
                    <div class="cf-task-detail-value" id="taskDetailOwner"></div>
                </div>
                <div class="cf-task-detail-item">
                    <div class="cf-task-detail-label">Status</div>
                    <div class="cf-task-detail-value" id="taskDetailStatus"></div>
                </div>
                <div class="cf-task-detail-item">
                    <div class="cf-task-detail-label">Due Date</div>
                    <div class="cf-task-detail-value" id="taskDetailDue"></div>
                </div>
                <div class="cf-task-detail-item">
                    <div class="cf-task-detail-label">Start Date</div>
                    <div class="cf-task-detail-value" id="taskDetailStart"></div>
                </div>
                <div class="cf-task-detail-item">
                    <div class="cf-task-detail-label">Completed</div>
                    <div class="cf-task-detail-value" id="taskDetailCompleted"></div>
                </div>
                <div class="cf-task-detail-item">
                    <div class="cf-task-detail-label">Company / Project</div>
                    <div class="cf-task-detail-value" id="taskDetailCompany"></div>
                </div>
            </div>
        </div>
        <div class="cf-task-modal-footer">
            <button class="btn btn-default" onclick="closeTaskDetail()">Close</button>
            <a class="btn btn-primary" id="taskDetailOpenBtn" href="#">Open Full View</a>
        </div>
    </div>
</div>

<script>
function fmtDate(d) {
    if (!d) return '-';
    try { return new Date(d).toLocaleDateString('en-SG', { day:'numeric', month:'short', year:'numeric' }); }
    catch(e) { return d; }
}

function openTaskDetail(cardId) {
    var d = (window._taskData || {})[cardId];
    if (!d) return;

    document.getElementById('taskDetailSubject').textContent = d.subject || '';
    document.getElementById('taskDetailName').textContent = d.task || 'Untitled';
    document.getElementById('taskDetailDesc').textContent = d.description || 'No description.';
    document.getElementById('taskDetailOwner').textContent = d.owner || 'Unassigned';
    document.getElementById('taskDetailDue').innerHTML = fmtDate(d.dueDate);
    document.getElementById('taskDetailStart').innerHTML = fmtDate(d.startDate);
    document.getElementById('taskDetailCompleted').innerHTML = d.completedDate ? fmtDate(d.completedDate) : '<span style="color:var(--cf-text-muted)">Not yet</span>';
    document.getElementById('taskDetailCompany').textContent = d.subject || '-';

    // Status badge
    var toneCls = d.tone || 'neutral';
    document.getElementById('taskDetailStatus').innerHTML = '<span class="cf-task-status-badge ' + toneCls + '">' + (d.lane || 'Unknown') + '</span>';

    // Due date urgency
    if (d.dueDate) {
        var diff = Math.round((new Date(d.dueDate) - new Date()) / 86400000);
        if (diff < 0) {
            document.getElementById('taskDetailDue').innerHTML += ' <span style="color:#ef4444;font-size:11px;font-weight:600">(' + Math.abs(diff) + ' days overdue)</span>';
        } else if (diff <= 7) {
            document.getElementById('taskDetailDue').innerHTML += ' <span style="color:#f59e0b;font-size:11px;font-weight:600">(' + diff + ' days left)</span>';
        }
    }

    document.getElementById('taskDetailOpenBtn').href = d.href || '#';
    document.getElementById('taskDetailOverlay').classList.add('open');
}

function closeTaskDetail() {
    document.getElementById('taskDetailOverlay').classList.remove('open');
}

function scrollToLane(laneKey) {
    var el = document.getElementById('lane-' + laneKey);
    if (el) {
        el.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'center' });
        /* Flash highlight */
        el.style.transition = 'box-shadow 0.3s';
        el.style.boxShadow = '0 0 0 3px rgba(79,134,198,0.3)';
        setTimeout(function() { el.style.boxShadow = ''; }, 1500);
    }
}
</script>
