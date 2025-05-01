<x-layout>
    <div class="container py-4">

        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="text-center fw-bold text-primary mb-5">Apartment Details</h2>
                <h4 class="card-title mb-3">{{ $apartment->apartmentName }}</h4>

                <ul class="list-unstyled mb-4">
                    <li class="mb-2"><strong>Bedrooms:</strong> {{ $apartment->bedroomNumber }}</li>
                    <li class="mb-2"><strong>Price:</strong> Tk{{ number_format($apartment->price) }}</li>
                    <li class="mb-2"><strong>Location:</strong> {{ $apartment->location }}</li>
                </ul>

                {{-- Action Buttons --}}
                <div class="d-flex flex-column flex-md-row gap-3">
                    <a href="{{ route('apartment.index') }}" class="btn btn-secondary rounded-pill w-100">
                        <i class="fa-solid fa-users me-1"></i> Back
                    </a>

                    <a href="{{ route('apartment.edit', $apartment) }}"
                        class="btn btn-outline-primary rounded-pill w-100">
                        <i class="fa-solid fa-pen me-1"></i> Edit Apartment
                    </a>

                    <form id="deleteForm" action="{{ route('apartment.destroy', $apartment->id) }}" method="POST"
                        class="w-100">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-outline-danger w-100 rounded-pill" id="deleteButton">
                            <i class="fa-solid fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<script>
    // Delete Confirmation
    document.getElementById('deleteButton').addEventListener('click', function(e) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to delete this Apartment Listing!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm').submit();
            }
        });
    });
</script>
