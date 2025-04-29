<?php

namespace App\Http\Controllers;

// use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index()
    {
        return view('apartment.index', );
    }
    // Show form to create a new apartment
    public function create()
    {
        return view('apartment.create');
    }


}
