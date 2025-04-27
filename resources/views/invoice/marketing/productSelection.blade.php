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
                                <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" form="generate-invoice-form" class="form-control" id="customer_name" name="customer_name" value="{{ $customer['customer_name'] ?? '' }}" placeholder="Enter Customer Name">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="invoice_number" class="form-label">
                                    Invoice Number <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
                                    <input type="text" form="generate-invoice-form" id="invoice_number" name="invoice_number" class="form-control font-italic" value="{{ session('regenerate_invoice_number') ?? '' }}" placeholder="Enter or generate invoice number">
                                    <div class="btn-group">
                                            <button type="button" class="btn input-group-text dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="visually-hidden">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item py-1 px-3" href="#" id="generateInvoiceNumber"><i class="fas fa-sync-alt me-2"></i>Generate</a>
                                                </li>
                                                <li><a class="dropdown-item py-1 px-3" href="#" id="copyInvoicenumber"><i class="fas fa-copy me-2"></i>Copy</a>
                                                </li>
                                            </ul>
                                        </div>
                                </div>
                            </div>
                            
                           
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Invoice Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" form="generate-invoice-form" name="invoice_date" class="form-control" value="{{ $invoice['invoice_date'] ?? now()->toDateString() }}">
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
                            <input type="text" form="generate-invoice-form" id="current_amount" name="current_amount" class="form-control bg-white" value="{{ $current_total ?? '00.00' }}" readonly>
                            <span class="input-group-text" style="width: 40px;"><i class="fas fa-money-bill-wave"></i></span> 
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Discount Amount</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">{{ site_currency() }}</span>
                            <input type="number" form="generate-invoice-form" name="discount_amount" id="discount_amount" class="form-control bg-white" placeholder="Discount Amount" value="0">
                            <span class="input-group-text" style="width: 40px;"><i class="fas fa-tags"></i></span> 
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

            <div class="card custom-card mt-4 border-1 rounded shadow">
            <div class="card-header bg-white shadow-sm rounded-3 p-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-stars text-primary fs-4 me-2"></i>
                    <h4 class="mb-0 fw-semibold text-dark">Build Your Product & Invoice</h4>
                </div>

                <div class="btn-group btn-group-sm" role="group" aria-label="Actions">
                        <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-1 me-1" 
                                data-bs-toggle="modal" data-bs-target="#addmoreproducts" onclick="customizeProducts('onload')">
                                <i class="fas fa-plus-square"></i> Add Products
                        </button>

                        <button type="button" class="btn btn-outline-success d-flex align-items-center gap-1"
                                onclick="randomizeProducts()">
                                <i class="fas fa-random"></i> Randomize
                        </button>

                        <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1 me-1"
                                onclick="clearRandomizedFilter(this)">
                            <i class="fa-solid fa-filter-circle-xmark"></i>
                        </button>

                        <button type="button" class="btn btn-primary d-flex align-items-center gap-1 me-1"
                                onclick="generateInvoice(event)">
                            <i class="bi bi-receipt-cutoff"></i> Generate Invoice
                        </button>
                    </div>


            </div>

                <div class="card-body">
                
                    <div class="mb-4">
                    <div class="row justify-content-center g-3 align-items-end">
                        <div class="col-md-6">
                            <label class="form-label text-center w-100">Randomize by Price Range</label>
                            <div id="randomize-price-slider" class="w-100"></div>
                            <input type="hidden" name="price_from" id="hidden_randomize_price_from_input_id">
                            <input type="hidden" name="price_to" id="hidden_randomize_price_to_input_id">
                        </div>
                    </div>

                    </div>

                
                    <div class="table-responsive border rounded shadow-sm">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="table-dark">
                            <tr>
                                <th class="w-10 text-center">PID</th>
                                <th class="w-30">Package Name</th>
                                <th class="w-20 text-center">Subscription</th>
                                <th class="w-15 text-center">Unit Price</th>
                                <th class="w-25 text-center">Editable Price</th>
                                <th class="w-10 text-center">Remove</th>
                            </tr>
                            </thead>
                            <tbody id="randomize-product-table-body">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addmoreproducts" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header bg-white shadow-sm rounded-3 p-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="fas fa-sliders-h text-primary fs-4 me-2"></i>
                    <h5 class="modal-title fw-semibold text-dark mb-0" id="staticBackdropLabel1">
                        Customize Your Product Selection
                    </h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            
            <!-- Modal Body -->
            <div class="modal-body bg-white">
                <div class="container-fluid">
                    <div class="row g-3 mb-4 mx-4">
                            <div class="col-md-6 d-flex flex-column">
                                <label for="keywordInput" class="form-label text-center fw-semibold mb-2">Search By Keyword</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                                    <input type="text" class="form-control" id="keywordInput" placeholder="Enter or Speak product or category name...">
                                    <button class="btn btn-outline-secondary" type="button" onclick="startVoiceSearch()" id="micBtn" title="Voice Search">
                                        <i class="fas fa-microphone" id="micIcon"></i>
                                    </button>
                                    <button class="btn btn-outline-primary" type="button" onclick="customizeProducts('search')">Search</button>
                                </div>
                            </div>

                            <div class="col-md-6 d-flex flex-column">
                                <label class="form-label text-center fw-semibold mb-2">Search By Price</label>
                                <div class="align-items-center rounded bg-white shadow-sm">
                                    <div class="w-100" id="customize-price-slider"></div>
                                </div>
                                <input type="hidden" id="hidden_customize_price_from_input_id">
                                <input type="hidden" id="hidden_customize_price_to_input_id">
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="bg-light rounded border shadow-sm p-1 text-center">
                                    <div class="text-muted small fw-semibold">Current Amount</div>
                                    <div class="fw-bold text-success fs-5">{{ site_currency() }}<span id="temp_current_amount_text">0.00</span></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-light rounded border shadow-sm p-1 text-center">
                                    <div class="text-muted small fw-semibold">Discount Amount</div>
                                    <div class="fw-bold text-danger fs-5">{{ site_currency() }}<span id="temp_discount_amount_text">0.00</span></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-light rounded border shadow-sm p-1 text-center">
                                    <div class="text-muted small fw-semibold">Invoice Amount</div>
                                    <div class="fw-bold text-warning fs-5">{{ site_currency() }}<span id="temp_invoice_amount_text">0.00</span></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="table-responsive border rounded shadow-sm">
                            <table class="table table-bordered table-hover align-middle mb-0">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th class="w-10 text-center">PID</th>
                                        <th class="w-30">Package Name</th>
                                        <th class="w-20 text-center">Subscription</th>
                                        <th class="w-15 text-center">Unit Price</th>
                                        <th class="w-25 text-center">Editable Price</th>
                                        <th class="w-10 text-center">Select</th>
                                    </tr>
                                </thead>
                                <tbody id="customize-product-table-body">
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
            
            <div class="modal-footer bg-light border-top">
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeFilters()">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-danger" onclick="clearFilters()">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filters
                    </button>
                    <button type="button" id="add-custom-products" class="btn btn-primary">
                        <i class="bi bi-cart-plus me-1"></i> Add Selected to Cart
                    </button>
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
<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace();
</script>
<script>
    $(document).ready(function() {
        $('html, body').animate({ scrollTop: 200 }, 500); 
        $('#current_amount').val('loading...');
        $('#discount_amount').prop('type', 'text').val('loading...').prop('readonly', true);
    });
</script>
<script>
    const randomizePriceSlider = document.getElementById('randomize-price-slider');
    const customizePriceSlider = document.getElementById('customize-price-slider');
    const minUnitPrice = @json($min_unit_price);
    const maxUnitPrice = @json($max_unit_price);
    const currency = "{{ site_currency() }}";
    let inProgressRequests = [];

    const updateHiddenInputs = (min, max, type) => {
        if (type === 'randomize') {
            $('#hidden_randomize_price_from_input_id').val(min).trigger('input');
            $('#hidden_randomize_price_to_input_id').val(max).trigger('input');
        } else if (type === 'customize') {
            $('#hidden_customize_price_from_input_id').val(min).trigger('input');
            $('#hidden_customize_price_to_input_id').val(max).trigger('input');
        }
    };

    noUiSlider.create(randomizePriceSlider, {
        start: [minUnitPrice, maxUnitPrice],
        connect: true,
        step: 0.1,
        range: { min: minUnitPrice, max: maxUnitPrice },
        tooltips: [true, true],
        format: {
            to: v => `${currency}${Math.round(v)}`,
            from: v => Number(v.replace(currency, ''))
        }
    });

    noUiSlider.create(customizePriceSlider, {
        start: [minUnitPrice, maxUnitPrice],
        connect: true,
        step: 0.1,
        range: { min: minUnitPrice, max: maxUnitPrice },
        tooltips: [true, true],
        format: {
            to: v => `${currency}${Math.round(v)}`,
            from: v => Number(v.replace(currency, ''))
        }
    });

    updateHiddenInputs(minUnitPrice, maxUnitPrice, 'randomize');
    updateHiddenInputs(minUnitPrice, maxUnitPrice, 'customize');

</script>


<script>
    function randomizeProducts() {
        $('#randomize-product-table-body').html(getLoaderRowHTML());
        const priceFrom = $('#hidden_randomize_price_from_input_id').val();
        const priceTo = $('#hidden_randomize_price_to_input_id').val();

        $('#current_amount').val('Calculating...');
        $('#discount_amount').prop('type', 'text').val('Calculating...').prop('readonly', true);
        var invoice_amount = parseFloat($('#invoice_amount').val()) || 0;

        $.ajax({
            url: "{{ route('random.products') }}",
            type: 'GET',
            data: {
                site_id: "{{ $customer['site_id'] }}",
                invoice_amount: invoice_amount,
                price_from: priceFrom,
                price_to: priceTo
            },
            success: function (response) {
                Swal.close();
                $('#discount_amount').val(0.00);
                if (response.total === 0) {
                    $('#randomize-product-table-body').html(getErrorRowHTML(`Try again with Randomize or click 'Add Product' to add manually.`));
                    return;
                }
                else {
                    const invoiceAmount = parseFloat($('#invoice_amount').val()) || 0;
                    const currentAmount = parseFloat(response.total.toFixed(2));
                    $('#current_amount_text').text(currentAmount.toFixed(2));
                    $('#invoice_amount_text').text(invoiceAmount.toFixed(2));
                    $('#randomize-product-table-body').html(response.tableRows);
                    $('#current_amount').val(currentAmount.toFixed(2));
                    $('#discount_amount').prop('readonly', false).prop('type', 'number') 
                    $('#discount_amount').val((currentAmount - invoiceAmount).toFixed(2));
                    calculateTotalPrice();
                    replaceFeatherIconsTemporarily();
                }
            },
            error: function () {
                toastr.error("Could not fetch random products.");
                Swal.close();
            }
        });
    }

    randomizeProducts();
</script>

<script>
    let customizeSliderTimer;
    let randomizeSliderTimer;

    customizePriceSlider.noUiSlider.on('change', function (values) {
        clearTimeout(customizeSliderTimer);
        customizeSliderTimer = setTimeout(() => {
            const [min, max] = values.map(v => Math.round(parseFloat(v.replace(currency, ''))));
            updateHiddenInputs(min, max, 'customize');
            customizeProducts('search');
        }, 1500);
    });

    randomizePriceSlider.noUiSlider.on('change', function (values) {
        clearTimeout(randomizeSliderTimer);
        randomizeSliderTimer = setTimeout(() => {
            const [min, max] = values.map(v => Math.round(parseFloat(v.replace(currency, ''))));
            Swal.fire({
                title: 'Apply new price range?',
                text: 'This will reset your current filter settings.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Apply',
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
                    updateHiddenInputs(min, max, 'randomize');
                    randomizeProducts();
                } else {
                    randomizePriceSlider.noUiSlider.set([minUnitPrice, maxUnitPrice]);
                }
            });
        }, 1000);
    });
</script>


 <script>

        function customizeProducts(search_type='search') {
            const keyword = $('#keywordInput').val().trim();
            const priceFrom = $('#hidden_customize_price_from_input_id').val();
            const priceTo = $('#hidden_customize_price_to_input_id').val();
            let invoice_amount = parseFloat($('#invoice_amount').val()) || 0;
            let current_amount = parseFloat($('#current_amount').val()) || 0;

            let discountAmount = 0;
            if (current_amount > invoice_amount) {
                discountAmount = current_amount - invoice_amount;
            }

            $('#temp_current_amount_text').text(current_amount.toFixed(2));
            $('#temp_invoice_amount_text').text(invoice_amount.toFixed(2));
            $('#temp_discount_amount_text').text(discountAmount.toFixed(2));

            if (!keyword && !priceFrom && !priceTo) {
                $('#customize-product-table-body').html(getErrorRowHTML('No products found for your keyword. Try a different keyword or adjust the range filter.'));
                $('#error-row').fadeIn(300).delay(3000).fadeOut(500);
                return;
            }

            $('#customize-product-table-body').html(getProductsSearchRowHTML());

            $.ajax({
                url: "{{ route('filter.products') }}",
                type: 'GET',
                data: {
                    keyword: keyword,
                    price_from: priceFrom,
                    price_to: priceTo,
                    search_type : search_type
                },
                success: function (response) {
                    if (!response.tableRows) {
                        $('#customize-product-table-body').html(
                            getErrorRowHTML('No products found for your keyword. Try a different keyword or adjust the range filter.')
                        );
                        return;
                    }
                    $('#customize-product-table-body').html(response.tableRows);
                    calculateTotalPrice();
                },
                error: function () {
                    toastr.error('Something went wrong while filtering.', 'Oops!');
                }
            });
        }
</script>

<script>

function clearRandomizedFilter(button) {
    const icon = $(button).find('i');
    const originalIconClass = 'fa-filter-circle-xmark';
    icon.removeClass(originalIconClass).addClass('fa-spinner fa-spin');

    $.ajax({
        url: "{{ route('clear.products') }}",
        type: 'GET',
        success: function(response) {
            $('input[name="product_ids[]"]').prop('checked', false);
            $('.product-price').val('');
            $('#current_amount').val('0.00');
            $('#discount_amount').val('0.00');
            $('#temp_current_amount_text').text('0.00');
            $('#temp_discount_amount_text').text('0.00');
            $('#temp_invoice_amount_text').text($('#invoice_amount').val());
            $('#randomize-product-table-body').html(getErrorRowHTML('Randomize filter cleared. You can now randomize products again or add custom products.'));
            toastr.success('Randomized products filter has been reset');
            calculateTotalPrice();
            
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
    function generateInvoice(event) {
        event.preventDefault();

        const invoiceInput = $('input[name="invoice_number"]');
        const selectedProducts = $('input[name="product_ids[]"]:checked');
        const invoiceAmount = parseFloat($('#invoice_amount').val()) || 0;
        const currentAmount = parseFloat($('#current_amount').val()) || 0;
        const discountAmount = parseFloat($('#discount_amount').val()) || 0;

        if (selectedProducts.length === 0) {
            toastr.error('Please select your products combo...', 'No Product Selected');
            return;
        }

        if (currentAmount < invoiceAmount) {
            $('#current_amount').addClass('border border-danger');
            setTimeout(() => {
                $('#current_amount').removeClass('border border-danger');
            }, 2000);
            toastr.error('Total is less than invoice amount.', 'Mismatch');
            return;
        }

        const expectedAmount = currentAmount - discountAmount;
        const epsilon = 0.01;

        if (Math.abs(expectedAmount - invoiceAmount) > epsilon) {
            const diff = currentAmount - invoiceAmount;
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


        const invoiceNumber = invoiceInput.val().trim();
        if (!invoiceNumber) {
            toastr.error('Please enter your invoice number or generate one randomly.', 'Invoice Number Missing');
            let blinkCount = 0;
            const interval = setInterval(() => {
                invoiceNumber.toggleClass('border border-danger');
                blinkCount++;
                if (blinkCount >= 10) { 
                    clearInterval(interval);
                    invoiceNumber.removeClass('border border-danger');
                }
            }, 200);
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

        Swal.fire({
            title: 'Generating Invoice...',
            html: getPrinterLoaderRowHTML(6),
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            width: '334px',
            height: '280px',
            background: 'rgba(0, 0, 0, 0.1)',
            customClass: {
                popup: 'p-2 text-center',
                title: 'text-white'
            }
        });

        $('#generate-invoice-form')[0].submit();

        setTimeout(() => {
            Swal.close();
            toastr.success('Invoice is ready and will download shortly.', 'Completed');
        }, 20000);  
    }
</script>


<script>
    $(document).ready(function() {
    $('#generateInvoiceNumber').on('click', function() {
        toastr.info('Generating an invoice number for you...', 'Please wait');
        $.ajax({
            url: "{{ route('generate.invoice.number') }}", 
            method: 'GET',
            data: {
                site_name : "{{ $customer['site_name'] }}", 
            },
            success: function(response) {
                if (response.success && response.new_invoice_number) {
                    $('#invoice_number').val(response.new_invoice_number);
                    toastr.success('Invoice number generated successfully.', 'Success');
                } else {
                    toastr.error('Failed to generate invoice number.', 'Error');
                }
            },
            error: function() {
                toastr.error('There was an error generating the invoice number.', 'Error');
            }
        });
    });
});

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
                    randomizeProducts();
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
@endpush
