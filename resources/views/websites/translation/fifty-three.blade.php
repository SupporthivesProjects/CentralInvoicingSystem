<!DOCTYPE html>
<html>
<head>
    <title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        *{
            margin:0px;
            padding:0px;
        }
        .header-row th {
            padding: 10px;
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse;">
                      <!-- Header -->
                      <tr style=" background: url('{{ $invoice_header_image }}');
                      background-repeat: no-repeat;
                      background-size: cover;
                      background-position: center;
                      height: 100px;">
                        <td style="">
                            <img src="" alt="" style="display: block;height:60px;">
                        </td>
                      </tr>

                    <!-- Header End -->

                     <!-- Content-->
                     <tr>
                        <td style="padding:50px; padding-bottom: 100px;">


                            <table style="width: 100%;">
                                    <tr>
                                            <td>
                                                <p style="font-size: 10px;font-family: arial; color: #000000; margin: 0px;"> <b>Date:</b> {{ $invoice_date }}</p>
                                                <p style="font-size: 10px;font-family: arial; color: #000000; margin: 0px;"><b>Invoice Number:</b> #{{ $invoice_number }}</p>
                                            </td>
                                            <td>
                                                <p style="font-size: 28px;font-family: arial; color: #000000; margin: 0px; text-align: right;"><b>
                                                    INVOICE
                                                </b></p>
                                            </td>
                                    </tr>

                            </table>

                            <table style="width: 100%; margin-top: 20px;">
                                <tr>
                                        <td>
                                            <p style="font-size: 10px;font-family: arial; color: #000000; margin: 0px;"> <b>Billed From:</b> </p>
                                            <p style="font-size: 10px;font-family: arial; color: #000000; margin: 0px;"><b>{{ $company_name ?? '123 Translators' }}</b>
                                            </p>
                                        </td>
                                        <td>
                                            <p style="font-size: 10px;font-family: arial; color: #000000; margin: 0px;text-align: right;"> <b>Billed To:</b> </p>
                                            <p style="font-size: 10px;font-family: arial; color: #000000; margin: 0px; text-align: right;"><b>{{ $customer_name }}</b>
                                            </p>
                                        </td>
                                </tr>



                            </table>

                            <table  style="width: 100%; margin-top: 5px;">
                                <tr>
                                    <td>
                                        <p style="font-size: 10px;font-family: arial; color: #000000; margin: 0px;">
                                            {{ $site_name }}<br>
                                            {{ $company_email ?? 'support@123translators.com' }}
                                            </p>
                                    </td>
                                </tr>
                            </table>

                            <div style="min-height: 550px !important">
                            <table cellspacing="0" cellpadding="10" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; margin-top: 30px;">
                                <!-- Header Row -->
                                <tr style="background-color: #F265AD; color: white; font-weight: bold; font-size: 11px;" class="header-row">
                                    <th style="text-align: left;">Description</th>
                                    <th style="text-align: center;">No. Pages/Words</th>
                                    <th style="text-align: center;">Unit Price</th>
                                    <th style="text-align: center;">Total</th>
                                </tr>

                                <!-- Data Row -->
                                @foreach($products as $product)
                                <tr style="border-bottom: 1px solid #ccc;">
                                    <td style="padding-bottom: 10px; padding-top: 5px;">
                                        <p style="font-weight: normal; font-size: 8px; margin: 0; margin-bottom: 10px">{{$product->name}}</p>
                                        </p>
                                        <p style="font-weight: normal;font-size: 8px; margin: 0;"><b>From Language:</b>{{ $product->from_language }}</p>
                                        <p style="font-weight: normal;font-size: 8px; margin: 0;"><b>To Language:</b> {{ $product->to_language }}</p>
                                        </p>
                                        <p style="font-weight: normal;font-size: 8px; margin: 0;margin-top: 10px"><b>Urgency:</b> {{ $product->is_urgent ? 'Yes (+' . site_currency() . number_format($product->urgent_amount, 2) . ')' : 'No' }}</p>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;font-size: 8px; padding: 0;">{{$product->pages}}</td>
<<<<<<< HEAD
                                    <td style="text-align: center; vertical-align: middle;font-size: 8px;  padding: 0;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                    <td style="text-align: center; vertical-align: middle;font-size: 8px;  padding: 0;">{{ site_currency() . number_format($product->line_total, 2) }}</td>
=======
                                    <td style="text-align: center; vertical-align: middle;font-size: 8px;  padding: 0;">{{ site_currency() . number_format($product->unit_price,2) }}</td>
                                    <td style="text-align: center; vertical-align: middle;font-size: 8px;  padding: 0;">{{ site_currency() . number_format($product->line_total,2) }}</td>
>>>>>>> 407a088b41af428e69f4eb681f5d000d295e8a3b
                                </tr>
                                @endforeach
                            </table>
                            </div>

                            <table style="width: 250px; border-collapse: collapse; font-family: Arial, sans-serif; margin-left: auto;">
                                <!-- Subtotal Row -->
                                <tr>
                                    <td style="font-weight: bold; padding: 8px; font-size: 10px;">Subtotal</td>
                                    <td style="text-align: right; font-weight: bold; padding: 8px;font-size: 10px;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                </tr>

                                <!-- Divider -->
                                <tr>
                                    <td colspan="2">
                                        <hr style="border: none; border-top: 1px solid #ccc; margin: 0;">
                                    </td>
                                </tr>

                                <!-- Discount Row -->
                                <tr>
                                    <td style="font-weight: bold; padding: 8px;font-size: 10px;">Discount</td>
                                    <td style="text-align: right; font-weight: bold; padding: 8px;font-size: 10px;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                </tr>

                                <!-- Grand Total Row -->
                                <tr style="background-color: #f26cb0; color: white;">
                                    <td style="font-weight: bold; padding: 10px;font-size: 10px;">Grand Total</td>
                                    <td style="text-align: right; font-weight: bold; padding: 10px;font-size: 10px;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                </tr>
                            </table>

                        </td>


                    </tr>
                     <!-- Content End-->


                    <!-----------Footer----------->
                    <tr style="
                    height: 60px;">
                            <td style=" display: flex; flex-direction: column; align-items: center;
                            justify-content: center;">

                                <p style="font-family: arial;font-size: 11px;font-weight: 400; margin: 0px;">Thank you for your business,
                                </p>
                                <p style="font-family: arial;font-size: 11px;font-weight: 400; margin: 0px; color: #F265AD;"><b>
                                    123Translators Team
                                </b>
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
