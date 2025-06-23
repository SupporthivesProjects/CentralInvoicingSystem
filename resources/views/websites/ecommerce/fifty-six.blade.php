<!DOCTYPE html>
<html>

<head>
    <title>mindcloudz</title>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#F8F8F8" style="padding: 20px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="black"
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
                                            <tr>
                                                <td align="right" style="padding-right: 65px;">
                                                    <p
                                                        style="font-family: 'Nirmala UI'; font-size: 40px; color: white;">
                                                        <b>INVOICE</b>
                                                    </p>
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
                            style="padding-top:0px;background:#000000; background-repeat: no-repeat;background-position: center;background-size: cover;height:444px; font-family: 'Yu Gothic';">

                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="font-family:Nirmala UI; font-size: 10px;color: #ffffff; padding: 20px;">
                                <tr>
                                    <!-- Billing From -->
                                    <td style="width: 100%; vertical-align: top; padding: 10px;">
                                        <table cellpadding="2" cellspacing="0" style="color: #ffffff;">
                                            <tr>
                                                <td style="font-weight: bold;">Billing from</td>
                                                <td style="font-weight: bold;">Billing to</td>
                                                <td style="font-weight: bold; padding-left: 95px;">Date {{ $invoice_date }}</td>
                                            </tr>
                                            <tr>
                                                <td>Mindcloudz.co</td>
                                                <td>{{ $customer_name }}</td>
                                                <td style="font-weight: bold; padding-left: 95px;">No.{{ $invoice_number }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="" style="color: #68c4ff; text-decoration:underline;">
                                                        {{ $company_email ?? 'support@mindcloudz.co' }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold;">{{ $company_address ?? 'N/A' }}</td>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ $company_phone ?? 'N/A' }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <div style="min-height: 480px !important;">
                            <!-- PRODUCT TABLE -->
                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="border-collapse: collapse; font-family: Arial, sans-serif;">
                                <tr
                                    style="background-color: #00f5e1; color: #000000; font-weight: bold; text-align: left;">
                                    <td align="center" style="">PRODUCT</td>
                                    <td align="center" style="">PRICE</td>
                                    <td align="center" style="">QTY</td>
                                    <td align="center" style="">TOTAL</td>
                                </tr>
                                @foreach($products as $product)
                                <tr style="background-color: #2c4641; color: #ffffff; font-weight: bold;">
                                    <td align="center" style="border-bottom: 10px solid #000000;">{{ $product->name }}</td>
                                    <td align="center" style="border-bottom: 10px solid #000000;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                    <td align="center" style="border-bottom: 10px solid #000000;">{{ $product->quantity ?? 1 }}</td>
                                    <td align="center" style="border-bottom: 10px solid #000000;">{{ site_currency() . number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}</td>
                                </tr>
                                @endforeach
                            </table>



                            <!-- TOTALS SECTION -->
                            <table align="right" cellpadding="6" cellspacing="0"
                                style="font-family: 'Nirmala UI'; font-size: 11px; color: #ffffff; margin-top: 20px; padding-right: 40px;">
                                <tr>
                                    <td
                                        style="text-align: right; padding-right: 20px; padding-top: 0%; padding-bottom: 0%;">
                                        SUBTOTAL</td>
                                    <td
                                        style="text-align: right; font-weight: bold; padding-top: 0%; padding-bottom: 0%;">
                                        {{ site_currency() . number_format(($invoice_amount + $discount_amount), 2) }}</td>
                                </tr>
                                <tr>
                                    <td
                                        style="text-align: right; padding-right: 20px; padding-top: 0%; padding-bottom: 0%;">
                                        DISCOUNT</td>
                                    <td
                                        style="text-align: right; font-weight: bold; padding-top: 0%; padding-bottom: 0%;">
                                        {{ site_currency() . number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: right; padding-right: 20px; padding-top: 0%; ">
                                        TOTAL PRICE
                                    </td>
                                    <td style="text-align: right; font-weight: bold; padding-top: 0%; ">
                                        {{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                </tr>

                            </table>
                            </div>
                        </td>
                    </tr>
                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr>
                        <td>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr
                                    style="background-color: #000000; background: url('{{ $invoice_footer_image }}') no-repeat;background-position: center;background-size: cover;height:100px;padding:50px;background-size:cover;width: 100%; font-family: 'Nirmala UI'; font-size: 10px; color: #ffffff;">
                                    <td style="width: 100%; padding-left: 70px;">

                                        <table cellpadding="5" cellspacing="0">
                                            <tr>
                                                <td
                                                    style="padding: 8px;">
                                                    <img style="width: 25px; " src="{{ $invoice_image1 }}" alt="" />
                                                </td>
                                                <td>
                                                    OAKSDALE TECHNOLOGY DEVELOPMENT LIMITED<br/>
                                                    Lagos, Nigeria
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="width: 100%; padding-right: 70px;">
                                        <table cellpadding="5" cellspacing="0">
                                            <tr>
                                                <td
                                                    style="padding: 8px;">
                                                    <img style="width: 25px;" src="{{ $invoice_image2 }}"
                                                        alt="" />
                                                </td>
                                                <td>
                                                    {{ $company_email ?? 'support@mindcloudz.co' }}<br />
                                                    Mindcloudz.Co
                                                </td>
                                            </tr>
                                        </table>
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
