<!-- Shareholders List - All shareholders across all companies -->
<div class="page-title">
    <div class="title_left">
        <h3>Shareholders</h3>
        <p style="color:var(--cf-text-secondary); font-size:14px; margin-top:4px;">
            All shareholders across all companies
            <span style="display:inline-flex; align-items:center; justify-content:center; min-width:28px; height:22px; border-radius:11px; background:rgba(16,185,129,0.08); color:var(--cf-success); font-size:12px; font-weight:600; padding:0 8px; margin-left:6px;">
                <?= count($shareholders) ?>
            </span>
        </p>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-shareholders" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:40px;">S/No.</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Company</th>
                            <th>ID No.</th>
                            <th>Nationality</th>
                            <th>Appointed</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; foreach ($shareholders as $s): ?>
                        <tr>
                            <td style="color:var(--cf-text-muted); font-size:12px;"><?= $sno++ ?></td>
                            <td>
                                <div style="font-weight:600; color:var(--cf-text);"><?= htmlspecialchars($s->name ?? '') ?></div>
                                <?php if (!empty($s->email)): ?>
                                    <div style="font-size:11px; color:var(--cf-text-muted);"><?= htmlspecialchars($s->email) ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                    $shType = $s->shareholder_type ?? 'Individual';
                                    $shBg = $shType === 'Corporate' ? 'rgba(139,92,246,0.08)' : 'rgba(79,134,198,0.08)';
                                    $shColor = $shType === 'Corporate' ? '#8b5cf6' : 'var(--cf-accent)';
                                ?>
                                <span style="display:inline-flex; align-items:center; padding:2px 10px; border-radius:10px; background:<?= $shBg ?>; color:<?= $shColor ?>; font-size:12px; font-weight:600;">
                                    <?= htmlspecialchars($shType) ?>
                                </span>
                            </td>
                            <td>
                                <div style="font-weight:500;"><?= htmlspecialchars($s->company_name ?? '') ?></div>
                                <div style="font-size:11px; color:var(--cf-text-muted); font-family:monospace;"><?= htmlspecialchars($s->registration_number ?? '') ?></div>
                            </td>
                            <td style="font-family:monospace; font-size:12px;">
                                <?php if (!empty($s->id_number)): ?>
                                    <span title="<?= htmlspecialchars($s->id_type ?? '') ?>"><?= htmlspecialchars($s->id_number) ?></span>
                                <?php endif; ?>
                            </td>
                            <td style="font-size:13px;"><?= htmlspecialchars($s->nationality ?? '') ?></td>
                            <td style="font-size:12px; white-space:nowrap;">
                                <?= !empty($s->date_of_appointment) ? date('d M Y', strtotime($s->date_of_appointment)) : '' ?>
                            </td>
                            <td>
                                <span class="status-badge <?= ($s->status ?? 'Active') === 'Active' ? 'active' : 'draft' ?>">
                                    <?= htmlspecialchars($s->status ?? 'Active') ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url("officials_list/{$s->company_id}") ?>" class="btn btn-default btn-xs" style="border-radius:6px;" title="View all officials for this company">
                                    <i class="fa fa-eye" style="margin-right:3px;"></i> View
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#datatable-shareholders').DataTable({
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            order: [[3, 'asc'], [1, 'asc']],
            language: {
                search: '',
                searchPlaceholder: 'Search shareholders...',
                info: 'Showing _START_ to _END_ of _TOTAL_ shareholders',
                paginate: { previous: '<i class="fa fa-chevron-left"></i>', next: '<i class="fa fa-chevron-right"></i>' }
            }
        });
    }
});
</script>
