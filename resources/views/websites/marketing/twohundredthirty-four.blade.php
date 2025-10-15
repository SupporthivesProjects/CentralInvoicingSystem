<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            <td align="center" bgcolor="#f2f2f2" style="">
                <table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; background: url('{{ $invoice_image1 }}') no-repeat;background-position: center;background-size: 100% 100%;">
                    <!-- Header -->
                    <tr>
                        <td style="padding-left: 40px;">
                            <table>
                                
                               
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                     <!-- Content -->
                    <tr >
                        <td style="padding:40px;padding-top:40px;height:444px;">
                            <table style="border-collapse: collapse;;">
                               <tr>
                                    <td style=" width: 600px; font-family: 'Poppins', sans-serif; ">
                                        <b style="font-size: 26px; margin-bottom: 0px; color: #F15A22;">Invoice</b><br>
                                        <b style="font-size: 11px;">Digital Marketing Services</b>
                                        
                                    </td>
                                    <td style="width: 600px;text-align: right;padding-right: 20px;padding-top: 45px;">
                                        <img src="{{ $company_logo }}" alt="" style="height:60px;padding-bottom: 10px;">
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p style="font-size: 11px; font-family: 'Poppins', sans-serif;">Mindcraft Vision Media Applications<br> Development L.L.C</p>
                                    </td>
                                    <td style="text-align: right; font-family: 'Poppins', sans-serif;">
                                        <p style="font-size: 11px;margin-top: 0px;"><b style="color: #F15A22;">Invoice No:</b> #{{ $invoice_number }}</p>
                                        <p style="font-size: 11px;"><b style="color: #F15A22;">Date:</b> {{ $invoice_date }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 11px; font-family: 'Poppins', sans-serif;">
                                        <p style="color: #F15A22; font-weight: 600;">Billed to:</p>
                                        <p>{{ $customer_name ? $customer_name : '' }}<br>
                                            {{ $customer_email ? $customer_email : '' }}<br>
                                            {{ $customer_mobile ? $customer_mobile : '' }}
                                        </p>
                                    </td>
                                </tr>
                                
                            </table>
                            <br>

                             <table style="border-collapse: collapse;">
                                <tr style="border-collapse: collapse;height: 24px;border-bottom: 1px solid black; color: #F15A22; font-family: 'Poppins', sans-serif;">
                                    <td style="width: 400px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-right: 1px solid black;">
                                       <b>Descriptions</b> 
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-right: 1px solid black;">
                                        <b>Package</b>
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-right: 1px solid black;">
                                        <b>Duration</b>
                                    </td>
                                    <td style="width: 100px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>AMOUNT</b>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr style="border-collapse: collapse;height: 24px;border-top: 1px solid black;border-bottom: 1px solid black;font-family: 'Poppins', sans-serif;">
                                    <td style="width: 400px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-right: 1px solid black;">
                                        {{ $product->name }}
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-right: 1px solid black;">
                                        {{ $packageName = trim(explode('-', $product->name)[1] ?? '') }}
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-right: 1px solid black;">
                                        {{ $product->subscription ?? '-' }}
                                    </td>
                                    <td style="width: 100px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        {{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                                 <tr style="border-top: 1px solid black;border-bottom: 1px solid black; height: 24px;font-family: 'Poppins', sans-serif;">
                                    <td colspan="1"></td>
                                    <td colspan="2" style="padding-right: 20px; width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-right: 1px solid black;">
                                        <b>Subtotal</b>
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                       <b>{{ site_currency_code() }}{{ number_format($invoice_amount + $discount_amount, 2) }}</b>
                                    </td>
                                </tr>
                                 <tr style="border-top: 1px solid black; height: 24px;font-family: 'Poppins', sans-serif;">
                                    <td colspan="1"></td>
                                    <td colspan="2" style="padding-right: 20px; width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-right: 1px solid black;">
                                        <b>Total (With Discount Applied)</b>

                                        </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>{{ site_currency_code() }}{{ number_format($invoice_amount, 2) }}</b>
                                        </td>
                                </tr>
                            </table>
                            <br>
                            <br>
                        </td>
                    </tr>
                    <!-- Content End-->

                    <!-----------Footer----------->
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
                                 <tr style="border-collapse: collapse; height: 80px;font-family: 'Poppins', sans-serif;">
                                    <td style=" text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #5E5E5E;padding-left: 40px;padding-top: 10px;">
                                       <img src="{{ $invoice_image2 }}" alt="" style="height: 25px;">
                                    </td>
                                    <td style=" width: 200px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #5E5E5E;padding-top: 10px;">
                                       <p>{{ $company_email }}</p>
                                    </td>
                                    <td style="text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #5E5E5E;padding-top: 10px;padding-left: 5px;">
                                       <img src="{{ $invoice_image3 }}" alt="" style="height: 25px;">
                                    </td>
                                    <td style=" width: 200px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #5E5E5E;padding-top: 10px;">
                                       <p>{{ $company_mobile }}</p>
                                    </td>
                                    <td style="text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #5E5E5E;padding-top: 10px;padding-left: 5px;">
                                       <img src="{{ $invoice_image4 }}" alt="" style="height: 25px;">
                                    </td>
                                    <td style=" width: 200px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;color: #5E5E5E;padding-top: 10px;">
                                       <p>{{ $company_address }}</p>
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