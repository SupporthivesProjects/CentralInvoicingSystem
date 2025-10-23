<!DOCTYPE html>
<html>
<head>
    <title>Your Email Title</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<style>
        * {
            margin: 0px;
            padding: 0px;
        }
        .footer_bg {
            /* background: url('{{ $invoice_image1 }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover; */
            /* height: 150px; */
            /* vertical-align: bottom; */
            position: absolute;
            bottom: 50px;
            left: 0;
            /* display: flex;
            flex-direction: row;
            justify-content: flex-start;
            align-items: center; */
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" >
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; ">
                     <!---header--->
                    <tr>
                        <td align="center" style="height:140px;background:url('{{ $invoice_header_image }}');background-size: cover;background-repeat: no-repeat;background-position: center;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;">
                                         <tr>
                                            <td align="left" style="width: 50%;padding-left: 25px;">
                                                <h1 style="margin: 0px;font-family:Source Sans Pro;font-size:21px;color: #000000;">
                                                   Invoice Details
                                                </h1>
                                            </td>
                                            <td align="center" style="width: 50%;padding-right: 40px;">
                                                <img src="{{ $company_logo }}" alt="" style="height:60px;">
                                            </td>
                                         </tr>
                            </table>
                        </td>
                    </tr>
                    <!---header End--->
                    <!-- Content -->
                    <tr style="background:#ffff ;">
                        <td style="padding:0px;">
                            <!-- <div style="min-height: 950px !important;"> -->
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;min-height: 950px !important;">
                                <tr style="min-height: 950px !important;">
                                    <td style="width:20px;"></td>
                                    <td align="center" style="vertical-align: top;">
                                       <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;">
                                        <tr style="border-top: 1px solid black;border-bottom:2px solid black;height:30px;">
                                            <td style="width: 50%;padding-left: 10px;">
                                                 <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color: #000000;">
                                                  Product
                                                </p>
                                            </td>
                                            <td style="width:20%;" align="center">
                                                 <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color: #000000;">
                                                  QTY
                                                </p>
                                            </td>
                                            <td style="width:30%;padding-right: 10px;" align="right">
                                                 <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color: #000000;">
                                                 Total
                                                </p>
                                            </td>
                                        </tr>
                                        @foreach($products as $product)
                                        <tr style="border-top: 1px solid black;border-bottom: 1px solid black;height:50px;">
                                            <td style="width: 50%;padding-left: 10px;">
                                                 <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color: #000000;">
                                                  {{ $product->name }}
                                                </p>
                                            </td>
                                            <td style="width:20%;" align="center">
                                                 <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color:#808080;">
                                                  01
                                                </p>
                                            </td>
                                            <td style="width:30%;padding-right: 10px;" align="right">
                                                 <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color:#808080;">
                                                 {{ site_currency() }} {{ number_format($product->unit_price, 2) }}
                                                </p>
                                            </td>
                                        </tr>
                                        @endforeach
                                         <tr style="height:30px;">
                                            <td></td>
                                            <td style="width:20%;border-bottom: 1px solid black;" align="center">
                                                 <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color:#808080;">
                                                 SUB-TOTAL
                                                </p>
                                            </td>
                                            <td style="width:30%;padding-right: 10px;border-bottom: 1px solid black;" align="right">
                                                 <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color:#808080;">
                                                 {{ site_currency() }} {{ number_format($invoice_amount + $discount_amount, 2) }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="height:30px;">
                                            <td></td>
                                            <td style="width:20%;border-bottom: 1px solid black;" align="center">
                                                 <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color:#808080;">
                                                DISCOUNT
                                                </p>
                                            </td>
                                            <td style="width:30%;padding-right: 10px;border-bottom: 1px solid black;" align="right">
                                                 <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color:#808080;">
                                                 {{ site_currency() }} {{ number_format($discount_amount, 2) }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="height:30px;">
                                            <td></td>
                                            <td style="width:20%;border-bottom:2px solid black;" align="center">
                                                 <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color:#808080;">
                                                 TOTAL
                                                </p>
                                            </td>
                                            <td style="width:30%;padding-right: 10px;border-bottom:2px solid black;" align="right">
                                                 <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color:#808080;">
                                                 {{ site_currency() }} {{ number_format($invoice_amount, 2) }}
                                                </p>
                                            </td>
                                        </tr>
                                       </table>
                                       <div class="footer_bg" width="100%" style="height: 100px;display:flex;flex-direction:row;justify-content:flex-start;align-items:center;gap:135px;">
                                        
                                                <img src="{{ $invoice_image1 }}" alt="" style="width: 200px;rotate: 90deg;">
                                        
                                                <img src="{{ $invoice_footer_image }}" alt="" style="width:100px;">
                                        
                                        </div>

                                       <!-- <table width="100%" style="height: 100px;">
                                        <tr>
                                            <td style="padding: 0px;" align="left">
                                                <img src="{{ $invoice_image1 }}" alt="" style="width: 200px;rotate: 90deg;">
                                            </td>
                                            <td>
                                                <img src="{{ $invoice_footer_image }}" alt="" style="width:100px;">
                                            </td>
                                        </tr>
                                       </table> -->
                                    </td>
                                    <td style="width:20px;"></td>
                                    <td align="center" style="min-height: 950px;vertical-align: top;width:200px;height:100%;background:url('{{ $invoice_image2 }}');background-size: cover;background-repeat: no-repeat;background-position: center;border-top: 1px solid black;padding: 20px 0px 0px 20px;">
                                        <table width="100%">
                                        <tr>
                                            <td>
                                                <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color: #000000;line-height: 12px;">
                                                  Invoice No.
                                                </p>
                                                <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color:#808080;line-height: 12px;">
                                                 {{ $invoice_number }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="height:14px;"></tr>
                                        <tr>
                                            <td>
                                                <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color: #000000;line-height: 12px;">
                                                  Invoice Date:
                                                </p>
                                                <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color:#808080;line-height: 12px;">
                                                 {{ $invoice_date }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="height:14px;"></tr>
                                        <tr>
                                            <td>
                                                <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color: #000000;line-height: 12px;">
                                                  Invoiced To:
                                                </p>
                                                <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color:#808080;line-height: 12px;">
                                                 {{ $customer_name }}
                                                </p>
                                            </td>
                                        </tr>
                                        </table>
                                        <table style="height:100px;"></table>
                                        <table width="100%">
                                        <tr>
                                            <td>
                                                <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color: #000000;line-height: 12px;">
                                                  Invoiced From:
                                                </p>
                                                <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color:#808080;line-height: 12px;">
                                                 {{ $site_name }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="height:14px;"></tr>
                                        <tr>
                                            <td>
                                                <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color: #000000;line-height: 12px;">
                                                  Company Address:
                                                </p>
                                                <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color:#808080;line-height: 12px;">
                                                 {{ $company_address }}<br />
                                                 {{ $company_mobile }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="height:14px;"></tr>
                                        <tr>
                                            <td>
                                                <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color: #000000;line-height: 12px;">
                                                 Contact :
                                                </p>
                                                <p style="margin: 0px;font-family:Source Sans Pro;font-size:9px;color:#808080;line-height: 12px;">
                                                 {{ $company_email }}
                                                </p>
                                            </td>
                                        </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <!-- </div> -->
                        </td>
                    </tr>
                    <!-- Content End-->
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
