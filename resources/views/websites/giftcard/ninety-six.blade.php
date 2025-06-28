<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->

                    <tr style="
                      height: 130px;">
                        <td style="padding: 90px 50px 50px 50px; padding-bottom: 0px;">
                            <img src="{{ $company_logo }}" alt="" style="display: block;height:60px; margin-left: auto;">
                        </td>
                    </tr>

                    <tr
                        style="font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-size: 10px; ">
                        <td style="padding-left: 50px;">
                            <p>{{ $company_name }}
                            </p>
                            <br>
                            <p>{!! $company_address !!}

                            </p>
                        </td>
                    </tr>
                    <!-- Header End -->

                    <!-- Content-->
                    <tr>


                        <td style="padding:50px">

                            <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px;">
                                <tr style="background-color: #002060; color: white;">
                                    <th style="padding: 10px; text-align: left;">INVOICE No. {{ $invoice_number }}</th>
                                    <th style="padding: 10px; text-align: right;">Date {{ $invoice_date }} </th>
                                </tr>
                            </table>

                            <table style="width: 100%; border-collapse: collapse; font-family: Arial, Helvetica, sans-serif; margin-top: 20px;">
                                <tr>
                                  <td style="vertical-align: top; padding-bottom: 10px; width: 70%;">
                                    <p style="color: #5a7b9d; font-size: 10px; font-variant: small-caps;">BILL TO</p>
                                    <hr style="border: none; border-top: 1px solid #5a7b9d; margin: 2px 0 10px 0;">
                                    <div style="font-size: 10px; color: #444;">{{ $customer_name  }}</div>
                                  </td>
                                  <td style="vertical-align: top; text-align: left; padding-bottom: 10px; width: 30%;">
                                    <p style="color: #5a7b9d; font-size: 10px;  font-variant: small-caps;">BILL FROM</p>
                                    <hr style="border: none; border-top: 1px solid #5a7b9d; margin: 2px 0 10px 0;">
                                    <div style="font-size: 10px; color: #444;"> {{ $site->site_link }}</div>
                                    <div style="font-size: 10px; color: #444;"> {{ $company_email }} </div>
                                  </td>
                                </tr>
                              </table>
                             <div style="min-height: 400px !important;">
                                <table
                                    style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 10px;  margin-top: 20px;">
                                    <thead>
                                        <tr style="background-color: #002060; color: white;">
                                            <th style="padding: 10px; text-align: left;">Quantity</th>
                                            <th style="padding: 10px; text-align: left;">Description</th>
                                            <th style="padding: 10px; text-align: right;">Unit Price 

                                            </th>
                                            <th style="padding: 10px; text-align: right;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $product)
                                        <tr style="border-bottom: 1px solid #ccc;">
                                            <td style="padding: 8px;"> {{ $product->quantity ?? 1 }}</td>
                                            <td style="padding: 8px; font-weight: bold;">{{ $product->name }}</td>
                                            <td style="padding: 8px; text-align: right;">{{ site_currency() }} {{ number_format($product->unit_price, 2) }}</td>
                                            <td style="padding: 8px; text-align: right;">{{ site_currency() }} {{ number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                        <td></td>
                                        <td></td>
                                        <td style="text-align: right;color: #577188; font-variant: small-caps;">Subtotal</td>
                                        <td style="text-align: right; color: #577188;">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</td>
                                        </tr>
                                        <tr>
                                        <td></td>
                                        <td></td>
                                        <td style="text-align: right;color: #577188; font-variant: small-caps;">Discount</td>
                                        <td style="text-align: right; color: #577188;">{{ site_currency() }} {{ number_format($discount_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                        <td></td>
                                        <td></td>
                                        <td colspan="2" style="border-top: 1px solid #999;"></td>
                                        </tr>
                                        <tr>
                                        <td></td>
                                        <td></td>
                                        <td style="text-align: right;font-weight: bold; color: #577188; padding-top: 8px; font-variant: small-caps;">Total</td>
                                        <td style="text-align: right; font-weight: bold; color: #577188; padding-top: 8px;">{{ site_currency() }} {{ number_format($invoice_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                        <td></td>
                                        <td></td>
                                        <td colspan="2" style="border-top: 1px solid #999; padding-top: 10px;"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <table style="width: 200px; font-family: Arial, sans-serif; font-size: 10px; border-collapse: collapse; margin-top: 20px; margin-left: auto;">

                                <tr>
                                    <td>
                                        <p style="font-family: Arial, sans-serif; font-size: 10px; color: #595959; margin-top: 30px; text-align: left;">
                                            <strong>Thank you for your business!</strong>
                                          </p>
                                    </td>
                                </tr>
                              </table>
                              
                             
                              
                        </td>
                    </tr>
                   
                </table>
            </td>
        </tr>
    </table>
</body>

</html>