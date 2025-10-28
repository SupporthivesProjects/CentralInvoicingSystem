<!DOCTYPE html>
<html>
<head>
    <title>Your Email Title</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
        }

        @page {
            size: A4;
            margin: 0;
        }

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }

        /* 🔵 HEADER background */
        .invoice-header {
            background-color: rgba(0, 128, 255, 0.2);
        }

        /* 🟢 MAIN CONTENT background */
        .invoice-body {
            background-color: rgba(0, 255, 128, 0.2);
        }

        /* 🔴 FOOTER background */
        .footer_bg {
            background-color: rgba(255, 0, 0, 0.2);
            position: absolute;
            bottom: 50px;
            left: 0;
        }

        /* 🟣 SIDEBAR background */
        .invoice-sidebar {
            background-color: rgba(128, 0, 255, 0.15);
        }

    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse;">
                    
                    <!--- 🔵 HEADER --->
                    <tr class="invoice-header">
                        <td align="center" style="height:140px;background:url('{{ $invoice_header_image }}');background-size:cover;background-repeat:no-repeat;background-position:center;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
                                <tr>
                                    <td align="left" style="width: 50%;padding-left: 25px;">
                                        <h1 style="margin: 0;font-family:'Poppins',sans-serif;font-size:21px;color:#000;">
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
                    <!--- HEADER END --->

                    <!-- 🟢 BODY --->
                    <tr class="invoice-body">
                        <td style="padding:0;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;min-height:980px !important;">
                                <tr style="min-height:980px !important;">
                                    <td style="width:20px;"></td>
                                    <td align="center" style="vertical-align: top;">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
                                            <tr style="border-top:1px solid black;border-bottom:2px solid black;height:30px;">
                                                <td style="width:50%;padding-left:10px;">
                                                    <p style="margin:0;font-family:'Poppins';font-size:9px;color:#000;">Product</p>
                                                </td>
                                                <td style="width:20%;" align="center">
                                                    <p style="margin:0;font-family:'Poppins';font-size:9px;color:#000;">QTY</p>
                                                </td>
                                                <td style="width:30%;padding-right:10px;" align="right">
                                                    <p style="margin:0;font-family:'Poppins';font-size:9px;color:#000;">Total</p>
                                                </td>
                                            </tr>
                                            @foreach($products as $product)
                                            <tr style="border-top:1px solid black;border-bottom:1px solid black;height:50px;">
                                                <td style="width:50%;padding-left:10px;">
                                                    <p style="margin:0;font-size:9px;color:#000;">{{ $product->name }}</p>
                                                </td>
                                                <td style="width:20%;" align="center">
                                                    <p style="margin:0;font-size:9px;color:#808080;">01</p>
                                                </td>
                                                <td style="width:30%;padding-right:10px;" align="right">
                                                    <p style="margin:0;font-size:9px;color:#808080;">{{ site_currency() }} {{ number_format($product->unit_price, 2) }}</p>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr style="height:30px;">
                                                <td></td>
                                                <td style="width:20%;border-bottom:1px solid black;" align="center">
                                                    <p style="margin:0;font-size:9px;color:#808080;">SUB-TOTAL</p>
                                                </td>
                                                <td style="width:30%;padding-right:10px;border-bottom:1px solid black;" align="right">
                                                    <p style="margin:0;font-size:9px;color:#808080;">{{ site_currency() }} {{ number_format($invoice_amount + $discount_amount, 2) }}</p>
                                                </td>
                                            </tr>
                                            <tr style="height:30px;">
                                                <td></td>
                                                <td style="width:20%;border-bottom:1px solid black;" align="center">
                                                    <p style="margin:0;font-size:9px;color:#808080;">DISCOUNT</p>
                                                </td>
                                                <td style="width:30%;padding-right:10px;border-bottom:1px solid black;" align="right">
                                                    <p style="margin:0;font-size:9px;color:#808080;">{{ site_currency() }} {{ number_format($discount_amount, 2) }}</p>
                                                </td>
                                            </tr>
                                            <tr style="height:30px;">
                                                <td></td>
                                                <td style="width:20%;border-bottom:2px solid black;" align="center">
                                                    <p style="margin:0;font-size:9px;color:#808080;">TOTAL</p>
                                                </td>
                                                <td style="width:30%;padding-right:10px;border-bottom:2px solid black;" align="right">
                                                    <p style="margin:0;font-size:9px;color:#808080;">{{ site_currency() }} {{ number_format($invoice_amount, 2) }}</p>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- 🔴 FOOTER -->
                                        <div class="footer_bg" width="100%" style="height:100px;display:flex;flex-direction:row;justify-content:flex-start;align-items:center;gap:135px;">
                                            <img src="{{ $invoice_image1 }}" alt="" style="width:200px;transform:rotate(90deg);">
                                            <img src="{{ $invoice_footer_image }}" alt="" style="width:100px;">
                                        </div>
                                    </td>

                                    <!-- 🟣 SIDEBAR -->
                                    <td class="invoice-sidebar" align="center" style="min-height:980px;vertical-align:top;width:200px;height:100%;background:url('{{ $invoice_image2 }}');background-size:cover;background-repeat:no-repeat;background-position:center;border-top:1px solid black;padding:20px 0px 0px 20px;">
                                        <table width="100%">
                                            <tr>
                                                <td>
                                                    <p style="margin:0;font-size:9px;color:#000;">Invoice No.</p>
                                                    <p style="margin:0;font-size:9px;color:#808080;">{{ $invoice_number }}</p>
                                                </td>
                                            </tr>
                                            <tr style="height:14px;"></tr>
                                            <tr>
                                                <td>
                                                    <p style="margin:0;font-size:9px;color:#000;">Invoice Date:</p>
                                                    <p style="margin:0;font-size:9px;color:#808080;">{{ $invoice_date }}</p>
                                                </td>
                                            </tr>
                                            <tr style="height:14px;"></tr>
                                            <tr>
                                                <td>
                                                    <p style="margin:0;font-size:9px;color:#000;">Invoiced To:</p>
                                                    <p style="margin:0;font-size:9px;color:#808080;">{{ $customer_name }}</p>
                                                </td>
                                            </tr>
                                            <tr style="height:14px;"></tr>
                                            <tr>
                                                <td>
                                                    <p style="margin:0;font-size:9px;color:#000;">Invoiced From:</p>
                                                    <p style="margin:0;font-size:9px;color:#808080;">{{ $site_name }}</p>
                                                </td>
                                            </tr>
                                            <tr style="height:14px;"></tr>
                                            <tr>
                                                <td>
                                                    <p style="margin:0;font-size:9px;color:#000;">Company Address:</p>
                                                    <p style="margin:0;font-size:9px;color:#808080;">{{ $company_address }}<br>{{ $company_mobile }}</p>
                                                </td>
                                            </tr>
                                            <tr style="height:14px;"></tr>
                                            <tr>
                                                <td>
                                                    <p style="margin:0;font-size:9px;color:#000;">Contact:</p>
                                                    <p style="margin:0;font-size:9px;color:#808080;">{{ $company_email }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- BODY END -->
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
