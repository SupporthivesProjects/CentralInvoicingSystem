<!DOCTYPE html>
<html> 
<head>
    <!-- kupido -->
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
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
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;">
                        <table class="invoice_header_image" width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                            <tr>
                                <td style="padding: 0px;">
                                    <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                                        <tr>
                                            <td style="padding: 0px;">
                                                <table width="300" cellspacing="0" cellpadding="0" style="background-color: #1F2139; margin-top: 40px; height: 50px; border-collapse: collapse;">
                                                    <tr>
                                                        <td style="padding: 8px 10px 0px 40px;">
                                                            <span style="color: #ffffff !important; font-family: 'Poppins', sans-serif !important; font-size: 28px !important; font-weight: 600 !important; text-transform: uppercase !important;">
                                                                Invoice
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 0px 10px 8px 40px;">
                                                            <table cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                                                                <tr>
                                                                    <td style="color: #ffffff !important; font-family: 'Poppins', sans-serif !important; font-size: 9px !important; font-weight: 600 !important; padding-right: 30px !important;">
                                                                        {{ $invoice_date }}
                                                                    </td>
                                                                    <td style="color: #ffffff !important; font-family: 'Poppins', sans-serif !important; font-size: 9px !important; font-weight: 600 !important;">
                                                                        NO: {{ $invoice_number }}
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



                    <tr style="background:#ffff ;">
                        <td style="padding:40px;display: flex;flex-direction: column;padding-bottom: 0px;">
                          
                            <table cellspacing="0" cellpadding="0" border="0" width="100%" style="border-collapse: collapse;margin-top:100px;">
                                <tr style="height:40px;background:#1F2139 ;">
                                    <td style="width:300px;vertical-align: middle;">
                                        <p style="color:#ffff;font-size: 10px;font-weight:400;font-family:Poppins;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;vertical-align: middle;">
                                            Product Name 
                                        </p>
                                    </td>
                                    <td style="width:50px;vertical-align: middle;">
                                        <p style="color:#ffff;font-size: 10px;font-weight:400;font-family:Poppins;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;vertical-align: middle;">
                                            Qty
                                        </p>
                                    </td>
                                    <td style="width:100px;vertical-align: middle;">
                                        <p style="color:#ffff;font-size: 10px;font-weight:400;font-family:Poppins;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;vertical-align: middle;">
                                            Unit Price
                                        </p>
                                    </td>
                                    <td style="width:100px;vertical-align: middle;">
                                        <p style="color:#ffff;font-size: 10px;font-weight:400;font-family:Poppins;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;vertical-align: middle;">
                                            Total
                                        </p>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr style="height:40px;">
                                    <td>
                                        <p style="color:black;font-size: 11px;font-weight: 500;font-family:Poppins;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;">
                                        {{ $product->name }}
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:black;font-size: 11px;font-weight: 500;font-family:Poppins;margin: 0px;line-height:16px;text-align:right;padding-right:10px;">
                                        {{ $product->quantity ?? 1 }}
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:black;font-size: 11px;font-weight: 500;font-family:Poppins;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;">
                                        {{ site_currency() }} {{ number_format($product->unit_price, 2) }}
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:black;font-size: 11px;font-weight: 500;font-family: Poppins;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;">
                                        {{ site_currency() }} {{ number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                @endforeach
                                <tr style="height:40px;border-bottom:1px solid grey ;">
                                    <td colspan="3">
                                        <p style="color:#000000;font-size: 10px;font-weight:500;font-family:Poppins;margin: 0px;line-height: 28px;text-align:left;padding-left:10px;text-transform:capitalize;">
                                            Sub total
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#000000;font-size: 10px;font-weight:500;font-family: Poppins;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;text-transform: uppercase;">
                                        {{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr style="height:40px;border-bottom:1px solid grey ;">
                                    <td colspan="3">
                                        <p style="color:#000000;font-size: 10px;font-weight:500;font-family:Poppins;margin: 0px;line-height: 28px;text-align:left;padding-left:10px;text-transform:capitalize;">
                                        Discount
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#000000;font-size: 10px;font-weight:500;font-family: Poppins;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;text-transform: uppercase;">
                                        {{ site_currency() }}  {{ number_format($discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr style="height:40px;border-bottom:1px solid grey ;">
                                    <td colspan="3">
                                        <p style="color:#000000;font-size: 10px;font-weight:600;font-family: Poppins;margin: 0px;line-height: 28px;text-align:left;padding-left:10px;text-transform:capitalize;">
                                            Total Amount
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#000000;font-size: 10px;font-weight:500;font-family: Poppins;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;text-transform: uppercase;">
                                        {{ site_currency() }} {{ number_format($invoice_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                           
                            <table style="border-collapse: collapse; width: 100%;margin-top:10px;">
                                <tr>
                                    <!-- Left Column: Invoice To -->
                                    <td align="left" style="vertical-align: middle; padding: 0px;">
                                        <h2 style="color: #000000 !important; font-size: 12px !important; font-weight: 500 !important; font-family: Poppins, sans-serif !important; margin: 0px !important; line-height: 18px !important; text-transform: capitalize !important;">
                                            Invoice to
                                        </h2>
                                        <p style="color: #000000 !important; font-size: 9px !important; font-weight: 500 !important; font-family: Poppins, sans-serif !important; margin: 0px !important; line-height: 16px !important; text-transform: capitalize !important;">
                                         {{ !empty($customer_name) ? $customer_name : 'Customer' }}
                                        </p>
                                    </td>

                                    <!-- Right Column: Company Info -->
                                    <td align="right" style="vertical-align: top; padding: 10px 0 0 0 !important;">
                                        <table style="border-collapse: collapse; float: right !important;">
                                            <tr>
                                                <td align="right" style="padding-right: 10px;">
                                                    <img src="{{ $invoice_footer_image }}" alt="" style="height: 30px !important; width: 70px !important;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="right" style="padding-right: 10px;">
                                                    <h2 style="color: #000000 !important; font-size: 12px !important; font-weight: 500 !important; font-family: Poppins, sans-serif !important; margin: 0px !important; line-height: 10px !important; text-transform: capitalize !important;">
                                                    {!! $company_name ?? '' !!}
                                                    </h2>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="right" style="padding-right: 10px;">
                                                    <p style="color: #767171 !important; font-size: 9px !important; font-weight: 500 !important; font-family: Poppins, sans-serif !important; margin: 0px !important; line-height: 10px !important; text-transform: capitalize !important;">
                                                        <b style="color: #000000 !important;">E:</b>  {{ $company_email ?? '' }}
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="right" style="padding-right: 10px;">
                                                    <p style="color: #767171 !important; font-size: 9px !important; font-weight: 500 !important; font-family: Poppins, sans-serif !important; margin: 0px !important; line-height: 10px !important; text-transform: capitalize !important;">
                                                        <b style="color: #000000 !important;">W:</b>   {{ $site->site_link }}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="height:110px;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
                                <tr>
                                    <td align="left" style="padding-left: 40px;">
                                        <h1 style="color: #000000 !important; font-family: Poppins, sans-serif !important; font-size: 16px !important; margin: 0px !important; text-align: left !important; line-height: 1.5 !important;">
                                            Thank You <br>
                                            For Your Business
                                        </h1>
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
