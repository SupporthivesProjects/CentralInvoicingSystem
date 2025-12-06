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
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" style="padding:0px;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse;">
                   <!-- header -->
                    <tr style="height:200px;">
                        <td style="vertical-align:ceter">
                            <table border="0" style="border-collapse:collapse;padding:0;" width="100%">
                                <tr style="background: url('{{ $invoice_image3 }}');background-position: center;background-repeat: no-repeat;background-size:cover;">
                                    <td style="padding:0px 50px" align="right" style="vertical-align:ceter">
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
                                    <div style="margin-top:100px;display: flex;justify-content: space-between;padding-right: 100px;">
                                       <p style="margin: 0px;font-size:12px;font-family: Lato;font-weight:800;color: #ffffff;padding-top: 15px;">
                                        Invoice To :
                                       </p>
                                       <p style="margin: 0px;font-size:12px;font-family: Lato;font-weight:800;color: #ffffff;padding-top: 20px;">
                                        Total Due
                                       </p>
                                    </div>
                                    
                                    <p style="margin: 0px;font-size:16px;font-family: Lato;font-weight:500;color: #ffffff;text-align: left;">
                                        {{ $customer_name ? $customer_name : '' }}<br>
                                        {{ $customer_email ? $customer_email : '' }}<br>
                                        {{ $customer_mobile ? $customer_mobile : '' }}
                                       </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr> 
                    <!-- header -->
                      <!-- content -->
                        <tr style="height:80vh;">
                            <td style="background: url('{{ $invoice_image2 }}');background-repeat: no-repeat;background-size:cover;height:600px;vertical-align: top;padding: 0px 50px;">
                             <p style="margin: 0px;font-size:24px;font-family: Lato;font-weight:700;color: #ffffff;text-align: right;padding-right: 100px;">
                                {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}
                                       </p>

                            <table style="width:80%;border-collapse: collapse;margin-top:50px;margin-left:20px;border-radius:10px;border:none;background:white;" border="0">
                                <tr>
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
                            </table>
                            <table style="width:80%;border-collapse:collapse;margin-top:23px;height:400px;margin-left:20px;" border="0" cellspacing="0" cellpadding="0">
                               
                               @foreach ($products as $product)
                               <tr style="height:40px;">
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
                               <tr style="height: 30px;"></tr>
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
                             
                             <table style="border-collapse: collapse;width:100%;margin-top: 50px;">
                                <tr>
                                    <td align="right">
                                    <p style="margin: 0px;font-size:12px;font-family: Lato;color:#ffffff;line-height: 16px;font-weight: 700;">
                                        {!! $company_address !!}
                                    </p><br>

                                     <p style="margin: 0px;font-size:9px;font-family: Lato;color:#ffffff;line-height: 16px;">
                                        {{ $company_email }}<br>
                                        {{ $company_mobile }} 
                                          
                                    </p>
                                  </td>
                                </tr>
                             </table>
                            </td>
                        </tr>
                    <!-- content -->
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
