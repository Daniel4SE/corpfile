<!-- Bulk Add AGM Events -->
<div class="page-title">
    <div class="title_left">
        <h3>Bulk Add AGM Events</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('agm_listing') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to AGM Listing</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Select Companies & Set AGM Dates</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="POST" action="<?= base_url('multiple_add_agm') ?>" class="form-horizontal form-label-left">
                    <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">

                    <!-- Company Selection -->
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Companies <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="company_ids[]" class="form-control select2" multiple="multiple" required>
                                <?php foreach ($companies ?? [] as $c): ?>
                                <option value="<?= $c->id ?>"><?= htmlspecialchars($c->company_name) ?> (<?= htmlspecialchars($c->registration_number ?? '') ?>)</option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Select multiple companies to add AGM events for all of them.</small>
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <!-- Common Date Fields -->
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Next Due Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="next_due_date" class="form-control datepicker">
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Notes</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <a href="<?= base_url('agm_listing') ?>" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Create AGM Events for Selected Companies</button>
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
        $('.select2').select2({ placeholder: 'Select companies...', allowClear: true });
    }
    if ($.fn.daterangepicker) {
        $('.datepicker').daterangepicker({
            singleDatePicker: true, autoApply: true,
            locale: { format: 'DD/MM/YYYY' }
        });
        $('.datepicker').val('');
    }
});
</script>
