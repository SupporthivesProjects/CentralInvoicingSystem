<!DOCTYPE html>
<html>
<head>
    <title>Your Email Title</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;">
                            <img src="{{ $invoice_header_image }}" alt="" style="margin: auto; display: block;height:120px;">
                        </td>
                    </tr>
                    <!-- Header End -->

                    <!-- Content -->
                    <tr style="background:url('');background-position: center;background-repeat: no-repeat;background-size: contain;">
                        <td style="padding:40px;display: flex;flex-direction: column;justify-content: center;align-items: center;">
                            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td>
                                        <div style="display: flex;flex-direction: column;">
                                        <p style="color:#4D4D4D;font-size: 10px;font-weight: 500;font-family: Arial;margin: 0px;line-height:16px;text-align: left;">
                                          <b style="color: #000000;">Date:</b>  {{ $invoice_date ?? 'N/A' }}
                                        </p>
                                        <p style="color:#4D4D4D;font-size: 10px;font-weight: 500;font-family: Arial;margin: 0px;line-height:16px;text-align: left;">
                                           <b style="color: #000000;">Invoice Number:</b> #{{ $invoice_number ?? 'N/A' }}
                                        </p>
                                        </div>
                                    </td>
                                    <td>
                                        <p style="color: #000000;font-size:28px;font-weight:700;font-family: Arial;margin: 0px;line-height:28px;text-align:right;">
                                            INVOICE
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <table style="margin-top:20px;border-collapse: collapse;width: 100%;">
                                <tr>
                                    <td>
                                        <p style="color: #000000;font-size: 12px;font-family: Arial;font-weight: 400;margin: 0px;text-transform: uppercase;">
                                            Billed To :
                                        </p>
                                        <p style="color: #000000;font-size: 12px;font-family: Arial;font-weight: 400;margin: 0px;text-transform:capitalize;">
                                            {{ $customer_name ?? 'N/A' }}
                                        </p>
                                       <p style="color: #000000;font-size: 10px;font-family: Arial;font-weight: 400;margin: 0px;text-transform:capitalize;">
                                            <b>Email:</b> {{ $customer_email ?? 'N/A' }}
                                        </p>
                                    </td>
                                </tr>
                                <tr style="height: 20px;"></tr>
                                <tr>
                                    <td>
                                        <p style="color: #000000;font-size: 12px;font-family: Arial;font-weight: 400;margin: 0px;text-transform: uppercase;">
                                            Billed From :
                                        </p>
                                        <p style="color: #000000;font-size: 12px;font-family: Arial;font-weight: 400;margin: 0px;text-transform:capitalize;">
                                            Gauntlet Gold
                                        </p>
                                    </td>
                                </tr>
                                <tr style="height: 20px;"></tr>
                                <tr style="height: 24px;">
                                    <td colspan="2">
                                        <div style="display: flex;flex-direction: column;">
                                        <p style="color: #000000;font-size: 10px;font-weight: 500;font-family: Arial;margin: 0px;line-height:16px;text-align: left;">
                                          <b>Website:</b> <a href="" style="color: rgb(35, 96, 209);">www.gauntletgold.com</a>
                                        </p>
                                        <p style="color: #000000;font-size: 10px;font-weight: 500;font-family: Arial;margin: 0px;line-height:16px;text-align: left;">
                                           <b>Phone:</b> {{ $company_phone ?? 'N/A' }}
                                        </p>
                                        <p style="color: #000000;font-size: 10px;font-weight: 500;font-family: Arial;margin: 0px;line-height:16px;text-align: left;">
                                           <b>Address:</b> {{ $company_address ?? 'N/A' }}
                                        </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <img src="{{ $invoice_image1 }}" alt="" style="width: 60%;margin-top:20px;">
                            <div style="min-height: 500px !important;">
                            <table cellspacing="0" cellpadding="0" border="1" width="100%" style="border: 1px solid rgb(195, 195, 195);border-collapse: collapse;">
                                <tr style="background:#A03F3F;width:550px;height: 28px;">
                                    <td style="width: 100px;">
                                        <p style="color: #000000;font-size:9px;font-weight:700;font-family: Arial;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;">
                                            Item
                                        </p>
                                    </td>
                                    <td style="width:250px;">
                                        <p style="color: #000000;font-size:9px;font-weight:700;font-family: Arial;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;">
                                            Description
                                        </p>
                                    </td>
                                    <td style="width:50px;">
                                        <p style="color: #000000;font-size:9px;font-weight:700;font-family: Arial;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;">
                                            Quantity
                                        </p>
                                    </td>
                                    <td style="width:70px;">
                                        <p style="color: #000000;font-size:9px;font-weight:700;font-family: Arial;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;">
                                            Unit Price
                                        </p>
                                    </td>
                                    <td style="width:70px;">
                                        <p style="color: #000000;font-size:9px;font-weight:700;font-family: Arial;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;">
                                            Total
                                        </p>
                                    </td>
                                </tr>
                                @foreach($products as $index => $product)
                                <tr style="height: 28px;">
                                    <td>
                                        <p style="color:#000000;font-size:8px;font-weight: 500;font-family: Arial;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;">
                                            {{ $loop->iteration }}
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#000000;font-size:8px;font-weight: 500;font-family: Arial;margin: 0px;line-height:10px;text-align: left;padding-left:10px;">
                                           <b>{{ $product['name'] }} </b> <br>
                                             {{ $product['game_currency_amount'] }} {{ $product['game_currency'] }}
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#000000;font-size:8px;font-weight: 500;font-family: Arial;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;">
                                            1
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#000000;font-size:8px;font-weight: 500;font-family: Arial;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;">
                                           {{ $currency . number_format($product['unit_price'], 2) }}
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#000000;font-size:8px;font-weight: 500;font-family: Arial;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;">
                                            {{ $currency . number_format($product['unit_price'], 2) }}
                                        </p>
                                    </td>
                                </tr>
                                @endforeach
                                    <td>
                                        <p style="color:#000000;font-size:8px;font-weight: 500;font-family: Arial;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;">

                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#000000;font-size:8px;font-weight: 500;font-family: Arial;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;">

                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#000000;font-size:8px;font-weight: 500;font-family: Arial;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;">

                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#000000;font-size:8px;font-weight: 500;font-family: Arial;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;">

                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#000000;font-size:8px;font-weight: 500;font-family: Arial;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;">

                                        </p>
                                    </td>
                                </tr>
                                <tr style="height: 28px;">
                                    <td colspan="2">

                                    </td>
                                    <td colspan="2">
                                        <p style="color:#000000;font-size:9px;font-weight:500;font-family: Arial;margin: 0px;line-height: 28px;text-align:left;padding-left:10px;text-transform:capitalize;">
                                            Subtotal
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#000000;font-size:9px;font-weight:500;font-family: Arial;margin: 0px;line-height: 28px;text-align:left;padding-left:10px;text-transform:capitalize;">
                                           {{ $currency . number_format($product['unit_price'] + $discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr style="height: 28px;">
                                    <td colspan="2">

                                    </td>
                                    <td colspan="2">
                                        <p style="color:#000000;font-size:9px;font-weight:500;font-family: Arial;margin: 0px;line-height: 28px;text-align:left;padding-left:10px;text-transform:capitalize;">
                                            Discount
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#000000;font-size:9px;font-weight:500;font-family: Arial;margin: 0px;line-height: 28px;text-align:left;padding-left:10px;text-transform:capitalize;">
                                           {{ $currency . number_format($discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr style="height: 28px;">
                                    <td colspan="2">

                                    </td>
                                    <td colspan="2" style="background:#A03F3F;">
                                        <p style="color:#000000;font-size:9px;font-weight:500;font-family: Arial;margin: 0px;line-height: 28px;text-align:left;padding-left:10px;text-transform:capitalize;">
                                            grand total
                                        </p>
                                    </td>
                                    <td style="background:#A03F3F;">
                                        <p style="color:#000000;font-size:9px;font-weight:500;font-family: Arial;margin: 0px;line-height: 28px;text-align:left;padding-left:10px;text-transform:capitalize;">
                                           {{ $currency . number_format($invoice_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr>
                        <td align="center" style="height:100px;background: url('{{ $invoice_footer_image }}');background-position: center;background-repeat: no-repeat;background-size: cover;">

                        </td>
                    </tr>
                    <!-----------Footer End----------->
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
