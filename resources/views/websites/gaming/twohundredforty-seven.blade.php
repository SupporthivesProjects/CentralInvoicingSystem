<!DOCTYPE html>
<html>

<head>
    
    <title>Invoice</title>

    <style>
        h1,h2,h3,h4,h5,h6,p {
            margin: 0px;
        }
        .mainT tr {
            border-bottom: 1px solid #4B4A52;
        }
        .mainT tr:first-child {
            border-bottom: 0px;
        }
        .mainT tr:last-child {
            border-bottom: 1px solid #D83E71;
        }
    </style>
</head>

<body style="margin:0; padding:0; background:red; width:100%; font-family: Arial, Helvetica, sans-serif;">

    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:0; margin:0; border-collapse:collapse;">
        <tr>
            <td align="center">

                <!-- Main Wrapper -->
                <table width="100%" cellpadding="0" cellspacing="0"
                    style="color:#ffffff; border-collapse:collapse;background: linear-gradient(to right, #0D022C 50%, #1B0C57 50%);">

                    <!-- HEADER -->
                    <tr>
                        <td style="padding:30px 0px 0px 30px;">
                            <table width="100%">
                                <tr>
                                    <td width="50%">
                                        <div style="display: flex;flex-direction: column;justify-content: space-between;align-items: flex-start;gap: 40px;position: relative;height: 295px;">
                                            
                                            <img src="{{ $company_logo }}" width="150" style="display:block;">
                                            <!-- <div style="display: flex;flex-direction: column;justify-content: flex-start;align-items: flex-start;gap: 30px;"> -->
                                                <div style="background:#D83E71;border-radius:20px;padding: 20px 20px;position: absolute;top: 85px;z-index: 1;">
                                                    <h1 style="font-size: 70px;letter-spacing: 5px;">INVOICE</h1>
                                                </div>

                                                <div style="background:#1B0C57;border-radius:8px;padding: 15px 25px;width: fit-content; display: flex;flex-direction: row;justify-content: center;align-items: center;gap: 16px;">
                                                    <div class="">
                                                        <p style="font-size: 10px;letter-spacing: 1px;color: #D83E71;text-align: center;">Invoice Number</p>
                                                        <p style="color: #FFF;font-size: 12px;text-align: center;">{{ $invoice_number }}</p>
                                                    </div>
                                                    <div class="">
                                                        <p style="font-size: 10px;letter-spacing: 1px;color: #D83E71;text-align: center;">Invoice Date</p>
                                                        <p style="color: #FFF;font-size: 12px;text-align: center;">{{ $invoice_date }}</p>
                                                    </div>
                                                </div>
                                            <!-- </div> -->
                                        </div>
                                    </td>
                                    <td width="50%" valign="top" align="right" style="font-size:14px; line-height:20px;padding-left: 10px;">
                                        <div style="background: #0D022C;border-radius: 20px 0px 0px 20px;height: 295px;position: relative;">
                                            <img src="{{ $invoice_image2 }}" style="position: absolute;top: 20px; right: 20px;width: 50px;" alt="">
                                            <div style="width: 110px;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
                                                <p style="color: #FFF;font-size: 12px;text-align: left;font-weight: bold;line-height: 15px;">Invoice From:</p>
                                                <div class="">
                                                    <p style="font-size: 10px;letter-spacing: 1px;color: #D83E71;text-align: left;">{{ $site_name }}</p>
                                                    {{-- <p style="color: #FFF;font-size: 8px;text-align: left;font-weight: 400;line-height: 10px;">Bank Name - Account Name</p>
                                                    <p style="color: #FFF;font-size: 8px;text-align: left;font-weight: 400;line-height: 10px;">Account No.</p>
                                                    <p style="color: #FFF;font-size: 8px;text-align: left;font-weight: 400;line-height: 10px;">SWIFT Code</p> --}}
                                                </div>
                                                <div class="">
                                                    <p style="font-size: 10px;letter-spacing: 1px;color: #D83E71;text-align: left;">{{ $company_mobile }}</p>
                                                    <p style="color: #FFF;font-size: 8px;text-align: left;font-weight: 400;line-height: 10px;">{{ $company_email }}</p>
                                                    <p style="color: #FFF;font-size: 8px;text-align: left;font-weight: 400;line-height: 10px;">Western Union</p>
                                                </div>
                                            </div>
                                            <img src="{{ $invoice_image1 }}" style="position: absolute;bottom: 20px; left: 20px;width: 50px;" alt="">
                                        </div>
                                        
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- INVOICE TITLE -->
                
                    <!-- TWO COLUMNS: Terms + Customer -->
                    <tr>
                        <td style="padding:30px;">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50%" style="font-size:14px; line-height:20px;padding: 0px 70px 0px 25px;vertical-align: top;">
                                        <div class="">
                                            <p style="color: #FFF;font-size: 12px;text-align: left;font-weight: bold;line-height: 15px;margin-bottom: 4px;">Terms & Conditions</p>
                                            <p style="color: #FFF;font-size: 8px;text-align: left;font-weight: 400;line-height: 10px;line-height: 10px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                                        </div>
                                    </td>
                                    <td width="50%" style="font-size:14px; line-height:20px;padding: 0px 70px 0px 25px;vertical-align: top;">
                                        <div class="">
                                            <p style="color: #FFF;font-size: 12px;text-align: left;font-weight: bold;line-height: 15px;margin-bottom: 4px;">Invoice To :</p>
                                            <p style="color: #FFF;font-size: 16px;text-align: left;font-weight: bold;line-height: 15px;margin-bottom: 4px;font-weight: bold;">{{ $customer_name ? $customer_name : '' }}</p>
                                            {{-- <p style="color: #FFF;font-size: 8px;text-align: left;font-weight: 400;line-height: 10px;line-height: 10px;">640 Shadowmar Drive<br>
                                            New Orleans, LA, USA 70125<br>
                                            patriciaharrison@gmail.com</p> --}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- ITEMS TABLE -->
                    <tr>
                        <td style="padding:30px;">
                            <table class="mainT" width="100%" cellpadding="0" cellspacing="0"
                                style="font-size:14px; border-collapse: collapse;">
                                <tr
                                    style="background:#D83E71; color:white; font-weight:bold; text-transform:uppercase;">
                                    <td style="padding: 10px 10px 10px 20px;width: 50%;">Description</td>
                                    <td style="padding: 10px 10px 10px 10px;" align="center">Unit Price</td>
                                    <td style="padding: 10px 10px 10px 10px;" align="center">Qty</td>
                                    <td style="padding: 10px 20px 10px 10px;" align="right">Total</td>
                                </tr>
                                @foreach($products as $product)
                                <tr>
                                    <td style="padding: 8px 10px 8px 20px;">{{ ucwords(strtolower($product['name'])) }}</td>
                                    <td style="padding: 8px 10px 8px 10px;" align="center">{{ $currency . number_format($product['unit_price'], 2) }}</td>
                                    <td style="padding: 8px 10px 8px 10px;" align="center">1</td>
                                    <td style="padding: 8px 20px 8px 10px;" align="right">{{ $currency . number_format($product['unit_price'], 2) }}</td>
                                </tr>
                                @endforeach
                               
                            </table>
                        </td>
                    </tr>

                    <!-- Bottom Total -->
                    <tr>
                        <td style="padding:30px;">
                            <table width="100%">
                                <tr>
                                    <td width="50%" style="font-size:26px; font-weight:bold; color:#ffffff;">
                                        TOTAL DUE<br>
                                        <span style="color:#D83E71; font-size:38px; font-weight:bold;">{{ site_currency() . number_format($invoice_amount ?? 0, 2) }}</span>
                                    </td>

                                    <td width="50%" align="right">
                                        <table style="width: 90%;font-size:14px; line-height:25px;background:#0D022C;border-radius:8px;padding: 15px 25px;">
                                            <tr>
                                                <td><b>Subtotal</b></td>
                                                <td align="right">{{ site_currency() . number_format($invoice_amount + $discount_amount ?? 0, 2) }}</td>
                                            </tr>
                                            {{-- <tr>
                                                <td><b>Tax 10%</b></td>
                                                <td align="right">$100.00</td>
                                            </tr> --}}
                                            <tr>
                                                <td><b>Discount</b></td>
                                                <td align="right">{{ site_currency() . number_format($discount_amount ?? 0, 2) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table><!-- END MAIN -->

            </td>
        </tr>
    </table>

</body>

</html>