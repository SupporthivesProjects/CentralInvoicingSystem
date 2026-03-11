<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        * {
            margin:0px;
            padding:0px;
        }
        .footer_bottom {
            position: fixed;
            bottom: -1px;
            left: 0px;
            right: 0px;
            width: calc(100% + 5px);

            display: flex;
            align-items: center;
            justify-content: space-between;
            background: url('{{ $invoice_footer_image }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            height: 141px;
            padding: 0 40px;
            color: white;

        }
        .trans {
            background: #FFFFFF;
        }
        .dark {
            background: #E6E7E8;
        }
    </style>
</head>

<body style="border-collapse: collapse;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
        <tr>
            <td align="center">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse;">
                    <tr>
                        
                        <td
                            style="height: 60px; background: url('{{ $invoice_header_image }}') no-repeat;background-position: center;background-size:cover;width: 100%;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px;">
                            <table width="100%">
                                <tr>
                                    <td>
                                        <p style="font-family:Calibri;font-size:48px;margin: 0px;font-weight:700;">
                                            <b>INVOICE</b>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 8px;padding-bottom:8px;">
                                        <p style="font-size: 10px;margin-bottom: 8px;font-family:Calibri;font-weight:700;"><b>Invoice To</b></p>
                                        <p style="font-size: 12px;margin-bottom: 8px;font-family:Calibri;font-weight:700;">
                                            <b>
                                                {{ $customer_name }}
                                            </b>
                                        </p>

                                    </td>
                                    <td style="padding-right: 45px;padding-top: 8px;padding-bottom:8px;">
                                        <p style="font-size: 10px;margin-bottom: 8px;font-family:Calibri;font-weight:700;">Invoice From</p>
                                        <p style="font-size: 12px;margin-bottom: 8px;font-family:Calibri;font-weight:700;">
                                            <b>
                                                {{ $site_name }}
                                            </b>
                                            
                                        </p>
                                        <p style="font-size: 10px;margin-bottom: 8px;font-family:Calibri;font-weight:400;">
                                            www.bluemoonmarketeers.com
                                        </p>
                                    </td>
                                    <td style="text-align: right;padding-top: 8px;padding-bottom:8px;">
                                        <p style="font-size: 10px;margin-bottom: 8px;font-family:Calibri;">Invoice No: #{{ $invoice_number }}</p>
                                        <p style="font-size: 10px;margin-bottom: 8px;font-family:Calibri;">Due Date: {{ $invoice_date }}</p>
                                        <p style="border-bottom:1px solid black;font-family:Calibri;"></p>

                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid black;">
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <p
                                            style="font-family:Calibri;font-size: 10px;margin-top: 0px;text-align: right;margin-left: 60px;margin-bottom: 8px;">
                                            Total Amount Due</p>
                                        <p
                                            style="font-family:Calibri;font-size: 22px;margin-top: 0px;text-align: right;margin-left: 60px;font-weight: 700;margin-bottom: 8px;">
                                            {{ site_currency() . number_format($invoice_amount, 2) }}</p>

                                    </td>

                                </tr>

                            </table>
                           <p style="height:10px;"></p>
                                <p style="border-top:1px solid black;width:100px;height:20px;width:100%;"></p>
                            <div style="min-height: 650px !important;">
                                
                                <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                    <tr
                                        style="border-collapse: collapse;background-color: #09192A; color: white;border-bottom: 0px;border: 0px;">
                                        <td
                                            style="padding-left: 16px;width: 600px;text-align: left;font-family:Calibri;font-size: 16px;margin: 0px;font-weight: 700;border-collapse: collapse;padding:16px 20px;text-transform:uppercase;">
                                            <b>Product Description</b>
                                        </td>
                                        <td
                                            style="width: 250px;text-align: center;font-family:Calibri;font-size: 16px;margin: 0px;font-weight: 700;border-collapse: collapse;padding:16px 20px;text-transform:uppercase;">
                                            <b>#Month</b>
                                        </td>
                                        <td
                                            style="padding-right: 16px;width: 150px;text-align: right;font-family:Calibri;font-size: 16px;margin: 0px;font-weight: 700;border-collapse: collapse;padding:16px 20px;text-transform:uppercase;">
                                            <b>Price</b>
                                        </td>

                                    </tr>
                                    @foreach ($products as $product)
                                        <tr class="{{ $loop->even ? 'dark' : 'trans' }}"  style="border-collapse: collapse;height: 50px;">
                                            <td
                                                style="padding-left: 16px;width: 100px;text-align: left;font-family:Calibri;font-size: 16px;margin: 0px;font-weight: 700;border-collapse: collapse;border-bottom: 0px; ">
                                                {{ $product->name ?? '-' }}
                                            </td>
                                            <td
                                                style="width: 250px;text-align:center;padding-left:10px;font-family:Calibri;font-size:16px;margin: 0px;font-weight: 700;border-collapse: collapse;">
                                                {{ $product->subscription ?? '-' }}
                                            </td>
                                            <td
                                                style="padding-right: 16px;width:100px;text-align:right;padding-right:10px;font-family:Calibri;font-size: 16px;margin: 0px;font-weight: 700; border-collapse: collapse;">
                                                {{ site_currency() . number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family:Calibri;font-size: 12px;margin: 0px;font-weight: 400;padding-right: 10px;padding-top: 8px;padding-bottom:8px;"
                                            colspan="2">
                                            <p><b>
                                                    SUBTOTAL
                                                </b></p>
                                        </td>
                                        <td
                                            style="padding-right: 16px;width:100px;text-align:right;padding-right:10px;font-family:Calibri;font-size: 12px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-top: 8px;padding-bottom:8px;"colspan="1">
                                            <p><b>{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</b>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td
                                            style="width: 100px;padding-right: 10px;text-align: right;font-family:Calibri;font-size: 12px;margin: 0px;font-weight: 400;border-bottom: 1px solid black;padding-top: 8px;padding-bottom:8px;">
                                            <p>DISCOUNT</p>
                                        </td>
                                        <td
                                            style="padding-right: 16px;width:100px;text-align:right;padding-right:10px;font-family:Calibri;font-size: 12px;margin: 0px;font-weight: 400;border-bottom: 1px solid black;border-collapse: collapse;padding-top: 8px;padding-bottom:8px;">
                                            <p>{{ site_currency() . number_format($discount_amount, 2) }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;padding-right: 10px;text-align: right;font-family:Calibri;font-size:16px;margin: 0px;font-weight: 400;padding-top: 8px;padding-bottom:8px;"
                                            colspan="2">
                                            <b>Grand Total</b>
                                        </td>
                                        <td
                                            style="padding-right: 16px;width:100px;text-align:right;padding-right:10px;font-family:Calibri;font-size:16px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-top: 8px;padding-bottom:8px;"colspan="1">
                                            <b>{{ site_currency() . number_format($invoice_amount, 2) }}</b>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>

                            <div class="footer_bottom">

                                <!-- Company Logo -->
                                <div style="flex: 1;">
                                    <img src="{{ $company_logo }}" alt="Company Logo" style="height: 85px; display: block;">
                                </div>

                                <!-- Company Address -->
                                <div style="flex: 1; text-align: left;">
                                    <p style="font-size: 11px; margin: 0;font-family:Calibri;font-weight:700;"><b>ADDRESS</b></p>
                                    <p style="font-size: 9px; margin: 0;font-family:Calibri;">{!! $company_address ?? 'N/A' !!}</p>
                                </div>

                                <!-- Company Contact -->
                                <div style="flex: 1; text-align: left;">
                                    <p style="font-size: 11px; margin: 0;font-family:Calibri;font-weight:700;"><b>CONTACTS</b></p>
                                    <p style="font-size: 9px; margin: 0;font-family:Calibri;">
                                        {{ $company_email ?? 'support@bluemoonmarketeers.com' }}
                                    </p>
                                </div>

                            </div>


                            <!-- <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr
                                    style="background: url('{{ $invoice_footer_image }}') no-repeat;background-position: center;background-size: cover;height:141px;padding:50px;background-size:cover;width: 100%;">
                                    <td><img src="{{ $company_logo }}" alt="Company Logo"
                                            style="padding-left: 40px; display: block;height:85px;">
                                    </td>
                                    <td style="color: white;margin: auto;">
                                        <p style="font-size: 10px;"><b>ADDRESS</b></p>
                                        <p style="font-size: 10px;">{!! $company_address ?? 'N/A' !!}
                                        </p>
                                    </td>
                                    <td style="color: white;">
                                        <p style="font-size: 10px;"><b>CONTACTS</b></p>
                                        <p style="font-size: 10px;">
                                            {{ $company_email ?? 'support@bluemoonmarketeers.com' }}</p>
                                    </td>
                                </tr>
                            </table> -->
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
