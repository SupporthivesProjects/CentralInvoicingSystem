<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body, table, td {
            background-color: transparent !important;
        }
        .invoice_header_image {
            background-image: url('{{ $invoice_header_image }}');
            background-repeat: no-repeat; 
            background-position: center;
            background-size: cover;
            text-align: center;
            height: 150px;
            width: 100%;
        }

        .invoice_footer_image {
            page-break-inside: avoid;
            height: 140px;
            background-image: url('{{ $invoice_footer_image }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }

        .narayan td {
            padding-top:5px !important;
            padding-bottom:5px !important;
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="80%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); margin: auto;">
                    <!-- Header -->
                    <tr class="invoice_header_image">
                        <td>
                            <table style="margin: auto;">
                                <tr>
                                    <td style="text-align: center;">
                                        <img src="{{ $company_logo }}" alt="" style="height:70px;padding-bottom:40px;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px; padding-top: 0px;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="text-align: center;">
                                        <h1 style="color:rgb(56, 53, 53); margin: 0px;">INVOICE</h1>
                                        <img src="{{ $invoice_image1 }}" alt="" style="height:30px; display: block; margin: 0 auto;">
                                    </td>
                                </tr>
                            </table>

                            <table style="width: 100%; margin-top: 10px;">
                                <tr>
                                    <td>
                                        <p style="color:#474748;font-family: arial;font-size: 10px;">
                                            <b>To:</b> {{ $customer_name }}
                                        </p>
                                        <p style="color:#474748;font-family: arial;font-size: 10px;">
                                            <b>From:</b> {{ $site_name }}
                                        </p>
                                    </td>
                                    <td style="text-align: right;">
                                        <p style="color:#474748;font-family: arial;font-size: 10px;">
                                            <b>Invoice no:</b> #{{ $invoice_number }}
                                        </p>
                                        <p style="color:#474748;font-family: arial;font-size: 10px;">
                                            <b>Date:</b> {{ $invoice_date }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <br>

                            <table  class="narayan" style="width: 100%; height: 400px;border: 1px solid rgb(56, 53, 53); border-collapse: collapse;">
                                <tr style="height: 24px;">
                                    <td style="width: 250px; text-align:left; padding-left:10px; font-family: arial; font-size: 10px; font-weight: 700; border: 1px solid rgb(56, 53, 53); color:rgb(56, 53, 53);">
                                        PRODUCTS
                                    </td>
                                    <td style="width: 100px; text-align: center; font-family: arial; font-size: 10px; font-weight: 700; border: 1px solid rgb(56, 53, 53); color:rgb(56, 53, 53);">
                                        TYPE
                                    </td>
                                    <td style="width: 150px; text-align: center; font-family: arial; font-size: 10px; font-weight: 700; border: 1px solid rgb(56, 53, 53); color:rgb(56, 53, 53);">
                                        QUANTITY
                                    </td>
                                    <td style="width: 100px; text-align:right; padding-right:10px; font-family: arial; font-size: 10px; font-weight: 700; border: 1px solid rgb(56, 53, 53); color:rgb(56, 53, 53);">
                                        PRICE
                                    </td>
                                </tr>

                                @foreach($products as $product)
                                <tr style="height: 24px;">
                                    <td style="padding-left:10px; font-family: arial; font-size: 10px; border: 1px solid rgb(56, 53, 53); color:#474748;">
                                        {{ $product->name }}
                                    </td>
                                    <td style="text-align: center; font-family: arial; font-size:10px; border: 1px solid rgb(56, 53, 53); color:#474748;">
                                        {{ $product->category_name }}
                                    </td>
                                    <td style="text-align: center; font-family: arial; font-size: 10px; border: 1px solid rgb(56, 53, 53); color:#474748;">
                                        01
                                    </td>
                                    <td style="text-align: center;  padding-right:10px; font-family: arial; font-size: 10px; border: 1px solid rgb(56, 53, 53); color:#474748;">
                                        {{ site_currency() . number_format($product->unit_price, 2) }}
                                    </td>
                                </tr>
                                @endforeach

                                <tr>
                                    <td colspan="2"></td>
                                    <td style="text-align: right; padding-right: 10px; font-family: arial; font-size: 10px; color:rgb(56, 53, 53);">
                                        <p>Sub Total</p>
                                    </td>
                                    <td style="text-align: center; font-family: arial; font-size: 10px; border: 1px solid rgb(56, 53, 53); color:#474748;">
                                        <p>{{ site_currency() . number_format(($invoice_amount + $discount_amount), 2) }} </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2"></td>
                                    <td style="text-align: right;color:green; padding-right: 10px; font-family: arial; font-size: 10px; color:#2f5496;">
                                        <p>Discount</p>
                                    </td>
                                    <td style="text-align: center; font-family: arial; font-size: 10px; border: 1px solid rgb(56, 53, 53); color:#474748;">
                                        <p>{{ site_currency() . number_format($discount_amount, 2) }}</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2"></td>
                                    <td style="text-align: right; padding-right: 10px; font-family: arial; font-size: 10px; border-top: 1px solid rgb(56, 53, 53);">
                                        <p><b style="color:#474748;">Grand Total</b></p>
                                    </td>
                                    <td style="text-align: center; font-family: arial; font-size: 10px; border: 1px solid rgb(56, 53, 53); color:#474748;">
                                        <p><b>{{ site_currency() . number_format($invoice_amount, 2) }}</b></p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End -->

                    <!-- Footer -->
                    <tr>
                        <td>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
                            <tr class="invoice_footer_image" style="height: 180px;"> <!-- Increased height here -->
                                <td>
                                    <table style="width: 100%; height: 120px!important;padding-top: 10px!important; padding-bottom: 10px !important;"> <!-- Make sure the table occupies the full height -->
                                        <tr>
                                            <td style="width: 100px;"></td>
                                            <td style="width: 200px; text-align: center;">
                                                <img src="{{ $invoice_image2 }}" style="width: 24px; height: auto;"> <!-- Image size adjusted -->
                                            </td>
                                            <td style="width: 200px; text-align: center;">
                                                <img src="{{ $invoice_image3 }}" style="width: 20px; height: auto;"> <!-- Image size adjusted -->
                                            </td>
                                            <td style="width: 100px;"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td style="text-align: center;">
                                                <p style="font-family: arial; font-size: 10px; margin: 0px; font-weight: 400; color: whitesmoke;">
                                                    {{ $company_email }}
                                                </p>
                                            </td>
                                            <td style="text-align: center;">
                                                <p style="font-family: arial; font-size: 10px; margin: 0px; font-weight: 400; color: whitesmoke;">
                                                    {!! $company_address !!}
                                                </p>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        </td>
                    </tr>
                    <!-- Footer End -->
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
