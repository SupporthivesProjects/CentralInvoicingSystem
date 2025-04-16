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
                            <button type="button" class="btn btn-primary my-2 btn-icon-text d-inline-flex align-items-center">
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
                                    <div class="card-body bg-success-gradient text-white">
                                        <div class="card-item">
                                            <div class="card-item-icon card-icon">
                                            <svg class="text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="24" width="24">
                                                <g>
                                                    <rect fill="white" height="24" width="24"/>
                                                    <g>
                                                    <path class="text-white" d="M12,2C6.5,2,2,6.5,2,12s4.5,10,10,10s10-4.5,10-10S17.5,2,12,2z M4,12c0-1,0.2-2,0.6-2.9l2.8,2.8L4,12z M12,20 c-1,0-2-0.2-2.9-0.6l2.8-2.8l2.8,2.8C14,19.8,13,20,12,20z M17.4,17.4l-2.8-2.8l2.8-2.8C17.8,10,18,11,18,12S17.8,14,17.4,17.4z M20,12c0-4.4-3.6-8-8-8c-0.5,0-1,0-1.5,0.1l2.9,2.9L20,12z"/>
                                                    </g>
                                                </g>
                                            </svg>

                                            </div>
                                            <div class="card-item-title mb-2">
                                                <label class="main-content-label fs-13 fw-bold mb-1">Connected Websites</label>
                                                  <p class="card-text">All connected websites</p>
                                            </div>
                                            <div class="card-item-body">
                                                <div class="card-item-stat">
                                                    <h4 class="fw-bold">{{ getAllWebsites() }} </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="card custom-card">
                                    <div class="card-body bg-success-gradient text-white">
                                        <div class="card-item">
                                         <div class="card-item-icon card-icon">
                                         <svg class="text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="24" width="24">
                                            <g>
                                                <rect fill="white" height="24" width="24"/>
                                                <g>
                                                <path d="M20,6h-3V4c0-1.1-0.9-2-2-2h-6C7.9,2,7,2.9,7,4v2H4C2.9,6,2,6.9,2,8v12c0,1.1,0.9,2,2,2h16c1.1,0,2-0.9,2-2V8 C22,6.9,21.1,6,20,6z M9,4h6v2H9V4z M20,20H4V8h16V20z"/>
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
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3">
                                <div class="card custom-card">
                                    <div class="card-body bg-success-gradient text-white">
                                        <div class="card-item">
                                           <div class="card-item-icon card-icon">
                                           <svg class="text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="24" width="24">
                                                <g>
                                                    <rect fill="white" height="24" width="24"/>
                                                    <g>
                                                    <path d="M17,3H7C5.9,3,5,3.9,5,5v16l2-1.5L9,21l2-1.5L13,21l2-1.5L17,21l2-1.5l2,1.5V5C21,3.9,20.1,3,19,3H17z M17,9H7V7h10V9z M17,13H7v-2h10V13z M13,17H7v-2h6V17z"/>
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
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3">
                                <div class="card custom-card">
                                    <div class="card-body  bg-success-gradient text-white">
                                        <div class="card-item">
                                           <div class="card-item-icon card-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24"
                                                    viewBox="0 0 24 24" width="24">
                                                    <path d="M0 0h24v24H0V0z" fill="white" />
                                                    <path
                                                        d="M12 4c-4.41 0-8 3.59-8 8 0 1.82.62 3.49 1.64 4.83 1.43-1.74 4.9-2.33 6.36-2.33s4.93.59 6.36 2.33C19.38 15.49 20 13.82 20 12c0-4.41-3.59-8-8-8zm0 9c-1.94 0-3.5-1.56-3.5-3.5S10.06 6 12 6s3.5 1.56 3.5 3.5S13.94 13 12 13z"
                                                        opacity=".3" />
                                                    <path
                                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM7.07 18.28c.43-.9 3.05-1.78 4.93-1.78s4.51.88 4.93 1.78C15.57 19.36 13.86 20 12 20s-3.57-.64-4.93-1.72zm11.29-1.45c-1.43-1.74-4.9-2.33-6.36-2.33s-4.93.59-6.36 2.33C4.62 15.49 4 13.82 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8c0 1.82-.62 3.49-1.64 4.83zM12 6c-1.94 0-3.5 1.56-3.5 3.5S10.06 13 12 13s3.5-1.56 3.5-3.5S13.94 6 12 6zm0 5c-.83 0-1.5-.67-1.5-1.5S11.17 8 12 8s1.5.67 1.5 1.5S12.83 11 12 11z" />
                                                </svg>
                                            </div>
                                           
                                            <div class="card-item-title  mb-2">
                                                <label class="main-content-label fs-13 fw-bold mb-1">User List</label>
                                                <p class="card-text">All admin and staff users</p>
                                            </div>
                                            <div class="card-item-body">
                                                <div class="card-item-stat">
                                                    <h4 class="fw-bold">{{ userCount() }}</h4>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End::row -->

                        <!-- Start::row -->
                        <div class="row">
                        <div class="col-sm-12 col-lg-12 col-xl-12">
                                    <div class="card custom-card overflow-hidden">
                                        <div class="card-header border-bottom-0">
                                            <div class="d-flex justify-content-between w-100">
                                                <div>
                                                    <label class="card-title"> Invoice Generation Analytics</label> 
                                                    <span class="d-block fs-12 mb-0 text-muted">
                                                        Here is the invoice generations history details chart
                                                    </span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="invoicechart"></div>
                                        </div>
                                    </div>
                                </div>

                            
                            <div class="col-lg-12">
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
                                                        <th>Site ID</th>
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
                                                            <td>{{ $invoice->site_id }}</td>
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
@endsection
@push('scripts')
<script>
    const invoiceDates = @json($dates);
    const invoiceCounts = @json($invoiceCounts);
    const totalSales = @json($totalSales);
    const discountAmounts = @json($discountAmounts);
    const siteCurrency = @json(site_currency());

    var options = {
        chart: {
            height: 350,            
            zoom: { enabled: true },
            toolbar: { show: false }
        },
        series: [
            {
                name: "Invoices Created",
                type: 'line',  
                data: invoiceCounts,
                color: "#FF5733",
                width: 10
            }
        ],
        xaxis: {
            categories: invoiceDates, 
            title: {
                text: 'Invoice Date',
                style: { fontWeight: 600 }
            }
        },
        plotOptions: {
            bar: {
                columnWidth: '20%',
                endingShape: 'rounded'
            }
        },
        yaxis: [
            {
              
                title: {
                    text: 'Invoices Created',
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
            {
                // Right side (amounts) — HIDE
                show: false
            }
        ],
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
