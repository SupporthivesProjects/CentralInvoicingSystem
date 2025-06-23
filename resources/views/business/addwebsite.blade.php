@extends('layouts.app')

@section('title', 'Connect New Website | Central Invoice System')

@section('content')

    <div class="page">
    <div class="main-content app-content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Add New Website</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="">Models & Websites</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Website</li>
                    </ol>
                </div>

                <div class="mt-3 mt-md-0">
                    <button type="button" id="check-remote-db" class="btn btn-outline-warning">
                        Check DB Connectivity
                    </button>
                </div>
            </div>
            <div class="col-xl-12">
                <div id="db-status-wrapper" class="text-center mt-3 mb-3">
                    <div id="db-status-message" style="display: none;"></div>
                </div>
            </div>
            <!-- Page Header Close -->
            <!-- Form -->
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                    <form method="POST" id="addwebsite-form" action="{{ route('website.store') }}" enctype="multipart/form-data" class="row g-3 mt-0">
                        @csrf

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Business Model <span style="color:red">*</span></label>
                            <select name="business_model_id" class="form-select" required>
                                <option selected disabled>Choose Business Model</option>
                                @foreach ($businessModels as $model)
                                    <option value="{{ $model->id }}">{{ $model->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Site Name <span style="color:red">*</span></label>
                            <input type="text" name="site_name" class="form-control" required placeholder="Enter Site Name">
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Database Host <span style="color:red">*</span></label>
                            <input type="text" name="db_host" class="form-control" placeholder="Enter Database Host" required>
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Database Port <span style="color:red">*</span></label>
                            <input type="text" name="db_port" class="form-control" placeholder="Enter Database Port" value="3306" required>
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Database Name <span style="color:red">*</span></label>
                            <input type="text" name="db_name" class="form-control" placeholder="Enter Database Name" required>
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Database Username <span style="color:red">*</span></label>
                            <input type="text" name="db_username" class="form-control" placeholder="Enter Database Username" required>
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Database Password <span style="color:red">*</span></label>
                            <input type="text" name="db_password" class="form-control" placeholder="Enter Database Password" required>
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Website Link <span style="color:red">*</span></label>
                            <input type="text" name="site_link" class="form-control" placeholder="Enter Website link">
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Site Description</label>
                            <input type="text" name="site_description" class="form-control" placeholder="Enter Site Description (optional)">
                        </div>

                        <!-- Add the Technology Field Here -->
                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Technology <span style="color:red">*</span></label>
                            <select name="technology" class="form-select" required>
                                <option selected disabled>Choose Technology</option>
                                <option value="wordpress">WordPress</option>
                                <option value="laravel">Laravel</option>
                                <option value="corephp">Core PHP</option>
                            </select>
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Company Name</label>
                            <input type="text" name="company_name" class="form-control" placeholder="Enter Company Name">
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Company Email</label>
                            <input type="email" name="company_email" class="form-control" placeholder="Enter Company Email">
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Company Mobile</label>
                            <input type="text" name="company_mobile" class="form-control" placeholder="Enter Company Mobile">
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Company Address</label>
                            <input type="text" name="company_address" class="form-control" placeholder="Enter Company Address">
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Bank Name</label>
                            <input type="text" name="bank_name" class="form-control" placeholder="Enter Bank Name">
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Bank Code</label>
                            <input type="text" name="bank_code" class="form-control" placeholder="Enter Bank Code (e.g., IFSC or SWIFT)">
                        </div>
                        <div class="my-4">
                            <div class="d-flex align-items-center text-muted">
                                <div class="flex-grow-1 border-bottom"></div>
                                <div class="px-3 fw-semibold">Invoice Template/Images</div>
                                <div class="flex-grow-1 border-bottom"></div>
                            </div>
                        </div>
                        <div class="row mb-1 mt-2">
                                <div class="col-md-6">
                                    <div class="p-4 border border-primary rounded-4 shadow-sm bg-white h-100">
                                        <h6 class="text-primary fw-bold mb-3">
                                            📄 Invoice Template (HTML/HTM/PHP)
                                        </h6>
                                        <input type="file" name="invoice_template" class="form-control" accept=".html,.htm,.php">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="p-4 border border-primary rounded-4 shadow-sm bg-white h-100">
                                        <h6 class="text-primary fw-bold mb-3">
                                            ✍️ Invoice Signature (Image)
                                        </h6>
                                        <input type="file" name="invoice_signature" class="form-control image-input" accept=".jpeg,.png,.jpg">
                                        <div class="file-info mt-2 d-none">
                                            <small class="text-muted d-flex align-items-center gap-2">
                                                <span class="hover-preview-link file-name text-muted" style="cursor: pointer;"></span>
                                                <button type="button" class="btn btn-sm text-danger p-0 remove-file-btn" title="Remove">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </small>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                         
                            <div class="col">
                                <div class="p-3 border rounded-3 shadow-sm bg-white">
                                    <label class="form-label fw-semibold text-dark">Company Logo</label>
                                    <input type="file" name="company_logo" class="form-control image-input" accept=".jpeg,.png,.jpg">
                                    <div class="file-info mt-2 d-none">
                                        <small class="text-muted d-flex align-items-center gap-2">
                                            <span class="hover-preview-link file-name text-muted" style="cursor: pointer;"></span>
                                            <button type="button" class="btn btn-sm text-danger p-0 remove-file-btn" title="Remove">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </small>
                                    </div>

                                </div>
                            </div>

                            <div class="col">
                                <div class="p-3 border rounded-3 shadow-sm bg-white">
                                    <label class="form-label fw-semibold text-dark">Invoice Header Image</label>
                                    <input type="file" name="invoice_header_image" class="form-control image-input" accept=".jpeg,.png,.jpg">
                                    <div class="file-info mt-2 d-none">
                                        <small class="text-muted d-flex align-items-center gap-2">
                                            <span class="hover-preview-link file-name text-muted" style="cursor: pointer;"></span>
                                            <button type="button" class="btn btn-sm text-danger p-0 remove-file-btn" title="Remove">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </small>
                                    </div>

                                </div>
                            </div>

                            <div class="col">
                                <div class="p-3 border rounded-3 shadow-sm bg-white">
                                    <label class="form-label fw-semibold text-dark">Invoice Footer Image</label>
                                    <input type="file" name="invoice_footer_image" class="form-control image-input" accept=".jpeg,.png,.jpg">
                                    <div class="file-info mt-2 d-none">
                                        <small class="text-muted d-flex align-items-center gap-2">
                                            <span class="hover-preview-link file-name text-muted" style="cursor: pointer;"></span>
                                            <button type="button" class="btn btn-sm text-danger p-0 remove-file-btn" title="Remove">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </small>
                                    </div>

                                </div>
                            </div>
                            <div class="col">
                                <div class="p-3 border rounded-3 shadow-sm bg-white">
                                    <label class="form-label fw-semibold text-dark">Invoice Image 1</label>
                                    <input type="file" name="invoice_image1" class="form-control image-input" accept=".jpeg,.png,.jpg">
                                    <div class="file-info mt-2 d-none">
                                        <small class="text-muted d-flex align-items-center gap-2">
                                            <span class="hover-preview-link file-name text-muted" style="cursor: pointer;"></span>
                                            <button type="button" class="btn btn-sm text-danger p-0 remove-file-btn" title="Remove">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </small>
                                    </div>

                                </div>
                            </div>

                            <div class="col">
                                <div class="p-3 border rounded-3 shadow-sm bg-white">
                                    <label class="form-label fw-semibold text-dark">Invoice Image 2</label>
                                    <input type="file" name="invoice_image2" class="form-control image-input" accept=".jpeg,.png,.jpg">
                                    <div class="file-info mt-2 d-none">
                                        <small class="text-muted d-flex align-items-center gap-2">
                                            <span class="hover-preview-link file-name text-muted" style="cursor: pointer;"></span>
                                            <button type="button" class="btn btn-sm text-danger p-0 remove-file-btn" title="Remove">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </small>
                                    </div>

                                </div>
                            </div>

                            <div class="col">
                                <div class="p-3 border rounded-3 shadow-sm bg-white">
                                    <label class="form-label fw-semibold text-dark">Invoice Image 3</label>
                                    <input type="file" name="invoice_image3" class="form-control image-input" accept=".jpeg,.png,.jpg">
                                    <div class="file-info mt-2 d-none">
                                        <small class="text-muted d-flex align-items-center gap-2">
                                            <span class="hover-preview-link file-name text-muted" style="cursor: pointer;"></span>
                                            <button type="button" class="btn btn-sm text-danger p-0 remove-file-btn" title="Remove">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </small>
                                    </div>

                                </div>
                            </div>

                            <div class="col">
                                <div class="p-3 border rounded-3 shadow-sm bg-white">
                                    <label class="form-label fw-semibold text-dark">Invoice Image 4</label>
                                    <input type="file" name="invoice_image4" class="form-control image-input" accept=".jpeg,.png,.jpg">
                                    <div class="file-info mt-2 d-none">
                                        <small class="text-muted d-flex align-items-center gap-2">
                                            <span class="hover-preview-link file-name text-muted" style="cursor: pointer;"></span>
                                            <button type="button" class="btn btn-sm text-danger p-0 remove-file-btn" title="Remove">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </small>
                                    </div>

                                </div>
                            </div>

                            <div class="col">
                                <div class="p-3 border rounded-3 shadow-sm bg-white">
                                    <label class="form-label fw-semibold text-dark">Invoice Image 5</label>
                                    <input type="file" name="invoice_image5" class="form-control image-input" accept=".jpeg,.png,.jpg">
                                    <div class="file-info mt-2 d-none">
                                        <small class="text-muted d-flex align-items-center gap-2">
                                            <span class="hover-preview-link file-name text-muted" style="cursor: pointer;"></span>
                                            <button type="button" class="btn btn-sm text-danger p-0 remove-file-btn" title="Remove">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </small>
                                    </div>

                                </div>
                            </div>

                            <div class="col">
                                <div class="p-3 border rounded-3 shadow-sm bg-white">
                                    <label class="form-label fw-semibold text-dark">Invoice Image 6</label>
                                    <input type="file" name="invoice_image6" class="form-control image-input" accept=".jpeg,.png,.jpg">
                                    <div class="file-info mt-2 d-none">
                                        <small class="text-muted d-flex align-items-center gap-2">
                                            <span class="hover-preview-link file-name text-muted" style="cursor: pointer;"></span>
                                            <button type="button" class="btn btn-sm text-danger p-0 remove-file-btn" title="Remove">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </small>
                                    </div>

                                </div>
                            </div>

                            <div class="col">
                                <div class="p-3 border rounded-3 shadow-sm bg-white">
                                    <label class="form-label fw-semibold text-dark">Invoice Image 7</label>
                                    <input type="file" name="invoice_image7" class="form-control image-input" accept=".jpeg,.png,.jpg">
                                    <div class="file-info mt-2 d-none">
                                        <small class="text-muted d-flex align-items-center gap-2">
                                            <span class="hover-preview-link file-name text-muted" style="cursor: pointer;"></span>
                                            <button type="button" class="btn btn-sm text-danger p-0 remove-file-btn" title="Remove">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </small>
                                    </div>

                                </div>
                            </div>

                            <div class="col">
                                <div class="p-3 border rounded-3 shadow-sm bg-white">
                                    <label class="form-label fw-semibold text-dark">Invoice Image 8</label>
                                    <input type="file" name="invoice_image8" class="form-control image-input" accept=".jpeg,.png,.jpg">
                                    <div class="file-info mt-2 d-none">
                                        <small class="text-muted d-flex align-items-center gap-2">
                                            <span class="hover-preview-link file-name text-muted" style="cursor: pointer;"></span>
                                            <button type="button" class="btn btn-sm text-danger p-0 remove-file-btn" title="Remove">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </small>
                                    </div>

                                </div>
                            </div>

                            <div class="col">
                                <div class="p-3 border rounded-3 shadow-sm bg-white">
                                    <label class="form-label fw-semibold text-dark">Invoice Image 9</label>
                                    <input type="file" name="invoice_image9" class="form-control image-input" accept=".jpeg,.png,.jpg">
                                    <div class="file-info mt-2 d-none">
                                        <small class="text-muted d-flex align-items-center gap-2">
                                            <span class="hover-preview-link file-name text-muted" style="cursor: pointer;"></span>
                                            <button type="button" class="btn btn-sm text-danger p-0 remove-file-btn" title="Remove">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </small>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary mt-2">Add Website</button>
                        </div>
                    </form>

                    </div>
                    <div class="card-footer d-none border-top-0"></div>
                </div>
            </div>

        </div>
    </div>
    <div id="hoverPreviewBox" style="display: none;position: fixed;z-index: 9999;background: #fff;padding: 8px;border-radius: 8px;box-shadow: 0 0 10px rgba(0,0,0,0.3);max-width: 300px;max-height: 300px; pointer-events: none;">
        <img id="hoverPreviewImage" src="" alt="Preview" style="max-width: 100%; max-height: 250px;">
    </div>

@endsection
@push('scripts')
<script>
    document.getElementById('addwebsite-form').addEventListener('submit', function () {
        Swal.fire({
            title: 'Adding New Website...',
            html: `
                <div class="d-flex flex-column align-items-center">
                     <div class="loaderBar"></div>
                    <small class="mt-3 fs-6">Hold tight! Your new website is being added right now.</small>
                </div>
            `,
            showConfirmButton: false,
            allowOutsideClick: false
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#check-remote-db').click(function () {
            $('#db-status-message')
                .html(`<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span><span>Establishing connection...</span>`)
                .css('color', '#6c757d')
                .fadeIn(300);
            $('.field-error').remove();

            var db_host = $('#db_host').val();
            var db_port = $('#db_port').val();
            var db_name = $('#db_name').val();
            var db_username = $('#db_username').val();
            var db_password = $('#db_password').val();

           if(!db_host){
                $('#db-status-message').html('<span class="field-error text-danger">Database Host is required</span>').fadeOut(1000);
                return;
            }
            if(!db_port){
                $('#db-status-message').html('<span class="field-error text-danger">Database Port is required</span>').fadeOut(1000);
                return;
            }
            if(!db_name){
                $('#db-status-message').html('<span class="field-error text-danger">Database Name is required</span>').fadeOut(1000);
                return;
            }
            if(!db_username){
                $('#db-status-message').html('<span class="field-error text-danger">Database Username is required</span>').fadeOut(1000);
                return;
            }
            if(!db_password){
                $('#db-status-message').html('<span class="field-error text-danger">Database Password is required</span>').fadeOut(1000);
                return;
            }

            $.ajax({
                url: "{{ route('check.db.connectivity') }}",
                type: 'POST',
                data: {
                    db_host: db_host,
                    db_port: db_port,
                    db_name: db_name,
                    db_username: db_username,
                    db_password: db_password,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        $('#db-status-message').html(`
                            <div class="checkmark-wrapper">
                                <div class="checkmark-circle">
                                    <div class="checkmark"></div>
                                </div>
                                <div>Connection successful!</div>
                            </div>
                        `).fadeIn(500);
                    } else {
                        $('#db-status-message').html('<span class="text-danger">' + response.message + '</span>');
                    }
                    setTimeout(function () {
                        $('#db-status-message').fadeOut(500);
                    }, 5000);
                },
                error: function () {
                    $('#db-status-message').html('<span class="text-danger">Error occurred while connecting to the DB.</span>');
                    setTimeout(function () {
                        $('#db-status-message').fadeOut(500);
                    }, 5000);
                }
            });
        });
    });
</script>
<script>
$(document).ready(function () {
    const offsetX = 30, offsetY = 20;

    $('.image-input').on('change', function () {
        const file = this.files[0];
        const reader = new FileReader();
        const $wrapper = $(this).siblings('.file-info');

        if (file && file.type.startsWith('image/')) {
            reader.onload = function (e) {
                const $link = $wrapper.find('.hover-preview-link');
                $link.text(file.name).attr('href', e.target.result).data('img', e.target.result);
                $wrapper.removeClass('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    $(document).on('mouseenter', '.hover-preview-link', function () {
        $('#hoverPreviewImage').attr('src', $(this).data('img'));
        $('#hoverPreviewBox').fadeIn(150);
    }).on('mousemove', '.hover-preview-link', function (e) {
        $('#hoverPreviewBox').css({ top: e.clientY + offsetY + 'px', left: e.clientX + offsetX + 'px' });
    }).on('mouseleave', '.hover-preview-link', function () {
        $('#hoverPreviewBox').fadeOut(100);
    });

    $(document).on('click', '.remove-file-btn', function () {
        const $wrapper = $(this).closest('.file-info');
        const $input = $wrapper.siblings('.image-input');
        $input.val('');
        $wrapper.addClass('d-none');
    });
});
</script>


@endpush