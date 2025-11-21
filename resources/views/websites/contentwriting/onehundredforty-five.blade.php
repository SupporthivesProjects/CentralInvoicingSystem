<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <link href="https://fonts.cdnfonts.com/css/calibri-light" rel="stylesheet">
    <style>
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
            font-family: 'Avenir';
        }
       
        table, th, td {
            border-collapse: collapse;
        }
        .table-heade{
            width: 100%;
            table-layout: fixed;
        }
        h5 span{
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
            padding: 0px 0px;
            /* background: #E9FCF7; */
            /* border: 1px solid #9de4d1; */
            padding: 3px 0px;
            text-align: center;
        } 
        .addrss h4{
            font-size: 11px;
            font-family: Avenir;
            font-weight: bold;
            color: #000;
            text-align: center;
        } 
        .addrss p{
            font-size: 11px;
            font-family: Avenir;
            font-weight: normal;
            color: #000;
            text-align: center;
        } 
        
        .addrss strong{
            font-size: 11px;
            font-family: Avenir;
            font-weight: bold;
            color: #000;
            text-align: center;
        } 
        .table-list th{
            /* background:#E9FCF7; */
        }
        .table-list th {
            /* background: #E9FCF7; */
            padding: 10px 10px;
            /* border: 1px solid #9de4d1; */
        }
        .table-list td{
            /* border: 1px solid #9de4d1; */
            padding: 10px 10px;
            font-size: 11px;
            font-family: Avenir;
            font-weight: normal;
            color: #000;
        }
        .table-list :nth-child(2){
            width: 62%;
        }
        .table-list :nth-child(1){
            width: 20%;
        }
        .table-list td:nth-child(3){
           text-align: right;
        }
        .table-list td:nth-child(4){
           text-align: right;
           width: 20%;
        }
        .table-list td:nth-child(5){
           text-align: right;
        }
        
        tfoot p{
            font-size: 11px;
            font-family: Avenir;
            font-weight: bold;
            color: #fff ;
            text-align: center;
        }
        
    </style>
</head>
<body>
    @php
        $minRows = 8; 
        $rowCount = count($products);
        $padRows = $minRows - $rowCount;
    @endphp
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
        <tr>
            <td style="background-size: cover; height: 100%;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0"  style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                   <tbody>
                    <tr>
                        <td style="background: url('{{ $invoice_header_image }}') no-repeat; background-size:cover;padding: 66px 0px;">
                            
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px 70px 0px 70px;">
                            <div style=" border: 1px solid #9de4d1; background: #E9FCF7;">
                                <h5><span>INVOICE </span> #: {{ $invoice_number }}	<span>DATE</span>: {{ $invoice_date }}</h5>
                            </div>
                        </td>
                     </tr>
                    <tr>
                        <td style="padding: 24px 50px;">
                            <table class="table-heade" style="width: 100%; border-bottom: 0px solid #0000004d;">
                               <tbody>
                                 
                                 <tr>
                                    <td class="addrss" style="vertical-align: top;">
                                        <h4>BILLED FROM:</h4>
                                        <p>{{ $site_name }}</p>
                                        <p>{!! $company_address !!}</p>
                                        <p><strong>Email</strong> {{ $company_email }}</p>
                                        <!-- <p><strong>Phone</strong>: {{ $company_mobile }}</p> -->
                                    </td>
                                    <td class="addrss" style="vertical-align: top;">
                                        <h4>BILLED TO:</h4>
                                        <p><strong>Name: </strong>{{ $customer_name }}</p>
                                        <!-- <p><strong>Email</strong> {{ $customer_name }}</p> -->
                                    </td>
                                 </tr>
                               </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0px 56px 50px">
                            <div style="height: 645px;">
                                <table class="table-list" style="width: 100%;"> 
                                    <tbody>
                                        <tr style="border: 1px solid #9de4d1; background: #E9FCF7;">
                                            <th style="border: 1px solid #9de4d1;">ITEM NO.</th>
                                            <th style="text-align: left; border: 1px solid #9de4d1;">DESCRIPTION</th>
                                            <th style="border: 1px solid #9de4d1;">QTY</th>
                                            <th style="border: 1px solid #9de4d1;">UNIT&nbsp;PRICE</th>
                                            <th style="border: 1px solid #9de4d1;">TOTAL</th>
                                        </tr>
                                        @foreach($products as $index => $product)
                                        <tr style="border: 1px solid #9de4d1; ">
                                            <td style="border: 1px solid #9de4d1;">{{ $index + 1 }}</td>
                                            <td style="text-align: left; border: 1px solid #9de4d1;"> {{ $product->name }}<br>
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

                                            </td>
                                            <td style="border: 1px solid #9de4d1;">1</td>
                                            <td style="border: 1px solid #9de4d1;">{{ site_currency() }} {{ number_format($product->unit_price, 2) }}</td>
                                            <td style="border: 1px solid #9de4d1;">{{ site_currency() }} {{ number_format($product->unit_price, 2) }}</td>
                                        </tr>
                                        @endforeach
                                        @for ($i = 0; $i < $padRows; $i++)
                                            <tr  style="border: 1px solid #9de4d1; ">
                                                <td  style="height: 40px;border: 1px solid #9de4d1;"></td>
                                                <td style="height: 40px;border: 1px solid #9de4d1;"></td>
                                                <td  style="height: 40px;border: 1px solid #9de4d1;"></td>
                                                <td style="height: 40px;border: 1px solid #9de4d1;"></td>
                                                <td style="height: 40px;border: 1px solid #9de4d1;"></td>
                                            </tr>
                                            @endfor
                                        <tr>
                                            <td colspan="3" style="border: 0px;"></td>
                                            
                                            <td style="border: 0px; text-align: right;">SUBTOTAL</td>
                                            <td style="border: 1px solid #9de4d1;">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</td>
                                        </tr>
                                    
                                        <tr>
                                            <td colspan="3" style="border: 0px;"></td>
                                            <td style="border: 0px; text-align: right;">DISCOUNT</td>
                                            <td style="border: 1px solid #9de4d1;">{{ site_currency() }} {{ number_format($discount_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="border: 0px;"></td>
                                            <td style="border: 0px; text-align: right;"><strong>TOTAL DUE</strong></td>
                                            <td style="border: 1px solid #9de4d1;"><strong>{{ site_currency() }} {{ number_format($invoice_amount, 2) }}</strong></td>
                                        </tr>


                                    </tbody>
                                    
                                </table>
                            </div>
                        </td>
                    </tr>
                    
                   </tbody>
                   <tfoot>
                        <tr>
                            <td style="width: 100%; background: url('{{ $invoice_footer_image }}') no-repeat; background-size:contain;padding: 50px 0px 90px;">
                                <p style="text-align: center;">THANK YOU FOR YOUR BUSINESS!</p>
                            </td>
                        </tr>
                   </tfoot>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
