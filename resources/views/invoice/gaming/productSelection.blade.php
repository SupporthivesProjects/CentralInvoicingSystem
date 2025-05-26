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
                            <input form="generate-invoice-form" name="invoice_amount" id="invoice_amount" class="form-control" value="{{ number_format($invoice['invoice_amount'], 2, '.', '') }}" type="number">
                            <span class="input-group-text" id="update_invoice_amount" style="cursor:pointer;width: 40px;"><i data-feather="edit" id="icon"></i></span>
                        </div>
                    </div>
                </div>


                </div>
            </div>

            <div class="card custom-card mt-4 border-1 rounded shadow rounded">
                <div class="border-1 rounded shadow rounded card-header bg-light d-flex justify-content-between align-items-center flex-wrap border-bottom pb-3">
                    <h5 class="mb-2 mb-md-0">Search & Filter Products</h5>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Actions">
                        <button type="button" class="btn btn-outline-success me-1" data-bs-toggle="modal" data-bs-target="#addgames" onclick="customizeProducts('onload')">
                            <i class="bi bi-plus-circle"></i> Add
                        </button>
                        {{-- <button type="button" class="btn btn-outline-info me-1" onclick="setCustomOnly()">
                            <i class="bi bi-pencil-square"></i> Custom
                        </button> --}}
                        <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1 me-1"
                                onclick="clearAllProducts(this)">
                            <i class="fa-solid fa-filter-circle-xmark"></i>Clear All
                        </button>
                        <button type="button" class="btn btn-outline-warning me-1" onclick="generateRandomProducts('random')">
                            <i class="bi bi-shuffle"></i> Randomize
                        </button>
                        <button type="button" class="btn btn-outline-primary" onclick="generateInvoice(event)">
                            <i class="bi bi-receipt"></i> Generate Invoice
                        </button>
                    </div>

                </div>


                <div class="card-body mt-1">
                    <!-- Search Filters -->
                    <form method="GET" action="#" class="mb-4">
                        <div class="row align-items-end g-3">
                            <!-- Number of Products -->
                            <div class="col-md-4 text-center">
                                <label for="productCountInput" class="form-label">Number of Products</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-list-ol"></i></span>
                                    <input type="number" name="product_count" id="productCountInput" class="form-control" placeholder="Enter number of products" min="1">
                                </div>
                            </div>

                            <!-- Keyword Search -->
                            <div class="col-md-4 text-center">
                                <label for="keywordInput" class="form-label">Search for Products</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" name="manual_keyword" id="keywordInput" class="form-control" placeholder="Type a keyword and wait for 1.5 seconds to apply the filter.">
                                    <span class="input-group-text"><i class="fas fa-filter"></i></span>
                                </div>
                            </div>

                            <!-- Price Range -->
                            <div class="col-md-4 text-center">
                                <label class="form-label d-block">Price Range</label>
                                <div id="price-slider" class="w-100 mx-auto"></div>
                                <input type="hidden" name="price_from" id="hidden_price_from_input_id">
                                <input type="hidden" name="price_to" id="hidden_price_to_input_id">
                            </div>
                        </div>
                    </form>


                    <!-- Combined Table -->
                    <div class="table-responsive border rounded">
                        <div id="product-table-wrapper" style="position: relative;">
                            <div id="table-blocker" style="display: none; position: absolute; inset: 0; background: rgba(255,255,255,0.6); z-index: 5; cursor: not-allowed;"></div>
                    <table class="table table-hover table-bordered align-middle shadow-sm rounded" id="productTable">
                            <thead class="table-dark">
                            <tr>
                                <th>SELECT</th>
                                <th>SR. NO.</th>
                                <th>GAME NAME</th>
                                <th>GAME CURRENCY</th>
                                <th>GAME CURRENCY AMOUNT</th>
                                <th>UNIT PRICE</th>
                                <th>EDIT PRICE</th>
                                <th>REMOVE</th>
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
</div>
{{-- Modal for Custom Game Selection --}}

<div class="modal fade" id="addgames" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addGamesLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-white shadow-sm rounded-3 p-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="fas fa-sliders-h text-primary fs-4 me-2"></i>
                    <h5 class="modal-title fw-semibold text-dark mb-0" id="addGamesLabel">
                        Customize Your Game Selection
                    </h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body bg-white">
                <div class="container-fluid">

                    <!-- Search Section -->
                    <div class="row g-3 mb-4 justify-content-center">
                        <div class="col-md-6">
                            <label for="keywordInput" class="form-label text-center fw-semibold mb-2">Search by Keyword</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" id="modalkeywordInput" placeholder="Enter or speak product or category name...">
                                <button class="btn btn-outline-secondary" type="button" onclick="startVoiceSearch()" id="micBtn" title="Voice Search">
                                    <i class="fas fa-microphone" id="micIcon"></i>
                                </button>
                                <button class="btn btn-outline-primary" type="button" onclick="customizeProducts('search')">Search</button>
                            </div>
                        </div>
                    </div>

                    <!-- Amount Summary Section -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="bg-light rounded border shadow-sm p-3 text-center">
                                <div class="text-muted small fw-semibold">Current Amount</div>
                                <div class="fw-bold text-success fs-5">{{ site_currency() }}<span id="temp_current_amount_text">0.00</span></div>
                                <input type="hidden" id="modal_current_amount" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light rounded border shadow-sm p-3 text-center">
                                <div class="text-muted small fw-semibold">Discount Amount</div>
                                <div class="fw-bold text-danger fs-5">{{ site_currency() }}<span id="temp_discount_amount_text">0.00</span></div>
                                <input type="hidden" id="modal_discount_amount" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light rounded border shadow-sm p-3 text-center">
                                <div class="text-muted small fw-semibold">Invoice Amount</div>
                                <div class="fw-bold text-warning fs-5">{{ site_currency() }}<span id="temp_invoice_amount_text">0.00</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Products Table Section -->
                    <div class="table-responsive border rounded shadow-sm">
                        <table class="table table-bordered table-hover align-middle mb-0" id="customize-products-table" style="width: 100%;">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>SR. NO.</th>
                                    <th>GAME NAME</th>
                                    <th>GAME CURRENCY</th>
                                    <th>GAME CURRENCY AMOUNT</th>
                                    <th>UNIT PRICE</th>
                                    <th>SELECT</th>
                                </tr>
                            </thead>
                            <tbody id="customize-product-table-body">
                                {{-- Injected by Ajax --}}
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer bg-light border-top">
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeFilters()">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-danger" onclick="clearFilters()">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filters
                    </button>
                    <button type="button" id="add-custom-products" class="btn btn-primary">
                        <i class="bi bi-cart-plus me-1"></i> Add to list
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>


{{-- Modal for Custom Game Selection --}}
@endsection
@push('scripts')

<script>
$(document).ready(function () {
    let sessionAmount = parseFloat("{{ session('invoice_amount') ?? 0 }}");

    function setEditIcon() {
        $('#update_invoice_amount')
            .removeClass('bg-warning bg-success')
            .addClass('bg-light')
            .html('<i data-feather="edit" id="icon" style="color: black;width:20px;"></i>');
        feather.replace();
    }

    function setUploadIcon() {
        $('#update_invoice_amount')
            .removeClass('bg-light bg-success')
            .addClass('bg-warning')
            .html('<i data-feather="upload-cloud" id="icon" style="color: black;width:20px;"></i>');
        feather.replace();
    }

    function setLoader() {
        $('#update_invoice_amount')
            .removeClass('bg-warning bg-light bg-success')
            .addClass('bg-warning')
            .html(
                '<div class="d-flex align-items-center justify-content-center" style="width:20px;">' +
                    '<div class="spinner-border text-dark" style="width: 18px; height: 18px;" role="status">' +
                        '<span class="visually-hidden">Loading...</span>' +
                    '</div>' +
                '</div>'
            );
    }

    function setSuccessIcon() {
        $('#update_invoice_amount')
            .removeClass('bg-warning')
            .addClass('bg-success')
            .html('<i data-feather="check-circle" id="icon" style="color: white;width:20px;"></i>');
        feather.replace();
    }

    $('#invoice_amount').on('input', function () {
        let currentVal = parseFloat($(this).val());
        if (!isNaN(currentVal) && currentVal !== sessionAmount) {
            setUploadIcon();
        } else {
            setEditIcon();
        }
    });

    $(document).on('click', '#update_invoice_amount', function () {
        let currentVal = parseFloat($('#invoice_amount').val());
        if (isNaN(currentVal) || currentVal === sessionAmount) {
            return;
        }

        setLoader();

        let invoice_amount = $('#invoice_amount').val();
        let invoice_date = $('#invoice_date').val();
        let customer_name = $('#customer_name').val();
        let customer_email = $('#customer_email').val();
        let customer_mobile = $('#customer_mobile').val();

        $.ajax({
            url: "{{ route('update.invoice.amount') }}",
            type: 'POST',
            data: {
                invoice_amount,
                invoice_date,
                customer_name,
                customer_email,
                customer_mobile,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.success) {
                    sessionAmount = parseFloat(invoice_amount);
                    setSuccessIcon();

                    $('#invoice_amount').val(response.updated.invoice_amount);
                    $('#invoice_date').val(response.updated.invoice_date);
                    $('#customer_name').val(response.updated.customer_name);
                    $('#customer_email').val(response.updated.customer_email);
                    $('#customer_mobile').val(response.updated.customer_mobile);
                    generateRandomProducts();

                    setTimeout(() => {
                        setEditIcon();
                    }, 4000);
                }
            },
            error: function () {
                setEditIcon();
            }
        });
    });
});
</script>

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

    updateHiddenInputs(defaultMin, defaultMax);

    priceSlider.noUiSlider.on('update', function (values) {
        const [min, max] = values.map(v => Math.round(parseFloat(v.replace('$', ''))));
        updateHiddenInputs(min, max);
    });
</script>


<style>
    /* Pacman Loader Styles */
    .pacman-loader {
        position: relative;
        width: 100px;
        height: 40px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        overflow: hidden;
    }

    .pacman {
        width: 0;
        height: 0;
        border-right: 20px solid transparent;
        border-top: 20px solid yellow;
        border-left: 20px solid yellow;
        border-bottom: 20px solid yellow;
        border-radius: 20px;
        animation: pacman-chomp 0.5s infinite alternate;
        z-index: 2;
    }

    @keyframes pacman-chomp {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(-20deg); }
    }

    .dots {
        display: flex;
        margin-left: 10px;
        position: relative;
    }

    .dot {
        width: 10px;
        height: 10px;
        margin-left: 20px;
        background: rgb(255, 255, 255);
        border-radius: 50%;
        animation: move-dot 1.5s linear infinite;
    }

    .dot:nth-child(1) { animation-delay: 0s; }
    .dot:nth-child(2) { animation-delay: 0.3s; }
    .dot:nth-child(3) { animation-delay: 0.6s; }
    .dot:nth-child(4) { animation-delay: 0.9s; }
    .dot:nth-child(5) { animation-delay: 1.2s; }

    @keyframes move-dot {
        0% { transform: translateX(0); opacity: 1; }
        100% { transform: translateX(-100px); opacity: 0; }
    }
    </style>

    <script>
        $(document).ready(function () {
            customMode = false;
            $('input[name="products[]"]').prop('disabled', true);
            //$('input[name="manual_keyword"]').prop('disabled', true);
            $('.product-price').prop('readonly', true);
            $('#discount_amount').val(0.00);
            generateRandomProducts();
        });

        function generateRandomProducts(mode = 'initial') {
    customMode = false;
    $('input[name="products[]"]').prop('disabled', true);
    //$('input[name="manual_keyword"]').prop('disabled', true);
    $('.product-price').prop('readonly', true);

    $('#product-table-body').html(`
        <tr>
            <td colspan="8" class="text-center py-5">
                <div class="pacman-loader">
                    <div class="pacman"></div>
                    <div class="dots">
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                    </div>
                </div>
            </td>
        </tr>
    `);

    const priceFrom = $('#hidden_price_from_input_id').val();
    const priceTo = $('#hidden_price_to_input_id').val();
    const productCount = $('input[name="product_count"]').val(); // 🔥 New line
    const keyword = $('#keywordInput').val().trim();

    if (!customMode) {
        $.ajax({
            url: "{{ route('random.products') }}",
            type: 'GET',
            data: {
                site_id: SITE_ID,
                //invoice_amount: "{{ $invoice['invoice_amount'] ?? '' }}",
                invoice_amount: parseFloat($('#invoice_amount').val()) || 0,
                price_from: priceFrom,
                price_to: priceTo,
                product_count: productCount, // 🔥 New line
                search_query: keyword,

            },
            success: function (response) {
                $('#discount_amount').val(0.00);

                if (response.total === 0) {
                    $('#product-table-body').html(
                        '<tr><td colspan="8" class="text-center text-muted py-5">No results found. Try randomizing or use a different keyword.</td></tr>'
                    );
                    toastr.info("Oops! No magic combo this time. Try another spin or go custom!");
                    return;
                } else {



                    // const invoiceAmount = parseFloat("{{ $invoice['invoice_amount'] ?? 0 }}");
                    const invoiceAmount = parseFloat($('#invoice_amount').val()) || 0;
                    const currentAmount = parseFloat(response.total.toFixed(2));
                    const discountAmount = currentAmount - invoiceAmount;


                    //const modalCurrentAmount = parseFloat()

                    $('#product-table-body').html(response.tableRows);
                    $('#current_amount').val(currentAmount.toFixed(2));
                    $('#modal_current_amount').val(currentAmount.toFixed(2));

                    // 💥 Update Discount Amount also
                    if (discountAmount > 0) {
                        $('#discount_amount').val(discountAmount.toFixed(2));
                        $('#modal_discount_amount').val(discountAmount.toFixed(2));
                    } else {
                        $('#discount_amount').val(0.00);
                    }

                    if (response.is_random) {
                        $('.narayan-checkbox').prop('checked', true).prop('disabled', true);
                    } else {
                        $('.narayan-checkbox').prop('disabled', false);
                    }

                    validateAmounts();

                }
            },
            error: function () {
                toastr.error("Could not fetch random products.");
                $('#product-table-body').html(
                    '<tr><td colspan="8" class="text-center text-danger py-5">Failed to load products. Please try again.</td></tr>'
                );
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
    $('input[name="products[]"]').prop('disabled', false);
    $('input[name="manual_keyword"]').prop('disabled', false);
    $('.product-price').prop('readonly', false);
    $('#product-table-body').empty();
    selectedTotal = 0;
    updateTotalDisplay();
    attachCheckboxHandlers();
    $('#discount_amount').val(0.00);
    toastr.info('Now filter and pick your custom products.','Let’s begin!');

}


// function filterProducts() {
//     const keyword = $('#keywordInput').val().trim();
//     const priceFrom = $('#hidden_price_from_input_id').val();
//     const priceTo = $('#hidden_price_to_input_id').val();

//     // Don't fetch anything if both fields are empty
//     if (!keyword && !priceFrom && !priceTo) {
//         $('#product-table-body').html(
//             '<tr><td colspan="7" class="text-center text-muted">Please enter a keyword or price range to search.</td></tr>'
//         );
//         return;
//     }

//     // Insert the Pacman loader inside the table body
//     $('#product-table-body').html(`
//         <tr>
//             <td colspan="7" class="text-center py-5">
//                 <div class="pacman-loader">
//                     <div class="pacman"></div>
//                     <div class="dots">
//                         <div class="dot"></div>
//                         <div class="dot"></div>
//                         <div class="dot"></div>
//                         <div class="dot"></div>
//                         <div class="dot"></div>
//                     </div>
//                 </div>
//             </td>
//         </tr>
//     `);

//     $.ajax({
//         url: "{{ route('filter.products') }}",
//         type: 'GET',
//         data: {
//             keyword: keyword,
//             price_from: priceFrom,
//             price_to: priceTo
//         },
//         success: function (response) {
//             //alert(1);
//             $('#customize-product-table-body').html(response.tableRows);
//             selectedTotal = 0;
//             updateTotalDisplay();
//             attachCheckboxHandlers();

//             //==
//             if ($.fn.DataTable.isDataTable('#customize-products-table')) {
//                 $('#customize-products-table').DataTable().clear().destroy();
//                 $('#customize-products-table').empty(); // optional cleanup
//             }

//             const customizeTable = $('#customize-products-table').DataTable({
//                 responsive: true,
//                 searchHighlight: true,
//                 dom: 'lrtip', // removes built-in search bar
//                 language: {
//                     search: "",
//                     searchPlaceholder: "Search..."
//                 },
//                 columnDefs: [
//                     { orderable: false, targets: [4, 5] }
//                 ]
//             });

//             // 🔍 Custom search input functionality
//             $('#keywordInput').on('input', function () {
//                 customizeTable.search(this.value).draw();
//             });

//             //==
//         },
//         error: function () {
//             toastr.error('Something went wrong while filtering.', 'Oops!');
//             $('#product-table-body').html(
//                 '<tr><td colspan="7" class="text-center text-danger py-5">Failed to load products. Please try again.</td></tr>'
//             );
//         }
//     });
// }


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
// function clearAllProducts() {
//     $('#product-table-body').empty();
//     $('input[name="manual_keyword"]').val('');
//     $('#discount_amount').val('');
//     $('#current_amount').val('');
//     selectedTotal = 0;
//     updateTotalDisplay();
//     toastr.success('Your filter has been reset now', 'Filter Cleared');
// }
function clearAllProducts(button) {
    const icon = $(button).find('i');
    const originalIconClass = 'fa-filter-circle-xmark';
    icon.removeClass(originalIconClass).addClass('fa-spinner fa-spin');

    $.ajax({
        url: "{{ route('clear.products') }}",
        type: 'GET',
        success: function(response) {
            $('#product-table-body').empty();
            $('input[name="manual_keyword"]').val('');
            $('#discount_amount').val('');
            $('#current_amount').val('');
            $('#temp_current_amount_text').text('0.00');
            $('#temp_discount_amount_text').text('0.00');
            $('#temp_invoice_amount_text').text($('#invoice_amount').val());
            $('#product-table-body').html(getErrorRowHTML('Randomize filter cleared. You can now randomize products again or add custom products.', 9));
            toastr.success('Randomized products filter has been reset');
            updateTotalDisplay();


        },
        error: function(xhr, status, error) {
            icon.removeClass('fa-spinner fa-spin').addClass(originalIconClass);
            toastr.error(error , 'Error clearing randomized products');
        },
        complete: function() {
            icon.removeClass('fa-spinner fa-spin').addClass(originalIconClass);
        }
    });
}

</script>
<script>
    let filterTimer;

    $('#keywordInput, #hidden_price_from_input_id, #hidden_price_to_input_id').on('input change', function () {
        clearTimeout(filterTimer);
        //const isKeyword = $(this).attr('id') === 'keywordInput';
        filterTimer = setTimeout(() => {
            generateRandomProducts('random');
        }, 1500);
    });
</script>


<script>
    function gatherGameCaptureData() {
    const gameCaptureData = [];

    // Loop through all products and their respective platforms
    document.querySelectorAll('.platform-section').forEach(section => {
        const productId = section.getAttribute('data-product-id');
        const platform = section.getAttribute('data-platform');

        // Check if the platform section is visible and if fields are entered
        const fieldsData = {};

        section.querySelectorAll('input[type="text"]').forEach(input => {
            const fieldName = input.name.split('[').pop().split(']')[0]; // Extract the field name
            fieldsData[fieldName] = input.value;  // Store the input data
        });

        if (Object.keys(fieldsData).length > 0) {
            gameCaptureData.push({
                product_id: productId,
                platform: platform,
                fields: fieldsData
            });
        }
    });

    return gameCaptureData;
}
    function generateInvoice(event) {
        event.preventDefault();
        //const gameCaptureData = gatherGameCaptureData();

        // Now you can send this data to the server or process it further
        //console.log(gameCaptureData);

        const visibleProducts = $('input[name="product_ids[]"]:visible');
        const selectedProducts = $('input[name="product_ids[]"]:checked');
        const invoiceAmount = parseFloat($('#invoice_amount').val()) || 0;
        const current_amount = parseFloat($('#current_amount').val()) || 0;
        const discountAmount = parseFloat($('#discount_amount').val()) || 0;

        // if (selectedProducts.length === 0) {
        //     toastr.error('Please select your products combo...', 'No Product Selected');
        //     return;
        // }

        if (current_amount < invoiceAmount) {
            $('#current_amount').addClass('border border-danger');
                setTimeout(() => {
                    $('#current_amount').removeClass('border border-danger');
                }, 2000);
            toastr.error('Total is less than invoice amount.', 'Mismatch');
            return;
        }

        const expectedAmount = current_amount - discountAmount;
        const epsilon = 0.01;

        if (Math.abs(expectedAmount - invoiceAmount) > epsilon) {
            const diff = current_amount - invoiceAmount;
            const diffFixed = diff.toFixed(2);

            $('#discount_amount').addClass('border border-danger');
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

                // selectedProducts.each(function () {
                //     const productId = $(this).val();
                //     const unitPrice = $(`input[data-product-id="${productId}"]`).val();

                //     $('#generate-invoice-form').append($('<input>', {
                //         type: 'hidden',
                //         name: 'product_data[]',
                //         value: JSON.stringify({ product_id: productId, unit_price: unitPrice })
                //     }));
                // });

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




<script>
function handlePlatformChange(select) {
    const platform = select.value;
    const productId = select.getAttribute('data-product-id');

    document.querySelectorAll(`.platform-section[data-product-id="${productId}"]`).forEach(section => {
        section.style.display = 'none';
    });

    if (platform) {
        const selected = document.querySelector(`.platform-section[data-product-id="${productId}"][data-platform="${platform}"]`);
        if (selected) selected.style.display = 'block';
    }
}
</script>

{{-- Remove Row Script --}}
<script>
    function removeProductRow(index) {
        const mainRow = document.getElementById(`product-main-row-${index}`);
        const collapseRow = document.getElementById(`product-collapse-row-${index}`);

        if (mainRow) mainRow.remove();
        if (collapseRow) collapseRow.remove();
    }
</script>

<script>
    const slider = document.getElementById('customize-price-slider');

noUiSlider.create(slider, {
    start: [0, 500],
    connect: true,
    range: {
        'min': 10,
        'max': 1000
    }
});

slider.noUiSlider.on('update', function (values, handle) {
    $('#hidden_customize_price_from_input_id_modal').val(parseFloat(values[0]));
    $('#hidden_customize_price_to_input_id_modal').val(parseFloat(values[1]));
});
</script>

<script>
    let customizeProductsTimeout; // ⏳ for debounce

    function customizeProducts(search_type = 'search') {
        //const keyword = $('#keywordInput').val().trim();
        //const priceFrom = $('#hidden_customize_price_from_input_id_modal').val();
        //const priceTo = $('#hidden_customize_price_to_input_id_modal').val();
        const invoice_amount = parseFloat($('#invoice_amount').val()) || 0;
        const current_amount = parseFloat($('#current_amount').val()) || 0;

        const discountAmount = Math.max(0, current_amount - invoice_amount);

        // $('#temp_current_amount_text').text(current_amount.toFixed(2));
        // $('#temp_invoice_amount_text').text(invoice_amount.toFixed(2));
        // $('#temp_discount_amount_text').text(discountAmount.toFixed(2));

        if (!isNaN(current_amount) && current_amount > 0) {
            $('#temp_current_amount_text').text(current_amount.toFixed(2));
        }
        if (!isNaN(invoice_amount) && invoice_amount > 0) {
            $('#temp_invoice_amount_text').text(invoice_amount.toFixed(2));
        }
        if (!isNaN(discountAmount) && discountAmount > 0) {
            $('#temp_discount_amount_text').text(discountAmount.toFixed(2));
        }

        // Show temporary loading state in table
        $('#customize-product-table-body').html(getProductsSearchRowHTML());

        $.ajax({
            url: "{{ route('filter.products') }}",
            type: 'GET',
            data: {
                //keyword: keyword,
                //price_from: priceFrom,
                //price_to: priceTo,
                search_type: search_type
            },
            success: function (response) {
    if (response && response.tableRows && response.tableRows.trim() !== '') {
        $('#customize-product-table-body').html(response.tableRows);

        // Wait for DOM update
        setTimeout(function () {
            let customizeTable;

            if ($.fn.DataTable.isDataTable('#customize-products-table')) {
                $('#customize-products-table').DataTable().clear().destroy();
            }

            customizeTable = $('#customize-products-table').DataTable({
                responsive: true,
                searchHighlight: true,
                dom: 'lrtip', // removes built-in search bar
                language: {
                    search: "",
                    searchPlaceholder: "Search..."
                },
                columnDefs: [
                    { orderable: false, targets: [4, 5] }
                ]
            });

            // ✅ Custom search input functionality
            $('#modalkeywordInput').off('keyup').on('keyup', function () {
                customizeTable.search(this.value).draw();
            });

            // Calculate totals
            if (typeof calculateTotalPrice === 'function') {
                calculateTotalPrice();
            }
        }, 0); // ⏳ Use timeout to ensure DOM is ready
    } else {
        $('#customize-product-table-body').html(
            getErrorRowHTML('No matching products found. Please try a different keyword or adjust your price range.')
        );
    }
}
,
            error: function (xhr, status, error) {
                console.error('Ajax Error:', status, error);
                toastr.error('Failed to filter products. Please try again.', 'Error');
                $('#customize-product-table-body').html(
                    getErrorRowHTML('Failed to load products. Please refresh or try again.')
                );
            }
        });
    }

    // 🚀 Call customizeProducts() once when modal opens


    // 🚀 Debounce user typing to prevent too many Ajax requests
    $('#keywordInput').on('input', function () {
        clearTimeout(customizeProductsTimeout);
        customizeProductsTimeout = setTimeout(function () {
            generateRandomProducts();
        }, 500); // 500ms delay after user stops typing
    });
</script>

<script>
    $('#addgames').on('hidden.bs.modal', function () {
    if ($.fn.DataTable.isDataTable('#customize-products-table')) {
        $('#customize-products-table').DataTable().clear().destroy();
    }

    // Optional: Clear HTML rows to avoid leftover data
    $('#customize-product-table-body').empty();
});

</script>
<script>
    function validateAmounts() {
        const currentAmountInput = document.getElementById("current_amount");
        const discountAmountInput = document.getElementById("discount_amount");
        const invoiceAmountInput = document.getElementById("invoice_amount");

        const currentAmount = parseFloat(currentAmountInput.value) || 0;
        const discountAmount = parseFloat(discountAmountInput.value) || 0;
        const invoiceAmount = parseFloat(invoiceAmountInput.value) || 0;

        const expectedTotal = (invoiceAmount + discountAmount).toFixed(2);
        const currentTotal = currentAmount.toFixed(2);

        const isValid = expectedTotal === currentTotal;

        const color = isValid ? "green" : "red";

        currentAmountInput.style.color = color;
        discountAmountInput.style.color = color;
        invoiceAmountInput.style.color = color;
    }

    document.addEventListener("DOMContentLoaded", function () {
        // Set up listeners
        document.getElementById("current_amount").addEventListener("input", validateAmounts);
        document.getElementById("discount_amount").addEventListener("input", validateAmounts);
        document.getElementById("invoice_amount").addEventListener("input", validateAmounts);

        // Initial check
        validateAmounts();
    });
</script>




@endpush




