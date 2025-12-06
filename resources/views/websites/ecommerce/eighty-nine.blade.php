<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>

<body style="margin: 0px; padding: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0; height: 130px;">
                            <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                                <tr>
                                    <td style="
                                        background: url('{{ $invoice_header_image }}') no-repeat center;background-size: cover;height: 130px;">
                                        <table align="right">
                                            <tr>
                                                <td
                                                    style="padding: 30px; text-align: right; width: 40%; vertical-align: middle; font-family: 'Dubai';">
                                                    <span style="font-size: 26px; font-weight: bold;">INVOICE</span><br>
                                                    <span style="font-size: 10px;">NO. {{ $invoice_number }}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td
                            style="padding:40px;padding-top:0px;background:#ffffff; background-repeat: no-repeat;background-position: center;background-size: cover;height:444px; font-family: 'Dubai';">
                            <table style="width: 100%; font-size: 10px; border-collapse: collapse; margin-top: 20px;">
                                <tr>
                                    <!-- INVOICE TO -->
                                    <td style="width: 50%; vertical-align: top; padding: 10px;">
                                        <span style="color: #f36c6c; font-weight: bold; font-size: 14px;">INVOICE
                                            TO:</span><br>
                                        <span style="font-size: 20px; font-weight: bold; font-size: 16px;">{{ $customer_name  }}</span><br>
                                        <!-- <span>Email: {{ $customer_email }}</span> -->
                                    </td>

                                    <!-- INVOICE FROM -->
                                    <td style="width: 50%; vertical-align: top; padding: 10px;">
                                        <span style="color: #f36c6c; font-weight: bold; font-size: 14px;">INVOICE
                                            FROM:</span><br>
                                        <span style="font-size: 20px; font-weight: bold; font-size: 16px;">{{ $site_name }} </span><br>
                                        <span>{!! $company_address !!}</span><br>
                                        <span>Phone: {{ $company_mobile }}</span><br>
                                        <span>Email: {{ $company_email }} </span>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <div style="min-height: 738px !important;">
                                <table style="width: 100%; border-collapse: collapse;  font-size: 10px;">
                                    <!-- Table Header -->
                                    <tr>
                                        <th
                                            style="background-color: #EA7780; color: white; text-align: left; padding: 10px;">
                                            Product Description</th>
                                        <th style="background-color: #0c0032; color: white; padding: 10px;">Price</th>
                                        <th style="background-color: #0c0032; color: white; padding: 10px;">QTY.</th>
                                        <th style="background-color: #0c0032; color: white; padding: 10px;">Total</th>
                                    </tr>

                                    @foreach($products as $product)
                                    <tr style="background-color: #f9f9f9;">
                                        <td style="padding: 10px;">
                                            <strong>{{ $product->name }}</strong><br>
                                            <span style="color: #666; font-weight: bold;">{{ $product->category_name }}</span>
                                        </td>
                                        <td style="text-align: center;">{{ site_currency() }} {{  number_format($product->unit_price, 2) }}</td>
                                        <td style="text-align: center;">1</td>
                                        <td style="text-align: center;">{{ site_currency() }} {{  number_format($product->unit_price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="2" style="border: none;"></td>
                                        <td style="text-align: right; padding: 10px;"><strong>Subtotal:</strong></td>
                                        <td style="text-align: center; font-weight: bold;">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="border: none;">
                                            <strong>Total Due</strong><br>
                                            <span style="color: #EA7780; font-size: 14px;"><strong>{{ site_currency() }} {{ number_format($invoice_amount, 2) }} {{ site_currency_code() }}</strong></span>
                                        </td>
                                        <td style="text-align: right; padding: 10px; font-weight: bold;">Discount:</td>
                                        <td style="text-align: center; font-weight: bold;">{{ site_currency() }} {{ number_format($discount_amount, 2) }}</td>
                                    </tr>

                                    <!-- Final Total -->
                                    <tr>
                                        <td colspan="3"
                                            style="background-color: #EA7780; color: white; padding: 10px; text-align: left;">
                                            <strong>Total:</strong></td>
                                        <td style="background-color: #EA7780; color: white; text-align: center;">
                                            <strong>{{ site_currency() }} {{ number_format($invoice_amount, 2) }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                            <!-- <table width="100%" cellpadding="0" cellspacing="0"
                                style="font-size: 10px; color: #333;  width: 80%;">
                                <tr>
                                    <td style="padding: 10px;">
                                        <span style="color: #f08a8a; font-weight: bold;">Note</span><br>
                                        Please ensure that the payment is made by the due date mentioned above.<br>
                                        This invoice is generated based on the information provided at the time of service.<br>
                                        If you have any questions or discrepancies, kindly contact our support team at support@example.com.<br>
                                        Thank you for your business.
                                    </td>
                                </tr>
                            </table> -->





                            <!-- TOTALS SECTION -->


                        </td>
                    </tr>
                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;">
                                <tr style="background: url('{{ $invoice_footer_image }}') no-repeat;background-position: center;background-size: cover;height:60px;padding:50px;background-size:cover;width: 100%;">
                                    <td>
                                        <table cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse; padding-left: 40px; margin-left: 40px;" align="start">
                                                        <tr>
                                                            <td>
                                                                <table>
                                                                    <tr>
                                                                        <td>
                                                                            <img src="{{ $invoice_image1 }}" alt="" style="width:24px;">
                                                                        </td>
                                                                         <td>
                                                                            <p style="font-size: 10px;font-family: Calibri;color: #ffffff;margin: 0px;"> {{ $company_mobile }}</p>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td style="padding-left: 10px;">
                                                                <table>
                                                                    <tr>
                                                                        <td>
                                                                            <img src="{{ $invoice_image2 }}" alt="" style="width:24px;">
                                                                        </td>
                                                                         <td>
                                                                            <p style="font-size: 10px;font-family: Calibri;color: #ffffff;margin: 0px;text-decoration: underline;"> {{ $company_email }} </p>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td style="padding-left: 10px;">
                                                                 <table>
                                                                    <tr>
                                                                        <td>
                                                                            <img src="{{ $invoice_image3 }}" alt="" style="width:24px;">
                                                                        </td>
                                                                         <td>
                                                                            <p style="font-size: 10px;font-family: Calibri;color: #ffffff;margin: 0px;">{!! $company_address !!}</p>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                        </table>
                                    </td>
                                    <td style="vertical-align: top;">
                                        <img src="{{ $invoice_image4 }}" alt="" style="height:30px;">
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