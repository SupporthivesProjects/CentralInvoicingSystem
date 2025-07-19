<!DOCTYPE html>
<html>

<head>
    <title>Your Email Title</title>
    <meta charset="UTF-8">
</head>

<body style="margin:0; padding:0; font-family: Arial, sans-serif;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">

                    <!-- Header Image -->
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td
                                        style="background: url('{{ $invoice_header_image }}') no-repeat center/cover; height: 101px;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Content Start -->
                    <tr>
                        <td>
                            <table width="100%" cellpadding="20" cellspacing="0"
                                style="font-family: Arial, sans-serif; font-size: 13px; color: #000;">
                                <tr>
                                    <td>
                                        <table width="100%">
                                            <tr>
                                                <td style="font-size: 14px; font-weight: bold;">{{ $site_name }}</td>
                                                <td align="right"
                                                    style="color: #00b050; font-size: 26px; font-weight: bold;">INVOICE
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top" style="padding-top: 10px;">
                                                    <div style="font-size: 11px;">
                                                        {{ $company_address }}<br />
                                                        {{ $company_phone }}<br />
                                                    </div>
                                                </td>
                                                <td valign="top" align="right" style="padding-top: 10px;">
                                                    <div style="color: #00b050; font-weight: bold;font-size: 11px;">
                                                        INVOICE # <span
                                                            style="font-size: 11px; color: #000 !important;font-weight: 400 !important;">{{ $invoice_number }}</span>
                                                    </div><br>
                                                    <div style="color: #00b050; font-weight: bold; font-size: 11px;">
                                                        DATE <span
                                                            style="font-size: 11px; color: #000 !important;font-weight: 400 !important;">{{ $invoice_date }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 30px; color: #00b050; font-weight: bold;">TO
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ $customer_name }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!-- Invoice Table -->
                                <tr>
                                    <td>
                                        <table width="100%" border="1" cellspacing="0" cellpadding="8"
                                            style="border-collapse: collapse;">
                                            <tr style="background-color: #2f2f82; color: white;">
                                                <th align="left">Game</th>
                                                <th align="right" style="width: 149px;">In Game Currency</th>
                                                <th align="right">Product Price</th>
                                                <th align="right">Amount</th>
                                            </tr>
                                            @foreach($products as $product)
                                            <tr style="font-size: 11px;">
                                                <td>{{ $product['name'] }}</td>
                                                <td align="right">{{ $product['game_currency_amount'] }} {{ $product['game_currency'] }}</td>
                                                <td align="right">{{ $currency . number_format($product['unit_price'], 2) }}</td>
                                                <td align="right" style="font-weight: bold;">{{ $currency . number_format($product['unit_price'], 2) }}</td>
                                            </tr>
                                            @endforeach
                                            <tr style="font-weight: bold;background-color: #f2f2f2;">
                                                <td colspan="" align="left" style="padding-top: 12px;">Subtotal</td>
                                                <td colspan="" align="left" style="padding-top: 12px;"></td>
                                                <td colspan="" align="left" style="padding-top: 12px;"></td>
                                                <td align="right" style="padding-top: 12px;">{{ $currency . number_format($invoice_amount+$discount_amount, 2) }}</td>
                                            </tr>
                                            <tr style="font-weight: bold;background-color: #f2f2f2;">
                                                <td colspan="" align="left" style="padding-top: 12px;">Discount</td>
                                                <td colspan="" align="left" style="padding-top: 12px;"></td>
                                                <td colspan="" align="left" style="padding-top: 12px;"></td>
                                                <td align="right" style="padding-top: 12px;">{{ $currency . number_format($discount_amount, 2) }}</td>
                                            </tr>
                                            <tr style="font-weight: bold;background-color: #f2f2f2;">
                                                <td colspan="" align="left" style="padding-top: 12px;">Grand Total</td>
                                                <td colspan="" align="left" style="padding-top: 12px;"></td>
                                                <td colspan="" align="left" style="padding-top: 12px;"></td>
                                                <td align="right" style="padding-top: 12px;">{{ $currency . number_format($invoice_amount, 2) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!-- Footer Message -->
                                <tr>
                                    <td style="text-align: center; padding: 60px 0px;">
                                        If you have any questions concerning this invoice, email
                                        <strong>{{ $company_email }}</strong><br>
                                        <span style="color: #00b050; font-weight: bold;">Thank you for your
                                            business!</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End -->

                    <!-- Footer Banner -->
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td
                                        style="background: url('{{ $invoice_footer_image }}') no-repeat center/cover; height: 93px;">
                                        <img src="./img/logo_m.png" alt="Logo"
                                            style="margin: auto; display: block; height: 60px;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Footer Banner End -->

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
