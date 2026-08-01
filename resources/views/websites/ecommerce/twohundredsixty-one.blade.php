<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body {
            margin: 0px;
            padding: 0px;
            background: #ececec;
            font-family: Arial, Helvetica, sans-serif;
        }
        table {
            border-collapse: collapse;
            border-spacing: 0;
        }
        .invoice {
            width: 900px;
            margin: auto;
            background: #ffffff;
        }
    </style>
</head>
<body style="height:80vh;">
    <table class="invoice" >
        <!-- Logo -->
        <tr>
            <td align="center" style="padding: 36px 0px 28px 0px;">
                <img src="{{ $invoice_header_image }}" width="220">
            </td>
        </tr>
        <!-- Invoice Header -->
        <tr>
            <td>
                <table cellpadding="0" cellspacing="0" style="background:#f3f5fa; margin: 0px 48px; width: fit-content;">
                    <tr>
                        <td></td>
                        <!-- Customer -->
                        <td align-items="center" style="padding: 24px 0px 12px 0px; text-align: center;">
                            <p style="margin:0; color:#6d84bf; font-size:16px;">Invoice To</p>
                            <p style="margin:15px 0 0; color:#24345e; font-size:40px; font-weight:bold;">
                                {{ $customer_name ? $customer_name : '' }}<br>
                                {{ $customer_email ? $customer_email : '' }}<br>
                                {{ $customer_mobile ? $customer_mobile : '' }}
                            </p>
                        </td>
                        <td></td>
                    </tr>
                    <tr  style="padding: 12px 36px 24px 36px;">
                        <!-- Invoice Number -->
                        <td width="25%" valign="bottom" style="padding: 12px 36px 24px 36px;">
                            <p style="margin:0; color:#6d84bf; font-size:16px; font-weight:600;">Invoice No.</p>
                            <p style="margin:12px 0 0; color:#24345e; font-size:18px; font-weight:bold;">{{ $invoice_number }}</p>
                        </td>
                        <!-- Date -->
                        <td width="55%" valign="bottom" style="padding: 12px 36px 24px 36px;">
                            <p style="margin:0; color:#6d84bf; font-size:16px; font-weight:600;">Date</p>
                            <p style="margin:12px 0 0; color:#24345e; font-size:18px;font-weight:bold;">{{ $invoice_date }}</p>
                        </td>
                        <!-- Total -->
                        <td width="20%" align="right" valign="bottom" style="padding: 12px 36px 24px 36px;">
                            <p style="margin:0; color:#6d84bf; font-size:16px; font-weight:600;">Total Due</p>
                            <p style="margin:12px 0 0; color:#24345e; font-size:26px;font-weight:bold;">{{ site_currency() . number_format($invoice_amount ?? 0, 2) }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Space -->
        <tr>
            <td style="height:40px;"></td>
        </tr>
        <!-- Table Header -->
        <tr>
            <td style="min-height: 585px;">
                <table cellpadding="0" cellspacing="0" style="margin: 0px 48px; width: fit-content;">
                    <thead>
                        <tr style="background:#263b6b;">
                            <th align="left" style="padding:18px; color:#ffffff; font-size:18px;">NO.</th>
                            <th align="left" style="min-width: 360px; padding:18px; color:#ffffff; font-size:18px;">ITEM NAME</th>
                            <th align="left" style="padding:18px; color:#ffffff; font-size:18px;">PRICE</th>
                            <th align="center" style="padding:18px; color:#ffffff; font-size:18px;">QUANTITY</th>
                            <th align="right" style="padding:18px; color:#ffffff; font-size:18px;">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Row 1 -->
                        @foreach ($products as $product)
                        <tr>
                            <td style="padding:18px;font-size:16px;color:#000;">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                            <td style="padding:18px;font-size:16px;color:#000;">{{ $product->name }}</td>
                            <td style="padding:18px;font-size:16px;color:#000;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                            <td align="center" style="padding:18px;font-size:16px;color:#000;">1</td>
                            <td align="right" style="padding:18px;font-size:16px;color:#000;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                        </tr>
                        @endforeach
                        <!-- Spacer -->
                        <tr>
                            <td colspan="5" style="height:20px;"></td>
                        </tr>
                        <!-- Subtotal -->
                        <tr style="background:#f5f7fb;">
                            <td colspan="3"></td>
                            <td style="padding:18px 12px;font-size:20px;font-weight:bold;color:#23345f;">Sub Total
                            </td>
                            <td align="right" style="padding:15px;font-size:22px;font-weight:bold;color:#23345f;">{{ site_currency() . number_format($invoice_amount + $discount_amount ?? 0, 2) }}
                            </td>
                        </tr>
                        <!-- Grand Total -->
                        <tr>
                            <td colspan="3"></td>
                            <td style="padding:18px 12px; font-size:20px; font-weight:bold; color:#23345f;">Grand&nbsp;Total<br><span style="font-size: 12px; color: #000; opacity: 0.5;">(Including&nbsp;discount)</span></td>
                            <td align="right" style="padding:20px; font-size:24px; font-weight:bold; color:#23345f;">{{ site_currency() . number_format($invoice_amount ?? 0, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <!-- Space -->
        <tr>
            <td style="height:60px;"></td>
        </tr>
        <!-- Footer Information -->
        <tr>
            <td align="center" style="padding:24px 60px 60px 60px; font-size:15px; line-height:28px; color:#23345f; font-weight:600;">
                {{ $company_email }} | {{ $company_mobile }} | DESIGNIFI.CO<br>
                 {!! $company_address !!}<br>
                
            </td>
        </tr>
        <!-- Bottom Blue Footer -->
        <tr>
            <td style="background:#243b70; padding: 60px;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center">
                            <img src="{{ $invoice_footer_image }}" alt="Logo" style="width:220px;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>