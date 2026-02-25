@forelse($products as $index => $product)
    @php
        $languages = site_languages();
        $urgencyOptions = $product->urgency_options ?? [];
        $currentUrgencyType = $product->urgency_type ?? 'none';
    @endphp
    <tr class="product-row">
        <td class="text-center">{{ $product->id }}</td>
        <td>
            {{ $product->name }}
            @if (!empty($product->product_url))
                <a href="{{ $product->product_url }}" target="_blank" title="View Product">🔗</a>
            @endif
            <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][id]" value="{{ $product->id }}">
            <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][name]" value="{{ $product->name }}">
        </td>
        <td>
            <select form="generate-invoice-form" class="form-select from-language-dropdown" name="products[{{ $product->id }}][from_language]">
                <option value="">From Language</option>
                @foreach ($languages as $lang)
                    <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select form="generate-invoice-form" class="form-select to-language-dropdown" name="products[{{ $product->id }}][to_language]">
                <option value="">To Language</option>
                @foreach ($languages as $lang)
                    <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][display_unit_price]" value="{{ number_format($product->unit_price, 2) }}">
            <div class="input-group d-flex">
                <span class="input-group-text" data-bs-toggle="tooltip" title="{{ site_currency_code() }}">{{ site_currency() }}</span>
                <input form="generate-invoice-form" style="display: none;" class="form-check-input border narayan-checkbox border-1 border-primary" type="checkbox" name="products[{{ $product->id }}][selected]" data-unit_price="{{ number_format($product->unit_price, 2, '.', '') }}" value="1" checked>
                <input form="generate-invoice-form" type="text" class="form-control product-price text-center" name="products[{{ $product->id }}][price]" value="{{ number_format($product->unit_price, 2, '.', '') }}" data-product-id="{{ $product->id }}" {{ $product->can_edit_price == 0 ? 'readonly' : '' }} />
                <span class="input-group-text d-flex align-items-center">
                    <i class="{{ $product->can_edit_price == 0 ? 'fas fa-lock text-muted' : 'fas fa-edit' }}" style="font-size: 12px;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $product->can_edit_price == 0 ? 'Price update allowed after ' . $product->remaining_days . ' days.' : 'Editable' }}"></i>
                </span>
            </div>
            <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][can_edit_price]" value="{{ $product->can_edit_price }}">
        </td>
        <td class="text-center">
            <div class="input-group">
                <input form="generate-invoice-form" type="number" class="form-control product-pages text-center" name="products[{{ $product->id }}][pages]" value="{{ $product->pages }}" min="1" data-product-id="{{ $product->id }}" data-unit-type="{{ $product->unit_type ?? 'pages' }}" aria-label="Number of pages or words" />
                <span class="input-group-text">{{ $product->unit_type ?? 'pages' }}</span>
            </div>
        </td>

        {{-- URGENCY COLUMN --}}
        <td class="text-center p-1">
            @if(count($urgencyOptions) > 0)
                <div class="urgency-radio-group d-flex flex-column align-items-start gap-1"
                    data-product-id="{{ $product->id }}"
                    data-unit-type="{{ $product->unit_type ?? 'pages' }}"
                    data-pages="{{ $product->pages }}"
                    @foreach($urgencyOptions as $key => $opt)
                        data-rate-{{ $key }}="{{ $opt['rate'] }}"
                    @endforeach
                    style="padding-left:2px;">

                    {{-- No Urgency --}}
                    <div class="form-check mb-0" style="min-height:0;">
                        <input
                            class="form-check-input urgency-radio"
                            type="radio"
                            form="generate-invoice-form"
                            name="products[{{ $product->id }}][urgency_type]"
                            id="urg_none_{{ $product->id }}"
                            value="none"
                            data-product-id="{{ $product->id }}"
                            data-rate="0"
                            data-urgkey="none"
                            {{ $currentUrgencyType === 'none' ? 'checked' : '' }}
                            data-bs-toggle="tooltip"
                            data-bs-placement="right"
                            title="No urgency surcharge"
                        >
                        <label class="form-check-label" for="urg_none_{{ $product->id }}" style="cursor:pointer;font-size:11px;white-space:nowrap;color:#6c757d;">None</label>
                    </div>

                    {{-- Dynamic urgency options --}}
                    @foreach($urgencyOptions as $key => $opt)
                        @php
                            $qty      = $product->pages;
                            $rate     = floatval($opt['rate']);
                            $urgTotal = ($key === 'flat') ? $rate : ($rate * $qty);
                        @endphp
                        <div class="form-check mb-0" style="min-height:0;">
                            <input
                                class="form-check-input urgency-radio"
                                type="radio"
                                form="generate-invoice-form"
                                name="products[{{ $product->id }}][urgency_type]"
                                id="urg_{{ $key }}_{{ $product->id }}"
                                value="{{ $key }}"
                                data-product-id="{{ $product->id }}"
                                data-rate="{{ $rate }}"
                                data-urgkey="{{ $key }}"
                                {{ $currentUrgencyType === $key ? 'checked' : '' }}
                                data-bs-toggle="tooltip"
                                data-bs-placement="right"
                                title="+{{ site_currency() }}{{ number_format($urgTotal, 2) }} added to total"
                            >
                            <label class="form-check-label fw-semibold" for="urg_{{ $key }}_{{ $product->id }}" style="cursor:pointer;font-size:11px;white-space:nowrap;">
                                {{ $opt['label'] }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <input form="generate-invoice-form" type="hidden" class="urgency-add-hidden" name="products[{{ $product->id }}][urgency_add]" value="{{ number_format($product->urgency_add ?? 0, 2, '.', '') }}">
                <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][urgent_amount]" value="{{ number_format($product->urgency_add ?? 0, 2, '.', '') }}">
            @else
                <span class="text-muted small">N/A</span>
                <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][urgency_type]" value="none">
                <input form="generate-invoice-form" type="hidden" class="urgency-add-hidden" name="products[{{ $product->id }}][urgency_add]" value="0">
                <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][urgent_amount]" value="0">
            @endif
        </td>

        <td class="text-center line-total" data-product-id="{{ $product->id }}">
            {{ site_currency() }}{{ number_format($product->line_total, 2) }}
            <input form="generate-invoice-form" type="hidden" name="products[{{ $product->id }}][line_total]" value="{{ $product->line_total }}">
        </td>
        <td class="text-center">
            <button type="button" class="remove-product btn btn-danger btn-sm" data-product-name="{{ $product->name }}" data-product-id="{{ $product->id }}">
                <i class="fa fa-trash"></i>
            </button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="10" class="text-center text-muted py-3 border-top">
            No results found. Try randomizing or use a different invoice amount.
        </td>
    </tr>
@endforelse

<script>
const siteCurrency = @json(site_currency());

function computeUrgencyAddFromGroup($group, pages) {
    var $checked = $group.find('.urgency-radio:checked');
    if (!$checked.length) return 0;
    var urgencyType = $checked.val();
    if (!urgencyType || urgencyType === 'none') return 0;
    var rate = parseFloat($checked.data('rate')) || 0;
    if (rate <= 0) return 0;
    return (urgencyType === 'flat') ? rate : (rate * pages);
}

function refreshTooltipsForGroup($group, pages) {
    $group.find('.urgency-radio').each(function () {
        var $radio      = $(this);
        var urgencyType = $radio.val();
        var tipText;

        if (!urgencyType || urgencyType === 'none') {
            tipText = 'No urgency surcharge';
        } else {
            var rate     = parseFloat($radio.data('rate')) || 0;
            var urgTotal = (urgencyType === 'flat') ? rate : (rate * pages);
            tipText = '+' + siteCurrency + urgTotal.toFixed(2) + ' added to total';
        }

        var existing = bootstrap.Tooltip.getInstance($radio[0]);
        if (existing) existing.dispose();
        $radio.attr('title', tipText);
        new bootstrap.Tooltip($radio[0], { placement: 'right', trigger: 'hover' });
    });
}

function updateLineTotalFromRow($row) {
    var $group     = $row.find('.urgency-radio-group');
    var pages      = parseInt($row.find('.product-pages').val()) || 1;
    var unitPrice  = parseFloat($row.find('.product-price').val()) || 0;
    var urgencyAdd = $group.length ? computeUrgencyAddFromGroup($group, pages) : 0;
    var lineTotal  = (unitPrice * pages) + urgencyAdd;

    var $totalCell   = $row.find('.line-total');
    var $hiddenTotal = $totalCell.find('input[type="hidden"]');
    $totalCell.text(siteCurrency + lineTotal.toFixed(2));
    $hiddenTotal.val(lineTotal.toFixed(2));

    $row.find('.urgency-add-hidden').val(urgencyAdd.toFixed(2));
    $row.find('input[name*="[urgent_amount]"]').val(urgencyAdd.toFixed(2));

    if ($group.length) refreshTooltipsForGroup($group, pages);
}

$(document).ready(function () {

    $(document).off('change', '.urgency-radio').on('change', '.urgency-radio', function () {
        var $radio      = $(this);
        var $row        = $radio.closest('tr');
        var productId   = $radio.data('product-id');
        var urgencyType = $radio.val();
        var pages       = parseInt($row.find('.product-pages').val()) || 1;

        updateLineTotalFromRow($row);
        calculateTotalPrice();

        $.ajax({
            url: "{{ route('update.product') }}",
            method: 'POST',
            data: {
                product_id:   productId,
                pages:        pages,
                urgency_type: urgencyType,
                site_id:      "{{ session('customer.site_id') }}",
                _token:       '{{ csrf_token() }}'
            },
            error: function () {
                toastr.error('Error updating urgency. Please try again.');
            }
        });
    });

    $(document).off('keyup change', '.product-price').on('keyup change', '.product-price', function () {
        updateLineTotalFromRow($(this).closest('tr'));
        calculateTotalPrice();
    });

    $(document).off('change', '.product-pages').on('change', '.product-pages', function () {
        var $input      = $(this);
        var productId   = $input.data('product-id');
        var pages       = parseInt($input.val()) || 1;
        var $row        = $input.closest('tr');
        var $group      = $row.find('.urgency-radio-group');
        var urgencyType = $group.length ? ($group.find('.urgency-radio:checked').val() || 'none') : 'none';

        if (pages < 1) { pages = 1; $input.val(pages); }

        updateLineTotalFromRow($row);

        $.ajax({
            url: "{{ route('update.product') }}",
            method: 'POST',
            data: {
                product_id:   productId,
                pages:        pages,
                urgency_type: urgencyType,
                site_id:      "{{ session('customer.site_id') }}",
                _token:       '{{ csrf_token() }}'
            },
            success: function () {
                calculateTotalPrice();
            },
            error: function () {
                toastr.error('Error updating pages. Please try again.');
            }
        });
    });

    $('.urgency-radio-group').each(function () {
        var $group = $(this);
        var pages  = parseInt($group.closest('tr').find('.product-pages').val()) || 1;
        refreshTooltipsForGroup($group, pages);
    });

    if (typeof ensureHiddenInputs === 'function') ensureHiddenInputs();

    $(document).off('click', '.remove-product').on('click', '.remove-product', function () {
        var $button     = $(this);
        var productId   = $button.data('product-id');
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
                        site_id:    "{{ session('customer.site_id') }}",
                        _token:     '{{ csrf_token() }}'
                    },
                    success: function (response) {
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
                    error: function () {
                        $('.remove-product').prop('disabled', false);
                        $button.html('<i class="fas fa-trash-alt"></i>');
                        $button.removeClass('btn-success').addClass('btn-danger');
                        calculateTotalPrice();
                        toastr.error('Error removing product. Please try again.');
                    },
                    complete: function () {
                        $('.remove-product').prop('disabled', false);
                    }
                });
            }
        });
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]:not(.urgency-radio)'));
    tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });
});
</script>