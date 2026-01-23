<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>

    <link href="https://fonts.cdnfonts.com/css/calibri-light" rel="stylesheet">

    <style>
        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background: #e7e0cf;
            font-family: 'Mazzard';
        }

        * {
            box-sizing: border-box;
        }

        @font-face {
            font-family: 'Mazzard';
            src: url("{{ asset('fonts/MazzardH-Black.otf') }}");
        }

        @font-face {
            font-family: 'Mazzard';
            src: url("{{ asset('fonts/mazzard-m-regular.otf') }}");
        }

        @font-face {
            font-family: 'Mazzard M';
            src: url("{{ asset('fonts/mazzard-m-bold.otf') }}");
        }

        @font-face {
            font-family: 'centurygothic';
            src: url("{{ asset('fonts/centurygothic.ttf') }}");
        }

        @font-face {
            font-family: 'centurygothic';
            src: url("{{ asset('fonts/centurygothic_bold.ttf') }}");
        }

        table {
            border-collapse: collapse;
        }

        .table-heade {
            width: 100%;
        }

        h2 {
            font-family: 'Mazzard M';
            font-size: 24px;
            color: #ffffff;
        }

        .table-div p {
            font-family: 'centurygothic';
            color: #ffffff;
            font-size: 8px;
        }

        .addrss h4 {
            font-size: 10px;
            font-family: 'Mazzard M';
            color: #000;
        }

        .addrss p {
            font-size: 10px;
            font-family: 'Mazzard M';
            color: #000;
        }

        .table-list {
            width: 100%;
            border: 5px solid #ff7f00;
            background: #ffffff;
        }

        .table-list th {
            padding: 10px;
            font-size: 9px;
            font-family: 'Mazzard M';
            border: 1px solid #ff7f00;
            background: #ffffff;
        }

        .table-list td {
            padding: 8px;
            border: 1px solid #ff7f00;
            font-size: 10px;
            font-family: 'Mazzard';
            text-align: center;
        }

        .table-list td h6 {
            font-family: 'Mazzard M';
            font-size: 9px;
            text-align: left;
        }

        .table-right {
            width: 100%;
            border: 5px solid #ff7f00;
        }

        .table-right td {
            padding: 6px 20px;
            font-size: 10px;
            font-family: 'Mazzard';
        }

        .table-right h6 {
            font-family: 'Mazzard M';
            font-size: 10px;
        }
    </style>
</head>

<body>

<table width="100%" cellpadding="0" cellspacing="0" style="min-height:100vh; background:#e7e0cf;">
    <tr>
        <td valign="top">

            @php
                $minRows = 10;
                $rowCount = count($products);
                $padRows = $minRows - $rowCount;
            @endphp

            <!-- HEADER -->
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="
                        background: url('{{ $invoice_header_image }}') no-repeat center;
                        background-size: cover;
                        padding:50px;
                        width:100%;
                    ">
                        <h2>INVOICE</h2>

                        <table style="margin-top:10px;">
                            <tr>
                                <td>
                                    <p>Company Name</p>
                                    <p>
                                        {{ $site_name }}<br>
                                        {{ $company_email }}
                                    </p>
                                </td>
                                <td style="padding-left:30px;">
                                    <p>Address</p>
                                    <p>
                                        {{ $company_mobile }}<br>
                                        {!! $company_address !!}
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- BILL TO -->
            <table width="100%" cellpadding="0" cellspacing="0" style="padding:24px 60px;">
                <tr>
                    <td class="addrss" width="40%">
                        <h4>BILLED TO:</h4>
                        <p>{{ $customer_name }}</p>
                        <p>{{ $customer_email }}</p>
                    </td>

                    <td class="addrss" align="right">
                        <h4>Invoice #{{ $invoice_number }}</h4>
                        <h4>Date {{ $invoice_date }}</h4>
                    </td>
                </tr>
            </table>

            <!-- PRODUCTS -->
            <table width="100%" cellpadding="0" cellspacing="0" style="padding:0 56px;">
                <tr>
                    <td>
                        <table class="table-list">
                            <tr>
                                <th align="left">Product</th>
                                <th>Duration</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>

                            @foreach($products as $product)
                            <tr>
                                <td align="left"><h6>{{ $product->name }}</h6></td>
                                <td>{{ $product->subscription ?? '-' }}</td>
                                <td>1</td>
                                <td>{{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</td>
                            </tr>
                            @endforeach

                            @for ($i = 0; $i < $padRows; $i++)
                            <tr>
                                <td>&nbsp;</td><td></td><td></td><td></td>
                            </tr>
                            @endfor
                        </table>
                    </td>
                </tr>
            </table>

            <!-- TOTALS -->
            <table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 56px 120px;">
                <tr>
                    <td width="60%"></td>
                    <td>
                        <table class="table-right">
                            <tr>
                                <td>Subtotal</td>
                                <td align="right">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td align="right">{{ site_currency() }} {{ number_format($discount_amount ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td style="background:#ff7f00;"><h6>GRAND TOTAL</h6></td>
                                <td style="background:#ff7f00;" align="right">
                                    <h6>{{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}</h6>
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
