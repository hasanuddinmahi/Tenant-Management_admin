<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Str;

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
            'phone' => 'nullable|required_without:email|string|max:20',
            'email' => 'nullable|required_without:phone|email|max:255',
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
