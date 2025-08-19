<!DOCTYPE html>
<html>

<head>
    <title>knowhowtodesign</title>
</head>

<body style="margin: 0px; padding: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); background-image: url('{{ $invoice_header_image }}'); background-position: center; background-repeat: no-repeat; background-size: cover; height: 870px;">
                    <!-- Header -->
                    <tr style="padding: 200px 50px 0px 50px;">
                        <td style="height: 130px;">
                            <table style="font-family: 'Poppins'; padding: 39px; width: 100%; font-size: 9px;">
                                <tr style="position: relative;">
                                    <td style="position: absolute; left: -5px; font-weight: bold; top: 16px;">
                                        #{{ $invoice_number }}</td>
                                    <td style="position: absolute; right: 333px; font-weight: bold; top: 16px;">
                                        {{ $invoice_date }}</td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr>

                        <td
                            style="font-family: 'Poppins'; font-size: 9px; vertical-align: top; padding: 0px 40px 0px 40px;">
                            <table style="font-size: 12px; ">
                                <td>Total Due</td>
                                <td>
                                    <div style="height: 1px; width: 450px; background-color: #E48920;"></div>
                                </td>
                                <td>Invoice To :</td>
                            </table>
                            <table width="100%">
                                <tr>
                                    <td width="50%"
                                        style="font-size: 32px; font-weight: bold; padding-left: 40px; padding-top: 13px;">
                                        {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}</td>
                                    <td align="right"
                                        style="font-size: 16px; vertical-align: middle; font-weight: bold;">{{ $customer_name ? $customer_name : '' }}</td>
                                </tr>
                            </table>
                            
                            <div style="min-height: 640px;">
                                <table
                                    style="margin-top: 70px; width: 100%; padding: 40px; border-collapse: collapse; color: white; font-size: 11px;">
                                    <thead>
                                        <tr style="font-size: 12px;">
                                            <th style="text-align: left; padding: 12px; border-bottom: 1px solid white;">
                                                DESCRIPTION</th>
                                            <th style="text-align: right; padding: 12px; border-bottom: 1px solid white;">
                                                UNIT PRICE</th>
                                            <th style="text-align: center; padding: 12px; border-bottom: 1px solid white; width: 100px;">
                                                QTY</th>
                                            <th style="text-align: right; padding: 12px; border-bottom: 1px solid white; width: 40px;">
                                                TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody style="color: white;">
                                        @foreach ($products as $product)
                                        <tr>
                                            <td style="padding: 12px; border-bottom: 1px solid #ccc;">{{ $product->name }}</td>
                                            <td style="padding: 12px; text-align: right; border-bottom: 1px solid #ccc;">
                                                {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}</td>
                                            <td style="padding: 12px; text-align: center; border-bottom: 1px solid #ccc;">1
                                            </td>
                                            <td style="padding: 12px; text-align: right; border-bottom: 1px solid #ccc;">
                                                {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}<</td>
                                        </tr>
                                        @endforeach
                                        {{-- <tr>
                                            <td style="padding: 12px; border-bottom: 1px solid #ccc;">Item Name</td>
                                            <td style="padding: 12px; text-align: right; border-bottom: 1px solid #ccc;">
                                                $100.00</td>
                                            <td style="padding: 12px; text-align: center; border-bottom: 1px solid #ccc;">3
                                            </td>
                                            <td style="padding: 12px; text-align: right; border-bottom: 1px solid #ccc;">
                                                $300.00</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 12px; border-bottom: 1px solid #ccc;">Item Name</td>
                                            <td style="padding: 12px; text-align: right; border-bottom: 1px solid #ccc;">
                                                $50.00</td>
                                            <td style="padding: 12px; text-align: center; border-bottom: 1px solid #ccc;">2
                                            </td>
                                            <td style="padding: 12px; text-align: right; border-bottom: 1px solid #ccc;">
                                                $100.00</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 12px; border-bottom: 1px solid #ccc;">Item Name</td>
                                            <td style="padding: 12px; text-align: right; border-bottom: 1px solid #ccc;">
                                                $50.00</td>
                                            <td style="padding: 12px; text-align: center; border-bottom: 1px solid #ccc;">2
                                            </td>
                                            <td style="padding: 12px; text-align: right; border-bottom: 1px solid #ccc;">
                                                $100.00</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 12px;">Item Name</td>
                                            <td style="padding: 12px; text-align: right;">$10.00</td>
                                            <td style="padding: 12px; text-align: center;">2</td>
                                            <td style="padding: 12px; text-align: right;">$20.00</td>
                                        </tr> --}}
                                    </tbody>
                                </table>

                                <table style="width: 100%; border-collapse: collapse; margin-top: 85px;">
                                    <tr>
                                        <td style="text-align: left; font-size: 12px; font-weight: 500; color: #1b1f23;">
                                            THANK YOU
                                        </td>
                                        <td style="text-align: right;">
                                            <table style="float: right; font-size: 12px;">
                                                <tr>
                                                    <td
                                                        style="font-weight: bold; padding-right: 20px; padding-bottom: 20px;">
                                                        SUBTOTAL</td>
                                                    <td style="font-size: 11px; padding-bottom: 20px;">{{ site_currency() . number_format($invoice_amount ?? 0, 2) }}<</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: bold; padding-right: 20px;">DISCOUNT</td>
                                                    <td style="font-size: 11px;">{{ site_currency() . number_format($discount_amount ?? 0, 2) }}</td>
                                                </tr>
                                            </table>
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
                            <table style="width: 100%; color: white; padding: 0px 40px 20px 40px; font-family: 'Poppins'; font-size: 9px;">
                                <tr>
                                    <td style="text-align: left; vertical-align: top;">
                                        <div style="font-weight: bold; font-size: 12px; margin-bottom: 10px;">{{ $company_name }}
                                        </div>
                                        <div style="margin-bottom: 5px;">{!! $company_address !!}</div>
                                        <div>{{ $company_mobile }}</div>
                                    </td>
                                    <td style="text-align: right; vertical-align: bottom;">
                                        <div>support@knowhowtodesign.com</div>
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