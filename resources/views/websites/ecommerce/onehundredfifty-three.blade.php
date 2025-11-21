<!DOCTYPE html>
<html>

<head>
    <title>Your Email Title</title>
</head>

<body style="margin: 0px; padding: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#FFFFFF" style="padding: 0px;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;max-height: 130px;">
                            <table style="border-spacing: 0px;">
                                <tr>
                                    <td
                                        style="height: 100px; background: url({{ $invoice_header_image }}) no-repeat;background-position:center;background-size:cover;width: 1000px;">

                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                    <!-- Content -->
                    <tr
                        style=" background: url({{ $invoice_image1 }}) no-repeat;background-position:center;background-size:cover; height: 100%;width: 100%;">
                        <td style="padding:40px;padding-top:20px; height: 100%;">
                            <table>
                                <tr>
                                    <td style="width: 290px;">
                                        <p
                                            style="font-family: arial;font-size:10px;margin-bottom: 5px;font-weight: 400;">
                                            <b> DATE:</b> {{ $invoice_date }}
                                        </p>

                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            <b>Invoice Number:</b> {{ $invoice_number }}
                                        </p>
                                        <br>
                                        <p
                                            style="font-family: arial;font-size: 10px;margin-bottom: 5px;font-weight: 400;">

                                            BILLED FROM:

                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            {{ $site_name }}
                                        </p>
                                        <br>
                                        <p
                                            style="font-family: arial;font-size: 10px;margin-bottom: 5px;font-weight: 400;">
                                            <strong>Email:</strong> {{ $company_email }}
                                        </p>
                                        <p
                                            style="font-family: arial;font-size: 10px;margin-bottom: 5px;font-weight: 400;">
                                            <b>Website:</b> {{ $site->site_link }}
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <b>Phone:</b> {{ $company_mobile }}
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <b>Address:</b> {{ $company_address }}
                                        </p>
                                    </td>
                                    <td
                                        style="width:300px;
                                    padding: 40px;padding-top: 0px;padding-right: 0px;
                                    text-align: right;">
                                        <h1 style="font-family: arial;font-size: 20px;margin: 0px;font-weight: 700;">
                                            INVOICE</h1><br>


                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">

                                            BILLED TO:

                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            {{ $customer_name }}
                                        </p>

                                    </td>
                                </tr>
                            </table>

                            <div style="min-height: 760px !important;">
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                <tr
                                    style="border-collapse: collapse;height: 30px;background-color:#F8F0E3; border-bottom: 0px;border: 0px;">
                                    <td
                                        style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                        <b>Product</b>
                                    </td>
                                    <td
                                        style="width: 300px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>Category</b>
                                    </td>
                                    <td
                                        style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-left: 1px solid whitesmoke; border-collapse: collapse;padding-left: 5px;">
                                        <b>Quantity</b>
                                    </td>
                                    <td
                                        style="width: 100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>Unit Price</b>
                                    </td>
                                    <td
                                        style="width:100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>Total</b>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr
                                    style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;border-bottom: 1px solid black;">
                                    <td
                                        style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 2px;">
                                        {{ $product->name }}
                                    </td>
                                    <td
                                        style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        {{ $product->category_name }}
                                    </td>
                                    <td
                                        style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        1
                                    </td>
                                    <td
                                        style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        {{ site_currency() . number_format($product->unit_price, 2) }}
                                    </td>
                                    <td
                                        style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        {{ site_currency() . number_format($product->unit_price, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td
                                        style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-bottom: 1px solid black;padding-left: 5px;">
                                        Subtotal
                                    </td>
                                    <td
                                        style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-bottom: 1px solid black;">

                                    </td>
                                    <td
                                        style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-bottom: 1px solid black;">
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
                                        style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px; border-bottom: 1px solid black; padding-left: 5px;">
                                        Discount
                                    </td>
                                    <td
                                        style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse; border-bottom: 1px solid black;">

                                    </td>
                                    <td
                                        style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse; border-bottom: 1px solid black;">
                                        {{ site_currency() . number_format($discount_amount, 2) }}
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
                                        style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #F8F0E3; padding-left: 5px;">
                                        Grand<br> Total
                                    </td>
                                    <td
                                        style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #F8F0E3;">

                                    </td>
                                    <td
                                        style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #F8F0E3;">
                                        {{ site_currency() . number_format($invoice_amount, 2) }}
                                    </td>
                                </tr><br><br>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <!-- Content End-->

                    <!-----------Footer----------->

                    <!-----------Footer End----------->

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
