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
                            <button type="button" class="btn btn-outline-secondary btn-sm me-2" onclick="generateRandomProducts()">🎲 Randomize</button>
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="clearAllProducts()">🗑️ Clear</button>
                        </div>

                    </div>

                    <div class="card-body">
                        <!-- Search Filters -->
                        <form method="GET" action="#" class="mb-4">
                            <div class="row align-items-end g-3">
                                <div class="col-md-6">
                                    <label class="form-label">🔍 Keyword</label>
                                    <input type="text" name="manual_keyword" class="form-control" placeholder="Enter keyword">
                                </div>
                                <div class="col-md-6 text-center">
                                    <label class="form-label d-block">💰 Price Range</label>
                                    <div id="price-slider" class="w-100 mx-auto"></div>
                                    <input type="hidden" name="price_from" id="priceFrom">
                                    <input type="hidden" name="price_to" id="priceTo">
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary px-4">🔍 Search Products</button>
                                </div>
                            </div>
                        </form>
                        <!-- Combined Table -->
                        <div class="table-responsive border rounded">
                            <table class="table table-bordered table-sm align-middle mb-0" id="productTable">
                                <thead class="table-light">
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Unit Price</th>
                                        <th>Source</th>
                                        <th>Edit Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $current_total =0;
                                    @endphp

                                   @foreach($selectedProducts as $product)
                                   @php
                                    $current_total = $current_total + $product->unit_price;
                                    @endphp
                                    <tr data-source="custom">
                                        <td><input type="checkbox"></td>
                                        <td>{{ $product->id }}</td>
                                         <td><a href="#">{{ $product->name }}</a></td>
                                        <td>${{ number_format($product->unit_price, 2) }}</td>
                                        <td><span class="badge bg-success">Custom</span></td>
                                        <td><input type="number" class="form-control form-control-sm" value="{{ $product->unit_price }}"></td>
                                    </tr>
        
                                    @endforeach
                                    
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
                            <input type="text" class="form-control" value="{{ $current_total  ?? '00.00'}}" readonly>
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
   var priceSlider = document.getElementById('price-slider');

   noUiSlider.create(priceSlider, {
    start: [20, 1000],
    connect: true,
    step: 10,
    range: {
        'min': 20,
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
    const min = Math.round(values[0]);
    const max = Math.round(values[1]);
    minVal.textContent = min;
    maxVal.textContent = max;
    priceFrom.value = min;
    priceTo.value = max;
});

</script>

@endpush
