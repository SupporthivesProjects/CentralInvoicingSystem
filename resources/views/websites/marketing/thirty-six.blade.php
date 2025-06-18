<!DOCTYPE html>
<html>

<head>
    <title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td style="padding: 0px;max-height: 130px;">
                            <table>
                                <tr>
                                    <td
                                        style="height: 60px; background: url('{{ $invoice_header_image }}}') no-repeat;background-position: 100% 100%;background-size:cover;width: 600px;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px;padding-top:0px;">
                            <table>
                                <tr>
                                    <td>
                                        <p style="font-family: arial;font-size:48px;margin: 0px;font-weight: 400;">
                                            <b> INVOICE</b>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p style="font-size: 10px;">Invoice To</p>
                                        <p style="font-size: 10px;">
                                            <b>
                                                {{ $customer_name }}
                                            </b>
                                        </p>

                                    </td>
                                    <td style="padding-right: 45px; ;">
                                        <p style="font-size: 10px;">Invoice From</p>
                                        <p style="font-size: 10px;">
                                            <b>
                                                {{ $site->site_name }}
                                            </b>
                                            <br>
                                            www.bluemoonmarketeers.com
                                        </p>
                                    </td>
                                    <td style="text-align: right;">
                                        <p style="font-size: 10px;">Invoice No: #{{ $invoice_number }}</p>
                                        <p style="font-size: 10px;">Due Date: {{ $invoice_date }}</p>
                                        <p style="border-bottom: 2px solid black;"></p>

                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid black;">
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <p
                                            style="font-family: arial;font-size: 10px;margin-top: 0px;text-align: right;margin-left: 60px;">
                                            Total Amount Due</p>
                                        <p
                                            style="font-family: arial;font-size: 22px;margin-top: 0px;text-align: right;margin-left: 60px;font-weight: 400;">
                                            {{ site_currency() . number_format($invoice_amount, 2) }}</p>

                                    </td>

                                </tr>

                            </table>


                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                <tr
                                    style="border-collapse: collapse;height: 30px;background-color: black; color: white;border-bottom: 0px;border: 0px;">
                                    <td
                                        style="width: 600px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>Product Description</b>
                                    </td>
                                    <td
                                        style="width: 250px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>#Month</b>
                                    </td>
                                    <td
                                        style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>Price</b>
                                    </td>

                                </tr>
                                @foreach ($products as $product)
                                    <tr style="border-collapse: collapse;height: 50px;">
                                        <td
                                            style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-bottom: 0px; ">
                                            {{ $product->name ?? '-' }}
                                        </td>
                                        <td
                                            style="width: 250px;text-align:center;padding-left:10px;font-family: arial;font-size:10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            {{ $product->subscription ?? '-' }}
                                        </td>
                                        <td
                                            style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                            {{ site_currency() . number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}
                                        </td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <td style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;"
                                        colspan="2">
                                        <p><b>
                                                SUBTOTAL
                                            </b></p>
                                    </td>
                                    <td
                                        style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;"colspan="1">
                                        <p><b>{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</b>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td
                                        style="width: 100px;padding-right: 10px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-bottom: 1px solid black;">
                                        <p>DISCOUNT</p>
                                    </td>
                                    <td
                                        style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-bottom: 1px solid black;border-collapse: collapse;">
                                        <p>{{ site_currency() . number_format($discount_amount, 2) }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;padding-right: 10px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;"
                                        colspan="2">
                                        <p>Grand Total</p>
                                    </td>
                                    <td
                                        style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;"colspan="1">
                                        <p>{{ site_currency() . number_format($invoice_amount, 2) }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr
                                    style="background: url('{{ $invoice_footer_image }}') no-repeat;background-position: center;background-size: cover;height:141px;padding:50px;background-size:cover;width: 100%;">
                                    <td><img src="{{ $company_logo }}" alt="Company Logo"
                                            style="padding-left: 40px; display: block;height:85px;">
                                    </td>
                                    <td style="color: white;margin: auto;">
                                        <p style="font-size: 10px;"><b>ADDRESS</b></p>
                                        <p style="font-size: 10px;">{!! $company_address ?? 'N/A' !!}
                                        </p>
                                    </td>
                                    <td style="color: white;">
                                        <p style="font-size: 10px;"><b>CONTACTS</b></p>
                                        <p style="font-size: 10px;">
                                            {{ $company_email ?? 'support@bluemoonmarketeers.com' }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
