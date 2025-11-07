<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #ffffff; font-size: 11px; width: 210mm; height: 297mm; position: relative;">

    <!-- Header -->
    <div style="position: fixed; top: 0; left: 0; width: 100%; max-height: 130px;">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <tr>
                <td style="height: 122px; background: url('{{ $invoice_header_image }}') no-repeat center; background-size: cover; width: 100%;">
                </td>
            </tr>
        </table>
    </div>
    <!-- Header End -->

    <!-- Content -->
    <div style="padding-top: 150px; padding-bottom: 130px; padding-left: 80px; padding-right: 80px; ">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style="margin: 0; border-collapse: collapse;">
            <tr>
                <td align="center" bgcolor="#f2f2f2" style="padding: 0;">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; margin: 0 auto;">

                        <tr>
                            <td style="padding: 40px 0 0 0;">
                                <table width="100%" style="border-collapse: collapse; border: 0;">
                                    <tr style="background-color: #F4F4F4; border: 1px solid black;">
                                        <td style="padding-top: 10px; width: 50%; text-align: right;">
                                            <p style="font-family: arial; font-size: 11px; margin: 0; padding-bottom: 5px;">
                                                <b>INVOICE</b> #: {{ $invoice_number }}
                                            </p>
                                        </td>
                                        <td style="padding-top: 10px; width: 50%; text-align: left;">
                                            <p style="font-family: arial; font-size: 11px; margin: 0; padding-bottom: 5px;">
                                                <b>DATE:</b> {{ $invoice_date }}
                                            </p>
                                        </td>
                                    </tr>

                                    <tr style="height: 20px;">
                                        <td colspan="2"></td>
                                    </tr>

                                    <tr>
                                        <td style="font-family: 'Gill Sans', Calibri, sans-serif; text-align: center; font-size: 11px;">
                                            <b>BILLED FROM:</b><br>
                                            {{ $site_name }}<br>
                                          
                                            {!! $company_address !!}<br>
                                            <strong>Email:</strong> {{ $company_email }}
                                        </td>
                                        <td style="font-family: 'Gill Sans', Calibri, sans-serif; text-align: center; font-size: 11px;">
                                            <b>BILLED TO:</b><br>
                                            {{ $customer_name }}
                                        </td>
                                    </tr>
                                </table>

                                <table width="100%" style="border-collapse: collapse; border: 0; margin-top: 20px;">
                                    <tr style="height: 30px; background-color: #F4F4F4; border: 1px solid black; font-family: 'Gill Sans', Calibri, sans-serif;">
                                        <td style="width: 15%; text-align: left; font-size: 10px; padding-left: 5px; border: 1px solid black;">
                                            <b>ITEM NO.</b>
                                        </td>
                                        <td style="width: 35%; text-align: left; font-size: 10px; padding-left: 5px; border: 1px solid black;">
                                            <b>PACKAGE</b>
                                        </td>
                                        <td style="width: 25%; text-align: left; font-size: 10px; border: 1px solid black;">
                                            <b>DURATION</b>
                                        </td>
                                        <td style="width: 25%; text-align: right; font-size: 10px; padding-right: 10px; border: 1px solid black;">
                                            <b>TOTAL</b>
                                        </td>
                                    </tr>

                                    @foreach($products as $index => $product)
                                    <tr style="height: 30px; border: 1px solid black; font-family: 'Gill Sans', Calibri, sans-serif;">
                                        <td style="text-align: left; font-size: 10px; padding-left: 5px; border: 1px solid black;">
                                            {{ $index + 1 }}
                                        </td>
                                        <td style="text-align: left; font-size: 10px; padding-left: 5px; border: 1px solid black;">
                                            {{ $product->name }}
                                        </td>
                                        <td style="text-align: left; font-size: 10px; border: 1px solid black;">
                                            {{ $product->subscription ?? '-' }}
                                        </td>
                                        <td style="text-align: right; font-size: 10px; padding-right: 10px; border: 1px solid black;">
                                            {{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}
                                        </td>
                                    </tr>
                                    @endforeach

                                    <tr style="height: 30px;">
                                        <td colspan="2"></td>
                                        <td style="text-align: right; font-size: 10px; padding-right: 5px;">SUBTOTAL</td>
                                        <td style="text-align: right; font-size: 10px; padding-right: 10px; border: 1px solid black;">
                                            {{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}
                                        </td>
                                    </tr>
                                    <tr style="height: 30px;">
                                        <td colspan="2"></td>
                                        <td style="text-align: right; font-size: 10px; padding-right: 5px;">DISCOUNT</td>
                                        <td style="text-align: right; font-size: 10px; padding-right: 10px; border: 1px solid black;">
                                            {{ site_currency() }} {{ number_format($discount_amount ?? 0, 2) }}
                                        </td>
                                    </tr>
                                    <tr style="height: 30px; ">
                                        <td colspan="2"></td>
                                        <td style="text-align: right; font-size: 10px; padding-right: 5px;"><b>TOTAL DUE</b></td>
                                        <td style="text-align: right; font-size: 10px; padding-right: 10px; border: 1px solid black;">
                                            <b>{{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}</b>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
    </div>
    <!-- Content End -->

    <!-- Footer -->
    <div style="position: fixed; bottom: 0; left: 0; width: 100%;  ">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; ">
            <tr style="background: url('{{ $invoice_footer_image }}') no-repeat center; background-size: contain; height: 150px; background-position: center; background-repeat: no-repeat;">
                <td style="text-align: center; color: white; font-family: Arial, Helvetica, sans-serif; font-size: 10px;">
                    <b>THANK YOU FOR YOUR BUSINESS!</b>
                </td>
            </tr>
        </table>
    </div>
    <!-- Footer End -->

</body>
</html>
