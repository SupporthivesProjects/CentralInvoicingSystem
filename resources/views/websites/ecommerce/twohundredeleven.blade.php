<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name . $invoice_number }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                     <!---header--->
                    <tr>
                        <td align="center">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
                                <tr>
                                <td align="center" style="width:30%;vertical-align: top;">
                                   <img src="{{ $invoice_image5 }}" alt="" style="height: 100px;">
                                </td>
                                <td align="center" style="width:70%;background:#8cc4de;vertical-align: top;">
                                   <table>
                                    <tr>
                                        <td align="center">
                                            <img src="{{ $invoice_image6 }}" alt="" style="width: 150px;">
                                        </td>
                                        <td align="right" style="padding: 20px;">
                                            <h1 style="color: #ffffff;margin: 0px;font-size: 42px;font-family: Roboto;line-height: 50px;">
                                                INVOICE
                                            </h1>
                                            <p style="color: #ffffff;margin: 0px;font-size: 10px;font-family: Roboto;line-height:12px;">
                                                Invoice No : {{ $invoice_number }}
                                            </p>
                                        </td>
                                    </tr>
                                   </table>
                                </td>
                                </tr>
                            </table>
                        </td>
                    </tr> 
                    <!---header End--->


                    <!-- Content -->
                    <tr>
                        <td align="center">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
                                <tr>
                                <td align="center" style="width:30%;vertical-align: top;"></td>
                                <td align="center" style="width:70%;background:#8cc4de;vertical-align: top;">
                                   <table>
                                    <tr style="height: 100px;"></tr>
                                   </table>
                                </td>
                                </tr>
                            </table>
                        </td>
                    </tr> 
                    <tr style="border-bottom: 2px solid #428bc2;;">
                        <td align="center">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
                                <tr>
                                <td align="left" style="width:30%;vertical-align:top;">
                                    <img src="{{ $invoice_image3 }}" alt="" style="height:250px;">
                                </td>
                                <td align="center" style="width:70%;background:#8cc4de;vertical-align:top;padding: 0px 30px;">
                                   <table style="width:100%;border-collapse: collapse;">
                                    <tr>
                                        <td align="left">
                                            <p style="color: #ffffff;margin: 0px;font-size: 14px;font-family: Roboto;line-height:24px;font-weight: 700;">
                                                Invoice To
                                            </p>
                                            <p style="color: #ffffff;margin: 0px;font-size:26px;font-family: Roboto;line-height:26px;font-weight: 700;">
                                                {{ $customer_name }}
                                            </p>
                                        </td>
                                        <td align="left" style="vertical-align: bottom;">
                                            <p style="color: #ffffff;margin: 0px;font-size: 10px;font-family: Roboto;line-height:12px;font-weight: 700;">
                                                Date :
                                            </p>
                                            <p style="color: #ffffff;margin: 0px;font-size:8px;font-family: Roboto;line-height:12px;">
                                                {{ $invoice_date }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <table style="width: 100%;border-collapse: collapse;margin-top: 10px;"> 
                                                <tr style="background: #428bc2;">
                                                    <td style="padding: 10px;width: 40%;">
                                                    <p style="color: #ffffff;margin: 0px;font-size:6px;font-family: Roboto;line-height:12px;font-weight: 700;">
                                                       ITEM DESCRIPTION
                                                    </p>
                                                    </td>
                                                    <td style="padding: 10px;width: 20%;" align="center">
                                                    <p style="color: #ffffff;margin: 0px;font-size:6px;font-family: Roboto;line-height:12px;font-weight: 700;">
                                                       UNIT PRICE
                                                    </p>
                                                    </td>
                                                    <td style="padding: 10px;width: 20%;" align="center">
                                                    <p style="color: #ffffff;margin: 0px;font-size:6px;font-family: Roboto;line-height:12px;font-weight: 700;">
                                                       QUANTITY
                                                    </p>
                                                    </td>
                                                    <td style="padding: 10px;width: 20%;" align="center">
                                                    <p style="color: #ffffff;margin: 0px;font-size:6px;font-family: Roboto;line-height:12px;font-weight: 700;">
                                                       TOTAL
                                                    </p>
                                                    </td>
                                                </tr>
                                                @foreach($products as $product)
                                                <tr style="background: #ffffff;">
                                                    <td style="padding: 10px;">
                                                    <p style="color: #000000;margin: 0px;font-size:6px;font-family: Roboto;line-height:12px;">
                                                       {{ $product->name }}
                                                    </p>
                                                    </td>
                                                    <td style="padding: 10px;" align="center">
                                                    <p style="color: #000000;margin: 0px;font-size:6px;font-family: Roboto;line-height:12px;">
                                                       {{ site_currency() . number_format($product->unit_price, 2) }}
                                                    </p>
                                                    </td>
                                                    <td style="padding: 10px;" align="center">
                                                    <p style="color: #000000;margin: 0px;font-size:6px;font-family: Roboto;line-height:12px;">
                                                       1
                                                    </p>
                                                    </td>
                                                    <td style="padding: 10px;" align="center">
                                                    <p style="color: #000000;margin: 0px;font-size:6px;font-family: Roboto;line-height:12px;">
                                                       {{ site_currency() . number_format($product->unit_price, 2) }}
                                                    </p>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                <tr style="height:30px;">
                                                    <td colspan="2"></td>
                                                    <td align="left">
                                                      <p style="color: #ffffff;margin: 0px;font-size:10px;font-family: Roboto;line-height:14px;">
                                                    Sub Total
                                                    </p> 
                                                    </td>
                                                    <td align="center">
                                                      <p style="color: #ffffff;margin: 0px;font-size:10px;font-family: Roboto;line-height:14px;">
                                                     {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                                    </p> 
                                                    </td>
                                                </tr>
                                                <tr style="height: 24px;">
                                                    <td colspan="2"></td>
                                                    <td align="left">
                                                      <p style="color: #ffffff;margin: 0px;font-size:10px;font-family: Roboto;line-height:14px;">
                                                    Tax
                                                    </p> 
                                                    </td>
                                                    <td align="center">
                                                      <p style="color: #ffffff;margin: 0px;font-size:10px;font-family: Roboto;line-height:14px;">
                                                     10%
                                                    </p> 
                                                    </td>
                                                </tr>
                                                <tr style="height: 24px;">
                                                    <td colspan="2"></td>
                                                    <td align="left">
                                                      <p style="color: #ffffff;margin: 0px;font-size:10px;font-family: Roboto;line-height:14px;">
                                                    Discount
                                                    </p> 
                                                    </td>
                                                    <td align="center">
                                                      <p style="color: #ffffff;margin: 0px;font-size:10px;font-family: Roboto;line-height:14px;">
                                                     {{ site_currency() . number_format($discount_amount, 2) }}
                                                    </p> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td colspan="2" align="left">
                                                    <p style="color: #ffffff;margin: 0px;font-size:16px;font-family: Roboto;line-height:24px;font-weight: 700;">
                                                     TOTAL
                                                    </p>
                                                    <p style="color: #ffffff;margin: 0px;font-size:30px;font-family: Roboto;line-height:30px;font-weight: 700;">
                                                        {{ site_currency() . number_format($invoice_amount, 2) }}
                                                    </p>
                                                    </td>
                                                </tr>
                                                <tr style="height:50px;"></tr>
                                            </table>        
                                        </td>
                                    </tr>
                                   </table>
                                </td>
                                </tr>
                            </table>
                        </td>
                    </tr> 
                    <!-- Content End-->  

                    <!---footer--->
                    <tr>
                        <td style="background:#8cc4de;height: 100px;padding:20px;">
                            <table width="100%">
                                <tr>
                                    <td>
                                       <table>
                                        <tr>
                                            <td style="display: flex;justify-content:left;align-items: center;gap:10px">
                                                <img src="{{ $invoice_image1 }}" alt="" style="height:20px;">
                                                <p style="color: #ffffff;margin: 0px;font-size:9px;font-family: Roboto;">
                                             {{ $site_name }}
                                            </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="display: flex;justify-content:left;align-items: center;gap:10px">
                                                <img src="{{ $invoice_image2 }}" alt="" style="height:20px;">
                                                <p style="color: #ffffff;margin: 0px;font-size:9px;font-family: Roboto;line-height:24px;">
                                             {{ $company_email }}
                                            </p>
                                            </td>
                                           
                                        </tr>
                                       </table>
                                    </td>
                                    <td align="right">
                                      <p style="color: #ffffff;margin: 0px;font-size:9px;font-family: Roboto;line-height:12px;">
                                       {{ $company_name }}
                                      </p>
                                      <p style="color: #ffffff;margin: 0px;font-size:9px;font-family: Roboto;line-height:12px;">
                                       {!! $company_address !!}<br>
                                       {{ $company_mobile }}
                                      </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr> 
                    <!---footer End--->
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
