<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>

  <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #ffffff;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 90%; margin: 0 auto; border: 1px solid #ccc;">
      <!-- Header with Logo -->
       <tr style=" background: url('{{ $invoice_header_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;height: 124px;">
          <td style="padding: 0px;">
          </td>
        </tr>

      <!-- Invoice Info -->
    <!-- Items Table -->
    <tr>
      <td colspan="2" style="padding: 20px 20px;">
        <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse; font-size: 14px;">
          <tr style="background-color: #5A3DF2; color: #ffffff;">
            <th align="left">INVOICE No. {{ $invoice_number }}</th>
            <th align="right">Date  {{ $invoice_date }}</th>
          </tr>
          <tr>
            <td valign="top" align="center" width="50%" style="border-bottom: 1px solid #4472C4;">
              
              <p style="margin: 4px 0 4px 0; color: #5A3DF2; font-variant: small-caps;">BILLED TO</p>
            </td>
            <td valign="top" align="center" width="50%" style="border-bottom: 1px solid #4472C4;">
              <p style="margin: 4px 0 4px 0; color: #5A3DF2; font-variant: small-caps;">BILLED FROM</p>
            </td>
          </tr>
          <tr>
            <td style="vertical-align: top;">
              <p style="margin: 4px 0 8px 0; text-align: center; color: #595959;">{{ $customer_name }}</p>
              
            </td>
          
            <td align="center">
              

              <p style="margin: 4px 0 8px 0;color: #595959;">{{ $company_name }}</p>
              <p style="margin: 0 0 8px 0;color: #595959;">{{ $site_name }}
              </p>
             
            </td>
          </tr>
        </table>
      </td>
    </tr>

   

    <!-- Items Table -->
    <tr>
      <td colspan="2" style="padding: 0 20px 20px;">
      <div style="min-height: 550px !important;">
      <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse; font-size: 14px;">
        <tr style="background-color: #5A3DF2; color: #ffffff;">
          <th align="left">Quantity</th>
          <th align="left">PRODUCT - Card Gift Value</th>
          <th align="right">Unit Price</th>
          <th align="right">Total</th>
        </tr>

        @foreach($products as $product)
          <tr style="border-bottom: 1px solid #ddd;">
            <td>{{ $product->quantity ?? 1 }}</td>
            <td>{{ $product->name }} - {{ site_currency() }} {{ number_format($product->unit_price, 2) }}</td>
            <td align="right">{{ site_currency() }} {{ number_format($product->unit_price, 2) }}</td>
            <td align="right">{{ site_currency() }} {{ number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}</td>
          </tr>
        @endforeach 

        <!-- Subtotal -->
        <tr>
          <td colspan="3" style="color: gray; font-variant: small-caps; font-size: 14px;" align="right">Subtotal</td>
          <td align="right" style="color: gray; font-size: 14px;">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</td>
        </tr>

        <!-- Divider -->
        <tr><td colspan="4" style="border-top: 1px solid #ccc; padding: 8px 0;"></td></tr>

        <!-- Discount -->
        <tr>
          <td colspan="3" style="color: gray; font-variant: small-caps; font-size: 14px;" align="right">Discount</td>
          <td align="right" style="color: gray; font-size: 14px;">{{ site_currency() }} {{ number_format($discount_amount, 2) }}</td>
        </tr>

        <!-- Divider -->
        <tr><td colspan="4" style="border-top: 1px solid #ccc; padding: 8px 0;"></td></tr>

        <!-- Total -->
        <tr>
          <td colspan="3" align="right" style="color: #5A33F6; font-weight: bold; font-variant: small-caps; font-size: 16px;">Total</td>
          <td align="right" style="color: #5A33F6; font-weight: bold; font-size: 16px;">{{ site_currency() }} {{ number_format($invoice_amount, 2) }}</td>
        </tr>

        <!-- Final Divider -->
        <tr><td colspan="4" style="border-top: 1px solid #ccc; padding-top: 8px;"></td></tr>
      </table>
    </div>
      </td>
    </tr>
      <!-- Footer -->

      

      <tr style=" background: url('{{ $invoice_footer_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;height: 115px;">
        <td style=" padding: 0px; color: #ffffff; font-size: 12px; text-align: center;">
        </td>
      </tr>
    </table>
  </body>
</html>
