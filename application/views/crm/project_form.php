<!-- CRM Project Create/Edit Form -->
<div class="page-title">
    <div class="title_left">
        <h3><?= isset($project) && $project ? 'Edit' : 'Create' ?> Project</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('crm_projects') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Projects</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-tasks"></i> Project Details</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="POST" action="<?= base_url(isset($project) && $project ? 'crm_project_edit/' . ($project->id ?? '') : 'crm_project_create') ?>" class="form-horizontal form-label-left">
                    <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Project Name <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="project_name" class="form-control" value="<?= htmlspecialchars($project->name ?? '') ?>" placeholder="Project Name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Client</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="client_id" class="form-control select2_single" style="width:100%;">
                                <option value="">Select Client</option>
                                <?php if (!empty($clients)): foreach ($clients as $c): ?>
                                <option value="<?= $c->id ?>" <?= (isset($project) && ($project->client_id ?? '') == $c->id) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($c->company_name) ?>
                                </option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Start Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($project->start_date ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Due Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="date" name="due_date" class="form-control" value="<?= htmlspecialchars($project->due_date ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="status" class="form-control">
                                <?php $statuses = ['Not Started','In Progress','Completed','On Hold','Cancelled']; foreach ($statuses as $s): ?>
                                <option value="<?= $s ?>" <?= (isset($project) && ($project->status ?? '') === $s) ? 'selected' : '' ?>><?= $s ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Budget ($)</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" name="budget" class="form-control" value="<?= htmlspecialchars($project->budget ?? '0') ?>" step="0.01" min="0">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Priority</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="priority" class="form-control">
                                <option value="Low" <?= (isset($project) && ($project->priority ?? '') === 'Low') ? 'selected' : '' ?>>Low</option>
                                <option value="Medium" <?= (!isset($project) || ($project->priority ?? 'Medium') === 'Medium') ? 'selected' : '' ?>>Medium</option>
                                <option value="High" <?= (isset($project) && ($project->priority ?? '') === 'High') ? 'selected' : '' ?>>High</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Assigned Team Members</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="team_members[]" class="form-control select2_multiple" style="width:100%;" multiple>
                                <?php if (!empty($users)): foreach ($users as $u): ?>
                                <option value="<?= $u->id ?>"><?= htmlspecialchars($u->name) ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea name="description" class="form-control" rows="5" placeholder="Project description..."><?= htmlspecialchars($project->description ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <a href="<?= base_url('crm_projects') ?>" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> <?= isset($project) && $project ? 'Update' : 'Create' ?> Project</button>
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
        $('.select2_single').select2({ allowClear: true });
        $('.select2_multiple').select2({ placeholder: 'Select team members' });
    }
});
</script>
