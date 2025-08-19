<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
</head>

<body style="margin: 0; padding: 0;">
    <table width="100%" cellspacing="0" cellpadding="0" style="
    background-image: url('{{ $invoice_image1 }}');
    background-size: 100% 100%;
    background-repeat: no-repeat;
    font-family: Arial, sans-serif;
    color: #000;
    margin: auto;
    border-collapse: collapse;
  ">
        <!-- Header -->
        <tr>
            <td colspan="4" style="padding: 110px 30px 20px;">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <!-- Left section -->
                        <td valign="top" style="color: white; font-size: 8px;">
                            <table>
                                <tr>
                                    <td style="padding-right: 10px; font-size: 11px;">Invoice To:</td>
                                    <td><strong style="font-size: 16px;">{{ $customer_name ? $customer_name : '' }}</strong></td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td>{{ $customer_email ? $customer_email : '' }}</td>
                                </tr>
                            </table>
                        </td>

                        <!-- Right section -->
                        <td valign="top" style="color: white; font-size: 8px; padding-left: 20px;padding-top: 20px;" align="center">
                            <table>
                                <tr>
                                    <td style="padding-right: 10px;">Date:</td>
                                    <td>{{ $invoice_date }}</td>
                                </tr>
                                <tr>
                                    <td>Invoice No.:</td>
                                    <td>{{ $invoice_number }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>


        <!-- Content Box -->
        <tr>
            <td colspan="4" style="padding: 0px;">
                <div style="min-height: 900px">
                    <table width="100%" cellspacing="0" cellpadding="10"
                    style="border-collapse: collapse; font-size: 10px; margin-top: 75px;">
                    <!-- Header Row -->
                    <tr style="text-transform: uppercase; border-bottom: 1px solid #293f8c;">
                        <th align="left" style="font-weight: 600;width:50%">Item Description</th>
                        <th align="center" style="font-weight: 600;width:20%">Unit Price</th>
                        <th align="center" style="font-weight: 600;width:10%">Qty</th>
                        <th align="center" style="font-weight: 600;width:20%">Total</th>
                    </tr>

                    <!-- Repeatable Rows -->
                    @foreach ($products as $product)
                    <tr style="border-bottom: 1px solid #293f8c;">
                        <td style="font-size: 8px; line-height: 1.4;">
                            <strong>{{ $product->name }}</strong><br>
                            <span style="font-size: 8px; line-height: 1.4;">
                               
                            </span>
                        </td>
                        <td align="center">{{ site_currency() . number_format($product->unit_price ?? 0, 2) }}</td>
                        <td align="center">1</td>
                        <td align="center">{{ site_currency() . number_format($product->unit_price ?? 0, 2) }}</td>
                    </tr>
                    @endforeach
                    {{-- <tr style="border-bottom: 1px solid #293f8c;">
                        <td style="font-size: 8px; line-height: 1.4;">
                            <strong>Item Name</strong><br>
                            <span style="font-size: 8px; line-height: 1.4;">
                                Lorem ipsum <span>dolor sit amet, consectetur adipiscing elit,
                                    sed</span> do eiusmod tempor.
                            </span>
                        </td>
                        <td align="center">$50.00</td>
                        <td align="center">5</td>
                        <td align="center">$250.00</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #293f8c;">
                        <td style="font-size: 8px; line-height: 1.4;">
                            <strong>Item Name</strong><br>
                            <span style="font-size: 8px; line-height: 1.4;">
                                Lorem ipsum <span>dolor sit amet, consectetur adipiscing elit,
                                    sed</span> do eiusmod tempor.
                            </span>
                        </td>
                        <td align="center">$50.00</td>
                        <td align="center">5</td>
                        <td align="center">$250.00</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #293f8c;">
                        <td style="font-size: 8px; line-height: 1.4;">
                            <strong>Item Name</strong><br>
                            <span style="font-size: 8px; line-height: 1.4;">
                                Lorem ipsum <span>dolor sit amet, consectetur adipiscing elit,
                                    sed</span> do eiusmod tempor.
                            </span>
                        </td>
                        <td align="center">$50.00</td>
                        <td align="center">5</td>
                        <td align="center">$250.00</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #293f8c;">
                        <td style="font-size: 8px; line-height: 1.4;">
                            <strong>Item Name</strong><br>
                            <span style="font-size: 8px; line-height: 1.4;">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                    sed do eiusmod tempor.
                            </span>
                        </td>
                        <td align="center">$50.00</td>
                        <td align="center">5</td>
                        <td align="center">$250.00</td>
                    </tr> --}}

                    <!-- Summary Rows -->
                    <tr>
                        <td colspan="2" rowspan="3" style="padding-top: 30px;">
                            <strong style="font-weight: 600; font-size: 11px;">Payment Method</strong><br>
                            <span style="font-size: 8px;">Card Payment</span>
                        </td>
                        <td align="right" style="padding-top: 30px; font-size: 10px;"><strong>Subtotal</strong></td>
                        <td align="right" style="padding-top: 30px; font-size: 10px;">{{ site_currency() . number_format($invoice_amount + $discount_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td align="right"><strong>Discount</strong></td>
                        <td align="right">{{ site_currency() . number_format($discount_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td align="right" style="border-top: 2px solid #293f8c; padding-top: 10px;">
                            <strong style="font-size: 10px;">Total</strong>
                        </td>
                        <td align="right" style="border-top: 2px solid #293f8c; padding-top: 10px;">
                            <strong style="font-size: 16px;">{{ site_currency() . number_format($invoice_amount ?? 0, 2) }}</strong>
                        </td>
                    </tr>
                    </table>
                </div>
            </td>
        </tr>


        <!-- Footer -->
        <tr>
            <td colspan="4" style="padding: 60px 30px 20px 30px; color: white; font-size: 13px;">
                <table width="100%">
                    <tr>
                        <td style="font-size: 7px;">
                            <strong style="font-size: 11px;">{{ $company_name }}</strong><br>
                            <br>
                            <br>
                            {!! $company_address !!}<br>
                            {{ $company_mobile }}
                        </td>
                        <td align="center" style="font-size: 7px; padding-top: 45px;">
                            {{ $company_email }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>