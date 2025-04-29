<x-layout>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Apartment List</h1>
            <a href="/apartment/create" class="btn btn-primary">Add Apartment</a>
        </div>

        <!-- Desktop Table View -->
        <div class="table-responsive d-none d-md-block">
            <table class="table table-bordered table-hover table-striped text-start">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Apartment Name</th>
                        <th>Bedroom Number</th>
                        <th>Price</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apartments as $apartment)
                        <tr>
                            <td><a href="{{ route('apartment.show', $apartment->id) }}" class="text-decoration-none text-dark">{{ $loop->iteration }}</a></td>
                            <td><a href="{{ route('apartment.show', $apartment->id) }}" class="text-decoration-none text-dark">{{ $apartment->apartmentName }}</a></td>
                            <td><a href="{{ route('apartment.show', $apartment->id) }}" class="text-decoration-none text-dark">{{ $apartment->bedroomNumber }}</a></td>
                            <td><a href="{{ route('apartment.show', $apartment->id) }}" class="text-decoration-none text-dark">${{ number_format($apartment->price, 2) }}</a></td>
                            <td><a href="{{ route('apartment.show', $apartment->id) }}" class="text-decoration-none text-dark">{{ $apartment->location }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="d-block d-md-none">
            @foreach ($apartments as $apartment)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <a href="{{ route('apartment.show', $apartment->id) }}" class="text-decoration-none text-dark">
                        <h5 class="card-title">{{ $apartment->apartmentName }}</h5>
                        <p class="card-text mb-1"><strong>Bedrooms:</strong> {{ $apartment->bedroomNumber }}</p>
                        <p class="card-text mb-1"><strong>Price:</strong> ${{ number_format($apartment->price, 2) }}</p>
                        <p class="card-text mb-1"><strong>Location:</strong> {{ $apartment->location }}</p>
                    </a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</x-layout>
