<!DOCTYPE html>
<html>
<head>
    <title>Your Email Title</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);background:url('{{ $invoice_image1 }}') ;background-repeat: no-repeat;background-size: cover;">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 40px;vertical-align: top;" align="left">
                            <h1 style="color:#000000;font-size:60px;font-weight:700;font-family:Cambria;margin: 0px;line-height:24px;text-align:start;">
                                INVOICE
                            </h1>
                        </td>
                        <td style="padding: 40px;">
                            <p style="color:#000000;font-size:10px;font-weight:700;font-family:Leelawadee UI;margin: 0px;line-height:14px;text-align:right;">
                                {{ $company_name ?? 'SILVERSPOON CONTENT' }}
                            </p>
                            <p style="color:#000000;font-size:10px;font-weight:400;font-family: Leelawadee UI;margin: 0px;line-height:14px;text-align:right;">
                               {{ $company_address ?? 'N/A' }} <br>
                               {{ $company_email ?? 'SUPPORT@SILVERSPOONCONTENT.CO' }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 60px;">
                            <p style="color:#000000;font-size:10px;font-weight:700;font-family: Leelawadee UI;margin: 0px;line-height:14px;background-color: #FBE5D6;width: 150px;padding:5px 10px;text-align: left;">
                              #{{ $invoice_number }}
                            </p>
                        </td>
                        <td style="padding: 0px;">
                            <p style="color:#ffffff;font-size:10px;font-weight:700;font-family: Leelawadee UI;margin: 0px;line-height:14px;background-color: #000000;width: 150px;padding:5px 10px;text-align: left;">
                             Date: {{ $invoice_date ?? date('Y-m-d') }}
                            </p>
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                     <tr>
                        <td style="padding:20px 60px;">
                            <p style="color:#000000;font-size:11px;font-weight:700;font-family: Leelawadee UI;margin: 0px;line-height:14px;">
                             BILLED TO
                            </p>
                            <p style="color:#7F7F7F;font-size:11px;font-weight:400;font-family: Leelawadee UI;margin: 0px;line-height:14px;">
                            {{ $customer_name ?? 'N/A' }}<br>
                            </p>
                        </td>
                        <td style="padding-right: 40px;" align="right">
                            <img src="{{ $company_logo }}" alt="" style="width:150px;">
                        </td>
                     </tr>
                    <tr>
                        <td style="padding:40px;width: 100%;padding-top:20px;" colspan="2">
                            <div style="min-height: 600px !important">
                            <table cellspacing="0" cellpadding="0" border="0" width="100%" style="border-collapse: collapse;">
                                <tr style="width:520px;height:30px;background: #AC7C00;">
                                    <td>
                                        <p style="color:#ffffff;font-size:10px;font-weight: 700;font-family:Leelawadee UI;margin: 0px;line-height: 28px;padding-left: 10px;text-transform: uppercase;">
                                            product & service
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#ffffff;font-size:10px;font-weight: 700;font-family:Leelawadee UI;margin: 0px;line-height: 28px;text-align: center;text-transform: uppercase;">
                                            QTY.
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#ffffff;font-size:10px;font-weight: 700;font-family:Leelawadee UI;margin: 0px;line-height: 28px;text-align: center;text-transform: uppercase;">
                                           IMAGERY
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#ffffff;font-size:10px;font-weight: 700;font-family:Leelawadee UI;margin: 0px;line-height: 28px;text-align: center;text-transform: uppercase;">
                                            BILLING CYCLE
                                        </p>
                                    </td>
                                     <td>
                                        <p style="color:#ffffff;font-size:10px;font-weight: 700;font-family:Leelawadee UI;margin: 0px;line-height: 28px;text-align: center;text-transform: uppercase;">
                                            Total
                                        </p>
                                    </td>
                                </tr>
                                @foreach($products as $product)
                                 <tr style="width:520px;height:40px;">
                                    <td>
                                        <p style="color:#000000;font-size:10px;font-weight: 700;font-family:Leelawadee UI;margin: 0px;padding-left: 10px;">
                                            {{ $product->name ?? 'N/A' }}
                                        </p>
                                        <p style="color:#000000;font-size:10px;font-weight:400;font-family:Leelawadee UI;margin: 0px;padding-left: 10px;">
                                            {{ $product->quality }}, {{ $product->delivery }}
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#000000;font-size:10px;font-weight:400;font-family:Leelawadee UI;margin: 0px;line-height: 28px;text-align: center;">
                                           1
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#000000;font-size:10px;font-weight:400;font-family:Leelawadee UI;margin: 0px;line-height: 28px;text-align: center;">
                                           {{ $product->imagecount }}
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:#000000;font-size:10px;font-weight:400;font-family:Leelawadee UI;margin: 0px;line-height: 28px;text-align: center;">
                                            ONE TIME
                                        </p>
                                    </td>
                                     <td>
                                        <p style="color:#000000;font-size:10px;font-weight:400;font-family:Leelawadee UI;margin: 0px;line-height: 28px;text-align: center;">
                                           {{ site_currency() . number_format($product->unit_price, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                @endforeach
                                <tr style="height: 50px;"></tr>
                                <tr style="height:30px;">
                                    <td colspan="3"></td>
                                    <td style="background: #000000;">
                                        <p style="color:#ffffff;font-size:10px;font-weight:400;font-family:Leelawadee UI;margin: 0px;line-height: 28px;text-align: center;">
                                           SUBTOTAL
                                        </p>
                                    </td>
                                     <td style="background: #000000;">
                                        <p style="color:#ffffff;font-size:10px;font-weight:400;font-family:Leelawadee UI;margin: 0px;line-height: 28px;text-align: center;">
                                           {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr style="height:30px;">
                                    <td colspan="3"></td>
                                    <td style="background: #000000;">
                                        <p style="color:#ffffff;font-size:10px;font-weight:400;font-family:Leelawadee UI;margin: 0px;line-height: 28px;text-align: center;">
                                           DISCOUNT
                                        </p>
                                    </td>
                                     <td style="background: #000000;">
                                        <p style="color:#ffffff;font-size:10px;font-weight:400;font-family:Leelawadee UI;margin: 0px;line-height: 28px;text-align: center;">
                                           {{ site_currency() . number_format($discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>

                                <tr style="height:30px;">
                                    <td colspan="3"></td>
                                    <td style="background: #000000;">
                                        <p style="color:#FFD2B2;font-size:10px;font-weight:400;font-family:Leelawadee UI;margin: 0px;line-height: 28px;text-align: center;">
                                           GRAND TOTAL
                                        </p>
                                    </td>
                                     <td style="background: #000000;">
                                        <p style="color:#FFD2B2;font-size:10px;font-weight:400;font-family:Leelawadee UI;margin: 0px;line-height: 28px;text-align: center;">
                                           {{ site_currency() . number_format($invoice_amount, 2) }}
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
                        <td align="center" style="height:100px;background: url({{ $invoice_footer_image }});background-repeat: no-repeat;background-position: center;background-size: cover;" colspan="2">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;">
                                <tr>
                                   <p style="color:#000000 ;font-family: Cambria;font-size:9px;margin: 0px;font-weight: 700;">
                                    Your decision to shop with us is greatly appreciated
                                   </p>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-----------Footer End----------->
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
