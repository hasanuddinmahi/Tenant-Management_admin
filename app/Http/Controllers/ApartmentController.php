<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    // Show a list of all apartments
    public function index()
    {
        $apartments = Apartment::latest()->get();
        return view('apartment.index', compact('apartments'));
    }

    // Show form to create a new apartment
    public function create()
    {
        return view('apartment.create');
    }

    // Store a new apartment
    public function store(Request $request)
    {
        $validated = $request->validate([
            'apartmentName'   => 'required|string|max:255',
            'bedroomNumber'   => 'required|integer|min:1',
            'price'           => 'required|numeric|min:0',
            'location'        => 'required|string|max:255',
        ]);

        Apartment::create($validated);

        return redirect()->route('apartment.index')->with('success', 'Apartment added successfully!');
    }

    // Show a specific apartment
    public function show($id)
    {
        $apartment = Apartment::findOrFail($id);
        return view('apartment.show', compact('apartment'));
    }
}
