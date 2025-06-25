<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td style="padding: 0px;max-height: 130px;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td
                                        style="height: 100px; background: url('{{ $invoice_header_image }}') no-repeat;background-position: 100% 100%;background-size:cover;width: 600px;">
                                        <img src="{{ $company_logo }}" alt="Company Logo"
                                            style="margin: auto; display: block;height:60px;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 40px;padding-top: 10px;">
                            <p style="text-align: center;font-size: large;font-family: arial;">Invoice</p>


                            <table style="border: 1px solid black;border-collapse: collapse;">
                                <tr
                                    style="border: 1px solid black;border-collapse: collapse;height: 24px;background-color: black;color: orange;">
                                    <td
                                        style="width: 150px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        <b>Billed To
                                    </td>
                                    <td
                                        style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-left: 1px solid black; border-collapse: collapse;">
                                        <b>Billed From</b>
                                    </td>
                                    <td
                                        style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 24px;">
                                    <td
                                        style="width: 150px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        Customer
                                    </td>
                                    <td
                                        style="width: 250px;text-align:left;padding-left:10px;font-family: arial;font-size:10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        {{ $customer_name }}
                                    </td>
                                    <td
                                        style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-left: 1px solid black;border-collapse: collapse;">
                                        Company
                                    </td>
                                    <td
                                        style="width:220px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        {{ $site_name }}
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 24px;">
                                    <td
                                        style="width: 150px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        Customer Inv #
                                    </td>
                                    <td
                                        style="width: 250px;text-align:left;padding-left:10px;font-family: arial;font-size:10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        #{{ $invoice_number }}
                                    </td>
                                    <td
                                        style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-left: 1px solid black;border-collapse: collapse;">
                                        Website
                                    </td>
                                    <td
                                        style="width:220px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        {{ $site->site_link }}
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 24px;">
                                    <td
                                        style="width: 150px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        Date Of Purchase
                                    </td>
                                    <td
                                        style="width: 250px;text-align:left;padding-left:10px;font-family: arial;font-size:10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        {{ $invoice_date }}
                                    </td>
                                    <td
                                        style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-left: 1px solid black;border-collapse: collapse;">
                                        Email
                                    </td>
                                    <td
                                        style="width:220px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        {{ $company_email ?? 'support@writewayservices.com' }}
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 24px;">
                                    <td
                                        style="width: 150px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width: 250px;text-align:left;padding-left:10px;font-family: arial;font-size:10px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-left: 1px solid black;border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width:220px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                </tr>
                            </table>
                            <br>
                            <div style="min-height: 300px !important;">
                                <table
                                    style="border: 1px solid black;border-collapse: collapse;border-bottom: 0px;border-left: 0px;">
                                    <tr
                                        style="border: 1px solid black;border-collapse: collapse;height: 24px;background-color: black; color: orange;">
                                        <td
                                            style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                            <b>Qty</b>
                                        </td>
                                        <td
                                            style="width: 250px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                            <b>DESCRIPTION</b>
                                        </td>
                                        <td
                                            style="width: 250px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                            <b>Quantity</b>
                                        </td>
                                        <td
                                            style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                            <b>Turnaround</b>
                                        </td>
                                        <td
                                            style="width: 150px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                            <b>Imagery</b>
                                        </td>
                                        <td
                                            style="width:200px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                            <b>Billing Cycle</b>
                                        </td>

                                        <td
                                            style="width: 250px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                            <b>Unit Price</b>
                                        </td>
                                    </tr>
                                    @foreach ($products as $product)
                                        <tr style="border: 1px solid black;border-collapse: collapse;height: 24px;">
                                            <td
                                                style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                                <p>{{ $loop->iteration }}</p>
                                            </td>
                                            <td
                                                style="width: 250px;text-align:left;padding-left:10px;font-family: arial;font-size:10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                                <p>
                                                    <strong>{{ $product->name }}</strong>
                                                </p>
                                            </td>
                                            <td
                                                style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                                <p>{{ $product->quantity ?? 1 }}</p>
                                            </td>
                                            <td
                                                style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                                <p>{{ $product->turnaround ?? '5 - 7 Days' }}</p>
                                            </td>
                                            <td
                                                style="width:150px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                                <p>{{ $product->imagecount ?? '4' }}</p>
                                            </td>
                                            <td
                                                style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                                <p>One Time</p>
                                            </td>
                                            <td
                                                style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                                <p>{{ site_currency() . number_format($product->unit_price, 2) }}</p>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tr style="border: 1px solid black;border-collapse: collapse;height: 24px;">
                                        <td
                                            style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <p></p>
                                        </td>
                                        <td
                                            style="width: 250px;text-align:left;padding-left:10px;font-family: arial;font-size:10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <p></p>
                                        </td>
                                        <td
                                            style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <p></p>
                                        </td>
                                        <td
                                            style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <p></p>
                                        </td>
                                        <td
                                            style="width:150px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <p></p>
                                        </td>
                                        <td
                                            style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                            <p>Discount</p>
                                        </td>
                                        <td
                                            style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                            <p>{{ site_currency() . number_format($discount_amount, 2) }}</p>
                                        </td>
                                    </tr>
                                    <tr style="border: 1px solid black;border-collapse: collapse;height: 24px;">
                                        <td
                                            style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <p></p>
                                        </td>
                                        <td
                                            style="width: 250px;text-align:left;padding-left:10px;font-family: arial;font-size:10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <p></p>
                                        </td>
                                        <td
                                            style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <p></p>
                                        </td>
                                        <td
                                            style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <p></p>
                                        </td>
                                        <td
                                            style="width:150px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <p></p>
                                        </td>
                                        <td
                                            style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                            <p>Subtotal</p>
                                        </td>
                                        <td
                                            style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;">
                                            <p>{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr style="border: 1px solid black;border-collapse: collapse;height: 24px;">
                                        <td
                                            style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <p></p>
                                        </td>
                                        <td
                                            style="width: 250px;text-align:left;padding-left:10px;font-family: arial;font-size:10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <p></p>
                                        </td>
                                        <td
                                            style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <p></p>
                                        </td>
                                        <td
                                            style="width:100px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <p></p>
                                        </td>
                                        <td
                                            style="width:150px;text-align:right;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <p></p>
                                        </td>
                                        <td
                                            style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;background-color: black;color: orange;">
                                            <p>Total</p>
                                        </td>
                                        <td
                                            style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border: 1px solid black;border-collapse: collapse;background-color: black;color: orange;">
                                            <p>{{ site_currency() . number_format($invoice_amount, 2) }}</p>
                                        </td>
                                    </tr>


                    </tr>
                </table>

        <tr>
            <td>
                <p style="font-family: arial;font-size: 12px;font-weight: 400;padding-left: 40px;">
                    <b>Thank you for your business!</b>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="font-family: arial;font-size: 12px;font-weight: 400;padding-left: 40px;color: orange;">
                    <b>{{ $site_name }}</b>
                </p>
                <p style="font-family: arial;font-size: 10px;padding-left: 40px;">{!! $company_address !!} |<br>
                    {{ $company_email ?? 'support@writewayservices.com' }}</p>
            </td>
        <tr>
            <td style="padding: 0px;max-height: 130px;">
                <table>
                    <tr>
                        <td <tr>
                        <td style="padding: 0px;max-height: 130px;">
                            <table>
                                <tr>
                                    <td style="height: 100px;">
                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>

            </td>

        </tr>
    </table>
    </td>
    </tr>
    </td>
    </tr>
    </table>
    </td>


    </tr>
    </table>
</body>

</html>
