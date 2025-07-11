<!DOCTYPE html>
<html>

<head>
    <title>Your Email Title</title>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="height: 75px;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr
                                    style="height: 150px; background: url({{ $invoice_header_image }}) no-repeat;background-position:center;background-size:cover;width: 600px; border-collapse: collapse;">
                                    <td style="width: 300px;border:0px">
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
                                    <td style="padding-top: 30px;width: 300px;">
                                        <p
                                            style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                            <b>BILLED TO</b>
                                        </p>
                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            <b>{{ $customer_name }}</b>
                                        </p>

                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            {{ $customer_mobile }}
                                        </p>
                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            {{ $customer_email }}
                                        </p>
                                        <br>
                                    </td>
                                    <td style="padding-top: 10px;width: 300px;text-align: right;">
                                        <p
                                            style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                            <b>BILLED FORM</b>
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <b>{{ $company_name }}</b>
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            {{ $company_address }},</p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            {{ $company_mobile }}</p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            {{ $company_email }}</p>
                                    </td>
                                </tr>

                            </table>

                            <div style="min-height: 500px !important;">
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                <tr
                                    style="border-collapse: collapse;height: 50px; color: white;border-bottom: 1px solid black;border: 0px;">
                                    <td
                                        style="padding-left: 2px; width: 500px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 600;border-collapse: collapse;padding-left: 5px;border-right: 1px solid black;background-color: #3C7F79;">
                                        <b>ITEM Descriptions</b>
                                    </td>
                                    <td
                                        style="width: 200px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 600;border-collapse: collapse;border-right: 1px solid black;background-color: black;">
                                        <b> Package Type</b>
                                    </td>
                                    <td
                                        style="width: 200px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 600; border-collapse: collapse;padding-left: 5px;border-right: 1px solid black;background-color: black;">
                                        <b>Length</b>
                                    </td>
                                    <td
                                        style="padding-right: 10px; width: 200px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 600;border-collapse: collapse;background-color: black;">
                                        <b>Amount</b>
                                    </td>

                                </tr>
                                @foreach($products as $product)
                                <tr
                                    style="border-collapse: collapse;height: 60px;border-bottom: 0px;border: 0px;border-bottom: 1px solid black;">
                                    <td
                                        style="color: #3C7F79; padding-left: 2px; width: 500px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;border-right: 1px solid black;">
                                        <b style="color: black">{{ $product->name }}
                                    </td>
                                    <td
                                        style="width: 300px;text-align:center;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-right: 1px solid black;">
                                        <!-- Extracting package type from product name using string manipulation, eg: Product Name - Package Type -->
                                        {{ substr($product->name, strpos($product->name, '-') + 1) }}
                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;border-right: 1px solid black;">
                                        {{ $product->subscription }} months
                                    </td>
                                    <td
                                        style="padding-right: 10px; width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        {{ site_currency() . number_format($product->unit_price, 2) }}
                                    </td>

                                </tr>
                                @endforeach
                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td
                                        style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        <img src="{{ $invoice_image2 }}" alt="" style="height: 20px;"> {{ $company_address }},
                                    </td>
                                    <td
                                        style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>

                                    <td
                                        style="width:100px;text-align:center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px; border-collapse: collapse; ">
                                        Sub Total
                                    </td>
                                    <td
                                        style="padding-right: 10px; width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse; ">
                                        {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td
                                        style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>

                                    <td
                                        style="width:100px;text-align:center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px; border-collapse: collapse; ">
                                        Discount
                                    </td>
                                    <td
                                        style="padding-right: 10px; width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse; ">
                                        {{ site_currency() . number_format($discount_amount, 2) }}
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td
                                        style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        <img src="{{ $invoice_image1 }}" alt="" style="height: 20px;"> +44 123 45 6789
                                    </td>
                                    <td
                                        style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>

                                    <td
                                        style="width:100px;text-align:center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px; border-collapse: collapse; ">

                                    </td>
                                    <td
                                        style="padding-right: 10px; width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse; ">

                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td
                                        style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;color: blue;">
                                        {{ $company_email }}</td>
                                    </td>
                                    <td
                                        style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>

                                    <td
                                        style="width:100px;text-align:center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px; border-collapse: collapse;background-color: #3C7F79;color: white; ">
                                        Grand Total
                                    </td>
                                    <td
                                        style="padding-right: 10px; width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #3C7F79;color: white; ">
                                        {{ site_currency() . number_format($invoice_amount, 2) }}
                                    </td>
                                </tr>

                                <br><br>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <!-- Content End-->

                    <!-----------Footer----------->
                    <tr>
                        <td style="height: 40px;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr
                                    style="height: 45px; background: url({{ $invoice_footer_image }}) no-repeat;background-position:center;background-size:cover;width: 600px; border-collapse: collapse;">
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
