<!DOCTYPE html>
<html>
<head>
    <title>Your Email Title</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#ffffff" style="">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse;">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;max-height: 130px;">
                            <table>
                                <tr >
                                    <td style="height: 150px; background: url({{ $invoice_header_image }}) no-repeat;background-position:center;background-size:cover;width: 600px;">
                                        <b style="padding-left: 70px;color: white;font-size: 22px;font-family: 'Courier New', Courier, monospace;"> Invioce</b><br>
                                        <b style="padding-left: 75px;color: white;font-size: 9px;font-family: 'Courier New', Courier, monospace;">No.{{ $invoice_number }}</b>
                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                     <!-- Content -->
                    <tr >
                        <td style="padding:60px;padding-top:0px;">
                            <table>

                                <tr>
                                    <td style="padding-top: 10px;width: 200px;">
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;  text-align: left; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                            <b>BILLED TO:</b>
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;  text-align: left; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                           {{ $customer_name }}
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;  text-align: left; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                           {{ $customer_mobile }}
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;  text-align: left; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                           {{ $customer_email }}
                                        </p>
                                     <td style="padding-top: 10px;width: 200px;">
                                       <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;  text-align: left; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                            <b>BILLED FROM:</b>
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;  text-align: left; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                            {{ $site_name }}
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;  text-align: left; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                            {{ $company_address }}
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;  text-align: left; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                            {{ $company_mobile }}
                                        </p>
                                     </td>
                                </tr>

                            </table>

                            <div style="min-height: 500px !important">
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                <tr style="border-collapse: collapse;height: 30px; border-bottom: 0px;border: 0px; background-color: #00A8DC;">
                                    <td style="width: 600px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       <b>Service</b>
                                    </td>
                                    <td style="width: 200px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>	Quantity</b>
                                    </td>
                                    <td style="width: 200px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        <b>Price</b>
                                    </td>
                                    <td style="width: 200px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>Cost</b>
                                    </td>

                                </tr>
                                @foreach($products as $product)
                                 <tr style="border-collapse: collapse;height: 30px; border-bottom: 0px;border: 0px; ">
                                    <td style="width: 600px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       {{ $product->name }}
                                    </td>
                                    <td style="width: 200px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        1
                                    </td>
                                    <td style="width: 200px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        {{ site_currency() . number_format($product->unit_price, 2) }}
                                    </td>
                                    <td style="width: 200px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        {{ site_currency() . number_format($product->unit_price, 2) }}
                                    </td>

                                </tr>
                                @endforeach
                                <tr style="border-collapse: collapse;height: 30px; border-bottom: 0px;border: 0px; ">
                                    <td style="width: 600px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       <!-- <b>Our Payment Methods:</b> -->
                                    </td>
                                    <td style="width: 200px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                    <td style="width: 200px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        <b>Sub Total</b>
                                    </td>
                                    <td style="width: 200px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</b>
                                    </td>

                                </tr>
                                <tr style="border-collapse: collapse;height: 30px; border-bottom: 0px;border: 0px; ">
                                    <td style="width: 600px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       <!-- Invoice # {{ $invoice_number }} -->
                                    </td>
                                    <td style="width: 200px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                    <td style="width: 200px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        <b>Discount</b>
                                    </td>
                                    <td style="width: 200px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>{{ site_currency() . number_format($discount_amount, 2) }}</b>
                                    </td>

                                </tr>
                                <tr style="border-collapse: collapse;height: 30px; border-bottom: 0px;border: 0px; ">
                                    <td style="width: 600px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       <!-- PayPal, Wire Transfer, Payoneer -->
                                    </td>
                                    <td style="width: 200px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                    <td style="width: 200px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;background-color: #F2F2F2;">
                                       <b>Total Due</b>
                                    </td>
                                    <td style="width: 200px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;background-color: #F2F2F2;">
                                        <b>{{ site_currency() . number_format($invoice_amount, 2) }}</b>
                                    </td>

                                </tr>
                                <br><br><br><br>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <!-- Content End-->

                    <!-----------Footer----------->
                    <tr>
                        <td style="height: 130px;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;">
                                <tr style="background: url({{ $invoice_footer_image }}) no-repeat;background-position: center;background-size: cover;height: 80px;padding:50px;background-size:cover;width: 100%;">
                                    <td style="width: 150px;">
                                        <p style="text-align: center;font-family: arial;font-size: 10px;margin: 0px;color: #00A8DC;">
                                            <b>Notes</b>
                                        </p><br>
                                        <p style="text-align: center;font-family: arial;font-size: 10px;margin: 0px;">
                                            {{ $invoice_notes ?? 'Thank you for your business!' }}

                                        </p>

                                    </td>

                                </tr>
                                <tr>
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
