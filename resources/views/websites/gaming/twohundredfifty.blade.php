<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>

    <style>
        @page {
            margin: 0;
            size: A4;
        }

        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        h1,h2,h3,h4,h5,h6,p {
            margin: 0;
        }
    </style>
</head>

<body>

<table width="100%" height="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td width="100%" height="100%">

            <!-- MAIN BACKGROUND CONTAINER -->
            <table width="100%" height="100%" cellpadding="0" cellspacing="0"
                style="
                    background: url({{$invoice_image1}});
                    background-size: cover;
                    background-repeat: no-repeat;
                    background-position: center;
                    color: #ffffff;
                    padding: 30px;
                ">

                <!-- ================= TOP CONTENT ================= -->
                <tr>
                    <td valign="top">

                        <!-- HEADER -->
                        <!-- <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="50%">
                                    <img src="{{ $invoice_header_image }}" width="200" style="display:block;">
                                </td>
                                <td width="50%" valign="top" align="right">
                                    <h1 style="font-size:70px;">INVOICE</h1>
                                    <p style="font-size:15px;margin-top:6px;">Invoice To :</p>
                                    <p style="font-size:16px;font-weight:bold;">{{ $customer_name }}</p>
                                </td>
                            </tr>
                        </table> -->
                        <!-- Logo & Title -->
                        <table width="100%">
                                <tr>
                                    <td width="50%">
                                        <img src="{{ $invoice_header_image }}" width="200" style="display:block;">
                                    </td>
                                    <td width="50%" valign="top" style="">
                                        <h1 style="font-size:70px;">INVOICE</h1>
                                        <p style="font-size:15px;margin-bottom: 6px;">Invoice To :</p>
                                        <p style="font-size:16px;font-weight:bold;margin-bottom: 6px;">{{ $customer_name ? $customer_name : '' }}</p>
                                        <div style="display: flex;flex-direction: row;justify-content: space-between;align-items: top; gap: 16px;">
                                            <p style="font-size:8px;line-height: 12px;">
                                                {!! $company_address !!}
                                            </p>

                                            <p style="font-size:8px;line-height: 12px;">
                                                {{ $customer_email ? $customer_email : '' }}<br>
                                                
                                            </p>

                                        </div>
                                    </td>
                                </tr>
                            </table>


                        <!-- INVOICE META -->
                        <table width="100%" cellpadding="0" cellspacing="0"
                            style="margin:20px 0; padding:20px 0; border-top:1px solid #48598A; border-bottom:1px solid #48598A;">
                            <tr>
                                <td width="50%">
                                    <b>Invoice Number:</b><br>{{ $invoice_number }}
                                </td>
                                <td width="50%">
                                    <b>Invoice Date:</b><br>{{ $invoice_date }}
                                </td>
                            </tr>
                        </table>

                        <!-- DESCRIPTION TABLE -->
                        <table width="100%" cellpadding="8" cellspacing="0"
                            style="background:#121a3d;border-radius:8px;border:1px solid #ffffff;padding:15px;">

                            <tr style="font-weight:bold;text-transform:uppercase;">
                                <td>Description</td>
                                <td>Unit Price</td>
                                <td align="center">Qty</td>
                                <td align="right">Total</td>
                            </tr>

                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product['name'] }} / {{ $product['game_currency_amount'] }} {{ $product['game_currency'] }}</td>
                                <td>{{ site_currency() . number_format($product['unit_price'], 2) }}</td>
                                <td align="center">2</td>
                                <td align="right">{{ site_currency() . number_format($product['unit_price'], 2) }}</td>
                            </tr>
                            @endforeach

                            <tr>
                                <td colspan="2" style="padding-top:20px;"><b>Subtotal</b></td>
                                <td colspan="2" align="right" style="padding-top:20px;">
                                    {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2"><b>Discount</b></td>
                                <td colspan="2" align="right">
                                    {{ site_currency() . number_format($discount_amount, 2) }}
                                </td>
                            </tr>

                            <tr style="font-size:18px;font-weight:bold;">
                                <td colspan="2">Total</td>
                                <td colspan="2" align="right">
                                    {{ site_currency() . number_format($invoice_amount, 2) }}
                                </td>
                            </tr>

                        </table>

                    </td>
                </tr>

                <!-- ============ SPACER (PUSH FOOTER DOWN) ============ -->
                <tr>
                    <td height="100%">&nbsp;</td>
                </tr>

                <!-- ================= FOOTER ================= -->
                <tr>
                    <td valign="bottom">

                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="font-size:10px;">
                                    <b>Email</b>: {{ $company_email }}<br>
                                    <b>Contact</b>: {{ $company_mobile }}<br>
                                </td>
                                
                                <td align="right">
                                    <b>THANK YOU!</b><br>
                                    <span style="font-size:12px;">{{ $company_email }}</span>
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
