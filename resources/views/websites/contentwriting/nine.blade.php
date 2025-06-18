<!DOCTYPE html>
<html>
<head>
    <title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body, table, td {
            /* background-color: transparent !important; */
           
        }
       table td {
            padding-top:10px !important;
            padding-bottom:10px !important;
        }
        .invoice_footer_image {
            background: url('{{ $invoice_footer_image }}');
            background-repeat: no-repeat; 
            background-position: center;
            background-size: cover;
            height: 100px; 
            padding: 10px;
            width: 100%;
        }
 </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="100%" height="100%;" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
              
                    <tr>
                         <td style="padding: 40px;vertical-align: bottom;">
                           <h1 style="margin: 0px;font-family: Calibri;font-size: 40px;text-transform: uppercase;">Invoice</h1>
                        </td>
                        <td style="padding: 40px;" align="right">
                           <img src="{{ $company_logo }} " alt="" style="width:200px;">
                        </td>
                    </tr>
                  
                    <tr style="background:#ffff ;">
                        <td style="padding:0px 40px 40px 40px;width: 100%;" colspan="2">
                            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td colspan="2" style="border-radius: 10px 0 0 10px !important;">
                                        <p style="color:#ffffff;font-size: 12px;font-weight:700;font-family:Calibri;margin: 0px;line-height:14px;text-align: left;background-color: #9A96F4;width: 200px;padding: 10px;border-radius:80px;text-transform: uppercase;">
                                          BILL FORM
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" >
                                        <p style="color:#000000;font-size:9px;font-weight:400;font-family:Calibri;margin: 0px;line-height:14px;text-align: left;padding-top: 10px;">
                                        {{ $site->site_name }}
                                        </p>
                                    </td>
                                </tr>
                                <tr style="height: 24px;"></tr>
                                <tr>
                                    <td colspan="2" style="border-radius: 10px 0 0 10px !important;">
                                        <p style="color:#ffffff;font-size: 12px;font-weight:700;font-family:Calibri;margin: 0px;line-height:14px;text-align: left;background-color: #9A96F4;width: 200px;padding: 10px;border-radius:80px;text-transform: uppercase;">
                                          BILL TO
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p style="color:#000000;font-size:9px;font-weight:400;font-family:Calibri;margin: 0px;line-height:14px;text-align: left;">
                                        {{ $customer_name }}
                                        </p>
                                    </td>
                                    <td align="right">
                                        <p style="color:#767171;font-size:9px;font-weight:400;font-family:Calibri;margin: 0px;line-height:14px;text-align:right;">
                                         <b>Invoice Number:</b> #{{ $invoice_number}}
                                        </p>
                                        <p style="color:#767171;font-size:9px;font-weight:400;font-family:Calibri;margin: 0px;line-height:14px;text-align:right;">
                                         <b>Date:</b> {{ $invoice_date }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <table class="table_body" cellspacing="0" cellpadding="0" border="0" width="100%" style="border-collapse: collapse;margin-top:50px;min-height: 500px !important;">
                                <tr style="width:440px;height:40px;background-color: #9A96F4! important;border-radius: 10px 0 0 10px !important;">
                                    <td style="border-radius:10px 0px 0px 10px;">
                                        <p style="vertical-align: middle;color:#ffffff;font-size: 10px;font-weight: 700;font-family: Calibri;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;text-transform: uppercase;">
                                            ITEM
                                        </p>
                                    </td>
                                    <td style="max-width: 50%; width: 50%;">
                                        <p style="vertical-align: middle;color:#ffffff;font-size: 10px;font-weight: 700;font-family: Calibri;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;text-transform: uppercase;">
                                            Description
                                        </p>
                                    </td>
                                    <td>
                                        <p style="vertical-align: middle;color:#ffffff;font-size: 10px;font-weight: 700;font-family: Calibri;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;text-transform: uppercase;">
                                           QTY
                                        </p>
                                    </td>
                                    <td>
                                        <p style="vertical-align: middle;color:#ffffff;font-size: 10px;font-weight: 700;font-family: Calibri;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;text-transform: uppercase;">
                                            unit price
                                        </p>
                                    </td>
                                    <td style="border-radius: 0px 10px 10px 0px;">
                                        <p style="vertical-align: middle;color:#ffffff;font-size: 10px;font-weight: 700;font-family: Calibri;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;text-transform: uppercase;">
                                            Total
                                        </p>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr>
                                    <td>
                                        <p style="vertical-align: middle;color:black;font-size:8px;font-weight: 500;font-family: Calibri;margin: 0px;line-height:14px;text-align: left;padding-left:10px;">
                                        {{ $product->name }}
                                        </p>
                                    </td>
                                    <td style="max-width: 50%; width: 50%;">
                                        <p style="vertical-align: middle;color:black;font-size: 8px;font-weight: 500;font-family: Calibri;margin: 0px;line-height:14px;text-align: left;padding-left:10px;">
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
                                            
                                        </p>
                                    </td>
                                    <td>
                                        <p style="vertical-align: middle;color:black;font-size:8px;font-weight: 500;font-family: Calibri;margin: 0px;line-height:14px;text-align: left;padding-left:10px;">
                                        {{ $product->quantity }}
                                        </p>
                                    </td>
                                    <td>
                                        <p style="vertical-align: middle;color:black;font-size:8px;font-weight: 500;font-family: Calibri;margin: 0px;line-height:14px;text-align: left;padding-left:10px;">
                                        {{ site_currency() }} {{ number_format($product->unit_price, 2) }}
                                        </p>
                                    </td>
                                    <td>
                                        <p style="vertical-align: middle;color:black;font-size:8px;font-weight: 500;font-family: Calibri;margin: 0px;line-height:14px;text-align:right;padding-right:10px;">
                                        {{ site_currency() }} {{ number_format($product->unit_price, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                @endforeach
                                <tr style="height: 28px;">
                                    <td>
                                        <p style="vertical-align: middle;color:#000000;font-size: 10px;font-weight:400;font-family: Calibri;margin: 0px;line-height: 28px;text-align:left;padding-right:10px;text-transform: uppercase;padding-left: 10px;">
                                            Subtotal
                                        </p>
                                    </td>
                                    <td>
                                        <p style="vertical-align: middle;color:#000000;font-size: 10px;font-weight:400;font-family: Calibri;margin: 0px;line-height: 28px;text-transform: uppercase;text-align: center;">
                                        {{ site_currency() }} {{  number_format(($invoice_amount + $discount_amount), 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr style="height: 28px;">
                                    <td>
                                        <p style="vertical-align: middle;color:#000000;font-size: 10px;font-weight:400;font-family: Calibri;margin: 0px;line-height: 28px;text-align:left;padding-right:10px;text-transform: uppercase;padding-left: 10px;">
                                            Discount
                                        </p>
                                    </td>
                                    <td>
                                        <p style="vertical-align: middle;color:#000000;font-size: 10px;font-weight:400;font-family: Calibri;margin: 0px;line-height: 28px;text-transform: uppercase;text-align: center;">
                                        {{ site_currency() }} {{ number_format($discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr style="height: 28px; background-color: #9A96F4;">
                                    <td style="border-top-left-radius: 10px; border-bottom-left-radius: 10px; background-color: #9A96F4;">
                                        <p style="vertical-align: middle; color: #ffffff; font-size: 10px; font-weight: 400; font-family: Calibri; margin: 0px; line-height: 28px; text-align: left; padding: 0 10px; text-transform: uppercase;">
                                        Total
                                        </p>
                                    </td>
                                    <td style="border-top-right-radius: 10px; border-bottom-right-radius: 10px;background-color: #9A96F4;">
                                        <p style="vertical-align: middle; color: #ffffff; font-size: 10px; font-weight: 400; font-family: Calibri; margin: 0px; line-height: 28px; text-align: center; text-transform: uppercase;">
                                        {{ site_currency() }} {{ number_format($invoice_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" class="invoice_footer_image"  colspan="2">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; width: 100%;">
                            <tr style="vertical-align: middle;">
                                <!-- Site Link -->
                                <td>
                                    <table cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                        <tr>
                                            <td style="vertical-align: middle; padding-right: 6px;">
                                                <img src="{{ $invoice_image1 }}" alt="" style="height: 24px;">
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <span style="color:#ffffff; font-size: 8px; font-weight:400; font-family: Calibri; line-height: 24px;">
                                                    {{ $site->site_link }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                                <!-- Company Email -->
                                <td>
                                    <table cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                        <tr>
                                            <td style="vertical-align: middle; padding-right: 6px;">
                                                <img src="{{ $invoice_image2 }}" alt="" style="height: 24px;">
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <span style="color:#ffffff; font-size: 8px; font-weight:400; font-family: Calibri; line-height: 24px;">
                                                    {{ $company_email }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                                <!-- Company Address -->
                                <td>
                                    <table cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                        <tr>
                                            <td style="vertical-align: middle; padding-right: 6px;">
                                                <img src="{{ $invoice_image3 }}" alt="" style="height: 24px;">
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <span style="color:#ffffff; font-size: 8px; font-weight:400; font-family: Calibri; line-height: 12px;">
                                                    {!! $company_address !!}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
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
