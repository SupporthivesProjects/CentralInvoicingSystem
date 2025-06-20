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
        thead {
            background-color: #4CAF50;
            color: white;
        }
        .table-data{
            border-collapse: collapse;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        .table-data th{
            font-family: arial;
            font-size: 16px;
            margin: 0px;
            font-weight: 900;
            color: #000;
        }
        .table-data td{
            font-family: arial;
            font-size: 14px;
            margin: 0px;
            font-weight: 400;
            color: #000;
        }
        .table-data th,  .table-data td{
            padding: 10px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }
        .table-data th:first-child {
          text-align: left;
        }

        .table-data td:last-child, .table-data th:last-child {
            text-align: end;
        }

        .table-data tr:last-child td:last-child {
            background-color: #4CAF50;
            border-bottom: 0px solid;
        }
        .table-data tr:last-child td:nth-last-child(2) {
            background-color: #4CAF50;
            border-bottom: 0px solid;
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
        <tr>
            <td style="background: url('{{ $invoice_image1 }}') no-repeat; background-size: cover; height: 100%;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0"  style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td style="background: url('{{ $invoice_header_image }}')no-repeat; background-size:  cover; height: 136px; background-position:  center center;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px 60px;">
                            <table  width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="width: 100%;">
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400; margin-bottom:5px;"><b style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 700;">Date:</b> {{ $invoice_date }}</p>
                                        <p style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 400;">
                                            <b style="font-family: arial;font-size: 10px;margin: 0px;font-weight: 700;">Invoice Number</b>: #{{ $invoice_number}}
                                        </p>
                                    </td>
                                    <td>
                                        <h2 style="font-family: arial;font-size: 28px;margin: 0px;font-weight: 700;">INVOICE</h2>
                                    </td>
                                </tr>
                                
                                <tr> 
                                    <td style="padding-top: 30px;">
                                        <p style="font-family: arial;font-size:14px;margin: 0px;font-weight: 400; margin-bottom: 5px;">Billed From:</p>
                                        <p style="font-family: arial;font-size:14px;margin: 0px;font-weight: 400;">{{ $site->site_name }}</p>
                                    </td>
                                    <td style="text-align: end; padding-top: 30px;">
                                        <p style="font-family: arial;font-size:14px;margin: 0px;font-weight: 400; margin-bottom: 5px;">Billed To:</p>
                                        <p style="font-family: arial;font-size:14px;margin: 0px;font-weight: 400;"> {{ $customer_name }} </p>									         
                                    </td>
                                </tr>
                                    <tr>
                                        <table  width="100%" cellspacing="0" cellpadding="0" style="border-spacing: 50px 40px;">
                                         <tbody>
                                            <tr>
                                                <td> 
                                                   <div style="background: url('{{ $invoice_image2 }}') no-repeat; background-position: center center; background-size: cover;width: 254px; height: 218px; max-width: 100%; display: flex;flex-direction: column;justify-content: end;padding-bottom: 24px; margin: auto;text-align: center;">
                                                        <p style="font-family: arial;font-size: 14px;margin: 3px;font-weight: 400;color: green;">Address</p>
                                                        <p style="font-family: arial;font-size: 16px; margin: 0px; font-weight: 400; margin-bottom: 0px;color: #fff; margin-top: 5px;">
                                                         {!! $company_address !!}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="background: url('{{ $invoice_image3 }}') no-repeat; background-position: center center; background-size: cover;width: 254px; height: 218px; max-width: 100%; display: flex;flex-direction: column;justify-content: end;padding-bottom: 24px;  margin: auto;text-align: center;">
                                                        <p style="font-family: arial;font-size: 14px;margin: 3px;font-weight: 400;color: green;">Email</p>
                                                        <p style="font-family: arial;font-size: 16px; margin: 0px; font-weight: 400; margin-bottom: 0px;color: #fff; margin-top: 5px;">
                                                            {{ $company_email }}
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                         </tbody>  
                                        </table>
                                        <table class="table-data"  width="100%" cellspacing="0" cellpadding="0">
                                           
                                            <thead>
                                                <tr>
                                                    <th>Category</th>
                                                    <th>Product Name</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                             @foreach($products as $index => $product)
                                                <tr>
                                                    <td>{{ $product->category_name }}</td>
                                                    <td>{{ $product->name }}</td>
                                                    <td>1</td>
                                                    <td> {{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                                    <td> {{ site_currency() . number_format($product->unit_price, 2) }}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="2" style="border-bottom: 0px;"></td>
                                                    <td colspan="2">Subtotal</td>
                                                    <td> {{ site_currency() . number_format(($invoice_amount + $discount_amount), 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="border-bottom: 0px;"></td>
                                                    <td colspan="2" style="border-bottom: 0px solid;">Discount</td>
                                                    <td style="border-bottom: 0px solid;"> {{ site_currency() . number_format($discount_amount, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="border-bottom: 0px;"></td>
                                                    <td colspan="2">Grand Total</td>
                                                    <td>{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
