<!DOCTYPE html>
<html>
<head>
    <title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body, table, td {
            background-color: transparent !important;
        }
        table td {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
        }
        .invoice_header_image {
            background-image: url('{{ $invoice_header_image }}');
            background-repeat: no-repeat;
            padding: 40px;
            background-position: center;
            background-size: cover;
            height: 130px;
        }
        .invoice_footer_image {
            background: url('{{ $invoice_footer_image }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            width: 100%;
            height:141px;
            padding:50px;
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="80%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr class="invoice_header_image">
                        <td>
                            <table width="100%" style="height: 120px;">
                                <tr>
                                    <td style="padding: 40px 0; width: 50%; text-align: left; padding:20px !important;">
                                        <img src="{{ $company_logo }}" alt="Company Logo" style="height: 40px;">
                                    </td>
                                    <td style="padding: 40px 0; width: 50%; text-align: right;">
                                        <img src="{{ $invoice_image1 }}" alt="Invoice Logo" style="height: 40px;padding:20px !important;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px; padding-top: 0;height:400px !important;">
                            <table width= "100%">
                                <tr>
                                    <td style="border-bottom: 1px solid #2f5496; width: 520px;">
                                        <h1 style="color: #2f5496; text-align: center; font-family: Calibri;">
                                            INVOICE
                                        </h1>
                                    </td>
                                </tr>
                            </table>
                            <table width= "100%">
                                <tr>
                                    <td>
                                        <p style="color: #2f5496; font-family: Calibri; font-size: 10px; margin: 0; font-weight: 700;padding-right:50px;">DATE:</p>
                                        <p style="color: black; font-family: Calibri; font-size: 10px; margin: 0;">{{ $invoice_date }}</p>
                                        <br>
                                        <p style="color: #2f5496; font-family: Calibri; font-size: 10px; margin: 0; font-weight: 700;">INVOICE #</p>
                                        <p style="color: black; font-family: Calibri; font-size: 10px; margin: 0;">{{ $invoice_number }}</p>
                                    </td>
                                    <td style="width: 100%; vertical-align: top;">
                                        <p style="color: #2f5496; font-family: Calibri; font-size: 10px; margin: 0; text-align: right; font-weight: 700;">TO:</p>
                                    </td>
                                    <td style="vertical-align: top;">
                                        <p style="color: black; font-family: Calibri; font-size: 10px; margin: 0; text-align: right;">{{ $customer_name }}</p>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <table style="border: 1px solid #2f5496; border-collapse: collapse;">
                                <tr style="height: 20px;">
                                    <td style="width: 100px; text-align: left; padding-left: 10px; font-family: Calibri; font-size: 10px; font-weight: 400; border: 1px solid #2f5496;">
                                        <b style="color:#2f5496;">QTY</b>
                                    </td>
                                    <td style="width: 250px; text-align: left; padding-left: 10px; font-family: Calibri; font-size: 10px; font-weight: 400; border: 1px solid #2f5496;">
                                        <b style="color:#2f5496;">PRODUCT NAME</b>
                                    </td>
                                    <td style="width: 150px; text-align: right; padding-right: 10px; font-family: Calibri; font-size: 10px; font-weight: 400; border: 1px solid #2f5496;">
                                        <b style="color:#2f5496;">UNIT PRICE</b>
                                    </td>
                                    <td style="width: 100px; text-align: right; padding-right: 10px; font-family: Calibri; font-size: 10px; font-weight: 400; border: 1px solid #2f5496;">
                                        <b style="color:#2f5496;">LINE TOTAL</b>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                    <tr style="height: 20px;">
                                        <td style="padding-left:10px; font-size:10px; font-family:Calibri; border:1px solid #2f5496;">
                                            {{ $product->quantity ?? 1 }}
                                        </td>
                                        <td style="padding-left:10px; font-size:10px; font-family:Calibri; border:1px solid #2f5496;">
                                            {{ $product->name }}
                                        </td>
                                        <td style="text-align:right; padding-right:10px; font-size:10px; font-family:Calibri; border:1px solid #2f5496;">
                                            {{ site_currency() . number_format($product->unit_price, 2) }}
                                        </td>
                                        <td style="text-align:right; padding-right:10px; font-size:10px; font-family:Calibri; border:1px solid #2f5496;">
                                            {{ site_currency() . number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}
                                        </td>
                                    </tr>
                                @endforeach

                                <!-- Totals -->
                                <tr>
                                    <td colspan="2"></td>
                                    <td style="padding-left:10px; font-family: Calibri; font-size: 10px;"><b style="color:#2f5496;">SUBTOTAL</b></td>
                                    <td style="text-align:right; padding-right:10px; font-family: Calibri; font-size: 10px; background: #d9e2f3 !important; border-bottom: 2px solid #2f5496 !important;">
                                        {{ site_currency() . number_format($invoice_amount, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td style="padding-left:10px; font-family: Calibri; font-size: 10px;"><b style="color:#2f5496;">DISCOUNT</b></td>
                                    <td style="text-align:right; padding-right:10px; font-family: Calibri; font-size: 10px; background: #d9e2f3 !important; border-bottom: 2px solid #2f5496 !important;">
                                        {{ site_currency() . number_format($discount_amount, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td style="padding-left:10px; font-family: Calibri; font-size: 10px;"><b style="color:#2f5496;">TOTAL</b></td>
                                    <td style="text-align:right; padding-right:10px; font-family: Calibri; font-size: 10px; background: #d9e2f3 !important; border-bottom: 2px solid #2f5496 !important;">
                                        {{ site_currency() . number_format($invoice_amount, 2) }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td>

                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;padding-top:50px !important;">
                                <tr class="invoice_footer_image">
                                    <td style="padding: 0 40px; height: 100px;">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
                                            <tr>
                                                <!-- Left Side: Email -->
                                                <td align="left" valign="middle" style="text-align: left !important;">
                                                    <table cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;text-align: left !important;">
                                                        <tr>
                                                            <td style="padding-right: 5px;">
                                                                <img src="{{ $invoice_image2 }}" style="width: 16px;">
                                                            </td>
                                                            <td>
                                                                <p style="font-family: Calibri; font-size: 10px; margin: 0; font-weight: 400; color: whitesmoke;">
                                                                {{ $company_email }}
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>

                                               <!-- Right Side: Address -->
                                                 
                                                <td align="right" valign="middle" style="text-align: right !important; padding-right: 10px;">
                                                    <table cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; width: 100%; text-align: right;">
                                                        <tr>
                                                            <td style="padding-right: 5px;text-align: right !important; ">
                                                                <img src="{{ $invoice_image3 }}" style="width: 16px;text-align: right !important; ">
                                                            </td>
                                                            <td>
                                                                <p style="font-family: Calibri; font-size: 10px; margin: 0; font-weight: 400; color: whitesmoke; text-align: right;">
                                                                    {!! $company_address !!}
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


                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
