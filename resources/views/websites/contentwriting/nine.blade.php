<!DOCTYPE html>
<html>
<head>
     <!-- kupido -->
    <title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body, table, td {
            background-color: transparent !important;
           
        }
        .invoice_image1 table td {
            padding-top:5px !important;
            padding-bottom:5px !important;
        }
        .invoice_header_image {
            background-image: url('{{ $company_logo }}');
            background-repeat: no-repeat; 
            padding-left: 40px;
            background-position: center;
            background-size: cover;
            width: 300px;
        }
        .invoice_image1 {
                padding: 40px;
                padding-top: 0px;
                background: url('{{ $invoice_image1 }}');
                background-repeat: no-repeat; 
                background-position: center;
                background-size: cover;
                height: 550px;
                width: 100%;
        }
        .invoice_footer_image {
            background: url('{{ $invoice_footer_image }}');
            background-repeat: no-repeat; 
            background-position: center;
            background-size: cover;
            height: 130px; 
            padding: 10px;
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
                                    <center><img src="{{ $invoice_header_image }}" alt="" style="display: block; margin: 0 auto; height: 60px;"></center>
                                </td>


                                    <td style="width:300px;padding: 40px;text-align: right;">
                                        <h1 style="font-family: arial;font-size: 20px;margin: 0px;font-weight: 700;">INVOICE</h1><br><br>
                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            INVOICE #{{ $invoice_number}}
                                        </p>
                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            DATE: {{ $invoice_date }}
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
                                            {{ $site->site_name }}
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            Website: {{ $site->site_link ?? 'N/A' }}
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            Email: {{ $company_email }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <br><br>

                            <table style="width: 100%; height: auto; border: 1px solid black; border-collapse: collapse;">
                                <tr style="height: 24px;">
                                    <td style="width: 10%; text-align: center; font-family: arial; font-size: 10px; font-weight: 400; border: 1px solid black;"><b>SR. NO.</b></td>
                                    <td style="width: 15%; text-align: center; font-family: arial; font-size: 10px; font-weight: 400; border: 1px solid black;"><b>QUANTITY</b></td>
                                    <td style="width: 45%; text-align: center; font-family: arial; font-size: 10px; font-weight: 400; border: 1px solid black;"><b>DESCRIPTION</b></td>
                                    <td style="width: 15%; text-align: center; font-family: arial; font-size: 10px; font-weight: 400; border: 1px solid black;"><b>UNIT PRICE</b></td>
                                    <td style="width: 15%; text-align: center; font-family: arial; font-size: 10px; font-weight: 400; border: 1px solid black;"><b>TOTAL</b></td>
                                </tr>

                                @foreach($products as $product)
                                <tr style="height: auto;">
                                    <td style="text-align: center; font-family: arial; font-size: 10px; border: 1px solid black;">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td style="text-align: center; font-family: arial; font-size: 10px; border: 1px solid black;">
                                        {{ $product->quantity ?? 1 }}
                                    </td>
                                    <td style="padding: 4px; font-family: arial; font-size: 10px; border: 1px solid black;">
                                        <b>{{ $product->name }}</b>
                                        <table style="width: 100%; font-size: 9px; font-family: arial; margin-top: 3px;">
                                            <tr>
                                                @if($product->project_title)<td><b>Title:</b> {{ $product->project_title }}</td>@endif
                                                @if($product->wordcount)<td><b>Words:</b> {{ $product->wordcount }}</td>@endif
                                            </tr>
                                            <tr>
                                                @if($product->imagecount)<td><b>Images:</b> {{ $product->imagecount }}</td>@endif
                                                @if($product->quantity)<td><b>Qty:</b> {{ $product->quantity }}</td>@endif
                                            </tr>
                                            <tr>
                                                @if($product->turnaround)<td><b>Turnaround:</b> {{ $product->turnaround }}</td>@endif
                                                @if($product->delivery)<td><b>Delivery:</b> {{ $product->delivery }}</td>@endif
                                            </tr>
                                            <tr>
                                                @if($product->quality)<td><b>Quality:</b> {{ $product->quality }}</td>@endif
                                                @if($product->subject)<td><b>Subject:</b> {{ $product->subject }}</td>@endif
                                            </tr>
                                            <tr>
                                                @if($product->preferred_voice)<td><b>Voice:</b> {{ $product->preferred_voice }}</td>@endif
                                                @if($product->preferred_writing_style)<td><b>Style:</b> {{ $product->preferred_writing_style }}</td>@endif
                                            </tr>
                                            <tr>
                                                @if($product->brand_name)<td><b>Brand:</b> {{ $product->brand_name }}</td>@endif
                                                @if($product->audience)<td><b>Audience:</b> {{ $product->audience }}</td>@endif
                                            </tr>
                                            <tr>
                                                @if($product->reference_link)
                                                    <td colspan="2"><b>Ref:</b> <a href="{{ $product->reference_link }}" style="color: #007bff; text-decoration: underline;" target="_blank">Link</a></td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if($product->note)
                                                    <td colspan="2"><b>Note:</b> {{ $product->note }}</td>
                                                @endif
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="text-align: right; padding-right: 10px; font-family: arial; font-size: 10px; border: 1px solid black;">
                                        {{ site_currency() . number_format($product->unit_price, 2) }}
                                    </td>
                                    <td style="text-align: right; padding-right: 10px; font-family: arial; font-size: 10px; border: 1px solid black;">
                                        {{ site_currency() . number_format($product->unit_price, 2) }}
                                    </td>
                                </tr>
                                @endforeach

                                <tr>
                                    <td colspan="4" style="text-align: right; font-family: arial; font-size: 10px; font-weight: 700; padding-right: 10px;">
                                        SUBTOTAL
                                    </td>
                                    <td style="text-align: right; padding-right: 10px; font-family: arial; font-size: 10px; font-weight: 700; border: 1px solid black;">
                                        {{ site_currency() . number_format(($invoice_amount + $discount_amount), 2) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="4" style="text-align: right; font-family: arial; font-size: 10px; padding-right: 10px;">
                                        DISCOUNT
                                    </td>
                                    <td style="text-align: right; padding-right: 10px; font-family: arial; font-size: 10px; color: green; border: 1px solid black;">
                                        {{ site_currency() . number_format($discount_amount, 2) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="4" style="text-align: right; font-family: arial; font-size: 10px; padding-right: 10px;">
                                        TOTAL DUE
                                    </td>
                                    <td style="text-align: right; padding-right: 10px; font-family: arial; font-size: 10px; border: 1px solid black;">
                                        {{ site_currency() . number_format($invoice_amount, 2) }}
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
