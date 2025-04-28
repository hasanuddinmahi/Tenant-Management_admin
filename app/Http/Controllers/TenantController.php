<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class TenantController extends Controller
{
    /**
     * Display a listing of tenants.
     */
    public function index()
    {
        $tenants = Tenant::latest()->get();
        return view('tenant.index', compact('tenants'));
    }

    public function create()
    {
        return view('tenant.create');
    }

    /**
     * Store a newly created tenant in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id_number' => 'required|string|max:255',
            'address' => 'required|string',
            'document_type' => 'required|string|in:nid,passport',
            'tenant_file_base64' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'father_name' => 'nullable|string|max:255|required_without_all:mother_name,spouse_name',
            'mother_name' => 'nullable|string|max:255|required_without_all:father_name,spouse_name',
            'spouse_name' => 'nullable|string|max:255|required_without_all:father_name,mother_name',
        ]);

        // Upload file to Cloudinary
        $uploadedFileUrl = $this->uploadBase64ToCloudinary($request->tenant_file_base64);

        // Save tenant with uploaded document URL
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
            'document_path' => $uploadedFileUrl,
        ]);

        return redirect()->route('tenant.index')->with('success', 'Tenant added successfully!');
    }

    public function show($id)
    {
        // Retrieve the tenant by ID or fail with a 404 error
        $tenant = Tenant::findOrFail($id);

        // Return the view with the tenant data
        return view('tenant.show', compact('tenant'));
    }

    // Show the edit form for a tenant
    public function edit($id)
    {
        $tenant = Tenant::findOrFail($id); // Find the tenant or fail
        return view('tenant.edit', compact('tenant')); // Pass the tenant to the edit view
    }

    public function update(Request $request, Tenant $tenant)
    {
        // Validate request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'id_number' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'father_name' => 'nullable|string|max:255|required_without_all:mother_name,spouse_name',
            'mother_name' => 'nullable|string|max:255|required_without_all:father_name,spouse_name',
            'spouse_name' => 'nullable|string|max:255|required_without_all:father_name,mother_name',
        ]);

        // Check if a new file is uploaded and process it
        if ($request->filled('tenant_file_base64')) {
            $validated['document_path'] = $this->uploadBase64ToCloudinary($request->tenant_file_base64);
        } else {
            $validated['document_path'] = $tenant->document_path;  // Keep the previous document path if no new file
        }

        // Check if any data has been updated
        $isUpdated = false;
        if (
            $tenant->name != $validated['name'] || $tenant->id_number != $validated['id_number'] ||
            $tenant->phone != $validated['phone'] || $tenant->father_name != $validated['father_name'] ||
            $tenant->mother_name != $validated['mother_name'] || $tenant->spouse_name != $validated['spouse_name'] ||
            $tenant->email != $validated['email'] || $tenant->address != $validated['address'] ||
            $tenant->document_path != $validated['document_path']
        ) {
            $isUpdated = true;
        }

        // Only update if there's a change
        if ($isUpdated) {
            $tenant->update([
                'name' => $validated['name'],
                'id_number' => $validated['id_number'],
                'phone' => $validated['phone'],
                'father_name' => $validated['father_name'],
                'mother_name' => $validated['mother_name'],
                'spouse_name' => $validated['spouse_name'],
                'email' => $validated['email'],
                'address' => $validated['address'],
                'document_path' => $validated['document_path'],
            ]);

            // Add success message to session if updated
            return redirect()->route('tenant.show', $tenant->id)->with('success', 'Tenant updated successfully!');
        }

        // If no changes were made, redirect back without setting a success message
        return redirect()->route('tenant.show', $tenant->id);
    }

    public function destroy($id)
    {
        $tenant = Tenant::findOrFail($id);

        // Soft delete (file stays unless you want to delete it too)
        $tenant->delete();

        return redirect()->route('tenant.index')->with('success', 'Tenant deleted successfully.');
    }


    /**
     * Uploads a base64 encoded file to Cloudinary.
     */
    private function uploadBase64ToCloudinary(string $base64Data): string
    {
        $decodedData = base64_decode($this->extractBase64Content($base64Data));

        if ($decodedData === false) {
            throw new \Exception('Invalid base64 data.');
        }

        // Save the decoded file temporarily
        $tmpFile = tempnam(sys_get_temp_dir(), 'cloudinary_');
        file_put_contents($tmpFile, $decodedData);

        try {
            $response = Cloudinary::upload($tmpFile, [
                'folder' => 'tenant-management/tenant_info',
                'resource_type' => 'auto',
                'public_id' => Str::uuid()->toString(), // unique ID for each file
            ]);
        } finally {
            @unlink($tmpFile); // Always clean up temp file
        }

        if (!$response || !$response->getSecurePath()) {
            throw new \Exception('Cloudinary upload failed.');
        }

        return $response->getSecurePath();
    }

    /**
     * Extracts only the base64 part from a full data URL.
     */
    private function extractBase64Content(string $base64String): string
    {
        if (preg_match('/^data:.*?;base64,(.*)$/', $base64String, $matches)) {
            return $matches[1];
        }

        return $base64String;
    }
}
