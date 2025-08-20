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
                <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);background: url('{{ $invoice_image1 }}');background-repeat: no-repeat;background-position: center;background-size:100% 100%;">
                    <!-- Content -->
                    <tr>
                        <td align="center" style="padding:40px;">
                          <table style="border-collapse: collapse;margin-top:100px;width: 100%;">
                            <tr>
                            <td style="vertical-align: top;" align="left">
                            <p style="font-family:MontSerrat;font-size:12px;font-weight:400;line-height: 24px;margin:0px;color:rgb(82, 80, 80);text-transform: uppercase;">
                              Invoice To : <b style="text-transform: capitalize;">{{ $customer_name ? $customer_name : '' }}</b>
                            </p>
                            <p style="font-family:MontSerrat;font-size:8px;font-weight:400;line-height:18px;margin:0px;color:rgb(82, 80, 80);">
                              Invoice Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:{{ $invoice_date }}
                            </p>
                            <p style="font-family:MontSerrat;font-size:8px;font-weight:400;line-height:18px;margin:0px;color:rgb(82, 80, 80);">
                              Invoice No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                               {{ $invoice_number }}
                            </p>
                            </td>   
                            </tr>
                          </table>
                            <table style="border-collapse: collapse;width:95%;margin-top:60px;">
                                <tr style="border-bottom: 1px solid #ffffff;">
                                    <td style="padding:10px;width: 40%;">
                                    <p style="font-family:MontSerrat;font-size:11px;font-weight:500;line-height:14px;margin: 0px;color: #ffffff;">
                                      ITEM DESCRIPTION
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:MontSerrat;font-size:11px;font-weight:500;line-height:14px;margin: 0px;color: #ffffff;">
                                      UNIT PRICE
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:MontSerrat;font-size:11px;font-weight:500;line-height:14px;margin: 0px;color: #ffffff;">
                                      QTY
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:MontSerrat;font-size:11px;font-weight:500;line-height:14px;margin: 0px;color: #ffffff;">
                                      TOTAL
                                    </p>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr>
                                  <td style="padding: 10px;width: 40%;">
                                    <p style="font-family:Avenir;font-size:8px;font-weight:400;line-height:14px;margin: 0px;color: #ffffff;">
                                      {{ $product->name }}
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Avenir;font-size:8px;font-weight:400;line-height:14px;margin: 0px;color: #ffffff;">
                                      {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Avenir;font-size:8px;font-weight:400;line-height:14px;margin: 0px;color: #ffffff;">
                                      1
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Avenir;font-size:8px;font-weight:400;line-height:14px;margin: 0px;color: #ffffff;">
                                      {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}
                                    </p>
                                  </td>
                                </tr>
                                @endforeach
                                {{-- <tr>
                                  <td style="padding: 10px;width: 40%;">
                                    <p style="font-family:Avenir;font-size:8px;font-weight:400;line-height:14px;margin: 0px;color: #ffffff;">
                                      Item Name
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Avenir;font-size:8px;font-weight:400;line-height:14px;margin: 0px;color: #ffffff;">
                                      $100.00
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Avenir;font-size:8px;font-weight:400;line-height:14px;margin: 0px;color: #ffffff;">
                                      2
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Avenir;font-size:8px;font-weight:400;line-height:14px;margin: 0px;color: #ffffff;">
                                      $300.00
                                    </p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="padding: 10px;width: 40%;">
                                    <p style="font-family:Avenir;font-size:8px;font-weight:400;line-height:14px;margin: 0px;color: #ffffff;">
                                      Item Name
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Avenir;font-size:8px;font-weight:400;line-height:14px;margin: 0px;color: #ffffff;">
                                      $100.00
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Avenir;font-size:8px;font-weight:400;line-height:14px;margin: 0px;color: #ffffff;">
                                      2
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Avenir;font-size:8px;font-weight:400;line-height:14px;margin: 0px;color: #ffffff;">
                                      $300.00
                                    </p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="padding: 10px;width: 40%;">
                                    <p style="font-family:Avenir;font-size:8px;font-weight:400;line-height:14px;margin: 0px;color: #ffffff;">
                                      Item Name
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Avenir;font-size:8px;font-weight:400;line-height:14px;margin: 0px;color: #ffffff;">
                                      $100.00
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Avenir;font-size:8px;font-weight:400;line-height:14px;margin: 0px;color: #ffffff;">
                                      2
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Avenir;font-size:8px;font-weight:400;line-height:14px;margin: 0px;color: #ffffff;">
                                      $300.00
                                    </p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="padding: 10px;width: 40%;">
                                    <p style="font-family:Avenir;font-size:8px;font-weight:400;line-height:14px;margin: 0px;color: #ffffff;">
                                      Item Name
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Avenir;font-size:8px;font-weight:400;line-height:14px;margin: 0px;color: #ffffff;">
                                      $100.00
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Avenir;font-size:8px;font-weight:400;line-height:14px;margin: 0px;color: #ffffff;">
                                      2
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center">
                                    <p style="font-family:Avenir;font-size:8px;font-weight:400;line-height:14px;margin: 0px;color: #ffffff;">
                                      $300.00
                                    </p>
                                  </td>
                                </tr>   --}}
                                <tr style="border-top: 1px solid #ffffff;">
                                    <td style="padding: 10px;"> 
                                    <p style="font-family:MontSerrat;font-size:10px;font-weight:400;line-height:18px;margin:0px;color:#ffffff;">
                                       SUBTOTAL   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                       {{ site_currency() . number_format($invoice_amount + $discount_amount ?? 0, 2) }}
                                    </p>  
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center" colspan="2" rowspan="2">
                                    <p style="font-family:MontSerrat;font-size: 10px;font-weight:700;line-height:24px;margin: 0px;color:#ffffff;">
                                       GRAND TOTAL
                                    </p>
                                    </td>
                                    <td style="padding: 10px;width: 20%;" align="center" rowspan="2">
                                    <p style="font-family:Avenir;font-size:20px;font-weight:600;line-height:24px;margin: 0px;color:#f35d2f;">
                                      {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}
                                    </p>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ffffff;">
                                    <td style="padding: 10px;" colspan="4">
                                    <p style="font-family:MontSerrat;font-size:10px;font-weight:400;line-height:18px;margin:0px;color:#ffffff;">
                                       SUBTOTAL   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                       {{ site_currency() . number_format($invoice_amount + $discount_amount ?? 0, 2) }}
                                    </p>  
                                    </td>
                                  </tr>
                                <tr>
                                    <td colspan="2" style="padding: 10px;">
                                      <p style="font-family:MontSerrat;font-size:12px;font-weight:400;line-height:18px;margin:0px;color:#ffffff;">
                                       THANK YOU
                                    </p>  
                                    </td>
                                    <td style="padding: 10px;width: 20%;padding-left: 40px;" align="left" colspan="2">
                                    <p style="font-family:MontSerrat;font-size:8px;font-weight:400;line-height: 24px;margin: 0px;color:#ffffff;">
                                       {{ $company_email }}
                                    </p>
                                     <p style="font-family:MontSerrat;font-size:8px;font-weight:400;line-height:14px;margin: 0px;color:#ffffff;">
                                      {!! $company_address !!}
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
