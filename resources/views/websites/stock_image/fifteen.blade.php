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
        .footer_bg {
            background: url('{{ $invoice_image1 }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            height: 150px;
            vertical-align: bottom;
            position: absolute;
            bottom: -1px;
            left: 0;
            right: -1px;
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            align-items: center;
        }
    </style>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" width="100%" >
        <tr>
            <td align="center" bgcolor="#ffffff" style="padding: 0px 0;">
                <!-- <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse;max-width: 100%;"> -->
                    <!-- Header -->
                    <!-- <tr>
                        <td style="padding: 0px;"> -->
                            <!-- <table style="border-collapse: collapse;width: 100%;" border="0">
                                <td style="padding: 40px;vertical-align: top;"> -->
                                    <div
                                        style="display: flex;width: fit-content;justify-content: space-between;">
                                        <img src="{{ $company_logo }}" alt="" style="height: 60px;">
                                        <div>
                                            <h1
                                                style="margin: 0px;font-family: Poppins;font-size: 16px;text-align: right; margin-right: 0px;">
                                                INVOICE NO: #{{ $invoice_number }}
                                            </h1>
                                            <p
                                                style="margin: 0px;font-family: Poppins;font-size: 12px;text-align: right; margin-right: 0px">
                                                {{ \Carbon\Carbon::parse($invoice_date)->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                <!-- </td> -->
                    <!-- </tr>
                </table> -->
            </td>
        </tr>
        <!-- Header End -->


        <!-- Content -->
        <tr>
            <td style="padding:40px;vertical-align: top;">
                <table cellspacing="0" cellpadding="0" border="0" width="100%" style="border-collapse: collapse;">
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="display: flex;flex-direction: column;gap:20px;">
                                <!-- Total Dues -->
                                @if (!empty($invoice_amount))
                                    <div style="display: flex;flex-direction: column;">
                                        <span
                                            style="color: #002052;font-size:10px;font-weight:600;font-family: Poppins;">
                                            TOTAL DUE:
                                        </span>
                                        <p
                                            style="color:#7E0E53;font-size:24px;font-weight:400;font-family: Poppins;margin: 0px;">
                                            {{ site_currency_code() }}{{ number_format($invoice_amount, 2) }}
                                        </p>
                                    </div>
                                @endif

                                <!-- Invoice To -->
                                @if (!empty($customer_name) || !empty($customer_address))
                                    <div style="display: flex;flex-direction: column;">
                                        <span
                                            style="color: #002052;font-size:9px;font-weight:400;font-family: Poppins;">
                                            Invoice To
                                        </span>
                                        @if (!empty($customer_name))
                                            <p
                                                style="color:#7E0E53;font-size:12px;font-weight:600;font-family: Poppins;margin: 0px;">
                                                {{ $customer_name }}
                                            </p>
                                        @endif
                                        @if (!empty($customer_address))
                                            <p
                                                style="color:#847E99;font-size:8px;font-weight:400;font-family: Poppins;margin: 0px;">
                                                {!! nl2br(e($customer_address)) !!}
                                            </p>
                                        @endif
                                    </div>
                                @endif

                                <!-- Customer Contact -->
                                @if (!empty($customer_phone) || !empty($customer_email))
                                    <div>
                                        @if (!empty($customer_phone))
                                            <p
                                                style="color: #847E99;font-size:8px;font-weight:400;font-family: Poppins;margin: 0px;">
                                                <b style="color:#7C53FA;">P:</b> {{ $customer_phone }}
                                            </p>
                                        @endif
                                        @if (!empty($customer_email))
                                            <p
                                                style="color: #847E99;font-size:8px;font-weight:400;font-family: Poppins;margin: 0px;">
                                                <b style="color:#7C53FA;">E:</b> {{ $customer_email }}
                                            </p>
                                        @endif
                                    </div>
                                @endif

                                <!-- Invoice From -->
                                @if (!empty($company_name) || !empty($company_number) || !empty($company_address))
                                    <div style="display: flex;flex-direction: column;margin-top:20px;">
                                        <span
                                            style="color: #002052;font-size:9px;font-weight:400;font-family: Poppins;">
                                            Invoice From
                                        </span>
                                        @if (!empty($company_name))
                                            <p
                                                style="color:#7E0E53;font-size:11px;font-weight:600;font-family: Poppins;margin: 0px;">
                                                {{ $company_name }}
                                            </p>
                                        @endif
                                        @if (!empty($company_number) || !empty($company_address))
                                            <p
                                                style="color:#847E99;font-size:8px;font-weight:400;font-family: Poppins;margin: 0px;">
                                                @if (!empty($company_number))
                                                    Company number {{ $company_number }}<br>
                                                @endif
                                                @if (!empty($company_address))
                                                    {!! nl2br(e($company_address)) !!}
                                                @endif
                                            </p>
                                        @endif
                                    </div>
                                @endif

                                <!-- Company Contact -->
                                @if (!empty($company_phone) || !empty($company_email))
                                    <div>
                                        @if (!empty($company_phone))
                                            <p
                                                style="color: #847E99;font-size:8px;font-weight:400;font-family: Poppins;margin: 0px;">
                                                <b style="color:#7C53FA;">P:</b> {{ $company_phone }}
                                            </p>
                                        @endif
                                        @if (!empty($company_email))
                                            <p
                                                style="color: #847E99;font-size:8px;font-weight:400;font-family: Poppins;margin: 0px;">
                                                <b style="color:#7C53FA;">E:</b> {{ $company_email }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </td>

                        <td style="width:20px;">

                        </td>
                        <td style="display: flex;vertical-align: top;padding: 0px;">
                            <table border="0" style="border-collapse: collapse;" width="100%" >
                                <tr style="height:50px;border-bottom: 1px solid grey;">
                                    <td style="width: 200px;padding-left: 10px;">
                                        <p
                                            style="color:#002052;font-size:10px;font-weight:600;font-family: Poppins;margin: 0px;">
                                            PRODUCT
                                        </p>
                                    </td>
                                    <td style="width: 70px;padding: 0px;">
                                        <p
                                            style="color: #002052;font-size:11px;font-weight:600;font-family: Poppins;margin: 0px;text-align: center;border-bottom:3px solid #7E0E53;height:50px;display: flex;justify-content: center;align-items: center;">
                                            QTY
                                        </p>
                                    </td>
                                    <td style="width:100px;padding: 0px;">
                                        <p
                                            style="color: #002052;font-size:11px;font-weight:600;font-family: Poppins;margin: 0px;text-align: center;border-bottom:3px solid #7E0E53;height:50px;display: flex;justify-content: center;align-items: center;">
                                            PRICE
                                        </p>
                                    </td>
                                </tr>
                                @foreach ($products as $index => $product)
                                    <tr style="border-bottom: 1px solid grey;">
                                        <td style="width: 200px;padding: 10px;display: flex;flex-direction: column;">
                                            <p
                                                style="color:#414042;font-size:10px;font-weight:600;font-family: Poppins;margin: 0px;">
                                                {{ $product->name ?? 'N/A' }}
                                            </p>
                                            <span
                                                style="color:#847E99;font-size:8px;font-weight:600;font-family: Poppins;margin: 0px;">
                                                {{ $product->credits ?? 0 }} Credits
                                            </span>
                                        </td>
                                        <td style="width: 70px;background: #e6e5e5;padding: 10px;">
                                            <p
                                                style="color: #847E99;font-size:9px;font-weight:400;font-family: Poppins;margin: 0px;text-align: center;">
                                                01
                                            </p>
                                        </td>
                                        <td style="width:100px;background: #e6e5e5;padding: 10px;">
                                            <p
                                                style="color: #847E99;font-size:12px;font-weight:400;font-family:Roboto Light;margin: 0px;text-align: center;">
                                                {{ site_currency_code() }}{{ number_format($product->price, 2) }}
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr style="height: 50px;">
                                    <td style="width: 200px;text-align: right;">
                                        <p
                                            style="color:#77787B;font-size:10px;font-weight:400;font-family: Poppins;margin: 0px;text-transform: uppercase;padding-right: 20px;">
                                            SUB TOTAl
                                        </p>
                                    </td>
                                    <td style="background: #e6e5e5;padding: 10px;text-align: right;" colspan="2">
                                        <p
                                            style="color: #77787B;font-size:10px;font-weight:400;font-family:Roboto Light;margin: 0px;padding-right: 10px;">
                                            {{ site_currency_code() }}
                                            {{ number_format($invoice_amount + $discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr style="height: 50px;border-bottom: 1px solid grey;">
                                    <td style="width: 200px;text-align: right;">
                                        <p
                                            style="color:#77787B;font-size:10px;font-weight:400;font-family: Poppins;margin: 0px;text-transform: uppercase;padding-right: 20px;">
                                            DISCOUNT
                                        </p>
                                    </td>
                                    <td style="background: #e6e5e5;padding: 10px;text-align: right;border-bottom:3px solid #7E0E53;"
                                        colspan="2">
                                        <p
                                            style="color: #77787B;font-size:10px;font-weight:400;font-family:Roboto Light;margin: 0px;padding-right: 10px;">
                                            {{ site_currency_code() }} {{ number_format($discount_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td style="width: 200px;text-align: right;">
                                        <p
                                            style="color:#7E0E53;font-size:12px;font-weight:700;font-family: Poppins;margin: 0px;text-transform: uppercase;padding-right: 20px;">
                                            TOTAl
                                        </p>
                                    </td>
                                    <td style="padding: 10px;text-align: right;" colspan="2">
                                        <p
                                            style="color: #7E0E53;font-size:16px;font-weight:700;font-family:Roboto Light;margin: 0px;padding-right: 10px;">
                                            {{ site_currency_code() }} {{ number_format($invoice_amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Content End-->


        <!-----------Footer----------->
        <!-- <tr>
            <td align="center" class="footer_bg">
                <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;">
                    <tr>
                        <td style="padding-left:40px ;vertical-align: bottom;padding-bottom:20px;">
                            <img src="{{ $invoice_footer_image }}" alt="" style="height: 40px;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr> -->
        <div class="footer_bg" style="background-color: #f5f5f5; text-align: center;">
            <div style="width: 100%; padding-left: 40px; padding-bottom: 20px; display: flex; align-items: flex-end;">
                <img src="{{ $invoice_footer_image }}" alt="" style="height: 40px;">
            </div>
        </div>

    </table>
    </td>
    </tr>
    </table>
</body>

</html>
