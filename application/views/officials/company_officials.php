<!-- Per-Company Officials (Tabbed View) -->
<style>
    .nav-tabs.bar_tabs > li > a { padding: 8px 12px; font-size: 12px; white-space: nowrap; }
    .bar_tabs-wrapper { padding-top: 4px; overflow-x: auto; overflow-y: visible; }
    .nav-tabs.bar_tabs { flex-wrap: nowrap; overflow: visible; display: flex; min-width: max-content; border-bottom: 1px solid #ddd; margin-bottom: 0; }
    .nav-tabs.bar_tabs > li { flex-shrink: 0; }
    .tab-pane table thead tr { background: #206570; color: #fff; }
    .officer-count { font-size: 10px; background: #E74C3C; color: #fff; border-radius: 50%; padding: 2px 6px; margin-left: 4px; }
</style>

<div class="page-title">
    <div class="title_left">
        <h3>Officials - <?= htmlspecialchars($company->company_name ?? 'Company') ?></h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url("view_company/{$company_id}") ?>" class="btn btn-info btn-sm"><i class="fa fa-building"></i> View Company</a>
            <a href="<?= base_url('company_officials') ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back to List</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">

                <!-- Tab Navigation -->
                <div class="bar_tabs-wrapper">
                <ul class="nav nav-tabs bar_tabs" id="officialsTabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#tab_directors" role="tab" data-toggle="tab"><i class="fa fa-users"></i> Directors
                            <?php if (!empty($directors)): ?><span class="officer-count"><?= count($directors) ?></span><?php endif; ?>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_shareholders" role="tab" data-toggle="tab"><i class="fa fa-pie-chart"></i> Shareholders
                            <?php if (!empty($shareholders)): ?><span class="officer-count"><?= count($shareholders) ?></span><?php endif; ?>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_secretaries" role="tab" data-toggle="tab"><i class="fa fa-user-secret"></i> Secretaries
                            <?php if (!empty($secretaries)): ?><span class="officer-count"><?= count($secretaries) ?></span><?php endif; ?>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_auditors" role="tab" data-toggle="tab"><i class="fa fa-search"></i> Auditors
                            <?php if (!empty($auditors)): ?><span class="officer-count"><?= count($auditors) ?></span><?php endif; ?>
                        </a>
                    </li>
                    <li role="presentation"><a href="#tab_controllers" role="tab" data-toggle="tab"><i class="fa fa-sitemap"></i> Controllers</a></li>
                    <li role="presentation"><a href="#tab_contact_persons" role="tab" data-toggle="tab"><i class="fa fa-phone"></i> Contact Persons</a></li>
                    <li role="presentation"><a href="#tab_chair_persons" role="tab" data-toggle="tab"><i class="fa fa-user"></i> Chairpersons</a></li>
                    <li role="presentation"><a href="#tab_dpo" role="tab" data-toggle="tab"><i class="fa fa-shield"></i> DPOs</a></li>
                    <li role="presentation"><a href="#tab_partners" role="tab" data-toggle="tab"><i class="fa fa-handshake-o"></i> Partners</a></li>
                    <li role="presentation"><a href="#tab_nominees" role="tab" data-toggle="tab"><i class="fa fa-user-plus"></i> Nominees/Trustees</a></li>
                    <li role="presentation"><a href="#tab_agents" role="tab" data-toggle="tab"><i class="fa fa-id-card"></i> Agents</a></li>
                    <li role="presentation"><a href="#tab_fund_managers" role="tab" data-toggle="tab"><i class="fa fa-money"></i> Fund Managers</a></li>
                    <li role="presentation"><a href="#tab_owners" role="tab" data-toggle="tab"><i class="fa fa-home"></i> Owners</a></li>
                    <li role="presentation"><a href="#tab_chief_reps" role="tab" data-toggle="tab"><i class="fa fa-star"></i> Chief Reps</a></li>
                    <li role="presentation"><a href="#tab_deputy_reps" role="tab" data-toggle="tab"><i class="fa fa-star-half-o"></i> Deputy Reps</a></li>
                    <li role="presentation"><a href="#tab_ep_holders" role="tab" data-toggle="tab"><i class="fa fa-id-badge"></i> EP Holders</a></li>
                    <li role="presentation"><a href="#tab_dp_holders" role="tab" data-toggle="tab"><i class="fa fa-id-badge"></i> DP Holders</a></li>
                    <li role="presentation"><a href="#tab_corp_reps" role="tab" data-toggle="tab"><i class="fa fa-building-o"></i> Corp Reps</a></li>
                    <li role="presentation"><a href="#tab_ceos" role="tab" data-toggle="tab"><i class="fa fa-briefcase"></i> CEOs</a></li>
                    <li role="presentation"><a href="#tab_managers" role="tab" data-toggle="tab"><i class="fa fa-user-circle"></i> Managers</a></li>
                    <li role="presentation"><a href="#tab_representatives" role="tab" data-toggle="tab"><i class="fa fa-address-card"></i> Representatives</a></li>
                </ul>
                </div><!-- /.bar_tabs-wrapper -->

                <!-- Tab Content -->
                <div class="tab-content">

                    <!-- DIRECTORS TAB -->
                    <div id="tab_directors" class="tab-pane fade in active" role="tabpanel">
                        <div style="margin-top:15px;">
                            <a href="<?= base_url("add_director/{$company_id}") ?>" class="btn btn-success btn-sm" style="margin-bottom:15px;">
                                <i class="fa fa-plus"></i> Add Director
                            </a>
                            <table class="table table-striped table-bordered dt-officials" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Name</th>
                                        <th>ID Type</th>
                                        <th>ID Number</th>
                                        <th>Nationality</th>
                                        <th>Date of Appointment</th>
                                        <th>Date of Cessation</th>
                                        <th>Status</th>
                                        <th width="80">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($directors)): $sno = 1; foreach ($directors as $d): ?>
                                    <tr>
                                        <td><?= $sno++ ?></td>
                                        <td><?= htmlspecialchars($d->name ?? '') ?></td>
                                        <td><?= htmlspecialchars($d->id_type ?? '') ?></td>
                                        <td><?= htmlspecialchars($d->id_number ?? '') ?></td>
                                        <td><?= htmlspecialchars($d->nationality ?? '') ?></td>
                                        <td><?= !empty($d->date_of_appointment) ? date('d M Y', strtotime($d->date_of_appointment)) : '' ?></td>
                                        <td><?= !empty($d->date_of_cessation) ? date('d M Y', strtotime($d->date_of_cessation)) : '' ?></td>
                                        <td><span class="label label-<?= strtolower($d->status ?? 'Active') === 'active' ? 'success' : 'danger' ?>"><?= htmlspecialchars($d->status ?? 'Active') ?></span></td>
                                        <td>
                                            <button class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- SHAREHOLDERS TAB -->
                    <div id="tab_shareholders" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <a href="<?= base_url("add_shareholder/{$company_id}") ?>" class="btn btn-success btn-sm" style="margin-bottom:15px;">
                                <i class="fa fa-plus"></i> Add Shareholder
                            </a>
                            <table class="table table-striped table-bordered dt-officials" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th>ID Type</th>
                                        <th>ID Number</th>
                                        <th>Nationality</th>
                                        <th>Date of Appointment</th>
                                        <th>Status</th>
                                        <th width="80">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($shareholders)): $sno = 1; foreach ($shareholders as $s): ?>
                                    <tr>
                                        <td><?= $sno++ ?></td>
                                        <td><?= htmlspecialchars($s->shareholder_type ?? 'Individual') ?></td>
                                        <td><?= htmlspecialchars($s->name ?? '') ?></td>
                                        <td><?= htmlspecialchars($s->id_type ?? '') ?></td>
                                        <td><?= htmlspecialchars($s->id_number ?? '') ?></td>
                                        <td><?= htmlspecialchars($s->nationality ?? '') ?></td>
                                        <td><?= !empty($s->date_of_appointment) ? date('d M Y', strtotime($s->date_of_appointment)) : '' ?></td>
                                        <td><span class="label label-<?= strtolower($s->status ?? 'Active') === 'active' ? 'success' : 'danger' ?>"><?= htmlspecialchars($s->status ?? 'Active') ?></span></td>
                                        <td>
                                            <button class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- SECRETARIES TAB -->
                    <div id="tab_secretaries" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <a href="<?= base_url("add_secretary/{$company_id}") ?>" class="btn btn-success btn-sm" style="margin-bottom:15px;">
                                <i class="fa fa-plus"></i> Add Secretary
                            </a>
                            <table class="table table-striped table-bordered dt-officials" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Name</th>
                                        <th>ID Type</th>
                                        <th>ID Number</th>
                                        <th>Nationality</th>
                                        <th>Date of Appointment</th>
                                        <th>Date of Cessation</th>
                                        <th>Status</th>
                                        <th width="80">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($secretaries)): $sno = 1; foreach ($secretaries as $s): ?>
                                    <tr>
                                        <td><?= $sno++ ?></td>
                                        <td><?= htmlspecialchars($s->name ?? '') ?></td>
                                        <td><?= htmlspecialchars($s->id_type ?? '') ?></td>
                                        <td><?= htmlspecialchars($s->id_number ?? '') ?></td>
                                        <td><?= htmlspecialchars($s->nationality ?? '') ?></td>
                                        <td><?= !empty($s->date_of_appointment) ? date('d M Y', strtotime($s->date_of_appointment)) : '' ?></td>
                                        <td><?= !empty($s->date_of_cessation) ? date('d M Y', strtotime($s->date_of_cessation)) : '' ?></td>
                                        <td><span class="label label-<?= strtolower($s->status ?? 'Active') === 'active' ? 'success' : 'danger' ?>"><?= htmlspecialchars($s->status ?? 'Active') ?></span></td>
                                        <td>
                                            <button class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- AUDITORS TAB -->
                    <div id="tab_auditors" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <a href="<?= base_url("add_auditor/{$company_id}") ?>" class="btn btn-success btn-sm" style="margin-bottom:15px;">
                                <i class="fa fa-plus"></i> Add Auditor
                            </a>
                            <table class="table table-striped table-bordered dt-officials" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Auditor Name</th>
                                        <th>Firm Name</th>
                                        <th>Date of Appointment</th>
                                        <th>Date of Cessation</th>
                                        <th>Status</th>
                                        <th width="80">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($auditors)): $sno = 1; foreach ($auditors as $a): ?>
                                    <tr>
                                        <td><?= $sno++ ?></td>
                                        <td><?= htmlspecialchars($a->name ?? '') ?></td>
                                        <td><?= htmlspecialchars($a->firm_name ?? '') ?></td>
                                        <td><?= !empty($a->date_of_appointment) ? date('d M Y', strtotime($a->date_of_appointment)) : '' ?></td>
                                        <td><?= !empty($a->date_of_cessation) ? date('d M Y', strtotime($a->date_of_cessation)) : '' ?></td>
                                        <td><span class="label label-<?= strtolower($a->status ?? 'Active') === 'active' ? 'success' : 'danger' ?>"><?= htmlspecialchars($a->status ?? 'Active') ?></span></td>
                                        <td>
                                            <button class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <?php
                    // Generic officer tabs - reuse same table structure
                    $generic_tabs = [
                        'controllers' => ['label' => 'Controller', 'icon' => 'sitemap', 'type' => 'controller'],
                        'contact_persons' => ['label' => 'Contact Person', 'icon' => 'phone', 'type' => 'contact_person'],
                        'chair_persons' => ['label' => 'Chairperson', 'icon' => 'user', 'type' => 'chair_person'],
                        'dpo' => ['label' => 'Data Protection Officer', 'icon' => 'shield', 'type' => 'data_protection', 'var' => 'data_protection_officers'],
                        'partners' => ['label' => 'Partner', 'icon' => 'handshake-o', 'type' => 'partner'],
                        'nominees' => ['label' => 'Nominee/Trustee', 'icon' => 'user-plus', 'type' => 'nominee_trustee'],
                        'agents' => ['label' => 'Agent', 'icon' => 'id-card', 'type' => 'agent'],
                        'fund_managers' => ['label' => 'Fund Manager', 'icon' => 'money', 'type' => 'fund_manager'],
                        'owners' => ['label' => 'Owner', 'icon' => 'home', 'type' => 'owner'],
                        'chief_reps' => ['label' => 'Chief Representative', 'icon' => 'star', 'type' => 'chief_representative', 'var' => 'chief_representatives'],
                        'deputy_reps' => ['label' => 'Deputy Representative', 'icon' => 'star-half-o', 'type' => 'deputy_representative', 'var' => 'deputy_representatives'],
                        'ep_holders' => ['label' => 'EP Holder', 'icon' => 'id-badge', 'type' => 'ep_holder'],
                        'dp_holders' => ['label' => 'DP Holder', 'icon' => 'id-badge', 'type' => 'dp_holder'],
                        'corp_reps' => ['label' => 'Corporate Representative', 'icon' => 'building-o', 'type' => 'corporate_representative', 'var' => 'corporate_representatives'],
                        'ceos' => ['label' => 'CEO', 'icon' => 'briefcase', 'type' => 'ceo'],
                        'managers' => ['label' => 'Manager', 'icon' => 'user-circle', 'type' => 'manager'],
                        'representatives' => ['label' => 'Representative', 'icon' => 'address-card', 'type' => 'representative'],
                    ];
                    foreach ($generic_tabs as $tab_id => $tab_info):
                        $var_name = $tab_info['var'] ?? $tab_info['type'] . 's';
                        $records = $$var_name ?? [];
                        $add_type = $tab_info['type'];
                        // Map type to controller route
                        $add_routes = [
                            'ceo' => 'add_ceo', 'manager' => 'add_manager', 'representative' => 'add_representative',
                        ];
                        $add_url = isset($add_routes[$add_type]) ? base_url("{$add_routes[$add_type]}/{$company_id}") : base_url("add_representative/{$company_id}?type={$add_type}");
                    ?>
                    <div id="tab_<?= $tab_id ?>" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <a href="<?= $add_url ?>" class="btn btn-success btn-sm" style="margin-bottom:15px;">
                                <i class="fa fa-plus"></i> Add <?= $tab_info['label'] ?>
                            </a>
                            <table class="table table-striped table-bordered dt-officials" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Name</th>
                                        <th>ID Type</th>
                                        <th>ID Number</th>
                                        <th>Nationality</th>
                                        <th>Date of Appointment</th>
                                        <th>Date of Cessation</th>
                                        <th>Status</th>
                                        <th width="80">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($records)): $sno = 1; foreach ($records as $r): ?>
                                    <tr>
                                        <td><?= $sno++ ?></td>
                                        <td><?= htmlspecialchars($r->name ?? '') ?></td>
                                        <td><?= htmlspecialchars($r->id_type ?? '') ?></td>
                                        <td><?= htmlspecialchars($r->id_number ?? '') ?></td>
                                        <td><?= htmlspecialchars($r->nationality ?? '') ?></td>
                                        <td><?= !empty($r->date_of_appointment) ? date('d M Y', strtotime($r->date_of_appointment)) : '' ?></td>
                                        <td><?= !empty($r->date_of_cessation) ? date('d M Y', strtotime($r->date_of_cessation)) : '' ?></td>
                                        <td><span class="label label-<?= strtolower($r->status ?? 'Active') === 'active' ? 'success' : 'danger' ?>"><?= htmlspecialchars($r->status ?? 'Active') ?></span></td>
                                        <td>
                                            <button class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>
                <!-- End Tab Content -->

            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('.dt-officials').each(function() {
            $(this).DataTable({
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                order: [[0, 'asc']],
                language: { emptyTable: "No records found", zeroRecords: "No matching records found" }
            });
        });
    }
    // Fix DataTable column width on tab switch
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        if ($.fn.DataTable) {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        }
    });
    // Hash-based tab navigation
    var hash = window.location.hash;
    if (hash) {
        var tabLink = $('#officialsTabs a[href="' + hash + '"]');
        if (tabLink.length) tabLink.tab('show');
    }
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        history.replaceState(null, null, e.target.hash);
    });
});
</script>
