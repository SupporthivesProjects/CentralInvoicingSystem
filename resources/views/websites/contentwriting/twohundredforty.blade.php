<!DOCTYPE html>
<html>
<head>
    <title>Your Email Title</title>
    <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400;700;800&display=swap" rel="stylesheet">

</head>

<body style="margin:0px; padding:0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding:0; margin:0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
            style="border-collapse: collapse; margin:0px; width:100%;">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;max-height: 130px;">
                            <table style="border-spacing: 0px; width: 100%;">
                                <tr>
                                    <td style="height: 122px; background: url({{ $invoice_header_image }}) no-repeat;background-position:center;background-size:cover;width: 865px;text-align: center;">
                                         <img src="{{ $company_logo }}" style=" height: 60px;">
                                    </td>
                                    
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                     <!-- Content -->
                    <tr style=" background: url({{ $invoice_footer_image }}) no-repeat;background-position:center;background-size:cover; height: 1100px;width: 100%;">
                        <td style="padding:60px;padding-top:20px;padding-bottom: 20px;">
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                <tr >
                                    <td style="padding-top: 10px;width: 750px;">
                                        <p style="font-family: 'Sen', sans-serif;font-size: 26px;margin: 0px; text-align: center;padding-bottom: 10px;">
                                            <b>Invoice #. {{ $invoice_number }}</b>
                                        </p>
                                    </td>
                                </tr>
                            </table>

                                <table style="border-bottom: 1px solid black;border-top: 1px solid black; width: 750px;">
                                <tr>
                                   <td style="font-family: 'Sen', sans-serif;text-align: center;font-size: 14px;width: 300px;">
                                        <b>Purchase Date:</b>
                                    </td>
                                    <td style="font-family: 'Sen', sans-serif;text-align: center;font-size: 14px;width: 300px;">
                                        <b>Billed To</b>
                                    </td>
                                </tr>
                                <tr>
                                   <td style="font-family: 'Sen', sans-serif;text-align: center;font-size: 14px;">
                                        {{ $invoice_date }}
                                    </td>
                                    <td style="font-family: 'Sen', sans-serif;text-align: center;font-size: 14px;">
                                        {{ $customer_name ? $customer_name : '' }}
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <div style="height: 850px;">
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                <tr style="border-collapse: collapse;height: 30px;background-color: darkblue;font-family: 'Sen', sans-serif; color: white;border-bottom: 1px solid black;">
                                    <td style="width: 50px;text-align: left;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       <b>QTY</b> 
                                    </td>
                                    <td style="width: 200px;text-align: left;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>DESCRIPTION</b>
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        <b>QUALITY</b>
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>TURNAROUND</b>
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        <b>IMAGERY</b>
                                    </td>
                                    <td style="width:580px;text-align: right;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        <b>BILLING CYCLE</b>
                                    </td>
                                    <td style="width:100px;text-align: right;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        <b>Total</b>
                                    </td>
                                </tr>
                                @foreach ($products as $product)
                                <tr style="border-collapse: collapse;height: 30px;font-family: 'Sen', sans-serif; color: gray;border-bottom: 1px solid black;background-color: {{ $loop->iteration % 2 == 0 ? 'lightgrey' : '#ffffff' }}; ">
                                    <td style="width: 50px;text-align: left;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       {{ $loop->iteration }}
                                    </td>
                                    <td style="width: 200px;text-align: left;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        {{ $product->name }}
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        {{ $product->quality }}
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        {{ $product->delivery }}
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        {{ $product->imagecount }}
                                    </td>
                                    <td style="width:580px;text-align: right;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        {{  site_currency() }} {{ number_format($product->unit_price, 2) }}
                                    </td>
                                    <td style="width:100px;text-align: right;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        {{  site_currency() }} {{ number_format($product->unit_price, 2) }}
                                    </td>
                                    @endforeach
                                </tr>
                              
                                <tr style="border-collapse: collapse;height: 30px;font-family: 'Sen', sans-serif; color: gray;">
                                    <td style="width: 50px;text-align: left;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                    
                                    </td>
                                    <td style="width: 200px;text-align: left;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        
                                    </td>
                                    <td style="width:580px;text-align: right;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;background-color: lightgrey;">
                                        Item total
                                    </td>
                                    <td style="width:100px;text-align: right;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;background-color: lightgrey;">
                                        {{ site_currency() . number_format($invoice_amount + $discount_amount ?? 0, 2) }}
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 30px;font-family: 'Sen', sans-serif; color: gray;">
                                    <td style="width: 50px;text-align: left;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                    
                                    </td>
                                    <td style="width: 200px;text-align: left;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        
                                    </td>
                                    <td style="width:580px;text-align: right;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        Coupon Used
                                    </td>
                                    <td style="width:100px;text-align: right;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        {{ site_currency() . number_format($discount_amount ?? 0, 2) }}
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 30px;font-family: 'Sen', sans-serif; color: gray;">
                                    <td style="width: 50px;text-align: left;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                    
                                    </td>
                                    <td style="width: 200px;text-align: left;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        
                                    </td>
                                    <td style="width:580px;text-align: right;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;color: #172355;background-color: lightgrey;">
                                        TOTAL
                                    </td>
                                    <td style="width:100px;text-align: right;font-size: 14px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;background-color: lightgrey;color: #172355;">
                                        {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}
                                    </td>
                                </tr>
                               
                            </table>
                            </div>
                            <br>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; margin:0; padding:0;position: fixed; bottom: 0; width: 100%; z-index: 999;">
                                <tr>
                                <td style="height: 100px;">
                                    <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
                                        <tr style="height:200px;width: 100%;">
                                            <td style="width: 35%"> 
                                            <img src="{{ $invoice_image1 }}" style="height: 200px;">
                                            </td>
                                            <!-- <td style="text-align: center;font-size: 14px;display: flow-root; font-family: 'Sen', sans-serif; width: 80%; ">
                                                <p><b style="color: #172355;">TEL:</b> {{ $company_mobile }}</p>
                                                <p><b style="color: #172355;">EMAIL:</b> {{ $company_email }}</p>
                                                <p><b style="color: #172355;">ADDRESS:</b> {!! $company_address !!}</p>
                                            </td >  -->
                                            <td style="text-align:center; font-size:14px; font-family:'Sen', sans-serif; width:40%;">
                                                <div style="margin-left:-20px;">
                                                    <p><b style="color:#172355;">TEL:</b> {{ $company_mobile }}</p>
                                                    <p><b style="color:#172355;">EMAIL:</b> {{ $company_email }}</p>
                                                    <p><b style="color:#172355;">ADDRESS:</b> {!! $company_address !!}</p>
                                                </div>
                                            </td>
                                            <td style="width: 35%">
                                                <img src="{{ $invoice_image2 }}" style="height: 200px;">
                                            </td>   
                                        </tr>
                                                    
                                    </table>
                                </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End-->

                    <!-----------Footer----------->
                     
                    <!-----------Footer End----------->

                </table>
            </td>
        </tr>
    </table>
</body>
</html>