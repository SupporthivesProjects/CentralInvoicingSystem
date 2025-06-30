<!DOCTYPE html>
<html>

<head>
    <title>Your Email Title</title>
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
                            style="height:100px;background:url('{{ $invoice_header_image }}');background-size: cover;background-repeat: no-repeat;background-position: center;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr>
                                    <td align="center" style="width: 50%;">
                                        <h1 style="margin: 0px;font-family: Avenir Black;font-size: 37px;color: #ffff;">
                                            INVOICE
                                        </h1>
                                    </td>
                                    <td align="center" style="width: 50%;">
                                        <img src="{{ $company_logo }}" alt="" style="height:60px;">
                                    </td>
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
                                    <td align="center" style="vertical-align: top;">
                                        <table width="100%">
                                            <tr style="background: #B2B2B2;">
                                                <td style="padding:5px 10px;">
                                                    <p
                                                        style="margin: 0px;font-family: Avenir Black;font-size:13px;color: #000000;font-weight: 600;">
                                                        BILL FROM
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-bottom:1px solid #B2B2B2;height: 10px;"></td>
                                            </tr>
                                            <tr>
                                                <td style="padding:5px 0px;">
                                                    <p
                                                        style="margin: 0px;font-family: Avenir Black;font-size:8px;color: #000000;font-weight:600;line-height: 12px;">
                                                        {{ $site_name }}
                                                    </p>
                                                    <p
                                                        style="margin: 0px;font-family: Avenir Black;font-size:8px;color: #000000;line-height: 12px;">
                                                        {{ $company_address }}<br />
                                                        {{ $company_mobile }}
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-bottom:1px solid #B2B2B2;height:1px;"></td>
                                            </tr>
                                            <tr>
                                                <td style="padding:5px 0px;">
                                                    <p
                                                        style="margin: 0px;font-family: Avenir Black;font-size:8px;color: #000000;line-height: 12px;">
                                                        <b>Email:</b> {{ $company_email }}
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-bottom:1px solid #B2B2B2;height:1px;"></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="width: 40px;"></td>
                                    <td align="center" style="vertical-align: top;">
                                        <table width="100%">
                                            <tr style="background: #B2B2B2;">
                                                <td style="padding:5px 10px;">
                                                    <p
                                                        style="margin: 0px;font-family: Avenir Black;font-size:13px;color: #000000;font-weight: 600;">
                                                        BILL TO
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-bottom:1px solid #B2B2B2;height:10px;"></td>
                                            </tr>
                                            <tr>
                                                <td style="padding:5px 0px;">
                                                    <p
                                                        style="margin: 0px;font-family: Avenir Black;font-size:8px;color: #000000;line-height: 12px;font-weight: 600;">
                                                        #{{ $invoice_number }}<br />
                                                        {{ $invoice_date }}<br />
                                                        {{ $customer_name }}
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-bottom:1px solid #B2B2B2;height:1px;"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <div style="min-height: 450px !important;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;margin-top: 40px;">
                                <tr style="background: #B2B2B2;">
                                    <td style="padding:5px 10px;">
                                        <p
                                            style="margin: 0px;font-family: Avenir Black;font-size:13px;color: #000000;font-weight: 600;">
                                            #
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;">
                                        <p
                                            style="margin: 0px;font-family: Avenir Black;font-size:13px;color: #000000;font-weight: 600;">
                                            Product Name
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;">
                                        <p
                                            style="margin: 0px;font-family: Avenir Black;font-size:13px;color: #000000;font-weight: 600;">
                                            QTY
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;">
                                        <p
                                            style="margin: 0px;font-family: Avenir Black;font-size:13px;color: #000000;font-weight: 600;">
                                            UNIT PRICE
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;" align="right">
                                        <p
                                            style="margin: 0px;font-family: Avenir Black;font-size:13px;color: #000000;font-weight: 600;">
                                            TOTAL
                                        </p>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr>
                                    <td style="border-bottom:1px solid #B2B2B2;height:10px;" colspan="5"></td>
                                </tr>
                                <tr>
                                    <td style="padding:5px 10px;">
                                        <p
                                            style="margin: 0px;font-family: Avenir Black;font-size:8px;color: #000000;line-height: 12px;">
                                            {{ $loop->iteration }}
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;">
                                        <p
                                            style="margin: 0px;font-family: Avenir Black;font-size:8px;color: #000000;line-height: 12px;">
                                            {{ $product->name }}
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;">
                                        <p
                                            style="margin: 0px;font-family: Avenir Black;font-size:8px;color: #000000;line-height: 12px;">
                                            1
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;">
                                        <p
                                            style="margin: 0px;font-family: Avenir Black;font-size:8px;color: #000000;line-height: 12px;">
                                            {{ site_currency() . number_format($product->unit_price, 2) }}
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;" align="right">
                                        <p
                                            style="margin: 0px;font-family: Avenir Black;font-size:8px;color: #000000;line-height: 12px;">
                                            {{ site_currency() . number_format($product->unit_price, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td style="border-top:1px solid #B2B2B2;height:50px;" colspan="5"></td>
                                </tr>
                                <tr>
                                    <td style="padding:5px 10px;" colspan="2"></td>
                                    <td style="padding:5px 10px;border-bottom:1px solid #B2B2B2;" colspan="2">
                                        <p
                                            style="margin: 0px;font-family: Avenir Black;font-size:10px;color: #000000;line-height: 14px;">
                                            SUBTOTAL
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;border-bottom:1px solid #B2B2B2;" align="right">
                                        <p
                                            style="margin: 0px;font-family: Avenir Black;font-size:10px;color: #000000;line-height: 14px;">
                                            {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:5px 10px;" colspan="2"></td>
                                    <td style="padding:5px 10px;border-bottom:1px solid #B2B2B2;" colspan="2">
                                        <p
                                            style="margin: 0px;font-family: Avenir Black;font-size:10px;color: #000000;line-height: 14px;">
                                            DISCOUNT
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;border-bottom:1px solid #B2B2B2;" align="right">
                                        <p
                                            style="margin: 0px;font-family: Avenir Black;font-size:10px;color: #000000;line-height: 14px;">
                                            {{ site_currency() . number_format($discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:5px 10px;" colspan="2"></td>
                                    <td style="padding:5px 10px;" colspan="2">
                                        <p
                                            style="margin: 0px;font-family: Avenir Black;font-size:10px;color: #000000;line-height: 14px;font-weight:700;">
                                            GRAND TOTAL
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;" align="right">
                                        <p
                                            style="margin: 0px;font-family: Avenir Black;font-size:10px;color: #000000;line-height: 14px;font-weight:700;">
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
                                    <td style="background: url('{{ $invoice_footer_image }}');background-size: cover;height: 150px;background-position: center;background-repeat: no-repeat;"
                                        align="center">
                                        <table>
                                            <tr>
                                                <td style="background: url('{{ $invoice_image1 }}');background-size: cover;background-position: center;background-repeat:no-repeat;width:200px;height:100px;vertical-align: bottom;padding-bottom: 10px;box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);"
                                                    align="center">
                                                    <p
                                                        style="margin: 0px;font-family: Avenir Black;font-size:8px;color: #000000;line-height: 14px;">
                                                        {{ $company_address }}
                                                    </p>
                                                </td>
                                                <td style="width:40px;"></td>
                                                <td style="background: url('{{ $invoice_image2 }}');background-size: cover;background-position: center;background-repeat:no-repeat;width:200px;height:100px;vertical-align: bottom;padding-bottom: 10px;box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);"
                                                    align="center">
                                                    <p
                                                        style="margin: 0px;font-family: Avenir Black;font-size:8px;color: #000000;line-height: 14px;">
                                                        {{ $company_email }}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="background: url('{{ $invoice_image3 }}');background-size: cover;height:40px;background-position: center;">

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
