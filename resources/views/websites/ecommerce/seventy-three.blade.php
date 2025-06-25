<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
  <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #ffffff;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 100%; margin: 0 auto; border: 1px solid #ccc;">
      <!-- Header with Logo -->
       <tr style="background: url('{{ $invoice_header_image }}'); background-repeat: no-repeat;background-size: cover;background-position: center;height: 105px;">
          <td style="padding: 0px;">
          </td>
        </tr>

      <!-- Invoice Info -->
      <tr>
        <td style="padding: 30px;">
          <h1 style="margin: 0; font-size: 28px; color: #222;">INVOICE</h1>
          <table width="100%" style="margin-top: 20px; font-size: 14px;">
            <tr>
              <td style="vertical-align: text-top;">
                <strong>Invoice To</strong><br />
                  {{ $customer_name }}
              </td>
              <td style="vertical-align: text-top; width: 35%;">
                <strong>Invoice From</strong><br />
                {{ $site_name }}<br />
                <a href="mailto:{{ $company_email }}" style="color: #007bff;">{{ $company_email }}</a><br />
                {!! $company_address !!}
              </td>
              <td align="right">
                <strong>Invoice No:</strong> #{{ $invoice_number }}<br />
                <strong>Due Date:</strong> {{ $invoice_date }}<br />
                <strong>Total Amount Due:</strong><br />
                <span style="font-size: 24px; font-weight: bold;">{{ site_currency() }} {{ number_format(($invoice_amount), 2) }}</span>
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <!-- Item Table Header -->
      <tr>
        <td style="padding: 0 30px;">
        <div style="min-height: 500px !important;">
          <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse; font-size: 14px;">
            <tr style="background-color: #071829; color: #fff;">
              <th align="left">ITEM DESCRIPTIONS</th>
              <th align="center">QUANTITY</th>
              <th align="right">AMOUNT</th>
            </tr>
            @foreach($products as $product)
            <tr style="background-color: #f9f9f9;">
              <td>{{ $product->category_name }}<br /><span style="font-size: 12px;">{{ $product->name }}</span></td>
              <td align="center">01</td>
              <td align="right">{{ site_currency() }} {{  number_format($product->unit_price, 2) }}</td>
            </tr>
            @endforeach
            <tr>
                <td align="right" >Sub Total</td>
                <td align="right"></td>
                <td align="right">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</td>
              </tr>
              <tr>
                <td align="right">Discount</td>
                <td align="right"></td>
                <td align="right">{{ site_currency() }} {{ number_format($discount_amount, 2) }}</td>
              </tr>
              
              <tr>
                <td align="right"style="padding-top: 10px; font-weight: bold;">GRAND TOTAL</td>
                <td align="right"></td>
                <td align="right" style="padding-top: 10px; font-weight: bold;">{{ site_currency() }} {{ number_format($invoice_amount, 2) }}</td>
              </tr>
          </table>
        </div>
        </td>
      </tr>

    <tr style=" background: url('{{ $invoice_footer_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;">
      <td style="padding: 30px; color: #ffffff;">
        <table width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" style="width: 50%;">
              <img src="{{ $invoice_image1 }}" alt="Address Icon" width="44" style="display:block; margin: auto;" />
              <p style="margin: 10px 0 0; font-weight: bold;">ADDRESS</p>
              <p style="margin: 5px 0 0;">{!! $company_address !!}</p>
            </td>
            <td align="center" style="width: 50%; vertical-align: top;">
              <img src="{{ $invoice_image2 }}" alt="Email Icon" width="40" style="display:block; margin: auto;" />
              <p style="margin: 10px 0 0; font-weight: bold;">EMAIL</p>
              <p style="margin: 5px 0 0;"><a href="mailto:{{ $company_email }}" style="color: #ffffff; text-decoration: none;">{{ $company_email }}</a></p>
            </td>
          </tr>
        </table>
      </td>
    </tr>


      

     
    </table>
  </body>
</html>
