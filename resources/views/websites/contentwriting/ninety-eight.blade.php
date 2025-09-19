<!DOCTYPE html>
<html>
<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Prata&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
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
       
       
        .table-head h6{
            font-family: Arial;
            font-size: 10px; 
            font-weight: 600; 
            line-height: normal; 
            color: #000;
        }
        .table-head h5{
            font-family: Arial;
            font-size: 10px; 
            font-weight: 600; 
            line-height: normal; 
            color: #000;
        }
        .table-two h5 {
            font-family: Arial;
            font-size: 10px;
            font-weight: 600;
            line-height: normal;
            color: #000;
            margin-bottom: 6px;
        }
        .table-list, .table-list th, .table-list td {
            border:1px solid black;
            border-collapse: collapse;

        }
        .table-list td:first-child{
            border-left: 0px;
        }
        .table-list td:last-child{
            border-right: 0px;
        }
        .table-list th{
            font-family: Lato;
            font-size: 11px;
            line-height: normal;
            font-weight: 700;
            background: #445379;
            padding: 14px 0px;
        }
        .table-list th{
            width: 18%;
        }
        .table-list td{
            text-align: center;
        }
    
        .table-list h6{
            font-family: Arial;
            font-size: 9px;
            line-height: normal;
            font-weight: 700;
            margin-bottom: 7px;
        }
        
    </style>
</head>
<body>
    <table width="800" cellspacing="0" cellpadding="0" border="0" style="margin: auto; border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
        <tbody>
                <tr>
                    <td style="background-size: cover; height: 100%;">
                        <table width="800" cellspacing="0" cellpadding="0" border="0"  style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                            <tbody>
                            <tr>
                                <td>
                                    <tr>
                                        <td style="height: 250px; display: block;">
                                            <div style="background: #8EBCD4;">
                                                <h2 style="font-family: 'Lato'; font-size: 30px;line-height: normal;font-weight: 700;color: #000; border-bottom: 1px solid #000;padding: 16px 29px 12px;">INVOICE</h2>
                                                <div style="padding: 16px 29px 75px">
                                                    <p style="font-family: Arial;font-size: 10px; font-weight: 600; line-height: normal; color: #000; margin-bottom: 10px;">
                                                        Invoice To
                                                    </p>
                                                    <p style="font-family: Arial;font-size: 10px; font-weight: 600; line-height: normal; color: #000;">
                                                        {{ $customer_name }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 0px 50px;">
                                            <table class="table-head">
                                                <tr style="display: flex; justify-content:space-between; gap: 24px; padding-top:0px;">
                                                    <td style="width: 22%;padding-bottom: 24px;">
                                                        <h6 style="display: flex;justify-content: left; gap: 10px; align-items: center; font-size: 8px; line-height: normal; color: #000; font-weight: 400;">
                                                        <div style="background: #8EBCD4; padding: 6px; width: 24px; height: 24px;">
                                                            <img src="{{ $invoice_image1 }}" alt="" class="img-fluid" style="width: 14px; height: 14px;max-width: 100%;object-fit: cover;">
                                                        </div> Address</h6>
                                                        <p style="font-family: Arial;font-size: 10px; font-weight: 400; line-height: normal; color: #000;">
                                                           {!! $company_address !!}
                                                        </p>
                                                    </td>
                                                    <td style="padding-left: 20px; padding-bottom: 24px;border-left: 1px solid #000;">
                                                        <h6 style="display: flex;justify-content: left; gap: 10px; align-items: center; font-size: 8px; line-height: normal; color: #000; font-weight: 400;">
                                                            <div style="background: #8EBCD4; padding: 6px; width: 24px; height: 24px;">
                                                                <img src="{{ $invoice_image2 }}" alt="" class="img-fluid" style="width: 14px; height: 14px;max-width: 100%;object-fit: cover;"></div>
                                                            Phone</h6>
                                                        <p style="font-family: Arial;font-size: 10px; font-weight: 400; line-height: normal; color: #000;">
                                                            {{ $company_mobile }}
                                                        </p>
                                                    </td>
                                                    <td style="padding-left: 20px; padding-bottom: 24px;border-left: 1px solid #000;">
                                                        <h6 style="display: flex;justify-content: left; gap: 10px; align-items: center; font-size: 8px; line-height: normal; color: #000; font-weight: 400;">
                                                        <div style="background: #8EBCD4; padding: 6px; width: 24px; height: 24px;">
                                                            <img src="{{ $invoice_image3 }}" alt="" class="img-fluid" style="width: 14px; height: 14px;max-width: 100%;object-fit: cover;">
                                                        </div>
                                                            Email
                                                        </h6>
                                                        <p style="font-family: Arial;font-size: 10px; font-weight: 400; line-height: normal; color: #000;">
                                                           {{ $company_email }}
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h5 style="margin-bottom: 10px;border-top: 2px solid #8EBCD4; padding-top: 20px; margin-top: 15px;">
                                                            Invoice From:
                                                        </h5>
                                                        <h5>
                                                            {{ $site_name }}
                                                        </h5>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                </td>
                                <td style="width: 100%; padding: 0px 50px 15px;">
                                    <table class="table-two" style="width: 100%;">
                                        <tbody>
                                            <tr>
                                                <td style="width: 100%;">
                                                    <h5 style="">Invoice Date</h5>
                                                    <p style="font-family: Arial;font-size: 8.5px; font-weight: 400; line-height: normal; color: #000;margin-bottom: 4px;">{{ $invoice_date  }}</p>
                                                    <p style="font-family: Arial;font-size: 8.5px; font-weight: 400; line-height: normal; color: #000;margin-bottom: 10px;">Invoice No: # {{ $invoice_number }}</p>
                                                </td>
                                                <td style="width: 50%;">
                                                    <div style="display: flex; gap: 24px; width: 113px;">
                                                        <div style="background: #8EBCD4; padding: 6px; width: 29px; height: 28px;">
                                                            <img src="{{ $invoice_image4 }}" style="width: 14px; height: 14px;">
                                                        </div>
                                                        <div>
                                                            <h5>Due Amount</h5>
                                                            <h3 style="font-family: Arial; font-size: 15px; font-weight: 600;">{{  site_currency() }} {{ number_format($invoice_amount, 2) }}</h3>
                                                        </div>
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
                    <td>
                    <div style="min-height: 320px !important;">
                        <table class="table-list" style="width:100%;border-bottom: 0px; border-left: 0px; border-right: 0px;">
                            <tbody>
                                <tr>
                                    <th style="background: #8EBCD4; width: 46%;">Product Name & Service Description</th>
                                    <th style="color: #fff;">Word Count</th>
                                    <th style="color: #fff;">Qty</th>
                                    <th style="color: #fff;">Total</th>
                                </tr>
                                @foreach($products as $product)
                                <tr>
                                    <td style="padding: 14px 18px; text-align: left;">
                                    <h6>{{ $product->name }}</h6>
                                    <p style="font-family: Arial;font-size: 8px;line-height: normal;font-weight: 500;">
                                     {{ $product->turnaround }} / Quality:{{ $product->quality }},  {{ $product->delivery }} Image Qty: {{ $product->imagecount }}
                                    </p>
                                    </td>
                                    <td >
                                    <p style="font-family: Arial;font-size: 10px; line-height: normal;font-weight: 400;"> {{ $product->wordcount }}</p>
                                    </td>
                                    <td>
                                    <p style="font-family: Arial;font-size: 10px; line-height: normal;font-weight: 400;">1</p>
                                    </td>
                                    <td>
                                    <p style="font-family: Arial;font-size: 10px; line-height: normal;font-weight: 400;">
                                        {{  site_currency() }} {{ number_format($product->unit_price, 2) }}
                                    </p>
                                    </td>
                                </tr>
                                @endforeach
                            <tr>
                                <td  colspan="2" style="border:0px;padding: 14px 18px; text-align: left;">
                                    <p style="border-bottom-style: dashed;border-width: thin; margin-top:10px;"></p>
                                </td>
                                <td style="border: 0px;">
                                    
                                </td>
                                <td style="border: 0px;">
                                    
                                </td>
                                <td style="border: 0px;">
                                    
                                </td>
                            </tr>
                            <tr>
                                <td  colspan="2" style="border:0px;padding: 14px 18px; text-align: left;">
                                </td>
                                
                                <td style="border: 0px;">
                                    <p style="font-family: Arial;font-size: 10px; line-height: normal;font-weight: 400;">Sub Total</p>
                                </td>
                                <td style="border: 0px;">
                                    <p style="font-family: Arial;font-size: 10px; line-height: normal;font-weight: 400;"> {{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td  colspan="2" style="border:0px;padding: 14px 18px; text-align: left;">
                                    <p style="font-family: Arial;font-size: 10px; line-height: normal;font-weight: 600;"> Thank you for placing your order with us.</p>
                                </td>
                                <td style="border: 0px;">
                                    <p style="font-family: Arial;font-size: 10px; line-height: normal;font-weight: 400;">Discount</p>
                                </td>
                                <td style="border: 0px;">
                                    <p style="font-family: Arial;font-size: 10px; line-height: normal;font-weight: 400;" >{{ site_currency() }} {{ number_format($discount_amount, 2) }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td  colspan="2" style="border:0px;padding: 14px 18px; text-align: left;">
                                    <p style="font-family: Arial;font-size: 10px; line-height: normal;font-weight: 600;"></p>
                                </td>
                                <td style="border: 0px;background: #8EBCD4;padding: 16px 0px;">
                                    <p style="font-family: 'Lato';font-size: 13px; line-height: normal;font-weight: 600;">Grand Total</p>
                                </td>
                                <td style="border: 0px;background: #8EBCD4; padding: 16px 0px;">
                                    <p style="font-family: 'Lato';font-size: 13px; line-height: normal;font-weight: 600;" >{{  site_currency() }} {{ number_format($invoice_amount, 2) }}</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 50px;">
                        <tfoot>
                            <tr>
                                <td style="background: url('{{ $invoice_footer_image }}')no-repeat; display: none; height: 252px; width: 100%; background-size: contain;">
                                    
                                </td>
                            </tr>
                            </tfoot>
                    </td>
                </tr>
        </tbody>
    </table>
</body>
</html>
