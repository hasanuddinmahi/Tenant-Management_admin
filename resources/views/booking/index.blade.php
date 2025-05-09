<x-layout>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Booking List</h1>
            <a href="{{ route('booking.create') }}" class="btn btn-primary">Add Booking</a>
        </div>

        <!-- Desktop Table View -->
        <div class="table-responsive d-none d-md-block">
            <table class="table table-bordered table-hover table-striped text-start">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Apartment</th>
                        <th>Tenant</th>
                        <th>Rent</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td><a href="{{ route('booking.show', $booking->id) }}">{{ $loop->iteration }}</a></td>
                            <td>{{ $booking->apartment->apartmentName }}</td>
                            <td>{{ $booking->tenant->name }}</td>
                            <td>Tk {{ number_format($booking->apartment->price) }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}</td>
                            <td>
                                @if ($booking->payment_status === 'unpaid')
                                    <form action="{{ route('bookings.markPaid', $booking->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Mark as Paid</button>
                                    </form>
                                @else
                                    <form action="{{ route('bookings.markUnpaid', $booking->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning">Mark as Unpaid</button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="d-block d-md-none">
            @foreach ($bookings as $booking)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $booking->apartment->apartmentName }}</h5>
                        <p class="card-text mb-1"><strong>Tenant:</strong> {{ $booking->tenant->name }}</p>
                        <p class="card-text mb-1"><strong>Start:</strong>
                            {{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }}</p>
                        <p class="card-text mb-1"><strong>End:</strong>
                            {{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}</p>

                        {{-- <p class="card-text mb-1"><strong>Status:</strong>
                            @if ($booking->payment_status === 'unpaid')
                                <form action="{{ route('bookings.markPaid', $booking->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Mark as Paid</button>
                                </form>
                            @else
                                <span class="badge bg-success">Paid</span>
                            @endif
                        </p> --}}


                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layout>
