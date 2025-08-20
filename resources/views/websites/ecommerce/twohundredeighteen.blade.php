<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>

<body style="padding: 0px; margin: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="650" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;">
                            <img src="{{ $invoice_header_image }}" alt=""
                                style="display: block;max-width: 100%;">
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td
                            style="padding:0px 60px 60px 60px;background: url('{{ $invoice_image1 }}') no-repeat;background-position: center;background-size: 101%;height:444px;">
                            <table style="width:100%;">
                                <tr>
                                    <td>
                                        <br>
                                        <br>
                                        <div
                                            style="display: flex; justify-content: center; width: 100%; margin-bottom: 20px;">
                                            <p style="font-family: Arial;font-size: 32px;margin: 0px;font-weight: 700;">
                                                <b>INVOICE</b>
                                                <br>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="display: flex; justify-content: space-between;">
                                        <br>
                                        <br>
                                        <div style="width: 100%;">
                                            <p style="font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                                <b>Date:</b><br>
                                                {{ $invoice_date }}<br><br>
                                                <b>ORDER NUMBER #</b><br> {{ $invoice_number }}
                                            </p>
                                        </div>
                                        <div style="width: 100%;">
                                            <p
                                                style="font-family: Arial;text-align: end; font-size: 10px;margin: 0px;font-weight: 400;">
                                                <b>To:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
                                                {{ $customer_name }}<br>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <table style="border-collapse: collapse;" class="table-stripped">
                                <tr style="border-collapse: collapse;height: 24px;background-color: #262626;">
                                    <td
                                        style="width: 400px; color: #c8aa84; text-align: start; padding: 0px 10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>PRODUCT NAME</b>
                                    </td>
                                    {{-- <td
                                        style="width: 120px; color: #c8aa84; text-align: center; padding: 0px 10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>DELIVERY</b>
                                    </td> --}}
                                    <td
                                        style="width: 100px; color: #c8aa84; text-align: center; padding: 0px 10px; font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>QTY</b>
                                    </td>
                                    <td
                                        style="width: 80px; color: #c8aa84; text-align: end; padding: 0px 10px; font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>UNIT PRICE</b>
                                    </td>
                                    <td
                                        style="width:100px; color: #c8aa84; text-align: end; padding: 0px 10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>LINE TOTAL</b>
                                    </td>
                                </tr>
                                @foreach ($products as $product)
                                    <tr style="border-collapse: collapse;height: 24px; background-color: #F4F4F4;">
                                        <td
                                            style="width: 400px; color:#000000; text-align: start; line-height: 16px; padding: 8px;font-family:  Arial;font-size: 9px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            {{ $product->name }}<br>
                                            {{-- <span style="color: grey;">Text & Illustrations</span> --}}
                                        </td>
                                        {{-- <td
                                            style="width: 120px; color:#000000; text-align:center;padding-left:10px;font-family:  Arial;font-size:9px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            Urgent (+$35)
                                        </td> --}}
                                        <td
                                            style="width:100px; color:#000000; text-align:center;padding-right:10px;font-family:  Arial;font-size: 9px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            1
                                        </td>
                                        <td
                                            style="width:80px; color:#000000; text-align:right;padding-right:10px;font-family:  Arial;font-size: 9px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            {{ site_currency() . number_format($product->unit_price, 2)}}
                                        </td>
                                        <td
                                            style="width:100px; color:#000000; text-align:right;padding-right:10px;font-family:  Arial;font-size: 9px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            {{ site_currency() .number_format(($product->unit_price), 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;"
                                        colspan="3">
                                    </td>
                                    <td style="width: 100px;color: #000000;text-align: start;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px; padding-left: 10px; background-color: #FFFFFF;"
                                        colspan="1">
                                        <p>SUBTOTAL</p>
                                    </td>
                                    <td
                                        style="width:100px;color: #000000;text-align:end;padding-right:10px;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse; background-color: #FFFFFF;">
                                        <p>{{ site_currency() .number_format(($invoice_amount + $discount_amount), 2) }}</p>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px; "
                                        colspan="3">
                                    </td>
                                    <td style="width: 100px;color: #000000;text-align: start;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px; padding-left: 10px; background-color: #F4F4F4;"
                                        colspan="1">
                                        <p>
                                            DISCOUNT
                                        </p>
                                    </td>
                                    <td
                                        style="width:100px;color: #000000;text-align:end;padding-right:10px;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse; background-color: #F4F4F4;">
                                        <p>{{ site_currency() .number_format(($discount_amount), 2) }}</p>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;"
                                        colspan="3">
                                    </td>
                                    <td style="width: 100px;color: #000000;text-align: start;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400; padding-right: 10px; padding-left: 10px; background-color: #FFFFFF;"
                                        colspan="1">
                                        <p>
                                            <b>TOTAL</b>
                                        </p>
                                    </td>
                                    <td
                                        style="width:100px;color: #c8aa84;text-align:end;padding-right:10px;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse; background-color: #FFFFFF;">
                                        <p><b>{{ site_currency() .number_format(($invoice_amount), 2) }}</b></p>
                                    </td>
                                </tr>
                            </table>
                            <table style="width: 100%; padding-top: 100px;">
                                <tr>
                                    <td
                                        style="width: 120px; color:#000000; text-align:center;padding-left:10px;font-family:  Arial;font-size:9px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        SUPPORT@CALLIGRAPHII.COM | +11 123 4567 890
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="width: 120px; padding-top: 16px; color:#000000; text-align:center;padding-left:10px;font-family:  Arial;font-size:9px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        PLACEHOLDER COMPANY NAME LLCOFFICE NO. XX, PLACEHOLDER STREET – PLACEHOLDER
                                        CITY
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End-->

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background-image: url({{ $invoice_footer_image }}); padding: 48px; background-size: 100% 100%; background-position: center; background-repeat: no-repeat;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
