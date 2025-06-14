<!DOCTYPE html>
<html>
<head>
<!-- developerguides4you -->
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
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
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
                            
                            <table style="margin-top: 40px;border-collapse: collapse;">
                                <tr>
                                    <td>
                                        <h1 style="color: #2e74b1;font-size:36px;font-family:Calibri;font-weight:700;margin: 0px;text-transform: uppercase;letter-spacing:1px;">
                                            invoice
                                        </h1>
                                    </td>
                                    <td>
                                        <h1 style="color: #2e74b1;font-size:14px;font-family:Calibri;font-weight:400;margin: 0px;text-transform: uppercase;text-align: right;">
                                           INVOICENO:{{ $invoice_number }}
                                        </h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <p style="color:black;font-size:12px;font-family:Roboto Medium;font-weight: 400;margin: 0px;text-align:right;text-transform:capitalize;">
                                              DATE: {{ $invoice_date }}
                                        </p>
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
                                                £100.00
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
                                                <b style="color: black;">E:</b>  {{ $customer_email }}
                                             </span>
                                          </div>
                                          <div style="display: flex;flex-direction: column;margin-top: 40px;">
                                             <span style="color: grey;font-size:10px;font-weight:400;font-family: Calibri;">
                                                Invoice From
                                             </span>
                                             <p style="color:#2e74b1;font-size:14px;font-weight:600;font-family: Calibri;margin: 0px;">
                                                {{ $site->site_name }}
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
                                        <table border="1" style="border-collapse: collapse;margin-bottom:20px;">
                                            <tr style="height:50px;">
                                                <td style="width: 200px;padding-left: 10px;">
                                                    <p style="color: rgb(128, 128, 128);font-size:11px;font-weight:600;font-family: Calibri;margin: 0px;">
                                                        DESCRIPTIONS
                                                    </p>
                                                </td>
                                                <td style="width: 70px;padding: 0px;">
                                                    <p style="color: grey;font-size:11px;font-weight:600;font-family: Calibri;margin: 0px;text-align: center;border-bottom:3px solid #2e74b1;height:50px;display: flex;justify-content: center;align-items: center;">
                                                        QTY
                                                    </p>
                                                </td>
                                                <td style="width:100px;padding: 0px;">
                                                    <p style="color: grey;font-size:11px;font-weight:600;font-family: Calibri;margin: 0px;text-align: center;border-bottom:3px solid #2e74b1;height:50px;display: flex;justify-content: center;align-items: center;">
                                                        PRICE
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px;padding: 10px;display: flex;flex-direction: column;">
                                                    <p style="color:black;font-size:10px;font-weight:600;font-family: Calibri;margin: 0px;">
                                                        Item Name Here
                                                    </p>
                                                    <span style="color:grey;font-size:8px;font-weight:600;font-family: Calibri;margin: 0px;">
                                                        Item Description
                                                    </span>
                                                    <p style="color:black;font-size:10px;font-weight:400;font-family: Calibri;margin: 0px;">
                                                        ELEGANY
                                                    </p>
                                                </td>
                                                <td style="width: 70px;background: rgb(227, 227, 254);padding: 10px;">
                                                    <p style="color: grey;font-size:9px;font-weight:400;font-family: Calibri;margin: 0px;text-align: center;">
                                                        01
                                                    </p>
                                                </td>
                                                <td style="width:100px;background: rgb(227, 227, 254);padding: 10px;">
                                                    <p style="color: grey;font-size:12px;font-weight:400;font-family:Roboto Light;margin: 0px;text-align: center;">
                                                        £10.00
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px;padding: 10px;display: flex;flex-direction: column;">
                                                    <p style="color:black;font-size:10px;font-weight:600;font-family: Calibri;margin: 0px;">
                                                        Item Name Here
                                                    </p>
                                                    <span style="color:grey;font-size:8px;font-weight:600;font-family: Calibri;margin: 0px;">
                                                        Item Description
                                                    </span>
                                                    <p style="color:black;font-size:10px;font-weight:400;font-family: Calibri;margin: 0px;">
                                                        ELEGANY
                                                    </p>
                                                </td>
                                                <td style="width: 70px;background: rgb(227, 227, 254);padding: 10px;">
                                                    <p style="color: grey;font-size:9px;font-weight:400;font-family: Calibri;margin: 0px;text-align: center;">
                                                        01
                                                    </p>
                                                </td>
                                                <td style="width:100px;background: rgb(227, 227, 254);padding: 10px;">
                                                    <p style="color: grey;font-size:12px;font-weight:400;font-family:Roboto Light;margin: 0px;text-align: center;">
                                                        £10.00
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px;padding: 10px;display: flex;flex-direction: column;">
                                                    <p style="color:black;font-size:10px;font-weight:600;font-family: Calibri;margin: 0px;">
                                                        Item Name Here
                                                    </p>
                                                    <span style="color:grey;font-size:8px;font-weight:600;font-family: Calibri;margin: 0px;">
                                                        Item Description
                                                    </span>
                                                    <p style="color:black;font-size:10px;font-weight:400;font-family: Calibri;margin: 0px;">
                                                        ELEGANY
                                                    </p>
                                                </td>
                                                <td style="width: 70px;background: rgb(227, 227, 254);padding: 10px;">
                                                    <p style="color: grey;font-size:9px;font-weight:400;font-family: Calibri;margin: 0px;text-align: center;">
                                                        01
                                                    </p>
                                                </td>
                                                <td style="width:100px;background: rgb(227, 227, 254);padding: 10px;">
                                                    <p style="color: grey;font-size:12px;font-weight:400;font-family:Roboto Light;margin: 0px;text-align: center;">
                                                        £10.00
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px;padding: 10px;display: flex;flex-direction: column;">
                                                    <p style="color:black;font-size:10px;font-weight:600;font-family: Calibri;margin: 0px;">
                                                        Item Name Here
                                                    </p>
                                                    <span style="color:grey;font-size:8px;font-weight:600;font-family: Calibri;margin: 0px;">
                                                        Item Description
                                                    </span>
                                                    <p style="color:black;font-size:10px;font-weight:400;font-family: Calibri;margin: 0px;">
                                                        ELEGANY
                                                    </p>
                                                </td>
                                                <td style="width: 70px;background: rgb(227, 227, 254);padding: 10px;">
                                                    <p style="color: grey;font-size:9px;font-weight:400;font-family: Calibri;margin: 0px;text-align: center;">
                                                        01
                                                    </p>
                                                </td>
                                                <td style="width:100px;background: rgb(227, 227, 254);padding: 10px;">
                                                    <p style="color: grey;font-size:12px;font-weight:400;font-family:Roboto Light;margin: 0px;text-align: center;">
                                                        £10.00
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px;padding: 10px;display: flex;flex-direction: column;">
                                                    <p style="color:black;font-size:10px;font-weight:600;font-family: Calibri;margin: 0px;">
                                                        Item Name Here
                                                    </p>
                                                    <span style="color:grey;font-size:8px;font-weight:600;font-family: Calibri;margin: 0px;">
                                                        Item Description
                                                    </span>
                                                    <p style="color:black;font-size:10px;font-weight:400;font-family: Calibri;margin: 0px;">
                                                        ELEGANY
                                                    </p>
                                                </td>
                                                <td style="width: 70px;background: rgb(227, 227, 254);padding: 10px;">
                                                    <p style="color: grey;font-size:9px;font-weight:400;font-family: Calibri;margin: 0px;text-align: center;">
                                                        01
                                                    </p>
                                                </td>
                                                <td style="width:100px;background: rgb(227, 227, 254);padding: 10px;">
                                                    <p style="color: grey;font-size:12px;font-weight:400;font-family:Roboto Light;margin: 0px;text-align: center;">
                                                        £10.00
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px;padding: 10px;text-align: right;">
                                                    <p style="color:grey;font-size:9px;font-weight:400;font-family: Calibri;margin: 0px;text-transform: uppercase;padding-right: 20px;">
                                                        SUB TOTAl
                                                    </p>
                                                    <p style="color:grey;font-size:9px;font-weight:400;font-family: Calibri;margin: 0px;text-transform: uppercase;padding-right: 20px;">
                                                        SUB TOTAl
                                                    </p>
                                                </td>
                                                <td style="background: rgb(227, 227, 254);padding: 10px;text-align: right;border-bottom:3px solid #2e74b1;height:50px;" colspan="2">
                                                    <p style="color: grey;font-size:12px;font-weight:400;font-family:Roboto Light;margin: 0px;padding-right: 10px;">
                                                        £100.00
                                                    </p>
                                                    <p style="color: grey;font-size:12px;font-weight:400;font-family:Roboto Light;margin: 0px;padding-right: 10px;">
                                                        £100.00
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
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
                                <tr>
                                   <td style="padding-left: 40px;">
                                    <div style="display: flex;flex-direction: column;gap:10px;">
                                       <div style="display: flex;gap: 5px;">
                                        <img src="{{ $invoice_image3 }} " alt="" style="height:24px;width:24px;">
                                        <p style="color: black;margin: 0px;font-family: Calibri;font-size: 9px;font-weight: 400;">Support@developerguides4you.com</p>
                                       </div>
                                       <div style="display: flex;gap: 5px;">
                                        <img src="{{ $invoice_image2 }}" alt="" style="height:24px;width:24px;">
                                        <p style="color: black;margin: 0px;font-family: Calibri;font-size: 9px;font-weight: 400;">
                                         {!! $company_address !!}
                                       </div>
                                    </div>
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
