<!DOCTYPE html>
<html>
<head>
    <title>SpeedTransaltors</title>
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
                            <img src="{{ $company_logo }}" alt="" style="display: block;height:60px;">
                        </td>
                      </tr>

                    <!-- Header End -->

                     <!-- Content-->
                     <tr>
                        <td style="padding:40px; padding-bottom: 100px;">

                            <table style="width: 100%; position: relative;">

                                <tr style="display: flex
                                ;
                                    justify-content: space-between;">

                                    <td>
                                        <p style="font-family: arial;font-size: 12px;font-weight: 400; color: #4585FD; margin: 0;">Invoice To</p>
                                        <p style="font-family: arial;font-size: 13px;margin: 0;"><b>{{ $customer_name }}</b></p>
                                    </td>
                                    <td>
                                        <p style="font-family: arial;font-size: 12px;font-weight: 400; color: #4585FD;margin: 0;">Invoice From</p>
                                        <p style="margin: 0; font-family: arial;font-size: 13px;margin: 0;"><b>Speedy Translators</b></p>
                                        <p style="margin: 0; font-family: arial;font-size: 12px;margin: 0;">Powered By Eromnet Hong Kong</p>
                                        <br>
                                        <br>
                                        <p style="margin: 0; font-family: arial;font-size: 12px;margin: 0;">{{ $company_email ?? 'Support@speedytranslators.com' }}</p></p>
                                    </td>
                                    <td>
                                        <p style="margin: 0;font-family: arial;font-size: 12px;margin: 0;">Invoice Date:</p>
                                        <p style="margin: 0;font-family: arial;font-size: 12px;margin: 0;">2023</p>
                                        <p style="margin: 0;font-family: arial;font-size: 12px;margin: 0;">Invoice  no.</p>
                                    </td>
                                    <td>
                                        <img src="{{ $invoice_image1 }}" alt="" style="position: absolute; width: 24px; height: 24px; right: 26px;
                                        top: -31px;">
                                         <img src="{{ $invoice_signiture }}" alt="" style="position: absolute; width: 24px; height: 24px; right: 141px;
                                         top: 93px;">

                                        <p style="margin: 0; font-family: arial;font-size: 12px;margin: 0;">{{ $invoice_date }}</p>
                                        <br>
                                        <br>
                                        <p style="margin: 0;font-family: arial;font-size: 12px;margin: 0;">{{ $invoice_number }}</p>
                                    </td>
                                </tr>
                            </table>
                            <div style="min-height: 480px !important;">
                            <table style="width: 100%; margin-top: 20px;" cellspacing="0" cellpadding="10" border="0" style="border-collapse: collapse; font-family: Arial, sans-serif;">


                                <tr style="background-color: #4585FD; color: white; font-family: arial;font-size: 10px; text-align: left;">
                                    <td style="padding-right: 0px; ">ITEM DESCRIPTION</td>
                                    <td style="padding-right: 0px; padding-left: 0px;">WORDS/PAGES</td>
                                    <td style="padding-right: 0px; padding-left: 0px;">URGENT</td>
                                    <td style="padding-right: 0px; padding-left: 0px;">TOTAL</td>

                                </tr>
                                @foreach($products as $product)
                                <tr style=" background-color: #ffffff; vertical-align: top;">
                                    <td style="padding: 0px; padding-top: 20px;">
                                        <span style="font-weight: bold;font-family: arial;
                                        font-size: 12px; ">{{ $product->name }}</span><br><br>
                                        <ul style="margin: 0; padding-left: 20px;">
                                            <li>
                                                <span style="font-weight: bold;font-family: arial;
                                                font-size: 12px; ">From:</span><br>
                                                <span style="font-family: arial;
                                                font-size: 10px;">{{ $product->from_language }}</span>
                                            </li><br>
                                            <li>
                                                <span style="font-weight: bold;font-family: arial;
                                                font-size: 12px; ">To:</span><br>
                                                <span style="font-family: arial;
                                                font-size: 10px;">{{ $product->to_language }}</span>
                                            </li>
                                        </ul>
                                    </td>
                                    <td style="text-align: left; vertical-align: top;font-family: arial;
                                    font-size: 10px; color: #6B6B6B;padding: 0px;padding-top: 20px;">{{$product->pages}}</td>
                                    <td style="text-align: left; vertical-align: top;font-family: arial;
                                    font-size: 10px;color: #6B6B6B;padding: 0px;padding-top: 20px;">{{ $product->is_urgent ? 'Yes (+' . site_currency() . number_format($product->urgent_amount, 2) . ')' : 'No' }}</td>
                                    <td style="text-align: left; vertical-align: top;font-family: arial;
                                    font-size: 10px;color: #6B6B6B;padding: 0px;padding-top: 20px;">{{ site_currency() . number_format($product->line_total, 2) }}</td>
                                </tr>
                                @endforeach


                            </table>

                            <table style="width: 50%; margin-left: auto; margin-top: 100px;">
                                <tr >
                                    <td colspan="4" style="border-top: 4px solid #448aff; text-align: right; font-weight: bold; padding-top: 5px; width: 50%; font-size: 14px;">
                                        Grand Total:&nbsp;&nbsp;&nbsp;{{ site_currency() . number_format($invoice_amount, 2) }}
                                    </td>
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
                    height: 53px; position: relative;">

                            <td style="padding-left: 50px; display: flex; flex-direction: row;">
                                <img src="img/orangecoin.png" alt="" style="position: absolute; width: 24px; height: 24px; right: 26px;
                                top: -31px;">
                                 <img src="{{ $invoice_image2 }}" alt="" style="position: absolute; width: 24px; height: 24px; left: 53px;
                                 top: -85px;">
                                <img src="img/icon.png" alt="" style="display: block; width: 24px; height: 24px;">
                                <p style="font-family: arial;font-size: 10px;font-weight: 400; margin: 0px;">support@speedytranslators.com</p>
                            </td>

                      </tr>
                    <!-----------Footer End----------->
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
