<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }}</title>
</head>

<body style="margin: 0px; padding: 0px; background-color: #FFFFFF;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); background-image: url(./img/bg.png); background-position: center; background-repeat: no-repeat; background-size: cover; height: 860px;">
                    <!-- Header -->
                    <tr>
                        <td style="height: 30px;">
                            <table>
                                <tr>
                                    <td><img src="{{ $company_logo }}" alt=""
                                            style="width: 270px; padding: 40px; padding-bottom: 0%;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <br>
                        <td style="font-family: 'Inter'; font-size: 9px; vertical-align: top;">
                            <table width="100%"
                                style="padding: 40px; color: White; background-image: url('{{ $invoice_image1 }}'); height: 212px; width: 100%; background-position: center; background-repeat: no-repeat; background-size: cover;">
                                <tr>
                                    <td width="50%">
                                        <p style=" font-size: 52px; font-weight: bold; margin: 0%;">INVOICE</p>
                                    </td>
                                    <td align="right">
                                        <p style=" font-size: 12px; font-weight: bold; margin: 0px;">Invoice To :</p>
                                        <p style="font-size: 21px; font-weight: bold; margin: 0%;">{{ $customer_name ? $customer_name : '' }}</p>
                                    </td>
                                </tr>
                            </table>
                            <table style="padding-left: 40px; font-size: 11px; margin-top: -30px;">
                                <tr>
                                    <td>
                                        <p style="margin: 0%; margin-bottom: 5px;"><strong>Invoice No</strong> :{{ $invoice_number }}
                                        </p>
                                        <p style="margin: 0%;"><strong>Invoice Date</strong>:{{ $invoice_date }}</p>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <div style="min-height: 702px;">
                                <table
                                    style="width: 100%; max-width: 1000px; margin: auto; border-collapse: collapse; font-family: 'Inter' ; font-size: 9px;">
                                    <!-- Table Header Row -->
                                    <tr
                                        style="background-image: url('{{ $invoice_image3 }}'); background-size: cover; background-repeat: no-repeat; color: black; font-size: 11px;">
                                        <th style=" text-align: left; padding-left: 40px;">NO</th>
                                        <th style="padding: 12px; text-align: left;">ITEM DESCRIPTION</th>
                                        <th style="padding: 12px; text-align: center;">UNIT PRICE</th>
                                        <th style="padding: 12px; text-align: center;">QTY</th>
                                        <th style="padding: 12px; text-align: center;">TOTAL</th>
                                    </tr>

                                    <!-- Item Rows -->
                                    @foreach($products as $product)
                                    <tr style="background-color: #ffffff;">
                                        <td style="padding: 10px; padding-left: 40px;">1.</td>
                                        <td style="padding: 10px; font-weight: bold;">{{ $product->name }}</td>
                                        <td style="padding: 10px; text-align: center;"> {{ site_currency() . number_format($product->line_total, 2) }}</td>
                                        <td style="padding: 10px;text-align: center;">1</td>
                                        <td style="padding: 10px; text-align: center;"> {{ site_currency() . number_format($product->line_total, 2) }}</td>
                                    </tr>
                                    @endforeach
                                    <!-- Totals -->
                                    <tr>
                                        <td colspan="4" style="text-align: right; font-size: 9px; padding: 10px; font-weight: bold;">SUB
                                            TOTAL</td>
                                        <td align="center" style="padding: 10px; font-weight: bold; font-size: 10px;">{{ site_currency() . number_format($invoice_amount + $discount_amount ?? 0, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: right; padding: 10px; font-size: 9px; font-weight: bold;">
                                            DISCOUNT</td>
                                        <td align="center" style="padding: 10px; font-size: 10px; font-weight: bold;">{{ site_currency() . number_format($discount_amount ?? 0, 2) }}</td>
                                    </tr>
                                </table>
                            
                             <table width="100%"
                                style="margin-top: -30px; padding: 40px; color: White; background-image: url('{{ $invoice_image2}}'); height: 212px; width: 100%; background-position: center; background-repeat: no-repeat; background-size: cover; box-shadow: none;">
                                <tr>
                                    <td width="50%">
                                        <p style=" font-size: 21px; font-weight: bold; margin: 0%;">Payment Information</p>
                                    </td>
                                    <td align="center">
                                        <p style=" font-size: 22px; font-weight: bold; margin: 0px;">Grand Total: </p>
                                        <p style="font-size: 22px; font-weight: bold; margin: 0%; padding-left: 48px;">{{ site_currency() . number_format($invoice_amount ?? 0, 2) }}</p>
                                    </td>
                                </tr>
                            </table>
                            </div>
                            
                        </td>
                    </tr>
                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr>
                        <td>
                            <table width="100%" style="padding: 0px 40px 0px 40px; font-family: 'Inter'; margin-top: -10px; background-color: #FFFFFF; box-shadow: none; height: 85px;">
                                <tr>
                                    <td width="50%" style="vertical-align: bottom;">
                                        <p style="font-size: 10px;">{{ $company_email }}</p>
                                    </td>
                                    <td align="right">
                                        <p style="font-size: 13px; font-weight: bold; margin-bottom: 9px;">{{ $company_name }}</p>
                                        <p style="font-size: 9px;">{!! $company_address !!}</p>
                                    </td>
                                </tr>
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