@forelse(collect($products)->sortByDesc('unit_price') as $index => $product)
    @php
        $captureFields = json_decode($product->game_need_to_capture ?? '{}', true);
        $platforms = array_keys($captureFields);

    @endphp


    {{-- Main Row --}}
    <tr class="product-row align-middle" id="product-main-row-{{ $index + 1 }}" data-bs-toggle="collapse"
        data-bs-target="#collapse-{{ $index + 1 }}" aria-expanded="false" aria-controls="collapse-{{ $index + 1 }}"
        style="cursor: pointer;">
        <td class="text-center">
            <div class="form-check m-0 d-flex justify-content-center">
                <input form="generate-invoice-form" class="form-check-input narayan-checkbox border-primary"
                    type="checkbox" data-unit_price="{{ $product->unit_price }}"
                    name="products[{{ $product->id }}][selected_checkbox]" value="1" checked disabled
                    {{-- @if (request()->has('is_random') && request('is_random'))
           disabled
       @endif --}}>
                <input type="hidden" name="products[{{ $product->id }}][selected]" value="1">
            </div>
        </td>
        <td>{{ $index + 1 }}</td>
        <td>
            {{ $product->name }}
            @if ($site->site_link && $product->slug)
                <a href="{{ $site->site_link }}games" target="_blank">🔗</a>
            @endif
            <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][name]"
                value="{{ $product->name }}">
        </td>
        <td><span class="badge bg-secondary">{{ $product->game_currency ?? '-' }}</span>
            <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][game_currency]"
                value="{{ $product->game_currency }}">
        </td>
        <td>{{ $product->game_currency_amount . ' ' . $product->game_currency }}
            <input form="generate-invoice-form" type="hidden"
                name="products[{{ $product->id }}][game_currency_amount]"
                value="{{ $product->game_currency_amount }}">
        </td>
        @if ($product->source == 'Random')
            <td>{{ site_currency() }}{{ number_format($product->unit_price, 2) }}
                <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][unit_price]"
                    value="{{ $product->unit_price }}">
                <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][bundle_id]"
                    value="{{ $product->bundle_id }}">
            </td>
        @else
            <td>{{ site_currency() }}{{ number_format($product->unit_price, 2) }}
                <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][unit_price]"
                    value="{{ $product->unit_price }}">
            </td>
        @endif

        {{-- <td>
            <input form="generate-invoice-form" type="number" class="form-control edit-price" name="products[{{ $product->id }}][unit_price]" value="{{ $product->unit_price }}">
        </td> --}}
        <td>
            @php
                // Check if price was updated in the last 90 days
                $lastUpdate = \App\Models\ProductPriceHistory::where('site_id', session('customer.site_id'))
                    ->where('product_id', $product->bundle_id)
                    ->where('bundle', (string) $product->game_currency_amount)
                    ->orderByDesc('last_price_changed')
                    ->first();

                $isLocked =
                    $lastUpdate && \Carbon\Carbon::parse($lastUpdate->last_price_changed)->diffInDays(now()) < 90;
                $daysRemaining = $isLocked
                    ? 90 - \Carbon\Carbon::parse($lastUpdate->last_price_changed)->diffInDays(now())
                    : 0;

                // Get lock/unlock status for display
                $lockStatus = $isLocked ? 'locked' : 'unlocked';
                $iconClass = $isLocked ? 'fa-lock bg-warning' : 'fa-pencil bg-success';
                $tooltip = $isLocked ? "Price locked for {$daysRemaining} more days" : 'Price can be edited';
                $inputTooltip = $isLocked
                    ? 'This price was updated on ' .
                        \Carbon\Carbon::parse($lastUpdate->last_price_changed)->format('M d, Y') .
                        " and cannot be modified for {$daysRemaining} more days"
                    : 'You can update this price';
            @endphp

            <div class="input-group">
                <span class="input-group-text {{ $isLocked ? 'bg-warning' : 'bg-success' }}" data-bs-toggle="tooltip"
                    title="{{ $tooltip }}">
                    <i class="fa {{ $iconClass }}"></i>
                </span>
                <input form="generate-invoice-form" type="number" step="0.01"
                    class="form-control edit-price {{ $isLocked ? 'bg-light' : '' }}"
                    name="products[{{ $product->id }}][unit_price]" value="{{ $product->unit_price }}"
                    {{ $isLocked ? 'readonly' : '' }} data-bs-toggle="tooltip" data-price-status="{{ $lockStatus }}"
                    title="{{ $inputTooltip }}">

                <!-- Hidden fields for bundle_id and game_currency_amount needed for update -->
                <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][bundle_id]"
                    value="{{ $product->bundle_id }}">
                <input form="generate-invoice-form" type="hidden"
                    name="products[{{ $product->id }}][game_currency_amount]"
                    value="{{ $product->game_currency_amount }}">
            </div>
        </td>

        <td>
            <button type="button" class="btn btn-sm btn-outline-danger px-2 py-1 remove-product"
                data-product-id="{{ $product->id }}" data-unit-price="{{ $product->unit_price }}"
                data-product-name="{{ $product->name }}" title="Remove Row">
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
                                                placeholder="Enter {{ $field }}" required>
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

@php
    //dd($products);
@endphp

<script>
    $(document).ready(function() {
        // Remove product with confirmation
        $(document).off('click', '.remove-product').on('click', '.remove-product', function() {
            var $button = $(this);
            var productId = $button.data('product-id');
            var unitPrice = $button.data('unit-price');
            var productName = $button.data('product-name');

            Swal.fire({
                title: 'Remove Product?',
                text: `Are you sure you want to remove '${productName}' product?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Remove',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'p-2'
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    $('#table-blocker').show();
                    $button.prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                        );

                    $.ajax({
                        url: "{{ route('remove.product') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            product_id: productId,
                            unit_price: unitPrice,
                            site_id: '{{ $site->id }}'
                        },
                        success: function(response) {
                            if (response.tableRows !== undefined) {
                                $('#product-table-body').html(response.tableRows);

                                // Update Current Amount
                                $('#current_amount').val(response.total.toFixed(2));

                                toastr.success('Product removed successfully!');
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            toastr.error('Something went wrong! Please try again.');
                        },
                        complete: function() {
                            $('#table-blocker').hide();
                            $button.prop('disabled', false).html(
                                '<i class="fa fa-trash"></i>');
                        }
                    });
                }
            });
        });

        // ✅ Recalculate when checkbox changes
        $(document).on('change', '.narayan-checkbox', function() {
            calculateTotalPrice();
        });

        // ✅ Recalculate when Edit Price input changes
        let sessionAmountTimeout;
        $(document).on('input', '.edit-price', function() {
            clearTimeout(sessionAmountTimeout);

            sessionAmountTimeout = setTimeout(function() {
                updateSessionCurrentAmount();
            }, 1000);

            calculateTotalPrice(); // still runs immediately
        });

        // Main Calculation Function
        function calculateTotalPrice() {
            let currentAmount = 0;

            // Loop through all selected products
            $('.narayan-checkbox:checked').each(function() {
                const productRow = $(this).closest('tr');
                const editPriceInput = productRow.find('.edit-price');
                let editPrice = parseFloat(editPriceInput.val());

                if (isNaN(editPrice)) {
                    editPrice = parseFloat($(this).data('unit_price')) || 0;
                }

                currentAmount += editPrice;
            });
            const invoiceAmount = parseFloat($('#invoice_amount').val()) || 0;
                let discountAmount = 0;

                if (currentAmount > invoiceAmount) {
                    discountAmount = currentAmount - invoiceAmount;
                }

                $('#current_amount').val(currentAmount.toFixed(2));
                $('#discount_amount').val(discountAmount.toFixed(2));



        }
    });
</script>
<script>
    //Write a function to update session current amount
    function updateSessionCurrentAmount() {
        let currentAmount = parseFloat($('#current_amount').val()) || 0;
        $.ajax({
            url: "{{ route('update.product') }}",
            type: 'POST',
            data: {
                current_amount: currentAmount,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {

            },
            error: function() {
                // Handle error in toastr
                toastr.error('Error updating session current amount.');
            }
        });
    }
</script>
