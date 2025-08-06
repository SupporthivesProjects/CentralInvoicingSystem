<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .footer-fixed {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background:#e5c99e; height:40px; border-bottom:60px solid #3c4a4a;
        }
    </style>
</head>



<body style="font-family:'Segoe UI', Arial, sans-serif; margin:0; ">
    <table cellpadding="0" cellspacing="0" border="0" align="center" style="background:#fff; width:100%;height: 100%; margin:0px auto;">
        <tr>
            <td colspan="2" style="padding:0;">
                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                    <tr style="height: 123px;background:#e5c99e; border-top:100px solid #3c4a4a; position: relative;">
                        <td style="width:180px; padding:0; ">
                            <!-- Logo image here -->
                            <img src="{{ $company_logo }}" alt="Brandexx Logo"
                                style="display:block;width: 183px;height: 228px;margin:10px auto 10px auto;border-radius:8px;position: absolute;top: -156px;left: 54px;margin-top: 6px;">
                        </td>
                        <td
                            style="text-align:right; vertical-align:middle; font-size:1.4em; letter-spacing:2px; color:#222; padding-right:40px;">
                            <span style="font-weight:bold; letter-spacing:3px;">INVOICE</span>#{{ $invoice_number }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Contact Info -->
        <tr>
            <td colspan="2" style="padding:0 0px 0 100px;">
                <table align="top" width="100%" cellpadding="0" cellspacing="0" style="margin-top:100px;">
                    <tr>
                        <td style="font-size:0.98em; padding-right:40px;width:30%;">
                            <b>📞&nbsp;Phone:</b><br>
                            {{ $company_mobile }}
                        </td>
                        <td style="font-size:0.98em; padding-right:40px;width:30%;">
                            <b>✉️&nbsp;Email:</b><br>
                            {{ $company_email }}
                        </td>
                        <td style="font-size:0.98em;">
                            <b>🏠&nbsp;Address:</b><br>
                            {!! $company_address !!}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Details Section -->
        <tr>
            <td colspan="2" style="padding:0 30px;">
                <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px;">
                    <tr>
                        <td style="width:32%; font-size:0.98em; line-height:1.5; vertical-align:top; border-left: 1px solid #282828; padding:10px 15px;">
                            <b style="font-size:1.05em;">To:  {{ $customer_name }}</b><br>
                            {{ $customer_email }}
                        </td>
                        
                        <td
                            style="width:36%; font-size:0.97em; padding:10px 15px; vertical-align:top; border-left: 1px solid #282828">
                            <b>Invoice Details</b><br>
                            Invoice Date: {{ $invoice_date }}<br>
                            Issue Date: {{ $invoice_date }}<br>
                            Total Due: {{ site_currency() }} {{ number_format(($invoice_amount) ?? 0, 2) }}
                        </td>
                        <td
                            style="width:32%; font-size:0.97em; padding:10px 15px; border-radius:6px; vertical-align:top;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Product Table -->
        <tr>
            <td colspan="2" style="padding:0;">
                <table width="90%" align="center" cellpadding="0" cellspacing="0"
                    style="margin-top:30px; border-collapse:collapse; font-size:1em;">
                    <tr>
                        <th
                            style="background: transparent; font-weight:bold; letter-spacing:1px; border-bottom:1px solid #D8A34E; border-top:1px solid #D8A34E; padding:12px 8px; text-align:left;">
                            PRODUCT DESCRIPTIONS</th>
                        <th
                            style="background: transparent; font-weight:bold; letter-spacing:1px; border-bottom:1px solid #D8A34E; border-top:1px solid #D8A34E; padding:12px 8px; text-align:left;">
                            Length</th>
                        <th
                            style="background: transparent; font-weight:bold; letter-spacing:1px; border-bottom:1px solid #D8A34E; border-top:1px solid #D8A34E; padding:12px 8px; text-align:left;">
                            Quantity</th>
                        <th
                            style="background: transparent; font-weight:bold; letter-spacing:1px; border-bottom:1px solid #D8A34E; border-top:1px solid #D8A34E; padding:12px 8px; text-align:right;">
                            AMOUNT</th>
                    </tr>
                    @foreach($products as $product)
                    <tr>
                        <td style="background: transparent; border-bottom:1px solid #282828; padding:12px 8px;"><b>{{ $product->name }}</td>
                        <td style="background: transparent; border-bottom:1px solid #282828; padding:12px 8px;">{{ $product->subscription ?? '-' }}</td>
                        <td style="background: transparent; border-bottom:1px solid #282828; padding:12px 8px;">1</td>
                        <td style="background: transparent; border-bottom:1px solid #282828; padding:12px 8px; text-align:right;">{{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</td>
                    </tr>
                    @endforeach
                    
                </table>
            </td>
        </tr>
        <!-- Thank You -->
        <tr>
            <td colspan="2" style="padding:0;">
                <table width="90%" align="center" style="margin-top:30px;">
                    <tr>
                        <td style="font-size:1.1em; font-weight:bold; color:#444;">
                            Thank You <span style="color:#3c4a4a; font-weight:bold;">For</span> Your Business!
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Summary Section -->
        <tr>
            <td colspan="2" style="padding:0;">
                <table width="90%" align="center" style="margin-top:20px; font-size:1em;">
                    <tr>
                        <td style="text-align:right; font-weight:bold; padding:6px 0;">Sub Total:</td>
                        <td style="text-align:right; width:120px; padding:6px 0;">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td style="text-align:right; font-weight:bold; padding:6px 0;">Discount:</td>
                        <td style="text-align:right; width:120px; padding:6px 0;">{{ site_currency() }} {{ number_format($discount_amount ?? 0, 2) }}</td>
                    </tr>
                   
                    <tr>
                        <td
                            style="text-align:right; font-weight:bold; font-size:1.15em; border-top:2px solid #222; padding-top:8px;">
                            Grand Total:</td>
                        <td
                            style="text-align:right; width:120px; font-size:1.15em; font-weight:bold; border-top:2px solid #222; padding-top:8px;">
                            {{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr class="footer-fixed">
            <td style="height: 100px;"></td>
        </tr>
        <!-- Footer Bar -->
        <!-- <tr>
            <td colspan="2" style="padding:0;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td
                            style="background:#e5c99e; height:18px; padding-top:40px; border-bottom:60px solid #3c4a4a;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr> -->
    </table>
     <!-- Footer absolutely fixed for PDF -->
     
</body>

</html>