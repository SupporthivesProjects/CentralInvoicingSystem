<!DOCTYPE html>
<html>

<head>
    <title>Your Email Title</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">


    <style>
        * {
            margin: 0px;
            padding: 0px;
        }

        .sub_tab {
        	width: 30%;
            position: absolute;
            right: 20px;
        }
        .sub_tab tr td {
            border: 1px solid black;
            padding: 5px 5px 5px 20px;
            text-align: right;
        }
    </style>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" style="padding:0px;vertical-align:top;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0"
                    style="border-collapse: collapse;background:url('{{ $invoice_image1 }}');background-size:cover;background-position:center;background-repeat:no-repeat;height:100vh">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 20px 0px 0px 45px;" colspan="2">
                            <table style="margin-top:125px">
                                <tr>
                                    <td style="padding: 5px;">
                                        <p
                                            style="font-size:9px;font-weight:700;font-family:Urbanist;margin: 0px;text-align:left;color:white;margin-bottom: 4px;">
                                            Invoice No.
                                        </p>
                                        <p
                                            style="font-size:9px;font-weight:700;font-family:Urbanist;margin: 0px;text-align:left;color:white;margin-bottom: 4px;">
                                            Date:
                                        </p><br>
                                        <p
                                            style="font-size:9px;font-weight:700;font-family:Urbanist;margin: 0px;text-align:left;color:white;margin-bottom: 4px;">
                                            Invoice To:
                                        </p>
                                    </td>
                                    <td style="padding: 5px;">
                                        <p
                                            style="font-size:9px;font-weight:400;font-family:Urbanist;margin: 0px;text-align:left;color:white;margin-bottom: 4px;">
                                            {{ $invoice_number }}
                                        </p>
                                        <p
                                            style="font-size:9px;font-weight:400;font-family:Urbanist;margin: 0px;text-align:left;color:white;margin-bottom: 4px;">
                                            {{ $invoice_date }}
                                        </p><br>
                                        <p
                                            style="font-size:9px;font-weight:400;font-family:Urbanist;margin: 0px;text-align:left;color:white;margin-bottom: 4px;">
                                            {{ $customer_name }}
                                        </p>
                                    </td>
                                </tr>
                                
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td style="padding:40px 20px 0px 20px;width:80%;vertical-align:top;margin-top:20px; position: relative;top: 10px;" align="center">
                            <table cellspacing="0" cellpadding="0" border="0" width="100%"
                                style="border-collapse: collapse;margin-top:40px;">
                                <tr style="height:50px;border-bottom:1px solid black;">
                                    <td style="width:40%;">
                                        <p
                                            style="font-size: 12px;font-weight:700;font-family:Urbanist;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;text-transform:uppercase;">
                                            ITEM DESCRIPTION
                                        </p>
                                    </td>
                                    <td style="width:20%;">
                                        <p
                                            style="font-size: 12px;font-weight:700;font-family:Urbanist;margin: 0px;line-height: 28px;text-align:center;padding-right:10px;text-transform:uppercase;">
                                            UNIT PRICE
                                        </p>
                                    </td>
                                    <td style="width:20%;">
                                        <p
                                            style="font-size: 12px;font-weight:700;font-family:Urbanist;margin: 0px;line-height: 28px;text-align:center;padding-right:10px;text-transform:uppercase;">
                                            QTY
                                        </p>
                                    </td>
                                    <td style="width:20%;">
                                        <p
                                            style="font-size: 12px;font-weight:700;font-family:Urbanist;margin: 0px;line-height: 28px;text-align:center;padding-right:10px;text-transform:uppercase;">
                                            Total
                                        </p>
                                    </td>
                                </tr>
                                @foreach ($products as $product)
                                    <tr style="height:50px;border-bottom:1px solid black;">
                                        <td>
                                            <p
                                                style="font-size:11px;font-weight: 700;font-family:Urbanist;margin: 0px;line-height:16px;text-align: left;padding-left:10px;">
                                                {{ $product->name }}
                                            </p>
                                        </td>
                                        <td>
                                            <p
                                                style="font-size: 11px;font-weight: 500;font-family:Urbanist;margin: 0px;line-height:16px;text-align:center;padding-right:10px;">
                                                {{ site_currency() . number_format($product->unit_price, 2) }}
                                            </p>
                                        </td>
                                        <td>
                                            <p
                                                style="font-size: 11px;font-weight: 500;font-family:Urbanist;margin: 0px;line-height:16px;text-align:center;padding-right:10px;">
                                                1
                                            </p>
                                        </td>
                                        <td>
                                            <p
                                                style="font-size: 11px;font-weight: 500;font-family: Urbanist;margin: 0px;line-height:16px;text-align:center;padding-right:10px;">
                                                {{ site_currency() . number_format($product->unit_price, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <table class="sub_tab" cellspacing="0" cellpadding="0" border="0" width="100%"
                                style="border-collapse: collapse;margin-top:20px;">
                                
                                <tr >
                                    <td style="border-bottom:1px solid grey ;">
                                        <p
                                            style="font-size:10px;font-weight:700;font-family:Urbanist;margin: 0px;padding-left:10px;text-transform:capitalize;">
                                            Subtotal
                                        </p>
                                    </td>
                                    <td style="border-bottom:1px solid grey ;">
                                        <p
                                            style="font-size:10px;font-weight:500;font-family:Urbanist;margin: 0px;text-transform: uppercase;">
                                            {{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr >
                                    <td style="border-bottom:1px solid grey ;">
                                        <p
                                            style="font-size:10px;font-weight:700;font-family:Urbanist;margin: 0px;padding-left:10px;text-transform:capitalize;">
                                            Discount
                                        </p>
                                    </td>
                                    <td style="border-bottom:1px solid grey ;">
                                        <p
                                            style="font-size:10px;font-weight:500;font-family:Urbanist;margin: 0px;text-transform: uppercase;color:#4EA72E;">
                                            {{ site_currency() . number_format($discount_amount, 2) }}

                                        </p>
                                    </td>
                                </tr>
                                <tr >
                                    <td style="border-bottom:1px solid grey ;">
                                        <p
                                            style="font-size:12px;font-weight:700;font-family:Urbanist;margin: 0px;padding-left:10px; textpx;-transform:capitalize;">
                                            Grand Total
                                        </p>
                                    </td>
                                    <td style="border-bottom:1px solid grey ;">
                                        <p
                                            style="font-size:12px;font-weight:500;font-family:Urbanist;margin: 0px;padding-left:10px;text-transform: uppercase;">
                                            {{ site_currency() . number_format($invoice_amount, 2) }}

                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 20%;"></td>
                    </tr>
                    <tr style="height:100%"></tr>
                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr>
                        <td align="center" style="height:50px;" colspan="2">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr>
                                    <td style="padding: 20px 40px;">
                                        <h4
                                            style="font-size:10px;font-weight:700;font-family:Urbanist;margin: 0px;line-height: 28px;text-align:left;padding-left:10px;text-transform:capitalize;">
                                            Contact Details
                                        </h4>
                                        <h4
                                            style="font-size:10px;font-weight:400;font-family:Urbanist;margin: 0px;line-height: 28px;text-align:left;padding-left:10px;text-transform:capitalize;">
                                            {{ $company_email }} <br>
                                            <!-- {!! $company_address !!}  -->
                                            @php
                                                $parts = explode(',', $company_address);

                                                // Insert line breaks after specific commas
                                                $formatted_address = '';
                                                foreach ($parts as $index => $part) {
                                                    $formatted_address .= trim($part);
                                                    if ($index < count($parts) - 1) {
                                                        $formatted_address .= ',';
                                                    }

                                                    // Add <br> after 1st and 4th commas
                                                    if (in_array($index, [0, 3])) {
                                                        $formatted_address .= '<br>';
                                                    } else {
                                                        $formatted_address .= ' ';
                                                    }
                                                }
                                            @endphp

                                            {!! $formatted_address !!}

                                        </h4>
                                    </td>
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
