<!-- General Settings Page -->
<div class="page-title">
    <div class="title_left">
        <h3>General Settings</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('settings') ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back to Settings</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <form method="POST" action="<?= base_url('general_settings') ?>" class="form-horizontal form-label-left">
                    <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?>">

                    <!-- Company Profile Section -->
                    <div class="form-group">
                        <div class="col-md-12">
                            <h4 style="border-bottom:1px solid #e5e5e5;padding-bottom:10px;">
                                <i class="fa fa-building"></i> Company Profile
                            </h4>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Company Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="company_name" value="<?= htmlspecialchars($company_profile->company_name ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Registration No.</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="registration_number" value="<?= htmlspecialchars($company_profile->registration_number ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($company_profile->email ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($company_profile->phone ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea class="form-control" name="address" rows="3"><?= htmlspecialchars($company_profile->address ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <!-- System Preferences Section -->
                    <div class="form-group">
                        <div class="col-md-12">
                            <h4 style="border-bottom:1px solid #e5e5e5;padding-bottom:10px;">
                                <i class="fa fa-sliders"></i> System Preferences
                            </h4>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Format</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="date_format">
                                <option value="DD/MM/YYYY" selected>DD/MM/YYYY</option>
                                <option value="MM/DD/YYYY">MM/DD/YYYY</option>
                                <option value="YYYY-MM-DD">YYYY-MM-DD</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Currency</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="currency">
                                <option value="SGD" selected>SGD - Singapore Dollar</option>
                                <option value="USD">USD - US Dollar</option>
                                <option value="MYR">MYR - Malaysian Ringgit</option>
                                <option value="HKD">HKD - Hong Kong Dollar</option>
                                <option value="GBP">GBP - British Pound</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Timezone</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="timezone">
                                <option value="Asia/Singapore" selected>Asia/Singapore (GMT+8)</option>
                                <option value="Asia/Kuala_Lumpur">Asia/Kuala_Lumpur (GMT+8)</option>
                                <option value="Asia/Hong_Kong">Asia/Hong_Kong (GMT+8)</option>
                                <option value="UTC">UTC (GMT+0)</option>
                            </select>
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <!-- Email Settings Section -->
                    <div class="form-group">
                        <div class="col-md-12">
                            <h4 style="border-bottom:1px solid #e5e5e5;padding-bottom:10px;">
                                <i class="fa fa-envelope"></i> Email Settings
                            </h4>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">SMTP Host</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="smtp_host" placeholder="smtp.example.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">SMTP Port</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" class="form-control" name="smtp_port" placeholder="587" value="587">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">SMTP Username</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="smtp_username" placeholder="user@example.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">SMTP Password</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="password" class="form-control" name="smtp_password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">From Email</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="email" class="form-control" name="from_email" placeholder="noreply@example.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">From Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="from_name" placeholder="CS System">
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <!-- Notification Settings Section -->
                    <div class="form-group">
                        <div class="col-md-12">
                            <h4 style="border-bottom:1px solid #e5e5e5;padding-bottom:10px;">
                                <i class="fa fa-bell"></i> Notification Settings
                            </h4>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">AGM Reminder (days before)</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" class="form-control" name="agm_reminder_days" value="30" min="1" max="365">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">AR Reminder (days before)</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" class="form-control" name="ar_reminder_days" value="30" min="1" max="365">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">ID Expiry Reminder (days before)</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" class="form-control" name="id_expiry_reminder_days" value="90" min="1" max="365">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email Notifications</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="checkbox">
                                <label><input type="checkbox" name="email_agm_reminder" value="1" checked> AGM Reminders</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" name="email_ar_reminder" value="1" checked> AR Reminders</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" name="email_id_expiry" value="1" checked> ID Expiry Reminders</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" name="email_fye_reminder" value="1" checked> FYE Reminders</label>
                            </div>
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Settings</button>
                            <a href="<?= base_url('settings') ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
