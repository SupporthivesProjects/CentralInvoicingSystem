@extends('layouts.app')

@section('title', 'Product Selection | Central Invoice System')

@section('content')

<div class="page">
    <div class="main-content app-content">
        <div class="container-fluid">
             <!-- Page Header -->
             <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Generate Invoice</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Product Selection</li>
                    </ol>
                </div>

                <div class="mt-3 mt-md-0">
                    <a href="your-cancel-url-or-js" class="btn btn-outline-danger btn-sm">
                        ❌ Cancel
                    </a>
                </div>
            </div>

            <!-- Page Header Close -->

            <div class="card custom-card">
                <div class="card-body">
                    <form method="GET" action="#"> {{-- route('products.query') --}}
                        @csrf
                        <!-- Row 1: Selected Website (Full Width) -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Selected Website <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" 
                                    value="{{ $customer['site_name'] ?? 'N/A' }}" 
                                    readonly>
                            </div>
                        </div>

                        <!-- Row 2: Invoice Amount, Invoice Number, Invoice Date -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Invoice Amount <span class="text-danger">*</span></label>
                                <input type="text" name="invoice_amount" class="form-control" 
                                    value="{{ $invoice['invoice_amount'] ?? '' }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Invoice Number <span class="text-danger">*</span></label>
                                <input type="text" name="invoice_number" class="form-control" 
                                    value="{{ $invoice['invoice_number'] ?? '' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Invoice Date</label>
                                <input type="date" name="invoice_date" class="form-control" 
                                    value="{{ $invoice['invoice_date'] ?? now()->toDateString() }}">
                            </div>
                        </div>

                        <!-- Row 3: Customer Details -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Customer Name </label>
                                <input type="text" class="form-control" 
                                    value="{{ $customer['name'] ?? '' }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Customer Email</label>
                                <input type="email" class="form-control" 
                                    value="{{ $customer['email'] ?? '' }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Customer Phone</label>
                                <input type="text" class="form-control" 
                                    value="{{ $customer['phone'] ?? '' }}" readonly>
                            </div>
                        </div>


                    </form>
                </div>
            </div>


            <div class="card custom-card mt-4 shadow-sm border-0">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">🛒 Add Products Manually</h5>
                    <div class="mb-3">
                        <button class="btn btn-outline-secondary btn-sm me-2" onclick="setCustomOnly()">Custom</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm me-2" onclick="generateRandomProducts('random')">🎲 Randomize</button>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="clearAllProducts()">🗑️ Clear</button>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Search Filters -->
                    <form method="GET" action="#" class="mb-4" onsubmit="applyFilter(event)">
                        <div class="row align-items-end g-3">
                            <div class="col-md-6">
                                <label class="form-label">🔍 Keyword</label>
                                <input type="text" name="manual_keyword" id="keywordInput" class="form-control" placeholder="Enter keyword">
                            </div>

                            <div class="col-md-6 text-center">
                                <label class="form-label d-block">💰 Price Range</label>
                                <div id="price-slider" class="w-100 mx-auto"></div>
                                <input type="hidden" name="price_from" id="hidden_price_from_input_id">
                                <input type="hidden" name="price_to" id="hidden_price_to_input_id">
                            </div>
                        </div>
                    </form>

                    <!-- Combined Table -->
                    <div class="table-responsive border rounded">
                    <table class="table table-bordered table-hover table-striped align-middle shadow-sm rounded" id="productTable">
                            <thead class="table-light">
                            <tr>
                                <th>Select</th>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Unit Price ($)</th>
                                <th>Source</th>
                                <th>Edit Price</th>
                            </tr>
                            </thead>
                            <tbody id="product-table-body">
                                <!-- Injected by AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card custom-card mt-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Target Value</label>
                            <input type="text" class="form-control" value="{{ $invoice['invoice_amount'] ?? 'N/A' }}"  readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Current Value</label>
                            <input type="text" id= "current_total" class="form-control" value="{{ $current_total  ?? '00.00'}}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Discount</label>
                            <input type="number" name="discount" class="form-control" placeholder="Enter Discount Amount">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Final Value</label>
                            <input type="number" name="finalvalue" class="form-control" placeholder="Enter Final Amount">
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <form method="POST" action="#"> {{-- route('invoice.generate') --}}
                    @csrf
                    <button type="submit" class="btn btn-success">Generate Invoice</button>
                </form>
            </div>
            <br>
        </div>
    </div>
</div>

{{-- Range Slider Script --}}


@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        generateRandomProducts('initial');
        $('input[name="product_ids[]"]').prop('disabled', true);
    });

    function generateRandomProducts(mode = 'initial') {
        $('input[name="product_ids[]"]').prop('disabled', true);
        let title = (mode === 'initial') ? 'Cooking Up Combos...' : 'Trying Cool Combos...';
        let loadingText = (mode === 'initial') 
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


        $.ajax({
            url: '/random-products',
            type: 'GET',
            data: {
                site_id: "{{ $customer['site_id'] ?? '' }}" ,
                invoice_amount: "{{ $invoice['invoice_amount'] ?? '' }}",
            },
            success: function (response) {
                $('#product-table-body').html(response.tableRows);
                $('#current_total').val(response.total.toFixed(2));
                Swal.close();
                if (response.total === 0) {
                    toastr.info("Oops! No magic combo this time. Try another spin or go custom!");
                    return;
                }
            },
            error: function () {
                toastr.error("Could not fetch random products.");
                Swal.close();
            }
        });
    }
</script>


<script>
    const INVOICE_TOTAL = parseFloat('{{ $invoice["invoice_amount"] ?? 0 }}');
    const SITE_ID = {{ session('customer.site_id') ?? 0 }};
</script>
<script>
let selectedTotal = 0;
let customMode = false;
const invoiceAmount = INVOICE_TOTAL;
const maxAllowed = invoiceAmount * 1.02;

// Triggered when custom button is clicked
function setCustomOnly() {
    customMode = true;
    $('input[name="product_ids[]"]').prop('disabled', false);
    $('#product-table-body').empty();
    selectedTotal = 0;
    updateTotalDisplay();

    Swal.fire({
        icon: 'info',
        title: 'Let’s Begin!',
        text: 'Now filter and pick your custom products.',
        timer: 1500,
        showConfirmButton: false
    });
}


function filterProducts() {
    const keyword = $('#keywordInput').val().trim();
    const priceFrom = $('#hidden_price_from_input_id').val();
    const priceTo = $('#hidden_price_to_input_id').val();

    // Don't fetch anything if both fields are empty
    if (!keyword && (!priceFrom || !priceTo)) {
        $('#product-table-body').html(
            '<tr><td colspan="6" class="text-center text-muted">Please enter a keyword or price range to search.</td></tr>'
        );
        return;
    }

    Swal.fire({
        title: 'Filtering...',
        html: 'Looking for matching products 🧠',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    $.ajax({
        url: '/filter-products',
        type: 'GET',
        data: {
            keyword: keyword,
            price_from: priceFrom,
            price_to: priceTo,
            site_id: SITE_ID
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
    $('input[name="product_ids[]"]').off('change').on('change', function () {
        const row = $(this).closest('tr');
        const price = parseFloat(row.find('.product-price').val()) || 0;

        // Recalculate fresh total from all checked items
        let tempTotal = 0;
        $('input[name="product_ids[]"]:checked').each(function () {
            const p = parseFloat($(this).closest('tr').find('.product-price').val()) || 0;
            tempTotal += p;
        });

        // Check if new total exceeds allowed limit
        if (tempTotal > maxAllowed) {
            $(this).prop('checked', false); // undo the check
            toastr.info(`Product total exceeds your invoice target of $${invoiceAmount.toFixed(2)}`, 'Limit Reached');
        } else {
            selectedTotal = tempTotal;
            updateTotalDisplay();
        }
    });
}



function updateTotalDisplay() {
    $('#current_total').val(selectedTotal.toFixed(2));
}

function controlCheckboxLimit() {
    const checkboxes = $('input[name="product_ids[]"]');
    const unchecked = checkboxes.not(':checked');

    if (selectedTotal >= invoiceAmount && selectedTotal <= maxAllowed) {
        unchecked.prop('disabled', true);
    } else {
        checkboxes.prop('disabled', false);
    }
}
</script>


  
<script>
   var priceSlider = document.getElementById('price-slider');

   noUiSlider.create(priceSlider, {
    start: [10, 1000],
    connect: true,
    step: 10,
    range: {
        'min': 10,
        'max': 1000
    },
    tooltips: [true, true], // 👈 This enables tooltips above both handles
    format: {
        to: value => `$${Math.round(value)}`,
        from: value => Number(value.replace('$', ''))
    }
});


const minVal = document.getElementById('min-val');
const maxVal = document.getElementById('max-val');
const priceFrom = document.getElementById('priceFrom');
const priceTo = document.getElementById('priceTo');

priceSlider.noUiSlider.on('update', function (values) {
    const min = Math.round(parseFloat(values[0].replace('$', '')));
    const max = Math.round(parseFloat(values[1].replace('$', '')));

    $('#min-val').text(`$${min}`);
    $('#max-val').text(`$${max}`);

    $('#hidden_price_from_input_id').val(min);
    $('#hidden_price_to_input_id').val(max);

    // Optional: trigger input/change event if needed
    $('#hidden_price_from_input_id').trigger('input');
    $('#hidden_price_to_input_id').trigger('input');
});



</script>
<script>
    // Debounce filtering by 2 seconds after typing or slider change
    let filterTimer;

    $('#keywordInput, #hidden_price_from_input_id, #hidden_price_to_input_id').on('input change', function () {
    if (!customMode) return;

    clearTimeout(filterTimer);
    filterTimer = setTimeout(() => {
        filterProducts();
    }, 1500);
});
    </script>

@endpush
