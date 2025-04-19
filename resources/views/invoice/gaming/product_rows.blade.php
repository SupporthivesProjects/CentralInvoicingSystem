@forelse(collect($products)->sortByDesc('unit_price') as $index => $product)
                <tr class="product-row">
                    <td class="text-center align-middle">
                        <div class="form-check d-flex justify-content-center align-items-center m-0">
                            <input class="form-check-input border narayan-checkbox border-1 border-primary"
                                   type="checkbox"
                                   name="product_ids[]"
                                   data-unit_price="{{ $product->unit_price }}"
                                   value="{{ $product->id }}">
                        </div>
                    </td>

                    <td>{{ $index + 1 }}</td>

                    <td>
                        {{ $product->name }}
                        @if($site->site_link && $product->slug)
                            <a href="{{ $site->site_link }}/product/{{ $product->slug }}" target="_blank">🔗</a>
                        @endif
                    </td>

                    {{-- ✅ Game Currency Column --}}
                    <td>
                        <span class="badge bg-secondary">
                            {{ $product->game_currency ?? '-' }}
                        </span>
                    </td>
                    <td>
                        {{ $product->game_currency_amount." ".$product->game_currency }}
                    </td>

                    {{-- ✅ Unit Price --}}
                    <td>{{ $currency->symbol }}{{ number_format($product->unit_price, 2) }}</td>

                    {{-- ✅ Product Source Badge --}}
                    <td>
                        <span class="badge rounded-pill bg-info">
                            {{ $product->source ?? 'Custom' }}
                        </span>
                    </td>

                    {{-- ✅ Price Input with Lock/Edit Icon --}}
                    {{-- <td>
                        <div class="input-group">
                            <span class="input-group-text">{{ $currency->symbol }}</span>

                            <input type="number"
                                   step="0.01"
                                   class="form-control product-price"
                                   value="{{ $product->unit_price }}"
                                   data-product-id="{{ $product->id }}"
                                   {{ $product->can_edit_price == 0 || $product->source == 'Random' ? 'readonly' : '' }}
                                   aria-label="Unit price">

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
                    </td> --}}
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-3 border-top">
                        No results found. Try randomizing or use a different keyword.
                    </td>
                </tr>
            @endforelse

            @push('scripts')
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                    tooltips.forEach(el => new bootstrap.Tooltip(el));
                });
            </script>
            @endpush
