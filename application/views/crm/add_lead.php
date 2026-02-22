<!-- Add Lead Form -->
<div class="page-title">
    <div class="title_left">
        <h3>Add Lead</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('crm_leads') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Leads</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-user-plus"></i> Lead Information</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="POST" action="<?= base_url('add_lead') ?>" class="form-horizontal form-label-left">
                    <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Lead Name <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="lead_name" class="form-control" placeholder="Enter lead name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Company</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="company" class="form-control" placeholder="Company name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Contact Person</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="contact_person" class="form-control" placeholder="Contact person name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="email" name="email" class="form-control" placeholder="email@example.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="phone" class="form-control" placeholder="Phone number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Source</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="source" class="form-control select2_single">
                                <option value="">Select Source</option>
                                <option value="Website">Website</option>
                                <option value="Referral">Referral</option>
                                <option value="Cold Call">Cold Call</option>
                                <option value="Social Media">Social Media</option>
                                <option value="Email Campaign">Email Campaign</option>
                                <option value="Trade Show">Trade Show</option>
                                <option value="Partner">Partner</option>
                                <option value="Advertisement">Advertisement</option>
                                <option value="Walk-in">Walk-in</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="status" class="form-control select2_single">
                                <option value="Warm">Warm</option>
                                <option value="Hot">Hot</option>
                                <option value="Cold">Cold</option>
                                <option value="New">New</option>
                                <option value="Contacted">Contacted</option>
                                <option value="Qualified">Qualified</option>
                                <option value="Converted">Converted</option>
                                <option value="Lost">Lost</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Priority</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="priority" class="form-control">
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                                <option value="Low">Low</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Notes</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea name="notes" class="form-control" rows="4" placeholder="Additional notes..."></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Assigned To</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="assigned_to" class="form-control select2_single">
                                <option value="">Select User</option>
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                    <option value="<?= $user->id ?? '' ?>"><?= htmlspecialchars($user->name ?? '') ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <a href="<?= base_url('crm_leads') ?>" class="btn btn-default">Cancel</a>
                            <button type="reset" class="btn btn-warning">Reset</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Lead</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.select2) {
        $('.select2_single').select2();
    }
});
</script>
