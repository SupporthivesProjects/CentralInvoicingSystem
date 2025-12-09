<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <meta charset="utf-8" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { margin:0; padding:0; font-family: Arial, sans-serif; color:#000; }

        /* Header */
        .header-row { padding: 20px; }
        .logo { width: 180px; display:block; margin-bottom:10px; } /* bigger logo */
        .company-details { font-size: 11px; line-height:1.45; margin-top:6px; color:#222; } /* 3 lines */

        /* Invoice badge */
        .invoice-badge {
            background-color: #ffc680;
            padding: 10px 22px;
            font-weight: 700;
            font-size: 38px;
            border-radius: 50px;
            display: inline-block;
        }

        /* Invoice date / number pills */
        .pills { text-align:right; font-weight:700; font-size:11px; }
        .pill { display:inline-block; padding:5px 14px; border-radius:15px; font-size:11px; margin-left:8px; }

        /* Orange "Invoice To" box */
        .invoice-to-wrap {
            padding: 90px 50px 0px 50px;
        }
        .invoice-to-box {
            background-color: #f79d7c; /* orange */
            border-radius: 0px 28px 28px 28px;
            padding: 30px 28px;
            max-width: 100%;
            box-shadow: 0 6px 0 rgba(0,0,0,0.02);
            position: relative;
            z-index: 2;
            margin-bottom: 24px;
        }
        .invoice-to-box h1 { margin:6px 0 0; font-size: 30px; color:#222; }
        .invoice-to-box .label { font-size:20px; font-weight:700; margin-bottom:6px; color:#111; }

        /* Items section (BLUE BAR FIX APPLIED HERE) */
        .items-wrap { padding: 0 20px 20px 20px; }
        .items-container {
            position: relative;
            z-index: 1;
            padding-top: 40px; /* FIX: ADD SPACE ABOVE BLUE BAR */
        }

        .items-table { width:100%; border-collapse:collapse; font-size:13px; }
        .items-table thead tr { background-color:#7ebbf3; color:#000; font-weight:700; font-size:13px; }
        .items-table th, .items-table td { padding:12px 14px; vertical-align:middle; }
        .items-table tbody tr { background-color:#fde7c8; height:48px; font-size:13px; }
        .items-table th:first-child { border-top-left-radius:12px; border-bottom-left-radius:12px; text-align:left; }
        .items-table th:last-child { border-top-right-radius:12px; border-bottom-right-radius:12px; text-align:right; }
        .items-table td:first-child { padding-left:16px; }
        .items-table td:last-child { text-align:right; padding-right:16px; }

        /* Totals */
        .totals { padding: 20px; }
        .totals .pill-row { width:220px; margin-left:auto; font-size:12px; }
    </style>
</head>

<body style="background: #feecd1;">

    <table align="center" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="background: url('{{ $invoice_image1 }}') no-repeat top/cover; vertical-align:top; min-height:100vh;">

                <table align="center" width="100%" cellpadding="0" cellspacing="0">
                    
                    <tr>
                        <td class="header-row">
                            <table width="100%">
                                <tr>
                                    <td style="width:70%; vertical-align:top;">
                                        <img src="{{ $company_logo }}" alt="logo" class="logo">

                                        <p style="font-size: 8px; line-height: 1.4; margin-top: 15px;">
                                            <!-- {{ $company_address }}<br> -->
                                            @php
                                                $parts = array_map('trim', explode(',', $company_address));
                                                $chunks = array_chunk($parts, ceil(count($parts) / 3));
                                            @endphp

                                            @foreach($chunks as $chunk)
                                                {{ implode(', ', $chunk) }}<br>
                                            @endforeach

                                            {{ $company_email }}<br>
                                        </p>
                                    </td>

                                    <td style="vertical-align: top; text-align:right;">
                                        <div class="invoice-badge">INVOICE</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 0 20px 10px 20px;">
                            <table width="100%">
                                <tr>
                                    <td></td>
                                    <td class="pills">
                                        <span class="pill" style="background:#7ebbf3;">Invoice Date</span>
                                        <span class="pill" style="background:#ffb6a3;">Invoice No.</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align:right; padding-top:8px; font-size:11px;">
                                        <span style="margin-right:40px;">{{ $invoice_date }}</span>
                                        <span>{{ $invoice_number }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td class="invoice-to-wrap">
                            <div class="invoice-to-box">
                                <div class="label">Invoice To</div>
                                <h1>{{ $customer_name }}</h1>
                            </div>
                        </td>
                    </tr>

                    <!-- BLUE BAR + ITEMS -->
                    <tr>
                        <td class="items-wrap">
                            <div class="items-container">
                                <table class="items-table">
                                    <thead>
                                        <tr>
                                            <th style="text-align:left;">ITEM DESCRIPTION</th>
                                            <th style="text-align:center;">UNIT PRICE</th>
                                            <th style="text-align:center;">QTY</th>
                                            <th style="text-align:right;">TOTAL</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td align="center">{{ site_currency() }} {{ number_format($product->unit_price, 2) }}</td>
                                            <td align="center">1</td>
                                            <td align="right">{{ site_currency() }} {{ number_format($product->unit_price, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="totals">
                            <table class="pill-row" align="right">
                                <tr>
                                    <td colspan="2" style="background:#7ebbf3; border-radius:30px; padding:10px 16px; font-weight:600; display:flex; justify-content:space-between;">
                                        <span>Sub Total</span>
                                        <span>{{ site_currency() }} {{ number_format($invoice_amount + $discount_amount, 2) }}</span>
                                    </td>
                                </tr>
                                <tr><td style="height:10px"></td></tr>
                                <tr>
                                    <td colspan="2" style="background:#f79d7c; border-radius:30px; padding:10px 16px; font-weight:600; display:flex; justify-content:space-between;">
                                        <span>Discount</span>
                                        <span>{{ site_currency() }} {{ number_format($discount_amount, 2) }}</span>
                                    </td>
                                </tr>
                                <tr><td style="height:10px"></td></tr>
                                <tr>
                                    <td colspan="2" style="background:#fff; border-radius:30px; padding:10px 16px; font-weight:700; display:flex; justify-content:space-between;">
                                        <span>TOTAL</span>
                                        <span>{{ site_currency() }} {{ number_format($invoice_amount, 2) }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
