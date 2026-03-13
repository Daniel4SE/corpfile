<!-- Directors List - All directors across all companies -->
<div class="page-title">
    <div class="title_left">
        <h3>Directors</h3>
        <p style="color:var(--cf-text-secondary); font-size:14px; margin-top:4px;">
            All directors across all companies
            <span style="display:inline-flex; align-items:center; justify-content:center; min-width:28px; height:22px; border-radius:11px; background:rgba(30,58,95,0.08); color:var(--cf-primary); font-size:12px; font-weight:600; padding:0 8px; margin-left:6px;">
                <?= count($directors) ?>
            </span>
        </p>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-directors" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:40px;">S/No.</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>ID No.</th>
                            <th>Nationality</th>
                            <th>Appointed</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; foreach ($directors as $d): ?>
                        <tr>
                            <td style="color:var(--cf-text-muted); font-size:12px;"><?= $sno++ ?></td>
                            <td>
                                <div style="font-weight:600; color:var(--cf-text);"><?= htmlspecialchars($d->name ?? '') ?></div>
                                <?php if (!empty($d->email)): ?>
                                    <div style="font-size:11px; color:var(--cf-text-muted);"><?= htmlspecialchars($d->email) ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="font-weight:500;"><?= htmlspecialchars($d->company_name ?? '') ?></div>
                                <div style="font-size:11px; color:var(--cf-text-muted); font-family:monospace;"><?= htmlspecialchars($d->registration_number ?? '') ?></div>
                            </td>
                            <td style="font-family:monospace; font-size:12px;">
                                <?php if (!empty($d->id_number)): ?>
                                    <span title="<?= htmlspecialchars($d->id_type ?? '') ?>"><?= htmlspecialchars($d->id_number) ?></span>
                                <?php endif; ?>
                            </td>
                            <td style="font-size:13px;"><?= htmlspecialchars($d->nationality ?? '') ?></td>
                            <td style="font-size:12px; white-space:nowrap;">
                                <?= !empty($d->date_of_appointment) ? date('d M Y', strtotime($d->date_of_appointment)) : '' ?>
                            </td>
                            <td>
                                <span class="status-badge <?= ($d->status ?? 'Active') === 'Active' ? 'active' : 'draft' ?>">
                                    <?= htmlspecialchars($d->status ?? 'Active') ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url("officials_list/{$d->company_id}") ?>" class="btn btn-default btn-xs" style="border-radius:6px;" title="View all officials for this company">
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
        $('#datatable-directors').DataTable({
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            order: [[2, 'asc'], [1, 'asc']],
            language: {
                search: '',
                searchPlaceholder: 'Search directors...',
                info: 'Showing _START_ to _END_ of _TOTAL_ directors',
                paginate: { previous: '<i class="fa fa-chevron-left"></i>', next: '<i class="fa fa-chevron-right"></i>' }
            }
        });
    }
});
</script>
