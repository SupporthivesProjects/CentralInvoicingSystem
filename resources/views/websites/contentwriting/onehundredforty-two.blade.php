<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <link href="https://fonts.cdnfonts.com/css/calibri-light" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #E9FCF7;
        }
        .footer-fixed {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: url('{{ $invoice_footer_image }}') center center no-repeat;
            background-size: cover;
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
       
    </style>

</head>
<body>
    <table width="800" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
        <tr>
            <td style="background-size: cover; height: 100%;">
                <table width="800" cellspacing="0" cellpadding="0" border="0"  style="border-collapse: collapse;">
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
                                 <td class="addrss" style="width: 40%; vertical-align: top;">
                                        <h4>Billed TO:</h4>
                                        <p style="font-size: 12px;">{{ $customer_name }}</p>
                                        <p style="font-size: 12px;">{{ $customer_email }}</p>
                                    </td>

                                    <td class="addrss">
                                        <h4>Billed From:</h4>
                                        <p style="font-size: 12px;">{{ $site_name }}</p>
                                        <p style="font-size: 12px;">{!! $company_address !!}</p>
                                        <p style="font-size: 12px;">{{ $company_email }}</p>
                                        <p style="font-size: 12px;">{{ $company_mobile }}</p>
                                    </td>
                                    <td class="addrss" style="display: flex; flex-direction: column; text-align: right; align-items: flex-end;">
                                        <h4>DATE</h4>
                                        <p style="font-size: 12px;">{{ $invoice_date }}</p>
                                    </td>
                                 </tr>
                               </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0px 56px 50px;">
                          <table class="table-list" style="width: 100%;"> 
                            <tbody>
                                <tr>
                                    <th style="text-align: left;font-size: 14px;">Service</th>
                                    <th style="text-align: left;font-size: 14px;">Images</th>
                                    <th style="font-size: 14px;">Qty of Words</th>
                                    <th style="font-size: 14px;">Price</th>
                                    <th style="font-size: 14px;">Amount</th>
                                </tr>
                                @php
                                    $totalRows = 10; 
                                    $productCount = count($products);
                                @endphp

                                @for($i = 0; $i < $totalRows; $i++)
                                    @if($i < $productCount)
                                        @php $product = $products[$i]; @endphp
                                        <tr>
                                            <td>
                                                <div>
                                                    <h4 style="font-size: 13px;">{{ $product->name }}</h4>
                                                    <p>
                                                        @if($product->quality)<span class="me-2 badge bg-light text-dark" style="font-size: 12px;"><strong>Quality:</strong> {{ $product->quality }}</span>@endif
                                                        @if($product->quantity)<span class="me-2 badge bg-light text-dark" style="font-size: 12px;"><strong>Quantity:</strong> {{ $product->quantity }}</span>@endif
                                                        @if($product->turnaround)<span class="me-2 badge bg-light text-dark" style="font-size: 12px;"><strong>Turnaround:</strong> {{ $product->turnaround }}</span>@endif
                                                        @if($product->delivery)<span class="me-2 badge bg-light text-dark" style="font-size: 12px;"><strong>Delivery:</strong> {{ $product->delivery }}</span>@endif
                                                        @if($product->project_title)<span class="me-2 badge bg-light text-dark" style="font-size: 12px;"><strong>Project Title:</strong> {{ $product->project_title }}</span>@endif
                                                        @if($product->note)<span class="badge bg-light text-dark" style="font-size: 12px;"><strong>Note:</strong> {{ $product->note }}</span>@endif
                                                    </p>
                                                </div>
                                            </td>
                                            <td style="font-size: 12px;">{{ $product->imagecount }}</td>
                                            <td style="font-size: 12px;">{{ $product->wordcount }}</td>
                                            <td style="font-size: 12px;">{{ site_currency() }} {{ number_format($product->unit_price, 2) }}</td>
                                            <td style="font-size: 12px;">{{ site_currency() }} {{ number_format($product->unit_price, 2) }}</td>
                                        </tr>
                                    @endif
                                @endfor
                                <tr>
                                    <td colspan="4" style="border: 0px;">
                                        <div>
                                            <h6 style="font-size: 14px; font-weight: 600; font-family: 'Bahnschrift'; margin: 0;">Subtotal</h6>
                                        </div>
                                    </td>
                                    <td style="border: 0px; text-align: right; font-size: 14px; font-weight: 500; font-family: 'Bahnschrift';">
                                        {{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="border: 0px;">
                                        <div>
                                            <h6 style="font-size: 14px; font-weight: 600; font-family: 'Bahnschrift'; margin: 0;">Discount</h6>
                                        </div>
                                    </td>
                                    <td style="border: 0px; text-align: right; font-size: 14px; font-weight: 500; font-family: 'Bahnschrift';">
                                        {{ site_currency() }} {{ number_format($discount_amount, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="border: 0px; background: #132028; color: #d3e9e3f5; font-size: 15px; font-weight: bold; font-family: 'Bahnschrift';">
                                        <div>
                                            <h6 style="color: #d3e9e3f5; font-size: 15px; font-weight: bold; font-family: 'Bahnschrift'; margin: 0;">Total Due</h6>
                                        </div>
                                    </td>
                                    <td style="border: 0px; text-align: right; background: #132028; color: #d3e9e3f5; font-size: 15px; font-weight: bold; font-family: 'Bahnschrift';">
                                        {{ site_currency() }} {{ number_format($invoice_amount, 2) }}
                                    </td>
                                </tr>


                            </tbody>
                            
                          </table>
                        </td>
                    </tr>
                    
                   </tbody>
                   <tfoot>
                    <tr>
                        <td style="display:none;"></td>
                    </tr>
                    <!-- Footer End -->   
                   </tfoot>
                </table>
            </td>
        </tr>
    </table>
    <!-- Footer absolutely fixed for PDF -->
    <div class="footer-fixed"></div>
</body>
</html>
