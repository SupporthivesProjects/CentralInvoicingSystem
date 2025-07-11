<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
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
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td
                            style="padding:40px;padding-top:0px;background:#ffffff; background-repeat: no-repeat;background-position: center;background-size: cover;height:444px; font-family: 'Calibri ';">
                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="border-collapse: collapse; margin-bottom: 20px;">
                                <tr style="background-color: #194F44; color: white;">
                                    <td align="left" style="font-weight: bold; font-size: 14px;">
                                        <p style="margin: 0%;">INVOICE NO. {{ $invoice_number }}</p>
                                    </td>
                                    <td align="right" style="font-weight: bold; font-size: 14px;">
                                        <p style="margin: 0%;">DATE {{ $invoice_date }}</p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Bill To / Billed From -->
                            <table width="100%" cellpadding="4" cellspacing="0"
                                style=" margin-bottom: 10px; font-size: 10px;">
                                <tr>
                                    <td align="center" style="border-bottom: 1px solid #000;">
                                        <strong>
                                            <p style="margin: 0%;">BILL TO</p>
                                        </strong>
                                    </td>
                                    <td align="center" style="border-bottom: 1px solid #000;">
                                        <strong>
                                            <p style="margin: 0%;">BILLED FROM</p>
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <p style="margin: 0%;">{{ $customer_name }}</p>
                                    </td>
                                    <td align="center">
                                        <p style="margin: 0%;">{{ $site_name }}</p>
                                    </td>
                                </tr>
                            </table>

                            <br>
                            <div style="min-height: 550px !important;">
                            <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse; font-size: 10px;">
                                    <tr style="background-color: #194F44; color: white; font-weight: bold;">
                                        <td align="left">QUANTITY</td>
                                        <td align="left">DESCRIPTION</td>
                                        <td align="right">UNIT PRICE</td>
                                        <td align="right">TOTAL</td>
                                    </tr>

                                    @foreach ($products as $product)
                                        <tr>
                                            <td align="left">{{ $product->quantity ?? 1 }}</td>
                                            <td align="left">{{ $product->name }}</td>
                                            <td align="right">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                            <td align="right">{{ site_currency() . number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}</td>
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="2"></td>
                                        <td align="left">SUBTOTAL</td>
                                        <td align="right">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                    </tr>
                                    <tr style="background-color: #F2F2F2;">
                                        <td colspan="2"></td>
                                        <td align="left">DISCOUNT</td>
                                        <td align="right">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td align="left" style="font-size: 14px; font-weight: bold;">TOTAL</td>
                                        <td align="right" style="font-size: 14px; font-weight: bold;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
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
                                    style="background: url('{{ $invoice_footer_image }}') no-repeat;background-position: center;background-size: cover;height:120px;padding:50px;background-size:cover;width: 100%; font-size: 10px; font-family: 'Cambria ';">
                                    <td style="width: 31.33%;">
                                        <table align="right">
                                            <tr>
                                                <td><img src="{{ $invoice_image1 }}" style="vertical-align: middle;"></td>
                                                <td>
                                                    <p style="color: #ffffff;">{{ $company_mobile }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="width: 24%;">
                                        <table align="center">
                                            <tr>
                                                <td><img src="{{ $invoice_image2 }}" style="vertical-align: middle;"></td>
                                                <td>
                                                    <p style="color: #ffffff;">{{ $company_email }}</p>
                                                </td>
                                            </tr>
                                        </table>


                                    </td>
                                    <td>
                                        <table align="left">
                                            <tr>
                                                <td><img src="{{ $invoice_image3 }}" style="vertical-align: middle;"></td>
                                                <td>
                                                    <p style=" color: #ffffff;">{!! $company_address !!}</p>
                                                </td>
                                            </tr>
                                        </table>


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