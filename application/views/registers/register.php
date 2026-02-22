<!-- Generic Register View -->
<div class="page-title">
    <div class="title_left">
        <h3 style="display:flex;align-items:center;gap:10px;">
            <span style="width:36px;height:36px;border-radius:50%;background:<?= $config['color'] ?>;display:inline-flex;align-items:center;justify-content:center;">
                <i class="fa <?= $config['icon'] ?>" style="color:#fff;font-size:15px;"></i>
            </span>
            <?= htmlspecialchars($page_title) ?>
        </h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('registers') ?>" class="btn btn-default btn-sm">
                <i class="fa fa-arrow-left"></i> Back to Registers
            </a>
            <button class="btn btn-primary btn-sm" onclick="window.print()">
                <i class="fa fa-print"></i> Print
            </button>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title" style="background:<?= $config['color'] ?>;border-radius:3px 3px 0 0;">
                <h2 style="color:#fff;font-size:14px;">
                    <i class="fa <?= $config['icon'] ?>"></i>
                    <?= htmlspecialchars($page_title) ?>
                    <span class="badge" style="background:rgba(255,255,255,0.3);margin-left:8px;"><?= count($records) ?></span>
                </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php if (empty($records)): ?>
                <div class="text-center" style="padding:40px 0;color:#999;">
                    <i class="fa <?= $config['icon'] ?>" style="font-size:48px;opacity:0.2;display:block;margin-bottom:10px;"></i>
                    <p>No records found for this register.</p>
                </div>
                <?php else: ?>
                <table id="register-table" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr style="background:<?= $config['color'] ?>;color:#fff;">
                            <th>#</th>
                            <?php foreach ($config['columns'] as $col): ?>
                            <th><?= htmlspecialchars($col) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($records as $row): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <?php
                            // Output each field value from the record object
                            $vals = (array)$row;
                            foreach ($vals as $v):
                            ?>
                            <td><?= htmlspecialchars((string)($v ?? '')) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable && $('#register-table tbody tr').length > 0) {
        $('#register-table').DataTable({
            pageLength: 25,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            order: [[1, 'asc']],
            dom: 'Blfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        });
    }
});
</script>
