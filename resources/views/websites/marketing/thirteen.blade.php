<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .container {
            width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 40px;
        }

        .header img {
            width: 200px;
            height: auto;
        }
        .footer img {
            width: 100%;
            height: auto;
        }

        .invoice-title {
            text-align: right;
            font-weight: bold;
            font-size: 24px;
            margin-top: -60px;
        }

        .invoice-meta {
            text-align: right;
        }

        .section-title {
            font-weight: bold;
            text-transform: uppercase;
        }

        .info-table td {
            padding: 4px 0;
        }

        .items-table, .items-table th, .items-table td {
            border: 1px solid #c3c3c3;
            text-align: center;
            padding: 6px;
        }

        .items-table th {
            background-color: #f2f2f2;
        }

        .total-row td {
            font-weight: bold;
        }

        .footer-note {
            text-align: center;
            margin-top: 30px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header Image -->
    <div class="header">
        <img src="{{ $company_logo }}" alt="Header Image" width="200px">
    </div>

    <!-- Invoice Title -->
    <div class="invoice-title">INVOICE</div>
    <div class="invoice-meta">
        <p>Invoice #{{ $invoice_number }}</p>
        <p>Date: {{ $invoice_date }}</p>
    </div>

    <br>

    <!-- Billing Info -->
    <table class="info-table">
        <tr>
            <td width="50%">
                <div class="section-title">Billed From:</div>
                <p>Javago<br>
                    Website: www.javago.com<br>
                    Email: support@javago.com<br>
                    Address: FDRK0114 Compass Building,<br>
                    Al Shohada Road, AL Hamra Industrial Zone-FZ,<br>
                    Ras Al Khaimah, United Arab Emirates
                </p>
            </td>
            <td width="50%" align="right">
                <div class="section-title">Billed To:</div>
                <p>{{ $customer_name }}</p>
            </td>
        </tr>
    </table>

    <br>

    <!-- Product Table -->
    <table class="items-table">
        <thead>
            <tr>
                <th>Product & Service</th>
                <th>QTY & Duration</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>Qty:{{ $product->quantity ?? 1 }} & {{ $product->subscription }}</td>
                <td>{{ site_currency_code() }}{{ number_format($product->unit_price, 2) }}</td>
                <td>{{ site_currency_code() }}{{ number_format($product->unit_price * ($product->quantity ?? 1), 2) }}</td>
            </tr>
        @endforeach
            <tr class="total-row">
                <td colspan="3" style="text-align: end;">Subtotal</td>
                <td>{{ site_currency_code() }}{{ number_format($invoice_amount + $discount_amount, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: end;">Discount</td>
                <td>{{ site_currency_code() }}{{ number_format($discount_amount, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: end;">Total</td>
                <td>{{ site_currency_code() }}{{ number_format($invoice_amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer-note">
    </div>

    <div class="footer">
        <img src="{{ $invoice_footer_image }}" alt="Footer Image">
    </div>
</div>

</body>
</html>
