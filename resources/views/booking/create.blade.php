<x-layout>

    @include('booking.validation-errors')

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <h2 class="mb-4 fw-bold text-primary">Create Booking</h2>

                {{-- Start Form --}}
                <form action="{{ route('booking.store') }}" method="POST" class="needs-validation" novalidate
                    onsubmit="return validateDates()">
                    @csrf

                    {{-- Booking Info Card --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Booking Information</h5>
                            <div class="row g-3">

                                {{-- Apartment Selection --}}
                                <div class="col-md-6">
                                    <label for="apartment_id" class="form-label">Apartment</label>
                                    <select name="apartment_id" id="apartment_id" class="form-select" required>
                                        <option value="" disabled selected>Select Apartment</option>
                                        @foreach ($apartments as $apartment)
                                            <option value="{{ $apartment->id }}">{{ $apartment->apartmentName }}
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
                                    <select name="tenant_id" id="tenant_id" class="form-select" >
                                        <option value="" disabled selected>Select Tenant</option>
                                        @foreach ($tenants as $tenant)
                                            <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
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
                                        required>
                                    <div class="invalid-feedback">
                                        Please select a start date.
                                    </div>
                                </div>

                                {{-- End Date --}}
                                <div class="col-md-6">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control" required>
                                    <div class="invalid-feedback">
                                        Please select an end date after the start date.
                                    </div>
                                </div>

                                {{-- Parking Charge --}}
                                <div class="col-md-6">
                                    <label for="parking_charge" class="form-label">Parking Charge</label>
                                    <input type="number" name="parking_charge" id="parking_charge" class="form-control"
                                        value="0" min="0" step="1">
                                    <div class="invalid-feedback">
                                        Please enter a valid parking charge.
                                    </div>
                                </div>

                                {{-- Other Charges --}}
                                <div class="col-md-6">
                                    <label for="other_charges" class="form-label">Other Charges</label>
                                    <input type="number" name="other_charges" id="other_charges" class="form-control"
                                        value="0" min="0" step="1">
                                    <div class="invalid-feedback">
                                        Please enter valid other charges.
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100">Create Booking</button>
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
</script>

<script src="{{ asset('js/validation.js') }}"></script>
