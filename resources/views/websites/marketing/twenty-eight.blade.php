<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        .footer-fixed {
        position: fixed;
        bottom: 0px;
        left: 0;
        right: 0;
        width: 100%;
        /* background: url('{{ $invoice_footer_image }}') center center no-repeat; */
        /* background-size: cover; */
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" height="100%" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
                <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;max-height: 130px;">
                            <table>
                                <tr>
                                    <td style="height: 40px; width: 600px;">
                                       
                                    </td>
                                    
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px;padding-top:0px;background: url('') no-repeat;background-position: center;background-size: cover;height:444px;">
                            <table>
                                <tr>
                                    <td ><img src="{{ $invoice_header_image }}" alt="" style="margin: auto; display: block;height: 40px;">
                                         <br>
                                        <br><br><br><br>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 700;">
                                            
                                             <strong>   BILLED FROM:</strong>
                                            
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                         {{ $site_name }} 
                                        </p>
                                        
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            Website:{{ $site->site_link }} 
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                        Email: {{ $company_email }} 
                                        </p>
                                    </td>
                                    <td style="width:300px;
                                    text-align: right;">
                                        <h1 style="font-family: arial;font-size: 20px;margin: 0px;font-weight: 700;">INVOICE</h1><br><br>
                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                           DATE: {{ $invoice_date }}
                                        </p>

                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                           INVOICE #{{ $invoice_number}}
                                        </p><br>
                                        
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <b>
                                                BILLED TO:
                                            </b>
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                             {{ $customer_name }}
                                        </p>
                                        
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <div style="min-height: 500px !important;">
                            <table style="border: 1px solid black;border-collapse: collapse;">
                                <tr style="border: 1px solid black;border-collapse: collapse;height: 24px;">
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                       <b>QUANTITY</b> 
                                    </td>
                                    <td style="width: 250px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        <b>DESCRIPTION</b>
                                    </td>
                                    
                                    <td style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        <b>UNIT PRICE</b>
                                    </td>
                                    <td style="width:100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        <b>TOTAL</b>
                                    </td>
                                </tr>
                            @foreach($products as $product)
                                <tr style="border: 1px solid black;border-collapse: collapse;height: 24px;">
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                      1
                                    </td>
                                    <td style="width: 250px;text-align:left;padding-left:10px;font-family: arial;font-size:10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                    {{ $product->name }} - {{ $product->subscription ?? '-' }}
                                    </td>
                                    
                                    <td style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        {{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}
                                    </td>
                                    <td style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        {{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}
                                    </td>
                                </tr>
                            @endforeach 
                                <tr>
                                    <td style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="3">
                                     <p><b>
                                        SUBTOTAL
                                     </b></p>
                                    </td>
                                    <td style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;" colspan="4">
                                        <p><b>{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}</b></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="3">
                                     <p><b>
                                        DISCOUNT
                                     </b></p>
                                    </td>
                                    <td style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;" colspan="4">
                                        <p><b>{{ site_currency() }} {{ number_format($discount_amount ?? 0, 2) }}</b></p>
                                    </td>
                                </tr>

                                <tr style="border-left: 0px;">
                                    <td style="width: 100px;padding-right: 10px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;" colspan="3">
                                     <p>TOTAL DUE</p>
                                    </td>
                                    <td style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;"colspan="4">
                                        <p>{{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
                                <tr class="footer-fixed" style="background: url('{{ $invoice_footer_image }}') no-repeat;background-position: center;background-size: cover;height:141px;padding:50px;background-size:cover;width: 100%;">
                                    <td style="text-align:center;">
                                        <p style="text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight:700;color:whitesmoke;">
                                            THANK YOU FOR YOUR BUSINESS
                                        </p>
                                    </td>          
                                </tr>
                                <tr>              
                            </table>
                        </td>
                    </tr> 
                </table>
            </td>
        </tr>
    </table>
</body>
</html>