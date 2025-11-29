<!DOCTYPE html>
<html>
<head>
    <title>Lenzlibrary</title>
</head>
<body style="margin: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFDF0" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                      <!-- Header -->

                      <tr style=" background: url('{{ $invoice_header_image }}');
                      background-repeat: no-repeat;
                      background-size: cover;
                      background-position: center;
                      height: 116px;">
                        <td >
                            <p style="font-family: 'Times New Roman', Times, serif;font-size: 48px; color: #ffffff; padding-left: 50px; margin: 0;">Invoice</p>
                        </td>
                      </tr>

                    <!-- Header End -->


                     <!-- Content-->

                     <tr>


                        <td style="padding:40px; padding-bottom: 100px;">

                            <table style="width: 100%;">
                                <tr>

                                    <td style="vertical-align: top;">
                                       <div style="background-color: #355C5B; width: 80%; padding: 8px;">
                                        <p style="margin: 0; color: #ffffff; font-family: 'Times New Roman', Times, serif;">INVOICE #: {{ $invoice_number }}</p>
                                       </div>
                                       <div style="background-color: #355C5B; width: 80%; padding: 8px; margin-top: 12px;">
                                        <p style="margin: 0; color: #ffffff; font-family: 'Times New Roman', Times, serif;">DATE: {{ $invoice_date }}</p>
                                       </div>
                                    </td>
                                    <td>
                                        <p style="font-family: 'Times New Roman', Times, serif; font-size: 16px; margin: 0;margin-bottom: 16px;">
                                            Billed to:
                                        </p>

                                        <p style="font-family: Arial, Helvetica, sans-serif; font-size: 10px; margin: 0;margin-bottom: 12px;">{{ $customer_name }}<br>


                                            </p>

                                        <p style="font-family: Arial, Helvetica, sans-serif; font-size: 10px; margin: 0;">
                                            {{ $customer_email }}<br>
                                            {{ $customer_mobile }}
                                        </p>
                                    </td>

                                    <td>
                                        <p style="font-family: 'Times New Roman', Times, serif; font-size: 16px; margin: 0;margin-bottom: 16px; text-align: right;">
                                            {{ $site_name }}
                                        </p>

                                        <p style="font-family: Arial, Helvetica, sans-serif; font-size: 10px; margin: 0;margin-bottom: 12px;text-align: right;">{{ $company_address }}<br>


                                            </p>

                                        <p style="font-family: Arial, Helvetica, sans-serif; font-size: 10px; margin: 0;text-align: right;">
                                            {{ $company_email }}<br>
                                            {{ $company_mobile }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <div style="min-height: 700px !important;">
                            <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 10px; margin-top: 30px;">
                                <tr style="background-color: #355C5B; color: white;">
                                  <th style="text-align: left; padding: 6px 12px;">PACK</th>
                                  <th style="text-align: left; padding: 6px 12px; text-align: center;">CREDITS</th>
                                  <th style="text-align: left; padding: 6px 12px;text-align: center;">UNIT PRICE</th>
                                  <th style="text-align: left; padding: 6px 12px;text-align: right;">TOTAL</th>
                                </tr>
                                @foreach($products as $product)
                                <tr style="background-color: #FFFDF0;">
                                  <td style="padding: 12px; color: #2f5e5a;">{{ $product->name }}</td>
                                  <td style="padding: 12px; color: #2f5e5a;text-align: center;">{{ $product->credits ?? 0 }} Credits</td>
                                  <td style="padding: 12px; color: #2f5e5a;text-align: center;">{{ site_currency() }}{{ number_format($product->price, 2) }}</td>
                                  <td style="padding: 12px; color: #2f5e5a;text-align: right;">{{ site_currency() }}{{ number_format($product->price, 2) }}</td>
                                </tr>
                                @endforeach
                              </table>
                              <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 10px; background-color: #f8f1d2;">
                                <tr>
                                  <td style="padding: 12px; ">SUBTOTAL</td>
                                  <td style="padding: 12px; text-align: right;">{{ site_currency() }}{{ number_format($invoice_amount + $discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                  <td style="padding: 12px; ">DISCIOUNT</td>
                                  <td style="padding: 12px; text-align: right;">{{ site_currency() }}{{ number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr style="border-top: 2px solid white;">
                                  <td colspan="2" style="padding: 12px; font-weight: bold; font-size: 16px; font-family: 'Times New Roman', Times, serif;">
                                    <span style="float: left;">Grand total</span>
                                    <span style="float: right;">{{ site_currency() }}{{ number_format($invoice_amount, 2) }}</span>
                                  </td>
                                </tr>
                              </table>
                            </div>
                        </td>
                    </tr>
                     <!-- Content End-->


                    <!-----------Footer----------->

                    <!-- <tr style=" background: url('{{ $invoice_footer_image }}');
                    background-repeat: no-repeat;
                    background-size: cover;
                    background-position: center;
                    height: 116px;">

                            <td >

                                <p style="width: 200px; font-size: 9px; padding-left: 50px; color: #ffffff; font-family: 'Times New Roman', Times, serif;">
                                    <span style="font-size:12px;">Notes</span>
                                    <br>
                                    <br>

Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamc.

                                </p>

                            </td>

                      </tr> -->
                    <!-----------Footer End----------->
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
