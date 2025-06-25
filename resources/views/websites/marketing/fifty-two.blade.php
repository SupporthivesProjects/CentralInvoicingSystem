<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #ffffff;">
  <table width="90%" cellpadding="0" cellspacing="0" border="0"
    style="max-width: 90%; margin: 0 auto; border: 1px solid #ccc;">
    <!-- Header with Logo -->
    <tr style=" background: url('{{ $invoice_header_image }}'); background-repeat: no-repeat;background-size: cover;background-position: center;height: 83px;">
      <td style="padding: 0px;">
      </td>
    </tr>

    <!-- Invoice Number and Date -->

    <tr>
        <td style="padding: 20px 30px;">
          <table width="100%">
            <tr>
              <td valign="top" style="width: 60%;">
                <p style="margin: 0; font-size: 18px; font-weight: bold; color: #000;">
                  {{ $site_name }} 
                </p>
                <p style="margin: 16px 0px 0px 0px; font-size: 14px; color: #333;"> {{ $site->site_link }} <br/>
                  {!! $company_address !!}<br/>
                  {{ $company_email }}
                </p>
              </td>
              <td align="right" valign="top" style="width: 40%;">
                <h2 style="margin: 0; font-size: 24px; color: #111;">INVOICE</h2>
                <p style="margin: 16px 0px 0px 0px; font-size: 14px;"><strong>Invoice:</strong> {{ $invoice_number }}<br />
                  <strong>Date:</strong>{{ $invoice_date }}</p>
              </td>
            </tr>
          </table>
        </td>
      </tr>


      <!-- Billed To -->
      <tr>
        <td style="padding: 0 30px 10px;">
          <p style="font-size: 14px;"><strong>To:</strong><br />{{ $customer_name }}</p>
        </td>
      </tr>


    <!-- Table -->
      <tr>
        <td style="padding: 10px 30px;">
        <div style="min-height: 500px !important;">
          <table width="100%" cellpadding="10" cellspacing="0" border="1" style="border-collapse: collapse; border: 1px solid #ccc; text-align: left;">
            <tr style="background-color: #f2f2f2;">
              <th style="border: 1px solid #ccc; font-size: 14px;">DESCRIPTION</th>
              <th style="border: 1px solid #ccc; font-size: 14px;">MONTHS</th>
              <th style="border: 1px solid #ccc; font-size: 14px;">RATE</th>
              <th style="border: 1px solid #ccc; font-size: 14px;">AMOUNT</th>
            </tr>
            @foreach($products as $product)
            <tr>
              <td style="border: 1px solid #ccc; font-size: 14px;">{{ $product->name }}</td>
              <td style="border: 1px solid #ccc; font-size: 14px;">{{ $product->subscription ?? '-' }}</td>
              <td style="border: 1px solid #ccc; font-size: 14px;">{{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</td>
              <td style="border: 1px solid #ccc; font-size: 14px;">{{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</td>
            </tr>
            @endforeach 
            <tr>
              <td colspan="3" style="border: 1px solid #ccc; font-size: 14px; text-align: right;"><strong>SUB TOTAL</strong></td>
              <td style="border: 1px solid #ccc; font-size: 14px;"><strong>{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}</strong></td>
            </tr>
            <tr>
              <td colspan="3" style="border: 1px solid #ccc; font-size: 14px; text-align: right;"><strong>DISCOUNT</strong></td>
              <td style="border: 1px solid #ccc; font-size: 14px;"><strong>{{ site_currency() }} {{ number_format($discount_amount ?? 0, 2) }}</strong></td>
            </tr>
            <tr>
              <td colspan="3" style="border: 1px solid #ccc; font-size: 14px; text-align: right;"><strong>TOTAL</strong></td>
              <td style="border: 1px solid #ccc; font-size: 14px;"><strong>{{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}</strong></td>
            </tr>
          </table>
      </div>
        </td>
      </tr>


    <!-- Note -->
      <tr>
        <td style="padding: 20px 30px; font-size: 14px;">
          Make all checks payable to <strong>{{ $site_name }}</strong><br /><br />
          <span style="font-variant: small-caps;">Thank you for your business!</span>
        </td>
      </tr>



    <!-- Footer -->



    <tr style=" background: url('{{ $invoice_footer_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;height: 75px;">
      <td style=" padding: 0px; color: #ffffff; font-size: 12px; text-align: center;">

      </td>
    </tr>
  </table>
</body>

</html>