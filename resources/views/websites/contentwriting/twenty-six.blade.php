<!DOCTYPE html>
<html>
<head>
<title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<style>
        body, table, td {
             background-color: transparent !important; 
           
        }
        table td {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
        }
       
        .invoice_header_image {
            background-image: url('{{ $invoice_header_image }}') !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
            background-size: cover !important;
            margin: auto !important;
            display: block !important;
            height:120px !important;
            width: 100% !important;
            border-collapse: collapse !important;
        }

        .invoice_footer_image {
            background-image: url('{{ $invoice_footer_image }}') !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
            background-size: cover !important;
            height:80px !important;
            width: 100% !important;
        }
       
 </style>
</head>
<body>
<table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin: 0 auto; text-align: center;">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
            <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                <tr>
                        <td style="padding: 0px;">
                            <div class="invoice_header_image">
                                <table width="100%" height="120">
                                    <tr align="center">
                                        <td style="width: 600px; height: 120px; vertical-align: middle;">
                                            <img src="{{ $company_logo }}" alt="" style="width:250px;">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr style="background:#ffff ;max-width: 600px;">
                        <td style="padding:40px;display: flex;flex-direction: column;max-width: 600px;">
                        <table cellspacing="0" cellpadding="0" border="0" width="100%" style="font-family: Calibri; font-size: 10px;">
                            <tr valign="top">
                            <td width="30%">
                                    <table cellspacing="0" cellpadding="0" border="0" style="margin-bottom: 10px;">
                                        <tr>
                                            <td style="padding-right: 5px; vertical-align: middle;"></td>
                                            <td style="vertical-align: middle;">
                                                <span style="font-weight: 700;">Invoice To</span><br>
                                               
                                            </td>
                                        </tr>
                                    </table>
                                    <table cellspacing="0" cellpadding="0" border="0">
                                        <tr>
                                            <td style="padding-right: 5px; vertical-align: middle;"></td>
                                            <td style="vertical-align: middle;">
                                            <span style="color: #136476; font-weight: 700;">Customer Name:</span><br>
                                             {{ !empty($customer_name) ? $customer_name : 'Customer' }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="30%">
                                    <table cellspacing="0" cellpadding="0" border="0" style="margin-bottom: 10px;">
                                        <tr>
                                            <td style="padding-right: 5px; vertical-align: middle;"></td>
                                            <td style="vertical-align: middle;">
                                                <span style="color: #136476; font-weight: 700;">Invoice Number</span><br>
                                                #{{ $invoice_number }}
                                            </td>
                                        </tr>
                                    </table>
                                    <table cellspacing="0" cellpadding="0" border="0">
                                        <tr>
                                            <td style="padding-right: 5px; vertical-align: middle;"></td>
                                            <td style="vertical-align: middle;">
                                                <span style="color: #136476; font-weight: 700;">Invoice Date</span><br>
                                                {{ $invoice_date }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="40%">
                                    <table cellspacing="0" cellpadding="0" border="0" style="margin-bottom: 10px;">
                                        <tr>
                                            <td style="padding-right: 5px; vertical-align: middle;">
                                                <img src="{{ $invoice_image1 }}" alt="" style="width: 24px;">
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <span style="color: #136476; font-weight: 700;">Customer Name:</span><br>
                                                {{ !empty($customer_name) ? $customer_name : 'Customer' }}
                                            </td>
                                        </tr>
                                    </table>
                                    <table cellspacing="0" cellpadding="0" border="0">
                                        <tr>
                                            <td style="padding-right: 5px; vertical-align: middle;">
                                                <img src="{{ $invoice_image2 }}" alt="" style="width: 24px;">
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <span style="color: #136476; font-weight: 700;">Website Address:</span><br>
                                                {{ $site->site_link }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>


                            <table cellspacing="0" cellpadding="0" border="0" width="100%" style="border-collapse: collapse; width: 600px;">
                                <tr>
                                    <!-- Left side: 25% for vertical "INVOICE" text -->
                                    <td style="width: 25%; vertical-align: top; position: relative;">
                                         <div style="font-weight: 700;transform: rotate(-90deg); transform-origin: left top; position: absolute; top: 450px; left: -20px; font-family: Calibri; font-size: 100px; color: #041021; margin: 0; white-space: nowrap;">INVOICE</div>
                                    </td>

                                    <!-- Right side: 75% for table -->
                                    <td style="width: 75%; vertical-align: top;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%" style="border-collapse: collapse; width: 100%;min-height: 570px !important;">
                                            <tr style="border-top: 1px solid black; border-bottom: 3px solid black; height: 30px;">
                                                <td>
                                                    <h1 style="margin: 0px; font-family: Calibri; font-size: 11px; color: #041021;">
                                                        Product Name / Service Details
                                                    </h1>
                                                </td>
                                                <td>
                                                    <h1 style="margin: 0px; font-family: Calibri; font-size: 11px; color: #041021;">
                                                        Quantity
                                                    </h1>
                                                </td>
                                                <td>
                                                    <h1 style="margin: 0px; font-family: Calibri; font-size: 11px; color: #041021;">
                                                        Amount
                                                    </h1>
                                                </td>
                                            </tr>
                                            @foreach($products as $product)
                                            <tr style="border-bottom: 1px solid black; height: 50px;">
                                                <td>
                                                    <p style="margin: 0px; font-family: Calibri; font-size: 8px; color: #041021;">
                                                        {{ $product->name }} <br>
                                                        Quality: {{ $product->quality }},{{ $product->delivery }},  Turnaround: {{ $product->turnaround }} ,Images : {{ $product->imagecount }} 
                                                    </p>
                                                </td>
                                                <td>
                                                    <p style="margin: 0px; font-family: Calibri; font-size: 10px; color: #041021;">1</p>
                                                </td>
                                                <td>
                                                    <p style="margin: 0px; font-family: Calibri; font-size: 11px; color: #041021;">  {{  site_currency() }} {{ number_format($product->unit_price, 2) }}</p>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <!-- Totals -->
                                            <tr style="border-bottom: 1px solid black; height: 50px;">
                                                <td colspan="2" align="right" style="padding-right: 40px;">
                                                    <h1 style="margin: 0px; font-family: Calibri; font-size: 11px; color: #041021;">SUB-TOTAL</h1>
                                                </td>
                                                <td>
                                                    <h1 style="margin: 0px; font-family: Calibri; font-size: 11px; color: #041021;"> {{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</h1>
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 1px solid black; height: 50px;">
                                                <td colspan="2" align="right" style="padding-right: 40px;">
                                                    <h1 style="margin: 0px; font-family: Calibri; font-size: 11px; color: #041021;">DISCOUNT</h1>
                                                </td>
                                                <td>
                                                    <h1 style="margin: 0px; font-family: Calibri; font-size: 11px; color: #041021;">{{ site_currency() }} {{ number_format($discount_amount, 2) }}</h1>
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 1px solid black; height: 50px;">
                                                <td colspan="2" align="right" style="padding-right: 40px;">
                                                    <h1 style="margin: 0px; font-family: Calibri; font-size: 11px; color: #041021;">TOTAL</h1>
                                                </td>
                                                <td>
                                                    <h1 style="margin: 0px; font-family: Calibri; font-size: 11px; color: #041021;"> {{  site_currency() }} {{ number_format($invoice_amount, 2) }}</h1>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    <!-- Content End-->
                    <tr>
                        <td align="center" class="invoice_footer_image">
                            
                        </td>
                    </tr> 
                   
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
