<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .footer-fixed {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 45px;
            background: url('{{ $invoice_header_image }}') center center no-repeat;
            background-size: cover;
        }
        .footer-fixed-2 {
            position: fixed;
            bottom: 60px;
            left: 0;
            right: 0;
        }
    </style>
  </head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #ffffff;">
  <table width="100%" cellpadding="0" cellspacing="0" border="0"
    style="max-width: 100%; margin: 0 auto; border: 1px solid #ccc;">
    <!-- Header with Logo -->
    <tr style=" background: url('{{ $invoice_header_image }}');background-repeat: no-repeat; background-size: cover;background-position: center;height: 134px;">
      <td style="padding: 65px 0px 10px 24px;">
        <img src="{{ $company_logo }}" alt="" width="166px">
      </td>
    </tr>

    <!-- Invoice Number and Date -->

    <tr>
      <td style="padding: 20px;">
        <table width="100%" style="font-size:14px;">
          <tr>
            <td colspan="3" style="border-top: 2px solid #2E75B5; border-bottom: 2px solid #2E75B5; padding: 8px 0px;">
              <strong>Invoice To:</strong><br />
              {{ $customer_name }}
            </td>

            <td align="right" rowspan="2">
              <p style="margin: 0px; font-size: 30px; text-align: right; margin-bottom: 8px; font-weight: bold;">INVOICE
              </p><br>
              <p style="margin: 0px; font-size: 10px; text-align: right; margin-bottom: 4px;">Invoice Date: {{ $invoice_date }}
              </p>
              <p style="margin: 0px; font-size: 10px; text-align: right; margin-bottom: 4px;">Invoice No: #{{ $invoice_number }}</p>
              <p style="margin: 0px; font-size: 13px; text-align: right;"><strong>Due Amount</strong><br>
                <span style="font-size: 18px; font-weight: bold;">{{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}</span>
              </p>


            </td>
          </tr>
          <tr>
            <td style="font-size: 10px; text-align: left; line-height: 16px;">
              <strong>Invoice From:<br />
              {{ $site_name }}</strong><br />
            </td>
            <td style="font-size: 10px; text-align: center;">
            {{ $company_email }}
            </td>
            <td style="font-size: 10px; text-align: center;">
            {!! $company_address !!}
            </td>
          </tr>
        </table>
      </td>
    </tr>



    <tr>
      <td style="padding: 0 20px 20px 20px;">
        <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse; font-size: 14px;">
          <tr style="color: white;">
            <th style="background-color: #327ac2;" align="left">Package Name</th>
            <th style="background-color: #0E0E0E;" align="center">Quanity</th>
            <th style="background-color: #0E0E0E;" align="center">Length</th>
            <th style="background-color: #0E0E0E;" align="right">Amount</th>
          </tr>
          @foreach($products as $product)
          <tr style="border-bottom: 1px solid #ccc;">
            <td><span style="font-weight: 700;font-size: 9px;">{{ $product->name }}</span></td>
            <td style="font-size: 10px;" align="center">1</td>
            <td style="font-size: 10px;" align="center">{{ $product->subscription ?? '-' }}</td>
            <td style="font-size: 10px;" align="right">{{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</td>
          </tr>
          @endforeach 
        </table>
      </td>
    </tr>



    <!-- Summary -->
    <tr>
      <td style="padding: 20px;">
        <table width="100%" cellpadding="5" cellspacing="0" style="max-width: 250px; float: right;">
          <tr>
            <td style="text-align: right;">SUBTOTAL</td>
            <td style="text-align: right;">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}</td>
          </tr>
          <tr>
            <td style="text-align: right;">SALES TAX</td>
            <td style="text-align: right;">{{ site_currency(). 0.00 }}</td>
          </tr>
          <tr>
            <td style="text-align: right;">DISCOUNT</td>
            <td style="text-align: right;">{{ site_currency() }} {{ number_format($discount_amount ?? 0, 2) }}</td>
          </tr>
          <tr style="background-color: #327ac2;color: white;">
            <td style="text-align: right; font-weight: bold;">TOTAL DUE</td>
            <td style="text-align: right; font-weight: bold;">{{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}</td>
          </tr>
        </table>
      </td>
    </tr>


    <tr class="footer-fixed-2">
      <td style="padding: 30px 20px;">
        <table width="100%" style="text-align: center; font-size: 13px; color: #444;">
          <tr>
            <td>
              <img src="{{ $invoice_image1 }}" width="20" style="vertical-align:middle; margin-bottom: 8px;" /> <br />
              <strong>Address</strong><br />
              {!! $company_address !!}
            </td>
            <td style="width: 20%;">
              
            </td>
            <td>
              <img src="{{ $invoice_image2 }}" width="20" style="vertical-align:middle; margin-bottom: 8px;" /> <br />
              <strong>Email</strong><br />
              {{ $company_email }}
            </td>
            <td style="width: 20%;">
              
            </td>
            <td>
              <img src="{{ $invoice_image3 }}" width="20" style="vertical-align:middle; margin-bottom: 8px;" /> <br />
              <strong>Website</strong><br />
              <a href="{{ $site->site_link }}" style="color: #000000">Brandbeknown.com</a>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <div class="footer-fixed"></div>

    <!-- Footer -->



    <!-- <tr style=" background: url('{{ $invoice_header_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;height: 45px;">
      <td style=" padding: 0px; color: #ffffff; font-size: 12px; text-align: center;">

      </td>
    </tr> -->
    <!-- Original Footer Row (Hidden for PDF rendering) -->
    <tr>
      <td style="display:none;"></td>
    </tr>
    <!-- Footer End -->   
  </table>

   <!-- Footer absolutely fixed for PDF -->
   
</body>

</html>