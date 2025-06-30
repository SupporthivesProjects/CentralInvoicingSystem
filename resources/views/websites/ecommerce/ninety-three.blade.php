<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                      <tr style=" background: url('{{ $invoice_header_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;height: 130px;">
                        <td></td>
                      </tr>
                     <tr style=" background: url('{{ $invoice_image1 }}');background-repeat: no-repeat;background-size: cover;background-position: center;">
                        <td style="padding:72px; padding-bottom: 100px; padding-top: 10px;">

                            <table style="width: 100%;font-family: Arial, Helvetica, sans-serif;">
                            
                                <tr>
                                    <td>
                                        <p style="font-size: 12px; margin: 0;"><b>Date: </b>{{ $invoice_date }}</p>
                                        <p style="font-size: 12px;margin: 0; "><b>Invoice Number: </b># {{ $invoice_number }}</p>
                                    </td>
                                    <td>
                                        <p style="font-size: 28px;margin: 0; text-align: right;"> <b>INVOICE</b></p>
                                    </td>

                                </tr>

                                
                            </table>

                            <table style="width: 100%;font-family: Arial, Helvetica, sans-serif; margin-top: 20px;">
                                <tr>
                                    <td>
                                        <p style="font-size: 12px; margin: 0;"><b>Billed From:</b></p>
                                        <p style="font-size: 12px;margin: 0; ">{{ $site_name }}</p>
                                    </td>
                                    <td>
                                        <p style="font-size: 12px; margin: 0; text-align: right;"><b>Billed To:</b></p>
                                        <p style="font-size: 12px;margin: 0;text-align: right; ">{{ $customer_name }}</p>
                                    </td>

                                </tr>
                            </table>


                            <table style="width: 100%;font-family: Arial, Helvetica, sans-serif; margin-top: 20px;">
                                <tr>
                                    <td>
                                        <p style="font-size: 10px; margin: 0;"><b>Email: </b>{{ $company_email }}
                                        </p>
                                        <p style="font-size: 10px; margin: 0;"><b>Website: </b>{{ $site->site_link }}
                                        </p>
                                        <p style="font-size: 10px; margin: 0;"><b>Phone: </b>{{ $company_mobile  }}</p>
                                        <p style="font-size: 10px; margin: 0;"><b>Address: </b>{!! $company_address !!}</p>
                                    </td>
                                    

                                </tr>
                            </table>

                            <div style="min-height: 500px !important;">
                            <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 10px; margin-top: 20px;">
                                <thead>
                                  <tr style="background-color: #0072c6; color: white; text-align: left;">
                                    <th style="padding: 8px 12px; font-weight: bold;">Item</th>
                                    <th style="padding: 8px 12px; font-weight: bold;">Description</th>
                                    <th style="padding: 8px 12px; font-weight: bold;">Quantity</th>
                                    <th style="padding: 8px 12px; font-weight: bold;">Unit Price</th>
                                    <th style="padding: 8px 12px; font-weight: bold;">Total</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                  <tr style="border-bottom: 1px solid #ccc;">
                                    <td style="padding: 8px 12px;">{{ $product->category_name }}</td>
                                    <td style="padding: 8px 12px;">{{ $product->name }}</td>
                                    <td style="padding: 8px 12px;">1</td>
                                    <td style="padding: 8px 12px;">{{ site_currency() }} {{  number_format($product->unit_price, 2) }}</td>
                                    <td style="padding: 8px 12px;">{{ site_currency() }} {{  number_format($product->unit_price, 2) }}</td>
                                  </tr>
                                  @endforeach
                                </tbody>
                              </table>
                              

                              <table style="width: 250px; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 10px; margin-left: auto;">
                                <tr>
                                  <td style="padding: 8px 12px; ">Subtotal</td>
                                  <td style="padding: 8px 12px; text-align: right; ">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</td>
                                </tr>
                                <tr>
                                  <td colspan="2">
                                    <hr style="border: none; border-top: 1px solid #ccc; margin: 0 12px;">
                                  </td>
                                </tr>
                                <tr>
                                  <td style="padding: 8px 12px; ">Discount</td>
                                  <td style="padding: 8px 12px; text-align: right; ">{{ site_currency() }} {{ number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr style="background-color: #0072c6; color: white; font-weight: bold; padding: 8px 12px;">

                                    <td style="padding: 8px 12px; ">Grand Total</td>
                                  <td style="padding: 8px 12px; text-align: right; ">{{ site_currency() }} {{ number_format($invoice_amount, 2) }}</td>
                                 
                                </tr>
                              </table>
                            </div>
                              
                        </td>
                    </tr>
                    <tr style=" background: url('{{ $invoice_footer_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;height: 100px; position: relative;">    
                   <td >
                   </td>

                      </tr>
                  
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
