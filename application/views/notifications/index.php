<!-- Notifications Page -->
<div class="page-title">
    <div class="title_left">
        <h3>Notifications</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <button class="btn btn-default btn-sm" id="markAllRead"><i class="fa fa-check-double"></i> Mark All as Read</button>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-bell"></i> All Notifications</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php if (!empty($notifications)): ?>
                <ul class="list-unstyled msg_list">
                    <?php foreach ($notifications as $notif): ?>
                    <li class="<?= ($notif->is_read ?? false) ? '' : 'unread' ?>" style="border-bottom:1px solid #eee;padding:12px 10px;<?= ($notif->is_read ?? false) ? '' : 'background:#f5f9ff;' ?>">
                        <a href="<?= htmlspecialchars($notif->link ?? '#') ?>" style="text-decoration:none;color:inherit;">
                            <span class="image">
                                <?php
                                $type = $notif->type ?? 'info';
                                $icon = 'fa-info-circle';
                                $color = '#337ab7';
                                if ($type === 'warning') { $icon = 'fa-exclamation-triangle'; $color = '#f0ad4e'; }
                                elseif ($type === 'success') { $icon = 'fa-check-circle'; $color = '#5cb85c'; }
                                elseif ($type === 'danger') { $icon = 'fa-times-circle'; $color = '#E74C3C'; }
                                ?>
                                <i class="fa <?= $icon ?> fa-lg" style="color:<?= $color ?>;"></i>
                            </span>
                            <span>
                                <span style="font-weight:<?= ($notif->is_read ?? false) ? 'normal' : 'bold' ?>;"><?= htmlspecialchars($notif->title ?? '') ?></span>
                            </span>
                            <span class="message"><?= htmlspecialchars($notif->message ?? '') ?></span>
                            <span class="time" style="font-size:11px;color:#999;">
                                <i class="fa fa-clock-o"></i> <?= isset($notif->created_at) ? date('d M Y, h:i A', strtotime($notif->created_at)) : '' ?>
                            </span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <div class="text-center" style="padding:50px 0;">
                    <i class="fa fa-bell-slash-o fa-3x" style="color:#ccc;"></i>
                    <h4 style="color:#999;margin-top:15px;">No notifications</h4>
                    <p class="text-muted">You're all caught up! Notifications will appear here.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#markAllRead').click(function() {
        $.ajax({
            url: '<?= base_url("notifications/mark_all_read") ?>',
            type: 'POST',
            success: function(response) {
                location.reload();
            },
            error: function() {
                alert('Failed to mark notifications as read.');
            }
        });
    });
});
</script>
