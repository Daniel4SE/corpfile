<!-- Corporate Shareholders - Modern Rillet Style -->
<div class="page-title">
    <div class="title_left">
        <h3>Corporate Shareholders</h3>
        <p style="color:var(--cf-text-secondary); font-size:14px; margin-top:4px;">
            Companies with corporate entity shareholders
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
                <table id="datatable-corp-sh" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>S/No</th>
                            <th>Company Name</th>
                            <th>UEN</th>
                            <th>Corporate Shareholder</th>
                            <th>Country</th>
                            <th>Share Type</th>
                            <th>No. of Shares</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($shareholders as $s): ?>
                        <tr>
                            <td style="color:var(--cf-text-muted); font-size:12px;"><?= $i++ ?></td>
                            <td>
                                <a href="<?= base_url('view_company/' . ($s->company_id ?? '')) ?>" style="color:var(--cf-text); font-weight:600; text-decoration:none;">
                                    <?= htmlspecialchars($s->company_name ?? '') ?>
                                </a>
                            </td>
                            <td style="font-family:monospace; font-size:12px;"><?= htmlspecialchars($s->registration_number ?? '') ?></td>
                            <td>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="width:26px; height:26px; border-radius:6px; background:rgba(79,134,198,0.08); display:flex; align-items:center; justify-content:center; color:var(--cf-accent); font-size:11px; flex-shrink:0;">
                                        <i class="fa fa-building"></i>
                                    </span>
                                    <span style="font-weight:500;"><?= htmlspecialchars($s->name ?? '') ?></span>
                                </div>
                            </td>
                            <td style="font-size:12px;"><?= htmlspecialchars($s->corp_country ?? $s->nationality ?? '-') ?></td>
                            <td style="font-size:12px;">Ordinary</td>
                            <td>
                                <span style="font-weight:600; font-family:monospace; font-size:12px;"><?= htmlspecialchars($s->total_shares ?? '0') ?></span>
                            </td>
                            <td>
                                <span class="status-badge <?= ($s->status ?? '') == 'Active' ? 'active' : 'draft' ?>">
                                    <?= htmlspecialchars($s->status ?? '') ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('company_officials/' . ($s->company_id ?? '')) ?>" class="btn btn-default btn-xs" style="border-radius:6px;">
                                    <i class="fa fa-eye" style="margin-right:4px;"></i> View
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
$(function(){
    if ($.fn.DataTable) {
        $('#datatable-corp-sh').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy','csv','excel','pdf','print'],
            language: {
                search: '',
                searchPlaceholder: 'Search shareholders...',
                paginate: { previous: '<i class="fa fa-chevron-left"></i>', next: '<i class="fa fa-chevron-right"></i>' }
            }
        });
    }
});
</script>
