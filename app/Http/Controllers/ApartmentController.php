<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Services\ApartmentService;

class ApartmentController extends Controller
{
    protected $service;

    public function __construct(ApartmentService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $apartments = Apartment::latest()->get();
        return view('apartment.index', compact('apartments'));
    }

    public function create()
    {
        return view('apartment.create');
    }

    public function store(StoreApartmentRequest $request)
    {
        $success = $this->service->create($request->validated());

        return $success
            ? redirect()->route('apartment.index')->with('success', 'Apartment added successfully!')
            : back()->withInput()->with('error', 'Failed to add apartment. Please try again.');
    }

    public function show(Apartment $apartment)
    {
        return view('apartment.show', compact('apartment'));
    }

    public function edit(Apartment $apartment)
    {
        return view('apartment.edit', compact('apartment'));
    }

    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        $success = $this->service->update($apartment, $request->validated());

        return $success
            ? redirect()->route('apartment.index')->with('success', 'Apartment updated successfully!')
            : back()->withInput()->with('error', 'Failed to update apartment. Please try again.');
    }

    public function destroy(Apartment $apartment)
    {
        $success = $this->service->delete($apartment);

        return $success
            ? redirect()->route('apartment.index')->with('success', 'Apartment deleted successfully!')
            : back()->with('error', 'Failed to delete apartment.');
    }
}
