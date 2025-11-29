<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        *{
            margin:0px;
            padding:0px;
        }
        .footer_bottom {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            width: 100%;
            
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td  bgcolor="#f2f2f2" style="padding:0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse;margin:0; padding:0; ">
                    <!-- Header -->
                    <tr style="width: 100%">
                        <td style="max-height: 130px;width: 100% ">
                            <table width="100%" style="border-spacing: 0px;">
                                <tr style="width: 100%">
                                    <td style="height: 120px; background: url('{{ $invoice_header_image }}') no-repeat;background-position:center;background-size:100% 100%;width: 100%;text-align: center;">
                                      <img src="{{ $company_logo  }}" alt="" style="height: 50px; ">
                                    </td>
                                    
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                     <!-- Content -->
                    <tr >
                        <td style="padding:40px;padding-top:0px;">
                            <table>
                                
                                
                                <tr>
                                    <td style="padding-top: 10px;font-size: 11px; width: 100%; ">
                                        <p style="font-family: arial;font-size: 26px;margin: 0px;font-weight: 400;  text-align: left; ">
                                            <b>INVOICE</b>
                                        </p>
                                        <p style="margin-bottom: 0px;"><b>INVOICE NUMBER: </b> {{ $invoice_number }}</p><br>
                                        <p style="margin-top: 0px;"><b>DATE: </b>{{ $invoice_date }}</p><br>
                                        <p><b>Billed To: </b>{{ $customer_name ? $customer_name:  '' }}<br>
                                            {{ $customer_email ? $customer_email : '' }}<br>
                                            {{ $customer_mobile ? $customer_mobile : '' }}
                                        </p>
                                    </td>
                                    <td style="padding-top: 10px; text-align: right;font-size: 11px; width: 100%;min-width: 350px;">
                                        <p style="font-family: arial;font-size: 14px;font-weight: 400;  text-align: right; ">
                                            <b>Brandflaire.com</b>
                                        </p>
                                        <p style="margin-top: 0px; text-align: right;">
                                            @php
                                                $parts = explode(',', $company_address);
                                            @endphp
                                            @foreach($parts as $index => $part)
                                                {{ trim($part) }}@if($index < count($parts) - 1),@endif
                                                @if($index === 0 || $index === 2)
                                                    <br>
                                                @endif
                                            @endforeach    
                                        <br>
                                            @if(!empty($company_mobile))
                                                {{ $company_mobile }}<br>
                                            @endif

                                            @if(!empty($company_email))
                                                {{ $company_email }}
                                            @endif
                                        </p>
                                        
                                    </td>
                                </tr>
                            </table>
                            
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                <tr style="border-collapse: collapse;height: 30px; border-bottom: 0px;border: 0px; border-bottom: 1px solid black;">
                                    <td style="width: 600px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       <b>Item Name & Summary</b> 
                                    </td>
                                    <td style="width: 200px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>	Qty</b>
                                    </td>
                                    <td style="width: 200px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        <b>Price</b>
                                    </td>
                                    
                                </tr>
                                @foreach($products as $product)
                                 <tr style="border-collapse: collapse;height: 30px; border-bottom: 0px;border: 0px; border-bottom: 1px solid black;">
                                    <td style="width: 600px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                        {{ $product->name }}
                                    </td>
                                    <td style="width: 200px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        01
                                    </td>
                                    <td style="width: 200px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        {{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                                <tr style="border-collapse: collapse;height: 30px; border-bottom: 0px;border: 0px; ">
                                    <td style="width: 600px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       
                                    </td>
                                    <td style="width: 200px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border-bottom: 1px solid black;">
                                        Subtotal
                                    </td>
                                    <td style="width: 200px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px; border-bottom: 1px solid black;">
                                    {{ site_currency() }} {{ number_format($invoice_amount + $discount_amount, 2) }}
                                    </td>
                                    
                                </tr>
                                <tr style="border-collapse: collapse;height: 30px; border-bottom: 0px;border: 0px; ">
                                    <td style="width: 600px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       
                                    </td>
                                    <td style="width: 300px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>Total (Including Discount) </b>
                                    </td>
                                    <td style="width: 200px;text-align: right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        <b>{{ site_currency() }} {{ number_format($invoice_amount, 2) }}</b>
                                    </td>
                                    
                                </tr>
                                
                                
                            </table>
                        </td>
                    </tr>
                    <!-- Content End-->

                    <!-----------Footer----------->
                    <table class="footer_bottom" style="border-spacing: 0px;">

                    <tr >
                        <td style="height: 130px;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse; border-spacing: 0px;"> 
                                <tr style="background: url('{{ $invoice_image1 }}') no-repeat;background-position: center;background-size: cover;height: 80px;background-size:cover;width: 100%;text-align: center;">
                                    <td style="width: 150px;"> 
                                        <img src="{{ $invoice_image2 }}" alt="" style="height: 110px;padding-top: 10px;">
                                        
                                    </td> 
                                    
                                </tr>
                                <tr style="background: url('{{ $invoice_footer_image }}') no-repeat;background-position: center;background-size: cover;height: 50px;background-size:cover;width: 100%;text-align: center;">
                                    <td>
                                        <img src="{{ $company_logo  }}" alt="" style="height: 20px; ">
                                    </td>
                                </tr>              
                            </table>
                        </td>
                    </tr> 
                    </table>
                    <!-----------Footer End----------->

                </table>
            </td>
        </tr>
    </table>
</body>
</html>