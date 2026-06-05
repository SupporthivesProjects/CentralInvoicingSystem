<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>

<body style="margin:0;padding:0;background:#f5f5f5;font-family:'Lato';">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td align="center">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#0E162D;">

    <!-- HEADER -->
    <tr>
        <td>

            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>

                    <!-- LEFT -->
                    <td valign="top" style="padding: 24px;">

                        <img src="{{ $company_logo }}"
                             width="230"
                             alt="HoneyBee"
                             style="display:block;">

                        <div style="
                            color:#F8D94D;
                            font-size:58px;
                            line-height:58px;
                            margin-top:25px;">
                            INVOICE
                        </div>

                        <table cellpadding="0" cellspacing="0" border="0" style="margin-top: 6px;">
                            <tr>
                                <td style="color:#ffffff;font-size:11px;padding-right:152px;">
                                    {{ $invoice_number }}
                                </td>

                                <td style="color:#ffffff;font-size:12px;">
                                   {{ $invoice_date }}
                                </td>
                            </tr>
                        </table>

                        <table cellpadding="0" cellspacing="0" border="0"
                               style="margin-top:30px;">
                            <tr>
                                <td style="color:#ffffff;font-size:14px;">
                                    Invoice To :
                                </td>
                            </tr>

                            <tr>
                                <td style="
                                    color:#ffffff;
                                    font-size:20px;
                                    font-weight:bold;
                                    padding-top:6px;">
                                   {{ $customer_name }}
                                </td>
                            </tr>
                        </table>

                    </td>

                    <!-- RIGHT -->
                    <td valign="top" align="right">

                        <img src="{{ $invoice_image1 }}"
                             width="230"
                             alt=""
                             style="display:block;">

                        <table cellpadding="0"
                               cellspacing="0"
                               border="0"
                               style="margin-top:30px; padding: 0px 30px 30px 0px;">
                            <tr>
                                <td align="left"
                                    style="font-size:12px;color:#ffffff; ">
                                    Total Due
                                </td>
                            </tr>

                            <tr>
                                <td align="right"
                                    style="
                                    color:#F8D94D;
                                    font-size:30px;
                                    font-weight:bold;
                                    padding-top:4px;">
                                   {{ site_currency() . number_format($invoice_amount, 2) }}
                                </td>
                            </tr>
                        </table>

                    </td>

                </tr>
            </table>

        </td>
    </tr>

    <!-- YELLOW DIVIDER IMAGE -->
    <tr>
        <td>
            <img src="{{ $invoice_image2 }}"
                 width="600"
                 alt=""
                 style="display:block;width:100%;">
        </td>
    </tr>

    <!-- TABLE SECTION -->
    <tr>
        <td style="padding:25px 20px;min-height:400px;height:400px;vertical-align:top;">

            <table width="100%" cellpadding="0" cellspacing="0" border="0">

                <!-- HEADINGS -->
                <tr>
                    <td style="color:#F8D94D;font-size:11px;font-weight:bold;padding:15px 15px 15px 25px;">
                        ITEM DESCRIPTION
                    </td>

                    <td align="center"
                        style="color:#F8D94D;font-size:11px;font-weight:bold;padding:15px;">
                        UNIT PRICE
                    </td>

                    <td align="center"
                        style="color:#F8D94D;font-size:11px;font-weight:bold;padding:15px;">
                        QTY
                    </td>

                    <td align="right"
                        style="color:#F8D94D;font-size:11px;font-weight:bold;padding:15px 25px 15px 15px ;">
                        TOTAL
                    </td>
                </tr>

                <!-- BORDER -->
                <tr>
                    <td colspan="4"
                        style="border-top:1px solid #F8D94D;height:10px;">
                    </td>
                </tr>

                @foreach($products as $product)
                <!-- ROWS -->
                <tr>
                    <td style="color:#ffffff;font-size:10px;padding:12px 12px 15px 22px;">{{ $product->name }}</td>
                    <td align="center" style="color:#ffffff;font-size:10px;">{{ site_currency() . number_format($product->price ?? $product->unit_price ?? 0, 2) }}</td>
                    <td align="center" style="color:#ffffff;font-size:10px;">{{ $product->quantity ?? 1 }}</td>
                    <td align="right" style="color:#ffffff;font-size:10px; padding:12px 25px 12px 12px;">{{ site_currency() . number_format($product->price ?? $product->unit_price ?? 0, 2) }}</td>
                </tr>
                @endforeach

            </table>

            <!-- TOTALS -->
            <table width="230"
                   align="right"
                   cellpadding="0"
                   cellspacing="0"
                   border="0"
                   style="margin-top:25px;">

                <tr>
                    <td colspan="2"
                        style="border-top:2px solid #F8D94D;height:20px;">
                    </td>
                </tr>

                <tr>
                    <td align="center" style="color:#F8D94D;font-size:10px;font-weight:bold;">
                        SUBTOTAL
                    </td>

                    <td align="center"
                        style="color:#ffffff;font-size:10px;">
                       {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                    </td>
                </tr>

                <tr>
                    <td align="center" style="color:#F8D94D;font-size:10px;font-weight:bold;padding-top:8px;">
                        DISCOUNT
                    </td>

                    <td align="center"
                        style="color:#ffffff;font-size:10px;padding-top:8px;">
                       {{ site_currency() . number_format($discount_amount, 2) }}
                    </td>
                </tr>

                <tr>
                    <td align="center" style="color:#F8D94D;font-size:10px;font-weight:bold;padding-top:8px;">
                        TOTAL
                    </td>

                    <td align="center"
                        style="color:#ffffff;font-size:10px;padding-top:8px;">
                        {{ site_currency() . number_format($invoice_amount, 2) }}
                    </td>
                </tr>

            </table>

        </td>
    </tr>

    <!-- FOOTER -->
    <tr>
        <td style="background:url('{{ $invoice_footer_image }}');padding:30px; background-size: 100% 100%;">

            <table width="100%" cellpadding="0" cellspacing="0" border="0">

                <tr>

                    <td valign="top">

                        <div style="font-size:12px;font-weight:bold;">
                            Invoice From
                        </div>

                        <table cellpadding="0" cellspacing="0" border="0"
                               style="margin-top:10px;">
                            <tr>
                                <td style="font-size:10px;font-weight:bold;padding-right:15px;">
                                    Company Name
                                </td>

                                <td style="font-size:8px;">
                                   {{ $company_name }}
                                </td>
                            </tr>

                            <tr>
                                <td style="font-size:10px;font-weight:bold;padding-top:5px;">
                                    Address
                                </td>

                                <td style="font-size:8px;padding-top:5px;">
                                   {{ strip_tags($company_address) }}
                                </td>
                            </tr>
                        </table>

                    </td>

                    <td align="right" valign="bottom">

                        <span style="font-size:9px;color:#333;">
                            {{ $company_email ?? 'support@honeybeegiftcards.com' }}
                        </span>

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