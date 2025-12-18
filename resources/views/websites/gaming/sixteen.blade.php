<!DOCTYPE html>
<html>
<head>
    <title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
            background: #f3f3f3;
        }

        .main-container {
            width: 100%;
            background: #f3f3f3;
            padding: 20px 0;
        }

        .invoice-wrapper {
            width: 100%;
            margin: 0 auto;
            background: #f3f3f3;
        }

        /* Header Section */
        .header-section {
            background: #fff;
            padding: 30px;
            margin-bottom: 0;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: top;
            border: none;
        }

        .logo-cell {
            width: 60%;
            padding-right: 20px;
        }

        .invoice-info-cell {
            width: 40%;
            text-align: right;
        }

        .company-logo {
            width: 200px;
            height: auto;
        }

        .invoice-title {
            color: #D09E53;
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .invoice-meta {
            font-size: 9px;
            margin: 5px 0;
            text-transform: uppercase;
        }

        /* Billing Information */
        .billing-section {
            width: 100%;
            margin-top: 20px;
        }

        .billing-table {
            width: 100%;
            border-collapse: collapse;
        }

        .billing-table td {
            vertical-align: top;
            font-size: 9px;
            border: none;
        }

        .billing-from {
            width: 60%;
            padding-right: 20px;
        }

        .billing-to {
            width: 40%;
            text-align: right;
        }

        .billing-label {
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
            display: block;
        }

        .billing-info {
            margin: 2px 0;
        }

        /* Content Section */
        .content-section {
            background: #f3f3f3;
            padding: 20px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
            background: #fff;
        }

        .invoice-table th {
            border: 1px solid #000;
            padding: 8px 5px;
            font-size: 9px;
            font-weight: bold;
            color: #D09E53;
            text-align: center;
            text-transform: uppercase;
            background-color: #fff;
            height: 20px;
        }

        .invoice-table td {
            border: 1px solid #000;
            padding: 8px 5px;
            font-size: 9px;
            height: 20px;
        }

        .qty-col {
            width: 15%;
            text-align: center;
        }

        .desc-col {
            width: 45%;
            text-align: left;
        }

        .price-col {
            width: 20%;
            text-align: right;
        }

        .total-col {
            width: 20%;
            text-align: right;
        }

        .product-name {
            font-weight: bold;
            margin-bottom: 2px;
        }

        .platform-info {
            font-style: italic;
            font-size: 8px;
            margin-top: 2px;
        }

        .platform-field {
            font-size: 8px;
            margin-left: 8px;
        }

        .total-row {
            font-weight: bold;
        }

        .discount-row {
            color: green;
        }

        .empty-space {
            height: 80px;
        }

        /* Footer Section */
        .footer-section {
            background-color: #333;
            padding: 20px;
            text-align: center;
            color: white;
        }

        .footer-text {
            font-size: 10px;
            font-weight: bold;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="invoice-wrapper">

            <!-- Header Section -->
            <div class="header-section">
                <table class="header-table">
                    <tr>
                        <td class="logo-cell">
                            <img src="{{ $company_logo }}" alt="Company Logo" class="company-logo">
                        </td>
                        <td class="invoice-info-cell">
                            <h1 class="invoice-title">INVOICE</h1>
                            <div class="invoice-meta">Invoice # {{ $invoice_number }}</div>
                            <div class="invoice-meta">Date: {{ \Carbon\Carbon::parse($invoice_date)->format('d M Y') }}</div>
                        </td>
                    </tr>
                </table>

                <!-- Billing Information -->
                <div class="billing-section">
                    <table class="billing-table">
                        <tr>
                            <td class="billing-from">
                                <span class="billing-label">BILLED FROM:</span>
                                <div class="billing-info">{{ $site->site_name }}</div>
                                <div class="billing-info">Website: <a href="{{ $site->site_link ?? 'N/A' }}" style="text-decoration: none; color: #000000;">www.goldforgamers.com</a></div>
                                <div class="billing-info">Email: {{ $company_email }}</div>
                            </td>
                            <td class="billing-to">
                                <span class="billing-label">BILLED TO:</span>
                                <div class="billing-info">{{ $customer_name }}</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Content Section -->
            <div class="content-section">
                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th class="qty-col">Quantity</th>
                            <th class="desc-col">Description</th>
                            <th class="price-col">Unit Price</th>
                            <th class="total-col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $counter = 1; @endphp
                        @foreach($products as $product)
                        <tr>
                            <td class="qty-col">{{ $counter++ }}</td>
                            <td class="desc-col">
                                <div class="product-name">{{ $product['name'] }}</div>
                                @if(isset($product['platform_fields']) && isset($product['selected_platform']))
                                    <div class="platform-info">{{ $product['selected_platform'] }}:</div>
                                    @foreach($product['platform_fields'][$product['selected_platform']] as $fieldName => $value)
                                        <div class="platform-field">
                                            {{ ucfirst(str_replace('_',' ',$fieldName)) }}: {{ $value }}
                                        </div>
                                    @endforeach
                                @endif
                            </td>
                            <td class="price-col">{{ $product['game_currency_amount'] }} {{ $product['game_currency'] }}</td>
                            <td class="total-col">{{ $currency . number_format($product['unit_price'],2) }}</td>
                        </tr>
                        @endforeach

                        <!-- Empty rows for spacing -->
                        @for($i = 0; $i < (6 - count($products)); $i++)
                        <tr>
                            <td class="qty-col">&nbsp;</td>
                            <td class="desc-col">&nbsp;</td>
                            <td class="price-col">&nbsp;</td>
                            <td class="total-col">&nbsp;</td>
                        </tr>
                        @endfor

                        <!-- Totals -->
                        <tr class="total-row">
                            <td colspan="3" style="text-align: right; padding-right: 10px;">SUBTOTAL</td>
                            <td class="total-col">{{ $currency . number_format($invoice_amount + $discount_amount,2) }}</td>
                        </tr>
                        <tr class="discount-row">
                            <td colspan="3" style="text-align: right; padding-right: 10px;">DISCOUNT</td>
                            <td class="total-col">-{{ $currency . number_format($discount_amount,2) }}</td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="3" style="text-align: right; padding-right: 10px;">TOTAL DUE</td>
                            <td class="total-col">{{ $currency . number_format($invoice_amount,2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Spacer -->
            <div class="empty-space"></div>

            <!-- Footer Section -->
            <div class="footer-section">
                <p class="footer-text">WE APPRECIATE YOUR BUSINESS</p>
            </div>

        </div>
    </div>
</body>
</html>
