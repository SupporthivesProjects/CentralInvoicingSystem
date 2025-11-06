<!DOCTYPE html>
<html>

<head>
    <title>Your Email Title</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
        <style>
        *{
            margin:0px;
            padding:0px;
        }
        a {
  text-decoration: none;
  color: #58595B;
}
        </style>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; ">
                    <!---header---->
                    <tr style="vertical-align: top;">
                        <td align="left" style="height:50px;padding:0px 40px 0px 20px;">
                            <p style="width:150px;background: #4B2A3B;height:10px;margin:0px;"></p>
                            <table width="100%" cellspacing="0" cellpadding="" border="0"
                                style="border-collapse: collapse;">
                                <tr>
                                    <td>
                                        <table border="0" style="border-collapse: collapse;margin-top:30px;">
                                            <tr>
                                                <td style="padding: 10px 0px;">
                                                    <img src="{{ $invoice_image2 }}"
                                                        style="width:24px;background: #4B2A3B;height:24px;margin:0px;">
                                                </td>
                                                <td style="padding: 10px 0px;padding-left: 5px;">
                                                    <h2
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size: 9px;">
                                                        Website</h2>
                                                    <p
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:8px;">
                                                        <a href="https://thewebdesigncrowd.com/">thewebdesigncrowd.com</a>
                                                        </p>
                                                        <!-- {{ $site->site_link }} -->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px 0px;">
                                                    <img src="{{ $invoice_image2 }}"
                                                        style="width:24px;background: #4B2A3B;height:24px;margin:0px;">
                                                </td>
                                                <td style="padding: 10px 0px;padding-left: 5px;">
                                                    <h2
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size: 9px;">
                                                        Email</h2>
                                                    <p
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:8px;">
                                                        {{ $company_email }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td align="right">
                                        <h1
                                            style="margin: 0px;font-family:Arial;font-size:30px;color:#808080;letter-spacing: 0.2cm;">
                                            INVOICE</h1>
                                        <br>
                                        <p style="border-bottom: 1px solid #808080;margin: 0px;"></p>
                                        <br>
                                        <table border="0" style="border-collapse: collapse;width: 100%;">
                                            <tr>
                                                <td style="border-right: 1px solid #808080;">
                                                    <p
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:10px;line-height: 14px;">
                                                        Due Amount:</p>
                                                    <h2
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:10px;line-height: 14px;">
                                                        {{ site_currency() . number_format($invoice_amount, 2) }}</h2>
                                                </td>
                                                <td style="border-right: 1px solid #808080;" align="center">
                                                    <p
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:10px;line-height: 14px;">
                                                        Invoice Date:</p>
                                                    <h2
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:10px;line-height: 14px;">
                                                        {{ $invoice_date }}</h2>
                                                </td>
                                                <td align="right">
                                                    <p
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:10px;line-height: 14px;">
                                                        Invoice No:</p>
                                                    <h2
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:10px;line-height: 14px;">
                                                        #{{ $invoice_number }}</h2>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!---header End---->
                    <!-- Content -->
                    <tr style="background:#ffff ;">
                        <td style="padding: 40px 20px;padding-bottom: 0px;min-height: 925px;">
                            <table border="0" style="border-collapse: collapse;width: 100%;min-height: 925px;">
                                <tr>
                                    <td style="min-height: 925px;width: 30%;background: url('{{ $invoice_image3 }}');background-repeat:no-repeat;background-size: cover;padding: 20px 20px 20px 10px;vertical-align: top;"
                                        align="center">
                                        <img src="{{ $company_logo }}" alt="" style="width:40px">
                                        <br>
                                        <table border="0"
                                            style="border-collapse: collapse;margin-bottom:80px;width: 100%;margin-top: 10px;">
                                            <tr>
                                                <td>
                                                    <h2
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:11px;line-height: 24px;">
                                                        Invoice To</h2>
                                                    <p style="border-bottom: 1px solid #808080;margin: 0px;"></p>
                                                    <h2
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:10px;line-height: 24px;">
                                                        {{ $customer_name }}</h2>
                                                </td>
                                            </tr>
                                        </table>
                                        <table border="0"
                                            style="border-collapse: collapse;margin-bottom:200px;width:100%;margin-top: 10px;">
                                            <tr>
                                                <td>
                                                    <h2
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:11px;line-height: 24px;">
                                                        Invoiced From</h2>
                                                    <p style="border-bottom: 1px solid #808080;margin: 0px;"></p>
                                                    <h2
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:10px;line-height: 24px;">
                                                        {{ $site_name }}</h2>
                                                    <p
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:8px;">
                                                        Powered By Eromnet Hong Kong</p>
                                                </td>
                                            </tr>
                                        </table>
                                        <img src="{{ $invoice_footer_image }}" alt="" style="height:30px;position: fixed; bottom: 30px;left: 150px;">
                                    </td>
                                    <td style="padding-left: 20px;vertical-align: top;">
                                        <table border="0"
                                            style="border-collapse: collapse;margin-bottom:200px;width:100%;margin-top: 10px;">
                                            <tr
                                                style="height: 50px; border-top: 1px solid black;border-bottom: 1px solid black;">
                                                <td>
                                                    <p
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:12px;font-weight:700;">
                                                        Product Names
                                                    </p>
                                                </td>
                                                <td>
                                                    <p
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:12px;font-weight:700;">
                                                        Qty
                                                    </p>
                                                </td>
                                                <td>
                                                    <p
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:12px;font-weight:700;">
                                                        Price
                                                    </p>
                                                </td>
                                                <td>
                                                    <p
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:12px;font-weight:700;">
                                                        Total
                                                    </p>
                                                </td>
                                            </tr>
                                            @foreach($products as $product)
                                            <tr style="height: 50px;border-bottom: 1px solid black;">
                                                <td>
                                                    <p
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:9px;font-weight:700;line-height: 14px;">
                                                        {{ $product->name }}
                                                    </p>
                                                    <p
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:8px;font-weight:700;line-height: 14px;">
                                                        {{ $product->category_name }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:10px;">
                                                        1
                                                    </p>
                                                </td>
                                                <td>
                                                    <p
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:10px;">
                                                        {{ site_currency() . number_format($product->unit_price, 2) }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:10px;">
                                                        {{ site_currency() . number_format($product->unit_price, 2) }}
                                                    </p>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr style="height:25px;">
                                                <td colspan="2"></td>
                                                <td>
                                                    <p
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:10px;">
                                                        Sub Total:
                                                    </p>
                                                </td>
                                                <td>
                                                    <p
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:10px;">
                                                        {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr style="height:25px;border-bottom: 1px solid black;">
                                                <td colspan="2"></td>
                                                <td>
                                                    <p
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:10px;">
                                                        Discount
                                                    </p>
                                                </td>
                                                <td>
                                                    <p
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:10px;">
                                                        {{ site_currency() . number_format($discount_amount, 2) }}
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr style="height:40px;">
                                                <td colspan="2"></td>
                                                <td>
                                                    <p
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:12px;font-weight: 700;">
                                                        GRAND TOTAL
                                                    </p>
                                                </td>
                                                <td>
                                                    <p
                                                        style="margin: 0px;color: #58595B;font-family: Arial;font-size:12px;font-weight: 700;">
                                                        {{ site_currency() . number_format($invoice_amount, 2) }}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End-->
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
