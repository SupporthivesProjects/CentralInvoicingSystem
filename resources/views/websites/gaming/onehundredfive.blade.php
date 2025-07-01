<!DOCTYPE html>
<html>

<head>
    <title>MEGAMMOS</title>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0; height: 130px;">
                            <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                                <tr>
                                    <td style="
                                        background: url({{ $invoice_header_image }}) no-repeat center center;
                                        background-size: cover;
                                        height: 240px;">
                                        <table align="right">
                                            <tr>
                                                <td
                                                    style="padding: 30px; text-align: right; width: 40%; vertical-align: middle; font-family: 'Dubai'; position: relative;">


                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td
                            style="padding:40px;padding-top:0px;background:#ffffff; background-repeat: no-repeat;background-position: center;background-size: cover;height:444px; font-family: 'Arial';">
                            <br>
                            <br>
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="font-family: Arial, sans-serif; font-size: 10px; color: #000; text-align: center;">
                                <tr>
                                    <td><span>Bill From</span><br><strong>{{ $site_name }}</strong></td>
                                    <td><span>Bill To</span><br><strong>{{ $customer_name }}</strong></td>
                                    <td><span>Invoice No</span><br><strong>#{{ $invoice_number }}</strong></td>
                                    <td><span>Invoice Date</span><br><strong>{{ $invoice_date }}</strong></td>
                                    <td><span>Due Date</span><br><strong>{{ $invoice_date }}</strong></td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <div style="min-height: 500px !important;">
                            <table width="100%" cellpadding="10" cellspacing="0" border="1"
                                style="border-collapse: collapse; border: 1px solid black; font-family: Arial, sans-serif; font-size: 9px;">
                                <tr style="font-weight: bold; font-size: 10px;">
                                    <td align="center">Game</td>
                                    <td align="left">In Game Currency</td>
                                    <td align="center">Unit Price</td>
                                    <td align="center">Total</td>
                                </tr>

                                @foreach($products as $product)
                                <!-- Item Row 1 -->
                                <tr>
                                    <td align="center">{{ $product['name'] }}</td>
                                    <td align="left">
                                        <strong>{{ $product['game_currency_amount'] }} {{ $product['game_currency'] }}</strong>

                                    </td>
                                    <td align="center">{{ site_currency() . number_format($product['unit_price'], 2) }}</td>
                                    <td align="center">{{ site_currency() . number_format($product['unit_price'], 2) }}</td>
                                </tr>
                                @endforeach

                                <!-- Footer Row -->
                                <tr>
                                    <td colspan="2" style="border: none;"></td>
                                    <td style="font-weight: bold; border: 1px solid black; border-right: none;">Sub Total</td>
                                    <td style="border: 1px solid black; border-left: none;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                </tr>
                                <tr>

                                    <td colspan="2" style=" padding: 0px 0px 0px 20px; font-style: italic; border: none; font-size: 16px; font-weight: bold;">Many Thanks For Your
                                        Business!</td>
                                    <td style="font-weight: bold; border: 1px solid black; border-right: none;">Discount</td>
                                    <td style="border: 1px solid black; border-left: none;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="border: none;"></td>
                                    <td style="font-weight: bold; border: 1px solid black; border-right: none;">Grand Total</td>
                                    <td style="border: 1px solid black; border-left: none;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                </tr>
                            </table>
                            </div>
                            <!-- TOTALS SECTION -->


                        </td>
                    </tr>
                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr
                                    style="background: url(./images/image1.png) no-repeat;background-position: center;background-size: cover;height:60px;padding:50px;background-size:cover;width: 100%;">
                                    <td
                                        style="font-family: 'Dubai'; text-align:center; position: relative; color: #ffffff; font-size: 10px;">
                                        <p style="position: absolute; top: 15px; left: 60px;">{{ $company_mobile }}</p>
                                        <p style="position: absolute; top: 15px; left: 174px;">{{ $company_email }}</p>
                                        <p style="position: absolute; top: 15px; left: 313px;">{{ $company_address }}</p>
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
