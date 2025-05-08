<x-layout>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <h2 class="mb-4 fw-bold text-primary">Expense Side</h2>

                {{-- Start Form Here --}}
                <form action="#" method="POST" class="needs-validation" novalidate>
                    @csrf

                    {{-- Expense Information Section --}}
                    <div class="card shadow-sm mb-5">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Expense Information</h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="guard_salary" class="form-label">Guard Salary</label>
                                    <input type="number" class="form-control" id="guard_salary" name="guard_salary"
                                        placeholder="Enter amount for guard salary" required>
                                    <div class="invalid-feedback">
                                        Please enter guard salary.
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="electricity_bill" class="form-label">Electricity Bill</label>
                                    <input type="number" class="form-control" id="electricity_bill"
                                        name="electricity_bill" placeholder="Enter amount for electricity bill"
                                        required>
                                    <div class="invalid-feedback">
                                        Please enter electricity bill.
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="guard_salary" class="form-label">Monjil Gas & Guard Bill</label>
                                    <input type="number" class="form-control" id="monjilG&GB" name="monjilG&GB"
                                        placeholder="Enter amount for Monjil Gas & Guard Bill" required>
                                    <div class="invalid-feedback">
                                        Please enter Monjil Gas & Guard Bill.
                                    </div>
                                </div>
                            </div>

                            {{-- Additional Expense Fields --}}
                            <hr class="my-4">
                            <h5 class="card-title mb-3">Other Expenses</h5>

                            <div id="extraFieldsContainer" class="row g-3">
                                <div class="extraFieldSet row g-3 mb-2">
                                    <div class="col-md-6">
                                        <label class="form-label">Expense Description</label>
                                        <input type="text" class="form-control" name="description[]"
                                            placeholder="Enter description">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Amount</label>
                                        <input type="number" class="form-control" name="other_amount[]"
                                            placeholder="Enter amount">
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end">
                                        <button type="button" class="btn btn-success"
                                            onclick="addMoreFields()">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button Section --}}
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </div>
                </form> {{-- End Form Here --}}

            </div>
        </div>
    </div>

</x-layout>
<script src="{{ asset('js/validation.js') }}"></script>
<script>
    function addMoreFields() {
        const container = document.getElementById('extraFieldsContainer');
        const newField = document.createElement('div');
        newField.classList.add('extraFieldSet', 'row', 'g-3', 'mb-2');

        newField.innerHTML = `
                <div class="col-md-6">
                    <input type="text" class="form-control" name="description[]" placeholder="Enter description">
                </div>
                <div class="col-md-5">
                    <input type="number" class="form-control" name="other_amount[]" placeholder="Enter amount">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger" onclick="removeField(this)">−</button>
                </div>
            `;
        container.appendChild(newField);
    }

    function removeField(button) {
        button.closest('.extraFieldSet').remove();
    }
</script>
