<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td style="padding: 0px;max-height: 130px;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
                                <tr>
                                    <td style="height: 100px; background: url('{{ $invoice_header_image }}') no-repeat;background-position: 100% 100%;background-size:cover;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px;padding-top:0px;background: url('{{ $invoice_image1 }}') no-repeat;background-position: center;background-size: cover;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
                                <tr>
                                    <td>
                                         <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                           <b> DATE:</b> {{ $invoice_date }}
                                        </p>

                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            <b>Invoice Number:</b> #{{ $invoice_number }}
                                        </p>
                                        <br>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 700;">
                                            BILLED FROM:
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            {{ $site_name }}
                                        </p>
                                        <br>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <strong>Email:</strong> {{ $company_email }}
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <b>Website:</b> www.reimaginedsolutionz.com
                                        </p>
                                    </td>
                                    <td style="width:300px;
                                    padding: 40px;
                                    text-align: right;">
                                        <h1 style="font-family: arial;font-size: 20px;margin: 0px;font-weight: 700;">INVOICE</h1><br><br>


                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <b>
                                                BILLED TO:
                                            </b>
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            {{ $customer_name }}
                                        </p>

                                    </td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <div style="min-height: 550px !important;">
                            <table style="border: 1px solid black;border-collapse: collapse; ">
                                <tr style="border: 1px solid black;border-collapse: collapse;height: 24px;background-color: #9e86f4">
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                       <b>#</b>
                                    </td>
                                    <td style="width: 250px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        <b>PRODUCT NAME</b>
                                    </td>
                                    <td style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        <b>Quantity</b>
                                    </td>
                                    <td style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        <b>UNIT PRICE</b>
                                    </td>
                                    <td style="width:100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        <b>TOTAL</b>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr style="border: 1px solid black;border-collapse: collapse;height: 24px;">
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                      {{ $loop->iteration }}
                                    </td>
                                    <td style="width: 250px;text-align:left;padding-left:10px;font-family: arial;font-size:10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        {{ $product->name }}
                                    </td>
                                    <td style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        {{ $product->quantity ?? 1 }}
                                    </td>
                                    <td style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        {{ site_currency_code() . number_format($product->unit_price, 2) }}
                                    </td>
                                    <td style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                        {{ site_currency_code() . number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                                {{-- The hardcoded empty rows can be added here if needed for spacing, or removed. --}}

                                <tr>
                                    <td style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;padding-right: 10px;" colspan="3">
                                     <p><b>
                                        SUBTOTAL
                                     </b></p>
                                    </td>
                                    <td style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;" colspan="4">
                                        <p><b>{{ site_currency_code() . number_format($invoice_amount + $discount_amount, 2) }}</b></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;padding-right: 10px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;" colspan="3">
                                     <p>DISCOUNT</p>
                                    </td>
                                    <td style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;"colspan="4">
                                        <p>{{ site_currency_code() . number_format($discount_amount, 2) }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;padding-right: 10px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;" colspan="3">
                                     <p>TOTAL DUE</p>
                                    </td>
                                    <td style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;background-color: #9e86f4;"colspan="4">
                                        <p>{{ site_currency_code() . number_format($invoice_amount, 2) }}</p>
                                    </td>
                                </tr>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;">
                                <tr style="background: url('{{ $invoice_footer_image }}') no-repeat;background-position: center;background-size: cover;height:141px;padding:50px;background-size:cover;width: 100%;">
                                    <td style="text-align:center;">
                                        <p style="text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight:700;color:whitesmoke;">

                                        </p>
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
