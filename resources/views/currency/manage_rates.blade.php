@extends('layouts.app')

@section('title', 'Manage Currency Combination rates | Central Invoice System')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
            <div>
                <h2 class="main-content-title fs-24 mb-1">Manage Currencies</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item active" aria-current="page">Currencies</li>
                </ol>
            </div>
        </div>
        <!-- Page Header Close -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">

                    <!-- Card Header -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="card-title mb-0">Currencies</div>

                        <div class="d-flex align-items-center ms-auto gap-2">
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addRateModal">
                                <i class="fas fa-plus"></i> Add Conversion Rate
                            </button>
                        </div>
                    </div>
                    <!-- Card Header Close -->

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap" style="width: 100%;" id="file-export">
                                <thead>
                                    <tr>
                                        <th>Sr.No.</th>
                                        <th>From Currency</th>
                                        <th>To Currency</th>
                                        <th>Rate</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rates as $index => $rate)
                                        <tr data-id="{{ $rate->id }}">
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>
                                                {{ $rate->fromCurrency->name ?? '-' }} ({{ $rate->fromCurrency->code ?? '' }})
                                            </td>
                                            <td>
                                                {{ $rate->toCurrency->name ?? '-' }} ({{ $rate->toCurrency->code ?? '' }})
                                            </td>
                                            <td>
                                                <input type="number" class="form-control rate" value="{{ $rate->rate }}" step="0.000001">
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-success update-rate">Update</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>


<div class="modal fade" id="addRateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addRateForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Currency Rate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body row g-2">
                <div class="col-md-6">
                    <label class="form-label">From</label>
                    <select class="form-select" name="from_currency_id" required>
                        @foreach($currencies as $currency)
                            <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">To</label>
                    <select class="form-select" name="to_currency_id" required>
                        @foreach($currencies as $currency)
                            <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 mt-2">
                    <label class="form-label">Rate</label>
                    <input type="number" name="rate" step="0.000001" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Add Rate</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).on('click', '.update-rate', function () {
    const $btn = $(this);
    const row = $btn.closest('tr');
    const id = row.data('id');
    const rate = row.find('.rate').val();

    if (!id) {
        toastr.error('Rate ID is missing.');
        return;
    }

    const originalHtml = $btn.html();
    $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...').prop('disabled', true);

    $.ajax({
        url: "{{ route('currencies.updateRate') }}",
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
            id,
            rate
        },
        success: function (res) {
            if (res.success) {
                toastr.success(res.message || 'Rate updated successfully');
            } else {
                toastr.error(res.message || 'Update failed');
            }
        },
        error: function () {
            toastr.error('Server error');
        },
        complete: function () {
            $btn.html(originalHtml).prop('disabled', false);
        }
    });
});

</script>


<script>
$(document).ready(function () {
    $('#addRateForm').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        var formData = form.serialize();
        $.ajax({
            url: "{{ route('currencies.storeRate') }}",
            method: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            beforeSend: function () {
                form.find('button[type="submit"]').prop('disabled', true).text('Adding...');
            },
            success: function (response) {
                form[0].reset();
                $('#addRateModal').modal('hide');
                const fromCurrencyText = form.find('select[name="from_currency_id"] option:selected').text();
                const toCurrencyText = form.find('select[name="to_currency_id"] option:selected').text();
                const involvedCurrencies = `${fromCurrencyText} to ${toCurrencyText}`;
                toastr.success(`Rate added for ${involvedCurrencies}`, 'Success');
                location.reload();
            },
            error: function (xhr) {
                toastr.error('Failed to add rate', 'Error');
            },
            complete: function () {
                form.find('button[type="submit"]').prop('disabled', false).text('Add Rate');
            }
        });
    });
});
</script>
@endpush
