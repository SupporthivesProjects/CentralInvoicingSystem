<!DOCTYPE html>
<html>
<head>
    <title>linguizt</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                      <!-- Header -->
                    <tr style="display: flex
                    ;
                        justify-content: space-between; padding: 80px 40px 40px 40px;">
                        <td>
                            <p style="font-family: arial;font-size: 14px;font-weight: 400; margin: 0px;color: #B33951; "><b>
                                Invoice Details
                            </b></p>
                            <br>
                            <br>
                            <p style="font-family: arial;font-size: 14px;font-weight: 400; margin: 0px; "><b>
                                Invoice No #{{ $invoice_number }}
                            </b></p>
                            <p style="font-family: arial;font-size: 14px;font-weight: 400; margin: 0px;"><b>
                                Invoice Date {{ $invoice_date }}
                            </b></p>
                        </td>

                        <td>
                            <div style="height: 1px; background-color: black; width: 200px; margin-bottom: 2px;">

                            </div>

                            <div style="height: 1px; background-color: black; width: 200px; margin-bottom: 30px;">

                            </div>
                            <img src="{{ $company_logo }}" alt="" style="display: block; width: 200px;">

                            <div style="height: 1px; background-color: black; width: 200px; margin-top: 30px;">

                            </div>
                        </td>
                    </tr>

                    <tr style="padding: 0px 40px;">
                       <td style="padding: 0px 40px;">
                        <p style="font-family: arial;font-size: 12px;font-weight: 400; margin: 0px;color: #414042; ">
                            Bill To
                        </p>
                        <p style="font-family: arial;font-size: 12px;font-weight: 400; margin: 0px;color: #414042; ">
                            {{ $customer_name }}
                        </p>
                       </td>
                    </tr>


                    <!-- Header End -->

                     <!-- Content-->

                     <tr style="display: flex; flex-direction: row; align-items: flex-end;">
                        <td style="padding:40px;">

                     <table style="width: 350px; font-family: Arial, sans-serif; border-collapse: collapse; font-size: 10px;">
                        <tr style="border-bottom: 1px solid #333;border-top: 1px solid #333;">
                          <th style="text-align: left; padding: 8px; font-weight: bold;">Translation Description</th>
                          <th style="text-align: left; padding: 8px; font-weight: bold;">Translation Type</th>
                          <th style="text-align: right; padding: 8px; font-weight: bold;">Total</th>
                        </tr>
                        @foreach($products as $product)
                        <tr style="border-bottom: 1px solid #333; ">
                          <td style="padding: 8px; vertical-align: top;">
                            From Language: {{ $product->from_language }}<br>
                            To Language: {{ $product->to_language }}<br>
                            No. of Pages: {{ $product->pages }}<br>
                            Urgency: {{ $product->is_urgent ? 'Yes (+' . site_currency() . number_format($product->urgent_amount, 2) . ')' : 'No' }}<br>
                          </td>
                          <td style="padding: 8px; vertical-align: top;">{{ $product->name }}</td>
                          <td style="padding: 8px; text-align: right; vertical-align: top;">{{ site_currency() . number_format($product->line_total, 2) }}</td>
                        </tr>
                        @endforeach
                      </table>
                      <!-- Totals -->
                      <table style="width: 350px; font-family: Arial, sans-serif; font-size: 10px; border-collapse: collapse;">
                        <tr>
                          <td style="width: 40%;"></td>
                          <td style="text-align: left; padding: 4px; font-weight: bold;">Sub<br>Total</td>
                          <td style="text-align: right; padding: 4px;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                        </tr>

                        <tr>
                          <td style="width: 40%;"></td>
                          <td style="text-align: left; padding: 4px; font-weight: bold;">Discount</td>
                          <td style="text-align: right; padding: 4px;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                        </tr>

                        <tr>
                            <td style="width: 40%;"></td>
                          <td style="text-align: left; padding: 4px;padding-top: 30px; font-weight: bold;  font-size: 10px;border-top: 1px solid #333; border-bottom: 1px solid #333;">Grand&nbsp;Total</td>
                          <td style="text-align: right; padding: 4px;padding-top: 30px; font-weight: bold; color: #B33951; font-size: 16px; border-top: 1px solid #333;border-bottom: 1px solid #333;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                        </tr>
                      </table>

                    </td>

                    <td style="height: fit-content;padding: 40px; padding-left: 0px;">
                        <div style="height: 1px; background-color: black; width: 200px; margin-bottom: 20px;">

                        </div>
                        <p style="font-family: arial;font-size: 14px;font-weight: 400; margin: 0px;"><b>
                            Company Details
                        </b></p>
                        <p style="font-family: arial;font-size: 12px;font-weight: 400; margin: 0px;color: #414042; ">
                          {{ $company_address ?? 'N/A' }}
                        </p>
                        <br>
                        <br>
                        <p style="font-family: arial;font-size: 12px;font-weight: 400; margin: 0px;color: #414042; ">
                            www.linguixt.com
                         </p><p style="font-family: arial;font-size: 12px;font-weight: 400; margin: 0px;color: #414042; ">
                            {{ $company_email ??'support@linguixt.com' }}
                         </p>
                    </td>

                </tr>
                     <!-- Content End-->


                    <!-----------Footer----------->


                    <tr style="height: 140px;">
                        <td>
                            <p style="font-family: arial;font-size: 32px;font-weight: 400; margin: 0px;color: #B33951; padding-left: 40px;"><b>
                                Thank You
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
