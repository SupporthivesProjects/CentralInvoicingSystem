<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #F2F3F3;padding-top: 30px">
  <table width="100%" cellpadding="0" cellspacing="0" border="0"
    style="max-width: 90%; margin: 0 auto; background-color: #ffffff;border-top-left-radius: 20px;border-bottom-left-radius: 20px;border-bottom-right-radius: 20px;">
    <!-- Header with Logo -->
    <tr>
      <td style="padding: 0px 0px 0px 0px;background-color: #F2F3F3;">
        <table width="100%" cellpadding="10" cellspacing="0">
            <tr>
              <td style=" background-color: #ffffff;border-top-left-radius: 20px; border-top-right-radius: 20px;padding-left:20px; padding-top:20px;">
                <img src="{{ $company_logo }}" width="200" alt=""><br><br>
                <p style="margin: 0; font-size: 12px;">{{ $company_name }}</p>
              </td>
              <td valign="top" align="right" style=" background-color: #ffffff; padding: 0px">
              <div style = "background-color: #F2F3F3;border-bottom-left-radius: 20px;padding-top:20px;padding-right:20px;padding-bottom:20px;">
              <div style="display:inline-block; border:1px solid #f28d40; padding:6px; border-radius:50%;">
    <p style="margin:0; font-size:12px;">{{ $company_mobile }}</p>
</div>

                <p style="margin: 0; font-size: 12px; color: #007BFF;">{{ $company_email }}</p>
                <p style="margin: 0; font-size: 12px;">{!! $company_address !!}</p>
              </div>
                
              </td>
            </tr>
        </table>
      </td>
    </tr>

    <!-- Invoice Number and Date -->
      <tr>
        <td style="padding: 20px;">
          <table width="100%" cellpadding="10" cellspacing="0" style="border: 1px solid #f28d40; border-collapse: collapse;">
            <tr style="background-color: #fff1e6;">
              <th style="border: 1px solid #f28d40; text-align: left;width: 40%;">Bill To</th>
              <th style="border: 1px solid #f28d40; text-align: left;width: 60%;">Bill From</th>
              
            </tr>
            <tr>
              <td style="border: 1px solid #f28d40;width: 30%;">
                <strong>Name:</strong> {{ $customer_name }}<br />
                <!-- <strong>Email:</strong> {{ $customer_mobile }}<br /> -->
              </td>
              <td style="border: 1px solid #f28d40;width: 70%;">
                <strong>Name:</strong> {{ $company_name }}<br />
                <strong>Address:</strong> {!! $company_address !!}<br />
                <strong>Email:</strong> {{ $company_email }}<br />
                <strong>Phone:</strong> {{ $company_mobile }}
              </td>
              
            </tr>
          </table>
        </td>
      </tr>

      <!-- Table -->
      <tr>
        <td style="padding: 20px;">
        <div style="min-height:550px !important;">
          <table width="100%" cellpadding="10" cellspacing="0" style="border: 1px solid #f28d40; border-collapse: collapse;">
            <tr style="background-color: #fff1e6;">
              <th style="border: 1px solid #f28d40; text-align: left;width: 10%;">Qty.</th>
              <th style="border: 1px solid #f28d40; text-align: left;width: 50%;">Description</th>
              <th style="border: 1px solid #f28d40; text-align: right;width: 20%;">Unit price</th>
              <th style="border: 1px solid #f28d40; text-align: right;width: 20%;">Total</th>
            </tr>
            @foreach($products as $index => $product)
            <tr>
              <td style="border: 1px solid #f28d40;">{{ $product->quantity }}</td>
              <td style="border: 1px solid #f28d40;">{{ $product->name }}/ 
              @if($product->wordcount)<span class="me-2 badge bg-light text-dark"><strong>Words Count:</strong> {{ $product->wordcount }}</span>@endif
                  @if($product->quality)<span class="me-2 badge bg-light text-dark"><strong>Quality:</strong> {{ $product->quality }}</span>@endif
                  @if($product->imagecount)<span class="me-2 badge bg-light text-dark"><strong>Image Count:</strong> {{ $product->imagecount }}</span>@endif
                  <br />
                  @if($product->quantity)<span class="me-2 badge bg-light text-dark"><strong>Quantity:</strong> {{ $product->quantity }}</span>@endif
                  @if($product->turnaround)<span class="me-2 badge bg-light text-dark"><strong>Turnaround Time:</strong> {{ $product->turnaround }}</span>@endif
                  @if($product->delivery)<span class="me-2 badge bg-light text-dark"><strong>Delivery In:</strong> {{ $product->delivery }}</span>@endif<br>
                  @if($product->project_title)<span class="me-2 badge bg-light text-dark"><strong>Project Title:</strong> {{ $product->project_title }}</span>@endif
                  <br>
                  @if($product->subject)<span class="me-2 badge bg-light text-dark"><strong>Subject:</strong> {{ $product->subject }}</span>@endif
                  @if($product->preferred_voice)<span class="me-2 badge bg-light text-dark"><strong>Preferred Voice:</strong> {{ $product->preferred_voice }}</span>@endif
                  @if($product->preferred_writing_style)<span class="me-2 badge bg-light text-dark"><strong>Preferred Writing Style:</strong> {{ $product->preferred_writing_style }}</span>@endif
                  @if($product->brand_name)<span class="me-2 badge bg-light text-dark"><strong>Brand Name:</strong> {{ $product->brand_name }}</span>@endif
                  @if($product->audience)<span class="me-2 badge bg-light text-dark"><strong>Audience:</strong> {{ $product->audience }}</span>@endif
                  
              </td>
              <td style="border: 1px solid #f28d40; text-align: right;">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
              <td style="border: 1px solid #f28d40; text-align: right;">{{ site_currency() . number_format($product->unit_price * $product->quantity, 2) }}</td>
            </tr>
            @endforeach

            <tr><td colspan="4" style="border: 1px solid #f28d40;">&nbsp;</td></tr>

            <!-- Totals -->
            <tr>
              <td colspan="3" style="border: 1px solid #f28d40; text-align: right;">Subtotal</td>
              <td style="border: 1px solid #f28d40; text-align: right;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
            </tr>
            <tr>
              <td colspan="3" style="border: 1px solid #f28d40; text-align: right;">Discount Total</td>
              <td style="border: 1px solid #f28d40; text-align: right;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
            </tr>
         
            <tr style="background-color: #f28d40; color: #000;">
              <td colspan="3" style="border: 1px solid #f28d40; text-align: right;"><strong>Total</strong></td>
              <td style="border: 1px solid #f28d40; text-align: right;"><strong>{{ site_currency() . number_format($invoice_amount, 2) }}</strong></td>
            </tr>
          </table>
        </div>
        </td>
      </tr>



    <!-- Footer -->



    <tr style="height: 75px;">
      <td style=" padding: 0px 75px 28px 75px; color: #ffffff; font-size: 12px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;" valign="bottom" >
        <hr style="background: #7F8082;margin: 0;">
      </td>
    </tr>
  </table>
</body>

</html>