<x-layout>
    <div class="container">
        <h1>Tenant Details</h1>

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $tenant->name }}</h5>
                <p class="card-text"><strong>ID Number:</strong> {{ $tenant->id_number }}</p>
                <p class="card-text"><strong>Phone:</strong> {{ $tenant->phone }}</p>
                <p class="card-text"><strong>Email:</strong> {{ $tenant->email }}</p>
                <p class="card-text"><strong>Address:</strong> {{ $tenant->address }}</p>
                <p class="card-text"><strong>Document Type:</strong> {{ $tenant->document_type }}</p>
                <p class="card-text"><strong>Father's Name:</strong> {{ $tenant->father_name }}</p>
                <p class="card-text"><strong>Mother's Name:</strong> {{ $tenant->mother_name }}</p>
                <p class="card-text"><strong>Spouse's Name:</strong> {{ $tenant->spouse_name }}</p>
                <p class="card-text"><strong>Document:</strong></p>
                <a href="{{ $tenant->document_path }}" target="_blank">View Document</a>
            </div>
        </div>

        <a href="{{ route('tenant.index') }}" class="btn btn-secondary">Back to Tenants</a>
    </div>
</x-layout>
