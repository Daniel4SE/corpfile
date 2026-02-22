<!-- Settings Master Form - Reusable add/edit form for all 42 master types -->
<div class="page-title">
    <div class="title_left">
        <h3><?= $is_edit ? 'Edit' : 'Add' ?> <?= htmlspecialchars($config['title']) ?></h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('settings_master/' . htmlspecialchars($master_type)) ?>" class="btn btn-default btn-sm">
                <i class="fa fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<?php if (!empty($flash)): ?>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : htmlspecialchars($flash['type']) ?> alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?= $flash['message'] ?>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    <i class="fa fa-<?= $is_edit ? 'edit' : 'plus-circle' ?>"></i>
                    <?= $is_edit ? 'Edit' : 'New' ?> <?= htmlspecialchars($config['title']) ?> Record
                </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="masterForm" method="post" action="<?= htmlspecialchars($form_action) ?>" class="form-horizontal form-label-left" novalidate>
                    <input type="hidden" name="ci_csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

                    <?php foreach ($config['fields'] as $field):
                        $fieldName  = $field['name'];
                        $fieldLabel = $field['label'];
                        $fieldType  = $field['type'];
                        $required   = !empty($field['required']);
                        $options    = $field['options'] ?? [];

                        // Get current value (edit mode) or POST value (validation failure)
                        $value = '';
                        if ($is_edit && $record) {
                            $value = $record->$fieldName ?? '';
                        }
                    ?>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="<?= htmlspecialchars($fieldName) ?>">
                            <?= htmlspecialchars($fieldLabel) ?>
                            <?php if ($required): ?><span class="required">*</span><?php endif; ?>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <?php if ($fieldType === 'text'): ?>
                            <input type="text" id="<?= htmlspecialchars($fieldName) ?>" name="<?= htmlspecialchars($fieldName) ?>"
                                   class="form-control col-md-7 col-xs-12"
                                   value="<?= htmlspecialchars($value) ?>"
                                   <?= $required ? 'required="required"' : '' ?>
                                   placeholder="Enter <?= htmlspecialchars($fieldLabel) ?>">

                            <?php elseif ($fieldType === 'email'): ?>
                            <input type="email" id="<?= htmlspecialchars($fieldName) ?>" name="<?= htmlspecialchars($fieldName) ?>"
                                   class="form-control col-md-7 col-xs-12"
                                   value="<?= htmlspecialchars($value) ?>"
                                   <?= $required ? 'required="required"' : '' ?>
                                   placeholder="Enter <?= htmlspecialchars($fieldLabel) ?>">

                            <?php elseif ($fieldType === 'number'): ?>
                            <input type="number" id="<?= htmlspecialchars($fieldName) ?>" name="<?= htmlspecialchars($fieldName) ?>"
                                   class="form-control col-md-7 col-xs-12"
                                   value="<?= htmlspecialchars($value) ?>"
                                   <?= $required ? 'required="required"' : '' ?>
                                   step="any"
                                   placeholder="Enter <?= htmlspecialchars($fieldLabel) ?>">

                            <?php elseif ($fieldType === 'date'): ?>
                            <input type="text" id="<?= htmlspecialchars($fieldName) ?>" name="<?= htmlspecialchars($fieldName) ?>"
                                   class="form-control col-md-7 col-xs-12 datepicker"
                                   value="<?= htmlspecialchars($value) ?>"
                                   <?= $required ? 'required="required"' : '' ?>
                                   placeholder="dd/mm/yyyy" autocomplete="off">

                            <?php elseif ($fieldType === 'textarea'): ?>
                            <textarea id="<?= htmlspecialchars($fieldName) ?>" name="<?= htmlspecialchars($fieldName) ?>"
                                      class="form-control col-md-7 col-xs-12"
                                      rows="4"
                                      <?= $required ? 'required="required"' : '' ?>
                                      placeholder="Enter <?= htmlspecialchars($fieldLabel) ?>"><?= htmlspecialchars($value) ?></textarea>

                            <?php elseif ($fieldType === 'select'): ?>
                            <select id="<?= htmlspecialchars($fieldName) ?>" name="<?= htmlspecialchars($fieldName) ?>"
                                    class="form-control col-md-7 col-xs-12"
                                    <?= $required ? 'required="required"' : '' ?>>
                                <option value="">-- Select <?= htmlspecialchars($fieldLabel) ?> --</option>
                                <?php foreach ($options as $opt): ?>
                                <option value="<?= htmlspecialchars($opt) ?>" <?= ($value == $opt) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($opt) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>

                            <?php elseif ($fieldType === 'richtext'): ?>
                            <textarea id="<?= htmlspecialchars($fieldName) ?>" name="<?= htmlspecialchars($fieldName) ?>"
                                      class="form-control col-md-7 col-xs-12 richtext-editor"
                                      rows="8"
                                      <?= $required ? 'required="required"' : '' ?>
                                      placeholder="Enter <?= htmlspecialchars($fieldLabel) ?>"><?= htmlspecialchars($value) ?></textarea>

                            <?php endif; ?>
                        </div>
                    </div>

                    <?php endforeach; ?>

                    <div class="ln_solid"></div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <a href="<?= base_url('settings_master/' . htmlspecialchars($master_type)) ?>" class="btn btn-default">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success" id="btnSubmit">
                                <i class="fa fa-<?= $is_edit ? 'save' : 'plus' ?>"></i>
                                <?= $is_edit ? 'Update' : 'Save' ?>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // ── Datepicker ────────────────────────────────────────────────────────
    if ($.fn.datepicker) {
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });
    } else if ($.fn.daterangepicker) {
        $('.datepicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: { format: 'DD/MM/YYYY' },
            autoUpdateInput: false
        }).on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        }).on('cancel.daterangepicker', function() {
            $(this).val('');
        });
    }

    // ── WYSIWYG Editor for richtext fields ────────────────────────────────
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '.richtext-editor',
            height: 250,
            menubar: false,
            plugins: 'advlist autolink lists link charmap preview anchor searchreplace visualblocks code',
            toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | link | code',
            content_style: 'body { font-family: Arial, sans-serif; font-size: 13px; }'
        });
    } else if (typeof CKEDITOR !== 'undefined') {
        $('.richtext-editor').each(function() {
            CKEDITOR.replace(this.id, {
                height: 200,
                toolbar: [
                    { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
                    { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight'] },
                    { name: 'links', items: ['Link', 'Unlink'] },
                    { name: 'tools', items: ['Source'] }
                ]
            });
        });
    }

    // ── Client-side form validation ───────────────────────────────────────
    $('#masterForm').on('submit', function(e) {
        var isValid = true;
        var firstInvalid = null;

        // Sync richtext editors before validation
        if (typeof tinymce !== 'undefined') {
            tinymce.triggerSave();
        }
        if (typeof CKEDITOR !== 'undefined') {
            for (var instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
        }

        // Check required fields
        $(this).find('[required]').each(function() {
            var $el = $(this);
            var val = $el.val();
            if (!val || val.trim() === '') {
                isValid = false;
                $el.closest('.form-group').addClass('has-error');
                if (!firstInvalid) firstInvalid = $el;
            } else {
                $el.closest('.form-group').removeClass('has-error');
            }
        });

        if (!isValid) {
            e.preventDefault();
            if (firstInvalid) firstInvalid.focus();

            // Show error notification
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please fill in all required fields.',
                    confirmButtonColor: '#206570'
                });
            } else {
                alert('Please fill in all required fields.');
            }
            return false;
        }

        // Disable submit button to prevent double-submission
        $('#btnSubmit').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
    });

    // Remove error styling on input
    $(document).on('input change', '.has-error input, .has-error select, .has-error textarea', function() {
        $(this).closest('.form-group').removeClass('has-error');
    });
});
</script>
