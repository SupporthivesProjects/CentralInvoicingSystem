<!DOCTYPE html>
<html>
<head>
        <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>

    <style>
        body
        {
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
                    <tr style="width: 100%;">
                        <td style="padding: 0px;max-height: 130px; width: 100%;">
                            <table style="width: 100%;">
                                <tr style="width: 100%;">
                                    <td style="height: 64px; background: url('{{ $invoice_header_image }}') no-repeat;background-position:center;background-size:cover;width: 100%;">
                                         <img src="{{ $company_logo }}" alt="" style="margin: auto; height: 50px; display: block;">
                                    </td>
                                    
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                     <!-- Content -->
                    <tr >
                        <td style="padding: 70px;padding-top:0px;">
                            <table>
                                <tr>
                                    <td style="padding-top: 30px; width: 100%;">
                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            <b>Date</b> {{ $invoice_date }}
                                        </p>
                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;padding-bottom: 5px;">
                                            <b>Invoice Number:</b> #{{ $invoice_number}}
                                        </p>
                                        
                                        <br>
                                    </td>
                                    <td style="text-align: right;">
                                        <p style="font-family: arial;font-size:20px;margin: 0px;font-weight: 400;">
                                            <b>INVOICE</b>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 10px;width: 100%;">
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <b>BILLED FROM:</b>
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">{{ $site_name }}</p>
                                     <td style="padding-top: 10px;width: 300px;text-align: right;">
                                       <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <b>BILLED TO:</b>
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;"> {{ $customer_name }}</p>
                                     </td>
                                </tr>
                                 
                            </table>
                            
                            <div style="min-height: 800px !important;">
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                <tr style="border-collapse: collapse;height: 30px;background-color: #0078D7; color: white;border-bottom: 0px;border: 0px;">
                                    <td style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 600;border-collapse: collapse;padding-left: 5px;">
                                       <b>CATEGORY</b> 
                                    </td>
                                    <td style="width: 400px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 600;border-collapse: collapse;">
                                        <b>PRODUCT NAME</b>
                                    </td>
                                    <td style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 600; border-collapse: collapse;padding-left: 5px;">
                                        <b>QTY</b>
                                    </td>
                                    <td style="width: 200px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 600;border-collapse: collapse;">
                                        <b>UNIT PRICE</b>
                                    </td>
                                    <td style="width:200px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 600;border-collapse: collapse;">
                                        <b>TOTAL</b>
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 10px;border-bottom: 0px;border: 0px;border-bottom: 1px solid black;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                      
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                       
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                      
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                      
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                       
                                    </td>
                                </tr>
                             @foreach($products as $product)
                                 <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;border-bottom: 1px solid black;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                    {{ $product->category_name }}
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     {{ $product->name }}
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        1
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        {{ site_currency() . number_format($product->unit_price, 2) }}
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        {{ site_currency() . number_format($product->unit_price, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                              
                            </tr>
                                 <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                      
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                      
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                       
                                    </td>
                                </tr>
                               
                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                      
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse; border-bottom: 1px solid black;">
                                       <b>INVOICE TOTAL</b>
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse; border-bottom: 1px solid black;">
                                        
                                    </td>
                                </tr>
                                 <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                      
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-bottom: 1px solid black;">
                                       SUBTOTAL
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-bottom: 1px solid black;">
                                     {{ site_currency() . number_format(($invoice_amount + $discount_amount), 2) }}
                                    </td>
                                </tr>
                                  <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                      
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-bottom: 1px solid black;">
                                       DISCOUNT
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-bottom: 1px solid black;">
                                        {{ site_currency() . number_format($discount_amount, 2) }}
                                    </td>
                                </tr>
                                 <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                      
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse; background-color: #0078D7; color: white;">
                                       <b>GRAND TOTAL</b>
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse; background-color: #0078D7; color: white;">
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
                        <td style="height: 75px;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
                                <tr style="height: 70px; background: url('{{ $invoice_footer_image }}') no-repeat;background-position:center;background-size:cover;width: 600px; border-collapse: collapse;">
                                    <td style="width: 300px;border:0px" > 
                                        <img src="{{ $invoice_image1 }}" alt="" style="margin: auto; height: 20px; display: block;">
                                        <p style="font-family: arial;font-size: 8px;margin: auto;font-weight: 200; color: white; text-align: center; padding-top: 10px;">+44 330 027 2570</p>
                                    </td>
                                    <td style="width: 300px;"> 
                                        <img src="{{ $invoice_image2 }}" alt="" style="margin: auto; height: 20px; display: block;">
                                        <p style="font-family: arial;font-size: 8px;margin: auto;font-weight: 200; color: white; text-align: center; padding-top: 10px;">Support@advanceurbusiness.com</p>
                                    </td>
                                    <td style="width: 300px;"> 
                                        <img src="{{ $invoice_image3 }}" alt="" style="margin: auto; height: 20px; display: block;">
                                        <p style="font-family: arial;font-size: 8px;margin: auto;font-weight: 200; color: white; text-align: center; padding-top: 10px;">Powered by Eromnet Hong Kong</p>
                                    </td>          
                                </tr>
                                              
                            </table>
                        </td>
                    </tr> 
                   
                </table>
            </td>
        </tr>
    </table>
</body>
</html>