<!DOCTYPE html>
<html>

<head>
    <title>Your Email Title template</title>
</head>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <table
                    style="border-collapse: collapse;border: 0px; background: url({{ $invoice_image3 }}) no-repeat;background-position:center;background-size:cover;">
                    <tr style="height: 150px;width: 600px;">
                        <td style="width: 300px;text-align: center;">
                            <img src="{{ $company_logo }}" style="height: 80px;">
                        </td>
                        <td
                            style="width: 300px;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">
                            <b style="font-size: 18px;margin: 0px; color: #1C293A; ">FLUX DIGITALS</b>
                            <p style="font-size: 10px;margin: 0px; ">{{ $company_address }}<br>{{ $company_email }} |
                                {{ $company_mobile }}</p>
                        </td>
                    </tr>

                    <tr style="background: url(Picture5.png);">
                        <td style="text-align: center;">
                            <img src="Picture3.png" style="height: 60px;">
                        </td>
                        <td style="padding-right: 75px;">
                            <h1
                                style="font-size: 53px;background-color: white;margin: 0px;padding-left: 10px;padding-right: 10px;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;font-weight: 500;color: #1C293A;">
                                INVIOCE</h1>
                        </td>
                    </tr>

                    <tr style="height: 150px;">

                        <td style="padding-left: 20px;padding-right: 20px;">
                            <table
                                style="border-collapse: collapse;font-size: 9px;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">
                                <tr style="border: 1px solid black;background-color: lightgray;height: 40px;">
                                    <td style="width: 150px;border: 1px solid black;padding-left: 10px;">
                                        <p>Invoice No.</p>
                                    </td>
                                    <td style="width: 150px;border: 1px solid black;padding-left: 10px;">
                                        <p>Invoice Date</p>
                                    </td>
                                </tr>
                                <tr style="border: 1px solid black;height: 40px;">
                                    <td style="border: 1px solid black;padding-left: 10px;">
                                        <p>{{ $invoice_number }}</p>
                                    </td>
                                    <td style="border: 1px solid black;padding-left: 10px;">
                                        <p>{{ $invoice_date }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td style="padding-right: 20px;">
                            <table
                                style="border: 1px solid black;font-size: 10px;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">
                                <tr>
                                    <td style="width: 300px;font-weight: 500;background-color: lightgrey;">
                                        <b>Invoice To</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b style="font-size: 18px;font-weight: 500;">{{ $customer_name }}</b>
                                        <p style="margin-bottom: 0px;">
                                            {{ $site_name }}<br>{{ $company_address }}<br>{{ $company_email }} |
                                            {{ $company_mobile }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="padding: 20px;">
                            <table style="border-collapse: collapse;">
                                <tr
                                    style="border-collapse: collapse;height: 30px; background-color: #1C293A;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; color: white;font-size: 12px;">
                                    <td
                                        style="width: 50px;text-align: center;margin: 0px;font-weight: 300;border-left: 1px solid white;">
                                        <b>#</b>
                                    </td>
                                    <td
                                        style="width: 300px;text-align: left;margin: 0px;font-weight: 300;border-left: 1px solid white;padding-left: 10px;">
                                        <b>Detail</b>
                                    </td>
                                    <td
                                        style="width: 100px;text-align: left;margin: 0px;font-weight: 300; padding-left: 10px;border-left: 1px solid white;">
                                        <b>QTY</b>
                                    </td>
                                    <td
                                        style="width:120px;text-align: center;margin: 0px;font-weight: 300;border-left: 1px solid white;">
                                        <b>Unit Price</b>
                                    </td>
                                    <td
                                        style="width:150px;text-align: center;margin: 0px;font-weight: 300;border-left: 1px solid white;">
                                        <b>Total</b>
                                    </td>
                                </tr>
                                @foreach ($products as $product)
                                    <tr
                                        style="border-collapse: collapse;height: 30px;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;font-size: 10px;border-bottom: 1px solid black;">
                                        <td
                                            style="width: 50px;text-align: center;margin: 0px;border-left: 1px solid white;">
                                            <p>{{ $loop->iteration }}</p>

                                        </td>
                                        <td
                                            style="width: 300px;text-align: left;margin: 0px;border-left: 1px solid white;padding-left: 10px;">
                                            <p>  {{ $product->name }}</p>
                                        </td>
                                        <td
                                            style="width: 100px;text-align: left;margin: 0px; padding-left: 10px;border-left: 1px solid white;">
                                            <p>1</p>
                                        </td>
                                        <td
                                            style="width:120px;text-align: center;margin: 0px;border-left: 1px solid white;background-color: lightgray;">
                                            <p> {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}</p>
                                        </td>
                                        <td
                                            style="width:150px;text-align: center;margin: 0px;border-left: 1px solid white;background-color: lightgray;">
                                            <p> {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr
                                    style="border-collapse: collapse;height: 30px;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;font-size: 12px;">
                                    <td colspan="3"></td>
                                    <td
                                        style="width:120px;text-align: right;margin: 0px;border-bottom: 1px solid white;background-color: darkgray;color: white;padding-right: 10px;">
                                        <p style="margin: 0px;">Sub Total</p>
                                    </td>
                                    <td
                                        style="width:150px;text-align: center;margin: 0px;border-bottom: 1px solid white;background-color: darkgray;color: white;">
                                        <p style="margin: 0px;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</p>
                                    </td>
                                </tr>
                                <tr
                                    style="border-collapse: collapse;height: 30px;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;font-size: 12px;">
                                    <td colspan="3"></td>
                                    <td
                                        style="width:120px;text-align: right;margin: 0px;border-bottom: 1px solid white;background-color: darkgray;color: white;padding-right: 10px;">
                                        <p style="margin: 0px;">Discount</p>
                                    </td>
                                    <td
                                        style="width:150px;text-align: center;margin: 0px;border-bottom: 1px solid white;background-color: darkgray;color: white;">
                                        <p style="margin: 0px;">{{ site_currency() . number_format($discount_amount, 2) }}</p>
                                    </td>
                                </tr>
                                <tr
                                    style="border-collapse: collapse;height: 30px;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;font-size: 16px;">
                                    <td colspan="3"></td>
                                    <td
                                        style="width:120px;text-align: right;margin: 0px;border-bottom: 1px solid white; background-color: #1C293A;color: white;padding-right: 10px;">
                                        <p style="margin: 0px;">Total</p>
                                    </td>
                                    <td
                                        style="width:150px;text-align: center;margin: 0px;border-bottom: 1px solid white; background-color: #1C293A;color: white;">
                                        <p style="margin: 0px;">{{ site_currency() . number_format($invoice_amount, 2) }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr style="height: 100px;">
                        <td></td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
