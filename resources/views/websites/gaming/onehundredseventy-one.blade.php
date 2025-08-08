<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice - WEDOMMO.CO</title>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f5f5f5;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#f5f5f5">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="margin: 20px auto; border-collapse: collapse; box-shadow: 0 0 5px rgba(0,0,0,0.1);">

                    <!-- Header -->
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0"
                                style="border-collapse: collapse;">
                                <tr style="background: url('{{ $invoice_header_image }}') no-repeat center/cover; height: 141px;">
                                    <td style="text-align: center;position: relative;">
                                        <img src="{{ $invoice_image1 }}" alt="Logo"
                                            style="margin: auto; display: block; height: 135px; position: absolute; margin-left: 31px; margin-top: -10px;">
                                        <div
                                            style="writing-mode: vertical-rl;transform: rotate(180deg);color: #fff;font-weight: bold;font-size: 26px;text-align: right;position: absolute;left: 175px;top: 45px;">
                                            INVOICE</div>
                                        <img src="{{ $company_logo }}" alt="Logo"
                                            style="margin: auto; display: block; height: 60px;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Invoice Content -->
                    <tr>
                        <td style="padding: 20px;">
                            <!-- Billed From and Invoice Info -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 50px;">
                                <tr>
                                    <td valign="top" style="font-size: 12px;">
                                        <strong style="font-size: 18px;">Billed From</strong><br>
                                        {{ $company_name }}<br>
                                        <strong>Address: {{ $company_address }}<br>
                                        <strong>Email:</strong> {{ $company_email }}<br>
                                        <strong>Tel:</strong> {{ $company_mobile }}<br>
                                    </td>
                                    <td valign="top" align="right" style="font-size: 12px;">
                                        <strong style="font-size: 14px;">Invoice#</strong> {{ $invoice_number }}<br>
                                        <strong style="font-size: 14px;">Date:</strong> {{ $invoice_date }}
                                    </td>
                                </tr>
                            </table>

                            <!-- Billed To -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 20px;">
                                <tr style="font-size: 12px;">
                                    <td>
                                        <strong style="font-size: 18px;">Billed To</strong><br>
                                        {{ $customer_name }}<br>
                                    </td>
                                </tr>
                            </table>

                            <!-- Items Table -->
                            <table width="100%" border="0" cellspacing="0" cellpadding="6"
                                style="border-collapse: collapse; margin-top: 10px; font-size: 11px;">
                                <tr style="background-color: black; color: white;">
                                    <th style="border: 1px solid #ccc; text-align: center;">#</th>
                                    <th style="border: 1px solid #ccc; text-align: left;">Item Details</th>
                                    <th style="border: 1px solid #ccc; text-align: right;">Qty</th>
                                    <th style="border: 1px solid #ccc; text-align: right;">Unit Price</th>
                                    <th style="border: 1px solid #ccc; text-align: right;">Total</th>
                                </tr>
                                @foreach($products as $index => $product)
                                <tr style="font-size: 10px;">
                                    <td style="border: 1px solid #ccc; text-align: center;">{{ $index + 1 }}</td>
                                    <td style="border: 1px solid #ccc;">{{ $product['name'] }} - {{ $product['game_currency_amount'] }} {{ $product['game_currency'] }}</td>
                                    <td style="border: 1px solid #ccc; text-align: right;">1</td>
                                    <td style="border: 1px solid #ccc; text-align: right;">{{ $currency . number_format($product['unit_price'], 2) }}</td>
                                    <td style="border: 1px solid #ccc; text-align: right;">{{ $currency . number_format($product['unit_price'], 2) }}</td>
                                </tr>`
                                @endforeach
                            </table>

                            <!-- Summary -->
                            <table width="100%" cellpadding="6" cellspacing="0" style="margin-top: 20px;">
                                <tr>
                                    <td width="60%"></td>
                                    <td width="40%">
                                        <table width="100%" cellpadding="6" cellspacing="0">
                                            <tr>
                                                <td align="left"
                                                    style="background-color: black;font-weight: bold;border: 1px solid #ccc;font-size: 10px;color: white; border: none;">
                                                    Sub Total</td>
                                                <td align="right"
                                                    style="background-color: black;font-weight: bold;border: 1px solid #ccc;font-size: 10px;color: white; border: none;">
                                                    {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left"
                                                    style="background-color: black; font-weight: bold; border: 1px solid #ccc; font-size: 10px; color: white;border: none;">
                                                    Discount</td>
                                                <td align="right"
                                                    style="background-color: black; border: 1px solid #ccc; font-size: 10px; color: white; border: none;">
                                                    {{ site_currency() . number_format($discount_amount, 2) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="right"
                                                    style="background-color: #f5821f; font-size: 20px; font-weight: bold; color: white; padding: 10px;">
                                                    {{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td
                                        style="background: url('{{ $invoice_footer_image }}') no-repeat center/cover; height: 112px;">
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
