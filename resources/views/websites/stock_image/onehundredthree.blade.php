<!DOCTYPE html>
<html>

<head>
  <title>CaptureCraze</title>
</head>

<body style=" margin:0px; padding: 0px 0;">
  <table style=" margin:0px; padding: 0px 0;" width="100%" cellspacing="0" cellpadding="0" border="0">
    <tr>
      <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
          style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
          <!-- Header -->

          <tr style=" background: url('{{ $invoice_header_image }}');
                      background-repeat: no-repeat;
                      background-size: cover;
                      background-position: center;
                      height: 124px; position: relative;">


            <td>

              <p
                style="width: fit-content; font-size: 24px; color: #FFFFFF;font-family: arial; margin: 0;padding-left: 70px;">
                INVOICE</p>

              <div style="display: flex; flex-direction: row; gap: 24px; padding-left: 70px;">
                <p style="width: fit-content; font-size: 8px; color: #FFFFFF;font-family: arial;">
                  {{ $company_name }}<br>
                  {{ $company_email }}



                </p>


                <p style="width: fit-content; font-size: 8px; color: #FFFFFF;font-family: arial;">
                  {{ $company_address }}<br>
                  {{ $company_mobile }}
                </p>
              </div>

              <img src="{{ $company_logo }}" alt=""
                style="display: block;height:50px; margin-left: auto;margin-right: 60px; position: absolute; top: 42px; right: 0;">
            </td>
          </tr>
          <!-- Header End -->

          <!-- Content-->

          <tr style="background: url('{{ $invoice_image1 }}');
                     background-repeat: no-repeat;
                     background-size: cover;
                     background-position: center;">


            <td style="padding:70px; padding-bottom: 130px; padding-top: 30px;">

              <table style="width: 100%;">

                <tr>
                  <td style="font-size: 10px;font-family: Arial, sans-serif;">
                    <p style="margin: 0;">Billed to</p>
                    <p style="margin: 0;">{{ $customer_name }}<br>
                      {{ $customer_email }}<br>
                      {{ $customer_mobile }}<br>
                    </p>
                  </td>

                  <td style="font-size: 10px;font-family: Arial, sans-serif;">
                    <p style="margin: 0;">Billed From</p>
                    <p style="margin: 0;">{{ $site_name }}<br>
                      {{ $company_address }}<br>
                      {{ $company_email }}<br>
                      {{ $company_mobile }}<br>

                    </p>
                  </td>

                  <td style="font-size: 10px;font-family: Arial, sans-serif; vertical-align: top;">
                    <p style="margin: 0; text-align: right;">Invoice #: <span
                        style="color: #326AA1;">{{ $invoice_number }}</span> </p>
                    <p style="margin: 0; text-align: right;">
                      Date: {{ $invoice_date }}


                    </p>
                  </td>
                </tr>

              </table>
              <div style="min-height: 750px !important;">
                <table
                  style="width: 100%; border: 2px solid #aaa; border-collapse: collapse; font-family: Arial, sans-serif; text-align: left; font-size: 9px; margin-top: 24px;">
                  <thead>
                    <tr style="background-color: #BFBFBF;">
                      <th style="padding: 6px 12px; border: 1px solid #999;">PACK</th>
                      <th style="padding: 6px 12px; border: 1px solid #999; text-align: center;">CREDITS</th>
                      <th style="padding: 6px 12px; border: 1px solid #999;text-align: center;">UNIT PRICE</th>
                      <th style="padding: 6px 12px; border: 1px solid #999;text-align: right;">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($products as $product)
            <tr>
              <td style="padding: 12px; border: 1px solid #ccc; background-color: #FFFFFF;">{{ $product->name }}
              </td>
              <td
              style="padding: 12px; border: 1px solid #ccc; background-color: #FFFFFF;color: green;text-align: center;">
              {{ $product->credits ?? 0 }} Credits</td>
              <td style="padding: 12px; border: 1px solid #ccc;background-color: #FFFFFF;text-align: center;">
              {{ site_currency() }}{{ number_format($product->price, 2) }}</td>
              <td style="padding: 12px; border: 1px solid #ccc;background-color: #FFFFFF;text-align: right;">
              {{ site_currency() }}{{ number_format($product->price, 2) }}</td>
            </tr>
          @endforeach
                  </tbody>
                </table>

                <table
                  style="width: 100%; border: 2px solid #aaa; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 10px; margin-top: 20px;">
                  <tr>
                    <td style="padding: 6px 10px; background-color: #FFFFFF;">Subtotal</td>
                    <td style="padding: 6px 10px; background-color: #FFFFFF; text-align: right;">
                      {{ site_currency() }}{{ number_format($invoice_amount + $discount_amount, 2) }}</td>
                  </tr>
                  <tr>
                    <td style="padding: 6px 10px;background-color: #FFFFFF; border-bottom: 1px solid #ccc;">Discount
                    </td>
                    <td
                      style="padding: 6px 10px;background-color: #FFFFFF; border-bottom: 1px solid #ccc; text-align: right;">
                      {{ site_currency() }}{{ number_format($discount_amount, 2) }}</td>
                  </tr>
                  <tr style="background-color: #BFBFBF; font-weight: bold;">
                    <td style="padding: 6px 12px;">GRAND TOTAL</td>
                    <td style="padding: 6px 12px; text-align: right;">
                      {{ site_currency() }}{{ number_format($invoice_amount, 2) }}</td>
                  </tr>
                </table>
              </div>

            </td>
          </tr>
          <!-- Content End-->


          <!-----------Footer----------->

          {{-- <tr
            style=" background: url({{ $invoice_footer_image }});
                    background-repeat: no-repeat;
                    background-size: cover;
                    background-position: center;
                    height: 124px; display: flex; justify-content: center; flex-direction: column; align-items: center;">


          </tr> --}}
          <!-----------Footer End----------->
        </table>
      </td>
    </tr>
  </table>
</body>

</html>