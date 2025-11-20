<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <link href="https://fonts.cdnfonts.com/css/calibri-light" rel="stylesheet">
    <style>
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }
       
       
        table, th, td {
            border-collapse: collapse;
        } 
        .add-h6 h6{
            font-family: Arial;
            font-size: 8px;
            color: #000000cf;
            font-weight: 500;
            padding: 7px 0px;
        }
        .invies-content h3{
            font-family: Arial;
            font-size: 11px;
            font-weight: bold;
            padding: 15px 0px;
            color: #000000a1;
            position: relative;

        }
        .invies-content p {
            font-family: Arial;
            font-size: 8px;
            padding: 4px 0px;
            color: #000000a1;
        }
        .invies-content{
            padding: 30px 40px;
        }
        .invies-content span{
            color: #D29F53;
            padding: 0px 9px;
            font-size: 8px;
        }
        .invies-content h2{
            font-size: 30px;
            font-family: arial;
            letter-spacing: 5px;
            font-weight: bold;
            color: #D29F53;
            border: 1px solid #000000cf;
            padding: 10px 10px;
        }

        .invies-content h6{
            font-size: 12px;
            font-weight: 500;
            font-family: Arial;
            text-align: end;
            padding: 6px 0px;
        }
        .invies-content h3::after {
            content: "";
            position: absolute;
            background: url('{{ $invoice_image1 }}') no-repeat;
            width: 47px;
            height: 30px;
            background-size: contain;
            left: -7px;
            top: 5px;
        }
        .invies-content-two h3::after {
            right: 90px;
            left: auto;
            transform: rotate(180deg)
         }
         .table-list h6{
            font-size: 9px;
            font-family: Arial;
            color: #000000b0;
            font-weight: bold;
            text-align: center;
        }
        .table-list p{
            font-size: 10px;
            font-family: Arial;
            color: #0000008c;
            text-align: center;
        }
        .table-list th{
            font-size: 11px;
            font-family: Arial;
            color: #000;
            font-weight: bold;
            background-color:#D29F53;
            padding: 16px 0px;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }
        .table-list td{
            background: rgba(128, 128, 128, 0.22);
            padding: 16px 0px;
            border-bottom: 1px solid #000;
        }
        .table-list td:last-child{
            background-color:#D29F53;
        }
        .table-list h5{
            font-size: 11px;
            font-family: Arial;
            color: #D29F53;
            text-align: center;
            padding: 8px 0px;
            font-weight: bold;
        }

    </style>
</head>
<body>
    <table width="800" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
        <tr>
            <td style="background-size: cover; height: 100%;">
                <table width="800" cellspacing="0" cellpadding="0" border="0"  style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                   <tbody>
                    <tr>
                        <td>
                            <table style="width: 100%;table-layout: fixed;">
                                <tr>
                                    <td>
                                        <img src="{{ $invoice_header_image }}" alt="" style="height: 135px;">
                                    </td>
                                    <td style="width:27%;">
            
                                    </td>
                                    <td>
                                     <div style="display: flex; justify-content: center; align-items: center;">
                                        <div style="background: url({{ $invoice_image2 }}) no-repeat; background-position: center center; background-size: contain; width: 47px; height: 127px;">
                                        
                                        </div>
                                         <div class="add-h6" style="width: 100px;">
                                           <h6 style="margin-bottom: 0px;" >{{ $company_mobile }}</h6>
                                           <h6 style="margin-bottom: 0px;">{{ $company_email }}</h6>
                                           <h6 style="margin-bottom: 0px;">{{ $site->site_link }}</h6>
                                           <h6 style="margin-bottom: 0px;">{!! $company_address !!}</h6>
                                         </div>
                                     </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 24px 0px;">
                            <table style="border-bottom: 0px solid #0000004d;">
                                <tbody>
                                    <tr>
                                        <td style="width: 30%;">
                                            <div class="invies-content">
                                              <h3>INVOICE TO</h3>
                                              <table>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <p>Name</p>
                                                        </td>
                                                        <td>
                                                            <span> # </span>
                                                        </td>
                                                        <td>
                                                            <p>{{ $customer_name }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Email</p>
                                                        </td>
                                                        <td>
                                                            <span> # </span>
                                                        </td>
                                                        <td>
                                                            <p>{{ $customer_email }}</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                              </table>
                                            </div>  
                                          </td>
                                          <td style="width: 30%;">
                                              <div class="invies-content invies-content-two">
                                                  <h3>INVOICE FROM</h3>
                                                  <table>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <p>Name</p>
                                                            </td>
                                                            <td>
                                                                <span> # </span>
                                                            </td>
                                                            <td>
                                                                <p>{{ $site_name }}</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>Phone</p>
                                                            </td>
                                                            <td>
                                                                <span> # </span>
                                                            </td>
                                                            <td>
                                                                <p>{{ $company_mobile }}</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>Address</p>
                                                            </td>
                                                            <td>
                                                                <span> # </span>
                                                            </td>
                                                            <td>
                                                                <p>{{ $company_name }} <br> {!! $company_address !!}</p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                  </table>
                                              </div>
                                          </td>
                                          <td style="width: 30%;">
                                              <div class="invies-content">
                                                  <h2>INVOICE</h2>
                                                  <h6>Invoice No: #{{ $invoice_number }}</h6>
                                              </div>
                                          </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0px 40px 100px">
                        <div style="min-height: 550px !important;">
                          <table class="table-list" style="width: 100%;"> 
                            <tbody>
                                <tr>
                                    <th>PRODUCT</th>
                                    <th>TYPE</th>
                                    <th>BILLING TYPE</th>
                                    <th>QTY</th>
                                    <th>TOTAL</th>
                                </tr>

                                @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <h6>{{ $product->name }}</h6>
                                    </td>
                                    <td>
                                        <p>{{ $product->category_name }}</p>
                                    </td>
                                    <td>
                                        <p>One Off</p>
                                    </td>
                                    <td>
                                        <p>01</p>
                                    </td>
                                    <td>
                                        <p>{{ site_currency() . number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}</p>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" style="border: 0px;  padding: 10px 0px;  background-color: transparent;"></td>
                                    <td style="padding: 0px; border: 0px;">
                                        <p>Sub Total</p>
                                    </td>
                                    <td style="padding: 0px; border: 0px; background: rgba(128, 128, 128, 0.22);">
                                        <p>{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="border: 0px; padding: 10px 0px; background-color: transparent;"></td>
                                    <td style="padding: 0px; border: 0px;">
                                        <p>Discount </p>
                                    </td>
                                    <td style="padding: 0px; border: 0px; background: rgba(128, 128, 128, 0.22);">
                                        <p> {{ site_currency() . number_format($discount_amount, 2) }}</p>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td colspan="3" style="border: 0px; padding: 10px 0px;background-color: transparent;"></td>
                                    <td style="padding: 0px; border: 0px; background: #495261;">
                                        <h5>GRAND TOTAL</h5>
                                    </td>
                                    <td style="padding: 0px; border: 0px;background: #495261;">
                                        <h5>{{ site_currency() . number_format($invoice_amount, 2) }}</h5>
                                    </td>
                                </tr>
                            </tbody>
                          </table>
                        </div>
                        </td>
                    </tr>
                   </tbody>
                   <tfoot>
                        <tr>
                            <td style="width: 100%; background: url('{{ $invoice_footer_image }}') no-repeat; background-size:cover;padding: 50px 0px;border-right: 20px solid #D29F53;">
                                
                            </td>
                        </tr>
                   </tfoot>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
