<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        tr.myrow:nth-of-type(odd) {
            background:#faf8fc !important;
            }

        </style>
</head>

<body style="margin:0; padding:0; font-family:Montserrat, Arial, sans-serif; background-color:#fff;">

    <table width="100%" align="center" cellpadding="0" cellspacing="0" style="background:#fff; border-collapse:collapse;">

        <!-- Header Section -->
        <tr>
            <td colspan="2"style="position: relative; background: url('{{ $invoice_header_image }}') no-repeat; background-size: cover; height: 165px;">
                <!-- Logos -->
                <img src="{{ $company_logo }}" style="position: absolute; top: 94px; left: 91px; height: 70px; z-index: 1;">
                <img src="{{ $invoice_image1 }}" style="position: absolute; top: 0px; left: 0px; width: 100px; z-index: 2;">

                <!-- Invoice Info (Right Aligned) -->
                <div style="position: absolute; top: 20px; right: 30px; color: #fff; text-align: right;">
                    <table style="color: black;">
                        <tr>
                            <td style="font-weight:600; font-size:14px;">Invoice Date</td>
                            <td style="font-size:14px;">{{ $invoice_date }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight:600; font-size:14px;">Invoice No:</td>
                            <td style="font-size:14px;">{{ $invoice_number}}</td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <div
                                    style="width: 170px; height:5px; background-image: url(./img/linee.png); margin-top:10px;">
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>

        <!-- Company Info and Recipient -->
        <tr>
            <td style="padding:82px 0 0 40px;" valign="top">
                <strong>Kindred Spirits</strong><br>
                Taiji Enterprises FZ-LLC<br>
                <a href="mailto:{{ $company_email }}"
                    style="color:#3b3bb3; text-decoration:underline;">{{ $company_email }}</a>
            </td>
            <td style="padding:30px 40px 0 0; text-align:right;" valign="top">
                <!-- Big Invoice Title -->
                <div style="font-size:64px; font-weight:700; color:#231f20; line-height:1; margin-bottom:10px;">
                    Invoice
                </div>

                <!-- Invoice To Details -->
                <div style="font-size:14px; color:#231f20;">
                    <strong>Invoice to:</strong><br>
                    <span style="font-weight:700;">{{ $customer_name }}</span>
                </div>
            </td>

        </tr>

        <!-- Invoice Title -->
        <tr>
            <td colspan="2" style="padding:10px 40px 0 0; text-align:right;">
            </td>
        </tr>

        <!-- Spacer -->
        <tr>
            <td colspan="2" style="height:30px;"></td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 0 40px;">
                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                    <tr>
                        <th
                            style="background:#cfc3e6; color:#231f20; padding:10px 8px; text-align:left; font-size:15px; font-weight:700;">
                            DESCRIPTION</th>
                        <th
                            style="background:#cfc3e6; color:#231f20; padding:10px 8px; text-align:center; font-size:15px; font-weight:700;">
                            QTY</th>
                        <th
                            style="background:#cfc3e6; color:#231f20; padding:10px 8px; text-align:center; font-size:15px; font-weight:700;">
                            PRICE</th>
                        <th
                            style="background:#cfc3e6; color:#231f20; padding:10px 8px; text-align:center; font-size:15px; font-weight:700;">
                            TOTAL</th>
                    </tr>
                   
                </table>
            </td>
        </tr>


        @foreach($products as $product)
        <tr class="myrow">
            <td colspan="2" style="padding: 0 40px;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                    <td style="font-weight:700; padding:10px 8px;">{{ $product->name }} - {{ $product->category_name }}</td>
                        <td style="text-align:center; padding:10px 8px;">01</td>
                        <td style="text-align:center; padding:10px 8px;">{{ site_currency() }} {{  number_format($product->unit_price, 2) }}</td>
                        <td style="text-align:center; padding:10px 8px;">{{ site_currency() }} {{  number_format($product->unit_price, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="height:30px; border-bottom:2px solid #231f20;"></td>
                    </tr>
                </table>
            </td>
        </tr>

        @endforeach
       
        <!-- Totals -->
        <tr>
            <td></td>
            <td style="padding:0 40px 0 0;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td
                            style="padding:10px 8px; border-bottom:1px solid #231f20; font-size:15px; background:#f7f7f7;">
                            SUB TOTAL</td>
                        <td
                            style="padding:10px 8px; border-bottom:1px solid #231f20; font-size:15px; text-align:right; background:#f7f7f7;">
                            {{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</td>
                    </tr>
                    <tr>
                        <td style="padding:10px 8px; border-bottom:1px solid #231f20; font-size:15px; background:#fff;">
                            DISCOUNT</td>
                        <td
                            style="padding:10px 8px; border-bottom:1px solid #231f20; font-size:15px; text-align:right; background:#fff;">
                            {{ site_currency() }} {{ number_format($discount_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td
                            style="padding:10px 8px; border-bottom:2px solid #231f20; font-size:15px; font-weight:700; background:#f7f7f7;">
                            TOTAL AMOUNT</td>
                        <td
                            style="padding:10px 8px; border-bottom:2px solid #231f20; font-size:15px; font-weight:700; text-align:right; background:#f7f7f7;">
                            {{ site_currency() }} {{ number_format($invoice_amount, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td colspan="2" style="padding-top: 52px;">
                <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0"
                    style="border-top: 2px solid #8ea5d3; padding-top: 10px;">
                    <tr class="d-flex" style=" display: flex; justify-content: center;">
                        <!-- Location -->
                        <td align="center" width="170" style="padding: 10px;display: flex;align-items: center;justify-content: center;gap: 6px;">
                            <img src="{{ $invoice_image2 }}" alt="Location Icon"
                                style="vertical-align: middle; max-width: 25px;" class="iconn img-fluid" />
                            <div style="color: #000000; font-size: 14px;">{{ $company_name }}</div>
                        </td>

                        <!-- Email and Website -->
                        <td align="center" width="170" style="padding: 10px;display: flex;align-items: center;justify-content: center;gap: 6px;">
                            <img src="{{ $invoice_image3 }}" alt="Internet Icon"
                                style="vertical-align: middle; max-width: 25px;" class="iconn"/>
                            <div>
                                <a href="mailto:{{ $company_email }}"
                                    style="color: #0073e6; text-decoration: none; font-size: 14px;">{{ $company_email }}</a>
                            </div>
                        </td>

                        <!-- Phone -->
                        <td align="center" width="170" style="padding: 10px;display: flex;align-items: center;justify-content: center;gap: 6px;">
                            <img src="{{ $invoice_image4 }}" alt="Phone Icon"
                                style="vertical-align: middle; max-width: 25px;" class="iconn" />
                            <div style="color: #000000; font-size: 14px;">{{ $company_mobile }}</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>

</body>

</html>