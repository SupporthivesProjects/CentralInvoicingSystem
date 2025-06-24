<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        td, th {
            padding: 8px;
            vertical-align: top;
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">

                    <!-- Header -->
                    <tr>
                        <td>
                            <table width="100%" style="height:200px;">
                                <tr>
                                    <td style="padding:40px; width:50%;">
                                        <img src="{{ $company_logo ?? '/img/logo.png' }}" alt="Logo" style="width:150px;">
                                    </td>
                                    <td style="padding:40px; width:50%;">
                                        <table width="100%">
                                            <tr>
                                                <td colspan="2">
                                                    <h1 style="font-size: 10px;">Invoice To:</h1>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:6.5px; font-weight:600;">Name:</td>
                                                <td style="font-size:6.5px;">{{ $customer_name }}</td>
                                            </tr>
                                            <tr><td colspan="2" style="height:10px;"></td></tr>
                                            <tr>
                                                <td colspan="2">
                                                    <h1 style="font-size: 10px;">Billing From:</h1>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:6.5px; font-weight:600;">Address:</td>
                                                <td style="font-size:6.5px;">{{ $site_name ?? 'Company Name' }}, Kenya</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:6.5px; font-weight:600;">Email:</td>
                                                <td style="font-size:6.5px;">{{ $company_email ?? 'support@writecontent4me.com' }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <table style="margin-left: 40px; margin-top:15px; width: 200px;">
                                <tr>
                                    <td>
                                        <p style="font-size:15px; font-weight: 600;">INVOICE</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:6.5px; font-weight:600;">Date:</td>
                                    <td style="border-bottom: 1px solid black; font-size:6.5px;">{{ $invoice_date }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:6.5px; font-weight:600;">Invoice No:</td>
                                    <td style="border-bottom: 1px solid black; font-size:6.5px;">{{ $invoice_number }}</td>
                                </tr>
                                <tr><td colspan="2" style="height: 40px;"></td></tr>
                                <tr style="background-color: #61ABAD;">
                                    <td colspan="2" style="padding:10px; font-size:10px; font-weight:600;">Grand Total</td>
                                </tr>
                                <tr style="border: 1px solid #DEDFDE; height: 100px;">
                                    <td colspan="2" style="padding:10px; text-align:center; font-size:16px; font-weight:400;">
                                        {{ site_currency_code() . number_format($invoice_amount, 2) }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                    <!-- Content -->
                    <tr>
                        <td style="padding:40px;">
                            <table border="1">
                                <tr style="background:#61ABAD;">
                                    <th colspan="4" style="font-size:10px; font-weight:600;">Item / Service Details</th>
                                </tr>
                                <tr>
                                    <th style="font-size:6.5px;">DESCRIPTION</th>
                                    <th style="font-size:6.5px;">QTY</th>
                                    <th style="font-size:6.5px;">UNIT PRICE</th>
                                    <th style="font-size:6.5px;">AMOUNT</th>
                                </tr>

                                @foreach($products as $product)
                                <tr>
                                    <td style="font-size:8px;">{{ $product->name }}
                                        <br />
                                        @if($product->wordcount)<span class="me-2 badge bg-light text-dark"><strong>Words Count:</strong> {{ $product->wordcount }}</span>@endif
                                        @if($product->quality)<span class="me-2 badge bg-light text-dark"><strong>Quality:</strong> {{ $product->quality }}</span>@endif
                                        @if($product->imagecount)<span class="me-2 badge bg-light text-dark"><strong>Image Count:</strong> {{ $product->imagecount }}</span>@endif
                                        <br />
                                        @if($product->quantity)<span class="me-2 badge bg-light text-dark"><strong>Quantity:</strong> {{ $product->quantity }}</span>@endif
                                        @if($product->turnaround)<span class="me-2 badge bg-light text-dark"><strong>Turnaround Time:</strong> {{ $product->turnaround }}</span>@endif
                                        @if($product->delivery)<span class="me-2 badge bg-light text-dark"><strong>Delivery In:</strong> {{ $product->delivery }}</span>@endif<br>
                                        @if($product->project_title)<span class="me-2 badge bg-light text-dark"><strong>Project Title:</strong> {{ $product->project_title }}</span>@endif
                                        @if($product->subject)<span class="me-2 badge bg-light text-dark"><strong>Subject:</strong> {{ $product->subject }}</span>@endif
                                        @if($product->preferred_voice)<span class="me-2 badge bg-light text-dark"><strong>Preferred Voice:</strong> {{ $product->preferred_voice }}</span>@endif
                                        @if($product->preferred_writing_style)<span class="me-2 badge bg-light text-dark"><strong>Preferred Writing Style:</strong> {{ $product->preferred_writing_style }}</span>@endif
                                        @if($product->brand_name)<span class="me-2 badge bg-light text-dark"><strong>Brand Name:</strong> {{ $product->brand_name }}</span>@endif
                                        @if($product->audience)<span class="me-2 badge bg-light text-dark"><strong>Audience:</strong> {{ $product->audience }}</span>@endif
                                    </td>
                                    <td style="font-size:6.5px;">{{ $product->quantity }}</td>
                                    <td style="font-size:6.5px;">{{ site_currency_code() . number_format($product->unit_price, 2) }}</td>
                                    <td style="font-size:6.5px;">{{ site_currency_code() . number_format($product->unit_price * $product->quantity, 2) }}</td>
                                </tr>
                                @endforeach

                                <tr>
                                    <td colspan="2"></td>
                                    <td style="font-size:6.5px; font-weight:600;">SUB-TOTAL</td>
                                    <td style="font-size:6.5px;">{{ site_currency_code() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td style="font-size:6.5px; font-weight:600;">DISCOUNT</td>
                                    <td style="font-size:6.5px; color:green;">{{ site_currency_code() . number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <p style="font-size: 6.5px; padding-left: 10px;">Thank you for your order.</p>
                                    </td>
                                    <td style="font-size:6.5px; font-weight:600;">GRAND TOTAL</td>
                                    <td style="font-size:6.5px;">{{ site_currency_code() . number_format($invoice_amount, 2) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End -->

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="height:110px;">
                            <p style="font-size:6.5px;">
                                <b>Email:</b> {{ $company_email ?? 'support@writecontent4me.com' }} <br>
                                {{ $site_name ?? 'Intergrated Consortium Company Limited' }}, Kenya <br>
                                {{ $site->site_link ?? 'www.writecontent4me.com' }}
                            </p>
                        </td>
                    </tr>
                    <!-- Footer End -->
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
