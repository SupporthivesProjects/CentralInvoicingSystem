<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        *{
            margin:0px;
            padding:0px;
        }
    </style>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="height:100vh;">
        <tr>
            <td align="center" style="padding:0px;vertical-align:top;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse;">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0;">
                            <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                                <tr>
                                    <td style="
                                        background: url('{{ $invoice_header_image }}') no-repeat center;
                                        background-size: cover;
                                        height:105px;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Header End -->
                     <tr style="height:30px">

                     </tr>

                    <!-- Content -->
                    <tr>
                        <td
                            style=" vertical-align: top; padding:40px;padding-top:0px;background:#ffffff; background-repeat: no-repeat;background-position: center;background-size: cover;height:444px; font-family: 'Arial ';">
                            <table width="100%" style="border-collapse: collapse;">
                                <tr>
                                    <td style="width: 60%; font-size: 10px;">
                                        <p style="margin: 0;"><strong>Email:</strong> {{ $invoice_date }}</p>
                                        <p style="margin: 0;"><strong>Invoice Number:</strong> {{ $invoice_number }}</p>
                                    </td>
                                    <td style="width: 40%; text-align: right;  position: relative;">
                                        <img src="{{ $invoice_image1 }}" alt="Top Box"
                                            style=" position: absolute; top: 27px; right: 89px; z-index: 1;" />
                                        <img src="{{ $invoice_image2 }}" alt="Bottom Box"
                                            style="position: absolute; top: 206px; right: 89px; z-index: 1; width: 65px;"/>
                                       <br><br>
                                            <p
                                            style="font-size: 28px; font-weight: bold; position: relative; z-index: 2; top: 69px;">
                                            INVOICE</p>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <br>
                            <br>

                            <!-- Billed Info Row -->
                            <table width="100%" style="border-collapse: collapse;">
                                <tr>
                                    <!-- Billed From -->
                                    <td style="width: 50%; vertical-align: top;">
                                        <p style="margin: 0; font-weight: bold; font-size: 12px;">Billed From:</p>
                                        <p style="margin: 0; font-size: 12px;">{{ $site_name }}</p>
                                        <br>
                                        <p style="margin: 5px 0; font-size: 11px;"><strong>Email:</strong>
                                            {{ $company_email }}</p>
                                        <p style="margin: 0; font-size: 11px;"><strong>Website:</strong> {{ $site_name }}
                                        </p>
                                    </td>

                                    <!-- Billed To -->
                                    <td style="width: 16%; vertical-align: top;">
                                        <p style="margin: 0; font-weight: bold; font-size:12px ;z-index:10000;">Billed To:</p>
                                        <p style="margin: 0; font-size:12px ;z-index: 200000;">
                                            {{ $customer_name }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <table width="100%" style="border-collapse: collapse;margin-top:40px;">
                                <tr style="background-color: #D4E1EF; border-bottom: 1px solid gray; font-size: 11px;">
                                    <th style="text-align: left; padding: 5px;">Item</th>
                                    <th style="text-align: left; padding: 5px;">Product Description</th>
                                    <th style="text-align: left; padding: 5px;">Quantity</th>
                                    <th style="text-align: left; padding: 5px;">Price</th>
                                    <th style="text-align: left; padding: 5px;">Total</th>
                                </tr>
                                @foreach ($products as $product)
                                <tr style="border-bottom: 1px solid gray; font-size: 8px;">
                                    <td style="padding: 5px;">1</td>
                                    <td style="padding: 5px;"><span>{{ $product->name }}</span> </td>
                                    <td style="padding: 5px;">1</td>
                                    <td style="padding: 5px;">{{ site_currency() }} {{  number_format($product->unit_price, 2) }}</td>
                                    <td style="padding: 5px;">{{ site_currency() }} {{  number_format($product->unit_price, 2) }}</td>
                                </tr>
                                @endforeach

                                <!-- Empty Rows -->
                              
                            </table>

                            <!-- Totals Section -->
                            <table width="45%" align="right" style="border-collapse: collapse;">
                                <tr>
                                    <td
                                        style=" text-align: left; font-size: 11px; border-bottom: 1px solid gray; padding: 5px;">
                                        Subtotal</td>
                                    <td style="text-align: right; font-size: 8px; border-bottom: 1px solid gray;">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; font-size: 11px; padding: 5px;">Discount</td>
                                    <td style="text-align: right; font-size: 8px;"></td>{{ site_currency() }} {{ number_format(( $discount_amount), 2) }}
                                </tr>
                                <tr style="background-color: #163264; color: white; font-weight: bold;">
                                    <td style=" text-align: left; padding: 6px; font-size: 11px;">Total</td>
                                    <td style="text-align: right; padding: 6px; font-size: 8px;">{{ site_currency() }} {{ number_format(($invoice_amount ), 2) }}</td>
                                </tr>
                                <tr >
                                    <td style="position:absolute;bottom:100px">
                                        <img src="{{ $invoice_image1 }}" alt=""
                                            style="position: absolute; bottom: -125px;
    left: -307px;
    width: 120px;">
                                        <img src="{{ $invoice_image1 }}" alt=""
                                            style="position: absolute; bottom: -83px;
    left: -259px;
    width: 120px;">
                                        <img src="{{ $invoice_image2 }}" alt=""
                                            style="position: absolute; bottom: 20px;
    left: -193px;
    width: 80px;">
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
                                    style="background: url() no-repeat;background-position: center;background-size: cover;height:120px;padding:50px;background-size:cover;width: 100%; font-size: 10px; font-family: 'Cambria ';">

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