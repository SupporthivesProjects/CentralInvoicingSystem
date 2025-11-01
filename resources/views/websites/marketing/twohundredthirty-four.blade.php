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
        .footer_bottom {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            width: 100%;
            background: url('{{ $invoice_footer_image }}') no-repeat;background-position: top center;background-size: cover;
            
        }
    </style>

</head>
<body style="border-collapse: collapse; background: url('{{ $invoice_image1 }}') no-repeat;background-position: top center;background-size: cover">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" >
        <tr>
            <td  style="padding:0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0"   >
                    <!-- Header -->
                    <tr style="width: 100%">
                        <td style="padding: 20px;">
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
                                    <td style="text-align: right; font-family: 'Poppins', sans-serif;padding-right: 20px;">
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
                                       <b>Description</b> 
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
                                    <td style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                       <b>{{ site_currency() }}{{ number_format($invoice_amount + $discount_amount, 2) }}</b>
                                    </td>
                                </tr>
                                 <tr style="border-top: 1px solid black; height: 24px;font-family: 'Poppins', sans-serif;">
                                    <td colspan="1"></td>
                                    <td colspan="2" style="padding-right: 20px; width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-right: 1px solid black;">
                                        <b>Total (With Discount Applied)</b>

                                        </td>
                                    <td style="width: 100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>{{ site_currency() }}{{ number_format($invoice_amount, 2) }}</b>
                                        </td>
                                </tr>
                            </table>
                            <br>
                            <br>
                        </td>
                    </tr>
                    <!-- Content End-->

                    <!-----------Footer----------->
                    <table class="footer_bottom">
                    
                    <tr>
                        <td>
                            <!-- <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
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
                            </table> -->
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;"> 
                                <tr style="height: 100px; font-family: 'Poppins', sans-serif;">

                                    <!-- Column 1 -->
                                    <td style="vertical-align: top;width: 33.33%; text-align: left; font-size: 10px; color: #5E5E5E; padding-left: 40px; padding-top: 10px;">
                                        @if(!empty($company_email))
                                        <div style="display: flex; align-items: flex-start;">
                                            <img src="{{ $invoice_image2 }}" alt="" style="height: 25px; vertical-align: middle;">
                                            <span style="margin-left: 5px; vertical-align: middle;">{{ $company_email }}</span>
                                            </div>
                                        @endif
                                        
                                    </td>

                                    <!-- Column 2 -->
                                    <td style="vertical-align: top;width: 33.33%; text-align: left; font-size: 10px; color: #5E5E5E; padding-top: 10px;">
                                        @if(!empty($company_mobile))
                                        <div style="display: flex; align-items: flex-start;">
                                            <img src="{{ $invoice_image3 }}" alt="" style="height: 25px; vertical-align: middle;">
                                            <span style="margin-left: 5px; vertical-align: middle;">{{ $company_mobile }}</span>
                                            </div>
                                        @endif    
                                        
                                    </td>

                                    <!-- Column 3 -->
                                    <td style="vertical-align: top;width: 33.33%; text-align: left; font-size: 10px; color: #5E5E5E; padding-top: 10px;">
                                        @if(!empty($company_address))
                                            <!-- <img src="{{ $invoice_image4 }}" alt="" style="height: 25px; vertical-align: middle;">
                                            <span style="margin-left: 5px; vertical-align: middle;">{{ $company_address }}</span> -->
                                            <div style="display: flex; align-items: flex-start;">
                                                <img src="{{ $invoice_image4 }}" alt="" style="height: 25px; margin-right: 5px; flex-shrink: 0;">
                                                <span style="display: inline-block; line-height: 1.4;">
                                                    {{ $company_address }}
                                                </span>
                                            </div>
                                        @endif
                                        </td>

                                </tr>           
                            </table>


                        </td>
                    </tr> 
                    </table>
                    <!-----------Footer End----------->

                </table>
            </td>
        </tr>
    </table>
</body>
</html>