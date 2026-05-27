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

<body style="margin:0; padding:0; background:#f2f2f2; font-family: Helvetica Neue;">

<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
<td align="center" style="padding:20px 0;">

<table width="100%" cellspacing="0" cellpadding="0" border="0"
style="
    background:#ffffff;
    border-collapse:collapse;
    width:100%;
">

<!-- HEADER -->
<tr>
<td style="padding:0;">

<div style="position:relative; width:100%; height:220px;">

        <!-- HEADER IMAGE -->
        <img src="{{ $invoice_header_image }}"
style="
    width:100%;
    height:220px;
    display:block;
">

        <!-- CONTENT -->
        <div style="
            position:absolute;
            top:0;
            left:0;
            width:100%;
            height:100%;
            padding:30px;
            box-sizing:border-box;
            color:#ffffff;
        ">

            <!-- LOGO -->
            <table width="100%">
                <tr>
                    <td align="center">
                        <img src="{{ $company_logo }}"
                             style="height:40px;">
                    </td>
                </tr>
            </table>

            <!-- TITLE -->
            <div style="
                text-align:center;
                font-size:34px;
                font-weight:700;
                letter-spacing:2px;
                margin-top:20px;
                color:#ffffff;
            ">
                INVOICE
            </div>

            <!-- LINE -->
            <div style="
                border-top:1px solid rgba(255,255,255,0.7);
                margin-top:20px;
            "></div>

            <!-- DETAILS -->
            <table width="100%" style="margin-top:20px; color:#ffffff; font-size:9px;">

                <tr>

                    <!-- LEFT -->
                    <td valign="top">

                        <strong style="color:#D5DCE4;">DATE:</strong><br>
                        {{ $invoice_date }}<br><br>

                        <strong style="color:#D5DCE4;">INVOICE #</strong><br>
                        {{ $invoice_number }}

                    </td>

                    <!-- RIGHT -->
                    <td align="right" valign="top">

                        <strong style="color:#D5DCE4;">TO:</strong>

                    </td>

                    <td align="right" valign="top">
                        {{ $customer_name }}
                    </td>

                </tr>

            </table>

        </div>

    </div>

</td>
</tr>

<!-- CONTENT -->
<tr>
<td style="padding:30px;">

<table width="100%"
cellspacing="0"
cellpadding="0"
style="border-collapse:collapse; font-size:9px; color:black;">

<tr style="font-weight:600;">

<td style="padding:6px; width:50px;">
QTY
</td>

<td style="padding:6px; width:300px;">
ITEM DESCRIPTION
</td>

<td align="right" style="padding:6px;">
UNIT PRICE
</td>

<td align="right" style="padding:6px;">
LINE TOTAL
</td>

</tr>

@foreach ($products as $product)

<tr>

<td style="border:1px solid #3b6cb7; padding:6px;">
1
</td>

<td style="border:1px solid #3b6cb7; padding:6px;">
{{ $product->name }}
</td>

<td align="right"
style="border:1px solid #3b6cb7; padding:6px;">

{{ site_currency() . number_format($product->unit_price, 2) }}

</td>

<td align="right"
style="border:1px solid #3b6cb7; padding:6px;">

{{ site_currency() . number_format($product->unit_price, 2) }}

</td>

</tr>

@endforeach

</table>

<!-- TOTALS -->
<table width="100%" cellspacing="0" cellpadding="0"
style="margin-top:20px;">

<tr>

<td width="60%"></td>

<td width="40%">

<table width="100%"
cellspacing="0"
cellpadding="6"
style="border-collapse:collapse; font-size:9px;">

<tr>

<td style="font-weight:bold;">
SUBTOTAL
</td>

<td style="
border:1px solid #3b6cb7;
background:#C4D4EA;
text-align:right;
font-weight:bold;
">

{{ site_currency() .number_format(($invoice_amount + $discount_amount), 2) }}

</td>

</tr>

<tr>

<td style="font-weight:bold;">
DISCOUNT
</td>

<td style="
border:1px solid #3b6cb7;
background:#C4D4EA;
text-align:right;
font-weight:bold;
">

{{ site_currency() .number_format(($discount_amount), 2) }}

</td>

</tr>

<tr>

<td style="font-weight:bold;">
TOTAL
</td>

<td style="
border:1px solid #3b6cb7;
background:#C4D4EA;
text-align:right;
font-weight:bold;
">

{{ site_currency() .number_format(($invoice_amount), 2) }}

</td>

</tr>

</table>

</td>
</tr>

</table>

</td>
</tr>

<!-- FOOTER -->
<tr>
<td style="padding:30px 20px; text-align:center;">

<div style="
font-size:9px;
color:#3b6cb7;
margin-bottom:15px;
">
Thank you for your business!
</div>

<div style="
font-size:8px;
color:#2c3e50;
letter-spacing:0.5px;
line-height:16px;
font-weight:600;
">
{{ $company_name }} {!! $company_address !!} |
{{ $company_mobile }}
</div>

<div style="
font-size:8px;
color:#2c3e50;
letter-spacing:0.5px;
margin-top:5px;
font-weight:600;
">
| EMAIL: {{ $company_email }}
</div>

</td>
</tr>

</table>

</td>
</tr>
</table>

</body>

</html>