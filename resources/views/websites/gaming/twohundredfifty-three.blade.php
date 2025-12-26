<!DOCTYPE html>
<html>

<head>
    <title>Your Email Title</title>
</head>
<style>
    table tr:nth-last-child(4) {
        border-bottom: 1px solid #FFFFFF;
    }
</style>

<body style="padding: 0px; margin: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr style="width:100%;">
            <td align="center" style="padding: 0px;" style="width:100%;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; " >

                    <!-- Content -->
                    <tr style="width:100%;">
                        <!-- <td style="padding: 95px 120px 170px 40px;background: url({{ $invoice_image1 }});background-position: center;background-size: cover;height:444px;" style="width:100%;"> -->
                        <td style="padding: 95px 120px 170px 40px;background: url({{ $invoice_image1 }});background-position: center;background-size: cover;" style="width:100%;">

                            <table style="width:100%;">
                                <tr>
                                    <td>
                                        <p
                                            style="line-height: 165%; font-family: Arial;font-size: 48px;margin: 0px;font-weight: 400; color: #FFFFFF;">
                                            INVOICE
                                        </p>
                                        <br>
                                        <div style="display: flex; justify-content: space-between; width: 100%;">
                                            <p
                                                style="line-height: 165%; width: 50%; font-family: Arial;font-size: 11px;margin: 0px;font-weight: 400; color: #FFFFFF;">
                                                Invoice To :<br>
                                                <span style="font-size: 14px;"><b>{{ $customer_name }}</b></span>
                                            </p>
                                            <p
                                                style="line-height: 165%; width: 50%; padding-left: 100px; font-family: Arial;font-size: 11px;margin: 0px;font-weight: 400; color: #FFFFFF;">
                                                <span style="color: #ec4185;"><b>Invoice No.</b></span><br>
                                                {{ $invoice_number }}<br>
                                                <span style="color: #ec4185; margin-top: 16px;"><b>Invoice Date</b></span><br>
                                                {{ $invoice_date }}<br>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <br>
                            <!-- <div style="height: 500px; padding-left: 20px;"> -->
                            <div style=" padding-left: 20px;">

                                <table style="border-collapse: collapse;">
                                    <tr style="border-collapse: collapse;height: 24px;">
                                        <td
                                            style="width: 250px; color: #FFFFFF; text-align: start; padding: 20px 10px;font-family:  Arial;font-size: 14px;margin: 0px;font-weight: 400;border-bottom: 1px solid #FFFFFF;border-collapse: collapse;">
                                            <b>DESCRIPTION</b>
                                        </td>
                                        <td
                                            style="width: 100px; color: #FFFFFF; text-align: center; padding: 20px 10px;font-family:  Arial;font-size: 14px;margin: 0px;font-weight: 400;border-bottom: 1px solid #FFFFFF;border-collapse: collapse;">
                                            <b>UNIT&nbsp;PRICE</b>
                                        </td>
                                        <td
                                            style="width: 150px; color: #FFFFFF; text-align: center; padding: 20px 10px; font-family:  Arial;font-size: 14px;margin: 0px;font-weight: 400;border-bottom: 1px solid #FFFFFF;border-collapse: collapse;">
                                            <b>QTY</b>
                                        </td>
                                        <td
                                            style="width: 150px; color: #FFFFFF; text-align: end; padding: 20px 10px; font-family:  Arial;font-size: 14px;margin: 0px;font-weight: 400;border-bottom: 1px solid #FFFFFF;border-collapse: collapse;">
                                            <b>TOTAL</b>
                                        </td>
                                    </tr>
                                    @foreach ($products as $product)
                                        <tr style="border-collapse: collapse;height: 24px;">
                                            <td
                                                style="width: 250px; color:#FFFFFF; text-align: start; padding: 16px 10px;font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                                <b> {{ $product['name'] }}</b>
                                            </td>
                                            <td
                                                style="width: 100px; color:#FFFFFF; text-align:center;padding:16px 10px;font-family:  Arial;font-size:12px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                                {{ site_currency() . number_format($product['unit_price'], 2) }}
                                            </td>
                                            <td
                                                style="width:100px; color:#FFFFFF; text-align:center;padding:16px 10px;font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                                1
                                            </td>
                                            <td
                                                style="width:100px; color:#FFFFFF; text-align:right;padding:16px 10px;font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                                {{ site_currency() . number_format($product['unit_price'], 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td style="    text-align: start; font-family: Arial; font-size: 10px; margin: 0px; font-weight: 400; padding-left: 40px; color: #FFFFFF; font-style: italic; padding-top: 50px;"
                                            colspan="2">
                                            {{ $site_name }}<br>
                                            {{ $company_address }}<br>
                                        </td>
                                        <td style="width: 100px;color: #FFFFFF;text-align: start;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400; padding-top: 40px;padding: 0px 10px;"
                                            colspan="1">
                                            <p>SUBTOTAL</p>
                                        </td>
                                        <td
                                            style="width:100px;color: #FFFFFF;text-align:end;padding-right:10px;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400; padding: 0px 10px;border-collapse: collapse; padding-top: 40px;">
                                            <p>{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px; "
                                            colspan="2">
                                        </td>
                                        <td style="width: 100px;color: #FFFFFF;text-align: start;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400; padding: 0px 10px;"
                                            colspan="1">
                                            <p>
                                                DISCOUNT
                                            </p>
                                        </td>
                                        <td
                                            style="width:100px;color: #FFFFFF;text-align:end;padding-right:10px;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400; padding: 0px 10px;border-collapse: collapse;">
                                            <p>{{ site_currency() . number_format($discount_amount, 2) }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;"
                                            colspan="2">
                                        </td>
                                        <td style="width: 100px;color: #FFFFFF;text-align: start;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400; padding: 0px 10px; background-color: #ec4185;"
                                            colspan="1">
                                            <p>
                                                TOTAL
                                            </p>
                                        </td>
                                        <td
                                            style="width:100px;color: #FFFFFF;text-align:end;padding-right:10px;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400; padding: 0px 10px; background-color: #ec4185;border-collapse: collapse;">
                                            <p>{{ site_currency() . number_format($invoice_amount, 2) }}</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </td>
                    </tr>
                    <!-- Content End-->
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
