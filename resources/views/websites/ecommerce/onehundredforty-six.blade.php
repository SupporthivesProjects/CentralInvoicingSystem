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
                        <td style="padding: 0px;max-height: 130px;">
                            <table style="width: 100%;">
                                <tr>
                                    <td
                                        style="height: 180px; background: url({{ $invoice_header_image }}) no-repeat;background-position: 100% 100%;background-size:cover;width: 600px;">
                                        <img src="{{ $company_logo }}" alt=""
                                            style="height:60px;padding: 40px;padding-top: 80px;">
                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                    <!-- Content -->
                    <tr>
                        <td
                            style="padding:40px;padding-top:0px;background: url({{ $invoice_image1 }}) no-repeat;background-position: center;background-size: cover;height:444px;">
                            <table style="border-collapse: collapse;;">
                                <tr style="border-collapse: collapse;height: 35px;">
                                    <td
                                        style="width: 300px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #5E5E5E;">
                                        <img src="{{ $invoice_image5 }}" alt="" style="height: 10px;"> {{ $company_address }},
                                    </td>
                                    <td
                                        style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-bottom: 1px solid black;">
                                        <b>Total Due:</b>
                                    </td>
                                    <td
                                        style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-bottom: 1px solid black;">
                                        <b>{{ site_currency() . number_format($invoice_amount, 2) }}</b>
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 25px;">
                                    <td
                                        style="width: 300px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #5E5E5E;">
                                        <img src="{{ $invoice_image3 }}" alt="" style="height: 10px;">
                                        {{ $company_mobile }}
                                    </td>
                                    <td
                                        style="width: 100px;text-align: left;font-family: Raleway;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #5E5E5E;">
                                        Invoice Number
                                    </td>
                                    <td
                                        style="width: 100px;text-align: right;font-family: Raleway;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #5E5E5E;">
                                        Invoice Date
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 25px;">
                                    <td
                                        style="width: 300px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #5E5E5E;">
                                        <img src="{{ $invoice_image4 }}" alt="" style="height: 10px;">
                                        {{ $company_email }}
                                    </td>
                                    <td
                                        style="width: 100px;text-align: left;font-family: Raleway;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #5E5E5E;">
                                        {{ $invoice_number }}
                                    </td>
                                    <td
                                        style="width: 100px;text-align: right;font-family: Raleway;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #5E5E5E;">
                                        {{ $invoice_date }}
                                    </td>
                                </tr>

                            </table>

                            <br>
                            <br>
                            <div style="min-height: 500px !important;">
                            <table style="border-collapse: collapse;">
                                <tr
                                    style="border-collapse: collapse;height: 24px;border-top: 1px solid black;border-bottom: 1px solid black;">
                                    <td
                                        style="width: 250px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-right: 1px solid black;">
                                        <b>Item Descriptions</b>
                                    </td>
                                    <td
                                        style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-right: 1px solid black;">
                                        <b>Unit Price</b>
                                    </td>
                                    <td
                                        style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-right: 1px solid black;">
                                        <b>Quantity</b>
                                    </td>
                                    <td
                                        style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>AMOUNT</b>
                                    </td>
                                </tr>
                                <tr
                                    style="border-collapse: collapse;height: 10px;border-top: 1px solid black;border-bottom: 1px solid black;">
                                    <td
                                        style="width: 250px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-right: 1px solid black;">

                                    </td>
                                    <td
                                        style="width: 150px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-right: 1px solid black;">

                                    </td>
                                    <td
                                        style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-right: 1px solid black;">

                                    </td>
                                    <td
                                        style="width: 150px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr
                                    style="border-collapse: collapse;height: 24px;border-top: 1px solid black;border-bottom: 1px solid black;">
                                    <td
                                        style="width: 250px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-right: 1px solid black;">
                                        <b>{{ $product->name }}</b>
                                    </td>
                                    <td
                                        style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-right: 1px solid black;">
                                        <b>{{ site_currency() . number_format($product->unit_price, 2) }}</b>
                                    </td>
                                    <td
                                        style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-right: 1px solid black;">
                                        <b>1</b>
                                    </td>
                                    <td
                                        style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>{{ site_currency() . number_format($product->unit_price, 2) }}</b>
                                    </td>
                                </tr>
                                @endforeach
                                <tr
                                    style="border-collapse: collapse;height: 10px;border-top: 1px solid black;border-bottom: 1px solid black;">
                                    <td
                                        style="width: 250px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-right: 1px solid black;">

                                    </td>
                                    <td
                                        style="width: 150px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-right: 1px solid black;">

                                    </td>
                                    <td
                                        style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-right: 1px solid black;">

                                    </td>
                                    <td
                                        style="width: 150px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                </tr>

                                <tr style="border-collapse: collapse;height: 24px;">
                                    <td
                                        style="width: 250px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width: 150px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <p>Sub Total</p>
                                    </td>
                                    <td
                                        style="width: 150px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <p> {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</p>
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 24px;">
                                    <td
                                        style="width: 250px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width: 150px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-bottom: 1px solid black;">
                                        <p style="color: red;">Discount</p>
                                    </td>
                                    <td
                                        style="width: 150px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-bottom: 1px solid black;">
                                        <p style="color: red;">{{ site_currency() . number_format($discount_amount, 2) }}</p>
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 24px;">
                                    <td
                                        style="width: 250px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width: 150px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <p style="color: #5E5E5E;">Grand Total</p>
                                    </td>
                                    <td
                                        style="width: 150px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <p style="color: #5E5E5E;">{{ site_currency() . number_format($invoice_amount, 2) }}</p>
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;">
                                    <td
                                        style="width: 300px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #5E5E5E;padding-left: 40px;padding-bottom: 5px;">
                                        <b>{{ $site_name }}</b>
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;">
                                    <td
                                        style="width: 300px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #5E5E5E;padding-left: 40px;padding-top: 5px;">
                                        {{ $company_address }}
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;">
                                    <td
                                        style=" width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #5E5E5E;padding-left: 40px;padding-top: 10px;">
                                        <img src="{{ $invoice_image3 }}" alt="" style="height: 10px;">+1 132 456 9873
                                    </td>
                                    <td
                                        style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #5E5E5E;padding-top: 10px;padding-left: 5px;">
                                        <img src="{{ $invoice_image4 }}" alt=""
                                            style="height: 10px;">{{ $company_email }}
                                    </td>
                                    <td
                                        style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #5E5E5E;padding-top: 10px;padding-left: 5px;">
                                        <img src="{{ $invoice_image2 }}" alt="" style="height: 10px;">{{ $site->site_link }}
                                    </td>
                                </tr>
                            </table>
                            </div>

                        </td>
                    </tr>
                    <!-- Content End-->

                    <!-----------Footer----------->
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr
                                    style="background: url({{ $invoice_footer_image }}) no-repeat;background-position: center;background-size: cover;height: 45px;padding:50px;background-size:cover;width: 100%;">
                                    <td style="text-align:center;">
                                        <p
                                            style="text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight:700;color:whitesmoke;">

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
