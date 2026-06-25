<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        @page {
          margin:0px;
          padding:0px;
        }
    </style>
</head>

<body style="margin:0; padding:0; background:#f5f6f8; font-family:Arial, sans-serif;">

    <!-- OUTER WRAPPER TABLE -->
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#FFFCF8;height:100vh">
        <tr>
            <td align="center" style="vertical-align:top;">

                <!-- MAIN CONTAINER -->
                <table width="100%" cellpadding="0" cellspacing="0"
                    style="background:#FFFCF8; border-radius:6px; overflow:hidden;">

                    <!-- HEADER -->
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="padding:60px 50px 10px 50px;position: relative;">
                                <tr>
                                    <!-- LEFT SIDE -->
                                    <td width="60%" valign="top">
                                        <img src="{{ $company_logo }}" alt="Brand Throttle"
                                            style="width:140px; margin-bottom:10px;">
                                        <table cellpadding="0" cellspacing="0"
                                            style="font-size:11px; line-height:18px; font-family:Arial;">
                                            <tr>
                                                <td><i>{!! $company_address !!}</i></td>
                                            </tr>
                                            {{-- <tr>
                        <td>123 place, City,</td>
                      </tr>
                      <tr>
                        <td>Country, Post code</td>
                      </tr> --}}
                                            <tr>
                                                <td>Email: {{ $company_email }}</td>
                                            </tr>
                                            <tr>
                                                <td>Phone: {{ $company_mobile }}</td>
                                            </tr>
                                        </table>
                                    </td>

                                    <!-- RIGHT SIDE -->
                                    <td width="40%" valign="top" align="right">
                                        <img src="{{ $invoice_image4 }}" alt=""
                                            style="position: absolute ;width: 50px;top: 0px;z-index: 2;">
                                        <img src="{{ $invoice_image2 }}" alt=""
                                            style="position: absolute ;    width: 235px; top: -50px; right: -92px;z-index: 1;">

                                        <table cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td
                                                    style="font-size:24px; font-weight:bold; letter-spacing:1px; color:#02767F; padding-bottom:10px;">
                                                    INVOICE
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px; line-height:18px;">
                                                    <strong>Invoice:</strong> <b>{{ $invoice_number }}</b><br>
                                                    <strong>Date:</strong> <b>{{ $invoice_date }}</b>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- BILL TO -->
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse: collapse;padding:10px 50px 5px 50px; position: relative;">
                                <tr>
                                    <td style="font-size:14px; line-height:18px;">
                                        <img src="{{ $invoice_image3 }}" alt=""
                                            style="position: absolute ;   width: 30px;top: -47px;left: 10px;">
                                        <strong>To:</strong><br>
                                        {{ $customer_name ? $customer_name : '' }}<br>
                                        {{ $customer_email ? $customer_email : '' }}<br>
                                        {{ $customer_mobile ? $customer_mobile : '' }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- INVOICE TABLE -->
                    <tr>
                        <td align="center">
                            <table cellpadding="0" cellspacing="0" width="90%"
                                style="border-collapse:collapse; font-family:Arial, sans-serif; font-size:14px; color:#000; position: relative;">

                                <!-- HEADER ROW -->
                                <tr>
                                    <th
                                        style="padding:10px 5px; text-align:left; border-bottom:1px solid #3C8F89; color:#3C8F89; font-weight:bold;">
                                        DESCRIPTION
                                    <!-- </th>
                                    <th
                                        style="padding:10px 5px; text-align:center; border-bottom:2px solid #3C8F89; color:#3C8F89; font-weight:bold;">
                                        STATUS
                                    </th> -->
                                    <th
                                        style="padding:10px 5px; text-align:center; border-bottom:1px solid #3C8F89; color:#3C8F89; font-weight:bold;">
                                        DURATION
                                    </th>
                                    <th
                                        style="padding:10px 5px; text-align:right; border-bottom:1px solid #3C8F89; color:#3C8F89; font-weight:bold;">
                                        AMOUNT
                                    </th>
                                </tr>

                                <!-- MAIN ROW -->
                                @foreach ($products as $product)
                                    <tr>
                                        <td style="padding:12px 5px; border-bottom:1px solid #3C8F89;">
                                            {{ $product->name }}</td>
                                        <!-- <td
                                            style="padding:12px 5px; text-align:center; border-bottom:1px solid #3C8F89; border-left:2px solid #3C8F89;">
                                            {{ $packageName = trim(explode('-', $product->name)[1] ?? '') }}</td> -->
                                        <td
                                            style="padding:12px 5px; text-align:center; border-bottom:1px solid #3C8F89; border-left:1px solid #3C8F89;">
                                            {{ $product->subscription ?? '-' }}</td>
                                        <td
                                            style="padding:12px 5px; text-align:right; border-bottom:1px solid #3C8F89; border-left:1px solid #3C8F89;">
                                            {{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}
                                        </td>
                                    </tr>
                                @endforeach

                                <!-- EMPTY ROWS (9 LINES) -->
                                <!-- repeat row template -->
                                <!-- row template -->
                                <!-- BELOW IS 9 REPEATED ROWS -->
                                <!-- 1 -->


                                <!-- TOTAL ROW -->
                                <tr>

                                    <td></td>
                                    <!-- <td></td> -->
                                    <td
                                        style="padding:10px 5px; text-align:right; font-size:14px; color:#3C8F89; font-weight:bold; border-top:1px solid #3C8F89;">
                                        TOTAL
                                    </td>
                                    <td
                                        style="padding:10px 5px; text-align:right; font-size:14px; color:#3C8F89; font-weight:bold; border-top:1px solid #3C8F89; border-left:1px solid #3C8F89;">
                                        {{ site_currency() }}{{ number_format($invoice_amount, 2) }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- FOOTER (TABLE ONLY) -->
                    <tr>
                        <td>
                            <table width="100%" height="100" cellpadding="0" cellspacing="0"
                                style="background-image:url('{{ $invoice_image1 }}'); background-size:100%; background-position:center; background-repeat:no-repeat; margin-top:40px;position:absolute;bottom:0px">
                                <tr>
                                    <td></td>
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