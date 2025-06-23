<!DOCTYPE html>
<html>
<head>
    <title>Your Email Title</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                      <!-- Header -->
                      <tr style=" background: url('{{ $invoice_header_image }}');
                      background-repeat: no-repeat;
                      background-size: cover;
                      background-position: center;
                      height: 130px;">
                        <td style="">
                            <p style="color: #fff; font-family: Arial, Helvetica, sans-serif; font-size: 60px; margin: 0; text-align: right; padding-right: 50px;">INVOICE</p>
                        </td>
                      </tr>
                    <!-- Header End -->

                     <!-- Content-->
                     <tr>


                        <td style="padding:40px; padding-bottom: 100px;">
                            <table style="width: 100%;">

                                <tr style="display: flex;justify-content: space-between;">
                                    <td>
                                        <p style="font-family: arial;font-size: 12px;font-weight: 400; color: #01003D; margin: 0;"><b>Billed To:</b></p>
                                        <br>
                                        <p style="font-family: arial;font-size: 12px;margin: 0; color: #7F7F7F;">{{ $customer_name }}</p>
                                    </td>
                                    <td>
                                        <p style="font-family: arial;font-size: 12px;font-weight: 400; color: #01003D; margin: 0;"><b>Billed From:

                                        </b></p>
                                        <br>
                                        <p style="font-family: arial;font-size: 12px;margin: 0; color: #7F7F7F;">Thetranslatortongue.com<br>
                                            {{ $company_address ?? 'KEVSRA ENTERPRISES LIMITED KENYA' }}<br>
                                            {{ $company_email ?? 'support@thetranslatortongue.com' }}

                                            </p>
                                    </td>
                                    <td>
                                        <p style="font-family: arial;font-size: 12px;font-weight: 400; color: #01003D; margin: 0;text-align: right;"><b>Invoice #<br>{{ $invoice_number }}</b></p>


                                        <p style="font-family: arial;font-size: 12px;font-weight: 400; color: #01003D; margin: 0;text-align: right;"><b>Date: {{ $invoice_date }}</b></p>

                                    </td>
                                </tr>

                            </table>
                            <div style="min-height: 480px !important;">
                            <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; text-align: left; border: 1px solid #01003D; margin-top: 40px;">
                                <tr style="background-color: #01003D; color: white; font-size: 12px;">
                                  <th style="padding: 6px; border: 1px solid #01003D; ">Service type</th>
                                  <th style="padding: 6px; border: 1px solid #01003D;text-align: center;">Pages</th>
                                  <th style="padding: 6px; border: 1px solid #01003D;text-align: center;">Unit Price</th>
                                  <th style="padding: 6px; border: 1px solid #01003D;text-align: right;">Total</th>
                                </tr>
                                @foreach($products as $product)
                                <tr style="background-color: white; font-size: 12px;">
                                  <td style="padding: 6px; border: 1px solid #01003D;">{{ $product->name }}
                                    <br />
                                    From Language: {{ $product->from_language }}
                                    <br />
                                    To Language: {{ $product->to_language }}
                                    <br />
                                    Urgent: {{ $product->is_urgent ? 'Yes (+' . site_currency() . number_format($product->urgent_amount, 2) . ')' : 'No' }}
                                  <td style="padding: 6px; text-align: center; border: 1px solid #01003D;">{{ $product->pages }}</td>
                                  <td style="padding: 6px; text-align: center; border: 1px solid #01003D;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                  <td style="padding: 6px;  border: 1px solid #01003D; text-align: right;">{{ site_currency() . number_format($product->line_total, 2) }}</td>
                                </tr>
                                @endforeach

                              </table>

                              <table style="width: 200px; border: 1px solid black; border-collapse: separate; border-spacing: 0; font-family: Arial, sans-serif; text-align: right; font-size: 12px; margin-left: auto; margin-top: 40px;">
                                <tr>
                                  <td style="padding: 6px; color: #0b004c; font-weight: bold; text-align: left;">Subtotal</td>
                                  <td style="padding: 6px; color: #0b004c; font-weight: bold;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                  <td style="padding: 6px; color: #0b004c; font-weight: bold; text-align: left;">Discount</td>
                                  <td style="padding: 6px; color: #0b004c; font-weight: bold;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                  <td colspan="2" style="border-top: 1px solid black;"></td>
                                </tr>
                                <tr>
                                  <td style="padding: 6px; color: darkred; font-weight: bold; text-align: left;">Grant total</td>
                                  <td style="padding: 6px; color: darkred; font-weight: bold;"{{ site_currency() . number_format($invoice_amount, 2) }}</td>
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
                    height: 70px;">

                      <td></td>
                      </tr>
                    <!-----------Footer End----------->
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
