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
                <div class="btn-group btn-group-sm" role="group" aria-label="Actions">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm" >
                    <i class="fas fa-arrow-left"></i> Go Back
                </a>

                <a href="{{ route('website.edit', ['id' => $site->id]) }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-edit"></i> Edit Website
                </a>

               
                </div>
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
                                    <span class="input-group-text" data-bs-toggle="modal" data-bs-target="#sitechangemodel"><i class="fas fa-sync-alt text-primary" style="cursor: pointer;"></i></span>
                                </div>
                                <input type="hidden" form="generate-invoice-form" name="site_id" id="site_id" class="form-control" value="{{ $customer['site_id'] }}" readonly>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Invoice Number <span class="text-danger">*</span> <span class="text-info">(Auto Generated)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
                                    <input type="text" form="generate-invoice-form" id="invoice_number" name="invoice_number" class="form-control font-italic" value="{{ $invoice['invoice_number'] ?? '' }}" placeholder="Invoice number will auto-generate">
                                     <span style="cursor: pointer;" class="input-group-text" id="copyInvoicenumber" title="Copy Invoice Number"><i class="fas fa-copy"></i></span>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Invoice Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" form="generate-invoice-form" name="invoice_date" class="form-control" value="{{ $invoice['invoice_date'] ?? now()->toDateString() }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" form="generate-invoice-form" class="form-control" id="customer_name" name="customer_name" value="{{ $customer['customer_name'] ?? '' }}" placeholder="Enter Customer Name">
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Customer Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" form="generate-invoice-form" class="form-control" id="customer_email" name="customer_email" value="{{ $customer['customer_email'] ?? '' }}"  placeholder="Enter Customer email">
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Customer Phone</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" form="generate-invoice-form" class="form-control" id="customer_mobile" name="customer_mobile" value="{{ $customer['customer_mobile'] ?? '' }}"  placeholder="Enter customer Mobile">
                                </div>
                            </div>
                        </div>



                    </form>
                </div>
            </div>
            <div class="card custom-card mt-4">
                <div class="card-body shadow rounded narayan-bg">
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
                            <span class="input-group-text" id="update_invoice_amount" style="cursor:pointer;"><i data-feather="edit" id="icon"></i></span> 
                        </div>
                    </div>
                </div>

                   
                </div>
            </div>

            <div class="card custom-card mt-4 border-1 rounded shadow">
                <div class="card-header bg-light border-bottom pb-3 d-flex flex-wrap justify-content-between align-items-center">
                    <h5 class="mb-2 mb-md-0"><i class="bi bi-funnel me-1"></i> Product Filter & Actions</h5>

                    <!-- Action Buttons Group -->
                    <div class="btn-group btn-group-sm" role="group" aria-label="Actions">
                        <button type="button" class="btn btn-outline-warning me-1" onclick="generateRandomProducts('random')">
                            <i class="bi bi-dice-5"></i> Random
                        </button>
                        <button type="button" class="btn btn-outline-danger me-1" onclick="clearAllProducts()">
                            <i class="bi bi-x-circle"></i> Clear All
                        </button>
                        <button type="button" class="btn btn-outline-success" onclick="generateInvoice(event)">
                            <i class="bi bi-receipt-cutoff"></i> Generate Invoice
                        </button>
                    </div>
                </div>

                <div class="card-body">
                
                    <div class="mb-4">
                        <div class="row g-3 align-items-end">
                        
                            <div class="col-md-6">
                                <label for="keywordInput" class="form-label text-center">Search Products by Keyword</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" class="form-control" name="manual_keyword" id="keywordInput" placeholder="Enter product or category name...">
                                    <button class="btn btn-outline-primary" type="button" id="applyfilter">Search</button>
                                </div>
                            </div>

                        
                            <div class="col-md-6">
                                <label class="form-label text-center">Filter by Price Range</label>
                                <div id="price-slider" class="w-100"></div>
                                <input type="hidden" name="price_from" id="hidden_price_from_input_id">
                                <input type="hidden" name="price_to" id="hidden_price_to_input_id">
                            </div>
                        </div>
                    </div>

                
                    <div class="table-responsive border rounded shadow-sm">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Select</th>
                                    <th>Category</th>
                                    <th>Product Name</th>
                                    <th>Unit Price</th>
                                    <th>Filter</th>
                                    <th>Modify Price</th>
                                </tr>
                            </thead>
                            <tbody id="product-table-body">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="sitechangemodel" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Select a Different Site</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form method="GET" action="{{ route('product.selection') }}" id="sitechangemodel-form">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="new_site_id" class="form-label">Choose a site</label>
                            <select form="sitechangemodel-form" name="new_site_id" id="new_site_id" class="form-select select2" required>
                                <option value="">-- Select Site --</option>
                                @foreach($sites as $s)
                                    <option value="{{ $s->id }}">{{ $s->site_name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <p class="text-muted small">Selecting another site will refresh the page to re-establish the database connection.</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" form="sitechangemodel-form" class="btn btn-primary">Change Site</button>
                    </div>
                </form>
            </div>
        </div>
   </div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace();
</script>
<script>
    $(document).ready(function() {
        $('html, body').animate({ scrollTop: 200 }, 500); 
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
    let filterTimer;
    $('#hidden_price_from_input_id, #hidden_price_to_input_id').on('input', function () {
        clearTimeout(filterTimer);
        filterTimer = setTimeout(() => {
            customMode ? filterProducts() : generateRandomProducts('random');
        }, 1500);
    });

       $('#applyfilter').on('click', function () {
            customMode = true;
            customMode ? filterProducts() : generateRandomProducts('random');
        });

        $('#keywordInput').on('keydown', function (event) {
            if (event.key === 'Enter') {
                customMode = true;
                customMode ? filterProducts() : generateRandomProducts('random');
            }
        });


</script>


<script>
    $(document).ready(function () {
        customMode = false;
        generateRandomProducts('initial');
        $('input[name="product_ids[]"]').prop('disabled', true);
        $('.product-price').prop('readonly', true);
        $('#discount_amount').val(0.00);
    });
    let isRequestInProgress = false;
    let requestTimeout = 1000; 

    function generateRandomProducts(mode = 'initial') {
        customMode = false;
        $('input[name="product_ids[]"]').prop('disabled', true);
        $('.product-price').prop('readonly', true);

        $('#product-table-body').html(getLoaderRowHTML());

        const priceFrom = $('#hidden_price_from_input_id').val();
        const priceTo = $('#hidden_price_to_input_id').val();
        if(!customMode){
        if (isRequestInProgress) return; 
        isRequestInProgress = true;
        var invoice_amount = parseFloat($('#invoice_amount').val()) || 0;

        $.ajax({
            url: "{{ route('random.products') }}",
            type: 'GET',
            data: {
                site_id: SITE_ID,
                invoice_amount: invoice_amount,
                price_from: priceFrom,
                price_to: priceTo
            },
            success: function (response) {
                Swal.close();
                $('#discount_amount').val(0.00);
                if (response.total === 0) {
                    $('#product-table-body').html(getErrorRowHTML('No results found. Try randomizing or use a different keyword.')); 
                    return;

                }else{

                    const invoiceAmount = parseFloat($('#invoice_amount').val()) || 0;
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
            },
            complete: function() {
                setTimeout(() => {
                    isRequestInProgress = false; 
                }, requestTimeout);
            }
        });
      }
    }
</script>

<script>
let selectedTotal = 0;
let customMode = false;
const invoiceAmount = parseFloat($('#invoice_amount').val()) || 0;
const SITE_ID = {{ session('customer.site_id') ?? 0 }};

function setCustomOnly() {
    customMode = true;
    $('input[name="product_ids[]"]').prop('disabled', false);
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

    if (!keyword && !priceFrom && !priceTo) {
        $('#product-table-body').html(getErrorRowHTML('No products found for your keyword. Try a different keyword or adjust the range filter.'));
        $('#error-row').fadeIn(300).delay(3000).fadeOut(500);
        return;
    }
    $('#product-table-body').html(getLoaderRowHTML());

    $.ajax({
        url: "{{ route('filter.products') }}",
        type: 'GET',
        data: {
            keyword: keyword,
            price_from: priceFrom,
            price_to: priceTo
        },
        success: function (response) {
            if (!response.tableRows) {
                $('#product-table-body').html(getErrorRowHTML('No products found for your keyword. Try a different keyword or adjust the range filter.'));
                $('#error-row').fadeIn(300).delay(3000).fadeOut(500);
                return;

                }else{

                    $('#product-table-body').html(response.tableRows);
                    selectedTotal = 0;
                    updateTotalDisplay();
                    attachCheckboxHandlers();
                    Swal.close();
                }

           
        },
        error: function () {
            toastr.error('Something went wrong while filtering.', 'Oops!');
            Swal.close();
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
        var invoice_amount = parseFloat($('#invoice_amount').val()) || 0;

        if (tempTotal > invoice_amount) {
            toastr.error(`Product total exceeds your invoice amount of $${invoice_amount.toFixed(2)}`, 'Limit Reached');
        }

        selectedTotal = tempTotal;
        updateTotalDisplay();
    });

    $('.product-price').on('input', function () {
        const tempTotal = calculateTotal();

        if (tempTotal > invoice_amount) {
            toastr.error(`Product total exceeds your invoice amount of $${invoice_amount.toFixed(2)}`, 'Limit Reached');
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
    function generateInvoice(event) {
        event.preventDefault();

        const invoiceInput = $('input[name="invoice_number"]');
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
        const maxBlinkCount = 30;
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
                if (!response.success || !response.new_invoice_number) {
                    Swal.close();
                    toastr.error('Failed to generate new invoice number', 'Error');
                    return;
                }

                invoiceInput.val(response.new_invoice_number);
                
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
                        toastr.options = { timeOut: 4000 };
                        toastr.success('Invoice is ready and will download shortly.', 'Completed');
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
    $('#sitechangemodel').on('shown.bs.modal', function () {
        $('#new_site_id').select2({
            dropdownParent: $('#sitechangemodel'),
            placeholder: "-- Select Site --",
            allowClear: true,
            width: '100%'
        });
       
    });

</script>
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
                    if(!customMode){
                            generateRandomProducts('random');
                        }
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


@endpush
