<!DOCTYPE html>
<html>
<head>
    <title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); background: url('{{ $invoice_image1 }}') no-repeat;background-position: center;background-size: 100% 100%;">
                    <!-- Header -->
                    <tr>
                        
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr style=" display: flex;
                    flex-direction: column;">
                        <td style="padding: 0px;">
                            <table>
                                <tr>
                                    <td style="padding-left: 40px; width: 300px;">
                                        <img src="{{ $company_logo }}" alt="" style="display: block; padding: 48px 0px 0px 0px;height:44px;">
                                    </td>
                                    <td style="width:300px; text-align: -webkit-right; padding-top: 70px; padding-right: 48px;">
                                        <h2 style="font-family: Arial; font-size: 24px; margin: 0px; color: blue;">INVOICE</h2>
                                        <br>
                                        <p style="font-family: Arial;font-size: 13px;margin: 0px;font-weight: 400;">
                                            Invoice: #{{ $invoice_number }}<br>
                                            Date: {{ $invoice_date }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="padding:0px 65px 250px 65px;height:444px;">
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <table style="width: 100%;">
                                <tr>
                                    <td style="display: flex; justify-content: space-between;">
                                        <p style="font-family:  Arial;font-size: 11px;margin: 0px; font-weight: 400; color: blue;">
                                            <b>BILLED FROM:</b>
                                        </p>
                                        <p style="font-family:  Arial;font-size: 11px;margin: 0px;font-weight: 400; min-width: 160px; text-align: end; color: blue;">
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
                            <br>
                            <div style="min-height: 550px !important;">
                                <table style="border-collapse: collapse;">
                                    <tr style="border-collapse: collapse;height: 24px;">
                                        <td style="width: 100px; color: blue; text-align: center; padding: 0px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse; border: 1px solid #000000;">
                                        <b>ITEM NO.</b> 
                                        </td>
                                        <td style="width: 250px; color: blue; text-align: center; padding: 0px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse; border: 1px solid #000000;">
                                            <b>DESCRIPTION</b>
                                        </td>
                                        <td style="width: 150px; color: blue; text-align: center; padding: 0px; font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse; border: 1px solid #000000;">
                                            <b>QUANTITY</b>
                                        </td>
                                        <td style="width:100px; color: blue; text-align: center; padding: 0px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse; border: 1px solid #000000;">
                                            <b>TOTAL</b>
                                        </td>
                                    </tr>
                                    @foreach($products as $index => $product)
                                    <tr style="border-collapse: collapse;height: 24px;">
                                        <td style="width: 100px; color:#000000; text-align: center; padding: 0px 10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid #000000;border-collapse: collapse;">
                                            {{ $index + 1 }}
                                        </td>
                                        <td style="width: 250px; color:#000000; text-align:center; padding: 0px 10px;font-family:  Arial;font-size:10px;margin: 0px;font-weight: 400;border: 1px solid #000000;border-collapse: collapse;">
                                            {{ $product['name'] }}<br>
                                            @if (isset($product['platform_fields']) && isset($product['selected_platform']))
                                                <div style="margin-top:4px;">
                                                    <em style="font-size:9px;">{{ $product['selected_platform'] }}:</em><br>
                                                    @foreach($product['platform_fields'][$product['selected_platform']] as $fieldName => $value)
                                                        <span style="font-size:9px; margin-left:8px;">
                                                            {{ ucfirst(str_replace('_',' ',$fieldName)) }}: {{ $value }}
                                                        </span><br>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <br>
                                            {{ $product['game_currency_amount'] }} {{ $product['game_currency'] }}
                                        </td>
                                        <td style="width:100px; color:#000000; text-align:center;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid #000000;border-collapse: collapse;">
                                            1
                                        </td>
                                        <td style="width:100px; color:#000000; text-align:center;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid #000000;border-collapse: collapse;">
                                            {{ $currency . number_format($product['unit_price'], 2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="2">
                                        </td>
                                        <td style="width: 100px;color: #000000;text-align: center;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;padding-right: 10px; padding-left: 24px;" colspan="1">
                                        <p style="margin: 8px 0px;">SUBTOTAL</p>
                                        </td>
                                        <td style="width:100px;color: #000000;text-align:end;padding-right:10px;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;border: 1px solid #000000;">
                                            <p style="margin: 8px 0px;"><b> {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</b></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="2">
                                        </td>
                                        <td style="width: 100px;color: #000000;text-align: center;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;padding-right: 10px; padding-left: 24px;"  colspan="1">
                                        <p style="margin: 8px 0px;">
                                            DISCOUNT
                                        </p>
                                        </td>
                                        <td style="width:100px;color: #000000;text-align:end;padding-right:10px;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;border: 1px solid #000000;">
                                            <p style="margin: 8px 0px;">{{ site_currency() . number_format($discount_amount, 2) }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="2">
                                        </td>
                                        <td style="width: 100px;color: #000000;text-align: center;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;padding-right: 10px; padding-left: 24px;"  colspan="1">
                                        <p style="margin: 8px 0px;">
                                            <b>TOTAL DUE</b>
                                        </p>
                                        </td>
                                        <td style="width:100px;color: #000000;text-align:end;padding-right:10px;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;border: 1px solid #000000;">
                                            <p style="margin: 8px 0px;">{{ site_currency() . number_format($invoice_amount, 2) }}</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <!-- Content End-->
                     <!-- Footer -->
                     <tr>
                        <td style="padding: 28px; background-size: cover; background-repeat: no-repeat;">
                            <div style="display: flex; gap: 20px; align-items: center; justify-content: space-between;">
                            <p style="font-family: Arial;font-size: 10px;">
                                {{ $company_name }}<br>
                                {!! $company_address !!}
                            </p>
                            <p style="font-size: 10px; margin: 0px; color: blue; opacity: 0.6; font-family: Arial;"><b>WE APPRECIATE YOU CHOOSING US</b></p>
                        </div>
                        </td>
                     </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
