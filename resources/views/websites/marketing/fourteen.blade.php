<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body {
            margin: 0;
            font-family: Calibri, sans-serif;
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#ffffff" style="padding:20px;">
                <table width="600px" cellspacing="0" cellpadding="0" border="0"
                       style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); background-image: url('{{ $invoice_image1 }}'); background-repeat: no-repeat; background-position: center; background-size: cover;">

                    <!-- Header with background -->
                    <tr>
                        <td colspan="2"
                            style="padding: 40px; background-image: url('{{ $invoice_header_image }}'); background-repeat: no-repeat; background-position: center; background-size: cover;">
                            <img src="{{ $company_logo }}" style="width:200px;">
                        </td>
                    </tr>

                    <!-- INVOICE and top-right icon -->
                    <tr>
                        <td style="padding-left: 40px;">
                            <h1 style="font-size: 36px; color: #414042; margin: 0px;">INVOICE</h1>
                        </td>
                        <td align="right" style="padding-right: 20px;">
                            <img src="{{ $invoice_image3 }}" style="width: 120px;">
                        </td>
                    </tr>

                    <!-- Invoice Info -->
                    <tr>
                        <td style="padding-left: 40px;">
                            <p style="font-size: 9px; margin: 0;">Invoice No : #{{ $invoice_number }}</p>
                            <p style="font-size: 9px; margin: 0;">Due Date : {{ $invoice_date }}</p>
                            <p style="border-bottom: 1px solid black; width: 150px; margin: 5px 0;"></p>
                            <p style="font-size: 10px;">Total Amount Due</p>
                            <p style="font-size: 22px; font-weight: 700; margin: 0;">{{ site_currency_code() }}{{ number_format($invoice_amount, 2) }}</p>
                        </td>
                        <td style="padding-right: 40px;" align="right">
                            <p style="font-size: 10px; font-weight: 700; margin: 0;">Invoice To</p>
                            <p style="font-size: 12px; font-weight: 700; margin: 0;">{{ $customer_name }}</p>
                            <br>
                            <p style="font-size: 10px; font-weight: 700; margin: 0;">Invoice From</p>
                            <p style="font-size: 12px; font-weight: 700; margin: 0;">Digital Age Solutionz</p>
                            <a style="font-size: 9px; color: #0563C1; text-decoration: underline;">{{ $company_email ?? 'Support@digitalagesolutionz.com' }}</a>
                            <p style="font-size: 9px; margin: 0;">+971 50 956 0385<br>Properties, DSO-IFZA,<br>Dubai Silicon Oasis</p>
                        </td>
                    </tr>

                    <tr><td colspan="2"><hr style="border: none; border-bottom: 2px solid black; width: 520px;"></td></tr>

                    <!-- Table Header -->
                    <tr>
                        <td colspan="2" style="padding: 40px 40px 20px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
                                <tr style="background: #000; color: #fff; height: 40px;">
                                    <th style="text-transform: uppercase;">Product & Service</th>
                                    <th style="text-transform: uppercase;">Qty</th>
                                    <th style="text-transform: uppercase;">Length</th>
                                    <th style="text-transform: uppercase;">Billing Cycle</th>
                                    <th style="text-transform: uppercase;">Total</th>
                                </tr>

                                @foreach($products as $product)
                                <tr style="height: 60px; background-color: #f9f9f9;">
                                    <td>{{ $product->name }}</td>
                                    <td align="center">1</td>
                                    <td align="center">{{ $product->subscription }}</td>
                                    <td align="center">One Time</td>
                                    <td align="center">{{ site_currency_code() }}{{ number_format($product->unit_price * ($product->quantity ?? 1), 2) }}</td>
                                </tr>
                                @endforeach

                                <!-- Subtotal -->
                                <tr>
                                    <td colspan="3"></td>
                                    <td align="right"><strong>Subtotal</strong></td>
                                    <td align="right">{{ site_currency_code() }}{{ number_format($invoice_amount + $discount_amount, 2) }}</td>
                                </tr>

                                <!-- Discount -->
                                <tr>
                                    <td colspan="3"></td>
                                    <td align="right"><strong>Discount</strong></td>
                                    <td align="right">{{ site_currency_code() }}{{ number_format($discount_amount, 2) }}</td>
                                </tr>

                                <!-- Grand Total -->
                                <tr>
                                    <td colspan="3"></td>
                                    <td align="right"><strong>Grand Total</strong></td>
                                    <td align="right"><strong>{{ site_currency_code() }}{{ number_format($invoice_amount, 2) }}</strong></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Bottom Decoration -->
                    <tr>
                        <td colspan="2">
                            <div style="height: 100px; background-image: url('{{ $invoice_image2 }}'); background-repeat: no-repeat; background-position: center; background-size: cover;"></div>
                        </td>
                    </tr>

                    <!-- Footer Background -->
                    <tr>
                        <td colspan="2" style="height: 60px; background-image: url('{{ $invoice_footer_image }}'); background-repeat: no-repeat; background-position: center; background-size: cover;"></td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
