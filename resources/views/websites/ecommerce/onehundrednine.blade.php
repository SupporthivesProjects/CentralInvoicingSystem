<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body style=" margin: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse;">
                    <!---header--->
                    <tr>
                        <td align="center"
                            style="height:100px;background:url('{{ $invoice_header_image }}');background-size: cover;background-repeat: no-repeat;background-position: center;">
                        </td>
                    </tr>
                    <!---header End--->

                    <!-- Content -->
                    <tr style="background:#ffff ;">
                        <td style="padding: 40px;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                                style="border-collapse: collapse;">
                                <tr>
                                    <td colspan="2">
                                        <p style="margin: 0px;font-family: Arial;font-size: 10px;line-height: 18px;">
                                            <b>Date : </b> {{ $invoice_date }}
                                        </p>
                                        <p style="margin: 0px;font-family: Arial;font-size: 10px;line-height: 18px;">
                                            <b>Invoice Number : </b>#{{ $invoice_number }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right">
                                        <h1
                                            style="margin: 0px;font-family: Arial;font-size:28px;line-height:32px;text-transform: uppercase;">
                                            invoice
                                        </h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p style="margin: 0px;font-family: Arial;font-size: 12px;line-height: 18px;">
                                            Billed From :
                                        </p>
                                        <p style="margin: 0px;font-family: Arial;font-size: 12px;line-height: 18px;">
                                            Corporate Content
                                        </p>
                                    </td>
                                    <td align="right">
                                        <p style="margin: 0px;font-family: Arial;font-size: 12px;line-height: 18px;">
                                            Billed To :
                                        </p>
                                        <p style="margin: 0px;font-family: Arial;font-size: 12px;line-height: 18px;">
                                            {{  $customer_name }}
                                        </p>
                                    </td>
                                </tr>
                                <tr style="height: 10px;"></tr>
                                <tr>
                                    <td colspan="2">
                                        <p style="margin: 0px;font-family: Arial;font-size: 10px;line-height: 18px;">
                                            <b>Email : </b>{{ $company_email }}
                                        </p>
                                        <p style="margin: 0px;font-family: Arial;font-size: 10px;line-height: 18px;text-transform: capitalize;">
                                            <b>Website : </b>{{ $site_name }}
                                        </p>

                                        <p style="margin: 0px;font-family: Arial;font-size: 10px;width: 250px; line-height: 18px;">
                                            <b>Address : </b>
                                            @php
                                                $parts = explode(',', $company_address);
                                            @endphp
                                            @foreach($parts as $index => $part)
                                                {{ trim($part) }}@if($index < count($parts) - 1),@endif
                                                @if($index === 0 || $index === 4)
                                                    <br>
                                                @endif
                                            @endforeach
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <div style="min-height: 650px !important;">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                                    style="border-collapse: collapse;margin-top: 30px;">
                                    <tr style="background: #D3E5F9;">
                                        <td>
                                            <p
                                                style="margin: 0px;font-family: Arial;font-size: 13px;line-height: 18px;font-weight: 700;padding: 5px;">
                                                Category
                                            </p>
                                        </td>
                                        <td>
                                            <p
                                                style="margin: 0px;font-family: Arial;font-size: 13px;line-height: 18px;font-weight: 700;padding: 5px;">
                                                Name
                                            </p>
                                        </td>
                                        <td>
                                            <p
                                                style="margin: 0px;font-family: Arial;font-size: 13px;line-height: 18px;font-weight: 700;padding: 5px;">
                                                Quantity
                                            </p>
                                        </td>
                                        <td>
                                            <p
                                                style="margin: 0px;font-family: Arial;font-size: 13px;line-height: 18px;font-weight: 700;padding: 5px;">
                                                Unit Price
                                            </p>
                                        </td>
                                        <td align="right">
                                            <p
                                                style="margin: 0px;font-family: Arial;font-size: 13px;line-height: 18px;font-weight: 700;padding: 5px;">
                                                Total
                                            </p>
                                        </td>
                                    </tr>
                                    @foreach ($products as $product)
                                        <tr style="border-bottom: 1px solid black;">
                                            <td>
                                                <p
                                                    style="margin: 0px;font-family: Arial;font-size:10px;line-height: 18px;padding: 5px;">
                                                    {{ $product->category_name }}
                                                </p>
                                            </td>
                                            <td>
                                                <p
                                                    style="margin: 0px;font-family: Arial;font-size:10px;line-height: 18px;padding: 5px;">
                                                    {{ $product->name }}
                                                </p>
                                            </td>
                                            <td>
                                                <p
                                                    style="margin: 0px;font-family: Arial;font-size:10px;line-height: 18px;padding: 5px;">
                                                    {{ $product->quantity ?? 1 }}
                                                </p>
                                            </td>
                                            <td>
                                                <p
                                                    style="margin: 0px;font-family: Arial;font-size:10px;line-height: 18px;padding: 5px;">
                                                    {{ site_currency() . number_format($product->unit_price, 2) }}
                                                </p>
                                            </td>
                                            <td align="right">
                                                <p
                                                    style="margin: 0px;font-family: Arial;font-size:10px;line-height: 18px;padding: 5px;">
                                                    {{ site_currency() . number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="2" style="border-bottom: 1px solid black;">
                                            <p
                                                style="margin: 0px;font-family: Arial;font-size:11px;line-height: 20px;padding: 5px;">
                                                Subtotal
                                            </p>
                                        </td>
                                        <td align="right" style="border-bottom: 1px solid black;">
                                            <p
                                                style="margin: 0px;font-family: Arial;font-size:10px;line-height: 20px;padding: 5px;">
                                                {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="2" style="border-bottom: 1px solid black;">
                                            <p
                                                style="margin: 0px;font-family: Arial;font-size:11px;line-height: 20px;padding: 5px;">
                                                Discount
                                            </p>
                                        </td>
                                        <td align="right" style="border-bottom: 1px solid black;">
                                            <p
                                                style="margin: 0px;font-family: Arial;font-size:10px;line-height: 20px;padding: 5px;">
                                                {{ site_currency() . number_format($discount_amount, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="2" style="background: #D3E5F9;">
                                            <p
                                                style="margin: 0px;font-family: Arial;font-size:11px;line-height: 20px;padding: 5px;">
                                                Grand Total
                                            </p>
                                        </td>
                                        <td align="right" style="background: #D3E5F9;">
                                            <p
                                                style="margin: 0px;font-family: Arial;font-size:10px;line-height: 20px;padding: 5px;">
                                                {{ site_currency() . number_format($invoice_amount, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <!-- Content End-->


                    <!-----------Footer----------->

                    <!-----------Footer End----------->
                </table>
            </td>
        </tr>
    </table>
</body>

</html>