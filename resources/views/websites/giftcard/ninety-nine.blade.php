<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <table style="width: 100%; border: 2px solid black; border-collapse: collapse; margin: 20px auto;">

                        <!-- Header -->
                        <tr>
                          <td colspan="2" style="background-color: #92D050; color: #003366; text-align: center; font-size: 24px; font-weight: bold; padding: 10px; border-bottom: 2px solid black;">
                            INVOICE
                          </td>
                        </tr>
                      
                        <!-- Main 2-column Layout -->
                        <tr>
                          <!-- LEFT COLUMN -->
                          <td style="width: 25%; border-right: 2px solid black; vertical-align: top; padding-top: 100px; font-size: 10px;font-family: arial; background-color: #fff;">
                            <div style="display: flex;">
                                <img src="{{ $company_logo }}" alt="Logo" style="height: 60px;margin-left: auto; margin-right: auto;"><br><br>

                            </div>
                            <p style="text-align: center; color: #003366;"><b>

                            {{ $company_name  }}</b></p>
                           <p style="text-align: center;"> {!! $company_address !!} <br> {{ $company_mobile }} </p>
                            <p style="text-align: center;"><a href="#" style="color: blue;">{{ $site_name }} </a><br>
                            <a href="#" style="color: blue;text-align: center;">{{ $site->site_link }}</a></p>
                          </td>
                      
                          <!-- RIGHT COLUMN -->
                          <td style="width: 75%; padding: 15px; vertical-align: top;background-color: #fff;">
                      
                            <!-- Invoice details -->
                            <div style="margin-bottom: 15px; font-size: 12px;font-family: arial;">

                                <div style="display: flex; justify-content: space-between;">
                                    <p style="color: #003366;font-family: arial;font-weight: bold; margin: 0;">INVOICE NO.: <br> {{ $invoice_number }} </p>
                                        <p style="text-align: right;color: #003366;font-family: arial;font-weight: bold; margin: 0;">DATE      {{ $invoice_date  }}<br><br></p>

                                </div>
                              </span></p>
                             
                              <p style="color: #003366;font-family: arial;font-weight: bold;">BILL TO</p>
                             <p style="color: black;font-family: arial;"> {{ $customer_name  }}</p>
                            </div>
                      
                            <!-- Inner Table (inside right cell) -->
                            <table style="width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px;font-family: arial;">
                              <tr style="background-color: #92D050; font-weight: bold; text-align: center; color: #003366;font-family: arial;">
                                <td style="border: 2px solid black; padding: 8px; width: 50%;">DESCRIPTION</td>
                                <td style="border: 2px solid black; padding: 8px;">AMOUNT</td>
                                <td style="border: 2px solid black; padding: 8px;">TOTAL</td>
                              </tr>
                              @foreach($products as $product)
                              <tr style="color: #003366;">
                                <td style="border: 2px solid black; padding: 8px;font-family: arial;">{{ $product->name }}</td>
                                <td style="border: 2px solid black; padding: 8px; text-align: center;">
                                <div style="display: flex;justify-content: space-between;">
                                    <p style="margin:0">{{ site_currency_code() }}</p>
                                    <p style="margin:0">{{ site_currency() }}{{ number_format($product->unit_price, 2) }}</p>
                                </div></td>
                                <td style="border: 2px solid black; padding: 8px; text-align: center;"><div style="display: flex;justify-content: space-between;">
                                    <p style="margin:0">{{ site_currency_code() }}</p>
                                    <p style="margin:0">{{ site_currency() }}{{ number_format($product->unit_price, 2) }}</p>
                                </div></td>
                              </tr>
                              @endforeach
                             
                              <tr style="color: #003366;font-family: arial;">
                                <td style="border: 2px solid black; padding: 8px;">Sub Total:</td>
                                <td style="border: 2px solid black; padding: 8px; text-align: center;"><div style="display: flex;justify-content: space-between;">
                                    <p style="margin:0">{{ site_currency_code() }}</p>
                                    <p style="margin:0">{{ site_currency() }}{{ number_format(($invoice_amount + $discount_amount), 2) }}</p>
                                </div></td>
                                <td style="border: 2px solid black; padding: 8px; text-align: center;"><div style="display: flex;justify-content: space-between;">
                                    <p style="margin:0">{{ site_currency_code() }}</p>
                                    <p style="margin:0">{{ site_currency() }}{{ number_format(($invoice_amount + $discount_amount), 2) }}</p>
                                </div></td>
                              </tr>
                              <tr style="color: #003366;font-family: arial;">
                                <td style="border: 2px solid black; padding: 8px;">Discount:</td>
                                <td style="border: 2px solid black; padding: 8px; text-align: center;"><div style="display: flex;justify-content: space-between;">
                                    <p style="margin:0">{{ site_currency_code() }}</p>
                                    <p style="margin:0">{{ site_currency() }}{{ number_format($discount_amount, 2) }}</p>
                                </div></td>
                                <td style="border: 2px solid black; padding: 8px; text-align: center;"><div style="display: flex;justify-content: space-between;">
                                    <p style="margin:0">{{ site_currency_code() }}</p>
                                    <p style="margin:0">{{ site_currency() }}{{ number_format($discount_amount, 2) }}</p>
                                </div></td>
                              </tr>
                              <tr style="background-color: #92D050; font-weight: bold;color: #003366;font-family: arial;">
                                <td colspan="2" style="border: 2px solid black; text-align: right; padding: 8px;">TOTAL AMOUNT</td>
                                <td style="border: 2px solid black; text-align: center; "><div style="display: flex;justify-content: space-between;">
                                    <p style="margin:0">{{ site_currency_code() }}</p>
                                    <p style="margin:0">{{ number_format($invoice_amount, 2) }}</p>
                                </div></td>
                              </tr>
                            </table>

                            <table style="width: 100%;font-family: arial; margin-top: 10px;">
                                <tr>
                                    <td colspan="2" style="padding: 0; background-color: #DAF1F3; font-size: 14px; width: 100%;">
                                      <p style="margin: 0;font-size: 24px;"><b>Payments/Credits DRH</b></p>
                                       {!! $site->site_description !!}
                                    </td>
                                  </tr>
                                
                            </table>
                            <div style="display: flex; justify-content: space-between;">
                                <div>
                                  <p style="color: #003366;font-family: arial;">Company Signature</p><br>
                                </div>
                               
                              </div>
                      
                          </td>
                        </tr>
                      
                        <!-- Payments Section -->
                        
                      </table>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
