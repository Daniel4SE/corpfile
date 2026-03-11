<section>
    <div class="cf-kpi-grid">
        <article class="cf-card cf-metric-card neutral">
            <span class="cf-card-kicker">Open workflow items</span>
            <div class="cf-metric-value"><?= number_format((int) ($metrics['open'] ?? 0)) ?></div>
            <div class="cf-metric-meta"><span class="cf-metric-trend quiet">All active SOP records</span></div>
        </article>
        <article class="cf-card cf-metric-card warning">
            <span class="cf-card-kicker">Due this week</span>
            <div class="cf-metric-value"><?= number_format((int) ($metrics['due_this_week'] ?? 0)) ?></div>
            <div class="cf-metric-meta"><span class="cf-metric-trend quiet">Needs immediate follow-up</span></div>
        </article>
        <article class="cf-card cf-metric-card blue">
            <span class="cf-card-kicker">Pending review</span>
            <div class="cf-metric-value"><?= number_format((int) ($metrics['pending_review'] ?? 0)) ?></div>
            <div class="cf-metric-meta"><span class="cf-metric-trend quiet">Waiting for approval or sign-off</span></div>
        </article>
        <article class="cf-card cf-metric-card green">
            <span class="cf-card-kicker">Done</span>
            <div class="cf-metric-value"><?= number_format((int) ($metrics['done'] ?? 0)) ?></div>
            <div class="cf-metric-meta"><span class="cf-metric-trend quiet">Completed records in current board</span></div>
        </article>
    </div>
</section>

<section style="margin-top:22px;">
    <div class="cf-page-header">
        <div>
            <h2>SOP board</h2>
            <p>Workflow lanes are rebuilt from existing task and due-date data, without the old extra modules.</p>
        </div>
    </div>

    <div class="cf-task-board">
        <?php foreach (($lanes ?? []) as $lane): ?>
            <section class="cf-task-column">
                <header>
                    <div>
                        <h3><?= esc($lane['label'] ?? '') ?></h3>
                    </div>
                    <span class="cf-badge neutral"><?= count($lane['items'] ?? []) ?></span>
                </header>

                <?php if (!empty($lane['items'])): ?>
                    <?php foreach ($lane['items'] as $item): ?>
                        <article class="cf-task-card">
                            <span class="cf-card-kicker"><?= esc($item['subject_name'] ?? '') ?></span>
                            <strong><?= esc($item['task_name'] ?? '') ?></strong>
                            <p><?= esc($item['description'] ?? '') ?></p>
                            <div class="cf-task-meta">
                                <span><?= !empty($item['due_date']) ? date('d M Y', strtotime($item['due_date'])) : 'No due date' ?></span>
                                <span class="cf-badge <?= esc($item['tone'] ?? 'neutral') ?>"><?= esc($item['assignee_name'] ?? 'Unassigned') ?></span>
                            </div>
                            <div class="cf-inline-actions" style="margin-top:12px;">
                                <a href="<?= esc($item['href'] ?? base_url('workflow')) ?>" class="btn btn-xs btn-primary">Open</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="cf-empty">No items in this lane.</div>
                <?php endif; ?>
            </section>
        <?php endforeach; ?>
    </div>
</section>
