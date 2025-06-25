<!DOCTYPE html>
<html>

<head>
    <title>{{ $company_name . "Invoice" }}</title>
    <meta charset="UTF-8">
</head>

<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color: #f2f2f2;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">

                    <!-- Header -->
                    <tr>
                        <td>
                            <table width="100%"
                                style="background-image: url('{{ $invoice_header_image }}'); color: #ffffff; margin-top: 40px; height: 165px;"
                                cellpadding="10">
                                <tr>
                                    <td align="right" width="33%" style="font-size: 17px;">
                                        <strong style="font-size: 11px;">Invoiced From</strong><br>
                                        {{ $site->name }}
                                    </td>
                                    <td align="center" width="34%" style="position: relative;">
                                        <img src="{{ $invoice_image2 }}" alt=""
                                            style="width: 190px;position: absolute;z-index: 1;top: -3px;left: 0px;height: 167px;">
                                        <img src="{{ $company_logo }}" alt="Logo" width="150px"
                                            style="top: 56px;position: absolute;z-index: 2;left: 18px;">
                                    </td>
                                    <td align="right" width="33%">
                                        <div style="font-size: 12px;">
                                            <img src="{{ $invoice_image3 }}" width="10" style="vertical-align: middle;" />
                                            {{ $company_email ?? 'support@chromewebb.com' }}<br>
                                            {{ $company_address }}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                    <!-- Body Content with Padding -->
                    <tr>
                        <td style="padding-left: 40px; padding-right: 40px;">

                            <!-- Customer / Date / Invoice Title -->
                            <table width="100%" cellpadding="10">
                                <tr
                                    style="display: flex;justify-content: space-between;align-items: flex-end; margin: 40px 0px;">
                                    <td align="left" style="font-size:9px;"><strong>{{ $customer_name }}</strong></td>
                                    <td align="right" style="font-size:9px;">
                                        Date: <br> {{ $invoice_date }}<br> <br>
                                        <span style="font-size:28px;">INVOICE</span><br />
                                        <span style="font-size:18px;">#{{ $invoice_number }}</span><br />
                                    </td>
                                </tr>
                            </table>
                            <div style="min-height: 470px !important;">
                            <!-- Item Table -->
                            <table width="100%" cellspacing="0" cellpadding="8" style="border-collapse: collapse;">
                                <tr style="background-color: #1b4d4f; color: white;">
                                    <th align="left">No.</th>
                                    <th align="left">Item Descriptions</th>
                                    <th align="left">Rate</th>
                                    <th align="left">Qty</th>
                                    <th align="left">Price</th>
                                </tr>
                                @foreach($products as $product)
                                <tr style="background-color:#e4f3e4;">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                    <td>01</td>
                                    <td>{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                </tr>
                                @endforeach
                            </table>
                            <!-- Summary -->
                            <table width="50%" cellpadding="8" style="margin-top: 10px;margin-left: auto; border-collapse: collapse;">

                                <tr style="background-color:#e4f3e4;">
                                    <td></td>
                                    <td align="right">Sub-Total</td>
                                    <td align="right">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td align="right">Discount</td>
                                    <td align="right">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                </tr>
                            </table>

                            <!-- Grand Total -->
                            <table width="50%" cellpadding="12" style="background-color: #1b4d4f; color: white; margin-left: auto;margin-bottom: 100px;">
                                <tr>
                                    <td align="right" colspan="3" style="font-size: 16px;"><strong>Grand
                                            Total:</strong>&nbsp;<strong>
                                            {{ site_currency() . number_format($invoice_amount, 2) }}
                                            </strong></td>
                                </tr>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <!-- End Body Content -->

                    <!-- Footer -->
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr style="background: url('{{ $invoice_footer_image }}') no-repeat center/cover; height: 72px;">
                                    <td style="text-align: center;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Footer End -->

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
