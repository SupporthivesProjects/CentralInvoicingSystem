<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .footer-fixed {
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            width: 100%;
            
        }
    </style>
</head>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" >
                <table style="border-collapse: collapse;border: 0px;background-color: white; ">
                    <!--Header-->
                    <tr style="font-family: sans-serif;font-size: 11px;">
                        <td style="width: 375px;padding: 40px;">
                            <p>{{ $invoice_date }}</p>
                        </td>
                        <td style="width: 235px;padding: 40px;text-align: end;">
                            {{ $invoice_number }} (Invoice No.)
                        </td>
                    </tr>
                        
                    <tr style="background: url({{$invoice_header_image}}) no-repeat;background-position:center;background-size:cover; height: 230px;color: white;border-collapse: collapse;font-family: sans-serif;width: 100%;">
                        <td style="padding: 43px;">
                            <p style="padding-top: 10px;padding-top: 22px;font-size: 15px;">Discountedg<b>cards</b></p>
                            <h1 style="font-size: 50px; margin: 0px;">INVOICE</h1>
                        </td>
                        <td style="text-align: end;padding: 40px;">
                            <p style="font-size: 30px;margin-bottom: 0px;font-weight: 700;">Thank You<br>for Ordering</p>
                            <p style="font-size: 10px;" href="{{ $site->site_link }}">www.discountagecards.com</p>
                        </td>
                    </tr>
                    <!--Body-->
                    <tr>
                        <td style="font-family: sans-serif;padding-left: 40px;">
                            <p style="font-size: 12px;">Invoice To</p>
                            <b style="font-size: 18px;font-weight: 800;">{{ $customer_name }}</b>
                        </td>
                    </tr>
                       <td colspan="2" style="padding: 20px 30px 10px 30px;">
                                <table style="border-collapse: collapse;">
                                     <tr style="border-collapse: collapse;height: 30px; ;font-family: sans-serif;font-size: 11px;font-weight: 700;border-bottom: 1px solid goldenrod;border-top: 1px solid goldenrod;">
                                        <td style="width: 300px;text-align: left;padding-left: 20px;">
                                        <b>ITEM DESCRIPTION</b> 
                                        </td>
                                        <td style="width: 200px;text-align: right;">
                                            <b>UNIT PRICE</b>
                                        </td>
                                        <td style="width: 200px;text-align: center;">
                                            <b>QTY</b>
                                        </td>
                                        <td style="width:200px;text-align: center;">
                                            <b>TOTAL</b>
                                        </td>
                                     </tr>
                                    @foreach($products as $product)
                                        <tr style="border-collapse: collapse;height: 30px; ;font-family: sans-serif;font-size: 11px;">
                                            <td style="width: 300px;text-align: left;padding-left: 20px;">
                                            <p>{{ $product->name }}</p>
                                            </td>
                                            <td style="width: 200px;text-align: right;">
                                                <p>{{ site_currency() }} {{ number_format($product->unit_price, 2) }}</p>
                                            </td>
                                            <td style="width: 200px;text-align: center;">
                                                <p>{{ $product->quantity ?? 1 }}</p>
                                            </td>
                                            <td style="width:200px;text-align: center;">
                                                <p>{{ site_currency() }}{{ number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                        </td>
                    <tr>

                        <td colspan="2" style="padding: 10px 30px 20px 30px;">
                                <table style="border-collapse: collapse;">
                                    <tr style="border-collapse: collapse;height: 30px; ;font-family: sans-serif;font-size: 10px;">
                                        <td style="width: 100px;text-align: left;padding-left: 20px;">
                                            <p>SUBTOTAL</p>
                                        </td>
                                        <td style="width:100px;text-align: right;padding-right: 20px;">
                                            <p>{{ site_currency() }}{{ number_format($invoice_amount + $discount_amount, 2) }}</p>
                                        </td>
                                    </tr>
                                    <tr style="border-collapse: collapse;height: 30px; ;font-family: sans-serif;font-size: 10px;">
                                        <td style="width: 100px;text-align: left;padding-left: 20px;">
                                            <p>DISCOUNT</p>
                                        </td>
                                        <td style="width:100px;text-align: right;padding-right: 20px;">
                                            <p>{{ site_currency() }}{{ number_format($discount_amount, 2) }}</p>
                                        </td>
                                    </tr>
                                    <tr style="border-collapse: collapse;height: 30px; ;font-family: sans-serif;font-size: 14px;background-color: orange;font-weight: 700px;color: white;">
                                        <td style="width: 100px;text-align: left;padding-left: 20px;">
                                            <b>TOTAL</b>
                                        </td>
                                        <td style="width:100px;text-align: right;padding-right: 20px;">
                                            <b>{{ site_currency() }}{{ number_format($invoice_amount, 2) }}</b>
                                        </td>
                                    </tr>
                                </table>
                        </td>
                    </tr>
                    
                    
                    
                    
                </table>
            </td>
        </tr>
        
    </table>
    <!--Footer-->
    <div class="footer-fixed" style="height: 100px;background-color: black;color: white; padding : 20px;">
                        <tr >
                            <td colspan="2" style="text-align: end;padding-right: 40px;font-size: 8px;">
                                <!-- <b style="font-size: 12px;">For More Information</b> -->
                                <p style="text-align: end;padding-right: 40px;font-size: 11px;">{!! $company_address !!}</p>
                                <p style="text-align: end;padding-right: 40px;font-size: 11px;">Phone #</p>
                                <p style="text-align: end;padding-right: 40px;font-size: 11px;">{{ $company_email }}</p>
                            </td>
                        </tr>
                    </div>
    
</body>
</html>
