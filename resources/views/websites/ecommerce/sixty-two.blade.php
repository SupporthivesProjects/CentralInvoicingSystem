<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>

<body style="margin: 0px; padding: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td style="padding: 0; height: 130px;">
                            <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                                <tr>
                                    <td style="background: url('{{ $invoice_header_image }}') no-repeat center;background-size: cover;height: 130px;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="padding:40px;padding-top:0px;background:#ffffff; background-repeat: no-repeat;background-position: center;background-size: cover;height:444px; font-family: 'Yu Gothic';">
                            <br>
                            <br>
                            <table width="100%" border="1" cellpadding="10" cellspacing="0"
                                style="border-collapse: collapse; font-family: 'Century Gothic (Headings)'; width: 800px; margin: auto;">
                                <!-- Header -->
                                <tr>
                                    <td colspan="4" align="center" style="font-size: 36px; color: #E62E2D; ">INVOICE
                                    </td>
                                </tr>

                                <!-- Spacer -->
                                <tr>
                                    <td colspan="4" style="padding: 0;">&nbsp;</td>
                                </tr>

                                <!-- Invoice Info -->
                                <tr>
                                    <!-- Date and Invoice Number -->
                                    <td colspan="2"
                                        style="vertical-align: top; font-size: 9px; width: 70%;  padding-top: 0px;">

                                        <div style="min-height: 80px !important;">
                                            <table>
                                                <tr style=" padding-top: 0px;">
                                                    <td style="color: #E62E2D; font-weight: bold;  padding-top: 0px; ">DATE:
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="color: #000;">{{ $invoice_date }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="height: 2px;"></td>
                                                </tr>
                                                <tr>
                                                    <td style="color: #E62E2D; font-weight: bold;">INVOICE #</td>
                                                </tr>
                                                <tr>
                                                    <td style="color: #000;">{{ $invoice_number }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="height: 20px;"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>

                                    <!-- To Section -->
                                    <td style="width: 9px; vertical-align: top; font-size: 9px; padding-top: 0px;">
                                        <span style="color: #E62E2D; font-weight: bold;  ">TO:</span>
                                    </td>
                                    <td align="right" style=" vertical-align: top; font-size: 9px;  padding-top: 0px;">
                                        {{ $customer_name }}
                                    </td>
                                </tr>
                            </table>
                            <div style="min-height: 610px !important;">
                                <table width="100%" border="1" cellspacing="0" cellpadding="8"
                                    style="border-collapse: collapse; font-family:'Century Gothic (Headings)'; font-size: 9px; width: 800px; margin: auto; margin-top: 20px; text-align: left;">
                                    <tr>
                                        <th style="color: red;">QTY</th>
                                        <th style="color: red;">DESCRIPTION</th>
                                        <th align="right" style="color: red;">UNIT PRICE</th>
                                        <th align="right" style="color: red;">LINE TOTAL</th>
                                    </tr>
                                    @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->quantity ?? 1 }}</td>
                                        <td> {{ $product->name }}</td>
                                        <td align="right"> {{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                        <td align="right"> {{ site_currency() . number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td style="color: red; font-weight: bold;" align="left">SUBTOTAL</td>
                                        <td align="right" style="color: red; font-weight: bold; border: 2px solid red; background-color: #FAE5E5;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td style="color: red; font-weight: bold;" align="left">DISCOUNT</td>
                                        <td align="right" style="color: red; font-weight: bold; border: 2px solid red; background-color: #FAE5E5;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td style="color: red; font-weight: bold;" align="left">TOTAL</td>
                                        <td align="right" style="color: red; font-weight: bold; border: 2px solid red; background-color: #FAE5E5;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                    </tr>
                                </table>
                            </div>
                            <!-- Footer -->
                            <table width="100%" cellpadding="8"
                                style="font-family:'Century Gothic (Headings)'; font-size: 9px; width: 800px; margin: auto; margin-top: 20px; text-align: center;">
                                <tr>
                                    <td style="color: red; font-weight: bold; padding: 0%;">MAKE ALL CHECKS PAYABLE TO BEEFITARO.CO
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: red; padding-top: 0%;">Thank you for your business!</td>
                                </tr>
                                <tr>
                                    <td style="color: red; font-weight: bold;">{{ $site_name }}.co  | {!! $company_address ?? 'N/A' !!}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr
                                    style="background: url('{{ $invoice_footer_image }}') no-repeat;background-position: center;background-size: cover;height:141px;padding:50px;background-size:cover;width: 100%;">
                                    <td style="text-align:center;">
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