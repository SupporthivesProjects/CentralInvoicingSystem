<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name . $invoice_number }}</title>
    <style>
        body{margin:0px; padding: 0px; background-color: #191C21;}

        .footer-fixed {
        position: fixed;
        bottom: 0px;
        left: 0;
        right: 0;
        width: 100%;
        /* background: url('{{ $invoice_footer_image }}') center center no-repeat; */
        /* background-size: cover; */
        }
    </style>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #191C21;">
        <tr>
            <td align="center" bgcolor="#191C21" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#191C21"
                    style="border-collapse: collapse;  min-height: 848px; background-color: #191C21;">
                    <!-- Header -->
                    <tr>

                        <td style="height: 150px; background-image: url('{{ $company_logo }}'); background-position: center left; background-repeat: no-repeat; background-size: cover;">

                            
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr>

                        <td
                            style="padding: 0px 40px 40px 40px; font-family: 'Roboto'; font-size: 9px; vertical-align: top; background-image: url('{{ $invoice_image1 }}'); background-color: #191C21; background-position: top center; background-repeat: no-repeat; background-size: 100% 605px;">

                            <table width="50%" align="right">
                                <tr>
                                    <td align="right">
                                        <p
                                            style="color: white; font-size: 12px; font-weight: bold; margin: 0%; margin-bottom: 6px;">
                                            Invoice To :</p>
                                        <p
                                            style="font-size: 16px; font-weight: bold; color: #E85B2A; margin: 0%; margin-bottom: 6px;">
                                            {{ $customer_name }}</p>
                                        <p style="color: white; font-size: 9px; margin: 0%; margin-bottom: 6px;">
                                            {{ $customer_email }}</p>
                                    </td>
                                </tr>
                            </table>
                            <table style="width:100%; border-collapse: collapse; font-size: 11px;">
                                <tr>
                                    <td
                                        style="width:30%; color:white; padding-top: 50px; vertical-align:top;">
                                        <p style="font-weight:bold; margin-bottom:5px; margin-top: 17px;">Invoice Number</p>
                                        <p style="margin-top:0; font-size: 9px;">{{ $invoice_number }}</p>

                                        <p style="font-weight:bold; margin-top:27px; margin-bottom: 5px;">Invoice Date</p>
                                        <p style="margin-top:0; font-size: 9px;">{{ $invoice_date }}</p>
                                        <p style="font-weight:bold; font-size: 9px; margin-top: 45px;">Online Payment</p>
                                    </td>

                                    <!-- Right Invoice Section -->
                                    <td style="width:70%; padding-top: 57px; padding-left: 54px; vertical-align:top;">
                                        <table style="width:100%; color: white;">
                                            <tr>
                                                <td style="font-size:40px; font-weight:bold;">INVOICE</td>
                                                <td style="text-align:right;">
                                                    <div style="font-size:24px; font-weight:bold;">{{ site_currency() . number_format($invoice_amount, 2) }}</div>
                                                    <div style="font-size:8px; text-transform:uppercase;">TOTAL AMOUNT DUE</div>
                                                </td>
                                            </tr>
                                        </table>

                                        <table cellpadding="10px"
                                            style="width:100%;  margin-top:30px; border-collapse:collapse; font-size:8px; color: white;">
                                            <thead>
                                                <tr style="border-bottom:1px solid white;">
                                                    <th style="text-align:left; padding-bottom:10px; width: 40%;">DESCRIPTION</th>
                                                    <th style="text-align:center; padding-bottom:10px;">UNIT PRICE</th>
                                                    <th style="text-align:center; padding-bottom:10px;">QTY</th>
                                                    <th style="text-align:right; padding-bottom:10px;">TOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($products as $product)
                                                <tr>
                                                    <td>{{ $product->name }}</td>
                                                    <td style="text-align:center;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                                    <td style="text-align:center;">1</td>
                                                    <td style="text-align:right;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <hr style="border-color:white;">

                                        <table cellpadding="10" style="width:100%; font-size:8px; color: white;" >
                                            <tr>
                                                <td  style="width: 68%; text-align:right;" colspan="3">SUBTOTAL</td>
                                                <td style="text-align:right; font-size: 9px;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align:right;" colspan="3">DISCOUNT</td>
                                                <td style="text-align:right; font-size: 9px;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    <hr style="border-color:white;">
                                                </td>
                                            </tr>
                                            <tr style="font-weight:bold;">
                                                <td style="text-align:right;" colspan="3">GRAND TOTAL</td>
                                                <td style="text-align:right; font-size: 9px;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>


                        </td>
                    </tr>
                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr>
                        <td style="background-color: #191C21;">
                            <table class="footer-fixed" align="right" style="color: white; font-family: 'Roboto'; padding-bottom: 30px; font-size: 9px; background-color: #191C21;">
                                <tr>
                                    <td>
                                        <div style="width:90%; height:1px; background-color: #AFB0B1; display:flex; margin-left: auto; margin-right: auto;"></div>
                                    </td>
                                </tr>
                                <tr align="right">
                                    <td style="padding-right:40px;">
                                        <p style="margin-bottom: 5px; font-size: 11px; font-weight: bold;">{{ $company_name }}</p>
                                        <p style="margin: 0%; margin-bottom: 2px;">{!! $company_address !!}</p>
                                        <p style="margin: 0%; margin-bottom: 2px;">{{ $company_mobile }}</p>
                                        <p style="margin: 0%;">{{ $company_email }}</p>
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