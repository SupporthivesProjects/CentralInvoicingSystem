<!DOCTYPE html>
<html>
<head>
    <title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body, table, td {

            font-family: 'DejaVu Sans', sans-serif!important;
        }
        table td {
            padding-top: 5px !important;
            padding-bottom: 5px !important;
        }
        .invoice_header_image {
            background-image: url('{{ $invoice_header_image }}');
            background-repeat: no-repeat;
            padding: 40px;
            background-position: center;
            background-size: cover;
            height: 110px;
        }
        .body-section {
            width: 100%;
            padding: 20px 20px 20px 20px;
            background: url('{{ $invoice_image3 }}') no-repeat center;
            background-size: cover;
        }
        .invoice_footer_image {
            position: relative;
            bottom: 0;
            width: 100%;
            height: 120px;
            background: url('{{ $invoice_footer_image }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
    </style>
</head>
<body style="margin: 0; padding: 0px 0px;background: #fff; font-family: Arial, sans-serif;">
<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"
style="background: #fff; margin: 0 auto; border-collapse: collapse; box-shadow: 0 3px 10px rgba(0,0,0,0.1); max-width: 100%;">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td class="invoice_header_image">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="50%">
                                        <h1 style="color:#ffffff;font-size:48px;font-weight:700;margin:0;line-height:24px;">
                                            INVOICE
                                        </h1>
                                    </td>
                                    <td width="25%" style="background: #ffffff;padding:10px;vertical-align:top;">
                                        <p style="color:#252525!important;font-size:9px;font-weight:700;margin:1;">Billed To:</p>
                                        <p style="color:#3F3F3F!important;font-size:9px;font-weight:400;margin:1;">
                                            {{ !empty($customer_name) ? $customer_name : 'Customer' }}
                                        </p>
                                    </td>
                                    <td width="25%" style="background: #ffffff;padding:10px;vertical-align:top;">
                                    <p style="color:#000000;font-size:9px;font-weight:700;margin:1;">Billed From:</p>
                                    <p style="color:#000000;font-size:9px;font-weight:400;margin:1;">
                                        {{ $site->site_name }}<br>
                                        {!! $company_address ?? '' !!}
                                    </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                    <!-- Content -->
                    <tr>
                        <td class="body-section">
                            <p style="color:#252525;font-size:16px;font-weight:700;margin:0;text-transform: uppercase;">
                                INVOICE NUMBER: #{{ $invoice_number ?? '-' }}
                            </p>
                            <p style="color:#252525;font-size:16px;font-weight:700;margin:0;text-transform: uppercase;">
                                INVOICE DATE: {{ $invoice_date ?? '-' }}
                            </p>
                            <br>
                            <table cellspacing="0" cellpadding="0" border="0" width="100%" style="border-collapse: collapse; margin-bottom: 100px;">
                                <tr style="height:40px; border-bottom: 2px solid black;">
                                    <td><p style="text-align:center; font-size:10px; font-weight:400;">Product & Service</p></td>
                                    <td><p style="text-align:center; font-size:10px; font-weight:400;">Qty</p></td>
                                    <td><p style="text-align:center; font-size:10px; font-weight:400;">Duration</p></td>
                                    <td><p style="text-align:center; font-size:10px; font-weight:400;">Price</p></td>
                                    <td><p style="text-align:center; font-size:10px; font-weight:400;">Total</p></td>
                                </tr>

                                @foreach($products as $product)
                                <tr style="height:40px; border-bottom: 1px solid black;">
                                    <td><p style="text-align:center; font-size:10px;">{{ $product->name ?? '-' }}</p></td>
                                    <td><p style="text-align:center; font-size:10px;">{{ $product->quantity ?? 1 }}</p></td>
                                    <td><p style="text-align:center; font-size:10px;">{{ $product->subscription ?? '-' }}</p></td>
                                    <td><p style="text-align:center; font-size:10px;">{{ site_currency_code() }} {{ number_format($product->unit_price ?? 0, 2) }}</p></td>
                                    <td><p style="text-align:center; font-size:10px;">{{ site_currency_code() }} {{ number_format($product->unit_price ?? 0, 2) }}</p></td>
                                </tr>
                                @endforeach

                                <tr>
                                    <td colspan="5" style="padding:10px;">
                                        <table width="100%" cellpadding="10" cellspacing="0">
                                        <tr>
                                            <td width="33%" style="background-color:#F2F2F2 !important; text-align:center;">
                                                <p style="font-size:10px;font-weight:700;">Subtotal</p>
                                                <p style="font-size:14px;font-weight:700;">
                                                    {{ site_currency_code() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}
                                                </p>
                                            </td>
                                            <td width="33%" style="background-color:#F2F2F2 !important; text-align:center;">
                                                <p style="font-size:10px;font-weight:700;">Discount</p>
                                                <p style="font-size:14px;font-weight:700;">
                                                    {{ site_currency_code() }} {{ number_format($discount_amount ?? 0, 2) }}
                                                </p>
                                            </td>
                                            <td width="34%" style="background-color:#E5443F !important; color:#ffffff !important; text-align:right; padding-right:10px;">
                                                <p style="font-size:10px;font-weight:700;">Grand Total</p>
                                                <p style="font-size:20px;font-weight:700;">
                                                    {{ site_currency_code() }} {{ number_format($invoice_amount ?? 0, 2) }}
                                                </p>
                                            </td>
                                        </tr>

                                        </table>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    <!-- Content End -->

                    <!-- Footer -->
                    <tr>
                        <td class="invoice_footer_image">
                            <table width="100%" cellpadding="40" cellspacing="0">
                                <tr>
                                    <td align="left" width="50%">
                                        <img src="{{ $company_logo ?? '' }}" alt="Logo" style="width: 150px;">
                                    </td>
                                    <td align="right" width="50%">
                                        <table cellpadding="5" cellspacing="0">
                                            <tr>
                                                <td>
                                                    <img src="{{ $invoice_image1 }}" style="width:20px;" />
                                                </td>
                                                <td style="color:#ffffff;font-size:9px;text-align:right;">
                                                    {!! $company_address ?? '' !!}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="{{ $invoice_image2 }}" style="width:20px;" />
                                                </td>
                                                <td style="color:#ffffff;font-size:9px;text-align:right;">
                                                    {{ $company_email ?? '' }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Footer End -->
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
