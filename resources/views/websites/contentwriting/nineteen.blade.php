<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        /* General Styles for DOMPDF */
        body {
            font-family: Arial, sans-serif; /* Fallback to Arial */
            margin: 0;
            padding: 0;
            -webkit-box-sizing: border-box; /* Good practice, though less critical for DOMPDF */
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        table {
            width: 100%;
            border-collapse: collapse; /* Essential for proper borders */
            /* Ensure no default cell spacing */
            border-spacing: 0;
            margin: 0;
            padding: 0;
        }
        /* Specific styling for the main content wrapper table */
        .main-wrapper {
            background-color: #f2f2f2;
            padding: 20px 0; /* Vertical padding around the main content */
        }
        .invoice-container {
            width: 600px; /* Fixed width as per your original design */
            margin: 0 auto; /* Center the container */
            background-color: #ffffff;
            border-collapse: collapse;
            /* box-shadow is often poorly rendered or ignored by DOMPDF.
               If you need a shadow, it might have to be part of the header image or
               a more subtle border. */
            /* box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); */
        }
        /* Header Image Styling */
        .header-image-cell {
            padding: 0px;
            text-align: center; /* To center the image if it's smaller than the cell */
        }
        .header-image {
            width: 100%; /* Make image fill the width of its container */
            height: 112px; /* Fixed height as per your design */
            display: block; /* Remove extra space below image */
        }

        /* Content Padding */
        .content-padding {
            padding: 40px 80px;
        }

        /* Text Styles (applying to paragraphs within tables for consistency) */
        .text-black { color: black; }
        .font-arial { font-family: Arial; }
        .font-size-10 { font-size: 10px; }
        .font-size-11 { font-size: 11px; }
        .font-size-12 { font-size: 12px; }
        .font-weight-400 { font-weight: 400; }
        .font-weight-500 { font-weight: 500; }
        .font-weight-700 { font-weight: 700; }
        .margin-0 { margin: 0px; }
        .line-height-16 { line-height: 16px; }
        .line-height-24 { line-height: 24px; }
        .line-height-28 { line-height: 28px; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-uppercase { text-transform: uppercase; }
        .text-capitalize { text-transform: capitalize; }

        /* Table Specific Styles */
        .data-table {
            border: 1px solid rgb(195, 195, 195);
            margin-top: 50px;
        }
        .data-table th, .data-table td {
            border: 1px solid rgb(195, 195, 195);
            padding: 8px 10px; /* Consistent padding for cells */
            vertical-align: top; /* Important for multi-line descriptions */
            word-wrap: break-word; /* Helps with long text in description */
            /* box-sizing: border-box; Not truly effective for DOMPDF on cells */
        }
        .data-table thead tr {
            background-color: #E2E2E2; /* Lighter grey for header, matches screenshot 2 */
        }
        .data-table tbody tr.odd-row {
            background-color: #f2f2f2;
        }
        .data-table tfoot tr {
            background-color: #F2F2F2;
        }
        .data-table tfoot tr.no-bg {
            background-color: #ffffff; /* Override background for specific footer rows */
        }
        .data-table .qty-col { width: 15%; text-align: center; }
        .data-table .desc-col { width: 65%; text-align: left; }
        .data-table .total-col { width: 20%; text-align: right; } /* Adjusted to right for numbers */

        /* Footer Address */
        .footer-address {
            text-align: center;
            padding: 20px 0;
        }
        .footer-address p {
            font-size: 10px;
            color: #000000;
            line-height: 16px;
            margin: 0;
            font-family: Arial;
        }
    </style>
</head>

<body>
    <table class="main-wrapper" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <table class="invoice-container" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td class="header-image-cell">
                            {{-- Make sure $invoice_header_image is the full banner as seen in Screenshot 2 --}}
                            <img src="{{ $invoice_header_image }}" alt="Company Logo" class="header-image">
                        </td>
                    </tr>
                    <tr>
                        <td class="content-padding">
                            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td style="width: 50%;">
                                        <p class="text-black font-size-12 font-weight-500 font-arial margin-0 line-height-24 text-left">
                                            <b>Date:</b> {{ $invoice_date }}
                                        </p>
                                    </td>
                                    <td style="width: 50%;">
                                        <p class="text-black font-size-12 font-weight-500 font-arial margin-0 line-height-28 text-right">
                                            <b>Invoice Number:</b> # {{ $invoice_number }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <table style="margin-top:30px;" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td style="width: 50%; vertical-align: top;">
                                        <p class="text-black font-size-12 font-arial font-weight-700 margin-0 text-left text-uppercase">
                                            Billed From:
                                        </p>
                                        @if (!empty($site_name))
                                            <p class="text-black font-size-11 font-arial font-weight-400 margin-0 text-capitalize">
                                                {{ $site_name }}
                                            </p>
                                        @endif
                                        @if (!empty($site->site_link))
                                            <p class="text-black font-size-11 font-arial font-weight-400 margin-0 text-capitalize">
                                                {{ $site->site_link }}
                                            </p>
                                        @endif
                                        @if (!empty($company_email))
                                            <p class="text-black font-size-11 font-arial font-weight-400 margin-0 text-capitalize">
                                                {{ $company_email }}
                                            </p>
                                        @endif
                                    </td>
                                    <td style="width: 50%; vertical-align: top;">
                                        <p class="text-black font-size-12 font-arial font-weight-700 margin-0 text-right text-uppercase">
                                            Billed To:
                                        </p>
                                        <p class="text-black font-size-11 font-arial font-weight-400 margin-0 text-right text-capitalize line-height-16">
                                            {{ $customer_name }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <table class="data-table" cellspacing="0" cellpadding="0" border="0">
                                <thead>
                                    <tr>
                                        <td class="qty-col">
                                            <p class="text-black font-size-12 font-weight-700 font-arial margin-0 line-height-28 text-center">
                                                Qty
                                            </p>
                                        </td>
                                        <td class="desc-col">
                                            <p class="text-black font-size-12 font-weight-700 font-arial margin-0 line-height-28 text-center">
                                                Description
                                            </p>
                                        </td>
                                        <td class="total-col">
                                            <p class="text-black font-size-12 font-weight-700 font-arial margin-0 line-height-28 text-right">
                                                Total
                                            </p>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr class="{{ $loop->odd ? 'odd-row' : '' }}">
                                            <td class="qty-col">
                                                <p class="text-black font-size-11 font-weight-500 font-arial margin-0 text-center">
                                                    {{ $product->quantity }}
                                                </p>
                                            </td>
                                            <td class="desc-col">
                                                <p class="text-black font-size-11 font-weight-500 font-arial margin-0 line-height-16 text-left">
                                                    <strong>{{ $product->name }}</strong><br>
                                                    @if ($product->wordcount)
                                                        Words Count: {{ $product->wordcount }}<br>
                                                    @endif
                                                    @if ($product->quality)
                                                        Quality: {{ $product->quality }}<br>
                                                    @endif
                                                    @if ($product->imagecount)
                                                        Image Count: {{ $product->imagecount }}<br>
                                                    @endif
                                                    @if ($product->turnaround)
                                                        Turnaround Time: {{ $product->turnaround }}<br>
                                                    @endif
                                                    @if ($product->delivery)
                                                        Delivery In: {{ $product->delivery }}<br>
                                                    @endif
                                                    @if ($product->project_title)
                                                        Project Title: {{ $product->project_title }}<br>
                                                    @endif
                                                    @if ($product->subject)
                                                        Subject: {{ $product->subject }}<br>
                                                    @endif
                                                    @if ($product->preferred_voice)
                                                        Preferred Voice: {{ $product->preferred_voice }}<br>
                                                    @endif
                                                    @if ($product->preferred_writing_style)
                                                        Preferred Writing Style: {{ $product->preferred_writing_style }}<br>
                                                    @endif
                                                    @if ($product->brand_name)
                                                        Brand Name: {{ $product->brand_name }}<br>
                                                    @endif
                                                    @if ($product->audience)
                                                        Audience: {{ $product->audience }}<br>
                                                    @endif
                                                    @if ($product->reference_link)
                                                        Reference link: <a href="{{ $product->reference_link }}"
                                                            target="_blank">{{ $product->reference_link }}</a><br>
                                                    @endif
                                                    @if ($product->note)
                                                        Additional Note: {{ $product->note }}
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="total-col">
                                                <p class="text-black font-size-11 font-weight-500 font-arial margin-0 text-right">
                                                    {{ site_currency() . number_format($product->unit_price, 2) }}
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="desc-col">
                                            <p class="text-black font-size-10 font-weight-700 font-arial margin-0 line-height-28 text-right text-uppercase">
                                                Subtotal
                                            </p>
                                        </td>
                                        <td class="total-col">
                                            <p class="text-black font-size-10 font-weight-700 font-arial margin-0 line-height-28 text-right text-uppercase">
                                                {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr class="no-bg"> {{-- Added class to override background if needed --}}
                                        <td colspan="2" class="desc-col">
                                            <p class="text-black font-size-10 font-weight-700 font-arial margin-0 line-height-28 text-right text-uppercase">
                                                Discount
                                            </p>
                                        </td>
                                        <td class="total-col">
                                            <p class="text-black font-size-10 font-weight-700 font-arial margin-0 line-height-28 text-right text-uppercase">
                                                {{ site_currency() . number_format($discount_amount, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="desc-col">
                                            <p class="text-black font-size-10 font-weight-700 font-arial margin-0 line-height-28 text-right text-uppercase">
                                                Total
                                            </p>
                                        </td>
                                        <td class="total-col">
                                            <p class="text-black font-size-10 font-weight-700 font-arial margin-0 line-height-28 text-right text-uppercase">
                                                {{ site_currency() . number_format($invoice_amount, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="footer-address">
                            <p>
                                @if (!empty($site_name))
                                    {{ $site_name }}<br>
                                @endif
                                @if (!empty($site->site_link))
                                    {{ $site->site_link }}<br>
                                @endif
                                @if (!empty($company_email))
                                    {{ $company_email }}
                                @endif
                                {{-- Assuming you want to add the address from screenshot 2 here --}}
                                @if (!empty($company_address))
                                    <br>{{ $company_address }}
                                @endif
                            </p>
                        </td>
                    </tr>
                    </table>
            </td>
        </tr>
    </table>
</body>

</html>
