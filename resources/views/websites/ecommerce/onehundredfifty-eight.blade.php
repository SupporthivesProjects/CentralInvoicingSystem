<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Erose Enterprises Invoice</title>
</head>

<body style="margin:0; padding:0; background:#fff; font-family:Arial,sans-serif;">
    <table cellpadding="0" cellspacing="0" border="0"
        style="width:100%; margin:30px auto; background:#fff; border-radius:8px; box-shadow:0 2px 12px rgba(0,0,0,0.07); border-collapse:separate;">
        <tr>
            <!-- Left Sidebar -->
            <td
                style="width:260px; background:#f8f8f8; vertical-align:top; border-top-left-radius:8px; border-bottom-left-radius:8px; border-right:1px solid #eee; padding:0;">
                <table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
                    <tr>
                        <td
                            style="padding:32px 0 0 32px; font-size:26px; color:#222; font-weight:bold; letter-spacing:1px;">
                            INVOICE
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0 0 32px; font-size:12px; color:#888;">
                            Invoice No : <span style="color:#222;">{{ $invoice_number }}</span>
                        </td>
                    </tr>
                    <!-- Spacer -->
                    <tr>
                        <td style="height:32px;"></td>
                    </tr>
                    <!-- Invoice To -->
                    <tr>
                        <td
                            style="padding:0 0 0 32px; font-size:14px; color:#222; font-weight:bold; border-left:3px solid #e05e6b;">
                            Invoice To
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0 0 32px;">
                            <table cellpadding="0" cellspacing="0" border="0" style="font-size:13px; color:#222;">
                                <tr>
                                    <td style="font-weight:bold;">{{ $customer_name }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#888; padding-top:2px;">{{ $customer_mobile }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#888; padding-top:2px;">{{ $customer_email }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Spacer -->
                    <tr>
                        <td style="height:24px;"></td>
                    </tr>
                    <!-- Invoice From -->
                    <tr>
                        <td
                            style="padding:0 0 0 32px; font-size:14px; color:#222; font-weight:bold; border-left:3px solid #e05e6b;">
                            Invoice From
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0 0 32px;">
                            <table cellpadding="0" cellspacing="0" border="0" style="font-size:13px; color:#222;">
                                <tr>
                                    <td style="font-weight:bold;">{{ $site_name }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#888; padding-top:2px;">{{ $company_mobile }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#888; padding-top:2px;">{{ $company_email }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#e05e6b; padding-top:2px; text-decoration:underline;">{{ $company_address }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Spacer -->
                    <tr>
                        <td style="height:24px;"></td>
                    </tr>
                    <!-- Notes -->
                    <tr>
                        <td
                            style="padding:0 0 0 32px; font-size:14px; color:#222; font-weight:bold; border-left:3px solid #e05e6b;">
                            Notes:
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:8px 32px 0 32px; font-size:12px; color:#888;">
                            {{ $invoice_notes ?? 'Thank you for your business!' }}
                        </td>
                    </tr>
                    <!-- Decorative leaves (optional) -->
                    <tr>
                        <td style="padding:32px 0 0 0;">
                            <img src="./img/leaf.png" alt="" style="height:40px; margin-left:32px; opacity:0.7;">
                        </td>
                    </tr>
                </table>
            </td>
            <!-- Main Content -->
            <td
                style="width:540px; background:#fff; vertical-align:top; border-top-right-radius:8px; border-bottom-right-radius:8px; padding:0;">
                <table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
                    <!-- Logo and Amount -->
                    <tr>
                        <td style="padding:32px 0 0 32px;">
                            <img src="./img/erose_logo.png" alt="erose enterprises" style="height:48px;">
                        </td>
                        <td
                            style="padding:32px 32px 0 0; text-align:right; font-size:24px; color:#e05e6b; font-weight:bold;">
                            £1000.00
                        </td>
                    </tr>
                    <!-- Issue Date, Invoice Date, Total Due -->
                    <tr>
                        <td colspan="2" style="padding:24px 32px 0 32px;">
                            <table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
                                <tr>
                                    <td style="font-size:13px; color:#888; text-align:left; width:33%;">Issue
                                        Date<br><span style="color:#e05e6b; font-weight:bold;">01/01/2023</span></td>
                                    <td style="font-size:13px; color:#888; text-align:center; width:33%;">Invoice
                                        Date<br><span style="color:#e05e6b; font-weight:bold;">01/01/2023</span></td>
                                    <td style="font-size:13px; color:#888; text-align:right; width:34%;">Total
                                        Due<br><span style="color:#e05e6b; font-weight:bold;">£1000.00</span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Spacer -->
                    <tr>
                        <td colspan="2" style="height:24px;"></td>
                    </tr>
                    <!-- Table Headings -->
                    <tr>
                        <td colspan="2" style="padding:0 32px;">
                            <table cellpadding="0" cellspacing="0" border="0"
                                style="width:100%; border-bottom:2px solid #e05e6b;">
                                <tr>
                                    <td style="font-size:13px; color:#e05e6b; font-weight:bold; padding-bottom:8px;">
                                        ITEM DESCRIPTION</td>
                                    <td
                                        style="font-size:13px; color:#e05e6b; font-weight:bold; padding-bottom:8px; text-align:center;">
                                        UNIT PRICE</td>
                                    <td
                                        style="font-size:13px; color:#e05e6b; font-weight:bold; padding-bottom:8px; text-align:center;">
                                        QTY</td>
                                    <td
                                        style="font-size:13px; color:#e05e6b; font-weight:bold; padding-bottom:8px; text-align:right;">
                                        AMOUNT</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Invoice Items -->
                    <tr>
                        <td colspan="2" style="padding:0 32px;">
                            <table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
                                <!-- Item Row 1 -->
                                <tr>
                                    <td
                                        style="font-size:13px; color:#222; padding:12px 0 8px 0; border-bottom:1px solid #eee;">
                                        <span style="font-weight:bold;">Item name 1</span><br>
                                        <span style="font-size:12px; color:#888;">Lorem ipsum dolor sit amet,</span>
                                    </td>
                                    <td
                                        style="font-size:13px; color:#222; text-align:center; border-bottom:1px solid #eee;">
                                        £100.00</td>
                                    <td
                                        style="font-size:13px; color:#222; text-align:center; border-bottom:1px solid #eee;">
                                        3</td>
                                    <td
                                        style="font-size:13px; color:#222; text-align:right; border-bottom:1px solid #eee;">
                                        £100.00</td>
                                </tr>
                                <!-- Item Row 2 -->
                                <tr>
                                    <td
                                        style="font-size:13px; color:#222; padding:12px 0 8px 0; border-bottom:1px solid #eee;">
                                        <span style="font-weight:bold;">Item name 1</span><br>
                                        <span style="font-size:12px; color:#888;">Lorem ipsum dolor sit amet,</span>
                                    </td>
                                    <td
                                        style="font-size:13px; color:#222; text-align:center; border-bottom:1px solid #eee;">
                                        £100.00</td>
                                    <td
                                        style="font-size:13px; color:#222; text-align:center; border-bottom:1px solid #eee;">
                                        2</td>
                                    <td
                                        style="font-size:13px; color:#222; text-align:right; border-bottom:1px solid #eee;">
                                        £100.00</td>
                                </tr>
                                <!-- Item Row 3 -->
                                <tr>
                                    <td
                                        style="font-size:13px; color:#222; padding:12px 0 8px 0; border-bottom:1px solid #eee;">
                                        <span style="font-weight:bold;">Item name 1</span><br>
                                        <span style="font-size:12px; color:#888;">Lorem ipsum dolor sit amet,</span>
                                    </td>
                                    <td
                                        style="font-size:13px; color:#222; text-align:center; border-bottom:1px solid #eee;">
                                        £100.00</td>
                                    <td
                                        style="font-size:13px; color:#222; text-align:center; border-bottom:1px solid #eee;">
                                        1</td>
                                    <td
                                        style="font-size:13px; color:#222; text-align:right; border-bottom:1px solid #eee;">
                                        £100.00</td>
                                </tr>
                                <!-- Item Row 4 -->
                                <tr>
                                    <td
                                        style="font-size:13px; color:#222; padding:12px 0 8px 0; border-bottom:1px solid #eee;">
                                        <span style="font-weight:bold;">Item name 1</span><br>
                                        <span style="font-size:12px; color:#888;">Lorem ipsum dolor sit amet,</span>
                                    </td>
                                    <td
                                        style="font-size:13px; color:#222; text-align:center; border-bottom:1px solid #eee;">
                                        £100.00</td>
                                    <td
                                        style="font-size:13px; color:#222; text-align:center; border-bottom:1px solid #eee;">
                                        1</td>
                                    <td
                                        style="font-size:13px; color:#222; text-align:right; border-bottom:1px solid #eee;">
                                        £100.00</td>
                                </tr>
                                <!-- Item Row 5 -->
                                <tr>
                                    <td
                                        style="font-size:13px; color:#222; padding:12px 0 8px 0; border-bottom:1px solid #eee;">
                                        <span style="font-weight:bold;">Item name 1</span><br>
                                        <span style="font-size:12px; color:#888;">Lorem ipsum dolor sit amet,</span>
                                    </td>
                                    <td
                                        style="font-size:13px; color:#222; text-align:center; border-bottom:1px solid #eee;">
                                        £100.00</td>
                                    <td
                                        style="font-size:13px; color:#222; text-align:center; border-bottom:1px solid #eee;">
                                        1</td>
                                    <td
                                        style="font-size:13px; color:#222; text-align:right; border-bottom:1px solid #eee;">
                                        £100.00</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Totals -->
                    <tr>
                        <td colspan="2" style="padding:24px 32px 0 32px;">
                            <table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
                                <tr>
                                    <td style="width:60%;"></td>
                                    <td style="font-size:13px; color:#888; text-align:right; padding:2px 0;">Sub Total
                                    </td>
                                    <td style="font-size:13px; color:#888; text-align:right; padding:2px 0;">£100.00
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="font-size:13px; color:#888; text-align:right; padding:2px 0;">Discount
                                    </td>
                                    <td style="font-size:13px; color:#888; text-align:right; padding:2px 0;">£100.00
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="font-size:13px; color:#888; text-align:right; padding:2px 0;">Discount
                                    </td>
                                    <td style="font-size:13px; color:#888; text-align:right; padding:2px 0;">£100.00
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2" style="border-top:2px solid #e05e6b; height:1px;"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td
                                        style="font-size:15px; color:#e05e6b; font-weight:bold; text-align:right; padding:8px 0 0 0;">
                                        Grand Total</td>
                                    <td
                                        style="font-size:15px; color:#e05e6b; font-weight:bold; text-align:right; padding:8px 0 0 0;">
                                        £100.00</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Spacer -->
                    <tr>
                        <td colspan="2" style="height:32px;"></td>
                    </tr>
                    <!-- Contact Footer -->
                    <tr>
                        <td colspan="2" style="padding:0 32px 32px 32px;">
                            <table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
                                <tr>
                                    <td style="font-size:14px; color:#e05e6b; font-weight:bold; padding-right:24px;">
                                        CONTACT</td>
                                    <td style="font-size:13px; color:#222; padding-right:24px;">
                                        +44 123 456 789
                                    </td>
                                    <td style="font-size:13px; color:#222; padding-right:24px;">
                                        info@eroseenterprises.com
                                    </td>
                                    <td style="font-size:13px; color:#e05e6b; text-decoration:underline;">
                                        123 London road, kent, abc-123
                                    </td>
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
