@forelse($products as $index => $product)
<tr class="product-row">
    <td class="text-center">{{ $product->id }}</td>
    <td>
        <div class="input-group">

        @if($site->site_link && $product->slug)
            <a 
                href="{{ $site->site_link }}{{ $product->slug }}" 
                target="_blank" 
                class="input-group-text"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="View product page">
                🔗
            </a>
        @else
        <a 
            href="{{ $site->site_link }}" 
            target="_blank" 
            class="input-group-text"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
            title="View Website">
            🔗
            </a>
        @endif
        <input 
            type="text"  
            class="form-control product-name" 
            value="{{ $product->name }}" 
            data-product-id="{{ $product->id }}" 
            aria-label="name" 
            {{ $product->can_edit_price == 0 ? 'readonly' : '' }}>


        <span 
            class="input-group-text d-flex align-items-center"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
            title="{{ $product->can_edit_price == 0 ? 'Name update allowed after ' . $product->remaining_days . ' days.' : 'Editable' }}">
            @if($product->can_edit_price == 0)
                <i class="fas fa-lock text-muted"></i>
            @else
                <i class="fas fa-edit"></i>
            @endif
        </span>
    </div>

    </td>
    <td class="text-center">
        <div class="input-group d-flex justify-content-center">
            <span class="input-group-text"  data-bs-toggle="tooltip" title="{{ site_currency_code() }}">{{ site_currency() }}</span>
            <input type="number" 
                   class="form-control text-center product-rrp" 
                   step="0.01"
                   value="{{ number_format($product->rrp, 2, '.', '') }}"
                   data-reverse-rate="{{ $product->reverse_rate ?? 1 }}"
                   data-product-id="{{ $product->id }}"
                   data-variation_id="{{ $product->variation_id ?? 0 }}"
                   aria-label="RRP"
                   inputmode="numeric"
                   {{ $product->can_edit_price == 0 ? 'readonly' : '' }}>
            <span class="input-group-text d-flex align-items-center"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  title="{{ $product->can_edit_price == 0 ? 'Price update allowed after ' . $product->remaining_days . ' days.' : 'Editable' }}">
                  @if($product->can_edit_price == 0)
                        <i class="fas fa-lock text-muted"></i>
                    @else
                        <i class="fas fa-edit"></i>
                    @endif
            </span>
        </div>
    </td>

    <td class="text-center">
        <div class="input-group d-flex justify-content-center">
        <span class="input-group-text"><i class="fas fa-percent text-success"></i></span>
            <input type="number" 
                   class="form-control text-center text-success fw-bold product-discount" 
                   value="{{ number_format($product->discount, 0, '.', '') }}" 
                   data-product-id="{{ $product->id }}" 
                   aria-label="Discount"
                   inputmode="numeric"
                   {{ $product->can_edit_price == 0 ? 'readonly' : '' }}>
            <span class="input-group-text d-flex align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $product->can_edit_price == 0 ? 'Discount update allowed after ' . $product->remaining_days . ' days.' : 'Editable' }}">
                  @if($product->can_edit_price == 0)
                        <i class="fas fa-lock text-success text-muted"></i>
                    @else
                      <i class="fas fa-edit text-success"></i>
                    @endif
                 
            </span>
        </div>
    </td>

    <td class="text-center">
            {{ site_currency() }}<span class="unit-price-text">{{ number_format($product->unit_price, 2, '.', '') }}</span>
        <input type="hidden" class="form-control product-price text-center"  value="{{ number_format($product->unit_price, 2, '.', '') }}" data-product-id="{{ $product->id }}" readonly>
    </td>

    <td class="text-center">
        <button class="remove-product btn btn-danger btn-sm" data-product-name="{{ $product->name }}" data-product-id="{{ $product->id }}">
            <i class="fa fa-trash"></i>
        </button>
        <input style="display: none;"  class="form-check-input border narayan-checkbox border-1 border-primary"  type="checkbox" name="product_ids[]"  
            data-unit_price="{{ number_format($product->unit_price, 2, '.', '') }}"
            data-reverse-rate="{{ $product->reverse_rate ?? 1 }}"
            data-original-rrp="{{ number_format($product->rrp, 0, '.', '') }}"
            data-original-discount="{{ number_format($product->discount, 0, '.', '') }}"
            value="{{ $product->id }}" 
            checked>
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