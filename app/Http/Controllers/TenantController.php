<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Tenant;

class TenantController extends Controller
{
    public function index()
    {
        // Fetch all tenants from the database
        $tenants = Tenant::latest()->get(); // latest() will sort newest first

        // Return the view and pass the tenants data
        return view('tenant.index', compact('tenants'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'id_number' => 'required|string|max:255',
            'address' => 'required|string',
            'document_type' => 'required|string|in:nid,passport',
            'tenant_file_base64' => 'required|string',

            // Ensure either phone or email is required
            'phone' => 'required_without:email|string|max:20',
            'email' => 'required_without:phone|email|max:255',

            // Ensure that at least one of father's name, mother's name, or spouse's name is required
            'father_name' => 'nullable|string|max:255|required_without_all:mother_name,spouse_name',
            'mother_name' => 'nullable|string|max:255|required_without_all:father_name,spouse_name',
            'spouse_name' => 'nullable|string|max:255|required_without_all:father_name,mother_name',


        ]);

        // Handle file saving
        $fileData = $request->tenant_file_base64;
        $fileName = 'tenant_files/' . uniqid() . '.' . $this->getFileExtension($fileData);

        Storage::disk('public')->put($fileName, base64_decode($this->getBase64Data($fileData)));

        // Check if the file was saved successfully
        if (!Storage::disk('public')->exists($fileName)) {
            return response()->json(['error' => 'File upload failed'], 500);
        }

        // Create tenant
        $tenant = Tenant::create([
            'name' => $request->name,
            'id_number' => $request->id_number,
            'phone' => $request->phone,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'spouse_name' => $request->spouse_name,
            'email' => $request->email,
            'address' => $request->address,
            'document_type' => $request->document_type,
            'document_path' => $fileName,
        ]);

        return redirect()->route('tenant.index')->with('success', 'Tenant added successfully!');
    }


    private function getFileExtension($base64Data)
    {
        if (str_contains($base64Data, 'image/jpeg')) {
            return 'jpg';
        } elseif (str_contains($base64Data, 'image/png')) {
            return 'png';
        } elseif (str_contains($base64Data, 'application/pdf')) {
            return 'pdf';
        }

        return 'bin'; // fallback
    }

    private function getBase64Data($base64Data)
    {
        return preg_replace('/^data:.*;base64,/', '', $base64Data);
    }
}
