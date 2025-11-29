<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }} </title>
    <style>
        table.striped-table tr:nth-child(1) {
            background-color: #24292e; /* First row - red */
        }

        table.striped-table tr:nth-child(n+2):nth-child(even) {
            background-color: #FFFFFF; /* Even rows starting from 2nd */
        }

        table.striped-table tr:nth-child(n+2):nth-child(odd) {
            background-color: #d9d9d9; /* Odd rows starting from 2nd */
        }
    </style>
</head>
<body style="padding: 0px; margin: 0px; background-color: #161A1C;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0px;">
                            <img src="{{ $invoice_header_image }}" alt="" style="display: block;max-width: 100%;">
                        </td>
                    </tr>
                    <!-- Header End -->


                    <!-- Content -->
                    <tr>
                        <td style="padding:0px 40px 100px 40px; background-color: #161a1c;">
                            <table style="width:100%;">
                                <tr>
                                    <td>
                                        <br>
                                        <br>
                                        <div style="display: flex; justify-content: space-between; width: 100%;">
                                            <div style="display: flex; flex-direction: column; gap: 6px;">
                                                <p style="font-family: Helvetica;color: #FFFFFF; font-size: 12px;margin: 0px;font-weight: 400;">
                                                Invoice to</p>
                                                <p style="font-family: Helvetica;color: #FFFFFF; font-size: 20px;margin: 0px;font-weight: 700;"> {{ $customer_name ? $customer_name : '' }}<br>
                                                    {{ $customer_email ? $customer_email : '' }}<br>
                                                    {{ $customer_mobile ? $customer_mobile : '' }}</p>
                                            </div>
                                            <p style="font-family: Helvetica;color: #FFFFFF; font-size: 12px;margin: 0px; text-align: end; font-weight: 400; line-height: 12px;">
                                                {{ $company_name }}<br>
                                                {!! $company_address !!}<br><br>
                                                {{ $company_email }}<br><br>
                                                {{ $company_mobile }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <table style="width: 100%;">
                                <tr>
                                    <td style="display: flex; justify-content: space-between;">
                                        <p style="font-family:  Helvetica;color: #FFFFFF; font-size: 12px;margin: 0px; font-weight: 400; min-width: 140px; padding-top: 16px; border-top: 2px solid #d3f64a;">
                                            Invoice  #&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp; {{ $invoice_number }}
                                        </p>
                                        <p style="font-family:  Helvetica;color: #FFFFFF; font-size: 17px;margin: 0px;font-weight: 400; min-width: 160px; text-align: end;">
                                            Total Due
                                        </p>
                                    </td>
                                    <td style="display: flex; justify-content: space-between; padding-top: 6px;">
                                        <p style="font-family:  Helvetica;color: #FFFFFF; font-size: 12px;margin: 0px;font-weight: 400;">
                                            Invoice Date &nbsp;&nbsp;&nbsp;:&nbsp; {{ $invoice_date }}
                                        </p>
                                        <p style="font-family:  Kanit;color: #d3f64a; font-size: 22px;margin: 0px;font-weight: 400; min-width: 160px; text-align: end;">
                                            <b>{{ site_currency() ." ". number_format($invoice_amount, 2) }}</b>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <div style="min-height: 657px;">
                                <table style="border-collapse: collapse;" class="striped-table">
                                    <!-- <tr style="border-collapse: collapse;height: 24px; border-bottom: 12px solid #161a1c;"> -->
                                    <tr style="border-collapse: collapse;height: 24px; ">
                                        <td style="width: 80px; color: #FFFFFF; text-align: center; padding: 16px 10px;font-family:  kanit;font-size: 14px;margin: 0px;font-weight: 700;border-collapse: collapse;">
                                        <b>NO</b>
                                        </td>
                                        <td style="width: 300px; color: #FFFFFF; text-align: start; padding:16px 10px;font-family:  kanit;font-size: 14px;margin: 0px;font-weight: 700;border-collapse: collapse;">
                                            <b>DESCRIPTION</b>
                                        </td>
                                        <td style="width: 100px; color: #FFFFFF; text-align: center; padding: 16px 10px; font-family:  kanit;font-size: 14px;margin: 0px;font-weight: 700;border-collapse: collapse;">
                                            <b>QTY</b>
                                        </td>
                                        <td style="width: 120px; color: #FFFFFF; text-align: center; padding: 16px 10px; font-family:  kanit;font-size: 14px;margin: 0px;font-weight: 700;border-collapse: collapse;">
                                            <b>UNIT PRICE</b>
                                        </td>
                                        <td style="width:100px; color: #FFFFFF; text-align: center; padding: 16px 10px;font-family:  kanit;font-size: 14px;margin: 0px;font-weight: 700;border-collapse: collapse;">
                                            <b>TOTAL</b>
                                        </td>
                                    </tr>
                                    @foreach ($products as $product)
                                    <tr style="border-collapse: collapse;height: 24px;">
                                        <td style="width: 80px; color:#000000; text-align: center; padding: 16px 10px;font-family:  Helvetica;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>{{ $loop->iteration }}</b>
                                        </td>
                                        <td style="width: 300px; color:#000000; text-align:start;padding: 16px 10px;font-family:  Helvetica;font-size:12px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            <b>{{ $product->name }}</b><br><br>
                                            {{--!! \Illuminate\Support\Str::limit(strip_tags($product->description), 150) !!--}}
                                        </td>
                                        <td style="width:100px; color:#000000; text-align:center;padding: 16px 10px;font-family:  Helvetica;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            1
                                        </td>
                                        <td style="width:120px; color:#000000; text-align:center;padding: 16px 10px;font-family:  Helvetica;font-size: 10px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            {{ site_currency() ." ". number_format($product->unit_price ?? 0, 2) }}
                                        </td>
                                        <td style="width:100px; color:#000000; text-align:center;padding: 16px 10px;font-family:  Helvetica;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                            {{ site_currency() ." ". number_format($product->unit_price ?? 0, 2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    <!-- <tr style="border-top: 24px solid #161a1c;"> -->
                                    <tr>

                                        <td style="width: 100px;text-align: right;font-family: Helvetica;font-size: 13px;margin: 0px;font-weight: 400;padding-right: 10px; border: 0px;background-color: #161A1C;" colspan="3">
                                        </td>
                                        <td style="width: 100px;color: #FFFFFF;text-align: start;font-family: Helvetica;font-size: 13px;margin: 0px;font-weight: 400;padding: 0px 12px; background-color: #24292e;" colspan="1">
                                        <p>Sub Total</p>
                                        </td>
                                        <td style="width:100px;color: #FFFFFF;text-align:end;padding-right:10px;font-family: Helvetica;font-size: 13px;margin: 0px;font-weight: 400;border-collapse: collapse; background-color: #24292e;">
                                            <p>{{ site_currency() ." ". number_format($invoice_amount + $discount_amount ?? 0, 2) }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Helvetica;font-size: 11px;margin: 0px;font-weight: 400;padding-right: 10px; background-color: #161a1c;border: 0px;background-color: #161A1C;" colspan="3">
                                        </td>
                                        <td style="width: 100px;color: #FFFFFF;text-align: start;font-family: Helvetica;font-size: 13px;margin: 0px;font-weight: 400;padding: 0px 12px; background-color: #24292e;"  colspan="1">
                                        <p>
                                            Discount
                                        </p>
                                        </td>
                                        <td style="width:100px;color: #FFFFFF;text-align:end;padding:0px 12px; font-family: Helvetica;font-size: 13px;margin: 0px;font-weight: 400;border-collapse: collapse; background-color: #24292e;">
                                            <p>{{ site_currency() ." ". number_format($discount_amount ?? 0, 2) }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;text-align: right;font-family: Helvetica;font-size: 12px;margin: 0px;font-weight: 400;padding-right: 10px; background-color: #161a1c;border: 0px;background-color: #161A1C;" colspan="3">
                                        </td>
                                        <td style="width: 100px;color: #FFFFFF;text-align: start;font-family: Kanit;font-size: 18px;margin: 0px;font-weight: 700; padding: 0px 12px 14px 12px; background-color: #24292e;" colspan="1">
                                        <p>
                                            <b>Total</b>
                                        </p>
                                        </td>
                                        <td style="width:100px;color: #d3f64a;text-align:end;padding:0px 12px 14px 12px;font-family: Kanit;font-size: 16px;margin: 0px;font-weight: 700; border-collapse: collapse; background-color: #24292e;">
                                            <p>{{ site_currency() ." ". number_format($invoice_amount ?? 0, 2) }}</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <!-- Content End-->
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
