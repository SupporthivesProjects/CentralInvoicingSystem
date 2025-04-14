@extends('layouts.app')

@section('title', 'Manage Currencies | Central Invoice System')

@section('content')
    <div class="main-content app-content">
            <div class="container-fluid">
                  <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1"> Manage Currencies </h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item active" aria-current="page">Currencies</li>
                    </ol>
                </div>
            </div>
            <!-- Page Header Close -->

            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="card-title">Currencies</div>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addCurrencyModal">
                            <i class="fas fa-plus"></i> Add Currency
                        </button>
                    </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="file-export" class="table table-bordered text-nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="wd-15p">#</th>
                                            <th class="wd-15p">Currency Name</th>
                                            <th class="wd-15p">Currency Code</th>
                                            <th class="wd-15p">Exchange Rate</th>
                                            <th class="wd-15p">Currency Symbol</th>
                                            <th class="wd-15p">Status</th>
                                            <th class="wd-15p">Created At</th>
                                            <th class="wd-15p">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($currencies as $currency)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $currency->name }}</td>
                                            <td>{{ $currency->code }}</td>
                                            <td>{{ $currency->exchange_rate }}</td>
                                            <td>{{ $currency->symbol }}</td>
                                            <td>{{ $currency->status == 1 ? 'Active' : 'Inactive' }}</td>
                                            <td>{{ $currency->created_at->format('Y-m-d H:i:s') }}</td>
                                            <td>
                                              <button type="button" class="btn btn-info currency_edit" data-id="{{ $currency->id }}">Edit</button>
                                              <button type="button" class="btn btn-danger currency_delete" data-id="{{ $currency->id }}">Delete</button>
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
    
        <div class="modal fade" id="addCurrencyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" 
            aria-labelledby="addCurrencyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="addCurrencyModalLabel">Add New Currency</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Form to add currency -->
                    <form method="POST" action="{{ route('currency.add') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Currency Name</label>
                                <input type="text" name="name" id="name" class="form-control" required placeholder="Enter currency name">
                            </div>
                            <div class="mb-3">
                                <label for="symbol" class="form-label">Currency Symbol</label>
                                <input type="text" name="symbol" id="symbol" class="form-control" required placeholder="Enter currency symbol">
                            </div>
                            <div class="mb-3">
                                <label for="exchange_rate" class="form-label">Exchange Rate</label>
                                <input type="number" step="0.00001" name="exchange_rate" id="exchange_rate" class="form-control" required placeholder="Enter exchange rate">
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="code" class="form-label">Currency Code</label>
                                <input type="text" name="code" id="code" class="form-control" placeholder="Enter currency code" required>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Currency</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editCurrencyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" 
            aria-labelledby="addCurrencyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="editCurrencyModalLabel">Edit Currency</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Form to add currency -->
                    <form method="POST" action="{{ route('currency.edit') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Currency Name</label>
                                <input type="hidden" name="currency_id" id="currency_id">
                                <input type="text" name="name" id="name" class="form-control" required placeholder="Enter currency name">
                            </div>
                            <div class="mb-3">
                                <label for="symbol" class="form-label">Currency Symbol</label>
                                <input type="text" name="symbol" id="symbol" class="form-control" required placeholder="Enter currency symbol">
                            </div>
                            <div class="mb-3">
                                <label for="exchange_rate" class="form-label">Exchange Rate</label>
                                <input type="number" step="0.00001" name="exchange_rate" id="exchange_rate" class="form-control" required placeholder="Enter exchange rate">
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="code" class="form-label">Currency Code</label>
                                <input type="text" name="code" id="code" class="form-control" placeholder="Enter currency code" required>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
@endsection
@push('scripts')
<script>
   $(document).on('click', '.currency_edit', function () {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Fetching currency details',
        html: 'we fetching currency details, please wait...',
        icon: 'info',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    $.ajax({
        url: `/currency/${id}`,
        method: 'GET',
        success: function (currency) {
            $('#editCurrencyModal #currency_id').val(currency.id);
            $('#editCurrencyModal #name').val(currency.name);
            $('#editCurrencyModal #symbol').val(currency.symbol);
            $('#editCurrencyModal #exchange_rate').val(currency.exchange_rate);
            $('#editCurrencyModal #code').val(currency.code);
            $('#editCurrencyModal #status').val(currency.status);
            Swal.close();
            $('#editCurrencyModal').modal('show');
        },
        error: function () {
            toastr.error('Failed to fetch currency details');
        }
    });
});

</script>
<script>
    $(document).on('click', '.currency_delete', function () {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'This currency will be deleted permanently.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch(`/currency/delete/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        return data;
                    } else {
                        throw new Error(data.message || 'Delete failed');
                    }
                })
                .catch(error => {
                    Swal.showValidationMessage(`Error: ${error}`);
                    return false; // Make sure the Swal is not closed immediately
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed && result.value?.success) {
                toastr.success(result.value.message || 'Currency deleted successfully');
                setTimeout(() => {
                    location.reload(); 
                }, 500);
            } else if (result.value && !result.value.success) {
                toastr.error(result.value.message || "Failed to delete currency!");
            }
        });
    });
</script>

@endpush