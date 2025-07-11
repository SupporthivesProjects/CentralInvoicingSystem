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
                                    <td style="background: url('{{ $invoice_header_image }}') no-repeat center;background-size: cover;height: 93px;">
                                        <p
                                            style="color: white; margin-left: 43%; font-family: 'Century Schoolbook'; font-size: 28px;">
                                            Invoice</p>
                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td
                            style="padding:40px;padding-top:0px;background: url('{{ $invoice_image1 }}'); background-repeat: no-repeat;background-position: center;background-size: cover;height:444px; font-family: 'Avenir Black ';">

                            <!-- Invoice Header -->
                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="border-collapse: collapse; font-size: 11px;">
                                <tr>
                                    <td>
                                        <strong style="font-size: 12px;">INVOICE NUMBER</strong><br>
                                        {{ $invoice_number }}
                                    </td>
                                    <td>
                                        <strong style="font-size: 12px;">INVOICE DATE</strong><br>
                                        {{ $invoice_date }}
                                    </td>
                                    <td align="right">
                                        <img src="{{ $company_logo }}" alt="Verbryte Logo" style="max-height: 60px;">
                                    </td>
                                </tr>
                            </table>

                            <!-- Customer & Business Details -->
                            <table width="70%" cellpadding="8" cellspacing="0"
                                style="border-collapse: collapse; font-size: 11px;">
                                <tr>
                                    <td valign="top">
                                        <strong style="font-size: 12px;">CUSTOMER DETAILS</strong><br>
                                        {{ $customer_name }}
                                    </td>
                                    <td valign="top">
                                        <strong style="font-size: 12px;">BUSINESS DETAILS</strong><br>
                                        {!! $company_address !!}
                                    </td>
                                    <td valign="top" align="right">
                                        <br>
                                        {{ $company_mobile }}<br>
                                        {{ $company_email }}<br>
                                        {{ $site_name }}
                                    </td>
                                </tr>
                            </table>

                            <!-- Invoice Table -->
                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="border-collapse: collapse; margin-top: 20px;">
                                <tr style="background-color: #000; color: #fff; font-size: 11px;">
                                    <th align="left" style="font-size: 12px;">DESCRIPTION</th>
                                    <th align="center" style="font-size: 12px;">IMAGES</th>
                                    <th align="center" style="font-size: 12px;">WORDS</th>
                                    <th align="right" style="font-size: 12px;">AMOUNT</th>
                                </tr>
                                @foreach($products as $product)
                                <tr style="border-bottom: 1px solid #ccc; background-color: #f2f2f2;">
                                    <td>{{ $product->name }}</td>
                                    <td align="center">{{ $product->imagecount }}</td>
                                    <td align="center">{{ $product->wordcount }}</td>
                                    <td align="right">{{ site_currency() }} {{ number_format($product->unit_price, 2) }}</td>
                                </tr>
                                @endforeach
                            </table>

                            <!-- Totals -->
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse: collapse; margin-top: 10px;">
                                <tr>
                                    <!-- Left Side: Subtotal & Discount -->
                                    <td style="width: 70%; vertical-align: top;">
                                        <table width="100%" cellpadding="6" cellspacing="0"
                                            style="border-collapse: collapse;">
                                            <tr>
                                                <td style="color: #555; font-size: 11px;">SUBTOTAL</td>
                                                <td align="right" style="color: #f15a24; font-size: 11px;">
                                                    {{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="border-top: 1px solid #ccc;"></td>
                                            </tr>
                                            <tr>
                                                <td style="color: #555; font-size: 11px;">DISCOUNT</td>
                                                <td align="right" style="color: #f15a24; font-size: 11px;">
                                                    - {{ site_currency() }} {{ number_format($discount_amount, 2) }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>

                                    <!-- Right Side: Invoice Total -->
                                    <td style="width: 30%; text-align: right; vertical-align: middle;">
                                        <div style="font-weight: bold; color: #111; font-size: 10px;">INVOICE TOTAL</div>
                                        <div style="color: #f15a24; font-size: 24px; font-weight: bold;">
                                            {{ site_currency() }} {{ number_format($invoice_amount, 2) }}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr
                                    style="font-size: 10px; font-family: 'Cambria ';">
                                    <img src="{{ $invoice_footer_image }}" alt="">
                                </tr>
                                <tr>
                            </table>
                        </td>
                    </tr>
                    <!-----------Footer End----------->
                </table>
            </td>
        </tr>
    </table>
</body>

</html>