<!DOCTYPE html>
<html>

<head>
    <title>Your Email Title</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body style="margin:0px;padding:0px">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0; background: white;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse;">
                    <!---header--->
                    <tr>
                        <td align="center" style="height:100px;background:#416529;padding:20px;vertical-align: middle;">
                            <img src="{{ $invoice_header_image }}" alt="" style="height: 70px;">
                        </td>
                    </tr>
                    <tr>
                        <td> <img src="{{ $invoice_image1 }}" alt="" style="width: 150px;">
                            <h1
                                style="margin: 0px;font-family: Arial;font-size:28px;line-height:32px;text-transform: uppercase;text-align: center;">
                                invoice
                            </h1>
                        </td>
                    </tr>
                    <!---header End--->

                    <!-- Content -->
                    <tr style="background:#ffff ;">
                        <td style="padding: 40px;padding-top: 0px;">
                            <table width="100%%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                                style="font-family:'Poppins',Arial,sans-serif;border-collapse:collapse;color:#000;">
                                <!-- ORDER INFO -->
                                <tr>
                                    <td style="padding-bottom:10px;">
                                        <p style="margin:0;font-size:12px;line-height:18px;">
                                            <b style="text-transform:uppercase;">Order Number:</b>
                                            #{{ $invoice_number }}
                                        </p>
                                        <p style="margin:0;font-size:12px;line-height:18px;">
                                            <b style="text-transform:uppercase;">Date:</b> {{ $invoice_date }}
                                        </p>
                                    </td>
                                    <td align="right" style="vertical-align:top;">
                                        <p
                                            style="margin:0;font-size:12px;line-height:18px;font-weight:700;color:#013220;text-transform:uppercase;">
                                            Billed To:
                                        </p>
                                        <p style="margin:0;font-size:12px;line-height:18px;">{{ $customer_name }}</p>
                                    </td>
                                </tr>

                        

                         <!-- TOTALS SECTION (in a new compact table) -->
<table width="30%" align="left" cellspacing="0" cellpadding="0" border="0" 
    style="font-family:'Poppins',Arial,sans-serif;border-collapse:collapse;color:#000;
           margin:0 auto;padding:10px;border-radius:6px;">

    <tr>
        <td colspan="2" style="padding-top:10px;">
            <p style="margin:0;font-size:8px;letter-spacing:1px;color:#777;">INVOICE TOTAL</p>
        </td>
    </tr>

    <tr>
        <td colspan="2" style="border-bottom:1px solid #ccc;padding:6px 0;"></td>
    </tr>

    <tr>
        <td style="padding-top:8px;">
            <p style="margin:0;font-size:8px;color:#555;">Subtotal</p>
        </td>
        
        <td align="right" style="padding-top:8px;">
            <p style="margin:0;font-size:8px;color:#555;">
                {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
            </p>
        </td>
    </tr>
<tr>
        <td colspan="2" style="border-bottom:1px solid #ccc;padding:6px 0;"></td>
    </tr>
    <tr>
        <td style="padding-top:6px;">
            <p style="margin:0;font-size:12px;color:#555;">Discount</p>
        </td>
        <td align="right" style="padding-top:6px;">
            <p style="margin:0;font-size:12px;color:#555;">
                {{ site_currency() . number_format($discount_amount, 2) }}
            </p>
        </td>
    </tr>
<tr>
        <td colspan="2" style="border-bottom:1px solid #ccc;padding:6px 0;"></td>
    </tr>
    <!-- GRAND TOTAL -->
    <tr>
        <td colspan="2" style="padding-top:12px;">
            <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                <tr>
                    <td style="background:#c8a951;padding:6px 10px;font-size:11px;font-weight:700;text-transform:uppercase;">
                        Grand Total
                    </td>
                    <td align="right" style="background:#c8a951;padding:6px 10px;font-size:12px;font-weight:700;">
                        {{ site_currency() . number_format($invoice_amount, 2) }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>


                                <!-- BILLED FROM INFO -->
                                <tr>
                                    <td colspan="2" style="padding:15px 40px ;">
                                        <p
                                            style="margin:0;font-size:12px;font-weight:700;color:#013220;text-transform:uppercase;">
                                            Billed From:
                                        </p>
                                        <p style="margin:0;font-size:12px;">{{ $site_name }}</p>
                                        <p style="margin:0;font-size:12px;"><b>Email:</b> {{ $company_email }}</p>
                                        <p style="margin:0;font-size:12px;"><b>Phone:</b> {{ $company_mobile }}</p>
                                        <p style="margin:0;font-size:12px;"><b>Address:</b> {{ $company_address }}</p>
                                    </td>
                                </tr>
                            </table>

                            <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                                style="border-collapse: collapse;margin: 0px 40px;background:#fff; ;>
                                <tr style="background:#416529;">
                                    <td>
                                        <p
                                            style="margin: 0px;font-family: Arial;font-size: 11px;line-height: 18px;font-weight: 700;padding: 5px;color: #ffff;">
                                            Product
                                        </p>
                                    </td>
                                    <td>
                                        <p
                                            style="margin: 0px;font-family: Arial;font-size: 11px;line-height: 18px;font-weight: 700;padding: 5px;color: #ffff;">
                                            Category
                                        </p>
                                    </td>
                                    <td>
                                        <p
                                            style="margin: 0px;font-family: Arial;font-size: 11px;line-height: 18px;font-weight: 700;padding: 5px;color: #ffff;">
                                            Quantity
                                        </p>
                                    </td>
                                    <td>
                                        <p
                                            style="margin: 0px;font-family: Arial;font-size: 11px;line-height: 18px;font-weight: 700;padding: 5px;color: #ffff;">
                                            Unit Price
                                        </p>
                                    </td>
                                    <td align="right">
                                        <p
                                            style="margin: 0px;font-family: Arial;font-size: 11px;line-height: 18px;font-weight: 700;padding: 5px;color: #ffff;">
                                            Total
                                        </p>
                                    </td>
                                </tr>
                                @foreach ($products as $product)
                                    <tr style="border-bottom: 1px solid black;">
                                        <td>
                                            <p
                                                style="margin: 0px;font-family: Arial;font-size:8px;line-height: 18px;padding: 5px;">
                                                {{ $product->name }}
                                            </p>
                                        </td>
                                        <td>
                                            <p
                                                style="margin: 0px;font-family: Arial;font-size:8px;line-height: 18px;padding: 5px;">
                                                {{ $product->category_name ?? 'Uncategorized' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p
                                                style="margin: 0px;font-family: Arial;font-size:8px;line-height: 18px;padding: 5px;">
                                                1
                                            </p>
                                        </td>
                                        <td>
                                            <p
                                                style="margin: 0px;font-family: Arial;font-size:8px;line-height: 18px;padding: 5px;">
                                                {{ site_currency() . number_format($product->unit_price, 2) }}
                                            </p>
                                        </td>
                                        <td align="right">
                                            <p
                                                style="margin: 0px;font-family: Arial;font-size:8px;line-height: 18px;padding: 5px;">
                                                {{ site_currency() . number_format($product->unit_price, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr style="background:#E2EFD9;">
                                    <td colspan="4" style="border-bottom: 1px solid black;">
                                        <p
                                            style="margin: 0px;font-family: Arial;font-size:11px;line-height: 18px;padding: 5px;">
                                            Subtotal
                                        </p>
                                    </td>
                                    <td align="right" style="border-bottom: 1px solid black;">
                                        <p
                                            style="margin: 0px;font-family: Arial;font-size:8px;line-height: 18px;padding: 5px;">
                                            {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr style="background:#E2EFD9;">
                                    <td colspan="4" style="border-bottom: 1px solid black;">
                                        <p
                                            style="margin: 0px;font-family: Arial;font-size:11px;line-height: 18px;padding: 5px;">
                                            Discount
                                        </p>
                                    </td>
                                    <td align="right" style="border-bottom: 1px solid black;">
                                        <p
                                            style="margin: 0px;font-family: Arial;font-size:8px;line-height: 18px;padding: 5px;">
                                            {{ site_currency() . number_format($discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr style="background: #416529;">
                                    <td colspan="4">
                                        <p
                                            style="margin: 0px;font-family: Arial;font-size:11px;line-height: 18px;padding: 5px;color:#ffff;">
                                            Grand Total
                                        </p>
                                    </td>
                                    <td align="right">
                                        <p
                                            style="margin: 0px;font-family: Arial;font-size:8px;line-height: 18px;padding: 5px;color:#ffff;">
                                            {{ site_currency() . number_format($invoice_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr>
                        <td style="height:100px;" align="right">
                            <img src="{{ $invoice_image1 }}" alt="" style="width: 250px;rotate: 180deg;">
                        </td>
                    </tr>
                    <!-----------Footer End----------->
                </table>
            </td>
        </tr>
    </table>
</body>

</html>