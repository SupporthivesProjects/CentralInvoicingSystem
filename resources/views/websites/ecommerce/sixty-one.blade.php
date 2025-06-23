<!DOCTYPE html>
<html>

<head>
    <title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">

                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); background-image: url('{{ $invoice_image1 }}'); background-size: 36%; background-repeat: no-repeat; background-position: left;">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;max-height: 130px;">
                            <table>
                                <tr>
                                    <td style="padding: 40px;">
                                        <img src="{{ $invoice_header_image }}" alt="" style="display: block;height:60px;">
                                    </td>
                                    <td align="right" style="padding-left: 296px; ">
                                        <h1
                                            style="float: right; margin: 0; font-family: 'Calibri'; font-weight: bold; font-size: 55px;">
                                            INVOICE</h1>
                                    </td>
                                </tr>
                                <tr style="position: relative; font-family: 'Calibri';">
                                    <!-- Left Column: Invoice From -->
                                    <td align="right"
                                        style="vertical-align: top; text-align: left; position: absolute; left: 301px;">
                                        <p style="margin: 0; font-size: 10px;"><strong>Invoice From</strong></p>
                                        <p style="margin: 5px 0;"><strong style="font-size: 12px;">{{ $site->site_name }}</strong></p>
                                        <p style="margin: 5px 0; font-size: 9px;">
                                            <a
                                                style="color: #007BFF; text-decoration: underline;">{{ $company_email }}</a>
                                        </p>
                                        <p style="margin: 5px 0; font-size: 9px;"> {!! $company_address !!} </p>
                                    </td>

                                    <!-- Right Column: Invoice No, Date, Total -->
                                    <td align="right" style="vertical-align: top; text-align: right;">
                                        <p style="margin: 0; font-size: 9px;">Invoice No :#{{ $invoice_number }}</p>
                                        <p style="margin: 0; font-size: 9px; ">Due Date :  {{ $invoice_date }}</p>
                                        <span
                                            style="margin: 0%; border-bottom: 1px solid black; display: inline-block; width: 100px;"></span>
                                        <p style="margin: 3px 0; font-size: 10px;">Total Amount Due</p>
                                        <p style="margin: 5px 0; font-size: 22px; font-weight: bold;">{{ site_currency() . number_format($invoice_amount, 2) }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td
                            style="padding:40px;padding-top:0px;background: url(img/body_bg.png) no-repeat;background-position: center;background-size: cover;height:444px;">
                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="border-collapse: collapse; background-color: #f7f7f7; font-family: 'Calibri';">
                                <!-- Header Row -->
                                <tr>
                                    <th align="left" colspan="1"
                                        style="background-color: #FFC107; color: #000; font-weight: bold; font-size: 16px;">PRODUCT
                                        DESCRIPTION</th>
                                    <th align="center" style="background-color: #333; color: #fff; font-weight: bold; font-size: 16px;">
                                        UNIT PRICE</th>
                                    <th align="center" style="background-color: #333; color: #fff; font-weight: bold; font-size: 16px;">
                                        QTY</th>
                                    <th align="center" style="background-color: #333; color: #fff; font-weight: bold; font-size: 16px;">
                                        TOTAL</th>
                                </tr>

                                @foreach($products as $index => $product)
                                <tr>
                                    <td style="font-size: 12px;">{{ $product->name }}<br><span style="font-size: 10px;">{{ $product->category_name }}</span> </td>
                                    <td style="font-size: 10px;" align="center">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                    <td style="font-size: 10px;" align="center">1</td>
                                    <td style="font-size: 10px;" align="center">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                </tr>
                                @endforeach
                            </table>

                            <!-- Totals Section -->
                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="border-collapse: collapse; margin-top: 30px; font-family: 'Calibri';">
                                <tr>
                                    <!-- Left Side: Contact Info -->
                                    <td width="50%" valign="top"
                                        style="color: white;">
                                        <table cellpadding="5" cellspacing="0">
                                            <tr>
                                                <td><img src="{{ $invoice_image2 }}" alt="" style="width: 20px; margin-bottom: -5px;"></td>
                                                <td><a
                                                        style="color: white; text-decoration: none; font-size: 9px;">{{ $company_email }}</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><img src="{{ $invoice_image3 }}" alt="" style="width: 20px;"></td>
                                                <td style="font-size: 9px;" >{!! $company_address !!}</td>
                                            </tr>
                                        </table>
                                    </td>

                                    <!-- Right Side: Totals -->
                                    <td width="50%" valign="top" style="text-align: right;">
                                        <table align="right" cellpadding="4" cellspacing="0" style="font-family: 'Calibri'; font-size: 12px;">
                                            <tr>
                                                <td style="text-align: right;">Sub Total</td>
                                                <td style="text-align: right;">{{ site_currency() . number_format(($invoice_amount + $discount_amount), 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right;">Discount</td>
                                                <td style="text-align: right;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                            </tr>
                                           
                                            <tr>
                                                <td style="text-align: right; font-weight: bold; font-size: 16px;">GRAND
                                                    TOTAL</td>
                                                <td style="text-align: right; font-weight: bold; font-size: 16px;">
                                                    {{ site_currency() . number_format($invoice_amount, 2) }} </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-----------Footer End----------->
                </table>
            </td>
        </tr>
    </table>
</body>

</html>