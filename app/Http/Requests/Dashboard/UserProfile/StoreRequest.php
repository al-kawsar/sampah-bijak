<?php

namespace App\Http\Requests\Dashboard\UserProfile;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'user_id' => 'required|uuid|exists:users,id',
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'profile_picture' => 'nullable|image|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'ID pengguna harus diisi.',
            'user_id.uuid' => 'ID pengguna tidak valid.',
            'user_id.exists' => 'ID pengguna tidak ditemukan.',
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
