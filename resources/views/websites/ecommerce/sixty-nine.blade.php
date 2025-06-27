<!DOCTYPE html>
<html>

<head>
    <title>theeworm</title>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#FDF4EE"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0; height: 130px;">
                            <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                                <tr>
                                    <td style="
                                        background: url('{{ $invoice_header_image }}') no-repeat center;
                                        background-size: cover;
                                        height: 130px;">
                                        <table width="100%">
                                            <tr style="position: relative;">
                                                <td align="right" style="padding-right: 30px;">
                                                    <img src="{{ $invoice_image1 }}" alt=""
                                                        style="width: 215px; position: absolute; top: -68px; left: 408px;">
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
                            style="padding:40px;padding-top:0px;background:#FDF4EE; background-repeat: no-repeat;background-position: center;background-size: cover;height:444px; font-family: 'Yu Gothic';">
                            <table>
                                <tr>
                                    <td width="100%" style="vertical-align: top;">
                                        <table>
                                            <tr>
                                                <td>
                                                    <h2 style="margin: 0; color: #306961; font-size: 26px;">Invoice</h2>
                                                </td>
                                                <td>
                                                    <p
                                                        style="margin: 5px 0; font-size: 11px; color: #666; padding-left: 70px;">
                                                        <span style="color: #306961;">#{{ $invoice_number }}</span><br>
                                                        Date: {{ $invoice_date }}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                        <table cellpadding="5" cellspacing="0" style="font-size: 11px;">
                                            <tr>
                                                <td style="vertical-align: top; color: #595959;">
                                                    <strong style="color: #306961;">Billed To:</strong><br>
                                                    {{ $customer_name }}
                                                </td>
                                                <td style="vertical-align: top;  padding-left: 75px; color: #595959;">
                                                    <strong style="color: #306961;">Billed From:</strong><br>
                                                    Deaton Company Limited<br>
                                                    Kenya<br>
                                                    {{ $customer_email ?? 'support@theeworm.co.com' }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <!-- PRODUCT TABLE -->
                            <div style="min-height: 550px !important;">
                            <table width="100%" cellpadding="8" cellspacing="0"
                                style="border-collapse: collapse; font-size: 11px; background-color: #fef3ed; color: #333;">
                                <tr style="background-color: #1e4c45; color: #ffffff;">
                                    <th align="left" style="border: 1px solid black;">Product</th>
                                    <th align="center" style="border: 1px solid black;">Price</th>
                                    <th align="center" style="border: 1px solid black;">QTY</th>
                                    <th align="right" style="border: 1px solid black;">Total</th>
                                </tr>

                                <!-- Repeat rows -->
                                @foreach($products as $product)
                                <tr>
                                    <td style="border: 1px solid black;">
                                        {{ $product->name }}<br>
                                        <span style="font-size: 11px; color: #555;">{{ $product->category_name }}</span>
                                    </td>
                                    <td align="center" style="border: 1px solid black;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                    <td align="center" style="border: 1px solid black;">1</td>
                                    <td align="right" style="border: 1px solid black;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                </tr>
                                @endforeach
                            </table>

                            <!-- TOTALS SECTION -->
                            <table align="right" cellpadding="8" cellspacing="0"
                                style="margin-top: 20px; background-color: #ffc940; width: 250px; font-size: 11px; color: #333;">
                                <tr>
                                    <td>Subtotal</td>
                                    <td align="right">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Discount</td>
                                    <td align="right">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; color: #306961;">Grant total</td>
                                    <td align="right" style="font-weight: bold; color: #306961;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
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
                                    style="background: url('{{ $invoice_footer_image }}') no-repeat;background-position: center;background-size: cover;height:75px;padding:50px;background-size:cover;width: 100%;">
                                    <td>

                                    </td>
                                </tr>
                                <tr>
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
