@forelse(collect($products)->sortByDesc('unit_price') as $index => $product)
    @php
        $captureFields = json_decode($product->game_need_to_capture ?? '{}', true);
        $platforms = array_keys($captureFields);
    @endphp

    {{-- Main Row --}}
    <tr class="product-row align-middle" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $index + 1 }}" aria-expanded="false" aria-controls="collapse-{{ $index + 1 }}" style="cursor: pointer;">
        <td class="text-center">
            <div class="form-check m-0 d-flex justify-content-center">
                <input class="form-check-input narayan-checkbox border-primary" type="checkbox"
                       name="product_ids[]" data-unit_price="{{ $product->unit_price }}"
                       value="{{ $product->id }}">
            </div>
        </td>
        <td>{{ $index + 1 }}</td>
        <td>
            {{ $product->name }}
            @if ($site->site_link && $product->slug)
                <a href="{{ $site->site_link }}/product/{{ $product->slug }}" target="_blank">🔗</a>
            @endif
        </td>
        <td><span class="badge bg-secondary">{{ $product->game_currency ?? '-' }}</span></td>
        <td>{{ $product->game_currency_amount . ' ' . $product->game_currency }}</td>
        <td>{{ $currency->symbol }}{{ number_format($product->unit_price, 2) }}</td>
        <td><span class="badge rounded-pill bg-info">{{ $product->source ?? 'Custom' }}</span></td>
    </tr>

    {{-- Expandable Capture Row --}}
    <tr>
        <td colspan="7" class="p-0 border-0">
            <div class="collapse bg-light" id="collapse-{{ $index + 1 }}" data-bs-parent="#product-table-body">
                <div class="p-3">
                    <h6 class="fw-bold mb-3">Game Account Details Required:</h6>

                    @if (!empty($captureFields))
                        {{-- Platform Dropdown --}}
                        <div class="mb-3">
                            <label class="form-label">Select Platform:</label>
                            <select class="form-select select-platform"
                                    data-product-id="{{ $product->id }}"
                                    onchange="handlePlatformChange(this)">
                                <option value="">-- Select Platform --</option>
                                @foreach ($platforms as $platform)
                                    <option value="{{ \Illuminate\Support\Str::slug($platform, '_') }}">
                                        {{ $platform }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Fields for each platform --}}
                        @foreach ($captureFields as $platform => $fields)
                            @php $slug = \Illuminate\Support\Str::slug($platform, '_'); @endphp
                            <div class="platform-section" data-product-id="{{ $product->id }}"
                                 data-platform="{{ $slug }}" style="display: none;">
                                <div class="row">
                                    @foreach ($fields as $field)
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">{{ $field }}</label>
                                            <input type="text" class="form-control"
                                                   name="game_capture[{{ $product->id }}][{{ $platform }}][{{ \Illuminate\Support\Str::slug($field, '_') }}]"
                                                   placeholder="Enter {{ $field }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-muted">No capture fields defined.</div>
                    @endif
                </div>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center text-muted py-3">No results found.</td>
    </tr>
@endforelse
