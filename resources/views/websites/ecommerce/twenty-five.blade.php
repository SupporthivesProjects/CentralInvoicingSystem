<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
            .for_bttom {
            position: fixed;
            bottom: -2px;
            left: 0;
            right: 0;
            width: 100%;
        }
        *{
            margin:0px;
            padding:0px;
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; ">
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
                    <tr>
                        <td style="padding:20px 100px;">
                            <table style="background: url('{{ $invoice_image1 }}') no-repeat;background-position: center;height:141px; width: 100%;border-collapse: collapse;">
                                <tr>
                                    <td style="width:30%;vertical-align:top;">
                                         <p style="font-family: arial;font-size:28px;margin-bottom: 5px;font-weight: 400;">
                                           <b>INVOICE</b> 
                                        </p>

                                        
                                        <br>
                                        <!-- <a href="https://www.logikalcoding.com/" style="text-decoration: none;color: #000">www.logikalcoding.com</a> -->
                                        <p style="font-family: arial;font-size: 10px;margin-bottom: 5px;">BILLED FROM:</p>
                                        <p style="font-family: Courier New;font-size: 10px;margin: 0px;font-weight: 600;">
                                        {{ $site_name }} </p>
                                        <br>
                                        <p style="font-family: arial;font-size: 10px;margin-bottom: 5px;font-weight: 400;">
                                            BILLED TO
                                        </p>
                                        <p style="font-family: Courier New;font-size: 10px;margin-bottom: 5px;font-weight: 600;">
                                        {{ $customer_name }}</p>
                                    </td>
                                    <td style="width:70%;padding:0px 40px;text-align:right;vertical-align:top;">
                                        <p style="font-family: Courier New;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <b style="font-size: 12px;text-transform:uppercase;">Date:</b> {{ $invoice_date }}
                                        </p>
                                       <p style="font-family: Courier New;font-size:10px;margin: 0px;font-weight: 400;">
                                            <b style="font-size: 12px;text-transform:uppercase;">Invoice Number:</b> #{{ $invoice_number}}
                                        </p><br>
                                        <p style="font-family: Courier New;font-size: 10px;margin-bottom: 5px;font-weight: 400;">
                                            <strong style="font-size: 12px;text-transform:uppercase;">Email:</strong> {{ $company_email}}
                                        </p>
                                          <p style="font-family: Courier New;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <b style="font-size: 12px;text-transform:uppercase;">Address:<br></b> {!! $company_address !!}</p>
                                    </td>
                                </tr>
                            </table>
                            
                            <div style="min-height: 500px !important;">
                                <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                    <tr style="border-collapse: collapse;height: 30px;background-color: #FF4500; color: white;border-bottom: 0px;border: 0px;">
                                        <td style="width: 300px;text-align: left;padding-left:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>ITEM NAME</b> 
                                        </td>
                                        <td style="width: 100px;text-align:center;padding-left:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>QUANTITY</b>
                                        </td>
                                        <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                            <b>UNIT PRICE</b>
                                        </td>
                                        <td style="width: 100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>TOTAL</b>
                                        </td>
                                        
                                    </tr>
                                    @foreach($products as $product)
                                    <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;border-bottom: 1px solid #FF4500;">
                                        <td style="width: 100px;text-align: left;padding-left:10px;font-family: Courier Newl;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        {{ $product->name }}
                                        </td>
                                        <td style="width: 300px;text-align:center;padding-left:10px;font-family: Courier New;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
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
                                        <td style="width: 100px;text-align: left;font-family: Courier Newl;font-size: 10px;margin: 0px;font-weight: 700; border-collapse: collapse;">
                                        
                                        </td>
                                        <td style="width: 300px;text-align:left;padding-left:10px;font-family: arial;font-size:10px;margin: 0px;font-weight:900; border-collapse: collapse;background-color: #FF4500; color: white;">
                                          <b>GRAND TOTAL</b>  
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: Courier New;font-size: 10px;margin: 0px;font-weight: 700; border-collapse: collapse;background-color: #FF4500;">
                                        
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: Courier New;font-size: 10px;margin: 0px;font-weight:900; border-collapse: collapse;background-color: #FF4500; color: white;">
                                          <b> {{ site_currency() . number_format($invoice_amount, 2) }}</b> 
                                        </td>
                                    </tr><br><br>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="for_bttom">
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