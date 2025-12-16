@forelse($products as $index => $product)
<tr class="product-row">
    <td class="text-center">{{ $product->id }}</td>
    <td>
        <div class="d-flex align-items-center gap-2">
            <span>{{ $product->name }}</span>
            <i class="fas fa-edit text-primary" 
               style="cursor: pointer; font-size: 14px;" 
               onclick="openEditNameModal({{ $product->id }}, '{{ addslashes($product->name) }}')"
               data-bs-toggle="tooltip" 
               title="Edit Name"></i>
            @if($site->site_link && $product->slug)
                <a href="{{ $site->site_link }}{{ $product->slug }}" target="_blank">🔗</a>
            @endif
        </div>
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

<div class="modal fade" id="editProductNameModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h6 class="modal-title">Edit Product Name</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label class="form-label small mb-1">Current Name</label>
                    <input type="text" class="form-control form-control-sm" id="currentProductName" readonly>
                </div>
                <div class="mb-2">
                    <label class="form-label small mb-1">New Name</label>
                    <input type="text" class="form-control form-control-sm" id="newProductName" placeholder="Enter new name">
                </div>
                <input type="hidden" id="editProductId">
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="updateProductName()">
                    <i class="fas fa-check me-1"></i>Update
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function openEditNameModal(productId, currentName) {
    $('#currentProductName').val(currentName);
    $('#newProductName').val('');
    $('#editProductId').val(productId);
    $('#editProductNameModal').modal('show');
    setTimeout(() => $('#newProductName').focus(), 300);
}

function updateProductName() {
    const productId = $('#editProductId').val();
    const newName = $('#newProductName').val().trim();
    const currentName = $('#currentProductName').val();

    if (!newName) {
        toastr.error('Please enter a new name', 'Validation Error');
        return;
    }

    if (newName === currentName) {
        toastr.info('No changes made', 'Info');
        $('#editProductNameModal').modal('hide');
        return;
    }

    $('#editProductNameModal').modal('hide');
    randomizeProductUpdate(null, productId, null, newName);
}

$('#newProductName').on('keypress', function(e) {
    if (e.which === 13) {
        e.preventDefault();
        updateProductName();
    }
});

function randomizeProductUpdate(categoryID, productId, subscription, productName = null) {
    const iconId = productName !== null ? `name-icon-${productId}` : `dropdown-icon-${productId}`;
    const icon = document.getElementById(iconId);
    if (icon) {
        icon.className = 'fas fa-spinner fa-spin text-primary';
    }

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
                if (icon) {
                    icon.className = productName !== null ? 'fas fa-edit text-muted' : 'fas fa-sync-alt text-muted';
                }
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
                if (productName !== null) {
                    toastr.success('Product name updated successfully', 'Updated');
                }
                calculateTotalPrice();
            }
        },
        error: function(xhr) {
            if (icon) {
                icon.className = productName !== null ? 'fas fa-edit text-muted' : 'fas fa-sync-alt text-muted';
            }
            console.error(xhr.responseText);
            toastr.error('Something went wrong');
        }
    });
}

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


