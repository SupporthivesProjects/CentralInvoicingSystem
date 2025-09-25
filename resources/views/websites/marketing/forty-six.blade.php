<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }
        .maintable{
            width: 800px;
            max-width: 100%;
            margin: auto;
        }
        .maintable td img{
            width:200px;
            max-width: 100%;
            margin: auto;
        }
        .table-td-p p{
            font-family: arial;
            font-size: 9px;
            margin: 0px;
            font-weight: 400;
            color: red;
        }
        td div{
            padding: 36px 27px;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);
            background: #fff;
            height: 140px;
            width: 150px;
        }
        td div p{
            font-family: 'Roboto';
            font-size: 9px;
            line-height: normal;
            font-weight: 400;
            margin: 7px 0px;

        }
        td div h5{
            font-family: 'Roboto';
            font-size: 10px;
            font-weight: 900;
            line-height: normal;
            color: #000;
        }
        table{
            width: 100%;
            border-collapse: collapse;
        }
        .table-invioce  h2{
            font-family: 'Roboto';
            font-size: 28px;
            line-height: normal;
            font-weight: 400;
        }

        .table-invioce td p{
            font-family: 'Roboto';
            font-size: 11px;
            line-height: normal;
            font-weight: 800;
        }
        table th{
            font-family: 'Roboto';
            font-size: 10px;
            line-height: normal;
            text-align: justify;
            font-weight: 800;
            padding: 10px 14px;
            border-bottom: 1px solid #000;
        }
        .table-invioce-list, .table-invioce{
            padding: 0px 40px;
        }
        .table-invioce-list td{
            padding: 10px 14px;
            border-bottom: 1px solid #000;
        }
        .table-invioce-list p{
            font-family: 'Roboto';
            font-size: 10px;
            line-height: normal;
            font-weight: 400;
            text-align: justify;
        }
        tfoot td p{
            font-family: 'Roboto';
            font-size: 10px;
            line-height: normal;
            font-weight: 500;
            text-align: center;
            color: #000;
        }
        tfoot h5{
            font-family: 'Roboto';
            font-size: 9px;
            line-height: normal;
            font-weight: 600;
            text-align: center;
            color: #000;
            margin-bottom: 10px;
        }
         .total-price span{
            font-family: 'Roboto';
            font-size: 10px;
            font-weight: 400;
            color: #837e7e;
        }
        .total-price p{
            font-family: 'Roboto';
            font-size: 14px;
            font-weight: 400;
            color: #837e7e;
        }
        .total-green{
            background: green;
            padding: 16px 24px;
            color: #fff;
        }
        .maintable{
            background: url('{{ $invoice_image1 }}') no-repeat;
            background-position: 100% 100%;
            background-size: contain;
        }
    </style>
</head>
<body>
    <table width="100%" class="maintable" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
        <tr>
            <td style="height:100vh;vertical-align:top;">
                <table  width="100%" cellspacing="0" cellpadding="0" border="0"  style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                
                    <tbody>
                        <tr>
                            <td>
                                <table  width="100%" cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td style="padding: 40px 40px;background: #80808021; width: 340px; text-align: center;">
                                                <img src="{{ $company_logo }}" alt="" class="img-fluid">
                                            </td>
                                            <td style="background: url('{{ $invoice_header_image }}') no-repeat; padding: 53px 63px;">
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 100%;padding: 0px 12px;">
                                                                <div>
                                                                    <h5>BILLED TO:</h5>
                                                                    <p>{{ $customer_name }}</p>
                                                                </div>
                                                            </td>
                                                            <td style="width: 100%; padding: 0px 12px;">
                                                                <div>
                                                                    <h5>BILLED FROM:</h5>
                                                                    <p>
                                                                      Green 3 creations
                                                                    </p>
                                                                    <p>{{ $site_name }}</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100%; padding: 24px 100px;">
                                <table class="table-invioce">
                                    <tbody>
                                        <tr>
                                            <td colspan="100%">
                                                <h2>INVOICE</h2>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%;">
                                                <p>INVOICE NUMBER: #{{ $invoice_number}}</p>
                                            </td>
                                            <td style="width: 50%; text-align: end;">
                                                <p>INVOICE DATE: {{ $invoice_date }}</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                      
                        <tr>
                            <td style="width: 100%; padding: 0px 100px 100px;height:400px;vertical-align:top;">
                                <table class="table-invioce-list">
                                    <thead>
                                        <tr>
                                            <th>PRODUCT & SERVICE</th>
                                            <th>QTY</th>
                                            <th>DURATION</th>
                                            <th>PRICE</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>
                                                <p> {{ $product->name }}</p>
                                            </td>
                                            <td>
                                                <p>1</p>
                                            </td>
                                            <td>
                                                <p>{{ $product->subscription ?? '-' }}</p>
                                            </td>
                                            <td>
                                                <p>
                                                {{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}
                                                </p>
                                            </td>
                                            <td>
                                                <p>
                                                {{ site_currency() }} {{ number_format($product->unit_price ?? 0, 2) }}
                                                </p>
                                            </td>
                                        </tr>
                                        @endforeach 

                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 0px 100px 60px;">
                                <table class="total-price">
                                    <tbody>
                                        <tr>
                                            <td style="background: #80808021;padding: 0px 0px 0px 20px;">
                                                <p>
                                                    <span>SUBTOTAL</span>
                                                    <br>
                                                    {{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}
                                                </p>
                                            </td>
                                            <td style="background: #80808021;padding: 0px 0px 0px 20px;">
                                                <p>
                                                    <span>DISCOUNT$ </span>
                                                    <br>
                                                    {{ site_currency() }} {{ number_format($discount_amount ?? 0, 2) }}
                                                </p>
                                            </td>
                                            <td class="total-green" style="text-align: right;">
                                                <p style="font-size: 20px; color:#fff;">
                                                    <span style="font-size: 10px; color:#fff;">    
                                                        GRAND TOTAL
                                                    </span>
                                                    <br>
                                                    {{ site_currency() }} {{ number_format($invoice_amount ?? 0, 2) }}
                                                </p>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                       </tr>
                    </tbody> 
               
                    <tfoot>
                       <tr>
                        <td style="padding: 0px 100px 100px;">
                            <table>
                                <tbody>
                                    <tr>
                                        <td style="border-bottom: 2px solid #008000ad;padding-bottom: 13px;">
                                            <p style="text-align: left;">{{ $site_name }} </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5 style="font-size: 9px; padding-top: 24px;">   
                                            {{ $site->company_name }} 
                                            </h5>
                                            <p style="font-size: 9px;">
                                            {!! $company_address !!} 
                                            </p>
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


