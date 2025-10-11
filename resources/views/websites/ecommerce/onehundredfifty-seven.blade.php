<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Invoice</title>
    <style>
        .for_bttom {
            position: fixed;
            bottom: -2px;
            left: 0;
            right: 0;
            width: 100%;
        }
    </style>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #fff;">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" style="border-collapse: collapse; background-color: #ffffff">
        <!-- Header Space -->
        <tr>
            <td colspan="6" style="padding: 0px 0px 40px; margin: 0">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse">
                    <tr>
                        <td style="background-image: url('{{ $invoice_image1 }}'); background-repeat: no-repeat; background-position: center; background-size: cover; height: 180px; position: relative; padding: 0;">
                            <!-- Logo -->
                            <img src="{{ $company_logo }}" alt="Logo" style="height: 70px; position: absolute; top: 20px; right: 94px;" />
                            <!-- INVOICE Text -->
                            <div style="position: absolute; top: 105px; font-size: 42px; font-weight: bold; color: white; text-align: center; width: 353px;">
                                INVOICE
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr >
                        <td style="padding:30px 60px 60px 60px;">
                            <table border="0" style="border-collapse: collapse;width: 100%;">


                                    <!-- BILL FROM / BILL TO -->
                                    <tr>
                                        <td colspan="1" style="padding: 10px; background-color: #f1e9df; font-weight: bold">BILL FROM</td>
                                        <td colspan="1" style="padding: 10px; background-color: #ffffff; font-weight: bold ; min-width: 30px"></td>
                                        <td colspan="3" style="padding: 10px; background-color: #f1e9df; font-weight: bold">BILL TO</td>
                                    </tr>
                                    <tr>
                                        <td colspan="1" style="padding: 10px; border-bottom: 1px solid #ddd; font-size: 14px">
                                            <strong>{{ $site_name }}</strong><br />
                                            {{ $company_address }}<br />
                                            <strong>Phone :</strong> {{ $company_mobile }}<br />
                                            <strong>Email :</strong> {{ $company_email }}
                                        </td>
                                        <td colspan="1" style="padding: 10px; border-bottom: 1px solid #ddd; font-size: 14px; min-width: 30px"></td>
                                        <td colspan="3" style="padding: 10px; border-bottom: 1px solid #ddd; font-size: 14px">
                                            <strong>{{ $customer_name }}</strong><br />
                                            <!-- <strong>Phone :</strong> {{ $customer_mobile }}<br />
                                            <strong>Email :</strong> {{ $customer_email }} -->
                                        </td>
                                    </tr>
                                    <tr style="height:40px;"></tr>

                                    <!-- ITEM TABLE HEADERS -->
                                    <tr style="background-color: #f1e9df; font-weight: bold; text-align: left">
                                        <td style="padding: 10px; border: 1px solid #ddd" colspan="2">ITEM</td>
                                        <!-- <td style="padding: 10px; border: 1px solid #ddd" colspan="2">DESCRIPTION</td> -->
                                        <td style="padding: 10px; border: 1px solid #ddd">QTY</td>
                                        <td style="padding: 10px; border: 1px solid #ddd">UNIT PRICE</td>
                                        <td style="padding: 10px; border: 1px solid #ddd">TOTAL</td>
                                    </tr>
                                    @foreach($products as $product)
                                    <tr style="border-bottom: 1px solid grey;">
                                        <td style="padding: 10px" colspan="2">{{ $product->name }}</td>
                                        <!-- <td colspan="2" style="padding: 10px">{!! \Illuminate\Support\Str::limit(strip_tags($product->description), 150) !!}</td> -->
                                        <td style="padding: 10px">1</td>
                                        <td style="padding: 10px">{{ site_currency() }} {{ number_format($product->unit_price, 2) }}</td>
                                        <td style="padding: 10px">{{ site_currency() }} {{ number_format($product->unit_price, 2) }}</td>
                                    </tr>
                                    @endforeach

                                    <!-- TOTAL SECTION -->
                                    <tr>
                                        <td colspan="3"></td>
                                        <td colspan="3" style="padding: 20px 10px">
                                            <table width="100%" cellpadding="5">
                                                <tr style="border-bottom: 1px solid grey;">
                                                    <td style="text-align: right">SUBTOTAL</td>
                                                    <td style="text-align: right">{{ site_currency() }} {{  number_format(($invoice_amount + $discount_amount), 2) }}</td>
                                                </tr>
                                                <tr style="border-bottom: 1px solid grey;">
                                                    <td style="text-align: right">DISCOUNT (5%)</td>
                                                    <td style="text-align: right">{{ site_currency() }} {{  number_format(($discount_amount), 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right; font-weight: bold">GRAND TOTAL</td>
                                                    <td style="text-align: right; font-weight: bold">{{ site_currency() }} {{  number_format(($invoice_amount), 2) }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

        </table>
                        </td>
                    </tr>

     

        <!-- Footer Space -->
        <!-- Footer Section -->
        <tr>
            <td colspan="6" style="padding: 0; margin: 0;">
                <!-- <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                    <tr>
                        <td style="background-image: url('{{ $invoice_footer_image }}'); background-repeat: no-repeat; background-position: center; background-size: cover; padding: 30px; font-size: 14px; color: #000;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                <tr>
                                    <td style="vertical-align: top; width: 60%;">
                                        <p style="margin: 0; padding-bottom: 10px;"><strong>Phone :</strong> {{ $company_mobile }}</p>
                                        <p style="margin: 0; padding-bottom: 10px;"><strong>Email :</strong> {{ $company_email }}</p>
                                        <p style="margin: 0;"><strong>Website :</strong> {{ $site->site_link }}</p>
                                    </td>
                                    <td style="vertical-align: top; text-align: right;">
                                        <p style="margin: 0; padding-bottom: 10px;">{{ $company_address }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table> -->
                <div style="width: 100%; background-image: url('{{ $invoice_footer_image }}'); background-repeat: no-repeat; background-position: center; background-size: cover; padding: 30px; font-size: 14px; color: #000; box-sizing: border-box;" class="for_bttom">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap;">
                        <!-- Left Column -->
                        <div style="width: 60%; min-width: 250px;">
                        <p style="margin: 0; padding-bottom: 10px;"><strong>Phone :</strong> {{ $company_mobile }}</p>
                        <p style="margin: 0; padding-bottom: 10px;"><strong>Email :</strong> {{ $company_email }}</p>
                        <p style="margin: 0;"><strong>Website :</strong> {{ $site->site_link }}</p>
                        </div>

                        <!-- Right Column -->
                        <div style="text-align: right; min-width: 200px;">
                        <p style="margin: 0; padding-bottom: 10px;">{{ $company_address }}</p>
                        </div>
                    </div>
                </div>

            </td>
        </tr>
    </table>
</body>
</html>
