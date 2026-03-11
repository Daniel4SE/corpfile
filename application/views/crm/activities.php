<!-- CRM Activities Log -->
<div class="page-title">
    <div class="title_left">
        <h3>Activities</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('crm_activities/add') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Log Activity</a>
            <a href="<?= base_url('dashboard') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-clock-o"></i> Activity Timeline</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php if (!empty($activities)): ?>
                <ul class="list-unstyled timeline">
                    <?php foreach ($activities as $act): ?>
                    <li>
                        <div class="block">
                            <div class="tags">
                                <a href="#" class="tag">
                                    <?php
                                    $type = $act->type ?? 'Note';
                                    $color = '#206570';
                                    if ($type === 'Call') $color = '#5cb85c';
                                    elseif ($type === 'Email') $color = '#f0ad4e';
                                    elseif ($type === 'Meeting') $color = '#337ab7';
                                    elseif ($type === 'Task') $color = '#E74C3C';
                                    ?>
                                    <span style="background:<?= $color ?>;color:#fff;padding:3px 8px;border-radius:3px;"><?= htmlspecialchars($type) ?></span>
                                </a>
                            </div>
                            <div class="block_content">
                                <h2 class="title">
                                    <span style="color:#999;font-size:12px;"><?= isset($act->created_at) ? date('d M Y, h:i A', strtotime($act->created_at)) : '' ?></span>
                                </h2>
                                <p class="excerpt"><?= htmlspecialchars($act->description ?? '') ?></p>
                                <p class="byline">
                                    <small>By: <?= htmlspecialchars($act->user ?? 'System') ?></small>
                                </p>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <!-- Empty state timeline -->
                <div class="text-center" style="padding:40px 0;">
                    <i class="fa fa-clock-o fa-3x" style="color:#ccc;"></i>
                    <h4 style="color:#999;margin-top:15px;">No activities recorded yet</h4>
                    <p class="text-muted">Activities will appear here as they are logged.</p>
                    <a href="<?= base_url('crm_activities/add') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Log First Activity</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.timeline { position: relative; padding: 0; list-style: none; }
.timeline li { position: relative; padding-left: 20px; margin-bottom: 20px; border-left: 3px solid #206570; }
.timeline li .block { padding: 10px 15px; background: #f9f9f9; border-radius: 5px; }
.timeline li .block .title { font-size: 14px; margin-bottom: 5px; }
.timeline li .block .excerpt { font-size: 13px; color: #555; margin-bottom: 5px; }
.timeline li .block .byline { font-size: 12px; color: #999; }
</style>

<script>
$(document).ready(function() {
    if ($.fn.select2) { $('.select2').select2(); }
});
</script>
