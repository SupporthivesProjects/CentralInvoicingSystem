@extends('layouts.app')

@section('title', 'Edit Website | Central Invoice System')

@section('content')

    @php
        $saved = fn ($field) => filled($website->getRawOriginal($field));
    @endphp

    <div class="page">
    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Edit Website</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="">Models & Websites</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Website</li>
                    </ol>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-2 mt-3">
                    <div>
                        <select class="form-select form-select-sm site-status-selector" form="editwebsite-form" name="site_status" data-id="{{ $website->id }}" data-current="{{ $website->site_status }}">
                            <option value="live" {{ $website->site_status == 'live' ? 'selected' : '' }}>Website Live</option>
                            <option value="tdown" {{ $website->site_status == 'tdown' ? 'selected' : '' }}>Temporary Down</option>
                            <option value="pdown" {{ $website->site_status == 'pdown' ? 'selected' : '' }}>Permanent Down</option>
                        </select>
                    </div>
                    <div>
                        <button type="button" id="check-remote-db" class="btn btn-outline-warning btn-sm w-100">Check DB Connectivity</button>
                    </div>
                    <div>
                        <a href="{{ route('site.connect.db', $website->id) }}" class="btn btn-outline-success btn-sm w-100">Generate Invoice</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div id="db-status-wrapper" class="text-center mt-3 mb-3">
                    <div id="db-status-message" style="display: none;"></div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <form id="editwebsite-form" method="POST" action="{{ route('website.update', $website->id) }}" enctype="multipart/form-data" class="row g-3 mt-0" autocomplete="off">
                            @csrf
                            @method('PATCH')

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Business Model <span style="color:red">*</span></label>
                                <select name="business_model_id" class="form-select" required>
                                    <option disabled {{ old('business_model_id', $website->business_model_id) ? '' : 'selected' }}>Choose Business Model</option>
                                    @foreach ($businessModels as $model)
                                        <option value="{{ $model->id }}" {{ old('business_model_id', $website->business_model_id) == $model->id ? 'selected' : '' }}>{{ $model->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Technology Stack <span style="color:red">*</span></label>
                                <select name="technology" class="form-select" required>
                                    <option value="wordpress" {{ $website->technology == 'wordpress' ? 'selected' : '' }}>WordPress</option>
                                    <option value="laravel" {{ $website->technology == 'laravel' ? 'selected' : '' }}>Laravel</option>
                                    <option value="corephp" {{ $website->technology == 'corephp' ? 'selected' : '' }}>Core PHP</option>
                                </select>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Database Host @if($saved('db_host'))<span class="badge bg-success ms-1">Saved</span>@else<span style="color:red">*</span>@endif</label>
                                <input type="text" name="db_host" id="db_host" class="form-control" autocomplete="off" data-saved="{{ $saved('db_host') ? '1' : '0' }}" placeholder="{{ $saved('db_host') ? '•••••••• Saved – leave blank to keep current' : 'Enter Database Host' }}" {{ $saved('db_host') ? '' : 'required' }}>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Database Port @if($saved('db_port'))<span class="badge bg-success ms-1">Saved</span>@else<span style="color:red">*</span>@endif</label>
                                <input type="text" name="db_port" id="db_port" class="form-control" autocomplete="off" data-saved="{{ $saved('db_port') ? '1' : '0' }}" placeholder="{{ $saved('db_port') ? '•••••••• Saved – leave blank to keep current' : 'Enter Database Port' }}" {{ $saved('db_port') ? '' : 'required' }}>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Database Name @if($saved('db_name'))<span class="badge bg-success ms-1">Saved</span>@else<span style="color:red">*</span>@endif</label>
                                <input type="text" name="db_name" id="db_name" class="form-control" autocomplete="off" data-saved="{{ $saved('db_name') ? '1' : '0' }}" placeholder="{{ $saved('db_name') ? '•••••••• Saved – leave blank to keep current' : 'Enter Database Name' }}" {{ $saved('db_name') ? '' : 'required' }}>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Database Username @if($saved('db_username'))<span class="badge bg-success ms-1">Saved</span>@else<span style="color:red">*</span>@endif</label>
                                <input type="text" name="db_username" id="db_username" class="form-control" autocomplete="off" readonly onfocus="this.removeAttribute('readonly')" data-saved="{{ $saved('db_username') ? '1' : '0' }}" placeholder="{{ $saved('db_username') ? '•••••••• Saved – leave blank to keep current' : 'Enter Database Username' }}" {{ $saved('db_username') ? '' : 'required' }}>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Database Password @if($saved('db_password'))<span class="badge bg-success ms-1">Saved</span>@else<span style="color:red">*</span>@endif</label>
                                <input type="password" name="db_password" id="db_password" class="form-control" autocomplete="new-password" readonly onfocus="this.removeAttribute('readonly')" data-saved="{{ $saved('db_password') ? '1' : '0' }}" placeholder="{{ $saved('db_password') ? '•••••••• Saved – leave blank to keep current' : 'Enter Database Password' }}" {{ $saved('db_password') ? '' : 'required' }}>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Website Link <span style="color:red">*</span></label>
                                <input type="text" name="site_link" class="form-control" placeholder="Enter Website link" value="{{ old('site_link', $website->site_link) }}" required>
                            </div>

                            @if(isset($website->businessModel) && strtolower($website->businessModel->model_type) == 'translation')
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header py-3" style="background: linear-gradient(135deg, #0d6efd15, #0dcaf015); border-left: 4px solid #0d6efd;">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:#0d6efd20;">
                                                <i class="bi bi-translate text-primary fs-5"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold text-primary">Translation Business Settings</h6>
                                                <small class="text-muted">Configure URLs and urgent delivery pricing for this translation site</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-4">

                                        <div class="p-3 rounded-3 mb-4" style="background:#f8f9fa; border: 1px solid #e9ecef;">
                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <i class="bi bi-link-45deg text-secondary fs-5"></i>
                                                <span class="fw-semibold text-secondary">Translation URLs</span>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Standard Translation URL</label>
                                                    <input type="text" name="std_trans_url" class="form-control" placeholder="request-translation" value="{{ old('std_trans_url', $website->std_trans_url ?? '') }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Certified Translation URL</label>
                                                    <input type="text" name="cert_trans_url" class="form-control" placeholder="request-translation?ref=certified" value="{{ old('cert_trans_url', $website->cert_trans_url ?? '') }}">
                                                </div>
                                            </div>
                                        </div>

                                        @if(isset($website->technology) && strtolower($website->technology) === 'laravel')
                                        <div class="p-3 rounded-3 mb-4" style="background: linear-gradient(135deg, #e8f4fd, #f0f9ff); border: 1px solid #b8daff;">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:#0d6efd20;">
                                                        <i class="bi bi-lightning-charge-fill text-primary fs-6"></i>
                                                    </div>
                                                    <div>
                                                        <span class="fw-semibold text-primary">Urgency Flat Fee</span>
                                                        <div><small class="text-muted">Fixed add-on price per product for urgent 2-3 day delivery on invoices</small></div>
                                                    </div>
                                                </div>
                                                <span class="badge bg-warning text-dark" style="font-size:11px;">Laravel - Leave empty to disable urgency</span>
                                            </div>
                                            <div class="row g-3 align-items-center">
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-dark mb-1" style="font-size:13px;">
                                                        <i class="bi bi-alarm-fill text-primary me-1"></i> Urgent 2-3 Days – Flat Fee
                                                    </label>
                                                    <div class="input-group shadow-sm">
                                                        <span class="input-group-text bg-primary text-white">{{ get_site_currency_by_id($website->id) }}</span>
                                                        <input type="number" name="urgency_amount" class="form-control fw-semibold" placeholder="e.g. 35.00" min="0" step="0.0001" value="{{ old('urgency_amount', $website->urgency_amount ?? '') }}">
                                                        <span class="input-group-text bg-light text-muted" style="font-size:11px;">per product</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="row g-2 ps-2">
                                                        <div class="col-4">
                                                            <div class="rounded-3 p-2 text-center h-100" style="background:#fff;border:1px solid #b8daff;">
                                                                <i class="bi bi-plus-circle-fill text-primary mb-1 d-block fs-5"></i>
                                                                <div class="fw-semibold text-dark" style="font-size:12px;">Added to Product Price</div>
                                                                <small class="text-muted" style="font-size:11px;">Fee stacks on top of the base unit price</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="rounded-3 p-2 text-center h-100" style="background:#fff;border:1px solid #b8daff;">
                                                                <i class="bi bi-magic text-primary mb-1 d-block fs-5"></i>
                                                                <div class="fw-semibold text-dark" style="font-size:12px;">Auto-Suggested</div>
                                                                <small class="text-muted" style="font-size:11px;">System suggests urgent when gap matches this fee</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="rounded-3 p-2 text-center h-100" style="background:#fff;border:1px solid #b8daff;">
                                                                <i class="bi bi-toggle-off text-primary mb-1 d-block fs-5"></i>
                                                                <div class="fw-semibold text-dark" style="font-size:12px;">Optional Toggle</div>
                                                                <small class="text-muted" style="font-size:11px;">Leave empty to hide urgency from invoice builder</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if(isset($website->technology) && strtolower($website->technology) === 'wordpress')
                                        <div class="p-3 rounded-3" style="background:#fff8f0; border: 1px solid #fde8cc;">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-clock-history text-warning fs-5"></i>
                                                    <span class="fw-semibold text-warning-emphasis">Urgent Delivery Add-On Pricing</span>
                                                </div>
                                                <span class="badge bg-warning text-dark" style="font-size:11px;">WordPress - Leave empty to disable urgency</span>
                                            </div>

                                            <div class="mb-4">
                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    <span class="badge rounded-pill" style="background:#e3f0ff;color:#0d6efd;font-size:11px;">📄 Per Page</span>
                                                    <small class="text-muted">Fee added per page based on delivery time</small>
                                                </div>
                                                <div class="row g-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold text-dark" style="font-size:13px;">
                                                            <i class="bi bi-hourglass-split text-primary me-1"></i> 12 Hour – Per Page
                                                        </label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light text-muted">{{ get_site_currency_by_id($website->id) }}</span>
                                                            <input type="number" name="urgency_12h_per_page" class="form-control" placeholder="0.0000" min="0" step="0.0001" value="{{ old('urgency_12h_per_page', $website->urgency_12h_per_page ?? '') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold text-dark" style="font-size:13px;">
                                                            <i class="bi bi-hourglass-split text-warning me-1"></i> 24 Hour – Per Page
                                                        </label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light text-muted">{{ get_site_currency_by_id($website->id) }}</span>
                                                            <input type="number" name="urgency_24h_per_page" class="form-control" placeholder="0.0000" min="0" step="0.0001" value="{{ old('urgency_24h_per_page', $website->urgency_24h_per_page ?? '') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold text-dark" style="font-size:13px;">
                                                            <i class="bi bi-hourglass-bottom text-success me-1"></i> 36-48 Hour – Per Page
                                                        </label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light text-muted">{{ get_site_currency_by_id($website->id) }}</span>
                                                            <input type="number" name="urgency_36_48h_per_page" class="form-control" placeholder="0.0000" min="0" step="0.0001" value="{{ old('urgency_36_48h_per_page', $website->urgency_36_48h_per_page ?? '') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    <span class="badge rounded-pill" style="background:#e8f5e9;color:#198754;font-size:11px;">🔤 Per Word</span>
                                                    <small class="text-muted">Fee added per word based on delivery time</small>
                                                </div>
                                                <div class="row g-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold text-dark" style="font-size:13px;">
                                                            <i class="bi bi-hourglass-split text-primary me-1"></i> 12 Hour – Per Word
                                                        </label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light text-muted">{{ get_site_currency_by_id($website->id) }}</span>
                                                            <input type="number" name="urgency_12h_per_word" class="form-control" placeholder="0.0000" min="0" step="0.0001" value="{{ old('urgency_12h_per_word', $website->urgency_12h_per_word ?? '') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold text-dark" style="font-size:13px;">
                                                            <i class="bi bi-hourglass-split text-warning me-1"></i> 24 Hour – Per Word
                                                        </label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light text-muted">{{ get_site_currency_by_id($website->id) }}</span>
                                                            <input type="number" name="urgency_24h_per_word" class="form-control" placeholder="0.0000" min="0" step="0.0001" value="{{ old('urgency_24h_per_word', $website->urgency_24h_per_word ?? '') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold text-dark" style="font-size:13px;">
                                                            <i class="bi bi-hourglass-bottom text-success me-1"></i> 36-48 Hour – Per Word
                                                        </label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light text-muted">{{ get_site_currency_by_id($website->id) }}</span>
                                                            <input type="number" name="urgency_36_48h_per_word" class="form-control" placeholder="0.0000" min="0" step="0.0001" value="{{ old('urgency_36_48h_per_word', $website->urgency_36_48h_per_word ?? '') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Site Name <span style="color:red">*</span></label>
                                <input type="text" name="site_name" class="form-control" required placeholder="Enter Site Name" value="{{ old('site_name', $website->site_name) }}">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">PDF Size <span style="color:red">*</span></label>
                                <select name="pdf_size" class="form-select" required>
                                    @php $pdfSize = old('pdf_size', $website->pdf_size ?? 'A4'); @endphp
                                    <option value="A4" {{ $pdfSize === 'A4' ? 'selected' : '' }}>A4</option>
                                    <option value="A5" {{ $pdfSize === 'A5' ? 'selected' : '' }}>A5</option>
                                    <option value="Letter" {{ $pdfSize === 'Letter' ? 'selected' : '' }}>Letter</option>
                                    <option value="Legal" {{ $pdfSize === 'Legal' ? 'selected' : '' }}>Legal</option>
                                </select>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">PDF Orientation <span style="color:red">*</span></label>
                                <select name="pdf_orientation" class="form-select" required>
                                    @php $orientation = old('pdf_orientation', $website->pdf_orientation ?? 'portrait'); @endphp
                                    <option value="portrait" {{ $orientation === 'portrait' ? 'selected' : '' }}>Portrait</option>
                                    <option value="landscape" {{ $orientation === 'landscape' ? 'selected' : '' }}>Landscape</option>
                                </select>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Company Email <span style="color:red">*</span></label>
                                <input type="email" name="company_email" class="form-control" value="{{ old('company_email', $website->company_email) }}" placeholder="Enter Company Email" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Consumer Key for WP site only @if($saved('consumer_key'))<span class="badge bg-success ms-1">Saved</span>@endif</label>
                                <input type="text" name="consumer_key" id="consumer_key" class="form-control" autocomplete="off" readonly onfocus="this.removeAttribute('readonly')" placeholder="{{ $saved('consumer_key') ? '•••••••• Saved – leave blank to keep current' : 'Enter Consumer Key' }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Consumer Secret for WP site only @if($saved('consumer_secret'))<span class="badge bg-success ms-1">Saved</span>@endif</label>
                                <input type="password" name="consumer_secret" id="consumer_secret" class="form-control" autocomplete="new-password" readonly onfocus="this.removeAttribute('readonly')" placeholder="{{ $saved('consumer_secret') ? '•••••••• Saved – leave blank to keep current' : 'Enter Consumer Secret' }}">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Site Description</label>
                                <input type="text" name="site_description" class="form-control" placeholder="Enter Site Description (optional)" value="{{ old('site_description', $website->site_description) }}">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Company Name</label>
                                <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $website->company_name) }}" placeholder="Enter Company Name">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Company Mobile</label>
                                <input type="text" name="company_mobile" class="form-control" value="{{ old('company_mobile', $website->company_mobile) }}" placeholder="Enter Company Mobile">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Bank Name</label>
                                <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name', $website->bank_name) }}" placeholder="Enter Bank Name">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Bank Code</label>
                                <input type="text" name="bank_code" class="form-control" value="{{ old('bank_code', $website->bank_code) }}" placeholder="Enter Bank Code (e.g., IFSC or SWIFT)">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Company Address</label>
                                <input type="text" name="company_address" class="form-control" value="{{ old('company_address', $website->company_address) }}" placeholder="Enter Company Address">
                            </div>

                            <div class="accordion w-100" id="websiteTableAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="tableConfigHeading">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tableConfigCollapse">
                                            Website Table Configuration
                                        </button>
                                    </h2>
                                    <div id="tableConfigCollapse" class="accordion-collapse collapse" data-bs-parent="#websiteTableAccordion">
                                        <div class="accordion-body">
                                            <div class="alert alert-warning mb-4" role="alert" style="font-size: 14px;">
                                                ⚠️ <strong>Important:</strong> Modifying table names can disrupt existing functionality. Only change these values if you are certain of the impact.
                                            </div>
                                            <div class="container-fluid px-0">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Main Product Table <span class="text-danger">*</span></label>
                                                        <input type="text" name="product_table" class="form-control" value="{{ old('product_table', $website->product_table) }}" placeholder="e.g., wp_posts" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Product Pricing Table <span class="text-danger">*</span></label>
                                                        <input type="text" name="product_price_table" class="form-control" value="{{ old('product_price_table', $website->product_price_table) }}" placeholder="e.g., wp_wc_product_meta_lookup" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Currency Settings Table <span class="text-danger">*</span></label>
                                                        <input type="text" name="currency_table" class="form-control" value="{{ old('currency_table', $website->currency_table) }}" placeholder="e.g., wp_options" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Product Category Table <span class="text-danger">*</span></label>
                                                        <input type="text" name="category_table" class="form-control" value="{{ old('category_table', $website->category_table) }}" placeholder="e.g., wp_terms" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Game Bundle Table <span class="text-danger">*</span></label>
                                                        <input type="text" name="bundle_table" class="form-control" value="{{ old('bundle_table', $website->bundle_table) }}" placeholder="e.g., game_sever_based_cost" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Site Settings Table <span class="text-danger">*</span></label>
                                                        <input type="text" name="general_settings" class="form-control" value="{{ old('general_settings', $website->general_settings) }}" placeholder="e.g., general_settings" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Product Tags Table <span class="text-danger">*</span></label>
                                                        <input type="text" name="tags_table" class="form-control" value="{{ old('tags_table', $website->tags_table) }}" placeholder="e.g., wp_term_relationships" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Taxonomy Mapping Table <span class="text-danger">*</span></label>
                                                        <input type="text" name="term_taxonomy_table" class="form-control" value="{{ old('term_taxonomy_table', $website->term_taxonomy_table) }}" placeholder="e.g., wp_term_taxonomy" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="my-4">
                                <div class="d-flex align-items-center text-muted">
                                    <div class="flex-grow-1 border-bottom"></div>
                                    <div class="px-3 fw-semibold">Invoice Template/Images</div>
                                    <div class="flex-grow-1 border-bottom"></div>
                                </div>
                            </div>

                            <div class="row mb-4 mt-2">
                                <div class="col-md-6">
                                    <div class="p-4 border border-primary rounded-4 shadow-sm bg-white h-100">
                                        <h6 class="text-primary fw-bold mb-3">📄 Invoice Template (HTML/HTM/PHP)</h6>
                                        <input type="file" name="invoice_template" class="form-control" accept=".html,.htm,.php">
                                        @if ($website->invoice_template)
                                            <small class="text-muted d-block mt-2">Current: <a href="{{ asset($website->invoice_template) }}" target="_blank" rel="noopener noreferrer">{{ basename($website->invoice_template) }}</a></small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-4 border border-primary rounded-4 shadow-sm bg-white h-100">
                                        <h6 class="text-primary fw-bold mb-3">✍️ Invoice Signature (Image)</h6>
                                        <input type="file" name="invoice_signature" class="form-control" accept=".jpeg,.png,.jpg">
                                        @if ($website->invoice_signature)
                                            <small class="text-muted d-block mt-2">invoice_signature: <a class="hover-preview-link" data-img="{{ asset($website->invoice_signature) }}" href="{{ asset($website->invoice_signature) }}" target="_blank" rel="noopener noreferrer">{{ basename($website->invoice_signature) }}</a></small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="container-fluid">
                                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                                    @foreach(['company_logo' => 'Invoice Logo', 'invoice_header_image' => 'Invoice Header Image', 'invoice_footer_image' => 'Invoice Footer Image', 'invoice_image1' => 'Invoice Image 1', 'invoice_image2' => 'Invoice Image 2', 'invoice_image3' => 'Invoice Image 3', 'invoice_image4' => 'Invoice Image 4', 'invoice_image5' => 'Invoice Image 5', 'invoice_image6' => 'Invoice Image 6', 'invoice_image7' => 'Invoice Image 7', 'invoice_image8' => 'Invoice Image 8', 'invoice_image9' => 'Invoice Image 9'] as $field => $label)
                                    <div class="col">
                                        <div class="p-3 border rounded-3 shadow-sm bg-white">
                                            <label class="form-label fw-semibold text-dark">{{ $label }}</label>
                                            <input type="file" name="{{ $field }}" class="form-control" accept=".jpeg,.png,.jpg">
                                            @if ($website->$field)
                                                <small class="d-block text-muted mt-2">{{ $field }}: <a class="hover-preview-link" data-img="{{ asset($website->$field) }}" href="{{ asset($website->$field) }}" target="_blank" rel="noopener noreferrer">{{ basename($website->$field) }}</a></small>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <br>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary mt-2">Update Website</button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="card-footer d-none border-top-0"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="hoverPreviewBox" style="display: none;position: fixed;z-index: 9999; background: #fff;padding: 8px;border-radius: 8px;box-shadow: 0 0 10px rgba(0,0,0,0.3); max-width: 300px;max-height: 300px;pointer-events: none;">
        <img id="hoverPreviewImage" src="" alt="Preview" style="max-width: 100%; max-height: 250px;">
    </div>

@endsection

@push('scripts')
<script>
    document.getElementById('editwebsite-form').addEventListener('submit', function () {
        Swal.fire({
            title: 'Updating Website...',
            html: `
                <div class="d-flex flex-column align-items-center">
                     <div class="loaderBar"></div>
                    <small class="mt-3 fs-6">Hold tight! Your website details are being updated right now.</small>
                </div>
            `,
            showConfirmButton: false,
            allowOutsideClick: false
        });
    });
</script>

<script>
    $(document).ready(function () {
        const $button = $('#check-remote-db');
        const $message = $('#db-status-message');
        const buttonLabel = $button.html();
        let hideTimer = null;

        const esc = function (value) {
            return $('<div>').text(value === null || value === undefined ? '' : String(value)).html();
        };

        const isMissing = function (id) {
            const $field = $('#' + id);
            return !$field.val() && $field.attr('data-saved') !== '1';
        };

        const stageTitles = {
            config: 'Configuration problem',
            network: 'Network problem',
            auth: 'Authentication problem',
            database: 'Database problem',
            error: 'Connection failed'
        };

        const show = function (html, autoHide) {
            clearTimeout(hideTimer);
            $message.stop(true, true).html(html).fadeIn(200);

            if (autoHide) {
                hideTimer = setTimeout(function () {
                    $message.fadeOut(500);
                }, autoHide);
            }
        };

        const showFailure = function (stage, text, details) {
            show(
                '<div class="alert alert-danger d-inline-block text-start mb-0" style="max-width:720px;">'
                + '<div class="fw-semibold mb-1"><i class="fas fa-times-circle me-1"></i>' + esc(stageTitles[stage] || stageTitles.error) + '</div>'
                + '<div>' + esc(text) + '</div>'
                + (details ? '<div class="small text-muted mt-2">' + esc(details) + '</div>' : '')
                + '</div>'
            );
        };

        const showSuccess = function (text, details) {
            show(
                '<div class="checkmark-wrapper">'
                + '<div class="checkmark-circle"><div class="checkmark"></div></div>'
                + '<div>' + esc(text) + '</div>'
                + (details ? '<div class="small text-muted mt-1">' + esc(details) + '</div>' : '')
                + '</div>',
                8000
            );
        };

        const describe = function (response) {
            const parts = [];

            if (response.target) {
                parts.push('Target: ' + response.target);
            }

            if (response.elapsed_ms !== undefined && response.elapsed_ms !== null) {
                parts.push(response.elapsed_ms + ' ms');
            }

            if (response.client_ip) {
                parts.push('The remote server sees this server as ' + response.client_ip);
            }

            return parts.join('  |  ');
        };

        const requiredFields = [
            ['db_host', 'Database Host'],
            ['db_port', 'Database Port'],
            ['db_name', 'Database Name'],
            ['db_username', 'Database Username'],
            ['db_password', 'Database Password']
        ];

        $button.on('click', function () {
            clearTimeout(hideTimer);

            for (const [id, label] of requiredFields) {
                if (isMissing(id)) {
                    showFailure('config', label + ' is required.');
                    return;
                }
            }

            $button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>Checking...');
            show('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span><span class="text-muted">Testing the network, then the credentials...</span>');

            $.ajax({
                url: "{{ route('check.db.connectivity') }}",
                type: 'POST',
                dataType: 'json',
                timeout: 30000,
                data: {
                    website_id: {{ $website->id }},
                    db_host: $('#db_host').val(),
                    db_port: $('#db_port').val(),
                    db_name: $('#db_name').val(),
                    db_username: $('#db_username').val(),
                    db_password: $('#db_password').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        showSuccess(response.message, describe(response));
                    } else {
                        showFailure(response.stage, response.message, describe(response));
                    }
                },
                error: function (xhr, status) {
                    let text = 'The connectivity check failed unexpectedly.';

                    if (status === 'timeout') {
                        text = 'The check took longer than 30 seconds and was stopped.';
                    } else if (xhr.status === 419) {
                        text = 'Your session expired. Reload the page and try again.';
                    } else if (xhr.status === 403) {
                        text = 'Only developers can run this check.';
                    } else if (xhr.status === 429) {
                        text = 'Too many checks. Wait a minute and try again.';
                    } else if (xhr.status === 422 && xhr.responseJSON) {
                        text = xhr.responseJSON.errors ? Object.values(xhr.responseJSON.errors)[0][0] : (xhr.responseJSON.message || text);
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        text = xhr.responseJSON.message;
                    } else if (xhr.status) {
                        text += ' (HTTP ' + xhr.status + ')';
                    }

                    showFailure('error', text);
                },
                complete: function () {
                    $button.prop('disabled', false).html(buttonLabel);
                }
            });
        });
    });
</script>

<script>
$(document).ready(function () {
    const offsetX = 30;
    const offsetY = 20;

    $('.hover-preview-link').on('mouseenter', function (e) {
        const imgUrl = $(this).data('img');
        $('#hoverPreviewImage').attr('src', imgUrl);
        $('#hoverPreviewBox').fadeIn(150);
    });

    $('.hover-preview-link').on('mousemove', function (e) {
        $('#hoverPreviewBox').css({
            top: e.clientY + offsetY + 'px',
            left: e.clientX + offsetX + 'px'
        });
    });

    $('.hover-preview-link').on('mouseleave', function () {
        $('#hoverPreviewBox').fadeOut(100);
    });
});
</script>

<script>
    $(document).ready(function () {
        $('.site-status-selector').on('change', function () {
            const $this = $(this);
            const siteId = $this.data('id');
            const updateUrl = "{{ route('website.updateStatus.ajax', ':id') }}".replace(':id', siteId);
            const newStatus = $this.val();
            const prevStatus = $this.data('current');

            Swal.fire({
                title: 'Are you sure?',
                text: `Change site status to "${newStatus}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Updating Status...',
                        text: 'Please wait while we update the site status.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => { Swal.showLoading(); }
                    });

                    $.ajax({
                        url: updateUrl,
                        method: 'POST',
                        data: { site_status: newStatus, _token: '{{ csrf_token() }}' },
                        success: function (response) {
                            Swal.close();
                            if (response.success) {
                                toastr.success(response.message);
                                $this.data('current', newStatus);
                            } else {
                                toastr.error(response.message || 'Unexpected response.');
                                $this.val(prevStatus);
                            }
                        },
                        error: function () {
                            Swal.close();
                            toastr.error('Failed to update site status.');
                            $this.val(prevStatus);
                        }
                    });
                } else {
                    $this.val(prevStatus);
                }
            });
        });
    });
</script>
@endpush