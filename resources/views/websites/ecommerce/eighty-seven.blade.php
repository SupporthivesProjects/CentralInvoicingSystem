<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
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
                            <table width="100%" cellpadding="20" cellspacing="0"
                                style="font-family: 'Inter'; background: url('{{ $invoice_image1 }}') no-repeat right top; background-size: cover; background-position: center; padding: 40px 40px 0px 40px;">
                                <tr>
                                    
                                    <!-- Left Side: Logo & Contact -->
                                    <td width="60%" style="vertical-align: top; position: relative;">
                                        <img src="{{ $invoice_header_image }}" alt=""
                                            style="position: absolute; height: 297px; top: -39px; left: -38px;">
                                        <img src="{{ $company_logo }}" alt="Dusk Digitals"
                                            style="height: 60px;"><br><br><br>

                                        <p style="margin: 5px 0; font-size: 8px;">
                                            <span style="font-size: 9px;">Invoice To</span><br>
                                            <span style="font-size: 10px;"><strong>{{ $customer_name }}</strong></span><br><br>
                                            <strong> {{ $customer_email  }}</strong>
                                        </p>
                                    </td>

                                    <!-- Right Side: Invoice Info -->
                                    <td width="40%" style="text-align: right; vertical-align: bottom">
                                        <h1 style="font-size: 25px; letter-spacing: 3px; margin-bottom: 0px;">INVOICE
                                        </h1>
                                        <table style="font-size: 8px; float: right;">
                                            <tr>
                                                <td style="padding: 4px 10px;">Invoice Date</td>
                                                <td style="padding: 4px 10px;">: <strong>{{ $invoice_date  }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 4px 10px;">Issue Date</td>
                                                <td style="padding: 4px 10px;">: <strong>{{ $invoice_date  }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 4px 10px; border-bottom: 1px solid black;">Invoice
                                                    No.</td>
                                                <td style="padding: 4px 10px;border-bottom: 1px solid black;">:
                                                    <strong>{{ $invoice_number }}</strong></td>
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
                            style="padding:40px;padding-top:0px;background:#ffffff; background-repeat: no-repeat;background-position: center;background-size: cover;height:444px; font-family: 'Yu Gothic';">
                            <br>
                            <div style="min-height: 600px !important;">
                                <table width="100%" cellpadding="10" cellspacing="0"
                                    style="border-collapse: collapse; font-family: 'Inter'; ">
                                    <!-- Table Header -->
                                    <tr
                                        style="background-color: #53AAA4; color: #fff; font-weight: bold; text-align: left; font-size: 11px;">
                                        <td style="border: 1px solid #ccc;">Item Description</td>
                                        <td style="border: 1px solid #ccc;">Unit Price</td>
                                        <td style="border: 1px solid #ccc;">Qty</td>
                                        <td align="right" style="border: 1px solid #ccc;">Amount</td>
                                    </tr>

                                    @foreach($products as $product)
                                    <tr style="border-bottom: 1px solid #ccc; font-size: 9px; font-weight: bold;">
                                        <td><strong>{{ $product->category_name }}</strong><br> <span
                                                style="font-size: 8px; font-weight: normal;">{{ $product->name }}</span></td>
                                        <td>{{ site_currency() }} {{  number_format($product->unit_price, 2) }}</td>
                                        <td>01</td>
                                        <td align="right">{{ site_currency() }} {{  number_format($product->unit_price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </table>

                                <!-- Totals -->
                                <table align="right" width="100%" cellpadding="8" cellspacing="0"
                                    style="width: 40%; font-family: 'Inter'; font-size: 9px; margin-top: 20px; font-weight: bold;">
                                    <tr>

                                        <td align="left" style="font-weight: bold;">Sub Total:</td>
                                        <td align="right">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</td>
                                    </tr>
                                    <tr>

                                        <td align="left" style="font-weight: bold;">Discount:</td>
                                        <td align="right">{{ site_currency() }} {{ number_format($discount_amount, 2) }}</td>
                                    </tr>
                                    <tr style=" color: #fff; font-weight: bold; font-size: 11px;">

                                        <td align="left" style="padding: 10px; background-color: #53AAA4;">Grand Total</td>
                                        <td align="right" style="padding: 10px; background-color: #53AAA4;"> {{ site_currency() }} {{ number_format($invoice_amount, 2) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                   
                    <tr>
                        <td>
                            <table width="100%" cellpadding="20" cellspacing="0" style="font-family: 'Inter'; font-size: 8px; background: url('{{ $invoice_footer_image }}'); background-position: top; height: 115px;">
                                <tr>
                                    <td align="right" width="50%" style="vertical-align: top;">
                                        <table cellpadding="0" cellspacing="0" style="font-family: 'Inter'; font-size: 8px;">
                                            <tr>
                                                <td style="padding-right: 10px;">
                                                    <img src="{{ $invoice_image2 }}" alt="email icon"
                                                        style="width: 24px; vertical-align: middle;">
                                                </td>
                                                <td style="color: #3b3b3b;">
                                                    {{ $company_mobile }}<br>
                                                    {{ $company_email }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>

                                    <!-- Right Location Info -->
                                    <td align="left" width="50%" style="vertical-align: top;">
                                        <table cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding-right: 10px;">
                                                    <img src="{{ $invoice_image3 }}" alt="location icon"
                                                        style="width: 24px; vertical-align: middle;">
                                                </td>
                                                <td style="color: #3b3b3b;">
                                                    {!! $company_address !!}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <!-- Decorative Shapes -->
                                <tr>
                                    <td colspan="2" style="padding: 0; position: relative;">
                                        <img src="{{ $invoice_footer_image }}" alt="footer design" style=" width: 400px; position: absolute; bottom: 0%; right: 0px;">
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