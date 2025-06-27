<!DOCTYPE html>
<html>

<head>
    <title>Gifteze</title>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr style=" background: url('{{ $invoice_header_image }}');
                      background-repeat: no-repeat;
                      background-size: cover;
                      background-position: center;
                      height: 130px;">
                        <td>

                        </td>
                    </tr>
                    <!-- Header End -->

                    <!-- Content-->
                    <tr>
                        <td style="padding:40px;">
                            <table
                                style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px;">
                                <tr style="background-color: #0070C0; color: white;">
                                    <th style="text-align: left; padding: 10px;">INVOICE No. {{$invoice_number}}</th>
                                    <th style="text-align: right; padding: 10px;">Invoice Date</th>

                                    <th style="text-align: right; padding: 10px;">Date  {{$invoice_date}}</th>
                                </tr>
                            </table>


                            <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 10px; color: #444; margin-top: 30px;">
                                <tr style="border-bottom: 1px solid #527ba0;">
                                  <th style="width: 50%; padding-bottom: 5px; font-variant: small-caps; color: #0070C0; text-align: center;">Billed To</th>
                                  <th style="width: 50%; padding-bottom: 5px; font-variant: small-caps; color: #0070C0; text-align: center;">Billed From</th>
                                </tr>
                                <tr>
                                  <td style="text-align: center; padding-top: 8px; vertical-align: top;">{{ $customer_name }}</td>
                                  <td style="text-align: center; padding-top: 8px;vertical-align: top;">
                                    {{ $site_name }}<br>
                                    {{ $company_address }}<br>
                                    {{ $company_mobile }}<br />
                                    <a href="mailto:{{ $company_email }}" style="color: #0070C0; text-decoration: underline;">{{$company_email}}</a>
                                  </td>
                                </tr>
                              </table>
                              <div style="min-height: 500px !important;">
                            <table
                                style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 10px; margin-top: 30px;">
                                <tr style="background-color: #0070C0; color: white;">
                                    <th style="text-align: left; padding: 10px;">Quantity</th>
                                    <th style="text-align: left; padding: 10px;">Product Name</th>
                                    <th style="text-align: right; padding: 10px;">Unit Price</th>
                                    <th style="text-align: right; padding: 10px;">Total</th>
                                </tr>
                                @foreach($products as $product)
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 10px;">1</td>
                                    <td style="padding: 10px;">{{$product->name}}</td>
                                    <td style="padding: 10px; text-align: right;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                    <td style="padding: 10px; text-align: right;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                </tr>
                                @endforeach
                            </table>

                            <table style="width: 300px; font-family: Arial, sans-serif; font-size: 10px; border-collapse: collapse; margin-left: auto;">
                                <tr style="border-bottom: 1px solid #ccc;">
                                  <td style="padding: 8px; font-weight: bold; color: #666; font-variant: small-caps;">Subtotal</td>
                                  <td style="padding: 8px; text-align: right; color: #666;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #999;">
                                  <td style="padding: 8px; font-weight: bold; color: #666; font-variant: small-caps;">Discount</td>
                                  <td style="padding: 8px; text-align: right; color: #666;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #999;">
                                  <td style="padding: 10px; font-weight: bold; color: #0070C0; font-variant: small-caps; font-size: 14px;">Total</td>
                                  <td style="padding: 10px; text-align: right; color: #0070C0; font-size: 14px; font-weight: bold;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                </tr>
                              </table>
                              </div>
                        </td>
                    </tr>
                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr style=" background: url('{{ $invoice_footer_image }}');
                    background-repeat: no-repeat;
                    background-size: cover;
                    background-position: center;
                    height: 100px; position: relative;">

                        <td>

                        </td>

                    </tr>
                    <!-----------Footer End----------->
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
