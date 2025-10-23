<!DOCTYPE html>
<html>

<head>
    <!-- <title>getdevving</title> -->
    <title>{{ $site_name }} #{{ $invoice_number }}</title>
</head>

<body style="margin: 0px; padding: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr style="width: 100%;">
            <td align="top" style="width: 100%;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr style="width: 100%;">
                        <td style="padding: 0px;max-height: 130px; width: 100%;">
                            <table style="width: 100%;">
                                <tr style="width: 100%;">
                                    <td style="width: 50%; vertical-align: top; padding-left: 40px; padding-top: 40px;">
                                        <img src="{{ $company_logo }}" alt="Get Devwing Logo"
                                            style="height: 40px;"><br><br>
                                        <span
                                            style="font-weight: bold; font-size: 9px; font-family: 'Arial (Body)'; margin-bottom: 0%;">BILLED
                                            FROM:</span><br>
                                        <p style="font-family: 'Arial'; font-size: 9px; margin-top: 0%;">{{ $company_name }}</p>
                                        <p style="font-family: 'Arial'; font-size: 9px; margin-bottom: 0%;">Website:
                                            {{ $site_name }}</p>
                                        <p style="font-family: 'Arial'; font-size: 9px; margin-top: 0%;">Email:
                                            {{ $company_email }}</p>
                                    </td>

                                    <!-- Right Side: Invoice Info -->
                                    <td
                                        style="width: 50%; text-align: right; vertical-align: top; padding-right: 40px; padding-top: 40px; font-family: 'Arial';">
                                        <p style="font-size: 20px; font-weight: bold; margin-top: 0%;">INVOICE</p>
                                        <p style="font-size: 9px; margin-bottom: 0%;">Invoice # {{ $invoice_number }}</p>
                                        <p style="font-size: 9px; margin-top: 0%;">Date: {{ $invoice_date  }}</p>
                                        <p style="font-size: 9px; font-weight: bold; margin-bottom: 0%;">Billed to:</p>
                                        <p style="font-size: 9px; margin-top: 0%;">{{ $customer_name  }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                        <tr> 
                            <td style="padding:40px;padding-top:0px;background-position: center;background-size: cover;height:778px; font-family: 'arial'; font-size: 9px; vertical-align: top;">
                                <br>
                                <table width="100%" border="1" cellspacing="0" cellpadding="8"
                                    style="border-collapse: collapse; text-align: center;">
                                    <tr>
                                        <th style="width: 15%; font-weight: bold;">QUANTITY</th>
                                        <th style="width: 55%; font-weight: bold;">DESCRIPTION</th>
                                        <th style="width: 15%; font-weight: bold;">UNIT PRICE</th>
                                        <th style="width: 15%; font-weight: bold;">TOTAL</th>
                                    </tr>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>1</td>
                                        <td align="left">{{ $product->name  }}</td>
                                        <td align="right">{{ site_currency() }}{{ number_format($product->unit_price, 2) }}</td>
                                        <td align="right">{{ site_currency() }}{{ number_format($product->unit_price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </table>

                                <!-- Totals Section -->
                                <table align="right"  cellspacing="0" cellpadding="8"
                                    style=" border-collapse: collapse; width: 23%;">
                                    <tr>
                                        <td style="font-weight: bold; text-align: right;">SUBTOTAL</td>
                                        <td style="text-align: right; border: 1px solid gray">{{ site_currency() }}{{ number_format(($invoice_amount + $discount_amount), 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; text-align: right;">DISCOUNT</td>
                                        <td style="text-align: right; border: 1px solid gray">{{ site_currency() }}{{ number_format($discount_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; text-align: right;">TOTAL DUE</td>
                                        <td style="text-align: right; border: 1px solid gray">{{ number_format($invoice_amount, 2) }}</td>
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
                                    style="background: url('{{ $invoice_footer_image }}') no-repeat;background-position: center;background-size: cover;height:130px;padding:50px;background-size:cover;width: 100%;">
                                    <td style="text-align:center;">
                                        <p
                                            style="text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight:700;color:whitesmoke;">
                                            WE APPRECIATE YOUR DECISION TO SHOP WITH US

                                        </p>
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