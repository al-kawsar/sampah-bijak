<?php

namespace App\Http\Requests\Dashboard\ContactMessage;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ganti dengan kondisi authorization sesuai kebutuhan
    }

    /**
     * Tentukan aturan validasi yang harus diterapkan pada request ini.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'subject' => 'sometimes|string|max:255',
            'message' => 'sometimes|string|min:10',
            'status' => 'sometimes|in:unread,read,replied', // Validasi status yang diizinkan
        ];
    }

    /**
     * Tentukan pesan error kustom jika diperlukan.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'subject.required' => 'Subjek harus diisi.',
            'message.required' => 'Pesan harus diisi.',
            'message.min' => 'Pesan harus memiliki setidaknya 10 karakter.',
            'status.required' => 'Status harus dipilih.',
            'status.in' => 'Status harus salah satu dari: unread, read, replied.',
        ];
    }
}
