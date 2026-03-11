<!-- Sealings List - Modern Rillet Style -->
<div class="page-title">
    <div class="title_left">
        <h3>Sealings List</h3>
        <p style="color:var(--cf-text-secondary); font-size:14px; margin-top:4px;">
            Track company seal usage and records
        </p>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('add_seal') ?>" class="btn btn-primary">
                <i class="fa fa-plus" style="margin-right:4px;"></i> Add Seal
            </a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-sealings" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>S/No</th>
                            <th>Company</th>
                            <th>Seal Type</th>
                            <th>Seal Number</th>
                            <th>Date Sealed</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th style="min-width:100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($sealings)): ?>
                            <?php $sno = 1; foreach ($sealings as $s): ?>
                            <tr>
                                <td style="color:var(--cf-text-muted); font-size:12px;"><?= $sno++ ?></td>
                                <td><span style="font-weight:600;"><?= htmlspecialchars($s->company_name ?? '') ?></span></td>
                                <td style="font-size:12px;"><?= htmlspecialchars($s->seal_type ?? '') ?></td>
                                <td style="font-family:monospace; font-size:12px;"><?= htmlspecialchars($s->seal_number ?? '') ?></td>
                                <td style="font-size:12px;"><?= !empty($s->date_sealed) ? date('d/m/Y', strtotime($s->date_sealed)) : '<span style="color:var(--cf-text-muted);">--</span>' ?></td>
                                <td style="font-size:12px; max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="<?= htmlspecialchars($s->description ?? '') ?>">
                                    <?= htmlspecialchars($s->description ?? '') ?>
                                </td>
                                <td>
                                    <span class="status-badge <?= ($s->status ?? '') === 'Active' ? 'active' : 'draft' ?>">
                                        <?= htmlspecialchars($s->status ?? '') ?>
                                    </span>
                                </td>
                                <td>
                                    <div style="display:flex; gap:4px;">
                                        <button class="btn btn-default btn-xs" title="Edit" style="border-radius:6px;">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button class="btn btn-default btn-xs" title="Delete" style="border-radius:6px; color:var(--cf-danger);">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center" style="padding:40px 20px !important;">
                                    <div style="width:48px; height:48px; border-radius:12px; background:var(--cf-card-bg); display:flex; align-items:center; justify-content:center; margin:0 auto 12px; color:var(--cf-text-muted); font-size:20px;">
                                        <i class="fa fa-stamp"></i>
                                    </div>
                                    <p style="color:var(--cf-text-secondary); font-size:13px; margin:0;">No sealings found.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#datatable-sealings').DataTable({
            pageLength: 10,
            order: [[4, 'desc']],
            language: {
                search: '',
                searchPlaceholder: 'Search sealings...',
                paginate: { previous: '<i class="fa fa-chevron-left"></i>', next: '<i class="fa fa-chevron-right"></i>' }
            }
        });
    }
});
</script>
