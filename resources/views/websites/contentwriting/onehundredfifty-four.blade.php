<!DOCTYPE html>
<html>

<head>
    <title>Your Email Title</title>
</head>

<body>
    <table width="100%" style="border-collapse: collapse;" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#ffffff" style="padding: 20px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse;">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;max-height: 130px;">
                            <table>
                                <tr>
                                    <td style="padding: 40px;padding-bottom: 0px;">
                                        <p style="font-family: arial;font-size:28px;margin: 0px;font-weight: 400;">
                                            <b style="color: #6949E2;">INVOICE</b>
                                        </p>
                                    </td>
                                    <td style="width:300px; padding: 40px;padding-bottom: 0px; text-align: right;">
                                        <img src="{{ $company_logo }}" alt="" style=" height:70px;">
                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                    <!-- Content -->
                    <tr>
                        <td style="padding:40px;padding-top:0px;">
                            <table style="border-collapse: collapse;">
                                <tr style="border-collapse: collapse;">
                                    <td
                                        style="width: 200px;text-align: left;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b style="color: #5E5E5E;">INVOICE NUMBER</b>
                                    </td>
                                    <td
                                        style="width: 200px;text-align: left;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b style="color: #5E5E5E;">INVOICE DATE</b>
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;">
                                    <td
                                        style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        {{ $invoice_number }}
                                    </td>
                                    <td
                                        style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        {{ $invoice_date }}
                                    </td>
                                </tr>
                            </table>
                            <table style="border-collapse: collapse;">
                                <tr style="border-collapse: collapse;">
                                    <td
                                        style="width: 200px;text-align: left;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b style="color: #5E5E5E;">BILLED TO</b>
                                    </td>
                                    <td
                                        style="width: 200px;text-align: left;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b style="color: #5E5E5E;">BILLED FROM</b>
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;">
                                    <td style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        {!! $customer_name ? $customer_name.'<br>' : '' !!}
                                        {!! $customer_email ? $customer_email.'<br>' : '' !!}
                                        {!! $company_address ? $company_address.'<br>' : '' !!}
                                    </td>

                                    <td style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        {!! $customer_mobile ? $customer_mobile.'<br>' : '' !!}
                                        {!! $site->site_link ? $site->site_link.'<br>' : '' !!}
                                        {!! $company_mobile ? $company_mobile.'<br>' : '' !!}
                                    </td>
                                </tr>

                                <!-- <tr style="border-collapse: collapse;">
                                    <td
                                        style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        {{ $customer_name }}
                                        {{ $customer_email }}
                                        {{ $company_address }}
                                    </td>
                                    <td
                                        style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        {{ $customer_mobile }}
                                        {{ $site->site_link }}
                                        {{ $company_mobile }}
                                    </td>
                                </tr> -->
                            </table>
                            <br>
                            <br>
                            <div style="min-height: 650px !important;">
                            <table style="border-collapse: collapse;">
                                <tr style="border-collapse: collapse;height: 24px;">
                                    <td
                                        style="width: 250px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>SERVICE</b>
                                    </td>
                                    <td
                                        style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>IMAGES</b>
                                    </td>
                                    <td
                                        style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>WORDS</b>
                                    </td>
                                    <td
                                        style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>AMOUNT</b>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr style="border-collapse: collapse;height: 24px;">
                                    <td
                                        style="width: 250px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #6949E2;">
                                        {{ $product->name }}
                                    </td>
                                    <td
                                        style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #6949E2;">
                                        {{ $product->imagecount }}
                                    </td>
                                    <td
                                        style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #6949E2;">
                                        {{ $product->wordcount }}
                                    </td>
                                    <td
                                        style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #6949E2;">
                                       {{ site_currency() }} {{ number_format($product->unit_price, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;"
                                        colspan="3">
                                        <p style="color: #5E5E5E;"><b>
                                                SUBTOTAL
                                            </b></p>
                                    </td>
                                    <td style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #6949E2"
                                        colspan="3">
                                        <p>{{ site_currency() }} {{  number_format(($invoice_amount + $discount_amount), 2) }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;padding-right: 10px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;"
                                        colspan="3">
                                        <p style="color: #5E5E5E;"><b>DISCOUNT</b></p>
                                    </td>
                                    <td
                                        style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #6949E2"colspan="3">
                                        <p> -{{ site_currency() }} {{ number_format($discount_amount, 2) }}</p>
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 24px;padding-bottom: 10px;">
                                    <td
                                        style="width: 250px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b style="color: #5E5E5E;">Notes</b>
                                    </td>
                                    <td
                                        style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b> INVOICE TOTAL</b>
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 24px;padding-bottom: 10px;">
                                    <td
                                        style="width: 250px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        {{ $product->note ?? 'No notes provided' }}
                                    </td>
                                    <td
                                        style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width: 100px;text-align: right;font-family: arial;font-size: 24px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #6949E2;">
                                        <b> {{ site_currency() }} {{ number_format($invoice_amount, 2) }}</b>
                                    </td>
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
                                    style="background: url({{ $invoice_footer_image }}) no-repeat;background-position: center;background-size: cover;height:61px;padding:50px;background-size:cover;width: 100%;">
                                    <td style="text-align:center;">
                                        <p
                                            style="text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight:700;color:whitesmoke;">

                                        </p>
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
