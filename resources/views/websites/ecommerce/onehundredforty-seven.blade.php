<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <link href="https://fonts.cdnfonts.com/css/calibri-light" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
            font-family: 'Calibri';
        }
        @font-face {
            font-family: 'Calibri';
            src: url("{{ asset('fonts/calibri-bold.ttf') }}");
            font-weight: bold;
        }
        @font-face {
            font-family: 'Calibri';
            src: url("{{ asset('fonts/calibri-regular.ttf') }}");
            font-weight: normal;
        }
       
        table, th, td {
            border-collapse: collapse;
        } 
        
        .table-heade h2{
            font-size: 26px;
            font-family: 'Calibri';
            color: skyblue;
            font-weight: bold;
            text-align: right;
            margin-bottom: 2rem;
        }
        .table-heade h6{
            font-size: 11px;
            font-family: 'Calibri';
            color: skyblue;
            font-weight: bold;
            display: flex;
            text-align: right;
            justify-content: right;
        }
        .table-heade p{
            font-size: 11px;
            font-family: 'Calibri';
            color: #000;
            font-weight: normal;
            padding: 0px 5px;  
        }
        .table-heade h3{
            font-size: 11px;
            font-family: 'Calibri';
            color: #000;
            font-weight: bold;
            margin-bottom: 3rem;
        }
        
        .table-list p{
            font-size: 11px;
            font-family: 'Calibri';
            color: #000;
            font-weight: normal;
        }
        .table-list h6{
            font-size: 11px;
            font-family: 'Calibri';
            color: #000;
            font-weight: bold;
            text-align: right;
            justify-content: right;
            margin: 6px 0px;
            width: 100px 
        }
        .table-heade{
            border-bottom: 0px solid #0000004d;
            width: 100%;
            table-layout: fixed;
        }
        .table-list th{
            font-size: 11px;
            font-family: 'Calibri';
            color: skyblue;
            font-weight: bold;
            border-bottom: 2px solid skyblue;
            padding-bottom: 3px;
        }
        .table-list td {
            padding: 4px 0px;
            border-bottom: 1px solid skyblue;
        }
        tfoot td h4{
            font-size: 11px;
            font-family: 'Calibri';
            color: skyblue;
            font-weight: bold;
            padding-top: 6px;
            text-align: center;
        }
        .table-footer div{
            background-color: #3DBAF8;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            color: #fff;
            font-size: 14px;
        }
        .table-footer  h3{
            font-size: 11px;
            font-family: 'Calibri';
            color: #000;
            font-weight: bold;
            text-align: center;
            justify-content: center;
            margin: 6px 0px;
        }
        .table-footer p {
            font-size: 11px;
            font-family: 'Calibri';
            color: #000;
            font-weight: normal;
        }

    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
        <tr>
            <td style="background-size: cover; height: 100%;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0"  style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                   <tbody>
                    <tr>
                        <td style="background: url('{{ $invoice_header_image }}') no-repeat; background-size:cover;padding: 66px 0px;">
                            
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 24px 50px;">
                            <table class="table-heade" style="border-bottom: 0px solid #0000004d;">
                                <tbody>
                                   <tr>
                                        <td>
                                            <h3>{{ $site_name }}</h3>
                                        </td>
                                        <td>
                                            <h2>INVOICE</h2>
                                        </td>
                                   </tr>
                                   <tr>
                                    <td style="padding:0px 0px 30px;">
                                        <p>{{ $company_name }}<br>
                                            {!! $company_address !!}</p>
                                        <p>{{ $company_mobile }}</p>
                                        <p>
                                           {{ $company_email }} | {{ $site->site_link }}
                                        </p>
                                    </td>
                                    <td>
                                        <h6>INVOICE #<p> {{ $invoice_number }}</p></h6>
                                        <h6>DATE<p> {{ $invoice_date }}</p></h6>
                                    </td>
                                   </tr> 
                                   <tr>
                                    <td>
                                        <p>TO</p>
                                        <p>{{ $customer_name }}</p>
                                        <p>{{ $customer_email }}</p>
                                    </td>
                                    <td>
                                    
                                    </td>
                                   </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0px 56px 50px">
                        <div style="min-height: 600px !important;">
                          <table class="table-list" style="width: 100%;"> 
                            <tbody>
                                <tr>
                                    <th style="text-align: left;">
                                        Description
                                    </th>
                                    <th style="text-align: right;">
                                        Amount
                                    </th>
                                </tr>
                            @foreach ($products as $product)
                               <tr>
                                <td>
                                    <p>{{ $product->category_name }}<br>{{ $product->name }}</p>
                                </td>
                                <td>
                                    <h6>{{ site_currency() . number_format(($product->quantity ?? 1) * $product->unit_price, 2) }}</h6>
                                </td>
                               </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="text-align: left; padding-top: 7px;">
                                        SubTotal
                                    </th>
                                    <th style="text-align: right; padding-top: 7px;">
                                    {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                                    </th>
                                </tr>
                                <tr>
                                    <th style="text-align: left; padding-top: 7px;">
                                        Discount
                                    </th>
                                    <th style="text-align: right; padding-top: 7px;">
                                        {{ site_currency() . number_format($discount_amount, 2) }}
                                    </th>
                                </tr>
                                <tr>
                                    <th style="text-align: left; padding-top: 7px;">
                                        Total
                                    </th>
                                    <th style="text-align: right; padding-top: 7px;">
                                    {{ site_currency() . number_format($invoice_amount, 2) }}
                                    </th>
                                </tr>
                                <tr>
                                    <td style="border: 0px; width: 100%; padding: 10px 0px;">
                                        <p>Make all checks payable to {{ $company_name }}</p>
                                        <p>Payment is due within 30 days.</p>
                                        <p>If you have any questions concerning this invoice, contact at {{ $company_email }}</p>
                                        <h4 style="text-align: center;">THANK YOU FOR YOUR BUSINESS!</h4>
                                    </td>
                                </tr>
                            </tfoot>
                          </table>
                        </div>
                        </td>
                    </tr>
                    
                   </tbody>
                   <tfoot>
                        <tr>
                            <!-- <td style="width: 100%; background: url(./img/Picture2.png) no-repeat; background-size:cover;padding: 79px 0px;">
                                
                            </td> -->
                            <td style=" padding: 42px 0px;   background: #F4F2F5;">
                                <table  width="800" class="table-footer">
                                    <tbody>
                                        <tr>
                                            <!-- Feature 1: Secure Payment -->
                                            <td align="center">
                                              <div>
                                                <i class="fas fa-credit-card"></i>
                                              </div>
                                              <h3 style="margin: 5px 0;">Secure Payment</h3>
                                              <p style="margin: 0;">100% secure payment<br>Lorem Ipsum</p>
                                            </td>
                                      
                                            <!-- Feature 2: Pro Consultation -->
                                            <td align="center">
                                              <div >
                                                <i class="fas fa-comments"></i>
                                              </div>
                                              <h3 style="margin: 5px 0;">Pro Consultation</h3>
                                              <p style="margin: 0;">Online consulting service<br>Lorem Ipsum</p>
                                            </td>
                                      
                                            <!-- Feature 3: Online Files -->
                                            <td align="center">
                                              <div>
                                                <i class="fas fa-file-alt"></i>
                                              </div>
                                              <h3 style="margin: 5px 0;">Online Files</h3>
                                              <p style="margin: 0;">Start your online course today<br>Lorem Ipsum</p>
                                            </td>
                                      
                                            <!-- Feature 4: Satisfaction Guarantee -->
                                            <td align="center">
                                              <div>
                                                    <i class="fas fa-check-circle"></i>
                                      
                                              </div>
                                              <h3 style="margin: 5px 0;">Satisfaction Guarantee</h3>
                                              <p style="margin: 0;">100% quality products & courses<br>Lorem Ipsum</p>
                                            </td>
                                          </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                   </tfoot>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
