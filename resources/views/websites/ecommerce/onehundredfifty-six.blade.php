<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Web Mechaniks Invoice</title>
    <style>
        .footer_bottom {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            width: 100%;
            
            
        }
        </style>
</head>

<body style="margin:0; padding:0; background:#fff; font-family:Arial,sans-serif;">
    <table
        style="width:100%; margin:30px auto; background:#fff; border-radius:8px; border-collapse:separate; border-spacing:0; position: relative;">
        <!-- Header -->
        <tr>
            <td colspan="4" style="padding:0;">
                <table style="width:100%; border-collapse:collapse;">
                    <tr>
                        <td style="width:60%; padding:20px 0 0 40px; vertical-align:top;">
                            <!-- Logo Placeholder -->
                            <img src="{{ $company_logo }}" alt="" height="50px">
                        </td>
                        <td style="width:40%; text-align:right; padding:20px 40px 0 0; vertical-align:top;">
                            <div style="font-size:9px; color:#222; margin-bottom:6px;">Amount Due:</div>
                            <div style="font-size:10px; color:#222; font-weight:bold;">{{ $invoice_amount }}</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Invoice Title & Meta -->
        <tr>
            <td colspan="4" style="padding: 20px 0 20px 0;">
                <table style="width:100%; border-collapse:collapse;">
                    <tr style="border: 1px solid black;">
                        <td
                            style="background:#2eb24b; color:#fff; font-size:10px; font-weight:bold; letter-spacing:2px; padding:12px 0 12px 20px; width:45%; border-top-left-radius:0px;">
                            INVOICE</td>
                        <td style="width:55%; padding:0;">
                            <table style="width:100%; border-collapse:collapse;">
                                <tr>
                                    <td style="font-size:9px; color:#222; padding:6px 0 0 20px;">
                                        <span style="font-weight:bold; font-size:10px;">Date:</span><br>{{ $invoice_date }}
                                    </td>
                                    <td style="font-size:9px; color:#222; padding:6px 20px 0 0;">
                                        <span style="font-weight:bold; font-size:10px;">Invoice No:</span><br>{{ $invoice_number }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Bill To / From -->
        <tr>
            <td colspan="4" style="padding:0;">
                <table style="width:100%; border-collapse:collapse; margin:0;">
                    <tr>
                        <td style="width:50%; padding:10px 0 8px 40px; font-size:9px; color:#222; vertical-align:top;">
                            <table style="width:100%; border-collapse:collapse;">
                                <tr>
                                    <td style="padding:0 8px 0 0; vertical-align:top;">
                                        <span style="font-size:9px;">Bill To:</span><br>
                                        <span style="font-weight:bold; font-size:10px;">{{ $customer_name }}</span>
                                    </td>
                                    <!-- <td style="font-size:9px; color:#222; vertical-align:top;">
                                        <span style="font-weight:bold; font-size:10px;">P:</span> {{ $customer_mobile }}<br>
                                        <span style="font-weight:bold; font-size:10px;">E:</span>
                                        {{ $customer_email }}<br>
                                    </td> -->
                                </tr>
                            </table>
                        </td>
                        <td style="width:50%; padding:10px 40px 8px 0; font-size:9px; color:#222; vertical-align:top;">
                            <table style="width:100%; border-collapse:collapse;">
                                <tr>
                                    <td style="padding:0 8px 0 0; vertical-align:top;">
                                        <span style="font-size:9px;">Bill From:</span><br>
                                        <span style="font-weight:bold; font-size:10px;">{{ $site_name }}</span>
                                    </td>
                                    <!-- <td style="font-size:9px; color:#222; vertical-align:top;">
                                        <span style="font-weight:bold; font-size:10px;">P:</span> {{ $company_mobile }}<br>
                                        <span style="font-weight:bold; font-size:10px;">E:</span>
                                        {{ $company_email }}<br>
                                        <span style="font-weight:bold; font-size:10px;">A:</span> {{ $company_address }}
                                    </td> -->
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Table Headings -->
        <tr>
            <td colspan="4" style="padding:0px 20px;">
                <table style="width:100%; border-collapse:collapse;">
                    <tr style="border: 2px solid #2eb24b;border-left: 0px;border-right: 0px;">
                        <td
                            style="border-bottom:2px solid #2eb24b; font-size:10px; color:#222; font-weight:bold; padding:8px 0 8px 20px; width:52%;">
                            ITEM DESCRIPTIONS
                        </td>
                        <td
                            style="border-bottom:2px solid #2eb24b; font-size:10px; color:#222; font-weight:bold; padding:8px 0;text-align:right; width:16%;">
                            PRICE
                        </td>
                        <td
                            style="border-bottom:2px solid #2eb24b; font-size:10px; color:#222; font-weight:bold; padding:8px 0;text-align:right; width:16%;">
                            QUANTITY
                        </td>
                        <td
                            style="border-bottom:2px solid #2eb24b; font-size:10px; color:#222; font-weight:bold; padding:8px 20px 8px 0;text-align:right; width:16%;">
                            TOTAL
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Invoice Items -->
        <tr>
            <td colspan="4" style="padding:0px 20px;">
                <table style="width:100%; border-collapse:collapse;">
                    @foreach($products as $product)
                    <tr style="background:#fff;">
                        <td style="padding:10px 0 4px 20px; font-size:9px; color:#222; border-bottom:1px solid #888; width:52%;">
                            <span style="font-weight:bold; font-size:10px;">{{ $product->name }}</span><br>
                            <!-- <span style="display:inline-block; max-width:100%; width:320px; word-break:break-word; white-space:normal; overflow:hidden; text-overflow:ellipsis;">
                                {!! \Illuminate\Support\Str::limit(strip_tags($product->description), 150) !!}
                            </span> -->
                        </td>
                        <td
                            style="padding:10px 0; font-size:9px; color:#222; border-bottom:1px solid #888; text-align:right;width:16%;">
                            {{ site_currency() }} {{ number_format($product->unit_price, 2) }}</td>
                        <td
                            style="padding:10px 0; font-size:9px; color:#222; border-bottom:1px solid #888; text-align:right;width:16%;">
                            1</td>
                        <td
                            style="padding:10px 28px 10px 0; font-size:9px; color:#222; border-bottom:1px solid #888; text-align:right;width:16%;">
                            {{ site_currency() }} {{ number_format($product->unit_price, 2) }}</td>
                    </tr>
                    @endforeach
                </table>
            </td>
        </tr>
        <!-- Notes and Totals Section -->
        <tr>
            <td colspan="4" style="padding:20px 20px 0px;">
                <table style="width:100%; border-collapse:collapse; background:transparent;">
                    <tr>
                        <!-- Notes -->
                        <td style="width:60%; vertical-align:top; padding:18px 0 18px 0;">
                            <span style="color:#2eb24b; font-weight:bold; font-size:10px;">Notes:</span>
                            <span style="font-size:9px; color:#222;">
                                {{ $invoice_notes ?? 'No additional notes provided!' }}
                            </span>
                        </td>
                        <!-- Totals -->
                        <td style="width:20%; vertical-align:top; padding:0;">
                        </td>
                        <td style="width:20%; vertical-align:top; padding:0;">
                            <table style="width:100%; border-collapse:collapse;">
                                <tr>
                                    <td style="font-size:9px; color:#222; padding:4px 0; text-align:right;">Sub Total
                                    </td>
                                    <td style="font-size:9px; color:#222; padding:4px 0; text-align:right;">{{ site_currency() }} {{  number_format(($invoice_amount + $discount_amount), 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:9px; color:#222; padding:4px 0; text-align:right;">Discount
                                    </td>
                                    <td style="font-size:9px; color:#222; padding:4px 0; text-align:right;">{{ site_currency() }} {{  number_format(($discount_amount), 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="border-top:2px solid black; padding-top:0px;"></td>
                                </tr>
                                <tr>
                                    <td
                                        style="font-size:10px; color:#2eb24b; font-weight:bold; padding:8px 0 0 0; text-align:right;">
                                        Grand Total</td>
                                    <td
                                        style="font-size:10px; color:#2eb24b; font-weight:bold; padding:8px 0 0 0; text-align:right;">
                                        {{ site_currency() }} {{  number_format(($invoice_amount), 2) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Contact Footer -->
        <table class="footer_bottom">
        <tr>
            <td colspan="4" style="padding:40px 0 20px 0;">
                <table style="width:100%; border-collapse:separate; border-spacing:0 0;">
                    <tr>
                        <td style="width:90px; padding:0 0 0 20px; vertical-align:middle;">
                            <div
                                style="background:#2eb24b; color:#fff; font-size:10px; font-weight:bold; padding:16px 0; text-align:center; border-radius:2px; width:90px;">
                                CONTACT
                            </div>
                        </td>
                        <!-- Email -->
                        <td style="padding-left:10px; vertical-align:middle;">
                            <div style="font-size:10px; color:#222; font-weight:bold; margin-bottom:4px;">Email:</div>
                            <div
                                style="background:#e5e5e5; font-size:9px; color:#222; padding:8px 10px; border-radius:2px; min-width:100px;">
                                {{ $company_email }}
                            </div>
                        </td>
                        <!-- Phone -->
                        <td style="padding-left:10px; vertical-align:middle;">
                            <div style="font-size:10px; color:#222; font-weight:bold; margin-bottom:4px;">Phone:</div>
                            <div
                                style="background:#e5e5e5; font-size:9px; color:#222; padding:8px 10px; border-radius:2px; min-width:80px;">
                                {{ $company_mobile }}
                            </div>
                        </td>
                        <!-- Address -->
                        <td style="padding-left:10px; padding-right:20px; vertical-align:middle;">
                            <div style="font-size:10px; color:#222; font-weight:bold; margin-bottom:4px;">Address:</div>
                            <div
                                style="background:#e5e5e5; font-size:9px; color:#222; padding:8px 10px; border-radius:2px; min-width:120px;">
                                {{ $company_address }}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Bottom Graphics (Optional) -->
        <tr>
            <td colspan="4" style="padding:0;">
                <table style="width:100%; border-collapse:collapse;">
                    <tr>
                        <td style="padding:10px 0 0 0; text-align:left;">
                            <!-- Placeholder for bottom left graphic --><img src="{{ $invoice_image2 }}" alt=""
                                style="height: 50px;">
                        </td>
                        <td style="padding:10px 10px 0 0; text-align:right;">
                            <!-- Placeholder for bottom right graphic -->
                            <img src="{{ $invoice_image3 }}" alt="" style="height: 50px;">
                        </td>
                        <td style="padding:10px 10px 0 0; text-align:right;">
                            <img src="{{ $invoice_image1 }}" alt="" class="bgg "
                                style="top: 370px; position: absolute;width: 273px;left: 0px;opacity: 0.2;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        </table>
    </table>
</body>

</html>
