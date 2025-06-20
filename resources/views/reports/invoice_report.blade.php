<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Report</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #333;
        }

        .report-wrapper {
            padding: 30px 40px;
        }

        .header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .header img {
            height: 60px;
            margin-right: 20px;
        }

        .header h2 {
            font-size: 24px;
            margin: 0;
            color: #333;
        }

        .report-title {
            text-align: center;
            font-size: 22px;
            margin-bottom: 20px;
            color: #444;
            font-weight: 600;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 14px;
        }

        thead {
            background-color: #2c3e50;
            color: #fff;
        }

        th, td {
            padding: 12px 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #777;
            margin-top: 30px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 60px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="report-wrapper">

        <!-- Header -->
        <div class="header">
            <img src="{{ asset('images/brand-logos/invoice_genie_white.png') }}" alt="Invoice Genie Logo">
            <h2>Invoice Genie</h2>
        </div>

        <!-- Title -->
        <div class="report-title">Invoice Report</div>

        <!-- Table or Message -->
        @if($invoices->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Invoice Number</th>
                        <th>Site Name</th>
                        <th>Business Model</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $invoice->invoice_number }}</td>
                            <td>{{ optional($invoice->website)->site_name }}</td>
                            <td>{{ optional(optional($invoice->website)->businessModel)->name }}</td>
                            <td>{{ number_format($invoice->invoice_amount, 2) }}</td>
                            <td>{{ $invoice->created_at->format('d M, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">No invoices found for the selected criteria.</div>
        @endif

        <!-- Footer -->
        <div class="footer">
            This report was printed by Narayan Zade on {{ \Carbon\Carbon::now()->format('d M, Y \a\t h:i A') }}
        </div>
    </div>
</body>
</html>
