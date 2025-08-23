<!DOCTYPE html>
<html>
<head>
    <title>Your Email Title</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
</head>
<body style="margin: 0px; padding: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                     <!---header--->
                    <tr> 
                        <td align="right" style="background: url('{{ $invoice_header_image }}');background-repeat:no-repeat;background-position:center;background-size:cover;height:180px;vertical-align:center;padding-right:35px;">
                          <p style="margin-top:90px;font-size:9px;font-family: DM Sans;line-height:12px;color: #ffffff;font-weight:500;">
                           Invoice #{{ $invoice_number }}.   <span style="margin-left:70px;"></span>
                           {{ $invoice_date }}
                         </p>
                        </td>
                    </tr> 
                    <!---header End--->

                    <!-- Content -->
                    <tr>
                        <td style="padding:0px 40px;background: url(img/body.png);background-repeat:no-repeat;background-position:center;background-size:cover;" align="center">
                           <table style="width: 100%;border-collapse: collapse;" width="100%">
                              <tr>
                                 <td style="padding:10px;vertical-align: top;">
                                    <p style="margin: 0px;font-size:14px;font-weight:500;font-family:DM Sans;line-height:24px;color: #ffffff;">
                                      Invoice To:
                                    </p>
                                    <h1 style="margin: 0px;font-size:20px;font-weight:700;font-family:DM Sans;line-height:24px;color: #ffffff;">
                                      {{ $customer_name ? $customer_name : '' }}
                                    </h1>
                                 </td>
                                 <td style="padding:10px;vertical-align: top;" align="right">
                                    <p style="margin: 0px;font-size:14px;font-weight:500;font-family:DM Sans;line-height:24px;color: #ffffff;">
                                      Total Due
                                    </p>
                                    <h1 style="margin: 0px;font-size:31px;font-weight:700;font-family:DM Sans;line-height:34px;color: #ffffff;">
                                      {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}
                                    </h1>
                                 </td>
                              </tr> 
                              <tr>
                                 <td colspan="2">
                                  <div style="min-height: 555px;">
                                    <table style="border-collapse: collapse;margin:20px 0px;" width="100%">
                                       <tr style="background: #fd8488;">
                                          <td style="padding: 10px;width: 50%;">
                                          <p style="margin: 0px;font-size:11px;font-family:DM Sans;line-height:24px;color: #ffffff;font-weight:600;">
                                            ITEM DESCRIPTION
                                          </p>
                                          </td>
                                          <td style="padding: 10px;width: 20%;" align="center">
                                          <p style="margin: 0px;font-size:11px;font-family:DM Sans;line-height:24px;color: #ffffff;font-weight:600;">
                                            UNIT PRICE
                                          </p>
                                          </td>
                                          <td style="padding: 10px;width: 10%;" align="center">
                                          <p style="margin: 0px;font-size:11px;font-family:DM Sans;line-height:24px;color: #ffffff;font-weight:600;">
                                            QTY
                                          </p>
                                          </td>
                                          <td style="padding: 10px;width: 20%;" align="center">
                                          <p style="margin: 0px;font-size:11px;font-family:DM Sans;line-height:24px;color: #ffffff;font-weight:600;">
                                            TOTAL
                                          </p>
                                          </td>
                                       </tr>
                                       @foreach ($products as $product)
                                       <tr style="background: #fea0a8;">
                                          <td style="padding: 10px;width: 50%;">
                                          <p style="margin: 0px;font-size:10px;font-family:DM Sans;line-height:14px;color: #ffffff;font-weight:600;">
                                            {{ $product->name }}
                                          </p>
                                          <p style="margin: 0px;font-size:8px;font-family:DM Sans;line-height:14px;color: #ffffff;">
                                            
                                          </p>
                                          </td>
                                          <td style="padding: 10px;width: 20%;" align="center">
                                          <p style="margin: 0px;font-size:10px;font-family:DM Sans;line-height:24px;color: #ffffff;">
                                            {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}
                                          </p>
                                          </td>
                                          <td style="padding: 10px;width: 10%;" align="center">
                                          <p style="margin: 0px;font-size:10px;font-family:DM Sans;line-height:24px;color: #ffffff;">
                                            1
                                          </p>
                                          </td>
                                          <td style="padding: 10px;width: 20%;" align="center">
                                          <p style="margin: 0px;font-size:10px;font-family:DM Sans;line-height:24px;color: #ffffff;">
                                            {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}
                                          </p>
                                          </td>
                                       </tr>
                                       @endforeach
                                       {{-- <tr style="background: #ffb5b7;">
                                          <td style="padding: 10px;width: 50%;">
                                          <p style="margin: 0px;font-size:10px;font-family:DM Sans;line-height:14px;color: #ffffff;font-weight:600;">
                                            Item Name
                                          </p>
                                          <p style="margin: 0px;font-size:8px;font-family:DM Sans;line-height:14px;color: #ffffff;">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                          </p>
                                          </td>
                                          <td style="padding: 10px;width: 20%;" align="center">
                                          <p style="margin: 0px;font-size:10px;font-family:DM Sans;line-height:24px;color: #ffffff;">
                                            $20.00
                                          </p>
                                          </td>
                                          <td style="padding: 10px;width: 10%;" align="center">
                                          <p style="margin: 0px;font-size:10px;font-family:DM Sans;line-height:24px;color: #ffffff;">
                                            1
                                          </p>
                                          </td>
                                          <td style="padding: 10px;width: 20%;" align="center">
                                          <p style="margin: 0px;font-size:10px;font-family:DM Sans;line-height:24px;color: #ffffff;">
                                            $20.00
                                          </p>
                                          </td>
                                       </tr>
                                       <tr style="background: #fea0a8;">
                                          <td style="padding: 10px;width: 50%;">
                                          <p style="margin: 0px;font-size:10px;font-family:DM Sans;line-height:14px;color: #ffffff;font-weight:600;">
                                            Item Name
                                          </p>
                                          <p style="margin: 0px;font-size:8px;font-family:DM Sans;line-height:14px;color: #ffffff;">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                          </p>
                                          </td>
                                          <td style="padding: 10px;width: 20%;" align="center">
                                          <p style="margin: 0px;font-size:10px;font-family:DM Sans;line-height:24px;color: #ffffff;">
                                            $20.00
                                          </p>
                                          </td>
                                          <td style="padding: 10px;width: 10%;" align="center">
                                          <p style="margin: 0px;font-size:10px;font-family:DM Sans;line-height:24px;color: #ffffff;">
                                            1
                                          </p>
                                          </td>
                                          <td style="padding: 10px;width: 20%;" align="center">
                                          <p style="margin: 0px;font-size:10px;font-family:DM Sans;line-height:24px;color: #ffffff;">
                                            $20.00
                                          </p>
                                          </td>
                                       </tr>
                                       <tr style="background: #ffb5b7;">
                                          <td style="padding: 10px;width: 50%;">
                                          <p style="margin: 0px;font-size:10px;font-family:DM Sans;line-height:14px;color: #ffffff;font-weight:600;">
                                            Item Name
                                          </p>
                                          <p style="margin: 0px;font-size:8px;font-family:DM Sans;line-height:14px;color: #ffffff;">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                          </p>
                                          </td>
                                          <td style="padding: 10px;width: 20%;" align="center">
                                          <p style="margin: 0px;font-size:10px;font-family:DM Sans;line-height:24px;color: #ffffff;">
                                            $20.00
                                          </p>
                                          </td>
                                          <td style="padding: 10px;width: 10%;" align="center">
                                          <p style="margin: 0px;font-size:10px;font-family:DM Sans;line-height:24px;color: #ffffff;">
                                            1
                                          </p>
                                          </td>
                                          <td style="padding: 10px;width: 20%;" align="center">
                                          <p style="margin: 0px;font-size:10px;font-family:DM Sans;line-height:24px;color: #ffffff;">
                                            $20.00
                                          </p>
                                          </td>
                                       </tr>
                                       <tr style="background: #fea0a8;">
                                          <td style="padding: 10px;width: 50%;">
                                          <p style="margin: 0px;font-size:10px;font-family:DM Sans;line-height:14px;color: #ffffff;font-weight:600;">
                                            Item Name
                                          </p>
                                          <p style="margin: 0px;font-size:8px;font-family:DM Sans;line-height:14px;color: #ffffff;">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                          </p>
                                          </td>
                                          <td style="padding: 10px;width: 20%;" align="center">
                                          <p style="margin: 0px;font-size:10px;font-family:DM Sans;line-height:24px;color: #ffffff;">
                                            $20.00
                                          </p>
                                          </td>
                                          <td style="padding: 10px;width: 10%;" align="center">
                                          <p style="margin: 0px;font-size:10px;font-family:DM Sans;line-height:24px;color: #ffffff;">
                                            1
                                          </p>
                                          </td>
                                          <td style="padding: 10px;width: 20%;" align="center">
                                          <p style="margin: 0px;font-size:10px;font-family:DM Sans;line-height:24px;color: #ffffff;">
                                            $20.00
                                          </p>
                                          </td>
                                       </tr> --}}
                                       <tr style="height: 10px;"></tr>
                                       <tr>
                                          <td colspan="4" style="border-top: 1px solid #ffffff;height: 10px;"></td>
                                       </tr>
                                       <tr>
                                          <td colspan="4" align="center">
                                          <table style="width:80%;border-collapse: collapse;">
                                             <tr>
                                                <td style="padding:0px 10px;" align="center">
                                                <p style="margin: 0px;font-size:12px;font-family:DM Sans;line-height:24px;color: #ffffff;font-weight: 700;">
                                                SUBTOTAL
                                                </p>
                                                </td>
                                                <td style="padding:0px 10px;" align="center">
                                                <p style="margin: 0px;font-size:12px;font-family:DM Sans;line-height:24px;color: #ffffff;">
                                               {{ site_currency() . number_format($invoice_amount + $discount_amount ?? 0, 2) }}
                                                </p>
                                                </td>
                                                <td style="padding:0px 10px;border-left: 1px solid #ffffff;" align="center">
                                                <p style="margin: 0px;font-size:12px;font-family:DM Sans;line-height:24px;color: #ffffff;font-weight: 700;">
                                                DISCOUNT
                                                </p>
                                                </td>
                                                <td style="padding:0px 10px;" align="center">
                                                <p style="margin: 0px;font-size:12px;font-family:DM Sans;line-height:24px;color: #ffffff;">
                                                {{ site_currency() . number_format($discount_amount ?? 0, 2) }}
                                                </p>
                                                </td>
                                             </tr>
                                          </table>
                                          </td>
                                       </tr>
                                    </table>
                                    </div>
                                 </td>
                              </tr>
                           </table>
                        </td>   
                    </tr>
                    <!-- Content End-->

                  <!--footer-->
                  <tr> 
                        <td style="padding:0px 30px;background: url('{{ $invoice_footer_image }}');background-repeat: no-repeat;background-position: center;background-size: cover;height:280px;" align="right">
                         <p style="margin: 0px;font-size: 10px;font-family: DM Sans;font-weight: 700;color: #ff8a8e;line-height: 16px;">
                           {{ $company_name }}
                         </p>
                         <p style="margin: 0px;font-size:7px;font-family: DM Sans;line-height: 12px;">
                           Lorem ipsum dolor sit amet, consectetur adipiscing <br>
                           elit, sed do eiusmod tempor incididunt ut labore et <br>
                           dolore magna aliqua. Ut enim ad minim veniam
                         </p>
                        </td>
                  </tr> 
                  <!--footer end-->
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
