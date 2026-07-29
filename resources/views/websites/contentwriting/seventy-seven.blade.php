<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        tr.myrow:nth-of-type(odd) {
            background-color: #EDEAE4 !important;
        }
        body{
            margin: 0px;
            padding: 0px
        }

        </style>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0; height: 130px;">
                            <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                                <tr>
                                    <td style="
                                        background: url('{{ $invoice_header_image }}') no-repeat center;
                                        background-size: cover;
                                        height: 130px;">
                                        <table width="100%" style="vertical-align: top; padding: 40px;">
                                            <tr>
                                                <!-- Left Section: INVOICE + Date/No -->
                                                <td style="text-align: left; vertical-align: top;">
                                                    <h1
                                                        style="font-size: 54px; font-weight: bolder; letter-spacing: 4px; margin: 0;">
                                                        INVOICE</h1>
                                                    <table style="margin-top: 10px; font-size: 16px;">
                                                        <tr>
                                                            <td style="padding-right: 40px;">
                                                                <strong>Date Invoice :</strong><br>
                                                                <span style="color: #666;"> {{ $invoice_date }} </span>
                                                            </td>
                                                            <td>
                                                                <strong>No Invoice :</strong><br>
                                                                <span style="color: #666;">#{{ $invoice_number }}</span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>

                                                <!-- Right Section: Logo + Company Name -->
                                                <td style="text-align: right;">
                                                    <img src="{{ $company_logo }}" alt="Skyrocket Logo"
                                                        style="height: 50px; vertical-align: middle;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td
                            style="padding:40px;padding-top:0px;background:#ffffff; background-repeat: no-repeat;background-position: center;background-size: cover;height:444px; font-family: 'Montserrat';">
                            <br>
                            <br>
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="font-family: 'Montserrat'; color: #000; border-collapse: collapse;">
                                <tr>
                                    <!-- Invoice To -->
                                    <td width="33%" style="vertical-align: top; padding: 10px;">
                                        <strong style="font-size: 13px;">Invoice To :</strong><br>
                                        <span style="color: #397872; font-weight: bold; font-size: 17px;">{{ $customer_name }}</span><br>
                                        <p style="font-size: 8px;">
                                            <a href="mailto:{{ $customer_email }}"
                                                style="color: blue; text-decoration: underline;">{{ $customer_email }}</a>
                                        </p>
                                    </td>

                                    <!-- Invoice From -->
                                    <td width="33%" style="vertical-align: top; padding: 10px;">
                                        <strong style="font-size: 13px;">Invoice From :</strong><br>
                                        <span style="color: #397872; font-weight: bold; font-size: 17px;">{{ $site_name }}</span><br>
                                        <p style="font-size: 8px;">
                                            {!! $company_address !!}<br>
                                            {{ $company_mobile }}<br>
                                            <b>{{ $site->site_link }}</b>
                                        </p>
                                    </td>

                                    <!-- Total -->
                                    <td width="33%" align="right" style="vertical-align: bottom; padding: 10px;">
                                        <span style="font-size: 18px; font-weight: bold;">Total : <span
                                                style="color: #000;">{{ site_currency() . number_format($invoice_amount, 2) }}</span></span>
                                    </td>
                                </tr>
                            </table>
                            <div style="min-height:625px !important;">
                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="font-family: 'Montserrat'; border-collapse: collapse; font-size: 9px;">
                                <!-- Header Row -->
                                <tr style="background-color: #EDEAE4; font-weight: bold; text-transform: uppercase;">
                                    <td>No.</td>
                                    <td>Item Description</td>
                                    <td>Billing Type</td>
                                    <td>Qty</td>
                                    <td style="text-align: right;">Subtotal</td>
                                </tr>
                                @foreach($products as $index => $product)
                                <tr class="myrow" style="font-weight: bold;">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $product->name }}</strong><br>
                                            <span style=" font-size: 8px; font-weight: normal;">
                                            @if($product->wordcount)<span class="me-2 badge bg-light text-dark"><strong>Words Count:</strong> {{ $product->wordcount }}</span>@endif
                                            @if($product->quality)<span class="me-2 badge bg-light text-dark"><strong>Quality:</strong> {{ $product->quality }}</span>@endif
                                            @if($product->imagecount)<span class="me-2 badge bg-light text-dark"><strong>Image Count:</strong> {{ $product->imagecount }}</span>@endif
                                            <br />
                                            @if($product->quantity)<span class="me-2 badge bg-light text-dark"><strong>Quantity:</strong> {{ $product->quantity }}</span>@endif
                                            @if($product->turnaround)<span class="me-2 badge bg-light text-dark"><strong>Turnaround Time:</strong> {{ $product->turnaround }}</span>@endif
                                            @if($product->delivery)<span class="me-2 badge bg-light text-dark"><strong>Delivery In:</strong> {{ $product->delivery }}</span>@endif<br>
                                            @if($product->project_title)<span class="me-2 badge bg-light text-dark"><strong>Project Title:</strong> {{ $product->project_title }}</span>@endif
                                            <br>
                                            @if($product->subject)<span class="me-2 badge bg-light text-dark"><strong>Subject:</strong> {{ $product->subject }}</span>@endif
                                            @if($product->preferred_voice)<span class="me-2 badge bg-light text-dark"><strong>Preferred Voice:</strong> {{ $product->preferred_voice }}</span>@endif
                                            @if($product->preferred_writing_style)<span class="me-2 badge bg-light text-dark"><strong>Preferred Writing Style:</strong> {{ $product->preferred_writing_style }}</span>@endif
                                            @if($product->brand_name)<span class="me-2 badge bg-light text-dark"><strong>Brand Name:</strong> {{ $product->brand_name }}</span>@endif
                                            @if($product->audience)<span class="me-2 badge bg-light text-dark"><strong>Audience:</strong> {{ $product->audience }}</span>@endif
                                        </span>
                                    </td>
                                    <td><strong>One Time</strong></td>
                                    <td>{{ $product->quantity }}</td>
                                    <td style="text-align: right;">{{ site_currency() . number_format($product->unit_price * $product->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </table>
                           
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="font-family: 'Montserrat'; font-size: 8px;">
                                <tr>
                                    <td valign="top" style="padding: 13px 10px 10px 10px;">
                                        <!-- <img src="{{ $invoice_image1 }}" alt="" style="width: 7px;"> -->
                                    </td>
                                    <td width="60%" valign="top" style="padding: 10px 10px 10px 0px;">
                                        <!-- <p style="margin: 0; color: black; font-weight: bold; font-size: 9px;">
                                            Note :
                                        </p>
                                        <p style="margin-top: 5px; color: #333;">
                                           {{ $site->site_description }}
                                        </p> -->
                                    </td>

                                    <!-- Totals Section -->
                                    <td width="40%" valign="top" style="padding: 10px;">
                                        <table width="100%" cellpadding="5" cellspacing="0" style="font-size: 9px;">
                                            <tr>
                                                <td style="color: #333;">Subtotal :</td>
                                                <td style="text-align: right; color: #333;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #333;">Discount :</td>
                                                <td style="text-align: right; color: #333;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                            </tr>
                                            <tr style="background-color: #f2ece6; font-weight: bold; font-size: 14px;">
                                                <td style="padding: 10px;">TOTAL</td>
                                                <td style="text-align: right; padding: 10px;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr>
                        <td>
                            <!-- Invoice Footer -->
                            <table align="left"
                                style="width: 60%; max-width: 100%; width: 100%; margin: 0 auto;
                                        background-image: url('{{ $invoice_footer_image }}');
                                        background-size: cover; background-repeat: no-repeat;
                                        background-position: center; padding: 30px; color: #333; font-family: 'Montserrat'; font-size: 7px;">
                                <tr>
                                    <td style="width: 40%; vertical-align: top;">
                                        <strong style="font-size: 14px; display: block; margin-bottom: 10px; text-decoration: underline white;">More
                                            Information</strong>{!! $company_address !!}<br>
                                        {{ $company_mobile }}
                                    </td>
                                    <td style="width: 30%; vertical-align: top;"></td>
                                    <td style="width: 30%; vertical-align: bottom; text-align: left;">
                                        <div style="margin-bottom: 8px;">{{ $company_email }}</div>
                                        <div>{{ $site_name }}</div>
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