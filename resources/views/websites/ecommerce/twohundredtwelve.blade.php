<!DOCTYPE html>
<html>
<head>
    <title>Your Email Title</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body style="margin: 0px; padding: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                     <!---header--->
                    <tr> 
                        <td align="center" style="padding: 20px 20px;background: url('{{ $invoice_header_image }}');background-repeat: no-repeat;background-position: center;background-size: cover;height:80px;">
                          <img src="{{ $company_logo }}" alt="" style="height:40px;">
                        </td>
                    </tr> 
                    <!---header End--->

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px;" align="center">
                           <table style="width: 100%;border-collapse: collapse;">
                              <tr style="border: 1px solid rgb(215, 208, 208);">
                                 <td align="center" colspan="3" style="padding: 10px;">
                                    <p style="margin: 0px;font-size:36px;font-weight:500;font-family:Baskerville;line-height:42px;">
                                      Invoice
                                    </p>
                                 </td>
                              </tr>
                              <tr style="height:20px;"></tr>
                              <tr style="border: 1px solid rgb(215, 208, 208);">
                                 <td style="width: 30%;padding: 10px;border-right: 1px solid rgb(215, 208, 208);">
                                    <p style="margin: 0px;font-size:11px;font-weight:700;font-family:poppins;line-height:14px;text-transform: uppercase;">
                                      DATE of poppins: 
                                    </p>
                                    <p style="margin: 0px;font-size:9px;font-weight:400;font-family:Baskerville;line-height:14px;">
                                      {{ $invoice_date }}
                                    </p>
                                 </td>
                                 <td align="center" style="width:40%;padding: 10px;border-right: 1px solid rgb(215, 208, 208);">
                                    <p style="margin: 0px;font-size:11px;font-weight:700;font-family:poppins;line-height:14px;text-transform: uppercase;">
                                      INVOICE no:
                                    </p>
                                    <p style="margin: 0px;font-size:9px;font-weight:400;font-family:Baskerville;line-height:14px;">
                                      #{{ $invoice_number }}
                                    </p>
                                 </td>
                                 <td align="right" style="width:30%;padding: 10px;">
                                    <p style="margin: 0px;font-size:11px;font-weight:700;font-family:poppins;line-height:14px;text-transform: uppercase;">
                                      invoiced To:  
                                    </p>
                                    <p style="margin: 0px;font-size:9px;font-weight:400;font-family:Baskerville;line-height:14px;">
                                      {{ $customer_name ? $customer_name : '' }}
                                    </p>
                                 </td>
                              </tr>
                           </table>
                           <div style="min-height: 520px;">
                              <table style="width: 100%;border-collapse: collapse;margin-top: 40px;">
                                 <tr style="background: #6e7160;">
                                    <td style="padding: 5px 10px;">
                                       <p style="margin: 0px;font-size:11px;font-weight:700;font-family:poppins;line-height:24px;text-transform:uppercase;color:#ffffff;">
                                       Qty   
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;">
                                       <p style="margin: 0px;font-size:11px;font-weight:700;font-family:poppins;line-height:24px;text-transform:uppercase;color:#ffffff;">
                                       Item Description  
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;" align="right">
                                       <p style="margin: 0px;font-size:11px;font-weight:700;font-family:poppins;line-height:24px;text-transform:uppercase;color:#ffffff;">
                                       Delivery  
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;" align="right">
                                       <p style="margin: 0px;font-size:11px;font-weight:700;font-family:poppins;line-height:24px;text-transform:uppercase;color:#ffffff;">
                                       Total   
                                       </p>
                                    </td>
                                 </tr>
                                 @foreach ($products as $product)
                                 <tr style="background:#f1f1f1;height: 24px;">
                                    <td style="padding: 5px 10px;">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                       1  
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                       Wedding Thank You Note Design  
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;" align="right">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                       Urgent (+$35)  
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;" align="right">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                       {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}   
                                       </p>
                                    </td>
                                 </tr>
                                 @endforeach
                                 {{-- <tr style="height: 24px;">
                                    <td style="padding: 5px 10px;">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                       1  
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                       Wedding Thank You Note Design  
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;" align="right">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                       Urgent (+$35)  
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;" align="right">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                       {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}  
                                       </p>
                                    </td>
                                 </tr> --}}
                                 {{-- <tr style="background:#f1f1f1;height: 24px;">
                                    <td style="padding: 5px 10px;">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                       
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                          
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;" align="right">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                       
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;" align="right">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                          
                                       </p>
                                    </td>
                                 </tr>
                                 <tr style="height: 24px;">
                                    <td style="padding: 5px 10px;">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                       
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                          
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;" align="right">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                          
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;" align="right">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                          
                                       </p>
                                    </td>
                                 </tr>
                                 <tr style="background:#f1f1f1;height: 24px;">
                                    <td style="padding: 5px 10px;">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                       
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                          
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;" align="right">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                       
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;" align="right">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                          
                                       </p>
                                    </td>
                                 </tr>
                                 <tr style="height: 24px;">
                                    <td style="padding: 5px 10px;">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                       
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                          
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;" align="right">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                          
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;" align="right">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                          
                                       </p>
                                    </td>
                                 </tr> --}}
                                 <tr style="background:#ffffff;height: 24px;">
                                    <td style="padding: 5px 10px;">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;" align="right">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;" align="right">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                       </p>
                                    </td>
                                 </tr>
                                 <tr style="height: 24px;">
                                    <td style="padding: 5px 10px;" colspan="2"></td>
                                    <td style="padding: 5px 10px;background:#f1f1f1;" align="left">
                                       <p style="margin: 0px;font-size:11px;font-weight:700;font-family:poppins;line-height:14px;text-transform: uppercase;">
                                       Subtotal
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;background:#f1f1f1;" align="right">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                          {{ site_currency() . number_format($invoice_amount + $discount_amount ?? 0, 2) }}
                                       </p>
                                    </td>
                                 </tr>
                                 <tr style="height: 24px;">
                                    <td style="padding: 5px 10px;" colspan="2"></td>
                                    <td style="padding: 5px 10px;" align="left">
                                       <p style="margin: 0px;font-size:11px;font-weight:700;font-family:poppins;line-height:14px;text-transform: uppercase;">
                                       Discount
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;" align="right">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                          {{ site_currency() . number_format($discount_amount ?? 0, 2) }}
                                       </p>
                                    </td>
                                 </tr>
                                 <tr style="height: 24px;">
                                    <td style="padding: 5px 10px;" colspan="2"></td>
                                    <td style="padding: 5px 10px;background:#f1f1f1;" align="left">
                                       <p style="margin: 0px;font-size:11px;font-weight:700;font-family:poppins;line-height:14px;text-transform: uppercase;">
                                       Total Paid 
                                       </p>
                                    </td>
                                    <td style="padding: 5px 10px;background:#f1f1f1;" align="right">
                                       <p style="margin: 0px;font-size:9px;font-weight:400;font-family:poppins;line-height:14px;color:#6e7160;">
                                          {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}
                                       </p>
                                    </td>
                                 </tr>
                              </table>
                           </div>
                        </td>   
                    </tr>
                    <!-- Content End-->

                  <!--footer-->
                  <tr> 
                        <td style="padding:20px 20px;background: url('{{ $invoice_footer_image }}');background-repeat: no-repeat;background-position: center;background-size: cover;height:260px;vertical-align: top;padding-left: 40px;">
                          <table style="border-collapse: collapse;width:40%;">
                              <tr>
                                 <td colspan="2">
                                    <p style="margin: 0px;font-size:12px;font-weight:400;font-family:Baskerville;line-height:24px;">
                                      Contact Information
                                    </p>
                                 </td>
                              </tr>
                              <tr style="height:15px;"></tr>
                              <tr>
                                 <td>
                                    <p style="margin: 0px;font-size:7.5px;font-weight:400;font-family:Baskerville;line-height:14px;">
                                      {!! $company_address !!}
                                    </p>
                                 </td>
                                 <td style="padding-left: 30px;">
                                     <p style="margin: 0px;font-size:7.5px;font-weight:400;font-family:Baskerville;line-height:14px;">
                                      {{ $company_email }}
                                    </p>
                                     <p style="margin: 0px;font-size:7.5px;font-weight:400;font-family:Baskerville;line-height:14px;">
                                      {{ $company_mobile }}
                                    </p>
                                     <p style="margin: 0px;font-size:7.5px;font-weight:400;font-family:Baskerville;line-height:14px;">
                                     {{ $site_name }}
                                    </p>
                                 </td>
                              </tr>
                          </table>
                        </td>
                  </tr> 
                  <!--footer end-->
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
