@forelse($products as $index => $product)
<tr class="product-row">
    <td class="text-center">{{ $product->id }}</td>
    <td>
        <div class="input-group">
            <input 
                type="text" 
                class="form-control product-name-input" 
                value="{{ $product->name }}" 
                data-product-id="{{ $product->id }}"
                data-original-name="{{ $product->name }}"
            >
            <span class="input-group-text" style="cursor: pointer;">
                <i class="fas fa-edit text-muted" id="name-icon-{{ $product->id }}"></i>
            </span>
        </div>
        @if($site->site_link && $product->slug)
            <a href="{{ $site->site_link }}{{ $product->slug }}" target="_blank" class="small">🔗</a>
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

    <td class="text-center">{{ site_currency() }}{{ number_format($product->unit_price, 2) }}</td>
    <td>
        <div class="input-group d-flex">
            <span class="input-group-text" data-bs-toggle="tooltip" title="{{ site_currency_code() }}">{{ site_currency() }}</span>
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
        <button class="remove-product btn btn-danger btn-sm" data-product-name="{{ $product->name }}" data-product-id="{{ $product->id }}" data-bs-toggle="tooltip" title="Remove Product">
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
function randomizeProductUpdate(categoryID, productId, subscription, productName = null) {
    const iconId = productName !== null ? `name-icon-${productId}` : `dropdown-icon-${productId}`;
    const icon = document.getElementById(iconId);
    icon.className = 'fas fa-spinner fa-spin text-primary';

    const postData = {
        _token: '{{ csrf_token() }}',
        product_id: productId
    };

    if (productName !== null) {
        postData.product_name = productName;
    } else {
        postData.subscription = subscription;
        postData.category_id = categoryID;
    }

    $.ajax({
        url: "{{ route('update.product') }}",
        method: 'POST',
        data: postData,
        success: function(response) {
            if (response.error) {
                icon.className = productName !== null ? 'fas fa-edit text-muted' : 'fas fa-sync-alt text-muted';
                toastr.error(response.error, 'Update Error');
            } else {
                $('#randomize-product-table-body').html(response.tableRows);
                const newIcon = document.getElementById(iconId);
                if (newIcon) {
                    newIcon.className = 'fas fa-check text-success';
                    setTimeout(() => {
                        newIcon.className = productName !== null ? 'fas fa-edit text-muted' : 'fas fa-sync-alt text-muted';
                    }, 1000);
                }
                calculateTotalPrice();
            }
        },
        error: function(xhr) {
            icon.className = productName !== null ? 'fas fa-edit text-muted' : 'fas fa-sync-alt text-muted';
            console.error(xhr.responseText);
            toastr.error('Something went wrong');
        }
    });
}

$(document).ready(function() {
    $(document).off('blur change', '.product-name-input').on('blur change', '.product-name-input', function() {
        const $input = $(this);
        const productId = $input.data('product-id');
        const newName = $input.val().trim();
        const originalName = $input.data('original-name');
        
        if (newName && newName !== originalName) {
            randomizeProductUpdate(null, productId, null, newName);
        }
    });

    $(document).off('keypress', '.product-name-input').on('keypress', '.product-name-input', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $(this).blur();
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
                        $('.remove-product').prop('disabled', false);
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
                            $('.remove-product').prop('disabled', false);
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


