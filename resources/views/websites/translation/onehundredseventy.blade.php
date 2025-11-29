<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding:0px;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse;">
                    <!-- Header -->
                   <tr style="padding:0px;">
                        <td style="background: url('{{ $invoice_image1 }}') no-repeat;background-position:center;background-size:100% 100%;padding:0px;height: 410px;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;border-collapse: collapse;"> 
                                <tr>
                                    <!-- <td style="width:50%;border:0px;margin-top: -30px;" > 
                                        <img src="{{ $company_logo }}" alt="" style="height: 60px; justify-content: left;padding-left: 20px;">
                                        </td>
                                       
                                        <td style="width:50%;border:0px;margin-top: -70px;">
                                            <h1 style=" text-align: right;padding-right: 70px;font-family: 'Roboto', sans-serif;font-size: 58px;margin: 0px;">
                                                INVOICE
                                            </h1>
                                        </td> -->
                                        <td style="width:50%; border:0px;">
                                            <div style="margin-top:-40px;">
                                                <img src="{{ $company_logo }}" style="height:60px; padding-left:20px;">
                                            </div>
                                        </td>

                                        <td style="width:50%; border:0px;">
                                            <div style="margin-top:-40px; text-align:right; padding-right:70px;">
                                                <h1 style="font-size:58px; margin:0;">INVOICE</h1>
                                            </div>
                                        </td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td style="width: 400px;"></td>
                                    <td  style="width: 300px; text-align: right;font-family:  'Roboto', sans-serif;font-size: 9px;">Invoice No. :</td>
                                    <td style="padding-right: 40px;width: 300px;text-align: right;font-family:  'Roboto', sans-serif;font-size: 9px;">Invoice Date :</td>
                                </tr>
                                <tr >
                                    <td style="width: 400px;"></td>
                                    <td  style="width: 300px; text-align: right;font-family:  'Roboto', sans-serif;font-size: 9px;">#{{ $invoice_number }}</td>
                                    <td style="padding-right: 40px;width: 300px;text-align: right;font-family:  'Roboto', sans-serif;font-size: 9px;">{{ $invoice_date }}</td>
                                </tr>
                            </table>
                            <table>
                                <tr style="color: white;font-family:  'Roboto', sans-serif;">
                                    <td style="width:50%;padding-left: 40px;font-size: 12px;padding-top: 15px;">
                                        Billed From:
                                    </td>
                                    <td style="width:50%;text-align: right;padding-right: 40px;font-size: 12px;padding-top: 40px;" align="right">Invoice To:</td>
                                </tr>
                                <tr style="color: white;font-family:  'Roboto', sans-serif;">
                                    <td style="padding-left: 40px;width:50%;vertical-align: middle;padding-top: 10px;">
                                        <p style="font-size: 10px;margin: 0px;">
                                            <img src="{{ $invoice_image2 }}" style="height: 20px;padding-right: 5px;vertical-align: middle;">
                                            {!! $company_address !!}<br>{{ $company_mobile }}</p>
                                    </td>
                                    <td style="width:50%;text-align: right;padding-right: 40px;font-size: 20px;vertical-align: middle;padding-top: 10px;" align="right">{{ $customer_name }}<br>
                                        {{ $customer_email }}<br></td>
                                </tr>
                                <tr style="color: white;font-family:  'Roboto', sans-serif;">
                                    <td style="padding-left: 40px;vertical-align: middle;padding-top: 5px;">
                                        <p style="font-size: 10px;margin: 0px;">
                                            <img src="{{ $invoice_image3 }}" style="height: 20px;padding-right: 5px;vertical-align: middle;">
                                            {{ $company_email }}</p>
                                    </td>
                                    <td style="width:50%;vertical-align: middle;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                     <!-- Content -->
                    <tr>
                        <td style="padding:40px;padding-top:0px;">
                            
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                <tr style="border-collapse: collapse;height: 50px;background-color: blue;color: white;border: 1px solid white;font-family:  'Roboto', sans-serif;">
                                    <td style="padding-left: 2px; width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 600;border-collapse: collapse;padding-left: 5px;background-color: orange;color: black;border: 1px solid white;">
                                       <b>NO</b> 
                                    </td>
                                    <td style="padding-left: 2px; width: 300px;text-align: left;font-size: 10px;margin: 0px;font-weight: 600;border-collapse: collapse;padding-left: 5px;border: 1px solid white;">
                                       <b>ITEM Descriptions</b> 
                                    </td>
                                    <td style="width: 200px;text-align: center;font-size: 10px;margin: 0px;font-weight: 600;border-collapse: collapse;border: 1px solid white;">
                                        <b>UNIT PRICE</b>
                                    </td>
                                    <td style="width: 200px;text-align: center;font-size: 10px;margin: 0px;font-weight: 600; border-collapse: collapse;padding-left: 5px;border: 1px solid white;">
                                        <b>QTY</b>
                                    </td>
                                    <td style="padding-right: 10px; width: 200px;text-align:center;font-size: 10px;margin: 0px;font-weight: 600;border-collapse: collapse;border: 1px solid white;">
                                        <b>TOTAL</b>
                                    </td>
                                </tr>
                                @foreach($products as $index => $product)
                                <tr style="border-collapse: collapse;height: 50px;border-bottom: 0px;border: 0px;border-bottom: 1px solid black;background-color: #F4F4F4;border: 1px solid white;font-family:  'Roboto', sans-serif;">
                                    <td style=" padding-left: 2px; width: 100px;text-align: center;font-size: 11px;margin: 0px; border-collapse: collapse;padding-left: 4px;border: 1px solid white;">
                                     <b >{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</b>
                                    </td>
                                    <td style="width: 300px;text-align:left;font-size:8px;margin: 0px; border-collapse: collapse;border: 1px solid white;padding-left: 10px;">
                                        <b style="font-size: 10px;">{{ $product->name }}</b><br>
                                        from {{ $product->from_language }} to {{ $product->to_language }}.
                                    </td>
                                    <td style="width:200px;text-align:center;font-size: 10px;margin: 0px; border-collapse: collapse;padding-left: 5px;border: 1px solid white;">
                                        {{ site_currency() . number_format($product->unit_price, 2) }}
                                    </td>
                                    <td style="width:100px;text-align:center;font-size: 10px;margin: 0px; border-collapse: collapse;padding-left: 5px;border: 1px solid white;">
                                        {{ $product->pages }} {{ $product->unit_type }}
                                    </td>
                                    <td style="padding-right: 10px; width:100px;text-align:center;font-size: 10px;margin: 0px; border-collapse: collapse;border: 1px solid white;">
                                        {{ site_currency() . number_format($product->line_total,2) }}
                                    </td>
                                </tr>
                                @endforeach

                                
                                <tr style="border-collapse: collapse;height: 20px;border-bottom: 0px;border: 0px;border-bottom: 1px solid black;font-family:  'Roboto', sans-serif;">
                                    <td style=" padding-left: 2px; width: 100px;text-align: center;font-size: 11px;margin: 0px; border-collapse: collapse;padding-left: 4px;border: 1px solid white;">
                                     <b ></b>
                                    </td>
                                    <td style="width: 300px;text-align:left;font-size:8px;margin: 0px; border-collapse: collapse;border: 1px solid white;padding-left: 10px;">
                                        <b style="font-size: 10px;"></b><br>
                                    </td>
                                    <td style="width:200px;text-align:center;font-size: 10px;margin: 0px; border-collapse: collapse;padding-left: 5px;border: 1px solid white;">
                                        
                                    </td>
                                    <td style="width:100px;text-align:center;font-size: 10px;margin: 0px; border-collapse: collapse;padding-left: 5px;border: 1px solid white;">
                                    
                                    </td>
                                    <td style="padding-right: 10px; width:100px;text-align:center;font-size: 10px;margin: 0px; border-collapse: collapse;border: 1px solid white;">
                                      	
                                    </td>
                                </tr>

                                <tr style="font-family:  'Roboto', sans-serif;font-size: 10px;color: white;height: 40px;">
                                    <td ></td>
                                    <td ></td>
                                    <td ></td>
                                    <td style="text-align: center;background-color: blue; ">SUB TOTAL :</td>
                                    <td style="text-align: center; background-color: blue;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                </tr>

                                <tr style="font-family:  'Roboto', sans-serif;font-size: 10px;color: white;height: 40px;">
                                    <td ></td>
                                    <td ></td>
                                    <td ></td>
                                    <td style="text-align: center;background-color: blue; ">DISCOUNT :</td>
                                    <td style="text-align: center; background-color: blue;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                </tr>

                                <tr style="font-family:  'Roboto', sans-serif;font-size: 15px;height: 40px;">
                                    <td ></td>
                                    <td ></td>
                                    <td ></td>
                                    <td style="text-align: center;background-color: orange; ">TOTAL |</td>
                                    <td style="text-align: center; background-color: orange;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                </tr>
                                 
                                <br><br>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End-->

                    <!-----------Footer----------->
                    
                    <!-----------Footer End----------->

                </table>
            </td>
        </tr>
    </table>
</body>
</html>