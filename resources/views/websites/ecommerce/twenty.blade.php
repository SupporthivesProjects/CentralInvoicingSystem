<!DOCTYPE html>
<html>
<head>
<!-- developerguides4you -->
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
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
            position: relative;
            bottom: 0;
            width: 100%;
            height: 130px;
            background: url('{{ $invoice_footer_image }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }

        .invoice_image1 {
            position: relative;
            bottom: 0;
            width: 100%;
            height: 130px;
            background: url('{{ $invoice_image1 }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
        }

    </style>
<body>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                  <!-- Header -->
                    <tr>
                        <td class="invoice_header_image" align="left">
                            <img src="{{ $company_logo }}" alt="" style="margin: auto;height: 44px;padding-left: 40px;">
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr class="invoice_image1" >
                        <td style="padding:40px;display: flex;flex-direction: column;">
                            
                        <table width="100%" style="margin-top: 40px; border-collapse: collapse;">
                            <tr>
                                <td style="width: 50%; vertical-align: middle;">
                                    <h1 style="color: #2e74b1; font-size: 36px; font-family: Calibri; font-weight: 700; margin: 0px; text-transform: uppercase; letter-spacing: 1px;">
                                        Invoice
                                    </h1>
                                </td>
                                <td style="width: 50%; text-align: right; vertical-align: middle;">
                                    <div style="display: inline-block; text-align: right;">
                                        <h1 style="color: #2e74b1; font-size: 14px; font-family: Calibri; font-weight: 400; margin: 0px; text-transform: uppercase;">
                                            INVOICE NO: {{ $invoice_number }}
                                        </h1>
                                        <p style="color: black; font-size: 12px; font-family: Roboto, sans-serif; font-weight: 400; margin: 4px 0 0; text-transform: capitalize;">
                                            DATE: {{ $invoice_date }}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        </table>

                            <table cellspacing="0" cellpadding="0" border="0" width="100%" style="border-collapse: collapse;margin-top:40px;">
                                <tr>
                                    <td style="vertical-align: top;">
                                       <div style="display: flex;flex-direction: column;gap:30px;">
                                          <div style="display: flex;flex-direction: column;">
                                             <span style="color: grey;font-size:11px;font-weight:600;font-family: Calibri;">
                                                TOTAL DUES:
                                             </span>
                                             <p style="color:#2e74b1;font-size:24px;font-weight:400;font-family: Calibri;margin: 0px;">
                                                {{ site_currency() }} {{  number_format($invoice_amount, 2) }}
                                             </p>
                                          </div>
                                          <div style="display: flex;flex-direction: column;">
                                             <span style="color: grey;font-size:10px;font-weight:400;font-family: Calibri;">
                                                Invoice To
                                             </span>
                                             <p style="color:#2e74b1;font-size:14px;font-weight:600;font-family: Calibri;margin: 0px;">
                                                {{ $customer_name }}
                                             </p>
                                             <span style="color: grey;font-size:10px;font-weight:400;font-family: Calibri;">
                                                <!-- <b style="color: black;">E:</b>  {{ $customer_email }} -->
                                                @if(!empty($customer_email))
                                                    <b style="color: black;">E:</b> {{ $customer_email }}
                                                @endif

                                             </span>
                                          </div>
                                          <div style="display: flex;flex-direction: column;margin-top: 40px;">
                                             <span style="color: grey;font-size:10px;font-weight:400;font-family: Calibri;">
                                                Invoice From
                                             </span>
                                             <p style="color:#2e74b1;font-size:14px;font-weight:600;font-family: Calibri;margin: 0px;">
                                                {{ $site_name }}
                                             </p>
                                             <span style="color: grey;font-size:10px;font-weight:400;font-family: Calibri;">
                                                <b style="color: black;">Powered By Eromnet Hong Kong</b><br>
                                                {{ $company_email }}
                                             </span>
                                          </div>
                                       </div>
                                    </td>
                                    <td style="width:20px;">

                                    </td>
                                    <td style="display: flex;">
                                    <table border="1" style="border-collapse: collapse; margin-bottom: 20px; width: 100%;min-height: 550px !important;border: 1px solid #ccc !important;">
                                        <tr style="height: 50px;">
                                            <td style="width: 200px; padding-left: 10px;border-bottom: 1px solid #ccc !important;">
                                                <p style="color: rgb(128, 128, 128); font-size: 11px; font-weight: 600; font-family: Calibri; margin: 0px;">
                                                    DESCRIPTIONS
                                                </p>
                                            </td>
                                            <td style="width: 70px; text-align: center; border-bottom: 3px solid #2e74b1;">
                                                <p style="color: grey; font-size: 11px; font-weight: 600; font-family: Calibri; margin: 0; line-height: 50px;">
                                                    QTY
                                                </p>
                                            </td>
                                            <td style="width: 100px; text-align: center; border-bottom: 3px solid #2e74b1;">
                                                <p style="color: grey; font-size: 11px; font-weight: 600; font-family: Calibri; margin: 0; line-height: 50px;">
                                                    PRICE
                                                </p>
                                            </td>
                                        </tr>
                                        @foreach($products as $product)
                                        <tr>
                                            <td style="width: 200px; padding: 10px;border-bottom: 1px solid #ccc !important;">
                                                <p style="color: black; font-size: 10px; font-weight: 600; font-family: Calibri; margin: 0px;">
                                                    {{ $product->name }}
                                                </p>
                                                <!-- <span style="color: grey; font-size: 8px; font-weight: 600; font-family: Calibri; margin: 0px;">
                                                {{ $product->name }}...
                                                </span> -->
                                                <p style="color: black; font-size: 10px; font-weight: 400; font-family: Calibri; margin: 0px;">
                                                {{ $product->category_name }}
                                                </p>
                                            </td>
                                            <td style="border-bottom: 1px solid #ccc !important;width: 70px; background-color: #e3e3fe !important; padding: 10px; text-align: center;">
                                                <p style="color: grey; font-size: 9px; font-weight: 400; font-family: Calibri; margin: 0px;">
                                                   {{ $product->quantity ?? 1 }}
                                                </p>
                                            </td>
                                            <td style="border-bottom: 1px solid #ccc !important;width: 100px; background-color: #e3e3fe !important; padding: 10px; text-align: center;">
                                                <p style="color: grey; font-size: 12px; font-weight: 400; font-family: Roboto Light; margin: 0px;">
                                                {{ site_currency() }} {{ number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}
                                                </p>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td style="border-bottom: 1px solid #ccc !important;width: 200px; padding: 10px; text-align: right;">
                                                <p style="color: grey; font-size: 9px; font-weight: 400; font-family: Calibri; margin: 0px; text-transform: uppercase; padding-right: 20px;">
                                                    SUB TOTAL
                                                </p>
                                                <p style="color: grey; font-size: 9px; font-weight: 400; font-family: Calibri; margin: 0px; text-transform: uppercase; padding-right: 20px;">
                                                    DISCOUNT
                                                </p>
                                                <p style="color: grey; font-size: 9px; font-weight: 400; font-family: Calibri; margin: 0px; text-transform: uppercase; padding-right: 20px;">
                                                    TOTAL
                                                </p>
                                            </td>
                                            <td colspan="2" style="border-bottom: 1px solid #ccc !important;background-color: #e3e3fe !important; padding: 10px; text-align: right; border-bottom: 3px solid #2e74b1;">
                                                <p style="color: grey; font-size: 12px; font-weight: 400; font-family: Roboto Light; margin: 0px; padding-right: 10px;">
                                                {{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}
                                                </p>
                                                <p style="color: grey; font-size: 12px; font-weight: 400; font-family: Roboto Light; margin: 0px; padding-right: 10px;">
                                                {{ site_currency() }} {{ number_format($discount_amount, 2) }}
                                                </p>
                                                <p style="color: grey; font-size: 12px; font-weight: 400; font-family: Roboto Light; margin: 0px; padding-right: 10px;">
                                                {{ site_currency() }} {{  number_format($invoice_amount, 2) }}
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


                    <!-----------Footer----------->
                    <tr>
                        <td align="center" class="invoice_footer_image">
                            <table width="100%" cellspacing="0" cellpadding="" border="0" style="border-collapse: collapse;"> 
                                <tr>
                                <td style="padding-left: 40px;">
                                    <table style="margin-bottom: 10px;">
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                <img src="{{ $invoice_image3 }}" alt="" style="height: 24px; width: 24px;">
                                            </td>
                                            <td style="vertical-align: middle; padding-left: 5px;">
                                                <p style="color: black; margin: 0px; font-family: Calibri; font-size: 9px; font-weight: 400;">
                                                    {{ $company_email }}
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                    <table>
                                        <tr>
                                            <td style="vertical-align: top;">
                                                <img src="{{ $invoice_image2 }}" alt="" style="height: 24px; width: 24px;">
                                            </td>
                                            <td style="vertical-align: top; padding-left: 5px;">
                                                <p style="color: black; margin: 0px; font-family: Calibri; font-size: 9px; font-weight: 400;">
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
                    <!-----------Footer End----------->    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
