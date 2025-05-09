<x-layout>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>User Table</h2>
            <a href="/user/create" class="btn btn-primary">Add User</a>
        </div>

        <!-- Desktop Table View -->
        <div class="table-responsive d-none d-md-block">
            <table class="table table-bordered table-hover table-striped text-start">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                        <tr>
                            <td></td>
                            <td>
                                <a href=""></a>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="d-block d-md-none">

                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="" class="text-decoration-none">

                            </a>
                        </h5>
                        <p class="card-text mb-1"><strong>Email:</strong> </p>
                        <p class="card-text mb-1"><strong>Role:</strong> </p>
                        <p class="card-text mb-1"><strong>Status:</strong> </p>
                    </div>
                </div>

        </div>
    </div>
</x-layout>
