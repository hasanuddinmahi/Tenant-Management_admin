<x-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">

                <div class="card shadow rounded-4 border-0">
                    <div class="card-body p-5">

                        <h2 class="text-center fw-bold text-primary mb-5">Tenant Details</h2>

                        {{-- Tabs --}}
                        <ul class="nav nav-pills mb-4 justify-content-center" id="tenantTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="info-tab" data-bs-toggle="pill"
                                    data-bs-target="#info" type="button" role="tab" aria-controls="info"
                                    aria-selected="true">
                                    <i class="fa-solid fa-circle-info"></i> Info
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="document-tab" data-bs-toggle="pill"
                                    data-bs-target="#document" type="button" role="tab" aria-controls="document"
                                    aria-selected="false">
                                    <i class="fa-regular fa-file"></i> Document
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="tenantTabsContent">
                            {{-- Info Tab --}}
                            <div class="tab-pane fade show active" id="info" role="tabpanel"
                                aria-labelledby="info-tab">
                                <div class="row g-4">
                                    @php
                                        $fields = [
                                            'Full Name' => $tenant->name,
                                            'ID Number' => $tenant->id_number,
                                            'Phone' => $tenant->phone,
                                            'Email' => $tenant->email,
                                            'Address' => $tenant->address,
                                            'Document Type' => $tenant->document_type,
                                            'Father\'s Name' => $tenant->father_name,
                                            'Mother\'s Name' => $tenant->mother_name,
                                            'Spouse\'s Name' => $tenant->spouse_name,
                                        ];
                                    @endphp

                                    @foreach ($fields as $label => $value)
                                        <div class="col-sm-{{ in_array($label, ['Address']) ? '12' : '6' }}">
                                            <div class="mb-1 fw-semibold">{{ $label }}:</div>
                                            <div class="text-muted">{{ $value ?: '-' }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Document Tab --}}
                            <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="document-tab">
                                <div class="text-center mt-4">
                                    <div class="mb-3 fw-semibold">Document Preview:</div>

                                    @if (!empty($tenant->document_path))
                                        @php
                                            $extension = strtolower(
                                                pathinfo($tenant->document_path, PATHINFO_EXTENSION),
                                            );
                                        @endphp

                                        @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                                            <img src="{{ asset($tenant->document_path) }}" alt="Tenant Document"
                                                class="img-fluid rounded-3 shadow-sm fade-in"
                                                style="max-height: 500px;">
                                        @elseif ($extension === 'pdf')
                                            <div id="pdfLoader" class="d-flex justify-content-center align-items-center"
                                                style="height: 600px;">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </div>
                                            <iframe id="pdfIframe" src="{{ asset($tenant->document_path) }}"
                                                width="100%" height="600px"
                                                class="border rounded-3 shadow-sm opacity-0"
                                                onload="fadeInPdf()"></iframe>
                                        @else
                                            <p class="text-muted">Document format not supported for preview.</p>
                                        @endif

                                        <div class="mt-3">
                                            <a href="{{ asset($tenant->document_path) }}" target="_blank"
                                                class="btn btn-outline-primary rounded-pill px-4">
                                                <i class="fa-regular fa-file-lines"></i> Open Document in New Tab
                                            </a>
                                        </div>
                                    @else
                                        <p class="text-muted">No document uploaded.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="mt-5">
                            <div class="d-flex flex-column flex-md-row gap-3">
                                <a href="{{ route('tenant.index') }}" class="btn btn-secondary w-100 rounded-pill">
                                    ← Back to Tenants
                                </a>

                                <a href="{{ route('tenant.edit', $tenant->id) }}"
                                    class="btn btn-outline-primary w-100 rounded-pill">
                                    <i class="fa-solid fa-pen"></i> Edit Tenant
                                </a>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Fade-in Styles --}}
    <style>
        .fade-in {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }

        #pdfIframe {
            transition: opacity 0.6s ease;
        }
    </style>

    {{-- Scripts --}}
    <script>
        function fadeInPdf() {
            document.getElementById('pdfLoader')?.classList.add('d-none');
            document.getElementById('pdfIframe')?.classList.remove('opacity-0');
        }

        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                document.querySelectorAll('.fade-in').forEach(el => el.classList.add('show'));
            }, 100);
        });
    </script>
</x-layout>
