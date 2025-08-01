<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <link href="https://fonts.cdnfonts.com/css/calibri-light" rel="stylesheet">
    <style>
        body {
            margin: 0px;
            padding: 0px;
        }
        @page {
            margin: 0px;
            padding: 0px;
        }
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
            font-family: 'Bahnschrift';
        }
        @font-face {
            font-family: 'Bahnschrift';
            src: url("{{ asset('fonts/BAHNSCHRIFT.TTF') }}");
        }

        table, th, td {
            border-collapse: collapse;
        }
        .table-heade {
            width: 100%;
            table-layout: fixed;
        }
        h5 span {
            font-size: 11px;
            font-family: Avenir;
            font-weight: bold;
            color: #000;
        }
        h5 {
            font-size: 11px;
            font-family: Avenir;
            font-weight: normal;
            color: #000;
        }
        td div {
            width: 100%;
            padding: 3px 0px;
            text-align: left;
            width: 246px !important;
        }
        .addrss h4 {
            font-size: 12px;
            font-family: 'Bahnschrift';
            font-weight: bold;
            color: #132028;
            text-align: left;
            margin-bottom: 5px;
        }
        .addrss p {
            font-size: 10px;
            font-family: 'Bahnschrift';
            font-weight: normal;
            color: #132028;
            text-align: left;
            padding: 3px 0px;
        }
        td h1 {
            font-family: 'Bahnschrift';
            font-size: 42px;
            font-weight: bold;
            color: #132028;
        }
        .table-list th {
            background: #132028;
            padding: 10px 10px;
            border: 0px solid #9de4d1;
            color: #d3e9e3f5;
            font-family: 'Bahnschrift';
            font-size: 10px;
            font-weight: bold;
        }
        .table-list td {
            border-bottom: 1px solid #9de4d1;
            padding: 10px 10px;
            background: #FFF;
            color: #132028;
            font-size: 9px;
            font-weight: normal;
            font-family: 'Bahnschrift';
        }
        .table-list :nth-child(1) {
            width: 39%;
        }
        .table-list th:nth-child(5) {
            text-align: right;
        }
        .table-list td:nth-child(3) {
            text-align: center;
        }
        .table-list td:nth-child(4) {
            text-align: center;
            width: 20%;
        }
        .table-list td:nth-child(5) {
            text-align: right;
        }
        .table-list div h6 {
            color: #132028;
            font-size: 10px;
            font-weight: bold;
            font-family: 'Bahnschrift';
        }
        .table-list p {
            color: #132028;
            font-size: 9px;
            font-weight: normal;
            font-family: 'Bahnschrift';
        }
        tfoot p {
            font-size: 8px;
            font-family: 'Bahnschrift';
            font-weight: bold;
            color: #E9FCF7;
            text-align: center;
        }
        table {
            background: #E9FCF7;
        }
    </style>

</head>
<body>
    <table width="800" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
        <tr>
            <td style="background-size: cover; height: 100%;">
                <table width="800" cellspacing="0" cellpadding="0" border="0"  style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                   <tbody>
                    <tr>
                        <td style="background: url('{{ $invoice_header_image }}') no-repeat; background-size:cover;padding: 66px 0px;">
                            
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px 60px 10px;">
                            <div>
                                <h1>INVOICE</h1>
                                <p style="font-family: 'Bahnschrift'; font-size: 11px; font-weight: normal; color: #132028;">Invoice no.{{ $invoice_number }}</p>
                            </div>
                        </td>
                     </tr>
                    <tr>
                        <td style="padding: 24px 60px;">
                            <table class="table-heade" style="width: 100%; border-bottom: 0px solid #0000004d;">
                               <tbody>
                                 
                                 <tr>
                                    <td class="addrss" style="width: 40%;">
                                        <h4>BILLED FROM:</h4>
                                        <p>{{ $customer_name }}</p>
                                        <p>{{ $customer_email }}</p>
                                    </td>
                                    <td class="addrss">
                                        <h4>Billed From:</h4>
                                        <p>{{ $site_name }}</p>
                                        <p>{!! $company_address !!}</p>
                                        <p>{{ $company_email }}</p>
                                        <p>{{ $company_mobile }}</p>
                                    </td>
                                    <td class="addrss" style="display: flex; flex-direction: column; text-align: right; align-items: flex-end;">
                                        <h4>DATE</h4>
                                        <p>{{ $invoice_date }}</p>
                                    </td>
                                 </tr>
                               </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0px 56px 50px; min-height: 650px;">
                          <table class="table-list" style="width: 100%;"> 
                            <tbody>
                                <tr>
                                    <th>Service</th>
                                    <th style="text-align: left;">Images</th>
                                    <th>Qty of Words</th>
                                    <th>Price</th>
                                    <th>Amount</th>
                                </tr>
                                @foreach($products as $product)
                                <tr>
                                    <td>
                                        <div>
                                            <h6>
                                                {{ $product->name }}
                                            </h6>
                                            <p>
                                            @if($product->quality)<span class="me-2 badge bg-light text-dark"><strong>Quality:</strong> {{ $product->quality }}</span>@endif
                                            @if($product->quantity)<span class="me-2 badge bg-light text-dark"><strong>Quantity:</strong> {{ $product->quantity }}</span>@endif
                                            @if($product->turnaround)<span class="me-2 badge bg-light text-dark"><strong>Turnaround Time:</strong> {{ $product->turnaround }}</span>@endif
                                            @if($product->delivery)<span class="me-2 badge bg-light text-dark"><strong>Delivery In:</strong> {{ $product->delivery }}</span>@endif<br>
                                            @if($product->project_title)<span class="me-2 badge bg-light text-dark"><strong>Project Title:</strong> {{ $product->project_title }}</span>@endif
                                            @if($product->subject)<span class="me-2 badge bg-light text-dark"><strong>Subject:</strong> {{ $product->subject }}</span>@endif
                                            @if($product->preferred_voice)<span class="me-2 badge bg-light text-dark"><strong>Preferred Voice:</strong> {{ $product->preferred_voice }}</span>@endif
                                            @if($product->preferred_writing_style)<span class="me-2 badge bg-light text-dark"><strong>Preferred Writing Style:</strong> {{ $product->preferred_writing_style }}</span>@endif
                                            @if($product->brand_name)<span class="me-2 badge bg-light text-dark"><strong>Brand Name:</strong> {{ $product->brand_name }}</span>@endif
                                            @if($product->audience)<span class="me-2 badge bg-light text-dark"><strong>Audience:</strong> {{ $product->audience }}</span>@endif
                                            @if($product->reference_link)
                                            <span class="me-2 badge bg-light text-dark"><strong>Reference link:</strong> 
                                                <a href="{{ $product->reference_link }}" target="_blank" class="text-primary text-decoration-underline">{{ $product->reference_link }}</a>
                                            </span>
                                            @endif
                                            @if($product->note)<span class="badge bg-light text-dark"><strong>Additional Note:</strong> {{ $product->note }}</span>@endif
                                            
                                            </p>
                                        </div>
                                    </td>
                                    <td>{{ $product->imagecount }}</td>
                                    <td>{{ $product->wordcount }}</td>
                                    <td>{{ site_currency() }} {{ number_format($product->unit_price, 2) }}</td>
                                    <td>{{ site_currency() }} {{ number_format($product->unit_price, 2) }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" style="border: 0px;">
                                        <div>
                                            <h6>Subtotal</h6>
                                        </div>
                                    </td>
                                    <td style="border: 0px; text-align: right;">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="border: 0px;">
                                        <div>
                                            <h6>Discount</h6>
                                        </div>
                                    </td>
                                    <td style="border: 0px; text-align: right;">{{ site_currency() }} {{ number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="border: 0px; background: #132028;color: #d3e9e3f5;font-size: 12px;font-weight: bold;    font-family: 'Bahnschrift';">
                                        <div>
                                            <h6 style="color: #d3e9e3f5;font-size: 12px;font-weight: bold;    font-family: 'Bahnschrift';">Total Due</h6>
                                        </div>
                                    </td>
                                    <td style="border: 0px; text-align: right;  background: #132028;color: #d3e9e3f5;font-size: 12px;font-weight: bold;    font-family: 'Bahnschrift';">{{ site_currency() }} {{ number_format($invoice_amount, 2) }}</td>
                                </tr>


                            </tbody>
                            
                          </table>
                        </td>
                    </tr>
                    
                   </tbody>
                   <tfoot style="position: absolute; bottom: 0px; width: 100%; height: 100px;">
                        <tr>
                            <td style="width: 100%; background: url('{{ $invoice_footer_image }}') no-repeat; background-size:contain;padding: 40px 0px 57px;">
                                <p style="text-align: center;">
                                    <div style="width: 340px !important; text-align: center; margin: auto;">
                                        <p style="padding-bottom: 5px;"> <strong></strong></p>
                                        <p>
                                           {!! $site->site_description !!}
                                        </p>
                                    </div>
                                </p>
                            </td>
                        </tr>
                   </tfoot>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
