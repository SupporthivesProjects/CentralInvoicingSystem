<!DOCTYPE html>
<html>
<head>
    <title>swifttranslation
    </title>
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
                        <td style="padding: 50px 50px 50px 50px;">
                            <p style="font-family: arial;font-size: 36px;font-weight: 400; color: #070034; margin: 0;">INVOICE</p>
                        </td>
                      </tr>
                    <!-- Header End -->

                     <!-- Content-->
                     <tr>
                        <td style="padding:40px; padding-bottom: 100px;">

                            <table style="width: 100%;">
                                <tr>
                                    <td>
                                        <p style="color: #070034;font-size: 11px; font-family: arial; margin: 0;"><b>BILLED FROM:</b></p>

                                        <p style="color: #7F7F7F; font-size: 11px; font-family: arial; margin: 0;">
                                            {{ $site_name }}<br>
                                            {{ $company_address }}<br>
                                            {{ $company_mobile }}<br />
                                            {{ $company_email }}


                                        </p>

                                    </td>

                                    <td style="vertical-align: top;">
                                        <p style="color: #070034;font-size: 11px; font-family: arial;margin: 0; text-align: right;"><b>INVOICE № {{$invoice_number}}</b></p>
                                        <p style="color: #070034;font-size: 11px; font-family: arial;margin: 0; text-align: right;"><b>DATE: {{ $invoice_date }}
                                        </b></p>


                                    </td>
                                </tr>
                            </table>

                                <table style="width: 100%; margin-top: 30px;">
                                    <tr>
                                        <td>
                                            <p style="color: #070034;font-size: 11px; font-family: arial; margin: 0;"><b>BILLED TO:</b></p>

                                            <p style="color: #7F7F7F; font-size: 11px; font-family: arial; margin: 0;">
                                                {{ $customer_name }}

                                            </p>
                                        </td>
                                    </tr>
                                </table>

                                <div style="min-height: 430px !important;">
                                <table width="100%"  cellspacing="0" cellpadding="10" style="border: 1px solid #ccc; border-collapse: separate; font-family: Arial, sans-serif; margin-top: 30px;">
                                    <!-- Header Row -->
                                    <tr style="background-color: #FE9B00; color: white; font-weight: bold; text-align: center; font-size: 10px;font-family: Arial, sans-serif;">
                                        <td style="padding-left: 10px; padding-right: 0px; text-align: left;">SERVICE TYPE</td>
                                        <td style="padding-left: 0px; padding-right: 0px; text-align: center;">PAGES</td>
                                        <td style="padding-left: 0px; padding-right: 0px; text-align: center;">URGENCY</td>
                                        <td style="padding-left: 0px; padding-right: 0px; text-align: center;">UNIT PRICE</td>
                                        <td style="padding-left: 0px; padding-right: 0px; text-align: center;">TOTAL</td>
                                    </tr>
                                    @foreach($products as $product)
                                    <!-- Content Row -->
                                    <tr style="background-color: white; color: #070034; vertical-align: top; font-size: 10px;font-family: Arial, sans-serif;">
                                        <td>
                                            {{$product->name}}<br>
                                            From {{ $product->from_language }} to {{ $product->to_language }}
                                        </td>
                                        <td style="text-align: center;">{{ $product->pages }}</td>
                                        <td style="text-align: center;">{{ $product->is_urgent ? 'Yes (+' . site_currency() . number_format($product->urgent_amount, 2) . ')' : 'No' }}</td>
                                        <td style="text-align: center;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                        <td style="text-align: right;">{{ site_currency() . number_format($product->line_total, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </table>

                                <table cellspacing="0" cellpadding="10" style="border: 1px solid #ccc; border-collapse: separate; font-family: Arial, sans-serif; width: 250px; margin-left: auto; margin-top: 30px;">
                                    <tr>
                                        <td style="color: #7F7F7F; border: none;font-size: 10px; font-family: Arial, sans-serif;">Subtotal</td>
                                        <td style="text-align: right; color: #7F7F7F; border: none;font-size: 10px; font-family: Arial, sans-serif;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color: #7F7F7F; border: none;font-size: 10px; font-family: Arial, sans-serif;">Discount</td>
                                        <td style="text-align: right; color: #7F7F7F; border: none;font-size: 10px; font-family: Arial, sans-serif;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="border-top: 1px solid #ccc; padding: 0px;"></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; color: #070034; border: none; font-size: 10px; font-family: Arial, sans-serif;">GRAND TOTAL</td>
                                        <td style="text-align: right; font-weight: bold; color: #070034; border: none; font-size: 10px; font-family: Arial, sans-serif;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
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
                    height: 130px;">
                            <td style=" display: flex; flex-direction: column; justify-content: center;align-items: center;margin-top: 20px;">
                                <p style="font-family: arial;font-size: 11px;font-weight: 400; margin: 0px; color: white;">{{ $site_name }}
                                </p>
                                <br>

                                <p style="font-family: arial;font-size: 8px;font-weight: 400; margin: 0px; color: white;">{{ $company_address }}


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
