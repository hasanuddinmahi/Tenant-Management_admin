<x-layout>

    @include('apartment.validation-errors')

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <h2 class="mb-4 fw-bold text-primary">Edit Booking</h2>

                {{-- Start Form --}}
                <form action="{{ route('booking.update', $booking->id) }}" method="POST" class="needs-validation"
                    id="booking-form" novalidate onsubmit="return validateDates()">
                    @csrf
                    @method('PUT')

                    {{-- Booking Info Card --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Booking Information</h5>
                            <div class="row g-3">

                                {{-- Apartment Selection --}}
                                <div class="col-md-6">
                                    <label for="apartment_id" class="form-label">Apartment</label>
                                    <select name="apartment_id" id="apartment_id" class="form-select" required>
                                        <option value="" disabled>Select Apartment</option>
                                        @foreach ($apartments as $apartment)
                                            <option value="{{ $apartment->id }}"
                                                {{ $apartment->id == $booking->apartment_id ? 'selected' : '' }}>
                                                {{ $apartment->apartmentName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select an apartment.
                                    </div>
                                </div>

                                {{-- Tenant Selection --}}
                                <div class="col-md-6">
                                    <label for="tenant_id" class="form-label">Tenant</label>
                                    <select name="tenant_id" id="tenant_id" class="form-select" required>
                                        <option value="" disabled>Select Tenant</option>
                                        @foreach ($tenants as $tenant)
                                            <option value="{{ $tenant->id }}"
                                                {{ $tenant->id == $booking->tenant_id ? 'selected' : '' }}>
                                                {{ $tenant->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a tenant.
                                    </div>
                                </div>

                                {{-- Start Date --}}
                                <div class="col-md-6">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                        value="{{ $booking->start_date->format('Y-m-d') }}" required>
                                    <div class="invalid-feedback">
                                        Please select a start date.
                                    </div>
                                </div>

                                {{-- End Date --}}
                                <div class="col-md-6">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        value="{{ $booking->end_date->format('Y-m-d') }}" required>
                                    <div class="invalid-feedback">
                                        Please select an end date after the start date.
                                    </div>
                                </div>

                                {{-- Parking Charge --}}
                                <div class="col-md-6">
                                    <label for="parking_charge" class="form-label">Parking Charge</label>
                                    <input type="number" name="parking_charge" id="parking_charge" class="form-control"
                                        value="{{ $booking->parking_charge }}" min="0" step="1">
                                    <div class="invalid-feedback">
                                        Please enter a valid parking charge.
                                    </div>
                                </div>

                                {{-- Other Charges --}}
                                <div class="col-md-6">
                                    <label for="other_charges" class="form-label">Other Charges</label>
                                    <input type="number" name="other_charges" id="other_charges" class="form-control"
                                        value="{{ $booking->other_charges }}" min="0" step="1">
                                    <div class="invalid-feedback">
                                        Please enter valid other charges.
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="col-12">
                        <button id="updateBookingButton" type="submit" class="btn btn-primary w-100">Update
                            Booking</button>
                    </div>
                </form>
                {{-- End Form --}}

            </div>
        </div>
    </div>
</x-layout>

<script>
    function validateDates() {
        var startDate = document.getElementById('start_date').value;
        var endDate = document.getElementById('end_date').value;

        if (new Date(endDate) < new Date(startDate)) {
            alert('End date must be after the start date.');
            return false;
        }
        return true;
    }

    document.getElementById('updateBookingButton').addEventListener('click', function(event) {
        event.preventDefault(); // Stop regular form submission

        const form = document.getElementById('booking-form');

        // Trigger HTML5 validation manually
        if (form.checkValidity()) {
            // If valid, show SweetAlert confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to update this booking?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form if confirmed
                }
            });
        } else {
            // If not valid, add Bootstrap validation feedback class
            form.classList.add('was-validated');
        }
    });
</script>

<script src="{{ asset('js/validation.js') }}"></script>
