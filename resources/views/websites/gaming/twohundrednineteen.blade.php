<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body{
            margin:0px;
            padding:0px;
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" >
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;max-height: 130px;width: 100%; ">
                            <table>
                                <tr>
                                    <td style="height: 122px; background: url('{{ $invoice_header_image }}') no-repeat;background-position:center;background-size:cover;width: 100%;">
                                         
                                    </td>
                                    
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                     <!-- Content -->
                    <tr >
                        <td style="padding:60px;padding-top:20px;">
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                
                                <tr style="background-color: #2A2C3A;color: white;border-collapse: collapse;width: 100%;">
                                    <td style="padding-top: 10px;width: 200px;">
                                        <p style="font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; text-align: left;padding-bottom: 5px;padding-left: 5px;">
                                            <b>INVOICE NO. {{ $invoice_number }}</b>
                                        </p>
                                    </td>
                                     <td style="padding-top: 10px;width: 200px;">
                                       <p style="font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; text-align: right;padding-bottom: 5px;padding-right: 5px;">
                                            <b>DATE  {{ $invoice_date }}</b>
                                        </p>
                                     </td>
                                </tr>
                                 <tr style="border-bottom: 1px solid black;">
                                    <td style="padding-top: 10px;width: 300px;">
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; text-align: center;padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                            BILLED TO
                                        </p>
                                    </td>
                                     <td style="padding-top: 10px;width: 300px;">
                                       <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;text-align: center; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                            BILLED FORM
                                        </p>
                                     </td>
                                </tr>
                                <tr >
                                    <td style="width: 300px;">
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; text-align: center;padding-bottom: 5px;padding-left: 5px;">
                                            {{ $customer_name ? $customer_name : '' }}<br>
                                            {{ $customer_email ? $customer_email : '' }}<br>
                                            {{ $customer_mobile ? $customer_mobile : '' }}
                                        </p>
                                    </td>
                                     <td style="padding-top: 5px;width: 300px;">
                                       <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;text-align: center;padding-bottom: 5px;padding-left: 5px;">
                                       {{ $site_name }}<br><b style="color: #0077C8;">{{ $company_email }}</b>
                                        </p>
                                     </td>
                                </tr>
                            </table>
                            
                            
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                <tr style="border-collapse: collapse;height: 30px; background-color: #2A2C3A;color: white;">
                                    <td style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       <b>QUANTITY </b> 
                                    </td>
                                    <td style="width: 400px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>	Description</b>
                                    </td>
                                    <td style="width: 200px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        <b>UNIT PRICE</b>
                                    </td>
                                    <td style="width:200px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px; ">
                                        <b>TOTAL</b>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;border-bottom: 1px solid black;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;padding-left: 5px;">
                                      1 
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        {{ $product['name'] }} /{{ $product['game_currency_amount'] }} {{ $product['game_currency'] }}
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        {{ site_currency() . number_format($product['unit_price'], 2) }}
                                    </td>
                                   
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                        {{ site_currency() . number_format($product['unit_price'], 2) }}
                                    </td>
                                </tr>
                                @endforeach
                              
                                 <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                     
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;border-bottom: 1px solid black;">
                                        SUBTOTAL 
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;border-bottom: 1px solid black;">
                                        {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                    </td>
                                </tr>
                                  <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                     
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;border-bottom: 1px solid black;">
                                      DISCOUNT   
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;border-bottom: 1px solid black;">
                                        {{ site_currency() . number_format($discount_amount, 2) }}
                                    </td>
                                </tr>
                                 <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                     
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;border-bottom: 1px solid black;color: rgb(174, 124, 60);">
                                        <b>TOTAL</b>
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;border-bottom: 1px solid black;color: rgb(174, 124, 60);">
                                       <b>{{ site_currency() . number_format($invoice_amount, 2) }}</b>
                                    </td>
                                </tr>
                                <br><br>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End-->

                    <!-----------Footer----------->
                    <tr>
                        <td style="height: 100px;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
                                <tr style="background: url('{{ $invoice_footer_image }}') no-repeat;background-position: center;background-size: cover;height:113px;padding:50px;background-size:cover;width: 100%;">
                                    <td style="width: 150px;text-align: center;color: white;font-family: Arial, Helvetica, sans-serif;font-size: 10px;"> 
                                      <b style=" color: #0077C8;"> {{ $company_email }} </b> |  mmomerchandise.com<br><br>{{ $company_name }}<br>
                                      {!! $company_address !!}
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