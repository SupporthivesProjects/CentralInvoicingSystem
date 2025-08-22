<!DOCTYPE html>
<html>

<head>
    <title>Your Email Title</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
<style>
*{
    margin:0px;
    padding:0px;
}
</style>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding:0px;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse;background-image: url({{ $invoice_image1 }}); background-repeat: no-repeat;background-size:cover;">
                    <!-- Content -->
                    <tr style="min-height: 600px;">
                        <td style="padding-top:200px;">

                            <table style="padding-left: 40px;padding-right: 50px;padding-top: 20px; ">
                                <tr style="border-collapse: collapse;">
                                    <td style="width: 300px;font-family: 'Montserrat', sans-serif;">
                                        <p style="color: #f24c1e;font-size: 14px;margin: 0px;">Invoice To :</p>
                                        <b style="color: #168B91;font-size: 20px;">{{ $customer_name }}</b>
                                    </td>
                                    <td style="width: 300px;text-align: right;font-family: 'Montserrat', sans-serif;">
                                        <p style="color: #f24c1e;font-size: 9px;">Invoice Number :</p>
                                        <p style="color: #168B91;font-size: 8px;">{{ $invoice_number }}</p>
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;">
                                    <td style="width: 300px;">

                                    </td>
                                    <td style="width: 300px;text-align: right;font-family: 'Montserrat', sans-serif;">
                                        <p style="color: #f24c1e;font-size: 9px;">Invoice Date </p>
                                        <p style="color: #168B91;font-size: 8px;">{{ $invoice_date }}</p>
                                    </td>
                                </tr>
                            </table>

                            <table style="border-collapse: collapse;padding-right: 40px;">
                                <tr
                                    style="border-collapse: collapse;height: 30px;border-bottom: 1px solid #f24c1e;border-top: 1px solid #f24c1e;color: #168B91;">
                                    <td
                                        style="width: 200px;text-align: left;font-family: 'Montserrat', sans-serif; font-size: 11px;margin: 0px;font-weight: 800;border-collapse: collapse;padding: 20px;">
                                        <b>ITEM DESCRIPTION</b>
                                    </td>
                                    <td
                                        style="width: 150px;text-align: center;font-family: 'Montserrat', sans-serif; font-size: 11px;margin: 0px;font-weight: 800; border-collapse: collapse;padding-left: 5px;">
                                        <b>UNIT PRICE</b>
                                    </td>
                                    <td
                                        style="width: 100px;text-align:center;font-family: 'Montserrat', sans-serif; font-size: 11px;margin: 0px;font-weight: 800;border-collapse: collapse;">
                                        <b>QTY</b>
                                    </td>
                                    <td
                                        style="width:100px;text-align: center;font-family: 'Montserrat', sans-serif; font-size: 11px;margin: 0px;font-weight: 800;border-collapse: collapse;padding-right: 2px;">
                                        <b>Total</b>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                    <tr style="border-collapse: collapse;height: 30px;">
                                        <td
                                            style="width: 200px;text-align:left;font-family: 'Montserrat', sans-serif;font-size:8px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 20px;">
                                            {{ $product->name }}
                                        </td>
                                        <td
                                            style="width:150px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 8px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                            {{ site_currency() }} {{ number_format($product->unit_price, 2) }}
                                        </td>
                                        <td
                                            style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 8px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                            1
                                        </td>
                                        <td
                                            style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 8px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                            {{ site_currency() }} {{ number_format($product->unit_price, 2) }}
                                        </td>
                                    </tr>
                                @endforeach

                                <tr style="border-collapse: collapse;height: 15px;">
                                    <td
                                        style="width: 200px;text-align:left;font-family: 'Montserrat', sans-serif;font-size:8px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width:150px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 8px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">

                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 8px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 8px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">

                                    </td>
                                </tr>

                                <tr style="border-collapse: collapse;height: 30px;">
                                    <td
                                        style="text-align: left;font-size: 12px;font-family: 'Montserrat', sans-serif;color: #f24c1e;padding-left: 40px;font-weight: 400;">
                                        <p style="margin: 0px;">COMPANY NAME</p>
                                    </td>
                                    <td
                                        style="width:150px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        {{ $customer_name }}
                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;color: white;">
                                        SUBTOTAL
                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;color: white;">
                                        {{ site_currency() }} {{ number_format($invoice_amount + $discount_amount, 2) }}
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 30px;">
                                    <td
                                        style="text-align: left;font-size: 12px;font-family: 'Montserrat', sans-serif;color: #f24c1e;padding-left: 40px;font-weight: 400;">
                                        <p style="margin-top: 0px;"> ADDRESS</p>
                                    </td>
                                    <td
                                        style="width:150px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        {{ $company_address }}
                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-bottom: 1px solid white;color: white;">
                                        DISCOUNT
                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;border-bottom: 1px solid white;color: white;">
                                        {{ site_currency() }} {{ number_format($discount_amount, 2) }}
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 30px;">
                                    <td
                                        style="width: 200px;text-align:center;font-family: 'Montserrat', sans-serif;font-size:24px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width:150px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">

                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;color: white;">
                                        Total
                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 16px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;color: white;">
                                        {{ site_currency() }} {{ number_format($invoice_amount, 2) }}
                                    </td>
                                </tr>
                                <br><br>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End-->
                    <tr>
                        <td
                            style="text-align: left;padding-right: 40px;font-size: 12px;font-family: 'Montserrat', sans-serif;color: #f24c1e;padding-left: 40px;padding-bottom: 60px;font-weight: 600;padding-top: 40px;">


                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
