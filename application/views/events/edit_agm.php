<!-- Edit AGM Event -->
<?php $company_id = $event->company_id ?? ''; ?>
<div class="page-title">
    <div class="title_left">
        <h3>Edit AGM Event - <?= htmlspecialchars($company->company_name ?? '') ?></h3>
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
            <div class="x_content">

                <!-- Tabs: Edit Form + Due Date Tracker -->
                <ul class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#tab_edit" role="tab" data-toggle="tab"><i class="fa fa-pencil"></i> Edit AGM Event</a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_tracker" role="tab" data-toggle="tab"><i class="fa fa-clock-o"></i> Due Date Tracker</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- EDIT TAB -->
                    <div id="tab_edit" class="tab-pane fade in active" role="tabpanel">
                        <div style="margin-top:15px;">
                            <form method="POST" action="<?= base_url("edit_agm/{$event->id}") ?>" class="form-horizontal form-label-left">
                                <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">FYE Date <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="fye_date" class="form-control datepicker" 
                                                   value="<?= !empty($event->fye_date) ? date('d/m/Y', strtotime($event->fye_date)) : '' ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">AGM Due Date</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="agm_due_date" class="form-control datepicker"
                                                   value="<?= !empty($event->agm_due_date) ? date('d/m/Y', strtotime($event->agm_due_date)) : '' ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">AGM Held Date</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="agm_held_date" class="form-control datepicker"
                                                   value="<?= !empty($event->agm_held_date) ? date('d/m/Y', strtotime($event->agm_held_date)) : '' ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">AR Date</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="ar_date" class="form-control datepicker"
                                                   value="<?= !empty($event->ar_date) ? date('d/m/Y', strtotime($event->ar_date)) : '' ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">AR Filing Date</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="ar_filing_date" class="form-control datepicker"
                                                   value="<?= !empty($event->ar_filing_date) ? date('d/m/Y', strtotime($event->ar_filing_date)) : '' ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="event_status" class="form-control">
                                            <?php foreach (['Pending','Completed','Overdue','Waived','N/A'] as $st): ?>
                                            <option value="<?= $st ?>" <?= ($event->event_status ?? '') === $st ? 'selected' : '' ?>><?= $st ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Next Due Date</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="next_due_date" class="form-control datepicker"
                                                   value="<?= !empty($event->next_due_date) ? date('d/m/Y', strtotime($event->next_due_date)) : '' ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Notes</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="notes" class="form-control" rows="3"><?= htmlspecialchars($event->notes ?? '') ?></textarea>
                                    </div>
                                </div>

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <a href="<?= base_url("company_agm_list/{$company_id}") ?>" class="btn btn-default">Cancel</a>
                                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update AGM Event</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- DUE DATE TRACKER TAB -->
                    <div id="tab_tracker" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="x_panel" style="border-left: 3px solid #206570;">
                                        <div class="x_title">
                                            <h2><i class="fa fa-info-circle"></i> Event Summary</h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <table class="table table-bordered table-condensed">
                                                <tr>
                                                    <th style="width:40%;">Company</th>
                                                    <td><?= htmlspecialchars($company->company_name ?? '') ?></td>
                                                </tr>
                                                <tr>
                                                    <th>FYE Date</th>
                                                    <td><?= !empty($event->fye_date) ? date('d M Y', strtotime($event->fye_date)) : '-' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>AGM Due Date</th>
                                                    <td>
                                                        <?= !empty($event->agm_due_date) ? date('d M Y', strtotime($event->agm_due_date)) : '-' ?>
                                                        <?php if (!empty($event->agm_due_date)): ?>
                                                            <?php
                                                                $days = (int)((strtotime($event->agm_due_date) - strtotime(date('Y-m-d'))) / 86400);
                                                                if ($days < 0): ?>
                                                                    <span class="label label-danger"><?= abs($days) ?> days overdue</span>
                                                                <?php elseif ($days <= 30): ?>
                                                                    <span class="label label-warning"><?= $days ?> days remaining</span>
                                                                <?php else: ?>
                                                                    <span class="label label-success"><?= $days ?> days remaining</span>
                                                                <?php endif; ?>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>AGM Held Date</th>
                                                    <td><?= !empty($event->agm_held_date) ? date('d M Y', strtotime($event->agm_held_date)) : '<span class="text-muted">Not yet held</span>' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>AR Date</th>
                                                    <td><?= !empty($event->ar_date) ? date('d M Y', strtotime($event->ar_date)) : '-' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>AR Filing Date</th>
                                                    <td><?= !empty($event->ar_filing_date) ? date('d M Y', strtotime($event->ar_filing_date)) : '-' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Next Due Date</th>
                                                    <td><?= !empty($event->next_due_date) ? date('d M Y', strtotime($event->next_due_date)) : '-' ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="x_panel" style="border-left: 3px solid #26B99A;">
                                        <div class="x_title">
                                            <h2><i class="fa fa-history"></i> Timeline</h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <ul class="list-unstyled timeline">
                                                <?php if (!empty($event->fye_date)): ?>
                                                <li>
                                                    <div class="block">
                                                        <div class="tags"><a class="tag"><span class="label label-info">FYE</span></a></div>
                                                        <div class="block_content">
                                                            <h2 class="title" style="font-size:14px;">Financial Year End</h2>
                                                            <p class="excerpt" style="font-size:12px;"><?= date('d M Y', strtotime($event->fye_date)) ?></p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php endif; ?>
                                                <?php if (!empty($event->agm_due_date)): ?>
                                                <li>
                                                    <div class="block">
                                                        <div class="tags"><a class="tag"><span class="label label-warning">AGM Due</span></a></div>
                                                        <div class="block_content">
                                                            <h2 class="title" style="font-size:14px;">AGM Due Date</h2>
                                                            <p class="excerpt" style="font-size:12px;"><?= date('d M Y', strtotime($event->agm_due_date)) ?></p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php endif; ?>
                                                <?php if (!empty($event->agm_held_date)): ?>
                                                <li>
                                                    <div class="block">
                                                        <div class="tags"><a class="tag"><span class="label label-success">AGM Held</span></a></div>
                                                        <div class="block_content">
                                                            <h2 class="title" style="font-size:14px;">AGM Held</h2>
                                                            <p class="excerpt" style="font-size:12px;"><?= date('d M Y', strtotime($event->agm_held_date)) ?></p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php endif; ?>
                                                <?php if (!empty($event->ar_filing_date)): ?>
                                                <li>
                                                    <div class="block">
                                                        <div class="tags"><a class="tag"><span class="label label-primary">AR Filed</span></a></div>
                                                        <div class="block_content">
                                                            <h2 class="title" style="font-size:14px;">Annual Return Filed</h2>
                                                            <p class="excerpt" style="font-size:12px;"><?= date('d M Y', strtotime($event->ar_filing_date)) ?></p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
    }
});
</script>
