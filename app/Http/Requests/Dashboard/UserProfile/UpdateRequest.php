<?php

namespace App\Http\Requests\Dashboard\UserProfile;

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
            'full_name' => 'sometimes|required|string|max:255',
            'phone_number' => 'sometimes|required|string|max:15',
            'profile_picture' => 'nullable|image|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'Nama lengkap harus diisi.',
            'full_name.string' => 'Nama lengkap harus berupa teks.',
            'full_name.max' => 'Nama lengkap maksimal 255 karakter.',
            'phone_number.required' => 'Nomor telepon harus diisi.',
            'phone_number.string' => 'Nomor telepon harus berupa teks.',
            'phone_number.max' => 'Nomor telepon maksimal 15 karakter.',
            'profile_picture.image' => 'File gambar tidak valid.',
            'profile_picture.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
