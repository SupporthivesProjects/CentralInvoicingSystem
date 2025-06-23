<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body, table, td {
            background-color: transparent !important;
        }
        table td {
            padding-top: 7px !important;
            padding-bottom: 7px !important;
        }
        .invoice_header_image{
            background-image: url('{{ $invoice_header_image }}') !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
            background-size: cover !important;
            width: 100% !important;
            height: 942px !important; 
        }
    </style>
</head>
<body>
<table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f2f2f2; padding: 20px 0;">
    <tr>
        <td align="center" >
            <table  class="invoice_header_image" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); max-width: 100%; width: 100%;">
                <tr>
                    <td  style="padding:40px;">
                            <table   width="100%" style="margin-top:80px !important;">
                                <tr>
                                    <td style="width: 290px;">
                                        <p style="font-family: arial;font-size: 10px;margin-bottom: 5px;font-weight: 700;">
                                             BILLED FROM:
                                        </p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            {{ $site->company_name }} <br>
                                            {{ $site_name }}
                                           
                                        </p>
                                        
                                        <p style="font-family: arial;font-size: 10px;margin-bottom: 5px;font-weight: 400;">
                                            {{ $site->site_link}}
                                        </p>
                                    </td>
                                    <td style="width:300px; padding: 40px;padding-top: 15px;padding-right: 0px;padding-bottom: 0px;text-align: right;">
                                        <h1 style="font-family: arial;font-size: 20px;margin: 0px;font-weight: 700;">INVOICE</h1>
                                         <p style="font-family: arial;font-size:10px;margin-bottom: 5px;font-weight: 400;">
                                           <b> INVOICE DATE: {{ $invoice_date }}</b>
                                        </p>
                                         <p style="font-family: arial;font-size:10px;margin: 0px;font-weight: 400;">
                                            <b>Invoice No: {{ $invoice_number}}</b> 
                                        </p><br><br><br>
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
                            
                            
                            <table width="100%" style="min-height: 500px;border-collapse: collapse; border: 0; table-layout: fixed; width: 100%;">
                            <tr style="height: 30px; border-collapse: collapse;">
                                <td style="width: 200px; text-align: left; font-family: arial; font-size: 10px; font-weight: 400; padding-left: 5px; border-bottom: 1px solid black;">
                                    <b>Quantity</b> 
                                </td>
                                <td style="width: 1000px; text-align: left; font-family: arial; font-size: 10px; font-weight: 400; padding-left: 5px; border-bottom: 1px solid black;">
                                    <b>Product</b>
                                </td>
                                <td style="width: 300px; text-align: left; font-family: arial; font-size: 10px; font-weight: 400; padding-left: 5px; border-bottom: 1px solid black;">
                                    <b>Price</b>
                                </td>
                                <td style="width: 200px; text-align: left; font-family: arial; font-size: 10px; font-weight: 400; padding-left: 5px; border-bottom: 1px solid black;">
                                    <b>Amount</b>
                                </td>
                            </tr>

                                @foreach($products as $product)
                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 2px;border-left: 1px solid black;">
                                      1
                                    </td>
                                    <td style="width: 1000px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-left: 1px solid black;">
                                     {{ $product->name }}
                                    </td>
                                    <td style="width:300px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;border-left: 1px solid black;">
                                   {{ site_currency() }} {{  number_format($product->unit_price, 2) }}
                                    </td>
                                    <td style="width:200px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border-left: 1px solid black;border-right: 1px solid black;">
                                    {{ site_currency() }} {{  number_format($product->unit_price, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                                <tr style="height: 30px; border-collapse: collapse;border-top: 1;border: 1;">
                                    <td style="width: 100px; text-align: left; font-family: arial; font-size: 10px; font-weight: 400; border-top: 1px solid black;">
                                    </td>
                                    <td style="width: 300px; text-align: left; font-family: arial; font-size: 10px; font-weight: 400; border-top: 1px solid black;">
                                    </td>
                                    <td style="width: 100px; text-align: right; font-family: arial; font-size: 10px; font-weight: 400; padding-right: 10px; border-top: 1px solid black;">
                                        <b>Subtotal</b>
                                    </td>
                                    <td style="width: 100px; text-align: left; font-family: arial; font-size: 10px; font-weight: 400; border: 1px solid black; border-top: 1px solid black;">
                                    {{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}
                                    </td>
                                </tr>

                                <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                      
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                       <b> Discount</b>
                                    </td>
                                    <td style="width:100px;text-align:left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;border: 1px solid black;">
                                    {{ site_currency() }} {{ number_format($discount_amount, 2) }}
                                    </td>
                                 <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;">
                                    <td style="width: 100px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                      
                                    </td>
                                    <td style="width: 300px;text-align:left;font-family: arial;font-size:10px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:right;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                       <b> Total Due</b>
                                    </td>
                                    <td style="width: 100px; text-align: left; font-family: arial; font-size: 10px; margin: 0px; font-weight: 400; border-collapse: collapse; border: 1px solid black !important;">
                                        {{ site_currency() }} {{ number_format($invoice_amount, 2) }}
                                    </td>

                                </tr>
                                <br><br>
                            </table>

                            <table width="100%" cellspacing="0" cellpadding="" border="0" style="border-collapse: collapse;width:100%;"> 
                                <tr >
                                    <td style="text-align:center;padding-top: 0px;"> 
                                        <p style="text-align: center;font-family: arial;font-size: 12px;margin: 0px;padding-bottom: 0px;">
                                            <b>Thank You</b><br>For questions concerning this invoice, please contact
                                        </p>
                                    </td>          
                                </tr>
                                <tr>              
                            </table>

                            <table width="100%" cellspacing="0" cellpadding="" border="0" style="border-collapse: collapse;width:100%;"> 
                            <tr>
                                <td style="width: 150px; text-align: center; vertical-align: middle;">
                                    <div style="display: flex; align-items: center; justify-content: center; gap: 5px;">
                                        <img src="{{ $invoice_image1 }}" alt="" style="height: 10px;">
                                        <span style="font-family: arial; font-size: 10px;">{!! $company_mobile ?? '' !!}</span>
                                    </div>
                                </td>
                                <td style="width: 200px; text-align: center; vertical-align: middle;">
                                    <div style="display: flex; align-items: center; justify-content: center; gap: 5px;">
                                        <img src="{{ $invoice_image2 }}" alt="" style="height: 10px;">
                                        <span style="font-family: arial; font-size: 10px;">{{ $company_email }}</span>
                                    </div>
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                        <div style="display: flex; align-items: center; justify-content: center; gap: 5px; margin-bottom: 3px;">
                                            <img src="{{ $invoice_image3 }}" alt="" style="height: 10px;">
                                            <span style="font-family: arial; font-size: 10px;">{!! $company_name ?? '' !!}</span>
                                        </div>
                                        <span style="font-family: arial; font-size: 10px; text-align: left;">
                                            {!! $company_address ?? '' !!}<br>
                                            Trading No.{{ $site->site_description ?? '' }}
                                        </span>
                                    </div>
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