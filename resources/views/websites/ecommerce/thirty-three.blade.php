<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }

        thead {
            background-color: #F4C542;
            color: white;
        }

        .table-data {
            border-collapse: collapse;
            width: 100%;
            max-width: 850px;
            margin: 0 auto;
        }

        .table-data th {
            font-family: arial;
            font-size: 16px;
            margin: 0px;
            font-weight: 900;
            color: #000;
        }

        .table-data td {
            font-family: arial;
            font-size: 14px;
            margin: 0px;
            font-weight: 400;
            color: #000;
        }

        .table-data th,
        .table-data td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }

        .table-data th:first-child {
            text-align: left;
        }

        .table-data td:last-child,
        .table-data th:last-child {
            text-align: end;
        }

        .table-data tr:last-child td:last-child {
            background-color: #F4C542;
            border-bottom: 0px solid;
        }

        .table-data tr:last-child td:nth-last-child(2) {
            background-color: #F4C542;
            border-bottom: 0px solid;
        }
    </style>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
        <tr>
            <td style="background: url('{{ $company_logo }}') no-repeat; background-size: cover; height: 100%;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td
                            style="background: url('{{ $invoice_header_image }}')no-repeat; background-size:  cover; height: 136px; background-position:  center center;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px 60px;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0"
                                style="border-collapse: collapse;">
                                <tr>
                                    <td style="width: 100%;padding-left: 50px;">
                                        <p
                                            style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; margin-bottom:5px;">
                                            <b
                                                style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 700;">Date:</b>
                                            {{ $invoice_date }}
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <b style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 700;">Invoice
                                                Number:</b> #{{ $invoice_number }}
                                        </p>
                                    </td>
                                    <td style= "padding-right: 50px;">
                                        <h2 style="font-family: arial;font-size: 30px;margin: 0px;font-weight: 700;">
                                            <b>INVOICE</b></h2>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding-top: 30px;padding-left: 50px;">
                                        <p
                                            style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400; margin-bottom: 5px;">
                                            Billed From:</p>
                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            {{ $site_name }}</p>
                                    </td>
                                    <td style="text-align: end; padding-top: 30px;padding-right: 50px;">
                                        <p
                                            style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400; margin-bottom: 5px;">
                                            <b>Billed To:</b></p>
                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            {{ $customer_name }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <table style="border-spacing: 50px 40px;">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div
                                                        style="background: url('{{ $invoice_image1 }}') no-repeat; background-position: center center; background-size: cover;width: 250px; height: 150px; max-width: 100%; display: flex;flex-direction: column;justify-content: end;padding-bottom: 24px; margin: auto;padding-left: 17px;">
                                                        <p
                                                            style="font-family: arial;font-size: 10px;margin: 10px;font-weight: 400;color: #F4C542;">
                                                            Phone </p>
                                                        <p
                                                            style="font-family: arial;font-size: 10px; margin: 0px; font-weight: 400; margin-bottom: 13px; margin-top: 5px;color: white;padding-left: 10px;">
                                                            {{ $company_phone ?? 'N/A' }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div
                                                        style="background: url('{{ $invoice_image2 }}') no-repeat; background-position: center center; background-size: cover;width: 250px; height: 150px; max-width: 100%; display: flex;flex-direction: column;justify-content: end;padding-bottom: 24px;  margin: auto;padding-left: 17px;">
                                                        <p
                                                            style="font-family: arial;font-size: 10px;margin: 3px;font-weight: 400;color: #F4C542;">
                                                            Address</p>
                                                        <p
                                                            style="font-family: arial;font-size: 10px; margin: 0px; font-weight: 400; margin-bottom: -3px; margin-top: 5px;color: white;padding-left: 5px;">
                                                            {!! $company_address ?? 'N/A' !!}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div
                                                        style="background: url('{{ $invoice_image3 }}') no-repeat; background-position: center center; background-size: cover;width: 250px; height: 150px; max-width: 100%; display: flex;flex-direction: column;justify-content: end;padding-bottom: 24px;  margin: auto;padding-left: 17px;">
                                                        <p
                                                            style="font-family: arial;font-size: 10px;margin: 10px;font-weight: 400;color: #F4C542;">
                                                            Email</p>
                                                        <p
                                                            style="font-family: arial;font-size: 10px; margin: 0px; font-weight: 400; margin-bottom: 13px; margin-top: 5px;color: white;padding-left: 10px;">
                                                            {{ $company_email ?? 'N/A' }}
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div style="min-height: 800px !important;">
                                        <table class="table-data">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Product</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($products as $product)
                                                    <tr>
                                                        <td>#{{ $loop->iteration }}</td>
                                                        <td>{{ $product->name }}</td>
                                                        <td>{{ $product->quantity ?? 1 }}</td>
                                                        <td>{{ site_currency() . number_format($product->unit_price, 2) }}
                                                        </td>
                                                        <td>{{ site_currency() . number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                <tr>
                                                    <td colspan="2" style="border-bottom: 0px;"></td>
                                                    <td colspan="2">Subtotal</td>
                                                    <td>{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="border-bottom: 0px;"></td>
                                                    <td colspan="2" style="border-bottom: 0px solid;">Discount</td>
                                                    <td style="border-bottom: 0px solid;">
                                                        {{ site_currency() . number_format($discount_amount, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="border-bottom: 0px;"></td>
                                                    <td colspan="2">Grand Total</td>
                                                    <td>{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </tr>
                                <tr>
                                    <td
                                        style="background: url('{{ $invoice_footer_image }}')no-repeat; background-size:  cover; height: 190px; background-position:  center center;bottom: 10px;">
                                        <p
                                            style="text-align: center;font-family: arial;font-size: 15px;margin-top: 110px;font-weight:700;color:whitesmoke;">
                                            Sharahla Solutions FZ-LLC<br>
                                            FDRK5710 Compass Building,Al Shohada Road, AL Hamra Industrial Zone-FZ, Ras
                                            Al Khaimah, United Arab Emirates.<br>
                                            Trading No. 45002243
                                        </p>
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
