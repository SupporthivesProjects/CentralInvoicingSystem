<!DOCTYPE html>
<html>

<head>
    <title>{{ $site_name . $invoice_number }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            font-family: Arial, sans-serif;

            /* bottom border image */
            /* background: url('{{ $invoice_image5 }}') repeat-y left top / 200px 100%, #ffffff;

            background-size: 100% 6px; */
            /* min-height: 1000px; */
        }
    </style>
</head>

<body>
    <table style="width:100%; margin: 0 auto; border-collapse: collapse;min-height: 1122px;">
        <tr>
            <!-- Left Side -->
            <td
                style="width: 200px; vertical-align: top; background-color: #ffffff; background-image: url('{{ $invoice_image5 }}'); background-repeat: repeat-y; background-size: cover; padding: 20px; min-height: 1122px;">
                <h2 style="margin-bottom: 0; font-size: 24px; color: #333;">INVOICE</h2>
                <p style="font-style: italic; font-size: 14px; color: #666; margin-top: 5px;">
                    Invoice No : <span style="color: #a94442;">{{ $invoice_number }}</span>
                </p>

                <h4
                    style="margin-top: 30px; font-size: 16px; color: #333; border-bottom: 1px solid #d9b3b3; padding-bottom: 5px;">
                    Invoice To</h4>
                <p style="font-weight: bold; color: #333; margin-top: -10px;">{{ $customer_name }}</p>

                <h4
                    style="margin-top: 200px; font-size: 16px; color: #333; border-bottom: 1px solid #d9b3b3; padding-bottom: 5px;">
                    Invoice To</h4>
                <p style="font-weight: bold; color: #333; margin-top: -10px;">{{ $site_name }}</p>
                <p style="font-size: 14px; color: #333;">
                    {!! $company_address !!}<br><br>
                    {{ $company_email }}<br><br>
                    {{ $company_mobile }}
                </p>
            </td>

            <!-- Right Side -->
            <td style="width: 100%; vertical-align: top; padding: 30px; background-color: #ffffff;">
                <div style="text-align: right;">
                    <img src="{{ $invoice_image7 }}" alt="Company Logo" style="height: 50px; margin-bottom: 10px;">
                </div>

                <table style="width: 100%; margin-top: 30px;">
                    <tr style="text-align: center; font-size: 10px; color: #999;">
                        <td style=" border-right: 1px solid grey; text-align: left;">Issue Date<br><br>
                            <span style="color: #e87c7c;">{{ $invoice_date }}</span>
                        </td>
                        <td style=" border-right: 1px solid grey; text-align: center;">Invoice Date<br><br>
                            <span style="color: #e87c7c;">{{ $invoice_date }}</span>
                        </td>
                        <td style="text-align: right;">Total Due<br><br>
                            <span style="color: #e87c7c; font-weight: bold; font-size: 12px;">
                                {{ site_currency() . number_format($invoice_amount, 2) }}
                            </span>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
                    <thead
                        style="font-size: 12px; color: #e87c7c; text-align: left; border-bottom: 1px solid grey; border-top: 1px solid grey;">
                        <tr>
                            <th style="padding: 8px;">ITEM DESCRIPTION</th>
                            <!-- <th style="padding: 8px;">UNIT PRICE</th> -->
                            <th style="padding: 8px;">QTY</th>
                            <th style="padding: 8px;text-align: right;">AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px; color: #333;">
                        @foreach($products as $product)
                        <tr>
                            <td style="padding: 8px 8px 20px;">
                                <strong>{{ $product->name }}</strong><br>
                                <!-- <span style="color: #666; font-size: 12px;">
                                    {{ Str::limit(strip_tags($product->description), 100) }}
                                </span> -->
                            </td>
                            <!-- <td style="padding: 8px 8px 20px;">
                                {{ site_currency() . number_format($product->unit_price, 2) }}
                            </td> -->
                            <td style="padding: 8px 8px 20px;">1</td>
                            <td style="padding: 8px 8px 20px;text-align: right;">
                                {{ site_currency() . number_format($product->unit_price, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <table style="width: 100%; margin-top: 20px; font-size: 13px; border-collapse: collapse;">
                    <tr>
                        <td colspan="4" style="text-align: right; padding: 12px;"></td>
                        <td style="padding: 12px; width: 195px;"></td>
                        <td colspan="2" style="text-align: right; padding: 0px;">Sub Total</td>
                        <td style="padding: 12px; width: 60px;text-align: right;">
                            {{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td colspan="2" style="text-align: right; padding: 0px; border-bottom: 1px solid #444;">
                            Discount
                        </td>
                        <td style="padding: 12px; width: 60px; border-bottom: 1px solid #444;text-align: right;">
                            {{ site_currency() . number_format($discount_amount, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td colspan="2" style="text-align: right; font-weight: bold; color: #e87c7c; padding: 0px;">
                            Grand Total
                        </td>
                        <td style="font-weight: bold; color: #e87c7c; padding: 12px; width: 60px;text-align: right;">
                            {{ site_currency() . number_format($invoice_amount, 2) }}
                        </td>
                    </tr>
                </table>

                <!-- Contact Section -->
                <h4 style="margin-top: 30px; font-size: 14px; color: #e87c7c; text-align: right;">CONTACT</h4>

                <table style="width: 43%; font-size: 12px; display: flex; margin-left: auto; border-collapse: collapse;">
                    <tr>
                        <td class="custom-line" style="padding-bottom: 10px; color: #333; display: flex; align-items: center; justify-content: flex-end; gap: 6px;">
                          
                            <span>{{ $company_mobile }}</span>
                                <img style="width: 18px;" src="{{ $invoice_image6 }}" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-line" style="padding-bottom: 10px; color: #333; display: flex; align-items: center; justify-content: flex-end; gap: 6px;">
                            
                            <span>{{ $company_email }}</span>
                                <img style="width: 18px;" src="{{ $invoice_image3 }}" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-line" style="padding-bottom: 10px; color: #333; display: flex; align-items: center; justify-content: flex-end; gap: 6px;">
                             <span>{!! $company_address !!}</span>
                                <img style="width: 18px;" src="{{ $invoice_image4 }}" alt="">
                            
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
