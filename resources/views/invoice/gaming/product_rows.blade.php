@forelse(collect($products)->sortByDesc('unit_price') as $index => $product)
    @php
        $captureFields = json_decode($product->game_need_to_capture ?? '{}', true);
        $platforms = array_keys($captureFields);
    @endphp

    {{-- Main Row --}}
    <tr class="product-row align-middle" id="product-main-row-{{ $index + 1 }}" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $index + 1 }}" aria-expanded="false" aria-controls="collapse-{{ $index + 1 }}" style="cursor: pointer;">
        <td class="text-center">
            <div class="form-check m-0 d-flex justify-content-center">
                <input form="generate-invoice-form" class="form-check-input narayan-checkbox border-primary" type="checkbox"
                    data-unit_price="{{ $product->unit_price }}" name="products[{{ $product->id }}][selected]" value="1">
            </div>
        </td>
        <td>{{ $index + 1 }}</td>
        <td>
            {{ $product->name }}
            @if ($site->site_link && $product->slug)
                <a href="{{ $site->site_link }}/product/{{ $product->slug }}" target="_blank">🔗</a>
            @endif
            <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][name]" value="{{ $product->name }}">
        </td>
        <td><span class="badge bg-secondary">{{ $product->game_currency ?? '-' }}</span>
            <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][game_currency]" value="{{ $product->game_currency }}">
        </td>
        <td>{{ $product->game_currency_amount . ' ' . $product->game_currency }}
            <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][game_currency_amount]" value="{{ $product->game_currency_amount }}">
        </td>
        <td>{{ site_currency() }}{{ number_format($product->unit_price, 2) }}
            <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][unit_price]" value="{{ $product->unit_price }}">
        </td>
        <td><span class="badge rounded-pill bg-info">{{ $product->source ?? 'Custom' }}</span></td>
        <td>
            <button type="button" class="btn btn-sm btn-outline-danger px-2 py-1 remove-product" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" title="Remove Row">
                <i class="fa fa-trash"></i>
            </button>
        </td>
    </tr>

    {{-- Expandable Capture Row --}}
    <tr id="product-collapse-row-{{ $index + 1 }}">
        <td colspan="8" class="p-0 border-0">
            <div class="collapse bg-light" id="collapse-{{ $index + 1 }}" data-bs-parent="#product-table-body">
                <div class="p-3">
                    <h6 class="fw-bold mb-3">Game Account Details Required:</h6>

                    @if (!empty($captureFields))
                        {{-- Platform Dropdown --}}
                        <div class="mb-3">
                            <label class="form-label">Select Platform:</label>
                            <select form="generate-invoice-form" class="form-select select-platform"
                                    data-product-id="{{ $product->id }}"
                                    name="products[{{ $product->id }}][selected_platform]"
                                    onchange="handlePlatformChange(this)">
                                <option value="">-- Select Platform --</option>
                                @foreach ($platforms as $platform)
                                    <option value="{{ \Illuminate\Support\Str::slug($platform, '_') }}">
                                        {{ $platform }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Fields for each platform --}}
                        @foreach ($captureFields as $platform => $fields)
                            @php $slug = \Illuminate\Support\Str::slug($platform, '_'); @endphp
                            <div class="platform-section" data-product-id="{{ $product->id }}"
                                 data-platform="{{ $slug }}" style="display: none;">
                                <div class="row">
                                    @foreach ($fields as $field)
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">{{ $field }}</label>
                                            <input form="generate-invoice-form" type="text" class="form-control"
                                                   name="products[{{ $product->id }}][platform_fields][{{ $slug }}][{{ \Illuminate\Support\Str::slug($field, '_') }}]"
                                                   placeholder="Enter {{ $field }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-muted">No capture fields defined.</div>
                    @endif
                </div>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center text-muted py-3">No results found.</td>
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
                            $('#product-table-body').html(response.tableRows);
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
