@forelse($products as $index => $product)
<tr class="product-row">
    <td class="text-center" >{{ $product->id }}</td>
    <td>#{{ $product->category_name }}</td>
    <td>
        {{ $product->name }} 
        @if($site->site_link && $product->slug)
            <a href="{{ $site->site_link }}/product/{{ $product->slug }}" target="_blank">🔗</a>
        @endif
    </td>
    <td>{{ $currency->symbol }}{{ number_format($product->unit_price, 2) }}</td>
    <td>
        <div class="input-group d-flex">
            <span class="input-group-text">{{ $currency->symbol }}</span>
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
                            : 'You can update the price.'
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
                title: 'text-base font-weight-bold',
                confirmButtonClass: 'btn btn-sm btn-danger',
                cancelButtonClass: 'btn btn-sm btn-secondary'
            },
            width: '350px',
            padding: '1em'
        }).then((result) => {
            if (result.isConfirmed) {
                $button.html('<i class="fas fa-spinner fa-spin"></i>'); 
                $('#current_amount').val('Recalculating...');
                $('#discount_amount').prop('type', 'text').val('Recalculating...').prop('readonly', true);
        
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
                        calculateTotalPrice(); 

                        setTimeout(() => {
                            $button.html('<i class="fas fa-trash-alt"></i>'); 
                            $button.removeClass('btn-success').addClass('btn-danger');
                        }, 2000);
                    },
                    error: function(xhr, status, error) {
                        $button.html('<i class="fas fa-trash-alt"></i>');
                        $button.removeClass('btn-success').addClass('btn-danger');
                        calculateTotalPrice();
                        toastr.error('Error removing product. Please try again.'); 
                    }
                });
            } else {
                console.log('Product removal canceled.');
            }
        });
    });
});



$(document).on('input', '.product-price', function() {
    calculateTotalPrice();
});

function calculateTotalPrice() {
    let currentAmount = 0;
    $('input[name="product_ids[]"]:checked').each(function() {
        const productId = $(this).val();
        const punitPrice = parseFloat($(`input[data-product-id="${productId}"]`).val()) || 0;
        currentAmount += punitPrice;
    });

    const invoiceAmount = parseFloat($('#invoice_amount').val()) || 0;
    let discountAmount = 0;

    if (currentAmount > invoiceAmount) {
        discountAmount = currentAmount - invoiceAmount;
    }
    $('#discount_amount').prop('readonly', false).prop('type', 'number') 
    $('#current_amount').val(currentAmount.toFixed(2));
    $('#temp_current_amount_text').text(currentAmount.toFixed(2));
    $('#discount_amount').val(discountAmount.toFixed(2));
    $('#temp_discount_amount_text').text(discountAmount.toFixed(2));
    $('#invoice_amount').val(invoiceAmount.toFixed(2));
    $('#temp_invoice_amount_text').text(invoiceAmount.toFixed(2));
}


</script>
