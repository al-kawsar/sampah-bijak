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
            'full_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'profile_picture' => ['file', 'image', 'max:2048'], // Maksimal 2MB
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
            'username.string' => 'Username harus berupa teks.',
            'username.max' => 'Username tidak boleh lebih dari :max karakter.',

            'email.required' => 'Silakan masukkan alamat email Anda.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Silakan masukkan alamat email yang valid.',
            'email.max' => 'Email tidak boleh lebih dari :max karakter.',
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain.',

            'password.required' => 'Silakan masukkan kata sandi Anda.',
            'password.string' => 'Kata sandi harus berupa teks.',
            'password.min' => 'Kata sandi harus memiliki panjang minimal :min karakter.',
            'password.max' => 'Kata sandi tidak boleh lebih dari :max karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok. Silakan coba lagi.',

            'region_id.required' => 'Silakan pilih region Anda.',
            'region_id.exists' => 'Region yang dipilih tidak valid. Silakan pilih dari daftar yang tersedia.',

            'full_name.required' => 'Silakan masukkan nama lengkap Anda.',
            'full_name.string' => 'Nama lengkap harus berupa teks.',
            'full_name.max' => 'Nama lengkap tidak boleh lebih dari :max karakter.',

            'phone_number.required' => 'Silakan masukkan nomor telepon Anda.',
            'phone_number.string' => 'Nomor telepon harus berupa teks.',
            'phone_number.max' => 'Nomor telepon tidak boleh lebih dari :max karakter.',

            'address.required' => 'Silakan masukkan alamat Anda.',
            'address.string' => 'Alamat harus berupa teks.',
            'address.max' => 'Alamat tidak boleh lebih dari :max karakter.',

            'profile_picture.image' => 'File harus berupa gambar (JPEG, PNG, BMP, GIF, atau SVG).',
            'profile_picture.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ];
    }
}