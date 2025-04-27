<x-layout>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Tenant Table</h2>
            <a href="/tenant/create" class="btn btn-primary">Add Tenant</a>
        </div>

        <div class="table-responsive">
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
                            <td>{{ $loop->iteration }}</td> {{-- This shows the index --}}
                            <td><a href="#">{{ $tenant->name }}</a></td>
                            <td>{{ $tenant->phone }}</td>
                            <td>{{ $tenant->email }}</td>
                            <td>{{ $tenant->rent_amount ?? 'N/A' }}</td> {{-- Assuming rent_amount is part of your model --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-layout>
