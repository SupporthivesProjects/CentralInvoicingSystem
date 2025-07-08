<!DOCTYPE html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>

<html>
  <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #ffffff;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 100%; margin: 0 auto; border: 1px solid #ccc;">
      <!-- Header with Logo -->
       <tr style=" background: url('{{ $invoice_header_image }}');background-repeat: no-repeat;background-size: cover; background-position: center;height: 124px;">
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
              

              <p style="margin: 4px 0 8px 0;color: #595959;">LAGOON ENTERPRISES FZ-LLC</p>
              <p style="margin: 0 0 8px 0;color: #595959;">www.thegiftcardbarn.com
              </p>
             
            </td>
          </tr>
        </table>
      </td>
    </tr>

   

    <!-- Items Table -->
    <tr>
      <td colspan="2" style="padding: 0 20px 20px;">
        <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse; font-size: 14px;">
          <tr style="background-color: #5A3DF2; color: #ffffff;">
            <th align="left">Quanitiy</th>
            <th align="left">PRODUCT - Card Gift Value</th>
            <th align="right">Unit Price</th>
            <th align="right">Total</th>
          </tr>
          <!-- Repeatable row -->
          <tr style="border-bottom: 1px solid #ddd;">
            <td>12</td>
            <td>Item Description / Name</td>
            <td align="right">75.00</td>
            <td align="right">900.00</td>
          </tr>
          <tr style="border-bottom: 1px solid #ddd;">
            <td>12</td>
            <td>Item Description / Name</td>
            <td align="right">75.00</td>
            <td align="right">900.00</td>
          </tr>
          <tr style="border-bottom: 1px solid #ddd;">
            <td>12</td>
            <td>Item Description / Name</td>
            <td align="right">75.00</td>
            <td align="right">900.00</td>
          </tr>
          <tr style="border-bottom: 1px solid #ddd;">
            <td>12</td>
            <td>Item Description / Name</td>
            <td align="right">75.00</td>
            <td align="right">900.00</td>
          </tr>
          <tr style="border-bottom: 1px solid #ddd;">
            <td>12</td>
            <td>Item Description / Name</td>
            <td align="right">75.00</td>
            <td align="right">900.00</td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- Totals -->

   

    <tr>
      <td colspan="2" style="padding: 20px;">
        <table width="300" align="right" style="font-size: 14px;">
          <tr>
            <td style="color: gray; font-variant: small-caps; font-size: 14px;">Subtotal</td>
            <td style="text-align: right; color: gray; font-size: 14px;">$52.95</td>
          </tr>
          <tr>
            <td colspan="2" style="border-top: 1px solid #ccc; padding: 8px 0;"></td>
          </tr>
          <tr>
            <td style="color: #5A33F6; font-weight: bold; font-variant: small-caps; font-size: 16px;">Total</td>
            <td style="text-align: right; color: #5A33F6; font-weight: bold; font-size: 16px;">$52.95</td>
          </tr>
          <tr>
            <td colspan="2" style="border-top: 1px solid #ccc; padding-top: 8px;"></td>
          </tr>
        </table>
      </td>
    </tr>

      <!-- Footer -->

      

      <tr style=" background: url('{{ $invoice_footer_image }}');
                    background-repeat: no-repeat;
                    background-size: cover;
                    background-position: center;
                    height: 115px;">
        <td style=" padding: 0px; color: #ffffff; font-size: 12px; text-align: center;">
          

        </td>
      </tr>
    </table>
  </body>
</html>
