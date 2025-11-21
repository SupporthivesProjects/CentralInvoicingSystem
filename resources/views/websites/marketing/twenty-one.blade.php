<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>{{ $site_name ?? 'Your Company' }} - Invoice #{{ $invoice_number ?? 'N/A' }}</title>
    <style>
        /* General Styles for DOMPDF */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff; /* Changed body background to white */
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        /* Main wrapper table to center the content */
        .main-wrapper {
            background-color: #f2f2f2; /* This gives the outer gray border */
            padding: 20px 0; /* Vertical padding */
        }
        /* Invoice container */
        .invoice-container {
            width: 100%;
            margin: 0 auto;
            background-color: #ffffff; /* This is the main white area */
            border-collapse: collapse;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin: 0;
            padding: 0;
        }
        td {
            vertical-align: top; /* Default vertical alignment for consistency */
        }

        /* Header Image */
        .header-image-cell {
            padding: 0;
            text-align: center;
        }
        .header-image {
            width: 100%;
            height: 150px;
            display: block;
            margin: 0 auto;
        }

        /* Content Padding (main content area inside the white box) */
        .content-padding {
            padding: 40px;
            background-color: #ffffff;
        }

        /* Text Styles */
        .text-black { color: #000000; }
        .font-arial { font-family: Arial, sans-serif; }
        .font-size-8 { font-size: 8px; }
        .font-size-9 { font-size: 9px; }
        .font-size-10 { font-size: 10px; }
        .font-size-11 { font-size: 11px; }
        .font-size-12 { font-size: 12px; }
        .font-size-28 { font-size: 28px; }
        .font-weight-400 { font-weight: 400; }
        .font-weight-500 { font-weight: 500; }
        .font-weight-700 { font-weight: 700; }
        .margin-0 { margin: 0; }
        .line-height-16 { line-height: 16px; }
        .line-height-28 { line-height: 28px; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-uppercase { text-transform: uppercase; }
        .text-capitalize { text-transform: capitalize; }
        .link-color { color: #0563c1; text-decoration: none; }

        /* Header Date/Invoice Table */
        .header-info-table td {
            width: 50%;
            vertical-align: top;
        }
        .header-info-table p {
            margin: 0;
            line-height: 16px;
        }

        /* Billed From/To Table */
        .billed-info-table {
            margin-top: 20px;
        }
        .billed-info-table td {
            width: 50%;
            vertical-align: top;
            padding-bottom: 5px;
        }
        .billed-info-table p {
            margin: 0;
            line-height: 16px;
        }
        .contact-info-cell {
             padding-top: 20px;
        }

        /* Product Table */
        .product-table {
            border: 1px solid rgb(195, 195, 195);
            margin-top: 20px;
            text-align: center;
        }
        .product-table th,
        .product-table td {
            border: 1px solid rgb(195, 195, 195);
            padding: 8px 10px;
            vertical-align: top;
            word-wrap: break-word;
        }
        .product-table thead tr {
            background-color: #f6f6f2;
            height: 28px;
        }
        .product-table th p {
            margin: 0;
            line-height: 1;
            padding: 0;
        }
        .product-table tbody tr {
            height: 28px;
        }
        .product-table tbody p {
            margin: 0;
            line-height: 1.2;
            padding: 0;
        }
        .product-table tfoot tr {
            height: 28px;
            background-color: #ffffff;
        }
        .product-table tfoot p {
            margin: 0;
            line-height: 1;
            padding: 0;
        }

        /* Specific column widths and alignment for product table */
        .col-item { width: 100px; text-align: left; }
        .col-desc { width: 250px; text-align: left; }
        .col-qty { width: 50px; text-align: left; }
        .col-unit-price { width: 70px; text-align: right; }
        .col-total { width: 70px; text-align: right; }

        /* Footer styling */
        .footer-cell {
            position:absolute;
            display:flex;
            justify-content:center;
            align-items:center;
            bottom:0px;
            text-align: center;
            padding:0 45%;
        }
        .footer-image {
            height: 70px;
            display: block;
            margin: 10px;
            
        }

        /* Spacer to push footer down (important for DOMPDF) */
        .spacer-row {
            height: 150px; /* Adjust this value as needed to push the footer down */
            background-color: #ffffff; /* Ensure this spacer is white */
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
                            <img src="{{ $invoice_header_image ?? 'img/header.png' }}" alt="Invoice Header" class="header-image">
                        </td>
                    </tr>
                    <tr>
                        <td class="content-padding">
                            <table cellspacing="0" cellpadding="0" border="0" width="100%" class="header-info-table">
                                <tr>
                                    <td>
                                        <table cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td>
                                                    <p class="text-black font-size-10 font-weight-500 font-arial margin-0 text-left">
                                                        <b>Date:</b> {{ $invoice_date ?? 'N/A' }}
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p class="text-black font-size-10 font-weight-500 font-arial margin-0 text-left">
                                                        <b>Invoice Number:</b> #{{ $invoice_number ?? 'N/A' }}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <p class="text-black font-size-28 font-weight-700 font-arial margin-0 line-height-28 text-right">
                                            INVOICE
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <table class="billed-info-table" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td>
                                     <p class="text-black font-size-12 font-arial font-weight-400 margin-0">
                                            Billed From :
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-black font-size-12 font-arial font-weight-400 margin-0 text-right">
                                            Billed To :
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-black font-size-12 font-arial font-weight-400 margin-0 text-capitalize">
                                            {{ $site_name ?? 'The Brand Monkey' }}
                                        </p>
                                    </td>
                                    <td style="text-align: right;">
                                        <p class="text-black font-size-12 font-arial font-weight-400 margin-0 text-capitalize line-height-16">
                                            {{ $customer_name ?? 'Customer Name' }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="contact-info-cell">
                                        <table cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td>
                                                    <p class="text-black font-size-10 font-weight-500 font-arial margin-0 text-left">
                                                        <b>Email:</b> {{ $company_email ?? 'support@thebrandmonkey.com' }}
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p class="text-black font-size-10 font-weight-500 font-arial margin-0 text-left">
                                                        <b>Website: </b><a href="https://thebrandmonkey.com" class="link-color">thebrandmonkey.com</a>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p class="text-black font-size-10 font-weight-500 font-arial margin-0 text-left">
                                                        Powered by Eromnet Hong Kong
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <table class="product-table" cellspacing="0" cellpadding="0" border="0">
                                <thead>
                                    <tr>
                                        <td class="col-item">
                                            <p class="font-size-11 font-weight-700 font-arial text-black text-left">Item</p>
                                        </td>
                                        <td class="col-desc">
                                            <p class="font-size-11 font-weight-700 font-arial text-black text-left">Description</p>
                                        </td>
                                        <td class="col-qty">
                                            <p class="font-size-11 font-weight-700 font-arial text-black text-left">Quantity</p>
                                        </td>
                                        <td class="col-unit-price">
                                            <p class="font-size-11 font-weight-700 font-arial text-black text-right">Unit Price</p>
                                        </td>
                                        <td class="col-total">
                                            <p class="font-size-11 font-weight-700 font-arial text-black text-right">Total</p>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                        <tr>
                                            <td class="col-item">
                                                <p class="font-size-10 font-weight-500 font-arial text-black text-left">{{ $product->name ?? '-' }}</p>
                                            </td>
                                            <td class="col-desc">
                                                <p class="font-size-10 font-weight-500 font-arial text-black text-left">{{ $product->description ?? $product->subscription ?? '-' }}</p>
                                            </td>
                                            <td class="col-qty">
                                                <p class="font-size-10 font-weight-500 font-arial text-black text-left">{{ $product->quantity ?? 1 }}</p>
                                            </td>
                                            <td class="col-unit-price">
                                                <p class="font-size-10 font-weight-500 font-arial text-black text-right">
                                                    {{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}
                                                </p>
                                            </td>
                                            <td class="col-total">
                                                <p class="font-size-8 font-weight-500 font-arial text-black text-right">
                                                    {{ site_currency() }} {{ number_format(($product->quantity ?? 1) * ($product->unit_price ?? 0), 2) }}
                                                </p>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center font-size-10" style="padding: 15px;">No products found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" style="border: none; text-align: right; padding-right: 10px;">
                                            <p class="font-size-9 font-weight-500 font-arial text-black text-uppercase">Subtotal</p>
                                        </td>
                                        <td colspan="2" class="col-total" style="padding-left: 0;">
                                            <p class="font-size-9 font-weight-500 font-arial text-black text-right text-uppercase">
                                                {{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="border: none; text-align: right; padding-right: 10px;">
                                            <p class="font-size-9 font-weight-500 font-arial text-black text-uppercase">Discount</p>
                                        </td>
                                        <td colspan="2" class="col-total" style="padding-left: 0;">
                                            <p class="font-size-9 font-weight-500 font-arial text-black text-right text-uppercase">
                                                {{ site_currency() }} {{ number_format($discount_amount ?? 0, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="border: none; text-align: right; padding-right: 10px;">
                                            <p class="font-size-9 font-weight-500 font-arial text-black text-uppercase">Grand Total</p>
                                        </td>
                                        <td colspan="2" class="col-total" style="padding-left: 0;">
                                            <p class="font-size-9 font-weight-500 font-arial text-black text-right text-uppercase">
                                                {{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>

                    {{-- Spacer row with white background to ensure full white area above footer --}}
                    <tr>
                        <td class="spacer-row">&nbsp;</td>
                    </tr>

                    <tr>
                        <td class="footer-cell">
                            <img src="{{ $invoice_footer_image ?? 'img/footer.png' }}" alt="Footer Logo" class="footer-image">
                        </td>
                    </tr>
                    </table>
            </td>
        </tr>
    </table>
</body>
</html>
