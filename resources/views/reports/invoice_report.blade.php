<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            margin: 20px auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        h4 {
            text-align: center;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            position: absolute;
            bottom: 20px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h4>Invoice Report</h4>
        
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
                            <td>{{ $invoice->website->site_name }}</td>
                            <td>{{ $invoice->website->businessModel->name }}</td>
                            <td>{{ number_format($invoice->invoice_amount, 2) }}</td>
                            <td>{{ $invoice->created_at->format('d M, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center"><center>No invoices found for the selected criteria.</center></p>
        @endif

        <!-- Footer Message with Date and Time -->
        <div class="footer">
            <p>This report printed by Narayan Zade on {{ \Carbon\Carbon::now()->format('d M, Y \a\t h:i A') }}</p>
        </div>
    </div>
</body>
</html>
