<!DOCTYPE html>
<html>
<head>
    <title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
    <style>
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }
        .table-td-p p{
            font-family: arial;
            font-size: 9px;
            margin: 0px;
            font-weight: 400;
            color: red;
        }
        table, th, td {
        border-collapse: collapse;
        }
        .table-td-p h6{
            font-family: arial;
            font-size: 9px;
            margin: 0px;
            font-weight: 400;
            color: #fff;
            margin-bottom: 9px;
        }
        .table-td-p{
            padding: 46px 69px;
            background: #0B132A;
            height: 700px;
            display: flex;
            width: 273px;
            flex-direction: column;
        }
       .table-product  th, .table-product td {
        padding: 12px;
        text-align: left;
        }

        .table-product th {
            border-bottom: 2px solid #000;
            border-top: 1px solid #000;
            font-weight: bold;
        }
        .table-product td {
            border-bottom: 1px solid #000;
            
        }
        .table-product td h6{
            font-size: 10px;
            font-weight: 900;
            font-family: Arial;
            color: #000;
        }
        .table-product table{
            width: 100% ;
        }
        .table-product{
            padding: 30px 30px;
            width: 100% ;
            vertical-align:top
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
        <tr>
            <td style="background: url() no-repeat; background-size: cover; height: 100%;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0"  style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                   <tbody>
                    <tr>
                        <td style="background: url('{{ $invoice_header_image }}') no-repeat; background-size: cover; text-align: center; text-align: center; display: flex; justify-content: center;align-items: center;height: 300px;">
                            <img src="{{ $company_logo }}" alt="" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0" class="table-list">
                                <tbody>
                                    <tr>
                                        <td class="table-td-p">
                                            <p>Invoice Number</p>
                                            <h6> #{{ $invoice_number }}</h6>
                                            <p>Date</p>
                                            <h6>{{ $invoice_date }}</h6>
                                            <p>Bill to</p>
                                            <h6> {{ $customer_name }}</h6>
                                            <p>Email</p>
                                            <h6>{{ $company_email }}</h6>
                                            <p>Address</p>
                                            <h6>{{ $site->site_name }}</h6>
                                            <p>
                                              {!! $company_address !!}
                                            </p>
                                        </td>
                                        <td class="table-product">
                                            <table width="100%" cellspacing="0" cellpadding="0">
                                                <thead>
                                                    <tr>
                                                        <th style="font-size: 9px; font-weight: 900;  font-family: Arial;">Description</th>
                                                        <th style="font-size: 9px; font-weight: 900;  font-family: Arial;">QTY</th>
                                                        <th style="font-size: 9px; font-weight: 900;  font-family: Arial;">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($products as $index => $product)
                                                    <tr>
                                                        <td><h6>{{ $product->name }}</h6></td>
                                                        <td> <h6>01</h6></td>
                                                        <td><h6>{{ site_currency() . number_format($product->unit_price, 2) }}</h6></td>
                                                    </tr>
                                                 @endforeach
                                                    <tr>
                                                        <td style="border: 0;"></td>
                                                        <td style="padding: 8px 8px;"><p style="font-size: 9px; font-weight: 400;  font-family: Arial;">SUB-TOTAL</p></td>
                                                        <td style="padding: 8px 8px;"><p style="font-size: 9px; font-weight: 400;  font-family: Arial;">{{ site_currency() . number_format(($invoice_amount + $discount_amount), 2) }}</p></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 0;"></td>
                                                        <td style="padding: 8px 8px;"><p style="font-size: 9px; font-weight: 400;  font-family: Arial;">DISCOUNT</p></td>
                                                        <td style="padding: 8px 8px;"><p style="font-size: 9px; font-weight: 400;  font-family: Arial;"> {{ site_currency() . number_format($discount_amount, 2) }}</p></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 0;"></td>
                                                        <td style="padding: 8px 8px; border: 0px;" > <h5 style="font-size: 10px; font-weight: 900;  font-family: Arial;" >TOTAL</h5></td>
                                                        <td style="padding: 8px 8px; border: 0px;"><h5 style="font-size: 10px; font-weight: 900;  font-family: Arial;">{{ site_currency() . number_format($invoice_amount, 2) }}</h5></td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
    </table>
</body>
</html>
