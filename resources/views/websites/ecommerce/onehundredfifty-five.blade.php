<!DOCTYPE html>
<html>

<head>
    <title>Your Email Title</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
    </style>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!---header--->
                    <tr>
                        <td align="center"
                            style="height:300px;background:url({{ $invoice_header_image }});background-size: cover;background-repeat: no-repeat;background-position: center;padding: 10px 20px;vertical-align: bottom;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr>
                                    <td colspan="2" style="padding-right:50px;" align="right">
                                        <h1
                                            style="font-family:Arial;margin: 0px;font-size: 25px;font-weight:500;color:#6f6f71;">
                                            INVOICE</h1>
                                    </td>
                                </tr>
                                <tr style="height:80px;"></tr>
                                <tr>
                                    <td style="padding-left:50px;">
                                        <p
                                            style="margin: 0px;font-family:Roboto;font-size:9px;color:#6f6f71;line-height: 12px;">
                                            Invoice To
                                        </p>
                                        <p
                                            style="margin: 0px;font-family:Roboto;font-size:9px;color:#6f6f71;line-height: 12px;font-weight: 600;">
                                            {{ $customer_name }}
                                        </p>
                                        <p
                                            style="margin: 0px;font-family:Roboto;font-size:9px;color:#6f6f71;line-height: 12px;">
                                            <b>Email :</b> {{ $customer_email }}
                                        </p>
                                        <!-- <p
                                            style="margin: 0px;font-family:Roboto;font-size:9px;color:#6f6f71;line-height: 12px;">
                                            <b>Phone :</b> {{ $customer_mobile }}
                                        </p> -->
                                    </td>
                                    <td style="padding-right:50px;" align="right">
                                        <p
                                            style="margin: 0px;font-family:Roboto;font-size:9px;color:#6f6f71;line-height: 12px;">
                                            Invoice Date : <b>{{ $invoice_date }}</b>
                                        </p>
                                        <p
                                            style="margin: 0px;font-family:Roboto;font-size:9px;color:#6f6f71;line-height: 12px;">
                                            Issue Date : <b>{{ $invoice_date }}</b>
                                        </p>
                                        <p
                                            style="margin: 0px;font-family:Roboto;font-size:9px;color:#6f6f71;line-height: 12px;">
                                            Invoice No. : <b>{{ $invoice_number }}</b>
                                        </p>
                                        <p style="width: 80%;border-bottom: 1px solid black;margin: 0px;"></p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!---header End--->
                    <!-- Content -->
                    <tr style="background:#ffff ;">
                        <td>
                            <div style="min-height: 550px !important;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;margin-top: 40px;">
                                <tr style="background:#3D9D97;">
                                    <td style="padding:10px;width: 50%;">
                                        <p
                                            style="margin: 0px;font-family:Roboto;font-size:11px;color: #ffffff;font-weight:600;">
                                            Item Description
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;" align="center">
                                        <p
                                            style="margin: 0px;font-family:Roboto;font-size:11px;color: #ffffff;font-weight:600;">
                                            Unit Rate
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;" align="center">
                                        <p
                                            style="margin: 0px;font-family:Roboto;font-size:11px;color: #ffffff;font-weight:600;">
                                            QTY
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;" align="center">
                                        <p
                                            style="margin: 0px;font-family:Roboto;font-size:11px;color: #ffffff;font-weight:600;">
                                            Amount
                                        </p>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr>
                                    <td style="padding:10px;background: #EBEBEC;">
                                        <p style="margin: 0px;font-family:Roboto;font-size:9px;color: #000000;">
                                            {{ $product->name }}
                                        </p>
                                        <p style="margin: 0px;font-family:Roboto;font-size:9px;color:#8e8e99;">
                                            {!! \Illuminate\Support\Str::limit(strip_tags($product->description), 150) !!}
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;border-bottom: 1px solid black;" align="center">
                                        <p style="margin: 0px;font-family:Roboto;font-size:9px;color: #000000;">
                                            {{ site_currency() . number_format($product->unit_price, 2) }}
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;border-bottom: 1px solid black;" align="center">
                                        <p style="margin: 0px;font-family:Roboto;font-size:9px;color: #000000;">
                                            1
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;border-bottom: 1px solid black;" align="center">
                                        <p style="margin: 0px;font-family:Roboto;font-size:9px;color: #000000;">
                                            {{ site_currency() . number_format($product->unit_price, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td style="padding:10px;background: #EBEBEC;"></td>
                                    <td style="padding:5px 10px;" align="center">
                                        <p style="margin: 0px;font-family:Roboto;font-size:9px;color: #000000;">
                                            Sub Total:
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;" align="center"></td>
                                    <td style="padding:5px 10px;" align="center">
                                        <p style="margin: 0px;font-family:Roboto;font-size:9px;color:#000000;">
                                            {{ site_currency() }} {{  number_format(($invoice_amount + $discount_amount), 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;background: #EBEBEC;"></td>
                                    <td style="padding:5px 10px;" align="center">
                                        <p style="margin: 0px;font-family:Roboto;font-size:9px;color:red;">
                                            Discount:
                                        </p>
                                    </td>
                                    <td style="padding:5px 10px;" align="center"></td>
                                    <td style="padding:5px 10px;" align="center">
                                        <p style="margin: 0px;font-family:Roboto;font-size:9px;color:red;">
                                            {{ site_currency() }} {{  number_format(($discount_amount), 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;background:#EBEBEC;"></td>
                                    <td style="padding:10px;background: #3D9D97;" align="center">
                                        <p
                                            style="margin: 0px;font-family:Roboto;font-size:9px;color:#ffffff;font-weight: 700;">
                                            Grand Total
                                        </p>
                                    </td>
                                    <td style="padding:10px;background: #3D9D97;" align="center"></td>
                                    <td style="padding:10px;background: #3D9D97;" align="center">
                                        <p
                                            style="margin: 0px;font-family:Roboto;font-size:9px;color:#ffffff;font-weight: 700;">
                                            {{ site_currency() }} {{  number_format(($invoice_amount), 2) }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <!-- Content End-->
                    <!-----------Footer----------->
                    <tr>
                        <td align="center"
                            style="background: url({{ $invoice_footer_image }});background-repeat: no-repeat;background-position: center;height:180px;background-size:cover;padding: 0px 40px;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr>
                                    <td colspan="3" style="border-bottom: 1px solid black;">
                                        <p
                                            style="margin: 0px;font-family:Roboto;font-size:12px;color: #3D9D97;font-weight:600;line-height:24px;">
                                            Thank You For Your Business!
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0px;">
                                        <p
                                            style="margin: 0px;font-family:Roboto;font-size:9px;color:#6f6f71;line-height: 12px;border-right: 1px solid #3D9D97;">
                                            <b>Phone :</b> <br>
                                            {{ $company_mobile }}
                                        </p>
                                    </td>
                                    <td style="padding: 10px;">
                                        <p
                                            style="margin: 0px;font-family:Roboto;font-size:9px;color:#6f6f71;line-height: 12px;border-right: 1px solid #3D9D97;">
                                            <b>Email :</b> <br>
                                            {{ $company_email }}
                                        </p>
                                    </td>
                                    <td style="padding: 10px;">
                                        <p
                                            style="margin: 0px;font-family:Roboto;font-size:9px;color:#6f6f71;line-height: 12px;">
                                            <b>Address :</b> <br>
                                            {{ $company_address }}
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
