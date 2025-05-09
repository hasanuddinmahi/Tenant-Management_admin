<?php

namespace App\Http\Controllers;

use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $service;

    /**
     * Initialize the controller with the BookingService.
     *
     * @param BookingService $service
     */
    public function __construct(BookingService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the bookings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->service->handleIndex();
    }

    /**
     * Show the form for creating a new booking.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->service->handleCreate();
    }

    /**
     * Store a newly created booking in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->service->handleStore($request);
    }

    /**
     * Display the specified booking.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->service->handleShow($id);
    }

    /**
     * Show the form for editing the specified booking.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->service->handleEdit($id);
    }

    /**
     * Update the specified booking in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->service->handleUpdate($request, $id);
    }

    /**
     * Remove the specified booking from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->service->handleDestroy($id);
    }

    public function markAsPaid($id)
    {
        return $this->service->markAsPaid($id);
    }
    public function markAsUnpaid($id)
    {
        return $this->service->markAsUnpaid($id);
    }



}
