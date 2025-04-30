<x-layout>
    @include('apartment.validation-errors')

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="mb-4 fw-bold text-primary">Edit Apartment</h2>

                {{-- Edit Form --}}
                <form action="{{ route('apartment.update', $apartment->id) }}" method="POST" class="needs-validation"
                    id="apartment-form" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="card shadow-sm mb-5">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Apartment Information</h5>

                            <div class="row g-3">
                                {{-- Apartment Name --}}
                                <div class="col-md-6">
                                    <label for="apartmentName" class="form-label">Apartment Name</label>
                                    <input type="text" class="form-control" id="apartmentName" name="apartmentName"
                                        value="{{ old('apartmentName', $apartment->apartmentName) }}" required>
                                    <div class="invalid-feedback">
                                        Please enter the apartment name.
                                    </div>
                                </div>

                                {{-- Bedroom Number --}}
                                <div class="col-md-6">
                                    <label for="bedroomNumber" class="form-label">Bedroom Number</label>
                                    <input type="number" class="form-control" id="bedroomNumber" name="bedroomNumber"
                                        min="1" value="{{ old('bedroomNumber', $apartment->bedroomNumber) }}"
                                        required>
                                    <div class="invalid-feedback">
                                        Please enter a valid bedroom number.
                                    </div>
                                </div>

                                {{-- Price --}}
                                <div class="col-md-6">
                                    <label for="price" class="form-label">Price (Monthly)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">TK</span>
                                        <input type="number" step="0.01" class="form-control" id="price"
                                            name="price" min="0" value="{{ old('price', $apartment->price) }}"
                                            required>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter a valid price.
                                    </div>
                                </div>

                                {{-- Location --}}
                                <div class="col-md-6">
                                    <label for="location" class="form-label">Location</label>
                                    <select class="form-select" id="location" name="location" required>
                                        <option value="" disabled
                                            {{ old('location', $apartment->location) ? '' : 'selected' }}>Select
                                            Location</option>
                                        <option value="Hasan Illusion Park"
                                            {{ old('location', $apartment->location) == 'Hasan Illusion Park' ? 'selected' : '' }}>
                                            Hasan Illusion Park</option>
                                        <option value="Hazi Mohammad Monjil"
                                            {{ old('location', $apartment->location) == 'Hazi Mohammad Monjil' ? 'selected' : '' }}>
                                            Hazi Mohammad Monjil</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a location.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="col-12">
                        <button type="submit" id="updateTenantButton" class="btn btn-primary w-100">Update
                            Apartment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>

<script src="{{ asset('js/validation.js') }}"></script>

<script>
    document.getElementById('updateTenantButton').addEventListener('click', function(event) {
        event.preventDefault(); // Stop regular form submission

        const form = document.getElementById('apartment-form');

        // Trigger HTML5 validation manually
        if (form.checkValidity()) {
            // If valid, show SweetAlert confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to update this apartment?',
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
