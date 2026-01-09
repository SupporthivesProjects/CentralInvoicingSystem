<!DOCTYPE html>
<html>
<head>
    <title>Your Email Title</title>
    <style>
            .for_bttom {
            position: fixed;
            bottom: -2px;
            left: 0;
            right: 0;
            width: 100%;
        }
        *, body{
            margin:0px;
            padding:0px;
            border: 0px;
            outline: 0px;
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; padding: 0px; margin: 0px;">
        <tr style="width: 100%;">
            <td bgcolor="#ffffff" style="width: 100%;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse;border-collapse: collapse; padding: 0px; margin: 0px;">
                    <!-- Header -->
                    <tr style="width: 100%;">
                        <td style="padding: 0px;max-height: 230px;width: 100%;">
                            <table style="width: 100%;" style="border-collapse: collapse; padding: 0px; margin: 0px;">
                                <tr style="width: 100%;">
                                    <!-- <td style="height: 230px; background: url({{ $invoice_header_image }}) no-repeat;background-position: top center;background-size:cover;width: 100%;">
                                        <b style="padding-left: 100px;color: white;font-size: 22px;font-family: 'Courier New', Courier, monospace;"> Invoice</b><br>
                                        <b style="padding-left: 102px;color: white;font-size: 9px;font-family: 'Courier New', Courier, monospace;">No.{{ $invoice_number }}</b>
                                    </td> -->
                                    <td>
                                        <div
                                            style="
                                                height: 230px;
                                                background: url({{ $invoice_header_image }});
                                                background-repeat: no-repeat;
                                                background-position: top center;
                                                background-size: cover;
                                                width: calc(100% + 5px);
                                                padding-left: 140px;
                                                display: flex;
                                                flex-direction: column;
                                                justify-content: center;
                                                position: relative;
                                                top: -4px;
                                                left: -2px;
                                            "
                                            >
                                            <b
                                                style="
                                                color: white;
                                                font-size: 22px;
                                                font-family: 'Courier New', Courier, monospace;
                                                "
                                            >
                                                Invoice
                                            </b>
                                            <strong
                                                style="
                                                color: white;
                                                font-size: 10px;
                                                font-family: 'Courier New', Courier, monospace;
                                                margin-top: 4px;
                                                font-weight: 700;
                                                "
                                            >
                                                No.{{ $invoice_number }}
                                            </strong>
                                            <b
                                                style="
                                                color: white;
                                                font-size: 9px;
                                                font-family: 'Courier New', Courier, monospace;
                                                margin-top: 4px;
                                                font-weight: bold;
                                                "
                                            >
                                                {{ $invoice_date }}
                                            </b>
                                            </div>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                     <!-- Content -->
                    <tr >
                        <td style="padding:60px;padding-top:0px;">
                            <table width="100%" style="border-collapse: collapse; table-layout: fixed;">

                                <tr>
                                    <td style="padding-top: 10px;width: 50%;vertical-align: top;">
                                        <p style="font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;  text-align: left; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                            <b>BILLED TO:</b>
                                        </p>
                                        <p style="font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;  text-align: left; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                           {{ $customer_name }}
                                        </p>
                                        <p style="font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;  text-align: left; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                           {{ $customer_mobile }}
                                        </p>
                                        <p style="font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;  text-align: left; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                           {{ $customer_email }}
                                        </p>
                                    </td> 
                                     <td style="padding-top: 10px;width: 50%;vertical-align: top;">
                                       <p style="font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;  text-align: left; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                            <b>BILLED FROM:</b>
                                        </p>
                                        <p style="font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;  text-align: left; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                            {{ $site_name }}
                                        </p>
                                        <p style="font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;  text-align: left; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;width: 250px;">
                                            <!-- {{ $company_address }} -->
                                            @php
                                                $parts = explode(',', $company_address);
                                            @endphp

                                            @foreach($parts as $index => $part)
                                                {{ trim($part) }}@if($index < count($parts) - 1),@endif
                                                @if($index === 1 || $index === 3)
                                                    <br><br>
                                                @endif
                                            @endforeach
                                        </p>
                                        <p style="font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;  text-align: left; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                            {{ $company_mobile }}
                                        </p>
                                     </td>
                                </tr>

                            </table>

                            <div style="min-height: 500px !important">
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px;">
                                <tr style="border-collapse: collapse;height: 30px; border-bottom: 0px;border: 0px; background-color: #00A8DC;">
                                    <td style="width: 600px;text-align: left;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 10px;">
                                       <b>Service</b>
                                    </td>
                                    <td style="width: 200px;text-align: center;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        <b>	Quantity</b>
                                    </td>
                                    <td style="width: 200px;text-align: right;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        <b>Price</b>
                                    </td>
                                    <td style="width: 200px;text-align:right;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px">
                                        <b>Cost</b>
                                    </td>

                                </tr>
                                @foreach($products as $product)
                                 <tr style="border-collapse: collapse;height: 30px; border-bottom: 0px;border: 0px; ">
                                    <td style="width: 600px;text-align: left;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 10px;">
                                       {{ $product->name }}
                                    </td>
                                    <td style="width: 200px;text-align: center;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;">
                                        1
                                    </td>
                                    <td style="width: 200px;text-align: right;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        {{ site_currency() . number_format($product->unit_price, 2) }}
                                    </td>
                                    <td style="width: 200px;text-align:right;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px">
                                        {{ site_currency() . number_format($product->unit_price, 2) }}
                                    </td>

                                </tr>
                                @endforeach
                                <tr style="border-collapse: collapse;height: 30px; border-bottom: 0px;border: 0px; ">
                                    <td style="width: 600px;text-align: left;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       <!-- <b>Our Payment Methods:</b> -->
                                    </td>
                                    <td style="width: 200px;text-align: center;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                    <td style="width: 200px;text-align: right;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        <b>Sub Total</b>
                                    </td>
                                    <td style="width: 200px;text-align:right;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px">
                                        <b>{{ site_currency() . number_format($invoice_amount + $discount_amount, 2) }}</b>
                                    </td>

                                </tr>
                                <tr style="border-collapse: collapse;height: 30px; border-bottom: 0px;border: 0px; ">
                                    <td style="width: 600px;text-align: left;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       <!-- Invoice # {{ $invoice_number }} -->
                                    </td>
                                    <td style="width: 200px;text-align: center;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                    <td style="width: 200px;text-align: right;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        <b>Discount</b>
                                    </td>
                                    <td style="width: 200px;text-align:right;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-right: 10px">
                                        <b>{{ site_currency() . number_format($discount_amount, 2) }}</b>
                                    </td>

                                </tr>
                                <tr style="border-collapse: collapse;height: 30px; border-bottom: 0px;border: 0px; ">
                                    <td style="width: 600px;text-align: left;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;padding-left: 5px;">
                                       <!-- PayPal, Wire Transfer, Payoneer -->
                                    </td>
                                    <td style="width: 200px;text-align: center;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;">

                                    </td>
                                    <td style="width: 200px;text-align: right;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;background-color: #F2F2F2;">
                                       <b>Total Due</b>
                                    </td>
                                    <td style="width: 200px;text-align:right;font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;border-collapse: collapse;background-color: #F2F2F2;padding-right: 10px">
                                        <b>{{ site_currency() . number_format($invoice_amount, 2) }}</b>
                                    </td>

                                </tr>
                                <br><br><br><br>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <!-- Content End-->

                    <!-----------Footer----------->
                    <tr>
                        <td style="height: 130px;" class="for_bttom">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px" style="border-collapse: collapse;">
                                <tr style="background: url({{ $invoice_footer_image }}) no-repeat;background-position: center;background-size: cover;height: 80px;padding:50px;background-size:cover;width: 100%;">
                                    <td style="width: 150px;">
                                        <p style="text-align: center;font-family: arial;font-size: 12px;margin: 0px;color: #00A8DC;">
                                            <b>Notes</b>
                                        </p><br>
                                        <p style="text-align: center;font-family: arial;font-size: 12px;margin: 0px;">
                                            {{ $invoice_notes ?? 'Thank you for your business!' }}

                                        </p>

                                    </td>

                                </tr>
                                <tr>
                            </table>
                        </td>
                    </tr>
                    <!-- <div style="height: 130px;" class="for_bttom">
                        <div style="background: url('{{ $invoice_footer_image }}') no-repeat center / cover; height: 80px; padding: 50px; width: 100%;">
                            <div style="width: 150px; margin: 0 auto; text-align: center;">
                            <p style="font-family: arial; font-size: 10px; margin: 0; color: #00A8DC; font-weight: bold;">
                                Notes
                            </p>
                            <br>
                            <p style="font-family: arial; font-size: 10px; margin: 0;">
                                {{ $invoice_notes ?? 'Thank you for your business!' }}
                            </p>
                            </div>
                        </div>
                    </div> -->

                    <!-----------Footer End----------->

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
