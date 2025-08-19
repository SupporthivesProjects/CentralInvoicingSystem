<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name . $invoice_number }}</title>
</head>
<body style="padding: 0px; margin: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <table width="700" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;">
                            <img src="{{ $invoice_header_image }}" alt="" style="display: block;max-width: 100%;">
                        </td>
                    </tr>
                    <!-- Header End -->

                    <tr>
                        <td style="padding: 0px 40px;">
                            <table style="width:100%;">
                                <tr>
                                    <td>
                                        <div style="display: flex; justify-content: space-between; width: 100%;">
                                            <p style="font-family: Arial;font-size: 11px;margin: 0px;font-weight: 400;"></p>
                                            <p style="font-family: Arial;font-size: 11px;margin: 0px;font-weight: 400;position: relative;top: -12px;">
                                                Invoice No: {{ $invoice_number }}<br>
                                                Invoice Date: {{ $invoice_date }}
                                            </p>
                                        </div>
                                        <br>
                                        <br>
                                        <br>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:0px 20px 180px 20px; background: url('{{ $invoice_image1 }}') no-repeat;background-position: center;background-size: contain; display: flex; align-items: flex-start;">
                            <table style="width: 280px; border-spacing: 0px;">
                                <tr>
                                    <td style="padding: 0px;">
                                        <p style="padding: 6px; background-color: #669bb9; margin: 0px; color: #FFFFFF; text-align: center;font-family:  Arial;font-size: 11px; border-right: 1px solid white;">Invoice Details </p>
                                        <p style="padding: 6px; padding-left: 24px; margin: 0px; color: #000000; text-align: start;font-family:  Arial;font-size: 11px;">
                                            Invoice To :<br>
                                            <b>{{ $customer_name }}</b>
                                        </p><br><br>
                                        <p style="padding: 6px; padding-left: 24px; margin: 0px; color: #000000; text-align: start;font-family:  Arial;font-size: 11px;">
                                            Invoice From :<br>
                                            <b>{{ $site_name }}</b>
                                        </p>
                                        <p style="padding: 6px; padding-left: 24px; margin: 0px; color: #000000; text-align: start;font-family:  Arial;font-size: 11px;">
                                            {{ $customer_email }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <table style="border-collapse: collapse;">
                                <tr style="border-collapse: collapse;height: 24px;background-color: #669bb9;">
                                    <td style="width: 20px; color: #FFFFFF; text-align: center; padding: 0px 10px;font-family:  Arial;font-size: 11px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                    </td>
                                    <td style="width: 350px; color: #FFFFFF; text-align: start; padding: 0px 10px;font-family:  Arial;font-size: 11px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>Item Description</b>
                                    </td>
                                    <td style="width: 150px; color: #FFFFFF; text-align: center; padding: 0px 10px; font-family:  Arial;font-size: 11px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>Billing Cycle</b>
                                    </td>
                                    <td style="width: 30px; color: #FFFFFF; text-align: center; padding: 0px 10px; font-family:  Arial;font-size: 11px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>Qty.</b>
                                    </td>
                                    <td style="width:100px; color: #FFFFFF; text-align: center; padding: 0px 10px;font-family:  Arial;font-size: 11px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>Total</b>
                                    </td>
                                </tr>
                                @foreach($products as $index => $product)
                                <tr style="border-collapse: collapse;height: 24px;">
                                    <td style="width: 20px; color:#000000; text-align: center; padding: 0px 10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                      {{ $index + 1 }}
                                    </td>
                                    <td style="width: 350px; color:#000000; text-align:start;padding:10px;font-family:  Arial;font-size:8px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        <b>{{ $product->name }}</b><br>
                                        Lorem ipsum dolor sit amet consectetur. Nec id adipiscing ut id. Consequat mauris maecenas
                                    </td>
                                    <td style="width:150px; color:#000000; text-align:center;padding-right:10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse; background-color: #e8f0f3;">
                                        One Time
                                    </td>
                                    <td style="width:30px; color:#000000; text-align:center;padding-right:10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse;">
                                        1
                                    </td>
                                    <td style="width:100px; color:#000000; text-align:center;padding-right:10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-bottom: 1px solid #000000;border-collapse: collapse; background-color: #e8f0f3;">
                                        {{ site_currency() . number_format($product->unit_price, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="3">
                                       </td>
                                    <td style="width: 100px;color: #000000;text-align: end;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;padding-right: 10px; padding-left: 10px;" colspan="1">
                                     <p style="margin-bottom: 0px; margin-top: 24px;">Sub Total :</p>
                                    </td>
                                    <td style="width:100px;color: #000000;text-align:center;padding-right:10px;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <p style="margin-bottom: 0px; margin-top: 24px;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px; " colspan="3">
                                       </td>
                                    <td style="width: 100px;color: #000000;text-align: end;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;padding-right: 10px; padding-left: 10px; border-bottom: 1px solid #000000;"  colspan="1">
                                     <p style="margin-top: 6px;">
                                        Discount :
                                    </p>
                                    </td>
                                    <td style="width:100px;color: #000000;text-align:center;padding-right:10px;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse; border-bottom: 1px solid #000000;">
                                        <p style="margin-top: 6px;">{{ site_currency() . number_format($discount_amount, 2) }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="3">
                                       </td>
                                    <td style="width: 100px;color: #000000;text-align: start;font-family: Arial;font-size: 16px;margin: 0px;font-weight: 400;  padding-right: 10px; padding-left: 24px;" colspan="1">
                                     <p>
                                        <b>Total :</b>
                                    </p>
                                    </td>
                                    <td style="width:100px;color: #000000;text-align:end;padding-right:10px;font-family: Arial;font-size: 16px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        <p><b>{{ site_currency() . number_format($invoice_amount, 2) }}</b></p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End-->

                    <tr>
                        <td style="padding: 40px 60px 20px 60px;">
                            <div style="display: flex; gap: 24px; align-items: flex-end;">
                                <div style="padding: 0px; display: flex; flex-direction: column; gap: 12px;width: 100%;">
                                    <p style="font-family:  Arial;font-size: 13px;margin: 0px; font-weight: 400; text-align: center;">
                                        <b>Address</b>
                                    </p>
                                    <p style="font-family:  Arial;font-size: 9px;margin: 0px; font-weight: 400; text-align: center;">
                                        {!! $company_address !!}
                                    </p>
                                </div>
                                <div style="height: 20px; width: 1px; background-color: #000000;"></div>
                                <div style="padding: 0px; display: flex; flex-direction: column; gap: 12px; width: 100%;">
                                    <p style="font-family:  Arial;font-size: 13px;margin: 0px; font-weight: 400; text-align: center;">
                                        <b>Phone</b>
                                    </p>
                                    <p style="font-family:  Arial;font-size: 9px;margin: 0px; font-weight: 400; text-align: center;">
                                        {{ $company_mobile }}
                                    </p>
                                </div>
                                <div style="height: 20px; width: 1px; background-color: #000000;"></div>
                                <div style="padding: 0px; display: flex; flex-direction: column; gap: 12px; width: 100%;">
                                    <p style="font-family:  Arial;font-size: 13px;margin: 0px; font-weight: 400; text-align: center;">
                                        <b>Email</b>
                                    </p>
                                    <p style="font-family:  Arial;font-size: 9px;margin: 0px; font-weight: 400; text-align: center;">
                                        {{ $company_email }}
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>
                     <!-- Footer -->
                     <tr>
                        <td style="background-color: #213442; padding: 16px;">
                        </td>
                     </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
