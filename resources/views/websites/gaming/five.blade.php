<!DOCTYPE html>
<html>
<head>
    <title>Your Email   Title</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px; max-height: 130px;">
                            <table>
                                <tr>
                                    <td style="height: 120px; background: url({{ $invoice_header_image }}) no-repeat; background-position: center; background-size: cover; width: 1000px;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                    <!-- Content -->
                    <tr style="background: url(Picture3.png) no-repeat; background-position: center; background-size: cover;">
                        <td style="padding: 40px; padding-top: 0px;">
                            <table>
                                <tr>
                                    <td style="padding-top: 10px;">
                                        <p style="font-family: arial; font-size: 10px; margin: 0px; font-weight: 400;">
                                            <b>Invoice Number:</b> #{{ $invoice_number }}
                                        </p>
                                        <br>
                                        <p style="font-family: arial; font-size: 10px; margin: 0px; font-weight: 400;">
                                            <b>Date</b> {{ $invoice_date }}
                                        </p>
                                        <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 10px; width: 300px;">
                                        <p style="font-family: arial; font-size: 10px; margin: 0px; font-weight: 400; border: 2px solid darkgreen; text-align: left; padding-top: 5px; padding-bottom: 5px;">
                                            <b>BILLED FROM:</b>
                                        </p>
                                    </td>
                                    <td style="padding-top: 10px; width: 300px;">
                                        <p style="font-family: arial; font-size: 10px; margin: 0px; font-weight: 400; border: 2px solid darkgreen; padding-top: 5px; padding-bottom: 5px;">
                                            <b>BILLED TO:</b>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 10px; width: 300px;">
                                        <p style="font-family: arial; font-size: 10px; margin: 0px; font-weight: 400; border-bottom: 1px solid black; text-align: left; padding-top: 5px; padding-bottom: 5px;">
                                            <b>{{ $site_name }}</b>
                                        </p>
                                    </td>
                                    <td style="padding-top: 10px; width: 300px;">
                                        <p style="font-family: arial; font-size: 10px; margin: 0px; font-weight: 400; border-bottom: 1px solid black; padding-top: 5px; padding-bottom: 5px;">
                                            <b>{{ $customer_name }}</b>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <div style="min-height: 500px !important;">
                            <table style="border-collapse: collapse; border-bottom: 0px; border: 0px;">
                                <tr style="height: 30px; background-color: darkgreen; color: white;">
                                    <td style="width: 200px; text-align: left; font-family: arial; font-size: 10px; font-weight: 400; padding-left: 5px;">
                                        <b>Game</b>
                                    </td>
                                    <td style="width: 400px; text-align: left; font-family: arial; font-size: 10px; font-weight: 400;">
                                        <b>GAME / CURRENCY AMOUNT</b>
                                    </td>
                                    <td style="width: 200px; text-align: left; font-family: arial; font-size: 10px; font-weight: 400; padding-left: 5px;">
                                        <b>QTY</b>
                                    </td>
                                    <td style="width: 200px; text-align: left; font-family: arial; font-size: 10px; font-weight: 400;">
                                        <b>UNIT PRICE</b>
                                    </td>
                                    <td style="width: 200px; text-align: left; font-family: arial; font-size: 10px; font-weight: 400;">
                                        <b>TOTAL</b>
                                    </td>
                                </tr>
                                @foreach($products as $index => $product)
                                <tr style="height: 30px; border-bottom: 1px solid black;">
                                    <td style="width: 100px; text-align: left; font-family: arial; font-size: 10px; font-weight: 400; padding-left: 4px;">
                                        {{ $product['name'] }}
                                    </td>
                                    <td style="width: 300px; text-align: left; font-family: arial; font-size: 10px; font-weight: 400;">
                                        {{ $product['game_currency_amount'] }} {{ $product['game_currency'] }}
                                    </td>
                                    <td style="width: 100px; text-align: left; font-family: arial; font-size: 10px; font-weight: 400; padding-left: 5px;">
                                        1
                                    </td>
                                    <td style="width: 100px; text-align: left; font-family: arial; font-size: 10px; font-weight: 400;">
                                        {{ $currency . number_format($product['unit_price'], 2) }}
                                    </td>
                                    <td style="width: 100px; text-align: left; font-family: arial; font-size: 10px; font-weight: 400;">
                                        {{ $currency . number_format($product['unit_price'], 2) }}
                                    </td>
                                </tr>
                                @endforeach
                                <tr style="height: 30px;">
                                    <td style="width: 100px;"></td>
                                    <td style="width: 300px;"></td>
                                    <td style="width: 100px; text-align: left; font-family: arial; font-size: 10px; font-weight: 400; padding-left: 5px;">
                                        <b>INVOICE TOTAL</b>
                                    </td>
                                    <td style="width: 100px;"></td>
                                    <td style="width: 100px;"></td>
                                </tr>
                                <tr style="height: 30px;">
                                    <td style="width: 100px;"></td>
                                    <td style="width: 300px;"></td>
                                    <td style="width: 100px; text-align: left; font-family: arial; font-size: 10px; font-weight: 400; padding-left: 5px; border-bottom: 1px solid black;">
                                        SUBTOTAL
                                    </td>
                                    <td style="width: 100px; border-bottom: 1px solid black;"></td>
                                    <td style="width: 100px; text-align: right; font-family: arial; font-size: 10px; font-weight: 400; border-bottom: 1px solid black;">
                                        {{ $currency . number_format($invoice_amount+$discount_amount, 2) }}
                                    </td>
                                </tr>
                                <tr style="height: 30px;">
                                    <td style="width: 100px;"></td>
                                    <td style="width: 300px;"></td>
                                    <td style="width: 100px; text-align: left; font-family: arial; font-size: 10px; font-weight: 400; padding-left: 5px; border-bottom: 1px solid black;">
                                        DISCOUNT
                                    </td>
                                    <td style="width: 100px; border-bottom: 1px solid black;"></td>
                                    <td style="width: 100px; text-align: right; font-family: arial; font-size: 10px; font-weight: 400; border-bottom: 1px solid black;">
                                        {{ $currency . number_format($discount_amount, 2) }}
                                    </td>
                                </tr>
                                <tr style="height: 30px;">
                                    <td style="width: 100px;"></td>
                                    <td style="width: 300px;"></td>
                                    <td style="width: 100px; text-align: left; font-family: arial; font-size: 10px; font-weight: 400; padding-left: 5px;">
                                        <b>GRAND TOTAL</b>
                                    </td>
                                    <td style="width: 100px;"></td>
                                    <td style="width: 100px; text-align: right; font-family: arial; font-size: 10px; font-weight: 400;">
                                        {{ $currency . number_format($invoice_amount, 2) }}
                                    </td>
                                </tr>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <!-- Content End-->

                    <!-- Footer -->
                    <tr>
                        <td style="height: 130px;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
                                <tr>
                                    <td style="text-align: center;">
                                        <p style="text-align: center; font-family: arial; font-size: 10px; margin: 0px; font-weight: 700; color: whitesmoke;">
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Footer End -->
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
