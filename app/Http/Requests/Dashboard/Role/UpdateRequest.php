<?php

namespace App\Http\Requests\Dashboard\Role;

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
            'name' => 'sometimes|required|string|max:255|unique:roles,name,' . $this->route('role')->id,
            'description' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama peran harus diisi.',
            'name.string' => 'Nama peran harus berupa teks.',
            'name.max' => 'Nama peran maksimal 255 karakter.',
            'name.unique' => 'Nama peran sudah terdaftar.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal 500 karakter.',
        ];
    }
}
