<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<body style="margin: 0px; padding: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                      <!-- Header -->

                      <tr style=" background: url('{{ $invoice_header_image }}');
                      background-repeat: no-repeat;background-size: cover;background-position: center;height: 130px;">
                        <td style="padding: 40px;">
                            <img src="{{ $company_logo }}" alt="" style="display: block;height:100px;">
                        </td>
                      </tr>
                   
                    <!-- Header End -->

                     <!-- Content-->

                     <tr>

                    
                        <td style="padding:40px; padding-bottom: 100px;">


                            <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; margin-bottom: 30px; font-size: 12px;">
                                <tr>
                                  <!-- TO Section -->
                                  <td style="width: 35%; vertical-align: top; padding: 10px;">
                                    <p style="font-weight: bold; font-size: 12px;">To: {{ $customer_name }} </p>
                                    <!-- <p style="margin: 5px 0;"><strong>Email:</strong> {{ $customer_email }} </p> -->
                                  </td>
                              
                                  <!-- Vertical Divider -->
                                  <td style="width: 2%; border-left: 2px solid #afc42b;"></td>
                              
                                  <!-- FROM Section -->
                                  <td style="width: 35%; vertical-align: top; padding: 10px;padding-right: 80px;">
                                    <p style="font-weight: bold; font-size: 12px;">From: {{ $site_name }}</p>
                                    <p style="margin: 5px 0;"> {!! $company_address !!} </p>
                                    <p style="margin: 5px 0;"><strong>Email:</strong> {{ $company_email }} </p>
                                    @if(isset($company_mobile) && trim($company_mobile) !== '')
                                        <p style="margin: 5px 0;">
                                            <strong>Phone:</strong> {{ $company_mobile }}
                                        </p>
                                    @endif
                                  </td>
                              
                                  <!-- Invoice Details Section -->
                                  <td style="width: 28%; vertical-align: top; padding: 10px; font-size: 10px;">
                                    <p style="font-weight: bold; font-size: 12px; margin: 0; text-align: right;">Invoice Details</p>
                                    <p style="margin:  0; text-align: right;">Invoice Date: {{ $invoice_date }} </p>
                                    <p style="margin:  0; text-align: right;">Invoice No: #{{ $invoice_number }}</p>
                                    <p style="margin-top: 20px; font-weight: bold; font-size: 16px; text-align: right;">TOTAL DUE</p>
                                    <p style="font-size: 18px; font-weight: bold; margin: 0; text-align: right;">{{ site_currency() }} {{ number_format($invoice_amount, 2) }}</p>
                                  </td>
                                </tr>
                              </table>
                          <div style="min-height: 545px !important;">
                          git add .                            <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 8px;">
                                <tr style="background-color: #A9BF2B;">
                                  <th style="text-align: left; padding: 8px 20px; font-size: 12px;">DESCRIPTION</th>
                                  <th style="text-align: center; padding: 8px 20px; font-size: 12px;">QTY</th>
                                  <th style="text-align: right; padding: 8px 20px; font-size: 12px;">TOTAL</th>
                                </tr>
                                @foreach($products as $product)
                                <tr>
                                  <td style="padding: 16px 20px;">
                                    <strong style=" font-size: 12px;">{{ $product->category_name }}</strong><br>
                                    <span style="color: #333; font-size: 10px;">{{ $product->name }}</span>
                                  </td>
                                  <td style="text-align: center; padding: 16px 20px; font-size: 12px;">01</td>
                                  <td style="text-align: right; padding: 16px 20px; font-size: 12px;">{{ site_currency() }} {{  number_format($product->unit_price, 2) }}</td>
                                </tr>
                                @endforeach
                                
                              </table>
                          

                              <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; margin-top: 24px; font-size: 12px;">
                                <tr>
                                  <!-- Notes Section -->
                                  <td style="width: 65%; background-color: #FFFFFF; padding: 20px; vertical-align: top;">
                                    <!-- <strong style="font-size: 12px; color: #333;">Notes</strong>
                                    <p style="color: #333; font-size: 12px; margin-top: 8px;">
                                    Thank you for your business. Please note that payment is due within 15 days from the invoice date. A late fee of 2% per month may be applied to overdue balances. If you have any questions regarding this invoice, feel free to contact our billing department at {{ $company_email }}.
                                    </p> -->
                                  </td>
                              
                                  <!-- Totals Section -->
                                  <td style="width: 35%; background-color: #EAEAEA; padding: 16px;">
                                    <table style="width: 100%; font-size: 12px; color: #333;">
                                      <tr>
                                        <td style="padding: 4px 0;">Sub Total</td>
                                        <td style="text-align: right;">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</td>
                                      </tr>
                                      <tr>
                                        <td style="padding: 4px 0;">Discount</td>
                                        <td style="text-align: right;">{{ site_currency() }} {{ number_format($discount_amount, 2) }}</td>
                                      </tr>
                                     
                                      <tr>
                                        <td style="padding: 8px 0; font-weight: bold; font-size: 12px;">Grand Total</td>
                                        <td style="text-align: right; font-weight: bold; font-size: 12px;">{{ site_currency() }} {{ number_format($invoice_amount, 2) }}</td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                              
                              </div>
                        </td>
                    </tr>
                     <!-- Content End-->


                    <!-----------Footer----------->

                    <tr style=" background: url('{{ $invoice_footer_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;height: 70px; ">    
                   
                            <td  style="display: flex; flex-direction: row; justify-content:space-around; padding-left:  50px; padding-right: 50px; padding-top: 20px;">
                                    <div style="font-size: 10px; display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                        <p style="margin: 0;margin-bottom: 6px;"><b>Contact</b></p>
                                        <a  href="" style="margin: 0; color: blue;"> {{ $company_email }} </a>
                                        <p style="margin: 0;"> {{ $company_mobile }} </p>
                                    </div>

                                    <img src="{{ $invoice_image1 }}" alt="" style="display: block;height:32px;">

                                    <div style="font-size: 10px; display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                        <p style="margin: 0; margin-bottom: 6px;"><b>Address</b></p>
                                        <p style="margin: 0; text-align: center;">{!! $company_address !!}</p>
                                       
                                    </div>

                            </td>

                      </tr>
                    <!-----------Footer End----------->
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
