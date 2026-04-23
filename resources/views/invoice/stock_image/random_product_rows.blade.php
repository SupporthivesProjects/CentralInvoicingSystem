@forelse($products as $index => $product)
<tr class="product-row">
    <td class="text-center">
        <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" style="display: none;" checked>
        {{ $product->id }}
    </td>
    <td>
        {{ $product->name }}
        @if($site->site_link)
            <a href="{{ $site->site_link }}pricing-packs/" target="_blank">🔗</a>
        @endif
        <input type="hidden"
               form="generate-invoice-form"
               name="product_data[]"
               value="{{ json_encode(['product_id' => $product->id, 'name' => $product->name, 'price' => number_format($product->price, 2, '.', ''), 'credits' => $product->credits ?? 0]) }}">
    </td>
    <td>
        @if(($product->credits ?? 0) > 0)
            <span class="badge bg-success">{{ $product->credits }} Credits</span>
        @else
            <span class="badge bg-secondary">No Credits</span>
        @endif
    </td>
    <td class="text-center">
        {{ site_currency() }}{{ number_format($product->price, 2) }}
        <input type="hidden"
           class="product-unit-price"
           data-product-id="{{ $product->id }}"
           value="{{ number_format($product->price, 2, '.', '') }}">
    </td>
    <td class="text-center">
        <button class="remove-product btn btn-danger btn-sm"
                data-product-name="{{ $product->name }}"
                data-product-id="{{ $product->id }}"
                data-bs-toggle="tooltip"
                title="Remove Product">
            <i class="fa fa-trash"></i>
        </button>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="text-center text-muted py-3 border-top">
        No results found. Try randomizing or use a different keyword.
        <div class="mt-3">
            <button class="btn btn-primary btn-sm" id="add-custom-pack">
                <i class="fas fa-plus"></i> Add Custom Pack
            </button>
        </div>
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