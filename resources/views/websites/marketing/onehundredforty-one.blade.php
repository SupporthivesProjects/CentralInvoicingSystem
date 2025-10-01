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
            font-family: 'Mazzard';
        }
        @font-face {
            font-family: 'Mazzard';
            src: url("{{ asset('fonts/MazzardH-Black.otf') }}");
        }
        @font-face {
            font-family: 'Mazzard';
            src: url("{{ asset('fonts/mazzard-m-regular.otf') }}");
        }
        @font-face {
            font-family: 'Mazzard M';
            src: url("{{ asset('fonts/mazzard-m-bold.otf') }}");
        }
        @font-face {
            font-family: 'centurygothic';
            src: url("{{ asset('fonts/centurygothic.ttf') }}");
        }
        @font-face {
            font-family: 'centurygothic';
            src: url("{{ asset('fonts/centurygothic_bold.ttf') }}");
        }

       
        table, th, td {
            border-collapse: collapse;
        }
        .table-heade{
            width: 100%;
            table-layout: fixed;
        }
        table td h2{
            font-family: 'Mazzard M';
            font-size: 24px;
            color: #ffffff;
            font-weight: bold;
            letter-spacing: 0px;
        }
        .table-div p{
            font-family: 'centurygothic';
            color: #ffffff;
            font-weight: normal;
            font-size: 8px;
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
        
        .addrss h4 {
            font-size: 10px;
            font-family: 'Mazzard M';
            font-weight: normal;
            color: #000;
            text-align: left;
            margin-bottom: 0px;
            letter-spacing: 0px;
        }
        .addrss p {
            font-size: 10px;
            font-family: 'Mazzard M';
            font-weight: normal;
            color: #000;
            text-align: left;
            padding: 1px 0px;
        }
         
        .table-list th{
            background:#E9FCF7;
        }
        .table-list th {
            background: #ffffff;
            padding: 10px 10px;
            color: #000000f5;
            font-family: 'Mazzard M';
            font-size: 9px;
            font-weight: bold;
            border: 1px solid #ff7f00;
        }
        .table-list td{
            border: 1px solid #ff7f00;
            padding: 7px 10px;
            background: #FFF;
        }

        table{
            background: #ccb58733;
        }
        .table-list td p{
            font-size: 10px;
            font-family: 'Mazzard';
            font-weight: normal;
            color: #000000;
            text-align: center;
        }
        .table-list td div p{
            text-align: left;
        }
        .table-list td div h6{
            color: #000000;
            font-family: 'Mazzard M';
            font-size: 9px;
            font-weight: bold;
        }
        .table-right td {
            padding: 6px 30px;
        }
        .table-right td {
            font-size: 10px;
            font-family: 'Mazzard';
            font-weight: normal;
            color: #000000;
            text-align: left;
        }
        .table-right td:last-child{
           text-align: right;
        }
        .table-right h6{
            color: #000000;
            font-family: 'Mazzard M';
            font-size: 10px;
            font-weight: bold;
        }
        tfoot div p{
            font-size: 6px;
            font-family: 'Mazzard M';
            font-weight: normal;
            color: #ffffff;
            text-align: center;
        }
        tfoot div h5{
            font-size: 12px;
            font-family: 'Mazzard M';
            font-weight: bold;
            color: #ffffff;
            text-align: center;
            margin-bottom: 5px;
        }
        tfoot div{
            text-align: center;
            width: 219px;
            margin: auto;
        }
        
    </style>
</head>
<body style="background:#ccb58733;height:100vh;padding:0px,margin:0px;">
    <table width="800" cellspacing="0" cellpadding="0" border="0" style="margin:0px;background:#ccb58733;">
        <tr>
            <td style="background-size: cover; height: 100%;">
            @php
                $minRows = 10; 
                $rowCount = count($products);
                $padRows = $minRows - $rowCount;
            @endphp

            <table width="800" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                <tbody>
                    <!-- Invoice Header -->
                    <tr>
                        <td style="background: url('{{ $invoice_header_image }}') no-repeat; background-size: cover; padding:40px 50px;">
                            <table class="table-div" style="background: transparent;">
                                <tr>
                                    <td>
                                        <h2>INVOICE</h2>
                                        <div style="display: flex; gap: 24px; margin-top: 10px;">
                                            <div>
                                                <p style="color:#ffffff">Company Name</p>
                                                <p style="color:#ffffff">{{ $site_name }} <br>
                                                  {{ $company_email }}<br>
                                                </p>
                                            </div>
                                            <div>
                                                <p style="color:#ffffff">Address</p>
                                                <p style="color:#ffffff">
                                                    
                                                    {{ $company_mobile }}<br>
                                                    {!! $company_address !!}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Billed To -->
                    <tr>
                        <td style="padding: 24px 60px;">
                            <table class="table-heade" style="width: 100%; background: transparent;">
                                <tbody>
                                    <tr>
                                        <td class="addrss" style="width: 40%;">
                                            <h4>BILLED TO:</h4>
                                            <p>{{ $customer_name }}</p>
                                            <p>{{ $customer_email }}</p>
                                        </td>
                                        <td class="addrss" style="display: flex;">
                                            <div style="display: flex; justify-content: space-between; width: 350px; max-width: 100%;">
                                                <h4>Invoice #{{ $invoice_number }}</h4>
                                                <h4>DATE {{ $invoice_date }}</h4>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <!-- Product Table with Padding -->
                    <tr>
                        <td style="padding: 0px 56px 50px;">
                            <table class="table-list" style="width: 100%; border: 5px solid #ff7f00;">
                                <tbody>
                                    <tr>
                                        <th style="text-align: left;">Product</th>
                                        <th>Duration</th>
                                        <th>QTY</th>
                                        <th>Total</th>
                                    </tr>

                                    @foreach($products as $product)
                                    <tr>
                                        <td><h6>{{ $product->name }}</h6></td>
                                        <td>{{ $product->subscription ?? '-' }}</td>
                                        <td>1</td>
                                        <td>{{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</td>
                                    </tr>
                                    @endforeach

                                    @for ($i = 0; $i < $padRows; $i++)
                                    <tr>
                                        <td style="height: 40px;">&nbsp;</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @endfor

                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <!-- Totals -->
                    <tr>
                        <td style="padding: 0px 56px 156px;">
                            <table style="width: 100%; background: transparent;">
                                <tbody>
                                    <tr>
                                        <td style="width: 61%;"></td>
                                        <td>
                                            <table class="table-right" style="width: 100%; background: transparent; border: 5px solid #ff7f00;">
                                                <tbody>
                                                    <tr>
                                                        <td>Subtotal</td>
                                                        <td>{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Discount</td>
                                                        <td>{{ site_currency() }} {{ number_format($discount_amount ?? 0, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background: #ff7f00;"><h6>GRAND TOTAL</h6></td>
                                                        <td style="background: #ff7f00;"><h6>{{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}</h6></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>

                <!-- Footer (Always at Bottom) -->
                <!-- <tfoot>
                    <tr>
                        <td style="width: 100%; background: url('{{ $invoice_footer_image }}') no-repeat; background-size: cover; padding: 60px 0px;">
                            <div style="text-align: center;">
                                <h5>Notes</h5>
                                <p>{{ $site->site_description }}</p>
                            </div>
                        </td>
                    </tr>
                </tfoot> -->

            </table>

            </td>
        </tr>
    </table>
</body>
</html>
