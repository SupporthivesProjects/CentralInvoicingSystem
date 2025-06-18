<!DOCTYPE html>
<html>

<head>
    <title>Your Email Title</title>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;max-height: 130px;">
                            <table>
                                <tr style="width: 100%;">
                                    <td
                                        style="height: 500px; background: url('{{ $invoice_image1 }}') no-repeat;background-position: 100% 100%;background-size:cover;width: 200px;position: relative;">

                                        <p
                                            style="text-align: center;padding-top: 20px;position: absolute;top: 10px;left: 60px;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">
                                            <b>INVOICE</b></p>


                                        <p
                                            style="position: absolute;top: 300px;left: 35px;border-bottom: 1px solid black;padding-bottom: 15px;width: 150px; font-size: 10px;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">
                                            <b>Date</b><br>06 December 2024</p>
                                        <p
                                            style="position: absolute;top: 370px;left: 35px;font-size: 10px;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">
                                            <b>BILLED TO</b></p>
                                        <p
                                            style="position: absolute;top: 400px;left: 35px;border-bottom: 1px solid black;padding-bottom: 35px;width: 150px;font-size: 10px;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">
                                            <b>Customer Name</b></p>
                                        <p
                                            style="position: absolute;top: 470px;left: 35px;font-size: 10px;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">
                                            <b>BILLED FORM</b></p>
                                        <p
                                            style="position: absolute;top: 510px;left: 35px;font-size: 10px;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">
                                            <b>Elite Content</b></p>
                                        <p
                                            style="position: absolute;top: 530px;left: 35px;font-size: 10px;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">
                                            Block B, Office-B27-011, SRTI Park,<br> in the Emirate of Sharjah, U.A.E</p>
                                        <p
                                            style="position: absolute;top: 600px;left: 35px; border-bottom: 1px solid black;padding-bottom: 15px;width: 150px;font-size: 10px;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">
                                            support@elitecontent.co</p>
                                    </td>

                                    <td style="text-align: right;">
                                        <img src="{{ $company_logo }}" alt=""
                                            style="padding-left: 170px;padding-top: 20px; display: block;height:85px;">
                                        <br><br><br><br><br><br><br>
                                        <p style="padding: 20px;padding-bottom: 5px;margin-bottom: 0px;"><b>Invoice
                                                NO</b></p>

                                        <table
                                            style="border-collapse: collapse;border-bottom: 0px;border: 0px;padding: 20px;padding-left: 20px;">
                                            <tr
                                                style="border-collapse: collapse;height: 30px;background-color: rgb(3, 3, 124); color: white;border-bottom: 0px;border: 0px;">
                                                <td
                                                    style="width: 400px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                                    <b>Services</b>
                                                </td>
                                                <td
                                                    style="width: 250px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                                    <b>Qty</b>
                                                </td>
                                                <td
                                                    style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                                    <b>Images</b>
                                                </td>
                                                <td
                                                    style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                                    <b>Total</b>
                                                </td>
                                            </tr>
                                            @foreach($products as $product)
                                            <tr
                                                style="border-collapse: collapse;height: 30px;background-color: gainsboro; border-bottom: 0px;border: 0px;">
                                                <td
                                                    style="width: 400px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                                    <b>{{$product->name}}</b>
                                                </td>
                                                <td
                                                    style="width: 250px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                                    <b>{{$product->quantity}}</b>
                                                </td>
                                                <td
                                                    style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                                    <b>{{$product->imagecount}}</b>
                                                </td>
                                                <td
                                                    style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                                    <b>{{ site_currency() . number_format($product->unit_price, 2) }}</b>
                                                </td>
                                            </tr>
                                            @endforeach


                                        </table>
                                        <br><br><br><br><br><br>

                                    </td>

                                </tr>

                            </table>

                        </td>

                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr
                                    style="background: url('{{ $invoice_footer_image }}') no-repeat;background-position: center;height:30px; background-size:cover;width: 100%;">
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

                </table>
            </td>
        </tr>

    </table>
</body>

</html>
