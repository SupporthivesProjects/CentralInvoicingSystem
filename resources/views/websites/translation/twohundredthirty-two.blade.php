<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">

</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); background: url('{{ $invoice_image1 }}') no-repeat;background-position:center;background-size:100% 100%;">
                    <!-- Header -->
                     <tr>
                        <td style="height: 75px; ">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" > 
                                <tr style="border-collapse: collapse; height: 100px;width: 600px; border-collapse: collapse;">
                                    <td style="width: 300px;border:0px;height: 120px;" > 
                                      
                                        </td>
                                       
                                        <td style="width: 150px;border:0px;height: 170px;text-align: left;margin: 0px;font-size: 14px;font-family: 'Montserrat', monospace;color: white;padding-left: 85px;">
                                        <p style="margin-bottom:4px;">Invioce Number</p>
                                        <p style="margin: 0px;">{{ $invoice_number }}</p>
                                        </td>
                                       <td style="width: 150px;border:0px;height: 170px;text-align: left;margin: 0px;font-size: 14px;font-family: 'Montserrat', monospace;color: white;">
                                        <p style="margin-bottom:4px;">Invioce Date</p>
                                        <p style="margin: 0px;">{{ $invoice_date }}</p>
                                        </td>
                                </tr>
                            </table>
                        </td>
                     </tr>
                    <!-- Header End -->

                     <!-- Content -->
                    <tr >
                        <td style="padding:30px;padding-top:0px;">
                            
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                
                                <tr style="border-collapse: collapse;">
                                    <td style="padding-top: 10px;width: 300px;height: 90px;">
                                       <h1 style="text-align: center;color: darkblue;font-size: 75px;margin:0px;font-family: 'Montserrat', monospace;"></h1>
                                    </td>
                                    
                                     <td style="padding-top: 10px;width: 300px;text-align: right;">
                                       
                                     </td>
                                </tr>
                                 
                                
                            </table>
                                 <table style="padding-top: 75px;">
                                    <tr >
                                    <td style="padding-top: 10px;width: 400px;">
                                        <p style="font-family: 'Montserrat', monospace;font-size: 12px;margin: 0px;font-weight: 400; text-align: left;padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                            Invoice To :
                                        </p>
                                    </td>
                                    
                                     <td style="padding-top: 10px;width: 400px;text-align: center;">
                                       <p style="font-family: 'Montserrat', monospace;font-size: 12px;margin: 0px;font-weight: 400; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                           Grand Total :
                                        </p>
                                     </td>
                                 </tr>
                                 <tr>
                                     <td style="width: 300px;">
                                        <b style="font-size: 16px;font-family: 'Montserrat', monospace;">{{ $customer_name ? $customer_name : '' }}</b>
                                    </td>
                                    
                                     <td style="padding-top: 10px; width: 300px;color: white; text-align: center;border-radius: 10px;">
                                      <b style="font-size: 24px;font-family: 'Montserrat', monospace; padding-left: 100px">{{ site_currency() . number_format($invoice_amount ?? 0, 2) }}</b>
                                     </td>
                                </tr>
                                 </table>   
                            
                            
                            <table style="border-collapse: collapse;">
                                <tr style="border-collapse: collapse;height: 50px; background-color: #1AB4FF;color: white;">
                                    
                                    <td style="width: 200px;text-align: left;font-family: 'Montserrat', sans-serif; font-size: 11px;margin: 0px;font-weight: 800;border-collapse: collapse;padding-left: 15px;border-bottom-left-radius: 40px;border-top-left-radius: 40px;">
                                        <b >ITEM DESCRIPTION</b>
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: 'Montserrat', sans-serif; font-size: 11px;margin: 0px;font-weight: 800; border-collapse: collapse;padding-left: 5px;">
                                        <b>UNIT PRICE</b>
                                    </td>
                                    <td style="width: 200px;text-align:center;font-family: 'Montserrat', sans-serif; font-size: 11px;margin: 0px;font-weight: 800;border-collapse: collapse;">
                                        <b>QTY</b>
                                    </td>
                                    <td style="width:100px;text-align: center;font-family: 'Montserrat', sans-serif; font-size: 11px;margin: 0px;font-weight: 800;border-collapse: collapse;padding-right: 2px;border-bottom-right-radius: 40px;border-top-right-radius: 40px;">
                                        <b>Total</b>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr style="border-collapse: collapse;height: 50px;">
                                    <td style="width: 200px;text-align:left;font-family: 'Montserrat', sans-serif;font-size:8px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 15px;">
                                       <b>{{ $product->name }}</b>
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                       {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     1
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                       {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}
                                    </td>
                                    <td style="width:300px;color: #2A3556; text-align:right;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 800; border-collapse: collapse;padding-right: 10px;">
                                       PAYMENT INFORMATION
                                    </td>
                                </tr>
                                @endforeach
                                {{-- <tr style="border-collapse: collapse;height: 50px;">
                                    <td style="width: 200px;text-align:left;font-family: 'Montserrat', sans-serif;font-size:8px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 15px;">
                                       <b>Item Name</b>
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                       $100.00
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     1
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                       $100.00 
                                    </td>
                                    <td style="width:300px;text-align:right;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                       <b>Online Payment</b>
                                        Visa/Mastercard,
                                    </td>
                                </tr>
                                 <tr style="border-collapse: collapse;height: 50px;">
                                    <td style="width: 200px;text-align:left;font-family: 'Montserrat', sans-serif;font-size:8px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 15px;">
                                       <b>Item Name</b>
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                       $100.00
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     1
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                       $100.00 
                                    </td>
                                   
                                </tr>
                               <tr style="border-collapse: collapse;height: 50px;">
                                    <td style="width: 200px;text-align:left;font-family: 'Montserrat', sans-serif;font-size:8px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 15px;">
                                       <b>Item Name</b>
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                       $100.00
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     1
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                       $100.00 
                                    </td>
                                   
                                </tr>
                               <tr style="border-collapse: collapse;height: 50px;"> --}}
                                    {{-- <td style="width: 200px;text-align:left;font-family: 'Montserrat', sans-serif;font-size:8px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 15px;">
                                       <b>Item Name</b>
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                       $100.00
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     1
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                       $100.00 
                                    </td>
                                    
                                </tr> --}}
                                <tr style="border-collapse: collapse;height: 50px;">
                                    <td style="width: 200px;text-align:left;font-family: 'Montserrat', sans-serif;font-size:9px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 15px;">
                                       <b>SUBTOTAL</b>
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                       {{ site_currency() . number_format($invoice_amount + $discount_amount ?? 0, 2) }}
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 50px;">
                                    <td style="width: 200px;text-align:left;font-family: 'Montserrat', sans-serif;font-size:9px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 15px;">
                                       <b>DISCOUNT</b>
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                       {{ site_currency() . number_format($discount_amount ?? 0, 2) }}
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                  
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                     
                                    </td>
                                    <td style="width:300px;text-align:right;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                       <b>Invoice From: <br>{{ $company_name }}</b>

                                    </td>
                                </tr>
                                 <tr style="border-collapse: collapse;height: 50px;">
                                    <td style="width: 200px;text-align:left;font-family: 'Montserrat', sans-serif;font-size:9px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 15px;">
                                       <b>TOTAL</b>
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                      {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                  
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                     
                                    </td>
                                    <td style="width:300px;text-align:right;font-family: 'Montserrat', sans-serif;font-size: 7px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                        {!! $company_address !!}
                                    </td>
                                </tr>
                                
                                <br><br>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End-->

                    <!--Footer Start-->
                     <tr>
                        <td style="height: 75px; ">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" > 
                                <tr style="border-collapse: collapse; height: 100px; background: url() no-repeat;background-position:center;background-size:cover;width: 600px; border-collapse: collapse;">
                                    <td style="width: 300px;border:0px;height: 120px;" > 
                                        
                                        </td>
                                       
                                        <td style="width: 300px;border:0px;height: 120px;text-align: left;margin: 0px;font-size: 22px;font-family: 'Montserrat', monospace;">
                                        
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