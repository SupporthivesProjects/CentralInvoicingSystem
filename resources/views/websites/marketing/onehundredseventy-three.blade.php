<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name . $invoice_number }} </title>
</head>
<body style="padding: 0px; margin: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" >
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
                        <td style="padding:0px 60px 80px 60px;background: url('{{ $invoice_image1 }}') no-repeat;background-position: center;background-size: cover;height:444px;">
                            <table style="width:100%;">
                                <tr>
                                    <td>
                                        <br>
                                        <br>
                                        <div style="display: flex; justify-content: space-between; width: 100%;">
                                            <div style="display: flex; flex-direction: column; gap: 6px;">
                                                <p style="font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                                    <b>Date:</b> {{ $invoice_date }}
                                                </p>
                                                <p style="font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                                    <b>Invoice Number:</b> {{ $invoice_number }}
                                                </p>
                                            </div>
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
                                        <p style="font-family:  Arial;font-size: 10px;margin: 0px; font-weight: 400;">
                                            <b>Billed From</b>
                                        </p>
                                        <p style="font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400; min-width: 160px; text-align: end;">
                                            <b>Billed To</b>
                                        </p>
                                    </td>
                                    <td style="display: flex; justify-content: space-between;">
                                        <p style="font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            {{ $site_name }}
                                        </p>
                                        <p style="font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400; min-width: 160px; text-align: end;">
                                            {{ $customer_name ? $customer_name : '' }}<br>
                                            {{ $customer_email ? $customer_email : '' }}<br>
                                            {{ $customer_mobile ? $customer_mobile : '' }}
                                        </p>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>
                                        <br>
                                        <p style="font-family:  Arial;font-size: 10px;margin: 0px; font-weight: 400; margin-bottom: 5px;">
                                            <b>Email:</b>  {{ $company_email }}
                                        </p>
                                        <p style="font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400; margin-bottom: 5px;">
                                            <b>Website:</b> www.brandcreationz.com
                                        </p>
                                        <p style="font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400; margin-bottom: 5px;">
                                            <b>Phone:</b>  {{ $company_mobile }}
                                        </p>
                                        <p style="font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400; margin-bottom: 5px;">
                                            <b>Address:</b>  {{ $company_address }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <div style="min-height: 442px;">
                                <table style="border-collapse: collapse;">
                                    <tr style="border-collapse: collapse;height: 24px;background-color: #f29aa6;">
                                        <td style="width: 100px; color: #000000; text-align: start; padding: 0px 10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>Item</b> 
                                        </td>
                                        <td style="width: 250px; color: #000000; text-align: start; padding: 0px 10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>Description</b>
                                        </td>
                                        <td style="width: 150px; color: #000000; text-align: start; padding: 0px 10px; font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>Quantity</b>
                                        </td>
                                        <td style="width: 150px; color: #000000; text-align: start; padding: 0px 10px; font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>Unit Price</b>
                                        </td>
                                        <td style="width:100px; color: #000000; text-align: end; padding: 0px 10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>Total</b>
                                        </td>
                                    </tr>
                                    @foreach ($products as $product)
                                    <tr style="border-collapse: collapse;height: 24px;">
                                        <td style="width: 100px; color:#000000; text-align: start; padding: 0px 10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                            {{ $product->name }}
                                        </td>
                                        <td style="width: 250px; color:#000000; text-align:start;padding:0px 10px;font-family:  Arial;font-size:10px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                            {{ $product->subscription }}
                                        </td>
                                        <td style="width:100px; color:#000000; text-align:start;padding: 0px 10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                            1
                                        </td>
                                        <td style="width:100px; color:#000000; text-align:start;padding: 0px 10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                            {{ site_currency() . ' ' . number_format($product->unit_price ?? 0, 2) }}
                                        </td>
                                        <td style="width:100px; color:#000000; text-align:end;padding:0px 10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                            {{ site_currency() . ' ' . number_format($product->unit_price ?? 0, 2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="3">
                                        </td>
                                        <td style="width: 100px;color: #000000;text-align: start;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px; padding-left: 10px; border-bottom: 1px solid #000000;" colspan="1">
                                        <p>SUBTOTAL</p>
                                        </td>
                                        <td style="width:100px;color: #000000;text-align:end;padding-right:10px;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse; border-bottom: 1px solid #000000;">
                                            <p>{{ site_currency() . ' ' . number_format($invoice_amount + $discount_amount ?? 0, 2) }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px; " colspan="3">
                                        </td>
                                        <td style="width: 100px;color: #000000;text-align: start;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px; padding-left: 10px; "  colspan="1">
                                        <p>
                                            DISCOUNT
                                        </p>
                                        </td>
                                        <td style="width:100px;color: #000000;text-align:end;padding-right:10px;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <p>{{ site_currency() . ' ' . number_format($discount_amount ?? 0, 2) }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="3">
                                        </td>
                                        <td style="width: 100px;color: #000000;text-align: start;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;  background-color: #f29aa6; padding-right: 10px; padding-left: 24px;" colspan="1">
                                        <p>
                                            <b>GRAND TOTAL</b>
                                        </p>
                                        </td>
                                        <td style="width:100px;color: #000000;text-align:end;padding-right:10px;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400; background-color: #f29aa6; border-collapse: collapse;">
                                            <p> {{ site_currency() . ' ' . number_format($invoice_amount ?? 0, 2) }}</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <!-- Content End-->

                     <!-- Footer -->
                     <tr>
                        <td style="background-image: url('{{ $invoice_footer_image }}'); padding: 100px 0px; background-size: 100% 100%; background-repeat: no-repeat;">
                        </td>
                     </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>