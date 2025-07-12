<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #ffffff;">
  <table width="100%" cellpadding="0" cellspacing="0" border="0"
    style="max-width: 90%; margin: 0 auto; border: 1px solid #ccc;">
    <!-- Header with Logo -->
    <tr style=" background: url('{{ $invoice_header_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;height: 83px;">
      <td style="padding: 0px;">
      </td>
    </tr>

    <!-- Title Section -->
      <tr>
        <td align="center" style="padding: 40px 20px 0px 20px;">
          <table width="100%" style="font-size: 14px;border: 1px solid #D8292F;border-bottom: 0px;">
            <tr>
              <td style="padding: 20px 0px;">
                <h2 style="margin: 0; font-size: 28px; color: #D8292F;text-align: center;">INVOICE</h2>
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <!-- Info Section -->
      <tr>
        <td style="padding: 0px 20px 20px 20px;">
          <table width="100%" style="font-size: 14px;border: 1px solid #D8292F;">
            <tr>
              <td style="width: 60%; vertical-align: top;">
                <p style="margin: 0 0 8px 0;color:#111111;"><strong style="color: #D8292F;">Date:</strong> {{ $invoice_date }}</p>
                <p style="margin: 0 0 8px 0;color:#111111;"><strong style="color: #D8292F;">Invoice #:</strong> {{ $invoice_number }}</p>
              </td>
              <td style="width: 10%; vertical-align: top;border-left: 1px solid #D8292F;">
                <p style="margin: 0 0 8px 0;color: #D8292F;"><strong>To:</strong></p>
              </td>
              <td style="width: 40%; vertical-align: top;border-left: 1px solid #D8292F;">
                <p style="margin: 0 0 8px 0;text-align: right;">{{ $customer_name }}<br/>
                {{ $customer_email }}</p>
              </td>
            </tr>
          </table>
        </td>
      </tr>

    
      <tr>
        <td style="padding: 0 20px;">
          <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
            <tr style="font-weight: bold; text-align: left;">
              <th align="left" style="color: #D8292F;border: 1px solid #000;">QTY</th>
              <th align="left" style="color: #D8292F;border: 1px solid #000;">DESCRIPTION</th>
              <th align="right" style="color: #D8292F;border: 1px solid #000;">CURRENCY AMOUNT</th>
              <th align="right" style="color: #D8292F;border: 1px solid #000;">LINE TOTAL</th>
            </tr>
            @php 
              $maxrow = 8;
              $currentRowCount = count($products); 
              $padrow = $maxrow - $currentRowCount;
          @endphp

          @foreach($products as $index => $product)
          <tr>
              <td style="border: 1px solid #000;">1</td>
              <td style="border: 1px solid #000;"> 
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
                  @endif 
              </td>
              <td align="right" style="border: 1px solid #000;">{{ $product['game_currency_amount'] }} {{ $product['game_currency'] }}</td>
              <td align="right" style="border: 1px solid #000;">{{ $currency . number_format($product['unit_price'], 2) }}</td>
          </tr>
          @endforeach

          {{-- Padding rows --}}
          @for ($i = 0; $i < $padrow; $i++)
          <tr>
              <td style="height:20px; border: 1px solid #000;"></td>
              <td style="height:20px; border: 1px solid #000;"></td>
              <td style="height:20px; border: 1px solid #000;"></td>
              <td style="height:20px; border: 1px solid #000;"></td>
          </tr>
          @endfor

          </table>
        </td>
      </tr>

   

    <!-- Totals -->
    <tr>
      <td colspan="2" style="padding: 20px;">
        <table width="300" align="right" style="font-size: 14px;">
          <tr>
            <td align="right"><strong>SUBTOTAL:</strong></td>
            <td align="right" style="border: 1px solid #D8292F; padding: 5px;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
          </tr>
          <tr>
            <td align="right"><strong>DISCOUNT:</strong></td>
            <td align="right" style="border: 1px solid #D8292F; padding: 5px;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
          </tr>
          <tr>
            <td align="right"><strong style="color: #D8292F;">TOTAL:</strong></td>
            <td align="right" style="border: 1px solid #D8292F; padding: 5px;"><strong>{{ site_currency() . number_format($invoice_amount, 2) }}</strong></td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- Footer Message -->
      <tr>
        <td style="padding: 20px 20px 0 20px; text-align: center; font-size: 14px; color: #D0221A;">
          <p><strong>MAKE ALL CHECKS PAYABLE TO {{ $company_name }}</strong><br/>Thank you for your business!</p>
        </td>
      </tr>

      <!-- Footer Details -->
      <tr>
        <td style="padding: 10px 20px 20px 20px; text-align: center; font-size: 10px; color: #D0221A;font-weight: bold;">
          {{ $company_name }} | {!! $company_address !!} | {{ $company_mobile  }}
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