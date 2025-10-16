<!DOCTYPE html>
<html>

<head>
    <title>Your Email Title</title>
    <style>
        
        *, body {
            margin:0px;
            padding:0px;
        }
    </style>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 16px 0px;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; ">
                    <!-- Header -->
                    <tr>
                        <td colspan="2" style="padding: 0px;max-height: 130px;">
                            
                            <img src="{{ $invoice_header_image }}" alt=""
                                style="height: 20px; width: 190px;">
                                   
                        </td>
                    </tr>
                    <!-- Header End -->

                    <tr>
                        <td>
                            <div class="" style="display: flex; flex-direction: row; justify-content: flex-start; align-items: flex-start;">
                                <img src="{{ $invoice_image4 }}" alt="" style="height: 20px;">
                                <div class="" style="display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start;">
                                    <b style="font-size: 12px;">Area</b> 
                                    <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">123 London road, kent, abc 123</p>
                                </div>
                            </div>
                            <div class="" style="display: flex; flex-direction: row; justify-content: flex-start; align-items: flex-start;">
                                <img src="{{ $invoice_image5 }}" alt="" style="height: 20px;">
                                <div class="" style="display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start;">
                                    <b style="font-size: 12px;">Phone</b> 
                                    <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">+44 123 456 789</p>
                                </div>
                            </div>
                            <div class="" style="display: flex; flex-direction: row; justify-content: flex-start; align-items: flex-start;">
                                <img src="{{ $invoice_image3 }}" alt="" style="height: 20px;">
                                <div class="" style="display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start;">
                                    <b style="font-size: 12px;">Email</b> 
                                    <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">info@estarsolutions.com</p>
                                </div>
                            </div>
                            <div class="" style="display: flex; flex-direction: row; justify-content: flex-start; align-items: flex-start;">
                                <img src="{{ $invoice_image2 }}" alt="" style="height: 20px;">
                                <div class="" style="display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start;">
                                    <b style="font-size: 12px;">Website</b> 
                                    <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;"><a href="{{ $site->site_link }}" style="text-decoration:none; color: #000000;">www.estarsolutions.co</a></p>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div style="background-image: url({{ $invoice_image1 }}); padding: 16px 24px;">

                                <!-- Billed From Section -->
                                <div style="margin-bottom: 40px;">
                                    <h3 style="font-size: 14px;font-weight: 600; color: #000000; margin-bottom: 8px;">Billed From:</h3>
                                    <hr>
                                    <h3 style="font-size: 16px;font-weight: 600; color: #000000; margin-bottom: 8px;">Evolron L.L.C-FZ</h3>
                                    <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                        Meydan Grandstand,<br>
                                        6th floor, Meydan Road,<br>
                                        Nad Al Sheba, Dubai, U.A.E.
                                    </p>
                                </div>

                                <!-- Invoice To Section -->
                                <div style="margin-top: 50px;">
                                    <h3 style="font-size: 14px;font-weight: 600; color: #000000; margin-bottom: 8px;">Invoice To</h3>
                                    <hr>
                                    <h3 style="font-size: 14px;font-weight: 600; color: #000000; margin-bottom: 8px;">John Smith</h3>
                                </div>

                            </div>
                        </td>
                        <td>
                            <table style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
                                <tr>
                                    <td style="text-align: right;">
                                        <h1 style="margin: 0; font-size: 38px; letter-spacing: 4px;">INVOICE</h1>
                                    </td>
                                </tr>
                            </table>

                            <hr style="border: none; margin-bottom: 20px;">

                            <!-- Invoice Summary -->
                            <table style="width: 100%; border-collapse: collapse; text-align: center; margin-bottom: 30px;">
                                <tr>
                                    <td style="border-right: 1px solid #ccc; padding: 10px;">
                                        <p style="margin: 0; font-size: 13px;">Due Amount:</p>
                                        <p style="margin: 5px 0 0; font-weight: 700;">£1000.00</p>
                                    </td>
                                    <td style="border-right: 1px solid #ccc; padding: 10px;">
                                        <p style="margin: 0; font-size: 13px;">Invoice Date:</p>
                                        <p style="margin: 5px 0 0; font-weight: 700;">18 August 2023</p>
                                    </td>
                                    <td style="padding: 10px;">
                                        <p style="margin: 0; font-size: 13px;">Invoice No:</p>
                                        <p style="margin: 5px 0 0; font-weight: 700;">#12345678</p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Items Table -->
                            <table
                                style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc;">
                                <tr style="background: #fff;">
                                    <th
                                        style="text-align: left; padding: 10px 0; font-size: 14px; border-bottom: 1px solid #ccc;">
                                        Descriptions</th>
                                    <th
                                        style="text-align: left; padding: 10px 0; font-size: 14px; border-bottom: 1px solid #ccc;">
                                        Qty</th>
                                    <th
                                        style="text-align: left; padding: 10px 0; font-size: 14px; border-bottom: 1px solid #ccc;">
                                        Price</th>
                                    <th
                                        style="text-align: left; padding: 10px 0; font-size: 14px; border-bottom: 1px solid #ccc;">
                                        Total</th>
                                </tr>

                                <tr>
                                    <td style="padding: 10px 0; font-weight: 700;">Business Item 1</td>
                                    <td>1</td>
                                    <td>£100.00</td>
                                    <td>£100.00</td>
                                </tr>

                                <tr>
                                    <td style="padding: 10px 0; font-weight: 700;">Business Item 1</td>
                                    <td>2</td>
                                    <td>£100.00</td>
                                    <td>£100.00</td>
                                </tr>

                                <tr>
                                    <td style="padding: 10px 0; font-weight: 700;">Business Item 1</td>
                                    <td>1</td>
                                    <td>£100.00</td>
                                    <td>£100.00</td>
                                </tr>

                                <tr>
                                    <td style="padding: 10px 0; font-weight: 700;">Business Item 1</td>
                                    <td>2</td>
                                    <td>£100.00</td>
                                    <td>£100.00</td>
                                </tr>

                                <tr>
                                    <td style="padding: 10px 0; font-weight: 700;">Business Item 1</td>
                                    <td>1</td>
                                    <td>£100.00</td>
                                    <td>£100.00</td>
                                </tr>
                            </table>

                            <!-- Subtotal Section -->
                            <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                                <tr>
                                    <td style="width: 70%;"></td>
                                    <td style="width: 15%; text-align: right; padding-right: 10px;">Sub Total:</td>
                                    <td style="width: 15%; text-align: right;">£1000.00</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: right; padding-right: 10px;">Discount</td>
                                    <td style="text-align: right;">£1000.00</td>
                                </tr>
                            </table>

                            <hr style="border: none; border-top: 1px solid #ccc;">

                            <!-- Grand Total -->
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td style="width: 70%;"></td>
                                    <td style="width: 15%; text-align: right; font-weight: 700;">GRAND TOTAL</td>
                                    <td style="width: 15%; text-align: right; font-weight: 700;">£1000.00</td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Content -->
                    <!-- <tr>
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
                                            <img src="{{ $invoice_image3 }}" alt="" style="height: 20px;"> <b
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
                                                   
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="width: 150px;">
                                            <td>
                                                <p
                                                    style="font-family: arial;font-size:8px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                                   
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
                                                

                                            </td>
                                        </tr>

                                    </table>



                                </div>
                            </div> -->





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
