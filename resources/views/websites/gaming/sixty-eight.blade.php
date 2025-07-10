<!DOCTYPE html>
<html>
<head>
    <title>Your Email Title</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;max-height: 130px;">
                            <table>
                                <tr>
                                    <td style="height: 150px; background: url('{{ $invoice_header_image }}') no-repeat;background-position:center;background-size:cover;width: 600px;">
                                         <img src="{{ $company_logo }}" alt="" style="margin: auto; padding-left: 60px; height: 20px;"><img src="Picture5.png" alt="" style="margin: auto;padding-left: 150px; height: 20px;">
                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                     <!-- Content -->
                    <tr >
                        <td style="padding:60px;padding-top:0px;">
                            <table>
                                <tr>
                                    <td style="padding-top: 10px;">
                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            <b>Invoice Number:</b>  #{{ $invoice_number }}
                                        </p><br>
                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            <b>Date</b> {{ $invoice_date }}
                                        </p>
                                        <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 10px;width: 200px;">
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;background-color: #E6BE5D;border-left: 1px solid #E6BE5D; border-radius: 10px; text-align: left; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                            <b>BILLED FROM:</b>
                                        </p>
                                     <td style="padding-top: 10px;width: 200px;">
                                       <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;background-color: #E6BE5D;border-left: 1px solid #E6BE5D; border-radius: 10px; text-align: left; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                            <b>BILLED TO:</b>
                                        </p>
                                     </td>
                                </tr>
                                 <tr>
                                    <td style="padding-top: 10px;width: 300px;">
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; text-align: left;padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                            <b>KROKOFGOLD</b>
                                        </p>
                                     <td style="padding-top: 10px;width: 300px;">
                                       <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                            <b>{{ $customer_name }}</b>
                                        </p>
                                     </td>
                                </tr>
                            </table>


                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                <tr style="border-collapse: collapse;height: 30px;background-color: #E6BE5D;border-radius: 10px; border-bottom: 0px;border: 0px;">
                                    <td style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px; border-top-left-radius: 20px; border-bottom-left-radius: 20px;">
                                       <b>ITEM</b>
                                    </td>
                                    <td style="width: 400px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>	Description</b>
                                    </td>
                                    <td style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        <b>QTY</b>
                                    </td>
                                    <td style="width: 200px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>UNIT PRICE</b>
                                    </td>
                                    <td style="width:200px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-top-right-radius: 20px;border-bottom-right-radius: 20px;padding-right: 10px; ">
                                        <b>TOTAL</b>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;border-bottom: 1px solid black;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;padding-left: 5px;">
                                      {{ $product['name'] }}
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        {{ $product['game_currency_amount'] }} {{ $product['game_currency'] }}
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        1
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                       {{ $currency . number_format($product['unit_price'], 2) }}
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                       {{ $currency . number_format($product['unit_price'], 2) }}
                                    </td>
                                </tr>
                                @endforeach

                                 <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        SUBTOTAL
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                        {{ $site_currency . number_format($invoice_amount + $discount_amount, 2) }}
                                    </td>
                                </tr>
                                  <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        DISCOUNT
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                        {{ $site_currency . number_format($discount_amount, 2) }}
                                    </td>
                                </tr>
                                 <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;background-color: #E6BE5D;border-bottom-left-radius: 20px;border-top-left-radius: 20px; ">
                                        <b>GRAND TOTAL</b>
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #E6BE5D;">

                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #E6BE5D;border-bottom-right-radius: 20px;border-top-right-radius: 20px;padding-right: 10px; ">
                                        {{ $site_currency . number_format($invoice_amount, 2) }}
                                    </td>
                                </tr>
                                <br><br>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End-->

                    <!-----------Footer----------->
                    <tr>
                        <td style="height: 130px;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;">
                                <tr style="background: url('{{ $invoice_footer_image }}') no-repeat;background-position: center;background-size: cover;height:141px;padding:50px;background-size:cover;width: 100%;">
                                    <td style="width: 150px;">
                                        <p style="text-align: center;font-family: arial;font-size: 10px;margin: 0px;color: white;">
                                            <img src="{{ $invoice_image2 }}" alt="" style="padding-right: 5px; height: 10px; ">www.krokofgold.com
                                        </p>
                                    </td>
                                    <td style="width: 200px;">
                                        <p style="text-align: center;font-family: arial;font-size: 10px;margin: 0px;color: white;">
                                           <img src="{{ $invoice_image3 }}" alt="" style="padding-right: 5px; height: 10px; "> support@krokofgold.com
                                        </p>
                                    </td>
                                    <td style="width: 200px;">
                                        <p style="text-align: left;font-family: arial;font-size: 10px;margin: 0px;padding-top: 0px;color: white;">
                                           <img src="{{ $invoice_image4 }}" alt="" style="padding-right: 5px; height: 10px; "> United Arab Emirates</p>
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
