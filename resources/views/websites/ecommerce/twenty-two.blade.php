<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        table {
            border-collapse: collapse;
            mso-table-lspace: 0pt; /* Outlook fix */
            mso-table-rspace: 0pt; /* Outlook fix */
            width: 100%; /* Ensure tables take full width of their container */
        }
        td {
            padding: 0; /* Reset default cell padding */
            vertical-align: top;
            line-height: normal; /* Ensure consistent line height */
        }
        p {
            margin: 0;
            padding: 0;
        }
        .main-invoice-wrapper {
            position: relative; /* Establish positioning context for absolutely positioned footer */
            min-height: 800px; /* Adjust this value based on your typical PDF page height to push footer down */
            /* This min-height will push content up and footer down. It's an approximation. */
            /* You might need to experiment with this value for your specific PDF page size (e.g., A4) */
            /* A4 height is approx 842px, considering margins, 800px is a good start. */
            width: 600px; /* Ensure this matches your inner table width */
            margin: 0 auto; /* Center the wrapper */
            background-color: #ffffff; /* Same as the inner table */
           
        }
        .footer-absolute {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%; /* Should span the width of the main invoice wrapper */
            height: 110px; /* Height of your footer image */
            text-align: center;
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td bgcolor="#f2f2f2" style="">
                <div class="main-invoice-wrapper">

                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                        <tr style="width:100%">
                            <td style="padding: 0px; height: 112px; text-align: center;width:100%">
                                <img src="{{ $invoice_header_image }}" alt="Header Image" style="display: inline-block; width: 600px; height: 112px;">
                            </td>
                        </tr>
                    </table>

                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                        <tr>
                            <td style="padding:40px;">

                                <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border: 1px solid rgb(195, 195, 195); border-collapse: collapse;">
                                    <tr style="background: rgb(57, 57, 86);">
                                        <td style="width:50%; height: 28px; padding-left:10px;">
                                            <p style="color: #ffff; font-size: 14px; font-weight: 500; font-family: Arial; line-height: 28px; text-align: left;">
                                                INVOICE No. {{ $invoice_number }}
                                            </p>
                                        </td>
                                        <td style="width:50%; height: 28px; padding-right:10px;">
                                            <p style="color: #ffff; font-size: 14px; font-weight: 500; font-family: Arial; line-height: 28px; text-align:right;">
                                                Date  {{ $invoice_date }}
                                            </p>
                                        </td>
                                    </tr>
                                </table>

                                <table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-top: 40px; border-collapse: collapse;">
                                    <tr>
                                        <td style="width: 50%; border-bottom: 1px solid black; padding-bottom: 5px; text-align: left;">
                                            <p style="color: #577188; font-size: 10px; font-family: Arial; font-weight: 400; text-transform: uppercase;">
                                                Billed To
                                            </p>
                                        </td>
                                        <td style="width: 50%; border-bottom: 1px solid black; padding-bottom: 5px; text-align: left;">
                                            <p style="color: #577188; font-size: 10px; font-family: Arial; font-weight: 400; text-transform: uppercase;">
                                                Billed FROM
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top: 5px; text-align: left; padding-left: 0;">
                                            <p style="color: #595959; font-size: 10px; font-weight: 400; font-family: Arial; text-transform:capitalize;">
                                                {{ $customer_name }}
                                            </p>
                                        </td>
                                        <td style="padding-top: 5px; text-align: left; padding-left: 0;">
                                            <p style="color: #595959; font-size: 10px; font-weight: 400; font-family: Arial; text-transform:capitalize; line-height: 16px;">
                                                Learn New Things Today
                                            </p>
                                            <span style="color:#0070c0; font-size: 10px; font-weight: 400; font-family: Arial; line-height: 16px;">
                                                 {{ $company_email }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>

                                <table cellspacing="0" cellpadding="0" border="1" width="100%" style="border: 1px solid rgb(195, 195, 195); border-collapse: collapse; margin-top:50px;">
                                    <tr style="background: rgb(57, 57, 86); height: 28px;">
                                        <td style="width: 10%; padding-left:10px;">
                                            <p style="color: #ffff; font-size: 10px; font-weight: 500; font-family: Arial; line-height: 28px; text-align: left;">
                                                Quantity
                                            </p>
                                        </td>
                                        <td style="width: 50%; padding-left:10px;">
                                            <p style="color: #ffff; font-size: 10px; font-weight: 500; font-family: Arial; line-height: 28px; text-align: left;">
                                                Description
                                            </p>
                                        </td>
                                        <td style="width: 20%; padding-right:10px; text-align:right;">
                                            <p style="color: #ffff; font-size: 10px; font-weight: 500; font-family: Arial; line-height: 28px;">
                                                Unit Price
                                            </p>
                                        </td>
                                        <td style="width: 20%; padding-right:10px; text-align:right;">
                                            <p style="color: #ffff; font-size: 10px; font-weight: 500; font-family: Arial; line-height: 28px;">
                                                Total
                                            </p>
                                        </td>
                                    </tr>
                                    @foreach($products as $product)
                                    <tr style="height: 28px;">
                                        <td style="padding-left:10px;">
                                            <p style="color:#595959; font-size: 10px; font-weight: 500; font-family: Arial; line-height: 28px; text-align: left;">
                                                {{ $product->quantity ?? 1 }}
                                            </p>
                                        </td>
                                        <td style="padding-left:10px;">
                                            <p style="color:#595959; font-size: 10px; font-weight: 500; font-family: Arial; line-height: 28px; text-align: left;">
                                                {{ $product->name }}
                                            </p>
                                        </td>
                                        <td style="text-align:right;padding-right:10px;">
                                            <p style="color:#595959; font-size: 10px; font-weight: 500; font-family: Arial; line-height: 28px;">
                                                {{ number_format($product->unit_price, 2) }}
                                            </p>
                                        </td>
                                        <td style="text-align:right;padding-right:10px;">
                                            <p style="color:#595959; font-size: 10px; font-weight: 500; font-family: Arial; line-height: 28px;">
                                                {{ number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                    @endforeach
                                    {{-- Placeholder rows to match the original template's height (11 rows total including header) --}}
                                    @for ($i = 0; $i < (max(0, 10 - count($products))); $i++)
                                    <tr style="height: 28px;">
                                        <td style="padding-left:10px;"><p style="color:#595959; font-size: 10px; font-weight: 500; font-family: Arial; line-height: 28px; text-align: left;"></p></td>
                                        <td style="padding-left:10px;"><p style="color:#595959; font-size: 10px; font-weight: 500; font-family: Arial; line-height: 28px; text-align: left;"></p></td>
                                        <td style="text-align:right;padding-right:10px;"><p style="color:#595959; font-size: 10px; font-weight: 500; font-family: Arial; line-height: 28px;"></p></td>
                                        <td style="text-align:right;padding-right:10px;"><p style="color:#595959; font-size: 10px; font-weight: 500; font-family: Arial; line-height: 28px;"></p></td>
                                    </tr>
                                    @endfor
                                    <tr style="height: 28px;">
                                        <td colspan="2" style="border: none;"></td> <td style="text-align:right;padding-right:10px;">
                                            <p style="color:#577188; font-size: 10px; font-weight:500; font-family: Arial; line-height: 28px; text-transform: uppercase;">
                                                Subtotal
                                            </p>
                                        </td>
                                        <td style="text-align:right;padding-right:10px;">
                                            <p style="color:#577188; font-size: 10px; font-weight:500; font-family: Arial; line-height: 28px; text-transform: uppercase;">
                                               {{ number_format(($invoice_amount + $discount_amount), 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr style="height: 28px;">
                                        <td colspan="2" style="border: none;"></td> <td style="text-align:right;padding-right:10px;">
                                            <p style="color:#577188; font-size: 10px; font-weight:500; font-family: Arial; line-height: 28px; text-transform: uppercase;">
                                                Discount
                                            </p>
                                        </td>
                                        <td style="text-align:right;padding-right:10px;">
                                            <p style="color:#577188; font-size: 10px; font-weight:500; font-family: Arial; line-height: 28px; text-transform: uppercase;">
                                               {{ number_format($discount_amount, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr style="height: 28px;">
                                        <td colspan="2" style="border: none;"></td> <td style="text-align:right;padding-right:10px;">
                                            <p style="color:#577188; font-size: 10px; font-weight:500; font-family: Arial; line-height: 28px; text-transform: uppercase;">
                                                Total
                                            </p>
                                        </td>
                                        <td style="text-align:right;padding-right:10px;">
                                            <p style="color:#577188; font-size: 10px; font-weight:500; font-family: Arial; line-height: 28px; text-transform: uppercase;">
                                               {{ number_format($invoice_amount, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <div class="footer-absolute">
                        <img src="{{ $invoice_footer_image }}" alt="Footer Image" style="display: inline-block; width: 600px; height: 110px;">
                    </div>
                </div> </td>
        </tr>
    </table>
</body>
</html>
