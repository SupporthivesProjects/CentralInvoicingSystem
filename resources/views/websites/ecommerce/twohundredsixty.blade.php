<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }}</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding:0px;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#19144C" style="border-collapse: collapse;background:#19144C;height:95vh !important;">
                    <!-- Header -->
                     <tr style="height:125px;">
                      <td align="center" style="padding:40px;">
                        <img src="{{ $company_logo }}" alt="" style="height:60px;">
                      </td>
                     </tr>
                    <tr style="background-position:center;background-size:cover;text-align: center;width: 100%;">
                        <td align="center">
                            <table style="width:80%;">
                                <tr style="height:70px;vertical-align:top;">
                                <td>
                                  <p style="color: #F9BE02;margin:0px;font-family:Heebo;font-size:26px;font-weight: 800;">Invoice</p>
                                </td>
                                <td align="right">
                                  <p style="color: #F9BE02;margin:0px;font-family:Heebo;font-size:11px;font-weight: 800;">
                                    INVOICE # <span style="color: #ffffff;">{{ $invoice_number }}</span>
                                  </p>
                                  <p style="color: #F9BE02;margin:0px;font-family:Heebo;font-size:11px;font-weight: 800;">
                                    Date <span style="color: #ffffff;">{{ $invoice_date }}</span>
                                  </p>
                                </td>
                               </tr>
                               <tr style="height: 16px;"></tr>
                                <tr style="height:70px;vertical-align:top;">
                                <td>
                                  <p style="color: #FFFFFF;margin:0px;font-family:Heebo;font-size:11px;font-weight: 800;line-height:140%;">
                                    {!! $company_address !!}<br>
                                    <a href="#">{{ $company_email }}</a> <br>
                                    <a href="#" style="color: #FFFFFF;margin:0px;font-family:Heebo;font-size:11px;font-weight: 800;line-height:140%;text-decoration:none;">
                                      {{ $site_name }}
                                    </a>  
                                  </p>
                                </td>
                                <td align="right">
                                  <p style="color: #F9BE02;margin:0px;font-family:Heebo;font-size:11px;font-weight: 800;">
                                   TO
                                  </p>
                                  <p style="color: #ffffff;margin:0px;font-family:Heebo;font-size:11px;font-weight: 800;">
                                    {{ $customer_name  }}
                                  </p>
                                </td>
                               </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                    <!-- Content -->
                    <tr style="height:40px;"></tr>
                    <tr>
                        <td align="center">
                        <table style="width:80%;">

                         <tr>
                            <td>
                                <table width="100%" border="1" cellspacing="0" cellpadding="0">
                                    <tr style="height: 24px;">
                                      <td>
                                       <p style="color: #F9BE02;margin:0px;font-family:Heebo;font-size:11px;font-weight: 800;">Description</p>
                                     </td>
                                     <td align="right">
                                       <p style="color: #F9BE02;margin:0px;font-family:Heebo;font-size:11px;font-weight: 800;">Amount</p>
                                     </td>
                                    </tr>
                                     @foreach($products as $product)
                                    <tr style="height: 24px;">
                                      <td>
                                       <p style="color: #FFFFFF;margin:0px;font-family:Heebo;font-size:11px;font-weight:500;">{{ $product->name  }}</p>
                                     </td>
                                     <td align="right">
                                       <p style="color: #FFFFFF;margin:0px;font-family:Heebo;font-size:11px;font-weight:500;">{{ site_currency() }}{{ number_format($product->unit_price, 2) }}</p>
                                     </td>
                                    </tr>
                                    @endforeach
                                    
                                    
                                    
                                    
                                    
                                    <tr style="height: 24px;">
                                      <td>
                                       <p style="color: #FFFFFF;margin:0px;font-family:Heebo;font-size:11px;font-weight: 500;">Subtotal</p>
                                     </td>
                                     <td align="right">
                                       <p style="color: #FFFFFF;margin:0px;font-family:Heebo;font-size:11px;font-weight: 500;">{{ site_currency() }}{{ number_format(($invoice_amount + $discount_amount), 2) }}</p>
                                     </td>
                                    </tr>
                                    <tr style="height: 24px;">
                                      <td>
                                       <p style="color: #F9BE02;margin:0px;font-family:Heebo;font-size:11px;font-weight: 500;">Total</p>
                                     </td>
                                     <td align="right">
                                       <p style="color: #F9BE02;margin:0px;font-family:Heebo;font-size:11px;font-weight: 500;">{{ site_currency() }}{{ number_format($invoice_amount, 2) }}</p>
                                     </td>
                                    </tr>
                                </table>
                            </td>
                         </tr>
                        </table>
                        </td>
                    </tr>
                    <!-- Content End-->
                     <tr style="height:150px;">
                      <td align="center">
                      <p style="color: #ffffff;margin:0px;font-family:Heebo;font-size:11px;font-weight: 800;line-height:150%;">
                         If you have any questions concerning this invoice, contact | {{ $company_mobile }} |<br> {{ $company_email }}
                      </p>
                      <p style="color: #F9BE02;margin:0px;font-family:Heebo;font-size:11px;font-weight: 800;line-height:150%;text-transform:uppercase">
                        Thank you for your business!
                      </p>
                      </td>
                     </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
