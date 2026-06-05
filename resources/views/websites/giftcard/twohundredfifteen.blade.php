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

    <!--
        bg.png natural ratio is approx 1412 x 1832px (portrait A4-ish).
        We pin the outer wrapper to exactly that aspect ratio so the
        background image fills 100% width AND 100% height perfectly.
        DomPDF default paper = A4 = 794px wide at 96dpi.
        Height locked to match bg.png ratio: 794 * (1832/1412) ≈ 1030px.
        Adjust $page_height below if your bg.png ratio differs.
    -->

    <table width="100%" cellspacing="0" cellpadding="0" border="0"
        style="border-collapse: collapse; width: 100%; height: 1030px;">
        <tr>
            <td style="padding: 0; vertical-align: top;">

                <!-- FULL PAGE TABLE WITH BG IMAGE -->
                <table width="100%" cellspacing="0" cellpadding="0" border="0"
                    style="border-collapse: collapse;
                           width: 100%;
                           height: 1030px;
                           background-image: url('{{ $invoice_image1 }}');
                           background-position: top left;
                           background-repeat: no-repeat;
                           background-size: 100% 100%;">

                    <!-- ====== HEADER ZONE (top ~28% of image = ~288px) ====== -->
                    <tr>
                        <td style="height: 288px; vertical-align: bottom; padding: 0;">
                            <table width="100%" style="font-family: 'Lato';">
                                <tr>
                                    <td style="font-size: 11px; padding-left: 34px; padding-bottom: 10px;">
                                        <span style="color: #ffffff;">{{ $invoice_number }}</span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span style="color: #ffffff;">{{ $invoice_date }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- ====== HEADER ZONE END ====== -->

                    <!-- ====== CONTENT ZONE (middle ~56% of image = ~577px) ====== -->
                    <tr>
                        <td style="vertical-align: top; padding: 20px 35px 0px 35px; font-family: 'Lato'; font-size: 9px;">

                            <!-- Invoice To + Total Due -->
                            <table width="100%">
                                <tr>
                                    <td style="color: #ffffff;">
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
                                            <span>Total Due </span>
                                            <span style="font-size: 30px; color: #FFD700; font-weight: bold; margin-left: 10px;">
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
                                    <td style="text-align: right; width: 90px;">UNIT PRICE</td>
                                    <td style="text-align: center;">QTY</td>
                                    <td style="text-align: center; width: 40px;">TOTAL</td>
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
                            <table width="32%" align="right" cellspacing="0" cellpadding="2"
                                style="color: #ffffff; font-size: 12px; margin-top: 4px;">
                                <tr>
                                    <td style="text-align: left; padding-left: 20px; padding-top: 10px; font-weight: bold; color: #FFD700; border-top: 2px solid #FFD700;">SUBTOTAL</td>
                                    <td style="text-align: right; padding-right: 10px; padding-top: 10px; border-top: 2px solid #FFD700;">
                                        {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; padding-left: 20px; font-weight: bold; color: #FFD700;">DISCOUNT</td>
                                    <td style="text-align: right; padding-right: 10px;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; padding-left: 20px; font-weight: bold; color: #FFD700;">TOTAL</td>
                                    <td style="text-align: right; padding-right: 10px;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    <!-- ====== CONTENT ZONE END ====== -->

                    <!-- ====== FOOTER ZONE (bottom ~16% of image = ~165px) ====== -->
                    <tr>
                        <td style="height: 165px; vertical-align: middle; padding: 0 40px;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0"
                                style="border-collapse: collapse; font-family: 'Lato';">
                                <tr>
                                    <td style="vertical-align: top; width: 60%;">
                                        <div style="font-size: 12px; font-weight: bold; color: #0C1326;">Invoice From</div>
                                        <table style="margin-top: 8px;" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="font-weight: bold; font-size: 10px; color: #0C1326;">Company Name</td>
                                                <td style="padding-left: 10px; font-style: italic; font-size: 8px; color: #444444;">{{ $company_name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; font-size: 10px; color: #0C1326;">Address</td>
                                                <td style="padding-left: 10px; font-style: italic; font-size: 8px; color: #444444;">{{ strip_tags($company_address) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td align="right" style="vertical-align: bottom; width: 40%;">
                                        <div style="color: #0C1326; font-size: 9px; padding-bottom: 5px;">{{ $company_email }}</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- ====== FOOTER ZONE END ====== -->

                </table>
                <!-- END FULL PAGE TABLE -->

            </td>
        </tr>
    </table>

</body>
</html>