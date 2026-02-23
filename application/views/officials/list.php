<!-- Company Officials Global Listing -->
<div class="page-title">
    <div class="title_left">
        <h3>Company Officials</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('company_list') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Companies</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <!-- Data Table -->
                <table id="datatable_company_officials" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No.</th>
                            <th>Company Name</th>
                            <th>Client No.</th>
                            <th>Registration No.</th>
                            <th>No.of Directors</th>
                            <th>No.of Shareholders</th>
                            <th>No.of Secretaries</th>
                            <th>No.of Auditors</th>
                            <th>No.of Managers</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; foreach ($companies as $c): ?>
                        <tr>
                            <td><?= $sno++ ?></td>
                            <td><a href="<?= base_url('view_company/' . $c->id) ?>"><?= htmlspecialchars($c->company_name) ?></a></td>
                            <td><?= htmlspecialchars($c->registration_number ?? '') ?></td>
                            <td><?= htmlspecialchars($c->registration_number ?? '') ?></td>
                            <td><?= $c->total_directors ?? 0 ?></td>
                            <td><?= $c->total_shareholders ?? 0 ?></td>
                            <td><?= $c->total_secretaries ?? 0 ?></td>
                            <td><?= $c->total_auditors ?? 0 ?></td>
                            <td><?= $c->total_managers ?? 0 ?></td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Select Officials <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?= base_url("company_officials/director_list/{$c->id}/director?view=view_officials") ?>">Directors</a></li>
                                        <li><a href="<?= base_url("company_shares/shareholders_listing/{$c->id}/view/view_officials") ?>">Shareholders</a></li>
                                        <li><a href="<?= base_url("company_officials/secretary_list/{$c->id}/secretary?view=view_officials") ?>">Secretaries</a></li>
                                        <li><a href="<?= base_url("company_officials/auditor_list/{$c->id}/auditor?view=view_officials") ?>">Auditors</a></li>
                                        <li><a href="<?= base_url("company_officials/representative_list/{$c->id}/representative?view=view_officials") ?>">Representatives</a></li>
                                        <li><a href="<?= base_url("company_officials/owner_list/{$c->id}/owner?view=view_officials") ?>">Owners</a></li>
                                        <li><a href="<?= base_url("company_officials/contact_person_list/{$c->id}/contact_person?view=view_officials") ?>">Contact Persons</a></li>
                                        <li><a href="<?= base_url("company_officials/chairperson_list/{$c->id}/chairperson?view=view_officials") ?>">Chairpersons</a></li>
                                        <li><a href="<?= base_url("company_officials/controller_list/{$c->id}/controller?view=view_officials") ?>">Controllers</a></li>
                                        <li><a href="<?= base_url("company_officials/dpo_list/{$c->id}/data_protection?view=view_officials") ?>">Data Protection Officers (DPOs)</a></li>
                                        <li><a href="<?= base_url("company_officials/partner_list/{$c->id}/partner?view=view_officials") ?>">Partners</a></li>
                                        <li><a href="<?= base_url("company_officials/chief_rep_list/{$c->id}/chief_representative?view=view_officials") ?>">Chief Representative</a></li>
                                        <li><a href="<?= base_url("company_officials/deputy_rep_list/{$c->id}/deputy_representative?view=view_officials") ?>">Deputy Representative</a></li>
                                        <li><a href="<?= base_url("company_officials/ep_holder_list/{$c->id}/ep_holder?view=view_officials") ?>">EP Holder</a></li>
                                        <li><a href="<?= base_url("company_officials/dp_holder_list/{$c->id}/dp_holder?view=view_officials") ?>">DP Holder</a></li>
                                        <li><a href="<?= base_url("company_officials/corp_rep_list/{$c->id}/corporate_representative?view=view_officials") ?>">Corporate Representative</a></li>
                                    </ul>
                                </div>
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
        $('#datatable_company_officials').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            order: [[1, 'asc']],
        });
    }
});
</script>
