<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0; height: 90px;">
                            <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                                <tr style="position: relative;">
                                    <td style="
                                        background: url('{{ $invoice_header_image }}') no-repeat center;
                                        background-size: cover;
                                        height: 150px;">

                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td
                            style="padding:40px;padding-top:0px;background: url('{{ $invoice_image1 }}'); background-repeat: no-repeat;background-position: center;background-size: cover;height:608px; font-family: 'Sen'; vertical-align: top;">
                            <h2 style="text-align: center; font-size: 24px; font-weight: normal; font-weight: bold;">
                                Invoice #.  {{ $invoice_number }}
                            </h2>

                            <!-- Date and Billing Info -->
                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="border-collapse: collapse; margin-bottom: 20px; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; font-size: 11px;">
                                <tr>
                                    <td align="center">
                                        <strong>Purchase Date</strong><br>
                                         {{ $invoice_date }}
                                    </td>
                                    <td align="center">
                                        <strong>Billed To</strong><br>
                                        {{ $customer_name }}
                                    </td>
                                </tr>
                            </table>

                            <div style="min-height: 500px !important">
                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="border-collapse: collapse; margin-top: 10px; font-size: 9px;">
                                <tr
                                    style="background-color: #142052; color: white; text-align: center; font-weight: bold;">
                                    <td>QTY.</td>
                                    <td>DESCRIPTION</td>
                                    <td>QUALITY</td>
                                    <td>TURNAROUND</td>
                                    <td>IMAGERY</td>
                                    <td>BILLING CYCLE</td>
                                    <td>TOTAL</td>
                                </tr>

                                @foreach($products as $product)
                                <tr style="text-align: center; border-bottom: 1px solid #ccc;">
                                    <td>1</td>
                                    <td align="left">{{ $product->name }}</td>
                                    <td>{{ $product->quality }}</td>
                                    <td> {{ $product->delivery }}</td>
                                    <td>{{ $product->imagecount }}</td>
                                    <td>{{ site_currency() }} {{ number_format($product->unit_price, 2) }}</td>
                                    <td>{{ site_currency() }} {{ number_format($product->unit_price, 2) }}</td>
                                </tr>
                                @endforeach
                                <tr style="background-color: #F2F2F2; border-bottom: 1px solid #ccc;">
                                    <td colspan="5"></td>
                                    <td align="right" style="color: #666;">Item total</td>
                                    <td align="right">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ccc;">
                                    <td colspan="5"></td>
                                    <td align="right" style="color: #666;">Coupon Used</td>
                                    <td align="right">{{ site_currency() }} {{ number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr style="background-color: #f2f2f2; font-size: 11px; border-bottom: 1px solid #ccc;">
                                    <td colspan="5"></td>
                                    <td align="right"><strong>TOTAL</strong></td>
                                    <td align="right"><strong>{{ site_currency() }} {{ number_format($invoice_amount, 2) }}</strong></td>
                                </tr>

                            </table>
                            </div>

                            <!-- Totals Section -->

                          

                            <table width="100%" align="center" cellpadding="0" cellspacing="0"
                                style=" text-align: center;">
                                <tr>
                                    <td>
                                        <span style="font-weight: bold; font-size: 9px;">TEL:</span>
                                        <span style="font-size: 10px;">{{ $company_mobile }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span style="font-weight: bold; font-size: 9px;">EMAIL:</span>
                                        <span style="font-size: 10px;">{{ $company_email }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span style="font-weight: bold; font-size: 9px;">ADDRESS:</span>
                                        <span style="font-size: 10px;">{!! $company_address !!}</span>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr>
                        <td>

                        </td>
                    </tr>
                    <!-----------Footer End----------->
                </table>
            </td>
        </tr>
    </table>
</body>

</html>