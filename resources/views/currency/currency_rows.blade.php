@foreach ($currencies as $currency)
<tr>
    <td class="text-center">{{ $loop->iteration }}</td>
    <td>{{ $currency->name }}</td>
    <td class="text-center">{{ $currency->code }}</td>
    <td>{{ $currency->exchange_rate }}</td>
    <td class="text-center">{{ $currency->symbol }}</td>
    <td class="text-center">{{ $currency->status == 1 ? 'Active' : 'Inactive' }}</td>
    <td>{{ $currency->created_at->format('Y-m-d H:i:s') }}</td>
    <td class="text-center">
        <button type="button" class="btn btn-info currency_edit" data-id="{{ $currency->id }}">
            <i class="fas fa-edit"></i>
        </button>
        <button type="button" class="btn btn-danger currency_delete" data-id="{{ $currency->id }}">
            <i class="fas fa-trash-alt"></i>
        </button>
    </td>
</tr>
@endforeach