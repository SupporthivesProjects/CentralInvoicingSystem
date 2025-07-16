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
                <table width="100%" cellspacing="0" cellpadding="0" border="0"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);background: #bacbe4;">
                    <!---header--->
                    <tr>
                        <td align="center" style="padding: 20px 20px;border-bottom: 2px solid black;" colspan="2">
                            <img src="{{ $company_logo }}" alt="" style="height:190px;width: 100%;">
                        </td>
                    </tr>
                    <!---header End--->

                    <!-- Content -->
                    <tr>
                        <td
                            style="padding:40px 20px 40px 40px;border-right: 2px solid black;vertical-align: top;width: 30%;">
                            <p style="margin: 0px;font-size: 9px;font-weight: 700;font-family:Arial;line-height: 12px;">
                                Invoice Number:
                            </p>
                            <p style="margin: 0px;font-size: 9px;font-family:Arial;line-height: 12px;">
                                #{{ $invoice_number }}
                            </p>
                            <br>
                            <br>
                            <p style="margin: 0px;font-size: 9px;font-weight: 700;font-family:Arial;line-height: 12px;">
                                Date:
                            </p>
                            <p style="margin: 0px;font-size: 9px;font-family:Arial;line-height: 12px;">
                                {{ $invoice_date }}
                            </p>
                            <br>
                            <p style="margin: 0px;font-size: 9px;font-weight: 700;font-family:Arial;line-height: 12px;">
                                Bill to:
                            </p>
                            <p style="margin: 0px;font-size: 9px;font-family:Arial;line-height: 12px;">
                                {{ $customer_name }}
                            </p>
                            <br>
                            <p style="margin: 0px;font-size: 9px;font-weight: 700;font-family:Arial;line-height: 12px;">
                                Bill From:
                            </p>
                            <p style="margin: 0px;font-size: 9px;font-family:Arial;line-height: 12px;">
                                {{ $site_name }}
                            </p>
                            <br>
                            <p style="margin: 0px;font-size: 9px;font-weight: 700;font-family:Arial;line-height: 12px;">
                                Email:
                            </p>
                            <p style="margin: 0px;font-size: 9px;font-family:Arial;line-height: 12px;">
                                {{ $company_email }}
                            </p>
                            <br>
                            <p style="margin: 0px;font-size: 9px;font-weight: 700;font-family:Arial;line-height: 12px;">
                                Phone
                            </p>
                            <p style="margin: 0px;font-size: 9px;font-family:Arial;line-height: 12px;">
                                {{ $company_mobile }}
                            </p>
                            <br>
                            <p style="margin: 0px;font-size: 9px;font-weight: 700;font-family:Arial;line-height: 12px;">
                                Address
                            </p>
                            <p style="margin: 0px;font-size: 9px;font-family:Arial;line-height: 12px;">
                                {{ $company_address }}
                            </p>
                        </td>
                        <td style="padding: 20px;vertical-align: top;">
                            <div style="min-height: 700px !important;">
                            <table cellspacing="0" cellpadding="0" border="0"
                                style="border-collapse: collapse;margin-bottom: 150px;" width="100%">
                                <tr style="border-top: 1px solid black;border-bottom: 2px solid black;">
                                    <td style="padding: 5px;">
                                        <p
                                            style="margin: 0px;font-size: 9px;font-weight: 700;font-family:Arial;line-height: 12px;">
                                            Product
                                        </p>
                                    </td>
                                    <td style="padding: 5px;width:70px;" align="center">
                                        <p
                                            style="margin: 0px;font-size: 9px;font-weight: 700;font-family:Arial;line-height: 12px;">
                                            Qty
                                        </p>
                                    </td>
                                    <td style="padding: 5px;width:70px;" align="right">
                                        <p
                                            style="margin: 0px;font-size: 9px;font-weight: 700;font-family:Arial;line-height: 12px;">
                                            Amount
                                        </p>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr style="border-top: 1px solid black;border-bottom: 2px solid black;">
                                    <td style="padding: 5px;">
                                        <p
                                            style="margin: 0px;font-size:10px;font-weight: 700;font-family:Arial;line-height: 12px;">
                                            {{ $product->name }}
                                        </p>
                                    </td>
                                    <td style="padding: 5px;width:70px;vertical-align: top;" align="center">
                                        <p
                                            style="margin: 0px;font-size:10px;font-weight: 700;font-family:Arial;line-height: 12px;">
                                            1
                                        </p>
                                    </td>
                                    <td style="padding: 5px;width:70px;vertical-align: top;" align="right">
                                        <p
                                            style="margin: 0px;font-size:10px;font-weight: 700;font-family:Arial;line-height: 12px;">
                                            {{ site_currency() . number_format($product->unit_price, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td style="padding: 5px;width:70px;vertical-align: top;border-bottom: 1px solid black;"
                                        align="left">
                                        <p style="margin: 0px;font-size:9px;font-family:Arial;line-height: 12px;">
                                            SUB-TOTAL
                                        </p>
                                    </td>
                                    <td style="padding: 5px;width:70px;vertical-align: top;border-bottom: 1px solid black;"
                                        align="right">
                                        <p style="margin: 0px;font-size:9px;font-family:Arial;line-height: 12px;">
                                            {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="padding: 5px;width:70px;vertical-align: top;border-bottom: 1px solid black;"
                                        align="left">
                                        <p style="margin: 0px;font-size:9px;font-family:Arial;line-height: 12px;">
                                            DISCOUNT
                                        </p>
                                    </td>
                                    <td style="padding: 5px;width:70px;vertical-align: top;border-bottom: 1px solid black;"
                                        align="right">
                                        <p style="margin: 0px;font-size:9px;font-family:Arial;line-height: 12px;">
                                            {{ site_currency() . number_format($discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="padding: 5px;width:70px;vertical-align: top;" align="left">
                                        <p
                                            style="margin: 0px;font-size:9px;font-family:Arial;line-height: 12px;font-weight: 700;">
                                            TOTAL
                                        </p>
                                    </td>
                                    <td style="padding: 5px;width:70px;vertical-align: top;" align="right">
                                        <p style="margin: 0px;font-size:9px;font-family:Arial;line-height: 12px;">
                                            {{ site_currency() . number_format($invoice_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <!-- Content End-->
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
