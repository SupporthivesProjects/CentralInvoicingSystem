@forelse($products as $index => $product)
<tr class="product-row">
    <td class="text-center" >{{ $product->id }}</td>
    <td>
        {{ $product->name }} 
        @if($site->site_link && $product->slug)
            <a href="{{ $site->site_link }}product/{{ $product->slug }}" target="_blank">🔗</a>
        @endif
    </td>
    <td class="text-center">
        <div class="input-group input-group-sm justify-content-center">
            <button class="btn btn-outline-primary wc-decrease" type="button" data-product-id="{{ $product->id }}" >-</button>
            <input type="text" readonly  class="form-control text-center wc-input"  data-product-id="{{ $product->id }}" value="{{ $product->default_wc }}" step="25" min="{{ $product->default_wc }}">
            <button class="btn btn-outline-primary wc-increase" type="button" data-product-id="{{ $product->id }}">+</button>
        </div>
    </td>


    <td class="text-center p-2">
        <select name="turnaround" id="turnaround" class="form-select form-select-sm text-center mx-0 turnaround-select" data-product-id="{{ $product->id }}">
            <option value="ta_standard">Standard</option>
            <option value="ta_express">Express</option>
        </select>
    </td>

    <td class="text-center">
        <div class="input-group input-group-sm justify-content-center">
            <button class="btn btn-outline-primary img-decrease" type="button" data-product-id="{{ $product->id }}">-</button>
            <input type="text" readonly class="form-control text-center img-input" value="1" step="1" min="1" data-product-id="{{ $product->id }}">
            <button class="btn btn-outline-primary img-increase" type="button" data-product-id="{{ $product->id }}">+</button>
        </div>
    </td>


    <td class="text-center p-2">
        <select name="quality" id="quality" class="form-select form-select-sm text-center mx-0 quality-select" data-product-id="{{ $product->id }}">
            <option value="q_standard">Standard </option>
            <option value="q_premium">Premium </option>
            <option value="q_expert">Expert</option>
        </select>
    </td>

    <td>
        <div class="input-group d-flex">
            <span class="input-group-text">{{ site_currency() }}</span>
            <input  style="display: none;"
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
        <button class="remove-product btn btn-danger btn-sm" data-product-name="{{ $product->name }}"  data-product-id="{{ $product->id }}">
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
