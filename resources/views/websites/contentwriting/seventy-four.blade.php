<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
      .footer-fixed {
        position: fixed;
        bottom: -1px;
        left: 0;
        right: 0;
        width: 100%;
        /* background: url('{{ $invoice_footer_image }}') center center no-repeat; */
        /* background-size: cover; */
      }
    </style>
</head>

<body style="margin: 0px; padding: 0;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0; height:100%;">
                <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">

                    <!-- Header -->
                    <tr>
                        <td style="padding: 0; height: 130px;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
                                <tr>
                                    <td style="background: url('{{ $invoice_header_image }}') no-repeat center; background-size: cover; height: 130px; position: relative;">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td align="left" style="padding-left: 69px; padding-top: 10px;">
                                                    <img src="{{ $company_logo }}" alt=""
                                                        style="width: 165px; display: block;">
                                                </td>
                                                <td align="right" style="padding-right: 40px; vertical-align: top;">
                                                    <p style="margin: 0; font-family: Calibri, sans-serif; font-size: 30px; padding-top: 20px;">
                                                        Invoice.
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px; padding-top: 0; background: #ffffff; font-family: Calibri, sans-serif; vertical-align: top; height:100vh;">
                            <table style="width: 100%; font-family: Calibri, sans-serif; border-collapse: collapse;" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td></td>
                                    <td>
                                        <p style="text-align: end; font-size: 9px; font-weight: bold; margin: 0;">
                                            Invoice No. #{{ $invoice_number }}
                                        </p>
                                    </td>
                                </tr>

                                <tr>
                                    <!-- LEFT INFO COLUMN -->
                                    <td style="width: 30%; vertical-align: top; padding: 10px;">
                                        <br><br><br>

                                        <p style="margin: 0; font-weight: bold; text-align: start; font-size: 10px;">DATE</p>
                                        <p style="margin: 0 0 20px 0; font-size: 8px;">{{ $invoice_date }}</p>

                                        <p style="margin: 0; font-weight: bold; border-bottom: 1px solid #ccc; font-size: 10px;">BILLED TO</p>
                                        <p style="margin: 5px 0; font-size: 8px;">
                                            <span style="font-size: 9px; font-weight: bold;">{{ $customer_name }}</span><br><br>
                                            {{ $customer_email }}
                                        </p>

                                        <p style="margin: 0; font-weight: bold; border-bottom: 1px solid #ccc; font-size: 10px;">BILLED FROM</p>
                                        <p style="margin: 5px 0; font-size: 8px;">
                                            <span style="font-size: 9px; font-weight: bold;">{{ $site_name }}</span><br><br>
                                            {!! $company_address !!}<br>
                                            {{ $company_mobile }}<br>
                                            {{ $company_email }}
                                        </p>
                                    </td>

                                    <!-- RIGHT PRODUCT TABLE -->
                                    <td style="vertical-align: top;">
                                        <table style="width: 100%; border-collapse: collapse; font-family: Calibri, sans-serif; font-size: 8px;" cellspacing="0" cellpadding="0" border="0">
                                            <tr style="background-color: orange; color: white; border-bottom: 3px solid white;">
                                                <th style="padding: 10px; text-align: left;">ITEM DESCRIPTION</th>
                                                <th style="padding: 10px;">PRICE</th>
                                                <th style="padding: 10px;">QTY</th>
                                                <th style="padding: 10px; text-align: end;">TOTAL</th>
                                            </tr>

                                            @foreach($products as $product)
                                            <tr style="background-color: #f2f2f2;">
                                                <td style="padding: 10px; vertical-align: top;">
                                                    <strong>{{ $product->name }}</strong>
                                                    <p style="width: 150px; margin: 5px 0 0 0;">
                                                        @if($product->wordcount)<span class="me-2 badge bg-light text-dark"><strong>Words Count:</strong> {{ $product->wordcount }}</span>@endif
                                                        @if($product->quality)<span class="me-2 badge bg-light text-dark"><strong>Quality:</strong> {{ $product->quality }}</span>@endif
                                                        @if($product->imagecount)<span class="me-2 badge bg-light text-dark"><strong>Image Count:</strong> {{ $product->imagecount }}</span>@endif
                                                        <br />
                                                        @if($product->quantity)<span class="me-2 badge bg-light text-dark"><strong>Quantity:</strong> {{ $product->quantity }}</span>@endif
                                                        @if($product->turnaround)<span class="me-2 badge bg-light text-dark"><strong>Turnaround Time:</strong> {{ $product->turnaround }}</span>@endif
                                                        @if($product->delivery)<span class="me-2 badge bg-light text-dark"><strong>Delivery In:</strong> {{ $product->delivery }}</span>@endif
                                                        <br>
                                                        @if($product->project_title)<span class="me-2 badge bg-light text-dark"><strong>Project Title:</strong> {{ $product->project_title }}</span>@endif
                                                        <br>
                                                        @if($product->subject)<span class="me-2 badge bg-light text-dark"><strong>Subject:</strong> {{ $product->subject }}</span>@endif
                                                        @if($product->preferred_voice)<span class="me-2 badge bg-light text-dark"><strong>Preferred Voice:</strong> {{ $product->preferred_voice }}</span>@endif
                                                        @if($product->preferred_writing_style)<span class="me-2 badge bg-light text-dark"><strong>Preferred Writing Style:</strong> {{ $product->preferred_writing_style }}</span>@endif
                                                        @if($product->brand_name)<span class="me-2 badge bg-light text-dark"><strong>Brand Name:</strong> {{ $product->brand_name }}</span>@endif
                                                        @if($product->audience)<span class="me-2 badge bg-light text-dark"><strong>Audience:</strong> {{ $product->audience }}</span>@endif
                                                    </p>
                                                </td>
                                                <td style="padding: 10px; text-align: center; vertical-align: top;">
                                                    {{ site_currency() . number_format($product->unit_price, 2) }}
                                                </td>
                                                <td style="padding: 10px; text-align: center; vertical-align: top;">
                                                    {{ $product->quantity }}
                                                </td>
                                                <td style="padding: 10px; text-align: end; vertical-align: top;">
                                                    {{ site_currency() . number_format($product->unit_price * $product->quantity, 2) }}
                                                </td>
                                            </tr>
                                            <tr style="background-color: #ffffff;">
                                                <td colspan="4" style="height: 8px;"></td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <table style="width: 100%; margin-top: 20px; font-family: Calibri, sans-serif;" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td style="width: 30%;"></td>
                                    <td style="width: 70%;">
                                        <table style="width: 100%; border-collapse: collapse;" cellspacing="0" cellpadding="0" border="0">
                                            <tr style="font-size: 8px;">
                                                <td style="padding: 5px; text-align: right;">Subtotal.</td>
                                                <td style="padding: 5px; text-align: right; width: 68px;">
                                                    {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                                </td>
                                            </tr>
                                            <tr style="font-size: 8px;">
                                                <td style="padding: 5px; text-align: right;">Discount</td>
                                                <td style="padding: 5px; text-align: right;">
                                                    {{ site_currency() . number_format($discount_amount, 2) }}
                                                </td>
                                            </tr>
                                            <tr style="border-top: 1px solid gray; font-weight: bold; font-size: 10px;">
                                                <td style="padding: 5px; text-align: right;">Total.</td>
                                                <td style="padding: 5px; text-align: right;">
                                                    {{ site_currency() . number_format($invoice_amount, 2) }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr style="height:100%;">
                        <td>
                            <div class="footer-fixed">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0"
                                style="border-collapse: collapse; background: url('{{ $invoice_footer_image }}') no-repeat center; background-size: cover; height: 100px; font-family: Calibri, sans-serif;">
                                <tr>
                                    <td align="center" style="padding: 20px 10px; width: 33.33%; vertical-align: top;">
                                        <p style="font-size: 10px; font-weight: bold; margin: 0;">
                                            PHONE<br>
                                            <span style="font-size: 8px; font-weight: normal;">{{ $company_mobile }}</span>
                                        </p>
                                    </td>
                                    <td align="center" style="padding: 20px 10px; width: 33.33%; vertical-align: top;">
                                        <p style="font-size: 10px; font-weight: bold; margin: 0;">
                                            EMAIL<br>
                                            <span style="font-size: 8px; font-weight: normal;">{{ $company_email }}</span>
                                        </p>
                                    </td>
                                    <td align="center" style="padding: 20px 10px; width: 33.33%; vertical-align: top;">
                                        <p style="font-size: 10px; font-weight: bold; margin: 0;">
                                            ADDRESS<br>
                                            <span style="font-size: 8px; font-weight: normal;">{!! $company_address !!}</span>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <!-- Footer End -->

                </table>
            </td>
        </tr>
    </table>
</body>

</html>