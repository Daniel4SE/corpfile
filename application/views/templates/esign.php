<!-- eSign Documents -->
<div class="page-title">
    <div class="title_left">
        <h3>eSign Documents</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('esign/create') ?>" class="btn btn-success"><i class="fa fa-plus"></i> New eSign Request</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="datatable-esign" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:#206570;color:#fff;">
                            <th>S/No</th>
                            <th>Document Name</th>
                            <th>Company</th>
                            <th>Signatories</th>
                            <th>Status</th>
                            <th>Sent Date</th>
                            <th>Completed Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($documents)): ?>
                            <?php $sno = 1; foreach ($documents as $doc): ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><?= htmlspecialchars($doc->name ?? '') ?></td>
                                <td><?= htmlspecialchars($doc->company ?? '') ?></td>
                                <td><?= htmlspecialchars($doc->signatories ?? '') ?></td>
                                <td>
                                    <?php
                                    $status = $doc->status ?? 'Draft';
                                    $badge = 'label-default';
                                    if ($status === 'Completed') $badge = 'label-success';
                                    elseif ($status === 'Pending') $badge = 'label-warning';
                                    elseif ($status === 'Sent') $badge = 'label-info';
                                    elseif ($status === 'Declined') $badge = 'label-danger';
                                    ?>
                                    <span class="label <?= $badge ?>"><?= htmlspecialchars($status) ?></span>
                                </td>
                                <td><?= isset($doc->sent_at) ? date('d/m/Y', strtotime($doc->sent_at)) : '' ?></td>
                                <td><?= isset($doc->completed_at) ? date('d/m/Y', strtotime($doc->completed_at)) : '' ?></td>
                                <td>
                                    <a href="<?= base_url('esign/view/' . ($doc->id ?? '')) ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
                                    <a href="<?= base_url('esign/download/' . ($doc->id ?? '')) ?>" class="btn btn-default btn-xs"><i class="fa fa-download"></i></a>
                                    <button class="btn btn-danger btn-xs delete-item" data-id="<?= $doc->id ?? '' ?>"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted">No eSign documents found.</td>
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
        $('#datatable-esign').DataTable({
            pageLength: 10,
            lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
            order: [[5, 'desc']],
        });
    }
    if ($.fn.select2) { $('.select2').select2(); }
});
</script>
