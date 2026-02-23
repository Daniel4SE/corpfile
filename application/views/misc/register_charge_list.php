<!-- Register of Charges -->
<div class="page-title">
    <div class="title_left">
        <h3>Register of Charges</h3>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-charges" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No.</th>
                            <th>Company Name</th>
                            <th>Charge No.</th>
                            <th>Type of charge</th>
                            <th>Date of Creation</th>
                            <th>Date of Registration</th>
                            <th>Name of chargee</th>
                            <th>Amount of Charge</th>
                            <th>Date of Discharge</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; foreach ($charges as $ch): ?>
                        <tr>
                            <td><?= $sno++ ?></td>
                            <td><?= htmlspecialchars($ch->company_name ?? '') ?></td>
                            <td><?= htmlspecialchars($ch->charge_number ?? '') ?></td>
                            <td><?= htmlspecialchars($ch->charge_description ?? '') ?></td>
                            <td><?= !empty($ch->date_of_registration) ? date('d/m/Y', strtotime($ch->date_of_registration)) : '' ?></td>
                            <td><?= !empty($ch->date_of_registration) ? date('d/m/Y', strtotime($ch->date_of_registration)) : '' ?></td>
                            <td><?= htmlspecialchars($ch->chargee_name ?? '') ?></td>
                            <td><?= ($ch->charge_amount ?? 0) > 0 ? number_format($ch->charge_amount, 2) : 'All Monies' ?></td>
                            <td><?= !empty($ch->date_of_discharge) ? date('d/m/Y', strtotime($ch->date_of_discharge)) : '' ?></td>
                            <td>
                                <button class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit</button>
                                <a href="<?= base_url('view_company/' . ($ch->company_id ?? '')) ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> View</a>
                                <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
                                <button class="btn btn-default btn-xs"><i class="fa fa-history"></i> Document History</button>
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
        $('#datatable-charges').DataTable({
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            order: [[0, 'asc']]
        });
    }
});
</script>
