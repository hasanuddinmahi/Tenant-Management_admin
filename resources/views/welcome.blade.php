<x-layout>

    <!-- Content -->
    <div class="container-fluid p-4">
        <h2>Welcome to Onboard</h2>
        <p>Fasten your seatbelt. Enjoy your flight ✈️</p>

        <div class="row mt-4">
            <div class="col-md-3 mb-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Payments</h5>
                        <h2 class="card-text">${{ number_format($totalPayments, 2) }}</h2>
                        <p class="card-text"><small>+8% from last month</small></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Expenses</h5>
                        <h2 class="card-text">${{ number_format($totalExpensesAmount, 2) }}</h2>
                        <p class="card-text"><small>+5% from last month</small></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <h5 class="card-title">Amount Left</h5>
                        <h2 class="card-text">${{ number_format($amountLeft, 2) }}</h2>
                        <p class="card-text"><small>Remaining balance</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>
