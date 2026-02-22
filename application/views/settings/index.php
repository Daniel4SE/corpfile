<!-- Settings Page - Tabbed Interface -->
<div class="page-title">
    <div class="title_left">
        <h3>Settings</h3>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <!-- Settings Tabs -->
                <ul class="nav nav-tabs bar_tabs" id="settingsTabs" role="tablist">
                    <li role="presentation" class="<?= ($active_tab === 'general') ? 'active' : '' ?>">
                        <a href="#tab_general" role="tab" data-toggle="tab"><i class="fa fa-cog"></i> General</a>
                    </li>
                    <li role="presentation" class="<?= ($active_tab === 'users') ? 'active' : '' ?>">
                        <a href="#tab_users" role="tab" data-toggle="tab"><i class="fa fa-users"></i> Users</a>
                    </li>
                    <li role="presentation" class="<?= ($active_tab === 'css') ? 'active' : '' ?>">
                        <a href="#tab_css" role="tab" data-toggle="tab"><i class="fa fa-paint-brush"></i> CSS</a>
                    </li>
                    <li role="presentation" class="<?= ($active_tab === 'presales') ? 'active' : '' ?>">
                        <a href="#tab_presales" role="tab" data-toggle="tab"><i class="fa fa-line-chart"></i> Pre-Sales</a>
                    </li>
                    <li role="presentation" class="<?= ($active_tab === 'order') ? 'active' : '' ?>">
                        <a href="#tab_order" role="tab" data-toggle="tab"><i class="fa fa-shopping-cart"></i> Order Processing</a>
                    </li>
                    <li role="presentation" class="<?= ($active_tab === 'pm') ? 'active' : '' ?>">
                        <a href="#tab_pm" role="tab" data-toggle="tab"><i class="fa fa-tasks"></i> PM</a>
                    </li>
                    <li role="presentation" class="<?= ($active_tab === 'support') ? 'active' : '' ?>">
                        <a href="#tab_support" role="tab" data-toggle="tab"><i class="fa fa-ticket"></i> Support</a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content">

                    <!-- General Tab -->
                    <div role="tabpanel" class="tab-pane fade <?= ($active_tab === 'general') ? 'in active' : '' ?>" id="tab_general">
                        <div class="row" style="padding-top:20px;">
                            <!-- Company Profile -->
                            <div class="col-md-6">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2><i class="fa fa-building"></i> Company Profile</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <p><strong>Company Name:</strong> <?= htmlspecialchars($company_profile->company_name ?? 'Not Set') ?></p>
                                        <p><strong>Registration No:</strong> <?= htmlspecialchars($company_profile->registration_number ?? 'Not Set') ?></p>
                                        <p><strong>Email:</strong> <?= htmlspecialchars($company_profile->email ?? 'Not Set') ?></p>
                                        <p><strong>Phone:</strong> <?= htmlspecialchars($company_profile->phone ?? 'Not Set') ?></p>
                                        <a href="<?= base_url('general_settings') ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit Profile</a>
                                    </div>
                                </div>
                            </div>

                            <!-- System Preferences -->
                            <div class="col-md-6">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2><i class="fa fa-sliders"></i> System Preferences</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <p><strong>Date Format:</strong> DD/MM/YYYY</p>
                                        <p><strong>Currency:</strong> SGD</p>
                                        <p><strong>Timezone:</strong> Asia/Singapore (GMT+8)</p>
                                        <p><strong>Language:</strong> English</p>
                                        <a href="<?= base_url('general_settings') ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit Preferences</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Email Settings -->
                            <div class="col-md-6">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2><i class="fa fa-envelope"></i> Email Settings</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <p><strong>SMTP Host:</strong> <span class="text-muted">Configure in General Settings</span></p>
                                        <p><strong>From Email:</strong> <span class="text-muted">Configure in General Settings</span></p>
                                        <a href="<?= base_url('general_settings') ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Configure Email</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Notification Settings -->
                            <div class="col-md-6">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2><i class="fa fa-bell"></i> Notification Settings</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <p><strong>AGM Reminders:</strong> <span class="label label-success">Enabled</span></p>
                                        <p><strong>AR Reminders:</strong> <span class="label label-success">Enabled</span></p>
                                        <p><strong>Email Notifications:</strong> <span class="label label-success">Enabled</span></p>
                                        <a href="<?= base_url('general_settings') ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Configure Notifications</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Users Tab -->
                    <div role="tabpanel" class="tab-pane fade <?= ($active_tab === 'users') ? 'in active' : '' ?>" id="tab_users">
                        <div style="padding-top:20px;">
                            <div class="pull-right" style="margin-bottom:15px;">
                                <a href="<?= base_url('user_settings') ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add User</a>
                            </div>
                            <div class="clearfix"></div>
                            <table id="datatable-users" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr style="background:#206570;color:#fff;">
                                        <th>S/No.</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Last Login</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sno = 1; foreach ($users as $u): ?>
                                    <tr>
                                        <td><?= $sno++ ?></td>
                                        <td><?= htmlspecialchars($u->name ?? '') ?></td>
                                        <td><?= htmlspecialchars($u->username ?? '') ?></td>
                                        <td><?= htmlspecialchars($u->email ?? '') ?></td>
                                        <td><?= htmlspecialchars($u->role ?? 'User') ?></td>
                                        <td>
                                            <span class="label label-<?= ($u->status ?? 1) == 1 ? 'success' : 'danger' ?>">
                                                <?= ($u->status ?? 1) == 1 ? 'Active' : 'Inactive' ?>
                                            </span>
                                        </td>
                                        <td><?= !empty($u->last_login) ? date('d/m/Y H:i', strtotime($u->last_login)) : 'Never' ?></td>
                                        <td>
                                            <a href="<?= base_url("user_settings/edit_user/{$u->id}") ?>" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
                                            <button class="btn btn-danger btn-xs delete-user" data-id="<?= $u->id ?>"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- CSS Tab -->
                    <div role="tabpanel" class="tab-pane fade <?= ($active_tab === 'css') ? 'in active' : '' ?>" id="tab_css">
                        <div style="padding-top:20px;">
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="<?= base_url('css_settings/theme_color') ?>" class="btn btn-default btn-block" style="padding:20px;margin-bottom:10px;">
                                        <i class="fa fa-paint-brush fa-2x"></i><br>Theme Color
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="<?= base_url('css_settings/logo_settings') ?>" class="btn btn-default btn-block" style="padding:20px;margin-bottom:10px;">
                                        <i class="fa fa-image fa-2x"></i><br>Logo Settings
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="<?= base_url('css_settings/favicon_settings') ?>" class="btn btn-default btn-block" style="padding:20px;margin-bottom:10px;">
                                        <i class="fa fa-bookmark fa-2x"></i><br>Favicon Settings
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="<?= base_url('css_settings/login_page') ?>" class="btn btn-default btn-block" style="padding:20px;margin-bottom:10px;">
                                        <i class="fa fa-sign-in fa-2x"></i><br>Login Page
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="<?= base_url('css_settings/custom_css') ?>" class="btn btn-default btn-block" style="padding:20px;margin-bottom:10px;">
                                        <i class="fa fa-code fa-2x"></i><br>Custom CSS
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pre-Sales Tab -->
                    <div role="tabpanel" class="tab-pane fade <?= ($active_tab === 'presales') ? 'in active' : '' ?>" id="tab_presales">
                        <div style="padding-top:20px;">
                            <div class="list-group">
                                <a href="<?= base_url('presales_settings/lead_source') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Lead Source</a>
                                <a href="<?= base_url('presales_settings/lead_status') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Lead Status</a>
                                <a href="<?= base_url('presales_settings/lead_category') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Lead Category</a>
                                <a href="<?= base_url('presales_settings/industry_type') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Industry Type</a>
                                <a href="<?= base_url('presales_settings/follow_up_type') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Follow Up Type</a>
                                <a href="<?= base_url('presales_settings/quotation_terms') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Quotation Terms</a>
                                <a href="<?= base_url('presales_settings/service_list') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Service List</a>
                            </div>
                        </div>
                    </div>

                    <!-- Order Processing Tab -->
                    <div role="tabpanel" class="tab-pane fade <?= ($active_tab === 'order') ? 'in active' : '' ?>" id="tab_order">
                        <div style="padding-top:20px;">
                            <div class="list-group">
                                <a href="<?= base_url('order_settings/order_status') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Order Status</a>
                                <a href="<?= base_url('order_settings/payment_terms') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Payment Terms</a>
                            </div>
                        </div>
                    </div>

                    <!-- PM Tab -->
                    <div role="tabpanel" class="tab-pane fade <?= ($active_tab === 'pm') ? 'in active' : '' ?>" id="tab_pm">
                        <div style="padding-top:20px;">
                            <div class="list-group">
                                <a href="<?= base_url('pm_settings/project_status') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Project Status</a>
                                <a href="<?= base_url('pm_settings/project_category') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Project Category</a>
                                <a href="<?= base_url('pm_settings/task_status') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Task Status</a>
                                <a href="<?= base_url('pm_settings/task_priority') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Task Priority</a>
                                <a href="<?= base_url('pm_settings/task_category') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Task Category</a>
                                <a href="<?= base_url('pm_settings/activity_type') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Activity Type</a>
                                <a href="<?= base_url('pm_settings/activity_status') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Activity Status</a>
                                <a href="<?= base_url('pm_settings/milestone') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Milestone</a>
                                <a href="<?= base_url('pm_settings/timesheet_category') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Timesheet Category</a>
                            </div>
                        </div>
                    </div>

                    <!-- Support Tab -->
                    <div role="tabpanel" class="tab-pane fade <?= ($active_tab === 'support') ? 'in active' : '' ?>" id="tab_support">
                        <div style="padding-top:20px;">
                            <div class="list-group">
                                <a href="<?= base_url('support_settings/ticket_status') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Ticket Status</a>
                                <a href="<?= base_url('support_settings/ticket_priority') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Ticket Priority</a>
                                <a href="<?= base_url('support_settings/ticket_category') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Ticket Category</a>
                                <a href="<?= base_url('support_settings/ticket_department') ?>" class="list-group-item"><i class="fa fa-arrow-right"></i> Ticket Department</a>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /Tab Content -->
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#datatable-users').DataTable({
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            order: [[1, 'asc']],
        });
    }

    // Delete user
    $('.delete-user').click(function() {
        var id = $(this).data('id');
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Are you sure?',
                text: "This user will be deactivated!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url("user_settings/delete_user/") ?>' + id;
                }
            });
        } else if (confirm('Are you sure you want to delete this user?')) {
            window.location.href = '<?= base_url("user_settings/delete_user/") ?>' + id;
        }
    });
});
</script>
