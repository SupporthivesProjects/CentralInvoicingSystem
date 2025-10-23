<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Invoice</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f7f7fa;
        }

        .main-table {
            width: 900px;
            margin: auto;
            border-collapse: separate;
            border-spacing: 0;
            background: #f7f7fa;
            /* border-radius: 8px; */
            overflow: hidden;
        }

        .header-row td,
        .footer-row td {
            height: 100px;
            text-align: center;
            font-size: 28px;
            color: #888;
            letter-spacing: 2px;
            border: none;
        }

        .bill-row td {
            padding: 36px 50px 24px 50px;
            background: #f7f7fa;
            border: none;
        }

        .bill-table {
            width: 100%;
        }

        .bill-table td {
            vertical-align: top;
            font-size: 15px;
            color: #222;
            border: none;
            padding: 0 0 0 0;
        }

        .bill-table .bill-to strong {
            font-size: 16px;
            color: #000;
        }

        .bill-table .meta {
            text-align: right;
            font-size: 15px;
            color: #222;
        }

        .bill-table .meta strong {
            color: #000;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 32px;
            margin-bottom: 0;
            background: #fff;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 16px 10px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 15px;
        }

        .invoice-table th {
            background: #eaeaf6;
            color: #222;
            font-weight: bold;
            text-align: left;
        }

        .invoice-table td {
            color: #333;
        }

        .notes-total-row td {
            padding: 40px;
            border: none;
        }

        .notes-cell {
            width: 60%;
            background: #c7c7f7;
            padding: 28px 28px 28px 50px;
            font-size: 14px;
            color: #222;
            /* border-bottom-left-radius: 8px; */
            vertical-align: top;
            flex: 1;
        }

        .notes-cell strong {
            display: block;
            margin-bottom: 10px;
            color: #222;
            font-size: 15px;
        }

        .total-cell {
            width: 40%;
            background: #f07edb;
            color: #fff;
            text-align: right;
            padding: 28px 50px 28px 28px;
            /* border-bottom-right-radius: 8px; */
            vertical-align: top;
            flex: 1;
        }

        .total-label {
            font-size: 17px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .total-amount {
            font-size: 40px;
            font-weight: bold;
            margin-top: 12px;
        }

        /* Add spacing between sections for clarity */
        .section-space {
            height: 18px;
            background: transparent;
        }
        .for_bttom {
            position: fixed;
            bottom: -2px;
            left: 0;
            right: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <table class="main-table">
        <!-- Header -->
        <tr class="header-row"
            style="height: 140px; background-image: url({{ $invoice_header_image }}); position: relative;">
            <td colspan="2" style="padding: 0;">
                <table width="100%" style="height: 140px; border-collapse: collapse;">
                    <tr>
                        <!-- Logo and Title -->
                        <td style="width: 60%; padding-left: 36px; vertical-align: middle;">
                            <div style="display: flex; align-items: center;">
                                <!-- Logo Placeholder -->
                                <div>
                                    <span>
                                        <img src="{{ $company_logo }}" alt="Logo"
                                            style="height:48px; margin-right: 14px;">.
                                    </span><br>
                                    <span
                                        style="font-size: 38px; color: #111; font-weight: bold; letter-spacing: 1px;">Invoice</span>
                                </div>
                            </div>
                        </td>
                        <!-- Company Info -->
                        <td style="width: 40%; text-align: right; padding-right: 36px; vertical-align: middle;">
                            <div style="font-size: 17px; font-weight: bold; color: #111;">{{ $company_name }}</div>
                            <div style="font-size: 15px; color: #222; margin-top: 6px;">{{ $company_address }}</div>
                            <div style="font-size: 15px; color: #222;">{{ $company_mobile }}</div>
                            <div style="font-size: 15px; color: #222;">{{ $company_email }}</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="section-space">
            <td colspan="2"></td>
        </tr>
        <!-- Bill To & Invoice Meta -->
        <tr class="bill-row">
            <td colspan="2">
                <table class="bill-table">
                    <tr>
                        <td class="bill-to">
                            <strong>BILL TO:</strong><br>
                            {{ $customer_name }}<br>
                            {{ $customer_mobile }}<br>
                            {{ $customer_email }}
                        </td>
                        <td class="meta">
                            <div><strong>INVOICE #</strong><br>{{ $invoice_number }}</div>
                            <div style="margin-top: 16px;"><strong>DATE</strong><br>{{ $invoice_date }}</div>
                            <div style="margin-top: 16px;"><strong>INVOICE DUE DATE</strong><br>{{ $invoice_date }}</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="section-space">
            <td colspan="2"></td>
        </tr>
        <!-- Invoice Items Table -->
        <tr>
            <td colspan="2" style="padding: 0 50px;">
                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th>CATEGORY</th>
                            <th>PRODUCT</th>
                            <th>QUANTITY</th>
                            <th>AMOUNT</th>
                            <th>PRICE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->category_name ?? 'Uncategorized' }}</td>
                            <td>{{ $product->name }}</td>
                            <td>1</td>
                            <td>{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                            <td>{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
        <tr class="section-space">
            <td colspan="2"></td>
        </tr>
        <!-- Notes and Total Row -->
        <tr class="notes-total-row">
            <td class="notes-cell">
                <!-- <strong>NOTES:</strong>
                {{ $invoice_notes ?? 'Thank you for your business!' }} -->
            </td>
            <td class="total-cell">
                <span class="total-label">TOTAL</span>
                <div class="total-amount">{{ site_currency() }} {{  number_format(($invoice_amount), 2) }}</div>
            </td>
        </tr>
        <tr class="section-space">
            <td colspan="2"></td>
        </tr>
        <tr class="section-space">
            <td colspan="2"></td>
        </tr>
        <tr class="section-space">
            <td colspan="2"></td>
        </tr>
        <tr class="section-space">
            <td colspan="2"></td>
        </tr>
        <!-- Footer -->
        <!-- <tr>
            <td colspan="2"
                style="position: relative; background: url('{{ $invoice_footer_image }}') no-repeat center center; background-size: cover; height: 133px;">
               
            </td>
        </tr> -->
        <div style=" background: url('{{ $invoice_footer_image }}') no-repeat center center; background-size: cover; height: 133px; width: 100%;" class="for_bttom">
    <!-- Optional content like logo/title can go here -->
</div>
    </table>
</body>

</html>
