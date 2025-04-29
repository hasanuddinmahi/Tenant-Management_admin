<?php

namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class TenantService
{
    public function createTenant(array $validated)
    {
        DB::transaction(function () use ($validated) {
            $validated['document_path'] = $this->uploadBase64ToCloudinary($validated['tenant_file_base64']);
            unset($validated['tenant_file_base64']);

            Tenant::create($validated);
        });
    }

    public function updateTenant(Tenant $tenant, array $validated)
    {
        DB::transaction(function () use ($tenant, $validated) {
            if (!empty($validated['tenant_file_base64'])) {
                $validated['document_path'] = $this->uploadBase64ToCloudinary($validated['tenant_file_base64']);
            } else {
                $validated['document_path'] = $tenant->document_path;
            }
            unset($validated['tenant_file_base64']);

            if ($this->isDataChanged($tenant, $validated)) {
                $tenant->update($validated);
            }
        });
    }

    public function deleteTenant(Tenant $tenant)
    {
        DB::transaction(function () use ($tenant) {
            $tenant->delete();
        });
    }

    private function uploadBase64ToCloudinary(string $base64Data): string
    {
        $content = $this->extractBase64Content($base64Data);

        if (!$content) {
            throw new \Exception('Invalid base64 content.');
        }

        $tmpFile = tempnam(sys_get_temp_dir(), 'cloudinary_');
        file_put_contents($tmpFile, base64_decode($content));

        try {
            $response = Cloudinary::upload($tmpFile, [
                'folder' => 'tenant-management/tenant_info',
                'resource_type' => 'auto',
                'public_id' => (string) Str::uuid(),
            ]);

            if (!$response || !$response->getSecurePath()) {
                throw new \Exception('Cloudinary upload failed.');
            }

            return $response->getSecurePath();
        } finally {
            @unlink($tmpFile);
        }
    }

    private function extractBase64Content(string $base64String): ?string
    {
        if (preg_match('/^data:.*?;base64,(.*)$/', $base64String, $matches)) {
            return $matches[1];
        }

        return $base64String;
    }

    private function isDataChanged(Tenant $tenant, array $validated): bool
    {
        foreach ($validated as $key => $value) {
            if ($tenant->$key !== $value) {
                return true;
            }
        }
        return false;
    }
}
