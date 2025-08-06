<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<body style="margin: 0px; padding: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        
                    </tr>
                    
                    <tr style="background: url('{{ $invoice_image1 }}') no-repeat;background-position: center;background-size: cover; display: flex;flex-direction: column;">
                        <td style="padding: 0px; width: 100%;">
                            <table style="width: 100%;">
                                <tr style="width: 100%;">
                                    <td style="padding-left: 60px; width: 100%;">
                                        <img src="{{ $company_logo }}" alt="" style="display: block; padding: 48px 0px 0px 0px;height:80px;">
                                    </td>
                                    <td style="width:300px; text-align: -webkit-right; padding-top: 60px; padding-right: 60px;">
                                        <h2 style="font-family: Arial; font-size: 24px; margin: 0px;">INVOICE</h2>
                                        <br>
                                        <p style="font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;">
                                            Invoice No: {{ $invoice_number }}<br>
                                            Date: {{ $invoice_date }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="padding:0px 60px 100px 60px;">
                            <br>
                            <br>
                            <table style="width: 100%;">
                                <tr style="width: 100%;">
                                    <td style="display: flex; justify-content: space-between;">
                                        <p style="font-family:  Arial;font-size: 11px;margin: 0px; font-weight: 400;">
                                            <b>BILLED FROM:</b>
                                        </p>
                                        <p style="font-family:  Arial;font-size: 11px;margin: 0px;font-weight: 400; min-width: 160px; text-align: end;">
                                            <b>BILLED TO:</b>
                                        </p>
                                    </td>
                                    <td style="display: flex; justify-content: space-between;">
                                        <p style="font-family:  Arial;font-size: 9px;margin: 0px;font-weight: 400;">
                                            {{ $site_name }}<br>
                                            Website: {{ $site->site_link }}
                                        </p>
                                        <p style="font-family:  Arial;font-size: 9px;margin: 0px;font-weight: 400; min-width: 160px; text-align: end;">
                                            {{ $customer_name }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <div style="min-height: 628px !important; width: 100%">
                                <table style="border-collapse: collapse; width: 100%;">
                                    <tr style="border-collapse: collapse;height: 24px; width: 100%">
                                        <td style="width: 100px; color: #000000; text-align: center; padding: 0px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse; border: 1px solid #000000;">
                                        <b>QUANTITY</b> 
                                        </td>
                                        <td style="width: 400px; color: #000000; text-align: center; padding: 0px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse; border: 1px solid #000000;">
                                            <b>DESCRIPTION</b>
                                        </td>
                                        <td style="width: 100px; color: #000000; text-align: center; padding: 0px; font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse; border: 1px solid #000000;">
                                            <b>UNIT PRICE</b>
                                        </td>
                                        <td style="width: 100px; color: #000000; text-align: center; padding: 0px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse; border: 1px solid #000000;">
                                            <b>TOTAL</b>
                                        </td>
                                    </tr>
                                    @foreach($products as $product)
                                    <tr style="border-collapse: collapse;height: 24px;">
                                        <td style="width: 100px; color:#000000; text-align: center; padding: 0px 10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid #000000;border-collapse: collapse;">
                                        1
                                        </td>
                                        <td style="width: 400px; color:#000000; text-align:start; padding: 0px 10px;font-family:  Arial;font-size:10px;margin: 0px;font-weight: 400;border: 1px solid #000000;border-collapse: collapse;">
                                            {{ $product->name }}
                                        </td>
                                        <td style="width: 100px; color:#000000; text-align:center;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid #000000;border-collapse: collapse;">
                                        {{ site_currency() }} {{  number_format($product->unit_price, 2) }}
                                        </td>
                                        <td style="width: 100px; color:#000000; text-align:center;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid #000000;border-collapse: collapse;">
                                        {{ site_currency() }} {{  number_format($product->unit_price, 2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="2">
                                        </td>
                                        <td style="width: 100px;color: #000000;text-align: center;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;padding-right: 10px; padding-left: 24px;" colspan="1">
                                        <p><b>SUBTOTAL</b></p>
                                        </td>
                                        <td style="width:100px;color: #000000;text-align:end;padding-right:10px;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;border: 1px solid #000000;">
                                            <p><b>{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</b></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="2">
                                        </td>
                                        <td style="width: 100px;color: #000000;text-align: center;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;padding-right: 10px; padding-left: 24px;"  colspan="1">
                                        <p>
                                            DISCOUNT
                                        </p>
                                        </td>
                                        <td style="width:100px;color: #000000;text-align:end;padding-right:10px;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;border: 1px solid #000000;">
                                            <p>{{ site_currency() }} {{ number_format( $discount_amount, 2) }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="2">
                                        </td>
                                        <td style="width: 100px;color: #000000;text-align: center;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;padding-right: 10px; padding-left: 24px;"  colspan="1">
                                        <p>
                                            TOTAL DUE
                                        </p>
                                        </td>
                                        <td style="width:100px;color: #000000;text-align:end;padding-right:10px;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;border: 1px solid #000000;">
                                            <p>{{ site_currency() }} {{ number_format($invoice_amount, 2) }}</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <!-- Content End-->
                     <!-- Footer -->
                     <tr>
                        <td style="background-image: url('{{ $invoice_footer_image }}'); padding: 60px; background-size: cover; background-repeat: no-repeat;">
                            <div style="display: flex; gap: 20px; align-items: center; justify-content: center;">
                            <p style="font-size: 10px; margin: 0px; color: #FFFFFF; font-family: Arial;">THANK YOU FOR SHOPPING WITH US</p>
                        </div>
                        </td>
                     </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
