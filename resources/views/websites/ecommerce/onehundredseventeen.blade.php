<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<body style="margin: 0px; padding: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); background: url('{{ $invoice_image2 }}') no-repeat;background-position: left bottom;background-size: 45%; background-color: #FFFFFF;">
                    <!-- Content -->
                    <tr style="display: flex; flex-direction: column;">
                        <td style="padding: 0px;">
                            <table>
                                <tr>
                                    <td style="width:300px; padding-top: 40px; padding-left: 24px;">
                                        <h2 style="font-family: Arial; font-size: 36px; margin: 0px; border-bottom: 1px solid #000000; max-width: 180px;">INVOICE</h2>
                                        <br>
                                        <p style="font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;">
                                            <span style="color: grey;">INVOICE NO:</span> {{ $invoice_number }}<br>
                                            <span style="color: grey;">INVOICE DATE:</span> {{ $invoice_date }}
                                        </p>
                                    </td>
                                    <td style="padding-right: 24px; width: 350px; display: flex; justify-content: flex-end;">
                                        <img src="{{ $company_logo  }}" alt="" style="display: block; padding: 40px 0px 0px 0px;height:52px;">
                                    </td>
                                </tr>
                            </table>
                            <br>
                        </td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; padding: 10px 0px; margin: 0px 24px;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="display: flex; justify-content: flex-end; gap: 20px; padding-right: 32px;">
                                        <div style="display: flex; gap: 10px; align-items: center;">
                                            <img style="height: 32px;" src="{{ $invoice_image4 }}">
                                            <p style="margin: 0px; font-family: Arial; font-size: 10px;">{{ $company_email  }}</p>
                                        </div>
                                        <div style="display: flex; gap: 10px; align-items: center;">
                                            <img style="height: 32px;" src="{{ $invoice_image5 }}">
                                            <p style="margin: 0px; font-family: Arial; font-size: 10px;">{!! $company_address !!}</p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="display: flex; height: 80vh;">
                        <td style="padding:0px 40px 60px 24px;height:650px;">
                            <br>
                            <br>
                            <br>
                            <div style="min-height: 650px !important;">
                                <table style="border-collapse: collapse;">

                                    <tr style="border-collapse: collapse;height: 24px;">
                                        <td style="width: 300px; color: #000000; text-align: start; padding: 12px 0px 12px 12px;font-family:  Arial;font-size: 13px;margin: 0px;font-weight: 400;border-collapse: collapse; border-top: 3px solid #000000;border-bottom: 3px solid #000000;">
                                        <b>Item Descriptions</b> 
                                        </td>
                                        <td style="width: 80px; color: #000000; text-align: center; padding: 12px 0px;font-family:  Arial;font-size: 13px;margin: 0px;font-weight: 400;border-collapse: collapse; border-top: 3px solid #000000;border-bottom: 3px solid #000000;">
                                            <b>Rate</b>
                                        </td>
                                        <td style="width: 80px; color: #000000; text-align: center; padding: 12px 0px; font-family:  Arial;font-size: 13px;margin: 0px;font-weight: 400;border-collapse: collapse; border-top: 3px solid #000000;border-bottom: 3px solid #000000;">
                                            <b>Qty</b>
                                        </td>
                                        <td style="width:100px; color: #000000; text-align: center; padding: 12px 0px;font-family:  Arial;font-size: 13px;margin: 0px;font-weight: 400;border-collapse: collapse; border-top: 3px solid #000000;border-bottom: 3px solid #000000;">
                                            <b>Total</b>
                                        </td>
                                    </tr>
                                    @foreach($products as $product)
                                    <tr style="border-collapse: collapse;height: 24px;">
                                        <td style="width: 300px; text-align: start; padding: 12px 0px 12px 10px; margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse; height: 40px;">
                                            <p style="color:#000000; font-family:  Arial;font-size: 10px;">{{ $product->name }}</p>
                                        </td>
                                        <td style="width: 80px; text-align: center; padding: 12px 0px 12px 10px; margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse; height: 40px;">
                                            <p style="color:#000000; font-family:  Arial;font-size: 10px;"> {{ site_currency() }} {{  number_format($product->unit_price, 2) }}</p>
                                        </td>
                                        <td style="width: 80px; text-align: center; padding: 12px 0px 12px 10px; margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse; height: 40px;">
                                            <p style="color:#000000; font-family:  Arial;font-size: 10px;">1</p>
                                        </td>
                                        <td style="width: 100px; text-align: center; padding: 12px 0px 12px 10px; margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse; height: 40px;">
                                            <p style="color:#000000; font-family:  Arial;font-size: 10px;"> {{ site_currency() }} {{  number_format($product->unit_price, 2) }}</p>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="1">
                                        </td>
                                        <td style="width: 100px;color: #000000;text-align: center;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;padding-right: 10px; padding-left: 24px;" colspan="2">
                                        <p style="margin-bottom: 0px;">Sub Total</p>
                                        </td>
                                        <td style="width:100px;color: #000000;text-align:end;padding-right:10px;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;border: none">
                                            <p style="margin-bottom: 0px;">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="1">
                                        </td>
                                        <td style="width: 100px;color: #000000;text-align: center;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;padding-right: 10px; padding-left: 24px;"  colspan="2">
                                            <p>Discount</p>
                                        </td>
                                        <td style="width:100px;color: #000000;text-align:end;padding-right:10px;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;border: none;">
                                            <p>{{ site_currency() }} {{ number_format( $discount_amount, 2) }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="1">
                                        </td>
                                        <td style="width: 100px;color: #000000;text-align: center;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;padding-right: 10px; padding-left: 24px;" colspan="2">
                                        <p><b></b></p>
                                        </td>
                                        <td style="width:100px;color: #000000;text-align:end;padding-right:10px;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;border: none;">
                                            <p><b></b></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="1">
                                        </td>
                                        <td style="width: 100px;color: #000000;text-align: start;font-family: Arial;font-size: 13px;margin: 0px;font-weight: 400;padding-right: 10px; padding-left: 0px; border-top: 1px solid #000000;"  colspan="2">
                                            <p><b>Grand Total</b></p>
                                        </td>
                                        <td style="width:100px;color: #000000;text-align:end;padding-right:0px;font-family: Arial;font-size: 13px;margin: 0px;font-weight: 400;border-collapse: collapse;border: none;  border-top: 1px solid #000000;">
                                            <p><b>{{ site_currency() }} {{ number_format($invoice_amount, 2) }}</b></p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <br>
                            <p style="font-family: Arial; font-size: 12px;">Thank You for Your Business</p>
                        </td>
                        <td style="padding: 40px 40px 40px 60px; width: 150px; background-image: url('{{ $invoice_image3 }}'); text-align: end;">
                            <p style="font-family: Arial; font-size: 13px;"><b>Invoice To</b></p>
                            <p style="font-family: Arial; font-size: 13px;border-top: 1px solid #000000; padding-top: 10px;"><b>{{ $customer_name }}</b></p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <p style="font-family: Arial; font-size: 13px;border-bottom: 1px solid #000000; padding-bottom: 10px;"><b>Invoice From</b></p>
                            <p style="font-family: Arial; font-size: 13px;"><b>{{ $site_name }}</b></p>
                            <p style="font-family: Arial; font-size: 10px;">{{ $company_email }}</p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <p style="font-family: Arial; font-size: 16px;border-bottom: 1px solid #000000; padding-bottom: 10px;">Total Due</p>
                            <p style="font-family: Arial; font-size: 16px;"><b>{{ site_currency() }} {{ number_format($invoice_amount, 2) }}</b></p>
                        </td>
                    </tr>
                    <!-- Content End-->
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
