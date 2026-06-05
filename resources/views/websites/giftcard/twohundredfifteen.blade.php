<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body {
            margin: 0px;
            padding: 0px;
        }
    </style>
</head>

<body style="background: #0E162D">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#0E162D" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#0E162D"
                    style="border-collapse: collapse; background-image: url('{{ $invoice_image1 }}'); background-position: top left; background-repeat: no-repeat; background-size: 100% auto;">

                    <!-- Header -->
                    <tr>
                        <td style="height: 290px;">
                            <table style="font-family: 'Lato';">
                                <tr>
                                    <td style="position: absolute; font-size: 11px;">
                                        <span style="color: #ffffff; position: relative; top: 155px; left: 34px;">{{ $invoice_number }}</span>
                                        <span style="color: #ffffff; position: relative; top: 155px; left: 204px;">{{ $invoice_date }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                    <!-- Content -->
                    <tr>
                        <td style="padding: 35px; padding-top: 110px; font-family: 'Lato'; font-size: 9px; vertical-align: top;">

                            <table width="100%">
                                <tr>
                                    <td style="color: #ffffff;">
                                        <span style="font-size: 14px;">Invoice To :</span><br>
                                    </td>
                                    <td align="right" style="color: white;">
                                        <p>&nbsp;</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #ffffff; vertical-align: top;">
                                        <span style="font-size: 20px; font-family: 'Lato ExtraBold'; font-weight: bold; margin: 0%;">{{ $customer_name }}</span>
                                    </td>
                                    <td align="right" style="color: white;">
                                        <div style="text-align: center; font-size: 12px;">
                                            <span>Total Due </span>
                                            <span style="font-size: 30px; color: #FFD700; font-weight: bold; margin-left: 10px;">
                                                {{ site_currency() . number_format($invoice_amount, 2) }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <br><br>

                            <table width="100%" cellpadding="15" cellspacing="0"
                                style="border-collapse: collapse; color: white;">
                                <!-- Table Header -->
                                <tr style="color: #FFD700; font-weight: bold; text-align: left; border-bottom: 2px solid #FFD700; font-size: 15px;">
                                    <td>ITEM DESCRIPTION</td>
                                    <td style="text-align: right; width: 90px;">UNIT PRICE</td>
                                    <td style="text-align: center;">QTY</td>
                                    <td style="text-align: center; width: 40px;">TOTAL</td>
                                </tr>

                                <!-- Table Rows -->
                                @foreach($products as $product)
                                <tr style="font-size: 14px;">
                                    <td>{{ $product->name }}</td>
                                    <td style="text-align: right;">{{ site_currency() . number_format($product->price ?? $product->unit_price ?? 0, 2) }}</td>
                                    <td style="text-align: center;">{{ $product->quantity ?? 1 }}</td>
                                    <td style="text-align: center;">{{ site_currency() . number_format($product->total ?? $product->unit_price ?? 0, 2) }}</td>
                                </tr>
                                @endforeach
                            </table>

                            <!-- Subtotal, Discount, Total -->
                            <table width="30%" align="right" cellspacing="0" cellpadding="2"
                                style="color: #ffffff; font-size: 14px;">
                                <tr>
                                    <td style="text-align: left; padding-left: 30px; padding-top: 15px; font-weight: bold; color: #FFD700; border-top: 2px solid #FFD700;">SUBTOTAL</td>
                                    <td style="text-align: right; padding-right: 10px; padding-top: 15px; border-top: 2px solid #FFD700;">
                                        {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; padding-left: 30px; font-weight: bold; color: #FFD700;">DISCOUNT</td>
                                    <td style="text-align: right; padding-right: 10px;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; padding-left: 30px; font-weight: bold; color: #FFD700;">TOTAL</td>
                                    <td style="text-align: right; padding-right: 10px;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    <!-- Content End -->

                    <!-----------Footer----------->
                    <tr>
                        <td style="padding: 20px 40px 25px 40px;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0"
                                style="border-collapse: collapse; font-family: 'Lato';">
                                <tr>
                                    <td style="vertical-align: top; width: 60%;">
                                        <div style="font-size: 12px; font-weight: bold; color: #0C1326;">Invoice From</div>
                                        <table style="margin-top: 10px;" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="font-weight: bold; font-size: 10px; color: #0C1326;">Company Name</td>
                                                <td style="padding-left: 10px; font-style: italic; font-size: 8px; color: #333;">{{ $company_name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; font-size: 10px; color: #0C1326;">Address</td>
                                                <td style="padding-left: 10px; font-style: italic; font-size: 8px; color: #333;">{{ strip_tags($company_address) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td align="right" style="vertical-align: bottom; width: 40%;">
                                        <div style="color: #0C1326; font-size: 9px;">{{ $company_email }}</div>
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