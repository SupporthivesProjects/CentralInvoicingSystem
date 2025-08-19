<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);background: url('{{ $invoice_image1 }}');background-repeat: no-repeat;background-position: center;background-size: cover;height:900px;">
                    <!---header--->
                    <tr style="height:90px;">
                        <td style="padding:40px;vertical-align: top;padding-right: 30px;" align="right">
                           <p style="font-family:Futura Cyrillic;font-size: 14px;font-weight: 400;line-height:24px;margin:25px;">
                            {{ $invoice_date }}
                           </p>
                        </td>   
                    </tr>
                    <!---header End--->

                    <!-- Content -->
                    <tr style="height: 24px;">
                        <td style="padding:20px 50px;vertical-align: top;" align="right">
                           <p style="font-family:Futura Cyrillic;font-size: 12px;font-weight: 400;line-height: 24px;margin: 0px;">
                              Invoice Number 
                           </p>
                           <p style="font-family:Avenir;font-size: 14px;font-weight:700;line-height: 24px;margin: 0px;color: #198bb1;">
                              #{{ $invoice_number }}
                           </p>
                        </td>   
                    </tr>
                    <tr style="height: 24px;">
                        <td style="padding:0px 50px;vertical-align: top;" align="left">
                           <p style="font-family:Futura Cyrillic;font-size: 14px;font-weight: 400;line-height:30px;margin: 0px;">
                              Invoice To :
                           </p>
                         
                           <p style="font-family:Futura Cyrillic;font-size:16px;font-weight:700;line-height:30px;margin: 0px;color: #198bb1;">
                            {{ $customer_name ? $customer_name : '' }}<br>
                            {{ $customer_email ? $customer_email : '' }}<br>
                            {{ $customer_mobile ? $customer_mobile : '' }}
                           </p>
                        </td>   
                    </tr>
                    <tr style="height:50px;"></tr>
                    <tr style="height:700px;">
                        <td style="padding:10px 30px 30px 20px;vertical-align: top;" align="center">
                            <table style="border-collapse: collapse;width:100%;">
                                <tr style="border-bottom: 1px solid #198bb1;">
                                    <td style="padding: 10px;width: 40%;padding-left:30px;">
                                    <p style="font-family:Futura Cyrillic;font-size:11px;font-weight:700;line-height:14px;margin: 0px;">
                                      DESCRIPTION
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Futura Cyrillic;font-size:11px;font-weight:700;line-height:14px;margin: 0px;">
                                      UNIT PRICE
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Futura Cyrillic;font-size:11px;font-weight:700;line-height:14px;margin: 0px;">
                                      QTY
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Futura Cyrillic;font-size:11px;font-weight:700;line-height:14px;margin: 0px;">
                                      TOTAL
                                    </p>
                                    </td>
                                </tr>
                                @foreach ($products as $product)
                                <tr>
                                    <td style="padding: 10px;width: 40%;padding-left:30px;">
                                    <p style="font-family:Avenir;font-size:10px;font-weight:400;line-height:14px;margin: 0px;">
                                      {{ $product->name }}
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Avenir;font-size:10px;font-weight:400;line-height:14px;margin: 0px;">
                                      {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Avenir;font-size:10px;font-weight:400;line-height:14px;margin: 0px;">
                                      1
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Avenir;font-size:10px;font-weight:400;line-height:14px;margin: 0px;">
                                      {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}
                                    </p>
                                    </td>
                                </tr>
                                @endforeach
                                <tr style="border-top: 1px solid #198bb1;">
                                    <td colspan="2"></td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Futura Cyrillic;font-size: 10px;font-weight:600;line-height: 24px;margin: 0px;color: #198bb1;">
                                       SUBTOTAL
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Avenir;font-size:10px;font-weight:400;line-height:14px;margin: 0px;">
                                      {{ site_currency() . number_format($invoice_amount + $discount_amount ?? 0, 2) }}
                                    </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="vertical-align: top;padding-left:30px;" rowspan="2">
                                    <p style="font-family:Futura Cyrillic;font-size: 12px;font-weight:400;line-height: 24px;margin: 0px;color: #198bb1;">
                                      {{ $company_name }}
                                    </p>
                                    <p style="font-family:Avenir;font-size:7px;font-weight:400;line-height:14px;margin: 0px;">
                                      {!! $company_address !!}<br>
                                      {{ $company_mobile }}<br>
                                      {{ $company_email }}
                                    </p>
                                    </td>
                                    <td style="width: 20%;vertical-align: top;" align="center">
                                    <p style="font-family:Futura Cyrillic;font-size: 10px;font-weight:600;line-height: 14px;margin: 0px;color: #198bb1;">
                                       DISCOUNT
                                    </p>
                                    </td>
                                    <td style="width: 20%;vertical-align: top;" align="center">
                                    <p style="font-family:Avenir;font-size:10px;font-weight:400;line-height:14px;margin: 0px;">
                                      {{ site_currency() . number_format($discount_amount ?? 0, 2) }}
                                    </p>
                                    </td>
                                </tr>
                                <tr style="height:107px;">
                                  <td style="padding:0px 10px;width: 20%;" align="center">
                                    <p style="font-family:Futura Cyrillic;font-size: 12px;font-weight:600;line-height: 14px;margin: 0px;color:#ffffff;">
                                       TOTAL
                                    </p>
                                    </td>
                                    <td style="padding:0px 10px;width: 20%;padding-right: 35px;" align="center">
                                    <p style="font-family:Futura Cyrillic;font-size:18px;font-weight:700;line-height:14px;margin: 0px;color:#ffffff;">
                                      {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}
                                    </p>
                                    </td>
                                </tr>
                                
                            </table>
                        </td>
                    </tr>
                    <!-- Content End-->
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
