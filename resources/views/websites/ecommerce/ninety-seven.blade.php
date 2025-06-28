<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="background-image: url('{{ $invoice_image1 }}'); background-repeat: no-repeat; background-position: center; background-size: cover;">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;max-height: 130px;">
                            <table>
                                <tr>
                                    <td style="vertical-align: top; padding: 103px 40px 40px">
                                        <h2 style="color: #f4a300; margin: 0; font-family: 'Nunito'; font-size: 12px;">
                                          {{ $company_name  }}</h2>
                                        <p
                                            style="line-height: 1.5; margin: 5px 0; font-family: 'Nunito'; font-size: 9px;">
                                            {!! $company_address  !!}
                                        </p>
                                    </td>
                                    <td
                                        style="padding: 40px; text-align: right; position: relative; left: 75px; top: 32px;">
                                        <img src="{{ $company_logo }}" alt="" style="width: 170px;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="padding:40px;padding-top:0px;background: url('{{ $invoice_image1 }}') no-repeat;background-position: center;background-size: cover;height:444px;">
                            <br>
                            <table
                                style="width: 100%; border-top: 1px solid orange; border-bottom: 1px solid orange; border-collapse: collapse; padding-top: 10px; padding-bottom: 10px; font-family: 'Nunito'; font-size: 10px;">
                                <tr>
                                    <td style="padding: 10px;">
                                        <span style="color: orange; font-weight: bold;">Invoice Number</span><br>
                                        <span
                                            style=" font-family: 'Nunito'; font-size: 9px; line-height: 18px;">{{ $invoice_number }}</span>
                                    </td>
                                    <td style="padding: 10px;">
                                        <span style="color: orange; font-weight: bold;">Date</span><br>
                                        <span style=" font-family: 'Nunito'; font-size: 9px; line-height: 18px;">{{ $invoice_date }}</span>
                                    </td>
                                    <td style="padding: 10px;">
                                        <span style="color: orange; font-weight: bold;">To</span><br>
                                        <span
                                            style=" font-family: 'Nunito'; font-size: 9px; line-height: 18px;">{{ $customer_name }}</span>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <table
                                style="width: 100%; border-collapse: collapse; font-family: 'Nunito'; font-size: 10px;">
                                <thead>
                                    <tr style="background-color: orange; color: white;">
                                        <th style="padding: 8px; text-align: left; border: 1px solid orange;">Quantity
                                        </th>
                                        <th style="padding: 8px; text-align: left; border: 1px solid orange;">
                                            Description</th>
                                        <th style="padding: 8px; text-align: right; border: 1px solid orange;">Unit
                                            Price</th>
                                        <th style="padding: 8px; text-align: right; border: 1px solid orange;">Total
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td style="padding: 8px; border-bottom: 1px solid black;">1</td>
                                        <td style="padding: 8px; border-bottom: 1px solid black;">{{ $product->name }} - {{ $product->category_name }}
                                        </td>
                                        <td style="padding: 8px; text-align: right; border-bottom: 1px solid black;">
                                        {{ site_currency() }} {{  number_format($product->unit_price, 2) }}</td>
                                        <td style="padding: 8px; text-align: right; border-bottom: 1px solid black;">
                                        {{ site_currency() }} {{  number_format($product->unit_price, 2) }}</td>
                                    </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="3" style="text-align: right; padding: 8px;">Subtotal</td>
                                        <td style="text-align: right; padding: 8px;">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="text-align: right; padding: 8px;">Discount Total</td>
                                        <td style="text-align: right; padding: 8px;">{{ site_currency() }} {{ number_format($invoice_amount, 2) }}</td>
                                    </tr>
                                    <tr style="border-top: 2px solid orange;">
                                        <td colspan="3"
                                            style="text-align: right; padding: 8px; font-weight: bold; border-top: 1px solid orange;">
                                            Total</td>
                                        <td
                                            style="text-align: right; padding: 8px; font-weight: bold; border-top: 1px solid orange;">
                                            {{ site_currency() }} {{ number_format($discount_amount, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p
                                style="text-align: right; font-family: 'Nunito'; font-size: 11px; color: orange; padding-top: 10px; margin: 0%;">
                                Thank you for your business!
                            </p>
                           

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;">
                                <tr style="position: relative; left: 258px; bottom: 15px;">
                                    <td style="text-align: center;">
                                        <img src="{{ $invoice_image2 }}" alt="" width="10px">
                                    </td>
                                    <td style="color: black; padding-left: 4px; font-family: 'Nunito'; font-size: 8px;">
                                        00971-564257851
                                    </td>
                                </tr>
                                <tr style="position: relative; left: 221px; bottom: 18px;">
                                    <td style="text-align: center;">
                                        <img src="{{ $invoice_image3 }}" alt="" width="10px">
                                    </td>
                                    <td style="color: black; font-family: 'Nunito'; font-size: 8px;">
                                       {{ $company_email }}
                                    </td>
                                </tr>
                                <tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>