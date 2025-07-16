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
                        <td style="padding: 0px;max-height: 130px;">
                            <table>
                                <tr>
                                    <td>
                                        <img src="{{ $invoice_header_image }}" alt=""
                                            style="height: 20px; width: 190px; padding-left: 20px;">
                                    </td>

                                </tr>

                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                    <!-- Content -->
                    <tr>
                        <td style="padding-left:40px;padding-right: 40px; padding-top:0px;">
                            <table>
                                <tr>
                                    <td style="padding-top: 30px;">
                                        <p
                                            style="font-family: arial;font-size:8px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                            <img src="{{ $invoice_image4 }}" alt="" style="height: 20px;"> <b
                                                style="font-size: 9px;">Area</b> <br> 123 London road, kent, abc 123
                                        </p>
                                    </td>
                                    <td style="text-align: right; align-content: end;width: 390px;">
                                        <p style="font-family: arial;font-size:26px;margin: 0px;font-weight: 400;">
                                            <b>INVOICE</b>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td style="width: 200px;">
                                        <p
                                            style="font-family: arial;font-size:8px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                            <img src="{{ $invoice_image5 }}" alt="" style="height: 20px;"> <b
                                                style="font-size: 9px;">Phone</b> <br> +44 123 456 789
                                        </p>
                                    </td>
                                    <td style="border-bottom: 1px solid black;width: 390px;"></td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td style="width: 200px;">
                                        <p
                                            style="font-family: arial;font-size:8px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                            <img src="E.png" alt="" style="height: 20px;"> <b
                                                style="font-size: 9px;">Email</b> <br> info@estarsolutions.com
                                        </p>
                                    <td style="text-align: left; width: 100px;border-right: 1 px solid black;">
                                        <p style="font-family: arial;font-size:8px;margin: 0px;font-weight: 400;">
                                            Due Amount:<br><br> <b>{{ $invoice_amount }}</b>
                                    </td>
                                    <td style="text-align: center; width: 100px; border-right: 1 px solid black;">
                                        <p style="font-family: arial;font-size:8px;margin: 0px;font-weight: 400;">
                                            Invoice Date:<br><br> <b>{{ $invoice_date }}</b>
                                    </td>
                                    <td style="text-align: right; width: 100px; border-right: 1 px solid black;">
                                        <p style="font-family: arial;font-size:8px;margin: 0px;font-weight: 400;">
                                            Invoice No:<br><br> <b>#{{ $invoice_number }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p
                                            style="font-family: arial;font-size:8px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                            <img src="{{ $invoice_image2 }}" alt="" style="height: 20px;"> <b
                                                style="font-size: 9px;">Website</b> <br> {{ $site->site_link }}
                                        </p>
                                    </td>
                                </tr>

                            </table>



                            <div class="row" style="margin-left:-5px;margin-right:-5px;">
                                <div class="column" style="float: left;padding: 5px;">

                                    <table style="background-image: url({{ $invoice_image1 }});width: 150px;">
                                        <tr style="width: 150px;">
                                            <td style="padding-top: 20px; border-bottom: 1px solid black;">
                                                <p
                                                    style="font-family: arial;font-size:8px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                                    <b style="font-size: 9px;">Invoice From</b>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="width: 150px;">
                                            <td style="padding-top: 10px; ">
                                                <p
                                                    style="font-family: arial;font-size:8px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                                    <b style="font-size: 9px;">{{ $company_name }}</b>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="width: 150px;">
                                            <td>
                                                <p
                                                    style="font-family: arial;font-size:8px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                                    {{ $company_address }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="width: 150px;">
                                            <td>
                                                <p
                                                    style="font-family: arial;font-size:8px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                                    <b style="font-size: 9px;">P:</b> {{ $company_mobile }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="width: 150px;">
                                            <td>
                                                <p
                                                    style="font-family: arial;font-size:8px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                                    <b style="font-size: 9px;">E:</b> {{ $company_email }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="width: 150px;">
                                            <td style="padding-top: 20px; border-bottom: 1px solid black;">
                                                <p
                                                    style="font-family: arial;font-size:8px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                                    <b style="font-size: 9px;">Invioce To</b>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="width: 150px;">
                                            <td style="padding-top: 10px; ">
                                                <p
                                                    style="font-family: arial;font-size:8px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                                    <b style="font-size: 9px;">{{ $customer_name }}</b>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="width: 150px;">
                                            <td>
                                                <p
                                                    style="font-family: arial;font-size:8px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                                    <b style="font-size: 9px;">P:</b> {{ $customer_mobile }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="width: 150px;">
                                            <td>
                                                <p
                                                    style="font-family: arial;font-size:8px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                                    <b style="font-size: 9px;">E:</b> {{ $customer_email }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="width: 150px;">
                                            <td style="text-align: center;padding-bottom: 30px;padding-top: 50px;">
                                                <img src="{{ $company_logo }}" alt=""
                                                    style="height: 50px; width: 100px;">
                                            </td>
                                        </tr>


                                    </table>
                                </div>
                                <div class="column">
                                    <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                        <tr
                                            style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;border-bottom: 1px solid black;border-top: 1px solid black;">
                                            <td
                                                style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                                Product
                                            </td>
                                            <td
                                                style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                                Category
                                            </td>
                                            <td
                                                style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                                Price
                                            </td>

                                            <td
                                                style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                                Amount
                                            </td>
                                        </tr>
                                        @foreach($products as $product)
                                        <tr
                                            style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;border-bottom: 1px solid black;border-top: 1px solid black;">
                                            <td
                                                style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                                {{ $product->name }}
                                            </td>
                                            <td
                                                style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                                1
                                            </td>
                                            <td
                                                style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                                {{ site_currency() . number_format($product->unit_price, 2) }}
                                            </td>

                                            <td
                                                style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                                {{ site_currency() . number_format($product->unit_price, 2) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr
                                            style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                            <td
                                                style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">

                                            </td>
                                            <td
                                                style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">

                                            </td>
                                            <td
                                                style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                                Sub Total:
                                            </td>

                                            <td
                                                style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                                {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                            </td>
                                        </tr>
                                        <tr
                                            style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                            <td
                                                style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">

                                            </td>
                                            <td
                                                style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">

                                            </td>
                                            <td
                                                style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                                Discount
                                            </td>

                                            <td
                                                style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                                {{ site_currency() . number_format($discount_amount, 2) }}
                                            </td>
                                        </tr>

                                        <tr
                                            style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;border-bottom: 1px solid black;">
                                            <td
                                                style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;padding-bottom: 90px;padding-top: 5px;">

                                            </td>
                                            <td
                                                style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;padding-bottom: 90px;padding-top: 5px;">

                                            </td>
                                            <td
                                                style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;padding-bottom: 90px;padding-top: 5px;">
                                                <b>Grand Total</b>
                                            </td>

                                            <td
                                                style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-bottom: 90px;padding-top: 5px;">
                                                {{ site_currency() . number_format($invoice_amount, 2) }}
                                            </td>
                                        </tr>
                                        <tr style="text-align: right; width: 400px;">
                                            <td style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;"
                                                colspan="4">
                                                <p
                                                    style="font-family: arial;font-size:11px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                                    <b>Notes:</b>
                                                </p>
                                                <p
                                                    style="font-family: arial;font-size:11px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                                    Lorem ipsum dolor sit amet, sed diam nonummy nibh euismod dolor<br>
                                                    tincidunt ut laoreet dolore magna aliquam erat volutpat.

                                            </td>
                                        </tr>

                                    </table>



                                </div>
                            </div>









                            <!-- Content End-->

                            <!-----------Footer
                    <tr>
                        <td style="height: 75px;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;">
                                <tr style="height: 70px; background: url(Picture2.png) no-repeat;background-position:center;background-size:cover;width: 600px; border-collapse: collapse;">
                                    <td style="width: 300px;border:0px" >
                                        </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                    Footer End----------->

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
