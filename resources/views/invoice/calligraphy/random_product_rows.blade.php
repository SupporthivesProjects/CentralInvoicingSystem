@forelse($products as $index => $product)
    <tr class="product-row">
        <td class="text-center">{{ $product->id }}</td>
        <td>
            {{ $product->name }}
            @if ($site->site_link && $product->slug)
                <a href="{{ $site->site_link }}product/{{ $product->slug }}" target="_blank">🔗</a>
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
                    data-product-id="{{ $product->id }}" {{ $product->can_edit_price == 0 ? 'readonly' : '' }}
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
                data-product-id="{{ $product->id }}">
                <option value="standard">Standard 5-7 days</option>
                <option value="urgent">Urgent 2-3 days (+35)</option>
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
    $(document).ready(function() {
        $(document).off('change', '.urgency-select').on('change', '.urgency-select', function() {
            var $select = $(this);
            var $row = $select.closest('tr.product-row');
            var urgencyValue = $select.val();

            var $checkbox = $row.find('input[name="product_ids[]"]');
            var originalUnitPrice = parseFloat($checkbox.data('unit_price'));

            var $editableInput = $row.find('.product-price');
            var $unitPriceCell = $row.find('td').eq(2);

            var urgencyFee = (urgencyValue === 'urgent') ? 35 : 0;
            var newUnitPrice = originalUnitPrice + urgencyFee;
            var newEditablePrice = originalUnitPrice + urgencyFee;

            var currencySymbol = @json(site_currency());
            $unitPriceCell.html(currencySymbol + number_format(newUnitPrice, 2));

            if (!$editableInput.prop('readonly')) {
                $editableInput.val(number_format(newEditablePrice, 2, '.', ''));
            }

            $row.data('urgency-fee', urgencyFee);

            if (typeof calculateTotalPrice === 'function') {
                calculateTotalPrice();
            }

            if (urgencyFee > 0) {
                $unitPriceCell.addClass('text-warning');
                $editableInput.addClass('border-warning');
                setTimeout(function() {
                    $unitPriceCell.removeClass('text-warning');
                    $editableInput.removeClass('border-warning');
                }, 2000);
            }
        });

        $(document).off('input', '.product-price').on('input', '.product-price', function() {
            if (typeof calculateTotalPrice === 'function') {
                calculateTotalPrice();
            }
        });
    });

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