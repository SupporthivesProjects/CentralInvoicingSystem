<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body{
            /* background-color: transparent !important; */
            margin:0px !important;
            padding:0px !important;


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
            width: 100% !important;
            height: 942px !important;
        }
        body{
            margin: 0px;
            padding: 0px;
        }


 </style>
</head>
<body>
<table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin: 0 auto; text-align: center;">
        <tr>
            <td align="center" style="padding: 0px;">
            <table class="invoice_header_image" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">

                <tr >
                    <td  style="padding:80px 40px;padding-bottom: 0px;">
                        <table  width="100%"  style="width: 100%;margin-top:50px;">
                            <tr>
                                <td style="vertical-align: bottom;"><h1 style="margin: 0px;font-family: Poppins;text-transform: uppercase;font-size: 24px;color: #4C483D;">INVOICE</h1></td>
                                <td align="right"><img src="{{ $company_logo }}" alt="" style="height:70px;"></td>
                            </tr>
                        </table>
                        <table cellspacing="0" cellpadding="0" border="0" width="100%" style="width: 100%;border-collapse: collapse;margin-top:10px;">
                            <tr style="height:40px;border-top: 1px solid #FF444E;">
                                <td style="width:300px;">
                                    <p style="color:#FF444E;font-size: 10px;font-weight:400;font-family:Poppins;margin: 0px;line-height:20px;text-align: left;padding-left:10px;">
                                        DATE
                                    </p>
                                </td>
                                <td style="width:120px;">
                                    <p style="color:#FF444E;font-size: 10px;font-weight:400;font-family:Poppins;margin: 0px;line-height:20px;text-align: left;padding-left:10px;">
                                        TO
                                    </p>
                                </td>
                                <td style="width:100px;">
                                    <p style="color:#FF444E;font-size: 10px;font-weight:400;font-family:Poppins;margin: 0px;line-height:20px;text-align: left;padding-left:10px;">
                                        INVOICE NO.
                                    </p>
                                </td>
                            </tr>
                            <tr style="height:50px;border-bottom: 1px solid #FF444E;vertical-align: top;">
                                <td style="width:300px;">
                                    <p style="color:#4C483D;font-size: 10px;font-weight:400;font-family:Poppins;margin: 0px;line-height:20px;text-align: left;padding-left:10px;">
                                    {{ $invoice_date }}
                                    </p>
                                </td>
                                <td style="width:120px;">
                                    <p style="color:#4C483D;font-size: 10px;font-weight:400;font-family:Poppins;margin: 0px;line-height:20px;text-align: left;padding-left:10px;">
                                    {{ !empty($customer_name) ? $customer_name : 'Customer' }}
                                    </p>
                                </td>
                                <td style="width:100px;">
                                    <p style="color:#4C483D;font-size: 10px;font-weight:400;font-family:Poppins;margin: 0px;line-height:20px;text-align: left;padding-left:10px;">
                                        #{{ $invoice_number }}
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <div style="min-height: 650px;">
                            <table width="100%"  style="border-collapse: collapse;margin-top:30px;min-height: 450px !important;">
                            <tr style="background-color: #FF444E !important; height: 30px;">
                                <td>
                                    <p style="margin: 0px;color:#FFFFFF;font-family: Poppins;font-size: 10px;font-weight: 500;text-align: center;text-transform: uppercase;">
                                        QTY.
                                    </p>
                                </td>
                                <td>
                                    <p style="margin: 0px;color:#FFFFFF;font-family: Poppins;font-size: 10px;font-weight: 500;text-align: center;text-transform: uppercase;">
                                        DESCRIPTION
                                    </p>
                                </td>
                                <td>
                                    <p style="margin: 0px;color:#FFFFFF;font-family: Poppins;font-size: 10px;font-weight: 500;text-align: center;text-transform: uppercase;">
                                        QUALITY
                                    </p>
                                </td>
                                <td>
                                    <p style="margin: 0px;color:#FFFFFF;font-family: Poppins;font-size: 10px;font-weight: 500;text-align: center;text-transform: uppercase;">
                                        TURNAROUND
                                    </p>
                                </td>
                                <td>
                                    <p style="margin: 0px;color:#FFFFFF;font-family: Poppins;font-size: 10px;font-weight: 500;text-align: center;text-transform: uppercase;">
                                        IMAGERY
                                    </p>
                                </td>
                                <td>
                                    <p style="margin: 0px;color:#FFFFFF;font-family: Poppins;font-size: 10px;font-weight: 500;text-align: center;text-transform: uppercase;">
                                        BILLING TYPE
                                    </p>
                                </td>
                                <td>
                                    <p style="margin: 0px;color:#FFFFFF;font-family: Poppins;font-size: 10px;font-weight: 500;text-align: center;text-transform: uppercase;">
                                        Total
                                    </p>
                                </td>
                                </tr>
                                @foreach($products as $product)
                                <tr style="height:30px;border-bottom: 1px solid #7F7F7F;">
                                <td>
                                    <p style="margin: 0px;color:#7F7F7F;font-family: Poppins;font-size: 10px;font-weight: 500;text-align: center;text-transform:capitalize;">
                                    {{ $loop->iteration }}
                                    </p>
                                </td>
                                <td>
                                    <p style="margin: 0px;color:#7F7F7F;font-family: Poppins;font-size: 10px;font-weight: 500;text-align: center;text-transform:capitalize;">
                                    {{ $product->name }}
                                    </p>
                                </td>
                                <td>
                                    <p style="margin: 0px;color:#7F7F7F;font-family: Poppins;font-size: 10px;font-weight: 500;text-align: center;text-transform:capitalize;">
                                    {{ $product->quality }}
                                    </p>
                                </td>
                                <td>
                                    <p style="margin: 0px;color:#7F7F7F;font-family: Poppins;font-size: 10px;font-weight: 500;text-align: center;text-transform:capitalize;">
                                    {{ $product->delivery }}
                                    </p>
                                </td>
                                <td>
                                    <p style="margin: 0px;color:#7F7F7F;font-family: Poppins;font-size: 10px;font-weight: 500;text-align: center;text-transform:capitalize;">
                                    {{ $product->imagecount }}
                                    </p>
                                </td>
                                <td>
                                    <p style="margin: 0px;color:#7F7F7F;font-family: Poppins;font-size: 10px;font-weight: 500;text-align: center;text-transform:capitalize;">
                                        one time
                                    </p>
                                </td>
                                <td>
                                    <p style="margin: 0px;color:#7F7F7F;font-family: Poppins;font-size: 10px;font-weight: 500;text-align: center;text-transform:capitalize;">
                                    {{  site_currency() }} {{ number_format($product->unit_price, 2) }}
                                    </p>
                                </td>
                                </tr>
                                @endforeach
                                <tr style="height:30px;border-bottom: 1px solid #7F7F7F;">
                                <td colspan="5"></td>
                                <td>
                                    <p style="margin: 0px;color:#7F7F7F;font-family: Poppins;font-size: 10px;font-weight: 500;text-align: center;text-transform:capitalize;">
                                        Subtotal
                                    </p>
                                </td>
                                <td>
                                    <p style="margin: 0px;color:#7F7F7F;font-family: Poppins;font-size: 10px;font-weight: 500;text-align: center;text-transform:capitalize;">
                                    {{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}
                                    </p>
                                </td>
                                </tr>
                                <tr style="height:30px;border-bottom: 1px solid #7F7F7F;">
                                <td colspan="5"></td>
                                <td>
                                    <p style="margin: 0px;color:#7F7F7F;font-family: Poppins;font-size: 10px;font-weight: 500;text-align: center;text-transform:capitalize;">
                                        Discount
                                    </p>
                                </td>
                                <td>
                                    <p style="margin: 0px;color:#7F7F7F;font-family: Poppins;font-size: 10px;font-weight: 500;text-align: center;text-transform:capitalize;">
                                    {{ site_currency() }} {{ number_format($discount_amount, 2) }}
                                    </p>
                                </td>
                                </tr>
                                <tr style="height:30px;border-bottom: 1px solid #7F7F7F;">
                                <td colspan="5"></td>
                                <td>
                                    <p style="margin: 0px;color:#4C483D;font-family: Poppins;font-size: 10px;font-weight: 500;text-align: center;text-transform:capitalize;">
                                        TOTAL
                                    </p>
                                </td>
                                <td>
                                    <p style="margin: 0px;color:#4C483D;font-family: Poppins;font-size: 10px;font-weight: 500;text-align: center;text-transform:capitalize;">
                                    {{  site_currency() }} {{ number_format($invoice_amount, 2) }}
                                    </p>
                                </td>
                                </tr>
                            </table>
                        </div>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; margin-top: 10px; padding-bottom: 40px; margin-bottom: 40px;">
                            <tr>
                                <td>
                                    <p style="margin: 0px; color:#FF444E; font-family: Poppins; font-size: 11px; font-weight: 500; text-align:right; text-transform:capitalize;">
                                        Thank you for your business!
                                    </p>
                                </td>
                            </tr>
                            <tr style="height: 10px;"></tr>
                            {{-- Company Name --}}
                            @if(!empty($company_name))
                            <tr>
                                <td>
                                    <p style="margin: 0px; color:#FF444E; font-family: Poppins; font-size: 11px; font-weight: 500; text-align:right; text-transform:capitalize;">
                                        Company Name: 
                                        <span style="color: #4C483D;">{{ $company_name }}</span>
                                    </p>
                                </td>
                            </tr>
                            @endif

                            {{-- License Number --}}
                            @if(!empty($site->license_number))
                            <tr>
                                <td>
                                    <p style="margin: 0px; color:#FF444E; font-family: Poppins; font-size: 11px; font-weight: 500; text-align:right; text-transform:capitalize;">
                                        License No: 
                                        <span style="color: #4C483D;">{{ $site->license_number }}</span>
                                    </p>
                                </td>
                            </tr>
                            @endif

                            {{-- Company Address --}}
                            @if(!empty($company_address))
                            <tr>
                                <td>
                                    <p style="margin: 0px; color:#FF444E; font-family: Poppins; font-size: 11px; font-weight: 500; text-align:right; text-transform:capitalize;">
                                        Address: 
                                        <span style="color: #4C483D;">{{ $company_address }}</span>
                                    </p>
                                </td>
                            </tr>
                            @endif

                        </table>

                    </td>
                </tr>

            </table>
            </td>
        </tr>
    </table>
</body>
</html>
