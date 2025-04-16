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
                <a href="{{ url()->previous() }}" class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-arrow-left"></i> Go back to Site Selection
                </a>
                </div>
            </div>

            <!-- Page Header Close -->

            <div class="card custom-card">
                <div class="card-body shadow rounded">
                    <form method="GET" action="#">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Selected Website <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" 
                                    value="{{ $customer['site_name'] ?? 'N/A' }}" 
                                    readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Company Email</label>
                                <input type="text" class="form-control" 
                                    value="{{ $site->company_email ?? 'N/A' }}" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Invoice Number <span class="text-danger">*</span></label>
                                <input type="text" name="invoice_number" class="form-control font-italic" 
                                    value="{{ $invoice['invoice_number'] ?? '' }}" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Invoice Date</label>
                                <input type="date" name="invoice_date" class="form-control" 
                                    value="{{ $invoice['invoice_date'] ?? now()->toDateString() }}" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Invoice Amount <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ site_currency() }}</span>
                                    </div>
                                    <input name="invoice_amount" class="form-control" 
                                        value="{{ $invoice['invoice_amount'] ?? '' }}" 
                                        readonly type="number" readonly>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Customer Name</label>
                                <input type="text" class="form-control" 
                                    value="{{ $customer['customer_name'] ?? '' }}" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Customer Email</label>
                                <input type="email" class="form-control" 
                                    value="{{ $customer['customer_email'] ?? '' }}" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Customer Phone</label>
                                <input type="text" class="form-control" 
                                    value="{{ $customer['customer_mobile'] ?? '' }}" readonly>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
            <div class="card custom-card mt-4">
                <div class="card-body shadow rounded">
                    <div class="row ">
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Current Amount</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{ site_currency() }}  </span> 
                                </div>
                                <input type="number" id= "current_amount"  name="current_amount" class="form-control bg-white" value="{{ $current_total  ?? '00.00'}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Discount Amount</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{ site_currency() }}</span> 
                                </div>
                                <input type="number" name="discount_amount" id="discount_amount"  class="form-control bg-white" placeholder="Discount Amount" value="0">
                            </div>
                            
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Target Amount</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{ site_currency() }}  </span> 
                                </div>
                                <input type="number" name="final_amount" id="final_amount" class="form-control bg-white" placeholder="Target Total" value="{{ $invoice['invoice_amount'] ?? '' }}">
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
                        <button type="button" class="btn btn-outline-success">
                            <i class="bi bi-file-earmark-text"></i> Generate Invoice
                        </button>
                    </div>
                </div>


                <div class="card-body mt-1">
                    <!-- Search Filters -->
                    <form method="GET" action="#" class="mb-4">
                        <div class="row align-items-end g-3">
                        <div class="col-md-6">
                            <label for="keywordInput" class="form-label">Search for Products</label>
                            <input type="text" name="manual_keyword" id="keywordInput" class="form-control" placeholder="Type a keyword and wait for 1.5 seconds to apply the filter.">
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
                                <th>Select</th>
                                <th>Sr. No.</th>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Unit Price</th>
                                <th>filter</th>
                                <th>Total</th>
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

<form id="generate-invoice-form" method="POST" action="{{ route('generate.invoice') }}">
    @csrf
    <button form="generate-invoice-form" type="submit" class="d-none">Generate Invoice</button>
</form>

@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        generateRandomProducts('initial');
        $('input[name="product_ids[]"]').prop('disabled', true);
        $('input[name="manual_keyword"]').prop('disabled', true);
    });

    function generateRandomProducts(mode = 'initial') {
        $('input[name="product_ids[]"]').prop('disabled', true);
        $('input[name="manual_keyword"]').prop('disabled', true);
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

        $.ajax({
            url: '/random-products',
            type: 'GET',
            data: {
                site_id: "{{ $customer['site_id'] ?? '' }}" ,
                invoice_amount: "{{ $invoice['invoice_amount'] ?? '' }}",
                price_from: priceFrom,
                price_to: priceTo
            },
            success: function (response) {
                Swal.close();
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
    $('input[name="manual_keyword"]').prop('disabled', false);
    $('#product-table-body').empty();
    selectedTotal = 0;
    updateTotalDisplay();
    attachCheckboxHandlers();

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
        url: '/filter-products',
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
    $('input[name="product_ids[]"]').off('change').on('change', function () {

        let tempTotal = 0;
        $('input[name="product_ids[]"]:checked').each(function () {
            const productId = $(this).val();
            const price = $(`input[data-product-id="${productId}"]`).val();
            const unitPrice = parseFloat(price) || 0;
            tempTotal += unitPrice;
        });

        $('input[name="product_ids[]"]').each(function () {
            const row = $(this).closest('tr');
            if ($(this).is(':checked')) {
                row.addClass('table-active border border border-light');
            } else {
                row.removeClass('table-active border border border-light');
            }
        });

        if (tempTotal > maxAllowed) {
            toastr.error(`Product total exceeds your invoice target of $${invoiceAmount.toFixed(2)}`, 'Limit Reached');
        }

        selectedTotal = tempTotal;
        updateTotalDisplay();
    });

    // Listen for price changes and update total
    $('.product-price').on('input', function () {
        let tempTotal = 0;

        $('input[name="product_ids[]"]:checked').each(function () {
            const productId = $(this).val();
            const price = $(`input[data-product-id="${productId}"]`).val();
            const unitPrice = parseFloat(price) || 0;
            tempTotal += unitPrice;
        });

        if (tempTotal > maxAllowed) {
            toastr.error(`Product total exceeds your invoice target of $${invoiceAmount.toFixed(2)}`, 'Limit Reached');
        }

        selectedTotal = tempTotal;
        updateTotalDisplay();
    });
}



function updateTotalDisplay() {
    $('#current_amount').val(selectedTotal.toFixed(2));
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

    $('#min-val').text(`{{ site_currency() }}${min}`);
    $('#max-val').text(`{{ site_currency() }}${max}`);


    $('#hidden_price_from_input_id').val(min);
    $('#hidden_price_to_input_id').val(max);

    $('#hidden_price_from_input_id').trigger('input');
    $('#hidden_price_to_input_id').trigger('input');
});

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
        // Prevent the form from submitting
        event.preventDefault(); 

        const selectedProducts = $('input[name="product_ids[]"]:checked');
        const invoiceAmount = parseFloat($('#final_amount').val()) || 0;
        const current_amount = parseFloat($('#current_amount').val()) || 0;
        const discountAmount = parseFloat($('#discount_amount').val()) || 0;
        const finalAmount = parseFloat($('#final_amount').val()) || 0;

        if (selectedProducts.length === 0) {
            toastr.warning('Select combo products to match your invoice amount.', 'No Products Selected');
            return;
        }

        if (current_amount < invoiceAmount) {
            toastr.error('Total is less than invoice amount.', 'Mismatch');
            return;
        }

        if ((current_amount - discountAmount) !== finalAmount) {
            const diff = (current_amount - finalAmount).toFixed(2);
            
            if (discountAmount > diff) {
                toastr.error(`The discount amount of $${discountAmount} is more than the expected discount of $${diff}.`, 'Discount Too High');
            } else {
                toastr.error(`Please apply a discount of $${diff} to match the target amount.`, 'Give Discount');
            }
            return;
        }
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

        
        $('#generate-invoice-form').append($('<input>', {
            type: 'hidden',
            name: 'current_amount',
            value: current_amount.toFixed(2)  
        }));

        $('#generate-invoice-form').append($('<input>', {
            type: 'hidden',
            name: 'discount_amount',
            value: discountAmount.toFixed(2) 
        }));

        $('#generate-invoice-form').append($('<input>', {
            type: 'hidden',
            name: 'final_amount',
            value: finalAmount.toFixed(2)  
        }));

        $('#generate-invoice-form')[0].submit();

            Swal.fire({
            title: 'Preparing Invoice...',
            text: 'Please wait while we generate your invoice.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        setTimeout(() => Swal.close(), 3500);
    }
</script>

@endpush
