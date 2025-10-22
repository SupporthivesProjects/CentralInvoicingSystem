<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&amp;display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0px;
            padding: 0px;
        }
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
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
        
        .table-list h2{
            font-family: Roboto;
            font-size: 28px;
            color: #f14d4d;
            line-height: normal;
            font-weight: 700;
        }
        .table-list p{
            font-family: 'Roboto';
            font-size: 14px;
            letter-spacing: 2px;
            line-height: normal;
            font-weight: 400;
            color: red;
        }
        .table-main-list div p{
            font-family: 'Roboto';
            font-size: 10px;
            line-height: normal;
            font-weight: 600;
            color: gray;
        }
        .table-main-list div h4{
            font-size: 24px;
            font-family: 'Roboto';
            font-weight: 400;
            margin: 10px 0px 20px;
            color: red;
        }
        .invoiec-div p{
            font-family: 'Roboto';
            font-size: 9px;
            line-height: normal;
            color: red;
        }
        .invoiec-div h6{
            font-family: 'Roboto';
            font-size: 12px;
            line-height: normal;
            font-weight: 600;
            color: red;
        }
        .table-list-product th{
            font-family: 'Roboto';
            font-size: 10px;
            text-align: justify;
            padding: 12px 10px;
            color: gray;
            border-bottom: 1px solid #000;
        }
        .table-list-product td{
            padding: 20px 0px;
            border-bottom: 1px solid #000;
            font-family: 'Roboto';
            font-size: 9px;
            font-weight: 500;
            color: #000;
        }

        .table-list-product th:last-child{
            padding: 12px 16px;
        }
        .table-list-product td:first-child{
            padding: 12px 10px;
        }
        .table-list-product td:last-child {
           background-color: #8080801c; /* Last TH */
           font-family: 'Roboto';
           font-size: 12px;
           font-weight: 500;
           color: grey;
           text-align: right;
           padding: 12px 16px;
        }

        .table-list-product td:nth-last-child(2) {
           background-color: #8080801c; /* Second last TH */
           font-family: 'Roboto';
           font-size: 9px;
           font-weight: 300;
           color: grey;
        }
        .table-list-product td:nth-last-child(3) {
           font-family: 'Roboto';
           font-size: 9px;
           font-weight: 300;
           color: grey;
        }
        .footer-fixed {
            position: fixed;
            bottom: 0px;
            left: 0;
            right: 0;
            width: 100%;
            /* background: url('{{ $invoice_footer_image }}') center center no-repeat; */
            /* background-size: cover; */
        }
       
    </style>
</head>
<body style="padding: 0px; margin: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
        <tr>
            <td style="background: url(./img/Picture3.png) no-repeat; background-size: cover; height: 100%;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0"  style="border-collapse: collapse;">
                   <tbody>
                    <tr>
                        <td style="background: url('{{ $invoice_header_image }}') no-repeat; background-size: cover; text-align: center; text-align: center; display: flex; justify-content: center;align-items: center;height: 100px;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 24px 54px;">
                            <table class="table-list" style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <td style="width: 50%; border-bottom: 1px solid green;">
                                            <h2>INVOICE</h2>
                                        </td>
                                        <td style="width: 50%; border-bottom: 1px solid green; padding: 16px 0px;">
                                            <p style="text-align: right; margin-bottom: 6px;">INVOICE NO: #{{ $invoice_number }}</p>
                                            <p style="color: #000;text-align: right;">{{ $invoice_date }}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0px 50px 24px;">
                            <div style="min-height: 450px !important;">
                                <table class="table-main-list" style="width: 100%;">
                                    <tbody>
                                        <tr>
                                            <td style="width: 40%;vertical-align: top;">
                                                <div>
                                                    <p>TOTAL</p>
                                                    <h4>{{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}</h4>
                                                </div>
                                                <div class="invoiec-div">
                                                    <p>Invoice To</p>
                                                    <h6>{{ $customer_name }}</h6>
                                                </div>
                                            </td>
                                            <td style="width: 60%;vertical-align: top;">
                                                <table class="table-list-product" style="width: 100%;">
                                                    <tbody>
                                                        <tr>
                                                            <th>Product</th>
                                                            <th style="text-align: end;">Length</th>
                                                            <th style="text-align: center; border-bottom: 3px solid red;">QTY</th>
                                                            <th style="text-align: end; border-bottom: 3px solid red;">PRICE</th>
                                                        </tr>
                                                        @foreach($products as $product)
                                                        <tr>
                                                            <td>{{ $product->name }}</td>
                                                            <td style="text-align: end;">{{ $product->subscription ?? '-' }}</td>
                                                            <td style="text-align: center;">01</td>
                                                            <td >{{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</td>
                                                        </tr>
                                                        @endforeach 
                                                        
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td></td>
                                                            
                                                            <td style="padding-left: 20px;text-align: end;">
                                                                <p style="font-family: 'Roboto';font-size: 9px;line-height: normal;color: gray;">SUB TOTAL<br>
                                                                    DISCOUNT</p>
                                                            </td>
                                                            <td></td>
                                                            <td style="padding-left: 20px; border-bottom: 3px solid red; padding-top: 20px;">
                                                                <p>{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}<br>
                                                                {{ site_currency() }} {{ number_format($discount_amount ?? 0, 2) }}
                                                                    </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 20px; border: 0px;"></td>
                                                            
                                                            <td style="padding-left: 20px; border: 0px;text-align: end;">
                                                                <h6 style="font-family: 'Roboto';font-size: 9px;line-height: normal;color: #ff0000b8;">GRAND TOTAL</h6>
                                                            </td>
                                                            <td style="padding-left: 20px; border: 0px;"></td>
                                                            <td style="border: 0px;" >
                                                                <h6 style="font-family: 'Roboto';font-size: 16px;line-height: normal;color: #ff0000b8;">{{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}</h6>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0px 50px 36px;">
                            <div class="thankyou">
                                <p style="background: red;padding: 2px 0px;width: 39px;margin-bottom: 14px;"></p>
                                <h2 style="font-family: 'Roboto';font-size: 12px;line-height: normal;font-weight: 600;color: #000;">THANK YOU!</h2>
                            </div>
                        </td>
                    </tr>
                   </tbody>
                   <div class="footer-fixed">
                   <div class="invoice-footer" style="
                        background: url('{{ $invoice_footer_image }}') no-repeat center;
                        background-size: cover;
                        height: 220px;
                        padding: 33px 45px;
                        display: flex;
                        align-items: flex-start;
                        justify-content: space-between;
                        gap: 20px;
                        flex-wrap: wrap;
                    ">

                        <!-- Company Logo -->
                        <div style="flex-shrink: 0;">
                            <img src="{{ $company_logo }}" alt="Company Logo" style="width: 206px; height: 150px;">
                        </div>

                        <!-- Company Info -->
                        <div style="flex: 1; text-align: right;">
                            <p style="font-family: 'Roboto'; font-size: 9px; font-weight: 400; color: #fff;">
                            {{ $company_name }}<br>
                            {!! $company_address !!}<br>
                            </p>
                            <p style="font-family: 'Roboto'; font-size: 9px; font-weight: 400; color: #fff; padding: 5px 0;">
                            {{ $site->company_mobile }}
                            </p>
                            <p style="font-family: 'Roboto'; font-size: 9px; font-weight: 400; color: pink;">
                            {{ $company_email }}
                            </p>
                        </div>

                        <!-- Vertical Icons -->
                        <div style="
                            padding-left: 12px;
                            display: flex;
                            align-items: flex-start;
                        ">
                            <div style="
                            background: #d75151;
                            display: flex;
                            flex-direction: column;
                            gap: 21px;
                            padding: 37px 7px;
                            transform: translate(10px, 37px);
                            ">
                            <img src="{{ $invoice_image1 }}" style="width: 10px; height: 10px; object-fit: contain;">
                            <img src="{{ $invoice_image2 }}" style="width: 10px; height: 10px; object-fit: contain;">
                            <img src="{{ $invoice_image3 }}" style="width: 10px; height: 10px; object-fit: contain;">
                            </div>
                        </div>

                    </div>
                    </div>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
