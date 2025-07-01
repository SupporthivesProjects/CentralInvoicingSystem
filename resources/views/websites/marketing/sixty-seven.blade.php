<!DOCTYPE html>
<html>
  <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #ffffff;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto; border: 1px solid #ccc;">

      <!-- Header -->
      <tr style=" background: url('{{ $invoice_header_image }}');
                      background-repeat: no-repeat;
                      background-size: contain;
                      background-position: center top;
                      height: 100px;">
        <td style="padding: 30px 20px 10px 20px;">
          <table width="100%">
            <tr>
              <td style="font-size: 28px; font-weight: bold;padding-top: 83px;">Invoice <span style="color: #007BFF;">{{ $invoice_number }}</span></td>
            </tr>
            <tr>
              <td style="text-align: right;">
                <img src="{{ $company_logo }}" alt="Emerald Eagle Logo" width="150px" />
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <!-- Date, To, From -->
      <tr>
        <td style="padding: 10px 20px;">
          <table width="100%" style="font-size: 14px;">
            <tr style="font-weight: bold;">
              <td style="width: 31%;">Date</td>
              <td style="width: 31%;">To</td>
              <td style="width: 38%;">From</td>
            </tr>
            <tr>
              <td>{{ $invoice_date }}</td>
              <td>{{ $customer_name }}</td>
              <td>
                {{ $site_name }}<br/>
                {{ $company_address }}<br/>
                {{ $company_mobile }}<br/>
                {{ $company_email }}<br/>
                Emerald Eagle Media<br/>
                <a href="{{ $site_name }}" style="color: #007BFF;">{{ $site_name }}</a>
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <!-- Table Header -->
      <tr>
        <td style="padding: 20px;">
          <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse; font-size: 14px;">
            <tr style="background-color: #173F7D; color: #ffffff;">
              <th style="border: 1px solid #000;text-align: left;">Month(s)</th>
              <th style="border: 1px solid #000;text-align: center;">Description</th>
              <th style="border: 1px solid #000;text-align: center;">Unit Price</th>
              <th style="border: 1px solid #000;text-align: right;">Total</th>
            </tr>
            @foreach($products as $product)
            <tr>
              <td style="border: 1px solid #ccc;text-align: left;">{{ $product->subscription }}</td>
              <td style="border: 1px solid #ccc;text-align: center;">{{$product->name}}</td>
              <td style="border: 1px solid #ccc;text-align: center;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
              <td style="border: 1px solid #ccc;text-align: right;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
            </tr>
            @endforeach
            <!-- Add more rows if needed -->
          </table>
        </td>
      </tr>

      <!-- Summary Totals -->
      <tr>
        <td style="padding: 0 20px 20px 20px;">
          <table width="100%" style="max-width: 300px; float: right; font-size: 14px;">
            <tr>
              <td style="text-align: right;">Subtotal</td>
              <td style="text-align: right;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
            </tr>
            <tr>
              <td style="text-align: right;">Discount</td>
              <td style="text-align: right;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
            </tr>
            <tr style="font-weight: bold;">
              <td style="text-align: right;">Total Due By Date</td>
              <td style="text-align: right;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
            </tr>
          </table>
        </td>
      </tr>

      <!-- Updated Footer -->
      <tr style=" background: url('{{ $invoice_footer_image }}');
                    background-repeat: no-repeat;
                    background-size: cover;
                    background-position: center;
                    height: 135px;">
        <td style="padding: 30px 20px; font-size: 12px; color: #000;">
          <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
              <!-- Left Column -->
              <td style="width: 33%; vertical-align: top;">
                <span style="color: #173F7D;">{{ $site_name }}</span><br/><br/>
                <span style="color: #666666;">Web:</span>
                <a href="http://www.emeraldeaglemedia.com" style="color: #4C483D; text-decoration: none;">{{ $site_name }}</a>
              </td>

              <!-- Middle Column -->
              <td style="width: 67%; vertical-align: top;">
                <span style="color: #666666;">Email:</span>
                <a href="mailto:support@emeraldeaglemedia.com" style="color: #4C483D; text-decoration: none;">{{ $company_email }}</a><br/>
                <br/>
                <span style="color: #666666;">Address:</span>
                <span style="color: #4C483D;">{{$company_address}}</span>
              </td>

            </tr>
          </table>
        </td>
      </tr>

    </table>
  </body>
</html>
