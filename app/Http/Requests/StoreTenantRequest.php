<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTenantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'id_number' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'father_name' => 'nullable|string|max:255|required_without_all:mother_name,spouse_name',
            'mother_name' => 'nullable|string|max:255|required_without_all:father_name,spouse_name',
            'spouse_name' => 'nullable|string|max:255|required_without_all:father_name,mother_name',
            'document_type' => 'required|string|in:nid,passport',
            'tenant_file_base64' => 'required|string',
        ];
    }
}
