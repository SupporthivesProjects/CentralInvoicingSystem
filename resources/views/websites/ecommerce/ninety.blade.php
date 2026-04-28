<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        .footer_bottom {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            width: 100%;
            
            
        }
        </style>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; ">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0; height: 130px;">
                            <!-- Invoice Header -->
                            <table
                                style="width: 100%; max-width: 800px; margin: 0 auto; padding: 40px; font-family: ' Montserrat - Google Fonts'; border-bottom: 1px solid gray;">
                                <tr>

                                    <td style="width: 50%; vertical-align: top;">
                                        <img src="{{ $invoice_header_image }}" alt="Logo"
                                            style="height: 60px; vertical-align: middle;">
                                        <div
                                            style="font-size: 28px; font-weight: bolder; color: black; margin-top: 10px;">
                                            INVOICE
                                        </div>
                                    </td>


                                    <td style="width: 50%; text-align: right; vertical-align: top;">
                                        <div style="font-size: 16px; font-weight: bold; color: black;"> {{ $site_name }}
                                        </div>
                                        <div style="font-size: 10px; color: black;">
                                        {!! $company_address !!}
                                        </div>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td
                            style="padding:40px;padding-top:0px;background:#ffffff; background-repeat: no-repeat;background-position: center;background-size: cover;height:444px; font-family: ' Montserrat - Google Fonts';">
                            <table style="width: 100%; max-width: 800px; margin: 20px auto; border-collapse: collapse;">
                                <tr style="background-color: #e8eff7;">
                                    <td style="padding: 10px;">
                                        <span style="font-size: 10px; font-weight: normal;">INVOICE No.</span><br>
                                        <span style="font-weight: bold; font-size: 10px;">#{{ $invoice_number }}</span>
                                    </td>
                                    <td style="padding: 10px;">
                                        <span style="font-size: 10px; font-weight: normal;">INVOICE DATE</span><br>
                                        <span style="font-weight: bold; font-size: 10px;">{{ $invoice_date }}</span>
                                    </td>
                                    <!--<td style="padding: 10px;">
                                        <span style="font-size: 10px; font-weight: normal;">INVOICE EXPORT</span><br>
                                        <span style="font-weight: bold; font-size: 10px;">{{ $invoice_date }}</span>
                                    </td>-->
                                </tr>
                            </table>

                            <!-- Billed To / From Section -->
                            <table style="width: 100%; max-width: 800px; margin: 20px auto;">
                                <tr>
                                    <!-- Billed To -->
                                    <td style="width: 50%; vertical-align: top; padding-right: 20px;">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td style="color: #0066cc; font-weight: bold; font-size: 12px;">BILLED
                                                    TO</td>
                                            </tr>
                                            <tr>
                                                <!--<td style="color: #888; font-size: 10px; vertical-align: top;">CUSTOMER
                                                    NAME</td>-->
                                                <td style="font-weight: bold; font-size: 10px; vertical-align: top;">
                                                     {{ $customer_name }} 
                                                   </td>
                                            </tr>

                                            <!--<tr>
                                                <td style="color: #888; font-size: 10px; vertical-align: top;">CUSTOMER
                                                    EMAIL</td>
                                                <td style="font-weight: bold; vertical-align: top; font-size: 10px;">
                                                  {{ $customer_email }}
                                                </td>
                                            </tr>-->

                                        </table>
                                    </td>

                                    <!-- Billed From -->
                                    <td style="width: 50%; vertical-align: top;">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td style="color: #0066cc; font-weight: bold; font-size: 12px;">BILLED
                                                    FROM</td>
                                            </tr>
                                            <tr>
                                                <!--<td style="color: #888; font-size: 10px; vertical-align: top;">ADDRESS
                                                </td>-->
                                                <td style="font-weight: bold; vertical-align: top; font-size: 10px;">
                                                    {!! $company_address !!}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <div style="min-height: 470px !important;">
                            <table
                                style="width: 100%; max-width: 800px; margin: 0 auto; font-size: 14px; border-collapse: collapse; margin-top: 30px;">
                                <tr style="background-color: #002b6c; color: white; text-align: left;">
                                    <th style="padding: 10px;">Product</th>
                                    <th style="padding: 10px;">Qty</th>
                                    <th style="padding: 10px;">Price</th>
                                    <th style="padding: 10px;">Total</th>
                                </tr>
                                @foreach($products as $product)
                                <tr>
                                    <td style="padding: 10px;">
                                        <span style="font-size: 12px; color: #386BDC;">{{ $product->category_name }}</span><br>
                                        <span style=" font-size: 14px;">{{ $product->name }}</span>
                                    </td>
                                    <td style="padding: 10px; color: #405F8E;">1</td>
                                    <td style="padding: 10px; color: #405F8E;">{{ site_currency() }} {{  number_format($product->unit_price, 2) }}</td>
                                    <td style="padding: 10px; color: #405F8E;">{{ site_currency() }} {{  number_format($product->unit_price, 2) }}</td>
                                </tr>
                                @endforeach
                            </table>

                            <!-- Total Calculation Table -->
                            <table
                                style="width: 100%; max-width: 800px; margin: 20px auto; border-collapse: collapse; font-size: 14px;">
                                <tr>
                                    <td style="width: 60%;"></td>
                                    <td style="padding: 8px; color: #666666; border-top: 1px solid #D8D8D8;">SUB TOTAL
                                    </td>
                                    <td
                                        style="padding: 8px; font-weight: bold; color: #405F8E; border-top: 1px solid #D8D8D8;">
                                        {{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="padding: 8px; color: #666666;">DISCOUNT</td>
                                    <td style="padding: 8px; font-weight: bold; color: #405F8E;">{{ site_currency() }} {{ number_format($discount_amount, 2) }}</td>
                                </tr>
                                
                                <tr style="border-top: 1px solid #132A68; font-size: 16px;">
                                    <td></td>
                                    <td style="padding: 10px; font-weight: bold; color: #405F8E;">TOTAL VALUE</td>
                                    <td style="padding: 10px; font-weight: bold; color: #405F8E;">{{ site_currency() }} {{ number_format($invoice_amount, 2) }}</td>
                                </tr>
                            </table>
                            </div>
                        </td>
                    </tr>
                    

                        <tr>
                            <table class="footer_bottom">
                            <td>
                                <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                    style="border-collapse: collapse; width: 100%; max-width: 800px;">
                                    <tr
                                        style="background: url('{{ $invoice_footer_image }}') no-repeat;background-position: center; font-family: 'Montserrat'; color: white;background-size: cover;height:141px;padding:50px;background-size:cover;width: 100%; margin:0px;">
                                        <td style="padding: 30px; width: 60%;">
                                        <!-- <strong
                                                style="display: block; font-size: 10px; margin-bottom: 10px;">NOTES</strong>
                                            <p style="margin: 0; font-size: 9px; line-height: 1.6;">
                                            Please review the invoice details carefully. <br>
                                            If there are any discrepancies or questions, <br>
                                            contact support at {{ $company_email }}.
                                            </p>-->
                                        </td>

                                        <!-- Right: Contact Info -->
                                        <td style="padding: 30px; text-align: right; font-size: 10px; width: 40%;">
                                            <div style="margin-bottom: 8px; font-size: 10px;">{{ $company_mobile  }}</div>
                                            <div style="margin-bottom: 8px; font-size: 10px;">{{ $site_name }}</div>
                                            <div> {!! $company_address !!}</div>
                                        </td>
                                    </tr>

                                </table>
                            </td>
                            </table >
                        </tr>
                    
                    <!-----------Footer End----------->
                </table>
            </td>
        </tr>
    </table>
</body>

</html>