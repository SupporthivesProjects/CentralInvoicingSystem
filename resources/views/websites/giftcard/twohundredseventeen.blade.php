<!DOCTYPE html>
<html>
<head>
    <title>Your Email Title</title>
     <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">


</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);border-left: 20px solid  #f24c1e;border-right: 20px solid  #f24c1e;">
                    <!-- Header -->
                     <tr>
                        <td style="height: 75px;background-color: white;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" > 
                                <tr style="border-collapse: collapse; height: 100px; width: 600px; border-collapse: collapse;">
                                    <td style="width: 300px;border:0px;text-align: center;" > 
                                    <img src="{{ $company_logo }}" alt="" style="height: 60px; justify-content: left;"></td>
                                </tr>
                            </table>
                        </td>
                     </tr>
                    <!-- Header End -->

                     <!-- Content -->
                    <tr >
                        <td style="padding-top:0px;">
                            
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;background: linear-gradient(to right, #3e1d1b, #0a0a12);">
                                <tr style="border-collapse: collapse;">
                                    <td style="padding-top: 10px;width: 300px;padding: 30px;">
                                        
                                            <p style="font-size: 15px;font-family: 'Bebas Neue', sans-serif;color: #f24c1e;margin: 0px; text-align: left;padding-bottom: 5px;padding-left: 5px;">Invoice to</p>
                                            <p style="font-family: 'Montserrat', sans-serif;font-size: 16px;margin: 0px; text-align: left;padding-bottom: 5px;padding-left: 5px;color: white;">{{ $customer_name ? $customer_name : '' }}</p>
                                       
                                    </td>
                                    <td style="padding-top: 10px;width: 300px;padding: 30px;">
                                       <p style="font-family: arial;font-size: 60px;margin: 0px;font-weight: 400; text-align: right;padding-bottom: 5px;padding-right: 5px;color: white;">
                                            <b>INVOICE</b>
                                        </p>
                                     </td>
                                </tr>
                            </table>
                            
                             <table style="padding-left: 30px;padding-right: 30px; background: linear-gradient(to right, #3e1d1b, #0a0a12);border-bottom-left-radius: 30px;border-bottom-right-radius: 30px;justify-content: center;">
                                
                                <tr >
                                    <td style="width: 300px;color: white;border-top: 1px solid #f24c1e;border-collapse: collapse;">
                                        <p style="color: #f24c1e;font-family: 'Bebas Neue', sans-serif;margin-bottom: 0px;">Invoice Number</p>
                                        <p style="margin-top: 2px;">{{ $invoice_number }}</p>
                                    </td>
                                    <td style="width: 300px;text-align: right;color: white;border-top: 1px solid #f24c1e;border-collapse: collapse;">
                                        <p style="color: #f24c1e;font-family: 'Bebas Neue', sans-serif;margin-bottom: 0px;">Invoice Date</p>
                                        <p style="margin-top: 2px;">{{ $invoice_date }}</p>
                                    </td>
                                </tr>
                             </table>       
                        </td>
                    </tr>
                    <tr >
                            <td style="padding: 50px;padding-top: 0px;background-color: white;">
                            <table style="border-collapse: collapse;">
                                <tr style="border-collapse: collapse;height: 40px;border-bottom: 1px solid #f24c1e;font-family: 'Bebas Neue', sans-serif;">
                                    <td style="width: 300px;text-align: left; font-size: 17px;margin: 0px;border-collapse: collapse;">
                                        <p>ITEM DESCRIPTION</p>
                                    </td>
                                    <td style="width: 150px;text-align: center; font-size: 17px;margin: 0px; border-collapse: collapse;padding-left: 5px;">
                                        <p>UNIT PRICE</p>
                                    </td>
                                    <td style="width: 200px;text-align:center; font-size: 17px;margin: 0px;border-collapse: collapse;">
                                        <p>QTY</p>
                                    </td>
                                    <td style="width:100px;text-align: center; font-size: 17px;margin: 0px;border-collapse: collapse;padding-right: 2px;">
                                        <p>Total</p>
                                    </td>
                                </tr>
                                @foreach ($products as $product)
                                <tr style="border-collapse: collapse;height: 50px;">
                                    <td style="width: 350px;text-align:left;font-family: 'Montserrat', sans-serif;font-size:8px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     <b> {{ $product->name }}<br></b>
                                   
                                    </td>
                                    <td style="width:150px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                       {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     1
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                      {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                                {{-- <tr style="border-collapse: collapse;height: 50px;">
                                    <td style="width: 350px;text-align:left;font-family: 'Montserrat', sans-serif;font-size:8px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                      <b> Item Name<br></b>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
 
                                    </td>
                                    <td style="width:150px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                       $100.00
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     5
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                      $500.00
                                    </td>
                                </tr>
                                  <tr style="border-collapse: collapse;height: 50px;">
                                    <td style="width: 350px;text-align:left;font-family: 'Montserrat', sans-serif;font-size:8px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                      <b> Item Name<br></b>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
 
                                    </td>
                                    <td style="width:150px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                      $50.00
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     5
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                      $500.00
                                    </td>
                                </tr>
                               <tr style="border-collapse: collapse;height: 50px;">
                                    <td style="width: 350px;text-align:left;font-family: 'Montserrat', sans-serif;font-size:8px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                      <b> Item Name<br></b>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
 
                                    </td>
                                    <td style="width:150px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                      $50.00
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     5
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                      $500.00
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 50px;border-bottom: 1px solid #f24c1e;">
                                    <td style="width: 350px;text-align:left;font-family: 'Montserrat', sans-serif;font-size:8px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                      <b> Item Name<br></b>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
 
                                    </td>
                                    <td style="width:150px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                      $50.00
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     5
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                      $500.00
                                    </td>
                                </tr> --}}
                                <tr style="border-collapse: collapse;height: 15px;">
                                    <td style="width: 350px;text-align:left;font-family: 'Montserrat', sans-serif;font-size:8px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     
                                    </td>
                                    <td style="width:150px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                      
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                     
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 25px;">
                                    <td style="width: 350px;text-align:center;font-family: 'Montserrat', sans-serif;font-size:9px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #f24c1e;border-top-left-radius: 30px;border-top-right-radius: 30px;color: white;">
                                        <b>Grand Total:</b>
                                    </td>
                                    <td style="width:150px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                      
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Bebas Neue', sans-serif;font-size: 13px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     <p style="margin-bottom: 0px;margin-top: 0px;">SUBTOTAL</p>
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                      {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}
                                    </td>
                                </tr>
                                 <tr style="border-collapse: collapse;height: 25px;">
                                    <td style="width: 350px;text-align:center;font-family: 'Montserrat', sans-serif;font-size:24px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #f24c1e;color: white;">
                                       <b>{{ site_currency() . number_format($invoice_amount + $discount_amount ?? 0, 2) }}</b>
                                    </td>
                                    <td style="width:150px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                      
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Bebas Neue', sans-serif;font-size: 13px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     <p>DISCOUNT</p>
                                    </td>
                                    <td style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                      {{ site_currency() . number_format($discount_amount ?? 0, 2) }}
                                    </td>
                                </tr>
                                
                            </table>
                            <br><br>
                        </td>
                    </tr>
                    <!-- Content End-->
                     
                    <tr >
                        <td style="text-align: right;padding-right: 40px;padding-left: 40px; font-size: 12px;font-family: 'Bebas Neue', sans-serif;">
                            <p style="margin: 0px;height: 25px;">{{ $company_name }}</p>
                            <p style="height: 25px;margin-top: 0px;">{!! $company_address !!}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>