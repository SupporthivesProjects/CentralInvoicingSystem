<!DOCTYPE html>
<html>
<head>
    <title>{{ $customer['site_name'] }} - Invoice #{{ $customer['invoice_number'] }}</title>
    <style>

        .invoice_header_image {
            background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path($site->company_logo))) }}');
            background-repeat: no-repeat; 
            padding-left: 40px;
            background-position: center;
            background-size: cover;
            width: 300px;
        }
        .invoice_image1 {
                padding: 40px;
                padding-top: 0px;
                background: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path($site->invoice_image1))) }}');
                background-repeat: no-repeat; 
                background-position: center;
                background-size: cover;
                height: 444px;
            }
            .invoice_footer_image {
                background: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path($site->invoice_footer_image))) }}');
                background-repeat: no-repeat; 
                background-position: center;
                background-size: cover;
                height: 100%;
                padding: 50px;
                width: 100%;
            }

        </style>
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
                                <td class="invoice_header_image">
                                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path($site->invoice_header_image))) }}" alt="" style="margin: auto; display: block;height:60px;">
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
                        <td class="invoice_image1" >
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
                                            Email: {{ $customer['company_email'] ?? 'N/A' }}
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
                                        {{ site_currency() . number_format($product->unit_price,2) }}
                                    </td>
                                    <td style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        {{ site_currency() . number_format($product->unit_price,2) }}
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
                                        <p><b>	{{ site_currency() . number_format($customer['invoice_amount'], 2) }}</b></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;padding-right: 10px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;" colspan="3">
                                     <p>DISCOUNT</p>
                                    </td>
                                    <td class="text-success" style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        <p>	{{ site_currency() . number_format($customer['discount_amount'], 2) }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;padding-right: 10px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;" colspan="3">
                                     <p>TOTAL DUE</p>
                                    </td>
                                    <td style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        <p>{{ site_currency() . number_format($customer['invoice_amount'], 2) }}</p>
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
                                <tr class="invoice_footer_image" >
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
