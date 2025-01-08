<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
            'region_id' => ['required', 'exists:regions,id'],
            'role_id' => ['required', 'exists:roles,id'],
            'full_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'profile_picture' => ['nullable', 'image', 'max:2048'], // Maksimal 2MB
        ];
    }

    /**
     * Custom messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Silakan masukkan username Anda.',
            'email.required' => 'Silakan masukkan alamat email Anda.',
            'email.email' => 'Silakan masukkan alamat email yang valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Silakan masukkan kata sandi Anda.',
            'password.min' => 'Kata sandi harus memiliki panjang minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'region_id.required' => 'Silakan pilih region Anda.',
            'region_id.exists' => 'Region yang dipilih tidak valid.',
            'role_id.required' => 'Silakan pilih role Anda.',
            'role_id.exists' => 'Role yang dipilih tidak valid.',
            'full_name.required' => 'Silakan masukkan nama lengkap Anda.',
            'phone_number.required' => 'Silakan masukkan nomor telepon Anda.',
            'address.required' => 'Silakan masukkan alamat Anda.',
            'profile_picture.image' => 'File harus berupa gambar.',
            'profile_picture.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ];
    }
}
