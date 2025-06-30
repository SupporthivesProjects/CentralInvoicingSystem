<!DOCTYPE html>
<html>
<head>
  <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #ffffff;">
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 90%; margin: 0 auto; border: 1px solid #ccc;">
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
              <span style="color: #e64a4a;">{{ $site_name }}</span><br/>
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

   
    <tr>
      <td style="padding: 30px 20px;">
        <table width="100%" style="text-align: center; font-size: 13px; color: #444;">
          <tr>
            <td>
              <img src="{{ $invoice_image1 }}" width="20" style="vertical-align:middle; margin-bottom: 8px;" /> <br />
              <strong>Address</strong><br />
              {!! $company_address !!}
            </td>
            <td>
              <img src="{{ $invoice_image2 }}" width="20" style="vertical-align:middle; margin-bottom: 8px;" /> <br />
              <strong>Email</strong><br />
              {{ $company_email }}
            </td>
            <td>
              <img src="{{ $invoice_image3 }}" width="20" style="vertical-align:middle; margin-bottom: 8px;" /> <br />
              <strong>Phone</strong><br />
              {{ $company_mobile }}
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- Footer -->
    <tr style=" background: url('{{ $invoice_footer_image }}');background-repeat: no-repeat;background-size: cover;background-position: center; height: 45px;">
      <td style=" padding: 0px; color: #ffffff; font-size: 12px; text-align: center;">
      </td>
    </tr>
  </table>
</body>

</html>