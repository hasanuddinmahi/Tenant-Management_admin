<x-layout>
    @include('tenant.validation-errors')

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <h2 class="mb-4 fw-bold text-primary">Edit Tenant</h2>

                {{-- Start Form Here --}}
                <form id="uploadForm" action="{{ route('tenant.update', $tenant->id) }}" method="POST"
                    enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    {{-- File Upload Section --}}
                    <div class="card shadow-sm mb-5">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Update Tenant File (Optional)</h5>

                            <div class="mb-3">
                                <input type="file" value="{{ $tenant->document_path }}" class="form-control"
                                    id="tenant_file" name="tenant_file" accept=".jpg,.jpeg,.png,.pdf">
                                <div class="invalid-feedback">
                                    Please upload a valid file (jpg, jpeg, png, pdf).
                                </div>
                                @if ($tenant->document_path)
                                    <div class="mt-2">
                                        <a href="{{ asset($tenant->document_path) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary rounded-pill">
                                            📄 View Stored Document
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <select class="form-select" id="document_type" name="document_type" required>
                                    <option value="" disabled {{ $tenant->document_type ? '' : 'selected' }}>
                                        Select type</option>
                                    <option value="nid" {{ $tenant->document_type === 'nid' ? 'selected' : '' }}>NID
                                    </option>
                                    <option value="passport"
                                        {{ $tenant->document_type === 'passport' ? 'selected' : '' }}>Passport</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a document type.
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tenant Form Section --}}
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Tenant Information</h5>

                            <input type="hidden" name="document_type_hidden" id="document_type_hidden">
                            <input type="hidden" name="tenant_file_base64" id="tenant_file_base64">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $tenant->name }}" required>
                                    <div class="invalid-feedback">
                                        Please enter a full name.
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="id_number" class="form-label">ID Number</label>
                                    <input type="text" class="form-control" id="id_number" name="id_number"
                                        value="{{ $tenant->id_number }}" required>
                                    <div class="invalid-feedback">
                                        Please enter an ID number.
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ $tenant->phone }}" required>
                                    <div class="invalid-feedback">
                                        Please enter a valid phone number.
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="father_name" class="form-label">Father's Name</label>
                                    <input type="text" class="form-control" id="father_name" name="father_name"
                                        value="{{ $tenant->father_name }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="mother_name" class="form-label">Mother's Name</label>
                                    <input type="text" class="form-control" id="mother_name" name="mother_name"
                                        value="{{ $tenant->mother_name }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="spouse_name" class="form-label">Spouse Name</label>
                                    <input type="text" class="form-control" id="spouse_name" name="spouse_name"
                                        value="{{ $tenant->spouse_name }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $tenant->email }}">
                                    <div class="invalid-feedback">
                                        Please enter a valid email address.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="address" class="form-label">Permanent Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="2" required>{{ $tenant->address }}</textarea>
                                    <div class="invalid-feedback">
                                        Please enter a permanent address.
                                    </div>
                                </div>

                                <div class="col-12 mt-3">
                                    <button type="submit" id="updateTenantButton"
                                        class="btn btn-primary w-100">Update Tenant</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form> {{-- End Form --}}
            </div>
        </div>
    </div>

    {{-- Preview Modal --}}
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Document Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="filePreview" class="w-100"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmUpload" class="btn btn-primary">Upload</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Styles for preview --}}
    <style>
        #filePreview canvas,
        #filePreview img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        #filePreview {
            overflow-x: auto;
        }
    </style>
</x-layout>


{{-- Libraries --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pica@9.0.1/dist/pica.min.js"></script>
<script src="{{ asset('js/validation.js') }}"></script>


<script>
    document.getElementById('updateTenantButton').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent form submission

        // SweetAlert2 Confirmation Popup
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to update this tenant?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form if confirmed
                document.getElementById('uploadForm').submit();
            }
        });
    });
</script>
