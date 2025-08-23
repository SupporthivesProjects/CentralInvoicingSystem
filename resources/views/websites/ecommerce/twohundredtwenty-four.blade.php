<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        * {
            margin: 0px;
            padding: 0px;
        }
    </style>
</head>

<body style="margin: 0; padding: 40px 0;  font-family: Arial, sans-serif;">

    <!-- Main White Invoice Table -->
    <table align="center" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td
                style="color: #000;border-radius: 10px; overflow: hidden; background: url('{{ $invoice_image1 }}') no-repeat; background-size:100% 100%;background-position:center;height:100vh;">
                <table align="center" width="100%" cellpadding="0" cellspacing="0" width="100%">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 20px;">
                            <table width="100%">
                                <tr>
                                    <td style="width: 70%;">
                                        <img src="{{ $company_logo }}" alt="" width="100px">
                                        <p style="font-size: 8px; line-height: 1.4; margin-top: 15px;">
                                            {{ $company_address }}<br>
                                            {{ $company_email }}<br>
                                        </p>
                                    </td>
                                    <td style="text-align: right; vertical-align: top;">
                                        <div
                                            style="background-color: #ffc680; padding: 10px 20px; font-weight: bold; font-size: 40px; border-radius: 50px;">
                                            INVOICE</div>
                                             {{ $company_logo }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Invoice Date & Number -->
                    <tr style="position: relative;">
                        <td style="padding: 0 20px 10px 20px; position: absolute; right: 10px; top: -55px;">
                            <table width="100%">
                                <tr>
                                    <td></td>
                                    <td style="text-align: right; font-weight: bold; font-size: 11px;">
                                        <span
                                            style="background-color: #7ebbf3; padding: 5px 15px; border-radius: 15px; font-size: 11px; margin-right: 10px;">Invoice
                                            Date</span>
                                        <span
                                            style="background-color: #ffb6a3; padding: 5px 15px; border-radius: 15px; font-size: 11px;">Invoice
                                            No.</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align:center ; padding-top: 10px; font-size: 11px;">
                                        <span style="margin-right:45px;">{{ $invoice_date }}</span>
                                        <span>{{ $invoice_number }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Invoice To -->
                    <tr style="position: relative;">
                        <td
                            style="padding: 20px; padding-bottom: 10px; position: absolute; width: 300px; left: 25px; top: 25px;">
                            <div style="background-color: #f79d7c; padding: 15px 20px; border-radius: 25px;">
                                <p style="margin: 0; font-size: 18px; color: black; font-weight: 700;">Invoice To</p>
                                <h2 style="margin: 5px 0 0 0; color: #333;">{{ $customer_name }}</h2>
                            </div>
                        </td>
                    </tr>

                    <!-- Invoice Items -->
                    <tr>
                        <td style="padding: 190px 20px 0px;">
                            <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
                                <thead>
                                    <tr
                                        style="background-color: #7ebbf3; color: #000; font-size: 11px; font-weight: bold;">
                                        <th align="left"
                                            style="padding: 12px; border-top-left-radius: 12px; border-bottom-left-radius: 12px;">
                                            ITEM DESCRIPTION</th>
                                        <th align="center" style="padding: 12px;">UNIT PRICE</th>
                                        <th align="center" style="padding: 12px;">QTY</th>
                                        <th align="right"
                                            style="padding: 12px; border-top-right-radius: 12px; border-bottom-right-radius: 12px;">
                                            TOTAL</th>
                                    </tr>
                                </thead>
                                <!-- Repeating Item Rows -->
                                @foreach ($products as $product)
                                    <tr style="background-color: #fde7c8; font-size: 9px;">
                                        <td>{{ $product->name }}</td>
                                        <td align="center">{{ site_currency() }}
                                            {{ number_format($product->unit_price, 2) }}</td>
                                        <td align="center">1</td>
                                        <td align="right">{{ site_currency() }}
                                            {{ number_format($product->unit_price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>

                    <!-- Totals Section -->
                    <tr>
                        <td style="padding: 20px 20px 130px;">
                            <table align="right"
                                style="width: 200px; font-family: Arial, sans-serif; font-size: 10px;">
                                <tr>
                                    <td colspan="2"
                                        style="background-color: #7ebbf3;border-radius: 30px;padding: 10px 16px;color: #000;font-weight: 600;display: flex;justify-content: space-between;">
                                        <span>Sub Total</span>
                                        <span>{{ site_currency() }}
                                            {{ number_format($invoice_amount + $discount_amount, 2) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 10px;"></td>
                                </tr> <!-- spacing -->

                                <tr>
                                    <td colspan="2"
                                        style="background-color: #f79d7c;border-radius: 30px;padding: 10px 16px;color: #000;font-weight: 600;display: flex;justify-content: space-between;">
                                        <span>Discount</span>
                                        <span>{{ site_currency() }} {{ number_format($discount_amount, 2) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 10px;"></td>
                                </tr> <!-- spacing -->

                                <tr>
                                    <td colspan="2"
                                        style="background-color: #ffffff;border-radius: 30px;padding: 10px 16px;color: #000;font-weight: 700;display: flex;justify-content: space-between;">
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
