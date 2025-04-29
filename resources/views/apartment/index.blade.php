<x-layout>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Apartment Listing</h2>
            <a href="/tenant/create" class="btn btn-primary">Add New</a>
        </div>

        @php
            $apartments = [
                [
                    'name' => 'Green Villa',
                    'bedrooms' => 3,
                    'price' => 1200,
                    'available' => true,
                    'location' => 'Downtown',
                ],
                [
                    'name' => 'Sunset Apartments',
                    'bedrooms' => 2,
                    'price' => 950,
                    'available' => false,
                    'location' => 'Uptown',
                ],
                [
                    'name' => 'Oakwood Residency',
                    'bedrooms' => 4,
                    'price' => 1500,
                    'available' => true,
                    'location' => 'Midtown',
                ],
            ];
        @endphp

        <!-- Desktop Table View -->
        <div class="table-responsive d-none d-md-block">
            <table class="table table-bordered table-striped table-sm align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Apartment Name</th>
                        <th>Bed room</th>
                        <th>Price (Monthly)</th>
                        <th>Availability</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($apartments as $index => $apartment)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="text-wrap">{{ $apartment['name'] }}</td>
                            <td>{{ $apartment['bedrooms'] }}</td>
                            <td>${{ number_format($apartment['price']) }}</td>
                            <td>
                                <span class="badge {{ $apartment['available'] ? 'bg-success' : 'bg-danger' }}">
                                    {{ $apartment['available'] ? 'Available' : 'Unavailable' }}
                                </span>
                            </td>
                            <td class="text-wrap">{{ $apartment['location'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="d-block d-md-none">
            @foreach($apartments as $index => $apartment)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $index + 1 }}. {{ $apartment['name'] }}</h5>
                        <p class="card-text mb-1"><strong>Bedrooms:</strong> {{ $apartment['bedrooms'] }}</p>
                        <p class="card-text mb-1"><strong>Price:</strong> ${{ number_format($apartment['price']) }}</p>
                        <p class="card-text mb-1"><strong>Location:</strong> {{ $apartment['location'] }}</p>
                        <span class="badge {{ $apartment['available'] ? 'bg-success' : 'bg-danger' }}">
                            {{ $apartment['available'] ? 'Available' : 'Unavailable' }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layout>
