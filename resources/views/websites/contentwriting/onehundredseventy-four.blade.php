<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name . $invoice_number }}</title>
</head>
<body style="padding: 0px; margin: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;">
                            <img src="{{ $invoice_header_image }}" alt="" style="display: block;max-width: 100%;">
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td style="padding:0px 60px 150px 60px;background: url(img/body_bg.png) no-repeat;background-position: center;background-size: cover;height:444px;">
                            <table style="width:100%;">
                                <tr>
                                    <td>
                                        <br>
                                        <br>
                                        <div style="display: flex; justify-content: space-between; width: 100%;">
                                            <p style="font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                                <b>Date:</b>{{ $invoice_date }}<br>
                                                <b>Invoice Number:</b> #{{ $invoice_number }}
                                            </p>
                                            <p style="font-family: Arial;font-size: 28px;margin: 0px;font-weight: 700;">
                                                <b>INVOICE</b>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <table style="width: 100%;">
                                <tr>
                                    <td style="display: flex; justify-content: space-between;">
                                        <p style="font-family:  Arial;font-size: 12px;margin: 0px; font-weight: 400;">
                                            Billed From
                                        </p>
                                        <p style="font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400; min-width: 160px; text-align: end;">
                                            Billed To
                                        </p>
                                    </td>
                                    <td style="display: flex; justify-content: space-between;">
                                        <p style="font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400;">
                                            {{ $site_name }}
                                        </p>
                                        <p style="font-family:  Arial;font-size: 12px;margin: 0px;font-weight: 400; min-width: 160px; text-align: end;">
                                            {{ $customer_name ? $customer_name : '' }}<br>
                                            {{ $customer_email ? $customer_email : '' }}<br>
                                            {{ $customer_mobile ? $customer_mobile : '' }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <div style="min-height: 409px;">
                                <table style="border-collapse: collapse;">
                                    <tr style="border-collapse: collapse;height: 24px;background-color: #324AB2;">
                                        <td style="width: 100px; color: #FFFFFF; text-align: start; padding: 0px 10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>Item</b> 
                                        </td>
                                        <td style="width: 450px; color: #FFFFFF; text-align: start; padding: 0px 10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>Description</b>
                                        </td>
                                        <td style="width: 60px; color: #FFFFFF; text-align: start; padding: 0px 10px; font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>Quantity</b>
                                        </td>
                                        <td style="width: 60px; color: #FFFFFF; text-align: start; padding: 0px 10px; font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>Unit Price</b>
                                        </td>
                                        <td style="width:80px; color: #FFFFFF; text-align: end; padding: 0px 10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>Total</b>
                                        </td>
                                    </tr>
                                    @foreach($products as $product)
                                    <tr style="border-collapse: collapse;height: 24px;">
                                        <td style="width: 100px; color:#000000; text-align: start; padding: 0px 10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                            {{ $product->name ?? 'N/A' }}
                                        </td>
                                        <td style="width: 450px; color:#000000; text-align:start;padding: 0px 10px;font-family:  Arial;font-size:10px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                            {{ $product->quality }}, {{ $product->delivery }}
                                        </td>
                                        <td style="width:60px; color:#000000; text-align:start;padding:0px 10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                            1
                                        </td>
                                        <td style="width:60px; color:#000000; text-align:start;padding:0px 10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                            {{ site_currency() . number_format($product->unit_price, 2) }}
                                        </td>
                                        <td style="width:80px; color:#000000; text-align:end;padding: 0px 10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                            {{ site_currency() . number_format($product->unit_price, 2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="3">
                                        </td>
                                        <td style="width: 100px;color: #000000;text-align: start;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px; padding-left: 10px; border-bottom: 1px solid #000000;" colspan="1">
                                        <p>Subtotal</p>
                                        </td>
                                        <td style="width:100px;color: #000000;text-align:end;padding-right:10px;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse; border-bottom: 1px solid #000000;">
                                            <p>{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px; " colspan="3">
                                        </td>
                                        <td style="width: 100px;color: #000000;text-align: start;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px; padding-left: 10px; "  colspan="1">
                                        <p>
                                            Discount
                                        </p>
                                        </td>
                                        <td style="width:100px;color: #000000;text-align:end;padding-right:10px;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <p>{{ site_currency() . number_format($discount_amount, 2) }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="3">
                                        </td>
                                        <td style="width: 100px;color: #FFFFFF;text-align: start;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;  background-color: #324AB2; padding: 0px 10px;" colspan="1">
                                        <p>
                                            Grand Total
                                        </p>
                                        </td>
                                        <td style="width:100px;color: #FFFFFF;text-align:end;padding-right:10px;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400; background-color: #324AB2; border-collapse: collapse;">
                                            <p>{{ site_currency() . number_format($invoice_amount, 2) }}</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <!-- Content End-->

                    <tr>
                        <td style="padding: 0px 60px;">
                            <div style="display: flex; gap: 24px;">
                                <div style="padding: 80px 24px 24px 24px; display: flex; flex-direction: column; gap: 12px; background-image: url('{{ $invoice_image2 }}'); background-size: contain; background-repeat: no-repeat; background-position: top center; width: 100%;position: relative; bottom: -24px; background-color: white; z-index: 10;">
                                    <p style="font-family:  Arial;font-size: 10px;margin: 0px; font-weight: 400; text-align: center;">
                                        <b>Phone</b>
                                    </p>
                                    <p style="font-family:  Arial;font-size: 8px;margin: 0px; font-weight: 400; text-align: center;">
                                        {{ $company_mobile }}
                                    </p>
                                </div>
                                <div style="padding: 80px 24px 24px 24px; display: flex; flex-direction: column; gap: 12px; background-image: url('{{ $invoice_image3 }}'); background-size: contain; background-repeat: no-repeat; background-position: top center; width: 100%; position: relative; bottom: -24px; background-color: white; z-index: 10;">
                                    <p style="font-family:  Arial;font-size: 10px;margin: 0px; font-weight: 400; text-align: center;">
                                        <b>Address</b>
                                    </p>
                                    <p style="font-family:  Arial;font-size: 8px;margin: 0px; font-weight: 400; text-align: center;">
                                        {{ $company_address }}
                                    </p>
                                </div>
                                <div style="padding: 80px 24px 24px 24px; display: flex; flex-direction: column; gap: 12px; background-image: url('{{ $invoice_image1 }}'); background-size: contain; background-repeat: no-repeat; background-position: top center; width: 100%;position: relative; bottom: -24px; background-color: white; z-index: 10;">
                                    <p style="font-family:  Arial;font-size: 10px;margin: 0px; font-weight: 400; text-align: center;">
                                        <b>Email</b>
                                    </p>
                                    <p style="font-family:  Arial;font-size: 8px;margin: 0px; font-weight: 400; text-align: center;">
                                        {{ $company_email }}
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>
                     <!-- Footer -->
                     <tr>
                        <td style="background-image: url('{{ $invoice_footer_image }}'); padding: 60px; opacity: 0.7; background-size: cover; background-repeat: no-repeat;">
                        </td>
                     </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
