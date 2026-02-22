<div class="page-title"><div class="title_left"><h3><?= !empty($form) ? 'Edit' : 'Add' ?> Form Template</h3></div><div class="title_right"><div class="pull-right"><a href="javascript:history.back()" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a></div></div></div><div class="clearfix"></div>

<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="x_panel">
<div class="x_title"><h2>Form Details</h2><div class="clearfix"></div></div>
<div class="x_content">
<form method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
<input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">

<div class="form-group"><label class="control-label col-md-3">Form Name <span class="required">*</span></label>
<div class="col-md-9"><input type="text" name="template_name" class="form-control" value="<?= htmlspecialchars($form->template_name ?? '') ?>" required></div></div>

<div class="form-group"><label class="control-label col-md-3">Category</label>
<div class="col-md-9"><select name="category_id" class="form-control select2_single">
<option value="">-- Select --</option>
<?php foreach ($form_categories as $fc): ?>
<option value="<?= $fc->id ?>" <?= ($form->category_id ?? '') == $fc->id ? 'selected' : '' ?>><?= htmlspecialchars($fc->category_name ?? '') ?></option>
<?php endforeach; ?>
</select></div></div>

<div class="form-group"><label class="control-label col-md-3">Description</label>
<div class="col-md-9"><textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($form->description ?? '') ?></textarea></div></div>

<div class="form-group"><label class="control-label col-md-3">Template File</label>
<div class="col-md-9"><input type="file" name="template_file" class="form-control">
<?php if (!empty($form->file_path)): ?><p class="help-block">Current: <?= htmlspecialchars($form->file_path) ?></p><?php endif; ?>
</div></div>

<div class="form-group"><label class="control-label col-md-3">Status</label>
<div class="col-md-9"><select name="status" class="form-control">
<option value="Active" <?= ($form->status ?? 'Active') == 'Active' ? 'selected' : '' ?>>Active</option>
<option value="Inactive" <?= ($form->status ?? '') == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
</select></div></div>

<div class="ln_solid"></div>
<div class="form-group"><div class="col-md-9 col-md-offset-3">
<button type="submit" class="btn btn-primary"><?= !empty($form) ? 'Update' : 'Create' ?> Form</button>
<a href="javascript:history.back()" class="btn btn-default">Cancel</a>
</div></div>
</form>
</div></div></div></div>
