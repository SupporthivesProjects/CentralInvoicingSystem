<!DOCTYPE html>
<html>

<head>
    <title>Your Email Title</title>
</head>

<style>

    .footer-fixed {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
    }
</style>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#ffffff" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse;">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;max-height: 130px;">
                            <table width="100%">
                                <tr>
                                    <td style="height: 40px; width: 600px;">
                                        <!-- <img src="Picture1.png" alt="" style="margin: auto; display: block;height:60px;"> -->
                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                    <!-- Content -->
                    <tr>
                        <td style="padding:40px;padding-top:0px;">
                            <table width="100%">
                                <tr>
                                    <td style="">
                                        <img src="{{ $invoice_header_image }}" alt=""
                                            style="margin: auto;margin-left: 0px; display: block;height: 30px;">
                                        <br>
                                        <br>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 700;">

                                            <strong> BILLED FROM:</strong>

                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            www.thedigitalkreator.co
                                        </p>

                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            Website: {{ $site->site_link }}
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            Email: {{ $company_email }}
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            Number: {{ $company_mobile }}</p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            Address: {{ $company_address }}</p>
                                    </td>
                                    <td style="text-align: right;">
                                        <h1
                                            style="font-family: arial;font-size: 20px;margin: 0px;font-weight: 700;padding-top: 0px;">
                                            INVOICE</h1><br><br>
                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            INVOICE # {{ $invoice_number }}
                                        </p>

                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            DATE: {{ $invoice_date }}
                                        </p><br>

                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <b>
                                                BILLED TO:
                                            </b>
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            {{ $customer_name }}
                                        </p>

                                    </td>
                                </tr>
                            </table>
                           
                        </td>
                    </tr>
                    <tr>
                         <table width="100%"
                                style="border: 1px solid black;border-collapse: collapse;border-bottom: 0px;border-left: 0px;">
                                <tr style="border: 1px solid black;border-collapse: collapse;height: 24px;">
                                    <td
                                        style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        <b>QUANTITY</b>
                                    </td>
                                    <td
                                        style="width: 250px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        <b>Product</b>
                                    </td>

                                    <td
                                        style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        <b>UNIT PRICE</b>
                                    </td>
                                    <td
                                        style="width:100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        <b>TOTAL</b>
                                    </td>
                                </tr>
                                @foreach ($products as $product)
                                    <tr style="border: 1px solid black;border-collapse: collapse;height: 24px;">
                                        <td
                                            style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                            1
                                        </td>
                                        <td
                                            style="width: 250px;text-align: center;font-family: arial;font-size:10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                            {{ $product->name }}<br />
                                        </td>

                                        <td
                                            style="width:100px;text-align:center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                            {{ site_currency() }} {{ number_format($product->unit_price, 2) }}
                                        </td>
                                        <td
                                            style="width:100px;text-align:center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                            {{ site_currency() }} {{ number_format($product->unit_price, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2"></td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;"
                                        colspan="1">
                                        <p><b>
                                                SUBTOTAL
                                            </b></p>
                                    </td>
                                    <td style="text-align:center;font-family: arial;font-size: 10px;font-weight: 400;border: 1px solid black;"
                                        colspan="4">
                                        <p><b>
                                            {{ site_currency() }} {{  number_format(($invoice_amount + $discount_amount), 2) }}
                                            </b></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;"
                                        colspan="1">
                                        <p>
                                            Discount
                                        </p>
                                    </td>
                                    <td style="text-align:center;font-family: arial;font-size: 10px;font-weight: 400;border: 1px solid black;"
                                        colspan="4">
                                        <p><b>
                                            {{ site_currency() }} {{  number_format($discount_amount, 2) }}
                                            </b></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;"
                                        colspan="1">
                                        <p>
                                            TOTAL DUE
                                        </p>
                                    </td>
                                    <td style="text-align:center;font-family: arial;font-size: 10px;font-weight: 400;border: 1px solid black;"
                                        colspan="4">
                                        <p><b>
                                            {{ site_currency() }} {{  number_format(($invoice_amount), 2) }}
                                            </b></p>
                                    </td>
                                </tr>
                            </table>
                    </tr>
                    <!-- Content End-->

                    <!-----------Footer----------->
                    <div class="footer-fixed" style="width: 100%; border-collapse: collapse;">
                        <div style="
                            background: url({{ $invoice_footer_image }}) no-repeat;
                            background-size: cover;
                            height: 150px;
                            padding: 50px;
                            width: 100%;
                            text-align: center;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            padding-top: 20px;
                        ">
                            <p style="
                                text-align: center;
                                font-family: arial;
                                font-size: 10px;
                                margin: 0px;
                                font-weight: 700;
                                color: black;
                            ">
                                <b>THANK YOU FOR CHOOSING TO SHOP WITH US</b>
                            </p>
                        </div>
                    </div>

                    <!-- <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr
                                    style="background: url({{ $invoice_footer_image }}) no-repeat;height:192px;padding:50px;background-size:cover;width: 100%;">
                                    <td style="text-align:center;padding-top: 15px;">
                                        <p
                                            style="text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight:700;color:black;">
                                            <b>THANK YOU FOR CHOOSING TO SHOP WITH US</b>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                            </table>
                        </td>
                    </tr> -->
                    <!-----------Footer End----------->

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
