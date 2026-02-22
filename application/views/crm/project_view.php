<!-- CRM Project Detail View - Tabbed -->
<div class="page-title">
    <div class="title_left">
        <h3>Project: <?= htmlspecialchars($project->name ?? 'Not Found') ?></h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <?php if ($project): ?>
            <a href="<?= base_url('crm_project_edit/' . ($project->id ?? '')) ?>" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
            <?php endif; ?>
            <a href="<?= base_url('crm_projects') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Projects</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<?php if (!$project): ?>
    <div class="alert alert-danger">Project not found.</div>
<?php else: ?>
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#tab_overview" role="tab" data-toggle="tab"><i class="fa fa-info-circle"></i> Overview</a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_tasks" role="tab" data-toggle="tab"><i class="fa fa-check-square-o"></i> Tasks <span class="badge"><?= count($tasks) ?></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_files" role="tab" data-toggle="tab"><i class="fa fa-folder-open"></i> Files <span class="badge"><?= count($files) ?></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_timeline" role="tab" data-toggle="tab"><i class="fa fa-clock-o"></i> Timeline</a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_team" role="tab" data-toggle="tab"><i class="fa fa-users"></i> Team <span class="badge"><?= count($team) ?></span></a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Overview Tab -->
                    <div id="tab_overview" class="tab-pane fade in active" role="tabpanel">
                        <div style="margin-top:15px;">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row form-horizontal">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5 control-label"><strong>Project Name:</strong></label>
                                                <div class="col-md-7"><p class="form-control-static"><?= htmlspecialchars($project->name ?? '') ?></p></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5 control-label"><strong>Client:</strong></label>
                                                <div class="col-md-7"><p class="form-control-static"><?= htmlspecialchars($project->client_name ?? '') ?></p></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-horizontal">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5 control-label"><strong>Start Date:</strong></label>
                                                <div class="col-md-7"><p class="form-control-static"><?= !empty($project->start_date) ? date('d M Y', strtotime($project->start_date)) : '-' ?></p></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5 control-label"><strong>Due Date:</strong></label>
                                                <div class="col-md-7"><p class="form-control-static"><?= !empty($project->due_date) ? date('d M Y', strtotime($project->due_date)) : '-' ?></p></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-horizontal">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5 control-label"><strong>Status:</strong></label>
                                                <div class="col-md-7">
                                                    <p class="form-control-static">
                                                        <?php
                                                        $status = $project->status ?? 'Not Started';
                                                        $badge = 'label-default';
                                                        if ($status === 'In Progress') $badge = 'label-info';
                                                        elseif ($status === 'Completed') $badge = 'label-success';
                                                        elseif ($status === 'On Hold') $badge = 'label-warning';
                                                        elseif ($status === 'Cancelled') $badge = 'label-danger';
                                                        ?>
                                                        <span class="label <?= $badge ?>"><?= htmlspecialchars($status) ?></span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5 control-label"><strong>Priority:</strong></label>
                                                <div class="col-md-7">
                                                    <p class="form-control-static">
                                                        <?php
                                                        $priority = $project->priority ?? 'Medium';
                                                        $pbadge = 'label-info';
                                                        if ($priority === 'High') $pbadge = 'label-danger';
                                                        elseif ($priority === 'Low') $pbadge = 'label-default';
                                                        ?>
                                                        <span class="label <?= $pbadge ?>"><?= htmlspecialchars($priority) ?></span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-horizontal">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5 control-label"><strong>Budget:</strong></label>
                                                <div class="col-md-7"><p class="form-control-static">$<?= number_format($project->budget ?? 0, 2) ?></p></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="padding:10px 30px;">
                                            <label><strong>Description:</strong></label>
                                            <p style="white-space:pre-wrap;"><?= htmlspecialchars($project->description ?? '') ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="x_panel" style="background:#f7f7f7;">
                                        <div class="x_title"><h2>Progress</h2><div class="clearfix"></div></div>
                                        <div class="x_content">
                                            <div class="progress" style="margin-bottom:10px;">
                                                <div class="progress-bar progress-bar-success" style="width:<?= $project->progress ?? 0 ?>%;">
                                                    <?= $project->progress ?? 0 ?>%
                                                </div>
                                            </div>
                                            <p><strong>Tasks:</strong> <?= count($tasks) ?></p>
                                            <p><strong>Team Members:</strong> <?= count($team) ?></p>
                                            <p><strong>Files:</strong> <?= count($files) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tasks Tab -->
                    <div id="tab_tasks" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <table class="table table-striped table-bordered">
                                <thead><tr style="background:#206570;color:#fff;">
                                    <th>S/No</th><th>Task Name</th><th>Assigned To</th><th>Status</th><th>Priority</th><th>Due Date</th><th>Actions</th>
                                </tr></thead>
                                <tbody>
                                    <?php if (!empty($tasks)): $sno = 1; foreach ($tasks as $t): ?>
                                    <tr>
                                        <td><?= $sno++ ?></td>
                                        <td><?= htmlspecialchars($t->name ?? '') ?></td>
                                        <td><?= htmlspecialchars($t->assigned_to_name ?? '') ?></td>
                                        <td><span class="label label-info"><?= htmlspecialchars($t->status ?? '') ?></span></td>
                                        <td><?= htmlspecialchars($t->priority ?? '') ?></td>
                                        <td><?= !empty($t->due_date) ? date('d/m/Y', strtotime($t->due_date)) : '' ?></td>
                                        <td>
                                            <button class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; else: ?>
                                    <tr><td colspan="7" class="text-center text-muted">No tasks found.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Files Tab -->
                    <div id="tab_files" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <table class="table table-striped table-bordered">
                                <thead><tr style="background:#206570;color:#fff;">
                                    <th>S/No</th><th>File Name</th><th>Type</th><th>Size</th><th>Uploaded By</th><th>Date</th><th>Actions</th>
                                </tr></thead>
                                <tbody>
                                    <?php if (!empty($files)): $sno = 1; foreach ($files as $f): ?>
                                    <tr>
                                        <td><?= $sno++ ?></td>
                                        <td><i class="fa fa-file-o"></i> <?= htmlspecialchars($f->file_name ?? '') ?></td>
                                        <td><?= htmlspecialchars($f->file_type ?? '') ?></td>
                                        <td><?= htmlspecialchars($f->file_size ?? '') ?></td>
                                        <td><?= htmlspecialchars($f->uploaded_by_name ?? '') ?></td>
                                        <td><?= !empty($f->created_at) ? date('d/m/Y', strtotime($f->created_at)) : '' ?></td>
                                        <td>
                                            <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-download"></i></a>
                                            <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; else: ?>
                                    <tr><td colspan="7" class="text-center text-muted">No files uploaded.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Timeline Tab -->
                    <div id="tab_timeline" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <ul class="list-unstyled timeline">
                                <?php if (!empty($timeline)): foreach ($timeline as $act): ?>
                                <li>
                                    <div class="block">
                                        <div class="tags">
                                            <a class="tag"><span><?= !empty($act->created_at) ? date('d M Y H:i', strtotime($act->created_at)) : '' ?></span></a>
                                        </div>
                                        <div class="block_content">
                                            <h2 class="title"><small><?= htmlspecialchars($act->user_name ?? 'System') ?></small></h2>
                                            <p class="excerpt"><?= htmlspecialchars($act->description ?? '') ?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endforeach; else: ?>
                                <li><p class="text-muted">No timeline activities yet.</p></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Team Tab -->
                    <div id="tab_team" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <div class="row">
                                <?php if (!empty($team)): foreach ($team as $member): ?>
                                <div class="col-md-3 col-sm-4 col-xs-6" style="margin-bottom:15px;">
                                    <div class="well text-center" style="padding:15px;">
                                        <img src="<?= base_url('public/images/user.png') ?>" class="img-circle" style="width:60px;height:60px;margin-bottom:10px;">
                                        <h5><?= htmlspecialchars($member->name ?? '') ?></h5>
                                        <p class="text-muted" style="font-size:12px;"><?= htmlspecialchars($member->role ?? '') ?></p>
                                        <p style="font-size:11px;"><?= htmlspecialchars($member->email ?? '') ?></p>
                                    </div>
                                </div>
                                <?php endforeach; else: ?>
                                <div class="col-md-12"><p class="text-muted">No team members assigned.</p></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#tab_tasks table, #tab_files table').DataTable({ pageLength: 10 });
    }
});
</script>
