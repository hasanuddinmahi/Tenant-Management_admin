<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Apartment;
use App\Models\Tenant;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Exception;

class BookingService
{
    /**
     * Handle displaying the list of all bookings.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleIndex()
    {
        try {
            $bookings = Booking::with(['apartment', 'tenant'])->latest()->get();
            return view('booking.index', compact('bookings'));
        } catch (Exception $e) {
            Log::error('Error fetching bookings: ' . $e->getMessage());
            return Redirect::route('booking.index')->with('error', 'Failed to load bookings.');
        }
    }

    /**
     * Handle displaying the form for creating a new booking.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleCreate()
    {
        try {
            // Get IDs of booked apartments and tenants
            $bookedApartmentIds = Booking::pluck('apartment_id')->toArray();
            $bookedTenantIds = Booking::pluck('tenant_id')->toArray();

            // Fetch apartments and tenants that are not already booked
            $apartments = Apartment::whereNotIn('id', $bookedApartmentIds)->get();
            $tenants = Tenant::whereNotIn('id', $bookedTenantIds)->get();

            return view('booking.create', compact('apartments', 'tenants'));
        } catch (Exception $e) {
            Log::error('Error fetching available apartments or tenants: ' . $e->getMessage());
            return Redirect::route('booking.index')->with('error', 'Failed to load available apartments or tenants.');
        }
    }

    /**
     * Handle storing a new booking.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function handleStore($request)
    {
        try {
            $data = $request->validate([
                'apartment_id' => 'required|exists:apartments,id',
                'tenant_id' => 'required|exists:tenants,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'parking_charge' => 'nullable|numeric',
                'other_charges' => 'nullable|numeric',
            ]);

            Booking::create($data);
            return Redirect::route('booking.index')->with('success', 'Booking created successfully!');
        } catch (Exception $e) {
            Log::error('Error creating booking: ' . $e->getMessage(), ['data' => $request->all()]);
            return Redirect::route('booking.index')->with('error', 'Failed to create booking.');
        }
    }

    /**
     * Handle displaying the specific booking details.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleShow($id)
    {
        try {
            $booking = Booking::with(['apartment', 'tenant'])->findOrFail($id);
            return view('booking.show', compact('booking'));
        } catch (Exception $e) {
            Log::error('Error fetching booking: ' . $e->getMessage());
            return Redirect::route('booking.index')->with('error', 'Booking not found.');
        }
    }

    /**
     * Handle displaying the form for editing a specific booking.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleEdit($id)
    {
        try {
            // Fetch the booking to edit
            $booking = Booking::findOrFail($id);

            // Get IDs of booked apartments and tenants, excluding the current booking's data
            $bookedApartmentIds = Booking::where('id', '!=', $id)->pluck('apartment_id')->toArray();
            $bookedTenantIds = Booking::where('id', '!=', $id)->pluck('tenant_id')->toArray();

            // Fetch apartments and tenants that are not already booked, excluding current booking's apartment and tenant
            $apartments = Apartment::whereNotIn('id', $bookedApartmentIds)->get();
            $tenants = Tenant::whereNotIn('id', $bookedTenantIds)->get();

            return view('booking.edit', compact('booking', 'apartments', 'tenants'));
        } catch (Exception $e) {
            Log::error('Error fetching booking or available apartments/tenants: ' . $e->getMessage());
            return Redirect::route('booking.index')->with('error', 'Failed to load booking or related data.');
        }
    }

    /**
     * Handle updating the specified booking.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleUpdate($request, $id)
    {
        try {
            $data = $request->validate([
                'apartment_id' => 'required|exists:apartments,id',
                'tenant_id' => 'required|exists:tenants,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'parking_charge' => 'nullable|numeric',
                'other_charges' => 'nullable|numeric',
            ]);

            $booking = Booking::findOrFail($id);
            $booking->update($data);
            return Redirect::route('booking.index')->with('success', 'Booking updated successfully!');
        } catch (Exception $e) {
            Log::error('Error updating booking: ' . $e->getMessage(), ['data' => $request->all()]);
            return Redirect::route('booking.index')->with('error', 'Failed to update booking.');
        }
    }

    /**
     * Handle deleting the specified booking.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function handleDestroy($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->delete();
            return Redirect::route('booking.index')->with('success', 'Booking deleted successfully!');
        } catch (Exception $e) {
            Log::error('Error deleting booking: ' . $e->getMessage());
            return Redirect::route('booking.index')->with('error', 'Failed to delete booking.');
        }
    }

    /**
     * Handle marking a booking as paid & unpaid.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function markAsPaid($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->payment_status = 'paid';
            $booking->save();

            return redirect()->back()->with('success', 'Booking marked as paid.');
        } catch (\Exception $e) {
            Log::error('Error marking booking as paid: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to mark booking as paid.');
        }
    }

    public function markAsUnpaid($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->payment_status = 'unpaid';
            $booking->save();

            return redirect()->back()->with('success', 'Booking marked as unpaid.');
        } catch (\Exception $e) {
            Log::error('Error marking booking as unpaid: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to mark booking as unpaid.');
        }
    }
}
