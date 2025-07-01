<!DOCTYPE html>
<html>
  <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #ffffff;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto; border: 1px solid #ccc;">
      <!-- Header with Logo -->
       <tr style=" background: url({{ $invoice_header_image }});
                      background-repeat: no-repeat;
                      background-size: cover;
                      background-position: center;
                      height: 124px;">
                        <td style="padding: 0px;">
                        </td>
                      </tr>

      <!-- Invoice Info -->
    <!-- Items Table -->

    <tr>
      <td colspan="2" style="padding: 20px 20px;">

        <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse; font-size: 14px;">
          <tr style="background-color: #A67C52; color: #ffffff;">
            <th align="left">QUANTITY</th>
            <th align="right">DESCRIPTION</th>
          </tr>
          <tr>
            <td valign="top" align="center" width="50%" style="border-bottom: 1px solid #4472C4;">
              <p style="margin: 4px 0 4px 0;"><strong>BILLED TO</strong></p>
            </td>
            <td valign="top" align="center" width="50%" style="border-bottom: 1px solid #4472C4;">
              <p style="margin: 4px 0 4px 0;"><strong>BILLED FROM</strong></p>
            </td>
          </tr>
          <tr>
            <td align="center">
              <p style="margin: 4px 0 8px 0;">{{ $customer_name }}</p>
              <p style="margin: 0 0 8px 0;">{{ $customer_email }}, {{ $customer_mobile }}</p>
            </td>

            <td align="center">
              <p style="margin: 4px 0 8px 0;">{{ $company_address }}</p>
              <p style="margin: 0 0 8px 0;">{{ $company_mobile }}</p>
              <a href="mailto:{{ $company_email }}" style="color: #0066cc;">{{ $company_email }}</a>
            </td>
          </tr>
        </table>
      </td>
    </tr>


    <!-- Items Table -->

    <tr>
      <td colspan="2" style="padding: 0 20px 20px;">
        <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse; font-size: 14px;">
          <tr style="background-color: #A67C52; color: #ffffff;">
            <th align="left">Game Name</th>
            <th align="left">In Game Currency</th>
            <th align="right">UNIT PRICE</th>
            <th align="right">TOTAL</th>
          </tr>
          @foreach($products as $index => $product)
          <!-- Repeatable row -->
          <tr style="border-bottom: 1px solid #ddd;">
            <td>{{ $product['name'] }}</td>
            <td>{{ $product['game_currency_amount'] }} {{ $product['game_currency'] }}</td>
            <td align="right">{{ site_currency() . number_format($product['unit_price'], 2) }}</td>
            <td align="right">{{ site_currency() . number_format($product['unit_price'], 2) }}</td>
          </tr>
            @endforeach
        </table>
      </td>
    </tr>


    <!-- Totals -->
    <tr>
      <td colspan="2" style="padding: 20px;">
        <table width="300" align="right" style="font-size: 14px;">
          <tr>
            <td align="right">SUBTOTAL:</td>
            <td align="right">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
          </tr>
          <tr>
            <td align="right">DISCOUNT:</td>
            <td align="right">{{ site_currency() . number_format($discount_amount, 2) }}</td>
          </tr>
          <tr>
            <td align="right"><strong style="color: #884C2F;">TOTAL</strong>:</td>
            <td align="right"><strong style="color: #884C2F;">{{ site_currency() . number_format($invoice_amount, 2) }}</strong></td>
          </tr>
        </table>
      </td>
    </tr>

      <!-- Footer -->



      <tr style=" background: url({{ $invoice_footer_image }});
                    background-repeat: no-repeat;
                    background-size: cover;
                    background-position: center;
                    height: 115px;">
        <td style=" padding: 0px; color: #ffffff; font-size: 12px; text-align: center;">
          <a href="mailto:info@mmodepot.com" style="color: #0066cc;">info@mmodepot.com</a> |
        mmodepot.com<br/><br>
        1234 Some Street, City, Country, 123 ABC | +44 123456789

        </td>
      </tr>
    </table>
  </body>
</html>
