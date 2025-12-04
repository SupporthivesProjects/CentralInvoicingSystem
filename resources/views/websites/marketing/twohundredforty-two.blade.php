<!DOCTYPE html>
<html>

<head>
    <title>Thedigitaldrifter</title>
</head>

<body style="margin: 0px;padding: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
                <table width="650" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border: 15px solid #D95D27;background: #D95D27; height: 100%">
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;border-radius: 18px;background-color: #ffffff;">
                                <!-- Header -->
                                <tr>
                                    <td style="height: 165px;">
                                        <div style="display: flex;flex-direction: column;justify-content: center;align-items: center;gap: 15px;">
                                            <img src="{{ $company_logo }}" alt="" style="width: 180px;">
                                            <img src="{{ $invoice_image1 }}" alt="" style="width: 250px;">
                                        </div>
                                    </td>
                                </tr>
                                <!-- Header End -->


                                <!-- Content -->
                                <tr>

                                    <td style="font-family: 'Montserrat'; font-size: 9px; vertical-align: top; height: 320px;">

                                        <table width="100%" cellpadding="1" style="padding:40px 80px; padding-bottom: 0%; ">
                                            <tr>
                                                <td style="width:20%; vertical-align:top; color:#000;">
                                                    <p style="margin:0;margin-top: 10px; font-size:14px; text-transform: capitalize;">Invoice To :</p>
                                                    <p style="margin:0; margin-top: 10px; font-size:12px; text-transform: capitalize;">Invoice Date <span style="padding-left: 12px;">:</span></p>
                                                    <p style="margin:0; margin-top: 10px; font-size:12px; text-transform: capitalize;">Invoice No<span style="padding-left: 19px;">:</span></p>
                                                </td>

                                                <td style="width:80%; vertical-align:top; color:#000;">
                                                    <p style="margin: 0%;margin-top: 10px; font-size: 14px; font-weight:bold;">{{ $customer_name ? $customer_name : '' }}</p>
                                                    <p style="margin:0%; margin-top: 10px; font-size: 12px;">{{ $invoice_date }}</p>
                                                    <p style="margin:0; margin-top: 10px;font-size: 12px;">{{ $invoice_number }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                        
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td colspan="4" 

                                        style="color:white; padding:30px; vertical-align: top; height:90px">

                                        <table width="100%" cellpadding="8" style="color:white; background: #3E3E48; border-top: 15px solid #3E3E48;border-left: 25px solid #3E3E48;border-right: 25px solid #3E3E48;border-bottom: 15px solid #3E3E48;border-radius: 15px;">
                                            <tr>
                                                <td style="padding: 0px;">
                                                    <table width="100%" cellpadding="8" style="color:white;border-collapse: collapse;padding: 0px;">
                                                        <tr style="font-weight:bold; text-transform:uppercase; font-size:14px;">
                                                            <td style="padding:18px 18px 25px 18px; border-bottom:1px solid white;">Item Description</td>
                                                            <td style="padding:18px 18px 25px 18px; border-bottom:1px solid white; text-align:center;">Unit Price</td>
                                                            <td style="padding:18px 18px 25px 18px; border-bottom:1px solid white; text-align:center;">Qty</td>
                                                            <td style="padding:18px 18px 25px 18px; border-bottom:1px solid white; text-align:center;">Total</td>
                                                        </tr>

                                                        @foreach($products as $product)
                                                        <tr style="font-size:12px;">
                                                            <td style="padding:25px 18px 18px 18px;">{{ $product->name }}</td>
                                                            <td style="padding:25px 18px 18px 18px; text-align:center;">{{ site_currency() . number_format($product->unit_price ?? 0, 2) }}</td>
                                                            <td style="padding:25px 18px 18px 18px; text-align:center;">2</td>
                                                            <td style="padding:25px 18px 18px 18px; text-align:center;">{{ site_currency() . number_format($invoice_amount ?? 0, 2) }}</td>
                                                        </tr>
                                                        @endforeach
                                                    
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                            <td colspan="4" style="border-top:1px solid white;padding: 0px;"></td>
                                                        </tr>
                                            <tr>
                                                <td style="padding: 10px 0px; border-bottom: 1px solid white;">


                                                    <table style="width:100%; font-family:'Montserrat'; color:#fff; border-collapse:collapse;">
                                                        
                                                        <tr style="font-size:12px;">
                                                            <td style="padding:10px 0 10px 20px; text-transform:uppercase;">Subtotal</td>
                                                            <td style="padding:10px 0 10px 20px; text-align:left;">{{ site_currency() . number_format($invoice_amount + $discount_amount ?? 0, 2) }}</td>
                                                            <td rowspan="2" style="padding: 0; text-transform:uppercase; text-align:center;">
                                                                <table style="border-collapse: collapse; width: 100%;border-collapse: collapse;">
                                                                    <tr>
                                                                        <td style="padding: 0; text-transform:uppercase; text-align:center;">
                                                                            Grand Total
                                                                        </td>
                                                                        <td style="padding:15px 0px; text-align:left; color:#ff5722; font-size:20px;">
                                                                            {{ site_currency() . number_format($invoice_amount ?? 0, 2) }}
                                                                        </td>
                                                                    </tr>
                                                                    
                                                                    
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr style="font-size:12px;">
                                                            <td style="padding:10px 0 10px 20px; text-transform:uppercase;">Discount</td>
                                                            <td style="padding:10px 0 10px 20px; text-align:left;">{{ site_currency() . number_format($discount_amount ?? 0, 2) }}</td>
                                                        </tr>

                                                    </table>




                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="padding:20px 0 20px 0px;">
                                                    <table style="width: 100%; border-collapse: collapse; font-family: 'Montserrat'; color:#fff;">
                                                        <tr>
                                                            <td rowspan="2" style="width:50%;padding-left: 20px;">
                                                                <p style="font-size:14px;  margin:0;">THANK YOU</p>
                                                            </td>
                                                            <td>
                                                                <div style="display: flex;flex-direction: row;justify-content: left;align-items: center; gap: 16px;">
                                                                    <svg style="width: 15px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#D95D27" d="M48 64c-26.5 0-48 21.5-48 48 0 15.1 7.1 29.3 19.2 38.4l208 156c17.1 12.8 40.5 12.8 57.6 0l208-156c12.1-9.1 19.2-23.3 19.2-38.4 0-26.5-21.5-48-48-48L48 64zM0 196L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-188-198.4 148.8c-34.1 25.6-81.1 25.6-115.2 0L0 196z"/></svg>
                                                                    <p style="font-size: 12px;">
                                                                        {{ $company_email }}
                                                                    </p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div style="display: flex;flex-direction: row;justify-content: left;align-items: center; gap: 16px;">
                                                                    <svg style="width: 15px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="#D95D27" d="M0 188.6C0 84.4 86 0 192 0S384 84.4 384 188.6c0 119.3-120.2 262.3-170.4 316.8-11.8 12.8-31.5 12.8-43.3 0-50.2-54.5-170.4-197.5-170.4-316.8zM192 256a64 64 0 1 0 0-128 64 64 0 1 0 0 128z"/></svg>
                                                                    <p style="font-size: 12px;">
                                                                        {!! $company_address !!}
                                                                    </p>
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
                        </td>
                    </tr>
                    

                </table>
            </td>
        </tr>
    </table>
</body>

</html>