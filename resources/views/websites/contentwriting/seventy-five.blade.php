<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #ffffff;">
  <table width="100%" cellpadding="0" cellspacing="0" border="0"
    style="max-width: 90%; margin: 0 auto; background: url('{{ $invoice_image1 }}'); background-repeat: no-repeat;background-size: cover;background-position: center;">
    <tr style="height: 100px;">
      <td style="padding: 16px 24px;" align="center">
        <img src="{{ $company_logo }}" width="50" alt=""><br>
        <h1 style="margin: 10px;color: #4A5E8C;font-size: 50px;font-weight: 400;">INVOICE</h1>
        <p style="margin: 0;font-size: 14px;letter-spacing: 4px;margin-bottom: 16px;">Invoice No#{{ $invoice_number }}</p>
        <hr style="background: #7F8082;margin: 0;">
      </td>
    </tr>


      <tr>
        <td style="padding: 16px 24px;">
          <table width="100%" cellpadding="5" cellspacing="0">
            <tr>
              <td valign="top" style="width: 33%;padding: 0 16px;" align="center">
                <p style="color: #1d2e5e;font-size: 12px;margin: 0 0 8px 0;">ADDRESS</p>
                <p style="color: #58595B; margin: 0px;font-size: 14px;">{!! $company_address !!}</p>
              </td>
              <td valign="top" style="width: 33%;padding: 0 16px;" align="center">
                <p style="color: #1d2e5e;font-size: 12px;margin: 0 0 8px 0;">PHONE</p>
                <p style="color: #58595B; margin: 0px;font-size: 14px;">{{ $company_mobile }}</p>
              </td>
              <td valign="top" style="width: 33%;padding: 0 16px;" align="center">
                <p style="color: #1d2e5e;font-size: 12px;margin: 0 0 8px 0;">E-MAIL</p>
                <p style="color: #58595B; margin: 0px;font-size: 14px;">{{  $company_email }}</p>
              </td>
            </tr>
          </table>
        </td>
      </tr>

    <tr>
      <td style="padding: 16px 24px;" align="center">
        <table width="100%" cellpadding="5" cellspacing="0">
            <tr>
              <td valign="top" style="width: 28%;padding: 0 8px 0px 0px;">
                <p style="color: #58595b;font-size: 12px;margin: 0 0 8px 0;">Invoice To</p>
                <p style="color: #1d2e5e;margin: 0 0 8px 0;">{{ $customer_name }}</p>
                <hr style="background: #7F8082;margin: 0 0 8px 0;">
                <p style="margin: 0px;color: #58595b;font-size: 14px;line-height: 20px;">
                {{ $customer_email  }}</p>
              </td>
              <td valign="top" style="width: 27%;padding: 0 8px 0px 0px;">
                <p style="color: #58595b;font-size: 12px;margin: 0 0 8px 0;">Invoice From</p>
                <p style="color: #1d2e5e;margin: 0 0 8px 0;">{{ $site_name }}</p>
                <hr style="background: #7F8082;margin: 0 0 8px 0;">
                <p style="margin: 0px;color: #58595b;font-size: 14px;line-height: 20px;">{{ $company_mobile }}<br />
                {{ $company_email }}<br />
                {!! $company_address !!}</p>
              </td>
              <td valign="center" align="right" style="width: 45%;padding: 0 0px;">
                <table width="80%" cellpadding="5" cellspacing="0" style="margin-top: 10px;">
                  <tr>
                    <td>
                      <p style="color: #58595b;font-size: 12px;margin: 0 0 0 0;">Total Due:</p>
                    </td>
                    <td style="text-align: right; color: #1d2e5e;">
                      <p style="margin: 0;font-weight: bold;">{{ site_currency() . number_format($invoice_amount, 2) }}</p>
                    </td>
                  </tr>
                  <tr>
                    <td style="text-align: left;">
                      <p style="color: #58595b;font-size: 12px;margin: 0 0 0 0;">Invoice Date:</p>
                    </td>
                    <td style="text-align: right;">
                      <p style="color: #58595b;font-size: 12px;margin: 0 0 0 0;">Issue Date:</p>
                    </td>
                  </tr>
                  <tr>
                    <td style="text-align: left;"><p style="margin: 0; font-size: 14px;">{{ $invoice_date }}</p></td>
                    <td style="text-align: right;"><p style="margin: 0; font-size: 14px;">{{ $invoice_date }}</p></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
      </td>
    </tr>
      
     


    <!-- Table -->
      <tr>
        <td style="padding: 16px 24px;" align="center">
          <table width="100%" cellpadding="" cellspacing="0">
          <tr>
            <td style="padding-top: 20px;">
              <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse;">
                <tr style="background: #e2f0fb; color: #1d2e5e;">
                  <th align="left">ITEM DESCRIPTIONS</th>
                  <th align="left">BILLING</th>
                  <th align="center">QUANTITY</th>
                  <th align="right">TOTAL</th>
                </tr>

                @foreach($products as $product)
                <tr style="border-bottom: 1px solid #ccc;">
                  <td>{{ $product->name }}<br />
                    <small> 
                          @if($product->wordcount)<span class="me-2 badge bg-light text-dark"><strong>Words Count:</strong> {{ $product->wordcount }}</span>@endif
                          @if($product->quality)<span class="me-2 badge bg-light text-dark"><strong>Quality:</strong> {{ $product->quality }}</span>@endif
                          @if($product->imagecount)<span class="me-2 badge bg-light text-dark"><strong>Image Count:</strong> {{ $product->imagecount }}</span>@endif
                          <br />
                          @if($product->quantity)<span class="me-2 badge bg-light text-dark"><strong>Quantity:</strong> {{ $product->quantity }}</span>@endif
                          @if($product->turnaround)<span class="me-2 badge bg-light text-dark"><strong>Turnaround Time:</strong> {{ $product->turnaround }}</span>@endif
                          @if($product->delivery)<span class="me-2 badge bg-light text-dark"><strong>Delivery In:</strong> {{ $product->delivery }}</span>@endif<br>
                          @if($product->project_title)<span class="me-2 badge bg-light text-dark"><strong>Project Title:</strong> {{ $product->project_title }}</span>@endif
                          <br />
                          @if($product->subject)<span class="me-2 badge bg-light text-dark"><strong>Subject:</strong> {{ $product->subject }}</span>@endif
                          @if($product->preferred_voice)<span class="me-2 badge bg-light text-dark"><strong>Preferred Voice:</strong> {{ $product->preferred_voice }}</span>@endif
                          @if($product->preferred_writing_style)<span class="me-2 badge bg-light text-dark"><strong>Preferred Writing Style:</strong> {{ $product->preferred_writing_style }}</span>@endif
                          @if($product->brand_name)<span class="me-2 badge bg-light text-dark"><strong>Brand Name:</strong> {{ $product->brand_name }}</span>@endif
                          @if($product->audience)<span class="me-2 badge bg-light text-dark"><strong>Audience:</strong> {{ $product->audience }}</span>@endif
                    </small>
                </td>
                  <td>One Time</td>
                  <td align="center">{{ $product->quantity }}</td>
                  <td align="right">{{ site_currency() . number_format($product->unit_price * $product->quantity, 2) }}</td>
                </tr>
                @endforeach
              </table>
            </td>
          </tr>
          </table>
        </td>
      </tr>

    <!-- Note -->
      <!-- Totals Section -->
      <tr>
        <td style="padding: 20px 30px 40px;">
          <table width="100%" style="font-size: 14px;">
            <tr>
              <td></td>
              <td width="300px">
                <table width="100%">
                  <tr>
                    <td>Sub Total</td>
                    <td align="right">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                  </tr>
                  <tr>
                    <td>Discount</td>
                    <td align="right">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                  </tr>
                  <tr>
                    <td style="padding-top: 10px; font-weight: bold;">GRAND TOTAL</td>
                    <td align="right" style="padding-top: 10px; font-weight: bold;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>

    <tr style=" background: url('{{ $invoice_footer_image }}');background-repeat: no-repeat; background-size: cover;background-position: center;height: 104px;">
        <td style=" padding: 0px; color: #ffffff; font-size: 12px; text-align: center;">
        </td>
    </tr>
  </table>
</body>

</html>