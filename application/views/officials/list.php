<!-- Company Officials - Modern Rillet Style -->
<div class="page-title">
    <div class="title_left">
        <h3>Company Officials</h3>
        <p style="color:var(--cf-text-secondary); font-size:14px; margin-top:4px;">
            Directors, shareholders, secretaries, and auditors overview
        </p>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('company_list') ?>" class="btn btn-default">
                <i class="fa fa-arrow-left" style="margin-right:4px;"></i> Back to Companies
            </a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <!-- Data Table -->
                <table id="datatable-officials" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>S/No.</th>
                            <th>Company Name</th>
                            <th>Registration No.</th>
                            <th>Status</th>
                            <th>Directors</th>
                            <th>Shareholders</th>
                            <th>Secretaries</th>
                            <th>Auditors</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; foreach ($companies as $c): ?>
                        <tr>
                            <td style="color:var(--cf-text-muted); font-size:12px;"><?= $sno++ ?></td>
                            <td>
                                <span style="font-weight:600; color:var(--cf-text);"><?= htmlspecialchars($c->company_name) ?></span>
                            </td>
                            <td style="font-family:monospace; font-size:12px;"><?= htmlspecialchars($c->registration_number ?? '') ?></td>
                            <td>
                                <span class="status-badge <?= ($c->entity_status ?? 'Active') === 'Active' ? 'active' : 'draft' ?>">
                                    <?= htmlspecialchars($c->entity_status ?? 'Active') ?>
                                </span>
                            </td>
                            <td>
                                <span style="display:inline-flex; align-items:center; justify-content:center; min-width:28px; height:24px; border-radius:12px; background:rgba(30,58,95,0.08); color:var(--cf-primary); font-size:12px; font-weight:600; padding:0 8px;">
                                    <?= $c->total_directors ?? 0 ?>
                                </span>
                            </td>
                            <td>
                                <span style="display:inline-flex; align-items:center; justify-content:center; min-width:28px; height:24px; border-radius:12px; background:rgba(16,185,129,0.08); color:var(--cf-success); font-size:12px; font-weight:600; padding:0 8px;">
                                    <?= $c->total_shareholders ?? 0 ?>
                                </span>
                            </td>
                            <td>
                                <span style="display:inline-flex; align-items:center; justify-content:center; min-width:28px; height:24px; border-radius:12px; background:rgba(79,134,198,0.08); color:var(--cf-accent); font-size:12px; font-weight:600; padding:0 8px;">
                                    <?= $c->total_secretaries ?? 0 ?>
                                </span>
                            </td>
                            <td>
                                <span style="display:inline-flex; align-items:center; justify-content:center; min-width:28px; height:24px; border-radius:12px; background:rgba(245,158,11,0.08); color:var(--cf-warning); font-size:12px; font-weight:600; padding:0 8px;">
                                    <?= $c->total_auditors ?? 0 ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url("officials_list/{$c->id}") ?>" class="btn btn-default btn-xs" style="border-radius:6px;">
                                    <i class="fa fa-eye" style="margin-right:4px;"></i> View Officials
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
        $('#datatable-officials').DataTable({
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            order: [[1, 'asc']],
            language: {
                search: '',
                searchPlaceholder: 'Search companies...',
                info: 'Showing _START_ to _END_ of _TOTAL_ companies',
                paginate: { previous: '<i class="fa fa-chevron-left"></i>', next: '<i class="fa fa-chevron-right"></i>' }
            }
        });
    }
});
</script>
