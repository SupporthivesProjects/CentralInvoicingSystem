<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                     <tr>
                        <td style="height: 75px;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" > 
                                <tr style="border-collapse: collapse; height: 220px; background: url('{{ $invoice_image2 }}') no-repeat;background-position:center;background-size:cover;width: 600px; border-collapse: collapse;">
                                    <td style="width: 300px;border:0px;" > 
                                        <img src="{{ $invoice_image3 }}" alt="" style="height: 60px; justify-content: left;padding-left: 40px;padding-bottom: 135px;">
                                        </td>
                                       
                                        <td style="width: 300px;border:0px;height: 50px;">
                                            <h1 style="justify-content: right;text-align: right;padding-right: 40px;padding-bottom: 115px;font-family: 'Poppins', sans-serif;">INVOICE</h1>
                                        </td>
                                </tr>
                            </table>
                        </td>
                     </tr>
                    <!-- Header End -->

                     <!-- Content -->
                    <tr style=" background: url('{{ $invoice_image1 }}') no-repeat;background-position:100% 100%;">
                        <td style="padding:60px;padding-top:0px;">
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                
                                <tr style="background-color:  #082B34;color: white;border-collapse: collapse;">
                                    <td style="padding-top: 10px;width: 200px;">
                                        <p style="font-family: 'Poppins', sans-serif;font-size: 14px;margin: 0px;font-weight: 400; text-align: center;padding-bottom: 5px;padding-left: 5px;">
                                            <b>Billed From</b>
                                        </p>
                                    </td>
                                    <td style="padding-top: 10px;width: 150px;background-color: white;">
                                        <p style="font-family: 'Poppins', sans-serif;font-size: 14px;margin: 0px;font-weight: 400; text-align: left;padding-bottom: 5px;padding-left: 5px;">
                                            <b></b>
                                        </p>
                                    </td>
                                     <td style="padding-top: 10px;width: 200px;">
                                       <p style="font-family: 'Poppins', sans-serif;font-size: 14px;margin: 0px;font-weight: 400; text-align: center;padding-bottom: 5px;padding-right: 5px;">
                                            <b>Billed To</b>
                                        </p>
                                     </td>
                                </tr>
                                 <tr >
                                    <td style="padding-top: 10px;width: 200px;">
                                        <p style="font-family: 'Poppins', sans-serif;font-size: 9px;margin: 0px;font-weight: 400; text-align: center;padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                            {{ $site_name }}
                                        </p>
                                    </td>
                                    <td style="padding-top: 10px;width: 10px;">
                                       
                                     </td>
                                     <td style="padding-top: 10px;width: 200px;">
                                       <p style="font-family: 'Poppins', sans-serif;font-size: 9px;margin: 0px;font-weight: 400;text-align: center; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                            {{ $customer_name }}
                                        </p>
                                     </td>
                                </tr>
                            </table>
                                    <p style="font-family: 'Poppins Light', sans-serif;font-size: 9px;"><b>Invoice Number:</b> {{ $invoice_number }}</p>
                                    <p style="font-family: 'Poppins Light', sans-serif;font-size: 9px;"><b>Date:</b> {{ $invoice_date }}</p>
                            
                            
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                <tr style="border-collapse: collapse;height: 30px;background-color:  #082B34; color: white;border-bottom: 0px;border: 0px;">
                                    <td style="width: 200px;text-align: left;font-family: 'Poppins', sans-serif;font-size: 12px;margin: 0px;font-weight: 800;border-collapse: collapse;padding-left: 5px;">
                                       <b>Item</b> 
                                    </td>
                                    <td style="width: 300px;text-align: left;font-family: 'Poppins', sans-serif;font-size: 12px;margin: 0px;font-weight: 800;border-collapse: collapse;">
                                        <b>Description</b>
                                    </td>
                                    <td style="width: 100px;text-align: left;font-family: 'Poppins', sans-serif;font-size: 12px;margin: 0px;font-weight: 800; border-collapse: collapse;padding-left: 5px;">
                                        <b>QTY</b>
                                    </td>
                                    <td style="width: 200px;text-align:left;font-family: 'Poppins', sans-serif;font-size: 12px;margin: 0px;font-weight: 800;border-collapse: collapse;">
                                        <b>Unit Price</b>
                                    </td>
                                    <td style="width:100px;text-align: right;font-family: 'Poppins', sans-serif;font-size: 12px;margin: 0px;font-weight: 800;border-collapse: collapse;padding-right: 2px;">
                                        <b>Total</b>
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 10px;border-bottom: 1px solid #eaeaea;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 2px;">
                                   
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                       
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                       
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                        
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 1px solid #eaeaea;">
                                    <td style="width: 100px;text-align: left;font-family: 'Poppins Medium', sans-serif;font-size: 8px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 2px;">
                                      {{ $product['name'] }}
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: 'Poppins Medium', sans-serif;font-size: 8px;margin: 0px;font-weight: 400; border-collapse: collapse;;">
                                        {{ $product['game_currency_amount'] }} {{ $product['game_currency'] }}
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: 'Poppins Medium', sans-serif;font-size: 8px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        1
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: 'Poppins Medium', sans-serif;font-size: 8px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                      {{ site_currency() . number_format($product['unit_price'], 2) }}
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: 'Poppins Medium', sans-serif;font-size: 8px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                        {{ site_currency() . number_format($product['unit_price'], 2) }}
                                    </td>
                                </tr> 
                                @endforeach    
                              
                                 
                                 <tr style="border-collapse: collapse;height: 10px;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 2px;">
                                   
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                       
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                       
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                        
                                    </td>
                                </tr>
                               
                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;color: white;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                      
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:155px;text-align:left;font-family: 'Poppins', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;background-color: #082B34;border: 1px solid  #082B34;">
                                        Invoice Total
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #082B34;border: 1px solid #082B34;">
                                       
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;background-color: #082B34;border: 1px solid #082B34;">
                                        
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;color: white;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                      
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:155px;text-align:left;font-family: 'Poppins', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;background-color: #082B34;border: 1px solid #082B34;">
                                        Subtotal
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #082B34;border: 1px solid #082B34;">
                                       
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: 'Poppins', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;background-color: #082B34;border: 1px solid #082B34;">
                                        {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;color: white;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                      
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:155px;text-align:left;font-family: 'Poppins', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;background-color: #082B34;border: 1px solid #082B34;">
                                        Discount
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #082B34;border: 1px solid #082B34;">
                                       
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: 'Poppins', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;background-color: #082B34;border: 1px solid #082B34;">
                                        {{ site_currency() . number_format($discount_amount, 2) }}
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;color: white;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                      
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:175px;text-align:left;font-family: 'Poppins', sans-serif;font-size: 13px;margin: 0px;font-weight: 800; border-collapse: collapse;padding-left: 5px;background-color: #082B34;border: 1px solid #082B34;">
                                        Grand Total
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #082B34;border: 1px solid #082B34;">
                                       
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: 'Poppins', sans-serif;font-size: 13px;margin: 0px;font-weight: 800; border-collapse: collapse;padding-right: 10px;background-color: #082B34;border: 1px solid #082B34;">
                                        {{ site_currency() . number_format($invoice_amount, 2) }}
                                    </td>
                                </tr>
                                <br><br>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End-->

                    <!-----------Footer----------->
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
                                <tr style="height: 120px; background: url('{{ $invoice_image4 }}') no-repeat;background-position:center;background-size:cover;width: 600px;">
                                    <td style="color: white;font-family: 'Poppins Medium', sans-serif;font-size: 8px;text-align: right;padding-right: 60px;"> 
                                        <p >{{ $site_name }}</p>
                                        <p>{{ $company_mobile }}</p>
                                        <p>{{ $company_email }}</p>
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