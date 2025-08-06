<!DOCTYPE html>
<html>
<head>
    <title>art2cartdevs</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .footer-fixed {
            position: fixed;
            bottom: -2px;
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
        }
        .maintable{
            width: 800px;
            max-width: 100%;
            margin: auto;
        }
        .maintable img{
            width: 800px;
            max-width: 100%;
            margin: auto;
        }
        .table-td-p p{
            font-family: arial;
            font-size: 9px;
            margin: 0px;
            font-weight: 400;
            color: red;
        }
        th, td {
          border-collapse: collapse;
        }
        table, th, td {
          border-collapse: collapse;
        }
        .main-td{
            padding: 50px 80px;
        }
        .datalist{
            padding: 0px 80px 50px;
        }
        .datalist table{
            width: 100%;
        }
        .datalist th{
            text-align: left;
            font-size: 10px;
            font-family: Arial;
            color: #000;
            font-weight: 900;
        }
        .datalist th, .datalist td {
            border-bottom: 1px solid #000;
            padding: 10px 10px;
        }
        .datalist th{
            background: #4a9ee0;
        }
        .datalist td {
            font-family: Arial;
            font-weight: 400;
            color: #000;
            font-size: 10px;

        }
        .datalist td:last-child{
            text-align: right;
        }
        .datalist th:last-child{
            text-align: right;
        }

    </style>
</head>
<body>
    <table width="100%" class="maintable" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
        <tr>
            <td>
                <table width="100%" cellspacing="0" cellpadding="0" border="0"  style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <tbody>
                        <tr>
                            <td>
                                <img src="{{ $invoice_header_image }}" class="img-fluid">
                            </td>
                        </tr>
                        <tr style="">
                            <td style="background: url('{{ $invoice_image1 }}') no-repeat; background-size: contain; background-position: 15px 42px">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="main-td">
                                    <tbody>
                                        <tr>
                                            <td class="main-td">
                                                <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
                                                    <tbody>
                                                        <tr>
                                                            <td width="100%">
                                                                <p style=" font-size: 10px;font-weight: 400;font-family: Arial; color: #000;margin-bottom: 6px;"><span style="font-size: 10.5px; font-weight: 900;">Date:</span> {{ $invoice_date }}</p>
                                                                <p style=" font-size: 10px;font-weight: 400;font-family: Arial; color: #000;margin-bottom: 6px;"><span style="font-size: 10.5px; font-weight: 900;">Invoice Number:</span> {{$invoice_number}}</p>
                                                            </td>
                                                            <td>
                                                                <h2 style="font-family: Arial; font-size: 28px; font-weight: 900; color: #000;">INVOICE</h2>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6 style=" font-size: 10px;font-weight: 000;font-family: Arial; color: #000; margin-top: 10px;">Billed From:</h6>
                                                                <p style=" font-size: 10px;font-weight: 400;font-family: Arial; color: #000; margin-top: 6px;">Art 2 Cart Devs </p>
                                                            </td>
                                                            <td>
                                                                <h6 style=" font-size: 10px;font-weight: 900;font-family: Arial; color: #000; margin-top: 10px;">Billed To:</h6>
                                                                <p style=" font-size: 10px;font-weight: 400;font-family: Arial; color: #000; margin-top: 6px;">
                                                                    {{ $customer_name }}
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p style="font-family: Arial; font-size: 10px; font-weight: 400; color: #000; margin-top: 16px;"> <span style="font-weight: 900;">Email:</span> {{ $company_email ?? 'support@art2cartdevs.com' }}</p>
                                                                <p style="font-family: Arial; font-size: 10px; font-weight: 400; color: #000;"> <span style="font-weight: 900;">Website:</span> www.art2cartdevs.com</p>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="datalist">
                                                <div style="min-height: 650px !important;">
                                                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="datalist">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Description</th>
                                                            <th>Quantity</th>
                                                            <th>Unit Price</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($products as $product)
                                                        <tr>
                                                            <td><p>{{ $loop->iteration }}</p></td>
                                                            <td>
                                                                <p>{{$product->name}}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $product->quantity ?? '1' }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ site_currency() . number_format($product->unit_price, 2) }}</p>
                                                            </td>
                                                            <td>
                                                                <p>
                                                                    {{ site_currency() . number_format($product->unit_price, 2) }}
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="3" style="border:0px"></td>
                                                            <td>
                                                                <p>Subtotal</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" style="border:0px"></td>
                                                            <td style="border-bottom: 0px;">
                                                                <p>Discount</p>
                                                            </td>
                                                            <td style="border-bottom: 0px;">
                                                                <p>{{ site_currency() . number_format($discount_amount, 2) }}</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" style="border:0px"></td>
                                                            <td style="background: #4a9ee0;">
                                                                <p style="color: #000;">Grand Total</p>
                                                            </td>
                                                            <td style="background: #4a9ee0;">
                                                                <p style="color: #000;">{{ site_currency() . number_format($invoice_amount, 2) }}</p>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td>
                                <img src="{{ $invoice_footer_image }}" class="img-fluid">
                            </td>
                        </tr> -->
                         <!-- Original Footer Row (Hidden for PDF rendering) -->
                    <tr>
                        <td style="display:none;"></td>
                    </tr>
                    <!-- Footer End --> 
                   </tbody>
                </table>

            </td>
        </tr>
    </table>
    <!-- Footer absolutely fixed for PDF -->
    <div class="footer-fixed"></div>
</body>
</html>
