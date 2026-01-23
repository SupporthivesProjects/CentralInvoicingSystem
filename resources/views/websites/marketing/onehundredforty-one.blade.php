<!DOCTYPE html>
<html>
    <head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table  style="border-collapse: collapse;border: 0px;background-color: white;background-color: #E9E3D3; ">
                    <!--Header-->
                    <tr style="background: url('{{ $invoice_header_image }}') no-repeat;background-position:center;background-size:contain; height: 145px;color: white;border-collapse: collapse;width: 600px;">
                        <td style="width: 600px;padding-left: 40px;padding-right: 40px;font-family: Arial, sans-serif;">
                           <table>
                                <tr>
                                    <td style="width: 300px;padding-left: 20px;">
                                        <b style="font-size: 24px;">INVIOCE</b>
                                        <div style="font-size: 8px;font-family: CenturyGothic, AppleGothic, sans-serif;display: flex;">
                                            <p style="padding-right: 20px;">{{ $company_name }}<br>{{ $company_email }}</p>
                                            <p style="padding-left: 10px;">{!! $company_address !!}<br> {{ $company_mobile }}</p>
                                        </div>
                                    </td>

                                    <td style="width: 300px;text-align: center;">
                                        <img src="{{ $company_logo }}" style="height: 60px;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                
        
                <!--Body-->
                
                    <tr style="width: 600px;">
                        <td style="padding: 40px;padding-bottom: 10px;">
                            <table style="border-collapse: collapse;">
                                <tr style="font-family: Arial, sans-serif;width: 600px;border-collapse: collapse;display: flex;font-size: 10px;">
                                    <td style="width: 200px;">
                                        <p style="margin: 0px;"><b>Billed To: </b><br>{{ $customer_name }}<br>{{ $customer_email }}</p>
                                    </td>

                                    <td style="width: 200px;text-align: right;">
                                        <b>Invoice #{{ $invoice_number }}</b>
                                    </td>

                                    <td style="width: 200px;text-align: right;">
                                        <b>Date: {{ $invoice_date }}</b>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 40px;padding-top: 30px;">
                            <table style="border-collapse: collapse;border: 4px solid orange;background-color: #F7F6F2;">
                                <tr style="border-collapse: collapse;height: 20px;background-color: #F4F4F4;border: 1px solid orange;font-family: Arial, sans-serif;">
                                    <td style="width: 300px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;border: 1px solid orange;padding-left: 20px;">
                                       <b>Product</b> 
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border: 1px solid orange;">
                                        <b>Duration</b>
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;border: 1px solid orange;">
                                        <b>QTY</b>
                                    </td>
                                    <td style="width:100px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border: 1px solid orange;padding-right: 20px; ">
                                        <b>Total</b>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                <tr style="border-collapse: collapse;height: 40px;background-color: #F4F4F4;border: 1px solid orange;font-family: Arial, sans-serif;">
                                    <td style="width: 300px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;border: 1px solid orange;padding-left: 20px;">
                                       <b style="color: black;">{{ $product->name }}</b><br><p style="color: orange;margin-top: 2px;margin-bottom: 1px;">Platinum</p>
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border: 1px solid orange;">
                                        <p>{{ $product->subscription ?? '-' }}</p>
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;border: 1px solid orange;">
                                        <p>1</p>
                                    </td>
                                    <td style="width:100px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;border: 1px solid orange;padding-right: 20px; ">
                                       <p>{{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</p>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="display: flex;justify-content: flex-end;padding-right: 40px;padding-bottom: 40px;">
                             <table style="border-collapse: collapse;border: 4px solid orange;background-color: #F7F6F2;">
                                <tr style="border-collapse: collapse;height: 20px;background-color: #F4F4F4;font-family: Arial, sans-serif;">
                                    <td style="width: 100px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;padding-left: 20px;">
                                       <p>Subtotal</p>
                                    </td>
                                    <td style="width: 100px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 20px;">
                                        <p>{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}</p>
                                    </td>
                                </tr> 
                                <tr style="border-collapse: collapse;height: 20px;background-color: #F4F4F4;font-family: Arial, sans-serif;">
                                    <td style="width: 100px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;padding-left: 20px;">
                                       <p>Discount</p>
                                    </td>
                                    <td style="width: 100px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 20px;">
                                        <p>{{ site_currency() }} {{ number_format($discount_amount ?? 0, 2) }}</p>
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 20px;background-color: orange;font-family: Arial, sans-serif;">
                                    <td style="width: 100px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;padding-left: 20px;">
                                       <b>Grand Total</b>
                                    </td>
                                    <td style="width: 100px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 20px;">
                                        <b>{{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}</b>
                                    </td>
                                </tr>   
                            </table>
                        </td>
                    </tr>

                    <!-----------Footer----------->
                    <tr>
                        <td style="height: 100px;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
                                <tr style="background: url() no-repeat;background-position: center;background-size: cover;height:113px;padding:50px;background-size:cover;width: 100%;">
                                    <td style="width: 150px;text-align: center;color: white;font-family: Arial, Helvetica, sans-serif;font-size: 10px;"> 
                                      
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