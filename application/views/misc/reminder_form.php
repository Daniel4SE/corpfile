<!-- Create/Edit Reminder Form -->
<div class="page-title">
    <div class="title_left">
        <h3><?= isset($reminder) && $reminder ? 'Edit' : 'Set' ?> Reminder</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('reminder_list') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Reminders</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-bell"></i> Reminder Details</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="POST" action="<?= base_url(isset($reminder) && $reminder ? 'edit_reminder/' . ($reminder->id ?? '') : 'set_reminder') ?>" class="form-horizontal form-label-left">
                    <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">

                    <div class="form-group">
                        <label class="control-label col-md-3">Title <span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($reminder->title ?? '') ?>" placeholder="Reminder title" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Description</label>
                        <div class="col-md-6">
                            <textarea name="description" class="form-control" rows="3" placeholder="Description..."><?= htmlspecialchars($reminder->description ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Date <span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="date" name="reminder_date" class="form-control" value="<?= htmlspecialchars($reminder->reminder_date ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Time</label>
                        <div class="col-md-6">
                            <input type="time" name="reminder_time" class="form-control" value="<?= htmlspecialchars($reminder->reminder_time ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Priority</label>
                        <div class="col-md-6">
                            <select name="priority" class="form-control">
                                <option value="Low" <?= (isset($reminder) && ($reminder->priority ?? '') === 'Low') ? 'selected' : '' ?>>Low</option>
                                <option value="Medium" <?= (!isset($reminder) || ($reminder->priority ?? 'Medium') === 'Medium') ? 'selected' : '' ?>>Medium</option>
                                <option value="High" <?= (isset($reminder) && ($reminder->priority ?? '') === 'High') ? 'selected' : '' ?>>High</option>
                            </select>
                        </div>
                    </div>

                    <?php if (isset($reminder) && $reminder): ?>
                    <div class="form-group">
                        <label class="control-label col-md-3">Status</label>
                        <div class="col-md-6">
                            <select name="status" class="form-control">
                                <option value="Active" <?= ($reminder->status ?? '') === 'Active' ? 'selected' : '' ?>>Active</option>
                                <option value="Completed" <?= ($reminder->status ?? '') === 'Completed' ? 'selected' : '' ?>>Completed</option>
                                <option value="Dismissed" <?= ($reminder->status ?? '') === 'Dismissed' ? 'selected' : '' ?>>Dismissed</option>
                            </select>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <a href="<?= base_url('reminder_list') ?>" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> <?= isset($reminder) && $reminder ? 'Update' : 'Save' ?> Reminder</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
