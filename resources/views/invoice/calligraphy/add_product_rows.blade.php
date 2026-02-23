@forelse($products as $index => $product)
<tr id="customize-product-row-{{ $product->id }}">
    <td class="text-center" >{{ $product->id }}</td>
    <td>
       {{ $product->name }}
            @if ($site->site_link && $product->slug)
                <a href="{{ $site->site_link }}product/{{ $product->slug }}" target="_blank">🔗</a>
            @endif
            @if (!empty($product->personalization_label))
                <br><small class="text-muted" style="font-size:10px;">{{ $product->personalization_label }}</small>
            @endif
    </td>
    <td class="text-center">{{ site_currency() }}{{ number_format($product->unit_price, 2) }}</td>
    <td>
        <div class="input-group">
            <span class="input-group-text"  data-bs-toggle="tooltip" title="{{ site_currency_code() }}">{{ site_currency() }}</span>
            <input type="text" class="form-control add-product-price text-center"  value="{{ number_format($product->unit_price, 2, '.', '') }}"  data-product-id="{{ $product->id }}" {{ $product->can_edit_price == 0 ? 'readonly' : '' }}  aria-label="Amount (to the nearest dollar)">
            <span class="input-group-text d-flex align-items-center">
                <i  class="{{ $product->can_edit_price == 0 ? 'fas fa-lock text-muted' : 'fas fa-edit' }}" style="font-size: 12px;" data-bs-toggle="tooltip"  data-bs-placement="top"
                    title="{{ $product->can_edit_price == 0 ? 'Price update allowed after ' . $product->remaining_days . ' days.' : 'Editable' }}" ></i>
            </span>
        </div>
    </td>
    <td class="text-center align-middle">
        <div class="form-check d-flex justify-content-center align-items-center m-0">
            <input
                class="form-check-input border narayan-checkbox border-1 border-primary"
                type="checkbox"
                name="add_product_ids[]"
                data-unit_price="{{ $product->unit_price }}"
                value="{{ $product->id }}"
            >
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="text-center text-muted py-3 border-top">
        No results found. Try randomizing or use a different keyword.
    </td>
</tr>
@endforelse
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

</script>

<script>
    $(document).ready(function () {
    $('#add-custom-products').off('click').on('click', function () {
        let selectedProducts = [];

        $('input[name="add_product_ids[]"]:checked').each(function () {
            let productId = $(this).val();
            let unitPrice = parseFloat($('.add-product-price[data-product-id="' + productId + '"]').val()) || 0;

            selectedProducts.push({
                product_id: productId,
                unit_price: unitPrice
            });
        });

        if (selectedProducts.length > 0) {
            let btn = $('#add-custom-products');
            btn.prop('disabled', true);
            btn.html('<i class="fas fa-spinner fa-spin"></i> Adding to Cart...');
            $('#current_amount').val('Calculating...');
            $('#discount_amount').prop('type', 'text').val('Calculating...').prop('readonly', true);
            $('#current_amount').removeClass('text-danger text-success');
            $('#discount_amount').removeClass('text-danger text-success');
            $('#invoice_amount').removeClass('text-danger text-success');

            $.ajax({
                url: "{{ route('add.products') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    products: selectedProducts,
                    site_id : "{{ session('customer.site_id') }}",
                },
                success: function(response) {
                    selectedProducts.forEach(function (product) {
                        $('#customize-product-row-' + product.product_id).remove();
                    });

                    let discountAmount = 0;
                    let current_amount = response.total;
                    let invoiceAmount = parseFloat($('#invoice_amount').val()) || 0;
                    if (current_amount > invoiceAmount) {
                        discountAmount = current_amount - invoiceAmount;
                    }

                    $('#addmoreproducts').modal('hide');
                    $('#discount_amount').prop('readonly', false).prop('type', 'number')
                    $('#randomize-product-table-body').html(response.tableRows);
                    calculateTotalPrice();
                },
                error: function(xhr, status, error) {
                    console.error('Error adding products to cart:', error);
                },
                complete: function() {
                    btn.prop('disabled', false);
                    btn.html('Add Selected to Cart');
                }
            });
        } else {
            toastr.error('Please select product(s) to add.');
        }
    });
});

</script>
<script>

    function updateTempTotal() {
        let originalAmount = parseFloat(@json(session('current_amount', 0)));
        let selectedTotal = 0;

        $('input[name="add_product_ids[]"]:checked').each(function () {
            let productId = $(this).val();
            let priceInput = $('.add-product-price[data-product-id="' + productId + '"]');
            let price = parseFloat(priceInput.val()) || 0;
            selectedTotal += price;
        });

        let tempTotal = originalAmount + selectedTotal;
        let invoiceAmount = parseFloat($('#invoice_amount').val()) || 0;
        let discountAmount = 0;

        if (tempTotal > invoiceAmount) {
            discountAmount = tempTotal - invoiceAmount;
        }

        $('#temp_current_amount_text').text(tempTotal.toFixed(2));
        $('#temp_discount_amount_text').text(discountAmount.toFixed(2));
        $('#temp_invoice_amount_text').text(invoiceAmount.toFixed(2));
    }

    $(document).ready(function () {
        $(document).on('input change', 'input[name="add_product_ids[]"], .add-product-price, #invoice_amount', function () {
            updateTempTotal();
        });
    });
</script>
