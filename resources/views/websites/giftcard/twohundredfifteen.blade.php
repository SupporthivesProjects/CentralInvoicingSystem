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

<body style="margin: 0; padding: 0; background: #0E162D;">

    <table width="100%" cellspacing="0" cellpadding="0" border="0"
        style="border-collapse: collapse; width: 100%; height: 1122px;">
        <tr>
            <td style="padding: 0; vertical-align: top;">

                <table width="100%" cellspacing="0" cellpadding="0" border="0"
                    style="border-collapse: collapse;
                           width: 100%;
                           height: 1122px;
                           table-layout: fixed;
                           background-image: url('{{ $invoice_image1 }}');
                           background-position: top left;
                           background-repeat: no-repeat;
                           background-size: 100% 100%;">

                    <!-- ====== HEADER ZONE: 370px = 33% of 1122 ====== -->
                    <tr>
                        <td style="height: 370px; vertical-align: bottom; padding: 0 0 14px 34px; font-family: 'Lato'; font-size: 11px;">
                            <span style="color: #ffffff;">{{ $invoice_number }}</span>
                            <span style="color: #ffffff; padding-left: 175px;">{{ $invoice_date }}</span>
                        </td>
                    </tr>

                    <!-- ====== CONTENT ZONE: min-height 582px, grows with products ====== -->
                    <tr>
                        <td style="vertical-align: top;
                                   padding: 25px 35px 10px 35px;
                                   font-family: 'Lato';
                                   font-size: 9px;
                                   min-height: 582px;">

                            <!-- Invoice To + Total Due -->
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="color: #ffffff; padding-bottom: 4px;">
                                        <span style="font-size: 14px;">Invoice To :</span>
                                    </td>
                                    <td align="right" style="color: white;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="color: #ffffff; vertical-align: top;">
                                        <span style="font-size: 20px; font-family: 'Lato ExtraBold'; font-weight: bold;">{{ $customer_name }}</span>
                                    </td>
                                    <td align="right" style="color: white; vertical-align: middle;">
                                        <div style="text-align: center; font-size: 12px;">
                                            <span>Total Due</span><br>
                                            <span style="font-size: 30px; color: #FFD700; font-weight: bold;">
                                                {{ site_currency() . number_format($invoice_amount, 2) }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <br>

                            <!-- Items Table -->
                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="border-collapse: collapse; color: white;">
                                <tr style="color: #FFD700; font-weight: bold; text-align: left; border-bottom: 2px solid #FFD700; font-size: 13px;">
                                    <td>ITEM DESCRIPTION</td>
                                    <td style="text-align: right; width: 100px;">UNIT PRICE</td>
                                    <td style="text-align: center; width: 60px;">QTY</td>
                                    <td style="text-align: center; width: 80px;">TOTAL</td>
                                </tr>

                                @foreach($products as $product)
                                <tr style="font-size: 12px;">
                                    <td>{{ $product->name }}</td>
                                    <td style="text-align: right;">{{ site_currency() . number_format($product->price ?? $product->unit_price ?? 0, 2) }}</td>
                                    <td style="text-align: center;">{{ $product->quantity ?? 1 }}</td>
                                    <td style="text-align: center;">{{ site_currency() . number_format($product->total ?? $product->unit_price ?? 0, 2) }}</td>
                                </tr>
                                @endforeach
                            </table>

                            <!-- Subtotal / Discount / Total -->
                            <table width="32%" align="right" cellspacing="0" cellpadding="3"
                                style="color: #ffffff; font-size: 12px; margin-top: 4px;">
                                <tr>
                                    <td style="padding-left: 20px; padding-top: 10px; font-weight: bold; color: #FFD700; border-top: 2px solid #FFD700; text-align: left;">SUBTOTAL</td>
                                    <td style="padding-right: 10px; padding-top: 10px; border-top: 2px solid #FFD700; text-align: right;">
                                        {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px; font-weight: bold; color: #FFD700; text-align: left;">DISCOUNT</td>
                                    <td style="padding-right: 10px; text-align: right;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px; font-weight: bold; color: #FFD700; text-align: left;">TOTAL</td>
                                    <td style="padding-right: 10px; text-align: right;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    <!-- ====== CONTENT ZONE END ====== -->

                    <!-- ====== WHITE FOOTER ZONE: 130px = 12% of 1122 ====== -->
                    <tr>
                        <td style="height: 130px; vertical-align: middle; padding: 0 40px; background-color: transparent;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0"
                                style="border-collapse: collapse; font-family: 'Lato';">
                                <tr>
                                    <td style="vertical-align: top; width: 55%;">
                                        <div style="font-size: 12px; font-weight: bold; color: #0C1326;">Invoice From</div>
                                        <table style="margin-top: 8px;" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="font-weight: bold; font-size: 10px; color: #0C1326; white-space: nowrap;">Company Name</td>
                                                <td style="padding-left: 8px; font-style: italic; font-size: 8px; color: #444444;">{{ $company_name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; font-size: 10px; color: #0C1326; white-space: nowrap;">Address</td>
                                                <td style="padding-left: 8px; font-style: italic; font-size: 8px; color: #444444;">{{ strip_tags($company_address) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td align="right" style="vertical-align: bottom; width: 45%; padding-bottom: 8px;">
                                        <div style="color: #0C1326; font-size: 9px;">{{ $company_email }}</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- ====== WHITE FOOTER ZONE END ====== -->

                    <!-- ====== DARK BOTTOM BAR: 40px = 3% of 1122 ====== -->
                    <tr>
                        <td style="height: 40px;">&nbsp;</td>
                    </tr>
                    <!-- ====== DARK BOTTOM BAR END ====== -->

                </table>

            </td>
        </tr>
    </table>

</body>
</html>