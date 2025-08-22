<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                     <!---header--->
                    <tr> 
                        <td style="padding: 20px 20px;background: url('{{ $invoice_header_image }}');background-repeat: no-repeat;background-position: center;background-size: cover;height:80px;padding-left:30px;padding-top: 30px;">
                          <img src="{{ $company_logo }}" alt="" style="height:50px;">
                        </td>
                    </tr> 
                    <!---header End--->

                    <!-- Content -->
                    <tr>
                        <td align="center">
                           <table style="width:90%;border-collapse: collapse;margin-top: 40px;">
                            <tr>
                              <td style="width: 70%;vertical-align: top;">
                                <p style="margin: 0px;font-size:12px;font-weight:600;font-family:Lato;line-height:24px;color: #000000;">
                                    Invoice To : 
                                </p>
                                <p style="margin: 0px;font-size:17px;font-weight:600;font-family:Lato;line-height:24px;color: #d81d3f;">
                                 {{ $customer_name ? $customer_name : '' }}
                                </p>
                                <p style="margin: 0px;font-size:10px;font-weight:400;font-family:Lato;line-height:24px;color: #000000;">
                                 {{ $customer_email ? $customer_email : '' }}<br>
                                 {{ $customer_mobile ? $customer_mobile : '' }}
                                </p>
                              </td>
                              <td style="vertical-align: top;">
                                 <h1 style="margin: 0px;font-size:43px;font-weight:700;font-family:Lato;line-height:50px;color: #d81d3f;text-transform: uppercase;">
                                    Invoice
                                 </h1>
                                 <p style="margin: 0px;font-size:12px;font-weight:600;font-family:Lato;line-height:24px;color: #000000;">
                                    #{{ $invoice_number }}
                                </p>
                                <p style="margin: 0px;font-size:12px;font-weight:600;font-family:Lato;line-height:24px;color: #000000;">
                                 {{ $invoice_date }}
                                </p>
                              </td>
                            </tr>
                           </table>
                           <table style="width: 100%;border-collapse: collapse;margin-top: 40px;">
                              <tr>
                                 <td style="padding: 5px 10px;background:#1d1c20;padding-left: 30px;" align="center">
                                    <p style="margin: 0px;font-size:11px;font-weight:700;font-family:Lato;line-height:24px;text-transform:uppercase;color:#ffffff;">
                                      NO   
                                    </p>
                                 </td>
                                 <td style="padding: 5px 10px;background:#1d1c20;">
                                    <p style="margin: 0px;font-size:11px;font-weight:700;font-family:Lato;line-height:24px;text-transform:uppercase;color:#ffffff;">
                                      Description  
                                    </p>
                                 </td>
                                 <td style="padding: 5px 10px;background:#d51240;" align="center">
                                    <p style="margin: 0px;font-size:11px;font-weight:700;font-family:Lato;line-height:24px;text-transform:uppercase;color:#ffffff;">
                                      UNIT PRICE  
                                    </p>
                                 </td>
                                 <td style="padding: 5px 10px;background:#d51240;" align="center">
                                    <p style="margin: 0px;font-size:11px;font-weight:700;font-family:Lato;line-height:24px;text-transform:uppercase;color:#ffffff;">
                                      QTY
                                    </p>
                                 </td>
                                 <td style="padding: 5px 10px;background:#d51240;" align="center">
                                    <p style="margin: 0px;font-size:11px;font-weight:700;font-family:Lato;line-height:24px;text-transform:uppercase;color:#ffffff;">
                                      Total   
                                    </p>
                                 </td>
                              </tr>
                              @foreach ($products as $product)
                              <tr style="height:50px;">
                                 <td style="padding: 5px 10px;padding-left: 30px;" align="center">
                                    <p style="margin: 0px;font-size:11px;font-weight:700;font-family:Lato;line-height:14px;">
                                       {{ $loop->iteration }}
                                    </p>
                                 </td>
                                 <td style="padding: 5px 10px;">
                                    <p style="margin: 0px;font-size:10px;font-weight:700;font-family:Lato;line-height:14px;">
                                       {{ $product->name }}
                                    </p>
                                    <p style="margin: 0px;font-size:8px;font-weight:400;font-family:Lato;line-height:14px;">
                                       {!! \Illuminate\Support\Str::limit(strip_tags($product->description), 100) !!}
                                    </p>
                                 </td>
                                 <td style="padding: 5px 10px;" align="center">
                                    <p style="margin: 0px;font-size:10px;font-weight:700;font-family:Lato;line-height:14px;">
                                       {{ site_currency() }} {{  number_format($product->unit_price, 2) }}
                                    </p>
                                 </td>
                                <td style="padding: 5px 10px;" align="center">
                                    <p style="margin: 0px;font-size:10px;font-weight:700;font-family:Lato;line-height:14px;">
                                      1
                                    </p>
                                 </td>
                                 <td style="padding: 5px 10px;" align="center">
                                    <p style="margin: 0px;font-size:10px;font-weight:700;font-family:Lato;line-height:14px;">
                                       {{ site_currency() }} {{  number_format($product->unit_price, 2) }}
                                    </p>
                                 </td>
                              </tr>
                              @endforeach
                              <tr style="height:50px;">
                                 <td style="padding: 5px 10px;" colspan="2"></td>
                                 <td style="padding: 5px 10px;" align="right" colspan="2">
                                     <p style="margin: 0px;font-size:9px;font-weight:600;font-family:Lato;line-height:14px;text-transform: uppercase;">
                                      Sub Total
                                    </p>
                                 </td>
                                 <td style="padding: 5px 10px;" align="center">
                                    <p style="margin: 0px;font-size:10px;font-weight:700;font-family:Lato;line-height:14px;">
                                       {{ site_currency() . number_format($invoice_amount + $discount_amount ?? 0, 2) }}
                                    </p>
                                 </td>
                              </tr>
                              <tr style="height:50px;">
                                 <td style="padding: 5px 10px;" colspan="2"></td>
                                 <td style="padding: 5px 10px;" align="right" colspan="2">
                                     <p style="margin: 0px;font-size:9px;font-weight:600;font-family:Lato;line-height:14px;text-transform: uppercase;">
                                     Discount
                                    </p>
                                 </td>
                                 <td style="padding: 5px 10px;" align="center">
                                    <p style="margin: 0px;font-size:10px;font-weight:700;font-family:Lato;line-height:14px;">
                                       {{ site_currency() . number_format($discount_amount ?? 0, 2) }}
                                    </p>
                                 </td>
                              </tr>
                               <tr style="height: 20px;"></tr>
                              <tr style="height:50px;">
                                 <td style="padding: 5px 20px;" colspan="3">
                                 <p style="margin: 0px;font-size:10px;font-weight:600;font-family:Lato;line-height:14px;color: #d81d3f;">
                                    {{ $company_name }}<br>
                                    {!! $company_address !!}
                                </p>
                                <p style="margin: 0px;font-size:7px;font-weight:400;font-family:Lato;line-height:14px;">
                                 {{ $company_mobile }} 
                                </p>
                                 </td>
                                 <td style="padding: 5px 10px;background: #d81d3f;" align="right">
                                     <p style="margin: 0px;font-size:11px;font-weight:700;font-family:Lato;line-height:14px;color: #ffffff;">
                                     Grand Total
                                    </p>
                                 </td>
                                 <td style="padding: 5px 10px;background: #d81d3f;" align="center">
                                    <p style="margin: 0px;font-size:12px;font-weight:700;font-family:Lato;line-height:14px;color: #ffffff;">
                                       {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}
                                    </p>
                                 </td>
                              </tr>
                           </table>
                           <table style="border-collapse:collapse;width:95%;margin-top: 40px;margin-bottom: 40px;">
                               <tr>
                                 <td align="left">
                                 <p style="margin: 0px;font-size:26px;font-weight:700;font-family:Lato;line-height:30px;color: #d81d3f;">
                                    Thank You for Purchasing!
                                </p>
                                 </td>
                                 <td align="right">
                                 <p style="margin: 0px;font-size:8px;font-weight:400;font-family:Lato;line-height:14px;">
                                    {{ $company_email }}
                                </p>
                                 </td>
                               </tr>
                           </table>
                        </td>   
                    </tr>
                    <!-- Content End-->

                  <!--footer-->
                  <tr> 
                        <td style="background: url('{{ $invoice_footer_image }}');background-repeat: no-repeat;background-position: center;background-size: cover;height:40px;">
                          
                        </td>
                  </tr> 
                  <!--footer end-->
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
