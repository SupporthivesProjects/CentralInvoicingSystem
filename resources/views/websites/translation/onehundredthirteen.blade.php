<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#E9F3FF" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                      <!-- Header -->
                   
                      <tr style=" background: url('{{ $invoice_header_image }}'); background-repeat: no-repeat;background-size: cover; background-position: center; height: 150px; ">
                        <td style=" text-align: right;padding-right: 50px;font-family: arial;">

                            <p style="font-size: 28px; margin: 0; color: #ffffff;">Invoice</p>
                            
                            <p style="font-size: 11px; margin: 0;color: #ffffff;">#: {{ $invoice_number }}
                                </p>
                                <p style="font-size: 11px; margin: 0;color: #ffffff;">
                                    Date: {{ $invoice_date }}
                                    </p>
                        </td>
                      </tr>
                    <!-- Header End -->

                     <!-- Content-->

                     <tr>

                     
                        <td style="padding:60px; padding-bottom: 100px;">

                            <table style="width: 100%; font-size: 12px; font-family: arial;color: #242661;">
                                <tr>
                                    <td>
                                        <p style=" margin: 0; margin-bottom: 6px;"><b>Billed To:</b></p>
                                        <p style=" margin: 0;">{{ $customer_name }}<br>
                                           {{ $customer_email }}<br>

                                            </p>
                                    </td>
                                    <td>
                                        <p style=" margin: 0; margin-bottom: 6px;"><b>Billed From:</b></p>
                                        <p style=" margin: 0;">{{ $site_name  }}<br>
                                            {{ $company_address }}<br>
                                            {{ $company_email }}<br>
                                            {{ $company_mobile }}
                                            
                                            </p>
                                    </td>
                                </tr>
                            </table>
                            <div style="min-height: 460px !important">
                            <table style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; background-color: #eaf2fd; margin-top: 30px;">
                                <thead>
                                  <tr style="background-color: #1B7EFF; color: white; text-align: left; font-size: 12px;">
                                    <th style="padding: 6px 12px;">Service type</th>
                                    <th style="padding: 6px 12px; text-align: center;">Pages</th>
                                    <th style="padding: 6px 12px;text-align: center;">Words</th>
                                    <th style="padding: 6px 12px; text-align: right;">Total</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                  <tr style="border-bottom: 1px solid #bcdaf8; font-size: 10px;">
                                    <td style="padding: 6px 12px;">{{ $product->name }} <br>{{ $product->from_language }} to  {{ $product->to_language }}
                                  </td>
                                    <td style="padding: 6px 12px;text-align: center;"> {{ $product->pages }}</td>
                                    <td style="padding: 6px 12px;text-align: center;">{{ round($product->pages * 250) }}</td>
                                    <td style="padding: 6px 12px;text-align: right;">{{ site_currency() . number_format($product->line_total) }}</td>
                                  </tr>
                                  @endforeach
                                  <tr>
                                    <td></td>
                                    <td></td>
                                  <td style="padding: 6px 12px;">Subtotal</td>
                                  <td style="padding: 6px 12px; text-align: right;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                </tr>
                               
                                <tr>
                                <td></td>
                                <td></td>
                                  <td style="padding: 6px 12px;">Discount</td>
                                  <td style="padding: 6px 12px; text-align: right;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                <td></td>
                                <td></td>
                                  <td style="padding: 6px 12px; font-weight: bold; color: #1B7EFF; font-size: 14px;">Grand total</td>
                                  <td style="padding: 6px 12px; text-align: right; font-weight: bold; color: #1B7EFF; font-size: 14px;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                </tr>
                                </tbody>
                              </table>
                            </div>
                              
                        </td>
                    </tr>
                     <!-- Content End-->


                    <!-----------Footer----------->

                    <tr style=" background: url('{{ $invoice_footer_image }}') #E9F3FF;background-repeat: no-repeat;background-size: cover;background-position: center;height: 146px;display: flex;align-items: center; ">    
                   
                            <td style="padding-left: 50px; display: flex; flex-direction: column;">
                                
                                <p style="font-size: 11px; color: #ffffff; margin-bottom: 6px;"><b>Notes</b></p>

                                <p style="font-size: 8px; width: 200px; color: #ffffff; margin: 0;"><b>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamc.
                                    </b></p>
                                
                            </td>

                      </tr>
                    <!-----------Footer End----------->
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
