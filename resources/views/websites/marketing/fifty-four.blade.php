<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
  <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #ffffff;">
    <table width="90%" cellpadding="0" cellspacing="0" border="0" style="max-width: 90%; margin: 0 auto; border: 1px solid #ccc;">
    
       <tr style=" background: url('{{ $invoice_header_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;height: 105px;">
                <td style="padding: 0px;">
                </td>
              </tr>

      <tr style=" background: url('{{ $invoice_image1 }}'); background-repeat: no-repeat;background-size: cover;background-position: center;">
        <td style="padding: 20px 30px;">
          <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
              <td style="background-color: #000; color: #fff; padding: 10px 15px; font-size: 14px;">
                <strong>INVOICE No. {{ $invoice_number }}</strong>
              </td>
              <td align="right" style="background-color: #000; color: #fff; padding: 10px 15px; font-size: 14px;">
                <strong>DATE {{ $invoice_date }}</strong>
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <!-- Billed Info -->
      <tr style=" background: url('{{ $invoice_image1 }}');background-repeat: no-repeat; background-size: cover;background-position: center;">
        <td style="padding: 0 30px 20px;">
          <table width="100%" style="font-size: 14px;">
            <tr>
              <td style="border-bottom: 1px solid #ccc; padding-bottom: 10px;">
                <strong style="text-transform: uppercase;">Billed To</strong><br />
                  {{ $customer_name }}
              </td>
              <td align="right" style="border-bottom: 1px solid #ccc; padding-bottom: 10px;">
                <strong style="text-transform: uppercase;">Billed From</strong><br />
                {{ $site_name }} <br />
                {!! $company_address !!}<br />
                <a href="mailto:{{ $company_email }}" style="color: #007bff;">{{ $company_email }}</a>
              </td>
            </tr>
          </table>
        </td>
      </tr>
     
      <tr style=" background: url('{{ $invoice_image1 }}');
                      background-repeat: no-repeat;
                      background-size: cover;
                      background-position: center;">
        <td style="padding: 0 30px 20px;">
        <div style="min-height: 400px !important;">
          <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse; text-align: left; font-size: 14px;">
            <tr style="background-color: #111; color: #fff;">
              <th>Quantity</th>
              <th>Description</th>
              <th>Unit Price</th>
              <th>Total</th>
            </tr>
            @foreach($products as $product)
            <tr style="background-color: transparent;">
              <td style="border: 1px solid #ccc;">1</td>
              <td style="border: 1px solid #ccc;">{{ $product->name }} - {{ $product->subscription ?? '-' }}</td>
              <td style="border: 1px solid #ccc;">{{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</td>
              <td style="border: 1px solid #ccc;">{{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</td>
            </tr>
            @endforeach 
            <tr>
              <td></td>
              <td></td>
              <td align="center"  style="padding: 5px 0;">Subtotal</td>
              <td align="center" style="padding: 5px 0;">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td align="center"  style="padding: 5px 0;">Discount</td>
              <td align="center" style="padding: 5px 0;">{{ site_currency() }} {{ number_format($discount_amount ?? 0, 2) }}</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td align="center"  style="padding: 10px 0; font-weight: bold; color: #9ad000;border-top: 0.5px solid #BBBABA; border-bottom: 0.5px solid #BBBABA;">Total</td>
              <td align="center" style="padding: 10px 0; font-weight: bold; color: #9ad000;border-top: 0.5px solid #BBBABA; border-bottom: 0.5px solid #BBBABA;">{{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}</td>
            </tr>
          </table>
</div>
        </td>
      </tr>
      <tr>
        <td style="padding: 0; height: 200px;">
          <div style="height: 200px; background: url('{{ $invoice_image1 }}') no-repeat center center; background-size: cover;">
            <table align="right" style="font-size: 14px; width: 300px; height: 100%;">
              <!-- Optional content -->
            </table>
          </div>
        </td>
      </tr>

 
      <tr style=" background: url('{{ $invoice_footer_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;height: 115px;">
        <td style=" padding: 0px; color: #ffffff; font-size: 12px; text-align: center;">
        <br/>
        {{ $company_email }} | {{ $site->site_link }} 
          <br/>
          <br/>
          {!! $company_address !!}


        </td>
      </tr>
    </table>
  </body>
</html>
