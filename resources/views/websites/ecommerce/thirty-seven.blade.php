<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;max-height: 150px;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td style="height: 140px; background: url('{{ $invoice_header_image }}') no-repeat;background-position: 100% 100%;background-size:cover;width: 600px;">
                                        <img src="{{ $company_logo }}" alt="" style="margin: auto; padding-left: 90px; height:50px;"> 
                                    </td>
                                    
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                     <!-- Content -->
                    <tr>
                        <td style="padding:40px;padding-top:0px;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td>
                                         <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                           <b> DATE:</b>  {{ $invoice_date }}
                                        </p>

                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            <b>Invoice Number:</b> #{{ $invoice_number}}
                                        </p>
                                        <br>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 700;">
                                            
                                                BILLED FROM:
                                            
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                         {{ $site_name}}
                                        </p>
                                        <br>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <strong>Email:</strong> {{ $company_email}}
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <b>Website:</b> {{ $site->site_link }}
                                        </p>
                                    </td>
                                    <td style="width:300px;
                                    padding: 40px;padding-top: 0px;padding-right: 0px;
                                    text-align: right;">
                                        <h1 style="font-family: arial;font-size: 20px;margin: 0px;font-weight: 700;">INVOICE</h1><br><br>
                                        
                                        
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <b>
                                                BILLED TO:
                                            </b>
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            {{ $customer_name }}
                                        </p>
                                        
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <div style="min-height: 500px !important;">
                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                    <tr style="border-collapse: collapse;height: 30px;background-color: #D26E00;; color: white;border-bottom: 0px;border: 0px;">
                                        <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>#</b> 
                                        </td>
                                        <td style="width: 300px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>Product</b>
                                        </td>
                                        <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-left: 1px solid whitesmoke; border-collapse: collapse;">
                                            <b>Quantity</b>
                                        </td>
                                        <td style="width: 100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>Price</b>
                                        </td>
                                        <td style="width:100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>Total</b>
                                        </td>
                                    </tr>
                                    @foreach($products as $index => $product)
                                    <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;border-bottom: 1px solid black;">
                                        <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                         {{ $index + 1 }}
                                        </td>
                                        <td style="width: 300px;text-align:left;padding-left:10px;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                         {{ $product->name }}
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                            1
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                            {{ site_currency() . number_format($product->unit_price, 2) }}
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                             {{ site_currency() . number_format($product->unit_price, 2) }}
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
                                            {{ site_currency() . number_format(($invoice_amount + $discount_amount), 2) }}
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
                                            {{ site_currency() . number_format($discount_amount, 2) }}
                                        </td>
                                    </tr>
                                    <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                        <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                        </td>
                                        <td style="width: 300px;text-align:left;padding-left:10px;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                            
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #D26E00;color: white;">
                                            Grand Total
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #D26E00;color: white;">
                                        
                                        </td>
                                        <td style="width:100px;text-align:left;padding-right:10px;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #D26E00;color: white;">
                                            {{ site_currency() . number_format($invoice_amount, 2) }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                   
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
                                <tr style="background: url('{{ $invoice_footer_image }}') no-repeat;background-position: center;background-size: cover;height:141px;padding:50px;background-size:cover;width: 100%;">
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