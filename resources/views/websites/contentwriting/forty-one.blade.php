<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body{
            margin: 0px;
            padding: 0px;
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" style="padding: 0px;">
                <table   width="100%" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td style="padding: 0px;max-height: 130px;">
                            <table  width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="height: 100px; background: url('{{ $invoice_header_image }}') no-repeat;background-position: 100% 100%;background-size:cover;width: 725px;">
                                        <p style="color: white;padding-left: 215px;font-size: 10px;"> {{ $company_name }}<br>{{ $company_email }}</p>
                                    </td>
                                    
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px;padding-top:0px;">
                            <table  width="100%" cellspacing="0" cellpadding="0">
                                <tr >
                                <td style="position: relative; width: max-content;margin-top:5px;">
                                    <div style="position: relative; display: inline-block;">
                                        <img src="{{ $company_logo }}" alt="" style="height: 60px; display: block;">
                                        <div style="
                                               position: absolute;
                                                bottom: 0;
                                                left: 20px;
                                                background: rgb(219 199 247);
                                                color: black;
                                                text-align: center;
                                                font-size: 10px;
                                                padding: 2px 0;
                                                font-weight: 800;
                                                width: 119px;
                                                border-radius: 5%;
                                                margin-bottom: 8px;">
                                           {{ $invoice_number }}
                                        </div>
                                    </div>
                                </td>

                                </tr>
                                     <tr  >   
                                    <td style="width: 100px;border-top: 1px solid black;">
                                        
                                        <p style="font-size: 10px;">BILL TO</p>
                                        <p style="font-size: 10px;">
                                            <b>
                                              {{ $company_name }}
                                            </b>
                                        </p>
                                
                                    </td>
                                    <td style="padding-right: 40px; width: 160px;border-top: 1px solid black;">
                                        
                                         <p style="font-size: 10px;">BILL FROM</p>
                                          <p style="font-size: 10px;">
                                            <b>
                                                contentcriteria.com<br>{!! $company_address !!}
                                            </b>
                                        </p>
                                    </td>
                                    <td style="text-align: left; width: 160px;border-top: 1px solid black;">
                                        
                                        <p style="font-size: 10px;">Date</p>
                                        <p style="font-size: 10px;">{{ $invoice_date }}</p>
                                        
                                    
                                    </td>
                                </tr>
                                
                            </table>
                           <br>
                        <br>
                         <div style="min-height: 680px !important;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;border-bottom: 1px solid black;border-top: 1px solid black;" >
                                    <td style="width: 250px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                       <b>SERVICE</b> 
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>IMAGES</b>
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>QTY OF WORDS</b>
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>PRICE</b>
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>AMOUNT</b>
                                    </td>
                                    
                                </tr>

                                @foreach($products as $product)
                                <tr style="border-collapse: collapse;height: 50px;border-bottom: 1px solid black;">
                                    <td style="width: 250px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                         <b>{{ $product->name }}</b><br>
                                         Quality:  {{ $product->quality }},  {{ $product->delivery }}
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b> {{ $product->imagecount }}</b>
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b> {{ $product->wordcount }}</b>
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b> {{  site_currency() }} {{ number_format($product->unit_price, 2) }}</b>
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b> {{  site_currency() }} {{ number_format($product->unit_price, 2) }}</b>
                                    </td>
                                    
                                </tr>
                                @endforeach
                                <tr>
                                <td style="width: 250px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                       Subtotal
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                      
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        {{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 250px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                       Discount
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        {{ site_currency() }} {{ number_format($discount_amount, 2) }}
                                    </td>
                                </tr>
                               
                                <tr style="border-bottom: 1px solid black;border-top: 1px solid black;height: 20px;">
                                    <td style="width: 250px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                       <b>Total Due</b>
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b></b>
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b></b>
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b></b>
                                    </td>
                                    <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>{{  site_currency() }} {{ number_format($invoice_amount, 2) }}</b>
                                    </td>
                                </tr>
                                
                           
                            </table>
                        </div>
                        </td>
                    </tr>
                   
                    <tr>
                        <td style="padding: 0px 32px;background: url('{{ $invoice_footer_image }}') no-repeat;background-position: center;background-size: cover;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
                                <tr style="background: url('{{ $invoice_footer_image }}') no-repeat;background-position: center;background-size: cover;height:105px;padding:50px;background-size:cover;width: 100%;">
                                    <td >
                                </td> 
                                <td style="color: black;margin: auto;">
                                    <p style="font-size: 10px;"><b>ADDRESS</b></p>
                                    <p style="font-size: 10px;">{!! $company_address !!}
                                    </p>
                                </td>
                                <td style="color: black;">
                                    <p style="font-size: 10px;"><b>CONTACTS</b></p>
                                    <p style="font-size: 10px;">{{ $company_email }} </p>
                                </td>         
                                </tr>
                                <tr>              
                            </table>
                        </td>
                    </tr> 
                  
                </table>
            </td>
        </tr>
    </table>
</body>
</html>