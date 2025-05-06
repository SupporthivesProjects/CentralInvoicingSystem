@forelse($products as $index => $product)
<tr class="product-row">
    <td class="text-center" >{{ $product->id }}</td>
    <td>
        {{ $product->name }} 
        @if($site->site_link && $product->slug)
            <a href="{{ $site->site_link }}/product/{{ $product->slug }}" target="_blank">🔗</a>
        @endif
    </td>
    <td>
        <div class="input-group">
                <select class="form-select fw-semibold"
                        name="subscription"
                        id="subscription-select-{{ $product->id }}"
                        onchange="randomizeProductUpdate({{ $product->category_id }}, {{ $product->id }}, this.value)">
                    @php
                        $options = ['1 Month', '3 Months', '6 Months', '12 Months'];
                    @endphp
                    @foreach($options as $option)
                        <option value="{{ $option }}" {{ $product->subscription == $option ? 'selected' : '' }}>
                            {{ $option }}
                        </option>
                    @endforeach
                </select>
                <span class="input-group-text" style="cursor: pointer;">
                    <i class="fas fa-sync-alt text-muted" id="dropdown-icon-{{ $product->id }}"></i>
                </span>
            </div>
        </td>


    <td  class="text-center">{{ site_currency() }}{{ number_format($product->unit_price, 2) }}</td>
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

 function randomizeProductUpdate(categoryID, productId, subscription) {

    const icon = document.getElementById(`dropdown-icon-${productId}`);
    icon.className = 'fas fa-spinner fa-spin text-primary';
    $.ajax({
        url: "{{ route('update.product') }}",
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            product_id: productId,
            subscription: subscription,
            category_id: categoryID
        },
        success: function(response) {
            if (response.error) {
                icon.className = 'fas fa-sync-alt text-muted';
                toastr.error(response.error, 'Update Error');
            } else {
                $('#randomize-product-table-body').html(response.tableRows);
                const newIcon = document.getElementById(`dropdown-icon-${productId}`);
                if (newIcon) {
                    newIcon.className = 'fas fa-check text-success';

                    setTimeout(() => {
                        newIcon.className = 'fas fa-sync-alt text-muted';
                    }, 1000);
                }
                calculateTotalPrice();
            }
        },
        error: function(xhr) {
            icon.className = 'fas fa-sync-alt text-muted';
            console.error(xhr.responseText);
            toastr.error('Something went wrong');
        }
    });
    }
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
                    confirmButton: 'btn btn-sm btn-danger',
                    cancelButton: 'btn btn-sm btn-secondary'
                },
                width: '350px',
                padding: '1em'
            }).then((result) => {
                if (result.isConfirmed) {
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
                            $button.html('<i class="fas fa-trash-alt"></i>');
                            $button.removeClass('btn-success').addClass('btn-danger');
                            calculateTotalPrice();
                            toastr.error('Error removing product. Please try again.');
                        }
                    });
                }
            });
        });
    });

</script>


