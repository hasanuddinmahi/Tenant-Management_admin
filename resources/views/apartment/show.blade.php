<x-layout>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Apartment Details</h1>
            <a href="/apartment" class="btn btn-secondary">Back to List</a>
        </div>

        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">{{ $apartment->apartmentName }}</h5>
                <p class="card-text mb-1"><strong>Bedrooms:</strong> {{ $apartment->bedroomNumber }}</p>
                <p class="card-text mb-1"><strong>Price:</strong> ${{ number_format($apartment->price, 2) }}</p>
                <p class="card-text mb-1"><strong>Location:</strong> {{ $apartment->location }}</p>
                <a href="{{ route('apartment.edit', $apartment->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>

    </div>
</x-layout>
