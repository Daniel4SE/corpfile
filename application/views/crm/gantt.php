<!-- CRM Project Gantt Chart View -->
<div class="page-title">
    <div class="title_left">
        <h3>Project Gantt Chart</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('crm_projects') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Projects</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-bar-chart"></i> Gantt Timeline</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- Gantt Chart Container -->
                <div id="gantt_chart" style="min-height:500px;overflow-x:auto;">
                    <?php if (!empty($projects) || !empty($tasks)): ?>
                    <table class="table table-bordered" style="min-width:1200px;">
                        <thead>
                            <tr style="background:#f5f5f5;">
                                <th style="width:250px;position:sticky;left:0;background:#f5f5f5;z-index:1;">Task / Project</th>
                                <th style="width:100px;">Start</th>
                                <th style="width:100px;">End</th>
                                <th style="width:80px;">Status</th>
                                <th>Timeline</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($projects)): foreach ($projects as $p): ?>
                            <tr style="background:#e8f4fd;">
                                <td style="position:sticky;left:0;background:#e8f4fd;z-index:1;">
                                    <strong><i class="fa fa-folder-open"></i> <?= htmlspecialchars($p->name ?? '') ?></strong>
                                </td>
                                <td><?= !empty($p->start_date) ? date('d/m/Y', strtotime($p->start_date)) : '-' ?></td>
                                <td><?= !empty($p->due_date) ? date('d/m/Y', strtotime($p->due_date)) : '-' ?></td>
                                <td><span class="label label-info"><?= htmlspecialchars($p->status ?? '') ?></span></td>
                                <td>
                                    <div style="background:#3498db;height:20px;border-radius:3px;min-width:50px;opacity:0.7;" title="<?= htmlspecialchars($p->name ?? '') ?>"></div>
                                </td>
                            </tr>
                            <?php endforeach; endif; ?>

                            <?php if (!empty($tasks)): foreach ($tasks as $t): ?>
                            <tr>
                                <td style="position:sticky;left:0;background:#fff;z-index:1;padding-left:30px;">
                                    <i class="fa fa-check-square-o"></i> <?= htmlspecialchars($t->name ?? '') ?>
                                    <small class="text-muted">(<?= htmlspecialchars($t->project_name ?? '') ?>)</small>
                                </td>
                                <td><?= !empty($t->start_date) ? date('d/m/Y', strtotime($t->start_date)) : '-' ?></td>
                                <td><?= !empty($t->due_date) ? date('d/m/Y', strtotime($t->due_date)) : '-' ?></td>
                                <td><span class="label label-default"><?= htmlspecialchars($t->status ?? '') ?></span></td>
                                <td>
                                    <div style="background:#2ecc71;height:16px;border-radius:3px;min-width:30px;margin-top:2px;opacity:0.7;"></div>
                                </td>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <div class="text-center text-muted" style="padding:60px;">
                        <i class="fa fa-bar-chart fa-4x"></i>
                        <h4 style="margin-top:20px;">No projects or tasks to display</h4>
                        <p>Create projects and tasks to see the Gantt chart timeline.</p>
                        <a href="<?= base_url('crm_project_create') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Create Project</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // FullCalendar timeline placeholder
    if (typeof $.fn.fullCalendar !== 'undefined') {
        // Could initialize FullCalendar timeline view here
    }
});
</script>
