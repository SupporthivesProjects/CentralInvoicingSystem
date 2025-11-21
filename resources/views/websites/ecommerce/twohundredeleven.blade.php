<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        *{
            padding:0px;
            margin:0px;
        }
    </style>
</head>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
<body style="padding:0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding:0px;vertical-align:top">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse;height:100vh;">      
                    <tr>
                        <td style="background-color:#8cbade;">
                                <div class="row">
                                <div class="column" style="float: left;">

                            <table style="width:250px;min-height:100vh;background-color: white;">
                                <tr style="width:100%;">
                                    <td style="text-align: center;display: flex;justify-content: center;">
                                        <img src="{{ $company_logo }}" style="height: 110px;">
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td style="display: flex; align-items: center;">
                                        <img src="{{ $invoice_image2 }}" style="height: 230px;">
                                    </td>
                                </tr>
                                <tr style="height:150px;background:#8cbade;position:absolute;bottom:0px;"> </tr>
                                
                            </table>
                                </div>
                                </div>
                                <div class="row">
                                <div class="column" style="padding:0px 10px;">
                                    <table>
                                        <tr>
                                            <td style="width:100%;text-align: center;"><img src="{{ $invoice_image1 }}" style="height: 100px;"></td>
                                            <td style="width:100%;text-align: right;font-family: 'Roboto', sans-serif;color:#ffffff;">
                                                <h1 style="font-size: 42px;margin: 0px;color:#ffffff;">INVOICE</h1>
                                                <p style="font-size: 10px;margin: 0px;color:#ffffff;">Invoice No :  {{ $invoice_number }}</p>
                                            </td>
                                        </tr>
                                        <tr style="height: 30px;">
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td style="font-family: 'Roboto', sans-serif;padding-left: 20px;width: 260px;">
                                                <h4 style="margin: 0px;font-size: 14px;color:#ffffff;"> Invoice To</h4>
                                                <h2 style="margin: 0px;font-size: 26px;color:#ffffff;">  {{ $customer_name ? $customer_name : '' }}<br>
                                                    {{ $customer_email ? $customer_email : '' }}<br>
                                                    {{ $customer_mobile ? $customer_mobile : '' }}
                                                </h2>
                                            </td>
                                        </tr>
                                    </table>
                                    <table>
                                        <tr>
                                            <td style="font-size: 8px;font-family: 'Roboto', sans-serif;padding-left: 20px;display: flex;align-items: center;color:#ffffff;width:30%;">
                                                <img src="{{ $invoice_image3 }}" style="height: 20px;padding-right: 10px;">{{ $company_email }}
                                            </td>
                                             <td style="font-size: 8px;font-family: 'Roboto', sans-serif;padding-left: 10px;color:#ffffff;width:40%;">
                                                <div style="display:flex;gap:10px;">
                                                 <img src="{{ $invoice_image4 }}" style="height: 20px;">
                                                 <p>{!! $company_address !!}</p> 
                                                </div>
                                            </td>
                                            <td style="font-size: 8px;font-family: 'Roboto', sans-serif;padding-left: 10px;color:#ffffff;width:30%;">
                                                <b style="font-size: 10px;">Date :</b><br>
                                                {{ $invoice_date }}
                                            </td>
                                        </tr>
                                    </table>
                                    <br>
                                    
                                    <table style="padding: 20px;border-collapse: collapse;font-family: 'Roboto', sans-serif;">
                                        <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;background-color:#428bc2;color: white;">
                                            <td style="width: 200px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 10px;">
                                     <b> ITEM DESCRIPTION</b>
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                     <b>UNIT PRICE</b>
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                      <b>QUANTITY</b>
                                    </td>
                                    <td style="width:100px;text-align:center;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                       	<b>TOTAL</b>
                                    </td>
                                    </tr>

                                    @foreach ($products as $product)
                                    <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;background-color:white;color: black;">
                                        <td style="width: 200px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 10px;">
                                        <b>  {{ $product->name }}</b>
                                        </td>
                                        <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                            {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}
                                        </td>
                                        <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                        1
                                        </td>
                                        
                                        <td style="width:100px;text-align:center;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                            {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}
                                        </td>
                                    </tr>
                                    @endforeach

                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 10px;">
                                      
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                      
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: 'Roboto', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;color:#ffffff;">
                                     <b>SUBTOTAL</b>
                                    </td>
                                    
                                    <td style="width:100px;text-align:center;font-family: 'Roboto', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;color:#ffffff;">
                                       <b>{{ site_currency() . number_format($invoice_amount + $discount_amount ?? 0, 2) }}</b>
                                    </td>
                                </tr>

                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 10px;">
                                      
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                      
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: 'Roboto', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;color:white;">
                                     <b>DISCOUNT</b>
                                    </td>
                                    
                                    <td style="width:100px;text-align:center;font-family: 'Roboto', sans-serif;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;color:white;">
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
                                             <td style="width: 200px;text-align: left;font-family: 'Roboto', sans-serif;font-size: 16px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 10px;color:white;">
                                      TOTAL
                                    </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 200px;text-align: left;font-family: 'Roboto', sans-serif;font-size: 30px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 10px;display: flex;color:white;">
                                                {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}
                                    </td>
                                        </tr>
                                    </table>


                                </div>
                            </div>
                            

                </table>
            </td>
        </tr>
    </table>
</body>
</html>