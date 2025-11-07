<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        *{
            margin:0px;
            padding:0px;
        }
        a {
  text-decoration: none;
}

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
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; ">
        <tr>
            <td align="center" bgcolor="#ffffff" style="padding: 0px; margin: 0px ">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; {{ $site->site_link }}">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;max-height: 130px;">
                            <table>
                            <tr>
                                <td>
                                    <img src="{{ $invoice_header_image }}" alt="" style="max-width: 100%; display: block;">
                                </td>
                            </tr>

                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td style="padding:40px;padding-top:0px;background: url(img/body_bg.png) no-repeat;background-position: center;background-size: cover;height:444px;">
                            <h2 style="color: #901918; font-family: arial; font-size: 14px;">INVOICE #{{ $invoice_number }}</h2>
                            <h2 style="color: #901918; font-family: arial; font-size: 14px;">DATE {{ $invoice_date }}</h2>
                            <br>
                            <table style="width: 100%; border: 1px solid red; border-collapse: collapse;">
                                <tr style="background-color: #f9dede;">
                                    <td style="border: 1px solid red; padding: 8px; width: 50%; font-family: arial; font-size: 9px;">
                                        <strong>Billed to</strong>
                                    </td>
                                    <td style="border: 1px solid red; padding: 8px; width: 50%; font-family: arial; font-size: 9px;">
                                        <strong>Billed from</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style=" padding: 16px 8px; display: flex; font-family: arial; font-size: 9px;">
                                        <strong>Name:</strong> {{ $customer_name }}
                                    </td>
                                    <td style="border: 1px solid red; padding: 16px 8px 30px; line-height: 16px; font-family: arial; font-size: 9px;">
                                        <p style="margin: 0; font-family: arial; line-height: 16px;"><strong>Name:</strong>&nbsp; &nbsp; &nbsp;{{ $site_name }}</p>
                                        <p style="margin: 0; font-family: arial; line-height: 16px;"><strong>Email:</strong>&nbsp; &nbsp; &nbsp;{{ $company_email  }}</p>
                                        <p style="margin: 0; font-family: arial; line-height: 16px;"><strong>Address:</strong>&nbsp; {!! $company_address !!}</p>
                                    </td>
                                </tr>
                            </table>

                            <br>
                            <br>
                            <div style="min-height: 400px !important;">
                            <table style="width: 100%; border: 1px solid red; border-collapse: collapse; text-align: center; font-size: 9px;">
                                <tr style="background-color: #f9dede;">
                                    <th style="border: 1px solid red; font-family: arial;">Qty.</th>
                                    <th style="border: 1px solid red; padding: 8px; text-align: left; font-family: arial;">Description</th>
                                    <th style="border: 1px solid red; padding: 8px; text-align: right; font-family: arial;">Unit price</th>
                                    <th style="border: 1px solid red; padding: 8px; text-align: right; font-family: arial;">Total</th>
                                </tr>
                                @foreach ($products as $product)
                                <tr>
                                    <td style="border: 1px solid red; padding: 8px; text-align: left; font-family: arial;">{{ $product->quantity ?? 1 }}</td>
                                    <td style="border: 1px solid red; padding: 8px; text-align: left; font-family: arial;">{{ $product->name }}</td>
                                    <td style="border: 1px solid red; padding: 8px; text-align: right; font-family: arial;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                    <td style="border: 1px solid red; padding: 8px; text-align: right; font-family: arial;">{{ site_currency() . number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" style="border: 1px solid red; padding: 8px; text-align: right; font-family: arial;">
                                        <strong>Subtotal</strong>
                                    </td>
                                    <td style="border: 1px solid red; padding: 8px; text-align: right; font-family: arial;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="border: 1px solid red; padding: 8px; text-align: right; font-family: arial;">
                                        <strong>Discount Total</strong>
                                    </td>
                                    <td style="border: 1px solid red; padding: 8px; text-align: right; font-family: arial;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr style="background-color: #ED978B;">
                                    <td colspan="3" style="border: 1px solid red; padding: 8px; text-align: right; font-family: arial;">
                                        <strong>Total</strong>
                                    </td>
                                    <td style="border: 1px solid red; padding: 8px; text-align: right; font-family: arial;">
                                        <strong>{{ site_currency() . number_format($invoice_amount, 2) }}</strong>
                                    </td>
                                </tr>
                            </table>
                            </div>

                           <!-- <p style="margin-top: 20px; font-family: arial; font-size: 9px;"><strong>Many Thanks for Your Custom.</strong></p>-->
                        </td>
                    </tr>
                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr class="footer_bottom">
                        <td style="padding: 0px;max-height: 130px;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr>
                                    <img src="{{ $invoice_footer_image }}" alt="" style="max-width: 100%; display: block;">
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-----------Footer End----------->
                </table>
            </td>
        </tr>
    </table>
</body>

</html>