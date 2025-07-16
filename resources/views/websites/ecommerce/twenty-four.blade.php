<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body, table, td {
            background-color: transparent !important;
        }
        .invoice_header_image {
            background-image: url('{{ $invoice_header_image }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            width: 100%;
            height: 942px;
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f2f2f2; padding: 20px 0;">
        <tr>
            <td align="center">
                <table cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0,0,0,0.1); max-width: 100%; width: 100%;">
                    <tr>
                        <td class="invoice_header_image">
                            <table width="100%" style="padding: 40px;">
                                <tr>
                                    <td style="width: 290px;">
                                        <p style="font-family: arial; font-size: 10px; font-weight: 700; margin-bottom: 5px;">BILLED FROM:</p>
                                        <p style="font-family: arial; font-size: 10px; margin: 0px; font-weight: 400;">
                                            {{ $company_name }} <br>
                                            {{ $site_name }} <br>
                                            {{ $site->site_link }}
                                        </p>
                                    </td>
                                    <td style="width: 300px; text-align: right; padding: 15px 0 0 0;">
                                        <h1 style="font-family: arial; font-size: 20px; margin: 0px; font-weight: 700;">INVOICE</h1>
                                        <p style="font-family: arial; font-size: 10px; margin-bottom: 5px;"><b>INVOICE DATE:</b> {{ $invoice_date }}</p>
                                        <p style="font-family: arial; font-size: 10px; margin: 0px;"><b>Invoice No:</b> {{ $invoice_number }}</p>
                                        <br><br>
                                        <p style="font-family: arial; font-size: 10px; margin: 0px;"><b>BILLED TO:</b></p>
                                        <p style="font-family: arial; font-size: 10px; margin: 0px;">{{ $customer_name }}</p>
                                    </td>
                                </tr>
                            </table>

                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="min-height: 500px; border-collapse: collapse; table-layout: fixed;">
                                <thead>
                                    <tr>
                                        <th style="width: 10%; text-align: left; font-family: arial; font-size: 10px; border-bottom: 1px solid black;"><b>Quantity</b></th>
                                        <th style="width: 60%; text-align: left; font-family: arial; font-size: 10px; border-bottom: 1px solid black;"><b>Product</b></th>
                                        <th style="width: 15%; text-align: left; font-family: arial; font-size: 10px; border-bottom: 1px solid black;"><b>Price</b></th>
                                        <th style="width: 15%; text-align: left; font-family: arial; font-size: 10px; border-bottom: 1px solid black;"><b>Amount</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td style="font-family: arial; font-size: 10px; border-left: 1px solid black;">{{ $product->quantity ?? 1 }}</td>
                                        <td style="font-family: arial; font-size: 10px; border-left: 1px solid black;">{{ $product->name }}</td>
                                        <td style="font-family: arial; font-size: 10px; border-left: 1px solid black;">{{ site_currency() }} {{ number_format($product->unit_price, 2) }}</td>
                                        <td style="font-family: arial; font-size: 10px; border-left: 1px solid black; border-right: 1px solid black;">
                                            {{ site_currency() }} {{ number_format(($product->unit_price * ($product->quantity ?? 1)), 2) }}
                                        </td>
                                    </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="2"></td>
                                        <td style="text-align: right; font-family: arial; font-size: 10px; padding-right: 10px;"><b>Subtotal</b></td>
                                        <td style="font-family: arial; font-size: 10px; border: 1px solid black;">
                                            {{ site_currency() }} {{ number_format($invoice_amount + $discount_amount, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td style="text-align: right; font-family: arial; font-size: 10px; padding-right: 10px;"><b>Discount</b></td>
                                        <td style="font-family: arial; font-size: 10px; border: 1px solid black;">
                                            {{ site_currency() }} {{ number_format($discount_amount, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td style="text-align: right; font-family: arial; font-size: 10px; padding-right: 10px;"><b>Total Due</b></td>
                                        <td style="font-family: arial; font-size: 10px; border: 1px solid black;">
                                            {{ site_currency() }} {{ number_format($invoice_amount, 2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-top: 20px;">
                                <tr>
                                    <td style="text-align: center;">
                                        <p style="font-family: arial; font-size: 12px; margin: 0px;"><b>Thank You</b><br>
                                        For questions concerning this invoice, please contact</p>
                                    </td>
                                </tr>
                            </table>

                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-top: 10px;">
                                <tr>
                                    <td style="text-align: center;">
                                        <div style="display: flex; justify-content: center; gap: 10px;">
                                            <span style="font-family: arial; font-size: 10px;">
                                                <img src="{{ $invoice_image1 }}" style="height: 10px;"> {{ $company_mobile }}
                                            </span>
                                            <span style="font-family: arial; font-size: 10px;">
                                                <img src="{{ $invoice_image2 }}" style="height: 10px;"> {{ $company_email }}
                                            </span>
                                        </div>
                                        <div style="margin-top: 5px; font-family: arial; font-size: 10px;">
                                            <img src="{{ $invoice_image3 }}" style="height: 10px;"> {{ $company_name }}<br>
                                            {!! $company_address !!}<br>
                                            Trading No. {{ $site->site_description ?? '' }}
                                        </div>
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
