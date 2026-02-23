<?php if (empty($company) && !empty($agm_events)): ?>
<!-- ALL Companies AGM List (no company selected) -->
<div class="page-title">
    <div class="title_left"><h3>Company AGM Events</h3></div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-agm-all" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>Entity Name</th>
                            <th>Client No</th>
                            <th>Registration No</th>
                            <th>No.of Event</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($agm_events as $ae): ?>
                        <tr>
                            <td><?= htmlspecialchars($ae->company_name ?? '') ?></td>
                            <td><?= htmlspecialchars($ae->client_no ?? '') ?></td>
                            <td><?= htmlspecialchars($ae->registration_no ?? '') ?></td>
                            <td><?= (int)($ae->num_events ?? 0) ?></td>
                            <td>
                                <?php if ($ae->company_id): ?>
                                <a href="<?= base_url("company_agm/agm_list/{$ae->company_id}") ?>" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> View Event</a>
                                <a href="<?= base_url("company_agm/add_agm/{$ae->company_id}/event") ?>" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> New Event</a>
                                <?php endif; ?>
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
$(function(){ if ($.fn.DataTable) { $('#datatable-agm-all').DataTable({ pageLength: 50, lengthMenu: [[10,25,50,100,-1],[10,25,50,100,"All"]], order: [[0, 'asc']] }); } });
</script>

<?php else: ?>
<!-- Per-Company AGM Event List -->
<div class="page-title">
    <div class="title_left">
        <h3>AGM Events - <?= htmlspecialchars($company->company_name ?? '') ?></h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url("company_agm/add_agm/{$company_id}") ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add AGM Event</a>
            <a href="<?= base_url("view_company/{$company_id}") ?>" class="btn btn-info btn-sm"><i class="fa fa-building"></i> View Company</a>
            <a href="<?= base_url('company_agm/company_agm_list') ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back to AGM Listing</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row tile_count">
    <div class="col-md-3 col-sm-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-calendar"></i> Total Events</span>
        <div class="count"><?= count($events ?? []) ?></div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-agm-company" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No.</th><th>FYE Date</th><th>AGM Due Date</th><th>AGM Held Date</th>
                            <th>AR Date</th><th>AR Filing Date</th><th>Status</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; foreach ($events ?? [] as $e): ?>
                        <?php
                            $agm_due = $e->agm_due_date ?? null;
                            $agm_held = $e->agm_held_date ?? null;
                            if ($agm_held) { $sl = 'success'; $st = 'Completed'; }
                            elseif ($agm_due && $agm_due < date('Y-m-d')) { $sl = 'danger'; $st = 'Overdue'; }
                            else { $sl = 'warning'; $st = 'Pending'; }
                        ?>
                        <tr>
                            <td><?= $sno++ ?></td>
                            <td><?= !empty($e->fye_date) ? date('d/m/Y', strtotime($e->fye_date)) : '-' ?></td>
                            <td><?= $agm_due ? date('d/m/Y', strtotime($agm_due)) : '-' ?></td>
                            <td><?= $agm_held ? date('d/m/Y', strtotime($agm_held)) : '-' ?></td>
                            <td><?= !empty($e->ar_date) ? date('d/m/Y', strtotime($e->ar_date)) : '-' ?></td>
                            <td><?= !empty($e->ar_filing_date) ? date('d/m/Y', strtotime($e->ar_filing_date)) : '-' ?></td>
                            <td><span class="label label-<?= $sl ?>"><?= $st ?></span></td>
                            <td>
                                <a href="<?= base_url("company_agm/edit_agm/{$e->id}") ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                                <button class="btn btn-danger btn-xs delete-agm" data-id="<?= $e->id ?>"><i class="fa fa-trash"></i></button>
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
    if ($.fn.DataTable) { $('#datatable-agm-company').DataTable({ pageLength: 25, order: [[1, 'desc']] }); }
    $('.delete-agm').click(function(){ var id=$(this).data('id'); if(confirm('Delete?')) window.location='<?= base_url("delete_agm/") ?>'+id; });
});
</script>
<?php endif; ?>
