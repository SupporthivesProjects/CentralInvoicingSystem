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
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="card-item">
                                            <div class="card-item-icon card-icon">
                                                <svg class="text-primary" xmlns="http://www.w3.org/2000/svg"
                                                    enable-background="new 0 0 24 24" height="24"
                                                    viewBox="0 0 24 24" width="24">
                                                    <g>
                                                        <rect height="14" opacity=".3" width="14" x="5" y="5" />
                                                        <g>
                                                            <rect fill="none" height="24" width="24" />
                                                            <g>
                                                                <path
                                                                    d="M19,3H5C3.9,3,3,3.9,3,5v14c0,1.1,0.9,2,2,2h14c1.1,0,2-0.9,2-2V5C21,3.9,20.1,3,19,3z M19,19H5V5h14V19z" />
                                                                <rect height="5" width="2" x="7" y="12" />
                                                                <rect height="10" width="2" x="15" y="7" />
                                                                <rect height="3" width="2" x="11" y="14" />
                                                                <rect height="2" width="2" x="11" y="10" />
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="card-item-title mb-2">
                                                <label class="main-content-label fs-13 fw-bold mb-1">Connected Websites</label>
                                                
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
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="card-item">
                                            <div class="card-item-icon card-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24"
                                                    viewBox="0 0 24 24" width="24">
                                                    <path d="M0 0h24v24H0V0z" fill="none" />
                                                    <path
                                                        d="M12 4c-4.41 0-8 3.59-8 8 0 1.82.62 3.49 1.64 4.83 1.43-1.74 4.9-2.33 6.36-2.33s4.93.59 6.36 2.33C19.38 15.49 20 13.82 20 12c0-4.41-3.59-8-8-8zm0 9c-1.94 0-3.5-1.56-3.5-3.5S10.06 6 12 6s3.5 1.56 3.5 3.5S13.94 13 12 13z"
                                                        opacity=".3" />
                                                    <path
                                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM7.07 18.28c.43-.9 3.05-1.78 4.93-1.78s4.51.88 4.93 1.78C15.57 19.36 13.86 20 12 20s-3.57-.64-4.93-1.72zm11.29-1.45c-1.43-1.74-4.9-2.33-6.36-2.33s-4.93.59-6.36 2.33C4.62 15.49 4 13.82 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8c0 1.82-.62 3.49-1.64 4.83zM12 6c-1.94 0-3.5 1.56-3.5 3.5S10.06 13 12 13s3.5-1.56 3.5-3.5S13.94 6 12 6zm0 5c-.83 0-1.5-.67-1.5-1.5S11.17 8 12 8s1.5.67 1.5 1.5S12.83 11 12 11z" />
                                                </svg>
                                            </div>
                                            <div class="card-item-title mb-2">
                                                <label class="main-content-label fs-13 fw-bold mb-1">Business Models</label>
                                               
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
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-4">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="card-item">
                                            <div class="card-item-icon card-icon">
                                                <svg class="text-primary" xmlns="http://www.w3.org/2000/svg"
                                                    height="24" viewBox="0 0 24 24" width="24">
                                                    <path d="M0 0h24v24H0V0z" fill="none" />
                                                    <path
                                                        d="M12 4c-4.41 0-8 3.59-8 8s3.59 8 8 8 8-3.59 8-8-3.59-8-8-8zm1.23 13.33V19H10.9v-1.69c-1.5-.31-2.77-1.28-2.86-2.97h1.71c.09.92.72 1.64 2.32 1.64 1.71 0 2.1-.86 2.1-1.39 0-.73-.39-1.41-2.34-1.87-2.17-.53-3.66-1.42-3.66-3.21 0-1.51 1.22-2.48 2.72-2.81V5h2.34v1.71c1.63.39 2.44 1.63 2.49 2.97h-1.71c-.04-.97-.56-1.64-1.94-1.64-1.31 0-2.1.59-2.1 1.43 0 .73.57 1.22 2.34 1.67 1.77.46 3.66 1.22 3.66 3.42-.01 1.6-1.21 2.48-2.74 2.77z"
                                                        opacity=".3" />
                                                    <path
                                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z" />
                                                </svg>
                                            </div>
                                            <div class="card-item-title  mb-2">
                                                <label class="main-content-label fs-13 fw-bold mb-1">Invoices Created</label>
                                               
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
                text: 'Date',
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
