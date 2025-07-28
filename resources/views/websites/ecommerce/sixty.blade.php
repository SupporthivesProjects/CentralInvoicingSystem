<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); background-image: url('{{ $invoice_image1 }}'); background-repeat: no-repeat; background-position: center right; background-size: cover;">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;max-height: 130px;">
                            <table>
                                <tr>
                                    <td style="width:300px;padding: 115px 40px 20px;text-align: left;">
                                        <p
                                            style="margin: 0px;font-weight: 400; font-family: 'BASKERVILLE SEMIBOLD'; font-size: 14px; font-style: italic;">
                                            <span
                                                style="color: #901918; font-family: 'BASKERVILLE SEMIBOLD'; font-size: 14px; font-style: italic; font-weight: 800;">INVOICE
                                                # </span>{{ $invoice_number }}
                                        </p>
                                        <p
                                            style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400; font-family: 'BASKERVILLE SEMIBOLD'; font-size: 14px; font-style: italic;">
                                            <span
                                                style="color: #901918; font-family: 'BASKERVILLE SEMIBOLD'; font-size: 14px; font-style: italic; font-weight: 800;">DATE
                                                :</span> {{ $invoice_date }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td style="padding:40px; padding-top:0px; height:444px; text-align: -webkit-center;">
                            <table
                                style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; border: 1px solid #f1cccc;">
                                <tr>
                                    <th
                                        style="background-color: #f4c4c4; text-align: left; padding: 10px; font-weight: bold; width: 50%; font-family: 'BASKERVILLE SEMIBOLD'; font-size: 10px;">
                                        Billed To</th>
                                    <th
                                        style="background-color: #f4c4c4; text-align: left; padding: 10px; font-weight: bold; font-family: 'BASKERVILLE SEMIBOLD'; font-size: 10px;">
                                        Billed From</th>
                                </tr>
                                <tr style="background-color: #f7f4ef;">
                                    <td style="padding: 15px; display: flex; ">
                                        <strong style="display: inline-block; width: 60px; font-family: 'BASKERVILLE SEMIBOLD'; font-size: 10px;">Name</strong>
                                        <span style="color: #2f4f4f; font-family: 'BASKERVILLE SEMIBOLD'; font-size: 10px; ">{{ $customer_name  }}</span>
                                    </td>
                                    <td style="padding: 15px;border: 1px solid pink">
                                        <strong style="display: inline-block; width: 60px; font-family: 'BASKERVILLE SEMIBOLD'; font-size: 10px;">Name</strong>
                                        <span style="color: #2f4f4f; font-family: 'BASKERVILLE SEMIBOLD'; font-size: 10px;">{{ $company_name  }}<br>{{ $site_name }}</span>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <div style="min-height: 450px !important;">
                            <table style="width: 100%; border-collapse: collapse; font-family: 'BASKERVILLE SEMIBOLD'; font-size: 10px; border: 1px solid #f1cccc;">
                                <thead>
                                    <tr style="background-color: #f4c4c4;">
                                        <th style="text-align: left; padding: 10px;" >Qty.</th>
                                        <th style="text-align: left; padding: 10px;">Product Name</th>
                                        <th style="text-align: right; padding: 10px;">Unit price</th>
                                        <th style="text-align: right; padding: 10px;">Total</th>
                                    </tr>
                                </thead>
                                <tbody style="background-color: #f7f4ef;">
                                @foreach ($products as $product)
                                    <tr>
                                        <td style="padding: 10px;border: 1px solid pink">{{ $product->quantity ?? 1 }}</td>
                                        <td style="padding: 10px;border: 1px solid pink">{{ $product->name }}</td>
                                        <td style="padding: 10px;border: 1px solid pink; text-align: right;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                        <td style="padding: 10px; text-align: right;border: 1px solid pink">{{ site_currency() . number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}</td>
                                    </tr>
                                @endforeach

                                    <!-- Subtotal and Discount -->
                                    <tr>
                                        <td colspan="3" style="text-align: right; padding: 10px;">Subtotal</td>
                                        <td style="text-align: right; padding: 10px;border: 1px solid pink">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="text-align: right;border: 1px solid pink; padding: 10px;">Discount Total</td>
                                        <td style="text-align: right; padding: 10px;border: 1px solid pink">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr style="background-color: #f4c4c4;">
                                        <td colspan="3" style="text-align: right; padding: 12px; font-weight: bold;">
                                            Total</td>
                                        <td style="text-align: right; padding: 12px; font-weight: bold;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                            </div>
                            <table style="text-align: center;">
                                <tr text-align: center;>
                                    <td
                                        style="font-family: 'Baskerville'; font-size: 9px; text-align: center; padding: 20px;">
                                        <p style="margin: 0; color: #333;">
                                            <span style="color: #000; ">{{ $company_email  }}</span>
                                            <span style="color: red;"> | </span>
                                            <span style="color: #000;">{{ $site_name }}</span>
                                            <span style="color: red;"> | </span>
                                            <span style="color: #000;">{{ $company_mobile }}</span>
                                        </p>

                                        <!-- Company Name -->
                                        <p
                                            style="margin: 10px 0 5px 0; font-family: 'Baskerville'; font-size: 9px; font-weight: 800;">
                                           {{ $company_name }}
                                        </p>

                                        <!-- Address -->
                                        <p style="margin: 0; font-family: 'Baskerville'; font-size: 9px;">
                                           {!! $company_address !!}
                                        </p>
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
                                    style="background: url(img/footer_bg.png) no-repeat;background-position: center;background-size: cover;height:141px;padding:50px;background-size:cover;width: 100%;">
                                    <td style="text-align:center;">
                                    </td>
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