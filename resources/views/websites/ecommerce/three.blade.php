<!DOCTYPE html>
<html>
<head>
    <title>{{ $customer['site_name'] }} - Invoice #{{ $customer['invoice_number'] }}</title>
    <style>
        body, table, td {
            background-color: transparent !important;
        }
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
                height: 550px;
                width: 100%;
        }
        .invoice_footer_image {
        background: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path($site->invoice_footer_image))) }}');
        background-repeat: no-repeat; 
        background-position: center;
        background-size: cover;
        height: 120px; /* Increased from default */
        padding: 20px;
        width: 100%;
     }
 </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="width: 60%" height="100%;" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                   
                    <tr>
                        <td style="padding: 0px;max-height: 100px;">
                            <table>
                                <tr>
                                    <td class="invoice_header_image">
                                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path($site->invoice_header_image))) }}" alt="" style="margin: auto; display: block;height:60px;">
                                    </td>

                                    <td style="width:300px;padding: 40px;text-align: right;">
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
                   
                    <tr>
                        <td class="invoice_image1" style="background-color: transparent;">
                            <table style="background-color: transparent;width: 100%;">
                                <tr>
                                    <td>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 700;">
                                            <b>BILLED FROM:</b>
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
                            <br><br>

                            <table style="width: 100%;height: 400px; width: 100%; border: 1px solid black; border-collapse: collapse;">
                                <tr style="height: 24px;">
                                    <td style="width: 10%; text-align: center; font-family: arial; font-size: 10px; font-weight: 400; border: 1px solid black;">
                                        <b>SR. NO.</b>
                                    </td>
                                    <td style="width: 45%; text-align: center; font-family: arial; font-size: 10px; font-weight: 400; border: 1px solid black;">
                                        <b>DESCRIPTION</b>
                                    </td>
                                    <td style="width: 15%; text-align: center; font-family: arial; font-size: 10px; font-weight: 400; border: 1px solid black;">
                                        <b>UNIT PRICE</b>
                                    </td>
                                    <td style="width: 15%; text-align: center; font-family: arial; font-size: 10px; font-weight: 400; border: 1px solid black;">
                                        <b>QUANTITY</b>
                                    </td>
                                    <td style="width: 15%; text-align: center; font-family: arial; font-size: 10px; font-weight: 400; border: 1px solid black;">
                                        <b>TOTAL</b>
                                    </td>
                                </tr>

                                @foreach($products as $product)
                                <tr style="height: 24px;">
                                    <td style="width: 10%; text-align: center; font-family: arial; font-size: 10px; border: 1px solid black;">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td style="width: 45%; text-align: left; padding-left: 10px; font-family: arial; font-size: 10px; border: 1px solid black;">
                                        {{ $product->name }}
                                    </td>
                                    <td style="width: 15%; text-align: right; padding-right: 10px; font-family: arial; font-size: 10px; border: 1px solid black;">
                                        {{ site_currency() . number_format($product->unit_price, 2) }}
                                    </td>
                                    <td style="width: 15%; text-align: center; font-family: arial; font-size: 10px; border: 1px solid black;">
                                        1
                                    </td>
                                    <td style="width: 15%; text-align: right; padding-right: 10px; font-family: arial; font-size: 10px; border: 1px solid black;">
                                        {{ site_currency() . number_format($product->unit_price, 2) }}
                                    </td>
                                </tr>
                                @endforeach

                                <tr>
                                    <td colspan="4" style="text-align: right; font-family: arial; font-size: 10px; font-weight: 700; padding-right: 10px;">
                                        SUBTOTAL
                                    </td>
                                    <td style="text-align: right; padding-right: 10px; font-family: arial; font-size: 10px; font-weight: 700; border: 1px solid black;">
                                        {{ site_currency() . number_format($customer['invoice_amount'], 2) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="4" style="text-align: right; font-family: arial; font-size: 10px; padding-right: 10px;">
                                        DISCOUNT
                                    </td>
                                    <td style="text-align: right; padding-right: 10px; font-family: arial; font-size: 10px; color: green; border: 1px solid black;">
                                        {{ site_currency() . number_format($customer['discount_amount'], 2) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="4" style="text-align: right; font-family: arial; font-size: 10px; padding-right: 10px;">
                                        TOTAL DUE
                                    </td>
                                    <td style="text-align: right; padding-right: 10px; font-family: arial; font-size: 10px; border: 1px solid black;">
                                        {{ site_currency() . number_format($customer['invoice_amount'], 2) }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
                                <tr>
                                    <td class="invoice_footer_image">
                                        <p style="text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight:700;color:whitesmoke;">
                                            WE APPRECIATE YOUR BUSINESS
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr> 
                     
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
