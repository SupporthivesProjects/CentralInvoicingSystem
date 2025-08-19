<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }} </title>
    <style>
        .footer-fixed {
            position: fixed;
            bottom: 0px;
            left: 0;
            right: 0;
            width: 100%;
            /* background: url('{{ $invoice_footer_image }}') center center no-repeat; */
            /* background-size: cover; */
        }
    </style>
</head>
<body style="padding: 0px; margin: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse;">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px; position: relative;">
                            <img src="{{ $invoice_header_image }}" alt="" style="display: block;max-width: 100%;">
                            <p style="font-family: Arial;font-size: 13px;margin: 0px;font-weight: 400; color: #FFFFFF; position: absolute; top: 50px; right: 40px;">Date : {{ $invoice_date }}</p>
                            <p style="font-family: Arial;font-size: 12px;margin: 0px;font-weight: 700;text-align: start; color: #e03b42; position: absolute; top: 54%; left: 50%;">Invoice Number</p>
                            <p style="font-family: Arial;font-size: 12px;margin: 0px;font-weight: 700;text-align: start; color: #FFFFFF; position: absolute; top: 60%; left: 50%;">{{ $invoice_number }}</p>
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td style="padding: 0px 0px 0px 40px;">
                            <div style="display: flex; align-items: flex-start;">
                                <div style="position: relative; top: -34px; min-height: 280px !important; ">
                                    <table style="border-collapse: collapse; background-color: #F2F2F2; border-radius: 10px 10px 0px 0px;">
                                        <tr style="border-collapse: collapse;height: 34px;background-color: #e03b42;">
                                            <td style="width: 200px; color: #FFFFFF; text-align: start; padding: 0px 16px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse; border-radius: 10px 0px 0px 0px;">
                                                <b>ITEM DESCRIPTION</b> 
                                            </td>
                                            <td style="width: 100px; color: #FFFFFF; text-align: end; padding: 0px 16px; font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                                <b>UNIT PRICE</b>
                                            </td>
                                            <td style="width: 100px; color: #FFFFFF; text-align: center; padding: 0px 16px; font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                                <b>QTY</b>
                                            </td>
                                            <td style="width:100px; color: #FFFFFF; text-align: end; padding: 0px 16px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse; border-radius: 0px 10px 0px 0px;">
                                                <b>TOTAL</b>
                                            </td>
                                        </tr>
                                        @foreach ($products as $product)
                                        <tr style="border-collapse: collapse;height: 40px;">
                                            <td style="width: 200px; color:#000000; text-align: start; padding: 0px 16px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                                <b> {{ $product->name }}</b>
                                            </td>
                                            <td style="width: 100px; color:#000000; text-align:center;padding-left:16px;font-family:  Arial;font-size:10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                                {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}
                                            </td>
                                            <td style="width:100px; color:#000000; text-align:center;padding-right:16px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                                1
                                            </td>
                                            <td style="width:100px; color:#000000; text-align:right;padding-right:16px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                                {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr style="border-top: 1px solid grey;">
                                            <td style="width: 100px;color: #000000;text-align: start;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding: 0px 16px;" colspan="1">
                                                <p><b>Subtotal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b></p>
                                            </td>
                                            <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="2">
                                            </td>
                                            <td style="width:100px;color: #000000;text-align:end;padding: 0px 16px;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                                <p><b>{{ site_currency() . number_format($invoice_amount + $discount_amount ?? 0, 2) }}</b></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 100px;color: #000000;text-align: start;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding: 0px 16px;"  colspan="1">
                                                <p></p>
                                            </td>
                                            <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px; " colspan="2">
                                            </td>
                                            <td style="width:100px;color: #000000;text-align:end;padding: 0px 16px;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                                <p></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 100px;color: #000000;text-align: start;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding: 0px 16px;"  colspan="1">
                                                <p><b>Discount&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b></p>
                                            </td>
                                            <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px; " colspan="2">
                                            </td>
                                            <td style="width:100px;color: #000000;text-align:end;padding: 0px 16px;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                                <p><b>{{ site_currency() . number_format($discount_amount ?? 0, 2) }}</b></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 100px;color: #000000;text-align: start;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding: 0px 16px;"  colspan="1">
                                                <p><b>Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b></p>
                                            </td>
                                            <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="2">
                                            </td>
                                            <td style="width:100px;color: #000000;text-align:end;padding: 0px 16px;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                                <p><b>{{ site_currency() . number_format($invoice_amount ?? 0, 2) }}</b></p>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div style="padding: 20px 60px; background-color: #e03b42; min-width: 100px;">
                                    <p style="font-family: Arial;font-size: 12px;margin: 0px;font-weight: 600;text-align: center; color: #FFFFFF;">Total Paid:</p>
                                    <p style="font-family: Arial;font-size: 26px;margin: 0px;font-weight: 500;text-align: center; color: #FFFFFF; margin-top: 10px;">{{ site_currency() . number_format($invoice_amount ?? 0, 2) }}</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <!-- Content End-->

                    <!-- from to -->
                     <tr>
                        <td style="padding: 20px 0px 60px 0px; display: flex;">
                            <div style="width: 50%; padding: 20px 20px 20px 40px; border-right: 1px solid #e03b42;">
                                <p style="font-family: Arial;font-size: 12px;margin: 0px;font-weight: 700;text-align: start; color: #000000;">Invoice To:</p>
                                <p style="font-family: Arial;font-size: 26px;margin: 0px;font-weight: 400;text-align: start; color: #000000; margin-top: 16px;">{{ $customer_name ? $customer_name : '' }}<br>
                                    {{ $customer_email ? $customer_email : '' }}<br>
                                    {{ $customer_mobile ? $customer_mobile : '' }}</p>
                            </div>
                            <div style="width: 50%; padding: 20px 40px 20px 20px;">
                                <p style="font-family: Arial;font-size: 12px;margin: 0px;font-weight: 700;text-align: start; color: #000000;">Invoice From:</p>
                                <p style="font-family: Arial;font-size: 26px;margin: 0px;font-weight: 400;text-align: start; color: #000000; margin-top: 16px;"> {{ $site_name }}</p>
                            </div>
                        </td>
                     </tr>
                    <!-- from to -->

                     <!-- Footer -->
                     <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" class="footer-fixed">
                                <tr>
                                <td style="background: linear-gradient(to right, #e03b42 35%, #202020 35%); padding: 60px 40px 60px 40px; display: flex; justify-content: space-between;">
                            <p style="font-family: Arial;font-size: 22px;margin: 0px;font-weight: 400; color: #FFFFFF;">Thank You for<br>Purchasing!</p>
                            <p style="font-family: Arial;font-size: 9px;margin: 0px;font-weight: 400; color: #FFFFFF; text-align: end; line-height: 15px;"><span style="color: #e03b42; font-size: 14px;">Contact</span><br>
                                {{ $company_name }}<br>
                                {{ $company_email }}<br>
                                {!! $company_address !!}<br>
                                {{ $company_mobile }}<br>
                                www.bizzspace.co                                
                            </p>
                        </td>
    </tr>

                            </table>
                        </td>
                       
                     </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
