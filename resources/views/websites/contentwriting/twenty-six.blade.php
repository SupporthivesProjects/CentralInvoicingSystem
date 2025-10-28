<!DOCTYPE html>
<html>
<head>
<title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<style>
        *,body {
            margin: 0;
            padding: 0;
            background-color: transparent !important; 
            border-collapse: collapse;
            font-family: 'Poppins';
        }

        .invoice_header_image {
            background-image: url('{{ $invoice_header_image }}') !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
            background-size: cover !important;
            margin: auto !important;
            height:160px !important;
            width: 100% !important;
            border-collapse: collapse !important;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
        }

        .invoice_footer_image {
            background-image: url('{{ $invoice_footer_image }}') !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
            background-size: cover !important;
            height:90px !important;
            width: calc(100% + 1px) !important;
            position: absolute;
            bottom: -1px;
            left: 0;
            right: -1px;
        }
        .tab1 p {
            margin-bottom: 0px;
        }
        .tab1 tr td {
            padding-bottom: 16px;
        }
        
        .linement {
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            align-items: flex-start;
            gap: 4px;
        }
        .linement2 {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
        }
       
 </style>
</head>
<body>
<table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin: 0 auto; text-align: center;">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
            <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse;">
                    <tr>
                        <td style="padding: 0px;">
                            <div class="invoice_header_image">
                                <img src="{{ $company_logo }}" alt="" style="width:350px;">
                            </div>
                        </td>
                    </tr>
                    <tr style="background:#ffff ;max-width: 100%;">
                        <td style="padding:40px;display: flex;flex-direction: column;max-width: 100%;">


                            <table class="tab1" cellspacing="0" cellpadding="0" border="0" width="100%" style="font-family: Calibri; font-size: 12px;">
                                <tr valign="top">
                                    <td width="40%">
                                        <p >Invoice To</p>
                                    </td>
                                    <td>
                                        <p style="color: #136476; font-weight: 700;">Invoice Number</p>
                                                    #{{ $invoice_number }}
                                    </td>
                                    <td>
                                        <div class="linement">
                                            <img src="{{ $invoice_image1 }}" alt="" style="width: 24px;">
                                            <div class="linement2">
                                                <p style="color: #136476; font-weight: 700;">Email:</p>
                                                {{ $company_email  }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr valign="top">

                                    <td width="40%">
                                        <p style="color: #136476; font-weight: 700;">Customer Name:</p>
                                                {{ !empty($customer_name) ? $customer_name : 'Customer' }}
                                    </td>
                                    <td>
                                       <p style="color: #136476; font-weight: 700;">Invoice Date</p>
                                                    {{ $invoice_date }}
                                    </td>
                                    <td>
                                        <div class="linement">
                                            <img src="{{ $invoice_image2 }}" alt="" style="width: 24px;">
                                            <div class="linement2">
                                                <p style="color: #136476; font-weight: 700;">Website Address:</p>
                                                    {{ $site->site_link }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>


                            <table cellspacing="0" cellpadding="0" border="0" width="100%" style="border-collapse: collapse; width: 100%;margin-top:80px">
                                <tr>
                                    <!-- Left side: 25% for vertical "INVOICE" text -->
                                    <td style="width: 20%; vertical-align: top; position: relative;">
                                        <p style="font-weight: 900; transform: rotate(90deg); transform-origin: top left; position: absolute; top: 0px; left: 100px; font-family: Calibri, sans-serif; font-size: 120px; color: #041021; margin: 0; white-space: nowrap;">INVOICE</p>
                                    </td>


                                    <!-- Right side: 75% for table -->
                                    <td style="width: 80%; vertical-align: top;">
                                        <div style="min-height: 651px !important;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%" style="border-collapse: collapse; width: 100%;">
                                            <tr style="border-top: 1px solid black; border-bottom: 2px solid black; height: 30px;">
                                                <td style="padding: 16px 0px 16px 16px;">
                                                    <h1 style="margin: 0px; font-family: Calibri; font-size: 11px; color: #041021;text-align: left;">
                                                        Product Name / Service Details
                                                    </h1>
                                                </td>
                                                <td style="padding: 16px 16px 16px 16px;">
                                                    <h1 style="margin: 0px; font-family: Calibri; font-size: 11px; color: #041021;text-align: center;">
                                                        Quantity
                                                    </h1>
                                                </td>
                                                <td style="padding: 16px 0px 16px 16px;">
                                                    <h1 style="margin: 0px; font-family: Calibri; font-size: 11px; color: #041021;text-align: right;">
                                                        Amount
                                                    </h1>
                                                </td>
                                            </tr>
                                            @foreach($products as $product)
                                                <tr style="border-bottom: 1px solid black;">
                                                    <td style="padding: 16px 0px 16px 16px;">
                                                        <p style="margin: 0px; font-family: Calibri; font-size: 8px; color: #041021;text-align: left;">
                                                            {{ $product->name }} <br>
                                                            Quality: {{ $product->quality }}, {{ $product->delivery }}, Turnaround: {{ $product->turnaround }}, <br>
                                                            Images: {{ $product->imagecount }} 
                                                        </p>
                                                    </td>
                                                    <td style="padding: 16px 16px 16px 16px;">
                                                        <p style="margin: 0px; font-family: Calibri; font-size: 10px; color: #041021;text-align: center;">1</p>
                                                    </td>
                                                    <td style="padding: 16px 0px 16px 16px;">
                                                        <p style="margin: 0px; font-family: Calibri; font-size: 11px; color: #041021;text-align: right;">{{ site_currency() }} {{ number_format($product->unit_price, 2) }}</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                          
                                           <!-- Totals -->
                                                <tr style="height: 40px;">
                                                    <td></td>
                                                    <td align="right" style="padding-right: 40px; border-bottom: 1px solid black;">
                                                        <h1 style="margin: 0px; font-family: Calibri; font-size: 11px; color: #041021;">SUB-TOTAL</h1>
                                                    </td>
                                                    <td style="border-bottom: 1px solid black;">
                                                        <h1 style="margin: 0px; font-family: Calibri; font-size: 11px; color: #041021;text-align: right;">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</h1>
                                                    </td>
                                                </tr>
                                                <tr style="height: 40px;">
                                                    <td></td>
                                                    <td align="right" style="padding-right: 40px; border-bottom: 1px solid black;">
                                                        <h1 style="margin: 0px; font-family: Calibri; font-size: 11px; color: #041021;">DISCOUNT</h1>
                                                    </td>
                                                    <td style="border-bottom: 1px solid black;">
                                                        <h1 style="margin: 0px; font-family: Calibri; font-size: 11px; color: #041021;text-align: right;">{{ site_currency() }} {{ number_format($discount_amount, 2) }}</h1>
                                                    </td>
                                                </tr>
                                                <tr style="height: 40px;">
                                                    <td></td>
                                                    <td align="right" style="padding-right: 40px; border-bottom: 1px solid black;">
                                                        <h1 style="margin: 0px; font-family: Calibri; font-size: 11px; color: #041021;">TOTAL</h1>
                                                    </td>
                                                    <td style="border-bottom: 1px solid black;">
                                                        <h1 style="margin: 0px; font-family: Calibri; font-size: 11px; color: #041021;text-align: right;">{{ site_currency() }} {{ number_format($invoice_amount, 2) }}</h1>
                                                    </td>
                                                </tr>

                                        </table>
                                    </div>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    <!-- Content End-->
                    <div class="invoice_footer_image">
                            
                    </div>
                   
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
