<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>

    <style>
        h1,h2,h3,h4,h5,h6,p {
            margin: 0px;
        }
    </style>

</head>

<body style="margin:0; padding:0; background: #fff; font-family: Arial, Helvetica, sans-serif;">

    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:0px;">
        <tr>
            <td>

                <!-- Main Container -->
                <table align="center" width="650" cellpadding="0" cellspacing="0"
                    style="background: url({{$invoice_image1}}); color:white; padding:30px;">
                    <tr>
                        <td style="padding:0px;">

                            <!-- Logo & Title -->
                            <table width="100%">
                                <tr>
                                    <td width="50%">
                                        <img src="{{ $invoice_header_image }}" width="200" style="display:block;">
                                    </td>
                                    <td width="50%" valign="top" style="">
                                        <h1 style="font-size:70px;">INVOICE</h1>
                                        <p style="font-size:15px;margin-bottom: 6px;">Invoice To :</p>
                                        <p style="font-size:16px;font-weight:bold;margin-bottom: 6px;">{{ $customer_name ? $customer_name : '' }}</p>
                                        <div style="display: flex;flex-direction: row;justify-content: space-between;align-items: top; gap: 16px;">
                                            <p style="font-size:8px;line-height: 12px;">
                                                {!! $company_address !!}
                                            </p>

                                            <p style="font-size:8px;line-height: 12px;">
                                                {{ $customer_email ? $customer_email : '' }}<br>
                                                
                                            </p>

                                        </div>
                                    </td>
                                </tr>
                            </table>



                            <!-- Divider -->

                            <!-- Invoice Number & Date -->
                            <table width="100%" style="margin-top:0px; font-size:14px; border-top:1px solid #48598A;border-bottom:1px solid #48598A;padding: 20px 0px; margin: 20px 0px;">
                                <tr>
                                    <td width="50%">
                                        <b>Invoice Number:</b><br>{{ $invoice_number }}
                                    </td>
                                    <td width="50%">
                                        <b>Invoice Date:</b><br>{{ $invoice_date }}
                                    </td>
                                </tr>
                            </table>



                            <!-- DESCRIPTION TABLE -->
                            <table width="100%" cellpadding="6" cellspacing="0"
                                style="font-size:14px;background:#121a3d;padding:15px; border-radius:8px; border: 1px solid #fff;">
                                <tr style="font-weight:bold; text-transform:uppercase;">
                                    <td>Description</td>
                                    <td>Unit Price</td>
                                    <td style="text-align: center;">Qty</td>
                                    <td style="text-align: right;">Total</td>
                                </tr>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product['name'] }} /{{ $product['game_currency_amount'] }} {{ $product['game_currency'] }}</td>
                                        <td>{{ site_currency() . number_format($product['unit_price'], 2) }}</td>
                                        <td style="text-align: center;">2</td>
                                        <td style="text-align: right;">{{ site_currency() . number_format($product['unit_price'], 2) }}</td>
                                    </tr>
                                @endforeach
                                {{-- <tr>
                                    <td>Item Name</td>
                                    <td>$100.00</td>
                                    <td style="text-align: center;">2</td>
                                    <td style="text-align: right;">$200.00</td>
                                </tr>
                                <tr>
                                    <td>Item Name</td>
                                    <td>$100.00</td>
                                    <td style="text-align: center;">2</td>
                                    <td style="text-align: right;">$200.00</td>
                                </tr>
                                <tr>
                                    <td>Item Name</td>
                                    <td>$100.00</td>
                                    <td style="text-align: center;">2</td>
                                    <td style="text-align: right;">$200.00</td>
                                </tr>
                                <tr>
                                    <td>Item Name</td>
                                    <td>$100.00</td>
                                    <td style="text-align: center;">2</td>
                                    <td style="text-align: right;">$200.00</td>
                                </tr> --}}
                                
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;"><b>Subtotal</b></td>
                                    <td colspan="2" align="right" style="padding-top: 20px;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                </tr>
                                {{-- <tr>
                                    <td colspan="2"><b>Tax 10%</b></td>
                                    <td colspan="2" align="right">$100.00</td>
                                </tr> --}}
                                <tr>
                                    <td colspan="2"><b>Discount</b></td>
                                    <td colspan="2" align="right">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr style="font-size:18px; font-weight:bold;">
                                    <td colspan="2">Total</td>
                                    <td colspan="2" align="right">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                </tr>
                            </table>

                            

                            

                            <!-- Terms & Conditions -->
                            {{-- <table width="100%" style="margin:25px 0px; font-size:14px; border: 1px solid #fff;background:#121a3d; border-radius:8px;">
                                <tr>
                                    <td style="padding:15px;">
                                        <b>Terms & Conditions</b>
                                        <p style="margin-top:5px; line-height:20px;">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
                                        </p>
                                    </td>
                                </tr>
                            </table> --}}

                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:0px;">
                                <tr>
                                    <td>
                                        <!-- Payment Methods -->
                                        <table width="100%" style="margin-top:0px; font-size:14px;">
                                            <tr>
                                                <td><b>{{ $company_name }}</b></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:0px; font-size:14px;">
                                                        <tr>
                                                            <td style="width: 20%;">
                                                                <p style="font-size:10px;line-height: 12px;font-weight: bold;">{{ $company_name }}</p>
                                                            </td>
    
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%;">
                                                                <p style="font-size:10px;line-height: 12px;font-weight: bold;">Email</p>
                                                            </td>
                                                            <td style="width: 80%;">
                                                                <p style="font-size:8px;line-height: 12px;">{{ $company_email }},</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%;">
                                                                <p style="font-size:10px;line-height: 12px;font-weight: bold;">Contact</p>
                                                            </td>
                                                            <td style="width: 80%;">
                                                                <p style="font-size:8px;line-height: 12px;">{{ $company_mobile }}</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            
                                        </table>
                                    </td>
                                    <td style="vertical-align: bottom;">

                                        <!-- Footer -->
                                        <table width="100%" style="margin-top:0px; font-size:16px;">
                                            <tr>
                                                <td width="50%" align="right" style="font-weight:bold;">
                                                    THANK YOU!
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="right" style="font-size:12px;">{{ $company_email }}</td>
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