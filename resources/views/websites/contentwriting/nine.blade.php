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
                                        @if(!empty($site->site_name))
                                        <p style="font-family: Arial; font-size: 10px; margin: 0; font-weight: 400;">
                                            {{ $site->site_name }}
                                        </p>
                                        @endif

                                        @if(!empty($site->site_link))
                                        <p style="font-family: Arial; font-size: 10px; margin: 0; font-weight: 400;">
                                            Website: {{ $site->site_link }}
                                        </p>
                                        @endif

                                        @if(!empty($company_email))
                                        <p style="font-family: Arial; font-size: 10px; margin: 0; font-weight: 400;">
                                            Email: {{ $company_email }}
                                        </p>
                                        @endif

                                    </td>
                                </tr>
                            </table>
                            <br><br>

                            <table style="width: 100%; border: 1px solid black; border-collapse: collapse;">
                                <tr style="height: 24px;">
                                    <td style="width: 10%; text-align: center; font-family: arial; font-size: 10px; font-weight: bold; border: 1px solid black;">SR. NO.</td>
                                    <td style="width: 60%; text-align: center; font-family: arial; font-size: 10px; font-weight: bold; border: 1px solid black;">PRODUCT DESCRIPTION</td>
                                    <td style="width: 15%; text-align: center; font-family: arial; font-size: 10px; font-weight: bold; border: 1px solid black;">QUANITY</td>
                                    <td style="width: 15%; text-align: center; font-family: arial; font-size: 10px; font-weight: bold; border: 1px solid black;">UNIT PRICE</td>
                                </tr>

                                @foreach($products as $product)
                                <tr>
                                    <td style="text-align: center; font-family: arial; font-size: 10px; border: 1px solid black; vertical-align: top;">
                                        {{ $loop->iteration }}
                                    </td>
                                   
                                    <td style="font-family: Arial, sans-serif; font-size: 8px; border: 1px solid black; padding: 6px 8px; vertical-align: top; line-height: 1.4;">
                                       
                                     <div class="" style="font-weight: bold; margin-bottom: 4px; font-size: 12px;">{{ $product->name }}</div>
                                   
                                        @if($product->wordcount)<span class="me-2 badge bg-light text-dark"><strong>Words Count:</strong> {{ $product->wordcount }}</span>@endif
                                        @if($product->quality)<span class="me-2 badge bg-light text-dark"><strong>Quality:</strong> {{ $product->quality }}</span>@endif
                                        @if($product->imagecount)<span class="me-2 badge bg-light text-dark"><strong>Image Count:</strong> {{ $product->imagecount }}</span>@endif
                                        @if($product->quantity)<span class="me-2 badge bg-light text-dark"><strong>Quantity:</strong> {{ $product->quantity }}</span>@endif
                                        @if($product->turnaround)<span class="me-2 badge bg-light text-dark"><strong>Turnaround Time:</strong> {{ $product->turnaround }}</span>@endif
                                        @if($product->delivery)<span class="me-2 badge bg-light text-dark"><strong>Delivery In:</strong> {{ $product->delivery }}</span>@endif<br>
                                        @if($product->project_title)<span class="me-2 badge bg-light text-dark"><strong>Project Title:</strong> {{ $product->project_title }}</span>@endif
                                        @if($product->subject)<span class="me-2 badge bg-light text-dark"><strong>Subject:</strong> {{ $product->subject }}</span>@endif
                                        @if($product->preferred_voice)<span class="me-2 badge bg-light text-dark"><strong>Preferred Voice:</strong> {{ $product->preferred_voice }}</span>@endif
                                        @if($product->preferred_writing_style)<span class="me-2 badge bg-light text-dark"><strong>Preferred Writing Style:</strong> {{ $product->preferred_writing_style }}</span>@endif
                                        @if($product->brand_name)<span class="me-2 badge bg-light text-dark"><strong>Brand Name:</strong> {{ $product->brand_name }}</span>@endif
                                        @if($product->audience)<span class="me-2 badge bg-light text-dark"><strong>Audience:</strong> {{ $product->audience }}</span>@endif
                                        @if($product->reference_link)
                                        <span class="me-2 badge bg-light text-dark"><strong>Reference link:</strong> 
                                            <a href="{{ $product->reference_link }}" target="_blank" class="text-primary text-decoration-underline">{{ $product->reference_link }}</a>
                                        </span>
                                        @endif
                                        @if($product->note)<span class="badge bg-light text-dark"><strong>Additional Note:</strong> {{ $product->note }}</span>@endif
                                   
                                    </td>
                                    <td class="text-center" style="text-align: right; padding-right: 10px; font-family: arial; font-size: 10px; border: 1px solid black; vertical-align: top;">
                                         {{ $product->quantity }}
                                    </td>
                                    <td class="text-center" style="text-align: center; padding-right: 10px; font-family: arial; font-size: 10px; border: 1px solid black; vertical-align: top;">
                                        {{ site_currency() . number_format($product->unit_price, 2) }}
                                    </td>

                                </tr>
                                @endforeach

                                <tr>
                                    <td colspan="3" style="text-align: right; font-family: arial; font-size: 10px; font-weight: bold; padding-right: 10px;">
                                        SUBTOTAL
                                    </td>
                                    <td class="text-center" style="text-align: center; padding-right: 10px; font-family: arial; font-size: 10px; font-weight: bold; border: 1px solid black;">
                                        {{ site_currency() . number_format(($invoice_amount + $discount_amount), 2) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3" style="text-align: right; font-family: arial; font-size: 10px; padding-right: 10px;">
                                        DISCOUNT
                                    </td>
                                    <td class="text-center" style="text-align: center; padding-right: 10px; font-family: arial; font-size: 10px; color: green; border: 1px solid black;">
                                        {{ site_currency() . number_format($discount_amount, 2) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3" style="text-align: right; font-family: arial; font-size: 10px; padding-right: 10px;">
                                        TOTAL DUE
                                    </td>
                                    <td class="text-center" style="text-align: center; padding-right: 10px; font-family: arial; font-size: 10px; border: 1px solid black;">
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
