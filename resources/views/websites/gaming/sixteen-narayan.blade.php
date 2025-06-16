<!DOCTYPE html>
<html>
<head>
    <title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body, table, td {
            /* background-color: transparent !important; */
           
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


 </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin: 0 auto; text-align: center;">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px;">
              <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
           
                     <tr>
                        <td style="padding: 40px;">
                            <table style="clip-path: polygon(12% 0, 100% 0, 100% 100%, 0 100%, 0 11%);background-color: #ffffff;box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td style="padding:30px;vertical-align: top;" align="left">
                            <img src="{{ $invoice_signiture }}" alt="" style="margin:0px; display: block;width:200px;">
                        </td>
                        <td style="padding:20px;padding-bottom:20px;vertical-align: top;">
                            <h1 style="color:#D09E53;font-size:24px;font-weight:700;font-family: Arial;margin: 0px;line-height:24px;text-align:right;text-transform: uppercase;">
                                INVOICE
                            </h1>
                            <br>
                            <p style="color:#000000;font-size:9px;font-weight:400;font-family: Arial;margin: 0px;line-height:14px;text-align:right;text-transform: uppercase;">
                                Invoice #{{ $invoice_number }}
                            </p>
                            <p style="color:#000000;font-size:9px;font-weight:400;font-family: Arial;margin: 0px;line-height:14px;text-align:right;text-transform: uppercase;">
                                Date: {{ \Carbon\Carbon::parse($invoice_date)->format('d M Y') }}
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="padding:0px;vertical-align: top;padding-left:20px;" align="left">
                            <p style="color:#000000;font-size:9px;font-weight:700;font-family: Arial;margin: 0px;line-height:14px;">
                                BILLED FROM:
                            </p>
                            <p style="color:#000000;font-size:9px;font-weight:400;font-family: Arial;margin: 0px;line-height:14px;">
                             {{ $site->site_name }}
                            </p>
                            <p style="color:#000000;font-size:9px;font-weight:400;font-family: Arial;margin: 0px;line-height:14px;">
                                Website: {{ $site->site_link ?? 'N/A' }}
                            </p>
                        </td>
                        <td style="padding:0px;vertical-align:top;padding-right:20px;">
                            <p style="color:#000000;font-size:9px;font-weight:700;font-family: Arial;margin: 0px;line-height:14px;text-align:right;text-transform: uppercase;">
                               Billed to:
                            </p>
                            <p style="color:#000000;font-size:9px;font-weight:400;font-family: Arial;margin: 0px;line-height:14px;text-align:right;">
                             {{ $customer_name }}
                            </p>
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td style="padding:20px;width: 100%;padding-top:20px;" colspan="2">
                            <table cellspacing="0" cellpadding="0" border="1" width="100%" style="border-collapse: collapse;">
                                <tr style="width:520px;height: 28px;">
                                    <td style="width:200px;">
                                        <p style="color:#D09E53;font-size:9px;font-weight: 700;font-family: Arial;margin: 0px;line-height: 28px;text-align: center;text-transform: uppercase;">
                                            QUANTITY
                                        </p>
                                    </td>
                                    <td style="width:150px;">
                                        <p style="color:#D09E53;font-size:9px;font-weight: 700;font-family: Arial;margin: 0px;line-height: 28px;text-align: center;text-transform: uppercase;">
                                            DESCRIPTION
                                        </p>
                                    </td>
                                    <td style="width:100px;">
                                        <p style="color:#D09E53;font-size:9px;font-weight: 700;font-family: Arial;margin: 0px;line-height: 28px;text-align: center;text-transform: uppercase;">
                                            UNIT PRICE
                                        </p>
                                    </td>
                                    <td style="width:70px;">
                                        <p style="color:#D09E53;font-size:9px;font-weight: 700;font-family: Arial;margin: 0px;line-height: 28px;text-align: center;text-transform: uppercase;">
                                            Total
                                        </p>
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

                                <tr style="height: 28px;">
                                    <td colspan="3">
                                        <p style="color:#000000;font-size:9px;font-weight:700;font-family: Arial;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;text-transform: uppercase;">
                                            Subtotal
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#000000;font-size:9px;font-weight:700;font-family: Arial;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;text-transform: uppercase;">
                                        {{ $currency . number_format($invoice_amount+$discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr style="height: 28px;">
                                    <td colspan="3">
                                        <p style="color:#000000;font-size:9px;font-weight:700;font-family: Arial;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;text-transform: uppercase;">
                                            Discount
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#000000;font-size:9px;font-weight:700;font-family: Arial;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;text-transform: uppercase;">
                                        {{ $currency . number_format($discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr style="height: 28px;">
                                    <td colspan="3">
                                        <p style="color:#000000;font-size:9px;font-weight:400;font-family: Arial;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;text-transform: uppercase;">
                                            Total
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#000000;font-size:9px;font-weight:400;font-family: Arial;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;text-transform: uppercase;">
                                        {{ $currency . number_format($invoice_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="height: 100px;"></tr>
                    <!-- Content End-->

                    </table> 
                   
                    <!-----------Footer----------->
                    <tr>
                        <td align="center" class="invoice_header_image"  colspan="2">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
                                <tr>
                                   <p style="color:#000000 ;font-family: Arial;font-size:9px;margin: 0px;font-weight: 700;">
                                    Your decision to shop with us is greatly appreciated
                                   </p>
                                </tr>              
                            </table>
                        </td>
                    </tr> 
                    <!-----------Footer End----------->
                      </td>
                     </tr>   
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
