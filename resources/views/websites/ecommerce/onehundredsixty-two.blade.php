<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    
                    <!-- Header -->
                    <tr style="background: url('{{ $invoice_header_image }}'); background-repeat: no-repeat; background-size: cover; background-position: center; height: 259px;">
                        <td>
                            <img src="{{ $company_logo }}" alt="" style="display: block; height: 40px; margin-left: auto; margin-right: auto;">
                            <h1 style="text-align: center; margin-bottom: 0; font-family: Arial; color: #fff;">INVOICE</h1>
                            <div style="height: 1px; width: 90%; background-color: #C4D5E9; margin-left: auto; margin-right: auto;"></div>
                            <div style="display: flex; flex-direction: row; justify-content: space-between; padding: 0px 50px;">
                                <div>
                                    <h1 style="font-family: Arial, sans-serif; font-size: 14px; color: #C4D5E9; margin: 0; margin-top: 20px;">Date:</h1>
                                    <p style="font-family: Arial, sans-serif; font-size: 9px; color: #fff; margin: 0;">{{ $invoice_date }}</p>
                                    <h1 style="font-family: Arial, sans-serif; font-size: 14px; color: #C4D5E9; margin: 0; margin-top: 10px;">Invoice #</h1>
                                    <p style="font-family: Arial, sans-serif; font-size: 9px; color: #fff; margin: 0;">{{ $invoice_number }}</p>
                                </div>
                                <div>
                                    <h1 style="font-family: Arial, sans-serif; font-size: 14px; color: #C4D5E9; margin: 0; margin-top: 20px;">To:</h1>
                                    <p style="font-family: Arial, sans-serif; font-size: 9px; color: #fff; margin: 0;">
                                        {{ $customer_name }}<br>{{ $customer_email }}
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <!-- Header End -->

                    <!-- Content -->
                    <tr>
                        <td style="padding: 50px;">
                            <div style="min-height: 500px !important;">
                                <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 9px;">
                                    <thead>
                                        <tr>
                                            <th style="border: 1px solid #3366cc; padding: 8px; text-align: left;">QTY</th>
                                            <th style="border: 1px solid #3366cc; padding: 8px; text-align: left; width: 272px;">ITEM DESCRIPTION</th>
                                            <th style="border: 1px solid #3366cc; padding: 8px; text-align: right;">UNIT PRICE</th>
                                            <th style="border: 1px solid #3366cc; padding: 8px; text-align: right;">LINE TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td style="border: 1px solid #3366cc; padding: 8px;">1</td>
                                                <td style="border: 1px solid #3366cc; padding: 8px;">{{ $product->name }}</td>
                                                <td style="border: 1px solid #3366cc; padding: 8px; text-align: right;">{{ site_currency() . number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}</td>
                                                <td style="border: 1px solid #3366cc; padding: 8px; text-align: right;">{{ site_currency() . number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2" style="border: 0; padding: 8px;"></td>
                                            <td style="border: 0; padding: 8px; font-weight: bold; text-align: left;">Subtotal</td>
                                            <td style="border: 1px solid #3366cc; padding: 8px; text-align: right; background-color: #C4D5E9; font-weight: bold;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="border: 0; padding: 8px;"></td>
                                            <td style="border: 0; padding: 8px; font-weight: bold; text-align: left;">Discount</td>
                                            <td style="border: 1px solid #3366cc; padding: 8px; text-align: right; background-color: #C4D5E9; font-weight: bold;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="border: 0; padding: 8px;"></td>
                                            <td style="border: 0; padding: 8px; font-weight: bold; text-align: left;">Total</td>
                                            <td style="border: 1px solid #3366cc; padding: 8px; text-align: right; background-color: #C4D5E9; font-weight: bold;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <!-- Content End -->

                    <!-- Footer -->
                    <tr style="height: 60px;">
                        <td style="text-align: center; padding: 20px;">
                            <p style="font-family: Arial; font-size: 8px; font-weight: bold; margin: 0; color: #1D3451;">Make all checks payable to {{ $company_name }}.</p>
                            <p style="color: #6D96CA; font-family: Arial; font-size: 8px; font-weight: 400; margin: 0 0 10px;">Thank you for your business!</p>
                            <p style="font-family: Arial; font-size: 8px; font-weight: bold; margin: 0; color: #1D3451;">
                                {!! $company_address !!} |<br>
                                PHONE: {{ $company_mobile }} | EMAIL: {{ $company_email }}
                            </p>
                            <img src="{{ $invoice_footer_image }}" alt="" style="display: block; height: 40px; margin: 20px auto;">
                        </td>
                    </tr>
                    <!-- Footer End -->

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
