<!DOCTYPE html>
<html>

<head>
    <title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        *{
          margin:0px;
          padding:0px;
        }
    </style>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #ffffff;">

    <!-- Outer Table with Background -->
    <table width="100%" cellpadding="0" cellspacing="0"
        style="background: url('{{ $invoice_image1 }}') no-repeat center top; background-size:100% 100%;">
        <tr>
            <td align="center" style="vertical-align:">
                <!-- White Box Container -->
                <table width="80%" cellpadding="0" cellspacing="0" style="margin-top:100px;height:92vh;">

                    <!-- Invoice Header -->
                    <tr>
                        <td style="padding: 10px 0; font-size: 14px;">
                            <strong>INVOICE NO.:</strong> {{ $invoice_number }}
                            <span style="color: red; padding: 0 10px;">|</span>
                            <strong>INVOICE DATE:</strong> {{ $invoice_date }}
                        </td>
                    </tr>

                    <!-- Billing Info -->
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse: collapse; font-family: Arial, sans-serif; border: 1px solid #000000; font-size: 9px;">
                                <tr>
                                    <!-- Bill To Header -->
                                    <td
                                        style="width: 50%; background-color: #810000; color: #ffffff; padding: 8px; border-right: 1px solid #000000; font-weight: bold;">
                                        Bill to
                                    </td>
                                    <!-- Bill From Header -->
                                    <td
                                        style="width: 50%; background-color: #810000; color: #ffffff; padding: 8px; font-weight: bold;">
                                        Bill from
                                    </td>
                                </tr>
                                <tr>
                                    <!-- Bill To Content -->
                                    <td
                                        style="padding: 10px; vertical-align: top; font-size: 13px; border-right: 1px solid #000000;">
                                        <table cellpadding="5" cellspacing="0" style="width: 100%; font-size: 9px;">
                                            <tr>
                                                <td style="font-weight: bold;">Name</td>
                                                <td>{{ $customer_name }}</td>
                                            </tr>
                                        </table>
                                    </td>

                                    <!-- Bill From Content -->
                                    <td style="padding: 10px; vertical-align: top; font-size: 13px;">
                                        <table cellpadding="5" cellspacing="0" style="width: 100%; font-size: 8px;">
                                            <tr>
                                                <td style="font-weight: bold;">Name</td>
                                                <td>{{ $company_name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; vertical-align: top;">Address</td>
                                                <td>
                                                    {{ $company_address }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold;">Email</td>
                                                <td>{{ $company_email }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>


                        </td>
                    </tr>

                    <!-- Service Table -->
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0" border="1"
                                style="font-size: 9px; border-collapse: collapse; margin-bottom: 20px; margin-top: 20px;">
                                <tr style="background-color: #810000; color: #ffffff; border: 1px solid black; ">
                                    <th style="padding: 8px;     text-align: left;">Qty.</th>
                                    <th style="padding: 8px;     text-align: left;">Service Type</th>
                                    <th style="padding: 8px;     text-align: right;">Pages</th>
                                    <th style="padding: 8px;     text-align: right;">Words</th>
                                    <th style="padding: 8px;     text-align: right;">Total</th>
                                </tr>
                                @foreach ($products as $product)
                                    <tr style="border: 1px solid black;">
                                        <td style="padding: 8px;   text-align: left;">1</td>
                                        <td style="padding: 8px;   text-align: left;">{{ $product->name }}</td>
                                        <td style="padding: 8px;   text-align: right;">{{ $product->pages }} </td>
                                        <td style="padding: 8px;   text-align: right;">{{ $product->unit_type }}</td>
                                        <td style="padding: 8px;   text-align: right;">
                                            {{ site_currency() . number_format($product->line_total, 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr style="border: 1px solid black;">
                                    <td colspan="1" style="text-align: right; padding: 8px;"></td>
                                    <td colspan="1" style="text-align: right; padding: 8px;"></td>
                                    <td colspan="1" style="text-align: right; padding: 8px;"></td>
                                    <td colspan="1" style="text-align: right; padding: 8px;"></td>
                                    <td style="padding: 8px;   text-align: right;"></td>
                                </tr>
                                <tr style="border: 1px solid black;">
                                    <td colspan="1" style="text-align: right; padding: 8px;"></td>
                                    <td colspan="1" style="text-align: right; padding: 8px;"></td>
                                    <td colspan="1" style="text-align: right; padding: 8px;"></td>
                                    <td colspan="1" style="text-align: right; padding: 8px;"></td>
                                    <td style="padding: 8px;   text-align: right;"></td>
                                </tr>
                                <tr style="border: none;">
                                    <td colspan="1" style="text-align: right; padding: 8px;"></td>
                                    <td colspan="1" style="text-align: right; padding: 8px;"></td>
                                    <td colspan="1" style="text-align: right; padding: 8px;"></td>
                                    <td colspan="1"
                                        style="text-align: right; padding: 8px; border: 1px solid black;">
                                        Subtotal</td>
                                    <td style="padding: 8px;   text-align: right;  border: 1px solid black;">
                                        {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                    </td>
                                </tr>
                                <tr style="border: none;">
                                    <td colspan="1" style="text-align: right; padding: 8px;"></td>
                                    <td colspan="1" style="text-align: right; padding: 8px;"></td>
                                    <td colspan="1" style="text-align: right; padding: 8px;"></td>
                                    <td colspan="1"
                                        style="text-align: right; padding: 8px;  border: 1px solid black;">
                                        Discount Total</td>
                                    <td style="padding: 8px;   text-align: right; border: 1px solid black;">278.00</td>
                                </tr>
                                <tr style="font-size: 11px; border: none;">
                                    <td colspan="1" style="text-align: right; padding: 8px;"></td>
                                    <td colspan="1" style="text-align: right; padding: 8px;"></td>
                                    <td colspan="1" style="text-align: right; padding: 8px;"></td>
                                    <td colspan="1"
                                        style="text-align: right; padding: 8px; background-color: #810000; color: white; border: 1px solid black;">
                                        <strong>Total</strong>
                                    </td>
                                    <td
                                        style="padding: 8px;   text-align: right; background-color: #810000; color: white; border: 1px solid black;">
                                        <strong>{{ site_currency() . number_format($invoice_amount, 2) }}</strong>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="text-align: center; font-size: 10px; color: #555; padding-top: 10px;">
                            {{ $company_email }} <span style="color: red; padding: 0 10px;">|</span>
                            {{ $site->site_name }}
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
