<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cambay&display=swap" rel="stylesheet">
<style>
    *{
        margin:0px;
        padding:0px;
    }
</style>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" style="padding:0px;background: url({{ $invoice_image1 }}) no-repeat;background-position:center;background-size:100% 100%;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
                    <!-- Content -->
                    <tr>
                        <td style="padding: 20px;padding-top: 0px;" align="center">
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;width:100%;">
                                <tr style="border-collapse: collapse; height: 100px;">
                                    <td style="width: 200px;padding-left: 10px;padding-top: 20px;padding-bottom: 30px;">

                                        <b
                                            style="font-size: 53px;color: white;font-family: 'Cambay', sans-serif;margin: 0px;font-weight: 400; text-align: left; ">INVOICE</b><br>
                                        <b
                                            style="font-size: 18px;color: white;font-family: 'Cambay', sans-serif;margin: 0px;font-weight: 400; text-align: left;">Invoice
                                            No. : {{ $invoice_number }}</b><br>
                                        <p style="margin: 0px;color: white;">{{ $invoice_date }}</p>

                                    </td>
                                    <td style="width: 400px;text-align: right;padding-right: 10px;">
                                        <img src="{{ $company_logo }}" alt="" style="height: 110px;">
                                    </td>
                                </tr>
                            </table>
                            <table style="background-color: white;border-radius: 10px;width:100%;">
                                <tr style="width:100%;">
                                    <td
                                        style="width: 550px;font-size: 14px;font-family: 'Cambay', sans-serif;font-weight: 300;padding: 20px;padding-bottom: 0px;">
                                        <b>Invoice To : </b>
                                    </td>
                                </tr>
                                <tr style="width:100%;">
                                    <td
                                        style="width: 550px;font-size: 29px;font-family: 'Cambay', sans-serif;font-weight: 400;padding: 20px;padding-top: 0px;padding-bottom: 0px;">
                                        <b>{{ $customer_name }}</b>
                                    </td>
                                </tr>
                            </table>

                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;border-radius: 15px; background-color: white;padding: 10px;margin-top:50px;margin-bottom:50px;height:57vh;">
                                <tr style="border-collapse: collapse;height: 40px;border-bottom: 0px;border: 0px;border-bottom: 2px solid black;padding: 20px;">
                                    <td
                                        style="width: 300px;text-align: left;font-family: 'Cambay', sans-serif;font-size: 13px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 20px;">
                                        <b>Description</b>
                                    </td>
                                    <td
                                        style="width: 100px;text-align: center;font-family: 'Cambay', sans-serif;font-size: 13px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        <b>QTY</b>
                                    </td>
                                    <td
                                        style="width: 200px;text-align:center;font-family: 'Cambay', sans-serif;font-size: 13px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>Unit Price</b>
                                    </td>
                                    <td
                                        style="width:100px;text-align: center;font-family: 'Cambay', sans-serif;font-size: 13px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 20px;">
                                        <b>Total</b>
                                    </td>
                                </tr>
                                
                                <tr  style="border-collapse: collapse;height: 40px;border-bottom: 0px;border: 0px;padding: 20px;">
                                    @foreach($products as $product)            
                                    <td
                                        style="width: 300px;text-align: left;font-family: 'Cambay', sans-serif;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 20px;">
                                        <b>{{ $product->name }}</b>
                                    </td>
                                    <td
                                        style="width: 100px;text-align: center;font-family: 'Cambay', sans-serif;font-size: 12px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        <b>1</b>
                                    </td>
                                    <td
                                        style="width: 200px;text-align:center;font-family: 'Cambay', sans-serif;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>{{ site_currency() }} {{  number_format($product->unit_price, 2) }}</b>
                                    </td>
                                    <td
                                        style="width:100px;text-align: center;font-family: 'Cambay', sans-serif;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 20px;">
                                        <b>{{ site_currency() }} {{  number_format($product->unit_price, 2) }}</b>
                                    </td>
                                </tr>
                                    @endforeach

                                <tr style="border-collapse: collapse;height: 10px;border-bottom: 0px;border: 0px;">
                                    <td
                                        style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">

                                    </td>
                                    <td
                                        style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">

                                    </td>
                                </tr>

                                <tr
                                    style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;padding: 20px">
                                    <td
                                        style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width:155px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: arial;font-size: 13px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        <b>SUBTOTAL</b>
                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: arial;font-size: 13px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                        <b>{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</b>
                                    </td>
                                </tr>
                                <tr
                                    style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;padding: 20px; ;">
                                    <td
                                        style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width:155px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: arial;font-size: 13px;margin: 0px;font-weight: 400; border-collapse: collapse;border-bottom: 2px solid black">
                                        <b>DISCOUNT</b>
                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: arial;font-size: 13px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;border-bottom: 2px solid black">
                                        <b>{{ site_currency() }} {{ number_format(( $discount_amount), 2) }}</b>
                                    </td>
                                </tr>

                                <tr
                                    style="border-collapse: collapse;height: 50px;border-bottom: 0px;border: 0px;padding: 20px;">
                                    <td
                                        style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width:155px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: arial;font-size: 13px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        <b>TOTAL</b>
                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: arial;font-size: 20px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                        <b>{{ site_currency() }} {{ number_format(($invoice_amount), 2) }}</b>
                                    </td>
                                </tr>

                            </table>

                            <table style="background-color: white;border-radius: 10px;width:100%;">
                                <tr style="width:100%;">
                                    <td style="width: 300px;font-size: 12px;font-family: 'Cambay', sans-serif;padding: 20px;padding-bottom: 20px;">
                                        <b>{{$company_name}}</b><br>
                                        <b>{{$company_email}}</b>
                                    </td>

                                    <td
                                        style="width: 300px;font-size: 29px;font-family: 'Cambay', sans-serif;font-weight: 200;padding: 20px;padding-bottom: 0px;text-align: right;font-weight: 400;">
                                        <b>Thank You! </b>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    <!-- Content End-->
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
