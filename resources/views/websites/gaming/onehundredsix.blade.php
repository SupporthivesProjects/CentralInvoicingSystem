<!DOCTYPE html>
<html>

<head>
    <title>leprechanloot</title>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); background-image: url({{ $invoice_image1 }}); background-position: center; background-repeat: no-repeat; background-size: cover;">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 40px; height: 130px;">
                            <table width="100%" cellspacing="0" cellpadding="0"
                                style="border-collapse: collapse; font-family: 'Arial';">
                                <tr>
                                    <td>
                                        <img src="{{ $company_logo }}" alt="" width="220px">
                                    </td>
                                    <td align="right">
                                        <p style="font-size: 20px; color: #5ABA7F;">INVOICE</p>
                                        <p style="font-size: 9px; margin-bottom: 0%;">Invoice # {{ $invoice_number }}</p>
                                        <p style="font-size: 9px; margin: 0%;">Date: {{ $invoice_date }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td
                            style="padding:40px;padding-top:0px; background-repeat: no-repeat;background-position: center;background-size: cover;height:444px; font-family: 'Arial';">
                            <br>
                            <br>
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="font-family: Arial, sans-serif; font-size: 9px; color: #000; ">
                                <tr>
                                    <td><span style="color: #5ABA7F;">Bill From</span><br>{{ $site_name }} <br>Website:
                                        {{ $site->site_link }}</td>
                                    <td align="right"><span style="color: #5ABA7F;">Billed to:</span><br>{{ $customer_name }}
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <div style="min-height: 530px !important;">
                            <table width="100%" cellpadding="8" cellspacing="0" border="1"
                                style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 9px;">
                                <tr style="color: teal; font-weight: bold; text-align: left;">
                                    <td>Game</td>
                                    <td>In Game Currency</td>
                                    <td>UNIT PRICE</td>
                                    <td>TOTAL</td>
                                </tr>
                                @foreach($products as $product)
                                <!-- Empty Rows for future entries -->
                                <tr>
                                    <td>{{ $product['name'] }}</td>
                                    <td>{{ $product['game_currency_amount'] }} {{ $product['game_currency'] }}</td>
                                    <td>{{ site_currency() . number_format($product['unit_price'], 2) }}</td>
                                    <td>{{ site_currency() . number_format($product['unit_price'], 2) }}</td>
                                </tr>
                                @endforeach

                            </table>

                            <!-- Totals Section -->
                            <table width="100%" cellpadding="5" cellspacing="0"
                                style="font-family: Arial, sans-serif; font-size: 9px; margin-top: 20px;">
                                <tr>
                                    <td width="75%"></td>
                                    <td style="text-align: right; font-weight: bold;">SUBTOTAL</td>
                                    <td style="border: 1px solid #ccc; width: 100px;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                </tr>
                                <tr>
                                    <td width="75%"></td>
                                    <td style="text-align: right; font-weight: bold;">DISCOUNT</td>
                                    <td style="border: 1px solid #ccc; width: 100px;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                </tr>
                                <tr>
                                    <td width="75%"></td>
                                    <td style="text-align: right; font-weight: bold;">GRAND TOTAL</td>
                                    <td style="border: 1px solid #ccc; width: 100px;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>
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
                                    style="background: url(./images/image1.png) no-repeat;background-position: center;background-size: cover;height:60px;padding:50px;background-size:cover;width: 100%;">
                                    <td style="vertical-align: top; padding-left: 40px;">
                                        <p style="font-size: 9px; font-weight: bold;">THANK YOU, GOOD LUCK WITH YOUR GAMEPLAY!</p>
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
