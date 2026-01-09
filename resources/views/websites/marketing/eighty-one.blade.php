<!DOCTYPE html>
<html>
<head>
  <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<body style="margin: 0px !important; padding: 0px; !important">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                      <!-- Header -->
                      <tr style=" background: url('{{ $invoice_header_image }}');background-repeat: no-repeat;background-size: cover; background-position: center;height: 94px;">
                        <td >
                           
                        </td>
                      </tr>
                   
                    <!-- Header End -->

                     <!-- Content-->

                     <tr style=" background: url('{{ $invoice_image1 }}');background-repeat: no-repeat;background-size: cover;background-position: center;">
                        <td style="padding:40px;  font-family: arial;">
                            <!-- <p style="text-align: center; color: #2E75B5; font-size: 20px; margin: 0;"><b>Invoice</b><b> #{{ $invoice_number }}</b></p> -->
                            <table style="width: 100%; border: none; border-collapse: collapse;">
                              <tr>
                                <td>
                                  <p style="text-align: center; color: #2E75B5; font-size: 20px; margin: 0;"><b>Invoice</b><b> #{{ $invoice_number }}</b></p>
                                </td>
                                <td>
                                  <p style="text-align: center; color: #2E75B5; font-size: 20px; margin: 0;"><b>Invoice Date:</b><b> #{{ $invoice_date }}</b></p>
                                </td>
                              </tr>
                            </table>

                            <table style="width: 100%; border: 1px solid #0074d9; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 10px; margin-top: 20px;">
                                <tr>
                                  <th style="background-color: #DEEBF6; text-align: left; padding: 10px; border-right: 1px solid #0074d9; border-bottom: 1px solid #0074d9;">Bill to</th>
                                  <th style="background-color: #DEEBF6; text-align: left; padding: 10px; border-bottom: 1px solid #0074d9;">Bill from</th>
                                </tr>
                                <tr>
                                  <td style="padding: 16px; display:flex; flex-direction: column">
                                    <p><strong>Name : </strong> {{ $customer_name  }}</p>
                                    <!-- <p><strong>Email</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $customer_email }}</p> -->
                                  </td>
                                  <td style="padding: 16px; border-left: 1px solid #0074d9;">
                                    <div>
                                      <p><strong>Name : </strong> {{ $site_name }}</p>
                                      <p><strong>Address : </strong><p> {!! $company_address !!} </p></p>
                                      @if(!empty($company_mobile))
                                        <p><strong>Phone : </strong> {{ $company_mobile  }}</p>
                                      @endif
                                      <p><strong>Email : </strong> {{ $company_email }}</p>
                                    </div>
                                  </td>
                                </tr>
                              </table>
                              <div style="min-height: 530px !important;">
                              <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; border: 1px solid #0074d9; font-size: 10px; margin-top: 20px;">
                                <thead>
                                  <tr style="background-color: #DEEBF6;">
                                    <th style="border: 1px solid #0074d9; padding: 8px; text-align: left;">Qty.</th>
                                    <th style="border: 1px solid #0074d9; padding: 8px; text-align: left;">Description</th>
                                    <th style="border: 1px solid #0074d9; padding: 8px; text-align: right;">Unit price</th>
                                    <th style="border: 1px solid #0074d9; padding: 8px; text-align: right;">Total</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                  <tr>
                                    <td style="border: 1px solid #0074d9; padding: 8px;">1</td>
                                    <td style="border: 1px solid #0074d9; padding: 8px;">{{ $product->name }} / {{ $product->subscription ?? '-' }}</td>
                                    <td style="border: 1px solid #0074d9; padding: 8px; text-align: right;">{{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</td>
                                    <td style="border: 1px solid #0074d9; padding: 8px; text-align: right;">{{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</td>
                                  </tr>
                                  @endforeach 
                                  <tr>
                                    <td colspan="3" style="border: 1px solid #0074d9; text-align: right; padding: 8px;">Subtotal</td>
                                    <td style="border: 1px solid #0074d9; text-align: right; padding: 8px;">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}</td>
                                  </tr>
                                  <tr>
                                    <td colspan="3" style="border: 1px solid #0074d9; text-align: right; padding: 8px;">Discount Total</td>
                                    <td style="border: 1px solid #0074d9; text-align: right; padding: 8px;">{{ site_currency() }} {{ number_format($discount_amount ?? 0, 2) }}</td>
                                  </tr>
                            
                                  <tr style="background-color: #DEEBF6;">
                                    <td colspan="3" style="border: 1px solid #0074d9; text-align: right; padding: 10px; font-weight: bold;">Total</td>
                                    <td style="border: 1px solid #0074d9; text-align: right; padding: 10px; font-weight: bold;">{{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}</td>
                                  </tr>
                                </tbody>
                              </table>
                              </div>


                            <p style="text-align: center;  font-size: 10px; margin: 0;margin-top: 20px;">{{ $company_email }} | {{ $site_name }}
                            </p>
                            <p style="text-align: center;  font-size: 10px; margin: 0; margin-top: 12px;">{!! $company_address !!} | {{ $company_mobile }}

                            </p>
                        </td>
                    </tr>

                    <tr style=" background: url('{{ $invoice_footer_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;height: 136px">    
                    <td >
                               
                    </td>

                      </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
