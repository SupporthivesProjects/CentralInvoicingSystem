<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>

    <style>
        body {
            margin: 0px;
            padding: 0px;
        }

        .footer-fixed {
            position: fixed;
            bottom: 0px;
            left: 0;
            right: 0;
            width: 100%;
        }
    </style>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #ffffff;">
  <table width="100%" cellpadding="0" cellspacing="0" border="0"
    style="max-width: 100%; margin: 0 auto; ">
    <!-- Header with Logo -->
    <tr style=" background: url('{{ $invoice_header_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;height: 83px;">
      <td style="padding: 0px;">
      </td>
    </tr>

    <!-- Title Section -->
      <tr>
        <td align="center" style="padding: 40px 20px 20px 20px;">
          <h2 style="margin: 0; font-size: 28px; color: #111111;">INVOICE</h2>
        </td>
      </tr>

      <!-- Info Section -->
      <tr>
        <td style="padding: 20px;">
          <table width="100%" style="font-size: 14px;border: 1px solid #FFEEEE;">
            <tr>
              <td style="width: 60%; vertical-align: top;">
                <p style="margin: 0 0 8px 0;"><strong>Date:</strong> {{ $invoice_date }}</p>
                <p style="margin: 0 0 8px 0;"><strong>Invoice #:</strong> {{ $invoice_number }}</p>
              </td>
              <td style="width: 10%; vertical-align: top;border-left: 1px solid #FFEEEE;">
                <p style="margin: 0 0 8px 0;"><strong>To:</strong></p>
              </td>
              <td style="width: 40%; vertical-align: top;border-left: 1px solid #FFEEEE;">
                <p style="margin: 0 0 8px 0;">{{ $customer_name }}<br/>{{ $customer_email }}</p>
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <!-- Table Section -->
      <tr>
        <td style="padding: 0 20px 20px 20px;">
        <div style="min-height: 400px !important;">
          <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
            <tr style="background-color: #FFEEEE; border: 1px solid #FFEEEE;">
              <th align="left">QTY</th>
              <th align="left">DESCRIPTION</th>
              <th align="right">UNIT PRICE</th>
              <th align="right">LINE TOTAL</th>
            </tr>
            @foreach($products as $product)
            <tr style="border-bottom: 1px solid #eee;">
              <td>01</td>
              <td>{{ $product->category_name }} | {{ $product->name }}</td>
              <td align="right">{{ site_currency() }} {{  number_format($product->unit_price, 2) }}</td>
              <td align="right">{{ site_currency() }} {{  number_format($product->unit_price, 2) }}</td>
            </tr>
            @endforeach
          </table>
        </div>
        </td>
      </tr>

      <!-- Totals -->
      <tr>
        <td style="padding: 0 20px 20px 20px;">
          <table align="right" cellpadding="10" cellspacing="0" style="font-size: 14px; border-collapse: collapse;">
            <tr>
              <td align="right"><strong>Subtotal:</strong></td>
              <td align="right">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</td>
            </tr>
            <tr>
              <td align="right"><strong>Discount:</strong></td>
              <td align="right">{{ site_currency() }} {{ number_format($discount_amount, 2) }}</td>
            </tr>
            <tr style="background-color: #FFEEEE;">
              <td align="right"><strong>Total:</strong></td>
              <td align="right"><strong>{{ site_currency() }} {{ number_format($invoice_amount, 2) }}</strong></td>
            </tr>
          </table>
        </td>
      </tr>


      <!-- Footer Message -->
      <tr>
        <td style="padding: 20px 20px 0 20px; text-align: center; font-size: 14px;">
          <p>Thank you for your business!</p>
        </td>
      </tr>

      <!-- Footer Details -->
      <tr>
        <td style="padding: 10px 20px 20px 20px; text-align: center; font-size: 10px; color: #333;font-weight: bold;">
          {{ $company_name }} {!! $company_address !!} | PHONE: {{ $company_mobile }}
        </td>
      </tr>

    <!-- Footer -->


    <div class="footer-fixed" style="background: url('{{ $invoice_footer_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;height: 75px;">
      
        <!-- <tr style=" background: url('{{ $invoice_footer_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;height: 75px;">
          <td style=" padding: 0px; color: #ffffff; font-size: 12px; text-align: center;">

          </td>
        </tr> -->
    </div>
  </table>
</body>

</html>