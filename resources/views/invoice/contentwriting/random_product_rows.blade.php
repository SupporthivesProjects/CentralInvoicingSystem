@forelse($products as $index => $product)
<tr class="product-row align-middle" data-product-row-id="{{ $product->id }}" data-request-type="randomize">
   {{--  <td class="text-center align-middle">
        @if($product->param_status)
            <button id="param-btn-{{ $product->id }}" onclick="getProductParams({{ $product->id }}, this)" data-product-name="{{ $product->name }}" data-product-id="{{ $product->id }}" class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Metadata set, click to view"><i class="bi bi-check-circle-fill"></i></button>
        @else
            <button id="param-btn-{{ $product->id }}" onclick="getProductParams({{ $product->id }}, this)" data-product-name="{{ $product->name }}" data-product-id="{{ $product->id }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Metadata missing, click to add"><i class="bi bi-exclamation-circle-fill"></i></button>
        @endif
    </td> --}}
    <td class="text-center align-middle">
        {{ $product->id }}
    </td>
    <td class="text-capitalize">
        {{ $product->name }}
        @if($site->site_link && $product->slug)
            <a href="{{ $site->site_link }}product/{{ $product->slug }}" target="_blank">🔗</a>
        @endif
    </td>
    <td class="text-center" style="padding-left: 10px;padding-right: 10px;">
        <div class="input-group input-group-sm justify-content-center">
            <button class="btn btn-outline-secondary wc-decrease-100" type="button" data-product-id="{{ $product->id }}" data-bs-toggle="tooltip" title="Decrease by 100">«</button>
            <button class="btn btn-outline-primary wc-decrease-25" type="button" data-product-id="{{ $product->id }}" data-bs-toggle="tooltip" title="Decrease by 25">-</button>
            
            <input type="text" readonly class="form-control text-center wc-input border-primary" data-product-id="{{ $product->id }}" value="{{ $product->wordcount }}" step="25" min="{{ $product->default_wc }}">
            
            <button class="btn btn-outline-primary wc-increase-25" type="button" data-product-id="{{ $product->id }}" data-bs-toggle="tooltip" title="Increase by 25">+</button>
            <button class="btn btn-outline-secondary wc-increase-100" type="button" data-product-id="{{ $product->id }}" data-bs-toggle="tooltip" title="Increase by 100">»</button>
        </div>

    </td>
    <td class="text-center p-2">
        <select name="turnaround" class="form-select form-select-sm text-center mx-0 turnaround-select input-or-select " data-product-id="{{ $product->id }}">
            <option value="ta_standard" @selected($product->turnaround == 'ta_standard')>Standard</option>
            <option value="ta_express" @selected($product->turnaround == 'ta_express')>Express</option>
        </select>
    </td>
    <td class="text-center"  style="padding-left: 10px;padding-right: 10px;">
        <div class="input-group input-group-sm justify-content-center">
            <button class="btn btn-outline-primary img-decrease" type="button" data-product-id="{{ $product->id }}">-</button>
            <input type="text" readonly class="form-control text-center img-input border-primary" value="{{ $product->imagecount }}" step="1" min="1" data-product-id="{{ $product->id }}">
            <button class="btn btn-outline-primary img-increase" type="button" data-product-id="{{ $product->id }}">+</button>
        </div>
    </td>
    <td class="text-center p-2">
    <select name="quality" class="form-select form-select-sm text-center mx-0 quality-select input-or-select" data-product-id="{{ $product->id }}">
        <option value="q_standard" @selected($product->quality == 'q_standard')>Standard</option>
        <option value="q_premium" @selected($product->quality == 'q_premium')>Premium</option>
        <option value="q_expert" @selected($product->quality == 'q_expert')>Expert</option>
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
                data-product-id="{{ $product->id }}" readonly >
                <span class="input-group-text d-flex align-items-center"  data-bs-toggle="tooltip" 
                    data-bs-placement="top" 
                    title="Auto calculated Total Price">
                    <i  class="fas fa-lock text-muted"  style="font-size: 12px;"></i>
                </span>
        </div>
    </td>
   
    <td class="text-center">
        <div class="d-flex justify-content-center gap-1">
            <button class="randomize-product btn btn-outline-secondary btn-sm" data-product-id="{{ $product->id }}" data-bs-toggle="tooltip" title="Randomize">
                <i class="fa fa-random"></i>
            </button>
            <button class="remove-product btn btn-outline-danger btn-sm" data-product-name="{{ $product->name }}" data-product-id="{{ $product->id }}" data-bs-toggle="tooltip" title="Remove">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    </td>

</tr>
@empty
<tr>
    <td colspan="9" class="text-center text-muted py-3 border-top">
        No results found. Try randomizing or use a different keyword.
    </td>
</tr>
@endforelse



<script>
    $(document).off('click', '.randomize-product').on('click', '.randomize-product', function () {
        const $button = $(this);
        const productId = $button.data('product-id');
        $button.prop('disabled', true);
        $button.html('<i class="fas fa-spinner fa-spin"></i>');
        $('[data-bs-toggle="tooltip"]').tooltip('hide');

        $.ajax({
            url: "{{ route('random.product') }}",
            method: "POST",
            data: {
                product_id: productId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#randomize-product-table-body').html(response.tableRows);
                calculateTotalPrice();
            },
            error: function() {
                toastr.error('Something went wrong. Please try again.');
                calculateTotalPrice();
            },
            complete: function() {
                toastr.success('Randomize product completed.');
                $button.html('<i class="fa fa-random"></i>');
                initTooltips();
                calculateTotalPrice();
            }
            
        });
    });

</script>
<script>
    function getProductParams(productId, element) {
        const productName = $(element).data('product-name') || `Product #${productId}`;
        $('#productTitle').text(productName);

        const myModal = new bootstrap.Modal(document.getElementById('productParamsModal'));
        myModal.show();

        $('#productParamsForm')[0].reset();
        $('#productParamsLoader').show();
        $('#productParamsForm').css('display', 'none');
        $('#productParamsFooter').css('display', 'noe');

        $.ajax({
            url: "{{ route('get.product') }}",
            type: 'GET',
            data: { product_id: productId },
            success: function(response) {
                if (response.success) {
                    let product = response.product;
                    $('input[name="product_id"]').val(product.id);
                    $('input[name="project_title"]').val(product.project_title || '');
                    $('input[name="reference_link"]').val(product.reference_link || '');
                    $('input[name="subject"]').val(product.subject || '');
                    $('select[name="preferred_voice"]').val(product.preferred_voice || '');
                    $('select[name="preferred_writing_style"]').val(product.preferred_writing_style || '');
                    $('input[name="brand_name"]').val(product.brand_name || '');
                    $('select[name="audience"]').val(product.audience || '');
                    $('input[name="note"]').val(product.note || '');
                } else {
                    toastr.error('Product not found or unavailable.');
                }
            },
            error: function() {
                toastr.error('An error occurred while fetching product details. Please try again later.');
            },
            complete: function() {
                $('#productParamsLoader').hide();
                $('#productParamsForm').css('display', 'block');
                $('#productParamsFooter').css('display', 'flex');
                initTooltips();
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
                        initTooltips();
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
