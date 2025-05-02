<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // Eager load apartment and tenant to reduce query count
        $bookings = Booking::with(['apartment', 'tenant'])->latest()->get();

        return view('booking.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get IDs of apartments already booked (optional: filter by active bookings)
        $bookedApartmentIds = Booking::pluck('apartment_id')->toArray();
        $bookedTenantIds = Booking::pluck('tenant_id')->toArray();

        // Only fetch apartments and tenants not already booked
        $apartments = Apartment::whereNotIn('id', $bookedApartmentIds)->get();
        $tenants = Tenant::whereNotIn('id', $bookedTenantIds)->get();

        return view('booking.create', compact('apartments', 'tenants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'apartment_id'    => 'required|exists:apartments,id',
            'tenant_id'       => 'required|exists:tenants,id',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'parking_charge'  => 'nullable|integer|min:0',
            'other_charges'   => 'nullable|integer|min:0',
        ]);

        Booking::create([
            'apartment_id'    => $validatedData['apartment_id'],
            'tenant_id'       => $validatedData['tenant_id'],
            'start_date'      => $validatedData['start_date'],
            'end_date'        => $validatedData['end_date'],
            'parking_charge'  => $validatedData['parking_charge'] ?? 0,
            'other_charges'   => $validatedData['other_charges'] ?? 0,
            'payment_status'  => 'unpaid'
        ]);

        return redirect()->route('booking.index')->with('success', 'Booking created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking = Booking::with(['apartment', 'tenant'])->findOrFail($id);
        return view('booking.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $booking = Booking::with(['apartment', 'tenant'])->findOrFail($id);

        // Get all currently booked apartment and tenant IDs
        $bookedApartmentIds = Booking::where('id', '!=', $booking->id)->pluck('apartment_id')->toArray();
        $bookedTenantIds = Booking::where('id', '!=', $booking->id)->pluck('tenant_id')->toArray();

        // Fetch apartments and tenants excluding booked ones, but include current ones
        $apartments = Apartment::whereNotIn('id', $bookedApartmentIds)
            ->orWhere('id', $booking->apartment_id)
            ->get();

        $tenants = Tenant::whereNotIn('id', $bookedTenantIds)
            ->orWhere('id', $booking->tenant_id)
            ->get();

        return view('booking.edit', compact('booking', 'apartments', 'tenants'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validatedData = $request->validate([
            'apartment_id'    => 'required|exists:apartments,id',
            'tenant_id'       => 'required|exists:tenants,id',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'parking_charge'  => 'nullable|integer|min:0',
            'other_charges'   => 'nullable|integer|min:0',
        ]);

        $booking->update([
            'apartment_id'    => $validatedData['apartment_id'],
            'tenant_id'       => $validatedData['tenant_id'],
            'start_date'      => $validatedData['start_date'],
            'end_date'        => $validatedData['end_date'],
            'parking_charge'  => $validatedData['parking_charge'] ?? 0,
            'other_charges'   => $validatedData['other_charges'] ?? 0,
        ]);

        return redirect()->route('booking.show', $booking->id)->with('success', 'Booking updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
