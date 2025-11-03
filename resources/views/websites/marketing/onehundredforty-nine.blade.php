<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
    /* Target only tr elements with this class */
    tr.row-color:nth-child(odd) {
       
        background-color: #F6F1FA; 
    }

    tr.row-color:nth-child(even) {
        background-color: #ffffff;
    }
</style>
</head>

<body style="margin: 0 !important; padding: 0 !important;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#ffffff" style="padding:0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0"
                    style="border-collapse: collapse; background: url({{ $invoice_image3 }});background-repeat: no-repeat;background-position: center;background-size: cover;">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 70px;vertical-align:bottom;background:url({{ $invoice_header_image }});background-repeat: no-repeat;background-position: center;background-size: cover;"
                            align="left" colspan="2">
                            <img src="{{ $company_logo }}" alt="" style="margin:0px; display: block;width:200px;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-left:40px;vertical-align:bottom;overflow:hidden;" align="left">
                            <h1 style="font-family: arial;font-size: 36px;color: #414042;margin: 0px;">INVOICE</h1>
                        </td>
                        <td style="padding:0px;vertical-align:top;overflow:hidden;" align="right">
                            <img src="{{ $invoice_image1 }}" alt="" style="width:120px;margin-right: -20px;">
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td style="padding-left:40px;vertical-align:bottom;overflow:hidden;display: flex;gap:95px;"
                            align="left">
                            <div>
                                <p style="font-family: arial;font-size:9px;color: #414042;margin: 0px;">
                                    Invoice No : #{{ $invoice_number }}
                                </p>
                                <p style="font-family: arial;font-size:9px;color: #414042;margin: 0px;">
                                    Date : {{ $invoice_date }}
                                </p>
                                <p style="border-bottom: 1px solid black;width: 150px;margin: 5px 0px;"></p>
                                <p style="font-family: arial;font-size:10px;color: #414042;">
                                    Total Amount Due
                                </p>
                                <p
                                    style="font-family: arial;font-size:22px;color: #414042;margin: 0px;font-weight: 700;">
                                    {{ site_currency() . $invoice_amount }}
                                </p>
                            </div>
                            <div style="padding-left:40px;">
                                <p
                                    style="font-family: arial;font-size:10px;color: #414042;margin: 0px;font-weight: 700;">
                                    Invoice To
                                </p>
                                <p
                                    style="font-family: arial;font-size:12px;color: #414042;margin: 0px;font-weight: 700;">
                                    {{ $customer_name }}
                                </p>
                            </div>
                        </td>
                        <td style="padding-right:40px;vertical-align:top;overflow:hidden;" align="right">
                            <div style="text-align: left;">
                                <p
                                    style="font-family: arial;font-size:10px;color: #414042;margin: 0px;font-weight: 700;">
                                    Invoice From
                                </p>
                                <p
                                    style="font-family: arial;font-size:12px;color: #414042;margin: 0px;font-weight: 700;">
                                    {{ $site_name }}
                                </p>
                                <a
                                    style="font-family: arial;font-size:9px;color: #0563C1;margin: 0px;text-decoration: underline;">
                                    {{ $company_email }}
                                </a>
                                <p style="font-family: arial;font-size:9px;color: #414042;margin: 0px; max-width: 150px">
                                    {{ $company_address }}<br>
                                    {{ $company_mobile }} 
                                </p>
                            </div>
                        </td>
                    </tr>
                   

                    <tr>
                        <td colspan="2" align="center">
                            <p style="border-bottom: 2px solid black;width: 90%;"></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px;width: 100%;padding-top:20px;" colspan="2">
                            <!-- <div style="min-height: 495px;"> -->
                                <table cellspacing="0" cellpadding="0" border="0" width="100%"
                                    style="border-collapse: collapse;">
                                    <tr style="width:520px;height:40px;background: #000000;">
                                        <td style="width: 150px;padding-left: 10px">
                                            <p
                                                style="color:#ffffff;font-size:16px;font-weight: 700;font-family:arial;margin: 0px;line-height: 28px;text-align: left;text-transform: uppercase;">
                                                product & service
                                            </p>
                                        </td>
                                        <td style="width:50px;">
                                            <p
                                                style="color:#ffffff;font-size:16px;font-weight: 700;font-family:arial;margin: 0px;line-height: 28px;text-align: center;text-transform: uppercase;">
                                                QTY
                                            </p>
                                        </td>
                                        <td style="width: 100px;">
                                            <p
                                                style="color:#ffffff;font-size:16px;font-weight: 700;font-family:arial;margin: 0px;line-height: 28px;text-align: center;text-transform: uppercase;">
                                                length
                                            </p>
                                        </td>
                                        <td style="width: 120px;">
                                            <p
                                                style="color:#ffffff;font-size:16px;font-weight: 700;font-family: arial;margin: 0px;line-height: 28px;text-align: center;text-transform: uppercase;">
                                                billing cycle
                                            </p>
                                        </td>
                                        <td style="width: 100px;text-align: right; padding-right: 10px">
                                            <p
                                                style="color:#ffffff;font-size:16px;font-weight: 700;font-family:arial;margin: 0px;line-height: 28px;text-align: right;text-transform: uppercase;">
                                                Total
                                            </p>
                                        </td>
                                    </tr>
                                    @foreach ($products as $product)
                                        <tr class="row-color" style="width:520px;height:60px;">
                                            <td style="width: 150px;padding: 10px;" align="left">
                                                <p
                                                    style="color:#000000;font-size:12px;font-weight:400;font-family:arial;margin: 0px;line-height:16px;">
                                                    {{ $product->name }}
                                                </p>
                                            </td>
                                            <td style="width:50px;">
                                                <p
                                                    style="color:#000000;font-size:9px;font-weight:400;font-family:arial;margin: 0px;line-height:16px;text-align: center;">
                                                    1
                                                </p>
                                            </td>
                                            <td style="width: 100px;">
                                                <p
                                                    style="color:#000000;font-size:9px;font-weight:400;font-family:arial;margin: 0px;line-height: 28px;text-align: center;text-transform: uppercase;">
                                                    {{ $product->subscription }}
                                                </p>
                                            </td>
                                            <td style="width: 120px;">
                                                <p
                                                    style="color:#000000;font-size:9px;font-weight: 400;font-family: arial;margin: 0px;line-height: 28px;text-align: center;text-transform: uppercase;">
                                                    One Time
                                                </p>
                                            </td>
                                            <td style="width: 100px;text-align: right; padding-right: 10px">
                                                <p
                                                    style="color:#000000;font-size:9px;font-weight: 400;font-family:arial;margin: 0px;line-height: 28px;text-align: right;text-transform: uppercase;">
                                                    {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr style="height: 28px;">
                                        <td colspan="3"></td>
                                        <td>
                                            <p
                                                style="color:#58595B;font-size:12px;font-weight:400;font-family:arial;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;text-transform: uppercase;">
                                                Subtotal
                                            </p>
                                        </td>
                                        <td>
                                            <p
                                                style="color:#58595B;font-size:12px;font-weight:400;font-family: arialmargin: 0px;line-height: 28px;text-align:right;padding-right:10px;text-transform: uppercase;">
                                                {{ site_currency() . number_format($invoice_amount + $discount_amount ?? 0, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr style="height:40px;">
                                        <td colspan="3"></td>
                                        <td style="border-bottom: 1px solid #58595B;">
                                            <p
                                                style="color:#58595B;font-size:12px;font-weight:400;font-family:arial;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;text-transform: uppercase;">
                                                Discount
                                            </p>
                                        </td>
                                        <td style="border-bottom: 1px solid #58595B;">
                                            <p
                                                style="color:#58595B;font-size:12px;font-weight:400;font-family:arial;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;text-transform: uppercase;">
                                                {{ site_currency() . number_format($discount_amount ?? 0, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr style="height: 28px;">
                                        <td colspan="4">
                                            <p
                                                style="color:#58595B;font-size:16px;font-weight:700;font-family:arial;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;text-transform: uppercase;">
                                                GRAND TOTAL
                                            </p>
                                        </td>
                                        <td>
                                            <p
                                                style="color:#58595B;font-size:16px;font-weight:700;font-family:arial;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;text-transform: uppercase;">
                                                {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            <!-- </div> -->
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <img src="{{ $invoice_image2 }}" alt="" style="height: 100px;">
                        </td>
                    </tr>
                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr>
                        <td align="center"
                            style="height:60px;background: url({{ $invoice_footer_image }});background-position: center;background-repeat: no-repeat;background-size: cover;"
                            colspan="2">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">

                            </table>
                        </td>
                    </tr>
                    <!-----------Footer End----------->
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
