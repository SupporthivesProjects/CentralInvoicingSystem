<!DOCTYPE html>
<html>
<head>
    <title>Your Email Title</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 20px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Content -->
                    <tr style="background:#ffff ;">
                        <td>
                            <table border="0" style="border-collapse: collapse;width: 100%;">
                                  <tr align="right">
                                    <td style="background: url('{{ $invoice_image1 }}');background-position: center;background-size: cover;background-repeat: no-repeat;padding:40px;width: 40%;vertical-align: top;">
                                       <h1 style="margin: 0px;font-family: Calibri;font-size: 40px;color:#414042;">INVOICE</h1>
                                       <table style="height:90px;"></table>
                                       <table border="0" style="border-collapse: collapse;width: 100%;">
                                            <tr>
                                                <td>
                                                    <h2 style="margin: 0px;font-family: Calibri;font-size:10px;color:#414042;">DATE</h2>
                                                    <p style="margin: 0px;font-family: Calibri;font-size:8px;color: #808080;">{{ $invoice_date }}</p>
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 1px solid #808080;height:14px;"></tr>
                                            <tr style="height:14px;"></tr>
                                             <tr>
                                                <td>
                                                    <h2 style="margin: 0px;font-family: Calibri;font-size:10px;color:#414042;">BILLED TO</h2>
                                                    <p style="margin: 0px;font-family: Calibri;font-size:8px;color: #414042;font-weight:600;">{{ $customer_name }}</p>
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 1px solid #808080;height:14px;"></tr>
                                            <tr style="height:14px;"></tr>
                                             <tr>
                                                <td>
                                                    <h2 style="margin: 0px;font-family: Calibri;font-size:10px;color:#414042;">BILLED FROM</h2>
                                                </td>
                                            </tr>
                                            <tr style="height:14px;"></tr>
                                            <tr>
                                                <td>
                                                     <h2 style="margin: 0px;font-family: Calibri;font-size:8px;color:#414042;">{{ $site_name }}</h2><br>
                                                     <p style="margin: 0px;font-family: Calibri;font-size:8px;color: #808080;">
                                                        {{ $company_address }}<br>
                                                        {{ $company_mobile }}
                                                     </p>
                                                          <a href="mailto:{{ $company_email }}" target="_blank" style="margin: 0px;font-family: Calibri;font-size:8px;color: #808080;text-decoration: underline;">
                                                       {{ $company_email }}
                                                     </a>

                                                </td>
                                            </tr>
                                       </table>
                                    </td>
                                    <td align="right" style="padding:40px;padding-left: 10px;vertical-align: top;">
                                       <img src="{{ $company_logo }}" alt="" style="height: 100px;">
                                       <h2 style="margin: 0px;font-family: Calibri;font-size:8px;color:#414042;">Invoice No. # {{$invoice_number}}</h2><br>
                                       <div style="min-height: 540px !important;">
                                       <table border="0" style="border-collapse: collapse;width: 100%;">
                                          <tr style="background-color: #19346F;">
                                               <td style="padding: 10px;">
                                                <h1 style="margin: 0px;font-family: Calibri;font-size:8px;color: #ffffff;">SERVICES</h1>
                                               </td>
                                               <td style="padding: 10px;" align="right">
                                                <h1 style="margin: 0px;font-family: Calibri;font-size:8px;color: #ffffff;">QTY</h1>
                                               </td>
                                               <td style="padding: 10px;" align="right">
                                                <h1 style="margin: 0px;font-family: Calibri;font-size:8px;color: #ffffff;">IMAGES</h1>
                                               </td>
                                               <td style="padding: 10px;" align="right">
                                                <h1 style="margin: 0px;font-family: Calibri;font-size:8px;color: #ffffff;">TOTAL</h1>
                                               </td>
                                          </tr>
                                          @foreach($products as $product)
                                          <tr style="background-color: #F4F4F4;">
                                               <td style="padding: 10px;">
                                                <h1 style="margin: 0px;font-family: Calibri;font-size:8px;color:#414042;">{{ $product->name }}</h1>
                                               </td>
                                               <td style="padding: 10px;" align="right">
                                                <h1 style="margin: 0px;font-family: Calibri;font-size:8px;color:#414042;">1</h1>
                                               </td>
                                               <td style="padding: 10px;" align="right">
                                                <h1 style="margin: 0px;font-family: Calibri;font-size:8px;color: #414042;">{{ $product->imagecount ?? '0' }}</h1>
                                               </td>
                                               <td style="padding: 10px;" align="right">
                                                <h1 style="margin: 0px;font-family: Calibri;font-size:8px;color:#414042;">{{ site_currency() }} {{ number_format($product->unit_price, 2) }}</h1>
                                               </td>
                                          </tr>
                                          <tr style="height: 50px;">
                                               <td style="padding: 10px;" colspan="4">
                                                <p style="margin: 0px;font-family: Calibri;font-size:8px;color:#414042;">{{ $product->turnaround ?? '0' . "-" . $product->quantity ?? 'N/A' }}</p>
                                               </td>
                                          </tr>
                                          @endforeach
                                          <tr>
                                               <td style="padding: 10px;" colspan="2"></td>
                                               <td style="padding: 10px;" align="right">
                                                <h1 style="margin: 0px;font-family: Calibri;font-size:8px;color: #414042;font-weight: 300;">Subtotal.</h1>
                                               </td>
                                               <td style="padding: 10px;" align="right">
                                                <h1 style="margin: 0px;font-family: Calibri;font-size:8px;color:#414042;font-weight: 300;">{{ site_currency() }} {{ number_format($invoice_amount + $discount_amount, 2) }}</h1>
                                               </td>
                                          </tr>
                                          <tr style="border-bottom: 1px solid #414042;">
                                               <td style="padding: 10px;" colspan="2"></td>
                                               <td style="padding: 10px;" align="right">
                                                <h1 style="margin: 0px;font-family: Calibri;font-size:8px;color: #414042;font-weight: 300;">Discount.</h1>
                                               </td>
                                               <td style="padding: 10px;" align="right">
                                                <h1 style="margin: 0px;font-family: Calibri;font-size:8px;color:#414042;font-weight: 300;">{{ site_currency() }} {{ number_format($discount_amount, 2) }}</h1>
                                               </td>
                                          </tr>
                                          <tr>
                                               <td style="padding: 10px;" colspan="2"></td>
                                               <td style="padding: 10px;" align="right">
                                                <h1 style="margin: 0px;font-family: Calibri;font-size:8px;color: #414042;">Total</h1>
                                               </td>
                                               <td style="padding: 10px;" align="right">
                                                <h1 style="margin: 0px;font-family: Calibri;font-size:8px;color:#414042;">{{ site_currency() }} {{ number_format($invoice_amount, 2) }}</h1>
                                               </td>
                                          </tr>
                                       </table>
                                       </div>
                                    </td>
                                  </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End-->
                    <!-----------Footer----------->
                    <tr>
                        <td align="center" style="height:50px;background: #19346F;">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;">

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
