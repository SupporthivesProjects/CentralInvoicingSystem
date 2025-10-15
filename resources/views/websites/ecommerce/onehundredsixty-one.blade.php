<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Invoice</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background: #fff;">
    <!-- Main Wrapper Table -->
    <table width="90%" cellpadding="0" cellspacing="0" style="background: #fff; margin: auto;">
        <!-- Header Row with Background -->
        <tr>
            <td colspan="2" 
                style="
                    background: url('{{ $invoice_header_image }}') no-repeat center; 
                    background-size: contain; 
                    height: 165px;">
            </td>
        </tr>
        <!-- Invoice Content Row -->
        <tr>
            <td align="center" colspan="2">
                <table width="820" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                    <tr>
                        <!-- Left Column -->
                        <td width="42%" valign="top"
                            style="padding: 50px 40px 30px; border-right: 1px solid #ccc; font-size: 14px; line-height: 1.6;">
                            <div style="margin-bottom: 28px;">
                                <p style="margin: 0; font-size: 11px; color: #888; letter-spacing: 1px;">DATE</p>
                                <p style="margin: 5px 0 0; color: #000;">{{ $invoice_date }}</p>
                            </div>
                            <div style="margin-bottom: 28px;">
                                <p style="margin: 0; font-size: 11px; color: #888; letter-spacing: 1px;">BILLED TO</p>
                                <p style="margin: 5px 0 0; color: #000;">
                                    <strong>{{ $customer_name }}</strong><br>
                                    {{ $customer_mobile }}<br>
                                    {{ $customer_email }}
                                </p>
                            </div>
                            <div style="margin-bottom: 28px;">
                                <p style="margin: 0; color: #000; font-size: 11px; color: #888; letter-spacing: 1px;">BILLED FROM</p>
                                <p style="margin: 5px 0 0;">
                                    <strong>{{ $site_name }}</strong><br>
                                        {!! $company_address !!}
                                </p>
                            </div>
                            <div>
                                <p style="margin: 0; font-size: 11px; color: #888; letter-spacing: 1px;">CONTACT</p>
                                <p style="margin: 5px 0 0; color: #000;">
                                    {{ $company_mobile }}<br>
                                    {{ $company_email }}
                                </p>
                            </div>
                        </td>
                        <!-- Right Column -->
                        <td width="58%" valign="top" style="padding: 50px 40px 30px; font-size: 14px;">
                            <!-- Invoice Heading -->
                            <div style="text-align: right; margin-bottom: 10px;">
                                <h1 style="margin: 0; font-size: 36px; font-weight: bold; color: #000;">INVOICE.</h1>
                                <p style="margin-top: 4px; color: #555;">
                                    <strong>Invoice No.</strong> #{{ $invoice_number }}
                                </p>
                            </div>
                            <!-- Table Header -->
                            <div style="min-height: 671px !important;">
                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="margin-top: 30px; font-size: 13px; border-collapse: collapse;">
                                <thead>
                                    <tr style="background-color: #000; color: #fff; font-weight: bold;">
                                        <th align="left" style="border-bottom: 1px solid #ccc;">ITEM DESCRIPTION</th>
                                        <th align="right" style="border-bottom: 1px solid #ccc;">PRICE</th>
                                        <th align="right" style="border-bottom: 1px solid #ccc;">QTY</th>
                                        <th align="right" style="border-bottom: 1px solid #ccc;">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr style="border-bottom: 1px solid #ddd;">
                                        <td style="padding: 12px 8px;">
                                            <strong>{{ $product->name }}</strong>
                                        </td>
                                        <td align="right">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                        <td align="right">1</td>
                                        <td align="right">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Totals -->
                            <table width="100%" cellpadding="8" cellspacing="0"
                                style="margin-top: 30px; font-size: 14px;">
                                <tr>
                                    <td align="right" style="color: #000;">Subtotal.</td>
                                    <td align="right" width="140">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td align="right" style="color: #000;">Discount</td>
                                    <td align="right">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr style="font-weight: bold;">
                                    <td align="right" style="color: #000;">Total.</td>
                                    <td align="right">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                </tr>
                            </table>
                            </div>
                            <!-- Footer Space -->
                            <div style="height: 120px; background-color: transparent;"></div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2"
                style="position: relative; background: url('{{ $invoice_footer_image }}') no-repeat center center; background-size: cover; height: 30px;">
                <!-- Optional content like logo/title can go here -->
            </td>
        </tr>
    </table>
</body>
</html>
