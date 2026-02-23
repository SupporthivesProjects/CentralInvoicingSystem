@forelse($products as $index => $product)
    <tr class="product-row">
        <td class="text-center">{{ $product->id }}</td>
        <td>
            {{ $product->name }}
            @if ($site->site_link && $product->slug)
                <a href="{{ $site->site_link }}product/{{ $product->slug }}" target="_blank">🔗</a>
            @endif
            @if (!empty($product->all_personalization_options) && $product->all_personalization_options->count() > 0)
                <br>
                <select class="form-select form-select-sm mt-1 personalization-option-select"
                    data-product-id="{{ $product->id }}"
                    style="font-size:11px; max-width:100%;">
                    @foreach($product->all_personalization_options as $opt)
                        <option value="{{ $opt->id }}"
                            data-price="{{ number_format($opt->price, 2, '.', '') }}"
                            {{ $opt->id == $product->personalization_option_id ? 'selected' : '' }}>
                            {{ $opt->label }} — {{ site_currency() }}{{ number_format($opt->price, 2) }}
                        </option>
                    @endforeach
                </select>
            @elseif(!empty($product->personalization_label))
                <br><small class="text-muted" style="font-size:11px;">{{ $product->personalization_label }}</small>
            @endif
        </td>
        <td class="text-center">{{ site_currency() }}{{ number_format($product->unit_price, 2) }}</td>
        <td>
            <div class="input-group d-flex">
                <span class="input-group-text" data-bs-toggle="tooltip"
                    title="{{ site_currency_code() }}">{{ site_currency() }}</span>
                <input style="display: none;" class="form-check-input border narayan-checkbox border-1 border-primary"
                    type="checkbox" name="product_ids[]"
                    data-unit_price="{{ number_format($product->unit_price, 2, '.', '') }}" value="{{ $product->id }}"
                    checked>
                <input type="text" class="form-control product-price text-center"
                    value="{{ number_format($product->unit_price, 2, '.', '') }}"
                    data-product-id="{{ $product->id }}"
                    data-option-id="{{ $product->personalization_option_id ?? '' }}"
                    {{ $product->can_edit_price == 0 ? 'readonly' : '' }}
                    aria-label="Amount (to the nearest dollar)">
                <span class="input-group-text d-flex align-items-center">
                    <i class="{{ $product->can_edit_price == 0 ? 'fas fa-lock text-muted' : 'fas fa-edit' }}"
                        style="font-size: 12px;" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="{{ $product->can_edit_price == 0
                            ? 'Price update allowed after ' . $product->remaining_days . ' days.'
                            : 'Editable' }}"></i>
                </span>
            </div>
        </td>

        <td class="text-center">
            <select class="form-select form-select-sm urgency-select" aria-label="Urgency"
                data-product-id="{{ $product->id }}"
                data-base-price="{{ number_format($product->unit_price, 2, '.', '') }}"
                data-auto-urgent="{{ isset($auto_urgent) && $auto_urgent ? 'true' : 'false' }}">
                <option value="standard" {{ !isset($auto_urgent) || !$auto_urgent ? 'selected' : '' }}>Standard 5-7 days</option>
                <option value="urgent" {{ isset($auto_urgent) && $auto_urgent ? 'selected' : '' }}>Urgent 2-3 days (+{{ site_currency() }}{{ $urgency_fee }})</option>
            </select>
        </td>

        <td class="text-center">
            <button class="remove-product btn btn-danger btn-sm" data-product-name="{{ $product->name }}"
                data-product-id="{{ $product->id }}" data-bs-toggle="tooltip" title="Remove Product">
                <i class="fa fa-trash"></i>
            </button>
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
    $(document).ready(function() {

        $(document).off('change', '.personalization-option-select').on('change', '.personalization-option-select', function() {
            var $select = $(this);
            var selectedOption = $select.find('option:selected');
            var newPrice = parseFloat(selectedOption.data('price'));
            var newOptionId = selectedOption.val();

            var $row = $select.closest('tr.product-row');
            var $priceInput = $row.find('.product-price');
            var $unitPriceCell = $row.find('td').eq(2);
            var $urgencySelect = $row.find('.urgency-select');
            var currencySymbol = @json(site_currency());

            $urgencySelect.data('base-price', newPrice.toFixed(2));
            $urgencySelect.val('standard');
            $row.data('urgency-fee', 0);

            $unitPriceCell.html(currencySymbol + number_format(newPrice, 2));

            $priceInput.val(newPrice.toFixed(2));
            $priceInput.data('urgency-price', newPrice);
            $priceInput.data('option-id', newOptionId);

            if (typeof calculateTotalPrice === 'function') {
                calculateTotalPrice();
            }
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
                    $('#discount_amount').prop('type', 'text').val('Recalculating...').prop('readonly', true);
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
                            toastr.success('Product has been removed successfully.', 'Product Removed');
                            $('#discount_amount').prop('readonly', false).prop('type', 'number');
                            $('#randomize-product-table-body .urgency-select').each(function() {
                                if ($(this).data('auto-urgent') === 'true' && $(this).val() === 'urgent') {
                                    applyUrgency($(this), 'urgent');
                                }
                            });
                            calculateTotalPrice();

                            setTimeout(() => {
                                $button.html('<i class="fas fa-trash-alt"></i>');
                                $button.removeClass('btn-success').addClass('btn-danger');
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
                                $button.removeClass('btn-success').addClass('btn-danger');
                            }, 1000);
                        }
                    });
                }
            });
        });
    });
</script>

<script>
    function applyUrgency($select, urgencyValue) {
        var $row = $select.closest('tr.product-row');
        var originalUnitPrice = parseFloat($select.data('base-price'));
        var urgencyFee = (urgencyValue === 'urgent') ? {{ $urgency_fee ?? 35 }} : 0;
        var newPrice = originalUnitPrice + urgencyFee;

        var $unitPriceCell = $row.find('td').eq(2);
        var $editableInput = $row.find('.product-price');
        var currencySymbol = @json(site_currency());

        $unitPriceCell.html(currencySymbol + number_format(newPrice, 2));
        $row.data('urgency-fee', urgencyFee);
        $editableInput.data('urgency-price', newPrice);
        $editableInput.val(number_format(newPrice, 2, '.', ''));

        if (urgencyFee > 0) {
            $unitPriceCell.addClass('text-warning');
            $editableInput.addClass('border-warning');
            setTimeout(function() {
                $unitPriceCell.removeClass('text-warning');
                $editableInput.removeClass('border-warning');
            }, 2000);
        }
    }

    $(document).off('change', '.urgency-select').on('change', '.urgency-select', function() {
        var urgencyValue = $(this).val();
        applyUrgency($(this), urgencyValue);
        if (typeof calculateTotalPrice === 'function') {
            calculateTotalPrice();
        }
    });

    $(document).off('input', '.product-price').on('input', '.product-price', function() {
        var $input = $(this);
        var $row = $input.closest('tr.product-row');
        var $select = $row.find('.urgency-select');
        var urgencyFee = parseFloat($row.data('urgency-fee')) || 0;
        var currentPrice = parseFloat($input.val()) || 0;
        var originalPrice = currentPrice - urgencyFee;
        $select.data('base-price', number_format(originalPrice, 2, '.', ''));

        if (typeof calculateTotalPrice === 'function') {
            calculateTotalPrice();
        }
    });

    $('.urgency-select').each(function() {
        var autoUrgent = $(this).data('auto-urgent');
        if (autoUrgent === 'true') {
            applyUrgency($(this), 'urgent');
        }
    });

    if (typeof calculateTotalPrice === 'function') {
        calculateTotalPrice();
    }

    function number_format(number, decimals = 2, dec_point = '.', thousands_sep = ',') {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }
</script>