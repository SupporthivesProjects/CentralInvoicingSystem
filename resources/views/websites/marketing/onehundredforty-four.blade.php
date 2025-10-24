<!DOCTYPE html>
<html>
<head>
    <title>Your Email Title</title>
</head>
<body style="margin: 0px; padding: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                   <tr>
                        <td style="height: 75px;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse; height: 153px; background: url({{ $invoice_header_image }}) no-repeat;background-position:center;background-size:cover;width: 100%; border-collapse: collapse;">
                                <tr >
                                    <td style="width: 300px;border:0px; height: 50px;padding-top: 25px;" >
                                        <img src="{{ $company_logo }}" alt="" style="height: 60px; justify-content: left;padding-left: 40px;">
                                        </td>
                                        <td style="width: 300px;border:0px;height: 50px;">

                                        </td>
                                        <td style="width: 300px;border:0px;height: 50px;padding-top: 25px;">
                                            <h1 style="justify-content: right; color: white;text-align: right;padding-right: 40px;">INVOICE</h1>
                                        </td>
                                </tr>
                                <tr >
                                    <td colspan="1" style="border-bottom: 0px; color: white;"></td>
                                    <td colspan="1" style="color: white;width: 300px; text-align: left;padding-left: 130px;padding-top: 10px;font-family: Arial;font-size: 9px;">Invoice Date</td>
                                    <td style="color: white;padding-right: 40px;width: 300px;text-align: center;padding-top: 10px;font-family: Arial;font-size: 9px;">: {{ $invoice_date }}</td>
                                </tr>
                                <tr >
                                    <td colspan="1" style="border-bottom: 0px; color: white;"></td>
                                    <td colspan="1" style="color: white;width: 300px; text-align: left;padding-left: 130px;font-family: Arial;font-size: 9px;">Invoice No.</td>
                                    <td style="color: white;padding-right: 40px;width: 300px;text-align: center;font-family: Arial;font-size: 9px;">: #{{ $invoice_number }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                     <!-- Content -->
                    <tr style="width: 100%;">
                        <td style="padding:40px;padding-top:0px; width: 100%;">
                            <table style="width: 100%;">
                                <tr style="width: 100%;">
                                    <div style="display: flex; flex-direction: row; justify-content: space-between;">
                                    <td style="padding-top: 30px;min-width: 200px;vertical-align: top;">
                                        <p style="font-family: arial;font-size: 14px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                            <b>BILLED TO</b>
                                        </p>
                                        <p style="font-family: arial;font-size: 14px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                            <b>{{ $customer_name }}</b>
                                        </p>
                                        <p style="font-family: arial;font-size: 14px;margin: 0px;font-weight: 400;padding-bottom: 5px;color: #8C8C8C;">
                                           {{ $customer_mobile }}
                                        </p>
                                        <p style="font-family: arial;font-size: 14px;margin: 0px;font-weight: 400;padding-bottom: 5px;color: #8C8C8C;">
                                           {{ $customer_email }}
                                        </p>
                                        <br>
                                    </td>
                                    <td style="padding-top: 10px;min-width: 200px;text-align: right;vertical-align: top;">
                                       <p style="font-family: arial;font-size: 14px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                            <b>BILLED FROM</b>
                                        </p>
                                        <p style="font-family: arial;font-size: 14px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                            <b>{{ $site_name }}</b>
                                        </p>
                                        <p style="font-family: arial;font-size: 14px;margin: 0px;font-weight: 400;padding-bottom: 5px;color: #8C8C8C; display: inline-block; width: 180px; text-align: right; word-wrap: break-word;">{{ $company_address }}</p>
                                          <p style="font-family: arial;font-size: 14px;margin: 0px;font-weight: 400;padding-bottom: 5px;color: #8C8C8C;">{{ $company_mobile }}</p>
                                           <p style="font-family: arial;font-size: 14px;margin: 0px;font-weight: 400;padding-bottom: 5px;color: #8C8C8C;">{{ $company_email }}</p>
                                     </td>
                                     </div>
                                </tr>
                            </table>
                            <div style="min-height: 768px !important;">
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                <tr style="border-collapse: collapse;height: 50px; color: white;border-bottom: 1px solid black;border: 0px;">
                                    <td style="padding-left: 2px; width: 500px;text-align: left;font-family: arial;font-size: 14px;margin: 0px;font-weight: 600;border-collapse: collapse;padding-left: 5px;border-right: 1px solid black;background-color: #3C7F79;">
                                       <b>Service</b>
                                    </td>
                                    <td style="width: 200px;text-align: center;font-family: arial;font-size: 14px;margin: 0px;font-weight: 600;border-collapse: collapse;border-right: 1px solid black;background-color: black;">
                                        <b>	Package Type</b>
                                    </td>
                                    <td style="width: 200px;text-align: center;font-family: arial;font-size: 14px;margin: 0px;font-weight: 600; border-collapse: collapse;padding-left: 5px;border-right: 1px solid black;background-color: black;">
                                        <b>Length</b>
                                    </td>
                                    <td style="padding-right: 10px; width: 200px;text-align:right;font-family: arial;font-size: 14px;margin: 0px;font-weight: 600;border-collapse: collapse;background-color: black;">
                                        <b>Amount</b>
                                    </td>

                                </tr>
                                @foreach($products as $product)
                                <tr style="border-collapse: collapse;height: 60px;border-bottom: 0px;border: 0px;border-bottom: 1px solid black;">
                                    <td style="color: #3C7F79; padding-left: 2px; width: 500px;text-align: left;font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;border-right: 1px solid black;">
                                     <b style="color: black">{{ $product->name }}</b>
                                    </td>
                                    <td style="width: 300px;text-align:center;font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;border-right: 1px solid black;">
                                        <!-- Extract package type from product name using string function, eg: Product Name - Package Type -->
                                        {{ substr($product->name, strrpos($product->name, '-') + 1) }}
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;border-right: 1px solid black;">
                                        {{ $product->subscription }}
                                    </td>
                                    <td style="padding-right: 10px; width:100px;text-align:right;font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                      	{{ site_currency() . ' ' . number_format($product->unit_price, 2) }}
                                    </td>

                                </tr>
                                @endforeach
                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>

                                    <td style="width:100px;text-align:center;font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px; border-collapse: collapse; ">
                                       Sub Total
                                    </td>
                                    <td style="padding-right: 10px; width:100px;text-align:right;font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse; ">
                                        {{ site_currency() . ' ' . number_format($invoice_amount + $discount_amount, 2) }}
                                    </td>
                                </tr>
                                 <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;padding-left: 20px; text-align: left;font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>

                                    <td style="width:100px;text-align:center;font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px; border-collapse: collapse; ">
                                       Discount
                                    </td>
                                    <td style="padding-right: 10px; width:100px;text-align:right;font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse; ">
                                        {{ site_currency() . ' ' . number_format($discount_amount, 2) }}
                                    </td>
                                </tr>
                                 <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>

                                    
                                </tr>
                                 <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;padding-left: 20px; text-align: left;font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;color: blue;">
                                     
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>

                                    <td style="width:100px;text-align:center;font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px; border-collapse: collapse;background-color: #3C7F79;color: white; ">
                                       Grand Total
                                    </td>
                                    <td style="padding-right: 10px; width:100px;text-align:right;font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #3C7F79;color: white; ">
                                        {{ site_currency() . number_format($invoice_amount, 2) }}
                                    </td>
                                </tr>

                                <br><br>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <!-- Content End-->

                    <!-----------Footer----------->
                    <tr>
                        <td style="height: 40px;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;">
                                <tr style="height: 45px; background: url({{ $invoice_footer_image }}) no-repeat;background-position:center;background-size:cover;width: 600px; border-collapse: collapse;">
                                    <td style="width: 300px;border:0px" >
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
