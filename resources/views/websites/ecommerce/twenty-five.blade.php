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
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td style="height: 90px; background: url('{{ $invoice_header_image }}') no-repeat;background-position:center;background-size:cover;width: 600px;">
                                         
                                    </td>
                                    
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr >
                        <td style="padding:40px;padding-top:10px;">
                            <table style="background: url('{{ $invoice_image1 }}') no-repeat;background-position: center;height:141px; width: 100%;border-collapse: collapse;">
                                <tr >
                                    <td style="width: 290px;">
                                         <p style="font-family: arial;font-size:20px;margin-bottom: 5px;font-weight: 400;">
                                           <b>INVOICE</b> 
                                        </p>

                                        
                                        <br>
                                        <p style="font-family: arial;font-size: 10px;margin-bottom: 5px;">BILLED FROM:</p>
                                        <p style="font-family: Courier New;font-size: 10px;margin: 0px;font-weight: 400;">
                                        {{ $site->site_name }}<br>{{ $site->site_link }}</p>
                                        <br>
                                        <p style="font-family: arial;font-size: 10px;margin-bottom: 5px;font-weight: 400;">
                                            BILLED TO
                                        </p>
                                        <p style="font-family: Courier New;font-size: 10px;margin-bottom: 5px;font-weight: 400;">
                                        {{ $customer_name }}</p>
                                    </td>
                                    <td style="width:300px;
                                    padding: 40px;padding-top: 0px;padding-right: 0px;
                                    text-align: right">
                                        <p style="font-family: Courier New;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <b>Date:</b> {{ $invoice_date }}
                                        </p>
                                       <p style="font-family: Courier New;font-size:10px;margin: 0px;font-weight: 400;">
                                            <b>Invoice Number:</b> #{{ $invoice_number}}
                                        </p><br><br>
                                        <p style="font-family: Courier New;font-size: 10px;margin-bottom: 5px;font-weight: 400;">
                                            <strong>Email:</strong> {{ $company_email}}
                                        </p>
                                          <p style="font-family: Courier New;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <b>Address</b> {!! $company_address !!}</p>
                                    </td>
                                </tr>
                            </table>
                            
                            <div style="min-height: 500px !important;">
                                <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                    <tr style="border-collapse: collapse;height: 30px;background-color: #FF4500; color: white;border-bottom: 0px;border: 0px;">
                                        <td style="width: 300px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>ITEM NAME</b> 
                                        </td>
                                        <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>QUANTITY</b>
                                        </td>
                                        <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                            <b>UNITY PRICE</b>
                                        </td>
                                        <td style="width: 100px;text-align:center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>TOTAL</b>
                                        </td>
                                        
                                    </tr>
                                    @foreach($products as $product)
                                    <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;border-bottom: 1px solid #FF4500;">
                                        <td style="width: 100px;text-align: left;font-family: Courier Newl;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        {{ $product->name }}
                                        </td>
                                        <td style="width: 300px;text-align:left;padding-left:10px;font-family: Courier New;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                            1
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: Courier New;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                            {{ site_currency() . number_format($product->unit_price, 2) }}
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: Courier New;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                            {{ site_currency() . number_format($product->unit_price, 2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                        <td style="width: 100px;text-align: left;font-family: Courier Newl;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                        </td>
                                        <td style="width: 300px;text-align:left;padding-left:10px;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse; border-bottom: 1px solid #FF4500;">
                                            SUBTOTAL
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: Courier New;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse; border-bottom: 1px solid #FF4500;">
                                        
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: Courier New;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse; border-bottom: 1px solid #FF4500;">
                                            {{ site_currency() . number_format(($invoice_amount + $discount_amount), 2) }}
                                        </td>
                                    </tr>
                                    <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                        <td style="width: 100px;text-align: left;font-family: Courier Newl;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                        </td>
                                        <td style="width: 300px;text-align:left;padding-left:10px;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-bottom: 1px solid #FF4500;">
                                            DISCOUNT
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: Courier New;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-bottom: 1px solid #FF4500;">
                                        
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: Courier New;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-bottom: 1px solid #FF4500;">
                                            {{ site_currency() . number_format($discount_amount, 2) }}
                                        </td>
                                    </tr>
                                    <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                        <td style="width: 100px;text-align: left;font-family: Courier Newl;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                        </td>
                                        <td style="width: 300px;text-align:left;padding-left:10px;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #FF4500;">
                                            GRAND TOTAL
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: Courier New;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #FF4500;">
                                        
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: Courier New;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #FF4500;">
                                            {{ site_currency() . number_format($invoice_amount, 2) }}
                                        </td>
                                    </tr><br><br>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
                                <tr style="background: url('{{ $invoice_image2 }}') no-repeat;background-position: center;height:141px; background-size:cover;width: 100%;">
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