@forelse($products as $index => $product)
<tr>
    
    <td><input type="checkbox" name="product_ids[]" value="{{ $product->id }}"></td>
       
    <td>{{ $index + 1 }}</td>
    <td>#{{ $product->id }}</td>
    <td>{{ $product->name }}</td>
    <td>{{ $currency->symbol }} {{ number_format($product->unit_price, 2) }}</td>
    <td>{{ $product->source ?? 'Manual' }}</td>
    <td>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">{{ $currency->symbol }}</span> 
        </div>
        <input class="form-control product-price" value="{{ $product->unit_price }}" type="number">
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

