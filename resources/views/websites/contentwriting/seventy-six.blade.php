<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0; height: 130px;">
                            <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                                <tr>
                                    <td style="
                                        background: url('{{ $invoice_header_image  }}') no-repeat center;
                                        background-size: cover;
                                        height: 130px;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Header End -->
                    

                    <!-- Content -->
                    <tr>
                        <td
                            style="padding:40px;padding-top:0px;background:#ffffff; background-repeat: no-repeat;background-position: center;background-size: cover;height:444px; font-family: 'Yu Gothic';">
                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="font-family: 'Arial'; border-collapse: collapse;">
                                <tr>
                                    <!-- Left Side -->
                                    <td style="width: 60%; vertical-align: top;">
                                        <p style="margin: 0; font-size: 10px;"><strong>Date:</strong> {{ $invoice_date }}
                                        </p>
                                        <p style="margin: 0; font-size: 10px;"><strong>Invoice Number:</strong> #{{ $invoice_number }}
                                        </p>

                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>

                                        <p style="font-size: 12px; margin: 0;">Billed From:</p>
                                        <p style="margin: 0;"><a href="#"
                                                style="color: #0000EE; text-decoration: underline; font-size: 12px;">{{ $site_name }}</a>
                                        </p>
                                        <p style="margin: 0; font-size: 10px;"><strong>Email:</strong>
                                            {{ $company_email }}</p>
                                        <p style="margin: 0; font-size: 10px;"><strong>Website:</strong> {{ $site->site_link }}
                                        </p>
                                        <p style="margin: 0; font-size: 10px;"><strong>Phone:</strong> {{ $company_mobile }}</p>
                                        <p style="margin: 0; font-size: 10px;"><strong>Address:</strong>{!! $company_address !!}</p>
                                    </td>
                                    <br>

                                    <!-- Right Side with SVG background -->
                                    <td style="width: 40%; text-align: right; vertical-align: top; position: relative;">
                                        <br>
                                        <br>
                                        <br>
                                        <div style="position: relative; display: inline-block;">
                                            <!-- SVG Shape -->
                                            <img src="{{ $invoice_image2 }}" alt=""
                                                style="position: absolute; z-index: 0; width: 120px; right: 113px; top: -33px;">

                                            <!-- Text Over SVG -->
                                            <h1
                                                style="margin: 0; font-size: 32px; position: relative; z-index: 1; font-size: 28px; font-weight: bold;">
                                                INVOICE</h1>
                                        </div>

                                        <p style="margin-top: 30px; font-size: 12px;">Billed To:<br>{{ $customer_name }}</p>
                                    </td>
                                </tr>
                            </table>
                            <br>
            
                            <!-- PRODUCT TABLE -->
                            <div style="min-height:450px !important;">
                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="font-family: Arial; border-collapse: collapse;">
                                <tr style="background-color: #F3EFE9; font-size: 12px; border-bottom: 1px solid #D0CECE;">
                                    <th align="left">Item</th>
                                    <th align="left">Description</th>
                                    <th align="center">Quantity</th>
                                    <th align="right">Unit Price</th>
                                    <th align="right">Total</th>
                                </tr>
                                @foreach($products as $product)
                                <tr style="border-bottom: 1px solid #D0CECE; font-size: 8px;">
                                    <td>{{ $product->name }}</td>
                                    <td> <p style="width: 133px;">
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
                                        </p>
                                    </td>
                                    <td align="center">{{ $product->quantity }}</td>
                                    <td align="right">{{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                    <td align="right">{{ site_currency() . number_format($product->unit_price * $product->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </table>
                           
                            <table align="right" cellpadding="5" cellspacing="0"
                                    style="font-family: Arial; width: 250px; z-index: 1; position: relative;">
                                    <tr>
                                        <td align="left" style="font-size: 11px; border-bottom: 1px solid #D0CECE;">Subtotal</td>
                                        <td align="right" style="font-size: 8px; border-bottom: 1px solid #D0CECE;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td align="left" style="font-size: 11px;">Discount</td>
                                        <td align="right" style="font-size: 8px;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                    </tr>
                                    <tr style="background-color: #E6DDD1;">
                                        <td align="left" style="font-size: 11px;">Grand<br>Total</td>
                                        <td align="right" style="font-size: 8px;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                    </tr>
                                </table>
                            </div>
                            <!-- Container for footer and SVGs -->
                            <div style="position: relative; padding: 40px 0; top: 62px;">

                                <!-- Left background SVG -->
                                <div style="position: absolute; bottom: 0; left: 0; z-index: 0;">
                                    <img src="{{ $invoice_image2 }}" alt="" style="width: 120px;">
                                </div>

                                <!-- Center background SVG -->
                                <div style="position: absolute; bottom: 0; left: 140px; z-index: 0;">
                                    <img src="{{ $invoice_image2 }}" alt="" style="width: 80px;">
                                </div>
                            </div>


                        </td>
                    </tr>
                    <!-- Content End-->


                    <!-----------Footer----------->
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="" border="0px"
                                style="border-collapse: collapse;">
                                <tr
                                    style="background: url(./images/footer.png) no-repeat;background-position: center;background-size: cover;height:75px;padding:50px;background-size:cover;width: 100%;">
                                    <td>

                                    </td>
                                </tr>
                                <tr>
                            </table>
                        </td>
                    </tr>
                    <!-----------Footer End----------->
                </table>
            </td>
        </tr>
    </table>
</body>

</html>