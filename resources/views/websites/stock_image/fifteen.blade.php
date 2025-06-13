<!DOCTYPE html>
<html>
<head>
    <title>Your Email Title</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<style>
    .footer_bg {
        background:url('{{ $invoice_image1 }}');
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        height:150px;
        vertical-align: bottom;
    }
</style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);max-width: 600px;">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;">
                            <table style="border-collapse: collapse;width: 100%;" border="0">
                                    <td style="padding: 40px;vertical-align: top;">
                                        <div style="display: flex;width: 100%;justify-content: space-between;vertical-align: top;">
                                          <img src="{{ $company_logo }}" alt="" style="height: 60px;">
                                          <div>
                                            <h1 style="margin: 0px;font-family: Poppins;font-size: 16px;text-align: right; margin-right: 80px;">
                                                INVOICE NO: #{{ $invoice_number }}
                                            </h1>
                                            <p style="margin: 0px;font-family: Poppins;font-size: 12px;text-align: right; margin-right: 80px">
                                                {{ \Carbon\Carbon::parse($invoice_date)->format('d M Y') }}
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
                    <tr>
                        <td style="padding:40px;vertical-align: top;">
                            <table cellspacing="0" cellpadding="0" border="0" width="100%" style="border-collapse: collapse;">
                                <tr>
                                    <td style="vertical-align: top;">
                                       <div style="display: flex;flex-direction: column;gap:20px;">
                                          <div style="display: flex;flex-direction: column;">
                                             <span style="color: #002052;font-size:10px;font-weight:600;font-family: Poppins;">
                                                TOTAL DUES:
                                             </span>
                                             <p style="color:#7E0E53;font-size:24px;font-weight:400;font-family: Poppins;margin: 0px;">
                                               {{ site_currency_code() }}{{ number_format($invoice_amount, 2) }}
                                             </p>
                                          </div>
                                          <div style="display: flex;flex-direction: column;">
                                             <span style="color: #002052;font-size:9px;font-weight:400;font-family: Poppins;">
                                                Invoice To
                                             </span>
                                             <p style="color:#7E0E53;font-size:12px;font-weight:600;font-family: Poppins;margin: 0px;">
                                                {{ $customer_name }}
                                             </p>
                                             <p style="color:#847E99;font-size:8px;font-weight:400;font-family: Poppins;margin: 0px;">
                                               Insert Full Address <br> Detail Here, City, <br> State, Zip Code
                                             </p>
                                          </div>
                                          <div>
                                           <p style="color: #847E99;font-size:8px;font-weight:400;font-family: Poppins;margin: 0px;">
                                            <b style="color:#7C53FA;">P:</b> +44 124 567 89
                                            </p>
                                          <p style="color: #847E99;font-size:8px;font-weight:400;font-family: Poppins;margin: 0px;">
                                            <b style="color:#7C53FA;">E:</b> info@email.com
                                            </p>
                                          </div>

                                          <div style="display: flex;flex-direction: column;margin-top:20px;">
                                             <span style="color: #002052;font-size:9px;font-weight:400;font-family: Poppins;">
                                                Invoice From
                                             </span>
                                             <p style="color:#7E0E53;font-size:11px;font-weight:600;font-family: Poppins;margin: 0px;">
                                                ImageVault ltd
                                             </p>
                                              <p style="color:#847E99;font-size:8px;font-weight:400;font-family: Poppins;margin: 0px;">
                                               Company number 1234 <br>
123 street, somewhere road,
Someplace city, 123 ABC
                                             </p>
                                          </div>
                                          <div>
                                           <p style="color: #847E99;font-size:8px;font-weight:400;font-family: Poppins;margin: 0px;">
                                            <b style="color:#7C53FA;">P:</b> +44 124 567 89
                                            </p>
                                          <p style="color: #847E99;font-size:8px;font-weight:400;font-family: Poppins;margin: 0px;">
                                            <b style="color:#7C53FA;">E:</b> info@email.com
                                            </p>
                                          </div>
                                       </div>
                                    </td>
                                    <td style="width:20px;">

                                    </td>
                                    <td style="display: flex;vertical-align: top;padding: 0px;">
                                        <table border="0" style="border-collapse: collapse;">
                                            <tr style="height:50px;border-bottom: 1px solid grey;">
                                                <td style="width: 200px;padding-left: 10px;">
                                                    <p style="color:#002052;font-size:10px;font-weight:600;font-family: Poppins;margin: 0px;">
                                                       PRODUCT
                                                    </p>
                                                </td>
                                                <td style="width: 70px;padding: 0px;">
                                                    <p style="color: #002052;font-size:11px;font-weight:600;font-family: Poppins;margin: 0px;text-align: center;border-bottom:3px solid #7E0E53;height:50px;display: flex;justify-content: center;align-items: center;">
                                                        QTY
                                                    </p>
                                                </td>
                                                <td style="width:100px;padding: 0px;">
                                                    <p style="color: #002052;font-size:11px;font-weight:600;font-family: Poppins;margin: 0px;text-align: center;border-bottom:3px solid #7E0E53;height:50px;display: flex;justify-content: center;align-items: center;">
                                                        PRICE
                                                    </p>
                                                </td>
                                            </tr>
                                            @foreach($products as $index => $product)
                                            <tr style="border-bottom: 1px solid grey;">
                                                <td style="width: 200px;padding: 10px;display: flex;flex-direction: column;">
                                                    <p style="color:#414042;font-size:10px;font-weight:600;font-family: Poppins;margin: 0px;">
                                                        {{ $product->name ?? 'N/A' }}
                                                    </p>
                                                    <span style="color:#847E99;font-size:8px;font-weight:600;font-family: Poppins;margin: 0px;">
                                                        {{ $product->credits ?? 0 }} Credits
                                                    </span>
                                                </td>
                                                <td style="width: 70px;background: #e6e5e5;padding: 10px;">
                                                    <p style="color: #847E99;font-size:9px;font-weight:400;font-family: Poppins;margin: 0px;text-align: center;">
                                                        01
                                                    </p>
                                                </td>
                                                <td style="width:100px;background: #e6e5e5;padding: 10px;">
                                                    <p style="color: #847E99;font-size:12px;font-weight:400;font-family:Roboto Light;margin: 0px;text-align: center;">
                                                       {{ site_currency_code() }}{{ number_format($product->price, 2) }}
                                                    </p>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr style="height: 50px;">
                                                <td style="width: 200px;text-align: right;">
                                                    <p style="color:#77787B;font-size:10px;font-weight:400;font-family: Poppins;margin: 0px;text-transform: uppercase;padding-right: 20px;">
                                                        SUB TOTAl
                                                    </p>
                                                </td>
                                                <td style="background: #e6e5e5;padding: 10px;text-align: right;" colspan="2">
                                                    <p style="color: #77787B;font-size:10px;font-weight:400;font-family:Roboto Light;margin: 0px;padding-right: 10px;">
                                                       {{ site_currency_code() }} {{ number_format($invoice_amount + $discount_amount, 2) }}
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr style="height: 50px;border-bottom: 1px solid grey;">
                                                <td style="width: 200px;text-align: right;">
                                                    <p style="color:#77787B;font-size:10px;font-weight:400;font-family: Poppins;margin: 0px;text-transform: uppercase;padding-right: 20px;">
                                                        DISCOUNT
                                                    </p>
                                                </td>
                                                <td style="background: #e6e5e5;padding: 10px;text-align: right;border-bottom:3px solid #7E0E53;" colspan="2">
                                                    <p style="color: #77787B;font-size:10px;font-weight:400;font-family:Roboto Light;margin: 0px;padding-right: 10px;">
                                                       {{ site_currency_code() }} {{ number_format($discount_amount, 2) }}
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr style="height: 50px;">
                                                <td style="width: 200px;text-align: right;">
                                                    <p style="color:#7E0E53;font-size:12px;font-weight:700;font-family: Poppins;margin: 0px;text-transform: uppercase;padding-right: 20px;">
                                                        TOTAl
                                                    </p>
                                                </td>
                                                <td style="padding: 10px;text-align: right;" colspan="2">
                                                    <p style="color: #7E0E53;font-size:16px;font-weight:700;font-family:Roboto Light;margin: 0px;padding-right: 10px;">
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
                    <tr>
                        <td align="center" class="footer_bg">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;">
                                <tr>
                                   <td style="padding-left:40px ;vertical-align: bottom;padding-bottom:20px;">
                                    <img src="{{ $invoice_footer_image }}" alt="" style="height: 40px;">
                                   </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
