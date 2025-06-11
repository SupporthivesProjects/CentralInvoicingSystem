@forelse($products as $index => $product)
<tr id="customize-product-row-{{ $product->id }}">
    <td class="text-center" >{{ $product->id }}</td>
    <td>
        {{ $product->name }}
        @if($site->site_link)
            <a href="{{ $site->site_link }}pricing-packs/" target="_blank">🔗</a>
        @endif
    </td>
    <td>
        {{-- Show credits --}}
        @if($product->credits > 0)
            <span class="badge bg-success">{{ $product->credits }} Credits</span>
        @else
            <span class="badge bg-secondary">No Credits</span>
        @endif
    </td>
    <td class="text-center">
        {{ site_currency() }}
        <input type="hidden"
               class="add-product-price form-control d-inline-block"
               data-product-id="{{ $product->id }}"
               value="{{ number_format($product->price, 2, '.', '') }}"
               step="0.01"
               min="0"
               style="width: 80px;">
               {{ number_format($product->price, 2, '.', '') }}
    </td>

    <td class="text-center align-middle">
        <div class="form-check d-flex justify-content-center align-items-center m-0">
            <input
                class="form-check-input border narayan-checkbox border-1 border-primary"
                type="radio"
                name="add_product_ids[]"
                data-product-id="{{ $product->id }}"
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


<script>
document.addEventListener("DOMContentLoaded", function () {
    // Select all radio buttons for product selection
    const productRadios = document.querySelectorAll('input[name="add_product_ids[]"]');

    productRadios.forEach(radio => {
        radio.addEventListener("change", function () {
            // When a radio is selected
            if (this.checked) {
                const productId = this.getAttribute("data-product-id");

                // Find the corresponding price input
                const priceInput = document.querySelector(`input.add-product-price[data-product-id="${productId}"]`);

                if (priceInput) {
                    const unitPrice = parseFloat(priceInput.value).toFixed(2);

                    // Update the Current Amount box with ONLY the unit price
                    const currentAmountElement = document.getElementById("modal_current_amount");
                    if (currentAmountElement) {
                        // Force set the value to only show unit price
                        currentAmountElement.textContent = `€${unitPrice}`;
                        currentAmountElement.innerHTML = `€${unitPrice}`;

                        // Also check if there's a value attribute and update it
                        if (currentAmountElement.hasAttribute('value')) {
                            currentAmountElement.setAttribute('value', unitPrice);
                        }
                    }

                    // If there's a hidden input for current amount, update it too
                    const hiddenCurrentAmount = document.querySelector('input[name="current_amount"], #current_amount_input');
                    if (hiddenCurrentAmount) {
                        hiddenCurrentAmount.value = unitPrice;
                    }
                }
            }
        });
    });

    // Also trigger the change event for any pre-selected radio button on page load
    const checkedRadio = document.querySelector('input[name="add_product_ids[]"]:checked');
    if (checkedRadio) {
        checkedRadio.dispatchEvent(new Event('change'));
    }
});
</script>
