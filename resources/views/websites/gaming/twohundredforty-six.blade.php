<!DOCTYPE html>
<html>
  <head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
  @page {
      margin: 0;               /* Removes ALL PDF margins */
      padding: 0;
  }

  body {
      margin: 0 !important;    /* Removes browser margin */
      padding: 0 !important;
      background: #000000;
  }

  html, body, table {
      width: 100%;
      height: 100%;
  }

  table {
      border-collapse: collapse;
  }

  /* Prevents phantom bottom spacing in PDF */
  * {
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
  }
</style>

   </head> 

<body style="margin:0; padding:0; background:#000000 width:100%;">

  <!-- FULL WRAPPER -->
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding:0; background:#000;">
    <tr>
      <td align="center" style="padding:0px;">

        <!-- MAIN CONTAINER -->
        <table width="100%" cellpadding="0" cellspacing="0" border="0"
          style="background:#1a1a1d; ">

          <!-- BG SECTION -->
          <tr>
            <td style="background:url('{{ $invoice_image1 }}') center center / cover no-repeat; padding:40px 30px 500px;">

              <!-- HEADER SECTION -->
              <table width="100%" cellpadding="0" cellspacing="0" style="padding:0px 40px 20px;">
                <tr>
                  <!-- LEFT: BIG INVOICE -->
                  <td align="left" valign="top" style="padding:0;">
                    <span style="
                      font-family:Arial Black, Arial, sans-serif;
                      color:#ffffff;
                      font-size:47px;
                      letter-spacing:2px;
                      display:block;">
                      INVOICE
                    </span>
                  </td>

                  <!-- RIGHT: LOGO -->
                  <td align="right" valign="cemtre" style="padding:0;">
                    <img src="{{ $company_logo }}" width="150" style="display:block;">
                  </td>
                </tr>

                <!-- SMALL ROW UNDER TITLE: INVOICE NUMBER + DATE -->
                <tr>
                  <td colspan="2" style="padding-top:4px;">
                    <table width="53%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" style="font-family:serif; color:#ffffff; font-size:9px;">
                          Invoice #{{ $invoice_number }}
                        </td>
                        <td align="right" style="font-family:Arial; color:#ffffff; font-size:9px;">
                          {{ $invoice_date }}
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              <!-- END HEADER -->

              <!-- INVOICE TO SECTION -->
              <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0 20px;">
                <tr>
                  <td align="center" style="color:#ffffff; font-family:Arial; font-size:9px;">
                    Invoice To :
                  </td>
                </tr>

                <!-- PINK LINE -->
                <tr>
                  <td align="center" style="padding-top:8px;">
                    <table width="85%" cellpadding="0" cellspacing="0" align="center">
                      <tr>
                        <td style="border-bottom:1px solid #ff29e4;"></td>
                      </tr>
                    </table>
                  </td>
                </tr>

                <!-- CUSTOMER NAME -->
                <tr>
                  <td align="center" style="color:#ffffff; font-family:Arial; font-size:9px; padding-top:16px;">
                    {{ $customer_name }}<br>
                    {{ $customer_email }}
                  </td>
                </tr>
              </table>
              <!-- END INVOICE TO -->

              <!-- TABLE HEADER -->
              <table width="85%" cellpadding="0" cellspacing="0"
                style="margin: 20px auto 0px; border-collapse:collapse;">
                <tr>
                  <td width="40%" style="background:#ff29e4; color:#ffffff; font-family:Arial;
                      font-size:9px; padding:10px 40px; font-weight:bold;">
                    DESCRIPTION
                  </td>
                  <td width="20%" style="background:#ff29e4; color:#ffffff; font-family:Arial;
                      font-size:9px; padding:10px 40px; font-weight:bold;">
                    UNIT PRICE
                  </td>
                  <td width="10%" style="background:#ff29e4; color:#ffffff; font-family:Arial;
                      font-size:9px; padding:10px 40px; font-weight:bold;">
                    QTY
                  </td>
                  <td width="20%" style="background:#ff29e4; color:#ffffff; font-family:Arial;
                      font-size:9px; padding:10px 40px; font-weight:bold;">
                    TOTAL
                  </td>
                </tr>

                <!-- ITEM ROWS -->
                @foreach($products as $product)
                <tr>
                  <td
                    style="color:#ffffff; font-family:Arial; font-size:9px; padding:10px 40px; border-bottom:1px solid ;">
                    {{ $product['name'] }} 
                  </td>
                  <td style="color:#ffffff; font-family:Arial; font-size:9px; border-bottom:1px solid ;padding:10px 40px;">
                    {{ site_currency() . number_format($product['unit_price'], 2) }}
                  </td>
                  <td style="color:#ffffff; font-family:Arial; font-size:9px; border-bottom:1px solid ;padding:10px 40px;">
                    1
                  </td>
                  <td style="color:#ffffff; font-family:Arial; font-size:9px; border-bottom:1px solid ;padding:10px 40px;">
                    {{ site_currency() . number_format($product['unit_price'], 2) }}
                  </td>
                </tr>
                @endforeach

                

              </table>
              <!-- END TABLE -->

              <!-- TOTALS -->
              <table width="31%" cellpadding="0" cellspacing="0" style="padding-top:40px;margin-left: auto; margin-right: 40px;">

                <!-- SUB TOTAL -->
                <tr>
                  <td align="right" style="color:#fff; font-family:Arial; font-size:9px;">
                    Sub Total
                  </td>
                  <td width="120" align="right" style="color:#fff; font-family:Arial; font-size:9px;">
                    {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                  </td>
                </tr>

                <!-- DISCOUNT -->
                <tr>
                  <td align="right" style="color:#fff; font-family:Arial; font-size:9px; padding-top:6px;">
                    Discount
                  </td>
                  <td align="right" style="color:#fff; font-family:Arial; font-size:9px; padding-top:6px;">
                    {{ site_currency() . number_format($discount_amount, 2) }}
                  </td>
                </tr>

                <!-- PINK DIVIDER LINE -->
                <tr>
                  <td colspan="2" style="padding-top:12px; padding-bottom:6px;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td style="border-bottom:2px solid #ff29e4;"></td>
                      </tr>
                    </table>
                  </td>
                </tr>

                <!-- TOTAL -->
                <tr>
                  <td align="right"
                    style="color:#ff29e4; font-family:Arial; font-size:9px; font-weight:bold; padding-top:6px;">
                    TOTAL
                  </td>
                  <td align="right"
                    style="color:#ff29e4; font-family:Arial; font-size:9px; font-weight:bold; padding-top:6px;">
                    {{ site_currency() . number_format($invoice_amount, 2) }}
                  </td>
                </tr>

              </table>


            </td>
          </tr>

        </table>
        <!-- END MAIN WRAPPER -->

      </td>
    </tr>
  </table>

</body>

</html>