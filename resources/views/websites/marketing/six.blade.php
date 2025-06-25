<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>

  <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #ffffff;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 100%; margin: 0 auto; border: 1px solid #ccc;">

       <tr style="background: url('{{ $invoice_header_image }}'); background-repeat: no-repeat; background-size: cover; background-position: center;height: 100px;">
          <td style="padding: 50px 50px 50px 50px;">
          </td>
        </tr>

      <tr>
        <td style="padding: 20px 20px;">
          <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
            <tr style="background-color: #e0e0e0;">
              <td style="padding: 20px; border: 1px solid #000; text-align: center;">
                <table width="100%">
                  <tr>
                    <td style="font-weight: bold; font-size: 14px;">INVOICE #: {{ $invoice_number }}</td>
                    <td style="font-weight: bold; font-size: 14px;">DATE:{{ $invoice_date }}</td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      
      

      <!-- Billed To and From -->
      <tr>
        <td style="padding: 5px 20px 30px 20px;">
          <table width="100%">
            <tr>
              <td valign="top" width="50%" style="text-align: center;">
                <strong style="text-transform: uppercase;">Billed From:</strong><br/>
                {{ $site_name }}<br/>
                {{ $site->site_link }}<br/>
                {!! $company_address !!} 
                <strong>Email:</strong> {{ $company_email }} 
              </td>
              <td valign="top" width="50%" style="text-align: center;">
                <strong style="text-transform: uppercase;">Billed To:</strong><br/>
                  {{ $customer_name }}
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <!-- Items Table -->
      <tr>
        <td style="padding: 0 20px;">
        <div style="min-height: 550px !important;">
          <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
            <tr style="background-color: #e0e0e0; font-weight: bold; text-align: left;">
              <th style="border: 1px solid #000;">Item No.</th>
              <th style="border: 1px solid #000;">Package</th>
              <th style="border: 1px solid #000;">Duration</th>
              <th style="border: 1px solid #000;">Total</th>
            </tr>
            <!-- Table rows -->
            @foreach($products as $index => $product)
            <tr>
              <td style="border: 1px solid #000;">{{ $index + 1 }}</td>
              <td style="border: 1px solid #000;"> {{ $product->name }}</td>
              <td style="border: 1px solid #000;"> {{ $product->subscription ?? '-' }}</td>
              <td style="border: 1px solid #000;"> {{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</td>
            </tr>
            @endforeach
            <tr>
              <td style="border: none;"></td>
              <td style="border: none;"> </td>
              <td style="border: none;"> SUBTOTAL</td>
              <td style="border: none;">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}</td>
            </tr>
            <tr>
              <td style="border: none;"></td>
              <td style="border: none;"> </td>
              <td style="border: none;">DISCOUNT</td>
              <td style="border: none;"> {{ site_currency() }} {{ number_format($discount_amount ?? 0, 2) }}</td>
            </tr>
            <tr>
              <td style="border: none;"></td>
              <td style="border: none;"> </td>
              <td style="border: none;"> TOTAL DUE</td>
              <td style="border: none;"> {{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}</td>
            </tr>
            
          </table>
        </div>
        </td>
      </tr>

      <!-- Summary -->
    
      <tr style=" background: url('{{ $invoice_footer_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;height: 114px;">
        <td style=" padding: 30px; color: #ffffff; font-size: 12px; text-align: center;">
          Thank you for your business!
        </td>
      </tr>
    </table>
  </body>
</html>
