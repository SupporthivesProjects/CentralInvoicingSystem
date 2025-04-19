@forelse($products as $index => $product)
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
    <span class="input-group-text">{{ $currency->symbol }}</span>
    
    <input type="text" class="form-control product-price" 
           value="{{ $product->unit_price }}" 
           type="number" 
           data-product-id="{{ $product->id }}"
           {{ $product->can_edit_price == 0 || $product->source == 'Random' ? 'readonly' : '' }}  
           aria-label="Amount (to the nearest dollar)">

           <span class="input-group-text d-flex align-items-center">
                <i class="{{ ($product->can_edit_price == 0 || $product->source == 'Random') ? 'fas fa-lock text-muted' : 'fas fa-edit' }}" 
                style="font-size: 12px;"
                @if($product->source == 'Custom' || $product->source == 'Random')
                data-bs-toggle="tooltip" 
                data-bs-placement="top" 
                title="{{
                        $product->source == 'Random' ? 'No Edit in Randomize.' : 
                        ($product->can_edit_price == 0 ? 'Price update allowed after ' . $product->remaining_days . ' days.' : 'You can update the price.')
                }}"
                @endif>
                </i>
            </span>
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
<script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
</script>
