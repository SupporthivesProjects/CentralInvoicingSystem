@extends('layouts.app')

@section('title', 'Product Selection | Central Invoice System')

@section('content')

<div class="page">
    <div class="main-content app-content">
        <div class="container-fluid">
             <!-- Page Header -->
             <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
             <div>
                <h2 class="main-content-title fs-24 mb-3">Choose Products and Generate Invoice</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}" class="text-primary">Select Site</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Choose Products and Generate Invoice</li>
                </ol>
            </div>

                <div class="mt-3 mt-md-0">
                <a href="{{ url()->previous() }}" class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-arrow-left"></i> Go back to Site Selection
                </a>
                </div>
            </div>

            <!-- Page Header Close -->

            <div class="card custom-card">
                <div class="card-body shadow rounded">
                    <form id="generate-invoice-form" method="POST" action="{{ route('generate.invoice') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Selected Website <span class="text-danger">*</span></label>
                                <div class="input-group">
                                 <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                    <input type="text" form="generate-invoice-form" class="form-control" name="site_name" id="site_name" value="{{ $customer['site_name'] ?? 'N/A' }}" readonly>
                                    <a href="{{ route('website.edit', ['id' => $site->id]) }}" class="input-group-text bg-white" title="Edit Site Info">
                                        <i class="fas fa-sync-alt"></i>
                                    </a>
                                </div>
                                <input type="hidden" form="generate-invoice-form" name="site_id" id="site_id" class="form-control" value="{{ $customer['site_id'] }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Invoice Number<span class="text-danger">*</span> <span class="text-info">(Auto Generated)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
                                    <input type="text" form="generate-invoice-form" id="invoice_number" name="invoice_number" class="form-control font-italic" value="{{ $invoice['invoice_number'] ?? '' }}" placeholder="Auto-generated invoice number" readonly>
                                     <span style="cursor: pointer;" class="input-group-text" id="copyInvoicenumber" title="Copy Invoice Number"><i class="fas fa-copy"></i></span>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Invoice Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" form="generate-invoice-form" name="invoice_date" class="form-control" value="{{ $invoice['invoice_date'] ?? now()->toDateString() }}">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" form="generate-invoice-form" class="form-control" id="customer_name" name="customer_name" value="{{ $customer['customer_name'] ?? '' }}" placeholder="Enter Customer Name">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Customer Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" form="generate-invoice-form" class="form-control" id="customer_email" name="customer_email" value="{{ $customer['customer_email'] ?? '' }}"  placeholder="Enter Customer email">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Customer Phone</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" form="generate-invoice-form" class="form-control" id="customer_mobile" name="customer_mobile" value="{{ $customer['customer_mobile'] ?? '' }}"  placeholder="Enter customer Mobile">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                </div>
                            </div>
                        </div>



                    </form>
                </div>
            </div>
            <div class="card custom-card mt-4">
                <div class="card-body shadow rounded">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Current Amount</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">{{ site_currency() }}</span>
                            <input type="number" form="generate-invoice-form" id="current_amount" name="current_amount" class="form-control bg-white" value="{{ $current_total ?? '00.00' }}" readonly>
                            <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Discount Amount</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">{{ site_currency() }}</span>
                            <input type="number" form="generate-invoice-form" name="discount_amount" id="discount_amount" class="form-control bg-white" placeholder="Discount Amount" value="0">
                            <span class="input-group-text"><i class="fas fa-tags"></i></span>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Invoice Amount <span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">{{ site_currency() }}</span>
                            <input form="generate-invoice-form" name="invoice_amount" id="invoice_amount" class="form-control" value="{{ number_format($invoice['invoice_amount'], 2) }}" type="number" readonly>
                            <span class="input-group-text"><i class="fas fa-file-invoice-dollar"></i></span>
                        </div>
                    </div>
                </div>


                </div>
            </div>

            <div class="card custom-card mt-4 border-1 rounded shadow rounded">
                <div class="border-1 rounded shadow rounded card-header bg-light d-flex justify-content-between align-items-center flex-wrap border-bottom pb-3">
                    <h5 class="mb-2 mb-md-0">Search & Filter Products</h5>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Actions">
                        <button type="button" class="btn btn-outline-primary me-1" onclick="setCustomOnly()">
                            <i class="bi bi-sliders"></i> Custom
                        </button>
                        <button type="button" class="btn btn-outline-danger me-1" onclick="clearAllProducts()">
                            <i class="bi bi-trash"></i> Clear
                        </button>
                        <button type="button" class="btn btn-outline-warning me-1" onclick="generateRandomProducts('random')">
                            <i class="bi bi-dice-5"></i> Randomize
                        </button>
                        <button type="button" class="btn btn-outline-success" onclick="generateInvoice(event)">
                            <i class="bi bi-file-earmark-text"></i> Generate Invoice
                        </button>
                    </div>
                </div>


                <div class="card-body mt-1">
                    <!-- Search Filters -->
                    <form method="GET" action="#" class="mb-4">
                        <div class="row align-items-end g-3">
                        <div class="col-md-6 text-center">
                            <label for="keywordInput" class="form-label">Search for Products</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" name="manual_keyword" id="keywordInput" class="form-control" placeholder="Type a keyword and wait for 1.5 seconds to apply the filter.">
                                <span class="input-group-text"><i class="fas fa-filter"></i></span>
                            </div>
                        </div>

                            <div class="col-md-6 text-center">
                                <label class="form-label d-block">Price Range</label>
                                <div id="price-slider" class="w-100 mx-auto"></div>
                                <input type="hidden" name="price_from" id="hidden_price_from_input_id">
                                <input type="hidden" name="price_to" id="hidden_price_to_input_id">
                            </div>
                        </div>
                    </form>

                    <!-- Combined Table -->
                    <div class="table-responsive border rounded">
                    <table class="table table-hover table-bordered align-middle shadow-sm rounded" id="productTable">
                            <thead class="table-dark">
                            <tr>
                                <th>SELECT</th>
                                <th>SR. NO.</th>
                                <th>GAME NAME</th>
                                <th>GAME CURRENCY</th>
                                <th>GAME CURRENCY AMOUNT</th>
                                <th>UNIT PRICE</th>
                                <th>FILTER</th>
                                {{-- <th>MODIFY PRICE</th> --}}
                            </tr>
                            </thead>
                            <tbody id="product-table-body">
                                <!-- Injected by AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    const priceSlider = document.getElementById('price-slider');
    const defaultMin = 10, defaultMax = 1000;
    const currency = "{{ site_currency() }}";

    noUiSlider.create(priceSlider, {
        start: [defaultMin, defaultMax],
        connect: true,
        step: 0.1,
        range: { min: defaultMin, max: defaultMax },
        tooltips: [true, true],
        format: {
            to: v => `${currency}${Math.round(v)}`,
            from: v => Number(v.replace(currency, ''))
        }
    });

    const updateHiddenInputs = (min, max) => {
        $('#hidden_price_from_input_id').val(min).trigger('input');
        $('#hidden_price_to_input_id').val(max).trigger('input');
    };

    $.get("{{ route('get.price.range') }}")
        .done(res => {
            const min = parseFloat(res.minProductPrice) || defaultMin;
            const max = parseFloat(res.maxProductPrice) || defaultMax;
            priceSlider.noUiSlider.updateOptions({ start: [min, max], range: { min, max } });
            updateHiddenInputs(min, max);
        })
        .fail(() => {
            updateHiddenInputs(defaultMin, defaultMax);
        });

    priceSlider.noUiSlider.on('update', function (values) {
        const [min, max] = values.map(v => Math.round(parseFloat(v.replace('$', ''))));
        updateHiddenInputs(min, max);
    });
</script>


<script>
    $(document).ready(function () {
        customMode = false;
        generateRandomProducts('initial');
        $('input[name="product_ids[]"]').prop('disabled', true);
        $('input[name="manual_keyword"]').prop('disabled', true);
        $('.product-price').prop('readonly', true);
        $('#discount_amount').val(0.00);
    });

    function generateRandomProducts(mode = 'initial') {
        customMode = false;
        $('input[name="product_ids[]"]').prop('disabled', true);
        $('input[name="manual_keyword"]').prop('disabled', true);
        $('.product-price').prop('readonly', true);
        let title = (mode === 'initial') ? 'Cooking Up Combos...' : 'Trying Cool Combos...';
        let loadingText = (mode === 'random')
            ? 'Finding products that match your invoice total...'
            : 'Trying new combinations of products that match your invoice total...';

        Swal.fire({
            title: title,
            html: `
                <div class="d-flex flex-column align-items-center">
                    <div class="spinner-border text-primary" role="status"></div>
                    <small class="mt-2">${loadingText}</small>
                </div>
            `,
            showConfirmButton: false,
            allowOutsideClick: false
        });

        const priceFrom = $('#hidden_price_from_input_id').val();
        const priceTo = $('#hidden_price_to_input_id').val();
        if(!customMode){
        $.ajax({
            url: "{{ route('random.products') }}",
            type: 'GET',
            data: {
                site_id: SITE_ID,
                invoice_amount: "{{ $invoice['invoice_amount'] ?? '' }}",
                price_from: priceFrom,
                price_to: priceTo
            },
            success: function (response) {
                Swal.close();
                $('#discount_amount').val(0.00);
                if (response.total === 0) {
                    $('#product-table-body').html(
                        '<tr><td colspan="7" class="text-center text-muted">No results found. Try randomizing or use a different keyword.</td></tr>'
                    );
                    toastr.info("Oops! No magic combo this time. Try another spin or go custom!");
                    return;

                }else{

                    const invoiceAmount = parseFloat("{{ $invoice['invoice_amount'] ?? 0 }}");
                    const currentAmount = parseFloat(response.total.toFixed(2));
                    const discountAmount = currentAmount - invoiceAmount;
                    $('#product-table-body').html(response.tableRows);
                    $('#current_amount').val(currentAmount.toFixed(2));
                    $('input[name="product_ids[]"]').prop('checked', true).prop('disabled', true);

                }

            },
            error: function () {
                toastr.error("Could not fetch random products.");
                Swal.close();
            }
        });
      }
    }
</script>

<script>
let selectedTotal = 0;
let customMode = false;
const invoiceAmount = parseFloat('{{ $invoice["invoice_amount"] ?? 0 }}');
const SITE_ID = {{ session('customer.site_id') ?? 0 }};

// Triggered when custom button is clicked
function setCustomOnly() {
    customMode = true;
    $('input[name="product_ids[]"]').prop('disabled', false);
    $('input[name="manual_keyword"]').prop('disabled', false);
    $('.product-price').prop('readonly', false);
    $('#product-table-body').empty();
    selectedTotal = 0;
    updateTotalDisplay();
    attachCheckboxHandlers();
    $('#discount_amount').val(0.00);
    toastr.info('Now filter and pick your custom products.','Let’s begin!');

}


function filterProducts() {
    const keyword = $('#keywordInput').val().trim();
    const priceFrom = $('#hidden_price_from_input_id').val();
    const priceTo = $('#hidden_price_to_input_id').val();

    // Don't fetch anything if both fields are empty
    if (!keyword && !priceFrom && !priceTo) {
        $('#product-table-body').html(
            '<tr><td colspan="7" class="text-center text-muted">Please enter a keyword or price range to search.</td></tr>'
        );
        return;
    }

    Swal.fire({
        title: 'Searching for the Best Matches...',
        html: `
            <div class="d-flex flex-column align-items-center">
                <div class="spinner-border text-primary" role="status"></div>
                <small class="mt-2">Finding products that match your filters. Please hold on!</small>
            </div>
        `,
        showConfirmButton: false,
        allowOutsideClick: false
    });


    $.ajax({
        url: "{{ route('filter.products') }}",
        type: 'GET',
        data: {
            keyword: keyword,
            price_from: priceFrom,
            price_to: priceTo
        },
        success: function (response) {
            $('#product-table-body').html(response.tableRows);
            selectedTotal = 0;
            updateTotalDisplay();
            attachCheckboxHandlers();
            Swal.close();
        },
        error: function () {
            toastr.error('Something went wrong while filtering.', 'Oops!');
        }
    });
}

function attachCheckboxHandlers() {
    function calculateTotal() {
        let tempTotal = 0;
        $('input[name="product_ids[]"]:checked').each(function () {
            const productId = $(this).val();
            const price = $(`input[data-product-id="${productId}"]`).val();
            const unitPrice = parseFloat(price) || 0;
            tempTotal += unitPrice;
        });

        return tempTotal;
    }


    $('input[name="product_ids[]"]').off('change').on('change', function () {
        const tempTotal = calculateTotal();

        if (tempTotal > invoiceAmount) {
            toastr.error(`Product total exceeds your invoice amount of $${invoiceAmount.toFixed(2)}`, 'Limit Reached');
        }

        selectedTotal = tempTotal;
        updateTotalDisplay();
    });

    $('.product-price').on('input', function () {
        const tempTotal = calculateTotal();

        if (tempTotal > invoiceAmount) {
            toastr.error(`Product total exceeds your invoice amount of $${invoiceAmount.toFixed(2)}`, 'Limit Reached');
        }

        selectedTotal = tempTotal;
        updateTotalDisplay();
    });
}


function updateTotalDisplay() {
    $('#current_amount').val(selectedTotal.toFixed(2));
}

</script>


<script>
function clearAllProducts() {
    $('#product-table-body').empty();
    $('input[name="manual_keyword"]').val('');
    $('#discount_amount').val('');
    $('#current_amount').val('');
    selectedTotal = 0;
    updateTotalDisplay();
    toastr.success('Your filter has been reset now', 'Filter Cleared');
}

</script>
<script>
    let filterTimer;

    $('#keywordInput, #hidden_price_from_input_id, #hidden_price_to_input_id').on('input change', function () {
        clearTimeout(filterTimer);
        const isKeyword = $(this).attr('id') === 'keywordInput';
        filterTimer = setTimeout(() => {
            if (customMode) {
                filterProducts();
            } else {

                if (!isKeyword) {
                    generateRandomProducts('random');
                }
            }
        }, 1500);
    });
</script>


<script>
    function generateInvoice(event) {
        event.preventDefault();

        const visibleProducts = $('input[name="product_ids[]"]:visible');
        const selectedProducts = $('input[name="product_ids[]"]:checked');
        const invoiceAmount = parseFloat($('#invoice_amount').val()) || 0;
        const current_amount = parseFloat($('#current_amount').val()) || 0;
        const discountAmount = parseFloat($('#discount_amount').val()) || 0;

        if (selectedProducts.length === 0) {
            toastr.error('Please select your products combo...', 'No Product Selected');
            return;
        }

        if (current_amount < invoiceAmount) {
            $('#current_amount').addClass('border border-danger');
                setTimeout(() => {
                    $('#current_amount').removeClass('border border-danger');
                }, 2000);
            toastr.error('Total is less than invoice amount.', 'Mismatch');
            return;
        }

        if ((current_amount - discountAmount) !== invoiceAmount) {
            const diff = (current_amount - invoiceAmount);
            const diffFixed = diff.toFixed(2);

            $('#discount_amount').val(discountAmount).addClass('border border-danger');
            setTimeout(() => {
                $('#discount_amount').removeClass('border border-danger');
            }, 2000);

            if (discountAmount > diff) {
                toastr.error(`The discount amount of $${discountAmount} exceeds the expected discount of $${diffFixed}.`, 'Discount Too High');
            } else {
                toastr.error(`Please apply a discount of $${diffFixed} to match the invoice amount.`, 'Give Discount');
            }

            return;
        }

        let blinkCount = 0;
        const maxBlinkCount = 15;
        const blinkInterval = 500;

        $('#discount_amount, #current_amount, #invoice_amount').css('transition', 'border-color 0.3s ease');

        (function blinkBorder() {
            $('#discount_amount, #current_amount, #invoice_amount').toggleClass('border border-success');
            blinkCount++;
            if (blinkCount < maxBlinkCount) {
                setTimeout(blinkBorder, blinkInterval);
            } else {
                $('#discount_amount, #current_amount, #invoice_amount').removeClass('border border-success');
            }
        })();
        toastr.options.timeOut = 5000;
        toastr.info('Preparing your invoice details...', 'Initializing');
        $.ajax({
            url: "{{ route('generate.invoice.number') }}",
            method: 'GET',
            data: { site_name: "{{ $customer['site_name'] ?? 'N/A' }}" },
            success: function (response) {
                if (!response.success) {
                    Swal.close();
                    toastr.error('Failed to generate new invoice number', 'Error');
                    return;
                }

                $('input[name="invoice_number"]').val(response.new_invoice_number);
                $('#generate-invoice-form').find('input[name="product_data[]"]').remove();

                selectedProducts.each(function () {
                    const productId = $(this).val();
                    const unitPrice = $(`input[data-product-id="${productId}"]`).val();

                    $('#generate-invoice-form').append($('<input>', {
                        type: 'hidden',
                        name: 'product_data[]',
                        value: JSON.stringify({ product_id: productId, unit_price: unitPrice })
                    }));
                });

                $('#generate-invoice-form')[0].submit();

                    toastr.options = {
                        timeOut: 15000,
                        onHidden: function () {
                            toastr.options = {
                                timeOut: 4000
                            };
                            toastr.success('Invoice is ready and will download shortly. The page will refresh in 30 seconds.', 'Completed');
                            setInterval(() => {
                                location.reload();
                            }, 30000);


                        }
                    };

                    toastr.info('Generating invoice PDF file...', 'Processing');

            },
            error: function () {
                Swal.close();
                toastr.error('There was an error generating the invoice number', 'Error');
            }
        });
    }
</script>


@endpush
