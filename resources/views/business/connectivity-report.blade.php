@extends('layouts.app')

@section('title', 'Website Connectivity Report | Central Invoice System')

@section('content')
    <div class="page">
        <div class="main-content app-content">
            <div class="container-fluid">

                <div class="mb-3 mt-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h2 class="main-content-title fs-24 mb-0">Website Connectivity Report</h2>
                    <div class="d-flex flex-wrap gap-2">
                        <select id="statusFilter" class="form-select form-select-sm" style="width:auto">
                            <option value="">All statuses</option>
                            <option value="ok">ok</option>
                            <option value="network">network</option>
                            <option value="auth">auth</option>
                            <option value="database">database</option>
                            <option value="config">config</option>
                            <option value="error">error</option>
                        </select>
                        <button type="button" id="startBtn" class="btn btn-primary btn-sm"><i class="fas fa-bolt me-1"></i>Check all sites</button>
                        <button type="button" id="downloadBtn" class="btn btn-success btn-sm" disabled><i class="fas fa-download me-1"></i>Download CSV</button>
                    </div>
                </div>

                <div class="card custom-card mb-3">
                    <div class="card-body">
                        <div class="progress mb-3" style="height:8px">
                            <div id="progressBar" class="progress-bar" style="width:0%"></div>
                        </div>
                        <div id="summary" class="d-flex flex-wrap gap-2 small"></div>
                    </div>
                </div>

                <div class="card custom-card">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-sm align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Site</th>
                                    <th>Host:Port</th>
                                    <th>Status</th>
                                    <th>Error</th>
                                    <th>Likely cause</th>
                                    <th>ms</th>
                                </tr>
                            </thead>
                            <tbody id="resultBody">
                                <tr><td colspan="7" class="text-muted text-center">Click "Check all sites" to start.</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    (function () {
        var urls = {
            sites: "{{ route('connectivity.report.sites') }}",
            check: "{{ route('connectivity.report.check') }}"
        };
        var token = "{{ csrf_token() }}";
        var CHUNK = 40;
        var CONCURRENCY = 5;
        var badge = {ok: 'success', network: 'danger', auth: 'warning', database: 'warning', config: 'secondary', error: 'dark'};
        var rows = [];
        var running = false;

        var body = document.getElementById('resultBody');
        var startBtn = document.getElementById('startBtn');
        var downloadBtn = document.getElementById('downloadBtn');
        var filter = document.getElementById('statusFilter');
        var bar = document.getElementById('progressBar');
        var summary = document.getElementById('summary');

        function cell(text) {
            var td = document.createElement('td');
            td.textContent = text === null || text === undefined ? '' : text;
            return td;
        }

        function render() {
            var sorted = rows.slice().sort(function (a, b) { return a.id - b.id; });
            var wanted = filter.value;
            body.innerHTML = '';

            sorted.forEach(function (row) {
                if (wanted && row.status !== wanted) {
                    return;
                }

                var tr = document.createElement('tr');
                var statusCell = document.createElement('td');
                var span = document.createElement('span');
                span.className = 'badge bg-' + (badge[row.status] || 'dark');
                span.textContent = row.status;
                statusCell.appendChild(span);

                tr.appendChild(cell(row.id));
                tr.appendChild(cell(row.site_name));
                tr.appendChild(cell(row.host ? row.host + ':' + row.port : ''));
                tr.appendChild(statusCell);
                tr.appendChild(cell((row.code ? '[' + row.code + '] ' : '') + row.message));
                tr.appendChild(cell(row.hint));
                tr.appendChild(cell(row.ms));
                body.appendChild(tr);
            });

            var counts = {};
            rows.forEach(function (row) { counts[row.status] = (counts[row.status] || 0) + 1; });
            summary.innerHTML = '';

            var total = document.createElement('span');
            total.className = 'badge bg-light text-dark border';
            total.textContent = 'Checked: ' + rows.length;
            summary.appendChild(total);

            Object.keys(counts).forEach(function (key) {
                var item = document.createElement('span');
                item.className = 'badge bg-' + (badge[key] || 'dark');
                item.textContent = key + ': ' + counts[key];
                summary.appendChild(item);
            });
        }

        function post(ids) {
            return fetch(urls.check, {
                method: 'POST',
                headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': token},
                body: JSON.stringify({ids: ids})
            }).then(function (response) {
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status);
                }
                return response.json();
            });
        }

        function run() {
            if (running) {
                return;
            }

            running = true;
            rows = [];
            startBtn.disabled = true;
            downloadBtn.disabled = true;
            bar.style.width = '0%';
            body.innerHTML = '<tr><td colspan="7" class="text-muted text-center">Checking...</td></tr>';

            fetch(urls.sites, {headers: {'Accept': 'application/json'}})
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('HTTP ' + response.status);
                    }
                    return response.json();
                })
                .then(function (list) {
                    var names = {};
                    list.forEach(function (site) { names[site.id] = site.name; });

                    var chunks = [];
                    for (var i = 0; i < list.length; i += CHUNK) {
                        chunks.push(list.slice(i, i + CHUNK).map(function (site) { return site.id; }));
                    }

                    var next = 0;
                    var done = 0;

                    function worker() {
                        if (next >= chunks.length) {
                            return Promise.resolve();
                        }

                        var chunk = chunks[next++];

                        return post(chunk)
                            .then(function (data) {
                                rows = rows.concat(data.results);
                            })
                            .catch(function (error) {
                                rows = rows.concat(chunk.map(function (id) {
                                    return {id: id, site_name: names[id], host: '', port: '', status: 'error', code: '', message: 'Check request failed: ' + error.message, hint: 'See the Laravel log and PHP timeout settings', ms: 0};
                                }));
                            })
                            .then(function () {
                                done += chunk.length;
                                bar.style.width = Math.round(done / list.length * 100) + '%';
                                render();
                                return worker();
                            });
                    }

                    var pool = [];
                    for (var w = 0; w < CONCURRENCY; w++) {
                        pool.push(worker());
                    }

                    return Promise.all(pool);
                })
                .catch(function (error) {
                    body.innerHTML = '';
                    var tr = document.createElement('tr');
                    var td = cell('Could not load the site list: ' + error.message);
                    td.colSpan = 7;
                    td.className = 'text-danger text-center';
                    tr.appendChild(td);
                    body.appendChild(tr);
                })
                .then(function () {
                    running = false;
                    startBtn.disabled = false;
                    downloadBtn.disabled = rows.length === 0;
                    render();
                });
        }

        function csvValue(value) {
            var text = value === null || value === undefined ? '' : String(value);
            if (/^[=+\-@\t\r]/.test(text)) {
                text = "'" + text;
            }
            return '"' + text.replace(/"/g, '""') + '"';
        }

        function download() {
            var checkedAt = new Date().toISOString().replace('T', ' ').slice(0, 19);
            var lines = [['ID', 'Site', 'Host', 'Port', 'Status', 'Code', 'Error', 'Likely cause', 'Time ms', 'Checked at (UTC)'].map(csvValue).join(',')];

            rows.slice().sort(function (a, b) { return a.id - b.id; }).forEach(function (row) {
                lines.push([row.id, row.site_name, row.host, row.port, row.status, row.code, row.message, row.hint, row.ms, checkedAt].map(csvValue).join(','));
            });

            var blob = new Blob(['\uFEFF' + lines.join('\r\n')], {type: 'text/csv;charset=utf-8;'});
            var link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'website-connectivity-' + checkedAt.replace(/[: ]/g, '-').slice(0, 16) + '.csv';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(link.href);
        }

        startBtn.addEventListener('click', run);
        downloadBtn.addEventListener('click', download);
        filter.addEventListener('change', render);
    })();
</script>
@endpush