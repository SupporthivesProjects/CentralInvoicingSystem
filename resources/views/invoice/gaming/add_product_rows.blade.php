@forelse($products as $index => $product)
    @php
        $captureFields = json_decode($product->game_need_to_capture ?? '{}', true);
    @endphp

    <tr class="align-middle product-row" id="customize-product-row-{{ $product->id }}">
        <td class="text-center">{{ $index + 1 }}</td>

        <td>
            {{ $product->name }}
            @if($site->site_link && $product->slug)
                <a href="{{ $site->site_link.'games/'.$product->slug }}" target="_blank" title="View Product"><i class="bi bi-box-arrow-up-right ms-1"></i></a>
            @endif
        </td>

        <td>{{ $product->game_currency ?? '-' }}</td>

        <td class="text-center">
            <div class="input-group">
                <span class="input-group-text">{{ $product->game_currency ?? '-' }}</span>
                <input type="text"
                    class="form-control add-currency-amount text-center"
                    value="0.00"
                    data-product-id="{{ $product->id }}"
                    readonly>
                <input type="hidden"
                    name="custom_products[{{ $product->id }}][bundle_first_amount]"
                    value="{{ $product->game_currency_amount ?? $product->bundle_first_amount ?? '0' }}">
                <input type="hidden"
                    name="custom_products[{{ $product->id }}][bundle_rate]"
                    value="{{ $product->bundle_rate ?? '' }}">
            </div>
        </td>

        <td>
            <div class="input-group">
                <span class="input-group-text" data-bs-toggle="tooltip" title="{{ site_currency_code() }}">{{ site_currency() }}</span>
                <input type="text"
                    class="form-control add-product-price text-center dynamic-input"
                    value="0.00"
                    data-product-id="{{ $product->id }}">
            </div>
        </td>

        <td class="text-center">
            <div class="form-check d-flex justify-content-center align-items-center m-0">
                <input class="form-check-input border border-primary narayan-checkbox"
                    type="checkbox"
                    name="add_product_ids[]"
                    value="{{ $product->id }}">
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center text-muted py-3">No products found. Please try a different keyword or randomize the list.</td>
    </tr>
@endforelse

<script>
    (function () {
        let originalAmount = parseFloat(@json(session('current_amount', 0)));

        function updateTempTotal() {
            let selectedTotal = 0;
            $('input[name="add_product_ids[]"]:checked').each(function () {
                let productId = $(this).val();
                let price = parseFloat($('.add-product-price[data-product-id="' + productId + '"]').val()) || 0;
                selectedTotal += price;
            });
            let tempTotal = originalAmount + selectedTotal;
            let invoiceAmount = parseFloat($('#invoice_amount').val()) || 0;
            syncAllAmountDisplays(tempTotal, invoiceAmount);
        }

        $(document).on('input change keyup', 'input[name="add_product_ids[]"], .add-product-price, #invoice_amount', function () {
            updateTempTotal();
        });

        $(document).on('blur', '.add-product-price', function () {
            let val = parseFloat($(this).val());
            if (!isNaN(val)) {
                $(this).val(val.toFixed(2));
            }
        });
    })();
</script>

<script>
    $(document).on('keyup change input', '.add-product-price', function () {
        const $priceInput = $(this);
        const productId   = $priceInput.data('product-id');

        if (!productId || $priceInput.prop('readonly')) return;

        const $hiddenAmountInput = $(`input[name="custom_products[${productId}][bundle_first_amount]"]`);
        const rawAmount          = $hiddenAmountInput.val().toString().trim();

        const lastChar    = rawAmount.slice(-1);
        const hasSuffix   = isNaN(lastChar);
        const modifiedStr = hasSuffix ? rawAmount.slice(0, -1) : rawAmount;
        const baseAmount  = parseFloat(modifiedStr) || 0;

        const unitPrice      = parseFloat($priceInput.val()) || 0;
        const currencyFactor = parseFloat(@json($currencyFactor ?? 1.0));
        const bundleRate     = parseFloat($(`input[name="custom_products[${productId}][bundle_rate]"]`).val()) || 0;

        const raw = unitPrice * bundleRate;

        function smartRound(value) {
            if (value >= 1_000_000) return Math.round(value / 1_000_000) * 1_000_000;
            if (value >= 100_000)   return Math.round(value / 100_000) * 100_000;
            if (value >= 10_000)    return Math.round(value / 10_000) * 10_000;
            if (value >= 1_000)     return Math.round(value / 1_000) * 1_000;
            if (value >= 100)       return Math.round(value / 100) * 100;
            return Math.round(value);
        }

        // WordPress
        const calculated = bundleRate > 0
            ? smartRound(raw)
            // Laravel
            : Math.floor(unitPrice * baseAmount * currencyFactor);

        const displayValue = hasSuffix ? calculated + lastChar : calculated.toString();

        $(`.add-currency-amount[data-product-id="${productId}"]`).val(displayValue);
    });
</script>

<script>
    $(document).ready(function () {
        $('#add-custom-products').off('click').on('click', function () {
            let selectedProducts = [];
            let hasValidData     = true;

            $('input[name="add_product_ids[]"]:checked').each(function () {
                let productId   = $(this).val();
                let $row        = $('#customize-product-row-' + productId);
                let $collapseRow = $('#product-collapse-row-' + productId);

                let unitPrice = parseFloat($row.find('.add-product-price:not([readonly])').val());

                if (isNaN(unitPrice) || unitPrice <= 0) {
                    toastr.error('Please enter a valid price for ' + $row.find('td:nth-child(2)').text().trim());
                    hasValidData = false;
                    return false;
                }

                let gameName       = $row.find('td:nth-child(2)').clone().children().remove().end().text().trim();
                let selectedPlatform = $collapseRow.find('.select-platform').val();
                let platformFields   = {};
                let missingFields    = false;

                if (selectedPlatform) {
                    $collapseRow.find(`.platform-section[data-platform="${selectedPlatform}"] input`).each(function () {
                        let fieldName  = $(this).attr('name');
                        let fieldValue = $(this).val();

                        if ($(this).prop('required') && (!fieldValue || fieldValue.trim() === '')) {
                            let fieldLabel = $(this).prev('label').text();
                            toastr.error(`Please enter ${fieldLabel} for ${gameName}`);
                            missingFields = true;
                            return false;
                        }

                        platformFields[fieldName] = fieldValue;
                    });

                    if (missingFields) {
                        hasValidData = false;
                        return false;
                    }
                }

                selectedProducts.push({
                    id:                   productId,
                    game_currency_amount: document.querySelector(`.add-currency-amount[data-product-id="${productId}"]`).value,
                    unit_price:           unitPrice,
                    bundle:               'custom'
                });
            });

            if (!hasValidData) return;

            if (selectedProducts.length > 0) {
                let btn = $('#add-custom-products');
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Adding to Cart...');
                $('#current_amount').val('Calculating...');
                $('#discount_amount').prop('type', 'text').val('Calculating...').prop('readonly', true);

                $.ajax({
                    url:  "{{ route('add.products') }}",
                    type: 'POST',
                    data: {
                        _token:        "{{ csrf_token() }}",
                        selected_games: selectedProducts,
                        site_id:       "{{ $site->id ?? '' }}"
                    },
                    success: function (response) {
                        $('input[name="products[]"]:checked').prop('disabled', true);

                        let invoiceAmount = parseFloat($('#invoice_amount').val()) || 0;

                        $('#addgames').modal('hide');
                        $('#discount_amount').prop('readonly', false).prop('type', 'number');
                        $('#product-table-body').html(response.tableRows);

                        syncAllAmountDisplays(response.total, invoiceAmount);
                        toastr.success('Products added successfully!');

                        if (!response.is_random) {
                            $('.narayan-checkbox').prop('disabled', false);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error adding products to cart:', error);
                        toastr.error('Failed to add products. Please try again.');
                    },
                    complete: function () {
                        btn.prop('disabled', false).html('<i class="bi bi-cart-plus me-1"></i> Add to list');
                    }
                });
            } else {
                toastr.error('Please select product(s) to add.');
            }
        });
    });
</script>

<script>
    function startVoiceSearch() {
        const inputField = document.getElementById('modalkeywordInput');
        inputField.placeholder = "Please speak product name or category";

        if (!('SpeechRecognition' in window || 'webkitSpeechRecognition' in window)) {
            toastr.error("Your browser does not support voice recognition. Please try using a modern browser like Chrome.");
            return;
        }

        inputField.value       = '';
        inputField.placeholder = "Listening to your voice search...";

        const recognition          = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.lang           = "en-US";
        recognition.interimResults = false;

        recognition.start();

        recognition.onresult = function (event) {
            const transcript = event.results[0][0].transcript;
            inputField.style.color = "blue";
            document.getElementById('modalkeywordInput').value = transcript;
            $('#modalkeywordInput').val(transcript).trigger('keyup');
        };

        recognition.onerror = function (event) {
            toastr.error("Voice recognition error: " + event.error);
            inputField.value       = '';
            inputField.style.color = '';
            inputField.placeholder = "Enter or Speak product or category name...";
        };

        recognition.onend = function () {
            inputField.style.color = 'blue';
            inputField.placeholder = "Enter or Speak product or category name...";
        };
    }
</script>

<script>
    function validateSelectedProducts() {
        return document.querySelectorAll('input[name="add_product_ids[]"]:checked').length > 0;
    }

    document.getElementById('add-custom-products')?.addEventListener('click', function (e) {
        if (!validateSelectedProducts()) {
            e.preventDefault();
        }
    });

    document.querySelectorAll('.product-row').forEach(row => {
        row.addEventListener('click', function (e) {
            if (e.target.closest('input, select, label')) {
                e.stopPropagation();
            }
        });
    });
</script>