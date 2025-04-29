<x-layout>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <h2 class="mb-4 fw-bold text-primary">Add Apartment</h2>

                {{-- Start Form Here --}}
                <form action="{{ route('apartment.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    {{-- Apartment Information Section --}}
                    <div class="card shadow-sm mb-5">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Apartment Information</h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="apartmentName" class="form-label">Apartment Name</label>
                                    <input type="text" class="form-control" id="apartmentName" name="apartmentName" required>
                                    <div class="invalid-feedback">
                                        Please enter the apartment name.
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="bedroomNumber" class="form-label">Bedroom Number</label>
                                    <input type="number" class="form-control" id="bedroomNumber" name="bedroomNumber" min="1" required>
                                    <div class="invalid-feedback">
                                        Please enter a valid bedroom number.
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="price" class="form-label">Price (Monthly)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">TK</span>
                                        <input type="number" class="form-control" id="price" name="price" min="0" required>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter a valid price.
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="location" class="form-label">Location</label>
                                    <select class="form-select" id="location" name="location" required>
                                        <option value="" disabled selected>Select Location</option>
                                        <option value="Hasan Illusion Park">Hasan Illusion Park</option>
                                        <option value="Hazi Mohammad Monjil">Hazi Mohammad Monjil</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a location.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button Section --}}
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100">Add Apartment</button>
                    </div>
                </form> {{-- End Form Here --}}

            </div>
        </div>
    </div>
</x-layout>
