<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>{{ $site->site_name }} - Invoice #{{ $invoice_number }}</title>
</head>
<body style="margin: 0; padding: 40px 40px;background: #fff; font-family: Arial, sans-serif;">


    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"
        style="background: #fff; margin: 0 auto; border-collapse: collapse; box-shadow: 0 3px 10px rgba(0,0,0,0.1); max-width: 100%;">
        <tr>
            <td align="center" style="padding: 15px 0;">
                <img src="{{ $invoice_header_image ?? '' }}" alt="Invoice Header" style="height: 87px; display: block;" />
            </td>
        </tr>

        <tr>
            <td style="padding: 20px 40px; text-align: center;">
                <h1 style="font-size: 26px; font-weight: 700; color: #3C3C3C; margin: 0;">
                    Transaction Confirmation
                </h1>
            </td>
        </tr>

        <tr>
            <td style="padding: 0 40px 25px; text-align: center; color: #656565; font-size: 16px; line-height: 1.5;">
                Dear {{ !empty($customer_name) ? $customer_name : 'Customer' }},<br /><br />
                We appreciate your order.<br />
                Here's a summary of your recent purchase.
            </td>
        </tr>

        <tr>
            <td style="padding: 10px 40px 30px;">
                <p style="font-weight: 700; font-size: 16px; color: #0E0E0E; margin: 0 0 12px; text-align: center;">
                    Billing Details:
                </p>
                <table role="presentation" width="100%" cellpadding="8" cellspacing="0"
                    style="border-collapse: collapse; font-size: 14px; color: #656565;">
                    <tr>
                        <td style="border: 1px solid #ddd; text-align: center; width: 50%;">{{ !empty($customer_name) ? $customer_name : '-' }}</td>
                        <td style="border: 1px solid #ddd; text-align: center; width: 50%;">{{ !empty($customer_email) ? $customer_email : '-' }}</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ddd; text-align: center;">{{ !empty($invoice_date) ? $invoice_date : '-' }}</td>
                        <td style="border: 1px solid #ddd; text-align: center;">{{ !empty($invoice_number) ? $invoice_number : '-' }}</td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td style="padding: 0 40px 40px;">
                <table role="presentation" width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse; font-size: 14px;">
                    <thead>
                        <tr style="background-color: #f9f9f9; color: #3C3C3C;">
                            <th style="border: 1px solid #ddd; text-align: left; width: 40%;">Product</th>
                            <th style="border: 1px solid #ddd; text-align: center; width: 20%;">Subscription</th>
                            <th style="border: 1px solid #ddd; text-align: center; width: 10%;">Qty</th>
                            <th style="border: 1px solid #ddd; text-align: center; width: 30%;">Unit Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td style="border: 1px solid #ddd; padding: 8px;">{{ $product->name ?? '-' }}</td>
                            <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $product->subscription ?? '-' }}</td>
                            <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $product->quantity ?? 1 }}</td>
                            <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">
                                {{ site_currency() }}{{ number_format($product->unit_price ?? 0, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="border: none; padding: 12px 8px; text-align: right; font-weight: 700;">Sub Total</td>
                            <td style="border: 1px solid #ddd; padding: 8px; text-align: right; color: #EE5921; font-weight: 700;">
                                {{ site_currency() }}{{ number_format(($invoice_amount + $discount_amount) ?? 0, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="border: none; padding: 12px 8px; text-align: right; font-weight: 700;">Discount</td>
                            <td style="border: 1px solid #ddd; padding: 8px; text-align: right; color: #EE5921; font-weight: 700;">
                                {{ site_currency() }}{{ number_format($discount_amount ?? 0, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="border: none; padding: 12px 8px; text-align: right; font-weight: 700;">Total</td>
                            <td style="border: 1px solid #ddd; padding: 8px; text-align: right; color: #EE5921; font-weight: 700;">
                                {{ site_currency() }}{{ number_format($invoice_amount ?? 0, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>

        <tr>
            <td style="padding: 0;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                    style="background: url('{{ $invoice_footer_image ?? '' }}') no-repeat center center; background-size: cover; height: 170px; color: #3C3C3C;">
                    <tr>
                        <td style="width: 50%; text-align: center; vertical-align: middle; padding: 20px;">
                            <img src="{{ $company_logo ?? '' }}" alt="Company Logo" style="max-height: 100px; display: inline-block;" />
                        </td>
                        <td style="width: 50%; text-align: right; vertical-align: middle; padding: 20px; font-size: 14px; line-height: 1.4;">
                            {!! $company_address ?? '' !!}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>
