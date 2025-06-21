<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
  </head>
  <body style="margin:0; padding:0; font-family: 'Arial', sans-serif; background-color: #f2f2f2;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f2f2f2;">
      <tr>
        <td align="center">
          <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border:1px solid #ddd;">
            
            <!-- Header with Logo and Banner -->
            <tr style="background: url('{{ $invoice_header_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;height: 134px;">
              <td style="padding: 20px; color: #fff;">
                <table width="100%">
                  <tr>
                    <td align="left" style="padding: 60px 0px 0px 39px;">
                      <p style="margin: 0; font-size: 12px;">Invoice #:{{ $invoice_number }}<br />Date:{{ $invoice_date }}</p>
                    </td>
                    <td align="right">
                      <p style="color: white; padding: 10px 25px; font-size: 24px; font-weight: bold;">Invoice</p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <!-- Billing Information -->
            <tr>
              <td style="padding: 30px;">
                <table width="100%" cellpadding="0" cellspacing="0" style="font-size: 14px;">
                  <tr>
                    <td valign="top" width="50%">
                      <strong>Billed to</strong><br /><br>
                      <span style="color: #876868;">{{ $customer_name }}</span>
                    </td>
                    <td valign="top" width="50%">
                      <strong>Billed From</strong><br /><br>
                      <span style="color: #876868;">{{ $site->site_link }} <br />
                      {!! $company_address !!} <br />
                      {{ $company_email }} </span>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <!-- Services Table -->
            <tr>
              <td style="padding: 0 30px 30px 30px;">
              <div style="min-height: 500px !important;">
                <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse; font-size: 14px;">
                  <tr style="background-color: #3e0c0c; color: white;">
                    <th align="left">Service name</th>
                    <th align="center">Duration</th>
                    <th align="center">Quanity</th>
                    <th align="right">Total</th>
                  </tr>
                  @foreach($products as $product)
                  <tr style="background-color: #ffffff; border-bottom: 1px solid #ccc;">
                    <td>{{ $product->name }}</td>
                    <td align="center">{{ $product->subscription ?? '-' }}</td>
                    <td align="center">1</td>
                    <td align="right"> {{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</td>
                  </tr>
                  @endforeach 
                 
                </table>
              </div>
              </td>
            </tr>

            <!-- Totals Section -->
            <tr style="background: url('{{ $invoice_image1 }}');background-repeat: no-repeat;background-size: contain;background-position: left top;">
              <td style="padding: 0 30px 40px 30px;">
                <table align="right" cellpadding="10" cellspacing="0" style="background-color: #f6bcbc; width: 300px; font-size: 14px;">
                  <tr>
                    <td>Subtotal</td>
                    <td align="right">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}</td>
                  </tr>
                 
                  <tr>
                    <td>Discount</td>
                    <td align="right">{{ site_currency() }} {{ number_format($discount_amount ?? 0, 2) }}</td>
                  </tr>
                  <tr>
                    <td colspan="2" style="border-top: 1px solid #ccc; font-weight: bold; font-size: 16px; padding-top: 10px;">
                      Grand total <span style="float:right;">{{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}</span>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <!-- Footer Pattern (Design) -->
            <!-- <tr>
              <td style="padding: 0 0 0px 0px;">
                <img src="./img/image1.png" alt="Pattern" width="500" />
              </td>
            </tr> -->

          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
