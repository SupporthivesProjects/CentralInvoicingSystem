<!DOCTYPE html>
<html>
<head>
    <title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                   <tr>
                        <td style="padding: 0px;max-height: 130px;">
                            <table  width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td style="height: 120px; background: url('{{ $invoice_header_image }}') no-repeat;background-position: center;background-size:cover;width: 600px;">
                                        <!--<img src="Picture3.png" alt="" style="margin: auto; padding-left: 90px; height:60px;">--> 
                                    </td>
                                    
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px;padding-top:0px;">
                            <table  width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td style="padding-top: 20px; width: 390px;">
                                        <h1 style="font-family: arial;font-size: 20px;margin: 0px;font-weight: 700;">INVOICE</h1><br>
                                         <p style="font-family: arial;font-size:10px;margin: 5px;margin-left: 0px; font-weight: 400;">
                                           <b> DATE:</b> {{ $invoice_date }}
                                        </p>

                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            <b>Invoice Number:</b> #{{ $invoice_number }}
                                        </p>
                                        <br>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 700;">
                                            
                                                BILLED FROM:
                                            
                                        </p>
                                        <br>
                                        <p style="font-family: arial;font-size: 10px;margin: 5px;margin-left: 0px; font-weight: 400;">
                                           <b>Company Name: </b>{{ $site->company_name }}
                                        </p>
                                        
                                        <p style="font-family: arial;font-size: 10px;margin: 7px;margin-left: 0px;font-weight: 400;">
                                            <b>Address: </b>{{ $company_address }}
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 7px;margin-left: 0px;font-weight: 400;">
                                            <b>License No:</b> {{ $site->site_description }}  
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 7px;margin-left: 0px;font-weight: 400;">
                                            <b>Email: </b> {{ $company_email }}
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 7px;margin-left: 0px;font-weight: 400;">
                                            <b>Website: </b>{{ $site->site_link }}
                                        </p>
                                    </td>
                                    <td style="width:300px;
                                    padding: 40px;padding-top: 0px;padding-right: 0px;
                                    text-align: right;">
                                        <br><br>
                                        
                                        
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <b>
                                                BILLED TO:
                                            </b>
                                        </p><br>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            {{ !empty($customer_name) ? $customer_name : 'Customer' }}
                                        </p>
                                        
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <div style="min-height: 300px !important;">
                                <table  width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                    <tr style="border-collapse: collapse;height: 30px;background-color: #B2ACAC;border-bottom: 0px;border: 0px;">
                                        <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>Item #</b> 
                                        </td>
                                        <td style="width: 300px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>Service Details</b>
                                        </td>
                                        <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                            <b>Quality</b>
                                        </td>
                                        <td style="width: 100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>Imagery</b>
                                        </td>
                                        <td style="width:100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>Total</b>
                                        </td>
                                    </tr>
                                    @foreach($products as $product)
                                    <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;border-bottom: 1px solid black;">
                                        <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        #{{ $loop->iteration }}
                                        </td>
                                        <td style="width: 300px;text-align:left;padding-left:10px;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        {{ $product->name }}
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        {{ $product->quality }},  {{ $product->delivery }}
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        {{ $product->imagecount }}
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        {{  site_currency() }} {{ number_format($product->unit_price, 2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                        <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                        </td>
                                        <td style="width: 300px;text-align:left;padding-left:10px;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                            
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-bottom: 1px solid black;">
                                            Subtotal
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-bottom: 1px solid black;">
                                        
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-bottom: 1px solid black;">
                                        {{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}
                                        </td>
                                    </tr>
                                    <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                        <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                        </td>
                                        <td style="width: 300px;text-align:left;padding-left:10px;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                            
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                            Discount
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                            {{ site_currency() }} {{ number_format($discount_amount, 2) }}
                                        </td>
                                    </tr>
                                    <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                        <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                        </td>
                                        <td style="width: 300px;text-align:left;padding-left:10px;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                            
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #B2ACAC;">
                                            Grand Total
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #B2ACAC;">
                                        
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #B2ACAC;">
                                            {{  site_currency() }} {{ number_format($invoice_amount, 2) }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
                                <tr style="background: url('{{ $invoice_image1 }}') no-repeat;background-position: center;background-size: cover;height: 297px;padding:50px;background-size:cover;width: 100%;">
                                    <td style="text-align:center;">
                                        <p style="text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight:700;color:whitesmoke;">
                                            
                                        </p>
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