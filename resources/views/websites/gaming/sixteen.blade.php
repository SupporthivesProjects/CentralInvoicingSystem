<!DOCTYPE html>
<html>
<head>
    <title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body, table, td {
            background-color: transparent !important;
        }
        .invoice_image1 table td {
            padding-top:5px !important;
            padding-bottom:5px !important;
        }
        .invoice_header_image {
            /*background-image: url('{{ $company_logo }}');*/
            background-repeat: no-repeat;
            padding-left: 40px;
            background-position: center;
            background-size: cover;
            width: 300px;
        }
        .invoice_image1 {
            padding: 40px;
            padding-top: 0px;
            background: url('{{ $invoice_image1 }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            height: 550px;
            width: 100%;
        }
        .invoice_footer_image {
            background: url('{{ $invoice_footer_image }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            height: 120px;
            padding: 20px;
            width: 100%;
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="60%" height="100%;" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">

                    <tr>
                        <td style="padding: 0px;max-height: 100px;">
                            <table>
                                <tr>
                                    <td class="invoice_header_image">
                                        <img src="{{ $company_logo }}" alt="" style="margin: auto; display: block;height:60px;">
                                    </td>

                                    <td style="width:300px;padding: 40px;text-align: right;">
                                        <h1 style="font-family: arial;font-size: 20px;margin: 0px;font-weight: 700; color: #d09f53">INVOICE</h1><br><br>
                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            INVOICE #{{ $invoice_number }}
                                        </p>
                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            DATE: {{ \Carbon\Carbon::parse($invoice_date)->format('d M Y') }}
                                        </p><br>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <b>BILLED TO:</b>
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            {{ $customer_name }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td class="invoice_image1" style="background-color: transparent;">
                            <table style="background-color: transparent;width: 100%;">
                                <tr>
                                    <td>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 700;">
                                            <b>BILLED FROM:</b>
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            {{ $site->site_name }}
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            Website: {{ $site->site_link ?? 'N/A' }}
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            Email: {{ $company_email }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <br><br>

                            <table style="width: 100%;height: 400px; width: 100%; border: 1px solid black; border-collapse: collapse;">
                                <tr style="height: 24px;">
                                    <td style="width: 10%; text-align: center; font-family: arial; font-size: 10px; font-weight: 400; border: 1px solid black;">
                                        <b style="color: #d09f53">SR. NO.</b>
                                    </td>
                                    <td style="width: 15%; text-align: center; font-family: arial; font-size: 10px; font-weight: 400; border: 1px solid black;">
                                        <b style="color: #d09f53">QUANTITY</b>
                                    </td>
                                    <td style="width: 45%; text-align: center; font-family: arial; font-size: 10px; font-weight: 400; border: 1px solid black;">
                                        <b style="color: #d09f53">DESCRIPTION</b>
                                    </td>
                                    <td style="width: 15%; text-align: center; font-family: arial; font-size: 10px; font-weight: 400; border: 1px solid black;">
                                        <b style="color: #d09f53">GAME CURRENCY</b>
                                    </td>
                                    <td style="width: 15%; text-align: center; font-family: arial; font-size: 10px; font-weight: 400; border: 1px solid black;">
                                        <b style="color: #d09f53">UNIT PRICE</b>
                                    </td>
                                    <td style="width: 15%; text-align: center; font-family: arial; font-size: 10px; font-weight: 400; border: 1px solid black;">
                                        <b style="color: #d09f53">TOTAL</b>
                                    </td>
                                </tr>

                                @php $counter = 1; @endphp
                                @foreach($products as $index => $product)
                                <tr style="height: 24px;">
                                    <td style="width: 10%; text-align: center; font-family: arial; font-size: 10px; border: 1px solid black;">
                                        {{ $counter++ }}
                                    </td>
                                    <td style="width: 15%; text-align: center; font-family: arial; font-size: 10px; border: 1px solid black;">
                                        1
                                    </td>
                                    <td style="width: 45%; text-align: left; padding-left: 10px; font-family: arial; font-size: 10px; border: 1px solid black;">
                                        <strong>{{ $product['name'] }}</strong>
                                        @if (isset($product['platform_fields']) && isset($product['selected_platform']))
                                            <div style="margin-top:4px;">
                                                <em style="font-size:9px;">{{ $product['selected_platform'] }}:</em><br>
                                                @foreach($product['platform_fields'][$product['selected_platform']] as $fieldName => $value)
                                                    <span style="font-size:9px; margin-left:8px;">
                                                        {{ ucfirst(str_replace('_',' ',$fieldName)) }}: {{ $value }}
                                                    </span><br>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                    <td style="width: 15%; text-align: right; padding-right: 10px; font-family: arial; font-size: 10px; border: 1px solid black;">
                                        {{ $product['game_currency_amount'] }} {{ $product['game_currency'] }}
                                    </td>
                                    <td style="width: 15%; text-align: right; padding-right: 10px; font-family: arial; font-size: 10px; border: 1px solid black;">
                                        {{ $currency . number_format($product['unit_price'], 2) }}
                                    </td>
                                    <td style="width: 15%; text-align: right; padding-right: 10px; font-family: arial; font-size: 10px; border: 1px solid black;">
                                        {{ $currency . number_format($product['unit_price'], 2) }}
                                    </td>
                                </tr>
                                @endforeach

                                <!-- Fixed alignment for summary rows -->
                                <tr>
                                    <td colspan="5" style="text-align: right; font-family: arial; font-size: 10px; font-weight: 700; padding-right: 10px;">
                                        SUBTOTAL
                                    </td>
                                    <td style="text-align: right; padding-right: 10px; font-family: arial; font-size: 10px; font-weight: 700; border: 1px solid black;">
                                        {{ $currency . number_format($invoice_amount+$discount_amount, 2) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="5" style="text-align: right; font-family: arial; font-size: 10px; padding-right: 10px;">
                                        DISCOUNT
                                    </td>
                                    <td style="text-align: right; padding-right: 10px; font-family: arial; font-size: 10px; color: green; border: 1px solid black;">
                                        {{ $currency . number_format($discount_amount, 2) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="5" style="text-align: right; font-family: arial; font-size: 10px; padding-right: 10px;">
                                        TOTAL DUE
                                    </td>
                                    <td style="text-align: right; padding-right: 10px; font-family: arial; font-size: 10px; border: 1px solid black;">
                                        {{ $currency . number_format($invoice_amount, 2) }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
                                <tr>
                                    <td class="invoice_footer_image">
                                        <p style="text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight:700;color:whitesmoke;">
                                            WE APPRECIATE YOUR BUSINESS
                                        </p>
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
