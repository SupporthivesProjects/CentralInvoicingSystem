<!DOCTYPE html>
<html>

<head>
    <title>Your Email Title</title>
    <style>
        body{
            padding: 0px;
            margin: 0px;
        }
    </style>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;max-height: 250px;">
                            <table>
                                <tr>
                                    <td
                                        style="height: 64px; background: url({{ $invoice_header_image }}) no-repeat;background-position:center;background-size:cover;width: 1000px;">

                                    </td>

                                </tr>

                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                    <!-- Content -->
                    <tr>
                        <td style="padding:40px;padding-top:0px;">
                            <table>
                                <tr>
                                    <td style="padding-top: 30px;">
                                        <p
                                            style="font-family: arial;font-size:14px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                            <b>{{ $site_name }}</b>
                                        </p>

                                        <br>
                                    </td>
                                    <td style="text-align: right;">
                                        <p style="font-family: arial;font-size:26px;margin: 0px;font-weight: 400;">
                                            <b style="color: #00B5D9;">INVOICE</b>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 10px;width: 300px;">
                                        <p style="font-family: arial;font-size: 11px;margin: 0px;font-weight: 400;">
                                            {{ $company_name }}
                                        </p>
                                        <p style="font-family: arial;font-size: 11px;margin: 0px;font-weight: 400;">
                                            {{ $company_address }}
                                        </p>
                                        <p style="font-family: arial;font-size: 11px;margin: 0px;font-weight: 400;">
                                            Phone {{ $company_mobile }}
                                        </p>
                                        <p style="font-family: arial;font-size: 11px;margin: 0px;font-weight: 400;">
                                            {{ $company_email }} | {{ $site->site_link }}
                                        </p>
                                    <td style="padding-top: 10px;width: 300px;text-align: right;">
                                        <p style="font-family: arial;font-size: 11px;margin: 0px;font-weight: 400;">
                                            <b style="color: #00B5D9;">INVOICE #</b> {{ $invoice_number }}
                                        </p>
                                        <p style="font-family: arial;font-size: 11px;margin: 0px;font-weight: 400;">
                                            <b style="color: #00B5D9;">DATE</b> {{ $invoice_date }}
                                        </p>
                                    </td>

                                </tr>
                                <tr>
                                    <td style="padding-top: 10px;width: 300px;">
                                        <p style="font-family: arial;font-size: 11px;margin: 0px;font-weight: 400;">
                                            TO
                                        </p>
                                        <p style="font-family: arial;font-size: 11px;margin: 0px;font-weight: 400;">
                                            {{ $customer_name }}
                                        </p>
                                        <p style="font-family: arial;font-size: 11px;margin: 0px;font-weight: 400;">
                                            Phone {{ $customer_mobile }} | {{ $customer_email }}
                                        </p>
                                    <td style="padding-top: 10px;width: 300px;text-align: right;">
                                        <p style="font-family: arial;font-size: 11px;margin: 0px;font-weight: 400;">
                                            <b style="color: #00B5D9;">
                                        </p>
                                        <p style="font-family: arial;font-size: 11px;margin: 0px;font-weight: 400;">
                                            <b style="color: #00B5D9;">
                                        </p>
                                    </td>

                                </tr>

                            </table>

                            <div style="min-height: 500px !important;">
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">


                                <tr
                                    style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;border-bottom: 2px solid #00B5D9;border-top: 1px solid #00B5D9;">
                                    <td
                                        style="width: 500px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;color: #00B5D9;">
                                        Product
                                    </td>

                                    <td
                                        style="width:500px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        Amount
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr
                                    style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;border-bottom: 1px solid #00B5D9;">
                                    <td
                                        style="width: 500px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                        <b>{{ $product->name }}</b>
                                    </td>

                                    <td
                                        style="width:500px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        <b>{{ site_currency() . number_format($product->unit_price, 2) }}</b>
                                    </td>
                                </tr>
                                @endforeach
                                <tr
                                    style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;border-bottom: 1px solid #00B5D9;">
                                    <td
                                        style="width: 500px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px; color: #00B5D9;">
                                        <b>Subtotal</b>
                                    </td>

                                    <td
                                        style="width:500px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        <b>{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</b>
                                    </td>
                                </tr>
                                <tr
                                    style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;border-bottom: 1px solid #00B5D9;">
                                    <td
                                        style="width: 500px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px; color: #00B5D9;">
                                        <b>Discount</b>
                                    </td>

                                    <td
                                        style="width:500px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        <b>{{ site_currency() . number_format($discount_amount, 2) }}</b>
                                    </td>
                                </tr>
                                <tr
                                    style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;border-bottom: 1px solid #00B5D9;">
                                    <td
                                        style="width: 500px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px; color: #00B5D9;">
                                        <b>Grand Total</b>
                                    </td>

                                    <td
                                        style="width:500px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        <b>{{ site_currency() . number_format($invoice_amount, 2) }}</b>
                                    </td>
                                </tr>

                                <br><br>
                            </table>
                            </div>
                    <tr>
                        <td style="padding-left: 40px;">
                            <p
                                style="font-family: arial;font-size:11px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                Make all checks payable to {{ $site_name }}
                            </p>
                            <p
                                style="font-family: arial;font-size:11px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                Payment is due within 30 days.
                            </p>
                            <p
                                style="font-family: arial;font-size:11px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                If you have any questions concerning this invoice, contact {{ $site_name }} | {{ $company_mobile }} | {{ $company_email }}
                            </p>

                            <br>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-bottom: 40px;">
                            <p
                                style="font-family: arial;font-size:11px;margin: 0px;font-weight: 400;padding-bottom: 5px;text-align: center;color: #00B5D9;">
                                THANK YOU FOR YOUR BUSINESS!
                            </p>
                        </td>
                    </tr>


            </td>
        </tr>
        <!-- Content End-->

        <!-----------Footer----------->
        <tr>
            <td style="height: 75px;">
                <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;">
                    <tr
                        style="height: 70px; background: url({{ $invoice_footer_image }}) no-repeat;background-position:center;background-size:cover;width: 600px; border-collapse: collapse;">
                        <td style="width: 300px;border:0px">
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
