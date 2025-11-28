<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
    <style>
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
<body style="margin: 0px; padding: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#ffffff" style="padding: 0px 0;">
                <table width="100%" style="border-collapse: collapse;border: 0px; background-color: #8BB9DC;">
                    <tr><td colspan="2" style="height: 15px;"></td></tr>
                    <tr>
                        <td style="vertical-align: bottom; ">
                            <table style="width: 150px;min-height: 800px;background-color: white;margin-left: -1px;">
                                <tr style="width: 150px;">
                                    <td style="text-align: center;display: flex;justify-content: center;margin-top: -3px;">
                                        <img src="{{ $company_logo }}" style="height: 110px;">
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td style="display: flex; align-items: center;margin-left: -1px;">
                                        <img src="{{ $invoice_image2 }}" style="height: 230px;">
                                    </td>
                                </tr>
                                
                            </table>
                            
                        </td>
                        

                        <td style="vertical-align: top;background-color: #8BB9DC;padding-left: 20px;padding-right: 40px;">
                            <table width="100%" style="border-collapse: collapse;">
                                <tr>
                                    <td style="width: 225px;text-align: center;">
                                        <img src="{{ $invoice_image1 }}" style="height: 120px;">
                                    </td>
                                            <td  style=" width: 225px;text-align: right;font-family: 'Roboto', sans-serif;color: white;">
                                                <h1 style="font-size: 42px;margin: 0px;">INVOICE</h1>
                                                <p style="font-size: 10px;margin: 0px;">Invoice No :{{ $invoice_number }}</p>
                                            </td>

                                </tr>

                                <tr>
                                    <td colspan="2" style="font-family: 'Roboto', sans-serif;color: white;padding-top: 20px;">
                                                <h4 style="margin: 0px;font-size: 14px"> Invoice To</h4>
                                                <h2 style="margin: 0px;font-size: 26px">{{ $customer_name }}</h2>
                                            </td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="padding-top: 20px;">
                                        <table width="100%" style="border-collapse: collapse;">
                                            <tr style="color: white;">
                                                <td style="font-size: 8px;font-family: 'Roboto', sans-serif;">
                                                <!-- <p style="display: flex;align-items: center;margin-top: 0px;"> <img src="{{ $invoice_image3 }}" style="height: 15px;padding-right: 10px;">{{ $company_mobile }}</p> -->
                                                    <div class="" style="display:flex;flex-direction:row;justify-content:flex-start;align-items:center;">
                                                        <img src="{{ $invoice_image3 }}" style="height: 15px;padding-right: 10px;">
                                                        <p style="margin: 0px;"> {{ $company_email }}</p>
                                                    </div>
                                                </td>
                                                <td style="font-size: 8px;font-family: 'Roboto', sans-serif;padding-left: 10px;">
                                                    <div class="" style="display:flex;flex-direction:row;justify-content:flex-start;align-items:center;">
                                                        <img src="{{ $invoice_image4 }}" style="height: 15px;padding-right: 10px;">
                                                        <p style="margin-top: 0px;"> {!! $company_address !!}</p>
                                                    </div>
                                                </td>
                                                <td style="font-size: 8px;font-family: 'Roboto', sans-serif;padding-left: 10px;">
                                                <p> <b style="font-size: 10px;">Date :</b>{{ $invoice_date }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>

                                </tr>
                                
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;">
                                        <table width="100%" style="border-collapse: collapse; font-family: 'Roboto', sans-serif;">
                                            <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;background-color: #4B8EC6;color: white;">
                                                <td style="width: 200px;text-align: left;font-size: 6px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 10px;">
                                                    <b> ITEM DESCRIPTION</b>
                                                </td>
                                                <td style="width: 100px;text-align: center;font-size: 6px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                                    <b>UNIT PRICE</b>
                                                </td>
                                                <td style="width: 100px;text-align: center;font-size: 6px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                                    <b>QUANTITY</b>
                                                </td>
                                                <td style="width:100px;text-align:right;font-size: 6px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                                    <b>TOTAL</b>
                                                </td>
                                            </tr>
                                            @foreach($products as $product)
                                            <tr style="border-collapse: collapse;height: 30px;border-bottom: 0px;border: 0px;background-color: white;">
                                                <td style="width: 200px;text-align: left;font-size: 6px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 10px;">
                                                <b> {{ $product->name }}</b>
                                                </td>
                                                <td style="width: 100px;text-align: center;font-size: 6px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                                    {{ site_currency() }} {{ number_format($product->unit_price, 2) }}
                                                </td>
                                                <td style="width: 100px;text-align: center;font-size: 6px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                                1
                                                </td>
                                                
                                                <td style="width:100px;text-align:right;font-size: 6px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                                    {{ site_currency() }} {{ number_format($product->unit_price, 2) }}
                                                </td>
                                            </tr>
                                            @endforeach

                                
                                            <tr style="border-collapse: collapse;height: 20px;border-bottom: 0px;border: 0px;color: white;">
                                                <td style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 10px;">
                                                
                                                </td>
                                                <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                                
                                                </td>
                                                <td style="width: 100px;text-align: center;font-family: 'Roboto', sans-serif;font-size: 8px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                                <b>SUBTOTAL</b>
                                                </td>
                                                
                                                <td style="width:100px;text-align:right;font-family: 'Roboto', sans-serif;font-size: 8px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                                <b> {{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</b>
                                                </td>
                                            </tr>


                                            <tr style="border-collapse: collapse;height: 20px;border-bottom: 0px;border: 0px;color: white;">
                                                <td style="width: 200px;text-align: left;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 10px;">
                                                
                                                </td>
                                                <td style="width: 100px;text-align: center;font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                                
                                                </td>
                                                <td style="width: 100px;text-align: center;font-family: 'Roboto', sans-serif;font-size: 8px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 4px;">
                                                <b>DISCOUNT</b>
                                                </td>
                                                
                                                <td style="width:100px;text-align:right;font-family: 'Roboto', sans-serif;font-size: 8px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 10px;">
                                                <b> {{ site_currency() }} {{ number_format($discount_amount, 2) }}</b>
                                                </td>
                                            </tr>

                                        </table>
                                    </td>

                                </tr>

                                <tr>
                                    <td colspan="" style="padding-top: 20px;">
                                        <p style="text-align: left;font-family: 'Roboto', sans-serif;font-size: 16px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 10px;color: white;">
                                            TOTAL
                                        </p>
                                        <p style="text-align: left;font-family: 'Roboto', sans-serif;font-size: 30px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 10px;color: white;">
                                            {{ site_currency() }} {{  number_format($invoice_amount, 2) }}
                                        </p>
                                        <p style="text-align: left;font-family: 'Roboto', sans-serif;font-size: 8px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 10px;color: white;padding-top: 5px;">
                                            ONLINE PAYMENT
                                        </p>
                                        <p style="text-align: left;font-family: 'Roboto', sans-serif;font-size: 8px;margin: 0px; border-collapse: collapse;padding-left: 10px;color: white;">
                                            Visa, Mastercard, PayPal, Western Union  
                                        </p>
                                    </td>
                                    <td style="padding-top: 60px;">
                                        <p style="text-align: right;font-family: 'Roboto', sans-serif;font-size: 8px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 10px;color: white;">
                                            BANK TRANSFER
                                        </p>
                                        <p style="text-align: right;font-family: 'Roboto', sans-serif;font-size: 8px;margin: 0px; border-collapse: collapse;padding-left: 10px;color: white;">
                                            BANK NAME
                                        </p>
                                        <p style="text-align: right;font-family: 'Roboto', sans-serif;font-size: 8px;margin: 0px; border-collapse: collapse;padding-left: 10px;color: white;">
                                            SWIFT Code
                                        </p>
                                        <p style="text-align: right;font-family: 'Roboto', sans-serif;font-size: 8px;margin: 0px; border-collapse: collapse;padding-left: 10px;color: white;">
                                            Bank Account No.
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div style="width: 100%;height: 3px;background-color: #4B8EC6;margin-top: 20px;"></div>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2">
                            <table class="footer-fixed" width="100%" cellspacing="0" cellpadding="0px" border="0px" style="border-collapse: collapse;"> 
                                <tr style="height: 100px;border-collapse: collapse;background-color: #8BB9DC;font-family: 'Roboto', sans-serif;font-size: 9px; color: white;">
                                    <td style="border:0px;padding: 10px;" > 
                                        <div class="" style="display:flex;flex-direction:row;justify-content:flex-start;align-items:center;">
                                            <img src="{{ $invoice_image5 }}" style="height: 20px;padding-right: 10px;">
                                            <p style="display: flex; align-items: center;">www.yourhealthfromhome.com</p>
                                        </div>
                                        <div class="" style="display:flex;flex-direction:row;justify-content:flex-start;align-items:center;">
                                            <img src="{{ $invoice_image3 }}" style="height: 20px;padding-right: 10px;"> 
                                            <p style="display: flex; align-items: center;">{{ $company_email }}</p>
                                        </div>
                                    </td>
                                    <td style="text-align: right;padding: 10px;">
                                        <div class="" style="display:flex;flex-direction:row;justify-content:flex-start;align-items:center;">
                                            <p style="display: flex; align-items: center;">
                                                {!! $company_address !!}
                                            </p>
                                            <img src="{{ $invoice_image4 }}" style="height: 20px;padding-left: 10px;">
                                        </div>
                                    </td>          
                                </tr>
                                              
                            </table>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>