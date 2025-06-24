<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    tr.myrow:nth-of-type(odd) {
      background:#f5f8ff !important;
    }

  </style>
</head>

<body style="margin:0; padding:0; font-family:'Montserrat', Arial, sans-serif; background-color:#fff;">

  <table width="100%" cellpadding="0" cellspacing="0" style="margin:auto; background:#fff;">

    <!-- Header -->
    <tr style="background-image: url('{{ $invoice_header_image }}');background-size:cover; background-position:center;">
      <td colspan="5" style="padding:0;">
        <table width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <!-- Left Column: Logo & Billed To -->
            <td style="width:0%; padding:0; vertical-align:top;">
              <div>
                <img src="{{ $company_logo }}" alt="Your Business Your Way" style="height:70px; margin:30px 0 0 30px;">
                <div style="margin:30px 0 0 30px;">
                  <span style="font-size:9px; font-weight:600; ">BILLED TO:</span><br>
                  <span style="font-size:8px; font-weight:400;"> {{ $customer_name }}</span>
                </div>
              </div>
            </td>

            <!-- Middle Column: Billed From -->
            <td style="width:25%; padding-top:30px; vertical-align:top;">
              <div style="margin-top:85px;">
                <span style="font-size:9px; font-weight:600;">BILLED FROM:</span><br>
                <span style="font-size:8px;">{{ $company_name }}</span>
                <a href="mailto:{{ $company_email }}"
                  style="color:#222; font-size:8px;"> {{ $company_email }}</a>
              </div>
            </td>

            <!-- Right Column: Invoice Title -->
            <td style="width:20%; text-align:right; padding:30px 30px 0 0; vertical-align:top;">
              <span style="font-size:36px; font-weight:700; color:#0066ff;">INVOICE</span>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- Invoice number and date -->
    <tr>
      <td colspan="5" style="padding:25px 0 10px 0;">
        <table width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td style="font-size:14px; font-weight:600; padding-left:30px;">
              INVOICE NUMBER: #{{ $invoice_number}}
            </td>
            <td style="font-size:14px; font-weight:600; text-align:right; padding-right:30px;">
              INVOICE DATE: {{ $invoice_date }}
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- Product table -->
    <tr>
      <td colspan="5">
        <table width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <th
              style="background:#e9eeff; color:#222; padding:12px 8px; text-align:left; font-size:15px; font-weight:700;">
              PRODUCT & SERVICE</th>
            <th
              style="background:#e9eeff; color:#222; padding:12px 8px; text-align:center; font-size:15px; font-weight:700;">
              QTY</th>
            <th
              style="background:#e9eeff; color:#222; padding:12px 8px; text-align:center; font-size:15px; font-weight:700;">
              PRICE</th>
            <th
              style="background:#e9eeff; color:#222; padding:12px 8px; text-align:center; font-size:15px; font-weight:700;">
              TOTAL</th>
          </tr>
          @foreach($products as $product)
          <tr class="myrow">
            <td style="padding:10px 8px; font-size:14px;height:65px;">
              {{ $product->name }}
            </td>
            <td style="text-align:center; padding:10px 8px; font-size:14px;">1</td>
            <td style="text-align:center; padding:10px 8px; font-size:14px;"> {{ site_currency() }} {{  number_format($product->unit_price, 2) }}</td>
            <td style="text-align:center; padding:10px 8px; font-size:14px;"> {{ site_currency() }} {{  number_format($product->unit_price, 2) }}</td>
          </tr>
          @endforeach
        </table>
      </td>
    </tr>

    <!-- Summary and note -->
    <tr>
      <td colspan="4" style="padding:30px 0 220px;">
        <span style="font-size:13px; color:black; font-weight:600;">WE APPRECIATE YOUR BUSINESS.</span>
      </td>
      <td colspan="1" style="padding:0 0 150px ;" align="right">
        <table width="320" cellpadding="0" cellspacing="0">
          <tr>
            <td style="font-size:13px; color:#bbb; padding:6px 8px; text-align:right;">SUBTOTAL</td>
            <td style="font-size:14px; color:#444; padding:6px 8px; text-align:right;">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</td>
          </tr>
          <tr>
            <td style="font-size:13px; color:#bbb; padding:6px 8px; text-align:right;">DISCOUNT</td>
            <td style="font-size:14px; color:#444; padding:6px 8px; text-align:right;">{{ site_currency() }} {{ number_format($discount_amount, 2) }}</td>
          </tr>
          <tr>
            <td
              style="font-size:15px; font-weight:700; color:#fff; background:#4d6fff; padding:10px 8px; text-align:right; border-radius:3px 0 0 3px;">
              GRAND TOTAL</td>
            <td
              style="font-size:18px; font-weight:700; color:#fff; background:#4d6fff; padding:10px 8px; text-align:right; border-radius:0 3px 3px 0;">
              {{ site_currency() }} {{ number_format($invoice_amount, 2) }}</td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- Footer -->
    <tr>
      <td colspan="5" style="padding:30px 0 20px 0; text-align:right;">
        <img src="{{ $company_logo }}" alt="Logo" style="height:135px; width: 250px;">
      </td>
    </tr>

  </table>

</body>

</html>