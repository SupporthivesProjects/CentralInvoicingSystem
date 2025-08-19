<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name . $invoice_number }}</title>
    <style>
        .footer-fixed {
            position: fixed;
            bottom: 0px;
            left: 0;
            right: 0;
            width: 100%;
            /* background: url('{{ $invoice_footer_image }}') center center no-repeat; */
            /* background-size: cover; */
        }
    </style>
</head>

<body style="margin: 0px; padding: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; background-image: url('{{ $invoice_image1 }}'); background-position: center; background-repeat: no-repeat; background-size: cover; height: 920px;">
                    <!-- Header -->
                    <tr>
                        <td style="height: 165px;">
                            <table style="font-family: 'ole'; padding: 35px; width: 100%;">
                                <tr>
                                    <td align="left">
                                        <img src="{{ $company_logo }}" alt="" style="width: 231px; height: 20px;">
                                    </td>
                                    <td align="right">
                                        <p style="font-size: 39px; font-weight: bold; color: #BEC543; margin: 0%;">
                                            INVOICE</p>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr>

                        <td style="font-family: 'ole'; font-size: 9px; vertical-align: top;">

                            <table width="100%" cellpadding="1" style="padding:40px; padding-bottom: 0%;">
                                <tr>
                                    <td align="left" width="52%">
                                        <p style="margin: 0%; color: #ffffff; font-size: 11px; font-weight: bold;">
                                            Invoice To : </p>
                                    </td>
                                    <td align="left">
                                        <p style="margin: 0%; font-size: 11px; font-weight: bold;">Invoice Information :
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: top;">
                                        <p style="margin: 0%;  color: #BEC543; font-size: 12px; font-weight: bold;">
                                            {{ $customer_name }}</p>
                                    </td>
                                    <td align="left">
                                        <p style="margin: 0%; font-size: 9px;">Number <br>{{ $invoice_number }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left"> </td>
                                    <td align="left">
                                        <p style="margin: 0%; font-size: 9px;">Invoice Date <br>{{ $invoice_date }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <table width="100%" border="0" cellspacing="0" cellpadding="11"
                                style="border-collapse: collapse; color: white;">
                                <tr style="background-color: #0d1f1f; font-size: 10px;">
                                    <th align="left" style="color: #c3d94c; padding-left: 40px; width: 251px;">
                                        DESCRIPTION</th>
                                    <th align="center" style="color: #c3d94c;">UNIT PRICE</th>
                                    <th align="center" style="color: #c3d94c;">QTY</th>
                                    <th align="center" style="color: #c3d94c; padding-right: 40px;">TOTAL</th>
                                </tr>

                                <!-- Row 1 -->
                                 @foreach($products as $product)
                                <tr style="font-size: 9px;">
                                    <td style="padding-left: 40px; font-size: 9px; border-bottom: 1px solid #D9D9D9;">
                                        <strong>{{ $product->name }}</strong><br>
                                        <span style="font-size: 7px;">IMAGES : {{ $product->imagecount }}<br>WORDS : {{ $product->wordcount }}</span>
                                    </td>
                                    <td align="center" style="color: black;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                    <td align="center" style="color: black;">1</td>
                                    <td align="center" style="color: black; padding-right: 40px;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                </tr>
                                @endforeach
                            </table>
                            <br>
                            <table align="right" width="27%" border="0" cellspacing="0" cellpadding="0"
                                style="color: #ffffff; font-size: 9px; margin-top: 35px; padding-right: 40px;">
                                <tr>
                                    <td style="padding-bottom: 12px">Sub Total</td>
                                    <td align="right" style="padding-bottom: 12px font-size: 10px;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 12px">Discount</td>
                                    <td align="right" style="padding-bottom: 12px font-size: 10px;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="border-top: 1px solid #BEC543; color: #BEC543; padding-top: 12px">TOTAL</td>
                                    <td align="right" style="border-top: 1px solid #BEC543;font-size: 10px; color: #BEC543; padding-top: 12px">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                </tr>

                            </table>




                        </td>
                    </tr>
                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr>
                        <td>
                            <table style="width: 100%; border-collapse: collapse; font-family: 'ole';">
                                <tr>
                                    <td
                                        style="color: white; padding: 40px; width: 50%; vertical-align: middle;">
                                        <p style="margin: 0; font-weight: bold; color: #d6d94d; font-size: 8px;">CONTACT US</p>
                                        <p style="margin: 5px 0 0; font-weight: bold; font-size: 8px; color: #d6d94d;">{{ $company_name }}
                                        </p>
                                        <p style="margin: 5px 0 0; font-size: 7px;">{!! $company_address !!}<br>
                                            {{ $company_mobile }}
                                        </p>
                                        <p style="margin: 10px 0 0; font-size: 7px; color: white;">{{ $company_email }}</p>
                                    </td>
                                    <td
                                        style=" padding: 40px;vertical-align: bottom; color: #0f1f20; text-align: end; font-size: 28px;">
                                        Thank You!
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