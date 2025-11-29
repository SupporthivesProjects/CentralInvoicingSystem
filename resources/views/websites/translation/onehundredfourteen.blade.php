<!DOCTYPE html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<html>
  <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #ffffff;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 100%; margin: 0 auto; border: 1px solid #ccc;">
       <tr style=" background: url('{{ $invoice_header_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;height: 124px;">
          <td style="padding: 0px;">
          </td>
        </tr>
    <tr>
      <td colspan="2" style="padding: 20px 20px;">
        <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse; font-size: 14px;">
         
          <tr>
            <td valign="top" align="center" width="50%" style="border-bottom: 1px solid #0D6966;">
              <p style="margin: 4px 0 4px 0;"><strong>BILLED TO</strong></p>
            </td>
            <td valign="top" align="center" width="50%" style="border-bottom: 1px solid #0D6966;">
              <p style="margin: 4px 0 4px 0;"><strong>BILLED FROM</strong></p>
            </td>
          </tr>
          <tr>
            <td align="center">
              <p style="margin: 4px 0 8px 0;">{{ $customer_name }}</p>
              <p style="margin: 0 0 8px 0;">{{ $customer_mobile }}</p>
            </td>
          
            <td align="center">
              <p style="margin: 4px 0 8px 0;">{!! $company_address !!}</p>
              <p style="margin: 0 0 8px 0;">{{ $company_mobile }}</p>
              <a href="mailto:{{ $company_email }}" style="color: #0066cc;">{{ $company_email }}</a>
            </td>
          </tr>
        </table>
      </td>
    </tr>

   

    <!-- Items Table -->
    <tr>
      <td colspan="2" style="padding: 0 20px 20px;">
      <div style="min-height: 680px !important">
        <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse; font-size: 14px;">
          <tr style="background-color: #0D6966; color: #ffffff;">
            <th align="left">QUANTITY</th>
            <th align="left">DESCRIPTION</th>
            <th align="right">NO OF PAGES/WORDS</th>
            <th align="right">TOTAL</th>
          </tr>
          @foreach($products as $product)
          <tr style="border-bottom: 1px solid #ddd;">
            <td>1</td>
            <td>{{ $product->name }} <br>{{ $product->from_language }} to  {{ $product->to_language }}</td>
            <td align="right">
              @if ($product->unit_type === 'words')
                  {{ ceil($product->pages / 250) }} | {{ $product->pages }} 
              @else
                  {{ $product->pages }} | {{ $product->pages * 250 }} 
              @endif
          </td>
            <td align="right">{{ site_currency() . number_format($product->line_total, 2) }}</td>
          </tr>
          @endforeach
          <tr>
          <td></td>
          <td></td>
            <td align="right">SUBTOTAL:</td>
            <td align="right">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
          </tr>
          <tr>
          <td></td>
          <td></td>
            <td align="right">DISCOUNT:</td>
            <td align="right">{{ site_currency() . number_format($discount_amount, 2) }}</td>
          </tr>
          <tr>
          <td></td>
          <td></td>
            <td align="right"><strong style="color: #0D6966;">TOTAL</strong>:</td>
            <td align="right"><strong style="color: #0D6966;">{{ site_currency() . number_format($invoice_amount, 2) }}</strong></td>
          </tr>
        </table>
      </div>
      </td>
    </tr>
    <tr style=" background: url('{{ $invoice_footer_image }}');background-repeat: no-repeat;background-size: cover;background-position: center;height: 95vh;"> 
      <td style="padding: 0px; color: #ffffff; font-size: 12px; text-align: center;"> 
      {{ $company_email}} |{{ $site_name }}| {{ $company_mobile }}<br/><br> {!! $company_address !!} 
      </td> 
    </tr>
    </table>
  </body>
</html>