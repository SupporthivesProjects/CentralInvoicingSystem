<!DOCTYPE html>
<html>

<head>
    <title>Your Email Title</title>
</head>

<body style="padding: 0px; margin: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px;">
                <table width="800" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); background-image: url('{{ $invoice_image1 }}'); background-position: center; background-repeat: no-repeat; background-size: cover;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="padding: 100px 0px; position: relative;">
                            <div style="position: absolute; top: 80px; right: 175px; width: 200px;">
                                <p
                                    style="color: #000000; font-family: Arial;font-size: 18px;margin: 0px;font-weight: 600;">
                                    <b>FLUX DIGITALS</b>
                                </p>
                                <p
                                    style="color: #000000; font-family: Arial;text-align: start; margin: 0px; font-size: 10px;margin-top:6px;font-weight: 400;">
                                    {!! $company_address !!}<br>
                                    {{ $company_email }} | {{ $company_mobile }}
                                </p>
                            </div>
                        </td>
                    </tr>
                    <!-- Header End -->

                    <!-- Content -->
                    <tr>
                        <td
                            style="padding:0px 60px 150px 60px;background-position: center;background-size: cover;height:444px;">
                            <table style="width:100%;">
                                <tr>
                                    <td>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <div
                                            style="display: flex; justify-content: space-between; gap: 40px; width: 100%;">
                                            <div class="info_left">
                                                <div class="l_top" style="display: flex;flex-direction: row;">
                                                    <div
                                                        style="padding: 10px; height: 30px; background-color: #F2F2F2; width: 130px; border: 1px solid grey;">
                                                        <p
                                                            style="color:#000000; text-align:start;padding:10px;font-family:  Arial;font-size:10px;margin: 0px;font-weight: 400;">
                                                            Invoice No.
                                                        </p>
                                                    </div>
                                                    <div
                                                        style="padding: 10px; height: 30px; background-color: #F2F2F2; width: 130px; border: 1px solid grey; border-left: none;">
                                                        <p
                                                            style="color:#000000; text-align:start;padding:10px;font-family:  Arial;font-size:10px;margin: 0px;font-weight: 400;">
                                                            {{ $invoice_number }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="l_top" style="display: flex;flex-direction: row;">
                                                    <div
                                                        style="padding: 10px; height: 30px; background-color: #FFFFFF; width: 130px; border: 1px solid grey; border-top: none;">
                                                        <p
                                                            style="color:#000000; text-align:start;padding:10px;font-family:  Arial;font-size:10px;margin: 0px;font-weight: 400;">
                                                            Invoice Date.
                                                        </p>
                                                    </div>
                                                    <div
                                                        style="padding: 10px; height: 30px; background-color: #FFFFFF; width: 130px; border: 1px solid grey; border-left: none; border-top: none;">
                                                        <p
                                                            style="color:#000000; text-align:start;padding:10px;font-family:  Arial;font-size:10px;margin: 0px;font-weight: 400;">
                                                            {{ $invoice_date }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info_right"
                                                style="width: 300px; height: 140px; border: 1px solid grey; padding: 5px; display: flex; flex-direction: column; gap: 8px;">
                                                <p
                                                    style="color:#000000; text-align:start;padding:8px 10px;font-family:  Arial;font-size:10px;margin: 0px;font-weight: 400; width: 93%; background-color: #F2F2F2;">
                                                    Invoice to
                                                </p>
                                                <p
                                                    style="color:#000000; text-align:start;padding:8px;font-family:  Arial;font-size:18px;margin: 0px;font-weight: 400;">
                                                    {{ $customer_name }}
                                                </p>
                                                <p
                                                    style="color:#000000; text-align:start;padding:0px;font-family:  Arial;font-size:10px;margin: 0px;font-weight: 400;">
                                                    {{ $site_name }}<br>{{ $company_email }}
                                                    | {{ $company_mobile }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <div style="min-height: 460px;">
                                <table style="border-collapse: collapse;">
                                    <tr style="border-collapse: collapse;height: 24px;background-color: #1c2939;">
                                        <td
                                            style="width: 30px; color: #FFFFFF;border-left: 1px solid #FFFFFF;border-top: 1px solid #FFFFFF; border-right: 1px solid #FFFFFF; text-align: center; padding: 10px;font-family:  Arial;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>#</b>
                                        </td>
                                        <td
                                            style="width: 300px; color: #FFFFFF;border-right: 1px solid #FFFFFF;border-top: 1px solid #FFFFFF; text-align: start; padding: 10px;font-family:  Arial;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>Service type</b>
                                        </td>
                                        <td
                                            style="width: 80px; color: #FFFFFF;border-right: 1px solid #FFFFFF;border-top: 1px solid #FFFFFF; text-align: center; padding: 10px;font-family:  Arial;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>Qty</b>
                                        </td>
                                        <td
                                            style="width: 80px; color: #FFFFFF;border-right: 1px solid #FFFFFF;border-top: 1px solid #FFFFFF; text-align: center; padding: 10px; font-family:  Arial;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>Unit Price</b>
                                        </td>
                                        <td
                                            style="width: 80px; color: #FFFFFF; text-align: end; padding: 10px;border-top: 1px solid #FFFFFF;border-right: 1px solid #FFFFFF; font-family:  Arial;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>Total</b>
                                        </td>
                                    </tr>
                                    @foreach ($products as $product)
                                        <tr style="border-collapse: collapse;height: 24px;">
                                            <td
                                                style="width: 30px; color:#000000; border-left: 1px solid #FFFFFF; border-right: 1px solid #FFFFFF; text-align:center;padding:10px;font-family: Arial;font-size:10px;margin: 0px;font-weight: 400;border-bottom: 1px solid grey;border-collapse: collapse;">
                                                 {{ $loop->iteration }}
                                            </td>
                                            <td
                                                style="width: 300px; color:#000000; border-right: 1px solid #FFFFFF; text-align: start; padding: 10px 10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-bottom: 1px solid grey;border-collapse: collapse;">
                                                {{ $product->name }}
                                            </td>
                                            <td
                                                style="width: 80px; color:#000000; border-right: 1px solid #FFFFFF; text-align:center;padding:10px;font-family:  Arial;font-size:10px;margin: 0px;font-weight: 400;border-bottom: 1px solid grey;border-collapse: collapse;">
                                                1
                                            </td>
                                            <td
                                                style="width:80px; color:#000000; border-right: 1px solid #FFFFFF; text-align:center;padding:10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-bottom: 1px solid grey;border-collapse: collapse; background-color: #F2F2F2;">
                                                {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}                                            </td>
                                            <td
                                                style="width:80px; color:#000000; border-right: 1px solid #FFFFFF; text-align:right;padding:10px;font-family:  Arial;font-size: 10px;margin: 0px;font-weight: 400;border-bottom: 1px solid grey;border-collapse: collapse; background-color: #F2F2F2;">
                                                {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;"
                                            colspan="3">
                                        </td>
                                        <td style="width: 100px;color: #FFFFFF;text-align: end;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400; background-color: #a6a6a6; border-bottom: 1px solid #F2F2F2;"
                                            colspan="1">
                                            <p style="margin: 0px; padding: 10px;">Sub Total</p>
                                        </td>
                                        <td
                                            style="width:100px;color: #FFFFFF;text-align:center;padding-right:10px;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse; background-color: #a6a6a6; border-bottom: 1px solid #F2F2F2;">
                                            <p style="margin: 0px; padding: 10px;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px; "
                                            colspan="3">
                                        </td>
                                        {{-- <td style="width: 100px;color: #FFFFFF;text-align: end;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400; background-color: #a6a6a6; border-bottom: 1px solid #F2F2F2;"
                                            colspan="1">
                                            <p style="margin: 0px; padding: 10px;">
                                                Tax
                                            </p>
                                        </td>
                                        <td
                                            style="width:100px;color: #FFFFFF;text-align:center;padding-right:10px;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse; background-color: #a6a6a6; border-bottom: 1px solid #F2F2F2;">
                                            <p style="margin: 0px; padding: 10px;">$00.00</p>
                                        </td> --}}
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px; "
                                            colspan="3">
                                        </td>
                                        <td style="width: 100px;color: #FFFFFF;text-align: end;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400; background-color: #a6a6a6; border-bottom: 1px solid #F2F2F2;"
                                            colspan="1">
                                            <p style="margin: 0px; padding: 10px;">
                                                Discount
                                            </p>
                                        </td>
                                        <td
                                            style="width:100px;color: #FFFFFF;text-align:center;padding-right:10px;font-family: Arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse; background-color: #a6a6a6; border-bottom: 1px solid #F2F2F2;">
                                            <p style="margin: 0px; padding: 10px;">{{ site_currency() . number_format($discount_amount, 2) }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;"
                                            colspan="3">
                                        </td>
                                        <td style="width: 100px;color: #FFFFFF;text-align: end;font-family: Arial;font-size: 16px;margin: 0px;font-weight: 400; background-color: #1c2939;"
                                            colspan="1">
                                            <p style="margin: 0px; padding: 10px;">
                                                <b>Total</b>
                                            </p>
                                        </td>
                                        <td
                                            style="width:100px;color: #FFFFFF;text-align:center;padding-right:10px;font-family: Arial;font-size: 16px;margin: 0px;font-weight: 400; border-collapse: collapse; background-color: #1c2939;">
                                            <p style="margin: 0px; padding: 10px;"><b>{{ site_currency() . number_format($invoice_amount, 2) }}</b></p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <!-- Content End-->
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
