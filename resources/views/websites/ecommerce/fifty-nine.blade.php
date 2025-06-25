<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#F8F8F8" style="padding: 00px 0;">
                <table width="90%" cellspacing="0" cellpadding="0" border="0" bgcolor="#FDF4EE"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0; height: 130px;">
                            <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                                <tr>
                                    <td style="background: url('{{ $invoice_header_image }}') no-repeat center;background-size: cover;height: 130px;">
                                        <table width="100%">
                                            <tr style="position: relative;">
                                                <td align="left" style="padding-left: 30px;">
                                                    <img src="{{ $invoice_image1 }}" alt=""
                                                        style="width: 215px; position: absolute; top: 85px; right: 383px;">
                                                    <p
                                                        style=" position: absolute; top: 47px; right: 413px; font-family: 'Calibri'; font-size: 36px; color: white;">
                                                        INVOICE</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="right" style="padding-right: 65px;">
                                                    <p
                                                        style="font-family: 'Bahnschrift'; font-size: 14px; color: white;">
                                                        {!! $company_address !!} <br>{{ $company_email }}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Header End -->

                    <!-- Content -->
                    <tr>
                        <td
                            style="padding:40px;padding-top:0px;background:#F8F8F8; background-repeat: no-repeat;background-position: center;background-size: cover;height:444px; font-family: 'Yu Gothic';">
                            <table>
                                <br>
                                <tr>
                                    <td width="100%" style="vertical-align: top;">
                                        <table width="100%">
                                            <tr>
                                                <td align="right"
                                                    style="padding-left: 270px; font-family: 'Bahnschrift'; font-size: 12px;">
                                                    <p style="margin: 0;"><b>Invoice #:{{ $invoice_number }}</b></p>
                                                </td>
                                                <td align="right"
                                                    style="font-family: 'Bahnschrift'; font-size: 12px; padding-left: 20px;">
                                                    <p style="margin: 0;"><b>Date: {{ $invoice_date }}</b></p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <p style="font-family: 'Bahnschrift'; font-size: 11px;"><b>Billed To:</b><br>{{ $customer_name }}
                            </p>
                            <br>
                            <div style="min-height: 500px !important;">
                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="border-collapse: collapse; font-family: 'Bahnschrift'; font-size: 11px;">
                                <tr style="background-color: #1D014D; color: white;">
                                    <th align="left" style="padding: 12px;">PRODUCT</th>
                                    <th align="center" style="padding: 12px;">PRICE</th>
                                    <th align="center" style="padding: 12px;">QTY</th>
                                    <th align="right" style="padding: 12px;">TOTAL</th>
                                </tr>

                                @foreach($products as $index => $product)
                                <tr style="background-color: #ffffff;">
                                    <td> {{ $product->name }}<br>
                                        <span style="color: #666; font-size: 10px;">{{ $product->category_name }}</span>
                                    </td>
                                    <td align="center">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                    <td align="center">1</td>
                                    <td align="right">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                </tr>
                                @endforeach
                               
                            </table>


                            <table align="right" cellpadding="10" cellspacing="0"
                                style="margin-top: 20px; width: 245px; border-collapse: collapse; border: 1px solid #000000; background-color: #fafafa; font-family: 'Bahnschrift'; font-size: 11px;">
                                <tr>
                                    <td style="color: #555;">Subtotal</td>
                                    <td align="right" style="color: #555;">{{ site_currency() . number_format(($invoice_amount + $discount_amount), 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #555; ">Taxes</td>
                                    <td align="right" style="color: #555;">{{ site_currency() }}0.00</td>
                                </tr>
                                <tr>
                                    <td style="color: #555;">Discount</td>
                                    <td align="right" style="color: #555;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr style="border-top: 1px solid #000000;">
                                    <td style="color: #C5267A; font-weight: bold;">GRANT TOTAL</td>
                                    <td align="right" style="color: #C5267A; font-weight: bold;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                        </td>
                    </tr>
                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr
                                    style="background: url('{{ $invoice_footer_image }}') no-repeat;background-position: center;background-size: cover;height:75px;padding:50px;background-size:cover;width: 100%;">
                                    <td>

                                    </td>
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