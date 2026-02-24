@forelse($products as $index => $product)
    @php
        //dd($product);
        $languages = site_languages();
    @endphp
    <tr class="product-row">
        <td class="text-center">{{ $product->id }}</td>
        <td>
            {{ $product->name }}
            @if (!empty($product->product_url))
                <a href="{{ $product->product_url }}" target="_blank" title="View Product">🔗</a>
            @endif
            <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][id]"
                value="{{ $product->id }}">
            <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][name]"
                value="{{ $product->name }}">
        </td>
        <td>
            <select form="generate-invoice-form" class="form-select from-language-dropdown"
                name="products[{{ $product->id }}][from_language]">
                <option value="">From Language</option>
                @foreach ($languages as $lang)
                    <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select form="generate-invoice-form" class="form-select to-language-dropdown"
                name="products[{{ $product->id }}][to_language]">
                <option value="">To Language</option>
                @foreach ($languages as $lang)
                    <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
        <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][display_unit_price]"
        value="{{ number_format($product->unit_price, 2) }}">
            <div class="input-group d-flex">
                <span class="input-group-text"  data-bs-toggle="tooltip" title="{{ site_currency_code() }}">{{ site_currency() }}</span>
                <input form="generate-invoice-form" style="display: none;"
                    class="form-check-input border narayan-checkbox border-1 border-primary" type="checkbox"
                    name="products[{{ $product->id }}][selected]"
                    data-unit_price="{{ number_format($product->unit_price, 2, '.', '') }}" value="1" checked>
                <input form="generate-invoice-form" type="text" class="form-control product-price text-center"
                    name="products[{{ $product->id }}][price]"
                    value="{{ number_format($product->unit_price, 2, '.', '') }}"
                    data-product-id="{{ $product->id }}" {{ $product->can_edit_price == 0 ? 'readonly' : '' }} />

                <span class="input-group-text d-flex align-items-center">
                    <i class="{{ $product->can_edit_price == 0 ? 'fas fa-lock text-muted' : 'fas fa-edit' }}"
                        style="font-size: 12px;" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="{{ $product->can_edit_price == 0
                            ? 'Price update allowed after ' . $product->remaining_days . ' days.'
                            : 'Editable' }}"></i>
                </span>
            </div>
            <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][can_edit_price]"
                value="{{ $product->can_edit_price }}">
        </td>
        <td class="text-center">
            <div class="input-group">
                <input 
                    form="generate-invoice-form" 
                    type="number" 
                    class="form-control product-pages text-center"
                    name="products[{{ $product->id }}][pages]" 
                    value="{{ $product->pages }}" 
                    min="1"
                    data-product-id="{{ $product->id }}" data-unit-type="{{ $product->unit_type ?? 'pages' }}"
                    aria-label="Number of pages or words" 
                />
                <span class="input-group-text">
                    {{ $product->unit_type ?? 'pages' }}
                </span>
            </div>
        </td>
       
        <td class="text-center">
            <input form="generate-invoice-form" class="form-check-input urgency-checkbox border-primary" type="checkbox"
                name="products[{{ $product->id }}][is_urgent]" value="1" data-product-id="{{ $product->id }}"
                data-urgent_amount="{{ number_format($product->urgent_amount ?? 99.75, 2, '.', '') }}"
                {{ isset($product->is_urgent) && $product->is_urgent ? 'checked' : '' }} />
            <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][urgent_amount]"
                value="{{ number_format($product->urgent_amount ?? 99.75, 2, '.', '') }}">
        </td>
        <td class="text-center line-total" data-product-id="{{ $product->id }}">
            {{ site_currency() }}{{ number_format($product->line_total, 2) }}
            <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][line_total]"
                value="{{ $product->line_total }}">
        </td>
        <td class="text-center">
            <button type="button" class="remove-product btn btn-danger btn-sm"
                data-product-name="{{ $product->name }}" data-product-id="{{ $product->id }}">
                <i class="fa fa-trash"></i>
            </button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="10" class="text-center text-muted py-3 border-top">
            No results found. Try randomizing or use a different invoice amount.
        </td>
    </tr>
@endforelse
<script>
    const siteCurrency = @json(site_currency()); // Make currency available to JS
</script>

<script>
    function bindUrgencyCheckbox() {
    $('.urgency-checkbox').off('change').on('change', function() {
        var $checkbox = $(this);
        var productId = $checkbox.data('product-id');
        var urgentAmount = parseFloat($checkbox.data('urgent_amount')) || 0;

        var $row = $checkbox.closest('tr');
        var pages = parseInt($row.find('.product-pages').val()) || 1;
        var unitPrice = parseFloat($row.find('.product-price').val()) || 0;
        var lineTotal = pages * unitPrice;

        if ($checkbox.is(':checked')) {
            lineTotal += urgentAmount;
        }

        // Get line total cell
        var $lineTotal = $row.find('.line-total');

        // Update the visible text
        $lineTotal.text(siteCurrency + lineTotal.toFixed(2));

        // Update or create the hidden input for this line total
        var $hiddenInput = $lineTotal.find('input[type="hidden"]');
        if ($hiddenInput.length === 0) {
            // Create the hidden input if it doesn't exist
            $hiddenInput = $('<input>')
                .attr('type', 'hidden')
                .attr('form', 'generate-invoice-form')
                .attr('name', 'products[' + productId + '][line_total]');
            $lineTotal.append($hiddenInput);
        }

        // Update the value
        $hiddenInput.val(lineTotal.toFixed(2));

        // ✅ Recalculate total price
        calculateTotalPrice();
        ensureHiddenInputs();
    });
}
    var $row = $checkbox.closest('tr');
    var pages = parseInt($row.find('.product-pages').val()) || 1;
    var unitPrice = parseFloat($row.find('.product-price').val()) || 0;
    var lineTotal = pages * unitPrice;

    if ($checkbox.is(':checked')) {
        lineTotal += urgentAmount;
    }

    // Get line total cell
    var $lineTotal = $row.find('.line-total');

    // Update the visible text
    $lineTotal.text(siteCurrency + lineTotal.toFixed(2));

    // Update or create the hidden input for this line total
    var $hiddenInput = $lineTotal.find('input[type="hidden"]');
    if ($hiddenInput.length === 0) {
        // Create the hidden input if it doesn't exist
        $hiddenInput = $('<input>')
            .attr('type', 'hidden')
            .attr('form', 'generate-invoice-form')
            .attr('name', 'products[' + productId + '][line_total]');
        $lineTotal.append($hiddenInput);
    }

    // Update the value
    $hiddenInput.val(lineTotal.toFixed(2));

    // ✅ Recalculate total price
    calculateTotalPrice();
    //ensureHiddenInputs();
</script>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    $(document).ready(function() {
        $(document).off('keyup change', '.product-price').on('keyup change', '.product-price', function() {
        var productId = $(this).data('product-id');
        updateLineTotal(productId);
        calculateTotalPrice(); // Make sure to recalculate the total price
    });
        // Pages change handler
        $(document).off('change', '.product-pages').on('change', '.product-pages', function() {
            var $input = $(this);
            var productId = $input.data('product-id');
            var unitType = $input.data('unit-type'); 
            var pages = parseInt($input.val()) || 1;

            if (pages < 1) {
                pages = 1;
                $input.val(1);
            }

            updateLineTotal(productId);
            toastr.info(`Updating ${unitType}...`);
            // ✅ AJAX update
            $.ajax({
                url: "{{ route('update.product') }}",
                method: 'POST',
                data: {
                    product_id: productId,
                    pages: pages,
                    site_id: "{{ session('customer.site_id') }}",
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    toastr.success(`${unitType} updated successfully`);
                    $('#randomize-product-table-body').html(response.tableRows);

                    // After updating the DOM, ensure all hidden inputs are present
                    ensureHiddenInputs();

                    bindUrgencyCheckbox(); // <== Rebind after DOM update

                    // After table is updated, recalculate all line totals & ensure hidden inputs
                    $('#randomize-product-table-body tr').each(function() {
                        var $row = $(this);
                        var productId = $row.find('.product-pages').data(
                            'product-id');
                        updateLineTotal(
                        productId); // This handles urgent checkbox and appends hidden input
                    });

                    setTimeout(() => {
                        calculateTotalPrice
                            (); // <== recalculate after table refresh
                    }, 100);
                },
                error: function() {
                    toastr.error('Error updating pages. Please try again.');
                }
            });
        });

        // Initial binding of urgency checkbox
        bindUrgencyCheckbox();

        // Function to calculate and update line total
        function updateLineTotal(productId) {
            var $priceInput = $('input.product-price[data-product-id="' + productId + '"]');
            var $pagesInput = $('input.product-pages[data-product-id="' + productId + '"]');
            var $urgencyCheckbox = $('.urgency-checkbox[data-product-id="' + productId + '"]');
            var $totalCell = $('.line-total[data-product-id="' + productId + '"]');

            var unitPrice = parseFloat($priceInput.val()) || 0;
            var pages = parseInt($pagesInput.val()) || 1;
            var urgentAmount = 0;

            if ($urgencyCheckbox.length && $urgencyCheckbox.is(':checked')) {
                urgentAmount = parseFloat($urgencyCheckbox.data('urgent_amount')) || 0;
            }

            var lineTotal = (unitPrice * pages) + urgentAmount;

            // Update the visible text
            $totalCell.text(siteCurrency + lineTotal.toFixed(2));

            // Update or create the hidden input
            var $hiddenInput = $totalCell.find('input[type="hidden"]');
            if ($hiddenInput.length === 0) {
                // Create the hidden input if it doesn't exist
                $hiddenInput = $('<input>')
                    .attr('type', 'hidden')
                    .attr('form', 'generate-invoice-form')
                    .attr('name', 'products[' + productId + '][line_total]');
                $totalCell.append($hiddenInput);
            }

            // Set the value
            $hiddenInput.val(lineTotal.toFixed(2));
        }

        // Call this function on page load to ensure all inputs exist initially
        ensureHiddenInputs();
    });





    $(document).off('click', '.remove-product').on('click', '.remove-product', function() {
        var $button = $(this);
        var productId = $button.data('product-id');
        var productName = $button.data('product-name');

        Swal.fire({
            title: 'Remove Product?',
            text: `Are you sure you want to remove '${productName}' product?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Remove',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'p-2 text-sm',
                title: 'text-base',
                confirmButtonClass: 'btn btn-sm btn-success',
                cancelButtonClass: 'btn btn-sm btn-danger'
            },
            width: '350px',
            padding: '1em'
        }).then((result) => {
            if (result.isConfirmed) {
                $('.remove-product').prop('disabled', true);
                $button.html('<i class="fas fa-spinner fa-spin"></i>');
                $('#current_amount').val('Recalculating...');
                $('#discount_amount').prop('type', 'text').val('Recalculating...').prop('readonly',
                    true);
                $('#current_amount').removeClass('text-danger text-success');
                $('#discount_amount').removeClass('text-danger text-success');
                $('#invoice_amount').removeClass('text-danger text-success');

                $.ajax({
                    url: "{{ route('remove.product') }}",
                    method: 'POST',
                    data: {
                        product_id: productId,
                        site_id: "{{ session('customer.site_id') }}",
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $button.html('<i class="fas fa-check-square"></i>');
                        $button.removeClass('btn-danger').addClass('btn-success');
                        $('#randomize-product-table-body').html(response.tableRows);
                        toastr.success('Product has been removed successfully.',
                            'Product Removed');
                        $('#discount_amount').prop('readonly', false).prop('type',
                            'number');
                        calculateTotalPrice();

                        setTimeout(() => {
                            $button.html('<i class="fas fa-trash-alt"></i>');
                            $button.removeClass('btn-success').addClass(
                                'btn-danger');
                        }, 2000);
                    },
                    error: function() {
                        $('.remove-product').prop('disabled', false);
                        $button.html('<i class="fas fa-trash-alt"></i>');
                        $button.removeClass('btn-success').addClass('btn-danger');
                        calculateTotalPrice();
                        toastr.error('Error removing product. Please try again.');
                    },
                    complete: function() {
                        $('.remove-product').prop('disabled', false);
                        setTimeout(() => {
                            $button.html('<i class="fas fa-trash-alt"></i>');
                            $button.removeClass('btn-success').addClass(
                                'btn-danger');
                        }, 1000);
                    }
                });
            }
        });
    });
</script>
