<!DOCTYPE html>
<html>
<head>
  <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
      body {
            margin: 0px;
            padding: 0px;
        }
        .footer-fixed {
            position: fixed;
            bottom: 0px;
            left: 0;
            right: 0;
            width: 100%;
            /* background: url('{{ $invoice_footer_image }}') center center no-repeat; */
            /* background-size: cover; */
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#FFFFFF" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse;">
                      <!-- Header -->

                      <tr style=" background: url('{{ $invoice_header_image }}'); background-repeat: no-repeat;background-size: cover;background-position: center;height: 130px;">
                        <td >
                        </td>
                      </tr>

                     <tr>

                     
                        <td style="padding:40px; padding-bottom: 100px;">

                            <table style="width: 100%;font-family: Arial, Helvetica, sans-serif;">
                            
                                <tr>
                                    <td>
                                        <p style="font-size: 12px; margin: 0;"><b>Date: </b> {{ $invoice_date }} </p>
                                        <p style="font-size: 12px;margin: 0; "><b>Invoice Number: </b>#{{ $invoice_number }}</p>
                                    </td>
                                    <td>
                                        <p style="font-size: 28px;margin: 0; text-align: right;"> <b>INVOICE</b></p>
                                    </td>

                                </tr>

                                
                            </table>

                            <table style="width: 100%;font-family: Arial, Helvetica, sans-serif; margin-top: 20px;">
                                <tr>
                                    <td>
                                        <p style="font-size: 12px; margin: 0;">Billed From:</p>
                                        <p style="font-size: 12px;margin: 0; ">{{ $site_name }}</p>
                                    </td>
                                    <td>
                                        <p style="font-size: 12px; margin: 0; text-align: right;">Billed To:</p>
                                        <p style="font-size: 12px;margin: 0;text-align: right; ">{{ $customer_name }}</p>
                                    </td>

                                </tr>
                            </table>


                            <table style="width: 100%;font-family: Arial, Helvetica, sans-serif; margin-top: 20px;">
                                <tr>
                                    <td>
                                        <p style="font-size: 12px; margin: 0;"><b>Email: </b>{{ $company_email }}</p>
                                        <p style="font-size: 12px; margin: 0;"><b>Website: </b> <a href="{{ $site->site_link }}" style="color: #000000;">eazymarketer.com</a> </p>
                                        <p style="font-size: 12px; margin: 0;"><b>Phone: </b>{{ $company_mobile }}</p>
                                        <p style="font-size: 12px; margin: 0;"><b>Address: </b>{!! $company_address !!}</p>
                                    </td>
                                    

                                </tr>
                            </table>
                            <div style="min-height: 400px !important;">
                            <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; margin-top: 50px;">
                                <thead>
                                  <tr style="background-color: #385623; color: white; text-align: left;font-size:14px;">
                                    <th style="padding: 4px 12px;">ITEM</th>
                                    <th style="padding: 4px 12px ;">DESCRIPTION</th>
                                    <th style="padding: 4px 12px ;">QTY</th>
                                    <th style="padding: 4px 12px ;">UNIT PRICE</th>
                                    <th style="padding:  4px 12px ;">TOTAL</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                  <tr style="border-bottom: 1px solid #ccc; font-size: 14px;">
                                    <td style="padding: 10px;"> {{ $product->name }}</td>
                                    <td style="padding: 10px;">{{ $product->subscription ?? '-' }}</td>
                                    <td style="padding: 10px;">1</td>
                                    <td style="padding: 10px;">{{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</td>
                                    <td style="padding: 10px;">{{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</td>
                                  </tr>
                                @endforeach 
                                </tbody>
                              </table>

                              
                              <table style="width: 250px; margin-left: auto;border-collapse: collapse; font-family: Arial, sans-serif; margin-top: 20px;">
                                <thead>
                                  <tr>
                                    <th colspan="2" style="text-align: left; padding: 10px 12px; font-weight: bold;font-size:14px;">INVOICE TOTAL</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr style="border-bottom: 1px solid #ccc; font-size: 12px;">
                                    <td style="padding: 10px 12px;">SUBTOTAL</td>
                                    <td style="padding: 10px 12px; text-align: right;">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}</td>
                                  </tr>
                                  <tr style="border-bottom: 1px solid #ccc; font-size: 12px;">
                                    <td style="padding: 10px 12px;">DISCOUNT</td>
                                    <td style="padding: 10px 12px; text-align: right;">{{ site_currency() }} {{ number_format($discount_amount ?? 0, 2) }}</td>
                                  </tr>
                                  <tr style="border-bottom: 1px solid #ccc; background-color: #3d5525; color: white;font-size:14px;">
                                    <td style="padding: 4px 12px; font-weight: bold;">GRAND TOTAL</td>
                                    <td style="padding: 4px 12px; text-align: right; font-weight: bold;"> {{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}</td>
                                  </tr>
                                </tbody>
                              </table>
                              
                              </div>
                        </td>
                    </tr>
                     <!-- Content End-->


                    <!-----------Footer----------->
                    <tr class="footer-fixed" style=" background: url('{{ $invoice_footer_image}}');
                    background-repeat: no-repeat;
                    background-size: cover;
                    background-position: center;
                    height: 146px; ">    
                   
                            <td >
                            </td>

                      </tr>
                    <!-----------Footer End----------->
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
