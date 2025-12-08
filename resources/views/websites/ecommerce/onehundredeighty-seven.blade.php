<!DOCTYPE html>
<html>
<head>
    <title> {{ $site_name . $invoice_number }} </title>
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        body {
            margin: 0;
            padding: 0;
            max-height:100vh;
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" style="padding:0px;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse;background: url('{{ $invoice_image4 }}');background-position: top;background-repeat: no-repeat;background-size:cover;height:1120px;">
                   <!-- header -->
                    <tr style="height: 150px;">
                        <td colspan="2" style="vertical-align:top;padding-top:90px;padding-bottom:90px">
                            <table border="0" style="border-collapse:collapse;padding:0;" width="100%">
                                <tr style="">
                                    <td style="width:50%;"></td>
                                    <td style="width:50%;" align="left" style="vertical-align:ceter">
                                        <div style="width:40%;padding-left:50px;text-align: left;">
                                            <p style="margin: 0px;font-size: 10px;font-family: Lato;color: #90b3eb;line-height: 16px;">
                                                Invoice Number
                                            </p>
                                            <p style="margin: 0px;font-size:10px;font-family: Lato;font-weight:800;">
                                                {{ $invoice_number }}
                                            </p>
                                        </div>
                                        <br>
                                        <div style="width:40%;padding-left:50px;text-align: left;">
                                            <p style="margin: 0px;font-size: 10px;font-family: Lato;color: #90b3eb;line-height: 16px;">
                                                Invoice Date
                                            </p>
                                            <p style="margin: 0px;font-size:10px;font-family: Lato;font-weight:800;">
                                                {{ $invoice_date }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr> 
                    <!-- header -->

                    <!-- some data -->
                     <tr style="height:100px;">
                        <td style="padding-left:50px">
                            <p style="margin: 0px;font-size:12px;font-family: Lato;font-weight:800;color: #ffffff;padding-top: 15px;">
                                Invoice To :
                            </p>
                            <p style="margin: 0px;font-size:16px;font-family: Lato;font-weight:500;color: #ffffff;text-align: left;">
                                {{ $customer_name ? $customer_name : '' }}<br>
                                {{ $customer_email ? $customer_email : '' }}<br>
                                {{ $customer_mobile ? $customer_mobile : '' }}
                            </p>
                        </td>
                        <td style="padding-right:50px">
                            <p style="margin: 0px;font-size:12px;font-family: Lato;font-weight:800;color: #ffffff;padding-top: 20px;">
                                Total Due
                            </p>
                            <p style="margin: 0px;font-size:24px;font-family: Lato;font-weight:700;color: #ffffff;">
                                {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}
                            </p>
                        </td>
                     </tr>
                    <!-- some data -->

                      <!-- content -->
                        <tr style="height:840px">
                            <td style="vertical-align: top;padding: 0px 50px;">
                             

                                <table style="width:80%;border-collapse: collapse;margin-top:50px;margin-left:20px;border-radius:10px;border:none;" border="0">
                                    <tr style="background:white;">
                                        <td style="padding: 10px;width: 40%;border-radius:40px 0px 0px 40px;background:white;">
                                            <p style="margin: 0px;font-size: 10px;font-family: Lato;color:#194fba;line-height: 16px;font-weight:600;">
                                                DESCRIPTION
                                            </p>
                                        </td>
                                        <td style="padding: 10px;width:30%;background:white;" align="center">
                                            <p style="margin: 0px;font-size: 10px;font-family: Lato;color:#194fba;line-height: 16px;font-weight:600;">
                                                UNIT PRICE
                                            </p>
                                        </td>
                                        <td style="padding: 10px;width: 10%;background:white;" align="center">
                                            <p style="margin: 0px;font-size: 10px;font-family: Lato;color:#194fba;line-height: 16px;font-weight:600;">
                                                QTY
                                            </p>
                                        </td>
                                        <td style="padding: 10px;width: 20%;border-radius:0px 40px 40px 0px;background:white;" align="center">
                                            <p style="margin: 0px;font-size: 10px;font-family: Lato;color:#194fba;line-height: 16px;font-weight:600;">
                                                TOTAL
                                            </p>
                                        </td>
                                    </tr>
                                    @foreach ($products as $product)
                                    <tr style="">
                                            <td style="padding: 10px;width: 40%;">
                                                <p style="margin: 0px;font-size:11px;font-family: Lato;color:#ffffff;line-height: 16px;font-weight:700;">
                                                    {{ $product->name }}
                                                </p>
                                            </td>
                                            <td style="padding: 10px;width:30%;" align="center">
                                                <p style="margin: 0px;font-size:11px;font-family: Lato;color:#ffffff;line-height: 16px;font-weight:700;">
                                                    {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}
                                                </p>
                                            </td>
                                            <td style="padding: 10px;width: 10%;" align="center">
                                                <p style="margin: 0px;font-size:11px;font-family: Lato;color:#ffffff;line-height: 16px;font-weight:700;">
                                                    1
                                                </p>
                                            </td>
                                            <td style="padding: 10px;width: 20%;" align="center">
                                                <p style="margin: 0px;font-size:11px;font-family: Lato;color:#ffffff;line-height: 16px;font-weight:700;">
                                                    {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}
                                                </p>
                                            </td>
                                    </tr>
                                    @endforeach
                                </table>
                                <table style="width:80%;border-collapse:collapse;margin-left:20px;" border="0" cellspacing="0" cellpadding="0">
                                    <tr style="height:30px;">
                                        <td></td>
                                        <td style="padding:0px 20px;width: 10%;border-radius:40px 0px 0px 0px;background:white;border:0;" align="center" colspan="2">
                                            <p style="margin: 0px;font-size:9px;font-family: Lato;color:#194fba;line-height: 16px;">
                                                SUBTOTAL
                                            </p>
                                        </td>
                                        <td style="padding:0px 20px;width: 20%;border-radius:0px 40px 0px 0px;background:white;border:0;" align="center">
                                            <p style="margin: 0px;font-size:10px;font-family: Lato;line-height: 16px;font-weight: 700;">
                                                {{ site_currency() . number_format($invoice_amount + $discount_amount ?? 0, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr style="height:30px;">
                                        <td></td>
                                        <td style="padding:0px 20px;width: 10%;border-radius:0px 0px 0px 40px;background:white;border:0;" align="center" colspan="2">
                                            <p style="margin: 0px;font-size:9px;font-family: Lato;color:#194fba;line-height: 16px;">
                                                DISCOUNT
                                            </p>
                                        </td>
                                        <td style="padding:0px 20px;width: 20%;border-radius:0px 0px 40px 0px;background:white;border:0;" align="center">
                                            <p style="margin: 0px;font-size:10px;font-family: Lato;line-height: 16px;font-weight: 700;">
                                                {{ site_currency() . number_format($discount_amount ?? 0, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                             
                                <!-- <table style="border-collapse: collapse;width:100%;position:absolute;bottom:0px;">
                                    <tr>
                                        <td align="right" style="padding-right:80px;padding-bottom:40px;">
                                        <p style="margin: 0px;font-size:12px;font-family: Lato;color:#ffffff;line-height: 16px;font-weight: 700;">
                                            {!! $company_address !!}
                                        </p><br>

                                        <p style="margin: 0px;font-size:9px;font-family: Lato;color:#ffffff;line-height: 16px;">
                                            {{ $company_email }}<br>
                                            {{ $company_mobile }} 
                                            
                                        </p>
                                    </td>
                                    </tr>
                                </table> -->

                                <div style="border-collapse: collapse;width:fit-content;position:absolute;bottom:0px;right:0px;">
                                    <div style="padding-right:80px;padding-bottom:40px;">
                                        <p style="margin: 0px;font-size:12px;font-family: Lato;color:#ffffff;line-height: 16px;font-weight: 700;">
                                            {!! $company_address !!}
                                        </p><br>

                                        <p style="margin: 0px;font-size:9px;font-family: Lato;color:#ffffff;line-height: 16px;">
                                            {{ $company_email }}<br>
                                            {{ $company_mobile }} 
                                        </p>
                                    </div>
                                </div>
                            </td>

                            
                                
                        </tr>
                    <!-- content -->
                </table>
                <div style="rotate: 90deg;position: absolute; top: 500px; left: 69%;">
                    <h1 style="color: #FFFFFF;font-size: 80px;letter-spacing: 15px;font-family: Montserrat;">INVOICE</h1>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
