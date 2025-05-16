@forelse($products as $index => $product)
<tr class="product-row">
    <td class="text-center">{{ $product->id }}</td>
    {{-- <td>{{ $product->category_name }}</td> --}}
    <td>
        {{ $product->name }}
        @if($site->site_link && $product->slug)
            <a href="{{ $site->site_link }}product/{{ $product->slug }}" target="_blank">🔗</a>
        @endif
    </td>
    <td class="text-center">{{ site_currency() }}{{ number_format($product->unit_price, 2) }}</td>
    <td>
        <div class="input-group d-flex">
            <span class="input-group-text">{{ site_currency() }}</span>
            <input style="display: none;"
                class="form-check-input border narayan-checkbox border-1 border-primary"
                type="checkbox"
                name="product_ids[]"
                data-unit_price="{{ number_format($product->unit_price, 2, '.', '') }}"
                value="{{ $product->id }}" checked>
            <input
                type="text"
                class="form-control product-price text-center"
                value="{{ number_format($product->unit_price, 2, '.', '') }}"
                data-product-id="{{ $product->id }}"
                {{ $product->can_edit_price == 0 ? 'readonly' : '' }}
                aria-label="Amount (to the nearest dollar)"
            >
            <span class="input-group-text d-flex align-items-center">
                <i
                    class="{{ $product->can_edit_price == 0 ? 'fas fa-lock text-muted' : 'fas fa-edit' }}"
                    style="font-size: 12px;"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    title="{{
                        $product->can_edit_price == 0
                            ? 'Price update allowed after ' . $product->remaining_days . ' days.'
                            : 'Editable'
                    }}"
                ></i>
            </span>
        </div>
    </td>
    <td class="text-center">
        <input
            type="number"
            class="form-control product-pages text-center"
            value="{{ $product->pages }}"
            min="1"
            data-product-id="{{ $product->id }}"
            aria-label="Number of pages"
        >
    </td>
    <td class="text-center">
        {{ site_currency() }}{{ number_format($product->line_total, 2) }}
    </td>
    <td class="text-center">
        <button class="remove-product btn btn-danger btn-sm" data-product-name="{{ $product->name }}" data-product-id="{{ $product->id }}">
            <i class="fa fa-trash"></i>
        </button>
    </td>
</tr>
@empty
<tr>
    <td colspan="8" class="text-center text-muted py-3 border-top">
        No results found. Try randomizing or use a different invoice amount.
    </td>
</tr>
@endforelse
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    $(document).ready(function() {
        // Handle page number changes
        $(document).off('change', '.product-pages').on('change', '.product-pages', function() {
            var $input = $(this);
            var productId = $input.data('product-id');
            var pages = parseInt($input.val()) || 1;

            if (pages < 1) {
                pages = 1;
                $input.val(1);
            }

            // Update the line total
            var unitPrice = parseFloat($('input.product-price[data-product-id="' + productId + '"]').val());
            var lineTotal = pages * unitPrice;

            // Find the line total cell and update it
            var $row = $input.closest('tr');
            $row.find('td:eq(6)').text('{{ site_currency() }}' + lineTotal.toFixed(2));

            // Recalculate totals
            calculateTotalPrice();

            // Update the session data via AJAX
            $.ajax({
                url: "{{ route('update.product.pages') }}",
                method: 'POST',
                data: {
                    product_id: productId,
                    pages: pages,
                    site_id: "{{ session('customer.site_id') }}",
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Optional: show success message
                    toastr.success('Pages updated successfully');
                },
                error: function() {
                    toastr.error('Error updating pages. Please try again.');
                }
            });
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
                            toastr.success('Product has been removed successfully.','Product Removed');
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
