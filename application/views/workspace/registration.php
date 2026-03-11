<section>
    <div class="cf-kpi-grid">
        <article class="cf-card cf-metric-card neutral">
            <span class="cf-card-kicker">Pending cases</span>
            <div class="cf-metric-value"><?= number_format((int) ($metrics['pending'] ?? 0)) ?></div>
            <div class="cf-metric-meta"><span class="cf-metric-trend quiet">Pre-incorporation or missing incorporation date</span></div>
        </article>
        <article class="cf-card cf-metric-card blue">
            <span class="cf-card-kicker">With documents</span>
            <div class="cf-metric-value"><?= number_format((int) ($metrics['with_docs'] ?? 0)) ?></div>
            <div class="cf-metric-meta"><span class="cf-metric-trend quiet">Records already carrying uploaded packs</span></div>
        </article>
        <article class="cf-card cf-metric-card warning">
            <span class="cf-card-kicker">PIC unassigned</span>
            <div class="cf-metric-value"><?= number_format((int) ($metrics['unassigned'] ?? 0)) ?></div>
            <div class="cf-metric-meta"><span class="cf-metric-trend quiet">Needs ownership before filing</span></div>
        </article>
        <article class="cf-card cf-metric-card green">
            <span class="cf-card-kicker">Templates</span>
            <div class="cf-metric-value"><?= number_format((int) ($metrics['templates'] ?? 0)) ?></div>
            <div class="cf-metric-meta"><span class="cf-metric-trend quiet">Available form and template records</span></div>
        </article>
    </div>
</section>

<section class="cf-dashboard-grid cf-dashboard-lower" style="margin-top:22px;">
    <div class="cf-shell-panel">
        <div class="cf-page-header">
            <div>
                <h2>Registration queue</h2>
                <p>Only live cases are shown here. The table is pulled from existing company and document records.</p>
            </div>
            <div class="cf-actions">
                <a href="<?= base_url('add_company') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> New registration</a>
            </div>
        </div>

        <div class="cf-table-shell">
            <table class="cf-table">
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Registration No.</th>
                        <th>PIC</th>
                        <th>Documents</th>
                        <th>Last Updated</th>
                        <th style="text-align:right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($cases ?? []) as $case): ?>
                        <tr>
                            <td>
                                <strong><?= esc($case->company_name ?? '') ?></strong>
                                <span class="cf-list-subtext"><?= esc($case->country ?? 'Singapore') ?></span>
                            </td>
                            <td><?= esc($case->acra_registration_number ?? $case->registration_number ?? '-') ?></td>
                            <td><?= esc($case->pic_name ?? 'Unassigned') ?></td>
                            <td><?= number_format((int) ($case->documents_count ?? 0)) ?></td>
                            <td><?= !empty($case->updated_at) ? date('d M Y', strtotime($case->updated_at)) : (!empty($case->created_at) ? date('d M Y', strtotime($case->created_at)) : '-') ?></td>
                            <td style="text-align:right;">
                                <div class="company-row-actions">
                                    <a href="<?= base_url('view_company/' . ($case->id ?? '')) ?>" class="btn btn-xs btn-primary">Open</a>
                                    <a href="<?= base_url('company_file/' . ($case->id ?? '')) ?>" class="btn btn-xs btn-default">Templates</a>
                                </div>
                            </td>
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
                    <h3>Template library</h3>
                    <p>Newest templates already in the client workspace.</p>
                </div>
            </div>
            <ul class="cf-list">
                <?php foreach (($recent_templates ?? []) as $template): ?>
                    <li class="cf-list-item">
                        <strong><?= esc($template->template_name ?? '') ?></strong>
                        <span class="cf-list-subtext"><?= !empty($template->created_at) ? date('d M Y', strtotime($template->created_at)) : 'No date' ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="cf-shell-panel">
            <div class="cf-card-header">
                <div>
                    <h3>Shortcuts</h3>
                </div>
            </div>
            <div class="cf-role-list">
                <a href="<?= base_url('company_file') ?>" class="cf-role-item">
                    <strong>Template Library</strong>
                    <span class="cf-list-subtext">Open all form templates and categories.</span>
                </a>
                <a href="<?= base_url('company_list') ?>" class="cf-role-item">
                    <strong>Company Records</strong>
                    <span class="cf-list-subtext">Review registry details before filing.</span>
                </a>
            </div>
        </div>
    </div>
</section>
