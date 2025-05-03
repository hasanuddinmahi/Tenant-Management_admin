<?php

// app/Http/Requests/StoreBookingRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function rules()
    {
        return [
            'apartment_id'    => 'required|exists:apartments,id',
            'tenant_id'       => 'required|exists:tenants,id',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'parking_charge'  => 'nullable|integer|min:0',
            'other_charges'   => 'nullable|integer|min:0',
        ];
    }

    public function authorize()
    {
        return true;
    }
}

