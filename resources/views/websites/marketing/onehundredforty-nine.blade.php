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
            font-family: Calibri;
        }
        @font-face {
            font-family: 'Calibri';
            src: url("{{ asset('fonts/calibri-regular.ttf') }}") format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'Calibri';
            src: url("{{ asset('fonts/calibri-bold.ttf') }}") format('truetype');
            font-weight: bold;
            font-style: normal;
        }

        .table-td-p p{
            font-family: arial;
            font-size: 9px;
            margin: 0px;
            font-weight: 400;
            color: red;
        }
        table, th, td {
            border-collapse: collapse;
        } 
        th {
            padding: 12px 39px;
            background: #000;
            color: #fff;
            font-family: 'Calibri';
            font-size: 16px;
            font-weight: bold;
        }
        .table-main td h5{
            font-size: 12px;
            font-family: 'Calibri';
            font-weight: bold;
            color: #000000b5;
        }
        .table-main td h6{
            font-size: 12px;
            font-family: 'Calibri';
            font-weight: bold;
            color: #000;
        }
        .table-main td h4{
            font-size: 16px;
            font-weight: bold;
            color: #00000078;
        }
        .table-main td p{
            font-size: 9px;
            font-family: 'Calibri';
            font-weight: bold;
            color: #0000008a;
        }
        .table-main td{
            padding: 13px 12px;
        }
       .table-main tr:nth-child(odd) {
            background-color: plum;
        }
        .table-main td{
            text-align: center;
        }
        .table-main td div p {
            text-align: left;
        }
        .table-main th:last-child {
           text-align: right;
           padding: 0px 14px 0px 62px;
        }
        .table-main td:last-child {
           text-align: right;
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
                        <td style="background: url('{{ $invoice_header_image }}') no-repeat; background-size: cover; background-position:  center center; padding: 108px 0px;">

                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 24px 54px;">
                            <h2 style="font-family: 'Calibri';font-size: 36px; font-weight: bold; line-height:normal; color: #000000b5;">INVOICE</h2>
                            <table style="border-bottom: 1px solid #0000004d;">
                                <tbody>
                                    <tr>
                                        <td style="width: 60%;">
                                            <div>
                                                <h5 style="font-family: 'Calibri';font-size: 9px; line-height: normal;color: grey;padding: 5px 0px 5px;">Invoice No : #{{ $invoice_number }}</h5>
                                                <h5 style="width: 156px; font-family: 'Calibri';font-size: 9px; line-height: normal;color: grey;padding: 0px 0px 13px;border-bottom: 1px solid #00000080;;">Due Date : {{ $invoice_date }}</h5>
                                                <div>
                                                    <h5 style="font-family: 'Calibri';font-size: 10px; line-height: normal;color: grey;padding: 6px 0px;">Total Amount Due</h5>
                                                    <h3  style="font-family: 'Calibri';font-size: 22px; font-weight: bold; line-height:normal; color: #000000b5;">{{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}</h3>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width:45%;">
                                            <div>
                                                <h5 style="font-family: 'Calibri';font-size: 10px; line-height: normal;color: grey; font-weight: bold;">Invoice To</h5>
                                                <h4 style="font-family: 'Calibri';font-size: 12px; line-height: normal;color: #000000b5; font-weight: bold; padding: 8px 0px 0px;">{{ $customer_name }}</h4>
                                                <p style="font-family: 'Calibri';font-size: 9px; line-height: normal;color: grey; padding: 8px 0px; line-height: 14px;">
                                                    {{ $customer_email }}<br>
                                                   
                                                </p>
                                            </div>
                                        </td>
                                        <td style="width: 30%;">
                                            <div>
                                                <h5 style="font-family: 'Calibri';font-size: 10px; line-height: normal;color: grey; font-weight: bold;">Invoice From</h5>
                                                <h4 style="font-family: 'Calibri';font-size: 12px; line-height: normal;color: #000000b5; font-weight: bold; padding: 8px 0px 0px;">{{ $site_name }}</h4>
                                                <p style="font-family: 'Calibri';font-size: 9px; line-height: normal;color: grey;padding: 8px 0px; line-height: 14px;">
                                                    {{ $company_email }}<br>
                                                    {{ $company_mobile  }}<br>
                                                    {!! $company_address !!}

                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 2rem;"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0px 50px 24px;">
                        <div style="min-height: 550px !important;">
                           <table class="table-main">
                            <tbody>
                                <tr>
                                    <th>SERVICE TYPE</th>
                                    <th>QTY</th>
                                    <th>LENGTH</th>
                                    <th>BILLING CYCLE</th>
                                    <th>TOTAL</th>
                                </tr>
                                @foreach($products as $product)
                                <tr>
                                    <td>
                                       <div>
                                          <h5>{{ $product->name }}</h5>
                                       </div> 
                                    </td>
                                    <td>
                                        <p> 1</p>
                                    </td>
                                    <td>
                                        <p>{{ $product->subscription ?? '-' }}</p>
                                    </td>
                                    <td>
                                        <p>One Time</p>
                                    </td>
                                    <td>
                                        <p>{{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</p>
                                    </td>
                                </tr>
                                @endforeach
                                <tr style="background: transparent;">
                                    <td colspan="3" style="padding: 0px 12px;"></td>
                                    <td style="padding: 0px 12px;">
                                        <p>Sub Total</p>
                                    </td>
                                    <td style="padding: 0px 12px;">
                                        <p>{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}</p>
                                    </td>
                                </tr>
                                <tr style="background: transparent;">
                                    <td colspan="3" style="padding: 0px 0px;"></td>
                                    <td style="padding: 0px 12px;">
                                        <p>Discount</p>
                                    </td>
                                    <td style="padding: 0px 12px;">
                                        <p>{{ site_currency() }} {{ number_format($discount_amount ?? 0, 2) }}</p>
                                    </td>
                                </tr>
                               
                                <tr style="background: transparent;">
                                    <td colspan="3" style="padding: 0px 0px;"></td>
                                    <td style="padding: 10px 12px;border-top: 1px solid #000;">
                                        <h4>GRAND TOTAL</h4>
                                    </td>
                                    <td style="padding: 10px 12px;border-top: 1px solid #000;">
                                        <h4>{{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}</h4>
                                    </td>
                                </tr>
                            </tbody>
                           </table>
                        </div>
                        </td>
                    </tr>
                    <tr>
                        
                    </tr>
                   </tbody>
                   <tfoot>
                        <tr>
                            <td style="background: url('{{ $invoice_footer_image }}') no-repeat; background-size:cover;padding: 35px 0px;">
                                
                            </td>
                        </tr>
                   </tfoot>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
