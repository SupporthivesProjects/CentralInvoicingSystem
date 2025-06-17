<!DOCTYPE html>
<html>
<head>
    <title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #ffffff;
        }
        .main-wrapper {
            padding: 20px;
        }
        .invoice-container {
            width: 100%;
            margin: 0 auto;
            background-color: #ffffff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .content-padding {
            padding: 20px 0 40px 0;
            /* This is now a positioning context for the background image */
            position: relative;
        }
        .background-image-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            text-align: center;
            opacity: 0.05; /* Kept very low to be a subtle watermark */
            z-index: 0;
            /*add backgroud image*/
            background-image: url('{{ $invoice_image1 }}');
        }
        .content-overlay {
            position: relative;
            z-index: 1;
        }
        .header-image, .footer-image {
            width: 100%;
            display: block;
        }
        .info-table p {
            font-size: 10px;
            margin: 0 0 5px 0;
        }
        .items-table {
            margin-top: 20px;
        }
        .items-table th {
            background-color: #FF4500;
            color: white;
            font-size: 10px;
            font-weight: bold;
            padding: 8px;
        }
        .items-table td {
            font-size: 10px;
            padding: 8px;
            border-bottom: 1px solid #FF4500;
        }
        .grand-total td {
            background-color: #FF4500;
            color: white;
            font-weight: bold;
            border-bottom: none;
        }
    </style>
</head>
<body>
    <table class="main-wrapper" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <table class="invoice-container" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <img class="header-image" src="{{ $invoice_header_image }}" alt="Header">
                        </td>
                    </tr>
                    <tr>
                        <td class="content-padding">
                            <div class="background-image-container">
                                <img src="{{ $invoice_image1 }}" style="height: 100%; width: auto;" alt="Watermark">
                            </div>

                            <div class="content-overlay">
                                <table class="info-table" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td style="width: 50%; vertical-align: top;">
                                            <h2 style="font-family: Arial, sans-serif; margin-top: 0;">INVOICE</h2>
                                            <p><b>BILLED FROM:</b></p>
                                            <p>{{ $site->site_name }}</p>
                                            <br/>
                                            <p><b>BILLED TO:</b></p>
                                            <p>{{ $customer_name }}</p>
                                        </td>
                                        <td style="width: 50%; vertical-align: top; text-align: right;">
                                            <p><b>Date:</b> {{ $invoice_date }}</p>
                                            <p><b>Invoice Number:</b> #{{ $invoice_number }}</p>
                                            <br/>
                                            @if(!empty($company_email))
                                                <p><b>Email:</b> {{ $company_email }}</p>
                                            @endif
                                            @if(!empty($company_address))
                                                <p><b>Address:</b><br>{!! $company_address !!}</p>
                                            @endif
                                        </td>
                                    </tr>
                                </table>

                                <table class="items-table" cellspacing="0" cellpadding="0">
                                    <thead>
                                        <tr>
                                            <th style="width: 45%; text-align: left;">ITEM NAME</th>
                                            <th style="width: 15%; text-align: center;">QUANTITY</th>
                                            <th style="width: 20%; text-align: right;">UNIT PRICE</th>
                                            <th style="width: 20%; text-align: right;">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td style="text-align: center;">{{ $product->quantity ?? 1 }}</td>
                                                <td style="text-align: right;">{{ site_currency_code() . number_format($product->unit_price, 2) }}</td>
                                                <td style="text-align: right;">{{ site_currency_code() . number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" style="border-bottom: none;"></td>
                                            <td style="text-align: right; font-weight: bold;">SUBTOTAL</td>
                                            <td style="text-align: right;">{{ site_currency_code() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="border-bottom: none;"></td>
                                            <td style="text-align: right; font-weight: bold;">DISCOUNT</td>
                                            <td style="text-align: right;">{{ site_currency_code() . number_format($discount_amount, 2) }}</td>
                                        </tr>
                                        <tr class="grand-total">
                                            <td colspan="2" style="border-bottom: none;"></td>
                                            <td style="text-align: right;">GRAND TOTAL</td>
                                            <td style="text-align: right;">{{ site_currency_code() . number_format($invoice_amount, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img class="footer-image" src="{{ $invoice_footer_image }}" alt="Footer">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
