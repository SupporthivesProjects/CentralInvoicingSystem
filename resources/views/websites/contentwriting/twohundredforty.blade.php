<!DOCTYPE html>
<html>
<head>
    <title>Your Email Title</title>
    <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400;700;800&display=swap" rel="stylesheet">

</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;max-height: 130px;">
                            <table>
                                <tr>
                                    <td style="height: 122px; background: url({{ $invoice_header_image }}) no-repeat;background-position:center;background-size:cover;width: 600px;text-align: center;">
                                         <img src="{{ $company_logo }}" style=" height: 60px;">
                                    </td>
                                    
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                     <!-- Content -->
                    <tr style=" background: url{{ $invoice_footer_image }}) no-repeat;background-position:center;background-size:cover; height: 100%;width: 100%;">
                        <td style="padding:60px;padding-top:20px;padding-bottom: 20px;">
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                <tr >
                                    <td style="padding-top: 10px;width: 600px;">
                                        <p style="font-family: 'Sen', sans-serif;font-size: 24px;margin: 0px; text-align: center;padding-bottom: 10px;">
                                            <b>Invoice #. [0000]</b>
                                        </p>
                                    </td>
                                </tr>
                            </table>

                                <table style="border-bottom: 1px solid black;border-top: 1px solid black;">
                                <tr>
                                   <td style="font-family: 'Sen', sans-serif;text-align: center;font-size: 11px;width: 300px;">
                                        <b>Purchase Date:</b>
                                    </td>
                                    <td style="font-family: 'Sen', sans-serif;text-align: center;font-size: 11px;width: 300px;">
                                        <b>Billed To</b>
                                    </td>
                                </tr>
                                <tr>
                                   <td style="font-family: 'Sen', sans-serif;text-align: center;font-size: 11px;">
                                        01/01/2025
                                    </td>
                                    <td style="font-family: 'Sen', sans-serif;text-align: center;font-size: 11px;">
                                        (Name Here)
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                <tr style="border-collapse: collapse;height: 30px;background-color: darkblue;font-family: 'Sen', sans-serif; color: white;border-bottom: 1px solid black;">
                                    <td style="width: 50px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       <b>QTY</b> 
                                    </td>
                                    <td style="width: 200px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>DESCRIPTION</b>
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        <b>QUALITY</b>
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>TURNAROUND</b>
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        <b>IMAGERY</b>
                                    </td>
                                    <td style="width:580px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        <b>BILLING CYCLE</b>
                                    </td>
                                    <td style="width:100px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        <b>Total</b>
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 30px;font-family: 'Sen', sans-serif; color: gray;border-bottom: 1px solid black;">
                                    <td style="width: 50px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       1
                                    </td>
                                    <td style="width: 200px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        Creative Writing / E-Book Writing
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        Premium
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        5 Days
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        0
                                    </td>
                                    <td style="width:580px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        $10.00
                                    </td>
                                    <td style="width:100px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        $10.00
                                    </td>
                                </tr>
                              <tr style="border-collapse: collapse;height: 30px;font-family: 'Sen', sans-serif; color: gray;background-color: lightgrey;border-bottom: 1px solid black;">
                                    <td style="width: 50px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       1
                                    </td>
                                    <td style="width: 200px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        Creative Writing / E-Book Writing
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        Premium
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        5 Days
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        0
                                    </td>
                                    <td style="width:580px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        $10.00
                                    </td>
                                    <td style="width:100px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        $10.00
                                    </td>
                                </tr>
                               <tr style="border-collapse: collapse;height: 30px;font-family: 'Sen', sans-serif; color: gray;border-bottom: 1px solid black;">
                                    <td style="width: 50px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       1
                                    </td>
                                    <td style="width: 200px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        Creative Writing / E-Book Writing
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        Premium
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        5 Days
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        0
                                    </td>
                                    <td style="width:580px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        $10.00
                                    </td>
                                    <td style="width:100px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        $10.00
                                    </td>
                                </tr>
                               <tr style="border-collapse: collapse;height: 30px;font-family: 'Sen', sans-serif; color: gray;background-color: lightgrey;border-bottom: 1px solid black;">
                                    <td style="width: 50px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       1
                                    </td>
                                    <td style="width: 200px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        Creative Writing / E-Book Writing
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        Premium
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        5 Days
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        0
                                    </td>
                                    <td style="width:580px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        $10.00
                                    </td>
                                    <td style="width:100px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        $10.00
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 30px;font-family: 'Sen', sans-serif; color: gray;border-bottom: 1px solid black;">
                                    <td style="width: 50px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       1
                                    </td>
                                    <td style="width: 200px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        Creative Writing / E-Book Writing
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        Premium
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        5 Days
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        0
                                    </td>
                                    <td style="width:580px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        $10.00
                                    </td>
                                    <td style="width:100px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        $10.00
                                    </td>
                                </tr>
                               <tr style="border-collapse: collapse;height: 30px;font-family: 'Sen', sans-serif; color: gray;background-color: lightgrey;border-bottom: 1px solid black;">
                                    <td style="width: 50px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       1
                                    </td>
                                    <td style="width: 200px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        Creative Writing / E-Book Writing
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        Premium
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        5 Days
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        0
                                    </td>
                                    <td style="width:580px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        $10.00
                                    </td>
                                    <td style="width:100px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        $10.00
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 30px;font-family: 'Sen', sans-serif; color: gray;border-bottom: 1px solid black;">
                                    <td style="width: 50px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       1
                                    </td>
                                    <td style="width: 200px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        Creative Writing / E-Book Writing
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        Premium
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        5 Days
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        0
                                    </td>
                                    <td style="width:580px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        $10.00
                                    </td>
                                    <td style="width:100px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        $10.00
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 30px;font-family: 'Sen', sans-serif; color: gray;">
                                    <td style="width: 50px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                    
                                    </td>
                                    <td style="width: 200px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        
                                    </td>
                                    <td style="width:580px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;background-color: lightgrey;">
                                        Item total
                                    </td>
                                    <td style="width:100px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;background-color: lightgrey;">
                                        $10.00
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 30px;font-family: 'Sen', sans-serif; color: gray;">
                                    <td style="width: 50px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                    
                                    </td>
                                    <td style="width: 200px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        
                                    </td>
                                    <td style="width:580px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        Coupon Used
                                    </td>
                                    <td style="width:100px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        $10.00
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 30px;font-family: 'Sen', sans-serif; color: gray;">
                                    <td style="width: 50px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                    
                                    </td>
                                    <td style="width: 200px;text-align: left;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width: 100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        
                                    </td>
                                    <td style="width:100px;text-align: center;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;">
                                        
                                    </td>
                                    <td style="width:580px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;color: #172355;background-color: lightgrey;">
                                        TOTAL
                                    </td>
                                    <td style="width:100px;text-align: right;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px;background-color: lightgrey;color: #172355;">
                                        $10.00
                                    </td>
                                </tr>
                               
                            </table>
                            <br>
                            <table>
                                <tr>
                        <td style="height: 100px;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;"> 
                                <tr style="height:200px;width: 600px;">
                                    <td style="text-align: left;width: 200px;"> 
                                     <img src="{{ $invoice_image1 }}" style="height: 130px;">
                                    </td>
                                    <td style="text-align: center;width: 220px;font-size: 10px;display: flow-root;font-family: 'Sen', sans-serif;">
                                        <p><b style="color: #172355;">TEL:</b> +44 123 456 789</p>
                                        <p><b style="color: #172355;">EMAIL:</b> Contact@scriptera.com</p>
                                        <p><b style="color: #172355;">ADDRESS:</b> Insert Full Address Detail<br>Here City, State, Zip Code</p>
                                    </td > 
                                       <td style="text-align: right;width: 200px;">
                                        <img src="{{ $invoice_image2 }}" style="height: 130px;">
                                       </td>   
                                </tr>
                                <tr>              
                            </table>
                        </td>
                    </tr>
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