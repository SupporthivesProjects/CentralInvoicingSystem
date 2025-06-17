<!DOCTYPE html>
<html>
<head>
    <title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            /* This is the only line that changed: from #f2f2f2 to #ffffff */
            background-color: #ffffff;
        }
        .main-content-wrapper {
            padding: 20px 0;
            padding-bottom: 150px; /* Space for the footer */
        }
        .invoice-container {
            width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .content-padding {
            padding: 40px;
        }
        p {
            margin: 0;
            font-size: 10px;
        }
        h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }
        /* Items Table Styles */
        .items-table {
            margin-top: 40px;
        }
        .items-table th {
            color: white;
            font-size: 10px;
            font-weight: bold;
            padding: 8px;
            border: none;
        }
        .items-table td {
            font-size: 10px;
            padding: 15px 8px;
            vertical-align: top;
        }
        .items-table .item-row td {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }
        .items-table .item-row .bordered-cell {
            border-left: 1px solid black;
            border-right: 1px solid black;
        }
        .totals-section {
            margin-top: 10px;
        }
        .totals-section td {
            text-align: right;
            font-size: 10px;
            padding: 4px 0;
        }
        .totals-section .grand-total {
            background-color: #b38c48;
            color: white;
            font-weight: bold;
        }
        .totals-section .grand-total td {
             padding: 6px;
        }

        /* Footer Styles */
        .footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            width: 100%;
            text-align: center;
        }

    </style>
</head>
<body>
    <div class="footer">
        <table style="width: 600px; margin: 0 auto;" cellspacing="0" cellpadding="0">
             <tr>
                <td style="text-align: center; padding: 10px 0; background-color: #ffffff;">
                    <img src="{{ $company_logo ?? '' }}" alt="Company Logo" style="max-height: 80px; display: inline-block;">
                </td>
            </tr>
            <tr>
                <td>
                    <img src="{{ $invoice_footer_image }}" alt="Footer" style="display: block; width: 100%;">
                </td>
            </tr>
        </table>
    </div>

    <div class="main-content-wrapper">
        <table class="invoice-container" cellspacing="0" cellpadding="0">
            <tr>
                <td class="content-padding" style="padding-bottom: 20px;">
                    <table cellspacing="0" cellpadding="0">
                        <tr>
                            <td style="width: 30%; border-right: 2px solid black; vertical-align: top;">
                                <p><b>Address</b></p>
                                <p>{!! $company_address ?? 'N/A' !!}</p>
                            </td>
                            <td style="width: 30%; padding-left: 10px; vertical-align: top;">
                                <p><b>Email</b></p>
                                <p>{{ $company_email ?? 'support@diggidudes.com' }}</p>
                            </td>
                            <td style="width: 40%; text-align: right; vertical-align: top;">
                                <h2>INVOICE</h2>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="content-padding" style="padding-top: 0; padding-bottom: 20px;">
                    <table cellspacing="0" cellpadding="0">
                        <tr>
                            <td style="border-top: 2px solid #b38c48; border-bottom: 2px solid #b38c48; padding: 10px 0;">
                                <p><b>Invoice To</b></p>
                                <p style="padding-top: 5px;">{{ $customer_name }}</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="content-padding" style="padding-top: 0; padding-bottom: 0;">
                    <table cellspacing="0" cellpadding="0">
                        <tr>
                            <td style="width: 35%; vertical-align: top;">
                                <p><b>Invoice From</b></p>
                                <p>{{ $site->site_name }}</p>
                            </td>
                            <td style="width: 65%; vertical-align: top; text-align: right;">
                                 <p><b>Invoice Date:</b> {{ $invoice_date }}</p>
                                 <p style="padding-top: 5px;"><b>Invoice No:</b> #{{ $invoice_number }}</p>
                                 <p style="padding-top: 15px;"><b>Due Amount</b></p>
                                 <p style="font-size: 15px;"><b>{{ site_currency_code() }}{{ number_format($invoice_amount, 2) }}</b></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="content-padding" style="padding-top: 20px;">
                    <table class="items-table" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th style="background-color: #b38c48; text-align: left;">Service Name</th>
                                <th style="background-color: black;">Package Type</th>
                                <th style="background-color: black;">Duration</th>
                                <th style="background-color: black; text-align:center;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr class="item-row">
                                <td>
                                    <p><b>{{ $product->name }}</b></p>
                                </td>
                                <td class="bordered-cell" style="text-align: center;">{{ \Illuminate\Support\Str::after($product->name, ' - ') }}</td>
                                <td class="bordered-cell" style="text-align: center;">{{ $product->subscription ?? '-' }}</td>
                                <td style="text-align: center;">{{ site_currency_code() }}{{ number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                     <table class="totals-section">
                        <tr>
                            <td style="width:70%;"></td>
                            <td style="width:15%;">Sub Total</td>
                            <td style="width:15%;">{{ site_currency_code() }}{{ number_format($invoice_amount + $discount_amount, 2) }}</td>
                        </tr>
                         <tr>
                            <td></td>
                            <td>Discount</td>
                            <td>{{ site_currency_code() }}{{ number_format($discount_amount, 2) }}</td>
                        </tr>
                        <tr class="grand-total">
                            <td></td>
                            <td>Grand Total</td>
                            <td>{{ site_currency_code() }}{{ number_format($invoice_amount, 2) }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
