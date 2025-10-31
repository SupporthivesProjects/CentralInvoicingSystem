<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body style="margin:0;padding:0;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="background:#ffffff;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse:collapse;">

                    <!-- Header -->
                    <tr>
                        <td align="center"
                            style="height:100px;background:#416529;padding:20px;vertical-align:middle;position: relative;z-index: 1;">
                            <img src="{{ $invoice_header_image }}" alt="Header Logo" style="height:70px;">
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:20px 0; position: relative;">
                            <img src="{{ $invoice_image1 }}" alt="Invoice Banner"
                                style="position: absolute;top: -110px;left: 62px;width: 280px;margin-right:auto;display: flex;transform: rotate(312deg);z-index: 0;">
                            <h1
                                style="margin:10px 0 0;font-family:Arial;font-size:28px;line-height:32px;text-transform:uppercase;text-align:center;">
                                Invoice
                            </h1>
                        </td>
                    </tr>
                    <!-- Header End -->

                    <!-- Content -->
                    <tr>
                        <td style="padding:40px;padding-top:0;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0"
                                style="font-family:'Poppins',Arial,sans-serif;border-collapse:collapse;color:#000;">

                                <!-- ORDER INFO -->
                                <tr>
                                    <td style="padding-bottom:10px;position: absolute;">
                                        <p style="margin:0;font-size:12px;line-height:18px;">
                                            <b style="text-transform:uppercase;">Order Number:</b>
                                            #{{ $invoice_number }}
                                        </p>
                                        <p style="margin:0;font-size:12px;line-height:18px;">
                                            <b style="text-transform:uppercase;">Date:</b> {{ $invoice_date }}
                                        </p>
                                    </td>
                                    <td align="right" style="vertical-align:top;">
                                        <p
                                            style="margin:0;font-size:12px;line-height:18px;font-weight:700;color:#013220;text-transform:uppercase;">
                                            Billed To:
                                        </p>
                                        <p style="margin:0;font-size:12px;line-height:18px;">{{ $customer_name }}</p>
                                    </td>
                                </tr>
                            </table>

                            <!-- TOTALS SECTION -->
                            <table width="30%" align="left" cellspacing="0" cellpadding="0" border="0"
                                style="font-family:'Poppins',Arial,sans-serif;border-collapse:collapse;color:#000;
                                          margin:20px 0;padding:10px;border-radius:6px;">

                                <tr>
                                    <td colspan="2" style="padding-top:10px;">
                                        <p style="margin:0;font-size:10px;letter-spacing:1px;color:#777;">INVOICE TOTAL
                                        </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="border-bottom:1px solid #ccc;padding:6px 0;"></td>
                                </tr>

                                <tr>
                                    <td style="padding-top:8px;">
                                        <p style="margin:0;font-size:10px;color:#555;">Subtotal</p>
                                    </td>
                                    <td align="right" style="padding-top:8px;">
                                        <p style="margin:0;font-size:10px;color:#555;">
                                            {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="border-bottom:1px solid #ccc;padding:6px 0;"></td>
                                </tr>

                                <tr>
                                    <td style="padding-top:6px;">
                                        <p style="margin:0;font-size:10px;color:#555;">Discount</p>
                                    </td>
                                    <td align="right" style="padding-top:6px;">
                                        <p style="margin:0;font-size:10px;color:#555;">
                                            {{ site_currency() . number_format($discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="border-bottom:1px solid #ccc;padding:6px 0;"></td>
                                </tr>

                                <!-- GRAND TOTAL -->
                                <tr>
                                    <td colspan="2" style="padding-top:12px;">
                                        <table width="100%" cellspacing="0" cellpadding="0"
                                            style="border-collapse:collapse;">
                                            <tr>
                                                <td
                                                    style="background:#c8a951;padding:6px 10px;font-size:11px;font-weight:700;text-transform:uppercase;">
                                                    Grand Total
                                                </td>
                                                <td align="right"
                                                    style="background:#c8a951;padding:6px 10px;font-size:11px;font-weight:700;">
                                                    {{ site_currency() . number_format($invoice_amount, 2) }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- BILLED FROM INFO -->
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                                style="border-collapse:collapse;">
                                <tr>
                                    <td colspan="2" style="padding:15px 0;">
                                        <p
                                            style="margin:0;font-size:12px;font-weight:700;color:#013220;text-transform:uppercase;">
                                            Billed From:
                                        </p>
                                        <p style="margin:0;font-size:12px;">{{ $site_name }}</p>
                                        <p style="margin:0;font-size:12px;"><b>Email:</b> {{ $company_email }}</p>
                                        <p style="margin:0;font-size:12px;"><b>Phone:</b> {{ $company_mobile }}</p>
                                        <p style="margin:0;font-size:12px;    max-width:270px;"><b>Address:</b> {{ $company_address }}</p>
                                    </td>
                                </tr>
                            </table>

                            <!-- PRODUCT TABLE -->
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                                style="border-collapse:collapse;margin:20px 0;background:#fff;">
                                <tr style="background:#416529;color:#ffffff;">
                                    <td style="padding:5px;font-family:Arial;font-size:11px;font-weight:700;">Product
                                    </td>
                                    <td style="padding:5px;font-family:Arial;font-size:11px;font-weight:700;">Category
                                    </td>
                                    <td style="padding:5px;font-family:Arial;font-size:11px;font-weight:700;">Quantity
                                    </td>
                                    <td style="padding:5px;font-family:Arial;font-size:11px;font-weight:700;">Unit Price
                                    </td>
                                    <td align="right"
                                        style="padding:5px;font-family:Arial;font-size:11px;font-weight:700;">Total</td>
                                </tr>

                                @foreach ($products as $product)
                                    <tr style="border-bottom:1px solid #ddd;">
                                        <td style="padding:5px;font-family:Arial;font-size:10px;">{{ $product->name }}</td>
                                        <td style="padding:5px;font-family:Arial;font-size:10px;">
                                            {{ $product->category_name ?? 'Uncategorized' }}</td>
                                        <td style="padding:5px;font-family:Arial;font-size:10px;">1</td>
                                        <td style="padding:5px;font-family:Arial;font-size:10px;">
                                            {{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                        <td align="right" style="padding:5px;font-family:Arial;font-size:10px;">
                                            {{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                    </tr>
                                @endforeach

                                <tr style="background:#E2EFD9;">
                                    <td colspan="4" style="padding:5px;font-family:Arial;font-size:11px;">Subtotal</td>
                                    <td align="right" style="padding:5px;font-family:Arial;font-size:10px;">
                                        {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                    </td>
                                </tr>
                                <tr style="background:#E2EFD9;">
                                    <td colspan="4" style="padding:5px;font-family:Arial;font-size:11px;">Discount</td>
                                    <td align="right" style="padding:5px;font-family:Arial;font-size:10px;">
                                        {{ site_currency() . number_format($discount_amount, 2) }}
                                    </td>
                                </tr>
                                <tr style="background:#416529;color:#ffffff;">
                                    <td colspan="4" style="padding:5px;font-family:Arial;font-size:11px;">Grand Total
                                    </td>
                                    <td align="right" style="padding:5px;font-family:Arial;font-size:10px;">
                                        {{ site_currency() . number_format($invoice_amount, 2) }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End -->

                    <!-- Footer -->
                    <tr style="position: relative;">
                        <td align="right" style="height:100px;padding:20px;">
                            <img src="{{ $invoice_footer_image }}" alt="Footer Banner"
                                style="width:60px; position: absolute; right: 0;">
                        </td>
                    </tr>
                    <!-- Footer End -->

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
