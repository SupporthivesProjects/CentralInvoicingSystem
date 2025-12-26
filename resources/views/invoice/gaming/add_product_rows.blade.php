@forelse($products as $index => $product)
    @php
        $captureFields = json_decode($product->game_need_to_capture ?? '{}', true);
    @endphp

    {{-- Main Row --}}
    <tr class="align-middle product-row" id="customize-product-row-{{ $product->id }}">
        <!-- 1️⃣ SR. NO. -->
        <td class="text-center">{{ $index + 1 }}</td>

        <!-- 2️⃣ GAME NAME -->
        <td>
            {{ $product->name }}
            @if($site->site_link && $product->slug)
                <a href="{{ $site->site_link }}games" target="_blank" title="View Product">🔗</a>
            @endif
        </td>

        <!-- 3️⃣ GAME CURRENCY -->
        <td>{{ $product->game_currency }}</td>

        <!-- 4️⃣ GAME CURRENCY AMOUNT -->
        <td class="text-center">
            <div class="input-group">
                <span class="input-group-text">{{ $product->game_currency }}</span>
                <input type="text" class="form-control add-currency-amount text-center" value="0.00" data-product-id="{{ $product->id }}" readonly>
                <input type="hidden" name="custom_products[{{ $product->id }}][bundle_first_amount]" value="{{ $product->bundle_first_amount }}">
            </div>
        </td>

        <!-- 5️⃣ UNIT PRICE -->
        <td>
            <div class="input-group">
                <span class="input-group-text"  data-bs-toggle="tooltip" title="{{ site_currency_code() }}">{{ site_currency() }}</span>
                <input type="text" class="form-control add-product-price text-center dynamic-input" value="0.00" data-product-id="{{ $product->id }}">
            </div>
        </td>

        <!-- 6️⃣ SELECT -->
        <td class="text-center">
            <div class="form-check d-flex justify-content-center align-items-center m-0">
                <input class="form-check-input border border-primary narayan-checkbox" type="checkbox" name="add_product_ids[]" value="{{ $product->id }}">
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center text-muted py-3">No products found. Please try a different keyword or randomize the list.</td>
    </tr>
@endforelse


<script>


    $(document).ready(function () {
        let originalAmount = parseFloat(@json(session('current_amount', 0)));

        function updateTempTotal() {
            let selectedTotal = 0;

            $('input[name="add_product_ids[]"]:checked').each(function () {
                let productId = $(this).val();
                let priceInput = $('.add-product-price[data-product-id="' + productId + '"]');
                let price = parseFloat(priceInput.val()) || 0;
                //alert("Before : " + selectedTotal);
                selectedTotal += price;
                //alert("After : " + selectedTotal);
            });

            //alert(originalAmount);

            let tempTotal = originalAmount + selectedTotal;
            //alert("Temp Total : " + tempTotal);
            let invoiceAmount = parseFloat($('#invoice_amount').val()) || 0;
            let discountAmount = 0;

            if (tempTotal > invoiceAmount) {
                discountAmount = tempTotal - invoiceAmount;
            }

            $('#temp_current_amount_text').text(tempTotal.toFixed(2));
            $('#temp_discount_amount_text').text(discountAmount.toFixed(2));
            $('#temp_invoice_amount_text').text(invoiceAmount.toFixed(2));
        }

        $(document).on('input change keyup', 'input[name="add_product_ids[]"], .add-product-price, #invoice_amount', function () {
            updateTempTotal();
        });
    });
</script>
<script>
    $(document).on('keyup change', '.add-product-price', function () {
        const $priceInput = $(this);
        const productId = $priceInput.data('product-id');

        if (!productId) return;

        // Skip read-only input
        if ($priceInput.prop('readonly')) return;

        // Get the hidden bundle_first_amount
        const $hiddenAmountInput = $(`input[name="custom_products[${productId}][bundle_first_amount]"]`);
        //alert($hiddenAmountInput.val());
        let rawAmount = $hiddenAmountInput.val().toString().trim();

        // Normalize value
        let numericAmount = parseFloat(rawAmount.replace(/[^0-9.]/g, '')) || 0;

        // Handle Lakh/Million suffix
        if (/l$/i.test(rawAmount)) {
            numericAmount *= 100000;
        } else if (/mill/i.test(rawAmount)) {
            numericAmount *= 1000000;
        }

        // Get current unit price
        const unitPrice = parseFloat($priceInput.val()) || 0;

        // Final amount rounded to nearest whole number
        const totalAmount = Math.round(numericAmount * unitPrice);

        // Find the corresponding read-only currency input
        const $currencyInput = $(`input[data-product-id="${productId}"]`).filter(function () {
            return $(this).prop('readonly');
        });

        $currencyInput.val(totalAmount+'0'); // No decimals
    });
</script>




<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });


    function closeFilters() {
        let originalAmount = parseFloat(@json(session('current_amount', 0)));
        let invoiceAmount = parseFloat($('#invoice_amount').val()) || 0;
        $('input[name="add_product_ids[]"]').prop('checked', false);
        $('.add-product-price').val('');
        $('#keywordInput').val('');
        let discountAmount = 0;

        if (originalAmount > invoiceAmount) {
            discountAmount = originalAmount - invoiceAmount;
        }

        $('#temp_current_amount_text').text(originalAmount.toFixed(2));
        $('#temp_discount_amount_text').text(discountAmount.toFixed(2));
        $('#temp_invoice_amount_text').text(invoiceAmount.toFixed(2));
    }

    function clearFilters() {
        let originalAmount = parseFloat(@json(session('current_amount', 0)));
        let invoiceAmount = parseFloat($('#invoice_amount').val()) || 0;

        $('input[name="add_product_ids[]"]').prop('checked', false);
        $('.add-product-price').val('');
        $('#manual_keyword').val('');
        $('#customize-product-table-body').html(getErrorRowHTML('No results found. Try randomizing or use a different keyword.'));
        let discountAmount = 0;


        if (originalAmount > invoiceAmount) {
            discountAmount = originalAmount - invoiceAmount;
        }

        $('#temp_current_amount_text').text(originalAmount.toFixed(2));
        $('#temp_discount_amount_text').text(discountAmount.toFixed(2));
        $('#temp_invoice_amount_text').text(invoiceAmount.toFixed(2));

        toastr.info('Filters have been reset.');
    }

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
        let hasValidData = true;

        $('input[name="add_product_ids[]"]:checked').each(function () {
            let productId = $(this).val();
            let $row = $('#customize-product-row-' + productId);
            let $collapseRow = $('#product-collapse-row-' + productId);

            // Get unit price (editable field)
            let unitPrice = parseFloat($row.find('.add-product-price:not([readonly])').val());


            // Validate unit price
            if (isNaN(unitPrice) || unitPrice <= 0) {
                toastr.error('Please enter a valid price for ' + $row.find('td:nth-child(2)').text().trim());
                hasValidData = false;
                return false; // break the loop
            }

            // Get game currency amount - convert from readonly field
            let bundleFirstAmount = parseFloat($row.find('input[name$="[bundle_first_amount]"]').val()) || 0;
            // Calculate currency amount based on unit price and any other logic if needed
            let currencyAmount = (bundleFirstAmount*unitPrice)+'0';

            // Get game name and currency
            let gameName = $row.find('td:nth-child(2)').clone().children().remove().end().text().trim();
            let gameCurrency = $row.find('td:nth-child(3)').text().trim();

            // Get selected platform
            let selectedPlatform = $collapseRow.find('.select-platform').val();

            // Check if platform is required and selected
            let platformRequired = $collapseRow.find('.platform-section').length > 0;
            // if (platformRequired && (!selectedPlatform || selectedPlatform === '')) {
            //     toastr.error('Please select a platform for ' + gameName);
            //     hasValidData = false;
            //     return false; // break the loop
            // }

            // Get all capture fields for the selected platform
            let platformFields = {};
            let missingFields = false;

            if (selectedPlatform) {
                $collapseRow.find(`.platform-section[data-platform="${selectedPlatform}"] input`).each(function() {
                    let fieldName = $(this).attr('name');
                    let fieldValue = $(this).val();

                    if ($(this).prop('required') && (!fieldValue || fieldValue.trim() === '')) {
                        let fieldLabel = $(this).prev('label').text();
                        toastr.error(`Please enter ${fieldLabel} for ${gameName}`);
                        missingFields = true;
                        return false; // break this loop
                    }

                    platformFields[fieldName] = fieldValue;
                });

                if (missingFields) {
                    hasValidData = false;
                    return false; // break the outer loop
                }
            }

            // Get all dynamic fields (platform + capture)
            let userInputFields = {
                selected_platform: selectedPlatform,
                platform_fields: platformFields
            };

            // Create game object
            selectedProducts.push({
                id: productId,
                game_currency_amount: document.querySelector(`.add-currency-amount[data-product-id="${productId}"]`).value,
                unit_price: unitPrice,
                bundle: 'custom'
            });
        });

        // If validation failed, stop here
        if (!hasValidData) {
            return;
        }

        if (selectedProducts.length > 0) {
            let btn = $('#add-custom-products');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Adding to Cart...');
            $('#current_amount').val('Calculating...');
            $('#discount_amount').prop('type', 'text').val('Calculating...').prop('readonly', true);

            $.ajax({
                url: "{{ route('add.products') }}", // This should be defined globally or via data attributes
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}", // Laravel CSRF token
                    selected_games: selectedProducts,
                    site_id: "{{ $site->id ?? '' }}" // Ensure site ID is passed from the backend
                },
                success: function(response) {
                    // Uncheck selected products in modal
                    $('input[name="products[]"]:checked').prop('disabled', true);

                    let discountAmount = 0;
                    let current_amount = response.total;
                    let invoiceAmount = parseFloat($('#invoice_amount').val()) || 0;

                    if (current_amount > invoiceAmount) {
                        discountAmount = current_amount - invoiceAmount;
                    }

                    $('#addgames').modal('hide');
                    $('#discount_amount').prop('readonly', false).prop('type', 'number');
                    $('#product-table-body').html(response.tableRows);
                    $('#current_amount').val(current_amount.toFixed(2));
                    $('#temp_current_amount_text').text(current_amount.toFixed(2));
                    $('#discount_amount').val(discountAmount.toFixed(2));
                    $('#temp_discount_amount_text').text(discountAmount.toFixed(2));
                    $('#invoice_amount').val(invoiceAmount.toFixed(2));

                    // Show success message
                    toastr.success('Products added successfully!');

                    // Update checkboxes in main table
                    if (!response.is_random) {
                        $('.narayan-checkbox').prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error adding products to cart:', error);
                    toastr.error('Failed to add products. Please try again.');
                },
                complete: function() {
                    btn.prop('disabled', false).html('Add Selected to Cart');
                }
            });
        } else {
            toastr.error('Please select product(s) to add.');
        }
    });

    // Helper function to update the read-only game currency amount field based on unit price
    $('.add-product-price:not([readonly])').on('input', function() {
        let productId = $(this).data('product-id');
        let unitPrice = parseFloat($(this).val()) || 0;
        let $row = $('#customize-product-row-' + productId);

        // Here you can implement any calculation logic needed
        // For example, if there's a conversion rate or formula
        let bundleFirstAmount = parseFloat($row.find('input[name$="[bundle_first_amount]"]').val()) || 0;
        let calculatedAmount = bundleFirstAmount; // Apply any conversion if needed

        // Update the read-only field
        $row.find('.add-product-price[readonly]').val(calculatedAmount.toFixed(2));
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

    inputField.value = '';
    inputField.placeholder = "Listening to your voice search...";

    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.lang = "en-US";
    recognition.interimResults = false;

    recognition.start();

    recognition.onresult = function(event) {
        const transcript = event.results[0][0].transcript;
        inputField.style.color = "blue";
        document.getElementById('modalkeywordInput').value = transcript;
        $('#modalkeywordInput').val(transcript).trigger('keyup');
    };

    recognition.onerror = function(event) {
        toastr.error("Voice recognition error: " + event.error);
        inputField.value = '';
        inputField.style.color = '';
        inputField.placeholder = "Enter or Speak product or category name...";
    };

    recognition.onend = function() {
        inputField.style.color = 'blue';
        inputField.placeholder = "Enter or Speak product or category name...";
    };
 }
</script>
<script>
    // Checkbox Validation Function
    function validateSelectedProducts() {
        const selected = document.querySelectorAll('input[name="add_product_ids[]"]:checked');
        if (selected.length === 0) {
            return false;
        }
        return true;
    }

    // Example: Hook to a button (replace #your-submit-button with your actual button ID)
    document.getElementById('add-custom-products')?.addEventListener('click', function(e) {
        if (!validateSelectedProducts()) {
            e.preventDefault();
        }
    });

    // Optional: Prevent row click toggles (since we removed collapse)
    document.querySelectorAll('.product-row').forEach(row => {
        row.addEventListener('click', function(e) {
            if (e.target.closest('input, select, label')) {
                e.stopPropagation();
            }
        });
    });
    </script>
