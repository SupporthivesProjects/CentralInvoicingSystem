 @forelse($products as $index => $product)
<tr>
<tr class="product-row">
    <td class="text-center align-middle">
        <div class="form-check d-flex justify-content-center align-items-center m-0">
            <input class="form-check-input border narayan-checkbox border-1 border-primary" type="checkbox" name="product_ids[]" data-unit_price="{{ $product->unit_price }}" value="{{ $product->id }}">
        </div>    
    </td>
    <td>{{ $index + 1 }}</td>
    <td>{{ $product->name }} @if($site->site_link && $product->slug)<a href="{{ $site->site_link }}/product/{{ $product->slug }}" target="_blank">🔗</a>@endif</td>
    <td>{{ $currency->symbol }}{{ number_format($product->unit_price, 2) }}</td>
    <td>{{ $product->source ?? 'Custom' }}</td>
    <td>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">{{ $currency->symbol }}</span> 
        </div>
        <input class="form-control product-price" value="{{ $product->unit_price }}" type="number" data-product-id="{{ $product->id }}" {{ ($product->source ?? 'Custom') !== 'Custom' ? 'readonly' : '' }}>
    </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center text-muted py-3 border-top">
        No results found. Try randomizing or use a different keyword.
    </td>
</tr>
@endforelse
