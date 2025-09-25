<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - #{{ $invoice_number }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body style="margin:0px;padding:0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding:0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-----------header----------->
                    <tr>
                        <td align="center" style="padding: 40px;padding-bottom: 0px;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr>
                                    <td>
                                        <img src="{{ $company_logo }}" style="height: 50px">
                                    </td>
                                    <td align="right" style="vertical-align: top;">
                                        <p
                                            style="margin:0px;font-family: Arial;font-size:18px;font-weight: 700;line-height:24px;">
                                            INVOICE
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-----------header End----------->
                    <!-- Content -->
                    <tr style="background:#ffff ;">
                        <td style="padding:10px 40px;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0"
                                style="border-collapse: collapse;">
                                <tr>
                                    <td style="vertical-align: top;">
                                        <p
                                            style="margin:0px;font-family: Arial;font-size:10px;font-weight: 600;line-height: 16px;">
                                            BILLED FROM:
                                        </p>
                                        <p style="margin:0px;font-family: Arial;font-size:10px;line-height: 16px;">
                                            {{ $site_name }} <br>
                                            {{ $company_address }} <br>
                                            {{ $company_email }} <br>
                                            {{ $company_mobile }} <br>
                                        </p>
                                    </td>
                                    <td style="vertical-align: top;" align="right">
                                        <p
                                            style="margin:0px;font-family: Arial;font-size:10px;font-weight: 600;line-height: 16px;">
                                            DATE OF INVOICE:
                                            <br />
                                            {{ $invoice_date }}
                                        </p>
                                        <p
                                            style="margin:0px;font-family: Arial;font-size:10px;font-weight: 600;line-height: 16px;">
                                            INVOICE NO:
                                            <br />
                                            {{ $invoice_number }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top;" align="right" colspan="2">
                                        <p
                                            style="margin:0px;font-family: Arial;font-size:10px;font-weight: 600;line-height: 16px;">
                                            BILLED TO:
                                        </p>
                                        <p style="margin:0px;font-family: Arial;font-size:10px;line-height: 16px;">
                                            {{ $customer_name }} <br>
                                            {{ $customer_mobile }} <br>
                                            {{ $customer_email }} <br>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <div style="min-height: 670px !important;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="1"
                                style="border-collapse: collapse;margin-top: 20px;border-color:rgb(173, 172, 172);">
                                <tr>
                                    <td style="padding: 5px 10px;">
                                        <p
                                            style="margin:0px;font-family: Arial;font-size:9px;font-weight:700;line-height: 16px;color: #AA17F0;">
                                            Game
                                        </p>
                                    </td>
                                    <td style="padding: 5px 10px;">
                                        <p
                                            style="margin:0px;font-family: Arial;font-size:9px;font-weight:700;line-height: 16px;color: #AA17F0;">
                                            In Game Currency
                                        </p>
                                    </td>
                                    <td style="padding: 5px 10px;">
                                        <p
                                            style="margin:0px;font-family: Arial;font-size:9px;font-weight:700;line-height: 16px;color: #AA17F0;">
                                            Unit Price
                                        </p>
                                    </td>
                                    <td style="padding: 5px 10px;">
                                        <p
                                            style="margin:0px;font-family: Arial;font-size:9px;font-weight:700;line-height: 16px;color: #AA17F0;">
                                            Amount
                                        </p>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr style="height:25px;">
                                    <td style="padding: 5px 10px;">
                                        <p style="margin:0px;font-family: Arial;font-size:9px;line-height: 16px;color:#000000;">
                                            {{ $product['name'] }}
                                        </p>
                                    </td>
                                    <td style="padding: 5px 10px;">
                                        <p
                                            style="margin:0px;font-family: Arial;font-size:9px;line-height: 16px;color:#000000;">
                                            {{ $product['game_currency_amount'] }} {{ $product['game_currency'] }}
                                        </p>
                                    </td>
                                    <td style="padding: 5px 10px;">
                                        <p
                                            style="margin:0px;font-family: Arial;font-size:9px;line-height: 16px;color:#000000;">
                                            {{ site_currency() . number_format($product['unit_price'], 2) }}
                                        </p>
                                    </td>
                                    <td style="padding: 5px 10px;">
                                        <p
                                            style="margin:0px;font-family: Arial;font-size:9px;line-height: 16px;color:#000000;">
                                            {{ site_currency() . number_format($product['unit_price'], 2) }}
                                        </p>
                                    </td>
                                </tr>
                                @endforeach
                                <tr style="height:25px;">
                                    <td style="padding: 5px 10px;" colspan="3" align="right">
                                        <p
                                            style="margin:0px;font-family: Arial;font-size:9px;line-height: 16px;color:#000000;font-weight: 600;">
                                            SUBTOTAL
                                        </p>
                                    </td>
                                    <td style="padding: 5px 10px;">
                                        <p
                                            style="margin:0px;font-family: Arial;font-size:9px;line-height: 16px;color:#000000;">
                                            {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr style="height:25px;">
                                    <td style="padding: 5px 10px;" colspan="3" align="right">
                                        <p
                                            style="margin:0px;font-family: Arial;font-size:9px;line-height: 16px;color:#000000;font-weight: 600;">
                                            DISCOUNT
                                        </p>
                                    </td>
                                    <td style="padding: 5px 10px;">
                                        <p
                                            style="margin:0px;font-family: Arial;font-size:9px;line-height: 16px;color:#000000;">
                                            {{ site_currency() . number_format($discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>

                                <tr style="height:25px;">
                                    <td style="padding: 5px 10px;" colspan="3" align="right">
                                        <p
                                            style="margin:0px;font-family: Arial;font-size:9px;line-height: 16px;color:#AA17F0;font-weight: 600;">
                                            TOTAL DUE
                                        </p>
                                    </td>
                                    <td style="padding: 5px 10px;">
                                        <p
                                            style="margin:0px;font-family: Arial;font-size:9px;line-height: 16px;color:#000000;">
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
                        <td align="center" style="padding:40px;">
                            <p style="margin:0px;font-family: Arial;font-size:18px;font-weight: 700;line-height:45px;">
                                Thank you
                            </p>
                            <p
                                style="margin:0px;font-family: Arial;font-size:9px;line-height:14px;font-style: italic;">
                                For questions concerning this invoice, please contact
                            </p>
                            <p style="margin:0px;font-family: Arial;font-size:10px;line-height:14px;">
                                {{ $site_name }}, {{ $company_mobile }}, {{ $company_email }}
                            </p>
                            <p style="margin:0px;font-family: Arial;font-size:10px;line-height:14px;">
                                {{ $site->site_link }}
                            </p>
                        </td>
                    </tr>
                    <!-----------Footer End----------->
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
