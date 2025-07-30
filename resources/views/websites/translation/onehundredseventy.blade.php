<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<body style="margin:0px;padding:0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); min-height: 1120px;">
                    <tr>
                        <td style="padding: 40px;" valign="top">
                            <p style="font-family: arial;font-size: 14px;font-weight: 400; margin: 0px;color: #B33951;"><b>Invoice Details</b></p>
                            <br><br>
                            <p style="font-family: arial;font-size: 14px;font-weight: 400; margin: 0px;"><b>Invoice No {{ $invoice_number }}</b></p>
                            <p style="font-family: arial;font-size: 14px;font-weight: 400; margin: 0px;"><b>Invoice Date {{ $invoice_date }}</b></p>
                        </td>
                        <td align="right" style="padding: 40px;" valign="top">
                            <div style="height: 1px; background-color: black; width: 200px; margin-bottom: 2px;"></div>
                            <div style="height: 1px; background-color: black; width: 200px; margin-bottom: 30px;"></div>
                            <img src="{{ $company_logo }}" alt="" style="display: block; width: 200px;">
                            <div style="height: 1px; background-color: black; width: 200px; margin-top: 30px;"></div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="padding: 0px 40px;">
                            <p style="font-family: arial;font-size: 12px;font-weight: 400; margin: 0px;color: #414042;">Bill To</p>
                            <p style="font-family: arial;font-size: 12px;font-weight: 400; margin: 0px;color: #414042;">{{ $customer_name }}</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="width: 70%; padding: 40px; vertical-align: top;">
                            <table style="width: 100%; font-family: Arial, sans-serif; border-collapse: collapse; font-size: 10px;">
                                <tr style="border-bottom: 1px solid #333;border-top: 1px solid #333;">
                                    <th style="text-align: left; padding: 8px; font-weight: bold;">Translation Description</th>
                                    <th style="text-align: left; padding: 8px; font-weight: bold;">Pages / Words </th>
                                    <th style="text-align: right; padding: 8px; font-weight: bold;">Total</th>
                                </tr>
                                @foreach($products as $product)
                                <tr style="border-bottom: 1px solid #333;">
                                    <td style="padding: 8px; vertical-align: top;">
                                        {{ $product->name }}<br>
                                        {{ $product->is_urgent ? 'Yes (+' . site_currency() . number_format($product->urgent_amount, 2) . ')' : 'No' }}<br>
                                        from {{ $product->from_language }} to {{ $product->to_language }}.
                                    </td>
                                    <td style="padding: 8px; vertical-align: top;">{{ $product->pages }} {{ $product->unit_type }}</td>
                                    <td style="padding: 8px; text-align: right; vertical-align: top;">{{ site_currency() . number_format($product->line_total, 2) }}</td>
                                </tr>
                                @endforeach
                            </table>

                            <div style="border-top: 1px solid #333; margin: 40px 0; width: 100%; margin-bottom: 0px;"></div>
                            <div style="border-top: 1px solid #333; margin: 40px 0; width: 100%; margin-bottom: 0px;"></div>
                            <div style="border-top: 1px solid #333; margin: 40px 0; width: 100%; margin-bottom: 0px;"></div>
                            <div style="border-top: 1px solid #333; margin: 40px 0; width: 100%; margin-bottom: 0px;"></div>
                            <div style="border-top: 1px solid #333; margin: 40px 0; width: 100%; margin-bottom: 0px;"></div>
                            <div style="border-top: 1px solid #333; margin: 40px 0; width: 100%; margin-bottom: 0px;"></div>
                            <div style="border-top: 1px solid #333; margin: 40px 0; width: 100%; margin-bottom: 0px;"></div>
                            <div style="border-top: 1px solid #333; margin: 40px 0; width: 100%; margin-bottom: 0px;"></div>
                            <div style="border-top: 1px solid #333; margin: 40px 0; width: 100%; margin-bottom: 0px;"></div>

                            <table style="width: 100%; font-family: Arial, sans-serif; font-size: 10px; border-collapse: collapse;">
                                <tr>
                                    <td style="width: 40%;"></td>
                                    <td style="text-align: left; padding: 4px; font-weight: bold;">Sub Total</td>
                                    <td style="text-align: right; padding: 4px;">{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;"></td>
                                    <td style="text-align: left; padding: 4px; font-weight: bold;">Discount</td>
                                    <td style="text-align: right; padding: 4px;">{{ site_currency() . number_format($discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;"></td>
                                    <td style="text-align: left; padding: 4px;padding-top: 30px; font-weight: bold; font-size: 10px;border-top: 1px solid #333; border-bottom: 1px solid #333;">Grand&nbsp;Total</td>
                                    <td style="text-align: right; padding: 4px;padding-top: 30px; font-weight: bold; color: #B33951; font-size: 16px; border-top: 1px solid #333;border-bottom: 1px solid #333;">{{ site_currency() . number_format($invoice_amount, 2) }}</td>
                                </tr>
                            </table>
                        </td>

                        <td style="width: 30%; padding: 40px; padding-left: 0px; vertical-align: bottom;">
                            <div style="height: 1px; background-color: black; width: 100%; margin-bottom: 20px;"></div>
                            <p style="font-family: arial;font-size: 14px;font-weight: 400; margin: 0px;"><b>Company Details</b></p>
                            <p style="font-family: arial;font-size: 12px;font-weight: 400; margin: 0px;color: #414042;">{{ $company_name }}</p>
                            <br><br>
                            <p style="font-family: arial;font-size: 12px;font-weight: 400; margin: 0px;color: #414042;">{{ $site_name }}</p>
                            <p style="font-family: arial;font-size: 12px;font-weight: 400; margin: 0px;color: #414042;">{{ $company_email }}</p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="padding: 40px 40px 60px 40px;">
                            <p style="font-family: arial;font-size: 32px;font-weight: 400; margin: 0px;color: #B33951; text-align: left;"><b>Thank You</b></p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
