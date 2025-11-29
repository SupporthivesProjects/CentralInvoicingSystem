<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #ffffff;">
  <table width="100%" cellpadding="0" cellspacing="0" border="0"
    style="max-width: 100%; margin: 0 auto; border: 1px solid #ccc;">
    <!-- Header with Logo -->
    <tr style="background: url('{{ $invoice_header_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;height: 100px;">
      <td style="padding: 0px;">
      </td>
    </tr>

    <!-- Invoice Info -->
      <tr>
        <td style="padding: 20px;">
          <table width="100%">
            <tr>
              <td style="font-size: 14px; vertical-align: top;">
                <p style="margin: 0 0 4px 0;"><strong>Date:</strong> {{ $invoice_date }} </p>
                <p style="margin: 0 0 4px 0;"><strong>Invoice Number:</strong> #{{ $invoice_number }}</p>
                <p style="margin: 0 0 4px 0;"><strong>Billed From:</strong>{{ $site_name }}</p>
                <p style="margin: 0 0 4px 0;"><strong>Email:</strong>{{ $company_email }}</p>
                   <p style="margin: 0 0 4px 0;"><strong>Website:</strong> www.pitchperfectsolutionz.com</p>
                   <p style="margin: 0 0 4px 0;"><strong>Phone:</strong> {{ $company_mobile }}</p>
                   <p style="margin: 0 0 4px 0;"><strong>Address:</strong> {!! $company_address !!}</p>
                </p>
              </td>
              <td valign="top" align="right" style="font-size: 18px; font-weight: bold;">
                INVOICE<br/>
                <span style="font-size: 14px; font-weight: normal;">Billed To:<br/>{{ $customer_name }}</span>
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <!-- Item Table -->
      <tr>
        <td style="padding: 0 20px 20px 20px;">
          <div style="min-height: 670px !important;">
          <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
            <tr style="background-color: #001f4d; color: #ffffff;">
              <th align="left">Name</th>
              <th align="left">Subscription</th>
              <th align="center">Quantity</th>
              <th align="right">Unit Price</th>
              <th align="right">Total</th>
            </tr>
            @foreach($products as $product)
            <tr style="border-bottom: 1px solid #ccc;">
              <td> {{ $product->name }}</td>
              <td>{{ $product->subscription ?? '-' }}</td>
              <td align="center">1</td>
              <td align="right"> {{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</td>
              <td align="right"> {{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</td>
            </tr>
            @endforeach 
            <!-- Totals -->
            <tr>
              <td colspan="4" align="right" style="padding-top: 10px;">Subtotal</td>
              <td align="right" style="padding-top: 10px;">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}</td>
            </tr>
            <tr>
              <td colspan="4" align="right">Discount</td>
              <td align="right">{{ site_currency() }} {{ number_format($discount_amount ?? 0, 2) }}</td>
            </tr>
            <tr>
              <td colspan="4" align="right" style="background-color: #001f4d; color: #fff; font-weight: bold; padding: 10px;">
                Grand Total
              </td>
              <td align="right" style="background-color: #001f4d; color: #fff; font-weight: bold; padding: 10px;">
                {{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}
              </td>
            </tr>
          </table>
        </div>
        </td>
      </tr>



    <!-- Footer -->



    <tr style=" background: url('{{ $invoice_footer_image }}');
                    background-repeat: no-repeat;
                    background-size: contain;
                    background-position: bottom right;
                    height: 130px;">
      <td style=" padding: 0px; color: #ffffff; font-size: 12px; text-align: center;">

      </td>
    </tr>

    
  </table>
</body>

</html>