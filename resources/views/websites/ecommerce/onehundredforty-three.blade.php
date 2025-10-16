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
            <td align="center" bgcolor="#ffffff" style="padding: 0px 16px;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; ">
                    <!-- Header -->
                    <tr>
                        <td colspan="2" style="padding: 0px;">
                            
                            <img src="{{ $invoice_header_image }}" alt=""
                                style="height: 20px; width: 190px;">
                                   
                        </td>
                    </tr>
                    <!-- Header End -->

                    <tr>
                        <td style="vertical-align: top;width: 190px;padding-top: 40px;">
                            <div class="" style="display: flex; flex-direction: row; justify-content: flex-start; align-items: flex-start; gap: 12px;margin-bottom: 8px;padding-left: 12px;">
                                <img src="{{ $invoice_image4 }}" alt="" style="height: 30px; width: 30px;">
                                <div class="" style="display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start;">
                                    <b style="font-size: 12px;">Area</b> 
                                    <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">123 London road, kent, abc 123</p>
                                </div>
                            </div>
                            <div class="" style="display: flex; flex-direction: row; justify-content: flex-start; align-items: flex-start; gap: 12px;margin-bottom: 8px;padding-left: 12px;">
                                <img src="{{ $invoice_image5 }}" alt="" style="height: 30px; width: 30px;">
                                <div class="" style="display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start;">
                                    <b style="font-size: 12px;">Phone</b> 
                                    <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">+44 123 456 789</p>
                                </div>
                            </div>
                            <div class="" style="display: flex; flex-direction: row; justify-content: flex-start; align-items: flex-start; gap: 12px;margin-bottom: 8px;padding-left: 12px;">
                                <img src="{{ $invoice_image3 }}" alt="" style="height: 30px; width: 30px;">
                                <div class="" style="display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start;">
                                    <b style="font-size: 12px;">Email</b> 
                                    <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">info@estarsolutions.com</p>
                                </div>
                            </div>
                            <div class="" style="display: flex; flex-direction: row; justify-content: flex-start; align-items: flex-start; gap: 12px;margin-bottom: 8px;padding-left: 12px;">
                                <img src="{{ $invoice_image2 }}" alt="" style="height: 30px; width: 30px;">
                                <div class="" style="display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start;">
                                    <b style="font-size: 12px;">Website</b> 
                                    <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;"><a href="{{ $site->site_link }}" style="text-decoration:none; color: #000000;">www.estarsolutions.co</a></p>
                                </div>
                            </div>
                            <br>
                            <div style="background-image: url({{ $invoice_image1 }});background-size: cover;background-repeat:no-repeat;background-position: top center; padding: 24px 16px; min-height: 830px;">

                                <!-- Billed From Section -->
                                <div style="margin-bottom: 40px;">
                                    <h3 style="font-size: 14px;font-weight: 600; color: #000000; margin-bottom: 8px;">Billed From:</h3>
                                    <div style="width: 100%; height: 1px; background: #000000; margin-bottom: 8px;"></div>
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
                                    <div style="width: 100%; height: 1px; background: #000000; margin-bottom: 8px;"></div>
                                    <h3 style="font-size: 14px;font-weight: 600; color: #000000; margin-bottom: 8px;">John Smith</h3>
                                </div>

                            </div>
                        </td>
                        <td style="vertical-align: top;padding-top: 40px;padding-left: 30px;padding-right: 30px;">
                            <table style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
                                <tr>
                                    <td style="text-align: right;">
                                        <h1 style="margin: 0; font-size: 38px; letter-spacing: 4px;">INVOICE</h1>
                                    </td>
                                </tr>
                            </table>

                            <div style="width: 100%; height: 1px; background: #000000;margin-bottom: 20px;"></div>

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
                                        style="text-align: right; padding: 10px 0;padding-right: 10px; font-size: 14px; border-bottom: 1px solid #ccc;">
                                        Price</th>
                                    <th
                                        style="text-align: right; padding: 10px 0; font-size: 14px; border-bottom: 1px solid #ccc;">
                                        Total</th>
                                </tr>

                                <tr>
                                    <td style="padding: 10px 0; font-weight: 700; border-bottom: 1px solid #ccc;">Business Item 1</td>
                                    <td style="border-bottom: 1px solid #ccc;">1</td>
                                    <td style="text-align: right; padding-right: 10px;border-bottom: 1px solid #ccc;">£100.00</td>
                                    <td style="text-align: right;border-bottom: 1px solid #ccc;">£100.00</td>
                                </tr>

                                <tr>
                                    <td style="padding: 10px 0; font-weight: 700; border-bottom: 1px solid #ccc;">Business Item 1</td>
                                    <td style="border-bottom: 1px solid #ccc;">2</td>
                                    <td style="text-align: right; padding-right: 10px;border-bottom: 1px solid #ccc;">£100.00</td>
                                    <td style="text-align: right;border-bottom: 1px solid #ccc;">£100.00</td>
                                </tr>

                                <tr>
                                    <td style="padding: 10px 0; font-weight: 700; border-bottom: 1px solid #ccc;">Business Item 1</td>
                                    <td style="border-bottom: 1px solid #ccc;">1</td>
                                    <td style="text-align: right; padding-right: 10px;border-bottom: 1px solid #ccc;">£100.00</td>
                                    <td style="text-align: right;border-bottom: 1px solid #ccc;">£100.00</td>
                                </tr>

                                <tr>
                                    <td style="padding: 10px 0; font-weight: 700; border-bottom: 1px solid #ccc;">Business Item 1</td>
                                    <td style="border-bottom: 1px solid #ccc;">2</td>
                                    <td style="text-align: right; padding-right: 10px;border-bottom: 1px solid #ccc;">£100.00</td>
                                    <td style="text-align: right;border-bottom: 1px solid #ccc;">£100.00</td>
                                </tr>

                                <tr>
                                    <td style="padding: 10px 0; font-weight: 700; border-bottom: 1px solid #ccc;">Business Item 1</td>
                                    <td style="border-bottom: 1px solid #ccc;">1</td>
                                    <td style="text-align: right; padding-right: 10px;border-bottom: 1px solid #ccc;">£100.00</td>
                                    <td style="text-align: right;border-bottom: 1px solid #ccc;">£100.00</td>
                                </tr>

                            <!-- Subtotal Section -->
                                <tr>
                                    <td colspan="2"></td>
                                    <td style="text-align: right; padding-right: 10px;">Sub Total:</td>
                                    <td style="text-align: right;">£1000.00</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td style="text-align: right; padding-right: 10px;">Discount:</td>
                                    <td style="text-align: right;">£1000.00</td>
                                </tr>
                            </table>


                            <!-- Grand Total -->
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td style="text-align: right; font-weight: 700;">GRAND TOTAL</td>
                                    <td style="width: 10%; text-align: right; font-weight: 700;">£1000.00</td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    

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
