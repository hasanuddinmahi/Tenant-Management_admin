<?php

namespace App\Services;

use App\Models\Apartment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApartmentService
{
    public function create(array $data): bool
    {
        try {
            DB::beginTransaction();

            Apartment::create($data);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Apartment Create Error: ' . $e->getMessage());
            return false;
        }
    }

    public function update(Apartment $apartment, array $data): bool
    {
        try {
            DB::beginTransaction();

            $apartment->update($data);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Apartment Update Error: ' . $e->getMessage());
            return false;
        }
    }

    public function delete(Apartment $apartment): bool
    {
        try {
            $apartment->delete();
            return true;
        } catch (\Exception $e) {
            Log::error('Apartment Delete Error: ' . $e->getMessage());
            return false;
        }
    }
}
