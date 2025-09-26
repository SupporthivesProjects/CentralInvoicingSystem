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

<body style="margin: 0 !important; padding: 0 !important;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse;">
                    <!-- Header -->
                    <tr>
                        <td style="padding:0px;">
                            <table
                                style="background: url({{ $invoice_header_image }});background-repeat: no-repeat;background-size: cover;margin: auto; display: block;height:250px;width: 100%;border-collapse: collapse;z-index: 9999999;">
                                <tr style="vertical-align: bottom;">
                                    <td style="padding: 0px;">
                                        <div
                                            style="background:#1F2139;margin-top:160px;height:70px;width: 320px;padding: 10px 0px 10px 40px;display: flex;flex-direction: column;gap: 10px;">
                                            <h1
                                                style="color: #ffff;font-family: Poppins SemiBold;font-size: 36px;font-weight: 600px;margin: 0px;text-transform: uppercase;">
                                                Invoice
                                            </h1>
                                            <div style="display: flex;gap: 30px;">
                                                <p
                                                    style="color: #ffff;font-family: Poppins SemiBold;font-size:14px;font-weight: 600px;margin: 0px;">
                                                    {{ $invoice_date }}
                                                </p>
                                                <p
                                                    style="color: #ffff;font-family: Poppins SemiBold;font-size:14px;font-weight: 600px;margin: 0px;">
                                                    NO: {{ $invoice_number }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr style="background:#ffff ;">
                        <td style="padding:40px;padding-bottom: 0px;" align="center">
                            <table style="border-collapse:collapse;width:100%;margin-top:20px;">
                                <td style="vertical-align: top;">
                                    <h2
                                        style="color:#000000;font-size: 14px;font-weight:600;font-family: Poppins;margin: 0px;line-height:18px;text-transform:capitalize;">
                                        Invoice to
                                    </h2>
                                    <p
                                        style="color:#000000;font-size:12px;font-weight:600;font-family: Poppins;margin: 0px;line-height:16px;text-transform:capitalize;">
                                        {{ $customer_name }}
                                    </p>
                                </td>
                                <td
                                    style="display: flex;flex-direction: column;align-items:flex-end;justify-content: flex-start;gap: 10px;padding-top: 10px;">
                                    <div style="display: flex;flex-direction: column;align-items:flex-start;justify-content: flex-start;gap: 10px;">
                                        <img src="{{ $company_logo }}" alt=""
                                            style="height:30px;width:70px;margin-right: 90px;">
                                        <div>
                                            <h2
                                                style="color:#000000;font-size: 12px;font-weight:500;font-family: Poppins;margin: 0px;line-height:18px;text-transform:capitalize;">
                                                {!! $company_address !!}
                                            </h2>
                                            <p
                                                style="color:#767171;font-size:9px;font-weight:500;font-family: Poppins;margin: 0px;line-height:16px;text-transform:capitalize;">
                                                <b style="color:#000000;">E:</b> {{ $company_email }}
                                            </p>
                                            <p
                                                style="color:#767171;font-size:9px;font-weight:500;font-family: Poppins;margin: 0px;line-height:16px;">
                                                <b style="color:#000000;">W:</b> {{ $site->site_link }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                </td>
                            </table>
                            <div style="min-height: 400px !important;">
                                <table cellspacing="0" cellpadding="0" border="0" width="100%"
                                    style="border-collapse: collapse;margin-top:40px;">
                                    <tr style="height:40px;background:#1F2139 ;">
                                        <td style="width:300px;">
                                            <p
                                                style="color:#ffff;font-size: 12px;font-weight:400;font-family:Poppins;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;">
                                                Product Name
                                            </p>
                                        </td>
                                        <td style="width:50px;">
                                            <p
                                                style="color:#ffff;font-size: 12px;font-weight:400;font-family:Poppins;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;">
                                                Qty
                                            </p>
                                        </td>
                                        <td style="width:100px;">
                                            <p
                                                style="color:#ffff;font-size: 12px;font-weight:400;font-family:Poppins;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;">
                                                Unit Price
                                            </p>
                                        </td>
                                        <td style="width:100px;">
                                            <p
                                                style="color:#ffff;font-size: 12px;font-weight:400;font-family:Poppins;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;">
                                                Total
                                            </p>
                                        </td>
                                    </tr>
                                    @foreach ($products as $product)
                                        <tr style="height:40px;">
                                            <td>
                                                <p
                                                    style="color:black;font-size: 11px;font-weight: 500;font-family:Poppins;margin: 0px;line-height: 28px;text-align: left;padding-left:10px;">
                                                    {{ $product->name }}
                                                </p>
                                            </td>
                                            <td>
                                                <p
                                                    style="color:black;font-size: 11px;font-weight: 500;font-family:Poppins;margin: 0px;line-height:16px;text-align:right;padding-right:10px;">
                                                    {{ $product->quantity ?? 1 }}
                                                </p>
                                            </td>
                                            <td>
                                                <p
                                                    style="color:black;font-size: 11px;font-weight: 500;font-family:Poppins;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;">
                                                    {{ site_currency() }} {{ number_format($product->unit_price, 2) }}
                                                </p>
                                            </td>
                                            <td>
                                                <p
                                                    style="color:black;font-size: 11px;font-weight: 500;font-family: Poppins;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;">
                                                    {{ site_currency() }}{{ number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr style="height:40px;border-bottom:1px solid grey ;">
                                        <td colspan="3">
                                            <p
                                                style="color:#000000;font-size: 12px;font-weight:500;font-family:Poppins;margin: 0px;line-height: 28px;text-align:left;padding-left:10px;text-transform:capitalize;">
                                                Sub total
                                            </p>
                                        </td>
                                        <td>
                                            <p
                                                style="color:#000000;font-size: 12px;font-weight:500;font-family: Poppins;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;text-transform: uppercase;">
                                                {{ site_currency() }}{{ number_format($invoice_amount + $discount_amount, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr style="height:40px;border-bottom:1px solid grey ;">
                                        <td colspan="3">
                                            <p
                                                style="color:#000000;font-size: 12px;font-weight:500;font-family:Poppins;margin: 0px;line-height: 28px;text-align:left;padding-left:10px;text-transform:capitalize;">
                                                Discount
                                            </p>
                                        </td>
                                        <td>
                                            <p
                                                style="color:#000000;font-size: 12px;font-weight:500;font-family: Poppins;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;text-transform: uppercase;">
                                                {{ site_currency() }}{{ number_format($discount_amount, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr style="height:40px;border-bottom:1px solid grey ;">
                                        <td colspan="3">
                                            <p
                                                style="color:#000000;font-size: 12px;font-weight:600;font-family: Poppins;margin: 0px;line-height: 28px;text-align:left;padding-left:10px;text-transform:capitalize;">
                                                Total Amount
                                            </p>
                                        </td>
                                        <td>
                                            <p
                                                style="color:#000000;font-size: 12px;font-weight:500;font-family: Poppins;margin: 0px;line-height: 28px;text-align:right;padding-right:10px;text-transform: uppercase;">
                                                {{ site_currency() }}{{ number_format($invoice_amount, 2) }}
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
                        <td align="center" style="height:110px;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr>
                                    <h1
                                        style="color:#000000 ;font-family: Poppins;font-size:16px;margin: 0px;text-align: left;padding:100px 40px;">
                                        Thank You <br>
                                        For Your Business
                                    </h1>
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
