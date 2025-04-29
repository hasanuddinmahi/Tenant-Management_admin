<x-layout>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Tenant Table</h2>
            <a href="/tenant/create" class="btn btn-primary">Add Tenant</a>
        </div>

        <!-- Desktop Table View -->
        <div class="table-responsive d-none d-md-block">
            <table class="table table-bordered table-hover table-striped text-start">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Rent Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tenants as $tenant)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('tenant.show', $tenant->id) }}">{{ $tenant->name }}</a>
                            </td>
                            <td>{{ $tenant->phone }}</td>
                            <td>{{ $tenant->email }}</td>
                            <td>{{ $tenant->rent_amount ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="d-block d-md-none">
            @foreach ($tenants as $tenant)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('tenant.show', $tenant->id) }}" class="text-decoration-none">
                                {{ $tenant->name }}
                            </a>
                        </h5>
                        <p class="card-text mb-1"><strong>Phone:</strong> {{ $tenant->phone }}</p>
                        <p class="card-text mb-1"><strong>Email:</strong> {{ $tenant->email }}</p>
                        <p class="card-text mb-1"><strong>Rent Amount:</strong> {{ $tenant->rent_amount ?? 'N/A' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layout>
