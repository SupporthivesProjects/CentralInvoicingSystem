<!DOCTYPE html>
<html>
<head>
    <title>Your Email Title</title>
    <style>
        body{
            margin: 0px;
            padding: 0px;
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr style="background: url('{{ $invoice_header_image }}') no-repeat;background-position:center;background-size:cover;text-align: center;height: 150px;width: 100%;">
                        <td>
                            <table>
                                <tr>
                                   <img src="{{ $company_logo }}" alt="" style="height:70px;padding-bottom:40px;">
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td style="padding:40px;padding-top:0px;">
                            <table>
                                <tr>
                                    <td style="text-align: center; align-items: center;">
                                       <h1 style="color:#474748;text-align: center;margin: 0px;font-size: 36;font-family: Arial;">
                                        INVOICE
                                       </h1>
                                       <img src="{{ $invoice_image3 }}" alt="" style="height:20px;">
                                    </td>
                                </tr>
                            </table>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;margin-top: 20px;">
                                <tr>
                                    <td>
                                       <p style="color:#474748;font-family: arial;font-size: 10px;">
                                        <b>To:</b> {{ $customer_name }}
                                       </p>
                                       <p style="color:#474748;font-family: arial;font-size: 10px;">
                                        <b>From:</b> https://dezignlogic.com/
                                       </p>
                                    </td>
                                    <td style="text-align: end;">
                                        <p style="color:#474748;font-family: arial;font-size: 10px;">
                                         <b>Invoice no: </b> #{{ $invoice_number }}
                                        </p>
                                        <p style="color:#474748;font-family: arial;font-size: 10px;">
                                         <b>Date:</b> {{ $invoice_date }}
                                        </p>
                                     </td>
                                </tr>
                            </table>
                           <br>
                           <div style="min-height: 620px !important;">
                            <table style="border-collapse: collapse;">
                                <tr style="height:40px;border-top: 1px solid #474748;border-bottom: 1px solid #474748;">
                                    <td style="width: 250px;padding: 10px;">
                                       <p style="font-family: arial;font-size: 10px;color:#474748;margin: 0px;font-weight: 700;">
                                          PRODUCTS
                                       </p>
                                    </td>
                                   <td style="width:150px;padding: 10px;">
                                       <p style="font-family: arial;font-size: 10px;color:#474748;margin: 0px;font-weight: 700;text-align: center;">
                                          Type
                                       </p>
                                    </td>
                                    <td style="width:150px;padding: 10px;">
                                       <p style="font-family: arial;font-size: 10px;color:#474748;margin: 0px;font-weight: 700;text-align: center;">
                                          Quantity
                                       </p>
                                    </td>
                                    <td style="width:150px;padding: 10px;">
                                       <p style="font-family: arial;font-size: 10px;color:#474748;margin: 0px;font-weight: 700;text-align: center;">
                                          Price
                                       </p>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr style="height:40px;">
                                    <td style="width: 250px;padding: 10px;">
                                       <p style="font-family: arial;font-size: 10px;color:#474748;margin: 0px;font-weight: 700;">
                                          {{ $product->name }}
                                       </p>
                                    </td>
                                   <td style="width:150px;padding: 10px;">
                                       <p style="font-family: arial;font-size: 10px;color:#474748;margin: 0px;font-weight: 700;text-align: center;">
                                          {{ $product->category_name }}
                                       </p>
                                    </td>
                                    <td style="width:150px;padding: 10px;">
                                       <p style="font-family: arial;font-size: 10px;color:#474748;margin: 0px;font-weight: 700;text-align: center;">
                                         01
                                       </p>
                                    </td>
                                    <td style="width:150px;padding: 10px;">
                                       <p style="font-family: arial;font-size: 10px;color:#474748;margin: 0px;font-weight: 700;text-align: center;">
                                          {{ site_currency() . number_format($product->unit_price, 2) }}
                                       </p>
                                    </td>
                                </tr>
                                @endforeach
                                <tr style="height:10px;border-bottom: 1px solid #474748;"></tr>
                                <tr style="height:24px;">
                                    <td colspan="3">
                                       <p style="font-family: arial;font-size: 10px;color:#474748;margin: 0px;font-weight:400;text-align:right;">
                                         Sub Total
                                       </p>
                                    </td>
                                    <td>
                                       <p style="font-family: arial;font-size: 10px;color:#474748;margin: 0px;font-weight:400;text-align: center;">
                                          {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                       </p>
                                    </td>
                                </tr>
                                <tr style="height:24px;">
                                    <td colspan="3">
                                       <p style="font-family: arial;font-size: 10px;color:#2F5496;margin: 0px;font-weight:400;text-align:right;">
                                         Discount
                                       </p>
                                    </td>
                                    <td>
                                       <p style="font-family: arial;font-size: 10px;color:#474748;margin: 0px;font-weight:400;text-align: center;">
                                          {{ site_currency() . number_format($discount_amount, 2) }}
                                       </p>
                                    </td>
                                </tr>
                                <tr style="height:24px;">
                                    <td colspan="2"></td>
                                    <td style="border-top: 1px solid #474748;">
                                       <p style="font-family: arial;font-size: 10px;color:#474748;margin: 0px;font-weight:700;text-align:right;">
                                         Grand Total
                                       </p>
                                    </td>
                                    <td style="border-top: 1px solid #474748;">
                                       <p style="font-family: arial;font-size: 10px;color:#474748;margin: 0px;font-weight:700;text-align: center;">
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
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;">
                                <tr style="background: url('{{ $invoice_footer_image }}') no-repeat;background-position:center;background-size: cover;height:100px;background-size:cover;">
                                    <td>
                                        <table>
                                            <tr>
                                                <td style="padding: 0px;" align="center">
                                                    <img src="{{ $invoice_image2 }}" style="width:32px">
                                                </td>
                                                <td style="padding: 0px;" align="center">
                                                    <img src="{{ $invoice_image1 }}" style="width:28px;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="width:300px;">
                                                    <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight:400;color:whitesmoke;">
                                                        Queries@rabianenterprises.com
                                                    </p>
                                                </td>
                                                <td align="center" style="width:300px;">
                                                    <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight:400;color:whitesmoke;">
                                                        BIZ00651, Compass Building, Al Shohada <br>
                                                         Road, AL Hamra
                                                    Industrial Zone-FZ, Ras <br>
                                                     Al Khaimah, United Arab Emirates
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
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
