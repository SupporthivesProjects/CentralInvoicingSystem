<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        .item-row {
            border-bottom: 2px solid #ffd75f;
        }
    </style>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #ffffff; color: #000;">

    <!-- HEADER -->
    <table width="100%" cellpadding="0" cellspacing="0" style="height:15vh;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0"
                    style="border-radius: 30px; background-color: #0a0033;">
                    <tr>
                        <td width="60%" style="padding: 30px;">
                            <img src="{{ $invoice_header_image }}" alt="Content At A Flash" style="height: 80px;">
                        </td>
                        <td width="40%" align="right" style="padding: 30px;">
                            <span style="font-size: 49px; font-weight: bold; color: #ffd75f;">INVOICE</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- GAP -->
    <div style="height: 30px;"></div>

    <!-- MAIN CONTENT -->
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="height:85vh;">
                    <tr valign="top">
                        <!-- LEFT: Item Table -->
                        <td width="65%" style="padding-right: 20px;">
                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="font-size: 13px; border-collapse: collapse;">
                                <tr
                                    style="color: #0a0033; font-weight: bold; border-bottom: 2px solid #ffd75f;font-size: 9px;">
                                    {{-- <th align="left">DESCRIPTION</th> --}}
                                    <th align="center">UNIT PRICE</th>
                                    <th align="center">QTY</th>
                                    <th align="right">TOTAL</th>
                                </tr>
                                <!-- Repeatable Rows -->
                                @foreach ($products as $product)
                                    <tr style="font-size: 7px;" class="item-row">
                                        <td style="font-size: 7px;"><strong>{{ $product->name }}</strong><br>      
                                        </td>
                                        <td align="center">{{ site_currency() . number_format($product->unit_price, 2)}}</td>
                                        <td align="center">1</td>
                                        <td align="right">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                        <!-- RIGHT: Info Panel -->
                        <td width="30%" valign="top">
                            <table width="100%" cellpadding="25" cellspacing="0"
                                style="background-color: #0a0033; border-radius: 30px; color: white; font-size: 14px; min-height: 386px;">
                                <tr>
                                    <td style="font-size: 8px;text-align: end;">
                                        <div style="margin-bottom: 20px;">INVOICE TO:<br><strong>{{ $customer_name }}</strong>
                                        </div>
                                        <div style="margin-bottom: 20px;">INVOICE NO:<br><strong>{{ $invoice_number }}</strong></div>
                                        <div style="margin-bottom: 180px;">INVOICE DATE:<br><strong>{{ $invoice_date }}
                                                2025</strong></div>
                                        {{-- <div style="margin-bottom: 20px;"><strong>Online Payment</strong><br>Visa or
                                            Mastercard</div> --}}
                                        <div><strong>BILL FROM:</strong><br><strong>{{ $company_name }} <br>
                                                </strong></div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- TOTAL SECTION (Centered Box) -->
                    <tr>
                        <td colspan="2" align="center" style="padding-top: 40px;">
                            <table width="180" cellpadding="0" cellspacing="0"
                                style="font-size: 8px; border-collapse: collapse;">
                                <tr>
                                    <td
                                        style="background-color: #0a0033; color: white; padding: 12px 20px; font-weight: bold; text-transform: uppercase;">
                                        SUBTOTAL</td>
                                    <td style="padding: 12px 20px; border: 1px solid #ddd; text-align: right;">{{ site_currency() .number_format(($invoice_amount + $discount_amount), 2) }}
                                </tr>
                                <tr>
                                    <td
                                        style="background-color: #0a0033; color: white; padding: 12px 20px; font-weight: bold; text-transform: uppercase;">
                                        DISCOUNT</td>
                                    <td style="padding: 12px 20px; border: 1px solid #ddd; text-align: right;">{{ site_currency() .number_format(($discount_amount), 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="background-color: #0a0033; color: white; padding: 12px 20px; font-weight: bold; text-transform: uppercase;">
                                        TOTAL</td>
                                    <td
                                        style="padding: 12px 20px; background-color: #ffd75f; font-size: 10px; font-weight: bold; color: black; text-align: right;">
                                        {{ site_currency() .number_format(($invoice_amount), 2) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- THANK YOU FOOTER -->
                    <tr>
                        <td colspan="2" align="center" style="padding-top: 50px;">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="border-radius: 30px; background-color: #fff;height:15vh">
                                <tr
                                    style="background-image: url({{ $invoice_footer_image }}); background-position: center; background-repeat: no-repeat; background-size: cover;">
                                    <td align="center" style="padding: 30px;">
                                        <h2 style="color: #ffd75f; margin: 0; font-size: 20px;">THANK YOU!</h2>
                                        <p style="color: white; font-size: 12px; margin: 5px 0 0 0; font-size: 5px;">
                                            Contact Us: {{ $company_email }}</p>
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
