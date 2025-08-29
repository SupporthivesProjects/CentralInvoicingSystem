<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body{
            margin: 0px;
            padding: 0px;
        }
        
        .footer-fixed {
            position: fixed;
            bottom: 0px;
            left: 0;
            right: 0;
            width: 100%;
            /* background: url('{{ $invoice_footer_image }}') center center no-repeat; */
            /* background-size: cover; */
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#FFFFFF" style="padding: 0px;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse;">
                    <!-- Header -->
                    <tr>
                        <td style="height: 100px; background: url('{{ $invoice_header_image }}') no-repeat;background-position:center;background-size:cover;width: 100%;text-align: center;">
                                <img src="{{ $invoice_image2 }}" alt="" >
                        </td>
                                    
                    </tr>
                    <!-- Header End -->

                     <!-- Content -->
                    <tr style=" background: url('{{ $invoice_image1 }}') no-repeat;background-position:center;background-size:cover;">
                        <td style="padding:40px;padding-top:0px;">
                            <table>
                                <tr>
                                    <td style="width: 100%;">
                                         <p style="font-family: Sora SemiBold;font-size: 28px;margin-bottom: 5px;font-weight: 400;">
                                           INVOICE
                                        </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            <b>Date:</b> {{ $invoice_date }}
                                        </p>

                                        <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            <b>Invoice Number:</b> {{ $invoice_number }}
                                        </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>                                       
                                        <p style="font-family: arial;font-size: 10px;margin-bottom: 5px;font-weight: 700;">
                                         Billed To: 
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            {{ $customer_name }}
                                        </p>
                                    </td>
                                </tr>

                                 <tr>
                                    <td>                                       
                                        <p style="font-family: arial;font-size: 10px;margin-bottom: 5px;font-weight: 700;">
                                        Billed From:
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            {{ $site_name }}
                                        </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <p style="font-family: arial;font-size: 10px;margin-bottom: 5px;font-weight: 400;">
                                            <strong>Email:</strong> {{ $company_email }}
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin-bottom: 5px;font-weight: 400;">
                                            <b>Website:</b> {{ $site_name }}</p>
                                        <p style="font-family: arial;font-size: 10px;margin-bottom: 5px;font-weight: 400;">
                                            <b>Phone:</b>{{ $company_mobile }}</p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <b>Address</b> {!! $company_address !!}</p>
                                    </td>
                                    
                                </tr>
                            </table>
                            
                            
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                <tr style="border-collapse: collapse;height: 30px;background-color: #E54666; color: white;border-bottom: 0px;border: 0px;">
                                    <td style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       <b>Item</b> 
                                    </td>
                                    <td style="width: 300px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>Description</b>
                                    </td>
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        <b>Quantity</b>
                                    </td>
                                    <td style="width: 100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>Unit Price</b>
                                    </td>
                                    <td style="width:100px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 2px;">
                                        <b>Total</b>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;border: 1px solid #F5F5F5;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 2px;border: 1px solid #F5F5F5;">
                                      {{ $product->name }}
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;border: 1px solid #F5F5F5;">
                                        {{ Str::limit(strip_tags($product->description), 100) }}
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;border: 1px solid #F5F5F5;">
                                        1
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border: 1px solid #F5F5F5;">
                                       {{ site_currency() . number_format($product->unit_price, 2) }}
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border: 1px solid #F5F5F5;padding-right: 2px;">
                                        {{ site_currency() . number_format($product->unit_price, 2) }}
                                    </td>
                                </tr> 
                                @endforeach
                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 2px;">
                                   
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                       
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                       
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                     
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                        
                                    </td>
                                </tr>
                               
                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                      
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-bottom: 1px solid #F5F5F5;padding-left: 5px;">
                                        Subtotal
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-bottom: 1px solid #F5F5F5;">
                                       
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border: 1px solid #F5F5F5;padding-right: 2px;">
                                        {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                    </td>
                                </tr>
                                 <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                      
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-bottom: 1px solid #F5F5F5;padding-left: 5px;">
                                        Discount
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-bottom: 1px solid #F5F5F5;">
                                       
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border: 1px solid #F5F5F5;padding-right: 2px;">
                                        {{ site_currency() . number_format($discount_amount, 2) }}
                                    </td>
                                </tr>
                                 <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                      
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #E54666;color: white;padding-left: 5px;">
                                        Grand Total
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #E54666;color: white;">
                                       
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;background-color: #E54666;color: white;padding-right: 2px;border-left: 1px solid whitesmoke;">
                                      {{ site_currency() . number_format($invoice_amount, 2) }}
                                    </td>
                                </tr><br><br>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End-->

                    <!-----------Footer----------->
                    <div class="footer-fixed" style="height: 120px; background: url('{{ $invoice_footer_image }}'); background-repeat: no-repeat;background-position:center;background-size:cover;">
                        
                    </div> 
                    <!-----------Footer End----------->

                </table>
            </td>
        </tr>
    </table>
</body>
</html>