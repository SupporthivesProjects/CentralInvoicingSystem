<!DOCTYPE html>
<html>
<head>
  <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
  <style>
    .footer-fixed {
      position: fixed;
      bottom: 0px;
      left: 0;
      right: 0;
      width: 100%;
      /* background: url('{{ $invoice_footer_image }}') center center no-repeat; */
      /* background-size: cover; */
    }
  </style>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #ffffff;">
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto; border: 0px solid #ccc;">
    <tr style=" background: url('{{ $invoice_header_image }}');background-repeat: no-repeat; background-size: cover; background-position: center;height: 134px;">
      <td style="padding: 65px 0px 10px 24px;">
        <!-- <img src="./img/image1.png" alt="" width="166px"> -->
      </td>
    </tr>

    <!-- Billing Info -->
    <tr>
      <td style="padding: 20px;">
        <table width="100%" style="font-size: 14px;">
          <tr>
            <td valign="top" width="33%">
              <strong>Invoice To</strong><br/>
              {{ $customer_name  }}<br/>
              {{ $customer_email  }}<br/>
            </td>
            <td valign="top" width="33%">
              <strong>Invoice From</strong><br/>
              <span>{{ $site_name }}</span><br/>
              {{ $company_email }}<br/>
              {{ $company_mobile }}<br/>
              {!! $company_address !!}
            </td>
            <td valign="top" width="33%" align="right">
              <strong>Invoice No:</strong> #{{ $invoice_number }}<br/>
              <strong>Due Date:</strong> {{ $invoice_date }}<br/><br/>
              <strong style="font-size: 18px;">Total Amount Due</strong><br/>
              <span style="font-size: 28px; font-weight: bold;">{{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}</span>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <tr>
      <td style="padding: 0 20px 20px 20px;">
    <div style="min-height: 450px !important;">
      <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse; font-size: 14px;">
        <tr style="background-color: #007bff; color: #fff;">
          <th align="left">SERVICE</th>
          <th align="center">QTY</th>
          <th align="center">LENGTH</th>
          <th align="center">BILLING CYCLE</th>
          <th align="right">TOTAL</th>
        </tr>

        @foreach($products as $product)
          <tr style="background-color: #f8f9ff;">
            <td>{{ $product->name }}</td>
            <td align="center">1</td>
            <td align="center">{{ $product->subscription ?? '-' }}</td>
            <td align="center">One Time</td>
            <td align="right">{{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}</td>
          </tr>
        @endforeach

        <tr>
          <td colspan="4" align="right">Sub Total</td>
          <td align="right">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}</td>
        </tr>
        <tr>
          <td colspan="4" align="right">Discount</td>
          <td align="right">{{ site_currency() }} {{ number_format($discount_amount ?? 0, 2) }}</td>
        </tr>
        <tr>
          <td colspan="4" align="right"><strong>GRAND TOTAL</strong></td>
          <td align="right"><strong>{{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}</strong></td>
        </tr>
      </table>
    </div>
      </td>
    </tr>

   <div class="footer-fixed">
    <!-- Contact Info -->
<div style="padding: 30px 20px;">
  <div style="display: flex; justify-content: center; gap: 0px; text-align: center; font-size: 13px; color: #444; flex-wrap: wrap;">

    <!-- Address -->
    <div style="width: 48%;">
      <img src="{{ $invoice_image1 }}" width="20" style="vertical-align: middle; margin-bottom: 8px;" /><br />
      <strong>Address</strong><br />
      {!! $company_address !!}
    </div>

    <!-- Email -->
    <div style="width: 48%;">
      <img src="{{ $invoice_image2 }}" width="20" style="vertical-align: middle; margin-bottom: 8px;" /><br />
      <strong>Email</strong><br />
      {{ $company_email }}
    </div>

    <!-- Phone (optional: uncomment if needed) -->
    <!--
    <div>
      <img src="{{ $invoice_image3 }}" width="20" style="vertical-align: middle; margin-bottom: 8px;" /><br />
      <strong>Phone</strong><br />
      {{ $company_mobile }}
    </div>
    -->
  </div>
</div>

<!-- Footer Background -->
<div style="
  background: url('{{ $invoice_footer_image }}') no-repeat center;
  background-size: cover;
  height: 45px;
  color: #ffffff;
  font-size: 12px;
  text-align: center;
  padding: 0;
">
</div>

    </div>
  </table>
</body>

</html>