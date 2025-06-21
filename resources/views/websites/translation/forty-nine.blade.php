<!DOCTYPE html>
<html>
<head>
    <title>Translate Text Today</title>
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
                        <td>

                        </td>
                      </tr>

                    <!-- Header End -->

                     <!-- Content-->
                     <tr>


                        <td style="padding:40px; padding-bottom: 70px;">

                            <table style="width: 100%;">

                                <tr style="font-family: arial;font-size: 11px;font-weight: 400; color: black; margin: 0;">
                                    <td>
                                        <p ><b>Invoice Number:</b> #{{ $invoice_number }}</p>
                                        <p ><b>Date: </b>{{ $invoice_date }}</p></p>
                                    </td>
                                </tr>

                                <tr style="display: flex;justify-content: space-between; ">

                                </tr>
                                <tr style="display: flex;justify-content: space-between; font-family: arial;font-size: 10px;font-weight: 400; color: black; margin: 0;">
                                    <td style="width: 45%;">
                                        <div style="border: 2px solid#0070C0 ; padding: 6px; font-family: Arial, sans-serif; font-size: 10px;">
                                           <b> Bill From</b>
                                        </div>
                                        <p style="padding: 0px 6px;"><b>{{ $company_name ?? 'TRANSLATE TEXT TODAY' }}</b></p>
                                        <p style="padding: 0px 6px;">{{ $company_address ?? 'N/A' }}<br>
                                            {{ $company_email ?? 'SUPPORT@TRANSLATETEXTTODAY.COM' }}
                                            </p>
                                            <div style="border-top: 1px solid #aaa; margin-top: 20px;"></div>
                                    </td>
                                    <td style="width: 45%;">
                                        <div style="border: 2px solid#0070C0 ; padding: 6px; font-family: Arial, sans-serif; font-size: 10px;">
                                            <b> Bill To</b>
                                         </div>
                                        <p style="padding: 0px 6px;"><b>{{ $customer_name }}</b></p>
                                        </b></p>
                                        <div style="border-top: 1px solid #aaa;margin-top: 53px; "></div>

                                    </td>
                                </tr>

                            </table>
                            <div style="min-height: 420px;">
                            <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; text-align: left; font-size: 10px; margin-top: 50px;">
                                <tr style="background-color: #0070C0; color: white;">
                                  <th style="padding: 6px;">Translation Type</th>
                                  <th style="padding: 6px;">Description</th>
                                  <th style="padding: 6px; text-align: center;">QTY</th>
                                  <th style="padding: 6px; text-align: right;">Unit Price</th>
                                  <th style="padding: 6px; text-align: right;">Total</th>
                                </tr>
                                @foreach($products as $product)
                                  <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 6px;">{{ $product->name }}</td>
                                    <td style="padding: 6px;">From: {{ $product->from_language ?? 'N/A' }} - To: {{ $product->to_language ?? 'N/A' }}
                                        <br />
                                        Total Pages: {{ $product->pages ?? 'N/A' }}
                                        <br />
                                        Urgency:
                                        {{ $product->is_urgent ? 'Yes (+' . site_currency() . number_format($product->urgent_amount, 2) . ')' : 'No' }}
                                    </td>
                                    <td style="padding: 6px; text-align: center;">1</td>
                                    <td style="padding: 6px; text-align: right;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                    <td style="padding: 6px; text-align: right;">{{ site_currency() . number_format($product->line_total, 2) }}</td>
                                  </tr>
                                @endforeach
                              </table>

                              <table style="width: 200px; font-family: Arial, sans-serif; border-collapse: collapse; margin-left: auto; margin-top: 20px;">
                                <tr>
                                  <td style="padding: 6px ; text-transform: uppercase; font-size: 10px;"><b style=" font-size: 14px;">S</b>ubtotal</td>
                                  <td style="padding: 6px ; text-align: right; font-size: 10px;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                  <td style="padding: 6px ; text-transform: uppercase; font-size: 10px;"><b style=" font-size: 14px;">D</b>iscount</td>
                                  <td style="padding: 6px ; text-align: right; font-size: 10px;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                  <td style="padding: 6px ; text-transform: uppercase; font-size: 10px;"><b style=" font-size: 14px;">T</b>ax</td>
                                  <td style="padding: 6px ; text-align: right; font-size: 10px;">N/A</td>
                                </tr>
                                <tr>
                                  <td colspan="2" style="border-top: 1px solid #aaa; "></td>
                                </tr>
                                <tr>
                                  <td style="padding: 10px 6px; text-transform: uppercase; font-weight: bold; color: #0070C0; font-size: 10px;"><b style=" font-size: 14px;">G</b>rand <b style=" font-size: 14px;">T</b>otal</td>
                                  <td style="padding: 10px 6px; text-align: right; font-weight: bold; color: #0070C0; font-size: 10px;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
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
                    height: 120px;">
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
