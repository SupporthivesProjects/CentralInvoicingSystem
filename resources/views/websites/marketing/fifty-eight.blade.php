<!DOCTYPE html>
<html>
  <head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
  </head>
  <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #ffffff;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 90%; margin: 0 auto; border: 1px solid #ccc;">
       <tr style=" background: url('{{ $invoice_header_image }}'); background-repeat: no-repeat;background-size: cover;background-position: center;height: 130px;">
                <td style="padding: 50px 50px 50px 50px;">
                </td>
        </tr>
      
      <tr>
        <td style="padding: 0 20px;">
          <table width="100%" cellpadding="15" cellspacing="0" style="border-collapse: collapse; margin-top: 20px;">
            <tr style="background-color: #262938; color: #ffffff; font-weight: bold; font-size: 13px;">
              <td style="color: #ffffff; font-weight: bold; font-size: 14px;">INVOICE No.{{ $invoice_number }}</td>
              <td style="color: #ffffff; font-weight: bold; font-size: 14px; text-align: right;">DATE {{ $invoice_date }}</td>
            </tr>
            
          </table>
        </td>
      </tr>

      <!-- Billed To and From -->
      <tr>
        <td style="padding: 20px;">
          <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
              <td style="padding-left: 15px; font-size: 12px; color: #666666; text-transform: uppercase; font-weight: bold;">Billed To</td>
              <td style="padding-right: 15px; font-size: 12px; color: #666666; text-transform: uppercase; font-weight: bold; text-align: right;">Billed From</td>
            </tr>
            <tr>
              <td style="padding-left: 15px; padding-top: 4px;">{{ $customer_name }}</td>
              <td style="padding-right: 15px; padding-top: 4px; text-align: right;">
              {{ $company_name }}<br />
                <a href="https://www.digitaldolphinmarketing.com" style="color: #0066cc; text-decoration: none;">{{ $site->site_link }} </a>
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <!-- Items Table -->
      <tr>
        <td style="padding: 0 20px;">
          <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse; margin-top: 20px;">
            <tr style="background-color: #262938; color: #ffffff; font-weight: bold; font-size: 13px;">
              <th align="left">MONTHS</th>
              <th align="left">Description</th>
              <th align="right">Unit Price</th>
              <th align="right">Total</th>
            </tr>
            @foreach($products as $product)
            <tr style="border-bottom: 1px solid #e0e0e0;">
              <td>{{ $product->subscription ?? '-' }}</td>
              <td>{{ $product->name }}</td>
              <td align="right">{{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</td>
              <td align="right">{{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</td>
            </tr>
            @endforeach 
          </table>
        </td>
      </tr>

      <!-- Summary -->
      <tr>
        <td style="padding: 20px;">
        <div style="min-height: 300px !important;">
          <table width="100%" cellpadding="5" cellspacing="0">
            <tr>
              <td style="text-align: right; color: #888888;">SUBTOTAL</td>
              <td style="text-align: right; width: 100px;">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}</td>
            </tr>
            <tr>
              <td style="text-align: right; color: #888888;">DISCOUNT</td>
              <td style="text-align: right;">{{ site_currency() }} {{ number_format($discount_amount ?? 0, 2) }}</td>
            </tr>
            <tr>
              <td style="text-align: right; color: #000000; font-weight: bold; font-size: 16px;">TOTAL</td>
              <td style="text-align: right; font-weight: bold; color: #0073e6; font-size: 16px;">{{ site_currency() }} {{ number_format(($invoice_amount) ?? 0, 2) }}</td>
            </tr>
          </table>
        </div>
        </td>
      </tr>

      <tr style=" background: url('{{ $invoice_footer_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;height: 130px;">
        <td style=" padding: 30px; color: #ffffff; font-size: 12px; text-align: center;">
         {{ $company_email }}|
          <a href="{{ $site->site_link }}" style="color: #ffffff; text-decoration: underline;">{{ $site->site_link }} </a><br /><br/>
          {{ $company_name }}<br /><br />
          {!! $company_address !!}
        </td>
      </tr>
    </table>
  </body>
</html>
