<!DOCTYPE html>
<html>
<head>
    <style>
        *{
            margin: 0px;
            padding: 0px;
        }
    </style>
    <title>{{ $site_name . $invoice_number }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" style="padding:0px;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
                    <!-- Header -->
                    <tr style="height:270px;background:url('{{ $invoice_header_image }}');background-size:cover;background-repeat:no-repeat;">
                        <td style="width: 50%;">
                            <img src="{{ $company_logo }}" alt="" style="width:200px;margin-left:50px;">

                        </td>
                        <td style="width: 50%;padding-right:50px;">
                          <h1 style="font-family: Soleil Bk;font-size:41px;color:#bfc543;text-align:right;margin:0px;">INVOICE</h1>
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                       <td colspan="2">
                        <table width="100%" style="border-collapse: collapse;">
                            <tr>
                                <td style="background:#172f32;width:46.4%;vertical-align:top;padding:0px 50px 50px 50px;">
                                    <p style="font-family: Soleil Bk;font-size:13px;color:#ffffff;margin:0px;line-height:24px">
                                    Invoice To : 
                                    </p>
                                    <p style="font-family: Soleil Bk;font-size:14px;color:#bfc543;margin:0px;line-height:24px">
                                        {{ $customer_name }}
                                    </p>
                                </td>
                                <td style="padding:0px 50px 50px 50px;">
                                    <p style="font-family: Soleil Bk;font-size:13px;color:#000000;margin:0px;line-height:24px;font-weight:700;">
                                    Invoice Information : 
                                    </p>
                                    <p style="font-family: Soleil Bk;font-size:11px;color:#000000;margin:0px;line-height:14px;">
                                    Invoice Number <br>
                                    {{ $invoice_number }} <br> <br>
                                    Invoice Date  <br>
                                    {{ $invoice_date }}
                                    </p>
                                </td>
                            </tr>
                        </table>
                        <table style="width: 100%;border-collapse:collapse;height:600px;">
                            <tr style="background:#111f21;height:60px;">
                                <td style="padding:10px;width:46.4%;padding-left:50px;">
                                <p style="font-family: Soleil Bk;font-weight: bold; font-size:12px;color:#bfc543;margin:0px;line-height:16px">
                                    DESCRIPTION
                                </p>
                                </td>
                                <td style="padding:10px;" align="center">
                                 <p style="font-family: Soleil Bk;font-weight: bold;font-size:12px;color:#bfc543;margin:0px;line-height:16px">
                                    UNIT PRICE
                                </p>
                                </td>
                                <td style="padding:10px;" align="center">
                                 <p style="font-family: Soleil Bk;font-weight: bold;font-size:12x;color:#bfc543;margin:0px;line-height:16px">
                                    QTY
                                </p>
                                </td>
                                <td style="padding:10px;" align="center">
                                 <p style="font-family: Soleil Bk;font-weight: bold;font-size:12px;color:#bfc543;margin:0px;line-height:16px">
                                    TOTAL
                                </p>
                                </td>
                            </tr>
                            @foreach($products as $index => $product)
                            <tr style="max-height:60px;">
                                <td style="padding:10px;width:46.4%;padding-left:50px;background:#172f32;border-bottom:1px solid #ffffff;">
                                <p style="font-family: Soleil Lt;font-size:11px;color:#ffffff;margin:0px;line-height:12px;font-weight:600">
                                    {{ $product->name }}
                                </p>
                                <p style="font-family: Soleil Lt;font-size:9px;color:#ffffff;margin:0px;line-height:10px;">
                                    IMAGES : {{ $product->imagecount }}
                                </p>
                                <p style="font-family: Soleil Lt;font-size:9px;color:#ffffff;margin:0px;line-height:10px;">
                                  WORDS :  {{ $product->wordcount }}
                                </p>
                                </td>
                                <td style="padding:10px;" align="center">
                                 <p style="font-family: Soleil Lt;font-size:11px;color:#000000;margin:0px;line-height:16px">
                                    {{ site_currency() . number_format($product->unit_price, 2) }}
                                </p>
                                </td>
                                <td style="padding:10px;" align="center">
                                 <p style="font-family: Soleil Lt;font-size:11px;color:#000000;margin:0px;line-height:16px">
                                   1
                                </p>
                                </td>
                                <td style="padding:10px;" align="center">
                                 <p style="font-family: Soleil Lt;font-size:11px;color:#000000;margin:0px;line-height:16px">
                                    {{ site_currency() . number_format($product->unit_price, 2) }}
                                </p>
                                </td>
                            </tr>
                            
                            @endforeach
                            <tr style="height:240.5px;">
                                <td style="background:#172f32;"></td>
                                <td colspan="3" style="background:url('{{ $invoice_image1 }}');background-repeat:no-repeat;background-size:cover;padding:20px;vertical-align:top;" align="right">
                                    <table style="width: 50%;border-collapse:collapse;">
                                        <tr>
                                            <td align="center">
                                            <p style="font-family: Soleil Bk;font-weight: bold;font-size:11px;color:#ffffff;margin:0px;line-height:24px">
                                            Sub Total
                                            </p>
                                            </td>
                                            <td align="center">
                                            <p style="font-family: Soleil Bk;font-weight: bold;font-size:11px;color:#ffffff;margin:0px;line-height:24px">
                                                {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                            </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                            <p style="font-family: Soleil Bk;font-weight: bold;font-size:11px;color:#ffffff;margin:0px;line-height:24px">
                                           Discount
                                            </p>
                                            </td>
                                            <td align="center">
                                            <p style="font-family: Soleil Bk;font-weight: bold;font-size:11px;color:#ffffff;margin:0px;line-height:24px">
                                                {{ site_currency() . number_format($discount_amount, 2) }}
                                            </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="border-top:1px solid #bfc543;">
                                            <p style="font-family: Soleil Bk;font-weight: bold;font-size:11px;color:#bfc543;margin:0px;line-height:24px">
                                           TOTAL
                                            </p>
                                            </td>
                                            <td align="center" style="border-top:1px solid #bfc543;">
                                            <p style="font-family: Soleil Bk;font-weight: bold;font-size:11px;color:#bfc543;margin:0px;line-height:24px">
                                                {{ site_currency() . number_format($invoice_amount, 2) }}
                                            </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <!--<tr height="100%">
                            <td style="background:#172f32;"></td>
                            <td></td>
                            </tr>-->
                        </table>
                       </td> 
                    </tr>
                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr style="width:100%">
                        <td colspan="2">
                            <table style="border-collapse:collapse;width:100%;">
                                <tr>
                                   <td style="background:#172f32;padding:20px 50px;height:98px;width:46.4%">
                            <p style="font-family: Soleil Bk;font-size:11px;color:#bfc543;margin:0px;line-height:12px">
                            CONTACT US <br>
                            SISISERVICES OI
                            </p>
                            <p style="font-family: Soleil Bk;font-size:9px;color:#ffffff;margin:0px;line-height:12px">
                                {{ $company_name }}<br>
                                {!! $company_address !!} <br>
                                {{ $company_mobile }}</br>
                                {{ $company_email }}
                            </p>
                        </td>
                        <td style="padding:20px;width:53.6" align="right"> 
                            <p style="font-family: Soleil Bk;font-size:30px;color:#000000;margin:0px;line-height:32px">
                                Thank You!
                            </p>
                        </td>
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
