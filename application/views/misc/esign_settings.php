<!-- eSign Settings -->
<div class="page-title">
    <div class="title_left">
        <h3>eSign Settings</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('esign_log') ?>" class="btn btn-info"><i class="fa fa-list"></i> View Log</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-pencil-square-o"></i> eSign Configuration</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="POST" action="<?= base_url('esign_settings') ?>" class="form-horizontal form-label-left">
                    <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">

                    <div class="form-group">
                        <label class="control-label col-md-3">Provider</label>
                        <div class="col-md-6">
                            <select name="provider" class="form-control">
                                <option value="">Select Provider</option>
                                <option value="DocuSign" <?= (isset($settings) && ($settings->provider ?? '') === 'DocuSign') ? 'selected' : '' ?>>DocuSign</option>
                                <option value="Adobe Sign" <?= (isset($settings) && ($settings->provider ?? '') === 'Adobe Sign') ? 'selected' : '' ?>>Adobe Sign</option>
                                <option value="SignNow" <?= (isset($settings) && ($settings->provider ?? '') === 'SignNow') ? 'selected' : '' ?>>SignNow</option>
                                <option value="HelloSign" <?= (isset($settings) && ($settings->provider ?? '') === 'HelloSign') ? 'selected' : '' ?>>HelloSign</option>
                                <option value="Custom" <?= (isset($settings) && ($settings->provider ?? '') === 'Custom') ? 'selected' : '' ?>>Custom</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">API Key</label>
                        <div class="col-md-6">
                            <input type="text" name="api_key" class="form-control" value="<?= htmlspecialchars($settings->api_key ?? '') ?>" placeholder="API Key">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">API Secret</label>
                        <div class="col-md-6">
                            <input type="password" name="api_secret" class="form-control" value="<?= htmlspecialchars($settings->api_secret ?? '') ?>" placeholder="API Secret">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Callback URL</label>
                        <div class="col-md-6">
                            <input type="url" name="callback_url" class="form-control" value="<?= htmlspecialchars($settings->callback_url ?? '') ?>" placeholder="https://yourdomain.com/callback">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Status</label>
                        <div class="col-md-6">
                            <select name="status" class="form-control">
                                <option value="Active" <?= (isset($settings) && ($settings->status ?? '') === 'Active') ? 'selected' : '' ?>>Active</option>
                                <option value="Inactive" <?= (isset($settings) && ($settings->status ?? '') === 'Inactive') ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> Save Settings</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
