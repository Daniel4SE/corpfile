<!-- CSS Module Settings -->
<div class="page-title">
    <div class="title_left">
        <h3><i class="fa fa-paint-brush"></i> CSS Settings</h3>
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

                <ul class="nav nav-tabs" id="cssSettingsTabs" role="tablist" style="margin-bottom:20px;">
                    <li role="presentation" class="tab-theme active"><a href="#tab_theme" data-toggle="tab"><i class="fa fa-tint"></i> Theme Color</a></li>
                    <li role="presentation" class="tab-logo"><a href="#tab_logo" data-toggle="tab"><i class="fa fa-image"></i> Logo Settings</a></li>
                    <li role="presentation" class="tab-favicon"><a href="#tab_favicon" data-toggle="tab"><i class="fa fa-star"></i> Favicon Settings</a></li>
                    <li role="presentation" class="tab-login"><a href="#tab_login" data-toggle="tab"><i class="fa fa-sign-in"></i> Login Page</a></li>
                    <li role="presentation" class="tab-custom"><a href="#tab_custom" data-toggle="tab"><i class="fa fa-code"></i> Custom CSS</a></li>
                </ul>

                <form method="POST" action="<?= base_url('css_settings') ?>" class="form-horizontal form-label-left" enctype="multipart/form-data">
                    <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">

                    <div class="tab-content">

                        <!-- Theme Color -->
                        <div class="tab-pane active" id="tab_theme">
                            <h4 style="border-bottom:1px solid #e5e5e5;padding-bottom:10px;margin-bottom:20px;"><i class="fa fa-tint"></i> Theme Color</h4>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Primary Color</label>
                                <div class="col-md-4">
                                    <input type="color" name="primary_color" class="form-control" value="#206570" style="height:40px;padding:2px;">
                                    <p class="help-block">Main brand color used for sidebar, buttons and headers.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Secondary Color</label>
                                <div class="col-md-4">
                                    <input type="color" name="secondary_color" class="form-control" value="#159895" style="height:40px;padding:2px;">
                                    <p class="help-block">Accent color used for highlights and links.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Sidebar Background</label>
                                <div class="col-md-4">
                                    <input type="color" name="sidebar_bg" class="form-control" value="#206570" style="height:40px;padding:2px;">
                                </div>
                            </div>
                        </div>

                        <!-- Logo Settings -->
                        <div class="tab-pane" id="tab_logo">
                            <h4 style="border-bottom:1px solid #e5e5e5;padding-bottom:10px;margin-bottom:20px;"><i class="fa fa-image"></i> Logo Settings</h4>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Current Logo</label>
                                <div class="col-md-6">
                                    <img src="<?= base_url('public/images/corpfile-logo.png') ?>" alt="Logo" style="max-height:60px;border:1px solid #eee;padding:5px;border-radius:4px;background:#fff;">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Upload New Logo</label>
                                <div class="col-md-6">
                                    <input type="file" name="logo_file" class="form-control" accept="image/*">
                                    <p class="help-block">Recommended size: 300×80px. Supported: PNG, JPG, SVG.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Logo Max Height</label>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="number" name="logo_height" class="form-control" value="55" min="20" max="120">
                                        <span class="input-group-addon">px</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Favicon Settings -->
                        <div class="tab-pane" id="tab_favicon">
                            <h4 style="border-bottom:1px solid #e5e5e5;padding-bottom:10px;margin-bottom:20px;"><i class="fa fa-star"></i> Favicon Settings</h4>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Current Favicon</label>
                                <div class="col-md-6">
                                    <img src="<?= base_url('public/images/favicon.png') ?>" alt="Favicon" style="width:32px;height:32px;border:1px solid #eee;padding:2px;border-radius:4px;">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Upload New Favicon</label>
                                <div class="col-md-6">
                                    <input type="file" name="favicon_file" class="form-control" accept="image/*">
                                    <p class="help-block">Recommended size: 32×32px or 64×64px. Supported: PNG, ICO.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Login Page -->
                        <div class="tab-pane" id="tab_login">
                            <h4 style="border-bottom:1px solid #e5e5e5;padding-bottom:10px;margin-bottom:20px;"><i class="fa fa-sign-in"></i> Login Page Settings</h4>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Login Background</label>
                                <div class="col-md-6">
                                    <input type="file" name="login_bg_file" class="form-control" accept="image/*,video/*">
                                    <p class="help-block">Upload a background image or video for the login page.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Login Title</label>
                                <div class="col-md-6">
                                    <input type="text" name="login_title" class="form-control" value="CorpFile" placeholder="Login page title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Show Singpass Login</label>
                                <div class="col-md-4">
                                    <label class="radio-inline"><input type="radio" name="show_singpass" value="1"> Yes</label>
                                    <label class="radio-inline"><input type="radio" name="show_singpass" value="0" checked> No</label>
                                </div>
                            </div>
                        </div>

                        <!-- Custom CSS -->
                        <div class="tab-pane" id="tab_custom">
                            <h4 style="border-bottom:1px solid #e5e5e5;padding-bottom:10px;margin-bottom:20px;"><i class="fa fa-code"></i> Custom CSS</h4>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Additional CSS</label>
                                <div class="col-md-9">
                                    <textarea name="custom_css" class="form-control" rows="15" style="font-family:monospace;font-size:12px;" placeholder="/* Enter your custom CSS here */"></textarea>
                                    <p class="help-block">Custom CSS will be applied site-wide after the default stylesheet.</p>
                                </div>
                            </div>
                        </div>

                    </div><!-- /.tab-content -->

                    <div class="form-group" style="margin-top:20px;border-top:1px solid #e5e5e5;padding-top:20px;">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Settings</button>
                            <button type="reset" class="btn btn-default" style="margin-left:8px;"><i class="fa fa-undo"></i> Reset</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Switch to correct tab based on URL path
$(document).ready(function() {
    var path = window.location.pathname;
    var tabMap = {
        'theme_color':      '.tab-theme a',
        'logo_settings':    '.tab-logo a',
        'favicon_settings': '.tab-favicon a',
        'login_page':       '.tab-login a',
        'custom_css':       '.tab-custom a'
    };
    for (var key in tabMap) {
        if (path.indexOf(key) !== -1) {
            $(tabMap[key]).tab('show');
            break;
        }
    }
});
</script>
