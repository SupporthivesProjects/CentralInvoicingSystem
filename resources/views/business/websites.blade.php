@extends('layouts.app')

@section('title', 'Available Websites | Central Invoice System')

@section('content')

    <div class="main-content app-content">
            <div class="container-fluid">
                  <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Manage Websites</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item active" aria-current="page">Available Websites</li>
                    </ol>
                </div>
            </div>
            <!-- Page Header Close -->


                <!-- Start:: row-4 -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">Available Websites</div>
                                @if(auth()->user()->roles->contains('name', 'developer'))
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('connectivity.report') }}" class="btn btn-sm btn-success d-flex align-items-center gap-1">
                                            <i class="fas fa-network-wired"></i> Check Connectivity
                                        </a>
                                        <button type="button" class="btn btn-sm btn-info d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#import-credentials-modal">
                                            <i class="fas fa-file-import"></i> Import DB Credentials
                                        </button>
                                        <a href="{{ route('website.create') }}" class="btn btn-sm btn-primary d-flex align-items-center gap-1 group">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                        </svg>
                                        New Website
                                        </a>
                                    </div>
                                @endif


                              </div>
                            <div class="card-body">
                                @if(session('encrypt_report') && auth()->user()->roles->contains('name', 'developer'))
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <strong>Encrypted now:</strong>
                                        <ul class="mb-2">
                                            @forelse(session('encrypt_report.encrypted') as $item)
                                                <li>{{ $item }}</li>
                                            @empty
                                                <li>None</li>
                                            @endforelse
                                        </ul>
                                        <strong>Already secure:</strong>
                                        <ul class="mb-0">
                                            @forelse(session('encrypt_report.already_secure') as $item)
                                                <li>{{ $item }}</li>
                                            @empty
                                                <li>None</li>
                                            @endforelse
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table id="websites-datatables" class="table table-bordered text-nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Business Model</th>
                                            <th>Site Name</th>
                                            <th>Bank Name</th>
                                            <th>Bank Code</th>
                                            <th class="text-center">Actions</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>

                                        <tbody>
                                            @foreach ($websites as $index => $site)
                                                <tr>
                                                    <td>{{ $site->id }}</td>
                                                    <td data-bs-toggle="tooltip" title="{{ $site->technology }}">
                                                        {{ $site->businessModel->name ?? '-' }}
                                                    </td>

                                                    <td>
                                                        {{ $site->site_name }}
                                                        @if($site->site_link)
                                                            <a href="{{ $site->site_link }}" target="_blank">
                                                                <i class="bi bi-box-arrow-up-right ms-1"></i>
                                                            </a>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control inline-edit" data-id="{{ $site->id }}" data-field="bank_name" value="{{ $site->bank_name }}">
                                                            <span class="input-group-text update-icon">
                                                            <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        </td>

                                                        <td>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control inline-edit" data-id="{{ $site->id }}" data-field="bank_code" value="{{ $site->bank_code }}">
                                                            <span class="input-group-text update-icon">
                                                            <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                    </td>

                                                    <td class="text-center">
                                                        <button onclick="window.location.href='{{ route('site.connect.db', $site->id) }}'" class="btn btn-sm btn-warning"
                                                            @if($site->site_status === 'pdown') disabled @endif>
                                                            <i class="fas fa-file-invoice"></i> Generate Invoice
                                                        </button>
                                                        @if(auth()->user()->roles->contains('name', 'developer'))
                                                            <a href="{{ route('website.edit', $site->id) }}" class="btn btn-sm btn-primary">
                                                                    <i class="fas fa-edit"></i> Edit
                                                                </a>
                                                            <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $site->id }}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        @endif

                                                    </td>
                                                    <td class="text-center">
                                                        @php
                                                            $statusMap = [
                                                                'live' => ['class' => 'success', 'title' => 'Site is live'],
                                                                'tdown' => ['class' => 'warning', 'title' => 'Site is temporarily down'],
                                                                'pdown' => ['class' => 'danger', 'title' => 'Site is permanently down'],
                                                            ];
                                                        @endphp

                                                        <span class="badge bg-{{ $statusMap[$site->site_status]['class'] }}" data-bs-toggle="tooltip" title="{{ $statusMap[$site->site_status]['title'] }}">
                                                            {{ $site->site_status }}
                                                        </span>
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
                <!-- End:: row-4 -->

            </div>
        </div>

        @if(auth()->user()->roles->contains('name', 'developer'))
        <div class="modal fade" id="import-credentials-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Import DB Credentials</h5>
                        <button type="button" class="btn-close" id="import-close-x" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger d-none" id="import-error"></div>

                        <div id="import-step-upload">
                            <p class="text-muted mb-3">
                                Upload a .csv or .xlsx file with the columns
                                <code>domain</code>, <code>ipaddress</code>, <code>dbname</code>, <code>username</code>, <code>password</code>, <code>port</code>.
                                Nothing is written until you confirm the preview. Values are saved encrypted and verified.
                            </p>
                            <div class="input-group">
                                <input type="file" class="form-control" id="import-file" accept=".csv,.txt,.xlsx,.xls">
                                <button type="button" class="btn btn-primary" id="import-analyze-btn">
                                    <i class="fas fa-search"></i> Analyze File
                                </button>
                            </div>
                        </div>

                        <div id="import-step-preview" class="d-none">
                            <div class="d-flex flex-wrap gap-2 mb-3" id="import-summary"></div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>Preview</strong>
                                <select class="form-select form-select-sm w-auto" id="import-filter">
                                    <option value="all">All rows</option>
                                    <option value="update">Will update</option>
                                    <option value="unchanged">No change</option>
                                    <option value="not_found">Not found</option>
                                    <option value="conflict">Conflict</option>
                                    <option value="ambiguous">Ambiguous</option>
                                    <option value="invalid">Invalid</option>
                                    <option value="no_data">No data</option>
                                </select>
                            </div>
                            <div class="table-responsive border rounded" style="max-height:380px;overflow:auto;">
                                <table class="table table-sm table-bordered mb-0 align-middle">
                                    <thead class="table-light" style="position:sticky;top:0;">
                                        <tr>
                                            <th>Line</th>
                                            <th>Domain</th>
                                            <th>Website</th>
                                            <th>Status</th>
                                            <th>Fields</th>
                                            <th>Note</th>
                                        </tr>
                                    </thead>
                                    <tbody id="import-preview-body"></tbody>
                                </table>
                            </div>
                        </div>

                        <div id="import-step-progress" class="d-none">
                            <div class="d-flex justify-content-between mb-1">
                                <strong id="import-progress-title">Importing...</strong>
                                <span id="import-progress-count">0 / 0</span>
                            </div>
                            <div class="progress mb-3" style="height:22px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" id="import-progress-bar" role="progressbar" style="width:0%">0%</div>
                            </div>
                            <div class="d-flex flex-wrap gap-2 mb-3" id="import-progress-stats"></div>
                            <div class="table-responsive border rounded" style="max-height:340px;overflow:auto;">
                                <table class="table table-sm table-bordered mb-0 align-middle">
                                    <thead class="table-light" style="position:sticky;top:0;">
                                        <tr>
                                            <th>Domain</th>
                                            <th>Website</th>
                                            <th>Status</th>
                                            <th>Fields</th>
                                            <th>Message</th>
                                        </tr>
                                    </thead>
                                    <tbody id="import-result-body"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary d-none" id="import-back-btn">Back</button>
                        <button type="button" class="btn btn-outline-primary d-none" id="import-report-btn"><i class="fas fa-download"></i> Download Report</button>
                        <button type="button" class="btn btn-success d-none" id="import-start-btn"><i class="fas fa-play"></i> Start Import</button>
                        <button type="button" class="btn btn-secondary" id="import-close-btn" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

@endsection
@push('scripts')
<script>
    $(document).on('click', '#encrypt-all-btn', function () {
        Swal.fire({
            title: 'Encrypt all credentials?',
            text: 'Remote DB and API credentials of every website will be encrypted. Already encrypted ones are skipped.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, encrypt',
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Encrypting...');
                $('#encrypt-all-form').trigger('submit');
            }
        });
    });

    $(document).on('click', '.delete-btn', function () {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                const url = `{{ route('website.delete', ':id') }}`.replace(':id', id);

                return fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.json();
                })
                .catch(error => {
                    Swal.showValidationMessage(`Delete failed: ${error}`);
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed && result.value?.success) {
                toastr.success(result.value.message || "Deleted successfully!");
                setTimeout(() => {
                    location.reload(); 
                }, 1500);
            } else if (result.value && !result.value.success) {
                toastr.error(result.value.message || "Failed to delete!");
            }
        });
    });
</script>

@if(auth()->user()->roles->contains('name', 'developer'))
<script>
    (function () {
        const modalEl = document.getElementById('import-credentials-modal');

        if (!modalEl) {
            return;
        }

        const routes = {
            preview: "{{ route('website.import.preview') }}",
            apply: "{{ route('website.import.apply') }}",
            cancel: "{{ route('website.import.cancel') }}"
        };
        const csrf = "{{ csrf_token() }}";

        const previewLabels = {
            update: ['success', 'Will update'],
            unchanged: ['secondary', 'No change'],
            not_found: ['danger', 'Not found'],
            conflict: ['warning', 'Conflict'],
            ambiguous: ['warning', 'Ambiguous'],
            invalid: ['danger', 'Invalid'],
            no_data: ['secondary', 'No data']
        };
        const resultLabels = {
            updated: ['success', 'Updated'],
            unchanged: ['secondary', 'No change'],
            failed: ['danger', 'Failed']
        };

        const el = (id) => document.getElementById(id);
        const steps = { upload: el('import-step-upload'), preview: el('import-step-preview'), progress: el('import-step-progress') };
        const buttons = { back: el('import-back-btn'), start: el('import-start-btn'), report: el('import-report-btn'), close: el('import-close-btn'), closeX: el('import-close-x'), analyze: el('import-analyze-btn') };
        const errorBox = el('import-error');

        let state = { token: null, rows: [], results: [], running: false, finished: false };

        const esc = (value) => String(value === null || value === undefined ? '' : value)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');

        const badge = (label) => '<span class="badge bg-' + label[0] + '">' + esc(label[1]) + '</span>';

        function showStep(name) {
            Object.keys(steps).forEach((key) => steps[key].classList.toggle('d-none', key !== name));
            buttons.back.classList.toggle('d-none', name !== 'preview');
            buttons.start.classList.toggle('d-none', name !== 'preview');
            buttons.report.classList.add('d-none');
        }

        function showError(message) {
            errorBox.textContent = message;
            errorBox.classList.toggle('d-none', !message);
        }

        function setLocked(locked) {
            state.running = locked;
            buttons.close.disabled = locked;
            buttons.closeX.disabled = locked;
            buttons.back.disabled = locked;
            buttons.start.disabled = locked;
        }

        async function request(url, body) {
            const headers = { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' };
            const options = { method: 'POST', headers: headers };

            if (body instanceof FormData) {
                options.body = body;
            } else {
                headers['Content-Type'] = 'application/json';
                options.body = JSON.stringify(body || {});
            }

            const response = await fetch(url, options);
            let data = {};

            try {
                data = await response.json();
            } catch (e) {
                data = {};
            }

            if (!response.ok) {
                const first = data.errors ? Object.values(data.errors)[0][0] : null;
                throw new Error(first || data.message || ('Request failed (' + response.status + ').'));
            }

            return data;
        }

        function renderSummary(summary) {
            const items = [
                ['primary', 'Domains in file', summary.total],
                ['success', 'Will update', summary.update],
                ['secondary', 'No change', summary.unchanged],
                ['danger', 'Not found', summary.not_found],
                ['warning', 'Conflict', summary.conflict],
                ['warning', 'Ambiguous', summary.ambiguous],
                ['danger', 'Invalid', summary.invalid],
                ['secondary', 'No data', summary.no_data]
            ];

            el('import-summary').innerHTML = items.map((item) =>
                '<span class="badge bg-' + item[0] + ' fs-12 p-2">' + esc(item[1]) + ': ' + esc(item[2]) + '</span>'
            ).join('');
        }

        function renderPreview() {
            const filter = el('import-filter').value;
            const rows = state.rows.filter((row) => filter === 'all' || row.status === filter);

            el('import-preview-body').innerHTML = rows.length ? rows.map((row) => {
                const label = previewLabels[row.status] || ['secondary', row.status];

                return '<tr>'
                    + '<td>' + esc(row.lines.join(', ')) + '</td>'
                    + '<td>' + esc(row.domain) + '</td>'
                    + '<td>' + (row.website_id ? '#' + esc(row.website_id) + ' ' + esc(row.site_name || '') : '-') + '</td>'
                    + '<td>' + badge(label) + '</td>'
                    + '<td>' + esc((row.fields || []).join(', ')) + '</td>'
                    + '<td>' + esc(row.note || '') + '</td>'
                    + '</tr>';
            }).join('') : '<tr><td colspan="6" class="text-center text-muted">No rows</td></tr>';
        }

        function renderStats() {
            const count = (status) => state.results.filter((result) => result.status === status).length;

            el('import-progress-stats').innerHTML =
                '<span class="badge bg-success fs-12 p-2">Updated: ' + count('updated') + '</span>'
                + '<span class="badge bg-secondary fs-12 p-2">No change: ' + count('unchanged') + '</span>'
                + '<span class="badge bg-danger fs-12 p-2">Failed: ' + count('failed') + '</span>';
        }

        function appendResults(results) {
            const body = el('import-result-body');

            results.forEach((result) => {
                const label = resultLabels[result.status] || ['secondary', result.status];
                const row = document.createElement('tr');

                row.innerHTML = '<td>' + esc(result.domain) + '</td>'
                    + '<td>#' + esc(result.website_id) + ' ' + esc(result.site_name || '') + '</td>'
                    + '<td>' + badge(label) + '</td>'
                    + '<td>' + esc((result.fields || []).join(', ')) + '</td>'
                    + '<td>' + esc(result.message || '') + '</td>';

                body.appendChild(row);
            });

            body.parentElement.parentElement.scrollTop = body.parentElement.parentElement.scrollHeight;
        }

        function updateProgress(processed, total) {
            const percent = total ? Math.round((processed / total) * 100) : 100;
            const bar = el('import-progress-bar');

            bar.style.width = percent + '%';
            bar.textContent = percent + '%';
            el('import-progress-count').textContent = processed + ' / ' + total;
        }

        async function analyze() {
            const file = el('import-file').files[0];

            showError('');

            if (!file) {
                showError('Choose a file first.');
                return;
            }

            const form = new FormData();
            form.append('file', file);

            buttons.analyze.disabled = true;
            buttons.analyze.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Analyzing...';

            try {
                const data = await request(routes.preview, form);

                state.token = data.token;
                state.rows = data.rows;
                state.results = [];
                state.finished = false;

                renderSummary(data.summary);
                el('import-filter').value = 'all';
                renderPreview();

                buttons.start.disabled = data.summary.update === 0;
                buttons.start.innerHTML = '<i class="fas fa-play"></i> Start Import (' + data.summary.update + ')';

                showStep('preview');
            } catch (error) {
                showError(error.message);
            } finally {
                buttons.analyze.disabled = false;
                buttons.analyze.innerHTML = '<i class="fas fa-search"></i> Analyze File';
            }
        }

        async function startImport() {
            const total = state.rows.filter((row) => row.status === 'update').length;

            const confirmation = await Swal.fire({
                title: 'Update ' + total + ' website(s)?',
                text: 'Credentials will be saved encrypted and verified. Take a database backup first if you have not.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, import'
            });

            if (!confirmation.isConfirmed) {
                return;
            }

            showError('');
            showStep('progress');
            setLocked(true);

            el('import-result-body').innerHTML = '';
            el('import-progress-title').textContent = 'Importing...';

            const bar = el('import-progress-bar');
            bar.className = 'progress-bar progress-bar-striped progress-bar-animated';

            updateProgress(0, total);
            renderStats();

            let offset = 0;

            try {
                while (true) {
                    const data = await request(routes.apply, { token: state.token, offset: offset });

                    state.results = state.results.concat(data.results);
                    appendResults(data.results);
                    updateProgress(data.processed, data.total);
                    renderStats();

                    if (data.done) {
                        break;
                    }

                    offset = data.processed;
                }

                state.finished = true;

                const failed = state.results.filter((result) => result.status === 'failed').length;

                bar.className = 'progress-bar bg-' + (failed ? 'warning' : 'success');
                el('import-progress-title').textContent = failed ? 'Completed with errors' : 'Import completed';

                if (failed) {
                    toastr.warning('Import finished with ' + failed + ' failure(s).');
                } else {
                    toastr.success('Import completed.');
                }
            } catch (error) {
                bar.className = 'progress-bar bg-danger';
                el('import-progress-title').textContent = 'Import stopped';
                showError(error.message);
            } finally {
                setLocked(false);
                buttons.report.classList.remove('d-none');
            }
        }

        function downloadReport() {
            const lines = [['domain', 'website_id', 'site_name', 'status', 'fields', 'message']];

            state.rows.filter((row) => row.status !== 'update').forEach((row) => {
                lines.push([row.domain, row.website_id || '', row.site_name || '', (previewLabels[row.status] || [0, row.status])[1], (row.fields || []).join(' '), row.note || '']);
            });

            state.results.forEach((result) => {
                lines.push([result.domain, result.website_id || '', result.site_name || '', (resultLabels[result.status] || [0, result.status])[1], (result.fields || []).join(' '), result.message || '']);
            });

            const csv = lines.map((line) => line.map((cell) => '"' + String(cell).replace(/"/g, '""') + '"').join(',')).join('\r\n');
            const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');

            link.href = URL.createObjectURL(blob);
            link.download = 'credential-import-report.csv';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(link.href);
        }

        function resetModal() {
            state = { token: null, rows: [], results: [], running: false, finished: false };
            el('import-file').value = '';
            el('import-preview-body').innerHTML = '';
            el('import-result-body').innerHTML = '';
            showError('');
            showStep('upload');
        }

        buttons.analyze.addEventListener('click', analyze);
        buttons.start.addEventListener('click', startImport);
        buttons.report.addEventListener('click', downloadReport);
        buttons.back.addEventListener('click', function () {
            showError('');
            showStep('upload');
        });
        el('import-filter').addEventListener('change', renderPreview);

        modalEl.addEventListener('hidden.bs.modal', function () {
            const ranImport = state.results.length > 0;

            if (state.token && !state.finished) {
                fetch(routes.cancel, {
                    method: 'POST',
                    keepalive: true,
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'Content-Type': 'application/json' },
                    body: JSON.stringify({ token: state.token })
                });
            }

            resetModal();

            if (ranImport) {
                location.reload();
            }
        });
    })();
</script>
@endif

@endpush