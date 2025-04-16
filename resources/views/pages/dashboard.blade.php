@extends('layouts.app')

@section('title', 'Dashboard | Central Invoice System')

@section('content')
    <div class="page">
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Start::page-header -->

                <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                    <div>
                        <h2 class="main-content-title fs-24 mb-1">Welcome To Dashboard</h2>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Central Invoice System</li>
                        </ol>
                    </div>
                    <div class="d-flex">
                        <div class="justify-content-center">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#generateReportModal" class="btn btn-primary my-2 btn-icon-text d-inline-flex align-items-center">
                                <i class="fe fe-download-cloud me-2 fs-14"></i> Download Report
                            </button>
                        </div>
                    </div>
                </div>

                <!-- End::page-header -->

                <!-- Start::row-1 -->
                <div class="row row-sm">
                    <div class="col-sm-12 col-lg-12 col-xl-12">
                        
                        <!-- Start::row -->
                        <div class="row row-sm">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="card-item">
                                            <div class="card-item-icon card-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5.93 6h-3.02c-.2-1.73-.8-3.3-1.64-4.47C16.37 4.28 18.05 5.87 17.93 8zM12 4.04c.84 1.07 1.44 2.64 1.64 4.47h-3.28c.2-1.83.8-3.4 1.64-4.47zM6.07 8c.12-2.13 1.8-3.72 3.66-4.47C8.8 4.7 8.2 6.27 8 8H6.07zM4.43 10h3.45c-.09.98-.14 1.98-.14 3s.05 2.02.14 3H4.43a8.056 8.056 0 0 1 0-6zm1.64 8h2.79c.31 1.19.76 2.27 1.33 3.18C7.16 20.9 5.65 19.6 6.07 18zM12 20c-.84-1.07-1.44-2.64-1.64-4.47h3.28c-.2 1.83-.8 3.4-1.64 4.47zm1.86-.82c.57-.91 1.02-1.99 1.33-3.18h2.79c.42 1.6-1.09 2.9-4.12 3.18zM16.12 16c.09-.98.14-1.98.14-3s-.05-2.02-.14-3h3.45a8.056 8.056 0 0 1 0 6h-3.45z"/>
                                            </svg>


                                            </div>
                                            <div class="card-item-title mb-2">
                                                <label class="main-content-label fs-13 fw-bold mb-1">Available Websites</label>
                                                  <p class="card-text">All Available Websites</p>
                                            </div>
                                            <div class="card-item-body">
                                                <div class="card-item-stat">
                                                    <h4 class="fw-bold">{{ getAllWebsites() }} </h4>
                                                    <a href="{{ route('connectedwebsites') }}" class="btn btn-sm btn-outline-primary mt-2">View
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                                    </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="card-item">
                                         <div class="card-item-icon card-icon">
                                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="24" width="24">
                                            <g>
                                                <rect fill="none" height="24" width="24"/>
                                                <g>
                                                <path fill="black" d="M20,6h-3V4c0-1.1-0.9-2-2-2h-6C7.9,2,7,2.9,7,4v2H4C2.9,6,2,6.9,2,8v12c0,1.1,0.9,2,2,2h16c1.1,0,2-0.9,2-2V8 C22,6.9,21.1,6,20,6z M9,4h6v2H9V4z M20,20H4V8h16V20z"/>
                                                </g>
                                            </g>
                                            </svg>


                                            </div>
                                            <div class="card-item-title mb-2">
                                                <label class="main-content-label fs-13 fw-bold mb-1">Business Models</label>
                                                <p class="card-text">All business models</p>
                                            </div>
                                            <div class="card-item-body">
                                                <div class="card-item-stat">
                                                    <h4 class="fw-bold">{{ getModelsCount() }}</h4>
                                                    <a href="{{ route('businessmodels') }}" class="btn btn-sm btn-outline-primary mt-2">View
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                                    </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="card-item">
                                           <div class="card-item-icon card-icon">
                                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="24" width="24">
                                            <g>
                                                <rect fill="none" height="24" width="24"/>
                                                <g>
                                                <path fill="black" d="M17,3H7C5.9,3,5,3.9,5,5v16l2-1.5L9,21l2-1.5L13,21l2-1.5L17,21l2-1.5l2,1.5V5C21,3.9,20.1,3,19,3H17z M17,9H7V7h10V9z M17,13H7v-2h10V13z M13,17H7v-2h6V17z"/>
                                                </g>
                                            </g>
                                            </svg>


                                            </div>
                                           
                                            <div class="card-item-title  mb-2">
                                                <label class="main-content-label fs-13 fw-bold mb-1">Invoices Created</label>
                                                <p class="card-text">All created invoices</p>
                                            </div>
                                            <div class="card-item-body">
                                                <div class="card-item-stat">
                                                    <h4 class="fw-bold">{{ count($invoices) }}</h4>
                                                    <a href="#listinvoices" class="btn btn-sm btn-outline-primary mt-2">View
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                                    </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="card-item">
                                           <div class="card-item-icon card-icon">
                                           <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path fill="black" d="M12 4c-4.41 0-8 3.59-8 8 0 1.82.62 3.49 1.64 4.83 1.43-1.74 4.9-2.33 6.36-2.33s4.93.59 6.36 2.33C19.38 15.49 20 13.82 20 12c0-4.41-3.59-8-8-8zm0 9c-1.94 0-3.5-1.56-3.5-3.5S10.06 6 12 6s3.5 1.56 3.5 3.5S13.94 13 12 13z"/>
                                            <path fill="black" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM7.07 18.28c.43-.9 3.05-1.78 4.93-1.78s4.51.88 4.93 1.78C15.57 19.36 13.86 20 12 20s-3.57-.64-4.93-1.72zm11.29-1.45c-1.43-1.74-4.9-2.33-6.36-2.33s-4.93.59-6.36 2.33C4.62 15.49 4 13.82 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8c0 1.82-.62 3.49-1.64 4.83zM12 6c-1.94 0-3.5 1.56-3.5 3.5S10.06 13 12 13s3.5-1.56 3.5-3.5S13.94 6 12 6zm0 5c-.83 0-1.5-.67-1.5-1.5S11.17 8 12 8s1.5.67 1.5 1.5S12.83 11 12 11z"/>
                                            </svg>

                                            </div>
                                           
                                            <div class="card-item-title  mb-2">
                                                <label class="main-content-label fs-13 fw-bold mb-1">User List</label>
                                                <p class="card-text">All admin and staff users</p>
                                            </div>
                                            <div class="card-item-body">
                                                <div class="card-item-stat">
                                                    <h4 class="fw-bold">{{ userCount() }}</h4>
                                                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-primary mt-2">View
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End::row -->

                        <!-- Start::row -->
                        <div class="row" >
                        <div class="col-sm-12 col-lg-12 col-xl-12">
                                    <div class="card custom-card overflow-hidden">
                                        <div class="card-header border-bottom-0">
                                            <div class="d-flex justify-content-between w-100">
                                                <h4 class="mb-1"> Invoice Generation Analytics</h4> 
                                            </div>
                                            <div class="d-flex justify-content-between w-100">
                                                <p class="text-muted mb-0" style="font-size: 14px;">
                                                    This chart shows invoice counts (red) and price changes counts (blue) over the last 7 days.
                                                </p>
                                            </div>
                                        <div class="card-body">
                                            <div id="invoicechart"></div>
                                        </div>
                                    </div>
                                </div>
                            
                            <div class="col-lg-12" id="listinvoices">
                                <div class="card custom-card mg-b-20 tasks">
                                <div class="card-body">
                                        <h4 class="mb-4">Invoice Generation History</h4>
                                        <div class="table-responsive">
                                            <table id="invoice-history" class="table table-bordered text-nowrap" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Invoice No</th>
                                                        <th>Model Type</th>
                                                        <th>Website</th>
                                                        <th>Discount Amount</th>
                                                        <th>Total Amount</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($invoices as $index => $invoice)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $invoice->invoice_number }}</td>
                                                            <td>{{ $invoice->model_type }}</td>
                                                            <td><a target="_blank" href="{{ $invoice->website->site_link }}">{{ $invoice->website->site_name }}</a></td>
                                                            <td>{{ $invoice->currency }} {{ number_format($invoice->discount_amount, 2) }} </td>
                                                            <td>{{ $invoice->currency }} {{ number_format($invoice->invoice_amount, 2) }}</td>
                                                            <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                            </div><!-- col end -->
                        </div>
                        <!-- End::row -->

                    </div><!-- col end -->

                    
                </div>
                <!-- End::row-1 -->

            </div>
        </div>
        <!-- End::app-content -->
    </div>
</div>

<div class="modal fade" id="generateReportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" 
     aria-labelledby="generateReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="generateReportModalLabel">Generate Invoice Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('invoice.report') }}" method="GET">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="business_model_id" class="form-label">Select Business Model</label>
                        <?php $models = getallModels(); ?>
                        <select name="business_model_id" id="business_model_id" class="form-select">
                            <option value="">-- Select Business Model --</option>
                            @foreach($models as $model)
                                <option value="{{ $model->id }}" {{ request()->business_model_id == $model->id ? 'selected' : '' }}>
                                    {{ $model->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="site_id" class="form-label">Select Site</label>
                        <select name="site_id" id="site_id" class="form-select">
                            <option value="all" {{ request()->site_id == 'all' ? 'selected' : '' }}>All Sites</option>
                            @foreach($sites as $site)
                                <option value="{{ $site->id }}" {{ request()->site_id == $site->id ? 'selected' : '' }}>
                                    {{ $site->site_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request()->start_date }}">
                    </div>

                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request()->end_date }}">
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">View Report</button>
                    <a href="{{ route('invoice.report', [
                        'generate_pdf' => true,
                        'business_model_id' => request()->business_model_id,
                        'site_id' => request()->site_id,
                        'start_date' => request()->start_date,
                        'end_date' => request()->end_date
                    ]) }}" class="btn btn-danger">Download PDF</a>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
@push('scripts')
<script>
    const invoiceDates = @json($dates);  // Common dates
    const invoiceCounts = @json($invoiceCounts);  // Invoice counts per date
    const priceChangeCounts = @json($priceChanges);  // Price change counts per date
    const siteCurrency = @json(site_currency());

    var options = {
        chart: {
            height: 350,
            zoom: { enabled: true },
            toolbar: { show: false }
        },
        series: [
            {
                name: "Invoices Created Count",
                type: 'line',  
                data: invoiceCounts,
                color: "#FF5733"
            },
            {
                name: "Price Changes Count",
                type: 'line',  
                data: priceChangeCounts,
                color: "#1E90FF"
            }
        ],
        xaxis: {
            categories: invoiceDates,  // Common dates for both series
            title: {
                text: 'Date',
                style: { fontWeight: 600 }
            }
        },
        yaxis: {
            title: {
                text: 'Counts',
                style: { fontWeight: 600, fontSize: '14px', color: '#333' }
            },
            min: 0,
            labels: {
                style: {
                    colors: '#666',
                    fontSize: '12px'
                }
            }
        },
        stroke: {
            curve: 'smooth',
            width: 4
        },
        markers: {
            size: 6,
            strokeColor: '#fff',
            strokeWidth: 3
        },
        grid: {
            borderColor: '#f1f1f1',
            row: {
                colors: ['#fff', '#f9f9f9'],
                opacity: 0.5
            }
        },
        tooltip: {
            theme: 'dark'
        }
    };

    var chart = new ApexCharts(document.querySelector("#invoicechart"), options);
    chart.render();
</script>



<script>
    $(document).ready(function () {
    $('#invoice-history').DataTable({
        responsive: true,
        dom: 'Bfrtip',  
        buttons: [
            'copy',      
            'csv',       
            'excel',     
            'pdf',        
            {
                extend: 'print',  
                text: 'Print Table'
            }
        ]
    });
});

</script>

@endpush
