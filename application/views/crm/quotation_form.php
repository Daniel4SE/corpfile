<!-- CRM Create Quotation Form -->
<div class="page-title">
    <div class="title_left">
        <h3>Create Quotation</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('crm_quotations') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Quotations</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title" style="background:#206570;border-radius:5px 5px 0 0;">
                <h2 style="color:#fff;"><i class="fa fa-file-text-o"></i> Quotation Details</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="POST" action="<?= base_url('crm_create_quotation') ?>" id="quotationForm">
                    <input type="hidden" name="ci_csrf_token" value="<?= $csrf_token ?? '' ?>">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Client <span class="required">*</span></label>
                                <select name="client_id" class="form-control select2_single" style="width:100%;" required>
                                    <option value="">Select Client</option>
                                    <?php if (!empty($clients)): foreach ($clients as $c): ?>
                                    <option value="<?= $c->id ?>"><?= htmlspecialchars($c->company_name) ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Quotation Date <span class="required">*</span></label>
                                <input type="date" name="quotation_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Validity Date</label>
                                <input type="date" name="validity_date" class="form-control" value="<?= date('Y-m-d', strtotime('+30 days')) ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Line Items -->
                    <h4 style="background:#f5f5f5;padding:10px 15px;border-left:3px solid #206570;margin:20px 0 15px 0;">
                        <i class="fa fa-list"></i> Line Items
                        <button type="button" class="btn btn-success btn-sm pull-right" id="addLineItem"><i class="fa fa-plus"></i> Add Item</button>
                    </h4>

                    <table class="table table-bordered" id="lineItemsTable">
                        <thead>
                            <tr style="background:#206570;color:#fff;">
                                <th style="width:5%;">#</th>
                                <th style="width:20%;">Item</th>
                                <th style="width:25%;">Description</th>
                                <th style="width:10%;">Qty</th>
                                <th style="width:15%;">Rate ($)</th>
                                <th style="width:15%;">Amount ($)</th>
                                <th style="width:10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="line-item" data-row="0">
                                <td>1</td>
                                <td><input type="text" name="item_name[]" class="form-control" placeholder="Item name" required></td>
                                <td><input type="text" name="item_description[]" class="form-control" placeholder="Description"></td>
                                <td><input type="number" name="item_qty[]" class="form-control item-qty" value="1" min="1" step="1"></td>
                                <td><input type="number" name="item_rate[]" class="form-control item-rate" value="0" min="0" step="0.01"></td>
                                <td><input type="number" name="item_amount[]" class="form-control item-amount" value="0" readonly></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-item"><i class="fa fa-minus"></i></button></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-right"><strong>Total:</strong></td>
                                <td><input type="number" name="total_amount" id="totalAmount" class="form-control" value="0" readonly style="font-weight:bold;"></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Notes</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Additional notes..."></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Terms & Conditions</label>
                                <textarea name="terms" class="form-control" rows="3" placeholder="Terms and conditions..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="text-center">
                        <a href="<?= base_url('crm_quotations') ?>" class="btn btn-default btn-lg">Cancel</a>
                        <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> Save Quotation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.select2) { $('.select2_single').select2({ allowClear: true }); }

    var rowIndex = 1;

    $('#addLineItem').click(function() {
        var newRow = '<tr class="line-item" data-row="' + rowIndex + '">' +
            '<td>' + (rowIndex + 1) + '</td>' +
            '<td><input type="text" name="item_name[]" class="form-control" placeholder="Item name" required></td>' +
            '<td><input type="text" name="item_description[]" class="form-control" placeholder="Description"></td>' +
            '<td><input type="number" name="item_qty[]" class="form-control item-qty" value="1" min="1" step="1"></td>' +
            '<td><input type="number" name="item_rate[]" class="form-control item-rate" value="0" min="0" step="0.01"></td>' +
            '<td><input type="number" name="item_amount[]" class="form-control item-amount" value="0" readonly></td>' +
            '<td><button type="button" class="btn btn-danger btn-sm remove-item"><i class="fa fa-minus"></i></button></td>' +
            '</tr>';
        $('#lineItemsTable tbody').append(newRow);
        rowIndex++;
    });

    $(document).on('click', '.remove-item', function() {
        if ($('.line-item').length > 1) {
            $(this).closest('tr').remove();
            recalculate();
        }
    });

    $(document).on('change keyup', '.item-qty, .item-rate', function() {
        var row = $(this).closest('tr');
        var qty = parseFloat(row.find('.item-qty').val()) || 0;
        var rate = parseFloat(row.find('.item-rate').val()) || 0;
        row.find('.item-amount').val((qty * rate).toFixed(2));
        recalculate();
    });

    function recalculate() {
        var total = 0;
        $('.item-amount').each(function() {
            total += parseFloat($(this).val()) || 0;
        });
        $('#totalAmount').val(total.toFixed(2));
    }
});
</script>
