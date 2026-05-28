<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>

<body lang="EN-US" style="margin:0; padding:0; width:100%; word-wrap:break-word; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;">

    <div style="margin:0; padding:0;">

        <!-- HEADER TABLE -->
        <table border="0" cellspacing="0" cellpadding="0" width="100%" style="border-collapse:collapse; border:none; background-image:url('{{ $invoice_header_image }}'); background-size:cover; background-position:center; background-repeat:no-repeat; height:180px;">
            <tr>
                <td colspan="3" style="padding:0; border:none;">
                    <div style="position:relative; width:100%; height:180px; overflow:hidden;">
                        <!-- Overlay Content -->
                        <div style="position:relative; z-index:2; padding:30px; height:180px; color:#ffffff; box-sizing:border-box;">

                            <table width="100%" cellpadding="0" cellspacing="0">

                                <!-- LOGO -->
                                <tr>
                                    <td align="center">
                                        <img src="{{ $company_logo }}" alt="Logo" style="height:40px;">
                                    </td>
                                </tr>

                                <!-- SPACE -->
                                <tr>
                                    <td height="15"></td>
                                </tr>

                                <!-- TITLE -->
                                <tr>
                                    <td align="center" style="padding-top:10px;">
                                        <div style="font-size:34px; font-weight:700; letter-spacing:2px; color:#ffffff;">
                                            INVOICE
                                        </div>
                                    </td>
                                </tr>

                                <!-- LINE -->
                                <tr>
                                    <td style="padding:15px 0;">
                                        <hr style="border:0; border-top:1px solid rgba(255,255,255,0.6);">
                                    </td>
                                </tr>

                            </table>

                        </div>
                    </div>
                </td>
            </tr>

            <!-- SPACER ROW -->
            <tr style="height:15.35pt;">
                <td colspan="3" valign="top" style="border:none; padding:0in 5.4pt 0in 5.4pt; height:15.35pt;">
                    <p style="margin:0; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; letter-spacing:.5pt;">&nbsp;</p>
                </td>
            </tr>

            <!-- DATE / INVOICE# / TO ROW -->
            <tr style="height:99.95pt;">

                <!-- LEFT: DATE & INVOICE# -->
                <td width="420" valign="top" style="width:314.75pt; padding:0in 40px 0in 40px; height:99.95pt; vertical-align:top;">
                    <h1 style="margin:0; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:white; text-transform:uppercase; letter-spacing:.5pt; font-weight:bold;">DATE:</h1>
                    <p style="margin:0; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:white; letter-spacing:.5pt;">{{ $invoice_date }}</p>
                    <p style="margin:0; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:white; letter-spacing:.5pt;">&nbsp;</p>
                    <h1 style="margin:0; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#D5DCE4; text-transform:uppercase; letter-spacing:.5pt; font-weight:bold;">INVOICE #</h1>
                    <p style="margin:0; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:white; letter-spacing:.5pt;">{{ $invoice_number }}</p>
                    <p style="margin:0; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:white; letter-spacing:.5pt;">&nbsp;</p>
                </td>

                <!-- MIDDLE: TO LABEL -->
                <td width="42" valign="top" style="width:31.5pt; padding:0in 5.4pt 0in 5.4pt; height:99.95pt; vertical-align:top;">
                    <h1 style="margin:0; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#D5DCE4; text-transform:uppercase; letter-spacing:.5pt; font-weight:bold;">To:</h1>
                </td>

                <!-- RIGHT: TO VALUE -->
                <td width="210" valign="top" style="width:157.5pt; padding:0in 40px 0in 5.4pt; height:99.95pt; vertical-align:top;">
                    <p style="margin:0; text-align:right; line-height:110%; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:white; letter-spacing:.5pt;">{{ $customer_name }}</p>
                    <p style="margin:0; text-align:right; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:white; letter-spacing:.5pt;">&nbsp;</p>
                </td>

            </tr>
        </table>

        <!-- CONTENT WRAP -->
        <div style="padding:0 40px;">

            <!-- ITEMS TABLE -->
            <table border="0" cellspacing="0" cellpadding="0" width="100%" style="border-collapse:collapse; border:none; margin:0 auto;">

                <!-- HEADER ROW -->
                <tr style="height:19.85pt;">
                    <td width="72" style="width:53.75pt; border:none; border-bottom:solid #4E80BF 1.0pt; padding:0in 5.4pt 0in 5.4pt; height:19.85pt;">
                        <h1 style="margin:0; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; text-transform:uppercase; letter-spacing:.5pt; font-weight:bold;">QTY</h1>
                    </td>
                    <td style="border:none; border-bottom:solid #4E80BF 1.0pt; padding:0in 5.4pt 0in 5.4pt; height:19.85pt;">
                        <h1 style="margin:0; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; text-transform:uppercase; letter-spacing:.5pt; font-weight:bold;">ITEM DESCRIPTION</h1>
                    </td>
                    <td width="96" style="width:71.85pt; border:none; border-bottom:solid #4E80BF 1.0pt; padding:0in 5.4pt 0in 5.4pt; height:19.85pt;">
                        <h1 align="right" style="margin:0; text-align:right; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; text-transform:uppercase; letter-spacing:.5pt; font-weight:bold;">UNIT PRICE</h1>
                    </td>
                    <td width="96" style="width:71.9pt; border:none; border-bottom:solid #4E80BF 1.0pt; padding:0in 5.4pt 0in 5.4pt; height:19.85pt;">
                        <h1 align="right" style="margin:0; text-align:right; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; text-transform:uppercase; letter-spacing:.5pt; font-weight:bold;">LINE TOTAL</h1>
                    </td>
                </tr>

                <!-- DYNAMIC PRODUCT ROWS -->
                @foreach ($products as $product)
                <tr style="height:19.85pt;">
                    <td width="72" style="width:53.75pt; border:solid #4E80BF 1.0pt; border-top:none; padding:0in 5.4pt 0in 5.4pt; height:19.85pt;">
                        <p style="margin:0; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; letter-spacing:.5pt;">1</p>
                    </td>
                    <td style="border-top:none; border-left:none; border-bottom:solid #4E80BF 1.0pt; border-right:solid #4E80BF 1.0pt; padding:0in 5.4pt 0in 5.4pt; height:19.85pt;">
                        <p style="margin:0; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; letter-spacing:.5pt;">{{ $product->name }}</p>
                    </td>
                    <td width="96" style="width:71.85pt; border-top:none; border-left:none; border-bottom:solid #4E80BF 1.0pt; border-right:solid #4E80BF 1.0pt; padding:0in 5.4pt 0in 5.4pt; height:19.85pt;">
                        <p align="right" style="margin:0; text-align:right; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; letter-spacing:.5pt;">{{ site_currency() . number_format($product->unit_price, 2) }}</p>
                    </td>
                    <td width="96" style="width:71.9pt; border-top:none; border-left:none; border-bottom:solid #4E80BF 1.0pt; border-right:solid #4E80BF 1.0pt; padding:0in 5.4pt 0in 5.4pt; height:19.85pt;">
                        <p align="right" style="margin:0; text-align:right; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; letter-spacing:.5pt;">{{ site_currency() . number_format($product->unit_price, 2) }}</p>
                    </td>
                </tr>
                @endforeach

                <!-- SUBTOTAL ROW -->
                <tr style="height:19.85pt;">
                    <td width="72" style="width:53.75pt; border:none; padding:0in 5.4pt 0in 5.4pt; height:19.85pt;">
                        <p style="margin:0; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; letter-spacing:.5pt;">&nbsp;</p>
                    </td>
                    <td style="border:none; padding:0in 5.4pt 0in 5.4pt; height:19.85pt;">
                        <p style="margin:0; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; letter-spacing:.5pt;">&nbsp;</p>
                    </td>
                    <td width="96" style="width:71.85pt; border:none; border-right:solid #4E80BF 1.0pt; padding:0in 5.4pt 0in 5.4pt; height:19.85pt;">
                        <h1 style="margin:0; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; text-transform:uppercase; letter-spacing:.5pt; font-weight:bold;">Subtotal</h1>
                    </td>
                    <td width="96" style="width:71.9pt; border-top:none; border-left:none; border-bottom:solid #4E80BF 1.0pt; border-right:solid #4E80BF 1.0pt; background:#C4D4EA; padding:0in 5.4pt 0in 5.4pt; height:19.85pt;">
                        <p style="margin:0; text-align:right; line-height:110%; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; letter-spacing:.5pt; font-weight:bold;">{{ site_currency() . number_format(($invoice_amount + $discount_amount), 2) }}</p>
                    </td>
                </tr>

                <!-- DISCOUNT ROW -->
                <tr style="height:19.85pt;">
                    <td width="72" style="width:53.75pt; padding:0in 5.4pt 0in 5.4pt; height:19.85pt;">
                        <p style="margin:0; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; letter-spacing:.5pt;">&nbsp;</p>
                    </td>
                    <td style="padding:0in 5.4pt 0in 5.4pt; height:19.85pt;">
                        <p style="margin:0; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; letter-spacing:.5pt;">&nbsp;</p>
                    </td>
                    <td width="96" style="width:71.85pt; border:none; border-right:solid #4E80BF 1.0pt; padding:0in 5.4pt 0in 5.4pt; height:19.85pt;">
                        <h1 style="margin:0; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; text-transform:uppercase; letter-spacing:.5pt; font-weight:bold;">Discount</h1>
                    </td>
                    <td width="96" style="width:71.9pt; border-top:none; border-left:none; border-bottom:solid #4E80BF 1.0pt; border-right:solid #4E80BF 1.0pt; background:#C4D4EA; padding:0in 5.4pt 0in 5.4pt; height:19.85pt;">
                        <p style="margin:0; text-align:right; line-height:110%; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; letter-spacing:.5pt; font-weight:bold;">{{ site_currency() . number_format(($discount_amount), 2) }}</p>
                    </td>
                </tr>

                <!-- TOTAL ROW -->
                <tr style="height:19.85pt;">
                    <td width="72" style="width:53.75pt; padding:0in 5.4pt 0in 5.4pt; height:19.85pt;">
                        <p style="margin:0; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; letter-spacing:.5pt;">&nbsp;</p>
                    </td>
                    <td style="padding:0in 5.4pt 0in 5.4pt; height:19.85pt;">
                        <p style="margin:0; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; letter-spacing:.5pt;">&nbsp;</p>
                    </td>
                    <td width="96" style="width:71.85pt; border:none; border-right:solid #4E80BF 1.0pt; padding:0in 5.4pt 0in 5.4pt; height:19.85pt;">
                        <h1 style="margin:0; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; text-transform:uppercase; letter-spacing:.5pt; font-weight:bold;">Total</h1>
                    </td>
                    <td width="96" style="width:71.9pt; border-top:none; border-left:none; border-bottom:solid #4E80BF 1.0pt; border-right:solid #4E80BF 1.0pt; background:#C4D4EA; padding:0in 5.4pt 0in 5.4pt; height:19.85pt;">
                        <p style="margin:0; text-align:right; line-height:110%; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; letter-spacing:.5pt; font-weight:bold;">{{ site_currency() . number_format(($invoice_amount), 2) }}</p>
                    </td>
                </tr>

            </table>

            <!-- SPACER -->
            <p style="margin-top:26pt; margin-right:0; margin-bottom:0; margin-left:0; text-align:left; font-size:8pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; text-transform:uppercase; letter-spacing:.5pt; font-weight:bold;">&nbsp;</p>

            <!-- THANK YOU -->
            <p style="margin:0; text-align:center; font-size:9pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#4E80BF; letter-spacing:.5pt;">Thank you for your business!</p>

            <!-- COMPANY INFO -->
            <p style="margin-top:26pt; margin-right:0; margin-bottom:0; margin-left:0; text-align:center; font-size:8pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; text-transform:uppercase; letter-spacing:.5pt; font-weight:bold;">{{ $company_name }} {!! $company_address !!} {{ $company_mobile }}</p>

            <!-- EMAIL -->
            <p style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; text-align:center; font-size:8pt; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#1D3451; text-transform:uppercase; letter-spacing:.5pt; font-weight:bold;">| Email: {{ $company_email }} |</p>

        </div>

    </div>

</body>

</html>