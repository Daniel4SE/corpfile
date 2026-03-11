<section>
    <div class="cf-kpi-grid">
        <article class="cf-card cf-metric-card neutral">
            <span class="cf-card-kicker">Notifications</span>
            <div class="cf-metric-value"><?= number_format((int) ($metrics['notifications'] ?? 0)) ?></div>
            <div class="cf-metric-meta"><span class="cf-metric-trend quiet">Items loaded for the current user</span></div>
        </article>
        <article class="cf-card cf-metric-card danger">
            <span class="cf-card-kicker">Unread</span>
            <div class="cf-metric-value"><?= number_format((int) ($metrics['unread'] ?? 0)) ?></div>
            <div class="cf-metric-meta"><span class="cf-metric-trend quiet">Needs acknowledgement</span></div>
        </article>
        <article class="cf-card cf-metric-card warning">
            <span class="cf-card-kicker">Overdue</span>
            <div class="cf-metric-value"><?= number_format((int) ($metrics['overdue'] ?? 0)) ?></div>
            <div class="cf-metric-meta"><span class="cf-metric-trend quiet">Due dates already past deadline</span></div>
        </article>
        <article class="cf-card cf-metric-card blue">
            <span class="cf-card-kicker">Next 30 days</span>
            <div class="cf-metric-value"><?= number_format((int) ($metrics['next_30_days'] ?? 0)) ?></div>
            <div class="cf-metric-meta"><span class="cf-metric-trend quiet">Upcoming alert pressure window</span></div>
        </article>
    </div>
</section>

<section class="cf-dashboard-grid cf-dashboard-lower" style="margin-top:22px;">
    <div class="cf-shell-panel">
        <div class="cf-card-header">
            <div>
                <h3>Alert queue</h3>
                <p>Real due-date records from the existing alert tables.</p>
            </div>
        </div>
        <div class="cf-table-shell">
            <table class="cf-table">
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Event</th>
                        <th>Due Date</th>
                        <th>Days</th>
                        <th>Status</th>
                        <th style="text-align:right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($alerts ?? []) as $alert): ?>
                        <tr>
                            <td><strong><?= esc($alert->company_name ?? '') ?></strong></td>
                            <td><?= esc($alert->event_name ?? '') ?></td>
                            <td><?= !empty($alert->due_date) ? date('d M Y', strtotime($alert->due_date)) : '-' ?></td>
                            <td><?= isset($alert->days_remaining) ? (int) $alert->days_remaining : '-' ?></td>
                            <td><span class="cf-badge <?= esc($alert->tone ?? 'neutral') ?>"><?= esc($alert->status ?? 'Pending') ?></span></td>
                            <td style="text-align:right;"><a href="<?= esc($alert->href ?? base_url('event_tracker')) ?>" class="btn btn-xs btn-primary">Open</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div style="display:grid; gap:18px;">
        <div class="cf-shell-panel">
            <div class="cf-card-header">
                <div>
                    <h3>Notifications</h3>
                </div>
            </div>
            <ul class="cf-list">
                <?php foreach (($notifications ?? []) as $notification): ?>
                    <li class="cf-list-item">
                        <strong><?= esc($notification->title ?? '') ?></strong>
                        <span class="cf-list-subtext"><?= esc($notification->message ?? '') ?></span>
                        <span class="cf-list-subtext"><?= !empty($notification->created_at) ? date('d M Y H:i', strtotime($notification->created_at)) : '' ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="cf-shell-panel">
            <div class="cf-card-header">
                <div>
                    <h3>Recent activity</h3>
                </div>
            </div>
            <ul class="cf-log-list">
                <?php foreach (($activity_logs ?? []) as $log): ?>
                    <li class="cf-log-item">
                        <div>
                            <strong><?= esc($log->user_name ?? 'System') ?></strong>
                            <span class="cf-list-subtext"><?= esc($log->action ?? '') ?><?= !empty($log->module) ? ' · ' . esc($log->module) : '' ?></span>
                        </div>
                        <small><?= !empty($log->created_at) ? date('d M H:i', strtotime($log->created_at)) : '' ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>
