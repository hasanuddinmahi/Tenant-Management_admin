<x-layout>
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="text-center fw-bold text-primary mb-5">Booking Details</h2>

                <h4 class="card-title mb-3">Tenant: {{ $booking->tenant->name }}</h4>

                <ul class="list-unstyled mb-4">
                    <li class="mb-2"><strong>Apartment:</strong> {{ $booking->apartment->apartmentName }}</li>
                    <li class="mb-2"><strong>Start Date:</strong> {{ $booking->start_date->format('F j, Y') }}</li>
                    <li class="mb-2"><strong>End Date:</strong> {{ $booking->end_date->format('F j, Y') }}</li>
                    <li class="mb-2"><strong>Parking Charge:</strong> Tk{{ number_format($booking->parking_charge) }}</li>
                    <li class="mb-2"><strong>Other Charges:</strong> Tk{{ number_format($booking->other_charges) }}</li>
                </ul>

                {{-- Action Buttons --}}
                <div class="d-flex flex-column flex-md-row gap-3">
                    <a href="{{ route('booking.index') }}" class="btn btn-secondary rounded-pill w-100">
                        Back
                    </a>

                    <a href="{{ route('booking.edit', $booking->id) }}" class="btn btn-outline-primary rounded-pill w-100">
                        <i class="fa-solid fa-pen me-1"></i> Edit Booking
                    </a>

                    <form id="deleteBookingForm" action="{{ route('booking.destroy', $booking->id) }}" method="POST" class="w-100">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-outline-danger w-100 rounded-pill" id="deleteBookingButton">
                            <i class="fa-solid fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<script>
    document.getElementById('deleteBookingButton').addEventListener('click', function () {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to delete this Booking!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteBookingForm').submit();
            }
        });
    });
</script>
