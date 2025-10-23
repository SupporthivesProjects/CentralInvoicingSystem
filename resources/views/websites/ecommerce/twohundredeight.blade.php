<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }} </title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color : #1E2E22;
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse;">
                    <!-- Header -->
                    <tr>
                        <td style="background: url('{{ $invoice_header_image }}');background-repeat: no-repeat;height:130px;background-size: cover;"></td>
                    </tr>
                    <!-- Header -->
                    <!-- Content -->
                    <tr style="background:url('{{ $invoice_image1 }}');background-repeat: no-repeat;background-size:100% 100%;">
                        <td style="padding:20px 40px 40px 40px;">
                            <table border="0" style="border-collapse: collapse;width: 100%;">
                                  <tr align="right">
                                    <td style="background: url(img/left-bg.png);background-position: center;background-size: cover;background-repeat: no-repeat;vertical-align:top;" colspan="2">
                                        <h2 style="margin:0px;color:#ffffff;font-size:14px;font-family: DM Sans;line-height: 18px;font-weight: 400;text-align: left;">
                                            Invoice To :
                                        </h2>
                                        <h2 style="margin:0px;color:#ffffff;font-size:24px;font-family: DM Sans;line-height:32px;font-weight: 400;text-align: left;">
                                            {{ $customer_name ? $customer_name : '' }}<br>
                                            {{ $customer_email ? $customer_email : '' }}<br>
                                            {{ $customer_mobile ? $customer_mobile : '' }}
                                        </h2>
                                    </td> 
                                  </tr>
                                  <tr style="height:40px;"></tr>
                                  <tr style="height:569px;vertical-align:top;">
                                    <td style="width:70%;vertical-align:top;">
                                      <table style="border-collapse: collapse;width:100%;">
                                        <tr style="border-top: 1px solid #ffffff;border-bottom: 1px solid #ffffff;">
                                            <td style="padding:10px;width:40%;">
                                            <p style="margin:0px;color:#ffffff;font-size:14px;font-family: DM Sans;line-height: 18px;font-weight: 400;">
                                            DESCRIPTION
                                            </p>
                                            </td>
                                             <td style="padding: 10px;width: 30%;" align="center">
                                            <p style="margin:0px;color:#ffffff;font-size:14px;font-family: DM Sans;line-height: 18px;font-weight: 400;">
                                            UNIT PRICE
                                            </p>
                                            </td>
                                             <td style="padding: 10px;width: 15%;" align="center">
                                            <p style="margin:0px;color:#ffffff;font-size:14px;font-family: DM Sans;line-height: 18px;font-weight: 400;">
                                            QTY
                                            </p>
                                            </td>
                                             <td style="padding:10px 0px;width:15%;" align="center">
                                            <p style="margin:0px;color:#ffffff;font-size:14px;font-family: DM Sans;line-height: 18px;font-weight: 400;">
                                            TOTAL
                                            </p>
                                            </td>
                                        </tr>
                                        @foreach ($products as $product)
                                        <tr>
                                            <td style="padding:10px;width:40%;">
                                            <p style="margin:0px;color:#ffffff;font-size:14px;font-family: DM Sans;line-height: 18px;font-weight: 400;">
                                                {{ $product->name }}
                                            </p>
                                            </td>
                                             <td style="padding: 10px;width: 30%;" align="center">
                                            <p style="margin:0px;color:#ffffff;font-size:14px;font-family: DM Sans;line-height: 18px;font-weight: 400;">
                                                {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}
                                            </p>
                                            </td>
                                             <td style="padding: 10px;width: 15%;" align="center">
                                            <p style="margin:0px;color:#ffffff;font-size:14px;font-family: DM Sans;line-height: 18px;font-weight: 400;">
                                            1
                                            </p>
                                            </td>
                                             <td style="padding: 10px 0px;width:15%;" align="center">
                                            <p style="margin:0px;color:#ffffff;font-size:14px;font-family: DM Sans;line-height: 18px;font-weight: 400;">
                                                {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}
                                            </p>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr style="border-top: 1px solid #ffffff;">
                                            <td style="padding:0px 10px;padding-top: 10px;" colspan="3">
                                            <p style="margin:0px;color:#ffffff;font-size:14px;font-family: DM Sans;line-height: 18px;font-weight:500;">
                                            SUBTOTAL
                                            </p>
                                             <td style="padding:0px 10px;padding-top: 10px;" align="center">
                                            <p style="margin:0px;color:#ffffff;font-size:14px;font-family: DM Sans;line-height: 18px;font-weight:500;">
                                                {{ site_currency() . number_format($invoice_amount + $discount_amount ?? 0, 2) }}
                                            </p>
                                            </td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid #ffffff;">
                                            <td style="padding:10px;" colspan="3">
                                            <p style="margin:0px;color:#ffffff;font-size:14px;font-family: DM Sans;line-height: 18px;font-weight:500;">
                                            DISCOUNT
                                            </p>
                                            </td>
                                             <td style="padding:10px;" align="center">
                                            <p style="margin:0px;color:#ffffff;font-size:14px;font-family: DM Sans;line-height: 18px;font-weight:500;">
                                                {{ site_currency() . number_format($discount_amount ?? 0, 2) }}
                                            </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:20px 10px;" colspan="3">
                                            <p style="margin:0px;color:#ffbf00;font-size:16px;font-family: DM Sans;line-height: 18px;font-weight:600;">
                                            GRAND TOTAL
                                            </p>
                                             <td style="padding:20px 10px;" align="center">
                                            <p style="margin:0px;color:#ffffff;font-size:24px;font-family: DM Sans;line-height:32px;font-weight:700;">
                                                {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}
                                            </p>
                                            </td>
                                        </tr>
                                      </table>
                                    </td>
                                    <td style="width:30%;vertical-align:top;" align="right">
                                        <p style="margin:0px;color:#ffffff;font-size:11px;font-family: DM Sans;line-height:18px;font-weight:700;">
                                            Invoice Number
                                        </p>
                                        <p style="margin:0px;color:#ffffff;font-size:14px;font-family: DM Sans;line-height:12px;">
                                            {{ $invoice_number }}
                                        </p>
                                        <br>
                                        <p style="margin:0px;color:#ffffff;font-size:11px;font-family: DM Sans;line-height:18px;font-weight:700;">
                                            Invoice Date
                                        </p>
                                        <p style="margin:0px;color:#ffffff;font-size:14px;font-family: DM Sans;line-height:12px;">
                                            {{ $invoice_date }}
                                        </p>
                                    </td>
                                  </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End-->
                    <!-----------Footer----------->
                    <tr>
                        <td align="bottom" style="background:url('{{ $invoice_image2 }}');background-size: cover;background-repeat: repeat;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
                                <tr>
                                    <td style="padding:40px 40px 100px 40px;">
                                        <h2 style="margin:0px;color:#ffffff;font-size:14px;font-family: DM Sans;line-height: 18px;">
                                            {{ $company_name }}
                                        </h2>
                                        <p style="margin:0px;color:#ffffff;font-size:14px;font-family: DM Sans;line-height: 16px;">
                                            {!! $company_address !!}<br>
                                            {{ $company_email }}<br>
                                            {{ $company_mobile }}

                                        </p>
                                    </td>
                                </tr>         
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
