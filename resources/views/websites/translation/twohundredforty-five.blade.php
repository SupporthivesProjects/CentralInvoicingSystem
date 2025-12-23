<!DOCTYPE html>
<html>
<head>
    <title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body {
            margin: 0px;
            padding: 0px;
        }

        .footer-fixed {
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            width: 100%;
        }
    </style>
</head>
<body style="padding: 0px; margin: 0px;background: #e9f3fd;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center"  style="padding: 0px;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#e9f3fd" style="border-collapse: collapse; ">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px; position: relative;">
                            <img src="{{$invoice_header_image}}" alt="" style="display: block;max-width: 100%;">
                            <div style="position: absolute; top: 56px; right: 80px;">
                                <p style="color: #FFFFFF; font-family: Arial;font-size: 28px;margin: 0px;font-weight: 600;">
                                    <b>Invoice</b>
                                </p>
                                <p style="color: #FFFFFF; font-family: Arial;text-align: end; margin: 0px; font-size: 12px;margin-top:6px;font-weight: 400;">
                                    {{ $invoice_number }}<br>
                                    Date: {{ $invoice_date }}
                                </p>
                            </div>
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td style="padding:0px 80px 130px 80px;background: #e9f3fd;background-position: center;background-size: cover;height:444px;">
                            <table style="width:100%;">
                                <tr>
                                    <td>
                                        <br>
                                        <br>
                                        <div style="display: flex; justify-content: space-between; width: 100%;">
                                            <p style="line-height: 165%; width: 50%; font-family: Arial;font-size: 11px;margin: 0px;font-weight: 400;">
                                                <span style="font-size: 12px;"><b>Billed To:</b></span><br> 
                                                {{ $customer_name }}<br>
                                            </p>
                                            <p style="line-height: 165%; width: 50%; padding-left: 100px; font-family: Arial;font-size: 11px;margin: 0px;font-weight: 400;">
                                                <span style="font-size: 12px;"><b>Billed From:</b></span><br>
                                                {{ $company_name }}<br>
                                                {{ $company_address }}<br>
                                                {{ $company_email }}<br>
                                                +123 44 555 6789
                                                <br>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <br>
                            <table style="border-collapse: collapse;">
                                <tr style="border-collapse: collapse;height: 24px;background-color: #1c7cf6;">
                                    <td style="width: 250px; color: #FFFFFF; text-align: start; padding: 10px;font-family:  Arial;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                       <b>Service type</b> 
                                    </td>
                                    <td style="width: 100px; color: #FFFFFF; text-align: center; padding: 10px;font-family:  Arial;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>Pages</b>
                                    </td>
                                    <td style="width: 150px; color: #FFFFFF; text-align: center; padding: 10px; font-family:  Arial;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>Words</b>
                                    </td>
                                    <td style="width: 150px; color: #FFFFFF; text-align: end; padding: 10px; font-family:  Arial;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>Total</b>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                    <tr style="border-collapse: collapse;height: 24px;">
                                        <td style="width: 250px; color:#000000; text-align: start; padding: 10px 10px;font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                            {{ $product->name }}
                                        </td>
                                        <td style="width: 100px; color:#000000; text-align:center;padding:10px;font-family:  Arial;font-size:12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                            {{ $product->pages }}
                                        </td>
                                        <td style="width:100px; color:#000000; text-align:center;padding:10px;font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                            {{ $product->unit_type }}
                                        </td>
                                        <td style="width:100px; color:#000000; text-align:right;padding:10px;font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                            {{ site_currency() . number_format($product->line_total, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                {{-- <tr style="border-collapse: collapse;height: 24px;">
                                    <td style="width: 250px; color:#000000; text-align: start; padding: 10px 10px;font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        Certified translation
                                    </td>
                                    <td style="width: 100px; color:#000000; text-align:center;padding:10px;font-family:  Arial;font-size:12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        4
                                    </td>
                                    <td style="width:100px; color:#000000; text-align:center;padding:10px;font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        1,000
                                    </td>
                                    <td style="width:100px; color:#000000; text-align:right;padding:10px;font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        £99.80
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 24px;">
                                    <td style="width: 250px; color:#000000; text-align: start; padding: 10px 10px;font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        Certified translation
                                    </td>
                                    <td style="width: 100px; color:#000000; text-align:center;padding:10px;font-family:  Arial;font-size:12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        4
                                    </td>
                                    <td style="width:100px; color:#000000; text-align:center;padding:10px;font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        1,000
                                    </td>
                                    <td style="width:100px; color:#000000; text-align:right;padding:10px;font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        £99.80
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 24px;">
                                    <td style="width: 250px; color:#000000; text-align: start; padding: 10px 10px;font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        Certified translation
                                    </td>
                                    <td style="width: 100px; color:#000000; text-align:center;padding:10px;font-family:  Arial;font-size:12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        4
                                    </td>
                                    <td style="width:100px; color:#000000; text-align:center;padding:10px;font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        1,000
                                    </td>
                                    <td style="width:100px; color:#000000; text-align:right;padding:10px;font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        £99.80
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 24px;">
                                    <td style="width: 250px; color:#000000; text-align: start; padding: 10px 10px;font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        Certified translation
                                    </td>
                                    <td style="width: 100px; color:#000000; text-align:center;padding:10px;font-family:  Arial;font-size:12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        4
                                    </td>
                                    <td style="width:100px; color:#000000; text-align:center;padding:10px;font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        1,000
                                    </td>
                                    <td style="width:100px; color:#000000; text-align:right;padding:10px;font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        £99.80
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 24px;">
                                    <td style="width: 250px; color:#000000; text-align: start; padding: 10px 10px;font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        Certified translation
                                    </td>
                                    <td style="width: 100px; color:#000000; text-align:center;padding:10px;font-family:  Arial;font-size:12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        4
                                    </td>
                                    <td style="width:100px; color:#000000; text-align:center;padding:10px;font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        1,000
                                    </td>
                                    <td style="width:100px; color:#000000; text-align:right;padding:10px;font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        £99.80
                                    </td>
                                </tr> --}}
                                <tr>
                                    <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="2">
                                       </td>
                                    <td style="width: 100px;color: #000000;text-align: start;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400; padding-top: 50px;" colspan="1">
                                     <p>Subtotal</p>
                                    </td>
                                    <td style="width:100px;color: #000000;text-align:end;padding-right:10px;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse; padding-top: 50px;">
                                        <p>{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px; " colspan="2">
                                       </td>
                                    <td style="width: 100px;color: #000000;text-align: start;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;"  colspan="1">
                                     <p>
                                        Discount
                                    </p>
                                    </td>
                                    <td style="width:100px;color: #000000;text-align:end;padding-right:10px;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <p>{{site_currency().number_format($discount_amount??0,2) }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="2">
                                       </td>
                                    <td style="width: 100px;color: #1c7cf6;text-align: start;font-family: Arial;font-size: 14px;margin: 0px;font-weight: 400;" colspan="1">
                                     <p>
                                        <b>GRAND TOTAL</b>
                                    </p>
                                    </td>
                                    <td style="width:100px;color: #1c7cf6;text-align:end;padding-right:10px;font-family: Arial;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        <p><b>{{ site_currency() . number_format($invoice_amount, 2) }}</b></p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End-->
                     <!-- Footer -->
                     <!-- <tr>
                        <td style="background-image: url({{$invoice_footer_image}}); height: 135px; width: 100%; opacity: 1; background-size: contain; background-repeat: no-repeat;">
                        </td>
                     </tr> -->

                    <div class="footer-fixed" style="background-image: url({{$invoice_footer_image}}); height: 135px; width: 1100px; opacity: 1; background-size: contain; background-repeat: no-repeat;">
                    </div>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
