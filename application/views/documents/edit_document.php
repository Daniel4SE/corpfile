<div class="page-title"><div class="title_left"><h3>Edit Document</h3></div><div class="title_right"><div class="pull-right"><a href="javascript:history.back()" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a></div></div></div><div class="clearfix"></div>

<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="x_panel">
<div class="x_title"><h2>Document Details</h2><div class="clearfix"></div></div>
<div class="x_content">
<form method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
<input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">

<div class="form-group"><label class="control-label col-md-3">Document Name</label>
<div class="col-md-9"><input type="text" name="document_name" class="form-control" value="<?= htmlspecialchars($document->document_name ?? '') ?>" required></div></div>

<div class="form-group"><label class="control-label col-md-3">Category</label>
<div class="col-md-9"><select name="category_id" class="form-control select2_single">
<option value="">-- Select --</option>
<?php foreach ($categories as $cat): ?>
<option value="<?= $cat->id ?>" <?= ($document->category_id ?? '') == $cat->id ? 'selected' : '' ?>><?= htmlspecialchars($cat->category_name ?? '') ?></option>
<?php endforeach; ?>
</select></div></div>

<div class="form-group"><label class="control-label col-md-3">Description</label>
<div class="col-md-9"><textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($document->description ?? '') ?></textarea></div></div>

<div class="form-group"><label class="control-label col-md-3">Company</label>
<div class="col-md-9"><select name="company_id" class="form-control select2_single">
<option value="">-- Select --</option>
<?php foreach ($companies ?? [] as $c): ?>
<option value="<?= $c->id ?>" <?= ($document->company_id ?? '') == $c->id ? 'selected' : '' ?>><?= htmlspecialchars($c->company_name) ?></option>
<?php endforeach; ?>
</select></div></div>

<div class="form-group"><label class="control-label col-md-3">Resolution Date</label>
<div class="col-md-9"><input type="date" name="resolution_date" class="form-control" value="<?= htmlspecialchars($document->resolution_date ?? '') ?>"></div></div>

<div class="form-group"><label class="control-label col-md-3">Replace File</label>
<div class="col-md-9"><input type="file" name="file" class="form-control">
<p class="help-block">Current: <?= htmlspecialchars($document->file_path ?? 'No file') ?></p></div></div>

<div class="ln_solid"></div>
<div class="form-group"><div class="col-md-9 col-md-offset-3">
<button type="submit" class="btn btn-primary">Update Document</button>
<a href="javascript:history.back()" class="btn btn-default">Cancel</a>
</div></div>
</form>
</div></div></div></div>
