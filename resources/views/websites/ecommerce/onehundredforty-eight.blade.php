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
       
        
        .footer-fixed {
            position: fixed;
            bottom: 0px;
            left: 0;
            right: 0;
            width: 100%;
        }
        table, th, td {
            border-collapse: collapse;
        } 
        .add-h6 h6, .add-h6 a {
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
            font-size: 10px;
            padding: 4px 0px;
            color: #000000a1;
        }
        .invies-content {
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
        .linement {
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            align-items: flex-start;
            gap: 8px;
        }
        .linement .box {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            background: #4A5261;
            padding: 8px;
        }
        .linement .box svg {
            height: 16px;
            width: 16px;
        }
        .linement .box svg path {
            fill: #D2B76A;
        }
        .srom {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
        }
    </style>
</head>
<body>
    <table width="800" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
        <tr>
            <td style="background-size: cover; height: 100%;">
                <table width="800" cellspacing="0" cellpadding="0" border="0"  style="border-collapse: collapse; ">
                   <tbody>
                    <tr>
                        <td>
                            <table style="width: 100%;table-layout: fixed;">
                                <tr>
                                    <td>
                                        <img src="{{ $invoice_header_image }}" alt="" style="height: 135px;">
                                    </td>
                                    <td style="width:25%;">
            
                                    </td>
                                    <td>
                                     <div style="display: flex; justify-content: center; align-items: center;">
                                        
                                         <div class="add-h6" style="width: 300px;">
                                            <div class="linement">
                                                <div class="box">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#D2B76A" d="M160.2 25C152.3 6.1 131.7-3.9 112.1 1.4l-5.5 1.5c-64.6 17.6-119.8 80.2-103.7 156.4 37.1 175 174.8 312.7 349.8 349.8 76.3 16.2 138.8-39.1 156.4-103.7l1.5-5.5c5.4-19.7-4.7-40.3-23.5-48.1l-97.3-40.5c-16.5-6.9-35.6-2.1-47 11.8l-38.6 47.2C233.9 335.4 177.3 277 144.8 205.3L189 169.3c13.9-11.3 18.6-30.4 11.8-47L160.2 25z"/></svg>
                                                </div>
                                                <h6 style="margin-bottom: 0px;margin-top:5px;" >{{ $company_mobile }}</h6>
                                            </div>
                                           <div class="linement">
                                                <div class="box">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#D2B76A" d="M290.5 287.7L491.4 86.9 359 456.3 290.5 287.7zM457.4 53L256.6 253.8 88 185.3 457.4 53zM38.1 216.8l205.8 83.6 83.6 205.8c5.3 13.1 18.1 21.7 32.3 21.7 14.7 0 27.8-9.2 32.8-23.1L570.6 8c3.5-9.8 1-20.6-6.3-28s-18.2-9.8-28-6.3L39.4 151.7c-13.9 5-23.1 18.1-23.1 32.8 0 14.2 8.6 27 21.7 32.3z"/></svg>
                                                </div>
                                                <h6 style="margin-bottom: 0px;margin-top:5px;">{{ $company_email }}</h6>
                                            </div>
                                           <div class="linement">
                                                <div class="box">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Pro v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2025 Fonticons, Inc.--><path fill="#D2B76A" d="M351.9 280l-190.9 0c2.9 64.5 17.2 123.9 37.5 167.4 11.4 24.5 23.7 41.8 35.1 52.4 11.2 10.5 18.9 12.2 22.9 12.2s11.7-1.7 22.9-12.2c11.4-10.6 23.7-28 35.1-52.4 20.3-43.5 34.6-102.9 37.5-167.4zM160.9 232l190.9 0C349 167.5 334.7 108.1 314.4 64.6 303 40.2 290.7 22.8 279.3 12.2 268.1 1.7 260.4 0 256.4 0s-11.7 1.7-22.9 12.2c-11.4 10.6-23.7 28-35.1 52.4-20.3 43.5-34.6 102.9-37.5 167.4zm-48 0C116.4 146.4 138.5 66.9 170.8 14.7 78.7 47.3 10.9 131.2 1.5 232l111.4 0zM1.5 280c9.4 100.8 77.2 184.7 169.3 217.3-32.3-52.2-54.4-131.7-57.9-217.3L1.5 280zm398.4 0c-3.5 85.6-25.6 165.1-57.9 217.3 92.1-32.7 159.9-116.5 169.3-217.3l-111.4 0zm111.4-48C501.9 131.2 434.1 47.3 342 14.7 374.3 66.9 396.4 146.4 399.9 232l111.4 0z"/></svg>
                                                </div>
                                                <a href="{{ $site->site_link }}" style="margin-bottom: 0px;margin-top:5px; text-decoration: none;">www.thewebzter.com </a>
                                           </div>
                                           <div class="linement">
                                                <div class="box">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#D2B76A" d="M0 188.6C0 84.4 86 0 192 0S384 84.4 384 188.6c0 119.3-120.2 262.3-170.4 316.8-11.8 12.8-31.5 12.8-43.3 0-50.2-54.5-170.4-197.5-170.4-316.8zM192 256a64 64 0 1 0 0-128 64 64 0 1 0 0 128z"/></svg>
                                                </div>
                                               <h6 style="margin-bottom: 0px;margin-top:5px;" >{!! $company_address !!}</h6>
                                           </div>
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
                                        <td style="width: 40%;vertical-align: top;">
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
                                                        <!-- <td>
                                                            <p>Email</p>
                                                        </td>
                                                        <td>
                                                            <span> # </span>
                                                        </td>
                                                        <td>
                                                            <p>{{ $customer_email }}</p>
                                                        </td> -->
                                                    </tr>
                                                </tbody>
                                              </table>
                                            </div>  
                                          </td>
                                          <td style="width: 30%;vertical-align: bottom;">
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
                                                            <td >
                                                                <p>{{ $company_name }} <br> {!! $company_address !!}</p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                  </table>
                                              </div>
                                          </td>
                                          <td style="width: 30%;vertical-align: bottom;">
                                              <div class="invies-content">
                                                  <h2>INVOICE</h2>
                                                  <h6>Invoice No: #{{ $invoice_number }}</h6>
                                                  <!-- <h6>Invoice Date: {{ $invoice_date }}</h6> -->
                                                   <h6>Invoice Date: {{ \Carbon\Carbon::parse($invoice_date)->format('d/m/Y') }}</h6>
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
                                    <th style="text-align:left;padding-left:10px;">PRODUCT</th>
                                    <th>TYPE</th>
                                    <th>BILLING TYPE</th>
                                    <th>QTY</th>
                                    <th>TOTAL</th>
                                </tr>

                                @foreach ($products as $product)
                                <tr>
                                    <td style="text-align:left;padding-left:10px;">
                                        <h6 style="text-align:left;">{{ $product->name }}</h6>
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
                    
                </table>
            </td>
        </tr>
    </table>
    <div class="footer-fixed" style="
                        width: 100%; 
                        background: url('{{ $invoice_footer_image }}') no-repeat; 
                        background-size: cover;
                        padding: 50px 0px;"></div>
</body>
</html>
