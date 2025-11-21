<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        *{
            margin:0px;
            padding:0px;
        }
    </style>
</head>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">

<body style="padding:0px;height:100vh;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding:0px;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse;padding:0px;height:100vh;">  
                    <tr>
                        <td style="background-color: #8BB9DC;padding:0px;">
                                <div class="row" >
                                <div class="column" style="float: left;">

                            <table style="width: 250px;min-height:90vh;background-color: white;">
                                <tr style="width: 250px;">
                                    <td style="text-align: center;display: flex;justify-content: center;">
                                        <img src="{{ $company_logo }}" style="height: 110px;">
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td style="display: flex; align-items: center;">
                                        <img src="{{ $invoice_image2 }}" style="height: 230px;">
                                    </td>
                                </tr>
                                
                            </table>
                                </div>
                                </div>
                                <div class="row">
                                <div class="column" style="padding-right: 10px;">
                                    <table>
                                        <tr >
                                            <td style="width: 225px;text-align: center;"><img src="{{ $invoice_image1 }}" style="height: 100px;"></td>
                                            <td style="width: 225px;text-align: right;font-family: 'Roboto', sans-serif;color: white;">
                                                <h1 style="font-size: 42px;margin: 0px;">INVOICE</h1>
                                                <p style="font-size: 10px;margin: 0px;">Invoice No : {{ $invoice_number }}</p>
                                            </td>
                                        </tr>
                                        <tr style="height: 30px;">
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td style="font-family: 'Roboto', sans-serif;padding-left: 20px;width: 260px;color: white;">
                                                <h4 style="margin: 0px;font-size: 14px"> Invoice To</h4>
                                                <h2 style="margin: 0px;font-size: 26px">{{ $customer_name ? $customer_name : '' }}<br>
                                                    {{ $customer_email ? $customer_email : '' }}<br>
                                                    {{ $customer_mobile ? $customer_mobile : '' }}</h2>
                                            </td>
                                        </tr>
                                    </table>
                                    <table>
                                        <tr style="color: white;">
                                            <td style="font-size: 8px;font-family: 'Roboto', sans-serif;padding-left: 20px;">
                                               <p style="display: flex;align-items: center;"> <img src="{{ $invoice_image3 }}" style="height: 20px;padding-right: 10px;">{{ $company_email }}</p>
                                            </td>
                                             <td style="font-size: 8px;font-family: 'Roboto', sans-serif;padding-left: 10px;width: 150px;">
                                               <p style="display: flex;align-items: center;"> <img src="{{ $invoice_image4 }}" style="height: 20px;padding-right: 10px;">{!! $company_address !!}</p>
                                            </td>
                                            <td style="font-size: 8px;font-family: 'Roboto', sans-serif;padding-left: 10px;">
                                               <p> <b style="font-size: 10px;">Date :</b><br>{{ $invoice_date }}</p>
                                            </td>
                                        </tr>
                                    </table>
                                    <br>
                                    
                                    <table style="padding: 20px;border-collapse: collapse;font-family: 'Roboto', sans-serif;">
                                    <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;background-color: #4B8EC6;color: white;">
                                            <td style="width: 200px;text-align: left;font-size: 6px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 10px;">
                                        <b> ITEM DESCRIPTION</b>
                                        </td>
                                        <td style="width: 100px;text-align: center;font-size: 6px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                        <b>UNIT PRICE</b>
                                        </td>
                                        <td style="width: 100px;text-align: center;font-size: 6px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                        <b>QUANTITY</b>
                                        </td>
                                        <td style="width:100px;text-align:center;font-size: 6px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                            <b>TOTAL</b>
                                        </td>
                                    </tr>

                                @foreach ($products as $product)   
                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;background-color: white;">
                                    <td style="width: 200px;text-align: left;font-size: 6px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 10px;">
                                      <b> {{ $product->name }}</b>
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 6px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                        {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 6px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                     1
                                    </td>
                                    
                                    <td style="width:100px;text-align:center;font-size: 6px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}
                                    </td>
                                </tr>
                                @endforeach

                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;color: white;">
                                    <td style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 10px;">
                                      
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                      
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: 'Roboto', sans-serif;font-size: 6px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                     <b>SUBTOTAL</b>
                                    </td>
                                    
                                    <td style="width:100px;text-align:center;font-family: 'Roboto', sans-serif;font-size: 6px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                       <b>{{ site_currency() . number_format($invoice_amount + $discount_amount ?? 0, 2) }}</b>
                                    </td>
                                </tr>

                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;color: white;">
                                    <td style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 10px;">
                                      
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                      
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: 'Roboto', sans-serif;font-size: 6px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                     <b>DISCOUNT</b>
                                    </td>
                                    
                                    <td style="width:100px;text-align:center;font-family: 'Roboto', sans-serif;font-size: 6px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                       <b>{{ site_currency() . number_format($discount_amount ?? 0, 2) }}</b>
                                    </td>
                                </tr>

                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;color: white;">
                                    <td style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 10px;">
                                      
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                      
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                     
                                    </td>
                                    
                                    <td style="width:100px;text-align:center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                    
                                    </td>
                                </tr>

                                
                                    </table>
                                    <table>
                                        <tr>
                                             <td style="width: 200px;text-align: left;font-family: 'Roboto', sans-serif;font-size: 16px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 10px;color: white;">
                                      TOTAL
                                    </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 200px;text-align: left;font-family: 'Roboto', sans-serif;font-size: 30px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 10px;display: flex;color: white;">
                                                {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}
                                    </td>
                                        </tr>
                                        <tr>
                                            <td style="border-bottom: 3px solid #4B8EC6;width: 600px;padding-top: 10px;"></td>
                                        </tr>
                                    </table>


                                </div>
                            </div>
                            
                            
                                
                            
                            
                            
                            

                           
                    <!-- Content End-->

                    <!-----------Footer-->
                    <tr>
                        <td style="height:10vh;background-color: #8BB9DC;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
                                <tr style="border-collapse: collapse;font-family: 'Roboto', sans-serif;font-size: 9px; color: white;">
                                    <td style="border:0px;padding: 10px;" > 
                                      <p style="display: flex; align-items: center;"> <img src="{{ $invoice_image5 }}" style="height: 20px;padding-right: 10px;"> www.yourhealthfromhome.com</p>
                                       <p style="display: flex; align-items: center;"><img src="{{ $invoice_image3 }}" style="height: 20px;padding-right: 10px;"> {{ $company_email }}</p>
                                        </td>
                                        <td style="text-align: right;padding: 10px;">
                                            {!! $company_address !!}
                                        </td>          
                                </tr>
                                              
                            </table>
                        </td>
                    </tr> 
                   <!--Footer End----------->

                </table>
            </td>
        </tr>
    </table>
</body>
</html>