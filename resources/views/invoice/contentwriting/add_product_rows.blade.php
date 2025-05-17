@forelse($products as $index => $product)
<tr  class="product-row align-middle" id="customize-product-row-{{ $product->id }}" data-product-row-id="{{ $product->id }}" data-request-type="customize">
    <td class="text-center align-middle">
    <button class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="You can set parameters after adding the product to the cart." >
        <i class="bi bi-exclamation-circle-fill"></i>
    </button>

    </td>

    <td class="text-capitalize">
        {{ $product->name }} 
        @if($site->site_link && $product->slug)
            <a href="{{ $site->site_link }}product/{{ $product->slug }}" target="_blank">🔗</a>
        @endif
    </td>

    <td class="text-center">
        <div class="input-group input-group-sm justify-content-center">
            <button class="btn btn-outline-primary wc-decrease" type="button" data-product-id="{{ $product->id }}" >-</button>
            <input type="text" readonly  class="form-control text-center wc-input border-primary"  data-product-id="{{ $product->id }}" value="{{ $product->default_wc }}" step="25" min="{{ $product->default_wc }}">
            <button class="btn btn-outline-primary wc-increase" type="button" data-product-id="{{ $product->id }}">+</button>
        </div>
    </td>


    <td class="text-center p-2">
        <select name="turnaround" id="turnaround" class="form-select form-select-sm text-center mx-0 turnaround-select input-or-select" data-product-id="{{ $product->id }}">
            <option value="ta_standard" @selected($product->turnaround == 'ta_standard')>Standard</option>
            <option value="ta_express" @selected($product->turnaround == 'ta_express')>Express</option>
        </select>
    </td>

    <td class="text-center">
        <div class="input-group input-group-sm justify-content-center">
            <button class="btn btn-outline-primary img-decrease" type="button" data-product-id="{{ $product->id }}">-</button>
            <input type="text" readonly class="form-control text-center img-input border-primary" value="1" step="1" min="1" data-product-id="{{ $product->id }}">
            <button class="btn btn-outline-primary img-increase" type="button" data-product-id="{{ $product->id }}">+</button>
        </div>
    </td>


    <td class="text-center p-2">
        <select name="quality" id="quality" class="form-select form-select-sm text-center mx-0 quality-select input-or-select" data-product-id="{{ $product->id }}">
            <option value="q_standard" @selected($product->quality == 'q_standard')>Standard</option>
            <option value="q_premium" @selected($product->quality == 'q_premium')>Premium</option>
            <option value="q_expert" @selected($product->quality == 'q_expert')>Expert</option>
        </select>
    </td>


    <td>
        <div class="input-group">
            <span class="input-group-text">{{ site_currency() }}</span>
            <input type="text" class="form-control add-product-price text-center"  value="{{ number_format($product->unit_price, 2, '.', '') }}"  data-product-id="{{ $product->id }}" {{ $product->can_edit_price == 0 ? 'readonly' : '' }}>
            <span class="input-group-text d-flex align-items-center">
                <i  class="{{ $product->can_edit_price == 0 ? 'fas fa-lock text-muted' : 'fas fa-edit' }}"  style="font-size: 12px;" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="{{ $product->can_edit_price == 0 ? 'Price update allowed after ' . $product->remaining_days . ' days.' : 'Editable' }}" >
                </i>
            </span>
        </div>
    </td>

    <td class="text-center align-middle">
        <div class="form-check d-flex justify-content-center align-items-center m-0">
            <input class="form-check-input border narayan-checkbox border-1 border-primary" type="checkbox"  name="add_product_ids[]" data-unit_price="{{ number_format($product->unit_price, 2, '.', '') }}" value="{{ $product->id }}">
        </div>    
    </td>
</tr>

@empty
<tr>
    <td colspan="8" class="text-center text-muted py-3 border-top">
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
        let originalAmount = parseFloat(@json(session('current_amount', 0)));

        function updateTempTotal() {
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

        $(document).on('input change', 'input[name="add_product_ids[]"], .add-product-price, #invoice_amount', function () {
            updateTempTotal();
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#add-custom-products').off('click').on('click', function () {
            let selectedProducts = [];

            $('input[name="add_product_ids[]"]:checked').each(function () {
                let productId = $(this).val();

                let unitPrice = parseFloat($('.add-product-price[data-product-id="' + productId + '"]').val()) || 0;
                let wordCount = parseInt($('.wc-input[data-product-id="' + productId + '"]').val()) || 0;
                let quality = $('.quality-select[data-product-id="' + productId + '"]').val() || '';
                let turnaround = $('.turnaround-select[data-product-id="' + productId + '"]').val() || '';
                let imageCount = parseInt($('.img-input[data-product-id="' + productId + '"]').val()) || 0;

                selectedProducts.push({
                    product_id: productId,
                    unit_price: unitPrice,
                    word_count: wordCount,
                    quality: quality,
                    turnaround: turnaround,
                    image_count: imageCount
                });
            });

            if (selectedProducts.length > 0) {
                let btn = $('#add-custom-products');
                btn.prop('disabled', true);
                btn.html('<i class="fas fa-spinner fa-spin"></i> Adding to Cart...');
                $('#current_amount').val('Calculating...');
                $('#discount_amount').prop('type', 'text').val('Calculating...').prop('readonly', true);
                $('#current_amount, #discount_amount, #invoice_amount').removeClass('text-danger text-success');

                $.ajax({
                    url: "{{ route('add.products') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        products: selectedProducts,
                        site_id: "{{ session('customer.site_id') }}"
                    },
                    success: function (response) {
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
                        $('#discount_amount').prop('readonly', false).prop('type', 'number');
                        $('#randomize-product-table-body').html(response.tableRows);
                        calculateTotalPrice();
                    },
                    error: function (xhr, status, error) {
                        console.error('Error adding products to cart:', error);
                    },
                    complete: function () {
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
    $(document).ready(function() {
        const wcStep = 25;
        const imgStep = 1;
        const wcMin = 0;
        const imgMin = 1;

        function updateProduct(productId) {
            const wc = parseInt($(.wc-input[data-product-id="${productId}"]).val()) || wcMin;
            const turnaround = $(.turnaround-select[data-product-id="${productId}"]).val() || 'ta_standard';
            const imgCount = parseInt($(.img-input[data-product-id="${productId}"]).val()) || imgMin;
            const quality = $(.quality-select[data-product-id="${productId}"]).val() || 'q_standard';

            $.ajax({
                url: "{{ route('update.product') }}",
                method: 'POST',
                data: {
                    product_id: productId,
                    wordcount: wc,
                    turnaround: turnaround,
                    imagecount: imgCount,
                    quality: quality,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message || 'Product updated successfully');
                    } else {
                        toastr.error(response.message || 'Failed to update product');
                    }
                },
                error: function() {
                    toastr.error('An error occurred. Please try again.');
                }
            });
        }

        $('.wc-decrease').click(function() {
            const productId = $(this).data('product-id');
            const $input = $(.wc-input[data-product-id="${productId}"]);
            let val = parseInt($input.val()) || wcMin;
            const min = parseInt($input.attr('min')) || wcMin;

            if (val - wcStep >= min) {
                $input.val(val - wcStep);
                updateProduct(productId);
            } else {
                toastr.warning(Minimum word count is ${min}, 'Limit reached');
            }
        });

        $('.wc-increase').click(function() {
            const productId = $(this).data('product-id');
            const $input = $(.wc-input[data-product-id="${productId}"]);
            let val = parseInt($input.val()) || wcMin;

            $input.val(val + wcStep);
            updateProduct(productId);
        });

        $('.img-decrease').click(function() {
            const productId = $(this).data('product-id');
            const $input = $(.img-input[data-product-id="${productId}"]);
            let val = parseInt($input.val()) || imgMin;
            const min = parseInt($input.attr('min')) || imgMin;

            if (val - imgStep >= min) {
                $input.val(val - imgStep);
                updateProduct(productId);
            } else {
                toastr.warning(Minimum image count is ${min}, 'Limit reached');
            }
        });

        $('.img-increase').click(function() {
            const productId = $(this).data('product-id');
            const $input = $(.img-input[data-product-id="${productId}"]);
            let val = parseInt($input.val()) || imgMin;

            $input.val(val + imgStep);
            updateProduct(productId);
        });

        $('.turnaround-select').change(function() {
            const productId = $(this).data('product-id');
            updateProduct(productId);
        });

        $('.quality-select').change(function() {
            const productId = $(this).data('product-id');
            updateProduct(productId);
        });
    });
</script>