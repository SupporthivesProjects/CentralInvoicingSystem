<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice{{ $invoice_number }}</title>
</head>

<body style="font-family: Arial, sans-serif; color: #000; background-color: #fff; margin:0; padding:0;">

    <!-- HEADER IMAGE SECTION -->
    <table style="width:100%; margin:0 auto; border-collapse:collapse;">
        <tr>
            <td style="width:100%; height:100px; background-color:#fcdce0; text-align:center; vertical-align:middle;">
                <img src="{{ $invoice_header_image }}" alt="Header Image" style="width:100%; height:100%; object-fit:cover;">
            </td>
        </tr>
    </table>

    <!-- INVOICE BODY -->
    <div style="width:600px; margin:0 auto; border-collapse:collapse;">
        <p style="text-align:center; font-weight:bold; color:#cc0000; font-size:9px; margin:20px 0;">INVOICE {{ $invoice_number }}</p>

        <table
            style="width:100%; border-collapse:collapse; font-size:9px; margin:0 auto; font-family:Arial, sans-serif; table-layout:fixed;">
            <tr>
                <th
                    style="border:1px solid #ff6666; background-color:#ffe5e5; text-align:left; padding:6px; width:50%;">
                    Bill to</th>
                <th
                    style="border:1px solid #ff6666; background-color:#ffe5e5; text-align:left; padding:6px; width:50%;">
                    Bill from</th>
            </tr>
            <tr>
                <!-- Bill To -->
                <td style="border:1px solid #ff6666; padding:8px; vertical-align:top;">
                    <div style="display:flex; gap:20px;">
                        <strong>Name</strong>
                        <span>{{ $customer_name ? $customer_name : '' }}</span>
                    </div>
                </td>

                <!-- Bill From -->
                <td style="border:1px solid #ff6666; padding:8px; vertical-align:top;">
                    <div style="display:flex; gap:30px; margin-bottom: 15px;">
                        <strong>Name</strong>
                        <span>{{ $company_name }}</span>
                    </div>
                    <div style="display:flex; gap:20px; margin-bottom: 15px;">
                        <strong>Address</strong>
                        <span>{!! $company_address !!}</span>
                    </div>
                    <div style="display:flex; gap:26px; margin-bottom: 15px;">
                        <strong>Phone</strong>
                        <span>{{ $company_mobile }}</span>
                    </div>
                    <div style="display:flex; gap:31px; ">
                        <strong>Email</strong>
                        <span>{{ $company_email }}</span>
                    </div>
                </td>
            </tr>
        </table>


        <br>

        <div style="min-height: 624px;">
            <table style="width:100%; border-collapse:collapse; font-size:9px; margin: 0 auto;height: 420px;">
            <tr>
                <th
                    style="width:10%; border:1px solid #ff6666; background-color:#ffd9d9; text-align:left; padding:8px;">
                    Qty.</th>
                <th
                    style="width:50%; border:1px solid #ff6666; background-color:#ffd9d9; text-align:left; padding:8px;">
                    Description</th>
                <th
                    style="width:20%; border:1px solid #ff6666; background-color:#ffd9d9; text-align:right; padding:8px;">
                    Unit price</th>
                <th
                    style="width:20%; border:1px solid #ff6666; background-color:#ffd9d9; text-align:right; padding:8px;">
                    Total</th>
            </tr>
            @foreach ($products as $product)
            <tr>
                <td style="border:1px solid #ff6666; padding:8px;">1</td>
                <td style="border:1px solid #ff6666; padding:8px;">{{ $product->name }}</td>
                <td style="border:1px solid #ff6666; padding:8px; text-align: right;">{{ site_currency() . number_format($product->unit_price ?? 0, 2) }}</td>
                <td style="border:1px solid #ff6666; padding:8px; text-align: right;">{{ site_currency() . number_format($product->unit_price ?? 0, 2) }}</td>
            </tr>
            @endforeach
            

            <!-- Empty rows for spacing -->
            <tr>
                <td style="border:1px solid #ff6666; padding:8px;"></td>
                <td style="border:1px solid #ff6666; padding:8px;"></td>
                <td style="border:1px solid #ff6666; padding:8px;"></td>
                <td style="border:1px solid #ff6666; padding:8px;"></td>
            </tr>
            <tr>
                <td style="border:1px solid #ff6666; padding:8px;"></td>
                <td style="border:1px solid #ff6666; padding:8px;"></td>
                <td style="border:1px solid #ff6666; padding:8px;"></td>
                <td style="border:1px solid #ff6666; padding:8px;"></td>
            </tr>
            <tr>
                <td style="border:1px solid #ff6666; padding:8px;"></td>
                <td style="border:1px solid #ff6666; padding:8px;"></td>
                <td style="border:1px solid #ff6666; padding:8px;"></td>
                <td style="border:1px solid #ff6666; padding:8px;"></td>
            </tr>

            <!-- Subtotal Row -->
            <tr>
                <td colspan="2" style="border:1px solid #ff6666; border-right: none;"></td>
                <td style="border:1px solid #ff6666; border-left:none; text-align:right; padding:8px;">Subtotal</td>
                <td style="border:1px solid #ff6666; text-align:right; padding:8px;">{{ site_currency() . number_format($invoice_amount + $discount_amount ?? 0, 2) }}</td>
            </tr>

            <!-- Discount Row -->
            <tr>
                <td colspan="2" style="border:1px solid #ff6666; border-right: none;"></td>
                <td style="border:1px solid #ff6666; border-left:none; text-align:right; padding:8px;">Discount Total
                </td>
                <td style="border:1px solid #ff6666; text-align:right; padding:8px;">{{ site_currency() . number_format($discount_amount ?? 0, 2) }}</td>
            </tr>

            <!-- Total Row (Highlighted) -->
            <tr style="border:1px solid #ff6666; border-right: none;">
                <td colspan="2" style="border:none;"></td>
                <td
                    style="border:1px solid #ff6666; border-left:none; font-weight:bold; text-align:right; padding:8px;">
                    Total</td>
                <td style="border:1px solid #ff6666; font-weight:bold; text-align:right; padding:8px;">{{ site_currency() . number_format($invoice_amount ?? 0, 2) }}</td>
            </tr>
            </table>
        </div>


        <div style="text-align:center; font-size:9px; margin-top:25px; margin-bottom: 25px;">
            <a href="#" style="color:#cc0000; font-weight:bold; text-decoration:none;">{{ $site_name }}</a><br>
            Thank you for your business!
        </div>
    </div>

    <!-- FOOTER IMAGE SECTION -->
    <table style="width:100%; margin:0 auto; border-collapse:collapse; border:1px solid #ff6666;">
        <tr>
            <td style="width:100%; height:120px; background-color:#fcdce0; text-align:center; vertical-align:middle;">
                <img src="{{ $invoice_footer_image }}" alt="Footer Image" style="width:100%; height:100%; object-fit:cover;">
            </td>
        </tr>
    </table>

</body>

</html>