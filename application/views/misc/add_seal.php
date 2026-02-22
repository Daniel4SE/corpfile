<!-- Add Seal Form -->
<div class="page-title">
    <div class="title_left">
        <h3>Add Seal</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('sealings_list') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to List</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-stamp"></i> Seal Details</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="POST" action="<?= base_url('add_seal') ?>" class="form-horizontal form-label-left">
                    <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">

                    <div class="form-group">
                        <label class="control-label col-md-3">Company <span class="required">*</span></label>
                        <div class="col-md-6">
                            <select name="company_id" class="form-control select2_single" style="width:100%;" required>
                                <option value="">Select Company</option>
                                <?php if (!empty($companies)): foreach ($companies as $c): ?>
                                <option value="<?= $c->id ?>"><?= htmlspecialchars($c->company_name) ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Seal Type <span class="required">*</span></label>
                        <div class="col-md-6">
                            <select name="seal_type" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="Common Seal">Common Seal</option>
                                <option value="Company Stamp">Company Stamp</option>
                                <option value="Securities Seal">Securities Seal</option>
                                <option value="Official Seal">Official Seal</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Seal Number</label>
                        <div class="col-md-6">
                            <input type="text" name="seal_number" class="form-control" placeholder="Seal Number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Date Sealed</label>
                        <div class="col-md-6">
                            <input type="date" name="date_sealed" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Description</label>
                        <div class="col-md-6">
                            <textarea name="description" class="form-control" rows="3" placeholder="Description..."></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Status</label>
                        <div class="col-md-6">
                            <select name="status" class="form-control">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <a href="<?= base_url('sealings_list') ?>" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Seal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() { if ($.fn.select2) { $('.select2_single').select2({ allowClear: true }); } });
</script>
