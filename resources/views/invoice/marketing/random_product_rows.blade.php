@forelse($products as $index => $product)
<tr class="product-row">
    <td class="text-center">{{ $product->id }}</td>
    <td>
        <div class="d-flex align-items-center gap-2">
            <span>{{ $product->name }}</span>
            <i class="fas fa-edit text-primary edit-name-icon" 
               style="cursor: pointer; font-size: 14px;" 
               data-product-id="{{ $product->id }}"
               data-product-name="{{ $product->name }}"
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

<script>
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
    $(document).on('click', '.edit-name-icon', function() {
        const productId = $(this).data('product-id');
        const currentName = $(this).data('product-name');
        
        Swal.fire({
            title: '<div style="display: flex; align-items: center; justify-content: center; gap: 10px;"><div style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fas fa-edit" style="color: white; font-size: 22px;"></i></div></div><div style="margin-top: 15px; font-size: 24px; font-weight: 700; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Edit Product Name</div>',
            html: `
                <style>
                    .modern-edit-container {
                        padding: 10px 0;
                    }
                    .modern-input-group {
                        margin-bottom: 0;
                        text-align: left;
                    }
                    .modern-label {
                        display: block;
                        font-size: 13px;
                        font-weight: 600;
                        color: #4a5568;
                        margin-bottom: 8px;
                        letter-spacing: 0.3px;
                        text-transform: uppercase;
                    }
                    .modern-input {
                        width: 100%;
                        padding: 14px 16px;
                        border: 2px solid #e2e8f0;
                        border-radius: 12px;
                        font-size: 15px;
                        transition: all 0.3s ease;
                        background: white;
                        font-family: inherit;
                    }
                    .modern-input:focus {
                        outline: none;
                        border-color: #667eea;
                        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
                        transform: translateY(-1px);
                    }
                    .modern-input::placeholder {
                        color: #cbd5e0;
                    }
                    .input-icon {
                        position: relative;
                    }
                    .input-icon i {
                        position: absolute;
                        right: 16px;
                        top: 50%;
                        transform: translateY(-50%);
                        color: #a0aec0;
                        font-size: 16px;
                    }
                </style>
                <div class="modern-edit-container">
                    <div class="modern-input-group">
                        <label class="modern-label">
                            <i class="fas fa-sparkles me-1"></i> Product Name
                        </label>
                        <div class="input-icon">
                            <input type="text" id="swal-product-name" class="modern-input" value="${currentName}" autocomplete="off">
                            <i class="fas fa-pen"></i>
                        </div>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check me-2"></i>Update Name',
            cancelButtonText: '<i class="fas fa-times me-2"></i>Cancel',
            customClass: {
                popup: 'swal-modern-popup',
                title: 'swal-modern-title',
                htmlContainer: 'swal-modern-content',
                confirmButton: 'swal-modern-confirm',
                cancelButton: 'swal-modern-cancel',
                actions: 'swal-modern-actions'
            },
            width: '500px',
            padding: '30px',
            background: '#ffffff',
            backdrop: 'rgba(0, 0, 0, 0.6)',
            showClass: {
                popup: 'animate__animated animate__fadeInDown animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp animate__faster'
            },
            focusConfirm: false,
            didOpen: () => {
                const style = document.createElement('style');
                style.textContent = `
                    .swal-modern-popup {
                        border-radius: 20px !important;
                        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3) !important;
                    }
                    .swal-modern-title {
                        padding: 0 !important;
                        margin-bottom: 20px !important;
                    }
                    .swal-modern-content {
                        margin: 0 !important;
                        padding: 0 !important;
                    }
                    .swal-modern-actions {
                        margin-top: 30px !important;
                        gap: 12px !important;
                    }
                    .swal-modern-confirm {
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
                        border: none !important;
                        border-radius: 10px !important;
                        padding: 12px 30px !important;
                        font-weight: 600 !important;
                        font-size: 15px !important;
                        transition: all 0.3s ease !important;
                        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4) !important;
                    }
                    .swal-modern-confirm:hover {
                        transform: translateY(-2px) !important;
                        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6) !important;
                    }
                    .swal-modern-cancel {
                        background: #f7fafc !important;
                        color: #4a5568 !important;
                        border: 2px solid #e2e8f0 !important;
                        border-radius: 10px !important;
                        padding: 12px 30px !important;
                        font-weight: 600 !important;
                        font-size: 15px !important;
                        transition: all 0.3s ease !important;
                    }
                    .swal-modern-cancel:hover {
                        background: #edf2f7 !important;
                        border-color: #cbd5e0 !important;
                        transform: translateY(-1px) !important;
                    }
                    .swal2-validation-message {
                        background: #fff5f5 !important;
                        border: 2px solid #fc8181 !important;
                        color: #c53030 !important;
                        border-radius: 10px !important;
                        padding: 12px 16px !important;
                        margin-top: 15px !important;
                        font-weight: 500 !important;
                    }
                `;
                document.head.appendChild(style);
                
                const inputField = document.getElementById('swal-product-name');
                setTimeout(() => {
                    inputField.focus();
                    inputField.select();
                }, 100);
                
                inputField.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        Swal.clickConfirm();
                    }
                });
            },
            preConfirm: () => {
                const newName = document.getElementById('swal-product-name').value.trim();
                
                if (!newName) {
                    Swal.showValidationMessage('<i class="fas fa-exclamation-circle me-2"></i>Please enter a product name');
                    return false;
                }
                
                if (newName === currentName) {
                    Swal.showValidationMessage('<i class="fas fa-info-circle me-2"></i>New name must be different from current name');
                    return false;
                }
                
                return newName;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                randomizeProductUpdate(null, productId, null, result.value);
            }
        });
    });

    $(document).on('click', '.remove-product', function() {
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
                confirmButton: 'btn btn-sm btn-success',
                cancelButton: 'btn btn-sm btn-danger'
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