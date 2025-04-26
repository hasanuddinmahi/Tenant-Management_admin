<x-layout>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <h2 class="mb-4 fw-bold text-primary">Add Tenant</h2>

                {{-- File Upload Section --}}
                <div class="card shadow-sm mb-5">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Upload Tenant File</h5>
                        <form id="uploadForm" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="document_type" class="form-label">Select Document Type</label>
                                <select class="form-select" id="document_type" required>
                                    <option value="" disabled selected>Select type</option>
                                    <option value="nid">NID</option>
                                    <option value="passport">Passport</option>
                                </select>
                            </div>
                            <!-- Hidden input to store the document type -->
                            <input type="hidden" id="document_type_hidden" name="document_type_hidden">

                            <div class="mb-3">
                                <input type="file" class="form-control" id="tenant_file" accept=".jpg,.jpeg,.png,.pdf" required>
                            </div>
                        </form>
                    </div>
                </div>


                {{-- Tenant Form Section --}}
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Tenant Information</h5>
                        <form action="/addtenant" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="document_type" id="document_type_hidden">
                            <input type="hidden" name="tenant_file_base64" id="tenant_file_base64">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="id_number" class="form-label">ID Number</label>
                                    <input type="text" class="form-control" id="id_number" name="id_number" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone">
                                </div>
                                <div class="col-md-6">
                                    <label for="father_name" class="form-label">Father's Name</label>
                                    <input type="text" class="form-control" id="father_name" name="father_name">
                                </div>
                                <div class="col-md-6">
                                    <label for="mother_name" class="form-label">Mother's Name</label>
                                    <input type="text" class="form-control" id="mother_name" name="mother_name">
                                </div>
                                <div class="col-md-6">
                                    <label for="spouse_name" class="form-label">Spouse Name</label>
                                    <input type="text" class="form-control" id="spouse_name" name="spouse_name">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                                <div class="col-12">
                                    <label for="address" class="form-label">Permanent Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="2"></textarea>
                                </div>
                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary w-100">Add Tenant</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

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
                    <button type="button" id="confirmUpload" class="btn btn-primary">Upload & Autofill</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Styles for preview --}}
    <style>
        #filePreview canvas, #filePreview img {
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

{{-- Custom Scripts --}}
<script src="{{ asset('js/preview&autofill.js') }}"></script>
