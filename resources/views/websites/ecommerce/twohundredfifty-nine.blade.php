<!DOCTYPE html>
<html>

<head>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8">
    <meta name=Generator content="Microsoft Word 15 (filtered)">
    <style>
        /* Font Definitions */
        @font-face {
            font-family: "Cambria Math";
            panose-1: 2 4 5 3 5 4 6 3 2 4;
        }

        @font-face {
            font-family: "Helvetica Neue";
        }

        @font-face {
            font-family: HGGothicM;
        }

        @font-face {
            font-family: Tahoma;
            panose-1: 2 11 6 4 3 5 4 4 2 4;
        }

        @font-face {
            font-family: "Times New Roman \(Headings CS\)";
            panose-1: 0 0 0 0 0 0 0 0 0 0;
        }

        @font-face {
            font-family: "\@HGGothicM";
        }

        /* Style Definitions */
        p.MsoNormal,
        li.MsoNormal,
        div.MsoNormal {
            margin: 0in;
            font-size: 9.0pt;
            font-family: "Helvetica Neue";
            color: #1D3451;
            letter-spacing: .5pt;
        }

        h1 {
            margin: 0in;
            page-break-after: avoid;
            font-size: 9.0pt;
            font-family: "Helvetica Neue";
            color: #1D3451;
            text-transform: uppercase;
            letter-spacing: .5pt;
        }

        p.MsoTitle,
        li.MsoTitle,
        div.MsoTitle {
            mso-style-link: "Title Char";
            margin: 0in;
            text-align: center;
            line-height: 40.0pt;
            font-size: 36.0pt;
            font-family: "Helvetica Neue";
            color: white;
            text-transform: uppercase;
            letter-spacing: .5pt;
            font-weight: bold;
        }

        p.MsoTitleCxSpFirst,
        li.MsoTitleCxSpFirst,
        div.MsoTitleCxSpFirst {
            mso-style-link: "Title Char";
            margin: 0in;
            text-align: center;
            line-height: 40.0pt;
            font-size: 36.0pt;
            font-family: "Helvetica Neue";
            color: white;
            text-transform: uppercase;
            letter-spacing: .5pt;
            font-weight: bold;
        }

        p.MsoTitleCxSpMiddle,
        li.MsoTitleCxSpMiddle,
        div.MsoTitleCxSpMiddle {
            mso-style-link: "Title Char";
            margin: 0in;
            text-align: center;
            line-height: 40.0pt;
            font-size: 36.0pt;
            font-family: "Helvetica Neue";
            color: white;
            text-transform: uppercase;
            letter-spacing: .5pt;
            font-weight: bold;
        }

        p.MsoTitleCxSpLast,
        li.MsoTitleCxSpLast,
        div.MsoTitleCxSpLast {
            mso-style-link: "Title Char";
            margin: 0in;
            text-align: center;
            line-height: 40.0pt;
            font-size: 36.0pt;
            font-family: "Helvetica Neue";
            color: white;
            text-transform: uppercase;
            letter-spacing: .5pt;
            font-weight: bold;
        }

        p.Right-alignedtext,
        li.Right-alignedtext,
        div.Right-alignedtext {
            mso-style-name: "Right-aligned text";
            margin: 0in;
            text-align: right;
            line-height: 110%;
            font-size: 9.0pt;
            font-family: "Helvetica Neue";
            color: #1D3451;
            letter-spacing: .5pt;
        }

        p.ContactInfo,
        li.ContactInfo,
        div.ContactInfo {
            mso-style-name: "Contact Info";
            margin-top: 26.0pt;
            margin-right: 0in;
            margin-bottom: 0in;
            margin-left: 0in;
            text-align: center;
            font-size: 8.0pt;
            font-family: "Helvetica Neue";
            color: #1D3451;
            text-transform: uppercase;
            letter-spacing: .5pt;
            font-weight: bold;
        }

        p.Thankyou,
        li.Thankyou,
        div.Thankyou {
            mso-style-name: "Thank you";
            margin: 0in;
            text-align: center;
            font-size: 9.0pt;
            font-family: "Helvetica Neue";
            color: #5E5B95;
            letter-spacing: .5pt;
        }

        span.TitleChar {
            mso-style-name: "Title Char";
            mso-style-link: Title;
            font-family: "Helvetica Neue";
            color: white;
            text-transform: uppercase;
            letter-spacing: .5pt;
            font-weight: bold;
        }

        p.Totals,
        li.Totals,
        div.Totals {
            mso-style-name: Totals;
            margin: 0in;
            text-align: right;
            line-height: 110%;
            font-size: 9.0pt;
            font-family: "Helvetica Neue";
            color: #1D3451;
            letter-spacing: .5pt;
            font-weight: bold;
        }

        .MsoChpDefault {
            font-size: 10.0pt;
            font-family: "Century Gothic", sans-serif;
        }

        /* Page Definitions */
        @page WordSection1 {
            size: 8.5in 11.0in;
            margin: 10.75pt .75in 24.4pt .75in;
        }

        div.WordSection1 {
            page: WordSection1;
        }
    </style>

    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>

<body lang=EN-US link="#0563C1" vlink="#954F72" style='word-wrap:break-word'>

    <div class=WordSection1>
        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width=672 style="
            border-collapse:collapse;
            border:none;
            background-image:url('{{ $invoice_header_image }}');
            background-size:cover;
            background-position:center;
            background-repeat:no-repeat;
            height:180px;
        ">
            <tr>
                <td colspan="3" style="padding:0; border:none;">

                    <div style="position:relative; width:100%; height:180px; overflow:hidden;">



                        <!-- Overlay Content -->
                        <div style="
                                position:relative;
                                z-index:2;
                                padding:30px;
                                height:180px;
                                color:#ffffff;
                            ">

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
                                        <div style="
                                            font-size:34px;
                                            font-weight:700;
                                            letter-spacing:2px;
                                            color:#ffffff;
                                        ">
                                            INVOICE
                                        </div>
                                    </td>
                                </tr>

                                <!-- LINE -->
                                <tr>
                                    <td style="padding:15px 0;">
                                        <hr style="
                                            border:0;
                                            border-top:1px solid rgba(255,255,255,0.6);
                                        ">
                                    </td>
                                </tr>

                            </table>

                        </div>

                    </div>

                </td>
            </tr>
            <tr style='height:15.35pt'>
                <td width=672 colspan=3 valign=top style='width:503.75pt;border:none;
                    padding:0in 5.4pt 0in 5.4pt;height:15.35pt'>
                    <p class=MsoNormal>&nbsp;</p>
                </td>
            </tr>
            <tr style='height:99.95pt'>
                <td width=420 valign=top style='width:314.75pt;padding:0in 5.4pt 0in 5.4pt;
                        height:99.95pt'>
                    <h1><span style='color:white'>DATE: </span></h1>
                    <p class=MsoNormal><span style='color:white'>{{ $invoice_date }} </span></p>
                    <p class=MsoNormal><span style='color:white'>&nbsp;</span></p>
                    <h1><span style='color:#D5DCE4'>INVOICE # </span></h1>
                    <p class=MsoNormal><span style='color:white'>{{ $invoice_number }} </span><span style='color:#D5DCE4'> </span></p>
                    <p class=MsoNormal>&nbsp;</p>
                </td>
                <td width=42 valign=top style='width:31.5pt;padding:0in 5.4pt 0in 5.4pt;
                    height:99.95pt'>
                    <h1><span style='color:#D5DCE4'>To:</span> </h1>
                </td>
                <td width=210 valign=top style='width:157.5pt;padding:0in 5.4pt 0in 5.4pt;
                        height:99.95pt'>
                    <p class=Right-alignedtext><span style='color:white'>{{ $customer_name }} </span></p>
                    <p class=MsoNormal align=right style='text-align:right'><span style='color:white'>&nbsp;</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal>&nbsp;</p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 style='border-collapse:collapse;border:none'>
            <tr style='height:19.85pt'>
                <td width=72 style='width:53.75pt;border:none;border-bottom:solid #4E80BF 1.0pt;
                    padding:0in 5.4pt 0in 5.4pt;height:19.85pt'>
                    <h1>QTY</h1>
                </td>
                <td width=408 style='width:4.25in;border:none;border-bottom:solid #4E80BF 1.0pt;
                    padding:0in 5.4pt 0in 5.4pt;height:19.85pt'>
                    <h1>ITem description </h1>
                </td>
                <td width=96 style='width:71.85pt;border:none;border-bottom:solid #4E80BF 1.0pt;
                    padding:0in 5.4pt 0in 5.4pt;height:19.85pt'>
                    <h1 align=right style='text-align:right'>Unit Price </h1>
                </td>
                <td width=96 style='width:71.9pt;border:none;border-bottom:solid #4E80BF 1.0pt;
                        padding:0in 5.4pt 0in 5.4pt;height:19.85pt'>
                    <h1 align=right style='text-align:right'>Line Total </h1>
                </td>
            </tr>

            @foreach ($products as $product)
            <tr style='height:19.85pt'>
                <td width=72 style='width:53.75pt;border:solid #4E80BF 1.0pt;border-top:none;
                        padding:0in 5.4pt 0in 5.4pt;height:19.85pt'>
                    <p class=MsoNormal>1 </p>
                </td>
                <td width=408 style='width:4.25in;border-top:none;border-left:none;
                        border-bottom:solid #4E80BF 1.0pt;border-right:solid #4E80BF 1.0pt;
                        padding:0in 5.4pt 0in 5.4pt;height:19.85pt'>
                    <p class=MsoNormal>{{ $product->name }}</p>
                </td>
                <td width=96 style='width:71.85pt;border-top:none;border-left:none;
                        border-bottom:solid #4E80BF 1.0pt;border-right:solid #4E80BF 1.0pt;
                        padding:0in 5.4pt 0in 5.4pt;height:19.85pt'>
                    <p class=MsoNormal align=right style='text-align:right'>{{ site_currency() . number_format($product->unit_price, 2)}} </p>
                </td>
                <td width=96 style='width:71.9pt;border-top:none;border-left:none;border-bottom:
                        solid #4E80BF 1.0pt;border-right:solid #4E80BF 1.0pt;padding:0in 5.4pt 0in 5.4pt;
                        height:19.85pt'>
                    <p class=MsoNormal align=right style='text-align:right'>{{ site_currency() . number_format($product->unit_price, 2)}}</p>
                </td>
            </tr>
            @endforeach
            <tr style='height:19.85pt'>
                <td width=72 style='width:53.75pt;border:none;padding:0in 5.4pt 0in 5.4pt; height:19.85pt'>
                    <p class=MsoNormal>&nbsp;</p>
                </td>
                <td width=408 style='width:4.25in;border:none;padding:0in 5.4pt 0in 5.4pt;height:19.85pt'>
                    <p class=MsoNormal>&nbsp;</p>
                </td>
                <td width=96 style='width:71.85pt;border:none;border-right:solid #4E80BF 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:19.85pt'>
                    <h1>Subtotal </h1>
                </td>
                <td width=96 style='width:71.9pt;border-top:none;border-left:none;border-bottom:
                    solid #4E80BF 1.0pt;border-right:solid #4E80BF 1.0pt;background:#C4D4EA;
                    padding:0in 5.4pt 0in 5.4pt;height:19.85pt'>
                    <p class=Totals>{{ site_currency() .number_format(($invoice_amount + $discount_amount), 2) }} </p>
                </td>
            </tr>
            <tr style='height:19.85pt'>
                <td width=72 style='width:53.75pt;padding:0in 5.4pt 0in 5.4pt;height:19.85pt'>
                    <p class=MsoNormal>&nbsp;</p>
                </td>
                <td width=408 style='width:4.25in;padding:0in 5.4pt 0in 5.4pt;height:19.85pt'>
                    <p class=MsoNormal>&nbsp;</p>
                </td>
                <td width=96 style='width:71.85pt;border:none;border-right:solid #4E80BF 1.0pt;
                    padding:0in 5.4pt 0in 5.4pt;height:19.85pt'>
                    <h1>Discount </h1>
                </td>
                <td width=96 style='width:71.9pt;border-top:none;border-left:none;border-bottom:
                        solid #4E80BF 1.0pt;border-right:solid #4E80BF 1.0pt;background:#C4D4EA;
                        padding:0in 5.4pt 0in 5.4pt;height:19.85pt'>
                    <p class=Totals>{{ site_currency() .number_format(($discount_amount), 2) }} </p>
                </td>
            </tr>
            <tr style='height:19.85pt'>
                <td width=72 style='width:53.75pt;padding:0in 5.4pt 0in 5.4pt;height:19.85pt'>
                    <p class=MsoNormal>&nbsp;</p>
                </td>
                <td width=408 style='width:4.25in;padding:0in 5.4pt 0in 5.4pt;height:19.85pt'>
                    <p class=MsoNormal>&nbsp;</p>
                </td>
                <td width=96 style='width:71.85pt;border:none;border-right:solid #4E80BF 1.0pt;
                    padding:0in 5.4pt 0in 5.4pt;height:19.85pt'>
                    <h1>Total</h1>
                </td>
                <td width=96 style='width:71.9pt;border-top:none;border-left:none;border-bottom:
                        solid #4E80BF 1.0pt;border-right:solid #4E80BF 1.0pt;background:#C4D4EA;
                        padding:0in 5.4pt 0in 5.4pt;height:19.85pt'>
                    <p class=Totals>{{ site_currency() .number_format(($invoice_amount), 2) }}</p>
                </td>
            </tr>
        </table>

        <p class=ContactInfo align=left style='text-align:left'>&nbsp;</p>

        <p class=Thankyou><span style='color:#4E80BF'>Thank you for your business!</span>
        </p>

        <p class=ContactInfo>{{ $company_name }} {!! $company_address !!}  {{ $company_mobile }}</p>

        <p class=ContactInfo style='margin-top:0in'>| Email: {{ $company_email }} |</p>

    </div>

</body>

</html>