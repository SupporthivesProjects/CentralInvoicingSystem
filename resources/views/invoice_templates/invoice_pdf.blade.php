{{-- 
Customer: {{ $customer['customer_name'] }}
Email: {{ $customer['customer_email'] }}
Invoice #: {{ $customer['invoice_number'] }}
Amount: {{ $customer['invoice_amount'] }}
Date: {{ $customer['invoice_date'] }}

@foreach($products as $product)
    Product: {{ $product->name }} – {{$currency->symbol }} {{ $product->unit_price }}
@endforeach --}}


