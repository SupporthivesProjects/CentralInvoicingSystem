<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>

<body style="margin: 0px; padding: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">

                    <tr style=" background: url('{{ $invoice_header_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;height: 130px;">
                        <td>

                        </td>
                    </tr>
                    <tr>
                   
                        <td style="padding:40px;">

                            <table style="width: 100%;font-family: arial;">

                                <tr>
                                    <td>
                                        <p style="font-size: 12px; margin: 0; text-align: right;"><b>Invoice No. :</b> #{{ $invoice_number }}</p>
                                        <p style="font-size: 12px; margin: 0; text-align: right;"><b>Invoice Date. :</b> {{ $invoice_date }}</p>
                                        
                                        
                                    </td>
                                </tr>
                                
                            </table>

                            <table style="height: 157px; width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; border: 1px solid #000; font-size: 10px; margin-top: 20px;">
                                <tr>
                                  <th colspan="2" style="background-color: #0F0C25; color: #FF4700; text-align: left; padding: 10px; font-size: 12px;border-right: 1px solid #000;">Billed To</th>
                                  <th colspan="2" style="background-color: #0F0C25; color: #FF4700; text-align: left; padding: 10px; font-size: 12px;">Billed From</th>
                                </tr>
                                <tr>
                                  <td style="font-weight: bold; padding: 8px;">Customer</td>
                                  <td style="padding: 8px;border-right: 1px solid #000;">{{ $customer_name }}</td>
                                  <td style="font-weight: bold; padding: 8px;">Website</td>
                                  <td style="padding: 8px;">{{ $site_name }}</td>
                                </tr>
                                <tr>
                                  <td style="font-weight: bold; padding: 8px;"></td>
                                  <td style="padding: 8px;border-right: 1px solid #000;"></td>
                                  <td style="font-weight: bold; padding: 8px;">Email</td>
                                  <td style="padding: 8px;">{{ $company_email }}</td>
                                </tr>
                                <tr>
                                  <td style="font-weight: bold; padding: 8px;"></td>
                                  <td style="padding: 8px;border-right: 1px solid #000;"></td>
                                  <td style="font-weight: bold; padding: 8px;">Address</td>
                                  <td style="padding: 8px;">{!! $company_address !!}</td>
                                </tr>
                                @if(isset($company_mobile) && trim($company_mobile) !== '')
                                <tr>
                                  <td style="font-weight: bold; padding: 8px;"></td>
                                  <td style="padding: 8px;border-right: 1px solid #000;"></td>
                                  <td style="font-weight: bold; padding: 8px;">Phone</td>
                                  <td style="padding: 8px;">{{ $company_mobile }}</td>
                                </tr>
                                @endif
                              </table>
                              <div style="min-height: 497px !important;">
                                <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;font-size: 10px; margin-top: 20px;">
                                  <thead>
                                    <tr style="background-color: #0f0b27; color: #ff4000;font-size: 12px;">
                                      <th style="border: 1px solid #000; padding: 8px;">Qty.</th>
                                      <th style="border: 1px solid #000; padding: 8px; text-align: left; width: 42%;">Description</th>
                                      <!-- <th style="border: 1px solid #000; padding: 8px;text-align: left;">Quality</th> -->
                                      <th style="border: 1px solid #000; padding: 8px;text-align: right;">Duration</th>
                                      <th style="border: 1px solid #000; padding: 8px;text-align: right;">Unit Price</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  @foreach($products as $product)
                                    <tr>
                                      <td style="border: 1px solid #000; padding: 8px; text-align: center;">1</td>
                                      <td style="border: 1px solid #000; padding: 8px;text-align: left;">{{ $product->name }}</td>
                                      <!-- <td style="border: 1px solid #000; padding: 8px;text-align: left;">Premium</td> -->
                                      <td style="border: 1px solid #000; padding: 8px;text-align: right;">{{ $product->subscription ?? '-' }}</td>
                                      <td style="border: 1px solid #000; padding: 8px; text-align: right;">{{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</td>
                                    </tr>
                                    @endforeach 
                                  
                                    <tr>
                                      <td style=" padding: 8px; text-align: center;"></td>
                                      <td style=" padding: 8px; text-align: center;"></td>
                                      <!-- <td style=" padding: 8px; text-align: center;"></td> -->
                                      <td  style="border: 1px solid #000; padding: 8px; text-align: right;">Subtotal</td>
                                      <td style="border: 1px solid #000; padding: 8px; text-align: right;">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}</td>
                                    </tr>
                                    <tr>
                                      <td style=" padding: 8px; text-align: center;"></td>
                                      <td style=" padding: 8px; text-align: center;"></td>
                                      <!-- <td style=" padding: 8px; text-align: center;"></td> -->
                                      <td  style="border: 1px solid #000; padding: 8px; text-align: right;">Discount</td>
                                      <td style="border: 1px solid #000; padding: 8px; text-align: right;">{{ site_currency() }} {{ number_format($discount_amount ?? 0, 2) }}</td>
                                    </tr>
                                    <tr >
                                      <td style=" padding: 8px; text-align: center;"></td>
                                      <td style=" padding: 8px; text-align: center;"></td>
                                      <!-- <td style=" padding: 8px; text-align: center;"></td> -->
                                      <td  style="border: 1px solid #000;background-color: #0f0b27; padding: 8px; text-align: right; color: #ff4000; font-weight: bold;">Total</td>
                                      <td style="border: 1px solid #000;background-color: #0f0b27; padding: 8px; text-align: right; color: #ff4000; font-weight: bold;">{{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                              
                        </td>
                    </tr>
                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr style=" background: url('{{ $invoice_footer_image }}');background-repeat: no-repeat;background-size: contain;background-position: left center;height: 185px;    display: flex;justify-content: flex-end;align-items: center; ">

                        <td
                            style=" padding-right: 50px; display: flex; flex-direction: column; align-items: flex-end; font-family: arial;font-size:10px;">
                            <p style="text-align: right; margin: 0;"><b>Thank you for you business!</b></p>

                            <p style="color: #FF4700; text-align: right;margin: 0;margin-top: 30px;">{{ $site_name }}</p>

                            <p style="margin: 0; text-align: right; margin-top: 10px;">
                                {!! $company_address !!} | {{ $site_name }}<br>
                                {{ $company_mobile }} | {{ $site->site_link }}

                            </p>
                        </td>

                    </tr>
                    <!-----------Footer End----------->
                </table>
            </td>
        </tr>
    </table>
</body>

</html>