<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
      body {
        margin: 0px;
        padding: 0px;

      }
    </style>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #ffffff;">
  <table width="100%" cellpadding="0" cellspacing="0" border="0"
    style="max-width: 100%; margin: 0 auto; border: 1px solid #ccc;">
    <!-- Header with Logo -->
    <tr style=" background: url('{{ $invoice_header_image }}'); background-repeat: no-repeat; background-size: cover;background-position: center;height: 83px;">
      <td style="padding: 0px;">
      </td>
    </tr>

    <!-- Company Info -->
     <tr>
      <td colspan="2" style="padding: 20px;">
        <table width="100%" style="font-size: 14px;">
          <tr>
            <td style="color: #1a1a1a;">
            </td>
            <td align="right">
              <h2 style="color: #f39c12; margin: 0;">INVOICE</h2>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="2" style="padding: 20px;">
        <table width="100%" style="font-size: 14px; ">
          <tr>
            <td style="color: #1a1a1a;">
             {!! $company_address !!}
              {{ $company_mobile  }}<br>
              <a href="mailto:{{ $company_email }}" style="color: #0044cc;">{{ $company_email }}</a> | <a href="{{ $site->site_link }}" style="color: #0044cc;">{{ $site->site_link }}</a>
            </td>
            <td align="right" valign="top">
              <p style="margin: 0px 0px 5px 0;"><strong style="color: #f39c12;">INVOICE #</strong> {{ $invoice_number }} </p>
              <p style="margin: 0 0 5px 0;"><strong style="color: #f39c12;">DATE</strong> {{ $invoice_date }}</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- Recipient Info -->
    <tr>
      <td colspan="2" style="padding: 0 20px 20px;">
        <strong>TO</strong><br>
        {{ $customer_name }}<br>
        {{ $customer_email }}
      </td>
    </tr>

    <!-- Item Table -->
    <tr>
      <td colspan="2" style="padding: 0 20px;">
      <div style="min-height: 500px !important;">
        <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse; font-size: 14px;border: 1px solid #ddd;">
          <tr style="color: #f39c12; font-weight: bold;border-bottom: 1px solid #ddd;">
            <th align="left" style="border-right: 1px solid #ddd;width: 70%;">Description</th>
            <th align="right">Amount</th>
          </tr>
          @foreach($products as $index => $product)
          <tr style="border-bottom: 1px solid #ddd;">
            <td style="border-right: 1px solid #ddd;width: 70%;">
            {{ $product['name'] }}<br>
                @if (isset($product['platform_fields']) && isset($product['selected_platform']))
                    <div style="margin-top:4px;">
                        <em style="font-size:9px;">{{ $product['selected_platform'] }}:</em><br>
                        @foreach($product['platform_fields'][$product['selected_platform']] as $fieldName => $value)
                            <span style="font-size:9px; margin-left:8px;">
                                {{ ucfirst(str_replace('_',' ',$fieldName)) }}: {{ $value }}
                            </span><br>
                        @endforeach 
                       
                    </div>
                @endif <br>
                {{ $product['game_currency_amount'] }} {{ $product['game_currency'] }}
            </td>
            <td align="right"><strong>{{ $currency . number_format($product['unit_price'], 2) }}</strong></td>
          </tr>
          @endforeach
          <tr style="border-bottom: 1px solid #ddd;">
            <td style="border-right: 1px solid #ddd;width: 70%;">Subtotal</td>
            <td align="right"><strong>{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</strong></td>
          </tr>
          <tr style="border-bottom: 1px solid #ddd;">
            <td style="border-right: 1px solid #ddd;width: 70%;">Discount</td>
            <td align="right"><strong>{{ site_currency() . number_format($discount_amount, 2) }}</strong></td>
          </tr>
         
          <tr style="color: #f39c12;">
            <td style="border-right: 1px solid #ddd;width: 70%;"><strong>Total</strong></td>
            <td align="right"><strong>{{ site_currency() . number_format($invoice_amount, 2) }}</strong></td>
          </tr>
        </table>
      </div>
      </td>
    </tr>

    <!-- Footer -->
    <tr>
      <td colspan="2" style="padding: 30px 20px 10px; text-align: center; font-size: 13px;">
        Make all checks payable to <strong>{{ $site_name }}</strong><br>
        Payment is due within 30 days.<br>
        If you have any questions concerning this invoice, contact at {{ $company_email }}
      </td>
    </tr>

    <tr>
      <td colspan="2" style="color: #f39c12; padding: 20px; text-align: center; font-weight: bold;">
        THANK YOU FOR YOUR BUSINESS!
      </td>
    </tr>

    <!-- Footer -->



    <tr style=" background: url('{{ $invoice_footer_image }}')background-repeat: no-repeat; background-size: cover;background-position: center;height: 75px;">
      <td style=" padding: 0px; color: #ffffff; font-size: 12px; text-align: center;">

      </td>
    </tr>
  </table>
</body>

</html>