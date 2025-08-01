@extends('layouts.app')

@section('title', 'Manage Currencies | Central Invoice System')

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
                <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">Currencies</div>

                <div class="d-flex align-items-center ms-auto gap-2">
                    <button id="updateRatesBtn" class="btn btn-success">
                        <i class="fas fa-sync-alt"></i> Update Live Rates
                    </button>
                    <button id="cancelUpdateBtn" class="btn btn-danger" style="display: none;">
                        Cancel Update ?
                    </button>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addCurrencyModal">
                        <i class="fas fa-plus"></i> Add Currency
                    </button>
                </div>
            </div>


                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="file-export" class="table table-bordered text-nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="wd-15p">#</th>
                                        <th class="wd-15p"> Name</th>
                                        <th class="wd-15p"> Code</th>
                                        <th class="wd-15p"> Rate</th>
                                        <th class="wd-15p"> Symbol</th>
                                        <th class="wd-15p">Status</th>
                                        <th class="wd-15p">Created At</th>
                                        <th class="wd-15p">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="currencyTableBody">
                                    @foreach ($currencies as $currency)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $currency->name }}</td>
                                        <td class="text-center">{{ $currency->code }}</td>
                                        <td >{{ $currency->exchange_rate }}</td>
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
                                </tbody>
                            </table>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>

    <!-- Add Currency Modal -->
    <div class="modal fade" id="addCurrencyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addCurrencyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="addCurrencyModalLabel">Add New Currency</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addcurrency-form" method="POST" action="{{ route('currency.add') }}">
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

    <!-- Edit Currency Modal -->
    <div class="modal fade" id="editCurrencyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addCurrencyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="editCurrencyModalLabel">Edit Currency</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" id="updatecurrency-form" action="{{ route('currency.edit') }}">
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
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('addcurrency-form').addEventListener('submit', function () {
        Swal.fire({
            title: 'Adding New Currency...',
            html: `
                <div class="d-flex flex-column align-items-center">
                     <div class="loaderBar"></div>
                    <small class="mt-3">Hold tight! Your new currency is being added right now.</small>
                </div>
            `,
            showConfirmButton: false,
            allowOutsideClick: false
        });
    });
</script>

<script>
    document.getElementById('updatecurrency-form').addEventListener('submit', function () {
        Swal.fire({
            title: 'Updating Currency...',
            html: `
                <div class="d-flex flex-column align-items-center">
                     <div class="loaderBar"></div>
                    <small class="mt-3">Hold tight! Your currency is being updated right now.</small>
                </div>
            `,
            showConfirmButton: false,
            allowOutsideClick: false
        });
    });
</script>

<script>
$(document).ready(function () {
    let xhrRequest = null;

    $('#updateRatesBtn').on('click', function () {
        Swal.fire({
            title: 'Update All Currency Live Rates?',
            text: "This will update the live rates for all currencies. Do you want to proceed?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update all!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                var $btn = $('#updateRatesBtn');
                var $cancelBtn = $('#cancelUpdateBtn');

                $btn.prop('disabled', true).html('<i class="fas fa-sync fa-spin"></i> Updating Live Rates...');
                $cancelBtn.show();

                xhrRequest = $.ajax({
                    url: "{{ route('currencies.updateRates.ajax') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (res) {
                        if (res.success) {
                            toastr.success('All currency rates updated successfully.');
                         
                            const table = $('#file-export').DataTable();
                            table.clear().destroy();

                            $('#currencyTableBody').html(res.html);

                            $('#file-export').DataTable({
                                dom: 'lBfrtip', 
                                buttons: [
                                    'copy', 'csv', 'excel', 'pdf', 'print'
                                ],
                                language: {
                                    searchPlaceholder: 'Search...',
                                    sSearch: '',
                                },
                                pageLength: 10,
                            });
                        } else {
                            toastr.error('Failed to update currency rates.');
                        }
                    },
                    error: function (xhr, textStatus) {
                        if (textStatus === 'abort') {
                            toastr.info('Currency update was cancelled.');
                        } else {
                            toastr.error('Server error while updating rates.');
                        }
                    },
                    complete: function () {
                        $btn.prop('disabled', false).html('<i class="fas fa-sync-alt"></i> Update Live Rates');
                        $cancelBtn.hide();
                        xhrRequest = null;
                    }
                });
            }
        });
    });

    $('#cancelUpdateBtn').on('click', function () {
        Swal.fire({
            title: 'Cancel Update?',
            text: "Are you sure you want to cancel the ongoing currency update?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, cancel it',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed && xhrRequest) {
                xhrRequest.abort();
            }
            location.reload(true);
        });
    });
});
</script>




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
        url: '{{ route("currency.get", ":id") }}'.replace(':id', id),
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