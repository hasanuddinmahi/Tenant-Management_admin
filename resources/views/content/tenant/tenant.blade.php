<x-layout>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h2>Tenant Table</h2>
          <a href="/tenant/create" class="btn btn-primary">Add Tenant</a>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered table-hover table-striped text-start">
            <thead class="table-dark">
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Rent Amount</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td><a href="#">John Doe</a></td>
                <td>+1 234 567 8900</td>
                <td>john@example.com</td>
                <td>12,000</td>
              </tr>
              <tr>
                <td>2</td>
                <td><a href="#">Jane Smith</a></td>
                <td>+1 987 654 3210</td>
                <td>jane@example.com</td>
                <td>50,000</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>


</x-layout>
