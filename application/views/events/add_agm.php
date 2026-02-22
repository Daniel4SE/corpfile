<!-- Add AGM Event -->
<div class="page-title">
    <div class="title_left">
        <h3>Add AGM Event - <?= htmlspecialchars($company->company_name ?? '') ?></h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url("company_agm_list/{$company_id}") ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to AGM List</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>AGM Event Details</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="POST" action="<?= base_url("add_agm/{$company_id}") ?>" class="form-horizontal form-label-left">
                    <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">FYE Date <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="fye_date" class="form-control datepicker" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">AGM Due Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="agm_due_date" class="form-control datepicker">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">AGM Held Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="agm_held_date" class="form-control datepicker">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">AR Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="ar_date" class="form-control datepicker">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">AR Filing Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="ar_filing_date" class="form-control datepicker">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="event_status" class="form-control">
                                <option value="Pending">Pending</option>
                                <option value="Completed">Completed</option>
                                <option value="Overdue">Overdue</option>
                                <option value="Waived">Waived</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Next Due Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="next_due_date" class="form-control datepicker">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Notes</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <a href="<?= base_url("company_agm_list/{$company_id}") ?>" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save AGM Event</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.daterangepicker) {
        $('.datepicker').daterangepicker({
            singleDatePicker: true, autoApply: true,
            locale: { format: 'DD/MM/YYYY' }
        });
        $('.datepicker').val('');
    }
});
</script>
