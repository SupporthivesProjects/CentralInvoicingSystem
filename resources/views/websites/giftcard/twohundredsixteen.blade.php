<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        .footer-fixed {
            position: fixed;
            bottom: 0px;
            left: 0;
            right: 0;
            width: 100%;
            /* background: url('{{ $invoice_footer_image }}') center center no-repeat; */
            /* background-size: cover; */
        }
    </style>
</head>

<body style="margin:0; padding:0; font-family:Arial, sans-serif; background:#f4f4f4;">
    <!-- Header -->
    <table cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse; margin:0 auto;">
        <tr>
            <td colspan="4"
                style="background-image: url('{{ $invoice_image3 }}'); background-size: 100% 100%; padding:65px 0;text-align:center;">
                <h1 style="color:black; font-size:48px; margin:10px 0 0 0;">Invoice</h1>
            </td>
        </tr>

        <!-- Middle Content (Wrapped in Single Table with White BG + BG Image Option) -->
        <tr>
            <td colspan="4"
                style="background-color:#fff; background-image:url('{{ $invoice_image5 }}'); background-size:100% 100%; background-position:center; padding:20px;">

                <table style="width:100%; border-collapse:collapse;">

                    <!-- Invoice Number and Date -->
                    <tr>
                        <td colspan="4" style="padding: 70px 0 0px; background-color: transparent;">
                            <table style=" width:100%; border-collapse:collapse;">
                                <tr>
                                    <td
                                        style="background:#8CC63F; color:#000; font-weight:bold; font-size:14px; padding:10px; width:48%; text-align: center;">
                                        Invoice Number: <span style="color:#000;">{{ $invoice_number }}</span>
                                    </td>
                                    <td style="width:4%;"></td>
                                    <td
                                        style="background:#8CC63F; color:#000; font-weight:bold; font-size:14px; padding:10px; width:48%; text-align: center;">
                                        Invoice Date: <span style="color:#000;">{{ $invoice_date }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Billed To & Logo -->
                    <tr>
                        <td colspan="4" style="padding:10px 10px 5px 10px; ">
                            <table style="width:100%;">
                                <tr>
                                    <td style="font-weight:bold; font-size:14px;">BILLED TO <br>
                                        <span style="color:#999; font-size:14px; padding-top:5px;"> {{ $customer_name }}
                                        </span>
                                    </td>
                                    <td style="text-align:right;margin-top: 5px;">
                                        <img src="{{ $invoice_image2 }}" alt="FINNDEALZ" style="height:40px;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Spacer -->
                    <tr>
                        <td colspan="4" style="height:10px; "></td>
                    </tr>

                    <!-- Table Header -->
                    <tr style="background:#8CC63F; color:#fff;">
                        <td style="padding:10px; font-weight:bold;">Service Name</td>
                        <td style="padding:10px; font-weight:bold; text-align:center;">Quantity</td>
                        <td colspan="2" style="padding:10px; font-weight:bold; text-align:right;">Total</td>
                    </tr>

                    <!-- Item Rows (Sample) -->
                    @foreach($products as $product) 
                    <tr style="border-bottom:1px solid #ccc; ">
                        <td style="padding:10px;">
                            <strong>{{ $product->name }}</strong><br>
                            <span style="font-size:12px; color:#6aa612;">{{ site_currency() }}{{ $product->rrp }}</span>
                        </td>
                        <td style="padding:10px; text-align:center;">1</td>
                        <td colspan="2" style="padding:10px; text-align:right;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                    </tr>
                    @endforeach

                    <!-- Totals -->
                    <tr style="">
                        <td colspan="4" style="padding:20px 10px 100px;">
                            <table style="width:100%; border-collapse: collapse;">
                                <tbody>
                                    <tr style="font-size: 10px;">
                                        <td style="width:60%;"></td>
                                        <td style="padding:5px 10px; text-align:left;">Subtotal</td>
                                        <td style="padding:5px 10px; text-align:right;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                    </tr>
                                    <tr style="font-size: 10px; border-bottom:1px solid #000;">
                                        <td style="border-bottom: 2px solid white;"></td>
                                        <td style="padding:5px 10px; text-align:left; border-bottom:1px solid #000;">
                                            Discount</td>
                                        <td style="padding:5px 10px; text-align:right; border-bottom:1px solid #000;">
                                            {{ site_currency() . number_format($discount_amount, 2) }}</td>
                                    </tr>
                                    <tr style="font-size: 14px;">
                                        <td></td>
                                        <td style="padding:10px 10px; font-weight:bold; text-align:left;">Grand Total
                                        </td>
                                        <td style="padding:10px 10px; font-weight:bold; text-align:right;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Footer -->
         <tr>
            <td>
                <table class="footer-fixed" width="100%" cellpadding="0" cellspacing="0">
                    <tr style=" background-color: #fff;">
                        <td colspan="4" style="background-image: url('{{ $invoice_image4 }}'); background-size: 100% 100%; padding:30px;">
                            <table style="width:100%;">
                                <tr>
                                    <td style="font-size:9px; color: #fff;">
                                        Email: <a href="mailto:info@finndealz.com"
                                            style=" text-decoration:none;">{{ $company_email }}</a><br>
                                        Tel: {{ $company_mobile }}<br>
                                        Address: {!! $company_address !!}
                                    </td>
                                    <td style="text-align:right;">
                                        <img src="{{ $invoice_image6 }}" alt="FINNDEALZ" style="height:40px;">
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