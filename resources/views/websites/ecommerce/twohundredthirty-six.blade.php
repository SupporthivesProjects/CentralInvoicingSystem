<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        *, body {
            padding: 0px;
            margin: 0px;
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="background: #ECECFF;">
        <tr>
            <td align="center">
                <table width="100%" cellspacing="0" cellpadding="0" border="0"  style="  border: 40px solid #ECECFF;background: #ECECFF;">
                    <!-- Header -->
                    <tr >
                        <td >
                            <table style=" background-color: #FFFFFF;border-collapse: collapse;">
                                <tr >
                                    <td style="background: #ECECFF; height: 140px; width: 200px;padding-left: 20px; font-family: 'Nunito', sans-serif; border-bottom-right-radius: 20px;">
                                        <p style="font-size: 26px;color: black">INVOICE <span style="font-size: 26px;color: #7B5CFF;">[{{ $invoice_number }}]</span></p>
                                        <p style="font-size: 10px;margin: 0px;color: #7B5CFF;">{{ $company_name }}</p>
                                        <p style="font-size: 9px;margin-top: 0px;">{!! $company_address !!}</p> 
                                    </td>
                                    <td style="width: 300px;background: #ECECFF; text-align: end;">
                                       <table style="border-collapse: collapse;">
                                            <tr>
                                                <td style="width: 300px;height: 140px;background: url('{{ $invoice_header_image }}');background-size: cover;background-position: top right;background-repeat: no-repeat;border-radius: 20px 0px 0px 0px;">
                                                    
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
                    <tr style="background: #FFFFFF;">
                        <td style="padding:20px;border-radius: 20px 0px 0px 0px;">
                            
                            <table style="border-collapse: collapse;">
                                
                                <tr style="border-top: 1px solid goldenrod; border-collapse: collapse; color: #7B5CFF;">
                                    <td style="padding-top: 10px;width: 33.3%; ">
                                        <p style="font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; text-align: left;padding-bottom: 5px;padding-left: 5px;">
                                            Date
                                        </p>
                                    </td>
                                     <td style="padding-top: 10px;width: 33.3%;">
                                       <p style="font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; text-align: left;padding-bottom: 5px;padding-right: 5px;">
                                            To
                                        </p>
                                     </td>
                                     <td style="padding-top: 10px;width: 33.3%;">
                                       <p style="font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; text-align: left;padding-bottom: 5px;padding-right: 5px;">
                                            Billed From
                                        </p>
                                     </td>
                                </tr>
                                 <tr style="border-collapse: collapse; border-bottom: 1px solid goldenrod;">
                                    <td style="width: 200px;">
                                        <p style="font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; text-align: left;padding-bottom: 5px;padding-left: 5px;">
                                            {{ $invoice_date }}
                                        </p>
                                    </td>
                                     <td style="width: 200px;">
                                       <p style="font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; text-align: left;padding-bottom: 5px;padding-right: 5px;">
                                         {{ $customer_name }}
                                        </p>
                                     </td>
                                     <td style="width: 200px;">
                                       <p style="font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; text-align: left;padding-bottom: 5px;padding-right: 5px;">
                                            Haven of Wellbeing
                                        </p>
                                     </td>
                                </tr>
                                
                            </table>
                            <br>
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                               
                                <tr style="border-collapse: collapse;height: 30px; background-color: #7B5CFF;color: white;">
                                    <td style="width: 200px;text-align: left;font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       <b>Quantity </b> 
                                    </td>
                                    <td style="width: 400px;text-align: left;font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>	Description</b>
                                    </td>
                                    <td style="width: 200px;text-align: right;font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        <b>Unit Price</b>
                                    </td>
                                    <td style="width:200px;text-align: right;font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px; ">
                                        <b>Total</b>
                                    </td>
                                </tr>
                                @foreach ($products as $product)
                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;border-bottom: 1px solid black;">
                                    <td style="width: 100px;text-align: left;font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;padding-left: 5px;">
                                      1 
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: 'Nunito', sans-serif;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        {{ $product->name }}
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        {{ site_currency() }} {{ number_format($product->unit_price, 2) }}
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                        {{ site_currency() }} {{ number_format($product->unit_price, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                              
                                 <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;border-bottom: 1px solid black;">
                                     
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-bottom: 1px solid black;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;border-bottom: 1px solid black;">
                                        SUBTOTAL 
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;border-bottom: 1px solid black;">
                                        {{ site_currency() }} {{ number_format($invoice_amount + $discount_amount, 2) }}
                                    </td>
                                </tr>
                                  <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;border-bottom: 1px solid goldenrod;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                     
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        DISCOUNT
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                        {{ site_currency() }} {{ number_format($discount_amount, 2) }}
                                    </td>
                                </tr>
                                 <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;border-bottom: 1px solid goldenrod">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                     
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        <b>TOTAL Due</b>
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                        {{ site_currency() }} {{ number_format($invoice_amount, 2) }}
                                    </td>
                                </tr>
                            </table>
                            <table>
                            <tr style="width: 100%; ">
                                <td style="width: 100%;text-align: center; color: #7B5CFF; font-size: 11px;font-family: 'Nunito', sans-serif;">
                                    <p>Thank you for your business!</p></td>
                            </tr>
                            
                            </table>
                            
                        </td>
                    </tr>
                    <!-- Content End-->

                    <!-----------Footer----------->
                    <tr>
                        <td style="height:200px;background-color: #FFFFFF;display: flex;justify-content: center; align-items: flex-end;border-bottom-left-radius: 20px;border-bottom-right-radius: 20px;">
                           
                                <div style="text-align: center; font-size: 9px;font-family: 'Nunito', sans-serif;width: 100%; ">
                                    <div style="display: flex;justify-content: center;">
                                        <img src="{{ $invoice_footer_image }}" alt="" style="height: 150px;">
                                    </div>
                                    <div style="background-color: black;border-bottom-left-radius: 20px;border-bottom-right-radius: 20px;">
                                    <p style="color: white;margin: 0px;padding-top: 10px; padding-bottom: 5px;">{{ $company_mobile  }}</p>
                                    <p style="color: goldenrod;margin: 0px;padding-bottom: 10px;">{{ $company_email }}</p>
                                    </div>
                                </div>
                               
                        </td>
                    </tr> 
                    <!-----------Footer End----------->

                </table>
            </td>
        </tr>
    </table>
</body>
</html>