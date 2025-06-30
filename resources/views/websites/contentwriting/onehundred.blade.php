<!DOCTYPE html>
<html>
<head>
    <title>Your Email Title</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Arial:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;">
                            <table style="background: url('{{ $invoice_header_image }}');background-repeat: no-repeat;background-size:cover;margin: auto; display: block;border-collapse: collapse;background-position: center;height: 150px;">
                                <tr style="vertical-align: bottom;">
                                    <td style="padding: 40px;width:300px;" align="center" >
                                        <img src="{{ $company_logo }}" alt="" style="height: 100px;">
                                    </td>
                                    <td style="vertical-align: middle;width: 300px;">
                                        <h1 style="margin: 0px;font-family: Arial;font-size: 28px;text-align: center;">
                                            INVOICE
                                        </h1>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr style="background:#ffff ;">
                        <td style="padding:40px;display: flex;flex-direction: column;padding-bottom: 0px;">
                            <table>
                                <tr>
                                    <td colspan="2">
                                        <h1 style="margin: 0px;font-family: Arial;font-size: 10px;line-height: 18px;">
                                            Date: <span style="font-weight: 400;">{{ $invoice_date }}</span>
                                        </h1>
                                        <h1 style="margin: 0px;font-family: Arial;font-size: 10px;line-height: 18px;">
                                            Invoice Number: <span style="font-weight: 400;">{{ $invoice_number }}</span>
                                        </h1>
                                    </td>
                                </tr>
                                <tr style="height:10px;"></tr>
                                <tr>
                                    <td style="width: 70%;">
                                        <h1 style="margin: 0px;font-family: Arial;font-size: 10px;line-height: 18px;">
                                           Billed From:
                                        </h1>
                                        <p style="margin: 0px;font-family: Arial;font-size: 10px;line-height: 18px;">
                                            {{ $site_name }}
                                        </p>
                                    </td>
                                    <td>
                                        <h1 style="margin: 0px;font-family: Arial;font-size: 10px;line-height: 18px;">
                                           Billed To:
                                        </h1>
                                        <p style="margin: 0px;font-family: Arial;font-size: 10px;line-height: 18px;">
                                            {{ $customer_name }}
                                        </p>
                                    </td>
                                </tr>
                                <tr style="height:10px;"></tr>
                                 <tr>
                                    <td colspan="2">
                                        <h1 style="margin: 0px;font-family: Arial;font-size: 10px;line-height: 18px;">
                                            Email:  <span style="font-weight: 400;">{{ $company_email }}</span>
                                        </h1>
                                        <h1 style="margin: 0px;font-family: Arial;font-size: 10px;line-height: 18px;">
                                            Website:  <a href="{{ $site_name }}" style="font-weight: 400;text-decoration: none;color: #000000;">{{ $site_name }}</a>
                                        </h1>
                                        <h1 style="margin: 0px;font-family: Arial;font-size: 10px;line-height: 18px;">
                                            Phone:  <span style="font-weight: 400;">{{ $company_mobile }}</span>
                                        </h1>
                                        <h1 style="margin: 0px;font-family: Arial;font-size: 10px;line-height: 18px;">
                                            Address:  <span style="font-weight: 400;">{{ $company_address }}</span>
                                        </h1>
                                    </td>
                                </tr>
                            </table>
                            <table cellspacing="0" cellpadding="0" border="0" width="100%" style="border-collapse: collapse;margin-top:20px;">
                                <tr style="height:40px;background:#EFEFEF ;">
                                    <td>
                                        <p style="color:#981618;font-size: 10px;font-weight:700;font-family:Arial;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;">
                                            Qty
                                        </p>
                                    </td>
                                    <td>
                                         <p style="color:#981618;font-size: 10px;font-weight:700;font-family:Arial;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;">
                                            Service Details
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#981618;font-size: 10px;font-weight:700;font-family:Arial;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;">
                                            Imagery
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#981618;font-size: 10px;font-weight:700;font-family:Arial;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;">
                                            Unit Price
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#981618;font-size: 10px;font-weight:700;font-family:Arial;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;">
                                            Total
                                        </p>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr style="height:40px;border-bottom:2px solid #EFEFEF;">
                                    <td>
                                        <p style="color:black;font-size: 10px;font-weight: 500;font-family:Arial;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;">
                                            1
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:black;font-size: 10px;font-weight: 500;font-family:Arial;margin: 0px;line-height:16px;">
                                           {{ $product->name }} <br>
                                            @if($product->wordcount)<span class="me-2 badge bg-light text-dark"><strong>Words Count:</strong> {{ $product->wordcount }}</span>@endif
                                            @if($product->quality)<span class="me-2 badge bg-light text-dark"><strong>Quality:</strong> {{ $product->quality }}</span>@endif

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
                                        <p style="color:black;font-size: 10px;font-weight: 500;font-family:Arial;margin: 0px;line-height: 28px;">
                                          {{ $product->imagecount }}
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:black;font-size: 10px;font-weight: 500;font-family: Arial;margin: 0px;line-height: 28px;">
                                           {{ site_currency() }} {{ number_format($product->unit_price, 2) }}
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:black;font-size: 10px;font-weight: 500;font-family: Arial;margin: 0px;line-height: 28px;">
                                           {{ site_currency() }} {{ number_format($product->unit_price, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                @endforeach
                              <tr style="height:40px;">
                                    <td colspan="2"></td>
                                    <td colspan="2" style="border-bottom:2px solid #EFEFEF;">
                                        <p style="color:#000000;font-size: 10px;font-weight:400;font-family:Arial;margin: 0px;line-height: 28px;text-align:left;padding-left:10px;text-transform:capitalize;">
                                            Sub total
                                        </p>
                                    </td>
                                    <td style="border-bottom:2px solid #EFEFEF;">
                                        <p style="color:#000000;font-size: 10px;font-weight:400;font-family: Arial;margin: 0px;line-height: 28px;text-transform: uppercase;">
                                           {{ site_currency() }} {{  number_format(($invoice_amount + $discount_amount), 2) }}
                                        </p>
                                    </td>
                                </tr>
                                 <tr style="height:40px;">
                                    <td colspan="2"></td>
                                    <td colspan="2" style="border-bottom:2px solid #EFEFEF;">
                                        <p style="color:#000000;font-size: 10px;font-weight:400;font-family:Arial;margin: 0px;line-height: 28px;text-align:left;padding-left:10px;text-transform:capitalize;">
                                            Discount
                                        </p>
                                    </td>
                                    <td style="border-bottom:2px solid #EFEFEF;">
                                        <p style="color:#000000;font-size: 10px;font-weight:400;font-family: Arial;margin: 0px;line-height: 28px;text-transform: uppercase;">
                                           {{ site_currency() }} {{ number_format($discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                 <tr style="height:40px;">
                                    <td colspan="2"></td>
                                    <td colspan="2" style="background: #EFEFEF;">
                                        <p style="color:#981618;font-size: 10px;font-weight:700;font-family:Arial;margin: 0px;line-height: 28px;text-align:left;padding-left:10px;text-transform:capitalize;">
                                            Grand Total
                                        </p>
                                    </td>
                                    <td style="background: #EFEFEF;">
                                        <p style="color:#981618;font-size: 10px;font-weight:700;font-family: Arial;margin: 0px;line-height: 28px;text-transform: uppercase;">
                                           {{ site_currency() }} {{ number_format($invoice_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr>
                        <td align="center">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;">
                                <tr>
                                   <td style="padding: 0px;">
                                    <img src="{{ $invoice_image1 }}" alt="" style="height:400px;">
                                   </td>
                                   <td align="center" style="vertical-align: bottom;padding: 40px;">
                                    <img src="{{ $invoice_footer_image }}" alt="" style="width: 100px;">
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
