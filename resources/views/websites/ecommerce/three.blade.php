<!DOCTYPE html>
<html>
<head>
    <title>{{ $customer['site_name'] }} - Invoice #{{ $customer['invoice_number'] }}</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;max-height: 130px;">
                            <table>
                                <tr>
                                    <td style="padding-left: 40px;background: url({{ asset($site->company_logo) }}) no-repeat;background-position: center;background-size:cover;width: 300px;">
                                        <img src="{{ asset($site->invoice_header_image) }}" alt="" style="margin: auto; display: block;height:60px;">
                                    </td>
                                    <td style="width:300px;
                                    padding: 40px;
                                    text-align: right;">
                                        <h1 style="font-family: arial;font-size: 20px;margin: 0px;font-weight: 700;">INVOICE</h1><br><br>
                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            INVOICE #{{ $customer['invoice_number'] ?? 'N/A' }}
                                        </p>
                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            DATE: {{ $customer['invoice_date'] ?? 'N/A' }}
                                        </p><br>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <b>
                                                BILLED TO:
                                            </b>
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                        {{ $customer['customer_name'] ?? 'N/A' }}
                                        </p>
                                        
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td style="padding:40px;padding-top:0px;background: url({{ asset($site->invoice_image1) }}) no-repeat;background-position: center;background-size: cover;height:444px;">
                            <table>
                                <tr>
                                    <td>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 700;">
                                            <b>
                                                BILLED FROM:
                                            </b>
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                        {{ $customer['site_name'] ?? 'N/A' }}
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            Website: {{ $site->site_link ?? 'N/A' }}
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            Email: {{ $customer['customer_email'] ?? 'N/A' }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <br>
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
                                        {{ $product->name }}
                                    </td>
                                    <td style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        {{ number_format($product->unit_price,2) }}
                                    </td>
                                    <td style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        {{ number_format($product->unit_price,2) }}
                                    </td>
                                   
                                </tr>
                                @endforeach
                              
                               
                                <tr>
                                    <td style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="3">
                                     <p><b>
                                        SUBTOTAL
                                     </b></p>
                                    </td>
                                    <td style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        <p><b>	{{ $currency->symbol . number_format($customer['invoice_amount'], 2) }}</b></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;padding-right: 10px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;" colspan="3">
                                     <p>DISCOUNT</p>
                                    </td>
                                    <td style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        <p>	0</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;padding-right: 10px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;" colspan="3">
                                     <p>TOTAL DUE</p>
                                    </td>
                                    <td style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        <p>{{ $currency->symbol . number_format($customer['invoice_amount'], 2) }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
                                <tr style="background: url({{ asset($site->invoice_footer_image) }}) no-repeat;background-position: center;background-size: cover;height:141px;padding:50px;background-size:cover;width: 100%;">
                                    <td style="text-align:center;">
                                        <p style="text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight:700;color:whitesmoke;">
                                            WE APPRECIATE YOUR BUSINESS
                                        </p>
                                    </td>          
                                </tr>
                                <tr>              
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
