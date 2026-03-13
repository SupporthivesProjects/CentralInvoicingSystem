<!DOCTYPE html>
<html>

<head>
    <title>Your Email Title</title>
</head>

<body style="padding: 0px; margin: 0px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 0px;">
                <table width="800" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
                    style="border-collapse: collapse; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); background-image: url('{{ $invoice_image1 }}'); background-position: center; background-repeat: no-repeat; background-size: cover;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="padding: 100px 0px; position: relative;">
                            <div style="position: absolute; top: 80px; right: 175px; width: 200px;">
                                <p
                                    style="color: #000000; font-family: Arial;font-size: 18px;margin: 0px;font-weight: 600;">
                                    <b>FLUX DIGITALS</b>
                                </p>
                                <p
                                    style="color: #000000; font-family: Arial;text-align: start; margin: 0px; font-size: 10px;margin-top:6px;font-weight: 400;">
                                    {!! $company_address !!}<br>
                                    {{ $company_email }} | {{ $company_mobile }}
                                </p>
                            </div>
                        </td>
                    </tr>
                    <!-- Header End -->

                    <!-- Content -->
                    <tr>
                        <td
                            style="padding:0px 60px 150px 60px;background-position: center;background-size: cover;height:444px;">
                            <table style="width:100%;">
                                <tr>
                                    <td>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <div
                                            style="display: flex; justify-content: space-between; gap: 40px; width: 100%;">
                                            <div class="info_left">
                                                <div class="l_top" style="display: flex;flex-direction: row;">
                                                    <div
                                                        style="padding: 10px; height: 30px; background-color: #F2F2F2; width: 130px; border: 1px solid grey;">
                                                        <p
                                                            style="color:#000000; text-align:start;padding:10px;font-family:  Arial;font-size:10px;margin: 0px;font-weight: 400;">
                                                            Invoice No.
                                                        </p>
                                                    </div>
                                                    <div
                                                        style="padding: 10px; height: 30px; background-color: #F2F2F2; width: 130px; border: 1px solid grey; border-left: none;">
                                                        <p
                                                            style="color:#000000; text-align:start;padding:10px;font-family:  Arial;font-size:10px;margin: 0px;font-weight: 400;">
                                                            {{ $invoice_number }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="l_top" style="display: flex;flex-direction: row;">
                                                    <div
                                                        style="padding: 10px; height: 30px; background-color: #FFFFFF; width: 130px; border: 1px solid grey; border-top: none;">
                                                        <p
                                                            style="color:#000000; text-align:start;padding:10px;font-family:  Arial;font-size:10px;margin: 0px;font-weight: 400;">
                                                            Invoice Date.
                                                        </p>
                                                    </div>
                                                    <div
                                                        style="padding: 10px; height: 30px; background-color: #FFFFFF; width: 130px; border: 1px solid grey; border-left: none; border-top: none;">
                                                        <p
                                                            style="color:#000000; text-align:start;padding:10px;font-family:  Arial;font-size:10px;margin: 0px;font-weight: 400;">
                                                            {{ $invoice_date }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info_right"
                                                style="width: 300px; height: 140px; border: 1px solid grey; padding: 5px; display: flex; flex-direction: column; gap: 8px;">
                                                <p
                                                    style="color:#000000; text-align:start;padding:8px 10px;font-family:  Arial;font-size:10px;margin: 0px;font-weight: 400; width: 93%; background-color: #F2F2F2;">
                                                    Invoice to
                                                </p>
                                                <p
                                                    style="color:#000000; text-align:start;padding:8px;font-family:  Arial;font-size:18px;margin: 0px;font-weight: 400;">
                                                    {{ $customer_name }}
                                                </p>
                                               
                                                    {{ $customer_email ? $customer_email : '' }}
                                                    {{ $customer_mobile ? $customer_mobile : '' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <div style="min-height: 460px;">
                                <table style="border-collapse: collapse;">
                                    <thead>
                                        <tbody>
                                            @forelse ($products as $product)
                                            <tr style="height: 24px;">
                                                <td style="text-align:center;padding:10px;">
                                                    {{ $loop->iteration }}
                                                </td>
                                            
                                                <td style="text-align:left;padding:10px;">
                                                    {{ $product->name }}
                                                </td>
                                            
                                                <td style="text-align:center;padding:10px;">
                                                    1
                                                </td>
                                            
                                                <td style="text-align:center;padding:10px;background:#F2F2F2;">
                                                    {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}
                                                </td>
                                            
                                                <td style="text-align:right;padding:10px;background:#F2F2F2;">
                                                    {{ site_currency() . number_format($product->unit_price ?? 0, 2) }}
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                            <td colspan="5" style="text-align:center;padding:10px;">
                                            No Products Found
                                            </td>
                                            </tr>
                                            @endforelse
                                            </tbody>
                                        
                                    </thead>
                                    
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
