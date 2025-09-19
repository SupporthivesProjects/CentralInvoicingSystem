<!DOCTYPE html>
<html>

<head>
    <title>Your Email Title</title>
    <style>
        body{
            margin:0px;
            padding:0px;
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!---header--->
                    <tr>
                        <td align="center"
                            style="height:100px;background:url(img/header-bg.png);background-size: cover;background-repeat: no-repeat;background-position: center;padding: 10px 20px;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr>
                                    <img src="{{ $company_logo }}" alt="" style="height: 50px;">
                                </tr>
                                <tr style="height: 10px;"></tr>
                                <tr>
                                    <img src="{{ $invoice_header_image }}" alt="" style="height:20px;">
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!---header End--->
                    <!-- Content -->
                    <tr style="background:#ffff ;">
                        <td style="padding: 40px;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr>
                                    <td align="left" style="vertical-align: top;">
                                        <h1
                                            style="margin: 0px;font-family: Lato;font-size: 12px;color: #4D4D4D;line-height:18px;">
                                            {{ $site_name }}
                                        </h1>
                                        <p
                                            style="margin: 0px;font-family:Helvetica;font-size: 11px;color: #4D4D4D;line-height:18px;">
                                            {{ $site->site_link }}
                                        </p>
                                        <p
                                            style="margin: 0px;font-family:Helvetica;font-size: 11px;color: #4D4D4D;line-height:18px;">
                                            {{ $company_email }}
                                        </p>
                                        <p
                                            style="margin: 0px;font-family:Helvetica;font-size: 11px;color: #4D4D4D;line-height:18px;">
                                            {{ $company_address }}
                                        </p>
                                    </td>
                                    <td style="width: 40px;"></td>
                                    <td align="center" style="vertical-align: top;">
                                        <img src="{{ $invoice_image1 }}" alt="" style="height: 50px;">
                                        <table>
                                            <tr>
                                                <td>
                                                    <h1
                                                        style="margin: 0px;font-family:Helvetica;font-size: 11px;color: #000000;line-height:18px;">
                                                        Invoice Number
                                                    </h1>
                                                    <p
                                                        style="margin: 0px;font-family:Helvetica;font-size: 11px;color: #4D4D4D;line-height:18px;">
                                                        #{{ $invoice_number }}
                                                    </p>
                                                </td>
                                                <td style="width: 10px;"></td>
                                                <td>
                                                    <h1
                                                        style="margin: 0px;font-family:Helvetica;font-size: 11px;color: #000000;line-height:18px;">
                                                        Date
                                                    </h1>
                                                    <p
                                                        style="margin: 0px;font-family:Helvetica;font-size: 11px;color: #4D4D4D;line-height:18px;">
                                                        {{ $invoice_date }}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr style="height: 20px;"></tr>
                                <tr>
                                    <td align="left" style="vertical-align: top;">
                                        <h1
                                            style="margin: 0px;font-family: Lato;font-size: 12px;color: #4D4D4D;line-height:18px;">
                                            Bill From
                                        </h1>
                                        <p
                                            style="margin: 0px;font-family:Helvetica;font-size: 11px;color: #4D4D4D;line-height:18px;">
                                            {{ $site_name }}
                                        </p>
                                    </td>
                                    <td style=""></td>
                                    <td align="center" style="vertical-align: top;">
                                        <h1
                                            style="margin: 0px;font-family: Lato;font-size: 12px;color: #4D4D4D;line-height:18px;">
                                            Bill To
                                        </h1>
                                        <p
                                            style="margin: 0px;font-family:Helvetica;font-size: 11px;color: #4D4D4D;line-height:18px;">
                                            {{ $customer_name }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <div style="min-height: 620px !important;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;margin-top: 40px;">
                                <tr style="background:#C1A064;">
                                    <td style="padding:5px 10px;">
                                        <p
                                            style="margin: 0px;font-family:Lato;font-size:12px;color: #ffffff;font-weight:700;">
                                            Game
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;">
                                        <p
                                            style="margin: 0px;font-family:Lato;font-size:12px;color: #ffffff;font-weight:700;">
                                            In Game Currency
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;">
                                        <p
                                            style="margin: 0px;font-family:Lato;font-size:12px;color: #ffffff;font-weight:700;">
                                            QTY
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;">
                                        <p
                                            style="margin: 0px;font-family:Lato;font-size:12px;color: #ffffff;font-weight:700;">
                                            UNIT PRICE
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;" align="right">
                                        <p
                                            style="margin: 0px;font-family:Lato;font-size:12px;color: #ffffff;font-weight:700;">
                                            TOTAL
                                        </p>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr>
                                    <td style="height:10px;" colspan="5"></td>
                                </tr>
                                <tr>
                                    <td style="padding:5px 10px;">
                                        <p
                                            style="margin: 0px;font-family: Helvetica;font-size:10px;color: #000000;line-height: 12px;">
                                            {{ $product['name'] }}
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;">
                                        <p
                                            style="margin: 0px;font-family: Helvetica;font-size:10px;color: #000000;line-height: 12px;">
                                            {{ $product['game_currency_amount'] }} {{ $product['game_currency'] }}
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;">
                                        <p
                                            style="margin: 0px;font-family: Helvetica;font-size:10px;color: #000000;line-height: 12px;">
                                            1
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;">
                                        <p
                                            style="margin: 0px;font-family: Helvetica;font-size:10px;color: #000000;line-height: 12px;">
                                            {{ site_currency() . number_format($product['unit_price'], 2) }}
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;" align="right">
                                        <p
                                            style="margin: 0px;font-family: Helvetica;font-size:10px;color: #000000;line-height: 12px;">
                                            {{ site_currency() . number_format($product['unit_price'], 2) }}
                                        </p>
                                    </td>
                                </tr>
                                @endforeach

                                <tr>
                                    <td style="border-bottom:1px solid #C1A064;height:20px;" colspan="5"></td>
                                </tr>
                                <tr>
                                    <td style="height:20px;" colspan="5"></td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="padding:5px 10px;">
                                        <p
                                            style="margin: 0px;font-family: Helvetica;font-size:10px;color: #000000;line-height: 12px;">
                                            SUBTOTAL
                                        </p>
                                    </td>
                                    <td colspan="2" align="right" style="padding:5px 10px;">
                                        <p
                                            style="margin: 0px;font-family: Helvetica;font-size:10px;color: #000000;line-height: 12px;">
                                            {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="padding:5px 10px;">
                                        <p
                                            style="margin: 0px;font-family: Helvetica;font-size:10px;color: #000000;line-height: 12px;">
                                            DISCOUNT
                                        </p>
                                    </td>
                                    <td colspan="2" align="right" style="padding:5px 10px;">
                                        <p
                                            style="margin: 0px;font-family: Helvetica;font-size:10px;color: #000000;line-height: 12px;">
                                            {{ site_currency() . number_format($discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:1px solid #C1A064;height:5px;" colspan="5"></td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="padding:0px 10px;">
                                        <p
                                            style="margin: 0px;font-family:Lato;font-size:12px;color: #000000;line-height: 12px;font-weight: 700;">
                                            GRAND TOTAL
                                        </p>
                                    </td>
                                    <td colspan="2" align="right" style="padding:0px 10px;">
                                        <p
                                            style="margin: 0px;font-family:Lato;font-size:12px;color: #000000;line-height: 12px;font-weight: 700;">
                                            {{ site_currency() . number_format($invoice_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <!-- Content End-->
                    <!-----------Footer----------->
                    <tr>
                        <td align="center">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr>
                                    <img src="{{ $invoice_footer_image }}" alt="" style="height: 20px;">
                                </tr>
                                <tr style="height: 10px;"></tr>
                                <tr>
                                    <td style="background:#C1A064;height:30px;">

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-----------Footer End----------->
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
