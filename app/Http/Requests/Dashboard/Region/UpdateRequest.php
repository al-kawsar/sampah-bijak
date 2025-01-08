<?php

namespace App\Http\Requests\Dashboard\Region;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Sesuaikan dengan kebijakan otorisasi aplikasi Anda.
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'region_name' => 'sometimes|required|string|max:100',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'region_name.required' => 'Nama wilayah harus diisi.',
            'region_name.string' => 'Nama wilayah harus berupa teks.',
            'region_name.max' => 'Nama wilayah maksimal 100 karakter.',
        ];
    }
}
