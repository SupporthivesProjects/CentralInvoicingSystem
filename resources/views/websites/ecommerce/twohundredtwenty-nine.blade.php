<!DOCTYPE html>
<html>

<head>
    <title>Your Email Title</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<style>
*{
    margin:0px;
    padding:0px;
}
</style>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#fff" style="padding:0px;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; background: url({{ $invoice_image1 }}) no-repeat;background-position: top center;background-size:contain;">
                    <!-- Header -->
                    <tr>
                        <td style="height: 20px;"></td>
                    </tr>
                    <tr>
                        <td style="padding-top : 35px ">
                            <table width="100%" cellspacing="0" cellpadding="" border="0px">
                                <tr
                                    style="border-collapse: collapse; height: 100px; width: 600px; border-collapse: collapse; ">
                                    <td style="width: 300px;border:0px;">
                                        <img src="{{ $invoice_header_image }}" alt=""
                                            style="height: 60px; justify-content: left;padding-left: 40px;padding-top: 10px;">
                                    </td>

                                    <td
                                        style="width: 300px;border:0px;height: 50px;text-align: right;margin: 0px;padding-right: 40px;font-size: 8px;font-family: 'Space Mono', monospace;;">
                                        <h5
                                            style="margin-bottom: 5px;margin-top: 7px; color: darkgreen;font-size: 12px;">
                                            Invoice Number <img src="{{ $invoice_image2 }}" alt=""
                                                style="height: 5px;"> </h5>{{ $invoice_number }}
                                        <h5 style="margin-bottom: 0;margin-top: 5px; color: darkgreen;font-size: 12px;">
                                            Invoice Date <img src="{{ $invoice_image2 }}" alt=""
                                                style="height: 5px;"></h5>{{ $invoice_date }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Header End -->

                    <!-- Content -->
                    <tr>
                        <td style="padding:30px;padding-top:20px;">
                            <h1
                                style="text-align: center;color: darkgreen;font-size: 75px;margin:0px;font-family: 'Space Mono', monospace;">
                                INVOICE</h1>
                            <table style="border-collapse: collapse;border-bottom: 0px;border: 0px; width:100%">


                                <tr style="border-collapse: collapse;width:100%">
                                    <td style="padding-top: 10px;width: 50%;vertical-align: top;">
                                        <p
                                            style="font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; text-align: left;margin-bottom: 8px;padding-left: 5px;color: darkgreen;">
                                            <b>Invoice to</b>
                                        </p>
                                        <p
                                            style="font-family: arial;font-size: 20px;margin: 0px;font-weight: 400; text-align: left;margin-bottom: 8px;padding-left: 5px;">
                                            {{ $customer_name }}
                                        </p>
                                    </td>

                                    <td style="padding-top: 10px;width: 50%;vertical-align: top;">
                                        <p
                                            style="font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; text-align: left;margin-bottom: 8px;padding-right: 5px;color: darkgreen;">
                                            <b>Billed from:</b>
                                        </p>
                                        <p
                                            style="font-family: arial;font-size: 20px;margin: 0px;font-weight: 400;text-align: left; margin-bottom: 8px;padding-left: 5px;">
                                            {{ $company_name }}
                                        </p>
                                        <p
                                            style="font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; text-align: left;padding-bottom: 5px;padding-right: 5px;color: darkgreen;">
                                            <b> Address : </b>  <span style="color: black; width: 60px; margin-left: 10px">{{ $company_address }} </span>
                                        </p>
                                        <p
                                            style="font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; text-align: left;padding-bottom: 5px;padding-right: 5px;color: darkgreen;">
                                            <b> Website : </b>  <span style="color: black;margin-left: 10px">{{ $site_name }}</span>
                                        </p>
                                        <p
                                            style="font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; text-align: left;padding-bottom: 5px;padding-right: 5px;color: darkgreen;">
                                            <b> Email : </b>  <span style="color: black;margin-left: 10px">{{ $company_email }}</span>
                                        </p>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td style="padding-top: 10px;width: 300px;">
                                        <p
                                            style="font-family: arial;font-size: 12px;margin: 0px;font-weight: 400; text-align: left;padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                            {{ $customer_name }}
                                        </p>
                                    </td>

                                    <td style="padding-top: 10px;width: 300px;">
                                        <p
                                            style="font-family: arial;font-size: 12px;margin: 0px;font-weight: 400;text-align: left; padding-top: 5px;padding-bottom: 5px;padding-left: 5px;">
                                            {{ $company_name }}
                                        </p>
                                        <p
                                            style="font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; text-align: left;padding-bottom: 5px;padding-right: 5px;color: darkgreen;">
                                            <b>Address:</b>
                                        </p>
                                        <p
                                            style="font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; text-align: left;padding-bottom: 5px;padding-right: 5px;color: darkgreen;">
                                            <b>Website:</b>
                                        </p>
                                        <p
                                            style="font-family: arial;font-size: 14px;margin: 0px;font-weight: 400; text-align: left;padding-bottom: 5px;padding-right: 5px;color: darkgreen;">
                                            <b>Email:</b>
                                        </p>
                                    </td>
                                </tr> -->
                            </table>
                            <table
                                style="border-collapse: collapse;border-bottom: 0px;border: 0px; border-radius: 10px; background-image: linear-gradient(to bottom, #349651, #377548);">
                                <tr
                                    style="border-collapse: collapse;height: 50px; color: white;border-bottom: 0px;border: 0px;">
                                    <td
                                        style="width: 100px;text-align: center;font-family: arial;font-size: 11px;margin: 0px;font-weight: 800;border-collapse: collapse;padding-left: 5px;">
                                        <b>NO</b>
                                    </td>
                                    <td
                                        style="width: 300px;text-align: left;font-family: 'Montserrat', sans-serif; font-size: 11px;margin: 0px;font-weight: 800;border-collapse: collapse;">
                                        <b>ITEM DESCRIPTION</b>
                                    </td>
                                    <td
                                        style="width: 150px;text-align: center;font-family: 'Montserrat', sans-serif; font-size: 11px;margin: 0px;font-weight: 800; border-collapse: collapse;padding-left: 5px;">
                                        <b>UNIT PRICE</b>
                                    </td>
                                    <td
                                        style="width: 200px;text-align:center;font-family: 'Montserrat', sans-serif; font-size: 11px;margin: 0px;font-weight: 800;border-collapse: collapse;">
                                        <b>QTY</b>
                                    </td>
                                    <td
                                        style="width:100px;text-align: center;font-family: 'Montserrat', sans-serif; font-size: 11px;margin: 0px;font-weight: 800;border-collapse: collapse;padding-right: 2px;">
                                        <b>Total</b>
                                    </td>
                                </tr>

                                @foreach($products as $product)
                                <tr style="border-collapse: collapse;height: 50px;color: white;">
                                    <td
                                        style="width: 100px;text-align: center;font-family: 'Montserrat', sans-serif;font-size: 11px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 2px;">
                                        <b>{{ $loop->iteration }}</b>
                                    </td>
                                    <td
                                        style="width: 350px;text-align:left;font-family: 'Montserrat', sans-serif;font-size:8px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        <b>{{ $product->name }}</b><br>
                                        
                                    </td>
                                    <td
                                        style="width:150px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 12px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">
                                        {{ site_currency() }} {{  number_format($product->unit_price, 2) }}
                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 12px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        1
                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 12px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                        {{ site_currency() }} {{  number_format($product->unit_price, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                                <tr style="border-collapse: collapse;">

                                    <td colspan="5"
                                        style="border-top-left-radius: 10px;border-bottom-left-radius: 10px; width: 100%;font-weight: 400; border-collapse: collapse;padding-left: 2px;  text-align: right;padding-right: 20px;">
                                        <!-- <div style="display: flex; flex-direction: row; justify-content: flex-end;"> -->
                                            <div style="display:  inline-flex; flex-direction: row;justify-content: space-around;gap: 8px;align-items: center;background-color: white;width: 500px; border-radius:10px; height: 40px ">
                                                <span style="font-size: 20px; color: black;">•</span>
                                                <b style="color: darkgreen; text-align: center;font-family: 'Space Mono', monospace;font-size: 11px;margin: 0px;">SUBTOTAL</b>
                                                <p style="color: darkgreen;">{{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}</p>
                                                <span style="font-size: 20px; color: black;">•</span>
                                                <b style="color: darkgreen; text-align: center;font-family: 'Space Mono', monospace;font-size: 11px;margin: 0px;">DISCOUNT</b>
                                                <p style="color: darkgreen;">{{ site_currency() }} {{ number_format(($discount_amount), 2) }}</p>
                                            </div>
                                        <!-- </div> -->
                                        
                                        
                                        
                                    </td>
                                    <!-- <td
                                        style="width: 300px;padding-left: 5px; text-align:left;font-family: 'Montserrat', sans-serif;font-size:9px;margin: 0px;font-weight: 400; border-collapse: collapse;">
                                        {{ site_currency() }} {{ number_format(($invoice_amount + $discount_amount), 2) }}

                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 8px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">

                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: 'Space Mono', monospace;color: darkgreen; font-size: 12px;margin: 0px;font-weight: 600; border-collapse: collapse;">
                                        DISCOUNT
                                    </td>
                                    <td
                                        style="border-top-right-radius: 10px;border-bottom-right-radius: 10px; width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 9px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-right: 2px;">
                                        {{ site_currency() }} {{ number_format(($discount_amount), 2) }}
                                    </td> -->
                                </tr>
                                <tr style="border-collapse: collapse;height: 50px;color: white;">
                                    <td
                                        style="width: 100px;text-align: center;font-family: 'Montserrat', sans-serif;font-size: 11px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 2px;">
                                        <b></b>
                                    </td>
                                    <td
                                        style="width: 300px;text-align:left;font-family: 'Montserrat', sans-serif;font-size:8px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 8px;margin: 0px;font-weight: 400; border-collapse: collapse;padding-left: 5px;">

                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: 'Montserrat', sans-serif;font-size: 8px;margin: 0px;font-weight: 400; border-collapse: collapse;">

                                    </td>
                                    <td
                                        style="width:100px;text-align:center;font-family: 'Space Mono', monospace;font-size: 12px;margin: 0px;font-weight: 600; border-collapse: collapse;padding-right: 2px;">
                                        Total Due
                                    </td>
                                </tr>
                                <tr style="border-collapse: collapse;height: 50px;color: white;">
                                   
                                    <td colspan="5"
                                        style="width:100px;text-align:right;font-family: 'Montserrat', sans-serif;font-size: 28px;margin: 0px;font-weight: 800; border-collapse: collapse;padding-right: 2px;">
                                        {{ site_currency() }} {{ number_format(($invoice_amount ), 2) }}
                                    </td>
                                </tr>

                                <br><br>
                            </table>
                        </td>
                    </tr>
                    <!-- Content End-->
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
