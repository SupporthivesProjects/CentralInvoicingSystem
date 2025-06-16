<!DOCTYPE html>
<html>
<head>
<!-- UpgradeUrSite -->
@php

dd($site->site_name);

@endphp
<title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        body, table, td {
            background-color: transparent !important;
        }
        table td {
            padding-top: 7px !important;
            padding-bottom: 7px !important;
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
                            <table style="border-collapse: collapse;max-width: 600px;" border="0">
                                    <td style="padding: 0px;">
                                        <img src="{{ $invoice_header_image }}" alt="" style="width: 100%;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td style="padding:40px;display: flex;flex-direction: column;padding-bottom: 100px;">
                            <table cellspacing="0" cellpadding="0" border="0" width="100%" style="border-collapse: collapse;">
                                <tr>
                                    <td style="width:350px;">
                                     <table style="width:350px;border-collapse: collapse;" border="0">
                                          <tr style="border-top: 2px solid black;border-bottom:2px solid black;height: 28px;">
                                            <td style="padding-left: 10px;">
                                                <p style="font-size: 9px;font-family: Arial;font-weight: 700;margin: 0px;">
                                                 Description
                                                </p>
                                            </td>
                                            <td style="width: 50px;">
                                                <p style="font-size: 9px;font-family: Arial;font-weight: 700;margin: 0px;text-align: center;">
                                                QTY
                                                </p>
                                            </td>
                                            <td style="width: 50px;">
                                                <p style="font-size: 9px;font-family: Arial;font-weight: 700;margin: 0px;text-align: center;">
                                                 Amount
                                                </p>
                                            </td>
                                          </tr>
                                          @foreach($products as $product)
                                          <tr style="border-top: 2px solid black;border-bottom:2px solid black;">
                                            <td style="padding: 10px;">
                                                <p style="font-size:10px;font-family: Arial;font-weight:700;margin: 0px;">
                                                {{ $product->category_name }}
                                                </p>
                                                <p style="font-size:8px;font-family: Arial;font-weight:400;margin: 0px;">
                                                {{ $product->name }}
                                                </p>
                                            </td>
                                            <td style="width: 50px;padding-top: 10px;vertical-align: top;">
                                                <p style="font-size: 9px;font-family: Arial;font-weight: 700;margin: 0px;text-align: center;">
                                                 {{ $product->quantity ?? 1 }}
                                                </p>
                                            </td>
                                            <td style="width: 50px;padding-top: 10px;vertical-align: top;">
                                                <p style="font-size: 9px;font-family: Arial;font-weight: 700;margin: 0px;text-align: center;">
                                                {{ site_currency_code() }} {{ number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}
                                                </p>
                                            </td>
                                          </tr>
                                          @endforeach
                                          <tr style="height: 28px;">
                                            <td colspan="2" style="width: 50px;padding-top: 10px;vertical-align: top;border-bottom:2px solid black;">
                                                <p style="font-size: 9px;font-family: Arial;font-weight:500;margin: 0px;text-align: right;">
                                                SUB-TOTAL
                                                </p>
                                            </td>
                                            <td style="width: 50px;padding-top: 10px;vertical-align: top;border-bottom:2px solid black;">
                                                <p style="font-size: 9px;font-family: Arial;font-weight: 700;margin: 0px;text-align: center;">
                                                {{ site_currency_code() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}
                                                </p>
                                            </td>
                                          </tr>
                                          <tr style="height: 28px;">
                                            <td colspan="2" style="width: 50px;padding-top: 10px;vertical-align: top;border-bottom:2px solid black;">
                                                <p style="font-size: 9px;font-family: Arial;font-weight:500;margin: 0px;text-align: right;">
                                                DISCOUNT
                                                </p>
                                            </td>
                                            <td style="width: 50px;padding-top: 10px;vertical-align: top;border-bottom:2px solid black;">
                                                <p style="font-size: 9px;font-family: Arial;font-weight: 700;margin: 0px;text-align: center;">
                                                {{ site_currency_code() }} {{ number_format($discount_amount, 2) }}
                                                </p>
                                            </td>
                                          </tr>
                                          <tr style="height: 28px;">
                                            <td colspan="2" style="width: 50px;padding-top: 10px;vertical-align: top;">
                                                <p style="font-size: 9px;font-family: Arial;font-weight:600;margin: 0px;text-align: right;">
                                                TOTAL
                                                </p>
                                            </td>
                                            <td style="width: 50px;padding-top: 10px;vertical-align: top;">
                                                <p style="font-size: 9px;font-family: Arial;font-weight: 700;margin: 0px;text-align: center;">
                                                 {{ site_currency_code() }} {{  number_format($invoice_amount, 2) }}
                                                </p>
                                            </td>
                                          </tr>
                                     </table>
                                    </td>
                                    <td style="width:40px;">

                                    </td>
                                    <td style="width: 150px;border-collapse: collapse;vertical-align: top;">
                                         <table>
                                            <tr>
                                                <td>
                                                <p style="font-size:10px;font-family: Arial;font-weight:700;margin: 0px;">
                                                 Invoice Number:
                                                </p>
                                                <p style="font-size:8px;font-family: Arial;font-weight:400;margin: 0px;">
                                                  #{{ $invoice_number }}
                                                </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="height:14px;padding: 0px;">

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                <p style="font-size:10px;font-family: Arial;font-weight:700;margin: 0px;">
                                                 Date:
                                                </p>
                                                <p style="font-size:8px;font-family: Arial;font-weight:400;margin: 0px;">
                                                {{ $invoice_date }}
                                                </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="height:14px;padding: 0px;">

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                <p style="font-size:10px;font-family: Arial;font-weight:700;margin: 0px;">
                                                 Bill to:
                                                </p>
                                                <p style="font-size:8px;font-family: Arial;font-weight:400;margin: 0px;">
                                                    {{ $customer_name }}
                                                </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="height:14px;padding: 0px;">

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                <p style="font-size:10px;font-family: Arial;font-weight:700;margin: 0px;">
                                                 Bill From:
                                                </p>
                                                <p style="font-size:8px;font-family: Arial;font-weight:400;margin: 0px;">
                                                {{ $site->site_name }}  
                                                </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="height:14px;padding: 0px;">

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                <p style="font-size:10px;font-family: Arial;font-weight:700;margin: 0px;">
                                                 Email:
                                                </p>
                                                <a href="#" style="font-size:8px;font-family: Arial;font-weight:400;margin: 0px;color: #CC99CC;">
                                                {{ $company_email }}
                                                </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="height:14px;padding: 0px;">

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                <p style="font-size:10px;font-family: Arial;font-weight:700;margin: 0px;">
                                                 Address
                                                </p>
                                                <p style="font-size:8px;font-family: Arial;font-weight:400;margin: 0px;">
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
                    <!-- Content End-->
    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
