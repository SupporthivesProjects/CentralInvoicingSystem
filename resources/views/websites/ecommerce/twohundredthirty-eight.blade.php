<!DOCTYPE html>
<html>

<head>
    <style>
        * {
            margin: 0px;
            padding: 0px;
        }
    </style>
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
            <td align="center" style="padding:0px;vertical-align:top;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0"
                    style="border-collapse: collapse;background:url('{{ $invoice_image1 }}');background-size:cover;background-position:center;background-repeat:no-repeat;height:100vh">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 20px 0px 0px 45px;" colspan="2">
                            <table style="margin-top:125px">
                                <tr style=";">
                                    <td style="padding: 5px;">
                                        <p
                                            style="font-size:9px;font-weight:700;font-family:Urbanist;margin: 0px;line-height:16px;text-align:left;color:white;margin-bottom: 0px;">
                                            Invoice No.
                                        </p>
                                    </td>
                                    <td style="padding: 5px;">
                                        <p
                                            style="font-size:9px;font-weight:400;font-family:Urbanist;margin: 0px;line-height:16px;text-align:left;color:white;margin-bottom: 0px;">
                                            {{ $invoice_number }}
                                        </p>
                                    </td>
                                </tr>
                                <tr style=";">
                                    <td style="padding: 5px;">
                                        <p
                                            style="font-size:9px;font-weight:700;font-family:Urbanist;margin: 0px;line-height:16px;text-align:left;color:white;margin-bottom: 0px;">
                                            Date:
                                        </p>
                                    </td>
                                    <td style="padding: 5px;">
                                        <p
                                            style="font-size:9px;font-weight:400;font-family:Urbanist;margin: 0px;line-height:16px;text-align:left;color:white;margin-bottom: 0px;">
                                            {{ $invoice_date }}
                                        </p>
                                    </td>
                                </tr>
                                <tr style=";"></tr>
                                <tr style=";">
                                    <td style="padding: 5px;">
                                        <p
                                            style="font-size:9px;font-weight:700;font-family:Urbanist;margin: 0px;line-height:16px;text-align:left;color:white;margin-bottom: 0px;">
                                            Invoice To:
                                        </p>
                                    </td>
                                    <td style="padding: 5px;">
                                        <p
                                            style="font-size:9px;font-weight:400;font-family:Urbanist;margin: 0px;line-height:16px;text-align:left;color:white;margin-bottom: 0px;">
                                            {{ $customer_name }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td style="padding:40px 20px 0px 20px;width:80%;vertical-align:top;margin-top:10px;" align="center">
                            <table cellspacing="0" cellpadding="0" border="0" width="100%"
                                style="border-collapse: collapse;margin-top:40px;">
                                <tr style="height:50px;border-bottom:1px solid black;">
                                    <td style="width:40%;">
                                        <p
                                            style="font-size: 10px;font-weight:700;font-family:Urbanist;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;text-transform:uppercase;">
                                            ITEM DESCRIPTION
                                        </p>
                                    </td>
                                    <td style="width:20%;">
                                        <p
                                            style="font-size: 10px;font-weight:700;font-family:Urbanist;margin: 0px;line-height: 28px;text-align:center;padding-right:10px;text-transform:uppercase;">
                                            UNIT PRICE
                                        </p>
                                    </td>
                                    <td style="width:20%;">
                                        <p
                                            style="font-size: 10px;font-weight:700;font-family:Urbanist;margin: 0px;line-height: 28px;text-align:center;padding-right:10px;text-transform:uppercase;">
                                            QTY
                                        </p>
                                    </td>
                                    <td style="width:20%;">
                                        <p
                                            style="font-size: 10px;font-weight:700;font-family:Urbanist;margin: 0px;line-height: 28px;text-align:center;padding-right:10px;text-transform:uppercase;">
                                            Total
                                        </p>
                                    </td>
                                </tr>
                                @foreach ($products as $product)
                                    <tr style="height:50px;border-bottom:1px solid black;">
                                        <td>
                                            <p
                                                style="font-size:11px;font-weight: 700;font-family:Urbanist;margin: 0px;line-height:16px;text-align: left;padding-left:10px;">
                                                {{ $product->name }}
                                            </p>
                                        </td>
                                        <td>
                                            <p
                                                style="font-size: 11px;font-weight: 500;font-family:Urbanist;margin: 0px;line-height:16px;text-align:center;padding-right:10px;">
                                                {{ site_currency_code() . number_format($product->unit_price, 2) }}
                                            </p>
                                        </td>
                                        <td>
                                            <p
                                                style="font-size: 11px;font-weight: 500;font-family:Urbanist;margin: 0px;line-height:16px;text-align:center;padding-right:10px;">
                                                1
                                            </p>
                                        </td>
                                        <td>
                                            <p
                                                style="font-size: 11px;font-weight: 500;font-family: Urbanist;margin: 0px;line-height:16px;text-align:center;padding-right:10px;">
                                                {{ site_currency_code() . number_format($product->unit_price, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr style="height:50px;">
                                    <td colspan="2"></td>
                                    <td style="text-align:center;border-bottom:1px solid grey ;">
                                        <p
                                            style="font-size:9px;font-weight:700;font-family:Urbanist;margin: 0px;line-height: 28px;text-align:center;padding-left:10px;text-transform:capitalize;">
                                            Sub total
                                        </p>
                                    </td>
                                    <td style="text-align:center;border-bottom:1px solid grey ;">
                                        <p
                                            style="font-size:9px;font-weight:500;font-family:Urbanist;margin: 0px;line-height: 28px;text-align:center;padding-right:10px;text-transform: uppercase;">
                                            {{ site_currency_code() }} {{ number_format($product->unit_price ?? 0, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr style="height:50px;">
                                    <td colspan="2"></td>
                                    <td style="text-align:center;border-bottom:1px solid grey ;">
                                        <p
                                            style="font-size:9px;font-weight:700;font-family:Urbanist;margin: 0px;line-height: 28px;text-align:center;padding-left:10px;text-transform:capitalize;">
                                            Discount
                                        </p>
                                    </td>
                                    <td style="text-align:center;border-bottom:1px solid grey ;">
                                        <p
                                            style="font-size:9px;font-weight:500;font-family:Urbanist;margin: 0px;line-height: 28px;text-align:center;padding-right:10px;text-transform: uppercase;color:rgb(137, 240, 133);">
                                            {{ site_currency_code() . number_format($discount_amount, 2) }}

                                        </p>
                                    </td>
                                </tr>
                                <tr style="height:50px;">
                                    <td colspan="2"></td>
                                    <td style="text-align:center;border-bottom:1px solid grey ;">
                                        <p
                                            style="font-size:11px;font-weight:700;font-family:Urbanist;margin: 0px;line-height: 28px;text-align:center;padding-left:10px;text-transform:capitalize;">
                                            Grand Total
                                        </p>
                                    </td>
                                    <td style="text-align:center;border-bottom:1px solid grey ;">
                                        <p
                                            style="font-size:11px;font-weight:500;font-family:Urbanist;margin: 0px;line-height: 28px;text-align:center;padding-right:10px;text-transform: uppercase;">
                                            {{ site_currency_code() . number_format($invoice_amount, 2) }}

                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 20%;"></td>
                    </tr>
                    <tr style="height:100%"></tr>
                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr>
                        <td align="center" style="height:50px;" colspan="2">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr>
                                    <td style="padding: 20px 40px;">
                                        <h4
                                            style="font-size:10px;font-weight:700;font-family:Urbanist;margin: 0px;line-height: 28px;text-align:left;padding-left:10px;text-transform:capitalize;">
                                            Contact Details
                                        </h4>
                                        <h4
                                            style="font-size:10px;font-weight:400;font-family:Urbanist;margin: 0px;line-height: 28px;text-align:left;padding-left:10px;text-transform:capitalize;">
                                            {{ $company_email }} <br>
                                            {!! $company_address !!} </h4>
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
