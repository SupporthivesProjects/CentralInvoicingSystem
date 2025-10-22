<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">

</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); background: url('{{ $invoice_image1 }}') no-repeat;background-position:center;background-size:100% 100%;">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;max-height: 130px;">
                            <table>
                                <tr>
                                    <td style="height: 122px; width: 600px;padding-left: 40px; font-family: 'Nunito', sans-serif;">
                                        <p style="font-size: 26px;color: #7B5CFF;">INVOICE [{{ $invoice_number }}]</p>
                                        <p style="font-size: 10px;margin: 0px;color: #7B5CFF;">{{ $company_name }}</p>
                                          <p style="font-size: 9px;margin-top: 0px;">{{ $company_address }}<br>{{ $company_email }}</p> 
                                    </td>
                                    
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                     <!-- Content -->
                    <tr >
                        <td style="padding:60px;padding-top:70px;padding-bottom: 0px;">
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                
                                <tr style="border-top: 1px solid black;border-collapse: collapse; color: #7B5CFF;">
                                    <td style="padding-top: 10px;width: 200px; ">
                                        <p style="font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; text-align: left;padding-bottom: 5px;padding-left: 5px;">
                                            Date
                                        </p>
                                    </td>
                                     <td style="padding-top: 10px;width: 200px;">
                                       <p style="font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; text-align: left;padding-bottom: 5px;padding-right: 5px;">
                                            To
                                        </p>
                                     </td>
                                     <td style="padding-top: 10px;width: 200px;">
                                       <p style="font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; text-align: left;padding-bottom: 5px;padding-right: 5px;">
                                            Billed From
                                        </p>
                                     </td>
                                </tr>
                                 <tr style="border-collapse: collapse;">
                                    <td style="width: 200px;">
                                        <p style="font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; text-align: left;padding-bottom: 5px;padding-left: 5px;">
                                            {{ $invoice_date }}
                                        </p>
                                    </td>
                                     <td style="width: 200px;">
                                       <p style="font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; text-align: left;padding-bottom: 5px;padding-right: 5px;">
                                        {{ $customer_name ? $customer_name : '' }}<br>
                                        {{ $customer_email ? $customer_email : '' }}<br>
                                        {{ $customer_mobile ? $customer_mobile : '' }}
                                        </p>
                                     </td>
                                     <td style="width: 200px;">
                                       <p style="font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; text-align: left;padding-bottom: 5px;padding-right: 5px;">
                                            Haven of Wellbeing
                                        </p>
                                     </td>
                                </tr>
                                
                            </table>
                            
                            
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                <tr style="border-collapse: collapse;height: 30px; background-color: #7B5CFF;color: white;">
                                    <td style="width: 200px;text-align: left;font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       <b>QUANTITY </b> 
                                    </td>
                                    <td style="width: 400px;text-align: left;font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>	Description</b>
                                    </td>
                                    <td style="width: 200px;text-align: right;font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        <b>UNIT PRICE</b>
                                    </td>
                                    <td style="width:200px;text-align: right;font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px; ">
                                        <b>TOTAL</b>
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
                                        {{ site_currency() }}
                                        {{ number_format($product->unit_price, 2) }}
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: 'Nunito', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                        {{ site_currency() }}
                                        {{ number_format($product->unit_price, 2) }}
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
                                        <b>TOTAL</b>
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                        {{ site_currency() }} {{ number_format($invoice_amount, 2) }}
                                    </td>
                                </tr>
                                <br><br><br>
                            </table>
                            <table>
                            <tr style="width: 600px; height: 150px;">
                                <td style="width: 600px;text-align: center; color: #7B5CFF; font-size: 11px;font-family: 'Nunito', sans-serif;margin: 0px;padding-bottom: 100px;">
                                    <p style="margin: 0px;">Thank you for your business!</p></td>
                            </tr>
                            
                            </table>
                            <tr style="height:100px;width: 100%;">
                                    <td style="width: 150px;text-align: center;color: white;font-family: 'Nunito', sans-serif;font-size: 8px;padding-top: 10px;"> 
                                    <p style="margin: 0px;">{{ $company_mobile }}</p>  
                                    <p style="color: goldenrod;padding-bottom: 10px;margin-top: 0px;">{{ $company_email }}</p>
                                    </td> 
                                          
                                </tr>
                            <br><br>
                        </td>
                    </tr>
                    <!-- Content End-->

                    <!-----------Footer----------->
                    <tr>
                        <td style="height: 40px;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
                                
                                              
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