<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    <title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .invoice_footer_image {
            background: url('{{ $invoice_footer_image }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            height: 170px;
            padding: 50px;
            width: 100%;
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="80%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;">
                            <img src="{{ $invoice_header_image }}" alt="Invoice Header" style="margin: auto; display: block; height: 87px;">
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 20px 60px;">
                            <h1 style="font-size: 24px; font-weight: 700; text-align: center; color: #3C3C3C;">Transaction Confirmation</h1>
                            <p style="font-size: 16px; color: #656565; text-align: center; line-height: 150%;">
                                Dear {{ $customer_name }},<br><br>
                                We appreciate your order.<br>
                                Here's a summary of your recent purchase.
                            </p>
                        </td>
                    </tr>

                    <!-- Billing Info -->
                    <tr>
                        <td style="padding: 10px 40px 40px;">
                            <p style="font-size: 16px; font-weight: 700; color: #0E0E0E; text-align: center;">Billing Details:</p>
                            <table width="100%">
                                <tr style="color:#656565; line-height:26px;">
                                    <td style="width:50%; text-align:center;">{{ $customer_name }}</td>
                                    <td style="width:50%; text-align:center;">{{ $customer_email }}</td>
                                </tr>
                                <tr style="color:#656565; line-height:26px;">
                                    <td style="text-align:center;">{{ $invoice_date }}</td>
                                    <td style="text-align:center;">{{ $invoice_number }}</td>
                                </tr>
                            </table>

                            <!-- Products Table -->
                            <table width="100%" height= "300px" style="margin-top:40px;">
                                @foreach($products as $product)
                                <tr>
                                    <td style="width:40%;">{{ $product->name }}</td>
                                    <td style="width:20%; text-align:center;">{{ $product->subscription }}</td>
                                    <td style="width:10%; text-align:center;">{{ $product->quantity ?? 1 }}</td>
                                    <td style="width:30%; text-align:center;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                </tr>
                                <tr><td colspan="4"><hr style="border-top: 1px solid #F3F3F1;"></td></tr>
                                @endforeach

                                <!-- Totals -->
                                <tr>
                                    <td colspan="3" style="text-align:right; font-weight:700;">Sub Total</td>
                                    <td style="text-align:center; color:#EE5921;">{{ site_currency(). number_format(($invoice_amount + $discount_amount), 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align:right; font-weight:700;">Discount</td>
                                    <td style="text-align:center; color:#EE5921;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align:right; font-weight:700;">Total</td>
                                    <td style="text-align:center; color:#EE5921;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr class="invoice_footer_image">
                                    <td style="text-align:center;">
                                        <img src="{{ $company_logo }}" alt="Company Logo">
                                    </td>
                                    <td style="text-align:right; padding-right:40px;">
                                        <p style="font-size: 16px; color:#3C3C3C; line-height:24px;">
                                            {!! $company_address !!}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
